-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 02:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `parent_post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `parent_post_id`, `author_id`, `body`, `created_at`) VALUES
(15, 22, 4, 'nice post', '2023-07-18 06:38:41'),
(29, 39, 1, 'lmao 3', '2023-07-19 17:14:16'),
(31, 39, 1, 'Another comment', '2023-07-19 18:15:00'),
(32, 41, 1, 'عليه الصلاة والسلام', '2023-07-19 19:00:00'),
(33, 40, 12, 'hello', '2023-07-19 19:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `author_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `created_at`, `author_id`, `image`) VALUES
(22, 'test1 title', 'test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ test1_BODY ___ ', '2023-07-17 22:48:04', 4, 'images/posts/20230717214804.jpg'),
(38, '', 'only body no image', '2023-07-19 16:58:17', 4, ''),
(39, '', 'body and image', '2023-07-19 16:59:09', 4, 'images/users/20230719155909.png'),
(40, '', 'admin post', '2023-07-19 18:17:43', 1, ''),
(41, '', 'صلي علي النبي', '2023-07-19 18:59:38', 12, ''),
(44, 'modify', '', '2023-07-19 19:23:18', 1, 'images/posts/20230719183206.');

-- --------------------------------------------------------

--
-- Table structure for table `reacts`
--

CREATE TABLE `reacts` (
  `react_id` int(11) NOT NULL,
  `react_parent_post` int(11) NOT NULL,
  `react_author` int(11) NOT NULL,
  `react_type` enum('thumbsup','love','haha','cry','angry') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `image`) VALUES
(1, 'Mazen Shams', 'mazen@email.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', 'images/users/1.jpg'),
(4, 'test4', 'test4@email.com', '86985e105f79b95d6bc918fb45ec7727', 'user', 'images/users/20230717233628.png'),
(12, 'Mostafa', 'sasa@email.com', 'f45731e3d39a1b2330bbf93e9b3de59e', 'user', 'images/users/20230719175905.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comment_post` (`parent_post_id`),
  ADD KEY `fk_comment_user` (`author_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_post_user` (`author_id`);

--
-- Indexes for table `reacts`
--
ALTER TABLE `reacts`
  ADD PRIMARY KEY (`react_id`),
  ADD KEY `fk_react_post` (`react_parent_post`),
  ADD KEY `fk_react_user` (`react_author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `reacts`
--
ALTER TABLE `reacts`
  MODIFY `react_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_post` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reacts`
--
ALTER TABLE `reacts`
  ADD CONSTRAINT `fk_react_post` FOREIGN KEY (`react_parent_post`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_react_user` FOREIGN KEY (`react_author`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
