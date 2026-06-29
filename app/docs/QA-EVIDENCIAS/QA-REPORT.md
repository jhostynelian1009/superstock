# INFORME QA – SNACKCONNECT

**Framework:** Laravel 12.61.0
**Fase:** Integración Final
**Líder Técnico:** Jhostyn Baños
**QA:** Diana
**Estado:** En pruebas

---

## Resumen General

| Módulo            | Estado               |
| ----------------- | -------------------- |
| Landing Page      | ✅ Funciona           |
| Catálogo          | ⚠️ Con observaciones |
| Autenticación     | ⚠️ Con observaciones |
| Dashboard         | ⚠️ Con observaciones |
| Productos         | ⬜ Pendiente          |
| Categorías        | ⬜ Pendiente          |
| WhatsApp Checkout | ⚠️ Con observaciones |

---

## Registro de Bugs

### BUG-001

**Módulo:** Catálogo / Carrito

**Descripción:**
El botón **"Agregar al carrito"** ubicado debajo de cada producto no ejecuta correctamente la acción esperada.

**Severidad:** Alta

**Estado:** Pendiente

---

### BUG-002

**Módulo:** Autenticación

**Descripción:**
El botón **"Iniciar sesión"** desde el catálogo o navegación pública no funciona correctamente.

**Severidad:** Alta

**Estado:** Pendiente

---

### BUG-003

**Módulo:** Dashboard

**Descripción:**
Los componentes visuales del dashboard presentan problemas de espaciado y distribución, dificultando la lectura y navegación.

**Severidad:** Media

**Estado:** Pendiente

---

### BUG-004

**Módulo:** Dashboard

**Descripción:**
No funcionan los siguientes botones o accesos:

* Nuevo Producto
* Ver Pedidos
* Campana de notificaciones
* Perfil de administrador
* Productos
* Categorías
* Usuarios
* Configuración
* Cerrar sesión

**Severidad:** Alta

**Estado:** Pendiente

---

### BUG-005

**Módulo:** WhatsApp Checkout

**Descripción:**
El botón de WhatsApp no ejecuta correctamente la redirección o generación del pedido.

**Severidad:** Alta

**Estado:** Pendiente

---

## Evidencias

Guardar futuras capturas dentro de:

```text
app/docs/QA-EVIDENCIAS/
```

---

## Conclusión Preliminar

El sistema integra correctamente los módulos principales; sin embargo, se detectaron fallos funcionales y visuales que requieren corrección antes del despliegue final.
