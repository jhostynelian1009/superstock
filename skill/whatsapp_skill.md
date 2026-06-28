# Skill Runbook: Checkout vía WhatsApp (whatsapp_skill)

*   **Responsable:** **Líder Técnico (LT) & DEV-FRONT**
*   **Rama Git:** `feature/06-whatsapp`
*   **Fase:** Compra y Catálogo (Día 9)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Instrucciones de Implementación
1.  **Configurar número telefónico en el entorno:**
    *   En `.env`, añadir `WHATSAPP_PHONE=59398920065` (ejemplo de formato con código de país).
    *   En `/config/services.php`, registrar la configuración:
        ```php
        'whatsapp' => [
            'phone' => env('WHATSAPP_PHONE'),
        ],
        ```
2.  **Lógica del Carrito en JavaScript (`/resources/js/cart.js`):**
    *   Almacenar productos en un array dentro de `localStorage` (`cart`).
    *   Crear funciones para añadir, restar cantidades y calcular el precio total.
3.  **Generar enlace dinámico de WhatsApp API:**
    *   Formatear los ítems del pedido mediante saltos de línea y negritas de Markdown.
    *   Codificar el string en JavaScript usando `encodeURIComponent` o en PHP mediante `urlencode`.
    *   Redirigir a `https://api.whatsapp.com/send?phone={phone}&text={encodedText}`.
    *   Limpiar el carrito (`localStorage.removeItem('cart')`) tras iniciar la redirección.

## 2. Puntos de Control y Verificación
*   [ ] Comprobar que los saltos de línea y emojis de WhatsApp se envían codificados sin romper la URL.
*   [ ] Asegurar que el número de teléfono cargado sea exactamente el especificado en `.env`.
