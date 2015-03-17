-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2015 at 04:16 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nacoss_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_of_error` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `home_page_slider`
--

CREATE TABLE IF NOT EXISTS `home_page_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` text NOT NULL,
  `link` text NOT NULL,
  `caption` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `home_page_slider`
--

INSERT INTO `home_page_slider` (`id`, `img_url`, `link`, `caption`) VALUES
(1, 'img/b6.jpg', 'library.php', 'Keep learning, try out our e-Library'),
(2, 'img/b3.jpg', 'forum/', 'Sample messages'),
(3, 'img/b4.jpeg', '#', 'Sample messages');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `time_of_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire_date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(30) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('email', 'example@domain.com'),
('help_lines', '+23412345678, +23487654321');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `regno` varchar(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `other_names` varchar(30) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `department` varchar(20) DEFAULT NULL,
  `level` varchar(3) DEFAULT NULL,
  `phone` varchar(13) NOT NULL,
  `email` text NOT NULL,
  `dob` date DEFAULT NULL,
  `address1` text,
  `address2` text,
  `interest` text,
  `bio` text,
  `verified` int(1) NOT NULL DEFAULT '0',
  `is_suspended` int(1) NOT NULL DEFAULT '0',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`regno`),
  UNIQUE KEY `regno` (`regno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`regno`, `first_name`, `last_name`, `other_names`, `password`, `department`, `level`, `phone`, `email`, `dob`, `address1`, `address2`, `interest`, `bio`, `verified`, `is_suspended`, `is_deleted`) VALUES
('1234/123456', 'Jane', 'Doe', 'Anonymous', 'd14f21b5919900f4cc49333652fb4e92940ac55d', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
