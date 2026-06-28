@extends('layouts.client')

@section('title', 'Pedido ' . $order->order_number . ' — SnackConnect')
@section('page_title', 'Pedido ' . $order->order_number)
@section('page_subtitle', 'Realizado el ' . $order->created_at->format('d/m/Y \a \l\a\s H:i'))

@section('client_content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 sc-card p-6">
        <h2 class="text-lg font-semibold text-text-primary mb-4">Productos</h2>
        <div class="divide-y divide-border-default">
            @foreach($order->items as $item)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div>
                        <p class="font-medium text-text-primary">{{ $item->product_name }}</p>
                        <p class="text-sm text-text-secondary">
                            {{ $item->quantity }} × ${{ number_format($item->product_price, 2) }}
                        </p>
                    </div>
                    <p class="font-semibold">${{ number_format($item->line_total, 2) }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-border-default flex justify-between items-baseline">
            <span class="font-semibold">Total</span>
            <span class="text-xl font-bold text-brand-primary">${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <div class="sc-card p-6 space-y-4">
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Estado</p>
            <p class="text-sm font-medium mt-1">{{ $order->statusLabel() }}</p>
        </div>
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Tipo de entrega</p>
            <p class="text-sm font-medium mt-1">{{ $order->deliveryLabel() }}</p>
        </div>
        @if($order->delivery_type === 'llevar')
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Dirección</p>
                <p class="text-sm mt-1 text-text-primary">
                    {{ $order->address_neighborhood }}<br>
                    {{ $order->address_main_street }} / {{ $order->address_secondary_street }}<br>
                    Ref: {{ $order->address_reference }}
                </p>
            </div>
        @endif
        <a href="{{ route('client.pedidos.index') }}" class="sc-btn sc-btn-secondary w-full justify-center">
            Volver a mis pedidos
        </a>
    </div>
</div>
@endsection
