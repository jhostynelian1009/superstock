<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryMovementRequest;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryMovementController extends Controller
{
    public function index(Request $request): View
    {
        $query = InventoryMovement::query()
            ->with(['product', 'user', 'supplier'])
            ->latest('occurred_at');

        // Filtro por producto
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filtro por tipo de movimiento
        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtro por fecha
        if ($request->filled('date_from')) {
            $query->whereDate('occurred_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('occurred_at', '<=', $request->date_to);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('reference', 'like', "%{$search}%")
              ->orWhere('reason', 'like', "%{$search}%");
        }

        $movements = $query->paginate(15);
        $products = Product::orderBy('name')->get();

        return view('admin.inventory-movements.index', compact('movements', 'products'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.inventory-movements.create', compact('products', 'suppliers'));
    }

    public function store(StoreInventoryMovementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Obtener el inventario del producto
        $inventory = Inventory::where('product_id', $validated['product_id'])->firstOrFail();

        // Validar salida
        if ($validated['movement_type'] === InventoryMovement::TYPE_OUTPUT) {
            if ($validated['quantity'] > $inventory->current_stock) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No hay suficiente stock. Stock disponible: '.$inventory->current_stock);
            }
        }

        // Crear el movimiento
        $movement = InventoryMovement::create($validated);

        // Actualizar stock
        $this->updateInventoryStock($inventory, $validated['movement_type'], $validated['quantity']);

        return redirect()
            ->route('admin.movimientos.show', $movement)
            ->with('success', 'Movimiento registrado correctamente.');
    }

    public function show(InventoryMovement $movimiento): View
    {
        $movimiento->load(['product', 'user', 'supplier']);

        return view('admin.inventory-movements.show', compact('movimiento'));
    }

    /**
     * Actualiza el stock en la tabla Inventory.
     */
    private function updateInventoryStock(Inventory $inventory, string $type, mixed $quantity): void
    {
        if ($type === InventoryMovement::TYPE_INPUT) {
            $inventory->increment('current_stock', (float) $quantity);
        } elseif ($type === InventoryMovement::TYPE_OUTPUT) {
            $inventory->decrement('current_stock', (float) $quantity);
        }
    }
}
