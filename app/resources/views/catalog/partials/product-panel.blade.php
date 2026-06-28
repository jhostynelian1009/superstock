{{-- Panel lateral de detalle de producto (mismo estilo label que admin) --}}
<div id="product-panel-overlay" class="admin-panel-overlay sc-label-overlay" aria-hidden="true"></div>

<aside id="product-panel"
       class="admin-quick-panel sc-label-modal"
       role="dialog"
       aria-modal="true"
       aria-labelledby="product-panel-title"
       aria-hidden="true">
    <div class="admin-quick-panel-header">
        <div>
            <div class="admin-quick-panel-labels" id="product-panel-labels"></div>
            <h2 id="product-panel-title" class="admin-quick-panel-title"></h2>
        </div>
        <button type="button" class="admin-quick-panel-close" data-product-panel-close aria-label="Cerrar detalle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="admin-quick-panel-body" id="product-panel-body"></div>

    <div class="admin-quick-panel-footer" id="product-panel-footer"></div>
</aside>
