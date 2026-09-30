-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 30, 2026 at 05:45 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paytest`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser_agent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `type`, `ip_address`, `browser_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.14.7 Chrome/144.0.7559.236 Electron/40.10.3 Safari/537.36', '2026-08-06 03:46:02', '2026-08-06 03:46:02'),
(2, 1, 'User', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.17.8 Chrome/144.0.7559.236 Electron/40.10.3 Safari/537.36', '2026-09-30 12:01:17', '2026-09-30 12:01:17'),
(3, 1, 'User', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.17.8 Chrome/144.0.7559.236 Electron/40.10.3 Safari/537.36', '2026-09-30 12:12:10', '2026-09-30 12:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

DROP TABLE IF EXISTS `addons`;
CREATE TABLE IF NOT EXISTS `addons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_identifier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` int NOT NULL DEFAULT '1',
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `addons_unique_identifier_unique` (`unique_identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active or Inactive',
  `picture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  UNIQUE KEY `admins_phone_unique` (`phone`),
  KEY `admins_role_id_index` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `first_name`, `last_name`, `phone`, `email`, `password`, `status`, `picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'Techvill', NULL, 'info@paymanent.com', '$2y$10$rQHsphzmtVN4kDLUwtdQHO4BOwty8IDAa.z2DyCex/vIUaJyAoWN.', 'Active', '273.jpg', 'wOAKqFJAai9to6zBb2vNXonQsRvri4sKwVzOYxVe2bYOm9VEgzV1729uTfhp', '2024-01-22 02:28:28', '2024-01-22 02:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `aeps_transactions`
--

DROP TABLE IF EXISTS `aeps_transactions`;
CREATE TABLE IF NOT EXISTS `aeps_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `reference_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar_masked` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `api_response` json DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aeps_transactions_reference_id_unique` (`reference_id`),
  KEY `aeps_transactions_user_id_index` (`user_id`),
  KEY `aeps_transactions_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_request_logs`
--

DROP TABLE IF EXISTS `api_request_logs`;
CREATE TABLE IF NOT EXISTS `api_request_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `module` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_headers_masked` json DEFAULT NULL,
  `request_body_masked` json DEFAULT NULL,
  `response_status` smallint UNSIGNED DEFAULT NULL,
  `response_body_summary` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `api_request_logs_user_id_index` (`user_id`),
  KEY `api_request_logs_module_index` (`module`),
  KEY `api_request_logs_action_index` (`action`),
  KEY `api_request_logs_reference_id_index` (`reference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_store_credentials`
--

DROP TABLE IF EXISTS `app_store_credentials`;
CREATE TABLE IF NOT EXISTS `app_store_credentials` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `has_app_credentials` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yes or No',
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Google or Apple',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_store_credentials`
--

INSERT INTO `app_store_credentials` (`id`, `has_app_credentials`, `link`, `logo`, `company`, `created_at`, `updated_at`) VALUES
(1, 'Yes', 'http://store.google.com/pay-money', '1531650482.png', 'Google', NULL, NULL),
(2, 'Yes', 'https://itunes.apple.com/bd/app/pay-money', '1531134592.png', 'Apple', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_tokens`
--

DROP TABLE IF EXISTS `app_tokens`;
CREATE TABLE IF NOT EXISTS `app_tokens` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_id` int UNSIGNED NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_in` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_tokens_app_id_index` (`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_transactions_infos`
--

DROP TABLE IF EXISTS `app_transactions_infos`;
CREATE TABLE IF NOT EXISTS `app_transactions_infos` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_id` int UNSIGNED NOT NULL,
  `payment_method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(20,8) NOT NULL,
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `success_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_in` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, success, cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_transactions_infos_app_id_index` (`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `country_id` int UNSIGNED DEFAULT NULL,
  `file_id` int UNSIGNED DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `swift_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No' COMMENT 'No, Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banks_user_id_index` (`user_id`),
  KEY `banks_admin_id_index` (`admin_id`),
  KEY `banks_currency_id_index` (`currency_id`),
  KEY `banks_country_id_index` (`country_id`),
  KEY `banks_file_id_index` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_payment_transactions`
--

DROP TABLE IF EXISTS `bill_payment_transactions`;
CREATE TABLE IF NOT EXISTS `bill_payment_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `reference_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumer_number` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `bill_fetch` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_response` json DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bill_payment_transactions_reference_id_unique` (`reference_id`),
  KEY `bill_payment_transactions_user_id_index` (`user_id`),
  KEY `bill_payment_transactions_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_booking_transactions`
--

DROP TABLE IF EXISTS `bus_booking_transactions`;
CREATE TABLE IF NOT EXISTS `bus_booking_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `reference_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pnr` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trip_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_city_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_city_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_city_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_city_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `passenger_details` json DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `api_response` json DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_ref` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bus_booking_transactions_user_id_index` (`user_id`),
  KEY `bus_booking_transactions_reference_id_index` (`reference_id`),
  KEY `bus_booking_transactions_pnr_index` (`pnr`),
  KEY `bus_booking_transactions_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coinpayment_log_trxes`
--

DROP TABLE IF EXISTS `coinpayment_log_trxes`;
CREATE TABLE IF NOT EXISTS `coinpayment_log_trxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `merchant_id` int NOT NULL,
  `payment_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `payment_created_at` datetime NOT NULL,
  `expired` datetime NOT NULL,
  `confirmation_at` datetime DEFAULT NULL,
  `amount` double(20,8) NOT NULL,
  `confirms_needed` int NOT NULL,
  `qrcode_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `short_name` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_short_name_unique` (`short_name`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `short_name`, `name`, `iso3`, `number_code`, `phone_code`, `is_default`) VALUES
(1, 'AF', 'Afghanistan', 'AFG', '4', '93', 'no'),
(2, 'AL', 'Albania', 'ALB', '8', '355', 'no'),
(3, 'DZ', 'Algeria', 'DZA', '12', '213', 'no'),
(4, 'AS', 'American Samoa', 'ASM', '16', '1684', 'no'),
(5, 'AD', 'Andorra', 'AND', '20', '376', 'no'),
(6, 'AO', 'Angola', 'AGO', '24', '244', 'no'),
(7, 'AI', 'Anguilla', 'AIA', '660', '1264', 'no'),
(8, 'AQ', 'Antarctica', NULL, NULL, '0', 'no'),
(9, 'AG', 'Antigua and Barbuda', 'ATG', '28', '1268', 'no'),
(10, 'AR', 'Argentina', 'ARG', '32', '54', 'no'),
(11, 'AM', 'Armenia', 'ARM', '51', '374', 'no'),
(12, 'AW', 'Aruba', 'ABW', '533', '297', 'no'),
(13, 'AU', 'Australia', 'AUS', '36', '61', 'no'),
(14, 'AT', 'Austria', 'AUT', '40', '43', 'no'),
(15, 'AZ', 'Azerbaijan', 'AZE', '31', '994', 'no'),
(16, 'BS', 'Bahamas', 'BHS', '44', '1242', 'no'),
(17, 'BH', 'Bahrain', 'BHR', '48', '973', 'no'),
(18, 'BD', 'Bangladesh', 'BGD', '50', '880', 'no'),
(19, 'BB', 'Barbados', 'BRB', '52', '1246', 'no'),
(20, 'BY', 'Belarus', 'BLR', '112', '375', 'no'),
(21, 'BE', 'Belgium', 'BEL', '56', '32', 'no'),
(22, 'BZ', 'Belize', 'BLZ', '84', '501', 'no'),
(23, 'BJ', 'Benin', 'BEN', '204', '229', 'no'),
(24, 'BM', 'Bermuda', 'BMU', '60', '1441', 'no'),
(25, 'BT', 'Bhutan', 'BTN', '64', '975', 'no'),
(26, 'BO', 'Bolivia', 'BOL', '68', '591', 'no'),
(27, 'BA', 'Bosnia and Herzegovina', 'BIH', '70', '387', 'no'),
(28, 'BW', 'Botswana', 'BWA', '72', '267', 'no'),
(29, 'BV', 'Bouvet Island', NULL, NULL, '0', 'no'),
(30, 'BR', 'Brazil', 'BRA', '76', '55', 'no'),
(31, 'IO', 'British Indian Ocean Territory', NULL, NULL, '246', 'no'),
(32, 'BN', 'Brunei Darussalam', 'BRN', '96', '673', 'no'),
(33, 'BG', 'Bulgaria', 'BGR', '100', '359', 'no'),
(34, 'BF', 'Burkina Faso', 'BFA', '854', '226', 'no'),
(35, 'BI', 'Burundi', 'BDI', '108', '257', 'no'),
(36, 'KH', 'Cambodia', 'KHM', '116', '855', 'no'),
(37, 'CM', 'Cameroon', 'CMR', '120', '237', 'no'),
(38, 'CA', 'Canada', 'CAN', '124', '1', 'no'),
(39, 'CV', 'Cape Verde', 'CPV', '132', '238', 'no'),
(40, 'KY', 'Cayman Islands', 'CYM', '136', '1345', 'no'),
(41, 'CF', 'Central African Republic', 'CAF', '140', '236', 'no'),
(42, 'TD', 'Chad', 'TCD', '148', '235', 'no'),
(43, 'CL', 'Chile', 'CHL', '152', '56', 'no'),
(44, 'CN', 'China', 'CHN', '156', '86', 'no'),
(45, 'CX', 'Christmas Island', NULL, NULL, '61', 'no'),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, NULL, '672', 'no'),
(47, 'CO', 'Colombia', 'COL', '170', '57', 'no'),
(48, 'KM', 'Comoros', 'COM', '174', '269', 'no'),
(49, 'CG', 'Congo', 'COG', '178', '242', 'no'),
(50, 'CD', 'Congo, the Democratic Republic of the', 'COD', '180', '242', 'no'),
(51, 'CK', 'Cook Islands', 'COK', '184', '682', 'no'),
(52, 'CR', 'Costa Rica', 'CRI', '188', '506', 'no'),
(53, 'CI', 'Cote D\'Ivoire', 'CIV', '384', '225', 'no'),
(54, 'HR', 'Croatia', 'HRV', '191', '385', 'no'),
(55, 'CU', 'Cuba', 'CUB', '192', '53', 'no'),
(56, 'CY', 'Cyprus', 'CYP', '196', '357', 'no'),
(57, 'CZ', 'Czech Republic', 'CZE', '203', '420', 'no'),
(58, 'DK', 'Denmark', 'DNK', '208', '45', 'no'),
(59, 'DJ', 'Djibouti', 'DJI', '262', '253', 'no'),
(60, 'DM', 'Dominica', 'DMA', '212', '1767', 'no'),
(61, 'DO', 'Dominican Republic', 'DOM', '214', '1809', 'no'),
(62, 'EC', 'Ecuador', 'ECU', '218', '593', 'no'),
(63, 'EG', 'Egypt', 'EGY', '818', '20', 'no'),
(64, 'SV', 'El Salvador', 'SLV', '222', '503', 'no'),
(65, 'GQ', 'Equatorial Guinea', 'GNQ', '226', '240', 'no'),
(66, 'ER', 'Eritrea', 'ERI', '232', '291', 'no'),
(67, 'EE', 'Estonia', 'EST', '233', '372', 'no'),
(68, 'ET', 'Ethiopia', 'ETH', '231', '251', 'no'),
(69, 'FK', 'Falkland Islands (Malvinas)', 'FLK', '238', '500', 'no'),
(70, 'FO', 'Faroe Islands', 'FRO', '234', '298', 'no'),
(71, 'FJ', 'Fiji', 'FJI', '242', '679', 'no'),
(72, 'FI', 'Finland', 'FIN', '246', '358', 'no'),
(73, 'FR', 'France', 'FRA', '250', '33', 'no'),
(74, 'GF', 'French Guiana', 'GUF', '254', '594', 'no'),
(75, 'PF', 'French Polynesia', 'PYF', '258', '689', 'no'),
(76, 'TF', 'French Southern Territories', NULL, NULL, '0', 'no'),
(77, 'GA', 'Gabon', 'GAB', '266', '241', 'no'),
(78, 'GM', 'Gambia', 'GMB', '270', '220', 'no'),
(79, 'GE', 'Georgia', 'GEO', '268', '995', 'no'),
(80, 'DE', 'Germany', 'DEU', '276', '49', 'no'),
(81, 'GH', 'Ghana', 'GHA', '288', '233', 'no'),
(82, 'GI', 'Gibraltar', 'GIB', '292', '350', 'no'),
(83, 'GR', 'Greece', 'GRC', '300', '30', 'no'),
(84, 'GL', 'Greenland', 'GRL', '304', '299', 'no'),
(85, 'GD', 'Grenada', 'GRD', '308', '1473', 'no'),
(86, 'GP', 'Guadeloupe', 'GLP', '312', '590', 'no'),
(87, 'GU', 'Guam', 'GUM', '316', '1671', 'no'),
(88, 'GT', 'Guatemala', 'GTM', '320', '502', 'no'),
(89, 'GN', 'Guinea', 'GIN', '324', '224', 'no'),
(90, 'GW', 'Guinea-Bissau', 'GNB', '624', '245', 'no'),
(91, 'GY', 'Guyana', 'GUY', '328', '592', 'no'),
(92, 'HT', 'Haiti', 'HTI', '332', '509', 'no'),
(93, 'HM', 'Heard Island and Mcdonald Islands', NULL, NULL, '0', 'no'),
(94, 'VA', 'Holy See (Vatican City State)', 'VAT', '336', '39', 'no'),
(95, 'HN', 'Honduras', 'HND', '340', '504', 'no'),
(96, 'HK', 'Hong Kong', 'HKG', '344', '852', 'no'),
(97, 'HU', 'Hungary', 'HUN', '348', '36', 'no'),
(98, 'IS', 'Iceland', 'ISL', '352', '354', 'no'),
(99, 'IN', 'India', 'IND', '356', '91', 'no'),
(100, 'ID', 'Indonesia', 'IDN', '360', '62', 'no'),
(101, 'IR', 'Iran, Islamic Republic of', 'IRN', '364', '98', 'no'),
(102, 'IQ', 'Iraq', 'IRQ', '368', '964', 'no'),
(103, 'IE', 'Ireland', 'IRL', '372', '353', 'no'),
(104, 'IL', 'Israel', 'ISR', '376', '972', 'no'),
(105, 'IT', 'Italy', 'ITA', '380', '39', 'no'),
(106, 'JM', 'Jamaica', 'JAM', '388', '1876', 'no'),
(107, 'JP', 'Japan', 'JPN', '392', '81', 'no'),
(108, 'JO', 'Jordan', 'JOR', '400', '962', 'no'),
(109, 'KZ', 'Kazakhstan', 'KAZ', '398', '7', 'no'),
(110, 'KE', 'Kenya', 'KEN', '404', '254', 'no'),
(111, 'KI', 'Kiribati', 'KIR', '296', '686', 'no'),
(112, 'KP', 'Korea, Democratic People\'s Republic of', 'PRK', '408', '850', 'no'),
(113, 'KR', 'Korea, Republic of', 'KOR', '410', '82', 'no'),
(114, 'KW', 'Kuwait', 'KWT', '414', '965', 'no'),
(115, 'KG', 'Kyrgyzstan', 'KGZ', '417', '996', 'no'),
(116, 'LA', 'Lao People\'s Democratic Republic', 'LAO', '418', '856', 'no'),
(117, 'LV', 'Latvia', 'LVA', '428', '371', 'no'),
(118, 'LB', 'Lebanon', 'LBN', '422', '961', 'no'),
(119, 'LS', 'Lesotho', 'LSO', '426', '266', 'no'),
(120, 'LR', 'Liberia', 'LBR', '430', '231', 'no'),
(121, 'LY', 'Libyan Arab Jamahiriya', 'LBY', '434', '218', 'no'),
(122, 'LI', 'Liechtenstein', 'LIE', '438', '423', 'no'),
(123, 'LT', 'Lithuania', 'LTU', '440', '370', 'no'),
(124, 'LU', 'Luxembourg', 'LUX', '442', '352', 'no'),
(125, 'MO', 'Macao', 'MAC', '446', '853', 'no'),
(126, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '807', '389', 'no'),
(127, 'MG', 'Madagascar', 'MDG', '450', '261', 'no'),
(128, 'MW', 'Malawi', 'MWI', '454', '265', 'no'),
(129, 'MY', 'Malaysia', 'MYS', '458', '60', 'no'),
(130, 'MV', 'Maldives', 'MDV', '462', '960', 'no'),
(131, 'ML', 'Mali', 'MLI', '466', '223', 'no'),
(132, 'MT', 'Malta', 'MLT', '470', '356', 'no'),
(133, 'MH', 'Marshall Islands', 'MHL', '584', '692', 'no'),
(134, 'MQ', 'Martinique', 'MTQ', '474', '596', 'no'),
(135, 'MR', 'Mauritania', 'MRT', '478', '222', 'no'),
(136, 'MU', 'Mauritius', 'MUS', '480', '230', 'no'),
(137, 'YT', 'Mayotte', NULL, NULL, '269', 'no'),
(138, 'MX', 'Mexico', 'MEX', '484', '52', 'no'),
(139, 'FM', 'Micronesia, Federated States of', 'FSM', '583', '691', 'no'),
(140, 'MD', 'Moldova, Republic of', 'MDA', '498', '373', 'no'),
(141, 'MC', 'Monaco', 'MCO', '492', '377', 'no'),
(142, 'MN', 'Mongolia', 'MNG', '496', '976', 'no'),
(143, 'MS', 'Montserrat', 'MSR', '500', '1664', 'no'),
(144, 'MA', 'Morocco', 'MAR', '504', '212', 'no'),
(145, 'MZ', 'Mozambique', 'MOZ', '508', '258', 'no'),
(146, 'MM', 'Myanmar', 'MMR', '104', '95', 'no'),
(147, 'NA', 'Namibia', 'NAM', '516', '264', 'no'),
(148, 'NR', 'Nauru', 'NRU', '520', '674', 'no'),
(149, 'NP', 'Nepal', 'NPL', '524', '977', 'no'),
(150, 'NL', 'Netherlands', 'NLD', '528', '31', 'no'),
(151, 'AN', 'Netherlands Antilles', 'ANT', '530', '599', 'no'),
(152, 'NC', 'New Caledonia', 'NCL', '540', '687', 'no'),
(153, 'NZ', 'New Zealand', 'NZL', '554', '64', 'no'),
(154, 'NI', 'Nicaragua', 'NIC', '558', '505', 'no'),
(155, 'NE', 'Niger', 'NER', '562', '227', 'no'),
(156, 'NG', 'Nigeria', 'NGA', '566', '234', 'no'),
(157, 'NU', 'Niue', 'NIU', '570', '683', 'no'),
(158, 'NF', 'Norfolk Island', 'NFK', '574', '672', 'no'),
(159, 'MP', 'Northern Mariana Islands', 'MNP', '580', '1670', 'no'),
(160, 'NO', 'Norway', 'NOR', '578', '47', 'no'),
(161, 'OM', 'Oman', 'OMN', '512', '968', 'no'),
(162, 'PK', 'Pakistan', 'PAK', '586', '92', 'no'),
(163, 'PW', 'Palau', 'PLW', '585', '680', 'no'),
(164, 'PS', 'Palestinian Territory, Occupied', NULL, NULL, '970', 'no'),
(165, 'PA', 'Panama', 'PAN', '591', '507', 'no'),
(166, 'PG', 'Papua New Guinea', 'PNG', '598', '675', 'no'),
(167, 'PY', 'Paraguay', 'PRY', '600', '595', 'no'),
(168, 'PE', 'Peru', 'PER', '604', '51', 'no'),
(169, 'PH', 'Philippines', 'PHL', '608', '63', 'no'),
(170, 'PN', 'Pitcairn', 'PCN', '612', '0', 'no'),
(171, 'PL', 'Poland', 'POL', '616', '48', 'no'),
(172, 'PT', 'Portugal', 'PRT', '620', '351', 'no'),
(173, 'PR', 'Puerto Rico', 'PRI', '630', '1787', 'no'),
(174, 'QA', 'Qatar', 'QAT', '634', '974', 'no'),
(175, 'RE', 'Reunion', 'REU', '638', '262', 'no'),
(176, 'RO', 'Romania', 'ROM', '642', '40', 'no'),
(177, 'RU', 'Russian Federation', 'RUS', '643', '70', 'no'),
(178, 'RW', 'Rwanda', 'RWA', '646', '250', 'no'),
(179, 'SH', 'Saint Helena', 'SHN', '654', '290', 'no'),
(180, 'KN', 'Saint Kitts and Nevis', 'KNA', '659', '1869', 'no'),
(181, 'LC', 'Saint Lucia', 'LCA', '662', '1758', 'no'),
(182, 'PM', 'Saint Pierre and Miquelon', 'SPM', '666', '508', 'no'),
(183, 'VC', 'Saint Vincent and the Grenadines', 'VCT', '670', '1784', 'no'),
(184, 'WS', 'Samoa', 'WSM', '882', '684', 'no'),
(185, 'SM', 'San Marino', 'SMR', '674', '378', 'no'),
(186, 'ST', 'Sao Tome and Principe', 'STP', '678', '239', 'no'),
(187, 'SA', 'Saudi Arabia', 'SAU', '682', '966', 'no'),
(188, 'SN', 'Senegal', 'SEN', '686', '221', 'no'),
(189, 'CS', 'Serbia and Montenegro', NULL, NULL, '381', 'no'),
(190, 'SC', 'Seychelles', 'SYC', '690', '248', 'no'),
(191, 'SL', 'Sierra Leone', 'SLE', '694', '232', 'no'),
(192, 'SG', 'Singapore', 'SGP', '702', '65', 'no'),
(193, 'SK', 'Slovakia', 'SVK', '703', '421', 'no'),
(194, 'SI', 'Slovenia', 'SVN', '705', '386', 'no'),
(195, 'SB', 'Solomon Islands', 'SLB', '90', '677', 'no'),
(196, 'SO', 'Somalia', 'SOM', '706', '252', 'no'),
(197, 'ZA', 'South Africa', 'ZAF', '710', '27', 'no'),
(198, 'GS', 'South Georgia and the South Sandwich Islands', NULL, NULL, '0', 'no'),
(199, 'ES', 'Spain', 'ESP', '724', '34', 'no'),
(200, 'LK', 'Sri Lanka', 'LKA', '144', '94', 'no'),
(201, 'SD', 'Sudan', 'SDN', '736', '249', 'no'),
(202, 'SR', 'Suriname', 'SUR', '740', '597', 'no'),
(203, 'SJ', 'Svalbard and Jan Mayen', 'SJM', '744', '47', 'no'),
(204, 'SZ', 'Swaziland', 'SWZ', '748', '268', 'no'),
(205, 'SE', 'Sweden', 'SWE', '752', '46', 'no'),
(206, 'CH', 'Switzerland', 'CHE', '756', '41', 'no'),
(207, 'SY', 'Syrian Arab Republic', 'SYR', '760', '963', 'no'),
(208, 'TW', 'Taiwan, Province of China', 'TWN', '158', '886', 'no'),
(209, 'TJ', 'Tajikistan', 'TJK', '762', '992', 'no'),
(210, 'TZ', 'Tanzania, United Republic of', 'TZA', '834', '255', 'no'),
(211, 'TH', 'Thailand', 'THA', '764', '66', 'no'),
(212, 'TL', 'Timor-Leste', NULL, NULL, '670', 'no'),
(213, 'TG', 'Togo', 'TGO', '768', '228', 'no'),
(214, 'TK', 'Tokelau', 'TKL', '772', '690', 'no'),
(215, 'TO', 'Tonga', 'TON', '776', '676', 'no'),
(216, 'TT', 'Trinidad and Tobago', 'TTO', '780', '1868', 'no'),
(217, 'TN', 'Tunisia', 'TUN', '788', '216', 'no'),
(218, 'TR', 'Turkey', 'TUR', '792', '90', 'no'),
(219, 'TM', 'Turkmenistan', 'TKM', '795', '7370', 'no'),
(220, 'TC', 'Turks and Caicos Islands', 'TCA', '796', '1649', 'no'),
(221, 'TV', 'Tuvalu', 'TUV', '798', '688', 'no'),
(222, 'UG', 'Uganda', 'UGA', '800', '256', 'no'),
(223, 'UA', 'Ukraine', 'UKR', '804', '380', 'no'),
(224, 'AE', 'United Arab Emirates', 'ARE', '784', '971', 'no'),
(225, 'GB', 'United Kingdom', 'GBR', '826', '44', 'no'),
(226, 'US', 'United States', 'USA', '840', '1', 'yes'),
(227, 'UM', 'United States Minor Outlying Islands', NULL, NULL, '1', 'no'),
(228, 'UY', 'Uruguay', 'URY', '858', '598', 'no'),
(229, 'UZ', 'Uzbekistan', 'UZB', '860', '998', 'no'),
(230, 'VU', 'Vanuatu', 'VUT', '548', '678', 'no'),
(231, 'VE', 'Venezuela', 'VEN', '862', '58', 'no'),
(232, 'VN', 'Viet Nam', 'VNM', '704', '84', 'no'),
(233, 'VG', 'Virgin Islands, British', 'VGB', '92', '1284', 'no'),
(234, 'VI', 'Virgin Islands, U.s.', 'VIR', '850', '1340', 'no'),
(235, 'WF', 'Wallis and Futuna', 'WLF', '876', '681', 'no'),
(236, 'EH', 'Western Sahara', 'ESH', '732', '212', 'no'),
(237, 'YE', 'Yemen', 'YEM', '887', '967', 'no'),
(238, 'ZM', 'Zambia', 'ZMB', '894', '260', 'no'),
(239, 'ZW', 'Zimbabwe', 'ZWE', '716', '263', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_asset_api_logs`
--

DROP TABLE IF EXISTS `crypto_asset_api_logs`;
CREATE TABLE IF NOT EXISTS `crypto_asset_api_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_method_id` int UNSIGNED NOT NULL,
  `object_id` int NOT NULL COMMENT 'wallet_id or cryto_sent_id or crypto_received_id',
  `object_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `network` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Networks/Cryto Curencies - BTC,LTC,DOGE',
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Crypto Api''s Payloads (e.g - get_new_address(), get_balance(), withdraw(),etc.',
  `confirmations` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crypto_asset_api_logs_payment_method_id_index` (`payment_method_id`),
  KEY `crypto_asset_api_logs_object_id_idx` (`object_id`),
  KEY `crypto_asset_api_logs_object_type_idx` (`object_type`),
  KEY `crypto_asset_api_logs_network_idx` (`network`),
  KEY `crypto_asset_api_logs_confirmations_idx` (`confirmations`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_asset_settings`
--

DROP TABLE IF EXISTS `crypto_asset_settings`;
CREATE TABLE IF NOT EXISTS `crypto_asset_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency_id` int UNSIGNED NOT NULL,
  `crypto_provider_id` int UNSIGNED NOT NULL,
  `payment_method_id` int UNSIGNED NOT NULL,
  `network` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Networks/Cryto Curencies - BTC,LTC,DT etc.',
  `network_credentials` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `crypto_asset_settings_currency_id_unique` (`currency_id`),
  UNIQUE KEY `crypto_asset_settings_network_unique` (`network`),
  KEY `crypto_asset_settings_crypto_provider_id_idx` (`crypto_provider_id`),
  KEY `crypto_asset_settings_payment_method_id_idx` (`payment_method_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_providers`
--

DROP TABLE IF EXISTS `crypto_providers`;
CREATE TABLE IF NOT EXISTS `crypto_providers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(91) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `crypto_providers_alias_unique` (`alias`),
  KEY `crypto_providers_name_idx` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crypto_providers`
--

INSERT INTO `crypto_providers` (`id`, `name`, `alias`, `description`, `logo`, `subscription_details`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TatumIo', 'tatumio', 'Tatum offers a flexible framework to build, run, and scale blockchain apps fast.', NULL, '', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crypto_tokens`
--

DROP TABLE IF EXISTS `crypto_tokens`;
CREATE TABLE IF NOT EXISTS `crypto_tokens` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `txid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `network` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimals` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crypto_tokens_currency_id_index` (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fiat' COMMENT 'fiat or crypto',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(21) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `exchange_from` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `allowed_wallet_creation` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `type`, `name`, `symbol`, `code`, `rate`, `logo`, `default`, `exchange_from`, `allowed_wallet_creation`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'fiat', 'US Dollar', '$', 'USD', '1.00000000', 'icons8-us-dollar-64.png', '1', 'local', 'No', NULL, 'Active', NULL, NULL),
(2, 'fiat', 'Pound Sterling', '?', 'GBP', '0.75000000', 'icons8-british-pound-64.png', '0', 'local', 'No', NULL, 'Active', NULL, NULL),
(3, 'fiat', 'Euro', '?', 'EUR', '0.85000000', 'icons8-euro-64.png', '0', 'local', 'No', NULL, 'Active', NULL, NULL),
(4, 'crypto', 'Bitcoin', '?', 'BTC', '0.00000000', 'bitcoin_crypto.png', '0', 'local', 'No', NULL, 'Inactive', NULL, NULL),
(5, 'crypto', 'Litecoin', '?', 'LTC', '0.00000000', '1660982923.png', '0', 'local', 'No', NULL, 'Inactive', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currency_exchanges`
--

DROP TABLE IF EXISTS `currency_exchanges`;
CREATE TABLE IF NOT EXISTS `currency_exchanges` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `from_wallet` int UNSIGNED DEFAULT NULL,
  `to_wallet` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID (For Each Exchange)',
  `exchange_rate` decimal(20,8) DEFAULT '0.00000000',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `fee` decimal(20,8) DEFAULT '0.00000000',
  `type` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'In, Out',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_exchanges_user_id_index` (`user_id`),
  KEY `currency_exchanges_from_wallet_index` (`from_wallet`),
  KEY `currency_exchanges_to_wallet_index` (`to_wallet`),
  KEY `currency_exchanges_currency_id_index` (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency_payment_methods`
--

DROP TABLE IF EXISTS `currency_payment_methods`;
CREATE TABLE IF NOT EXISTS `currency_payment_methods` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency_id` int UNSIGNED NOT NULL,
  `method_id` int UNSIGNED NOT NULL,
  `activated_for` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'transaction types like deposit, withdrawal, investment etc.',
  `method_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'input field''s title and value like client_id, client_secret etc',
  `processing_time` tinyint NOT NULL DEFAULT '0' COMMENT 'time in days',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_payment_methods_currency_id_index` (`currency_id`),
  KEY `currency_payment_methods_method_id_index` (`method_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
CREATE TABLE IF NOT EXISTS `deposits` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `bank_id` int UNSIGNED DEFAULT NULL,
  `file_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID (For Each Deposit)',
  `charge_percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_fixed` decimal(20,8) DEFAULT '0.00000000',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deposits_user_id_index` (`user_id`),
  KEY `deposits_currency_id_index` (`currency_id`),
  KEY `deposits_payment_method_id_index` (`payment_method_id`),
  KEY `deposits_bank_id_index` (`bank_id`),
  KEY `deposits_file_id_index` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_logs`
--

DROP TABLE IF EXISTS `device_logs`;
CREATE TABLE IF NOT EXISTS `device_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `browser_fingerprint` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser_agent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `device_logs_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

DROP TABLE IF EXISTS `disputes`;
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `claimant_id` int UNSIGNED DEFAULT NULL,
  `defendant_id` int UNSIGNED DEFAULT NULL,
  `transaction_id` int UNSIGNED DEFAULT NULL,
  `reason_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open' COMMENT 'Open, Closed, Solved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disputes_claimant_id_index` (`claimant_id`),
  KEY `disputes_defendant_id_index` (`defendant_id`),
  KEY `disputes_transaction_id_index` (`transaction_id`),
  KEY `disputes_reason_id_index` (`reason_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispute_discussions`
--

DROP TABLE IF EXISTS `dispute_discussions`;
CREATE TABLE IF NOT EXISTS `dispute_discussions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `dispute_id` int UNSIGNED DEFAULT NULL,
  `user_id` int NOT NULL,
  `type` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Admin, User',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dispute_discussions_dispute_id_index` (`dispute_id`),
  KEY `dispute_discussions_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_verifications`
--

DROP TABLE IF EXISTS `document_verifications`;
CREATE TABLE IF NOT EXISTS `document_verifications` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `file_id` int UNSIGNED DEFAULT NULL,
  `verification_type` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'address, identity',
  `identity_type` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'driving_license, passport, national_id',
  `identity_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pan, aadhaar_front, aadhaar_back, photo, business_proof, gst_certificate, partnership_deed, etc.',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, approved, rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_verifications_user_id_index` (`user_id`),
  KEY `document_verifications_file_id_index` (`file_id`),
  KEY `document_verifications_provider_id_foreign` (`provider_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_configs`
--

DROP TABLE IF EXISTS `email_configs`;
CREATE TABLE IF NOT EXISTS `email_configs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_protocol` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_encryption` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_host` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_port` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_configs`
--

INSERT INTO `email_configs` (`id`, `email_protocol`, `email_encryption`, `smtp_host`, `smtp_port`, `smtp_email`, `smtp_username`, `smtp_password`, `from_address`, `from_name`, `status`) VALUES
(1, 'sendmail', 'tls', '', '587', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `language_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lang` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'email or sms',
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `group` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email_templates_language_id_idx` (`language_id`),
  KEY `email_templates_name_idx` (`name`),
  KEY `email_templates_alias_idx` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `language_id`, `name`, `alias`, `subject`, `body`, `lang`, `type`, `status`, `group`, `created_at`, `updated_at`) VALUES
(1, 1, 'Notify Admin on Deposit', 'notify-admin-on-deposit', 'Money Deposit Notification', 'Hi <b>{admin}</b>,\r\n<br><br>Amount <b>{amount}</b> has been deposited by <b>{user}</br>\r\n<br><br><b><u><i>Here?s a brief overview of the Deposit:</i></u></b>\r\n<br><br><b><u>Deposited at:</u></b> {created_at}\r\n<br><br><b><u>Deposited via:</u></b> {payment_method}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee:</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(2, 2, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'ar', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(3, 3, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'fr', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(4, 4, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'pt', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(5, 5, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'ru', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(6, 6, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'es', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(7, 7, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'tr', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(8, 8, 'Notify Admin on Deposit', 'notify-admin-on-deposit', '', '', 'ch', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(9, 1, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', 'Deposit via System Administrator', 'Hi <b>{user}</b>,\r\n<br><br>Amount <b>{amount}</b> has been deposited to your account by System Administrator.\r\n<br><br><b><u><i>Here?s a brief overview of the Deposit:</i></u></b>\r\n<br><br><b><u>Deposited at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee:</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(10, 2, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'ar', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(11, 3, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'fr', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(12, 4, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'pt', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(13, 5, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'ru', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(14, 6, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'es', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(15, 7, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'tr', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(16, 8, 'Notify User on Deposit via Admin', 'notify-user-on-deposit-via-admin', '', '', 'ch', 'email', 'Active', 'Deposit', '2026-04-01 02:28:28', NULL),
(17, 1, 'Notify Money Receiver', 'notify-money-receiver', 'Money Received Notification', 'Hi <b>{receiver_id}</b>,\r\n<br><br>You have received {amount} on your account.\r\n<br><br>\r\n<b><u><i>Here?s a brief overview of your Received:</i></u></b>\r\n<br><br><b><u>Transferred at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Sent By:</u></b> {sender_id}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Note:</u></b> {note}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(18, 2, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ar', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(19, 3, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'fr', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(20, 4, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'pt', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(21, 5, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ru', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(22, 6, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'es', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(23, 7, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'tr', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(24, 8, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ch', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(25, 1, 'Notify Admin on Transfer', 'notify-admin-on-transfer', 'Money Transfer Notification', 'Hi <b>{admin}</b>,\r\n<br><br><b>{sender}</b> has been transferred <b>{amount}</b> to <b>{receiver}</b>.\r\n<br><br><b><u><i>Here?s a brief overview of the Transfer:</i></u></b>\r\n<br><br><b><u>Transferred at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Sent By:</u></b> {sender}\r\n<br><br><b><u>Received By:</u></b> {receiver}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee (deducted from {sender}):</u></b> {fee}\r\n<br><br><b><u>Note:</u></b> {note}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(26, 2, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'ar', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(27, 3, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'fr', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(28, 4, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'pt', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(29, 5, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'ru', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(30, 6, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'es', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(31, 7, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'tr', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(32, 8, 'Notify Admin on Transfer', 'notify-admin-on-transfer', '', '', 'ch', 'email', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(33, 1, 'Notify Request Receiver', 'notify-request-receiver', 'Request Money Notification', 'Hi {request_receiver},\r\n<br><br>{request_sender} has been requested {amount} from you.\r\n<br><br><b><u><i>Here?s a brief overview of the Request:</i></u></b>\r\n<br><br>\r\n<b><u>Request:</u></b> #{uuid}\r\n<br><br>\r\n<b><u>Requested At:</u></b> {created_at}\r\n<br><br>\r\n<b><u>Requested Amount:</u></b> {amount}\r\n<br><br>\r\n<b><u>Note: </u></b> {note}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(34, 2, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ar', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(35, 3, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'fr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(36, 4, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'pt', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(37, 5, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ru', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(38, 6, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'es', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(39, 7, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'tr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(40, 8, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ch', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(41, 1, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', 'Requested Money Received Notification', 'Hi {request_sender},\r\n<br><br>Your request of #{uuid} has been received by {request_receiver}.\r\n<br><br><b><u><i>Here?s a brief overview of the Request:</i></u></b>\r\n<br><br>\r\n<b><u>Received Date:</u></b> {created_at}.\r\n<br><br>\r\n<b><u>Requested Amount:</u></b> {amount}\r\n<br><br>\r\n<b><u>Received Amount:</u></b> {accept_amount}\r\n<br><br>\r\n<b><u>Currency:</u></b> {currency}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(42, 2, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ar', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(43, 3, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'fr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(44, 4, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'pt', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(45, 5, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ru', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(46, 6, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'es', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(47, 7, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'tr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(48, 8, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ch', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(49, 1, 'Notify Admin on Money Received', 'notify-admin-on-money-received', 'Request Money Received Notification', 'Hi {admin},\r\n<br><br>Money request of #{uuid} from {request_sender} has been received by {request_receiver}.\r\n<br><br><b><u><i>Here?s a brief overview of the Request Acceptance:</i></u></b>\r\n<br><br><b><u>Received at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Requested By:</u></b> {request_sender}\r\n<br><br><b><u>Received By:</u></b> {request_receiver}\r\n<br><br><b><u>Requested Amount:</u></b> {request_amount}\r\n<br><br><b><u>Given Amount:</u></b> {given_amount}\r\n<br><br><b><u>Fee (deducted from {request_receiver}):</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(50, 2, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'ar', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(51, 3, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'fr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(52, 4, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'pt', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(53, 5, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'ru', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(54, 6, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'es', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(55, 7, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'tr', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(56, 8, 'Notify Admin on Money Received', 'notify-admin-on-money-received', '', '', 'ch', 'email', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(57, 1, 'Notify Admin on Exchange', 'notify-admin-on-exchange', 'Money Exchange Notification', 'Hi <b>{admin}</b>,\r\n<br><br>Amount <b>{amount}</b> has been exchanged by <b>{user}</b>\r\n<br><br><b><u><i>Here?s a brief overview of the Exchange:</i></u></b>\r\n<br><br><b><u>Exchanged at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>From wallet:</u></b> {from_wallet}\r\n<br><br><b><u>To wallet:</u></b> {to_wallet}\r\n<br><br><b><u>Exchanged Amount:</u></b> {exchanged_amount}\r\n<br><br><b><u>Exchange Rate:</u></b> 1 {from_wallet} = {exchange_rate} {to_wallet}\r\n<br><br><b><u>Fee (deducted from {from_wallet}):</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(58, 2, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'ar', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(59, 3, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'fr', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(60, 4, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'pt', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(61, 5, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'ru', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(62, 6, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'es', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(63, 7, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'tr', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(64, 8, 'Notify Admin on Exchange', 'notify-admin-on-exchange', '', '', 'ch', 'email', 'Active', 'Exchange', '2026-04-01 02:28:28', NULL),
(65, 1, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', 'Money Withdrawal Notification', 'Hi <b>{admin}</b>,\r\n<br><br><b>{amount}</b> has been withdrawn by <b>{user}</b>.\r\n<br><br><b><u><i>Here?s a brief overview of the Withdrawn:</i></u></b>\r\n<br><br><b><u>Withdrawn at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Withdraw via:</u></b> {payment_method}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee:</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(66, 2, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'ar', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(67, 3, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'fr', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(68, 4, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'pt', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(69, 5, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'ru', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(70, 6, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'es', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(71, 7, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'tr', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(72, 8, 'Notify Admin on Withdrawal', 'notify-admin-on-withdrawal', '', '', 'ch', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(73, 1, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', 'Money Withdrawal Notification', 'Hi <b>{user}</b>,\r\n<br><br><b>{amount}</b> has been withdrawn from your account by System Administrator.\r\n<br><br><b><u><i>Here?s a brief overview of the withdrawn:</i></u></b>\r\n<br><br><b><u>Withdrawn at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee:</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(74, 2, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'ar', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(75, 3, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'fr', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(76, 4, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'pt', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(77, 5, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'ru', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(78, 6, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'es', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(79, 7, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'tr', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(80, 8, 'Notify User on Withdrawal via Admin', 'notify-user-on-withdrawal-via-admin', '', '', 'ch', 'email', 'Active', 'Withdraw', '2026-04-01 02:28:28', NULL),
(81, 1, 'Notify Merchant', 'notify-merchant', 'Merchant Payment Notification', 'Hi {merchant},\r\n<br><br>Payment has been completed. Amount {amount} has been paid to {merchant}.\r\n<br><br><b><u><i>Here?s a brief overview of the Payment:</i></u></b>\r\n<br><br><b><u>Paid at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Paid By:</u></b> {user}\r\n<br><br><b><u>Paid To:</u></b> {merchant}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee (deducted from {fee_bearer}):</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(82, 2, 'Notify Merchant', 'notify-merchant', '', '', 'ar', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(83, 3, 'Notify Merchant', 'notify-merchant', '', '', 'fr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(84, 4, 'Notify Merchant', 'notify-merchant', '', '', 'pt', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(85, 5, 'Notify Merchant', 'notify-merchant', '', '', 'ru', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(86, 6, 'Notify Merchant', 'notify-merchant', '', '', 'es', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(87, 7, 'Notify Merchant', 'notify-merchant', '', '', 'tr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(88, 8, 'Notify Merchant', 'notify-merchant', '', '', 'ch', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(89, 1, 'Notify Admin on Payment', 'notify-admin-on-payment', 'Merchant Payment Notification', 'Hi <b>{admin}</b>,\r\n<br><br>Merchant payment completed. Amount <b>{amount}</b> has been paid by <b>{user}</b> to <b>{merchant}</b>.\r\n<br><br><b><u><i>Here?s a brief overview of the Payment:</i></u></b>\r\n<br><br><b><u>Paid at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Paid By:</u></b> {user}\r\n<br><br><b><u>Paid To:</u></b> {merchant}\r\n<br><br><b><u>Amount:</u></b> {amount}\r\n<br><br><b><u>Fee (deducted from {fee_bearer}):</u></b> {fee}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(90, 2, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'ar', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(91, 3, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'fr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(92, 4, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'pt', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(93, 5, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'ru', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(94, 6, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'es', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(95, 7, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'tr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(96, 8, 'Notify Admin on Payment', 'notify-admin-on-payment', '', '', 'ch', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(97, 1, 'New Ticket', 'new-ticket', 'New Ticket has been {assigned/created}', 'Hi {admin/assignee/user},\r\n<br><br>Ticket #{ticket_code} was {assigned/created} {to/for} you.\r\n<br><br><b><u><i>Here?s a brief overview of the ticket:</i></u></b>\r\n<br><br>Ticket #{ticket_code} was created at {created_at}.\r\n<br><br><b><u>Assignee:</u></b> {assignee}\r\n<br><br><b><u>User:</u></b> {user}\r\n<br><br><b><u>Ticket Subject:</u></b> {subject}\r\n<br><br><b><u>Ticket Message:</u></b> {message}\r\n<br><br><b><u>Ticket Status:</u></b> {status}\r\n<br><br><b><u>Ticket Priority Level:</u></b> {priority}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(98, 2, 'New Ticket', 'new-ticket', '', '', 'ar', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(99, 3, 'New Ticket', 'new-ticket', '', '', 'fr', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(100, 4, 'New Ticket', 'new-ticket', '', '', 'pt', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(101, 5, 'New Ticket', 'new-ticket', '', '', 'ru', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(102, 6, 'New Ticket', 'new-ticket', '', '', 'es', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(103, 7, 'New Ticket', 'new-ticket', '', '', 'tr', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(104, 8, 'New Ticket', 'new-ticket', '', '', 'ch', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(105, 1, 'Ticket Reply', 'ticket-reply', 'Ticket Reply Notification', 'Hi {assignee/user},\r\n<br><br>You have received a ticket reply.\r\n<br><br><b><u><i>Here?s a brief overview of the reply:</i></u></b>\r\n<br><br>This reply was initiated against ticket code #{ticket_code}.\r\n<br><br><b><u>Assignee:</u></b> {assignee}\r\n<br><br><b><u>Reply Message:</u></b> {message}\r\n<br><br><b><u>Reply Status:</u></b> {status}\r\n<br><br><b><u>Reply Priority Level:</u></b> {priority}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(106, 2, 'Ticket Reply', 'ticket-reply', '', '', 'ar', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(107, 3, 'Ticket Reply', 'ticket-reply', '', '', 'fr', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(108, 4, 'Ticket Reply', 'ticket-reply', '', '', 'pt', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(109, 5, 'Ticket Reply', 'ticket-reply', '', '', 'ru', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(110, 6, 'Ticket Reply', 'ticket-reply', '', '', 'es', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(111, 7, 'Ticket Reply', 'ticket-reply', '', '', 'tr', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(112, 8, 'Ticket Reply', 'ticket-reply', '', '', 'ch', 'email', 'Active', 'Ticket', '2026-04-01 02:28:28', NULL),
(113, 1, 'Open Dispute', 'open-dispute', 'Dispute Open Notification', 'Hi <b>{admin/merchant}</b>,\r\n<br><br>Dispute ID <b>#{dispute_id}</b> has been opened by <b>{claimant}</b>.\r\n<br><br><b><u><i>Here?s a brief overview of the dispute:</i></u></b>\r\n<br><br><b><u>Created at:</u></b> {created_at}\r\n<br><br><b><u>Transaction ID:</u></b> {uuid}\r\n<br><br><b><u>Claimant:</u></b> {claimant}\r\n<br><br><b><u>Defendant:</u></b> {defendant}\r\n<br><br><b><u>Dispute Subject:</u></b> {subject}\r\n<br><br><b><u>Dispute description:</u></b> {description}\r\n<br><br><b><u>Dispute Status:</u></b> {status}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(114, 2, 'Open Dispute', 'open-dispute', '', '', 'ar', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(115, 3, 'Open Dispute', 'open-dispute', '', '', 'fr', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(116, 4, 'Open Dispute', 'open-dispute', '', '', 'pt', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(117, 5, 'Open Dispute', 'open-dispute', '', '', 'ru', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(118, 6, 'Open Dispute', 'open-dispute', '', '', 'es', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(119, 7, 'Open Dispute', 'open-dispute', '', '', 'tr', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(120, 8, 'Open Dispute', 'open-dispute', '', '', 'ch', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(121, 1, 'Dispute Reply', 'dispute-reply', 'New Dispute Reply', 'Hi <b>{admin/merchant/user}</b>,\r\n<br><br>You have received a new dispute reply from <b>{user}</b>.\r\n<br><br><b><u><i>Here?s a brief overview of the reply:</i></u></b>\r\n<br><br><b><u>Replied at</u></b> {created_at}\r\n<br><br><b><u>Dispute ID:</u></b> {dispute_id}\r\n<br><br><b><u>Transaction ID:</u></b> {transaction_id}\r\n<br><br><b><u>Claimant:</u></b> {claimant}\r\n<br><br><b><u>Defendant</u></b> {defendant}\r\n<br><br><b><u>Subject:</u></b> {subject}\r\n<br><br><b><u>Replied Message:</u></b> {message}\r\n<br><br><b><u>Status:</u></b> {status}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(122, 2, 'Dispute Reply', 'dispute-reply', '', '', 'ar', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(123, 3, 'Dispute Reply', 'dispute-reply', '', '', 'fr', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(124, 4, 'Dispute Reply', 'dispute-reply', '', '', 'pt', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(125, 5, 'Dispute Reply', 'dispute-reply', '', '', 'ru', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(126, 6, 'Dispute Reply', 'dispute-reply', '', '', 'es', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(127, 7, 'Dispute Reply', 'dispute-reply', '', '', 'tr', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(128, 8, 'Dispute Reply', 'dispute-reply', '', '', 'ch', 'email', 'Active', 'Dispute', '2026-04-01 02:28:28', NULL),
(129, 1, 'Two-fa Authentication', 'two-fa-authentication', '2fa OTP code', 'Hi {user},\r\n<br><br>\r\nYour 2-Factor Authentication code is: {code}\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(130, 2, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(131, 3, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(132, 4, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(133, 5, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(134, 6, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(135, 7, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(136, 8, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(137, 1, 'Email Verification', 'email-verification', 'Email Verification', 'Hi {user},\r\n<br><br>\r\nYour registered email id: {email}. Please click on the below link to verify your account,<br><br>\r\n{verification_url}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(138, 2, 'Email Verification', 'email-verification', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(139, 3, 'Email Verification', 'email-verification', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(140, 4, 'Email Verification', 'email-verification', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(141, 5, 'Email Verification', 'email-verification', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(142, 6, 'Email Verification', 'email-verification', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(143, 7, 'Email Verification', 'email-verification', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(144, 8, 'Email Verification', 'email-verification', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(145, 1, 'Password Reset', 'password-reset', 'Password Reset Notification', 'Hi {user},\r\n<br><br>\r\nYour registered email id: {email}. Please click on the below link to reset your password,<br><br>\r\n{password_reset_url}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(146, 2, 'Password Reset', 'password-reset', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(147, 3, 'Password Reset', 'password-reset', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(148, 4, 'Password Reset', 'password-reset', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(149, 5, 'Password Reset', 'password-reset', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(150, 6, 'Password Reset', 'password-reset', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(151, 7, 'Password Reset', 'password-reset', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(152, 8, 'Password Reset', 'password-reset', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(153, 1, 'Profile Status Change', 'profile-status-change', 'Profile Status Change', 'Hi {user},\r\n<br><br>Your profile status has been changed to <b>{status}</b> by the System Administrator\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>.', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(154, 2, 'Profile Status Change', 'profile-status-change', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(155, 3, 'Profile Status Change', 'profile-status-change', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(156, 4, 'Profile Status Change', 'profile-status-change', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(157, 5, 'Profile Status Change', 'profile-status-change', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(158, 6, 'Profile Status Change', 'profile-status-change', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(159, 7, 'Profile Status Change', 'profile-status-change', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(160, 8, 'Profile Status Change', 'profile-status-change', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(161, 1, 'Transaction Status Update', 'transaction-status-update', 'Transaction Status Update Notification', 'Hi {user},\r\n<br><br>We would like to inform you that the transaction for <b>{transaction_type}</b> with the ID #<b>{uuid}</b> has been updated to <b>{status}</b> by the system administrator.\r\n<br><br>Amount <b>{amount}</b> has been <b>{added/subtracted}</b> {from/to} your account.\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>.', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(162, 2, 'Transaction Status Update', 'transaction-status-update', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(163, 3, 'Transaction Status Update', 'transaction-status-update', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(164, 4, 'Transaction Status Update', 'transaction-status-update', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(165, 5, 'Transaction Status Update', 'transaction-status-update', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(166, 6, 'Transaction Status Update', 'transaction-status-update', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(167, 7, 'Transaction Status Update', 'transaction-status-update', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(168, 8, 'Transaction Status Update', 'transaction-status-update', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(169, 1, 'Notify Money Receiver', 'notify-money-receiver', 'Money Received Notification', 'Hi {receiver_id}, You have received amount {amount} tnxId #{uuid} at {created_at} on your account. Regards, {soft_name}.', 'en', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(170, 2, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ar', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(171, 3, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'fr', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(172, 4, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'pt', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(173, 5, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ru', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(174, 6, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'es', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(175, 7, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'tr', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(176, 8, 'Notify Money Receiver', 'notify-money-receiver', '', '', 'ch', 'sms', 'Active', 'Send Money', '2026-04-01 02:28:28', NULL),
(177, 1, 'Notify Request Receiver', 'notify-request-receiver', 'Request Money Notification', 'Hi {request_receiver}, {request_sender} has been requested amount {amount} with tnxId: #{uuid} at {created_at} from you. Regards, {soft_name}.', 'en', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(178, 2, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ar', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(179, 3, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'fr', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(180, 4, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'pt', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(181, 5, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ru', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(182, 6, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'es', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(183, 7, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'tr', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(184, 8, 'Notify Request Receiver', 'notify-request-receiver', '', '', 'ch', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(185, 1, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', 'Requested Money Received Notification', 'Dear {request_sender}, You have received amount {amount} tnxId #{uuid} from {request_receiver}. Regards, {soft_name}.', 'en', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(186, 2, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ar', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(187, 3, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'fr', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(188, 4, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'pt', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(189, 5, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ru', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(190, 6, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'es', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(191, 7, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'tr', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(192, 8, 'Notify Request Sender on Money Received', 'notify-request-sender-on-money-received', '', '', 'ch', 'sms', 'Active', 'Request Money', '2026-04-01 02:28:28', NULL),
(193, 1, 'Transaction Status Update', 'transaction-status-update', 'Transaction Status Update Notification', 'Hi {user}, The transaction {transaction_type} with ID #{uuid} has been updated to {status} by the administrator. Amount {amount} has been {added/subtracted} {from/to} your account. Regards, {soft_name}.', 'en', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(194, 2, 'Transaction Status Update', 'transaction-status-update', '', '', 'ar', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(195, 3, 'Transaction Status Update', 'transaction-status-update', '', '', 'fr', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(196, 4, 'Transaction Status Update', 'transaction-status-update', '', '', 'pt', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(197, 5, 'Transaction Status Update', 'transaction-status-update', '', '', 'ru', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(198, 6, 'Transaction Status Update', 'transaction-status-update', '', '', 'es', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(199, 7, 'Transaction Status Update', 'transaction-status-update', '', '', 'tr', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(200, 8, 'Transaction Status Update', 'transaction-status-update', '', '', 'ch', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(201, 1, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', 'New merchant Creation Notification', 'Hi <b>{admin}</b>,\r\n<br><br>A new merchant has been created by <b>{user}</b></br>\r\n<br><br><b><u><i>Here?s a brief overview of the merchant:</i></u></b>\r\n<br><br><b><u>Created at:</u></b> {created_at}\r\n<br><br><b><u>Merchant:</u></b> {business_name}\r\n<br><br><b><u>Site URL:</u></b> {site_url}\r\n<br><br><b><u>Currency:</u></b> {code}\r\n<br><br><b><u>Type:</u></b> {merchant_type}\r\n<br><br><b><u>Message:</u></b> {message}\r\n<br><br>If you have any questions, please feel free to reply to this email.\r\n<br><br>Regards,\r\n<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(202, 2, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'ar', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(203, 3, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'fr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(204, 4, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'pt', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(205, 5, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'ru', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(206, 6, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'es', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(207, 7, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'tr', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(208, 8, 'Notify Admin on Merchant Creation', 'notify-admin-on-merchant-creation', '', '', 'ch', 'email', 'Active', 'Merchant Payment', '2026-04-01 02:28:28', NULL),
(209, 1, 'Notice for Forgot Password', 'forgot-password-notice', 'Notice for Forgot Password', 'Hi {user},<br><br>You recently requested a password reset for your account.<br><br>Please use the following code to reset your password<br><br><b><u>Code:</u></b> {password_reset_code} <br><br>If you did not make this request, please contact our support team immediately.<br><br>Regards,<br><b>{soft_name}</b>', 'en', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(210, 2, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'ar', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(211, 3, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'fr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(212, 4, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'pt', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(213, 5, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'ru', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(214, 6, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'es', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(215, 7, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'tr', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(216, 8, 'Notice for Forgot Password', 'forgot-password-notice', '', '', 'ch', 'email', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(217, 1, 'Two-fa Authentication', 'two-fa-authentication', '2fa OTP code', 'Hi {user},Your 2-Factor Authentication code is: {code} Regards,{soft_name}', 'en', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(218, 2, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ar', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(219, 3, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'fr', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(220, 4, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'pt', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(221, 5, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ru', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(222, 6, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'es', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(223, 7, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'tr', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL),
(224, 8, 'Two-fa Authentication', 'two-fa-authentication', '', '', 'ch', 'sms', 'Active', 'General', '2026-04-01 02:28:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_limits`
--

DROP TABLE IF EXISTS `fees_limits`;
CREATE TABLE IF NOT EXISTS `fees_limits` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `transaction_type_id` int UNSIGNED DEFAULT NULL,
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `charge_percentage` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `charge_fixed` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `min_limit` decimal(20,8) NOT NULL DEFAULT '1.00000000',
  `max_limit` decimal(20,8) DEFAULT NULL,
  `processing_time` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT 'time in days',
  `has_transaction` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yes or No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fees_limits_transaction_type_id_foreign` (`transaction_type_id`),
  KEY `fees_limits_payment_method_id_foreign` (`payment_method_id`),
  KEY `fees_limits_currency_id_index` (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fees_limits`
--

INSERT INTO `fees_limits` (`id`, `currency_id`, `transaction_type_id`, `payment_method_id`, `charge_percentage`, `charge_fixed`, `min_limit`, `max_limit`, `processing_time`, `has_transaction`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(2, 1, 1, 2, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(3, 1, 1, 3, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(4, 1, 1, 4, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(5, 1, 1, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(6, 1, 1, 6, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(7, 1, 1, 7, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(8, 1, 2, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(9, 1, 2, 3, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(10, 1, 2, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(11, 1, 3, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(12, 1, 5, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(13, 1, 8, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(14, 2, 1, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(15, 2, 1, 2, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(16, 2, 1, 3, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(17, 2, 1, 4, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(18, 2, 1, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2019-04-08 04:05:02'),
(19, 2, 1, 6, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(20, 2, 1, 7, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(21, 2, 2, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(22, 2, 2, 3, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(23, 2, 2, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(24, 3, 2, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(25, 3, 2, 3, '1.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(26, 3, 2, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(27, 3, 5, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(28, 2, 5, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:28', '2026-04-01 02:28:28'),
(29, 3, 1, 1, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(30, 3, 1, 2, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(31, 3, 1, 3, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(32, 3, 1, 4, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(33, 3, 1, 5, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(34, 3, 1, 6, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(35, 3, 1, 7, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'No', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(36, 2, 3, NULL, '1.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(37, 3, 3, NULL, '1.00000000', '1.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(38, 3, 8, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(39, 2, 8, NULL, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', '2026-04-01 02:28:29', '2026-04-01 02:28:29'),
(40, 1, 1, 9, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', NULL, NULL),
(41, 1, 1, 10, '0.00000000', '0.00000000', '1.00000000', NULL, '0', 'Yes', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ticket_id` int UNSIGNED DEFAULT NULL,
  `ticket_reply_id` int UNSIGNED DEFAULT NULL,
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `originalname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_admin_id_index` (`admin_id`),
  KEY `files_user_id_index` (`user_id`),
  KEY `files_ticket_id_index` (`ticket_id`),
  KEY `files_ticket_reply_id_index` (`ticket_reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_partners`
--

DROP TABLE IF EXISTS `kyc_partners`;
CREATE TABLE IF NOT EXISTS `kyc_partners` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhaar_number` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar_file_id` int UNSIGNED DEFAULT NULL,
  `pan_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_file_id` int UNSIGNED DEFAULT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kyc_partners_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_providers`
--

DROP TABLE IF EXISTS `kyc_providers`;
CREATE TABLE IF NOT EXISTS `kyc_providers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No' COMMENT 'Yes, No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kyc_providers_name_unique` (`name`),
  UNIQUE KEY `kyc_providers_alias_unique` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 or 0',
  `deletable` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes' COMMENT 'Yes or No',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active or Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `flag`, `default`, `deletable`, `status`) VALUES
(1, 'English', 'en', '1530358989.png', '1', 'No', 'Active'),
(2, '????', 'ar', '1530359409.png', '0', 'No', 'Active'),
(3, 'Fran?ais', 'fr', '1530359431.png', '0', 'No', 'Active'),
(4, 'Portugu?s', 'pt', '1530359450.png', '0', 'No', 'Active'),
(5, '???????', 'ru', '1530359474.png', '0', 'No', 'Active'),
(6, 'Espa?ol', 'es', '1530360151.png', '0', 'No', 'Active'),
(7, 'T?rk?e', 'tr', '1530696845.png', '0', 'No', 'Active'),
(8, '?? (??)', 'ch', '1531227913.png', '0', 'No', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `merchant_group_id` int UNSIGNED DEFAULT NULL,
  `merchant_uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID for each Merchant',
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'standard or express',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` decimal(20,8) DEFAULT '0.00000000',
  `status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Moderation' COMMENT 'Moderation, Disapproved, Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchants_user_id_index` (`user_id`),
  KEY `merchants_currency_id_index` (`currency_id`),
  KEY `merchants_merchant_group_id_index` (`merchant_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_apps`
--

DROP TABLE IF EXISTS `merchant_apps`;
CREATE TABLE IF NOT EXISTS `merchant_apps` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int UNSIGNED NOT NULL,
  `client_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_secret` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_apps_client_id_unique` (`client_id`),
  KEY `merchant_apps_merchant_id_index` (`merchant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_groups`
--

DROP TABLE IF EXISTS `merchant_groups`;
CREATE TABLE IF NOT EXISTS `merchant_groups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` decimal(20,8) DEFAULT '0.00000000',
  `fee_bearer` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Merchant' COMMENT 'Merchant, User',
  `is_default` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No' COMMENT 'No or Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_groups_name_unique` (`name`),
  KEY `fee_bearer_merchant_groups_idx` (`fee_bearer`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchant_groups`
--

INSERT INTO `merchant_groups` (`id`, `name`, `description`, `fee`, `fee_bearer`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Premium', 'This is the premium merchant group', '0.50000000', 'Merchant', 'No', NULL, NULL),
(2, 'Gold', 'This is the gold merchant group', '1.00000000', 'Merchant', 'No', NULL, NULL),
(3, 'Silver', 'This is the silver merchant group', '1.50000000', 'Merchant', 'Yes', NULL, NULL),
(4, 'Bronze', 'This is the bronze merchant group', '2.00000000', 'Merchant', 'No', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_payments`
--

DROP TABLE IF EXISTS `merchant_payments`;
CREATE TABLE IF NOT EXISTS `merchant_payments` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `gateway_reference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_bearer` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Merchant, User',
  `percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_fixed` decimal(20,8) DEFAULT '0.00000000',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `total` decimal(20,8) DEFAULT '0.00000000',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Success' COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_payments_merchant_id_index` (`merchant_id`),
  KEY `merchant_payments_currency_id_index` (`currency_id`),
  KEY `merchant_payments_payment_method_id_index` (`payment_method_id`),
  KEY `merchant_payments_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

DROP TABLE IF EXISTS `metas`;
CREATE TABLE IF NOT EXISTS `metas` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`id`, `url`, `title`, `description`, `keywords`) VALUES
(1, 'help', 'Help', 'Help', NULL),
(2, 'about-us', 'About Us', 'About Us', NULL),
(3, 'contact-us', 'Contact Us', 'Contact Us', NULL),
(4, 'header', 'Header', 'Header', NULL),
(5, 'login', 'Login', 'Login', NULL),
(6, 'register', 'Register', 'Register', NULL),
(7, '/', 'Home', 'Home', NULL),
(8, 'dashboard', 'Dashboard', 'Dashboard', NULL),
(9, 'moneytransfer', 'Money Transfer', 'Money Transfer', NULL),
(10, 'transactions', 'Transactions', 'Transactions', NULL),
(11, 'exchanges', 'Money Exchange', 'Money Exchange', NULL),
(12, 'exchange', 'Money Exchange', 'Money Exchange', NULL),
(13, 'merchants', 'Merchant', 'Merchant', NULL),
(14, 'merchant/add', 'Add Merchant', 'Add Merchant', NULL),
(15, 'request_payments', 'Request Payments', 'Request Payments', NULL),
(16, 'request_payment/add', 'Request Payment', 'Request Payment', NULL),
(17, 'request_payment/edit/{id}', 'Request Payment', 'Request Payment', NULL),
(18, 'request_payment/detail/{id}', 'Request Payment', 'Request Payment', NULL),
(19, 'request_payment/completes', 'Request Payment', 'Request Payment', NULL),
(20, 'exchange/view/{id}', 'Money Exchange', 'Money Exchange', NULL),
(21, 'merchant/edit/{id}', 'Edit Merchant', 'Edit Merchant', NULL),
(22, 'merchant/payments', 'Merchant payments', 'Merchant payments', NULL),
(23, 'deposit', 'Deposit', 'Deposit', NULL),
(24, 'deposit/method/{id}', 'Deposit Amount', 'Deposit Amount', NULL),
(25, 'deposit/stripe_payment', 'Deposit With Stripe', 'Deposit With Stripe', NULL),
(26, 'payout', 'Payout', 'Payout', NULL),
(27, 'withdrawal/method/{id}', 'Payout', 'Payout', NULL),
(28, 'payouts', 'Payouts', 'Payouts', NULL),
(29, 'transactions/{id}', 'Transactions', 'Transactions', NULL),
(30, 'request_payment/accept/{id}', 'Request Payment', 'Request Payment', NULL),
(31, 'request_payment/accept/{id}', 'Request Payment', 'Request Payment', NULL),
(32, 'disputes', 'Disputes', 'Disputes', NULL),
(33, 'merchant/detail/{id}', 'View Merchant', 'View Merchant', NULL),
(34, 'dispute/discussion/{id}', 'Dispute Details', 'Dispute Details', NULL),
(35, 'dispute/add/{id}', 'Dispute Add', 'Dispute Add', NULL),
(36, 'send-money', 'Send Money', 'Send Money', NULL),
(37, 'request-money', 'Request Money', 'Request Money', NULL),
(38, 'news', 'News', 'News', NULL),
(39, 'profile', 'User Profile', 'User Profile', NULL),
(40, 'tickets', 'Tickets', 'Tickets', NULL),
(41, 'ticket/add', 'Add Ticket', 'Add Ticket', NULL),
(42, 'ticket/reply/{id}', 'Ticket Reply', 'Ticket Reply', NULL),
(43, 'exchange_of_base_currency', 'Money Exchange', 'Money Exchange', NULL),
(44, 'exchange/exchange-of-base-currency-confirm', 'Money Exchange', 'Money Exchange', NULL),
(45, 'payout/setting', 'Payout', 'Payout', NULL),
(46, 'payout/store', 'Payout', 'Payout', NULL),
(47, 'send-money-confirm', 'Money Transfer', 'Money Transfer', NULL),
(48, 'exchange_to_base_currency', 'Money Exchange', 'Money Exchange', NULL),
(49, 'exchange/exchange-to-base-currency-confirm', 'Money Exchange', 'Money Exchange', NULL),
(50, 'portfolio', 'Portfolio', 'Portfolio', NULL),
(51, 'request_payment/store', 'Request Payment', 'Request Payment', NULL),
(52, 'forget-password', 'Forgot Password', 'Forgot Password', NULL),
(53, 'password/resets/{token}', 'Reset Password', 'Reset Password', NULL),
(54, 'request-money-confirm', 'Request Money', 'Request Money', NULL),
(55, 'request_payment/accepted', 'Request Payment', 'Request Payment', NULL),
(56, 'request_payment/accept-money-confirm', 'Request Payment', 'Request Payment', NULL),
(57, 'policies', 'Policies', 'Policies', NULL),
(58, 'transfer', 'Money Transfer', 'Money Transfer', NULL),
(59, 'withdrawal/confirm-transaction', 'Payout', 'Payout', NULL),
(60, 'request', 'Request Payment', 'Request Payment', NULL),
(61, 'developer', 'Developer', 'Developer Page', NULL),
(62, 'about-us', 'About us', 'About us', NULL),
(63, 'portfoilo', 'Portfoilo', 'Portfoilo', NULL),
(64, 'contact-us', 'Contact Us', 'Contact Us', NULL),
(65, 'phone-verification', 'Verfy Phone', 'Verfy Phone', NULL),
(66, 'authenticate', '2-Factor Authentication', '2-Factor Authentication', NULL),
(67, 'profile/2fa', '2-FA', '2-FA', NULL),
(68, '2fa', '2-Factor Authentication', '2-Factor Authentication', NULL),
(69, 'google2fa', 'Google 2FA', 'Google 2FA', NULL),
(70, 'exchange-of-money', 'Money Exchange', 'Money Exchange', NULL),
(71, 'exchange-of-money-success', 'Money Exchange', 'Money Exchange', NULL),
(72, 'deposit/bank-payment', 'Deposit', 'Deposit', NULL),
(73, 'deposit/payeer/payment/success', 'Deposit With Payeer', 'Deposit With Payeer', NULL),
(74, 'deposit/checkout/payment/success', 'Deposit with 2checkout', 'Deposit with 2checkout', NULL),
(75, 'merchant/payment', 'Merchant Payment', 'Merchant Payment', NULL),
(76, 'deposit/stripe-payment/success', 'Deposit With Stripe', 'Deposit With Stripe', NULL),
(77, 'deposit/paypal-payment/success', 'Deposit With PayPal', 'Deposit With PayPal', NULL),
(78, 'deposit/bank-payment/success', 'Deposit With Bank', 'Deposit With Bank', NULL),
(79, 'check-user-status', 'Suspended', 'Suspended', NULL),
(80, 'check-request-creator-suspended-status', 'Suspended', 'Suspended', NULL),
(81, 'check-request-creator-inactive-status', 'Inactive', 'Inactive', NULL),
(82, 'deposit/store', 'Deposit Fund', 'Deposit', NULL),
(83, 'deposit/coinpayment-transaction-info', 'Coinpayment Summery', 'Coinpayment Summery', NULL),
(84, 'wallet-list', 'Wallet List', 'Wallet List', NULL),
(85, 'deposit/paypal-payment/success/{amount}', 'Deposit With PayPal', 'Deposit With PayPal', NULL),
(86, 'privacy-policy', 'Privacy Policy', 'Privacy Policy', NULL),
(87, 'deposit/confirm', 'Deposit confirm', 'Deposit confirm', NULL),
(88, 'deposit/confirm', 'Deposit confirm', 'Deposit confirm', NULL),
(89, 'deposit/success', 'Deposit Success', 'Deposit Success', NULL),
(90, 'reset-password/{token}', 'Reset Password', 'Reset Password', ''),
(91, 'register/store-personal-info', 'User Registration', 'User Registration', '');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2019_09_01_0000000002_create_email_configs_table', 1),
(8, '2019_09_01_000000001_entrust_setup_tables', 1),
(9, '2019_09_01_0000001_create_activity_logs_table', 1),
(10, '2019_09_01_0000002_create_backups_table', 1),
(11, '2019_09_01_0000003_create_countries_table', 1),
(12, '2019_09_01_0000004_create_metas_table', 1),
(13, '2019_09_01_0000005_create_settings_table', 1),
(14, '2019_09_01_0000006_create_admins_table', 1),
(15, '2019_09_01_0000010_create_payment_methods_table', 1),
(16, '2019_09_01_0000011_create_merchant_groups_table', 1),
(17, '2019_09_01_0000013_create_preferences_table', 1),
(18, '2019_09_01_0000014_create_reasons_table', 1),
(19, '2019_09_01_0000015_create_time_zones_table', 1),
(20, '2019_09_01_0000016_create_transaction_types_table', 1),
(21, '2019_09_01_0000017_create_socials_table', 1),
(22, '2019_09_01_0000018_create_ticket_statuses_table', 1),
(23, '2019_09_01_0000019_create_currencies_table', 1),
(24, '2019_09_01_0000020_create_currency_payment_methods_table', 1),
(25, '2019_09_01_0000021_create_users_table', 1),
(26, '2019_09_01_0000022_create_user_details_table', 1),
(27, '2019_09_01_0000023_create_fees_limits_table', 1),
(28, '2019_09_01_0000024_create_tickets_table', 1),
(29, '2019_09_01_0000025_create_ticket_replies_table', 1),
(30, '2019_09_01_0000026_create_files_table', 1),
(31, '2019_09_01_0000027_create_merchants_table', 1),
(32, '2019_09_01_0000028_create_merchant_apps_table', 1),
(33, '2019_09_01_0000029_create_banks_table', 1),
(34, '2019_09_01_0000029_create_merchant_payments_table', 1),
(35, '2019_09_01_0000030_create_deposits_table', 1),
(36, '2019_09_01_0000031_create_payout_settings_table', 1),
(37, '2019_09_01_0000032_create_withdrawals_table', 1),
(38, '2019_09_01_0000033_create_withdrawal_details_table', 1),
(39, '2019_09_01_0000034_create_transfers_table', 1),
(40, '2019_09_01_0000035_create_wallets_table', 1),
(41, '2019_09_01_0000036_create_currency_exchanges_table', 1),
(42, '2019_09_01_0000037_create_request_payments_table', 1),
(43, '2019_09_01_0000038_create_transactions_table', 1),
(44, '2019_09_01_0000039_create_disputes_table', 1),
(45, '2019_09_01_0000040_create_dispute_discussions_table', 1),
(46, '2019_09_01_0000043_create_app_tokens_table', 1),
(47, '2019_09_01_0000044_create_app_transactions_infos_table', 1),
(48, '2019_09_01_0000045_create_verify_users_table', 1),
(49, '2019_09_01_0000046_create_device_logs_table', 1),
(50, '2019_09_01_0000047_create_qr_codes_table', 1),
(51, '2019_09_01_0000048_create_password_resets_table', 1),
(52, '2019_09_01_0000049_create_document_verifications_table', 1),
(53, '2019_09_01_000004_create_app_store_credentials_table', 1),
(54, '2019_09_01_000005_create_languages_table', 1),
(55, '2019_09_01_000007_create_email_templates_table', 1),
(56, '2019_09_01_000009_create_pages_table', 1),
(57, '2019_10_22_054304_create_notification_types_table', 1),
(58, '2019_10_22_054339_create_notification_settings_table', 1),
(59, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(60, '2020_01_27_101740_create_sms_configs_table', 1),
(61, '2021_07_12_071706_create_addons_table', 1),
(62, '2021_08_15_075359_create_coinpayment_log_trxes_table', 1),
(63, '2022_07_26_065815_create_crypto_providers_table', 1),
(64, '2022_07_26_070412_create_crypto_asset_settings_table', 1),
(65, '2022_07_26_080438_create_crypto_asset_api_logs_table', 1),
(66, '2023_06_12_110255_create_jobs_table', 1),
(67, '2023_11_05_042724_create_personal_access_tokens_table', 1),
(68, '2023_11_09_113702_create_parameters_table', 1),
(69, '2024_11_30_082008_create_virtualcard_providers_table', 1),
(70, '2024_11_30_082045_create_virtualcard_categories_table', 1),
(71, '2024_11_30_082129_create_virtualcard_feeslimits_table', 1),
(72, '2024_11_30_082213_create_virtualcard_holders_table', 1),
(73, '2024_11_30_082309_create_virtualcards_table', 1),
(74, '2024_11_30_082342_create_virtualcard_transactions_table', 1),
(75, '2024_11_30_082414_create_virtualcard_topups_table', 1),
(76, '2024_11_30_082431_create_virtualcard_withdrawals_table', 1),
(77, '2024_12_05_061523_create_kyc_providers_table', 1),
(78, '2024_12_05_062020_add_provider_id_to_document_verifications_table', 1),
(79, '2024_13_08_025417_create_crypto_tokens_table', 1),
(80, '2025_02_13_030051_create_virtualcard_spending_controls_table', 1),
(81, '2025_02_13_042705_create_virtualcard_spendings_table', 1),
(82, '2025_02_14_100000_add_kyc_fields_to_user_details_table', 1),
(83, '2025_02_14_100001_add_document_type_to_document_verifications_table', 1),
(84, '2025_02_14_120000_create_kyc_partners_table', 1),
(85, '2025_02_14_120001_add_business_registration_type_to_user_details', 1),
(86, '2025_02_14_150000_add_kyc_bank_details_to_user_details', 1),
(87, '2025_02_14_160000_add_kyc_business_registration_fields_to_user_details', 1),
(88, '2025_02_14_170000_add_kyc_authorised_signatory_to_user_details', 1),
(89, '2025_02_14_180000_add_kyc_submit_count_to_user_details', 1),
(90, '2025_02_14_190000_create_products_table', 1),
(91, '2025_02_14_200000_create_user_products_table', 1),
(92, '2025_03_06_100000_create_bill_payment_transactions_table', 1),
(93, '2025_03_06_100001_create_recharge_transactions_table', 1),
(94, '2025_03_07_100000_create_api_request_logs_table', 1),
(95, '2025_03_07_100001_create_aeps_transactions_table', 1),
(96, '2025_03_07_100002_create_bus_booking_transactions_table', 1),
(97, '2025_03_07_100003_create_verification_logs_table', 1),
(98, '2025_03_08_100000_create_service_commissions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE IF NOT EXISTS `notification_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `notification_type_id` int UNSIGNED NOT NULL,
  `recipient_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_settings_notification_type_id_index` (`notification_type_id`),
  KEY `notification_settings_recipient_index` (`recipient`),
  KEY `notification_settings_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `notification_type_id`, `recipient_type`, `recipient`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28'),
(2, 2, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28'),
(3, 3, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28'),
(4, 4, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28'),
(5, 5, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28'),
(6, 6, 'email', 'info@paymanent.com', 'Yes', '2024-08-19 02:28:28', '2024-08-19 02:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

DROP TABLE IF EXISTS `notification_types`;
CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_types_name_unique` (`name`),
  UNIQUE KEY `notification_types_alias_unique` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`, `alias`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Deposit', 'deposit', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27'),
(2, 'Payout', 'payout', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27'),
(3, 'Send', 'send', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27'),
(4, 'Request', 'request', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27'),
(5, 'Exchange', 'exchange', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27'),
(6, 'Payment', 'payment', 'Active', '2024-08-09 02:28:27', '2024-08-09 02:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `client_id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `client_id` int NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'agkL4ISxlzHE5z2zS2vwqZqqoF7ker3HMXo7De3v', 'http://localhost', 1, 0, 0, NULL, NULL),
(2, NULL, 'Laravel Password Grant Client', 'TwF6YvwSCLuVejXhUQCAqMaPAqhHZ29sEhhFfsM9', 'http://localhost', 0, 1, 0, NULL, NULL),
(3, NULL, 'Laravel Personal Access Client', 'YWG63Yjp0bcf7iL45MgK75Yc5Tq18KS9rcv8ltBM', 'http://localhost', 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 2, NULL, NULL),
(3, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'active or inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_url_unique` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE IF NOT EXISTS `parameters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `unique_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active or Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `status`) VALUES
(1, 'Mts', 'Active'),
(2, 'Stripe', 'Active'),
(3, 'Paypal', 'Active'),
(4, 'PayUmoney', 'Active'),
(5, 'Bank', 'Active'),
(6, 'Coinpayments', 'Active'),
(7, 'Payeer', 'Active'),
(8, 'Crypto', 'Active'),
(9, 'Coinbase', 'Active'),
(10, 'Flutterwave', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payout_settings`
--

DROP TABLE IF EXISTS `payout_settings`;
CREATE TABLE IF NOT EXISTS `payout_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `type` int NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `crypto_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` int UNSIGNED DEFAULT NULL,
  `swift_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_payout` tinyint NOT NULL DEFAULT '0' COMMENT '0=not default, 1=default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group`, `name`, `display_name`, `description`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'User', 'view_user', 'View User', 'View User', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(2, 'User', 'add_user', 'Add User', 'Add User', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(3, 'User', 'edit_user', 'Edit User', 'Edit User', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(4, 'User', 'delete_user', 'Delete User', 'Delete User', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(5, 'Transaction', 'view_transaction', 'View Transaction', 'View Transaction', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(6, 'Transaction', 'add_transaction', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(7, 'Transaction', 'edit_transaction', 'Edit Transaction', 'Edit Transaction', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(8, 'Transaction', 'delete_transaction', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(9, 'Deposit', 'view_deposit', 'View Deposit', 'View Deposit', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(10, 'Deposit', 'add_deposit', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(11, 'Deposit', 'edit_deposit', 'Edit Deposit', 'Edit Deposit', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(12, 'Deposit', 'delete_deposit', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(13, 'Withdrawal', 'view_withdrawal', 'View Withdrawal', 'View Withdrawal', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(14, 'Withdrawal', 'add_withdrawal', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(15, 'Withdrawal', 'edit_withdrawal', 'Edit Withdrawal', 'Edit Withdrawal', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(16, 'Withdrawal', 'delete_withdrawal', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(17, 'Transfer', 'view_transfer', 'View Transfer', 'View Transfer', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(18, 'Transfer', 'add_transfer', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(19, 'Transfer', 'edit_transfer', 'Edit Transfer', 'Edit Transfer', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(20, 'Transfer', 'delete_transfer', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(21, 'Exchange', 'view_exchange', 'View Exchange', 'View Exchange', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(22, 'Exchange', 'add_exchange', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(23, 'Exchange', 'edit_exchange', 'Edit Exchange', 'Edit Exchange', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(24, 'Exchange', 'delete_exchange', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(25, 'Request Payment', 'view_request_payment', 'View Request Payment', 'View Request Payment', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(26, 'Request Payment', 'add_request_payment', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(27, 'Request Payment', 'edit_request_payment', 'Edit Request Payment', 'Edit Request Payment', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(28, 'Request Payment', 'delete_request_payment', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(29, 'Revenue', 'view_revenue', 'View Revenue', 'View Revenue', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(30, 'Revenue', 'add_revenue', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(31, 'Revenue', 'edit_revenue', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(32, 'Revenue', 'delete_revenue', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(33, 'Email Template', 'view_email_template', 'View Email Template', 'View Email Template', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(34, 'Email Template', 'add_email_template', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(35, 'Email Template', 'edit_email_template', 'Edit Email Template', 'Edit Email Template', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(36, 'Email Template', 'delete_email_template', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(37, 'Activity Log', 'view_activity_log', 'View Activity Log', 'View Activity Log', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(38, 'Activity Log', 'add_activity_log', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(39, 'Activity Log', 'edit_activity_log', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(40, 'Activity Log', 'delete_activity_log', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(41, 'General Setting', 'view_general_setting', 'View General Setting', 'View General Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(42, 'General Setting', 'add_general_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(43, 'General Setting', 'edit_general_setting', 'Edit General Setting', 'Edit General Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(44, 'General Setting', 'delete_general_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(45, 'Social Links', 'view_social_links', 'View Social Links', 'View Social Links', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(46, 'Social Links', 'add_social_links', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(47, 'Social Links', 'edit_social_links', 'Edit Social Links', 'Edit Social Links', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(48, 'Social Links', 'delete_social_links', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(49, 'API Credentials', 'view_api_credentials', 'View API Credentials', 'View API Credentials', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(50, 'API Credentials', 'add_api_credentials', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(51, 'API Credentials', 'edit_api_credentials', 'Edit API Credentials', 'Edit API Credentials', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(52, 'API Credentials', 'delete_api_credentials', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(53, 'Payment Methods', 'view_payment_methods', 'View Payment Methods', 'View Payment Methods', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(54, 'Payment Methods', 'add_payment_methods', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(55, 'Payment Methods', 'edit_payment_methods', 'Edit Payment Methods', 'Edit Payment Methods', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(56, 'Payment Methods', 'delete_payment_methods', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(57, 'Email Setting', 'view_email_setting', 'View Email Setting', 'View Email Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(58, 'Email Setting', 'add_email_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(59, 'Email Setting', 'edit_email_setting', 'Edit Email Setting', 'Edit Email Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(60, 'Email Setting', 'delete_email_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(61, 'Currency', 'view_currency', 'View Currency', 'View Currency', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(62, 'Currency', 'add_currency', 'Add Currency', 'Add Currency', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(63, 'Currency', 'edit_currency', 'Edit Currency', 'Edit Currency', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(64, 'Currency', 'delete_currency', 'Delete Currency', 'Delete Currency', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(65, 'Country', 'view_country', 'View Country', 'View Country', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(66, 'Country', 'add_country', 'Add Country', 'Add Country', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(67, 'Country', 'edit_country', 'Edit Country', 'Edit Country', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(68, 'Country', 'delete_country', 'Delete Country', 'Delete Country', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(69, 'Language', 'view_language', 'View Language', 'View Language', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(70, 'Language', 'add_language', 'Add Language', 'Add Language', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(71, 'Language', 'edit_language', 'Edit Language', 'Edit Language', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(72, 'Language', 'delete_language', 'Delete Language', 'Delete Language', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(73, 'Role', 'view_role', 'View Role', 'View Role', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(74, 'Role', 'add_role', 'Add Role', 'Add Role', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(75, 'Role', 'edit_role', 'Edit Role', 'Edit Role', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(76, 'Role', 'delete_role', 'Delete Role', 'Delete Role', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(77, 'Database Backup', 'view_database_backup', 'View Database Backup', 'View Database Backup', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(78, 'Database Backup', 'add_database_backup', 'Add Database Backup', 'Add Database Backup', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(79, 'Database Backup', 'edit_database_backup', 'Edit Database Backup', 'Edit Database Backup', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(80, 'Database Backup', 'delete_database_backup', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(81, 'Meta', 'view_meta', 'View Meta', 'View Meta', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(82, 'Meta', 'add_meta', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(83, 'Meta', 'edit_meta', 'Edit Meta', 'Edit Meta', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(84, 'Meta', 'delete_meta', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(85, 'Page', 'view_page', 'View Page', 'View Page', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(86, 'Page', 'add_page', 'Add Page', 'Add Page', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(87, 'Page', 'edit_page', 'Edit Page', 'Edit Page', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(88, 'Page', 'delete_page', 'Delete Page', 'Delete Page', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(89, 'Preference', 'view_preference', 'View Preference', 'View Preference', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(90, 'Preference', 'add_preference', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(91, 'Preference', 'edit_preference', 'Edit Preference', 'Edit Preference', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(92, 'Preference', 'delete_preference', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(93, 'Merchant', 'view_merchant', 'View Merchant', 'View Merchant', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(94, 'Merchant', 'add_merchant', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(95, 'Merchant', 'edit_merchant', 'Edit Merchant', 'Edit Merchant', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(96, 'Merchant', 'delete_merchant', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(97, 'Merchant Payment', 'view_merchant_payment', 'View Merchant Payment', 'View Merchant Payment', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(98, 'Merchant Payment', 'add_merchant_payment', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(99, 'Merchant Payment', 'edit_merchant_payment', 'Edit Merchant Payment', 'Edit Merchant Payment', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(100, 'Merchant Payment', 'delete_merchant_payment', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(101, 'Transaction', 'manage_transaction', 'Manage Transaction', 'Manage Transaction', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(102, 'Deposit', 'manage_deposit', 'Manage Deposit', 'Manage Deposit', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(103, 'Withdrawal', 'manage_withdrawal', 'Manage Withdrawal', 'Manage Withdrawal', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(104, 'Transfer', 'manage_transfer', 'Manage Transfer', 'Manage Transfer', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(105, 'Exchange', 'manage_exchange', 'Manage Exchange', 'Manage Exchange', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(106, 'Request Payment', 'manage_request_payment', 'Manage Request Payment', 'Manage Request Payment', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(107, 'Merchant', 'manage_merchant', 'Manage Merchant', 'Manage Merchant', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(108, 'Merchant Payment', 'manage_merchant_payment', 'Manage Merchant Payment', 'Manage Merchant Payment', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(109, 'User Group', 'view_group', 'View User Group', 'View User Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(110, 'User Group', 'add_group', 'Add User Group', 'Add User Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(111, 'User Group', 'edit_group', 'Edit User Group', 'Edit User Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(112, 'User Group', 'delete_group', 'Delete User Group', 'Delete User Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(113, 'Admins', 'view_admins', 'View Admins', 'View Admins', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(114, 'Admins', 'add_admin', 'Add Admin', 'Add Admin', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(115, 'Admins', 'edit_admin', 'Edit Admin', 'Edit Admin', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(116, 'Admins', 'delete_admin', 'Delete Admin', 'Delete Admin', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(117, 'Disputes', 'view_disputes', 'View Disputes', 'View Disputes', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(118, 'Disputes', 'add_dispute', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(119, 'Disputes', 'edit_dispute', 'Edit Dispute', 'Edit Dispute', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(120, 'Disputes', 'delete_dispute', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(121, 'Tickets', 'view_tickets', 'View Tickets', 'View Tickets', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(122, 'Tickets', 'add_ticket', 'Add Ticket', 'Add Ticket', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(123, 'Tickets', 'edit_ticket', 'Edit Ticket', 'Edit Ticket', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(124, 'Tickets', 'delete_ticket', 'Delete Ticket', 'Delete Ticket', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(125, 'Dispute', 'manage_dispute', 'Manage Dispute', 'Manage Dispute', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(126, 'Ticket', 'manage_ticket', 'Manage Ticket', 'Manage Ticket', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(127, 'Settings', 'manage_setting', 'Manage Settings', 'Manage Settings', 'User', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(128, 'AppStore Credentials', 'view_appstore_credentials', 'View AppStore Credentials', 'View AppStore Credentials', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(129, 'AppStore Credentials', 'add_appstore_credentials', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(130, 'AppStore Credentials', 'edit_appstore_credentials', 'Edit AppStore Credentials', 'Edit AppStore Credentials', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(131, 'AppStore Credentials', 'delete_appstore_credentials', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(132, 'Merchant Groups', 'view_merchant_group', 'View Merchant Group', 'View Merchant Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(133, 'Merchant Groups', 'add_merchant_group', 'Add Merchant Group', 'Add Merchant Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(134, 'Merchant Groups', 'edit_merchant_group', 'Edit Merchant Group', 'Edit Merchant Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(135, 'Merchant Groups', 'delete_merchant_group', 'Delete Merchant Group', 'Delete Merchant Group', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(136, 'SMS Setting', 'view_sms_setting', 'View SMS Setting', 'View SMS Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(137, 'SMS Setting', 'add_sms_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(138, 'SMS Setting', 'edit_sms_setting', 'Edit SMS Setting', 'Edit SMS Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(139, 'SMS Setting', 'delete_sms_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(140, 'Sms Template', 'view_sms_template', 'View Sms Template', 'View Sms Template', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(141, 'Sms Template', 'add_sms_template', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(142, 'Sms Template', 'edit_sms_template', 'Edit Sms Template', 'Edit Sms Template', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(143, 'Sms Template', 'delete_sms_template', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(144, 'Admin Security', 'view_admin_security', 'View Admin Security', 'View Admin Security', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(145, 'Admin Security', 'add_admin_security', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(146, 'Admin Security', 'edit_admin_security', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(147, 'Admin Security', 'delete_admin_security', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(148, 'Notification Type', 'view_notification_type', 'View Notification Type', 'View Notification Type', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(149, 'Notification Type', 'add_notification_type', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(150, 'Notification Type', 'edit_notification_type', 'Edit Notification Type', 'Edit Notification Type', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(151, 'Notification Type', 'delete_notification_type', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(152, 'Notification Setting', 'view_notification_setting', 'View Notification Setting', 'View Notification Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(153, 'Notification Setting', 'add_notification_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(154, 'Notification Setting', 'edit_notification_setting', 'Edit Notification Setting', 'Edit Notification Setting', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(155, 'Notification Setting', 'delete_notification_setting', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(156, 'Conversion Rate Api', 'view_conversion_rate_api', 'View Conversion Rate Api', 'View Conversion Rate Api', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(157, 'Conversion Rate Api', 'add_conversion_rate_api', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(158, 'Conversion Rate Api', 'edit_conversion_rate_api', 'Edit Conversion Rate Api', 'Edit Conversion Rate Api', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(159, 'Conversion Rate Api', 'delete_conversion_rate_api', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(160, 'Addon Manager', 'view_addon_manager', 'View Addon Manager', 'View Addon Manager', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(161, 'Addon Manager', 'add_addon_manager', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(162, 'Addon Manager', 'edit_addon_manager', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(163, 'Addon Manager', 'delete_addon_manager', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(164, 'Crypto Provider', 'view_crypto_provider', 'View Crypto Provider', 'View Addon Manager', 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(165, 'Crypto Provider', 'add_crypto_provider', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(166, 'Crypto Provider', 'edit_crypto_provider', 'Edit Crypto Provider', NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(167, 'Crypto Provider', 'delete_crypto_provider', NULL, NULL, 'Admin', '2024-01-22 02:28:28', '2024-01-22 02:28:28'),
(168, 'Cache Clear', 'view_cache_clear', 'View Cache Clear', 'View Cache Clear', 'Admin', NULL, NULL),
(169, 'Cache Clear', 'add_cache_clear', 'Add Cache Clear', 'Add Cache Clear', 'Admin', NULL, NULL),
(170, 'Cache Clear', 'edit_cache_clear', 'Edit Cache Clear', 'Edit Cache Clear', 'Admin', NULL, NULL),
(171, 'Cache Clear', 'delete_cache_clear', 'Delete Cache Clear', 'Delete Cache Clear', 'Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `role_id` int UNSIGNED NOT NULL,
  `permission_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(1, 9),
(1, 11),
(1, 13),
(1, 15),
(1, 17),
(1, 19),
(1, 21),
(1, 23),
(1, 25),
(1, 27),
(1, 29),
(1, 33),
(1, 35),
(1, 37),
(1, 41),
(1, 43),
(1, 45),
(1, 47),
(1, 49),
(1, 51),
(1, 53),
(1, 55),
(1, 57),
(1, 59),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 81),
(1, 83),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 91),
(1, 93),
(1, 95),
(1, 97),
(1, 99),
(2, 101),
(3, 101),
(2, 102),
(3, 102),
(2, 103),
(3, 103),
(2, 104),
(3, 104),
(2, 105),
(3, 105),
(2, 106),
(3, 106),
(3, 107),
(3, 108),
(1, 109),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 119),
(1, 121),
(1, 122),
(1, 123),
(1, 124),
(2, 125),
(3, 125),
(2, 126),
(3, 126),
(2, 127),
(3, 127),
(1, 128),
(1, 130),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 138),
(1, 140),
(1, 142),
(1, 144),
(1, 148),
(1, 150),
(1, 152),
(1, 154),
(1, 156),
(1, 158),
(1, 160),
(1, 164),
(1, 166),
(1, 168),
(1, 169),
(1, 170),
(1, 171);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

DROP TABLE IF EXISTS `preferences`;
CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `field` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `preferences_field_unique` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `category`, `field`, `value`) VALUES
(1, 'preference', 'row_per_page', '25'),
(2, 'preference', 'date_format', '1'),
(3, 'preference', 'date_sepa', '-'),
(4, 'company', 'site_short_name', 'PM'),
(5, 'preference', 'percentage', '2'),
(6, 'preference', 'quantity', '0'),
(7, 'preference', 'date_format_type', 'dd-mm-yyyy'),
(8, 'company', 'company_name', 'Paymanent'),
(9, 'company', 'company_email', 'info@paymanent.com'),
(10, 'company', 'dflt_lang', 'en'),
(11, 'preference', 'default_money_format', '&nbsp;&#36;'),
(12, 'preference', 'money_format', 'before'),
(13, 'preference', 'decimal_format_amount', '2'),
(14, 'preference', 'thousand_separator', ','),
(15, 'preference', 'dflt_timezone', 'Asia/Dhaka'),
(16, 'preference', 'verification_mail', 'Disabled'),
(17, 'preference', 'phone_verification', 'Disabled'),
(18, 'preference', 'two_step_verification', 'disabled'),
(19, 'preference', 'processed_by', 'email'),
(20, 'preference', 'decimal_format_amount_crypto', '8'),
(21, 'preference', 'admin_url_prefix', 'admin'),
(22, 'preference', 'file_size', '2');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Font Awesome class e.g. fa fa-money-bill',
  `section` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available' COMMENT 'activated, available',
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

DROP TABLE IF EXISTS `qr_codes`;
CREATE TABLE IF NOT EXISTS `qr_codes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `object_id` int DEFAULT NULL,
  `object_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qr_codes_object_id_index` (`object_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `object_id`, `object_type`, `secret`, `qr_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', 'VTBZNGFzbEdYUlBFR3ovU3RxL2ZSRDNsUVZ4ay96MHFvcHNaUWJhZlk5OTR1bHdKMWgwT3d1VExKbVJJRmp5Qw==', '1790789408.jpg', 'Active', '2026-09-30 12:00:08', '2026-09-30 12:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE IF NOT EXISTS `reasons` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reasons`
--

INSERT INTO `reasons` (`id`, `title`) VALUES
(1, 'I have not received the goods'),
(2, 'Description does not match with product');

-- --------------------------------------------------------

--
-- Table structure for table `recharge_transactions`
--

DROP TABLE IF EXISTS `recharge_transactions`;
CREATE TABLE IF NOT EXISTS `recharge_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `reference_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `api_response` json DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recharge_transactions_reference_id_unique` (`reference_id`),
  KEY `recharge_transactions_user_id_index` (`user_id`),
  KEY `recharge_transactions_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_payments`
--

DROP TABLE IF EXISTS `request_payments`;
CREATE TABLE IF NOT EXISTS `request_payments` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `receiver_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID (For Each Payment Request)',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `accept_amount` decimal(20,8) DEFAULT '0.00000000',
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `request_payments_user_id_index` (`user_id`),
  KEY `request_payments_receiver_id_index` (`receiver_id`),
  KEY `request_payments_currency_id_index` (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `user_type`, `customer_type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'Admin', 'user', 'No', NULL, NULL),
(2, 'Default User', 'Default User', 'Default User', 'User', 'user', 'Yes', NULL, NULL),
(3, 'Merchant Regular', 'Merchant Regular', 'Merchant Regular', 'User', 'merchant', 'Yes', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `user_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`, `user_type`) VALUES
(1, 1, 'Admin'),
(1, 2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `service_commissions`
--

DROP TABLE IF EXISTS `service_commissions`;
CREATE TABLE IF NOT EXISTS `service_commissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'aeps, recharge, bbps, bus_booking, verification',
  `service_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_percent` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT 'Admin commission %',
  `commission_fixed` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Admin commission fixed amount',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_commissions_service_slug_unique` (`service_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`) VALUES
(1, 'name', 'Paymanent', 'general'),
(2, 'logo', '1532175849_logo.png', 'general'),
(3, 'favicon', '1530689937_favicon.png', 'general'),
(4, 'head_code', '', 'general'),
(5, 'default_currency', '1', 'general'),
(6, 'allowed_wallets', '2,3', 'general'),
(7, 'default_language', '1', 'general'),
(8, 'site_key', '', 'recaptcha'),
(9, 'secret_key', '', 'recaptcha'),
(10, 'default_timezone', 'Asia/Dhaka', 'general'),
(11, 'has_captcha', 'Disabled', 'general'),
(12, 'login_via', 'email_only', 'general'),
(13, 'admin_access_ip_setting', 'Disabled', 'admin_security'),
(14, 'admin_access_ips', '::1', 'admin_security'),
(15, 'exchange_enabled_api', 'Disabled', 'currency_exchange_rate'),
(16, 'currency_converter_api_key', NULL, 'currency_exchange_rate'),
(17, 'exchange_rate_api_key', NULL, 'currency_exchange_rate'),
(18, 'crypto_compare_enabled_api', 'Disabled', 'crypto_compare_rate'),
(19, 'crypto_compare_api_key', '', 'crypto_compare_rate');

-- --------------------------------------------------------

--
-- Table structure for table `sms_configs`
--

DROP TABLE IF EXISTS `sms_configs`;
CREATE TABLE IF NOT EXISTS `sms_configs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sms_configs_type_index` (`type`),
  KEY `sms_configs_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_configs`
--

INSERT INTO `sms_configs` (`id`, `type`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'twilio', '', 'Inactive', '2024-05-01 02:28:28', '2024-05-01 02:28:28'),
(2, 'nexmo', '', 'Inactive', '2024-05-01 02:28:28', '2024-05-01 02:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

DROP TABLE IF EXISTS `socials`;
CREATE TABLE IF NOT EXISTS `socials` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `icon` text NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `name`, `icon`, `url`) VALUES
(1, 'facebook', '<div class=\"facebook\" id=\"facebook\">\r\n                            <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                            <rect width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"></rect>\r\n                            <g clip-path=\"url(#clip0_2297_2968)\">\r\n                            <path d=\"M24.5094 32.4052V23.6116H27.5441L27.9985 20.1846H24.5094V17.9966C24.5094 17.0044 24.7927 16.3282 26.2557 16.3282L28.1215 16.3274V13.2623C27.7986 13.2207 26.6911 13.1274 25.4027 13.1274C22.7126 13.1274 20.8709 14.7244 20.8709 17.6574V20.1847H17.8284V23.6117H20.8708V32.4053L24.5094 32.4052Z\" fill=\"white\"></path>\r\n                            </g>\r\n                            <defs>\r\n                            <clipPath id=\"clip0_2297_2968\">\r\n                            <rect width=\"10.2931\" height=\"19.2823\" fill=\"white\" transform=\"translate(17.8284 13.125)\"></rect>\r\n                            </clipPath>\r\n                            </defs>\r\n                            </svg>\r\n                            </div>', '#'),
(2, 'twitter', '<div class=\"twitter ml-11\" id=\"twitter\">\r\n                            <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                            <rect x=\"0.0402832\" width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"></rect>\r\n                            <path d=\"M32.4132 16.0164C31.6927 16.325 30.8693 16.5306 30.0458 16.6335C30.8693 16.1193 31.5898 15.2966 31.8986 14.371C31.0751 14.8852 30.2517 15.1937 29.2224 15.3994C28.5019 14.5767 27.3696 14.0625 26.2374 14.0625C23.9729 14.0625 22.1201 15.9136 22.1201 18.1761C22.1201 18.4846 22.1201 18.7931 22.2231 19.1016C18.8263 18.8959 15.7384 17.2505 13.6798 14.7824C13.371 15.3994 13.1651 16.1193 13.1651 16.8392C13.1651 18.2789 13.8857 19.513 15.0179 20.2328C14.2974 20.2328 13.6798 20.0272 13.1651 19.7186C13.1651 21.6726 14.6062 23.4208 16.4589 23.7294C16.1501 23.8322 15.7384 23.8322 15.3267 23.8322C15.0179 23.8322 14.812 23.8322 14.5032 23.7294C15.0179 25.3748 16.5619 26.6089 18.4146 26.6089C16.9736 27.7401 15.2238 28.3571 13.2681 28.3571C12.9593 28.3571 12.6505 28.3571 12.2388 28.2543C14.0915 29.3855 16.2531 30.1054 18.6205 30.1054C26.2374 30.1054 30.3546 23.8322 30.3546 18.3817V17.8675C31.178 17.559 31.8986 16.8391 32.4132 16.0164Z\" fill=\"white\"></path>\r\n                            </svg>\r\n                            </div>', '#'),
(3, 'linkedin', '<div class=\"linkdin ml-11\" id=\"linkdin\">\r\n                    <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                    <rect x=\"0.201416\" width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"></rect>\r\n                    <path d=\"M17.5146 31.9712V19.8375H13.4417V31.9712H17.5146ZM15.4787 18.1799C16.8989 18.1799 17.783 17.2481 17.783 16.0838C17.7565 14.8932 16.899 13.9873 15.5056 13.9873C14.1125 13.9873 13.2014 14.8932 13.2014 16.0838C13.2014 17.2482 14.0853 18.1799 15.4521 18.1799H15.4785H15.4787ZM19.7689 31.9712H23.8417V25.1952C23.8417 24.8325 23.8682 24.4703 23.9757 24.211C24.2702 23.4865 24.9403 22.736 26.0654 22.736C27.5392 22.736 28.1288 23.8487 28.1288 25.4799V31.9711H32.2014V25.0138C32.2014 21.2868 30.1921 19.5526 27.5124 19.5526C25.3153 19.5526 24.3506 20.7688 23.8146 21.597H23.8418V19.8373H19.769C19.8224 20.9758 19.769 31.971 19.769 31.971L19.7689 31.9712Z\" fill=\"white\"></path>\r\n                    </svg>\r\n                    </div>', '#'),
(4, 'pinterest', '<div class=\"pinterest ml-11\" id=\"pinterest\">\r\n                    <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                    <rect x=\"0.161133\" width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"></rect>\r\n                    <path d=\"M28.5611 15.0943C27.247 13.7814 25.3582 13.125 23.305 13.125C20.1842 13.125 18.2953 14.4378 17.2277 15.5045C15.9137 16.8174 15.1746 18.5405 15.1746 20.3456C15.1746 22.561 16.0779 24.2021 17.6383 24.8585C17.7205 24.9406 17.8847 24.9406 17.9668 24.9406C18.2953 24.9406 18.5417 24.6944 18.6239 24.3662C18.706 24.2021 18.7881 23.7098 18.8702 23.4636C18.9523 23.0534 18.8702 22.8892 18.6239 22.561C18.2132 22.0687 17.9668 21.4123 17.9668 20.5918C17.9668 18.2123 19.7736 15.6686 23.0586 15.6686C25.6867 15.6686 27.3292 17.1456 27.3292 19.5251C27.3292 21.002 27.0007 22.3969 26.4258 23.4636C26.0152 24.2021 25.276 25.0226 24.2084 25.0226C23.7156 25.0226 23.305 24.8585 23.0586 24.4482C22.8123 24.12 22.7301 23.7098 22.8122 23.2995C22.8944 22.8072 23.0586 22.3149 23.2229 21.8226C23.4693 20.92 23.7978 20.0174 23.7978 19.361C23.7978 18.2123 23.0586 17.3917 21.991 17.3917C20.5949 17.3917 19.5272 18.7866 19.5272 20.5097C19.5272 21.4123 19.7736 21.9867 19.8557 22.2328C19.6915 22.9713 18.6238 27.3201 18.4596 28.0585C18.3775 28.5509 17.6383 32.3253 18.7881 32.5714C20.02 32.8996 21.1697 29.2073 21.2519 28.797C21.334 28.4688 21.6625 27.156 21.8268 26.4175C22.4016 26.9919 23.3871 27.4021 24.3727 27.4021C26.1794 27.4021 27.7398 26.5816 28.8896 25.1047C29.9572 23.7098 30.6142 21.7405 30.6142 19.5251C30.5321 18.0482 29.8751 16.3251 28.5611 15.0943Z\" fill=\"white\"></path>\r\n                    </svg>\r\n                    </div>', '#'),
(5, 'youtube', '<div class=\"whtsapp ml-11\" id=\"whtsapp\">\r\n                            <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                            <rect x=\"0.0400391\" width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"/>\r\n                            <path d=\"M28.9291 14.0528C30.2064 14.1845 31.8674 14.0528 32.7619 15.0988C33.7842 16.144 33.913 17.841 33.913 19.1476C34.04 20.7148 34.04 22.9367 34.04 24.3714C33.913 25.8096 34.04 27.5058 33.3996 28.8142C32.7628 30.2489 31.6116 30.7737 30.2064 30.9026C28.6715 31.0325 19.2171 31.0325 16.1518 30.9026C14.7458 30.7728 13.0848 30.7728 12.0624 29.5969C11.1679 28.5509 11.1679 26.9846 11.04 25.6789C11.04 24.1108 11.04 21.8898 11.04 20.3235C11.04 18.8861 11.04 17.1891 11.6787 15.8825C12.3182 14.5767 13.5955 14.3152 15.0007 14.1854C16.5338 14.0537 25.8603 13.9239 28.9282 14.0537L28.9291 14.0528ZM19.9846 18.4939V26.3299L27.0123 22.4119L19.9846 18.4939Z\" fill=\"white\"/>\r\n                            </svg>\r\n                            </div>', '#'),
(6, 'instagram', '<div class=\"instagram ml-11\" id=\"instagram\">\r\n                            <svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"#402875\" xmlns=\"http://www.w3.org/2000/svg\">\r\n                            <rect x=\"0.0805664\" width=\"45.0402\" height=\"45\" rx=\"4\" fill=\"\"></rect>\r\n                            <path d=\"M28.8545 14.0625H16.5944C15.2101 14.0625 14.1555 15.1162 14.1555 16.4992V28.7483C14.1555 30.1313 15.2101 31.185 16.5944 31.185H28.8545C30.2387 31.185 31.2933 30.1313 31.2933 28.7483V16.4992C31.2933 15.1162 30.2387 14.0625 28.8545 14.0625ZM22.7244 27.7605C25.5587 27.7605 27.8657 25.5214 27.8657 22.8213C27.8657 22.3603 27.7998 21.8335 27.668 21.4383H29.1181V28.419C29.1181 28.7483 28.8545 29.0776 28.459 29.0776H16.9898C16.6603 29.0776 16.3307 28.8142 16.3307 28.419V21.3725H17.8467C17.7149 21.8335 17.649 22.2945 17.649 22.7554C17.5831 25.5214 19.8901 27.7605 22.7244 27.7605ZM22.7244 25.7848C20.8788 25.7848 19.4287 24.336 19.4287 22.5579C19.4287 20.7798 20.8788 19.331 22.7244 19.331C24.57 19.331 26.0201 20.7798 26.0201 22.5579C26.0201 24.4018 24.57 25.7848 22.7244 25.7848ZM29.0522 18.7383C29.0522 19.1334 28.7226 19.4627 28.3271 19.4627H26.4815C26.086 19.4627 25.7565 19.1334 25.7565 18.7383V16.9601C25.7565 16.565 26.086 16.2357 26.4815 16.2357H28.3271C28.7226 16.2357 29.0522 16.565 29.0522 16.9601V18.7383Z\" fill=\"white\"></path>\r\n                            </svg>\r\n                            </div>', '#');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ticket_status_id` int UNSIGNED DEFAULT NULL,
  `subject` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Low' COMMENT 'Low, Normal, High',
  `last_reply` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_admin_id_index` (`admin_id`),
  KEY `tickets_user_id_index` (`user_id`),
  KEY `tickets_ticket_status_id_index` (`ticket_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

DROP TABLE IF EXISTS `ticket_replies`;
CREATE TABLE IF NOT EXISTS `ticket_replies` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ticket_id` int UNSIGNED DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_type` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'admin or user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_replies_admin_id_index` (`admin_id`),
  KEY `ticket_replies_user_id_index` (`user_id`),
  KEY `ticket_replies_ticket_id_index` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

DROP TABLE IF EXISTS `ticket_statuses`;
CREATE TABLE IF NOT EXISTS `ticket_statuses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_statuses`
--

INSERT INTO `ticket_statuses` (`id`, `name`, `color`, `is_default`) VALUES
(1, 'Open', '00a65a', 0),
(2, 'In Progress', '3c8dbc', 1),
(3, 'Hold', 'f39c12', 0),
(4, 'Closed', 'dd4b39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `time_zones`
--

DROP TABLE IF EXISTS `time_zones`;
CREATE TABLE IF NOT EXISTS `time_zones` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `zone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=426 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_zones`
--

INSERT INTO `time_zones` (`id`, `zone`, `gmt`, `created_at`, `updated_at`) VALUES
(1, 'Africa/Abidjan', 'UTC/GMT +00:00', NULL, NULL),
(2, 'Africa/Accra', 'UTC/GMT +00:00', NULL, NULL),
(3, 'Africa/Addis_Ababa', 'UTC/GMT +03:00', NULL, NULL),
(4, 'Africa/Algiers', 'UTC/GMT +01:00', NULL, NULL),
(5, 'Africa/Asmara', 'UTC/GMT +03:00', NULL, NULL),
(6, 'Africa/Bamako', 'UTC/GMT +00:00', NULL, NULL),
(7, 'Africa/Bangui', 'UTC/GMT +01:00', NULL, NULL),
(8, 'Africa/Banjul', 'UTC/GMT +00:00', NULL, NULL),
(9, 'Africa/Bissau', 'UTC/GMT +00:00', NULL, NULL),
(10, 'Africa/Blantyre', 'UTC/GMT +02:00', NULL, NULL),
(11, 'Africa/Brazzaville', 'UTC/GMT +01:00', NULL, NULL),
(12, 'Africa/Bujumbura', 'UTC/GMT +02:00', NULL, NULL),
(13, 'Africa/Cairo', 'UTC/GMT +02:00', NULL, NULL),
(14, 'Africa/Casablanca', 'UTC/GMT +01:00', NULL, NULL),
(15, 'Africa/Ceuta', 'UTC/GMT +02:00', NULL, NULL),
(16, 'Africa/Conakry', 'UTC/GMT +00:00', NULL, NULL),
(17, 'Africa/Dakar', 'UTC/GMT +00:00', NULL, NULL),
(18, 'Africa/Dar_es_Salaam', 'UTC/GMT +03:00', NULL, NULL),
(19, 'Africa/Djibouti', 'UTC/GMT +03:00', NULL, NULL),
(20, 'Africa/Douala', 'UTC/GMT +01:00', NULL, NULL),
(21, 'Africa/El_Aaiun', 'UTC/GMT +01:00', NULL, NULL),
(22, 'Africa/Freetown', 'UTC/GMT +00:00', NULL, NULL),
(23, 'Africa/Gaborone', 'UTC/GMT +02:00', NULL, NULL),
(24, 'Africa/Harare', 'UTC/GMT +02:00', NULL, NULL),
(25, 'Africa/Johannesburg', 'UTC/GMT +02:00', NULL, NULL),
(26, 'Africa/Juba', 'UTC/GMT +03:00', NULL, NULL),
(27, 'Africa/Kampala', 'UTC/GMT +03:00', NULL, NULL),
(28, 'Africa/Khartoum', 'UTC/GMT +02:00', NULL, NULL),
(29, 'Africa/Kigali', 'UTC/GMT +02:00', NULL, NULL),
(30, 'Africa/Kinshasa', 'UTC/GMT +01:00', NULL, NULL),
(31, 'Africa/Lagos', 'UTC/GMT +01:00', NULL, NULL),
(32, 'Africa/Libreville', 'UTC/GMT +01:00', NULL, NULL),
(33, 'Africa/Lome', 'UTC/GMT +00:00', NULL, NULL),
(34, 'Africa/Luanda', 'UTC/GMT +01:00', NULL, NULL),
(35, 'Africa/Lubumbashi', 'UTC/GMT +02:00', NULL, NULL),
(36, 'Africa/Lusaka', 'UTC/GMT +02:00', NULL, NULL),
(37, 'Africa/Malabo', 'UTC/GMT +01:00', NULL, NULL),
(38, 'Africa/Maputo', 'UTC/GMT +02:00', NULL, NULL),
(39, 'Africa/Maseru', 'UTC/GMT +02:00', NULL, NULL),
(40, 'Africa/Mbabane', 'UTC/GMT +02:00', NULL, NULL),
(41, 'Africa/Mogadishu', 'UTC/GMT +03:00', NULL, NULL),
(42, 'Africa/Monrovia', 'UTC/GMT +00:00', NULL, NULL),
(43, 'Africa/Nairobi', 'UTC/GMT +03:00', NULL, NULL),
(44, 'Africa/Ndjamena', 'UTC/GMT +01:00', NULL, NULL),
(45, 'Africa/Niamey', 'UTC/GMT +01:00', NULL, NULL),
(46, 'Africa/Nouakchott', 'UTC/GMT +00:00', NULL, NULL),
(47, 'Africa/Ouagadougou', 'UTC/GMT +00:00', NULL, NULL),
(48, 'Africa/Porto-Novo', 'UTC/GMT +01:00', NULL, NULL),
(49, 'Africa/Sao_Tome', 'UTC/GMT +01:00', NULL, NULL),
(50, 'Africa/Tripoli', 'UTC/GMT +02:00', NULL, NULL),
(51, 'Africa/Tunis', 'UTC/GMT +01:00', NULL, NULL),
(52, 'Africa/Windhoek', 'UTC/GMT +02:00', NULL, NULL),
(53, 'America/Adak', 'UTC/GMT -09:00', NULL, NULL),
(54, 'America/Anchorage', 'UTC/GMT -08:00', NULL, NULL),
(55, 'America/Anguilla', 'UTC/GMT -04:00', NULL, NULL),
(56, 'America/Antigua', 'UTC/GMT -04:00', NULL, NULL),
(57, 'America/Araguaina', 'UTC/GMT -03:00', NULL, NULL),
(58, 'America/Argentina/Buenos_Aires', 'UTC/GMT -03:00', NULL, NULL),
(59, 'America/Argentina/Catamarca', 'UTC/GMT -03:00', NULL, NULL),
(60, 'America/Argentina/Cordoba', 'UTC/GMT -03:00', NULL, NULL),
(61, 'America/Argentina/Jujuy', 'UTC/GMT -03:00', NULL, NULL),
(62, 'America/Argentina/La_Rioja', 'UTC/GMT -03:00', NULL, NULL),
(63, 'America/Argentina/Mendoza', 'UTC/GMT -03:00', NULL, NULL),
(64, 'America/Argentina/Rio_Gallegos', 'UTC/GMT -03:00', NULL, NULL),
(65, 'America/Argentina/Salta', 'UTC/GMT -03:00', NULL, NULL),
(66, 'America/Argentina/San_Juan', 'UTC/GMT -03:00', NULL, NULL),
(67, 'America/Argentina/San_Luis', 'UTC/GMT -03:00', NULL, NULL),
(68, 'America/Argentina/Tucuman', 'UTC/GMT -03:00', NULL, NULL),
(69, 'America/Argentina/Ushuaia', 'UTC/GMT -03:00', NULL, NULL),
(70, 'America/Aruba', 'UTC/GMT -04:00', NULL, NULL),
(71, 'America/Asuncion', 'UTC/GMT -04:00', NULL, NULL),
(72, 'America/Atikokan', 'UTC/GMT -05:00', NULL, NULL),
(73, 'America/Bahia', 'UTC/GMT -03:00', NULL, NULL),
(74, 'America/Bahia_Banderas', 'UTC/GMT -05:00', NULL, NULL),
(75, 'America/Barbados', 'UTC/GMT -04:00', NULL, NULL),
(76, 'America/Belem', 'UTC/GMT -03:00', NULL, NULL),
(77, 'America/Belize', 'UTC/GMT -06:00', NULL, NULL),
(78, 'America/Blanc-Sablon', 'UTC/GMT -04:00', NULL, NULL),
(79, 'America/Boa_Vista', 'UTC/GMT -04:00', NULL, NULL),
(80, 'America/Bogota', 'UTC/GMT -05:00', NULL, NULL),
(81, 'America/Boise', 'UTC/GMT -06:00', NULL, NULL),
(82, 'America/Cambridge_Bay', 'UTC/GMT -06:00', NULL, NULL),
(83, 'America/Campo_Grande', 'UTC/GMT -04:00', NULL, NULL),
(84, 'America/Cancun', 'UTC/GMT -05:00', NULL, NULL),
(85, 'America/Caracas', 'UTC/GMT -04:00', NULL, NULL),
(86, 'America/Cayenne', 'UTC/GMT -03:00', NULL, NULL),
(87, 'America/Cayman', 'UTC/GMT -05:00', NULL, NULL),
(88, 'America/Chicago', 'UTC/GMT -05:00', NULL, NULL),
(89, 'America/Chihuahua', 'UTC/GMT -06:00', NULL, NULL),
(90, 'America/Costa_Rica', 'UTC/GMT -06:00', NULL, NULL),
(91, 'America/Creston', 'UTC/GMT -07:00', NULL, NULL),
(92, 'America/Cuiaba', 'UTC/GMT -04:00', NULL, NULL),
(93, 'America/Curacao', 'UTC/GMT -04:00', NULL, NULL),
(94, 'America/Danmarkshavn', 'UTC/GMT +00:00', NULL, NULL),
(95, 'America/Dawson', 'UTC/GMT -07:00', NULL, NULL),
(96, 'America/Dawson_Creek', 'UTC/GMT -07:00', NULL, NULL),
(97, 'America/Denver', 'UTC/GMT -06:00', NULL, NULL),
(98, 'America/Detroit', 'UTC/GMT -04:00', NULL, NULL),
(99, 'America/Dominica', 'UTC/GMT -04:00', NULL, NULL),
(100, 'America/Edmonton', 'UTC/GMT -06:00', NULL, NULL),
(101, 'America/Eirunepe', 'UTC/GMT -05:00', NULL, NULL),
(102, 'America/El_Salvador', 'UTC/GMT -06:00', NULL, NULL),
(103, 'America/Fort_Nelson', 'UTC/GMT -07:00', NULL, NULL),
(104, 'America/Fortaleza', 'UTC/GMT -03:00', NULL, NULL),
(105, 'America/Glace_Bay', 'UTC/GMT -03:00', NULL, NULL),
(106, 'America/Godthab', 'UTC/GMT -02:00', NULL, NULL),
(107, 'America/Goose_Bay', 'UTC/GMT -03:00', NULL, NULL),
(108, 'America/Grand_Turk', 'UTC/GMT -04:00', NULL, NULL),
(109, 'America/Grenada', 'UTC/GMT -04:00', NULL, NULL),
(110, 'America/Guadeloupe', 'UTC/GMT -04:00', NULL, NULL),
(111, 'America/Guatemala', 'UTC/GMT -06:00', NULL, NULL),
(112, 'America/Guayaquil', 'UTC/GMT -05:00', NULL, NULL),
(113, 'America/Guyana', 'UTC/GMT -04:00', NULL, NULL),
(114, 'America/Halifax', 'UTC/GMT -03:00', NULL, NULL),
(115, 'America/Havana', 'UTC/GMT -04:00', NULL, NULL),
(116, 'America/Hermosillo', 'UTC/GMT -07:00', NULL, NULL),
(117, 'America/Indiana/Indianapolis', 'UTC/GMT -04:00', NULL, NULL),
(118, 'America/Indiana/Knox', 'UTC/GMT -05:00', NULL, NULL),
(119, 'America/Indiana/Marengo', 'UTC/GMT -04:00', NULL, NULL),
(120, 'America/Indiana/Petersburg', 'UTC/GMT -04:00', NULL, NULL),
(121, 'America/Indiana/Tell_City', 'UTC/GMT -05:00', NULL, NULL),
(122, 'America/Indiana/Vevay', 'UTC/GMT -04:00', NULL, NULL),
(123, 'America/Indiana/Vincennes', 'UTC/GMT -04:00', NULL, NULL),
(124, 'America/Indiana/Winamac', 'UTC/GMT -04:00', NULL, NULL),
(125, 'America/Inuvik', 'UTC/GMT -06:00', NULL, NULL),
(126, 'America/Iqaluit', 'UTC/GMT -04:00', NULL, NULL),
(127, 'America/Jamaica', 'UTC/GMT -05:00', NULL, NULL),
(128, 'America/Juneau', 'UTC/GMT -08:00', NULL, NULL),
(129, 'America/Kentucky/Louisville', 'UTC/GMT -04:00', NULL, NULL),
(130, 'America/Kentucky/Monticello', 'UTC/GMT -04:00', NULL, NULL),
(131, 'America/Kralendijk', 'UTC/GMT -04:00', NULL, NULL),
(132, 'America/La_Paz', 'UTC/GMT -04:00', NULL, NULL),
(133, 'America/Lima', 'UTC/GMT -05:00', NULL, NULL),
(134, 'America/Los_Angeles', 'UTC/GMT -07:00', NULL, NULL),
(135, 'America/Lower_Princes', 'UTC/GMT -04:00', NULL, NULL),
(136, 'America/Maceio', 'UTC/GMT -03:00', NULL, NULL),
(137, 'America/Managua', 'UTC/GMT -06:00', NULL, NULL),
(138, 'America/Manaus', 'UTC/GMT -04:00', NULL, NULL),
(139, 'America/Marigot', 'UTC/GMT -04:00', NULL, NULL),
(140, 'America/Martinique', 'UTC/GMT -04:00', NULL, NULL),
(141, 'America/Matamoros', 'UTC/GMT -05:00', NULL, NULL),
(142, 'America/Mazatlan', 'UTC/GMT -06:00', NULL, NULL),
(143, 'America/Menominee', 'UTC/GMT -05:00', NULL, NULL),
(144, 'America/Merida', 'UTC/GMT -05:00', NULL, NULL),
(145, 'America/Metlakatla', 'UTC/GMT -08:00', NULL, NULL),
(146, 'America/Mexico_City', 'UTC/GMT -05:00', NULL, NULL),
(147, 'America/Miquelon', 'UTC/GMT -02:00', NULL, NULL),
(148, 'America/Moncton', 'UTC/GMT -03:00', NULL, NULL),
(149, 'America/Monterrey', 'UTC/GMT -05:00', NULL, NULL),
(150, 'America/Montevideo', 'UTC/GMT -03:00', NULL, NULL),
(151, 'America/Montserrat', 'UTC/GMT -04:00', NULL, NULL),
(152, 'America/Nassau', 'UTC/GMT -04:00', NULL, NULL),
(153, 'America/New_York', 'UTC/GMT -04:00', NULL, NULL),
(154, 'America/Nipigon', 'UTC/GMT -04:00', NULL, NULL),
(155, 'America/Nome', 'UTC/GMT -08:00', NULL, NULL),
(156, 'America/Noronha', 'UTC/GMT -02:00', NULL, NULL),
(157, 'America/North_Dakota/Beulah', 'UTC/GMT -05:00', NULL, NULL),
(158, 'America/North_Dakota/Center', 'UTC/GMT -05:00', NULL, NULL),
(159, 'America/North_Dakota/New_Salem', 'UTC/GMT -05:00', NULL, NULL),
(160, 'America/Ojinaga', 'UTC/GMT -06:00', NULL, NULL),
(161, 'America/Panama', 'UTC/GMT -05:00', NULL, NULL),
(162, 'America/Pangnirtung', 'UTC/GMT -04:00', NULL, NULL),
(163, 'America/Paramaribo', 'UTC/GMT -03:00', NULL, NULL),
(164, 'America/Phoenix', 'UTC/GMT -07:00', NULL, NULL),
(165, 'America/Port-au-Prince', 'UTC/GMT -04:00', NULL, NULL),
(166, 'America/Port_of_Spain', 'UTC/GMT -04:00', NULL, NULL),
(167, 'America/Porto_Velho', 'UTC/GMT -04:00', NULL, NULL),
(168, 'America/Puerto_Rico', 'UTC/GMT -04:00', NULL, NULL),
(169, 'America/Punta_Arenas', 'UTC/GMT -03:00', NULL, NULL),
(170, 'America/Rainy_River', 'UTC/GMT -05:00', NULL, NULL),
(171, 'America/Rankin_Inlet', 'UTC/GMT -05:00', NULL, NULL),
(172, 'America/Recife', 'UTC/GMT -03:00', NULL, NULL),
(173, 'America/Regina', 'UTC/GMT -06:00', NULL, NULL),
(174, 'America/Resolute', 'UTC/GMT -05:00', NULL, NULL),
(175, 'America/Rio_Branco', 'UTC/GMT -05:00', NULL, NULL),
(176, 'America/Santarem', 'UTC/GMT -03:00', NULL, NULL),
(177, 'America/Santiago', 'UTC/GMT -03:00', NULL, NULL),
(178, 'America/Santo_Domingo', 'UTC/GMT -04:00', NULL, NULL),
(179, 'America/Sao_Paulo', 'UTC/GMT -03:00', NULL, NULL),
(180, 'America/Scoresbysund', 'UTC/GMT +00:00', NULL, NULL),
(181, 'America/Sitka', 'UTC/GMT -08:00', NULL, NULL),
(182, 'America/St_Barthelemy', 'UTC/GMT -04:00', NULL, NULL),
(183, 'America/St_Johns', 'UTC/GMT -02:30', NULL, NULL),
(184, 'America/St_Kitts', 'UTC/GMT -04:00', NULL, NULL),
(185, 'America/St_Lucia', 'UTC/GMT -04:00', NULL, NULL),
(186, 'America/St_Thomas', 'UTC/GMT -04:00', NULL, NULL),
(187, 'America/St_Vincent', 'UTC/GMT -04:00', NULL, NULL),
(188, 'America/Swift_Current', 'UTC/GMT -06:00', NULL, NULL),
(189, 'America/Tegucigalpa', 'UTC/GMT -06:00', NULL, NULL),
(190, 'America/Thule', 'UTC/GMT -03:00', NULL, NULL),
(191, 'America/Thunder_Bay', 'UTC/GMT -04:00', NULL, NULL),
(192, 'America/Tijuana', 'UTC/GMT -07:00', NULL, NULL),
(193, 'America/Toronto', 'UTC/GMT -04:00', NULL, NULL),
(194, 'America/Tortola', 'UTC/GMT -04:00', NULL, NULL),
(195, 'America/Vancouver', 'UTC/GMT -07:00', NULL, NULL),
(196, 'America/Whitehorse', 'UTC/GMT -07:00', NULL, NULL),
(197, 'America/Winnipeg', 'UTC/GMT -05:00', NULL, NULL),
(198, 'America/Yakutat', 'UTC/GMT -08:00', NULL, NULL),
(199, 'America/Yellowknife', 'UTC/GMT -06:00', NULL, NULL),
(200, 'Antarctica/Casey', 'UTC/GMT +08:00', NULL, NULL),
(201, 'Antarctica/Davis', 'UTC/GMT +07:00', NULL, NULL),
(202, 'Antarctica/DumontDUrville', 'UTC/GMT +10:00', NULL, NULL),
(203, 'Antarctica/Macquarie', 'UTC/GMT +11:00', NULL, NULL),
(204, 'Antarctica/Mawson', 'UTC/GMT +05:00', NULL, NULL),
(205, 'Antarctica/McMurdo', 'UTC/GMT +12:00', NULL, NULL),
(206, 'Antarctica/Palmer', 'UTC/GMT -03:00', NULL, NULL),
(207, 'Antarctica/Rothera', 'UTC/GMT -03:00', NULL, NULL),
(208, 'Antarctica/Syowa', 'UTC/GMT +03:00', NULL, NULL),
(209, 'Antarctica/Troll', 'UTC/GMT +02:00', NULL, NULL),
(210, 'Antarctica/Vostok', 'UTC/GMT +06:00', NULL, NULL),
(211, 'Arctic/Longyearbyen', 'UTC/GMT +02:00', NULL, NULL),
(212, 'Asia/Aden', 'UTC/GMT +03:00', NULL, NULL),
(213, 'Asia/Almaty', 'UTC/GMT +06:00', NULL, NULL),
(214, 'Asia/Amman', 'UTC/GMT +03:00', NULL, NULL),
(215, 'Asia/Anadyr', 'UTC/GMT +12:00', NULL, NULL),
(216, 'Asia/Aqtau', 'UTC/GMT +05:00', NULL, NULL),
(217, 'Asia/Aqtobe', 'UTC/GMT +05:00', NULL, NULL),
(218, 'Asia/Ashgabat', 'UTC/GMT +05:00', NULL, NULL),
(219, 'Asia/Atyrau', 'UTC/GMT +05:00', NULL, NULL),
(220, 'Asia/Baghdad', 'UTC/GMT +03:00', NULL, NULL),
(221, 'Asia/Bahrain', 'UTC/GMT +03:00', NULL, NULL),
(222, 'Asia/Baku', 'UTC/GMT +04:00', NULL, NULL),
(223, 'Asia/Bangkok', 'UTC/GMT +07:00', NULL, NULL),
(224, 'Asia/Barnaul', 'UTC/GMT +07:00', NULL, NULL),
(225, 'Asia/Beirut', 'UTC/GMT +03:00', NULL, NULL),
(226, 'Asia/Bishkek', 'UTC/GMT +06:00', NULL, NULL),
(227, 'Asia/Brunei', 'UTC/GMT +08:00', NULL, NULL),
(228, 'Asia/Chita', 'UTC/GMT +09:00', NULL, NULL),
(229, 'Asia/Choibalsan', 'UTC/GMT +08:00', NULL, NULL),
(230, 'Asia/Colombo', 'UTC/GMT +05:30', NULL, NULL),
(231, 'Asia/Damascus', 'UTC/GMT +03:00', NULL, NULL),
(232, 'Asia/Dhaka', 'UTC/GMT +06:00', NULL, NULL),
(233, 'Asia/Dili', 'UTC/GMT +09:00', NULL, NULL),
(234, 'Asia/Dubai', 'UTC/GMT +04:00', NULL, NULL),
(235, 'Asia/Dushanbe', 'UTC/GMT +05:00', NULL, NULL),
(236, 'Asia/Famagusta', 'UTC/GMT +03:00', NULL, NULL),
(237, 'Asia/Gaza', 'UTC/GMT +03:00', NULL, NULL),
(238, 'Asia/Hebron', 'UTC/GMT +03:00', NULL, NULL),
(239, 'Asia/Ho_Chi_Minh', 'UTC/GMT +07:00', NULL, NULL),
(240, 'Asia/Hong_Kong', 'UTC/GMT +08:00', NULL, NULL),
(241, 'Asia/Hovd', 'UTC/GMT +07:00', NULL, NULL),
(242, 'Asia/Irkutsk', 'UTC/GMT +08:00', NULL, NULL),
(243, 'Asia/Jakarta', 'UTC/GMT +07:00', NULL, NULL),
(244, 'Asia/Jayapura', 'UTC/GMT +09:00', NULL, NULL),
(245, 'Asia/Jerusalem', 'UTC/GMT +03:00', NULL, NULL),
(246, 'Asia/Kabul', 'UTC/GMT +04:30', NULL, NULL),
(247, 'Asia/Kamchatka', 'UTC/GMT +12:00', NULL, NULL),
(248, 'Asia/Karachi', 'UTC/GMT +05:00', NULL, NULL),
(249, 'Asia/Kathmandu', 'UTC/GMT +05:45', NULL, NULL),
(250, 'Asia/Khandyga', 'UTC/GMT +09:00', NULL, NULL),
(251, 'Asia/Kolkata', 'UTC/GMT +05:30', NULL, NULL),
(252, 'Asia/Krasnoyarsk', 'UTC/GMT +07:00', NULL, NULL),
(253, 'Asia/Kuala_Lumpur', 'UTC/GMT +08:00', NULL, NULL),
(254, 'Asia/Kuching', 'UTC/GMT +08:00', NULL, NULL),
(255, 'Asia/Kuwait', 'UTC/GMT +03:00', NULL, NULL),
(256, 'Asia/Macau', 'UTC/GMT +08:00', NULL, NULL),
(257, 'Asia/Magadan', 'UTC/GMT +11:00', NULL, NULL),
(258, 'Asia/Makassar', 'UTC/GMT +08:00', NULL, NULL),
(259, 'Asia/Manila', 'UTC/GMT +08:00', NULL, NULL),
(260, 'Asia/Muscat', 'UTC/GMT +04:00', NULL, NULL),
(261, 'Asia/Nicosia', 'UTC/GMT +03:00', NULL, NULL),
(262, 'Asia/Novokuznetsk', 'UTC/GMT +07:00', NULL, NULL),
(263, 'Asia/Novosibirsk', 'UTC/GMT +07:00', NULL, NULL),
(264, 'Asia/Omsk', 'UTC/GMT +06:00', NULL, NULL),
(265, 'Asia/Oral', 'UTC/GMT +05:00', NULL, NULL),
(266, 'Asia/Phnom_Penh', 'UTC/GMT +07:00', NULL, NULL),
(267, 'Asia/Pontianak', 'UTC/GMT +07:00', NULL, NULL),
(268, 'Asia/Pyongyang', 'UTC/GMT +08:30', NULL, NULL),
(269, 'Asia/Qatar', 'UTC/GMT +03:00', NULL, NULL),
(270, 'Asia/Qyzylorda', 'UTC/GMT +06:00', NULL, NULL),
(271, 'Asia/Riyadh', 'UTC/GMT +03:00', NULL, NULL),
(272, 'Asia/Sakhalin', 'UTC/GMT +11:00', NULL, NULL),
(273, 'Asia/Samarkand', 'UTC/GMT +05:00', NULL, NULL),
(274, 'Asia/Seoul', 'UTC/GMT +09:00', NULL, NULL),
(275, 'Asia/Shanghai', 'UTC/GMT +08:00', NULL, NULL),
(276, 'Asia/Singapore', 'UTC/GMT +08:00', NULL, NULL),
(277, 'Asia/Srednekolymsk', 'UTC/GMT +11:00', NULL, NULL),
(278, 'Asia/Taipei', 'UTC/GMT +08:00', NULL, NULL),
(279, 'Asia/Tashkent', 'UTC/GMT +05:00', NULL, NULL),
(280, 'Asia/Tbilisi', 'UTC/GMT +04:00', NULL, NULL),
(281, 'Asia/Tehran', 'UTC/GMT +04:30', NULL, NULL),
(282, 'Asia/Thimphu', 'UTC/GMT +06:00', NULL, NULL),
(283, 'Asia/Tokyo', 'UTC/GMT +09:00', NULL, NULL),
(284, 'Asia/Tomsk', 'UTC/GMT +07:00', NULL, NULL),
(285, 'Asia/Ulaanbaatar', 'UTC/GMT +08:00', NULL, NULL),
(286, 'Asia/Urumqi', 'UTC/GMT +06:00', NULL, NULL),
(287, 'Asia/Ust-Nera', 'UTC/GMT +10:00', NULL, NULL),
(288, 'Asia/Vientiane', 'UTC/GMT +07:00', NULL, NULL),
(289, 'Asia/Vladivostok', 'UTC/GMT +10:00', NULL, NULL),
(290, 'Asia/Yakutsk', 'UTC/GMT +09:00', NULL, NULL),
(291, 'Asia/Yangon', 'UTC/GMT +06:30', NULL, NULL),
(292, 'Asia/Yekaterinburg', 'UTC/GMT +05:00', NULL, NULL),
(293, 'Asia/Yerevan', 'UTC/GMT +04:00', NULL, NULL),
(294, 'Atlantic/Azores', 'UTC/GMT +00:00', NULL, NULL),
(295, 'Atlantic/Bermuda', 'UTC/GMT -03:00', NULL, NULL),
(296, 'Atlantic/Canary', 'UTC/GMT +01:00', NULL, NULL),
(297, 'Atlantic/Cape_Verde', 'UTC/GMT -01:00', NULL, NULL),
(298, 'Atlantic/Faroe', 'UTC/GMT +01:00', NULL, NULL),
(299, 'Atlantic/Madeira', 'UTC/GMT +01:00', NULL, NULL),
(300, 'Atlantic/Reykjavik', 'UTC/GMT +00:00', NULL, NULL),
(301, 'Atlantic/South_Georgia', 'UTC/GMT -02:00', NULL, NULL),
(302, 'Atlantic/St_Helena', 'UTC/GMT +00:00', NULL, NULL),
(303, 'Atlantic/Stanley', 'UTC/GMT -03:00', NULL, NULL),
(304, 'Australia/Adelaide', 'UTC/GMT +09:30', NULL, NULL),
(305, 'Australia/Brisbane', 'UTC/GMT +10:00', NULL, NULL),
(306, 'Australia/Broken_Hill', 'UTC/GMT +09:30', NULL, NULL),
(307, 'Australia/Currie', 'UTC/GMT +10:00', NULL, NULL),
(308, 'Australia/Darwin', 'UTC/GMT +09:30', NULL, NULL),
(309, 'Australia/Eucla', 'UTC/GMT +08:45', NULL, NULL),
(310, 'Australia/Hobart', 'UTC/GMT +10:00', NULL, NULL),
(311, 'Australia/Lindeman', 'UTC/GMT +10:00', NULL, NULL),
(312, 'Australia/Lord_Howe', 'UTC/GMT +10:30', NULL, NULL),
(313, 'Australia/Melbourne', 'UTC/GMT +10:00', NULL, NULL),
(314, 'Australia/Perth', 'UTC/GMT +08:00', NULL, NULL),
(315, 'Australia/Sydney', 'UTC/GMT +10:00', NULL, NULL),
(316, 'Europe/Amsterdam', 'UTC/GMT +02:00', NULL, NULL),
(317, 'Europe/Andorra', 'UTC/GMT +02:00', NULL, NULL),
(318, 'Europe/Astrakhan', 'UTC/GMT +04:00', NULL, NULL),
(319, 'Europe/Athens', 'UTC/GMT +03:00', NULL, NULL),
(320, 'Europe/Belgrade', 'UTC/GMT +02:00', NULL, NULL),
(321, 'Europe/Berlin', 'UTC/GMT +02:00', NULL, NULL),
(322, 'Europe/Bratislava', 'UTC/GMT +02:00', NULL, NULL),
(323, 'Europe/Brussels', 'UTC/GMT +02:00', NULL, NULL),
(324, 'Europe/Bucharest', 'UTC/GMT +03:00', NULL, NULL),
(325, 'Europe/Budapest', 'UTC/GMT +02:00', NULL, NULL),
(326, 'Europe/Busingen', 'UTC/GMT +02:00', NULL, NULL),
(327, 'Europe/Chisinau', 'UTC/GMT +03:00', NULL, NULL),
(328, 'Europe/Copenhagen', 'UTC/GMT +02:00', NULL, NULL),
(329, 'Europe/Dublin', 'UTC/GMT +01:00', NULL, NULL),
(330, 'Europe/Gibraltar', 'UTC/GMT +02:00', NULL, NULL),
(331, 'Europe/Guernsey', 'UTC/GMT +01:00', NULL, NULL),
(332, 'Europe/Helsinki', 'UTC/GMT +03:00', NULL, NULL),
(333, 'Europe/Isle_of_Man', 'UTC/GMT +01:00', NULL, NULL),
(334, 'Europe/Istanbul', 'UTC/GMT +03:00', NULL, NULL),
(335, 'Europe/Jersey', 'UTC/GMT +01:00', NULL, NULL),
(336, 'Europe/Kaliningrad', 'UTC/GMT +02:00', NULL, NULL),
(337, 'Europe/Kiev', 'UTC/GMT +03:00', NULL, NULL),
(338, 'Europe/Kirov', 'UTC/GMT +03:00', NULL, NULL),
(339, 'Europe/Lisbon', 'UTC/GMT +01:00', NULL, NULL),
(340, 'Europe/Ljubljana', 'UTC/GMT +02:00', NULL, NULL),
(341, 'Europe/London', 'UTC/GMT +01:00', NULL, NULL),
(342, 'Europe/Luxembourg', 'UTC/GMT +02:00', NULL, NULL),
(343, 'Europe/Madrid', 'UTC/GMT +02:00', NULL, NULL),
(344, 'Europe/Malta', 'UTC/GMT +02:00', NULL, NULL),
(345, 'Europe/Mariehamn', 'UTC/GMT +03:00', NULL, NULL),
(346, 'Europe/Minsk', 'UTC/GMT +03:00', NULL, NULL),
(347, 'Europe/Monaco', 'UTC/GMT +02:00', NULL, NULL),
(348, 'Europe/Moscow', 'UTC/GMT +03:00', NULL, NULL),
(349, 'Europe/Oslo', 'UTC/GMT +02:00', NULL, NULL),
(350, 'Europe/Paris', 'UTC/GMT +02:00', NULL, NULL),
(351, 'Europe/Podgorica', 'UTC/GMT +02:00', NULL, NULL),
(352, 'Europe/Prague', 'UTC/GMT +02:00', NULL, NULL),
(353, 'Europe/Riga', 'UTC/GMT +03:00', NULL, NULL),
(354, 'Europe/Rome', 'UTC/GMT +02:00', NULL, NULL),
(355, 'Europe/Samara', 'UTC/GMT +04:00', NULL, NULL),
(356, 'Europe/San_Marino', 'UTC/GMT +02:00', NULL, NULL),
(357, 'Europe/Sarajevo', 'UTC/GMT +02:00', NULL, NULL),
(358, 'Europe/Saratov', 'UTC/GMT +04:00', NULL, NULL),
(359, 'Europe/Simferopol', 'UTC/GMT +03:00', NULL, NULL),
(360, 'Europe/Skopje', 'UTC/GMT +02:00', NULL, NULL),
(361, 'Europe/Sofia', 'UTC/GMT +03:00', NULL, NULL),
(362, 'Europe/Stockholm', 'UTC/GMT +02:00', NULL, NULL),
(363, 'Europe/Tallinn', 'UTC/GMT +03:00', NULL, NULL),
(364, 'Europe/Tirane', 'UTC/GMT +02:00', NULL, NULL),
(365, 'Europe/Ulyanovsk', 'UTC/GMT +04:00', NULL, NULL),
(366, 'Europe/Uzhgorod', 'UTC/GMT +03:00', NULL, NULL),
(367, 'Europe/Vaduz', 'UTC/GMT +02:00', NULL, NULL),
(368, 'Europe/Vatican', 'UTC/GMT +02:00', NULL, NULL),
(369, 'Europe/Vienna', 'UTC/GMT +02:00', NULL, NULL),
(370, 'Europe/Vilnius', 'UTC/GMT +03:00', NULL, NULL),
(371, 'Europe/Volgograd', 'UTC/GMT +03:00', NULL, NULL),
(372, 'Europe/Warsaw', 'UTC/GMT +02:00', NULL, NULL),
(373, 'Europe/Zagreb', 'UTC/GMT +02:00', NULL, NULL),
(374, 'Europe/Zaporozhye', 'UTC/GMT +03:00', NULL, NULL),
(375, 'Europe/Zurich', 'UTC/GMT +02:00', NULL, NULL),
(376, 'Indian/Antananarivo', 'UTC/GMT +03:00', NULL, NULL),
(377, 'Indian/Chagos', 'UTC/GMT +06:00', NULL, NULL),
(378, 'Indian/Christmas', 'UTC/GMT +07:00', NULL, NULL),
(379, 'Indian/Cocos', 'UTC/GMT +06:30', NULL, NULL),
(380, 'Indian/Comoro', 'UTC/GMT +03:00', NULL, NULL),
(381, 'Indian/Kerguelen', 'UTC/GMT +05:00', NULL, NULL),
(382, 'Indian/Mahe', 'UTC/GMT +04:00', NULL, NULL),
(383, 'Indian/Maldives', 'UTC/GMT +05:00', NULL, NULL),
(384, 'Indian/Mauritius', 'UTC/GMT +04:00', NULL, NULL),
(385, 'Indian/Mayotte', 'UTC/GMT +03:00', NULL, NULL),
(386, 'Indian/Reunion', 'UTC/GMT +04:00', NULL, NULL),
(387, 'Pacific/Apia', 'UTC/GMT +13:00', NULL, NULL),
(388, 'Pacific/Auckland', 'UTC/GMT +12:00', NULL, NULL),
(389, 'Pacific/Bougainville', 'UTC/GMT +11:00', NULL, NULL),
(390, 'Pacific/Chatham', 'UTC/GMT +12:45', NULL, NULL),
(391, 'Pacific/Chuuk', 'UTC/GMT +10:00', NULL, NULL),
(392, 'Pacific/Easter', 'UTC/GMT -05:00', NULL, NULL),
(393, 'Pacific/Efate', 'UTC/GMT +11:00', NULL, NULL),
(394, 'Pacific/Enderbury', 'UTC/GMT +13:00', NULL, NULL),
(395, 'Pacific/Fakaofo', 'UTC/GMT +13:00', NULL, NULL),
(396, 'Pacific/Fiji', 'UTC/GMT +12:00', NULL, NULL),
(397, 'Pacific/Funafuti', 'UTC/GMT +12:00', NULL, NULL),
(398, 'Pacific/Galapagos', 'UTC/GMT -06:00', NULL, NULL),
(399, 'Pacific/Gambier', 'UTC/GMT -09:00', NULL, NULL),
(400, 'Pacific/Guadalcanal', 'UTC/GMT +11:00', NULL, NULL),
(401, 'Pacific/Guam', 'UTC/GMT +10:00', NULL, NULL),
(402, 'Pacific/Honolulu', 'UTC/GMT -10:00', NULL, NULL),
(403, 'Pacific/Kiritimati', 'UTC/GMT +14:00', NULL, NULL),
(404, 'Pacific/Kosrae', 'UTC/GMT +11:00', NULL, NULL),
(405, 'Pacific/Kwajalein', 'UTC/GMT +12:00', NULL, NULL),
(406, 'Pacific/Majuro', 'UTC/GMT +12:00', NULL, NULL),
(407, 'Pacific/Marquesas', 'UTC/GMT -09:30', NULL, NULL),
(408, 'Pacific/Midway', 'UTC/GMT -11:00', NULL, NULL),
(409, 'Pacific/Nauru', 'UTC/GMT +12:00', NULL, NULL),
(410, 'Pacific/Niue', 'UTC/GMT -11:00', NULL, NULL),
(411, 'Pacific/Norfolk', 'UTC/GMT +11:00', NULL, NULL),
(412, 'Pacific/Noumea', 'UTC/GMT +11:00', NULL, NULL),
(413, 'Pacific/Pago_Pago', 'UTC/GMT -11:00', NULL, NULL),
(414, 'Pacific/Palau', 'UTC/GMT +09:00', NULL, NULL),
(415, 'Pacific/Pitcairn', 'UTC/GMT -08:00', NULL, NULL),
(416, 'Pacific/Pohnpei', 'UTC/GMT +11:00', NULL, NULL),
(417, 'Pacific/Port_Moresby', 'UTC/GMT +10:00', NULL, NULL),
(418, 'Pacific/Rarotonga', 'UTC/GMT -10:00', NULL, NULL),
(419, 'Pacific/Saipan', 'UTC/GMT +10:00', NULL, NULL),
(420, 'Pacific/Tahiti', 'UTC/GMT -10:00', NULL, NULL),
(421, 'Pacific/Tarawa', 'UTC/GMT +12:00', NULL, NULL),
(422, 'Pacific/Tongatapu', 'UTC/GMT +13:00', NULL, NULL),
(423, 'Pacific/Wake', 'UTC/GMT +12:00', NULL, NULL),
(424, 'Pacific/Wallis', 'UTC/GMT +12:00', NULL, NULL),
(425, 'UTC', 'UTC/GMT +00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `end_user_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `merchant_id` int UNSIGNED DEFAULT NULL,
  `bank_id` int UNSIGNED DEFAULT NULL,
  `file_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID',
  `refund_reference` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Refund Reference',
  `transaction_reference_id` int NOT NULL DEFAULT '0',
  `transaction_type_id` int UNSIGNED DEFAULT NULL,
  `user_type` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'registered' COMMENT 'registered, unregistered',
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(20,8) DEFAULT '0.00000000',
  `percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_fixed` decimal(20,8) DEFAULT '0.00000000',
  `total` decimal(20,8) DEFAULT '0.00000000',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Pending, Success, Blocked',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_transaction_type_id_foreign` (`transaction_type_id`),
  KEY `transactions_user_id_index` (`user_id`),
  KEY `transactions_end_user_id_index` (`end_user_id`),
  KEY `transactions_currency_id_index` (`currency_id`),
  KEY `transactions_payment_method_id_index` (`payment_method_id`),
  KEY `transactions_merchant_id_index` (`merchant_id`),
  KEY `transactions_bank_id_index` (`bank_id`),
  KEY `transactions_file_id_index` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `name`) VALUES
(1, 'Deposit'),
(2, 'Withdrawal'),
(3, 'Transferred'),
(4, 'Received'),
(5, 'Exchange_From'),
(6, 'Exchange_To'),
(7, 'Request_Sent'),
(8, 'Request_Received'),
(9, 'Payment_Sent'),
(10, 'Payment_Received');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` int UNSIGNED DEFAULT NULL,
  `receiver_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `bank_id` int UNSIGNED DEFAULT NULL,
  `file_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID (For Each Transfer)',
  `fee` decimal(20,8) DEFAULT '0.00000000',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_sender_id_index` (`sender_id`),
  KEY `transfers_receiver_id_index` (`receiver_id`),
  KEY `transfers_currency_id_index` (`currency_id`),
  KEY `transfers_bank_id_index` (`bank_id`),
  KEY `transfers_file_id_index` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED DEFAULT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user' COMMENT 'user or merchant',
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `formattedPhone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `defaultCountry` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrierCode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phrase` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_verified` tinyint(1) NOT NULL DEFAULT '0',
  `identity_verified` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Active, Inactive, Suspended',
  `picture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_role_id_index` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `type`, `first_name`, `last_name`, `formattedPhone`, `phone`, `google2fa_secret`, `defaultCountry`, `carrierCode`, `email`, `password`, `phrase`, `address_verified`, `identity_verified`, `status`, `picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 2, 'user', 'Flow', 'Check', NULL, NULL, NULL, NULL, NULL, 'flowcheck.8001@example.com', '$2y$10$RnakKbfAVy8k4sY3DdIdtuu4TZ1RHdgIlGno4FzFGOGpTV751UtEC', NULL, 0, 0, 'Active', '', NULL, '2026-09-30 12:00:08', '2026-09-30 12:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `country_id` int UNSIGNED NOT NULL,
  `email_verification` tinyint(1) NOT NULL DEFAULT '0',
  `phone_verification_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_step_verification_type` varchar(21) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disabled' COMMENT 'disabled, email, phone, google_authenticator',
  `two_step_verification_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_step_verification` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `address_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `default_currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'individual, proprietorship, partnership',
  `kyc_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, in_review, approved, rejected',
  `kyc_submitted_at` timestamp NULL DEFAULT NULL,
  `kyc_reviewed_at` timestamp NULL DEFAULT NULL,
  `kyc_rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_submit_count` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of times user has submitted KYC for verification (max 3)',
  `business_registration_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_business_registration_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_business_registration_other_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_signatory_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_signatory_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_signatory_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_bank_account_holder_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_bank_account_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_bank_ifsc_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_details_user_id_index` (`user_id`),
  KEY `user_details_country_id_index` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `country_id`, `email_verification`, `phone_verification_code`, `two_step_verification_type`, `two_step_verification_code`, `two_step_verification`, `last_login_at`, `last_login_ip`, `city`, `state`, `address_1`, `address_2`, `default_currency`, `timezone`, `merchant_category`, `kyc_status`, `kyc_submitted_at`, `kyc_reviewed_at`, `kyc_rejection_reason`, `kyc_submit_count`, `business_registration_type`, `kyc_business_registration_number`, `kyc_business_registration_other_name`, `kyc_signatory_name`, `kyc_signatory_phone`, `kyc_signatory_email`, `kyc_bank_name`, `kyc_bank_account_holder_name`, `kyc_bank_account_number`, `kyc_bank_ifsc_code`) VALUES
(1, 1, 226, 0, NULL, 'disabled', NULL, 0, '2026-09-30 12:12:10', '127.0.0.1', NULL, NULL, NULL, NULL, '1', 'Asia/Dhaka', 'partnership', 'pending', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_products`
--

DROP TABLE IF EXISTS `user_products`;
CREATE TABLE IF NOT EXISTS `user_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, activated, rejected',
  `requested_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_products_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `user_products_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verification_logs`
--

DROP TABLE IF EXISTS `verification_logs`;
CREATE TABLE IF NOT EXISTS `verification_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier_masked` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_ref` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `api_response_summary` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_logs_user_id_index` (`user_id`),
  KEY `verification_logs_type_index` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verify_users`
--

DROP TABLE IF EXISTS `verify_users`;
CREATE TABLE IF NOT EXISTS `verify_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verify_users_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcards`
--

DROP TABLE IF EXISTS `virtualcards`;
CREATE TABLE IF NOT EXISTS `virtualcards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_provider_id` bigint UNSIGNED DEFAULT NULL,
  `virtualcard_category_id` bigint UNSIGNED NOT NULL,
  `virtualcard_holder_id` bigint UNSIGNED NOT NULL,
  `card_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Virtual',
  `card_brand` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Visa, Mastercard',
  `card_number` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_cvc` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `expiry_month` int DEFAULT NULL,
  `expiry_year` int DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Active, Inactive, Pending, Freeze, Terminate, Expired',
  `api_card_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Provider card id',
  `api_card_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Provider card response',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcards_virtualcard_provider_id_foreign` (`virtualcard_provider_id`),
  KEY `virtualcards_virtualcard_category_id_foreign` (`virtualcard_category_id`),
  KEY `virtualcards_virtualcard_holder_id_foreign` (`virtualcard_holder_id`),
  KEY `virtualcards_card_brand_idx` (`card_brand`),
  KEY `virtualcards_currency_code_idx` (`currency_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_categories`
--

DROP TABLE IF EXISTS `virtualcard_categories`;
CREATE TABLE IF NOT EXISTS `virtualcard_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_feeslimits`
--

DROP TABLE IF EXISTS `virtualcard_feeslimits`;
CREATE TABLE IF NOT EXISTS `virtualcard_feeslimits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_provider_id` bigint UNSIGNED NOT NULL,
  `virtualcard_currency_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_creation_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `topup_percentage_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `topup_fixed_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `topup_min_limit` decimal(20,8) DEFAULT NULL,
  `topup_max_limit` decimal(20,8) DEFAULT NULL,
  `withdrawal_percentage_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `withdrawal_fixed_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `withdrawal_min_limit` decimal(20,8) DEFAULT NULL,
  `withdrawal_max_limit` decimal(20,8) DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider_currency_unique` (`virtualcard_provider_id`,`virtualcard_currency_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_holders`
--

DROP TABLE IF EXISTS `virtualcard_holders`;
CREATE TABLE IF NOT EXISTS `virtualcard_holders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `virtualcard_provider_id` bigint UNSIGNED DEFAULT NULL,
  `card_holder_type` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Individual' COMMENT 'Individual or Business',
  `business_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `date_of_birth` date DEFAULT NULL,
  `verification_document_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual. Passport, NID, Driving License',
  `verification_document_id_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `verification_document_image_front` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `verification_document_image_back` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `first_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `last_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'required if card_holder_type is individual',
  `country` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending,Approved,Rejected',
  `api_holder_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Provider holder id',
  `api_holder_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'provider holder response',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_holders_user_id_foreign` (`user_id`),
  KEY `virtualcard_holders_virtualcard_provider_id_foreign` (`virtualcard_provider_id`),
  KEY `virtualcard_holders_card_holder_type_idx` (`card_holder_type`),
  KEY `virtualcard_holders_country_idx` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_providers`
--

DROP TABLE IF EXISTS `virtualcard_providers`;
CREATE TABLE IF NOT EXISTS `virtualcard_providers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` json NOT NULL,
  `type` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Manual' COMMENT 'Automated, Manual',
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `virtualcard_providers_name_unique` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_spendings`
--

DROP TABLE IF EXISTS `virtualcard_spendings`;
CREATE TABLE IF NOT EXISTS `virtualcard_spendings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_spendings_virtualcard_id_foreign` (`virtualcard_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_spending_controls`
--

DROP TABLE IF EXISTS `virtualcard_spending_controls`;
CREATE TABLE IF NOT EXISTS `virtualcard_spending_controls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_id` bigint UNSIGNED NOT NULL,
  `interval` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'per_transaction, daily, weekly, monthly, yearly, all_time',
  `amount` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  `spent` decimal(20,8) DEFAULT '0.00000000',
  `allowed_categories` json DEFAULT NULL,
  `blocked_categories` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_spending_controls_virtualcard_id_foreign` (`virtualcard_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_topups`
--

DROP TABLE IF EXISTS `virtualcard_topups`;
CREATE TABLE IF NOT EXISTS `virtualcard_topups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `requested_fund` decimal(20,8) NOT NULL,
  `percentage` decimal(20,8) DEFAULT NULL,
  `percentage_fees` decimal(20,8) DEFAULT NULL,
  `fixed_fees` decimal(20,8) DEFAULT NULL,
  `fund_request_time` timestamp NULL DEFAULT NULL,
  `fund_approval_status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Approved, Cancelled',
  `cancellation_reason` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_topups_virtualcard_id_foreign` (`virtualcard_id`),
  KEY `virtualcard_topups_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_transactions`
--

DROP TABLE IF EXISTS `virtualcard_transactions`;
CREATE TABLE IF NOT EXISTS `virtualcard_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `amount` decimal(20,8) NOT NULL,
  `merchant_amount` decimal(20,8) DEFAULT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_fees` decimal(20,8) DEFAULT NULL,
  `card_number` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(91) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'webhook response',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_transactions_virtualcard_id_foreign` (`virtualcard_id`),
  KEY `virtualcard_transactions_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtualcard_withdrawals`
--

DROP TABLE IF EXISTS `virtualcard_withdrawals`;
CREATE TABLE IF NOT EXISTS `virtualcard_withdrawals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtualcard_id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `requested_fund` decimal(20,8) NOT NULL,
  `percentage` decimal(20,8) DEFAULT NULL,
  `percentage_fees` decimal(20,8) DEFAULT NULL,
  `fixed_fees` decimal(20,8) DEFAULT NULL,
  `fund_request_time` timestamp NULL DEFAULT NULL,
  `fund_release_time` timestamp NULL DEFAULT NULL,
  `fund_approval_status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Approved, Cancelled',
  `cancellation_reason` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virtualcard_withdrawals_virtualcard_id_foreign` (`virtualcard_id`),
  KEY `virtualcard_withdrawals_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `balance` decimal(20,8) DEFAULT '0.00000000',
  `is_default` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No' COMMENT 'Yes, No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallets_user_id_index` (`user_id`),
  KEY `wallets_currency_id_index` (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `currency_id`, `balance`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0.00000000', 'Yes', '2026-09-30 12:00:08', '2026-09-30 12:00:08'),
(2, 1, 2, '0.00000000', 'No', '2026-09-30 12:00:08', '2026-09-30 12:00:08'),
(3, 1, 3, '0.00000000', 'No', '2026-09-30 12:00:08', '2026-09-30 12:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
CREATE TABLE IF NOT EXISTS `withdrawals` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `currency_id` int UNSIGNED DEFAULT NULL,
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `uuid` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique ID (For Each Withdrawal)',
  `charge_percentage` decimal(20,8) DEFAULT '0.00000000',
  `charge_fixed` decimal(20,8) DEFAULT '0.00000000',
  `subtotal` decimal(20,8) DEFAULT '0.00000000',
  `amount` decimal(20,8) DEFAULT '0.00000000',
  `payment_method_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Success, Refund, Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withdrawals_user_id_index` (`user_id`),
  KEY `withdrawals_currency_id_index` (`currency_id`),
  KEY `withdrawals_payment_method_id_index` (`payment_method_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_details`
--

DROP TABLE IF EXISTS `withdrawal_details`;
CREATE TABLE IF NOT EXISTS `withdrawal_details` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `withdrawal_id` int UNSIGNED DEFAULT NULL,
  `type` int NOT NULL COMMENT '2=Paypal, 5=Bank, 8=Crypto',
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` int UNSIGNED DEFAULT NULL,
  `swift_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withdrawal_details_withdrawal_id_index` (`withdrawal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
