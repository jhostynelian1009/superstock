# Skill Runbook: Inicialización del Proyecto (setup_skill)

*   **Responsable:** **Líder Técnico (LT)**
*   **Rama Git:** `feature/00-setup`
*   **Fase:** Cimientos (Día 1 - 2)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Instrucciones de Configuración Inicial
1.  **Ejecutar en la raíz del proyecto para crear la app Laravel:**
    ```powershell
    composer create-project laravel/laravel app
    ```
2.  **Configurar base de datos MySQL 8.x:**
    *   Iniciar Apache y MySQL desde el Panel de Control de XAMPP.
    *   Crear la base de datos `snackconnect` a través de phpMyAdmin o la línea de comandos de MySQL:
        ```powershell
        mysql -u root -e "CREATE DATABASE snackconnect;"
        ```
    *   Editar `app/.env` y establecer las variables de conexión:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=snackconnect
        DB_USERNAME=root
        DB_PASSWORD=
        ```
3.  **Ejecutar migraciones iniciales de Laravel:**
    ```powershell
    php artisan migrate
    ```

## 2. Puntos de Control y Verificación
*   [ ] Comprobar en phpMyAdmin o la línea de comandos que la base de datos `snackconnect` contiene las tablas iniciales de Laravel que se generaron tras ejecutar la migración.
*   [ ] Iniciar el servidor local (`php artisan serve`) y verificar la respuesta HTTP 200 en `http://127.0.0.1:8000`.
*   [ ] Integrar e inicializar el repositorio Git local:
    ```powershell
    git init
    git checkout -b develop
    ```
