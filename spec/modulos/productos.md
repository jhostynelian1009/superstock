# Especificación de Módulo: Gestión de Productos (CRUD)

*   **Responsable del Módulo:** **DEV-PROD**
*   **Rama Git Relacionada:** `feature/05-crud-products`
*   **Plazo de Entrega:** Días 5 al 7 del Roadmap.

---

## 1. Alcance Académico
Este módulo abarca el CRUD completo de productos y categorías requerido por la rúbrica de bases de datos y manejo de archivos en Laravel.

## 2. Historias de Usuario Asignadas
*   **HU-PROD-01 (CRUD Categorías):** Como administrador, quiero crear y listar categorías para ordenar mis productos.
*   **HU-PROD-02 (CRUD Productos):** Como administrador, quiero agregar, editar y eliminar productos con imagen para mantener actualizado el catálogo.

## 3. Campos y Validaciones
*   **Formulario Producto:**
    *   `name`: `required|string|max:255|unique:products,name,`
    *   `category_id`: `required|exists:categories,id`
    *   `price`: `required|numeric|min:0.01`
    *   `image`: `nullable|image|mimes:jpeg,png,webp|max:2048`
    *   `status`: `required|in:active,inactive`
*   **Lógica de Archivos:**
    *   Guardar imágenes en `storage/app/public/products` con nombres únicos (`time() . '_' . $file->getClientOriginalName()`).
    *   Al actualizar o eliminar un producto, eliminar el archivo físico antiguo utilizando la fachada `Storage::disk('public')->delete()`.
