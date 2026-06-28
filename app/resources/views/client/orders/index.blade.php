@extends('layouts.client')

@section('title', 'Mis pedidos — SnackConnect')
@section('page_title', 'Mis pedidos')
@section('page_subtitle', 'Historial de compras realizadas')

@section('client_content')
<div class="sc-card overflow-hidden">
    @if($orders->isEmpty())
        <div class="p-8 text-center">
            <p class="text-sm text-text-secondary mb-4">No tienes pedidos registrados todavía.</p>
            <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-primary">Ir al catálogo</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm min-w-[700px]">
                <thead class="bg-bg-muted text-xs font-medium uppercase tracking-wide text-text-secondary">
                    <tr>
                        <th class="px-5 py-3">Nº Pedido</th>
                        <th class="px-5 py-3">Productos</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Entrega</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3">Fecha</th>
                        <th class="px-5 py-3 text-right">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t border-border-default hover:bg-bg-muted/50">
                            <td class="px-5 py-3 font-medium">{{ $order->order_number }}</td>
                            <td class="px-5 py-3 text-text-secondary">
                                {{ $order->items->pluck('product_name')->take(2)->join(', ') }}
                                @if($order->items->count() > 2)
                                    <span class="text-xs">+{{ $order->items->count() - 2 }} más</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium">${{ number_format($order->total, 2) }}</td>
                            <td class="px-5 py-3">{{ $order->deliveryLabel() }}</td>
                            <td class="px-5 py-3">{{ $order->statusLabel() }}</td>
                            <td class="px-5 py-3 text-text-secondary">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('client.pedidos.show', $order) }}" class="text-sm font-medium hover:underline">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-5 py-4 border-t border-border-default">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
