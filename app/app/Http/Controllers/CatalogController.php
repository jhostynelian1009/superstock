<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Landing Page pública (GET /)
     */
    public function landing()
    {
        $categories = Category::query()->orderBy('name')->get();
        $featuredProducts = Product::query()
            ->with('category')
            ->active()
            ->latest()
            ->take(8)
            ->get();

        return view('landing', compact('categories', 'featuredProducts'));
    }

    /**
     * Catálogo con búsqueda y filtros (GET /catalogo)
     */
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();

        $query = Product::query()
            ->with('category')
            ->orderBy('name');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->input('category')));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $request->input('category'),
            'searchTerm' => $request->input('search'),
            'openProductSlug' => $request->input('product'),
        ]);
    }

    /**
     * Detalle de producto — abre panel en catálogo sin recargar página completa.
     */
    public function show(string $slug)
    {
        $exists = Product::query()->where('slug', $slug)->exists();

        if (! $exists) {
            abort(404);
        }

        return redirect()->route('catalogo.index', array_filter([
            'product' => $slug,
            'category' => request('category'),
            'search' => request('search'),
        ]));
    }
}
