<div id="admin-panel-overlay" class="admin-panel-overlay sc-label-overlay" aria-hidden="true"></div>

{{-- ════════ PANEL: NOTIFICACIONES ════════ --}}
<aside id="admin-panel-notificaciones"
       class="admin-quick-panel sc-label-modal"
       role="dialog"
       aria-modal="true"
       aria-labelledby="admin-panel-title-notificaciones"
       aria-hidden="true">

    <div class="admin-quick-panel-header">
        <div>
            <div class="admin-quick-panel-labels">
                <span class="admin-module-label admin-module-label--info">Notificaciones</span>
                @if(($pendingAdminRequests ?? 0) > 0)
                    <span class="admin-module-label admin-module-label--soon">{{ $pendingAdminRequests }} pendiente{{ $pendingAdminRequests === 1 ? '' : 's' }}</span>
                @endif
            </div>
            <h2 id="admin-panel-title-notificaciones" class="admin-quick-panel-title">Centro de Notificaciones</h2>
            <p class="admin-quick-panel-desc">Solicitudes de nuevas cuentas de administrador.</p>
        </div>
        <button type="button" class="admin-quick-panel-close" data-admin-panel-close aria-label="Cerrar panel">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="admin-quick-panel-body" style="gap: 0; padding: 0;">

        {{-- Código generado recientemente (si viene de una aprobación) --}}
        @if(session('generated_admin_code'))
            <div id="notif-generated-code" style="
                margin: var(--space-4);
                padding: var(--space-4);
                border-radius: var(--radius-lg);
                background: linear-gradient(135deg, var(--color-brand-primary) 0%, var(--color-brand-secondary) 100%);
                color: #fff;
                animation: sc-scaleIn 0.4s ease forwards;
            ">
                <div style="display:flex; align-items:center; gap:var(--space-2); margin-bottom:var(--space-2);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <span style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Código generado — válido 24h</span>
                </div>
                <p style="font-size:0.8rem; opacity:0.85; margin:0 0 var(--space-2);">{{ session('generated_admin_email') }}</p>
                <div style="
                    display: flex; align-items:center; justify-content:space-between;
                    background: rgba(255,255,255,0.15);
                    border-radius: var(--radius-md);
                    padding: var(--space-3) var(--space-4);
                    margin-bottom: var(--space-2);
                ">
                    <code id="notif-code-value" style="font-size:1.35rem; font-weight:700; letter-spacing:0.12em; font-family: monospace;">{{ session('generated_admin_code') }}</code>
                    <button type="button" onclick="copyNotifCode()" title="Copiar código" style="
                        background: rgba(255,255,255,0.2);
                        border: none; border-radius: var(--radius-sm);
                        padding: 4px 8px; cursor:pointer; color:#fff;
                        font-size:0.75rem; font-weight:600;
                        transition: background 0.2s;
                    " onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                        Copiar
                    </button>
                </div>
                <p style="font-size:0.72rem; opacity:0.75; margin:0;">Entrega este código al solicitante para que active su cuenta.</p>
            </div>
        @endif

        {{-- Solicitudes pendientes --}}
        @if(($currentAdminUser ?? null)?->isPrimaryAdmin())
            @if(count($adminNotifications ?? []) > 0)
                <div style="padding: var(--space-2) var(--space-4) var(--space-1); border-bottom: 1px solid var(--color-border-default);">
                    <p style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--color-text-secondary); margin:0;">
                        Solicitudes pendientes de aprobación
                    </p>
                </div>

                @foreach($adminNotifications as $notif)
                    <div class="notif-request-item" style="
                        padding: var(--space-4);
                        border-bottom: 1px solid var(--color-border-default);
                        transition: background 0.15s ease;
                    " onmouseover="this.style.background='var(--color-bg-muted)'" onmouseout="this.style.background=''">
                        <div style="display:flex; align-items:flex-start; gap:var(--space-3);">
                            {{-- Avatar --}}
                            <div style="
                                width:36px; height:36px; flex-shrink:0;
                                border-radius:50%;
                                background: linear-gradient(135deg, var(--color-brand-primary), var(--color-brand-secondary));
                                color:#fff; font-size:0.85rem; font-weight:700;
                                display:flex; align-items:center; justify-content:center;
                            ">{{ strtoupper(substr($notif['name'] ?? '?', 0, 1)) }}</div>

                            <div style="flex:1; min-width:0;">
                                <p style="margin:0; font-weight:600; font-size:0.875rem; color:var(--color-text-primary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $notif['name'] }}
                                </p>
                                <p style="margin:2px 0 0; font-size:0.75rem; color:var(--color-text-secondary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $notif['email'] }}
                                </p>
                                <p style="margin:2px 0 0; font-size:0.7rem; color:var(--color-text-secondary);">{{ $notif['tiempo'] }}</p>
                            </div>
                        </div>

                        {{-- Acciones inline --}}
                        <div style="margin-top:var(--space-3);">
                            <form action="{{ route('admin.solicitudes-admin.approve', $notif['id']) }}" method="POST">
                                @csrf
                                <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:8px; padding:6px; background:var(--color-bg-muted); border-radius:var(--radius-sm); font-size:10px; color:var(--color-text-secondary);">
                                    <span style="font-weight:600; font-size:9px; text-transform:uppercase;">Módulos permitidos:</span>
                                    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:4px;">
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="productos" checked> Prod</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="categorias" checked> Cat</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="proveedores" checked> Prov</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="inventario" checked> Inv</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="movimientos" checked> Mov</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer;"><input type="checkbox" name="permissions[]" value="usuarios"> User</label>
                                        <label style="display:flex; align-items:center; gap:2px; cursor:pointer; grid-column: span 3;"><input type="checkbox" name="permissions[]" value="solicitudes-admin"> Solicitudes Admin</label>
                                    </div>
                                </div>
                                <div style="display:flex; gap:var(--space-2);">
                                    <button type="submit" style="
                                        flex: 1; padding: 6px 0;
                                        border-radius: var(--radius-md);
                                        background: var(--color-brand-primary);
                                        color: #fff; border: none;
                                        font-size: 0.78rem; font-weight: 600;
                                        cursor: pointer;
                                        transition: opacity 0.2s;
                                    " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                        ✓ Aprobar y generar código
                                    </button>
                            </form>
                            <form action="{{ route('admin.solicitudes-admin.reject', $notif['id']) }}" method="POST" style="flex:1;">
                                @csrf
                                <input type="hidden" name="rejection_reason" value="Solicitud rechazada desde panel de notificaciones.">
                                <button type="submit" style="
                                    width:100%; padding: 6px 0;
                                    border-radius: var(--radius-md);
                                    background: transparent;
                                    color: var(--color-text-secondary);
                                    border: 1px solid var(--color-border-default);
                                    font-size: 0.78rem; font-weight: 600;
                                    cursor: pointer;
                                    transition: all 0.2s;
                                " onmouseover="this.style.background='var(--color-bg-muted)'" onmouseout="this.style.background='transparent'">
                                    ✕ Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            @else
                <div style="padding: var(--space-8) var(--space-4); text-align:center;">
                    <div style="width:44px; height:44px; margin:0 auto var(--space-3); border-radius:50%; background:var(--color-bg-muted); display:flex; align-items:center; justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px;color:var(--color-text-secondary);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p style="font-size:0.875rem; font-weight:600; color:var(--color-text-primary); margin:0 0 4px;">Todo al día</p>
                    <p style="font-size:0.8rem; color:var(--color-text-secondary); margin:0;">No hay solicitudes pendientes.</p>
                </div>
            @endif
        @else
            <div style="padding: var(--space-8) var(--space-4); text-align:center;">
                <p style="font-size:0.875rem; color:var(--color-text-secondary); margin:0;">Sin notificaciones nuevas.</p>
            </div>
        @endif
    </div>

    <div class="admin-quick-panel-footer" style="display:flex; align-items:center; justify-content:space-between;">
        @if(($currentAdminUser ?? null)?->isPrimaryAdmin())
            <span class="admin-module-label admin-module-label--info">Solo el admin principal gestiona solicitudes</span>
            <a href="{{ route('admin.solicitudes-admin.index') }}" style="font-size:0.78rem; color:var(--color-brand-primary); font-weight:600; text-decoration:none;">
                Ver todas →
            </a>
        @else
            <span class="admin-module-label admin-module-label--soon">Centro de notificaciones</span>
        @endif
    </div>
</aside>

{{-- ════════ PANEL: CONFIGURACIÓN ════════ --}}
<aside id="admin-panel-configuracion"
       class="admin-quick-panel sc-label-modal"
       role="dialog"
       aria-modal="true"
       aria-labelledby="admin-panel-title-configuracion"
       aria-hidden="true">
    <div class="admin-quick-panel-header">
        <div>
            <div class="admin-quick-panel-labels">
                <span class="admin-module-label admin-module-label--soon">Próximamente</span>
            </div>
            <h2 id="admin-panel-title-configuracion" class="admin-quick-panel-title">Configuración</h2>
            <p class="admin-quick-panel-desc">Ajustes rápidos del sistema sin salir del dashboard.</p>
        </div>
        <button type="button" class="admin-quick-panel-close" data-admin-panel-close aria-label="Cerrar panel">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="admin-quick-panel-body">
        @foreach([
            ['key' => 'Zona Horaria', 'value' => config('app.timezone', 'UTC'), 'hint' => 'Registro de movimientos'],
            ['key' => 'Moneda',       'value' => 'USD ($)',                       'hint' => 'Valorización de inventario'],
            ['key' => 'Entorno',      'value' => config('app.env'),               'hint' => 'Modo de ejecución actual'],
        ] as $setting)
            <div class="admin-quick-panel-card">
                <p class="admin-quick-panel-card-title">{{ $setting['key'] }}</p>
                <p class="admin-quick-panel-card-value">{{ $setting['value'] }}</p>
                <p class="admin-quick-panel-card-meta">{{ $setting['hint'] }}</p>
            </div>
        @endforeach
    </div>
    <div class="admin-quick-panel-footer">
        <span class="admin-module-label admin-module-label--soon">Módulo compacto</span>
        <p class="admin-quick-panel-footer-text">Funcionalidad completa se integrará próximamente.</p>
    </div>
</aside>

{{-- Script: copiar código --}}
<script>
function copyNotifCode() {
    const code = document.getElementById('notif-code-value')?.textContent?.trim();
    if (!code) return;
    navigator.clipboard.writeText(code).then(() => {
        const btn = event.target;
        const original = btn.textContent;
        btn.textContent = '✓ Copiado';
        setTimeout(() => { btn.textContent = original; }, 2000);
    });
}
</script>

