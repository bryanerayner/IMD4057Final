-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2013 at 04:02 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `abcd0001`
--
CREATE DATABASE IF NOT EXISTS `rayn0021` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rayn0021`;

-- --------------------------------------------------------

--
-- Table structure for table `mtm4057_meme_images`
--

DROP TABLE IF EXISTS `mtm4057_meme_images`;
CREATE TABLE IF NOT EXISTS `mtm4057_meme_images` (
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` char(44) NOT NULL,
  `mime_type` varchar(20) NOT NULL,
  `file_size` int(10) unsigned NOT NULL,
  `image_title` varchar(50) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mtm4057_meme_likes`
--

DROP TABLE IF EXISTS `mtm4057_meme_likes`;
CREATE TABLE IF NOT EXISTS `mtm4057_meme_likes` (
  `like_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `like_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `meme_id` int(10) unsigned NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mtm4057_meme_memes`
--

DROP TABLE IF EXISTS `mtm4057_meme_memes`;
CREATE TABLE IF NOT EXISTS `mtm4057_meme_memes` (
  `meme_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned NOT NULL COMMENT 'foreign key',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `top_text` varchar(100) NOT NULL,
  `bottom_text` varchar(100) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  PRIMARY KEY (`meme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
