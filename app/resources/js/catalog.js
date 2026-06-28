/**
 * Catálogo público: carrito AJAX (sin recarga) y panel de producto con labels.
 */

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

function formatPrice(price) {
    return '$' + Number(price).toFixed(2);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text ?? '';
    return div.innerHTML;
}

function updateCartBadge(count) {
    const desktopLink = document.querySelector('#navbar-public a[href*="cart"]');
    if (!desktopLink) return;

    let badge = desktopLink.querySelector('.sc-cart-badge');
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'sc-cart-badge';
            badge.id = 'sc-cart-badge';
            desktopLink.appendChild(badge);
        }
        badge.textContent = String(count);
    } else if (badge) {
        badge.remove();
    }

    const mobileCart = document.querySelector('#mobile-menu a[href*="cart"]');
    if (mobileCart) {
        const base = 'Carrito';
        mobileCart.textContent = count > 0 ? `${base} (${count})` : base;
    }
}

function removeExistingToast() {
    document.getElementById('sc-toast')?.remove();
}

function showCartToast(message, type = 'success') {
    removeExistingToast();

    const cartUrl = document.body.dataset.cartUrl ?? '/cart';
    const toast = document.createElement('div');
    toast.id = 'sc-toast';
    toast.className = `sc-toast sc-toast--${type}`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'polite');
    toast.innerHTML = `
        <div class="sc-toast-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div class="sc-toast-body">
            <p class="sc-toast-title">${type === 'success' ? 'Producto añadido' : 'Atención'}</p>
            <p class="sc-toast-message"></p>
        </div>
        ${type === 'success' ? `<a href="${cartUrl}" class="sc-toast-action">Ver carrito</a>` : ''}
        <button type="button" class="sc-toast-close" aria-label="Cerrar notificación">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    `;

    toast.querySelector('.sc-toast-message').textContent = message;
    toast.querySelector('.sc-toast-close')?.addEventListener('click', () => toast.remove());
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('sc-toast--hide');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

async function addProductToCart(productId, button = null) {
    const url = `/cart/add/${productId}`;
    const formData = new FormData();
    formData.append('_token', getCsrfToken());

    if (button) {
        button.disabled = true;
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            showCartToast(data.message ?? 'No se pudo agregar el producto.', 'error');
            return;
        }

        showCartToast(data.message);
        if (typeof data.cart_count === 'number') {
            updateCartBadge(data.cart_count);
        }
    } catch {
        showCartToast('Error de conexión. Intenta de nuevo.', 'error');
    } finally {
        if (button) {
            button.disabled = false;
        }
    }
}

function parseProductData(element) {
    const raw = element.closest('[data-product]')?.dataset.product
        ?? element.dataset.product;
    if (!raw) return null;

    try {
        return JSON.parse(raw);
    } catch {
        return null;
    }
}

function buildLabelCard(label, value, variant = 'info') {
    return `
        <div class="admin-quick-panel-card">
            <div class="admin-quick-panel-card-top">
                <span class="admin-quick-panel-card-id">${label}</span>
                <span class="admin-module-label admin-module-label--${variant}">${value}</span>
            </div>
        </div>
    `;
}

function populateProductPanel(product) {
    const panel = document.getElementById('product-panel');
    const labelsEl = document.getElementById('product-panel-labels');
    const titleEl = document.getElementById('product-panel-title');
    const bodyEl = document.getElementById('product-panel-body');
    const footerEl = document.getElementById('product-panel-footer');

    if (!panel || !labelsEl || !titleEl || !bodyEl || !footerEl) return;

    const isActive = product.status === 'active';
    const statusLabel = isActive ? 'Disponible' : 'Agotado';
    const statusVariant = isActive ? 'active' : 'soon';

    labelsEl.innerHTML = `
        <span class="admin-module-label admin-module-label--info">Detalle</span>
        <span class="admin-module-label admin-module-label--${statusVariant}">${statusLabel}</span>
    `;
    titleEl.textContent = product.name;

    const imageHtml = product.image_url
        ? `<div class="sc-product-panel-image">
               <img src="${escapeHtml(product.image_url)}" alt="${escapeHtml(product.name)}" class="w-full h-full object-cover">
           </div>`
        : `<div class="sc-product-panel-image sc-product-panel-image--placeholder">
               <svg class="w-10 h-10 text-border-default" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                   <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
               </svg>
           </div>`;

    bodyEl.innerHTML = `
        ${imageHtml}
        ${buildLabelCard('Categoría', escapeHtml(product.category), 'info')}
        ${buildLabelCard('Precio', formatPrice(product.price), 'active')}
        <div class="admin-quick-panel-card">
            <div class="admin-quick-panel-card-top">
                <span class="admin-quick-panel-card-id">Descripción</span>
            </div>
            <p class="admin-quick-panel-card-meta">${escapeHtml(product.description)}</p>
        </div>
    `;

    if (isActive) {
        footerEl.innerHTML = `
            <button type="button" class="sc-btn sc-btn-primary w-full js-cart-add-btn" data-product-id="${product.id}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
                Agregar al Carrito
            </button>
            <p class="admin-quick-panel-footer-text">El producto se añade sin recargar la página.</p>
        `;
    } else {
        footerEl.innerHTML = `
            <button type="button" class="sc-btn sc-btn-secondary w-full" disabled>No Disponible</button>
            <p class="admin-quick-panel-footer-text">Este producto no está disponible por el momento.</p>
        `;
    }
}

function openProductPanel(product) {
    const panel = document.getElementById('product-panel');
    if (!panel || !product) return;

    window.ScLabelModals?.closeAll();
    populateProductPanel(product);

    window.ScLabelModals?.openLabelOverlay();
    panel.classList.add('is-open');
    panel.setAttribute('aria-hidden', 'false');
}

function closeProductPanel() {
    const panel = document.getElementById('product-panel');
    if (!panel) return;

    panel.classList.remove('is-open');
    panel.setAttribute('aria-hidden', 'true');

    const anyOpen = document.querySelector('.admin-quick-panel.is-open, #sc-action-modal.is-open');
    if (!anyOpen) {
        window.ScLabelModals?.closeAll();
    }

    const url = new URL(window.location.href);
    if (url.searchParams.has('product')) {
        url.searchParams.delete('product');
        window.history.replaceState({}, '', url);
    }
}

function openProductBySlug(slug) {
    document.querySelectorAll('[data-product]').forEach((el) => {
        try {
            const product = JSON.parse(el.dataset.product);
            if (product.slug === slug) {
                openProductPanel(product);
            }
        } catch {
            /* ignore */
        }
    });
}

function initCatalog() {
    document.querySelectorAll('.js-cart-add-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const match = form.action.match(/\/cart\/add\/(\d+)/);
            const productId = match?.[1];
            if (!productId) return;

            const button = form.querySelector('button[type="submit"]');
            addProductToCart(productId, button);
        });
    });

    document.addEventListener('click', (event) => {
        const addBtn = event.target.closest('.js-cart-add-btn');
        if (addBtn?.dataset.productId) {
            event.preventDefault();
            addProductToCart(addBtn.dataset.productId, addBtn);
            return;
        }

        const openTrigger = event.target.closest('[data-product-panel-open]');
        if (openTrigger) {
            event.preventDefault();
            const product = parseProductData(openTrigger);
            if (product) openProductPanel(product);
            return;
        }

        if (event.target.closest('[data-product-panel-close]')) {
            closeProductPanel();
            return;
        }
    });

    document.getElementById('product-panel-overlay')?.addEventListener('click', closeProductPanel);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && document.getElementById('product-panel')?.classList.contains('is-open')) {
            closeProductPanel();
        }
    });

    const openSlug = window.__SC_OPEN_PRODUCT__;
    if (openSlug) {
        openProductBySlug(openSlug);
    }
}

document.addEventListener('DOMContentLoaded', initCatalog);
