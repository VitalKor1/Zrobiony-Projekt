-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 09:25 PM
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
-- Database: `facebook_clone`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `image`, `created_at`, `user_id`) VALUES
(55, 'que', '1778692939_Снимок экрана 2026-05-10 134424.png', '2026-05-13 17:22:20', 8),
(56, 'asd', '1778693024_Снимок экрана 2025-08-12 232107.png', '2026-05-13 17:23:44', 1000),
(57, 'ddd', '1778693124_Снимок экрана 2026-05-13 192501.png', '2026-05-13 17:25:24', 1001),
(58, 'asd', '1778693396_Снимок экрана 2025-03-29 214948.png', '2026-05-13 17:29:56', 1002);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`) VALUES
(3, 45, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT 'default_avatar.jpg',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `avatar`, `last_activity`) VALUES
(5, 'VitalKor', 'admin@gmail.com', '$2y$10$9DqliToIp/77ou8rNhfYk.GG8ZpTYCY2b4YKSzHjEiC7CwUDuA322', '2026-05-04 18:12:29', 'default_avatar.jpg', '2026-05-13 14:40:10'),
(7, 'dffdfasda', 'asdadad@gmail.com', '$2y$10$fLIQJ0U6uwYW5Uj2AMXR2OAWooMG1IjCDsQ2rYndkx6e28zBKf9lO', '2026-05-05 10:32:02', 'default_avatar.jpg', '2026-05-13 14:40:10'),
(8, '1user2', 'asd@gmail.com', '$2y$10$pDRsMzUR91Nf16YzmCMQEO73Wvmpw78cMYzyhz5AjqOSfjU9ZzxlW', '2026-05-13 14:03:35', 'uploads/avatars/1778684290_8d8d339ff04988841494f62a49436480.jpg', '2026-05-13 15:26:33'),
(999, 'Developer', 'dev@test.com', 'none', '2026-05-13 14:11:52', 'default_avatar.jpg', '2026-05-13 14:40:10'),
(1000, '2user1', 'adsdsa@gmail.com', '$2y$10$XRT.dA9AFZq3RrvxUapfM.rd.cobSfNj5LFKYURZnoPvg1aMiMDCG', '2026-05-13 17:22:38', 'uploads/avatars/1778693040_Снимок экрана 2026-05-07 214433.png', '2026-05-13 17:24:00'),
(1001, 'ggg', 'ggg@gmail.com', '$2y$10$S.ZqgVKwts9i8rOT.8sBVus2U0L7FY9tDiL5R/7KX8AHS9peyXLde', '2026-05-13 17:24:31', 'uploads/avatars/1778693302_Снимок экрана 2025-04-11 204143.png', '2026-05-13 17:28:22'),
(1002, 'ss', 'ss@gmail.com', '$2y$10$znd8qIMH.G3iCdciOJsvDusnyFH3NLkDck98bqVZH5sCqhOowKQh2', '2026-05-13 17:29:50', 'uploads/avatars/1778693405_Снимок экрана 2025-04-01 121259.png', '2026-05-13 17:30:05'),
(1003, 'user', 'user@gmail.com', '$2y$10$W7liLBR56N5SKMeBOm1/2.8cczinslELOz7EF5XftiFDXWmDaII4e', '2026-05-13 19:12:15', 'uploads/avatars/1778699578_Снимок экрана 2025-03-31 211941.png', '2026-05-13 19:12:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
