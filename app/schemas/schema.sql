-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.17-0ubuntu0.16.04.2 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5169
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for riot
CREATE DATABASE IF NOT EXISTS `riot` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `riot`;

-- Dumping structure for table riot.champions
CREATE TABLE IF NOT EXISTS `champions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `championId` smallint(6) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table riot.games
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matchId` bigint(20) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `lane` varchar(15) NOT NULL,
  `role` varchar(15) NOT NULL,
  `champion` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table riot.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` smallint(6) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `description` text,
  `plaintext` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table riot.match
CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mapId` tinyint(4) DEFAULT NULL,
  `championId` smallint(6) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `didWin` tinyint(1) DEFAULT NULL,
  `champLevel` tinyint(20) DEFAULT NULL,
  `goldEarned` smallint(6) DEFAULT NULL,
  `minionsKilled` smallint(6) DEFAULT NULL,
  `kills` tinyint(4) DEFAULT NULL,
  `deaths` tinyint(4) DEFAULT NULL,
  `assists` tinyint(4) DEFAULT NULL,
  `matchDuration` smallint(6) DEFAULT NULL,
  `spell1Id` tinyint(4) DEFAULT NULL,
  `spell2Id` tinyint(4) DEFAULT NULL,
  `item0` smallint(6) DEFAULT NULL,
  `item1` smallint(6) DEFAULT NULL,
  `item2` smallint(6) DEFAULT NULL,
  `item3` smallint(6) DEFAULT NULL,
  `item4` smallint(6) DEFAULT NULL,
  `item5` smallint(6) DEFAULT NULL,
  `item6` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table riot.summoner_spell
CREATE TABLE IF NOT EXISTS `summoner_spell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spellId` smallint(6) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
