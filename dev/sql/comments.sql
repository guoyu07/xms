-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2009 at 11:41 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


--
-- Database: `xrx`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `author_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
