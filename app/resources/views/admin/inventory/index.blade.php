@extends('layouts.admin')

@section('title', 'Inventario')
@section('breadcrumb', 'Inventario')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Inventario</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Consulta de existencias y estado de stock.</p>
        </div>
    </div>

    @include('admin.partials.flash')

    {{-- Buscador --}}
    <form method="GET" action="{{ route('admin.inventario.index') }}" class="mb-4">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Buscar por producto, SKU o categoría…"
                class="w-full max-w-sm rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] outline-none transition focus:border-[#F53003] focus:ring-1 focus:ring-[#F53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
                aria-label="Buscar en inventario"
            >
            <button type="submit"
                class="inline-flex items-center justify-center rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1b1b18]">
                Buscar
            </button>
            @if($search)
                <a href="{{ route('admin.inventario.index') }}"
                    class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-4 py-2 text-sm font-medium text-[#706f6c] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                    Limpiar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3 text-right">Stock Actual</th>
                        <th class="px-4 py-3 text-right">Stock Mínimo</th>
                        <th class="px-4 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventories as $inventory)
                        @php
                            // Calcular estado según spec/modulos/inventario.md §5
                            if ($inventory->current_stock <= 0) {
                                $statusKey   = 'agotado';
                                $statusLabel = 'Agotado';
                            } elseif ($inventory->current_stock <= $inventory->minimum_stock) {
                                $statusKey   = 'stock-bajo';
                                $statusLabel = 'Stock Bajo';
                            } else {
                                $statusKey   = 'disponible';
                                $statusLabel = 'Disponible';
                            }
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $inventory->product->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 font-mono text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $inventory->product->sku ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $inventory->product->category->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ number_format($inventory->current_stock, 3) }}
                            </td>
                            <td class="px-4 py-3 text-right text-[#706f6c] dark:text-[#A1A09A]">
                                {{ number_format($inventory->minimum_stock, 3) }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($statusKey === 'disponible')
                                    <span class="badge badge--activo">
                                        <span class="badge-dot"></span>{{ $statusLabel }}
                                    </span>
                                @elseif ($statusKey === 'stock-bajo')
                                    <span class="badge badge--pendiente">
                                        <span class="badge-dot"></span>{{ $statusLabel }}
                                    </span>
                                @else
                                    <span class="badge badge--cancelado">
                                        <span class="badge-dot"></span>{{ $statusLabel }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-[#706f6c] dark:text-[#A1A09A]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 opacity-40">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    @if($search)
                                        <p class="font-medium">Sin resultados para "{{ $search }}"</p>
                                        <p class="text-sm">Intenta con otro término de búsqueda.</p>
                                    @else
                                        <p class="font-medium">No hay registros de inventario</p>
                                        <p class="text-sm">Los productos activos con inventario aparecerán aquí.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($inventories->hasPages())
        <div class="mt-6">
            {{ $inventories->links() }}
        </div>
    @endif
@endsection
