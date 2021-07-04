-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2021 at 01:46 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kurs`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `userRole` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `userEmail`, `userPassword`, `userRole`) VALUES
(1, 'Berta', 'bb@bb.bb', '$2y$12$T8JJWhKUUmGkDnR0829zNOFxPZ5j8v6gI6woZ./QHmIdp5tz16ZHa', 1),
(2, 'Alfredo', 'aa@aa.aa', '$2y$12$T8JJWhKUUmGkDnR0829zNOFxPZ5j8v6gI6woZ./QHmIdp5tz16ZHa', 0),
(3, 'Chris', 'cc@cc.cc', '$2y$12$T8JJWhKUUmGkDnR0829zNOFxPZ5j8v6gI6woZ./QHmIdp5tz16ZHa', 0),
(5, 'Xaver', 'xx@xx.xx', '$2y$12$T8JJWhKUUmGkDnR0829zNOFxPZ5j8v6gI6woZ./QHmIdp5tz16ZHa', 0),
(10, 'eventsuser', 'user@event.com', '$2y$12$T8JJWhKUUmGkDnR0829zNOFxPZ5j8v6gI6woZ./QHmIdp5tz16ZHa', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
