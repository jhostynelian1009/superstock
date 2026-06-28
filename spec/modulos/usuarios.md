# Módulo de Usuarios

## 1. Propósito

Administrar las cuentas internas responsables de operar SuperStock.

## 2. Alcance

- Listar y buscar usuarios.
- Crear cuentas.
- Consultar y actualizar datos.
- Asignar rol Administrador o Empleado.
- Activar y desactivar.
- Conservar usuarios responsables de movimientos.

No incluye autorregistro, perfiles de cliente, direcciones ni solicitudes públicas.

## 3. Actores y permisos

- **Administrador:** mantenimiento completo.
- **Empleado:** sin acceso al módulo; solo utiliza su propia identidad autenticada.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-003, RF-013; RNF-002, RNF-010 |
| Caso de uso | CU-03 |
| Reglas | RN-003, RN-004, RN-008, RN-009, RN-010 |

## 5. Datos funcionales

- Nombre completo.
- Correo electrónico único.
- Contraseña protegida.
- Rol.
- Estado activo/inactivo.
- Fechas de creación y actualización.

## 6. Reglas operativas

- Solo el Administrador crea y cambia roles.
- El correo se normaliza antes de comprobar unicidad.
- Una contraseña vacía durante edición no reemplaza la existente.
- Una cuenta inactiva pierde acceso inmediatamente.
- Un usuario con movimientos se desactiva en lugar de eliminarse.
- El sistema registra al Administrador responsable de cambios sensibles.

## 7. Dependencias

- Autenticación y middleware.
- `inventory_movements` para comprobar referencias históricas.
- Componentes de tabla, formulario, badge y confirmación.

## 8. Criterios de aceptación

- El Administrador crea cuentas válidas de ambos roles.
- No se aceptan correos duplicados.
- El Empleado no accede ni por navegación ni por URL directa.
- Una cuenta desactivada no inicia sesión.
- Desactivar no altera movimientos históricos.

## 9. Estados de interfaz

- Listado paginado y buscable.
- Badge de rol y estado.
- Confirmación antes de desactivar.
- Estado vacío cuando no existen resultados.
- Mensajes explícitos de éxito, validación y acceso denegado.

