-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: rental
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default-admin.png',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'kelompok 6 kece','kelompok6@gmail.com','$2y$10$Cy2lOPqViloiteAbrC2Z2ufasAhq8tJav52txeGym7WV7il9j9qsi','1781624652_1781419349_kategori-drone.jpeg','2026-06-22 13:16:59','2026-06-08 04:37:22');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'Carrier','cat_6a2975db89a75.jpeg','2026-06-07 13:14:45'),(3,'Sleeping','cat_6a2975fc7f9b1.jpeg','2026-06-07 13:14:45'),(4,'DSLR','cat_6a29790820f5e.jpeg','2026-06-07 13:14:45'),(5,'Mirrorless','cat_6a29791bd6f05.png','2026-06-07 13:14:45'),(6,'Drone','cat_6a2975e589e3f.jpeg','2026-06-07 13:14:45'),(7,'Lensa','cat_6a2979104aac8.jpeg','2026-06-07 13:14:45'),(8,'Lighting','cat_6a2975ef99513.jpeg','2026-06-07 13:14:45'),(10,'Tripod','cat_6a29760b3b3b7.png','2026-06-09 08:11:36'),(11,'Tenda','cat_6a29761edf7b8.jpeg','2026-06-10 14:35:10'),(12,'kursi','cat_6a2e3be53f412.png','2026-06-14 05:28:05');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_like` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (3,5,3,'2026-06-16 13:25:27'),(4,5,2,'2026-06-16 13:25:32'),(5,5,1,'2026-06-16 13:25:33'),(6,3,3,'2026-06-23 06:20:09'),(9,3,2,'2026-06-23 06:33:09'),(10,3,1,'2026-06-23 06:33:13');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rental_id` int NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `rental_id` (`rental_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'cash',NULL,'diterima','2026-06-15 04:12:11'),(2,2,'bank',NULL,'ditolak','2026-06-15 04:23:56'),(3,3,'cash',NULL,'diterima','2026-06-16 11:45:34'),(4,4,'bank',NULL,'diterima','2026-06-16 11:46:32'),(5,5,'cash',NULL,'ditolak','2026-06-16 11:52:14'),(6,6,'cash',NULL,'diterima','2026-06-16 12:11:52'),(7,7,'bank','1781615444_1781528345_1781419506_1781419349_kategori-drone.jpeg','diterima','2026-06-16 13:10:44'),(8,8,'cash',NULL,'diterima','2026-06-16 13:23:02'),(9,9,'cash',NULL,'diterima','2026-06-16 13:58:10'),(10,10,'cash',NULL,'diterima','2026-06-22 08:19:06'),(11,11,'cash',NULL,'menunggu','2026-06-22 08:53:26'),(12,12,'cash',NULL,'menunggu','2026-06-22 08:54:32'),(13,13,'cash',NULL,'menunggu','2026-06-22 13:36:31'),(14,14,'cash',NULL,'menunggu','2026-06-23 02:27:10'),(15,15,'cash',NULL,'menunggu','2026-06-23 02:27:43'),(16,16,'cash',NULL,'menunggu','2026-06-23 02:28:41'),(17,17,'cash',NULL,'menunggu','2026-06-23 02:30:28'),(18,18,'cash',NULL,'menunggu','2026-06-23 02:32:06'),(19,19,'cash',NULL,'menunggu','2026-06-23 05:45:35'),(20,20,'cash',NULL,'menunggu','2026-06-23 05:46:24'),(21,21,'cash',NULL,'menunggu','2026-06-23 05:47:52');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `gambar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,2,'1780839994_6a25763ae76be.jpg'),(2,1,'1781092324_6a294fe43d5e3.jpg'),(3,3,'1781104743_6a298067cbddb.jpeg'),(4,3,'1781104743_6a298067ce509.jpeg');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text,
  `spesifikasi` text,
  `include_item` text,
  `harga_sewa` decimal(12,2) NOT NULL,
  `stok` int DEFAULT '0',
  `kondisi` enum('baik','rusak_ringan','rusak_berat') DEFAULT 'baik',
  `status` enum('tersedia','maintenance') DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deposit` decimal(12,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_deposit` CHECK ((`deposit` >= 0)),
  CONSTRAINT `chk_harga_sewa` CHECK ((`harga_sewa` >= 0)),
  CONSTRAINT `chk_stok_non_negatif` CHECK ((`stok` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,'tas','alus pokokna','geede\r\ntahan lama','apa aja',100000.00,50,'baik','tersedia','2026-06-07 13:30:38',200000.00),(2,4,'kamera','apa lah','1 aja','dasdasd, sadasd',150000.00,50,'baik','tersedia','2026-06-07 13:46:34',100000.00),(3,11,'Tenda','bagus banget, saya sampaikan hari ini saya akan lawan','gacor\r\nbagus\r\nmantap\r\nkeren\r\napalagi','apa, aja, yang, kalian, mau',200000.00,50,'rusak_ringan','tersedia','2026-06-10 15:19:03',150000.00);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rental_details`
--

DROP TABLE IF EXISTS `rental_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rental_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rental_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rental_id` (`rental_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `rental_details_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rental_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rental_details`
--

LOCK TABLES `rental_details` WRITE;
/*!40000 ALTER TABLE `rental_details` DISABLE KEYS */;
INSERT INTO `rental_details` VALUES (1,1,3,2,200000.00),(2,2,3,1,200000.00),(3,3,3,1,200000.00),(4,4,3,1,200000.00),(5,5,3,1,200000.00),(6,6,3,1,200000.00),(7,7,1,1,100000.00),(8,8,3,1,200000.00),(9,9,2,1,150000.00),(10,10,3,1,200000.00),(11,11,1,1,100000.00),(12,12,3,1,200000.00),(13,13,3,1,200000.00),(14,14,3,1,200000.00),(15,15,3,1,200000.00),(16,16,3,1,200000.00),(17,17,3,1,200000.00),(18,18,3,1,200000.00),(19,19,3,1,200000.00),(20,20,3,1,200000.00),(21,21,3,1,200000.00);
/*!40000 ALTER TABLE `rental_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rentals`
--

DROP TABLE IF EXISTS `rentals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rentals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','disewa','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rentals`
--

LOCK TABLES `rentals` WRITE;
/*!40000 ALTER TABLE `rentals` DISABLE KEYS */;
INSERT INTO `rentals` VALUES (1,2,'2026-06-14','2026-06-16',950000.00,'selesai','2026-06-15 04:12:11',NULL,NULL),(2,2,'2026-06-14','2026-06-15',200000.00,'dibatalkan','2026-06-15 04:23:56',NULL,NULL),(3,3,'2026-06-16','2026-06-17',200000.00,'selesai','2026-06-16 11:45:34',NULL,NULL),(4,3,'2026-06-17','2026-06-17',200000.00,'selesai','2026-06-16 11:46:32',NULL,NULL),(5,3,'2026-06-16','2026-06-16',200000.00,'dibatalkan','2026-06-16 11:52:14',NULL,NULL),(6,3,'2026-06-17','2026-06-18',200000.00,'selesai','2026-06-16 12:11:52',NULL,NULL),(7,3,'2026-06-16','2026-06-17',100000.00,'selesai','2026-06-16 13:10:44',NULL,NULL),(8,5,'2026-06-16','2026-06-17',200000.00,'selesai','2026-06-16 13:23:02',NULL,NULL),(9,5,'2026-06-16','2026-06-17',150000.00,'disewa','2026-06-16 13:58:10',NULL,NULL),(10,NULL,'2026-06-22','2026-06-23',200000.00,'disewa','2026-06-22 08:19:06','bapaku','08123456789'),(11,NULL,'2026-06-22','2026-06-23',100000.00,'pending','2026-06-22 08:53:26','bapakmu','0987654321'),(12,3,'2026-06-22','2026-06-23',200000.00,'pending','2026-06-22 08:54:32',NULL,NULL),(13,NULL,'2026-06-22','2026-06-23',200000.00,'pending','2026-06-22 13:36:31','putri','0239840956'),(14,3,'2026-06-24','2026-06-25',200000.00,'pending','2026-06-23 02:27:10',NULL,NULL),(15,3,'2026-06-24','2026-06-25',200000.00,'pending','2026-06-23 02:27:43',NULL,NULL),(16,3,'2026-06-24','2026-06-25',200000.00,'pending','2026-06-23 02:28:41',NULL,NULL),(17,3,'2026-06-23','2026-06-24',200000.00,'pending','2026-06-23 02:30:28',NULL,NULL),(18,3,'2026-06-24','2026-06-25',200000.00,'pending','2026-06-23 02:32:06',NULL,NULL),(19,3,'2026-06-23','2026-06-24',200000.00,'pending','2026-06-23 05:45:35',NULL,NULL),(20,NULL,'2026-06-23','2026-06-24',200000.00,'pending','2026-06-23 05:46:24','kencol','0987654321'),(21,NULL,'2026-06-23','2026-06-24',200000.00,'pending','2026-06-23 05:47:52','kencol','0987654321');
/*!40000 ALTER TABLE `rentals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returns`
--

DROP TABLE IF EXISTS `returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `returns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rental_id` int NOT NULL,
  `kondisi_barang` varchar(50) DEFAULT NULL,
  `hari_terlambat` int DEFAULT '0',
  `denda` decimal(12,2) DEFAULT '0.00',
  `tanggal_pengembalian` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rental_id` (`rental_id`),
  CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` VALUES (1,1,'hilang',0,1000000.00,'2026-06-15 11:17:24'),(2,3,'hilang',0,1000000.00,'2026-06-16 18:45:59'),(3,4,'rusak_berat',0,300000.00,'2026-06-16 18:47:13'),(4,4,'rusak_berat',0,300000.00,'2026-06-16 20:14:40'),(5,7,'baik',0,0.00,'2026-06-16 20:15:07'),(6,6,'baik',0,0.00,'2026-06-16 20:43:10'),(7,8,'baik',0,0.00,'2026-06-16 20:43:38');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `alamat` text,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default-user.png',
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'eqy','eqy@gmail.com','23425345242','asddfgfdfgergdf','$2y$10$HXEFB1hQAFAI8yFDcWAWRueZMbWD7PVst7uuBDmiDsKaeWr7m6tuq','1780813880_6a2510388c3d8.jpg','user','aktif','2026-06-03 11:19:45','2026-06-14 07:48:06'),(2,'syaputra','syaputra@gmail.com','089857834234','cimanuk','$2y$10$Uk96qx0UHWc4TPIJ37aYKeD5r4/4PuZjWe7nnk/EqHRvzy2rrC7Ne','1781499784_6a2f8788773f0.png','user','aktif','2026-06-14 12:43:57','2026-06-15 05:03:04'),(3,'putri','putri@gmail.com','0239840956','wanaraja','$2y$10$8AzhvqilMhMrSxWt/WVTCOQEpDAb5v.LAnfS18m7FwoRW9Izw66lK','1781499751_6a2f87673744c.png','user','aktif','2026-06-15 04:30:02','2026-06-15 05:02:31'),(5,'elqy','elqy@gmail.com','08679584723','pajajaran','$2y$10$1GM./j6JC8GG2WzHXpO8ueOyTC8O7OrZ63k1U66MJn90ZrC9En4X.','default-user.png','user','aktif','2026-06-16 13:18:08','2026-06-16 13:18:08');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-23 13:51:29
