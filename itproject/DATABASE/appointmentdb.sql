-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 06:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointmentdb`
--

CREATE TABLE `appointmentdb` (
  `ID` int(11) NOT NULL,
  `Student_ID` varchar(15) NOT NULL,
  `Student_Name` varchar(80) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `Appointment_Date` datetime NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Status` enum('Pending','Accepted','Ongoing','Completed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointmentdb`
--

INSERT INTO `appointmentdb` (`ID`, `Student_ID`, `Student_Name`, `Section`, `Appointment_Date`, `Description`, `Status`) VALUES
(1, '11', '11', '11', '1111-11-11 11:11:00', '111', 'Completed'),
(2, '111', '11', '11', '1111-11-11 11:11:00', '11', ''),
(3, '123123', '1123', '123123', '1111-11-11 14:13:00', '123', ''),
(4, '11212', '111', '1212', '1211-12-12 12:12:00', '12', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointmentdb`
--
ALTER TABLE `appointmentdb`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointmentdb`
--
ALTER TABLE `appointmentdb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
