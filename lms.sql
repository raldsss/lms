-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 01:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `admin_name`, `email`, `mobile_number`, `username`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', '09207029503', 'Admin', 'admin');

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
(1, 1, 'Admin', '978-0743273565', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', '1925', 'Scribner', 18, 20, '2024-11-29 14:18:32', 'The_Great_Gatsby_Cover_1925_Retouched.jpg', 'Available'),
(4, 1, 'Admin', '9780061120084', 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', '1920', 'J.B. Lippincott & Co.', 15, 15, '2024-11-29 14:59:54', 'tokillamockingbird.jpg', 'Available'),
(7, 1, 'Admin', '978-1-86197-876-9', 'Journey Through Space', 'John Smith', 'Science Fiction', '2019', 'Galaxy Reads Publishing', 10, 15, '2024-12-07 11:37:23', 'journey_through_space.jpg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_tbl`
--

CREATE TABLE `borrow_tbl` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_uid` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_course` varchar(255) NOT NULL,
  `student_year` int(11) NOT NULL,
  `student_section` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_category` varchar(255) NOT NULL,
  `borrow_quantity` int(11) NOT NULL,
  `date_borrow` date NOT NULL,
  `date_return` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_tbl`
--

INSERT INTO `borrow_tbl` (`borrow_id`, `book_id`, `admin_id`, `admin_name`, `student_id`, `student_uid`, `student_name`, `student_course`, `student_year`, `student_section`, `book_title`, `book_category`, `borrow_quantity`, `date_borrow`, `date_return`, `status`) VALUES
(1, 7, '1', 'Admin', 1, '331383873', 'Kerwin Gelasing', 'BSTech', 3, 'A', 'Journey Through Space', 'Science Fiction', 5, '2024-12-07', '2024-12-20', 'Approved'),
(2, 1, '1', 'Admin', 1, '331383873', 'Kerwin Gelasing', 'BSTech', 3, 'A', 'The Great Gatsby', 'Fiction', 2, '2024-12-07', '2024-12-13', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `student_tbl`
--

CREATE TABLE `student_tbl` (
  `student_id` int(11) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `student_uid` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_course` varchar(255) NOT NULL,
  `student_year` int(11) NOT NULL,
  `student_section` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tbl`
--

INSERT INTO `student_tbl` (`student_id`, `admin_id`, `admin_name`, `student_uid`, `student_name`, `student_course`, `student_year`, `student_section`, `student_password`) VALUES
(1, '1', 'Admin', '331383873', 'Kerwin Gelasing', 'BSTech', 3, 'A', 'kerwin'),
(2, '1', 'Admin', '2020115058', 'John Dela Cruz', 'Bachelor of Science in Information Technology', 2, 'A', 'john'),
(3, '1', 'Admin', '2024-10002', 'Maria Clara Santos', 'Bachelor of Science in Accountancy (BSA)', 3, 'C', 'maria');

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
-- Indexes for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD PRIMARY KEY (`borrow_id`);

--
-- Indexes for table `student_tbl`
--
ALTER TABLE `student_tbl`
  ADD PRIMARY KEY (`student_id`);

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
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_tbl`
--
ALTER TABLE `student_tbl`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
