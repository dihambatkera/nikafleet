/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `cache` VALUES ('nikafleet-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:2;',1787630771),('nikafleet-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1787630771;',1787630771);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_availability_blocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `blocked_from` date NOT NULL,
  `blocked_until` date NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_availability_blocks_car_id_foreign` (`car_id`),
  CONSTRAINT `car_availability_blocks_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_images_car_id_foreign` (`car_id`),
  CONSTRAINT `car_images_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `car_images` VALUES (1,1,'placeholder_perodua.png',1,1,'2026-06-28 15:20:11','2026-06-28 15:20:11'),(4,4,'placeholder_toyota.png',1,1,'2026-06-28 15:20:11','2026-06-28 15:20:11'),(6,2,'cars/2/6a8d12db873b0.webp',1,1,'2026-08-24 19:58:28','2026-08-24 19:58:45'),(7,3,'cars/3/6a8d133c85a7c.webp',1,1,'2026-08-24 19:59:57','2026-08-24 19:59:57'),(8,5,'cars/5/6a8d14b5c1105.webp',1,1,'2026-08-24 20:06:15','2026-08-24 20:06:15');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` smallint unsigned NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('sedan','suv','mpv','pickup','van','hatchback') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transmission` enum('auto','manual') COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` tinyint unsigned NOT NULL,
  `fuel_type` enum('petrol','diesel','hybrid','electric') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `price_per_week` decimal(10,2) DEFAULT NULL,
  `deposit_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `late_return_penalty` decimal(10,2) DEFAULT NULL,
  `mileage` int unsigned NOT NULL DEFAULT '0',
  `last_service_date` date DEFAULT NULL,
  `next_service_due` date DEFAULT NULL,
  `insurance_expiry` date DEFAULT NULL,
  `road_tax_expiry` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rawang, Selangor',
  `status` enum('available','rented','maintenance','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `availability_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cars_plate_number_unique` (`plate_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `cars` VALUES (1,'Perodua Myvi 1.5 AV','VGD 8834','Perodua','Myvi',2023,'Granite Grey','hatchback','auto',5,'petrol',130.00,800.00,150.00,NULL,12500,NULL,NULL,NULL,NULL,'Rawang, Selangor','available',1,'Sleek, compact and reliable. The legendary Malaysian hatchback with Advanced Safety Assist (ASA) 3.0. Perfect for city driving and fuel efficiency.','Available daily','2026-06-28 15:20:11','2026-08-24 19:40:11','2026-08-24 19:40:11'),(2,'Proton Saga 1.3 Premium','WUX 5521','Proton','Saga',2022,'Snow White','sedan','auto',5,'petrol',110.00,700.00,100.00,NULL,24000,NULL,NULL,NULL,NULL,'Rawang, Selangor','available',1,'Malaysia\'s favorite budget sedan. Comfortable ride, modern infotainment with Bluetooth connectivity, and stable handling.','Available daily','2026-06-28 15:20:11','2026-06-28 15:20:11',NULL),(3,'Honda Civic 1.5 VTEC Turbo','BRT 7789','Honda','Civic',2023,'Platinum White Pearl','sedan','auto',5,'petrol',320.00,2000.00,300.00,NULL,8900,NULL,NULL,NULL,NULL,'Rawang, Selangor','available',1,'Premium sporty sedan with high-performance VTEC Turbo engine, premium leather seats, Honda SENSING suite, and high-end aesthetics.','Available daily','2026-06-28 15:20:11','2026-06-28 15:20:11',NULL),(4,'Toyota Vellfire 2.5 Golden Eye','VJL 9900','Toyota','Vellfire',2021,'Burning Black','mpv','auto',7,'petrol',550.00,3500.00,500.00,NULL,45000,NULL,NULL,NULL,NULL,'Rawang, Selangor','available',1,'Luxury MPV designed for VIP comfort. Double sunroof, pilot seats, ambient lighting, power sliding doors, and spacious interior.','Weekend bookings require 2 days minimum','2026-06-28 15:20:11','2026-06-28 15:20:11',NULL),(5,'Proton X70 1.5 TGDI Premium','WVD 4321','Proton','X70',2022,'Space Grey','suv','auto',5,'petrol',250.00,1500.00,250.00,NULL,19800,NULL,NULL,NULL,NULL,'Rawang, Selangor','available',0,'Premium SUV with panoramic sunroof, Nappa leather seats, voice command infotainment, and outstanding riding comfort.','Available daily','2026-06-28 15:20:11','2026-06-28 15:20:11',NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('maintenance','fuel','insurance','cleaning','repair','tax','marketing','salary','utilities','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_date` date NOT NULL,
  `receipt_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_car_id_foreign` (`car_id`),
  CONSTRAINT `expenses_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `locations` VALUES (1,'Rawang, Selangor','Rawang, Selangor, Malaysia','active',1,'2026-08-24 18:49:58','2026-08-24 18:49:58'),(2,'Kangar','Kangar, Perlis, Malaysia','inactive',2,'2026-08-24 18:49:58','2026-08-24 20:07:09'),(3,'Padang Besar','Padang Besar, Perlis, Malaysia','inactive',3,'2026-08-24 18:49:58','2026-08-24 20:07:09'),(4,'Kuala Perlis','Kuala Perlis, Perlis, Malaysia','inactive',4,'2026-08-24 18:49:58','2026-08-24 20:07:14'),(5,'UITM Tapah',NULL,'active',0,'2026-08-24 20:07:27','2026-08-24 20:07:27');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_01_000001_create_cars_table',1),(5,'2025_11_01_000002_create_car_images_table',1),(6,'2025_11_01_000003_create_rentals_table',1),(7,'2025_11_01_000004_create_expenses_table',1),(8,'2025_11_01_000005_create_revenues_table',1),(9,'2025_11_01_000006_create_car_availability_blocks_table',1),(10,'2025_11_01_000007_create_settings_table',1),(11,'2026_06_27_223040_create_permission_tables',1),(12,'2026_06_28_000001_create_contact_messages_table',1),(13,'2026_06_28_000002_add_customer_fields_to_rentals_table',1),(14,'2026_06_28_222846_add_extra_fields_to_cars_table',1),(15,'2026_06_28_224311_add_car_id_to_revenues_table',1),(16,'2026_08_25_000001_add_superadmin_to_users_role_enum',2),(17,'2026_08_25_000002_create_locations_table',2),(18,'2026_08_25_000003_create_time_slots_table',2);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `permissions` VALUES (1,'view cars','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(2,'create cars','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(3,'edit cars','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(4,'delete cars','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(5,'view rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(6,'create rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(7,'edit rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(8,'delete rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(9,'confirm rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(10,'cancel rentals','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(11,'view expenses','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(12,'create expenses','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(13,'edit expenses','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(14,'delete expenses','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(15,'view revenues','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(16,'create revenues','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(17,'view users','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(18,'create users','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(19,'edit users','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(20,'delete users','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(21,'view settings','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(22,'edit settings','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(23,'view reports','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(24,'export reports','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(25,'manage locations','web','2026-08-24 18:49:07','2026-08-24 18:49:07'),(26,'manage time_slots','web','2026-08-24 18:49:07','2026-08-24 18:49:07'),(27,'manage whatsapp_template','web','2026-08-24 18:49:07','2026-08-24 18:49:07'),(28,'manage users','web','2026-08-24 18:49:07','2026-08-24 18:49:07');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rentals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `car_id` bigint unsigned NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int unsigned NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `deposit_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance_due` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','confirmed','active','completed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dropoff_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `customer_notes` text COLLATE utf8mb4_unicode_ci,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rentals_booking_code_unique` (`booking_code`),
  KEY `rentals_user_id_foreign` (`user_id`),
  KEY `rentals_car_id_foreign` (`car_id`),
  CONSTRAINT `rentals_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `rentals` VALUES (1,NULL,1,'Ahmad Albab','012-3456789','NF-VIDFQEET','2026-06-30','2026-07-03',3,130.00,390.00,100.00,290.00,'pending',NULL,NULL,'Rawang, Selangor','Rawang, Selangor',NULL,'Tolong basuh kereta bersih-bersih ya.',NULL,NULL,NULL,NULL,'2026-06-28 15:20:12','2026-06-28 15:20:12',NULL),(2,NULL,1,'Siti Aminah','019-8765432','NF-VCRXAGO6','2026-07-01','2026-07-04',3,130.00,390.00,150.00,240.00,'confirmed',NULL,NULL,'Rawang, Selangor','Rawang, Selangor',NULL,NULL,'2026-06-28 15:20:12',NULL,NULL,NULL,'2026-06-28 15:20:12','2026-06-28 15:20:12',NULL),(3,NULL,3,'Mujahid Bin Ahmad','011-6824 7599','NF-ELDFAZVA','2026-06-26','2026-06-30',4,320.00,1280.00,200.00,1080.00,'active',NULL,NULL,'Rawang, Selangor','Rawang, Selangor',NULL,NULL,'2026-06-25 15:20:12','2026-06-26 15:20:12',NULL,NULL,'2026-06-28 15:20:12','2026-06-28 15:20:12',NULL),(4,NULL,4,'Cristiano Ronaldo','017-6543210','NF-PWHOUPRR','2026-06-18','2026-06-22',4,550.00,2200.00,500.00,1700.00,'completed',NULL,NULL,'Rawang, Selangor','Rawang, Selangor',NULL,NULL,'2026-06-16 15:20:12','2026-06-18 15:20:12','2026-06-22 15:20:12',NULL,'2026-06-28 15:20:12','2026-06-28 15:20:12',NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rental_id` bigint unsigned DEFAULT NULL,
  `car_id` bigint unsigned DEFAULT NULL,
  `type` enum('rental','deposit','penalty','refund','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revenue_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revenues_rental_id_foreign` (`rental_id`),
  KEY `revenues_car_id_foreign` (`car_id`),
  CONSTRAINT `revenues_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE SET NULL,
  CONSTRAINT `revenues_rental_id_foreign` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(1,2),(5,2),(6,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3),(27,3),(28,3);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `roles` VALUES (1,'admin','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(2,'user','web','2026-06-28 15:20:08','2026-06-28 15:20:08'),(3,'superadmin','web','2026-08-24 18:49:07','2026-08-24 18:49:07');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `sessions` VALUES ('evylri3ewnHVuHLT0PuP1ojaKFVYL2NAt1rNJzBm',NULL,'127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoidVMxNk40eGRDYTN2VHZKSGI1c1ZKYXpwMXFPUlFBdlI2RDZnbW1YQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9uaWthZmxlZXQudGVzdCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1787647089),('ZDxA79CtFfYIzLgk7FCcBcK7TKNP1YKdq7JjwT0z',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidmNtMGxvdE15Mms1ZVZ1UWhYaUthTmlHeDZ1bzVHY0NHZXA5bk92eCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9uaWthZmxlZXQudGVzdCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1787655433);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `settings` VALUES (1,'company_name','NikaFleet','2026-06-28 15:20:11','2026-06-28 15:20:11'),(2,'tagline','Nak sewa? Nika kan ada!','2026-06-28 15:20:11','2026-06-28 15:20:11'),(3,'phone','+60 11-6824 7599','2026-06-28 15:20:11','2026-06-28 15:20:11'),(4,'whatsapp','+60116824 7599','2026-06-28 15:20:11','2026-06-28 15:20:11'),(5,'email','admin@nikafleet.com','2026-06-28 15:20:11','2026-06-28 15:20:11'),(6,'location','Rawang, Selangor','2026-06-28 15:20:11','2026-06-28 15:20:11'),(7,'address','Rawang, Selangor, Malaysia','2026-06-28 15:20:11','2026-06-28 15:20:11'),(8,'tiktok','https://www.tiktok.com/@nika.fleet','2026-06-28 15:20:11','2026-06-28 15:20:11'),(9,'currency','RM','2026-06-28 15:20:11','2026-06-28 15:20:11'),(10,'currency_code','MYR','2026-06-28 15:20:11','2026-06-28 15:20:11'),(11,'established','November 2025','2026-06-28 15:20:11','2026-06-28 15:20:11'),(12,'logo',NULL,'2026-06-28 15:20:11','2026-06-28 15:20:11'),(13,'meta_title','NikaFleet - Car Rental Rawang Selangor','2026-06-28 15:20:11','2026-06-28 15:20:11'),(14,'meta_description','NikaFleet menyediakan perkhidmatan sewa kereta di Rawang, Selangor. Nak sewa? Nika kan ada!','2026-06-28 15:20:11','2026-06-28 15:20:11');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_slots` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `time_slots` VALUES (1,'08:00 AM','08:00',1,1,'2026-08-24 18:50:15','2026-08-24 18:50:15'),(2,'10:00 AM','10:00',1,2,'2026-08-24 18:50:16','2026-08-24 18:50:16'),(3,'12:00 PM','12:00',1,3,'2026-08-24 18:50:16','2026-08-24 18:50:16'),(4,'02:00 PM','14:00',1,4,'2026-08-24 18:50:16','2026-08-24 18:50:16'),(5,'04:00 PM','16:00',1,5,'2026-08-24 18:50:16','2026-08-24 18:50:16'),(6,'06:00 PM','18:00',1,6,'2026-08-24 18:50:16','2026-08-24 18:50:16');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `users` VALUES (1,'NikaFleet Admin','admin@nikafleet.com','+60 11-6824 7599','2026-06-28 15:20:11','$2y$12$EKsB/dWTK1VtZBGAgKtsQ.ttZGjNfO0AZ5GekYWHBeVhoM8I/ATfa','superadmin',1,NULL,'yBFgTy9145OPCNM5VNTHZC7HAMmpuEwgQL7ZAyoP0LC7z48t7BrjhItIh5to','2026-06-28 15:20:11','2026-08-24 18:51:26',NULL);
