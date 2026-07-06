-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_projectakhir
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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_index` (`user_id`),
  KEY `activity_logs_action_type_index` (`action_type`),
  KEY `activity_logs_module_index` (`module`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'login','auth',NULL,NULL,'User login: Super Administrator (superadmin@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.8457','2026-06-02 04:26:43','2026-06-02 04:26:43'),(2,1,'login','auth',NULL,NULL,'User login: Super Administrator (superadmin@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.8457','2026-06-02 04:26:55','2026-06-02 04:26:55'),(3,1,'login','auth',NULL,NULL,'User login: Super Administrator (superadmin@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.8457','2026-06-05 09:34:20','2026-06-05 09:34:20'),(4,NULL,'login','pelanggan','App\\Models\\Customer',7,'Pelanggan Dell login','[]','127.0.0.1','curl/7.84.0','2026-06-09 01:53:34','2026-06-09 01:53:34'),(5,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0','2026-06-10 04:43:33','2026-06-10 04:43:33'),(6,NULL,'create','pesanan','App\\Models\\Order',22,'Pelanggan herman membuat booking layanan #22 (Rp 35.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0','2026-06-10 04:44:12','2026-06-10 04:44:12'),(7,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 06:10:52','2026-06-25 06:10:52'),(8,NULL,'create','pesanan','App\\Models\\Order',23,'Pelanggan herman membuat booking layanan #23 (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 06:11:20','2026-06-25 06:11:20'),(9,NULL,'update','pembayaran','App\\Models\\Order',23,'Pelanggan herman membayar pesanan #23 via DANA (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 06:11:31','2026-06-25 06:11:31'),(10,1,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 06:14:52','2026-06-25 06:14:52'),(11,1,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 07:03:09','2026-06-25 07:03:09'),(12,1,'create','pesanan','App\\Models\\Order',24,'Pelanggan herman membuat pembelian produk #24 (Rp 55.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 07:04:45','2026-06-25 07:04:45'),(13,1,'update','pembayaran','App\\Models\\Order',24,'Pelanggan herman membayar pesanan #24 via DANA (Rp 55.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 07:05:22','2026-06-25 07:05:22'),(14,1,'create','pesanan','App\\Models\\Order',25,'Pelanggan herman membuat booking layanan #25 (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 07:06:35','2026-06-25 07:06:35'),(15,1,'update','pembayaran','App\\Models\\Order',25,'Pelanggan herman membayar pesanan #25 via DANA (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-25 07:06:42','2026-06-25 07:06:42'),(16,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-26 11:03:55','2026-06-26 11:03:55'),(17,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-26 13:43:56','2026-06-26 13:43:56'),(18,NULL,'create','pesanan','App\\Models\\Order',26,'Pelanggan herman membuat pembelian produk #26 (Rp 76.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-26 13:44:50','2026-06-26 13:44:50'),(19,NULL,'update','pembayaran','App\\Models\\Order',26,'Pelanggan herman membayar pesanan #26 via DANA (Rp 76.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-26 13:45:05','2026-06-26 13:45:05'),(20,7,'login','absensi','App\\Models\\PegawaiAttendanceLog',1,'Pegawai Rizky Maulana check-in pukul 13:14','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:14:25','2026-06-27 06:14:25'),(21,7,'logout','auth',NULL,NULL,'User logout: Rizky Maulana (barber1@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:17:31','2026-06-27 06:17:31'),(22,1,'logout','auth',NULL,NULL,'User logout: Super Administrator (superadmin@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:18:16','2026-06-27 06:18:16'),(23,7,'logout','absensi','App\\Models\\PegawaiAttendanceLog',1,'Pegawai Rizky Maulana check-out pukul 13:18','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:18:26','2026-06-27 06:18:26'),(24,7,'logout','auth',NULL,NULL,'User logout: Rizky Maulana (barber1@gmail.com)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:24:21','2026-06-27 06:24:21'),(25,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-27 06:24:51','2026-06-27 06:24:51'),(28,NULL,'login','pelanggan','App\\Models\\Customer',8,'Pelanggan herman login','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-29 03:31:58','2026-06-29 03:31:58'),(29,NULL,'create','pesanan','App\\Models\\Order',27,'Pelanggan herman membuat booking layanan #27 (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-29 03:32:48','2026-06-29 03:32:48'),(30,NULL,'update','pembayaran','App\\Models\\Order',27,'Pelanggan herman membayar pesanan #27 via DANA (Rp 25.000)','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','2026-06-29 03:41:31','2026-06-29 03:41:31'),(31,NULL,'create','booking','App\\Models\\Order',32,'Mobile Booking Created','{\"customer_id\": 11}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:13:01','2026-07-05 03:13:01'),(32,NULL,'create','booking','App\\Models\\Order',33,'Mobile Booking Created','{\"customer_id\": 11}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:13:17','2026-07-05 03:13:17'),(33,NULL,'create','booking','App\\Models\\Order',34,'Mobile Booking Created','{\"customer_id\": 12}','127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.8457','2026-07-05 03:16:53','2026-07-05 03:16:53'),(34,NULL,'create','booking','App\\Models\\Order',35,'Mobile Booking Created','{\"customer_id\": 11}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:18:09','2026-07-05 03:18:09'),(35,NULL,'update','booking','App\\Models\\Order',35,'Mobile Payment Processed via ewallet','{\"no_ref\": \"BF-260705101821-JF34\", \"customer_id\": 11, \"metode_bayar\": \"ewallet\"}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:18:21','2026-07-05 03:18:21'),(36,NULL,'create','booking','App\\Models\\Order',36,'Mobile Product Order Created','{\"customer_id\": 12}','127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.8457','2026-07-05 03:30:19','2026-07-05 03:30:19'),(37,NULL,'create','booking','App\\Models\\Order',37,'Mobile Product Order Created','{\"customer_id\": 11}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:33:22','2026-07-05 03:33:22'),(38,NULL,'update','booking','App\\Models\\Order',37,'Mobile Payment Processed via ewallet','{\"no_ref\": \"BF-260705103328-NLDB\", \"customer_id\": 11, \"metode_bayar\": \"ewallet\"}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:33:28','2026-07-05 03:33:28'),(39,NULL,'create','booking','App\\Models\\Order',38,'Mobile Booking Created','{\"customer_id\": 13}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:57:33','2026-07-05 03:57:33'),(40,NULL,'update','booking','App\\Models\\Order',38,'Mobile Payment Processed via ewallet','{\"no_ref\": \"BF-260705105750-SYP8\", \"customer_id\": 13, \"metode_bayar\": \"ewallet\"}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:57:50','2026-07-05 03:57:50'),(41,NULL,'create','booking','App\\Models\\Order',39,'Mobile Product Order Created','{\"customer_id\": 13}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:59:01','2026-07-05 03:59:01'),(42,NULL,'update','booking','App\\Models\\Order',39,'Mobile Payment Processed via transfer','{\"no_ref\": \"BF-260705105912-AI10\", \"customer_id\": 13, \"metode_bayar\": \"transfer\"}','127.0.0.1','Dart/3.11 (dart:io)','2026-07-05 03:59:12','2026-07-05 03:59:12');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;

--
-- Table structure for table `asets`
--

DROP TABLE IF EXISTS `asets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pembelian` date NOT NULL,
  `harga_perolehan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nilai_saat_ini` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status_aset` enum('aktif','rusak','hilang','dijual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_aset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_maintenance` date DEFAULT NULL,
  `next_maintenance` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asets_kode_aset_unique` (`kode_aset`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asets`
--

/*!40000 ALTER TABLE `asets` DISABLE KEYS */;
INSERT INTO `asets` VALUES (1,'X-Ray Machine Digital','AST-MED-001','Mesin X-Ray digital untuk pemeriksaan radiologi','Alat Medis','PT. Medika Sejahtera','2022-03-15',250000000.00,200000000.00,'aktif','Ruang Radiologi Lantai 2',NULL,'2025-10-01','2026-04-01','2026-06-02 04:03:12','2026-06-02 04:03:12'),(2,'Ultrasonography (USG)','AST-MED-002','USG 4D untuk pemeriksaan kandungan dan organ dalam','Alat Medis','PT. Alkes Indonesia','2021-08-20',180000000.00,135000000.00,'aktif','Poliklinik Kebidanan Lantai 3',NULL,'2025-09-15','2026-03-15','2026-06-02 04:03:12','2026-06-02 04:03:12'),(3,'Ventilator ICU','AST-MED-003','Ventilator untuk pasien ICU','Alat Medis','PT. Medical Equipment','2023-01-10',350000000.00,300000000.00,'aktif','Ruang ICU Lantai 4',NULL,'2025-11-01','2025-12-01','2026-06-02 04:03:12','2026-06-02 04:03:12'),(4,'Electrocardiogram (ECG)','AST-MED-004','Mesin EKG 12 channel','Alat Medis','PT. Kardia Medika','2022-06-05',45000000.00,35000000.00,'aktif','Poliklinik Jantung Lantai 2',NULL,'2025-10-10','2026-04-10','2026-06-02 04:03:12','2026-06-02 04:03:12'),(5,'Dental Chair Unit','AST-MED-005','Kursi dental lengkap dengan lampu dan alat','Alat Medis','PT. Dental Supplies','2020-11-20',75000000.00,45000000.00,'aktif','Klinik Gigi Lantai 1',NULL,'2025-08-15','2026-02-15','2026-06-02 04:03:12','2026-06-02 04:03:12'),(6,'Server Komputer HP ProLiant','AST-ELK-001','Server untuk sistem informasi rumah sakit','Elektronik','PT. Komputer Persada','2023-05-01',120000000.00,95000000.00,'aktif','Ruang Server IT Lantai Basement',NULL,'2025-11-10','2026-05-10','2026-06-02 04:03:12','2026-06-02 04:03:12'),(7,'AC Central Daikin 5 PK','AST-ELK-002','AC Central untuk ruang operasi','Elektronik','PT. Cool Tech','2021-04-15',65000000.00,40000000.00,'aktif','Ruang Operasi Lantai 3',NULL,'2025-10-20','2026-04-20','2026-06-02 04:03:12','2026-06-02 04:03:12'),(8,'Meja Operasi Elektrik','AST-FUR-001','Meja operasi dengan sistem hidrolik elektrik','Furniture','PT. Medical Furniture','2022-09-01',95000000.00,75000000.00,'aktif','Ruang Operasi Utama Lantai 3',NULL,'2025-10-05','2026-04-05','2026-06-02 04:03:12','2026-06-02 04:03:12'),(9,'Tempat Tidur Pasien Elektrik','AST-FUR-002','Tempat tidur pasien dengan pengatur posisi elektrik (10 unit)','Furniture','PT. Furniture Medis','2023-02-10',150000000.00,120000000.00,'aktif','Ruang Rawat Inap Lantai 5',NULL,'2025-11-05','2026-05-05','2026-06-02 04:03:12','2026-06-02 04:03:12'),(10,'Ambulance Toyota Hiace','AST-VEH-001','Ambulance lengkap dengan peralatan medis darurat','Kendaraan','PT. Auto Medika','2022-07-15',450000000.00,350000000.00,'aktif','Parkir Ambulance Lantai Basement',NULL,'2025-11-15','2025-12-15','2026-06-02 04:03:12','2026-06-02 04:03:12'),(11,'Paracetamol 500mg','OBT-001','Obat demam dan nyeri','Obat-obatan','Industri Farmasi XYZ','2025-01-10',2500000.00,2000000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(12,'Amoxicillin 500mg','OBT-002','Antibiotik untuk infeksi bakteri','Obat-obatan','Industri Farmasi ABC','2025-01-15',3500000.00,2800000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(13,'Insulin Lantus 100 Unit/ml','OBT-003','Insulin untuk pasien diabetes','Obat-obatan','PT. Novo Nordisk','2024-11-20',8500000.00,7500000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(14,'Antiseptik Betadine 10%','OBT-004','Antiseptik untuk sterilisasi luka','Obat-obatan','PT. Kimia Industri','2025-01-05',1500000.00,1200000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(15,'Metformin 500mg','OBT-005','Obat diabetes tipe 2','Obat-obatan','Industri Farmasi XYZ','2025-01-08',2000000.00,1600000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(16,'Omeprazole 20mg','OBT-006','Obat untuk asam lambung','Obat-obatan','Industri Farmasi DEF','2025-01-12',3000000.00,2400000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(17,'Vitamin C 500mg','OBT-007','Vitamin untuk imunitas','Obat-obatan','PT. Vitamin Indonesia','2025-01-10',1800000.00,1400000.00,'aktif','Apotek Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(18,'Bandage Steril 5cm x 5m','ALS-001','Perban steril untuk perawatan luka','Alat Medis','PT. Medika Supply','2025-01-01',500000.00,400000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(19,'Suntik Steril 3ml','ALS-002','Spuit medis steril ukuran 3ml','Alat Medis','PT. Alat Medis Sejahtera','2025-01-03',750000.00,600000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(20,'Infus Set 18G','ALS-003','Set infus ukuran 18G','Alat Medis','PT. Medical Supply','2025-01-05',1200000.00,1000000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(21,'Thermometer Digital','ALS-004','Termometer digital untuk pengukuran suhu','Alat Medis','PT. Digital Medika','2024-08-15',850000.00,680000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(22,'Blood Pressure Monitor','ALS-005','Alat tensi meter digital','Alat Medis','PT. Monitoring Kesehatan','2024-09-20',1500000.00,1200000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(23,'Pulse Oximeter','ALS-006','Alat pengukur oksigen darah dan denyut nadi','Alat Medis','PT. Vital Sign Indonesia','2024-10-10',2500000.00,2000000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(24,'Sarung Tangan Medis Latex','ALS-007','Sarung tangan steril untuk medis (100 pasang)','Alat Medis','PT. Protective Equipment','2025-01-02',600000.00,500000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(25,'Masker Medis N95','ALS-008','Masker medis N95 (50 buah)','Alat Medis','PT. PPE Supply','2025-01-04',1000000.00,800000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(26,'Kateter Urin','ALS-009','Kateter urin steril berbagai ukuran','Alat Medis','PT. Catheter Indonesia','2024-12-20',2800000.00,2200000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(27,'Standar Infus IV Pole','ALS-010','Standar untuk menggantung infus','Alat Medis','PT. Hospital Equipment','2023-06-01',3500000.00,2800000.00,'aktif','Gudang Medis Lantai 2',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(28,'Defibrillator AED','ALS-011','Alat defibrillator otomatis untuk kedaruratan','Alat Medis','PT. Emergency Medical','2023-03-15',45000000.00,36000000.00,'aktif','Ruang Gawat Darurat Lantai 1',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(29,'Oksigen Tabung Besar','ALS-012','Tabung oksigen kapasitas besar untuk pasien','Alat Medis','PT. Gas Medika','2024-05-01',8500000.00,7000000.00,'aktif','Ruang ICU Lantai 4',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(30,'Suction Pump (Penghisap)','ALS-013','Alat penghisap cairan dari saluran pernapasan','Alat Medis','PT. Suction Medical','2024-06-10',5500000.00,4400000.00,'aktif','Ruang ICU Lantai 4',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(31,'Koleksi Darah Steril Tabung','ALS-014','Tabung pengambilan darah steril 5ml (100 pcs)','Alat Medis','PT. Blood Collection','2025-01-06',1800000.00,1500000.00,'aktif','Lab Lantai Basement',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(32,'Slide Mikroskop Steril','ALS-015','Slide mikroskop steril untuk pemeriksaan','Alat Medis','PT. Lab Equipment','2025-01-07',1200000.00,1000000.00,'aktif','Lab Lantai Basement',NULL,NULL,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12');
/*!40000 ALTER TABLE `asets` ENABLE KEYS */;

--
-- Table structure for table `barbers`
--

DROP TABLE IF EXISTS `barbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barbers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesialisasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengalaman_tahun` int NOT NULL DEFAULT '0',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barbers`
--

/*!40000 ALTER TABLE `barbers` DISABLE KEYS */;
INSERT INTO `barbers` VALUES (1,'Aldi Pratama','Classic Cut & Shave',7,'081234567001','barber_1.jpg','aktif','2026-06-02 04:04:04','2026-07-05 03:43:00'),(2,'Rizky Firmansyah','Fade & Modern Style',5,'081234567002','barber_2.jpg','aktif','2026-06-02 04:04:04','2026-07-05 03:43:00'),(3,'Doni Setiawan','Beard Grooming & Coloring',4,'081234567003','barber_3.jpg','aktif','2026-06-02 04:04:04','2026-07-05 03:43:00'),(4,'Hendra Kusuma','Hair Treatment & Spa',6,'081234567004','barber_4.jpg','aktif','2026-06-02 04:04:04','2026-07-05 03:43:00'),(5,'Bagas Nugroho','Skin Fade & Design',3,'081234567005','barber_5.jpg','aktif','2026-06-02 04:04:04','2026-07-05 03:43:00'),(6,'John Barber','Hairstylist',67,'17.980,00','barber_1781067142.jpeg','aktif','2026-06-02 04:19:16','2026-06-10 04:52:24');
/*!40000 ALTER TABLE `barbers` ENABLE KEYS */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (7,'Dell','dell@gmail.com','$2y$12$8x5NKhp.JDJo9RiZc1W42erxgocoJVox0dHueRbW6tHxDIEMQRSnO',NULL,NULL,NULL,NULL,'2026-06-07 14:28:33','2026-06-07 16:30:46'),(8,'herman','herman@gmail.com','$2y$12$XTAV8dQuKJjmo0WVqLpoZOM6noNDBlkknojmF1iEhAkWfJd6cBgqe','08123412345','JL Kober Kecil RT01/RW02','cust_1780901967.jpg',NULL,'2026-06-08 06:53:21','2026-06-26 11:10:06'),(9,'Adia Rahma','dellzevz@gmail.com',NULL,NULL,NULL,'https://lh3.googleusercontent.com/a/ACg8ocJwRgxmCGID71KmAlSmaMo7JOe0i0Y-_CdWlFpA1WFPRKC1jw=s96-c','107204534618185480319','2026-06-27 06:25:20','2026-06-27 06:25:20'),(10,'dell1','dell1@gmail.com','$2y$12$M5ykiW1o9iIfBXe9bGwtjO8SRSyLR.6YShLFornYhKXdywbXSiwPC',NULL,NULL,NULL,NULL,'2026-06-29 02:17:40','2026-06-29 02:17:40'),(11,'Dell','Delll@gmail.com','$2y$12$PxYlJTaAu2lTAfqq8odAOebl03IkFWN/3BuYTYrpGHiJSEglnPrBG','08132465','jln kober',NULL,NULL,'2026-07-05 01:43:05','2026-07-05 03:12:45'),(12,'Dell','dell@test.com','$2y$12$kRV.4.hLyS/8opIwzDvqXuuZKyOa7gwz2dxJOjdYIdTdDRDEWK.06','081234856','jln kober',NULL,NULL,'2026-07-05 02:50:30','2026-07-05 03:05:50'),(13,'wildan','idan@gmail.com','$2y$12$6Ot5894Qu.vKaGOL2GAov.YUeulpPSTUQv/SReBmyJ3x16P1sftvW','08123456','jln pedati',NULL,NULL,'2026-07-05 03:56:14','2026-07-05 03:57:10');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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

--
-- Dumping data for table `failed_jobs`
--

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

--
-- Table structure for table `foto_produk`
--

DROP TABLE IF EXISTS `foto_produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foto_produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produk_id` bigint unsigned NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foto_produk_produk_id_foreign` (`produk_id`),
  CONSTRAINT `foto_produk_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foto_produk`
--

/*!40000 ALTER TABLE `foto_produk` DISABLE KEYS */;
/*!40000 ALTER TABLE `foto_produk` ENABLE KEYS */;

--
-- Table structure for table `galeris`
--

DROP TABLE IF EXISTS `galeris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galeris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('hairstyle','haircut','beard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'haircut',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeris`
--

/*!40000 ALTER TABLE `galeris` DISABLE KEYS */;
INSERT INTO `galeris` VALUES (1,'Haircut Klasik Rapi','gal_1.jpg','Hasil potong rambut klasik yang bersih dan rapi.','haircut','2026-07-05 03:43:33','2026-07-05 03:43:33'),(2,'Shave & Beard Grooming','gal_2.jpg','Cukur jenggot dengan pisau klasik dan perawatan.','beard','2026-07-05 03:43:33','2026-07-05 03:43:33'),(3,'Hair Coloring Modern','gal_3.jpg','Pewarnaan rambut gaya modern.','hairstyle','2026-07-05 03:43:33','2026-07-05 03:43:33'),(4,'Suasana Barbershop','gal_4.jpg','Interior barbershop yang nyaman.','haircut','2026-07-05 03:43:33','2026-07-05 03:43:33'),(5,'Fade & Modern Style','gal_5.jpg','Skin fade dan gaya modern kekinian.','hairstyle','2026-07-05 03:43:33','2026-07-05 03:43:33'),(6,'Paket Full Service','gal_6.jpg','Paket lengkap grooming pria.','haircut','2026-07-05 03:43:33','2026-07-05 03:43:33');
/*!40000 ALTER TABLE `galeris` ENABLE KEYS */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
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

--
-- Dumping data for table `job_batches`
--

/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
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

--
-- Dumping data for table `jobs`
--

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Hair Styling'),(2,'Perawatan Rambut'),(3,'Perawatan Jenggot');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

--
-- Table structure for table `layanans`
--

DROP TABLE IF EXISTS `layanans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` decimal(10,2) NOT NULL,
  `durasi_menit` int NOT NULL DEFAULT '30',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanans`
--

/*!40000 ALTER TABLE `layanans` DISABLE KEYS */;
INSERT INTO `layanans` VALUES (29,'Haircut Reguler','Potong rambut standar menggunakan gunting dan sisir oleh barber profesional. Cocok untuk semua tipe rambut.',35000.00,30,'lay_29.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00'),(30,'Haircut + Styling','Potong rambut lengkap dengan penataan gaya menggunakan pomade atau wax pilihan. Tampil rapi dan stylish.',50000.00,45,'lay_30.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00'),(31,'Shave & Beard Trim','Cukur jenggot dan kumis dengan pisau cukur klasik, dilanjutkan perawatan dengan aftershave untuk kulit segar.',25000.00,20,'layanan_1781067264.jpg','aktif','2026-06-02 04:05:07','2026-06-10 04:54:26'),(32,'Hair Wash + Blow Dry','Keramas dengan shampo premium pria, pemijatan kepala, dan blow dry hingga rapi sempurna.',30000.00,30,'lay_32.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00'),(33,'Creambath','Perawatan rambut intensif dengan krim bergizi, pijatan kepala yang menenangkan, dan steam untuk hasil maksimal.',75000.00,60,'lay_33.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00'),(34,'Hair Coloring','Pewarnaan rambut profesional dengan cat berkualitas tinggi. Tersedia berbagai pilihan warna natural hingga bold.',150000.00,90,'lay_34.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00'),(35,'Paket Full Service','Paket lengkap meliputi haircut, beard trim, hair wash, creambath, dan styling. Pengalaman grooming paling premium.',200000.00,120,'lay_35.jpg','aktif','2026-06-02 04:05:07','2026-07-05 03:43:00');
/*!40000 ALTER TABLE `layanans` ENABLE KEYS */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_05_26_000001_create_barbers_table',1),(2,'2026_05_26_000002_create_layanans_table',1),(3,'2026_05_26_000003_create_galeris_table',1),(4,'2026_05_26_000004_create_customers_table',2),(5,'2026_05_26_000005_create_orders_table',2),(6,'2026_05_26_000006_create_order_items_table',2),(7,'0001_01_01_000000_create_users_table',3),(8,'0001_01_01_000001_create_cache_table',3),(9,'0001_01_01_000002_create_jobs_table',3),(10,'0001_01_01_000003_create_sessions_table',3),(11,'2025_10_23_014340_create_personal_access_tokens_table',3),(12,'2025_11_20_010950_create_kategori_table',3),(13,'2025_11_20_100056_create_produk_table',3),(14,'2025_11_20_105435_create_foto_produk_table',3),(15,'2025_11_27_142025_create_pegawais_table',3),(16,'2025_11_27_142829_create_asets_table',3),(17,'2025_12_09_204046_create_roles_table',3),(18,'2025_12_09_204356_create_permissions_table',3),(19,'2025_12_09_204423_create_role_permissions_table',3),(20,'2025_12_09_204449_create_user_roles_table',3),(21,'2025_12_09_204516_add_security_fields_to_user_table',3),(22,'2025_12_16_142218_create_pegawai_attendance_logs_table',3),(23,'2025_12_18_083036_create_activity_logs_table',3),(24,'2025_12_18_092906_create_settings_table',3),(25,'2026_05_26_000007_add_payment_to_orders',4),(26,'2026_06_07_000001_add_payment_channel_to_orders',5),(27,'2026_06_09_000001_add_hidden_at_to_orders',6),(28,'2026_06_25_182741_add_barber_id_to_orders_table',7),(29,'2026_06_25_182833_add_barber_id_to_orders_table',7),(30,'2026_06_26_093538_add_shipping_to_orders_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `layanan_id` bigint unsigned DEFAULT NULL,
  `produk_id` bigint unsigned DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_layanan_id_foreign` (`layanan_id`),
  KEY `order_items_produk_id_foreign` (`produk_id`),
  CONSTRAINT `order_items_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (7,7,31,NULL,1,25000.00,'2026-06-07 14:28:44','2026-06-07 14:28:44'),(10,9,NULL,1,1,38000.00,'2026-06-07 15:41:17','2026-06-07 15:41:17'),(11,8,NULL,1,1,38000.00,'2026-06-07 16:32:14','2026-06-07 16:32:14'),(16,10,NULL,2,1,55000.00,'2026-06-08 02:12:24','2026-06-08 02:12:24'),(17,10,29,NULL,1,35000.00,'2026-06-08 02:12:28','2026-06-08 02:12:28'),(19,11,31,NULL,1,25000.00,'2026-06-08 02:24:21','2026-06-08 02:24:21'),(20,12,29,NULL,1,35000.00,'2026-06-08 03:09:03','2026-06-08 03:09:03'),(21,14,35,NULL,1,200000.00,'2026-06-08 03:27:15','2026-06-08 03:27:15'),(22,13,29,NULL,1,35000.00,'2026-06-08 03:53:35','2026-06-08 03:53:35'),(23,15,31,NULL,1,25000.00,'2026-06-08 06:53:45','2026-06-08 06:53:45'),(24,15,NULL,2,3,55000.00,'2026-06-08 06:54:05','2026-06-08 06:54:39'),(25,15,NULL,3,1,49000.00,'2026-06-08 06:54:08','2026-06-08 06:54:08'),(27,16,NULL,2,1,55000.00,'2026-06-08 07:00:16','2026-06-08 07:00:16'),(28,16,32,NULL,1,30000.00,'2026-06-08 07:17:58','2026-06-08 07:17:58'),(29,17,29,NULL,1,35000.00,'2026-06-08 07:33:00','2026-06-08 07:33:00'),(32,20,29,NULL,1,35000.00,'2026-06-08 08:06:14','2026-06-08 08:06:14'),(33,21,29,NULL,1,50000.00,'2026-06-09 01:51:12','2026-06-09 01:51:12'),(34,22,29,NULL,1,35000.00,'2026-06-10 04:43:43','2026-06-10 04:43:43'),(35,23,31,NULL,1,25000.00,'2026-06-25 06:10:59','2026-06-25 06:10:59'),(38,24,NULL,2,1,55000.00,'2026-06-25 07:04:11','2026-06-25 07:04:11'),(39,25,31,NULL,1,25000.00,'2026-06-25 07:06:05','2026-06-25 07:06:05'),(42,26,NULL,1,2,38000.00,'2026-06-26 11:11:02','2026-06-26 11:11:07'),(43,27,31,NULL,1,25000.00,'2026-06-27 06:24:58','2026-06-29 03:32:08'),(44,28,31,NULL,1,25000.00,'2026-06-29 02:18:32','2026-06-29 02:18:32'),(45,29,31,NULL,1,25000.00,'2026-06-29 02:18:57','2026-06-29 02:18:57'),(46,30,31,NULL,1,25000.00,'2026-06-29 02:22:09','2026-06-29 02:22:09'),(47,31,31,NULL,1,25000.00,'2026-06-29 02:22:32','2026-06-29 02:22:32'),(48,32,31,NULL,1,25000.00,'2026-07-05 03:13:01','2026-07-05 03:13:01'),(49,33,31,NULL,1,25000.00,'2026-07-05 03:13:17','2026-07-05 03:13:17'),(50,34,31,NULL,1,25000.00,'2026-07-05 03:16:53','2026-07-05 03:16:53'),(51,35,31,NULL,1,25000.00,'2026-07-05 03:18:09','2026-07-05 03:18:09'),(52,36,NULL,2,1,55000.00,'2026-07-05 03:30:19','2026-07-05 03:30:19'),(53,37,NULL,1,1,38000.00,'2026-07-05 03:33:22','2026-07-05 03:33:22'),(54,38,31,NULL,1,25000.00,'2026-07-05 03:57:33','2026-07-05 03:57:33'),(55,39,NULL,5,1,33000.00,'2026-07-05 03:59:01','2026-07-05 03:59:01'),(56,39,NULL,1,2,38000.00,'2026-07-05 03:59:01','2026-07-05 03:59:01');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `total_harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','confirmed','done','batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `jenis` enum('booking','produk') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'booking',
  `metode_bayar` enum('transfer','cash','ewallet') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kanal_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_bayar` enum('belum','menunggu_verifikasi','lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibayar_pada` timestamp NULL DEFAULT NULL,
  `hidden_at` timestamp NULL DEFAULT NULL,
  `alamat_kirim` text COLLATE utf8mb4_unicode_ci,
  `kota_tujuan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota_tujuan_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kurir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layanan_ongkir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_ongkir` decimal(12,2) NOT NULL DEFAULT '0.00',
  `estimasi_ongkir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_berat` double DEFAULT NULL,
  `tanggal_booking` date DEFAULT NULL,
  `jam_booking` time DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barber_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_barber_id_foreign` (`barber_id`),
  CONSTRAINT `orders_barber_id_foreign` FOREIGN KEY (`barber_id`) REFERENCES `barbers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (7,7,25000.00,'confirmed','booking','transfer',NULL,'menunggu_verifikasi','bukti_7_1780846355.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-08','12:12:00',NULL,'2026-06-07 14:28:44','2026-06-07 15:32:35',NULL),(8,7,38000.00,'confirmed','produk','transfer','BCA','belum',NULL,NULL,NULL,NULL,'Jl. Uji No. 1',NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-20','10:00:00',NULL,'2026-06-07 15:39:17','2026-06-08 03:14:49',NULL),(9,7,38000.00,'confirmed','produk','ewallet','OVO','lunas',NULL,'BF-260607233219-8FER','2026-06-07 16:32:19',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,NULL,NULL,NULL,'2026-06-07 15:41:17','2026-06-07 16:32:19',NULL),(10,7,90000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260608091230-46SZ','2026-06-08 02:12:30',NULL,'Jl. Uji 1',NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-20','10:00:00',NULL,'2026-06-07 16:56:34','2026-06-08 02:12:30',NULL),(11,7,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260608101430-8CJJ','2026-06-08 03:14:30',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-09','09:00:00',NULL,'2026-06-08 02:22:18','2026-06-08 03:14:30',NULL),(12,7,35000.00,'confirmed','booking','ewallet','OVO','lunas',NULL,'BF-260608100906-N3MG','2026-06-08 03:09:06',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-25','11:00:00',NULL,'2026-06-08 03:09:03','2026-06-08 03:09:06',NULL),(13,7,35000.00,'batal','booking',NULL,NULL,'belum',NULL,NULL,NULL,'2026-06-09 01:51:13',NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-26','12:00:00',NULL,'2026-06-08 03:17:47','2026-06-09 01:51:13',NULL),(14,7,200000.00,'confirmed','booking','transfer','BCA','lunas',NULL,'BF-260608105343-SR8B','2026-06-08 03:53:43',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-21','10:00:00',NULL,'2026-06-08 03:27:15','2026-06-08 03:53:43',NULL),(15,8,239000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260608135749-ISRK','2026-06-08 06:57:49',NULL,'jl kober',NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-10','15:00:00',NULL,'2026-06-08 06:53:45','2026-06-08 06:57:49',NULL),(16,8,85000.00,'batal','booking',NULL,NULL,'belum',NULL,NULL,NULL,'2026-06-09 01:51:13','sdad',NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-12','17:00:00',NULL,'2026-06-08 06:59:57','2026-06-09 01:51:13',NULL),(17,7,35000.00,'batal','booking',NULL,NULL,'belum',NULL,NULL,NULL,'2026-06-09 01:51:13',NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-01','14:00:00',NULL,'2026-06-08 07:33:00','2026-06-09 01:51:13',NULL),(20,7,35000.00,'pending','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,NULL,NULL,NULL,'2026-06-08 08:06:14','2026-06-08 08:06:14',NULL),(21,7,50000.00,'batal','booking',NULL,NULL,'belum',NULL,NULL,NULL,'2026-06-09 01:51:13',NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-10','15:00:00',NULL,'2026-06-09 01:51:12','2026-06-09 01:51:13',NULL),(22,8,35000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-10','12:00:00',NULL,'2026-06-10 04:43:43','2026-06-10 04:44:12',NULL),(23,8,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260625131131-XTGR','2026-06-25 06:11:31',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-26','12:00:00',NULL,'2026-06-25 06:10:59','2026-06-25 06:11:31',NULL),(24,8,55000.00,'confirmed','produk','ewallet','DANA','lunas',NULL,'BF-260625140522-HBYF','2026-06-25 07:05:22',NULL,'jl kober',NULL,NULL,NULL,NULL,0.00,NULL,NULL,NULL,NULL,NULL,'2026-06-25 06:14:57','2026-06-25 07:05:22',NULL),(25,8,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260625140642-ILVG','2026-06-25 07:06:42',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-26','13:00:00',NULL,'2026-06-25 07:06:00','2026-06-25 07:06:42',NULL),(26,8,76000.00,'confirmed','produk','ewallet','DANA','lunas',NULL,'BF-260626204505-AHDP','2026-06-26 13:45:05',NULL,'JL kober kecil','17707','RAWA BUNGA, JATINEGARA, JAKARTA TIMUR, DKI JAKARTA, 13350','JNE','CTC',10000.00,'1 day',440,NULL,NULL,NULL,'2026-06-26 11:04:01','2026-06-26 13:45:05',NULL),(27,8,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260629104131-X5DV','2026-06-29 03:41:31',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-30','10:30:00',NULL,'2026-06-26 13:47:13','2026-06-29 03:41:31',2),(28,10,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-30','13:00:00',NULL,'2026-06-29 02:18:32','2026-06-29 02:18:32',1),(29,10,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-30','14:00:00',NULL,'2026-06-29 02:18:57','2026-06-29 02:18:57',1),(30,10,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-30','10:00:00','konfirmasi','2026-06-29 02:22:09','2026-06-29 02:22:09',6),(31,10,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-06-30','11:00:00','konfirmasi','2026-06-29 02:22:32','2026-06-29 02:22:32',6),(32,11,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-05','10:00:00',NULL,'2026-07-05 03:13:01','2026-07-05 03:13:01',4),(33,11,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-05','11:00:00',NULL,'2026-07-05 03:13:17','2026-07-05 03:13:17',4),(34,12,25000.00,'confirmed','booking',NULL,NULL,'belum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-10','14:00:00','test','2026-07-05 03:16:53','2026-07-05 03:16:53',1),(35,11,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260705101821-JF34','2026-07-05 03:18:21',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-05','10:00:00',NULL,'2026-07-05 03:18:09','2026-07-05 03:18:21',6),(36,12,55000.00,'confirmed','produk',NULL,NULL,'belum',NULL,NULL,NULL,NULL,'jln kober','14165','RAWA BUNGA, JATINEGARA','JNE','CTC',10000.00,'1 day',200,NULL,NULL,'test','2026-07-05 03:30:19','2026-07-05 03:30:19',NULL),(37,11,38000.00,'confirmed','produk','ewallet','DANA','lunas',NULL,'BF-260705103328-NLDB','2026-07-05 03:33:28',NULL,'jln kober','17707','RAWA BUNGA, JATINEGARA, JAKARTA TIMUR, DKI JAKARTA, 13350','JNE','CTC',10000.00,'1 day',220,NULL,NULL,NULL,'2026-07-05 03:33:22','2026-07-05 03:33:28',NULL),(38,13,25000.00,'confirmed','booking','ewallet','DANA','lunas',NULL,'BF-260705105750-SYP8','2026-07-05 03:57:50',NULL,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,'2026-07-06','11:00:00',NULL,'2026-07-05 03:57:33','2026-07-05 03:57:50',5),(39,13,109000.00,'done','produk','transfer','BNI','lunas',NULL,'BF-260705105912-AI10','2026-07-05 03:59:12',NULL,'jln pedati','14165','RAWA (MEUNASAH RAWA), LHOKSUKON, ACEH UTARA, NANGGROE ACEH DARUSSALAM (NAD), 24382','JNE','REG',63000.00,'4 day',710,NULL,NULL,NULL,'2026-07-05 03:59:01','2026-07-06 02:24:39',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `pegawai_attendance_logs`
--

DROP TABLE IF EXISTS `pegawai_attendance_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai_attendance_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in_time` timestamp NULL DEFAULT NULL,
  `check_out_time` timestamp NULL DEFAULT NULL,
  `check_in_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Optional for prototype',
  `check_out_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Optional for prototype',
  `check_in_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Manual verification by admin',
  `check_out_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Manual verification by admin',
  `status` enum('present','late','absent','leave','sick','holiday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_duration_minutes` int DEFAULT NULL,
  `overtime_minutes` int NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawai_attendance_logs_pegawai_id_date_unique` (`pegawai_id`,`date`),
  KEY `pegawai_attendance_logs_approved_by_foreign` (`approved_by`),
  KEY `pegawai_attendance_logs_pegawai_id_index` (`pegawai_id`),
  KEY `pegawai_attendance_logs_date_index` (`date`),
  KEY `pegawai_attendance_logs_status_index` (`status`),
  CONSTRAINT `pegawai_attendance_logs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pegawai_attendance_logs_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawais` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai_attendance_logs`
--

/*!40000 ALTER TABLE `pegawai_attendance_logs` DISABLE KEYS */;
INSERT INTO `pegawai_attendance_logs` VALUES (1,58,'2026-06-27','2026-06-27 06:14:25','2026-06-27 06:18:26',NULL,NULL,0,0,'late',4,0,NULL,NULL,NULL,'2026-06-27 06:14:25','2026-06-27 06:18:26');
/*!40000 ALTER TABLE `pegawai_attendance_logs` ENABLE KEYS */;

--
-- Table structure for table `pegawais`
--

DROP TABLE IF EXISTS `pegawais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawais` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pegawai` enum('aktif','cuti','resign') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `tanggal_masuk` date NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `gaji_pokok` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawais_email_unique` (`email`),
  KEY `pegawais_user_id_foreign` (`user_id`),
  CONSTRAINT `pegawais_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawais`
--

/*!40000 ALTER TABLE `pegawais` DISABLE KEYS */;
INSERT INTO `pegawais` VALUES (1,'Dr. Ahmad Fauzi','ahmad.fauzi@carexis.com','081234567890','Jl. Merdeka No. 123, Jakarta','Dokter Umum','Medis','aktif','2020-01-15','1985-05-20','laki-laki',NULL,NULL,15000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(2,'Dr. Siti Nurhaliza','siti.nurhaliza@carexis.com','081234567891','Jl. Sudirman No. 45, Jakarta','Dokter Spesialis Anak','Medis','aktif','2019-03-10','1987-08-15','perempuan',NULL,NULL,20000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(3,'Budi Santoso','budi.santoso@carexis.com','081234567892','Jl. Thamrin No. 78, Jakarta','Perawat','Medis','aktif','2021-06-01','1990-03-12','laki-laki',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(4,'Dewi Lestari','dewi.lestari@carexis.com','081234567893','Jl. Gatot Subroto No. 90, Jakarta','Perawat','Medis','aktif','2020-09-15','1992-11-25','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(5,'Rina Wijaya','rina.wijaya@carexis.com','081234567894','Jl. Kuningan No. 12, Jakarta','Staff Administrasi','Administrasi','aktif','2022-02-01','1995-07-08','perempuan',NULL,NULL,5000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(6,'Andi Prasetyo','andi.prasetyo@carexis.com','081234567895','Jl. HR Rasuna Said No. 34, Jakarta','Kepala HRD','Kepegawaian','aktif','2018-05-20','1983-04-18','laki-laki',NULL,NULL,12000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(7,'Maya Sari','maya.sari@carexis.com','081234567896','Jl. MT Haryono No. 56, Jakarta','Apoteker','Farmasi','aktif','2021-10-01','1989-12-05','perempuan',NULL,NULL,9000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(8,'Rudi Hermawan','rudi.hermawan@carexis.com','081234567897','Jl. Casablanca No. 88, Jakarta','IT Support','IT','aktif','2022-07-15','1994-02-28','laki-laki',NULL,NULL,8000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(9,'Fitri Handayani','fitri.handayani@carexis.com','081234567898','Jl. Menteng No. 23, Jakarta','Customer Service','Administrasi','cuti','2021-04-10','1993-09-14','perempuan',NULL,NULL,5500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(10,'Agus Setiawan','agus.setiawan@carexis.com','081234567899','Jl. Kemang No. 67, Jakarta','Security','Keamanan','aktif','2019-11-01','1988-06-22','laki-laki',NULL,NULL,4500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(11,'Dr. Hendra Wijaya','hendra.wijaya@carexis.com','081234567900','Jl. Blok M No. 10','Dokter Umum','Medis','aktif','2021-01-15','1986-03-10','laki-laki',NULL,NULL,16000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(12,'dr. Eka Putri','eka.putri@carexis.com','081234567901','Jl. Senayan No. 25','Dokter Spesialis','Medis','aktif','2020-02-10','1984-07-22','perempuan',NULL,NULL,22000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(13,'Nurul Hidayah','nurul.hidayah@carexis.com','081234567902','Jl. Kuningan No. 45','Perawat','Medis','aktif','2022-03-01','1995-11-08','perempuan',NULL,NULL,7200000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(14,'Bambang Hartono','bambang.hartono@carexis.com','081234567903','Jl. Gatot Subroto No. 100','Perawat','Medis','aktif','2021-05-20','1991-04-15','laki-laki',NULL,NULL,7200000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(15,'Linda Susanti','linda.susanti@carexis.com','081234567904','Jl. Menteng No. 55','Bidan','Kebidanan','aktif','2020-08-10','1990-09-05','perempuan',NULL,NULL,8000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(16,'Slamet Riyanto','slamet.riyanto@carexis.com','081234567905','Jl. Ahmad Yani No. 30','Teknisi Lab','Laboratorium','aktif','2021-06-01','1992-02-12','laki-laki',NULL,NULL,6500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(17,'Tatik Wijaya','tatik.wijaya@carexis.com','081234567906','Jl. Panglima No. 40','Staff Farmasi','Farmasi','aktif','2022-01-15','1996-05-20','perempuan',NULL,NULL,6000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(18,'Cahyo Purnomo','cahyo.purnomo@carexis.com','081234567907','Jl. Sudirman No. 78','Staff IT','IT','aktif','2021-09-01','1994-08-18','laki-laki',NULL,NULL,8500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(19,'Heni Kusumastuti','heni.kusumastuti@carexis.com','081234567908','Jl. Hayam Wuruk No. 55','Admin Keuangan','Keuangan','aktif','2020-04-01','1988-10-25','perempuan',NULL,NULL,7500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(20,'Yudi Kristanto','yudi.kristanto@carexis.com','081234567909','Jl. Ismail Marzuki No. 15','Manager Operasional','Operasional','aktif','2019-07-10','1985-01-22','laki-laki',NULL,NULL,13000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(21,'Siti Rahma','siti.rahma@carexis.com','081234567910','Jl. MT Haryono No. 88','Perawat','Medis','cuti','2021-02-15','1993-06-30','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(22,'Arief Gunawan','arief.gunawan@carexis.com','081234567911','Jl. Benda No. 25','Analis Kesehatan','Laboratorium','aktif','2020-10-01','1989-12-03','laki-laki',NULL,NULL,6800000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(23,'Wiwit Hariyanto','wiwit.hariyanto@carexis.com','081234567912','Jl. Raya Bogor No. 60','Dokter Gigi','Gigi','aktif','2021-04-01','1987-09-14','perempuan',NULL,NULL,18000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(24,'Suryanto Budi','suryanto.budi@carexis.com','081234567913','Jl. Casablanca No. 100','Petugas Kebersihan','Operasional','aktif','2022-05-01','1996-03-20','laki-laki',NULL,NULL,4000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(25,'Endang Sulistyowati','endang.sulistyowati@carexis.com','081234567914','Jl. Setiabudi No. 45','Nutrisionis','Gizi','aktif','2020-06-15','1991-07-11','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(26,'Rinto Soeprapto','rinto.soeprapto@carexis.com','081234567915','Jl. Kuningan No. 88','Dokter','Medis','aktif','2019-09-01','1984-11-05','laki-laki',NULL,NULL,17000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(27,'Susi Handayani','susi.handayani@carexis.com','081234567916','Jl. Imam Bonjol No. 30','Radiografer','Radiologi','aktif','2021-03-01','1993-02-16','perempuan',NULL,NULL,8000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(28,'Dani Hermawan','dani.hermawan@carexis.com','081234567917','Jl. Diponegoro No. 50','Maintenance','Teknik','aktif','2020-08-01','1990-05-08','laki-laki',NULL,NULL,5500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(29,'Komala Sari','komala.sari@carexis.com','081234567918','Jl. Raden Saleh No. 25','Resepsionis','Administrasi','aktif','2021-07-01','1997-01-12','perempuan',NULL,NULL,5000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(30,'Prabowo Aji','prabowo.aji@carexis.com','081234567919','Jl. Kunciran No. 35','Driver','Operasional','aktif','2022-02-01','1994-08-24','laki-laki',NULL,NULL,4800000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(31,'Ningsih Dwi','ningsih.dwi@carexis.com','081234567920','Jl. Medlindsari No. 15','Asisten Medis','Medis','aktif','2021-08-15','1995-04-27','perempuan',NULL,NULL,6500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(32,'Tomi Setiawan','tomi.setiawan@carexis.com','081234567921','Jl. Terogong No. 40','Admin Medis','Administrasi','aktif','2020-09-01','1992-10-30','laki-laki',NULL,NULL,6000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(33,'Rini Setyowati','rini.setyowati@carexis.com','081234567922','Jl. Raya Kebon Jeruk','Cleaning Service','Operasional','aktif','2022-03-15','1996-06-05','perempuan',NULL,NULL,4000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(34,'Gunawan Pratama','gunawan.pratama@carexis.com','081234567923','Jl. Kompleks Kemakmuran','Security Officer','Keamanan','aktif','2021-10-01','1989-09-18','laki-laki',NULL,NULL,5000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(35,'Ani Suwarto','ani.suwarto@carexis.com','081234567924','Jl. Pasar Minggu No. 20','Koordinator Asuhan','Medis','aktif','2020-11-01','1990-08-22','perempuan',NULL,NULL,9000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(36,'Bintang Wijaya','bintang.wijaya@carexis.com','081234567925','Jl. Kemang No. 45','Dokter','Medis','aktif','2019-04-15','1983-12-10','laki-laki',NULL,NULL,19000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(37,'Dewita Salsabila','dewita.salsabila@carexis.com','081234567926','Jl. Gatot No. 65','Perawat','Medis','aktif','2022-01-10','1996-11-03','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(38,'Endra Marpaung','endra.marpaung@carexis.com','081234567927','Jl. Taman Ismail','Teknisi Medis','Teknik','aktif','2021-05-15','1993-03-25','laki-laki',NULL,NULL,7500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(39,'Friska Amelia','friska.amelia@carexis.com','081234567928','Jl. Setiabudi No. 80','Fisioterapis','Rehabilitasi','aktif','2021-06-01','1994-07-08','perempuan',NULL,NULL,8500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(40,'Heru Kristianto','heru.kristianto@carexis.com','081234567929','Jl. Mertani No. 30','Apoteker','Farmasi','aktif','2020-07-01','1988-05-14','laki-laki',NULL,NULL,9500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(41,'Ika Mursitowati','ika.mursitowati@carexis.com','081234567930','Jl. Jend Sudirman No. 12','Perawat','Medis','aktif','2021-09-15','1995-10-19','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(42,'Joko Supriyanto','joko.supriyanto@carexis.com','081234567931','Jl. Benda No. 88','Dokumentasi Medis','Administrasi','aktif','2020-10-15','1989-11-02','laki-laki',NULL,NULL,6000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(43,'Kusuma Dewi','kusuma.dewi@carexis.com','081234567932','Jl. Blok M No. 22','Perawat','Medis','aktif','2021-11-01','1996-02-28','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(44,'Lanang Hardianto','lanang.hardianto@carexis.com','081234567933','Jl. Terogong No. 55','Analis Laboratorium','Laboratorium','aktif','2020-12-01','1991-04-10','laki-laki',NULL,NULL,6800000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(45,'Monica Sariasih','monica.sariasih@carexis.com','081234567934','Jl. Salemba Raya','Perawat','Medis','aktif','2021-12-15','1997-08-05','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(46,'Nendra Pratama','nendra.pratama@carexis.com','081234567935','Jl. Raya Pondok Gede','Teknisi Laboratorium','Laboratorium','aktif','2022-01-20','1997-09-14','laki-laki',NULL,NULL,6000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(47,'Oktaviana Putri','oktaviana.putri@carexis.com','081234567936','Jl. Kemang Utara No. 5','Asisten Apoteker','Farmasi','aktif','2022-02-15','1997-03-22','perempuan',NULL,NULL,5500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(48,'Pia Handoko','pia.handoko@carexis.com','081234567937','Jl. Jatinegara Barat','Staff Administrasi','Administrasi','aktif','2021-03-20','1994-12-08','perempuan',NULL,NULL,5500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(49,'Reno Budiono','reno.budiono@carexis.com','081234567938','Jl. Pramuka No. 50','Perawat','Medis','aktif','2021-04-10','1993-01-15','laki-laki',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(50,'Sinta Rahayu','sinta.rahayu@carexis.com','081234567939','Jl. Medansatria No. 25','Kamar Operasi','Medis','aktif','2020-05-01','1989-02-20','perempuan',NULL,NULL,8000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(51,'Tria Gunawan','tria.gunawan@carexis.com','081234567940','Jl. Merdeka Utara No. 10','Perawat','Medis','aktif','2021-05-25','1995-07-11','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(52,'Ujang Supratman','ujang.supratman@carexis.com','081234567941','Jl. Bendungan Hilir No. 30','Operator Radiologi','Radiologi','aktif','2021-06-15','1992-08-09','laki-laki',NULL,NULL,7500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(53,'Vicky Setyo','vicky.setyo@carexis.com','081234567942','Jl. Matraman Raya No. 15','Perawat','Medis','aktif','2022-03-01','1996-09-07','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(54,'Wahyu Siburian','wahyu.siburian@carexis.com','081234567943','Jl. Cikini No. 70','Staff Medis','Medis','aktif','2021-07-10','1993-10-16','laki-laki',NULL,NULL,6500000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(55,'Xenia Wulandari','xenia.wulandari@carexis.com','081234567944','Jl. Veteran No. 45','Admin Farmasi','Farmasi','aktif','2021-08-20','1995-11-29','perempuan',NULL,NULL,5800000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(56,'Yusuf Irawan','yusuf.irawan@carexis.com','081234567945','Jl. Letjen S. Parman No. 50','Perawat','Medis','aktif','2021-09-05','1994-04-12','laki-laki',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(57,'Zahra Khaira','zahra.khaira@carexis.com','081234567946','Jl. Kepala Batu No. 25','Perawat','Medis','aktif','2022-04-01','1997-05-18','perempuan',NULL,NULL,7000000.00,'2026-06-02 04:03:12','2026-06-02 04:03:12'),(58,'Rizky Maulana','barber1@gmail.com','081234560001','Belum diisi','Barber','Operasional','aktif','2025-12-27','2001-06-27','laki-laki',NULL,7,4000000.00,'2026-06-27 06:12:34','2026-06-27 06:12:34'),(59,'Doni Saputra','barber2@gmail.com','081234560002','Belum diisi','Barber','Operasional','aktif','2025-12-27','2001-06-27','laki-laki',NULL,8,4000000.00,'2026-06-27 06:12:34','2026-06-27 06:12:34');
/*!40000 ALTER TABLE `pegawais` ENABLE KEYS */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Permission name (slug format)',
  `display_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Human-readable permission name',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Permission description',
  `module` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Module category (kepegawaian, inventaris, etc.)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  KEY `permissions_name_index` (`name`),
  KEY `permissions_module_index` (`module`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'user.view','Lihat User','Dapat melihat daftar user','user-management','2026-06-02 04:03:11','2026-06-02 04:03:11'),(2,'user.create','Tambah User','Dapat menambah user baru','user-management','2026-06-02 04:03:11','2026-06-02 04:03:11'),(3,'user.update','Edit User','Dapat mengedit data user','user-management','2026-06-02 04:03:11','2026-06-02 04:03:11'),(4,'user.delete','Hapus User','Dapat menghapus user','user-management','2026-06-02 04:03:11','2026-06-02 04:03:11'),(5,'pegawai.view','Lihat Pegawai','Dapat melihat daftar pegawai','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(6,'pegawai.create','Tambah Pegawai','Dapat menambah pegawai baru','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(7,'pegawai.update','Edit Pegawai','Dapat mengedit data pegawai','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(8,'pegawai.delete','Hapus Pegawai','Dapat menghapus pegawai','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(9,'absensi.view','Lihat Absensi','Dapat melihat data absensi','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(10,'absensi.create','Input Absensi','Dapat melakukan absensi','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(11,'absensi.update','Edit Absensi','Dapat mengedit data absensi','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(12,'absensi.delete','Hapus Absensi','Dapat menghapus data absensi','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(13,'jadwal.view','Lihat Jadwal','Dapat melihat jadwal kerja','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(14,'jadwal.create','Buat Jadwal','Dapat membuat jadwal kerja','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(15,'jadwal.update','Edit Jadwal','Dapat mengedit jadwal kerja','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(16,'jadwal.delete','Hapus Jadwal','Dapat menghapus jadwal kerja','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(17,'gaji.view','Lihat Gaji','Dapat melihat slip gaji','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(18,'gaji.create','Input Gaji','Dapat input data gaji','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(19,'gaji.update','Edit Gaji','Dapat mengedit data gaji','kepegawaian','2026-06-02 04:03:11','2026-06-02 04:03:11'),(20,'aset.view','Lihat Aset','Dapat melihat daftar aset','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(21,'aset.create','Tambah Aset','Dapat menambah aset baru','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(22,'aset.update','Edit Aset','Dapat mengedit data aset','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(23,'aset.delete','Hapus Aset','Dapat menghapus aset','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(24,'kategori.view','Lihat Kategori','Dapat melihat kategori produk','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(25,'kategori.create','Tambah Kategori','Dapat menambah kategori','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(26,'kategori.update','Edit Kategori','Dapat mengedit kategori','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(27,'kategori.delete','Hapus Kategori','Dapat menghapus kategori','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(28,'produk.view','Lihat Produk','Dapat melihat daftar produk/stok','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(29,'produk.create','Tambah Produk','Dapat menambah produk/stok','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(30,'produk.update','Edit Produk','Dapat mengedit produk/stok','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(31,'produk.delete','Hapus Produk','Dapat menghapus produk/stok','inventaris','2026-06-02 04:03:11','2026-06-02 04:03:11'),(32,'laporan.kepegawaian','Laporan Kepegawaian','Dapat melihat dan export laporan kepegawaian','pelaporan','2026-06-02 04:03:11','2026-06-02 04:03:11'),(33,'laporan.inventaris','Laporan Inventaris','Dapat melihat dan export laporan inventaris','pelaporan','2026-06-02 04:03:11','2026-06-02 04:03:11'),(34,'laporan.keuangan','Laporan Keuangan','Dapat melihat dan export laporan keuangan','pelaporan','2026-06-02 04:03:11','2026-06-02 04:03:11'),(35,'settings.view','Lihat Pengaturan','Dapat melihat pengaturan sistem','settings','2026-06-02 04:03:11','2026-06-02 04:03:11'),(36,'settings.update','Edit Pengaturan','Dapat mengubah pengaturan sistem','settings','2026-06-02 04:03:11','2026-06-02 04:03:11'),(89,'attendance.manage-all','Kelola Semua Attendance','Dapat melihat, approve, edit, dan hapus attendance seluruh pegawai','kepegawaian','2026-06-27 06:12:28','2026-06-27 06:12:28'),(90,'attendance.own','Absensi Diri Sendiri','Dapat melakukan check-in/check-out & melihat riwayat absensi sendiri','kepegawaian','2026-06-27 06:12:28','2026-06-27 06:12:28'),(91,'barber.view','Lihat Barber','Dapat melihat daftar barber','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(92,'barber.create','Tambah Barber','Dapat menambah barber baru','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(93,'barber.update','Edit Barber','Dapat mengedit data barber','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(94,'barber.delete','Hapus Barber','Dapat menghapus barber','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(95,'layanan.view','Lihat Layanan','Dapat melihat daftar layanan','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(96,'layanan.create','Tambah Layanan','Dapat menambah layanan baru','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(97,'layanan.update','Edit Layanan','Dapat mengedit data layanan','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(98,'layanan.delete','Hapus Layanan','Dapat menghapus layanan','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(99,'galeri.view','Lihat Galeri','Dapat melihat galeri foto','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(100,'galeri.create','Upload Galeri','Dapat upload foto ke galeri','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(101,'galeri.delete','Hapus Galeri','Dapat menghapus foto galeri','barbershop','2026-06-27 06:12:28','2026-06-27 06:12:28'),(102,'order.view','Lihat Pesanan','Dapat melihat daftar pesanan customer','pesanan','2026-06-27 06:12:28','2026-06-27 06:12:28'),(103,'order.manage','Kelola Pesanan','Dapat mengubah status pesanan & verifikasi pembayaran','pesanan','2026-06-27 06:12:28','2026-06-27 06:12:28'),(104,'backup.manage','Kelola Backup','Dapat membuat, mengunduh, menghapus, dan RESTORE backup database','settings','2026-06-27 06:12:28','2026-06-27 06:12:28');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\Customer',4,'mobile','78117157856d9adf3afddb00b1ea3d19a83e793cfaefd0846daab1b4bbf288ce','[\"*\"]','2026-06-05 08:08:29',NULL,'2026-06-05 08:08:29','2026-06-05 08:08:29'),(2,'App\\Models\\Customer',6,'mobile','fb0ce89d045f9f3c63504d01a4049b08506bf89028918d3134f76da351d7b1b8','[\"*\"]','2026-06-05 10:24:15',NULL,'2026-06-05 10:24:14','2026-06-05 10:24:15'),(3,'App\\Models\\Customer',7,'mobile','ea63e900b11c1673146b6fae9bf5829d83c8f1a58c86df7d508c8e08b9d269c4','[\"*\"]',NULL,NULL,'2026-06-08 02:34:48','2026-06-08 02:34:48'),(4,'App\\Models\\Customer',7,'mobile','79f0bcfb5206dc222fe9de88eec270dd6e771220f3858d6f9bd78f09a834fd23','[\"*\"]',NULL,NULL,'2026-06-08 02:40:12','2026-06-08 02:40:12'),(5,'App\\Models\\Customer',7,'mobile','e30f676ed6abc6ea175db8231cc294579afee8d0a8b2bd099816900dab498548','[\"*\"]','2026-06-08 03:27:29',NULL,'2026-06-08 03:24:47','2026-06-08 03:27:29'),(7,'App\\Models\\Customer',7,'mobile','4d096c822dd3aefb8c2ff7c029f3b28ffd4ceab10d8ab8d7585176a55f02ffbf','[\"*\"]','2026-06-08 03:34:13',NULL,'2026-06-08 03:34:13','2026-06-08 03:34:13'),(8,'App\\Models\\Customer',7,'mobile','f0b074a7fa1f02e637030e931cd2a52fa13cb33072151a26aeb5ed136c5aa74d','[\"*\"]','2026-06-08 03:41:21',NULL,'2026-06-08 03:40:22','2026-06-08 03:41:21'),(9,'App\\Models\\Customer',10,'mobile','9ee03bb27f87f09a74e0fc764675960b0c8d1b1b72632f92db11541c0baefc57','[\"*\"]',NULL,NULL,'2026-06-29 02:17:40','2026-06-29 02:17:40'),(10,'App\\Models\\Customer',10,'mobile','df44f741d2163c3f6c47c5da0f231c5a9f66a8124c91b2ce706c20efc887244e','[\"*\"]','2026-06-29 02:22:32',NULL,'2026-06-29 02:17:53','2026-06-29 02:22:32'),(11,'App\\Models\\Customer',10,'mobile','cd74b4af88adcf7f2be8b5fdfc11188f4b22ef768a643489250ec2310add5f3c','[\"*\"]',NULL,NULL,'2026-06-29 02:45:09','2026-06-29 02:45:09'),(12,'App\\Models\\Customer',10,'mobile','dbc27e2d09facc5390837eb2c9f2c61e76d118365aae86a82cd8699b72f86188','[\"*\"]',NULL,NULL,'2026-06-29 02:50:00','2026-06-29 02:50:00'),(13,'App\\Models\\Customer',10,'mobile','628707c69a9731fb6404d033794f2590b4b1bdbb61ade460273f012913d23d12','[\"*\"]',NULL,NULL,'2026-06-29 03:01:16','2026-06-29 03:01:16'),(14,'App\\Models\\Customer',11,'mobile','afe2a24e4c536da050a0f85ecb7398290b00c24fbc28ced9e7199890dba976e6','[\"*\"]',NULL,NULL,'2026-07-05 01:43:05','2026-07-05 01:43:05'),(15,'App\\Models\\Customer',11,'mobile','88a45d0028ef929cfcc2255715ade99141993d6c677c5d89f41f64a95f082325','[\"*\"]',NULL,NULL,'2026-07-05 01:43:22','2026-07-05 01:43:22'),(16,'App\\Models\\Customer',11,'mobile','bbd4bf878265b118a0022c26d4f7d74b67b58bf2c86de4df8421d2331925f09c','[\"*\"]',NULL,NULL,'2026-07-05 01:47:52','2026-07-05 01:47:52'),(17,'App\\Models\\Customer',11,'mobile','76ac2a434df01be548bc935bcce1b606e2c8a88fc69f3c6a4c8481a8b4d047f5','[\"*\"]',NULL,NULL,'2026-07-05 02:44:57','2026-07-05 02:44:57'),(18,'App\\Models\\Customer',11,'mobile','6630923f549909dc62d7f8c45f81b38acaf9bb2767b0fb4a478eef337427a6f8','[\"*\"]',NULL,NULL,'2026-07-05 02:47:51','2026-07-05 02:47:51'),(19,'App\\Models\\Customer',12,'mobile','4403113b4cc0d3d5f4a2d962cb9c28da1eb67e6aa97bf185239b0d9535387648','[\"*\"]',NULL,NULL,'2026-07-05 02:50:30','2026-07-05 02:50:30'),(20,'App\\Models\\Customer',12,'mobile','ed7c127be8ac0d854b71c2f2295faa6fc0dc1cc289f33b5d1d47bfb6b82caa57','[\"*\"]',NULL,NULL,'2026-07-05 02:54:46','2026-07-05 02:54:46'),(21,'App\\Models\\Customer',7,'probe','bd1e29761c57aa12fcbd83433cbc493c21057ab4a1d24b1b6116ba33bd244ebe','[\"*\"]',NULL,NULL,'2026-07-05 02:58:46','2026-07-05 02:58:46'),(22,'App\\Models\\Customer',12,'mobile','5334be144241ced102a00b4e8af59a5d372c38696e30dea41a76767725e056ba','[\"*\"]','2026-07-05 03:05:50',NULL,'2026-07-05 03:05:49','2026-07-05 03:05:50'),(23,'App\\Models\\Customer',12,'mobile','a2445aeef8e2b16ddcd11febab218bc1cefb3b6d692fe40a83557f1550d46e62','[\"*\"]','2026-07-05 03:07:54',NULL,'2026-07-05 03:07:54','2026-07-05 03:07:54'),(24,'App\\Models\\Customer',11,'mobile','0b2e675dfabdee8614b5d8b6d2051756eb7963abc148963193200bdb95b3fa68','[\"*\"]','2026-07-05 03:14:07',NULL,'2026-07-05 03:12:26','2026-07-05 03:14:07'),(25,'App\\Models\\Customer',12,'mobile','ff8b6f5cd1dd94d345f666c823a72e4d385dbc176dd4277c5e8729daa32053e6','[\"*\"]','2026-07-05 03:16:53',NULL,'2026-07-05 03:16:52','2026-07-05 03:16:53'),(26,'App\\Models\\Customer',11,'mobile','d60f4255e9113d0b92bd5a9bfe2392436f35353bd8b167ab834f4b1378f230b0','[\"*\"]','2026-07-05 03:18:49',NULL,'2026-07-05 03:17:52','2026-07-05 03:18:49'),(27,'App\\Models\\Customer',12,'mobile','70eea4579ba746b616bf9978e360a66994b7e6b68222504d7b4e2fbdc7be8110','[\"*\"]','2026-07-05 03:21:52',NULL,'2026-07-05 03:21:52','2026-07-05 03:21:52'),(29,'App\\Models\\Customer',12,'mobile','dd19cbf0478447fe01691a842b96c0a90c4c6de73fe74f5d57970953d60b6a07','[\"*\"]','2026-07-05 03:30:19',NULL,'2026-07-05 03:30:18','2026-07-05 03:30:19'),(33,'App\\Models\\Customer',13,'mobile','466d85566a84eb60f209cb746913b6010b1c1c63c48a2d643a3081546c2d0be0','[\"*\"]',NULL,NULL,'2026-07-05 03:56:14','2026-07-05 03:56:14'),(35,'App\\Models\\Customer',11,'mobile','39947cfdc0e855e4a59133b257bfcb89c10652b77921517e220c46fd757c65a8','[\"*\"]','2026-07-05 04:11:52',NULL,'2026-07-05 04:11:51','2026-07-05 04:11:52');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `stok` int NOT NULL,
  `berat` double NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_kategori_id_foreign` (`kategori_id`),
  KEY `produk_user_id_foreign` (`user_id`),
  CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  CONSTRAINT `produk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produk`
--

/*!40000 ALTER TABLE `produk` DISABLE KEYS */;
INSERT INTO `produk` VALUES (1,1,1,1,'Makarizo Barber Daily Styling Gel Wet Look 200 ml','Hair styling gel untuk pria yang menyukai kombinasi styling mudah dan tampilan kasual. Diformulasikan dengan ekstrak castor oil serta ekstrak citrus & musk, memberikan aroma segar dan sejuk dengan hasil wet look.',38000,40,220,'makarizo-barber-daily-gel.png','2026-06-07 15:25:39','2026-06-07 15:25:39'),(2,1,1,1,'Classic Hold Pomade Strong 100 g','Pomade water-based dengan daya tahan kuat dan kilau medium. Mudah dibilas, cocok untuk gaya klasik slick back maupun pompadour.',55000,30,120,'prod_2.jpg','2026-06-07 15:28:30','2026-07-05 03:43:00'),(3,1,1,1,'Matte Clay Hair Wax 75 g','Hair clay dengan hasil akhir matte tanpa kilau, daya cengkeram kuat untuk gaya tekstur natural sepanjang hari.',49000,25,95,'prod_3.jpg','2026-06-07 15:28:30','2026-07-05 03:43:00'),(4,2,1,1,'Hair Tonic Anti Rontok 200 ml','Hair tonic penyegar kulit kepala yang membantu mengurangi kerontokan dan menjaga rambut tetap sehat serta ternutrisi.',42000,35,215,'prod_4.jpg','2026-06-07 15:28:30','2026-07-05 03:43:00'),(5,2,1,1,'Daily Shampoo for Men 250 ml','Sampo harian pria dengan sensasi dingin menyegarkan, membersihkan minyak berlebih tanpa membuat rambut kering.',33000,50,270,'prod_5.jpg','2026-06-07 15:28:30','2026-07-05 03:43:00'),(6,3,1,1,'Beard Oil Argan & Jojoba 30 ml','Minyak jenggot dengan argan & jojoba oil untuk melembutkan jenggot, melembapkan kulit, dan memberikan aroma maskulin.',60000,20,45,'prod_6.jpg','2026-06-07 15:28:30','2026-07-05 03:43:00');
/*!40000 ALTER TABLE `produk` ENABLE KEYS */;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role_permission` (`role_id`,`permission_id`),
  KEY `role_permissions_role_id_index` (`role_id`),
  KEY `role_permissions_permission_id_index` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,1,1,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(2,1,2,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(3,1,3,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(4,1,4,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(5,1,5,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(6,1,6,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(7,1,7,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(8,1,8,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(9,1,9,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(10,1,10,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(11,1,11,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(12,1,12,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(13,1,13,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(14,1,14,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(15,1,15,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(16,1,16,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(17,1,17,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(18,1,18,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(19,1,19,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(20,1,20,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(21,1,21,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(22,1,22,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(23,1,23,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(24,1,24,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(25,1,25,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(26,1,26,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(27,1,27,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(28,1,28,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(29,1,29,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(30,1,30,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(31,1,31,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(32,1,32,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(33,1,33,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(34,1,34,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(35,1,35,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(36,1,36,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(37,2,5,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(38,2,6,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(39,2,7,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(40,2,8,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(41,2,9,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(42,2,10,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(43,2,11,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(44,2,12,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(45,2,13,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(46,2,14,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(47,2,15,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(48,2,16,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(49,2,17,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(50,2,18,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(51,2,19,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(52,2,20,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(53,2,21,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(54,2,22,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(55,2,23,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(56,2,24,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(57,2,25,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(58,2,26,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(59,2,27,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(60,2,28,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(61,2,29,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(62,2,30,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(63,2,31,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(64,2,32,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(65,2,33,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(66,2,34,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(67,2,35,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(68,2,36,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(69,3,5,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(70,3,6,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(71,3,7,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(72,3,8,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(73,3,9,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(74,3,10,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(75,3,11,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(76,3,12,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(77,3,13,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(78,3,14,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(79,3,15,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(80,3,16,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(81,3,17,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(82,3,18,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(83,3,19,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(84,3,32,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(85,4,20,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(86,4,21,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(87,4,22,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(88,4,23,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(89,4,24,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(90,4,25,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(91,4,26,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(92,4,27,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(93,4,28,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(94,4,29,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(95,4,30,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(96,4,31,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(97,4,5,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(98,4,33,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(99,4,35,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(100,5,5,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(101,5,9,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(102,5,13,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(103,5,17,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(104,5,20,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(105,5,24,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(106,5,28,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(107,5,32,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(108,5,33,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(109,5,35,'2026-06-27 06:10:16','2026-06-27 06:10:16'),(110,1,89,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(111,1,90,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(112,1,91,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(113,1,92,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(114,1,93,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(115,1,94,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(116,1,95,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(117,1,96,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(118,1,97,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(119,1,98,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(120,1,99,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(121,1,100,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(122,1,101,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(123,1,102,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(124,1,103,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(125,1,104,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(126,2,91,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(127,2,92,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(128,2,93,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(129,2,94,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(130,2,95,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(131,2,96,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(132,2,97,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(133,2,98,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(134,2,99,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(135,2,100,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(136,2,101,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(137,2,102,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(138,2,103,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(139,2,104,'2026-06-27 06:12:28','2026-06-27 06:12:28'),(140,12,90,'2026-06-27 06:12:28','2026-06-27 06:12:28');
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Role name (slug format)',
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Human-readable role name',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Role description',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Role active status',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  KEY `roles_name_index` (`name`),
  KEY `roles_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super-admin','Super Admin','Memiliki akses penuh ke semua fitur sistem CAREXIS termasuk manajemen user, kepegawaian, inventaris, dan pelaporan',1,'2026-06-02 04:03:11','2026-06-02 04:03:11'),(2,'admin','Admin','Akses ke fitur kepegawaian dan inventaris, tidak bisa mengelola user',1,'2026-06-02 04:03:11','2026-06-02 04:03:11'),(3,'staff-kepegawaian','Staff Kepegawaian','Akses terbatas ke modul kepegawaian (absensi, jadwal, slip gaji)',1,'2026-06-02 04:03:11','2026-06-02 04:03:11'),(4,'staff-inventaris','Staff Inventaris','Akses terbatas ke modul inventaris (data aset, stok barang)',1,'2026-06-02 04:03:11','2026-06-02 04:03:11'),(5,'viewer','Viewer','Hanya bisa melihat data tanpa bisa mengedit atau menghapus',1,'2026-06-02 04:03:11','2026-06-02 04:03:11'),(12,'barber','Barber','Akun untuk barber/pegawai operasional. Hanya bisa melakukan absensi (check-in/check-out) sendiri, tidak memiliki akses ke modul backend lainnya',1,'2026-06-27 06:12:28','2026-06-27 06:12:28');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
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

--
-- Dumping data for table `sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('obic7ym7g69XaVplLPi5LqWw02fZIMzl3WoBmwIz',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnJaaG5lTHRUZHpKUkRCcllTU1lYajJGZW1hSm5jT05JQ3ZieGVlRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iYWNrZW5kL2FrdGl2aXRhcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1783304697),('ZWudmd33OMhWVNsQ0aMfxV8bINewwdCSILvfotRm',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRG5FRkpmQ3BDYkg0c1IyYkdBT21qTmxuQWdZODl2VUhJeVBIMmZobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zdHJ1ay8yNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoiY3VzdG9tZXIiO086MTk6IkFwcFxNb2RlbHNcQ3VzdG9tZXIiOjM2OntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjk6ImN1c3RvbWVycyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEwOntzOjI6ImlkIjtpOjg7czo0OiJuYW1hIjtzOjY6Imhlcm1hbiI7czo1OiJlbWFpbCI7czoxNjoiaGVybWFuQGdtYWlsLmNvbSI7czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEyJFhUQVY4ZFF1S0pqbW8wV1ZxTHBvWk9NNm5vTkRCbGtrbm9qbUYxaUVoQWtXZkpkNmNCZ3FlIjtzOjU6Im5vX2hwIjtzOjExOiIwODEyMzQxMjM0NSI7czo2OiJhbGFtYXQiO3M6MjQ6IkpMIEtvYmVyIEtlY2lsIFJUMDEvUlcwMiI7czo0OiJmb3RvIjtzOjE5OiJjdXN0XzE3ODA5MDE5NjcuanBnIjtzOjk6Imdvb2dsZV9pZCI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI2LTA2LTA4IDEzOjUzOjIxIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI2LTA2LTI2IDE4OjEwOjA2Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTA6e3M6MjoiaWQiO2k6ODtzOjQ6Im5hbWEiO3M6NjoiaGVybWFuIjtzOjU6ImVtYWlsIjtzOjE2OiJoZXJtYW5AZ21haWwuY29tIjtzOjg6InBhc3N3b3JkIjtzOjYwOiIkMnkkMTIkWFRBVjhkUXVLSmptbzBXVnFMcG9aT002bm9OREJsa2tub2ptRjFpRWhBa1dmSmQ2Y0JncWUiO3M6NToibm9faHAiO3M6MTE6IjA4MTIzNDEyMzQ1IjtzOjY6ImFsYW1hdCI7czoyNDoiSkwgS29iZXIgS2VjaWwgUlQwMS9SVzAyIjtzOjQ6ImZvdG8iO3M6MTk6ImN1c3RfMTc4MDkwMTk2Ny5qcGciO3M6OToiZ29vZ2xlX2lkIjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjYtMDYtMDggMTM6NTM6MjEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjYtMDYtMjYgMTg6MTA6MDYiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjExOiIAKgBwcmV2aW91cyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTowOnt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjA6e31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjI3OiIAKgByZWxhdGlvbkF1dG9sb2FkQ2FsbGJhY2siO047czoyNjoiACoAcmVsYXRpb25BdXRvbG9hZENvbnRleHQiO047czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMiO2I6MDtzOjk6IgAqAGhpZGRlbiI7YToxOntpOjA7czo4OiJwYXNzd29yZCI7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjc6e2k6MDtzOjQ6Im5hbWEiO2k6MTtzOjU6ImVtYWlsIjtpOjI7czo4OiJwYXNzd29yZCI7aTozO3M6NToibm9faHAiO2k6NDtzOjY6ImFsYW1hdCI7aTo1O3M6NDoiZm90byI7aTo2O3M6OToiZ29vZ2xlX2lkIjt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoyOiJpZCI7fXM6MTQ6IgAqAGFjY2Vzc1Rva2VuIjtOO3M6MTk6IgAqAGF1dGhQYXNzd29yZE5hbWUiO3M6ODoicGFzc3dvcmQiO3M6MjA6IgAqAHJlbWVtYmVyVG9rZW5OYW1lIjtzOjE0OiJyZW1lbWJlcl90b2tlbiI7fX0=',1782704492);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL COMMENT 'Last successful login timestamp',
  `failed_login_attempts` int NOT NULL DEFAULT '0' COMMENT 'Count of consecutive failed login attempts',
  `account_locked_until` timestamp NULL DEFAULT NULL COMMENT 'Account lockout expiration time',
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Two-factor authentication status',
  `two_factor_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Two-factor authentication secret',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Remember me token',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_last_login_index` (`last_login`),
  KEY `user_account_locked_until_index` (`account_locked_until`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Super Administrator','superadmin@gmail.com','0',1,'$2y$12$vSRTHRte0uoFgchmMwF1zubV0DtPa57J5UfaBzR5IuQcWPqdiiq3.','081234567890',NULL,'2026-06-02 04:03:12','2026-07-06 02:06:50','2026-07-06 02:06:50',0,NULL,0,NULL,NULL),(2,'Administrator','admin@gmail.com','0',1,'$2y$12$DWfIhvDDvyUmzsmoycNzh.i4dN29.jCgxVGWXLsimAw0d3Q.W6vIG','081234567891',NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12',NULL,0,NULL,0,NULL,NULL),(3,'Staff Kepegawaian','staff-kepegawaian@gmail.com','0',1,'$2y$12$asHgczikKWSBWeonQWPRUexkN.CIMYbArwnPaS7KaV6kRimQ/8zgS','081234567892',NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12',NULL,0,NULL,0,NULL,NULL),(4,'Staff Inventaris','staff-inventaris@gmail.com','0',1,'$2y$12$Juf43Ha.oe1sq92no9QuFeXQdKEt/fdwK4kLsmuqALPwylmQruTia','081234567893',NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12',NULL,0,NULL,0,NULL,NULL),(5,'User Viewer','viewer@gmail.com','0',1,'$2y$12$08Ph6PTO2mePpql7YOSl4uwIfSYj0aggOKROS0uZOinHllglHjbh.','081234567894',NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12',NULL,0,NULL,0,NULL,NULL),(6,'Sopian Aji','sopian4ji@gmail.com','0',1,'$2y$12$P9hmOfTu6Mh5ZJ7gDL9gi.OH6jkGfsL3nFqn21DKfM48bLBk/Uc8a','081234567895',NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12',NULL,0,NULL,0,NULL,NULL),(7,'Rizky Maulana','barber1@gmail.com','0',1,'$2y$12$ket0NImGw4Ad47SmZZRZhubu3WpH.Y.YFEe/1XPDuSzC/YVRk0.u2','081234560001',NULL,'2026-06-27 06:12:34','2026-06-27 06:18:21','2026-06-27 06:18:21',0,NULL,0,NULL,NULL),(8,'Doni Saputra','barber2@gmail.com','0',1,'$2y$12$C6ES3PXzmfGUPCF1U5hhUOeEuTuvpHSNhkCo0lBfmMlf/rczxVP/C','081234560002',NULL,'2026-06-27 06:12:34','2026-06-27 06:12:34',NULL,0,NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `assigned_by` bigint unsigned DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When the role was assigned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_role` (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`),
  KEY `user_roles_assigned_by_index` (`assigned_by`),
  CONSTRAINT `user_roles_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1,1,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(2,2,2,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(3,3,3,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(4,4,4,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(5,5,5,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(6,6,5,NULL,'2026-06-02 04:03:12','2026-06-02 04:03:12','2026-06-02 04:03:12'),(7,7,12,NULL,'2026-06-27 06:12:34','2026-06-27 06:12:34','2026-06-27 06:12:34'),(8,8,12,NULL,'2026-06-27 06:12:34','2026-06-27 06:12:34','2026-06-27 06:12:34');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-06 13:02:50
