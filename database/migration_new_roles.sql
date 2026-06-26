-- ============================================================
-- Migration: Nuevos roles de usuario y tablas adicionales
-- Plataforma Turística Colón
-- ============================================================

-- 1. Modificar ENUM de roles para incluir nuevos tipos de usuario
ALTER TABLE `users` 
  MODIFY COLUMN `role` ENUM('visitor','admin','superadmin','prestador','colaborador','turista') NOT NULL DEFAULT 'turista';

-- 2. Agregar columnas a businesses para nuevas funcionalidades
ALTER TABLE `businesses`
  ADD COLUMN `is_open` TINYINT(1) NOT NULL DEFAULT 1 AFTER `featured`,
  ADD COLUMN `open_for_messaging` ENUM('24hrs','schedule') NOT NULL DEFAULT 'schedule' AFTER `is_open`,
  ADD COLUMN `google_maps_link` VARCHAR(500) DEFAULT NULL AFTER `open_for_messaging`,
  ADD COLUMN `waze_link` VARCHAR(500) DEFAULT NULL AFTER `google_maps_link`,
  ADD COLUMN `languages` VARCHAR(255) DEFAULT NULL COMMENT 'Idiomas separados por coma' AFTER `waze_link`,
  ADD COLUMN `max_images` INT UNSIGNED NOT NULL DEFAULT 6 AFTER `languages`,
  ADD COLUMN `self_classification` TEXT DEFAULT NULL COMMENT 'Autoclasificación del prestador' AFTER `max_images`;

-- 3. Tabla de contactos (CRM)
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `business_id` INT UNSIGNED NOT NULL,
  `wa_id` VARCHAR(30) DEFAULT NULL COMMENT 'ID de WhatsApp del contacto',
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(191) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `category` ENUM('prospecto','cliente','lovemark') NOT NULL DEFAULT 'prospecto',
  `source` ENUM('whatsapp','mapa','manual') NOT NULL DEFAULT 'manual',
  `notes` TEXT DEFAULT NULL,
  `total_visits` INT UNSIGNED NOT NULL DEFAULT 0,
  `total_purchases` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `last_contact_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`business_id`) REFERENCES `businesses`(`id`) ON DELETE CASCADE,
  INDEX `idx_wa_id` (`wa_id`),
  INDEX `idx_category` (`category`),
  INDEX `idx_business_category` (`business_id`, `category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabla de compras/visitas de contactos
CREATE TABLE IF NOT EXISTS `contact_purchases` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `contact_id` INT UNSIGNED NOT NULL,
  `business_id` INT UNSIGNED NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `products` TEXT DEFAULT NULL COMMENT 'JSON con productos/servicios comprados',
  `notes` TEXT DEFAULT NULL,
  `purchase_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`contact_id`) REFERENCES `contacts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`business_id`) REFERENCES `businesses`(`id`) ON DELETE CASCADE,
  INDEX `idx_contact` (`contact_id`),
  INDEX `idx_business` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla de promociones
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `business_id` INT UNSIGNED DEFAULT NULL COMMENT 'NULL si es promoción global',
  `user_id` INT UNSIGNED NOT NULL COMMENT 'Creador de la promoción',
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `price` DECIMAL(12,2) DEFAULT NULL COMMENT 'Precio de lista',
  `presale_price` DECIMAL(12,2) DEFAULT NULL COMMENT 'Precio de preventa',
  `conditions` TEXT DEFAULT NULL COMMENT 'Condiciones generales',
  `public_url` VARCHAR(500) DEFAULT NULL COMMENT 'URL pública para más info',
  `type` ENUM('promocion','evento') NOT NULL DEFAULT 'promocion',
  `target_segment` SET('prospectos_sin_historial','prospectos_recurrentes','clientes','clientes_frecuentes','todos') NOT NULL DEFAULT 'todos',
  `status` ENUM('pending','approved','active','inactive','expired') NOT NULL DEFAULT 'pending',
  `approved_by` INT UNSIGNED DEFAULT NULL COMMENT 'ID del colaborador/superadmin que aprobó',
  `start_date` DATETIME DEFAULT NULL,
  `end_date` DATETIME DEFAULT NULL,
  `presale_start` DATETIME DEFAULT NULL COMMENT 'Inicio de preventa',
  `presale_end` DATETIME DEFAULT NULL COMMENT 'Fin de preventa',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`business_id`) REFERENCES `businesses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX `idx_status` (`status`),
  INDEX `idx_business` (`business_id`),
  INDEX `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabla de envíos de promociones
CREATE TABLE IF NOT EXISTS `promotion_sends` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `promotion_id` INT UNSIGNED NOT NULL,
  `contact_id` INT UNSIGNED DEFAULT NULL,
  `sent_via` ENUM('whatsapp','chatbot','email') NOT NULL DEFAULT 'whatsapp',
  `sent_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`promotion_id`) REFERENCES `promotions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`contact_id`) REFERENCES `contacts`(`id`) ON DELETE SET NULL,
  INDEX `idx_promotion` (`promotion_id`),
  INDEX `idx_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabla de números de emergencia
CREATE TABLE IF NOT EXISTS `emergency_numbers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(120) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabla de perfiles de turistas
CREATE TABLE IF NOT EXISTS `tourist_profiles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  `whatsapp` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(191) DEFAULT NULL,
  `preferences` TEXT DEFAULT NULL COMMENT 'JSON con preferencias',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;