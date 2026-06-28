# Skill Runbook: Catálogo Público y Filtros (catalogo_skill)

*   **Responsable:** **DEV-FRONT**
*   **Rama Git:** `feature/03-catalog`
*   **Fase:** Compra y Catálogo (Día 8)

---

## 0. Prerrequisito Obligatorio — Design System

> **⚠ ANTES de implementar cualquier interfaz**, leer obligatoriamente:
> *   [spec/design/design-system.md](../spec/design/design-system.md)
> *   [spec/design/ui-components.md](../spec/design/ui-components.md)
>
> **Ningún componente visual puede crearse fuera del sistema de diseño aprobado.**

---

## 1. Instrucciones de Implementación
1.  **Crear el controlador público del catálogo:**
    ```powershell
    php artisan make:controller CatalogController
    ```
2.  **Configurar lógica de filtrado dinámico (`CatalogController@index`):**
    *   Iniciar consulta apuntando a productos con estado activo: `$query = Product::where('status', 'active');`.
    *   Filtrar por categoría si se recibe el parámetro en la URL: `whereHas('category', ...)`.
    *   Filtrar por texto si se ingresa texto en la barra de búsqueda: `where('name', 'like', '%' . $search . '%')`.
    *   Asegurar paginación de los productos: `paginate(12)->withQueryString()`.
3.  **Desarrollar vistas públicas Blade:**
    *   `/resources/views/catalog/index.blade.php`: Listado de productos, input de búsqueda y barra lateral/horizontal de categorías.
    *   `/resources/views/catalog/show.blade.php`: Ficha técnica y detallada del producto.

## 2. Puntos de Control y Verificación
*   [ ] Comprobar que al buscar un término (ej. "Muffin"), el paginador conserve el término de búsqueda al cambiar de página.
*   [ ] Verificar que los productos inactivos (`inactive`) no aparezcan en la cuadrícula del catálogo público.
