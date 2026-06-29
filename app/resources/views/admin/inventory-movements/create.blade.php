@extends('layouts.admin')

@section('title', 'Nuevo movimiento')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nuevo movimiento</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Registra un movimiento de inventario.</p>
    </div>

    @include('admin.partials.flash')

    <div class="max-w-2xl rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <form action="{{ route('admin.movimientos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="product_id" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Producto <span class="text-[#F53003]">*</span>
                </label>
                <select name="product_id" id="product_id" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('product_id') border-[#F53003] @enderror">
                    <option value="">Selecciona un producto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="movement_type" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Tipo de movimiento <span class="text-[#F53003]">*</span>
                </label>
                <select name="movement_type" id="movement_type" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('movement_type') border-[#F53003] @enderror">
                    <option value="">Selecciona un tipo</option>
                    <option value="Entrada" @selected(old('movement_type') === 'Entrada')>Entrada</option>
                    <option value="Salida" @selected(old('movement_type') === 'Salida')>Salida</option>
                </select>
                @error('movement_type')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantity" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Cantidad <span class="text-[#F53003]">*</span>
                </label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" step="0.001" min="0.001" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('quantity') border-[#F53003] @enderror">
                @error('quantity')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="supplier_id" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Proveedor (opcional)</label>
                <select name="supplier_id" id="supplier_id"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('supplier_id') border-[#F53003] @enderror">
                    <option value="">Sin proveedor</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reason" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Motivo <span class="text-[#F53003]">*</span>
                </label>
                <textarea name="reason" id="reason" rows="3" required
                    class="min-h-[100px] w-full resize-y rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('reason') border-[#F53003] @enderror">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reference" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Referencia (opcional)</label>
                <input type="text" name="reference" id="reference" value="{{ old('reference') }}" maxlength="100"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('reference') border-[#F53003] @enderror"
                    placeholder="Ej: ORD-001, FAC-2026-001">
                @error('reference')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                    Guardar movimiento
                </button>
                <a href="{{ route('admin.movimientos.index') }}"
                    class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
