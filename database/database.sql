-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP EVENT IF EXISTS `password_reset_ttl`;;
CREATE EVENT `password_reset_ttl` ON SCHEDULE EVERY 1 HOUR STARTS '2015-02-07 03:03:13' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM password_reset WHERE created < NOW() - INTERVAL 24 HOUR;;

DELIMITER ;

DROP TABLE IF EXISTS `passwordreset`;
CREATE TABLE `passwordreset` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `hash` varchar(20) COLLATE utf8mb4_czech_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  CONSTRAINT `passwordreset_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


-- 2015-02-11 00:43:21