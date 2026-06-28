# Módulo de Salidas

## 1. Propósito

Registrar disminuciones de existencias sin permitir stock negativo y conservando trazabilidad.

## 2. Alcance

- Buscar y seleccionar producto activo.
- Mostrar existencia disponible y unidad.
- Registrar cantidad, fecha, motivo o destino y referencia.
- Mostrar saldo resultante.
- Confirmar movimiento y descuento.

## 3. Actores

- Administrador.
- Empleado.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-006, RF-010, RF-013; RNF-003, RNF-010 |
| Caso de uso | CU-08 |
| Reglas | RN-003, RN-004, RN-014, RN-016 a RN-020, RN-025 a RN-027 |

## 5. Datos de salida

- Producto activo.
- Cantidad mayor que cero.
- Fecha efectiva.
- Motivo o destino.
- Referencia opcional.
- Usuario autenticado como responsable.

## 6. Reglas operativas

- La cantidad respeta la unidad del producto.
- La disponibilidad se valida al presentar y nuevamente al confirmar.
- La cantidad no supera el saldo vigente.
- Salidas simultáneas sobre el mismo producto no pueden consumir el mismo stock.
- Movimiento y descuento son una sola transacción.
- Un fallo revierte ambas operaciones.
- La salida confirmada no se edita ni elimina.

## 7. Dependencias

- Productos y búsqueda.
- Inventario y Movimientos.
- Usuario autenticado.

## 8. Criterios de aceptación

- Una salida válida descuenta exactamente la cantidad.
- Una salida insuficiente se rechaza sin cambios.
- La existencia nunca queda negativa.
- Cancelar no crea movimiento.
- La salida aparece inmediatamente en historial y Dashboard.
- La concurrencia no permite sobregiro.

