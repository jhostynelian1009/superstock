@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Productos</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Gestiona el inventario del catálogo.</p>
        </div>
        <a href="{{ route('admin.productos.create') }}"
            class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
            Nuevo producto
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $actionData = [
                                'Producto' => $product->name,
                                'Categoría' => $product->category?->name ?? '—',
                                'Precio' => '$'.number_format($product->price, 2),
                                'Estado' => $product->is_active ? 'Activo' : 'Inactivo',
                            ];
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                                            class="h-10 w-10 rounded-sm object-cover">
                                    @else
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-sm bg-[#fff2f2] text-xs text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                                            N/A
                                        </div>
                                    @endif
                                    <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $product->category?->name }}</td>
                            <td class="px-4 py-3 font-medium text-[#F8B803]">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3">
                                @if ($product->is_active)
                                    <span
                                        class="inline-flex rounded-full bg-[#F3BEC7] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#1D0002] dark:text-[#EDEDEC]">Activo</span>
                                @else
                                    <span
                                        class="inline-flex rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium text-[#706f6c] dark:border-[#3E3E3A] dark:text-[#A1A09A]">Inactivo</span>
                                @endif
                            </td>
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
                            <td colspan="6" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay productos registrados.
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
