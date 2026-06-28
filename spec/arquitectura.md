# Arquitectura del Sistema - SnackConnect Laravel (MySQL 8.x)

Para este proyecto académico, la arquitectura busca mitigar riesgos de configuración del entorno y fallos de despliegue local durante la evaluación del docente.

## 1. Stack Tecnológico de Bajo Riesgo
*   **Framework:** Laravel 11.x (PHP 8.2+)
*   **Base de Datos:** MySQL 8.x, seleccionada por las siguientes justificaciones arquitectónicas:
    *   Compatibilidad directa con XAMPP y phpMyAdmin.
    *   Familiaridad del equipo de desarrollo.
    *   Compatibilidad con la mayoría de proveedores de hosting compartido.
    *   Mayor similitud con entornos reales de producción.
    *   Facilidad para la exposición académica y evaluación docente.
*   **Gestión de Assets:** Laravel Vite (compilación local ligera).
*   **Frontend:** Vistas Blade estructuradas en layouts reutilizables, estiladas con CSS Vanilla o TailwindCSS para asegurar adaptabilidad móvil (Mobile First).

---

## 2. Enrutamiento y Control de Flujo de Datos

El enrutamiento está estructurado de manera que no existan colisiones entre las tareas de los diferentes desarrolladores del equipo.

```mermaid
graph TD
    subgraph Rutas Públicas
        R_Landing[GET / - Landing Page]
        R_Catalog[GET /catalogo - Catálogo]
        R_Show[GET /catalogo/{id} - Detalle]
    end
    subgraph Rutas Privadas Admin
        R_Dash[GET /admin/dashboard - Métricas]
        R_CRUD[Resource /admin/productos - CRUD]
    end
    subgraph Rutas Auth
        R_Login[GET/POST /login]
        R_Register[GET/POST /register]
    end

    R_Dash -->|Protegido por auth middleware| AuthMW[Middleware Auth]
    R_CRUD -->|Protegido por auth middleware| AuthMW
```

### Separación de Archivos de Ruta
*   Para evitar conflictos de fusión (merge conflicts) en `routes/web.php`, se definen bloques comentados estrictos asignados a cada rol:
    *   **Bloque 1 (DEV-FRONT):** Rutas de inicio, catálogo y checkout.
    *   **Bloque 2 (DEV-AUTH):** Rutas de login, registro y logout.
    *   **Bloque 3 (DEV-DASH / DEV-PROD):** Prefijo `/admin` y controladores asociados.
