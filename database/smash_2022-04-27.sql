-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van smash wordt geschreven
CREATE DATABASE IF NOT EXISTS `smash` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `smash`;

-- Structuur van  tabel smash.comments wordt geschreven
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(300) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.followers wordt geschreven
CREATE TABLE IF NOT EXISTS `followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `following_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.likes wordt geschreven
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.posts wordt geschreven
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.reports wordt geschreven
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.reset_password wordt geschreven
CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.socials wordt geschreven
CREATE TABLE IF NOT EXISTS `socials` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.tags wordt geschreven
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) DEFAULT NULL,
  `post_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel smash.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(300) DEFAULT NULL,
  `username` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `profile_pic` varchar(300) DEFAULT 'default.png',
  `bio` varchar(300) DEFAULT NULL,
  `education` varchar(300) DEFAULT NULL,
  `second_email` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Data exporteren was gedeselecteerd

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
