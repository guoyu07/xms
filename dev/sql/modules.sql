-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2009 at 11:45 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `xrx`
--

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `use_category` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `use_comment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `use_category`, `use_comment`) VALUES
(1, 'Default', 0, 0),
(2, 'Widgets', 0, 0),
(3, 'User', 0, 0),
(4, 'News', 1, 1),
(5, 'Category', 0, 0),
(6, 'Comment', 0, 0);
