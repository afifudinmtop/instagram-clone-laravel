-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2023 at 06:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram-clone-laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `post` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp(),
  `hapus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `uuid`, `user`, `post`, `comment`, `ts`, `hapus`) VALUES
(7, '643e6fc496ce2', '643cec746725a', '643cfbea019e7', 'komen1', '2023-04-18 10:24:04', NULL),
(8, '644a304ee1556', '644a0af16b44f', '643cfbea019e7', 'komen 2', '2023-04-27 08:20:30', NULL),
(9, '644b3c2a2d7bc', '643cec746725a', '644b2dae1cc6d', 'nice view', '2023-04-28 03:23:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dm`
--

CREATE TABLE `dm` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `target` text DEFAULT NULL,
  `chat` text DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dm`
--

INSERT INTO `dm` (`id`, `uuid`, `user`, `target`, `chat`, `ts`) VALUES
(5, '644b3be1e7f60', '644a0af16b44f', '643cec746725a', 'halo gan', '2023-04-28 03:22:09'),
(6, '644b3bf097094', '644a0af16b44f', '643cec746725a', 'apa kabar?', '2023-04-28 03:22:24'),
(7, '644b3c103561d', '643cec746725a', '644a0af16b44f', 'ok mantab', '2023-04-28 03:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `following` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`id`, `uuid`, `user`, `following`) VALUES
(11, '644a1541d0ed4', '644a0af16b44f', '643cec746725a'),
(12, '644b3c188cc2f', '643cec746725a', '644a0af16b44f');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `post` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `uuid`, `user`, `post`) VALUES
(4, '643e3728ef70e', '643cec746725a', '643cfbea019e7'),
(10, '644b2d9389f92', '644a0af16b44f', '643cfbea019e7'),
(11, '644b2dbe47105', '644a0af16b44f', '644b2dae1cc6d'),
(12, '644b3c21d97ef', '643cec746725a', '644b2dae1cc6d');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp(),
  `hapus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `uuid`, `user`, `image`, `caption`, `ts`, `hapus`) VALUES
(25, '643cfbea019e7', '643cec746725a', '643cfbe2e317c.jpg', 'tes1', '2023-04-17 07:57:30', NULL),
(26, '644b2dae1cc6d', '644a0af16b44f', '644b2da78994d.jpg', 'mantab', '2023-04-28 02:21:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `post` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`id`, `uuid`, `user`, `post`) VALUES
(3, '643e3b2beb11d', '643cec746725a', '643cfbea019e7'),
(4, '644a5dac7bb97', '644a0af16b44f', '643cfbea019e7'),
(5, '644b2db35f7e8', '644a0af16b44f', '644b2dae1cc6d');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `uuid` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `hapus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uuid`, `username`, `password`, `first_name`, `last_name`, `image`, `bio`, `hapus`) VALUES
(1, '643cec746725a', 'apip1', '$2y$10$.iMht.5Wha2IQ1DGE5vkGuDSmGMTZkFgjcaGem6pnXNcAck9VW0Ai', 'apip1', 'udin1', '644a0a603d47c.jpg', 'biox apip1', NULL),
(2, '644a0af16b44f', 'apip2', '$2y$10$ym5RSDec9.PZZswWBqE.5OPRY.kvJYHD5P03SeyaQgj9uVEH2k4wS', 'apip2', 'udin2', 'default.png', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dm`
--
ALTER TABLE `dm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved`
--
ALTER TABLE `saved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dm`
--
ALTER TABLE `dm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `saved`
--
ALTER TABLE `saved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
