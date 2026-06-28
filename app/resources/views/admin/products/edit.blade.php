@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Editar producto</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Actualiza {{ $product->name }}.</p>
    </div>

    @include('admin.partials.flash')

    <div class="max-w-3xl rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <form action="{{ route('admin.productos.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Nombre <span class="text-[#F53003]">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('name') border-[#F53003] @enderror">
                @error('name')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Categoría <span class="text-[#F53003]">*</span>
                </label>
                <select name="category_id" id="category_id" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('category_id') border-[#F53003] @enderror">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Precio <span class="text-[#F53003]">*</span>
                    </label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0.01" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('price') border-[#F53003] @enderror">
                    @error('price')
                        <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="stock" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Stock <span class="text-[#F53003]">*</span>
                    </label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('stock') border-[#F53003] @enderror">
                    @error('stock')
                        <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Descripción</label>
                <textarea name="description" id="description" rows="4"
                    class="min-h-[120px] w-full resize-y rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">{{ old('description', $product->description) }}</textarea>
            </div>

            @if ($product->image)
                <div>
                    <p class="mb-2 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Imagen actual</p>
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                        class="h-24 w-24 rounded-sm object-cover">
                </div>
            @endif

            <div>
                <label for="image" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Nueva imagen</label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-sm border border-dashed border-[#e3e3e0] bg-[#fff2f2] px-4 py-6 text-sm file:mr-4 file:rounded-sm file:border-0 file:bg-[#1b1b18] file:px-4 file:py-2 file:text-sm file:font-medium file:text-white dark:border-[#3E3E3A] dark:bg-[#1D0002] dark:file:bg-[#EDEDEC] dark:file:text-[#1C1C1A] @error('image') border-[#F53003] @enderror">
                <p class="mt-1 text-[13px] text-[#706f6c] dark:text-[#A1A09A]">JPEG, PNG o WEBP — máx. 2MB.</p>
                @error('image')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $product->is_active))
                    class="h-4 w-4 rounded-sm border-[#e3e3e0] text-[#F53003] focus:ring-[#F53003]">
                <label for="is_active" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Producto activo</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                    Actualizar
                </button>
                <a href="{{ route('admin.productos.index') }}"
                    class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
