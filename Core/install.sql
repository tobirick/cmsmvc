-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2018 at 09:16 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'active_theme_id', '2'),
(2, 'active_menu_id', '2'),
(3, 'active_footer_menu_id', '3'),
(4, 'siteurl', ''),
(5, 'sitename', ''),
(6, 'sitedesc', '');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`) VALUES
(3, 'footer-nav'),
(2, 'main-nav');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `menu_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `menu_id`, `page_id`, `menu_position`) VALUES
(61, 'Homepage', 2, 7, 1),
(62, 'Über uns', 2, 8, 2),
(89, 'Contact', 2, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pagebuilder_columnrows`
--

CREATE TABLE `pagebuilder_columnrows` (
  `id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagebuilder_columnrows`
--

INSERT INTO `pagebuilder_columnrows` (`id`, `row_id`, `position`) VALUES
(73, 87, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pagebuilder_columns`
--

CREATE TABLE `pagebuilder_columns` (
  `id` int(11) NOT NULL,
  `columnrow_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `col` varchar(255) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `css_id` varchar(255) NOT NULL,
  `styles` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagebuilder_columns`
--

INSERT INTO `pagebuilder_columns` (`id`, `columnrow_id`, `position`, `col`, `css_class`, `css_id`, `styles`) VALUES
(156, 73, 0, '3', '', '', ''),
(157, 73, 0, '3', '', '', ''),
(158, 73, 0, '3', '', '', ''),
(159, 73, 0, '3', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pagebuilder_items`
--

CREATE TABLE `pagebuilder_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path_name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `html` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagebuilder_items`
--

INSERT INTO `pagebuilder_items` (`id`, `name`, `path_name`, `content`, `type`, `description`, `html`) VALUES
(5, 'Text', 'C:\\xampp\\htdocs\\trmvc\\App\\Models/../Views/admin/pagebuilder-items/Text.blade.php', 'Test123', 'fa fa-text-width', '', ''),
(6, 'Button', 'C:\\xampp\\htdocs\\trmvc\\App\\Models/../Views/admin/pagebuilder-items/Button.blade.php', 'test3', 'fa fa-users', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pagebuilder_rows`
--

CREATE TABLE `pagebuilder_rows` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `section_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `css_id` varchar(255) NOT NULL,
  `styles` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagebuilder_rows`
--

INSERT INTO `pagebuilder_rows` (`id`, `name`, `section_id`, `position`, `css_class`, `css_id`, `styles`) VALUES
(87, '', 90, 0, '', '', ''),
(88, '', 90, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pagebuilder_sections`
--

CREATE TABLE `pagebuilder_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `page_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `css_id` varchar(255) NOT NULL,
  `styles` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagebuilder_sections`
--

INSERT INTO `pagebuilder_sections` (`id`, `name`, `page_id`, `position`, `css_class`, `css_id`, `styles`) VALUES
(90, '', 7, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `title`, `content`) VALUES
(7, 'About', 'about', 'About Title', 'about content'),
(8, 'Contact', 'contact', 'Contact Page', 'This is contact page'),
(19, 'Home', 'home', 'Home Title', 'home content');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `path`) VALUES
(2, 'trtheme', 'App/Views/public/themes/trtheme');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `name`, `created_at`) VALUES
(5, 'tobi@tobi.de', '$2y$10$Jvx1yghLELhfceZKqGqveOOQRe1xwCNjZgLybLboSbjk.dsQxZuc6', 'tobi', '0000-00-00 00:00:00'),
(16, 'tobias.rickmann@pp-systeme.de', '$2y$10$v5aCoa3axt2dUf3qvy7zre/gZULnDMwhMr1P/xD/fzURSXYBrsIMi', 'tobirick', '0000-00-00 00:00:00'),
(17, 'test@test.de', '$2y$10$9IodbfIiUPvTfh.CsJZVOe62TLCeUR9yN0RymrgDi3aej4ApQVowe', 'testtest', '0000-00-00 00:00:00'),
(18, 'tester@tester.de', '$2y$10$57.RYuU9aZzrSAiziGKhF.LD9aJ742PP6mc0fNzzyJYUJFTppG3TO', 'tobi123', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagebuilder_columnrows`
--
ALTER TABLE `pagebuilder_columnrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `row_id` (`row_id`);

--
-- Indexes for table `pagebuilder_columns`
--
ALTER TABLE `pagebuilder_columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `columnrow_id` (`columnrow_id`);

--
-- Indexes for table `pagebuilder_items`
--
ALTER TABLE `pagebuilder_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagebuilder_rows`
--
ALTER TABLE `pagebuilder_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `pagebuilder_sections`
--
ALTER TABLE `pagebuilder_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `path` (`path`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `pagebuilder_columnrows`
--
ALTER TABLE `pagebuilder_columnrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `pagebuilder_columns`
--
ALTER TABLE `pagebuilder_columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
--
-- AUTO_INCREMENT for table `pagebuilder_items`
--
ALTER TABLE `pagebuilder_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pagebuilder_rows`
--
ALTER TABLE `pagebuilder_rows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `pagebuilder_sections`
--
ALTER TABLE `pagebuilder_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pagebuilder_columnrows`
--
ALTER TABLE `pagebuilder_columnrows`
  ADD CONSTRAINT `pagebuilder_columnrows_ibfk_1` FOREIGN KEY (`row_id`) REFERENCES `pagebuilder_rows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagebuilder_columns`
--
ALTER TABLE `pagebuilder_columns`
  ADD CONSTRAINT `pagebuilder_columns_ibfk_1` FOREIGN KEY (`columnrow_id`) REFERENCES `pagebuilder_columnrows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagebuilder_rows`
--
ALTER TABLE `pagebuilder_rows`
  ADD CONSTRAINT `pagebuilder_rows_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `pagebuilder_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagebuilder_sections`
--
ALTER TABLE `pagebuilder_sections`
  ADD CONSTRAINT `pagebuilder_sections_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
