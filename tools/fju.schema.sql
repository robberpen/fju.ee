-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2014 at 03:54 PM
-- Server version: 5.5.37
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fju`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `name` tinytext,
  `password` tinytext,
  `email` tinytext NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `index` int(11) NOT NULL AUTO_INCREMENT,
  KEY `index` (`index`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `Data`
--

CREATE TABLE IF NOT EXISTS `Data` (
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TreeID` int(11) NOT NULL,
  `LeafID` int(11) NOT NULL,
  `data` double NOT NULL,
  `Status` enum('regular','irregular','nodata','fixed') CHARACTER SET armscii8 NOT NULL DEFAULT 'regular',
  PRIMARY KEY (`DateTime`,`TreeID`,`LeafID`),
  KEY `TreeID` (`TreeID`),
  KEY `LeafID` (`LeafID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LeafID`
--

CREATE TABLE IF NOT EXISTS `LeafID` (
  `LeafID` int(11) NOT NULL,
  `LeafDescription` text NOT NULL,
  `Type` enum('root','tree','watt','temperature') NOT NULL,
  `TreeID` int(11) NOT NULL,
  `Note` text NOT NULL,
  `action` enum('test','reset') DEFAULT NULL,
  `min` int(11) NOT NULL DEFAULT '22',
  `max` int(11) NOT NULL DEFAULT '27',
  PRIMARY KEY (`LeafID`,`TreeID`),
  KEY `TreeID` (`TreeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Tree`
--

CREATE TABLE IF NOT EXISTS `Tree` (
  `TreeID` int(11) NOT NULL,
  `TreeDescription` text NOT NULL,
  PRIMARY KEY (`TreeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Data`
--
ALTER TABLE `Data`
  ADD CONSTRAINT `Data_ibfk_2` FOREIGN KEY (`TreeID`) REFERENCES `Tree` (`TreeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Data_ibfk_4` FOREIGN KEY (`LeafID`) REFERENCES `LeafID` (`LeafID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LeafID`
--
ALTER TABLE `LeafID`
  ADD CONSTRAINT `LeafID_ibfk_1` FOREIGN KEY (`TreeID`) REFERENCES `Tree` (`TreeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
