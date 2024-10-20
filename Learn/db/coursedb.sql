-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 01:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coursedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`user_id`, `playlist_id`) VALUES
('WQ62fuOFcl2TvBGwheHM', '');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(50) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `number`, `message`) VALUES
('lkjv', 'apu@gmail.com', '789461230', 'we are here'),
('lkjv', 'apu@gmail.com', '789461230', ''),
('alu', 'alu@gmail.com', '9876543210', 'vxcbnhkujm c vsnghj');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
('5ooPCnUyZ58ASNiqLSJK', '0', '6ZgsWczjwEN', 'Chapter 1', 'Introduction to graphics', 'Pbk0NkWy2yhj4WuXNG3r.mp4', 'NFPHf3Z3KVUvawU66n3L.jpg', '2024-10-05', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `tutor_id`, `content_id`) VALUES
('WQ62fuOFcl2TvBGwheHM', '0', '5ooPCnUyZ58ASNiqLSJK');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` varchar(11) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`) VALUES
('m3Gtr6NrXI4', '0', 'Development', 'Software development is the process of designing, creating, testing, and maintaining different software engineering.', 'aizus8Xze3BITcAv03ww.jpg', '2024-10-03', 'active'),
('6ZgsWczjwEN', '0', 'Graphic designer', 'Let us learn from Scratch', 'CXWZC9muJSMKKvsgat2w.jpg', '2024-10-05', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
('0', 'Arpita Baral', 'software', 'cde@gmail.com', '456789', '66fee31924434.jpg'),
('4', 'Ram', 'teacher', 'ram@gmail.com', '456789', '6702d591888d4.jpg'),
('7', 'papali', 'student', 'pa@gmail.com', '147258', 'RwAHvLX9CAHv4UTOY6c0.png'),
('ML46kvsPOvWW9KMwLqBi', 'Manju lata', 'teacher', 'manju123@gmail.com', '147852', 'Vxf5q3B2VZo9j7cppFtJ.png'),
('qQNWmazpzKaSbu6aruYb', 'Avishek', 'student', 'avi@gmail.com', 'avi@123', 'KQhyClBFObtaRjffjgzl.png'),
('VMWIJ99dXVMLUvtfrHbS', 'chiku', 'working', 'chiku@gmail.com', '12345', 'VYkR3e98WbORtC4CKgu5.png'),
('z6UaMkDPZGIcQYYR9oN7', 'Subhankar Lenka', 'devloper', 'shubha@gmail.com', 'shubha@123', 'sqwILA1gIm1qRUB06frp.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
('8QZNhdUVt7pPAC2qrHTV', 'sweety', 'sweety@gmail.com', '123789'),
('WQ62fuOFcl2TvBGwheHM', 'papali', 'pa@gmail.com', 'pa@123'),
('ixtcE3EYsTMtlc0q8CP6', 'rimini', 'rim@gmail.com', '123'),
('vs01rEfyVRkHcSwHaO8c', 'Monali Rout', 'monali@gmail.com', 'mona123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
