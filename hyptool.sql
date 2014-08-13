-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2014 at 06:00 PM
-- Server version: 5.1.58
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a4907786_hyps`
--

-- --------------------------------------------------------

--
-- Table structure for table `cores`
--

CREATE TABLE `cores` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `player_id` smallint(6) DEFAULT NULL,
  `alliance_id` smallint(6) DEFAULT NULL,
  `sc` tinyint(4) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `planet_1` mediumint(9) DEFAULT NULL,
  `planet_2` mediumint(9) DEFAULT NULL,
  `planet_3` mediumint(9) DEFAULT NULL,
  `planet_4` mediumint(9) DEFAULT NULL,
  `planet_5` mediumint(9) DEFAULT NULL,
  `planet_6` mediumint(9) DEFAULT NULL,
  `planet_7` mediumint(9) DEFAULT NULL,
  `planet_8` mediumint(9) DEFAULT NULL,
  `planet_9` mediumint(9) DEFAULT NULL,
  `planet_10` mediumint(9) DEFAULT NULL,
  `planet_11` mediumint(9) DEFAULT NULL,
  `planet_12` mediumint(9) DEFAULT NULL,
  `planet_13` mediumint(9) DEFAULT NULL,
  `planet_14` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`,`sc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `planets`
--

CREATE TABLE `planets` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `x_coord` tinyint(4) NOT NULL,
  `y_coord` tinyint(4) NOT NULL,
  `race` tinyint(3) unsigned NOT NULL,
  `prod_type` tinyint(3) unsigned NOT NULL,
  `gov_sys` tinyint(3) unsigned NOT NULL,
  `civ_lvl` tinyint(3) unsigned NOT NULL,
  `activity` mediumint(8) unsigned NOT NULL,
  `public_tag` varchar(7) NOT NULL,
  `planet_size` tinyint(3) unsigned NOT NULL,
  `sc` tinyint(3) unsigned NOT NULL,
  `uid` smallint(5) unsigned NOT NULL,
  KEY `id` (`id`,`sc`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `val` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
