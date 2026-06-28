# Especificación de Módulo: Autenticación (Auth)

*   **Responsable del Módulo:** **DEV-AUTH**
*   **Rama Git Relacionada:** `feature/02-auth`
*   **Plazo de Entrega:** Día 3 y 4 del Roadmap.

---

## 1. Alcance Académico
El módulo provee los mecanismos de control de acceso requeridos por la rúbrica. El registro de administradores estará abierto en desarrollo, pero contará con validaciones estrictas y protección contra accesos no autorizados.

## 2. Historias de Usuario Asignadas
*   **HU-AUTH-01 (Registro):** Como usuario, quiero registrarme ingresando mi nombre, email y contraseña para poder administrar la tienda.
*   **HU-AUTH-02 (Inicio de Sesión):** Como administrador, quiero loguearme con mis credenciales para acceder a la gestión de productos.
*   **HU-AUTH-03 (Cierre de Sesión):** Como administrador autenticado, deseo cerrar sesión para proteger mi información.

## 3. Especificaciones Técnicas y Validaciones
*   **Rutas a crear:**
    *   `GET /login`, `POST /login`
    *   `GET /register`, `POST /register`
    *   `POST /logout`
*   **Reglas de validación en PHP:**
    *   `name`: `required|string|max:255`
    *   `email`: `required|string|email|max:255|unique:users`
    *   `password`: `required|string|min:8|confirmed`
*   **Middleware:** Aplicar el middleware `auth` a las rutas de `/admin/*` para interceptar peticiones de invitados y redirigirlos a `/login`.
