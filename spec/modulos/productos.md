# Módulo de Productos

## 1. Propósito

Mantener el catálogo maestro interno y permitir localizar productos para consulta y movimientos.

## 2. Alcance

- Listar, buscar y filtrar productos.
- Crear y actualizar datos maestros.
- Activar y desactivar.
- Consultar detalle y estado.
- Impedir edición directa de existencias.

No incluye precios, imágenes comerciales, catálogo público ni venta.

## 3. Actores y permisos

- **Administrador:** mantenimiento completo.
- **Empleado:** listado, búsqueda y detalle de solo lectura.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-005, RF-006, RF-013 |
| Casos de uso | CU-05, CU-10 |
| Reglas | RN-003, RN-004, RN-009, RN-012, RN-014 a RN-019 |

## 5. Datos funcionales

- SKU único.
- Código de barras opcional y único.
- Nombre y descripción.
- Categoría obligatoria.
- Unidad de control.
- Estado activo/inactivo.

## 6. Búsqueda

- Coincidencia por nombre.
- Coincidencia exacta o parcial por SKU.
- Coincidencia por código de barras.
- Filtro por categoría y estado.
- Resultados paginados y orden consistente.

## 7. Reglas operativas

- El SKU siempre es obligatorio.
- El código de barras conserva ceros iniciales.
- La unidad determina si movimientos admiten fracciones.
- Un producto inactivo es consultable, pero no recibe movimientos.
- Un producto con movimientos se desactiva, no se elimina.
- La ficha no contiene ni acepta stock actual.
- Al habilitar un producto debe existir un inventario asociado.

## 8. Dependencias

- Categorías.
- Inventario para saldo y mínimo.
- Movimientos para historial y conservación.
- Autenticación y autorización.

## 9. Criterios de aceptación

- El Administrador mantiene productos válidos y únicos.
- El Empleado consulta sin modificar.
- Una categoría inválida o identificador duplicado se rechaza.
- El stock no cambia al editar el producto.
- Un producto inactivo no puede seleccionarse en Entrada o Salida.

