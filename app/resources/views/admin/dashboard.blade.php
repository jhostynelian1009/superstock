@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

    {{-- ════════════════════════════════════════════════════
         WELCOME HEADER + QUICK ACTIONS
         ════════════════════════════════════════════════════ --}}
    <div class="dashboard-welcome">
        <div class="dashboard-welcome-text">
            <h1>¡Bienvenido, Admin!</h1>
            <p>{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.productos.create') }}" class="btn-accent">
                {{-- Heroicon: plus --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo Producto
            </a>
            <a href="{{ route('admin.pedidos.index') }}" class="btn-secondary">
                {{-- Heroicon: clipboard-document-list --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.251 2.251 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Ver Pedidos
            </a>
            <a href="{{ route('catalogo.index') }}" class="btn-secondary" target="_blank" rel="noopener noreferrer">
                {{-- Heroicon: eye --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Ver Catálogo
            </a>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════
         ALERTS
         ════════════════════════════════════════════════════ --}}
    <div class="alerts-section">
        <div class="admin-alert admin-alert--warning">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            <div class="admin-alert-content">
                <div class="admin-alert-title">Stock bajo detectado</div>
                <div>3 productos tienen stock bajo o agotado. Revisa tu inventario para evitar pérdida de ventas.</div>
            </div>
        </div>

        <div class="admin-alert admin-alert--success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <div class="admin-alert-content">
                <div class="admin-alert-title">Sistema actualizado</div>
                <div>El catálogo se ha sincronizado correctamente. Todos los productos están al día.</div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════
         KPI CARDS
         ════════════════════════════════════════════════════ --}}
    <div class="kpi-grid">
        {{-- Ventas --}}
        <div class="kpi-card kpi-card--ventas">
            <div class="kpi-card-header">
                <div class="kpi-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="kpi-card-label">{{ $metrics['ventas']['label'] }}</span>
            </div>
            <div class="kpi-card-value">{{ $metrics['ventas']['value'] }}</div>
            <div class="kpi-card-change kpi-card-change--{{ $metrics['ventas']['direction'] }}">
                @if($metrics['ventas']['direction'] === 'up')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                @endif
                <span>{{ $metrics['ventas']['change'] }} vs ayer</span>
            </div>
        </div>

        {{-- Pedidos --}}
        <div class="kpi-card kpi-card--pedidos">
            <div class="kpi-card-header">
                <div class="kpi-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
                <span class="kpi-card-label">{{ $metrics['pedidos']['label'] }}</span>
            </div>
            <div class="kpi-card-value">{{ $metrics['pedidos']['value'] }}</div>
            <div class="kpi-card-change kpi-card-change--{{ $metrics['pedidos']['direction'] }}">
                @if($metrics['pedidos']['direction'] === 'up')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                @endif
                <span>{{ $metrics['pedidos']['change'] }} vs ayer</span>
            </div>
        </div>

        {{-- Productos --}}
        <div class="kpi-card kpi-card--productos">
            <div class="kpi-card-header">
                <div class="kpi-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
                <span class="kpi-card-label">{{ $metrics['productos']['label'] }}</span>
            </div>
            <div class="kpi-card-value">{{ $metrics['productos']['value'] }}</div>
            <div class="kpi-card-change kpi-card-change--{{ $metrics['productos']['direction'] }}">
                @if($metrics['productos']['direction'] === 'up')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                @endif
                <span>{{ $metrics['productos']['change'] }} activos</span>
            </div>
        </div>

        {{-- Clientes --}}
        <div class="kpi-card kpi-card--clientes">
            <div class="kpi-card-header">
                <div class="kpi-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <span class="kpi-card-label">{{ $metrics['clientes']['label'] }}</span>
            </div>
            <div class="kpi-card-value">{{ $metrics['clientes']['value'] }}</div>
            <div class="kpi-card-change kpi-card-change--{{ $metrics['clientes']['direction'] }}">
                @if($metrics['clientes']['direction'] === 'up')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                @endif
                <span>{{ $metrics['clientes']['change'] }} vs ayer</span>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════
         MAIN CONTENT GRID (2/3 + 1/3)
         ════════════════════════════════════════════════════ --}}
    <div class="dashboard-grid">
        {{-- ── Left Column: Tables ── --}}
        <div>
            {{-- Pedidos Recientes --}}
            <div class="admin-table-wrapper">
                <div class="admin-table-header">
                    <h2 class="admin-table-title">Pedidos Recientes</h2>
                    <a href="{{ route('admin.dashboard', ['panel' => 'pedidos']) }}" class="view-all-link">Ver todos →</a>
                </div>
                <div class="admin-table-scroll">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td style="font-weight: 500;">{{ $order['id'] }}</td>
                                    <td>{{ $order['cliente'] }}</td>
                                    <td style="color: var(--color-text-secondary);">{{ $order['productos'] }}</td>
                                    <td style="font-weight: 600;">{{ $order['total'] }}</td>
                                    <td>
                                        <span class="badge badge--{{ $order['estado'] }}">
                                            <span class="badge-dot"></span>
                                            {{ $order['estado_label'] ?? ucfirst($order['estado']) }}
                                        </span>
                                    </td>
                                    <td style="color: var(--color-text-secondary);">{{ $order['fecha'] }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ $order['url'] ?? route('admin.pedidos.index') }}" class="table-action-btn" aria-label="Ver pedido">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Productos Recientes --}}
            <div class="admin-table-wrapper">
                <div class="admin-table-header">
                    <h2 class="admin-table-title">Productos Recientes</h2>
                    <a href="{{ route('admin.productos.index') }}" class="view-all-link">Ver todos →</a>
                </div>
                <div class="admin-table-scroll">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="table-product-cell">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/'.$product->image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="h-10 w-10 rounded-sm object-cover">
                                            @else
                                                <div class="product-img-placeholder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="table-product-info">
                                                <span class="table-product-name">{{ $product->name }}</span>
                                                <span class="table-product-cat">{{ $product->category?->name ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-price">${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if($product->stock === 0)
                                            <span style="color: var(--color-danger); font-weight: 500;">Agotado</span>
                                        @elseif($product->stock <= 10)
                                            <span style="color: #92600A; font-weight: 500;">{{ $product->stock }} uds.</span>
                                        @else
                                            <span>{{ $product->stock }} uds.</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge--{{ $product->is_active ? 'activo' : 'inactivo' }}">
                                            <span class="badge-dot"></span>
                                            {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.productos.index') }}" class="table-action-btn" aria-label="Ver producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.productos.edit', $product) }}" class="table-action-btn" aria-label="Editar producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.productos.index') }}" class="table-action-btn table-action-btn--danger" aria-label="Gestionar producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--color-text-secondary); padding: var(--space-6);">
                                        No hay productos registrados aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── Right Column: Widgets ── --}}
        <div>
            {{-- Estadísticas Semanales --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <h3 class="widget-card-title">Ventas de la Semana</h3>
                </div>
                <div class="widget-card-body">
                    @foreach($weeklyStats as $stat)
                        <div class="stats-bar-item">
                            <span class="stats-bar-label">{{ $stat['day'] }}</span>
                            <div class="stats-bar-track">
                                <div class="stats-bar-fill" style="width: {{ $stat['percent'] }}%;"></div>
                            </div>
                            <span class="stats-bar-value">${{ $stat['sales'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Actividad Reciente --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <h3 class="widget-card-title">Actividad Reciente</h3>
                    <a href="{{ route('admin.dashboard', ['panel' => 'pedidos']) }}" class="view-all-link">Ver todo</a>
                </div>
                <div class="widget-card-body">
                    <div class="activity-timeline">
                        @foreach($recentActivity as $activity)
                            <div class="activity-item">
                                <div class="activity-icon activity-icon--{{ $activity['type'] }}">
                                    @if($activity['type'] === 'order')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                    @elseif($activity['type'] === 'product')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                        </svg>
                                    @elseif($activity['type'] === 'user')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    @elseif($activity['type'] === 'alert')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">{!! $activity['text'] !!}</p>
                                    <p class="activity-time">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
