# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.34)
# Database: smash
# Generation Time: 2022-05-03 15:19:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(300) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table followers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `followers`;

CREATE TABLE `followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `following_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `tags` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `title`, `date`, `image`, `description`, `tags`, `user_id`)
VALUES
	(9,'Smash: branding and mobile app','2022-04-30','project-smash.png','Mobile web application built for the course php',NULL,2),
	(11,'Hoppin: mobility mobile app','2022-05-03','project-hoppin-fien-gerardi.png','Hoppin is made to make travelling easy with every vehicle.',NULL,2),
	(12,'Tingels: education app for children','2022-05-03','project-tingels-fien-gerardi.png','Desktop app for children to make learning fun and accessible.',NULL,2),
	(13,'Sweet 16: branding for event weareimd','2022-05-03','project-sweet16-fien-gerardi.jpg','Branding and website for celebrating 16 years of IMD!',NULL,2),
	(15,'Tingels: learning platform','2022-05-03','tingels dribbble.png','A fun platform with educational videos for children',NULL,1),
	(18,'Connec: reconnect students','2022-05-03','mockup connec.png','An idea to reconnect students through activities',NULL,1),
	(19,'Hoppin: transport app','2022-05-03','hoppin-min.png','Transportation with much possibilities',NULL,1),
	(20,'SLAM: reconnect teachers','2022-05-03','Screenshot 2022-05-03 at 12.40.20.png','A platform where students can reconnect through projects for organisations',NULL,1);

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table reset_password
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reset_password`;

CREATE TABLE `reset_password` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`id`, `tag`, `post_id`)
VALUES
	(7,'#design #development #app',9),
	(8,'#design #branding #webapp',10),
	(9,'#design #ux #ui',11),
	(10,'#branding #ux #ui',12),
	(11,'#branding #website #development',13),
	(12,'#design #development #branding',14),
	(13,'#ux #ui #design',15),
	(14,'#logo #design',16),
	(15,'#design #ui #development',17),
	(16,'#ux #branding',18),
	(17,'#ui #ux',19),
	(18,'#design #branding #development',20);

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(300) DEFAULT NULL,
  `username` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `profile_pic` varchar(300) DEFAULT 'default.png',
  `bio` varchar(300) DEFAULT 'New member of the smash community',
  `education` varchar(300) DEFAULT NULL,
  `second_email` varchar(300) DEFAULT NULL,
  `social_linkedin` varchar(300) DEFAULT NULL,
  `social_github` varchar(300) DEFAULT NULL,
  `social_instagram` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `is_admin`, `profile_pic`, `bio`, `education`, `second_email`, `social_linkedin`, `social_github`, `social_instagram`)
VALUES
	(1,'r0786673@student.thomasmore.be','ellendeveth','$2y$12$uvFCVOYl8ptMDd3Tb/5EN.hEGbohUfb9sGh8C6A.pNWRbuAASycS6',NULL,'me.jpeg','Ready to explore fun designs','Interactive multimedia design','ellen.deveth@hotmail.com','https://www.linkedin.com/in/ellendeveth/','https://github.com/ellendeveth','https://www.instagram.com/ellendeveth/'),
	(2,'r0857158@student.thomasmore.be','fiengerardi','$2y$12$uruF6vSBstHyjixiXf4Jke6YTQIk6o2cfGMpPglegmOgvCm1kCXbK',NULL,'juri-gianfrancesco-UCEtRnp8qR0-unsplash.jpg','Ready to ace designs and code.','Interactive Multimedia Design','fien.gerardi@gmail.com','https://www.linkedin.com/in/fien-gérardi-035003151/','https://github.com/fgrardi','https://www.instagram.com/fiengerardi/');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
