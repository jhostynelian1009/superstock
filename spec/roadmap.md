# Roadmap de Adaptación e Implementación

## 1. Propósito

Este documento define la transformación controlada de SnackConnect hacia SuperStock. Determina qué se conserva, adapta, elimina o crea y establece fases con criterios de salida. No sustituye las especificaciones funcionales ni autoriza cambios de alcance.

## 2. Estado de partida

SnackConnect aporta:

- Laravel MVC, sesiones, Eloquent, Blade, Vite y Tailwind CSS.
- Login, roles orientados a Administrador y Cliente.
- Gestión parcial de usuarios.
- CRUD de categorías y productos.
- Dashboard administrativo.
- Layouts y componentes responsive.
- Catálogo público, carrito, checkout, pedidos y WhatsApp.

Las principales brechas son:

- No existe el actor Empleado.
- El stock está acoplado al producto y no tiene historial.
- No existen proveedores, inventarios ni movimientos.
- Dashboard contiene métricas comerciales o simuladas.
- La base heredada utiliza MariaDB en el entorno inspeccionado, mientras el destino aprobado es MySQL.

## 3. Estrategia

### Principios

1. Respaldar antes de transformar.
2. Clasificar cada componente antes de eliminarlo.
3. Retirar dependencias desde rutas y navegación hacia capas internas.
4. No convertir clientes heredados automáticamente en empleados.
5. Trasladar el stock mediante movimientos de apertura conciliables.
6. Reemplazar valores simulados por datos reales.
7. Verificar cada fase antes de continuar.
8. Mantener la trazabilidad RF → CU → RN → pruebas.

### Clasificación

- **Reutilizar:** válido sin cambio funcional significativo.
- **Modificar:** base útil con responsabilidad diferente.
- **Eliminar:** exclusivo del dominio SnackConnect.
- **Crear:** necesario y ausente.

## 4. Componentes reutilizados

| Componente | Decisión | Alcance de reutilización |
|---|---|---|
| Arquitectura MVC | Reutilizar | Estructura Laravel, providers, configuración y organización de capas. |
| Autenticación por sesión | Modificar | Conservar guard y protección; adaptar roles y estado activo. |
| Login | Modificar | Mantener flujo base; retirar Cliente y registro público. |
| Usuarios | Modificar | Convertir gestión de clientes en cuentas internas. |
| Categorías | Reutilizar/Modificar | Conservar CRUD; restringir eliminación con productos. |
| Productos | Modificar | Conservar maestro; incorporar SKU, código y unidad; retirar stock y datos comerciales. |
| Dashboard | Modificar | Conservar estructura visual; reemplazar fuentes y métricas. |
| Blade responsive | Reutilizar | Layout interno, formularios, tablas y alertas genéricas. |
| Vite y Tailwind CSS | Reutilizar | Canal de assets y fundamentos visuales. |
| PHPUnit | Reutilizar | Infraestructura; reescribir escenarios de dominio. |

## 5. Componentes eliminados

| Componente | Motivo |
|---|---|
| Landing comercial y catálogo público | SuperStock es interno. |
| Carrito y checkout | No existen compras de clientes. |
| Pedidos y detalle | Ventas fuera del MER. |
| Integración WhatsApp | Sin caso de uso aprobado. |
| Perfil, dirección y dashboard de cliente | El actor Cliente desaparece. |
| Registro público y solicitudes de administradores | Las cuentas las gestiona un Administrador. |
| Métricas de ventas y actividad simulada | Dashboard solo usa inventario real. |
| JavaScript y estilos exclusivos del comercio | No tienen consumidores válidos. |

## 6. Componentes nuevos

| Módulo | Propósito | Prioridad |
|---|---|---|
| Inventario | Consultar saldo, mínimo y estado. | Crítica |
| Movimientos | Mantener historial trazable e inmutable. | Crítica |
| Entradas | Incrementar saldo con origen y responsable. | Alta |
| Salidas | Disminuir saldo validando disponibilidad. | Alta |
| Proveedores | Mantener abastecedores y asociarlos opcionalmente a entradas. | Media |

## 7. Transición de base de datos

| Tabla | Acción | Decisión |
|---|---|---|
| `users` | Modificar | Roles Administrador/Empleado, estado activo; retirar datos de cliente y administrador principal. |
| `categories` | Reutilizar | Conservar datos válidos y aplicar protección referencial. |
| `products` | Modificar | Añadir datos maestros aprobados; retirar stock, precio, imagen y atributos comerciales fuera del modelo. |
| `orders` | Eliminar/Archivar | Fuera del alcance; exportar si se requiere evidencia. |
| `order_items` | Eliminar/Archivar | Dependiente de pedidos. |
| `admin_access_requests` | Eliminar/Archivar | Registro público eliminado. |
| `suppliers` | Crear | Entidad aprobada. |
| `inventories` | Crear | Un saldo por producto en V1. |
| `inventory_movements` | Crear | Entradas y salidas trazables. |

### Secuencia de datos

1. Respaldar esquema y datos.
2. Fijar motor y versión objetivo.
3. Revisar cuentas; conservar solo personal autorizado.
4. Depurar categorías y productos demostrativos o duplicados.
5. Completar SKU, código de barras y unidad.
6. Crear un inventario por producto.
7. Convertir cada stock heredado en una entrada de apertura.
8. Conciliar saldo anterior, apertura y saldo nuevo.
9. Archivar datos comerciales cuando corresponda.
10. Retirar campos y tablas solo después de validar.

## 8. Fases de implementación

### Fase 1 — Línea base y limpieza

**Objetivo:** aislar infraestructura reutilizable y dependencias heredadas.

**Actividades:**

- Crear respaldo y rama de adaptación.
- Ejecutar pruebas heredadas como línea base.
- Inventariar rutas, clases, vistas, assets y datos por módulo.
- Retirar accesos a catálogo, carrito, checkout, pedidos, WhatsApp y clientes.
- Cambiar identidad visible a SuperStock.

**Criterio de salida:** no hay rutas accesibles del dominio eliminado y login administrativo base continúa operativo.

### Fase 2 — Persistencia y transición

**Objetivo:** disponer del modelo de seis entidades y datos conciliables.

**Actividades:**

- Confirmar diseño físico desde `base_datos.md`.
- Preparar transformaciones y reversión.
- Adaptar usuarios, categorías y productos.
- Incorporar proveedores, inventarios y movimientos.
- Crear aperturas y conciliar stock.

**Criterio de salida:** cada dato heredado tiene destino, archivo o eliminación aprobada; los saldos coinciden.

### Fase 3 — Dominio y modelos

**Objetivo:** representar entidades, relaciones y reglas de conservación.

**Actividades:**

- Adaptar User, Category y Product.
- Incorporar Supplier, Inventory e InventoryMovement.
- Retirar relaciones de pedidos y clientes.
- Establecer consultas y conversiones necesarias.

**Criterio de salida:** solo las seis entidades aprobadas integran el dominio funcional.

### Fase 4 — Casos de uso y controladores

**Objetivo:** implementar CU-01 a CU-11.

**Actividades:**

- Adaptar autenticación, usuarios y datos maestros.
- Implementar búsqueda e inventario.
- Implementar entradas, salidas y consulta de movimientos.
- Aplicar transacciones, autorización y validación de disponibilidad.
- Reemplazar consultas del Dashboard.

**Criterio de salida:** cada caso funciona para su actor y un error no deja cambios parciales.

### Fase 5 — Interfaz

**Objetivo:** disponer de una experiencia interna, responsive y accesible.

**Actividades:**

- Aplicar branding y design system.
- Adaptar layouts y menú según rol.
- Crear vistas faltantes.
- Implementar estados vacío, carga, error y confirmación.
- Eliminar recursos visuales heredados.

**Criterio de salida:** los actores completan sus flujos en escritorio y móvil sin ver acciones no autorizadas.

### Fase 6 — Integración

**Objetivo:** verificar funcionamiento de extremo a extremo.

**Actividades:**

- Integrar rutas, middleware, Requests, Controllers, Models y Views.
- Validar datos migrados y permisos.
- Comparar Dashboard contra inventario conocido.
- Buscar referencias residuales de SnackConnect.

**Criterio de salida:** no hay dependencias rotas, datos huérfanos ni discrepancias de saldo.

### Fase 7 — Pruebas y aceptación

**Objetivo:** demostrar cumplimiento funcional y técnico.

**Actividades:**

- Probar autenticación, permisos y datos maestros.
- Probar entradas, salidas y compensaciones.
- Probar stock insuficiente y concurrencia.
- Probar trazabilidad e inmutabilidad.
- Probar Dashboard, responsive y accesibilidad.
- Confirmar ausencia de módulos eliminados.

**Criterio de salida:** no existen defectos críticos y la matriz de trazabilidad posee evidencia.

## 9. Riesgos y mitigación

| Riesgo | Mitigación |
|---|---|
| Dependencias ocultas | Búsqueda estática, inventario de referencias y eliminación incremental. |
| Pérdida de datos | Respaldo validado y archivo previo. |
| Clientes convertidos en empleados | Revisión manual; solo personal autorizado migra. |
| Stock inicial inconsistente | Movimientos de apertura y conciliación por producto. |
| Diferencias MySQL/MariaDB | Motor oficial único y pruebas de integración. |
| Salidas concurrentes | Bloqueo del saldo, revalidación y pruebas simultáneas. |
| Eliminación destructiva | Desactivación de maestros con historia. |
| Dashboard ficticio | Fuente documentada para cada indicador. |
| Regresiones MVC | Cambios por fase y pruebas frecuentes. |
| Alcance creciente | Control de cambios previo en `spec/`. |

## 10. Estrategia de pruebas por prioridad

### Crítica

- Autenticación y permisos.
- Movimiento y saldo indivisibles.
- No negatividad.
- Concurrencia de salidas.
- Inmutabilidad de movimientos.

### Alta

- CRUD de usuarios, categorías, productos y proveedores.
- Búsqueda y filtros.
- Stock bajo y agotado.
- Conciliación de apertura.

### Media

- Responsive y accesibilidad.
- Estados vacíos y mensajes.
- Datos demostrativos y reportes visuales.

## 11. Entregables finales

- Código sin módulos SnackConnect activos.
- Esquema y datos alineados con el MER.
- CU-01 a CU-11 implementados.
- UI alineada con `spec/design/`.
- Suite de pruebas y evidencias.
- Informe de conciliación de datos.
- Manual de instalación y presentación técnica.

## 12. Condición para ampliar alcance

Una nueva funcionalidad solo ingresa al roadmap después de:

1. Actualizar visión y requerimientos.
2. Definir o modificar casos de uso y reglas.
3. Evaluar arquitectura y datos.
4. Actualizar módulo, diseño y pruebas afectadas.
5. Obtener aprobación del responsable del proyecto.

