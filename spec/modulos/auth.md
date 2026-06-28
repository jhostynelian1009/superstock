# Módulo de Autenticación y Sesión

## 1. Propósito

Controlar el acceso de Administradores y Empleados a las áreas internas de SuperStock y finalizar sus sesiones de forma segura.

## 2. Alcance

- Inicio de sesión con correo y contraseña.
- Verificación de cuenta activa.
- Creación y regeneración de sesión.
- Redirección al Dashboard.
- Cierre e invalidación de sesión.
- Protección de rutas internas.

No incluye registro público, selección manual de rol, perfiles de cliente ni solicitudes de administrador.

## 3. Actores

- Administrador.
- Empleado.

## 4. Trazabilidad

| Tipo | Referencias |
|---|---|
| Requisitos | RF-001, RF-002, RF-013; RNF-001, RNF-002 |
| Casos de uso | CU-01, CU-02 |
| Reglas | RN-001, RN-002, RN-005, RN-006, RN-007, RN-008, RN-009 |

## 5. Flujo funcional

1. El usuario accede al formulario de login.
2. Ingresa correo y contraseña.
3. El sistema valida formato, credenciales y estado.
4. El sistema regenera la sesión y determina el rol almacenado.
5. El usuario accede al Dashboard con navegación autorizada.
6. Al cerrar sesión, el sistema invalida sesión y token.

## 6. Validaciones y seguridad

- Correo obligatorio y válido.
- Contraseña obligatoria.
- Mensaje genérico ante credenciales incorrectas.
- Cuenta activa obligatoria.
- Limitación de intentos repetidos.
- La autorización no depende solo de elementos ocultos en la interfaz.
- Logout únicamente mediante una solicitud protegida contra CSRF.

## 7. Respuestas esperadas

- Éxito: sesión vigente y Dashboard.
- Validación: formulario con mensajes y datos no sensibles conservados.
- Credenciales o estado inválidos: acceso denegado sin crear sesión.
- Acceso sin sesión: redirección al login.
- Acceso sin rol: respuesta denegada o redirección segura.

## 8. Dependencias

- Entidad `users`.
- Middleware de autenticación y autorización.
- Layout de autenticación.
- Módulo Usuarios para altas, roles y estados.

## 9. Criterios de aceptación

- Una cuenta activa con credenciales válidas inicia sesión.
- Una cuenta inactiva o credencial inválida no inicia sesión.
- Administrador y Empleado reciben únicamente permisos de su rol.
- Cerrar sesión impide reutilizar la sesión anterior.
- No existe ruta de registro público.

