/*
MySQL Data Transfer
Source Host: localhost
Source Database: codeigniter_fbapps
Target Host: localhost
Target Database: codeigniter_fbapps
Date: 1/13/2012 8:16:26 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for appmodule
-- ----------------------------
CREATE TABLE `appmodule` (
  `appmodule_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `about` text,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appmodule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contests
-- ----------------------------
CREATE TABLE `contests` (
  `contest_id` int(11) NOT NULL DEFAULT '0',
  `fbplatform_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_time` int(11) NOT NULL,
  `submission_end_time` int(11) NOT NULL,
  `winner_announce_time` int(11) DEFAULT NULL,
  `voting_start_time` int(11) DEFAULT NULL,
  `voting_end_time` int(11) DEFAULT NULL,
  `end_time` int(11) NOT NULL,
  `winner_selection_process` enum('judge','voting','votetojudge','judgetovote') NOT NULL DEFAULT 'judge',
  `avaliability` enum('on','off','declined') NOT NULL DEFAULT 'on',
  `timezone` varchar(20) NOT NULL,
  `appmodule_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contests_entrants
-- ----------------------------
CREATE TABLE `contests_entrants` (
  `fb_uid` bigint(20) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `fb_accesstoken` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fb_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contests_prize
-- ----------------------------
CREATE TABLE `contests_prize` (
  `prize_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`prize_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `password_salt` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for customer_constests
-- ----------------------------
CREATE TABLE `customer_constests` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for fbplatform
-- ----------------------------
CREATE TABLE `fbplatform` (
  `id` int(11) NOT NULL DEFAULT '0',
  `application_id` bigint(20) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records 
-- ----------------------------
