# Módulo de Proveedores

## 1. Propósito

Mantener referencias normalizadas de abastecedores que pueden asociarse con entradas de inventario.

## 2. Alcance

- Listar y buscar proveedores.
- Crear y actualizar datos básicos.
- Activar y desactivar.
- Seleccionar un proveedor activo durante una entrada.
- Conservar referencias históricas.

No incluye órdenes de compra, cuentas por pagar, pagos ni evaluación comercial.

## 3. Actores y permisos

- **Administrador:** mantenimiento completo.
- **Empleado:** consulta y selección dentro de CU-07; sin mantenimiento.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-007, RF-009, RF-013 |
| Casos de uso | CU-11, apoyo a CU-07 |
| Reglas | RN-003, RN-004, RN-009, RN-022, RN-024 |

## 5. Datos funcionales

- Razón social obligatoria.
- Identificación tributaria opcional y única.
- Nombre de contacto.
- Teléfono y correo opcionales.
- Estado activo/inactivo.

## 6. Reglas operativas

- Solo proveedores activos aparecen para nuevas entradas.
- Una entrada puede no tener proveedor si registra otro origen válido.
- Una salida nunca se asocia con proveedor.
- Un proveedor con movimientos se desactiva, no se elimina.
- La identificación tributaria se normaliza antes de validar unicidad.

## 7. Dependencias

- Entradas.
- Inventario y Movimientos.
- Autenticación y autorización administrativa.

## 8. Criterios de aceptación

- El Administrador mantiene proveedores válidos.
- Un identificador duplicado se rechaza.
- El Empleado solo puede consultar proveedores activos desde una entrada.
- Desactivar un proveedor no altera movimientos anteriores.
- Registrar una entrada sin proveedor sigue siendo posible con origen o referencia.

