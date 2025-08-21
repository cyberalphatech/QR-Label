-- QR Wine Label by BIT SOLUTIONS - Database Schema
-- Version 1.0 - Updated to match existing structure
-- External Database: 165.22.102.58

-- Dropdown list for bottle sizes and types
CREATE TABLE IF NOT EXISTS `tbldropdown_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Main wine labels table (matches existing structure)
CREATE TABLE IF NOT EXISTS `tbllabels` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label_id` varchar(255) DEFAULT NULL,
  `module_id` varchar(255) NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT 'Wine name',
  `lot` varchar(50) DEFAULT NULL,
  `BottleSize` varchar(100) DEFAULT NULL,
  `grapev` varchar(20) DEFAULT NULL COMMENT 'Grape name',
  `vintage` int(11) DEFAULT NULL COMMENT 'Year',
  `alcohol` int(11) DEFAULT NULL COMMENT '% grade',
  `serving` varchar(10) DEFAULT NULL COMMENT 'Celsius',
  `description` text DEFAULT NULL COMMENT 'Short description',
  `characteristics` text DEFAULT NULL COMMENT 'Short Characteristics',
  `Tcolor` varchar(255) DEFAULT NULL COMMENT 'Wine color',
  `Ttaste` text DEFAULT NULL COMMENT 'Wine taste',
  `Tpairing` text DEFAULT NULL COMMENT 'Food Pairing',
  `Pic1` varchar(50) DEFAULT NULL COMMENT 'Main picture',
  `Pic2` varchar(50) DEFAULT NULL COMMENT '2nd picture',
  `Pic3` varchar(50) DEFAULT NULL COMMENT '3rd picture',
  `submit_url` varchar(255) DEFAULT NULL,
  `ingr` varchar(200) DEFAULT NULL COMMENT 'List ingredients',
  `ingrpreanti` varchar(200) DEFAULT NULL COMMENT 'List Ingredients Preservatives /antioxidants',
  `nutrition` int(11) DEFAULT 0 COMMENT 'id nutrition to get form table',
  `ID_producer` int(11) DEFAULT 0 COMMENT 'ID Producer to get from label',
  `printing_id` int(11) DEFAULT 0,
  `oenology_id` int(11) DEFAULT 0,
  `id_cert` int(11) DEFAULT 0 COMMENT 'Id certifications from tabel tblcertificate',
  `Id_recy` int(11) DEFAULT 0 COMMENT 'Id Recycling from tabel tblrecycling',
  `date_created` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 0 COMMENT 'Publish 1 , delete 2',
  `date_published` datetime DEFAULT NULL,
  `is_delete` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_module_id` (`module_id`),
  KEY `idx_status` (`status`),
  KEY `idx_producer` (`ID_producer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Wine certifications table
CREATE TABLE IF NOT EXISTS `tbllabels_cert` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(255) NOT NULL,
  `label_id` varchar(11) NOT NULL,
  `cert_i_1` int(11) DEFAULT NULL,
  `cert_i_2` int(11) DEFAULT NULL,
  `cert_i_3` int(11) DEFAULT NULL,
  `cert_eu_1` int(11) DEFAULT NULL,
  `cert_eu_2` int(11) DEFAULT NULL,
  `cert_eu_3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module_label` (`module_id`, `label_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Client/Producer information table
CREATE TABLE IF NOT EXISTS `tbllabels_client` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(255) NOT NULL,
  `ID-producer` int(11) NOT NULL COMMENT 'ID Producer to get from label usually same as ID',
  `name` varchar(50) NOT NULL COMMENT 'Producer Name',
  `description` text NOT NULL COMMENT 'Short description',
  `e-mail` varchar(60) NOT NULL COMMENT 'email for labels',
  `telephone` varchar(60) NOT NULL COMMENT 'telephone',
  `url-label` varchar(60) NOT NULL COMMENT 'The name on the URL http://digi-card.co/"url-label"-0001',
  `address` varchar(60) NOT NULL COMMENT 'add address',
  `city` varchar(60) NOT NULL COMMENT 'add City',
  `zip` varchar(60) NOT NULL COMMENT 'add Zip',
  `state` varchar(60) NOT NULL COMMENT 'add State',
  `membership` int(11) NOT NULL COMMENT 'Membership ID',
  `Pic1` varchar(50) NOT NULL COMMENT 'Logo',
  `Pic2` varchar(50) NOT NULL COMMENT '2nd picture',
  `Pic3` varchar(50) NOT NULL COMMENT '3rd picture',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `site` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT 0 COMMENT '1=Producer, 2=Printing Service, 3=Oenology',
  `date_published` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id` (`module_id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Nutrition information table
CREATE TABLE IF NOT EXISTS `tbllabels_nutrition` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(255) NOT NULL,
  `id_label` varchar(11) DEFAULT NULL,
  `kcal` varchar(45) DEFAULT NULL,
  `kj` varchar(45) DEFAULT NULL,
  `grassi` varchar(45) DEFAULT NULL,
  `grassi_saturi` varchar(45) DEFAULT NULL,
  `carboidrati` varchar(45) DEFAULT NULL,
  `zuccheri` varchar(45) DEFAULT NULL,
  `proteine` varchar(45) DEFAULT NULL,
  `sale` varchar(45) DEFAULT NULL,
  `Ingredient` varchar(100) DEFAULT NULL,
  `preservatives` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module_label` (`module_id`, `id_label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Recycling components definitions
CREATE TABLE IF NOT EXISTS `tbllabels_recycling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Recycling relationships table
CREATE TABLE IF NOT EXISTS `tbllabels_recycling_relation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(255) NOT NULL,
  `label_id` varchar(11) NOT NULL,
  `bottle_id` int(11) DEFAULT NULL,
  `cork_id` int(11) DEFAULT NULL,
  `capsule_id` int(11) DEFAULT NULL,
  `cork_cage_id` int(11) DEFAULT NULL,
  `packaging_id` int(11) DEFAULT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `printing_id` int(11) DEFAULT NULL,
  `oenology_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module_label` (`module_id`, `label_id`),
  KEY `fk_bottle` (`bottle_id`),
  KEY `fk_cork` (`cork_id`),
  KEY `fk_capsule` (`capsule_id`),
  CONSTRAINT `fk_bottle` FOREIGN KEY (`bottle_id`) REFERENCES `tbllabels_recycling` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cork` FOREIGN KEY (`cork_id`) REFERENCES `tbllabels_recycling` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_capsule` FOREIGN KEY (`capsule_id`) REFERENCES `tbllabels_recycling` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Insert default bottle sizes
INSERT INTO `tbldropdown_list` (`type`, `name`) VALUES
('bottle', 'Split | 187.5ml | 0.25 Bottles'),
('bottle', 'Demi | 375ml | 0.5 Bottles'),
('bottle', 'Standard | 750ml | 1 Bottles'),
('bottle', 'Magnum | 1500ml | 2 Bottles'),
('bottle', 'Double | 2000ml | 2.6 Bottles'),
('bottle', 'Jeroboam | 3000ml | 4 Bottles'),
('bottle', 'Rehoboam | 4500ml | 6 Bottles'),
('bottle', 'Imperial | 6000ml | 8 Bottles'),
('bottle', 'Salmanazar | 9000ml | 12 Bottles'),
('bottle', 'Balthazar | 12000ml | 16 Bottles'),
('bottle', 'Nebuchadnezzar | 15000ml | 20 Bottles'),
('bottle', 'BagInBox | 20l | 26.6 Bottles'),
('bottle', 'BagInBox | 10l | 13.3 Bottles'),
('bottle', 'Fusto Inox | 30l | 40 Bottles');

-- Insert default recycling components
INSERT INTO `tbllabels_recycling` (`type`, `name`, `description`, `symbol`, `code`, `status`) VALUES
('bottle', 'Vetro incolore', 'Vetro', 'GL', 'GL70', 1),
('bottle', 'Vetro Verde Blu', 'Vetro', 'GL', 'GL71', 1),
('bottle', 'Vetro Marrone', 'Vetro', 'GL', 'GL72', 1),
('cork', 'Sughero', 'RACCOLTA DIFFEREN', 'FOR', 'FOR51', 1),
('cork', 'Vetro Verde Blu', 'RACCOLTA ALLUMINIO', 'ALU', 'C/ALU 90', 1),
('cork', 'TAPPI SINTETICI', 'RACCOLTA PLASTICA', 'LDPE', 'LDPE 4', 1),
('capsule', 'CAPSULE TERMORETRAIBILI IN PVC', 'Raccolta Plasitica', 'PVC', 'C/PVC 90', 1),
('capsule', 'CAPSULE TERMORETRAIBILI IN PET', 'Raccolta Plasitica', 'PETG', 'C/PETG 90', 1),
('capsule', 'CAPSULE POLILAMINATO - ALLUMINIO', 'RACCOLTA ALLUMINIO', 'ALU', 'C/ALU 90', 1),
('cork_cage', 'GABBIETTE PER TAPPO SPUMANTE', 'RACCOLTA ACCIAIO', 'FE', 'FE 40', 1),
('packaging', 'CARTONI PER MULTIPLI DI BOTTIGLIE', 'RACCOLTA CARTA', 'PAP', 'PAP 20', 1),
('packaging', 'DIVISORI INTERNI AI CARTONI', 'RACCOLTA CARTA', 'PAP', 'PAP 21', 1);
