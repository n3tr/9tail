-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2010 at 07:41 PM
-- Server version: 5.0.89
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ninetail_db_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tail_checkin`
--

CREATE TABLE `tail_checkin` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `place_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_friend`
--

CREATE TABLE `tail_friend` (
  `from` bigint(20) unsigned NOT NULL,
  `to` bigint(20) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL default '0',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `guid` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_messages`
--

CREATE TABLE `tail_messages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `to` bigint(20) unsigned NOT NULL,
  `from` bigint(20) unsigned NOT NULL,
  `text` text NOT NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_photo_album`
--

CREATE TABLE `tail_photo_album` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default 'Untitled',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` bigint(20) unsigned default NULL,
  `place_id` bigint(20) unsigned default NULL,
  `thumb_path` varchar(255) NOT NULL default 'default_album.jpg',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_place`
--

CREATE TABLE `tail_place` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `create_by` bigint(20) NOT NULL,
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `official` int(11) NOT NULL default '0',
  `guid` varchar(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `guid` (`guid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_place_address`
--

CREATE TABLE `tail_place_address` (
  `place_id` bigint(20) unsigned NOT NULL,
  `address` varchar(255) default NULL,
  `tambon` varchar(255) default NULL,
  `amphoe` varchar(255) default NULL,
  `province` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `postal` varchar(10) default NULL,
  `guid` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_tip`
--

CREATE TABLE `tail_tip` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `text` text NOT NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `place_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_user`
--

CREATE TABLE `tail_user` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `screen_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` int(11) unsigned NOT NULL default '0',
  `gender` int(11) unsigned NOT NULL default '0',
  `thumbnail` varchar(255) NOT NULL default 'default_thumbnail.jpg',
  `small_thumbnail` varchar(255) NOT NULL default 'small_default_thumbnail',
  `guid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `screen_name` (`screen_name`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tail_user_photo`
--

CREATE TABLE `tail_user_photo` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `album_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `thumb_path` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
