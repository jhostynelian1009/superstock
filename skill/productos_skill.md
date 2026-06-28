# Skill Runbook: CRUD de Productos y Categorías (productos_skill)

*   **Responsable:** **DEV-PROD**
*   **Rama Git:** `feature/05-crud-products`
*   **Fase:** CRUD y Panel (Días 5 - 7)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Instrucciones de Implementación
1.  **Generar modelos y archivos de migración:**
    ```powershell
    php artisan make:model Category -m
    ```
    ```powershell
    php artisan make:model Product -m
    ```
2.  **Configurar esquemas de base de datos:**
    *   En migración `categories`: agregar campos `name`, `slug` y `description`.
    *   En migración `products`: agregar claves foráneas `category_id`, campos `name`, `slug`, `price`, `description`, `image_path` y `status`.
    *   Ejecutar `php artisan migrate`.
3.  **Configurar relaciones Eloquent:**
    *   `Category` -> `hasMany(Product)`
    *   `Product` -> `belongsTo(Category)`
4.  **Generar controlador de administración:**
    ```powershell
    php artisan make:controller Admin/ProductController --resource
    ```
5.  **Programar almacenamiento físico de imágenes:**
    *   Guardar los archivos en `storage/app/public/products` y ejecutar `php artisan storage:link`.
    *   **Limpieza de disco:** Al modificar la foto de un producto o al borrar un producto, eliminar el archivo antiguo usando `Storage::disk('public')->delete($oldImagePath)`.

## 2. Puntos de Control y Verificación
*   [ ] Comprobar que los productos nuevos se registran con su imagen en `/storage/products/`.
*   [ ] Probar la eliminación de un producto y verificar que su imagen correspondiente desaparece de la carpeta `products/`.
