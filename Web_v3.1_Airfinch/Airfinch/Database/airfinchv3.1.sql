-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2019 at 12:27 PM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.0.33-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airfinchLive`
--

-- --------------------------------------------------------

--
-- Table structure for table `hts_additionalamenities`
--

CREATE TABLE `hts_additionalamenities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `additionalimage` varchar(30) DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_additionalamenities`
--

INSERT INTO `hts_additionalamenities` (`id`, `name`, `description`, `additionalimage`, `status`, `cdate`) VALUES
(1, 'Hot tub', 'Hot tub is available at bath area', 'additional_1552309511.png', NULL, 1552309540),
(2, 'Cooking basics', 'Pots and pans, oil, salt and pepper', 'additional_1552309668.png', NULL, 1552309670),
(3, 'Pool', 'Pool is very big with 3 to 12 feet height, 150 m long, 50 m width.', 'additional_1552309828.png', NULL, 1552309829),
(4, 'Free parking on premises', 'Free Parking is allowed for cycles, bike, four wheels type light motor vehicles', 'additional_1552309948.png', NULL, 1552309949),
(5, 'Gym', 'Gym is available with in our premises from 5 A.M - 9.00 P.M, Age limit minimum of atleast 15 years', 'additional_1552310077.png', NULL, 1552310078),
(6, 'BBQ grill', 'Out space facility for BBQ is allowed, essentials need for BBQ is availble at out premises', 'additional_1552310198.png', NULL, 1552310199),
(7, 'Washer', 'Washer is allowed near by or make an call to our administrator', 'additional_1552310332.png', NULL, 1552310334),
(8, 'Dryer', 'Availalbe at our Premises', 'additional_1552310419.png', NULL, 1552310420);

-- --------------------------------------------------------

--
-- Table structure for table `hts_additionallisting`
--

CREATE TABLE `hts_additionallisting` (
  `id` int(11) NOT NULL,
  `listingid` int(11) DEFAULT NULL,
  `amenityid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_additionallisting`
--

INSERT INTO `hts_additionallisting` (`id`, `listingid`, `amenityid`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 1),
(10, 2, 2),
(11, 2, 3),
(12, 2, 4),
(13, 2, 5),
(14, 2, 6),
(15, 2, 8),
(16, 3, 1),
(17, 3, 2),
(18, 3, 3),
(19, 3, 4),
(20, 3, 5),
(21, 3, 6),
(22, 3, 7),
(23, 3, 8),
(24, 4, 1),
(25, 4, 2),
(26, 4, 3),
(27, 4, 5),
(28, 4, 6),
(29, 4, 7),
(30, 5, 2),
(31, 5, 7),
(32, 5, 8),
(33, 6, 2),
(34, 6, 7),
(35, 6, 8),
(36, 7, 2),
(37, 7, 6),
(38, 7, 7),
(39, 8, 1),
(40, 8, 2),
(41, 8, 3),
(42, 8, 4),
(43, 8, 5),
(44, 8, 6),
(45, 8, 7),
(46, 8, 8),
(47, 9, 2),
(48, 9, 3),
(49, 9, 5),
(50, 9, 7),
(51, 9, 8),
(52, 10, 1),
(53, 10, 2),
(54, 10, 3),
(55, 10, 4),
(56, 10, 5),
(57, 10, 6),
(58, 10, 7),
(59, 10, 8),
(60, 11, 1),
(61, 11, 2),
(62, 11, 3),
(63, 11, 4),
(64, 11, 5),
(65, 11, 6),
(66, 11, 7),
(67, 11, 8),
(68, 12, 1),
(69, 12, 2),
(70, 12, 3),
(71, 12, 4),
(72, 12, 5),
(73, 12, 6),
(74, 12, 7),
(75, 12, 8),
(76, 13, 1),
(77, 13, 2),
(78, 13, 4),
(79, 13, 7),
(80, 13, 8),
(81, 14, 1),
(82, 14, 2),
(83, 14, 4),
(84, 14, 6),
(85, 14, 7),
(86, 14, 8),
(87, 15, 1),
(88, 15, 2),
(89, 15, 3),
(90, 15, 4),
(91, 15, 5),
(92, 15, 6),
(93, 15, 7),
(94, 15, 8),
(95, 16, 1),
(96, 16, 2),
(97, 16, 4),
(98, 16, 5),
(99, 16, 7),
(100, 16, 8),
(101, 17, 4),
(102, 17, 6),
(103, 17, 7),
(104, 17, 8),
(105, 18, 2),
(106, 18, 4),
(107, 18, 7),
(108, 18, 8),
(109, 19, 4),
(110, 19, 7),
(111, 19, 8),
(112, 20, 1),
(113, 20, 2),
(114, 20, 6),
(115, 20, 7),
(116, 20, 8),
(117, 21, 2),
(118, 21, 7),
(119, 21, 8),
(120, 22, 1),
(121, 22, 2),
(122, 22, 3),
(123, 22, 4),
(124, 22, 5),
(125, 22, 6),
(126, 22, 7),
(127, 22, 8),
(128, 23, 1),
(129, 23, 2),
(130, 23, 3),
(131, 23, 4),
(132, 23, 5),
(133, 23, 7),
(134, 23, 8),
(135, 24, 1),
(136, 24, 2),
(137, 24, 7),
(138, 24, 8),
(139, 25, 2),
(140, 25, 4),
(141, 26, 2),
(142, 26, 4),
(143, 26, 8),
(144, 27, 3),
(145, 27, 4),
(146, 27, 6),
(147, 27, 7),
(148, 27, 8),
(149, 28, 2),
(150, 28, 4),
(151, 28, 7),
(152, 28, 8),
(153, 29, 2),
(154, 29, 3),
(155, 29, 4),
(156, 29, 7),
(157, 29, 8),
(158, 30, 1),
(159, 30, 2),
(160, 30, 3),
(161, 30, 4),
(162, 30, 5),
(163, 30, 7),
(164, 30, 8),
(165, 31, 1),
(166, 31, 2),
(167, 31, 3),
(168, 32, 1),
(169, 32, 2),
(170, 32, 3),
(171, 32, 4),
(172, 32, 5),
(173, 32, 6),
(174, 32, 7),
(175, 32, 8),
(176, 33, 1),
(177, 33, 2),
(178, 33, 3),
(179, 33, 4),
(180, 33, 5),
(181, 33, 6),
(182, 33, 7),
(183, 33, 8);

-- --------------------------------------------------------

--
-- Table structure for table `hts_buttonsliders`
--

CREATE TABLE `hts_buttonsliders` (
  `id` int(11) NOT NULL,
  `title` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `buttonname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `buttonlink` text CHARACTER SET utf8,
  `sliderimage` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_buttonsliders`
--

INSERT INTO `hts_buttonsliders` (`id`, `title`, `description`, `buttonname`, `buttonlink`, `sliderimage`) VALUES
(1, 'Profits from guest stay', 'Admin can earn commission from guest who books stays through their online vacation rental platform.', 'Earnings from guest', 'https://airfinchscript.com/', '1552374599.jpg'),
(2, 'Hosting in community based platform', 'Become a host into this collabarative online space renting platform to get reached around huge number of travellers.', 'Earnings on host listing', 'https://airfinchscript.com/', '1552376137.jpg'),
(3, 'Revenue on every booking', 'Being an Admin through this Airfinch script, earn commission from the host on every successful property booking. ', 'Earn revenue', 'https://airfinchscript.com/', '1552376361.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hts_cancellation`
--

CREATE TABLE `hts_cancellation` (
  `id` int(11) NOT NULL,
  `policyname` varchar(255) NOT NULL,
  `policylimit` varchar(255) NOT NULL,
  `cancelfrom` int(5) DEFAULT NULL,
  `cancelto` int(5) DEFAULT NULL,
  `cancelpercentage` int(3) DEFAULT NULL,
  `canceldesc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_cancellation`
--

INSERT INTO `hts_cancellation` (`id`, `policyname`, `policylimit`, `cancelfrom`, `cancelto`, `cancelpercentage`, `canceldesc`) VALUES
(1, 'Super strict', '', 0, 7, 30, 'For Guest Attention: Cancel the trip before 7days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 7 days of your trip - 30% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.'),
(2, 'Strict', '', 0, 10, 25, 'For Guest Attention: Cancel the trip before 10 days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 10 days of your trip - 25% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.'),
(3, 'Liberal', '', 0, 15, 22, 'For Guest Attention: Cancel the trip before 15days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 15 days of your trip - 22% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.'),
(4, 'Moderate', '', 0, 20, 18, '  For Guest Attention: Cancel the trip before 20 days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 20 days of your trip - 180% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.'),
(5, 'Long Term', '', 0, 30, 15, 'For Guest Attention: Cancel the trip before 30 days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 30 days of your trip - 15% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.'),
(6, 'Flexible', '', 0, 60, 10, 'For Guest Attention: Cancel the trip before 60 days of your check-in and get a 100% refund (minus service fees and Commission Fees). Cancel within 60 days of your trip - 10% amount will deducted and refunded to you (minus service fees and Commission Fees). Cancellation amount will be credited to Host.');

-- --------------------------------------------------------

--
-- Table structure for table `hts_claim`
--

CREATE TABLE `hts_claim` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `reservationid` int(11) DEFAULT NULL,
  `sdamount` varchar(10) DEFAULT NULL,
  `sdstatus` varchar(10) DEFAULT NULL,
  `claimby` varchar(10) DEFAULT NULL,
  `claimstatus` varchar(20) DEFAULT NULL,
  `receiverstatus` varchar(20) DEFAULT NULL,
  `involveadmin` int(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_claimmessage`
--

CREATE TABLE `hts_claimmessage` (
  `id` int(11) NOT NULL,
  `claimid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `hostid` int(11) DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `sentby` varchar(6) DEFAULT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_commission`
--

CREATE TABLE `hts_commission` (
  `id` int(11) NOT NULL,
  `min_value` varchar(15) DEFAULT NULL,
  `max_value` varchar(15) DEFAULT NULL,
  `percentage` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_commission`
--

INSERT INTO `hts_commission` (`id`, `min_value`, `max_value`, `percentage`) VALUES
(1, '1', '1000', '12'),
(2, '1000', '10000', '10'),
(3, '10000', '100000', '8'),
(4, '100000', '9999000', '7');

-- --------------------------------------------------------

--
-- Table structure for table `hts_commonamenities`
--

CREATE TABLE `hts_commonamenities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `commonimage` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_commonamenities`
--

INSERT INTO `hts_commonamenities` (`id`, `name`, `description`, `commonimage`, `status`, `cdate`) VALUES
(1, 'Essentials', 'Towels, bed sheets, soap, toilet paper, and pillows', 'additional_1552310539.png', NULL, 1552310540),
(2, 'Kitchen', 'Space where guests can cook their own meals', 'additional_1552310631.png', NULL, 1552310633),
(3, 'Air Conditioning', '', 'additional_1552310719.png', NULL, 1552310720),
(4, 'Heating', 'Central heating or a heater in the listing', 'additional_1552310759.png', NULL, 1552310760),
(5, 'Wifi', 'Continuous access in the listing', 'additional_1552310803.png', NULL, 1552310804),
(6, '24-Hour Check-in', 'Check in allowed at any time in your booked schedule', 'additional_1552310893.png', NULL, 1552310894),
(7, 'TV', 'Television is available at Main hall and bedroom', 'additional_1552311006.png', NULL, 1552311007),
(8, 'Cable', 'Cable facility is available for all televisions', 'additional_1552311198.png', NULL, 1552311201),
(9, 'Hangers', 'Hangers availble for cloths to be dry', 'additional_1552311342.png', NULL, 1552311343),
(10, 'Laptop friendly workspace', 'A table or desk with space for a laptop and a chair that’s comfortable to work in', 'additional_1552311391.png', NULL, 1552311393);

-- --------------------------------------------------------

--
-- Table structure for table `hts_commonlisting`
--

CREATE TABLE `hts_commonlisting` (
  `id` int(11) NOT NULL,
  `listingid` int(11) DEFAULT NULL,
  `amenityid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_commonlisting`
--

INSERT INTO `hts_commonlisting` (`id`, `listingid`, `amenityid`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 10),
(10, 2, 1),
(11, 2, 2),
(12, 2, 3),
(13, 2, 4),
(14, 2, 5),
(15, 2, 6),
(16, 2, 7),
(17, 2, 8),
(18, 2, 9),
(19, 2, 10),
(20, 3, 1),
(21, 3, 2),
(22, 3, 3),
(23, 3, 4),
(24, 3, 5),
(25, 3, 6),
(26, 3, 7),
(27, 3, 8),
(28, 3, 9),
(29, 3, 10),
(30, 4, 1),
(31, 4, 2),
(32, 4, 3),
(33, 4, 4),
(34, 4, 5),
(35, 4, 6),
(36, 4, 7),
(37, 4, 8),
(38, 4, 9),
(39, 4, 10),
(40, 5, 1),
(41, 5, 2),
(42, 5, 3),
(43, 5, 5),
(44, 5, 7),
(45, 5, 8),
(46, 5, 10),
(47, 6, 1),
(48, 6, 2),
(49, 6, 3),
(50, 7, 1),
(51, 7, 3),
(52, 7, 5),
(53, 7, 7),
(54, 7, 8),
(55, 8, 1),
(56, 8, 2),
(57, 8, 3),
(58, 8, 4),
(59, 8, 5),
(60, 8, 6),
(61, 8, 7),
(62, 8, 8),
(63, 8, 9),
(64, 8, 10),
(65, 9, 1),
(66, 9, 2),
(67, 9, 3),
(68, 9, 5),
(69, 9, 7),
(70, 10, 1),
(71, 10, 2),
(72, 10, 3),
(73, 10, 4),
(74, 10, 5),
(75, 10, 6),
(76, 10, 7),
(77, 10, 8),
(78, 10, 9),
(79, 10, 10),
(80, 11, 1),
(81, 11, 2),
(82, 11, 3),
(83, 11, 4),
(84, 11, 5),
(85, 11, 6),
(86, 11, 7),
(87, 11, 8),
(88, 11, 9),
(89, 11, 10),
(90, 12, 1),
(91, 12, 2),
(92, 12, 3),
(93, 12, 4),
(94, 12, 5),
(95, 12, 6),
(96, 12, 7),
(97, 12, 8),
(98, 12, 9),
(99, 12, 10),
(100, 13, 1),
(101, 13, 2),
(102, 13, 4),
(103, 13, 5),
(104, 13, 6),
(105, 13, 7),
(106, 13, 8),
(107, 13, 9),
(108, 13, 10),
(109, 14, 1),
(110, 14, 2),
(111, 14, 4),
(112, 14, 5),
(113, 14, 6),
(114, 14, 7),
(115, 14, 8),
(116, 14, 9),
(117, 15, 1),
(118, 15, 2),
(119, 15, 3),
(120, 15, 4),
(121, 15, 5),
(122, 15, 6),
(123, 15, 7),
(124, 15, 8),
(125, 15, 9),
(126, 15, 10),
(127, 16, 1),
(128, 16, 2),
(129, 16, 3),
(130, 16, 5),
(131, 16, 6),
(132, 16, 7),
(133, 16, 8),
(134, 16, 10),
(135, 17, 1),
(136, 17, 2),
(137, 17, 4),
(138, 17, 7),
(139, 17, 8),
(140, 17, 9),
(141, 18, 1),
(142, 18, 2),
(143, 18, 3),
(144, 18, 4),
(145, 18, 5),
(146, 18, 6),
(147, 18, 7),
(148, 18, 8),
(149, 18, 9),
(150, 18, 10),
(151, 19, 3),
(152, 19, 5),
(153, 19, 6),
(154, 19, 7),
(155, 19, 8),
(156, 19, 9),
(157, 19, 10),
(158, 20, 1),
(159, 20, 2),
(160, 20, 4),
(161, 20, 5),
(162, 20, 7),
(163, 20, 8),
(164, 20, 9),
(165, 20, 10),
(166, 21, 1),
(167, 21, 2),
(168, 21, 3),
(169, 21, 5),
(170, 21, 6),
(171, 21, 7),
(172, 21, 8),
(173, 21, 9),
(174, 21, 10),
(175, 22, 1),
(176, 22, 2),
(177, 22, 4),
(178, 22, 5),
(179, 22, 6),
(180, 22, 7),
(181, 22, 8),
(182, 22, 9),
(183, 22, 10),
(184, 23, 1),
(185, 23, 2),
(186, 23, 3),
(187, 23, 4),
(188, 23, 5),
(189, 23, 6),
(190, 23, 7),
(191, 23, 8),
(192, 23, 9),
(193, 23, 10),
(194, 24, 1),
(195, 24, 2),
(196, 24, 3),
(197, 24, 7),
(198, 25, 1),
(199, 25, 2),
(200, 25, 3),
(201, 25, 5),
(202, 25, 7),
(203, 26, 1),
(204, 26, 2),
(205, 26, 5),
(206, 26, 10),
(207, 27, 1),
(208, 27, 2),
(209, 27, 3),
(210, 27, 5),
(211, 27, 7),
(212, 27, 8),
(213, 28, 1),
(214, 28, 2),
(215, 28, 3),
(216, 28, 4),
(217, 28, 5),
(218, 28, 6),
(219, 28, 7),
(220, 28, 8),
(221, 28, 9),
(222, 28, 10),
(223, 29, 1),
(224, 29, 2),
(225, 29, 3),
(226, 29, 4),
(227, 29, 5),
(228, 29, 7),
(229, 29, 8),
(230, 29, 9),
(231, 30, 1),
(232, 30, 2),
(233, 30, 3),
(234, 30, 4),
(235, 30, 5),
(236, 30, 6),
(237, 30, 7),
(238, 30, 8),
(239, 30, 9),
(240, 31, 1),
(241, 31, 2),
(242, 31, 3),
(243, 31, 4),
(244, 31, 5),
(245, 31, 6),
(246, 32, 3),
(247, 32, 4),
(248, 32, 5),
(249, 32, 6),
(250, 32, 7),
(251, 32, 8),
(252, 32, 10),
(253, 33, 1),
(254, 33, 2),
(255, 33, 3),
(256, 33, 4),
(257, 33, 5),
(258, 33, 6),
(259, 33, 7),
(260, 33, 8),
(261, 33, 9),
(262, 33, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hts_country`
--

CREATE TABLE `hts_country` (
  `id` int(11) NOT NULL,
  `code` varchar(3) DEFAULT NULL,
  `countryname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `alternative` varchar(150) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_country`
--

INSERT INTO `hts_country` (`id`, `code`, `countryname`, `alternative`, `latitude`, `longitude`) VALUES
(1, 'AF', 'Afghanistan', NULL, 33.939110, 67.709953),
(2, 'AL', 'Albania', NULL, 41.153332, 20.168331),
(3, 'DZ', 'Algeria', NULL, 28.033886, 1.659626),
(4, 'AS', 'American Samoa', NULL, -14.270972, -170.132217),
(5, 'AD', 'Andorra', NULL, 42.506287, 1.521801),
(6, 'AO', 'Angola', NULL, -11.202692, 17.873886),
(7, 'AI', 'Anguilla', NULL, 18.220554, -63.068615),
(8, 'AQ', 'Antarctica', NULL, -82.862755, 135.000000),
(9, 'AG', 'Antigua and Barbuda', NULL, 17.060816, -61.796429),
(10, 'AR', 'Argentina', NULL, -38.416096, -63.616673),
(11, 'AM', 'Armenia', NULL, 40.069099, 45.038189),
(12, 'AW', 'Aruba', NULL, 12.521110, -69.968338),
(13, 'AU', 'Australia', NULL, -25.274399, 133.775131),
(14, 'AT', 'Austria', NULL, 47.516232, 14.550072),
(15, 'AZ', 'Azerbaijan', NULL, 40.143105, 47.576927),
(16, 'BS', 'Bahamas', NULL, 25.034281, -77.396278),
(17, 'BH', 'Bahrain', NULL, 26.066700, 50.557701),
(18, 'BD', 'Bangladesh', NULL, 23.684994, 90.356331),
(19, 'BB', 'Barbados', NULL, 13.193887, -59.543198),
(20, 'BY', 'Belarus', NULL, 53.709808, 27.953388),
(21, 'BE', 'Belgium', NULL, 50.503887, 4.469936),
(22, 'BZ', 'Belize', NULL, 17.189877, -88.497650),
(23, 'BJ', 'Benin', NULL, 9.307690, 2.315834),
(24, 'BM', 'Bermuda', NULL, 32.307800, -64.750504),
(25, 'BT', 'Bhutan', NULL, 27.514162, 90.433601),
(26, 'BO', 'Bolivia', NULL, -16.290154, -63.588654),
(27, 'BA', 'Bosnia and Herzegovina', NULL, 43.915886, 17.679075),
(28, 'BW', 'Botswana', NULL, -22.328474, 24.684866),
(29, 'BV', 'Bouvet Island', NULL, -54.420792, 3.346450),
(30, 'BR', 'Brazil', NULL, -14.235004, -51.925282),
(31, 'IO', 'British Indian Ocean Territory', NULL, -6.343194, 71.876518),
(32, 'BN', 'Brunei Darussalam', NULL, 4.535277, 114.727669),
(33, 'BG', 'Bulgaria', NULL, 42.733883, 25.485830),
(34, 'BF', 'Burkina Faso', NULL, 12.238333, -1.561593),
(35, 'BI', 'Burundi', NULL, -3.373056, 29.918886),
(36, 'KH', 'Cambodia', NULL, 12.565679, 104.990967),
(37, 'CM', 'Cameroon', NULL, 7.369722, 12.354722),
(38, 'CA', 'Canada', NULL, 56.130367, -106.346771),
(39, 'CV', 'Cape Verde', NULL, 16.538799, -23.041800),
(40, 'KY', 'Cayman Islands', NULL, 19.313299, -81.254601),
(41, 'CF', 'Central African Republic', NULL, 6.611111, 20.939444),
(42, 'TD', 'Chad', NULL, 15.454166, 18.732206),
(43, 'CL', 'Chile', NULL, -35.675148, -71.542969),
(44, 'CN', 'China', NULL, 35.861660, 104.195396),
(45, 'CX', 'Christmas Island', NULL, -10.447525, 105.690453),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, -12.164165, 96.870956),
(47, 'CO', 'Colombia', NULL, 4.570868, -74.297333),
(48, 'KM', 'Comoros', NULL, -11.645500, 43.333302),
(49, 'CG', 'Congo', NULL, -4.038333, 21.758663),
(50, 'CD', 'Congo, The Democratic Republic of the', NULL, -4.038333, 21.758663),
(51, 'CK', 'Cook Islands', NULL, -21.236736, -159.777664),
(52, 'CR', 'Costa Rica', NULL, 9.748917, -83.753426),
(53, 'CI', 'Côte D\'Ivoire', NULL, 7.539989, -5.547080),
(54, 'HR', 'Croatia', NULL, 45.099998, 15.200000),
(55, 'CU', 'Cuba', NULL, 21.521757, -77.781166),
(56, 'CY', 'Cyprus', NULL, 35.126411, 33.429859),
(57, 'CZ', 'Czech Republic', NULL, 49.817493, 15.472962),
(58, 'DK', 'Denmark', NULL, 56.263920, 9.501785),
(59, 'DJ', 'Djibouti', NULL, 11.825138, 42.590275),
(60, 'DM', 'Dominica', NULL, 15.414999, -61.370975),
(61, 'DO', 'Dominican Republic', NULL, 18.735693, -70.162651),
(62, 'EC', 'Ecuador', NULL, -1.831239, -78.183403),
(63, 'EG', 'Egypt', NULL, 26.820553, 30.802498),
(64, 'SV', 'El Salvador', NULL, 13.794185, -88.896530),
(65, 'GQ', 'Equatorial Guinea', NULL, 1.650801, 10.267895),
(66, 'ER', 'Eritrea', NULL, 15.179384, 39.782333),
(67, 'EE', 'Estonia', NULL, 58.595272, 25.013607),
(68, 'ET', 'Ethiopia', NULL, 9.145000, 40.489674),
(69, 'FK', 'Falkland Islands (Malvinas)', NULL, -51.796253, -59.523613),
(70, 'FO', 'Faroe Islands', NULL, 61.892635, -6.911806),
(71, 'FJ', 'Fiji', NULL, -17.713371, 178.065033),
(72, 'FI', 'Finland', NULL, 61.924110, 25.748152),
(73, 'FR', 'France', NULL, 46.227638, 2.213749),
(74, 'GF', 'French Guiana', NULL, 3.933889, -53.125782),
(75, 'PF', 'French Polynesia', NULL, -17.679743, -149.406845),
(76, 'TF', 'French Southern Territories', NULL, -49.280365, 69.348557),
(77, 'GA', 'Gabon', NULL, -0.803689, 11.609444),
(78, 'GM', 'Gambia', NULL, 13.443182, -15.310139),
(79, 'GE', 'Georgia', NULL, 32.165623, -82.900078),
(80, 'DE', 'Germany', NULL, 51.165691, 10.451526),
(81, 'GH', 'Ghana', NULL, 7.946527, -1.023194),
(82, 'GI', 'Gibraltar', NULL, 36.140751, -5.353585),
(83, 'GR', 'Greece', NULL, 39.074207, 21.824312),
(84, 'GL', 'Greenland', NULL, 71.706940, -42.604301),
(85, 'GD', 'Grenada', NULL, 12.116500, -61.679001),
(86, 'GP', 'Guadeloupe', NULL, 16.264999, -61.550999),
(87, 'GU', 'Guam', NULL, 13.444304, 144.793732),
(88, 'GT', 'Guatemala', NULL, 15.783471, -90.230759),
(89, 'GG', 'Guernsey', NULL, 49.448196, -2.589490),
(90, 'GN', 'Guinea', NULL, 9.945587, -9.696645),
(91, 'GW', 'Guinea-Bissau', NULL, 11.803749, -15.180413),
(92, 'GY', 'Guyana', NULL, 4.860416, -58.930180),
(93, 'HT', 'Haiti', NULL, 18.971188, -72.285217),
(94, 'HM', 'Heard Island and McDonald Islands', NULL, -53.081810, 73.504158),
(95, 'VA', 'Holy See (Vatican City State)', NULL, 41.902916, 12.453389),
(96, 'HN', 'Honduras', NULL, 15.199999, -86.241905),
(97, 'HK', 'Hong Kong', NULL, 22.396427, 114.109497),
(98, 'HU', 'Hungary', NULL, 47.162495, 19.503304),
(99, 'IS', 'Iceland', NULL, 64.963051, -19.020836),
(100, 'IN', 'India', NULL, 20.593683, 78.962883),
(101, 'ID', 'Indonesia', NULL, -0.789275, 113.921326),
(102, 'IR', 'Iran, Islamic Republic of', NULL, 32.427910, 53.688046),
(103, 'IQ', 'Iraq', NULL, 33.223190, 43.679291),
(104, 'IE', 'Ireland', NULL, 53.142368, -7.692054),
(105, 'IM', 'Isle of Man', NULL, 54.236107, -4.548056),
(106, 'IL', 'Israel', NULL, 31.046051, 34.851612),
(107, 'IT', 'Italy', NULL, 41.871941, 12.567380),
(108, 'JM', 'Jamaica', NULL, 18.109581, -77.297508),
(109, 'JP', 'Japan', NULL, 36.204823, 138.252930),
(110, 'JE', 'Jersey', NULL, 49.214439, -2.131250),
(111, 'JO', 'Jordan', NULL, 37.997372, -97.334259),
(112, 'KZ', 'Kazakhstan', NULL, 48.019573, 66.923683),
(113, 'KE', 'Kenya', NULL, -0.023559, 37.906193),
(114, 'KI', 'Kiribati', NULL, -3.370417, -168.734039),
(115, 'KP', 'Korea, Democratic People\'s Republic of', NULL, 40.339851, 127.510094),
(116, 'KR', 'Korea, Republic of', NULL, 35.907757, 127.766922),
(117, 'KW', 'Kuwait', NULL, 29.311661, 47.481766),
(118, 'KG', 'Kyrgyzstan', NULL, 41.204380, 74.766098),
(119, 'LA', 'Lao People\'s Democratic Republic', NULL, 19.856270, 102.495499),
(120, 'LV', 'Latvia', NULL, 56.879635, 24.603189),
(121, 'LB', 'Lebanon', NULL, 33.854721, 35.862286),
(122, 'LS', 'Lesotho', NULL, -29.609987, 28.233608),
(123, 'LR', 'Liberia', NULL, 6.428055, -9.429499),
(124, 'LY', 'Libyan Arab Jamahiriya', NULL, 26.335100, 17.228331),
(125, 'LI', 'Liechtenstein', NULL, 47.166000, 9.555373),
(126, 'LT', 'Lithuania', NULL, 55.169437, 23.881275),
(127, 'LU', 'Luxembourg', NULL, 49.815273, 6.129583),
(128, 'MO', 'Macao', NULL, 22.198746, 113.543877),
(129, 'MK', 'Macedonia, The Former Yugoslav Republic of', NULL, 41.608635, 21.745275),
(130, 'MG', 'Madagascar', NULL, -18.766947, 46.869106),
(131, 'MW', 'Malawi', NULL, -13.254308, 34.301525),
(132, 'MY', 'Malaysia', NULL, 4.210484, 101.975769),
(133, 'MV', 'Maldives', NULL, 3.202778, 73.220680),
(134, 'ML', 'Mali', NULL, 17.570692, -3.996166),
(135, 'MT', 'Malta', NULL, 35.937496, 14.375416),
(136, 'MH', 'Marshall Islands', NULL, 7.131474, 171.184479),
(137, 'MQ', 'Martinique', NULL, 14.641528, -61.024174),
(138, 'MR', 'Mauritania', NULL, 21.007891, -10.940835),
(139, 'MU', 'Mauritius', NULL, -20.348404, 57.552151),
(140, 'YT', 'Mayotte', NULL, -12.827500, 45.166245),
(141, 'MX', 'Mexico', NULL, 23.634501, -102.552788),
(142, 'FM', 'Micronesia, Federated States of', NULL, 7.425554, 150.550812),
(143, 'MD', 'Moldova, Republic of', NULL, 47.411633, 28.369884),
(144, 'MC', 'Monaco', NULL, 43.738419, 7.424616),
(145, 'MN', 'Mongolia', NULL, 46.862495, 103.846657),
(146, 'ME', 'Montenegro', NULL, 42.708679, 19.374390),
(147, 'MS', 'Montserrat', NULL, 16.742498, -62.187366),
(148, 'MA', 'Morocco', NULL, 31.791702, -7.092620),
(149, 'MZ', 'Mozambique', NULL, -18.665695, 35.529564),
(150, 'MM', 'Myanmar', NULL, 21.916222, 95.955971),
(151, 'NA', 'Namibia', NULL, -22.957640, 18.490410),
(152, 'NR', 'Nauru', NULL, -0.522778, 166.931503),
(153, 'NP', 'Nepal', NULL, 28.394857, 84.124008),
(154, 'NL', 'Netherlands', NULL, 52.132633, 5.291266),
(155, 'AN', 'Netherlands Antilles', NULL, 52.376354, 4.924567),
(156, 'NC', 'New Caledonia', NULL, -20.904305, 165.618042),
(157, 'NZ', 'New Zealand', NULL, -40.900558, 174.885971),
(158, 'NI', 'Nicaragua', NULL, 12.865416, -85.207230),
(159, 'NE', 'Niger', NULL, 17.607788, 8.081666),
(160, 'NG', 'Nigeria', NULL, 9.081999, 8.675277),
(161, 'NU', 'Niue', NULL, -19.054445, -169.867233),
(162, 'NF', 'Norfolk Island', NULL, -29.040834, 167.954712),
(163, 'MP', 'Northern Mariana Islands', NULL, 15.097900, 145.673904),
(164, 'NO', 'Norway', NULL, 60.472023, 8.468946),
(165, 'OM', 'Oman', NULL, 21.473534, 55.975414),
(166, 'PK', 'Pakistan', NULL, 30.375320, 69.345116),
(167, 'PW', 'Palau', NULL, 7.514980, 134.582520),
(168, 'PS', 'Palestine', NULL, 31.952162, 35.233154),
(169, 'PA', 'Panama', NULL, 8.537981, -80.782127),
(170, 'PG', 'Papua New Guinea', NULL, -6.314993, 143.955551),
(171, 'PY', 'Paraguay', NULL, -23.442503, -58.443832),
(172, 'PE', 'Peru', NULL, -9.189967, -75.015152),
(173, 'PH', 'Philippines', NULL, 12.879721, 121.774017),
(174, 'PN', 'Pitcairn', NULL, -24.376755, -128.324234),
(175, 'PL', 'Poland', NULL, 51.919437, 19.145136),
(176, 'PT', 'Portugal', NULL, 39.399872, -8.224454),
(177, 'PR', 'Puerto Rico', NULL, 18.220833, -66.590149),
(178, 'QA', 'Qatar', NULL, 25.354826, 51.183884),
(179, 'RE', 'Reunion', NULL, -21.115141, 55.536385),
(180, 'RO', 'Romania', NULL, 45.943161, 24.966761),
(181, 'RU', 'Russian Federation', 'Russia', 61.524010, 105.318756),
(182, 'RW', 'Rwanda', NULL, -1.940278, 29.873888),
(183, 'BL', 'Saint Barthélemy', NULL, 17.900000, -62.833332),
(184, 'SH', 'Saint Helena', NULL, -15.965010, -5.708924),
(185, 'KN', 'Saint Kitts and Nevis', NULL, 17.357822, -62.782997),
(186, 'LC', 'Saint Lucia', NULL, 13.909444, -60.978893),
(187, 'MF', 'Saint Martin', NULL, 18.070829, -63.050079),
(188, 'PM', 'Saint Pierre and Miquelon', NULL, 46.885201, -56.315899),
(189, 'VC', 'Saint Vincent and the Grenadines', NULL, 12.984305, -61.287228),
(190, 'WS', 'Samoa', NULL, -13.759029, -172.104630),
(191, 'SM', 'San Marino', NULL, 43.942360, 12.457777),
(192, 'ST', 'Sao Tome and Principe', NULL, 0.186360, 6.613081),
(193, 'SA', 'Saudi Arabia', NULL, 23.885942, 45.079163),
(194, 'SN', 'Senegal', NULL, 14.497401, -14.452362),
(195, 'RS', 'Serbia', NULL, 44.016521, 21.005859),
(196, 'SC', 'Seychelles', NULL, -4.679574, 55.491978),
(197, 'SL', 'Sierra Leone', NULL, 8.460555, -11.779889),
(198, 'SG', 'Singapore', NULL, 1.352083, 103.819839),
(199, 'SK', 'Slovakia', NULL, 48.669025, 19.699024),
(200, 'SI', 'Slovenia', NULL, 46.151241, 14.995463),
(201, 'SB', 'Solomon Islands', NULL, -9.645710, 160.156189),
(202, 'SO', 'Somalia', NULL, 5.152149, 46.199615),
(203, 'ZA', 'South Africa', NULL, -30.559483, 22.937506),
(204, 'GS', 'South Georgia and the South Sandwich Islands', NULL, -54.429581, -36.587910),
(205, 'ES', 'Spain', NULL, 40.463669, -3.749220),
(206, 'LK', 'Sri Lanka', NULL, 7.873054, 80.771797),
(207, 'SD', 'Sudan', NULL, 12.862807, 30.217636),
(208, 'SR', 'Suriname', NULL, 3.919305, -56.027782),
(209, 'SJ', 'Svalbard and Jan Mayen', NULL, 77.553604, 23.670273),
(210, 'SZ', 'Swaziland', NULL, -26.522503, 31.465866),
(211, 'SE', 'Sweden', NULL, 60.128162, 18.643501),
(212, 'CH', 'Switzerland', NULL, 46.818188, 8.227512),
(213, 'SY', 'Syrian Arab Republic', NULL, 34.802074, 38.996815),
(214, 'TW', 'Taiwan, Province Of China', NULL, 22.615801, 120.712006),
(215, 'TJ', 'Tajikistan', NULL, 38.861034, 71.276093),
(216, 'TZ', 'Tanzania, United Republic of', NULL, 40.756699, -73.966461),
(217, 'TH', 'Thailand', NULL, 15.870032, 100.992538),
(218, 'TL', 'Timor-Leste', NULL, -8.874217, 125.727539),
(219, 'TG', 'Togo', NULL, 8.619543, 0.824782),
(220, 'TK', 'Tokelau', NULL, -9.200200, -171.848404),
(221, 'TO', 'Tonga', NULL, -21.178986, -175.198242),
(222, 'TT', 'Trinidad and Tobago', NULL, 10.691803, -61.222504),
(223, 'TN', 'Tunisia', NULL, 33.886917, 9.537499),
(224, 'TR', 'Turkey', NULL, 38.963745, 35.243320),
(225, 'TM', 'Turkmenistan', NULL, 38.969719, 59.556278),
(226, 'TC', 'Turks and Caicos Islands', NULL, 21.694025, -71.797928),
(227, 'TV', 'Tuvalu', NULL, -7.109535, 177.649323),
(228, 'UG', 'Uganda', NULL, 1.373333, 32.290276),
(229, 'UA', 'Ukraine', NULL, 48.379433, 31.165581),
(230, 'AE', 'United Arab Emirates', 'uae', 23.424076, 53.847816),
(231, 'GB', 'United Kingdom', 'uk', 55.378052, -3.435973),
(232, 'US', 'United States', 'united states of america, usa,', 37.090240, -95.712891),
(233, 'UM', 'United States Minor Outlying Islands', NULL, 19.282318, 166.647049),
(234, 'UY', 'Uruguay', NULL, -32.522778, -55.765835),
(235, 'UZ', 'Uzbekistan', NULL, 41.377491, 64.585258),
(236, 'VU', 'Vanuatu', NULL, -15.376706, 166.959152),
(237, 'VE', 'Venezuela', NULL, 6.423750, -66.589729),
(238, 'VN', 'Viet Nam', NULL, 14.058324, 108.277199),
(239, 'VG', 'Virgin Islands, British', NULL, 18.420694, -64.639969),
(240, 'VI', 'Virgin Islands, U.S.', NULL, 18.335766, -64.896332),
(241, 'WF', 'Wallis And Futuna', NULL, -14.293800, -178.116501),
(242, 'EH', 'Western Sahara', NULL, 24.215527, -12.885834),
(243, 'YE', 'Yemen', NULL, 15.552727, 48.516388),
(244, 'ZM', 'Zambia', NULL, -13.133897, 27.849333),
(245, 'ZW', 'Zimbabwe', NULL, -19.015438, 29.154858);

-- --------------------------------------------------------

--
-- Table structure for table `hts_currency`
--

CREATE TABLE `hts_currency` (
  `id` int(11) NOT NULL,
  `countrycode` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `currencycode` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `currencysymbol` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `countryname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `currencyname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `price` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `defaultcurrency` int(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_currency`
--

INSERT INTO `hts_currency` (`id`, `countrycode`, `currencycode`, `currencysymbol`, `countryname`, `currencyname`, `price`, `status`, `defaultcurrency`, `cdate`) VALUES
(1, 'US', 'USD', '$', 'United States', 'U.S. Dollar', '1.000000', NULL, 1, NULL),
(2, 'FR', 'EUR', '€', 'France', 'Euro', '0.889519', NULL, NULL, NULL),
(3, 'GB', 'GBP', '£', 'United Kingdom', 'Pound Sterling', '0.768258', NULL, NULL, NULL),
(4, 'MX', 'MXN', 'Mex$', 'Mexico', 'Mexican Peso', '19.467376', NULL, NULL, NULL),
(5, 'RU', 'RUB', 'руб', 'Russian Federation', 'Russian Ruble', '66.038627', NULL, NULL, NULL),
(6, 'AU', 'AUD', '$', 'Australia', 'Australian Dollar', '1.415960', NULL, NULL, NULL),
(7, 'SG', 'SGD', 'S$', 'Singapore', 'Singapore Dollar', '1.355982', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hts_help`
--

CREATE TABLE `hts_help` (
  `id` int(11) NOT NULL,
  `topicid` int(50) NOT NULL,
  `name` mediumtext CHARACTER SET utf8,
  `maincontent` text CHARACTER SET utf8,
  `subcontent` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_help`
--

INSERT INTO `hts_help` (`id`, `topicid`, `name`, `maincontent`, `subcontent`) VALUES
(1, 1, 'Help', '<p><strong>Help</strong></p>\r\n', '<p>This is your Dashboard, the place to manage your rental, check messages in your Inbox, respond to Reservation Requests, view upcoming Trip Information, and much more!</p>\r\n'),
(2, 1, 'Policies', '<h2>Cancellation policy</h2>\r\n', '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>AirFinch allows hosts to choose among standardized <a href="https://www.airbnb.com/home/cancellation_policies">cancellation policies</a> (Super strict, Strict, Liberal, Moderate, Long Term and Flexible ) that we enforce to protect both hosts and guests. A host&#39;s cancellation policy can be found in the Prices section of their listing page. Guests must agree to the host&#39;s cancellation policy when they make a reservation.&nbsp;</p>\r\n</div>\r\n\r\n<p>Each listing and reservation on our site will clearly state the cancellation policy. Guests may cancel and review any penalties by viewing their travel plans and then clicking &#39;Cancel&#39; on the appropriate reservation.</p>\r\n\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n'),
(3, 1, 'Reservation', '<h2>Reservation</h2>\r\n', '<div>\r\n<div>\r\n<div>\r\n<p>Your payment information is collected when you submit a reservation request. Once the host accepts your request, or if you book a reservation with <a href="https://www.airbnb.com/help/article/187" target="_blank">Instant Book</a>, your payment method will be charged for the entire amount at that time.</p>\r\n\r\n<p>Whether the reservation is two days or two months away, we hold the payment until 24 hours after check-in before giving it to the host. This hold gives both parties time to make sure that everything is as expected.</p>\r\n</div>\r\n\r\n<div>&nbsp;</div>\r\n&nbsp;\r\n\r\n<div>\r\n<h4>Long term reservations</h4>\r\n\r\n<p>If you book a reservation for 28 nights or more, you&rsquo;ll be charged a first month down payment when the reservation is confirmed. Then, the rest of the nights will be charged on a monthly basis.</p>\r\n\r\n<h4>Security deposits</h4>\r\n\r\n<p>If your listing requires a security deposit, you won&rsquo;t be charged unless the host files a successful claim within 48 hours of your checkout. &nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n'),
(4, 1, 'Contact host', '<h2>How do I contact a host ?</h2>', '<div>\n<div>\n<div>\n<p>If you want to contact a host before booking a reservation or after a trip, send them a message on AirFinch.</p>\n\n<h4>Before booking a reservation</h4>\n\n<p>If you want to find out more about a listing or host before booking a reservation, you can message the host on AirFinch. Make sure to review the listing page (for example, reviews and amenities) to clarify anything you need from the host.</p>\n\n<p>To send a message:</p>\n\n<ol>\n <li>On AirFinch.com, go to the listing for the host you want to contact.</li>\n <li>Click <strong>Contact Host</strong> on the listing page.</li>\n <li>Enter the dates and number of guests for your trip. You can adjust this information before booking.</li>\n  <li>Write your message and click <strong>Send Message</strong>.</li>\n</ol>\n\n<p>For your safety and privacy, you can&rsquo;t call or email hosts before your reservation is accepted. Learn more about why it&rsquo;s good to keep <a href="https://www.airbnb.com/help/question/209" target="_blank">communication and transactions on AirFinch</a>.</p>\n</div>\nOnce a trip is confirmed\n\n<div>\n<p>If you have an accepted reservation, you can call or email the host, or message them on the site to communicate about your trip.</p>\n\n<p>You can find the host&rsquo;s email and phone number in the <a href="https://www.airbnb.com/inbox" target="_blank">message thread</a> for your trip, where you can also send the host a message.</p>\n\n<h4>After a trip</h4>\n\n<p>After a trip, you can send a message to your host in your <a href="https://www.airbnb.com/inbox" target="_blank">Inbox</a> if you have anything you need to follow up with them about.</p>\n\n<p>If you have any issues that you need to resolve, you can work through payment issues in the <a href="https://www.airbnb.com/help/article/767" target="_blank">Resolution Center</a> on the site.</p>\n</div>\n</div>\n</div>\n');

-- --------------------------------------------------------

--
-- Table structure for table `hts_helptopic`
--

CREATE TABLE `hts_helptopic` (
  `id` int(11) NOT NULL,
  `topic` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_helptopic`
--

INSERT INTO `hts_helptopic` (`id`, `topic`) VALUES
(1, 'Popular Questions');

-- --------------------------------------------------------

--
-- Table structure for table `hts_homecountries`
--

CREATE TABLE `hts_homecountries` (
  `id` int(11) NOT NULL,
  `countryid` int(11) DEFAULT NULL,
  `imagename` varchar(45) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hts_homecountries`
--

INSERT INTO `hts_homecountries` (`id`, `countryid`, `imagename`, `latitude`, `longitude`) VALUES
(1, 232, 'country_1552313349.jpg', 37.090240, -95.712891),
(2, 100, 'country_1552369466.jpg', 20.593683, 78.962883),
(3, 13, 'country_1552369102.jpg', -25.274399, 133.775131),
(4, 212, 'country_1552369135.jpg', 46.818188, 8.227512),
(5, 231, 'country_1552369161.jpg', 55.378052, -3.435973),
(6, 107, 'country_1552369718.jpg', 41.871941, 12.567380),
(7, 198, 'country_1552369873.jpg', 1.352083, 103.819839),
(8, 139, 'country_1552370058.jpg', -20.348404, 57.552151),
(9, 217, 'country_1552370397.png', 15.870032, 100.992538),
(10, 55, 'country_1552370935.jpg', 21.521757, -77.781166),
(11, 230, 'country_1552477911.jpg', 23.424076, 53.847816);

-- --------------------------------------------------------

--
-- Table structure for table `hts_homepagesettings`
--

CREATE TABLE `hts_homepagesettings` (
  `id` int(1) NOT NULL,
  `banner` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `bannerforapp` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `bannertitle` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bannerdesc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `bannertextcolor` varchar(10) NOT NULL,
  `placescount` varchar(20) DEFAULT NULL,
  `placesdesc` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `customerscount` varchar(20) DEFAULT NULL,
  `customersdesc` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `supporttime` varchar(5) DEFAULT NULL,
  `supportdesc` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `main_termsandconditions` text CHARACTER SET utf8,
  `sub_termsandconditions` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_homepagesettings`
--

INSERT INTO `hts_homepagesettings` (`id`, `banner`, `bannerforapp`, `bannertitle`, `bannerdesc`, `bannertextcolor`, `placescount`, `placesdesc`, `customerscount`, `customersdesc`, `supporttime`, `supportdesc`, `main_termsandconditions`, `sub_termsandconditions`) VALUES
(1, '', '', 'Explore your dream stay', 'Rent Your Convenient Stays From The Local Host Available In 190+ Countries. ', '', '999500', 'Perfect for seekers, artistic types and intellectuals as we are in the heart of the arty/academic/spiritual community of Cape Town.', '1348500', 'One large, lovely room with a double and single bed perfect for singles, two friends, couples, and couples with one child.', '24/7', 'If you need help while traveling or hosting, contact us at our toll free number: 1800 2504 4520 1255', '<h2>Terms of Service</h2>\r\n\r\n<h4>In General</h4>\r\n\r\n<p>Airfinch (&quot;https://www.airfinchscript.com&quot;) owns and operate this Website. This document governs your relationship with https://www.airfinchscript.com (&quot;Website&quot;). Access to and use of this Website and the products and services available through this Website (collectively, the &quot;Services&quot;) are subject to the following terms, conditions and notices (the &quot;Terms of Service&quot;). By using the Services, you are agreeing to all of the Terms of Service, as may be updated by us from time to time. You should check this page regularly to take notice of any changes we may have made to the Terms of Service.<br />\r\nAccess to this Website is permitted on a temporary basis, and we reserve the right to withdraw or amend the Services without notice. We will not be liable if for any reason this Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts or all of this Website. This Website may contain links to other websites (the &quot;Linked Sites&quot;), which are not operated by https://www.airfinchscript.com. https://www.airfinchscript.com has no control over the Linked Sites and accepts no responsibility for them or for any loss or damage that may arise from your use of them. Your use of the Linked Sites will be subject to the terms of use and service contained within each such site.</p>\r\n\r\n<h4>Privacy Policy</h4>\r\n\r\n<p>Our privacy policy, which sets out how we will use your information, can be found at https://www.airfinchscript.com. By using this Website, you consent to the processing described therein and warrant that all data provided by you is accurate.</p>\r\n\r\n<h4>Prohibitions</h4>\r\n\r\n<p>You must not misuse this Website. You will not: commit or encourage a criminal offense; transmit or distribute a virus, trojan, worm, logic bomb or any other material which is malicious, technologically harmful, in breach of confidence or in any way offensive or obscene; hack into any aspect of the Service; corrupt data; cause annoyance to other users; infringe upon the rights of any other person&#39;s proprietary rights; send any unsolicited advertising or promotional material, commonly referred to as &quot;spam&quot;; or attempt to affect the performance or functionality of any computer facilities of or accessed through this Website. Breaching this provision would constitute a criminal offense and https://www.airfinchscript.com will report any such breach to the relevant law enforcement authorities and disclose your identity to them.<br />\r\nWe will not be liable for any loss or damage caused by a distributed denial-of-service attack, viruses or other technologically harmful material that may infect your computer equipment, computer programs, data or other proprietary material due to your use of this Website or to your downloading of any material posted on it, or on any website linked to it.</p>\r\n\r\n<h4>Intellectual Property, Software and Content</h4>\r\n\r\n<p>The intellectual property rights in all software and content (including photographic images) made available to you on or through this Website remains the property of https://www.airfinchscript.com or its licensors and are protected by copyright laws and treaties around the world. All such rights are reserved by https://www.airfinchscript.com and its licensors. You may store, print and display the content supplied solely for your own personal use. You are not permitted to publish, manipulate, distribute or otherwise reproduce, in any format, any of the content or copies of the content supplied to you or which appears on this Website nor may you use any such content in connection with any business or commercial enterprise.</p>\r\n\r\n<h4>Terms of Sale</h4>\r\n\r\n<p>By placing an order you are offering to purchase a product on and subject to the following terms and conditions. All orders are subject to availability and confirmation of the order price. Dispatch times may vary according to availability and subject to any delays resulting from postal delays or force majeure for which we will not be responsible. In order to contract with https://www.airfinchscript.com you must be over 18 years of age and possess a valid credit or debit card issued by a bank acceptable to us. https://www.airfinchscript.com retains the right to refuse any request made by you. If your order is accepted we will inform you by email and we will confirm the identity of the party which you have contracted with. This will usually be https://www.airfinchscript.com or may in some cases be a third party. Where a contract is made with a third party https://www.airfinchscript.com is not acting as either agent or principal and the contract is made between yourself and that third party and will be subject to the terms of sale which they supply you. When placing an order you undertake that all details you provide to us are true and accurate, that you are an authorized user of the credit or debit card used to place your order and that there are sufficient funds to cover the cost of the goods. The cost of foreign products and services may fluctuate. All prices advertised are subject to such changes. (a) Our Contract When you place an order, you will receive an acknowledgement e-mail confirming receipt of your order: this email will only be an acknowledgement and will not constitute acceptance of your order. A contract between us will not be formed until we send you confirmation by e-mail that the goods which you ordered have been dispatched to you. Only those goods listed in the confirmation e-mail sent at the time of dispatch will be included in the contract formed. (b) Pricing and Availability Whilst we try and ensure that all details, descriptions and prices which appear on this Website are accurate, errors may occur. If we discover an error in the price of any goods which you have ordered we will inform you of this as soon as possible and give you the option of reconfirming your order at the correct price or cancelling it. If we are unable to contact you we will treat the order as cancelled. If you cancel and you have already paid for the goods, you will receive a full refund. Delivery costs will be charged in addition; such additional charges are clearly displayed where applicable and included in the &#39;Total Cost&#39;. (c) Payment Upon receiving your order we carry out a standard authorization check on your payment card to ensure there are sufficient funds to fulfil the transaction. Your card will be debited upon authorisation being received. The monies received upon the debiting of your card shall be treated as a deposit against the value of the goods you wish to purchase. Once the goods have been despatched and you have been sent a confirmation email the monies paid as a deposit shall be used as consideration for the value of goods you have purchased as listed in the confirmation email.</p>\r\n', '<h2>Terms of Service</h2>\r\n\r\n<h4>In General</h4>\r\n\r\n<p>Airfinch (&quot;https://www.airfinchscript.com&quot;) owns and operate this Website. This document governs your relationship with https://www.airfinchscript.com (&quot;Website&quot;). Access to and use of this Website and the products and services available through this Website (collectively, the &quot;Services&quot;) are subject to the following terms, conditions and notices (the &quot;Terms of Service&quot;). By using the Services, you are agreeing to all of the Terms of Service, as may be updated by us from time to time. You should check this page regularly to take notice of any changes we may have made to the Terms of Service.<br />\r\nAccess to this Website is permitted on a temporary basis, and we reserve the right to withdraw or amend the Services without notice. We will not be liable if for any reason this Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts or all of this Website. This Website may contain links to other websites (the &quot;Linked Sites&quot;), which are not operated by https://www.airfinchscript.com. https://www.airfinchscript.com has no control over the Linked Sites and accepts no responsibility for them or for any loss or damage that may arise from your use of them. Your use of the Linked Sites will be subject to the terms of use and service contained within each such site.</p>\r\n\r\n<h4>Privacy Policy</h4>\r\n\r\n<p>Our privacy policy, which sets out how we will use your information, can be found at https://www.airfinchscript.com. By using this Website, you consent to the processing described therein and warrant that all data provided by you is accurate.</p>\r\n\r\n<h4>Prohibitions</h4>\r\n\r\n<p>You must not misuse this Website. You will not: commit or encourage a criminal offense; transmit or distribute a virus, trojan, worm, logic bomb or any other material which is malicious, technologically harmful, in breach of confidence or in any way offensive or obscene; hack into any aspect of the Service; corrupt data; cause annoyance to other users; infringe upon the rights of any other person&#39;s proprietary rights; send any unsolicited advertising or promotional material, commonly referred to as &quot;spam&quot;; or attempt to affect the performance or functionality of any computer facilities of or accessed through this Website. Breaching this provision would constitute a criminal offense and https://www.airfinchscript.com will report any such breach to the relevant law enforcement authorities and disclose your identity to them.<br />\r\nWe will not be liable for any loss or damage caused by a distributed denial-of-service attack, viruses or other technologically harmful material that may infect your computer equipment, computer programs, data or other proprietary material due to your use of this Website or to your downloading of any material posted on it, or on any website linked to it.</p>\r\n\r\n<h4>Intellectual Property, Software and Content</h4>\r\n\r\n<p>The intellectual property rights in all software and content (including photographic images) made available to you on or through this Website remains the property of https://www.airfinchscript.com or its licensors and are protected by copyright laws and treaties around the world. All such rights are reserved by https://www.airfinchscript.com and its licensors. You may store, print and display the content supplied solely for your own personal use. You are not permitted to publish, manipulate, distribute or otherwise reproduce, in any format, any of the content or copies of the content supplied to you or which appears on this Website nor may you use any such content in connection with any business or commercial enterprise.</p>\r\n\r\n<h4>Terms of Sale</h4>\r\n\r\n<p>By placing an order you are offering to purchase a product on and subject to the following terms and conditions. All orders are subject to availability and confirmation of the order price. Dispatch times may vary according to availability and subject to any delays resulting from postal delays or force majeure for which we will not be responsible. In order to contract with https://www.airfinchscript.com you must be over 18 years of age and possess a valid credit or debit card issued by a bank acceptable to us. https://www.airfinchscript.com retains the right to refuse any request made by you. If your order is accepted we will inform you by email and we will confirm the identity of the party which you have contracted with. This will usually be https://www.airfinchscript.com or may in some cases be a third party. Where a contract is made with a third party https://www.airfinchscript.com is not acting as either agent or principal and the contract is made between yourself and that third party and will be subject to the terms of sale which they supply you. When placing an order you undertake that all details you provide to us are true and accurate, that you are an authorized user of the credit or debit card used to place your order and that there are sufficient funds to cover the cost of the goods. The cost of foreign products and services may fluctuate. All prices advertised are subject to such changes. (a) Our Contract When you place an order, you will receive an acknowledgement e-mail confirming receipt of your order: this email will only be an acknowledgement and will not constitute acceptance of your order. A contract between us will not be formed until we send you confirmation by e-mail that the goods which you ordered have been dispatched to you. Only those goods listed in the confirmation e-mail sent at the time of dispatch will be included in the contract formed. (b) Pricing and Availability Whilst we try and ensure that all details, descriptions and prices which appear on this Website are accurate, errors may occur. If we discover an error in the price of any goods which you have ordered we will inform you of this as soon as possible and give you the option of reconfirming your order at the correct price or cancelling it. If we are unable to contact you we will treat the order as cancelled. If you cancel and you have already paid for the goods, you will receive a full refund. Delivery costs will be charged in addition; such additional charges are clearly displayed where applicable and included in the &#39;Total Cost&#39;. (c) Payment Upon receiving your order we carry out a standard authorization check on your payment card to ensure there are sufficient funds to fulfil the transaction. Your card will be debited upon authorisation being received. The monies received upon the debiting of your card shall be treated as a deposit against the value of the goods you wish to purchase. Once the goods have been despatched and you have been sent a confirmation email the monies paid as a deposit shall be used as consideration for the value of goods you have purchased as listed in the confirmation email.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `hts_hometype`
--

CREATE TABLE `hts_hometype` (
  `id` int(11) NOT NULL,
  `hometype` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `priority` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_hometype`
--

INSERT INTO `hts_hometype` (`id`, `hometype`, `priority`) VALUES
(1, 'House', NULL),
(2, 'Apartment', NULL),
(3, 'Bed and breakfast', NULL),
(4, 'Boutique hotel', NULL),
(5, 'Bungalow', NULL),
(6, 'Cabin', NULL),
(7, 'Chalet', NULL),
(8, 'Cottage', NULL),
(9, 'Guest suite', NULL),
(10, 'Guesthouse', NULL),
(11, 'Hostel', NULL),
(12, 'Hotel', NULL),
(13, 'Loft', NULL),
(14, 'Resort', NULL),
(15, 'Townhouse', NULL),
(16, 'Villa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hts_inquiry`
--

CREATE TABLE `hts_inquiry` (
  `id` int(11) NOT NULL,
  `senderid` int(11) DEFAULT NULL,
  `receiverid` int(11) DEFAULT NULL,
  `lastmessageid` int(11) DEFAULT NULL,
  `listingid` int(11) DEFAULT NULL,
  `type` enum('inquiry','booked','','') DEFAULT 'inquiry',
  `checkin` datetime DEFAULT '0000-00-00 00:00:00',
  `checkout` datetime DEFAULT '0000-00-00 00:00:00',
  `guest` int(2) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_inquiry`
--

INSERT INTO `hts_inquiry` (`id`, `senderid`, `receiverid`, `lastmessageid`, `listingid`, `type`, `checkin`, `checkout`, `guest`, `cdate`, `mdate`) VALUES
(1, 2, 3, 2, 21, 'inquiry', '2019-05-01 00:00:00', '2019-05-05 00:00:00', 2, 1552473658, 1552473658),
(2, 2, 3, 3, 21, 'booked', '2019-07-10 00:00:00', '2019-07-15 00:00:00', 1, 1552473839, 1552473839),
(3, 3, 2, 4, 3, 'booked', '2019-03-20 07:00:00', '2019-03-20 12:00:00', 2, 1552474189, 1552474189),
(4, 2, 3, 5, 24, 'booked', '2019-07-01 00:00:00', '2019-07-05 00:00:00', 1, 1552474381, 1552474381),
(5, 3, 2, 6, 1, 'booked', '2019-03-17 00:00:00', '2019-03-18 00:00:00', 1, 1552474712, 1552474712),
(6, 2, 3, 7, 16, 'booked', '2019-04-18 00:00:00', '2019-04-20 00:00:00', 1, 1552474888, 1552474888),
(7, 2, 4, 8, 31, 'booked', '2019-03-11 00:00:00', '2019-03-13 00:00:00', 1, 1552223730, 1552223730),
(8, 4, 2, 10, 3, 'inquiry', '2019-03-24 13:00:00', '2019-03-24 18:00:00', 1, 1552483550, 1552483550),
(9, 3, 2, 11, 32, 'booked', '2019-03-09 15:00:00', '2019-03-09 22:00:00', 1, 1551447535, 1551447535),
(10, 3, 2, 12, 12, 'booked', '2019-11-21 12:00:00', '2019-11-21 18:00:00', 3, 1552542068, 1552542068),
(11, 3, 2, 13, 11, 'booked', '2019-12-18 00:00:00', '2019-12-23 00:00:00', 1, 1552542433, 1552542433),
(12, 3, 2, 14, 13, 'booked', '2019-03-12 00:00:00', '2019-03-13 00:00:00', 5, 1552197960, 1552543560),
(13, 3, 2, 15, 3, 'booked', '2019-03-03 19:00:00', '2019-03-03 23:00:00', 1, 1551076059, 1551076059),
(14, 3, 2, 16, 8, 'booked', '2019-07-11 00:00:00', '2019-07-14 00:00:00', 1, 1552557043, 1552557043);

-- --------------------------------------------------------

--
-- Table structure for table `hts_invoices`
--

CREATE TABLE `hts_invoices` (
  `id` int(11) NOT NULL,
  `orderid` int(11) DEFAULT NULL,
  `invoiceno` varchar(30) DEFAULT NULL,
  `invoicedate` int(11) DEFAULT NULL,
  `invoicestatus` varchar(15) DEFAULT NULL,
  `paymentmethod` varchar(20) DEFAULT NULL,
  `stripe_transactionid` varchar(150) DEFAULT NULL,
  `paypaltransactionid` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_invoices`
--

INSERT INTO `hts_invoices` (`id`, `orderid`, `invoiceno`, `invoicedate`, `invoicestatus`, `paymentmethod`, `stripe_transactionid`, `paypaltransactionid`) VALUES
(1, 1, 'INV2', 1552473839, NULL, 'Stripe', 'ch_1EDUZ0JBMSMXMqdDpx7jImCg', ''),
(2, 2, 'INV3', 1552474189, NULL, 'Stripe', 'ch_1EDUefJBMSMXMqdDKF4J4Ig8', ''),
(3, 3, 'INV2', 1552474381, NULL, 'Stripe', 'ch_1EDUhkJBMSMXMqdDLWNhbuGK', ''),
(4, 4, 'INV3', 1552474712, NULL, 'Stripe', 'ch_1EDUn5JBMSMXMqdDZFAAYNK7', ''),
(5, 5, 'INV2', 1552474888, NULL, 'Stripe', 'ch_1EDUpvJBMSMXMqdDwOyXyybk', ''),
(6, 6, 'INV2', 1552482930, NULL, 'Stripe', 'ch_1EDWveJBMSMXMqdDoKHeLReO', ''),
(7, 7, 'INV3', 1552484335, NULL, 'Stripe', 'ch_1EDXIJJBMSMXMqdDxF6aWtQh', ''),
(8, 8, 'INV3', 1552542068, NULL, 'Stripe', 'ch_1EDmJUJBMSMXMqdDyXTuzZ9B', ''),
(9, 9, 'INV3', 1552542433, NULL, 'Stripe', 'ch_1EDmPNJBMSMXMqdDZcAWcXjk', ''),
(10, 10, 'INV3', 1552543560, NULL, 'Stripe', 'ch_1EDmhYJBMSMXMqdDSUOErrMm', ''),
(11, 11, 'INV3', 1552544859, NULL, 'Stripe', 'ch_1EDn2UJBMSMXMqdDOFty41M8', ''),
(12, 12, 'INV3', 1552557043, NULL, 'Stripe', 'ch_1EDqD0JBMSMXMqdDyKYc3MXb', '');

-- --------------------------------------------------------

--
-- Table structure for table `hts_languages`
--

CREATE TABLE `hts_languages` (
  `id` int(11) NOT NULL,
  `languagename` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_languages`
--

INSERT INTO `hts_languages` (`id`, `languagename`) VALUES
(1, 'English (UK)'),
(2, 'French'),
(3, 'Spanish'),
(4, 'Chinese'),
(5, 'Bahasa Malay'),
(6, 'Dutch'),
(7, 'Thai'),
(8, 'Urdu'),
(9, 'Bengali'),
(10, 'Arabic');

-- --------------------------------------------------------

--
-- Table structure for table `hts_listing`
--

CREATE TABLE `hts_listing` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `hometype` int(3) DEFAULT NULL,
  `roomtype` int(3) DEFAULT NULL,
  `accommodates` int(3) DEFAULT NULL,
  `bedrooms` int(3) DEFAULT NULL,
  `beds` int(3) DEFAULT NULL,
  `bathrooms` int(3) DEFAULT NULL,
  `youtubeurl` varchar(255) NOT NULL,
  `city` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `listingname` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `country` int(3) DEFAULT NULL,
  `timezone` int(5) DEFAULT NULL,
  `streetaddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `accesscode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `commonamenities` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `additionalamenities` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `specialfeatures` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `featuredlist` enum('0','1') NOT NULL,
  `featuredate` int(11) DEFAULT NULL,
  `safetychecklist` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `fireextinguisher` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `firealarm` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `gasshutoffvalve` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `emergencyexitinstruction` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `medicalno` bigint(20) DEFAULT NULL,
  `fireno` bigint(20) DEFAULT NULL,
  `policeno` bigint(20) DEFAULT NULL,
  `nightlyprice` varchar(10) DEFAULT NULL,
  `hourlyprice` varchar(10) DEFAULT NULL,
  `cleaningfees` int(11) NOT NULL,
  `servicefees` int(11) NOT NULL,
  `accomadtionfees` int(11) NOT NULL,
  `administrative_fees` int(11) NOT NULL,
  `securitydeposit` varchar(10) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `booking` enum('perday','pernight','perhour') NOT NULL DEFAULT 'pernight',
  `bookingstyle` varchar(10) DEFAULT NULL,
  `whocanbook` varchar(10) DEFAULT NULL,
  `houserules` text CHARACTER SET utf8,
  `bookingavailability` varchar(10) DEFAULT NULL,
  `startdate` int(11) DEFAULT NULL,
  `enddate` int(11) DEFAULT NULL,
  `minstay` int(3) DEFAULT NULL,
  `maxstay` int(3) DEFAULT NULL,
  `advancenotice` int(1) DEFAULT NULL,
  `priceforextrapeople` varchar(10) DEFAULT NULL,
  `weeklydiscount` varchar(5) DEFAULT NULL,
  `weekendprice` enum('0','1') NOT NULL,
  `monthlydisocunt` varchar(5) DEFAULT NULL,
  `cancellation` varchar(10) DEFAULT NULL,
  `liststatus` int(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `normalprice` text,
  `specialprice` text,
  `blockedspecialprice` text,
  `splpricestatus` enum('0','1') NOT NULL,
  `pernight_availablity` text,
  `hourly_availablity` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_listing`
--

INSERT INTO `hts_listing` (`id`, `userid`, `hometype`, `roomtype`, `accommodates`, `bedrooms`, `beds`, `bathrooms`, `youtubeurl`, `city`, `listingname`, `description`, `country`, `timezone`, `streetaddress`, `accesscode`, `state`, `zipcode`, `latitude`, `longitude`, `commonamenities`, `additionalamenities`, `specialfeatures`, `featuredlist`, `featuredate`, `safetychecklist`, `fireextinguisher`, `firealarm`, `gasshutoffvalve`, `emergencyexitinstruction`, `medicalno`, `fireno`, `policeno`, `nightlyprice`, `hourlyprice`, `cleaningfees`, `servicefees`, `accomadtionfees`, `administrative_fees`, `securitydeposit`, `currency`, `booking`, `bookingstyle`, `whocanbook`, `houserules`, `bookingavailability`, `startdate`, `enddate`, `minstay`, `maxstay`, `advancenotice`, `priceforextrapeople`, `weeklydiscount`, `weekendprice`, `monthlydisocunt`, `cancellation`, `liststatus`, `cdate`, `normalprice`, `specialprice`, `blockedspecialprice`, `splpricestatus`, `pernight_availablity`, `hourly_availablity`) VALUES
(1, 2, 15, 1, 6, 2, 3, 3, 'https://www.youtube.com/watch?v=Vmo2V54pJGw', 'Denver', 'Urban Farmhouse at Denver', 'The Urban Farmhouse circa 1886 - meticulously converted in 2013. Situated adjacent to community garden. The updates afford you all the modern convenience you could ask for and charm you can only get from a building built in 1886. A true Charmer.\n\nThe space\n\nPrivately tucked next door to a community garden in Denver\'s oldest neighborhood. 1/2 block to light-rail and near to B-Cycle (public bikes). Walking distance to local craft breweries and restaurants on Welton and Larimer. Street parking. 2 Bedrooms/2 Bathrooms perfectly sleeps two couples (additional charge for additional guests). We have a pack-n-play and baby gates available upon request.\n\nIt is my home, but i will lock my personal items away and with the exception of a small portion of the closet the whole place is yours during your stay.\n\nGuest access\n\nKey-less access to the Townhouse with laundry facility. shared gas grill, Crossfit gym in garage (with classes evenings M-W-F) down the street, garden and outdoor covered lounge/dining space. I will send you the personalized codes for the gate and the front door 24 hours before arrival.\n\nInteraction with guests\n\nAs little or as much as you like. I am always happy to meet guests, answer any questions or provide recommendations. It is my home, so I will be out while you stay, however I can be easily reached if anything is needed.\n\nOther things to note\n\nFree cable and WIFI - laundry and bath products. We also supply coffee and tea, and light snacks. For security there is camera mounted under the awning near the front door. Denver Short Term License: 2016-CFN-0009990.\nLicense or registration number\n2016-CFN-0009990', 232, 97, 'Stout St', 'Building #488', 'Colorado', '80123', 39.750534, -104.987000, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '145', NULL, 5, 5, 0, 0, '25', 1, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 1, 5, NULL, NULL, NULL, '1', NULL, '1', 1, 1552384901, NULL, NULL, NULL, '0', '10:00*|*09:00', ''),
(2, 2, 2, 1, 4, 1, 2, 1, 'https://www.youtube.com/watch?v=lbeL792x8Mk', 'San Francisco', 'Grand and Cozy 1910\'s Studio', 'Come enjoy our large studio in San Francisco\'s charming and convenient Bernal Heights! You\'ll enjoy your own cozy and private lodging with a romantic gas fireplace, wood and stone floors and artistic decor. You will be close to world class views of San Francisco and it\'s beautiful bay. Bus lines are close by and and parking is very easy!\n\nThe space\n\nOur complete description follows this city generated notice:\n\nSAN FRANCISCO SHORT-TERM RESIDENTIAL RENTAL REGISTRATION NUMBER: STR-920. Possession of a San Francisco Short-Term Rental Registration Certificate certifies that the registration certificate holder has agreed to comply with the terms of the San Francisco Short-Term Residential Rental Ordinance (San Francisco Administrative Code 41A). This ordinance does not require an inspection of the unit by the City for potential Building, Housing, Fire, or other Code violations.\n\nTHIS BEAUTIFUL APARTMENT was once a corner store. It has been tastefully remodeled to make a very comfortable living space. It consists of one very large room with a sleeping area sectioned off by curtains. It also has an attractive bathroom and a closet. There are areas for sleeping, dining, cooking, working and relaxing. The kitchenette has a fridge, two burners, a microwave, toaster oven, coffee maker and filtered water on tap, as well as all the kitchenware and tableware you may need. The bed has a very comfortable queen size mattress. It\'s all quite romantic, but you can also sleep an additional two people on the comfortable fold down sofa. You\'ll have the use of wireless high speed cable internet and widescreen dish TV and dvd player. The apartment is completely separate from our living space so you\'ll have it all to yourself. It has a grand and gracious yet completely cozy feel.\n\nWe like to host visitors and we\'ll be happy to give you information and tips on request. You\'ll love our neighborhood where you\'ll find some of the city\'s sunniest weather, best affordable restaurants, great views and easy parking. Street parking is safe and generally available either right outside or within a block. The house is on a quiet residential street two blocks from Bernal Hill Park, which has spectacular views of the city and The Bay. Our electricity comes from solar panels on the roof! \n\nGuest access\n\nIt\'s a private apartment with a private entrance. It\'s all yours!\n\nInteraction with guests\n\nWe\'re available as needed, but we wait to be asked after our initial meeting.', 232, 81, 'Cortland Ave, Bernal Heights', 'Suite #1', 'California', '94110', 37.738892, -122.414696, NULL, NULL, NULL, '1', 1552401611, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '150', NULL, 10, 15, 0, 0, '200', 1, 'pernight', 'instant', NULL, 'No smoking inside the apartment.\nNo candles or open flames.\nNo loud music or partying, especially after 10:30 PM\nBe gentle with the wood furniture and softwood floors. Always use coasters for hot drinks. Definitely no spiky high heels inside.', 'onetime', 1552348800, 1609372800, 2, 8, NULL, NULL, NULL, '1', NULL, '2', 1, 1552385820, NULL, NULL, NULL, '0', '11:00*|*10:00', ''),
(3, 2, 8, 2, 2, 2, 4, 2, 'https://www.youtube.com/watch?v=_YHF7n16gm8', 'San Diego', 'South Mission Beach Zen-Like Home', 'This fully furnished second story South Mission bayside studio offers relaxed beach living. This studio sleeps 2 (Queen Bed), 2 Beach cruisers & 2 Boogie Boards are provided; private off street parking; steps to the bay and short stroll to the beach.\n\nGuest access\n\nGuests will have access to private off-street parking, two beach cruisers and two boogie boards. There is also a small patio with a grill.\n\nInteraction with guests\n\nVery limited interaction with guests other than initial booking communications.', 232, 53, 'Mission Point', 'South Mission Beach Home', 'California', '92109', 32.761715, -117.246147, NULL, NULL, NULL, '1', 1552401628, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '390', 20, 15, 0, 0, '200', 4, 'perhour', 'request', NULL, '', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '3', 1, 1552387237, NULL, NULL, NULL, '0', '', '07:00*|*12:00,13:00*|*18:00,19:00*|*23:00,'),
(4, 2, 5, 1, 6, 2, 5, 2, 'https://www.youtube.com/watch?v=v32XxeNikpY', 'Zorzino', 'Lussuoso. Vista incantevole', 'Apartment overlooking the new and luxurious lake in residence with pool open in summer from June 15 to September 15, tennis court, bowling alley and park (use included in the price). Extraordinary view. Property car park. 150 meters from the center of the medieval village of Riva di Solto. Three-roomed + bathroom + 2 terraces. Internet wi-fi: € 1.50 per day (Internet wi- fi: € 1.50 per day.\n\nThe space\n\nIn residence with swimming pool, tennis court, bowling alley and park (all for free use; the swimming pool can be used in the summer season from 15 June to 15 September, a wonderful new apartment consisting of living room with sofa bed, kitchen with oven and dishwasher , Double bedroom, bedroom with 2 single beds, bathroom with shower, 2 large terraces, 5 meters parking space.\nExceptional and unique view overlooking the lake. He is not afraid of comparisons. The residence is 150 meters from the center of the picturesque medieval village of Riva di Solto and is connected directly to the lake. From Riva di Solto you can climb the ferry to Montisola, the largest lakeside island in Europe with the presence of free beaches. A few kilometers away there is the Camonica Valley with ancient villages, ski resorts (Ponte di Legno - Tonale, Monte Campione, Borno, Boario thermal baths, prehistoric parks of rock engravings, UNESCO World Heritage Sites. Kilometers is the Franciacorta with its wines, its hills and the extraordinary landscape.\nThe cities of Brescia, Bergamo, Milan, Verona and Venice can be visited on a day by car.\nThe nearest airport is Bergamo Orio al Serio (about 40 km) Milan Linate (about 65 Km) Milan Malpensa (100 km).\nExit the motorway recommended Rovato Pontoglio Palazzolo Bergamo.\nNO SMOKING. NO SMOKING\nDO NOT ALLOW ANIMALS. NO PETS\nWI FI\n\nGuest access\n\nGuests can use the free swimming pool with solarium in the summer, tennis court and bowls all year round.\nNo smoking and no ban on animals\n\nInteraction with guests\n\nI will meet the guests and be available to meet their needs. I live 40 km away and I can reach Riva di Solto in 30 minutes.', 107, 353, 'via costa, zorzino', 'costa #H145', 'Lombardia', '00010', 45.781849, 10.045799, NULL, NULL, NULL, '1', 1552401613, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '120', 20, 20, 0, 0, '100', 2, 'perhour', 'instant', NULL, 'Non sono ammessi animali.\nNo pets.\nVietato fumare.\nNo smoking.\n\nKeep clean.', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '4', 1, 1552388194, NULL, NULL, NULL, '0', '', '06:00*|*10:00,11:00*|*15:00,15:00*|*23:00,'),
(5, 2, 4, 2, 4, 1, 2, 1, 'https://www.youtube.com/watch?v=p51xL4Rp7L8', 'Madrid', 'Private Studio in Sol, Madrid', 'We are offering a clean, well presented and recently refurbished double studio situated in the heart of Madrid, Spain.\nSol square is just 2 minutes walk away, Also the studio is within walking distance to all major attractions and museums.\n\nThe space\n\nThis antique apartment was built in 17th century. However, the studio is recently refurbished in modern style and very clean. Located on the third floor of the building, Elevator available and up to 4 people can stay.\n(Comfortable Queen sized bed and a sofa bed for two people)\n\nHas 2 large balconies.\n(Tempered glass windows for soundproofing)\n\nBathrooms include shampoo, shower gel, hand soap, hair dryer, toilet paper and Clean towels for face&shower.\n\nThere\'s electric cooktop, microwave and oven for cooking. Cutlery, crockery and glassware are available.\n\nElectric Kettle/Mocha pot\nWashing machine/Drying Reck\nIron/Ironing Board\nWi-fi\nAir conditioner/Electric heaters.\n\nIf you think there is something missing, please give us your feedback in order to improve our service.\n\nGuest access\n\nLocated in the center of Madrid.\nMost famous attractions and museums are within walking distance.\nIn the local area you will find everything you need for a great stay including bars, cafes, restaurants and supermarkets.\n\nSol: 2 min.\nPlaza Mayor: 6 min.\nGran via: 7 min.\nRoyal palace: 12 min.\nMuseo Thyssen: 12 min.\nMuseo del prado: 15 min.\nMuseo Reina Sofia: 15 min.\nStation Atocha: 17 min.', 107, 353, 'calle le da cruz', 'Plaza de santa ana', 'Comunidad de Madrid', '28017', 40.422367, -3.644582, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '95', NULL, 8, 5, 0, 0, '50', 2, 'pernight', 'instant', NULL, 'There are not so many rules. :)\n\nSmoking is prohibited inside the building.\nPets can not be together.\n\nPlease be considerate of the neighbors. In particular, please refrain from the late noise. (No Party)\n\nThe most important thing is to entertain.', 'onetime', 1552348800, 1580428800, 1, 10, NULL, NULL, NULL, '1', NULL, '5', 1, 1552389172, NULL, NULL, NULL, '0', '10:00*|*08:00', ''),
(6, 2, 4, 1, 2, 1, 1, 1, 'https://www.youtube.com/watch?v=9NpphSWpB30', 'Havana', 'Melia Marina Varadero Cuba', 'New apartment, located in the heart of Havana, only 5 minutes walking to Old Havana, Capitolio, nightclubs, the apartment consists of wifi, air conditioning, refrigerator, microwave, security cameras outside the apartment, ideal to rest and Enjoy your experience on the island\n\nlocated in San Rafael 363 between Manrique and San Nicholas, Havana center\n\nThe space\n\nthey can use everything in the apartment, they have drinks service in the apartment, wifi card service,\n\nGuest access\n\nlaundry service ,\n\nInteraction with guests\n\nDisponibles las 24 horas para ayudar al huésped ,soy el dueño y vivo solo a dos puertas del apartamento ,\n\nOther things to note\n\nthe apartment is very in the center of Havana, very close to everything', 55, 115, 'Neptuno', 'Apt #49', 'Havana', '36097', 23.137501, -82.370300, NULL, NULL, NULL, '1', 1552401625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '60', NULL, 5, 3, 0, 0, '15', 1, 'pernight', 'instant', NULL, 'No pets\nNo parties or events\nCheck-in time is flexible and check out by 8PM (night)\nSelf check-in with building staff\n\nNo se permite la entrada de cubanos que viven en cuba al apartamento\n\nCubans residing in Cuba are not allowed to enter.', 'always', NULL, NULL, 1, 3, NULL, NULL, NULL, '1', NULL, '6', 1, 1552390843, NULL, NULL, NULL, '0', '10:00*|*20:00', ''),
(7, 2, 3, 1, 5, 1, 2, 1, 'https://www.youtube.com/watch?v=3Pla7JqAW0o', 'Beau Champ', 'Otentic, eco tent lodge', 'We are the first glamping project in Mauritius. Our 12 safari tents each have their own private bathroom made of recycled wood. Our friendly staff is all from the nearby village. We generate our own electricity and hot water.\n\nThe space\n\nWe are the only glamping safari tent guesthouse in Mauritius. We have 12 individual tents. Each tent has 1 double bed and 2 or 3 single beds and can accommodate 2 adults / 3 children or up to 4 adults. Each tent has its own private bathroom.\n\nGuest access\n\nSwimming pool, Kayaks, Stand-up Paddle, Mountain bikes, Treks, free shuttle boat to Ile aux cerfs (the beach) every day.\n\nInteraction with guests\n\nWe will adapt to the guest request. We are always on site to help whenever needed.\n\nOther things to note\n\nWe have one of the best \'table d\'hote\' of the island. For lunch we serve Mauritian food and for dinner Barbecue.', 139, 383, 'LVD beau champ', '#4', 'Flacq District', '40401', -20.274673, 57.772453, NULL, NULL, NULL, '1', 1552401623, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '65', 10, 10, 0, 0, '50', 1, 'perhour', 'request', NULL, '', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '2', 1, 1552393830, NULL, NULL, NULL, '0', '', '06:00*|*10:00,10:00*|*16:00,16:00*|*20:00,20:00*|*23:00,'),
(8, 2, 14, 2, 8, 1, 1, 1, 'https://www.youtube.com/watch?v=6l9djoUDzao', 'Laem Chabang', 'Luxury Villa with Pool & Ocean View', 'Unwind in luxury, style and tranquility at the beautiful Villa K, superbly set in a picture-perfect location with breathtaking views over the sparkling turquoise sea and Big Buddha. This stunning villa is perfect escape for friends or families\n\nThe space\n\nUnwind in luxury, style and tranquility at the beautiful Villa K in Koh Samui, superbly set in a picture-perfect location with breathtaking views over the sparkling turquoise sea and Big Buddha temple. This stunning villa is in easy reach of everything Koh Samui has to offer, and with four bedrooms sleeping 8 - 12 people, it’s the perfect escape for couples, friends or families with children.\n\nVilla K has been designed with carefully thought-out details that will make your stay as pleasurable as possible. Take a dip in the glorious infinity pool while the kids play happily on the inflatables, sooth those aching muscles in the Jacuzzi or simply stretch out with a long cool drink and soak up the panoramic views.\n\nIf you fancy venturing out from the villa, it’s easy to explore the idyllic surroundings. In just a 10 minute drive you could be lounging on the white sands of Choeng Mon beach, enjoying the lively bustle of Chewang or immersed in the charming Fisherman’s Village in Bophut.\n\nA stylish, modern interior\n\nStepping inside the villa, the open-plan living space is light and airy. A neutral, modern interior complements the spectacular outside vistas.\n\nThe fully equipped kitchen is fitted with top of the range appliances and a washing machine. A contemporary glass dining table is accompanied by 10 comfortable dining chairs for lazy lunches through to celebratory dinners. Floor-to-ceiling glass doors slide all the way back to bring the outside in and give that feeling of al fresco dining.\n\nThe dining space leads into the relaxing lounge area where you can enjoy satellite TV, an LCD screen, DVD player and family board games from the comfort of the roomy sectional sofa and armchair.\n\nDownstairs on the lower level, four bedrooms sleep eight people, with space for an extra bed or cot in each room taking the maximum occupancy to 12. Each bedroom has its own private bathroom with sleek, modern fittings.\n\nThe two master bedrooms have sweeping views of the ocean and the Big Buddha, a king size bed with top of the range mattress, TV, hairdryer, safe and air-conditioning, with a bath tub and luxurious walk-in rain shower in each bathroom.', 217, 222, 'Laem Road', '#Sector Y 21', 'Chon Buri', '20230', 13.084673, 100.903351, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '350', NULL, 20, 30, 0, 0, '200', 2, 'pernight', 'instant', NULL, 'Check-in is anytime after 4 PM and check out by 11 AM\n\nElectrical appliance which can cause a high level of noise (e.g. television, radio, karaoke, electric tools, etc.) must be used with due consideration for other residents. ', 'always', NULL, NULL, 3, 12, NULL, NULL, NULL, '1', NULL, '1', 1, 1552394670, NULL, NULL, '[{"specialstartDate":"06\\/01\\/2019","specialendDate":"06\\/01\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/02\\/2019","specialendDate":"06\\/02\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/03\\/2019","specialendDate":"06\\/03\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/04\\/2019","specialendDate":"06\\/04\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/05\\/2019","specialendDate":"06\\/05\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/06\\/2019","specialendDate":"06\\/06\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/07\\/2019","specialendDate":"06\\/07\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/08\\/2019","specialendDate":"06\\/08\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/15\\/2019","specialendDate":"06\\/15\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/14\\/2019","specialendDate":"06\\/14\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/13\\/2019","specialendDate":"06\\/13\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/12\\/2019","specialendDate":"06\\/12\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/11\\/2019","specialendDate":"06\\/11\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/10\\/2019","specialendDate":"06\\/10\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/09\\/2019","specialendDate":"06\\/09\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/16\\/2019","specialendDate":"06\\/16\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/17\\/2019","specialendDate":"06\\/17\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/18\\/2019","specialendDate":"06\\/18\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/19\\/2019","specialendDate":"06\\/19\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/20\\/2019","specialendDate":"06\\/20\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/21\\/2019","specialendDate":"06\\/21\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/22\\/2019","specialendDate":"06\\/22\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/29\\/2019","specialendDate":"06\\/29\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/28\\/2019","specialendDate":"06\\/28\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/27\\/2019","specialendDate":"06\\/27\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/26\\/2019","specialendDate":"06\\/26\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/25\\/2019","specialendDate":"06\\/25\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/24\\/2019","specialendDate":"06\\/24\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/23\\/2019","specialendDate":"06\\/23\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"},{"specialstartDate":"06\\/30\\/2019","specialendDate":"06\\/30\\/2019","liststatus":"blocked","specialprice":"350","note":"Blocked for special events"}]', '1', '16:00*|*11:00', ''),
(9, 2, 13, 3, 5, 3, 4, 4, '', 'Singapore', 'Bukit Timah/Near city', 'Welcome to our home.\nOur house is a bungalow in the heart of Bukit Timah and only a 5 minute walk from the 6th Avenue downtown line MRT station.\nYou can expect tranquil surroundings, a private garden and your room overlooks the Balinese style pool (which you are free to use).\nThe room is perfect for small families or a group of friends and enjoys your own ensuite shower, a conducive study table, and a strong and fast Wifi connection.\n\nThe space\n\nThe bed options are essentially a large bunk bed with a pull out bed below. There is also a large sofa for a 4th or 5th person.\n\nGuest access\n\nPlease feel at home to use what you need. There is a full kitchen, 2 living rooms, a pool and a garden. Should you require we can even invite a masseuse to the home for massage therapy and treatment.\n\nInteraction with guests\n\nShould you need to clarify anything or ask any questions, we are usually very responsive. Just drop us a message here and we would be glad to help with anything at all. There may be a few hours delay should we be in vastly different time zones.\n\nOther things to note\n\n  Please note that the house is on one of the highest points in Bukit Timah. Going to the MRT is indeed a 3-5min walk downhill. Exit the gate, downhill 3min and turn left and it is there. How long one takes walking uphill however is really quite a matter of fitness. LOL.\n\nAlternatively you can simply Grab / taxi back to the house.   a 5 minute walk from the 6th Avenue downtown line MRT station.', 198, 275, 'burkit tamiah', 'Building Burkit Palace', 'Singapore', '521110', 1.347002, 103.949158, NULL, NULL, NULL, '1', 1552401622, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '90', NULL, 10, 5, 0, 0, '40', 3, 'pernight', 'request', NULL, '', 'onetime', 1552348800, 1575072000, 1, 5, NULL, NULL, NULL, '0', NULL, '3', 1, 1552395809, NULL, NULL, NULL, '0', '10:00*|*09:00', ''),
(10, 2, 9, 2, 4, 2, 2, 2, 'https://www.youtube.com/watch?v=50MAloxJsdE', 'London', 'The Muse Haus II - Balcony Room', '*Self-check-in: 24/7 -> virtual host\n*Private feel & ensuite bathroom, door locks\n*High-speed Wifi\n*Free (basic) breakfast (Nespresso!)\n*Daily cleaning\n*Kitchen, own labelled fridge & kitchen unit\n*Noise level: medium (200 feet off Great West Road)\n*West London -> 15-25 minutes to city centre\n*Closest underground: Ravenscourt Park -> 10 minutes walk away\n*Area: River Thames; young mid to upper class, pubs & restaurants\n*MORE ROOMS: message the responsive & friendly Muse Team\n\nThe space\n\n1. THE ROOM\nTwo beds: One super king-size (200cm x 180cm) + one optional queen-size sofa bed (real and comfortable mattress: 190cm x 140cm)\nSpacious room with ensuite bathroom and private balcony with view onto the River Thames\nRoom size: 20 sq.m. (ensuite bathroom and private stairs incl.)\nPrivate feel: all rooms go directly off the staircase\n\n2. CHECK-IN / CHECK-OUT\nSelf check-in & self-service concept: virtual host available 24/7 via messenger, phone or live-chat\nEarly check-in and late check-out possible for luggage only\n\n3. ADDITIONAL GUESTS\nEvery additional adult OR child over 1 year is considered as an extra guest and does cost just a little extra (please select the correct number of guests)\n\n4. PARKING\n24/7 free parking at Falcon Close, W4 3XQ London (5 min drive, 15 min bus, 30 min walk)\nWeekdays evening / morning: free street parking (17.00 – 9.00)\nWeekend & Holidays: free street parking\n\n5. THE CONCEPT\nThe Muse Haus is a 24/7 self-service, walk-in, walk-out concept with a virtual receptionist & concierge only. Guests shall feel at home and inspired rather than confined in a corporate setting – it is your home away from home in London, however long your stay may be\n\nThe Muse Haus is pioneering a new and unique concept of hospitality: it merges accessibility and hotel standard quality with homelike comfort and the privacy of serviced apartments, mobilised and driven by modern internet and smart phone technology\n\nThe Muse Haus endeavours to make guests feel at home the moment they enter the house, with the ability to store belongings and food, use of a common kitchen and living space. Mingle with Muse Haus mates or hang out on your own, work, rest or play.', 231, 340, 'Great Road', '#12', 'England', 'BF1 2AT', 51.491302, -0.238377, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '150', 50, 20, 0, 0, '800', 3, 'perhour', 'request', NULL, '', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '4', 1, 1552396559, NULL, NULL, '[{"specialstartDate":"03\\/27\\/2019","specialendDate":"03\\/27\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"03\\/28\\/2019","specialendDate":"03\\/28\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"03\\/29\\/2019","specialendDate":"03\\/29\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"03\\/30\\/2019","specialendDate":"03\\/30\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"03\\/26\\/2019","specialendDate":"03\\/26\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"03\\/31\\/2019","specialendDate":"03\\/31\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/01\\/2019","specialendDate":"04\\/01\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/02\\/2019","specialendDate":"04\\/02\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/10\\/2019","specialendDate":"04\\/10\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/03\\/2019","specialendDate":"04\\/03\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/04\\/2019","specialendDate":"04\\/04\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/05\\/2019","specialendDate":"04\\/05\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/06\\/2019","specialendDate":"04\\/06\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/07\\/2019","specialendDate":"04\\/07\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/08\\/2019","specialendDate":"04\\/08\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/09\\/2019","specialendDate":"04\\/09\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/11\\/2019","specialendDate":"04\\/11\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/12\\/2019","specialendDate":"04\\/12\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/13\\/2019","specialendDate":"04\\/13\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/20\\/2019","specialendDate":"04\\/20\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/18\\/2019","specialendDate":"04\\/18\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/19\\/2019","specialendDate":"04\\/19\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/16\\/2019","specialendDate":"04\\/16\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/17\\/2019","specialendDate":"04\\/17\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/15\\/2019","specialendDate":"04\\/15\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/14\\/2019","specialendDate":"04\\/14\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/21\\/2019","specialendDate":"04\\/21\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/22\\/2019","specialendDate":"04\\/22\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/23\\/2019","specialendDate":"04\\/23\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/24\\/2019","specialendDate":"04\\/24\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/25\\/2019","specialendDate":"04\\/25\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"},{"specialstartDate":"04\\/26\\/2019","specialendDate":"04\\/26\\/2019","liststatus":"blocked","specialprice":"150","note":"Listing not available on those days"}]', '1', '', '07:00*|*14:00,14:00*|*21:00,'),
(11, 2, 7, 1, 10, 3, 5, 5, 'https://www.youtube.com/watch?v=rDb7026_CHg', 'Vex', 'Luxury 5* chalet - Verbier region', 'Chalet Feiler is a beautiful mountain retreat in Les Collons, part of the Verbier ski area. With uninterrupted views of the sunny Rhone valley and southern Swiss and French Alps, this spectacular chalet can be enjoyed at all times of the year.\n\nThe space\n\nIt may be hard to leave the chalet with its hot tub overlooking the Matterhorn, sauna, Playstation, Wii, Ipod docks, TV, movies, fully equipped kitchen, sun loungers, and a number of ‘good reads’ – all surrounded by over 180 degrees of incredible mountain views. Yet if you can tear yourself away there are mountain spas, ski-ing, heli-boarding, paragliding, kayaking, canyoning, mountain biking and horse riding to name but a few (obviously some dependent on weather and season!).\n\nChalet Feiler is a self-catering chalet. There are catering options which are organised by the housekeeper (minimum of 5 days notice required). Please note we provide bed linen and towels.\n\nSleeping up to 10 adult guests plus we have 2 folding beds for children / or 2 cots, we welcome couples, families and friends. Our chalet is family-friendly, with cots, high chairs and a baby monitor. Local childcare can be arranged through the housekeeper (please let us know in advance your requirements).\n\nFrom your bed, wake up to incredible views from floor to ceiling windows. Bedrooms have been stylishly decorated in a mountain style. Luxury mattresses with cotton bedsheets and fluffy goose feather duvets and pillows (anti-allergy bedding also available on request).\n\nThe entire middle floor of Chalet Feiler is dedicated to the sleeping quarters and comprises three bedrooms with kingsize beds (two bedrooms can also be set up as twin beds), and the bunk room with 4 beds, is perfect for children and adults alike. There are two foldaway child beds or travel cots which can be set up in the room with the sauna in it. This brings the sleeping capacity of the chalet up to 12 guests in total. Each bedroom has mountain views and either has an ensuite bath or shower room. Three of the rooms have access to a large outdoor terrace for further lounging.\n\nThe open plan living area upstairs is the focal point in Chalet Feiler and is where you will undoubtedly spend countless hours chatting in front of the fire and enjoying the incredible views. The feeling of space is created by the double height ceiling and panoramic windows leading onto the large south-east facing balcony with fantastic views out into the valley.', 212, 374, 'Route de thyon, near collons', '#ana 42', 'Valais', '3436', 46.189308, 7.380019, NULL, NULL, NULL, '1', 1552401620, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '450', NULL, 50, 20, 0, 0, '700', 3, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 5, 12, NULL, NULL, NULL, '1', NULL, '6', 1, 1552397232, NULL, NULL, NULL, '0', '13:00*|*10:00', ''),
(12, 2, 16, 1, 5, 1, 2, 2, 'https://www.youtube.com/watch?v=pGg0bnhog2M', 'Sunrise Beach', 'Noosa Tree Top Eco Retreat', 'BUSH TO BEACH-a place to call your home for a while.....\nThe Tree Top Eco Retreat has its own private entrance. The bedroom is enclosed with glass, timber and bamboo. In winter it is warmed by the sun all day so it stays cozy warm, plus you can snuggle up under your winter weight quilt on your electric blanket . In summer you can open the louvre windows and the fresh ocean breeze cools the room.\n\nThe space\n\nAre you looking for something a little bit different? Do you want a rustic and romantic couples getaway? Or are you looking for some peaceful self-time away from it all, to recharge the soul? Do you want to enjoy a beautiful sunset from the comfort of your king size bed? Are you a nature lover, looking to take walks on the beach and see whales at play? And also be close to world class restaurants? If so, then we are looking for YOU!\n\nYour private, cosy, enclosed Bali style thatch roofed bedroom looks open to the elements but it is in fact enclosed with bamboo and glass and protected from the weather. It overlooks the Australian bush national park, with floor to ceiling views on two sides. This is no standard room! At night you sleep snug and warm, under a blanket of stars and the soothing sound of the ocean. In the morning, native bird song gently sings you into the new day. Just down the steps you have your own separate indoor/outdoor covered bathroom, (fresh rainwater shower&bath) and a spacious deck, (which is adjoined to the back of our solar powered home) to sunbathe and relax in a hammock with a good book. You can book in an amazing in-house massage and you also have access to our yoga studio, complete with mats and props. You have your own guest parking spot right outside the house. The beach, shops and bus stops are walking distance. Famous Hastings street shopping and restaurants are 5 km. Also plenty of great markets for some unique gifts.\n\nSee our other listing: we also rent the entire house-ask us for availability\n\nINCLUSIVE:\n*Crisp white soft cotton sheets and towels\n*King size bed\n*Tea and coffee (provided) and basic food making facilities\n( fridge, microwave oven, toaster, jug)\n*Shampoos/soaps\n*Filtered water\n*Free pick up from Noosa Junction (from 2pm)\n\nENJOY\n*An outdoor candlelit bath\n*Leisurely walks to the beach and parks\n*The friendly relaxed peaceful natural surrounds\n*Breakfast at a local cafe overlooking the ocean\n*Enjoy an in-house professional massage or yoga class\n*Noosa Farmers produce market on Sundays', 13, 304, 'Twilight Street, Sunrise beach', 'Villa 21', 'Queensland', '4179', -26.420687, 153.100937, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '150', 20, 30, 0, 0, '80', 1, 'perhour', 'instant', NULL, 'Respect the neighbours: Please keep noise levels down especially after dark.\n\nRespect the planet: Be energy aware: turn off lights, be mindful of water use ( short showers if possible please as we are on tank water supply)', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '0', NULL, '3', 1, 1552397992, NULL, NULL, NULL, '0', '', '06:00*|*11:00,12:00*|*18:00,'),
(13, 2, 8, 1, 5, 2, 4, 3, '', 'Mussoorie', 'Charming cottage in Landour', 'A three bedroom house surrounded by tall trees and filled with light, sunshine and colour.', 100, 250, 'Kellogg Memorial Chruch, Landour', 'Suite 45', 'Uttarakhand', '248122', 30.459476, 78.098022, NULL, NULL, NULL, '1', 1552401618, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '40', NULL, 3, 5, 0, 0, '0', 3, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 1, 10, NULL, NULL, NULL, '1', NULL, '1', 1, 1552398692, NULL, NULL, NULL, '0', '14:00*|*13:00', ''),
(14, 2, 14, 2, 10, 3, 5, 5, '', 'Darjeeling', 'Quaint Wood Cottage, Sherpa khangba', 'Away from congested town area, located amidst pine forests and greenery, 25 min walk from Mall, friendly neighbors, located near oldest monastery, comfortable stay, kitchen, and dining space for self cook available. Village tour, paragliding near by\n\nThe space\n\nYou will own private suite consisting of a bedroom and a living room bedroom attached fully furnished with sofas, reading articles n 29 inch TV with cable. Toilet both Indian and European style available. Hot shower available till 10 am. Kitchen n dining room available for self cooking. Breakfast, lunch, tea n dinner can be provided at a very reasonable rate. All room are well carpeted. 24 hours running water with Wi-Fi. The owner lives on the same floor, but privacy assured.\n\nA family of three can rent out the apt consisting of one bedroom, sitting area with amenities, shared kitchen and dining area for more than a month at reasonable rate. Electricity, cooking gas and water charges extra.plus in winter heater can be provided at an extra cost\n\nGuest access\n\nAll areas accessible.\n\nInteraction with guests\n\nAs per guest request.\n\nOther things to note\n\nInterested guests will have opportunity to have a first hand experience of authentic village life, can do meditation in the oldest Aloobari monastery , can take a 25 min walk to Ghoom monastery , Japanese peace pagoda too. Or visit chowrasta with a 30 min walk\nLocal sight seeings and trip to sunrise view at Tiger hill can also be arranged.\nFor the adventurous treks to Sandakphu and Falut is also available.\nVisit to tea gardens of Lebong is just a call away.', 100, 250, 'Darjeeling Road', '45', 'West Bengal', '734101', 27.052217, 88.258980, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '50', NULL, 5, 10, 0, 0, '50', 1, 'pernight', 'instant', NULL, 'House Rules\nSelf check-in with building staff\n\nGuest should take care of the house as their own. Shoes need to opened outside since the room are carpeted\nYou must also acknowledge\nPet(s) live on property', 'onetime', 1552348800, 1577404800, 1, 5, NULL, NULL, NULL, '1', NULL, '1', 1, 1552399666, NULL, '[{"specialstartDate":"04\\/14\\/2019","specialendDate":"04\\/14\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/20\\/2019","specialendDate":"04\\/20\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/19\\/2019","specialendDate":"04\\/19\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/18\\/2019","specialendDate":"04\\/18\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/17\\/2019","specialendDate":"04\\/17\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/16\\/2019","specialendDate":"04\\/16\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"},{"specialstartDate":"04\\/15\\/2019","specialendDate":"04\\/15\\/2019","liststatus":"available","specialprice":"35","note":"Special price due to Cottage Anniversary"}]', '[{"specialstartDate":"04\\/10\\/2019","specialendDate":"04\\/10\\/2019","liststatus":"blocked","specialprice":"50","note":"Special Events occurs on that day, so bookings are blocked."},{"specialstartDate":"04\\/11\\/2019","specialendDate":"04\\/11\\/2019","liststatus":"blocked","specialprice":"50","note":"Special Events occurs on that day, so bookings are blocked."},{"specialstartDate":"04\\/12\\/2019","specialendDate":"04\\/12\\/2019","liststatus":"blocked","specialprice":"50","note":"Special Events occurs on that day, so bookings are blocked."}]', '1', '15:00*|*12:00', ''),
(15, 3, 1, 1, 1, 2, 4, 4, '', 'Madikeri', 'CAESARS VILLA - ROMANTIC | POOL | ', 'A private villa with a plunge pool on the banks of river Kaveri to chill out with family and friends. Pets are invited. An ideal place for a romantic weekend amidst the nature in a secluded ambiance. Plenty of Parking space available.\n\nThe space\n\nthe property is a private villa with total privacy\n\nGuest access\n\nGuest can access around the area of the villa and also the best part is relaxing beside kaveri river\n\nOther things to note\n\nOurs is a private villa with private swimming pool and has total privacy accommodated with satellite TV , air conditioner, attached bathroom', 100, 250, 'coorg road', '56', 'Karnataka', '571201', 12.428877, 75.730698, NULL, NULL, NULL, '1', 1552401616, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '50', 10, 10, 0, 0, '60', 2, 'perhour', 'instant', NULL, '', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '2', 1, 1552401563, NULL, NULL, NULL, '0', '', '07:00*|*14:00,15:00*|*20:00,'),
(16, 3, 15, 1, 2, 1, 2, 1, 'https://www.youtube.com/watch?v=RM7U9qy85nE', 'Mumbai', 'Grand Luxury Studio Near Olives Ban', 'A contemporary studio tucked in Pali Hill area. With 2 toilets and 2 bathrooms and kitchen and walking wardrobe area. Very close to olives in Bandra West. This studio is Fully furnished, in an upscale residential building. with round the clock water and Tata sky on a 49 inch HIGH DEFI LED. Some popular restaurants, cafes & Carter Rd are in walking distance. PLEASE PROVIDE COPY OF GOVERNMENT ID PROOF ON CHECK IN. Strictly non smoking\n\nThe space\n\nMy studio in good for couples, small families, solo adventurers and business travellers. The neighbourhood is very safe and easy to access. You\'ll love my place because it is very spacious, comfortable and extremely close to a string of eateries and cafes buzzing night and day.\n\nThis ultra comfortable ground floor studio comes with a king sized bed with two toilets, two bathrooms, kitchen with sink, dedicated walk in wardrobe with a stand alone wash basin, this is an ideal place for couples, families wishing to spend time in Mumbai, explore Mumbai from the queen of suburbs.\n\nPlease note this flat is strictly non smoking.\n\nGuest access\n\nThe place has been set up for guest use only.\n\nInteraction with guests\n\nWe are reachable by phone and (Hidden by Airbnb) for any help during your stay\n\nOther things to note\n\nThis property is non smoking, no loud music as this a residential area.', 100, 250, 'Pali hills, Bandra west', 'Suite #1 ', 'Maharashtra', '400050', 19.067368, 72.826241, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '70', NULL, 10, 8, 0, 0, '100', 1, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 2, 5, NULL, NULL, NULL, '1', NULL, '4', 1, 1552455109, NULL, NULL, NULL, '0', '10:00*|*08:00', ''),
(17, 3, 6, 2, 4, 1, 2, 1, 'https://www.youtube.com/watch?v=FjUsiFLTamQ', 'Kodaikanal', 'Wood Cabins 8 Shafa Resort', 'Wood Cabins provides the opportunity of living in the lap of nature. The cottages, built out of wooden interiors provides you a luxurious blend of comfort and exotic natural ambiance which makes your dream vacation a reality. So, come-on, take that vacation you have kept aside for so long and visit us. We promise the vacation of your life!\n\nThe space\n\nA short stretch into the woods should ideally lead into the silent estate. But that is not the case, because hidden in the dark and silent canopy of pears and towering trees lays a resort which has merged itself into the beautiful landscape. Its inhabitants are enthralled by its distinguished wild visitors which includes the awesome bison’s and the all so beautiful birds which hover around in different colors and sizes.\n\nGuest access\n\n1. Free Parking space within our premises\n2. Private Patio for each Cabin with scenic valley view\n3. Access to Italian/ Conti Restaurant\n4. Nature walk within the estate\n\nInteraction with guests\n\nCaretakers available 24/7 at the resort.\n\nOther things to note\n\n1.Our property lies inside 14 acre pear estate a part of reserved forest area so there is no access to internet connectivity; guests can always get connected to beauty of nature.\n(URL HIDDEN) poor mobile phone signals inside the cabins (Airtel works better than others)\n3.Place may not be suitable for infants / very small kids & senior citizens and no wheel chair assistance.\n4.Trekking assistance and nature walk assistance can be provided.\n5.Tour Planning & travel assistance provided.\n6.Guests will have travel on the forest road(single road) for 700 meters to reach the resort.\nCome with trekking shoes on and bring your regular medicines handy if required.', 100, 250, 'Near valley view, vattakanal', 'Block #48', 'Tamil Nadu', '624101', 10.188192, 77.425156, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '40', 5, 5, 0, 0, '50', 1, 'perhour', 'instant', NULL, 'Not suitable for infants (under 2 years)\nYou must also acknowledge\nPet(s) live on property', 'onetime', 1554076800, 1580428800, 1, NULL, NULL, NULL, NULL, '1', NULL, '3', 1, 1552455851, NULL, NULL, NULL, '0', '', '06:00*|*11:00,12:00*|*16:00,'),
(18, 3, 16, 2, 5, 2, 4, 3, '', 'Port Blair', 'The Harriet View (Bedroom-2)', 'We are located in the heart of the City, Phoenix Bay, Port Blair which is very well connected to all the main places of tourist attractions like Samudrika, Sagarika, Anthropological Museum, Chatham Saw Mill and Marina Park. Veer Sawarkar Airport is situated at a distance of 2.5-3Kms. The biggest market of the Port Balir city, Aberdeen Bazar is less than 1 Km away. The National Monument Cellular jail a major Tourist attraction is hardly 1Km away. All major banks and ATMs are at walkable distance.', 100, 250, 'MA road', 'Door No: 25', 'Andaman and Nicobar Islands', '744101', 11.668789, 92.733307, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '50', NULL, 5, 5, 0, 0, '40', 1, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 3, 8, NULL, NULL, NULL, '0', NULL, '2', 1, 1552456356, NULL, NULL, NULL, '0', '10:00*|*08:00', '');
INSERT INTO `hts_listing` (`id`, `userid`, `hometype`, `roomtype`, `accommodates`, `bedrooms`, `beds`, `bathrooms`, `youtubeurl`, `city`, `listingname`, `description`, `country`, `timezone`, `streetaddress`, `accesscode`, `state`, `zipcode`, `latitude`, `longitude`, `commonamenities`, `additionalamenities`, `specialfeatures`, `featuredlist`, `featuredate`, `safetychecklist`, `fireextinguisher`, `firealarm`, `gasshutoffvalve`, `emergencyexitinstruction`, `medicalno`, `fireno`, `policeno`, `nightlyprice`, `hourlyprice`, `cleaningfees`, `servicefees`, `accomadtionfees`, `administrative_fees`, `securitydeposit`, `currency`, `booking`, `bookingstyle`, `whocanbook`, `houserules`, `bookingavailability`, `startdate`, `enddate`, `minstay`, `maxstay`, `advancenotice`, `priceforextrapeople`, `weeklydiscount`, `weekendprice`, `monthlydisocunt`, `cancellation`, `liststatus`, `cdate`, `normalprice`, `specialprice`, `blockedspecialprice`, `splpricestatus`, `pernight_availablity`, `hourly_availablity`) VALUES
(19, 3, 10, 2, 2, 1, 2, 2, '', 'Varkala', 'Private Sea View Villa - Privasea', 'Privasea is a private villa situated on the hillside amongst lush tropical gardens in Varkala - Kerala. With stylish combination of traditional Kerala design and modern elegance and a direct sea view from terrace, lawn and bedroom !\n\nThe space\n\nPrivasea has its own unique charm and features a verandah or terrace from which you can enjoy the most breathtaking direct views of varkala beach.\n\nGuest access\n\n> Free Wifi \n> Free Breakfast\n> 2 Bottles of Mineral Water Daily\n> Housekeeping services on Request\n> Digital Safe Deposit Locker', 100, 250, 'Near Edava Beach', 'Building No: 25, Old No: 42', 'Kerala', '695141', 8.759138, 76.687843, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '35', 10, 10, 0, 0, '50', 2, 'perhour', 'request', NULL, '', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '1', 1, 1552456885, NULL, NULL, NULL, '0', '', '07:00*|*12:00,13:00*|*18:00,19:00*|*23:00,'),
(20, 3, 5, 3, 2, 3, 4, 3, '', 'Andermatt', 'Alpine Chic Apartment, 3 bedrooms', 'Beautiful apartment for 6-8 people situated on the main street of Andermatt and 50 meters from the cabin to the ski area.\nThe complex has all the comfort you need to spend a beautiful winter or summer vacation\n\nThe space\n\nApartment 4 1/2 and 128 m2, 8 sleeping beds\n\nBeautiful apartment for a perfect holidays on the Swiss alps. Situated on a new building where everything made easier your ski holidays. The ski lift is at 50 m. Ski area for all level.\nParadise for freeride.\nIce rink and winter hiking.\n\nAndermatt is the perfect location to spend some beautiful ski or summer holidays.\nThis village is located on the center of Switzerland. Perfect to see more location and beautiful landscape on one trip.\nReally appreciated for bikes or motorcycles rides, hiking, fishing,...\nNew Golf course 500m.\n\nRestaurants, shops, bank, postoffice directly on the village.\n\nThe apartment is perfect for 2 family or to spend time with friends.\nLarge living-room with kitchen open.\nLarge dining area for 10 people\nOven, microwave, steemer, dishwasher, coffee machine,...\nTV,DVD,WI-Fi,Wii,... on the living-room.\n\n3 bedrooms.\n-One with double bed\n- One with double bed and baby bed\n- One with three singles beds in bunk bed and a kid bed\nSofa bed on the living room\n\n2 bathrooms.\n-One with shower\n-One with bath\nWash machine and tumbler on the main bathroom.\n\nBalcony of 12 m2\n\nSki deposit at the building entrance.\n\nTwo places of park on an under garage with direct access to the building.\n\nPlayground for the kids outside.\n\nInteraction with guests\n\nI can also help you during your stay in Andermatt and before to organize in the best way your vacation in this beautiful place. I can help you to find all the best place or thing to do in Andermatt.\nDo you want to celebrate a party in Andermatt, we can organize all your event on the Chalet for your guests or in an other place downtown.\nOr why not take a massage directly in your accommodation?', 212, 374, 'Near Gondola Lift Station, Andermatt', '#45', 'Uri', '6490', 46.632538, 8.591784, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '120', NULL, 10, 20, 0, 0, '100', 3, 'pernight', 'instant', NULL, 'No smoking\nCheck-in time is 1PM - 3PM and check out out by 10AM\n\nPets on request\nKids welcome and everything is disposed for them.\nYou must also acknowledge\nSecurity Deposit - if you damage the home, you may be charged up to $100', 'always', NULL, NULL, 4, 15, NULL, NULL, NULL, '1', NULL, '3', 1, 1552457676, NULL, NULL, NULL, '0', '13:00*|*10:00', ''),
(21, 3, 7, 2, 2, 1, 2, 1, '', 'London', 'Cosy Dutch House Boat Near London', 'Relax in this self-contained, refurbished, and fully decorated Dutch barge that oozes character and comfort. Enjoy views of the serene Grand Union Canal from the outdoor patio or have a cup of tea inside at the cosy dining table.', 231, 340, 'Mill Ln, Cowley', 'No 5648', 'England', 'SW1A 1AA', 51.501366, -0.141890, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '450', NULL, 50, 50, 0, 0, '500', 3, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 2, 5, NULL, NULL, NULL, '0', NULL, '2', 1, 1552458680, NULL, NULL, NULL, '0', '12:00*|*10:00', ''),
(22, 3, 10, 1, 10, 5, 5, 5, '', 'Montvalezan', 'Très beau chale Vue 10+ Personnes', 'Très beau et grand chalet de 350m, pour 10 à 22 personnes, séjour de 100m2 avec cheminée centrale, 6 chambres, 4 salles de bain, 5 toilettes, sauna (en sup), internet, parking, plein sud, vue pano. jardin. Possibilité de louer au weekend. En semaine d\'inter saison , peut être séparé en 2 duplex,12 et 9 p. Les draps et serviettes doivent être apportés ou je peux les louer pour vous et les mettre dans le chalet pour votre arrivée.Possibilité de ménage après votre départ.\n\nThe space\nThis huge chalet for 22 people, at the limit of fir trees and larches, completely renovated in the Savoyard style, is ideal for holidays to several families or groups, at any time of the year. Its stay of 100m2 with its central fireplace, as well as its large tables that allow large friendly tables. Its view is impregnable and its maximum sunshine (full south). The sunsets are superb. The flower garden is very pleasant summer (BBQ). It is located in the heart of one of the largest ski areas: the Tarentaise. 10 minutes by car or free shuttle from the ski area "San Bernardo" to La Rosière (160 kilometers of slopes). It has a sauna (extra charge), filter coffee makers (do not bring), and a Nespresso coffee maker with capsules (for capsules, I can help you out). There is an American fridge, a Godin stove, dishwasher, washer and dryer, raclette appliances and fondue pots. It has 6 bedrooms, 4 bathrooms, 5 toilets, I have 4 extra mattresses, and there are baby equipment: 1 cot and 2 high chairs, and a small barrier for the stairs. Underfloor heating and radiators in the rooms. It has private parking and near municipal parking. It also has a ski room in the big entrance of the bottom. Outside school holidays, it can be rented at the weekend. It can be separated into 2 independent duplexes (12-13 people or 9-10 people) with 3 bedrooms each, 2 bathrooms, 2 and 3 toilets, only during off-season (May-June and September, October November).\ntranslated by Google\n\nCet immense chalet pour 22 personnes, à la limite des sapins et des mélèzes, entièrement rénové dans le style savoyard, est idéal pour des vacances à plusieurs familles ou en groupe, à chaque période de l\'année. Son séjour de 100m2 avec sa cheminée centrale, ainsi que ses grandes tables qui permettent de grandes tablées conviviales.\nSa vue est imprenable et son ensoleillement maximal (plein sud). Les couchers de soleil sont superbes.\nLe jardin fleuri est très agréable l\'été (BBQ).', 73, 349, 'Les Laix', '', 'Auvergne-Rhône-Alpes', '75016', 45.616650, 6.845563, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '250', NULL, 15, 20, 0, 0, '400', 2, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 3, 30, NULL, NULL, NULL, '1', NULL, '2', 1, 1552459500, NULL, NULL, NULL, '0', '10:00*|*09:00', ''),
(23, 3, 12, 2, 2, 2, 3, 2, '', 'Moscow Mills', 'Luxury apartments in city center', '5 star luxury apartments!\n\nLocated in historical centre of Moscow. Many beautiful churches, parks and museums around. Just 10min to Red Square by car. You will have a bedroom and studio type living room with cooking corner . There is free WiFi for guests and secured parking in house.\n5 star luxury apartments! Located in historical centre of Moscow. Many beautiful churches, parks and museums around. Just 10min to Red Square by car. You will have a bedroom and studio type living room with cooking corner . There is free WiFi for guests and secured parking in house. -) 5min walk from subway stations (Baumanskaya and Krasnoselskaya) -) Free wifi -) free secured parking and security in building -) little Park inside\ntranslated by Google\n\n-) 5min walk from subway stations (Baumanskaya and Krasnoselskaya)\n-) Free wifi\n-) free secured parking and security in building\n-) little Park inside\n\nThe space\nSpecial designer apartments. 24-hours security. Beautiful Park inside our building, best for walking at night time:)\ntranslated by Google\n\nSpecial designer apartments. 24-hours security. Beautiful Park inside our building, best for walking at night time:)\n\nInteraction with guests\nI will provide you any help during your stay.\ntranslated by Google\n\nI will provide you any help during your stay.', 181, 347, 'Basmanny road', '#321', 'Missouri', '105043', 55.764946, 37.671581, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2500', NULL, 600, 600, 0, 0, '1500', 5, 'pernight', 'request', NULL, '', 'onetime', 1559347200, 1575072000, 2, 4, NULL, NULL, NULL, '0', NULL, '4', 1, 1552461363, NULL, NULL, NULL, '0', '11:00*|*09:00', ''),
(24, 3, 13, 2, 4, 1, 1, 1, '', 'Kazan', 'Peace on the river', 'Luxury boat-house on the river Sava. Hot tub area specially designed to provide a wonderful experience. Warm and peaceful ambient with wooden decoration, clean and full of natural light with the amazing view and wonderful nature. 10 min walk to the Ada Ciganlija Lake, 15 min by car to the city center, 25 min drive to the airport. There are three restaurants nearby. Sunbeds, sunshades and patio furniture. Local driveway to the house.\n\nInteraction with guests\n\n100% available during the guest\'s stay.', 181, 347, 'Arsk Road', '#B45', 'Tatarstan', '103274', 56.088909, 49.875401, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3000', NULL, 800, 800, 0, 0, '1800', 5, 'pernight', 'instant', NULL, 'House Rules\nNo parties or events\nCheck-in is anytime after 1PM and check out by 11AM\nSelf check-in with keypad\n\nThere is No Special rules, we only need normal behaving.', 'always', NULL, NULL, 1, 5, NULL, NULL, NULL, '0', NULL, '3', 1, 1552463227, NULL, NULL, NULL, '0', '13:00*|*11:00', ''),
(25, 3, 12, 2, 2, 1, 1, 1, '', 'Singapore', '【❤️Top Pick!!】RentRadise Alfa Suite', 'Hottest pick in sembawang! All our previous guests enjoy their stay in this unit and you will too! Guaranteed clean and comfortable, we strive to provide you the best accommodation for your vacation. We update calendar daily, you can book the dates you want instantly.\n\n• 1 min to Tesco Supermarket\n• 5 min to Giant Supermarket\n• 8 min to AEON Tebrau\n• 8 min to IKEA Tebrau\n• 8 min to Mount Austin Water Theme Park\n• 15 min to Johor Bahru CIQ\n• Uber/Grab active location\n• 24 hours Security\n\nThe space\n\n✔To receive discount voucher worth $120, use link below:\nhttps://www.airbnb.com/c/brycew1129\n\n--------------------------------------------------------------\n\n★ The Location ★\nLocate just beside Pasir Gudang Highway, easy access to anywhere in Johor Bahru. Near to Mount Austin, another lively town in Johor Bahru.\nTesco supermarket is just beside the apartment, so you can easily get your daily groceries there! In the middle of several hot spot in Johor Bahru, Pasir Gudang, Molek, Mount Austin, Tebrau, Johor Jaya, Permas Jaya and Senibong Cove, all can be reach within 10 minutes drive.\n\n★ The Unit ★\nSpecial tatami design, unique stay in Johor Bahru, come with one high quality queen size bed. Come here and experience a non-local design vacation stay! Can stay up to two guests, guest more than two can request for extra mattress.\n\nGuest access\n\nAt Level 6\n• Swimming Pool\n• Gym\n• Basketball Court\n• Ping Pong Table\n• Sauna\n• Playground\n• Meeting Room\n• Entertainment Room\n\nInteraction with guests\n\nMe or my co-host will personally welcome you and guide you to the studio, or else we will guide you on a simple self check in instruction.\n\nNo worry as the self check in guide is simple and easy to understand :)\n\nIf you have inquiries, drop me a message and i will respond in no time. Don\'t be shy to share a little about you, i will share mine too.\n\nPlease let me know your travel itinerary and also check in/check time out so that i can well prepare for it.\n\nIf you have any special request please let me know, i will try to fulfill and make sure you have the best stay here.\n\nOther things to note\n\nIf you are looking for transportation to/from Singapore, do let me know, i have partners that can provide the transport service for you with the cheapest price in town!\n\nExtra bed and towel will be provided for guests more than two.', 198, 275, 'Sembawang way, Sembawang', '#998', 'Singapore', '521110', 1.448602, 103.816544, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', 5, 5, 0, 0, '100', 2, 'perhour', 'request', NULL, '', 'onetime', 1556668800, 1585612800, 1, NULL, NULL, NULL, NULL, '1', NULL, '1', 1, 1552463882, NULL, NULL, NULL, '0', '', '01:00*|*08:00,09:00*|*14:00,15:00*|*19:00,20:00*|*23:00,'),
(26, 3, 10, 1, 5, 2, 2, 2, '', 'Fitzroy North', 'Bright apartment in vibrant Fitzroy', 'A beautiful sunny space in the heart of Fitzroy with everything you need for a comfortable stay. Ideal for a solo traveller or couple who want to experience Melbourne like locals.\n\nThe space\n\nThis beautiful studio apartment has been recently renovated and is ideally located in Fitzroy within walking distance to Melbourne CBD. It is ideal for a single person or a couple.\n\nThe apartment is on the first floor of a small block of units (18 in total) surrounded by greenery. Our studio apartment (approximately 32m2) is tastefully decorated and has a large window overlooking Napier Street which gets lovely morning light.\n\nGuest access\n\nGuests will have access to a fully equipped kitchen, comfortable queen size bed, bathroom facilities and wireless internet. The apartment has ample storage for bags with hanging space and large drawers for clothes. Fresh towels and linen are of course provided and are included in the price. Guests have access to a communal, coin operated laundry on the same floor of the building and there is secure parking for one car if required.\n\nInteraction with guests\n\nOnce we give you the keys the apartment is all yours to enjoy. It is very private and a wonderful retreat after a busy day of exploring the city. We are always happy to be contacted if you need advice or help throughout your stay.\n\nOther things to note\n\nThere is no TV in the apartment, but rest assured there is plenty to do! If you have any questions please send us a message and we\'d be more than happy to help.', 13, 312, 'Brunswick st', '#52', 'Victoria', '3056', -37.791611, 144.979599, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '90', NULL, 50, 50, 0, 0, '50', 1, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 1, 3, NULL, NULL, NULL, '0', NULL, '1', 1, 1552469908, NULL, NULL, NULL, '0', '10:00*|*08:00', ''),
(27, 3, 5, 1, 2, 1, 2, 2, '', 'Hat Yai', 'Premier Homestay Villa Lanna', 'Located 5mins from Chiang Mai\'s largest shopping mall Central Festival, Big C Extra, and 10mins from Thapae Gate. Villa Lanna is the ideal property for our guests whom enjoy the hustle and bustle of the city, and yet would like to come home to a relaxing getaway. A historical teak house refurbished to meet modern day living standards and more. We have brought a whole new meaning to experiencing Thailand. Our guest will have no worries on transportation, or visiting attractions.\n\nThe space\n\nThe premier Lanna homestay destination in Chiang Mai. A historical teak villa, refurbished with all the contemporary conveniences to ensure the comfort of our guests. Bringing to our guests a unique experience of a true Thai holiday without breaking the bank! Come stay with us and unravel the beauty of Chiang Mai!\n\nGuest access\n\nGuest would have the entire Villa to themselves.\n\nInteraction with guests\n\nWe would be more than happy to help our guest with any information they need about Chiang Mai. Being tour company owner\'s we would also offer the best deals on any attractions that Chiang Mai has to offer.\n\nOther things to note\n\nGuest whom stay with us are entitled to free usage of a scooter for transportation, and also discounts on Chiang Mai\'s attractions. Our guest are also entitled to free airport pick ups and send offs between 2pm till 11pm.', 217, 222, 'Phet Kasem Road', 'Suite #BE54', 'Songkhla', '90000', 8.672328, 98.252975, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '145', 25, 25, 0, 0, '200', 2, 'perhour', 'instant', NULL, 'No smoking\nCheck-in is anytime after 3PM and check out by 12PM (noon)\nSelf check-in with building staff\n\nSmoking is allowed only at the external areas of the house and not within the house itself.\n别墅内是不允许吸烟的,如果房客吸烟的话请只在别墅外的吸烟区吸烟｡', 'always', NULL, NULL, 1, NULL, NULL, NULL, NULL, '1', NULL, '1', 1, 1552471047, NULL, NULL, NULL, '0', '', '07:00*|*13:00,14:00*|*20:00,'),
(28, 3, 2, 1, 2, 1, 1, 1, '', 'Roma', 'Ex Pastificio Pantanella (A)', 'The apartment is located in the center of Rome, it is located in a very quiet and peaceful residential area,precisely in the luxury area of the ex-industrial factory "Pantanella." this amazing industrial structure is very close to the very important monuments like the Basilica of San Giovanni,the Basilica of Sant Maria Maggiore, and the Colosseum is at 1.5km. In the area of the apartment there are some many interesting points to visit, monuments, vintage market, nightlife and local food market.\n\nThe space\n\nThe apartment is located in the center of Rome, just 30 meters from "Porta Maggiore" the main entrance door of ancient Rome. the apartment is located in a very quiet and peaceful, specifically in the upmarket residential area of the former pasta factory "Pantanella." The apartment is near the monumental area of Rome (San Giovanni) and at the same time close to the nightlife area of Rome "Pigneto" and "San Lorenzo".\n\nGuest access\n\nThe guests have access to the whole apartment, the property will be exclusively for you!\n\nInteraction with guests\n\nWe will be available at all times for any request or need at the property. We will welcome you at the apartment on your arrival.', 107, 353, 'piazza Lodi', '#52', 'Lazio', '07644', 41.887299, 12.521474, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '80', NULL, 10, 10, 0, 0, '60', 2, 'pernight', 'request', NULL, '', 'onetime', 1556668800, 1577750400, 3, 6, NULL, NULL, NULL, '1', NULL, '3', 1, 1552471883, NULL, NULL, NULL, '0', '11:00*|*10:00', ''),
(29, 3, 16, 1, 6, 3, 5, 5, '', 'Havana', 'Relax frente al mar', 'Lujosa villa con piscina con acceso directo al mar. Frente al mar se encuentra un ranchón donde descansar bajo la sombra, ideal para pasar buenos ratos tomando el sol y disfrutando de la vista y brisa del mar junto a sus amigos o parejas.', 55, 115, 'Fusterlandia', 'Block 45', 'Havana', '62644', 23.089846, -82.483124, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '120', NULL, 15, 15, 0, 0, '100', 1, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 2, 8, NULL, NULL, NULL, '1', NULL, '3', 1, 1552472488, NULL, NULL, NULL, '0', '06:00*|*19:00', ''),
(30, 3, 5, 1, 4, 2, 3, 2, '', 'Singapore', '【❣️City HOT!】RentRadise Kobe Suite', 'Enjoy a perfect stay in the heart of Johor Bahru at RentRadise Kobe Suite, a condo unit within walking distance to all major attractions and night life in JB. Book this unit now and explore everything that JB has to offer! Points of interest nearby include:\n\n• 1 min walk to Komtar JBCC & City Square shopping complex\n• 2 min walk to JB Sentral\n• 5 min walk to Heritage Street\n• 5 min walk to Karat Night Market\n• 5 min walk to Persada Johor\n• 15 min to Woodlands Singapore\n\nThe space\n\nTo receive FREE Airbnb travel credit $120, use the referral link from us\n★www.airbnb.com/c/brycew (Phone number hidden by Airbnb) ★\n\nCheck out our other listing :\n★https://www.airbnb.com/users/136700088/listings★\n\nFully furnish stylist design one bedroom suite that can comfortably fit up to 5 guests. High quality king size bed, sofa bed and floor mattress will be provided base on the registered number of guests.\n\nToiletries such as body, hair shampoo and towel will be provided, just bring your clothes and enjoy the stay. One free indoor car park provided, car access card will be given upon check in.\n\nGuest access\n\nAt Level 33A :\n• Sky View Swimming Pool\n• Gym\n• Playground\n• Sky Deck\n• Self-Laundry\n\nInteraction with guests\n\nMe or my co-host will personally welcome you and guide you to the condominium or a simple self check in will be provided so that you can check in anytime.\n\nOther things to note\n\nTransport service to/from Singapore available with reasonable price!', 198, 275, 'Novena', 'BL No 56', 'Singapore', '228598', 1.312989, 103.841995, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '120', NULL, 20, 25, 0, 0, '150', 3, 'pernight', 'request', NULL, '', 'onetime', 1559433600, 1575072000, 1, 5, NULL, NULL, NULL, '1', NULL, '4', 1, 1552473277, NULL, NULL, NULL, '0', '10:00*|*09:00', ''),
(31, 4, 1, 2, 2, 1, 1, 1, '', 'Cooktown', 'Aroma(n)tica TreehouseinMonferrato', 'A wonderful suspended nest, an amazing panoramic view on the hills, among the fragrances of the linden trees and other aromatic herbs. A garden with solarium and a swimming pool (seasonal opening) surrounded by blooming peaceful nature.\nThe garden measures 18,000 square meters with awe-inspiring trees such as majestic cedars of Lebanon and magnolias, pagodas, hollies and tamarisks. You can find Nature walks, cycle routes, wine tours and cultural paths.\nThe Monferrato is, with its deep-rooted enological traditions, an area in which you can find the top quality wines such as Barbera, Freisa, Grignolino and Cortese; it is possible to visit the wine cellars of high-qualified productors. \nIn the mansion, you can have access as well to the wine cellar carved in tuff of the late XIXth century, with the typical "infernot", barrels and an ancient press to produce wine.\n\n(URL HIDDEN) Free wifi around the swimming pool(URL HIDDEN) Shabby chic decor.(URL HIDDEN) Private bathroom with sink, toilet and shower(URL HIDDEN) Private parking.(URL HIDDEN) Very close to Casale Monferrato, Alessandria (5 minutes by car)(URL HIDDEN) Not far from Alba, Barolo and Asti.(URL HIDDEN) 1 hour driving to Turin, Milan and Genoa(URL HIDDEN)Nearby, it is possible to find taverns and cottages where you can taste the typical specialties of the territory.', 13, 305, 'Shire of cook', '', 'Queensland', '54453', -15.469702, 145.251755, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '133', NULL, 5, 5, 0, 0, '20', 1, 'pernight', 'instant', NULL, 'No smoking. No pets. No parties or events.', 'always', NULL, NULL, 2, 6, NULL, NULL, NULL, '1', NULL, '2', 1, 1552477718, NULL, NULL, NULL, '0', '00:00*|*00:00', ''),
(32, 2, 2, 1, 5, 3, 5, 4, 'https://www.youtube.com/watch?v=mSyfSc3REEA', 'Dubai', 'Elegant 3BDR Apartment - Downtown', 'A modern yet elegantly designed apartment situated in Downtown Dubai, offering you the breathtaking view of the world\'s tallest building Burj Khalifa. t is conveniently located in close proximity to Sheikh Zayed Road and is only 20 minutes away from the airport.\n\nThis exclusive and spacious three bedroom is the perfect getaway and is designed to refresh maximize the levels of comfort and relaxation with family and friends.\n\nThe space\n\nA tastefully designed apartment in Downtown Dubai, which simply redefines the concept of spacious living in the heart of the city. The sassy apartment features sealing to floor windows that provide energizing light in the apartment and a breathtaking view. The stylish yet sophisticated space is consisting of three exceptional bedrooms and three beautiful bathrooms, accommodating six guests, completed with a large living and dining area with an outstanding view of the dancing fountain and accompanied by the view of the world famous Burj Khalifa. The apartment consists of a fully equipped kitchen for the perfect dine-in experience!\n\nThis sensational apartment accommodates six people, allowing a whole family to come together and spend quality time with their own personal space. The posh location allows you to travel around in convenience to the world famous hotels, restaurants and water theme parks!\n\nFor your utmost suitability the apartment is equipped with a Nespresso machine.\n\nThe building itself offers a gymnasium and a swimming pool.\n\nGuest access\n\nOur apartments are exclusively designed for your optimal privacy, we offer video intercom access, pool, gymnasium access and for your safety and protection 24 hours’ security available in the building. Our apartments are rented solely for our guests thus, you have a key card system which allows you to utilize the private building parking, following a private elevator straight to your apartment. The apartment itself is secluded and offers you prime privacy for your relaxation.\n\nInteraction with guests\n\nUpon your arrival you will be welcomed by our GEM- Guest experience Maker, who will be at your service 24 hours a day regarding any matter, and one day prior to your departure the guest relations associate will contact you for your check out details.\nAs we truly respect your privacy we will not cause any disturbance to you during your stay, until and unless you have requested it.', 230, 233, 'Dubai City', '', 'Dubai', '00000', 25.248871, 55.312397, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '550', 50, 30, 0, 0, '800', 1, 'perhour', 'request', NULL, '', 'always', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2', 1, 1552482615, NULL, NULL, NULL, '0', '', '05:00*|*14:00,15:00*|*22:00,'),
(33, 2, 2, 2, 4, 2, 3, 2, '', 'Dubai', 'Large Boutique Condo by Metro', 'Your deluxe SMART home is 10 minutes from the beach in the upscale Jumeirah Lakes Towers neighborhood. Use your voice to control the AC, lights, and play music, as well as enjoy the memory foam king bed and comfy day bed as you watch NETFLIX on a 55 inch 4K UHDTV.\n\nYou are only 1 minute from the metro with free parking, pool, gym, and sauna. Life can’t be more convenient with dozens of restaurants and shops at your doorstep.\n\nSingle travelers, couples, families, and groups all welcome!\n\nThe space\n\nWelcome to Dubai’s most convenient SMART home. The provided Amazon Echo allows you to control the AC, lights, and play music from a library of over a million songs using your voice. You may also access free NETFLIX and cable channels on the 55 inch 4K SAMSUNG TV.\n\nIn the bedroom:\n\n• King bed with a memory foam mattress for a relaxing night’s sleep\n• Plenty of pillows, sheets, bath towels, and beach towels\n• A large balcony with stunning views of Lake Almas and the vistas of Jumeirah Lakes Towers\n\nIn the living room:\n\n• 55 inch SAMSUNG 4K TV with free NETFLIX\n• Cable with over 200+ channels in over a dozen languages\n• A relaxing environment with a comfortable daybed\n• The daybed can be used as a sofa, and also expanded to comfortably sleep two people\n\nIn the dining room:\n\n• Dual-use eating and working space with leather chairs that seats up to 4\n• Water dispenser with cold, medium, and hot buttons, with 5 gallons (19 liters) of water included\n• Complementary snacks and tea/coffee to get you going!\n\nIn the kitchen:\n\n• Cooking utensils and stove\n• Electric kettle\n• Microwave and toaster\n• Coffee maker and grinder\n• Washer and dryer (detergent provided)\n\nIn the bathroom\n\n• Full bath with shower\n• Soap and shampoo/conditioner\n• Bidet spray\n\nSMART and network features:\n\n• Fast and stable 30+ mbps internet connection with WiFi router\n• Amazon Echo to control your home with your voice and listen to music\n• NEST thermostat with SMART temperature regulation\n\nOther amenities:\n\n• Hair dryer\n• Power socket adapters\n• Iron and ironing table\n• Queen size air bed for groups of 5 or more\n• Crib for those with infants or young children\n• Prayer mat\n\nThe total space of the apartment is 530 square feet (50 square meters). It is ideal for 4 people but can sleep up to 5.\n\nGuest access\n\nEnjoy for free on the first floor:\n\n• Separate men\'s and women\'s gyms\n• Separate adult\'s and children\'s pools\n• Hot tub\n• Sauna\n• Steam Rooms\n• Barbecue and outdoor dining area\n• Kids play area\n• Table', 230, 233, 'Dubai City', '#21', 'Dubai', '00000', 25.248871, 55.312397, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '450', NULL, 25, 25, 0, 0, '600', 6, 'pernight', 'request', NULL, '', 'always', NULL, NULL, 1, 5, NULL, NULL, NULL, '0', NULL, '2', 1, 1552545833, NULL, NULL, NULL, '0', '11:00*|*08:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `hts_listingproperties`
--

CREATE TABLE `hts_listingproperties` (
  `id` int(11) NOT NULL,
  `bedrooms` int(3) DEFAULT NULL,
  `beds` int(3) DEFAULT NULL,
  `bathrooms` int(3) DEFAULT NULL,
  `accommodates` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_listingproperties`
--

INSERT INTO `hts_listingproperties` (`id`, `bedrooms`, `beds`, `bathrooms`, `accommodates`) VALUES
(1, 5, 5, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hts_lists`
--

CREATE TABLE `hts_lists` (
  `id` int(11) NOT NULL,
  `listname` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `user_create` int(1) DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_lists`
--

INSERT INTO `hts_lists` (`id`, `listname`, `createdby`, `user_create`, `cdate`) VALUES
(1, 'Demo Favourite', 2, 1, '2019-03-13 10:55:48'),
(2, 'Demo\'s Dream Home', 2, 1, '2019-03-13 10:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `hts_logs`
--

CREATE TABLE `hts_logs` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `notifyto` int(11) DEFAULT NULL,
  `listingid` int(11) DEFAULT NULL,
  `notifymessage` text,
  `messageread` enum('0','1') NOT NULL DEFAULT '0',
  `message` text CHARACTER SET utf8,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_logs`
--

INSERT INTO `hts_logs` (`id`, `type`, `userid`, `notifyto`, `listingid`, `notifymessage`, `messageread`, `message`, `cdate`) VALUES
(1, 'message', 2, 3, 21, 'sent you a message', '1', 'Looking great to see your\'s chalet, we need some details about it. As we planned to trip around the London.', 1552473658),
(2, 'request', 3, 2, 21, 'You made a reservation on', '1', '', 1552473839),
(3, 'reservation', 2, 3, 21, 'There is a reservation made on', '1', '', 1552473839),
(4, 'request', 2, 3, 3, 'You made a reservation on', '1', '', 1552474189),
(5, 'reservation', 3, 2, 3, 'There is a reservation made on', '1', '', 1552474189),
(6, 'cancel', 3, 2, 3, 'cancelled your reservation', '1', '', 1552474222),
(7, 'request', 3, 2, 24, 'You made a reservation on', '1', '', 1552474381),
(8, 'reservation', 2, 3, 24, 'There is a reservation made on', '1', '', 1552474381),
(9, 'request', 2, 3, 1, 'You made a reservation on', '1', '', 1552474712),
(10, 'reservation', 3, 2, 1, 'There is a reservation made on', '1', '', 1552474712),
(11, 'request', 3, 2, 16, 'You made a reservation on', '1', '', 1552474888),
(12, 'reservation', 2, 3, 16, 'There is a reservation made on', '1', '', 1552474888),
(13, 'decline', 3, 2, 16, 'declined your reservation request', '1', '', 1552474935),
(14, 'request', 4, 2, 31, 'You made a reservation on', '1', '', 1552482930),
(15, 'reservation', 2, 4, 31, 'There is a reservation made on', '0', '', 1552482930),
(16, 'message', 4, 2, 3, 'sent you a message', '1', 'Hi..Is this listing available on this time??', 1552483550),
(17, 'review', 2, 4, 31, 'sent review', '0', '', 1552484172),
(18, 'request', 2, 3, 32, 'You made a reservation on', '1', '', 1552484335),
(19, 'reservation', 3, 2, 32, 'There is a reservation made on', '1', '', 1552484335),
(20, 'request', 2, 3, 12, 'You made a reservation on', '1', '', 1552542068),
(21, 'reservation', 3, 2, 12, 'There is a reservation made on', '1', '', 1552542068),
(22, 'request', 2, 3, 11, 'You made a reservation on', '1', '', 1552542433),
(23, 'reservation', 3, 2, 11, 'There is a reservation made on', '1', '', 1552542433),
(24, 'review', 3, 2, 32, 'sent review', '1', '', 1552542580),
(25, 'request', 2, 3, 13, 'You made a reservation on', '1', '', 1552543560),
(26, 'reservation', 3, 2, 13, 'There is a reservation made on', '1', '', 1552543560),
(27, 'review', 3, 2, 13, 'sent review', '1', '', 1552544501),
(28, 'request', 2, 3, 3, 'You made a reservation on', '1', '', 1552544859),
(29, 'reservation', 3, 2, 3, 'There is a reservation made on', '1', '', 1552544859),
(30, 'request', 2, 3, 8, 'You made a reservation on', '1', '', 1552557043),
(31, 'reservation', 3, 2, 8, 'There is a reservation made on', '1', '', 1552557043);

-- --------------------------------------------------------

--
-- Table structure for table `hts_messages`
--

CREATE TABLE `hts_messages` (
  `id` int(11) NOT NULL,
  `inquiryid` int(11) DEFAULT NULL,
  `senderid` int(11) DEFAULT NULL,
  `receiverid` int(11) DEFAULT NULL,
  `message` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `receiverread` int(11) DEFAULT NULL,
  `listingid` int(11) DEFAULT NULL,
  `messagetype` enum('user','admin') DEFAULT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_messages`
--

INSERT INTO `hts_messages` (`id`, `inquiryid`, `senderid`, `receiverid`, `message`, `receiverread`, `listingid`, `messagetype`, `cdate`) VALUES
(1, 1, 2, 3, 'Looking great to see your\'s chalet, we need some details about it. As we planned to trip around the London.', 1, 21, 'user', '2019-03-13 10:40:58'),
(2, 1, 3, 2, 'Hi, Aswad Nice to see your inquiry, welcome you to London.', 1, 21, 'user', '2019-03-13 10:43:09'),
(3, 2, 2, 3, 'Reservation made on your listing - Cosy Dutch House Boat Near London', 0, 21, 'user', '2019-03-13 10:43:59'),
(4, 3, 3, 2, 'Reservation made on your listing - South Mission Beach Zen-Like Home', 0, 3, 'user', '2019-03-13 10:49:49'),
(5, 4, 2, 3, 'Reservation made on your listing - Peace on the river', 0, 24, 'user', '2019-03-13 10:53:01'),
(6, 5, 3, 2, 'Reservation made on your listing - Urban Farmhouse at Denver', 0, 1, 'user', '2019-03-13 10:58:32'),
(7, 6, 2, 3, 'Reservation made on your listing - Grand Luxury Studio Near Olives Ban', 1, 16, 'user', '2019-03-13 11:01:28'),
(8, 7, 2, 4, 'Reservation made on your listing - Aroma(n)tica TreehouseinMonferrato', 0, 31, 'user', '2019-03-13 13:15:30'),
(9, 8, 4, 2, 'Hi..Is this listing available on this time??', 1, 3, 'user', '2019-03-13 13:25:50'),
(10, 8, 2, 4, 'Hi..Yes its available..', 1, 3, 'user', '2019-03-13 13:27:26'),
(11, 9, 3, 2, 'Reservation made on your listing - Elegant 3BDR Apartment - Downtown', 1, 32, 'user', '2019-03-13 13:38:55'),
(12, 10, 3, 2, 'Reservation made on your listing - Noosa Tree Top Eco Retreat', 0, 12, 'user', '2019-03-14 05:41:08'),
(13, 11, 3, 2, 'Reservation made on your listing - Luxury 5* chalet - Verbier region', 0, 11, 'user', '2019-03-14 05:47:13'),
(14, 12, 3, 2, 'Reservation made on your listing - Charming cottage in Landour', 0, 13, 'user', '2019-03-14 06:06:00'),
(15, 13, 3, 2, 'Reservation made on your listing - South Mission Beach Zen-Like Home', 0, 3, 'user', '2019-03-14 06:27:39'),
(16, 14, 3, 2, 'Reservation made on your listing - Luxury Villa with Pool & Ocean View', 0, 8, 'user', '2019-03-14 09:50:43');

-- --------------------------------------------------------

--
-- Table structure for table `hts_paymentmethods`
--

CREATE TABLE `hts_paymentmethods` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `cardno` varchar(20) DEFAULT NULL,
  `valilddate` int(11) DEFAULT NULL,
  `cvvno` varchar(3) DEFAULT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `postalcode` bigint(20) DEFAULT NULL,
  `country` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_payoutmethods`
--

CREATE TABLE `hts_payoutmethods` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `address1` varchar(60) DEFAULT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `postalcode` bigint(20) DEFAULT NULL,
  `country` int(3) DEFAULT NULL,
  `payoutmethod` varchar(20) DEFAULT NULL,
  `paypalid` varchar(150) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `loginkey` varchar(50) DEFAULT NULL,
  `transactionkey` varchar(50) DEFAULT NULL,
  `stripeid` varchar(50) DEFAULT NULL,
  `stripekey` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_photos`
--

CREATE TABLE `hts_photos` (
  `id` int(11) NOT NULL,
  `listid` int(11) DEFAULT NULL,
  `image_name` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_photos`
--

INSERT INTO `hts_photos` (`id`, `listid`, `image_name`) VALUES
(1, 1, '1552384592_2_0.jpg'),
(2, 1, '1552384600_2_0.jpg'),
(3, 1, '1552384600_2_1.jpg'),
(4, 1, '1552384600_2_2.jpg'),
(5, 2, '1552385505_2_0.jpg'),
(6, 2, '1552385520_2_0.jpg'),
(7, 2, '1552385520_2_1.jpg'),
(8, 2, '1552385520_2_2.jpg'),
(9, 2, '1552385520_2_3.jpg'),
(10, 3, '1552386986_2_0.jpg'),
(11, 3, '1552386993_2_0.jpg'),
(12, 3, '1552386993_2_1.jpg'),
(13, 3, '1552386993_2_2.jpg'),
(14, 3, '1552386993_2_3.jpg'),
(15, 4, '1552387908_2_0.jpg'),
(16, 4, '1552387926_2_0.jpg'),
(17, 4, '1552387926_2_1.jpg'),
(18, 4, '1552387926_2_2.jpg'),
(19, 4, '1552387926_2_3.jpg'),
(20, 5, '1552388850_2_0.jpg'),
(21, 5, '1552388858_2_0.jpg'),
(22, 5, '1552388858_2_1.jpg'),
(23, 5, '1552388858_2_2.jpg'),
(24, 5, '1552388858_2_3.jpg'),
(30, 6, '1552390825_2_0.jpg'),
(31, 6, '1552390825_2_1.jpg'),
(32, 6, '1552390825_2_2.jpg'),
(33, 6, '1552390825_2_3.jpg'),
(34, 6, '1552390825_2_4.jpg'),
(41, 7, '1552393806_2_0.jpg'),
(42, 7, '1552393814_2_0.jpg'),
(43, 7, '1552393814_2_1.jpg'),
(44, 7, '1552393814_2_2.jpg'),
(45, 7, '1552393814_2_3.jpg'),
(46, 8, '1552394395_2_0.jpg'),
(47, 8, '1552394434_2_0.jpg'),
(48, 8, '1552394434_2_1.jpg'),
(49, 8, '1552394434_2_2.jpg'),
(50, 8, '1552394434_2_3.jpg'),
(51, 9, '1552395650_2_0.jpg'),
(52, 9, '1552395661_2_0.jpg'),
(53, 9, '1552395661_2_1.jpg'),
(54, 9, '1552395661_2_2.jpg'),
(55, 9, '1552395661_2_3.jpg'),
(56, 10, '1552396377_2_0.jpg'),
(57, 10, '1552396383_2_0.jpg'),
(58, 10, '1552396383_2_1.jpg'),
(59, 10, '1552396383_2_2.jpg'),
(60, 10, '1552396383_2_3.jpg'),
(61, 11, '1552397104_2_0.jpg'),
(62, 11, '1552397133_2_0.jpg'),
(63, 11, '1552397133_2_1.jpg'),
(64, 11, '1552397133_2_2.jpg'),
(65, 11, '1552397133_2_3.jpg'),
(66, 12, '1552397804_2_0.jpg'),
(67, 12, '1552397811_2_0.jpg'),
(68, 12, '1552397811_2_1.jpg'),
(69, 12, '1552397811_2_2.jpg'),
(70, 12, '1552397811_2_3.jpg'),
(71, 13, '1552398606_2_0.jpg'),
(72, 13, '1552398611_2_0.jpg'),
(73, 13, '1552398611_2_1.jpg'),
(74, 13, '1552398611_2_2.jpg'),
(75, 13, '1552398611_2_3.jpg'),
(76, 14, '1552399239_2_0.jpg'),
(77, 14, '1552399239_2_1.jpg'),
(78, 14, '1552399239_2_2.jpg'),
(79, 14, '1552399239_2_3.jpg'),
(80, 14, '1552399239_2_4.jpg'),
(81, 15, '1552401468_3_0.jpg'),
(82, 15, '1552401468_3_1.jpg'),
(83, 15, '1552401468_3_2.jpg'),
(84, 15, '1552401468_3_3.jpg'),
(85, 15, '1552401468_3_4.jpg'),
(86, 16, '1552454928_3_0.jpg'),
(87, 16, '1552454928_3_1.jpg'),
(88, 16, '1552454928_3_2.jpg'),
(89, 16, '1552454928_3_3.jpg'),
(90, 16, '1552454928_3_4.jpg'),
(91, 17, '1552455641_3_0.jpg'),
(92, 17, '1552455641_3_1.jpg'),
(93, 17, '1552455641_3_2.jpg'),
(94, 17, '1552455641_3_3.jpg'),
(95, 17, '1552455641_3_4.jpg'),
(96, 18, '1552456278_3_0.jpg'),
(97, 18, '1552456285_3_0.jpg'),
(98, 18, '1552456285_3_1.jpg'),
(99, 18, '1552456285_3_2.jpg'),
(100, 18, '1552456285_3_3.jpg'),
(101, 19, '1552456807_3_0.jpg'),
(102, 19, '1552456807_3_1.jpg'),
(103, 19, '1552456807_3_2.jpg'),
(104, 19, '1552456807_3_3.jpg'),
(105, 19, '1552456807_3_4.jpg'),
(106, 20, '1552457559_3_0.jpg'),
(107, 20, '1552457559_3_1.jpg'),
(108, 20, '1552457559_3_2.jpg'),
(109, 20, '1552457559_3_3.jpg'),
(110, 20, '1552457559_3_4.jpg'),
(111, 21, '1552458593_3_0.jpg'),
(112, 21, '1552458593_3_1.jpg'),
(113, 21, '1552458593_3_2.jpg'),
(114, 21, '1552458593_3_3.jpg'),
(115, 21, '1552458593_3_4.jpg'),
(116, 22, '1552459419_3_0.jpg'),
(117, 22, '1552459419_3_1.jpg'),
(118, 22, '1552459419_3_2.jpg'),
(119, 22, '1552459419_3_3.jpg'),
(120, 22, '1552459419_3_4.jpg'),
(121, 23, '1552461277_3_0.jpg'),
(122, 23, '1552461277_3_1.jpg'),
(123, 23, '1552461277_3_2.jpg'),
(124, 23, '1552461277_3_3.jpg'),
(125, 23, '1552461281_3_0.jpg'),
(126, 24, '1552463146_3_0.jpg'),
(127, 24, '1552463146_3_1.jpg'),
(128, 24, '1552463146_3_2.jpg'),
(129, 24, '1552463146_3_3.jpg'),
(130, 24, '1552463146_3_4.jpg'),
(131, 25, '1552463773_3_0.jpg'),
(132, 25, '1552463773_3_1.jpg'),
(133, 25, '1552463773_3_2.jpg'),
(134, 25, '1552463773_3_3.jpg'),
(135, 25, '1552463773_3_4.jpg'),
(136, 26, '1552469861_3_0.jpg'),
(137, 26, '1552469861_3_1.jpg'),
(138, 26, '1552469861_3_2.jpg'),
(139, 26, '1552469861_3_3.jpg'),
(140, 26, '1552469861_3_4.jpg'),
(141, 27, '1552470942_3_0.jpg'),
(142, 27, '1552470942_3_1.jpg'),
(143, 27, '1552470942_3_2.jpg'),
(144, 27, '1552470942_3_3.jpg'),
(145, 27, '1552470942_3_4.jpg'),
(146, 28, '1552471794_3_0.jpg'),
(147, 28, '1552471794_3_1.jpg'),
(148, 28, '1552471794_3_2.jpg'),
(149, 28, '1552471794_3_3.jpg'),
(150, 28, '1552471794_3_4.jpg'),
(151, 29, '1552472430_3_0.jpg'),
(152, 29, '1552472430_3_1.jpg'),
(153, 29, '1552472430_3_2.jpg'),
(154, 29, '1552472430_3_3.jpg'),
(155, 29, '1552472430_3_4.jpg'),
(156, 30, '1552473126_3_0.jpg'),
(157, 30, '1552473126_3_1.jpg'),
(158, 30, '1552473126_3_2.jpg'),
(159, 30, '1552473126_3_3.jpg'),
(160, 30, '1552473126_3_4.jpg'),
(161, 31, '1552477519_4_0.jpg'),
(162, 31, '1552477529_4_0.jpg'),
(163, 32, '1552479408_2_0.jpg'),
(164, 32, '1552479408_2_1.jpg'),
(165, 32, '1552479408_2_2.jpg'),
(166, 32, '1552479408_2_3.jpg'),
(167, 32, '1552479408_2_4.jpg'),
(168, 33, '1552545773_2_0.jpg'),
(169, 33, '1552545773_2_1.jpg'),
(170, 33, '1552545773_2_2.jpg'),
(171, 33, '1552545773_2_3.jpg'),
(172, 33, '1552545773_2_4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hts_privileges`
--

CREATE TABLE `hts_privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `action_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_profilereports`
--

CREATE TABLE `hts_profilereports` (
  `id` int(11) NOT NULL,
  `report_type` enum('profile','list') NOT NULL,
  `report` varchar(60) NOT NULL,
  `shortdesc` varchar(150) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_reportlisting`
--

CREATE TABLE `hts_reportlisting` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `listingid` int(11) NOT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_reservations`
--

CREATE TABLE `hts_reservations` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `hostid` int(11) DEFAULT NULL,
  `listid` int(11) DEFAULT NULL,
  `inquiryid` int(11) DEFAULT NULL,
  `fromdate` int(11) DEFAULT NULL,
  `todate` int(11) DEFAULT NULL,
  `checkin` datetime DEFAULT '0000-00-00 00:00:00',
  `checkout` datetime DEFAULT '0000-00-00 00:00:00',
  `guests` int(3) DEFAULT NULL,
  `pricepernight` varchar(10) DEFAULT NULL,
  `pricedetails` text,
  `totaldays` int(3) DEFAULT NULL,
  `totalhours` int(3) DEFAULT NULL,
  `currencycode` varchar(3) DEFAULT NULL,
  `convertedcurrencycode` varchar(3) DEFAULT NULL,
  `convertedprice` varchar(10) DEFAULT NULL,
  `commissionfees` varchar(10) DEFAULT NULL,
  `servicefees` varchar(10) DEFAULT NULL,
  `cleaningfees` varchar(10) NOT NULL,
  `sitefees` varchar(10) NOT NULL,
  `taxfees` varchar(10) DEFAULT NULL,
  `securityfees` varchar(10) DEFAULT NULL,
  `sdstatus` varchar(10) DEFAULT NULL,
  `total` varchar(10) DEFAULT NULL,
  `booktype` varchar(20) DEFAULT NULL,
  `bookstatus` varchar(20) DEFAULT NULL,
  `cancelby` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `canceldate` int(11) DEFAULT NULL,
  `orderstatus` varchar(20) DEFAULT NULL,
  `claim_status` varchar(20) DEFAULT NULL,
  `other_transaction` text CHARACTER SET utf8,
  `claim_transaction` text,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking` enum('perday','pernight','perhour') NOT NULL DEFAULT 'pernight',
  `hourly_booked` text,
  `timezone` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_reservations`
--

INSERT INTO `hts_reservations` (`id`, `userid`, `hostid`, `listid`, `inquiryid`, `fromdate`, `todate`, `checkin`, `checkout`, `guests`, `pricepernight`, `pricedetails`, `totaldays`, `totalhours`, `currencycode`, `convertedcurrencycode`, `convertedprice`, `commissionfees`, `servicefees`, `cleaningfees`, `sitefees`, `taxfees`, `securityfees`, `sdstatus`, `total`, `booktype`, `bookstatus`, `cancelby`, `canceldate`, `orderstatus`, `claim_status`, `other_transaction`, `claim_transaction`, `cdate`, `booking`, `hourly_booked`, `timezone`) VALUES
(1, 2, 3, 21, 2, 1562716800, 1563148800, '2019-07-10 12:00:00', '2019-07-15 10:00:00', 1, '450', NULL, 5, NULL, 'GBP', 'USD', '0.768258', '54', '50', '50', '405', '225', '500', 'pending', '4600.01', 'request', 'requested', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-13 10:43:59', 'pernight', '12:00*|*10:00', 340),
(2, 3, 2, 3, 3, 1553040000, 1553040000, '2019-03-20 07:00:00', '2019-03-20 12:00:00', 2, '390', NULL, NULL, 5, 'MXN', 'EUR', '21.8852840', '46.8', '15', '20', '351', '234', '200', 'paid', '128.71', 'request', 'refunded', 'Guest', NULL, 'paid', NULL, '{"refund_id":"re_1EDUf8JBMSMXMqdDNsMzVNou","status":"succeeded","amount":9307,"type":"refund","charge":"ch_1EDUefJBMSMXMqdDKF4J4Ig8","currency":"EUR","percentage":22,"cdate":1552474218}', '{"deduct_id":"ch_1EDUfBJBMSMXMqdDPRxYMnyi","status":"succeeded","amount":1960,"type":"charge","currency":"EUR","paid":1960.0000000000002,"cdate":1552474222}', '2019-03-13 10:49:49', 'perhour', '07:00*|*12:00', 53),
(3, 2, 3, 24, 4, 1561939200, 1562284800, '2019-07-01 13:00:00', '2019-07-05 11:00:00', 1, '3000', NULL, 4, NULL, 'RUB', 'USD', '66.038627', '300', '800', '800', '2160', '0', '1800', 'pending', '270.44', 'instant', 'accepted', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-13 10:53:01', 'pernight', '13:00*|*11:00', 347),
(4, 3, 2, 1, 5, 1552780800, 1552867200, '2019-03-17 10:00:00', '2019-03-18 09:00:00', 1, '145', NULL, 1, NULL, 'USD', 'GBP', '1.30164606', '17.4', '5', '5', '29', '17.4', '25', 'pending', '187.31', 'request', 'requested', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-13 10:58:32', 'pernight', '10:00*|*09:00', 97),
(5, 2, 3, 16, 6, 1555545600, 1555718400, '2019-04-18 10:00:00', '2019-04-20 08:00:00', 1, '75', '{"special":null,"week":{"price":80,"days":1},"normal":{"price":"70","days":1},"special_price":null,"special_count":null}', 2, NULL, 'USD', 'USD', '1', '9', '8', '10', '30', '22.5', '100', 'paid', '329.5', 'request', 'declined', 'Host', NULL, 'paid', NULL, '{"refund_id":"re_1EDUqhJBMSMXMqdDf6H4L0TC","status":"succeeded","amount":32950,"type":"refund","charge":"ch_1EDUpvJBMSMXMqdDwOyXyybk","currency":"USD","cdate":1552474935}', NULL, '2019-03-13 11:01:28', 'pernight', '10:00*|*08:00', 250),
(6, 2, 4, 31, 7, 1552262400, 1552435200, '2019-03-11 00:00:00', '2019-03-13 00:00:00', 1, '144', '{"special":null,"week":{"price":155,"days":1},"normal":{"price":"133","days":1},"special_price":null,"special_count":null}', 2, NULL, 'USD', 'USD', '1', '17.28', '5', '5', '57.6', '57.6', '20', 'pending', '450.48', 'instant', 'accepted', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-10 13:15:30', 'pernight', '00:00*|*00:00', 305),
(7, 3, 2, 32, 9, 1552089600, 1552089600, '2019-03-09 15:00:00', '2019-03-09 22:00:00', 1, '550', NULL, NULL, 7, 'USD', 'USD', '1', '66', '30', '50', '693', '962.5', '800', 'pending', '6451.5', 'request', 'claimed', NULL, NULL, 'pending', 'pending', NULL, NULL, '2019-03-01 13:38:55', 'perhour', '15:00*|*22:00', 233),
(8, 3, 2, 12, 10, 1574294400, 1574294400, '2019-11-21 12:00:00', '2019-11-21 18:00:00', 3, '150', NULL, NULL, 6, 'USD', 'USD', '1', '18', '30', '20', '180', '180', '80', 'pending', '1408', 'instant', 'accepted', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-14 05:41:08', 'perhour', '12:00*|*18:00', 304),
(9, 3, 2, 11, 11, 1576627200, 1577059200, '2019-12-18 13:00:00', '2019-12-23 10:00:00', 1, '470', '{"special":null,"week":{"price":500,"days":2},"normal":{"price":"450","days":3},"special_price":null,"special_count":null}', 5, NULL, 'GBP', 'USD', '0.768258', '56.4', '20', '50', '423', '352.5', '700', 'pending', '5143.97', 'request', 'requested', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-14 05:47:13', 'pernight', '13:00*|*10:00', 374),
(10, 3, 2, 13, 12, 1552348800, 1552435200, '2019-03-12 14:00:00', '2019-03-13 13:00:00', 5, '45', '{"special":null,"week":{"price":45,"days":1},"normal":null,"special_price":null,"special_count":null}', 1, NULL, 'GBP', 'USD', '0.768258', '5.4', '5', '3', '9', '6.75', '0', 'pending', '96.51', 'request', 'accepted', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-10 06:06:00', 'pernight', '14:00*|*13:00', 250),
(11, 3, 2, 3, 13, 1551571200, 1551571200, '2019-03-03 19:00:00', '2019-03-03 23:00:00', 1, '380', '{"special":null,"week":{"price":380,"days":1},"normal":null,"special_price":null,"special_count":null}', NULL, 4, 'MXN', 'USD', '19.467376', '45.6', '15', '20', '273.6', '182.4', '200', 'pending', '115.91', 'request', 'requested', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-02-25 06:27:39', 'perhour', '19:00*|*23:00', 53),
(12, 3, 2, 8, 14, 1562803200, 1563062400, '2019-07-11 16:00:00', '2019-07-14 11:00:00', 1, '250', '{"special":null,"week":{"price":200,"days":2},"normal":{"price":"350","days":1},"special_price":null,"special_count":null}', 3, NULL, 'EUR', 'USD', '0.889519', '30', '30', '20', '150', '37.5', '200', 'pending', '1368.72', 'instant', 'accepted', NULL, NULL, 'pending', NULL, NULL, NULL, '2019-03-14 09:50:43', 'pernight', '16:00*|*11:00', 222);

-- --------------------------------------------------------

--
-- Table structure for table `hts_reviews`
--

CREATE TABLE `hts_reviews` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `reservationid` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `review` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `listid` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL,
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_reviews`
--

INSERT INTO `hts_reviews` (`id`, `userid`, `reservationid`, `rating`, `review`, `listid`, `status`, `cdate`) VALUES
(1, 2, 6, 4, 'Hello, I\'m Demo! I\'ve travelled to many places around the world and find the best way to get to know a city is as a local. It\'s my favorite way to travel around Australia', 31, '0', '2019-03-13 13:36:12'),
(2, 3, 7, 5, 'Demo\'s place is located in a great place.... you are next to the metro station, the world\'s largest mall, plenty of restaurants and attractions. The management team is outstanding.', 32, '0', '2019-03-14 05:49:40'),
(3, 3, 10, 4, 'Lvely property wid beautiful views. Quite n isolated..Awesome if u wanna have a "me or we time" wid ur family and friends away from d hustle n bustle of mall road.', 13, '0', '2019-03-14 06:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `hts_roles`
--

CREATE TABLE `hts_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` varchar(150) NOT NULL,
  `priviliges` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_roles`
--

INSERT INTO `hts_roles` (`id`, `name`, `description`, `priviliges`, `created_time`, `status`) VALUES
(1, 'Moderator', 'Moderator has full access like as adimn', '["rolesmanagement","moderator","usermanagement","blockedusermanagement","activehostmanagement","blockedhostmanagement","activelisting","blockedlisting","reviewsmanagement","wishlists","managereports","userreports","listingreport","emailmanagement","sitemanagement","stripesettings","socialloginsettings","mobilesmssettings","footersettings","managecurrency","managelanguages","timezone","googlecodesettings","baseproperties","additionalamenities","commonamenities","hometypes","roomtypes","safetychecklist","specialfeatures","completereservations","incompletereservations","completeclaim","incompleteclaim","commission","sitecharges","tax","invoices","homepagesettings","homepagecountries","buttonslider","helppages","termsandconditions","cancellation"]', '2019-03-12 08:40:09', '0');

-- --------------------------------------------------------

--
-- Table structure for table `hts_roomtype`
--

CREATE TABLE `hts_roomtype` (
  `id` int(11) NOT NULL,
  `roomtype` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_roomtype`
--

INSERT INTO `hts_roomtype` (`id`, `roomtype`, `description`) VALUES
(1, 'Entire Place', 'Have a place to yourself'),
(2, 'Private Room', 'Have your own room and share some common spaces'),
(3, 'Shared Room', 'Stay in a shared space, like a common room');

-- --------------------------------------------------------

--
-- Table structure for table `hts_safetycheck`
--

CREATE TABLE `hts_safetycheck` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_safetycheck`
--

INSERT INTO `hts_safetycheck` (`id`, `name`, `description`, `status`, `cdate`) VALUES
(1, 'Fire extinguisher', 'Check your local laws, which may require a working fire extinguisher in your space', NULL, 1552309129),
(2, 'Carbon monoxide detector', 'Check your local laws, which may require a working carbon monoxide detector in every room', NULL, 1552309155),
(3, 'Smoke detector', 'Check your local laws, which may require a working smoke detector in every room', NULL, 1552309178),
(4, 'First aid kit', 'Check your local laws, which may require a first aid kit, kindly notice that medical kit available.', NULL, 1552309237),
(5, 'Electric Tools', 'Check your local laws, which may require a electrical tools for managing damaged appliances.', NULL, 1552309350);

-- --------------------------------------------------------

--
-- Table structure for table `hts_safetylisting`
--

CREATE TABLE `hts_safetylisting` (
  `id` int(11) NOT NULL,
  `listingid` int(11) DEFAULT NULL,
  `safetyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_safetylisting`
--

INSERT INTO `hts_safetylisting` (`id`, `listingid`, `safetyid`) VALUES
(5, 1, 1),
(6, 1, 3),
(7, 1, 4),
(8, 1, 5),
(14, 2, 1),
(15, 2, 2),
(16, 2, 3),
(17, 2, 4),
(18, 2, 5),
(24, 3, 1),
(25, 3, 2),
(26, 3, 3),
(27, 3, 4),
(28, 3, 5),
(34, 4, 1),
(35, 4, 2),
(36, 4, 3),
(37, 4, 4),
(38, 4, 5),
(42, 5, 1),
(43, 5, 3),
(44, 5, 4),
(48, 6, 4),
(61, 7, 1),
(62, 7, 2),
(63, 7, 3),
(64, 7, 4),
(70, 8, 1),
(71, 8, 2),
(72, 8, 3),
(73, 8, 4),
(74, 8, 5),
(85, 9, 1),
(86, 9, 2),
(87, 9, 3),
(88, 9, 4),
(89, 9, 5),
(95, 10, 1),
(96, 10, 2),
(97, 10, 3),
(98, 10, 4),
(99, 10, 5),
(105, 11, 1),
(106, 11, 2),
(107, 11, 3),
(108, 11, 4),
(109, 11, 5),
(115, 12, 1),
(116, 12, 2),
(117, 12, 3),
(118, 12, 4),
(119, 12, 5),
(125, 13, 1),
(126, 13, 2),
(127, 13, 3),
(128, 13, 4),
(129, 13, 5),
(135, 14, 1),
(136, 14, 2),
(137, 14, 3),
(138, 14, 4),
(139, 14, 5),
(145, 15, 1),
(146, 15, 2),
(147, 15, 3),
(148, 15, 4),
(149, 15, 5),
(155, 16, 1),
(156, 16, 2),
(157, 16, 3),
(158, 16, 4),
(159, 16, 5),
(165, 17, 1),
(166, 17, 2),
(167, 17, 3),
(168, 17, 4),
(169, 17, 5),
(175, 18, 1),
(176, 18, 2),
(177, 18, 3),
(178, 18, 4),
(179, 18, 5),
(184, 19, 1),
(185, 19, 3),
(186, 19, 4),
(187, 19, 5),
(193, 20, 1),
(194, 20, 2),
(195, 20, 3),
(196, 20, 4),
(197, 20, 5),
(203, 21, 1),
(204, 21, 2),
(205, 21, 3),
(206, 21, 4),
(207, 21, 5),
(213, 22, 1),
(214, 22, 2),
(215, 22, 3),
(216, 22, 4),
(217, 22, 5),
(222, 23, 1),
(223, 23, 2),
(224, 23, 3),
(225, 23, 4),
(230, 24, 1),
(231, 24, 2),
(232, 24, 3),
(233, 24, 4),
(239, 25, 1),
(240, 25, 2),
(241, 25, 3),
(242, 25, 4),
(243, 25, 5),
(247, 26, 1),
(248, 26, 4),
(249, 26, 5),
(255, 27, 1),
(256, 27, 2),
(257, 27, 3),
(258, 27, 4),
(259, 27, 5),
(265, 28, 1),
(266, 28, 2),
(267, 28, 3),
(268, 28, 4),
(269, 28, 5),
(275, 29, 1),
(276, 29, 2),
(277, 29, 3),
(278, 29, 4),
(279, 29, 5),
(290, 30, 1),
(291, 30, 2),
(292, 30, 3),
(293, 30, 4),
(294, 30, 5),
(297, 31, 1),
(298, 31, 2),
(303, 32, 1),
(304, 32, 2),
(305, 32, 3),
(306, 32, 4),
(312, 33, 1),
(313, 33, 2),
(314, 33, 3),
(315, 33, 4),
(316, 33, 5);

-- --------------------------------------------------------

--
-- Table structure for table `hts_shippingaddress`
--

CREATE TABLE `hts_shippingaddress` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `address1` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `address2` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `country` int(3) DEFAULT NULL,
  `zipcode` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_shippingaddress`
--

INSERT INTO `hts_shippingaddress` (`id`, `userid`, `address1`, `address2`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 2, '6/1, Kamala First Street', 'Chinna Chokkichulam', 'Madurai', 'Tamil Nadu', 100, '625003'),
(2, 4, 'Tallakulam', 'chinna chokkikulam', 'Madurai', 'TAMILNADU', 100, '625002');

-- --------------------------------------------------------

--
-- Table structure for table `hts_sitecharge`
--

CREATE TABLE `hts_sitecharge` (
  `id` int(11) NOT NULL,
  `min_value` varchar(15) DEFAULT NULL,
  `max_value` varchar(15) DEFAULT NULL,
  `percentage` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_sitecharge`
--

INSERT INTO `hts_sitecharge` (`id`, `min_value`, `max_value`, `percentage`) VALUES
(1, '1', '1000', '20'),
(2, '1000', '50000', '18'),
(3, '50000', '500000', '12'),
(4, '500000', '9999000', '10');

-- --------------------------------------------------------

--
-- Table structure for table `hts_sitesettings`
--

CREATE TABLE `hts_sitesettings` (
  `id` int(11) NOT NULL,
  `sitename` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sitetitle` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `metakey` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `metadesc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `welcomeemail` enum('yes','no') DEFAULT NULL,
  `signupactive` enum('yes','no') DEFAULT NULL,
  `supportemail` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `noreplyname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `noreplyemail` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `noreplypassword` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `gmail_smtp` enum('enable','disable') DEFAULT NULL,
  `smtp_port` int(5) DEFAULT NULL,
  `medial_url` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `media_server_hostname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `media_server_username` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `media_server_password` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sitelogoblack` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sitelogowhite` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `defaultuserimage` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `defaultfavicon` varchar(20) DEFAULT NULL,
  `paymenttype` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `paypaladaptive` text CHARACTER SET utf8,
  `paypalid` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `stripe_publishkey` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `stripe_secretkey` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `stripe_host_support_country` text,
  `stripe_card_details` text,
  `stripeid` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stripekey` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `loginkey` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `transactionkey` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `braintreepaymenttype` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `braintreemerchantid` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `braintreepublickey` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `braintreeprivatekey` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sitechanges` text CHARACTER SET utf8,
  `footercontent` text CHARACTER SET utf8,
  `footeractive` enum('yes','no') DEFAULT NULL,
  `commission_percentage` int(3) DEFAULT NULL,
  `socialid` text CHARACTER SET utf8,
  `gender` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `pricerange` varchar(10) DEFAULT NULL,
  `googleapikey` varchar(100) DEFAULT NULL,
  `googleanalyticsactive` enum('no','yes') DEFAULT NULL,
  `googleanalyticscode` text,
  `google_webmaster_link` varchar(150) NOT NULL,
  `hour_booking` enum('yes','no') NOT NULL DEFAULT 'no',
  `autoupdate_currency` int(2) NOT NULL COMMENT '0-disable,1-enable',
  `fcmKey` varchar(255) DEFAULT NULL,
  `smssettings` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_sitesettings`
--

INSERT INTO `hts_sitesettings` (`id`, `sitename`, `sitetitle`, `metakey`, `metadesc`, `welcomeemail`, `signupactive`, `supportemail`, `noreplyname`, `noreplyemail`, `noreplypassword`, `gmail_smtp`, `smtp_port`, `medial_url`, `media_server_hostname`, `media_server_username`, `media_server_password`, `sitelogoblack`, `sitelogowhite`, `defaultuserimage`, `defaultfavicon`, `paymenttype`, `paypaladaptive`, `paypalid`, `stripe_publishkey`, `stripe_secretkey`, `stripe_host_support_country`, `stripe_card_details`, `stripeid`, `stripekey`, `loginkey`, `transactionkey`, `braintreepaymenttype`, `braintreemerchantid`, `braintreepublickey`, `braintreeprivatekey`, `sitechanges`, `footercontent`, `footeractive`, `commission_percentage`, `socialid`, `gender`, `pricerange`, `googleapikey`, `googleanalyticsactive`, `googleanalyticscode`, `google_webmaster_link`, `hour_booking`, `autoupdate_currency`, `fcmKey`, `smssettings`) VALUES
(1, 'AirFinch', 'AirFinch', 'rooms for rent,apartments for rents', 'Online website for booking room for rent', 'yes', NULL, 'noreply@hitasoft.com', 'noreply', 'noreply@hitasoft.com', 'noreplyhitasoft', 'enable', 1121, NULL, NULL, NULL, NULL, 'logoblack.png', 'logowhite.png', 'usrimg.jpg', 'favicon.png', 'sandbox', '{"paymentMode":"adaptive","apiUserId":"yaminib-facilitator_api1.hitasoft.com","apiPassword":"3YSLBKTGGYNAYZN4","apiSignature":"AFcWxV21C7fd0v3bYYYRCpSSRl31AzMvUtELLgU7L8bDp89CBwS7CL2I","apiApplicationId":"APP-80W284485P519543T"}', 'rajahussian@yahoo.com', 'pk_test_t1NRFN3qGNDIvSL69OEW7M6q', 'sk_test_CDDjV7z3BbUNYHhb4H37sIui', '["AU~AUD~Australia", "AT~EUR~Austria", "BE~EUR~Belgium", "CA~CAD~Canada", "DK~DKK~Denmark", "FI~EUR~Finland", "FR~EUR~France", "DE~EUR~Germany", "HK~HKD~Hong Kong", "IE~EUR~Ireland", "IT~EUR~Italy", "LU~EUR~Luxembourg", "NL~EUR~Netherlands", "NZ~NZD~New Zealand", "NO~NOK~Norway", "PT~EUR~Portugal", "SG~SGD~Singapore", "ES~EUR~Spain", "SE~SEK~Sweden", "CH~CHF~Switzerland", "GB~GBP~United Kingdom", "US~USD~United States"]', '{"stripe_card":"4242424242424242","stripe_month":"8","stripe_year":"2020","stripe_cvc":"314","stripe_hostpaydays":"5"}', NULL, NULL, NULL, NULL, 'sandbox', 'wd6v9yqp6syfxwnx', 'zbv82z73szs82hyd', 'a88e10291a97c6ce89512a698d4109d8', NULL, '{"facebookLink":"https:\\/\\/www.facebook.com\\/bedforest\\/","googleLink":"https:\\/\\/plus.google.com\\/u\\/0\\/118220092516248577075\\/","twitterLink":"https:\\/\\/twitter.com\\/hitasoft_\\/","linkedinLink":"https:\\/\\/www.linkedin.com\\/company\\/bedforest\\/","youtubeLink":"https:\\/\\/www.youtube.com\\/","pinterestLink":"https:\\/\\/www.pinterest.com\\/bedforest\\/","instagramLink":"https:\\/\\/www.instagram.com\\/bedforest\\/","address":"kamala 1st street, chinnachokikulam, madurai -625002","phone":"1234567899","email":"info@hitasoft.commm","ioslink":"https:\\/\\/airfinchscript.com","androidlink":"https:\\/\\/airfinchscript.com","androidlinkstatus":"yes","ioslinkstatus":"yes"}', NULL, NULL, '{"facebook":{"status":"1","secret":"9586002d999fc5ec5e9b55cc27248011","appid":"1038770532958761"},"google":{"status":"1","secret":"mHDJQzVsCe9CmRCWh_n4vzB_","appid":"420558747705-shlh0tdlk92mneujpj2du0p3ulv4h67p.apps.googleusercontent.com"},"socialstatus":"1"}', NULL, '', 'AIzaSyBqN_3wtob65prYXsWPGtvaMNzntAzpnes', 'no', 'this is developer test', 'https://www.google.com/webmasters/tools/submit-url?pli=1', 'yes', 1, 'AAAAbR1qxc0:APA91bFbRmxvvABotgqdsnQK6FMCxNzZEegDfgT_hPZQ06onA0CF5kqas65V6S_spbfvfmiWi98IcxLSyX-_sBIgS3OkO2pg94tfadC1G9tAn_XLXruthECPk7NfrJRtb-zG_ICtfi5CjX0JXPfpW3N9JfDQVjUpqQ', '{"facebook":{"secret":"7b137068bd3584fe3506e7da696592f4","appid":"1038770532958761"}}');

-- --------------------------------------------------------

--
-- Table structure for table `hts_specialfeatures`
--

CREATE TABLE `hts_specialfeatures` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `specialimage` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_specialfeatures`
--

INSERT INTO `hts_specialfeatures` (`id`, `name`, `description`, `specialimage`, `status`, `cdate`) VALUES
(1, 'Smoking', 'Smoking allowed', 'additional_1552311479.png', NULL, 1552311480),
(2, 'Pets allowed', 'Pets allowed', 'additional_1552311523.png', NULL, 1552311524),
(3, 'Family/Kid Friendly', 'Family/Kid Friendly atmosphere', 'additional_1552311583.png', NULL, 1552311584),
(4, 'Events', 'Suitable for events', 'additional_1552311636.png', NULL, 1552311638),
(5, 'Wheelchair Accessible', 'Easy access to the building and listing for guests in wheelchairs', 'additional_1552311701.png', NULL, 1552311702);

-- --------------------------------------------------------

--
-- Table structure for table `hts_speciallisting`
--

CREATE TABLE `hts_speciallisting` (
  `id` int(11) NOT NULL,
  `listingid` int(11) DEFAULT NULL,
  `specialid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_speciallisting`
--

INSERT INTO `hts_speciallisting` (`id`, `listingid`, `specialid`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 2),
(7, 2, 3),
(8, 2, 4),
(9, 3, 2),
(10, 3, 3),
(11, 3, 4),
(12, 3, 5),
(13, 4, 2),
(14, 4, 3),
(15, 4, 4),
(16, 5, 1),
(17, 5, 2),
(18, 5, 3),
(19, 6, 1),
(20, 7, 1),
(21, 7, 2),
(22, 7, 3),
(23, 7, 4),
(24, 8, 1),
(25, 8, 2),
(26, 8, 3),
(27, 8, 4),
(28, 8, 5),
(29, 9, 3),
(30, 10, 1),
(31, 10, 2),
(32, 10, 3),
(33, 10, 4),
(34, 10, 5),
(35, 11, 1),
(36, 11, 2),
(37, 11, 3),
(38, 11, 4),
(39, 11, 5),
(40, 12, 1),
(41, 12, 2),
(42, 12, 3),
(43, 12, 4),
(44, 12, 5),
(45, 13, 3),
(46, 13, 4),
(47, 14, 1),
(48, 14, 2),
(49, 14, 3),
(50, 14, 4),
(51, 15, 1),
(52, 15, 2),
(53, 15, 3),
(54, 15, 4),
(55, 15, 5),
(56, 16, 3),
(57, 17, 1),
(58, 17, 3),
(59, 17, 4),
(60, 17, 5),
(61, 18, 1),
(62, 18, 3),
(63, 19, 3),
(64, 20, 1),
(65, 20, 2),
(66, 20, 3),
(67, 20, 4),
(68, 20, 5),
(69, 21, 1),
(70, 21, 2),
(71, 21, 3),
(72, 21, 4),
(73, 22, 1),
(74, 22, 2),
(75, 22, 3),
(76, 22, 4),
(77, 22, 5),
(78, 23, 1),
(79, 23, 2),
(80, 23, 3),
(81, 23, 4),
(82, 24, 1),
(83, 24, 3),
(84, 25, 3),
(85, 26, 3),
(86, 27, 2),
(87, 27, 3),
(88, 27, 4),
(89, 28, 2),
(90, 28, 3),
(91, 28, 4),
(92, 29, 1),
(93, 29, 2),
(94, 29, 3),
(95, 29, 4),
(96, 30, 1),
(97, 30, 2),
(98, 30, 3),
(99, 31, 1),
(100, 31, 2),
(101, 31, 3),
(102, 32, 1),
(103, 32, 2),
(104, 32, 3),
(105, 32, 4),
(106, 32, 5),
(107, 33, 1),
(108, 33, 2),
(109, 33, 3),
(110, 33, 4),
(111, 33, 5);

-- --------------------------------------------------------

--
-- Table structure for table `hts_tax`
--

CREATE TABLE `hts_tax` (
  `id` int(11) NOT NULL,
  `countryid` int(11) DEFAULT NULL,
  `countryname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `taxname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `percentage` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_tax`
--

INSERT INTO `hts_tax` (`id`, `countryid`, `countryname`, `taxname`, `percentage`) VALUES
(1, 100, 'India', 'India Tax Basis', '15'),
(2, 231, 'United Kingdom', 'UK Tax Basis', '10'),
(3, 232, 'United States', 'USA Tax Basis', '12'),
(4, 13, 'Australia', 'Kangroo Tax Basis', '20'),
(5, 212, 'Switzerland', 'Swiss Tax', '15'),
(6, 107, 'Italy', 'Italy Premium Tax', '12'),
(7, 230, 'United Arab Emirates', 'Arab Tax', '25'),
(8, 217, 'Thailand', 'Thai Tax', '5'),
(9, 139, 'Mauritius', 'Mauritin Tax', '8'),
(10, 55, 'Cuba', 'Cuba Tax', '10');

-- --------------------------------------------------------

--
-- Table structure for table `hts_textsliders`
--

CREATE TABLE `hts_textsliders` (
  `id` int(11) NOT NULL,
  `slidertext` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `sliderimage` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_timezone`
--

CREATE TABLE `hts_timezone` (
  `id` int(11) NOT NULL,
  `countryname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `timezone` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
  `zonecode` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_timezone`
--

INSERT INTO `hts_timezone` (`id`, `countryname`, `code`, `timezone`, `zonecode`) VALUES
(1, NULL, 'CI', '(GMT) Africa, Abidjan', 'Africa/Abidjan'),
(2, NULL, 'GH', '(GMT) Africa, Accra', 'Africa/Accra'),
(3, NULL, 'ET', '(GMT+03:00) Africa, Addis Ababa', 'Africa/Addis_Ababa'),
(4, NULL, 'DZ', '(GMT+01:00) Africa, Algiers', 'Africa/Algiers'),
(5, NULL, 'ER', '(GMT+03:00) Africa, Asmara', 'Africa/Asmara'),
(6, NULL, 'ML', '(GMT) Africa, Bamako', 'Africa/Bamako'),
(7, NULL, 'CF', '(GMT+01:00) Africa, Bangui', 'Africa/Bangui'),
(8, NULL, 'GM', '(GMT) Africa, Banjul', 'Africa/Banjul'),
(9, NULL, 'GW', '(GMT) Africa, Bissau', 'Africa/Bissau'),
(10, NULL, 'MW', '(GMT+02:00) Africa, Blantyre', 'Africa/Blantyre'),
(11, NULL, 'CG', '(GMT+01:00) Africa, Brazzaville', 'Africa/Brazzaville'),
(12, NULL, 'BI', '(GMT+02:00) Africa, Bujumbura', 'Africa/Bujumbura'),
(13, NULL, 'EG', '(GMT+02:00) Africa, Cairo', 'Africa/Cairo'),
(14, NULL, 'MA', '(GMT) Africa, Casablanca', 'Africa/Casablanca'),
(15, NULL, 'ES', '(GMT+01:00) Africa, Ceuta', 'Africa/Ceuta'),
(16, NULL, 'GN', '(GMT) Africa, Conakry', 'Africa/Conakry'),
(17, NULL, 'SN', '(GMT) Africa, Dakar', 'Africa/Dakar'),
(18, NULL, 'TZ', '(GMT+03:00) Africa, Dar es Salaam', 'Africa/Dar_es_Salaam'),
(19, NULL, 'DJ', '(GMT+03:00) Africa, Djibouti', 'Africa/Djibouti'),
(20, NULL, 'CM', '(GMT+01:00) Africa, Douala', 'Africa/Douala'),
(21, NULL, 'EH', '(GMT) Africa, El Aaiun', 'Africa/El_Aaiun'),
(22, NULL, 'SL', '(GMT) Africa, Freetown', 'Africa/Freetown'),
(23, NULL, 'BW', '(GMT+02:00) Africa, Gaborone', 'Africa/Gaborone'),
(24, NULL, 'ZW', '(GMT+02:00) Africa, Harare', 'Africa/Harare'),
(25, NULL, 'ZA', '(GMT+02:00) Africa, Johannesburg', 'Africa/Johannesburg'),
(26, NULL, 'SS', '(GMT+03:00) Africa, Juba', 'Africa/Juba'),
(27, NULL, 'UG', '(GMT+03:00) Africa, Kampala', 'Africa/Kampala'),
(28, NULL, 'SD', '(GMT+03:00) Africa, Khartoum', 'Africa/Khartoum'),
(29, NULL, 'RW', '(GMT+02:00) Africa, Kigali', 'Africa/Kigali'),
(30, NULL, 'CD', '(GMT+01:00) Africa, Kinshasa', 'Africa/Kinshasa'),
(31, NULL, 'NG', '(GMT+01:00) Africa, Lagos', 'Africa/Lagos'),
(32, NULL, 'GA', '(GMT+01:00) Africa, Libreville', 'Africa/Libreville'),
(33, NULL, 'TG', '(GMT) Africa, Lome', 'Africa/Lome'),
(34, NULL, 'AO', '(GMT+01:00) Africa, Luanda', 'Africa/Luanda'),
(35, NULL, 'CD', '(GMT+02:00) Africa, Lubumbashi', 'Africa/Lubumbashi'),
(36, NULL, 'ZM', '(GMT+02:00) Africa, Lusaka', 'Africa/Lusaka'),
(37, NULL, 'GQ', '(GMT+01:00) Africa, Malabo', 'Africa/Malabo'),
(38, NULL, 'MZ', '(GMT+02:00) Africa, Maputo', 'Africa/Maputo'),
(39, NULL, 'LS', '(GMT+02:00) Africa, Maseru', 'Africa/Maseru'),
(40, NULL, 'SZ', '(GMT+02:00) Africa, Mbabane', 'Africa/Mbabane'),
(41, NULL, 'SO', '(GMT+03:00) Africa, Mogadishu', 'Africa/Mogadishu'),
(42, NULL, 'LR', '(GMT) Africa, Monrovia', 'Africa/Monrovia'),
(43, NULL, 'KE', '(GMT+03:00) Africa, Nairobi', 'Africa/Nairobi'),
(44, NULL, 'TD', '(GMT+01:00) Africa, Ndjamena', 'Africa/Ndjamena'),
(45, NULL, 'NE', '(GMT+01:00) Africa, Niamey', 'Africa/Niamey'),
(46, NULL, 'MR', '(GMT) Africa, Nouakchott', 'Africa/Nouakchott'),
(47, NULL, 'BF', '(GMT) Africa, Ouagadougou', 'Africa/Ouagadougou'),
(48, NULL, 'BJ', '(GMT+01:00) Africa, Porto-Novo', 'Africa/Porto-Novo'),
(49, NULL, 'ST', '(GMT) Africa, Sao Tome', 'Africa/Sao_Tome'),
(50, NULL, 'LY', '(GMT+02:00) Africa, Tripoli', 'Africa/Tripoli'),
(51, NULL, 'TN', '(GMT+01:00) Africa, Tunis', 'Africa/Tunis'),
(52, NULL, 'NA', '(GMT+02:00) Africa, Windhoek', 'Africa/Windhoek'),
(53, NULL, 'US', '(GMT-10:00) America, Adak', 'America/Adak'),
(54, NULL, 'US', '(GMT-09:00) America, Anchorage', 'America/Anchorage'),
(55, NULL, 'AI', '(GMT-04:00) America, Anguilla', 'America/Anguilla'),
(56, NULL, 'AG', '(GMT-04:00) America, Antigua', 'America/Antigua'),
(57, NULL, 'BR', '(GMT-03:00) America, Araguaina', 'America/Araguaina'),
(58, NULL, 'AR', '(GMT-03:00) America, Argentina, Buenos Aires', 'America/Argentina/Buenos_Aires'),
(59, NULL, 'AR', '(GMT-03:00) America, Argentina, Catamarca', 'America/Argentina/Catamarca'),
(60, NULL, 'AR', '(GMT-03:00) America, Argentina, Cordoba', 'America/Argentina/Cordoba'),
(61, NULL, 'AR', '(GMT-03:00) America, Argentina, Jujuy', 'America/Argentina/Jujuy'),
(62, NULL, 'AR', '(GMT-03:00) America, Argentina, La Rioja', 'America/Argentina/La_Rioja'),
(63, NULL, 'AR', '(GMT-03:00) America, Argentina, Mendoza', 'America/Argentina/Mendoza'),
(64, NULL, 'AR', '(GMT-03:00) America, Argentina, Rio Gallegos', 'America/Argentina/Rio_Gallegos'),
(65, NULL, 'AR', '(GMT-03:00) America, Argentina, Salta', 'America/Argentina/Salta'),
(66, NULL, 'AR', '(GMT-03:00) America, Argentina, San Juan', 'America/Argentina/San_Juan'),
(67, NULL, 'AR', '(GMT-03:00) America, Argentina, San Luis', 'America/Argentina/San_Luis'),
(68, NULL, 'AR', '(GMT-03:00) America, Argentina, Tucuman', 'America/Argentina/Tucuman'),
(69, NULL, 'AR', '(GMT-03:00) America, Argentina, Ushuaia', 'America/Argentina/Ushuaia'),
(70, NULL, 'AW', '(GMT-04:00) America, Aruba', 'America/Aruba'),
(71, NULL, 'PY', '(GMT-03:00) America, Asuncion', 'America/Asuncion'),
(72, NULL, 'CA', '(GMT-05:00) America, Atikokan', 'America/Atikokan'),
(73, NULL, 'BR', '(GMT-03:00) America, Bahia', 'America/Bahia'),
(74, NULL, 'MX', '(GMT-06:00) America, Bahia Banderas', 'America/Bahia_Banderas'),
(75, NULL, 'BB', '(GMT-04:00) America, Barbados', 'America/Barbados'),
(76, NULL, 'BR', '(GMT-03:00) America, Belem', 'America/Belem'),
(77, NULL, 'BZ', '(GMT-06:00) America, Belize', 'America/Belize'),
(78, NULL, 'CA', '(GMT-04:00) America, Blanc-Sablon', 'America/Blanc-Sablon'),
(79, NULL, 'BR', '(GMT-04:00) America, Boa Vista', 'America/Boa_Vista'),
(80, NULL, 'CO', '(GMT-05:00) America, Bogota', 'America/Bogota'),
(81, NULL, 'US', '(GMT-07:00) America, Boise', 'America/Boise'),
(82, NULL, 'CA', '(GMT-07:00) America, Cambridge Bay', 'America/Cambridge_Bay'),
(83, NULL, 'BR', '(GMT-04:00) America, Campo Grande', 'America/Campo_Grande'),
(84, NULL, 'MX', '(GMT-05:00) America, Cancun', 'America/Cancun'),
(85, NULL, 'VE', '(GMT-04:00) America, Caracas', 'America/Caracas'),
(86, NULL, 'GF', '(GMT-03:00) America, Cayenne', 'America/Cayenne'),
(87, NULL, 'KY', '(GMT-05:00) America, Cayman', 'America/Cayman'),
(88, NULL, 'US', '(GMT-06:00) America, Chicago', 'America/Chicago'),
(89, NULL, 'MX', '(GMT-07:00) America, Chihuahua', 'America/Chihuahua'),
(90, NULL, 'CR', '(GMT-06:00) America, Costa Rica', 'America/Costa_Rica'),
(91, NULL, 'CA', '(GMT-07:00) America, Creston', 'America/Creston'),
(92, NULL, 'BR', '(GMT-04:00) America, Cuiaba', 'America/Cuiaba'),
(93, NULL, 'CW', '(GMT-04:00) America, Curacao', 'America/Curacao'),
(94, NULL, 'GL', '(GMT) America, Danmarkshavn', 'America/Danmarkshavn'),
(95, NULL, 'CA', '(GMT-08:00) America, Dawson', 'America/Dawson'),
(96, NULL, 'CA', '(GMT-07:00) America, Dawson Creek', 'America/Dawson_Creek'),
(97, NULL, 'US', '(GMT-07:00) America, Denver', 'America/Denver'),
(98, NULL, 'US', '(GMT-05:00) America, Detroit', 'America/Detroit'),
(99, NULL, 'DM', '(GMT-04:00) America, Dominica', 'America/Dominica'),
(100, NULL, 'CA', '(GMT-07:00) America, Edmonton', 'America/Edmonton'),
(101, NULL, 'BR', '(GMT-05:00) America, Eirunepe', 'America/Eirunepe'),
(102, NULL, 'SV', '(GMT-06:00) America, El Salvador', 'America/El_Salvador'),
(103, NULL, 'CA', '(GMT-07:00) America, Fort Nelson', 'America/Fort_Nelson'),
(104, NULL, 'BR', '(GMT-03:00) America, Fortaleza', 'America/Fortaleza'),
(105, NULL, 'CA', '(GMT-04:00) America, Glace Bay', 'America/Glace_Bay'),
(106, NULL, 'GL', '(GMT-03:00) America, Godthab', 'America/Godthab'),
(107, NULL, 'CA', '(GMT-04:00) America, Goose Bay', 'America/Goose_Bay'),
(108, NULL, 'TC', '(GMT-04:00) America, Grand Turk', 'America/Grand_Turk'),
(109, NULL, 'GD', '(GMT-04:00) America, Grenada', 'America/Grenada'),
(110, NULL, 'GP', '(GMT-04:00) America, Guadeloupe', 'America/Guadeloupe'),
(111, NULL, 'GT', '(GMT-06:00) America, Guatemala', 'America/Guatemala'),
(112, NULL, 'EC', '(GMT-05:00) America, Guayaquil', 'America/Guayaquil'),
(113, NULL, 'GY', '(GMT-04:00) America, Guyana', 'America/Guyana'),
(114, NULL, 'CA', '(GMT-04:00) America, Halifax', 'America/Halifax'),
(115, NULL, 'CU', '(GMT-05:00) America, Havana', 'America/Havana'),
(116, NULL, 'MX', '(GMT-07:00) America, Hermosillo', 'America/Hermosillo'),
(117, NULL, 'US', '(GMT-05:00) America, Indiana, Indianapolis', 'America/Indiana/Indianapolis'),
(118, NULL, 'US', '(GMT-06:00) America, Indiana, Knox', 'America/Indiana/Knox'),
(119, NULL, 'US', '(GMT-05:00) America, Indiana, Marengo', 'America/Indiana/Marengo'),
(120, NULL, 'US', '(GMT-05:00) America, Indiana, Petersburg', 'America/Indiana/Petersburg'),
(121, NULL, 'US', '(GMT-06:00) America, Indiana, Tell City', 'America/Indiana/Tell_City'),
(122, NULL, 'US', '(GMT-05:00) America, Indiana, Vevay', 'America/Indiana/Vevay'),
(123, NULL, 'US', '(GMT-05:00) America, Indiana, Vincennes', 'America/Indiana/Vincennes'),
(124, NULL, 'US', '(GMT-05:00) America, Indiana, Winamac', 'America/Indiana/Winamac'),
(125, NULL, 'CA', '(GMT-07:00) America, Inuvik', 'America/Inuvik'),
(126, NULL, 'CA', '(GMT-05:00) America, Iqaluit', 'America/Iqaluit'),
(127, NULL, 'JM', '(GMT-05:00) America, Jamaica', 'America/Jamaica'),
(128, NULL, 'US', '(GMT-09:00) America, Juneau', 'America/Juneau'),
(129, NULL, 'US', '(GMT-05:00) America, Kentucky, Louisville', 'America/Kentucky/Louisville'),
(130, NULL, 'US', '(GMT-05:00) America, Kentucky, Monticello', 'America/Kentucky/Monticello'),
(131, NULL, 'BQ', '(GMT-04:00) America, Kralendijk', 'America/Kralendijk'),
(132, NULL, 'BO', '(GMT-04:00) America, La Paz', 'America/La_Paz'),
(133, NULL, 'PE', '(GMT-05:00) America, Lima', 'America/Lima'),
(134, NULL, 'US', '(GMT-08:00) America, Los Angeles', 'America/Los_Angeles'),
(135, NULL, 'SX', '(GMT-04:00) America, Lower Princes', 'America/Lower_Princes'),
(136, NULL, 'BR', '(GMT-03:00) America, Maceio', 'America/Maceio'),
(137, NULL, 'NI', '(GMT-06:00) America, Managua', 'America/Managua'),
(138, NULL, 'BR', '(GMT-04:00) America, Manaus', 'America/Manaus'),
(139, NULL, 'MF', '(GMT-04:00) America, Marigot', 'America/Marigot'),
(140, NULL, 'MQ', '(GMT-04:00) America, Martinique', 'America/Martinique'),
(141, NULL, 'MX', '(GMT-06:00) America, Matamoros', 'America/Matamoros'),
(142, NULL, 'MX', '(GMT-07:00) America, Mazatlan', 'America/Mazatlan'),
(143, NULL, 'US', '(GMT-06:00) America, Menominee', 'America/Menominee'),
(144, NULL, 'MX', '(GMT-06:00) America, Merida', 'America/Merida'),
(145, NULL, 'US', '(GMT-09:00) America, Metlakatla', 'America/Metlakatla'),
(146, NULL, 'MX', '(GMT-06:00) America, Mexico City', 'America/Mexico_City'),
(147, NULL, 'PM', '(GMT-03:00) America, Miquelon', 'America/Miquelon'),
(148, NULL, 'CA', '(GMT-04:00) America, Moncton', 'America/Moncton'),
(149, NULL, 'MX', '(GMT-06:00) America, Monterrey', 'America/Monterrey'),
(150, NULL, 'UY', '(GMT-03:00) America, Montevideo', 'America/Montevideo'),
(151, NULL, 'MS', '(GMT-04:00) America, Montserrat', 'America/Montserrat'),
(152, NULL, 'BS', '(GMT-05:00) America, Nassau', 'America/Nassau'),
(153, NULL, 'US', '(GMT-05:00) America, New York', 'America/New_York'),
(154, NULL, 'CA', '(GMT-05:00) America, Nipigon', 'America/Nipigon'),
(155, NULL, 'US', '(GMT-09:00) America, Nome', 'America/Nome'),
(156, NULL, 'BR', '(GMT-02:00) America, Noronha', 'America/Noronha'),
(157, NULL, 'US', '(GMT-06:00) America, North Dakota, Beulah', 'America/North_Dakota/Beulah'),
(158, NULL, 'US', '(GMT-06:00) America, North Dakota, Center', 'America/North_Dakota/Center'),
(159, NULL, 'US', '(GMT-06:00) America, North Dakota, New Salem', 'America/North_Dakota/New_Salem'),
(160, NULL, 'MX', '(GMT-07:00) America, Ojinaga', 'America/Ojinaga'),
(161, NULL, 'PA', '(GMT-05:00) America, Panama', 'America/Panama'),
(162, NULL, 'CA', '(GMT-05:00) America, Pangnirtung', 'America/Pangnirtung'),
(163, NULL, 'SR', '(GMT-03:00) America, Paramaribo', 'America/Paramaribo'),
(164, NULL, 'US', '(GMT-07:00) America, Phoenix', 'America/Phoenix'),
(165, NULL, 'HT', '(GMT-05:00) America, Port-au-Prince', 'America/Port-au-Prince'),
(166, NULL, 'TT', '(GMT-04:00) America, Port of Spain', 'America/Port_of_Spain'),
(167, NULL, 'BR', '(GMT-04:00) America, Porto Velho', 'America/Porto_Velho'),
(168, NULL, 'PR', '(GMT-04:00) America, Puerto Rico', 'America/Puerto_Rico'),
(169, NULL, 'CA', '(GMT-06:00) America, Rainy River', 'America/Rainy_River'),
(170, NULL, 'CA', '(GMT-06:00) America, Rankin Inlet', 'America/Rankin_Inlet'),
(171, NULL, 'BR', '(GMT-03:00) America, Recife', 'America/Recife'),
(172, NULL, 'CA', '(GMT-06:00) America, Regina', 'America/Regina'),
(173, NULL, 'CA', '(GMT-06:00) America, Resolute', 'America/Resolute'),
(174, NULL, 'BR', '(GMT-05:00) America, Rio Branco', 'America/Rio_Branco'),
(175, NULL, 'BR', '(GMT-03:00) America, Santarem', 'America/Santarem'),
(176, NULL, 'CL', '(GMT-03:00) America, Santiago', 'America/Santiago'),
(177, NULL, 'DO', '(GMT-04:00) America, Santo Domingo', 'America/Santo_Domingo'),
(178, NULL, 'BR', '(GMT-03:00) America, Sao Paulo', 'America/Sao_Paulo'),
(179, NULL, 'GL', '(GMT-01:00) America, Scoresbysund', 'America/Scoresbysund'),
(180, NULL, 'US', '(GMT-09:00) America, Sitka', 'America/Sitka'),
(181, NULL, 'BL', '(GMT-04:00) America, St. Barthelemy', 'America/St_Barthelemy'),
(182, NULL, 'CA', '(GMT-03:30) America, St. Johns', 'America/St_Johns'),
(183, NULL, 'KN', '(GMT-04:00) America, St. Kitts', 'America/St_Kitts'),
(184, NULL, 'LC', '(GMT-04:00) America, St. Lucia', 'America/St_Lucia'),
(185, NULL, 'VI', '(GMT-04:00) America, St. Thomas', 'America/St_Thomas'),
(186, NULL, 'VC', '(GMT-04:00) America, St. Vincent', 'America/St_Vincent'),
(187, NULL, 'CA', '(GMT-06:00) America, Swift Current', 'America/Swift_Current'),
(188, NULL, 'HN', '(GMT-06:00) America, Tegucigalpa', 'America/Tegucigalpa'),
(189, NULL, 'GL', '(GMT-04:00) America, Thule', 'America/Thule'),
(190, NULL, 'CA', '(GMT-05:00) America, Thunder Bay', 'America/Thunder_Bay'),
(191, NULL, 'MX', '(GMT-08:00) America, Tijuana', 'America/Tijuana'),
(192, NULL, 'CA', '(GMT-05:00) America, Toronto', 'America/Toronto'),
(193, NULL, 'VG', '(GMT-04:00) America, Tortola', 'America/Tortola'),
(194, NULL, 'CA', '(GMT-08:00) America, Vancouver', 'America/Vancouver'),
(195, NULL, 'CA', '(GMT-08:00) America, Whitehorse', 'America/Whitehorse'),
(196, NULL, 'CA', '(GMT-06:00) America, Winnipeg', 'America/Winnipeg'),
(197, NULL, 'US', '(GMT-09:00) America, Yakutat', 'America/Yakutat'),
(198, NULL, 'CA', '(GMT-07:00) America, Yellowknife', 'America/Yellowknife'),
(199, NULL, 'AQ', '(GMT+11:00) Antarctica, Casey', 'Antarctica/Casey'),
(200, NULL, 'AQ', '(GMT+07:00) Antarctica, Davis', 'Antarctica/Davis'),
(201, NULL, 'AQ', '(GMT+10:00) Antarctica, DumontDUrville', 'Antarctica/DumontDUrville'),
(202, NULL, 'AU', '(GMT+11:00) Antarctica, Macquarie', 'Antarctica/Macquarie'),
(203, NULL, 'AQ', '(GMT+05:00) Antarctica, Mawson', 'Antarctica/Mawson'),
(204, NULL, 'AQ', '(GMT+13:00) Antarctica, McMurdo', 'Antarctica/McMurdo'),
(205, NULL, 'AQ', '(GMT-03:00) Antarctica, Palmer', 'Antarctica/Palmer'),
(206, NULL, 'AQ', '(GMT-03:00) Antarctica, Rothera', 'Antarctica/Rothera'),
(207, NULL, 'AQ', '(GMT+03:00) Antarctica, Syowa', 'Antarctica/Syowa'),
(208, NULL, 'AQ', '(GMT) Antarctica, Troll', 'Antarctica/Troll'),
(209, NULL, 'AQ', '(GMT+06:00) Antarctica, Vostok', 'Antarctica/Vostok'),
(210, NULL, 'SJ', '(GMT+01:00) Arctic, Longyearbyen', 'Arctic/Longyearbyen'),
(211, NULL, 'YE', '(GMT+03:00) Asia, Aden', 'Asia/Aden'),
(212, NULL, 'KZ', '(GMT+06:00) Asia, Almaty', 'Asia/Almaty'),
(213, NULL, 'JO', '(GMT+02:00) Asia, Amman', 'Asia/Amman'),
(214, NULL, 'RU', '(GMT+12:00) Asia, Anadyr', 'Asia/Anadyr'),
(215, NULL, 'KZ', '(GMT+05:00) Asia, Aqtau', 'Asia/Aqtau'),
(216, NULL, 'KZ', '(GMT+05:00) Asia, Aqtobe', 'Asia/Aqtobe'),
(217, NULL, 'TM', '(GMT+05:00) Asia, Ashgabat', 'Asia/Ashgabat'),
(218, NULL, 'KZ', '(GMT+05:00) Asia, Atyrau', 'Asia/Atyrau'),
(219, NULL, 'IQ', '(GMT+03:00) Asia, Baghdad', 'Asia/Baghdad'),
(220, NULL, 'BH', '(GMT+03:00) Asia, Bahrain', 'Asia/Bahrain'),
(221, NULL, 'AZ', '(GMT+04:00) Asia, Baku', 'Asia/Baku'),
(222, NULL, 'TH', '(GMT+07:00) Asia, Bangkok', 'Asia/Bangkok'),
(223, NULL, 'RU', '(GMT+07:00) Asia, Barnaul', 'Asia/Barnaul'),
(224, NULL, 'LB', '(GMT+02:00) Asia, Beirut', 'Asia/Beirut'),
(225, NULL, 'KG', '(GMT+06:00) Asia, Bishkek', 'Asia/Bishkek'),
(226, NULL, 'BN', '(GMT+08:00) Asia, Brunei', 'Asia/Brunei'),
(227, NULL, 'RU', '(GMT+09:00) Asia, Chita', 'Asia/Chita'),
(228, NULL, 'MN', '(GMT+08:00) Asia, Choibalsan', 'Asia/Choibalsan'),
(229, NULL, 'LK', '(GMT+05:30) Asia, Colombo', 'Asia/Colombo'),
(230, NULL, 'SY', '(GMT+02:00) Asia, Damascus', 'Asia/Damascus'),
(231, NULL, 'BD', '(GMT+06:00) Asia, Dhaka', 'Asia/Dhaka'),
(232, NULL, 'TL', '(GMT+09:00) Asia, Dili', 'Asia/Dili'),
(233, NULL, 'AE', '(GMT+04:00) Asia, Dubai', 'Asia/Dubai'),
(234, NULL, 'TJ', '(GMT+05:00) Asia, Dushanbe', 'Asia/Dushanbe'),
(235, NULL, 'CY', '(GMT+03:00) Asia, Famagusta', 'Asia/Famagusta'),
(236, NULL, 'PS', '(GMT+02:00) Asia, Gaza', 'Asia/Gaza'),
(237, NULL, 'PS', '(GMT+02:00) Asia, Hebron', 'Asia/Hebron'),
(238, NULL, 'VN', '(GMT+07:00) Asia, Ho Chi Minh', 'Asia/Ho_Chi_Minh'),
(239, NULL, 'HK', '(GMT+08:00) Asia, Hong Kong', 'Asia/Hong_Kong'),
(240, NULL, 'MN', '(GMT+07:00) Asia, Hovd', 'Asia/Hovd'),
(241, NULL, 'RU', '(GMT+08:00) Asia, Irkutsk', 'Asia/Irkutsk'),
(242, NULL, 'ID', '(GMT+07:00) Asia, Jakarta', 'Asia/Jakarta'),
(243, NULL, 'ID', '(GMT+09:00) Asia, Jayapura', 'Asia/Jayapura'),
(244, NULL, 'IL', '(GMT+02:00) Asia, Jerusalem', 'Asia/Jerusalem'),
(245, NULL, 'AF', '(GMT+04:30) Asia, Kabul', 'Asia/Kabul'),
(246, NULL, 'RU', '(GMT+12:00) Asia, Kamchatka', 'Asia/Kamchatka'),
(247, NULL, 'PK', '(GMT+05:00) Asia, Karachi', 'Asia/Karachi'),
(248, NULL, 'NP', '(GMT+05:45) Asia, Kathmandu', 'Asia/Kathmandu'),
(249, NULL, 'RU', '(GMT+09:00) Asia, Khandyga', 'Asia/Khandyga'),
(250, NULL, 'IN', '(GMT+05:30) Asia, Kolkata', 'Asia/Kolkata'),
(251, NULL, 'RU', '(GMT+07:00) Asia, Krasnoyarsk', 'Asia/Krasnoyarsk'),
(252, NULL, 'MY', '(GMT+08:00) Asia, Kuala Lumpur', 'Asia/Kuala_Lumpur'),
(253, NULL, 'MY', '(GMT+08:00) Asia, Kuching', 'Asia/Kuching'),
(254, NULL, 'KW', '(GMT+03:00) Asia, Kuwait', 'Asia/Kuwait'),
(255, NULL, 'MO', '(GMT+08:00) Asia, Macau', 'Asia/Macau'),
(256, NULL, 'RU', '(GMT+11:00) Asia, Magadan', 'Asia/Magadan'),
(257, NULL, 'ID', '(GMT+08:00) Asia, Makassar', 'Asia/Makassar'),
(258, NULL, 'PH', '(GMT+08:00) Asia, Manila', 'Asia/Manila'),
(259, NULL, 'OM', '(GMT+04:00) Asia, Muscat', 'Asia/Muscat'),
(260, NULL, 'CY', '(GMT+02:00) Asia, Nicosia', 'Asia/Nicosia'),
(261, NULL, 'RU', '(GMT+07:00) Asia, Novokuznetsk', 'Asia/Novokuznetsk'),
(262, NULL, 'RU', '(GMT+07:00) Asia, Novosibirsk', 'Asia/Novosibirsk'),
(263, NULL, 'RU', '(GMT+06:00) Asia, Omsk', 'Asia/Omsk'),
(264, NULL, 'KZ', '(GMT+05:00) Asia, Oral', 'Asia/Oral'),
(265, NULL, 'KH', '(GMT+07:00) Asia, Phnom Penh', 'Asia/Phnom_Penh'),
(266, NULL, 'ID', '(GMT+07:00) Asia, Pontianak', 'Asia/Pontianak'),
(267, NULL, 'KP', '(GMT+08:30) Asia, Pyongyang', 'Asia/Pyongyang'),
(268, NULL, 'QA', '(GMT+03:00) Asia, Qatar', 'Asia/Qatar'),
(269, NULL, 'KZ', '(GMT+06:00) Asia, Qyzylorda', 'Asia/Qyzylorda'),
(270, NULL, 'SA', '(GMT+03:00) Asia, Riyadh', 'Asia/Riyadh'),
(271, NULL, 'RU', '(GMT+11:00) Asia, Sakhalin', 'Asia/Sakhalin'),
(272, NULL, 'UZ', '(GMT+05:00) Asia, Samarkand', 'Asia/Samarkand'),
(273, NULL, 'KR', '(GMT+09:00) Asia, Seoul', 'Asia/Seoul'),
(274, NULL, 'CN', '(GMT+08:00) Asia, Shanghai', 'Asia/Shanghai'),
(275, NULL, 'SG', '(GMT+08:00) Asia, Singapore', 'Asia/Singapore'),
(276, NULL, 'RU', '(GMT+11:00) Asia, Srednekolymsk', 'Asia/Srednekolymsk'),
(277, NULL, 'TW', '(GMT+08:00) Asia, Taipei', 'Asia/Taipei'),
(278, NULL, 'UZ', '(GMT+05:00) Asia, Tashkent', 'Asia/Tashkent'),
(279, NULL, 'GE', '(GMT+04:00) Asia, Tbilisi', 'Asia/Tbilisi'),
(280, NULL, 'IR', '(GMT+03:30) Asia, Tehran', 'Asia/Tehran'),
(281, NULL, 'BT', '(GMT+06:00) Asia, Thimphu', 'Asia/Thimphu'),
(282, NULL, 'JP', '(GMT+09:00) Asia, Tokyo', 'Asia/Tokyo'),
(283, NULL, 'RU', '(GMT+07:00) Asia, Tomsk', 'Asia/Tomsk'),
(284, NULL, 'MN', '(GMT+08:00) Asia, Ulaanbaatar', 'Asia/Ulaanbaatar'),
(285, NULL, 'CN', '(GMT+06:00) Asia, Urumqi', 'Asia/Urumqi'),
(286, NULL, 'RU', '(GMT+10:00) Asia, Ust-Nera', 'Asia/Ust-Nera'),
(287, NULL, 'LA', '(GMT+07:00) Asia, Vientiane', 'Asia/Vientiane'),
(288, NULL, 'RU', '(GMT+10:00) Asia, Vladivostok', 'Asia/Vladivostok'),
(289, NULL, 'RU', '(GMT+09:00) Asia, Yakutsk', 'Asia/Yakutsk'),
(290, NULL, 'MM', '(GMT+06:30) Asia, Yangon', 'Asia/Yangon'),
(291, NULL, 'RU', '(GMT+05:00) Asia, Yekaterinburg', 'Asia/Yekaterinburg'),
(292, NULL, 'AM', '(GMT+04:00) Asia, Yerevan', 'Asia/Yerevan'),
(293, NULL, 'PT', '(GMT-01:00) Atlantic, Azores', 'Atlantic/Azores'),
(294, NULL, 'BM', '(GMT-04:00) Atlantic, Bermuda', 'Atlantic/Bermuda'),
(295, NULL, 'ES', '(GMT) Atlantic, Canary', 'Atlantic/Canary'),
(296, NULL, 'CV', '(GMT-01:00) Atlantic, Cape Verde', 'Atlantic/Cape_Verde'),
(297, NULL, 'FO', '(GMT) Atlantic, Faroe', 'Atlantic/Faroe'),
(298, NULL, 'PT', '(GMT) Atlantic, Madeira', 'Atlantic/Madeira'),
(299, NULL, 'IS', '(GMT) Atlantic, Reykjavik', 'Atlantic/Reykjavik'),
(300, NULL, 'GS', '(GMT-02:00) Atlantic, South Georgia', 'Atlantic/South_Georgia'),
(301, NULL, 'SH', '(GMT) Atlantic, St. Helena', 'Atlantic/St_Helena'),
(302, NULL, 'FK', '(GMT-03:00) Atlantic, Stanley', 'Atlantic/Stanley'),
(303, NULL, 'AU', '(GMT+10:30) Australia, Adelaide', 'Australia/Adelaide'),
(304, NULL, 'AU', '(GMT+10:00) Australia, Brisbane', 'Australia/Brisbane'),
(305, NULL, 'AU', '(GMT+10:30) Australia, Broken Hill', 'Australia/Broken_Hill'),
(306, NULL, 'AU', '(GMT+11:00) Australia, Currie', 'Australia/Currie'),
(307, NULL, 'AU', '(GMT+09:30) Australia, Darwin', 'Australia/Darwin'),
(308, NULL, 'AU', '(GMT+08:45) Australia, Eucla', 'Australia/Eucla'),
(309, NULL, 'AU', '(GMT+11:00) Australia, Hobart', 'Australia/Hobart'),
(310, NULL, 'AU', '(GMT+10:00) Australia, Lindeman', 'Australia/Lindeman'),
(311, NULL, 'AU', '(GMT+11:00) Australia, Lord Howe', 'Australia/Lord_Howe'),
(312, NULL, 'AU', '(GMT+11:00) Australia, Melbourne', 'Australia/Melbourne'),
(313, NULL, 'AU', '(GMT+08:00) Australia, Perth', 'Australia/Perth'),
(314, NULL, 'AU', '(GMT+11:00) Australia, Sydney', 'Australia/Sydney'),
(315, NULL, 'NL', '(GMT+01:00) Europe, Amsterdam', 'Europe/Amsterdam'),
(316, NULL, 'AD', '(GMT+01:00) Europe, Andorra', 'Europe/Andorra'),
(317, NULL, 'RU', '(GMT+04:00) Europe, Astrakhan', 'Europe/Astrakhan'),
(318, NULL, 'GR', '(GMT+02:00) Europe, Athens', 'Europe/Athens'),
(319, NULL, 'RS', '(GMT+01:00) Europe, Belgrade', 'Europe/Belgrade'),
(320, NULL, 'DE', '(GMT+01:00) Europe, Berlin', 'Europe/Berlin'),
(321, NULL, 'SK', '(GMT+01:00) Europe, Bratislava', 'Europe/Bratislava'),
(322, NULL, 'BE', '(GMT+01:00) Europe, Brussels', 'Europe/Brussels'),
(323, NULL, 'RO', '(GMT+02:00) Europe, Bucharest', 'Europe/Bucharest'),
(324, NULL, 'HU', '(GMT+01:00) Europe, Budapest', 'Europe/Budapest'),
(325, NULL, 'DE', '(GMT+01:00) Europe, Busingen', 'Europe/Busingen'),
(326, NULL, 'MD', '(GMT+02:00) Europe, Chisinau', 'Europe/Chisinau'),
(327, NULL, 'DK', '(GMT+01:00) Europe, Copenhagen', 'Europe/Copenhagen'),
(328, NULL, 'IE', '(GMT) Europe, Dublin', 'Europe/Dublin'),
(329, NULL, 'GI', '(GMT+01:00) Europe, Gibraltar', 'Europe/Gibraltar'),
(330, NULL, 'GG', '(GMT) Europe, Guernsey', 'Europe/Guernsey'),
(331, NULL, 'FI', '(GMT+02:00) Europe, Helsinki', 'Europe/Helsinki'),
(332, NULL, 'IM', '(GMT) Europe, Isle of Man', 'Europe/Isle_of_Man'),
(333, NULL, 'TR', '(GMT+03:00) Europe, Istanbul', 'Europe/Istanbul'),
(334, NULL, 'JE', '(GMT) Europe, Jersey', 'Europe/Jersey'),
(335, NULL, 'RU', '(GMT+02:00) Europe, Kaliningrad', 'Europe/Kaliningrad'),
(336, NULL, 'UA', '(GMT+02:00) Europe, Kiev', 'Europe/Kiev'),
(337, NULL, 'RU', '(GMT+03:00) Europe, Kirov', 'Europe/Kirov'),
(338, NULL, 'PT', '(GMT) Europe, Lisbon', 'Europe/Lisbon'),
(339, NULL, 'SI', '(GMT+01:00) Europe, Ljubljana', 'Europe/Ljubljana'),
(340, NULL, 'GB', '(GMT) Europe, London', 'Europe/London'),
(341, NULL, 'LU', '(GMT+01:00) Europe, Luxembourg', 'Europe/Luxembourg'),
(342, NULL, 'ES', '(GMT+01:00) Europe, Madrid', 'Europe/Madrid'),
(343, NULL, 'MT', '(GMT+01:00) Europe, Malta', 'Europe/Malta'),
(344, NULL, 'AX', '(GMT+02:00) Europe, Mariehamn', 'Europe/Mariehamn'),
(345, NULL, 'BY', '(GMT+03:00) Europe, Minsk', 'Europe/Minsk'),
(346, NULL, 'MC', '(GMT+01:00) Europe, Monaco', 'Europe/Monaco'),
(347, NULL, 'RU', '(GMT+03:00) Europe, Moscow', 'Europe/Moscow'),
(348, NULL, 'NO', '(GMT+01:00) Europe, Oslo', 'Europe/Oslo'),
(349, NULL, 'FR', '(GMT+01:00) Europe, Paris', 'Europe/Paris'),
(350, NULL, 'ME', '(GMT+01:00) Europe, Podgorica', 'Europe/Podgorica'),
(351, NULL, 'CZ', '(GMT+01:00) Europe, Prague', 'Europe/Prague'),
(352, NULL, 'LV', '(GMT+02:00) Europe, Riga', 'Europe/Riga'),
(353, NULL, 'IT', '(GMT+01:00) Europe, Rome', 'Europe/Rome'),
(354, NULL, 'RU', '(GMT+04:00) Europe, Samara', 'Europe/Samara'),
(355, NULL, 'SM', '(GMT+01:00) Europe, San Marino', 'Europe/San_Marino'),
(356, NULL, 'BA', '(GMT+01:00) Europe, Sarajevo', 'Europe/Sarajevo'),
(357, NULL, 'RU', '(GMT+04:00) Europe, Saratov', 'Europe/Saratov'),
(358, NULL, 'UA', '(GMT+03:00) Europe, Simferopol', 'Europe/Simferopol'),
(359, NULL, 'MK', '(GMT+01:00) Europe, Skopje', 'Europe/Skopje'),
(360, NULL, 'BG', '(GMT+02:00) Europe, Sofia', 'Europe/Sofia'),
(361, NULL, 'SE', '(GMT+01:00) Europe, Stockholm', 'Europe/Stockholm'),
(362, NULL, 'EE', '(GMT+02:00) Europe, Tallinn', 'Europe/Tallinn'),
(363, NULL, 'AL', '(GMT+01:00) Europe, Tirane', 'Europe/Tirane'),
(364, NULL, 'RU', '(GMT+04:00) Europe, Ulyanovsk', 'Europe/Ulyanovsk'),
(365, NULL, 'UA', '(GMT+02:00) Europe, Uzhgorod', 'Europe/Uzhgorod'),
(366, NULL, 'LI', '(GMT+01:00) Europe, Vaduz', 'Europe/Vaduz'),
(367, NULL, 'VA', '(GMT+01:00) Europe, Vatican', 'Europe/Vatican'),
(368, NULL, 'AT', '(GMT+01:00) Europe, Vienna', 'Europe/Vienna'),
(369, NULL, 'LT', '(GMT+02:00) Europe, Vilnius', 'Europe/Vilnius'),
(370, NULL, 'RU', '(GMT+03:00) Europe, Volgograd', 'Europe/Volgograd'),
(371, NULL, 'PL', '(GMT+01:00) Europe, Warsaw', 'Europe/Warsaw'),
(372, NULL, 'HR', '(GMT+01:00) Europe, Zagreb', 'Europe/Zagreb'),
(373, NULL, 'UA', '(GMT+02:00) Europe, Zaporozhye', 'Europe/Zaporozhye'),
(374, NULL, 'CH', '(GMT+01:00) Europe, Zurich', 'Europe/Zurich'),
(375, NULL, 'MG', '(GMT+03:00) Indian, Antananarivo', 'Indian/Antananarivo'),
(376, NULL, 'IO', '(GMT+06:00) Indian, Chagos', 'Indian/Chagos'),
(377, NULL, 'CX', '(GMT+07:00) Indian, Christmas', 'Indian/Christmas'),
(378, NULL, 'CC', '(GMT+06:30) Indian, Cocos', 'Indian/Cocos'),
(379, NULL, 'KM', '(GMT+03:00) Indian, Comoro', 'Indian/Comoro'),
(380, NULL, 'TF', '(GMT+05:00) Indian, Kerguelen', 'Indian/Kerguelen'),
(381, NULL, 'SC', '(GMT+04:00) Indian, Mahe', 'Indian/Mahe'),
(382, NULL, 'MV', '(GMT+05:00) Indian, Maldives', 'Indian/Maldives'),
(383, NULL, 'MU', '(GMT+04:00) Indian, Mauritius', 'Indian/Mauritius'),
(384, NULL, 'YT', '(GMT+03:00) Indian, Mayotte', 'Indian/Mayotte'),
(385, NULL, 'RE', '(GMT+04:00) Indian, Reunion', 'Indian/Reunion'),
(386, NULL, 'WS', '(GMT+14:00) Pacific, Apia', 'Pacific/Apia'),
(387, NULL, 'NZ', '(GMT+13:00) Pacific, Auckland', 'Pacific/Auckland'),
(388, NULL, 'PG', '(GMT+11:00) Pacific, Bougainville', 'Pacific/Bougainville'),
(389, NULL, 'NZ', '(GMT+13:45) Pacific, Chatham', 'Pacific/Chatham'),
(390, NULL, 'FM', '(GMT+10:00) Pacific, Chuuk', 'Pacific/Chuuk'),
(391, NULL, 'CL', '(GMT-05:00) Pacific, Easter', 'Pacific/Easter'),
(392, NULL, 'VU', '(GMT+11:00) Pacific, Efate', 'Pacific/Efate'),
(393, NULL, 'KI', '(GMT+13:00) Pacific, Enderbury', 'Pacific/Enderbury'),
(394, NULL, 'TK', '(GMT+13:00) Pacific, Fakaofo', 'Pacific/Fakaofo'),
(395, NULL, 'FJ', '(GMT+12:00) Pacific, Fiji', 'Pacific/Fiji'),
(396, NULL, 'TV', '(GMT+12:00) Pacific, Funafuti', 'Pacific/Funafuti'),
(397, NULL, 'EC', '(GMT-06:00) Pacific, Galapagos', 'Pacific/Galapagos'),
(398, NULL, 'PF', '(GMT-09:00) Pacific, Gambier', 'Pacific/Gambier'),
(399, NULL, 'SB', '(GMT+11:00) Pacific, Guadalcanal', 'Pacific/Guadalcanal'),
(400, NULL, 'GU', '(GMT+10:00) Pacific, Guam', 'Pacific/Guam'),
(401, NULL, 'US', '(GMT-10:00) Pacific, Honolulu', 'Pacific/Honolulu'),
(402, NULL, 'US', '(GMT-10:00) Pacific, Johnston', 'Pacific/Johnston'),
(403, NULL, 'KI', '(GMT+14:00) Pacific, Kiritimati', 'Pacific/Kiritimati'),
(404, NULL, 'FM', '(GMT+11:00) Pacific, Kosrae', 'Pacific/Kosrae'),
(405, NULL, 'MH', '(GMT+12:00) Pacific, Kwajalein', 'Pacific/Kwajalein'),
(406, NULL, 'MH', '(GMT+12:00) Pacific, Majuro', 'Pacific/Majuro'),
(407, NULL, 'PF', '(GMT-09:30) Pacific, Marquesas', 'Pacific/Marquesas'),
(408, NULL, 'UM', '(GMT-11:00) Pacific, Midway', 'Pacific/Midway'),
(409, NULL, 'NR', '(GMT+12:00) Pacific, Nauru', 'Pacific/Nauru'),
(410, NULL, 'NU', '(GMT-11:00) Pacific, Niue', 'Pacific/Niue'),
(411, NULL, 'NF', '(GMT+11:00) Pacific, Norfolk', 'Pacific/Norfolk'),
(412, NULL, 'NC', '(GMT+11:00) Pacific, Noumea', 'Pacific/Noumea'),
(413, NULL, 'AS', '(GMT-11:00) Pacific, Pago Pago', 'Pacific/Pago_Pago'),
(414, NULL, 'PW', '(GMT+09:00) Pacific, Palau', 'Pacific/Palau'),
(415, NULL, 'PN', '(GMT-08:00) Pacific, Pitcairn', 'Pacific/Pitcairn'),
(416, NULL, 'FM', '(GMT+11:00) Pacific, Pohnpei', 'Pacific/Pohnpei'),
(417, NULL, 'PG', '(GMT+10:00) Pacific, Port Moresby', 'Pacific/Port_Moresby'),
(418, NULL, 'CK', '(GMT-10:00) Pacific, Rarotonga', 'Pacific/Rarotonga'),
(419, NULL, 'MP', '(GMT+10:00) Pacific, Saipan', 'Pacific/Saipan'),
(420, NULL, 'PF', '(GMT-10:00) Pacific, Tahiti', 'Pacific/Tahiti'),
(421, NULL, 'KI', '(GMT+12:00) Pacific, Tarawa', 'Pacific/Tarawa'),
(422, NULL, 'TO', '(GMT+13:00) Pacific, Tongatapu', 'Pacific/Tongatapu'),
(423, NULL, 'UM', '(GMT+12:00) Pacific, Wake', 'Pacific/Wake'),
(424, NULL, 'WF', '(GMT+12:00) Pacific, Wallis', 'Pacific/Wallis'),
(425, NULL, NULL, '(GMT) UTC', 'UTC'),
(426, NULL, 'AN', '(GMT-04:00) America, Curacao', 'America/Curacao');

-- --------------------------------------------------------

--
-- Table structure for table `hts_userdevices`
--

CREATE TABLE `hts_userdevices` (
  `id` int(11) NOT NULL,
  `deviceToken` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `badge` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `mode` int(11) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `deviceId` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_userinvitecredits`
--

CREATE TABLE `hts_userinvitecredits` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `invited_friend` int(11) DEFAULT NULL,
  `credit_amount` varchar(15) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_userinvites`
--

CREATE TABLE `hts_userinvites` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `invitedemail` varchar(150) DEFAULT NULL,
  `inviteddate` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_userreports`
--

CREATE TABLE `hts_userreports` (
  `id` int(11) NOT NULL,
  `reportid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `reporterid` int(11) NOT NULL,
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `report_type` enum('profile','list') NOT NULL,
  `report_status` enum('0','1') NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hts_users`
--

CREATE TABLE `hts_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `birthday` varchar(10) DEFAULT NULL,
  `userstatus` varchar(1) DEFAULT NULL,
  `hoststatus` varchar(1) DEFAULT NULL,
  `verify_pass` int(1) DEFAULT NULL,
  `verify_passcode` int(20) DEFAULT NULL,
  `profile_image` varchar(50) DEFAULT NULL,
  `address1` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `address2` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `country` int(3) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `modified_at` int(11) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `login_type` varchar(10) DEFAULT NULL,
  `facebookid` bigint(20) DEFAULT NULL,
  `googleid` varchar(50) DEFAULT NULL,
  `referrer_id` varchar(100) DEFAULT NULL,
  `privilige_id` int(11) NOT NULL,
  `credit_total` varchar(45) DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `activation` int(1) DEFAULT NULL,
  `user_level` varchar(10) DEFAULT NULL,
  `phoneno` bigint(20) DEFAULT NULL,
  `about` varchar(180) CHARACTER SET utf8 DEFAULT NULL,
  `school` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `work` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `timezone` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `language` text CHARACTER SET utf8,
  `emergencyno` bigint(20) DEFAULT NULL,
  `emergencyname` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `emergencyemail` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `emergencyrelation` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `shippingid` int(11) DEFAULT NULL,
  `workemail` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `pushnotification` varchar(3) DEFAULT NULL,
  `notifications` mediumtext,
  `emailsettings` mediumtext,
  `socialconnections` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `findability` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `loginnotify` int(1) DEFAULT NULL,
  `mobileverify` int(1) DEFAULT NULL,
  `verifyno` varchar(15) DEFAULT NULL,
  `verifycountrycode` varchar(8) DEFAULT NULL,
  `emailverify` int(1) DEFAULT NULL,
  `verifycode` varchar(50) DEFAULT NULL,
  `reservationrequirement` int(11) DEFAULT NULL,
  `paypalid` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `searchkeys` text CHARACTER SET utf8,
  `listids` text,
  `auth_key` varchar(250) DEFAULT NULL,
  `currency_mobile` int(10) NOT NULL,
  `stripe_status` text,
  `stripe_account_id` text,
  `stripe_account_info` text,
  `stripe_customer_id` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_users`
--

INSERT INTO `hts_users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `birthday`, `userstatus`, `hoststatus`, `verify_pass`, `verify_passcode`, `profile_image`, `address1`, `address2`, `city`, `state`, `country`, `created_at`, `modified_at`, `last_login`, `login_type`, `facebookid`, `googleid`, `referrer_id`, `privilige_id`, `credit_total`, `gender`, `activation`, `user_level`, `phoneno`, `about`, `school`, `work`, `timezone`, `language`, `emergencyno`, `emergencyname`, `emergencyemail`, `emergencyrelation`, `shippingid`, `workemail`, `pushnotification`, `notifications`, `emailsettings`, `socialconnections`, `findability`, `loginnotify`, `mobileverify`, `verifyno`, `verifycountrycode`, `emailverify`, `verifycode`, `reservationrequirement`, `paypalid`, `searchkeys`, `listids`, `auth_key`, `currency_mobile`, `stripe_status`, `stripe_account_id`, `stripe_account_info`, `stripe_customer_id`) VALUES
(1, 'Admin', 'admin', 'admin', 'admin@airfinch.com', 'MTIzNDU2', NULL, '1', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1452158180, 1551514861, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 'god', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, NULL, NULL, NULL, NULL),
(2, 'Demo', 'Airfinch', NULL, 'demo@airfinch.com', 'MTIzNDU2', '3-9-2001', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Tamil Nadu', NULL, 1552378236, 1552563859, NULL, NULL, NULL, NULL, NULL, 0, NULL, '', NULL, 'normal', NULL, 'I am very quite and interested in computer codes as well as Hacks.', 'Adithya school of excellence', 'Hitasoft technology solutions and private limited', '(GMT+05:30) Asia, Kolkata', '[{"name":"English (UK)"},{"name":"French"},{"name":"Urdu"},{"name":"Arabic"}]', 8015452650, 'Kishore', 'kishorekumarrk@hitasoft.com', 'Vice President ', NULL, NULL, '1', '{"mobilenotify":"0","messagenotify":"1","reservationnotify":"1","accountnotify":"0"}', '{"generalemail":"0","reservationemail":"1"}', NULL, NULL, NULL, 1, '9080803340', '91', 1, NULL, NULL, NULL, NULL, '["24","21","31","28","15","16","17","20","25"]', NULL, 0, 'verified', '{"accountnumber":"0000000010","routingnumber":"110000","accountid":"acct_1ED5uVGtB8TJHaN5","base":"NZ~NZD~New Zealand"}', '{"firstname":"Demo","lastname":"Airfinch","birth_day":"9","birth_month":"3","birth_year":"2001","type":"individual","phonenumber":"9 800 7370","line1":"445, Mount Eden Road","line2":"Mount Eden","city":"Auckland","state":"","postalcode":"1024","country":"NZ","documentstatus":"verified","charges_enabled":true,"created":1552379071,"default_currency":"nzd","payouts_enabled":true,"payouts_day":4,"payouts_interval":"daily","account_id":"acct_1ED5uVGtB8TJHaN5"}', 'cus_EgsJsn9PC84VNh'),
(3, 'Aswad', 'Asath', NULL, 'abulkalam@hitasoft.com', 'MTIzNDU2', '12-19-1990', '1', '1', NULL, NULL, '3_lee.jpg', NULL, NULL, NULL, NULL, NULL, 1552380125, 1552557016, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '{"mobilenotify":"0","messagenotify":"1","reservationnotify":"1","accountnotify":"0"}', '{"generalemail":"0","reservationemail":"1"}', NULL, NULL, NULL, 1, '9080803340', '91', 1, NULL, NULL, NULL, NULL, '["8","3","31","1","13","2","5","4","10","12"]', NULL, 0, 'verified', '{"accountnumber":"000123456789","routingnumber":"110000000","accountid":"acct_1EDBPHLFYW3zEhA0","base":"US~USD~United States"}', '{"personalidnumber":"000000000","personalidnumber_status":"1","ssn_last_four":"0000","ssn_status":"1","firstname":"Aswad","lastname":"Asath","birth_day":"19","birth_month":"12","birth_year":"1990","type":"individual","phonenumber":"(555) 867-5310","line1":"185 berry st.","line2":"","city":"San Francisco","state":"California","postalcode":"94107","country":"US","documentstatus":"verified","charges_enabled":true,"created":1552400200,"default_currency":"usd","payouts_enabled":true,"payouts_day":2,"payouts_interval":"daily","account_id":"acct_1EDBPHLFYW3zEhA0"}', 'cus_EgsPYW9WKw9wa7'),
(4, 'Kishore', 'kumar', NULL, 'kishorekumarrk@hitasoft.com', 'MTIzNDU2', '6-1-1992', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'TAMILNADU', NULL, 1552475839, 1552545471, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'male', NULL, 'normal', NULL, 'Our rooms are spacious,inbred with kerala antique look. Its greenish and mum environment. We heartfully invite you to have a good and memorable stay with us .', '', 'Hitasoft Technology Solutions', '(GMT+03:00) Africa, Nairobi', '[{"name":"English (UK)"},{"name":"French"},{"name":"Arabic"}]', NULL, '', '', '', NULL, NULL, '1', '{"mobilenotify":"0","messagenotify":"1","reservationnotify":"1","accountnotify":"0"}', '{"generalemail":"0","reservationemail":"1"}', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '["13","3","21"]', NULL, 0, 'verified', '{"accountnumber":"000123456","routingnumber":"110000","accountid":"acct_1EDVDkCCfzAfuSo9","base":"AU~AUD~Australia"}', '{"firstname":"Kishore","lastname":"kumar","birth_day":"1","birth_month":"6","birth_year":"1992","type":"individual","phonenumber":"9876 5432","line1":"200 Broadway Av","line2":"","city":"WEST BEACH SA 5024","state":"SA","postalcode":"5024","country":"AU","documentstatus":"verified","charges_enabled":true,"created":1552476365,"default_currency":"aud","payouts_enabled":true,"payouts_day":2,"payouts_interval":"daily","account_id":"acct_1EDVDkCCfzAfuSo9"}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hts_weekendprice`
--

CREATE TABLE `hts_weekendprice` (
  `id` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `weekend_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_weekendprice`
--

INSERT INTO `hts_weekendprice` (`id`, `listid`, `weekend_price`) VALUES
(1, 1, 120),
(2, 2, 140),
(3, 3, 380),
(4, 4, 105),
(5, 5, 100),
(6, 6, 70),
(7, 7, 70),
(8, 8, 200),
(9, 10, 160),
(10, 11, 500),
(11, 13, 45),
(12, 14, 60),
(13, 15, 60),
(14, 16, 80),
(15, 17, 45),
(16, 19, 30),
(17, 20, 110),
(18, 22, 300),
(19, 25, 35),
(20, 27, 180),
(21, 28, 90),
(22, 29, 130),
(23, 30, 140),
(24, 31, 155);

-- --------------------------------------------------------

--
-- Table structure for table `hts_wishlists`
--

CREATE TABLE `hts_wishlists` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `listid` int(11) DEFAULT NULL,
  `listingid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hts_wishlists`
--

INSERT INTO `hts_wishlists` (`id`, `userid`, `listid`, `listingid`) VALUES
(1, 2, 1, 29),
(2, 2, 1, 28),
(3, 2, 2, 20),
(4, 2, 2, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hts_additionalamenities`
--
ALTER TABLE `hts_additionalamenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_additionallisting`
--
ALTER TABLE `hts_additionallisting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listid1_idx` (`listingid`),
  ADD KEY `additionalid_idx` (`amenityid`);

--
-- Indexes for table `hts_buttonsliders`
--
ALTER TABLE `hts_buttonsliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_cancellation`
--
ALTER TABLE `hts_cancellation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_claim`
--
ALTER TABLE `hts_claim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claimuserid_idx` (`userid`),
  ADD KEY `claimreserveid_idx` (`reservationid`);

--
-- Indexes for table `hts_claimmessage`
--
ALTER TABLE `hts_claimmessage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claimmessclaimid_idx` (`claimid`),
  ADD KEY `claimmessuserid_idx` (`userid`),
  ADD KEY `claimmesshostid_idx` (`hostid`);

--
-- Indexes for table `hts_commission`
--
ALTER TABLE `hts_commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_commonamenities`
--
ALTER TABLE `hts_commonamenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_commonlisting`
--
ALTER TABLE `hts_commonlisting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listid_idx` (`listingid`),
  ADD KEY `commonid_idx` (`amenityid`);

--
-- Indexes for table `hts_country`
--
ALTER TABLE `hts_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_currency`
--
ALTER TABLE `hts_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_help`
--
ALTER TABLE `hts_help`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_helptopic`
--
ALTER TABLE `hts_helptopic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_homecountries`
--
ALTER TABLE `hts_homecountries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countryid_idx` (`countryid`);

--
-- Indexes for table `hts_homepagesettings`
--
ALTER TABLE `hts_homepagesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_hometype`
--
ALTER TABLE `hts_hometype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_inquiry`
--
ALTER TABLE `hts_inquiry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listingid` (`listingid`),
  ADD KEY `listingid_2` (`listingid`),
  ADD KEY `senderid` (`senderid`,`receiverid`,`lastmessageid`);

--
-- Indexes for table `hts_invoices`
--
ALTER TABLE `hts_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderid_1_idx` (`orderid`);

--
-- Indexes for table `hts_languages`
--
ALTER TABLE `hts_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_listing`
--
ALTER TABLE `hts_listing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`),
  ADD KEY `accommodates_idx` (`accommodates`),
  ADD KEY `bedroooms_idx` (`bedrooms`),
  ADD KEY `beds_idx` (`beds`),
  ADD KEY `bathrooms_idx` (`bathrooms`),
  ADD KEY `currrency_idx` (`currency`),
  ADD KEY `hometype_idx` (`hometype`),
  ADD KEY `roomtype_idx` (`roomtype`),
  ADD KEY `fk_country` (`country`);

--
-- Indexes for table `hts_listingproperties`
--
ALTER TABLE `hts_listingproperties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_lists`
--
ALTER TABLE `hts_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wish_userid_idx` (`createdby`);

--
-- Indexes for table `hts_logs`
--
ALTER TABLE `hts_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_userid_idx` (`userid`),
  ADD KEY `log_notifyto_idx` (`notifyto`),
  ADD KEY `log_listingid_idx` (`listingid`);

--
-- Indexes for table `hts_messages`
--
ALTER TABLE `hts_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderid_idx` (`senderid`),
  ADD KEY `fk_listingid_idx` (`listingid`),
  ADD KEY `fk_receiverid_idx` (`receiverid`),
  ADD KEY `inquiryid` (`inquiryid`),
  ADD KEY `inquiryid_2` (`inquiryid`),
  ADD KEY `inquiryid_3` (`inquiryid`);

--
-- Indexes for table `hts_paymentmethods`
--
ALTER TABLE `hts_paymentmethods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_payoutmethods`
--
ALTER TABLE `hts_payoutmethods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_photos`
--
ALTER TABLE `hts_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listid_idx` (`listid`);

--
-- Indexes for table `hts_privileges`
--
ALTER TABLE `hts_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_profilereports`
--
ALTER TABLE `hts_profilereports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_reportlisting`
--
ALTER TABLE `hts_reportlisting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_reservations`
--
ALTER TABLE `hts_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`),
  ADD KEY `reservehostid` (`hostid`),
  ADD KEY `reservelistid` (`listid`),
  ADD KEY `inquiryid` (`inquiryid`),
  ADD KEY `inquiryid_2` (`inquiryid`);

--
-- Indexes for table `hts_reviews`
--
ALTER TABLE `hts_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_roles`
--
ALTER TABLE `hts_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_roomtype`
--
ALTER TABLE `hts_roomtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_safetycheck`
--
ALTER TABLE `hts_safetycheck`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_safetylisting`
--
ALTER TABLE `hts_safetylisting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listid3_idx` (`listingid`),
  ADD KEY `checklistid_idx` (`safetyid`);

--
-- Indexes for table `hts_shippingaddress`
--
ALTER TABLE `hts_shippingaddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_sitecharge`
--
ALTER TABLE `hts_sitecharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_sitesettings`
--
ALTER TABLE `hts_sitesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_specialfeatures`
--
ALTER TABLE `hts_specialfeatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_speciallisting`
--
ALTER TABLE `hts_speciallisting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listid2_idx` (`listingid`),
  ADD KEY `featureid_idx` (`specialid`);

--
-- Indexes for table `hts_tax`
--
ALTER TABLE `hts_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countryid_idx` (`countryid`);

--
-- Indexes for table `hts_textsliders`
--
ALTER TABLE `hts_textsliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_timezone`
--
ALTER TABLE `hts_timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_userdevices`
--
ALTER TABLE `hts_userdevices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_userinvitecredits`
--
ALTER TABLE `hts_userinvitecredits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_userinvites`
--
ALTER TABLE `hts_userinvites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_idx` (`userid`);

--
-- Indexes for table `hts_userreports`
--
ALTER TABLE `hts_userreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_users`
--
ALTER TABLE `hts_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_idx` (`country`);

--
-- Indexes for table `hts_weekendprice`
--
ALTER TABLE `hts_weekendprice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hts_wishlists`
--
ALTER TABLE `hts_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_userid_idx` (`userid`),
  ADD KEY `list_listid_idx` (`listid`),
  ADD KEY `list_listingid_idx` (`listingid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hts_additionalamenities`
--
ALTER TABLE `hts_additionalamenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `hts_additionallisting`
--
ALTER TABLE `hts_additionallisting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
--
-- AUTO_INCREMENT for table `hts_buttonsliders`
--
ALTER TABLE `hts_buttonsliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hts_cancellation`
--
ALTER TABLE `hts_cancellation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `hts_claim`
--
ALTER TABLE `hts_claim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_claimmessage`
--
ALTER TABLE `hts_claimmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_commission`
--
ALTER TABLE `hts_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hts_commonamenities`
--
ALTER TABLE `hts_commonamenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `hts_commonlisting`
--
ALTER TABLE `hts_commonlisting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT for table `hts_country`
--
ALTER TABLE `hts_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT for table `hts_currency`
--
ALTER TABLE `hts_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `hts_help`
--
ALTER TABLE `hts_help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hts_helptopic`
--
ALTER TABLE `hts_helptopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hts_homecountries`
--
ALTER TABLE `hts_homecountries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `hts_homepagesettings`
--
ALTER TABLE `hts_homepagesettings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hts_hometype`
--
ALTER TABLE `hts_hometype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `hts_inquiry`
--
ALTER TABLE `hts_inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `hts_invoices`
--
ALTER TABLE `hts_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `hts_languages`
--
ALTER TABLE `hts_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `hts_listing`
--
ALTER TABLE `hts_listing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `hts_listingproperties`
--
ALTER TABLE `hts_listingproperties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hts_lists`
--
ALTER TABLE `hts_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hts_logs`
--
ALTER TABLE `hts_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `hts_messages`
--
ALTER TABLE `hts_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `hts_paymentmethods`
--
ALTER TABLE `hts_paymentmethods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_payoutmethods`
--
ALTER TABLE `hts_payoutmethods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_photos`
--
ALTER TABLE `hts_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `hts_privileges`
--
ALTER TABLE `hts_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_profilereports`
--
ALTER TABLE `hts_profilereports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_reportlisting`
--
ALTER TABLE `hts_reportlisting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_reservations`
--
ALTER TABLE `hts_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `hts_reviews`
--
ALTER TABLE `hts_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hts_roles`
--
ALTER TABLE `hts_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hts_roomtype`
--
ALTER TABLE `hts_roomtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hts_safetycheck`
--
ALTER TABLE `hts_safetycheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hts_safetylisting`
--
ALTER TABLE `hts_safetylisting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;
--
-- AUTO_INCREMENT for table `hts_shippingaddress`
--
ALTER TABLE `hts_shippingaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hts_sitecharge`
--
ALTER TABLE `hts_sitecharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hts_sitesettings`
--
ALTER TABLE `hts_sitesettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hts_specialfeatures`
--
ALTER TABLE `hts_specialfeatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hts_speciallisting`
--
ALTER TABLE `hts_speciallisting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `hts_tax`
--
ALTER TABLE `hts_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `hts_textsliders`
--
ALTER TABLE `hts_textsliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_timezone`
--
ALTER TABLE `hts_timezone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;
--
-- AUTO_INCREMENT for table `hts_userdevices`
--
ALTER TABLE `hts_userdevices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_userinvitecredits`
--
ALTER TABLE `hts_userinvitecredits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_userinvites`
--
ALTER TABLE `hts_userinvites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_userreports`
--
ALTER TABLE `hts_userreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hts_users`
--
ALTER TABLE `hts_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hts_weekendprice`
--
ALTER TABLE `hts_weekendprice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `hts_wishlists`
--
ALTER TABLE `hts_wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `hts_additionallisting`
--
ALTER TABLE `hts_additionallisting`
  ADD CONSTRAINT `additionalid` FOREIGN KEY (`amenityid`) REFERENCES `hts_additionalamenities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `listid1` FOREIGN KEY (`listingid`) REFERENCES `hts_listing` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hts_claim`
--
ALTER TABLE `hts_claim`
  ADD CONSTRAINT `claimreserveid` FOREIGN KEY (`reservationid`) REFERENCES `hts_reservations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `claimuserid` FOREIGN KEY (`userid`) REFERENCES `hts_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hts_claimmessage`
--
ALTER TABLE `hts_claimmessage`
  ADD CONSTRAINT `claimmessclaimid` FOREIGN KEY (`claimid`) REFERENCES `hts_claim` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `claimmesshostid` FOREIGN KEY (`hostid`) REFERENCES `hts_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `claimmessuserid` FOREIGN KEY (`userid`) REFERENCES `hts_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hts_commonlisting`
--
ALTER TABLE `hts_commonlisting`
  ADD CONSTRAINT `commonid` FOREIGN KEY (`amenityid`) REFERENCES `hts_commonamenities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `listid4` FOREIGN KEY (`listingid`) REFERENCES `hts_listing` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hts_homecountries`
--
ALTER TABLE `hts_homecountries`
  ADD CONSTRAINT `home_countryid` FOREIGN KEY (`countryid`) REFERENCES `hts_country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
