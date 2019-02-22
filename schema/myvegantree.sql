SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `vrdntf_myvegantree` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vrdntf_myvegantree`;

DROP TABLE IF EXISTS `mvt_accounts`;
CREATE TABLE `mvt_accounts` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date` int(11) NOT NULL,
  `levels` tinyint(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `vpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `mvt_bubbles`;
CREATE TABLE `mvt_bubbles` (
  `date` tinyint(4) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family` smallint(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Vegan',
  `type` tinyint(1) NOT NULL,
  `attached` tinyint(1) NOT NULL DEFAULT '0',
  `photo` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `level` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `mvt_requests`;
CREATE TABLE `mvt_requests` (
  `idrequests` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) unsigned NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `accepted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idrequests`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

