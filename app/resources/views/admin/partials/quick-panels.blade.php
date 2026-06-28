@php
    $panels = [
        'pedidos' => [
            'title' => 'Pedidos',
            'label' => 'Próximamente',
            'label_variant' => 'soon',
            'description' => 'Consulta y gestiona los pedidos recibidos por WhatsApp.',
            'items' => [
                ['id' => '#SC-1042', 'cliente' => 'María López', 'total' => '$12.50', 'estado' => 'Pendiente'],
                ['id' => '#SC-1041', 'cliente' => 'Carlos Ruiz', 'total' => '$8.75', 'estado' => 'Entregado'],
                ['id' => '#SC-1040', 'cliente' => 'Ana Torres', 'total' => '$15.00', 'estado' => 'En preparación'],
            ],
        ],
        'usuarios' => [
            'title' => 'Usuarios',
            'label' => 'Próximamente',
            'label_variant' => 'soon',
            'description' => 'Administra cuentas de administradores y permisos de acceso.',
            'items' => [
                ['nombre' => 'Admin', 'email' => 'admin@snackconnect.com', 'rol' => 'Administrador'],
                ['nombre' => 'Jaider Tapuyo', 'email' => 'jaidernino2022@gmail.com', 'rol' => 'Administrador'],
            ],
        ],
        'configuracion' => [
            'title' => 'Configuración',
            'label' => 'Próximamente',
            'label_variant' => 'soon',
            'description' => 'Ajustes rápidos del sistema sin salir del dashboard.',
            'settings' => [
                ['key' => 'WHATSAPP_PHONE', 'value' => config('services.whatsapp.phone', '593998128034'), 'hint' => 'Número de pedidos WhatsApp'],
                ['key' => 'Moneda', 'value' => 'USD ($)', 'hint' => 'Formato de precios en catálogo'],
                ['key' => 'Entorno', 'value' => config('app.env'), 'hint' => 'Modo de ejecución actual'],
            ],
        ],
        'notificaciones' => [
            'title' => 'Notificaciones',
            'label' => 'Vista rápida',
            'label_variant' => 'info',
            'description' => 'Alertas recientes del sistema.',
            'items' => [
                ['texto' => 'Stock bajo en 3 productos', 'tiempo' => 'Hace 2 h', 'tipo' => 'warning'],
                ['texto' => 'Catálogo sincronizado correctamente', 'tiempo' => 'Hace 5 h', 'tipo' => 'success'],
                ['texto' => 'Nuevo pedido vía WhatsApp', 'tiempo' => 'Ayer', 'tipo' => 'order'],
            ],
        ],
    ];
@endphp

<div id="admin-panel-overlay" class="admin-panel-overlay sc-label-overlay" aria-hidden="true"></div>

@foreach($panels as $id => $panel)
    <aside id="admin-panel-{{ $id }}"
           class="admin-quick-panel sc-label-modal"
           role="dialog"
           aria-modal="true"
           aria-labelledby="admin-panel-title-{{ $id }}"
           aria-hidden="true">
        <div class="admin-quick-panel-header">
            <div>
                <div class="admin-quick-panel-labels">
                    <span class="admin-module-label admin-module-label--{{ $panel['label_variant'] }}">{{ $panel['label'] }}</span>
                </div>
                <h2 id="admin-panel-title-{{ $id }}" class="admin-quick-panel-title">{{ $panel['title'] }}</h2>
                <p class="admin-quick-panel-desc">{{ $panel['description'] }}</p>
            </div>
            <button type="button" class="admin-quick-panel-close" data-admin-panel-close aria-label="Cerrar panel">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="admin-quick-panel-body">
            @if($id === 'pedidos')
                @foreach($panel['items'] as $item)
                    <div class="admin-quick-panel-card">
                        <div class="admin-quick-panel-card-top">
                            <span class="admin-quick-panel-card-id">{{ $item['id'] }}</span>
                            <span class="admin-module-label admin-module-label--{{ strtolower($item['estado']) === 'entregado' ? 'active' : 'soon' }}">{{ $item['estado'] }}</span>
                        </div>
                        <p class="admin-quick-panel-card-title">{{ $item['cliente'] }}</p>
                        <p class="admin-quick-panel-card-meta">Total: {{ $item['total'] }}</p>
                    </div>
                @endforeach
            @elseif($id === 'usuarios')
                @foreach($panel['items'] as $item)
                    <div class="admin-quick-panel-card">
                        <p class="admin-quick-panel-card-title">{{ $item['nombre'] }}</p>
                        <p class="admin-quick-panel-card-meta">{{ $item['email'] }}</p>
                        <span class="admin-module-label admin-module-label--active">{{ $item['rol'] }}</span>
                    </div>
                @endforeach
            @elseif($id === 'configuracion')
                @foreach($panel['settings'] as $setting)
                    <div class="admin-quick-panel-card">
                        <p class="admin-quick-panel-card-title">{{ $setting['key'] }}</p>
                        <p class="admin-quick-panel-card-value">{{ $setting['value'] }}</p>
                        <p class="admin-quick-panel-card-meta">{{ $setting['hint'] }}</p>
                    </div>
                @endforeach
            @elseif($id === 'notificaciones')
                @forelse(($adminNotifications ?? []) as $item)
                    <a href="{{ $item['url'] ?? route('admin.solicitudes-admin.index') }}" class="admin-quick-panel-card admin-quick-panel-card--{{ $item['tipo'] }}" style="text-decoration:none;color:inherit;">
                        <p class="admin-quick-panel-card-title">{{ $item['texto'] }}</p>
                        <p class="admin-quick-panel-card-meta">{{ $item['tiempo'] }}</p>
                    </a>
                @empty
                    @foreach($panel['items'] as $item)
                        <div class="admin-quick-panel-card admin-quick-panel-card--{{ $item['tipo'] }}">
                            <p class="admin-quick-panel-card-title">{{ $item['texto'] }}</p>
                            <p class="admin-quick-panel-card-meta">{{ $item['tiempo'] }}</p>
                        </div>
                    @endforeach
                @endforelse
            @endif
        </div>

        <div class="admin-quick-panel-footer">
            <span class="admin-module-label admin-module-label--info">Módulo compacto</span>
            <p class="admin-quick-panel-footer-text">Vista previa accesible. La funcionalidad completa se integrará próximamente.</p>
        </div>
    </aside>
@endforeach
