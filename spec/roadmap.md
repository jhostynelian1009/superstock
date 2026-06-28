# Roadmap y Planificación de 12 Días - SnackConnect Laravel

Debido a la restricción de **12 días** para la entrega final del proyecto académico, la planificación se establece con un calendario estricto de entregables diarios.

---

## 1. Roadmap Diario (Calendario de 12 Días)

### Hito 1: Cimientos (Días 1 - 2)
*   **Día 1:** Inicialización del proyecto Laravel, configuración de la base de datos MySQL 8.x y configuración del repositorio en GitHub (**Líder Técnico**).
*   **Día 2:** Estructuración de archivos de migración iniciales, seeds y definición de layouts Blade compartidos (**Líder Técnico** y **QA**).
*   *Merge Hito 1:* Integración y congelamiento de la rama base `develop`.

### Hito 2: Módulos de Núcleo (Días 3 - 4)
*   **Día 3:** Implementación del Login, Registro y middleware de autenticación privada (**DEV-AUTH**).
*   **Día 4:** Diseño y maquetación de la Landing Page dinámica y cabeceras responsive (**DEV-FRONT**).
*   *Merge Hito 2:* Apertura y merge de PRs `feature/02-auth` y `feature/01-landing` tras pruebas de QA.

### Hito 3: Funcionalidades Administrativas (Días 5 - 7)
*   **Día 5:** Desarrollo del CRUD de Categorías y Productos, incluyendo la lógica de subida de imágenes (**DEV-PROD**).
*   **Día 6:** Construcción del Dashboard Administrativo, visualización de métricas dinámicas de DB (**DEV-DASH**).
*   **Día 7:** Conexión de CRUD y Dashboard con el layout maestro de administración (**DEV-PROD** y **DEV-DASH**).
*   *Merge Hito 3:* Fusión de ramas hacia `develop` evaluada por **QA**.

### Hito 4: Catálogo y WhatsApp (Días 8 - 9)
*   **Día 8:** Mapeo de productos en el Catálogo Público, filtros por categorías y barra de búsqueda (**DEV-FRONT**).
*   **Día 9:** Integración de LocalStorage en el carrito de compras e implementación del botón dinámico de redirección a WhatsApp (**LT** y **DEV-FRONT**).
*   *Merge Hito 4:* Cierre de funcionalidades a nivel de código.

### Hito 5: Pruebas, Hardening y Cierre (Días 10 - 12)
*   **Día 10:** Implementación final de Feature Tests automatizados y corrección de bugs reportados (**QA** y desarrolladores).
*   **Día 11:** Auditoría de seguridad (CSRF, XSS, rate limiting), refactorización de código estilo PSR-12 (**QA** y **LT**).
*   **Día 12:** Congelamiento de código, merge final de `develop` hacia `main`, preparación de la base de datos con datos de muestra y armado de la presentación para evaluación académica (**Todo el equipo**).
