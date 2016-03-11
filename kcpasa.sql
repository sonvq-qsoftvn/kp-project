-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 17, 2013 at 04:28 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kcpasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `kcp_admin`
--

CREATE TABLE IF NOT EXISTS `kcp_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(50) NOT NULL DEFAULT '',
  `password` char(100) NOT NULL DEFAULT '',
  `fname` varchar(222) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(222) NOT NULL,
  `sex` char(30) NOT NULL,
  `phone` char(100) NOT NULL,
  `fax` char(100) NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `seller_type` int(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `admin_type` int(1) NOT NULL,
  `recover_pass` varchar(100) NOT NULL,
  `recover_time` datetime NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Admin information' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kcp_admin`
--

INSERT INTO `kcp_admin` (`admin_id`, `username`, `password`, `fname`, `lname`, `email`, `sex`, `phone`, `fax`, `time_zone`, `seller_type`, `organization_id`, `admin_type`, `recover_pass`, `recover_time`) VALUES
(1, 'administrator', '21232f297a57a5a743894a0e4a801fc3', '', '', '', '', '', '', '', 0, 1, 1, 'admin', '0000-00-00 00:00:00'),
(2, 'amit', 'e10adc3949ba59abbe56e057f20f883e', 'Amit', 'Banerjee', 'amit.unified@gmail.com', 'M', '9876543210', '', '', 0, 1, 0, 'vlncaws8', '2013-06-10 18:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_category_by_event`
--

CREATE TABLE IF NOT EXISTS `kcp_category_by_event` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `kcp_category_by_event`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_city`
--

CREATE TABLE IF NOT EXISTS `kcp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `county_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `kcp_city`
--

INSERT INTO `kcp_city` (`id`, `county_id`, `city_name`) VALUES
(9, 1, 'Ciudad ConstituciÃ³n'),
(10, 1, 'Ciudad Insurgentes'),
(11, 1, 'Puerto San Carlos'),
(12, 1, 'Puerto Adolfo LÃ³pez Mateos'),
(13, 1, 'Villa Ignacio Zaragoza'),
(14, 1, 'Villa Morelos'),
(15, 1, 'Benito JuÃ¡rez'),
(16, 1, 'Las Barrancas'),
(17, 1, 'San Miguel de ComondÃº'),
(18, 1, 'Puerto CortÃ©s'),
(19, 1, 'San JosÃ© de ComondÃº'),
(20, 2, 'La Paz'),
(21, 2, 'Todos Santos'),
(22, 2, 'El Centenario'),
(23, 2, 'Chametla'),
(24, 2, 'El Pescadero'),
(25, 2, 'El Triunfo'),
(26, 2, 'La Ventana'),
(27, 2, 'MelitÃ³n AlbÃ¡Ã±ez DomÃ­nguez'),
(28, 2, 'Los Barriles'),
(29, 2, 'San Antonio'),
(30, 2, 'Puerto Chale'),
(31, 3, 'Ensenada Blanca'),
(32, 3, 'LigÃ¼Ã­'),
(33, 3, 'Loreto'),
(34, 3, 'Puerto Agua Verde'),
(35, 3, 'San Javier'),
(36, 4, 'San José del Cabo'),
(37, 4, 'Cabo San Lucas'),
(38, 4, 'La Ribera'),
(39, 4, 'Miraflores. '),
(40, 4, 'Santiago.'),
(41, 5, 'Guerrero Negro'),
(42, 5, 'Santa RosalÃ­a'),
(43, 5, 'Villa Alberto AndrÃ©s Alvarado ArÃ¡mburo'),
(44, 5, 'MulegÃ©'),
(45, 5, 'BahÃ­a Tortugas'),
(46, 5, 'San Francisco'),
(47, 5, 'Las Margaritas'),
(48, 5, 'BahÃ­a AsunciÃ³n'),
(49, 5, 'El Silencio'),
(50, 5, 'Gustavo DÃ­az Ordaz'),
(51, 5, 'Estero de la Bocana'),
(52, 5, 'Punta Abreojos'),
(53, 5, 'San Ignacio'),
(54, 1, 'Los MÃ¡rtires'),
(55, 5, 'San Bruno'),
(56, 1, 'Ejido San Lucas');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_countries`
--

CREATE TABLE IF NOT EXISTS `kcp_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL DEFAULT '',
  `printable_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=249 ;

--
-- Dumping data for table `kcp_countries`
--

INSERT INTO `kcp_countries` (`id`, `iso`, `printable_name`, `iso3`, `numcode`) VALUES
(1, 'AF', 'Afghanistan', 'AFG', 4),
(2, 'AL', 'Albania', 'ALB', 8),
(3, 'DZ', 'Algeria', 'DZA', 12),
(4, 'AS', 'American Samoa', 'ASM', 16),
(5, 'AD', 'Andorra', 'AND', 20),
(6, 'AO', 'Angola', 'AGO', 24),
(7, 'AI', 'Anguilla', 'AIA', 660),
(8, 'AQ', 'Antarctica', NULL, NULL),
(9, 'AG', 'Antigua and Barbuda', 'ATG', 28),
(10, 'AR', 'Argentina', 'ARG', 32),
(11, 'AM', 'Armenia', 'ARM', 51),
(12, 'AW', 'Aruba', 'ABW', 533),
(13, 'AU', 'Australia', 'AUS', 36),
(14, 'AT', 'Austria', 'AUT', 40),
(15, 'AZ', 'Azerbaijan', 'AZE', 31),
(16, 'BS', 'Bahamas', 'BHS', 44),
(17, 'BH', 'Bahrain', 'BHR', 48),
(18, 'BD', 'Bangladesh', 'BGD', 50),
(19, 'BB', 'Barbados', 'BRB', 52),
(20, 'BY', 'Belarus', 'BLR', 112),
(21, 'BE', 'Belgium', 'BEL', 56),
(22, 'BZ', 'Belize', 'BLZ', 84),
(23, 'BJ', 'Benin', 'BEN', 204),
(24, 'BM', 'Bermuda', 'BMU', 60),
(25, 'BT', 'Bhutan', 'BTN', 64),
(26, 'BO', 'Bolivia', 'BOL', 68),
(27, 'BA', 'Bosnia and Herzegovina', 'BIH', 70),
(28, 'BW', 'Botswana', 'BWA', 72),
(29, 'BV', 'Bouvet Island', NULL, NULL),
(30, 'BR', 'Brazil', 'BRA', 76),
(31, 'IO', 'British Indian Ocean Territory', NULL, NULL),
(32, 'BN', 'Brunei Darussalam', 'BRN', 96),
(33, 'BG', 'Bulgaria', 'BGR', 100),
(34, 'BF', 'Burkina Faso', 'BFA', 854),
(35, 'BI', 'Burundi', 'BDI', 108),
(36, 'KH', 'Cambodia', 'KHM', 116),
(37, 'CM', 'Cameroon', 'CMR', 120),
(38, 'CA', 'Canada', 'CAN', 124),
(39, 'CV', 'Cape Verde', 'CPV', 132),
(40, 'KY', 'Cayman Islands', 'CYM', 136),
(41, 'CF', 'Central African Republic', 'CAF', 140),
(42, 'TD', 'Chad', 'TCD', 148),
(43, 'CL', 'Chile', 'CHL', 152),
(44, 'CN', 'China', 'CHN', 156),
(45, 'CX', 'Christmas Island', NULL, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, NULL),
(47, 'CO', 'Colombia', 'COL', 170),
(48, 'KM', 'Comoros', 'COM', 174),
(49, 'CG', 'Congo', 'COG', 178),
(50, 'CD', 'Congo, the Democratic Republic of the', 'COD', 180),
(51, 'CK', 'Cook Islands', 'COK', 184),
(52, 'CR', 'Costa Rica', 'CRI', 188),
(53, 'CI', 'Cote D''Ivoire', 'CIV', 384),
(54, 'HR', 'Croatia', 'HRV', 191),
(55, 'CU', 'Cuba', 'CUB', 192),
(56, 'CY', 'Cyprus', 'CYP', 196),
(57, 'CZ', 'Czech Republic', 'CZE', 203),
(58, 'DK', 'Denmark', 'DNK', 208),
(59, 'DJ', 'Djibouti', 'DJI', 262),
(60, 'DM', 'Dominica', 'DMA', 212),
(61, 'DO', 'Dominican Republic', 'DOM', 214),
(62, 'EC', 'Ecuador', 'ECU', 218),
(63, 'EG', 'Egypt', 'EGY', 818),
(64, 'SV', 'El Salvador', 'SLV', 222),
(65, 'GQ', 'Equatorial Guinea', 'GNQ', 226),
(66, 'ER', 'Eritrea', 'ERI', 232),
(67, 'EE', 'Estonia', 'EST', 233),
(68, 'ET', 'Ethiopia', 'ETH', 231),
(69, 'FK', 'Falkland Islands (Malvinas)', 'FLK', 238),
(70, 'FO', 'Faroe Islands', 'FRO', 234),
(71, 'FJ', 'Fiji', 'FJI', 242),
(72, 'FI', 'Finland', 'FIN', 246),
(73, 'FR', 'France', 'FRA', 250),
(74, 'GF', 'French Guiana', 'GUF', 254),
(75, 'PF', 'French Polynesia', 'PYF', 258),
(76, 'TF', 'French Southern Territories', NULL, NULL),
(77, 'GA', 'Gabon', 'GAB', 266),
(78, 'GM', 'Gambia', 'GMB', 270),
(79, 'GE', 'Georgia', 'GEO', 268),
(80, 'DE', 'Germany', 'DEU', 276),
(81, 'GH', 'Ghana', 'GHA', 288),
(82, 'GI', 'Gibraltar', 'GIB', 292),
(83, 'GR', 'Greece', 'GRC', 300),
(84, 'GL', 'Greenland', 'GRL', 304),
(85, 'GD', 'Grenada', 'GRD', 308),
(86, 'GP', 'Guadeloupe', 'GLP', 312),
(87, 'GU', 'Guam', 'GUM', 316),
(88, 'GT', 'Guatemala', 'GTM', 320),
(89, 'GN', 'Guinea', 'GIN', 324),
(90, 'GW', 'Guinea-Bissau', 'GNB', 624),
(91, 'GY', 'Guyana', 'GUY', 328),
(92, 'HT', 'Haiti', 'HTI', 332),
(93, 'HM', 'Heard Island and Mcdonald Islands', NULL, NULL),
(94, 'VA', 'Holy See (Vatican City State)', 'VAT', 336),
(95, 'HN', 'Honduras', 'HND', 340),
(96, 'HK', 'Hong Kong', 'HKG', 344),
(97, 'HU', 'Hungary', 'HUN', 348),
(98, 'IS', 'Iceland', 'ISL', 352),
(99, 'IN', 'India', 'IND', 356),
(100, 'ID', 'Indonesia', 'IDN', 360),
(101, 'IR', 'Iran, Islamic Republic of', 'IRN', 364),
(102, 'IQ', 'Iraq', 'IRQ', 368),
(103, 'IE', 'Ireland', 'IRL', 372),
(104, 'IL', 'Israel', 'ISR', 376),
(105, 'IT', 'Italy', 'ITA', 380),
(106, 'JM', 'Jamaica', 'JAM', 388),
(107, 'JP', 'Japan', 'JPN', 392),
(108, 'JO', 'Jordan', 'JOR', 400),
(109, 'KZ', 'Kazakhstan', 'KAZ', 398),
(110, 'KE', 'Kenya', 'KEN', 404),
(111, 'KI', 'Kiribati', 'KIR', 296),
(112, 'KP', 'Korea, Democratic People''s Republic of', 'PRK', 408),
(113, 'KR', 'Korea, Republic of', 'KOR', 410),
(114, 'KW', 'Kuwait', 'KWT', 414),
(115, 'KG', 'Kyrgyzstan', 'KGZ', 417),
(116, 'LA', 'Lao People''s Democratic Republic', 'LAO', 418),
(117, 'LV', 'Latvia', 'LVA', 428),
(118, 'LB', 'Lebanon', 'LBN', 422),
(119, 'LS', 'Lesotho', 'LSO', 426),
(120, 'LR', 'Liberia', 'LBR', 430),
(121, 'LY', 'Libyan Arab Jamahiriya', 'LBY', 434),
(122, 'LI', 'Liechtenstein', 'LIE', 438),
(123, 'LT', 'Lithuania', 'LTU', 440),
(124, 'LU', 'Luxembourg', 'LUX', 442),
(125, 'MO', 'Macao', 'MAC', 446),
(126, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807),
(127, 'MG', 'Madagascar', 'MDG', 450),
(128, 'MW', 'Malawi', 'MWI', 454),
(129, 'MY', 'Malaysia', 'MYS', 458),
(130, 'MV', 'Maldives', 'MDV', 462),
(131, 'ML', 'Mali', 'MLI', 466),
(132, 'MT', 'Malta', 'MLT', 470),
(133, 'MH', 'Marshall Islands', 'MHL', 584),
(134, 'MQ', 'Martinique', 'MTQ', 474),
(135, 'MR', 'Mauritania', 'MRT', 478),
(136, 'MU', 'Mauritius', 'MUS', 480),
(137, 'YT', 'Mayotte', NULL, NULL),
(138, 'MX', 'Mexico', 'MEX', 484),
(139, 'FM', 'Micronesia, Federated States of', 'FSM', 583),
(140, 'MD', 'Moldova, Republic of', 'MDA', 498),
(141, 'MC', 'Monaco', 'MCO', 492),
(142, 'MN', 'Mongolia', 'MNG', 496),
(143, 'MS', 'Montserrat', 'MSR', 500),
(144, 'MA', 'Morocco', 'MAR', 504),
(145, 'MZ', 'Mozambique', 'MOZ', 508),
(146, 'MM', 'Myanmar', 'MMR', 104),
(147, 'NA', 'Namibia', 'NAM', 516),
(148, 'NR', 'Nauru', 'NRU', 520),
(149, 'NP', 'Nepal', 'NPL', 524),
(150, 'NL', 'Netherlands', 'NLD', 528),
(151, 'AN', 'Netherlands Antilles', 'ANT', 530),
(152, 'NC', 'New Caledonia', 'NCL', 540),
(153, 'NZ', 'New Zealand', 'NZL', 554),
(154, 'NI', 'Nicaragua', 'NIC', 558),
(155, 'NE', 'Niger', 'NER', 562),
(156, 'NG', 'Nigeria', 'NGA', 566),
(157, 'NU', 'Niue', 'NIU', 570),
(158, 'NF', 'Norfolk Island', 'NFK', 574),
(159, 'MP', 'Northern Mariana Islands', 'MNP', 580),
(160, 'NO', 'Norway', 'NOR', 578),
(161, 'OM', 'Oman', 'OMN', 512),
(162, 'PK', 'Pakistan', 'PAK', 586),
(163, 'PW', 'Palau', 'PLW', 585),
(164, 'PS', 'Palestinian Territory, Occupied', NULL, NULL),
(165, 'PA', 'Panama', 'PAN', 591),
(166, 'PG', 'Papua New Guinea', 'PNG', 598),
(167, 'PY', 'Paraguay', 'PRY', 600),
(168, 'PE', 'Peru', 'PER', 604),
(169, 'PH', 'Philippines', 'PHL', 608),
(170, 'PN', 'Pitcairn', 'PCN', 612),
(171, 'PL', 'Poland', 'POL', 616),
(172, 'PT', 'Portugal', 'PRT', 620),
(173, 'PR', 'Puerto Rico', 'PRI', 630),
(174, 'QA', 'Qatar', 'QAT', 634),
(175, 'RE', 'Reunion', 'REU', 638),
(176, 'RO', 'Romania', 'ROM', 642),
(177, 'RU', 'Russian Federation', 'RUS', 643),
(178, 'RW', 'Rwanda', 'RWA', 646),
(179, 'SH', 'Saint Helena', 'SHN', 654),
(180, 'KN', 'Saint Kitts and Nevis', 'KNA', 659),
(181, 'LC', 'Saint Lucia', 'LCA', 662),
(182, 'PM', 'Saint Pierre and Miquelon', 'SPM', 666),
(183, 'VC', 'Saint Vincent and the Grenadines', 'VCT', 670),
(184, 'WS', 'Samoa', 'WSM', 882),
(185, 'SM', 'San Marino', 'SMR', 674),
(186, 'ST', 'Sao Tome and Principe', 'STP', 678),
(187, 'SA', 'Saudi Arabia', 'SAU', 682),
(188, 'SN', 'Senegal', 'SEN', 686),
(189, 'CS', 'Serbia', NULL, 381),
(190, 'SC', 'Seychelles', 'SYC', 690),
(191, 'SL', 'Sierra Leone', 'SLE', 694),
(192, 'SG', 'Singapore', 'SGP', 702),
(193, 'SK', 'Slovakia', 'SVK', 703),
(194, 'SI', 'Slovenia', 'SVN', 705),
(195, 'SB', 'Solomon Islands', 'SLB', 90),
(196, 'SO', 'Somalia', 'SOM', 706),
(197, 'ZA', 'South Africa', 'ZAF', 710),
(198, 'GS', 'South Georgia and the South Sandwich Islands', NULL, NULL),
(199, 'ES', 'Spain', 'ESP', 724),
(200, 'LK', 'Sri Lanka', 'LKA', 144),
(201, 'SD', 'Sudan', 'SDN', 736),
(202, 'SR', 'Suriname', 'SUR', 740),
(203, 'SJ', 'Svalbard and Jan Mayen', 'SJM', 744),
(204, 'SZ', 'Swaziland', 'SWZ', 748),
(205, 'SE', 'Sweden', 'SWE', 752),
(206, 'CH', 'Switzerland', 'CHE', 756),
(207, 'SY', 'Syrian Arab Republic', 'SYR', 760),
(208, 'TW', 'Taiwan, Province of China', 'TWN', 158),
(209, 'TJ', 'Tajikistan', 'TJK', 762),
(210, 'TZ', 'Tanzania, United Republic of', 'TZA', 834),
(211, 'TH', 'Thailand', 'THA', 764),
(212, 'TL', 'Timor-Leste', NULL, NULL),
(213, 'TG', 'Togo', 'TGO', 768),
(214, 'TK', 'Tokelau', 'TKL', 772),
(215, 'TO', 'Tonga', 'TON', 776),
(216, 'TT', 'Trinidad and Tobago', 'TTO', 780),
(217, 'TN', 'Tunisia', 'TUN', 788),
(218, 'TR', 'Turkey', 'TUR', 792),
(219, 'TM', 'Turkmenistan', 'TKM', 795),
(220, 'TC', 'Turks and Caicos Islands', 'TCA', 796),
(221, 'TV', 'Tuvalu', 'TUV', 798),
(222, 'UG', 'Uganda', 'UGA', 800),
(223, 'UA', 'Ukraine', 'UKR', 804),
(224, 'AE', 'United Arab Emirates', 'ARE', 784),
(225, 'GB', 'United Kingdom', 'GBR', 826),
(226, 'US', 'United States', 'USA', 840),
(227, 'UM', 'United States Minor Outlying Islands', NULL, NULL),
(228, 'UY', 'Uruguay', 'URY', 858),
(229, 'UZ', 'Uzbekistan', 'UZB', 860),
(230, 'VU', 'Vanuatu', 'VUT', 548),
(231, 'VE', 'Venezuela', 'VEN', 862),
(232, 'VN', 'Viet Nam', 'VNM', 704),
(233, 'VG', 'Virgin Islands, British', 'VGB', 92),
(234, 'VI', 'Virgin Islands, U.s.', 'VIR', 850),
(235, 'WF', 'Wallis and Futuna', 'WLF', 876),
(236, 'EH', 'Western Sahara', 'ESH', 732),
(237, 'YE', 'Yemen', 'YEM', 887),
(238, 'ZM', 'Zambia', 'ZMB', 894),
(239, 'ZW', 'Zimbabwe', 'ZWE', 716),
(248, '', 'Montenegro', NULL, 382);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_county`
--

CREATE TABLE IF NOT EXISTS `kcp_county` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `county_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `kcp_county`
--

INSERT INTO `kcp_county` (`id`, `state_id`, `county_name`) VALUES
(1, 1, 'ComondÃº'),
(2, 1, 'La Paz'),
(3, 1, 'Loreto'),
(4, 1, 'Los Cabos'),
(5, 1, 'MulegÃ©');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_events`
--

CREATE TABLE IF NOT EXISTS `kcp_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(222) NOT NULL,
  `event_date` datetime NOT NULL,
  `venue` int(100) NOT NULL,
  `description` longtext NOT NULL,
  `on_sale_date` datetime NOT NULL,
  `sale_close_date` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `age` varchar(222) NOT NULL,
  `event_web_site` varchar(222) NOT NULL,
  `icon_image` varchar(256) NOT NULL,
  `event_image` varchar(222) NOT NULL,
  `inventory_capacity` int(100) NOT NULL,
  `event_status` int(1) NOT NULL,
  `print_at_home` int(11) NOT NULL,
  `print_date_enable` datetime NOT NULL,
  `print_date_disable` datetime NOT NULL,
  `print_add_desc` longtext NOT NULL,
  `will_call` int(11) NOT NULL,
  `will_date_enable` datetime NOT NULL,
  `will_date_disable` datetime NOT NULL,
  `will_add_desc` longtext NOT NULL,
  `donation_enable` int(1) NOT NULL,
  `donation_name` varchar(222) NOT NULL,
  `online_service_fee` float NOT NULL,
  `ticket_note` varchar(222) NOT NULL,
  `ticket_transaction_limit` float NOT NULL,
  `checkout_time_limit` int(100) NOT NULL,
  `private_event` int(1) NOT NULL,
  `url_short_name` varchar(222) NOT NULL,
  `custom_fee` int(1) NOT NULL,
  `custom_fee_name` varchar(333) NOT NULL,
  `custom_fee_type` int(1) NOT NULL,
  `custom_fee_amt` float NOT NULL,
  `custom_apply_fee` int(1) NOT NULL,
  `event_step` int(10) NOT NULL,
  `event_launch` int(1) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `organization_id` int(100) NOT NULL,
  `commission` float NOT NULL,
  `home_page_event` int(1) NOT NULL,
  `event_ads1` varchar(333) NOT NULL,
  `event_ads2` varchar(333) NOT NULL,
  `event_order` int(100) NOT NULL,
  `event_views` int(100) NOT NULL,
  `pause_sale` int(1) NOT NULL,
  `send_newsletter` int(11) NOT NULL,
  `newsletter_sent` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kcp_events`
--

INSERT INTO `kcp_events` (`event_id`, `event_name`, `event_date`, `venue`, `description`, `on_sale_date`, `sale_close_date`, `category_id`, `age`, `event_web_site`, `icon_image`, `event_image`, `inventory_capacity`, `event_status`, `print_at_home`, `print_date_enable`, `print_date_disable`, `print_add_desc`, `will_call`, `will_date_enable`, `will_date_disable`, `will_add_desc`, `donation_enable`, `donation_name`, `online_service_fee`, `ticket_note`, `ticket_transaction_limit`, `checkout_time_limit`, `private_event`, `url_short_name`, `custom_fee`, `custom_fee_name`, `custom_fee_type`, `custom_fee_amt`, `custom_apply_fee`, `event_step`, `event_launch`, `admin_id`, `organization_id`, `commission`, `home_page_event`, `event_ads1`, `event_ads2`, `event_order`, `event_views`, `pause_sale`, `send_newsletter`, `newsletter_sent`) VALUES
(1, 'Test Event', '2013-06-07 04:10:00', 1, 'Test', '2013-05-31 15:21:00', '2013-06-06 01:00:00', 1, '18', 'http://tickethype.com/register/2', '', '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, '', 0, 0, 0, '', 0, '', 0, 0, 0, 1, 0, 2, 1, 0, 0, '', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_event_category`
--

CREATE TABLE IF NOT EXISTS `kcp_event_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(333) NOT NULL,
  `parent_category` int(11) NOT NULL,
  `category_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `kcp_event_category`
--

INSERT INTO `kcp_event_category` (`category_id`, `category_name`, `parent_category`, `category_status`) VALUES
(1, 'Nightlife ', 0, 'Y'),
(2, 'Entertainment', 0, 'Y'),
(3, 'Music', 0, 'Y'),
(4, 'Art & culture', 0, 'Y'),
(5, 'Cinema', 0, 'Y'),
(6, 'Sport', 0, 'Y'),
(7, 'Body, Mind & Spirit', 0, 'Y'),
(8, 'Show/concert/performance', 0, 'Y'),
(9, 'Party', 0, 'Y'),
(10, 'Festivals', 0, 'Y'),
(11, 'Expose/Conventions', 0, 'Y'),
(12, 'Tournament / Torneos', 0, 'Y'),
(13, 'Race / carreras', 0, 'Y'),
(14, 'Musical', 2, 'Y'),
(15, 'Dance', 2, 'Y'),
(16, 'Theater', 2, 'Y'),
(17, 'Circus', 2, 'Y'),
(18, 'Nutrition', 7, 'Y'),
(19, 'Zumba/Aerobic/Dance', 7, 'Y'),
(20, 'Healing', 7, 'Y'),
(21, 'Yoga', 7, 'Y'),
(22, 'Meditation', 7, 'Y'),
(23, 'Martial arts', 6, 'Y'),
(24, 'Golf', 6, 'Y'),
(25, 'Car Racing', 6, 'Y'),
(26, 'Sport Fishing', 6, 'Y'),
(27, 'Water Sports', 6, 'Y'),
(28, 'Folklorica', 3, 'Y'),
(29, 'Traditional Mexican', 3, 'Y'),
(30, 'Banda - nortena', 3, 'Y'),
(31, 'Troba', 3, 'Y'),
(32, 'Salsa/meringue/cumbia', 3, 'Y'),
(33, 'Rock-pop', 3, 'Y'),
(34, 'Jazz', 3, 'Y'),
(35, 'Classical', 3, 'Y'),
(36, 'Ethnic', 3, 'Y'),
(37, 'Other', 3, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_final_tickets`
--

CREATE TABLE IF NOT EXISTS `kcp_final_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `kcp_final_tickets`
--

INSERT INTO `kcp_final_tickets` (`ticket_id`, `event_id`, `ticket_name_en`, `ticket_name_sp`, `description_en`, `description_sp`, `price_mx`, `price_us`, `ticket_num`, `from_ticket`, `to_ticket`, `eairly_dis_percen`, `eairly_days`, `group_dis_per`, `group_dis_days`, `ticket_icon`, `members_only`, `unique_id`, `post_date`) VALUES
(1, 1, 'Demo ticket', 'Spanish demo ticket', 'Demo ticket description', 'Spanish demo ticket description', 100.00, 125.00, 3000, '1371061800', '1371321000', 7.00, 90, 9.00, 120, '1371043750413482460.png', 'Y', '1772477445', 1371043756),
(4, 3, 'pre-registration', 'pre-registro', 'Description', 'DescripciÃ³n', 500.00, 45.00, 200, '1370975400', '1371493800', 0.00, 0, 0.00, 0, '', 'N', '1772834210', 1371095345),
(5, 3, 'Day of the event', 'Dia del evento', 'Description', '', 750.00, 65.00, 200, '1371580200', '1371580200', 0.00, 0, 0.00, 0, '', 'N', '1772834210', 1371096126),
(10, 4, 'Package A - 8 conferences on Saturday', 'Paquete A - 8 conferencias el sabado', 'Entrance to the 8 conference on Saturday\r\n* Includes entry kit, diploma and raffle ticket', 'Entrada a las OCHO conferencias del Sabado\r\n*Incluye kit de entrada, diploma y folio para rifa', 650.00, 0.00, 100, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '801542968', 1371098324),
(11, 4, 'Package B - 8 conferences & one 9-hours workshop', 'Paquete B - 8 conferencias y una 9-hora taller', 'Entrance to the Eight conferences and one 9-hours workshop.\r\n* Includes welcome kit to the workshop, workshop diploma,\r\nconference diploma, and raffle tickets', 'Entrada a las OCHO conferencias y un taller con 9 horas de duraciÃ³n.\r\n*Incluye kit de bienvenida al taller, diploma de taller, \r\ndiploma de conferencias y folio para rifa', 1500.00, 0.00, 50, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '801542968', 1371098329),
(12, 4, 'Package c - 8 conferences and two 9-hours workshops', 'Paquete A - 8 conferencias y dos talleres de 9 horas', 'Entrance to the 8 conferences and two 9-hours workshops.\r\n* TWO workshops (check schedules), includes welcome kit to the workshop, workshops diplomas, conferences  diploma and raffle ticket', 'Entrada a las OCHO conferencias y dos talleres con 9 horas de duraciÃ³n.\r\n*DOS talleres (checar horarios), Incluye kit de bienvenida al taller, diplomas de talleres, diploma de conferencias y folio para rifa', 2500.00, 0.00, 50, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '801542968', 1371098333),
(17, 8, 'test', 'test', 'Description', 'DescripciÃ³n', 120.00, 10.00, 0, '1371148200', '1371666600', 0.00, 0, 0.00, 0, '', 'N', '456012827', 1371198746),
(18, 10, 'Competition entry', 'inscripciÃ³n a la competiciÃ³n', 'inscription to participate at all competitions', 'inscripciÃ³n para participar en todas las competiciones', 1200.00, 100.00, 100, '1371148200', '1371321000', 0.00, 0, 0.00, 0, '', 'N', '739206647', 1371220303),
(19, 11, 'Vendor fee', 'Cuota de vendedor', 'Description', 'DescripciÃ³n', 120.00, 10.00, 0, '1371148200', '1371234600', 0.00, 0, 0.00, 0, '', 'N', '288985775', 1371223890),
(20, 15, 'Vendor fee', 'Cuota de vendedor', 'Description', 'DescripciÃ³n', 120.00, 10.00, 0, '', '', 0.00, 0, 0.00, 0, '', 'N', '1756052637', 1371224629),
(21, 16, 'Perroton - 2.5 km', 'Perroton - 2.5 km', 'Description', 'DescripciÃ³n', 100.00, 100.00, 200, '1371148200', '1372444200', 0.00, 0, 0.00, 0, '', 'N', '23338641', 1371236841),
(22, 16, 'Fun run - 5 km', 'Carrera recreativa', '', '', 150.00, 100.00, 200, '', '', 0.00, 0, 0.00, 0, '', 'N', '23338641', 1371237026),
(23, 16, 'The pros - 15 km', 'Carrera deportista - 15 km', '', '', 250.00, 100.00, 300, '', '', 0.00, 0, 0.00, 0, '', 'N', '23338641', 1371237059),
(24, 17, 'Free of charge', 'Evento gratis', 'Description', 'DescripciÃ³n', 0.00, 0.00, 0, '', '', 0.00, 0, 0.00, 0, '', 'N', '1615002363', 1371238998),
(25, 18, 'General admission', 'Entrada general', 'Description', 'DescripciÃ³n', 150.00, 0.00, 0, '', '', 0.00, 0, 0.00, 0, '', 'N', '527672079', 1371240363),
(27, 20, 'Donativo', 'Donation', 'Description', 'DescripciÃ³n', 150.00, 0.00, 200, '', '', 0.00, 0, 0.00, 0, '', 'Y', '581111799', 1371243829),
(29, 20, 'General', 'General', 'General', 'General', 150.00, 250.00, 300, '1371506400', '1371852000', 0.00, 0, 0.00, 0, '1371475451louis_roederer_bp.jpg', 'Y', '', 1371475484);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_general_events`
--

CREATE TABLE IF NOT EXISTS `kcp_general_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name_en` text NOT NULL,
  `event_name_sp` text NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `event_end_date_time` datetime NOT NULL,
  `event_end_ampm` varchar(10) NOT NULL,
  `event_venue_state` int(11) NOT NULL,
  `event_venue_county` int(11) NOT NULL,
  `event_venue_city` int(11) NOT NULL,
  `event_venue` int(11) NOT NULL,
  `event_details_en` longtext NOT NULL,
  `event_details_sp` longtext NOT NULL,
  `event_tag` varchar(255) NOT NULL,
  `event_photo` varchar(200) NOT NULL,
  `event_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `kcp_general_events`
--

INSERT INTO `kcp_general_events` (`event_id`, `event_name_en`, `event_name_sp`, `event_start_date_time`, `event_start_ampm`, `event_end_date_time`, `event_end_ampm`, `event_venue_state`, `event_venue_county`, `event_venue_city`, `event_venue`, `event_details_en`, `event_details_sp`, `event_tag`, `event_photo`, `event_status`, `post_date`) VALUES
(1, '2nd international congress of alternative tourism ', 'II congreso internacional de turismo alternativo ', '2013-11-07 09:30:00', 'AM', '2013-11-09 05:00:00', 'PM', 1, 4, 37, 6, '<p>\r\n	<span id="result_box" lang="en"><span class="hps">AGATA</span>&nbsp;Todos Santos, <span class="hps">Mexico</span> <span class="hps">invites</span>&nbsp;you to&nbsp;<span class="hps">its second</span> <span class="hps">international congress of</span> <span class="hps atn">alternative tourism &quot;</span><span class="alt-edited">Leveraging</span> <span class="hps">Ideas&quot;</span><br />\r\n	<br />\r\n	<span class="hps">Rural tourism,</span> <span class="hps">adventure and ecotourism</span> <span class="hps">will be</span> <span class="hps">some of</span> <span class="hps">the lectures</span> <span class="hps">will be given</span> <span class="hps">by</span> <span class="hps">international speakers</span> <span class="hps">from</span> <span class="hps">Spain</span>, France, United States, <span class="hps">Costa Rica</span> <span class="hps">and</span> <span class="hps">Mexico</span>.<br />\r\n	<br />\r\n	<span class="hps">More</span> <span class="hps">information</span><span>:</span></span></p>\r\n<p>\r\n	Tel: (624) 1468597<br />\r\n	<a href="http://www.agata.mx/" target="_blank">WWW.AGATA.MX</a><br />\r\n	<a href="mailto:RESERVACIONES@AGATA.MX">RESERVACIONES@AGATA.MX</a></p>\r\n', '<p>\r\n	<span class="textoContenido">AGATA todos santos, M&eacute;xico invita a su II congreso internacional de turismo alternativo &quot;Impulsando ideas&quot;<br />\r\n	<br />\r\n	Turismo rural, de aventura y ecoturismo seran algunas de las conferencias que se daran por parte de conferencistas internacionales de Espa&ntilde;a, Francia, Estados Unidos, Costa Rica y M&eacute;xico.<br />\r\n	<br />\r\n	M&aacute;s informaci&oacute;n:<br />\r\n	Tel: (624) 1468597<br />\r\n	<a href="http://www.agata.mx/" target="_blank">WWW.AGATA.MX</a><br />\r\n	<a href="mailto:RESERVACIONES@AGATA.MX">RESERVACIONES@AGATA.MX</a></span></p>\r\n', '', '1371048781Congreso turismo alternativo.png', 'Y', 1371043974),
(3, 'Sunset Shakti Naam Masterclass', 'Sunset Shakti Naam Masterclass', '2013-06-19 06:30:00', 'PM', '2013-06-19 08:30:00', 'PM', 1, 4, 37, 10, '<p>\r\n	<font color="#232438" face="Verdana" style="font-size: 9.5pt">Shakti Naam works with the fifth element within us, that ocean of energy that gives life to our being. It is referred to as the yoga of immortality by those that know the full extent of its power. During this very special class, Dr. Levry will teach these advanced techniques designed to build and expand your electromagnetic field and nurture your life force. Here we are, at the very eve of the Age of Love. This is the Age of group energy. It is so important that we come together and support each other as we perform our spiritual work. Doing so will not only bless us and burn away our karma, but bless and heal everyone with whom we are sharing this special place in time. We invite you to join us as we come together in the Spirit of Love, with our beloved teacher, to heal and bless the Earth. This powerful class is designed to illuminate your life, so that you may ride the wave of your highest Destiny straight into the heart of the Divine.</font></p>\r\n', '<p>\r\n	<font color="#232438" face="Verdana" style="font-size: 9.5pt">&ldquo;SHAKTI NAAM es una practica rara y muy poco conocida en el Occidente que cuida del cuerpo humano como un todo, desde de tu cabeza hasta los dedos de tus pies. No hay ninguna parte del cuerpo que no se beneficie con Shakti Naam, todos tus huesos, tus m&uacute;sculos, tus &oacute;rganos, as&iacute; como los sistemas glandular y nervioso. La pr&aacute;ctica de Shakti Naam ocasiona que los m&uacute;sculos dispersen energ&iacute;a en todo el cuerpo y el cerebro empieza a responder&rdquo;.<br />\r\n	<i>-Palabras del Dr. Levry a Antonio Esquinca en su programa en Alfa 91.3</i><br />\r\n	<br />\r\n	DURANTE ESTE EVENTO TAN ESPECIAL Dr. Levry ense&ntilde;ar&aacute; t&eacute;cnicas avanzadas que est&aacute;n dise&ntilde;adas para prevenir el estress y la enfermedad. Clase abierta a todas las edades y niveles.</font></p>\r\n', '', '1371096164SunsetShaktiNaamMasterclass-flyer.jpg', 'Y', 1371096165),
(4, 'Design Time Los Cabos', 'Design Time Los Cabos', '2013-07-11 09:00:00', 'AM', '2013-07-13 08:00:00', 'PM', 1, 4, 37, 11, '<p>\r\n	<span id="result_box" lang="en" tabindex="-1"><span class="hps">We are pleased</span> <span class="hps">to present</span> <span class="hps">our</span> <span class="hps">third consecutive</span> <span class="hps">Lecture</span> <span class="hps">and Workshop</span>, <span class="hps">themed</span> <span class="hps">graphic design, advertising</span><span>, MKT</span>, art, photography, <span class="hps">communication</span> <span class="hps">and the latest</span> <span class="hps">digital trends</span>. <span class="hps">With</span> <span class="hps">nine guests</span> <span class="hps">of the highest level</span>, which <span class="hps">are internationally recognized</span>, <span class="hps">who will share with</span> <span class="hps">our participants</span> <span class="hps">interesting information</span> <span class="hps">that will help them</span> <span class="hps">have a better</span> <span class="hps">competitive perspective</span>.<br />\r\n	<span class="hps">Our 8</span> <span class="hps">conferences</span> <span class="hps">will be</span> <span class="hps">on Saturday,</span> <span class="hps">July 13</span>, while <span class="hps atn">our 3</span>&nbsp;<span class="hps">workshops will</span>&nbsp;be&nbsp;<span class="hps">Thursday11</span> <span class="hps">and Friday</span> <span class="hps">July 12</span>.<br />\r\n	<span class="hps">The workshops will be</span> <span class="hps">creating</span> <span class="hps">characters with</span> <span class="hps">illustration techniques</span> <span class="hps">taught by</span> <span class="hps">C&eacute;sar</span> <span class="hps">N&aacute;ndez</span>, <span class="hps">InDesign</span> <span class="hps">CS6</span> <span class="hps">digital</span> <span class="hps">publications</span> <span class="hps">taught by</span> <span class="hps">Adobe</span> <span class="hps">&reg;</span> <span class="hps">Influencer</span> <span class="hps">Aldo</span> <span class="hps">de la Fuente</span> <span class="hps">and</span> <span class="hps">web</span> <span class="hps">sites</span> <span class="hps">for any</span> <span class="hps">given</span> <span class="hps">screen</span> <span class="hps">by</span> <span class="hps">Monky</span> <span class="hps">Adobe</span> <span class="hps">&reg;</span> <span class="hps">Certified</span> <span class="hps">Instructor</span>. <span class="hps">All</span> <span class="hps">9-hour</span> <span class="hps">workshops</span> <span class="hps">with a diploma</span> <span class="hps">curriculum</span>.</span></p>\r\n', '<p>\r\n	Estamos muy contentos de presentarles por tercer a&ntilde;o consecutivo nuestro Ciclo de Conferencias y Talleres, con temas de dise&ntilde;o gr&aacute;fico, publicidad, MKT, arte, fotograf&iacute;a, comunicaci&oacute;n y lo &uacute;ltimo en tendencias digitales. Con nueve invitados de primer&iacute;simo nivel, que cuentan con reconocimiento internacional, quienes compartir&aacute;n con nuestros participantes interesantes datos que les ayudar&aacute;n a tener una mejor perspectiva competitiva.</p>\r\n<p>\r\n	Nuestras 8 conferencias ser&aacute;n el d&iacute;a s&aacute;bado 13 de Julio, mientras que nuestro 3 talleres ser&aacute;n los d&iacute;as jueves11 y viernes 12 de Julio.<br />\r\n	Los talleres ser&aacute;n Creando personajes con t&eacute;cnicas de ilustraci&oacute;n impartidas por C&eacute;sar N&aacute;ndez; Publicaciones digitales con InDesign CS6 impartido por el Adobe&reg; Influencer Aldo de la Fuente y Sitios web para cualquier pantalla impartido por el Adobe&reg; Certified Instructor Monky. Todos los talleres de 9 horas con diploma curricular.</p>\r\n', '', '1371137390design time-2talleres.jpg', 'Y', 1371098335),
(5, 'ASP 6-Star Los Cabos Open of Surf', 'ASP 6-Star Los Cabos Open of Surf', '2013-06-17 08:00:00', 'AM', '2013-06-23 04:00:00', 'PM', 1, 4, 36, 0, '<p>\r\n	<span class="textoContenido">The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\r\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\r\n<p>\r\n	Official schedule&nbsp;<a href="http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps">La Asociaci&oacute;n</span> <span class="hps">de Profesionales del</span> <span class="hps">Surf</span> <span class="hps">6</span>-Star <span class="hps">en Los</span> <span class="hps">Cabos</span>&nbsp;Open of&nbsp;<span class="hps">Surf</span> <span class="hps">ha sido oficialmente</span> <span class="hps">a&ntilde;adido a la</span>&nbsp;</span>programaci&oacute;n&nbsp;ASP&nbsp;<span class="hps">Am&eacute;rica del</span> <span class="hps">Norte</span>, despleg&aacute;ndose <span class="hps">en</span> <span class="hps">Cabos</span> <span class="hps">derecha</span> <span class="hps">adoquines</span> <span class="hps">pointbreak</span> <span class="hps">de</span> <span class="hps">Zippers</span>.</p>\r\n<p>\r\n	<span lang="es" tabindex="-1"><span class="hps">El</span> <span class="hps">Los</span> <span class="hps">Cabos</span>&nbsp;Open of&nbsp;<span class="hps">Surf</span> <span class="hps">tambi&eacute;n incluir&aacute;</span> <span class="hps">una serie de conciertos</span> <span class="hps">en la playa con</span> <span class="hps">artistas internacionales</span> <span class="hps">y DJs</span>, bares de playa, <span class="hps">una feria</span> <span class="hps">que ofrece</span> <span class="hps">alimentos frescos</span><span>, cocina local</span>, <span class="hps">desfiles de moda</span> <span class="hps">con algunos de los</span> <span class="hps">mejores</span> <span class="hps">marcas de surf</span>, paseos <span class="hps">de arte y actividades</span> <span class="hps">ecol&oacute;gicas</span>, <span class="hps">mostrando lo mejor</span> <span class="hps">del estilo de vida</span> <span class="hps">surf.</span></span></p>\r\n<p>\r\n	Programa oficial &nbsp;<a href="http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\r\n', '', '1371144385Los Cabos open of Surf.jpg', 'Y', 1371144385),
(6, 'ASP 6-Star Los Cabos Open of Surf', 'ASP 6-Star Los Cabos Open of Surf', '2013-06-17 08:00:00', 'AM', '2013-06-23 04:00:00', 'PM', 1, 4, 37, 0, '<p>\r\n	<span class="textoContenido">The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\r\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\r\n<p>\r\n	Official schedule&nbsp;<a href="http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps">La Asociaci&oacute;n</span> <span class="hps">de Profesionales del</span> <span class="hps">Surf</span> <span class="hps">6</span>-Star <span class="hps">en Los</span> <span class="hps">Cabos</span>&nbsp;Open of&nbsp;<span class="hps">Surf</span> <span class="hps">ha sido oficialmente</span> <span class="hps">a&ntilde;adido a la</span>&nbsp;</span>programaci&oacute;n&nbsp;ASP&nbsp;<span class="hps">Am&eacute;rica del</span> <span class="hps">Norte</span>, despleg&aacute;ndose <span class="hps">en</span> <span class="hps">Cabos</span> <span class="hps">derecha</span> <span class="hps">adoquines</span> <span class="hps">pointbreak</span> <span class="hps">de</span> <span class="hps">Zippers</span>.</p>\r\n<p>\r\n	<span lang="es" tabindex="-1"><span class="hps">El</span> <span class="hps">Los</span> <span class="hps">Cabos</span>&nbsp;Open of&nbsp;<span class="hps">Surf</span> <span class="hps">tambi&eacute;n incluir&aacute;</span> <span class="hps">una serie de conciertos</span> <span class="hps">en la playa con</span> <span class="hps">artistas internacionales</span> <span class="hps">y DJs</span>, bares de playa, <span class="hps">una feria</span> <span class="hps">que ofrece</span> <span class="hps">alimentos frescos</span><span>, cocina local</span>, <span class="hps">desfiles de moda</span> <span class="hps">con algunos de los</span> <span class="hps">mejores</span> <span class="hps">marcas de surf</span>, paseos <span class="hps">de arte y actividades</span> <span class="hps">ecol&oacute;gicas</span>, <span class="hps">mostrando lo mejor</span> <span class="hps">del estilo de vida</span> <span class="hps">surf.</span></span></p>\r\n<p>\r\n	Programa oficial &nbsp;<a href="http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\r\n', '', '1371144521Los Cabos open of Surf.jpg', 'Y', 1371144521),
(7, 'vdvd', 'vsdv', '2013-06-13 07:00:00', 'PM', '2013-06-13 09:00:00', 'PM', 1, 4, 36, 0, '', '', '', '', 'Y', 1371145766),
(8, 'Test1', 'Test1 SP', '2013-06-21 07:00:00', 'PM', '2013-06-21 09:00:00', 'PM', 1, 4, 36, 0, '<p>\r\n	test</p>\r\n', '', '', '', 'Y', 1371198778),
(9, 'dwda', 'dwd', '2013-06-18 07:00:00', 'PM', '2013-06-18 09:00:00', 'PM', 1, 4, 37, 14, '<p>\r\n	dasdsd</p>\r\n', '<p>\r\n	dawd</p>\r\n', '', '', 'Y', 1371220260),
(10, 'ASP 6-Star Los Cabos Open of Surf', 'ASP 6-Star Los Cabos Open of Surf', '2013-06-17 08:00:00', 'AM', '2013-06-23 07:00:00', 'PM', 1, 4, 36, 25, '<p>\r\n	<span>The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\r\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\r\n', '<div id="">\r\n	<div dir="" style="">\r\n		<span id="" lang=""><span>La Asociaci&oacute;n</span> <span>de Profesionales del</span> <span>Surf</span> <span>6</span>-Star&nbsp;</span><span>Los</span>&nbsp;<span>Cabos&nbsp;</span>Open of&nbsp;<span>Surf</span>&nbsp;<span>ha sido oficialmente</span> <span>a&ntilde;adido a la</span>&nbsp;<span>programaci&oacute;n</span>&nbsp;<span>ASP de&nbsp;</span><span>Am&eacute;rica del</span> <span>Norte</span>, despleg&aacute;ndose <span>en</span> <span>Cabos</span> <span>derecha</span> <span>adoquines</span> <span>pointbreak</span> <span>de</span> <span>Zippers</span>.</div>\r\n	<div dir="" style="">\r\n		<span lang=""><span>El</span> <span>Los</span> <span>Cabos</span>&nbsp;Open of&nbsp;<span>Surf</span> <span>tambi&eacute;n incluir&aacute;</span> <span>una serie de conciertos</span> <span>en la playa con</span> <span>artistas internacionales</span> <span>y DJs</span>, bares de playa, <span>una feria</span> <span>que ofrece</span> <span>alimentos frescos</span><span>, cocina local</span>, <span>desfiles de moda</span> <span>con algunos de los</span> <span>mejores</span> <span>marcas de surf</span>, paseos <span>de arte y actividades</span> <span>ecol&oacute;gicas</span>, <span>mostrando lo mejor</span> <span>del estilo de vida</span> <span>surf.</span></span></div>\r\n</div>\r\n', '', '1371231133Los Cabos open of Surf.jpg', 'Y', 1371220313),
(11, 'Organic Market Pedregal', 'Mercado Organico en Pedregal', '2013-06-15 07:00:00', 'AM', '2013-06-15 12:00:00', 'PM', 1, 4, 37, 0, '<h1>\r\n	Organic Farmers Market</h1>\r\n<h2>\r\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\r\n<p>\r\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\r\n<p>\r\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps alt-edited">Mercado Org&aacute;nico</span><span class="hps alt-edited">&nbsp;de productores</span><br />\r\n	<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span><span>, Los</span> <span class="hps">Cabos,</span> <span class="hps">Baja</span> <span class="hps">California Sur,</span> <span class="hps">M&eacute;xico</span><br />\r\n	<br />\r\n	<span class="hps">Lo que usted come</span> <span class="hps">puede afectar</span> <span class="hps">la forma en</span> <span class="hps">que funciona su cuerpo</span><span>.</span> <span class="hps">Para mantener</span> <span class="hps">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class="hps">alimentos saludables</span> <span class="hps">de todos los</span> <span class="hps">grupos de alimentos</span> <span class="hps">y los h&aacute;bitos</span> <span class="hps">saludables de alimentaci&oacute;n</span><span class="hps">&nbsp;puede</span>&nbsp;ser<span class="hps">&nbsp;el camino hacia</span> <span class="hps">una mejor salud.</span> <span class="hps">La comida,</span> <span class="hps">uno de los grandes</span> <span class="hps">placeres de la vida</span><span>,</span> <span class="hps">es la base para</span> <span class="hps">una vida sana</span><span>.</span><br />\r\n	<br />\r\n	<span class="hps"><span class="hps">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span> &nbsp;<span class="hps">de productores&nbsp;</span><span class="hps">tiene una incre&iacute;ble</span> <span class="hps">variedad de</span> <span class="hps">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class="hps">hierbas y frutas</span><span>, junto</span> <span class="hps">con una selecci&oacute;n de</span> <span class="hps">comidas preparadas.</span> <span class="hps">Es</span> <span class="hps">un lugar muy animado</span> <span class="hps">los mi&eacute;rcoles y</span> <span class="hps">s&aacute;bados por la ma&ntilde;ana</span> <span class="hps">desde las 8 am</span> <span class="hps">hasta el mediod&iacute;a</span><span>,</span> <span class="hps">todo el a&ntilde;o,</span> <span class="hps">donde podr&aacute;</span> <span class="hps">reunirse con los amigos</span><span>, comprar</span> <span class="hps">los mejores alimentos</span> <span class="hps">org&aacute;nicos</span><span>,</span> <span class="hps">y hacer</span> <span class="hps">sus citas</span> <span class="hps">para la pr&oacute;xima semana</span> <span class="hps">por los diferentes servicios</span><span>.</span></span></p>\r\n', '', '', 'Y', 1371223922),
(12, 'Organic Market Pedregal', 'Mercado Organico en Pedregal', '2013-06-19 08:00:00', 'AM', '2013-06-19 12:00:00', 'PM', 1, 4, 37, 13, '<h1>\r\n	Organic Farmers Market</h1>\r\n<h2>\r\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\r\n<p>\r\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\r\n<p>\r\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps alt-edited">Mercado Org&aacute;nico</span><span class="hps alt-edited">&nbsp;de productores</span><br />\r\n	<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span><span>, Los</span> <span class="hps">Cabos,</span> <span class="hps">Baja</span> <span class="hps">California Sur,</span> <span class="hps">M&eacute;xico</span><br />\r\n	<br />\r\n	<span class="hps">Lo que usted come</span> <span class="hps">puede afectar</span> <span class="hps">la forma en</span> <span class="hps">que funciona su cuerpo</span><span>.</span> <span class="hps">Para mantener</span> <span class="hps">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class="hps">alimentos saludables</span> <span class="hps">de todos los</span> <span class="hps">grupos de alimentos</span> <span class="hps">y los h&aacute;bitos</span> <span class="hps">saludables de alimentaci&oacute;n</span><span class="hps">&nbsp;puede</span>&nbsp;ser<span class="hps">&nbsp;el camino hacia</span> <span class="hps">una mejor salud.</span> <span class="hps">La comida,</span> <span class="hps">uno de los grandes</span> <span class="hps">placeres de la vida</span><span>,</span> <span class="hps">es la base para</span> <span class="hps">una vida sana</span><span>.</span><br />\r\n	<br />\r\n	<span class="hps"><span class="hps">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span> &nbsp;<span class="hps">de productores&nbsp;</span><span class="hps">tiene una incre&iacute;ble</span> <span class="hps">variedad de</span> <span class="hps">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class="hps">hierbas y frutas</span><span>, junto</span> <span class="hps">con una selecci&oacute;n de</span> <span class="hps">comidas preparadas.</span> <span class="hps">Es</span> <span class="hps">un lugar muy animado</span> <span class="hps">los mi&eacute;rcoles y</span> <span class="hps">s&aacute;bados por la ma&ntilde;ana</span> <span class="hps">desde las 8 am</span> <span class="hps">hasta el mediod&iacute;a</span><span>,</span> <span class="hps">todo el a&ntilde;o,</span> <span class="hps">donde podr&aacute;</span> <span class="hps">reunirse con los amigos</span><span>, comprar</span> <span class="hps">los mejores alimentos</span> <span class="hps">org&aacute;nicos</span><span>,</span> <span class="hps">y hacer</span> <span class="hps">sus citas</span> <span class="hps">para la pr&oacute;xima semana</span> <span class="hps">por los diferentes servicios</span><span>.</span></span></p>\r\n', '', '1371224142SJD mercado organico1.jpg', 'Y', 1371224020),
(13, 'Organic Market Pedregal', 'Mercado Organico en Pedregal', '2013-06-15 08:00:00', 'AM', '2013-06-15 12:00:00', 'PM', 1, 4, 37, 13, '<h1>\r\n	Organic Farmers Market</h1>\r\n<h2>\r\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\r\n<p>\r\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\r\n<p>\r\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps alt-edited">Mercado Org&aacute;nico</span><span class="hps alt-edited">&nbsp;de productores</span><br />\r\n	<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span><span>, Los</span> <span class="hps">Cabos,</span> <span class="hps">Baja</span> <span class="hps">California Sur,</span> <span class="hps">M&eacute;xico</span><br />\r\n	<br />\r\n	<span class="hps">Lo que usted come</span> <span class="hps">puede afectar</span> <span class="hps">la forma en</span> <span class="hps">que funciona su cuerpo</span><span>.</span> <span class="hps">Para mantener</span> <span class="hps">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class="hps">alimentos saludables</span> <span class="hps">de todos los</span> <span class="hps">grupos de alimentos</span> <span class="hps">y los h&aacute;bitos</span> <span class="hps">saludables de alimentaci&oacute;n</span><span class="hps">&nbsp;puede</span>&nbsp;ser<span class="hps">&nbsp;el camino hacia</span> <span class="hps">una mejor salud.</span> <span class="hps">La comida,</span> <span class="hps">uno de los grandes</span> <span class="hps">placeres de la vida</span><span>,</span> <span class="hps">es la base para</span> <span class="hps">una vida sana</span><span>.</span><br />\r\n	<br />\r\n	<span class="hps"><span class="hps">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span> &nbsp;<span class="hps">de productores&nbsp;</span><span class="hps">tiene una incre&iacute;ble</span> <span class="hps">variedad de</span> <span class="hps">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class="hps">hierbas y frutas</span><span>, junto</span> <span class="hps">con una selecci&oacute;n de</span> <span class="hps">comidas preparadas.</span> <span class="hps">Es</span> <span class="hps">un lugar muy animado</span> <span class="hps">los mi&eacute;rcoles y</span> <span class="hps">s&aacute;bados por la ma&ntilde;ana</span> <span class="hps">desde las 8 am</span> <span class="hps">hasta el mediod&iacute;a</span><span>,</span> <span class="hps">todo el a&ntilde;o,</span> <span class="hps">donde podr&aacute;</span> <span class="hps">reunirse con los amigos</span><span>, comprar</span> <span class="hps">los mejores alimentos</span> <span class="hps">org&aacute;nicos</span><span>,</span> <span class="hps">y hacer</span> <span class="hps">sus citas</span> <span class="hps">para la pr&oacute;xima semana</span> <span class="hps">por los diferentes servicios</span><span>.</span></span></p>\r\n', '', '1371227052cabo-organic-market-pedregal_r3.jpg', 'Y', 1371224021),
(14, 'Organic Market Pedregal', 'Mercado Organico en Pedregal', '2013-06-22 08:00:00', 'AM', '2013-06-22 12:00:00', 'PM', 1, 0, 0, 0, '<h1>\r\n	Organic Farmers Market</h1>\r\n<h2>\r\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\r\n<p>\r\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\r\n<p>\r\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\r\n', '<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps alt-edited">Mercado Org&aacute;nico</span><span class="hps alt-edited">&nbsp;de productores</span><br />\r\n	<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span><span>, Los</span> <span class="hps">Cabos,</span> <span class="hps">Baja</span> <span class="hps">California Sur,</span> <span class="hps">M&eacute;xico</span><br />\r\n	<br />\r\n	<span class="hps">Lo que usted come</span> <span class="hps">puede afectar</span> <span class="hps">la forma en</span> <span class="hps">que funciona su cuerpo</span><span>.</span> <span class="hps">Para mantener</span> <span class="hps">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class="hps">alimentos saludables</span> <span class="hps">de todos los</span> <span class="hps">grupos de alimentos</span> <span class="hps">y los h&aacute;bitos</span> <span class="hps">saludables de alimentaci&oacute;n</span><span class="hps">&nbsp;puede</span>&nbsp;ser<span class="hps">&nbsp;el camino hacia</span> <span class="hps">una mejor salud.</span> <span class="hps">La comida,</span> <span class="hps">uno de los grandes</span> <span class="hps">placeres de la vida</span><span>,</span> <span class="hps">es la base para</span> <span class="hps">una vida sana</span><span>.</span><br />\r\n	<br />\r\n	<span class="hps"><span class="hps">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class="hps">Cabo</span> <span class="hps">San</span> <span class="hps">Lucas</span> &nbsp;<span class="hps">de productores&nbsp;</span><span class="hps">tiene una incre&iacute;ble</span> <span class="hps">variedad de</span> <span class="hps">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class="hps">hierbas y frutas</span><span>, junto</span> <span class="hps">con una selecci&oacute;n de</span> <span class="hps">comidas preparadas.</span> <span class="hps">Es</span> <span class="hps">un lugar muy animado</span> <span class="hps">los mi&eacute;rcoles y</span> <span class="hps">s&aacute;bados por la ma&ntilde;ana</span> <span class="hps">desde las 8 am</span> <span class="hps">hasta el mediod&iacute;a</span><span>,</span> <span class="hps">todo el a&ntilde;o,</span> <span class="hps">donde podr&aacute;</span> <span class="hps">reunirse con los amigos</span><span>, comprar</span> <span class="hps">los mejores alimentos</span> <span class="hps">org&aacute;nicos</span><span>,</span> <span class="hps">y hacer</span> <span class="hps">sus citas</span> <span class="hps">para la pr&oacute;xima semana</span> <span class="hps">por los diferentes servicios</span><span>.</span></span></p>\r\n', '', '', 'Y', 1371224242),
(15, 'Organic Market Pedregal', 'Mercado Organico en Pedregal', '2013-06-22 08:00:00', 'AM', '2013-06-22 12:00:00', 'PM', 1, 4, 37, 13, '<h1>\r\n	Organic Farmers Market</h1>\r\n<h2>\r\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\r\n<p>\r\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\r\n<p>\r\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\r\n', '<p>\r\n	<span class="hps alt-edited">Mercado Org&aacute;nico</span><span class="hps alt-edited">&nbsp;de productores</span><br />\r\n	<span class="hps">Cabo</span>&nbsp;<span class="hps">San</span>&nbsp;<span class="hps">Lucas</span>, Los&nbsp;<span class="hps">Cabos,</span>&nbsp;<span class="hps">Baja</span>&nbsp;<span class="hps">California Sur,</span>&nbsp;<span class="hps">M&eacute;xico</span><br />\r\n	<br />\r\n	<span class="hps">Lo que usted come</span>&nbsp;<span class="hps">puede afectar</span>&nbsp;<span class="hps">la forma en</span>&nbsp;<span class="hps">que funciona su cuerpo</span>.&nbsp;<span class="hps">Para mantener</span>&nbsp;<span class="hps">una nutrici&oacute;n &oacute;ptima</span>, una variedad de&nbsp;<span class="hps">alimentos saludables</span>&nbsp;<span class="hps">de todos los</span>&nbsp;<span class="hps">grupos de alimentos</span>&nbsp;<span class="hps">y los h&aacute;bitos</span>&nbsp;<span class="hps">saludables de alimentaci&oacute;n</span><span class="hps">&nbsp;puede</span>&nbsp;ser<span class="hps">&nbsp;el camino hacia</span>&nbsp;<span class="hps">una mejor salud.</span>&nbsp;<span class="hps">La comida,</span>&nbsp;<span class="hps">uno de los grandes</span>&nbsp;<span class="hps">placeres de la vida</span>,&nbsp;<span class="hps">es la base para</span>&nbsp;<span class="hps">una vida sana</span>.<br />\r\n	<br />\r\n	<span class="hps"><span class="hps">El&nbsp;</span>Mercado</span>&nbsp;Org&aacute;nico&nbsp;<span class="hps">Cabo</span>&nbsp;<span class="hps">San</span>&nbsp;<span class="hps">Lucas</span>&nbsp;&nbsp;<span class="hps">de productores&nbsp;</span><span class="hps">tiene una incre&iacute;ble</span>&nbsp;<span class="hps">variedad de</span>&nbsp;<span class="hps">productos frescos</span>, mariscos, pollo, huevos, quesos,&nbsp;<span class="hps">hierbas y frutas</span>, junto&nbsp;<span class="hps">con una selecci&oacute;n de</span>&nbsp;<span class="hps">comidas preparadas.</span>&nbsp;<span class="hps">Es</span>&nbsp;<span class="hps">un lugar muy animado</span>&nbsp;<span class="hps">los mi&eacute;rcoles y</span>&nbsp;<span class="hps">s&aacute;bados por la ma&ntilde;ana</span>&nbsp;<span class="hps">desde las 8 am</span>&nbsp;<span class="hps">hasta el mediod&iacute;a</span>,&nbsp;<span class="hps">todo el a&ntilde;o,</span>&nbsp;<span class="hps">donde podr&aacute;</span>&nbsp;<span class="hps">reunirse con los amigos</span>, comprar&nbsp;<span class="hps">los mejores alimentos</span>&nbsp;<span class="hps">org&aacute;nicos</span>,&nbsp;<span class="hps">y hacer</span>&nbsp;<span class="hps">sus citas</span>&nbsp;<span class="hps">para la pr&oacute;xima semana</span>&nbsp;<span class="hps">por los diferentes servicios</span>.</p>\r\n', '', '1371231051cabo-organic-market_9253_r3.jpg', 'Y', 1371224639),
(16, 'CICLOVÃA 3rd ANNIVERSARY ', 'CICLOVÃA 3ER Aniversario', '2013-06-30 07:00:00', 'AM', '2013-06-30 11:00:00', 'AM', 1, 4, 37, 17, '<p>\r\n	Sunday morning with Amigos de Cabo San Lucas.<br />\r\n	The main drag is closed to vehicle traffic, great opportunity to exercise and mingle with local families... Bicycle, walk, skate, pet walk, sometimes even music, aerobics, zumba, spinning</p>\r\n<p>\r\n	Join the fun with 3 different races for all levels and conditions:</p>\r\n<ul>\r\n	<li>\r\n		<span class="st">Perrot&oacute;n - a 2.5 km walk with your dog - Inscription MXP100</span></li>\r\n	<li>\r\n		Fun run - 5 km&nbsp;Inscription MXP150</li>\r\n	<li>\r\n		The pros - 15 km Inscription MXP250</li>\r\n</ul>\r\n<p>\r\n	<a href="mailto:amigosdecabosanlucas@gmail.com">amigosdecabosanlucas@gmail.com</a></p>\r\n', '<p>\r\n	Preparan celebraci&oacute;n del tercer aniversario de inicio de la ciclov&iacute;a, cuyo proyecto se ha venido desarrollando exitosamente con la participaci&oacute;n cada vez mayor de m&aacute;s familias sanluque&ntilde;as e invitados.<br />\r\n	<br />\r\n	Mario Meave invita a la ciudadan&iacute;a a la ciclov&iacute;a, para juntos celebrar el tercer aniversario, el jueves 30 de junio 2013 en el par vial, para quienes desconozcan el lugar, es por Boulevard L&aacute;zaro C&aacute;rdenas, todos los domingos, de 7:00 a.m. a 11:00 a.m.</p>\r\n<p>\r\n	<span id="result_box" lang="es" tabindex="-1"><span class="hps">Participa a la diversi&oacute;n</span> <span class="hps">con 3</span> <span class="hps alt-edited">carreras</span> <span class="hps">diferentes para</span> <span class="hps">todos los niveles</span> <span class="hps">y condiciones:</span><br />\r\n	<br />\r\n	<span class="hps">Perroton</span> <span class="hps">-</span> <span class="hps">un</span> <span class="hps">2,5 kilometros</span> <span class="hps">a pie</span> <span class="hps">con su perro</span> <span class="hps">- Inscripci&oacute;n</span> <span class="hps">MXP100</span><br />\r\n	<span class="hps alt-edited">Carrera recreativa</span> &nbsp;<span class="hps">- 5 km</span> <span class="hps">inscripci&oacute;n</span> <span class="hps">MXP150</span><br />\r\n	<span class="hps">Los</span> <span class="hps">pros</span> <span class="hps">-</span> <span class="hps">15 kilometros</span> <span class="hps">Inscripci&oacute;n</span> <span class="hps">MXP250</span></span><br />\r\n	<br />\r\n	Record&oacute; ser un programa sin autos para las familias, a donde pueden acudir con bicicletas, patines y mascotas, para que juntos poder disfrutar de este divertido y ejercitado paseo bajo la Direcci&oacute;n del Club Cactus Bike.<br />\r\n	<br />\r\n	Mario Meave, mencion&oacute; que este proyecto se concret&oacute; gracias a Club Cactus Bike y Amigos de Cabo San Lucas A.C., cuyo programa fue proyectado pensando en el bienestar de las familias de esta ciudad para que hagan ejercicio y al mismo tiempo estar ayudando a la convivencia familiar.<br />\r\n	<br />\r\n	Para ello, habr&aacute; festival de arte en la Plaza Amelia Wilkes, &quot;reviviendo lo nuestro del segundo aniversario&quot;, con exhibici&oacute;n y venta gastron&oacute;mica de algunos restaurantes del centro de Cabo San Lucas, evento cultural, m&uacute;sica en vivo, en s&iacute;, diversi&oacute;n familiar.<br />\r\n	<br />\r\n	Record&oacute; que como forman parte de la campa&ntilde;a Imagina Los Cabos que dirige la direcci&oacute;n de Imagen Urbana y el Consejo Coordinador, invitan igualmente a sumarse a las labores de limpia de playas, de calles, a la campa&ntilde;a antigraffiti, todo por una buena imagen ante el turista y de todos los que vivimos en Los Cabos, as&iacute; como se han sumado al comit&eacute; del carnaval para el 2014.<br />\r\n	<br />\r\n	Finalmente, coment&oacute; Mario Meave que se da continuidad al programa de apoyo a la ni&ntilde;ez sana, para que no sea explotada, para ello han implementando carteles donde se dice &quot;no compres, no regales dinero a los ni&ntilde;os ambulantes, en la marina y playa es por su bien son nuestros futuros ciudadanos&quot;.&nbsp;</p>\r\n', '', '13712370853ro aniversario ciclovia.jpg', 'Y', 1371237085);
INSERT INTO `kcp_general_events` (`event_id`, `event_name_en`, `event_name_sp`, `event_start_date_time`, `event_start_ampm`, `event_end_date_time`, `event_end_ampm`, `event_venue_state`, `event_venue_county`, `event_venue_city`, `event_venue`, `event_details_en`, `event_details_sp`, `event_tag`, `event_photo`, `event_status`, `post_date`) VALUES
(17, 'Fete de la musique', 'Fiesta de la MÃºsica', '2013-06-21 04:00:00', 'PM', '2013-06-22 01:00:00', 'AM', 1, 4, 36, 7, '<p>\r\n	<span id="result_box" lang="en" tabindex="-1"><span title="El prÃ³ximo 21 de junio se llevarÃ¡ a cabo la quinta ediciÃ³n de la â€œFiesta de la MÃºsicaâ€ en San JosÃ© del Cabo, a partir de las 16:00 hrs.">The next June 21 will be held the fifth edition of the &quot;Festival of Music&quot; in San Jose del Cabo, from 16:00 hrs. </span><span title="en las calles del centro histÃ³rico.">on the streets of the historic center. </span><span title="Este es un evento internacional que naciÃ³ en Francia en 1982 para festejar la mÃºsica y asÃ­ rendir homenaje a todos los estilos musicales.">This is an international event that was born in France in 1982 to celebrate the music and so pay tribute to all musical styles.</span><br />\r\n	<br />\r\n	The Association Civil&nbsp;Cultural Promotion Vivarte, through organizing committee invites the largest musical celebration of the world in the centro historico with 15 stage sets, with local groups and singers.</span><br />\r\n	&nbsp;</p>\r\n<p>\r\n	<span lang="en" tabindex="-1">The scenario VIVARTE fill your program with &nbsp;musicians representative of the&nbsp;regional talent such as:<br />\r\n	<br />\r\n	<span title="Totoy, Divier Guive, Los Shamanes y Black Maria, ademÃ¡s contarÃ¡ con la participaciÃ³n especial de la compaÃ±Ã­a de espectÃ¡culos ËRougeË y la presentaciÃ³n estelar de Mexican Dubweiser.">Totoy, Divier Guiver, Shamans and Black Maria, and will feature special entertainment company Ë Ë Rouge and Dubweiser Mexican stellar presentation.</span><br />\r\n	<span title="TambiÃ©n se podrÃ¡ apreciar la presencia de, Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas''klan, Summertime Blues Band, Antares GuereÃ±a, Armando d'' Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn">We will also appreciate the presence of, Les Heritiers of Manden, Acoustic-Paradoxx, Dz-Karga, Judas&#39;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d &#39;Anna, Art Garrrid, Bahia Beat, Lower Rhythm Band, Brian Flynn </span><span title="Band, CÃ¡bula, Cambio de CorazÃ³n, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel GarcÃ­a, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, JosÃ© RamÃ³n, Karma Rush, Katarsys">Band, c&aacute;bula, Change of Heart, Cats, Chaosspell, Charlene Mignault, Urban Collective, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garcia, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Johnny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys </span><span title=", Kethe Salceda, La Cruz, Los Chales de la TÃ­a, Lunacustica, Mistica VibraciÃ³n, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, SeÃ±or Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking,">, Kethe Salceda, The Cross, The Aunt Shawls, Lunacustica, Mystic Vibration, Nidia Barajas, Panihari, Percubeta, Percussion Limanya, Ro &amp; Rockdriguez Band, Mr. Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, </span><span title="Lizzie Moran, Bong the BongÂ´s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, AdicciÃ³n NorteÃ±a, Los">Lizzie Moran, the Bong Bong&#39;s, Vyk Pichardo, Distorzion, Victor Knight, Chicken Gallus, Rodrigo, Richard O, Disco Devil, Edward P, Lucky M + Franz, Extra-Large, and Tropical Blue Sky Group, Northern Addiction, The </span><span title="AutÃ©nticos y mÃ¡s.">Authentic and more.</span><br />\r\n	<span title="El festival darÃ¡ inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs.">The festival will start from 16:00 hrs until at 01:00 hrs. </span><span title="del siguiente dÃ­a.">the next day.</span><br />\r\n	<br />\r\n	<span title="La circulaciÃ³n vehicular de las calles del primer cuadro de la zona centro permanecerÃ¡ cerrada a partir de las 10:00 hrs.">The streets of the historic center will be closed to traffic from 10:00 hrs. </span><span title="y se abrirÃ¡ despuÃ©s de que el evento se dÃ© por concluido alrededor de las 01:00hrs.">and will be opened after the event is terminated by around 01:00 hrs.</span><br />\r\n	<br />\r\n	<span title="El montaje del escenario Plaza Mijares y locaciones aledaÃ±as se realizarÃ¡ desde el dÃ­a anterior ya lo largo del dÃ­a del evento, tanto en la Plaza Mijares como en diferentes zonas del Ã¡rea Centro.">The stage set Mijares Square and surrounding locations will be from the day before and throughout the day of the event, in the Plaza Mijares and in different areas of the center area.</span><br />\r\n	<br />\r\n	<span title="Si eres mÃºsico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comitÃ© organizador y te asignarÃ¡n un espacio en un escenario.">If you are a musician, you can register by organizing your own stage and record with VIVARTE, or if you do not contact the organizing committee stage and you will be assigned a space on stage. </span><span title="Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participaciÃ³n: organizando su escenario con sus mÃºsicos y enviar la informaciÃ³n al comitÃ© o bien solicitando un espacio en coordinaciÃ³n con el comitÃ© para crear un programa.">For business owners who want to collaborate and enrich the festival, there are two options for participation: organizing your stage with musicians and send the information to the committee or by requesting a space in coordination with the committee to create a program. </span><span title="Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com">For more information you can contact the email, fiestadelamusicaloscabos@gmail.com</span><br />\r\n	<br />\r\n	<br />\r\n	<br />\r\n	<span title="MÃ¡s informaciÃ³n">More information</span><br />\r\n	<br />\r\n	<span title="http://www.fiestadelamusicaloscabos.com/">http://www.fiestadelamusicaloscabos.com/</span><br />\r\n	<span title="http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</span></span></p>\r\n', '<p>\r\n	El pr&oacute;ximo 21 de junio se llevar&aacute; a cabo la quinta edici&oacute;n de la &ldquo;Fiesta de la M&uacute;sica&rdquo; en San Jos&eacute; del Cabo, a partir de las 16:00 hrs. en las calles del centro hist&oacute;rico. Este es un evento internacional que naci&oacute; en Francia en 1982 para festejar la m&uacute;sica y as&iacute; rendir homenaje a todos los estilos musicales.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	La Asociaci&oacute;n Civil Promotora Cultural Vivarte, a trav&eacute;s del comit&eacute; organizador invita a la celebraci&oacute;n musical m&aacute;s grande del mundo, en el primer cuadro de la zona centro donde se distribuir&aacute;n 15 escenarios, contando con agrupaciones y cantantes de la localidad.</p>\r\n<p>\r\n	El escenario VIVARTE llenar&aacute; su programa con la propuesta de m&uacute;sicos representativos del talento regional como:</p>\r\n<ul>\r\n	<li>\r\n		<strong>Totoy, Divier Guive, Los Shamanes</strong> y <strong>Black Maria</strong>, adem&aacute;s contar&aacute; con la participaci&oacute;n especial de la compa&ntilde;&iacute;a de espect&aacute;culos ËRougeË y la presentaci&oacute;n estelar de <strong>Mexican Dubweiser</strong>.</li>\r\n	<li>\r\n		Tambi&eacute;n se podr&aacute; apreciar la presencia de, <strong>Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas&rsquo;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d&rsquo; Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn Band, C&aacute;bula, Cambio de Coraz&oacute;n, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garc&iacute;a, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys, Kethe Salceda, La Cruz, Los Chales de la T&iacute;a, Lunacustica, Mistica Vibraci&oacute;n, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Se&ntilde;or Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, Lizzie Moran, Bong the Bong&acute;s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicci&oacute;n Norte&ntilde;a, Los Aut&eacute;nticos</strong> y m&aacute;s.</li>\r\n</ul>\r\n<p>\r\n	El festival dar&aacute; inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs. del siguiente d&iacute;a.</p>\r\n<p>\r\n	La circulaci&oacute;n vehicular de las calles del primer cuadro de la zona centro permanecer&aacute; cerrada a partir de las 10:00 hrs. y se abrir&aacute; despu&eacute;s de que el evento se d&eacute; por concluido alrededor de las 01:00hrs.</p>\r\n<p>\r\n	El montaje del escenario Plaza Mijares y locaciones aleda&ntilde;as se realizar&aacute; desde el d&iacute;a anterior y a lo largo del d&iacute;a del evento, tanto en la Plaza Mijares como en diferentes zonas del &aacute;rea Centro.</p>\r\n<p>\r\n	Si eres m&uacute;sico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comit&eacute; organizador y te asignar&aacute;n un espacio en un escenario. Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participaci&oacute;n: organizando su escenario con sus m&uacute;sicos y enviar la informaci&oacute;n al comit&eacute; o bien solicitando un espacio en coordinaci&oacute;n con el comit&eacute; para crear un programa. Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com</p>\r\n<p>\r\n	&nbsp;</p>\r\n<h2>\r\n	M&aacute;s informaci&oacute;n</h2>\r\n<p>\r\n	<a href="http://www.fiestadelamusicaloscabos.com/" target="_blank" title="Fiesta de la musica Los Cabos.com">http://www.fiestadelamusicaloscabos.com/</a><br />\r\n	<a href="http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/" target="_blank" title="Fiesta de la musica Los Cabos.com">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</a></p>\r\n', '', '1371239012Fiesta de la musica sjc-2013-vf-3.11.jpg', 'Y', 1371239012),
(18, 'Cats â€“ The musical', 'Cats â€“ El musical', '2013-06-22 05:00:00', 'PM', '2013-06-22 07:00:00', 'PM', 1, 4, 37, 6, '<div class="almost_half_cell" id="gt-res-content">\r\n	<div dir="ltr" style="zoom:1">\r\n		<span id="result_box" lang="en" tabindex="-1"><span class="hps">Henry</span> <span class="hps">Lopez</span> <span class="hps">Studio</span> <span class="hps">presents</span>.<br />\r\n		<span class="hps">JUNE</span>, <span class="hps">Saturday 22</span> <span class="hps">and</span> <span class="hps">Sunday 23</span><br />\r\n		<span class="hps">Functions</span><span>: 5:00</span> <span class="hps">pm</span> <span class="hps">and</span> <span class="hps">8:00 pm</span> <span class="hps">both days</span><br />\r\n		<span class="hps">$ 150</span> <span class="hps">p</span> <span class="hps">/</span> <span class="hps">p</span><span>,</span> <span class="hps">general admission</span> <span class="hps">Tel</span> <span class="hps">/ Info</span> <span class="hps">*</span> <span class="hps">624</span> <span class="hps">358-6111</span></span></div>\r\n</div>\r\n', '<p>\r\n	Henry L&oacute;pez Studio presenta.<br />\r\n	JUNIO, S&aacute;bado 22 y Domingo 23<br />\r\n	Funciones: 5:00pm y 8:00pm los dos d&iacute;as<br />\r\n	$150 p/p , entrada general Tel/Info* 624 358-6111</p>\r\n', '', '1371240376cats4.jpg', 'Y', 1371240376),
(20, 'Que Brujadas! ', 'Que Brujadas! ', '2013-06-29 08:00:00', 'PM', '2013-06-29 10:00:00', 'PM', 1, 4, 36, 1, '<p>\r\n	The Theater Company Mascaras presents &quot;Que Brujadas!&quot;&nbsp;</p>\r\n', '<p>\r\n	<span class="Head">La Compa&ntilde;&iacute;a de Teatro Mascaras presenta la obra &quot;Que Brujadas!&quot;&nbsp;</span></p>\r\n', '', '1371243867teatro ciudad sjs jun 29 brujas 2013.jpg', 'Y', 1371243867);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_multiple_events`
--

CREATE TABLE IF NOT EXISTS `kcp_multiple_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  `venue` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kcp_multiple_events`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_order`
--

CREATE TABLE IF NOT EXISTS `kcp_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `email` varchar(333) NOT NULL,
  `address` varchar(333) NOT NULL,
  `address2` longtext NOT NULL,
  `country` varchar(222) NOT NULL,
  `state` varchar(222) NOT NULL,
  `city` varchar(222) NOT NULL,
  `zip` varchar(222) NOT NULL,
  `event_id` int(100) NOT NULL,
  `phone` char(50) NOT NULL,
  `qr_code` varchar(20) NOT NULL,
  `confirmation_id` varchar(222) NOT NULL,
  `user_id` int(100) NOT NULL,
  `ticket_holder` varchar(333) NOT NULL,
  `option_value` varchar(222) NOT NULL,
  `discount_amt` float NOT NULL,
  `coupon_event_id` int(11) NOT NULL,
  `order_voided` int(1) NOT NULL,
  `delivery_option` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kcp_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_order_detail`
--

CREATE TABLE IF NOT EXISTS `kcp_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(100) NOT NULL,
  `barcode` varchar(222) NOT NULL,
  `price_level_id` int(100) NOT NULL,
  `ticket_holder` varchar(333) NOT NULL,
  `ticket_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kcp_order_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_organization`
--

CREATE TABLE IF NOT EXISTS `kcp_organization` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_fname` varchar(333) NOT NULL,
  `org_lname` varchar(333) NOT NULL,
  `organization_name` varchar(333) NOT NULL,
  `org_country` int(11) NOT NULL,
  `org_address1` varchar(333) NOT NULL,
  `org_address2` varchar(333) NOT NULL,
  `org_city` varchar(222) NOT NULL,
  `org_state` varchar(222) NOT NULL,
  `org_zip` varchar(100) NOT NULL,
  `org_phone` varchar(50) NOT NULL,
  `org_fax` varchar(50) NOT NULL,
  `payable_to` varchar(333) NOT NULL,
  `pay_address` varchar(333) NOT NULL,
  `pay_address2` varchar(333) NOT NULL,
  `pay_city` varchar(222) NOT NULL,
  `pay_state` varchar(222) NOT NULL,
  `pay_zip` varchar(222) NOT NULL,
  `total_earning` float NOT NULL,
  `organization_status` int(1) NOT NULL,
  `paypal_id` varchar(222) NOT NULL,
  `wire_bankname` varchar(256) NOT NULL,
  `wire_bankaddr` varchar(256) NOT NULL,
  `wire_rtno` varchar(256) NOT NULL,
  `wire_acname` varchar(256) NOT NULL,
  `wire_acaddress` varchar(256) NOT NULL,
  `wire_acnumber` varchar(256) NOT NULL,
  `upcoming_url` varchar(256) NOT NULL,
  `send_newsletter` int(11) NOT NULL,
  PRIMARY KEY (`organization_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kcp_organization`
--

INSERT INTO `kcp_organization` (`organization_id`, `org_fname`, `org_lname`, `organization_name`, `org_country`, `org_address1`, `org_address2`, `org_city`, `org_state`, `org_zip`, `org_phone`, `org_fax`, `payable_to`, `pay_address`, `pay_address2`, `pay_city`, `pay_state`, `pay_zip`, `total_earning`, `organization_status`, `paypal_id`, `wire_bankname`, `wire_bankaddr`, `wire_rtno`, `wire_acname`, `wire_acaddress`, `wire_acnumber`, `upcoming_url`, `send_newsletter`) VALUES
(1, 'Gareth', 'Little', 'The Circle LLC', 226, '299 East 3rd Street', '', 'New York', 'New York', '10009', '', '203-260-8763', 'The Winners Circle LLC', '299 east 3rd street suite 2E', '', 'New York', 'New York', '10009', 0, 0, 'contact@thecirclellc.com', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_organization_sale`
--

CREATE TABLE IF NOT EXISTS `kcp_organization_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(100) NOT NULL,
  `organization_id` int(100) NOT NULL,
  `total_amount` float NOT NULL,
  `commission_amount` float NOT NULL,
  `without_commission` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kcp_organization_sale`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_page`
--

CREATE TABLE IF NOT EXISTS `kcp_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `page_link` varchar(255) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kcp_page`
--

INSERT INTO `kcp_page` (`page_id`, `page_name`, `page_content`, `page_link`) VALUES
(1, ' About KCPasa', '<p>\r\n	Lorem ipsum dolor sit amet, qui audire persius inermis id. Debet quando oportere ea usu, vis eu lorem commune. Postea graecis salutatus has ne, melius corpora argumentum te nec, mea et vivendum efficiendi. Et eum discere vulputate, quod feugait expetenda ei his, cu solum audiam vocibus per. Consetetur interesset pri cu, legimus perpetua consulatu his ad, his cu tation altera nusquam.<br />\r\n	<br />\r\n	Ex doming putant possim eum, melius sanctus reprehendunt per an. Case dicam pri in. Cu quod error veniam eam, an illud appetere nam, eu oblique labores principes vix. In quidam propriae vim, prima adipisci vix eu.<br />\r\n	<br />\r\n	Ne qui iusto cetero percipitur. Ad mandamus intellegam his, te vocent tractatos eam. Ei mea aeque salutatus, vis in debet aliquip. In quod cibo deserunt usu, vis fabellas theophrastus id. Cum an oblique conceptam, est in aeque soluta.<br />\r\n	<br />\r\n	Maiorum invenire est eu. Ocurreret voluptatum conclusionemque mea cu. An equidem adversarium vel, vel ne utamur nostrud salutatus, ei dico adversarium nec. Nobis legimus ea mea. Sit fabulas nominati at, ad dictas mnesarchum vituperatoribus per.<br />\r\n	<br />\r\n	Mel putant vituperatoribus ut, quodsi luptatum te cum. Cu case vocent qui. Mel te utamur dissentias, usu ut mollis gubergren. Debet sonet usu an, sed ex error partem. Vix id erant fierent. Duo senserit postulant at.</p>\r\n', 'about-kcpasa'),
(2, 'About Baja Sur', '<p>\r\n	About Baja Sur - Lorem ipsum dolor sit amet, qui audire persius inermis id. Debet quando oportere ea usu, vis eu lorem commune. Postea graecis salutatus has ne, melius corpora argumentum te nec, mea et vivendum efficiendi. Et eum discere vulputate, quod feugait expetenda ei his, cu solum audiam vocibus per. Consetetur interesset pri cu, legimus perpetua consulatu his ad, his cu tation altera nusquam.<br />\r\n	<br />\r\n	Ex doming putant possim eum, melius sanctus reprehendunt per an. Case dicam pri in. Cu quod error veniam eam, an illud appetere nam, eu oblique labores principes vix. In quidam propriae vim, prima adipisci vix eu.<br />\r\n	<br />\r\n	Ne qui iusto cetero percipitur. Ad mandamus intellegam his, te vocent tractatos eam. Ei mea aeque salutatus, vis in debet aliquip. In quod cibo deserunt usu, vis fabellas theophrastus id. Cum an oblique conceptam, est in aeque soluta.<br />\r\n	<br />\r\n	Maiorum invenire est eu. Ocurreret voluptatum conclusionemque mea cu. An equidem adversarium vel, vel ne utamur nostrud salutatus, ei dico adversarium nec. Nobis legimus ea mea. Sit fabulas nominati at, ad dictas mnesarchum vituperatoribus per.</p>\r\n', 'about-baja-sur');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_price_level`
--

CREATE TABLE IF NOT EXISTS `kcp_price_level` (
  `price_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `price_name` varchar(222) NOT NULL,
  `price_amount` float NOT NULL,
  `ticket_limit` int(255) NOT NULL,
  `ticket_sold` int(255) NOT NULL,
  `price_status` int(1) NOT NULL,
  `price_description` longtext NOT NULL,
  `event_id` int(11) NOT NULL,
  `price_level_status` int(1) NOT NULL,
  PRIMARY KEY (`price_level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kcp_price_level`
--


-- --------------------------------------------------------

--
-- Table structure for table `kcp_setting`
--

CREATE TABLE IF NOT EXISTS `kcp_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(333) NOT NULL,
  `api_login_id` varchar(255) NOT NULL,
  `transaction_key` varchar(255) NOT NULL,
  `authorizenet_sandbox` char(20) NOT NULL,
  `smtp_host` varchar(50) NOT NULL,
  `smtp_port` varchar(50) NOT NULL,
  `smtp_username` varchar(50) NOT NULL,
  `smtp_password` varchar(50) NOT NULL,
  `smtp_active` int(1) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `contact_no` char(50) NOT NULL,
  `gmap_api` varchar(333) NOT NULL,
  `fb_app_id` varchar(256) NOT NULL,
  `fb_secret` varchar(256) NOT NULL,
  `topbanner_link` varchar(256) NOT NULL,
  `topbanner_image` varchar(256) NOT NULL,
  `sidebanner_link` varchar(256) NOT NULL,
  `sidebanner_image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kcp_setting`
--

INSERT INTO `kcp_setting` (`id`, `email`, `api_login_id`, `transaction_key`, `authorizenet_sandbox`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_active`, `site_name`, `contact_no`, `gmap_api`, `fb_app_id`, `fb_secret`, `topbanner_link`, `topbanner_image`, `sidebanner_link`, `sidebanner_image`) VALUES
(1, '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', 'top_1262447899_01358_D PIC 4 MAS KA RAID_004.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_state`
--

CREATE TABLE IF NOT EXISTS `kcp_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kcp_state`
--

INSERT INTO `kcp_state` (`id`, `country_id`, `state_name`) VALUES
(1, 138, 'Baja California Sur'),
(2, 96, 'West Bengal');

-- --------------------------------------------------------

--
-- Table structure for table `kcp_temporary_tickets`
--

CREATE TABLE IF NOT EXISTS `kcp_temporary_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `kcp_temporary_tickets`
--

INSERT INTO `kcp_temporary_tickets` (`ticket_id`, `event_id`, `ticket_name_en`, `ticket_name_sp`, `description_en`, `description_sp`, `price_mx`, `price_us`, `ticket_num`, `from_ticket`, `to_ticket`, `eairly_dis_percen`, `eairly_days`, `group_dis_per`, `group_dis_days`, `ticket_icon`, `members_only`, `unique_id`, `post_date`) VALUES
(14, 0, 'Package A - 8 conferences on Saturday', 'Paquete A - 8 conferencias el sabado', 'Entrance to the 8 conference on Saturday\n* Includes entry kit, diploma and raffle ticket', 'Entrada a las OCHO conferencias del Sabado\n*Incluye kit de entrada, diploma y folio para rifa', 0.00, 0.00, 0, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '801542968', 1371098347),
(15, 0, 'Package A - 8 conferences on Saturday', 'Paquete A - 8 conferencias el sabado', 'Entrance to the 8 conference on Saturday\n* Includes entry kit, diploma and raffle ticket', 'Entrada a las OCHO conferencias del Sabado\n*Incluye kit de entrada, diploma y folio para rifa', 650.00, 0.00, 0, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '1859033602', 1371098350),
(16, 0, 'Package A - 8 conferences on Saturday', 'Paquete A - 8 conferencias el sabado', 'Entrance to the 8 conference on Saturday\n* Includes entry kit, diploma and raffle ticket', 'Entrada a las OCHO conferencias del Sabado\n*Incluye kit de entrada, diploma y folio para rifa', 0.00, 0.00, 0, '1370975400', '1372789800', 0.00, 0, 0.00, 0, '', 'N', '1859033602', 1371098350),
(26, 0, 'General admission', 'entrada general', 'Description', 'DescripciÃ³n', 150.00, 0.00, 0, '', '', 0.00, 0, 0.00, 0, '', 'N', '1291021625', 1371240590);

-- --------------------------------------------------------

--
-- Table structure for table `kcp_venue`
--

CREATE TABLE IF NOT EXISTS `kcp_venue` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(333) NOT NULL,
  `venue_country` int(7) NOT NULL,
  `venue_address` varchar(333) NOT NULL,
  `venue_city` int(7) NOT NULL,
  `venue_state` int(7) NOT NULL,
  `venue_county` int(7) NOT NULL,
  `venue_zip` varchar(333) NOT NULL,
  `venue_timezone` varchar(100) NOT NULL,
  `event_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `venue_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `organization_id` int(11) NOT NULL,
  `venue_contact_name` varchar(333) NOT NULL,
  `venue_description` text NOT NULL,
  `venue_type` varchar(222) NOT NULL,
  `venue_capacity` int(100) NOT NULL,
  `venue_url` varchar(333) NOT NULL,
  `venue_phone` varchar(50) NOT NULL,
  `venue_fax` varchar(50) NOT NULL,
  `venue_email` varchar(333) NOT NULL,
  `venue_image` varchar(222) NOT NULL,
  `venue_seat_chart` varchar(333) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `kcp_venue`
--

INSERT INTO `kcp_venue` (`venue_id`, `venue_name`, `venue_country`, `venue_address`, `venue_city`, `venue_state`, `venue_county`, `venue_zip`, `venue_timezone`, `event_id`, `admin_id`, `venue_active`, `organization_id`, `venue_contact_name`, `venue_description`, `venue_type`, `venue_capacity`, `venue_url`, `venue_phone`, `venue_fax`, `venue_email`, `venue_image`, `venue_seat_chart`) VALUES
(1, 'Teatro de la Ciudad "Miguel Lomeli CeseÃ±a"', 138, 'Calle Ignacio Zaragoza', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(3, 'Playa Medano', 138, 'Playa Medano', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(6, 'PabellÃ³n Cultural de la republica', 138, 'Blvd Marina', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(7, 'Art District', 138, 'Calle Alvaro Obregon', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(10, 'Pueblo Bonito Pacifica Resort & Spa', 138, 'Pacifico', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(11, 'Wyndham Cabo San Lucas Resort', 138, ', Boulevard Marina S/N Lote 9 y 10', 37, 1, 4, '23450', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(12, 'Nikki Beach Cabo San Lucas', 138, 'ME Cabo Playa El Medano', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(13, 'Organic Market Pedregal', 138, 'Mar A Dentro, Camino del Colegio, Colonia Pedregal', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(14, 'El Squid Roe, Cabo san Lucas', 138, 'LÃ¡zaro CÃ¡rdenas Sn, colonia Centro', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(15, 'The Shoppes at Palmilla', 138, 'Car Transpeninsular km 27.5', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(16, 'Huerta Maria', 138, 'Camino a Las Animas', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(17, 'Ciclovia San Lucas', 138, 'Blvd Marina', 37, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(18, 'Hotel Buena Vista Beach Resort', 138, 'Carr. Federal #1 Km. 105, Buena Vista ', 28, 1, 2, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(21, 'El Pescadero', 138, 'El Pescadero', 21, 1, 2, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(20, 'Loreto MalecÃ³n costero', 138, 'MalecÃ³n costero', 33, 1, 3, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(22, 'Central Plaza', 138, 'Central Plaza', 21, 1, 2, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(25, 'Zippers beach', 138, 'Costa Azul,  carretera transpeninsular Km.28.5', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(24, 'Tsegyalgar West ', 138, 'Rancho Los Naranjos', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(26, 'Centro historico', 138, 'centro', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(27, 'Plaza Mijares', 138, 'Plaza Mijares', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', ''),
(28, 'Estadio de basebol', 138, 'Estadio de basebol', 36, 1, 4, '', '', 0, 1, 'Y', 1, '', '', '', 0, '', '', '', '', '', '');
