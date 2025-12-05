-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2025 at 12:00 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `street`, `city`, `state`, `country`, `postal_code`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 6, 'asasasaSAS fgfgdg', 'sasas', 'asas', 'sasa', '2323', '1', '0', '2025-04-08 03:32:23', '2025-04-08 03:54:44'),
(2, 6, 'asas', 'sasas', 'asas', 'sasa', '2323', '1', '0', '2025-04-08 03:52:50', '2025-04-08 03:52:50'),
(3, 6, 'asas', 'sasas', 'asas', 'sasa', '2323', '1', '0', '2025-04-08 03:52:57', '2025-04-08 03:52:57'),
(4, 6, 'asasasaSAS fgfgdg', 'sasas', 'asas', 'sasa', '2323', '1', '0', '2025-04-08 06:49:23', '2025-04-08 06:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FabIndia', '1764655317_692e80d574b63.jpg', '0', '1', NULL, '2025-12-02 00:31:57'),
(2, 'Manyavar', '1744977396_68023df4c6bcf.jpg', '0', '1', NULL, NULL),
(3, 'Allen Solly', '1744977565_68023e9d2b64c.jpg', '0', '1', NULL, NULL),
(4, 'Van Heusen', '1764654186_692e7c6aad35f.png', '0', '1', NULL, '2025-12-02 00:13:06'),
(5, 'W for Woman', '1744977460_68023e348690b.jpg', '0', '1', NULL, NULL),
(6, 'Flying Machine', '1744977485_68023e4d2099b.jpg', '0', '1', NULL, NULL),
(7, 'Spykar', '1744977504_68023e6026154.jpg', '0', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `image`, `thumbnail`, `description`, `order`, `is_home`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fashion', 'fashion', 0, '1764654210.jpg', 'thumb_1764654210.jpg', NULL, NULL, '1', '0', '1', '2025-12-01 05:00:12', '2025-12-02 00:13:30'),
(2, 'Electronics', 'electronics', 0, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:00:27', '2025-12-01 05:00:27'),
(3, 'Home & Kitchen', 'home-&-kitchen', 0, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:00:37', '2025-12-01 05:00:37'),
(4, 'Books & Media', 'books-&-media', 0, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:00:48', '2025-12-01 05:00:48'),
(5, 'Beauty & Personal Care', 'beauty-&-personal-care', 0, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:00:58', '2025-12-01 05:00:58'),
(6, 'Men', 'men', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:01:26', '2025-12-01 05:01:26'),
(7, 'Women', 'women', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:01:41', '2025-12-01 05:01:41'),
(8, 'Kids', 'kids', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:01:53', '2025-12-01 05:01:53'),
(9, 'Accessories', 'accessories', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:02:44', '2025-12-01 05:02:44'),
(10, 'Winter Wear', 'winter-wear', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:02:56', '2025-12-01 05:02:56'),
(11, 'Mobiles & Accessories', 'mobiles-&-accessories', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:03:15', '2025-12-01 05:03:15'),
(12, 'Computers & Laptops', 'computers-&-laptops', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:03:23', '2025-12-01 05:03:23'),
(13, 'TV & Audio', 'tv-&-audio', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:03:34', '2025-12-01 05:03:34'),
(14, 'Cameras & Accessories', 'cameras-&-accessories', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:03:44', '2025-12-01 05:03:44'),
(15, 'Home Appliances', 'home-appliances', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:03:58', '2025-12-01 05:03:58'),
(16, 'Kitchen Essentials', 'kitchen-essentials', 3, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:04:10', '2025-12-01 05:04:10'),
(17, 'Home Décor', 'home-décor', 3, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:04:19', '2025-12-01 05:04:19'),
(18, 'Furniture', 'furniture', 3, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:04:29', '2025-12-01 05:04:29'),
(19, 'Home Improvement', 'home-improvement', 3, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:04:39', '2025-12-01 05:04:39'),
(20, 'Bedding & Bath', 'bedding-&-bath', 3, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:04:48', '2025-12-01 05:04:48'),
(21, 'Fiction', 'fiction', 4, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:00', '2025-12-01 05:05:00'),
(22, 'Non-Fiction', 'non-fiction', 4, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:09', '2025-12-01 05:05:09'),
(23, 'Children’s Books', 'children’s-books', 4, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:20', '2025-12-01 05:05:20'),
(24, 'Music & Audio', 'music-&-audio', 4, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:29', '2025-12-01 05:05:29'),
(25, 'Movies & TV', 'movies-&-tv', 4, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:40', '2025-12-01 05:05:40'),
(26, 'Makeup', 'makeup', 5, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:05:50', '2025-12-01 05:05:50'),
(27, 'Skin Care', 'skin-care', 5, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:06:02', '2025-12-01 05:06:02'),
(28, 'Hair Care', 'hair-care', 5, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:06:11', '2025-12-01 05:06:11'),
(29, 'Personal Hygiene', 'personal-hygiene', 5, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:06:21', '2025-12-01 05:06:21'),
(30, 'Fragrances', 'fragrances', 5, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 05:06:31', '2025-12-01 05:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploadfile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `uploadfile`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'File 1', '1764653561.jpg', 'This is test Remark', 1, '2025-03-07 04:55:22', '2025-12-02 00:02:41'),
(3, 'File 3', '1741345993.jpg', 'File 3 Remark', 1, '2025-03-07 05:43:13', '2025-03-07 05:43:13'),
(4, 'File 4', '1741346083.jpg', 'File 4 Remark', 1, '2025-03-07 05:44:43', '2025-03-07 05:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `file_manager`
--

DROP TABLE IF EXISTS `file_manager`;
CREATE TABLE IF NOT EXISTS `file_manager` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('folder','file','text') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `is_delete` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_manager_parent_id_foreign` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_manager`
--

INSERT INTO `file_manager` (`id`, `name`, `type`, `parent_id`, `path`, `size`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Photos', 'folder', NULL, 'uploads/file-manager/Photos/', 0, '0', '1', '2025-11-26 06:48:42', '2025-11-26 06:49:57'),
(2, 'Imges', 'folder', NULL, 'uploads/file-manager/Imges/', 0, '0', '1', '2025-11-26 06:49:43', '2025-11-26 06:50:39'),
(3, 'deASASs.png', 'file', 1, 'uploads/file-manager/Photos/', 101156, '0', '1', '2025-11-26 06:52:05', '2025-12-05 06:14:00'),
(4, 'favicon.ico', 'file', 1, 'uploads/file-manager/Photos/', 894, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(5, 'fb.png', 'file', 1, 'uploads/file-manager/Photos/', 18169, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(6, 'languge.png', 'file', 1, 'uploads/file-manager/Photos/', 1993, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(7, 'linew.png', 'file', 1, 'uploads/file-manager/Photos/', 2853, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(8, 'logo.png', 'file', 1, 'uploads/file-manager/Photos/', 6065, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(9, 'nhm.png', 'file', 1, 'uploads/file-manager/Photos/', 5462, '0', '1', '2025-11-26 06:52:05', '2025-11-26 06:52:05'),
(10, 'ADSD', 'folder', NULL, 'uploads/file-manager/ADSD/', 0, '0', '1', '2025-11-26 07:06:52', '2025-11-26 07:06:52'),
(11, 'asasas', 'folder', NULL, 'uploads/file-manager/asasas/', 0, '0', '1', '2025-11-26 07:11:16', '2025-11-26 07:11:16'),
(12, 'GHGHGH', 'folder', 1, 'uploads/file-manager/Photos/GHGHGH/', 0, '0', '1', '2025-11-26 07:14:59', '2025-11-26 07:14:59'),
(13, 'add_vhost.php', 'file', 1, 'uploads/file-manager/Photos/', 49189, '0', '1', '2025-11-26 07:20:06', '2025-11-26 07:20:06'),
(14, 'thumb_v_v_1.jpg', 'file', 12, 'uploads/file-manager/Photos/GHGHGH/', 78634, '0', '1', '2025-12-05 06:14:35', '2025-12-05 06:14:35'),
(15, 'thumb_v_v_2.jpg', 'file', 12, 'uploads/file-manager/Photos/GHGHGH/', 84329, '0', '1', '2025-12-05 06:14:35', '2025-12-05 06:14:35'),
(16, 'thumb_v_y_1.jpg', 'file', 12, 'uploads/file-manager/Photos/GHGHGH/', 79637, '0', '1', '2025-12-05 06:14:35', '2025-12-05 06:14:35'),
(17, 'thumb_v_y_2.jpg', 'file', 12, 'uploads/file-manager/Photos/GHGHGH/', 101969, '0', '1', '2025-12-05 06:14:35', '2025-12-05 06:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `file_shares`
--

DROP TABLE IF EXISTS `file_shares`;
CREATE TABLE IF NOT EXISTS `file_shares` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_shares`
--

INSERT INTO `file_shares` (`id`, `file_id`, `role_id`, `user_id`, `action_type`, `action_by`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 2, 'forwarded', 1, '2025-03-07 05:44:43', '2025-03-07 05:44:43'),
(2, 3, 1, 1, 'forwarded', 1, '2025-03-07 06:54:52', '2025-03-07 06:54:52'),
(3, 3, 2, 2, 'forwarded', 1, '2025-03-07 06:56:10', '2025-03-07 06:56:10'),
(4, 1, 1, 1, 'forwarded', 1, '2025-12-02 00:11:51', '2025-12-02 00:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

DROP TABLE IF EXISTS `form_fields`;
CREATE TABLE IF NOT EXISTS `form_fields` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subcategory_id` bigint UNSIGNED NOT NULL,
  `field_label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_type` enum('text','textarea','select','checkbox','radio','number','date') COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_options` json DEFAULT NULL,
  `is_required` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_fields_subcategory_id_foreign` (`subcategory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `subcategory_id`, `field_label`, `field_name`, `field_type`, `field_options`, `is_required`, `order`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'Size', 'size', 'select', '\"[\\\"2XS\\\",\\\"XS\\\",\\\"S\\\",\\\"M\\\",\\\"L\\\",\\\"XL\\\",\\\"2XL\\\",\\\"3XL\\\",\\\"4XL\\\",\\\"5XL\\\",\\\"6XL\\\",\\\"7XL\\\",\\\"8XL\\\",\\\"9XL\\\",\\\"10XL\\\",\\\"Free\\\"]\"', '1', 0, '1', '0', '2025-12-04 02:23:25', '2025-12-04 07:50:47'),
(2, 1, 'Color', 'color', 'select', '\"[\\\"Black\\\",\\\"White\\\",\\\"Multicolor\\\",\\\"Blue\\\",\\\"Grey\\\",\\\"Green\\\",\\\"Maroon\\\",\\\"Red\\\",\\\"Beige\\\",\\\"Yellow\\\",\\\"Brown\\\",\\\"Navy Blue\\\",\\\"Pink\\\",\\\"Dark Blue\\\",\\\"Purple\\\",\\\"Dark Green\\\",\\\"Light Blue\\\",\\\"Light Green\\\",\\\"Orange\\\",\\\"Silver\\\",\\\"Gold\\\"]\"', '1', 0, '1', '0', '2025-12-04 05:44:42', '2025-12-04 07:50:30'),
(3, 1, 'Fabric', 'fabric', 'select', '\"[\\\"Cotton Blend\\\",\\\"Pure Cotton\\\",\\\"Polyester\\\",\\\"Polycotton\\\",\\\"Organic Cotton\\\",\\\"Elastane\\\",\\\"Nylon\\\",\\\"Wool Blend\\\",\\\"Viscose Rayon\\\",\\\"Linen Blend\\\",\\\"Modal\\\"]\"', '0', 0, '1', '0', '2025-12-04 05:54:28', '2025-12-04 07:51:38'),
(4, 1, 'Sleeve Type', 'sleeve_type', 'select', '\"[\\\"Half Sleeve\\\",\\\"Short Sleeve\\\",\\\"Full Sleeve\\\",\\\"Sleeveless\\\",\\\"3\\\\/4 Sleeve\\\",\\\"Roll-up Sleeve\\\",\\\"Layered Sleeve\\\",\\\"Raglan\\\"]\"', '0', 0, '1', '0', '2025-12-04 06:13:20', '2025-12-04 06:34:38'),
(5, 1, 'Occasion', 'occasion', 'select', '\"[\\\"Casual\\\",\\\"Sports\\\",\\\"Formal\\\",\\\"Party\\\",\\\"Lounge Wear\\\",\\\"Beach Wear\\\",\\\"Festive\\\"]\"', '0', 0, '1', '0', '2025-12-04 06:48:35', '2025-12-04 06:48:35'),
(6, 1, 'Type', 'type', 'checkbox', '\"[\\\"Round Neck\\\",\\\"Polo Neck\\\",\\\"Hooded Neck\\\",\\\"Crew Neck\\\",\\\"V Neck\\\",\\\"Zip Neck\\\",\\\"Henley Neck\\\",\\\"High Neck\\\",\\\"Mandarin Collar\\\",\\\"Scoop Neck\\\",\\\"Turtle Neck\\\",\\\"Cowl Neck\\\",\\\"Stylised Neck\\\",\\\"Boat Neck\\\",\\\"Shawl Neck\\\",\\\"Racerback\\\",\\\"Halter Neck\\\",\\\"Peter Pan Collar\\\",\\\"Square Neck\\\"]\"', '0', 2, '1', '0', '2025-12-04 07:10:18', '2025-12-04 07:52:23'),
(7, 1, 'Gender', 'gender', 'radio', '\"[\\\"Male\\\",\\\"Female\\\",\\\"Other\\\"]\"', '0', 1, '1', '0', '2025-12-04 07:26:34', '2025-12-04 07:48:05'),
(8, 2, 'Mfg Date', 'mfg_date', 'textarea', NULL, '1', 0, '1', '0', '2025-12-05 06:01:45', '2025-12-05 06:06:07'),
(9, 2, 'Colors', 'colors', 'select', '\"[\\\"@\\\"]\"', '0', 0, '1', '0', '2025-12-05 06:03:14', '2025-12-05 06:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

DROP TABLE IF EXISTS `masters`;
CREATE TABLE IF NOT EXISTS `masters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `order`, `is_home`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Users', 5, '0', '1', '0', '2025-04-22 06:01:01', '2025-12-05 00:38:24'),
(2, 'Categories', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:58:23'),
(3, 'Products', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:59:40'),
(4, 'Roles', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:58:30'),
(5, 'Permissions', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:58:38'),
(6, 'Files', NULL, '1', '1', '0', '2025-04-22 06:01:01', '2025-04-22 06:01:01'),
(7, 'Settings', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:59:29'),
(8, 'Masters', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:59:03'),
(9, 'Menus', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:58:52'),
(10, 'Brands', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:58:45'),
(16, 'Subcategories', NULL, '1', '1', '0', '2025-04-22 01:51:17', '2025-04-22 01:51:17'),
(17, 'Item Types', NULL, '1', '1', '0', '2025-05-06 07:10:32', '2025-05-06 07:10:32'),
(18, 'Pages', NULL, '1', '1', '0', '2025-12-03 03:58:43', '2025-12-05 00:38:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_21_121000_create_roles_table', 1),
(6, '2025_02_21_121155_create_permissions_table', 1),
(7, '2025_02_21_121202_create_role_permissions_table', 1),
(8, '2025_02_21_121210_create_user_roles_table', 1),
(9, '2025_02_26_090800_create_books_table', 2),
(10, '2025_02_26_090819_create_reviews_table', 3),
(11, '2025_03_07_071811_create_files_table', 4),
(12, '2025_03_07_072000_create_file_shares_table', 5),
(13, '2025_03_13_061135_create_categories_table', 6),
(14, '2025_03_24_125001_create_variants_table', 7),
(15, '2025_04_04_085805_create_contacts_table', 8),
(17, '2025_04_08_081522_create_addresses_table', 9),
(18, '2025_04_17_061919_create_settings_table', 10),
(19, '2025_04_17_123759_create_masters_table', 11),
(20, '2025_04_22_055222_create_menus_table', 12),
(21, '2025_05_06_113712_create_sub_categories_table', 13),
(22, '2025_05_13_115305_create_items_table', 14),
(23, '2025_05_13_121357_create_brands_table', 15),
(24, '2025_07_01_123627_create_file_managers_table', 16),
(25, '2025_12_04_064304_create_form_fields_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `description`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '<p><img src=\"data:image/jpeg;base64,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b25nAAAAAAAAAAtjcm9wUmVjdFRvcGxvbmcAAAAAADhCSU0D7QAAAAAAEABIAAAAAQABAEgAAAABAAE4QklNBCYAAAAAAA4AAAAAAAAAAAAAP4AAADhCSU0EDQAAAAAABAAAAHg4QklNBBkAAAAAAAQAAAAeOEJJTQPzAAAAAAAJAAAAAAAAAAABADhCSU0nEAAAAAAACgABAAAAAAAAAAE4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQAAAAAAAACAAQ4QklNBAIAAAAAAAoAAAAAAAAAAAAAOEJJTQQwAAAAAAAFAQEBAQEAOEJJTQQtAAAAAAAGAAEAAAAHOEJJTQQIAAAAAAAQAAAAAQAAAkAAAAJAAAAAADhCSU0EHgAAAAAABAAAAAA4QklNBBoAAAAAA0kAAAAGAAAAAAAAAAAAAADrAAABXAAAAAoAVQBuAHQAaQB0AGwAZQBkAC0ANAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAABXAAAAOsAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAQAAAAAAAG51bGwAAAACAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAAOsAAAAAUmdodGxvbmcAAAFcAAAABnNsaWNlc1ZsTHMAAAABT2JqYwAAAAEAAAAAAAVzbGljZQAAABIAAAAHc2xpY2VJRGxvbmcAAAAAAAAAB2dyb3VwSURsb25nAAAAAAAAAAZvcmlnaW5lbnVtAAAADEVTbGljZU9yaWdpbgAAAA1hdXRvR2VuZXJhdGVkAAAAAFR5cGVlbnVtAAAACkVTbGljZVR5cGUAAAAASW1nIAAAAAZib3Vu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REYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDE1LTA2LTA3VDIxOjAwOjQ2KzA1OjMwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAxNS0wNi0wOFQwMDozODowNyswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxNS0wNi0wOFQwMDozODowNyswNTozMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1MjQ2RjNFNjIwMERFNTExOTg4NkU2MDQxQTYxNjM2MyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBMzM4QkFFMDJBMERFNTExOTg4NkU2MDQxQTYxNjM2MyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjUyNDZGM0U2MjAwREU1MTE5ODg2RTYwNDFBNjE2MzYzIiBkYzpmb3JtYXQ9ImltYWdlL2pwZWciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6QTIzOEJBRTAyQTBERTUxMTk4ODZFNjA0MUE2MTYzNjMiIHN0RXZ0OndoZW49IjIwMTUtMDYtMDdUMjE6MDA6NDYrMDU6MzAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjb252ZXJ0ZWQiIHN0RXZ0OnBhcmFtZXRlcnM9ImZyb20gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCB0byBpbWFnZS9qcGVnIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpBMzM4QkFFMDJBMERFNTExOTg4NkU2MDQxQTYxNjM2MyIgc3RFdnQ6d2hlbj0iMjAxNS0wNi0wOFQwMDozODowNyswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDxwaG90b3Nob3A6RG9jdW1lbnRBbmNlc3RvcnM+IDxyZGY6QmFnPiA8cmRmOmxpPnhtcC5kaWQ6NEM0NkYzRTYyMDBERTUxMTk4ODZFNjA0MUE2MTYzNjM8L3JkZjpsaT4gPHJkZjpsaT54bXAuZGlkOkEwMzhCQUUwMkEwREU1MTE5ODg2RTYwNDFBNjE2MzYzPC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDpGNDE5QUM2RTIzMERFNTExOTg4NkU2MDQxQTYxNjM2MzwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg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\" data-filename=\"thumb-v-v-2.jpg\" style=\"width: 348px; float: right;\" class=\"note-float-right\"></p>\r\n<div><b style=\"background-color: rgb(0, 255, 255); color: rgb(255, 0, 0);\">No dolore ipsum accusam no lorem. </b></div><div><i><font face=\"Courier New\">Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</font></i></div><div><i><br></i></div><div><i><br></i></div><div><div class=\"col-md-9\" style=\"width: 855px; padding-right: 15px; padding-left: 15px; color: rgb(108, 117, 125); font-family: Roboto, sans-serif;\"><div class=\"row\" style=\"margin-right: -15px; margin-left: -15px;\"><div class=\"col-md-3 mb-3\" style=\"width: 213.75px; padding-right: 15px; padding-left: 15px;\"><h6 class=\"text-danger font-weight-bold\" style=\"color: rgb(220, 53, 69) !important;\">Mobiles &amp; Accessories</h6><ul class=\"list-unstyled\" style=\"margin-bottom: 0px;\"><li><a href=\"http://localhost/e-com/shop/mobiles-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Cases &amp; Covers</a></li><li><a href=\"http://localhost/e-com/shop/mobiles-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Chargers &amp; Cables</a></li><li><a href=\"http://localhost/e-com/shop/mobiles-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Power Banks</a></li><li><a href=\"http://localhost/e-com/shop/mobiles-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Smartphones</a></li></ul></div><div class=\"col-md-3 mb-3\" style=\"width: 213.75px; padding-right: 15px; padding-left: 15px;\"><h6 class=\"text-danger font-weight-bold\" style=\"color: rgb(220, 53, 69) !important;\">Computers &amp; Laptops</h6><ul class=\"list-unstyled\" style=\"margin-bottom: 0px;\"><li><a href=\"http://localhost/e-com/shop/computers-&amp;-laptops\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Desktops</a></li><li><a href=\"http://localhost/e-com/shop/computers-&amp;-laptops\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Keyboards &amp; Mouse</a></li><li><a href=\"http://localhost/e-com/shop/computers-&amp;-laptops\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Laptops</a></li><li><a href=\"http://localhost/e-com/shop/computers-&amp;-laptops\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Monitors</a></li></ul></div><div class=\"col-md-3 mb-3\" style=\"width: 213.75px; padding-right: 15px; padding-left: 15px;\"><h6 class=\"text-danger font-weight-bold\" style=\"color: rgb(220, 53, 69) !important;\">TV &amp; Audio</h6><ul class=\"list-unstyled\" style=\"margin-bottom: 0px;\"><li><a href=\"http://localhost/e-com/shop/tv-&amp;-audio\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Headphones &amp; Earbuds</a></li><li><a href=\"http://localhost/e-com/shop/tv-&amp;-audio\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Home Theatres</a></li><li><a href=\"http://localhost/e-com/shop/tv-&amp;-audio\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Smart TVs</a></li><li><a href=\"http://localhost/e-com/shop/tv-&amp;-audio\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Soundbars</a></li></ul></div><div class=\"col-md-3 mb-3\" style=\"width: 213.75px; padding-right: 15px; padding-left: 15px;\"><h6 class=\"text-danger font-weight-bold\" style=\"color: rgb(220, 53, 69) !important;\">Cameras &amp; Accessories</h6><ul class=\"list-unstyled\" style=\"margin-bottom: 0px;\"><li><a href=\"http://localhost/e-com/shop/cameras-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Action Cameras</a></li><li><a href=\"http://localhost/e-com/shop/cameras-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">DSLR Cameras</a></li><li><a href=\"http://localhost/e-com/shop/cameras-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Memory Cards</a></li><li><a href=\"http://localhost/e-com/shop/cameras-&amp;-accessories\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Tripods &amp; Mounts</a></li></ul></div><div class=\"col-md-3 mb-3\" style=\"width: 213.75px; padding-right: 15px; padding-left: 15px;\"><h6 class=\"text-danger font-weight-bold\" style=\"color: rgb(220, 53, 69) !important;\">Home Appliances</h6><ul class=\"list-unstyled\" style=\"margin-bottom: 0px;\"><li><a href=\"http://localhost/e-com/shop/home-appliances\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Air Conditioners</a></li><li><a href=\"http://localhost/e-com/shop/home-appliances\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Microwaves</a></li><li><a href=\"http://localhost/e-com/shop/home-appliances\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Refrigerators</a></li><li><a href=\"http://localhost/e-com/shop/home-appliances\" class=\"text-dark\" style=\"color: rgb(61, 70, 77) !important;\">Washing Machines</a></li></ul></div></div></div><div class=\"col-md-3 text-center\" style=\"width: 285px; padding-right: 15px; padding-left: 15px; color: rgb(108, 117, 125); font-family: Roboto, sans-serif;\"></div></div>', '0', '1', '2025-12-03 04:08:02', '2025-12-03 05:03:45');
INSERT INTO `pages` (`id`, `name`, `slug`, `description`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Privacy Policy', 'privacy-policy', '<p>asasas</p>', '0', '1', '2025-12-03 04:16:11', '2025-12-03 04:51:58'),
(3, 'asas', 'asas', '<p>asas</p>', '0', '1', '2025-12-03 04:53:20', '2025-12-03 04:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int DEFAULT NULL,
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `menu_id`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'product create', 3, '0', '2025-02-21 07:19:13', '2025-04-18 01:12:23'),
(2, 'product edit', 3, '0', '2025-02-21 07:19:13', '2025-04-18 01:12:16'),
(6, 'permission list', 5, '0', '2025-02-24 04:22:35', '2025-04-18 01:12:52'),
(7, 'permission create', 5, '0', '2025-02-24 04:22:50', '2025-04-18 01:13:00'),
(8, 'permission edit', 5, '0', '2025-02-24 04:22:57', '2025-04-18 01:13:23'),
(9, 'permission delete', 5, '0', '2025-02-24 04:23:03', '2025-04-18 01:13:07'),
(10, 'role list', 4, '0', '2025-02-24 04:23:10', '2025-04-18 01:13:15'),
(11, 'role create', 4, '0', '2025-02-24 04:23:17', '2025-04-18 01:12:42'),
(12, 'role edit', 4, '0', '2025-02-24 04:23:24', '2025-04-18 01:12:31'),
(13, 'role delete', 1, '0', '2025-02-24 04:23:31', '2025-04-18 01:13:51'),
(14, 'user list', 1, '0', '2025-02-24 04:23:37', '2025-04-18 01:13:42'),
(15, 'user create', 1, '0', '2025-02-24 04:23:44', '2025-04-18 01:13:32'),
(16, 'user edit', 1, '0', '2025-02-24 04:23:51', '2025-04-18 01:15:06'),
(17, 'user delete', 1, '0', '2025-02-24 04:23:57', '2025-04-18 01:14:56'),
(18, 'product list', 3, '0', '2025-02-24 04:24:09', '2025-04-18 01:14:48'),
(19, 'product delete', 3, '0', '2025-02-24 04:25:02', '2025-04-18 01:14:40'),
(22, 'product review', 3, '0', '2025-03-05 06:42:26', '2025-04-18 01:14:32'),
(23, 'file list', 6, '0', '2025-03-07 04:11:25', '2025-04-18 01:14:23'),
(24, 'file create', 6, '0', '2025-03-07 04:11:36', '2025-04-18 01:14:15'),
(25, 'file edit', 6, '0', '2025-03-07 04:11:44', '2025-04-18 01:14:08'),
(26, 'file delete', 6, '0', '2025-03-07 04:11:59', '2025-04-18 01:12:08'),
(27, 'category list', 2, '0', '2025-03-13 00:47:46', '2025-04-18 01:11:51'),
(28, 'category create', 2, '0', '2025-03-13 00:48:00', '2025-04-18 01:11:42'),
(29, 'category edit', 2, '0', '2025-03-13 00:48:12', '2025-04-18 01:11:35'),
(30, 'category delete', 2, '0', '2025-03-13 00:48:26', '2025-04-18 01:11:29'),
(31, 'settings', NULL, '0', '2025-04-17 02:54:28', '2025-04-18 04:15:01'),
(32, 'site settings', 7, '0', '2025-04-17 06:55:34', '2025-04-17 08:03:53'),
(33, 'masters', NULL, '0', '2025-04-17 07:03:41', '2025-04-18 04:15:10'),
(34, 'menu list', 9, '0', '2025-04-17 07:04:16', '2025-04-17 08:10:16'),
(35, 'menu create', 9, '0', '2025-04-17 07:04:28', '2025-04-17 08:10:25'),
(36, 'menu edit', 9, '0', '2025-04-17 07:04:41', '2025-04-17 08:10:08'),
(37, 'menu delete', 9, '0', '2025-04-17 07:04:56', '2025-04-17 08:10:00'),
(38, 'brand list', 10, '0', '2025-04-18 04:34:17', '2025-04-18 06:00:07'),
(39, 'brand create', 10, '0', '2025-04-18 04:35:27', '2025-04-18 06:00:16'),
(40, 'brand edit', 10, '0', '2025-04-18 06:00:41', '2025-04-18 06:00:41'),
(41, 'brand delete', 10, '0', '2025-04-18 06:00:55', '2025-04-18 06:00:55'),
(42, 'subcategory list', 16, '0', '2025-04-22 01:48:26', '2025-04-22 01:56:39'),
(43, 'subcategory create', 16, '0', '2025-04-22 01:48:52', '2025-04-22 01:56:30'),
(44, 'subcategory edit', 16, '0', '2025-04-22 01:49:43', '2025-04-22 01:56:21'),
(45, 'subcategory delete', 16, '0', '2025-04-22 01:49:57', '2025-04-22 01:55:54'),
(46, 'item type create', 17, '0', '2025-05-06 07:04:37', '2025-05-06 07:10:59'),
(47, 'item type edit', 17, '0', '2025-05-06 07:05:07', '2025-05-06 07:11:08'),
(48, 'item type list', 17, '0', '2025-05-06 07:05:20', '2025-05-06 07:10:51'),
(49, 'item type delete', 17, '0', '2025-05-06 07:05:35', '2025-05-06 07:10:45'),
(50, 'page list', 18, '0', '2025-12-03 03:59:36', '2025-12-03 03:59:36'),
(51, 'page edit', 18, '0', '2025-12-03 03:59:43', '2025-12-03 03:59:43'),
(52, 'page create', 18, '0', '2025-12-03 03:59:54', '2025-12-03 03:59:54'),
(53, 'page delete', 18, '0', '2025-12-03 04:00:05', '2025-12-05 00:37:46');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcategory` int DEFAULT NULL,
  `category` int DEFAULT NULL,
  `main_category` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_trending` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `reviews` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_book_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '0', '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(2, 'Author', '0', '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(3, 'User', '0', '2025-02-21 07:19:13', '2025-02-24 01:49:33'),
(8, 'Test', '0', '2025-02-24 04:52:55', '2025-02-24 04:52:55'),
(9, 'Demo Role', '0', '2025-03-25 07:24:32', '2025-03-25 07:24:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_permissions_role_id_foreign` (`role_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(30, 8, 18, NULL, NULL),
(31, 8, 6, NULL, NULL),
(32, 8, 10, NULL, NULL),
(33, 8, 14, NULL, NULL),
(187, 8, 28, NULL, NULL),
(188, 8, 30, NULL, NULL),
(189, 8, 29, NULL, NULL),
(190, 8, 27, NULL, NULL),
(191, 8, 24, NULL, NULL),
(192, 8, 26, NULL, NULL),
(193, 8, 25, NULL, NULL),
(194, 8, 23, NULL, NULL),
(195, 8, 7, NULL, NULL),
(196, 8, 9, NULL, NULL),
(197, 8, 8, NULL, NULL),
(198, 8, 1, NULL, NULL),
(199, 8, 19, NULL, NULL),
(200, 8, 2, NULL, NULL),
(201, 8, 22, NULL, NULL),
(202, 8, 11, NULL, NULL),
(203, 8, 13, NULL, NULL),
(204, 8, 12, NULL, NULL),
(205, 8, 15, NULL, NULL),
(206, 8, 17, NULL, NULL),
(207, 8, 16, NULL, NULL),
(215, 3, 28, NULL, NULL),
(216, 3, 30, NULL, NULL),
(217, 3, 29, NULL, NULL),
(218, 3, 27, NULL, NULL),
(219, 3, 24, NULL, NULL),
(220, 3, 26, NULL, NULL),
(221, 3, 25, NULL, NULL),
(222, 3, 23, NULL, NULL),
(223, 3, 33, NULL, NULL),
(224, 3, 35, NULL, NULL),
(225, 3, 37, NULL, NULL),
(226, 3, 36, NULL, NULL),
(227, 3, 34, NULL, NULL),
(228, 3, 7, NULL, NULL),
(229, 3, 9, NULL, NULL),
(230, 3, 8, NULL, NULL),
(231, 3, 6, NULL, NULL),
(232, 3, 1, NULL, NULL),
(233, 3, 19, NULL, NULL),
(234, 3, 2, NULL, NULL),
(235, 3, 18, NULL, NULL),
(236, 3, 22, NULL, NULL),
(237, 3, 11, NULL, NULL),
(238, 3, 13, NULL, NULL),
(239, 3, 12, NULL, NULL),
(240, 3, 10, NULL, NULL),
(241, 3, 31, NULL, NULL),
(242, 3, 32, NULL, NULL),
(243, 3, 15, NULL, NULL),
(244, 3, 17, NULL, NULL),
(245, 3, 16, NULL, NULL),
(246, 3, 14, NULL, NULL),
(247, 2, 28, NULL, NULL),
(248, 2, 30, NULL, NULL),
(249, 2, 29, NULL, NULL),
(250, 2, 27, NULL, NULL),
(251, 2, 24, NULL, NULL),
(252, 2, 26, NULL, NULL),
(253, 2, 25, NULL, NULL),
(254, 2, 23, NULL, NULL),
(256, 2, 35, NULL, NULL),
(257, 2, 37, NULL, NULL),
(258, 2, 36, NULL, NULL),
(259, 2, 34, NULL, NULL),
(260, 2, 7, NULL, NULL),
(261, 2, 9, NULL, NULL),
(262, 2, 8, NULL, NULL),
(263, 2, 6, NULL, NULL),
(264, 2, 1, NULL, NULL),
(265, 2, 19, NULL, NULL),
(266, 2, 2, NULL, NULL),
(267, 2, 18, NULL, NULL),
(268, 2, 22, NULL, NULL),
(269, 2, 11, NULL, NULL),
(270, 2, 13, NULL, NULL),
(271, 2, 12, NULL, NULL),
(272, 2, 10, NULL, NULL),
(274, 2, 32, NULL, NULL),
(275, 2, 15, NULL, NULL),
(276, 2, 17, NULL, NULL),
(277, 2, 16, NULL, NULL),
(278, 2, 14, NULL, NULL),
(300, 2, 39, NULL, NULL),
(301, 2, 38, NULL, NULL),
(473, 1, 28, NULL, NULL),
(474, 1, 30, NULL, NULL),
(475, 1, 29, NULL, NULL),
(476, 1, 27, NULL, NULL),
(477, 1, 24, NULL, NULL),
(478, 1, 26, NULL, NULL),
(479, 1, 25, NULL, NULL),
(480, 1, 23, NULL, NULL),
(485, 1, 7, NULL, NULL),
(486, 1, 9, NULL, NULL),
(487, 1, 8, NULL, NULL),
(488, 1, 6, NULL, NULL),
(489, 1, 1, NULL, NULL),
(490, 1, 19, NULL, NULL),
(491, 1, 2, NULL, NULL),
(492, 1, 18, NULL, NULL),
(493, 1, 22, NULL, NULL),
(494, 1, 11, NULL, NULL),
(495, 1, 13, NULL, NULL),
(496, 1, 12, NULL, NULL),
(497, 1, 10, NULL, NULL),
(498, 1, 32, NULL, NULL),
(499, 1, 43, NULL, NULL),
(500, 1, 45, NULL, NULL),
(501, 1, 44, NULL, NULL),
(502, 1, 42, NULL, NULL),
(510, 1, 37, NULL, NULL),
(511, 1, 36, NULL, NULL),
(512, 1, 34, NULL, NULL),
(532, 1, 35, NULL, NULL),
(533, 2, 43, NULL, NULL),
(534, 2, 45, NULL, NULL),
(535, 2, 44, NULL, NULL),
(536, 2, 42, NULL, NULL),
(537, 2, 41, NULL, NULL),
(538, 2, 40, NULL, NULL),
(544, 1, 46, NULL, NULL),
(545, 1, 49, NULL, NULL),
(546, 1, 47, NULL, NULL),
(547, 1, 48, NULL, NULL),
(548, 9, 39, NULL, NULL),
(549, 9, 41, NULL, NULL),
(550, 9, 40, NULL, NULL),
(551, 9, 38, NULL, NULL),
(565, 9, 32, NULL, NULL),
(568, 9, 13, NULL, NULL),
(570, 9, 11, NULL, NULL),
(571, 9, 12, NULL, NULL),
(572, 9, 10, NULL, NULL),
(586, 1, 39, NULL, NULL),
(587, 1, 41, NULL, NULL),
(588, 1, 40, NULL, NULL),
(589, 1, 38, NULL, NULL),
(594, 1, 52, NULL, NULL),
(595, 1, 53, NULL, NULL),
(596, 1, 51, NULL, NULL),
(597, 1, 50, NULL, NULL),
(598, 9, 52, NULL, NULL),
(599, 9, 51, NULL, NULL),
(600, 9, 50, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_iframe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `email`, `phone`, `address`, `post_code`, `header_logo`, `footer_logo`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `map_iframe`, `created_at`, `updated_at`) VALUES
(1, 'Melody', 'No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no', 'info@example.com', '01234567890', '123 Street, New York, USA', '110067', '1764676349_692ed2fd6397b.svg', '1744890030_6800e8aea0d5b.svg', 'https://www.facebook.com/', 'https://x.com/', 'https://www.linkedin.com/', 'https://www.instagram.com/', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12001247.519305438!2d-75.770041!3d42.74622!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1744889821973!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '0000-00-00 00:00:00', '2025-12-02 06:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_fields` json DEFAULT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `category`, `image`, `thumbnail`, `description`, `form_fields`, `order`, `is_home`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'T-Shirts', 't-shirts', 6, '1764655280.png', 'thumb_1764655280.png', NULL, '[\"color\", \"size (Inch)\", \"resolution (1280 x 720)\", \"quality (HD)\", \"quantity\", \"images\"]', NULL, '1', '0', '1', '2025-12-01 11:29:13', '2025-12-03 01:31:34'),
(2, 'Shirts', 'shirts', 6, NULL, NULL, NULL, '[\"color\", \"size (XX)\", \"quantity\", \"images\", \"description\", \"highlights\", \"specifications\"]', NULL, '1', '0', '1', '2025-12-01 10:56:00', '2025-12-04 00:38:52'),
(3, 'Jeans', 'jeans', 6, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 10:56:00', '2025-12-01 10:56:00'),
(4, 'Jackets', 'jackets', 6, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 10:56:00', '2025-12-01 10:56:00'),
(5, 'Footwear', 'footwear', 6, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 10:56:00', '2025-12-01 10:56:00'),
(6, 'Sarees', 'sarees', 7, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(7, 'Dresses', 'dresses', 7, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(8, 'Tops & T-Shirts', 'tops-t-shirts', 7, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(9, 'Handbags', 'handbags', 7, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(10, 'Footwears', 'footwears', 7, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(11, 'Boys Clothing', 'boys-clothing', 8, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(12, 'Girls Clothing', 'girls-clothing', 8, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(13, 'Baby Essentials', 'baby-essentials', 8, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(14, 'School Shoes', 'school-shoes', 8, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(15, 'Watches', 'watches', 9, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(16, 'Sunglasses', 'sunglasses', 9, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(17, 'Belts & Wallets', 'belts-wallets', 9, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(18, 'Caps & Hats', 'caps-hats', 9, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(19, 'Sweaters', 'sweaters', 10, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(20, 'Hoodies', 'hoodies', 10, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(21, 'Coats & Blazers', 'coats-blazers', 10, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(22, 'Thermal Wear', 'thermal-wear', 10, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:00:10', '2025-12-01 11:00:10'),
(23, 'Smartphones', 'smartphones', 11, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:06:56', '2025-12-01 11:06:56'),
(24, 'Power Banks', 'power-banks', 11, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:06:56', '2025-12-01 11:06:56'),
(25, 'Cases & Covers', 'cases-covers', 11, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:06:56', '2025-12-01 11:06:56'),
(26, 'Chargers & Cables', 'chargers-cables', 11, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:06:56', '2025-12-01 11:06:56'),
(27, 'Laptops', 'laptops', 12, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(28, 'Desktops', 'desktops', 12, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(29, 'Monitors', 'monitors', 12, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(30, 'Keyboards & Mouse', 'keyboards-mouse', 12, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(31, 'Smart TVs', 'smart-tvs', 13, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(32, 'Soundbars', 'soundbars', 13, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(33, 'Home Theatres', 'home-theatres', 13, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(34, 'Headphones & Earbuds', 'headphones-earbuds', 13, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(35, 'DSLR Cameras', 'dslr-cameras', 14, NULL, NULL, NULL, '[\"color\", \"description\", \"highlights\", \"specifications\"]', NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-02 05:23:16'),
(36, 'Action Cameras', 'action-cameras', 14, NULL, NULL, NULL, '[\"specifications\"]', NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-02 04:39:12'),
(37, 'Tripods & Mounts', 'tripods-mounts', 14, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(38, 'Memory Cards', 'memory-cards', 14, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(39, 'Washing Machines', 'washing-machines', 15, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(40, 'Refrigerators', 'refrigerators', 15, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(41, 'Air Conditioners', 'air-conditioners', 15, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(42, 'Microwaves', 'microwaves', 15, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(43, 'Cookware', 'cookware', 16, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(44, 'Storage Containers', 'storage-containers', 16, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(45, 'Dinner Sets', 'dinner-sets', 16, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(46, 'Kitchen Tools', 'kitchen-tools', 16, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(47, 'Wall Art', 'wall-art', 17, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(48, 'Clocks', 'clocks', 17, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(49, 'Lamps & Lighting', 'lamps-lighting', 17, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(50, 'Curtains & Cushions', 'curtains-cushions', 17, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(51, 'Sofas', 'sofas', 18, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(52, 'Beds', 'beds', 18, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(53, 'Tables & Chairs', 'tables-chairs', 18, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(54, 'Wardrobes', 'wardrobes', 18, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(55, 'Tools & Hardware', 'tools-hardware', 19, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(56, 'Cleaning Supplies', 'cleaning-supplies', 19, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(57, 'Electrical Fixtures', 'electrical-fixtures', 19, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(58, 'Bedsheets', 'bedsheets', 20, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(59, 'Blankets & Quilts', 'blankets-quilts', 20, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(60, 'Towels', 'towels', 20, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(61, 'Bath Mats', 'bath-mats', 20, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(62, 'Novels', 'novels', 21, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(63, 'Short Stories', 'short-stories', 21, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(64, 'Fantasy', 'fantasy', 21, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(65, 'Thrillers', 'thrillers', 21, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(66, 'Biographies', 'biographies', 22, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(67, 'Self-Help', 'self-help', 22, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(68, 'Business & Economics', 'business-economics', 22, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(69, 'History', 'history', 22, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(70, 'Story Books', 'story-books', 23, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(71, 'Activity Books', 'activity-books', 23, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(72, 'Educational Books', 'educational-books', 23, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(73, 'CDs', 'cds', 24, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(74, 'Vinyl Records', 'vinyl-records', 24, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(75, 'Digital Albums', 'digital-albums', 24, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(76, 'DVDs', 'dvds', 25, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(77, 'Blu-ray', 'blu-ray', 25, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(78, 'Documentary Films', 'documentary-films', 25, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(79, 'Lipsticks', 'lipsticks', 26, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(80, 'Foundations', 'foundations', 26, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(81, 'Eyeliners', 'eyeliners', 26, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(82, 'Makeup Kits', 'makeup-kits', 26, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(83, 'Moisturizers', 'moisturizers', 27, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(84, 'Face Wash', 'face-wash', 27, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(85, 'Sunscreen', 'sunscreen', 27, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(86, 'Serums', 'serums', 27, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(87, 'Shampoos', 'shampoos', 28, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(88, 'Conditioners', 'conditioners', 28, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(89, 'Hair Oils', 'hair-oils', 28, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(90, 'Styling Products', 'styling-products', 28, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(91, 'Bath & Shower', 'bath-shower', 29, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(92, 'Oral Care', 'oral-care', 29, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(93, 'Feminine Hygiene', 'feminine-hygiene', 29, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(94, 'Perfumes', 'perfumes', 30, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(95, 'Deodorants', 'deodorants', 30, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12'),
(96, 'Body Mists', 'body-mists', 30, NULL, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-12-01 11:28:12', '2025-12-01 11:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '	1=Active, 0=Inactive',
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `image`, `state`, `city`, `pin_code`, `email_verified_at`, `password`, `remember_token`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '8423551271', 'Demo Address', '1741179188.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$uCH3PmmCcrLpd15FnIX88eDu5rgbu5Yet9Y1L4E3yAU0ww7ZT434O', NULL, '1', '0', '2025-02-21 07:19:13', '2025-04-22 07:20:51'),
(2, 'Author', 'author@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$0i0fsTFnUyBtqurjSI4NS.S3G/oLzGPH.eSQMyfEv7rLt3oTCDp4G', NULL, '0', '0', '2025-02-21 07:19:13', '2025-04-22 06:52:52'),
(3, 'User', 'user@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$onp/9.1OXXbfAFSPPFZta.RPRqde94HHKd.S.z/8/qjnzhVOapR6K', NULL, '1', '0', '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(4, 'Aman Kumar', 'aman@gmail.com', '9999999999', 'Demo Address', '1740394053.png', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$daOAexpIflWDiAZ6hXNfYuaVwOAso6FeXGlLrmEUj2L9aLl7VA/Mm', NULL, '0', '0', '2025-02-24 05:17:33', '2025-04-22 07:29:42'),
(5, 'asasas', 'amansasa@gmail.com', '9999999999', 'Demo Address', '1741167801.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$QtpNBgM92ptFqzT5yPkEIuSj9c2jPCoFFgYEFZy3tymPHG0UHMoh2', NULL, '0', '0', '2025-03-05 03:43:49', '2025-04-22 07:29:35'),
(6, 'Shanu Kashyap', 'shanukashyap244@gmail.com', '8423551271', 'Demo Address', '1744798946.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$Sdz/JK113Oig6UsCY3P1ieOE9aQH/5KC9usfPWBB9zC5D2vOFfwd.', NULL, '1', '0', '2025-04-04 05:14:42', '2025-04-16 04:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_roles_user_id_foreign` (`user_id`),
  KEY `user_roles_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(7, 5, 2, NULL, NULL),
(8, 4, 9, NULL, NULL),
(9, 6, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
CREATE TABLE IF NOT EXISTS `variants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `occasion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `quality` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `resolution` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `base_price` float DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `description` longtext,
  `highlights` longtext,
  `specifications` longtext,
  `is_delete` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variants_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
