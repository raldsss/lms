-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:25 AM
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
-- Database: `lmsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `admin_name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `book_tbl`
--

CREATE TABLE `book_tbl` (
  `book_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_category` varchar(100) NOT NULL,
  `publication_year` year(4) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `copies_available` int(11) NOT NULL,
  `total_copies` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_tbl`
--

INSERT INTO `book_tbl` (`book_id`, `admin_id`, `admin_name`, `isbn`, `book_title`, `book_author`, `book_category`, `publication_year`, `publisher`, `copies_available`, `total_copies`, `date_added`, `image`, `status`) VALUES
(1, 1, 'Admin', '978-0743273565', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', '1925', 'Scribner', 0, 5, '2024-11-29 14:18:32', 'The_Great_Gatsby_Cover_1925_Retouched.jpg', 'Available'),
(5, 1, 'Admin', '21323232', 'The Avatar', 'basta', 'Non-fiction', '1920', 'akndksd', 0, 5, '2024-12-03 00:44:41', '67822852_715970678844895_1242991439864922112_n-fotor-bg-remover-202411196541.png', 'Available'),
(6, 1, 'Admin', '123123', 'basta', 'basta', 'Non-fiction', '1922', 'bsta', 0, 3, '2024-12-03 00:46:15', 'back.PNG', 'Available'),
(16, 1, 'Admin', '12', 'The Mongolloyds', 'Lloyd', 'Fiction', '1980', 'lloydis', 0, 23, '2024-12-03 02:34:54', 'back.PNG', 'Available'),
(17, 1, 'Admin', '23', 'The Mongolloydd', 'Lloydd', 'Non-fiction', '1930', 'lloydid', 0, 24, '2024-12-03 02:39:22', '67822852_715970678844895_1242991439864922112_n.jpg', 'Available'),
(18, 1, 'Admin', '34', 'The Mongolloyddi', 'Lloyds', 'Fiction', '1980', 'lloydidw', 34, 34, '2024-12-03 02:44:13', 'back.PNG', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_books`
--

CREATE TABLE `borrow_books` (
  `book_id` int(11) NOT NULL,
  `borrower_name` varchar(255) NOT NULL,
  `borrower_email` varchar(100) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `copies` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_books`
--

INSERT INTO `borrow_books` (`book_id`, `borrower_name`, `borrower_email`, `book_name`, `copies`, `borrow_date`, `return_date`, `status`) VALUES
(1, 'Gerald Secare', 'geraldsecared@gmail.com', '', 0, '2024-12-03', '2024-12-10', 'Borrowed'),
(2, 'Gerald Secare', 'geraldsecared@gmail.com', '', 0, '2024-12-03', '2024-12-10', 'Borrowed'),
(3, 'Gerald Escare', 'gerald@gmail.com', '', 0, '2024-12-03', '2024-12-28', 'Borrowed'),
(4, 'Gerald Escare', 'gerald@gmail.com', 'The Mongolloyddi', 0, '2024-12-03', '2024-12-28', 'Borrowed'),
(5, 'Gerald Escare', 'gerald@gmail.com', 'The Mongolloyddi', 0, '2024-12-03', '2024-12-28', 'Borrowed'),
(6, 'Liezel Villaester', 'ger@gmail.com', 'basta', 0, '2024-12-03', '2025-01-03', 'Borrowed'),
(7, '', '', 'The Mongolloyddi', 6, '2024-12-03', '2024-12-27', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `book_tbl`
--
ALTER TABLE `book_tbl`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrow_books`
--
ALTER TABLE `borrow_books`
  ADD PRIMARY KEY (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `book_tbl`
--
ALTER TABLE `book_tbl`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `borrow_books`
--
ALTER TABLE `borrow_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
