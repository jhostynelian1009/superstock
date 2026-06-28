# Visión de SuperStock

## 1. Propósito

SuperStock es un Sistema Web de Gestión de Inventario para Supermercados. Su propósito es proporcionar al personal autorizado una fuente confiable para administrar productos, consultar existencias y registrar toda variación de stock mediante entradas y salidas trazables.

El sistema reutiliza la infraestructura Laravel de SnackConnect, pero reemplaza su dominio de catálogo público y pedidos por un dominio estrictamente interno de inventario.

## 2. Problema

El control manual o disperso del inventario dificulta conocer las existencias reales, identificar productos agotados, establecer responsabilidades sobre los movimientos y explicar diferencias entre el stock físico y el registrado.

Sin un historial consistente, el supermercado no puede determinar con precisión quién modificó una existencia, cuándo ocurrió la operación ni cuál fue su motivo.

## 3. Propuesta de valor

SuperStock centraliza:

- El catálogo maestro de productos y categorías.
- Los usuarios internos y sus permisos.
- Los proveedores utilizados como referencia de abastecimiento.
- La existencia vigente y el stock mínimo por producto.
- El historial inmutable de entradas y salidas.
- Los indicadores operativos de stock bajo, agotados y actividad reciente.

La propuesta prioriza simplicidad, trazabilidad e integridad antes que amplitud funcional.

## 4. Actores

### Administrador

Responsable de la configuración funcional y del control general del sistema. Puede gestionar usuarios, categorías, productos y proveedores; consultar inventario; registrar movimientos y revisar el Dashboard.

### Empleado

Responsable de la operación cotidiana. Puede autenticarse, consultar productos e inventario, buscar productos, registrar entradas y salidas y consultar el Dashboard. No administra usuarios, permisos ni configuración.

## 5. Alcance de la primera versión

La primera versión incluye:

1. Autenticación y cierre seguro de sesión.
2. Gestión de usuarios internos por el Administrador.
3. Gestión de categorías.
4. Gestión y búsqueda de productos.
5. Gestión básica de proveedores.
6. Consulta de existencias y stock mínimo.
7. Registro de entradas.
8. Registro de salidas con validación de disponibilidad.
9. Historial de movimientos.
10. Dashboard con información real.

La primera versión administra un único inventario consolidado por producto. Sucursales y bodegas múltiples quedan como extensión futura.

## 6. Fuera de alcance

- Clientes y perfiles de comprador.
- Landing o catálogo público.
- Carrito y checkout.
- Pedidos, entregas, ventas y facturación.
- Pasarelas de pago o integración con WhatsApp.
- Compras y órdenes de compra.
- Inventario por múltiples ubicaciones en esta versión.

## 7. Principios del producto

- **Trazabilidad:** toda variación de stock tiene movimiento, usuario, fecha y motivo.
- **Integridad:** ninguna salida produce stock negativo.
- **Separación de responsabilidades:** producto, saldo y movimiento son conceptos distintos.
- **Mínimo privilegio:** cada actor accede únicamente a las funciones autorizadas.
- **Datos reales:** el Dashboard no presenta valores simulados.
- **Conservación histórica:** usuarios, productos, proveedores y movimientos con historial no se eliminan de forma destructiva.
- **Responsive:** la interfaz es operable en escritorio, tableta y móvil.

## 8. Criterios de éxito

SuperStock se considerará funcionalmente aceptable cuando:

- Los dos actores puedan autenticarse y acceder solo a sus funciones.
- El Administrador pueda mantener los datos maestros aprobados.
- Las existencias solo cambien mediante entradas o salidas confirmadas.
- Cada movimiento sea consultable y trazable.
- El sistema rechace cantidades inválidas y salidas sin disponibilidad.
- El inventario y el historial puedan conciliarse.
- El Dashboard refleje los datos reales del sistema.
- Las pruebas cubran permisos, integridad de stock y flujos críticos.

## 9. Restricciones y supuestos

- Framework objetivo: Laravel 12.x sobre PHP 8.2 o superior.
- Persistencia objetivo: MySQL; la versión deberá ser uniforme entre desarrollo, pruebas y presentación.
- Arquitectura: monolito modular basado en MVC.
- Interfaz: Blade, Tailwind CSS, JavaScript y Vite.
- Idioma de interfaz: español de Ecuador.
- La adaptación se realiza sobre SnackConnect y debe preservar únicamente infraestructura compatible con este alcance.

