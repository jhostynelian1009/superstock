# Módulo de Entradas

## 1. Propósito

Registrar incrementos de existencias de manera trazable, validada e indivisible.

## 2. Alcance

- Buscar y seleccionar producto activo.
- Mostrar existencia actual y unidad.
- Registrar cantidad, fecha, origen, proveedor opcional y referencia.
- Confirmar resumen.
- Crear movimiento e incrementar saldo.
- Informar el nuevo saldo.

## 3. Actores

- Administrador.
- Empleado.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-006, RF-009, RF-013; RNF-003, RNF-010 |
| Caso de uso | CU-07 |
| Reglas | RN-003, RN-004, RN-014, RN-016 a RN-019, RN-022 a RN-024 |

## 5. Datos de entrada

- Producto activo.
- Cantidad mayor que cero.
- Fecha efectiva.
- Motivo u origen.
- Proveedor opcional.
- Referencia opcional.
- Usuario autenticado como responsable.

## 6. Reglas operativas

- La cantidad respeta la unidad del producto.
- El proveedor, cuando existe, debe estar activo.
- El origen sigue siendo obligatorio aunque exista proveedor.
- La confirmación vuelve a validar los datos.
- Movimiento e incremento son una sola transacción.
- Un fallo revierte ambas operaciones.
- La entrada confirmada no se edita ni elimina.

## 7. Dependencias

- Productos y búsqueda.
- Proveedores.
- Inventario y Movimientos.
- Usuario autenticado.

## 8. Criterios de aceptación

- Una entrada válida incrementa exactamente la cantidad indicada.
- Una cantidad inválida o producto inactivo no cambia datos.
- Cancelar antes de confirmar no crea movimiento.
- Un fallo no deja movimiento sin saldo ni saldo sin movimiento.
- La entrada aparece inmediatamente en historial y Dashboard.

