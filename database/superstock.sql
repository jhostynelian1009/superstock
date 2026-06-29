-- ============================================================
--  SuperStock — Script de Creación de Base de Datos
--  Sistema de Inventario para Supermercado
--  Framework: Laravel 11 | Motor: MySQL 8+
--  Generado: 2026-06-29
-- ============================================================

CREATE DATABASE IF NOT EXISTS superstock
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE superstock;

-- ─────────────────────────────────────────
-- Tabla: users
-- Almacena todos los usuarios del sistema
-- (administradores y clientes)
-- ─────────────────────────────────────────
CREATE TABLE users (
    id                     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name                   VARCHAR(255)    NOT NULL,
    email                  VARCHAR(255)    NOT NULL,
    email_verified_at      TIMESTAMP       NULL,
    password               VARCHAR(255)    NOT NULL,
    document_number        VARCHAR(30)     NULL,
    phone                  VARCHAR(30)     NULL,
    role                   VARCHAR(50)     NOT NULL DEFAULT 'Cliente',
                                            -- Valores: 'Administrador', 'Empleado', 'Cliente'
    is_active              TINYINT(1)      NOT NULL DEFAULT 1,
    is_primary_admin       TINYINT(1)      NOT NULL DEFAULT 0,
    default_delivery_type  VARCHAR(30)     NULL,
    address_neighborhood   VARCHAR(100)    NULL,
    address_main_street    VARCHAR(150)    NULL,
    address_secondary_street VARCHAR(150)  NULL,
    address_reference      VARCHAR(255)    NULL,
    remember_token         VARCHAR(100)    NULL,
    created_at             TIMESTAMP       NULL,
    updated_at             TIMESTAMP       NULL,
    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: categories
-- Categorías de productos del supermercado
-- ─────────────────────────────────────────
CREATE TABLE categories (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(120)    NOT NULL,
    description VARCHAR(500)    NULL,
    created_at  TIMESTAMP       NULL,
    updated_at  TIMESTAMP       NULL,
    PRIMARY KEY (id),
    UNIQUE KEY categories_name_unique (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: products
-- Productos del supermercado
-- ─────────────────────────────────────────
CREATE TABLE products (
    id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id     BIGINT UNSIGNED NOT NULL,
    sku             VARCHAR(60)     NOT NULL,
    barcode         VARCHAR(50)     NULL,
    name            VARCHAR(180)    NOT NULL,
    description     TEXT            NULL,
    unit_of_measure VARCHAR(30)     NOT NULL,
    slug            VARCHAR(220)    NULL,
    price           DECIMAL(10,2)   NULL,
    image           VARCHAR(255)    NULL,
    is_active       TINYINT(1)      NOT NULL DEFAULT 1,
    created_at      TIMESTAMP       NULL,
    updated_at      TIMESTAMP       NULL,
    PRIMARY KEY (id),
    UNIQUE KEY products_sku_unique    (sku),
    UNIQUE KEY products_barcode_unique (barcode),
    UNIQUE KEY products_slug_unique    (slug),
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories (id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: suppliers
-- Proveedores de productos
-- ─────────────────────────────────────────
CREATE TABLE suppliers (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(180)    NOT NULL,
    contact_name VARCHAR(120)    NULL,
    email        VARCHAR(180)    NULL,
    phone        VARCHAR(30)     NULL,
    address      TEXT            NULL,
    created_at   TIMESTAMP       NULL,
    updated_at   TIMESTAMP       NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: inventories
-- Existencias actuales de cada producto
-- (relación 1:1 con products)
-- ─────────────────────────────────────────
CREATE TABLE inventories (
    id            BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    product_id    BIGINT UNSIGNED  NOT NULL,
    current_stock DECIMAL(14,3)    NOT NULL DEFAULT 0.000,
    minimum_stock DECIMAL(14,3)    NOT NULL DEFAULT 0.000,
    created_at    TIMESTAMP        NULL,
    updated_at    TIMESTAMP        NULL,
    PRIMARY KEY (id),
    UNIQUE KEY inventories_product_id_unique (product_id),
    CONSTRAINT fk_inventories_product
        FOREIGN KEY (product_id) REFERENCES products (id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: inventory_movements
-- Registro de entradas y salidas de stock
-- ─────────────────────────────────────────
CREATE TABLE inventory_movements (
    id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id    BIGINT UNSIGNED NOT NULL,
    user_id       BIGINT UNSIGNED NOT NULL,
    supplier_id   BIGINT UNSIGNED NULL,
    movement_type VARCHAR(10)     NOT NULL,
                                   -- Valores: 'Entrada', 'Salida'
    quantity      DECIMAL(14,3)   NOT NULL,
    occurred_at   DATETIME        NOT NULL,
    reason        VARCHAR(255)    NOT NULL,
    reference     VARCHAR(100)    NULL,
    created_at    TIMESTAMP       NULL,
    CONSTRAINT fk_inv_movements_product
        FOREIGN KEY (product_id)  REFERENCES products  (id) ON DELETE RESTRICT,
    CONSTRAINT fk_inv_movements_user
        FOREIGN KEY (user_id)     REFERENCES users      (id) ON DELETE RESTRICT,
    CONSTRAINT fk_inv_movements_supplier
        FOREIGN KEY (supplier_id) REFERENCES suppliers  (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: orders
-- Pedidos de clientes
-- ─────────────────────────────────────────
CREATE TABLE orders (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    BIGINT UNSIGNED NOT NULL,
    status     VARCHAR(30)     NOT NULL DEFAULT 'pendiente',
                                -- Valores: 'pendiente', 'procesando', 'completado', 'cancelado'
    total      DECIMAL(10,2)   NOT NULL DEFAULT 0.00,
    notes      TEXT            NULL,
    created_at TIMESTAMP       NULL,
    updated_at TIMESTAMP       NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: order_items
-- Líneas de detalle de cada pedido
-- ─────────────────────────────────────────
CREATE TABLE order_items (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id   BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity   DECIMAL(14,3)   NOT NULL,
    unit_price DECIMAL(10,2)   NOT NULL,
    created_at TIMESTAMP       NULL,
    updated_at TIMESTAMP       NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)   REFERENCES orders   (id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tabla: admin_access_requests
-- Solicitudes para acceder como administrador
-- ─────────────────────────────────────────
CREATE TABLE admin_access_requests (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    BIGINT UNSIGNED NOT NULL,
    status     VARCHAR(20)     NOT NULL DEFAULT 'pendiente',
                                -- Valores: 'pendiente', 'aprobado', 'rechazado'
    notes      TEXT            NULL,
    created_at TIMESTAMP       NULL,
    updated_at TIMESTAMP       NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_admin_requests_user
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Tablas de infraestructura Laravel
-- (cache, sessions, jobs, failed_jobs)
-- ─────────────────────────────────────────
CREATE TABLE cache (
    `key`       VARCHAR(255) NOT NULL,
    value       MEDIUMTEXT   NOT NULL,
    expiration  INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key`      VARCHAR(255) NOT NULL,
    owner      VARCHAR(255) NOT NULL,
    expiration INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sessions (
    id            VARCHAR(255)    NOT NULL,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45)     NULL,
    user_agent    TEXT            NULL,
    payload       LONGTEXT        NOT NULL,
    last_activity INT             NOT NULL,
    PRIMARY KEY (id),
    KEY sessions_user_id_index       (user_id),
    KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE jobs (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    queue        VARCHAR(255)    NOT NULL,
    payload      LONGTEXT        NOT NULL,
    attempts     TINYINT UNSIGNED NOT NULL,
    reserved_at  INT UNSIGNED    NULL,
    available_at INT UNSIGNED    NOT NULL,
    created_at   INT UNSIGNED    NOT NULL,
    PRIMARY KEY (id),
    KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id             VARCHAR(255) NOT NULL,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INT          NOT NULL,
    pending_jobs   INT          NOT NULL,
    failed_jobs    INT          NOT NULL,
    failed_job_ids LONGTEXT     NOT NULL,
    options        MEDIUMTEXT   NULL,
    cancelled_at   INT          NULL,
    created_at     INT          NOT NULL,
    finished_at    INT          NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    uuid       VARCHAR(255)    NOT NULL,
    connection TEXT            NOT NULL,
    queue      TEXT            NOT NULL,
    payload    LONGTEXT        NOT NULL,
    exception  LONGTEXT        NOT NULL,
    failed_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────
-- Datos iniciales: usuario administrador
-- ─────────────────────────────────────────
-- Contraseña: Admin1234! (hash bcrypt)
INSERT INTO users (name, email, password, role, is_active, is_primary_admin, created_at, updated_at)
VALUES (
    'Administrador Principal',
    'admin@superstock.ec',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Administrador',
    1,
    1,
    NOW(),
    NOW()
);
-- NOTA: Cambia la contraseña en producción
-- Para generar un hash correcto usa: php artisan tinker => Hash::make('TuContraseña')
