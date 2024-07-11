-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2023 at 02:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reviews_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chef`
--

CREATE TABLE `chef` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` varchar(20) NOT NULL,
  `UserID` varchar(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(30) NOT NULL,
  `cuisine` varchar(25) NOT NULL,
  `ingredients` varchar(100) NOT NULL,
  `directions` text NOT NULL,
  `preparation_time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `UserID`, `title`, `image`, `cuisine`, `ingredients`, `directions`, `preparation_time`) VALUES
('NgFZhBDgpNVclzJpcKoM', 'eRRbMJmjGn', 'recipe', 'bGDgq8lYSFquWWoCiPPb.jpg', 'American', 'ingredient 1$ ingredient 1$ ingredient 1$ ingredient 1', 'step 1 ste', '13');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` varchar(20) NOT NULL,
  `RecipeID` varchar(20) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `Rating` varchar(1) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `RecipeID`, `UserID`, `Rating`, `description`, `date`) VALUES
('nSc18iJVyokD15VKd4rh', 'WyWdDHZmwk73CfuXpUa4', 'eRRbMJmjGnu60Srb27T5', '5', 'g', '2023-06-10'),
('7EpBenvSj6z6lFG6lVLW', 'bppN8lRwyFKQJHYSDZay', 'eRRbMJmjGnu60Srb27T5', '1', 'mmmmmmmmmmmmmmmmmmmm', '2023-06-10'),
('8JC9J5On5bKbBkuehKJo', 'NgFZhBDgpNVclzJpcKoM', 'ElE8Cvm3F6gAxq7BHc2k', '1', 'hhhhhhhhhhhhhhhhhhhhhhhhh', '2023-06-10'),
('m2jb6vqNaeD9VC52sbqn', 'NgFZhBDgpNVclzJpcKoM', '0HLLt6zaCbWxqAGY8p0Q', '1', 'vvl;svsl;kvsl;vksl;vkl;vkl;kvsl;kl;', '2023-06-11'),
('Jpz4E0XebMQ7stllypzF', 'NgFZhBDgpNVclzJpcKoM', 'iSXAF56wJj8loBT8gSwJ', '5', 'bhhjghjghjghjghjghjghjgjhghj', '2023-06-11'),
('ukdBrdkppvz2dJcQ566a', 'NgFZhBDgpNVclzJpcKoM', 'GugsPp1a1Zn9IYcT6IOq', '1', 'hjghjghjghjghjghjghjghj', '2023-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('0HLLt6zaCbWxqAGY8p0Q', 'Nethmina', 'abc@gmail.com', '$2y$10$UszLgXl1IDZ6NMS23FrfKeFQPhLFSCE2Et3eYjqLJJipcbUPf0pd2', 'jJyf708fcbLcIbhssXNu.jpg'),
('iSXAF56wJj8loBT8gSwJ', 'Akalanka', '123@gmail.com', '$2y$10$67pXXyhzP36ds9fvy5zmYul/N.hf1i7W64i0Hd7Xqqv29ZUUcRmI.', 'CrLkMFtLveatvDrYhvQK.jpg'),
('GugsPp1a1Zn9IYcT6IOq', 'Dias', 'akalanka@gmail.com', '$2y$10$wNLWzmAL/dEGTvHu3yHnFuF.nJ.voR//pVoVClmqtXyfjdIqA6q.2', 'nOWBVW38DHPWFWxSdZsG.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
