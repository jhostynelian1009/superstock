# SnackConnect Laravel - Carpeta de Especificaciones (spec/)

Este directorio contiene las especificaciones formales del proyecto **SnackConnect Laravel**, adaptadas para un **proyecto académico universitario** con un equipo de **6 integrantes** y un plazo de **12 días**.

Toda implementación en `app/` o runbook de automatización en `skill/` debe estar estrictamente alineada con las especificaciones aquí detalladas para garantizar el cumplimiento del 100% de la rúbrica de evaluación con el menor riesgo posible.

## Estructura de Roles del Equipo
*   **Líder Técnico (LT):** Configuración base, arquitectura general, integraciones y administración de Git/GitHub.
*   **Desarrollador de Autenticación (DEV-AUTH):** Registro, login, control de acceso y seguridad de sesiones.
*   **Desarrollador de Productos (DEV-PROD):** CRUD de productos, categorización y manejo de almacenamiento físico de imágenes.
*   **Desarrollador de Frontend Público (DEV-FRONT):** Landing page, listado de catálogo, filtros y búsquedas dinámicas.
*   **Desarrollador de Dashboard (DEV-DASH):** Panel interno privado, renderizado de métricas y layouts maestros.
*   **Testing y Calidad (QA):** Implementación de pruebas automatizadas, auditorías de seguridad e integración continua local.

## Estrategia Git y Pull Requests
*   **Rama Principal (`main`):** Solo código estable y libre de errores.
*   **Rama de Integración (`develop`):** Donde se fusionan las ramas de características aprobadas.
*   **Ramas de Características (`feature/nombre-caracteristica`):** Creadas de forma individual por cada desarrollador según su rol.
*   **Flujo de PR:** Toda Pull Request a `develop` requiere una revisión técnica del integrante de **Testing y Calidad (QA)** para verificar el cumplimiento de la rúbrica, y la posterior aprobación del **Líder Técnico** para el merge.

## Índice de Documentos
*   [Visión General](vision.md): Justificación académica, objetivos del proyecto y restricciones.
*   [Requerimientos](requerimientos.md): Requerimientos funcionales y no funcionales vinculados a la rúbrica.
*   [Arquitectura de Software](arquitectura.md): Patrón MVC Monolítico simplificado y enrutamiento.
*   [Modelo de Base de Datos](base_datos.md): Entidades y relaciones sobre MySQL 8.x.
*   [Roadmap del Proyecto](roadmap.md): Planificación detallada para el ciclo de 12 días.
*   [Módulos Funcionales](modulos/README.md): Especificaciones detalladas por módulo de trabajo.
