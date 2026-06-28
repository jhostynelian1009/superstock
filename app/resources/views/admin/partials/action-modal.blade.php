{{-- Modal centrado con labels para acciones (editar / eliminar) --}}
<aside id="sc-action-modal"
       class="admin-quick-panel sc-label-modal"
       role="dialog"
       aria-modal="true"
       aria-labelledby="sc-action-modal-title"
       aria-hidden="true">
    <div class="admin-quick-panel-header">
        <div>
            <div class="admin-quick-panel-labels" id="sc-action-modal-labels"></div>
            <h2 id="sc-action-modal-title" class="admin-quick-panel-title"></h2>
            <p id="sc-action-modal-desc" class="admin-quick-panel-desc"></p>
        </div>
        <button type="button" class="admin-quick-panel-close" data-sc-action-close aria-label="Cerrar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="admin-quick-panel-body" id="sc-action-modal-body"></div>

    <div class="admin-quick-panel-footer" id="sc-action-modal-footer"></div>
</aside>
