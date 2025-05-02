-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 02:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `street` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `postal_code` varchar(191) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `street`, `city`, `state`, `country`, `postal_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'asasasaSAS fgfgdg', 'sasas', 'asas', 'sasa', '2323', '1', '2025-04-08 03:32:23', '2025-04-08 03:54:44'),
(2, 6, 'asas', 'sasas', 'asas', 'sasa', '2323', '1', '2025-04-08 03:52:50', '2025-04-08 03:52:50'),
(3, 6, 'asas', 'sasas', 'asas', 'sasa', '2323', '1', '2025-04-08 03:52:57', '2025-04-08 03:52:57'),
(4, 6, 'asasasaSAS fgfgdg', 'sasas', 'asas', 'sasa', '2323', '1', '2025-04-08 06:49:23', '2025-04-08 06:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dresses', '1743160399.jpg', 'Category 1 Description', '1', '2025-03-13 01:07:49', '2025-03-28 05:43:19'),
(2, 'Shoes', '1743160565.jpg', 'Category 2 Description', '1', '2025-03-19 06:51:38', '2025-03-28 05:46:05'),
(3, 'Blazers', '1743160592.jpg', NULL, '0', '2025-03-28 05:46:32', '2025-03-28 05:49:21'),
(4, 'Beauty', '1743160657.jpg', NULL, '1', '2025-03-28 05:47:37', '2025-03-28 05:47:37'),
(5, 'Camera', '1743160677.jpg', NULL, '1', '2025-03-28 05:47:57', '2025-03-28 05:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) NOT NULL,
  `uploadfile` varchar(191) NOT NULL,
  `remark` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `file_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action_type` varchar(191) DEFAULT NULL,
  `action_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_shares`
--

INSERT INTO `file_shares` (`id`, `file_id`, `role_id`, `user_id`, `action_type`, `action_by`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 2, 'forwarded', 1, '2025-03-07 05:44:43', '2025-03-07 05:44:43'),
(2, 3, 1, 1, 'forwarded', 1, '2025-03-07 06:54:52', '2025-03-07 06:54:52'),
(3, 3, 2, 2, 'forwarded', 1, '2025-03-07 06:56:10', '2025-03-07 06:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

CREATE TABLE `masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masters`
--

INSERT INTO `masters` (`id`, `name`, `type`, `order`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Users', 'menu', 2, NULL, NULL, '1', '2025-04-17 07:47:29', '2025-04-17 07:47:29'),
(2, 'Categories', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:48:31', '2025-04-17 07:48:31'),
(3, 'Products', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:48:41', '2025-04-17 07:48:41'),
(4, 'Roles', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:48:50', '2025-04-17 07:48:50'),
(5, 'Permissions', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:48:57', '2025-04-17 07:48:57'),
(6, 'Files', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:49:04', '2025-04-17 07:49:04'),
(7, 'Settings', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:49:12', '2025-04-17 07:49:12'),
(8, 'Masters', 'menu', NULL, NULL, NULL, '1', '2025-04-17 07:49:19', '2025-04-17 07:50:46'),
(9, 'Menus', 'menu', NULL, NULL, NULL, '1', '2025-04-17 08:09:49', '2025-04-18 06:01:29'),
(10, 'Brands', 'menu', NULL, NULL, NULL, '1', '2025-04-18 04:47:18', '2025-04-18 06:01:23'),
(11, 'FabIndia', 'brand', NULL, '1744977372_68023ddc68cc1.jpg', 'FabIndia is one of the top 10 clothing brands in India. It is known for its ethnic wear, home furnishings, and accessories. The brand emphasizes traditional craftsmanship, promoting handmade and handwoven products. It is committed to providing sustainable and handmade products and promoting traditional Indian crafts.', '1', '2025-04-18 06:26:12', '2025-04-18 06:26:12'),
(12, 'Manyavar', 'brand', NULL, '1744977396_68023df4c6bcf.jpg', 'Manyavar is among the top 100 clothing brands in India. It is known for capturing the essence of grand celebrations. This brand is mainly focused on traditional and ceremonial wear for men, capturing the essence of Indian weddings and festivals. It is one of the leading Indian clothing brands for ethnic menswear in India.', '1', '2025-04-18 06:26:36', '2025-04-18 06:26:36'),
(13, 'Allen Solly', 'brand', NULL, '1744977565_68023e9d2b64c.jpg', 'Allen Solly is one of the most versatile Indian clothing brands, known for both formal and casual Western wear for men and women. It aims to bring a modern touch to workwear and everyday fashion. It blends sophistication with contemporary fashion, offering a wide range of styles for various occasions.', '1', '2025-04-18 06:26:53', '2025-04-18 06:29:25'),
(14, 'Van Heusen', 'brand', NULL, '1744979065_680244792a78f.jpg', 'Van Heusen is a brand famous for providing sophisticated formal and semi-formal wear for both men and women. It is known for its tailored and refined designs, catering to professionals and individuals with a taste for elegant fashion. It is one of the top 10 clothing brands in India.', '1', '2025-04-18 06:27:19', '2025-04-18 06:54:25'),
(15, 'W for Woman', 'brand', NULL, '1744977460_68023e348690b.jpg', 'W for Woman is a brand that speaks to the modern woman’s desire for fashion that embraces both style and ease. This brand in the list of top clothing brands in India combines traditional Indian aesthetics with modern designs. It caters to the diverse fashion needs of women. W for Woman offers a mix of ethnic and contemporary women’s wear. It is one of the top female clothing brands in India.', '1', '2025-04-18 06:27:40', '2025-04-18 06:27:40'),
(16, 'Flying Machine', 'brand', NULL, '1744977485_68023e4d2099b.jpg', 'Flying Machine is a youth-oriented brand known for its trendy denim and casual wear. It captures the essence of casual and stylish clothing for youth. From trendy jeans to casual apparel, this Indian clothing brand embodies the dynamic and modern fashion preferences of the younger generation. It is India’s first homegrown denim brand.', '1', '2025-04-18 06:28:05', '2025-04-18 06:28:05'),
(17, 'Spykar', 'brand', NULL, '1744977504_68023e6026154.jpg', 'Spykar is a name synonymous with urban fashion. It is one of the top clothing brands in India. It mainly focuses on denim and casual wear, catering to an urban and fashion-forward audience. This is one of the largest and fastest-growing Indian clothing brands. It is known for its trendy denim products and contemporary casual wear.', '1', '2025-04-18 06:28:24', '2025-04-18 06:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(19, '2025_04_17_123759_create_masters_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 'product create', 3, '2025-02-21 07:19:13', '2025-04-18 01:12:23'),
(2, 'product edit', 3, '2025-02-21 07:19:13', '2025-04-18 01:12:16'),
(6, 'permission list', 5, '2025-02-24 04:22:35', '2025-04-18 01:12:52'),
(7, 'permission create', 5, '2025-02-24 04:22:50', '2025-04-18 01:13:00'),
(8, 'permission edit', 5, '2025-02-24 04:22:57', '2025-04-18 01:13:23'),
(9, 'permission delete', 5, '2025-02-24 04:23:03', '2025-04-18 01:13:07'),
(10, 'role list', 4, '2025-02-24 04:23:10', '2025-04-18 01:13:15'),
(11, 'role create', 4, '2025-02-24 04:23:17', '2025-04-18 01:12:42'),
(12, 'role edit', 4, '2025-02-24 04:23:24', '2025-04-18 01:12:31'),
(13, 'role delete', 1, '2025-02-24 04:23:31', '2025-04-18 01:13:51'),
(14, 'user list', 1, '2025-02-24 04:23:37', '2025-04-18 01:13:42'),
(15, 'user create', 1, '2025-02-24 04:23:44', '2025-04-18 01:13:32'),
(16, 'user edit', 1, '2025-02-24 04:23:51', '2025-04-18 01:15:06'),
(17, 'user delete', 1, '2025-02-24 04:23:57', '2025-04-18 01:14:56'),
(18, 'product list', 3, '2025-02-24 04:24:09', '2025-04-18 01:14:48'),
(19, 'product delete', 3, '2025-02-24 04:25:02', '2025-04-18 01:14:40'),
(22, 'product review', 3, '2025-03-05 06:42:26', '2025-04-18 01:14:32'),
(23, 'file list', 6, '2025-03-07 04:11:25', '2025-04-18 01:14:23'),
(24, 'file create', 6, '2025-03-07 04:11:36', '2025-04-18 01:14:15'),
(25, 'file edit', 6, '2025-03-07 04:11:44', '2025-04-18 01:14:08'),
(26, 'file delete', 6, '2025-03-07 04:11:59', '2025-04-18 01:12:08'),
(27, 'category list', 2, '2025-03-13 00:47:46', '2025-04-18 01:11:51'),
(28, 'category create', 2, '2025-03-13 00:48:00', '2025-04-18 01:11:42'),
(29, 'category edit', 2, '2025-03-13 00:48:12', '2025-04-18 01:11:35'),
(30, 'category delete', 2, '2025-03-13 00:48:26', '2025-04-18 01:11:29'),
(31, 'settings', NULL, '2025-04-17 02:54:28', '2025-04-18 04:15:01'),
(32, 'site settings', 7, '2025-04-17 06:55:34', '2025-04-17 08:03:53'),
(33, 'masters', NULL, '2025-04-17 07:03:41', '2025-04-18 04:15:10'),
(34, 'menu list', 9, '2025-04-17 07:04:16', '2025-04-17 08:10:16'),
(35, 'menu create', 9, '2025-04-17 07:04:28', '2025-04-17 08:10:25'),
(36, 'menu edit', 9, '2025-04-17 07:04:41', '2025-04-17 08:10:08'),
(37, 'menu delete', 9, '2025-04-17 07:04:56', '2025-04-17 08:10:00'),
(38, 'brand list', 10, '2025-04-18 04:34:17', '2025-04-18 06:00:07'),
(39, 'brand create', 10, '2025-04-18 04:35:27', '2025-04-18 06:00:16'),
(40, 'brand edit', 10, '2025-04-18 06:00:41', '2025-04-18 06:00:41'),
(41, 'brand delete', 10, '2025-04-18 06:00:55', '2025-04-18 06:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pid` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `category` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `price` varchar(191) NOT NULL,
  `is_featured` enum('1','0') NOT NULL DEFAULT '0',
  `is_trending` enum('1','0') NOT NULL DEFAULT '0',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `short_description` text DEFAULT NULL,
  `full_description` longtext DEFAULT NULL,
  `add_description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `pid`, `name`, `category`, `image`, `images`, `price`, `is_featured`, `is_trending`, `status`, `short_description`, `full_description`, `add_description`, `created_at`, `updated_at`) VALUES
(1, 'PID0001', 'Motorola Edge 50 Fusion', 'Camera', NULL, '[\"1743512575-67ebe3ffe7f89.jpg\",\"1743512575-67ebe3ffe84b5.jpg\",\"1743512575-67ebe3ffe88e9.jpg\",\"1743512575-67ebe3ffe8c49.jpg\"]', '22499', '1', '1', '1', 'Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit clita ea. Sanc ipsum et, labore clita lorem magna duo dolor no sea Nonumy.', '<h4 class=\"mb-3\" style=\"font-family: Roboto, sans-serif; font-weight: 500; line-height: 1.2; color: rgb(61, 70, 77); font-size: 1.5rem;\"><br></h4><div><div class=\"_0B07y7 sR34dU Zhp430\" style=\"margin: 0px auto 5px 0px; padding: 0px 0px 0px 32px; text-align: center; float: right; overflow: hidden; width: 200px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\"><img src=\"https://rukminim2.flixcart.com/image/200/200/cms-rpd-images/febe48a7edf74c8eb42f4c4ffb6303de_16bbd00c3ee_image.jpeg?q=90\" style=\"margin: 0px; padding: 0px; color: inherit; border-width: initial; border-color: initial; border-image: initial; outline: none; max-width: 100%;\"></div><div style=\"margin: 0px; padding: 0px; color: rgb(33, 33, 33); font-family: Inter, -apple-system, Helvetica, Arial, sans-serif; font-size: 14px;\"><div class=\"_9GQWrZ\" style=\"margin: 0px; padding: 0px 0px 10px; font-size: 20px;\">4000 mAH Two-day Battery</div><div class=\"AoD2-N\" style=\"margin: 0px; padding: 0px; line-height: 1.29;\"><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\">It comes with a long battery life, so you can enjoy uninterrupted performance anywhere and at any time. The 4000 mAH battery also provides a standby time of up to 19 days. Also, it supports 10 W fast charging. This is extremely helpful if you are in a rush and you want to charge your phone quickly before you start the day.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\"><br></p><div class=\"_0B07y7 IqfVRM Zhp430\" style=\"margin: 0px auto 5px 0px; padding: 0px 32px 0px 0px; text-align: center; float: left; overflow: hidden; width: 200px;\"><img src=\"https://rukminim2.flixcart.com/image/200/200/cms-rpd-images/5a80bd40eeff456e8e8dfc76cb6cfde7_16bbcff8fb0_image.jpeg?q=90\" style=\"border-width: initial; border-color: initial; border-image: initial; margin: 0px; padding: 0px; color: inherit; outline: none; max-width: 100%; width: 100%; float: left;\" class=\"note-float-left\"></div><div style=\"margin: 0px; padding: 0px;\"><div class=\"_9GQWrZ\" style=\"margin: 0px; padding: 0px 0px 10px; font-size: 20px;\">Qualcomm Snapdragon 439 Octa-core Processor</div><div class=\"AoD2-N\" style=\"margin: 0px; padding: 0px; line-height: 1.29;\"><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px;\">The Redmi 7A comes with a Qualcomm Snapdragon 439 Octa-core Processor. So, whether you are watching videos or browsing the web you can experience a faster and seamless performance.</p></div></div></div></div></div>', '<h4 class=\"mb-3\" style=\"font-weight: 500; line-height: 1.2; color: rgb(61, 70, 77); font-size: 1.5rem; font-family: Roboto, sans-serif;\"><span style=\"color: rgb(108, 117, 125); font-size: 16px; font-weight: initial;\">Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</span></h4><div class=\"row\" style=\"margin-right: -15px; margin-left: -15px; color: rgb(108, 117, 125); font-family: Roboto, sans-serif;\"><div class=\"col-md-6\" style=\"width: 630.5px; padding-right: 15px; padding-left: 15px;\"><ul class=\"list-group list-group-flush\"><li class=\"list-group-item px-0\" style=\"border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: rgba(0, 0, 0, 0.125); border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Sit erat duo lorem duo ea consetetur, et eirmod takimata.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Amet kasd gubergren sit sanctus et lorem eos sadipscing at.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Duo amet accusam eirmod nonumy stet et et stet eirmod.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-bottom-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.</li></ul></div><div class=\"col-md-6\" style=\"width: 630.5px; padding-right: 15px; padding-left: 15px;\"><ul class=\"list-group list-group-flush\"><li class=\"list-group-item px-0\" style=\"border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: rgba(0, 0, 0, 0.125); border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Sit erat duo lorem duo ea consetetur, et eirmod takimata.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Amet kasd gubergren sit sanctus et lorem eos sadipscing at.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Duo amet accusam eirmod nonumy stet et et stet eirmod.</li><li class=\"list-group-item px-0\" style=\"border-top-width: 0px; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-color: rgba(0, 0, 0, 0.125); border-bottom-color: rgba(0, 0, 0, 0.125); border-left-color: rgba(0, 0, 0, 0.125);\">Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.</li></ul></div></div>', '2025-04-01 07:29:20', '2025-04-16 06:24:43'),
(2, 'PID0002', 'Product 1', 'Dresses', NULL, '[\"1744263339-67f758abd4dca.jpg\",\"1744263320-67f75898ba968.jpg\",\"1744263320-67f75898babe3.jpg\",\"1744263320-67f75898bae72.jpg\"]', '22499', '1', '1', '1', NULL, NULL, NULL, '2025-04-10 00:05:20', '2025-04-10 00:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pid` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `reviews` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `pid`, `user_id`, `user_name`, `email`, `rating`, `reviews`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Admin', 'admin@gmail.com', 4, 'Motorola Edge 50 Fusion is best product in this price range.', '2025-04-03 07:01:54', '2025-04-03 07:01:54'),
(2, 2, 1, 'Admin', 'admin@gmail.com', 5, 'Product 1 is best product in this price range.', '2025-04-10 00:05:20', '2025-04-10 00:05:20'),
(3, 1, 6, 'Shanu Kashyap', 'shanukashyap244@gmail.com', 5, 'Motorola Edge 50 Fusion is best product in this price range.', '2025-04-11 08:13:43', '2025-04-11 08:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(2, 'Author', '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(3, 'User', '2025-02-21 07:19:13', '2025-02-24 01:49:33'),
(8, 'Test', '2025-02-24 04:52:55', '2025-02-24 04:52:55'),
(9, 'Demo Role', '2025-03-25 07:24:32', '2025-03-25 07:24:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(2, 1, 2, NULL, NULL),
(16, 1, 19, NULL, NULL),
(17, 1, 18, NULL, NULL),
(19, 1, 9, NULL, NULL),
(20, 1, 8, NULL, NULL),
(21, 1, 6, NULL, NULL),
(23, 1, 13, NULL, NULL),
(24, 1, 12, NULL, NULL),
(25, 1, 10, NULL, NULL),
(27, 1, 17, NULL, NULL),
(28, 1, 16, NULL, NULL),
(29, 1, 14, NULL, NULL),
(30, 8, 18, NULL, NULL),
(31, 8, 6, NULL, NULL),
(32, 8, 10, NULL, NULL),
(33, 8, 14, NULL, NULL),
(43, 1, 1, NULL, NULL),
(44, 1, 7, NULL, NULL),
(45, 1, 11, NULL, NULL),
(46, 1, 15, NULL, NULL),
(56, 1, 22, NULL, NULL),
(57, 1, 24, NULL, NULL),
(58, 1, 26, NULL, NULL),
(59, 1, 25, NULL, NULL),
(60, 1, 23, NULL, NULL),
(62, 1, 28, NULL, NULL),
(63, 1, 30, NULL, NULL),
(64, 1, 29, NULL, NULL),
(65, 1, 27, NULL, NULL),
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
(209, 1, 32, NULL, NULL),
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
(308, 1, 34, NULL, NULL),
(309, 1, 35, NULL, NULL),
(310, 1, 36, NULL, NULL),
(312, 1, 38, NULL, NULL),
(313, 1, 37, NULL, NULL),
(316, 1, 39, NULL, NULL),
(317, 1, 41, NULL, NULL),
(318, 1, 40, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `post_code` varchar(191) DEFAULT NULL,
  `header_logo` varchar(191) DEFAULT NULL,
  `footer_logo` varchar(191) DEFAULT NULL,
  `facebook_url` varchar(191) DEFAULT NULL,
  `twitter_url` varchar(191) DEFAULT NULL,
  `linkedin_url` varchar(191) DEFAULT NULL,
  `instagram_url` varchar(191) DEFAULT NULL,
  `map_iframe` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `email`, `phone`, `address`, `post_code`, `header_logo`, `footer_logo`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `map_iframe`, `created_at`, `updated_at`) VALUES
(1, 'Melody', 'No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no', 'info@example.com', '01234567890', '123 Street, New York, USA', '110067', '1744890030_6800e8aea0794.svg', '1744890030_6800e8aea0d5b.svg', 'https://www.facebook.com/', 'https://x.com/', 'https://www.linkedin.com/', 'https://www.instagram.com/', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12001247.519305438!2d-75.770041!3d42.74622!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1744889821973!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '0000-00-00 00:00:00', '2025-04-17 06:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `pin_code` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `image`, `state`, `city`, `pin_code`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '8423551271', 'Demo Address', '1741179188.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$uCH3PmmCcrLpd15FnIX88eDu5rgbu5Yet9Y1L4E3yAU0ww7ZT434O', NULL, '2025-02-21 07:19:13', '2025-03-05 07:23:08'),
(2, 'Author', 'author@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$0i0fsTFnUyBtqurjSI4NS.S3G/oLzGPH.eSQMyfEv7rLt3oTCDp4G', NULL, '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(3, 'User', 'user@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$onp/9.1OXXbfAFSPPFZta.RPRqde94HHKd.S.z/8/qjnzhVOapR6K', NULL, '2025-02-21 07:19:13', '2025-02-21 07:19:13'),
(4, 'Aman Kumar', 'aman@gmail.com', '9999999999', 'Demo Address', '1740394053.png', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$daOAexpIflWDiAZ6hXNfYuaVwOAso6FeXGlLrmEUj2L9aLl7VA/Mm', NULL, '2025-02-24 05:17:33', '2025-02-24 05:22:42'),
(5, 'asasas', 'amansasa@gmail.com', '9999999999', 'Demo Address', '1741167801.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$QtpNBgM92ptFqzT5yPkEIuSj9c2jPCoFFgYEFZy3tymPHG0UHMoh2', NULL, '2025-03-05 03:43:49', '2025-03-05 04:13:21'),
(6, 'Shanu Kashyap', 'shanukashyap244@gmail.com', '8423551271', 'Demo Address', '1744798946.jpg', 'Delhi', 'Munirika', '110067', NULL, '$2y$10$Sdz/JK113Oig6UsCY3P1ieOE9aQH/5KC9usfPWBB9zC5D2vOFfwd.', NULL, '2025-04-04 05:14:42', '2025-04-16 04:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(191) NOT NULL,
  `size` varchar(191) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `stock` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `product_id`, `color`, `size`, `price`, `images`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Red', 'MD', 22499, '[\"1743512575-67ebe3ffe7f89.jpg\",\"1743512575-67ebe3ffe84b5.jpg\",\"1743512575-67ebe3ffe88e9.jpg\",\"1743512575-67ebe3ffe8c49.jpg\"]', 5, '1', '2025-04-01 07:29:20', '2025-04-10 01:02:47'),
(2, 1, 'Black', 'SM', 22499, '[\"1743512649-67ebe4495b109.jpg\",\"1743512649-67ebe4495b4ad.jpg\",\"1743512649-67ebe4495b740.jpg\",\"1743512649-67ebe4495b9b9.jpg\"]', 5, '1', '2025-04-01 07:34:09', '2025-04-01 07:34:09'),
(3, 2, 'Black', 'XS', 22499, '[\"1744263339-67f758abd4dca.jpg\",\"1744263320-67f75898ba968.jpg\",\"1744263320-67f75898babe3.jpg\",\"1744263320-67f75898bae72.jpg\"]', 5, '1', '2025-04-10 00:05:20', '2025-04-10 00:05:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_shares`
--
ALTER TABLE `file_shares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_book_id_foreign` (`pid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_user_id_foreign` (`user_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variants_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `file_shares`
--
ALTER TABLE `file_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `masters`
--
ALTER TABLE `masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
