@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nuevo producto</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Registra un producto en el catálogo.</p>
    </div>

    @include('admin.partials.flash')

    <div class="max-w-3xl rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <form action="{{ route('admin.productos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sku" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        SKU <span class="text-brand-primary">*</span>
                    </label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('sku') border-brand-primary @enderror">
                    @error('sku')
                        <p class="mt-1 text-[13px] text-brand-primary">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="barcode" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Código de barras
                    </label>
                    <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('barcode') border-brand-primary @enderror">
                    @error('barcode')
                        <p class="mt-1 text-[13px] text-brand-primary">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Nombre <span class="text-brand-primary">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('name') border-brand-primary @enderror">
                @error('name')
                    <p class="mt-1 text-[13px] text-brand-primary">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="category_id" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Categoría <span class="text-brand-primary">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('category_id') border-brand-primary @enderror">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-[13px] text-brand-primary">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="unit_of_measure" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Unidad de medida <span class="text-brand-primary">*</span>
                    </label>
                    <input type="text" name="unit_of_measure" id="unit_of_measure" value="{{ old('unit_of_measure') }}" required placeholder="Unidades, Kilogramos, etc."
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('unit_of_measure') border-brand-primary @enderror">
                    @error('unit_of_measure')
                        <p class="mt-1 text-[13px] text-brand-primary">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Descripción</label>
                <textarea name="description" id="description" rows="4"
                    class="min-h-[120px] w-full resize-y rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))
                    class="h-4 w-4 rounded-sm border-[#e3e3e0] text-brand-primary focus:ring-brand-primary">
                <label for="is_active" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Producto activo</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                    Guardar
                </button>
                <a href="{{ route('admin.productos.index') }}"
                    class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
