<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $this->prepareProductData($request->validated());

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Product::query()->create($data);

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
        $data = $this->prepareProductData($request->validated());

        if ($request->hasFile('image')) {
            $this->deleteImage($producto->image);
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $producto->update($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto): RedirectResponse
    {
        $this->deleteImage($producto->image);
        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function prepareProductData(array $data): array
    {
        if (filled($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            unset($data['slug']);
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        unset($data['image']);

        return $data;
    }

    private function storeImage(UploadedFile $file): string
    {
        $filename = time().'_'.$file->getClientOriginalName();

        return $file->storeAs('products', $filename, 'public');
    }

    private function deleteImage(?string $path): void
    {
        if (filled($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
