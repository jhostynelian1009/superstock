@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Productos</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Gestiona el inventario del catálogo.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            {{-- Buscador --}}
            <form action="{{ route('admin.productos.index') }}" method="GET" class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Buscar por nombre, SKU o código..." 
                       class="w-64 rounded-sm border border-[#e3e3e0] bg-white px-3 py-1.5 pr-8 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                @if(request('search'))
                    <a href="{{ route('admin.productos.index') }}" class="absolute right-8 top-1/2 -translate-y-1/2 text-[#706f6c] hover:text-[#F53003]" aria-label="Limpiar búsqueda">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
                <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[#706f6c] hover:text-[#F53003]" aria-label="Buscar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z"/>
                    </svg>
                </button>
            </form>

            <a href="{{ route('admin.productos.create') }}"
                class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
                Nuevo producto
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Código</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Unidad de medida</th>
                        <th class="px-4 py-3">Fecha de creación</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $actionData = [
                                'SKU' => $product->sku,
                                'Código' => $product->barcode ?? '—',
                                'Nombre' => $product->name,
                                'Categoría' => $product->category?->name ?? '—',
                                'Unidad de medida' => $product->unit_of_measure,
                            ];
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $product->barcode ?? '—' }}</td>
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $product->unit_of_measure }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $product->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3">
                                    <button type="button"
                                        data-sc-action-open="edit"
                                        data-sc-action-url="{{ route('admin.productos.edit', $product) }}"
                                        data-sc-action-title="Editar producto"
                                        data-sc-action-data='@json($actionData)'
                                        class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                        Editar
                                    </button>
                                    <button type="button"
                                        data-sc-action-open="delete"
                                        data-sc-action-url="{{ route('admin.productos.destroy', $product) }}"
                                        data-sc-action-title="Eliminar producto"
                                        data-sc-action-data='@json($actionData)'
                                        class="text-sm font-medium text-[#F53003] underline-offset-4 hover:underline">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No se encontraron productos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
@endsection
