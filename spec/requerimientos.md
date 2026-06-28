# Requerimientos del Sistema - SnackConnect Laravel (Rúbrica Académica)

Para cumplir exitosamente con la rúbrica de evaluación del proyecto, los requerimientos se asignan directamente a los roles del equipo para asegurar la trazabilidad.

## 1. Requerimientos Funcionales (RF) y Asignaciones

| Código | Requerimiento | Criterio de Rúbrica Asociado | Responsable |
| :--- | :--- | :--- | :--- |
| **RF-01** | **Landing Page Dinámica** | Estética responsive, uso correcto de vistas de Blade, estructuración HTML5. | **DEV-FRONT** |
| **RF-02** | **Catálogo de Productos** | Consultas a base de datos eficientes, filtrado por categorías, buscador de texto. | **DEV-FRONT** |
| **RF-03** | **Autenticación (Auth)** | Restricción de rutas privadas, hashing de contraseñas, validación de login/registro. | **DEV-AUTH** |
| **RF-04** | **Dashboard Admin** | Layout administrativo coherente, conteo dinámico de datos de DB. | **DEV-DASH** |
| **RF-05** | **CRUD de Productos** | Operaciones CRUD completas, validación de archivos (imágenes), relaciones Eloquent. | **DEV-PROD** |
| **RF-06** | **Botón de Checkout** | Generación de enlaces URL seguros y preformateados para la API de WhatsApp. | **LT / DEV-FRONT** |

---

## 2. Requerimientos No Funcionales (RNF) y Calidad

| Código | Criterio de Calidad | Criterio de Rúbrica Asociado | Responsable |
| :--- | :--- | :--- | :--- |
| **RNF-01** | **Seguridad CSRF/XSS** | Protección obligatoria de formularios y escape de variables en Blade. | **DEV-AUTH / QA** |
| **RNF-02** | **Pruebas Automatizadas** | Mínimo de 8 Feature Tests válidos implementados cubriendo Auth, CRUD y filtros. | **QA** |
| **RNF-03** | **Estándar de Base de Datos**| Configuración y uso de MySQL 8.x para compatibilidad local con XAMPP y phpMyAdmin. | **LT** |
| **RNF-04** | **Clean Code / PSR-12** | Estilo de código consistente sin advertencias de linters. | **Todos / QA** |

---

## 3. Reglas de Negocio Prioritarias (RN)
*   **RN-01:** Solo los usuarios con rol de `admin` pueden acceder a `/admin/*`. Los intentos de acceso sin sesión redirigen a `/login` (Responsable: **DEV-AUTH**).
*   **RN-02:** Los archivos cargados para productos deben ser exclusivamente imágenes (JPEG, PNG, WEBP) de máximo 2MB para evitar errores de cuota de disco (Responsable: **DEV-PROD**).
*   **RN-03:** El checkout debe limpiar el carrito en `localStorage` inmediatamente tras redireccionar al cliente a WhatsApp (Responsable: **DEV-FRONT**).
