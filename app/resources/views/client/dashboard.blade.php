@extends('layouts.client')

@section('title', 'Mi cuenta — SnackConnect')
@section('page_title', 'Hola, ' . $user->name)
@section('page_subtitle', 'Bienvenido a tu área de cliente')

@section('client_content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="sc-card p-5">
        <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Correo</p>
        <p class="text-sm font-medium text-text-primary mt-1">{{ $user->email }}</p>
    </div>
    <div class="sc-card p-5">
        <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Teléfono</p>
        <p class="text-sm font-medium text-text-primary mt-1">{{ $user->phone ?? '—' }}</p>
    </div>
    <div class="sc-card p-5">
        <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Cédula / ID</p>
        <p class="text-sm font-medium text-text-primary mt-1">{{ $user->document_number ?? '—' }}</p>
    </div>
</div>

<div class="sc-card p-5 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <p class="text-xs font-medium uppercase tracking-wide text-text-secondary">Ubicación de entrega</p>
        @if($user->hasSavedDeliveryAddress())
            <p class="text-sm font-medium text-text-primary mt-1">{{ $user->address_neighborhood }} — {{ $user->address_main_street }}</p>
            <p class="text-xs text-text-secondary mt-1">{{ $user->deliveryLabel() }}</p>
        @elseif(($user->default_delivery_type ?? 'llevar') === 'local')
            <p class="text-sm font-medium text-text-primary mt-1">Consumo local</p>
        @else
            <p class="text-sm text-text-secondary mt-1">Sin dirección guardada. Configúrala en tu perfil.</p>
        @endif
    </div>
    <a href="{{ route('client.perfil.edit') }}" class="sc-btn sc-btn-secondary text-sm shrink-0">Editar perfil</a>
</div>

<div class="sc-card overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-border-default">
        <h2 class="text-lg font-semibold text-text-primary">Pedidos recientes</h2>
        <a href="{{ route('client.pedidos.index') }}" class="text-sm font-medium text-brand-primary hover:underline">
            Ver todos →
        </a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="p-8 text-center">
            <p class="text-sm text-text-secondary mb-4">Aún no has realizado ningún pedido.</p>
            <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-primary">Explorar catálogo</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm min-w-[600px]">
                <thead class="bg-bg-muted text-xs font-medium uppercase tracking-wide text-text-secondary">
                    <tr>
                        <th class="px-5 py-3">Pedido</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3">Fecha</th>
                        <th class="px-5 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr class="border-t border-border-default hover:bg-bg-muted/50">
                            <td class="px-5 py-3 font-medium">{{ $order->order_number }}</td>
                            <td class="px-5 py-3">${{ number_format($order->total, 2) }}</td>
                            <td class="px-5 py-3">{{ $order->statusLabel() }}</td>
                            <td class="px-5 py-3 text-text-secondary">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('client.pedidos.show', $order) }}" class="text-sm font-medium hover:underline">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
