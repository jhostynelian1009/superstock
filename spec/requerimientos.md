# Requerimientos de SuperStock

## 1. Propósito

Este documento es la fuente oficial de requisitos funcionales, no funcionales y reglas de negocio de SuperStock. Los flujos detallados se especifican en [casos_de_uso.md](casos_de_uso.md) y los módulos referencian estos códigos sin repetir su contenido.

## 2. Actores y permisos

| Capacidad | Administrador | Empleado |
|---|:---:|:---:|
| Iniciar y cerrar sesión | Sí | Sí |
| Consultar Dashboard | Sí | Sí |
| Gestionar usuarios y permisos | Sí | No |
| Gestionar categorías | Sí | No |
| Gestionar productos | Sí | No |
| Consultar y buscar productos | Sí | Sí |
| Gestionar proveedores | Sí | No |
| Consultar proveedores para una entrada | Sí | Sí |
| Consultar inventario y movimientos | Sí | Sí |
| Registrar entradas | Sí | Sí |
| Registrar salidas | Sí | Sí |
| Modificar directamente el stock | No | No |

## 3. Requerimientos funcionales

| Código | Requerimiento | Criterio de aceptación resumido | Caso de uso |
|---|---|---|---|
| **RF-001** | Autenticar usuarios internos. | Solo cuentas existentes y activas acceden; el sistema determina su rol. | CU-01 |
| **RF-002** | Finalizar la sesión. | La sesión queda invalidada y las áreas internas vuelven a exigir autenticación. | CU-02 |
| **RF-003** | Gestionar usuarios. | El Administrador crea, consulta, actualiza, activa y desactiva cuentas sin destruir historial. | CU-03 |
| **RF-004** | Gestionar categorías. | El Administrador mantiene categorías únicas y no elimina categorías relacionadas con productos. | CU-04 |
| **RF-005** | Gestionar productos. | El Administrador mantiene SKU, código de barras, categoría, unidad y estado sin editar stock. | CU-05 |
| **RF-006** | Buscar productos. | Los actores localizan productos por nombre, SKU, código de barras o categoría. | CU-10 |
| **RF-007** | Gestionar proveedores. | El Administrador mantiene proveedores activos y conserva los relacionados con movimientos. | CU-11 |
| **RF-008** | Consultar inventario. | Los actores consultan existencia, stock mínimo y condición de abastecimiento sin modificar saldos. | CU-06 |
| **RF-009** | Registrar entradas. | Una entrada válida incrementa el saldo y crea un movimiento trazable como una sola operación. | CU-07 |
| **RF-010** | Registrar salidas. | Una salida válida disminuye el saldo sin permitir cantidades negativas. | CU-08 |
| **RF-011** | Consultar movimientos. | Los actores consultan el historial por producto, tipo, responsable, proveedor o período. | CU-06, CU-09 |
| **RF-012** | Consultar Dashboard. | Presenta totales, activos, stock bajo, agotados y movimientos recientes con datos reales. | CU-09 |
| **RF-013** | Aplicar permisos por rol. | El sistema oculta y bloquea operaciones no autorizadas, incluso ante acceso directo. | Todos |

## 4. Requerimientos no funcionales

| Código | Requerimiento | Criterio verificable |
|---|---|---|
| **RNF-001** | Seguridad de autenticación. | Contraseñas protegidas, sesión regenerada al autenticar, cierre invalidante y mensajes sin revelar credenciales. |
| **RNF-002** | Autorización. | Todas las rutas internas requieren sesión; las acciones administrativas verifican el rol. |
| **RNF-003** | Integridad transaccional. | Movimiento y actualización de saldo se confirman o revierten juntos. |
| **RNF-004** | Persistencia. | MySQL es el motor objetivo y las restricciones referenciales se aplican en la base de datos. |
| **RNF-005** | Rendimiento. | Listados paginados, consultas filtrables y ausencia de consultas repetitivas evitables en relaciones. |
| **RNF-006** | Usabilidad responsive. | Los flujos críticos son utilizables desde 360 px de ancho y mediante teclado. |
| **RNF-007** | Accesibilidad. | Contraste WCAG AA, labels visibles, foco perceptible y acciones con nombre accesible. |
| **RNF-008** | Mantenibilidad. | Arquitectura MVC, módulos cohesionados, validación centralizada y estilo PSR-12. |
| **RNF-009** | Pruebas. | Existen pruebas de autenticación, permisos, datos maestros, entradas, salidas, concurrencia e integridad. |
| **RNF-010** | Trazabilidad. | Cada movimiento conserva producto, usuario, tipo, cantidad, fecha y motivo. |
| **RNF-011** | Recuperación. | Antes de transformar datos heredados se dispone de respaldo verificable y procedimiento de reversión. |
| **RNF-012** | Consistencia temporal. | Fechas almacenadas de forma uniforme y presentadas en la zona horaria institucional. |

## 5. Reglas de negocio

### 5.1 Reglas generales

| Código | Regla | Módulos |
|---|---|---|
| **RN-001** | SuperStock es un sistema interno; no expone funciones operativas al público. | Todos |
| **RN-002** | Toda operación interna requiere una sesión autenticada y vigente. | Todos |
| **RN-003** | Los datos se validan antes de guardar; una operación inválida no produce cambios parciales. | Usuarios, Categorías, Productos, Proveedores, Entradas, Salidas |
| **RN-004** | Toda alteración conserva fecha, usuario responsable y tipo de acción. | Datos maestros, Inventario |

### 5.2 Login

| Código | Regla | Módulos |
|---|---|---|
| **RN-005** | El acceso solo se concede con credenciales válidas y mensajes de error genéricos. | Login |
| **RN-006** | Una cuenta inactiva o bloqueada no puede iniciar sesión. | Login, Usuarios |
| **RN-007** | Cerrar sesión invalida la sesión y exige una nueva autenticación. | Login |

### 5.3 Usuarios y permisos

| Código | Regla | Módulos |
|---|---|---|
| **RN-008** | El identificador de acceso de cada usuario es único. | Usuarios, Login |
| **RN-009** | Cada usuario opera únicamente con las funciones autorizadas para su rol. | Todos |
| **RN-010** | Un usuario con operaciones históricas se desactiva en lugar de eliminarse. | Usuarios, Movimientos |

### 5.4 Categorías

| Código | Regla | Módulos |
|---|---|---|
| **RN-011** | El nombre normalizado de la categoría es único. | Categorías, Productos |
| **RN-012** | Todo producto pertenece obligatoriamente a una categoría válida. | Categorías, Productos |
| **RN-013** | Una categoría con productos no puede eliminarse hasta reasignarlos o desactivarlos. | Categorías, Productos |

### 5.5 Productos

| Código | Regla | Módulos |
|---|---|---|
| **RN-014** | Cada producto tiene SKU único; el código de barras también es único cuando existe. | Productos, Inventario |
| **RN-015** | Nombre, SKU, categoría, unidad de control y estado son datos mínimos del producto. | Productos |
| **RN-016** | Valores cuantitativos son no negativos y respetan si la unidad admite fracciones. | Productos, Inventario, Movimientos |
| **RN-017** | Un producto con movimientos se desactiva en lugar de eliminarse. | Productos, Inventario |

### 5.6 Inventario

| Código | Regla | Módulos |
|---|---|---|
| **RN-018** | La existencia corresponde al saldo de entradas y salidas confirmadas. | Inventario, Movimientos |
| **RN-019** | El stock no se modifica desde la ficha del producto; solo mediante movimientos. | Productos, Inventario |
| **RN-020** | Ninguna operación puede producir una existencia inferior a cero. | Inventario, Salidas |
| **RN-021** | Hay stock bajo cuando la existencia es menor o igual al mínimo configurado. | Inventario, Dashboard |

### 5.7 Entradas

| Código | Regla | Módulos |
|---|---|---|
| **RN-022** | Toda entrada identifica producto, cantidad, fecha, origen o referencia y responsable; el proveedor es opcional. | Entradas, Proveedores |
| **RN-023** | Una entrada mayor que cero incrementa el saldo exactamente en la cantidad confirmada. | Entradas, Inventario |
| **RN-024** | Una entrada confirmada es inmutable; los errores se corrigen con un movimiento compensatorio. | Entradas, Movimientos |

### 5.8 Salidas

| Código | Regla | Módulos |
|---|---|---|
| **RN-025** | Toda salida identifica producto, cantidad, fecha, motivo o destino y responsable. | Salidas |
| **RN-026** | La cantidad de salida es mayor que cero y no supera la existencia disponible. | Salidas, Inventario |
| **RN-027** | Una salida confirmada reduce el saldo exactamente y es inmutable; se corrige mediante compensación. | Salidas, Movimientos |

### 5.9 Dashboard

| Código | Regla | Módulos |
|---|---|---|
| **RN-028** | Todos los indicadores proceden de datos vigentes; no se muestran cifras simuladas. | Dashboard |
| **RN-029** | El Dashboard muestra productos registrados y activos, stock bajo o agotado y movimientos recientes. | Dashboard, Inventario |
| **RN-030** | El Dashboard es informativo y no modifica existencias. | Dashboard |

## 6. Restricciones globales

- No existe registro público de usuarios ni administradores.
- Solo el Administrador gestiona usuarios, categorías, productos y proveedores.
- El Empleado puede consultar y registrar movimientos, pero no administrar permisos.
- Las existencias se almacenan en `inventories`, nunca en `products`.
- Los movimientos confirmados no se eliminan ni alteran en producto, tipo o cantidad.
- Las correcciones utilizan movimientos compensatorios.
- La primera versión gestiona un inventario consolidado por producto.
- Las funciones heredadas de SnackConnect quedan fuera del alcance.

## 7. Trazabilidad resumida

| Requisito | Caso de uso | Reglas principales | Módulo |
|---|---|---|---|
| RF-001 | CU-01 | RN-001, RN-002, RN-005, RN-006, RN-008, RN-009 | Autenticación |
| RF-002 | CU-02 | RN-002, RN-007 | Autenticación |
| RF-003 | CU-03 | RN-003, RN-004, RN-008, RN-009, RN-010 | Usuarios |
| RF-004 | CU-04 | RN-003, RN-004, RN-011, RN-012, RN-013 | Categorías |
| RF-005 | CU-05 | RN-003, RN-004, RN-012, RN-014 a RN-019 | Productos |
| RF-006 | CU-10 | RN-009, RN-011, RN-012, RN-014, RN-017 | Productos |
| RF-007 | CU-11 | RN-003, RN-004, RN-009, RN-022, RN-024 | Proveedores |
| RF-008 | CU-06 | RN-018 a RN-021 | Inventario |
| RF-009 | CU-07 | RN-003, RN-004, RN-018, RN-022 a RN-024 | Entradas |
| RF-010 | CU-08 | RN-003, RN-004, RN-018 a RN-020, RN-025 a RN-027 | Salidas |
| RF-011 | CU-06, CU-09 | RN-004, RN-018, RN-024, RN-027 | Movimientos |
| RF-012 | CU-09 | RN-021, RN-028 a RN-030 | Dashboard |
| RF-013 | Todos | RN-002, RN-009 | Seguridad |

