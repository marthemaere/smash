# ************************************************************
# Sequel Ace SQL dump
# Version 20033
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.7.34)
# Database: smash
# Generation Time: 2022-05-18 15:19:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
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

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `text`, `post_id`, `user_id`)
VALUES
	(32,'cool!',13,1);

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table followers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `followers`;

CREATE TABLE `followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `following_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;

INSERT INTO `followers` (`id`, `follower_id`, `following_id`)
VALUES
	(2,1,2);

/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;

INSERT INTO `likes` (`id`, `user_id`, `post_id`)
VALUES
	(8,2,28),
	(10,2,15),
	(23,1,29),
	(26,1,28),
	(36,1,22),
	(39,1,26);

/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `image_thumb` varchar(300) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `isShowcase` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `title`, `date`, `image`, `image_thumb`, `description`, `user_id`, `isShowcase`)
VALUES
	(9,'Smash: branding and mobile app','2022-04-30 00:00:00','project-smash.png',NULL,'Mobile web application built for the course php',2,NULL),
	(11,'Hoppin: mobility mobile app','2022-05-03 00:00:00','project-hoppin-fien-gerardi.png',NULL,'Hoppin is made to make travelling easy with every vehicle.',2,NULL),
	(12,'Tingels: education app for children','2022-05-03 00:00:00','project-tingels-fien-gerardi.png',NULL,'Desktop app for children to make learning fun and accessible.',2,NULL),
	(13,'Sweet 16: branding for event weareimd','2022-05-03 00:00:00','project-sweet16-fien-gerardi.jpg',NULL,'Branding and website for celebrating 16 years of IMD!',2,0),
	(15,'Tingels: learning platform','2022-05-03 00:00:00','tingels dribbble.png',NULL,'A fun platform with educational videos for children',1,0),
	(18,'Connec: reconnect students','2022-05-03 00:00:00','mockup connec.png',NULL,'An idea to reconnect students through activities',1,0),
	(19,'Hoppin: transport app','2022-05-03 00:00:00','hoppin-min.png',NULL,'Transportation with much possibilities',1,0),
	(21,'Democrats abroad: marketing campaign','2022-05-04 00:00:00','democratsabroad.jpg',NULL,'Marketing campaign to engage Americans living in Belgium to vote for the American Elections',3,NULL),
	(22,'Skwikkl: online learning platform for children','2022-05-04 00:00:00','skwikkl.png',NULL,'An online platform where children can learn in a playful way',3,NULL),
	(25,'Grofgerief: an online platform for circular economy','2022-05-04 00:00:00','grofgerief.png',NULL,'An online website to make circular economy possible',3,NULL),
	(26,'Hoppin: combimobility app','2022-05-04 00:00:00','hoppin.png',NULL,'An app to improve mobility with public transport in Belgium',3,NULL),
	(27,'SLAM: connect vzw\'s with students','2022-05-04 00:00:00','Slam.png',NULL,'SLAM gives the opportunity to students to realise a real life project with non profit organisations',1,NULL),
	(28,'Johannes Gutenberg: One of the kids','2022-05-07 00:00:00','1.png',NULL,'We were challenged to tell a historical story to children with animation. I made Johannes a best friend for the kids. ',4,NULL),
	(29,'Designing a logo for a startup','2022-05-07 00:00:00','5.png',NULL,'This is a design for a logo for a startup working around qr codes for stores. They wanted a retro vibe. ',4,NULL),
	(30,'Enjoy Digital: A complete branding for a marketing agency','2022-05-07 00:00:00','3.png',NULL,'A happy and young look, this was the main goal for Enjoy Digital\'s branding. We created a website, total branding and wrote the texts for the whole project. ',4,NULL),
	(31,'Tingels: An interactive learning platform for children','2022-05-07 00:00:00','tingels.png',NULL,'An interactive learning platform in a dashboard design where kids can grow in a fun way and with each other at their own pace. ',4,NULL);

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_user_id` int(11) DEFAULT NULL,
  `reported_user_id` int(11) DEFAULT NULL,
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
	(7,'#design',9),
	(8,'#design',10),
	(9,'#design',11),
	(10,'#branding',12),
	(11,'#branding',13),
	(12,'#design',14),
	(13,'#ux',15),
	(14,'#logo',16),
	(15,'#design',17),
	(16,'#ux',18),
	(17,'#ui',19),
	(18,'#design',20),
	(19,'#branding',21),
	(20,'#prototype',22),
	(21,'#prototype',23),
	(22,'#webdesign',24),
	(23,'#webdesign',25),
	(24,'#prototype',26),
	(25,'#branding',27),
	(26,'#design',28),
	(27,'#logo',29),
	(28,'#development',30),
	(29,'#wireframing',31),
	(30,'#development',9),
	(31,'#app',9),
	(32,'#branding',10),
	(33,'#webapp',10),
	(34,'#ux',11),
	(35,'#ui',11),
	(36,'#ux',12),
	(37,'#ui',12),
	(38,'#website',13),
	(39,'#development',13),
	(40,'#development',14),
	(41,'#branding',14),
	(42,'#ui',15),
	(43,'#design',15),
	(44,'#design',16),
	(45,'#ui',17),
	(46,'#development',17),
	(47,'#branding',18),
	(48,'#branding',20),
	(49,'#ux',19),
	(50,'#development',20),
	(51,'#marketing',21),
	(52,'#advertisement',21),
	(53,'#design',22),
	(54,'#design',23),
	(55,'#coding',24),
	(56,'#circulareconomy',24),
	(57,'#coding',25),
	(58,'#circulareconomy',25),
	(59,'#design',27),
	(60,'#design',26),
	(61,'#development',27),
	(62,'#animation',28),
	(63,'#adobeanimate',28),
	(64,'#design',29),
	(65,'#retrostyle',29),
	(66,'#webdesign',30),
	(67,'#branding',30),
	(68,'#webdesign',31),
	(69,'#figma',31);

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
	(1,'r0786673@student.thomasmore.be','ellendeveth','$2y$12$CiNdd9BKi6btzqGnDBy9tOvvz7hluWhnXtt7LAuoMybgZw33HE/A.',1,'me.jpeg','Ready to explore fun designs','Interactive multimedia design','ellen.deveth@hotmail.com','https://www.linkedin.com/in/ellendeveth/','https://github.com/ellendeveth','https://www.instagram.com/ellendeveth/'),
	(2,'r0857158@student.thomasmore.be','fiengerardi','$2y$12$uruF6vSBstHyjixiXf4Jke6YTQIk6o2cfGMpPglegmOgvCm1kCXbK',1,'juri-gianfrancesco-UCEtRnp8qR0-unsplash.jpg','Ready to ace designs and code.','Interactive Multimedia Design','fien.gerardi@gmail.com','https://www.linkedin.com/in/fien-gérardi-035003151/','https://github.com/fgrardi','https://www.instagram.com/fiengerardi/'),
	(3,'r0710641@student.thomasmore.be','yanellevdb','$2y$12$d.t4JXgKn4eWmhm7ZGZ3HumUFKcKLFtWxxqqGAHN2itXHeTqHub8a',1,'Knipsel.PNG','New member of the smash community','','',NULL,NULL,NULL),
	(4,'jadeapers@student.thomasmore.be','jadeapers','$2y$12$H2MrqzcKGCOfe7qITqM5iu/rxou58QKWUVt2E0l2pEiypE20sT8Zi',1,'default.png','New member of the smash community',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
