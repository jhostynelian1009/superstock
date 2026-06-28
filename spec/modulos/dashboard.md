# Módulo Dashboard

## 1. Propósito

Presentar una vista resumida y real del estado operativo de SuperStock.

## 2. Alcance

- Total de productos registrados.
- Total de productos activos.
- Productos con stock bajo.
- Productos agotados.
- Resumen de entradas y salidas recientes.
- Accesos a módulos autorizados según rol.

No muestra ventas, pedidos, clientes, ingresos monetarios ni actividad simulada.

## 3. Actores

- Administrador.
- Empleado.

La información puede ser común, pero la navegación y acciones disponibles dependen del rol.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-012, RF-013; RNF-005, RNF-006 |
| Caso de uso | CU-09 |
| Reglas | RN-009, RN-021, RN-028, RN-029, RN-030 |

## 5. Indicadores

| Indicador | Fuente |
|---|---|
| Productos registrados | Productos |
| Productos activos | Productos con estado activo |
| Stock bajo | Inventarios con saldo mayor que cero y menor o igual al mínimo |
| Agotados | Inventarios con saldo cero |
| Movimientos recientes | Entradas y salidas confirmadas |

## 6. Reglas operativas

- Todo indicador se calcula con datos vigentes.
- No se usan arreglos fijos, muestras ni cifras ficticias.
- El Dashboard no modifica saldos.
- Un indicador no disponible muestra error o estado vacío, nunca un valor inventado.
- Los accesos rápidos respetan permisos.

## 7. Dependencias

- Productos.
- Inventario y Movimientos.
- Autenticación y autorización.

## 8. Criterios de aceptación

- Los indicadores coinciden con consultas de control.
- Un stock en el mínimo se clasifica como bajo.
- Un stock cero se clasifica como agotado.
- Los movimientos recientes están ordenados por fecha.
- El Empleado no ve accesos administrativos.
- La interfaz funciona en móvil y escritorio.

