-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
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

-- Dumpen data van tabel smash.comments: ~0 rows (ongeveer)

-- Structuur van  tabel smash.followers wordt geschreven
CREATE TABLE IF NOT EXISTS `followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `following_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.followers: ~0 rows (ongeveer)

-- Structuur van  tabel smash.likes wordt geschreven
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.likes: ~0 rows (ongeveer)

-- Structuur van  tabel smash.posts wordt geschreven
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `tags` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.posts: ~16 rows (ongeveer)
INSERT INTO `posts` (`id`, `title`, `date`, `image`, `description`, `tags`, `user_id`) VALUES
	(9, 'Smash: branding and mobile app', '2022-04-30', 'project-smash.png', 'Mobile web application built for the course php', NULL, 2),
	(11, 'Hoppin: mobility mobile app', '2022-05-03', 'project-hoppin-fien-gerardi.png', 'Hoppin is made to make travelling easy with every vehicle.', NULL, 2),
	(12, 'Tingels: education app for children', '2022-05-03', 'project-tingels-fien-gerardi.png', 'Desktop app for children to make learning fun and accessible.', NULL, 2),
	(13, 'Sweet 16: branding for event weareimd', '2022-05-03', 'project-sweet16-fien-gerardi.jpg', 'Branding and website for celebrating 16 years of IMD!', NULL, 2),
	(15, 'Tingels: learning platform', '2022-05-03', 'tingels dribbble.png', 'A fun platform with educational videos for children', NULL, 1),
	(18, 'Connec: reconnect students', '2022-05-03', 'mockup connec.png', 'An idea to reconnect students through activities', NULL, 1),
	(19, 'Hoppin: transport app', '2022-05-03', 'hoppin-min.png', 'Transportation with much possibilities', NULL, 1),
	(21, 'Democrats abroad: marketing campaign', '2022-05-04', 'democratsabroad.jpg', 'Marketing campaign to engage Americans living in Belgium to vote for the American Elections', NULL, 3),
	(22, 'Skwikkl: online learning platform for children', '2022-05-04', 'skwikkl.png', 'An online platform where children can learn in a playful way', NULL, 3),
	(25, 'Grofgerief: an online platform for circular economy', '2022-05-04', 'grofgerief.png', 'An online website to make circular economy possible', NULL, 3),
	(26, 'Hoppin: combimobility app', '2022-05-04', 'hoppin.png', 'An app to improve mobility with public transport in Belgium', NULL, 3),
	(27, 'SLAM: connect vzw\'s with students', '2022-05-04', 'Slam.png', 'SLAM gives the opportunity to students to realise a real life project with non profit organisations', NULL, 1),
	(28, 'Johannes Gutenberg: One of the kids', '2022-05-07', '1.png', 'We were challenged to tell a historical story to children with animation. I made Johannes a best friend for the kids. ', NULL, 4),
	(29, 'Designing a logo for a startup', '2022-05-07', '5.png', 'This is a design for a logo for a startup working around qr codes for stores. They wanted a retro vibe. ', NULL, 4),
	(30, 'Enjoy Digital: A complete branding for a marketing agency', '2022-05-07', '3.png', 'A happy and young look, this was the main goal for Enjoy Digital\'s branding. We created a website, total branding and wrote the texts for the whole project. ', NULL, 4),
	(31, 'Tingels: An interactive learning platform for children', '2022-05-07', 'tingels.png', 'An interactive learning platform in a dashboard design where kids can grow in a fun way and with each other at their own pace. ', NULL, 4);

-- Structuur van  tabel smash.reports wordt geschreven
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.reports: ~0 rows (ongeveer)

-- Structuur van  tabel smash.reset_password wordt geschreven
CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.reset_password: ~0 rows (ongeveer)

-- Structuur van  tabel smash.tags wordt geschreven
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel smash.tags: ~23 rows (ongeveer)
INSERT INTO `tags` (`id`, `tag`, `post_id`) VALUES
	(7, '#design #development #app', 9),
	(8, '#design #branding #webapp', 10),
	(9, '#design #ux #ui', 11),
	(10, '#branding #ux #ui', 12),
	(11, '#branding #website #development', 13),
	(12, '#design #development #branding', 14),
	(13, '#ux #ui #design', 15),
	(14, '#logo #design', 16),
	(15, '#design #ui #development', 17),
	(16, '#ux #branding', 18),
	(17, '#ui #ux', 19),
	(18, '#design #branding #development', 20),
	(19, '#branding #marketing #advertisement', 21),
	(20, '#prototype #design', 22),
	(21, '#prototype #design', 23),
	(22, '#webdesign #coding #circulareconomy', 24),
	(23, '#webdesign #coding #circulareconomy', 25),
	(24, '#prototype #design', 26),
	(25, '#branding #design #development', 27),
	(26, '#design #animation #adobeanimate', 28),
	(27, '#logo #design #retrostyle', 29),
	(28, '#development #webdesign #branding', 30),
	(29, '#wireframing #webdesign #figma', 31);

-- Structuur van  tabel smash.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumpen data van tabel smash.users: ~4 rows (ongeveer)
INSERT INTO `users` (`id`, `email`, `username`, `password`, `is_admin`, `profile_pic`, `bio`, `education`, `second_email`, `social_linkedin`, `social_github`, `social_instagram`) VALUES
	(1, 'r0786673@student.thomasmore.be', 'ellendeveth', '$2y$12$uvFCVOYl8ptMDd3Tb/5EN.hEGbohUfb9sGh8C6A.pNWRbuAASycS6', NULL, 'me.jpeg', 'Ready to explore fun designs', 'Interactive multimedia design', 'ellen.deveth@hotmail.com', 'https://www.linkedin.com/in/ellendeveth/', 'https://github.com/ellendeveth', 'https://www.instagram.com/ellendeveth/'),
	(2, 'r0857158@student.thomasmore.be', 'fiengerardi', '$2y$12$uruF6vSBstHyjixiXf4Jke6YTQIk6o2cfGMpPglegmOgvCm1kCXbK', NULL, 'juri-gianfrancesco-UCEtRnp8qR0-unsplash.jpg', 'Ready to ace designs and code.', 'Interactive Multimedia Design', 'fien.gerardi@gmail.com', 'https://www.linkedin.com/in/fien-gérardi-035003151/', 'https://github.com/fgrardi', 'https://www.instagram.com/fiengerardi/'),
	(3, 'r0710641@student.thomasmore.be', 'yanellevdb', '$2y$12$d.t4JXgKn4eWmhm7ZGZ3HumUFKcKLFtWxxqqGAHN2itXHeTqHub8a', NULL, 'Knipsel.PNG', 'New member of the smash community', '', '', NULL, NULL, NULL),
	(4, 'jadeapers@student.thomasmore.be', 'jadeapers', '$2y$12$H2MrqzcKGCOfe7qITqM5iu/rxou58QKWUVt2E0l2pEiypE20sT8Zi', NULL, 'default.png', 'New member of the smash community', NULL, NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
