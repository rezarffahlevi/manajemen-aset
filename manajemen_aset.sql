-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table manajemen_aset.material
DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penyimpanan_id` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `spr_id` int DEFAULT NULL,
  `material` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vendor` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.material: ~0 rows (approximately)
REPLACE INTO `material` (`id`, `number`, `brand`, `penyimpanan_id`, `jumlah`, `spr_id`, `material`, `vendor`) VALUES
	(1, '1233221', 'Nokia', 3, 125, NULL, 'nama ku', 'Icon'),
	(2, '123', 'lenovo', 3, 2, 1, 'apa', 'ibm');

-- Dumping structure for table manajemen_aset.penyimpanan
DROP TABLE IF EXISTS `penyimpanan`;
CREATE TABLE IF NOT EXISTS `penyimpanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.penyimpanan: ~2 rows (approximately)
REPLACE INTO `penyimpanan` (`id`, `lokasi`, `keterangan`) VALUES
	(2, 'Laci', 'rak 1'),
	(3, 'Bawah meja', 'Samping sepatu');

-- Dumping structure for table manajemen_aset.rekanan
DROP TABLE IF EXISTS `rekanan`;
CREATE TABLE IF NOT EXISTS `rekanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pic` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.rekanan: ~0 rows (approximately)
REPLACE INTO `rekanan` (`id`, `nama_perusahaan`, `pic`, `email`, `telp`) VALUES
	(2, 'Rekan Saya', 'Saya sendiri', 'rekan@yopmail.com', '08123213213');

-- Dumping structure for table manajemen_aset.reservasi
DROP TABLE IF EXISTS `reservasi`;
CREATE TABLE IF NOT EXISTS `reservasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `material_id` int DEFAULT NULL,
  `tgl_reservasi` date DEFAULT NULL,
  `penyimpanan_id` int DEFAULT NULL,
  `pic` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `lokasi_tujuan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.reservasi: ~0 rows (approximately)
REPLACE INTO `reservasi` (`id`, `material_id`, `tgl_reservasi`, `penyimpanan_id`, `pic`, `jumlah`, `lokasi_tujuan`, `keterangan`, `status`, `created_at`) VALUES
	(1, 2, '2024-11-07', 3, 'yono', 2, 'icon', 'hehhe', 'Disetujui', '2024-11-03 19:24:27');

-- Dumping structure for table manajemen_aset.rma
DROP TABLE IF EXISTS `rma`;
CREATE TABLE IF NOT EXISTS `rma` (
  `id` int NOT NULL,
  `material_id` int DEFAULT NULL,
  `tgl_rma` date DEFAULT NULL,
  `penyimpanan_id` int DEFAULT NULL,
  `pic` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah` int unsigned DEFAULT NULL,
  `lokasi_barang` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.rma: ~0 rows (approximately)
REPLACE INTO `rma` (`id`, `material_id`, `tgl_rma`, `penyimpanan_id`, `pic`, `jumlah`, `lokasi_barang`, `keterangan`, `created_at`) VALUES
	(0, 1, '2024-11-03', 3, 'yono', 122, 'icon', 'asdad', '2024-11-03 20:45:05');

-- Dumping structure for table manajemen_aset.spr
DROP TABLE IF EXISTS `spr`;
CREATE TABLE IF NOT EXISTS `spr` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_spr` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rab` double(10,0) DEFAULT NULL,
  `realisasi` double(10,0) DEFAULT NULL,
  `jenis_anggaran` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `rekanan_id` int DEFAULT NULL,
  `nomor_io` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.spr: ~0 rows (approximately)
REPLACE INTO `spr` (`id`, `judul`, `no_spr`, `rab`, `realisasi`, `jenis_anggaran`, `tgl`, `rekanan_id`, `nomor_io`, `created_at`, `updated_at`) VALUES
	(1, 'SPR-123', 'SPR-123', 12000000, 1100000, 'Capex', '2024-11-04', 2, '9012200', '2024-11-03 19:19:14', '2024-11-03 19:19:14');

-- Dumping structure for table manajemen_aset.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table manajemen_aset.user: ~2 rows (approximately)
REPLACE INTO `user` (`id`, `username`, `password`, `nama`, `level`) VALUES
	(1, 'admin', '6116afedcb0bc31083935c1c262ff4c9', 'Admin Icon+', 'Admin'),
	(3, 'staff', '6116afedcb0bc31083935c1c262ff4c9', 'Staff  P', 'SPV');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
