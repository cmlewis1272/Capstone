-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2021 at 05:42 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thoedata`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `Donation_id` int(3) NOT NULL,
  `Donator_id` int(3) NOT NULL,
  `Donation_amount` float NOT NULL,
  `Donation_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`Donation_id`, `Donator_id`, `Donation_amount`, `Donation_date`) VALUES
(1, 3, 1500, '2021-11-29'),
(2, 1, 25, '2020-11-29'),
(3, 1, 100, '2021-08-15'),
(4, 2, 250, '2019-02-17'),
(5, 3, 153.33, '2019-11-29'),
(6, 4, 726.75, '2021-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `donators`
--

CREATE TABLE `donators` (
  `Donator_id` int(3) NOT NULL,
  `Donator_type` text NOT NULL,
  `Organization_name` text NOT NULL,
  `Donator_FirstName` text NOT NULL,
  `Donator_LastName` text NOT NULL,
  `Street_num` int(10) NOT NULL,
  `Street_name` text NOT NULL,
  `City` text NOT NULL,
  `State` text NOT NULL,
  `zip` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donators`
--

INSERT INTO `donators` (`Donator_id`, `Donator_type`, `Organization_name`, `Donator_FirstName`, `Donator_LastName`, `Street_num`, `Street_name`, `City`, `State`, `zip`) VALUES
(1, 'individual', '', 'John', 'Philban', 2254, 'Paladin ave', 'Houston', 'TX', 77498),
(2, 'individual', '', 'Joe', 'Huan', 152, 'Broderbond', 'Stafford', 'TX', 77477),
(3, 'Organization', 'The Bratcher foundation', '', '', 256, 'solomon ln', 'Houston', 'TX', 77081),
(4, 'Organization', 'Vorcane International', '', '', 105, 'Nilbog ave', 'Richmond', 'TX', 77498);

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `Resident_id` int(3) NOT NULL,
  `Street_name` varchar(25) NOT NULL,
  `Street_num` varchar(10) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` int(5) NOT NULL,
  `Availability` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`Resident_id`, `Street_name`, `Street_num`, `City`, `State`, `Zip`, `Availability`) VALUES
(1, 'Juniper', '1111', 'Houston', 'TX', 77498, 2),
(2, 'Salzan', '2000', 'rosenberg', 'TX', 77584, 1),
(3, 'Blalock', '1564', 'Houston', 'TX', 77498, 2),
(6, 'Thomson', '1528', 'Sugar Land', 'TX', 77498, 3),
(7, 'Old Richmond', '2584', 'Sugar Land', 'TX', 77498, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `Tenant_id` int(3) NOT NULL,
  `Resident_id` int(3) NOT NULL,
  `First_name` text NOT NULL,
  `Last_name` text NOT NULL,
  `Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`Tenant_id`, `Resident_id`, `First_name`, `Last_name`, `Phone`) VALUES
(1, 1, 'Jimmy', 'falon', '2815569856'),
(2, 1, 'Tommy', 'Ferris', '7135896584'),
(3, 2, 'Billy', 'Traehan', '4095876525'),
(6, 1, 'Jason', 'Bourne', '2816265848'),
(7, 2, 'Mathew', 'Mchonahey', '555-555-5558');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(3) NOT NULL,
  `First_name` varchar(25) NOT NULL,
  `Last_name` varchar(25) NOT NULL,
  `Street_num` int(6) NOT NULL,
  `Street_name` varchar(25) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` int(7) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Access_level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_name`, `Last_name`, `Street_num`, `Street_name`, `City`, `State`, `Zip`, `Username`, `Password`, `Access_level`) VALUES
(1, 'Christopher', 'Lewis', 1501, 'Bloder st', 'Houston', 'TX', 77548, 'cmlewis1272', 'jimmycr12', 1),
(2, 'Freddy', 'Kruger', 1428, 'Elm st', 'Springwood', 'OH', 45201, 'boiler', 'hand', 2),
(4, 'Jason', 'vorhees', 11582, 'Crystal lake Dr', 'Crystal Place', 'NH', 77266, 'knife', 'mama', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`Donation_id`);

--
-- Indexes for table `donators`
--
ALTER TABLE `donators`
  ADD PRIMARY KEY (`Donator_id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`Resident_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`Tenant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `Donation_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donators`
--
ALTER TABLE `donators`
  MODIFY `Donator_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `Resident_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `Tenant_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
