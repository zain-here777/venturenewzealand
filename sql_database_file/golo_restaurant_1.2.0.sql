# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.0.38-MariaDB)
# Database: golo_restaurant
# Generation Time: 2020-12-25 08:18:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table amenities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `amenities`;

CREATE TABLE `amenities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `amenities` WRITE;
/*!40000 ALTER TABLE `amenities` DISABLE KEYS */;

INSERT INTO `amenities` (`id`, `name`, `icon`, `created_at`, `updated_at`)
VALUES
	(6,'Free wifi','5ec945585e339_1590248792.svg','2019-11-02 16:02:01','2020-05-23 15:46:32'),
	(7,'Reservations','5ec9454c66eeb_1590248780.svg','2019-11-04 14:37:01','2020-05-23 15:46:20'),
	(8,'Credit cards','5ec945370f42c_1590248759.svg','2019-11-04 14:37:19','2020-05-23 15:45:59'),
	(9,'Non smoking','5ec9452c1891b_1590248748.svg','2019-11-04 14:40:22','2020-05-23 15:45:48'),
	(10,'Air conditioner','5ec945216511a_1590248737.svg','2019-11-04 16:21:12','2020-05-23 15:45:37'),
	(11,'Car parking','5ec9450aa2a48_1590248714.svg','2019-11-04 16:24:54','2020-05-23 15:45:14'),
	(13,'Cocktails','5ec944e5479b4_1590248677.svg','2019-11-04 16:33:05','2020-05-23 15:44:37');

/*!40000 ALTER TABLE `amenities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table amenities_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `amenities_translations`;

CREATE TABLE `amenities_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amenities_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `amenities_translations_amenities_id_locale_unique` (`amenities_id`,`locale`),
  KEY `amenities_translations_locale_index` (`locale`),
  CONSTRAINT `amenities_translations_amenities_id_foreign` FOREIGN KEY (`amenities_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `amenities_translations` WRITE;
/*!40000 ALTER TABLE `amenities_translations` DISABLE KEYS */;

INSERT INTO `amenities_translations` (`id`, `amenities_id`, `locale`, `name`)
VALUES
	(1,6,'en','Free wifi'),
	(2,7,'en','Reservations'),
	(3,8,'en','Credit cards'),
	(4,9,'en','Non smoking'),
	(5,10,'en','Air conditioner'),
	(6,11,'en','Car parking'),
	(8,13,'en','Cocktails');

/*!40000 ALTER TABLE `amenities_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bookings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `numbber_of_adult` int(11) DEFAULT NULL,
  `numbber_of_children` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `name` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `status` int(2) DEFAULT '2' COMMENT 'status default pending: 2',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;

INSERT INTO `bookings` (`id`, `user_id`, `place_id`, `numbber_of_adult`, `numbber_of_children`, `date`, `time`, `name`, `email`, `phone_number`, `message`, `type`, `status`, `created_at`, `updated_at`)
VALUES
	(60,8,19,1,1,'2020-02-11','01:00:00','',NULL,NULL,NULL,1,1,'2020-02-10 08:04:16','2020-02-10 08:34:42'),
	(61,8,18,NULL,NULL,NULL,NULL,'Kevin','kevin@uxper.co','+81337120819','Hello, I need a book',2,0,'2020-02-10 08:07:52','2020-02-13 03:48:21'),
	(63,8,41,1,1,'2020-02-16','01:30:00','',NULL,NULL,NULL,1,2,'2020-02-15 08:00:37','2020-02-15 08:00:37'),
	(65,13,19,1,1,'2020-02-16','01:30:00','',NULL,NULL,NULL,1,2,'2020-02-15 11:15:23','2020-02-15 11:15:23'),
	(66,13,19,1,1,'2020-02-16','01:30:00','',NULL,NULL,NULL,1,2,'2020-02-15 11:17:32','2020-02-15 11:17:32'),
	(67,13,19,1,1,'2020-02-21','01:00:00','',NULL,NULL,NULL,1,2,'2020-02-15 11:18:26','2020-02-15 11:18:26'),
	(68,13,19,1,1,'2020-02-21','01:00:00','',NULL,NULL,NULL,1,2,'2020-02-15 11:18:29','2020-02-15 11:18:29'),
	(73,8,41,1,0,'2020-02-16','12:30:00','',NULL,NULL,NULL,1,2,'2020-02-15 11:28:30','2020-02-15 11:28:30'),
	(74,8,19,1,0,'2020-02-15','12:30:00','',NULL,NULL,NULL,1,1,'2020-02-15 16:34:02','2020-02-16 08:13:43'),
	(75,8,19,1,0,'2020-02-15','12:30:00','',NULL,NULL,NULL,1,1,'2020-02-15 16:35:38','2020-02-16 04:10:46'),
	(76,8,36,2,2,'2020-05-29','01:30:00','',NULL,NULL,NULL,1,2,'2020-05-24 09:23:56','2020-05-24 09:23:56'),
	(77,8,38,1,1,'2020-06-19','01:00:00','',NULL,NULL,NULL,1,2,'2020-06-18 03:53:24','2020-06-18 03:53:24'),
	(78,8,19,1,1,'2020-06-19','01:30:00','',NULL,NULL,NULL,1,2,'2020-06-18 14:55:21','2020-06-18 14:55:21'),
	(79,8,19,1,1,'2020-06-20','01:00:00','',NULL,NULL,NULL,1,2,'2020-06-19 15:16:01','2020-06-19 15:16:01'),
	(80,8,19,1,1,'2020-06-25','01:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 07:36:13','2020-06-24 07:36:13'),
	(81,20,37,1,0,'2020-06-30','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 07:50:39','2020-06-24 07:50:39'),
	(82,20,37,1,0,'2020-07-02','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 07:50:57','2020-06-24 07:50:57'),
	(83,22,19,2,1,'2020-06-26','09:00:00','',NULL,NULL,NULL,1,2,'2020-06-24 09:15:41','2020-06-24 09:15:41'),
	(84,23,19,1,0,'2020-06-25','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 14:06:38','2020-06-24 14:06:38'),
	(85,23,19,1,0,'2020-06-26','04:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 14:06:56','2020-06-24 14:06:56'),
	(86,23,19,2,0,'2020-07-03','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 14:07:51','2020-06-24 14:07:51'),
	(87,23,19,2,0,'2020-07-03','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 14:09:35','2020-06-24 14:09:35'),
	(88,23,37,2,0,'2020-07-01','01:30:00','',NULL,NULL,NULL,1,2,'2020-06-24 14:10:39','2020-06-24 14:10:39'),
	(89,32,19,1,1,'2020-06-26','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-26 06:54:53','2020-06-26 06:54:53'),
	(90,32,19,1,1,'2020-06-26','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-26 06:55:06','2020-06-26 06:55:06'),
	(91,36,19,4,2,'2020-06-27','09:00:00','',NULL,NULL,NULL,1,2,'2020-06-27 02:32:54','2020-06-27 02:32:54'),
	(92,36,36,1,0,'2020-06-27','03:00:00','',NULL,NULL,NULL,1,2,'2020-06-27 02:34:00','2020-06-27 02:34:00'),
	(93,40,37,1,2,'2020-06-04','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-28 18:14:13','2020-06-28 18:14:13'),
	(94,41,44,1,0,'2020-06-23','01:00:00','',NULL,NULL,NULL,1,2,'2020-06-29 17:39:42','2020-06-29 17:39:42'),
	(95,42,19,2,0,'2020-06-22','12:00:00','',NULL,NULL,NULL,1,2,'2020-06-29 20:25:48','2020-06-29 20:25:48'),
	(96,43,19,1,0,'2020-06-24','01:00:00','',NULL,NULL,NULL,1,2,'2020-06-30 00:13:05','2020-06-30 00:13:05'),
	(97,43,19,1,0,'2020-07-08','01:00:00','',NULL,NULL,NULL,1,2,'2020-06-30 00:13:29','2020-06-30 00:13:29'),
	(98,43,36,2,0,'2020-07-01','09:30:00','',NULL,NULL,NULL,1,2,'2020-06-30 00:14:13','2020-06-30 00:14:13'),
	(99,42,45,1,0,'2020-07-01','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-30 13:00:07','2020-06-30 13:00:07'),
	(100,45,19,2,0,'2020-07-01','12:30:00','',NULL,NULL,NULL,1,2,'2020-06-30 20:08:17','2020-06-30 20:08:17'),
	(101,NULL,46,NULL,NULL,NULL,NULL,'admin','admin@mailinator.com',NULL,NULL,2,2,'2020-07-01 03:31:36','2020-07-01 03:31:36'),
	(102,NULL,46,NULL,NULL,NULL,NULL,'admin','admin@mailinator.com',NULL,NULL,2,2,'2020-07-01 03:35:37','2020-07-01 03:35:37'),
	(103,NULL,46,NULL,NULL,NULL,NULL,'admin','admin@mailinator.com','9575164549','qqq',2,2,'2020-07-01 03:36:05','2020-07-01 03:36:05'),
	(104,47,36,1,0,'2020-07-31','12:00:00','',NULL,NULL,NULL,1,2,'2020-07-01 05:43:03','2020-07-01 05:43:03'),
	(105,47,36,1,0,'2020-07-31','12:00:00','',NULL,NULL,NULL,1,2,'2020-07-01 05:43:17','2020-07-01 05:43:17'),
	(106,54,19,1,0,'2020-07-07','12:30:00','',NULL,NULL,NULL,1,2,'2020-07-02 17:51:19','2020-07-02 17:51:19'),
	(107,55,36,3,0,'2020-07-24','01:00:00','',NULL,NULL,NULL,1,2,'2020-07-03 04:58:26','2020-07-03 04:58:26'),
	(108,56,19,2,0,'2020-06-30','12:30:00','',NULL,NULL,NULL,1,2,'2020-07-04 14:29:50','2020-07-04 14:29:50'),
	(109,58,19,2,1,'2020-07-07','01:00:00','',NULL,NULL,NULL,1,2,'2020-07-05 19:35:57','2020-07-05 19:35:57'),
	(110,58,19,2,1,'2020-07-07','04:30:00','',NULL,NULL,NULL,1,2,'2020-07-05 19:36:15','2020-07-05 19:36:15'),
	(111,58,19,2,1,'2020-07-07','04:30:00','',NULL,NULL,NULL,1,2,'2020-07-05 19:36:29','2020-07-05 19:36:29'),
	(112,13,19,3,0,'2020-07-08','02:00:00','',NULL,NULL,NULL,1,2,'2020-07-09 03:10:13','2020-07-09 03:10:13'),
	(113,13,19,3,0,'2020-07-10','02:00:00','',NULL,NULL,NULL,1,2,'2020-07-09 03:10:28','2020-07-09 03:10:28'),
	(114,13,19,3,0,'2020-07-10','02:00:00','',NULL,NULL,NULL,1,1,'2020-07-09 03:10:41','2020-07-09 03:13:35'),
	(115,NULL,41,NULL,NULL,NULL,NULL,'asdsaf','asdfasf','asdfasdf','asfsadf',2,2,'2020-07-28 15:44:17','2020-07-28 15:44:17'),
	(116,78,36,2,0,'2020-07-21','12:30:00','',NULL,NULL,NULL,1,2,'2020-07-28 18:13:30','2020-07-28 18:13:30'),
	(117,78,36,2,0,'2020-07-21','12:30:00','',NULL,NULL,NULL,1,2,'2020-07-28 18:13:43','2020-07-28 18:13:43'),
	(118,79,43,2,1,'2020-08-03','12:30:00','',NULL,NULL,NULL,1,2,'2020-08-02 11:11:12','2020-08-02 11:11:12'),
	(119,79,43,2,1,'2020-08-06','02:30:00','',NULL,NULL,NULL,1,2,'2020-08-02 11:11:38','2020-08-02 11:11:38'),
	(120,79,43,2,1,'2020-08-06','02:30:00','',NULL,NULL,NULL,1,2,'2020-08-02 11:11:52','2020-08-02 11:11:52'),
	(121,8,19,1,1,'2020-08-25','12:30:00','',NULL,NULL,NULL,1,2,'2020-08-07 06:53:01','2020-08-07 06:53:01'),
	(122,8,46,NULL,NULL,NULL,NULL,'Lyon','hello@uxper.co','444','4444',2,2,'2020-08-07 06:57:40','2020-08-07 06:57:40'),
	(123,8,19,1,1,'2020-08-12','01:00:00','',NULL,NULL,NULL,1,2,'2020-08-11 02:09:29','2020-08-11 02:09:29'),
	(124,86,19,1,0,'2020-08-12','01:30:00','',NULL,NULL,NULL,1,2,'2020-08-11 13:20:45','2020-08-11 13:20:45'),
	(125,92,19,1,0,'2020-08-21','01:00:00','',NULL,NULL,NULL,1,2,'2020-08-20 15:28:46','2020-08-20 15:28:46'),
	(126,97,36,1,1,'2020-08-04','12:00:00','',NULL,NULL,NULL,1,2,'2020-08-23 17:36:17','2020-08-23 17:36:17'),
	(127,98,37,1,1,'2020-08-26','01:30:00','',NULL,NULL,NULL,1,2,'2020-08-24 04:44:27','2020-08-24 04:44:27'),
	(128,100,43,2,0,'2020-08-29','02:00:00','',NULL,NULL,NULL,1,2,'2020-08-26 12:10:33','2020-08-26 12:10:33'),
	(129,108,38,2,0,'2020-09-16','01:30:00','',NULL,NULL,NULL,1,2,'2020-09-01 00:36:37','2020-09-01 00:36:37'),
	(130,111,36,1,0,'2020-09-09','01:00:00','',NULL,NULL,NULL,1,2,'2020-09-06 00:32:48','2020-09-06 00:32:48'),
	(131,13,36,1,0,'2020-09-09','01:00:00','',NULL,NULL,NULL,1,2,'2020-09-08 02:22:47','2020-09-08 02:22:47'),
	(132,13,36,1,0,'2020-09-10','12:30:00','',NULL,NULL,NULL,1,2,'2020-09-08 02:54:39','2020-09-08 02:54:39'),
	(133,13,36,1,0,'2020-09-10','12:30:00','',NULL,NULL,NULL,1,2,'2020-09-08 03:41:06','2020-09-08 03:41:06'),
	(134,13,36,1,0,'2020-09-04','01:30:00','',NULL,NULL,NULL,1,2,'2020-09-08 03:47:29','2020-09-08 03:47:29'),
	(135,115,43,1,0,'2020-09-04','06:30:00','',NULL,NULL,NULL,1,2,'2020-09-10 08:38:23','2020-09-10 08:38:23'),
	(136,119,37,2,0,'2020-09-16','12:30:00','',NULL,NULL,NULL,1,2,'2020-09-15 08:05:56','2020-09-15 08:05:56'),
	(137,120,19,1,0,'2020-09-15','12:00:00','',NULL,NULL,NULL,1,2,'2020-09-15 17:17:59','2020-09-15 17:17:59'),
	(138,NULL,46,NULL,NULL,NULL,NULL,'Alisher Bazarkhanov','developer.alisher@gmail.com','+77079131344','asd',2,2,'2020-09-16 06:27:50','2020-09-16 06:27:50'),
	(139,127,44,1,1,'2020-09-24','12:00:00','',NULL,NULL,NULL,1,2,'2020-09-24 17:29:17','2020-09-24 17:29:17'),
	(140,127,36,1,1,'2020-09-09','07:00:00','',NULL,NULL,NULL,1,2,'2020-09-24 17:30:06','2020-09-24 17:30:06'),
	(141,128,36,2,0,'2020-10-30','02:30:00','',NULL,NULL,NULL,1,2,'2020-09-24 18:01:42','2020-09-24 18:01:42'),
	(142,129,19,3,4,'2020-09-25','12:30:00','',NULL,NULL,NULL,1,2,'2020-09-24 20:13:32','2020-09-24 20:13:32'),
	(143,140,19,2,0,'2020-10-20','12:30:00','',NULL,NULL,NULL,1,2,'2020-10-19 02:40:38','2020-10-19 02:40:38'),
	(144,NULL,46,NULL,NULL,NULL,NULL,'asd','12332@gmail.com','+905005005050','asd',2,2,'2020-10-20 10:58:29','2020-10-20 10:58:29'),
	(145,NULL,41,NULL,NULL,NULL,NULL,'nisar mohd','mohdnis9869877@gmail.com','08707077720','khgkgjlg',2,2,'2020-10-20 14:27:25','2020-10-20 14:27:25'),
	(146,142,19,1,0,'2020-10-28','12:00:00','',NULL,NULL,NULL,1,2,'2020-10-23 20:41:27','2020-10-23 20:41:27'),
	(147,76,19,1,0,'2020-11-11','02:00:00','',NULL,NULL,NULL,1,2,'2020-11-04 04:33:51','2020-11-04 04:33:51'),
	(148,147,37,1,0,'2020-11-11','06:00:00','',NULL,NULL,NULL,1,2,'2020-11-04 05:41:24','2020-11-04 05:41:24'),
	(149,150,19,3,0,'2020-11-16','12:30:00','',NULL,NULL,NULL,1,2,'2020-11-15 13:27:54','2020-11-15 13:27:54');

/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT '0',
  `is_feature` int(11) DEFAULT '0',
  `feature_title` varchar(255) DEFAULT NULL,
  `icon_map_marker` varchar(255) DEFAULT NULL,
  `color_code` varchar(80) DEFAULT NULL,
  `type` varchar(10) DEFAULT 'place',
  `status` int(11) DEFAULT '1',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `slug`, `priority`, `is_feature`, `feature_title`, `icon_map_marker`, `color_code`, `type`, `status`, `seo_title`, `seo_description`, `created_at`, `updated_at`)
VALUES
	(11,'See & Do','pizza',1,1,'Must See & Do','5fbf2f235af7f_1606364963.jpg','#f0626c','place',1,NULL,NULL,'2019-10-25 11:11:08','2020-11-26 04:29:23'),
	(12,'Eat & Drink','fastfoot',2,0,'Where to Eat','5fbf2f5e9fac0_1606365022.png','#d763d7','place',1,NULL,NULL,'2019-10-25 11:11:19','2020-11-26 04:30:46'),
	(13,'Stay','vegetarian',3,0,'Place to stay','5fbf303062055_1606365232.jpg','#5b5ff9','place',1,NULL,NULL,'2019-10-25 11:11:45','2020-11-26 04:33:52'),
	(15,'Beaches','eat-drink',0,0,NULL,NULL,NULL,'post',1,NULL,NULL,'2019-11-27 08:57:25','2020-11-26 08:03:03'),
	(17,'Take a break','life-style',0,0,NULL,NULL,NULL,'post',1,NULL,NULL,'2019-11-27 08:57:38','2020-05-24 04:28:28'),
	(18,'Tips & Tricks','tips-tricks',0,0,NULL,NULL,NULL,'post',1,NULL,NULL,'2019-11-27 08:57:45','2019-11-27 08:57:45'),
	(20,NULL,'mexican',4,0,NULL,'5fbf3086b2ca1_1606365318.jpeg','#ffb44f','place',1,NULL,NULL,'2020-05-22 16:05:06','2020-11-26 04:35:18'),
	(21,NULL,'italian',6,0,NULL,'5fbf30ba613ce_1606365370.jpg','#846fcd','place',1,NULL,NULL,'2020-05-23 15:22:58','2020-11-26 04:36:10'),
	(22,NULL,'japan',5,0,NULL,'5fbf30fdb51fa_1606365437.jpg','#5493f9','place',1,NULL,NULL,'2020-05-23 16:54:39','2020-11-26 04:37:17'),
	(23,NULL,'vietnamese',6,0,NULL,'5fbf313627edc_1606365494.jpg','#78cc58','place',1,NULL,NULL,'2020-05-24 03:53:42','2020-11-26 04:38:14');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_translations`;

CREATE TABLE `category_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feature_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;

INSERT INTO `category_translations` (`id`, `category_id`, `locale`, `name`, `feature_title`)
VALUES
	(1,11,'en','Pizza',NULL),
	(2,12,'en','Fastfoot',NULL),
	(3,13,'en','Vegetarian',NULL),
	(4,15,'en','Eat & Drink',NULL),
	(6,17,'en','Life Style',NULL),
	(7,18,'en','Tips & Tricks',NULL),
	(9,20,'en','Mexican',NULL),
	(10,21,'en','Italian',NULL),
	(11,22,'en','Japan','Hotel'),
	(12,23,'en','Vietnamese',NULL),
	(13,23,'fr','Vietnamien',NULL),
	(14,22,'fr','Japan',NULL),
	(15,21,'fr','Italienne',NULL),
	(16,20,'fr','Mexicaine',NULL),
	(17,13,'fr','Végétarienne',NULL),
	(18,12,'fr','Pied rapide',NULL),
	(19,11,'fr','Restaurant',NULL),
	(20,15,'fr',NULL,NULL);

/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `best_time_to_visit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`, `intro`, `description`, `thumb`, `banner`, `best_time_to_visit`, `currency`, `language`, `lat`, `lng`, `priority`, `status`, `seo_title`, `seo_description`, `created_at`, `updated_at`)
VALUES
	(24,11,'Bangkok','san-diego','When in doubt, get a tuk-tuk','It isn’t a conventional charm that keeps us coming back to Bangkok. The Thai capital doesn’t have an Old Town like Hanoi, the modernity of Hong Kong, or the density of temples like Siem Reap (though few places in Southeast Asia are as spectacular as Wat Arun at sunrise).','5ec94e045024d_1590251012.jpg','5ec94e0450424_1590251012.jpeg','Nov to Apr','U. S. Dollar','English',32.715738,-117.1610838,0,1,NULL,NULL,'2019-11-04 03:10:37','2020-05-23 16:23:32'),
	(26,11,'New York','new-york','The entire world in one place','To know “The City” like a local might still be the greatest badge of honor for travelers. But take a breath: you won’t be able to cover the countless museums, galleries, restaurants, watering holes—and, yes, $1 pizza slices—all in one visit, but that’s the good news.','5ec94b2ca92c8_1590250284.jpg','5ec94b2ca9423_1590250284.jpeg','April to December','U.S. dollar','English',40.7127753,-74.0059728,0,1,NULL,NULL,'2019-11-04 03:15:46','2020-05-23 16:11:24'),
	(29,11,'Los Angeles','los-angeles','Cinematic city of dreams','From the Hollywood hills to the Venice Beach boardwalk, Los Angeles is a cinematic city of dreams, where every sunset feels like a scene from a movie. The center of the entertainment world','5ec94a4806643_1590250056.jpg','5ec94a480682f_1590250056.jpeg','Anytime','U. S. Dollar','English',34.0522342,-118.2436849,0,1,NULL,NULL,'2019-11-04 03:25:50','2020-05-23 16:07:36'),
	(30,11,'London','chicago','Where the pubs are as old as the monuments','London is as much about innovation as tradition; it’s a place that’s impossible to finish discovering, where the promise of something new is always in the air.','5ec9484029637_1590249536.jpg','5ec947c9bd6ee_1590249417.jpeg','May, Sep, Dec','USD','English',41.8781136,-87.6297982,0,1,NULL,NULL,'2019-11-04 03:28:13','2020-05-23 15:58:56'),
	(31,11,'','san-francisco',NULL,NULL,'5ec94f8aa91af_1590251402.jpg','5ec94f8aa953b_1590251402.jpeg','Anytime','U. S. Dollar','English',37.7749295,-122.4194155,0,1,NULL,NULL,'2020-05-23 16:30:02','2020-05-23 16:30:02');

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table city_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_translations`;

CREATE TABLE `city_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_translations_city_id_locale_unique` (`city_id`,`locale`),
  KEY `city_translations_locale_index` (`locale`),
  CONSTRAINT `city_translations_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `city_translations` WRITE;
/*!40000 ALTER TABLE `city_translations` DISABLE KEYS */;

INSERT INTO `city_translations` (`id`, `city_id`, `locale`, `name`, `intro`, `description`)
VALUES
	(2,24,'en','San Diego','South of Los Angeles','San Diego is a city in the U.S. state of California on the coast of the Pacific Ocean , approximately 120 miles (190 km) south of Los Angeles and immediately ...'),
	(4,26,'en','New York','The entire world in one place','To know “The City” like a local might still be the greatest badge of honor for travelers. But take a breath: you won’t be able to cover the countless museums, galleries, restaurants, watering holes—and, yes, $1 pizza slices—all in one visit, but that’s th'),
	(7,29,'en','Los Angeles','Cinematic city of dreams','From the Hollywood hills to the Venice Beach boardwalk, Los Angeles is a cinematic city of dreams, where every sunset feels like a scene from a movie. The center of the entertainment world'),
	(8,30,'en','Chicago','Where the pubs are as old as the monuments','Chicago is a city unlike any other. We’ve got the architectural marvels, world-class museums, dynamic entertainment, and award-winning dining scene you’d expect from one of the world’s greatest cities.'),
	(9,31,'en','San Francisco','Home to a little bit of everything','San Francisco is home to a little bit of everything. Whether you\'re a first time visitor or a long-time local, San Francisco\'s Golden Gates welcome all.'),
	(10,31,'fr','San Francisco',NULL,NULL);

/*!40000 ALTER TABLE `city_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;

INSERT INTO `countries` (`id`, `name`, `slug`, `priority`, `status`, `seo_title`, `seo_description`, `seo_cover_image`, `created_at`, `updated_at`)
VALUES
	(6,'France','france',0,1,NULL,NULL,NULL,'2019-10-25 04:05:59','2019-10-25 04:05:59'),
	(9,'Spain','spain',0,1,NULL,NULL,NULL,'2019-11-04 01:48:38','2019-11-04 01:48:38'),
	(11,'United States','united-states',0,1,NULL,NULL,NULL,'2019-11-04 01:49:46','2019-11-04 01:49:46');

/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `native_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;

INSERT INTO `languages` (`id`, `name`, `native_name`, `code`, `is_default`, `is_active`, `created_at`, `updated_at`)
VALUES
	(1,'Abkhaz','аҧсуа','ab',0,0,'2020-04-01 17:20:54','2020-06-24 19:48:54'),
	(2,'Afar','Afaraf','aa',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(3,'Afrikaans','Afrikaans','af',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(4,'Akan','Akan','ak',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(5,'Albanian','Shqip','sq',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(6,'Amharic','አማርኛ','am',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(7,'Arabic','العربية','ar',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(8,'Aragonese','Aragonés','an',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(9,'Armenian','Հայերեն','hy',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(10,'Assamese','অসমীয়া','as',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(11,'Avaric','авар мацӀ, магӀарул мацӀ','av',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(12,'Avestan','avesta','ae',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(13,'Aymara','aymar aru','ay',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(14,'Azerbaijani','azərbaycan dili','az',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(15,'Bambara','bamanankan','bm',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(16,'Bashkir','башҡорт теле','ba',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(17,'Basque','euskara, euskera','eu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(18,'Belarusian','Беларуская','be',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(19,'Bengali','বাংলা','bn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(20,'Bihari','भोजपुरी','bh',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(21,'Bislama','Bislama','bi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(22,'Bosnian','bosanski jezik','bs',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(23,'Breton','brezhoneg','br',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(24,'Bulgarian','български език','bg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(25,'Burmese','ဗမာစာ','my',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(26,'Catalan; Valencian','Català','ca',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(27,'Chamorro','Chamoru','ch',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(28,'Chechen','нохчийн мотт','ce',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(29,'Chichewa; Chewa; Nyanja','chiCheŵa, chinyanja','ny',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(30,'Chinese','中文 (Zhōngwén), 汉语, 漢語','zh',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(31,'Chuvash','чӑваш чӗлхи','cv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(32,'Cornish','Kernewek','kw',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(33,'Corsican','corsu, lingua corsa','co',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(34,'Cree','ᓀᐦᐃᔭᐍᐏᐣ','cr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(35,'Croatian','hrvatski','hr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(36,'Czech','česky, čeština','cs',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(37,'Danish','dansk','da',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(38,'Divehi; Dhivehi; Maldivian;','ދިވެހި','dv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(39,'Dutch','Nederlands, Vlaams','nl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(40,'English','English','en',1,1,'2020-04-01 17:20:54','2020-06-24 19:48:22'),
	(41,'Esperanto','Esperanto','eo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(42,'Estonian','eesti, eesti keel','et',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(43,'Ewe','Eʋegbe','ee',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(44,'Faroese','føroyskt','fo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(45,'Fijian','vosa Vakaviti','fj',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(46,'Finnish','suomi, suomen kieli','fi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(47,'French','français, langue française','fr',0,1,'2020-04-01 17:20:54','2020-06-24 19:48:20'),
	(48,'Fula; Fulah; Pulaar; Pular','Fulfulde, Pulaar, Pular','ff',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(49,'Galician','Galego','gl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(50,'Georgian','ქართული','ka',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(51,'German','Deutsch','de',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(52,'Greek, Modern','Ελληνικά','el',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(53,'Guaraní','Avañeẽ','gn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(54,'Gujarati','ગુજરાતી','gu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(55,'Haitian; Haitian Creole','Kreyòl ayisyen','ht',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(56,'Hausa','Hausa, هَوُسَ','ha',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(57,'Hebrew (modern)','עברית','he',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(58,'Herero','Otjiherero','hz',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(59,'Hindi','हिन्दी, हिंदी','hi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(60,'Hiri Motu','Hiri Motu','ho',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(61,'Hungarian','Magyar','hu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(62,'Interlingua','Interlingua','ia',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(63,'Indonesian','Bahasa Indonesia','id',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(64,'Interlingue','Originally called Occidental; then Interlingue after WWII','ie',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(65,'Irish','Gaeilge','ga',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(66,'Igbo','Asụsụ Igbo','ig',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(67,'Inupiaq','Iñupiaq, Iñupiatun','ik',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(68,'Ido','Ido','io',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(69,'Icelandic','Íslenska','is',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(70,'Italian','Italiano','it',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(71,'Inuktitut','ᐃᓄᒃᑎᑐᑦ','iu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(72,'Japanese','日本語 (にほんご／にっぽんご)','ja',0,0,'2020-04-01 17:20:54','2020-05-20 15:35:02'),
	(73,'Javanese','basa Jawa','jv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(74,'Kalaallisut, Greenlandic','kalaallisut, kalaallit oqaasii','kl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(75,'Kannada','ಕನ್ನಡ','kn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(76,'Kanuri','Kanuri','kr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(77,'Kashmiri','कश्मीरी, كشميري‎','ks',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(78,'Kazakh','Қазақ тілі','kk',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(79,'Khmer','ភាសាខ្មែរ','km',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(80,'Kikuyu, Gikuyu','Gĩkũyũ','ki',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(81,'Kinyarwanda','Ikinyarwanda','rw',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(82,'Kirghiz, Kyrgyz','кыргыз тили','ky',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(83,'Komi','коми кыв','kv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(84,'Kongo','KiKongo','kg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(85,'Korean','한국어 (韓國語), 조선말 (朝鮮語)','ko',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(86,'Kurdish','Kurdî, كوردی‎','ku',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(87,'Kwanyama, Kuanyama','Kuanyama','kj',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(88,'Latin','latine, lingua latina','la',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(89,'Luxembourgish, Letzeburgesch','Lëtzebuergesch','lb',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(90,'Luganda','Luganda','lg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(91,'Limburgish, Limburgan, Limburger','Limburgs','li',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(92,'Lingala','Lingála','ln',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(93,'Lao','ພາສາລາວ','lo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(94,'Lithuanian','lietuvių kalba','lt',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(95,'Luba-Katanga','','lu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(96,'Latvian','latviešu valoda','lv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(97,'Manx','Gaelg, Gailck','gv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(98,'Macedonian','македонски јазик','mk',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(99,'Malagasy','Malagasy fiteny','mg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(100,'Malay','bahasa Melayu, بهاس ملايو‎','ms',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(101,'Malayalam','മലയാളം','ml',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(102,'Maltese','Malti','mt',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(103,'Māori','te reo Māori','mi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(104,'Marathi (Marāṭhī)','मराठी','mr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(105,'Marshallese','Kajin M̧ajeļ','mh',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(106,'Mongolian','монгол','mn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(107,'Nauru','Ekakairũ Naoero','na',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(108,'Navajo, Navaho','Diné bizaad, Dinékʼehǰí','nv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(109,'Norwegian Bokmål','Norsk bokmål','nb',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(110,'North Ndebele','isiNdebele','nd',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(111,'Nepali','नेपाली','ne',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(112,'Ndonga','Owambo','ng',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(113,'Norwegian Nynorsk','Norsk nynorsk','nn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(114,'Norwegian','Norsk','no',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(115,'Nuosu','ꆈꌠ꒿ Nuosuhxop','ii',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(116,'South Ndebele','isiNdebele','nr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(117,'Occitan','Occitan','oc',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(118,'Ojibwe, Ojibwa','ᐊᓂᔑᓈᐯᒧᐎᓐ','oj',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(119,'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic','ѩзыкъ словѣньскъ','cu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(120,'Oromo','Afaan Oromoo','om',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(121,'Oriya','ଓଡ଼ିଆ','or',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(122,'Ossetian, Ossetic','ирон æвзаг','os',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(123,'Panjabi, Punjabi','ਪੰਜਾਬੀ, پنجابی‎','pa',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(124,'Pāli','पाऴि','pi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(125,'Persian','فارسی','fa',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(126,'Polish','polski','pl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(127,'Pashto, Pushto','پښتو','ps',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(128,'Portuguese','Português','pt',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(129,'Quechua','Runa Simi, Kichwa','qu',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(130,'Romansh','rumantsch grischun','rm',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(131,'Kirundi','kiRundi','rn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(132,'Romanian, Moldavian, Moldovan','română','ro',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(133,'Russian','русский язык','ru',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(134,'Sanskrit (Saṁskṛta)','संस्कृतम्','sa',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(135,'Sardinian','sardu','sc',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(136,'Sindhi','सिन्धी, سنڌي، سندھی‎','sd',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(137,'Northern Sami','Davvisámegiella','se',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(138,'Samoan','gagana faa Samoa','sm',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(139,'Sango','yângâ tî sängö','sg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(140,'Serbian','српски језик','sr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(141,'Scottish Gaelic; Gaelic','Gàidhlig','gd',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(142,'Shona','chiShona','sn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(143,'Sinhala, Sinhalese','සිංහල','si',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(144,'Slovak','slovenčina','sk',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(145,'Slovene','slovenščina','sl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(146,'Somali','Soomaaliga, af Soomaali','so',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(147,'Southern Sotho','Sesotho','st',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(148,'Spanish; Castilian','español, castellano','es',0,0,'2020-04-01 17:20:54','2020-06-24 19:48:59'),
	(149,'Sundanese','Basa Sunda','su',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(150,'Swahili','Kiswahili','sw',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(151,'Swati','SiSwati','ss',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(152,'Swedish','svenska','sv',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(153,'Tamil','தமிழ்','ta',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(154,'Telugu','తెలుగు','te',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(155,'Tajik','тоҷикӣ, toğikī, تاجیکی‎','tg',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(156,'Thai','ไทย','th',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(157,'Tigrinya','ትግርኛ','ti',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(158,'Tibetan Standard, Tibetan, Central','བོད་ཡིག','bo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(159,'Turkmen','Türkmen, Түркмен','tk',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(160,'Tagalog','Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔','tl',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(161,'Tswana','Setswana','tn',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(162,'Tonga (Tonga Islands)','faka Tonga','to',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(163,'Turkish','Türkçe','tr',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(164,'Tsonga','Xitsonga','ts',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(165,'Tatar','татарча, tatarça, تاتارچا‎','tt',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(166,'Twi','Twi','tw',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(167,'Tahitian','Reo Tahiti','ty',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(168,'Uighur, Uyghur','Uyƣurqə, ئۇيغۇرچە‎','ug',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(169,'Ukrainian','українська','uk',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(170,'Urdu','اردو','ur',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(171,'Uzbek','zbek, Ўзбек, أۇزبېك‎','uz',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(172,'Venda','Tshivenḓa','ve',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(173,'Vietnamese','Tiếng Việt','vi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(174,'Volapük','Volapük','vo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(175,'Walloon','Walon','wa',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(176,'Welsh','Cymraeg','cy',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(177,'Wolof','Wollof','wo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(178,'Western Frisian','Frysk','fy',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(179,'Xhosa','isiXhosa','xh',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(180,'Yiddish','ייִדיש','yi',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(181,'Yoruba','Yorùbá','yo',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54'),
	(182,'Zhuang, Chuang','Saɯ cueŋƅ, Saw cuengh','za',0,0,'2020-04-01 17:20:54','2020-04-01 17:20:54');

/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ltm_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ltm_translations`;

CREATE TABLE `ltm_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `ltm_translations` WRITE;
/*!40000 ALTER TABLE `ltm_translations` DISABLE KEYS */;

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`)
VALUES
	(1,0,'en','_json','Search results',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(2,0,'en','_json','results for',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(3,0,'en','_json','My account',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(4,0,'en','_json','Reset Password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(5,0,'en','_json','New password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(6,0,'en','_json','Enter new password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(7,0,'en','_json','Re-new password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(8,0,'en','_json','Save',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(9,0,'en','_json','Profile',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(10,0,'en','_json','Places',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(11,0,'en','_json','Wishlist',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(12,0,'en','_json','Profile Setting',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(13,0,'en','_json','Avatar',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(14,0,'en','_json','Upload new',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(15,0,'en','_json','Basic Info',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(16,0,'en','_json','Full name',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(17,0,'en','_json','Enter your name',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(18,0,'en','_json','Email',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(19,0,'en','_json','Phone',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(20,0,'en','_json','Enter phone number',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(21,0,'en','_json','Facebook',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(22,0,'en','_json','Enter facebook',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(23,0,'en','_json','Instagram',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(24,0,'en','_json','Enter instagram',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(25,0,'en','_json','Update',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(26,0,'en','_json','Change Password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(27,0,'en','_json','Old password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(28,0,'en','_json','Enter old password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(29,0,'en','_json','Place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(30,0,'en','_json','All cities',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(31,0,'en','_json','All categories',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(32,0,'en','_json','Search',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(33,0,'en','_json','ID',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(34,0,'en','_json','Thumb',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(35,0,'en','_json','Place name',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(36,0,'en','_json','City',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(37,0,'en','_json','Category',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(38,0,'en','_json','Status',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(39,0,'en','_json','Edit',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(40,0,'en','_json','View',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(41,0,'en','_json','Delete',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(42,0,'en','_json','No item found',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(43,0,'en','_json','Login',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(44,0,'en','_json','Sign Up',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(45,0,'en','_json','My Places',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(46,0,'en','_json','Logout',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(47,0,'en','_json','Destinations',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(48,0,'en','_json','Continue with',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(49,0,'en','_json','Forgot password',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(50,0,'en','_json','Add place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(51,0,'en','_json','Discover amazing things to do everywhere you go.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(52,0,'en','_json','About Us',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(53,0,'en','_json','Blog',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(54,0,'en','_json','Faqs',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(55,0,'en','_json','Contact',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(56,0,'en','_json','Contact Us',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(57,0,'en','_json','Back to list',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(58,0,'en','_json','Show all',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(59,0,'en','_json','Introducing',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(60,0,'en','_json','Currency',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(61,0,'en','_json','Languages',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(62,0,'en','_json','Best time to visit',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(63,0,'en','_json','Maps view',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(64,0,'en','_json','See all',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(65,0,'en','_json','No places',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(66,0,'en','_json','results',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(67,0,'en','_json','Clear All',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(68,0,'en','_json','Sort By',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(69,0,'en','_json','Newest',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(70,0,'en','_json','Average rating',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(71,0,'en','_json','Price: Low to high',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(72,0,'en','_json','Price: High to low',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(73,0,'en','_json','Free',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(74,0,'en','_json','Low: $',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(75,0,'en','_json','Medium: $$',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(76,0,'en','_json','High: $$$',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(77,0,'en','_json','Types',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(78,0,'en','_json','Amenities',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(79,0,'en','_json','Explorer Other Cities',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(80,0,'en','_json','No cities',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(81,0,'en','_json','Explore the world',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(82,0,'en','_json','Type a city or location',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(83,0,'en','_json','Popular:',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(84,0,'en','_json','Popular cities',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(85,0,'en','_json','Get the App',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(86,0,'en','_json','Download the app and go to travel the world.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(87,0,'en','_json','Related stories',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(88,0,'en','_json','View more',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(89,0,'en','_json','We want to hear from you.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(90,0,'en','_json','Our Offices',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(91,0,'en','_json','London (HQ)',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(92,0,'en','_json','Unit TAP.E, 80 Long Lane, London, SE1 4GT',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(93,0,'en','_json','+44 (0)34 5312 3505','+44 (0)34 5312 3505','2020-04-01 15:50:11','2020-12-25 05:36:16'),
	(94,0,'en','_json','Get Direction',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(95,0,'en','_json','Paris',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(96,0,'en','_json','Station F, 2 Parvis Alan Turing, 8742, Paris France',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(97,0,'en','_json','Get in touch with us',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(98,0,'en','_json','First name',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(99,0,'en','_json','Last name',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(100,0,'en','_json','Phone number',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(101,0,'en','_json','Message',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(102,0,'en','_json','Send Message',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(103,0,'en','_json','Genaral',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(104,0,'en','_json','Location',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(105,0,'en','_json','Contact info',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(106,0,'en','_json','Social network',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(107,0,'en','_json','Open hours',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(108,0,'en','_json','Media',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(109,0,'en','_json','Edit my place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(110,0,'en','_json','Add new place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(111,0,'en','_json','What the name of place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(112,0,'en','_json','Price Range',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(113,0,'en','_json','Description',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(114,0,'en','_json','Select Category',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(115,0,'en','_json','Place Type',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(116,0,'en','_json','Select Place Type',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(117,0,'en','_json','Place Address',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(118,0,'en','_json','Select country',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(119,0,'en','_json','Select city',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(120,0,'en','_json','Full Address',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(121,0,'en','_json','Place Location at Google Map',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(122,0,'en','_json','Your email address',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(123,0,'en','_json','Your phone number',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(124,0,'en','_json','Website',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(125,0,'en','_json','Your website url',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(126,0,'en','_json','Social Networks',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(127,0,'en','_json','Select network',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(128,0,'en','_json','Enter URL include http or www',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(129,0,'en','_json','Add more',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(130,0,'en','_json','Opening Hours',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(131,0,'en','_json','Thumb image',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(132,0,'en','_json','Maximum file size: 1 MB',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(133,0,'en','_json','Gallery Images',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(134,0,'en','_json','Video',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(135,0,'en','_json','Youtube, Vimeo video url',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(136,0,'en','_json','Login to submit',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(137,0,'en','_json','Submit',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(138,0,'en','_json','Gallery',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(139,0,'en','_json','Overview',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(140,0,'en','_json','Show more',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(141,0,'en','_json','Location & Maps',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(142,0,'en','_json','Direction',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(143,0,'en','_json','Review',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(144,0,'en','_json','to review',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(145,0,'en','_json','Write a review',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(146,0,'en','_json','Rate This Place',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(147,0,'en','_json','Booking online',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(148,0,'en','_json','Book now',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(149,0,'en','_json','Make a reservation',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(150,0,'en','_json','Send me a message',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(151,0,'en','_json','Send',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(152,0,'en','_json','Banner Ads',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(153,0,'en','_json','By Booking.com',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(154,0,'en','_json','Adults',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(155,0,'en','_json','Childrens',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(156,0,'en','_json','You won\'t be charged yet',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(157,0,'en','_json','You successfully created your booking.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(158,0,'en','_json','An error occurred. Please try again.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(159,0,'en','_json','Similar places',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(160,0,'en','_json','by',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(161,0,'en','_json','Related Articles',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(162,0,'en','_json','All',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(163,0,'en','_json','reviews',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(164,0,'en','_json','404 Error',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(165,0,'en','_json','Sorry, we couldn\'t find that page.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(166,0,'en','_json','OOPS!',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(167,0,'en','_json','We can\'t find the page or studio you\'re looking for.',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(168,0,'en','_json','Make sure you\'ve typed in the URL correctly or try go',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(169,0,'en','_json','Homepage',NULL,'2020-04-01 15:50:11','2020-04-01 15:50:11'),
	(170,0,'fr','_json','Explore the world','Explore le monde','2020-04-01 15:57:36','2020-12-25 05:36:16'),
	(171,0,'fr','_json','Destinations','Les destinations','2020-04-01 15:58:13','2020-12-25 05:36:16'),
	(172,0,'fr','_json','Add place','Ajouter Un Lieu','2020-04-01 16:03:20','2020-12-25 05:36:16'),
	(173,0,'fr','_json','Type a city or location','Saisissez une ville ou un emplacement','2020-04-01 16:04:19','2020-12-25 05:36:16'),
	(174,0,'fr','_json','Popular cities','Villes populaires','2020-04-01 16:04:41','2020-12-25 05:36:16'),
	(175,0,'fr','_json','Get the App','Obtenir l\'application','2020-04-01 16:06:12','2020-12-25 05:36:16'),
	(176,0,'fr','_json','Download the app and go to travel the world.','Téléchargez l\'application et partez parcourir le monde.','2020-04-01 16:06:45','2020-12-25 05:36:16'),
	(177,0,'fr','_json','Related stories','Histoires liées','2020-04-01 16:07:21','2020-12-25 05:36:16'),
	(178,0,'fr','_json','Discover amazing things to do everywhere you go.','Découvrez des choses incroyables à faire partout où vous allez.','2020-04-01 16:07:54','2020-12-25 05:36:16'),
	(179,0,'fr','_json','About Us','À propos de nous','2020-04-01 16:08:47','2020-12-25 05:36:16'),
	(180,0,'fr','_json','Popular:','Populaire','2020-04-01 16:10:33','2020-12-25 05:36:16'),
	(181,0,'fr','_json','Places','Des Endroits','2020-04-01 16:11:04','2020-12-25 05:36:16'),
	(182,0,'fr','_json','View more','Voir plus','2020-04-01 16:11:47','2020-12-25 05:36:16'),
	(183,0,'fr','_json','Introducing','Présentation','2020-04-01 16:27:56','2020-12-25 05:36:16'),
	(184,0,'fr','_json','Currency','DEVISE','2020-04-01 16:28:21','2020-12-25 05:36:16'),
	(185,0,'fr','_json','Languages','LANGUES','2020-04-01 16:28:47','2020-12-25 05:36:16'),
	(186,0,'fr','_json','Best time to visit','MEILLEUR MOMENT POUR VISITER','2020-04-01 16:29:07','2020-12-25 05:36:16'),
	(187,0,'fr','_json','Explorer Other Cities','Explorer d\'autres villes','2020-04-01 16:29:43','2020-12-25 05:36:16'),
	(188,0,'fr','_json','Maps view','Affichage des cartes','2020-04-01 16:33:26','2020-12-25 05:36:16'),
	(189,0,'fr','_json','See all','Voir tout','2020-04-01 16:33:50','2020-12-25 05:36:16'),
	(190,0,'fr','_json','Overview','Aperçu','2020-04-01 16:39:49','2020-12-25 05:36:16'),
	(191,0,'fr','_json','Location & Maps','Emplacement et cartes','2020-04-01 16:40:08','2020-12-25 05:36:16'),
	(192,0,'fr','_json','Contact info','Informations de contact','2020-04-01 16:40:28','2020-12-25 05:36:16'),
	(193,0,'fr','_json','Opening Hours','Horaires d\'ouvertures','2020-04-01 16:40:49','2020-12-25 05:36:16'),
	(194,0,'fr','_json','Our Offices','Horaires d\'ouvertures','2020-04-01 16:41:12','2020-12-25 05:36:16'),
	(195,0,'fr','_json','Write a review','Écrire une critique','2020-04-01 16:41:32','2020-12-25 05:36:16'),
	(196,0,'fr','_json','Rate This Place','Évaluez cet endroit','2020-04-01 16:41:51','2020-12-25 05:36:16'),
	(197,0,'fr','_json','Submit','Soumettre','2020-04-01 16:42:11','2020-12-25 05:36:16'),
	(198,0,'fr','_json','Similar places','Endroits similaires','2020-04-01 16:42:41','2020-12-25 05:36:16'),
	(199,0,'fr','_json','Gallery','Galerie','2020-04-01 16:43:08','2020-12-25 05:36:16'),
	(200,0,'fr','_json','Show more','Montre plus','2020-04-01 16:43:35','2020-12-25 05:36:16'),
	(201,0,'fr','_json','Get in touch with us','Prenez contact avec nous','2020-04-01 16:44:58','2020-12-25 05:36:16'),
	(202,0,'fr','_json','404 Error','Erreur 404','2020-04-01 16:45:17','2020-12-25 05:36:16'),
	(203,0,'fr','_json','Add more','Ajouter plus de','2020-04-01 16:45:31','2020-12-25 05:36:16'),
	(204,0,'fr','_json','Add new place','Ajouter un nouveau lieu','2020-04-01 16:45:48','2020-12-25 05:36:16'),
	(205,0,'fr','_json','Adults','Adultes','2020-04-01 16:46:12','2020-12-25 05:36:16'),
	(206,0,'fr','_json','All','Toute','2020-04-01 16:46:24','2020-12-25 05:36:16'),
	(207,0,'fr','_json','All categories','Toutes catégories','2020-04-01 16:46:34','2020-12-25 05:36:16'),
	(208,0,'fr','_json','All cities','Toutes les villes','2020-04-01 16:46:45','2020-12-25 05:36:16'),
	(209,0,'fr','_json','Amenities','Agréments','2020-04-01 16:46:55','2020-12-25 05:36:16'),
	(210,0,'fr','_json','An error occurred. Please try again.','Une erreur est survenue. Veuillez réessayer.','2020-04-01 16:47:06','2020-12-25 05:36:16'),
	(211,0,'fr','_json','Avatar','Avatar','2020-04-01 16:47:18','2020-12-25 05:36:16'),
	(212,0,'fr','_json','Average rating','Note moyenne','2020-04-01 16:47:28','2020-12-25 05:36:16'),
	(213,0,'fr','_json','Back to list','Retour à la liste','2020-04-01 16:47:38','2020-12-25 05:36:16'),
	(214,0,'fr','_json','Banner Ads','Bannière publicitaire','2020-04-01 16:47:50','2020-12-25 05:36:16'),
	(215,0,'fr','_json','Basic Info','Informations de base','2020-04-01 16:48:14','2020-12-25 05:36:16'),
	(216,0,'fr','_json','Blog','Blog','2020-04-01 16:48:25','2020-12-25 05:36:16'),
	(217,0,'fr','_json','Book now','Reserve maintenant','2020-04-01 16:48:37','2020-12-25 05:36:16'),
	(218,0,'fr','_json','Booking online','Réservation en ligne','2020-04-01 16:48:46','2020-12-25 05:36:16'),
	(219,0,'fr','_json','by','par','2020-04-01 16:48:55','2020-12-25 05:36:16'),
	(220,0,'fr','_json','By Booking.com','Par Booking.com','2020-04-01 16:49:07','2020-12-25 05:36:16'),
	(221,0,'fr','_json','Category','Catégorie','2020-04-01 16:49:18','2020-12-25 05:36:16'),
	(222,0,'fr','_json','Change Password','Changer le mot de passe','2020-04-01 16:49:28','2020-12-25 05:36:16'),
	(223,0,'fr','_json','Childrens','Enfants','2020-04-01 16:49:38','2020-12-25 05:36:16'),
	(224,0,'fr','_json','City','Ville','2020-04-01 16:49:48','2020-12-25 05:36:16'),
	(225,0,'fr','_json','Clear All','Tout effacer','2020-04-01 16:49:58','2020-12-25 05:36:16'),
	(226,0,'fr','_json','Contact','Contact','2020-04-01 16:50:08','2020-12-25 05:36:16'),
	(227,0,'fr','_json','Contact Us','Nous contacter','2020-04-01 16:50:17','2020-12-25 05:36:16'),
	(228,0,'fr','_json','Continue with','Continue avec','2020-04-01 16:50:26','2020-12-25 05:36:16'),
	(229,0,'fr','_json','Delete','Supprimer','2020-04-01 16:50:37','2020-12-25 05:36:16'),
	(230,0,'fr','_json','Description','La description','2020-04-01 16:50:46','2020-12-25 05:36:16'),
	(231,0,'fr','_json','Direction','Direction','2020-04-01 16:50:56','2020-12-25 05:36:16'),
	(232,0,'fr','_json','Edit','Éditer','2020-04-01 16:51:07','2020-12-25 05:36:16'),
	(233,0,'fr','_json','Edit my place','Modifier ma place','2020-04-01 16:51:20','2020-12-25 05:36:16'),
	(234,0,'fr','_json','Email','Email','2020-04-01 16:51:25','2020-12-25 05:36:16'),
	(235,0,'fr','_json','Enter facebook','Entrez facebook','2020-04-01 16:51:48','2020-12-25 05:36:16'),
	(236,0,'fr','_json','Enter instagram','Enter instagram','2020-04-01 16:51:53','2020-12-25 05:36:16'),
	(237,0,'fr','_json','Enter new password','Entrez un nouveau mot de passe','2020-04-01 16:52:05','2020-12-25 05:36:16'),
	(238,0,'fr','_json','Enter old password','Entrez l\'ancien mot de passe','2020-04-01 16:52:15','2020-12-25 05:36:16'),
	(239,0,'fr','_json','Enter phone number','Entrez le numéro de téléphone','2020-04-01 16:52:27','2020-12-25 05:36:16'),
	(240,0,'fr','_json','Enter URL include http or www','Entrez l\'URL inclure http ou www','2020-04-01 16:52:37','2020-12-25 05:36:16'),
	(241,0,'fr','_json','Enter your name','Entrez votre nom','2020-04-01 16:52:48','2020-12-25 05:36:16'),
	(242,0,'fr','_json','Facebook','Facebook','2020-04-01 16:52:53','2020-12-25 05:36:16'),
	(243,0,'fr','_json','Faqs','Faqs','2020-04-01 16:52:57','2020-12-25 05:36:16'),
	(244,0,'fr','_json','First name','Prénom','2020-04-01 16:53:05','2020-12-25 05:36:16'),
	(245,0,'fr','_json','Forgot password','Mot de passe oublié','2020-04-01 16:53:14','2020-12-25 05:36:16'),
	(246,0,'fr','_json','Free','Gratuite','2020-04-01 16:53:24','2020-12-25 05:36:16'),
	(247,0,'fr','_json','Full Address','Adresse complète','2020-04-01 16:53:35','2020-12-25 05:36:16'),
	(248,0,'fr','_json','Full name','Nom complet','2020-04-01 16:53:43','2020-12-25 05:36:16'),
	(249,0,'fr','_json','Gallery Images','Galerie d\'images','2020-04-01 16:53:54','2020-12-25 05:36:16'),
	(250,0,'fr','_json','Genaral','Générale','2020-04-01 16:54:04','2020-12-25 05:36:16'),
	(251,0,'fr','_json','Get Direction','Get Direction','2020-04-01 16:54:15','2020-12-25 05:36:16'),
	(252,0,'fr','_json','High: $$$','Élevé: $$$','2020-04-01 16:54:26','2020-12-25 05:36:16'),
	(253,0,'fr','_json','Homepage','Page d\'accueil','2020-04-01 16:54:35','2020-12-25 05:36:16'),
	(254,0,'fr','_json','Last name','Nom de famille','2020-04-01 16:54:48','2020-12-25 05:36:16'),
	(255,0,'fr','_json','Location','Emplacement','2020-04-01 16:54:59','2020-12-25 05:36:16'),
	(256,0,'fr','_json','Login','S\'identifier','2020-04-01 16:55:09','2020-12-25 05:36:16'),
	(257,0,'fr','_json','Login to submit','Login to submit','2020-04-01 16:55:15','2020-12-25 05:36:16'),
	(258,0,'fr','_json','Logout','Se déconnecter','2020-04-01 16:55:28','2020-12-25 05:36:16'),
	(259,0,'fr','_json','Low: $','Faible: $','2020-04-01 16:55:39','2020-12-25 05:36:16'),
	(260,0,'fr','_json','Make a reservation','Faire une réservation','2020-04-01 16:55:49','2020-12-25 05:36:16'),
	(261,0,'fr','_json','Make sure you\'ve typed in the URL correctly or try go','Assurez-vous que vous avez correctement saisi l\'URL ou essayez d\'aller','2020-04-01 16:55:59','2020-12-25 05:36:16'),
	(262,0,'fr','_json','Maximum file size: 1 MB','Taille maximale du fichier: 1 Mo','2020-04-01 16:56:38','2020-12-25 05:36:16'),
	(263,0,'fr','_json','Media','Médias','2020-04-01 16:56:49','2020-12-25 05:36:16'),
	(264,0,'fr','_json','Medium: $$','Moyen: $$','2020-04-01 16:56:59','2020-12-25 05:36:16'),
	(265,0,'fr','_json','Message','Message','2020-04-01 16:57:11','2020-12-25 05:36:16'),
	(266,0,'fr','_json','My account','Mon compte','2020-04-01 16:57:21','2020-12-25 05:36:16'),
	(267,0,'fr','_json','My Places','Mes lieux','2020-04-01 16:57:33','2020-12-25 05:36:16'),
	(268,0,'fr','_json','New password','New password','2020-04-01 16:57:47','2020-12-25 05:36:16'),
	(269,0,'fr','_json','Newest','Le plus récent','2020-04-01 16:57:56','2020-12-25 05:36:16'),
	(270,0,'fr','_json','No cities','Pas de villes','2020-04-01 16:58:05','2020-12-25 05:36:16'),
	(271,0,'fr','_json','No item found','Aucun élément trouvé','2020-04-01 16:58:13','2020-12-25 05:36:16'),
	(272,0,'fr','_json','No places','Aucun endroit','2020-04-01 16:58:24','2020-12-25 05:36:16'),
	(273,0,'fr','_json','Old password','Ancien mot de passe','2020-04-01 16:58:34','2020-12-25 05:36:16'),
	(274,0,'fr','_json','Open hours','Heures d\'ouverture','2020-04-01 16:58:44','2020-12-25 05:36:16'),
	(275,0,'fr','_json','Phone','Téléphone','2020-04-01 16:58:54','2020-12-25 05:36:16'),
	(276,0,'fr','_json','Phone number','Numéro de téléphone','2020-04-01 16:59:04','2020-12-25 05:36:16'),
	(277,0,'fr','_json','Place','Endroit','2020-04-01 16:59:14','2020-12-25 05:36:16'),
	(278,0,'fr','_json','Place Address','Adresse du lieu','2020-04-01 16:59:27','2020-12-25 05:36:16'),
	(279,0,'fr','_json','Place Location at Google Map','Placer la position sur Google Map','2020-04-01 16:59:36','2020-12-25 05:36:16'),
	(280,0,'fr','_json','Place name','Nom du lieu','2020-04-01 16:59:45','2020-12-25 05:36:16'),
	(281,0,'fr','_json','Place Type','Type de lieu','2020-04-01 16:59:56','2020-12-25 05:36:16'),
	(282,0,'fr','_json','Price Range','Échelle des prix','2020-04-01 17:00:08','2020-12-25 05:36:16'),
	(283,0,'fr','_json','Price: High to low','Prix: de haut en bas','2020-04-01 17:00:16','2020-12-25 05:36:16'),
	(284,0,'fr','_json','Price: Low to high','Price: Low to high','2020-04-01 17:00:22','2020-12-25 05:36:16'),
	(285,0,'fr','_json','Profile','Profil','2020-04-01 17:00:32','2020-12-25 05:36:16'),
	(286,0,'fr','_json','Profile Setting','Réglage du profil','2020-04-01 17:00:41','2020-12-25 05:36:16'),
	(287,0,'fr','_json','Re-new password','Nouveau mot de passe','2020-04-01 17:00:50','2020-12-25 05:36:16'),
	(288,0,'fr','_json','Related Articles','Articles Liés','2020-04-01 17:01:01','2020-12-25 05:36:16'),
	(289,0,'fr','_json','Reset Password','réinitialiser le mot de passe','2020-04-01 17:01:12','2020-12-25 05:36:16'),
	(290,0,'fr','_json','results','résultats','2020-04-01 17:01:23','2020-12-25 05:36:16'),
	(291,0,'fr','_json','results for','résultats pour','2020-04-01 17:01:32','2020-12-25 05:36:16'),
	(292,0,'fr','_json','Review','La revue','2020-04-01 17:01:42','2020-12-25 05:36:16'),
	(293,0,'fr','_json','reviews','Commentaires','2020-04-01 17:01:53','2020-12-25 05:36:16'),
	(294,0,'fr','_json','Save','sauvegarder','2020-04-01 17:02:04','2020-12-25 05:36:16'),
	(295,0,'fr','_json','Search','Chercher','2020-04-01 17:02:15','2020-12-25 05:36:16'),
	(296,0,'fr','_json','Search results','Résultats de recherche','2020-04-01 17:02:24','2020-12-25 05:36:16'),
	(297,0,'fr','_json','Select Category','Choisir une catégorie','2020-04-01 17:02:33','2020-12-25 05:36:16'),
	(298,0,'fr','_json','Select city','Sélectionnez une ville','2020-04-01 17:02:42','2020-12-25 05:36:16'),
	(299,0,'fr','_json','Select country','Choisissez le pays','2020-04-01 17:02:54','2020-12-25 05:36:16'),
	(300,0,'fr','_json','Select network','Sélectionnez réseau','2020-04-01 17:03:05','2020-12-25 05:36:16'),
	(301,0,'fr','_json','Select Place Type','Sélectionnez le type de lieu','2020-04-01 17:03:13','2020-12-25 05:36:16'),
	(302,0,'fr','_json','Send','Envoyer','2020-04-01 17:03:22','2020-12-25 05:36:16'),
	(303,0,'fr','_json','Send me a message','Envoyez-moi un message','2020-04-01 17:03:32','2020-12-25 05:36:16'),
	(304,0,'fr','_json','Send Message','Envoyer le message','2020-04-01 17:03:42','2020-12-25 05:36:16'),
	(305,0,'fr','_json','Show all','Afficher tout','2020-04-01 17:03:50','2020-12-25 05:36:16'),
	(306,0,'fr','_json','Sign Up','S\'inscrire','2020-04-01 17:04:00','2020-12-25 05:36:16'),
	(307,0,'fr','_json','Social network','Réseau social','2020-04-01 17:04:09','2020-12-25 05:36:16'),
	(308,0,'fr','_json','Social Networks','Réseau social','2020-04-01 17:04:14','2020-12-25 05:36:16'),
	(309,0,'fr','_json','Sorry, we couldn\'t find that page.','Désolé, nous n\'avons pas pu trouver cette page.','2020-04-01 17:04:28','2020-12-25 05:36:16'),
	(310,0,'fr','_json','Sort By','Trier par','2020-04-01 17:04:39','2020-12-25 05:36:16'),
	(311,0,'fr','_json','Status','Statut','2020-04-01 17:04:53','2020-12-25 05:36:16'),
	(312,0,'fr','_json','Thumb','Thumb','2020-04-01 17:05:04','2020-12-25 05:36:16'),
	(313,0,'fr','_json','Thumb image','Image du pouce','2020-04-01 17:05:14','2020-12-25 05:36:16'),
	(314,0,'fr','_json','to review','réviser','2020-04-01 17:05:23','2020-12-25 05:36:16'),
	(315,0,'fr','_json','Types','Les types','2020-04-01 17:05:33','2020-12-25 05:36:16'),
	(316,0,'fr','_json','Update','Mise à jour','2020-04-01 17:05:43','2020-12-25 05:36:16'),
	(317,0,'fr','_json','Upload new','Importer un nouveau','2020-04-01 17:05:54','2020-12-25 05:36:16'),
	(318,0,'fr','_json','Video','Vidéo','2020-04-01 17:06:04','2020-12-25 05:36:16'),
	(319,0,'fr','_json','View','Vue','2020-04-01 17:06:13','2020-12-25 05:36:16'),
	(320,0,'fr','_json','We can\'t find the page or studio you\'re looking for.','Nous ne trouvons pas la page ou le studio que vous recherchez.','2020-04-01 17:06:26','2020-12-25 05:36:16'),
	(321,0,'fr','_json','We want to hear from you.','Nous voulons de vos nouvelles.','2020-04-01 17:06:40','2020-12-25 05:36:16'),
	(322,0,'fr','_json','Website','Site Internet','2020-04-01 17:06:52','2020-12-25 05:36:16'),
	(323,0,'fr','_json','What the name of place','quel est le nom du lieu','2020-04-01 17:07:13','2020-12-25 05:36:16'),
	(324,0,'fr','_json','Wishlist','Liste de souhaits','2020-04-01 17:07:24','2020-12-25 05:36:16'),
	(325,0,'fr','_json','You successfully created your booking.','Vous avez créé votre réservation avec succès.','2020-04-01 17:07:35','2020-12-25 05:36:16'),
	(326,0,'fr','_json','You won\'t be charged yet','You won\'t be charged yet','2020-04-01 17:07:43','2020-12-25 05:36:16'),
	(327,0,'fr','_json','Your email address','Votre adresse email','2020-04-01 17:07:54','2020-12-25 05:36:16'),
	(328,0,'fr','_json','Your phone number','Votre numéro de téléphone','2020-04-01 17:08:05','2020-12-25 05:36:16'),
	(329,0,'fr','_json','Your website url','L\'adresse URL de votre site','2020-04-01 17:08:15','2020-12-25 05:36:16'),
	(330,0,'fr','_json','Youtube, Vimeo video url','Youtube, URL vidéo Vimeo','2020-04-01 17:08:26','2020-12-25 05:36:16'),
	(331,0,'en','_json','Search places ...',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(332,0,'en','_json','Or',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(333,0,'en','_json','Lost your password? Please enter your email address. You will receive a link to create a new password via email.',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(334,0,'en','_json','Dashboard',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(335,0,'en','_json','Company',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(336,0,'en','_json','Support',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(337,0,'en','_json','Email: support@domain.com',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(338,0,'en','_json','Phone: 1 (00) 832 2342',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(339,0,'en','_json','https://uxper.co',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(340,0,'en','_json','UxPer',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(341,0,'en','_json','All rights reserved.',NULL,'2020-05-04 14:32:29','2020-05-04 14:32:29'),
	(342,0,'en','Loading','..',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(343,0,'en','_json','Filter',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(344,0,'en','_json','More',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(345,0,'en','_json','Apply',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(346,0,'en','_json','Maps',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(347,0,'en','_json','Nothing found!',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(348,0,'en','_json','We\'re sorry but we do not have any listings matching your search, try to change you search settings',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(349,0,'en','_json','Close',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(350,0,'en','_json','Find',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(351,0,'en','_json','Where',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(352,0,'en','_json','Log In',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(353,0,'en','_json','Sign-up to receive regular updates from us.',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(354,0,'en','_json','The Golo App',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(355,0,'en','_json','Price Filter',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(356,0,'en','_json','Business Listing',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(357,0,'en','_json','cities',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(358,0,'en','_json','categories',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(359,0,'en','_json','Browse Businesses by Category',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(360,0,'en','_json','Trending Business Places',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(361,0,'en','_json','Featured Cities',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(362,0,'en','_json','Choose the city you\'ll be living in next',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(363,0,'en','_json','Who we are',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(364,0,'en','_json','Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident.',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(365,0,'en','_json','Read more',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(366,0,'en','_json','People Talking About Us',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(367,0,'en','_json','From Our Blog',NULL,'2020-06-17 04:51:08','2020-06-17 04:51:08'),
	(368,0,'fr','_json','Business Listing','Liste d\'entreprises','2020-06-23 15:58:46','2020-12-25 05:36:16'),
	(369,0,'fr','_json','cities','villes','2020-06-23 15:59:17','2020-12-25 05:36:16'),
	(370,0,'fr','_json','categories','catégories','2020-06-23 15:59:42','2020-12-25 05:36:16'),
	(371,0,'fr','_json','Browse Businesses by Category','Parcourir les entreprises par catégorie','2020-06-23 16:00:50','2020-12-25 05:36:16'),
	(372,0,'fr','_json','Trending Business Places','Tendance des lieux d\'affaires','2020-06-23 16:01:12','2020-12-25 05:36:16'),
	(373,0,'fr','_json','Featured Cities','Villes en vedette','2020-06-23 16:01:38','2020-12-25 05:36:16'),
	(374,0,'fr','_json','Choose the city you\'ll be living in next','Choose the city you\'ll be living in next','2020-06-23 16:02:07','2020-12-25 05:36:16'),
	(375,0,'fr','_json','Who we are','Qui nous sommes','2020-06-23 16:02:24','2020-12-25 05:36:16'),
	(376,0,'fr','_json','People Talking About Us','Des gens qui parlent de nous','2020-06-23 16:02:42','2020-12-25 05:36:16'),
	(377,0,'fr','_json','From Our Blog','De notre blog','2020-06-23 16:03:00','2020-12-25 05:36:16'),
	(378,0,'fr','_json','Sign-up to receive regular updates from us.','Inscrivez-vous pour recevoir des mises à jour régulières de notre part.','2020-06-23 16:09:51','2020-12-25 05:36:16'),
	(379,0,'fr','_json','Find','Trouver','2020-06-23 16:10:56','2020-12-25 05:36:16'),
	(380,0,'fr','_json','Where','Où','2020-06-23 16:11:28','2020-12-25 05:36:16'),
	(381,0,'fr','_json','All rights reserved.','Tous les droits sont réservés.','2020-06-23 16:15:33','2020-12-25 05:36:16'),
	(382,0,'fr','_json','Nothing found!','Rien n\'a été trouvé!','2020-06-23 16:15:59','2020-12-25 05:36:16'),
	(383,0,'fr','_json','Search places ...','Rechercher des lieux ...','2020-06-23 16:16:13','2020-12-25 05:36:16'),
	(384,0,'fr','_json','We\'re sorry but we do not have any listings matching your search, try to change you search settings','Nous sommes désolés mais nous n\'avons aucune annonce correspondant à votre recherche, essayez de modifier vos paramètres de recherche','2020-06-23 16:16:33','2020-12-25 05:36:16'),
	(385,0,'fr','_json','Support','Soutien','2020-06-23 16:16:50','2020-12-25 05:36:16'),
	(386,0,'fr','_json','Read more','Lire la suite','2020-06-23 16:17:03','2020-12-25 05:36:16'),
	(387,0,'fr','_json','Price Filter','Filtre de prix','2020-06-23 16:17:13','2020-12-25 05:36:16'),
	(388,0,'fr','_json','More','Plus','2020-06-23 16:17:36','2020-12-25 05:36:16'),
	(389,0,'fr','_json','Lost your password? Please enter your email address. You will receive a link to create a new password via email.','Mot de passe perdu? Veuillez saisir votre adresse e-mail. Vous recevrez un lien pour créer un nouveau mot de passe par e-mail.','2020-06-23 16:17:53','2020-12-25 05:36:16'),
	(390,0,'fr','_json','Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident.','De nombreux packages de publication assistée par ordinateur et éditeurs de pages Web utilisent désormais Lorem Ipsum comme texte de modèle par défaut, et une recherche de «lorem ipsum» permettra de découvrir de nombreux sites Web encore balbutiants. Différentes versions ont évolué au fil des ans, parfois par accident.','2020-06-23 16:18:09','2020-12-25 05:36:16'),
	(391,0,'fr','_json','Log In','S\'identifier','2020-06-23 16:18:20','2020-12-25 05:36:16'),
	(392,0,'fr','_json','Filter','Filtre','2020-06-23 16:18:35','2020-12-25 05:36:16'),
	(393,0,'fr','_json','Dashboard','Tableau de bord','2020-06-23 16:18:49','2020-12-25 05:36:16'),
	(394,0,'fr','_json','Close','Fermer','2020-06-23 16:19:01','2020-12-25 05:36:16'),
	(395,0,'fr','_json','Company','Compagnie','2020-06-23 16:19:11','2020-12-25 05:36:16'),
	(396,0,'fr','_json','Apply','Appliquer','2020-06-23 16:19:25','2020-12-25 05:36:16'),
	(397,0,'en','_json','Drink, Food & Enjoy',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(398,1,'en','_json','Discover the best restaurant.',NULL,'2020-12-25 05:26:42','2020-12-25 05:32:09'),
	(399,0,'en','_json','Popular Restaurants in Town',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(400,0,'en','_json','Search By Cuisine',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(401,0,'en','_json','Explore restaurants and cafes by your favorite cuisine',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(402,0,'en','_json','Explore restaurants & cafes by locality',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(403,0,'en','_json','Restaurateurs Join Us',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(404,0,'en','_json','Join the more than 10,000 restaurants which fill seats and manage reservations with Golo.',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(405,0,'en','_json','Learn More',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(406,0,'en','_json','Password',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(407,0,'en','_json','© 2020 All Rights Reserved.',NULL,'2020-12-25 05:26:42','2020-12-25 05:26:42'),
	(408,1,'fr','_json','© 2020 All Rights Reserved.',NULL,'2020-12-25 05:31:36','2020-12-25 05:31:42'),
	(409,0,'fr','_json','Discover the best restaurant.','Découvrez le meilleur restaurant.','2020-12-25 05:32:15','2020-12-25 05:36:16'),
	(410,0,'fr','_json','Drink, Food & Enjoy','BOIRE, NOURRIR ET PROFITER','2020-12-25 05:32:39','2020-12-25 05:36:16'),
	(411,0,'fr','_json','Popular Restaurants in Town','Restaurants populaires à Town','2020-12-25 05:33:20','2020-12-25 05:36:16'),
	(412,0,'fr','_json','Search By Cuisine','Recherche par cuisine','2020-12-25 05:33:44','2020-12-25 05:36:16'),
	(413,0,'fr','_json','Explore restaurants and cafes by your favorite cuisine','Explorez les restaurants et les cafés selon votre cuisine préférée','2020-12-25 05:34:16','2020-12-25 05:36:16'),
	(414,0,'fr','_json','Explore restaurants & cafes by locality','Explorez les restaurants et cafés par localité','2020-12-25 05:34:50','2020-12-25 05:36:16'),
	(415,0,'fr','_json','Restaurateurs Join Us','Les restaurateurs nous rejoignent','2020-12-25 05:35:12','2020-12-25 05:36:16'),
	(416,0,'fr','_json','Join the more than 10,000 restaurants which fill seats and manage reservations with Golo.','Rejoignez les plus de 10 000 restaurants qui remplissent les places et gèrent les réservations avec Golo.','2020-12-25 05:35:35','2020-12-25 05:36:16');

/*!40000 ALTER TABLE `ltm_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table place_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `place_translations`;

CREATE TABLE `place_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `place_translations_place_id_locale_unique` (`place_id`,`locale`),
  KEY `place_translations_locale_index` (`locale`),
  CONSTRAINT `place_translations_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `place_translations` WRITE;
/*!40000 ALTER TABLE `place_translations` DISABLE KEYS */;

INSERT INTO `place_translations` (`id`, `place_id`, `locale`, `name`, `description`)
VALUES
	(2,19,'en','Boot Café','Boot Café is an understated coffee shop on a quiet street between the busier Rue de Turenne and Boulevard Beaumarchais in Le Marais. Only postcards and photos are tacked to the walls, and the menu is limited to coffee, tea and the selection of cakes that sit under glass domes on the counter.\r\n\r\nThe name choice is as simple as its interiors: Boot Café is so-called because the space was once a shoe shop. The café retains some trappings of its former life thanks to a Cordonnerie sign painted on its fading blue façade and a large red boot trade sign hanging adjacent.'),
	(15,36,'en','The View Lounge','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.'),
	(16,37,'en','Earthbody','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.'),
	(17,38,'en','Therapy','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.'),
	(18,39,'en','The 9Streets','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.'),
	(19,40,'en','Satay Restaurant','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(20,41,'en','Le Babalou','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(21,42,'en','Flor Coffee','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(22,43,'en','La Ciccia Claimed','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(23,44,'en','Lodom Restaurant','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(24,45,'en','Ushio Ramen','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(25,46,'en','Jacob\'s Pickles','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.'),
	(30,49,'en','Torraku Ramen','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.'),
	(31,49,'fr',NULL,NULL),
	(32,37,'fr',NULL,NULL),
	(33,19,'fr',NULL,NULL),
	(34,46,'fr',NULL,NULL),
	(35,36,'fr',NULL,NULL),
	(36,38,'fr',NULL,NULL),
	(37,39,'fr',NULL,NULL),
	(38,45,'fr',NULL,NULL),
	(39,40,'fr',NULL,NULL),
	(40,44,'fr',NULL,NULL),
	(41,43,'fr',NULL,NULL),
	(42,42,'fr',NULL,NULL),
	(43,41,'fr',NULL,NULL);

/*!40000 ALTER TABLE `place_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table place_type_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `place_type_translations`;

CREATE TABLE `place_type_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place_type_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `place_type_translations_place_type_id_locale_unique` (`place_type_id`,`locale`),
  KEY `place_type_translations_locale_index` (`locale`),
  CONSTRAINT `place_type_translations_place_type_id_foreign` FOREIGN KEY (`place_type_id`) REFERENCES `place_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `place_type_translations` WRITE;
/*!40000 ALTER TABLE `place_type_translations` DISABLE KEYS */;

INSERT INTO `place_type_translations` (`id`, `place_type_id`, `locale`, `name`)
VALUES
	(1,25,'en','Margherita'),
	(2,26,'en','Pepperoni'),
	(8,32,'en','Spaghetti'),
	(9,33,'en','Sushi'),
	(10,34,'en','Tofu'),
	(12,36,'en','Soba'),
	(13,37,'en','Hamburger'),
	(14,38,'en','Sandwich'),
	(16,40,'en','Guacamole'),
	(17,41,'en','Enchiladas'),
	(18,42,'en','Tomato Salsa'),
	(19,43,'en','Pasta'),
	(20,44,'en','Panzenella'),
	(21,45,'en','Pollotarian'),
	(22,46,'en','Flexitarian'),
	(23,47,'en','Pho'),
	(26,47,'fr','Pho'),
	(27,46,'fr','Flexitarian'),
	(28,45,'fr','Pollotarian'),
	(29,44,'fr','Panzenella'),
	(30,43,'fr','Pasta'),
	(31,42,'fr','Tomato Salsa'),
	(32,38,'fr','Sandwich'),
	(33,41,'fr','Enchiladas'),
	(34,40,'fr','Guacamole'),
	(35,26,'fr','Pepperoni'),
	(36,25,'fr','Margherita'),
	(37,32,'fr','Spaghetti'),
	(38,33,'fr','Sushi'),
	(39,34,'fr','Tofu'),
	(40,36,'fr','Soba'),
	(41,37,'fr','Hamburger');

/*!40000 ALTER TABLE `place_type_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table place_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `place_types`;

CREATE TABLE `place_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `place_types` WRITE;
/*!40000 ALTER TABLE `place_types` DISABLE KEYS */;

INSERT INTO `place_types` (`id`, `category_id`, `name`, `created_at`, `updated_at`)
VALUES
	(25,11,'Restaurant','2019-10-25 11:17:39','2020-05-23 16:40:41'),
	(26,11,'Coffee Shop','2019-10-25 11:17:50','2020-05-23 16:40:32'),
	(32,21,'Market','2019-11-04 16:40:54','2020-05-23 16:41:21'),
	(33,22,'Hostel','2019-11-04 16:41:13','2020-05-23 16:55:28'),
	(34,22,'Hotel','2019-11-04 16:41:22','2020-05-23 16:55:20'),
	(36,22,'Apartment','2019-11-04 16:42:03','2020-05-23 16:54:56'),
	(37,12,'Bars','2019-11-04 16:42:21','2019-11-04 16:42:21'),
	(38,12,'Bakeries','2019-11-04 16:42:39','2019-11-04 16:42:39'),
	(40,20,NULL,'2020-05-23 15:41:43','2020-05-23 15:41:43'),
	(41,20,NULL,'2020-05-23 15:42:04','2020-05-23 15:42:04'),
	(42,20,NULL,'2020-05-23 15:42:20','2020-05-23 15:42:20'),
	(43,21,NULL,'2020-05-23 16:42:10','2020-05-23 16:42:10'),
	(44,21,NULL,'2020-05-23 16:42:28','2020-05-23 16:42:28'),
	(45,13,NULL,'2020-05-23 17:08:46','2020-05-23 17:08:46'),
	(46,13,NULL,'2020-05-23 17:09:06','2020-05-23 17:09:06'),
	(47,23,NULL,'2020-05-24 03:57:02','2020-05-24 03:57:02');

/*!40000 ALTER TABLE `place_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table places
# ------------------------------------------------------------

DROP TABLE IF EXISTS `places`;

CREATE TABLE `places` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `place_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `price_range` int(11) DEFAULT NULL,
  `amenities` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `social` varchar(500) DEFAULT '' COMMENT 'array',
  `opening_hour` varchar(500) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `gallery` longtext,
  `video` varchar(255) DEFAULT NULL,
  `booking_type` int(2) DEFAULT NULL,
  `link_bookingcom` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `menu` longtext,
  `faq` longtext,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `places` WRITE;
/*!40000 ALTER TABLE `places` DISABLE KEYS */;

INSERT INTO `places` (`id`, `user_id`, `country_id`, `city_id`, `category`, `place_type`, `name`, `slug`, `description`, `price_range`, `amenities`, `address`, `lat`, `lng`, `email`, `phone_number`, `website`, `social`, `opening_hour`, `thumb`, `gallery`, `video`, `booking_type`, `link_bookingcom`, `status`, `seo_title`, `seo_description`, `menu`, `faq`, `updated_at`, `created_at`)
VALUES
	(19,8,11,26,'[\"11\"]','[\"25\"]','Boot Café','boot-cafe','Boot Café is an understated coffee shop on a quiet street between the busier Rue de Turenne and Boulevard Beaumarchais in Le Marais. Only postcards and photos are tacked to the walls, and the menu is limited to coffee, tea and the selection of cakes that sit under glass domes on the counter.\r\n\r\nThe name choice is as simple as its interiors: Boot Café is so-called because the space was once a shoe shop. The café retains some trappings of its former life thanks to a Cordonnerie sign painted on its fading blue façade and a large red boot trade sign hanging adjacent.',2,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','42 E 20th St, New York, NY 10003, USA',40.7384607,-73.9885635,NULL,'(212) 213-4429',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"BootCaf\\u00e9\"}}','[{\"title\":\"Monday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Tuesday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Wednesday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Thursday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Friday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Saturday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Sunday\",\"value\":\"10:00 AM - 11:00 PM\"}]','5ec54e73e1b75_1589988979.jpg','[\"5ec54e684f57e_1589988968.jpeg\",\"5ec9531f7534a_1590252319.jpg\",\"5ec953293a5f0_1590252329.jpg\",\"5ec95330aef59_1590252336.jpg\"]','https://www.youtube.com/watch?v=GlrxcuEDyF8',5,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/golo_thumb1.jpg\",\"name\":\"Chiken\",\"price\":\"$12\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 07:17:13','2019-11-07 15:33:46'),
	(36,8,11,26,'[\"20\"]','[\"42\"]',NULL,'the-view-lounge',NULL,2,'[\"13\",\"11\",\"9\",\"8\",\"7\",\"6\"]','354 W 37th St, New York, NY 10018, USA',40.7549601,-73.9945963,'helo@paradiseclubnyc.com','(212) 261-5400',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"paradiseclubnyc\"}}','[{\"title\":\"Monday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Tuesday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Wednesday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Thursday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Friday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Saturday\",\"value\":\"10:00 AM - 11:00 PM\"},{\"title\":\"Sunday\",\"value\":\"10:00 AM - 11:00 PM\"}]','5fbf55e5de19e_1606374885.jpeg','[\"5fbf55cc2184d_1606374860.jpeg\",\"5fbf55d1a3d19_1606374865.jpeg\",\"5fbf55d77b72d_1606374871.jpeg\",\"5fbf55dfa0fd9_1606374879.jpeg\"]',NULL,5,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:23:28','2020-05-23 15:41:25'),
	(37,8,11,24,'[\"21\"]','[\"43\"]',NULL,'earthbody',NULL,3,'[\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','7007 Friars Rd, San Diego, CA 92108, USA',32.7681182,-117.1667284,NULL,'(619) 688-9113',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"Earthbody\"}}','[{\"title\":\"Monday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Tuesday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Wednesday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Thursday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Friday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Saturday\",\"value\":\"11:00 am - 7:00 pm\"},{\"title\":\"Sunday\",\"value\":\"11:00 am - 7:00 pm\"}]','5fbf532ec3f9e_1606374190.jpeg','[\"5fbf52e74dc04_1606374119.jpeg\",\"5fbf52f65a89e_1606374134.jpeg\",\"5fbf53042f3b9_1606374148.jpeg\",\"5fbf532b10aa6_1606374187.jpg\"]',NULL,5,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:29:08','2020-05-23 16:38:57'),
	(38,8,11,24,'[\"12\"]','[\"37\"]',NULL,'therapy',NULL,2,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','2230 Fifth Ave, San Diego, CA 92101, USA',32.7286988,-117.1604843,NULL,'(858) 888-0655',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"spakingston\"}}','[{\"title\":\"Monday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Tuesday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Wednesday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Thursday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Friday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Saturday\",\"value\":\"9:00 am - 9:00 pm\"},{\"title\":\"Sunday\",\"value\":\"9:00 am - 9:00 pm\"}]','5fbf56fa6547f_1606375162.jpeg','[\"5fbf56d7a06f4_1606375127.jpeg\",\"5fbf56e3456f4_1606375139.jpeg\",\"5fbf56ea7c85f_1606375146.jpeg\",\"5fbf56f15adbe_1606375153.jpeg\"]',NULL,5,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:22:42','2020-05-23 17:00:19'),
	(39,8,11,24,'[\"13\"]','[\"45\"]',NULL,'the-9streets',NULL,2,'[\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','2949 Garnet Ave, San Diego, CA 92109, USA',32.8064606,-117.2162461,NULL,'(858) 272-3400',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"thegym\"}}','[{\"title\":\"Monday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Tuesday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Wednesday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Thursday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Friday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Saturday\",\"value\":\"4:00 am - 12:00 am\"},{\"title\":\"Sunday\",\"value\":\"4:00 am - 12:00 am\"}]','5fbf579864dd3_1606375320.jpeg','[\"5fbf578789afe_1606375303.jpeg\",\"5fbf578edd511_1606375310.jpeg\",\"5fbf57924e6e7_1606375314.jpeg\",\"5fbf57964cbba_1606375318.jpeg\"]',NULL,5,NULL,1,NULL,NULL,'[{\"thumb\":null,\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":null,\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":null,\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":null,\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":null,\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":null,\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:22:21','2020-05-23 17:07:55'),
	(40,8,11,24,'[\"22\"]','[\"34\"]',NULL,'satay-restaurant',NULL,2,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','44 Pacific Hwy, San Diego, CA 92110, USA',32.7518871,-117.2006589,'hello@oldtown-inn.com','(619) 260-8024',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"oldtown-inn\"}}','[{\"title\":\"Monday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Tuesday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Wednesday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Thursday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Friday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Saturday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Sunday\",\"value\":\"12:00 am - 11:59 pm\"}]','5fbf59c4b9fa0_1606375876.jpeg','[\"5fbf596c47655_1606375788.jpeg\",\"5fbf5973470d4_1606375795.jpeg\",\"5fbf59863dca7_1606375814.jpeg\",\"5fbf59b75894b_1606375863.jpeg\"]',NULL,4,'https://www.booking.com/?aid=1266181',1,NULL,NULL,'[]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 08:18:03','2020-05-24 03:52:14'),
	(41,8,11,24,'[\"21\"]','[\"47\"]',NULL,'le-babalou',NULL,1,'[\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','115 E 17th St, National City, CA 91950, USA',32.6685948,-117.1025237,'hello@valueautorepair.org','(619) 760-9152',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"valueautorepair\"}}','[{\"title\":\"Monday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Tuesday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Wednesday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Thursday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Friday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Saturday\",\"value\":\"8:00 am - 5:00 pm\"},{\"title\":\"Sunday\",\"value\":\"8:00 am - 5:00 pm\"}]','5fbf5ef883695_1606377208.jpeg','[\"5fbf5e80bd4b5_1606377088.jpeg\",\"5fbf5e86d2360_1606377094.jpeg\",\"5fbf5e8c6b760_1606377100.jpeg\",\"5fbf5e9586135_1606377109.jpeg\"]',NULL,2,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[]','2020-12-25 04:53:55','2020-05-24 03:56:44'),
	(42,8,11,26,'[\"22\"]','[\"33\"]',NULL,'flor-coffee',NULL,2,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','95 W Broadway, New York, NY 10007, USA',40.715475,-74.008909,'hi@frederickhotelnyc.com','(212) 566-1900',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"frederickhotel\"}}','[{\"title\":\"Monday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Tuesday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Wednesday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Thursday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Friday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Saturday\",\"value\":\"12:00 am - 11:59 pm\"},{\"title\":\"Sunday\",\"value\":\"12:00 am - 11:59 pm\"}]','5fbf5e21cca7e_1606376993.jpeg','[\"5fbf5de83274c_1606376936.jpeg\",\"5fbf5dee3a2aa_1606376942.jpeg\",\"5fbf5df5706f5_1606376949.jpeg\",\"5fbf5e077ce1b_1606376967.jpeg\"]',NULL,5,'https://www.booking.com/?aid=1266181',1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:20:35','2020-05-24 04:14:20'),
	(43,8,11,26,'[\"12\"]','[\"37\"]',NULL,'la-ciccia-claimed',NULL,2,'[\"11\",\"10\",\"8\",\"7\",\"6\"]','684 6th Ave 2nd floor, New York, NY 10010, USA',40.7418154,-73.9931724,'hello@vivibodyspa.com','(646) 537-0117',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"vivibodyspa\"}}','[{\"title\":\"Monday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Tuesday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Wednesday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Thursday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Friday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Saturday\",\"value\":\"10:00 am - 12:00 am\"},{\"title\":\"Sunday\",\"value\":\"10:00 am - 12:00 am\"}]','5fbf5d43eb5fc_1606376771.jpeg','[\"5fbf5d13029e7_1606376723.jpeg\",\"5fbf5d1943921_1606376729.jpeg\",\"5fbf5d28f39f0_1606376744.jpeg\",\"5fbf5d3147540_1606376753.jpeg\"]',NULL,5,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-08 16:20:02','2020-05-24 04:20:49'),
	(44,8,11,26,'[\"21\"]','[\"32\"]',NULL,'lodom-restaurant',NULL,2,'[\"11\",\"10\",\"8\",\"6\"]','55 Richmond Terrace, Staten Island, NY 10301, USA',40.6444964,-74.0749214,'hi@empireoutlets.nyc','(718) 422-9999',NULL,'[{\"name\":\"Facebook\",\"url\":null}]','[{\"title\":\"Monday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Tuesday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Wednesday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Thursday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Friday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Saturday\",\"value\":\"10:00 am - 9:00 pm\"},{\"title\":\"Sunday\",\"value\":\"10:00 am - 9:00 pm\"}]','5fbf5c368de97_1606376502.jpeg','[\"5fbf5c15ed369_1606376469.jpeg\",\"5fbf5c1b395e8_1606376475.jpeg\",\"5fbf5c210070a_1606376481.jpeg\",\"5fbf5c3264569_1606376498.jpeg\"]',NULL,4,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 07:24:56','2020-05-24 04:35:03'),
	(45,8,11,26,'[\"23\"]','[\"47\"]',NULL,'ushio-ramen',NULL,1,'[\"11\",\"10\",\"9\",\"8\",\"6\"]','19017 Station Rd, Flushing, NY 11358, USA',40.7611168,-73.7910234,'contact@petroneauto.com','(718) 939-8200',NULL,'[{\"name\":\"Instagram\",\"url\":\"UshioRamen\"}]','[{\"title\":\"Monday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Tuesday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Wednesday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Thursday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Friday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Saturday\",\"value\":\"10:00 am - 5:30 pm\"},{\"title\":\"Sunday\",\"value\":\"8:00 am - 5:00 pm\"}]','5fbf58c0676a6_1606375616.jpeg','[\"5fbf58afe34f6_1606375599.jpeg\",\"5fbf58b5292f3_1606375605.jpeg\",\"5fbf58b8e2e80_1606375608.jpeg\",\"5fbf58bd1c56e_1606375613.jpeg\"]',NULL,3,'https://www.opentable.com/',1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 05:04:17','2020-05-24 04:40:40'),
	(46,8,11,31,'[\"11\"]','[\"25\"]',NULL,'jacobs-pickles',NULL,3,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','1313 Park Blvd, San Diego, CA 92101, USA',32.7175697,-117.1508543,NULL,'(212) 470-5566',NULL,'{\"1\":{\"name\":\"Instagram\",\"url\":\"jacobs\"}}','[{\"title\":\"Monday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Tuesday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Wednesday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Thursday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Friday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Saturday\",\"value\":\"10:00 am - 12:30 am\"},{\"title\":\"Sunday\",\"value\":\"10:00 am - 12:30 am\"}]','5ec9fc06a9a57_1590295558.jpg','[\"5ec9fbe195d03_1590295521.jpg\",\"5ec9fbeb991bc_1590295531.jpg\",\"5ec9fbf3dffc6_1590295539.jpg\",\"5ec9fbf86de62_1590295544.jpg\"]',NULL,2,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact  $9\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact  $9\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact  $9\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact  $9\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact  $9\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact  $9\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 08:07:13','2020-05-24 04:45:58'),
	(49,8,11,31,'[\"21\"]','[\"32\"]',NULL,'torraku-ramen',NULL,2,'[\"13\",\"11\",\"10\",\"9\",\"8\",\"7\",\"6\"]','7007 Friars Rd, San Diego, CA 92108, USA',32.7682239,-117.1668349,NULL,'+81337120819',NULL,'[{\"name\":\"Facebook\",\"url\":null}]','[{\"title\":\"Monday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Tuesday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Wednesday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Thursday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Friday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Saturday\",\"value\":\"8:00 - 22:00\"},{\"title\":\"Sunday\",\"value\":\"8:00 - 22:00\"}]','5fbf503ca6f4e_1606373436.jpg','[\"5eea56091f380_1592415753.jpg\",\"5fbf50335e7f0_1606373427.jpg\",\"5fbf5037e583a_1606373431.jpg\"]',NULL,1,NULL,1,NULL,NULL,'[{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/mon\\/chicken-140x140.jpeg\",\"name\":\"Chiken\",\"price\":\"$23\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/salad-140x140.jpg\",\"name\":\"Salad\",\"price\":\"$10\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/pasta-140x140.jpg\",\"name\":\"Pasta Scramble\",\"price\":\"$15\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/noodles-140x140.jpg\",\"name\":\"Noodles\",\"price\":\"$13\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/meat-140x140.jpeg\",\"name\":\"Fresh Meat\",\"price\":\"$22\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1520218576172-c1a2df3fa5fc-140x140.jpeg\",\"name\":\"Vegetarian Soup\",\"price\":\"$21\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/photo-1574126154517-d1e0d89ef734-140x140.jpeg\",\"name\":\"Pizza\",\"price\":\"$34\",\"description\":\"It is a long established fact\"},{\"thumb\":\"https:\\/\\/lara-restaurant.getgolo.com\\/uploads\\/photos\\/8\\/in-this-photo-illustration-an-impossible-whopper-sits-on-a-news-photo-1134335293-1556554175-140x140.jpg\",\"name\":\"Nasi Goreng\",\"price\":\"$17\",\"description\":\"It is a long established fact\"}]','[{\"question\":\"How is this business handling reopening?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"Does the Sesame Meatless Chicken come with Broccoli?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"},{\"question\":\"How is this business operating during COVID-19?\",\"answer\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\"}]','2020-12-25 04:58:00','2020-06-17 17:42:37');

/*!40000 ALTER TABLE `places` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table post_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post_translations`;

CREATE TABLE `post_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_translations_post_id_locale_unique` (`post_id`,`locale`),
  KEY `post_translations_locale_index` (`locale`),
  CONSTRAINT `post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `post_translations` WRITE;
/*!40000 ALTER TABLE `post_translations` DISABLE KEYS */;

INSERT INTO `post_translations` (`id`, `post_id`, `locale`, `title`, `content`)
VALUES
	(1,10,'en','About Us','<div class=\"company-info flex-inline\"><img src=\"https://lara.getgolo.com/assets/images/about-02.jpg\" alt=\"Our Company\" />\r\n<div class=\"ci-content\">Our Company\r\n<h2>Mission statement</h2>\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n</div>\r\n</div>\r\n<!-- .company-info -->\r\n<div class=\"our-team\">\r\n<div class=\"container\">\r\n<h2 class=\"title align-center\">Meet Our Team</h2>\r\n</div>\r\n<div class=\"ot-content grid grid-4\">\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-1.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Jaspreet Bhamrai</h3>\r\n<span class=\"job\">Co - founder</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-2.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Justine Robinson</h3>\r\n<span class=\"job\">Marketing Guru</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-3.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Jeremías Romero</h3>\r\n<span class=\"job\">Designer</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-4.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Rutherford Brannan</h3>\r\n<span class=\"job\">Mobile developer</span></div>\r\n</div>\r\n</div>\r\n<!-- .ot-content --></div>\r\n<!-- .our-team -->\r\n<div class=\"join-team align-center\">\r\n<div class=\"container\">\r\n<h2 class=\"title\">Join our team</h2>\r\n<div class=\"jt-content\">\r\n<p>We’re always looking for talented individuals and <br />people who are hungry to do great work.</p>\r\n<a class=\"btn\" title=\"View openings\" href=\"#\">View openings</a></div>\r\n</div>\r\n</div>\r\n<!-- .join-team -->'),
	(2,11,'en','Faqs','<h2 class=\"title align-center\">How may we be of help?</h2>\r\n<ul class=\"accordion first-open\">\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">What is Golo Theme?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">Why should I save on Schoolable?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How secure is my money?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How much can I save on Golo?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How many saving plans can I create?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n</ul>'),
	(3,13,'en','Deep dish s’mores bowls for two','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec odio nulla. Donec sed eros ut erat finibus pharetra. Vivamus quis rhoncus felis, ut euismod dolor. Aliquam in ante eget leo cursus mattis vel non est. Vestibulum non purus elementum, placerat quam at, interdum lectus. In erat mi, tincidunt a congue at, pulvinar eu sapien. Etiam placerat efficitur arcu nec tincidunt.</p>\r\n<p>Nullam egestas risus risus. In ac maximus metus. Morbi fermentum justo quis varius dictum. Cras laoreet dolor sit amet arcu auctor, in consectetur lectus luctus. Pellentesque luctus est eget sapien luctus, at convallis diam hendrerit.</p>\r\n<h2>Cras laoreet dolor sit amet</h2>\r\n<p>In magna tortor, facilisis vel finibus quis, placerat eget lacus. Mauris iaculis diam augue, non fringilla libero tincidunt a. In quis felis finibus, ultricies eros ut, tincidunt tortor. Etiam non semper dolor, eget iaculis mauris. Nulla quis purus gravida urna maximus tincidunt vulputate interdum massa. Quisque tellus est, ultricies nec lorem eget, sagittis tincidunt ipsum. Cras laoreet a ligula non laoreet. Vestibulum elementum quam lacinia sapien semper interdum.</p>\r\n<blockquote class=\"wp-block-quote\">\r\n<p><em>Nullam facilisis ipsum nec eros vestibulum sollicitudin. Maecenas sed odio a lorem scelerisque consectetur. Aliquam accumsan dui elit, in vulputate nisl aliquam non. Donec iaculis mauris nulla, eleifend auctor nisi commodo eget.</em></p>\r\n<cite>&nbsp;Famous Thinker</cite></blockquote>\r\n<blockquote class=\"wp-block-quote\"><cite>Donec nec convallis ligula, eu bibendum lorem. Etiam et molestie ex. Mauris placerat libero sed ipsum efficitur elementum. Vivamus sapien sem, lacinia vitae tortor quis, egestas cursus magna. Phasellus consequat nibh lorem, ac egestas justo commodo et. Quisque ac ligula semper, maximus sem rutrum, placerat velit. Aenean dignissim suscipit enim, quis posuere nulla sodales nec. Sed vitae felis a leo faucibus congue in vel ex.</cite></blockquote>'),
	(4,14,'en','Where to Eat in New York: A Complete Guide','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec odio nulla. Donec sed eros ut erat finibus pharetra. Vivamus quis rhoncus felis, ut euismod dolor. Aliquam in ante eget leo cursus mattis vel non est. Vestibulum non purus elementum, placerat quam at, interdum lectus. In erat mi, tincidunt a congue at, pulvinar eu sapien. Etiam placerat efficitur arcu nec tincidunt.</p>\r\n<p>Nullam egestas risus risus. In ac maximus metus. Morbi fermentum justo quis varius dictum. Cras laoreet dolor sit amet arcu auctor, in consectetur lectus luctus. Pellentesque luctus est eget sapien luctus, at convallis diam hendrerit.</p>\r\n<figure class=\"wp-block-image\"><img class=\"wp-image-178\" src=\"https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-1024x683.jpeg\" sizes=\"(max-width: 1024px) 100vw, 1024px\" srcset=\"https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-1024x683.jpeg 1024w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-600x400.jpeg 600w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-300x200.jpeg 300w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-768x512.jpeg 768w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897.jpeg 1650w\" alt=\"\" /></figure>\r\n<h2>Cras laoreet dolor sit amet</h2>\r\n<p>In magna tortor, facilisis vel finibus quis, placerat eget lacus. Mauris iaculis diam augue, non fringilla libero tincidunt a. In quis felis finibus, ultricies eros ut, tincidunt tortor. Etiam non semper dolor, eget iaculis mauris. Nulla quis purus gravida urna maximus tincidunt vulputate interdum massa. Quisque tellus est, ultricies nec lorem eget, sagittis tincidunt ipsum. Cras laoreet a ligula non laoreet. Vestibulum elementum quam lacinia sapien semper interdum.</p>'),
	(5,15,'en','America’s 38 Essential Restaurants','<p>Aside from a few forays to France, the furthest my maternal grandparents travelled was Pembrokeshire, Wales (repeat visits to a wind-buffeted static caravan in Croes-goch, if you must know). Just a generation later, my parents&rsquo; peregrinations had encompassed most of Western Europe.</p>\r\n<p><img src=\"/storage/photos/8/photo-1495562569060-2eec283d3391.jpeg\" alt=\"\" /></p>\r\n<p>As of writing, I&rsquo;ve visited about 50 countries (I counted them up once, but have forgotten the total), most of them during two spells of backpacking &ndash; first across the US, then around the world &ndash; plus others as and when the opportunity arose.</p>\r\n<p>My wife has been to twice that number of destinations, and I&rsquo;d wager that a significant proportion of the people who comprise Lonely Planet&rsquo;s extended community &ndash; staff and contributors, followers and fans &ndash; have led equally footloose lives.</p>\r\n<p>The trend continues, too: my son, four, and daughter, one, have already visited many more places than my grandparents did in their entire lives. In fact, Harvey probably covered more miles&nbsp;<em>in utero</em>&nbsp;than they managed in total.</p>\r\n<figure class=\"wp-block-image\"><img class=\"wp-image-120\" src=\"https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-1024x656.jpg\" sizes=\"(max-width: 1024px) 100vw, 1024px\" srcset=\"https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-1024x656.jpg 1024w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-600x384.jpg 600w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-300x192.jpg 300w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-768x492.jpg 768w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama.jpg 2048w\" alt=\"\" />\r\n<figcaption>Caption of Image</figcaption>\r\n</figure>\r\n<h4>Our expanding horizons</h4>\r\n<p>You can visualise each generation&rsquo;s expanding horizons as a series of concentric circles, like ripples spreading out from a stone dropped in a pond; assuming that trend doesn&rsquo;t go into reverse (which is possible, of course, given variables like climate change), where will the edge of my children&rsquo;s known universe lie? Just as I have explored the far side of this planet, might they explore the far side of another world?</p>\r\n<p>It&rsquo;s not as far-fetched as it sounds. As it often does, the stuff of science fiction has become the stuff of science fact: the race for space is more competitive now than it has been at any time since Neil Armstrong took that famous first step on the surface of the Moon, an epoch-defining moment that happened 50 years ago this July.</p>'),
	(6,15,'fr',NULL,NULL),
	(7,13,'fr',NULL,NULL);

/*!40000 ALTER TABLE `post_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(500) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `thumb` varchar(255) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `user_id`, `category`, `title`, `slug`, `content`, `thumb`, `type`, `status`, `seo_title`, `seo_description`, `created_at`, `updated_at`)
VALUES
	(10,8,NULL,'About Us','about-us','<div class=\"company-info flex-inline\"><img src=\"https://lara.getgolo.com/assets/images/about-02.jpg\" alt=\"Our Company\" />\r\n<div class=\"ci-content\">Our Company\r\n<h2>Mission statement</h2>\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n</div>\r\n</div>\r\n<!-- .company-info -->\r\n<div class=\"our-team\">\r\n<div class=\"container\">\r\n<h2 class=\"title align-center\">Meet Our Team</h2>\r\n</div>\r\n<div class=\"ot-content grid grid-4\">\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-1.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Jaspreet Bhamrai</h3>\r\n<span class=\"job\">Co - founder</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-2.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Justine Robinson</h3>\r\n<span class=\"job\">Marketing Guru</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-3.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Jeremías Romero</h3>\r\n<span class=\"job\">Designer</span></div>\r\n</div>\r\n<div class=\"grid-item ot-item hover__box\">\r\n<div class=\"hover__box__thumb\"><img src=\"https://lara.getgolo.com/assets/images/people-4.jpg\" alt=\"\" /></div>\r\n<div class=\"ot-info\">\r\n<h3>Rutherford Brannan</h3>\r\n<span class=\"job\">Mobile developer</span></div>\r\n</div>\r\n</div>\r\n<!-- .ot-content --></div>\r\n<!-- .our-team -->\r\n<div class=\"join-team align-center\">\r\n<div class=\"container\">\r\n<h2 class=\"title\">Join our team</h2>\r\n<div class=\"jt-content\">\r\n<p>We’re always looking for talented individuals and <br />people who are hungry to do great work.</p>\r\n<a class=\"btn\" title=\"View openings\" href=\"#\">View openings</a></div>\r\n</div>\r\n</div>\r\n<!-- .join-team -->','5df473fb078bd_1576301563.jpg','page',1,NULL,NULL,'2019-11-27 09:04:37','2019-12-14 05:32:43'),
	(11,8,NULL,'Faqs','faqs','<h2 class=\"title align-center\">How may we be of help?</h2>\r\n<ul class=\"accordion first-open\">\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">What is Golo Theme?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">Why should I save on Schoolable?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How secure is my money?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How much can I save on Golo?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n<li>\r\n<h3 class=\"accordion-title\"><a href=\"#\">How many saving plans can I create?</a></h3>\r\n<div class=\"accordion-content\">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>\r\n</div>\r\n</li>\r\n</ul>',NULL,'page',1,NULL,NULL,'2019-12-21 07:49:42','2019-12-21 07:49:42'),
	(13,8,'[\"17\"]','My Story When I Backpacked Around The World','deep-dish-smores-bowls-for-two','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec odio nulla. Donec sed eros ut erat finibus pharetra. Vivamus quis rhoncus felis, ut euismod dolor. Aliquam in ante eget leo cursus mattis vel non est. Vestibulum non purus elementum, placerat quam at, interdum lectus. In erat mi, tincidunt a congue at, pulvinar eu sapien. Etiam placerat efficitur arcu nec tincidunt.</p>\r\n<p>Nullam egestas risus risus. In ac maximus metus. Morbi fermentum justo quis varius dictum. Cras laoreet dolor sit amet arcu auctor, in consectetur lectus luctus. Pellentesque luctus est eget sapien luctus, at convallis diam hendrerit.</p>\r\n<h2>Cras laoreet dolor sit amet</h2>\r\n<p>In magna tortor, facilisis vel finibus quis, placerat eget lacus. Mauris iaculis diam augue, non fringilla libero tincidunt a. In quis felis finibus, ultricies eros ut, tincidunt tortor. Etiam non semper dolor, eget iaculis mauris. Nulla quis purus gravida urna maximus tincidunt vulputate interdum massa. Quisque tellus est, ultricies nec lorem eget, sagittis tincidunt ipsum. Cras laoreet a ligula non laoreet. Vestibulum elementum quam lacinia sapien semper interdum.</p>\r\n<blockquote class=\"wp-block-quote\">\r\n<p><em>Nullam facilisis ipsum nec eros vestibulum sollicitudin. Maecenas sed odio a lorem scelerisque consectetur. Aliquam accumsan dui elit, in vulputate nisl aliquam non. Donec iaculis mauris nulla, eleifend auctor nisi commodo eget.</em></p>\r\n<cite> Famous Thinker</cite></blockquote>\r\n<blockquote class=\"wp-block-quote\"><cite>Donec nec convallis ligula, eu bibendum lorem. Etiam et molestie ex. Mauris placerat libero sed ipsum efficitur elementum. Vivamus sapien sem, lacinia vitae tortor quis, egestas cursus magna. Phasellus consequat nibh lorem, ac egestas justo commodo et. Quisque ac ligula semper, maximus sem rutrum, placerat velit. Aenean dignissim suscipit enim, quis posuere nulla sodales nec. Sed vitae felis a leo faucibus congue in vel ex.</cite></blockquote>','5fbf60eecc523_1606377710.jpeg','blog',1,NULL,NULL,'2020-01-11 06:58:53','2020-11-26 08:01:50'),
	(14,8,'[\"18\"]','Where to Eat in Paris: A Complete Guide','where-to-eat-in-new-york-a-complete-guide','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec odio nulla. Donec sed eros ut erat finibus pharetra. Vivamus quis rhoncus felis, ut euismod dolor. Aliquam in ante eget leo cursus mattis vel non est. Vestibulum non purus elementum, placerat quam at, interdum lectus. In erat mi, tincidunt a congue at, pulvinar eu sapien. Etiam placerat efficitur arcu nec tincidunt.</p>\r\n<p>Nullam egestas risus risus. In ac maximus metus. Morbi fermentum justo quis varius dictum. Cras laoreet dolor sit amet arcu auctor, in consectetur lectus luctus. Pellentesque luctus est eget sapien luctus, at convallis diam hendrerit.</p>\r\n<figure class=\"wp-block-image\"><img class=\"wp-image-178\" src=\"https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-1024x683.jpeg\" sizes=\"(max-width: 1024px) 100vw, 1024px\" srcset=\"https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-1024x683.jpeg 1024w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-600x400.jpeg 600w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-300x200.jpeg 300w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897-768x512.jpeg 768w, https://wp.getgolo.com/wp-content/uploads/2019/10/photo-1567529692333-de9fd6772897.jpeg 1650w\" alt=\"\" /></figure>\r\n<h2>Cras laoreet dolor sit amet</h2>\r\n<p>In magna tortor, facilisis vel finibus quis, placerat eget lacus. Mauris iaculis diam augue, non fringilla libero tincidunt a. In quis felis finibus, ultricies eros ut, tincidunt tortor. Etiam non semper dolor, eget iaculis mauris. Nulla quis purus gravida urna maximus tincidunt vulputate interdum massa. Quisque tellus est, ultricies nec lorem eget, sagittis tincidunt ipsum. Cras laoreet a ligula non laoreet. Vestibulum elementum quam lacinia sapien semper interdum.</p>','5ec9f7939eb95_1590294419.jpeg','blog',1,NULL,NULL,'2020-01-11 07:01:15','2020-05-24 04:29:15'),
	(15,8,'[\"15\"]','Wonderings: are the stars our destination?','americas-38-essential-restaurants','<p>Aside from a few forays to France, the furthest my maternal grandparents travelled was Pembrokeshire, Wales (repeat visits to a wind-buffeted static caravan in Croes-goch, if you must know). Just a generation later, my parents&rsquo; peregrinations had encompassed most of Western Europe.</p>\r\n<p><img src=\"/storage/photos/8/photo-1495562569060-2eec283d3391.jpeg\" alt=\"\" /></p>\r\n<p>As of writing, I&rsquo;ve visited about 50 countries (I counted them up once, but have forgotten the total), most of them during two spells of backpacking &ndash; first across the US, then around the world &ndash; plus others as and when the opportunity arose.</p>\r\n<p>My wife has been to twice that number of destinations, and I&rsquo;d wager that a significant proportion of the people who comprise Lonely Planet&rsquo;s extended community &ndash; staff and contributors, followers and fans &ndash; have led equally footloose lives.</p>\r\n<p>The trend continues, too: my son, four, and daughter, one, have already visited many more places than my grandparents did in their entire lives. In fact, Harvey probably covered more miles&nbsp;<em>in utero</em>&nbsp;than they managed in total.</p>\r\n<figure class=\"wp-block-image\"><img class=\"wp-image-120\" src=\"https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-1024x656.jpg\" sizes=\"(max-width: 1024px) 100vw, 1024px\" srcset=\"https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-1024x656.jpg 1024w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-600x384.jpg 600w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-300x192.jpg 300w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama-768x492.jpg 768w, https://wp.getgolo.com/wp-content/uploads/2019/10/the-16-copper-statues-which-fbfe-diaporama.jpg 2048w\" alt=\"\" />\r\n<figcaption>Caption of Image</figcaption>\r\n</figure>\r\n<h4>Our expanding horizons</h4>\r\n<p>You can visualise each generation&rsquo;s expanding horizons as a series of concentric circles, like ripples spreading out from a stone dropped in a pond; assuming that trend doesn&rsquo;t go into reverse (which is possible, of course, given variables like climate change), where will the edge of my children&rsquo;s known universe lie? Just as I have explored the far side of this planet, might they explore the far side of another world?</p>\r\n<p>It&rsquo;s not as far-fetched as it sounds. As it often does, the stuff of science fiction has become the stuff of science fact: the race for space is more competitive now than it has been at any time since Neil Armstrong took that famous first step on the surface of the Moon, an epoch-defining moment that happened 50 years ago this July.</p>','5fbf61036d16c_1606377731.jpeg','blog',1,NULL,NULL,'2020-01-11 07:03:48','2020-11-26 08:03:13');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `score` float DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;

INSERT INTO `reviews` (`id`, `user_id`, `place_id`, `score`, `comment`, `status`, `created_at`, `updated_at`)
VALUES
	(5,8,23,5,'Great route. Too fast English delivery. So much traffic that the guide description first match to visiting places at time. Frequent buses and helpful employees. Over all time well spent.',1,'2019-12-14 01:36:33','2019-12-17 11:47:25'),
	(6,8,24,5,'Great route. Too fast English delivery. So much traffic that the guide description first match to visiting places at time. Frequent buses and helpful employees. Over all time well spent.',1,'2019-12-14 01:36:57','2019-12-14 01:36:57'),
	(7,8,22,5,'Great route. Too fast English delivery. So much traffic that the guide description first match to visiting places at time. Frequent buses and helpful employees. Over all time well spent.',1,'2019-12-14 01:38:09','2019-12-14 01:38:09'),
	(17,8,21,5,'Excellent service and awesome food. Truly a 5 star restaurant. Service is seamless and spot on. Food was prepared perfectly.',1,'2019-12-14 10:59:30','2019-12-14 10:59:30'),
	(23,8,17,5,'Excellent service and awesome food. Truly a 5 star restaurant. Service is seamless and spot on. Food was prepared perfectly.',1,'2019-12-14 11:01:44','2019-12-14 11:01:44'),
	(25,8,19,5,'Excellent service and awesome food. Truly a 5 star restaurant. Service is seamless and spot on. Food was prepared perfectly.',1,'2019-12-14 11:02:07','2019-12-14 11:02:07'),
	(26,8,20,5,'Excellent service and awesome food. Truly a 5 star restaurant. Service is seamless and spot on. Food was prepared perfectly.',1,'2019-12-14 11:02:19','2019-12-14 11:02:19'),
	(27,8,16,5,'Excellent service and awesome food. Truly a 5 star restaurant. Service is seamless and spot on. Food was prepared perfectly.',1,'2019-12-14 11:02:35','2019-12-14 11:02:35'),
	(29,8,27,5,'The location was near the subway, metro, & train stations. It also had excellent access to all kinds of shopping & good restaurants.',1,'2019-12-14 11:04:25','2019-12-14 11:04:25'),
	(30,8,28,5,'The location was near the subway, metro, & train stations. It also had excellent access to all kinds of shopping & good restaurants.',1,'2019-12-14 11:04:38','2019-12-14 11:04:38'),
	(32,8,36,5,'I got take away order from here and was satisfied with their food. Thanks for your service during this epidemic.',1,'2020-06-11 03:37:16','2020-06-11 03:37:16'),
	(33,8,37,5,'Cool shopping mall in Japantown with quite a few of the essentials.  A Nijiya supermarket, gift shops, desserts, pastries, and a bunch of restaurants.',1,'2020-06-11 03:38:53','2020-06-11 03:38:53'),
	(34,8,38,5,'The entire office staff is also really friendly and making appointments is fairly easy.  You can also conveniently receive text notifications should you opt into it.',1,'2020-06-11 03:40:11','2020-06-11 03:40:11');

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `val` text COLLATE utf8mb4_unicode_ci,
  `type` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `val`, `type`, `created_at`, `updated_at`)
VALUES
	(11,'app_name','Golo - Restaurant Listing Laravel Theme','string','2019-12-18 00:53:47','2020-11-26 04:39:06'),
	(13,'logo','5f13d225080e9_1595134501.png','image','2019-12-18 00:55:23','2020-07-19 04:55:01'),
	(14,'email_system','hello@uxper.co','string','2019-12-21 03:18:55','2020-02-10 18:50:43'),
	(15,'ads_sidebar_banner_link','https://getyourguide.com','string','2019-12-21 03:18:55','2020-06-17 15:39:35'),
	(16,'ads_sidebar_banner_image','5ec9f126a2db1_1590292774.jpg','image','2019-12-21 03:19:03','2020-05-24 03:59:34'),
	(17,'home_description','Golo is a Laravel Theme to build a Business Listing, Restaurant Listing, City Travel Guide website that shows interesting places of the city with description and some attributes.','string','2020-05-04 15:54:45','2020-11-26 04:39:06'),
	(18,'mail_driver','smtp','string','2020-05-04 15:54:45','2020-05-04 15:54:45'),
	(19,'mail_host','smtp.googlemail.com','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(20,'mail_port','465','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(21,'mail_username','minhthend@gmail.com','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(22,'mail_password','blsdxvmscyuecjag','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(23,'mail_encryption','ssl','string','2020-05-04 15:54:45','2020-08-10 15:44:28'),
	(24,'mail_from_address','hello@uxper.co','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(25,'mail_from_name','uxper','string','2020-05-04 15:54:45','2020-06-17 04:48:36'),
	(26,'facebook_app_id','2599500287035694','string','2020-05-04 15:54:45','2020-06-19 15:38:56'),
	(27,'facebook_app_secret','50a825790110a46cc4798b7c494e0c8f','string','2020-05-04 15:54:45','2020-06-19 15:38:56'),
	(28,'google_app_id','1030498997640-437od1mjm66j1i8kn3vi23ivjb0oapgc.apps.googleusercontent.com','string','2020-05-04 15:54:45','2020-06-19 15:25:41'),
	(29,'google_app_secret','-DxAH6MaEnOH-TpCSgEE35rW','string','2020-05-04 15:54:45','2020-06-19 15:25:41'),
	(30,'goolge_map_api_key','AIzaSyBvPDNG6pePr9iFpeRKaOlaZF_l0oT3lWk','string','2020-05-04 15:54:45','2020-06-16 16:03:18'),
	(31,'style_rtl','0','string','2020-05-08 15:40:43','2020-08-28 09:23:47'),
	(32,'home_banner','5fd1905774bc4_1607569495.jpeg','image','2020-05-24 03:59:34','2020-12-10 03:04:55'),
	(33,'home_banner_app','5fd191198ce6a_1607569689.jpg','image','2020-05-24 03:59:34','2020-12-10 03:08:09'),
	(34,'tenplate','0','string','2020-06-10 04:25:38','2020-06-10 04:25:38'),
	(35,'tenplate_detail','0','string','2020-06-10 04:25:38','2020-06-17 04:08:07'),
	(36,'template','03','string','2020-06-18 03:07:25','2020-12-25 05:29:37');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table social_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `social_accounts`;

CREATE TABLE `social_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `social_accounts` WRITE;
/*!40000 ALTER TABLE `social_accounts` DISABLE KEYS */;

INSERT INTO `social_accounts` (`user_id`, `provider_user_id`, `provider`, `created_at`, `updated_at`)
VALUES
	(17,'1558327657668482','facebook','2020-06-19 15:39:39','2020-06-19 15:39:39'),
	(17,'106673868543748156803','google','2020-06-19 15:40:19','2020-06-19 15:40:19'),
	(18,'113023046359481981906','google','2020-06-19 15:41:15','2020-06-19 15:41:15'),
	(19,'106302961557738356825','google','2020-06-24 02:49:51','2020-06-24 02:49:51'),
	(21,'10158623270604448','facebook','2020-06-24 08:20:57','2020-06-24 08:20:57'),
	(22,'1998443056955443','facebook','2020-06-24 09:14:34','2020-06-24 09:14:34'),
	(23,'118208363000394944367','google','2020-06-24 14:06:21','2020-06-24 14:06:21'),
	(24,'102583064936404232092','google','2020-06-24 20:03:39','2020-06-24 20:03:39'),
	(25,'101325606659252170650','google','2020-06-24 21:29:04','2020-06-24 21:29:04'),
	(27,'2577741242477768','facebook','2020-06-25 01:10:40','2020-06-25 01:10:40'),
	(29,'109017220359948416757','google','2020-06-25 10:16:08','2020-06-25 10:16:08'),
	(30,'101752811716609868813','google','2020-06-25 18:55:25','2020-06-25 18:55:25'),
	(31,'110703018728520365226','google','2020-06-25 19:54:37','2020-06-25 19:54:37'),
	(32,'103798961282560446235','google','2020-06-26 06:54:22','2020-06-26 06:54:22'),
	(34,'107541307661762765473','google','2020-06-26 13:49:08','2020-06-26 13:49:08'),
	(35,'112949568785804911648','google','2020-06-26 20:58:02','2020-06-26 20:58:02'),
	(37,'108997158218867970276','google','2020-06-27 11:36:37','2020-06-27 11:36:37'),
	(38,'10163720391025111','facebook','2020-06-27 21:09:07','2020-06-27 21:09:07'),
	(39,'105438075793007607951','google','2020-06-28 12:44:35','2020-06-28 12:44:35'),
	(40,'110523188299399488462','google','2020-06-28 18:13:40','2020-06-28 18:13:40'),
	(41,'108855050512903350207','google','2020-06-29 17:39:06','2020-06-29 17:39:06'),
	(42,'2623377144589959','facebook','2020-06-29 20:24:37','2020-06-29 20:24:37'),
	(43,'113143130518520701066','google','2020-06-30 00:11:37','2020-06-30 00:11:37'),
	(44,'3397189033659236','facebook','2020-06-30 07:57:49','2020-06-30 07:57:49'),
	(45,'112612749084316779814','google','2020-06-30 20:08:02','2020-06-30 20:08:02'),
	(46,'108571435192837405542','google','2020-07-01 00:35:39','2020-07-01 00:35:39'),
	(48,'3223159117744914','facebook','2020-07-01 08:50:40','2020-07-01 08:50:40'),
	(49,'113987047815111696496','google','2020-07-01 09:57:46','2020-07-01 09:57:46'),
	(50,'930248077490546','facebook','2020-07-01 16:59:00','2020-07-01 16:59:00'),
	(51,'1920144224782979','facebook','2020-07-01 17:38:57','2020-07-01 17:38:57'),
	(52,'106055794661062331972','google','2020-07-01 19:14:11','2020-07-01 19:14:11'),
	(54,'673154136600020','facebook','2020-07-02 17:51:02','2020-07-02 17:51:02'),
	(55,'115879925177635582858','google','2020-07-03 04:58:06','2020-07-03 04:58:06'),
	(56,'114231441183692321431','google','2020-07-03 13:50:46','2020-07-03 13:50:46'),
	(58,'109937795679593141343','google','2020-07-05 19:35:23','2020-07-05 19:35:23'),
	(59,'103367187563342176463','google','2020-07-08 17:03:51','2020-07-08 17:03:51'),
	(62,'112920893414091422753','google','2020-07-10 07:14:46','2020-07-10 07:14:46'),
	(64,'110235644306274232619','google','2020-07-11 18:29:20','2020-07-11 18:29:20'),
	(65,'107234685418400577962','google','2020-07-13 14:18:27','2020-07-13 14:18:27'),
	(66,'110221990533770636235','google','2020-07-13 14:36:03','2020-07-13 14:36:03'),
	(67,'105111209332589889454','google','2020-07-15 13:58:09','2020-07-15 13:58:09'),
	(70,'105462022676453173466','google','2020-07-20 02:35:25','2020-07-20 02:35:25'),
	(72,'107343995742991373469','google','2020-07-22 11:15:02','2020-07-22 11:15:02'),
	(73,'115120365675826257127','google','2020-07-23 13:19:58','2020-07-23 13:19:58'),
	(75,'116337132795825228800','google','2020-07-24 14:44:28','2020-07-24 14:44:28'),
	(78,'103034797008497264608','google','2020-07-28 18:13:01','2020-07-28 18:13:01'),
	(81,'116818071233162611006','google','2020-08-04 06:00:20','2020-08-04 06:00:20'),
	(82,'111427868173432223311','google','2020-08-06 12:58:22','2020-08-06 12:58:22'),
	(84,'104658224110796694362','google','2020-08-09 00:48:27','2020-08-09 00:48:27'),
	(85,'100052200834013204200','google','2020-08-11 12:39:51','2020-08-11 12:39:51'),
	(86,'106568769979843909259','google','2020-08-11 13:20:28','2020-08-11 13:20:28'),
	(92,'114568103717509629819','google','2020-08-20 15:28:06','2020-08-20 15:28:06'),
	(94,'103335674294793776122','google','2020-08-22 15:04:03','2020-08-22 15:04:03'),
	(95,'116916040110756884371','google','2020-08-23 07:11:57','2020-08-23 07:11:57'),
	(96,'104051665586609540806','google','2020-08-23 07:34:33','2020-08-23 07:34:33'),
	(97,'114516024330945875443','google','2020-08-23 17:35:22','2020-08-23 17:35:22'),
	(99,'102483684048269464381','google','2020-08-24 10:38:17','2020-08-24 10:38:17'),
	(100,'108842364617459241423','google','2020-08-24 13:17:22','2020-08-24 13:17:22'),
	(104,'110910513437676039683','google','2020-08-27 19:39:17','2020-08-27 19:39:17'),
	(106,'108892150422073255502','google','2020-08-30 05:46:53','2020-08-30 05:46:53'),
	(107,'102031819194870476726','google','2020-08-30 16:33:27','2020-08-30 16:33:27'),
	(108,'105236711025477668933','google','2020-09-01 00:36:18','2020-09-01 00:36:18'),
	(109,'114683235016642714217','google','2020-09-01 03:09:42','2020-09-01 03:09:42'),
	(111,'111321975853059548434','google','2020-09-06 00:32:27','2020-09-06 00:32:27'),
	(112,'104432365490656899054','google','2020-09-08 08:46:49','2020-09-08 08:46:49'),
	(114,'113199336768044996397','google','2020-09-09 07:28:48','2020-09-09 07:28:48'),
	(116,'111003534403686254410','google','2020-09-10 10:23:35','2020-09-10 10:23:35'),
	(117,'115446287686768725947','google','2020-09-12 21:15:56','2020-09-12 21:15:56'),
	(118,'114118928598876767652','google','2020-09-13 04:46:36','2020-09-13 04:46:36'),
	(121,'104404522282549398874','google','2020-09-16 06:28:05','2020-09-16 06:28:05'),
	(123,'116598261484182515816','google','2020-09-16 19:33:26','2020-09-16 19:33:26'),
	(124,'105046242754440101089','google','2020-09-20 09:49:37','2020-09-20 09:49:37'),
	(125,'108991576765926527393','google','2020-09-23 11:05:48','2020-09-23 11:05:48'),
	(126,'100774229966848668878','google','2020-09-24 10:16:43','2020-09-24 10:16:43'),
	(128,'109771600511625901938','google','2020-09-24 18:00:56','2020-09-24 18:00:56'),
	(129,'118220713244585119654','google','2020-09-24 20:13:01','2020-09-24 20:13:01'),
	(131,'105950754548411524790','google','2020-09-24 22:32:20','2020-09-24 22:32:20'),
	(133,'111556518475428990024','google','2020-09-27 01:19:40','2020-09-27 01:19:40'),
	(136,'115137367923998019754','google','2020-10-07 18:11:45','2020-10-07 18:11:45'),
	(138,'111928679548955855418','google','2020-10-11 07:21:32','2020-10-11 07:21:32');

/*!40000 ALTER TABLE `social_accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table testimonial_translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testimonial_translations`;

CREATE TABLE `testimonial_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `testimonial_id` int(11) DEFAULT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `testimonial_translations` WRITE;
/*!40000 ALTER TABLE `testimonial_translations` DISABLE KEYS */;

INSERT INTO `testimonial_translations` (`id`, `testimonial_id`, `locale`, `name`, `job_title`, `content`)
VALUES
	(3,10,'en','Kari Granleese','CEO Alididi','Really useful app to find interesting things to see do, drink and eat in new places. I’ve been using it regularly in my travels over the past few months.'),
	(4,10,'fr','Kari Granleese','CEO Alididi','Application vraiment utile pour trouver des choses intéressantes à voir, à boire et à manger dans de nouveaux endroits. Je l’utilise régulièrement dans mes voyages au cours des derniers mois.'),
	(5,11,'en','Lorealdonae','Travellers','I use this app for everything! I am a very adventurous person, so I like to try new restaurants, hair salons, and even the nightlife when I am in different cities!'),
	(6,11,'fr','Lorealdonae','Travellers','J\'utilise cette application pour tout! Je suis une personne très aventureuse, donc j\'aime essayer de nouveaux restaurants, salons de coiffure et même la vie nocturne quand je suis dans différentes villes!'),
	(7,12,'en','Alexkaay','Local Guide','I love to know more about new and old local businesses, especially small independent businesses. ” And this is just the place to do it.'),
	(8,12,'fr','Alexkaay','Local Guide','J\'adore en savoir plus sur les nouvelles et les anciennes entreprises locales, en particulier les petites entreprises indépendantes ». Et c\'est juste l\'endroit pour le faire.');

/*!40000 ALTER TABLE `testimonial_translations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table testimonials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testimonials`;

CREATE TABLE `testimonials` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;

INSERT INTO `testimonials` (`id`, `name`, `job_title`, `avatar`, `content`, `status`, `created_at`, `updated_at`)
VALUES
	(10,NULL,NULL,'5ee19cf5de0ab_1591844085.jpg',NULL,1,'2020-05-28 15:27:45','2020-06-11 02:54:45'),
	(11,NULL,NULL,'5ee19d9a2b42a_1591844250.jpg',NULL,1,'2020-05-28 15:41:35','2020-06-11 02:57:30'),
	(12,NULL,NULL,'5ee19e4de3586_1591844429.jpg',NULL,1,'2020-06-11 03:00:29','2020-06-11 03:00:29');

/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `api_token`, `avatar`, `phone_number`, `facebook`, `instagram`, `is_admin`, `status`, `created_at`, `updated_at`)
VALUES
	(8,'Christian','lara@getgolo.com',NULL,'$2y$10$LO/QO4tSq7WdlaMmwA78LOPazAqaOVd28eZo7wi17nLxmVA.rrg8.','0vpMI1Z3KXlgqkjwtcvZ6W2NenCtRxpw1dekBKbTfe1cYyXwQPO6DaATPQGW','zEvWSYUWZn1Cs4RrqjeXTVHhDJDCVcFwH8fltFtNhqdGbohpRgsTDoXfFp2A','5ec9501b06ec9_1590251547.jpg','+813371208190',NULL,NULL,1,1,'2019-11-08 14:22:25','2020-12-25 05:14:43'),
	(13,'Kevin','demo@getgolo.com',NULL,'$2y$10$JzW.POk/BDCKYHulJmtXaOLGSXQ1LZIKYSdMjRJ.ifiqsP3FxWHyK','w5WVicYKjA313kscNTcKPumSWWXer81zLtGBZktnLloWfyNUZax4VPBhfUaN','h3RlV2sXf36BunfexI37y0vLq17mhNTucHXxB4W8QLrHMIs9DTsfCiFcnxAT',NULL,'+81337120819','facebook.com/uxper.co','instagram.com/uxper.co',0,1,'2019-11-08 14:22:25','2020-11-14 04:18:21'),
	(14,'Nathan','nathan@gmail.com',NULL,'$2y$10$XjpZkW/r6PUcxf6R7Dh7wO3uz5tnsc60r.ot3NinwmCyLzgy8nSG.','KcQO55az9XbRtaXp78nxp1NZJHSZHww0yF82AquVHyqfgQnCSZyaHP2nQygu',NULL,NULL,'0912222222','facebook.com/nathan','instagram.com/nathan',0,0,'2019-12-14 02:09:31','2020-07-15 15:35:35'),
	(16,'Clayton Smith','clayton01@gmail.com',NULL,'$2y$10$25oej/ly24weFwhWSJrA4u/8c5CysWh4iMpW/M2PgWMBqXKx4VJKa',NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2020-01-20 23:52:43','2020-07-15 15:35:32'),
	(17,'Vũ Minh Thế','minhthend@gmail.com',NULL,'$2y$10$QDKnTafnLAGbewkbmy7/1uozkwETHoSN0V7/7l7GxBWb9EKPt9VHC',NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2020-06-19 15:39:39','2020-07-15 15:35:30'),
	(18,'Kevin Kay','hello@uxper.co',NULL,'$2y$10$2E9weefz3aQQiDnkidtG3unaxhOwLqJZdNB4gakM426zf0B80aANG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-19 15:41:15','2020-06-19 15:41:15'),
	(19,'Shahibur rahman','shahibur11@gmail.com',NULL,'$2y$10$ZpFjBazK3CXuVTQCcPcqyeR8kvbwYor1CdMucx6zjo4Dc6O6/y23C',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 02:49:51','2020-06-24 02:49:51'),
	(20,'adrian','adrianert@gmail.com',NULL,'$2y$10$vDBo7SIS8MQ7HtA8OM9cxu37mAviZ72ouSan0WETaWQ0pmzPx3KBa',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 07:49:35','2020-06-24 07:49:35'),
	(21,'Idriss François','com@retro-plus.com',NULL,'$2y$10$r9QQZYpLRRt/.ZygJ77S0uPNhO5k5YmSa0dVbHEGMnXhmQ56lUBgC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 08:20:57','2020-06-24 08:20:57'),
	(22,'Panos Karageorgas','panoskarag@hotmail.gr',NULL,'$2y$10$0mFGyUyY.0Udoj2FJMOboeDfU5I6QcfAi4nVaGyQyjhKCpDXakf9a',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 09:14:34','2020-06-24 09:14:34'),
	(23,'Sam Soon Chee Wai','sam.my2ndlove@gmail.com',NULL,'$2y$10$M1GhK0OdP36w/dQJHhNj2.p6.0ERMYj1jW6PXKV8xpTE/qtMzq7gu',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 14:06:21','2020-06-24 14:06:21'),
	(24,'envatonly envatinonly','envatonly@gmail.com',NULL,'$2y$10$nSkBzapAHBbV7LICjK/.yuRtZ5aE6kd3onjHzihViaF1LHcCsM2tm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 20:03:39','2020-06-24 20:03:39'),
	(25,'Théo pidoux','tdofmaxkizi@gmail.com',NULL,'$2y$10$u8jABHwigGDEAshKqFnJquscwN86UkpOE9gaXpMz9moFiSjEl/wJ2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-24 21:29:04','2020-06-24 21:29:04'),
	(26,'Kevin Soto Gomez','kevinsotogomez@hotmail.com',NULL,'$2y$10$Xwfxejgo4gaDJOO7x8B2xeI8d2GkkkYX07so7F4WY8e4QY.lFSUf2','WTDfnRyrlEEc6frIyv7WQW5irvsSGiaTKsITaH1FeHiKZIJ6i3tjyf9XLcLv','odrmw13rJWggoX4CthMpTaekStzu4yV9gMUdx9Jxt0pDA506Lo6PRyRSBGm4',NULL,NULL,NULL,NULL,0,1,'2020-06-24 22:57:54','2020-06-26 00:39:28'),
	(27,'ริชาดส์ วินเติล','baanmac@gmail.com',NULL,'$2y$10$7TTwFhs4ae6Ckf1F5ZsNn.omUpCJYITG1.e5moEjxEk2H2MR0qRdC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-25 01:10:40','2020-06-25 01:10:40'),
	(28,'Jose Ingles','joseingles@mailinator.com',NULL,'$2y$10$rVhOU6PyPhjy6RIwXcgld.NLIh0Ofu4t7hiE9TrdW41a8XgG/SQ/a',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-25 06:14:15','2020-06-25 06:14:15'),
	(29,'Kyle Francey','gosimcoe@gmail.com',NULL,'$2y$10$cRmpDjUSBnjTaT.7Amgorey4KLiDpFLyUrXCV8N/E2IhLslrLuVL6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-25 10:16:08','2020-06-25 10:16:08'),
	(30,'Transport Saver','transportsaver@gmail.com',NULL,'$2y$10$rs0FM/HQNTX/mENDgupOX./ByKcGsF.qAwDvJgygWGi3xaaSxCHua',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-25 18:55:25','2020-06-25 18:55:25'),
	(31,'Future Makers Workshop','younesdoudou.di@gmail.com',NULL,'$2y$10$02D61ytP.Aq3.FtPl4dhLOqsy/9Na3MnccetYWVHYp9QTQRT393iC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-25 19:54:37','2020-06-25 19:54:37'),
	(32,'dani shania','danisetiawanid@gmail.com',NULL,'$2y$10$Gj9dNwHvrCGJV76h8zyqn.kMuIRYjZnfu3S9aM2ugniNB.vw5imXK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-26 06:54:22','2020-06-26 06:54:22'),
	(33,'Marcos','chillimarcos@gmail.com',NULL,'$2y$10$pyZsDwlsPhnOds3vYoLJG.zFS0bSGsMLCsYbrKN/YUDRbp/X8dlE.','PQf3wGgHiAdHZd3VOYWrsvbSMSGL962THQZcWyfLIs01SA6niNxVpew23je4','NupJIiCDRrwu885N3xFsDXzVwZtpxVROo5iLnVyHyfgqcACcmngp8IpaNa7Z',NULL,NULL,NULL,NULL,0,1,'2020-06-26 11:33:26','2020-07-02 23:17:31'),
	(34,'Jan Rolls','jan2004@gmail.com',NULL,'$2y$10$4.mOUPJ8Ir8aXLmhyBclfO2co3RKpzU0VF21dto/hLkjMc6DaP/q.',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-26 13:49:08','2020-06-26 13:49:08'),
	(35,'راشد الدوسري','rasheddosari89@gmail.com',NULL,'$2y$10$KbhIZbmy7c7YX6xiZwNF8.KaHlp75DozDVmLaYl2PIxEUpDPZueUO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-26 20:58:02','2020-06-26 20:58:02'),
	(36,'adasd asdas asd','luis.alonso@msn.com',NULL,'$2y$10$oTKpdKDMwYuJofCAHf1SH.4xjCnGpse4iQODRcdZyjgQSu7Yn6i1y',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-27 02:32:38','2020-06-27 02:32:38'),
	(37,'yum sum','yumsum33@gmail.com',NULL,'$2y$10$5cqcuveKiKAsr7D9oBTwveq73U90Snq4Itfw3mtHik4QxnQsKMmwW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-27 11:36:37','2020-06-27 11:36:37'),
	(38,'Mohamed Gamal Rabeea','mohamed-gamal@nasey.com',NULL,'$2y$10$xVESk1lENX/MLkYbtSDb3eBsebDpvcChOwNbpK1VkY20DajuAu462',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-27 21:09:07','2020-06-27 21:09:07'),
	(39,'Max Antonov','max@getcarrier.com',NULL,'$2y$10$GdWjU9wZ7g/6uCZic0IcbubchQWOM30WRdk1bZwK6M8V5BU92/Iy2',NULL,NULL,'5ef890e27409f_1593348322.jpg',NULL,NULL,NULL,0,1,'2020-06-28 12:44:35','2020-06-28 12:45:22'),
	(40,'Mency Kiloung','kimvar22@gmail.com',NULL,'$2y$10$U1gpuZreFbOP4t1gf4ZwqekP6eyPBnckZhM0boFPXVNdcAd8fqt2e',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-28 18:13:40','2020-06-28 18:13:40'),
	(41,'philip ram','philipram231@gmail.com',NULL,'$2y$10$Nm63u3Nd6g3QjQ2uyg595OgVHfjPPLZJe7ggbwpJmcn7x48bEAHwi',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-29 17:39:06','2020-06-29 17:39:06'),
	(42,'Sebastian Alexandru','byehosting@gmail.com',NULL,'$2y$10$.cdDvyLqTYBQ9kApnntnsu4U4vp8cIeSqB8t1rPi1y35smQMABlfe',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-29 20:24:37','2020-06-29 20:24:37'),
	(43,'Mohammed Diouri','diouri.meed@gmail.com',NULL,'$2y$10$B58NHvcSA1Rh7ydJoNRHeOwx54iwVkT/E8F4s3RIV9qks87bWKNQe',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-30 00:11:37','2020-06-30 00:11:37'),
	(44,'이민웅','mwlee@koons.co.kr',NULL,'$2y$10$cag.PnUaidRXqPC4WVTnq.oLVDPvLBkcddB/ABUFbgaQDrG7dD8fW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-30 07:57:49','2020-06-30 07:57:49'),
	(45,'ליאב עמר','liava94@gmail.com',NULL,'$2y$10$qBmVfv5Z2zNy33NWMIQjxe1Qbfm/WbuQHokVXCweT139VNhWp0O/K',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-06-30 20:08:02','2020-06-30 20:08:02'),
	(46,'Joao Eduardo','joaoeduardo980@gmail.com',NULL,'$2y$10$LOBuJT7hYmt204L38xsWZeYDfKrtEOHbx7mFQrfWwhjvNa/pMsgma',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 00:35:39','2020-07-01 00:35:39'),
	(47,'testes','testes@mail.com',NULL,'$2y$10$.YOjZ7muxuQiEgM3e6QcguUf.8HfAW22Rv1hesBQ97nFUKHJRWP5W',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 05:39:50','2020-07-01 05:39:50'),
	(48,'Моше Михайлов','masik-d.90@mail.ru',NULL,'$2y$10$cGPVw31lAL34523Gqotx1O2obLlKqL6ssQUKqlYntitWp1uCTUm7G',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 08:50:40','2020-07-01 08:50:40'),
	(49,'Amr Bdreldin','amr.bdreldin@gmail.com',NULL,'$2y$10$h82cWMqh2RpmBgg7aBLKieIbaozjuYu8mCN3aK5trr6IX/q9w2P7O',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 09:57:46','2020-07-01 09:57:46'),
	(50,'Twestnet Copo','facebook@twestnet.com',NULL,'$2y$10$0Cna.eiOcsSdBjrzDMDiru5gMyNFdTfcVXqkfr3zv2Q4K7QQGn2e2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 16:59:00','2020-07-01 16:59:00'),
	(51,'Julio Gurgel','julio_gurgel@hotmail.com',NULL,'$2y$10$qfMfwnxUH6DuHAPO/twsg.7zg0W89DRiE23zDM6kLyPSlSEZu/0iO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 17:38:57','2020-07-01 17:38:57'),
	(52,'Felicia Oluwaseun','felicia.seun47@gmail.com',NULL,'$2y$10$6ZuJRurfINbUOSskpCQil.ZquoXsULkf62/V7iDPFGet./UANp7vO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-01 19:14:11','2020-07-01 19:14:11'),
	(53,'vladvector','nocar57547@mailres.net',NULL,'$2y$10$hCVJR.CqdvXFt8pgVTIGsusQo7.snksiCVZL.WA8ZlJbdkDkecsh.',NULL,NULL,'5efe18f999f3b_1593710841.jpg','1','1','1',0,1,'2020-07-02 15:17:04','2020-07-02 17:27:21'),
	(54,'Mohamed Asfar','asfarmohamed20@yahoo.com',NULL,'$2y$10$xlJzOorDQXWDCYPHT85YPe.PyN2RPi/GDE8RgLiZxQJOZUXirZnmO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-02 17:51:02','2020-07-02 17:51:02'),
	(55,'ucell ums','amazondilshod@gmail.com',NULL,'$2y$10$SFv1u9CV5RMNB2FVytqix.TYpDiKvONJ9YouV8OQxexyz4cA50GRe',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-03 04:58:06','2020-07-03 04:58:06'),
	(56,'Mike Ndaombwa','ndaombwa@gmail.com',NULL,'$2y$10$vYIb8Iyo33mBgVM6pGdlKuC.B2UgpTVj92NSGf22kexcnP.fyiEg2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-03 13:50:46','2020-07-03 13:50:46'),
	(57,'Amazai Khan','visaab9002@gmail.com',NULL,'$2y$10$ixII1SfFTD0woDe1CnLSJO8IX/8izvL751NYfyUNce8d8i4IAw8gK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-05 12:09:27','2020-07-05 12:09:27'),
	(58,'Илья Садкин','pyaniyotchim@gmail.com',NULL,'$2y$10$ulKAIo8YPf8GIIO/tFiNF./L6NyxSHFq0WhR6Vvrpy5TdScd1B3dW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-05 19:35:23','2020-07-05 19:35:23'),
	(59,'Linda MacDonald','lindamacdonalde@gmail.com',NULL,'$2y$10$ulGWCZC0JQf3y2R4xQCkDOEaNkQ8RSjGCYDNMYalahUdf2OuONuOW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-08 17:03:51','2020-07-08 17:03:51'),
	(60,'ffff fff2','fff@ff.lo',NULL,'$2y$10$AnHAiU8sLZrit2t4aQsfH.IsY8L/.3d9VDYfZbaxg4Rh2jnhZVQ2i',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-08 20:10:32','2020-07-09 03:12:50'),
	(61,'Testas','jorigiskavaliauskas7@gmail.com',NULL,'$2y$10$4ZKGtHIS5mFIqKfIUwSBhuiHx2jlVyCckO7bGxNa1gBQeB1/Jgxra',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-09 20:06:55','2020-07-09 20:06:55'),
	(62,'Varun B','bvarun1005@gmail.com',NULL,'$2y$10$TYfZl9SsK/eWtKjpYEj2vuVfErKvTdW2wchkcaxOum4Q1BSYTcrhu',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-10 07:14:46','2020-07-10 07:14:46'),
	(63,'Vlad Vector','vladvector@poc.tld',NULL,'$2y$10$XmMaZLQmoL1.tUlXKDI1TupNFJjBJskOQAvc6xtpR6YXdl5Nw8Bsm','mGEF5GXpPaoAVmbdIrOH2dV3mUI5Q0CxG745NR8wjZpukRwCcmJRHUICuiuO','iFHSCHGfGrhjtffRIz9IrWAXHEWtL0dDkFcrk17AW1rHbLZkrzMsgMSRHhr5',NULL,NULL,NULL,NULL,0,1,'2020-07-11 13:24:54','2020-11-05 21:53:43'),
	(64,'Outpage Magazine','shaneomacjr@gmail.com',NULL,'$2y$10$c/7Q8M1nw7ud11awD.YVUejjhvdoaqWBH5JL9H6J1x1CxXHYxqrb2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-11 18:29:20','2020-07-11 18:29:20'),
	(65,'Dev Ops','devops@vyudu.com',NULL,'$2y$10$DaNkErI/NigXnNyYjBGLn.18t8eqAMaO8duD6pB/PTl.fiECsRinC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-13 14:18:27','2020-07-13 14:18:27'),
	(66,'Ogoluwa Ojewale','simeondgenius@gmail.com',NULL,'$2y$10$HusjwoEkxP.n/oLXkidO6e963wlkjDh7IqISkD5cGuiZ5IyKDDwIq',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-13 14:36:03','2020-07-13 14:36:03'),
	(67,'ankit khatri','adkhatri77@gmail.com',NULL,'$2y$10$nkB0j8SYJIVmSWztLz6E7OulAc5Fw7RCgsK/7UY1FK9GlKQKxGimy',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-15 13:58:09','2020-07-15 13:58:09'),
	(68,'Nannan','dev.nael98@gmail.com',NULL,'$2y$10$WkxBTfU72SKlP5HjmoJ4bu06rHDS5vaBhBl6QZWGnJH/l9Au3JVjK','1KozvJjgiha3dpnmflB8qPLtE1UwODU5vEm1EY9Fw0zTD6bJnKXip99laGoS','O52wFURsK4hZ1uSKyl6PYF8hwhRag4dmw6wb7LT4IOVEbU3FVg1bZTv0XCsa',NULL,NULL,NULL,NULL,0,1,'2020-07-15 18:28:54','2020-07-15 18:33:33'),
	(69,'Demo','demo@demo.com',NULL,'$2y$10$EeGCVSwAnDde2IHyDQOwBOUHwpXjSKs6GgEeP5tI1C1dtsHM5D3qG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-16 10:22:21','2020-07-16 10:22:21'),
	(70,'Harry Sitbon','harrysitbon@gmail.com',NULL,'$2y$10$jM0iUAwWTf4/BrXpoOT7Iutfg3IkjCYoJ4PvK36Y3YxGFnScYAwhG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-20 02:35:25','2020-07-20 02:35:25'),
	(71,'MURAT','muratsokmen@protonmail.com',NULL,'$2y$10$5T22TX75wvpxyJHwSZ0OYeF47DCY.HJPVHt2bl.KnzUxCrDtaLz82',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-21 16:50:04','2020-07-21 16:50:04'),
	(72,'Sebastian Simionescu','1212simi@gmail.com',NULL,'$2y$10$z1Ik9SGaxl3eJbWaZu8jQO7giaXO4wyzz4m2mkj2Nnzh1.pTVRgA.',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-22 11:15:02','2020-07-22 11:15:02'),
	(73,'Vinicius Cavalcant','vinicrf2012@gmail.com',NULL,'$2y$10$icRi3LPBMb0R0ego4ao79e5XoExHWDzV4hT0Wh2cpfr6CPxy4xzmW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-23 13:19:58','2020-07-23 13:19:58'),
	(74,'qhm78107@cuoly.com','qhm78107@cuoly.com',NULL,'$2y$10$JFpIyWBlyYeDNY1xu364V.ar0RhmrHyZ2bNY/BYUZGk7OrceP87BG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-24 05:28:39','2020-07-24 05:28:39'),
	(75,'Ahmed Mansoor','ahmed.khokhar84@gmail.com',NULL,'$2y$10$YzTcy47DpQiqWgLlAk6OBOVYK900J.dL8TZMkdwvtxkIDCWY7TYaS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-24 14:44:28','2020-07-24 14:44:28'),
	(76,'mg','mgiousa@gmail.com',NULL,'$2y$10$3gShBxI.w7CJDce6VUVggeLyPQYlFY5LG8D2MYWCJDHgRCXTONaLG','oGU2bXLTqKjs35AUXboRX93lwJl0r5KPkTXFzEEva4EKI8Pi3yUbXWF5QMhc','Df7JN0FnSwoSe4UgDhcB1oi5V7dVJWDJ9MnqMd2ICtU1gAYj9rVacDdajMRq',NULL,NULL,NULL,NULL,0,1,'2020-07-25 18:11:22','2020-11-04 04:33:39'),
	(77,'ilovegolo','k8j6@sofia.re',NULL,'$2y$10$/tp4pt6yWF3vFoGbCba44.rI/IPfWdxMYoYmpqjYilNiwd.J5hmRu',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-26 16:36:04','2020-07-26 16:36:04'),
	(78,'Beto Rivera Leiva','alberto31rivera@gmail.com',NULL,'$2y$10$x6hnmXi9IpvA88zlsDByHOHmh6jWEwVGS3GL207wsdIjaoB8bxhzS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-07-28 18:13:01','2020-07-28 18:13:01'),
	(79,'kono christian','vortisgroup@gmail.com',NULL,'$2y$10$eCm5BzJVYdODoEH9UMe5xuf8TGY0fZsE4QO75eLhI8Yu0uYjPTXc6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-02 10:48:49','2020-08-02 10:48:49'),
	(80,'Kadir Ece','kadir@ageajans.com',NULL,'$2y$10$hp0w5kErHA4SaC7F7UsbFeOcxo2O3pknxy1W7stUCiWgYAGGIV0tm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-03 21:43:05','2020-08-03 21:43:05'),
	(81,'10x Philippines','10xpilipinas@gmail.com',NULL,'$2y$10$AZ3N6BArinLH7TZbVDnSq.OfQfvk1tnyQ/soCZ4A4gFm2muZZeQuG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-04 06:00:20','2020-08-04 06:00:20'),
	(82,'Berkay Kara','berrkkra@gmail.com',NULL,'$2y$10$YjkqBUbU72AgTtKj/lBsIeQSF/acIF75t0ctVlDAkBj6Mw4gO.YJK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-06 12:58:22','2020-08-06 12:58:22'),
	(83,'aaa','aaa@aaa.pt',NULL,'$2y$10$tLM7zRkmCpymotbTAthHh.SKN3eyMkKgIxCBn1hXxjuxKe/IcjJl6','mKfedJMP99mC9judHal6N3Zb0007TnSk5J7iImwgfH6i7uU1vhHNx9eXe2c8','4bgeKbv9kzgERR4LZSNJnut7YAf523xS2Q3Fylz51EubjePUXLQCePFgVXjr',NULL,NULL,NULL,NULL,0,1,'2020-08-07 16:35:04','2020-08-10 09:30:18'),
	(84,'Ephraim Molepo','ephraimmolepo@gmail.com',NULL,'$2y$10$XVpyyTWLqdBysHrPRXnmSegESJ/GyLHBNxvFQrX522aErPaykrSFu',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-09 00:48:27','2020-08-09 00:48:27'),
	(85,'İlyas Özkurt','ilyasozkurt@gmail.com',NULL,'$2y$10$qo4WCaT2zAAIpXsNjq.DOeOgllGUrSGOlqPmqrE4Dbf30ANSE5r3a',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-11 12:39:51','2020-08-11 12:39:51'),
	(86,'Hussain Al Marzooq','prince7ussain@gmail.com',NULL,'$2y$10$6E4a/Js7p.a/IJHrylyN8uBkFqxPKClk.i8El6SQNwhIucnbZJuDS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-11 13:20:28','2020-08-11 13:20:28'),
	(87,'Pranta Mazumder','freelancerpranta@gmail.com',NULL,'$2y$10$zklZpPm.RBCJrx2aIYyRU.8I5tG/FVD7cHBMsVRw6eifXg/YeNaFC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-12 04:21:47','2020-08-12 04:21:47'),
	(88,'Pety','levide2622@aenmail.net',NULL,'$2y$10$T/xkmL..xmBygMi32a26CuY.sGE8VKGseZYqcxZMPjoQa9V1W5vJe',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-13 17:52:19','2020-08-13 17:52:19'),
	(89,'Tamer Essam','tamerjrrar@yandex.com',NULL,'$2y$10$Vho.ULgejrDv8lngtNsq7.eL5OAPq.NQj3Fw..3bfECzM4KusyR9u',NULL,NULL,'5f36ecf97af75_1597435129.jpg',NULL,NULL,NULL,0,1,'2020-08-14 19:49:57','2020-08-14 19:58:49'),
	(90,'Sajjad Ahmad','sajjadahmad2345@gmail.com',NULL,'$2y$10$jpALIgQD/WJNYJM3JWycwux4iCGiYoeYu92AiLj2LsOZ/kNtx2JxW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-17 11:37:14','2020-08-17 11:37:14'),
	(91,'Muhammad Hassan','atom4en@gmail.com',NULL,'$2y$10$9MT3O8LUWv.jtmQyhQxQMO0nTgCj.78UB6KPonh.gKg2UmV0MD69G',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-19 08:24:44','2020-08-19 08:24:44'),
	(92,'Carlos Eduardo','carloshopt@gmail.com',NULL,'$2y$10$FOgFZWxpjYuDbZz9kEfcfeudbajTw.xV9UXLVpmtk1LJG/Ll3vR6G',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-20 15:28:06','2020-08-20 15:28:06'),
	(93,'ANDY LAM','swanghobby@gmail.com',NULL,'$2y$10$7FNdbNrGYEUx.YACiPoVKOv8mdONTaW/0KlrXooQG87tNsW5K/H2i',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-22 03:57:17','2020-08-22 03:57:17'),
	(94,'Hossam KHALIL','khalil.hossam@gmail.com',NULL,'$2y$10$JoFeno71lR1OKwUnU9VkOOolXYsjvsQ.qPgQ1dFKtetVbChNpLkHW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-22 15:04:03','2020-08-22 15:04:03'),
	(95,'Furnitures Today','ftconnectindia@gmail.com',NULL,'$2y$10$Pf8w/zAESY8KmK2JZVGv4OYlb4nQjEf/KtUs7mmIOnVWmU/Dv./9q',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-23 07:11:57','2020-08-23 07:11:57'),
	(96,'Abdullah AKAT','stop18@gmail.com',NULL,'$2y$10$90w3yoeQrSe0Xd/aqttMA.UO/1h8pna21F1vqXKnXcKCgf3Z6x/xC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-23 07:34:33','2020-08-23 07:34:33'),
	(97,'jitender verma','vermajitenderguitar@gmail.com',NULL,'$2y$10$5jXYMZkj6lEyJgUlTsiC..7dEi4dMy0t2DW8aTB6qaApPojHoSx7i',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-23 17:35:22','2020-08-23 17:35:22'),
	(98,'Aurora Stanton','ramutiqile@mailinator.com',NULL,'$2y$10$ZZmRs3bhJr1zbCtaeiN9nuBPdmiVDupYo8iKtJ.x.KZuP2bcLkQ4.',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-24 04:44:12','2020-08-24 04:44:12'),
	(99,'Cutman Friseur Berlin','info@cutman-friseur.de',NULL,'$2y$10$WUE2zDhrSYFHl.UxhF3kzORH.TyfstOEQh2rugLIW76e0E.rAqf5W',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-24 10:38:17','2020-08-24 10:38:17'),
	(100,'blake nguyen','blake.nguyentran@gmail.com',NULL,'$2y$10$u6FClgQGv.m9435vc3ayS.QCdkzaVKQ3mFF9npa6E72yTfeHjrqNa',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-24 13:17:22','2020-08-24 13:17:22'),
	(101,'Carol','carolxxx@hotmail.com',NULL,'$2y$10$yadgoV3KAoQbAVZxYMelOefKVV0nJus/U2t8eWbvXBtNNMnUOhw8u',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-24 20:40:42','2020-08-24 20:40:42'),
	(102,'Aphrodite Browning','baleqyhiry@mailinator.com',NULL,'$2y$10$3CfC4mtdRe1NokCFTDMZKe76xyv/fw4p1WPGnJIzlmfyvQ3PzxO.m',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-25 15:30:32','2020-08-25 15:30:32'),
	(103,'Laweeb','dhdhdhdh@gmail.com',NULL,'$2y$10$G0/TXzAraLMTlNHxsrw/FO2Bf63bTr3lqaK2qSFwbXhC4yIX5c4da',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-26 01:15:40','2020-08-26 01:15:40'),
	(104,'INDRASEN KUMAR','indrasenkumar715@gmail.com',NULL,'$2y$10$WQ8lWtBcqdj8G5bvHwzjH.oREaxGJVD4mb4WgUBxrOrF/JyzTa4QS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-27 19:39:17','2020-08-27 19:39:17'),
	(105,'Gabriel Macedo','gabe@acedagency.comg',NULL,'$2y$10$sMAJOZy59Befj4Rxb8RSa.JDc17KqkkrHDND7ESXrY8nOMy/gzlZG',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-27 21:49:34','2020-08-27 21:49:34'),
	(106,'MyCityArea Social','mycityarea.social@gmail.com',NULL,'$2y$10$RBhrmsDoQfV5yZnG5zufC.BplaHurqF.RFL1i5hLSis6vrLmz.MJ6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-30 05:46:53','2020-08-30 05:46:53'),
	(107,'ÖMER BAŞKUL','omerbskl1@gmail.com',NULL,'$2y$10$TB9/Z.rma8TaifHhx.wKPeFxggSD5vSo6tdHMKOSuvUgh9i2fhEnm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-08-30 16:33:27','2020-08-30 16:33:27'),
	(108,'Maani Roman','maani.roman.aw@gmail.com',NULL,'$2y$10$9rPWdebTRHFvKwrZd3GbouwzO8vBrxHcyjmHELrfjqYdmyEW0npBO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-01 00:36:18','2020-09-01 00:36:18'),
	(109,'Brahmananda Mohanty','110301CSR004@cutm.ac.in',NULL,'$2y$10$Nh/RaelGx3GFJKLw1rlpcOeSqNLzD0eiEaagnhmvd9.jt.L/f6FqS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-01 03:09:42','2020-09-01 03:09:42'),
	(110,'sina','hellonasm@gmail.com',NULL,'$2y$10$ipFkx5bANCKtK7AVmJnM7u6r9u30dLSXTioQIE7pQGCdgxqXKSycS',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-03 14:48:43','2020-09-03 14:48:43'),
	(111,'nova heryani','novaheryani718@gmail.com',NULL,'$2y$10$vefuMrwZvwHkPohN0PA5pe45E37zuiAYZ6kHiiXhfhZdWaHTH5KQe',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-06 00:32:27','2020-09-06 00:32:27'),
	(112,'Max Sky','maxskies@gmail.com',NULL,'$2y$10$ERBZu.N01DUQ8OVCU.1HquZJloWI48SpASo9Eu8xU3M8z0f4L4Kr6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-08 08:46:49','2020-09-08 08:46:49'),
	(113,'lol','admin@admin.com',NULL,'$2y$10$xgCDwnMMSQ2zwrK8YRn9yu9HYNXdb9JZKKkGBcDUbqogm4r0JQkZO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-08 16:22:36','2020-09-08 16:22:36'),
	(114,'Murat Aydemir','scsemih@gmail.com',NULL,'$2y$10$JmkHt89vIPla1Id1A3rIe.uzo./5jqpvATxoNvBKBfmIm.eW0DPE6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-09 07:28:48','2020-09-09 07:28:48'),
	(115,'Peter','peter.pafumi@live.com.au',NULL,'$2y$10$5cXeIUHi2H5VtOr9C5woe.H7j6flYuuKEFMDWYndUBOnJKrYu/c0a',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-10 08:37:58','2020-09-10 08:37:58'),
	(116,'barsam jaferi','jaferi.mehran@yahoo.com',NULL,'$2y$10$H7q7e3pv.VGFJOMrSeAW1uBSvZKNhspNDT31gvgWJ3jEgC1H/K3ry',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-10 10:23:35','2020-09-10 10:23:35'),
	(117,'Valentin Cosmin Pantazi','88fonac@gmail.com',NULL,'$2y$10$5w4OHtQep2XhI6diiarhUO78ez5pGczEa186ibtr71tlRLA8o7g2W',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-12 21:15:56','2020-09-12 21:15:56'),
	(118,'Terence Morton','terencemortron@gmail.com',NULL,'$2y$10$PyZ02ImLCasAeqSvdPi38uE5qDGttTWU5mgCpZHjsIzAgKMI9i5jm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-13 04:46:36','2020-09-13 04:46:36'),
	(119,'xyz','abc@mail.com',NULL,'$2y$10$zR0BjVYX.TJtO3PeibrqpO.IGnJAV.ot/tg.JHrAf.SBuzHq8SLIO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-15 08:05:20','2020-09-15 08:05:20'),
	(120,'Dori','4webtirana@gmail.com',NULL,'$2y$10$OVvCSYL/AOyO//en8chuzey73gNTxEptIXxQA2Zobsy7x66aMtUWa',NULL,NULL,'5f60f769f343a_1600190313.png',NULL,NULL,NULL,0,1,'2020-09-15 17:17:44','2020-09-15 17:18:33'),
	(121,'Alisher Bazarkhanov','alisher.bazarkhanov@gmail.com',NULL,'$2y$10$rXunLwQdok/SU.7gVpALFuoPFUc8j0jgWe0Ddx7rIIOv.jKK8.Jmi',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-16 06:28:05','2020-09-16 06:28:05'),
	(122,'Vishal Purohit','visal.purohit@gmail.com',NULL,'$2y$10$MUDkMStfzfOLLOJyqFrOwem7KZlR0/g.HWobn61hvzUcsv488CpPm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-16 08:25:37','2020-09-16 08:25:37'),
	(123,'Third Person Gamer','thirdpersonbusiness@gmail.com',NULL,'$2y$10$tVpOLarYqO1Cxm7h5SOQ0e3haOn9kKFRD8kgGqdUt6bWQnw0Gh27S',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-16 19:33:26','2020-09-16 19:33:26'),
	(124,'Fardin Anan','fardin.anan@gmail.com',NULL,'$2y$10$NAKDI8IP3290BA0oc/rBK.5BmHTJBajl7mMkQBzqR7rM1ZkOWGwVK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-20 09:49:37','2020-09-20 09:49:37'),
	(125,'mankasha sajid','mankasha786@gmail.com',NULL,'$2y$10$1pfwbSRb5xc5jEd3Jg6JEeKMks5OQZaa8MLXENMpvPVzpoB83qiKq',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-23 11:05:48','2020-09-23 11:05:48'),
	(126,'Eco Krasa','ecokrasabiz@gmail.com',NULL,'$2y$10$HLT2S2ybTYBDHefy3gbbNuZXgdBJN6/S91GEFKP.RcW9yIKsL5nXK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 10:16:43','2020-09-24 10:16:43'),
	(127,'Yandry Hernandez Acosta','yandryhn@gmail.com',NULL,'$2y$10$tLaIiQxmJ5uoauMhnnpirePCDt56RrbdT4fxaoQlZn9j1OPIsLfhK',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 17:29:01','2020-09-24 17:29:01'),
	(128,'Asad Ali','asadbloch78@gmail.com',NULL,'$2y$10$uTrHcxjCm0IKXNgYNx5g8etNpFSKV/kX5jiPi5ms8wawfgKVEzu8e',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 18:00:56','2020-09-24 18:00:56'),
	(129,'Cristian Navarro','zonasur2011@gmail.com',NULL,'$2y$10$n1Oxr.ypeGndxaT0zb9nb.e1M7jyxQCbhl.clkEMY1WW6xUR7yQ8u',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 20:13:01','2020-09-24 20:13:01'),
	(130,'yeah','m@m.com',NULL,'$2y$10$J4Gd8hEKjlOYvcdg5SvXV.dIhPmM2ty77i0NNQipIISqgalgSkkG2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 22:31:06','2020-09-24 22:31:06'),
	(131,'Timothy Kwasi Afrane Wuo-Asare','timothyafranewuoasare@gmail.com',NULL,'$2y$10$/5U3dj5JL6OvcD8rolV1IeKAsjdZOCo5XS4sNPfS62uH6LFnJjT4a',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-24 22:32:20','2020-09-24 22:32:20'),
	(132,'Lovensky Carl Junior François','lovenskyf0@gmail.com',NULL,'$2y$10$Bgfgqe2uV98Qca9ZeZCYueure03CwUbdoAkprKB2.JEP1.q/PUsK.',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-25 12:43:44','2020-09-25 12:43:44'),
	(133,'Enterasan Aksiyon','aybarsyazilim@gmail.com',NULL,'$2y$10$CV49QoznJteaJeP41ONhXOKSfiRpUi0r8Jm5ZkEi7/loDlNgT8y3u',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-27 01:19:40','2020-09-27 01:19:40'),
	(134,'Ronaldo Brazier','ronaldinhobr74@hotmail.com',NULL,'$2y$10$FQPY5daETZHXrdKXG6zmrewyyF85bcPKFR3TK7hb6CRHANAH1TSCO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-09-28 13:23:13','2020-09-28 13:23:13'),
	(135,'avdvsdv','sdvsdv@yahoo.com',NULL,'$2y$10$vlJ5UBmnoez3dPnIRTpoo..2QbK1Fvcy3vh6Pd6m6sB2ZIcjB1I5i',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-01 07:16:18','2020-10-01 07:16:18'),
	(136,'Prasobh Sudhakaran','prasobh022@gmail.com',NULL,'$2y$10$8tVqOL1z/xetbH9mebsn/urTnNoYtdbzhauG8kM9t/k29QTqzvHzm',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-07 18:11:45','2020-10-07 18:11:45'),
	(137,'demouser4','asd@asd.asd',NULL,'$2y$10$8NO2RfsRbWJw7NmURZSF4uuUnDxnz5JMLli4sdmwxkyZX6STl2f/O',NULL,NULL,'5f7fa879b13b0_1602201721.jpg',NULL,NULL,NULL,0,1,'2020-10-09 00:00:23','2020-10-09 00:02:01'),
	(138,'Para Pelo','esrecreo@gmail.com',NULL,'$2y$10$NmVtwu/gzq0BRG59IzpKNeDLqxC/oEq9eGBw0OaIDiu.fvQ8L8zna',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-11 07:21:32','2020-10-11 07:21:32'),
	(139,'muayid','moahfox@gmail.com',NULL,'$2y$10$d7VxZDfs9Es1acgR.bYyouiEykeSeiCpTaqc8L2WRWGvvzizQHw9W',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-15 22:17:10','2020-10-15 22:17:10'),
	(140,'usuario','usuario@gmail.com',NULL,'$2y$10$B8zkh63ZaBfDve621XF7q.lECrwdBpH7SBK4m49Tp35KZWegCN8EO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-19 02:40:07','2020-10-19 02:40:07'),
	(141,'OJ Ani','ojanii2@gmail.com',NULL,'$2y$10$lSGvLCtyrdFU87lubBjq5.B/bF/FuYwqY8lZ9OPuzVVyNC8nkiKqi',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-22 19:32:11','2020-10-22 19:32:11'),
	(142,'normaluye','normaluye@normaluye.com',NULL,'$2y$10$V3RMO96f88waHn6rfqRgce/5cvZFNKrpvQqLllPGMCMi4q.R0BZiy',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-23 20:40:45','2020-10-23 20:40:45'),
	(143,'Garagaianu Catalin','stefan.cata92@gmail.com',NULL,'$2y$10$gnuKt870PTRqHcA5MFOPceihSp5hpx6Mi7Gk7yZGlGzLDeBsr.1rC',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-27 15:36:38','2020-10-27 15:36:38'),
	(144,'Marcus Vinicius','marcusbohessef83@gmail.com',NULL,'$2y$10$3GRBEwMfGNUXQZOGIiQZOuGoov26zD1v0FinMCUP473YaYHLgHt1u',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-10-28 13:58:23','2020-10-28 13:58:23'),
	(145,'nitesh','niteshverma.ndv@gmail.com',NULL,'$2y$10$Yvci3tw12judoewxvgZvGecGzUWO1aKDQYE58bGKEQTjW.Q6qm4zO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-02 10:34:39','2020-11-02 10:34:39'),
	(146,'Felipe','felipe@carpena.co.uk',NULL,'$2y$10$xM/1QtEkxQai7H/53ou84Oy0DxKfsFcRMXXkI4o/VgBSPzRJiRPUW',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-02 17:28:40','2020-11-02 17:28:40'),
	(147,'fgfg','eee@live.com',NULL,'$2y$10$qqtU0xdVtCNACsn2vDeO4ONWMWGZ1iYMAKPGNb1URoXWDo0caEGda',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-04 05:40:57','2020-11-04 05:40:57'),
	(148,'dsgfds','ssghs@sfsdfa.asf',NULL,'$2y$10$ofNX82l040d5wfijiQ0WReZaztYHIBjOgbLRqa2C2E2BMDVZjBdc2',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-04 16:33:15','2020-11-04 16:33:15'),
	(149,'bnrmxjyesg','accae104236926f6035d246bd0c8b4efprx@ssemarketing.net',NULL,'$2y$10$XSWiMo1Pn96H7HyY1w80WeXBxR0JpSNsoLXwD49CF7SVD1XPQVnJa',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-11 12:34:20','2020-11-11 12:34:20'),
	(150,'michael','michdriy@me.com',NULL,'$2y$10$7G5y6vlx78k/zahx0JziQOOSpFzdW3V9Zw.CdTT.2VGxJHO4xw8c.',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-11-15 13:22:19','2020-11-15 13:22:19'),
	(151,'xxhffz','mehmetemreguven46@gmail.com',NULL,'$2y$10$5aRHYM6oldf4t8tSlLCHQeTb.rRfvfJqzZkz8cBP3U4g7c/moeNx6',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-12-19 02:07:36','2020-12-19 02:07:36'),
	(152,'testuser2','scott@detectornetwork.com',NULL,'$2y$10$maHoEdqxODv8S.wRX.bcTuyciI.LLetRcWkdWQgF.mPuTNUrORGiO',NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2020-12-23 23:12:13','2020-12-23 23:12:13');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wishlists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wishlists`;

CREATE TABLE `wishlists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;

INSERT INTO `wishlists` (`id`, `user_id`, `place_id`, `created_at`, `updated_at`)
VALUES
	(9,20,37,'2020-06-24 07:50:21','2020-06-24 07:50:21'),
	(10,35,36,'2020-06-26 20:58:27','2020-06-26 20:58:27'),
	(11,35,37,'2020-06-26 20:58:28','2020-06-26 20:58:28'),
	(12,44,19,'2020-06-30 08:00:28','2020-06-30 08:00:28'),
	(13,52,39,'2020-07-01 19:20:55','2020-07-01 19:20:55'),
	(14,57,19,'2020-07-05 12:10:51','2020-07-05 12:10:51'),
	(16,13,37,'2020-07-14 21:59:37','2020-07-14 21:59:37'),
	(17,67,19,'2020-07-15 14:19:59','2020-07-15 14:19:59'),
	(18,80,19,'2020-08-03 21:48:08','2020-08-03 21:48:08'),
	(20,105,40,'2020-08-27 21:50:26','2020-08-27 21:50:26'),
	(21,111,43,'2020-09-06 00:36:08','2020-09-06 00:36:08'),
	(22,136,19,'2020-10-07 18:13:52','2020-10-07 18:13:52'),
	(23,76,40,'2020-11-04 04:36:09','2020-11-04 04:36:09'),
	(24,76,46,'2020-11-04 04:36:11','2020-11-04 04:36:11'),
	(30,152,44,'2020-12-23 23:13:35','2020-12-23 23:13:35'),
	(33,8,19,'2020-12-25 07:04:14','2020-12-25 07:04:14'),
	(35,8,36,'2020-12-25 07:22:52','2020-12-25 07:22:52');

/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
