@extends('layouts.admin')

@section('title', 'Pedidos')
@section('breadcrumb', 'Pedidos')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Pedidos</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Todos los pedidos realizados por los clientes.</p>
    </div>

    @include('admin.partials.flash')

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Pedido</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Productos</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Entrega</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $order->customer_name }}</div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $order->customer_email }}</div>
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $order->items->pluck('product_name')->take(2)->join(', ') }}
                                @if($order->items->count() > 2)
                                    <span class="text-xs">+{{ $order->items->count() - 2 }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-[#F8B803]">${{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-3">{{ $order->deliveryLabel() }}</td>
                            <td class="px-4 py-3">{{ $order->statusLabel() }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.pedidos.show', $order) }}"
                                   class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay pedidos registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-4 py-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
