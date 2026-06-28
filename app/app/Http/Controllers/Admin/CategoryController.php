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
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (filled($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            unset($data['slug']);
        }

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

        if (filled($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            unset($data['slug']);
        }

        $categoria->update($data);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
