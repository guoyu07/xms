-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2009 at 08:04 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `xrx`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_module`
--

CREATE TABLE IF NOT EXISTS `category_module` (
  `category_id` bigint(20) unsigned NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `category_module` (`category_id`,`module_id`),
  KEY `category_id` (`category_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_module`
--

INSERT INTO `category_module` (`category_id`, `module_id`) VALUES
(1, 1),
(1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_module`
--
ALTER TABLE `category_module`
  ADD CONSTRAINT `category_module_ibfk_4` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_module_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;