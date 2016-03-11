-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2014 at 04:49 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `team5_reid`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `admin_email`, `role`, `created`, `modified`, `last_login`) VALUES
(1, 'admin', '751cb3f4aa17c36186f4856c8982bf27', 'achinta@gmail.com', 'superadmin', '2014-08-11 07:02:32', '2014-09-30 00:07:43', '2014-09-30 00:07:43'),
(2, 'reid', 'd043a60a513b9c651d3f614fa0c48bb8', 'reid@gmail.com', 'superadmin', '2014-08-18 09:26:39', '2014-12-01 14:52:49', '2014-12-01 02:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `appointmentmsgs`
--

CREATE TABLE IF NOT EXISTS `appointmentmsgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `sender_type` int(11) NOT NULL COMMENT '1. user, 2.clinic manager',
  `reciver_id` int(11) NOT NULL,
  `reciver_type` int(11) NOT NULL COMMENT '1. user, 2. clinic_manager',
  `appointment_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=Active post;0=Deleted(De-Activate post)',
  `send_notification` int(11) NOT NULL COMMENT '0=if clinic manager post,1=send notification to clinic manager if user post,2 = notification viewed by clinic manager',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `send_notification_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `appointmentmsgs`
--

INSERT INTO `appointmentmsgs` (`id`, `sender_id`, `sender_type`, `reciver_id`, `reciver_type`, `appointment_id`, `status`, `send_notification`, `message`, `added_date`, `send_notification_count`) VALUES
(1, 0, 0, 9, 2, 41, 1, 1, 'You have a new pending appointment, booked by Sumitra Roy on 11/23/2014(07:15 to 07:30) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-10 17:14:07', 1),
(2, 0, 0, 6, 1, 41, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/23/2014(07:15 to 07:30) is booked successfully. However it''s pending for approveal, you will get a notification when it confirmed.', '2014-11-10 17:14:07', 1),
(3, 0, 0, 120, 1, 42, 1, 1, 'You have a new appointment on 11/19/2014(06:45 to 07:00) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-10 00:00:00', 1),
(4, 0, 0, 6, 1, 35, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/"></a> on  ( to ) is confirmed.', '2014-11-10 00:00:00', 1),
(5, 0, 0, 6, 1, 35, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/10/2014 ( to ) is confirmed.', '2014-11-10 00:00:00', 1),
(6, 0, 0, 120, 1, 0, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is canceled. Please book another appointment.', '2014-11-10 18:25:15', 1),
(13, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is confirmed.', '2014-11-11 19:09:01', 1),
(11, 0, 0, 6, 1, 44, 1, 1, 'You have a new appointment on 11/12/2014 (07:30 to 07:45) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-11 18:58:53', 1),
(12, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is confirmed.', '2014-11-11 19:01:10', 1),
(10, 0, 0, 6, 1, 34, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is confirmed.', '2014-11-11 18:56:08', 1),
(14, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/"></a> on  ( to ) is resheduled. Please check new appointment time and confirm to continue.', '2014-11-11 19:09:25', 1),
(15, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is resheduled. Please check new appointment time and confirm to continue.', '2014-11-11 19:10:57', 1),
(16, 0, 0, 6, 1, 41, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/23/2014 is confirmed.', '2014-11-11 19:32:34', 1),
(17, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is confirmed.', '2014-11-11 19:34:04', 1),
(18, 0, 0, 6, 1, 44, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is resheduled. Please check new appointment time and confirm to continue.', '2014-11-11 19:40:16', 1),
(19, 0, 0, 9, 1, 44, 1, 1, 'User confirmed appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014.', '2014-11-11 19:40:36', 1),
(20, 0, 0, 9, 2, 45, 1, 1, 'You have a new pending appointment, booked by Sumitra Roy on 11/16/2014(06:45 to 07:00) at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-11 00:00:00', 1),
(21, 0, 0, 6, 1, 45, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/16/2014 (06:45 to 07:00) is booked successfully. However it''s pending for approveal, you will be notified when it confirmed.', '2014-11-11 19:41:35', 1),
(22, 0, 0, 6, 1, 45, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/16/2014 is confirmed.', '2014-11-11 19:41:51', 1),
(23, 0, 0, 9, 1, 41, 1, 1, 'User have resheduled an appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/23/2014. Please check new appointment time and confirm to continue.', '2014-11-11 19:55:34', 1),
(24, 0, 0, 120, 1, 42, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/19/2014 is resheduled. Please check new appointment time and confirm to continue.', '2014-11-11 19:58:28', 1),
(25, 0, 0, 9, 1, 42, 1, 1, 'User confirmed appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/19/2014.', '2014-11-11 19:59:03', 1),
(26, 0, 0, 6, 1, 0, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/23/2014 is canceled. Please book another appointment.', '2014-11-13 13:34:03', 1),
(27, 0, 0, 6, 1, 0, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/12/2014 is canceled. Please book another appointment.', '2014-11-13 13:37:30', 1),
(28, 0, 0, 120, 1, 46, 1, 1, 'You have a new appointment on 11/20/2014 (01:05 to 01:10) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-20 22:03:25', 1),
(29, 0, 0, 120, 1, 47, 1, 1, 'You have a new appointment on 11/20/2014 (01:10 to 01:15) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-20 22:05:13', 1),
(30, 0, 0, 120, 1, 48, 1, 1, 'You have a new appointment on 11/20/2014 (01:05 to 01:10) at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-20 22:08:15', 1),
(31, 0, 0, 120, 1, 0, 1, 1, 'Your appointment at <a href="http://www.phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/20/2014 is canceled. Please book another appointment.', '2014-11-20 22:09:45', 1),
(32, 0, 0, 9, 2, 49, 1, 1, 'You have a new pending appointment, booked by Sumitra Roy on 11/27/2014(01:00 to 01:15) at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-24 00:00:00', 1),
(34, 0, 0, 9, 1, 49, 1, 1, 'User have resheduled an appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/27/2014. Please check new appointment time and confirm to continue.', '2014-11-24 18:29:15', 1),
(35, 0, 0, 6, 1, 0, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/27/2014 is canceled. Please book another appointment.', '2014-11-24 19:24:40', 1),
(36, 0, 0, 9, 2, 50, 1, 1, 'You have a new pending appointment, booked by Sumitra Roy on 11/24/2014(03:15 to 03:30) at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/appointments/clinic_appointments">New Clinic1</a>.', '2014-11-24 00:00:00', 1),
(37, 0, 0, 6, 1, 50, 1, 1, 'Your appointment at <a href="http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/clinics/clincwall/6">New Clinic1</a> on 11/24/2014 (03:15 to 03:30) is booked successfully. However it''s pending for approveal, you will be notified when it confirmed.', '2014-11-24 22:48:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `rownum` int(11) NOT NULL,
  `mesage` text COLLATE utf8_unicode_ci NOT NULL,
  `added_on` datetime NOT NULL,
  `status` smallint(4) NOT NULL DEFAULT '0' COMMENT '0 = need approval from clinicmanager; 1=need approval from user, 2 = booked',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `uid`, `clinic_id`, `date`, `rownum`, `mesage`, `added_on`, `status`) VALUES
(1, 124, 6, '2014-12-05', 12, 'dsff', '2014-12-02 11:02:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `alies` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `click_doctors`
--

CREATE TABLE IF NOT EXISTS `click_doctors` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinicexceptions`
--

CREATE TABLE IF NOT EXISTS `clinicexceptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exceptiondate` date NOT NULL,
  `clinicid` int(11) NOT NULL COMMENT 'foreign key to clinics',
  `rownum` int(11) NOT NULL,
  `type` int(255) NOT NULL COMMENT '0=block exception,1=add exception',
  PRIMARY KEY (`id`),
  KEY `clinicid` (`clinicid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `clinicexceptions`
--

INSERT INTO `clinicexceptions` (`id`, `exceptiondate`, `clinicid`, `rownum`, `type`) VALUES
(9, '2014-11-25', 6, 39, 0),
(10, '2014-11-28', 6, 22, 0),
(11, '2014-11-28', 6, 26, 0),
(12, '2014-11-28', 6, 32, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cliniclikes`
--

CREATE TABLE IF NOT EXISTS `cliniclikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like` int(11) NOT NULL DEFAULT '0',
  `send_notification` int(11) NOT NULL COMMENT '1=send notification to clinic manager,2 = notification viewed by clinic manager',
  `added_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `cliniclikes`
--

INSERT INTO `cliniclikes` (`id`, `clinic_id`, `user_id`, `like`, `send_notification`, `added_date`) VALUES
(22, 6, 120, 1, 2, '2014-11-04'),
(25, 7, 120, 0, 0, '0000-00-00'),
(29, 6, 6, 1, 1, '2014-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE IF NOT EXISTS `clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `license` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `handphone` bigint(20) NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT 'Type of clinic speciality,0 by default',
  `likes` bigint(20) NOT NULL,
  `subtype` int(11) NOT NULL DEFAULT '0' COMMENT 'sub speciality if exists default 0 means no sub speciality',
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `waitingtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slot_time_diff` int(11) NOT NULL,
  `displaywaiting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=don''t display; 1=display',
  `allowpost` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=don''t allow, 1=allow',
  `lockwall` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=not locked; 1=locked',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=disapprove; 1=approve',
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datelastmodified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `clinicmanagersid` int(11) NOT NULL COMMENT 'foreign key to clinicmanagers',
  `send_notification` int(11) NOT NULL COMMENT '1=send notification to clinic manager,2 = notification viewed by clinic manager',
  `lat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `license` (`license`),
  KEY `clinicmanagersid` (`clinicmanagersid`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `license`, `handphone`, `url`, `type`, `likes`, `subtype`, `logo`, `about`, `waitingtime`, `slot_time_diff`, `displaywaiting`, `allowpost`, `lockwall`, `status`, `dateadded`, `datelastmodified`, `address`, `clinicmanagersid`, `send_notification`, `lat`, `lon`, `tags`, `postal_code`) VALUES
(6, 'New Clinic1', '123456', 6531043160, 'http://www.newclinic.com', 4, 2, 36, '77914144210476.png', '<p>\r\n	good boy</p>\r\n', '', 15, 0, 1, 0, 1, '0000-00-00 00:00:00', '2014-11-25 23:58:13', '<p>\r\n	180 Kitchener Road&nbsp; B2-29 Centre Management Office&nbsp; Singapore 208539.</p>\r\n', 9, 2, '1.3037868', '103.8358137', 'plastic surgery,cosmic surgery, cardiac surgery,surgery for diabetes', '0'),
(7, 'Test sumitra Clinic', '1212121', 654561237898, 'http://www.google1.com', 9, 0, 49, '', '<p>\r\n	hj</p>\r\n', '', 15, 0, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '<p>\r\n	asdasdasdad dasdasda</p>\r\n', 9, 2, '1.4560707', '103.8426627', '', '0'),
(8, 'urpaltestclnic', '1234567', 24467951, 'www.google.com', 9, 0, 49, 'abc.png', '<p>\r\n	This is a dental clinic.</p>\r\n', '1', 0, 0, 1, 1, 1, '2014-11-11 20:12:01', '2014-11-11 20:26:02', 'b.c.Road', 9, 1, '1.3146631', '103.8454093', '', '0'),
(13, 'Heart Clinic', '12345', 6598765432, 'heartclinic.com', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-26 11:17:18', '0000-00-00 00:00:00', 'saltlake', 127, 0, '', '', '', '700064'),
(14, 'MyTesr', 'qwerty', 65123456789, 'http://www.google.com', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-27 10:41:57', '0000-00-00 00:00:00', 'zxcvb', 136, 0, '', '', '', '7000123'),
(20, 'Ad', '1234556', 65, 'qwwe', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-27 11:41:02', '0000-00-00 00:00:00', 'sdfg', 134, 0, '', '', '', '70002552'),
(21, 'As', '1223445', 65, 'gghh@gig.com', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-27 11:53:46', '0000-00-00 00:00:00', 'kolkata', 134, 0, '', '', '', '9708855258'),
(22, 'Apollo#%%%$$&*$$', '1232=%%%&', 65, 'wddfddfvggffr', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-27 13:44:53', '0000-00-00 00:00:00', 'fgddgfbfhfddg', 139, 0, '', '', '', '14555589999665548888555477787'),
(34, 'Amri', '123455', 65, 'sdf', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-28 09:50:55', '0000-00-00 00:00:00', 'kolkata', 140, 0, '', '', '', '700030'),
(36, 'Aiims', '4567832678', 659870654123, 'www.google.com', 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, '2014-11-28 10:16:09', '0000-00-00 00:00:00', '33, Canaught Place', 140, 0, '', '', '', '600089');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'active=1,deleted=0',
  `posted_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `send_notification` int(11) NOT NULL COMMENT '0=if clinic manager give coment on his own post,1=send notification to clinic manager if user post,2 = notification viewed by clinic manager',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `clinic_id`, `post_id`, `user_id`, `comment`, `status`, `posted_date`, `send_notification`) VALUES
(1, 6, 32, 6, 'Ayan Sil', 1, '2014-10-28 15:21:38', 2),
(2, 6, 32, 6, 'wonderful.', 1, '2014-10-28 14:51:21', 2),
(3, 6, 30, 9, 'hello cup.', 1, '2014-10-28 13:24:13', 2),
(4, 6, 32, 6, 'test comment :)', 0, '2014-10-28 15:23:58', 2),
(5, 6, 32, 6, 'dsaddadad', 0, '2014-10-28 15:30:48', 2),
(6, 6, 32, 6, 'sasss111', 0, '2014-10-28 15:13:10', 2),
(7, 6, 30, 6, '', 0, '2014-10-28 13:54:57', 2),
(8, 6, 30, 6, ' Sudip saha Sudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip sahaSudip saha', 0, '2014-10-28 15:22:44', 2),
(9, 6, 28, 6, 'add koro.\r\nadd koro', 0, '2014-10-28 15:23:44', 2),
(10, 6, 33, 9, 'hello', 0, '2014-10-31 14:25:38', 0),
(11, 6, 33, 9, '', 0, '2014-10-31 14:25:37', 0),
(12, 6, 33, 9, '', 0, '2014-10-31 14:25:36', 0),
(13, 6, 33, 9, 'fsfsd', 0, '2014-10-31 14:25:33', 0),
(14, 6, 33, 9, 'ffgddsgs', 0, '2014-10-31 14:25:30', 0),
(15, 6, 32, 9, 'hi! now notification test.1', 1, '2014-11-05 09:54:23', 0),
(16, 6, 31, 9, 'comment test noti for owner send_noti =0', 1, '2014-11-05 09:56:24', 0),
(17, 6, 31, 6, 'user comment noti for user send_noti=1', 1, '2014-11-05 09:58:10', 2),
(18, 6, 28, 6, 'Arijit modak  post. [new post 123]', 1, '2014-11-05 13:13:44', 2),
(19, 6, 28, 6, 'hello  [new post 123].', 1, '2014-11-05 13:15:01', 2),
(20, 6, 27, 6, 'post Arjit modak post.[This is my 27-10-2014 post text.]->', 1, '2014-11-05 13:15:36', 2),
(21, 6, 27, 9, ' post Arjit modak post.[This is my 27-10-2014 post text.]-> Clinic Manager.', 1, '2014-11-05 13:18:04', 0),
(22, 6, 27, 6, 'after design check save.', 0, '2014-11-06 10:30:59', 2),
(23, 6, 38, 6, 'dsad', 1, '2014-11-16 11:56:29', 1),
(24, 6, 37, 6, 'aaa', 1, '2014-11-16 11:56:38', 0),
(25, 6, 38, 9, 'good', 1, '2014-11-17 13:00:04', 0),
(26, 6, 32, 6, 'hehehee', 1, '2014-11-20 12:28:05', 1),
(27, 7, 56, 6, 'hello', 0, '2014-11-24 12:54:13', 1),
(28, 7, 56, 6, 'hey hey watch this, it should be more like Facebook, when i click send, the message should appear without having to reload', 1, '2014-11-24 14:18:40', 1),
(29, 7, 56, 6, 'as above ', 1, '2014-11-24 14:18:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `companylogos`
--

CREATE TABLE IF NOT EXISTS `companylogos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `image_type` varchar(10) NOT NULL COMMENT 'C=Company logo;B=Banner Image',
  `featured` int(11) NOT NULL DEFAULT '0' COMMENT '0=not featured, 1= feaured in home',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `companylogos`
--

INSERT INTO `companylogos` (`id`, `company_name`, `company_logo`, `image_type`, `featured`, `created_date`) VALUES
(1, 'sd', 'no-avatar.jpg', 'C', 0, '2014-11-30 20:00:30'),
(2, 'ssaaa', 'dream_fulfill.jpg', 'B', 0, '2014-11-30 20:19:50'),
(3, 'ssd', '9381417438974.jpg', 'C', 0, '2014-12-01 03:32:54'),
(4, 'image ', '6661417439438.jpg', 'B', 0, '2014-12-01 03:40:38'),
(5, 'test image', '7851417439564.jpg', 'C', 0, '2014-12-01 03:42:44'),
(6, 'test again', '3491417445568.jpg', 'B', 0, '2014-12-01 05:22:48'),
(7, 'sdsdsfsf', '4541417447066.jpg', 'B', 0, '2014-12-01 05:47:46'),
(8, 'ytuir', '1831417447172.jpg', 'B', 0, '2014-12-01 05:49:32'),
(9, 'as', '4951417447213.jpg', 'C', 0, '2014-12-01 05:50:13'),
(10, 'fgh', '3181417447338.jpg', 'C', 0, '2014-12-01 05:52:18'),
(11, 'uorpr', '', 'C', 0, '2014-12-01 05:53:45'),
(12, 'cd', '3401417447683.jpg', 'C', 0, '2014-12-01 05:58:03'),
(13, 'd', '9991417447872.jpg', 'B', 0, '2014-12-01 06:01:12'),
(14, 'lkd', '4081417447986', 'C', 0, '2014-12-01 06:03:06'),
(15, 'last one', '1001417448621.jpg', 'B', 0, '2014-12-01 06:13:41'),
(16, '123', '5751417448917.jpg', 'C', 0, '2014-12-01 06:18:37'),
(17, 'Banner 123', '2001417449007.jpg', 'B', 0, '2014-12-01 06:20:07'),
(18, 'wonderful', '7461417449950.jpg', 'C', 0, '2014-12-02 06:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0->Inactive,1->Active,2->Deleted',
  `content_for_meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `page_name`, `alias`, `page_title`, `content`, `status`, `content_for_meta_description`) VALUES
(5, 'HomeDekko', 'homedekko', 'HomeDekko', '<div>\r\n	Thanks for registrating into our site</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rutrum est ac massa blandit molestie. In hac habitasse platea dictumst. Suspendisse non tortor sed lectus consequat laoreet ac nec orci. Aliquam facilisis suscipit elit sed auctor. Maecenas ornare eget sapien sit amet eleifend. Fusce varius fermentum nibh, ut sodales nisl rhoncus vel. Nullam egestas risus dolor, sit amet feugiat tortor cursus vel. Nullam fermentum ut odio vitae varius. Integer vestibulum dolor eget commodo sollicitudin. Aenean odio dolor, semper et ligula sed, sagittis feugiat mauris. Quisque non orci ornare, ullamcorper risus vitae, consectetur ipsum. Nulla magna ex, efficitur eget fermentum ut, viverra et ligula.</div>\r\n<div>\r\n	&nbsp;</div>\r\n', 1, ''),
(7, 'Terms of Use', 'terms-of-use', 'Terms of Use ', '<p>\r\n	This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one.</p>\r\n<p>\r\n	This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. This is s dummy content and will be replaced by the original one. &nbsp;Test pal</p>\r\n', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `l_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qualification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 in_active | 1 active',
  `clinic_id` int(11) NOT NULL COMMENT 'foreign key to clinics id',
  `featured` int(11) NOT NULL COMMENT '1=Featured for home,0=not feaured',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=92 ;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `f_name`, `l_name`, `title`, `img`, `qualification`, `active`, `clinic_id`, `featured`) VALUES
(89, 'Utpal', 'Poulik', 'Specialist', '92414153449246.jpg', 'M.B.B.S', 1, 6, 1),
(90, 'utjjal', 'fdg', 'dfg', '', 'fg', 1, 6, 1),
(91, 'Sumitra', 'Roy', 'F.R.C.S', '67714163134728.jpg', 'M.B.B.S', 1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `eligibilitieclincs`
--

CREATE TABLE IF NOT EXISTS `eligibilitieclincs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eligibiliti_id` int(11) NOT NULL,
  `clinc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eligibiliti_id` (`eligibiliti_id`),
  KEY `clinc_id` (`clinc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `eligibilitieclincs`
--

INSERT INTO `eligibilitieclincs` (`id`, `eligibiliti_id`, `clinc_id`) VALUES
(7, 4, 8),
(8, 4, 8),
(12, 4, 7),
(39, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `eligibilities`
--

CREATE TABLE IF NOT EXISTS `eligibilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eligibilities_parent_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `eligibility_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eligibility_date_last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `eligibilities`
--

INSERT INTO `eligibilities` (`id`, `name`, `eligibilities_parent_id`, `status`, `eligibility_date_added`, `eligibility_date_last_modified`) VALUES
(1, 'Main Eligibility', 0, 1, '2014-11-25 05:24:57', '0000-00-00 00:00:00'),
(3, 'test1', 1, 1, '2014-11-24 21:34:00', '0000-00-00 00:00:00'),
(4, 'hello', 3, 1, '2014-10-13 04:04:15', '2014-11-24 19:51:33'),
(5, 'new ', 1, 1, '2014-10-15 00:09:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_pass_reqs`
--

CREATE TABLE IF NOT EXISTS `forgot_pass_reqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `added_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `forgot_pass_reqs`
--

INSERT INTO `forgot_pass_reqs` (`id`, `user_id`, `status`, `added_date`) VALUES
(5, 126, 0, '2014-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE IF NOT EXISTS `insurances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insurances_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `insurance_parent_id` int(11) NOT NULL,
  `insurances_status` tinyint(4) NOT NULL DEFAULT '1',
  `insurances_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `insurances_date_last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `insurances_name`, `insurance_parent_id`, `insurances_status`, `insurances_date_added`, `insurances_date_last_modified`) VALUES
(1, 'Main Insurance', 0, 1, '2014-11-24 12:55:55', '0000-00-00 00:00:00'),
(7, 'Insurance 2', 10, 1, '2014-08-21 21:23:52', '2014-08-29 04:24:54'),
(10, 'Insurance 1', 1, 1, '2014-08-26 06:28:01', '2014-08-29 04:24:40'),
(11, 'Insurance 3', 1, 1, '2014-08-26 06:28:06', '2014-08-29 04:25:02'),
(12, 'Insurance 4', 11, 1, '2014-08-26 06:28:10', '2014-08-29 04:25:09'),
(14, 'blocker1', 11, 1, '2014-10-15 00:09:39', '2014-11-24 20:26:32'),
(15, 'test insurance11', 12, 1, '2014-11-24 03:04:50', '2014-11-24 20:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `insurancetoclinics`
--

CREATE TABLE IF NOT EXISTS `insurancetoclinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insuranceid` int(11) NOT NULL COMMENT 'foreign key to insurances',
  `clinicid` int(11) NOT NULL COMMENT 'foreign key to clinics',
  PRIMARY KEY (`id`),
  KEY `insuranceid` (`insuranceid`),
  KEY `clinicid` (`clinicid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=94 ;

--
-- Dumping data for table `insurancetoclinics`
--

INSERT INTO `insurancetoclinics` (`id`, `insuranceid`, `clinicid`) VALUES
(37, 10, 7),
(92, 12, 6),
(93, 14, 6);

-- --------------------------------------------------------

--
-- Table structure for table `messagecontents`
--

CREATE TABLE IF NOT EXISTS `messagecontents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromid` int(11) NOT NULL,
  `fromuname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fromtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'which type fromid relates to',
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `datesent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isfromtrash` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=No; 1=Yes;',
  `isdraft` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=draft;1=complete',
  PRIMARY KEY (`id`),
  KEY `fromid` (`fromid`),
  KEY `fromuname` (`fromuname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `messagecontents`
--

INSERT INTO `messagecontents` (`id`, `fromid`, `fromuname`, `fromtype`, `subject`, `message`, `datesent`, `isfromtrash`, `isdraft`) VALUES
(1, 6, 'reid_user', 'user', 'All test', 'All ', '2014-10-27 11:26:54', 0, 1),
(2, 9, 'reid_clinicmanager', 'Clinicmanager', 'All Manager test', 'gggg', '2014-10-27 11:27:37', 0, 1),
(17, 6, 'reid_user', 'user', 'greeting utpal da.', 'Good morning! how r u?', '2014-10-30 08:25:54', 0, 1),
(18, 6, 'reid_user', 'user', 'good 1 my boy.', 'good 1 my boy.good 1 my boy.good 1 my boy.\r\ngood 1 my boy.', '2014-10-30 08:55:53', 0, 1),
(19, 2, 'reid', 'superadmin', 'ayan test admin', '<p>ayan test admi.</p>', '2014-11-12 13:29:00', 1, 1),
(20, 6, 'reid_user', 'user', 'sdadasds', 'sdadasadasdasd', '2014-10-30 12:08:33', 0, 1),
(21, 6, 'reid_user', 'user', 'hello hi!', 'wonderful evening.', '2014-10-30 12:25:09', 0, 1),
(22, 2, 'reid', 'superadmin', 'giving reply', '<p>giving reply.', '2014-10-30 12:26:22', 0, 1),
(25, 2, 'reid', 'superadmin', '', '', '2014-10-30 18:27:29', 0, 0),
(26, 2, 'reid', 'superadmin', '', '', '2014-10-31 10:47:33', 0, 0),
(27, 6, 'reid_user', 'user', 'hi! Test 4=11=2014', 'hi! Test 4=11=2014hi! Test 4=11=2014hi! Test 4=11=2014', '2014-11-04 09:22:23', 0, 1),
(28, 2, 'reid', '', '', '', '2014-11-04 13:41:14', 0, 0),
(29, 2, 'reid', 'superadmin', '', '', '2014-11-04 17:35:25', 0, 0),
(30, 2, 'reid', 'superadmin', '', '', '2014-11-05 14:28:23', 0, 0),
(31, 2, 'reid', 'superadmin', 'Notification message send by admin to all', '<p>', '2014-11-05 14:30:43', 0, 1),
(32, 9, 'reid_clinicmanager', 'Clinicmanager', 'noti test from clientmanager(9) to reid user', 'noti test from clientmanager(9) to reid user.', '2014-11-13 09:44:12', 1, 1),
(33, 120, 'user2', 'user', 'hi! from user2 to reid_user', 'hi! from user2 to reid_user', '2014-11-05 17:26:42', 0, 1),
(34, 120, 'user2', 'user', '2nd msg from user2 to reid_user', '2nd msg from user2 to reid_user', '2014-11-05 17:28:34', 0, 1),
(35, 6, 'reid_user', 'user', 'After Design Change Check.', 'After Design Change Check. After Design Change Check. test', '2014-11-06 10:34:00', 0, 1),
(36, 2, 'reid', '', '', '', '2014-11-06 11:57:15', 0, 0),
(37, 2, 'reid', 'superadmin', '', '', '2014-11-06 14:27:44', 0, 0),
(38, 2, 'reid', 'superadmin', '', '', '2014-11-06 15:45:36', 0, 0),
(39, 2, 'reid', 'superadmin', '', '', '2014-11-10 14:10:15', 0, 0),
(40, 6, 'reid_user', 'user', 'hey dude', 'dudee!! ', '2014-11-23 11:06:19', 0, 1),
(41, 6, 'reid_user', 'user', 'hi', 'thanks for ur messgae, how are you today ? ', '2014-11-23 13:54:00', 0, 1),
(42, 6, 'reid_user', 'user', '', 'hahahaha ', '2014-11-23 13:54:15', 0, 1),
(43, 6, 'reid_user', 'user', 'sadads', 'dsads', '2014-11-24 14:14:39', 0, 1),
(44, 6, 'reid_user', 'user', 'watch this page, it reloads', 'when i post ', '2014-11-24 14:16:12', 0, 1),
(45, 6, 'reid_user', 'user', '', 'see that? the page has to reload.. it has to be more responsive. when i click post, the post appears\r\n', '2014-11-24 14:16:36', 0, 1),
(46, 9, 'reid_clinicmanager', 'Clinicmanager', 'After Design Change Check.', 'hi!hello', '2014-11-24 14:17:13', 0, 1),
(47, 6, 'reid_user', 'user', '', 'i understand u want to focus on functionality now, so we can do this responsive feature later.. ', '2014-11-24 14:17:19', 0, 1),
(48, 9, 'reid_clinicmanager', 'Clinicmanager', 'again', 'again..', '2014-11-24 14:18:30', 0, 1),
(49, 2, 'reid', 'superadmin', '', '', '2014-11-24 14:41:21', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `touname` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `totype` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `isviewed` int(1) NOT NULL DEFAULT '0' COMMENT '0=Not Viewed | = viewed',
  `istotrash` int(1) NOT NULL DEFAULT '0' COMMENT '0=No | 1=yes',
  `replytoid` int(11) NOT NULL DEFAULT '0' COMMENT 'id of the message this message is sent as a reply. A reply id 0 means noreply is sent for this message',
  `send_notification` int(11) NOT NULL COMMENT '0=no notification[might be in draft],1=notification send',
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  KEY `toid` (`toid`),
  KEY `touname` (`touname`),
  KEY `replytoid` (`replytoid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=183 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message_id`, `toid`, `touname`, `totype`, `isviewed`, `istotrash`, `replytoid`, `send_notification`) VALUES
(12, 1, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 0, 0, 0),
(15, 2, 6, 'reid_user', 'user', 1, 0, 0, 0),
(40, 17, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 0, 0, 0),
(41, 18, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 1, 0, 0),
(44, 19, 6, 'reid_user', 'user', 1, 0, 0, 0),
(45, 20, 2, 'reid', 'superadmin', 1, 0, 0, 0),
(46, 21, 2, 'reid', 'superadmin', 1, 0, 0, 0),
(52, 22, 6, 'reid_user', 'user', 1, 0, 0, 0),
(87, 25, 9, 'reid_clinicmanager', 'Clinicmanager', 0, 0, 0, 0),
(88, 27, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 0, 0, 0),
(161, 31, 6, 'reid_user', 'user', 1, 0, 0, 1),
(162, 31, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 0, 0, 2),
(163, 31, 120, 'user2', 'user', 1, 0, 0, 1),
(164, 32, 6, 'reid_user', 'user', 1, 1, 0, 1),
(165, 33, 6, 'reid_user', 'user', 1, 0, 0, 1),
(166, 34, 6, 'reid_user', 'user', 1, 1, 0, 1),
(167, 35, 9, 'reid_clinicmanager', 'Clinicmanager', 1, 0, 0, 2),
(173, 37, 9, 'reid_clinicmanager', 'Clinicmanager', 0, 0, 0, 0),
(174, 40, 2, 'reid', 'superadmin', 0, 0, 0, 1),
(175, 41, 120, 'user2', 'user', 0, 0, 0, 1),
(176, 42, 120, 'user2', 'user', 0, 0, 0, 1),
(177, 43, 2, 'reid', 'superadmin', 0, 0, 0, 1),
(178, 44, 2, 'reid', 'superadmin', 0, 0, 0, 1),
(179, 45, 2, 'reid', 'superadmin', 0, 0, 0, 1),
(180, 46, 1, 'admin', 'superadmin', 0, 0, 0, 1),
(181, 47, 2, 'reid', 'superadmin', 0, 0, 0, 1),
(182, 48, 1, 'admin', 'superadmin', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `openinghours`
--

CREATE TABLE IF NOT EXISTS `openinghours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinicid` int(11) NOT NULL,
  `fromhour` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `tohour` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fromminutes` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `tominutes` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `day` int(11) NOT NULL COMMENT '1=monday; 2=tuesday; 3=wednesday; 4=thursday; 5=friday; 6=saturday; 7=sunday',
  PRIMARY KEY (`id`),
  KEY `clinicid` (`clinicid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `openinghours`
--

INSERT INTO `openinghours` (`id`, `clinicid`, `fromhour`, `tohour`, `fromminutes`, `tominutes`, `day`) VALUES
(1, 6, '05', '10', '00', '00', 1),
(3, 6, '07', '08', '00', '00', 3),
(4, 6, '06', '20', '00', '00', 7),
(5, 6, '12', '14', '00', '00', 3),
(6, 6, '12', '14', '00', '00', 1),
(9, 7, '12', '18', '13', '05', 4),
(11, 7, '00', '23', '00', '59', 1),
(12, 6, '02', '04', '10', '15', 1),
(13, 6, '03', '12', '15', '00', 2),
(14, 6, '01', '02', '00', '00', 4),
(15, 8, '04', '07', '08', '09', 1),
(16, 7, '05', '17', '16', '04', 2),
(17, 8, '12', '14', '00', '30', 1),
(18, 6, '01', '09', '00', '00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE IF NOT EXISTS `sitesettings` (
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`field_name`, `field_value`) VALUES
('SITENAME', 'SeeDoctor.sg'),
('METATITLE', 'SeeDoctor.sg'),
('METADATA', 'SeeDoctor.sg'),
('facebook_link', 'https://www.facebook.com/SeeDoctor.sg'),
('twitter_link', 'https://www.twitter.com/SeeDoctor.sg'),
('youtube_link', 'https://www.youtube.com/SeeDoctor.sg'),
('google_link', 'https://www.plus.google.com/SeeDoctor.sg'),
('facebook_app_id', '278048352382827'),
('get_in_touch_text', ''),
('get_in_touch_content', ''),
('feature_in_text', '');

-- --------------------------------------------------------

--
-- Table structure for table `specialities`
--

CREATE TABLE IF NOT EXISTS `specialities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specialities_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=General Type,1=Dentist Type',
  `specialities_parent_id` int(11) NOT NULL DEFAULT '1',
  `specialities_status` tinyint(1) NOT NULL DEFAULT '1',
  `specialities_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `specialities_date_last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=110 ;

--
-- Dumping data for table `specialities`
--

INSERT INTO `specialities` (`id`, `specialities_name`, `type`, `specialities_parent_id`, `specialities_status`, `specialities_date_added`, `specialities_date_last_modified`) VALUES
(1, 'Main Speciality', 0, 0, 1, '2014-08-13 05:44:28', '0000-00-00 00:00:00'),
(4, 'Polyclinic', 0, 1, 1, '2014-08-13 05:47:11', '0000-00-00 00:00:00'),
(6, 'General Practitioner', 0, 1, 1, '2014-08-13 05:47:11', '0000-00-00 00:00:00'),
(7, 'Medical Specialties', 0, 1, 1, '2014-08-13 05:47:11', '2014-08-13 04:16:52'),
(8, 'General Dentistry', 1, 1, 1, '2014-08-13 05:47:11', '0000-00-00 00:00:00'),
(9, 'Dental Specialty', 1, 1, 1, '2014-08-13 05:47:11', '0000-00-00 00:00:00'),
(10, 'Aesthetic Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(11, 'Anesthesiology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(12, 'Breast Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(13, 'Cardiology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(14, 'Cardiothoracic Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(15, 'Colorectal Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(16, 'Dermatology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(17, 'Endocrinology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(18, 'Gastroenterology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(19, 'Gastrointestinal Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(20, 'General Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(21, 'Geriatric Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(22, 'Infectious Disease', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(23, 'Internal Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(24, 'Nephrology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(25, 'Neurology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(26, 'Neurosurgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(27, 'Obstetrics & Gynecology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(28, 'Oncology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(29, 'Ophthalmology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(30, 'Orthopedic Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(31, 'Otorhinolaryngology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(32, 'Pain Management', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(33, 'Palliative Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(34, 'Pathology & Labs', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(35, 'Pediatrics', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(36, 'Pediatric Surgery', 0, 4, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(37, 'Plastic Surgery', 0, 4, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(38, 'Psychiatry', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(39, 'Radiology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(40, 'Rehabilitation Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(41, 'Rheumatology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(42, 'Sleep Medicine123', 0, 7, 1, '2014-08-13 05:55:31', '2014-08-21 21:13:51'),
(43, 'Sports Medicine', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(44, 'Transplant Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(45, 'Urology', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(46, 'Vascular Surgery', 0, 7, 1, '2014-08-13 05:55:31', '0000-00-00 00:00:00'),
(49, 'Oral & Maxillofacial Surgery', 1, 9, 1, '2014-08-13 05:57:16', '0000-00-00 00:00:00'),
(50, 'Orthodontics', 1, 9, 1, '2014-08-13 05:57:16', '0000-00-00 00:00:00'),
(51, 'Pediatric Dentistry', 1, 9, 1, '2014-08-13 05:57:16', '0000-00-00 00:00:00'),
(52, 'Periodontics', 1, 9, 1, '2014-08-13 05:57:16', '0000-00-00 00:00:00'),
(53, 'Prosthodontics', 1, 9, 1, '2014-08-13 05:57:16', '0000-00-00 00:00:00'),
(100, 'A&E', 0, 1, 1, '2014-08-13 05:47:11', '2014-08-24 21:10:35'),
(102, 'test', 0, 1, 1, '2014-09-01 02:47:09', '0000-00-00 00:00:00'),
(103, 'yoyi', 0, 1, 1, '2014-10-15 00:06:59', '0000-00-00 00:00:00'),
(104, 'p', 0, 4, 1, '2014-10-15 00:18:46', '0000-00-00 00:00:00'),
(105, 'dhiraj', 0, 1, 1, '2014-10-15 00:19:46', '0000-00-00 00:00:00'),
(106, 'kumar', 0, 105, 1, '2014-10-15 00:20:04', '0000-00-00 00:00:00'),
(108, 'Aesthetic Dentistry', 0, 9, 1, '2014-11-06 04:33:14', '0000-00-00 00:00:00'),
(109, 'Endodontics', 0, 9, 1, '2014-11-06 04:35:44', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `text`, `date_added`, `date_last_modified`) VALUES
(6, '<p>\r\n	Here is an update. This update is being bodified now this should come before another update now</p>\r\n<p>\r\n	&nbsp;</p>\r\n', '2014-09-01 10:32:20', '2014-09-01 05:02:20'),
(15, '<p>\r\n	hello Doctor!</p>\r\n', '2014-09-01 10:17:11', '2014-09-01 04:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_type` int(11) NOT NULL COMMENT '1. user, 2. Clinic manager',
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clinicmanagers_email` (`email`),
  UNIQUE KEY `clinicmanagers_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=142 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `gender`, `date_of_birth`, `phone_number`, `status`, `date_created`, `date_modified`, `user_type`, `facebook_id`) VALUES
(6, 'reid_user', 'Sumitra', 'Roy', '25d55ad283aa400af464c76d713c07ad', 'arijit.modak.unified@gmail.com', 'M', '2004-02-08', '0123456789', 1, '2014-10-08 00:54:39', '0000-00-00 00:00:00', 1, ''),
(9, 'reid_clinicmanager', 'Arijit', 'Modak', '25d55ad283aa400af464c76d713c07ad', 'arijit.unified1@gmail.com', 'M', '2004-04-04', '1234567890', 1, '2014-10-08 02:12:21', '0000-00-00 00:00:00', 2, ''),
(120, 'user2', 'sudip', 'saha', '25d55ad283aa400af464c76d713c07ad', 'user@gmail.com', 'M', '2014-11-04', '', 1, '2014-11-03 22:40:07', '0000-00-00 00:00:00', 1, '0'),
(121, 'daw', 'awd', 'awd', '25d55ad283aa400af464c76d713c07ad', 'wadwa@waw.com', 'M', '0000-00-00', '', 1, '2014-11-11 04:06:20', '0000-00-00 00:00:00', 1, ''),
(122, 'infotech_unified_facebook', '', '', '', '', 'M', '1985-07-16', '', 1, '2014-11-13 04:14:44', '0000-00-00 00:00:00', 1, '278106842384955'),
(124, 'utpal_1stuser', 'utpal', 'poulik', '', 'utpalpoulik123456@gmail.com', 'M', '2012-11-12', '9831043160', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '1'),
(126, 'utpal_1stuser123', 'utpal', 'poulik', 'e10adc3949ba59abbe56e057f20f883e', 'utpal.unified@gmail.com', 'M', '2012-11-12', '9831043160', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0'),
(127, 'abcd', 'AA', 'BB', '81dc9bdb52d04dc20036dbd8313ed055', 'a@a.com', 'M', '2012-11-14', '123456789', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(128, 'Aa', '', '', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'aa@aa.com', 'F', '2014-11-26', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(129, 'Abc', '', '', '25d55ad283aa400af464c76d713c07ad', 'aaa@gmail.com', 'M', '1996-12-18', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(130, 'dghfhb', 'Sdff', 'Sdfgh', '25d55ad283aa400af464c76d713c07ad', 'sffgh@gmail.com', 'M', '1988-04-18', '1234567890', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(131, 'Dddd', '', '', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'aaa@aa.com', 'F', '2010-08-20', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(132, 'Anuva', '', '', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'anuva.unified@gmail.com', 'F', '2004-05-21', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(133, 'Agni', '', '', '25d55ad283aa400af464c76d713c07ad', 'agnideep.unified@gmail.com', 'M', '1989-06-15', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(134, 'adip', 'Agnideep', 'Pal', '25f9e794323b453885f5181f1b624d0b', 'agnideep@gmail.com', 'M', '1988-11-27', '9087456321', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(135, 'ssc', 'ss', 'cc', '25d55ad283aa400af464c76d713c07ad', 'b@b.com', 'F', '1983-11-26', '123456789', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(136, 'testdev', 'Test', 'Dev', '25d55ad283aa400af464c76d713c07ad', 'test@gmail.com', 'M', '1988-11-27', '1234567890', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(137, 'ggg', 'Sd', 'Hgg', '25f9e794323b453885f5181f1b624d0b', 'dd@fd.com', 'F', '1981-08-24', '8984112235', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(138, 'Qwerty', '', '', '25d55ad283aa400af464c76d713c07ad', 'qw@gmail.com', 'F', '1989-06-20', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ''),
(139, 'asd', 'Hello', 'World', '25d55ad283aa400af464c76d713c07ad', 'hello@gmail.com', '', '2001-04-17', '7485236908', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(140, 'asdf', 'Anuva', 'Roy', '22d7fe8c185003c98f97e5d6ced420c7', 'aa@ss.com', 'F', '1990-11-28', '98254741125', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, ''),
(141, 'Dip', '', '', '25f9e794323b453885f5181f1b624d0b', 'bb@bb.com', 'F', '2009-07-20', '0', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `wallposts`
--

CREATE TABLE IF NOT EXISTS `wallposts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `alias_fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias_lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias_designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `post_title` text COLLATE utf8_unicode_ci NOT NULL,
  `post_main_text` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_text` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modify_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(5) NOT NULL COMMENT '1=Active post;0=Deleted(De-Activate post)',
  `send_notification` int(11) NOT NULL COMMENT '0=if clinic manager post,1=send notification to clinic manager if user post,2 = notification viewed by clinic manager',
  `featured` int(11) NOT NULL COMMENT '0= not featured to home,1=featured to home',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

--
-- Dumping data for table `wallposts`
--

INSERT INTO `wallposts` (`id`, `user_id`, `alias_fname`, `alias_lname`, `alias_designation`, `clinic_id`, `post_title`, `post_main_text`, `attachment_image`, `attachment_heading`, `attachment_text`, `attachment_url`, `post_create_time`, `post_modify_time`, `status`, `send_notification`, `featured`) VALUES
(27, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'post1', 'This is my 27-10-2014 post text.', '1414389528cup1.jpeg', 'Black Cup', 'This is balck cup.', 'http://blackcup.com', '2014-10-23 00:28:48', '2014-11-13 08:28:03', 1, 0, 1),
(28, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'post2', 'new post 123', '1414416518cup1.jpeg', '', '', '', '2014-10-26 22:16:19', '2014-10-27 15:58:38', 1, 0, 0),
(29, 9, 'sumitra', 'roy', 'Developer', 6, 'post3', 'again check', '', '', '', '', '2014-10-26 22:17:22', '2014-10-26 22:17:22', 1, 0, 1),
(30, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'post4', 'Just Now new post', '1414414306cup4.jpg', 'attachment', 'this is the attachment .', 'www.attchment.com/', '2014-10-27 01:00:44', '2014-10-27 15:23:50', 0, 0, 0),
(31, 9, 'Arijit2', 'Modak3', 'Clinic Manager4', 6, 'post5', 'now1', '1414406129141027039920140331_204105-1-1.jpg', '5', '6', '7', '2014-10-27 13:05:29', '2014-10-27 15:20:16', 1, 0, 0),
(32, 9, 'Ayan', 'Sil', 'Doctor', 6, 'post6', 'My First Test Post', '1414417336user_update_from_the_heart.jpg', 'Watch for our new appointment system', 'Its easy to use ', '', '2014-10-27 16:12:16', '2014-10-27 16:13:35', 1, 0, 0),
(33, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'post7', '', NULL, '', '', '', '2014-10-31 08:34:10', '2014-10-31 08:34:10', 1, 0, 0),
(35, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'post8', '123', '1415110202app_icon.png', 'ewr', 'wre', 'wre', '2014-11-04 16:40:02', '2014-11-04 16:40:02', 1, 0, 0),
(37, 6, 'Sumitra', 'Roy', 'User', 6, 'post9', 'ghj', '1415111355Screenshot.png', '', '', '', '2014-11-04 16:59:15', '2014-11-04 16:59:15', 1, 2, 1),
(38, 9, 'Sumitra', 'Roy', 'User', 6, 'Post Title from reid_user', 'Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. Post Title from reid_user. ', '1415260040Screenshot-3.png', 'Test Attachment heading about See Doctor.', 'Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. Test Attachment heading about See Doctor. ', 'http://phppowerhousedemo.com/webroot/team5/SeeDoctor.sg.alpha/', '2014-11-06 10:17:20', '2014-11-06 12:58:49', 1, 2, 0),
(39, 6, 'Sumitra', 'Roy', 'User', 6, '', 'hehehhe', NULL, '', '', '', '2014-11-16 12:00:47', '2014-11-16 12:00:47', 1, 1, 0),
(40, 6, 'Sumitra', 'Roy', 'User', 6, '', 'hehehhe', NULL, '', '', '', '2014-11-16 12:01:28', '2014-11-16 12:01:28', 0, 1, 0),
(46, 9, 'Arijit', 'Modak', 'Clinic Manager', 6, 'Check after validation  and file  upload error fix.', 'Check after validation  and file  upload error fix.Check after validation  and file  upload error fix.Check after validation  and file  upload error fix.Check after validation  and file  upload error fix.Check after validation  and file  upload error fix.', '1416218316congo_tm5_2008245_lrg.jpg', '', '', '', '2014-11-17 12:21:56', '2014-11-17 13:50:37', 1, 0, 1),
(47, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, '', '', NULL, '', '', '', '2014-11-21 16:04:01', '2014-11-21 16:04:01', 0, 0, 0),
(48, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, '', '', NULL, '', '', '', '2014-11-21 16:16:52', '2014-11-21 16:16:52', 0, 0, 0),
(49, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, '', '', NULL, '', '', '', '2014-11-21 16:19:47', '2014-11-21 16:19:47', 0, 0, 0),
(50, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, '', '', NULL, '', '', '', '2014-11-21 16:20:44', '2014-11-21 16:20:44', 0, 0, 0),
(51, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, '', '', NULL, '', '', '', '2014-11-21 16:23:00', '2014-11-21 16:23:00', 0, 0, 0),
(52, 9, 'Arijit', 'Modak', 'Clinic Manager', 8, 'Testing Post ', 'Testing post main text.Testing post main text.Testing post main text.Testing post main text.Testing post main text.', NULL, '', '', '', '2014-11-21 16:26:41', '2014-11-21 16:26:41', 1, 0, 1),
(53, 6, '11', '11', '11', 6, '1231', '2131', '14167333431.jpg', '3123', '21312', '', '2014-11-23 11:32:23', '2014-11-23 11:32:23', 1, 1, 1),
(54, 6, 'Sumitra1', 'Roy1', 'User1', 8, '11', '11', NULL, '', '', '', '2014-11-23 13:46:47', '2014-11-23 13:46:47', 0, 1, 0),
(55, 6, 'Sumitra', 'Roy', 'User', 8, 'test check', 'test check main test check maintest check main  test check main test check main', NULL, '', '', '', '2014-11-24 10:09:18', '2014-11-24 10:09:18', 0, 1, 0),
(56, 9, 'Arijit', 'Modak', 'Clinic Manager', 7, 'Post Title from reid ', 'post ts24-11-2014', NULL, '', '', '', '2014-11-24 12:53:30', '2014-11-24 12:53:30', 1, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clinicexceptions`
--
ALTER TABLE `clinicexceptions`
  ADD CONSTRAINT `clinicexceptions_ibfk_1` FOREIGN KEY (`clinicid`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cliniclikes`
--
ALTER TABLE `cliniclikes`
  ADD CONSTRAINT `cliniclikes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliniclikes_ibfk_2` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clinics`
--
ALTER TABLE `clinics`
  ADD CONSTRAINT `clinics_ibfk_2` FOREIGN KEY (`clinicmanagersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eligibilitieclincs`
--
ALTER TABLE `eligibilitieclincs`
  ADD CONSTRAINT `eligibilitieclincs_ibfk_1` FOREIGN KEY (`eligibiliti_id`) REFERENCES `eligibilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eligibilitieclincs_ibfk_2` FOREIGN KEY (`clinc_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forgot_pass_reqs`
--
ALTER TABLE `forgot_pass_reqs`
  ADD CONSTRAINT `forgot_pass_reqs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurancetoclinics`
--
ALTER TABLE `insurancetoclinics`
  ADD CONSTRAINT `insurancetoclinics_ibfk_1` FOREIGN KEY (`insuranceid`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurancetoclinics_ibfk_2` FOREIGN KEY (`clinicid`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messagecontents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `openinghours`
--
ALTER TABLE `openinghours`
  ADD CONSTRAINT `openinghours_ibfk_1` FOREIGN KEY (`clinicid`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallposts`
--
ALTER TABLE `wallposts`
  ADD CONSTRAINT `wallposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wallposts_ibfk_2` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
