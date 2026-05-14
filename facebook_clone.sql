-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 14, 2026 at 09:26 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

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
-- Struktura tabeli dla tabeli `posts`
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
(0, 'aaaaaaaaaaaa', '1778742300_1778693124_Снимок экрана 2026-05-13 192501.png', '2026-05-14 07:05:00', 0),
(0, 'What\'s on your mind?', '1778742322_1778693024_Снимок экрана 2025-08-12 232107.png', '2026-05-14 07:05:22', 0),
(0, 'What\'s on your mind?', '1778742327_1778682032_7daabf8906da059fcbc4f43bbcc78e3a.jpg', '2026-05-14 07:05:27', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
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
(5, 'VitalKor', 'admin@gmail.com', '$2y$10$9DqliToIp/77ou8rNhfYk.GG8ZpTYCY2b4YKSzHjEiC7CwUDuA322', '2026-05-04 16:12:29', 'default_avatar.jpg', '2026-05-13 12:40:10'),
(7, 'dffdfasda', 'asdadad@gmail.com', '$2y$10$fLIQJ0U6uwYW5Uj2AMXR2OAWooMG1IjCDsQ2rYndkx6e28zBKf9lO', '2026-05-05 08:32:02', 'default_avatar.jpg', '2026-05-13 12:40:10'),
(8, '1user2', 'asd@gmail.com', '$2y$10$pDRsMzUR91Nf16YzmCMQEO73Wvmpw78cMYzyhz5AjqOSfjU9ZzxlW', '2026-05-13 12:03:35', 'uploads/avatars/1778684290_8d8d339ff04988841494f62a49436480.jpg', '2026-05-13 13:26:33'),
(999, 'Developer', 'dev@test.com', 'none', '2026-05-13 12:11:52', 'default_avatar.jpg', '2026-05-13 12:40:10'),
(1000, '2user1', 'adsdsa@gmail.com', '$2y$10$XRT.dA9AFZq3RrvxUapfM.rd.cobSfNj5LFKYURZnoPvg1aMiMDCG', '2026-05-13 15:22:38', 'uploads/avatars/1778693040_Снимок экрана 2026-05-07 214433.png', '2026-05-13 15:24:00'),
(1001, 'ggg', 'ggg@gmail.com', '$2y$10$S.ZqgVKwts9i8rOT.8sBVus2U0L7FY9tDiL5R/7KX8AHS9peyXLde', '2026-05-13 15:24:31', 'uploads/avatars/1778693302_Снимок экрана 2025-04-11 204143.png', '2026-05-13 15:28:22'),
(1002, 'ss', 'ss@gmail.com', '$2y$10$znd8qIMH.G3iCdciOJsvDusnyFH3NLkDck98bqVZH5sCqhOowKQh2', '2026-05-13 15:29:50', 'uploads/avatars/1778693405_Снимок экрана 2025-04-01 121259.png', '2026-05-13 15:30:05'),
(1003, 'user', 'user@gmail.com', '$2y$10$W7liLBR56N5SKMeBOm1/2.8cczinslELOz7EF5XftiFDXWmDaII4e', '2026-05-13 17:12:15', 'uploads/avatars/1778699578_Снимок экрана 2025-03-31 211941.png', '2026-05-13 17:12:58'),
(0, '1user', 'user1@gmail.com', '$2y$10$uzgJUsEZ.RMLVzFsawsxKePxz/whbRof0wmqunYYzgPppt91p4f9q', '2026-05-14 07:04:43', 'uploads/avatars/1778742351_Снимок экрана 2026-05-10 134429.png', '2026-05-14 07:05:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
