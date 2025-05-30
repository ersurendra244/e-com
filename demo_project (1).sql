-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2025 at 12:31 PM
-- Server version: 9.1.0
-- PHP Version: 7.4.33

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
  `street` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delete` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FabIndia', '1744977372_68023ddc68cc1.jpg', '0', '1', NULL, '2025-05-13 07:02:22'),
(2, 'Manyavar', '1744977396_68023df4c6bcf.jpg', '0', '1', NULL, NULL),
(3, 'Allen Solly', '1744977565_68023e9d2b64c.jpg', '0', '1', NULL, NULL),
(4, 'Van Heusen', '1744979065_680244792a78f.jpg', '0', '1', NULL, NULL),
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `thumbnail`, `image`, `description`, `order`, `is_home`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Fashion', 'fashion', NULL, NULL, NULL, NULL, '1', '1', '0', '2025-05-06 03:31:34', '2025-05-12 07:27:44'),
(2, 'Electronics', 'electronics', NULL, NULL, NULL, NULL, '1', '1', '0', '2025-05-06 03:31:43', '2025-05-13 05:31:31'),
(3, 'Home & Kitchen', 'home-&-kitchen', NULL, NULL, NULL, NULL, '1', '1', '0', '2025-05-06 03:32:00', '2025-05-06 03:32:00'),
(4, 'Books & Media', 'books-&-media', NULL, NULL, NULL, NULL, '1', '1', '0', '2025-05-06 03:32:09', '2025-05-06 03:32:09'),
(5, 'Beauty & Personal Care', 'beauty-&-personal-care', NULL, NULL, NULL, NULL, '1', '1', '0', '2025-05-06 03:32:18', '2025-05-06 03:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
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
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploadfile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `uploadfile`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'File 1', '1741774689.jpg', 'This is test Remark', 1, '2025-03-07 04:55:22', '2025-03-12 04:48:09'),
(3, 'File 3', '1741345993.jpg', 'File 3 Remark', 1, '2025-03-07 05:43:13', '2025-03-07 05:43:13'),
(4, 'File 4', '1741346083.jpg', 'File 4 Remark', 1, '2025-03-07 05:44:43', '2025-03-07 05:44:43');

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
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_shares`
--

INSERT INTO `file_shares` (`id`, `file_id`, `role_id`, `user_id`, `action_type`, `action_by`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 2, 'forwarded', 1, '2025-03-07 05:44:43', '2025-03-07 05:44:43'),
(2, 3, 1, 1, 'forwarded', 1, '2025-03-07 06:54:52', '2025-03-07 06:54:52'),
(3, 3, 2, 2, 'forwarded', 1, '2025-03-07 06:56:10', '2025-03-07 06:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_cat_id` longtext COLLATE utf8mb4_unicode_ci,
  `is_delete` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `slug`, `sub_cat_id`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Digital SLRs', 'digital-slrs', '[\"1\"]', '0', '1', '2025-05-15 05:11:49', '2025-05-15 05:11:49'),
(2, 'Point & shoot', 'point-&-shoot', '[\"1\"]', '0', '1', '2025-05-15 05:12:10', '2025-05-15 05:12:10'),
(3, 'Mirrorless Cameras', 'mirrorless-cameras', '[\"1\"]', '0', '1', '2025-05-15 05:12:22', '2025-05-15 05:12:22'),
(4, 'Camcorders', 'camcorders', '[\"1\"]', '0', '1', '2025-05-15 05:12:32', '2025-05-15 05:12:32'),
(5, 'Camera Lenses', 'camera-lenses', '[\"1\"]', '0', '1', '2025-05-15 05:12:58', '2025-05-15 05:12:58'),
(6, 'Action Cameras', 'action-cameras', '[\"1\"]', '0', '1', '2025-05-15 05:13:14', '2025-05-15 05:13:14'),
(7, 'Surveillance & Security Cameras', 'surveillance-&-security-cameras', '[\"1\"]', '0', '1', '2025-05-15 05:13:40', '2025-05-15 05:13:40'),
(8, '360 degree cameras', '360-degree-cameras', '[\"1\"]', '0', '1', '2025-05-15 05:13:54', '2025-05-15 05:13:54'),
(9, 'Spy cameras', 'spy-cameras', '[\"1\"]', '0', '1', '2025-05-15 05:14:08', '2025-05-15 05:14:08'),
(10, 'Cases & Covers', 'cases-&-covers', '[\"2\"]', '0', '1', '2025-05-15 05:14:29', '2025-05-15 05:14:29'),
(11, 'Screen guards', 'screen-guards', '[\"2\"]', '0', '1', '2025-05-15 05:14:44', '2025-05-15 05:14:44'),
(12, 'Power Banks', 'power-banks', '[\"2\"]', '0', '1', '2025-05-15 05:14:54', '2025-05-15 05:14:54'),
(13, 'Headsets', 'headsets', '[\"2\"]', '0', '1', '2025-05-15 05:15:05', '2025-05-15 05:15:05'),
(14, 'Data Cables', 'data-cables', '[\"2\"]', '0', '1', '2025-05-15 05:15:16', '2025-05-15 05:15:16'),
(15, 'Chargers', 'chargers', '[\"2\"]', '0', '1', '2025-05-15 05:15:27', '2025-05-15 05:15:27'),
(16, 'Selfie Sticks', 'selfie-sticks', '[\"2\"]', '0', '1', '2025-05-15 05:15:45', '2025-05-15 05:15:45'),
(17, 'Skin Stickers', 'skin-stickers', '[\"2\"]', '0', '1', '2025-05-15 05:15:57', '2025-05-15 05:15:57'),
(18, 'Internal Batteries', 'internal-batteries', '[\"2\"]', '0', '1', '2025-05-15 05:16:11', '2025-05-15 05:16:11'),
(19, 'Mounts & Stands', 'mounts-&-stands', '[\"2\"]', '0', '1', '2025-05-15 05:16:22', '2025-05-15 05:16:22'),
(20, 'Lens Kits', 'lens-kits', '[\"2\"]', '0', '1', '2025-05-15 05:16:32', '2025-05-15 05:16:32'),
(21, 'Replacement Parts', 'replacement-parts', '[\"2\"]', '0', '1', '2025-05-15 05:16:45', '2025-05-15 05:16:45'),
(22, 'Smart & Ultra HD', 'smart-&-ultra-hd', '[\"5\"]', '0', '1', '2025-05-21 05:03:16', '2025-05-21 05:03:16'),
(23, 'Shoes', 'shoes', '[\"6\"]', '0', '1', '2025-05-21 05:20:55', '2025-05-21 05:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

DROP TABLE IF EXISTS `masters`;
CREATE TABLE IF NOT EXISTS `masters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `order`, `is_home`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Users', NULL, '0', '1', '0', '2025-04-22 06:01:01', '2025-04-22 00:56:30'),
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
(17, 'Item Types', NULL, '1', '1', '0', '2025-05-06 07:10:32', '2025-05-06 07:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(23, '2025_05_13_121357_create_brands_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int DEFAULT NULL,
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(49, 'item type delete', 17, '0', '2025-05-06 07:05:35', '2025-05-06 07:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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
  `pid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` int DEFAULT NULL,
  `sub_cat_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  `base_price` float DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_trending` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `highlights` longtext COLLATE utf8mb4_unicode_ci,
  `specifications` longtext COLLATE utf8mb4_unicode_ci,
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `pid`, `title`, `slug`, `sub_title`, `cat_id`, `sub_cat_id`, `item_id`, `price`, `base_price`, `image`, `is_featured`, `is_trending`, `description`, `highlights`, `specifications`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(2, 'PID0006', 'Canon R100 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 'canon-r100-mirrorless-camera-rf-s-18-45mm-f/4.5-6.3-is-stm--(black)', 'Canon R100 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 2, 1, 1, 22499, 65995, '1747744798.jpg', '1', '1', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '0', '1', '2025-05-19 07:15:53', '2025-05-21 00:04:46'),
(3, 'PID0005', 'Canon R100 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 'canon-r100-mirrorless-camera-rf-s-18-45mm-f/4.5-6.3-is-stm--(black)', 'Canon R100 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 2, 1, 1, 22499, 65995, '1747744798.jpg', '1', '1', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '<p><br></p><p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">This Canon R100 Mirrorless Camera features a RF-S 18-45 mm lens, which provides a wide range of focal lengths for capturing everything from landscapes to portraits. With its mirrorless design, this camera offers fast and accurate autofocus, as well as the ability to shoot in low-light conditions. With Creative Assist Mode, Hybrid Auto Mode, and Silent Mode for Quiet Operation, this camera is sure to impress with its performance and image quality.</span></p>', '0', '1', '2025-05-19 07:15:53', '2025-05-20 07:32:16'),
(4, 'PID0010', 'Canon R500 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 'canon-r500-mirrorless-camera-rf-s-18-45mm-f/4.5-6.3-is-stm--(black)', 'Canon R100 Mirrorless Camera RF-S 18-45mm f/4.5-6.3 IS STM  (Black)', 2, 1, 1, 200, 65995, '1747819623.jpg', '1', '1', '<p>ASAS</p>', '<p>ASAS</p>', '<p>ASSAs</p>', '0', '1', '2025-05-21 03:56:29', '2025-05-26 04:22:10'),
(5, 'PID0009', 'Canon EOS 3000D DSLR Camera 1 Body, 18 - 55 mm Lens  (Black)', 'canon-eos-3000d-dslr-camera-1-body,-18---55-mm-lens--(black)', NULL, 2, 1, 1, 30990, 35990, '1747915622.webp', '1', '1', '<p><span style=\"color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\">If you are a photography enthusiast, then the Canon EOS 3000D DSLR Camera is a must-have gadget. Featuring an 18 MP (APS-C) CMOS sensor and the DIGIC 4+ imaging processor, you can capture amazing photos of your subject at all times, even in low-light conditions. Moreover, the remote Live View function lets you control this camera remotely using your smartphone so you can capture amazing photos even from a distance.</span></p>', '<ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\"><li class=\"_7eSDEz\" style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Self-Timer, Type C and Mini HDMI, 9 Auto Focus Points, 3x Optical Zoom, WiFi, Full HD, Video Recording at 1080 p on 30fps, APS-C CMOS sensor-which is 25 times larger than a typical Smartphone sensor.</li><li class=\"_7eSDEz\" style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Effective Pixels: 18 MP</li><li class=\"_7eSDEz\" style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Sensor Type: CMOS</li><li class=\"_7eSDEz\" style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">WiFi Available</li><li class=\"_7eSDEz\" style=\"margin: 0px; padding: 0px 0px 0px 16px; list-style: none; position: relative;\">Full HD</li></ul>', '<div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">In The Box</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"Izz52n col col-12-12\" style=\"margin: 0px; padding: 0px; width: 747.672px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">1 dslr_camera</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">General</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Brand</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Canon</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Model Number</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">EOS 3000D</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Model Name</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">EOS</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">SLR Variant</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">1 Body, 18 - 55 mm Lens</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Brand Color</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Black</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Type</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">DSLR</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Color</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Black</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Effective Pixels</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">18 MP</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Tripod Socket</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Yes</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Wifi</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Yes</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">GPS</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">No</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Sensor Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Sensor Type</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">CMOS</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Image Sensor Size</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">22.3 x 14.9mm</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Lens Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Optical Zoom</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">35x</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Lens Mount</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Canon EF Mount</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Dust Reduction</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Yes</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Viewfinder Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Viewfinder Coverage</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Approximate: 95 %</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Shutter Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Shutter Speed</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">1/4000 sec</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Self-timer</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Yes</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Image Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Image Format</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">JPEG, RAW (14-bit Canon original)</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Video Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Video Resolution</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">1920 x 1080</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Video Quality</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Full HD</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Display Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Display Type</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Digital, single-lens reflex, AF / AE camera with built-in flash</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Display Size</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">2 cm</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Touch Screen</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">No</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Storage Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Compatible Card</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">SD Card</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Power Features</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Battery Type</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Lithium Battery</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Dimensions</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Width</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">129 mm</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Height</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">101.6 mm</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Depth</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">77.1 mm</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Weight</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">475 g</li></ul></td></tr></tbody></table></div><div class=\"GNDEQ-\" style=\"margin: 0px; padding: 24px 24px 34px; border-top: 1px solid rgb(240, 240, 240); font-size: 14px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif;\"><div class=\"_4BJ2V+\" style=\"margin: 0px; padding: 0px 0px 16px; font-size: 18px; text-wrap-mode: nowrap; line-height: 1.4;\">Warranty</div><table class=\"_0ZhAN9\" style=\"margin: 0px; padding: 0px; width: 747.672px;\"><tbody style=\"margin: 0px; padding: 0px;\"><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Warranty Summary</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">2 Year Warranty (1 year standard warranty + 1 year additional warranty from the date of purchase made by the customer.)</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Service Type</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Carry In</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px 0px 16px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Covered in Warranty</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Warranty of the product is limited to only manufacturing defect on camera body &amp; lens.</li></ul></td></tr><tr class=\"WJdYP6 row\" style=\"margin: 0px; padding: 0px; flex-direction: row; width: 747.672px;\"><td class=\"+fFi1w col col-3-12\" style=\"margin: 0px; padding: 0px 8px 0px 0px; width: 186.906px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Not Covered in Warranty</td><td class=\"Izz52n col col-9-12\" style=\"margin: 0px; padding: 0px; width: 560.75px; display: inline-block; vertical-align: top; line-height: 1.4; word-break: break-word;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><li class=\"HPETK2\" style=\"margin: 0px; padding: 0px; list-style: none;\">Warranty does not cover any external accessories (such as battery, cable, carrying bag), damage caused to the product due to improper installation by customer.</li></ul></td></tr></tbody></table></div>', '0', '1', '2025-05-22 06:37:02', '2025-05-26 04:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `reviews` text COLLATE utf8mb4_unicode_ci,
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_book_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `user_name`, `email`, `rating`, `reviews`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Admin', 'admin@gmail.com', 5, 'This camera is best in this price range.', '0', '2025-05-19 07:15:53', '2025-05-19 07:15:53'),
(2, 4, 1, 'Admin', 'admin@gmail.com', 5, 'Product 1 is best product in this price range.', '0', '2025-05-21 03:56:29', '2025-05-21 03:56:29'),
(3, 5, 1, 'Admin', 'admin@gmail.com', 5, 'This is best Product', '0', '2025-05-22 06:37:02', '2025-05-22 06:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=548 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(30, 8, 18, NULL, NULL),
(31, 8, 6, NULL, NULL),
(32, 8, 10, NULL, NULL),
(33, 8, 14, NULL, NULL),
(139, 9, 28, NULL, NULL),
(140, 9, 30, NULL, NULL),
(141, 9, 29, NULL, NULL),
(142, 9, 27, NULL, NULL),
(143, 9, 24, NULL, NULL),
(144, 9, 26, NULL, NULL),
(145, 9, 25, NULL, NULL),
(146, 9, 23, NULL, NULL),
(147, 9, 7, NULL, NULL),
(148, 9, 9, NULL, NULL),
(149, 9, 8, NULL, NULL),
(150, 9, 6, NULL, NULL),
(151, 9, 1, NULL, NULL),
(152, 9, 19, NULL, NULL),
(153, 9, 2, NULL, NULL),
(154, 9, 18, NULL, NULL),
(155, 9, 22, NULL, NULL),
(156, 9, 11, NULL, NULL),
(157, 9, 13, NULL, NULL),
(158, 9, 12, NULL, NULL),
(159, 9, 10, NULL, NULL),
(160, 9, 15, NULL, NULL),
(161, 9, 17, NULL, NULL),
(162, 9, 16, NULL, NULL),
(163, 9, 14, NULL, NULL),
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
(513, 1, 14, NULL, NULL),
(515, 1, 15, NULL, NULL),
(516, 1, 16, NULL, NULL),
(517, 1, 17, NULL, NULL),
(526, 1, 40, NULL, NULL),
(529, 1, 39, NULL, NULL),
(530, 1, 41, NULL, NULL),
(532, 1, 35, NULL, NULL),
(533, 2, 43, NULL, NULL),
(534, 2, 45, NULL, NULL),
(535, 2, 44, NULL, NULL),
(536, 2, 42, NULL, NULL),
(537, 2, 41, NULL, NULL),
(538, 2, 40, NULL, NULL),
(539, 1, 38, NULL, NULL),
(544, 1, 46, NULL, NULL),
(545, 1, 49, NULL, NULL),
(546, 1, 47, NULL, NULL),
(547, 1, 48, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_iframe` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `email`, `phone`, `address`, `post_code`, `header_logo`, `footer_logo`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `map_iframe`, `created_at`, `updated_at`) VALUES
(1, 'Melody', 'No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no', 'info@example.com', '01234567890', '123 Street, New York, USA', '110067', '1744890030_6800e8aea0794.svg', '1744890030_6800e8aea0d5b.svg', 'https://www.facebook.com/', 'https://x.com/', 'https://www.linkedin.com/', 'https://www.instagram.com/', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12001247.519305438!2d-75.770041!3d42.74622!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1744889821973!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '0000-00-00 00:00:00', '2025-04-17 06:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int DEFAULT NULL,
  `is_home` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Publish, 0=Unpublish',
  `is_delete` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Delete, 0=Not Delete',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `cat_id`, `image`, `thumbnail`, `description`, `order`, `is_home`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cameras', 'cameras', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-15 05:07:10', '2025-05-15 05:07:10'),
(2, 'Mobile Accessories', 'mobile-accessories', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-15 05:08:03', '2025-05-15 05:08:03'),
(3, 'Men Clothings', 'men-clothings', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-15 05:11:01', '2025-05-15 05:11:01'),
(4, 'Women Clothings', 'women-clothings', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-15 05:11:16', '2025-05-15 05:11:16'),
(5, 'TVs & Appliances', 'tvs-&-appliances', 2, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-21 05:02:28', '2025-05-21 05:02:28'),
(6, 'Footwear', 'footwear', 1, NULL, NULL, NULL, NULL, '1', '0', '1', '2025-05-21 05:19:09', '2025-05-21 05:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '	1=Active, 0=Inactive',
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
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
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `quantity` int DEFAULT NULL,
  `is_delete` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variants_product_id_foreign` (`product_id`)
) ;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `product_id`, `color`, `size`, `images`, `quantity`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(7, 3, 'Black', NULL, '[\"1747744798-682c781e30046.jpg\"]', 500, '0', '1', '2025-05-20 06:07:10', '2025-05-20 07:41:35'),
(8, 2, 'Red', NULL, '[\"1747744798-682c781e29b03.jpg\",\"1747744798-682c781e29e58.jpg\",\"1747744798-682c781e2a1bc.jpg\"]', 100, '0', '1', '2025-05-20 05:31:04', '2025-05-20 07:09:58'),
(9, 3, 'Blue', NULL, '[\"1747744798-682c781e2ecec.jpg\",\"1747744798-682c781e2efc2.jpg\"]', 300, '0', '1', '2025-05-20 05:31:04', '2025-05-20 07:40:55'),
(10, 4, 'Black', NULL, '[\"1747819589-682d9c450a7dd.jpg\",\"1747819589-682d9c450ac72.jpg\",\"1747819589-682d9c450ae68.jpg\"]', 500, '0', '1', '2025-05-21 03:56:29', '2025-05-21 03:56:29'),
(11, 4, 'Red', NULL, '[\"1747819589-682d9c450c329.jpg\",\"1747819589-682d9c450c550.jpg\",\"1747819589-682d9c450c746.jpg\",\"1747819589-682d9c450c931.jpg\"]', 200, '0', '1', '2025-05-21 03:56:29', '2025-05-21 03:56:29'),
(12, 5, 'Black', NULL, '[\"1747915622-682f136689d39.jpeg\"]', 200, '0', '1', '2025-05-22 06:37:02', '2025-05-22 06:37:02');

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

--
-- Constraints for table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
