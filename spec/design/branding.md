# Branding Oficial — SnackConnect Laravel

---

## 1. Nombre de Marca

| Propiedad | Valor |
|:---|:---|
| **Nombre completo** | SnackConnect |
| **Formato tipográfico** | PascalCase, una sola palabra: **Snack** + **Connect** |
| **Uso incorrecto** | ~~Snack Connect~~, ~~snackconnect~~, ~~SNACKCONNECT~~, ~~Snack-Connect~~ |
| **Tagline** | _"Tus snacks favoritos, directo a tu WhatsApp."_ |

---

## 2. Logo

### 2.1 Logotipo Textual (Primary)

El logo principal de SnackConnect es un **logotipo textual** (wordmark) que utiliza la tipografía del sistema.

| Propiedad | Valor |
|:---|:---|
| **Tipografía** | `Instrument Sans` |
| **Peso** | `600` (SemiBold) |
| **Tamaño mínimo** | `20px` en pantalla |
| **Color sobre fondo claro** | `--color-text-primary` (`#1b1b18`) |
| **Color sobre fondo oscuro** | `--color-text-primary` dark (`#EDEDEC`) |
| **Color sobre fondo de marca** | `#FFFFFF` |

### 2.2 Icono de Marca (Favicon / Avatar)

| Propiedad | Valor |
|:---|:---|
| **Forma** | Cuadrado con `border-radius: var(--radius-lg)` |
| **Fondo** | `--color-brand-primary` (`#F53003`) |
| **Contenido** | Letra **S** en `Instrument Sans`, peso `600`, color `#FFFFFF` |
| **Tamaño mínimo** | `32px × 32px` |
| **Favicon** | Versión a `16px` y `32px` como `.ico` |

### 2.3 Espacio de Protección

El logo debe mantener un espacio mínimo libre a su alrededor equivalente a la **altura de la letra "S"** del logotipo en todos sus lados. Ningún elemento puede invadir esta zona.

### 2.4 Usos Incorrectos del Logo

- ❌ No estirar ni distorsionar las proporciones.
- ❌ No cambiar la tipografía.
- ❌ No usar sombras o efectos de bisel.
- ❌ No colocar sobre fondos que reduzcan el contraste por debajo de 4.5:1.
- ❌ No rotar ni inclinar.
- ❌ No agregar íconos emoji como logo.

---

## 3. Paleta de Marca (Resumen Visual)

### 3.1 Colores Primarios

```
┌───────────────┐  ┌───────────────┐  ┌───────────────┐
│               │  │               │  │               │
│   #F53003     │  │   #F8B803     │  │   #F0ACB8     │
│   Naranja     │  │   Dorado      │  │   Rosa        │
│   Acento      │  │   Precio      │  │   Decorativo  │
│               │  │               │  │               │
└───────────────┘  └───────────────┘  └───────────────┘
```

### 3.2 Neutros de Marca

```
┌───────────────┐  ┌───────────────┐  ┌───────────────┐  ┌───────────────┐
│               │  │               │  │               │  │               │
│   #1b1b18     │  │   #706f6c     │  │   #FDFDFC     │  │   #fff2f2     │
│   Texto       │  │   Texto       │  │   Fondo       │  │   Fondo       │
│   Principal   │  │   Secundario  │  │   Base        │  │   Muted       │
│               │  │               │  │               │  │               │
└───────────────┘  └───────────────┘  └───────────────┘  └───────────────┘
```

> Referencia completa de tokens en [design-system.md](design-system.md#2-paleta-de-colores-oficial).

---

## 4. Tono de Voz

### 4.1 Personalidad de Marca

| Atributo | Descripción |
|:---|:---|
| **Cercano** | Hablamos como un vecino amigable, no como una corporación. |
| **Directo** | Instrucciones claras, sin rodeos. Las acciones se entienden al primer vistazo. |
| **Cálido** | Los colores y el lenguaje evocan comida, sabor y comunidad local. |
| **Confiable** | Sin trucos ni letra pequeña. Precios claros, acciones predecibles. |

### 4.2 Reglas de Copywriting

| Contexto | Tono | Ejemplo |
|:---|:---|:---|
| **Botón CTA** | Imperativo, acción clara | "Agregar al Carrito", "Confirmar Pedido" |
| **Títulos** | Declarativo, corto | "Nuestros Snacks", "Tu Pedido" |
| **Mensajes de éxito** | Positivo, celebratorio | "¡Producto agregado! 🎉" |
| **Mensajes de error** | Empático, solucionador | "No pudimos guardar. Revisa los campos marcados." |
| **Estado vacío** | Invitador, no triste | "Aún no hay productos. ¡Agrega el primero!" |
| **Placeholder** | Guía concreta | "Ej: Muffin de Chocolate" |

### 4.3 Idioma

- **Interfaz del sistema:** Español (es-EC).
- **Mensajes del sistema Laravel (auth, validation):** Español.
- **Variables de código:** Inglés (convención Laravel).

---

## 5. Fotografía y Estilo de Imágenes

### 5.1 Estilo Fotográfico de Productos

| Propiedad | Directriz |
|:---|:---|
| **Iluminación** | Natural o difusa, sin sombras duras. |
| **Fondo** | Neutro (blanco, crema) o ambiental (mesa de madera, mantel). |
| **Encuadre** | Cenital (top-down) o 3/4 para snacks. Nunca tomas laterales planas. |
| **Resolución** | Mínimo `800×800px`, formato cuadrado (1:1). |
| **Formato** | JPEG o WEBP. Máximo 2MB por archivo (RN-02). |
| **Tratamiento** | Sin filtros extremos. Saturación natural. Contraste medio. |

### 5.2 Placeholder de Imagen

Cuando un producto no tiene imagen:

| Propiedad | Valor |
|:---|:---|
| **Fondo** | `--color-bg-muted` (`#fff2f2`) |
| **Ícono** | Heroicon `photo` (xl), color `--color-border-default` |
| **Texto** | "Sin imagen", `caption`, `--color-text-secondary` |

---

## 6. Aplicación de Marca por Contexto

### 6.1 Encabezado de Páginas Públicas

```
[Logo SnackConnect]                    [Catálogo]  [Login]  [Registrarse]
```
- Logo alineado a la izquierda.
- Navegación alineada a la derecha.
- Fondo `--color-bg-base`.

### 6.2 Encabezado del Panel Admin

```
[Logo S]  SnackConnect Admin           [🔔]  [Admin ▾]
```
- Ícono compacto + texto en la sidebar.
- Navbar superior con notificaciones y menú de usuario.

### 6.3 Footer Público

```
─────────────────────────────────────────────
SnackConnect © 2026 — Todos los derechos reservados.
Hecho con 🍕 para la comunidad local.
```
- Texto centrado, `caption`, `--color-text-secondary`.
- Fondo `--color-bg-surface`, borde superior `--color-border-default`.

### 6.4 Página de Login / Registro

- Logo centrado en la parte superior del formulario.
- Sin navbar completa — solo el logo como elemento de marca.
- Fondo dividido: formulario sobre `--color-bg-surface`, panel decorativo sobre `--color-bg-muted`.

---

## 7. Materiales de Referencia

| Recurso | Ubicación |
|:---|:---|
| Design System completo | [spec/design/design-system.md](design-system.md) |
| Catálogo de componentes | [spec/design/ui-components.md](ui-components.md) |
| Arquitectura del sistema | [spec/arquitectura.md](../arquitectura.md) |
| Especificaciones de módulos | [spec/modulos/](../modulos/README.md) |

---

*Última actualización: Fase 1 — Identidad de Marca.*
*Aprobado por: Arquitecto de Software / Líder Técnico.*
