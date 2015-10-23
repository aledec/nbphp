-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2015 at 03:53 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nbu`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `hardware` text NOT NULL,
  `os` text NOT NULL,
  `client` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`hardware`, `os`, `client`, `comment`) VALUES
('vmx-07', 'otherLinux64Guest', '10.1.1.1', '');

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE IF NOT EXISTS `errors` (
  `status` char(10) CHARACTER SET utf8 NOT NULL,
  `client` char(50) CHARACTER SET utf8 NOT NULL,
  `policy` char(100) CHARACTER SET utf32 NOT NULL,
  `type` char(50) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `result` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`status`, `client`, `policy`, `type`, `date`, `result`) VALUES
('0', 'hostname1', 'UNIX-Oracle-SAPP', 'Daily', '2015-08-17 00:00:07', 'Success'),
('0', 'hostname2', 'UNIX-Oracle-Arch', 'Daily', '2015-08-17 00:00:13', 'Success');


-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `client_timestamp` char(50) NOT NULL,
  `client` char(50) NOT NULL,
  `policy` char(100) NOT NULL,
  `sched_label` char(50) NOT NULL,
  `retention_level` char(50) NOT NULL,
  `backup_time` datetime NOT NULL,
  `elapsed_time` mediumint(9) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `kilobytes` bigint(20) NOT NULL,
  `number_of_files` int(11) NOT NULL,
  `number_of_copies` tinyint(4) NOT NULL,
  `status` tinyint(5) NOT NULL,
  `storage_lifecycle_policy` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`client_timestamp`, `client`, `policy`, `sched_label`, `retention_level`, `backup_time`, `elapsed_time`, `expiration_time`, `kilobytes`, `number_of_files`, `number_of_copies`, `status`, `storage_lifecycle_policy`) VALUES
('10.1.1.1_1438446063', '10.1.1.1', 'VMWARE-Policy', 'Weekly', '6 months (6)', '2015-08-01 12:21:03', 279, '2016-02-03 12:21:03', 6009369, 37813, 2, 0, 'Weekly_Windows');


-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE IF NOT EXISTS `policies` (
  `name` text NOT NULL,
  `template` text NOT NULL,
  `type` text NOT NULL,
  `active` text NOT NULL,
  `active_since` datetime NOT NULL,
  `client` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`name`, `template`, `type`, `active`, `active_since`, `client`) VALUES
('Catalog-Backup-Online', 'FALSE', 'NBU-Catalog (35)', 'yes', '2007-08-02 11:01:00', 'hostname3'),
('UNIX-FS-POSPRD-LifeCycle-Policy', 'FALSE', 'Standard (0)', 'yes', '2007-04-13 09:44:45', 'hostname2');