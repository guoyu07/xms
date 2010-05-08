-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2010 at 08:07 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


--
-- Database: `xrx`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `name_module` (`name`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `settings` (`name`, `value`, `module`) VALUES
('default_status', 'approved', 'comment'),
('items_per_page', '10', 'general'),
('public_registration', '1', 'user'),
('recaptcha_private_key', '', 'general'),
('recaptcha_public_key', '', 'general'),
('show_on_front', 'news', 'general'),
('show_on_front_id', '0', 'general'),
('use_recaptcha', '0', 'comment'),
('website_title', 'XRX', 'general');