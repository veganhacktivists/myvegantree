-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `vrdntf_myvegantree` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vrdntf_myvegantree`;

CREATE TABLE `mvt_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `levels` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `vpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `mvt_accounts` (`id`, `name`, `username`, `password`, `date`, `levels`, `email`, `vpassword`) VALUES
(4,	'David',	'davidvanbeveren',	'$2y$10$Sdxk/F6kowX0XvGQSCgzHe8bdf9.HBHru9u/dOre.yoOTKLk/.tfC',	'0000-00-00 00:00:00',	0,	'david.vanbeveren@gmail.com',	'$2y$10$akRgS7SLXTHxBLIbaJrfGezAJVQmeLKpqzvv5uXk6ddvY4VKNzQue'),
(5,	'Alan',	'AlanSpurlock',	'$2y$10$tFlJrszgGgMcg.uxpAdX0e919gqnpD0Akab2G/luyV1A1BmNnwPy2',	'0000-00-00 00:00:00',	0,	'alanspurlock@hotmail.com',	'b1d1ab72336885719b522a1920d56e5c'),
(6,	'Kris',	'kristopherb',	'$2y$10$tFlJrszgGgMcg.uxpAdX0e919gqnpD0Akab2G/luyV1A1BmNnwPy2',	'0000-00-00 00:00:00',	0,	'angst@tutanota.com',	'5289632b10e7ebdaa10ade3fe38b78df'),
(7,	'Sergio',	'Sergio',	'$2y$10$tFlJrszgGgMcg.uxpAdX0e919gqnpD0Akab2G/luyV1A1BmNnwPy2',	'0000-00-00 00:00:00',	0,	'david.vanbeveren@gmail.com',	'5289632b10e7ebdaa10ade3fe38b78df'),
(8,	'0',	'samantha',	'$2y$10$tFlJrszgGgMcg.uxpAdX0e919gqnpD0Akab2G/luyV1A1BmNnwPy2',	'0000-00-00 00:00:00',	0,	'sam.vanbeveren@gmail.com',	'b1d1ab72336885719b522a1920d56e5c'),
(10,	'0',	'Switch Statement',	'$2y$10$tFlJrszgGgMcg.uxpAdX0e919gqnpD0Akab2G/luyV1A1BmNnwPy2',	'0000-00-00 00:00:00',	0,	'switch.morality@gmail.com',	'5289632b10e7ebdaa10ade3fe38b78df'),
(20,	'0',	'test',	'$2y$10$F.dzIMyfJzCdU5p6Zeq42ebGGsae0NV5Exj7R9yjo8TxHT55MiF3C',	'0000-00-00 00:00:00',	0,	'david.vanbeveren22222222@gmail.com',	'$2y$10$27JOiIoaC9FSH8X246wple090gj3BJVUmHMjl0TwpK2OpU1DlNXoe'),
(21,	'0',	'samvan',	'$2y$10$Bcv.MZZP3wYZw7zc9uAG4OM0zJ3oCuVt6Px8hxjcjlImveShLhkB6',	'2019-02-24 06:44:00',	0,	'sdasdsa@dddd.com',	'$2y$10$IyfCvl/R99vUr0aHUQ62LuOcIm6DO8xOPB8ioUotBOeo6nRE6NTB2'),
(22,	'0',	'barker',	'$2y$10$I9ybgEwdvHLmV0n60TOqAutJFV7N32Zyk1ocPaXLS6NLTpPbJo2ba',	'2019-02-24 09:21:08',	0,	'dbarkerinbox@gmail.com',	'$2y$10$yIxm4bo3c/Bt/709bFsyOeF51ckzW85jbIfz/FZimPC7xHjNYQE9C'),
(23,	'0',	'barker2',	'$2y$10$3xcYxAa5IyCjvLjxHSOdJuWYBXqD1C2tvIvlkedVDaPajQi3udYwq',	'2019-02-24 09:21:53',	0,	'dbarkerinbox@gmail.com',	'$2y$10$C72ALRxiCv8DJbjQ6KxkDeNiMRZnglAzx2c.1GX2U7JwWmaPmRk4q'),
(24,	'0',	'dbarkz2',	'$2y$10$cPDsRV70ScSyq15i2AC0V.rQtaz1QW8B3KMw3f0UTK5TrXDwR8z4m',	'2019-02-24 10:58:18',	0,	'dbarkerinbox@gmail.com',	'$2y$10$DDka34JAoo3/oMaBITIyBuUDAmB/r5pzXEWLt6VIny39Bjv6bC6nK'),
(25,	'0',	'dbarkz',	'$2y$10$qOIcyF9gxSOd9Lp76K0NZezhNI2hCrWAOnrVYvoGFnVfgZm3TYhmC',	'2019-02-24 10:59:09',	0,	'dbarkerinbox@gmail.com',	'$2y$10$rNBTapUDojd0R0qmYALILeqnhe0BKUWWhafNDuX9RTnG0gJWfh3YO');

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

INSERT INTO `mvt_bubbles` (`id`, `account_id`, `date`, `family`, `name`, `status`, `type`, `photo`, `bio`, `level`, `parent`) VALUES
(28,	4,	'0000-00-00 00:00:00',	4,	'David',	'Vegan',	0,	'uploads/cHJvZmlsZQ_1549848706.jpg',	'',	0,	0),
(29,	NULL,	'0000-00-00 00:00:00',	4,	'Abby',	'Vegan',	0,	'uploads/MjE3MzE4NjRfMTY1MzA2NzEzMTQwMTA3Nl83MjkyNDkxOTUzNTM3ODcxNjMyX28_1549848718.jpg',	'Bio Notes Goes Here',	0,	28),
(33,	NULL,	'0000-00-00 00:00:00',	4,	'Nancy',	'Getting there',	0,	'uploads/Z3JhbmRfZGF1Z2h0ZXI_1546407933.png',	'',	0,	29),
(34,	NULL,	'0000-00-00 00:00:00',	4,	'Samantha',	'Vegan',	0,	'uploads/ZGF1Z2h0ZXI_1546407975.png',	'',	0,	28),
(36,	NULL,	'0000-00-00 00:00:00',	4,	'Cambria',	'Vegetarian',	0,	'uploads/c29u_1546408066.png',	'note',	0,	28),
(37,	NULL,	'0000-00-00 00:00:00',	4,	'Dan',	'Getting there',	0,	'',	'',	0,	34),
(43,	NULL,	'0000-00-00 00:00:00',	4,	'undersam',	'Vegan',	1,	'',	'',	0,	30),
(44,	NULL,	'0000-00-00 00:00:00',	4,	'dasdsad',	'Vegan',	1,	'',	'',	0,	30),
(45,	NULL,	'0000-00-00 00:00:00',	4,	'asdsadsa',	'Vegan',	2,	'',	'',	0,	30),
(46,	NULL,	'0000-00-00 00:00:00',	4,	'hi',	'Vegan',	1,	'',	'',	0,	31),
(47,	NULL,	'0000-00-00 00:00:00',	4,	'Michael',	'Getting there',	0,	'',	'',	0,	28),
(48,	NULL,	'0000-00-00 00:00:00',	4,	'Ophelia',	'Vegan',	0,	'',	'',	0,	28),
(53,	NULL,	'0000-00-00 00:00:00',	4,	'Kristopher',	'Vegan',	0,	'',	'',	0,	28),
(55,	NULL,	'0000-00-00 00:00:00',	4,	'Ryan',	'Getting there',	0,	'',	'',	0,	32),
(56,	NULL,	'0000-00-00 00:00:00',	4,	'Heather',	'Vegan',	0,	'',	'',	0,	53),
(57,	7,	'0000-00-00 00:00:00',	7,	'Sergio',	'Vegan',	0,	'',	'',	0,	0),
(59,	NULL,	'0000-00-00 00:00:00',	12,	'test1',	'',	0,	'',	'',	0,	0),
(60,	NULL,	'0000-00-00 00:00:00',	13,	'test2',	'',	0,	'',	'',	0,	0),
(61,	NULL,	'0000-00-00 00:00:00',	0,	'test3',	'',	0,	'',	'',	0,	0),
(62,	NULL,	'0000-00-00 00:00:00',	0,	'test4',	'',	0,	'',	'',	0,	0),
(63,	NULL,	'0000-00-00 00:00:00',	16,	'test5',	'Vegan',	0,	'',	'',	0,	0),
(64,	NULL,	'0000-00-00 00:00:00',	17,	'test6',	'Vegan',	0,	'',	'',	0,	0),
(66,	NULL,	'2019-02-23 13:22:28',	7,	'Brian',	'Vegan',	0,	'',	'',	0,	57),
(67,	NULL,	'2019-02-23 13:23:43',	7,	'Sarah',	'Vegetarian',	0,	'',	'just a note',	0,	57),
(68,	NULL,	'2019-02-23 16:51:42',	7,	'Jan',	'Getting there',	0,	'',	'',	0,	67),
(69,	NULL,	'2019-02-23 16:52:17',	7,	'Thomas',	'Vegetarian',	0,	'',	'',	0,	67),
(70,	NULL,	'2019-02-23 16:52:32',	7,	'Sandy',	'Plant-Based',	0,	'',	'',	0,	69),
(71,	NULL,	'2019-02-23 21:10:20',	4,	'Jorge',	'Getting there',	0,	'',	'',	0,	65),
(72,	21,	'2019-02-24 06:44:00',	21,	'samvan',	'Vegan',	0,	NULL,	'',	0,	0),
(74,	23,	'2019-02-24 09:21:53',	23,	'barker',	'Vegan',	0,	NULL,	'',	0,	0),
(80,	24,	'2019-02-24 10:58:18',	24,	'dbarkz',	'Vegan',	0,	NULL,	'',	0,	0),
(81,	25,	'2019-02-24 10:59:09',	25,	'dbarkz',	'Vegan',	0,	NULL,	'',	0,	0),
(82,	NULL,	'2019-02-24 11:00:02',	24,	'Test',	'Vegan',	0,	'',	'',	0,	80),
(87,	NULL,	'2019-02-24 15:42:23',	4,	'Heidi',	'Vegan',	0,	'',	'',	0,	53),
(88,	NULL,	'2019-02-24 17:07:23',	4,	'wwq',	'Vegan',	0,	'',	'',	0,	29),
(89,	NULL,	'2019-02-24 21:30:36',	4,	'plantttt',	'Plant-Based',	0,	'',	'',	0,	88),
(90,	NULL,	'2019-02-25 09:10:03',	4,	'life',	'Plant-Based',	0,	'',	'',	0,	89),
(91,	NULL,	'2019-02-25 13:47:49',	24,	'gfhhgh',	'Vegan',	0,	'',	'',	0,	82),
(92,	NULL,	'2019-02-25 13:48:01',	24,	'hfhghgf',	'Vegan',	0,	'',	'',	0,	82),
(94,	NULL,	'2019-02-25 13:48:19',	24,	'ghjghgjghj',	'Vegan',	0,	'',	'',	0,	82),
(95,	NULL,	'2019-02-25 15:20:17',	25,	'dgdgdgdfg',	'Vegan',	0,	'',	'',	0,	81),
(96,	NULL,	'2019-02-25 15:26:15',	25,	'thgfhhgh',	'Vegan',	0,	'',	'',	0,	81);

CREATE TABLE `mvt_requests` (
  `idrequests` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) unsigned NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `accepted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ignored` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrequests`),
  UNIQUE KEY `from_id_to_id` (`from_id`,`to_id`),
  KEY `from_id` (`from_id`),
  KEY `to_id` (`to_id`),
  CONSTRAINT `mvt_requests_ibfk_2` FOREIGN KEY (`from_id`) REFERENCES `mvt_accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mvt_requests_ibfk_3` FOREIGN KEY (`to_id`) REFERENCES `mvt_accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `mvt_requests` (`idrequests`, `from_id`, `to_id`, `accepted`, `ignored`) VALUES
(1,	4,	7,	1,	1),
(2,	7,	8,	0,	0),
(5,	7,	5,	0,	0);

-- 2019-02-25 21:27:58
