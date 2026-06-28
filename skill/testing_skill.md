# Skill Runbook: Testing y Control de Calidad (testing_skill)

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

## 1. Instrucciones de Configuración y Ejecución
1.  **Configurar base de datos de pruebas (`phpunit.xml`):**
    ```xml
    <env name="DB_CONNECTION" value="mysql"/>
    <env name="DB_DATABASE" value="snackconnect_test"/>
    ```
2.  **Escribir pruebas funcionales en `/tests/Feature/`:**
    *   **Autenticación:** Probar registro correcto, login válido/inválido e interceptación de middleware `auth` en rutas administrativas.
    *   **CRUD de Productos:** Usar `Storage::fake('public')` y `UploadedFile::fake()->image('test.png')` para simular cargas de archivos. Comprobar que un usuario no autenticado no puede crear productos.
    *   **Catálogo Público:** Verificar que solo se muestran productos activos y que las búsquedas funcionan.
3.  **Ejecutar pruebas del sistema:**
    ```powershell
    php artisan test
    ```

## 2. Puntos de Control y Verificación
*   [ ] Verificar que el 100% de la suite de pruebas se ejecute con éxito sin generar archivos basura en las carpetas de storage públicas.
