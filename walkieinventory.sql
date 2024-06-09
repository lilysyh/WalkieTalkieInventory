-- phpMyAdmin SQL Dump
-- version 5.2.2-dev+20230928.2a96c4b98e
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 03:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `walkieinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d_id` int(11) NOT NULL,
  `d_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `d_name`) VALUES
(1, 'Sector Exec'),
(2, 'Operation Executive'),
(3, 'Operator'),
(5, 'P.House/Jetty'),
(9, 'Terminal 5'),
(10, 'Operations');

-- --------------------------------------------------------

--
-- Table structure for table `ownershiptype`
--

CREATE TABLE `ownershiptype` (
  `o_id` int(11) NOT NULL,
  `o_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ownershiptype`
--

INSERT INTO `ownershiptype` (`o_id`, `o_type`) VALUES
(1, 'Spare'),
(3, 'Individual'),
(4, 'Shared'),
(7, 'Unallocated');

-- --------------------------------------------------------

--
-- Table structure for table `statusdb`
--

CREATE TABLE `statusdb` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statusdb`
--

INSERT INTO `statusdb` (`s_id`, `s_name`) VALUES
(1, 'In Use'),
(2, 'Repair'),
(6, 'Lost'),
(7, 'UnUsed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Dalili', 'admin@gmail.com', 'fc50ef442dfadd118632fb695'),
(2, 'abcde', 'abcde@gmail.com', 'ab56b4d92b40713acc5af8998'),
(3, 'Asyikin', 'asyikin@gmail.com', '61c8186128d8b08935dbf9a32'),
(4, 'abcdef', 'abcdef@gmail.com', 'e80b5017098950fc58aad83c8'),
(5, 'a123', 'a123@gmail.com', '80c9ef0fb86369cd25f90af27'),
(6, 'Dalili Syahirah Shahidi', 'dalilisyahirahshahidi@gmail.com', 'fc50ef442dfadd118632fb695'),
(7, 'NUR DALILI', 'dalili@gmail.com', 'ce024cb5b7ea032fca6ab97f8');

-- --------------------------------------------------------

--
-- Table structure for table `wakietalkie`
--

CREATE TABLE `wakietalkie` (
  `id` int(11) NOT NULL,
  `RadioID` int(11) NOT NULL,
  `SerialNo` varchar(25) NOT NULL,
  `Status` varchar(25) NOT NULL,
  `Model` varchar(25) NOT NULL,
  `OwnershipType` varchar(25) NOT NULL,
  `Ownership` varchar(50) NOT NULL,
  `Position` varchar(25) NOT NULL,
  `Department` varchar(25) NOT NULL,
  `Remark` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wakietalkie`
--

INSERT INTO `wakietalkie` (`id`, `RadioID`, `SerialNo`, `Status`, `Model`, `OwnershipType`, `Ownership`, `Position`, `Department`, `Remark`) VALUES
(1, 2001, '037TNMJ713', 'Lost', 'P8268', 'Spare', 'Mohd Nazri Bin Manap', 'Manager/ Head of Unit (Je', 'Sector Exec', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `ownershiptype`
--
ALTER TABLE `ownershiptype`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `statusdb`
--
ALTER TABLE `statusdb`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakietalkie`
--
ALTER TABLE `wakietalkie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ownershiptype`
--
ALTER TABLE `ownershiptype`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `statusdb`
--
ALTER TABLE `statusdb`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wakietalkie`
--
ALTER TABLE `wakietalkie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
