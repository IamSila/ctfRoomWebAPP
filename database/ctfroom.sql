-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2025 at 09:19 AM
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
-- Database: `ctfroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `username`, `email`, `name`) VALUES
(1, 'silamulingi', 'sila@gmail.com', 'Sila Mulingi'),
(2, 'judge2', 'judge@email.com', 'Added another Judge'),
(5, 'jude3', 'judge3@gmail.com', 'judge 3'),
(6, 'judge4', 'judge@gmail.com', 'added judge'),
(7, 'denno', 'denis@email.com', 'Dennis qubit');

-- --------------------------------------------------------

--
-- Table structure for table `judge_scores`
--

CREATE TABLE `judge_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `judge_ip` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `category` enum('Web Security','Software Engineering','Linux','Binary Exploitation','General') NOT NULL,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `category`, `points`) VALUES
(1, 'jdoe', 'John', 'Doe', 'jdoe@example.com', 'Web Security', 80),
(2, 'asmith', 'Alice', 'Smith', 'asmith@example.com', 'Software Engineering', 100),
(3, 'bjohnson', 'Bob', 'Johnson', 'bjohnson@example.com', 'Linux', 78),
(4, 'cmiller', 'Carol', 'Miller', 'cmiller@example.com', 'Binary Exploitation', 80),
(5, 'dwilson', 'David', 'Wilson', 'dwilson@example.com', 'General', 65),
(6, 'eanderson', 'Eve', 'Anderson', 'eanderson@example.com', 'Web Security', 88),
(7, 'fthomas', 'Frank', 'Thomas', 'fthomas@example.com', 'Software Engineering', 75),
(8, 'gjackson', 'Grace', 'Jackson', 'gjackson@example.com', 'Linux', 82),
(9, 'hwhite', 'Henry', 'White', 'hwhite@example.com', 'Binary Exploitation', 90),
(10, 'iharris', 'Ivy', 'Harris', 'iharris@example.com', 'General', 70);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `judge_scores`
--
ALTER TABLE `judge_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_judging` (`user_id`,`judge_ip`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `judge_scores`
--
ALTER TABLE `judge_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
