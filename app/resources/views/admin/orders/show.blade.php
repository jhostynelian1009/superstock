@extends('layouts.admin')

@section('title', 'Pedido ' . $order->order_number)
@section('breadcrumb', 'Pedidos')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Pedido {{ $order->order_number }}</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
            </p>
        </div>
        <a href="{{ route('admin.pedidos.index') }}"
           class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[#fff2f2] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:bg-[#1D0002]">
            ← Volver a pedidos
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="px-4 py-3 border-b border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff2f2] dark:bg-[#1D0002]">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] dark:text-[#A1A09A]">Productos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:text-[#A1A09A]">
                        <tr>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3">Cantidad</th>
                            <th class="px-4 py-3">Precio</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                                <td class="px-4 py-3 font-medium">{{ $item->product_name }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">${{ number_format($item->product_price, 2) }}</td>
                                <td class="px-4 py-3 text-right font-medium">${{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#FDFDFC] dark:bg-[#0a0a0a]">
                            <td colspan="3" class="px-4 py-3 text-right font-semibold">Total</td>
                            <td class="px-4 py-3 text-right text-lg font-bold text-[#F53003]">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-5">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] dark:text-[#A1A09A] mb-4">Cliente</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-[#706f6c] dark:text-[#A1A09A]">Nombre</dt>
                        <dd class="font-medium">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#706f6c] dark:text-[#A1A09A]">Correo</dt>
                        <dd class="font-medium">{{ $order->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#706f6c] dark:text-[#A1A09A]">Teléfono</dt>
                        <dd class="font-medium">{{ $order->customer_phone ?? '—' }}</dd>
                    </div>
                    @if($order->user)
                        <div>
                            <dt class="text-[#706f6c] dark:text-[#A1A09A]">Cédula / ID</dt>
                            <dd class="font-medium">{{ $order->user->document_number ?? '—' }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-5">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] dark:text-[#A1A09A] mb-4">Entrega</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-[#706f6c] dark:text-[#A1A09A]">Tipo</dt>
                        <dd class="font-medium">{{ $order->deliveryLabel() }}</dd>
                    </div>
                    <div>
                        <dt class="text-[#706f6c] dark:text-[#A1A09A]">Estado</dt>
                        <dd class="font-medium">{{ $order->statusLabel() }}</dd>
                    </div>
                    @if($order->delivery_type === 'llevar')
                        <div>
                            <dt class="text-[#706f6c] dark:text-[#A1A09A]">Dirección</dt>
                            <dd class="font-medium">
                                {{ $order->address_neighborhood }}<br>
                                {{ $order->address_main_street }} / {{ $order->address_secondary_street }}<br>
                                Ref: {{ $order->address_reference }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection
