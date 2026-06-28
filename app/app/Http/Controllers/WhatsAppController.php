<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WhatsAppController extends Controller
{
    /**
     * Resuelve un producto activo desde la base de datos.
     */
    private function resolveProduct(int $id): ?array
    {
        $product = Product::query()->find($id);

        if (! $product || ! $product->is_active) {
            return null;
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'image' => $product->image,
            'description' => $product->description,
        ];
    }

    /**
     * Lista de productos activos para el carrito.
     */
    private function availableProducts(): array
    {
        return Product::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn (Product $product) => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'image' => $product->image,
                    'description' => $product->description,
                ],
            ])->all();
    }

    private function whatsappPhone(): string
    {
        return config('services.whatsapp.phone', '593998128034');
    }

    /**
     * Show the temporary cart page with items and products catalog.
     */
    public function showCart()
    {
        $cart = Session::get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', [
            'cart' => $cart,
            'products' => $this->availableProducts(),
            'total' => $total,
            'whatsappPhone' => $this->whatsappPhone(),
        ]);
    }

    /**
     * Add a product to the session cart.
     */
    public function addToCart(Request $request, $id)
    {
        $id = (int) $id;
        $product = $this->resolveProduct($id);

        if (! $product) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado.',
                ], 404);
            }

            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        if ($request->boolean('whatsapp_redirect')) {
            return redirect()->route('cart.show')
                ->with('success', "{$product['name']} agregado. Completa tu pedido por WhatsApp.");
        }

        $toastMessage = "«{$product['name']}» se añadió al carrito.";
        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $toastMessage,
                'cart_count' => $cartCount,
                'product' => $product['name'],
            ]);
        }

        return redirect()
            ->back()
            ->with('cart_toast', [
                'type' => 'success',
                'message' => $toastMessage,
                'product' => $product['name'],
            ]);
    }

    /**
     * Remove or decrease a product from the session cart.
     */
    public function removeFromCart(Request $request, $id)
    {
        $id = (int) $id;
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                $message = "Cantidad de {$cart[$id]['name']} reducida.";
            } else {
                $message = "{$cart[$id]['name']} eliminado del carrito.";
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        } else {
            return redirect()->route('cart.show')->with('error', 'El producto no está en el carrito.');
        }

        return redirect()->route('cart.show')->with('success', $message);
    }

    /**
     * Clear all products from the session cart.
     */
    public function clearCart()
    {
        Session::forget('cart');

        return redirect()->route('cart.show')->with('success', 'Carrito vaciado exitosamente.');
    }

    /**
     * Format cart contents and redirect to WhatsApp API.
     */
    public function checkoutWhatsApp(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'delivery_type' => 'required|in:llevar,local',
            'address_neighborhood' => 'required_if:delivery_type,llevar|nullable|string|max:100',
            'address_main_street' => 'required_if:delivery_type,llevar|nullable|string|max:150',
            'address_secondary_street' => 'required_if:delivery_type,llevar|nullable|string|max:150',
            'address_reference' => 'required_if:delivery_type,llevar|nullable|string|max:150',
        ], [
            'delivery_type.required' => 'Debe seleccionar el tipo de entrega.',
            'address_neighborhood.required_if' => 'Indique el barrio de entrega.',
            'address_main_street.required_if' => 'Indique la calle principal.',
            'address_secondary_street.required_if' => 'Indique la calle secundaria.',
            'address_reference.required_if' => 'Indique una referencia o número de casa.',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'El carrito está vacío. Agregue algunos snacks antes de comprar.');
        }

        $subtotal = 0;
        $itemsText = '';

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            $itemsText .= "- {$item['quantity']}x {$item['name']} ($".number_format($item['price'], 2)." c/u)\n";
        }

        $deliveryLabel = $request->delivery_type === 'llevar' ? 'Para Llevar / Delivery' : 'Consumo Local';

        $order = DB::transaction(function () use ($user, $request, $cart, $subtotal) {
            $order = Order::query()->create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'delivery_type' => $request->delivery_type,
                'address_neighborhood' => $request->address_neighborhood,
                'address_main_street' => $request->address_main_street,
                'address_secondary_street' => $request->address_secondary_street,
                'address_reference' => $request->address_reference,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'status' => 'sent',
                'whatsapp_sent_at' => now(),
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => (int) $productId,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            return $order;
        });

        $user->update([
            'default_delivery_type' => $request->delivery_type,
            'address_neighborhood' => $request->delivery_type === 'llevar' ? $request->address_neighborhood : null,
            'address_main_street' => $request->delivery_type === 'llevar' ? $request->address_main_street : null,
            'address_secondary_street' => $request->delivery_type === 'llevar' ? $request->address_secondary_street : null,
            'address_reference' => $request->delivery_type === 'llevar' ? $request->address_reference : null,
        ]);

        $message = "*¡Hola! Me gustaría hacer el siguiente pedido en SnackConnect:*\n";
        $message .= '*Pedido:* '.$order->order_number."\n";
        $message .= "---------------------------------\n";
        $message .= $itemsText;
        $message .= "---------------------------------\n";
        $message .= '*Total:* $'.number_format($subtotal, 2)."\n";
        $message .= '*Cliente:* '.$user->name."\n";
        $message .= '*Correo:* '.$user->email."\n";
        $message .= '*Teléfono:* '.($user->phone ?? '—')."\n";
        $message .= '*Cédula/ID:* '.($user->document_number ?? '—')."\n";
        $message .= '*Entrega:* '.$deliveryLabel."\n";

        if ($request->delivery_type === 'llevar') {
            $message .= "\n*Dirección de entrega:*\n";
            $message .= '- Barrio: '.trim($request->address_neighborhood)."\n";
            $message .= '- Calle principal: '.trim($request->address_main_street)."\n";
            $message .= '- Calle secundaria: '.trim($request->address_secondary_street)."\n";
            $message .= '- Referencia: '.trim($request->address_reference)."\n";
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $this->whatsappPhone());
        Session::forget('cart');
        $whatsappUrl = 'https://api.whatsapp.com/send?phone='.$cleanPhone.'&text='.urlencode($message);

        return redirect()
            ->route('checkout.success')
            ->with('whatsapp_redirect_url', $whatsappUrl)
            ->with('order_number', $order->order_number);
    }

    /**
     * Página de confirmación: muestra éxito y redirige a WhatsApp.
     */
    public function orderSuccess()
    {
        $whatsappUrl = session('whatsapp_redirect_url');

        if (! $whatsappUrl) {
            return redirect()->route('cart.show');
        }

        return view('checkout.success', [
            'whatsappUrl' => $whatsappUrl,
            'orderNumber' => session('order_number'),
        ]);
    }
}
