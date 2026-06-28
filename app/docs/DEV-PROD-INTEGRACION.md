# Módulo DEV-PROD — Productos y Categorías

**Responsable:** Jaider-Tapuyo  
**Rama:** `feature/05-crud-products` / `Jaider-Tapuyo`

## Fuente de verdad de datos

La estructura y los datos de ejemplo del módulo se definen exclusivamente mediante:

- Migraciones: `database/migrations/2026_06_04_000001_create_categories_table.php`, `2026_06_04_000002_create_products_table.php`
- Seeders: `CategorySeeder`, `ProductSeeder`

**No** incluir `database/database.sqlite` ni otros archivos de base de datos local en commits. Cada entorno debe ejecutar:

```bash
php artisan migrate --force
php artisan db:seed --class=CategorySeeder --force
php artisan db:seed --class=ProductSeeder --force
```

No usar `migrate:fresh` en integración salvo indicación explícita del Líder Técnico.

## Dependencia de layout administrativo

Las vistas CRUD del módulo (`resources/views/admin/**`) extienden:

```blade
@extends('layouts.admin')
```

Ese layout (`resources/views/layouts/admin.blade.php`) **no forma parte de DEV-PROD**. Está pendiente de entrega por **DEV-DASH** (Dashboard / Layout Administrativo).

Hasta que exista `layouts.admin`, las rutas del CRUD responderán con error de vista al intentar renderizar. El backend (modelos, rutas, controladores, validaciones) permanece listo para integración.

## Integración con otros roles

| Rol | Integración sugerida |
|-----|---------------------|
| **Genesis** (Catálogo) | `Product::query()->with('category')->active()` |
| **Amy** (Dashboard) | `Product::count()`, `Product::with('category')->latest()->take(5)->get()` |
| **Jhostyn** (WhatsApp) | `Product::find($id)`, `Product::where('slug', $slug)->first()` |

## Rutas del módulo

Prefijo `/admin`, middleware `auth` (sin implementar Auth en este módulo).

- `admin.categorias.*`
- `admin.productos.*`

## Imágenes de producto

Requiere enlace simbólico de storage (una vez por entorno):

```bash
php artisan storage:link
```

Ruta de almacenamiento: `storage/app/public/products/`
