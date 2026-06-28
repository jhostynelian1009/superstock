# Plan de Adaptación de SnackConnect a SuperStock

**Proyecto destino:** SuperStock  
**Proyecto base:** SnackConnect  
**Tipo de documento:** Plan técnico de adaptación  
**Estado:** Documento base para implementación  
**Arquitectura:** Laravel MVC  
**Persistencia objetivo:** MySQL

## 1. Introducción

SuperStock se construirá mediante la adaptación controlada de SnackConnect, una aplicación Laravel que ya dispone de una estructura MVC operativa, autenticación, control de acceso, vistas responsivas, gestión básica de usuarios, categorías y productos, además de un panel administrativo.

Reutilizar esta base permite concentrar el esfuerzo en el nuevo dominio de inventario y evita repetir actividades ya resueltas, como la configuración del framework, la organización del proyecto, el manejo de sesiones, la validación de formularios, la compilación de recursos y la estructura visual administrativa.

La reutilización no implica conservar todas las funcionalidades existentes. SnackConnect fue concebido como un catálogo de snacks con carrito, clientes y pedidos por WhatsApp; SuperStock será una herramienta interna de gestión de inventario. Por ello, la transformación requiere separar cuidadosamente la infraestructura reutilizable del código acoplado al dominio comercial anterior.

Este documento establece la estrategia oficial para ejecutar dicha transformación de manera incremental, trazable y verificable antes de iniciar la implementación.

## 2. Objetivo

Definir la hoja de ruta técnica para transformar SnackConnect en SuperStock, determinando qué componentes serán reutilizados, modificados, eliminados o desarrollados desde cero.

Los objetivos específicos son:

- Maximizar la reutilización de infraestructura estable.
- Eliminar funcionalidades ajenas al control interno de inventario.
- Adaptar los módulos compatibles con los actores Administrador y Empleado.
- Alinear la persistencia con `03-BaseDatos.md` y `04-MER.md`.
- Incorporar los módulos de inventario definidos por los casos de uso y reglas de negocio.
- Reducir riesgos derivados de dependencias ocultas y eliminación de código.
- Establecer fases, entregables y criterios de finalización verificables.
- Preservar la integridad de los datos durante la transición.

## 3. Alcance

La adaptación comprende el análisis y transformación de los siguientes elementos:

- Estructura MVC de Laravel.
- Autenticación, sesiones, roles y middleware.
- Modelos y relaciones del dominio actual.
- Controladores y validaciones.
- Rutas públicas, privadas y administrativas.
- Vistas Blade, layouts y navegación.
- Recursos visuales y JavaScript.
- Tablas y datos existentes.
- Seeders, factories y datos demostrativos.
- Pruebas automatizadas.
- Identidad visual y terminología del sistema.

El alcance funcional de SuperStock queda limitado a:

- Login y cierre de sesión.
- Administración de usuarios.
- Administración de categorías y productos.
- Consulta de inventario.
- Registro de entradas y salidas.
- Historial de movimientos.
- Gestión básica de proveedores vinculados con entradas.
- Dashboard de indicadores reales.

Quedan excluidos el catálogo público, carrito, checkout, pedidos, WhatsApp, perfiles de clientes, entregas, ventas, facturación y cualquier funcionalidad no aprobada en los documentos del proyecto.

La ejecución de este plan deberá realizarse en una rama de trabajo controlada y con respaldo previo. Este documento no autoriza por sí mismo eliminaciones de datos productivos ni cambios directos sobre la base de datos.

## 4. Estado actual del proyecto

SnackConnect es una aplicación monolítica Laravel con arquitectura MVC y renderizado mediante Blade. Utiliza Eloquent para la persistencia, middleware para separar accesos, sesiones para autenticación y carrito, y Vite con Tailwind CSS y JavaScript para los recursos de interfaz.

### 4.1 Infraestructura existente

- Proyecto Laravel 12 con PHP 8.2 o superior.
- Organización MVC convencional.
- Autenticación basada en sesiones.
- Roles actuales orientados a administrador y cliente.
- Middleware para administrador, cliente y administrador principal.
- Formularios validados mediante Requests y validaciones de controlador.
- Layouts Blade para áreas pública, administrativa, de autenticación y de cliente.
- Diseño responsivo con Tailwind CSS y estilos propios.
- Compilación de recursos mediante Vite.
- Pruebas Feature y Unit existentes.
- Persistencia local configurada con el controlador MySQL, aunque el entorno inspeccionado utiliza MariaDB.

### 4.2 Módulos existentes

- Landing y catálogo público.
- Login y registro de clientes.
- Solicitud pública de acceso administrativo.
- Gestión de categorías y productos.
- Carrito almacenado en sesión.
- Checkout y generación de pedidos por WhatsApp.
- Pedidos y detalle de pedidos.
- Perfil y dirección del cliente.
- Dashboard administrativo.
- Consulta administrativa de clientes.

### 4.3 Limitaciones frente a SuperStock

- El rol Cliente no corresponde al actor Empleado.
- El stock se encuentra acoplado al producto y carece de movimientos trazables.
- Las entradas y salidas no existen como procesos independientes.
- No existen las entidades `Suppliers`, `Inventories` ni `Inventory_Movements`.
- El Dashboard mezcla datos reales con indicadores simulados y métricas de ventas.
- La gestión de usuarios es parcial y está orientada a clientes y solicitudes de administradores.
- Los pedidos no actualizan existencias ni forman parte del dominio objetivo.
- La marca, textos, datos demostrativos e imágenes corresponden a SnackConnect.

## 5. Estrategia de Adaptación

La transformación se realizará de forma incremental y guiada por dependencias. No se eliminará un componente hasta identificar y retirar previamente sus referencias en rutas, controladores, vistas, assets, pruebas y datos.

### 5.1 Clasificación de componentes

Cada componente será clasificado en una de cuatro categorías:

- **Reutilizar:** puede conservarse con cambios mínimos de nombre, configuración o estilo.
- **Modificar:** su base es útil, pero su comportamiento debe alinearse con SuperStock.
- **Eliminar:** pertenece exclusivamente al dominio anterior y no tiene función en el nuevo sistema.
- **Crear:** no existe en SnackConnect y es necesario para cumplir el modelo aprobado.

### 5.2 Principios de ejecución

1. **Conservar primero:** identificar la infraestructura estable antes de retirar módulos.
2. **Eliminar por dependencia:** retirar primero rutas y navegación; después vistas, controladores, modelos, pruebas y datos huérfanos.
3. **Migrar datos con respaldo:** no transformar ni eliminar información sin inventario, copia de seguridad y validación previa.
4. **Adaptar el dominio de forma explícita:** sustituir Cliente por Empleado únicamente para cuentas autorizadas; no convertir automáticamente usuarios finales en empleados.
5. **Separar stock y producto:** trasladar conceptualmente las existencias hacia `inventories` y registrar sus variaciones en `inventory_movements`.
6. **Preservar trazabilidad:** toda existencia inicial deberá contar con un origen controlado durante la transición.
7. **Reemplazar antes de retirar:** los módulos críticos de inventario deben estar disponibles antes de eliminar cualquier mecanismo temporal necesario para validarlos.
8. **Verificar en cada fase:** cada etapa tendrá criterios de salida y pruebas antes de continuar.
9. **Mantener trazabilidad documental:** toda decisión deberá coincidir con los requisitos, casos de uso, reglas de negocio, diseño lógico y MER aprobados.

### 5.3 Orden recomendado de transformación

El orden lógico será: inventariar dependencias, aislar módulos heredados, adaptar autenticación y roles, preparar el nuevo diseño de datos, incorporar el núcleo de inventario, renovar la interfaz, integrar y ejecutar pruebas completas.

Este orden reduce el período en que la aplicación queda en un estado inconsistente y facilita detectar el origen de cada regresión.

## 6. Módulos reutilizados

| Módulo actual | Estado | Justificación |
|---|---|---|
| Login | Reutilización con ajustes | El flujo de autenticación y sesiones es válido; deben retirarse referencias a Cliente, validar cuentas activas y dirigir según los perfiles Administrador y Empleado. |
| Usuarios | Reutilización parcial | La entidad y la autenticación existentes son aprovechables, pero la gestión actual de clientes debe convertirse en administración interna de usuarios. |
| Categorías | Reutilización alta | El concepto, relación con productos, validaciones y vistas CRUD responden al nuevo dominio; deben ajustarse las restricciones de eliminación y la terminología. |
| Productos | Reutilización parcial | Se conservan la identidad básica, categoría, descripción, estado y estructura CRUD; deben añadirse los datos maestros aprobados y eliminar el stock directo. |
| Dashboard | Reutilización visual | El layout, tarjetas y estructura responsiva son aprovechables; las métricas de ventas, pedidos y datos simulados deben reemplazarse. |
| Arquitectura MVC | Reutilización completa | La separación de rutas, controladores, modelos, validaciones y vistas es adecuada para SuperStock y evita reconstruir la base técnica. |
| Sistema de autenticación | Reutilización con ajustes | El guard basado en sesión, el almacenamiento seguro de contraseñas y la protección de rutas siguen siendo válidos; deben adaptarse roles, permisos y estado de cuenta. |
| Diseño responsive | Reutilización alta | La estructura Blade, Tailwind CSS, Vite y componentes adaptables reducen el trabajo de interfaz; requieren depuración y cambio de identidad visual. |
| Gestión de archivos y recursos | Reutilización selectiva | La configuración de Vite y almacenamiento puede conservarse; los recursos exclusivos del catálogo público y productos de SnackConnect deben retirarse. |
| Infraestructura de pruebas | Reutilización con ajustes | PHPUnit, TestCase y la organización Feature/Unit son válidos; los escenarios deben reescribirse para el nuevo dominio. |

## 7. Módulos modificados

| Módulo | Cambios requeridos | Motivo |
|---|---|---|
| Login | Eliminar selección de Cliente, comprobar estado activo, reconocer Administrador y Empleado, ajustar destinos posteriores al acceso y retirar vínculos de registro público. | SuperStock solo admite actores internos autorizados. |
| Usuarios | Sustituir el enfoque de clientes por cuentas internas; incorporar estado activo; adaptar roles; habilitar creación, consulta, edición, activación y desactivación por el Administrador. | CU-03 y RN-008 a RN-010 exigen administración y conservación del historial. |
| Categorías | Conservar el CRUD, impedir eliminación con productos asociados y retirar dependencias de catálogo público o slugs cuando no sean necesarios. | El dominio interno requiere clasificación estable y protección referencial. |
| Productos | Incorporar SKU, código de barras y unidad de control; conservar categoría y estado; retirar stock, precio, imagen o datos heredados que no formen parte del diseño aprobado; impedir eliminación con historial. | `Products` debe contener únicamente información maestra y no existencias físicas. |
| Dashboard | Reemplazar ventas, pedidos, clientes, actividad ficticia y estadísticas simuladas por productos activos, stock bajo, agotados y movimientos recientes. | RN-028 a RN-030 exigen indicadores reales de inventario y una vista exclusivamente informativa. |
| Autorización | Sustituir middleware de Cliente y Administrador principal por controles para Administrador y Empleado; limitar Usuarios y mantenimiento maestro al Administrador. | Los actores y permisos de SuperStock difieren de SnackConnect. |
| Navegación administrativa | Reorganizar el menú para Usuarios, Categorías, Productos, Inventario, Entradas, Salidas, Movimientos, Proveedores y Dashboard. | La navegación debe reflejar únicamente los módulos aprobados. |
| Identidad visual | Cambiar nombre, textos, etiquetas, mensajes, iconografía y referencias de SnackConnect por SuperStock. | Evita ambigüedad de dominio y presenta una aplicación institucional coherente. |

## 8. Módulos eliminados

| Módulo | Motivo de eliminación |
|---|---|
| Carrito | SuperStock no realiza compras ni mantiene una selección temporal de productos para clientes. |
| Checkout | El nuevo sistema no procesa pedidos, entregas ni confirmaciones comerciales. |
| Pedidos | `orders` y `order_items` pertenecen al dominio de ventas de SnackConnect y no forman parte del MER aprobado. |
| WhatsApp | La generación de mensajes y redirección a WhatsApp no participa en ningún caso de uso de inventario. |
| Catálogo público | SuperStock es un sistema interno; los productos se consultan únicamente por usuarios autenticados. |
| Perfil del cliente | El actor Cliente desaparece y no se gestionan direcciones ni preferencias de entrega. |
| Registro público de administradores | Las cuentas internas deben ser creadas y administradas por un Administrador autorizado, no mediante solicitudes públicas. |
| Área personal del cliente | El dashboard, historial de pedidos y navegación del cliente no tienen equivalencia en SuperStock. |
| Landing comercial | La presentación pública de productos y llamadas a compra no corresponde al alcance interno. |

La eliminación se realizará únicamente después de comprobar que no existen referencias activas. Si se requiere conservar evidencia histórica, los datos se exportarán o archivarán fuera del modelo operativo de SuperStock antes de retirar las tablas.

## 9. Nuevos módulos

| Módulo | Objetivo | Prioridad |
|---|---|---|
| Inventario | Consultar la existencia vigente y el stock mínimo de cada producto sin permitir edición directa del saldo. | Crítica |
| Entradas | Registrar incrementos de existencia con producto, cantidad, fecha, origen y usuario responsable. | Alta |
| Salidas | Registrar disminuciones controladas, validando disponibilidad y evitando saldos negativos. | Alta |
| Movimientos de Inventario | Conservar el historial inmutable y trazable de entradas, salidas y correcciones compensatorias. | Crítica |
| Proveedores | Mantener referencias básicas de abastecedores y permitir su asociación opcional con entradas. | Media |

Inventario y Movimientos constituyen el núcleo del nuevo dominio. Entradas y Salidas representan los procesos autorizados para modificar existencias. Proveedores funciona como entidad de apoyo para identificar fuentes de abastecimiento cuando corresponda.

## 10. Adaptación de la Base de Datos

| Tabla actual o prevista | Acción | Justificación |
|---|---|---|
| `users` | Modificar | Conservar identidad y credenciales; reemplazar el rol Cliente por Empleado solo para cuentas autorizadas; incorporar estado activo; retirar dirección, entrega y atributos de administrador principal que no pertenezcan al modelo aprobado. |
| `categories` | Reutilizar | Su propósito y atributos esenciales coinciden con SuperStock; deberán revisarse las restricciones para impedir eliminaciones que afecten productos. |
| `products` | Modificar | Conservar categoría, nombre, descripción y estado; incorporar SKU, código de barras y unidad de control; retirar el stock directo y atributos comerciales no aprobados. |
| `orders` | Eliminar | Representa pedidos comerciales y no pertenece a las seis entidades del MER. Sus datos deberán respaldarse antes de su retiro si se requiere conservar evidencia. |
| `order_items` | Eliminar | Depende de pedidos y representa detalle de ventas, fuera del alcance de SuperStock. |
| `admin_access_requests` | Eliminar | El registro público de administradores desaparece; las cuentas serán gestionadas internamente. |
| `suppliers` | Crear | Representará proveedores y permitirá asociarlos opcionalmente con entradas. |
| `inventories` | Crear | Separará la existencia vigente y el stock mínimo de los datos maestros de productos. |
| `inventory_movements` | Crear | Registrará el historial inmutable de entradas y salidas con producto, usuario, cantidad, fecha, motivo y proveedor opcional. |

### 10.1 Estrategia de transición de datos

La transición deberá planificarse antes de retirar cualquier columna o tabla:

1. Realizar un respaldo verificable de la base actual.
2. Identificar cuentas administrativas válidas y definir cuáles continuarán en SuperStock.
3. No convertir automáticamente clientes existentes en empleados.
4. Revisar y depurar categorías y productos duplicados o exclusivamente demostrativos.
5. Asignar a cada producto los nuevos datos maestros obligatorios.
6. Crear conceptualmente un inventario único por producto.
7. Convertir el stock existente en un saldo inicial respaldado por un movimiento de entrada de apertura claramente identificado.
8. Conciliar el total trasladado con el stock original antes de retirar el campo heredado.
9. Exportar pedidos y solicitudes administrativas si existe obligación de conservarlos.
10. Retirar datos y estructuras heredadas únicamente después de validar la nueva operación.

### 10.2 Compatibilidad del motor

El destino aprobado es MySQL. El entorno heredado inspeccionado utiliza MariaDB mediante el controlador MySQL, por lo que deberán verificarse tipos, restricciones, índices, comportamiento temporal y compatibilidad de cualquier migración futura en el motor seleccionado oficialmente.

El equipo deberá elegir un motor y versión de referencia antes de implementar cambios para evitar diferencias entre desarrollo, pruebas y presentación.

## 11. Adaptación de la Arquitectura

### 11.1 Models

- Conservar y adaptar `User`, `Category` y `Product`.
- Retirar `Order`, `OrderItem` y `AdminAccessRequest` cuando sus dependencias hayan sido eliminadas.
- Incorporar posteriormente `Supplier`, `Inventory` e `InventoryMovement` conforme al MER.
- Sustituir relaciones de pedidos y clientes por relaciones de categorías, inventarios, movimientos, usuarios y proveedores.
- Mantener fuera del producto cualquier lógica de saldo directo.

### 11.2 Controllers

- Reutilizar la base de autenticación, categorías, productos, usuarios y Dashboard.
- Adaptar el controlador de usuarios para cuentas internas.
- Reemplazar las consultas del Dashboard por indicadores reales de inventario.
- Retirar controladores de WhatsApp, pedidos, clientes y registro público administrativo.
- Incorporar controladores específicos para Inventario, Entradas, Salidas, Movimientos y Proveedores.
- Evitar trasladar lógica crítica de stock a controladores extensos; la operación deberá mantenerse cohesionada y verificable.

### 11.3 Requests

- Conservar la estrategia de validación mediante Requests.
- Adaptar validaciones de Productos y Categorías al diseño aprobado.
- Incorporar validaciones específicas para usuarios, proveedores, entradas y salidas.
- Centralizar obligatoriedad, dominios, unicidad y formatos para que las reglas se apliquen uniformemente.

### 11.4 Middleware

- Conservar el middleware de autenticación.
- Adaptar el control de Administrador.
- Sustituir el middleware de Cliente por autorización de Empleado.
- Retirar el middleware de Administrador principal si el perfil no existe en SuperStock.
- Proteger todos los módulos internos y limitar Usuarios, Categorías, Productos y Proveedores según los permisos aprobados.

### 11.5 Views

- Conservar layouts de autenticación y administración como base responsiva.
- Adaptar formularios y listados de Usuarios, Categorías y Productos.
- Rehacer el Dashboard con datos reales.
- Crear vistas internas para Inventario, Entradas, Salidas, Movimientos y Proveedores.
- Eliminar vistas de landing, catálogo público, carrito, checkout, pedidos y área de cliente.
- Evitar presentar botones o enlaces que el actor no pueda utilizar.

### 11.6 Assets

- Conservar Vite, Tailwind CSS y estilos generales compatibles.
- Reutilizar componentes visuales genéricos como tablas, formularios, alertas y navegación.
- Eliminar JavaScript específico de carrito, panel de producto público, checkout y WhatsApp.
- Retirar imágenes demostrativas y estilos exclusivamente comerciales.
- Actualizar logotipo, colores, textos y metadatos a la identidad SuperStock.

### 11.7 Rutas

- Conservar las rutas de login y cierre de sesión, adaptando su comportamiento.
- Mantener rutas internas de Usuarios, Categorías, Productos y Dashboard después de revisar permisos.
- Eliminar rutas públicas de catálogo, carrito, checkout, pedidos, clientes y registro administrativo.
- Incorporar rutas autenticadas para Inventario, Entradas, Salidas, Movimientos y Proveedores.
- Agrupar las rutas por módulo y perfil para facilitar mantenimiento y auditoría.

### 11.8 Seeders

- Retirar datos demostrativos de snacks, clientes, pedidos e imágenes comerciales.
- Conservar únicamente categorías y productos que resulten válidos después de la revisión.
- Preparar datos mínimos de demostración coherentes con SuperStock.
- Evitar seeders que eliminen registros ajenos a su catálogo de ejemplo.
- No incluir credenciales conocidas en entornos distintos del desarrollo controlado.

### 11.9 Factories

- Adaptar la factory de usuarios a los roles Administrador y Empleado y al estado activo.
- Retirar estados orientados a Cliente o Administrador principal.
- Incorporar factories de las nuevas entidades únicamente para pruebas y datos controlados.
- Garantizar que los datos generados respeten unicidad y relaciones obligatorias.

### 11.10 Tests

- Conservar la infraestructura y utilidades generales de PHPUnit.
- Retirar o reescribir pruebas de carrito, checkout, WhatsApp, clientes, pedidos y solicitudes administrativas.
- Adaptar pruebas de autenticación a cuentas activas y roles internos.
- Mantener y ampliar pruebas de Categorías y Productos.
- Incorporar pruebas de Entradas, Salidas, stock insuficiente, no negatividad, trazabilidad, permisos e inmutabilidad.
- Probar operaciones concurrentes que intenten retirar existencias del mismo producto.
- Ejecutar pruebas de integración sobre el motor de base de datos oficialmente seleccionado.

## 12. Riesgos Técnicos

| Riesgo | Impacto posible | Estrategia de mitigación |
|---|---|---|
| Dependencias ocultas entre módulos | Errores por clases, rutas, vistas o scripts que siguen esperando componentes eliminados. | Elaborar un inventario de referencias; retirar módulos en orden de dependencia; ejecutar búsqueda estática y pruebas después de cada eliminación. |
| Eliminación prematura de código | Pérdida de componentes reutilizables o interrupción de funciones compartidas. | Clasificar cada archivo antes de eliminarlo; conservar historial en control de versiones; realizar cambios pequeños y revisables. |
| Pérdida de datos heredados | Eliminación irreversible de pedidos, usuarios o stock existente. | Crear respaldo, exportar información histórica y aprobar formalmente la política de conservación antes de retirar tablas. |
| Conversión incorrecta de roles | Clientes heredados podrían obtener acceso como Empleados. | Revisar cuentas individualmente; migrar solo usuarios internos autorizados; desactivar el resto. |
| Inconsistencia durante el traslado de stock | El saldo inicial podría no coincidir con los valores heredados. | Crear movimientos de apertura, ejecutar conciliación por producto y no retirar el stock anterior hasta validar totales. |
| Compatibilidad de migraciones | Diferencias entre MariaDB y MySQL podrían alterar restricciones o comportamiento. | Definir motor y versión oficiales; validar las migraciones futuras en un entorno equivalente y documentar incompatibilidades. |
| Integridad referencial | Eliminaciones o cambios podrían dejar registros huérfanos. | Diseñar restricciones antes de migrar datos; depurar referencias inválidas; aplicar la política de desactivación. |
| Concurrencia en salidas | Dos operaciones simultáneas podrían utilizar el mismo stock disponible. | Diseñar confirmaciones indivisibles, volver a validar disponibilidad y añadir pruebas de concurrencia. |
| Dashboard con datos obsoletos o simulados | Decisiones incorrectas y pérdida de confianza. | Retirar todos los valores fijos; definir la fuente de cada indicador; contrastar métricas con consultas de inventario. |
| Refactorización extensa | Regresiones por cambios simultáneos en varias capas MVC. | Trabajar por fases verticales, realizar revisiones frecuentes y mantener una matriz de impacto por módulo. |
| Pruebas heredadas incompatibles | Falsos fallos o falsa confianza en comportamientos eliminados. | Clasificar pruebas en conservar, adaptar, retirar y crear; exigir cobertura de reglas críticas. |
| Persistencia de identidad SnackConnect | Mezcla de términos, rutas, mensajes o recursos del dominio anterior. | Ejecutar una revisión final de textos, configuración, nombres visibles, assets, documentación y datos demostrativos. |
| Ampliación no controlada del alcance | Incorporación de ventas, bodegas múltiples u otros módulos no aprobados. | Aplicar control de cambios y validar toda nueva necesidad contra los documentos oficiales antes de desarrollarla. |

## 13. Plan de Implementación

### Fase 1 — Limpieza del proyecto

**Objetivo:** aislar la infraestructura reutilizable y retirar dependencias del dominio anterior sin afectar la base técnica.

**Actividades:**

1. Crear respaldo del código y de la base de datos.
2. Establecer una rama exclusiva para la adaptación.
3. Inventariar rutas, controladores, modelos, vistas, assets y pruebas por módulo.
4. Identificar dependencias de carrito, checkout, pedidos, WhatsApp, catálogo y clientes.
5. Retirar accesos de navegación y rutas heredadas.
6. Eliminar progresivamente componentes sin referencias.
7. Cambiar la identidad visible de SnackConnect a SuperStock.
8. Confirmar que autenticación y panel administrativo base continúan operativos.

**Entregables:** inventario de componentes, respaldo validado, proyecto sin módulos comerciales activos y lista de elementos reutilizables.

**Criterio de salida:** no existen rutas accesibles hacia funcionalidades eliminadas y la aplicación conserva una autenticación administrativa mínima funcional.

### Fase 2 — Adaptación de Base de Datos

**Objetivo:** preparar la persistencia para las seis entidades aprobadas y planificar la transición de datos.

**Actividades:**

1. Confirmar el motor y versión objetivo.
2. Comparar el esquema heredado con `03-BaseDatos.md` y `04-MER.md`.
3. Definir la transformación de `users`, `categories` y `products`.
4. Diseñar la incorporación de `suppliers`, `inventories` e `inventory_movements`.
5. Establecer la estrategia de saldos iniciales y movimientos de apertura.
6. Depurar datos incompatibles y referencias huérfanas.
7. Definir el respaldo o archivo de pedidos y solicitudes administrativas.
8. Preparar criterios de conciliación y reversión.

**Entregables:** matriz de transformación de datos, política de conservación, plan de conciliación y diseño físico revisado.

**Criterio de salida:** cada dato heredado tiene un destino, una regla de conversión o una decisión formal de archivo/eliminación.

### Fase 3 — Adaptación de Modelos

**Objetivo:** alinear la capa de dominio y persistencia con las entidades y relaciones aprobadas.

**Actividades:**

1. Adaptar Usuario, Categoría y Producto.
2. Retirar relaciones con clientes y pedidos.
3. Incorporar Proveedor, Inventario y Movimiento de Inventario.
4. Configurar conceptualmente las cinco relaciones aprobadas.
5. Aplicar estados, dominios y reglas de conservación.
6. Evitar cualquier actualización directa de stock desde Producto.
7. Verificar que los movimientos históricos no sean eliminables.

**Entregables:** capa de modelos alineada con el MER y matriz de relaciones validada.

**Criterio de salida:** los modelos representan exclusivamente las seis entidades y respetan cardinalidades y restricciones documentadas.

### Fase 4 — Adaptación de Controladores

**Objetivo:** implementar los flujos definidos en los casos de uso sin reutilizar lógica comercial incompatible.

**Actividades:**

1. Adaptar login, cierre de sesión y administración de usuarios.
2. Ajustar Categorías y Productos.
3. Incorporar consulta de Inventario y búsqueda interna de productos.
4. Incorporar registro de Entradas y Salidas.
5. Incorporar consulta de Movimientos.
6. Incorporar gestión básica de Proveedores dentro del alcance aprobado.
7. Reemplazar métricas del Dashboard.
8. Aplicar validación de permisos y consistencia en cada operación.

**Entregables:** flujos funcionales internos alineados con CU-01 a CU-10 y con las reglas RN-001 a RN-030.

**Criterio de salida:** cada caso de uso puede ejecutarse por el actor autorizado y las operaciones rechazadas no producen cambios parciales.

### Fase 5 — Adaptación de Interfaces

**Objetivo:** transformar la experiencia visual en una herramienta interna de inventario responsiva y coherente.

**Actividades:**

1. Adaptar layouts de autenticación y administración.
2. Rediseñar navegación por módulos y perfiles.
3. Ajustar formularios de Usuarios, Categorías y Productos.
4. Crear vistas de Inventario, Entradas, Salidas, Movimientos y Proveedores.
5. Sustituir el Dashboard comercial por indicadores reales.
6. Eliminar recursos visuales y scripts del catálogo público.
7. Revisar accesibilidad, mensajes de validación y adaptación móvil.

**Entregables:** interfaz SuperStock completa, responsiva y sin elementos de SnackConnect.

**Criterio de salida:** Administrador y Empleado visualizan solo funciones autorizadas y pueden completar sus procesos en escritorio y móvil.

### Fase 6 — Integración

**Objetivo:** conectar capas, migrar datos controlados y verificar el funcionamiento conjunto.

**Actividades:**

1. Integrar rutas, middleware, controladores, modelos y vistas.
2. Ejecutar la transición de datos en un entorno de prueba.
3. Crear y conciliar saldos iniciales.
4. Validar permisos de Administrador y Empleado.
5. Confirmar que las métricas del Dashboard coinciden con el inventario.
6. Revisar logs, mensajes y comportamiento ante errores.
7. Verificar ausencia de referencias a componentes eliminados.

**Entregables:** versión integrada, informe de conciliación y registro de incidencias.

**Criterio de salida:** las existencias coinciden con los movimientos, no existen dependencias rotas y los diez casos de uso operan de extremo a extremo.

### Fase 7 — Pruebas

**Objetivo:** demostrar que SuperStock cumple los requisitos y conserva la integridad del inventario.

**Actividades:**

1. Ejecutar pruebas de autenticación, sesión, roles y permisos.
2. Probar administración de Usuarios, Categorías y Productos.
3. Probar búsqueda y consulta de inventario.
4. Probar Entradas y Salidas válidas e inválidas.
5. Verificar rechazo de saldos negativos.
6. Verificar trazabilidad e inmutabilidad de movimientos.
7. Probar correcciones mediante movimientos compensatorios.
8. Ejecutar pruebas de concurrencia sobre salidas.
9. Validar indicadores del Dashboard contra datos conocidos.
10. Ejecutar pruebas responsivas y de regresión.
11. Confirmar que carrito, checkout, pedidos, WhatsApp y área cliente no son accesibles.
12. Documentar evidencias, incidencias y correcciones.

**Entregables:** informe de pruebas, evidencias, matriz de trazabilidad y acta de aceptación técnica.

**Criterio de salida:** no existen defectos críticos abiertos y todas las reglas de negocio prioritarias cuentan con evidencia de cumplimiento.

## 14. Conclusiones

Reutilizar SnackConnect representa una estrategia eficiente porque conserva una base Laravel operativa, una arquitectura MVC conocida, autenticación por sesiones, componentes responsivos, validaciones y una estructura administrativa que ya resolvió parte importante de la infraestructura transversal.

El beneficio depende de aplicar una adaptación selectiva. Conservar indiscriminadamente el código heredado trasladaría al nuevo sistema dependencias de clientes, pedidos, carrito y WhatsApp que contradicen el dominio de SuperStock. La clasificación entre reutilizar, modificar, eliminar y crear permite aprovechar lo valioso sin perpetuar responsabilidades incorrectas.

La planificación por fases reduce riesgos al separar limpieza, persistencia, modelos, controladores, interfaz, integración y pruebas. Los respaldos, la migración controlada de roles, la creación de movimientos de apertura y la conciliación del stock protegen la integridad de los datos durante la transición.

En conjunto, esta estrategia disminuye el tiempo de desarrollo frente a una construcción desde cero, mantiene la trazabilidad con la documentación aprobada y proporciona puntos de verificación antes de cada cambio irreversible. Su aplicación disciplinada permitirá convertir SnackConnect en SuperStock sin comprometer la calidad del sistema ni ampliar indebidamente su alcance.
