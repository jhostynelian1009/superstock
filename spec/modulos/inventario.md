# Módulo de Inventario y Movimientos

## 1. Propósito

Proporcionar el saldo vigente por producto y el historial que explica cada variación.

## 2. Alcance

- Listar y filtrar existencias.
- Mostrar stock actual, mínimo y condición.
- Consultar detalle de un producto.
- Consultar movimientos por producto, tipo, usuario, proveedor o período.
- Identificar stock bajo y agotado.
- Conciliar saldo e historial.

El módulo no permite modificar directamente `current_stock`.

## 3. Actores

- Administrador.
- Empleado.

Ambos poseen acceso de consulta. Los cambios se originan exclusivamente en Entradas y Salidas.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-008, RF-011, RF-013; RNF-003, RNF-010 |
| Casos de uso | CU-06, apoyo a CU-07, CU-08 y CU-09 |
| Reglas | RN-004, RN-009, RN-018 a RN-021, RN-024, RN-027 |

## 5. Estados de inventario

| Estado | Condición |
|---|---|
| Disponible | Stock mayor al mínimo. |
| Stock bajo | Stock mayor que cero y menor o igual al mínimo. |
| Agotado | Stock igual a cero. |

## 6. Reglas operativas

- Un producto controlado posee un único inventario en V1.
- El saldo inicial es cero o una entrada de apertura.
- El saldo nunca es negativo.
- Movimiento y saldo se confirman o revierten juntos.
- El historial es inmutable.
- Una corrección utiliza un movimiento compensatorio.
- La conciliación es entradas menos salidas.

## 7. Consulta de movimientos

Cada fila presenta como mínimo:

- Fecha efectiva.
- Tipo.
- Producto.
- Cantidad.
- Responsable.
- Motivo.
- Proveedor opcional.
- Referencia.

Los filtros no alteran datos y los resultados son paginados.

## 8. Dependencias

- Productos.
- Usuarios.
- Proveedores.
- Entradas y Salidas.

## 9. Criterios de aceptación

- El saldo mostrado coincide con el historial confirmado.
- Stock bajo y agotado se clasifican correctamente.
- Ningún actor edita el saldo desde la consulta.
- Los filtros devuelven solo movimientos correspondientes.
- Un movimiento confirmado no ofrece edición ni eliminación.

