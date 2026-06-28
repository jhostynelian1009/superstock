# Especificación de Módulo: Checkout vía WhatsApp

*   **Responsable del Módulo:** **Líder Técnico (LT) & DEV-FRONT**
*   **Rama Git Relacionada:** `feature/06-whatsapp`
*   **Plazo de Entrega:** Día 9 del Roadmap.

---

## 1. Alcance Académico
Este módulo implementa el flujo de finalización de compra sin añadir la complejidad y riesgo de APIs de pago comerciales, generando redirecciones seguras por medio de URL.

## 2. Historias de Usuario Asignadas
*   **HU-WA-01 (Gestión de Carrito local):** Como cliente, deseo añadir productos a mi carrito y modificar cantidades localmente.
*   **HU-WA-02 (Generar mensaje WhatsApp):** Como cliente, quiero presionar "Confirmar Pedido" para enviar mi carrito formateado al WhatsApp del negocio.

## 3. Especificación Técnica
*   **Almacenamiento del Carrito:** `localStorage` del navegador para evitar persistencia costosa en la base de datos MySQL.
*   **Configuración del número de teléfono:** Almacenado en `.env` como `WHATSAPP_PHONE`.
*   **Estructura del Mensaje (Markdown WhatsApp):**
    ```text
    *¡Hola! Me gustaría hacer el siguiente pedido:*
    ---------------------------------
    - 2x Muffin de Chocolate ($3.00 c/u)
    - 1x Té Verde ($2.00 c/u)
    ---------------------------------
    *Total:* $8.00
    *Cliente:* [Nombre]
    *Entrega:* [Llevar / Consumo Local]
    ```
*   **Redirección:** `https://api.whatsapp.com/send?phone={phone}&text={encodedText}`. Tras abrir la pestaña, se limpia el `localStorage` del cliente.
