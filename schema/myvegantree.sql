-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `mvt_accounts`;
CREATE TABLE `mvt_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `levels` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `vpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `mvt_bubbles`;
CREATE TABLE `mvt_bubbles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `family` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Vegan',
  `type` tinyint(1) DEFAULT '0',
  `photo` varchar(255) DEFAULT NULL,
  `bio` text NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `family` (`family`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `mvt_requests`;
CREATE TABLE `mvt_requests` (
  `idrequests` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) unsigned NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `accepted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idrequests`),
  KEY `from_id` (`from_id`),
  KEY `to_id` (`to_id`),
  CONSTRAINT `mvt_requests_ibfk_2` FOREIGN KEY (`from_id`) REFERENCES `mvt_accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mvt_requests_ibfk_3` FOREIGN KEY (`to_id`) REFERENCES `mvt_accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2019-02-24 17:55:30
