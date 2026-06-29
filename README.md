# 🛒 SuperStock — Sistema de Inventario para Supermercado

> Proyecto grupal universitario — Desarrollo Web con Frameworks Modernos

---

## 📌 Objetivo General del Sistema

SuperStock es una aplicación web dinámica para la **gestión de inventario de un supermercado**. Permite administrar productos, categorías, stock, proveedores, usuarios y el registro de entradas/salidas de mercancía. El sistema cuenta con un panel administrativo completo, autenticación por roles y una interfaz responsiva y organizada.

---

## 🛠️ Framework Seleccionado

**Laravel 11** (PHP)

### Justificación técnica
- **ORM Eloquent**: Permite modelar las relaciones entre entidades (productos, categorías, inventario) de forma expresiva sin SQL manual.
- **Sistema de migrations**: Control de versiones de la base de datos, facilitando la instalación y colaboración en equipo.
- **Blade Templating**: Motor de plantillas limpio que permite componentes reutilizables y herencia de layouts.
- **Middleware de autenticación**: Gestión de roles (Administrador / Cliente) de forma nativa.
- **Artisan CLI**: Comandos para seeders, factories y generación de código que aceleran el desarrollo.
- **Ecosistema maduro**: Documentación extensa, comunidad activa y paquetes de terceros para cualquier necesidad.

---

## 🗄️ Base de Datos Utilizada

**MySQL 8+**

### Razón de elección
- Motor relacional estándar en la industria, compatible con XAMPP (entorno de desarrollo local).
- Soporte nativo en Laravel con driver `pdo_mysql`.
- Integridad referencial con llaves foráneas (FK), garantizando consistencia entre productos, inventario y movimientos.
- Amplia documentación y herramientas visuales (phpMyAdmin, DBeaver, MySQL Workbench).

---

## 🏗️ Arquitectura Implementada

**Arquitectura MVC (Modelo-Vista-Controlador)** con separación por módulos de dominio.

```
┌─────────────────────────────────────────────────────────────┐
│                     CLIENTE (Browser)                       │
└─────────────────────────┬───────────────────────────────────┘
                          │ HTTP Request
                          ▼
┌─────────────────────────────────────────────────────────────┐
│              ROUTES (web.php)                               │
│  Middleware: auth, admin, client, primary_admin             │
└─────────────────────────┬───────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│           CONTROLLERS (App\Http\Controllers)                │
│  Admin\: Dashboard, Product, Category, Inventory,          │
│          InventoryMovement, Supplier, User, Order           │
│  Auth\:  AuthController, AdminRegistrationController        │
└──────────┬──────────────────────────────────┬──────────────┘
           │                                  │
           ▼                                  ▼
┌──────────────────────┐          ┌───────────────────────────┐
│   MODELS (Eloquent)  │          │   VIEWS (Blade Templates) │
│  User, Product,      │          │  layouts/admin.blade.php  │
│  Category, Supplier, │          │  admin/{module}/          │
│  Inventory,          │          │  auth/                    │
│  InventoryMovement,  │          └───────────────────────────┘
│  Order, OrderItem    │
└──────────┬───────────┘
           │
           ▼
┌─────────────────────────────────────────────────────────────┐
│              BASE DE DATOS (MySQL)                          │
│  users · categories · products · suppliers                  │
│  inventories · inventory_movements · orders · order_items   │
└─────────────────────────────────────────────────────────────┘
```

### Justificación de la arquitectura
MVC es el patrón nativo de Laravel y el más adecuado para este proyecto porque:
1. **Separación de responsabilidades**: Cada capa tiene un rol claro (datos, lógica, presentación).
2. **Mantenibilidad**: Agregar nuevos módulos no afecta los existentes.
3. **Testabilidad**: Los Controllers y Models pueden probarse de forma independiente.
4. **Escalabilidad**: Preparado para crecer hacia una API REST si se requiere en el futuro.

---

## 📦 Módulos y Funcionalidades

| Módulo | Descripción | Rutas |
|--------|-------------|-------|
| **Autenticación** | Login por rol (Admin/Cliente), registro, cierre de sesión | `/login`, `/register` |
| **Dashboard** | KPIs (productos, categorías, proveedores, stock bajo), movimientos recientes, alertas | `/admin/dashboard` |
| **Gestión de Productos** | CRUD completo, búsqueda por nombre/SKU/código de barras, activar/desactivar | `/admin/productos` |
| **Gestión de Categorías** | CRUD completo, búsqueda, conteo de productos por categoría | `/admin/categorias` |
| **Gestión de Proveedores** | CRUD completo, datos de contacto | `/admin/proveedores` |
| **Inventario** | Consulta de existencias actuales, stock mínimo, estado (disponible/bajo/agotado) | `/admin/inventario` |
| **Movimientos de Inventario** | Registro de entradas y salidas, filtros por producto/tipo/fecha, historial | `/admin/movimientos` |
| **Gestión de Usuarios** | Listado de todos los usuarios, búsqueda, filtro por rol, activar/desactivar cuentas | `/admin/usuarios` |
| **Pedidos** | Listado y detalle de pedidos de clientes | `/admin/pedidos` |
| **Solicitudes Admin** | Aprobación/rechazo de solicitudes para acceso de administrador (solo admin principal) | `/admin/solicitudes-admin` |

---

## 🔧 Tecnologías Complementarias

| Tecnología | Uso |
|------------|-----|
| **Vite** | Bundling de assets CSS/JS con HMR en desarrollo |
| **Tailwind CSS (parcial)** | Clases utilitarias en vistas, junto con CSS custom variables |
| **Bunny Fonts / Instrument Sans** | Tipografía del panel administrativo |
| **Heroicons** | Iconografía SVG inline en el sidebar y tarjetas |
| **Carbon (PHP)** | Manipulación y formateo de fechas en español |
| **Laravel Factories & Seeders** | Datos de prueba realistas para desarrollo |
| **XAMPP / Apache** | Servidor local de desarrollo (PHP + MySQL) |

---

## 🗃️ Modelo de Base de Datos

### Diagrama de Entidad-Relación (MER)

```
users
  ├── id (PK)
  ├── name, email, password
  ├── document_number, phone
  ├── role (Administrador | Empleado | Cliente)
  ├── is_active, is_primary_admin
  └── address fields...
      │
      ├──< orders (1:N)
      │       ├── id (PK)
      │       ├── user_id (FK → users)
      │       ├── status, total, notes
      │       └──< order_items (1:N)
      │               ├── order_id (FK → orders)
      │               ├── product_id (FK → products)
      │               ├── quantity, unit_price
      │
      └──< inventory_movements (1:N)
              ├── user_id (FK → users)
              ├── product_id (FK → products)
              ├── supplier_id (FK → suppliers, nullable)
              ├── movement_type (Entrada | Salida)
              ├── quantity, occurred_at, reason, reference

categories
  ├── id (PK)
  ├── name (unique), description
  └──< products (1:N)
          ├── id (PK)
          ├── category_id (FK → categories)
          ├── sku (unique), barcode (unique), slug (unique)
          ├── name, description, unit_of_measure
          ├── price, image, is_active
          └──1 inventories (1:1)
                  ├── product_id (FK → products)
                  ├── current_stock
                  └── minimum_stock

suppliers
  ├── id (PK)
  ├── name, contact_name
  ├── email, phone, address
  └──< inventory_movements (1:N)
```

### Descripción de tablas y relaciones

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios del sistema. Un usuario puede ser Administrador, Empleado o Cliente. |
| `categories` | Clasificaciones de productos (Lácteos, Bebidas, Limpieza, etc.). |
| `products` | Catálogo de productos del supermercado. Cada producto pertenece a una categoría. |
| `suppliers` | Proveedores de mercancía. Se asocian a movimientos de entrada. |
| `inventories` | Registro de existencias. Relación 1:1 con productos. Contiene stock actual y mínimo. |
| `inventory_movements` | Historial de entradas y salidas de stock. Vinculado a producto, usuario y proveedor. |
| `orders` | Pedidos realizados por clientes. |
| `order_items` | Líneas de detalle de cada pedido (producto + cantidad + precio). |
| `admin_access_requests` | Solicitudes de usuarios para obtener rol de administrador. |

---

## 📸 Capturas de Pantalla

> *(Se agregarán en la entrega final del proyecto)*

---

## ⚙️ Guía de Instalación

### Requisitos previos
- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18 + npm
- MySQL 8+ (o XAMPP con MySQL)
- Git

### Pasos de instalación

#### 1. Clonar el repositorio
```bash
git clone https://github.com/TU_USUARIO/superstock.git
cd superstock
```

#### 2. Instalar dependencias PHP
```bash
cd app
composer install
```

#### 3. Instalar dependencias Node.js
```bash
npm install
```

#### 4. Configurar el entorno
```bash
cp .env.example .env
php artisan key:generate
```

#### 5. Configurar la base de datos en `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306          # XAMPP usa 3307 por defecto si hay conflicto
DB_DATABASE=superstock
DB_USERNAME=root
DB_PASSWORD=          # Dejar vacío si no tiene contraseña
```

#### 6. Crear la base de datos
**Opción A** — Con el script SQL directo:
```sql
-- Ejecutar en phpMyAdmin o MySQL Workbench:
source database/superstock.sql;
```

**Opción B** — Con migrations de Laravel:
```bash
php artisan migrate
```

#### 7. Sembrar datos de prueba
```bash
php artisan db:seed
```
Esto crea:
- 1 usuario administrador principal
- 6 categorías de productos
- 30+ productos de supermercado
- 5 proveedores
- Inventario para todos los productos
- 50+ movimientos de inventario de ejemplo

---

## 🚀 Guía de Ejecución

### Modo desarrollo (recomendado)

**Terminal 1 — Servidor Laravel:**
```bash
cd app
php artisan serve
```
Disponible en: http://localhost:8000

> **Con XAMPP**: Asegúrate de que Apache y MySQL estén corriendo. Accede a: http://localhost/superstock/app/public

**Terminal 2 — Assets con Vite:**
```bash
cd app
npm run dev
```

### Credenciales de acceso por defecto

| Usuario | Email | Contraseña | Rol |
|---------|-------|------------|-----|
| Admin Principal | admin@superstock.ec | Admin1234! | Administrador |

> ⚠️ **Importante**: Cambiar la contraseña antes de cualquier despliegue en producción.

---

## 📋 Dependencias Necesarias

### PHP (composer.json)
- `laravel/framework: ^11.0`
- `laravel/tinker: ^2.9`

### Node.js (package.json)
- `laravel-vite-plugin: ^1.0`
- `vite: ^5.0`

### Sistema
- PHP Extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`
- MySQL 8.0+

---

## 👥 Integrantes del Grupo

| Nombre | Rol en el proyecto |
|--------|-------------------|
| *(Nombre 1)* | Líder técnico / Backend |
| *(Nombre 2)* | Base de datos / Migraciones |
| *(Nombre 3)* | Frontend / Vistas Blade |
| *(Nombre 4)* | Documentación / README |
| *(Nombre 5)* | Testing / Seeders |

> *(Completar con los integrantes reales del grupo)*

---

## 📝 Conclusiones del Proyecto

1. **Laravel como framework de elección** demostró ser una herramienta robusta para el desarrollo ágil de aplicaciones web con base de datos relacional. El ORM Eloquent simplificó enormemente las operaciones CRUD y las relaciones entre entidades.

2. **El diseño de la base de datos** fue fundamental para garantizar la integridad de los datos. La separación de `inventories` e `inventory_movements` permite mantener un historial completo sin comprometer el rendimiento de consultas de stock actual.

3. **La arquitectura MVC** facilitó el trabajo en equipo, ya que cada integrante pudo trabajar en su capa (modelos, controladores, vistas) sin interferir con el trabajo de los demás.

4. **Los seeders y factories** de Laravel fueron clave para generar datos de prueba realistas, lo que permitió probar todos los módulos del sistema sin necesidad de ingresar datos manualmente.

5. **El sistema de roles y middleware** garantiza que solo los administradores accedan al panel de gestión, mientras que los clientes tienen su propio espacio, demostrando buenas prácticas de seguridad en aplicaciones web.

---

## 🌐 Despliegue

*(Sección a completar si se despliega en plataformas cloud)*

Plataformas recomendadas: **Railway**, **Render**, **Fly.io**

---

*SuperStock © 2026 — Proyecto académico universitario*
