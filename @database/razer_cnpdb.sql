-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2013 at 11:04 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `razer_cnpdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cnp_firm`
--

DROP TABLE IF EXISTS `cnp_firm`;
CREATE TABLE IF NOT EXISTS `cnp_firm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `website_url` varchar(150) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `position_firm` varchar(30) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `subscription_name` varchar(50) NOT NULL,
  `current_case_alloted` int(11) NOT NULL,
  `remaining_case` varchar(10) NOT NULL,
  `auto_renew_plan` varchar(10) NOT NULL COMMENT 'Yes / No',
  `firm_logo_url` varchar(50) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `account_status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `date_created` varchar(30) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `cnp_firm`
--

INSERT INTO `cnp_firm` (`id`, `firm_name`, `address`, `city`, `state`, `zip`, `website_url`, `contact_person`, `position_firm`, `email_address`, `subscription_id`, `subscription_name`, `current_case_alloted`, `remaining_case`, `auto_renew_plan`, `firm_logo_url`, `theme_id`, `is_archive`, `account_status`, `date_created`, `last_modified`) VALUES
(1, 'Razerbite Solutions', 'Bel-Air, Makati City ', 'Makati City', 'Option 1', '4025', 'www.razerbite.com', 'Patton Lucas', 'CEO / Founder', 'patton@razerbite.com', 1, '$2,995.00', 1000, '1000', 'Yes', '', 1, 'No', 'Active', '2013-07-17 17:02:58', '2013-07-17 09:08:30'),
(9, 'SGV & Co.', '6760 Ayala Avenue, Makati City, ', 'Makati City', 'Option 1', '1226', '', 'SyCip Gorres Velayo', 'CEO / Founder', 'sgv@gmail.com', 1, '$2,995.00', 1000, '1000', 'Yes', '8ce21e542f7be6e48f6bc5b616c64001370b880504140706.j', 1, 'No', 'Active', '2013-07-18 16:14:07', '2013-07-18 08:14:07'),
(28, 'T-One Vision Inc', 'Bel-Air, ITC Bldg. ', 'Makati City', 'Option 1', '4025', 'http://www.t-onevision.com.ph', 'Carlo Aguas', 'President / CEO', 'carlo.aguas@gmail.com', 1, '$2,995.00', 1000, '1000', 'Yes', 'a5211a801c6f94269b86dcd26b2025eb3ad1746c01350745.j', 1, 'No', 'Active', '2013-07-19 13:36:26', '2013-07-19 05:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `cnp_firm_contact_list`
--

DROP TABLE IF EXISTS `cnp_firm_contact_list`;
CREATE TABLE IF NOT EXISTS `cnp_firm_contact_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) NOT NULL,
  `contact_type` varchar(20) NOT NULL,
  `contact_value` varchar(30) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `cnp_firm_contact_list`
--

INSERT INTO `cnp_firm_contact_list` (`id`, `firm_id`, `contact_type`, `contact_value`, `extension`, `is_archive`, `date_created`, `last_modified`) VALUES
(1, 1, 'Mobile', '123123', '123123', 'No', '2013-07-17 17:02:58', '2013-07-17 09:02:58'),
(2, 1, 'Work', '123123', '123123', 'No', '2013-07-17 17:02:58', '2013-07-17 09:02:58'),
(3, 1, 'Home', '132312', '123123', 'No', '2013-07-17 17:02:58', '2013-07-17 09:02:58'),
(4, 1, 'Fax', '123213', '123213123', 'No', '2013-07-17 17:02:58', '2013-07-17 09:02:58'),
(47, 28, 'Mobile', '213', '123', 'No', '2013-07-19 13:36:26', '2013-07-19 05:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `cnp_firm_subscription_history`
--

DROP TABLE IF EXISTS `cnp_firm_subscription_history`;
CREATE TABLE IF NOT EXISTS `cnp_firm_subscription_history` (
  `id` bigint(20) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `subscription_name` varchar(50) NOT NULL,
  `case_alloted` varchar(10) NOT NULL,
  `auto_renew` varchar(10) NOT NULL COMMENT 'Yes / No',
  `renewal_date` varchar(20) NOT NULL,
  `payment_type` varchar(20) NOT NULL COMMENT 'Credit Card / Paypal',
  `transaction_number` varchar(20) NOT NULL,
  `date_paid` varchar(20) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cnp_firm_subscription_information`
--

DROP TABLE IF EXISTS `cnp_firm_subscription_information`;
CREATE TABLE IF NOT EXISTS `cnp_firm_subscription_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) NOT NULL,
  `subscription_type` varchar(20) NOT NULL COMMENT 'Free / Bronze / Silver / Gold',
  `remaining_cases` varchar(20) NOT NULL,
  `total_case_alloted` int(11) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cnp_settings_subscription_plan`
--

DROP TABLE IF EXISTS `cnp_settings_subscription_plan`;
CREATE TABLE IF NOT EXISTS `cnp_settings_subscription_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `case_alloted` varchar(10) NOT NULL,
  `price` varchar(20) NOT NULL,
  `is_active` varchar(10) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cnp_settings_subscription_plan`
--

INSERT INTO `cnp_settings_subscription_plan` (`id`, `subscription_name`, `description`, `case_alloted`, `price`, `is_active`, `date_created`, `last_modified`) VALUES
(1, '$2,995.00', 'Etiam congue sit amet est eget pharetra. Fusce luctus neque imperdiet semper facilisis. Maecenas consectetur eros nisl, ac eleifend sem bibendum eu. Nulla tempor tempor quam, in condimentum sem. Vivamus vel lectus dui. Donec scelerisque at nunc non eleifend. Cras vel sagittis felis, eu venenatis turpis. Nullam imperdiet, risus non blandit scelerisque, erat metus feugiat nunc, vitae tempus ante nisi non tellus. Cras ac tempor nulla, ', '1000', '2995', 'Yes', '2013-07-03 13:04:05', '2013-07-17 05:07:43'),
(2, '$1,995.00', 'Etiam congue sit amet est eget pharetra. Fusce luctus neque imperdiet semper facilisis. Maecenas consectetur eros nisl, ac eleifend sem bibendum eu. Nulla tempor tempor quam, in condimentum sem. Vivamus vel lectus dui. Donec scelerisque at nunc non eleifend. Cras vel sagittis felis, eu venenatis turpis. Nullam imperdiet, risus non blandit scelerisque, erat metus feugiat nunc, vitae tempus ante nisi non tellus. Cras ac tempor nulla, ', '500', '1995', 'Yes', '2013-07-03 13:04:05', '2013-07-17 05:06:06'),
(3, '$499.00', 'Etiam congue sit amet est eget pharetra. Fusce luctus neque imperdiet semper facilisis. Maecenas consectetur eros nisl, ac eleifend sem bibendum eu. Nulla tempor tempor quam, in condimentum sem. Vivamus vel lectus dui. Donec scelerisque at nunc non eleifend. Cras vel sagittis felis, eu venenatis turpis. Nullam imperdiet, risus non blandit scelerisque, erat metus feugiat nunc, vitae tempus ante nisi non tellus. Cras ac tempor nulla, ', '100', '449', 'Yes', '2013-07-03 13:04:05', '2013-07-17 05:06:09'),
(4, '$149.00', 'Etiam congue sit amet est eget pharetra. Fusce luctus neque imperdiet semper facilisis. Maecenas consectetur eros nisl, ac eleifend sem bibendum eu. Nulla tempor tempor quam, in condimentum sem. Vivamus vel lectus dui. Donec scelerisque at nunc non eleifend. Cras vel sagittis felis, eu venenatis turpis. Nullam imperdiet, risus non blandit scelerisque, erat metus feugiat nunc, vitae tempus ante nisi non tellus. Cras ac tempor nulla, ', '25', '149', 'Yes', '2013-07-03 13:04:05', '2013-07-17 05:06:12'),
(5, 'Free', 'Etiam congue sit amet est eget pharetra. Fusce luctus neque imperdiet semper facilisis. Maecenas consectetur eros nisl, ac eleifend sem bibendum eu. Nulla tempor tempor quam, in condimentum sem. Vivamus vel lectus dui. Donec scelerisque at nunc non eleifend. Cras vel sagittis felis, eu venenatis turpis. Nullam imperdiet, risus non blandit scelerisque, erat metus feugiat nunc, vitae tempus ante nisi non tellus. Cras ac tempor nulla, ', '10', 'Free', 'Yes', '2013-07-03 13:04:05', '2013-07-17 05:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `cnp_settings_theme`
--

DROP TABLE IF EXISTS `cnp_settings_theme`;
CREATE TABLE IF NOT EXISTS `cnp_settings_theme` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(30) NOT NULL,
  `content` int(11) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` int(11) NOT NULL,
  `last_modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cnp_user`
--

DROP TABLE IF EXISTS `cnp_user`;
CREATE TABLE IF NOT EXISTS `cnp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `account_type` varchar(50) NOT NULL COMMENT 'Super Administrator / Firm Administrator / Tech Administrator',
  `account_status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `last_change_password` varchar(20) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cnp_user`
--

INSERT INTO `cnp_user` (`id`, `firm_id`, `firstname`, `middlename`, `lastname`, `address`, `city`, `state`, `zip`, `email_address`, `username`, `password`, `hash`, `account_type`, `account_status`, `last_change_password`, `date_created`, `last_modified`) VALUES
(1, 1, 'Leo Angelo', 'Lariba', 'Diaz', 'Bel-Air, Makati City', 'Makati City', 'AR', '4025', 'leoangelo.diaz@razerbite.com', 'super_admin', 'QM8itO9c8cOl1y4FhYSGRFZOkSylH8hmen+Qa2jj/HgSoKW8yxHwUr4SqptKSBhBVxFeGDCDIR4P140NZFAxGQ==', 'sha256:1000:YvH5/iT8+FLnx/S17G/5eK/Su8BriNdv:XbH+DeECZ+1MxKGPjV1fe0lFTMuqt9iL', 'Super Administrator', 'Active', '', '2013-07-17 01:57:39', '2013-07-17 08:57:56'),
(2, 1, 'Patton', '', 'Lucas', 'Bel-Air, ITC Building ', 'Makati City', 'AL', '4025', 'patton@razerbite.com', 'patton.lucas', 'BGFysFZi9U8CeBql7aJQO52O64Bf5ifY+u4ngcThwXV8pZLn8HltapA60AsxFblqf/X2yPVbwlXKhxDxIakSqg==', 'sha256:1000:DzIb5trOH1HfYS2knAs035uDr2BO0JHD:kgjxIFndFCTACZbF5bea8aQJ0eGXloVJ', 'Tech Administrator', 'Active', '', '2013-07-19 12:39:28', '2013-07-19 04:39:28'),
(5, 1, 'Christine', '', 'Berces', 'Bel-Air, ITC Bldg. ', 'Makati City', 'AL', '4123', 'christine.berces@razerbite.com', 'christine.berces', 'C8v8MTYkQEtxX2u5QZyLJcupmR79T2wpQPXKooXzJqQP0/UBW9EYkF4b0k+jC9QMQff230V7xSn85m3QXukWEg==', 'sha256:1000:fCm5WCAfMsLBe6FSlx6GufC5LxpqVqiF:lENnXGA30uJO4NjlACH5Hm5ZRiQcUhQd', 'Tech Administrator', 'Active', '', '2013-07-19 12:46:26', '2013-07-19 04:46:26'),
(9, 1, 'Victor Inigo', '', 'Garcia', 'BF Homes ', 'Paranaque', 'AL', '12312', 'victor.garcia@razerbite.com', 'victor.garcia', 'fwv0880NWOt37BDTQglrlZRznQCZMcLa+uzdves5owUjlMzEZp6JQMWDC/Fc0o8+P2I832uJZMcRzsWiecJvNA==', 'sha256:1000:SFIAkBWY5iX6ZIKK+EvrwyqjCNC+GXOO:z9kWR05Qcdx5PfyLsIsRTG/MivZaDCcp', 'Tech Administrator', 'Active', '', '2013-07-19 12:51:44', '2013-07-19 04:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `cnp_user_contact_list`
--

DROP TABLE IF EXISTS `cnp_user_contact_list`;
CREATE TABLE IF NOT EXISTS `cnp_user_contact_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `contact_type` varchar(20) NOT NULL,
  `contact_value` varchar(30) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cnp_user_contact_list`
--

INSERT INTO `cnp_user_contact_list` (`id`, `user_id`, `contact_type`, `contact_value`, `extension`, `is_archive`, `date_created`, `last_modified`) VALUES
(4, 1, 'Mobile', '123123213', '', 'No', '2013-07-19 12:46:26', '2013-07-29 08:10:50');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
