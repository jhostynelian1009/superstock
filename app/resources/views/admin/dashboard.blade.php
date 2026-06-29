@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

    {{-- Encabezado de bienvenida --}}
    <div class="dashboard-welcome">
        <div class="dashboard-welcome-text">
            <h1>Bienvenido nuevamente, {{ $user->name }}.</h1>
            <p>
                <span class="dashboard-welcome-role">{{ $user->role }}</span>
                <span class="dashboard-welcome-separator" aria-hidden="true">·</span>
                {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
        </div>
    </div>

    {{-- Tarjetas de métricas --}}
    <div class="kpi-grid" role="region" aria-label="Indicadores del inventario">
        @foreach($metrics as $metric)
            <div class="kpi-card kpi-card--{{ $metric['variant'] }}">
                <div class="kpi-card-header">
                    <div class="kpi-card-icon" aria-hidden="true">
                        @if($metric['icon'] === 'cube')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                        @elseif($metric['icon'] === 'tag')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                        @elseif($metric['icon'] === 'building-office')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        @endif
                    </div>
                    <span class="kpi-card-label">{{ $metric['label'] }}</span>
                </div>
                <div class="kpi-card-value">{{ $metric['value'] }}</div>
                <p class="kpi-card-description">{{ $metric['description'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Alertas de stock bajo --}}
    <div class="admin-table-wrapper" role="region" aria-label="Alertas de inventario">
        <div class="admin-table-header">
            <h2 class="admin-table-title">Alertas de stock</h2>
        </div>

        @if($lowStockAlerts->isEmpty())
            <div class="dashboard-empty-state">
                <div class="dashboard-empty-state-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="dashboard-empty-state-title">Sin alertas de inventario</h3>
                <p class="dashboard-empty-state-text">Todos los productos tienen existencia por encima de su stock mínimo.</p>
            </div>
        @else
            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Existencia actual</th>
                            <th scope="col">Stock mínimo</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockAlerts as $inventory)
                            @php
                                $isOutOfStock = (float) $inventory->current_stock <= 0;
                            @endphp
                            <tr>
                                <td style="font-weight: 500;">{{ $inventory->product?->name ?? '—' }}</td>
                                <td>{{ number_format((float) $inventory->current_stock, 3, '.', '') }}</td>
                                <td>{{ number_format((float) $inventory->minimum_stock, 3, '.', '') }}</td>
                                <td>
                                    <span class="badge badge--{{ $isOutOfStock ? 'agotado' : 'stock-bajo' }}">
                                        <span class="badge-dot"></span>
                                        {{ $isOutOfStock ? 'Agotado' : 'Stock bajo' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Movimientos recientes --}}
    <div class="admin-table-wrapper" role="region" aria-label="Movimientos recientes">
        <div class="admin-table-header">
            <h2 class="admin-table-title">Movimientos recientes</h2>
        </div>

        @if($recentMovements->isEmpty())
            <div class="dashboard-empty-state">
                <div class="dashboard-empty-state-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </div>
                <h3 class="dashboard-empty-state-title">Sin movimientos registrados</h3>
                <p class="dashboard-empty-state-text">Aún no hay entradas ni salidas en el historial de inventario.</p>
            </div>
        @else
            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Usuario responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMovements as $movement)
                            @php
                                $isInput = $movement->movement_type === \App\Models\InventoryMovement::TYPE_INPUT;
                            @endphp
                            <tr>
                                <td style="color: var(--color-text-secondary);">
                                    {{ $movement->occurred_at->locale('es')->isoFormat('D MMM YYYY, HH:mm') }}
                                </td>
                                <td style="font-weight: 500;">{{ $movement->product?->name ?? '—' }}</td>
                                <td>
                                    <span class="badge badge--{{ $isInput ? 'entrada' : 'salida' }}">
                                        <span class="badge-dot"></span>
                                        {{ $movement->movement_type }}
                                    </span>
                                </td>
                                <td>{{ number_format((float) $movement->quantity, 3, '.', '') }}</td>
                                <td>{{ $movement->user?->name ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Accesos rápidos --}}
    <section class="quick-access-section" aria-label="Accesos rápidos">
        <h2 class="quick-access-heading">Accesos rápidos</h2>
        <div class="quick-access-grid">
            @if($user->isAdmin())
                <a href="{{ route('admin.productos.index') }}" class="quick-access-card">
                    <div class="quick-access-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                    <span class="quick-access-card-title">Productos</span>
                    <span class="quick-access-card-desc">Gestionar catálogo interno</span>
                </a>

                <a href="{{ route('admin.categorias.index') }}" class="quick-access-card">
                    <div class="quick-access-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                    </div>
                    <span class="quick-access-card-title">Categorías</span>
                    <span class="quick-access-card-desc">Organizar clasificaciones</span>
                </a>

                <a href="#" class="quick-access-card">
                    <div class="quick-access-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <span class="quick-access-card-title">Proveedores</span>
                    <span class="quick-access-card-desc">Consultar proveedores</span>
                </a>
            @endif

            <a href="#" class="quick-access-card">
                <div class="quick-access-card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5a1.125 1.125 0 0 0-1.125-1.125H3.375a1.125 1.125 0 0 0-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
                <span class="quick-access-card-title">Inventario</span>
                <span class="quick-access-card-desc">Consultar existencias</span>
            </a>

            <a href="#" class="quick-access-card">
                <div class="quick-access-card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </div>
                <span class="quick-access-card-title">Movimientos</span>
                <span class="quick-access-card-desc">Historial de entradas y salidas</span>
            </a>
        </div>
    </section>

@endsection
