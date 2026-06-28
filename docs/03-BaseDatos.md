# 1. Introducción

El presente documento define el diseño conceptual y lógico de la base de datos del Sistema Web de Gestión de Inventario para Supermercados **SuperStock**. El diseño se deriva del alcance funcional establecido en `05-CasosDeUso.md`, de las disposiciones contenidas en `06-ReglasNegocio.md` y del modelo conceptual aprobado para el proyecto.

La base de datos constituye el núcleo de persistencia de SuperStock. Su responsabilidad es conservar los usuarios autorizados, la clasificación y definición de los productos, los proveedores, las existencias vigentes y el historial de movimientos que explica cada variación del inventario.

El modelo está orientado a MySQL y se documenta con independencia de una implementación concreta en Laravel. En esta etapa no se establecen migraciones, modelos Eloquent, scripts SQL ni detalles de programación. El documento servirá posteriormente como insumo para el Modelo Entidad-Relación, el diseño físico y el desarrollo del sistema.

# 2. Objetivo

Documentar de forma completa, coherente y justificable el diseño lógico de la base de datos de SuperStock, asegurando que cada entidad y relación responda a una necesidad funcional aprobada.

Los objetivos específicos son:

- Identificar las entidades de negocio y delimitar sus responsabilidades.
- Definir atributos, identificadores, relaciones y restricciones lógicas.
- Establecer un diccionario de datos previo al diseño físico.
- Garantizar integridad de entidad, integridad referencial y validez de dominio.
- Demostrar el cumplimiento de Primera, Segunda y Tercera Forma Normal.
- Separar los datos maestros de los saldos y movimientos de inventario.
- Proporcionar una base estable para el MER, las migraciones, los modelos y las pruebas futuras.

# 3. Alcance

El modelo de negocio de la primera versión está compuesto exclusivamente por las siguientes seis entidades aprobadas:

1. `Users`
2. `Categories`
3. `Products`
4. `Suppliers`
5. `Inventories`
6. `Inventory_Movements`

El alcance contempla:

- Autenticación de Administradores y Empleados.
- Clasificación y mantenimiento de productos.
- Consulta de existencias.
- Registro trazable de entradas y salidas.
- Asociación opcional de proveedores con movimientos de entrada.
- Obtención de indicadores reales para el Dashboard.

Quedan fuera del modelo de negocio:

- Comercio electrónico, clientes, carrito, checkout, pagos y pedidos por WhatsApp.
- Ventas, facturación y órdenes de compra.
- Sucursales y bodegas múltiples en la primera versión.
- Tablas técnicas del framework, como sesiones, caché, colas o recuperación de contraseñas.
- Entidades no justificadas por las reglas de negocio, los casos de uso o el modelo conceptual aprobado.

`Suppliers` se incorpora porque forma parte expresa del modelo aprobado y permite identificar el origen de futuras entradas. Su mantenimiento funcional completo deberá formalizarse mediante un caso de uso propio antes de implementarse; este documento no añade dicho caso de uso.

# 4. Criterios de Diseño

## 4.1 Simplicidad

El modelo utiliza únicamente las seis entidades aprobadas. No se crean tablas para conceptos que pueden representarse correctamente mediante atributos o dominios controlados, como los roles de usuario o los tipos de movimiento.

Cada entidad posee una responsabilidad principal:

- `Users` identifica a los actores internos.
- `Categories` clasifica productos.
- `Products` conserva datos maestros.
- `Suppliers` identifica fuentes de abastecimiento.
- `Inventories` conserva saldos físicos.
- `Inventory_Movements` explica cada variación de dichos saldos.

## 4.2 Separación de responsabilidades

Los datos maestros del producto no se mezclan con la existencia física. `Products` describe qué es el artículo, mientras `Inventories` representa cuántas unidades existen y cuál es su nivel mínimo de control.

Del mismo modo, `Inventory_Movements` no reemplaza al saldo operativo: conserva el historial de entradas y salidas que permite explicar y conciliar el valor registrado en `Inventories`.

## 4.3 Integridad referencial

Las asociaciones entre entidades deberán mantenerse mediante referencias válidas. No podrá existir un producto sin categoría, un inventario sin producto ni un movimiento sin producto y usuario responsable.

Las eliminaciones que comprometan información histórica deberán restringirse. En esos casos se utilizará la desactivación lógica del registro maestro, conforme a las reglas de negocio.

## 4.4 Trazabilidad

Cada movimiento deberá conservar su tipo, cantidad, fecha efectiva, motivo, producto y usuario responsable. Los movimientos confirmados serán históricos e inmutables. Una corrección se representará mediante un nuevo movimiento compensatorio, nunca mediante la alteración o eliminación del original.

## 4.5 Normalización

El diseño evita grupos repetitivos, dependencias parciales y dependencias transitivas. Los datos descriptivos de categorías, productos, proveedores y usuarios se conservan una sola vez en su entidad correspondiente y se referencian desde las demás entidades.

## 4.6 Escalabilidad

La separación entre producto, inventario y movimiento permite extender el sistema hacia múltiples ubicaciones sin redefinir el concepto de producto ni perder el historial. Las ampliaciones futuras deberán agregar las referencias necesarias sin trasladar las existencias a `Products`.

## 4.7 Mantenibilidad

Los nombres de entidades y atributos deberán conservar significado funcional, consistencia y ausencia de ambigüedad. Las restricciones críticas deberán aplicarse de manera uniforme en cualquier interfaz que opere sobre los mismos datos.

## 4.8 Coherencia funcional

Toda decisión del modelo se vincula con un proceso o regla aprobada. En especial:

- La autenticación y los permisos justifican `Users`.
- La clasificación obligatoria justifica `Categories`.
- La identificación única justifica `Products`.
- El origen de abastecimiento justifica `Suppliers`.
- La consulta del stock justifica `Inventories`.
- Las entradas, salidas y la trazabilidad justifican `Inventory_Movements`.

# 5. Modelo Conceptual

El modelo conceptual identifica las entidades relevantes del dominio y su significado, sin definir todavía tipos de datos ni decisiones de implementación.

## 5.1 Users

Representa a las personas autorizadas para utilizar SuperStock. Cada usuario posee una identidad de acceso, credenciales, un rol y un estado operativo.

Su existencia se justifica por los casos de uso de inicio y cierre de sesión, la administración de usuarios y la obligación de asociar cada movimiento con la persona que lo registró. Los roles aprobados son Administrador y Empleado.

Referencias funcionales principales: CU-01, CU-02, CU-03, RN-002, RN-004, RN-005, RN-006, RN-008, RN-009 y RN-010.

## 5.2 Categories

Representa la clasificación funcional de los productos del supermercado. Una categoría agrupa productos con características comunes y facilita su consulta, búsqueda y análisis.

Su existencia evita repetir el nombre y la descripción de una clasificación en cada producto. Todo producto deberá pertenecer a una categoría válida.

Referencias funcionales principales: CU-04, CU-05, CU-10, RN-011, RN-012 y RN-013.

## 5.3 Products

Representa el catálogo maestro interno de artículos controlados por SuperStock. Conserva la identidad, descripción, clasificación, unidad de control y estado del producto.

No almacena la existencia física. Esta separación evita mezclar la definición del artículo con un valor operativo que cambia continuamente por entradas y salidas.

Referencias funcionales principales: CU-05, CU-06, CU-07, CU-08, CU-10, RN-014, RN-015, RN-016, RN-017 y RN-019.

## 5.4 Suppliers

Representa a las personas naturales o jurídicas que abastecen productos al supermercado. Permite identificar, cuando corresponda, el proveedor relacionado con una entrada de inventario.

La entidad evita repetir información del proveedor en cada movimiento y prepara el modelo para ampliar la gestión de abastecimiento sin alterar la identidad de productos o usuarios.

Referencia funcional principal: origen o referencia de entrada establecido en CU-07 y RN-022, además de su aprobación expresa dentro del modelo conceptual.

## 5.5 Inventories

Representa el saldo físico vigente de cada producto y su nivel mínimo de control. En la primera versión existirá un único inventario por producto.

Su independencia respecto de `Products` es esencial para diferenciar información maestra de información operativa. También establece el punto de extensión para inventarios separados por sucursal o bodega en versiones futuras.

Referencias funcionales principales: CU-06, CU-07, CU-08, CU-09, RN-018, RN-019, RN-020 y RN-021.

## 5.6 Inventory_Movements

Representa el historial cronológico e inmutable de las entradas y salidas. Cada movimiento identifica el producto afectado, la cantidad, el tipo, la fecha, el motivo y el usuario responsable. En las entradas podrá asociarse un proveedor.

La entidad constituye el mecanismo principal de trazabilidad. Todo cambio del saldo deberá estar respaldado por un movimiento confirmado y nunca deberán eliminarse movimientos históricos.

Referencias funcionales principales: CU-07, CU-08, CU-09, RN-004, RN-018, RN-022, RN-023, RN-024, RN-025, RN-026 y RN-027.

# 6. Modelo Lógico

## 6.1 Entidad Users

**Nombre lógico:** `Users`

**Descripción:** almacena las cuentas internas autorizadas para autenticarse y operar en SuperStock.

**Atributos:**

- Identificador del usuario.
- Nombre completo.
- Correo electrónico de acceso.
- Contraseña protegida.
- Rol.
- Estado de la cuenta.
- Fecha de creación.
- Fecha de última actualización.

**Llave primaria:** identificador del usuario.

**Llaves foráneas:** no posee.

**Restricciones principales:**

- El correo electrónico deberá ser único.
- La contraseña nunca se almacenará en texto legible.
- El rol solo podrá ser Administrador o Empleado.
- Únicamente las cuentas activas podrán iniciar sesión.
- Un usuario con movimientos históricos deberá desactivarse en lugar de eliminarse.

**Relaciones:** un usuario puede registrar muchos movimientos de inventario; cada movimiento pertenece a un único usuario.

## 6.2 Entidad Categories

**Nombre lógico:** `Categories`

**Descripción:** almacena las clasificaciones utilizadas para organizar los productos.

**Atributos:**

- Identificador de la categoría.
- Nombre.
- Descripción.
- Fecha de creación.
- Fecha de última actualización.

**Llave primaria:** identificador de la categoría.

**Llaves foráneas:** no posee.

**Restricciones principales:**

- El nombre normalizado deberá ser único.
- El nombre será obligatorio.
- Una categoría asociada con productos no podrá eliminarse mientras existan dichas asociaciones.

**Relaciones:** una categoría puede clasificar muchos productos; cada producto pertenece obligatoriamente a una categoría.

## 6.3 Entidad Products

**Nombre lógico:** `Products`

**Descripción:** almacena la información maestra de los productos controlados por el sistema, sin incluir existencias físicas.

**Atributos:**

- Identificador del producto.
- Identificador de la categoría.
- Código interno o SKU.
- Código de barras, cuando exista.
- Nombre.
- Descripción.
- Unidad de control.
- Estado del producto.
- Fecha de creación.
- Fecha de última actualización.

**Llave primaria:** identificador del producto.

**Llaves foráneas:** identificador de la categoría, con referencia obligatoria a `Categories`.

**Restricciones principales:**

- El SKU deberá ser único y obligatorio.
- El código de barras, cuando se registre, deberá ser único.
- El nombre, la categoría y la unidad de control serán obligatorios.
- Un producto con movimientos históricos deberá desactivarse en lugar de eliminarse.
- La existencia no podrá registrarse ni modificarse en esta entidad.

**Relaciones:**

- Cada producto pertenece a una categoría.
- Cada producto posee un único inventario en la primera versión.
- Cada producto puede tener muchos movimientos de inventario.

## 6.4 Entidad Suppliers

**Nombre lógico:** `Suppliers`

**Descripción:** almacena la identificación y los datos básicos de los proveedores que pueden asociarse con entradas de inventario.

**Atributos:**

- Identificador del proveedor.
- Nombre o razón social.
- Identificación tributaria, cuando corresponda.
- Nombre de contacto.
- Teléfono.
- Correo electrónico.
- Estado del proveedor.
- Fecha de creación.
- Fecha de última actualización.

**Llave primaria:** identificador del proveedor.

**Llaves foráneas:** no posee.

**Restricciones principales:**

- El nombre o razón social será obligatorio.
- La identificación tributaria, cuando se registre, deberá ser única.
- El correo deberá cumplir un formato válido cuando sea proporcionado.
- Un proveedor relacionado con movimientos históricos deberá desactivarse en lugar de eliminarse.

**Relaciones:** un proveedor puede asociarse con muchos movimientos; cada movimiento puede tener como máximo un proveedor.

## 6.5 Entidad Inventories

**Nombre lógico:** `Inventories`

**Descripción:** almacena la existencia vigente y el nivel mínimo de control correspondiente a cada producto.

**Atributos:**

- Identificador del inventario.
- Identificador del producto.
- Existencia actual.
- Stock mínimo.
- Fecha de creación.
- Fecha de última actualización.

**Llave primaria:** identificador del inventario.

**Llaves foráneas:** identificador del producto, con referencia obligatoria a `Products`.

**Restricciones principales:**

- El identificador del producto deberá ser único dentro de esta entidad durante la primera versión.
- La existencia actual y el stock mínimo serán mayores o iguales a cero.
- Al habilitar un producto para control de inventario deberá existir su registro de inventario con saldo inicial igual a cero, salvo que una entrada inicial confirmada establezca el saldo.
- El saldo solo podrá variar mediante movimientos de entrada o salida confirmados.

**Relaciones:** cada inventario pertenece a un solo producto y cada producto posee exactamente un inventario en la primera versión.

## 6.6 Entidad Inventory_Movements

**Nombre lógico:** `Inventory_Movements`

**Descripción:** almacena el historial de entradas y salidas que incrementan o disminuyen las existencias.

**Atributos:**

- Identificador del movimiento.
- Identificador del producto.
- Identificador del usuario responsable.
- Identificador del proveedor, cuando corresponda.
- Tipo de movimiento.
- Cantidad.
- Fecha y hora efectiva del movimiento.
- Motivo, origen o destino.
- Referencia documental opcional.
- Fecha y hora de registro en el sistema.

**Llave primaria:** identificador del movimiento.

**Llaves foráneas:**

- Identificador del producto, con referencia obligatoria a `Products`.
- Identificador del usuario, con referencia obligatoria a `Users`.
- Identificador del proveedor, con referencia opcional a `Suppliers`.

**Restricciones principales:**

- El tipo solo podrá ser Entrada o Salida.
- La cantidad deberá ser mayor que cero y compatible con la unidad de control del producto.
- Una salida no podrá superar la existencia disponible.
- El proveedor solo podrá asociarse cuando resulte aplicable al origen de una entrada; no será obligatorio para todas las entradas.
- Un movimiento confirmado no podrá eliminarse ni modificarse en sus datos esenciales.
- La confirmación del movimiento y la actualización del saldo deberán constituir una operación indivisible.

**Relaciones:**

- Cada movimiento pertenece a un producto; un producto puede tener muchos movimientos.
- Cada movimiento pertenece al usuario que lo registró; un usuario puede registrar muchos movimientos.
- Cada movimiento puede asociarse con un proveedor; un proveedor puede aparecer en muchos movimientos.

# 7. Diccionario de Datos

Los tipos que se presentan son sugerencias lógicas orientadas a MySQL. No constituyen instrucciones SQL ni una definición física definitiva. Las longitudes deberán validarse durante el diseño físico.

## 7.1 Diccionario de Users

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno del usuario. | Llave primaria; generado por el sistema; no reutilizable. |
| `name` | Cadena de hasta 150 caracteres | Sí | Nombre completo del usuario. | No admite valor vacío. |
| `email` | Cadena de hasta 255 caracteres | Sí | Identificador utilizado para el acceso. | Único; formato de correo válido; comparación normalizada. |
| `password` | Cadena de hasta 255 caracteres | Sí | Representación protegida de la contraseña. | Debe contener únicamente el resultado del mecanismo de protección; nunca texto legible. |
| `role` | Cadena controlada de hasta 20 caracteres | Sí | Perfil funcional asignado. | Valores permitidos: Administrador o Empleado. |
| `is_active` | Booleano | Sí | Indica si la cuenta puede acceder al sistema. | Valor inicial activo; una cuenta inactiva no puede autenticarse. |
| `created_at` | Fecha y hora | Sí | Momento de creación de la cuenta. | Registrado por el sistema. |
| `updated_at` | Fecha y hora | Sí | Momento de la última actualización. | Registrado por el sistema. |

## 7.2 Diccionario de Categories

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno de la categoría. | Llave primaria; generado por el sistema; no reutilizable. |
| `name` | Cadena de hasta 120 caracteres | Sí | Nombre de la clasificación. | Único después de normalizar mayúsculas, minúsculas y espacios. |
| `description` | Cadena de hasta 500 caracteres | No | Explicación breve del contenido de la categoría. | No debe sustituir atributos propios del producto. |
| `created_at` | Fecha y hora | Sí | Momento de creación. | Registrado por el sistema. |
| `updated_at` | Fecha y hora | Sí | Momento de la última actualización. | Registrado por el sistema. |

## 7.3 Diccionario de Products

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno del producto. | Llave primaria; generado por el sistema; no reutilizable. |
| `category_id` | Entero grande positivo | Sí | Categoría a la que pertenece el producto. | Llave foránea válida hacia `Categories`. |
| `sku` | Cadena de hasta 60 caracteres | Sí | Código interno único del producto. | Único; no admite valor vacío. |
| `barcode` | Cadena de hasta 50 caracteres | No | Código de barras comercial. | Único cuando se registra; se conserva como texto para no perder ceros iniciales. |
| `name` | Cadena de hasta 180 caracteres | Sí | Nombre del producto. | No admite valor vacío. |
| `description` | Texto | No | Descripción complementaria del producto. | No debe contener datos de existencia. |
| `unit_of_measure` | Cadena controlada de hasta 30 caracteres | Sí | Unidad utilizada para contabilizar cantidades. | Determina si admite cantidades enteras o fraccionarias. |
| `is_active` | Booleano | Sí | Indica si el producto admite nuevos movimientos. | Los productos con historial se desactivan en lugar de eliminarse. |
| `created_at` | Fecha y hora | Sí | Momento de creación. | Registrado por el sistema. |
| `updated_at` | Fecha y hora | Sí | Momento de la última actualización. | Registrado por el sistema. |

## 7.4 Diccionario de Suppliers

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno del proveedor. | Llave primaria; generado por el sistema; no reutilizable. |
| `business_name` | Cadena de hasta 180 caracteres | Sí | Nombre o razón social del proveedor. | No admite valor vacío. |
| `tax_identifier` | Cadena de hasta 30 caracteres | No | Identificación tributaria o institucional. | Única cuando se registra. |
| `contact_name` | Cadena de hasta 150 caracteres | No | Persona principal de contacto. | Información descriptiva. |
| `phone` | Cadena de hasta 30 caracteres | No | Número de contacto. | Debe respetar el formato institucional definido. |
| `email` | Cadena de hasta 255 caracteres | No | Correo de contacto. | Formato de correo válido cuando se registra. |
| `is_active` | Booleano | Sí | Indica si el proveedor puede seleccionarse en nuevas operaciones. | Los proveedores con historial se desactivan en lugar de eliminarse. |
| `created_at` | Fecha y hora | Sí | Momento de creación. | Registrado por el sistema. |
| `updated_at` | Fecha y hora | Sí | Momento de la última actualización. | Registrado por el sistema. |

## 7.5 Diccionario de Inventories

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno del inventario. | Llave primaria; generado por el sistema; no reutilizable. |
| `product_id` | Entero grande positivo | Sí | Producto cuyo saldo se controla. | Llave foránea hacia `Products`; único en la primera versión. |
| `current_stock` | Decimal de precisión 14 y escala 3 | Sí | Existencia física vigente del producto. | Mayor o igual a cero; valor inicial cero; solo varía mediante movimientos confirmados. |
| `minimum_stock` | Decimal de precisión 14 y escala 3 | Sí | Nivel a partir del cual el producto se considera con stock bajo. | Mayor o igual a cero; coherente con la unidad de control. |
| `created_at` | Fecha y hora | Sí | Momento de creación del saldo. | Registrado por el sistema. |
| `updated_at` | Fecha y hora | Sí | Momento de la última variación del saldo o del mínimo. | Registrado por el sistema. |

## 7.6 Diccionario de Inventory_Movements

| Campo | Tipo de dato sugerido | Obligatorio | Descripción | Restricciones |
|---|---|---:|---|---|
| `id` | Entero grande positivo | Sí | Identificador interno del movimiento. | Llave primaria; generado por el sistema; no reutilizable. |
| `product_id` | Entero grande positivo | Sí | Producto afectado por el movimiento. | Llave foránea válida hacia `Products`. |
| `user_id` | Entero grande positivo | Sí | Usuario responsable del registro. | Llave foránea válida hacia `Users`; la referencia histórica debe conservarse. |
| `supplier_id` | Entero grande positivo | No | Proveedor asociado al origen de una entrada. | Llave foránea hacia `Suppliers`; nulo cuando no corresponda; no aplicable a salidas. |
| `movement_type` | Cadena controlada de hasta 10 caracteres | Sí | Sentido del movimiento. | Valores permitidos: Entrada o Salida. |
| `quantity` | Decimal de precisión 14 y escala 3 | Sí | Cantidad que incrementa o disminuye la existencia. | Mayor que cero; compatible con la unidad del producto. |
| `occurred_at` | Fecha y hora | Sí | Fecha y hora efectiva del movimiento. | No puede quedar indefinida. |
| `reason` | Cadena de hasta 255 caracteres | Sí | Motivo, origen o destino que justifica el movimiento. | No admite valor vacío. |
| `reference` | Cadena de hasta 100 caracteres | No | Referencia documental o administrativa relacionada. | No reemplaza el identificador único del movimiento. |
| `created_at` | Fecha y hora | Sí | Momento en que el movimiento fue confirmado en el sistema. | Registrado por el sistema; permite auditar diferencias frente a `occurred_at`. |

# 8. Relaciones

## 8.1 Categories — Products

**Cardinalidad:** una categoría se relaciona con cero o muchos productos; cada producto se relaciona obligatoriamente con una sola categoría.

**Justificación:** la relación implementa la clasificación obligatoria definida para los productos y evita repetir la información de la categoría en cada registro.

**Participación:** opcional para `Categories`, porque puede existir una categoría todavía sin productos; obligatoria para `Products`.

**Regla de conservación:** una categoría con productos asociados no podrá eliminarse hasta que los productos sean reasignados o tratados según las reglas del sistema.

## 8.2 Products — Inventories

**Cardinalidad:** uno a uno en la primera versión. Cada producto posee un inventario y cada inventario corresponde a un único producto.

**Justificación:** la relación separa el catálogo maestro del saldo físico. El producto puede cambiar de descripción o estado sin confundir esos cambios con una entrada o salida.

**Participación:** obligatoria para todo producto habilitado para control de inventario. El saldo inicial será cero hasta que exista una entrada confirmada.

**Regla de unicidad:** `product_id` será único en `Inventories` mientras el sistema maneje una sola ubicación de inventario.

## 8.3 Products — Inventory_Movements

**Cardinalidad:** un producto puede tener cero o muchos movimientos; cada movimiento pertenece a un único producto.

**Justificación:** las entradas y salidas deben identificar de forma inequívoca el artículo cuyo saldo se modifica. La relación permite reconstruir y auditar el historial de cada producto.

**Participación:** opcional para `Products`, porque un producto recién creado puede no tener movimientos; obligatoria para `Inventory_Movements`.

**Regla de conservación:** un producto con movimientos no podrá eliminarse físicamente. Su identificación deberá permanecer disponible para interpretar el historial.

## 8.4 Users — Inventory_Movements

**Cardinalidad:** un usuario puede registrar cero o muchos movimientos; cada movimiento pertenece a un único usuario responsable.

**Justificación:** responde a la obligación de trazabilidad y permite determinar quién ejecutó cada entrada o salida.

**Participación:** opcional para `Users`, porque un usuario puede no haber registrado movimientos; obligatoria para `Inventory_Movements`.

**Regla de conservación:** los usuarios con movimientos deberán desactivarse en lugar de eliminarse.

## 8.5 Suppliers — Inventory_Movements

**Cardinalidad:** un proveedor puede asociarse con cero o muchos movimientos; cada movimiento puede asociarse con cero o un proveedor.

**Justificación:** permite identificar una fuente de abastecimiento sin duplicar sus datos en cada entrada. La asociación es opcional porque RN-022 exige un origen o referencia, pero no obliga a que toda entrada proceda de un proveedor registrado.

**Participación:** opcional en ambos extremos. Para una salida, la referencia al proveedor deberá permanecer vacía.

**Regla de conservación:** un proveedor con movimientos históricos deberá desactivarse en lugar de eliminarse.

## 8.6 Coordinación entre Inventories e Inventory_Movements

El modelo conceptual aprobado no establece una relación directa entre estas dos entidades. Ambas se coordinan mediante el producto:

- `Inventories` conserva el saldo vigente del producto.
- `Inventory_Movements` conserva las operaciones que explican sus variaciones.

Cuando se confirme una entrada o salida, el movimiento y la actualización del inventario del mismo producto deberán aplicarse como una unidad indivisible. La suma histórica de entradas menos salidas deberá ser conciliable con `current_stock`.

# 9. Reglas de Integridad

## 9.1 Integridad de entidad

- Cada entidad tendrá una llave primaria obligatoria, única, estable y no reutilizable.
- Ninguna llave primaria podrá ser nula.
- La identidad de un registro histórico no deberá cambiar después de su creación.
- Los movimientos confirmados conservarán permanentemente su identificador.

## 9.2 Integridad referencial

- `Products.category_id` deberá corresponder a una categoría existente.
- `Inventories.product_id` deberá corresponder a un producto existente.
- `Inventory_Movements.product_id` deberá corresponder a un producto existente.
- `Inventory_Movements.user_id` deberá corresponder a un usuario existente.
- `Inventory_Movements.supplier_id`, cuando tenga valor, deberá corresponder a un proveedor existente.
- No se permitirá eliminar categorías, productos, usuarios o proveedores cuando ello deje referencias históricas o funcionales inválidas.
- Las relaciones históricas no deberán resolverse mediante eliminaciones en cascada que destruyan movimientos.

## 9.3 Restricciones de unicidad

- El correo electrónico del usuario será único.
- El nombre normalizado de la categoría será único.
- El SKU del producto será único.
- El código de barras será único cuando se registre.
- La identificación tributaria del proveedor será única cuando se registre.
- Un producto solo podrá tener un registro en `Inventories` durante la primera versión.

## 9.4 Restricciones de dominio

- `Users.role` solo aceptará Administrador o Empleado.
- Los estados de usuarios, productos y proveedores serán valores booleanos válidos.
- `Inventory_Movements.movement_type` solo aceptará Entrada o Salida.
- Las cantidades de movimiento deberán ser mayores que cero.
- `current_stock` y `minimum_stock` deberán ser mayores o iguales a cero.
- Las cantidades deberán respetar si la unidad de control admite o no fracciones.
- Los correos deberán cumplir un formato válido.
- Las fechas obligatorias deberán representar valores temporales válidos y coherentes.

## 9.5 Restricciones de negocio

- Solo los usuarios activos podrán iniciar sesión.
- El Empleado no podrá administrar usuarios ni modificar datos reservados al Administrador.
- Todo producto deberá pertenecer a una categoría.
- La existencia no podrá almacenarse ni editarse en `Products`.
- Toda variación de `current_stock` deberá estar respaldada por un movimiento confirmado.
- Una entrada incrementará el saldo exactamente en la cantidad registrada.
- Una salida disminuirá el saldo exactamente en la cantidad registrada.
- Una salida no podrá producir existencias negativas.
- Los movimientos confirmados serán inmutables y no podrán eliminarse.
- Las correcciones se realizarán mediante movimientos compensatorios.
- El proveedor será opcional en una entrada y no corresponderá a una salida.
- El Dashboard deberá calcular sus indicadores a partir de datos reales de estas entidades.

## 9.6 Coherencia del saldo

`Inventories.current_stock` constituye el saldo operativo de consulta inmediata. `Inventory_Movements` constituye el historial explicativo. Ambos valores deberán mantenerse coherentes bajo la siguiente regla conceptual:

**Existencia vigente = total de entradas confirmadas − total de salidas confirmadas**

El almacenamiento del saldo vigente es una materialización controlada para facilitar consultas operativas. No autoriza actualizaciones directas ni reemplaza el historial de movimientos.

# 10. Normalización

## 10.1 Primera Forma Normal — 1FN

El modelo cumple 1FN porque:

- Cada entidad posee una llave primaria que identifica de forma única sus registros.
- Cada atributo contiene un valor atómico y no una lista de elementos.
- No existen grupos repetitivos dentro de una misma fila.
- Los productos, categorías, proveedores, usuarios y movimientos se registran individualmente.
- Un movimiento representa un solo producto, un solo tipo y una sola cantidad.

Si en el futuro un proveedor requiriera múltiples contactos o teléfonos, dicha ampliación deberá modelarse separadamente; no se almacenarán listas dentro de un solo atributo.

## 10.2 Segunda Forma Normal — 2FN

El modelo cumple 2FN porque:

- Todas las entidades utilizan una llave primaria simple.
- Cada atributo no clave depende por completo de la llave primaria de su entidad.
- Los datos del producto dependen del producto y no de la categoría.
- Los datos del proveedor dependen del proveedor y no del movimiento.
- La cantidad, tipo, fecha y motivo dependen del movimiento completo identificado por su llave primaria.

Al no existir llaves primarias compuestas en la primera versión, no pueden presentarse dependencias parciales respecto de una parte de la llave.

## 10.3 Tercera Forma Normal — 3FN

El modelo cumple 3FN porque:

- Los atributos no clave dependen de la llave primaria y no de otros atributos no clave.
- `Products` conserva la referencia a la categoría, pero no duplica su nombre o descripción.
- `Inventory_Movements` conserva referencias a producto, usuario y proveedor, pero no duplica sus datos descriptivos.
- `Inventories` conserva únicamente información propia del saldo y no repite datos maestros del producto.
- `Products` no conserva la existencia ni totales derivados de movimientos.
- No se almacenan nombres de usuario, categoría o proveedor dentro de los movimientos.

`current_stock` es un saldo operativo materializado y controlado, no una dependencia transitiva respecto de otro atributo de `Inventories`. Su coherencia se garantiza mediante la regla que obliga a modificarlo únicamente junto con un movimiento confirmado. El historial continúa siendo la fuente de trazabilidad y conciliación.

# 11. Escalabilidad

## 11.1 Múltiples sucursales y bodegas

La separación de `Inventories` respecto de `Products` permite evolucionar desde un inventario único por producto hacia inventarios por ubicación. En una versión futura podrá incorporarse el concepto de ubicación y asociarlo tanto con los saldos como con los movimientos.

La responsabilidad de las entidades actuales no cambia:

- `Products` seguirá describiendo el artículo.
- `Inventories` seguirá representando un saldo físico, aunque exista uno por producto y ubicación.
- `Inventory_Movements` seguirá explicando las variaciones, incorporando la ubicación afectada.

Estas posibles entidades o referencias futuras no forman parte del modelo actual.

## 11.2 Auditoría

Los campos temporales, el usuario responsable y la inmutabilidad de movimientos proporcionan una base de auditoría funcional. Una ampliación podrá incorporar un registro de cambios administrativos sin alterar la identidad ni las relaciones principales de productos, inventarios y movimientos.

## 11.3 Reportes

El historial estructurado permite elaborar reportes por producto, categoría, usuario, proveedor, tipo de movimiento y período. Los reportes deberán derivarse de las entidades existentes y no requerir duplicar datos operativos en tablas del modelo principal.

## 11.4 Proveedores adicionales

La relación uno a muchos permite incorporar nuevos proveedores sin modificar los movimientos existentes. Cada movimiento conservará su referencia original y la desactivación de un proveedor no afectará el historial.

## 11.5 Crecimiento del volumen

Las llaves estables, las relaciones explícitas y la separación de datos maestros y transaccionales permiten optimizar posteriormente búsquedas, filtros y reportes sin rediseñar el dominio. Las decisiones de índices y particionamiento corresponderán al diseño físico, no a este documento lógico.

# 12. Justificación del Diseño

## 12.1 Justificación de las seis entidades

El modelo utiliza únicamente seis entidades porque cada una responde a una necesidad funcional distinta e irreducible:

- `Users` habilita autenticación, autorización y responsabilidad sobre movimientos.
- `Categories` evita duplicar clasificaciones y garantiza organización consistente.
- `Products` identifica los artículos controlados.
- `Suppliers` normaliza la información sobre posibles fuentes de entrada.
- `Inventories` conserva saldos físicos independientes del catálogo.
- `Inventory_Movements` conserva la historia de entradas y salidas.

Eliminar cualquiera de estas entidades obligaría a perder trazabilidad, mezclar responsabilidades o repetir información. Incorporar otras entidades en esta versión excedería los casos de uso y reglas aprobados.

## 12.2 Razón para no almacenar existencias en Products

La existencia es un dato operativo y variable; el nombre, SKU, categoría y unidad son datos maestros relativamente estables. Almacenar ambos conceptos en `Products` produciría un acoplamiento innecesario entre el mantenimiento del catálogo y el control físico.

La separación evita que la edición de un producto pueda alterar accidentalmente su saldo y permite que futuras ubicaciones mantengan existencias independientes para el mismo artículo.

## 12.3 Razón para utilizar Inventories

`Inventories` proporciona un lugar explícito para el saldo vigente y el stock mínimo. La relación uno a uno satisface la primera versión, en la que existe un único inventario por producto, sin cerrar la posibilidad de evolucionar a varios saldos por ubicación.

Esta entidad también permite aplicar de forma central las reglas de existencia no negativa, stock bajo y prohibición de edición directa desde el producto.

## 12.4 Razón para utilizar Inventory_Movements

Un saldo por sí solo indica cuánto existe, pero no explica por qué existe esa cantidad. `Inventory_Movements` registra quién realizó el cambio, cuándo ocurrió, qué producto fue afectado, cuál fue la cantidad y qué motivo justificó la operación.

La inmutabilidad de los movimientos permite reconstruir la secuencia histórica, detectar diferencias y realizar conciliaciones. Los errores no se ocultan modificando el pasado; se corrigen mediante movimientos compensatorios verificables.

## 12.5 Razón para mantener Suppliers separado

Los datos de un proveedor pueden participar en múltiples entradas. Mantenerlos en una entidad independiente evita repetir nombres, identificaciones y contactos en cada movimiento, reduce inconsistencias y permite conservar una referencia estable aun cuando el proveedor deje de estar activo.

# 13. Conclusiones

El diseño propuesto proporciona una base lógica simple, normalizada y alineada con los procesos aprobados de SuperStock. Las seis entidades poseen responsabilidades claramente diferenciadas y relaciones justificadas por los casos de uso y reglas de negocio.

La separación entre `Products`, `Inventories` e `Inventory_Movements` constituye la decisión central del modelo. Permite conservar un catálogo maestro estable, consultar saldos de forma eficiente y mantener un historial completo que respalde cada variación de existencias.

Las restricciones de identidad, referencia, unicidad, dominio e inmutabilidad protegen la calidad de los datos y reducen el riesgo de saldos negativos, registros huérfanos o pérdida de trazabilidad. El cumplimiento de 3FN evita redundancias innecesarias, mientras la materialización controlada del saldo responde a las necesidades operativas del sistema.

En conjunto, el modelo constituye una base sólida para elaborar posteriormente el MER, definir el diseño físico en MySQL y desarrollar las migraciones y relaciones de Laravel, sin incorporar funcionalidades ajenas al alcance actual.
