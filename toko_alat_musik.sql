/*
SQLyog Professional v12.4.3 (64 bit)
MySQL - 10.4.14-MariaDB : Database - toko_alat_musik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`toko_alat_musik` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `toko_alat_musik`;

/*Table structure for table `alat_musik` */

DROP TABLE IF EXISTS `alat_musik`;

CREATE TABLE `alat_musik` (
  `id_alat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(20) DEFAULT NULL,
  `gambar` varchar(30) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `alat_musik` */

insert  into `alat_musik`(`id_alat`,`nama_alat`,`gambar`,`harga`,`stok`) values 
(1,'pianika','pianika.jpg',100000,7),
(2,'gitar','gitar.jpg',750000,15),
(3,'recorder_putih','recorder.jpg',35000,8),
(10,'recorder_pink','recorder2.jpg',50000,7),
(11,'biola','biola.jpg',150000,5),
(12,'triangle','triangle.jpg',35000,10),
(13,'ukulele','ukulele.jpg',80000,9);

/*Table structure for table `pembayaran` */

DROP TABLE IF EXISTS `pembayaran`;

CREATE TABLE `pembayaran` (
  `no_order` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `id_pembeli` int(11) DEFAULT NULL,
  `total_beli` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  PRIMARY KEY (`no_order`),
  KEY `pembayaran_ibfk_1` (`id_pembeli`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=latin1;

/*Data for the table `pembayaran` */

insert  into `pembayaran`(`no_order`,`tanggal`,`id_pembeli`,`total_beli`,`bayar`,`sisa`) values 
(231,'2021-05-07',111,200000,200000,0),
(232,'2021-05-08',112,750000,800000,50000),
(243,'2021-05-08',113,35000,200000,165000),
(248,'2021-05-09',118,100000,100000,0);

/*Table structure for table `pembeli` */

DROP TABLE IF EXISTS `pembeli`;

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL AUTO_INCREMENT,
  `id_alat` int(11) DEFAULT NULL,
  `jumlah_beli` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pembeli`),
  KEY `pembeli_ibfk_1` (`id_alat`),
  CONSTRAINT `pembeli_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alat_musik` (`id_alat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

/*Data for the table `pembeli` */

insert  into `pembeli`(`id_pembeli`,`id_alat`,`jumlah_beli`) values 
(111,1,2),
(112,2,1),
(113,3,1),
(118,1,1),
(119,1,8),
(120,2,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id_user`,`username`,`password`) values 
(1,'sada','$2y$10$.TrcJzYYOIajNwKTF3LfKu18gnvwzRG3tb2TKWnNji2osQCytzNZy'),
(2,'dwi','$2y$10$hqFABROgSwMBMZRk.59kNuKzsU9pGGgNbTfg6UImnD.ewD9E65iA.');

/* Trigger structure for table `pembayaran` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `EditStok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `EditStok` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN
    UPDATE 
	alat_musik
	INNER JOIN pembeli
	ON alat_musik.`id_alat`=pembeli.`id_alat`
	INNER JOIN pembayaran
	ON pembayaran.`id_pembeli`=pembeli.`id_pembeli`
    SET 
	alat_musik.`stok`= alat_musik.`stok`-(SELECT jumlah_beli 
	FROM pembeli INNER JOIN pembayaran
	ON pembeli.`id_pembeli`=pembayaran.`id_pembeli` 
	WHERE pembayaran.`no_order`=new.no_order)
    WHERE pembayaran.`no_order`=new.no_order;

    END */$$


DELIMITER ;

/* Function  structure for function  `BuatNoNota` */

/*!50003 DROP FUNCTION IF EXISTS `BuatNoNota` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `BuatNoNota`(tanggala DATE, nourut CHAR(2)) RETURNS varchar(9) CHARSET utf8mb4
BEGIN
	DECLARE atahun CHAR(2);
	    DECLARE abulan CHAR(2);
	    DECLARE ahari CHAR(2);
	    
	    SELECT TRIM(SUBSTRING(tanggala,3,2)) INTO atahun;
	    SELECT TRIM(SUBSTRING(tanggala,6,2)) INTO abulan;
	    SELECT TRIM(SUBSTRING(tanggala,9,2)) INTO ahari;
	    RETURN CONCAT(atahun,abulan,ahari,'-',nourut); 
    END */$$
DELIMITER ;

/* Function  structure for function  `Pemasukan` */

/*!50003 DROP FUNCTION IF EXISTS `Pemasukan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `Pemasukan`(tanggal date) RETURNS int(9)
BEGIN
	DECLARE total INT(9);
	SELECT
	    SUM(pb.total_beli)
	FROM
	    pembayaran AS pb
	WHERE
	    pb.tanggal = tanggal INTO total;
	RETURN total;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `alat_terlaku` */

/*!50003 DROP PROCEDURE IF EXISTS  `alat_terlaku` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `alat_terlaku`()
BEGIN
	select
	m.`id_alat`, m.`nama_alat`, MAX(db.`jumlah_beli`) AS jumlah
	FROM alat_musik AS m
	INNER JOIN pembeli AS db
	ON db.`id_alat` = m.`id_alat`
	WHERE db.`jumlah_beli` = (SELECT MAX(db.`jumlah_beli`) FROM pembeli AS db)
	GROUP BY m.`id_alat`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `banyak_transaksi` */

/*!50003 DROP PROCEDURE IF EXISTS  `banyak_transaksi` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `banyak_transaksi`()
BEGIN
	SELECT COUNT(no_order) AS Banyak_Transaksi FROM pembayaran;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_alat_musik` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_alat_musik` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_alat_musik`(IdAlat int)
BEGIN
		DELETE FROM alat_musik
		WHERE IdAlat = id_alat;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_pembayaran` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_pembayaran` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_pembayaran`(NoOrder int)
BEGIN
		DELETE FROM pembayaran
		WHERE NoOrder = no_order;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_pembeli` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_pembeli` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_pembeli`(IdPembeli int)
BEGIN
		DELETE FROM pembeli
		WHERE IdPembeli = id_pembeli;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `harga_alat_termahal` */

/*!50003 DROP PROCEDURE IF EXISTS  `harga_alat_termahal` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `harga_alat_termahal`()
BEGIN
SELECT MAX(harga) AS harga_termahal FROM alat_musik 
WHERE harga = harga;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `harga_alat_termurah` */

/*!50003 DROP PROCEDURE IF EXISTS  `harga_alat_termurah` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `harga_alat_termurah`()
BEGIN
	SELECT Min(harga) AS harga_termurah 
	FROM alat_musik 
	WHERE harga= harga;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Hitung_Total_Pembelian` */

/*!50003 DROP PROCEDURE IF EXISTS  `Hitung_Total_Pembelian` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Hitung_Total_Pembelian`()
BEGIN
	START TRANSACTION;
	SELECT
	    SUM(hb.total_beli) as TotalPembelian
	FROM
	    pembayaran AS hb;
	COMMIT; 
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_alat_musik` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_alat_musik` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_alat_musik`(nama_alat VARCHAR(255), gambar VARCHAR(255), harga INT, stok int)
BEGIN
		INSERT INTO alat_musik (nama_alat, gambar, harga, stok) VALUES(nama_alat, gambar, harga, stok);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_pembayaran` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_pembayaran` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_pembayaran`(tanggal date, id_pembeli int, bayar int)
BEGIN
	DECLARE total_beli INT;
	
	SET total_beli = (SELECT (a.harga*p.jumlah_beli)
	FROM alat_musik AS a
	INNER JOIN pembeli AS p
	ON p.id_alat = a. id_alat
	WHERE p.id_pembeli = id_pembeli);
	
	INSERT INTO pembayaran VALUES('' ,tanggal,id_pembeli,total_beli,bayar,(bayar-total_beli));
	
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_pembeli` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_pembeli` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_pembeli`(id_alat int, jumlah_beli int)
BEGIN
		insert into pembeli values('', id_alat, jumlah_beli);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_alat_musik` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_alat_musik` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_alat_musik`(id_alat int, nama_alat varchar(255), gambar varchar(255), harga int, stok int)
BEGIN
		UPDATE alat_musik
		SET id_alat = id_alat, nama_alat = nama_alat, gambar = gambar, harga = harga, stok = stok
		WHERE id_alat = id_alat;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_pembayaran` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_pembayaran` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_pembayaran`(no_order int, tanggal date, id_pembeli int, total_beli int, bayar int, sisa int)
BEGIN
		update pembayaran
		set no_order = no_order, tanggal = tanggal, id_pembeli = id_pembeli, total_beli = total_beli, bayar = bayar, sisa = sisa
		where no_orde = no_order;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_pembeli` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_pembeli` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_pembeli`(id_pembeli int, id_alat int, jumlah_beli int)
BEGIN
		UPDATE pembeli
		SET id_pembeli = id_pembeli, id_alat = id_alat, jumlah_beli = jumlah_beli
		WHERE id_pembeli = id_pembeli;
	END */$$
DELIMITER ;

/*Table structure for table `daftar_alat_musik` */

DROP TABLE IF EXISTS `daftar_alat_musik`;

/*!50001 DROP VIEW IF EXISTS `daftar_alat_musik` */;
/*!50001 DROP TABLE IF EXISTS `daftar_alat_musik` */;

/*!50001 CREATE TABLE  `daftar_alat_musik`(
 `nama_alat` varchar(20) 
)*/;

/*Table structure for table `pemasukan_harian` */

DROP TABLE IF EXISTS `pemasukan_harian`;

/*!50001 DROP VIEW IF EXISTS `pemasukan_harian` */;
/*!50001 DROP TABLE IF EXISTS `pemasukan_harian` */;

/*!50001 CREATE TABLE  `pemasukan_harian`(
 `no_order` int(11) ,
 `tanggal` date ,
 `total_pemasukan` int(11) 
)*/;

/*View structure for view daftar_alat_musik */

/*!50001 DROP TABLE IF EXISTS `daftar_alat_musik` */;
/*!50001 DROP VIEW IF EXISTS `daftar_alat_musik` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftar_alat_musik` AS (select `alat_musik`.`nama_alat` AS `nama_alat` from `alat_musik` group by `alat_musik`.`nama_alat`) */;

/*View structure for view pemasukan_harian */

/*!50001 DROP TABLE IF EXISTS `pemasukan_harian` */;
/*!50001 DROP VIEW IF EXISTS `pemasukan_harian` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pemasukan_harian` AS (select `hb`.`no_order` AS `no_order`,`hb`.`tanggal` AS `tanggal`,`hb`.`total_beli` AS `total_pemasukan` from `pembayaran` `hb` group by `hb`.`tanggal`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
