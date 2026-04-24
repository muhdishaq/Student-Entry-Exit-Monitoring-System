-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table sistem-in-out.pelajar
CREATE TABLE IF NOT EXISTS `pelajar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `no_matrik` varchar(50) DEFAULT NULL,
  `no_ic` varchar(50) DEFAULT NULL,
  `no_bilik` varchar(50) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_tel` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `statuskeluar` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping structure for table sistem-in-out.pengguna
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table sistem-in-out.pengguna: ~3 rows (approximately)
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` (`id`, `nama`, `email`, `role`, `password`) VALUES
	(5, 'admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
	(9, 'warden', 'warden@gmail.com', 'warden', '170e46bf5e0cafab00cac3a650910837'),
	(10, 'guard', 'guard@gmail.com', 'guard', 'df4ad9d5c22ecabca116e2b8dd0c140c'),
	(11, 'ketua jabatan', 'ketuajabatan@gmail.com', 'ketua jabatan', 'f08b1d646a029f0a7eb86af4220cb5d5');
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;

-- Dumping structure for table sistem-in-out.pengesahan_warden
CREATE TABLE IF NOT EXISTS `pengesahan_warden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pengesahan` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Dumping structure for table sistem-in-out.permohonan_status
CREATE TABLE IF NOT EXISTS `permohonan_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(200) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table sistem-in-out.permohonan_status: ~3 rows (approximately)
/*!40000 ALTER TABLE `permohonan_status` DISABLE KEYS */;
INSERT INTO `permohonan_status` (`id`, `status`, `class`) VALUES
	(1, 'Dalam Pengesahan', 'info'),
	(2, 'Disahkan', 'success'),
	(3, 'Tidak disahkan', 'danger');
/*!40000 ALTER TABLE `permohonan_status` ENABLE KEYS */;

-- Dumping data for table sistem-in-out.pengesahan_warden: ~2 rows (approximately)
/*!40000 ALTER TABLE `pengesahan_warden` DISABLE KEYS */;
INSERT INTO `pengesahan_warden` (`id`, `pengesahan`, `class`) VALUES
	(1, 'Dalam Pengesahan', 'info'),
	(2, 'Disahkan', 'success'),
	(3, 'Tidak disahkan', 'danger');
/*!40000 ALTER TABLE `pengesahan_warden` ENABLE KEYS */;



-- Dumping structure for table sistem-in-out.permohonan
CREATE TABLE IF NOT EXISTS `permohonan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajar_id` int(11) DEFAULT NULL,
  `tarikh_permohonan` date DEFAULT NULL,
  `tarikh_keluar` date DEFAULT NULL,
  `tarikh_masuk` date DEFAULT NULL,
  `alasan` text,
  `permohonan_status_id` int(11) DEFAULT '1',
  `pengesahan_oleh` varchar(50) DEFAULT NULL,
  `pengesahan_warden_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pelajar_id` (`pelajar_id`),
  KEY `pengesahan_status_id` (`permohonan_status_id`),
  KEY `pengesahan_warden` (`pengesahan_warden_id`),
  CONSTRAINT `FK_permohonan_pelajar` FOREIGN KEY (`pelajar_id`) REFERENCES `pelajar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_permohonan_pengesahan_warden` FOREIGN KEY (`pengesahan_warden_id`) REFERENCES `pengesahan_warden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_permohonan_permohonan_status` FOREIGN KEY (`permohonan_status_id`) REFERENCES `permohonan_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table sistem-in-out.permohonan: ~1 rows (approximately)
/*!40000 ALTER TABLE `permohonan` DISABLE KEYS */;
/*!40000 ALTER TABLE `permohonan` ENABLE KEYS */;

-- Dumping structure for table sistem-in-out.report
CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajar_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tarikh` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pelajar_id` (`pelajar_id`),
  CONSTRAINT `FK_report_pelajar` FOREIGN KEY (`pelajar_id`) REFERENCES `pelajar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

CREATE TABLE `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `noic` varchar(50) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `pelajar_id` int(11) DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `pelajar_id` (`pelajar_id`),
   CONSTRAINT `FK_pelajar` FOREIGN KEY (`pelajar_id`) REFERENCES `pelajar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sistem-in-out.report: ~16 rows (approximately)
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
/*!40000 ALTER TABLE `report` ENABLE KEYS */;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
