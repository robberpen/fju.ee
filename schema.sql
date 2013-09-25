-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: fju
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Data`
--

DROP TABLE IF EXISTS `Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Data` (
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TreeID` int(11) NOT NULL,
  `LeafID` int(11) NOT NULL,
  `data` double NOT NULL,
  `Status` enum('regular','irregular','nodata','fixed') CHARACTER SET armscii8 NOT NULL DEFAULT 'regular',
  PRIMARY KEY (`DateTime`,`TreeID`,`LeafID`),
  KEY `TreeID` (`TreeID`),
  KEY `LeafID` (`LeafID`),
  CONSTRAINT `Data_ibfk_2` FOREIGN KEY (`TreeID`) REFERENCES `Tree` (`TreeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Data_ibfk_4` FOREIGN KEY (`LeafID`) REFERENCES `LeafID` (`LeafID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LeafID`
--

DROP TABLE IF EXISTS `LeafID`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LeafID` (
  `LeafID` int(11) NOT NULL,
  `LeafDescription` text NOT NULL,
  `Type` enum('root','tree','watt','temperature') NOT NULL,
  `TreeID` int(11) NOT NULL,
  `Note` text NOT NULL,
  `action` enum('test','reset') DEFAULT NULL,
  `min` int(11) NOT NULL DEFAULT '22',
  `max` int(11) NOT NULL DEFAULT '27',
  PRIMARY KEY (`LeafID`,`TreeID`),
  KEY `TreeID` (`TreeID`),
  CONSTRAINT `LeafID_ibfk_1` FOREIGN KEY (`TreeID`) REFERENCES `Tree` (`TreeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tree`
--

DROP TABLE IF EXISTS `Tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tree` (
  `TreeID` int(11) NOT NULL,
  `TreeDescription` text NOT NULL,
  PRIMARY KEY (`TreeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `name` tinytext,
  `password` tinytext,
  `phone` varchar(10) DEFAULT NULL,
  `index` int(11) NOT NULL AUTO_INCREMENT,
  KEY `index` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-13 20:03:06
