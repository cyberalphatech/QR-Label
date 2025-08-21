-- Wine QR Labels Database Schema
-- This script creates all necessary tables for the wine QR label system

-- Main labels table
CREATE TABLE IF NOT EXISTS `tblqr_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` varchar(50) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `ID_producer` int(11) DEFAULT NULL,
  `printing_id` int(11) DEFAULT NULL,
  `oenology_id` int(11) DEFAULT NULL,
  `wine_name` varchar(255) NOT NULL,
  `producer_name` varchar(255) DEFAULT NULL,
  `vintage` varchar(10) DEFAULT NULL,
  `alcohol_content` decimal(4,2) DEFAULT NULL,
  `volume` varchar(20) DEFAULT NULL,
  `wine_type` varchar(50) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `grape_varieties` text,
  `tasting_notes` text,
  `serving_temperature` varchar(50) DEFAULT NULL,
  `food_pairing` text,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `lot_number` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_published` datetime DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `is_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label_id` (`label_id`),
  KEY `idx_producer` (`ID_producer`),
  KEY `idx_status` (`status`),
  KEY `idx_deleted` (`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Nutrition information table
CREATE TABLE IF NOT EXISTS `tblqr_labels_nutrition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` varchar(50) NOT NULL,
  `energy_kj` decimal(8,2) DEFAULT NULL,
  `energy_kcal` decimal(8,2) DEFAULT NULL,
  `fat` decimal(8,2) DEFAULT NULL,
  `saturated_fat` decimal(8,2) DEFAULT NULL,
  `carbohydrates` decimal(8,2) DEFAULT NULL,
  `sugars` decimal(8,2) DEFAULT NULL,
  `protein` decimal(8,2) DEFAULT NULL,
  `salt` decimal(8,2) DEFAULT NULL,
  `sulfites` varchar(100) DEFAULT NULL,
  `allergens` text,
  PRIMARY KEY (`id`),
  KEY `fk_nutrition_label` (`label_id`),
  CONSTRAINT `fk_nutrition_label` FOREIGN KEY (`label_id`) REFERENCES `tblqr_labels` (`label_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Certifications table
CREATE TABLE IF NOT EXISTS `tblqr_labels_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` varchar(50) NOT NULL,
  `certification_type` enum('DOC','DOCG','IGT','EU_DOP','EU_IGP','EU_STG','EU_ORGANIC') NOT NULL,
  `certification_number` varchar(100) DEFAULT NULL,
  `certification_body` varchar(255) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cert_label` (`label_id`),
  CONSTRAINT `fk_cert_label` FOREIGN KEY (`label_id`) REFERENCES `tblqr_labels` (`label_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Recycling components master table
CREATE TABLE IF NOT EXISTS `tblqr_labels_recycling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('bottle','cork','capsule','cage','container') NOT NULL,
  `name` varchar(255) NOT NULL,
  `material` varchar(100) DEFAULT NULL,
  `recycling_code` varchar(20) DEFAULT NULL,
  `disposal_instructions` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Recycling relation table (links labels to recycling components)
CREATE TABLE IF NOT EXISTS `tblqr_labels_recycling_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` varchar(50) NOT NULL,
  `bottle_id` int(11) DEFAULT NULL,
  `cork_id` int(11) DEFAULT NULL,
  `capsule_id` int(11) DEFAULT NULL,
  `cage_id` int(11) DEFAULT NULL,
  `container_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recycling_label` (`label_id`),
  KEY `fk_bottle` (`bottle_id`),
  KEY `fk_cork` (`cork_id`),
  KEY `fk_capsule` (`capsule_id`),
  KEY `fk_cage` (`cage_id`),
  KEY `fk_container` (`container_id`),
  CONSTRAINT `fk_recycling_label` FOREIGN KEY (`label_id`) REFERENCES `tblqr_labels` (`label_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bottle` FOREIGN KEY (`bottle_id`) REFERENCES `tblqr_labels_recycling` (`id`),
  CONSTRAINT `fk_cork` FOREIGN KEY (`cork_id`) REFERENCES `tblqr_labels_recycling` (`id`),
  CONSTRAINT `fk_capsule` FOREIGN KEY (`capsule_id`) REFERENCES `tblqr_labels_recycling` (`id`),
  CONSTRAINT `fk_cage` FOREIGN KEY (`cage_id`) REFERENCES `tblqr_labels_recycling` (`id`),
  CONSTRAINT `fk_container` FOREIGN KEY (`container_id`) REFERENCES `tblqr_labels_recycling` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Business/Producer information table
CREATE TABLE IF NOT EXISTS `tblqr_labels_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producer_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `user_type` enum('producer','printing','oenology') DEFAULT 'producer',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `producer_id` (`producer_id`),
  KEY `idx_user_type` (`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Insert default recycling components
INSERT IGNORE INTO `tblqr_labels_recycling` (`type`, `name`, `material`, `recycling_code`, `disposal_instructions`) VALUES
('bottle', 'Standard Glass Bottle', 'Glass', 'GL-70', 'Dispose in glass recycling bin'),
('bottle', 'Antique Glass Bottle', 'Glass', 'GL-71', 'Dispose in glass recycling bin'),
('cork', 'Natural Cork', 'Cork', 'FOR-51', 'Compostable or general waste'),
('cork', 'Synthetic Cork', 'Plastic', 'OTHER-7', 'General waste'),
('cork', 'Screw Cap', 'Aluminum', 'ALU-41', 'Metal recycling'),
('capsule', 'Aluminum Capsule', 'Aluminum', 'ALU-41', 'Metal recycling'),
('capsule', 'Plastic Capsule', 'Plastic', 'OTHER-7', 'General waste'),
('cage', 'Wire Cage', 'Metal', 'FE-40', 'Metal recycling'),
('container', 'Cardboard Box', 'Cardboard', 'PAP-20', 'Paper recycling');
