# Especificación de Módulo: Catálogo Público

*   **Responsable del Módulo:** **DEV-FRONT**
*   **Rama Git Relacionada:** `feature/03-catalog`
*   **Plazo de Entrega:** Día 8 del Roadmap.

---

## 1. Alcance Académico
Este módulo cubre la vista de cara al cliente final, exigiendo un diseño visual responsivo (Mobile-First) y consultas parametrizadas (búsqueda y filtros).

## 2. Historias de Usuario Asignadas
*   **HU-CAT-01 (Ver Catálogo):** Como cliente, deseo ver la cuadrícula de productos disponibles para elegir qué comprar.
*   **HU-CAT-02 (Filtrar por Categoría):** Como cliente, deseo seleccionar una categoría para acotar la búsqueda de snacks.
*   **HU-CAT-03 (Buscador):** Como cliente, deseo buscar productos ingresando texto en el campo de búsqueda.

## 3. Lógica y Estructura
*   **Ruta:** `GET /catalogo`
*   **Consultas SQL Seguras:**
    *   Filtrar por categoría (usando `whereHas('category')`).
    *   Filtrar por texto (usando `where('name', 'like', ...)`).
    *   Paginación de resultados: `paginate(12)`.
*   **Interfaz:**
    *   Buscador dinámico en la parte superior.
    *   Barra de filtros de categorías desplazable horizontalmente en móviles.
    *   Grid responsivo de productos (1 columna en móviles, 2 en tablets, 4 en PC).
    *   Los productos inactivos (`inactive`) deben renderizarse con un estilo opaco que indique "Agotado" y deshabilitar su compra.
