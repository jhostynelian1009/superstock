# Especificación de Módulo: Dashboard Administrativo

*   **Responsable del Módulo:** **DEV-DASH**
*   **Rama Git Relacionada:** `feature/04-dashboard`
*   **Plazo de Entrega:** Días 5 al 7 del Roadmap.

---

## 1. Alcance Académico
El panel provee la visualización dinámica exigida en la rúbrica de interfaces internas. Muestra un resumen del estado del sistema y accesos directos al CRUD de productos.

## 2. Historias de Usuario Asignadas
*   **HU-DASH-01 (Métricas rápidas):** Como administrador, quiero ver los contadores de productos y alertas de stock agotado para tomar decisiones de reabastecimiento.
*   **HU-DASH-02 (Vista general):** Como administrador, quiero ver los últimos productos cargados en una tabla.

## 3. Lógica y Vista (`/admin/dashboard`)
*   **Consultas Eloquent (Evitar N+1):**
    *   `Product::count()` (Total de productos)
    *   `Product::where('status', 'inactive')->count()` (Productos agotados)
    *   `Product::with('category')->latest()->take(5)->get()` (Eager loading para la tabla de recientes)
*   **UI/UX:**
    *   Integrar barra lateral de navegación estructurada.
    *   Diseñar tarjetas métricas premium y tabla de productos recientes.
