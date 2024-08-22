-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bungaindah
CREATE DATABASE IF NOT EXISTS `bungaindah` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */;
USE `bungaindah`;

-- Dumping structure for table bungaindah.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `nama_pengirim` varchar(50) DEFAULT NULL,
  `nama_penerima` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nomor_telepon` varchar(50) DEFAULT NULL,
  `alamat` varchar(500) DEFAULT NULL,
  `ekspedisi` varchar(500) DEFAULT NULL,
  `tanggal_order` date DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `total_harga` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_order_user` (`id_user`),
  KEY `FK_order_product` (`id_product`),
  CONSTRAINT `FK_order_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table bungaindah.orders: ~0 rows (approximately)

-- Dumping structure for table bungaindah.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `harga` bigint(20) DEFAULT NULL,
  `deskripsi` varchar(500) DEFAULT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table bungaindah.product: ~6 rows (approximately)
INSERT INTO `product` (`id`, `nama`, `harga`, `deskripsi`, `gambar`, `stok`) VALUES
	(1, 'Buket Pernikahan', 1000000, 'Keindahan dalam genggaman Anda pada hari istimewa. Buket pernikahan kami terdiri dari mawar putih dan pink yang disusun dengan elegan, memberikan sentuhan romantis dan klasik. Setiap bunga dipilih dengan cermat untuk memastikan kesegaran dan kualitas terbaik.\n', 'weeding.jpg', 16),
	(2, 'Buket Wisuda', 500000, 'Rayakan pencapaian besar dengan buket wisuda yang penuh warna dan semangat. Buket ini terdiri dari berbagai macam bunga segar yang dipadukan dengan hiasan boneka wisuda, menjadikannya hadiah sempurna untuk momen berharga ini.\n', 'wisuda.jpeg', 32),
	(3, 'Buket Meja', 200000, 'Tambahkan keindahan pada ruang tamu atau meja kerja Anda dengan buket meja kami. Terdiri dari campuran bunga lili, mawar, dan tanaman hijau, rangkaian ini memberikan sentuhan segar dan elegan pada setiap ruangan.\n', 'table.jpeg', 49),
	(4, 'Buket Besar', 500000, 'Menciptakan kesan mendalam dengan buket besar kami. Rangkaian ini terdiri dari bunga-bunga mewah seperti mawar, anggrek, dan peony yang dipadukan dengan sempurna, ideal untuk perayaan besar dan momen-momen istimewa.\n', 'besar.jpeg', 44),
	(5, 'Buket Sedang', 250000, 'Buket sedang yang dirancang dengan penuh cinta dan perhatian, menampilkan campuran bunga mawar, lili, dan tulip. Cocok untuk berbagai acara seperti ulang tahun, ucapan selamat, atau sekadar menyampaikan kasih sayang.\n', 'sedang.jpg', 38),
	(6, 'Buket Kecil', 100000, 'Hadirkan senyuman dengan buket kecil yang penuh pesona. Buket ini terdiri dari bunga-bunga pilihan seperti mawar mini, aster, dan daun hijau segar, sempurna sebagai hadiah sederhana namun berarti.\r\n', 'kecil.jpg', 51);

-- Dumping structure for table bungaindah.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table bungaindah.user: ~5 rows (approximately)
INSERT INTO `user` (`id`, `nama`, `username`, `email`, `password`, `order`) VALUES
	(0, 'Guest', 'user', NULL, '123', 0),
	(1, 'Budianto', 'budi', 'budi123@gmail.com', '123', 5),
	(2, 'Lutfi Firmansyah', 'pi', 'lutfi3522@gmail.com', '123', 9),
	(3, 'Fahri ', 'Apah', 'apah123@gmail.com', '123', 1),
	(5, 'Sulistiana', 'sulis', 'sulis@gmail.com', '123', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
