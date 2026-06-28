# Reglas de Negocio

**Proyecto:** SuperStock  
**Tipo de sistema:** Sistema Web de Gestión de Inventario para Supermercados  
**Arquitectura de referencia:** MVC sobre Laravel  
**Base de datos de referencia:** MySQL

## Objetivo

Establecer las reglas de negocio que gobiernan el funcionamiento de SuperStock, definiendo las condiciones, restricciones y criterios que deben cumplirse durante la administración de usuarios, productos, categorías y movimientos de inventario.

Estas reglas constituyen la referencia funcional para el análisis, diseño, implementación, validación y pruebas del sistema. Su propósito es asegurar que las operaciones mantengan la integridad de las existencias, permitan la trazabilidad de los movimientos y respondan a las necesidades de control interno de un supermercado.

## Alcance

Las reglas descritas aplican a los módulos de Login, Usuarios, Categorías, Productos, Inventario, Entradas, Salidas y Dashboard.

SuperStock se concibe como una herramienta interna de gestión. Por tanto, este documento excluye expresamente procesos de comercio electrónico, catálogo público, carrito de compras, checkout, pagos en línea y ventas o pedidos mediante WhatsApp heredados de SnackConnect.

El alcance cubre el acceso al sistema, el mantenimiento de datos maestros, el registro de movimientos, la actualización de existencias y la consulta de indicadores operativos. No sustituye las especificaciones técnicas, el diseño de base de datos ni los manuales de usuario.

## Definición de Regla de Negocio

Una regla de negocio es una disposición funcional que establece cómo debe comportarse el sistema ante una condición u operación determinada. Define obligaciones, restricciones, validaciones o decisiones propias del dominio de inventario, independientemente de la tecnología utilizada para implementarlas.

Cada regla posee un código único para facilitar su trazabilidad con requisitos, casos de uso, criterios de aceptación y pruebas. Las reglas deberán aplicarse de manera consistente en todas las interfaces y procesos que intervengan en la misma operación.

## Reglas Generales

**Código**

RN-001

**Nombre**

Uso interno del sistema.

**Descripción**

SuperStock deberá operar como un sistema interno de control de inventario. Todas las funciones de administración y consulta estarán destinadas exclusivamente al personal autorizado del supermercado.

**Justificación**

El propósito del sistema es proteger y controlar información operativa que no debe exponerse públicamente ni confundirse con un canal de ventas al consumidor.

**Módulos involucrados**

Login, Usuarios, Categorías, Productos, Inventario, Entradas, Salidas y Dashboard.

---

**Código**

RN-002

**Nombre**

Acceso autenticado a las funciones operativas.

**Descripción**

Toda operación de consulta, creación, actualización, activación, desactivación o registro de movimientos deberá requerir una sesión autenticada y vigente.

**Justificación**

La autenticación permite impedir accesos no autorizados y asociar cada operación con una identidad responsable.

**Módulos involucrados**

Login y todos los módulos administrativos.

---

**Código**

RN-003

**Nombre**

Validación obligatoria de la información.

**Descripción**

El sistema deberá validar integridad, formato, obligatoriedad y coherencia de los datos antes de aceptar cualquier operación. Una operación con información incompleta o inválida no deberá producir cambios parciales.

**Justificación**

Los datos incorrectos afectan directamente la confiabilidad del inventario y pueden generar diferencias entre las existencias físicas y las registradas.

**Módulos involucrados**

Usuarios, Categorías, Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-004

**Nombre**

Trazabilidad de operaciones.

**Descripción**

Toda operación que altere datos maestros o existencias deberá conservar, como mínimo, la fecha y hora de ejecución, el usuario responsable y el tipo de acción realizada.

**Justificación**

La trazabilidad permite investigar diferencias, determinar responsabilidades y respaldar procesos de auditoría y control interno.

**Módulos involucrados**

Usuarios, Categorías, Productos, Inventario, Entradas y Salidas.

## Reglas por Módulo

### Login

**Código**

RN-005

**Nombre**

Validación de credenciales.

**Descripción**

El acceso solo será concedido cuando las credenciales proporcionadas correspondan a una cuenta registrada y la contraseña sea válida. Los mensajes de error no deberán revelar cuál credencial fue incorrecta.

**Justificación**

La validación protege el sistema frente a accesos indebidos y evita divulgar información útil para intentos de intrusión.

**Módulos involucrados**

Login y Usuarios.

---

**Código**

RN-006

**Nombre**

Acceso exclusivo de cuentas activas.

**Descripción**

Una cuenta inactiva o bloqueada no podrá iniciar sesión, aunque las credenciales ingresadas sean correctas.

**Justificación**

La desactivación debe impedir inmediatamente el acceso de personal que ya no esté autorizado, sin eliminar su historial de operaciones.

**Módulos involucrados**

Login y Usuarios.

---

**Código**

RN-007

**Nombre**

Finalización segura de la sesión.

**Descripción**

Al cerrar sesión, el sistema deberá invalidar la sesión activa y requerir una nueva autenticación para volver a acceder a cualquier función interna.

**Justificación**

La invalidación evita que una sesión cerrada pueda reutilizarse desde el mismo equipo o mediante información previamente almacenada.

**Módulos involucrados**

Login.

### Usuarios

**Código**

RN-008

**Nombre**

Identidad única del usuario.

**Descripción**

Cada usuario deberá registrarse con un identificador de acceso único. No se permitirá crear dos cuentas activas asociadas al mismo correo electrónico o identificador definido por la institución.

**Justificación**

La unicidad evita ambigüedad en la autenticación y garantiza que las operaciones puedan atribuirse a una sola persona.

**Módulos involucrados**

Usuarios y Login.

---

**Código**

RN-009

**Nombre**

Asignación controlada de permisos.

**Descripción**

Cada usuario deberá operar únicamente con las funciones autorizadas para su perfil. La gestión de usuarios y permisos quedará restringida al personal con privilegios administrativos.

**Justificación**

La separación de responsabilidades reduce errores y limita el impacto de acciones realizadas por usuarios sin la autoridad necesaria.

**Módulos involucrados**

Usuarios, Login y todos los módulos administrativos.

---

**Código**

RN-010

**Nombre**

Conservación del historial del usuario.

**Descripción**

Un usuario que posea operaciones registradas deberá ser desactivado en lugar de eliminado. Sus movimientos históricos conservarán la referencia del responsable original.

**Justificación**

Eliminar usuarios con actividad previa rompería la trazabilidad y dificultaría las auditorías de inventario.

**Módulos involucrados**

Usuarios, Inventario, Entradas y Salidas.

### Categorías

**Código**

RN-011

**Nombre**

Nombre único de categoría.

**Descripción**

No podrán existir dos categorías con el mismo nombre normalizado. La comparación deberá evitar duplicados generados únicamente por diferencias de mayúsculas, minúsculas o espacios innecesarios.

**Justificación**

Las categorías duplicadas fragmentan los reportes y dificultan la clasificación y búsqueda de productos.

**Módulos involucrados**

Categorías, Productos y Dashboard.

---

**Código**

RN-012

**Nombre**

Clasificación obligatoria del producto.

**Descripción**

Todo producto deberá pertenecer a una categoría válida. Un producto no podrá quedar sin clasificación durante su creación o actualización.

**Justificación**

La clasificación consistente facilita la organización del inventario, las consultas y la elaboración de indicadores.

**Módulos involucrados**

Categorías, Productos, Inventario y Dashboard.

---

**Código**

RN-013

**Nombre**

Protección de categorías con productos asociados.

**Descripción**

Una categoría que tenga productos asociados no podrá eliminarse hasta que dichos productos sean reasignados o desactivados conforme a las políticas del sistema.

**Justificación**

La eliminación en cascada de categorías podría ocasionar pérdida accidental de productos y de referencias históricas.

**Módulos involucrados**

Categorías y Productos.

### Productos

**Código**

RN-014

**Nombre**

Identificación única del producto.

**Descripción**

Cada producto deberá contar con un identificador interno único, como un código de producto o SKU. Cuando se registre un código de barras, este tampoco podrá estar asignado a otro producto.

**Justificación**

La identificación única evita registrar movimientos sobre el artículo equivocado y facilita la localización precisa de cada producto.

**Módulos involucrados**

Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-015

**Nombre**

Datos mínimos del producto.

**Descripción**

Para registrar un producto deberán informarse al menos su nombre, identificador interno, categoría, unidad de control y estado. Los datos utilizados para controlar existencias no podrán quedar indefinidos.

**Justificación**

Un catálogo maestro completo es indispensable para interpretar correctamente cantidades y movimientos de inventario.

**Módulos involucrados**

Productos, Categorías e Inventario.

---

**Código**

RN-016

**Nombre**

Valores numéricos válidos del producto.

**Descripción**

El stock mínimo y cualquier valor monetario o cuantitativo asociado al producto deberán ser numéricos y mayores o iguales a cero. No se admitirán cantidades fraccionarias cuando la unidad de control del producto no las permita.

**Justificación**

La validación evita existencias, costos o límites incoherentes y respeta la forma real en que se contabiliza cada artículo.

**Módulos involucrados**

Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-017

**Nombre**

Desactivación de productos con historial.

**Descripción**

Los productos que posean movimientos de inventario no deberán eliminarse físicamente. Podrán desactivarse para impedir nuevos movimientos, conservando su información histórica.

**Justificación**

La conservación del producto permite interpretar entradas y salidas anteriores sin alterar los registros históricos.

**Módulos involucrados**

Productos, Inventario, Entradas, Salidas y Dashboard.

### Inventario

**Código**

RN-018

**Nombre**

Existencia respaldada por movimientos.

**Descripción**

La existencia disponible de cada producto deberá corresponder al saldo resultante de sus entradas y salidas confirmadas. Todo cambio en el saldo deberá estar respaldado por un movimiento identificable.

**Justificación**

Un saldo sin movimientos de respaldo no puede auditarse ni compararse de manera confiable con el inventario físico.

**Módulos involucrados**

Inventario, Entradas, Salidas y Productos.

---

**Código**

RN-019

**Nombre**

Prohibición de modificación directa del stock.

**Descripción**

La existencia de un producto no podrá editarse directamente desde su ficha. Las variaciones deberán registrarse mediante una entrada o una salida con su correspondiente motivo y responsable.

**Justificación**

La edición directa elimina la trazabilidad y dificulta identificar el origen de las diferencias de inventario.

**Módulos involucrados**

Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-020

**Nombre**

Existencias no negativas.

**Descripción**

El sistema no deberá permitir que la existencia de un producto sea inferior a cero. Cualquier operación que produzca un saldo negativo deberá rechazarse antes de modificar el inventario.

**Justificación**

El stock negativo representa una inconsistencia operativa y oculta faltantes que deben ser investigados y regularizados.

**Módulos involucrados**

Inventario y Salidas.

---

**Código**

RN-021

**Nombre**

Identificación de stock bajo.

**Descripción**

Un producto deberá considerarse con stock bajo cuando su existencia sea menor o igual al stock mínimo configurado. Esta condición deberá reflejarse en las consultas de inventario y en el Dashboard.

**Justificación**

La detección oportuna permite planificar el abastecimiento y reducir el riesgo de agotamiento de productos.

**Módulos involucrados**

Productos, Inventario y Dashboard.

### Entradas

**Código**

RN-022

**Nombre**

Datos obligatorios de una entrada.

**Descripción**

Toda entrada deberá identificar el producto, la cantidad, la fecha, el motivo o referencia de origen y el usuario responsable. No se aceptarán entradas sin información suficiente para justificar el incremento.

**Justificación**

Estos datos permiten comprobar la procedencia del movimiento y respaldar la conciliación con documentos o controles externos.

**Módulos involucrados**

Entradas, Inventario, Productos y Usuarios.

---

**Código**

RN-023

**Nombre**

Incremento efectivo por entrada confirmada.

**Descripción**

La cantidad de una entrada deberá ser mayor que cero. Al confirmarse el movimiento, el sistema incrementará la existencia del producto exactamente en la cantidad registrada y ambas acciones deberán considerarse una sola operación.

**Justificación**

La actualización conjunta evita que exista una entrada sin impacto en stock o un incremento sin su movimiento de respaldo.

**Módulos involucrados**

Entradas e Inventario.

---

**Código**

RN-024

**Nombre**

Inmutabilidad de entradas confirmadas.

**Descripción**

Una entrada confirmada no podrá eliminarse ni alterar su producto o cantidad. Los errores deberán corregirse mediante un movimiento compensatorio autorizado que mantenga la referencia al registro original.

**Justificación**

La inmutabilidad preserva la secuencia histórica y evita que modificaciones posteriores oculten errores o acciones indebidas.

**Módulos involucrados**

Entradas, Salidas, Inventario y Usuarios.

### Salidas

**Código**

RN-025

**Nombre**

Datos obligatorios de una salida.

**Descripción**

Toda salida deberá identificar el producto, la cantidad, la fecha, el motivo o destino del movimiento y el usuario responsable.

**Justificación**

La información permite distinguir consumos, pérdidas, mermas, ajustes u otros motivos válidos sin depender de descripciones informales posteriores.

**Módulos involucrados**

Salidas, Inventario, Productos y Usuarios.

---

**Código**

RN-026

**Nombre**

Validación de disponibilidad antes de la salida.

**Descripción**

La cantidad solicitada deberá ser mayor que cero y no podrá superar la existencia disponible del producto en el momento de confirmar la salida.

**Justificación**

La validación garantiza el cumplimiento de la regla de existencias no negativas y evita registrar cantidades que el sistema no posee.

**Módulos involucrados**

Salidas e Inventario.

---

**Código**

RN-027

**Nombre**

Disminución efectiva e inmutabilidad de la salida.

**Descripción**

Al confirmarse una salida, la existencia se reducirá exactamente en la cantidad registrada. El movimiento confirmado no podrá eliminarse ni cambiar su producto o cantidad; cualquier corrección requerirá un movimiento compensatorio autorizado.

**Justificación**

La aplicación conjunta y la conservación del movimiento aseguran un saldo consistente y un historial verificable.

**Módulos involucrados**

Salidas, Entradas, Inventario y Usuarios.

### Dashboard

**Código**

RN-028

**Nombre**

Indicadores basados en información real.

**Descripción**

Todos los valores presentados en el Dashboard deberán obtenerse de los datos vigentes del sistema. No se mostrarán cifras simuladas, valores fijos ni actividades ficticias como si fueran información operativa.

**Justificación**

Las decisiones de reposición y control dependen de que los indicadores representen el estado real del inventario.

**Módulos involucrados**

Dashboard, Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-029

**Nombre**

Indicadores mínimos de inventario.

**Descripción**

El Dashboard deberá informar, como mínimo, el total de productos registrados, productos activos, productos con stock bajo o agotado y un resumen de entradas y salidas recientes.

**Justificación**

Estos indicadores ofrecen una visión operativa suficiente para detectar necesidades de abastecimiento y revisar la actividad reciente.

**Módulos involucrados**

Dashboard, Productos, Inventario, Entradas y Salidas.

---

**Código**

RN-030

**Nombre**

Carácter informativo del Dashboard.

**Descripción**

El Dashboard será un módulo de consulta y navegación. No permitirá modificar directamente existencias ni sustituirá los formularios autorizados de Entradas y Salidas.

**Justificación**

Separar la consulta de la ejecución de movimientos reduce acciones accidentales y mantiene un flujo de registro controlado.

**Módulos involucrados**

Dashboard, Inventario, Entradas y Salidas.

## Restricciones

- El sistema no permitirá operaciones internas sin autenticación.
- No se permitirán existencias negativas ni cantidades de movimiento iguales o inferiores a cero.
- El stock no podrá modificarse directamente desde el mantenimiento de productos.
- Los movimientos confirmados no podrán eliminarse ni alterarse de forma que se pierda su trazabilidad.
- No se eliminarán usuarios, productos o categorías cuando la eliminación comprometa información histórica o relaciones vigentes.
- Los códigos únicos de usuarios, categorías y productos no podrán duplicarse.
- El Dashboard no utilizará información ficticia para representar el estado del negocio.
- Las funciones heredadas de catálogo público, carrito, checkout y pedidos por WhatsApp quedan fuera del alcance de SuperStock.
- Las reglas deberán aplicarse de forma consistente con las restricciones de integridad definidas en MySQL.

## Consideraciones

- Este documento describe comportamiento funcional y no prescribe una implementación específica.
- Las reglas deberán vincularse posteriormente con requisitos funcionales, casos de uso, criterios de aceptación y pruebas.
- Los nombres de perfiles y el detalle de sus permisos deberán formalizarse en la documentación del módulo Usuarios, respetando el principio de mínimo privilegio definido en RN-009.
- La unidad de control de cada producto deberá establecer si admite cantidades enteras o fraccionarias.
- Los ajustes de inventario deberán representarse mediante entradas o salidas justificadas para preservar la trazabilidad.
- Las fechas y horas deberán manejarse de manera uniforme en todos los módulos y presentarse conforme a la zona horaria institucional.
- Cualquier ampliación futura deberá evaluar su impacto sobre estas reglas y mantener la numeración existente para conservar la trazabilidad documental.
- La reutilización de componentes de SnackConnect deberá limitarse a elementos compatibles con el alcance interno de SuperStock.
