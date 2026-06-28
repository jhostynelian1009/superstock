# Skill Runbook: Hardening de Seguridad (security_skill)

*   **Responsable:** **Testing y Calidad (QA)**
*   **Rama Git:** `feature/99-qa-testing`
*   **Fase:** Pruebas y Cierre (Día 10 - 11)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Auditorías de Seguridad Obligatorias
El integrante de **QA** debe auditar el código desarrollado antes de cada Hito del Roadmap para cumplir con la rúbrica de seguridad.

1.  **Auditoría de Formularios (CSRF):**
    *   Buscar cualquier etiqueta `<form>` en archivos Blade y verificar que contenga la directiva `@csrf` para prevenir ataques de falsificación de peticiones en sitios cruzados.
2.  **Auditoría de Salidas (Prevención XSS):**
    *   Verificar que no se utilicen de forma insegura las directivas `{!! $variable !!}` en Blade. Toda variable dinámica proveniente de la base de datos o entrada del usuario debe imprimirse usando `{{ $variable }}`.
3.  **Auditoría de Consultas (Prevención SQL Injection):**
    *   Revisar controladores en búsqueda de consultas directas de string (`raw`). Forzar el uso de Eloquent parametrizado o métodos seguros del Query Builder.
4.  **Auditoría de Librerías y Vulnerabilidades:**
    *   Ejecutar en consola para analizar los paquetes instalados por composer:
        ```powershell
        composer audit
        ```
5.  **Rate Limiting:**
    *   Verificar que la ruta `POST /login` cuente con el middleware `throttle` para mitigar ataques de fuerza bruta.

## 2. Puntos de Control y Verificación
*   [ ] Comprobar que el comando `composer audit` no arroje vulnerabilidades críticas.
*   [ ] Intentar enviar una petición POST sin token CSRF y verificar que retorne error HTTP `419`.
