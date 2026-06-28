/**
 * Modales centrados con labels y fondo borroso (admin + catálogo).
 */

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text ?? '';
    return div.innerHTML;
}

function buildLabelCard(label, value, variant = 'info') {
    return `
        <div class="admin-quick-panel-card">
            <div class="admin-quick-panel-card-top">
                <span class="admin-quick-panel-card-id">${escapeHtml(label)}</span>
                <span class="admin-module-label admin-module-label--${variant}">${escapeHtml(value)}</span>
            </div>
        </div>
    `;
}

function getOverlays() {
    return document.querySelectorAll('.sc-label-overlay, .admin-panel-overlay, #product-panel-overlay');
}

function closeAllLabelModals() {
    document.querySelectorAll('.admin-quick-panel.is-open, .sc-label-modal.is-open, #sc-action-modal.is-open, #product-panel.is-open').forEach((panel) => {
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
    });

    getOverlays().forEach((overlay) => {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    });

    document.body.style.overflow = '';
}

function openLabelOverlay() {
    getOverlays().forEach((overlay) => {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
    });
    document.body.style.overflow = 'hidden';
}

function openAdminPanel(panelId) {
    const panel = document.getElementById('admin-panel-' + panelId);
    if (!panel) return;

    closeAllLabelModals();
    openLabelOverlay();
    panel.classList.add('is-open');
    panel.setAttribute('aria-hidden', 'false');
}

function closeActionModal() {
    const modal = document.getElementById('sc-action-modal');
    if (!modal) return;

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}

function populateActionModal(config) {
    const modal = document.getElementById('sc-action-modal');
    const labelsEl = document.getElementById('sc-action-modal-labels');
    const titleEl = document.getElementById('sc-action-modal-title');
    const descEl = document.getElementById('sc-action-modal-desc');
    const bodyEl = document.getElementById('sc-action-modal-body');
    const footerEl = document.getElementById('sc-action-modal-footer');

    if (!modal || !labelsEl || !titleEl || !descEl || !bodyEl || !footerEl) return;

    const isDelete = config.type === 'delete';
    const actionLabel = isDelete ? 'Eliminar' : 'Editar';
    const variant = isDelete ? 'soon' : 'info';

    labelsEl.innerHTML = `
        <span class="admin-module-label admin-module-label--${variant}">${actionLabel}</span>
        <span class="admin-module-label admin-module-label--info">Confirmación</span>
    `;
    titleEl.textContent = config.title;
    descEl.textContent = isDelete
        ? 'Esta acción no se puede deshacer. Revisa los datos antes de confirmar.'
        : 'Se abrirá el editor del registro seleccionado.';

    const data = config.data ?? {};
    const cards = Object.entries(data)
        .map(([key, value]) => buildLabelCard(key, String(value), 'info'))
        .join('');

    bodyEl.innerHTML = cards || buildLabelCard('Registro', config.title, 'info');

    if (isDelete) {
        footerEl.innerHTML = `
            <div class="sc-label-modal-actions">
                <button type="button" class="sc-btn sc-btn-secondary" data-sc-action-close>Cancelar</button>
                <button type="button" class="sc-btn sc-btn-primary sc-btn-danger" data-sc-action-confirm>Eliminar</button>
            </div>
        `;
    } else {
        footerEl.innerHTML = `
            <div class="sc-label-modal-actions">
                <button type="button" class="sc-btn sc-btn-secondary" data-sc-action-close>Cancelar</button>
                <button type="button" class="sc-btn sc-btn-primary" data-sc-action-confirm>Continuar edición</button>
            </div>
        `;
    }

    footerEl.querySelector('[data-sc-action-confirm]')?.addEventListener('click', () => {
        if (isDelete) {
            submitDeleteAction(config.url);
            return;
        }
        window.location.href = config.url;
    }, { once: true });
}

function submitDeleteAction(url) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = `
        <input type="hidden" name="_token" value="${escapeHtml(getCsrfToken())}">
        <input type="hidden" name="_method" value="DELETE">
    `;
    document.body.appendChild(form);
    form.submit();
}

function openActionModal(trigger) {
    const type = trigger.dataset.scActionOpen;
    const url = trigger.dataset.scActionUrl;
    const title = trigger.dataset.scActionTitle ?? 'Confirmar acción';
    let data = {};

    try {
        data = JSON.parse(trigger.dataset.scActionData ?? '{}');
    } catch {
        data = {};
    }

    closeAllLabelModals();
    populateActionModal({ type, url, title, data });

    const modal = document.getElementById('sc-action-modal');
    if (!modal) return;

    openLabelOverlay();
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function initLabelModals() {
    document.addEventListener('click', (event) => {
        const actionTrigger = event.target.closest('[data-sc-action-open]');
        if (actionTrigger) {
            event.preventDefault();
            openActionModal(actionTrigger);
            return;
        }

        if (event.target.closest('[data-sc-action-close]')) {
            closeActionModal();
            closeAllLabelModals();
            return;
        }

        const adminOpen = event.target.closest('[data-admin-panel-open]');
        if (adminOpen) {
            event.preventDefault();
            openAdminPanel(adminOpen.getAttribute('data-admin-panel-open'));
            const sidebar = document.getElementById('admin-sidebar');
            if (sidebar?.classList.contains('open') && typeof window.toggleSidebar === 'function') {
                window.toggleSidebar();
            }
            return;
        }

        if (event.target.closest('[data-admin-panel-close]')) {
            closeAllLabelModals();
            return;
        }

        const overlay = event.target.closest('.sc-label-overlay, .admin-panel-overlay, #product-panel-overlay');
        if (overlay?.classList.contains('is-open')) {
            closeAllLabelModals();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAllLabelModals();
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    const panelParam = urlParams.get('panel');
    if (panelParam) {
        openAdminPanel(panelParam);
    }
}

window.ScLabelModals = {
    closeAll: closeAllLabelModals,
    openAdminPanel,
    openLabelOverlay,
};

document.addEventListener('DOMContentLoaded', initLabelModals);
