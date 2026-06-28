# Visión del Proyecto - SnackConnect Laravel (Ámbito Académico)

## 1. Introducción y Contexto Académico
Este proyecto se desarrolla en el marco de una evaluación académica universitaria. El equipo está compuesto por **6 integrantes** con roles distribuidos y cuenta con un plazo estricto de **12 días** para la entrega final. 

El principal objetivo del proyecto no es construir un sistema comercial a gran escala, sino implementar un **Mínimo Producto Viable (MVP)** que cumpla con el 100% de los lineamientos de la rúbrica de evaluación con un margen de riesgo técnico mínimo.

## 2. Propuesta de Valor Abreviada
**SnackConnect** permite a pequeños comercios locales de snacks y alimentos digitalizar su carta y recibir pedidos directos a través de WhatsApp sin intermediarios ni pasarelas de pago externas complejas, las cuales representarían un riesgo de integración inaceptable dentro del límite de 12 días.

## 3. Limitaciones y Alcance del Proyecto Académico
*   **Base de Datos Estándar:** Uso de MySQL 8.x para garantizar compatibilidad con XAMPP, phpMyAdmin y entornos reales de producción, facilitando la exposición académica.
*   **Checkout sin Pasarela de Pago:** Redirección limpia a WhatsApp que encapsula el pedido en un string URL, eliminando la necesidad de APIs de pago (Stripe, PayPal) que requieran credenciales o cuentas activas.
*   **Despliegue Local Rápido:** Configuración ágil a través del servidor local de Laravel Vite y Artisan.

## 4. Distribución General de Responsabilidades
1.  **Líder Técnico (LT):** Coordina e integra.
2.  **Autenticación (DEV-AUTH):** Asegura el acceso seguro del administrador.
3.  **Productos (DEV-PROD):** Implementa el catálogo interno (CRUD).
4.  **Frontend Público (DEV-FRONT):** Construye la cara visible del sitio (Landing y catálogo).
5.  **Dashboard (DEV-DASH):** Diseña el panel administrativo de visualización rápida.
6.  **Testing y Calidad (QA):** Verifica que todo código cumpla la rúbrica antes de integrarlo.
