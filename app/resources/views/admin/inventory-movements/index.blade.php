@extends('layouts.admin')

@section('title', 'Movimientos de Inventario')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Movimientos de Inventario</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Historial de entradas y salidas.</p>
        </div>
        <a href="{{ route('admin.movimientos.create') }}"
            class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
            Nuevo movimiento
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="mb-6 space-y-4 rounded-lg border border-[#e3e3e0] bg-white p-4 dark:border-[#3E3E3A] dark:bg-[#161615]">
        <form method="GET" action="{{ route('admin.movimientos.index') }}" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="search" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Producto, referencia..."
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                </div>

                <div>
                    <label for="product_id" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Producto</label>
                    <select name="product_id" id="product_id"
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                        <option value="">Todos</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="movement_type" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Tipo</label>
                    <select name="movement_type" id="movement_type"
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                        <option value="">Todos</option>
                        <option value="Entrada" @selected(request('movement_type') === 'Entrada')>Entrada</option>
                        <option value="Salida" @selected(request('movement_type') === 'Salida')>Salida</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="w-full rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A]">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.movimientos.index') }}"
                        class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-3 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Cantidad</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Motivo</th>
                        <th class="px-4 py-3">Referencia</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $movement->occurred_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $movement->product?->name }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($movement->movement_type === 'Entrada')
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Entrada
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Salida
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ number_format($movement->quantity, 3) }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $movement->user?->name }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $movement->supplier?->business_name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $movement->reason }}
                            </td>
                            <td class="px-4 py-3 text-xs font-mono text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $movement->reference ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.movimientos.show', $movement) }}"
                                        class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                        Ver
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay movimientos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $movements->links() }}
    </div>
@endsection
