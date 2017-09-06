-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2017 at 07:17 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wsspeshawar`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(20) NOT NULL,
  `nc_id` int(255) NOT NULL,
  `uc_id` int(255) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `emailad` varchar(25) NOT NULL,
  `mobilenumber` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `nc_id`, `uc_id`, `fullname`, `emailad`, `mobilenumber`, `password`, `profile_image`) VALUES
(73, 0, 0, 'test this', 'test@admin.com', '03342211221', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', '17903431_188134929207805.jpg'),
(75, 0, 0, 'Tehseen', 'tehseenullah91@gmail.com', '03358018012', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '17903431_188134929207805.jpg'),
(76, 0, 0, 'Fazal', 'fazalullah32@gmail.com', '03029155055', 'd6cfe5e76c8347bc803168fe861f69fcc69cc79c', '56c5668018b083524e710db326b6b24b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `c_id` int(255) NOT NULL,
  `account_id` int(255) NOT NULL,
  `c_number` varchar(255) NOT NULL,
  `c_details` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `bin_address` varchar(255) NOT NULL,
  `c_date` date NOT NULL,
  `c_time` time NOT NULL,
  `c_date_time` datetime NOT NULL,
  `c_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`c_id`, `account_id`, `c_number`, `c_details`, `image_path`, `longitude`, `latitude`, `bin_address`, `c_date`, `c_time`, `c_date_time`, `c_type`, `status`) VALUES
(15, 73, '74425', 'Testing.................', './uploads/map/74425.jpeg', '71.5453641', '34.0011949', 'FC Chok', '2017-04-20', '09:19:23', '0000-00-00 00:00:00', 'Drainage', 'completed'),
(16, 73, '74425', '0', './uploads/map/74425.jpeg', '71.5453641', '0', 'FC Chok', '2017-04-20', '09:31:47', '0000-00-00 00:00:00', '0', 'inprogress'),
(17, 76, '42412', 'test complaint....\r\ntestingggg...', './uploads/map/42412.jpeg', '71.5488416', '34.0028678', 'Test', '2017-04-20', '09:15:18', '0000-00-00 00:00:00', 'Water Supply', 'pendingreview'),
(18, 75, '42412', 'test complaint....\ntestingggg...', './uploads/map/42412.jpeg', '71.5488416', '34.0028678', 'Test', '2017-04-19', '01:36:11', '0000-00-00 00:00:00', 'Water Supply', 'pendingreview'),
(19, 73, '40701', 'Test.....', './uploads/map/40701.jpeg', '71.5187945', '34.0076315', 'Tehkal', '2017-04-20', '09:32:29', '0000-00-00 00:00:00', 'Drainage', 'completed'),
(20, 75, '40701', 'Test.....', './uploads/map/40701.jpeg', '71.5187945', '34.0076315', 'Tehkal', '2017-04-20', '09:21:24', '0000-00-00 00:00:00', 'Drainage', 'underreview'),
(21, 76, '75280', 'Testing.......\r\nappp.....', './uploads/map/75280.jpeg', '71.5454568', '34.0012933', 'Test', '2017-04-20', '09:15:52', '2017-04-20 07:30:49', 'Garbage', 'inprogress');

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES
(1, 'Love.Fish', '580 Darling Street, Rozelle, NSW', 33.861034, 71.545372, 'PendingReview'),
(2, 'Young Henrys', '76 Wilford Street, Newtown, NSW', 34.071754, 71.645454, 'Completed'),
(3, 'Hunter Gatherer', 'Greenwood Plaza, 36 Blue St, North Sydney NSW', 33.840282, 71.545372, 'InProgress'),
(4, 'The Potting Shed', '7A, 2 Huntley Street, Alexandria, NSW', 33.910751, 71.545380, 'InProgress'),
(5, 'Nomad', '16 Foster Street, Surry Hills, NSW', 33.879917, 71.545364, 'Completed'),
(6, 'Three Blue Ducks', '43 Macpherson Street, Bronte, NSW', 33.906357, 71.545372, 'PendingReview'),
(7, 'Single Origin Roasters', '60-64 Reservoir Street, Surry Hills, NSW', 34.001114, 71.545364, 'UnderReview'),
(8, 'Red Lantern', '60 Riley Street, Darlinghurst, NSW', 33.874737, 71.545372, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `neighbourhood_c`
--

CREATE TABLE `neighbourhood_c` (
  `nc_id` int(255) NOT NULL,
  `nc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unioncouncil_c`
--

CREATE TABLE `unioncouncil_c` (
  `uc_id` int(255) NOT NULL,
  `uc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `neighbourhood_c`
--
ALTER TABLE `neighbourhood_c`
  ADD PRIMARY KEY (`nc_id`);

--
-- Indexes for table `unioncouncil_c`
--
ALTER TABLE `unioncouncil_c`
  ADD PRIMARY KEY (`uc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `c_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `neighbourhood_c`
--
ALTER TABLE `neighbourhood_c`
  MODIFY `nc_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unioncouncil_c`
--
ALTER TABLE `unioncouncil_c`
  MODIFY `uc_id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
