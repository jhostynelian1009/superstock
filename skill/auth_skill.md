# Skill Runbook: Autenticación y Middleware (auth_skill)

*   **Responsable:** **DEV-AUTH**
*   **Rama Git:** `feature/02-auth`
*   **Fase:** Núcleo (Días 3 - 4)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Instrucciones de Implementación
1.  **Crear el controlador:**
    ```powershell
    php artisan make:controller AuthController
    ```
2.  **Crear plantillas de interfaz de usuario:**
    *   `/app/resources/views/auth/login.blade.php`: Formulario con campos `email`, `password` y directiva `@csrf`.
    *   `/app/resources/views/auth/register.blade.php`: Formulario con campos `name`, `email`, `password`, `password_confirmation` y `@csrf`.
3.  **Configurar enrutamiento (`routes/web.php`):**
    *   Registrar rutas con el middleware `guest` (login, registro).
    *   Registrar ruta de `POST /logout` con el middleware `auth`.
4.  **Codificar validaciones en `AuthController`:**
    *   En registro, aplicar validaciones estrictas: `min:8` caracteres para contraseña. Almacenar la clave en base de datos cifrada (`Hash::make($password)`).
    *   En login, validar credenciales con `Auth::attempt()`. Regenerar la sesión del usuario al completarse con éxito (`$request->session()->regenerate()`).

## 2. Puntos de Control y Verificación
*   [ ] Comprobar redirección automática a `/login` al intentar acceder a `/admin/dashboard` sin sesión activa.
*   [ ] Comprobar que tras el registro e inicio de sesión, el usuario sea redirigido a `/admin/dashboard`.
