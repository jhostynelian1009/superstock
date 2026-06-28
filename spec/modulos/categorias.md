# Módulo de Categorías

## 1. Propósito

Mantener una clasificación consistente para los productos del inventario.

## 2. Alcance

- Listar y buscar categorías.
- Crear categorías.
- Consultar y editar nombre y descripción.
- Eliminar únicamente categorías sin productos.
- Mostrar cantidad de productos asociados.

## 3. Actores y permisos

- **Administrador:** mantenimiento completo.
- **Empleado:** utiliza categorías como filtro en consultas, sin administrarlas.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-004, RF-013 |
| Caso de uso | CU-04 |
| Reglas | RN-003, RN-004, RN-011, RN-012, RN-013 |

## 5. Datos funcionales

- Nombre único normalizado.
- Descripción opcional.
- Fechas de creación y actualización.

## 6. Reglas operativas

- No se admiten nombres vacíos o equivalentes por mayúsculas y espacios.
- Todo producto referencia una categoría existente.
- La eliminación se bloquea cuando existen productos.
- No se utiliza eliminación en cascada de productos.
- Las categorías se ofrecen como filtros en Productos e Inventario.

## 7. Dependencias

- Productos para asociaciones y conteos.
- Autenticación y autorización administrativa.
- Componentes de tabla, formulario y confirmación.

## 8. Criterios de aceptación

- El Administrador crea y edita categorías válidas.
- Un duplicado normalizado se rechaza.
- Una categoría con productos no se elimina.
- El Empleado no accede al mantenimiento.
- Los filtros muestran categorías vigentes sin duplicados.

