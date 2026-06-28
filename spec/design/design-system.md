# Design System de SuperStock

## 1. Propósito

Definir los tokens y reglas visuales que garantizan consistencia, accesibilidad y eficiencia en todas las interfaces internas. Los componentes concretos se describen en [ui-components.md](ui-components.md).

## 2. Principios

| Principio | Regla |
|---|---|
| Claridad | La información operativa tiene prioridad sobre decoración. |
| Consistencia | Una misma acción utiliza el mismo patrón en todos los módulos. |
| Jerarquía | Cada pantalla posee una acción principal inequívoca. |
| Prevención | Estados críticos se comunican antes de confirmar. |
| Accesibilidad | Cumplimiento WCAG AA y operación por teclado. |
| Responsive | Diseño desde 360 px y adaptación progresiva. |
| Densidad controlada | Tablas y formularios muestran información suficiente sin saturación. |

## 3. Colores

### 3.1 Marca

| Token | Claro | Oscuro | Uso |
|---|---|---|---|
| `brand-primary` | `#1D4ED8` | `#60A5FA` | Acción primaria, foco, navegación activa |
| `brand-primary-hover` | `#1E40AF` | `#93C5FD` | Hover primario |
| `brand-secondary` | `#0F766E` | `#2DD4BF` | Información de inventario y acción secundaria |

### 3.2 Neutros

| Token | Claro | Oscuro | Uso |
|---|---|---|---|
| `bg-base` | `#F8FAFC` | `#0F172A` | Fondo general |
| `bg-surface` | `#FFFFFF` | `#1E293B` | Cards, tablas, modales |
| `bg-muted` | `#F1F5F9` | `#334155` | Headers, filtros, estados vacíos |
| `text-primary` | `#0F172A` | `#F8FAFC` | Texto principal |
| `text-secondary` | `#475569` | `#CBD5E1` | Ayudas y metadatos |
| `border-default` | `#CBD5E1` | `#475569` | Bordes y separadores |

### 3.3 Semánticos

| Token | Claro | Uso |
|---|---|---|
| `success` | `#15803D` | Operación correcta, stock disponible |
| `warning` | `#D97706` | Stock bajo, atención necesaria |
| `danger` | `#B91C1C` | Agotado, error, acción destructiva |
| `info` | `#0369A1` | Información y ayuda |

### Reglas

- Texto normal mantiene contraste 4.5:1.
- Stock disponible, bajo y agotado incluyen etiqueta o icono además de color.
- Peligro no se usa como acento decorativo.
- Una pantalla tiene una acción primaria; las demás son secundarias o de texto.

## 4. Tipografía

**Familia:** Instrument Sans con fallback de sistema.

| Nivel | Tamaño | Peso | Uso |
|---|---:|---:|---|
| Display | 36 px | 600 | Métrica destacada |
| H1 | 30 px | 600 | Título de página |
| H2 | 24 px | 600 | Sección |
| H3 | 20 px | 600 | Card o panel |
| Body | 16 px | 400 | Contenido principal |
| Body small | 14 px | 400/500 | Tablas, formularios |
| Caption | 12 px | 400/500 | Metadatos y badges |

- Pesos permitidos: 400, 500 y 600.
- Labels visibles; un placeholder no los reemplaza.
- Cantidades usan dígitos tabulares cuando sea posible.

## 5. Espaciado

Unidad base: 4 px.

| Token | Valor | Uso |
|---|---:|---|
| `space-1` | 4 px | Separación mínima |
| `space-2` | 8 px | Icono y texto |
| `space-3` | 12 px | Campos relacionados |
| `space-4` | 16 px | Padding estándar |
| `space-5` | 20 px | Botones y paneles compactos |
| `space-6` | 24 px | Cards y formularios |
| `space-8` | 32 px | Bloques principales |
| `space-12` | 48 px | Secciones |

## 6. Layout responsive

| Rango | Comportamiento |
|---|---|
| 360–639 px | Una columna; sidebar en drawer; tablas con scroll o vista apilada |
| 640–767 px | Formularios simples en una o dos columnas según contenido |
| 768–1023 px | Sidebar colapsable; grids de 2 columnas |
| 1024 px o más | Sidebar fija; contenido de hasta 1440 px; grids de 4 métricas |

- Formularios críticos mantienen orden lógico al reflujo.
- Las acciones primarias permanecen visibles sin cubrir contenido.
- No se ocultan columnas críticas sin una alternativa de detalle.

## 7. Bordes y radios

| Token | Valor | Uso |
|---|---:|---|
| `radius-sm` | 4 px | Inputs, botones, badges |
| `radius-md` | 6 px | Dropdowns y filtros |
| `radius-lg` | 8 px | Cards, tablas, modales |
| `radius-full` | 9999 px | Pills y avatares |

- Borde estándar: 1 px.
- Foco: anillo de 2 px con color primario y separación visible.
- No mezclar radios arbitrariamente.

## 8. Sombras

| Nivel | Uso |
|---|---|
| Ninguna | Tablas y superficies contenidas |
| Suave | Cards y header |
| Media | Menús y elementos flotantes |
| Alta | Modales |

Las sombras indican elevación, no decoración. En modo oscuro se reducen y se refuerzan bordes.

## 9. Iconografía

- Librería: Heroicons outline.
- Tamaño estándar: 20 px; navegación: 24 px; decorativo: 32 px.
- Color heredado del texto.
- Iconos de acción con tooltip o texto accesible.
- No usar emojis como iconos funcionales.

## 10. Estados de interacción

Todos los controles contemplan:

- Normal.
- Hover.
- Focus visible.
- Active.
- Disabled.
- Loading.
- Error cuando corresponda.

Un botón en carga conserva ancho, impide doble envío y comunica progreso.

## 11. Modo oscuro

- Activación por preferencia del sistema o selección persistida.
- Sin negro puro como fondo general.
- Colores semánticos ajustados para contraste.
- Imágenes y gráficos no deben perder legibilidad.
- Toda pantalla debe verificarse en ambos modos antes de aprobarse.

## 12. Reglas por tipo de pantalla

### Login

- Contenedor estrecho, marca, formulario y ayuda mínima.
- Sin registro público ni navegación administrativa.

### Listados

- Título, descripción, acción primaria, búsqueda/filtros, tabla, paginación y estado vacío.
- Acciones según rol.

### Formularios

- Grupos semánticos, labels, ayuda, validación próxima al campo y resumen de errores.
- Cancelar como secundaria; guardar como primaria.

### Movimientos

- Producto, stock actual, unidad y efecto de la operación visibles.
- Resumen antes de confirmar.
- Entradas usan información neutral/positiva; salidas insuficientes usan peligro.

### Dashboard

- Métricas con fuente real.
- Máximo cuatro tarjetas primarias por fila.
- Alertas accionables y tabla de movimientos recientes.

## 13. Accesibilidad

- HTML semántico y orden de encabezados.
- Navegación completa por teclado.
- Foco nunca oculto.
- Labels asociados a controles.
- Errores anunciables y comprensibles.
- Tablas con encabezados y caption contextual.
- Modales con foco confinado y retorno al disparador.
- Movimiento reducido cuando el sistema lo solicita.

## 14. Criterio de aprobación visual

Una interfaz se aprueba cuando:

- Usa únicamente tokens definidos.
- Es responsive desde 360 px.
- Funciona con teclado.
- Mantiene contraste AA.
- Muestra estados vacío, carga, éxito y error.
- Respeta permisos del actor.
- No contiene referencias visuales o textuales a SnackConnect.

