/*
SQLyog Enterprise v13.1.1 (32 bit)
MySQL - 10.4.10-MariaDB : Database - u5982481_laravel_spp2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `angkatans` */

DROP TABLE IF EXISTS `angkatans`;

CREATE TABLE `angkatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `angkatan` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('X','XI','XII','ALUMNI') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `expenses` */

DROP TABLE IF EXISTS `expenses`;

CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('Sekolah','Yayasan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `financing_categories` */

DROP TABLE IF EXISTS `financing_categories`;

CREATE TABLE `financing_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `besaran` int(11) NOT NULL,
  `jenis` enum('Bayar per Bulan','Sekali Bayar','Khusus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `financing_category_resets` */

DROP TABLE IF EXISTS `financing_category_resets`;

CREATE TABLE `financing_category_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `financing_category_id` int(11) NOT NULL,
  `besaran` int(11) NOT NULL,
  `jenis` enum('Bayar per Bulan','Sekali Bayar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `incomes` */

DROP TABLE IF EXISTS `incomes`;

CREATE TABLE `incomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('Sekolah','Yayasan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `majors` */

DROP TABLE IF EXISTS `majors`;

CREATE TABLE `majors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `payment_details` */

DROP TABLE IF EXISTS `payment_details`;

CREATE TABLE `payment_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_dibayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `status` enum('Lunas','Nunggak','Waiting') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `payment_periode_details` */

DROP TABLE IF EXISTS `payment_periode_details`;

CREATE TABLE `payment_periode_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_periode_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `bulan` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Lunas','Nunggak','Waiting') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1549 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `payment_periodes` */

DROP TABLE IF EXISTS `payment_periodes`;

CREATE TABLE `payment_periodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `financing_category_id` int(11) NOT NULL,
  `angkatan_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `financing_category_id` int(11) NOT NULL,
  `persentase` double(8,2) NOT NULL,
  `jenis_pembayaran` enum('Tunai','Cicilan','Waiting','Nunggak','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pencatatans` */

DROP TABLE IF EXISTS `pencatatans`;

CREATE TABLE `pencatatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_id` bigint(20) NOT NULL,
  `expense_id` bigint(20) NOT NULL,
  `debit` bigint(20) NOT NULL,
  `kredit` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `students` */

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nis` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` enum('X','XI','XII') COLLATE utf8mb4_unicode_ci NOT NULL,
  `major_id` int(11) NOT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_masuk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Sekolah','Yayasan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* Trigger structure for table `financing_categories` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `financing_categories_delete` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `financing_categories_delete` AFTER DELETE ON `financing_categories` FOR EACH ROW BEGIN
DELETE FROM financing_category_resets WHERE financing_category_resets.financing_category_id = old.id;
DELETE FROM payments WHERE payments.financing_category_id= old.id;
DELETE FROM payment_periodes where payment_periodes.financing_category_id = old.id; 
END */$$


DELIMITER ;

/* Trigger structure for table `payments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `payments_delete` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `payments_delete` AFTER DELETE ON `payments` FOR EACH ROW BEGIN
DELETE FROM payment_details WHERE payment_details.payment_id = old.id;
DELETE FROM payment_periode_details WHERE payment_periode_details.payment_id = old.id;
END */$$


DELIMITER ;

/* Function  structure for function  `getAkumulasiPerBulan` */

/*!50003 DROP FUNCTION IF EXISTS `getAkumulasiPerBulan` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getAkumulasiPerBulan`(`id` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT SUM(pd.`nominal`) into v FROM payment_periode_details ppd
JOIN payment_periodes pd ON ppd.`payment_periode_id`=pd.id
WHERE payment_id=id;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getAkumulasiSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getAkumulasiSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getAkumulasiSpp`(`siswa` INT) RETURNS int(11)
BEGIN
declare v int;
SELECT SUM(ps.nominal) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE s.id=siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getBanyakTunggakanSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getBanyakTunggakanSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getBanyakTunggakanSpp`(`siswa` INT) RETURNS int(11)
BEGIN
    declare v int;
SELECT COUNT(*) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE ps.status = "Nunggak" AND s.id=siswa;
return v;    
    END */$$
DELIMITER ;

/* Function  structure for function  `getBesaranBiayaKategoriPembiayaan` */

/*!50003 DROP FUNCTION IF EXISTS `getBesaranBiayaKategoriPembiayaan` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getBesaranBiayaKategoriPembiayaan`(`param` INT) RETURNS int(11)
BEGIN
	SET @val='';
	select besaran into @val from financing_categories
	where id=param;
	return @val;
    END */$$
DELIMITER ;

/* Function  structure for function  `getBesaranBiayaTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getBesaranBiayaTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getBesaranBiayaTerbayar`(`id_siswa` INT, `id_kategori` INT) RETURNS int(11)
BEGIN
	set @val='';
	select sum(nominal) into @val from payment_details pd
	join payments p on p.id = pd.payment_id
	join students s on s.id = p.student_id
	where
	s.id = id_siswa and
	p.financing_category_id = id_kategori;
	return @val;
    END */$$
DELIMITER ;

/* Function  structure for function  `getBulanTidakTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getBulanTidakTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getBulanTidakTerbayar`(`payment_id` INT) RETURNS int(11)
BEGIN
    declare v int default 0;
	SELECT COUNT(*) into v FROM payment_periode_details ppd
WHERE ppd.payment_id = payment_id AND STATUS != "Lunas";
	return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountBulananTidakTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getCountBulananTidakTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountBulananTidakTerbayar`(`id` INT) RETURNS int(11)
BEGIN
	declare v int;
	SELECT COUNT(*) into v FROM payment_periode_details ppd WHERE STATUS="Nunggak" AND payment_id=id;
	return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountDetailBulanan` */

/*!50003 DROP FUNCTION IF EXISTS `getCountDetailBulanan` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountDetailBulanan`(`pay_id` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(*) into v FROM payment_periode_details
WHERE payment_id=pay_id;
	return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountLunasSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getCountLunasSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountLunasSpp`(`siswa` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(*) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE ps.status = "Lunas" AND s.id=siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountNunggak` */

/*!50003 DROP FUNCTION IF EXISTS `getCountNunggak` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountNunggak`(`pay_id` INT) RETURNS int(11)
BEGIN
    DECLARE v INT;
    SELECT COUNT(STATUS) into v FROM payment_periode_details
WHERE STATUS = "Nunggak" AND payment_id=pay_id;
RETURN v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountNunggakPeriodeUseKategori` */

/*!50003 DROP FUNCTION IF EXISTS `getCountNunggakPeriodeUseKategori` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountNunggakPeriodeUseKategori`(`id` INT) RETURNS int(11)
BEGIN
    declare v int;
	SELECT COUNT(STATUS) INTO v FROM payment_periode_details ppd
    JOIN payments p ON p.id = ppd.payment_id
    join financing_categories fc on fc.id = p.financing_category_id
WHERE ppd.status = "Nunggak" AND fc.id=id;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountWaiting` */

/*!50003 DROP FUNCTION IF EXISTS `getCountWaiting` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountWaiting`(`pay_id` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(STATUS) into v FROM payment_periode_details
WHERE STATUS = "Waiting" AND payment_id=pay_id;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getCountWaitingSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getCountWaitingSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getCountWaitingSpp`(`siswa` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(*) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE ps.status = "Waiting" AND s.id=siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getJumlahNunggak` */

/*!50003 DROP FUNCTION IF EXISTS `getJumlahNunggak` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getJumlahNunggak`() RETURNS int(11)
BEGIN
    declare v,s int;
	SELECT COUNT(STATUS) into v FROM payment_periode_details
WHERE STATUS = "Nunggak";
SELECT COUNT(*) into s FROM  payments p 
WHERE p.`jenis_pembayaran`="Nunggak"
AND p.id NOT IN (
	SELECT payment_id FROM payment_periode_details GROUP BY payment_id
);
	set v = v + s;
	return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getJumlahPeriodePembayaran` */

/*!50003 DROP FUNCTION IF EXISTS `getJumlahPeriodePembayaran` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getJumlahPeriodePembayaran`(`id` INT) RETURNS int(11)
BEGIN
    set @val='';
    select count(*) into @val FROM payment_periodes WHERE financing_category_id=id;
return @val;
    END */$$
DELIMITER ;

/* Function  structure for function  `getJumlahPeriodeTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getJumlahPeriodeTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getJumlahPeriodeTerbayar`(`id_siswa` INT, `id_kategori` INT) RETURNS int(11)
BEGIN
    set @v='';
	SELECT COUNT(*) into @v FROM payment_periodes ps
    JOIN payment_periode_students pps ON pps.`payment_periode_id`=ps.`id`
    JOIN students s ON s.`id` = pps.`student_id`    
    WHERE ps.financing_category_id=id_kategori
    AND s.`id`=id_siswa;
    return @v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getJumlahSiswa` */

/*!50003 DROP FUNCTION IF EXISTS `getJumlahSiswa` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getJumlahSiswa`() RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(*) into v FROM students;
    return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getJumlahTunggakanKategori` */

/*!50003 DROP FUNCTION IF EXISTS `getJumlahTunggakanKategori` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getJumlahTunggakanKategori`(`id` INT) RETURNS int(11)
BEGIN
    declare v int;
    SELECT COUNT(*) into v FROM payments p
JOIN financing_categories fc ON fc.`id`=p.`financing_category_id`
WHERE jenis_pembayaran = "Nunggak" AND fc.`id`=id;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getNominalPembayaranBulanan` */

/*!50003 DROP FUNCTION IF EXISTS `getNominalPembayaranBulanan` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getNominalPembayaranBulanan`(`id` INT) RETURNS int(11)
BEGIN
    set @v='';
    SELECT SUM(nominal) into @v FROM payment_periodes ps 
WHERE ps.`financing_category_id`=id;
return @v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getNominalSekaliBayarTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getNominalSekaliBayarTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getNominalSekaliBayarTerbayar`(`id_siswa` INT, `id_kategori` INT) RETURNS int(11)
BEGIN
	declare v int default 0;
	SELECT SUM(nominal) into v FROM payment_details pd
JOIN payments p ON p.`id`=pd.`payment_id`
WHERE p.`financing_category_id`=id_kategori
AND p.`student_id`=id_siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getNominalTerbayar` */

/*!50003 DROP FUNCTION IF EXISTS `getNominalTerbayar` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getNominalTerbayar`(`id_pay` INT, `id_kategori` INT) RETURNS int(11)
BEGIN
	declare v, s, c int;
	SELECT COUNT(STATUS) into v FROM payment_periode_details
	WHERE STATUS = "Lunas" AND payment_id=id_pay;
	select besaran into s from financing_categories
	where id = id_kategori;
	return v*s;
return @v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getNominalTerbayarBulanan` */

/*!50003 DROP FUNCTION IF EXISTS `getNominalTerbayarBulanan` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getNominalTerbayarBulanan`(`id_pay` INT) RETURNS int(11)
BEGIN
	declare v int;
	SELECT SUM(nominal) into v FROM payment_periodes pp
JOIN payment_periode_details ppd ON ppd.`payment_periode_id`=pp.`id`
WHERE STATUS = "Lunas" and ppd.`payment_id`=id_pay;
	return v;
return @v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getTerbayarSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getTerbayarSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getTerbayarSpp`(`siswa` INT) RETURNS int(11)
BEGIN
    declare v int;
	SELECT SUM(ps.nominal) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE ps.status = "Lunas" AND s.id=siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `getTunggakanSpp` */

/*!50003 DROP FUNCTION IF EXISTS `getTunggakanSpp` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `getTunggakanSpp`(`siswa` INT) RETURNS int(11)
BEGIN
declare v int;
SELECT SUM(ps.nominal) into v FROM pembayaran_spp ps
JOIN students s ON s.id = ps.student_id
WHERE ps.status = "Nunggak" AND s.id=siswa;
return v;
    END */$$
DELIMITER ;

/* Function  structure for function  `paid_once` */

/*!50003 DROP FUNCTION IF EXISTS `paid_once` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `paid_once`(`id` INT) RETURNS int(11)
BEGIN
	declare v int;
	SELECT SUM(nominal) into v FROM payment_details WHERE payment_id=id;
	return v;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `getPenghitunganPerBulan` */

/*!50003 DROP PROCEDURE IF EXISTS  `getPenghitunganPerBulan` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `getPenghitunganPerBulan`(`id_siswa` INT, `id_kategori` INT)
BEGIN
		SELECT `getJumlahPeriodeTerbayar`(id_siswa,id_kategori) AS terbayar, 
		`getJumlahPeriodePembayaran`(id_kategori) AS total, 
		`getNominalPembayaran`(id_kategori) AS nominalPembayaran, 
		`getNominalTerbayar`(id_siswa,id_kategori) AS nominalTerbayar;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `pilihKategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `pilihKategori` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `pilihKategori`(`id` INT)
BEGIN
		SELECT fc.*, p.`jenis_pembayaran` FROM financing_categories fc
LEFT OUTER JOIN payments p ON p.`financing_category_id`=fc.`id` 
WHERE p.student_id IS NULL OR p.`student_id`=id
ORDER BY fc.id;
	END */$$
DELIMITER ;

/*Table structure for table `dashboard_view` */

DROP TABLE IF EXISTS `dashboard_view`;

/*!50001 DROP VIEW IF EXISTS `dashboard_view` */;
/*!50001 DROP TABLE IF EXISTS `dashboard_view` */;

/*!50001 CREATE TABLE  `dashboard_view`(
 `pemasukan` decimal(41,0) ,
 `pengeluaran` decimal(41,0) ,
 `siswa` int(11) ,
 `nunggak` int(11) 
)*/;

/*Table structure for table `dashboard_view_2` */

DROP TABLE IF EXISTS `dashboard_view_2`;

/*!50001 DROP VIEW IF EXISTS `dashboard_view_2` */;
/*!50001 DROP TABLE IF EXISTS `dashboard_view_2` */;

/*!50001 CREATE TABLE  `dashboard_view_2`(
 `pemasukan` decimal(41,0) ,
 `pengeluaran` decimal(41,0) ,
 `siswa` int(11) ,
 `nunggak` int(11) 
)*/;

/*Table structure for table `payment_views` */

DROP TABLE IF EXISTS `payment_views`;

/*!50001 DROP VIEW IF EXISTS `payment_views` */;
/*!50001 DROP TABLE IF EXISTS `payment_views` */;

/*!50001 CREATE TABLE  `payment_views`(
 `idSiswa` bigint(20) unsigned ,
 `idPembayaran` bigint(20) unsigned ,
 `idDetail` bigint(20) unsigned ,
 `idKategori` bigint(20) unsigned ,
 `nis` varchar(15) ,
 `nama` varchar(255) ,
 `kelas` enum('X','XI','XII') ,
 `jurusan` varchar(255) ,
 `penerima` varchar(255) ,
 `status` enum('Lunas','Nunggak','Waiting') ,
 `kategori` varchar(255) ,
 `jenis_kategori_pembayaran` enum('Bayar per Bulan','Sekali Bayar','Khusus') ,
 `jenis_pembayaran` enum('Tunai','Cicilan','Waiting','Nunggak','Lunas') ,
 `biaya` int(11) ,
 `terbayar` int(11) ,
 `nominal` int(11) 
)*/;

/*Table structure for table `rekap_view` */

DROP TABLE IF EXISTS `rekap_view`;

/*!50001 DROP VIEW IF EXISTS `rekap_view` */;
/*!50001 DROP TABLE IF EXISTS `rekap_view` */;

/*!50001 CREATE TABLE  `rekap_view`(
 `saldo` decimal(42,0) ,
 `pemasukan` decimal(41,0) ,
 `pengeluaran` decimal(41,0) ,
 `tunggakan` decimal(33,0) 
)*/;

/*Table structure for table `tunggakan_sekali_report_view` */

DROP TABLE IF EXISTS `tunggakan_sekali_report_view`;

/*!50001 DROP VIEW IF EXISTS `tunggakan_sekali_report_view` */;
/*!50001 DROP TABLE IF EXISTS `tunggakan_sekali_report_view` */;

/*!50001 CREATE TABLE  `tunggakan_sekali_report_view`(
 `nama` varchar(255) ,
 `kelas` enum('X','XI','XII') ,
 `jurusan` varchar(255) ,
 `akumulasi` int(11) ,
 `terbayar` decimal(32,0) ,
 `metode` varchar(7) 
)*/;

/*Table structure for table `view_detail_once` */

DROP TABLE IF EXISTS `view_detail_once`;

/*!50001 DROP VIEW IF EXISTS `view_detail_once` */;
/*!50001 DROP TABLE IF EXISTS `view_detail_once` */;

/*!50001 CREATE TABLE  `view_detail_once`(
 `id` bigint(20) unsigned ,
 `nis` varchar(15) ,
 `nama` varchar(255) ,
 `jenis_kelamin` enum('L','P') ,
 `kelas` enum('X','XI','XII') ,
 `major_id` int(11) ,
 `phone` varchar(14) ,
 `email` varchar(255) ,
 `tgl_masuk` varchar(255) ,
 `created_at` timestamp ,
 `updated_at` timestamp ,
 `akumulasi` int(11) ,
 `financing_nama` varchar(255) ,
 `terbayar` int(11) ,
 `financing_id` bigint(20) unsigned ,
 `payment_id` bigint(20) unsigned ,
 `jenis_pembayaran` enum('Tunai','Cicilan','Waiting','Nunggak','Lunas') 
)*/;

/*Table structure for table `view_detail_once_2` */

DROP TABLE IF EXISTS `view_detail_once_2`;

/*!50001 DROP VIEW IF EXISTS `view_detail_once_2` */;
/*!50001 DROP TABLE IF EXISTS `view_detail_once_2` */;

/*!50001 CREATE TABLE  `view_detail_once_2`(
 `id` bigint(20) unsigned ,
 `nis` varchar(15) ,
 `nama` varchar(255) ,
 `jenis_kelamin` enum('L','P') ,
 `kelas` enum('X','XI','XII') ,
 `major_id` int(11) ,
 `phone` varchar(14) ,
 `email` varchar(255) ,
 `tgl_masuk` varchar(255) ,
 `created_at` timestamp ,
 `updated_at` timestamp ,
 `akumulasi` int(11) ,
 `financing_nama` varchar(255) ,
 `terbayar` int(11) ,
 `financing_id` bigint(20) unsigned ,
 `payment_id` bigint(20) unsigned ,
 `jenis_pembayaran` enum('Tunai','Cicilan','Waiting','Nunggak','Lunas') 
)*/;

/*View structure for view dashboard_view */

/*!50001 DROP TABLE IF EXISTS `dashboard_view` */;
/*!50001 DROP VIEW IF EXISTS `dashboard_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `dashboard_view` AS select sum(`pencatatans`.`debit`) AS `pemasukan`,sum(`pencatatans`.`kredit`) AS `pengeluaran`,`getJumlahSiswa`() AS `siswa`,`getJumlahNunggak`() AS `nunggak` from `pencatatans` */;

/*View structure for view dashboard_view_2 */

/*!50001 DROP TABLE IF EXISTS `dashboard_view_2` */;
/*!50001 DROP VIEW IF EXISTS `dashboard_view_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `dashboard_view_2` AS select sum(`pencatatans`.`debit`) AS `pemasukan`,sum(`pencatatans`.`kredit`) AS `pengeluaran`,`getJumlahSiswa`() AS `siswa`,`getJumlahNunggak`() AS `nunggak` from `pencatatans` */;

/*View structure for view payment_views */

/*!50001 DROP TABLE IF EXISTS `payment_views` */;
/*!50001 DROP VIEW IF EXISTS `payment_views` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `payment_views` AS select `s`.`id` AS `idSiswa`,`p`.`id` AS `idPembayaran`,`pd`.`id` AS `idDetail`,`fc`.`id` AS `idKategori`,`s`.`nis` AS `nis`,`s`.`nama` AS `nama`,`s`.`kelas` AS `kelas`,`m`.`nama` AS `jurusan`,`u`.`name` AS `penerima`,`pd`.`status` AS `status`,`fc`.`nama` AS `kategori`,`fc`.`jenis` AS `jenis_kategori_pembayaran`,`p`.`jenis_pembayaran` AS `jenis_pembayaran`,`getBesaranBiayaKategoriPembiayaan`(`p`.`financing_category_id`) AS `biaya`,`getBesaranBiayaTerbayar`(`s`.`id`,`p`.`financing_category_id`) AS `terbayar`,`pd`.`nominal` AS `nominal` from (((((`payment_details` `pd` join `payments` `p` on(`pd`.`payment_id` = `p`.`id`)) join `students` `s` on(`s`.`id` = `p`.`student_id`)) join `majors` `m` on(`m`.`id` = `s`.`major_id`)) join `users` `u` on(`u`.`id` = `pd`.`user_id`)) join `financing_categories` `fc` on(`p`.`financing_category_id` = `fc`.`id`)) */;

/*View structure for view rekap_view */

/*!50001 DROP TABLE IF EXISTS `rekap_view` */;
/*!50001 DROP VIEW IF EXISTS `rekap_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `rekap_view` AS select sum(`pencatatans`.`debit`) - sum(`pencatatans`.`kredit`) AS `saldo`,sum(`pencatatans`.`debit`) AS `pemasukan`,sum(`pencatatans`.`kredit`) AS `pengeluaran`,(select sum(`fc`.`besaran`) + (select sum(`payment_details`.`nominal`) from `payment_details` where `payment_details`.`status` = 'Nunggak') from ((`payment_periode_details` `ppd` join `payment_periodes` `pp` on(`pp`.`id` = `ppd`.`payment_periode_id`)) join `financing_categories` `fc` on(`fc`.`id` = `pp`.`financing_category_id`)) where `ppd`.`status` = 'Nunggak') AS `tunggakan` from `pencatatans` */;

/*View structure for view tunggakan_sekali_report_view */

/*!50001 DROP TABLE IF EXISTS `tunggakan_sekali_report_view` */;
/*!50001 DROP VIEW IF EXISTS `tunggakan_sekali_report_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `tunggakan_sekali_report_view` AS select `s`.`nama` AS `nama`,`s`.`kelas` AS `kelas`,`m`.`nama` AS `jurusan`,`fc`.`besaran` AS `akumulasi`,(select sum(`pd2`.`nominal`) from `payment_details` `pd2` where `pd2`.`id` = `pd`.`id`) AS `terbayar`,(select `p2`.`jenis_pembayaran` from `payments` `p2` where `p2`.`id` = `p`.`id`) AS `metode` from ((((`students` `s` join `majors` `m` on(`m`.`id` = `s`.`major_id`)) join `payments` `p` on(`p`.`student_id` = `s`.`id`)) join `financing_categories` `fc` on(`fc`.`id` = `p`.`financing_category_id`)) join `payment_details` `pd` on(`pd`.`payment_id` = `p`.`id`)) */;

/*View structure for view view_detail_once */

/*!50001 DROP TABLE IF EXISTS `view_detail_once` */;
/*!50001 DROP VIEW IF EXISTS `view_detail_once` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_once` AS select `s`.`id` AS `id`,`s`.`nis` AS `nis`,`s`.`nama` AS `nama`,`s`.`jenis_kelamin` AS `jenis_kelamin`,`s`.`kelas` AS `kelas`,`s`.`major_id` AS `major_id`,`s`.`phone` AS `phone`,`s`.`email` AS `email`,`s`.`tgl_masuk` AS `tgl_masuk`,`s`.`created_at` AS `created_at`,`s`.`updated_at` AS `updated_at`,`fc`.`besaran` AS `akumulasi`,`fc`.`nama` AS `financing_nama`,`paid_once`(`p`.`id`) AS `terbayar`,`fc`.`id` AS `financing_id`,`p`.`id` AS `payment_id`,`p`.`jenis_pembayaran` AS `jenis_pembayaran` from (((`students` `s` left join `payments` `p` on(`s`.`id` = `p`.`student_id`)) left join `financing_categories` `fc` on(`fc`.`id` = `p`.`financing_category_id`)) left join `payment_details` `pd` on(`pd`.`payment_id` = `p`.`id`)) group by `s`.`id` */;

/*View structure for view view_detail_once_2 */

/*!50001 DROP TABLE IF EXISTS `view_detail_once_2` */;
/*!50001 DROP VIEW IF EXISTS `view_detail_once_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_once_2` AS select `s`.`id` AS `id`,`s`.`nis` AS `nis`,`s`.`nama` AS `nama`,`s`.`jenis_kelamin` AS `jenis_kelamin`,`s`.`kelas` AS `kelas`,`s`.`major_id` AS `major_id`,`s`.`phone` AS `phone`,`s`.`email` AS `email`,`s`.`tgl_masuk` AS `tgl_masuk`,`s`.`created_at` AS `created_at`,`s`.`updated_at` AS `updated_at`,`fc`.`besaran` AS `akumulasi`,`fc`.`nama` AS `financing_nama`,`paid_once`(`p`.`id`) AS `terbayar`,`fc`.`id` AS `financing_id`,`p`.`id` AS `payment_id`,`p`.`jenis_pembayaran` AS `jenis_pembayaran` from (((`students` `s` left join `payments` `p` on(`s`.`id` = `p`.`student_id`)) left join `financing_categories` `fc` on(`fc`.`id` = `p`.`financing_category_id`)) left join `payment_details` `pd` on(`pd`.`payment_id` = `p`.`id`)) group by `s`.`id` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
