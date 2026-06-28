# Catálogo de Componentes UI de SuperStock

## 1. Propósito

Definir componentes reutilizables y su comportamiento. Los valores visuales proceden de [design-system.md](design-system.md); este documento no redefine tokens.

## 2. Estructura interna

### 2.1 Sidebar

Orden oficial:

1. Dashboard.
2. Inventario.
3. Entradas.
4. Salidas.
5. Movimientos.
6. Productos.
7. Categorías.
8. Proveedores.
9. Usuarios.
10. Cerrar sesión.

Productos, Categorías, Proveedores y Usuarios muestran acceso de mantenimiento solo al Administrador. El Empleado puede acceder a consulta de Productos y a los módulos operativos autorizados.

Estados: normal, hover, activo, focus y colapsado. En móvil funciona como drawer con overlay, cierre por Escape y control de foco.

### 2.2 Header

- Breadcrumb y título contextual.
- Nombre y rol del usuario.
- Control de tema cuando se implemente.
- Disparador de sidebar en móvil.
- Sin campana ni notificaciones ficticias.

## 3. Botones

| Variante | Uso |
|---|---|
| Primary | Acción principal: guardar, registrar, confirmar |
| Secondary | Cancelar, volver, filtros secundarios |
| Ghost | Acciones discretas de fila |
| Danger | Desactivar o eliminar cuando esté permitido |
| Success | Uso excepcional para comunicar una entrada, no como estilo general |

Reglas:

- Texto en verbo: “Crear producto”, “Registrar salida”.
- Icono a la izquierda cuando aporta significado.
- Botón solo icono requiere nombre accesible.
- Loading impide doble envío.
- Danger requiere confirmación cuando la acción sea irreversible o sensible.

## 4. Formularios

### 4.1 Campo base

Incluye label, control, ayuda opcional y error. Estados: normal, focus, error, disabled y read-only.

### 4.2 Controles

- Texto y correo.
- Contraseña con control de visibilidad.
- Número y decimal según unidad.
- Select para categoría, rol, estado, proveedor y tipo.
- Fecha y hora.
- Textarea para motivo o descripción.
- Checkbox o switch para estado activo.

### 4.3 Formulario de movimiento

Orden recomendado:

1. Buscar y seleccionar producto.
2. Mostrar SKU, unidad y stock actual.
3. Cantidad.
4. Fecha efectiva.
5. Motivo/origen/destino.
6. Proveedor opcional solo en entrada.
7. Referencia opcional.
8. Resumen del saldo resultante.
9. Confirmación.

La salida muestra error inmediato cuando la cantidad supera disponibilidad, pero el servidor vuelve a validar al confirmar.

## 5. Búsqueda y filtros

- Campo con búsqueda por nombre, SKU o código de barras.
- Select de categoría y estado.
- Filtros de inventario: disponible, bajo, agotado.
- Filtros de movimientos: tipo, producto, responsable, proveedor y período.
- Botón “Limpiar filtros”.
- Los filtros activos se reflejan como chips removibles.
- El estado se conserva durante paginación.

## 6. Tablas

### 6.1 Estructura

- Título o caption contextual.
- Encabezados claros.
- Orden consistente.
- Acciones al final.
- Paginación y resumen de resultados.
- Scroll horizontal o representación apilada en móvil.

### 6.2 Columnas por módulo

| Módulo | Columnas principales |
|---|---|
| Usuarios | Nombre, correo, rol, estado, acciones |
| Categorías | Nombre, descripción, productos, acciones |
| Productos | SKU, código, nombre, categoría, unidad, estado, acciones |
| Proveedores | Razón social, identificación, contacto, estado, acciones |
| Inventario | SKU, producto, categoría, stock, mínimo, condición |
| Movimientos | Fecha, tipo, producto, cantidad, responsable, proveedor, motivo |

Las acciones no autorizadas no se renderizan. La eliminación no aparece para registros protegidos por historial.

## 7. Cards de métricas

| Card | Semántica |
|---|---|
| Productos registrados | Neutral/informativa |
| Productos activos | Secundaria/positiva |
| Stock bajo | Advertencia |
| Agotados | Peligro |

Cada card contiene label, valor, icono y enlace de consulta cuando el actor tiene permiso. No muestra porcentajes inventados.

## 8. Badges

### Estados maestros

- Activo.
- Inactivo.

### Inventario

- Disponible.
- Stock bajo.
- Agotado.

### Movimiento

- Entrada.
- Salida.

Todos combinan color, texto e icono o punto semántico.

## 9. Alertas y notificaciones

| Variante | Uso |
|---|---|
| Success | Operación confirmada |
| Warning | Condición que requiere revisión |
| Danger | Error o stock insuficiente |
| Info | Contexto o ayuda |

- Mensajes específicos y accionables.
- No incluyen datos técnicos sensibles.
- Los mensajes persistentes requieren cierre manual; los transitorios pueden desaparecer sin impedir lectura.

## 10. Modales y confirmaciones

Uso permitido:

- Confirmar desactivación.
- Confirmar eliminación de categoría sin productos.
- Confirmar movimiento mostrando efecto en stock.

Requisitos:

- Título inequívoco.
- Consecuencia explicada.
- Botón cancelar inicialmente seguro.
- Focus confinado y retorno al disparador.
- Cierre por Escape salvo durante confirmación en curso.

Los formularios extensos se presentan en página, no en modal.

## 11. Estados de contenido

### Vacío inicial

Explica que aún no hay registros y ofrece acción solo si el actor puede ejecutarla.

### Sin resultados

Indica que los filtros no encontraron coincidencias y ofrece limpiarlos.

### Carga

Utiliza skeleton o indicador con texto accesible; evita saltos grandes de layout.

### Error

Explica qué no pudo cargarse y ofrece reintento cuando corresponda.

## 12. Paginación

- Disponible en todos los listados extensos.
- Incluye anterior, siguiente, página actual y total conocido.
- Mantiene búsqueda y filtros.
- Controles de al menos 36 px y foco visible.

## 13. Componentes por módulo

| Componente | Auth | Dashboard | Usuarios | Categorías | Productos | Proveedores | Inventario | Entradas | Salidas |
|---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| Layout auth | Sí | — | — | — | — | — | — | — | — |
| Sidebar/Header | — | Sí | Sí | Sí | Sí | Sí | Sí | Sí | Sí |
| Cards métricas | — | Sí | — | — | — | — | — | — | — |
| Tabla | — | Sí | Sí | Sí | Sí | Sí | Sí | — | — |
| Búsqueda/Filtros | — | — | Sí | Sí | Sí | Sí | Sí | Sí | Sí |
| Formulario | Sí | — | Sí | Sí | Sí | Sí | — | Sí | Sí |
| Badges | — | Sí | Sí | — | Sí | Sí | Sí | Sí | Sí |
| Modal confirmación | — | — | Sí | Sí | Sí | Sí | — | Sí | Sí |
| Alertas | Sí | Sí | Sí | Sí | Sí | Sí | Sí | Sí | Sí |
| Paginación | — | — | Sí | Sí | Sí | Sí | Sí | — | — |

## 14. Criterios de aceptación de componentes

- Coinciden con tokens del Design System.
- Funcionan con teclado y lector de pantalla básico.
- Poseen estados normal, focus, disabled y error cuando aplican.
- No dependen de texto, rutas o scripts de SnackConnect.
- Respetan permisos por rol.
- Mantienen comportamiento responsive desde 360 px.

