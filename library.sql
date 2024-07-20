-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 05:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `phone_number`, `address`) VALUES
(1, 'Akbar', '082112341234', 'RT 1');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `ISBN` varchar(15) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Author` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `Title`, `Author`) VALUES
('0316512443', 'Youjo Senki Vol 1', 'Carlo Zen'),
('031651246X', 'Youjo Senki Vol 2', 'Carlo Zen');

-- --------------------------------------------------------

--
-- Table structure for table `book_borrowing`
--

CREATE TABLE `book_borrowing` (
  `Borrow_ID` int(11) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Borrow_Date` date NOT NULL,
  `Return_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_borrowing`
--

INSERT INTO `book_borrowing` (`Borrow_ID`, `ID_User`, `ID_Admin`, `Borrow_Date`, `Return_Date`) VALUES
(3, 1, 1, '2024-07-19', '2024-07-20'),
(4, 1, 1, '2024-07-19', '2024-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `book_borrowing_details`
--

CREATE TABLE `book_borrowing_details` (
  `Borrow_Detail_ID` int(11) NOT NULL,
  `Borrow_ID` int(11) NOT NULL,
  `ISBN` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_borrowing_details`
--

INSERT INTO `book_borrowing_details` (`Borrow_Detail_ID`, `Borrow_ID`, `ISBN`) VALUES
(4, 3, '031651246X'),
(5, 4, '031651246X'),
(6, 4, '0316512443');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_User` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Phone_Number` varchar(20) NOT NULL,
  `Address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_User`, `Name`, `Phone_Number`, `Address`) VALUES
(1, 'Felix', '085712341234', 'RT 01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `book_borrowing`
--
ALTER TABLE `book_borrowing`
  ADD PRIMARY KEY (`Borrow_ID`),
  ADD KEY `ID_Admin` (`ID_Admin`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `book_borrowing_details`
--
ALTER TABLE `book_borrowing_details`
  ADD PRIMARY KEY (`Borrow_Detail_ID`),
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `Borrow_ID` (`Borrow_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_borrowing`
--
ALTER TABLE `book_borrowing`
  MODIFY `Borrow_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_borrowing_details`
--
ALTER TABLE `book_borrowing_details`
  MODIFY `Borrow_Detail_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_borrowing`
--
ALTER TABLE `book_borrowing`
  ADD CONSTRAINT `book_borrowing_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `book_borrowing_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `user` (`ID_User`);

--
-- Constraints for table `book_borrowing_details`
--
ALTER TABLE `book_borrowing_details`
  ADD CONSTRAINT `book_borrowing_details_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
