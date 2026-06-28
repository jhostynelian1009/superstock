<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with('category')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::query()->create($request->validated());

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $producto): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $producto,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $producto): RedirectResponse
    {
        $producto->update($request->validated());

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto): RedirectResponse
    {
        if ($producto->inventory()->exists() || $producto->inventoryMovements()->exists()) {
            return redirect()
                ->route('admin.productos.index')
                ->with('error', 'No se puede eliminar el producto porque tiene inventario asociado o movimientos registrados.');
        }

        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
