<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        
        $query = Category::query()
            ->withCount('products');

        if (filled($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::query()->create($data);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $categoria): View
    {
        return view('admin.categories.edit', ['category' => $categoria]);
    }

    public function update(UpdateCategoryRequest $request, Category $categoria): RedirectResponse
    {
        $data = $request->validated();

        $categoria->update($data);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $categoria): RedirectResponse
    {
        if ($categoria->products()->exists()) {
            return redirect()
                ->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar la categoría "' . $categoria->name . '" porque tiene productos asociados.');
        }

        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
