# Catálogo de Componentes UI — SnackConnect Laravel

> **⚠ REGLA OBLIGATORIA:** Ningún desarrollador puede crear componentes visuales fuera de los definidos en este documento. Cualquier componente nuevo debe ser aprobado por el Líder Técnico y documentado aquí antes de implementarse.

---

## 0. Índice

1. [Navbar](#1-navbar)
2. [Sidebar](#2-sidebar)
3. [Cards](#3-cards)
4. [Botones](#4-botones)
5. [Formularios e Inputs](#5-formularios-e-inputs)
6. [Tablas](#6-tablas)
7. [Alertas](#7-alertas)
8. [Modales](#8-modales)
9. [Badges y Chips](#9-badges-y-chips)
10. [Paginación](#10-paginación)

---

## 1. Navbar

### 1.1 Navbar Pública (Landing, Catálogo)

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `var(--color-bg-base)` (`#FDFDFC` / `#0a0a0a`) |
| **Altura** | `56px` (mobile) / `64px` (desktop) |
| **Borde inferior** | `1px solid var(--color-border-default)` |
| **Posición** | `sticky top-0 z-50` |
| **Padding horizontal** | `--space-5` (20px) |
| **Logo** | Izquierda, texto "SnackConnect" en `h3` peso `600`, color `--color-text-primary` |
| **Links de navegación** | Derecha, `body-sm` peso `500`, color `--color-text-primary` |
| **Hover de links** | Borde inferior `1px solid var(--color-border-strong)` |
| **Botón Login/Register** | Botón secundario con borde (ver sección Botones) |

### 1.2 Navbar Admin (Dashboard, CRUD)

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `var(--color-bg-surface)` (`#FFFFFF` / `#161615`) |
| **Altura** | `64px` |
| **Sombra** | `var(--shadow-sm)` |
| **Contenido** | Breadcrumbs a la izquierda, nombre de usuario + avatar a la derecha |
| **Tipografía breadcrumb** | `caption` (13px), color `--color-text-secondary`, separador `/` |

---

## 2. Sidebar

### 2.1 Sidebar Admin

| Propiedad | Valor |
|:---|:---|
| **Ancho** | `256px` (desktop), colapsada a `64px` (tablet), oculta (mobile con hamburger) |
| **Fondo** | `var(--color-bg-surface)` |
| **Borde derecho** | `1px solid var(--color-border-default)` |
| **Posición** | `fixed left-0 top-0 h-screen` |
| **Logo** | Área superior, `--space-6` de padding, logo + texto "SnackConnect" |
| **Separador** | `1px solid var(--color-border-default)` entre logo y menú |

### 2.2 Ítems de Navegación (Sidebar)

| Estado | Fondo | Texto | Ícono | Borde |
|:---|:---|:---|:---|:---|
| **Normal** | `transparent` | `--color-text-secondary` | `--color-text-secondary` | ninguno |
| **Hover** | `rgba(0,0,0,0.04)` | `--color-text-primary` | `--color-text-primary` | ninguno |
| **Activo** | `rgba(245,48,3,0.08)` | `--color-brand-primary` | `--color-brand-primary` | `left: 3px solid --color-brand-primary` |

| Propiedad | Valor |
|:---|:---|
| **Padding** | `12px 16px` |
| **Radio** | `--radius-sm` (4px) |
| **Gap icono-texto** | `--space-3` (12px) |
| **Icono** | `20px × 20px` (md), Heroicons outline |
| **Tipografía** | `body-sm` (14px), peso `500` |
| **Transición** | `150ms ease-in-out` en background y color |

### 2.3 Secciones del Menú

```
📊  Dashboard          (heroicon: chart-bar-square)
📦  Productos          (heroicon: cube)
🏷️  Categorías         (heroicon: tag)
👥  Usuarios           (heroicon: users)
─── separador ───
⚙️  Configuración      (heroicon: cog-6-tooth)
🚪  Cerrar Sesión      (heroicon: arrow-right-on-rectangle)
```

---

## 3. Cards

### 3.1 Card Base

Componente base del que heredan todas las cards del sistema.

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `var(--color-bg-surface)` |
| **Borde** | Sombra interna: `inset 0 0 0 1px rgba(26,26,0,0.16)` |
| **Radio** | `var(--radius-lg)` (8px) |
| **Padding** | `var(--space-6)` (24px) |
| **Transición** | `box-shadow 200ms ease-in-out` |
| **Hover** | `var(--shadow-md)` |

### 3.2 Card de Producto (Catálogo Público)

```
┌─────────────────────────┐
│  ┌───────────────────┐  │
│  │                   │  │ ← Imagen (aspect-ratio: 1/1, object-fit: cover)
│  │   Imagen Snack    │  │    border-radius: var(--radius-lg) top corners
│  │                   │  │
│  └───────────────────┘  │
│                         │
│  Categoría              │ ← caption, --color-brand-rose, peso 500
│  Nombre del Producto    │ ← h3, --color-text-primary, peso 600
│  Descripción corta...   │ ← body-sm, --color-text-secondary, max 2 líneas
│                         │
│  $3.50                  │ ← h3, --color-brand-secondary (#F8B803), peso 600
│                         │
│  [  Agregar al Carrito ] │ ← Botón primario, ancho completo
└─────────────────────────┘
```

### 3.3 Card de Métrica (Dashboard)

```
┌─────────────────────────┐
│  📦  Total Productos    │ ← Icono (md) + label (body-sm, --color-text-secondary)
│                         │
│  156                    │ ← display/h1 (30px), --color-text-primary, peso 600
│  +12% vs ayer           │ ← caption, --color-success (#16a34a)
└─────────────────────────┘
```

| Propiedad adicional | Valor |
|:---|:---|
| **Acento superior** | Línea de `3px` en el borde superior con color semántico |
| **Acento colores** | Productos: `--color-brand-primary`, Categorías: `--color-brand-secondary`, Usuarios: `--color-info` |

### 3.4 Card de Categoría (Chips en catálogo)

| Propiedad | Valor |
|:---|:---|
| **Fondo normal** | `transparent` |
| **Fondo activo** | `--color-brand-rose-light` (`#F3BEC7`) |
| **Borde** | `1px solid var(--color-border-default)` |
| **Borde activo** | `1px solid var(--color-brand-rose)` |
| **Radio** | `var(--radius-full)` (pill) |
| **Padding** | `6px 16px` |
| **Tipografía** | `body-sm`, peso `500` |

---

## 4. Botones

### 4.1 Variantes de Botón

| Variante | Fondo | Texto | Borde | Hover Fondo |
|:---|:---|:---|:---|:---|
| **Primary** | `#1b1b18` | `#FFFFFF` | `1px solid #000` | `#000000` |
| **Secondary** | `transparent` | `--color-text-primary` | `1px solid var(--color-border-strong)` | `rgba(0,0,0,0.04)` |
| **Ghost** | `transparent` | `--color-text-primary` | `1px solid transparent` | borde `--color-border-default` |
| **Accent (CTA)** | `#F53003` | `#FFFFFF` | `1px solid #F53003` | `#D42800` |
| **Danger** | `transparent` | `#F53003` | `1px solid #F53003` | `rgba(245,48,3,0.08)` |
| **WhatsApp** | `#25D366` | `#FFFFFF` | `1px solid #25D366` | `#1DA851` |

### 4.2 Tamaños de Botón

| Tamaño | Padding | Font Size | Altura mínima |
|:---|:---|:---|:---|
| **sm** | `4px 12px` | `micro` (12px) | `28px` |
| **md** (default) | `6px 20px` | `body-sm` (14px) | `36px` |
| **lg** | `10px 24px` | `body-lg` (16px) | `44px` |

### 4.3 Propiedades Comunes a Todos los Botones

| Propiedad | Valor |
|:---|:---|
| **Border Radius** | `var(--radius-sm)` (4px) |
| **Font Weight** | `500` (medium) |
| **Cursor** | `pointer` |
| **Transición** | `background-color 150ms ease-in-out, border-color 150ms ease-in-out` |
| **Estado disabled** | `opacity: 0.5`, `cursor: not-allowed` |
| **Line Height** | `normal` |

### 4.4 Botones con Ícono

- El ícono va **a la izquierda** del texto, separado por `--space-2` (8px).
- Solo ícono (icon-only button): padding `8px`, forma cuadrada, necesita `aria-label`.
- El ícono hereda `currentColor` del botón.

---

## 5. Formularios e Inputs

### 5.1 Input de Texto (text, email, password, number)

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `var(--color-bg-surface)` |
| **Borde** | `1px solid var(--color-border-default)` |
| **Border Radius** | `var(--radius-sm)` (4px) |
| **Padding** | `12px 16px` |
| **Font Size** | `body-sm` (14px) |
| **Font Weight** | `400` |
| **Placeholder color** | `--color-text-secondary` con `opacity: 0.7` |
| **Altura** | `44px` |

### 5.2 Estados del Input

| Estado | Borde | Sombra adicional |
|:---|:---|:---|
| **Normal** | `var(--color-border-default)` | ninguna |
| **Focus** | `var(--color-brand-primary)` | `0 0 0 2px rgba(245,48,3,0.20)` |
| **Error** | `var(--color-danger)` (`#F53003`) | `0 0 0 2px rgba(245,48,3,0.12)` |
| **Disabled** | `var(--color-border-default)` | fondo `--color-bg-muted`, `opacity: 0.6` |

### 5.3 Labels

| Propiedad | Valor |
|:---|:---|
| **Posición** | Encima del input, separada por `--space-2` (8px) |
| **Font Size** | `body-sm` (14px) |
| **Font Weight** | `500` |
| **Color** | `--color-text-primary` |
| **Requerido** | Asterisco `*` en `--color-danger` después del texto |

### 5.4 Mensajes de Error

| Propiedad | Valor |
|:---|:---|
| **Posición** | Debajo del input, separado por `--space-1` (4px) |
| **Font Size** | `caption` (13px) |
| **Color** | `--color-danger` (`#F53003`) |
| **Ícono** | Heroicon `exclamation-circle` (xs) antes del texto |

### 5.5 Select

- Mismos estilos base que input de texto.
- Flecha personalizada: Heroicon `chevron-down` (`sm`) en `--color-text-secondary`.
- Apariencia: `-webkit-appearance: none` para control visual completo.

### 5.6 Textarea

- Mismos estilos base que input de texto.
- Altura mínima: `120px`.
- `resize: vertical` únicamente.

### 5.7 File Upload (Imágenes de producto)

```
┌─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┐
│                                     │
│   📷  Arrastra tu imagen aquí       │ ← Borde punteado 2px --color-border-default
│   o haz clic para seleccionar       │    Radio: --radius-lg
│                                     │    Fondo: --color-bg-muted
│   JPEG, PNG, WEBP — máx. 2MB       │    Padding: --space-8
└─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┘    Hover: borde --color-brand-primary
```

---

## 6. Tablas

### 6.1 Tabla de Datos (Admin CRUD)

| Propiedad | Valor |
|:---|:---|
| **Ancho** | `100%` dentro del contenedor |
| **Borde exterior** | `1px solid var(--color-border-default)`, radio `--radius-lg` |
| **Overflow** | `overflow-x: auto` en mobile |

### 6.2 Encabezado de Tabla (`<thead>`)

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `var(--color-bg-muted)` (`#fff2f2`) |
| **Tipografía** | `body-sm`, peso `500` |
| **Color texto** | `--color-text-secondary` |
| **Padding celda** | `12px 16px` |
| **Borde inferior** | `1px solid var(--color-border-default)` |
| **Texto** | `text-transform: uppercase`, `letter-spacing: 0.05em`, `font-size: micro (12px)` |

### 6.3 Filas del Cuerpo (`<tbody>`)

| Propiedad | Valor |
|:---|:---|
| **Fondo par** | `var(--color-bg-surface)` |
| **Fondo impar** | `var(--color-bg-base)` |
| **Padding celda** | `12px 16px` |
| **Borde inferior** | `1px solid var(--color-border-default)` |
| **Hover fila** | `rgba(245,48,3,0.04)` |
| **Tipografía** | `body-sm`, peso `400` |

### 6.4 Columna de Acciones

| Propiedad | Valor |
|:---|:---|
| **Layout** | `display: flex`, `gap: --space-2`, alineado a la derecha |
| **Botón Ver** | Ghost con ícono `eye` |
| **Botón Editar** | Ghost con ícono `pencil-square` |
| **Botón Eliminar** | Danger ghost con ícono `trash`, color `--color-danger` |

---

## 7. Alertas

### 7.1 Variantes de Alerta

| Variante | Fondo | Borde izquierdo | Ícono | Color texto |
|:---|:---|:---|:---|:---|
| **Success** | `rgba(22,163,74,0.08)` | `3px solid #16a34a` | `check-circle` | `#16a34a` |
| **Warning** | `rgba(248,184,3,0.10)` | `3px solid #F8B803` | `exclamation-triangle` | `#92600A` |
| **Danger** | `rgba(245,48,3,0.08)` | `3px solid #F53003` | `x-circle` | `#F53003` |
| **Info** | `rgba(2,132,199,0.08)` | `3px solid #0284c7` | `information-circle` | `#0284c7` |

### 7.2 Propiedades Comunes

| Propiedad | Valor |
|:---|:---|
| **Border Radius** | `var(--radius-md)` (6px) |
| **Padding** | `16px 20px` |
| **Gap ícono-texto** | `--space-3` (12px) |
| **Tipografía mensaje** | `body-sm` (14px) |
| **Tipografía título** | `body-sm`, peso `600` |
| **Botón cerrar** | Ícono `x-mark` (sm), posición top-right, `--color-text-secondary` |
| **Dismissible** | Transición `opacity 200ms` al cerrar |

---

## 8. Modales

### 8.1 Modal Base

| Propiedad | Valor |
|:---|:---|
| **Overlay** | `rgba(0,0,0,0.50)`, `backdrop-filter: blur(4px)` |
| **Fondo modal** | `var(--color-bg-surface)` |
| **Border Radius** | `var(--radius-lg)` (8px) |
| **Sombra** | `var(--shadow-xl)` |
| **Ancho** | `90vw` (mobile), `480px` (default), `640px` (wide) |
| **Max Height** | `85vh` con scroll interno |
| **Animación entrada** | `scale(0.95) → scale(1)` + `opacity 0→1`, `200ms ease-out` |
| **Animación salida** | `scale(1) → scale(0.95)` + `opacity 1→0`, `150ms ease-in` |

### 8.2 Estructura del Modal

```
┌──────────────────────────────────────┐
│  Título del Modal              ✕     │ ← Header: padding 20px 24px
│─────────────────────────────────────│    border-bottom: 1px solid --border-default
│                                      │
│  Contenido del modal                 │ ← Body: padding 24px, overflow-y: auto
│  ...                                 │
│                                      │
│─────────────────────────────────────│
│              [Cancelar]  [Confirmar] │ ← Footer: padding 16px 24px
└──────────────────────────────────────┘    border-top, botones alineados a la derecha
```

### 8.3 Modal de Confirmación de Eliminación

| Propiedad | Valor |
|:---|:---|
| **Ícono** | `exclamation-triangle` (xl), color `--color-danger` |
| **Título** | "¿Eliminar [nombre]?" |
| **Mensaje** | Texto descriptivo en `--color-text-secondary` |
| **Botón cancelar** | Variante `secondary` |
| **Botón confirmar** | Variante `danger` con fondo: texto "Eliminar" |

---

## 9. Badges y Chips

### 9.1 Badge de Estado

| Estado | Fondo | Texto | Dot |
|:---|:---|:---|:---|
| **Activo** | `rgba(22,163,74,0.10)` | `#16a34a` | `●` verde |
| **Inactivo** | `rgba(0,0,0,0.06)` | `--color-text-secondary` | `●` gris |
| **Pendiente** | `rgba(248,184,3,0.12)` | `#92600A` | `●` amarillo |

| Propiedad | Valor |
|:---|:---|
| **Padding** | `2px 10px` |
| **Border Radius** | `var(--radius-full)` |
| **Font Size** | `micro` (12px) |
| **Font Weight** | `500` |
| **Dot size** | `6px × 6px`, `margin-right: 6px` |

### 9.2 Badge de Precio

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `rgba(248,184,3,0.15)` |
| **Texto** | `--color-brand-secondary` oscurecido (`#92600A`) |
| **Padding** | `4px 12px` |
| **Font Weight** | `600` |
| **Border Radius** | `var(--radius-sm)` |

### 9.3 Chip de Categoría (Filtros)

Ver sección 3.4 (Card de Categoría).

---

## 10. Paginación

### 10.1 Paginación de Tabla/Catálogo

| Propiedad | Valor |
|:---|:---|
| **Layout** | `flex`, `justify-content: center`, `gap: --space-1` |
| **Botón página** | `36px × 36px`, `body-sm`, peso `500` |
| **Fondo normal** | `transparent` |
| **Fondo hover** | `rgba(0,0,0,0.04)` |
| **Fondo activo** | `--color-brand-primary` (`#F53003`), texto `#FFFFFF` |
| **Border Radius** | `var(--radius-sm)` |
| **Flechas** | Heroicon `chevron-left` / `chevron-right` (sm) |
| **Disabled** | `opacity: 0.4`, `cursor: not-allowed` |

---

## 11. Tabla Resumen de Componentes por Módulo

| Componente | Landing | Login | Registro | Dashboard | Catálogo | Productos | WhatsApp |
|:---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| Navbar Pública | ✅ | — | — | — | ✅ | — | ✅ |
| Navbar Admin | — | — | — | ✅ | — | ✅ | — |
| Sidebar | — | — | — | ✅ | — | ✅ | — |
| Card Producto | — | — | — | — | ✅ | — | ✅ |
| Card Métrica | — | — | — | ✅ | — | — | — |
| Botón Primary | ✅ | ✅ | ✅ | ✅ | — | ✅ | — |
| Botón Accent | ✅ | — | — | — | ✅ | — | — |
| Botón WhatsApp | — | — | — | — | — | — | ✅ |
| Botón Danger | — | — | — | — | — | ✅ | — |
| Input Text | — | ✅ | ✅ | — | ✅ | ✅ | ✅ |
| Select | — | — | — | — | ✅ | ✅ | ✅ |
| File Upload | — | — | — | — | — | ✅ | — |
| Tabla | — | — | — | ✅ | — | ✅ | — |
| Modal | — | — | — | — | — | ✅ | — |
| Alertas | — | ✅ | ✅ | ✅ | — | ✅ | ✅ |
| Badge Estado | — | — | — | ✅ | — | ✅ | — |
| Badge Precio | — | — | — | — | ✅ | — | ✅ |
| Paginación | — | — | — | — | ✅ | ✅ | — |
| Chip Categoría | — | — | — | — | ✅ | — | — |

---

*Última actualización: Fase 1 — Catálogo de Componentes UI.*
*Aprobado por: Arquitecto de Software / Líder Técnico.*
