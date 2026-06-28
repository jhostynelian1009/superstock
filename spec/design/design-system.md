# Design System Oficial — SnackConnect Laravel

> **⚠ REGLA OBLIGATORIA:** Todo desarrollador debe leer este documento y `spec/design/ui-components.md` **antes de implementar cualquier interfaz**. Ningún componente visual puede crearse fuera de este sistema de diseño.

---

## 0. Índice

1. [Identidad y Principios Visuales](#1-identidad-y-principios-visuales)
2. [Paleta de Colores Oficial](#2-paleta-de-colores-oficial)
3. [Tipografía Oficial](#3-tipografía-oficial)
4. [Espaciado y Layout](#4-espaciado-y-layout)
5. [Bordes y Radios](#5-bordes-y-radios)
6. [Sombras](#6-sombras)
7. [Iconografía](#7-iconografía)
8. [Modo Oscuro](#8-modo-oscuro)
9. [Visual Consistency Rules](#9-visual-consistency-rules)
10. [Reglas de Aplicación por Módulo](#10-reglas-de-aplicación-por-módulo)

---

## 1. Identidad y Principios Visuales

### 1.1 Concepto de Marca

SnackConnect es una plataforma de comercio local de snacks con checkout vía WhatsApp. Su identidad visual combina:

- **Calidez y apetito:** Tonos cálidos (naranja, amarillo dorado, rosa rosado) que evocan alimentos y cercanía.
- **Modernidad limpia:** Fondos casi-blancos o casi-negros, tipografía sans-serif precisa, geometría ordenada.
- **Contraste intencional:** Acentos vibrantes sobre fondos neutros para jerarquía clara.

### 1.2 Principios de Diseño

| Principio | Descripción |
|:---|:---|
| **Coherencia** | Mismos colores, mismos botones, mismas tarjetas en todo el sistema. |
| **Jerarquía Visual** | El acento principal siempre guía la acción más importante de cada pantalla. |
| **Legibilidad** | Mínimo 4.5:1 de contraste texto/fondo (WCAG AA). |
| **Consistencia de Radio** | Un solo sistema de radios; no se mezclan bordes redondeados con bordes rectos. |
| **Mobile First** | Todo layout se define primero para `< 640px` y escala hacia pantallas más grandes. |

---

## 2. Paleta de Colores Oficial

### 2.1 Colores de Marca (Brand Colors)

Extraídos y normalizados de la referencia visual aprobada.

| Token | Nombre | Hex | Uso Principal |
|:---|:---|:---|:---|
| `--color-brand-primary` | Naranja Acento | `#F53003` | CTA principal, botones primarios, estados activos |
| `--color-brand-secondary` | Amarillo Dorado | `#F8B803` | Badges, highlights, etiquetas de precio |
| `--color-brand-rose` | Rosa Snack | `#F0ACB8` | Decorativos, estados hover suaves, chips de categoría |
| `--color-brand-rose-light` | Rosa Claro | `#F3BEC7` | Fondos de cards de categoría, banners suaves |
| `--color-brand-dark-red` | Rojo Oscuro | `#1D0002` | Fondos oscuros de marca, hero en dark mode |

### 2.2 Colores Neutros (Neutral Scale)

| Token | Hex (Light) | Hex (Dark) | Uso |
|:---|:---|:---|:---|
| `--color-bg-base` | `#FDFDFC` | `#0a0a0a` | Fondo de página principal |
| `--color-bg-surface` | `#FFFFFF` | `#161615` | Cards, modales, paneles |
| `--color-bg-muted` | `#fff2f2` | `#1D0002` | Fondos secundarios, secciones hero decorativas |
| `--color-bg-subtle` | `#dbdbd7` | `#3E3E3A` | Indicadores, separadores, puntos de progreso |
| `--color-text-primary` | `#1b1b18` | `#EDEDEC` | Texto principal |
| `--color-text-secondary` | `#706f6c` | `#A1A09A` | Texto secundario, placeholders, leyendas |
| `--color-text-inverse` | `#FFFFFF` | `#1C1C1A` | Texto sobre fondos oscuros de marca |
| `--color-border-default` | `#e3e3e0` | `#3E3E3A` | Bordes de inputs, cards, separadores |
| `--color-border-strong` | `#19140035` | `#fffaed2d` | Bordes con sombra interna, contenedores activos |

### 2.3 Colores Semánticos (Semantic Colors)

| Token | Hex | Uso |
|:---|:---|:---|
| `--color-success` | `#16a34a` | Mensajes de éxito, estados completados |
| `--color-warning` | `#F8B803` | Advertencias (reusar brand-secondary) |
| `--color-danger` | `#F53003` | Errores de validación, alertas destructivas |
| `--color-info` | `#0284c7` | Información neutral, tooltips |

### 2.4 Colores del Dark Mode (Modo Oscuro)

| Token | Hex | Contexto |
|:---|:---|:---|
| `--dark-accent-primary` | `#FF4433` | Acento principal en dark mode |
| `--dark-accent-orange` | `#FF750F` | Acento naranja oscuro, bordes decorativos SVG |
| `--dark-accent-red` | `#F61500` | Variante saturada del rojo en dark |

---

## 3. Tipografía Oficial

### 3.1 Familia Tipográfica

**Font Principal:** `Instrument Sans` (Google Fonts / Bunny Fonts)

```
font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif,
             'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
```

**Importación CDN oficial del proyecto:**
```html
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
```

### 3.2 Escala Tipográfica

| Nivel | Tamaño | Line Height | Peso | Uso |
|:---|:---|:---|:---|:---|
| `display` | `3rem` (48px) | `1.1` | `600` (SemiBold) | Hero title, nombre de marca |
| `h1` | `1.875rem` (30px) | `1.2` | `600` | Títulos de página |
| `h2` | `1.5rem` (24px) | `1.3` | `600` | Títulos de sección |
| `h3` | `1.25rem` (20px) | `1.4` | `500` (Medium) | Subtítulos, nombres de card |
| `h4` | `1.125rem` (18px) | `1.5` | `500` | Encabezados de panel |
| `body-lg` | `1rem` (16px) | `1.5` | `400` (Regular) | Texto de párrafo estándar |
| `body-sm` | `0.875rem` (14px) | `1.43` | `400` | Texto secundario, labels |
| `caption` | `0.8125rem` (13px) | `20px` | `400` | Metadatos, timestamps, notas |
| `micro` | `0.75rem` (12px) | `1.33` | `400` | Badges, chips pequeños |

### 3.3 Reglas de Tipografía

- **Solo se usa `Instrument Sans`** — nunca `Arial`, `Helvetica` genérico ni variantes sin importar.
- **Pesos autorizados:** `400`, `500`, `600` — no usar `700` (bold) ni `300` (light).
- **Letter-spacing:** `normal` por defecto. Solo `-0.025em` en headings display.
- **No se permiten** fuentes adicionales sin aprobación del Líder Técnico.

---

## 4. Espaciado y Layout

### 4.1 Escala Base de Espaciado

Base unit: `0.25rem` (4px). Todos los espaciados son múltiplos de esta unidad.

| Token | Valor | px equiv. | Uso típico |
|:---|:---|:---|:---|
| `--space-1` | `0.25rem` | `4px` | Micro gaps, padding de badges |
| `--space-2` | `0.5rem` | `8px` | Padding interno pequeño |
| `--space-3` | `0.75rem` | `12px` | Gap entre elementos relacionados |
| `--space-4` | `1rem` | `16px` | Padding estándar de componente |
| `--space-5` | `1.25rem` | `20px` | Padding horizontal de botones |
| `--space-6` | `1.5rem` | `24px` | Padding de cards, separación de secciones |
| `--space-8` | `2rem` | `32px` | Padding de panels grandes |
| `--space-12` | `3rem` | `48px` | Espaciado entre bloques de contenido |
| `--space-20` | `5rem` | `80px` | Padding de secciones hero |

### 4.2 Sistema de Grid

| Breakpoint | Nombre | Ancho mínimo | Columnas | Gutter |
|:---|:---|:---|:---|:---|
| `default` | Mobile | `< 640px` | 4 cols | `16px` |
| `sm` | Small | `≥ 640px` | 8 cols | `24px` |
| `md` | Medium | `≥ 768px` | 12 cols | `24px` |
| `lg` | Large | `≥ 1024px` | 12 cols | `32px` |
| `xl` | XLarge | `≥ 1280px` | 12 cols | `32px` |

### 4.3 Contenedores Máximos

| Uso | Max-width |
|:---|:---|
| Contenido estrecho (auth, modales) | `335px` (mobile) / `448px` (desktop) |
| Contenido general | `56rem` (896px) |
| Layout principal con sidebar | `80rem` (1280px) |
| Página de admin full-width | `100%` con padding horizontal de `32px` |

---

## 5. Bordes y Radios

### 5.1 Sistema de Border Radius

| Token | Valor | Uso |
|:---|:---|:---|
| `--radius-xs` | `0.125rem` (2px) | Micro elementos, separadores |
| `--radius-sm` | `0.25rem` (4px) | **Botones estándar, inputs, badges** ← _radio por defecto del sistema_ |
| `--radius-md` | `0.375rem` (6px) | Cards pequeñas, dropdowns |
| `--radius-lg` | `0.5rem` (8px) | **Cards principales, modales, paneles** |
| `--radius-xl` | `0.75rem` (12px) | Cards hero, featured sections |
| `--radius-full` | `9999px` | Avatares, pills, chips redondos |

> **Regla:** Botones → `--radius-sm`. Cards → `--radius-lg`. Avatares → `--radius-full`. No mezclar arbitrariamente.

### 5.2 Bordes

- **Grosor estándar:** `1px` — nunca más de `2px` para bordes funcionales.
- **Color default:** `var(--color-border-default)` = `#e3e3e0` (claro) / `#3E3E3A` (oscuro).
- **Sombra interna de borde activo:** `inset 0px 0px 0px 1px rgba(26,26,0,0.16)` (claro) / `inset 0px 0px 0px 1px #fffaed2d` (oscuro).

---

## 6. Sombras

### 6.1 Escala de Sombras

| Token | Valor CSS | Uso |
|:---|:---|:---|
| `--shadow-micro` | `0 1px rgba(0,0,0,0.03)` | Indicadores de estado, bullets |
| `--shadow-xs` | `0px 0px 1px rgba(0,0,0,0.03), 0px 1px 2px rgba(0,0,0,0.06)` | Micro-cards, avatares, badges |
| `--shadow-sm` | `0 1px 3px rgba(0,0,0,0.10), 0 1px 2px -1px rgba(0,0,0,0.10)` | Inputs con foco, cards básicas |
| `--shadow-md` | `0 4px 6px -1px rgba(0,0,0,0.10), 0 2px 4px -2px rgba(0,0,0,0.10)` | **Cards estándar, botones elevados** |
| `--shadow-lg` | `0 10px 15px -3px rgba(0,0,0,0.10), 0 4px 6px -4px rgba(0,0,0,0.10)` | Dropdowns, sidebars, navbars |
| `--shadow-xl` | `0 20px 25px -5px rgba(0,0,0,0.10), 0 8px 10px -6px rgba(0,0,0,0.10)` | Modales, popovers |
| `--shadow-inset-border` | `inset 0px 0px 0px 1px rgba(26,26,0,0.16)` | Reemplazo de bordes en superficies blancas |

---

## 7. Iconografía

### 7.1 Sistema de Iconos

- **Librería oficial:** [Heroicons](https://heroicons.com/) — SVG inline o componente Blade.
- **Tamaños autorizados:**
  - `xs`: `12px × 12px` — inline con texto micro
  - `sm`: `16px × 16px` — botones, labels de input
  - `md`: `20px × 20px` — **tamaño por defecto en la UI**
  - `lg`: `24px × 24px` — iconos de navegación, sidebar
  - `xl`: `32px × 32px` — iconos decorativos de sección

### 7.2 Reglas de Uso

- **Color:** siempre hereda `currentColor` del elemento padre — nunca hardcodear colores en SVG.
- **Stroke:** `stroke-linecap: square` para iconos de flecha/link (como en la referencia). `round` para iconos de acción (eliminar, agregar).
- **No usar** íconos de Font Awesome ni Bootstrap Icons — solo Heroicons.
- Cada ícono debe tener un `aria-label` descriptivo cuando actúa como botón.

---

## 8. Modo Oscuro

### 8.1 Estrategia

El modo oscuro se activa mediante **`prefers-color-scheme: dark`** (sistema operativo) o mediante una clase CSS `dark` en el `<html>`.

### 8.2 Reglas de Implementación

- Cada color del sistema tiene su par oscuro definido en la sección 2.
- Los fondos en dark mode NO son negro puro (`#000`) — usar `#0a0a0a` o `#161615`.
- Los acentos en dark mode son más saturados y ligeramente más cálidos: `#FF4433` en lugar de `#F53003`.
- Las sombras en dark mode usan `rgba(255,250,237, 0.17)` en vez de `rgba(0,0,0,0.10)`.
- Las sombras internas de borde usan `#fffaed2d` en lugar de `rgba(26,26,0,0.16)`.

---

## 9. Visual Consistency Rules

> Esta sección garantiza que **todos los módulos del sistema compartan exactamente los mismos patrones visuales**. Su incumplimiento es una violación del sistema de diseño.

### 9.1 Reglas de Color

| Regla | Descripción |
|:---|:---|
| **VC-COL-01** | El color de acento primario `#F53003` se usa **únicamente** para el botón CTA más importante por pantalla y para links de acción. |
| **VC-COL-02** | El amarillo `#F8B803` se reserva para precios, badges de oferta y highlights de producto. Nunca para texto de párrafo. |
| **VC-COL-03** | El rosa `#F0ACB8` solo aparece en elementos decorativos, chips de categoría y secciones hero. |
| **VC-COL-04** | Fondo de página: siempre `#FDFDFC` (claro) / `#0a0a0a` (oscuro). **Prohibido** usar `#fff` puro como fondo de página. |
| **VC-COL-05** | Superficies de cards y modales: `#FFFFFF` (claro) / `#161615` (oscuro). |

### 9.2 Reglas de Tipografía

| Regla | Descripción |
|:---|:---|
| **VC-TYP-01** | Solo se usa `Instrument Sans`. Sin excepciones. |
| **VC-TYP-02** | Los títulos de página (`<h1>`) siempre usan peso `600` y tamaño `h1` de la escala. |
| **VC-TYP-03** | El texto secundario usa siempre `--color-text-secondary` (`#706f6c`). |
| **VC-TYP-04** | Los botones usan siempre el tamaño `body-sm` (14px) con peso `500`. |

### 9.3 Reglas de Botones

| Regla | Descripción |
|:---|:---|
| **VC-BTN-01** | Todos los botones primarios: fondo `#1b1b18`, texto `#FFFFFF`, radio `--radius-sm`. |
| **VC-BTN-02** | Hover de botón primario: fondo `#000000`. Transición `150ms ease-in-out`. |
| **VC-BTN-03** | Botones secundarios: borde `1px solid var(--color-border-default)`, fondo transparente. |
| **VC-BTN-04** | Botones de acento (CTA principal): fondo `#F53003`, texto `#FFFFFF`. Solo 1 por pantalla. |
| **VC-BTN-05** | Botón de WhatsApp: fondo `#25D366`, texto `#FFFFFF`. Ícono de WhatsApp SVG incluido. |
| **VC-BTN-06** | Padding horizontal estándar: `20px`. Padding vertical: `6px`. |

### 9.4 Reglas de Cards

| Regla | Descripción |
|:---|:---|
| **VC-CRD-01** | Todas las cards usan `background: var(--color-bg-surface)` + `border-radius: var(--radius-lg)`. |
| **VC-CRD-02** | Borde de card: `inset 0px 0px 0px 1px rgba(26,26,0,0.16)` como sombra interna (no border CSS). |
| **VC-CRD-03** | Padding interno de card: `--space-6` (24px). |
| **VC-CRD-04** | Cards de producto incluyen: imagen, nombre (`h3`), precio (`brand-secondary`), botón CTA. |
| **VC-CRD-05** | Hover de card: elevación mediante `--shadow-md` con transición `200ms`. |

### 9.5 Reglas de Formularios

| Regla | Descripción |
|:---|:---|
| **VC-FRM-01** | Todos los inputs: borde `1px solid var(--color-border-default)`, radio `--radius-sm`. |
| **VC-FRM-02** | Estado focus: `box-shadow: 0 0 0 2px rgba(245,48,3,0.20)` (anillo de acento). |
| **VC-FRM-03** | Estado error: borde `#F53003`, mensaje de error en `caption` debajo del campo. |
| **VC-FRM-04** | Labels: siempre visibles encima del input, nunca solo placeholder. Peso `500`, tamaño `body-sm`. |
| **VC-FRM-05** | Padding de input: `12px 16px`. |

### 9.6 Reglas de Tablas

| Regla | Descripción |
|:---|:---|
| **VC-TBL-01** | Headers de tabla: fondo `--color-bg-muted`, texto `--color-text-secondary`, peso `500`. |
| **VC-TBL-02** | Filas alternadas: una fila blanca, una fila `#FDFDFC`. No usar grises fuertes. |
| **VC-TBL-03** | Acciones de fila (editar/eliminar): botones de texto con ícono, sin fondo. |
| **VC-TBL-04** | Borde de tabla: `1px solid var(--color-border-default)` solo en separadores horizontales. |

---

## 10. Reglas de Aplicación por Módulo

Cada módulo debe cumplir las reglas base del sistema más sus reglas específicas:

### Landing Page
- Fondo de hero: `--color-bg-muted` (`#fff2f2`) con elementos decorativos en `--color-brand-rose`.
- Navbar: fondo `--color-bg-base`, borde inferior `1px solid --color-border-default`.
- CTA principal: botón de acento `#F53003` con texto de acción claro.
- Precios/destacados: usar `--color-brand-secondary` (`#F8B803`).

### Login / Registro
- Layout dividido: panel de formulario (izquierda/abajo en mobile) sobre fondo `--color-bg-surface`. Panel decorativo (derecha/arriba en mobile) con `--color-bg-muted`.
- Sin sidebars ni navbars complejas. Solo logo + formulario + link de acción secundaria.

### Dashboard Admin
- Sidebar fija izquierda: fondo `--color-bg-surface`, borde derecho `--color-border-default`.
- Área de contenido: fondo `--color-bg-base`.
- Metric cards: fondo `--color-bg-surface` con `--shadow-md` y acento de color semántico.

### Catálogo Público
- Grid de productos: 1 col (mobile), 2 cols (sm), 3 cols (lg), 4 cols (xl).
- Filtros de categoría: chips con radio `--radius-full`, usando `--color-brand-rose` activo.
- Cards de producto: imagen cuadrada (aspect-ratio 1:1) en la parte superior.

### CRUD de Productos (Admin)
- Tabla de listado: seguir todas las reglas `VC-TBL-*`.
- Formulario de creación/edición: en página completa o modal. Seguir todas las reglas `VC-FRM-*`.
- Botón de eliminar: variante `danger` (`color: --color-danger`), requiere confirmación modal.

### WhatsApp Checkout
- Botón de checkout: `--color-brand-whatsapp` (`#25D366`), ancho completo en mobile.
- Resumen del carrito: card con fondo `--color-bg-surface`, lista de ítems, total en `h2` con `--color-brand-secondary`.
- Estado vacío: ilustración simple + texto en `--color-text-secondary`.

---

*Última actualización del Design System: Fase 1 — Cimientos Visuales.*
*Aprobado por: Arquitecto de Software / Líder Técnico.*
