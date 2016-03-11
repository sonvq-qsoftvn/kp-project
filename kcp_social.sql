-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 15, 2016 at 03:57 AM
-- Server version: 5.5.48-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kpasappc_kcpasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `kcp_social`
--

CREATE TABLE IF NOT EXISTS `kcp_social` (
  `social_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_url` varchar(255) NOT NULL,
  `social_type` varchar(255) NOT NULL,
  `social_name` text NOT NULL,
  `social_lang` varchar(255) NOT NULL,
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `kcp_social`
--

INSERT INTO `kcp_social` (`social_id`, `social_url`, `social_type`, `social_name`, `social_lang`) VALUES
(42, 'https://www.facebook.com/bcs.kpasapp', 'FB', '', 'es,en'),
(41, 'https://www.facebook.com/master.kpasapp', 'FB', '', 'es'),
(40, 'https://www.facebook.com/groups/eventsbcs', 'FB', '', 'es'),
(44, 'https://www.facebook.com/groups/4sale.bcs/', 'FB', '', 'es');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
