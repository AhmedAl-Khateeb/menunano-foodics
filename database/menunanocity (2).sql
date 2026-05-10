-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026 at 02:38 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `menunanocity`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` enum('present','absent','late','leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `shift_id`, `attendance_date`, `check_in`, `check_out`, `status`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 94, 1, '2026-04-18', '2026-04-18 02:34:00', '2026-04-18 00:54:35', 'present', 'ddddddddddddddd', '2026-04-21 22:34:40', '2026-04-17 22:54:35', NULL),
(2, 71, 2, '2026-04-18', '2026-04-18 00:42:00', '2026-04-18 00:51:16', 'present', 'تم إنشاء السجل تلقائيًا عند فتح الشيفت', '2026-04-19 22:43:19', '2026-04-17 22:51:17', NULL),
(3, 95, 3, '2026-04-18', '2026-04-18 00:56:00', '2026-04-18 00:57:12', 'present', 'تم إنشاء السجل تلقائيًا عند فتح الشيفت', '2026-04-17 22:56:44', '2026-04-17 22:57:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `created_by`, `name`, `code`, `phone`, `address`, `is_active`, `business_id`, `owner_id`, `created_at`, `updated_at`) VALUES
(1, 71, 'التجمع', '55', '01000000014', 'شارع التحرير، القاهرةr', 1, 71, 71, '2026-05-02 07:55:59', '2026-05-02 07:55:59'),
(2, 71, 'التحرير', '56', '01236987412', 'شارع التحرير، القاهرة', 1, 71, 71, '2026-05-02 08:13:28', '2026-05-02 08:13:28'),
(4, 71, 'الفيوم', '66', '01325369874', 'الفيوم المسله', 1, 71, 71, '2026-05-02 10:12:19', '2026-05-02 13:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `branch_creation_requests`
--

CREATE TABLE `branch_creation_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','paid','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_creation_requests`
--

INSERT INTO `branch_creation_requests` (`id`, `business_id`, `requested_by`, `branch_name`, `branch_code`, `phone`, `address`, `status`, `approved_by`, `approved_at`, `created_branch_id`, `created_at`, `updated_at`) VALUES
(1, 71, 71, 'التجمع', '55', '01000000014', 'شارع التحرير، القاهرةr', 'approved', 2, '2026-05-02 07:55:59', 1, '2026-05-02 07:48:15', '2026-05-02 07:55:59'),
(2, 71, 71, 'التحرير', '56', '01236987412', 'شارع التحرير، القاهرة', 'approved', 2, '2026-05-02 08:13:28', 2, '2026-05-04 08:13:14', '2026-05-02 08:13:28'),
(3, 71, 71, 'الفيوم', '66', '01325369874', 'الفيوم المسله', 'approved', 2, '2026-05-02 10:12:19', 4, '2026-05-02 09:46:00', '2026-05-02 10:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `branch_links`
--

CREATE TABLE `branch_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `from_branch_id` bigint(20) UNSIGNED NOT NULL,
  `to_branch_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'linked',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_links`
--

INSERT INTO `branch_links` (`id`, `business_id`, `from_branch_id`, `to_branch_id`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 71, 1, 4, 'main_sub_branch', 1, '2026-05-02 10:15:18', '2026-05-02 10:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `branch_users`
--

CREATE TABLE `branch_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manager',
  `is_primary_manager` tinyint(1) NOT NULL DEFAULT 0,
  `can_manage_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_users`
--

INSERT INTO `branch_users` (`id`, `branch_id`, `user_id`, `role`, `is_primary_manager`, `can_manage_permissions`, `permissions`, `assigned_by`, `created_at`, `updated_at`) VALUES
(1, 1, 71, 'owner', 1, 1, '[\"*\"]', 2, '2026-05-02 07:55:59', '2026-05-02 07:55:59'),
(2, 2, 71, 'owner', 1, 1, '[\"*\"]', 2, '2026-05-02 08:13:28', '2026-05-02 08:13:28'),
(4, 4, 71, 'owner', 1, 1, '[\"*\"]', 2, '2026-05-02 10:12:19', '2026-05-02 10:12:19'),
(5, 1, 96, 'cashier', 0, 0, '[\"orders.access\",\"orders.all\",\"orders.delivery\",\"orders.pickup\",\"orders.local\",\"pos.access\"]', 71, '2026-05-02 13:20:45', '2026-05-02 13:24:20'),
(6, 4, 97, 'manager', 1, 0, '[\"dashboard.access\",\"emenu.access\",\"categories.access\",\"products.access\",\"sliders.access\"]', 71, '2026-05-02 13:39:29', '2026-05-02 13:39:29');

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'video_link_1', 'https://www.youtube.com/watch?v=lxaHrOxbLRw', NULL, '2025-09-07 13:58:06'),
(2, 'video_link_2', 'https://www.youtube.com/watch?v=KyPKI3LLPtw', NULL, '2025-09-07 14:01:29'),
(3, 'description', 'that is not us', NULL, NULL),
(4, 'whatsapp', '+201069944482', NULL, '2025-12-01 12:08:25'),
(5, 'phone', '+201069944482', NULL, '2025-12-01 12:08:26'),
(6, 'main_image', 'settings/0WNPZMiGElYhKow2n3Us4fK4eJfHFr5lXsJoPTnd.png', NULL, '2025-08-31 13:29:28'),
(7, 'currency', 'جنيه', '2025-08-31 11:13:24', '2025-08-31 11:23:56');

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

CREATE TABLE `business_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_types`
--

INSERT INTO `business_types` (`id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'مطعم', 'rest', 1, '2026-04-16 19:03:55', '2026-04-16 19:03:55'),
(3, 'محاسب', 'acc', 1, '2026-04-16 19:04:53', '2026-04-16 21:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_size_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_transfers`
--

CREATE TABLE `cash_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('to_manager','to_next_shift','to_safe') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'to_manager',
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_transfers`
--

INSERT INTO `cash_transfers` (`id`, `from_shift_id`, `to_shift_id`, `branch_id`, `from_user_id`, `to_user_id`, `type`, `amount`, `status`, `approved_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 17, NULL, 1, 71, 71, 'to_manager', '150.00', 'approved', 71, 'تم تسليم مبلغ اثناء الشيفت', '2026-04-26 19:04:36', '2026-04-26 19:04:36'),
(2, 17, 18, 1, 71, 96, 'to_next_shift', '130.00', 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-26 19:22:59', '2026-04-26 19:53:09'),
(5, 18, NULL, 1, 96, 71, 'to_manager', '100.00', 'approved', 96, 'تم', '2026-04-26 20:04:33', '2026-04-26 20:04:33'),
(6, 18, 19, 1, 96, 96, 'to_next_shift', '20.00', 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-04-26 20:05:33', '2026-04-26 20:16:40'),
(7, 19, 21, 1, 96, 71, 'to_next_shift', '20.00', 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-04-26 20:17:01', '2026-04-27 17:18:42'),
(8, 21, 22, 1, 71, 71, 'to_next_shift', '20.00', 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-27 17:19:25', '2026-04-27 17:44:16'),
(9, 22, NULL, 1, 71, 71, 'to_manager', '100.00', 'approved', 71, 'تم', '2026-04-27 17:45:33', '2026-04-27 17:45:33'),
(10, 22, 23, 1, 71, 96, 'to_next_shift', '30.00', 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-27 17:45:59', '2026-05-02 13:29:16'),
(11, 23, 24, 1, 96, 96, 'to_next_shift', '30.00', 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 13:29:36', '2026-05-02 13:35:31'),
(12, 24, 25, 1, 96, 96, 'to_next_shift', '30.00', 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 13:37:50', '2026-05-02 14:40:17'),
(13, 25, NULL, 1, 96, NULL, 'to_next_shift', '30.00', 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 14:41:04', '2026-05-02 14:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menu',
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `type`, `cover`, `created_at`, `updated_at`, `is_active`, `store_id`) VALUES
(12, NULL, 'برجر', 'menu', '1755003614.jpg', '2025-08-12 13:00:14', '2025-08-12 13:00:14', 1, NULL),
(13, NULL, 'بيتزا', 'menu', '1755003964.jpg', '2025-08-12 13:06:04', '2025-08-12 13:06:04', 1, NULL),
(24, 8, 'testtttt', 'menu', 'images/category/kUlBBgDALaCIjjO7kcbV4rTA2yHt8eKrlyk2vvHm.png', '2025-08-31 09:07:34', '2025-08-31 09:07:34', 1, NULL),
(30, 48, 'محاشي', 'menu', 'images/category/bZRrLj3zcUC0NRmnfpV04nFOWBciL3UK0zanlzgK.png', '2025-09-01 10:54:42', '2025-09-01 10:54:42', 1, NULL),
(31, 48, 'مخاصي', 'menu', 'images/category/1AfTbMBuKyPoIdAFOmS8lcPjJ1WwMKHaTvDSILpU.png', '2025-09-01 10:55:11', '2025-09-01 10:55:11', 1, NULL),
(32, 48, 'مشاوي', 'menu', 'images/category/2oBBrnmYIEohMXJarNHA3hmhFawgUCitbGv0CQdI.jpg', '2025-09-01 10:55:36', '2025-09-01 10:55:36', 1, NULL),
(33, 48, 'مبايض', 'menu', 'images/category/kMJQEJQh3m0PGX672owb7u4XiT88YBS5NYPHuoTh.avif', '2025-09-01 10:56:06', '2025-09-01 10:56:06', 1, NULL),
(34, 50, 'Fast Food', 'menu', 'images/category/5jRRvUpfk39eqGYWhEGwaAlKXcoMF5AVELafm197.png', '2025-09-03 15:22:21', '2025-09-03 15:22:21', 1, NULL),
(88, 79, 'عطور', 'menu', 'images/category/rlOAcW1bU72pxFO6MjxxWYLLuFsR3wlRBFdw2ltY.jpg', '2025-12-02 21:18:56', '2025-12-02 21:19:22', 1, NULL),
(89, 71, 'مطعم نانو', 'menu', 'images/category/dv2G9HTk5mHRaOPL9YvX1tSJKNhVTV8K3sD959WM.jpg', '2025-12-03 15:23:12', '2025-12-04 19:49:17', 1, NULL),
(90, 71, 'عصاير نانو', 'menu', 'images/category/mmQPqucFoNfRi3xeYCyhV39ZzXw91ldcXgA4fr4X.jpg', '2025-12-04 20:00:06', '2025-12-04 20:09:59', 1, NULL),
(91, 71, 'كافي نانو', 'menu', 'images/category/DDybS0dJHavvQvEYcGeBXhezorIoijEt29FYXUzo.jpg', '2025-12-04 20:12:50', '2025-12-04 20:12:50', 1, NULL),
(92, 71, 'عطور نانو', 'menu', 'images/category/TgP8FhdwMKbDS2MJMNtth4KIhmROYbi9Nno0kDQz.png', '2025-12-04 20:22:39', '2025-12-04 20:22:39', 1, NULL),
(93, 80, 'Beef Burger', 'menu', 'images/category/h2p46eYHAYYvL5YRRKBaycIPiae68jaiiGhZvkxf.jpg', '2025-12-08 17:09:53', '2025-12-08 17:09:53', 1, NULL),
(94, 80, 'smash burger', 'menu', 'images/category/QUK5sAcvmflOMkwiwibv219bE0zp2AJImBww000q.jpg', '2025-12-08 17:10:59', '2025-12-08 17:10:59', 1, NULL),
(95, 80, 'chicken burger', 'menu', 'images/category/cXoCqkXTJ4HAB2yR7rU0EA4F9ur1x2IXkjJoEpPU.jpg', '2025-12-08 17:11:39', '2025-12-08 17:11:39', 1, NULL),
(96, 80, 'appetizers', 'menu', 'images/category/rgXJwMWHZN5Jlc0sS0toGDidTVVwYUkGGiDYGFKd.jpg', '2025-12-08 17:13:06', '2025-12-08 17:13:06', 1, NULL),
(97, 80, 'السندوتشات', 'menu', 'images/category/B1SolZ3YF3H2DKEsviSWf1SQ5vKTJuzmAPYtjjHF.jpg', '2025-12-08 17:14:38', '2025-12-29 20:20:52', 1, NULL),
(98, 80, 'الكريبات', 'menu', 'images/category/JpgPtQFRS1JeXpRxMCrUVhDgSPEexfB1LYnYLoRl.jpg', '2025-12-08 17:15:30', '2025-12-08 17:15:30', 1, NULL),
(100, 80, 'الاضافات', 'menu', 'images/category/OlCJ1xLooha2akbyFDQr4MBFLfFaak5tB83oPYJ8.jpg', '2025-12-08 17:44:31', '2025-12-08 17:44:31', 1, NULL),
(101, 80, 'المشروبات', 'menu', 'images/category/B6qJx0jZFWAy6FT4WmiIr6uEa8OrZJBjTQxk8Z2M.jpg', '2025-12-08 17:45:08', '2025-12-08 17:45:08', 1, NULL),
(103, 71, 'سجاد نانو', 'menu', 'images/category/93BWbbKwSu2rwwQuZN5f3SvwLezaekV57KDCc3Rp.jpg', '2025-12-09 10:39:32', '2025-12-09 10:39:32', 1, NULL),
(105, 71, 'ورد نانو', 'menu', 'images/category/hRuBQMcT2TNJs73TYqO2qyXHTwHkOqia4mDcfhVW.jpg', '2025-12-09 10:40:32', '2025-12-09 10:40:32', 1, NULL),
(106, 71, 'ذهب نانو', 'menu', 'images/category/o8WOs5g25LeCFaY3uYCrVV1zL3Ich6YGtCX1J3ik.jpg', '2025-12-09 10:42:19', '2025-12-09 10:42:19', 1, NULL),
(108, 71, 'ادوات منزليه نانو22', 'menu', 'images/category/DVROgWF3B3oYVKKxLo1mefaw7LOYVfBR5VTvuncw.jpg', '2025-12-09 10:43:21', '2026-04-11 16:58:42', 1, NULL),
(109, 84, 'القسم الغربي', 'menu', 'images/category/SRwVHd4qtPyzffl0kkxocBu1NzncmSxf6UOJNTCS.jpg', '2025-12-09 13:02:23', '2025-12-09 13:09:55', 1, NULL),
(110, 84, 'الوجبات الغربي', 'menu', 'images/category/VYiw1Ibo1Y2oHQrUsvAdYxBNiakEezvBZ5ILPGCo.jpg', '2025-12-09 13:07:29', '2025-12-09 13:07:29', 1, NULL),
(111, 84, 'قسم الشاورما', 'menu', 'images/category/nl6f4GyaQjMM9ROw1zJlSifDG1vzZSNLRuXyR4Bw.jpg', '2025-12-09 13:11:47', '2025-12-09 13:11:47', 1, NULL),
(112, 84, 'قسم الشوايه', 'menu', 'images/category/WWVR2xRe6LPRYpODrah8BRdtt8VQ0gVKuKouOWol.jpg', '2025-12-09 13:13:33', '2025-12-09 13:13:33', 1, NULL),
(113, 84, 'بروستيد جريل', 'menu', 'images/category/9CtP7kuv5NfWiqqxWLje6NcxyXdY2xgnY74q7bSH.jpg', '2025-12-09 13:17:23', '2025-12-09 13:17:23', 1, NULL),
(114, 84, 'المقبلات', 'menu', 'images/category/CQujgTygByK0qg66vxL8Mhl6sm7cz0juqZ5M51UT.jpg', '2025-12-09 13:19:13', '2025-12-09 13:19:13', 1, NULL),
(115, 81, 'قسم الساعات', 'menu', 'images/category/gtsMMmD1AxN6Rsb5k7dMFCI2P8Uv9EKBSuhYrHgR.jpg', '2025-12-09 15:55:28', '2025-12-09 15:55:28', 1, NULL),
(116, 81, 'قسم البرفيوم', 'menu', 'images/category/xFK0l7Xvj3CyMEWYW5F1BkKoKYPGtrl8q2XBrVXW.jpg', '2025-12-09 15:57:50', '2025-12-09 15:57:50', 1, NULL),
(117, 81, 'قسم المحافظ', 'menu', 'images/category/kHVN1jxKcYTdTC6jhhsRpagIxbufzgShlE1XebZn.jpg', '2025-12-09 15:58:22', '2025-12-09 15:58:22', 1, NULL),
(118, 81, 'قسم مكن الكهرباء', 'menu', 'images/category/o0qHn4tm5iMil7yeIY6xrYkPXlX4MsKSt9K8GfQz.jpg', '2025-12-09 15:59:57', '2025-12-09 15:59:57', 1, NULL),
(119, 81, 'النظارات الشمسيه', 'menu', 'images/category/OQy1S0Uc63QJNKJNTZ2IlYjJbXeSCzzurB9m0jDK.jpg', '2025-12-09 17:14:30', '2025-12-09 17:14:30', 1, NULL),
(120, 85, 'standard', 'menu', 'images/category/ANgZHvGDAHtyyRjMNue3vh3GmWOXaTGDs2G6pThG.png', '2025-12-11 18:05:02', '2025-12-11 18:06:03', 1, NULL),
(121, 85, 'Primum', 'menu', 'images/category/Ypk7vI064KngZJKbSBA6Kk70IWj1SKsHG4e6bhxW.png', '2025-12-11 18:05:27', '2025-12-11 18:05:27', 1, NULL),
(122, 85, 'Basic', 'menu', 'images/category/4YvFFQVcbj0OpCTdz7YtFE3ciDuCUiEDuJokF7Kf.png', '2025-12-11 18:06:28', '2025-12-11 18:06:28', 1, NULL),
(123, 86, 'chicken meels', 'menu', 'images/category/kF0w83rmOZ0SlZXq3e8E0hXrV9JZqJUh1wyN60BS.jpg', '2025-12-13 16:16:45', '2025-12-13 16:16:45', 1, NULL),
(124, 86, 'Single Meals', 'menu', 'images/category/j3mtBBuVp77XBwDDky8nX1OdXW2Ohextu4yI5Azn.jpg', '2025-12-13 16:36:29', '2025-12-13 16:36:29', 1, NULL),
(125, 86, 'Kids Meals', 'menu', 'images/category/luCvPdVKmiRK4dt53P7A08FwA9820VIEriWLL2bc.jpg', '2025-12-13 16:37:18', '2025-12-13 16:37:18', 1, NULL),
(126, 86, 'Chicken Sandwich', 'menu', 'images/category/AdTLQELJQ6jYjxPjJcBS9FVX8wV9uRr8pynq93yh.jpg', '2025-12-13 16:38:08', '2025-12-13 16:38:08', 1, NULL),
(127, 86, 'Beef Sandwich', 'menu', 'images/category/qTyYDYdq0we4YJ7wGFBAsLVxhChxoxWnv2BNXuEy.jpg', '2025-12-13 16:40:16', '2025-12-13 16:40:16', 1, NULL),
(128, 86, 'APPETIZER', 'menu', 'images/category/mAvH6SD7MZK4z4h8UbRV4o3StEYdAIuXXzTN27Fn.jpg', '2025-12-13 16:42:19', '2025-12-13 16:42:19', 1, NULL),
(129, 86, 'Adds', 'menu', 'images/category/B9sCPt2QwZtgih7CTZRrChSAMFLj4FZ0jG72bfb7.jpg', '2025-12-13 16:42:44', '2025-12-13 16:42:44', 1, NULL),
(130, 86, 'Drinks', 'menu', 'images/category/JKZgztceNiPINQhBEkLER8Whc3fnr6njGUb0HccX.jpg', '2025-12-13 16:43:09', '2025-12-13 16:43:09', 1, NULL),
(131, 87, 'وجبات بالكيلو', 'menu', 'images/category/4lt43ZGnMSPWMc75UQVspDP7fFPbvGqaqiwAAZUJ.png', '2025-12-15 17:59:45', '2025-12-15 17:59:45', 1, NULL),
(132, 87, 'وجبات الوحيد', 'menu', 'images/category/G5mfpkN5A8YWR64Z7jOlk4Ep9B0L0NKqVNOU8Lb1.png', '2025-12-15 18:00:54', '2025-12-15 18:00:54', 1, NULL),
(133, 87, 'سندوتشات', 'menu', 'images/category/rM850p0yroTGKqfO4UHJ2YtstDh5pQ8aiRxHVLZ6.png', '2025-12-15 18:01:44', '2025-12-15 18:01:44', 1, NULL),
(159, 71, 'بن ساده', 'menu', 'images/category/r8ExPwG0RJfrQokAYkoPvfG34Aw1DRB2HNV5TZpf.jpg', '2026-04-11 16:57:37', '2026-04-11 16:57:37', 1, NULL),
(160, 71, 'لحوم', 'internal', 'cWymDbyVIurzpvZyzrZsApdh9QtqN8cR2pxG4mkl.jpg', '2026-04-18 19:03:00', '2026-04-18 19:03:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicable_order_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_order_types`)),
  `classification` enum('tax','fee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tax',
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `value` decimal(8,2) NOT NULL,
  `is_inclusive` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 71, 'عبدالرحمن احمد', '+2020150837340', '2026-01-21 06:25:52', '2026-01-21 06:25:52'),
(2, 71, 'test', '+201508373405', '2026-01-26 01:23:21', '2026-01-26 01:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dining_areas`
--

CREATE TABLE `dining_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(22) NOT NULL,
  `TITLE` varchar(300) NOT NULL,
  `Amount` int(22) NOT NULL,
  `Notes` text NOT NULL,
  `attach_File` varchar(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `TITLE`, `Amount`, `Notes`, `attach_File`, `user_id`, `created_at`, `updated_at`, `created_by`) VALUES
(6, 'مصروف الايجار', 500, 'sddddddddds', '1778374759.png', 71, '2026-05-09 21:59:19', '2026-05-09 21:59:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goods_receipts`
--

CREATE TABLE `goods_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_date` date NOT NULL,
  `status` enum('draft','posted','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'posted',
  `subtotal` decimal(14,3) NOT NULL DEFAULT 0.000,
  `discount` decimal(14,3) NOT NULL DEFAULT 0.000,
  `tax` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goods_receipts`
--

INSERT INTO `goods_receipts` (`id`, `user_id`, `purchase_order_id`, `supplier_id`, `receipt_number`, `receipt_date`, `status`, `subtotal`, `discount`, `tax`, `total`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 1, 'GR-20260419001615', '2026-04-19', 'posted', '999.000', '10.000', '10.000', '999.000', 'dddddddd', '2026-04-18 22:16:15', '2026-04-18 22:16:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `goods_receipt_items`
--

CREATE TABLE `goods_receipt_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goods_receipt_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(14,3) NOT NULL,
  `unit_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goods_receipt_items`
--

INSERT INTO `goods_receipt_items` (`id`, `goods_receipt_id`, `raw_material_id`, `purchase_order_item_id`, `unit_id`, `quantity`, `unit_cost`, `total_cost`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '3.000', '333.000', '999.000', '2026-04-18 22:16:15', '2026-04-18 22:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `inventoriable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventoriable_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `purchase_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `current_quantity` decimal(15,3) NOT NULL DEFAULT 0.000,
  `avg_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `last_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `reorder_level` decimal(14,3) DEFAULT NULL,
  `min_quantity` decimal(14,3) DEFAULT NULL,
  `max_quantity` decimal(14,3) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `user_id`, `inventoriable_type`, `inventoriable_id`, `purchase_price`, `purchase_unit_id`, `current_quantity`, `avg_cost`, `last_cost`, `reorder_level`, `min_quantity`, `max_quantity`, `is_active`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 'App\\Models\\RawMaterial', 1, '333.00', 1, '9.000', '333.000', '222.000', '5.000', '55.000', '53.000', 1, '2026-04-18 21:07:03', '2026-04-19 22:32:40', NULL),
(2, 71, 'App\\Models\\RawMaterial', 2, '77.00', 1, '0.000', '50.000', '50.000', '10.000', '10.000', '10.000', 1, '2026-04-20 05:35:25', '2026-04-20 05:35:25', NULL),
(3, 71, 'App\\Models\\RawMaterial', 3, '55.00', 1, '0.000', '66.000', '222.000', '2.000', '2.000', '2.000', 1, '2026-04-24 09:21:48', '2026-04-24 09:21:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_categories`
--

CREATE TABLE `inventory_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_categories`
--

INSERT INTO `inventory_categories` (`id`, `user_id`, `name`, `code`, `description`, `cover`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 71, 'لحوم', '22', 'لحوم بلدى', 'inventory_categories/1776552280_69e40958aa37e.png', 1, '2026-04-18 19:44:18', '2026-04-18 20:44:40'),
(2, 71, 'agent', '11', 'صصصصصصصصصصصصصص', 'inventory_categories/1776552378_69e409ba9ed77.jpg', 1, '2026-04-18 20:46:18', '2026-04-18 20:46:18'),
(3, 71, 'agent', '2595', 'سسسسسسسسسسس', 'inventory_categories/1776552687_69e40aef2868b.jpg', 1, '2026-04-18 20:51:27', '2026-04-18 20:51:27'),
(4, 71, 'admin', '22', 'aaaaaaaaaaaaaaa', 'inventory_categories/1776670429_69e5d6dda1626.jpg', 1, '2026-04-20 05:33:50', '2026-04-20 05:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('purchase','sale','waste','adjustment','transfer_out','transfer_in','production_in','production_out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_before` decimal(15,3) NOT NULL,
  `balance_after` decimal(15,3) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movement_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_movements`
--

INSERT INTO `inventory_movements` (`id`, `user_id`, `inventory_id`, `type`, `quantity`, `unit_cost`, `balance_before`, `balance_after`, `description`, `total_cost`, `reference_type`, `reference_id`, `notes`, `movement_date`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 'purchase', '3.000', '333.00', '0.000', '3.000', 'استلام شراء', '999.000', 'App\\Models\\GoodsReceipt', 1, 'استلام على الفاتورة GR-20260419001615', '2026-04-22 22:16:22', '2026-04-22 22:16:22', '2026-04-18 22:16:22', NULL),
(2, 71, 2, 'transfer_out', '-1.000', '15.00', '3.000', '2.000', 'تحويل مخزني - صرف', '15.000', 'App\\Models\\TransferRequest', 1, 'من الفرع 1 إلى الفرع 3', '2026-04-19 19:11:49', '2026-04-19 19:11:49', '2026-04-19 19:11:49', NULL),
(3, 71, 2, 'transfer_in', '1.000', '15.00', '2.000', '3.000', 'تحويل مخزني - استلام', '15.000', 'App\\Models\\TransferRequest', 1, 'استلام تحويل من الفرع 1', '2026-04-19 19:13:53', '2026-04-19 19:13:53', '2026-04-19 19:13:53', NULL),
(4, 71, 2, 'adjustment', '7.000', '15.00', '3.000', '10.000', 'تسوية جرد', '105.000', 'App\\Models\\StockCount', 1, 'فائض جرد', '2026-04-19 19:21:30', '2026-04-19 19:21:30', '2026-04-19 19:21:30', NULL),
(5, 71, 1, 'adjustment', '-2.000', '15.00', '10.000', '8.000', 'تسوية جرد', '30.000', 'App\\Models\\StockCount', 1, 'عجز جرد', '2026-04-19 19:21:30', '2026-04-19 19:21:30', '2026-04-19 19:21:30', NULL),
(6, 71, 1, 'production_out', '-2.000', '333.00', '8.000', '6.000', 'استهلاك خامات للإنتاج', '666.000', 'App\\Models\\ProductionOrder', 1, 'أمر إنتاج PD-20260420001458', '2026-04-19 22:32:40', '2026-04-19 22:32:40', '2026-04-19 22:32:40', NULL),
(7, 71, 1, 'production_in', '3.000', '222.00', '6.000', '9.000', 'إضافة ناتج إنتاج', '666.000', 'App\\Models\\ProductionOrder', 1, 'ناتج أمر إنتاج PD-20260420001458', '2026-04-19 22:32:40', '2026-04-19 22:32:40', '2026-04-19 22:32:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_06_130650_create_categories_table', 1),
(5, '2025_02_06_130658_create_products_table', 1),
(6, '2025_02_06_133741_create_settings_table', 1),
(7, '2025_02_06_133818_create_socials_table', 1),
(8, '2025_02_06_142302_create_orders_table', 1),
(9, '2025_02_06_145023_create_personal_access_tokens_table', 1),
(10, '2025_02_23_210614_create_sliders_table', 1),
(11, '2025_02_26_155954_add_two_factor_columns_to_users_table', 1),
(12, '2025_04_26_104258_create_product_sizes_table', 1),
(13, '2025_04_26_104630_create_order_product_sizes_table', 1),
(14, '2025_08_25_093920_create_business_settings_table', 2),
(15, '2025_08_26_111205_alter_settings_value_nullable', 3),
(16, '2026_01_14_200946_create_permission_tables', 4),
(17, '2026_01_14_234724_add_created_by_to_users_table', 4),
(18, '2026_01_16_003433_add_name_to_users_table', 4),
(19, '2026_01_16_013634_add_created_by_to_roles_table', 4),
(20, '2026_01_16_015727_add_group_and_user_role_to_permissions_table', 4),
(21, '2026_01_16_022500_add_created_by_to_payment_methods_table', 4),
(22, '2026_01_18_235515_create_customers_table', 5),
(23, '2026_01_18_235534_create_cart_items_table', 5),
(24, '2026_01_21_012556_update_orders_table_for_customer_and_payment', 5),
(25, '2026_01_28_012326_change_role_column_type_in_users_table', 6),
(26, '2026_01_29_061754_add_pos_columns_to_orders_table', 6),
(27, '2026_02_02_041627_create_category_product_table', 6),
(28, '2026_02_02_041629_add_type_to_categories_table', 6),
(29, '2026_02_02_041633_refactor_products_structure', 6),
(30, '2026_02_04_000000_create_dining_areas_table', 6),
(31, '2026_02_04_000002_create_tables_table', 6),
(32, '2026_02_04_000003_restore_product_category_structure', 6),
(33, '2026_02_04_104737_create_units_table', 6),
(34, '2026_02_05_021053_create_charges_table', 6),
(35, '2026_02_05_034822_add_applies_to_column_to_charges_table', 6),
(36, '2026_02_05_082350_replace_applies_to_with_order_types_in_charges_table', 6),
(37, '2026_02_11_073929_add_type_to_products_table', 7),
(40, '2026_02_11_080113_create_product_recipes_table', 7),
(41, '2026_02_14_115225_add_product_size_id_to_product_recipes_table', 7),
(42, '2026_02_14_123456_add_missing_columns_to_categories_table', 7),
(43, '2026_02_14_130000_make_cover_nullable_in_categories_table', 7),
(44, '2026_02_14_131000_make_cover_nullable_in_products_table', 7),
(45, '2026_02_24_205204_add_pos_fields_to_orders_table', 8),
(46, '2026_02_24_215702_create_delivery_men_table', 8),
(47, '2026_02_24_215717_add_delivery_man_id_to_orders_table', 8),
(49, '2026_02_24_221014_create_purchase_invoices_table', 8),
(50, '2026_02_24_221025_create_purchase_invoice_items_table', 8),
(52, '2026_01_16_022500_create_payment_methods_table', 1),
(54, '2026_04_14_170209_create_branch_user_table', 9),
(55, '2026_04_14_213634_add_branch_id_to_users_table', 10),
(56, '2026_04_16_201221_create_business_types_table', 11),
(57, '2026_04_16_215624_add_business_type_id_to_packages_table', 12),
(58, '2026_04_17_224209_create_attendances_table', 13),
(59, '2026_02_26_235906_create_shifts_table', 14),
(60, '2026_04_18_144716_create_inventory_categories_table', 15),
(62, '2026_04_18_144901_create_raw_materials_table', 17),
(63, '2026_02_11_074417_create_inventories_table', 18),
(64, '2026_02_11_075319_create_inventory_movements_table', 18),
(65, '2026_04_18_145152_create_purchase_requests_table', 18),
(66, '2026_04_18_145254_create_purchase_request_items_table', 18),
(67, '2026_04_18_145355_create_purchase_orders_table', 18),
(68, '2026_04_18_145528_create_purchase_order_items_table', 18),
(69, '2026_04_18_145605_create_goods_receipts_table', 18),
(70, '2026_04_18_145943_create_goods_receipt_items_table', 18),
(71, '2026_04_18_150120_create_transfer_requests_table', 18),
(72, '2026_04_18_150201_create_transfer_request_items_table', 18),
(73, '2026_04_18_150242_create_stock_counts_table', 18),
(74, '2026_04_18_150356_create_stock_count_items_table', 18),
(77, '2026_04_18_150651_create_production_orders_table', 18),
(78, '2026_04_18_150810_create_production_order_items_table', 18),
(79, '2026_04_18_214019_add_cover_to_inventory_categories_table', 19),
(80, '2026_04_19_210913_update_inventory_movements_type_enum', 20),
(81, '2026_04_18_150502_create_recipes_table', 21),
(82, '2026_04_18_150546_create_recipe_items_table', 21),
(83, '2026_04_19_224436_create_raw_materials_table', 21),
(84, '2026_02_24_220614_create_suppliers_table', 22),
(85, '2026_04_20_190224_create_supplier_raw_materials_table', 22),
(86, '2026_04_20_235523_create_package_permissions_table', 23),
(87, '2026_04_20_235813_create_subscriptions_table', 23),
(88, '2026_04_24_234033_add_shift_id_to_orders_table', 24),
(89, '2026_04_26_210305_create_cash_transfers_table', 25),
(90, '2026_04_26_210701_create_shift_expenses_table', 25),
(91, '2026_04_26_210759_add_cash_closing_fields_to_shifts_table', 25),
(92, '2026_04_14_170102_create_branches_table', 26),
(93, '2026_04_27_211633_create_branch_users_table', 26),
(94, '2026_04_27_212755_create_branch_links_table', 27),
(95, '2026_04_27_213026_create_branch_creation_requests_table', 28),
(96, '2026_04_30_031119_add_branch_id_to_remaining_tables', 29);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 96);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT 0,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_proof` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('served','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `type` enum('takeaway','table','free_seating','delivery') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'takeaway',
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_man_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `name`, `phone`, `address`, `total_price`, `paid_amount`, `change_amount`, `payment_method`, `payment_proof`, `status`, `type`, `table_id`, `delivery_man_id`, `delivery_fee`, `source`, `created_at`, `updated_at`, `shift_id`, `branch_id`) VALUES
(1, NULL, 71, 'ممت', '٨٠٠٠٠', 'اللب', 460, '460.00', '0.00', 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-13 16:35:29', '2026-04-24 18:35:34', 4, NULL),
(2, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, '100.00', '0.00', 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'pos', '2026-04-13 16:35:29', '2026-04-24 18:59:04', 5, NULL),
(3, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, NULL, NULL, 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'app', '2026-04-13 16:35:29', '2025-09-02 11:32:31', 6, NULL),
(4, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, NULL, NULL, 'cash', NULL, 'served', 'delivery', NULL, NULL, '0.00', 'web', '2026-04-12 16:35:29', '2025-08-16 11:44:30', 7, NULL),
(5, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, '100.00', '0.00', 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'app', '2026-04-12 16:35:29', '2026-04-25 18:33:32', 8, NULL),
(6, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, '100.00', '0.00', 'cash', NULL, 'served', 'delivery', NULL, NULL, '0.00', 'pos', '2026-04-12 16:35:29', '2026-04-25 18:34:41', 8, NULL),
(7, NULL, 71, 'llll', '123456789', 'kkkk', 120, NULL, NULL, 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'web', '2026-04-12 16:35:29', '2025-08-16 12:28:57', 8, NULL),
(9, NULL, 1, 'Amr Khaled', '0100000000', 'شارع الاختبار - القاهرة', 960, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-08-27 07:00:27', '2025-08-27 07:00:27', 8, NULL),
(10, NULL, 40, '555', '52343545352', '523432423', 360, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-09-04 08:25:07', '2025-09-04 08:25:07', 8, NULL),
(11, NULL, 1, 'amr', '0110928873', 'cairo', 1200, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-09-04 09:01:17', '2025-09-04 09:01:17', NULL, NULL),
(12, NULL, 40, 'زعبلة', '0123654789', 'عنوان بيننا', 200, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-10-13 20:57:12', '2025-10-13 20:57:12', NULL, NULL),
(13, NULL, 68, 'شاكر', '01099909123', 'قلين', 35, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-11-05 22:05:13', '2025-11-05 22:05:13', NULL, NULL),
(14, NULL, 53, 'وائل ابو البنات', '01211327252', 'بلازا 5', 185, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-11-13 17:21:01', '2025-11-13 17:21:01', NULL, NULL),
(15, NULL, 53, 'وائل ابو اللنات', '01211327252', 'بلازا 5', 190, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-11-13 22:03:08', '2025-11-13 22:03:08', NULL, NULL),
(16, NULL, 80, 'مممم', '01000058000', 'عولفعوو', 565, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-08 21:12:04', '2025-12-08 21:13:45', NULL, NULL),
(17, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-11 15:49:33', '2025-12-15 16:57:37', NULL, NULL),
(18, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-11 15:49:34', '2025-12-15 16:58:47', NULL, NULL),
(19, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-11 15:49:34', '2025-12-15 16:58:43', NULL, NULL),
(20, NULL, 86, 'Mostafa Matter', '01507444580', 'السعديه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-14 07:55:58', '2025-12-14 20:58:38', NULL, NULL),
(21, NULL, 86, 'Mostafa Matter', '01507444580', 'الشرقيه', 6, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-14 08:16:53', '2025-12-14 20:58:31', NULL, NULL),
(22, NULL, 86, 'بوحه', '٠١٥٠٧٤٤٤٥٨٠', 'القطاويه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-14 20:18:35', '2025-12-14 20:58:25', NULL, NULL),
(23, NULL, 80, 'ضياء رضا', '01050222277', 'المجاوره 10', 195, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-15 17:00:00', '2025-12-15 17:01:58', NULL, NULL),
(24, NULL, 86, 'بوحه', '٠١٥٠٧٤٤٤٥٨٠', 'السعديه', 155, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-15 20:51:04', '2025-12-16 00:01:57', NULL, NULL),
(25, NULL, 86, 'مصطفي', '٠١٥٠٧٤٤٤٥٨٠', 'السعدية', 320, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-23 20:53:28', '2025-12-16 00:02:02', NULL, NULL),
(26, NULL, 84, 'محمود نور', '01112556029', 'الحريزات الشرقيه شارع ال النجار', 380, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-24 13:58:05', '2025-12-23 14:49:47', NULL, NULL),
(27, NULL, 84, 'محمود نور', '01112556029', 'الحريزات الشرقيه شارع ال النجار', 380, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-17 14:58:06', '2025-12-23 14:49:44', NULL, NULL),
(28, NULL, 85, 'خخخخ', '01025570206', 'kkkkd kdkdk', 1099.99, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:13:27', '2025-12-21 08:22:43', NULL, NULL),
(29, NULL, 85, 'jddjjd', '01025570206', 'jcdjdjcxj', 1949.97, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:18:36', '2025-12-21 08:53:46', NULL, NULL),
(30, NULL, 85, 'بنبنبن', '01025570206', 'dkdkdk', 1949.97, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:23:27', '2025-12-21 08:53:44', NULL, NULL),
(31, NULL, 85, 'يتتيتي', '01025570206', 'kckkcc', 739.98, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:28:27', '2025-12-21 08:32:42', NULL, NULL),
(32, NULL, 85, 'ندندن', '01025570206', 'rfjfjf', 1099.99, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:47:05', '2025-12-21 08:53:40', NULL, NULL),
(33, NULL, 85, 'مميميميم', '01025570206', 'xkxkkx', 1099.99, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 08:54:17', '2025-12-21 09:02:12', NULL, NULL),
(34, NULL, 86, 'عمر خيري', '01507444580', 'السعديه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 09:03:13', '2025-12-21 09:07:20', NULL, NULL),
(35, NULL, 86, 'عمر', '01055020229', 'السعديه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 09:05:54', '2025-12-21 09:07:28', NULL, NULL),
(36, NULL, 86, 'ا', '5', 'ا', 3, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-21 20:13:09', '2025-12-21 20:13:50', NULL, NULL),
(37, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-22 22:55:23', '2025-12-22 23:02:37', NULL, NULL),
(38, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-22 22:55:24', '2025-12-22 23:02:33', NULL, NULL),
(39, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-22 22:55:26', '2025-12-22 23:02:19', NULL, NULL),
(40, NULL, 86, 'H', '5', 'H', 875, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:12:08', '2025-12-24 00:12:37', NULL, NULL),
(41, NULL, 86, 'Hh', '55', 'Vb', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:13:07', '2025-12-24 00:14:55', NULL, NULL),
(42, NULL, 86, 'Jh ok', '8686', 'Kvi', 450, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:13:27', '2025-12-24 00:14:53', NULL, NULL),
(43, NULL, 86, 'Mostafa Matter', '04507888580', 'Hhhgxf', 570, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:13:53', '2025-12-24 00:14:51', NULL, NULL),
(44, NULL, 86, 'Bb', '88', 'Yv', 450, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:14:24', '2025-12-24 00:14:48', NULL, NULL),
(45, NULL, 86, 'Mostafa Matter', '01280912321', 'السعديه', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:16:25', '2025-12-24 00:16:37', NULL, NULL),
(46, NULL, 86, 'Mostafa Matter', '0000000', 'تااتزد', 285, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 00:17:32', '2025-12-24 00:18:16', NULL, NULL),
(47, NULL, 88, 'اشرف', '01010250854', 'العاشر من', 1900, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-24 23:03:00', '2026-01-08 18:41:35', NULL, NULL),
(48, NULL, 90, 'مدحت فخري', '01080362429', 'مجاوره 18', 200, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-27 22:44:11', '2025-12-27 22:44:11', NULL, NULL),
(49, NULL, 80, 'Osama', '124846487', '686', 125, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-30 17:57:00', '2025-12-30 17:58:24', NULL, NULL),
(50, NULL, 80, 'ياسمين أحمد', '01093478580', 'المجاوره 19 خلف فرن تبارك', 640, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2025-12-31 20:11:51', '2025-12-31 20:29:35', NULL, NULL),
(51, NULL, 80, 'عبدالرحمن خالد', '01027785305', 'الأردنية بجوار دار مناسبات العاشر', 145, NULL, NULL, 'cash', NULL, 'pending', 'takeaway', NULL, NULL, '0.00', 'web', '2026-01-11 13:33:55', '2026-01-11 13:33:55', NULL, NULL),
(52, 1, 71, 'عبدالرحمن احمد', '+2020150837340', 'الجيزة مركز الصف', 10, '10.00', '0.00', 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-12 06:26:54', '2026-04-25 19:15:22', 15, NULL),
(53, 2, 71, 'test', '+201508373405', 'test', 25, NULL, NULL, 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-12 01:24:30', '2026-04-11 17:19:31', NULL, NULL),
(54, NULL, 71, 'عميل 1', '0100000001', 'القاهرة', 120, '120.00', '0.00', 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-12 16:37:24', '2026-04-24 20:34:07', NULL, NULL),
(55, NULL, 71, 'عميل 2', '0100000002', 'الجيزة', 180, '180.00', '0.00', 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'pos', '2026-04-12 16:37:24', '2026-04-24 20:35:31', NULL, NULL),
(56, NULL, 71, 'عميل 3', '0100000003', 'المنصورة', 210, '210.00', '0.00', 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'app', '2026-04-12 16:37:24', '2026-04-25 17:53:23', 13, NULL),
(57, NULL, 71, 'عميل 4', '0100000004', 'طنطا', 250, '250.00', '0.00', 'cash', NULL, 'served', 'delivery', NULL, NULL, '20.00', 'web', '2026-04-12 16:37:24', '2026-04-25 17:54:11', 13, NULL),
(58, NULL, 71, 'عميل 1', '0100000001', 'القاهرة', 120, '120.00', '0.00', 'cash', NULL, 'served', 'takeaway', NULL, NULL, '0.00', 'web', '2026-04-10 08:00:00', '2026-04-27 17:45:07', 22, NULL),
(59, NULL, 71, 'عميل 2', '0100000002', 'الجيزة', 150, '150.00', '0.00', 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'pos', '2026-04-11 08:00:00', '2026-04-26 19:03:31', 17, NULL),
(60, NULL, 71, 'عميل 3', '0100000003', 'المنصورة', 180, '180.00', '0.00', 'cash', NULL, 'served', 'free_seating', NULL, NULL, '0.00', 'app', '2026-04-12 08:00:00', '2026-04-25 18:41:27', 14, NULL),
(61, NULL, 71, 'عميل 4', '0100000004', 'طنطا', 200, '200.00', '0.00', 'cash', NULL, 'served', 'delivery', NULL, NULL, '0.00', 'web', '2026-04-12 12:00:00', '2026-04-25 18:37:05', 14, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_product_sizes`
--

CREATE TABLE `order_product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_size_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product_sizes`
--

INSERT INTO `order_product_sizes` (`id`, `order_id`, `product_size_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 150, 2, '2025-05-07 12:39:50', '2025-05-07 12:39:50'),
(2, 1, 6, 120, 1, '2025-05-07 12:39:50', '2025-05-07 12:39:50'),
(3, 1, 12, 40, 1, '2025-05-07 12:39:50', '2025-05-07 12:39:50'),
(4, 2, 3, 100, 1, '2025-07-17 14:14:20', '2025-07-17 14:14:20'),
(5, 3, 3, 100, 1, '2025-07-17 14:14:20', '2025-07-17 14:14:20'),
(6, 4, 3, 100, 1, '2025-07-17 14:14:22', '2025-07-17 14:14:22'),
(7, 5, 3, 100, 1, '2025-07-17 14:14:22', '2025-07-17 14:14:22'),
(8, 6, 3, 100, 1, '2025-07-17 14:14:22', '2025-07-17 14:14:22'),
(9, 7, 13, 40, 3, '2025-08-16 12:28:32', '2025-08-16 12:28:32'),
(10, 8, 4, 150, 2, '2025-08-27 06:53:04', '2025-08-27 06:53:04'),
(11, 8, 6, 120, 1, '2025-08-27 06:53:04', '2025-08-27 06:53:04'),
(12, 9, 4, 150, 4, '2025-08-27 07:00:27', '2025-08-27 07:00:27'),
(13, 9, 6, 120, 3, '2025-08-27 07:00:27', '2025-08-27 07:00:27'),
(14, 10, 71, 120, 3, '2025-09-04 08:25:07', '2025-09-04 08:25:07'),
(15, 11, 99, 160, 6, '2025-09-04 09:01:17', '2025-09-04 09:01:17'),
(16, 11, 71, 120, 2, '2025-09-04 09:01:17', '2025-09-04 09:01:17'),
(17, 12, 70, 100, 2, '2025-10-13 20:57:12', '2025-10-13 20:57:12'),
(18, 13, 153, 35, 1, '2025-11-05 22:05:13', '2025-11-05 22:05:13'),
(19, 14, 273, 110, 1, '2025-11-13 17:21:01', '2025-11-13 17:21:01'),
(20, 14, 182, 75, 1, '2025-11-13 17:21:01', '2025-11-13 17:21:01'),
(21, 15, 243, 190, 1, '2025-11-13 22:03:08', '2025-11-13 22:03:08'),
(22, 16, 422, 135, 1, '2025-12-08 21:12:04', '2025-12-08 21:12:04'),
(23, 16, 411, 215, 2, '2025-12-08 21:12:04', '2025-12-08 21:12:04'),
(24, 17, 408, 125, 2, '2025-12-11 15:49:33', '2025-12-11 15:49:33'),
(25, 18, 408, 125, 2, '2025-12-11 15:49:34', '2025-12-11 15:49:34'),
(26, 19, 408, 125, 2, '2025-12-11 15:49:34', '2025-12-11 15:49:34'),
(27, 20, 650, 285, 1, '2025-12-14 07:55:58', '2025-12-14 07:55:58'),
(28, 21, 724, 3, 2, '2025-12-14 08:16:53', '2025-12-14 08:16:53'),
(29, 22, 737, 285, 1, '2025-12-14 20:18:35', '2025-12-14 20:18:35'),
(30, 23, 728, 195, 1, '2025-12-15 17:00:00', '2025-12-15 17:00:00'),
(31, 24, 986, 155, 1, '2025-12-15 20:51:04', '2025-12-15 20:51:04'),
(32, 25, 924, 320, 1, '2025-12-15 20:53:28', '2025-12-15 20:53:28'),
(33, 26, 543, 65, 2, '2025-12-17 14:58:05', '2025-12-17 14:58:05'),
(34, 26, 582, 125, 2, '2025-12-17 14:58:05', '2025-12-17 14:58:05'),
(35, 27, 543, 65, 2, '2025-12-17 14:58:06', '2025-12-17 14:58:06'),
(36, 27, 582, 125, 2, '2025-12-17 14:58:06', '2025-12-17 14:58:06'),
(37, 28, 870, 1099.99, 1, '2025-12-21 08:13:27', '2025-12-21 08:13:27'),
(38, 29, 876, 649.99, 3, '2025-12-21 08:18:36', '2025-12-21 08:18:36'),
(39, 30, 876, 649.99, 3, '2025-12-21 08:23:27', '2025-12-21 08:23:27'),
(40, 31, 877, 369.99, 2, '2025-12-21 08:28:27', '2025-12-21 08:28:27'),
(41, 32, 870, 1099.99, 1, '2025-12-21 08:47:05', '2025-12-21 08:47:05'),
(42, 33, 870, 1099.99, 1, '2025-12-21 08:54:17', '2025-12-21 08:54:17'),
(43, 34, 909, 285, 1, '2025-12-21 09:03:13', '2025-12-21 09:03:13'),
(44, 35, 909, 285, 1, '2025-12-21 09:05:54', '2025-12-21 09:05:54'),
(45, 36, 724, 3, 1, '2025-12-21 20:13:09', '2025-12-21 20:13:09'),
(46, 37, 909, 285, 1, '2025-12-22 22:55:23', '2025-12-22 22:55:23'),
(47, 38, 909, 285, 1, '2025-12-22 22:55:24', '2025-12-22 22:55:24'),
(48, 39, 909, 285, 1, '2025-12-22 22:55:26', '2025-12-22 22:55:26'),
(49, 40, 916, 590, 1, '2025-12-24 00:12:08', '2025-12-24 00:12:08'),
(50, 40, 909, 285, 1, '2025-12-24 00:12:08', '2025-12-24 00:12:08'),
(51, 41, 909, 285, 1, '2025-12-24 00:13:07', '2025-12-24 00:13:07'),
(52, 42, 913, 450, 1, '2025-12-24 00:13:27', '2025-12-24 00:13:27'),
(53, 43, 910, 285, 2, '2025-12-24 00:13:53', '2025-12-24 00:13:53'),
(54, 44, 913, 450, 1, '2025-12-24 00:14:24', '2025-12-24 00:14:24'),
(55, 45, 910, 285, 1, '2025-12-24 00:16:25', '2025-12-24 00:16:25'),
(56, 46, 910, 285, 1, '2025-12-24 00:17:32', '2025-12-24 00:17:32'),
(57, 47, 1106, 1900, 1, '2025-12-24 23:03:00', '2025-12-24 23:03:00'),
(58, 48, 1200, 200, 1, '2025-12-27 22:44:11', '2025-12-27 22:44:11'),
(59, 49, 727, 125, 1, '2025-12-30 17:57:00', '2025-12-30 17:57:00'),
(60, 50, 428, 150, 1, '2025-12-31 20:11:51', '2025-12-31 20:11:51'),
(61, 50, 858, 160, 1, '2025-12-31 20:11:51', '2025-12-31 20:11:51'),
(62, 50, 446, 145, 1, '2025-12-31 20:11:51', '2025-12-31 20:11:51'),
(63, 50, 444, 120, 1, '2025-12-31 20:11:51', '2025-12-31 20:11:51'),
(64, 50, 865, 65, 1, '2025-12-31 20:11:51', '2025-12-31 20:11:51'),
(65, 51, 846, 135, 1, '2026-01-11 13:33:55', '2026-01-11 13:33:55'),
(66, 51, 497, 10, 1, '2026-01-11 13:33:55', '2026-01-11 13:33:55'),
(67, 52, 362, 10, 1, '2026-01-21 06:26:54', '2026-01-21 06:26:54'),
(68, 53, 359, 10, 1, '2026-01-26 01:24:30', '2026-01-26 01:24:30'),
(69, 53, 363, 15, 1, '2026-01-26 01:24:30', '2026-01-26 01:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'عدد الأيام',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `business_type_id`, `description`, `price`, `duration`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'باقه البداية', 2, 'شهريه', '250.00', 30, 1, '2025-08-31 07:12:22', '2025-08-31 07:12:22'),
(4, 'باقه النمو', 3, 'نصف سنوية', '1250.00', 180, 1, '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(5, 'باقه التميز', 2, '(خصم٪20)سنويه', '2500.00', 360, 1, '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(7, 'free', 3, 'trail', '0.00', 5, 1, '2025-09-01 08:18:29', '2025-09-01 08:18:29'),
(8, 'agent', 2, 'ششششششششششششششش', '1452.00', 10, 1, '2026-04-16 19:58:17', '2026-04-16 19:58:17'),
(10, 'الباقة الصيفيه', 2, 'باقة مناسبة', '100.00', 10, 1, '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(11, 'qqq', 3, 'qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', '100.00', 60, 1, '2026-04-27 16:32:11', '2026-04-27 16:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `package_features`
--

CREATE TABLE `package_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_features`
--

INSERT INTO `package_features` (`id`, `package_id`, `text`, `created_at`, `updated_at`) VALUES
(11, 4, '•	عدد لا نهائي من المنتجات', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(12, 4, '•	تعديل الأسعار وإضافة أصناف بسهولة', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(13, 4, '•	إمكانية إضافة أكثر من حجم وسعر للمنتج', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(14, 4, '•	تصنيفات منظمة لتسهيل التصفح', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(15, 4, '•	لوحة تحكم لإدارة المنتجات والطلبات', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(16, 4, '•	إضافة رقم واتساب ورقم اتصال لسهولة التواصل', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(17, 4, '•	تحكم كامل في الألوان والشكل بما يناسب الهوية التجارية', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(18, 4, '•	إمكانية عرض إعلانات وعروض خاصة داخل المنيو', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(19, 4, '•	ربط حسابات السوشيال ميديا بسهولة', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(20, 4, '•	خدمة عملاء + تحديثات مستمرة', '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(21, 5, '•	عدد لا نهائي من المنتجات', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(22, 5, '•	تعديل الأسعار وإضافة أصناف بسهولة', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(23, 5, '•	إمكانية إضافة أكثر من حجم وسعر للمنتج', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(24, 5, '•	تصنيفات منظمة لتسهيل التصفح', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(25, 5, '•	لوحة تحكم لإدارة المنتجات والطلبات', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(26, 5, '•	إضافة رقم واتساب ورقم اتصال لسهولة التواصل', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(27, 5, '•	تحكم كامل في الألوان والشكل بما يناسب الهوية التجارية', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(28, 5, '•	إمكانية عرض إعلانات وعروض خاصة داخل المنيو', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(29, 5, '•	خدمة عملاء + تحديثات مستمرة', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(30, 5, '•	سهولة الشراء أونلاين من خلال الموقع', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(31, 5, '•	فرصتك للظهور على محركات البحث (SEO)', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(32, 5, '•	دعم فني مميز وسريع', '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(49, 3, '•	عدد لا نهائي من المنتجات', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(50, 3, '•	تعديل الأسعار وإضافة أصناف بسهولة', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(51, 3, '•	إمكانية إضافة أكثر من حجم وسعر للمنتج', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(52, 3, '•	تصنيفات منظمة لتسهيل التصفح', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(53, 3, '•	لوحة تحكم لإدارة المنتجات والطلبات', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(54, 3, '•	إضافة رقم واتساب ورقم اتصال لسهولة التواصل', '2026-04-16 12:53:48', '2026-04-16 12:53:48'),
(57, 8, 'صصصصصصصصصص', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(58, 10, 'شششششششششششششششششش', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(59, 10, 'شششششششششششششششششش', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(60, 10, 'سسسسسسسسسسسسسسسسسسسس', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(61, 10, 'ييييييييييييييييييييييييييييييييييييييييييييييي', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(66, 7, 'تجربة', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(67, 11, 'aaaaaaaaaaaaaaaaaaaaaa', '2026-04-27 16:32:11', '2026-04-27 16:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `package_permissions`
--

CREATE TABLE `package_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `permission_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_permissions`
--

INSERT INTO `package_permissions` (`id`, `package_id`, `permission_key`, `created_at`, `updated_at`) VALUES
(1, 3, 'restaurant.dashboard', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(2, 3, 'restaurant.orders', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(3, 3, 'restaurant.menu', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(4, 4, 'restaurant.dashboard', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(5, 4, 'restaurant.orders', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(6, 4, 'restaurant.menu', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(7, 4, 'restaurant.tables', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(8, 4, 'inventory.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(9, 4, 'reports.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(10, 4, 'pos.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(11, 5, 'restaurant.dashboard', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(12, 5, 'restaurant.orders', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(13, 5, 'restaurant.menu', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(14, 5, 'restaurant.tables', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(15, 5, 'inventory.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(16, 5, 'reports.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(17, 5, 'settings.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(18, 5, 'pos.access', '2026-04-21 00:40:40', '2026-04-21 00:40:40'),
(23, 8, 'dashboard.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(24, 8, 'emenu.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(25, 8, 'categories.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(26, 8, 'products.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(27, 8, 'sliders.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(28, 8, 'orders.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(29, 8, 'orders.all', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(30, 8, 'orders.delivery', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(31, 8, 'orders.pickup', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(32, 8, 'orders.local', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(33, 8, 'pos.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(34, 8, 'management.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(35, 8, 'users.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(36, 8, 'roles.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(37, 8, 'branches.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(38, 8, 'shifts.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(39, 8, 'attendances.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(40, 8, 'inventory.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(41, 8, 'inventory.dashboard', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(42, 8, 'inventory.suppliers', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(43, 8, 'inventory.categories', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(44, 8, 'units.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(45, 8, 'inventory.materials', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(46, 8, 'inventory.purchase_requests', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(47, 8, 'inventory.purchase_orders', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(48, 8, 'inventory.receipts', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(49, 8, 'inventory.production_orders', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(50, 8, 'inventory.transfer_requests', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(51, 8, 'inventory.stock_counts', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(52, 8, 'inventory.movements', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(53, 8, 'reports.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(54, 8, 'reports.sales', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(55, 8, 'reports.top_products', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(56, 8, 'reports.staff_performance', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(57, 8, 'settings.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(58, 8, 'settings.general', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(59, 8, 'payment_methods.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(60, 8, 'tables_areas.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(61, 8, 'charges.access', '2026-04-20 23:50:42', '2026-04-20 23:50:42'),
(62, 10, 'dashboard.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(63, 10, 'emenu.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(64, 10, 'categories.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(65, 10, 'products.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(66, 10, 'sliders.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(67, 10, 'orders.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(68, 10, 'orders.all', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(69, 10, 'orders.delivery', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(70, 10, 'orders.pickup', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(71, 10, 'orders.local', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(72, 10, 'pos.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(73, 10, 'management.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(74, 10, 'users.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(75, 10, 'roles.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(76, 10, 'branches.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(77, 10, 'shifts.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(78, 10, 'attendances.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(79, 10, 'inventory.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(80, 10, 'inventory.dashboard', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(81, 10, 'inventory.suppliers', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(82, 10, 'inventory.categories', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(83, 10, 'units.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(84, 10, 'inventory.materials', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(85, 10, 'inventory.purchase_requests', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(86, 10, 'inventory.purchase_orders', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(87, 10, 'inventory.receipts', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(88, 10, 'inventory.production_orders', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(89, 10, 'inventory.transfer_requests', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(90, 10, 'inventory.stock_counts', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(91, 10, 'inventory.movements', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(92, 10, 'reports.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(93, 10, 'reports.sales', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(94, 10, 'reports.top_products', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(95, 10, 'reports.staff_performance', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(96, 10, 'settings.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(97, 10, 'settings.general', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(98, 10, 'payment_methods.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(99, 10, 'tables_areas.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(100, 10, 'charges.access', '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(220, 7, 'dashboard.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(221, 7, 'emenu.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(222, 7, 'categories.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(223, 7, 'products.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(224, 7, 'sliders.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(225, 7, 'orders.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(226, 7, 'orders.all', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(227, 7, 'orders.delivery', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(228, 7, 'orders.pickup', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(229, 7, 'orders.local', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(230, 7, 'pos.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(231, 7, 'management.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(232, 7, 'users.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(233, 7, 'roles.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(234, 7, 'branches.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(235, 7, 'shifts.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(236, 7, 'attendances.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(237, 7, 'inventory.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(238, 7, 'inventory.dashboard', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(239, 7, 'inventory.suppliers', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(240, 7, 'inventory.categories', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(241, 7, 'units.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(242, 7, 'inventory.materials', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(243, 7, 'inventory.purchase_requests', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(244, 7, 'inventory.purchase_orders', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(245, 7, 'inventory.receipts', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(246, 7, 'inventory.production_orders', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(247, 7, 'inventory.transfer_requests', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(248, 7, 'inventory.stock_counts', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(249, 7, 'inventory.movements', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(250, 7, 'reports.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(251, 7, 'reports.sales', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(252, 7, 'reports.top_products', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(253, 7, 'reports.staff_performance', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(254, 7, 'settings.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(255, 7, 'settings.general', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(256, 7, 'payment_methods.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(257, 7, 'tables_areas.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(258, 7, 'charges.access', '2026-04-21 13:01:53', '2026-04-21 13:01:53'),
(259, 7, 'cashier-cash-reports.access', '2026-04-26 23:22:04', '2026-04-26 23:22:04'),
(260, 11, 'dashboard.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(261, 11, 'emenu.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(262, 11, 'categories.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(263, 11, 'products.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(264, 11, 'sliders.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(265, 11, 'orders.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(266, 11, 'orders.all', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(267, 11, 'orders.delivery', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(268, 11, 'orders.pickup', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(269, 11, 'orders.local', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(270, 11, 'pos.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(271, 11, 'management.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(272, 11, 'users.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(273, 11, 'roles.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(274, 11, 'branches.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(275, 11, 'shifts.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(276, 11, 'attendances.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(277, 11, 'cashier-cash-reports.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(278, 11, 'inventory.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(279, 11, 'inventory.dashboard', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(280, 11, 'inventory.suppliers', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(281, 11, 'inventory.categories', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(282, 11, 'units.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(283, 11, 'inventory.materials', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(284, 11, 'inventory.purchase_requests', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(285, 11, 'inventory.purchase_orders', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(286, 11, 'inventory.receipts', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(287, 11, 'inventory.production_orders', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(288, 11, 'inventory.transfer_requests', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(289, 11, 'inventory.stock_counts', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(290, 11, 'inventory.movements', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(291, 11, 'reports.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(292, 11, 'reports.sales', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(293, 11, 'reports.top_products', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(294, 11, 'reports.staff_performance', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(295, 11, 'settings.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(296, 11, 'settings.general', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(297, 11, 'payment_methods.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(298, 11, 'tables_areas.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11'),
(299, 11, 'charges.access', '2026-04-27 16:32:11', '2026-04-27 16:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `phone`, `is_active`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'InstaPay', 'وسيلة دفع عبر تطبيق إنستا باي', '01093334419', 1, '2025-08-30 08:09:37', '2026-01-08 08:14:28', NULL),
(2, 'Vodafone Cash', 'تحويل الأموال عبر فودافون كاش', '01069944482', 1, '2025-08-30 08:09:37', '2026-01-08 08:13:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `user_role`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard_read', 'Dashboard', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(2, 'category_create', 'Categories', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(3, 'category_read', 'Categories', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(4, 'category_update', 'Categories', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(5, 'category_delete', 'Categories', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(6, 'product_create', 'Products', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(7, 'product_read', 'Products', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(8, 'product_update', 'Products', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(9, 'product_delete', 'Products', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(10, 'order_create', 'Orders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(11, 'order_read', 'Orders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(12, 'order_update', 'Orders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(13, 'order_delete', 'Orders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(14, 'user_create', 'Users', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(15, 'user_read', 'Users', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(16, 'user_update', 'Users', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(17, 'user_delete', 'Users', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(18, 'role_create', 'Roles', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(19, 'role_read', 'Roles', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(20, 'role_update', 'Roles', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(21, 'role_delete', 'Roles', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(22, 'settings_read', 'Settings', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(23, 'settings_update', 'Settings', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(24, 'slider_create', 'Sliders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(25, 'slider_read', 'Sliders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(26, 'slider_update', 'Sliders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(27, 'slider_delete', 'Sliders', 'admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(28, 'admin_create', 'Admins', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(29, 'admin_read', 'Admins', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(30, 'admin_update', 'Admins', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(31, 'admin_delete', 'Admins', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(32, 'business_settings_read', 'Business Settings', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(33, 'business_settings_update', 'Business Settings', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(34, 'package_create', 'Packages', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(35, 'package_read', 'Packages', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(36, 'package_update', 'Packages', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(37, 'package_delete', 'Packages', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(38, 'payment_method_create', 'Payment Methods', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(39, 'payment_method_read', 'Payment Methods', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(40, 'payment_method_update', 'Payment Methods', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(41, 'payment_method_delete', 'Payment Methods', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(42, 'section_create', 'Sections', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(43, 'section_read', 'Sections', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(44, 'section_update', 'Sections', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(45, 'section_delete', 'Sections', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(46, 'subscription_read', 'Subscriptions', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(47, 'subscription_update', 'Subscriptions', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(48, 'subscription_delete', 'Subscriptions', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(49, 'term_create', 'Terms', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(50, 'term_read', 'Terms', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(51, 'term_update', 'Terms', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(52, 'term_delete', 'Terms', 'super_admin', 'web', '2026-01-16 15:56:22', '2026-01-16 15:56:22'),
(53, 'branch_create', 'Branches', 'admin', 'web', '2026-04-14 22:21:54', '2026-04-14 22:21:54'),
(54, 'branch_read', 'Branches', 'admin', 'web', '2026-04-14 22:21:54', '2026-04-14 22:21:54'),
(55, 'branch_update', 'Branches', 'admin', 'web', '2026-04-14 22:21:54', '2026-04-14 22:21:54'),
(56, 'branch_delete', 'Branches', 'admin', 'web', '2026-04-14 22:21:54', '2026-04-14 22:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'auth_token', '4c900973b020d1eb1e86c270a345c2ba2ee90055448a94a0d37aee2f23548b2b', '[\"*\"]', NULL, NULL, '2025-08-26 05:57:58', '2025-08-26 05:57:58'),
(2, 'App\\Models\\User', 7, 'auth_token', 'bfdab5e8a772f81d04a497ee88be0a54fc69f13b127e9bf1726c6f0034846f05', '[\"*\"]', NULL, NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(3, 'App\\Models\\User', 8, 'auth_token', '9ad0b066d8c33d80cc66c309babcbda5f5874b76df0cbccb12881d637b85721a', '[\"*\"]', NULL, NULL, '2025-08-27 06:03:18', '2025-08-27 06:03:18'),
(4, 'App\\Models\\User', 9, 'auth_token', '1bb5264132f550417dfb2cbe28c27a801f5f5ad48641b67fc93d84a030ccb067', '[\"*\"]', NULL, NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(5, 'App\\Models\\User', 12, 'auth_token', '5336ac6d313750faf30483be8d10e963c18774e790d2fe1dac89ba3588693c75', '[\"*\"]', NULL, NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(6, 'App\\Models\\User', 13, 'auth_token', '5fc656b27c717ee2c2dd3a4a8293bba9b852d5dd21db69404d8cc89b0a4a2db3', '[\"*\"]', NULL, NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(7, 'App\\Models\\User', 14, 'auth_token', '184f5a7f3f19e560ba225a2396718eff0c97ba07a8536431cc9ceb1a0e3dddf7', '[\"*\"]', NULL, NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(8, 'App\\Models\\User', 15, 'auth_token', 'cb6070d5082114c74f9d9a751c49e7229169202c94386f81a59b42434ef7fbbe', '[\"*\"]', NULL, NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(9, 'App\\Models\\User', 16, 'auth_token', '896bedf0215c8bcb6a3f417984f3a25b5209b2ea27eac188ea7bfffae9b9f08a', '[\"*\"]', NULL, NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(10, 'App\\Models\\User', 17, 'auth_token', 'b0165da4a6eb4485b04f3e08d34703ec00bb3942cfea662bd25f7a97515bc313', '[\"*\"]', '2025-08-30 10:19:32', NULL, '2025-08-30 09:54:49', '2025-08-30 10:19:32'),
(11, 'App\\Models\\User', 18, 'auth_token', '1ea765a0fcab6c91b5be85efd7b9e69beac5d67e8c9c3ff4f22f1df99df34d24', '[\"*\"]', '2025-08-30 11:48:38', NULL, '2025-08-30 10:26:55', '2025-08-30 11:48:38'),
(12, 'App\\Models\\User', 19, 'auth_token', '7c844db0bf4a35b42aa612446e379a705f30e84bc40a2e26db4f9324ce8fd238', '[\"*\"]', NULL, NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(13, 'App\\Models\\User', 20, 'auth_token', 'c1963baeaea4fde64095667936eaddf796bec763185d6521033dfc1d293ee4fa', '[\"*\"]', NULL, NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(14, 'App\\Models\\User', 21, 'auth_token', '74ecca4241aee9b86c54ffcad3f903a2ba61dbef7b984b4935c48e40e1240160', '[\"*\"]', NULL, NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(15, 'App\\Models\\User', 22, 'auth_token', '6aa8d6b8589c3802ffb931d03dcdf1ef8d5dfca7050c3f585ba74c61cb27dca4', '[\"*\"]', NULL, NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(16, 'App\\Models\\User', 23, 'auth_token', 'bd41371b9d1c49dcf25e40ff3564d803d3308a4797ec484e9724b5c0776e18d5', '[\"*\"]', NULL, NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(17, 'App\\Models\\User', 24, 'auth_token', 'eb7d3ec5830cb27906f44de2926c2b8c17f60b0d10ad0a63e83bd475bab70050', '[\"*\"]', NULL, NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(18, 'App\\Models\\User', 25, 'auth_token', 'c5a66996bc102c21d72d16b7a99eb9cf1e529f759009fc6739e7bd765c05922a', '[\"*\"]', NULL, NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(19, 'App\\Models\\User', 26, 'auth_token', '2c7a85be7a0710f009687931521baf3f62cc68ba81660bed70e876482eb93ee3', '[\"*\"]', NULL, NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(20, 'App\\Models\\User', 27, 'auth_token', '3453b4ddf46e90b6475faef24340fe97e771e9c1088657e1175d035eec20b7c6', '[\"*\"]', NULL, NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(21, 'App\\Models\\User', 28, 'auth_token', '0042489310c31bc3bcb59e1a273ddb23944e406d4216e1ce80f4e05b74ef1165', '[\"*\"]', NULL, NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(22, 'App\\Models\\User', 29, 'auth_token', '17636823255b097358d3be01a46af204a12b3d30815baaf6c2894eb8641ee0d7', '[\"*\"]', NULL, NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(23, 'App\\Models\\User', 30, 'auth_token', '302021c25b6b8430387ac7c5c4b7fb982b6a09cdf16d47d08bf902b7568bcaaf', '[\"*\"]', NULL, NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(24, 'App\\Models\\User', 31, 'auth_token', 'e84263e71396de6aed1460cdf10e290f57a7eff115e058b5dcafb44cc60866e8', '[\"*\"]', '2025-08-30 14:56:39', NULL, '2025-08-30 14:55:39', '2025-08-30 14:56:39'),
(25, 'App\\Models\\User', 32, 'auth_token', '3e8260cc81b1716f08c8b2e857a19d92c323e55bfd3945587688b6e93d7837a1', '[\"*\"]', '2025-08-30 15:00:36', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:36'),
(26, 'App\\Models\\User', 33, 'auth_token', '18376a4d2b2a9361d6a29875ad9fd1f8915af8db91c0e98feeb6a976eda1180f', '[\"*\"]', '2025-08-30 15:06:22', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:22'),
(27, 'App\\Models\\User', 34, 'auth_token', '24bdd1a7575ce8cafb11d1554d80fb96c662aed54b0c129d677c3b46c2235cd9', '[\"*\"]', '2025-08-30 15:17:43', NULL, '2025-08-30 15:13:26', '2025-08-30 15:17:43'),
(28, 'App\\Models\\User', 35, 'auth_token', '29d5e08736c5a0ca3d502090d5774d6cb1c7ef192a52cb45a53cd1b0c93d01a8', '[\"*\"]', NULL, NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(29, 'App\\Models\\User', 36, 'auth_token', 'b0ee50b7f3f519b110410a71a0ca5216a3b1e8104632d62619c5bdff72596629', '[\"*\"]', NULL, NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(30, 'App\\Models\\User', 37, 'auth_token', 'bf5e3ce4e2c66c9232efac217a656b46eb9a49d68dea676414500f8e07b8cfee', '[\"*\"]', NULL, NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(31, 'App\\Models\\User', 38, 'auth_token', '88826291c558abddd14ef21210c5441d98d8cd8bf1ad697c17cf49b4aa2e7758', '[\"*\"]', NULL, NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(32, 'App\\Models\\User', 39, 'auth_token', 'b9eeece26578c53c2b679752308534ec68f27898062e5e5f21bf9c7dc59c2da2', '[\"*\"]', '2025-08-30 15:32:39', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:39'),
(33, 'App\\Models\\User', 40, 'auth_token', '9fefb0764e1510e19df5c825f2f27bedd459710e644a0a204df89f380d5e2242', '[\"*\"]', '2025-08-30 15:43:13', NULL, '2025-08-30 15:42:21', '2025-08-30 15:43:13'),
(34, 'App\\Models\\User', 41, 'auth_token', 'c19d2dcc5df1d110f0a3d1058b45973bd9698f6e1b18c086ed17280cc7a11a88', '[\"*\"]', NULL, NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(35, 'App\\Models\\User', 42, 'auth_token', 'e1c5f8a0a5091845719dae7571b9093e4597dd6612dd2c506839421a2c7b75af', '[\"*\"]', '2025-08-31 12:30:00', NULL, '2025-08-31 12:27:36', '2025-08-31 12:30:00'),
(36, 'App\\Models\\User', 43, 'auth_token', 'ebf560382c92c984fe17fbbad58f99371c259f69f86f162bb2d16ac0cd1e78b7', '[\"*\"]', NULL, NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(37, 'App\\Models\\User', 44, 'auth_token', '975bb232a72a21bb4c2a61ff7860703658431eed96414e2f101f974374f65722', '[\"*\"]', NULL, NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(38, 'App\\Models\\User', 45, 'auth_token', '0d9e4118551618280fa2db2fba9fd41d45934236d006e1d7c0c85ea7b5d4d187', '[\"*\"]', NULL, NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(39, 'App\\Models\\User', 46, 'auth_token', 'dfae025e5aeb93abc56538bbca2c4e242ccb66315f7fcfff644f2ed96be2bc00', '[\"*\"]', NULL, NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(40, 'App\\Models\\User', 47, 'auth_token', 'c62d375708b35483d65abd7784ec8608d29234dd01704d9b1cf1a2bf5b1221a3', '[\"*\"]', NULL, NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(41, 'App\\Models\\User', 48, 'auth_token', '8989d94698832caae1e165e80b2d1aa37eff607a28c007c1b950cabb8d4f9d91', '[\"*\"]', NULL, NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(42, 'App\\Models\\User', 49, 'auth_token', 'd9233ba8209269a99f815f8ee4d5727fdd1ea8d7b2f4fa3ee78fe8bdcf550c19', '[\"*\"]', '2025-09-01 12:52:02', NULL, '2025-09-01 12:30:37', '2025-09-01 12:52:02'),
(43, 'App\\Models\\User', 50, 'auth_token', 'f72adc49deff511c1d8f5b67452f3b98d7d79a040a234bd1ae10783907f2bbd4', '[\"*\"]', NULL, NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(44, 'App\\Models\\User', 51, 'auth_token', '088c695b783cc76b4987df2fa5f99d86cece677210de95d68f049d5bad602f8e', '[\"*\"]', '2025-09-04 08:31:48', NULL, '2025-09-04 08:31:29', '2025-09-04 08:31:48'),
(45, 'App\\Models\\User', 52, 'auth_token', '4cb14ec61d5491340b1e64bd5b9d92238aebc3367e525a007e54c8a3d5f32165', '[\"*\"]', NULL, NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(46, 'App\\Models\\User', 53, 'auth_token', '02ed64eb856bb056204d279041b94ed240508d991056ce059f0272b0b169c08f', '[\"*\"]', '2025-09-06 07:16:27', NULL, '2025-09-06 07:14:35', '2025-09-06 07:16:27'),
(47, 'App\\Models\\User', 54, 'auth_token', '482cb73183b5fe1ceccc2f1294f6bd5ae3315946e31789861469e7330c2c63cc', '[\"*\"]', '2025-09-06 08:44:46', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:46'),
(48, 'App\\Models\\User', 55, 'auth_token', '3677b97f2db92f0f0aba279a0fad3ee3dbffe39877e972530601a245d23365a1', '[\"*\"]', NULL, NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(49, 'App\\Models\\User', 56, 'auth_token', '851fb50a64fe273bb7d71c5003db96e3a31b98e875c78d1f6063287a7812878d', '[\"*\"]', NULL, NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(50, 'App\\Models\\User', 57, 'auth_token', 'fadd3a03c063bf8bb0c1bfe3ea987e0425c481dc3d6f75be4704638f428e3159', '[\"*\"]', '2025-09-06 09:02:01', NULL, '2025-09-06 08:59:40', '2025-09-06 09:02:01'),
(51, 'App\\Models\\User', 58, 'auth_token', '364e0459e9b07a22475c8e8aa498fb148fdb21e386b7d302a224576217bbf84a', '[\"*\"]', '2025-09-06 09:04:24', NULL, '2025-09-06 09:03:17', '2025-09-06 09:04:24'),
(52, 'App\\Models\\User', 59, 'auth_token', '32868d348d07905b63a4b1067b74e56bc6284f476b6ad2b51f9bd7a19f629689', '[\"*\"]', '2025-09-06 09:06:52', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:52'),
(53, 'App\\Models\\User', 60, 'auth_token', '5566dc373d7e32443439ff13a48ea5b6dc97274da231f18c58ba61d29641bf03', '[\"*\"]', '2025-09-06 09:24:28', NULL, '2025-09-06 09:24:04', '2025-09-06 09:24:28'),
(54, 'App\\Models\\User', 61, 'auth_token', 'f6a5e91a3dee41d2e65b10e53e2bde6a7ae1b5e24d2d4c7e0cdda5f44b3dca4b', '[\"*\"]', NULL, NULL, '2025-09-06 12:04:47', '2025-09-06 12:04:47'),
(55, 'App\\Models\\User', 62, 'auth_token', 'bf9441f74396c71a663fb1e9378ec7cd6aa749375aad7f9e6bbc57d1c9a05206', '[\"*\"]', NULL, NULL, '2025-09-07 09:37:56', '2025-09-07 09:37:56'),
(56, 'App\\Models\\User', 63, 'auth_token', '81a20dafe10f342ac8ca2111d10c20f35e6b9238bab783618074f58bb0dfb423', '[\"*\"]', NULL, NULL, '2025-09-14 09:40:24', '2025-09-14 09:40:24'),
(57, 'App\\Models\\User', 64, 'auth_token', 'fe6734bb324cd0132deec087949b2b088a35b59c01e95cab89264e0ef0ace52a', '[\"*\"]', '2025-09-14 13:19:43', NULL, '2025-09-14 13:19:20', '2025-09-14 13:19:43'),
(58, 'App\\Models\\User', 65, 'auth_token', '80bc7dd05926e7173960fb7352ac07407eb1855821f7a941af18de43d2f0743f', '[\"*\"]', '2025-09-26 13:30:36', NULL, '2025-09-26 13:29:48', '2025-09-26 13:30:36'),
(59, 'App\\Models\\User', 66, 'auth_token', '1684629d255370d22e037718b87051e38764c0b5067672e11f25c6dc66723445', '[\"*\"]', '2025-10-04 10:02:47', NULL, '2025-10-04 10:02:28', '2025-10-04 10:02:47'),
(60, 'App\\Models\\User', 67, 'auth_token', '19d851068bcdfbea9c2584e2da6b0bbd175769930490f6a1d41d23e95e8c67f7', '[\"*\"]', '2025-10-07 14:19:15', NULL, '2025-10-07 14:18:57', '2025-10-07 14:19:15'),
(61, 'App\\Models\\User', 68, 'auth_token', 'd8e1a4128e2100f9124467941a237f225177e16b97125ad91f9b65f5eb51955b', '[\"*\"]', '2025-11-05 21:14:11', NULL, '2025-11-05 21:07:55', '2025-11-05 21:14:11'),
(62, 'App\\Models\\User', 69, 'auth_token', 'e92e85ed2a1884b629db38738f7675a46eac6f247bcc4f8cff8d51b570333a28', '[\"*\"]', '2025-11-19 14:57:59', NULL, '2025-11-19 14:57:27', '2025-11-19 14:57:59'),
(63, 'App\\Models\\User', 70, 'auth_token', '1ba1d19447dbd9b4a81b0acbaa620db76f4e07b60fcf90aad625dd888cd0ca02', '[\"*\"]', '2025-11-19 15:01:02', NULL, '2025-11-19 15:00:42', '2025-11-19 15:01:02'),
(64, 'App\\Models\\User', 72, 'auth_token', 'ba5e662d1c67a8f27e699e13ebb7f75accf7773e3439e7b352448fd4590e60eb', '[\"*\"]', NULL, NULL, '2025-12-02 14:17:04', '2025-12-02 14:17:04'),
(65, 'App\\Models\\User', 73, 'auth_token', 'a50c8a0dbe2c057dc98a5163c898d2204c65a77150e5ccc8afd05347ff95400d', '[\"*\"]', NULL, NULL, '2025-12-02 16:32:26', '2025-12-02 16:32:26'),
(66, 'App\\Models\\User', 74, 'auth_token', '2713ec8d41dff78ff22163167c7efe4f26ea2a57cd9f59ba3105c2607a74b68e', '[\"*\"]', NULL, NULL, '2025-12-02 16:36:38', '2025-12-02 16:36:38'),
(67, 'App\\Models\\User', 75, 'auth_token', 'fc260ee5cc06dc69bd783c39f8155f004fbc03ee71bd99a8f8d19787668a52e6', '[\"*\"]', NULL, NULL, '2025-12-02 16:47:52', '2025-12-02 16:47:52'),
(68, 'App\\Models\\User', 76, 'auth_token', 'c46cc76eac58d6a1c054ebca24d2433db8597f4cb3cbb5d0efef3be14bf46abd', '[\"*\"]', NULL, NULL, '2025-12-02 16:48:42', '2025-12-02 16:48:42'),
(69, 'App\\Models\\User', 77, 'auth_token', '5001b69c665a93633b23f84ff75bc0135341a60539e3bfda9ec38372b2638def', '[\"*\"]', '2025-12-02 16:50:18', NULL, '2025-12-02 16:49:28', '2025-12-02 16:50:18'),
(70, 'App\\Models\\User', 78, 'auth_token', 'b455d7190d83b28a5a0e5baae05dc2c5bc3af57c61b1aa017a44622c8e440f46', '[\"*\"]', '2025-12-02 16:57:54', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:54'),
(71, 'App\\Models\\User', 79, 'auth_token', '8eced2aef632997f7d3b0433a711a3d74274faada78b8028c27191064563e4be', '[\"*\"]', '2025-12-02 21:07:21', NULL, '2025-12-02 21:05:50', '2025-12-02 21:07:21'),
(72, 'App\\Models\\User', 80, 'auth_token', 'b133dabe1453235f0d51f7c08c8f33d81e45211183355c653a2f167108858a3b', '[\"*\"]', NULL, NULL, '2025-12-03 16:28:42', '2025-12-03 16:28:42'),
(73, 'App\\Models\\User', 81, 'auth_token', 'b1ed7a918ad02f4bb0304e5a9f783cb87ae892d6df76307cc37e5403f69632ef', '[\"*\"]', '2025-12-07 17:05:23', NULL, '2025-12-07 17:04:44', '2025-12-07 17:05:23'),
(74, 'App\\Models\\User', 83, 'auth_token', 'ec8ed1d6b24b646424ba6bddcb39d9a09a30deb591344f395071e890fe005606', '[\"*\"]', '2025-12-09 11:06:27', NULL, '2025-12-09 11:03:53', '2025-12-09 11:06:27'),
(75, 'App\\Models\\User', 84, 'auth_token', 'aa442815fb600941136c9bb4dbc4933df285fe4e4343b6243d94ea48da2987d2', '[\"*\"]', '2025-12-09 12:18:22', NULL, '2025-12-09 12:17:53', '2025-12-09 12:18:22'),
(76, 'App\\Models\\User', 91, 'auth_token', '9060511baf3c8c81041ed0f7b3201c092393e07b36e57e78bc3bfaba2b1230e6', '[\"*\"]', NULL, NULL, '2026-01-08 22:58:04', '2026-01-08 22:58:04'),
(77, 'App\\Models\\User', 92, 'auth_token', '43473c1fcec0b5402251dc859bf3688064e30fab74f545483ed56c009ba3caa6', '[\"*\"]', '2026-01-13 10:03:35', NULL, '2026-01-13 10:03:08', '2026-01-13 10:03:35'),
(78, 'App\\Models\\Customer', 1, 'customer-token', '0ce1350d3e6068a9f7aff206e83ca86416dd406eff4a04ac7a996c8dfdf54640', '[\"*\"]', '2026-01-21 06:26:54', NULL, '2026-01-21 06:25:52', '2026-01-21 06:26:54'),
(79, 'App\\Models\\Customer', 2, 'customer-token', 'b30055f4fd5cce58edd0b7d75108bb4126f47de3b7977736c40e5f0fb88ce99b', '[\"*\"]', '2026-01-26 01:24:30', NULL, '2026-01-26 01:23:21', '2026-01-26 01:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `production_orders`
--

CREATE TABLE `production_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `production_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `production_date` date NOT NULL,
  `planned_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `produced_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `status` enum('draft','approved','produced','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_orders`
--

INSERT INTO `production_orders` (`id`, `user_id`, `recipe_id`, `production_number`, `production_date`, `planned_quantity`, `produced_quantity`, `status`, `total_cost`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 'PD-20260420001458', '2026-04-20', '5.000', '3.000', 'produced', '666.000', 'اهلا', '2026-04-22 22:14:58', '2026-04-19 22:32:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `production_order_items`
--

CREATE TABLE `production_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `production_order_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `planned_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `consumed_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `unit_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_order_items`
--

INSERT INTO `production_order_items` (`id`, `production_order_id`, `raw_material_id`, `unit_id`, `planned_quantity`, `consumed_quantity`, `unit_cost`, `total_cost`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '5.000', '2.000', '333.000', '666.000', '2026-04-19 22:14:58', '2026-04-19 22:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('ready','manufactured','raw') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ready',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `type`, `user_id`, `name`, `description`, `cover`, `Purchase_price`, `selling_price`, `created_at`, `updated_at`) VALUES
(9, NULL, 'ready', NULL, 'شطيرة شاورما دجاج', 'شاورما دجاج', '1755350079.jpeg', NULL, NULL, '2025-08-16 13:14:39', '2025-08-16 13:14:39'),
(10, NULL, 'ready', NULL, 'شاورما الديك الرومي', 'شاورما الديك الرومي', '1755350627.png', NULL, NULL, '2025-08-16 13:23:47', '2025-08-16 13:23:47'),
(11, 12, 'ready', NULL, 'برجر', 'برجر', '1755351017.jpeg', NULL, NULL, '2025-08-16 13:30:17', '2025-08-16 13:30:17'),
(12, 12, 'ready', NULL, 'برجر ستيشن', 'برجر ستيشن', '1755351212.jpeg', NULL, NULL, '2025-08-16 13:33:32', '2025-08-16 13:33:32'),
(13, 12, 'ready', NULL, 'دبل تشيز برجر', 'دبل تشيز برجر', '1755351360.jpeg', NULL, NULL, '2025-08-16 13:36:00', '2025-08-16 13:36:00'),
(14, 13, 'ready', NULL, 'بيتزا ايطالية', 'بيتزا ايطالية', '1755351509.jpeg', NULL, NULL, '2025-08-16 13:38:29', '2025-08-16 13:38:29'),
(15, 13, 'ready', NULL, 'باستا بيتزا', 'باستا بيتزا', '1755351631.jpeg', NULL, NULL, '2025-08-16 13:40:31', '2025-08-16 13:40:31'),
(16, 13, 'ready', NULL, 'بيتزا خضار', 'بيتزا خضار', '1755351784.jpeg', NULL, NULL, '2025-08-16 13:43:04', '2025-08-16 13:43:04'),
(17, NULL, 'ready', NULL, 'الفطير المشلتت', 'الفطير المشلتت', '1755351950.jpeg', NULL, NULL, '2025-08-16 13:45:50', '2025-08-16 13:45:50'),
(18, NULL, 'ready', NULL, 'فطائر الجبنة', 'فطائر الجبنة', '1755352056.jpeg', NULL, NULL, '2025-08-16 13:47:36', '2025-08-16 13:47:36'),
(21, 24, 'ready', 8, 'test', 'te', 'products/SpCsKqU4t09yaWhje7zcgDuoblTNv4fbCmXZ7GNk.png', NULL, NULL, '2025-08-31 09:24:29', '2025-08-31 09:24:29'),
(22, 24, 'ready', 8, 'pro', 'test', 'products/D8j1Q2kbLzTDfRmMfyUQHbbFkAm7vwrYnuLuaXTN.png', NULL, NULL, '2025-08-31 09:37:19', '2025-08-31 09:37:19'),
(26, 24, 'ready', 8, 'Amr', 'test', 'products/rUmLQb5EtZakVsFfYIfYJGJoR4OyjG0jmoxxT1Ha.png', NULL, NULL, '2025-08-31 10:40:40', '2025-08-31 10:40:40'),
(27, 24, 'ready', 8, 'باقة سنوية', 'te', 'products/txOPkMsMWfNj6LLIsZIjrdRvcIVjX0UR5ecoh9rb.png', NULL, NULL, '2025-08-31 10:41:10', '2025-08-31 10:41:10'),
(53, 34, 'ready', 50, 'Burger', 'Hot Burger', 'products/udjyuba0vd0Qqi9Wo4E26dEy3KPKVPUJRGh05wNW.png', NULL, NULL, '2025-09-03 15:23:13', '2025-09-03 15:23:13'),
(55, 34, 'ready', 50, 'test', 'هيضاف', 'products/7EMuZuBnfbMJArb5qpOjgeC7QeCwy4l2ySLAMOKw.png', NULL, NULL, '2025-09-04 09:37:03', '2025-09-04 09:37:03'),
(57, 34, 'ready', 50, 'Kno', 'let`s see', 'products/S7GQwjznex401JgRDeoOP87RJtBy6FuOhg7rndWs.png', NULL, NULL, '2025-09-04 09:39:53', '2025-09-04 09:39:53'),
(272, 88, 'ready', 79, 'عطر سينس لافيرن نسائي', '😍😍😍😍🤩🤩🤩🤩 عطر سينس لافيرن نسائي  برفيوم جورجينا التريند 😍😍😍✌️  من وحي زهرةٍ تمايلت كراقصة باليه ومن أسرار الأنوثة التي عجز الشعراء عن كشفها! صُمم سينس ليجعل للأنوثة ملامح تبتسم وتقول : أنا أشعر إذن أنا موجودة! هو كلمة \"أحبك\" التي توجهينها لنفسك اولاً ثم للعالم..  رحلة تصميم العطر : سينس لم يكن صدفة! بل كان نتيجة رحلة من التخطيط والعمل تجاوزت عاماً بأكمله.. ابتكرت خلالها داليا ايزم بالتعاون مع جورجينا رودريغيز أكثر من ٧٤٠ عينة! لتختار اخيراً جورجينا التركيبة المثالية التي تجسد كل مشاعرها في زجاجة عطر.. ليكون سينس جامعًا لكل أسرار الأنوثة في زجاجة.  التركيبة : الافتتاحية : الكشمش الأسود، اليوسفي القلب : الياسمين، السوسن، الكشمير، زهر البرتقال القاعدة : المسك  عطر-سينس-لافيرن حجم العطر : 75 مل', 'products/8GlE8QiNluKHz0awhceiAob1Deh3iULG69zOBB4F.jpg', NULL, NULL, '2025-12-02 21:21:13', '2025-12-02 21:21:13'),
(273, 88, 'ready', 79, 'برفان حريمي 212 sexy', 'برفان حريمي 212 sexy 💛💛🌸🌸  انا فتحتلي واحده 🌸🌸ايه داا ..فظيعه بجد.ازازتين فى واحده .... الاختيااار الاؤل للعرايس فعلااااا 💋💋😍😍 ريحتها وووهم وثابته.جداااا لو نفسك فحاجه 🙊🙊🙊 😉 كده ومختلفه  212 بتقولك انا اهو بتقولك اللي يجربني مش هيغيرني 💜 ❤️❤️💋😘 كوني مميزه ومختلفه مع عطر 212 ع ضمنتي..... من جماله عمرك ماهتقدري تستغني عنو  😍💥💥💥', 'products/CpVXckfMTCLRzpdDN5evwX4FGMlcf2RhYffuAlx7.jpg', NULL, NULL, '2025-12-02 21:21:55', '2025-12-02 21:21:55'),
(274, 88, 'ready', 79, 'Valentino Uomo Born in Roma', '100 ml ❤❤❤ VALENTINO ❤❤❤  فلانتينو للرجال 🖤  أحد أفخم وأقوى ابداعات فلانتينو♥️ فهو يوصف بأنه مزیج من  الكلاسیكیة  🚧 Valentino Uomo Intense - فلانتينو   عطر بودري زهري مع جلود للرجال ⚓   ثبات وفوحان وأداء قوي ومعاك لفترة طويلة على الملابس🕖🔊  عطر عالمي جذاب من العطورات بتدمج بين الماضي والحاضر 🖤   برفان ملئ بالجمال واناقه لا متناهيه يعبر عن القوة والشجاعة 😎  إفتتاحية العطر ✨ الماندرين (اليوسفي) و المريمية 🍊 قلب العطر ✨ السوسن و حبوب التونكا🫚 قاعدة العطر ✨  الفانيليا و الجلود🌿', 'products/h9noIi7OlYWgWjGpJOR8qf5LeLh45vePhyQyH5k4.jpg', NULL, NULL, '2025-12-02 21:22:54', '2025-12-02 21:22:54'),
(275, 88, 'ready', 79, 'Jean Paul Gaultier La Belle Le Parfum', 'الأنوثة المُركّزة في زجاجة حمراء😍، عطر شرقي زكي الرائحة مُمتع، مُركّز و مُغري يبرز قوة المرأة ويزيد من حِدّة جاذبيتها بمتعة أخاذة لا يمكن مقاومتها .  عطر شرقي - فانيليا للنساء حسِّي ، فتّان و مغوي بالدرجة الاولى ذو فوحان و ثبات عالي جداً يليق بلأجواء الباردة❄️ . عطر في منتهى الأنوثة و الجاذبية لا تفوتوا تجربته استسلم للروائح الشرقية للعطر الجديد La Belle le Parfum من Jean-Paul Gaultier. قصيدة للأنوثة الفائقة ، مركّزة في زجاجة حمراء ذات منحنيات مدمرة ، تعلوها عقد من الورود الذهبية. تغلفك المكونات الشرقية والذواقة لهذا العطر الجذاب طوال اليوم. استسلم للإغراء اليوم واكتشف العطر النسائي', 'products/nyNHM7Npw3PEPrAD5mWK4cIBunC7n9Jh1f3lP2Cf.jpg', NULL, NULL, '2025-12-02 21:23:49', '2025-12-02 21:23:49'),
(276, 88, 'ready', 79, 'Bonbon viktor and rolf 🍬 For women', 'اخيرا بونبون 🔥🔥  بونبون وهي اسم علي مسمي بجد   كراميل وشوجري🩷🧡 كل اللي عايز حاجه سيكسي بجد ياخدها حلووووووه موووت🙈🙈🙈  جديدة معانا 30 ml 💥💥 Travel size 30 ml Bonbon Viktor&Rolf  عطر زهري - فواكه إفتتاحية العطر الخوخ, الماندرين (اليوسفي) و البرتقال; قلب العطر الكاراميل, زهر البرتقال و الياسمين;  قاعدة العطر تتكون من العنبر, خشب الصندل, أخشاب الغاياك و خشب الأرز.حجم 100 مللي', 'products/JMFlSvdgJBttxkd8x6rgcdyHRw6U5RC27DkC3hHg.jpg', NULL, NULL, '2025-12-02 21:25:10', '2025-12-02 21:25:10'),
(278, 89, 'ready', 71, 'بيتزا', 'بيتزا فراخ وجبنه', 'products/4gCkUX1LlwZCIPf1K81WUnNpcXOJj7p8NJmNHGSI.jpg', NULL, NULL, '2025-12-04 19:52:25', '2025-12-04 19:52:25'),
(279, 89, 'ready', 71, 'وجبه فراخ', 'نص فرخه مع بطاطس مع رز مع صلصات', 'products/CWc2CQebFUwRJthRQcfAiqxwR8WXnlpNt3tdE3Ye.jpg', NULL, NULL, '2025-12-04 19:54:02', '2025-12-04 19:54:02'),
(280, 89, 'ready', 71, 'مكرونه بشامل', 'مكرونه بشامل بصوص الفراخ', 'products/bUAHD5j8zt9CleueYb2Rsp6fSbQIO7EDzib1iD6F.jpg', NULL, NULL, '2025-12-04 19:54:50', '2025-12-04 19:54:50'),
(281, 89, 'ready', 71, 'سلطه خضراوات', 'سلطه خضراوات', 'products/5E5KvC6QEqS1ok0vfhFlhyx7QtCWn0j1iYPHNLpd.jpg', NULL, NULL, '2025-12-04 19:55:41', '2025-12-04 19:55:41'),
(282, 90, 'ready', 71, 'عصير فراوله', 'عصير فراوله', 'products/goqXmrYKUzCBZskEYZXeHhviEioJjphPKDpQ9rKV.jpg', NULL, NULL, '2025-12-04 20:01:32', '2025-12-04 20:01:32'),
(283, 90, 'ready', 71, 'عصير لمون', 'عصير لمون طازه', 'products/dfFRFU1Qd43xk4nAOYMrACcA6s6LPqQxnXflc1hm.jpg', NULL, NULL, '2025-12-04 20:02:21', '2025-12-04 20:02:21'),
(284, 90, 'ready', 71, 'عصير توت', 'عصير توت طازه', 'products/ICdCKEuu1kKuSbazp07tDQOsMNXw9ROJSU2ooQw1.jpg', NULL, NULL, '2025-12-04 20:04:39', '2025-12-04 20:04:39'),
(285, 90, 'ready', 71, 'عصير برتقال', 'عصير برتقال طازه', 'products/cemGZKLVVnNwMjFJDhNfCND8KtIsJoMWXsGVUKoE.jpg', NULL, NULL, '2025-12-04 20:05:48', '2025-12-04 20:05:48'),
(286, 90, 'ready', 71, 'عصير انناس', 'عصير انناس طازه', 'products/7roYlrF4JzKZ1BfIi69ykxKa0uzc7ULve3fTuTZT.jpg', NULL, NULL, '2025-12-04 20:07:06', '2025-12-04 20:07:06'),
(287, 91, 'ready', 71, 'شاي', 'شاي فتله', 'products/lQPud4Gz7buMpWTC6QD8xdlBlbdT1CKQcT0ha1wG.jpg', NULL, NULL, '2025-12-04 20:13:56', '2025-12-04 20:13:56'),
(288, 91, 'ready', 71, 'نسكافيه بالبن', 'نسكافيه باللبن', 'products/NL5Mnfr7M5kEKexWrstPWpGAqpEWOFmLD5ZCsqXS.jpg', NULL, NULL, '2025-12-04 20:14:45', '2025-12-04 20:14:45'),
(289, 91, 'ready', 71, 'شيكولاتا سخنه', 'شيكولاتا سخنه', 'products/EEArj15iPPHZkJ8fCxcGSRoc5VEKyU1Eu4wQIw3P.jpg', NULL, NULL, '2025-12-04 20:15:33', '2025-12-04 20:15:33'),
(290, 91, 'ready', 71, 'قهوه مانو', 'شهوه مانو', 'products/Xfrq5QUeWaQDlConjGviiYXGyGBEECFxTEeSL82A.jpg', NULL, NULL, '2025-12-04 20:16:40', '2025-12-04 20:16:40'),
(291, 91, 'ready', 71, 'شاي بالنعناع', 'شاي بالنعناع', 'products/P6P8C3RRAFVOd9xS0b2pdRGaIqt4RlehBYsc83rt.jpg', NULL, NULL, '2025-12-04 20:18:18', '2025-12-04 20:18:18'),
(293, 92, 'ready', 71, 'عطور بلو', 'اجود انواع العطور', 'products/67qyIJRxotQb5exfrxMbrYWqgePTTZOOGdLFkmdZ.jpg', NULL, NULL, '2025-12-04 20:24:49', '2025-12-04 20:24:49'),
(294, 92, 'ready', 71, 'عطور برادا', 'اجود انواع العطور', 'products/yKrAqoZe11ArpjaXk0B5JqDFGPmzlKhiNsudDmEt.jpg', NULL, NULL, '2025-12-04 20:25:31', '2025-12-04 20:25:31'),
(295, 92, 'ready', 71, 'عطور سوفاج', 'اجود انواع العطور', 'products/ZzZb6HHXugOxCqOxRDdHKEWCO8ukZ7n1gVwADSIH.jpg', NULL, NULL, '2025-12-04 20:26:42', '2025-12-04 20:26:42'),
(296, 92, 'ready', 71, 'عطور فرانك', 'اجود انواع العطور', 'products/e3Gt64Fab83sEogUAHvqGfVBZcqGgpxiK1xPK76e.jpg', NULL, NULL, '2025-12-04 20:27:41', '2025-12-04 20:27:41'),
(297, 92, 'ready', 71, 'عطور سكندال', 'اجود انواع العطور', 'products/4BAqqj7zKCHSDqOSM0Syn2uVciLvjqvu5VTqZO26.jpg', NULL, NULL, '2025-12-04 20:28:18', '2025-12-04 20:28:18'),
(298, 93, 'ready', 80, 'كلاسيك برجر', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+تيستي', 'products/CCwawi6cR9yJDeQs2LOwLUqswJ70TR3UE1EVJZSS.jpg', NULL, NULL, '2025-12-08 17:48:02', '2025-12-08 17:48:02'),
(299, 93, 'ready', 80, 'بيكون', 'شريحة لحم+صوص شيدر +خص+خيار مخلل+تيستي بيكون', 'products/WGWYDWD1sGCOISCBE4EPbJl7g9FWnlauQOeOMPFF.jpg', NULL, NULL, '2025-12-08 17:52:14', '2025-12-08 17:52:14'),
(300, 93, 'ready', 80, 'تشيز', 'قطعة لحم١٥٠ جرام +صوص شيدر+خص+خيار مخلل+شريحة جبنه شيدر+تيستي', 'products/uCkngliyRKSrrlR7eRen7ui8NOFd18xTUIU47aU8.jpg', NULL, NULL, '2025-12-08 17:55:47', '2025-12-08 17:55:47'),
(301, 93, 'ready', 80, 'مشروم', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+مشروم', 'products/i6eTEYgfOYp9bnfyWsibAiTdGiTeZomSjwqtafoS.jpg', NULL, NULL, '2025-12-08 17:58:34', '2025-12-08 17:58:34'),
(302, 93, 'ready', 80, 'BunnBeef', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+موتزريلا ستيكس', 'products/HjdrNBMA6YrJSrFGlcDaZL7B4WrCH4gO5ufBhjsG.jpg', NULL, NULL, '2025-12-08 18:02:26', '2025-12-08 18:02:26'),
(303, 93, 'ready', 80, 'ميكس بيف فرايد', 'قطعة لحم١٥٠ جرام +قطعة فراخ ١٠٠جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل', 'products/8WzRKYh8YX5fagJ19rg1e4W9jbv1qyEDe4bOT0Ep.jpg', NULL, NULL, '2025-12-08 18:11:54', '2025-12-08 18:11:54'),
(304, 94, 'ready', 80, 'كلاسيك', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل', 'products/6ws3htAwYtc54oxU72fK7VS2kVmJtr8AwydJe4ru.jpg', NULL, NULL, '2025-12-08 18:14:36', '2025-12-08 18:14:36'),
(305, 94, 'ready', 80, 'بيكون', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+بيكون', 'products/MYFvKu7AUDo0gfsRzI90Zbj4gLOdJXfeW5wTbBZv.jpg', NULL, NULL, '2025-12-08 18:16:38', '2025-12-08 18:16:38'),
(306, 94, 'ready', 80, 'مشروم', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+مشروم', 'products/qi24y0DrJCAzDACq6GFPgK0SbS79Eb271VvOrKAq.jpg', NULL, NULL, '2025-12-08 18:18:19', '2025-12-08 18:18:19'),
(307, 94, 'ready', 80, 'بافلو', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+بافلو', 'products/o7T1lDaKAkjebzIAAEGg3FpPHudmFRJZTA19DgXA.jpg', NULL, NULL, '2025-12-08 18:22:27', '2025-12-08 18:22:27'),
(308, 94, 'ready', 80, 'بيكون مشروم', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+مشروم+بيكون', 'products/blJt0bF7DdFzWdLPdFaNQJMrYkpmRXDf8rBKYFTV.jpg', NULL, NULL, '2025-12-08 18:24:30', '2025-12-08 18:24:30'),
(309, 95, 'ready', 80, 'كلاسيك', 'قطعة فراخ ١٠٠ جرام +مايونيز +صوص شيدر+خص+خيار مخلل', 'products/EfMeiFM8vNKUgbxcJrlCycVR362NvjSVuswfEjVb.jpg', NULL, NULL, '2025-12-08 18:27:35', '2025-12-08 18:27:35'),
(311, 95, 'ready', 80, 'تركي', 'قطعة فراخ ١٠٠ جرام +مايونيز +صوص شيدر+خص+خيار مخلل+تركي', 'products/9m8va3MFoXKXQunu6WwQR4eEtUuV0OYZm8DRFxuJ.jpg', NULL, NULL, '2025-12-08 18:30:41', '2025-12-08 18:30:41'),
(312, 95, 'ready', 80, 'رانش', 'قطعة فراخ ١٠٠ جرام +صوص رانش+صوص شيدر+خص+خيار مخلل', 'products/8MHVSlfrIr96q1KiZQRyltxf9vwQi96IXqx4p5GO.jpg', NULL, NULL, '2025-12-08 18:34:13', '2025-12-08 18:34:13'),
(313, 95, 'ready', 80, 'بافلو', 'قطعة فراخ ١٠٠ جرام +صوص بافلو+صوص شيدر+خص+خيار مخلل', 'products/6XvTQQwoFPlhWLAVgf9wuFM9eE3A5QIkBixhdhB1.jpg', NULL, NULL, '2025-12-08 18:36:33', '2025-12-08 18:36:33'),
(314, 95, 'ready', 80, 'بنن بيف', 'قطعة فراخ ١٠٠ جرام +موتزريلا ستكس+تركي+صوص شيدر+خص+خيار مخلل+تيستي', 'products/xci1eLQXnsoHyQwCDSI8M41OyTIfFhjGsB3PXYT1.jpg', NULL, NULL, '2025-12-08 18:46:43', '2025-12-08 18:46:43'),
(315, 95, 'ready', 80, 'مدخن جريل', 'خص+خيار مخلل+قطعه فراخ ١٥٠ جرام علي الجريل +صوص شيدر+تيستي', 'products/Fcjp3BlUgHi0k0CwwdwYNu6TbU1mc5GlUFNmbqa0.jpg', NULL, NULL, '2025-12-08 18:55:44', '2025-12-08 18:55:44'),
(316, 96, 'ready', 80, 'باكت فرايز', 'باكت فرايز', 'products/sAAWJ0kRnx7ujXpOm72XF7s23asQmYEGVGPq5Kxk.jpg', NULL, NULL, '2025-12-08 18:58:39', '2025-12-08 18:58:39'),
(317, 96, 'ready', 80, 'فرسكس فرايز', 'فرسكس فرايز', 'products/uxvYpVXvgp9VdCCXU6Yy74je4otvnheyLfqv9g3M.jpg', NULL, NULL, '2025-12-08 19:00:13', '2025-12-08 19:00:13'),
(318, 96, 'ready', 80, 'بافلو فرايز', 'بافلو فرايز', 'products/KUi8FaLrvz7mSoiEGkfmCtJshWIMZlwv1tePNqPj.jpg', NULL, NULL, '2025-12-08 19:02:09', '2025-12-08 19:02:09'),
(319, 96, 'ready', 80, 'بيكون فرايز', 'بيكون فرايز', 'products/Z25VaXvLwOhI8QAYlTbiTXezb76Ub8FJjelD3QiN.png', NULL, NULL, '2025-12-08 19:03:40', '2025-12-08 19:03:40'),
(320, 96, 'ready', 80, 'تشيز فرايز', 'تشيز فرايز', 'products/IvIxYLNFlg6VUWqhfaBFmHVjjzeSohwgPTy10UbB.jpg', NULL, NULL, '2025-12-08 19:07:04', '2025-12-08 19:07:04'),
(321, 96, 'ready', 80, 'كرانشي فرايز', 'كرانشي فرايز', 'products/n9A1OdPEvdA5iVxaLVwIOJK4GGbMPzzOnwZUxsRS.webp', NULL, NULL, '2025-12-08 19:08:53', '2025-12-08 19:08:53'),
(322, 96, 'ready', 80, 'تشيلي فرايز', 'تشيلي فرايز', 'products/wJVUM6qXHREjpG6oh2Hu8aEU9ihmHQDb2ita8GOk.jpg', NULL, NULL, '2025-12-08 19:10:28', '2025-12-08 19:10:28'),
(323, 96, 'ready', 80, 'حلقات بصل', 'حلقات بصل 6 قطع', 'products/Tzr0U4JZ0qz81wCnEUqnvExFcm4uSglfEnAUzVll.png', NULL, NULL, '2025-12-08 19:11:59', '2025-12-08 19:11:59'),
(324, 96, 'ready', 80, 'موتزريلا ستيكس', 'موتزريلا ستيكس ٣ قطع', 'products/qa9XrGucK16COSbVHGaMJO8vDmTQHD9lyEdK9tmz.webp', NULL, NULL, '2025-12-08 19:13:18', '2025-12-08 19:13:18'),
(325, NULL, 'ready', 80, 'كفته بلدي', 'كفته بلدي +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/SZzOfRULfQHZ66VjCkaFEipEgv1MCvxDW7yl5nFT.jpg', NULL, NULL, '2025-12-08 19:46:26', '2025-12-08 19:51:28'),
(326, NULL, 'ready', 80, 'سجق بلدي', 'سجق بلدي +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/AL1f1TZbmZzupMykkHBHDtV5sQZErGtbzgdgy2T4.jpg', NULL, NULL, '2025-12-08 19:48:15', '2025-12-08 19:51:09'),
(328, NULL, 'ready', 80, 'شيش طاووق', 'شيش طاووق +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/uUkqeNVhO9dus5McDi74HnAo2oRbBAGLwecLMQhp.jpg', NULL, NULL, '2025-12-08 19:53:00', '2025-12-08 19:53:00'),
(330, 97, 'ready', 80, 'ساندوتش كفتة', 'ساندوتش كفتة + علبه طحينة+علبة سلطة', 'products/mOOKXP7krAOsqbBrIWJK9mYJmcY2nqyZk5Kgjsw3.jpg', NULL, NULL, '2025-12-08 19:59:19', '2025-12-08 19:59:19'),
(332, 97, 'ready', 80, 'ساندوتش شيش طاووق', 'شيش طاووق +كاتشب', 'products/9fSQ0Cvtp2qUp4fOlFNWBGhjqSaNoh21iFEhUr6s.jpg', NULL, NULL, '2025-12-08 20:06:01', '2025-12-08 20:06:17'),
(333, 97, 'ready', 80, 'ساندوتش تشكن رنش', 'تشكن رنش+كاتشب', 'products/h6fln6ljXkpMAESeAoHmQrJpFijmiGSy6cwlBTxi.png', NULL, NULL, '2025-12-08 20:08:01', '2025-12-08 20:08:01'),
(334, 97, 'ready', 80, 'ساندوتش حواوشي كبير', 'حواوشي+كاتشب +طحينة', 'products/ACmf97teHvTWnr92zXvsvDIM9Yq2PmCwgIsoMYlZ.jpg', NULL, NULL, '2025-12-08 20:09:41', '2025-12-24 14:33:06'),
(335, 97, 'ready', 80, 'ساندوتش حوواوشي جبنة', 'حوواوشي جبنة+طحينة+كاتشب', 'products/yxSHAqmDvNZ4pyjx82ag4olyDh0YzxkPhOmbMUeo.avif', NULL, NULL, '2025-12-08 20:14:01', '2025-12-08 20:14:01'),
(336, 97, 'ready', 80, 'ساندوتش بطاطس', 'ساندوتش بطاطس+صوص+كاتشب', 'products/nXggwWl5nfI1lTCLrWc9EnMma3txplEfPWIPBMDf.jpg', NULL, NULL, '2025-12-08 20:20:28', '2025-12-08 20:20:28'),
(337, 98, 'ready', 80, 'استربس', 'استربس+كاتشب', 'products/mxLk29BLod7vVZG6nITrPeXYIT2aK6CYG4ZOSznj.jpg', NULL, NULL, '2025-12-08 20:22:53', '2025-12-08 20:22:53'),
(338, 98, 'ready', 80, 'شيش فحم', 'شيش فحم+كاتشب', 'products/sufQqPWn7MlmNu5ArXvNJSgKXMx8FrG23vIYnrdu.jpg', NULL, NULL, '2025-12-08 20:24:54', '2025-12-08 20:24:54'),
(339, 98, 'ready', 80, 'كرسبي حار', 'كرسبي حار+كاتشب', 'products/JF44c8JtWtd4q40RZjq3LOMhitCkODt6UMDjCn9X.jpg', NULL, NULL, '2025-12-08 20:26:36', '2025-12-08 20:26:36'),
(340, 98, 'ready', 80, 'ميكس فراخ', 'ميكس فراخ+كاتشب', 'products/hSArqKj593JUTy4hLqPREaoiNw6UISaRT5OnSIKF.jpg', NULL, NULL, '2025-12-08 20:28:35', '2025-12-08 20:28:35'),
(341, 98, 'ready', 80, 'ميكس لحوم', 'ميكس لحوم +كاتشب', 'products/6X5i7VKnbgQ6E5MqakJpntBkWsuiAOKW6q0fIbFa.jpg', NULL, NULL, '2025-12-08 20:30:17', '2025-12-08 20:30:17'),
(342, 98, 'ready', 80, 'كريب بطاطس', 'بطاطس+كاتشب', 'products/I5jjiqpOA7vcdp1Ni3ma7YcTZrGmyhiIZQMhdg03.jpg', NULL, NULL, '2025-12-08 20:31:58', '2025-12-08 20:31:58'),
(343, 100, 'ready', 80, 'ارز بسمتي', 'ارز بسمتي', 'products/blEG0sQ70mzHSHrmvXh9Hd8cvyZCq2hjoUnFUjRq.jpg', NULL, NULL, '2025-12-08 20:33:42', '2025-12-08 20:33:42'),
(344, 100, 'ready', 80, 'سلطة بلدي', 'سلطة بلدي', 'products/4GLvGpPeLnaGdjv0Fr2zJs8Tz9rXvIlYr9bmYrgQ.jpg', NULL, NULL, '2025-12-08 20:34:56', '2025-12-08 20:34:56'),
(345, 100, 'ready', 80, 'سلطة فريش', 'سلطة فريش', 'products/E6150IVrgKancDashqWQSwAl43X5uuicEnftoEVD.jpg', NULL, NULL, '2025-12-08 20:37:25', '2025-12-08 20:37:25'),
(346, 100, 'ready', 80, 'مخلل', 'مخلل', 'products/9VUyO5FgzdMoz40Gq0anG8NfAiqWZvDqVMU8PX5v.jpg', NULL, NULL, '2025-12-08 20:38:29', '2025-12-08 20:38:29'),
(347, 100, 'ready', 80, 'مشروم', 'مشروم', 'products/d5Dm5xDjmZmhEMYJ7DGszhONUoanll9hwdZJzLvg.jpg', NULL, NULL, '2025-12-08 20:39:45', '2025-12-08 20:39:45'),
(348, 100, 'ready', 80, 'تيستي', 'تيستي', 'products/fzH7xHYqfoymVA2yXJczedlhJ5d37n7zMDX5qvD1.webp', NULL, NULL, '2025-12-08 20:41:14', '2025-12-08 20:41:14'),
(349, 100, 'ready', 80, 'رانش', 'رانش', 'products/6ynxPTuPstv3EJTIX3kQp1uoT9ijkzBoPRsaHsyv.webp', NULL, NULL, '2025-12-08 20:42:44', '2025-12-08 20:42:44'),
(350, 100, 'ready', 80, 'صوص شيدر', 'صوص شيدر', 'products/vsIWlBhXcNBf1fn7s7nWzl3Y1WX3hRKlRjdqBrOl.jpg', NULL, NULL, '2025-12-08 20:43:49', '2025-12-08 20:43:49'),
(351, 100, 'ready', 80, 'باربكيو', 'باربكيو', 'products/CUDoRAx6Rnupzb2fXnzdNy6BGaZToGzjnbJ08osQ.jpg', NULL, NULL, '2025-12-08 20:45:14', '2025-12-08 20:45:14'),
(352, NULL, 'ready', 80, 'ربع فرخه+1/8كفته', 'ربع فرخه+1/8كفته+رز+سلطة+طحينة', 'products/e6r60P2bUwiVrrJNdg1qp6ToRw9M5uBb1NybrcOH.webp', NULL, NULL, '2025-12-08 20:50:11', '2025-12-08 20:50:11'),
(353, NULL, 'ready', 80, 'وجبة ربع شيش +تمن كفتة', 'وجبة ربع شيش +تمن كفتة +رز+سلطه+طحينة', 'products/Q35yTZwrnkJhql6Fp49VJkvwUO9TVJOHvFosSILc.png', NULL, NULL, '2025-12-08 20:55:59', '2025-12-08 20:55:59'),
(354, NULL, 'ready', 80, 'وجبة ربع شيش تمن كفته تمن سجق', 'ربع شيش تمن كفته تمن سجق+رز+سلطة+طحينة', 'products/CNTDel4J7HlRkyNSBGn49ww1LSdgQBmPIIniG1zr.png', NULL, NULL, '2025-12-08 21:00:26', '2025-12-08 21:00:26'),
(356, 105, 'ready', 71, 'ورد نانو', 'ورد', 'products/aYdPGHur8JprhyDpWwQuNDBmRI0AKbU13p9dvgrk.jpg', NULL, NULL, '2025-12-09 10:45:12', '2025-12-09 10:45:12'),
(357, NULL, 'ready', 71, 'ورد نانو', 'ورد', 'products/ll3fn0nD1nsO3PZ12IVOTZUZtiUikc2l62BiqkDI.jpg', NULL, NULL, '2025-12-09 10:45:38', '2025-12-09 10:45:38'),
(358, 105, 'ready', 71, 'ورد نانو', 'ورد', 'products/Jq9yBHzzsCQN6fj3ze3mPg9zfrjTQg5f7EJGy2z0.jpg', NULL, NULL, '2025-12-09 10:46:47', '2025-12-09 10:46:47'),
(359, 105, 'ready', 71, 'ورد نانو', 'ورد', 'products/GjTYbO6QoGcQEbH7y1IXCgoggS0IQzjyaKARtZpi.jpg', NULL, NULL, '2025-12-09 10:47:07', '2025-12-09 10:47:07'),
(360, 105, 'ready', 71, 'ورد نانو', 'ورد', 'products/STcFzt2rw9GZGiWX8WFP2nILSEB7VbrWd9haDEsW.jpg', NULL, NULL, '2025-12-09 10:47:30', '2025-12-09 10:47:30'),
(361, 105, 'ready', 71, 'ورد نانو', 'ورد', 'products/zg6Iv5Jh1d7i1VkM6Y1I3IzeVEZStdkUPfgex45d.jpg', NULL, NULL, '2025-12-09 10:48:00', '2025-12-09 10:48:00'),
(362, 103, 'ready', 71, 'سجاد نانو', 'سجاد', 'products/F3ugiVtzl6CP0urPKv3Fk8iYR1D6FtNV79SUXNQ0.jpg', NULL, NULL, '2025-12-09 10:48:45', '2025-12-09 10:48:45'),
(363, 103, 'ready', 71, 'سجاد نانو', 'سجاد', 'products/ddhUSvLhk88BZ9yWACFaUkVFcsfZ7SNfz8Y0ISrm.jpg', NULL, NULL, '2025-12-09 10:49:10', '2025-12-09 10:49:10'),
(364, 103, 'ready', 71, 'سجاد نانو', 'سجاد', 'products/zzXA6CeMyIjviNlEcUGYiyMCO3UkdHf3u4aPNIn4.jpg', NULL, NULL, '2025-12-09 10:49:32', '2025-12-09 10:49:32'),
(365, 103, 'ready', 71, 'سجاد نانو', 'سجاد', 'products/38w7M948fE0g5fyJetZkNM574Eb1k4UlGx9xJlXy.jpg', NULL, NULL, '2025-12-09 10:50:02', '2025-12-09 10:50:02'),
(366, 103, 'ready', 71, 'سجاد نانو', 'سجاد', 'products/ibNu8AZrOocbNAhv9HTZhfBlih7XRlXsTyrI0ZGq.jpg', NULL, NULL, '2025-12-09 10:50:26', '2025-12-09 10:50:26'),
(367, 106, 'ready', 71, 'ذهب نانو', 'ذهب', 'products/xSjsWlTyDnHy1XwrcdfguzcdiXAqa2lQJ4kIqWED.jpg', NULL, NULL, '2025-12-09 10:50:59', '2025-12-09 10:50:59'),
(368, 106, 'ready', 71, 'ذ', 'ذهب', 'products/4XLjSF8Rz9n0Z7FTslblGyOBqkK1769sV22BLdr9.jpg', NULL, NULL, '2025-12-09 10:51:26', '2025-12-09 10:51:26'),
(369, 106, 'ready', 71, 'ذهب نانو', 'ذهب', 'products/bN21uQdqFhNtnrYyGXuvAMqeFsGsb9e6cp4faTEJ.jpg', NULL, NULL, '2025-12-09 10:51:53', '2025-12-09 10:51:53'),
(370, 106, 'ready', 71, 'ذهب نانو', 'ذهب', 'products/rdapLyT4uy2p11BbuxqO88JhUwZW8xKmVLzFLBJ1.jpg', NULL, NULL, '2025-12-09 10:52:20', '2025-12-09 10:52:20'),
(371, 106, 'ready', 71, 'ذهب نانو', 'ذهب', 'products/XaNZebgEMPWKLX27NcoKnr6CWA2hdhmPz4w5UOyz.jpg', NULL, NULL, '2025-12-09 10:52:43', '2025-12-09 10:52:43'),
(376, 108, 'ready', 71, 'ادوات منزليه نانو', 'ادوات منزليه', 'products/uN0vwvuzkkn33jkjBwS64tQABBFRmVNsOUG8WkhJ.jpg', NULL, NULL, '2025-12-09 10:54:58', '2025-12-09 10:54:58'),
(377, 108, 'ready', 71, 'ادوات منزليه نانو', 'ادوات منزليه', 'products/5WOTMJZbpsMuvtbOYr0dHtbz0DQRst5G1T8SJ7XI.jpg', NULL, NULL, '2025-12-09 10:55:21', '2025-12-09 10:55:21'),
(378, 108, 'ready', 71, 'ادوات منزليه نانو', 'ادوات منزليه', 'products/25aCCMC0dGSEPUEfbclZwiICwSjLrfgwjoVT6k5E.jpg', NULL, NULL, '2025-12-09 10:55:40', '2025-12-09 10:55:40'),
(379, 108, 'ready', 71, 'ادوات منزليه نانو', 'ادوات منزليه', 'products/zSnZ2psaL4LF4zwV9pV8D0KjpKLs6097Fu2y3b6k.jpg', NULL, NULL, '2025-12-09 10:55:58', '2025-12-09 10:55:58'),
(380, 108, 'ready', 71, 'ادوات منزليه نانو', 'ادوات منزليه', 'products/FyeoXfOTEdVue45PzYzp6RmcGEHmKtl7gs2kdHrc.jpg', NULL, NULL, '2025-12-09 10:56:12', '2025-12-09 10:56:12'),
(381, 109, 'ready', 84, 'كرسبي', 'كرسبي', 'products/dMXbLOhCGM7RrZNz9ErUPL8UGnKmi3g14Ykcybow.jpg', NULL, NULL, '2025-12-09 13:29:03', '2025-12-09 13:29:03'),
(382, 109, 'ready', 84, 'زنجر', 'زنجر', 'products/1B8LzcNDYMOHETESDqDac2s6y4bKbiD7xwnMLkMA.jpg', NULL, NULL, '2025-12-09 13:31:02', '2025-12-09 13:31:31'),
(383, 109, 'ready', 84, 'سوبريم', 'سوبريم', 'products/uWEYCRw3Fcs2kqOXc6J6vt8XZRtsGfhdhUwITYFq.jpg', NULL, NULL, '2025-12-09 13:36:47', '2025-12-09 13:36:47'),
(384, 109, 'ready', 84, 'فاهيتا دجاج', 'فاهيتا دجاج', 'products/l9ixWwpgJs0AIYXLEgRWxefounYkJ5PxLTbFvcTw.jpg', NULL, NULL, '2025-12-09 13:38:46', '2025-12-09 13:38:46'),
(385, 109, 'ready', 84, 'مكسيكانو', 'مكسيكانو', 'products/k5Nrph17O0l9xCJri8keU5LfgyRFCwAimDOPhTin.jpg', NULL, NULL, '2025-12-09 13:39:53', '2025-12-09 13:39:53'),
(386, 109, 'ready', 84, 'شيش طاووق', 'شيش طاووق', 'products/cXCOB4F3ytOsuDMU7EH1BlDU2WARSdw3MVHHKJmC.jpg', NULL, NULL, '2025-12-09 13:41:50', '2025-12-09 13:41:50'),
(387, 109, 'ready', 84, 'ماريا كريسبي', 'ماريا كريسبي', 'products/O35pe7oX8VDPeOhf8xl6MxLVwtUPq9TacyMDAXyj.jpg', NULL, NULL, '2025-12-09 13:44:28', '2025-12-09 13:44:28'),
(388, 109, 'ready', 84, 'بطاطس مكس جبن', 'بطاطس مكس جبن', 'products/sVBgUrJoKaAZXkeK62PIo0VZFBnoyReqZqSRpXQw.jpg', NULL, NULL, '2025-12-09 13:46:12', '2025-12-09 13:46:12'),
(389, 109, 'ready', 84, 'بطاطس', 'بطاطس', 'products/MtUDdXt7PKaUiD9rCujHMFKDKJozhDGYjYTkZqcM.jpg', NULL, NULL, '2025-12-09 13:52:16', '2025-12-09 13:52:16'),
(390, 109, 'ready', 84, 'بطاطس موتزريلا\\شيدر', 'بطاطس موتزريلا\\شيدر', 'products/CeTAivFErYJEi9MDkD5VMg8MXrRYH3eMaGxrLvIt.jpg', NULL, NULL, '2025-12-09 13:53:37', '2025-12-09 13:53:37'),
(391, 109, 'ready', 84, 'بطاطس صيامي', 'بطاطس صيامي', 'products/7Wg26dneJA7o0D5elHwrrq9WPkRUjBR3EWWLLu7l.jpg', NULL, NULL, '2025-12-09 13:54:38', '2025-12-09 13:54:38'),
(392, 110, 'ready', 84, 'وجبه كرسبي', '( قطع دجاج مقرمش + أرز + بطاطس + توميه + عيش + مخلل )', 'products/nxB89ARIosthJleEGI2ayvTcMJwfRCKSBgb0gqVX.jpg', NULL, NULL, '2025-12-09 13:56:51', '2025-12-09 13:56:51'),
(393, 110, 'ready', 84, 'وجبه زنجر', '( قطع الدجاج المقرمش الحار + ارز + بطاطس + توميه + عيش + مخلل )', 'products/lDjY93yKIDDVNq5h8YGLwXeWAbMxVvI2lqnyglqH.jpg', NULL, NULL, '2025-12-09 14:01:20', '2025-12-09 14:01:20'),
(394, 110, 'ready', 84, 'وجبه سوبريم', '( قطع دجاج رول محشو موتزريلا + ارز + بطاطس + توميه + عيش + مخلل )', 'products/QpXD0dMCk2fjxGyWKjhXKOSnTe8wNMpjNvUUf3a4.jpg', NULL, NULL, '2025-12-09 14:03:45', '2025-12-09 14:03:45'),
(395, 110, 'ready', 84, 'وجبه سوبريم', '( قطع دجاج رول محشو موتزريلا + ارز + بطاطس + توميه + عيش + مخلل )', 'products/EtGAdXV85OqiFsE0Uuqh0bhMPovUVX2RpBUfNf4c.jpg', NULL, NULL, '2025-12-09 14:03:51', '2025-12-09 14:03:51'),
(396, 110, 'ready', 84, 'وجبه فاهيتا دجاج', '( قطع دجاج بصوص الفاهيتا مع الفلفل الألوان + أرز + بطاطس + توميه + عيش + مخلل )', 'products/4AcSnLiO1BFaY0jrcRnnxNhux3TlDQDIptbxTvi1.jpg', NULL, NULL, '2025-12-09 14:07:26', '2025-12-09 14:07:26'),
(397, 110, 'ready', 84, 'وجبه مكسيكانو', '( قطع دجاج بالصوص الحار + أرز + بطاطس + توميه + عيش + مخلل )', 'products/5w81f5wWFjpV7RHVS5Y9taDzBqIZTFKbwXyCvFMl.jpg', NULL, NULL, '2025-12-09 14:09:29', '2025-12-09 14:09:29'),
(398, 110, 'ready', 84, 'وجبه شيش طاووق', '( قطع دجاج شيش طاووق + ارز + بطاطس + اوكيه + عيش + مخلل )', 'products/e4PEDkGZNdxAVXOtYmOQ6zJnymsBwIKh0xOeVd7V.jpg', NULL, NULL, '2025-12-09 14:12:27', '2025-12-09 14:12:27'),
(399, 111, 'ready', 84, 'ساندوتش شاورما وسط', 'ساندوتش شاورما وسط', 'products/dd81pYTblFaeMXGicXGwyeLAD9ZfiTMiRsLbHEB2.jpg', NULL, NULL, '2025-12-09 14:17:22', '2025-12-09 14:17:22'),
(400, 111, 'ready', 84, 'ساندوتش شاورما كبير', 'ساندوتش شاورما كبير', 'products/9rTTV85Fy8A1t2J4uIXcTvdyucgkWtn8O1FW4i6v.jpg', NULL, NULL, '2025-12-09 14:18:33', '2025-12-09 14:18:33'),
(401, 111, 'ready', 84, 'ساندوتش شاورما صاروخ', 'ساندوتش شاورما صاروخ', 'products/n1HMZllMk6TWYCe3QfKhqyC3fvKT5qYmD1KX1SS0.jpg', NULL, NULL, '2025-12-09 14:19:58', '2025-12-09 14:19:58'),
(402, 111, 'ready', 84, 'شاورما عربي سنجل', 'شاورما عربي سنجل', 'products/FfjcQsFr93iYvP1fmQYkPo2Et6SWn1eSnFJ0QEUp.jpg', NULL, NULL, '2025-12-09 14:21:19', '2025-12-09 14:21:19'),
(403, 111, 'ready', 84, 'شاورما عربي دبل', 'شاورما عربي دبل', 'products/tWhJEsYCL58mbc9w2onlHuQt6JLRgRYRi1v5df7w.jpg', NULL, NULL, '2025-12-09 14:23:16', '2025-12-09 14:23:16'),
(404, 111, 'ready', 84, 'شاورما ماريا', 'شاورما ماريا', 'products/FPPOYsva1XeEFLRXknfb0CcIs0bjX9QLeqhetfRj.jpg', NULL, NULL, '2025-12-09 14:25:06', '2025-12-09 14:25:06'),
(405, 111, 'ready', 84, 'فته شاورما كبير', 'فته شاورما كبير', 'products/OGbG3UkZR3uVxoDJMKfMsqXPpZPm30AMjSgtnlzP.jpg', NULL, NULL, '2025-12-09 14:26:49', '2025-12-09 14:26:49'),
(406, 112, 'ready', 84, 'دجاج شوايه كامله', 'دجاج شوايه كامله', 'products/InO1ITRH0NyUjiHJBntC92uQ1gno2F7kJfszwTmt.jpg', NULL, NULL, '2025-12-09 14:29:53', '2025-12-09 14:29:53'),
(407, 112, 'ready', 84, 'نصف دجاجه شوايه', 'نصف دجاجه شوايه', 'products/T6Y66gGDX1oedqiJIoQkqNlCn3YmQzk0C7KvPyx8.jpg', NULL, NULL, '2025-12-09 14:30:56', '2025-12-09 14:30:56'),
(408, 112, 'ready', 84, 'ربع دجاجه ورك شوايه', 'حسب المتاح', 'products/Pgk3YVtjNu2SSKuITsFpQPWvL0hbGoZO1QJzIUAq.jpg', NULL, NULL, '2025-12-09 14:33:26', '2025-12-09 14:33:26'),
(409, 112, 'ready', 84, 'ربع دجاجه صدر شوايه', 'حسب المتاح', 'products/TVnklrE86DymeMbzDANqQ6XSYNbT09nGtthsr0m5.jpg', NULL, NULL, '2025-12-09 14:35:57', '2025-12-09 14:35:57'),
(410, 112, 'ready', 84, 'دبل ورك دجاج شوايه', 'يقدم معها (أرز بسمتي + بطاطس + عيش + تومية + مخــلل)', 'products/R3IJt6fIfnCIcp1FRwmz7EqQXs3gbczIVpa4j4V6.jpg', NULL, NULL, '2025-12-09 14:38:10', '2025-12-09 14:38:10'),
(411, 114, 'ready', 84, 'سيزر سلاط', '( سلطه خضرا + قطع شيش طاووق +صوص رانش )', 'products/S5WzSUdmzulMLf7VbsNXGVpw5andlSj8J5ZJqlpi.jpg', NULL, NULL, '2025-12-09 14:39:59', '2025-12-09 14:39:59'),
(412, 114, 'ready', 84, 'توميه', 'توميه', 'products/r0jRpi8XK758kf2u1mJpkBks8rtanm2ZTH8qZyoi.jpg', NULL, NULL, '2025-12-09 14:42:22', '2025-12-09 14:42:22'),
(413, 114, 'ready', 84, 'توميه سبايسي', 'توميه سبايسي', 'products/Vb3YEPEvgsyYIjQxbzywwXqxCHhEC5dm7xAWuVn3.jpg', NULL, NULL, '2025-12-09 14:43:22', '2025-12-09 14:43:22'),
(414, 114, 'ready', 84, 'طحينه', 'طحينه', 'products/s2s4aibIwGh3mraEo41S8p3wiSHWIy8D6DWzFOBr.jpg', NULL, NULL, '2025-12-09 14:44:48', '2025-12-09 14:44:48'),
(415, 114, 'ready', 84, 'كولسلو', 'كولسلو', 'products/ZReI1irSMt7WDZMckRBoliNiNb6ZMJItrYO5wmKh.jpg', NULL, NULL, '2025-12-09 14:45:42', '2025-12-09 14:45:42'),
(416, 114, 'ready', 84, 'فتوش', 'فتوش', 'products/EnL3tCOCu6K2upnTSUTa60arQEWFjvGYfeQ6ZODN.jpg', NULL, NULL, '2025-12-09 14:47:44', '2025-12-09 14:47:44'),
(417, 114, 'ready', 84, 'تبوله', 'تبوله', 'products/WsAZsGULfLYz7x7EXaMDXcxkWxKTqphhlV9WFLrK.jpg', NULL, NULL, '2025-12-09 14:49:21', '2025-12-09 14:49:21'),
(418, 114, 'ready', 84, 'مخلل', 'مخلل', 'products/E5lkUykzq1BQebWhQdXK11cHYePs4oAZnVPzpcsh.jpg', NULL, NULL, '2025-12-09 14:50:28', '2025-12-09 14:50:28'),
(419, 114, 'ready', 84, 'ارز بسمتي', 'ارز بسمتي', 'products/eAWMsVAoD0DMua8KUqFyvKTqx01vaMkjtp5dJrLo.jpg', NULL, NULL, '2025-12-09 14:51:45', '2025-12-09 14:51:45'),
(420, 114, 'ready', 84, 'بطاطس', 'بطاطس', 'products/qmUaN0nEa4MvULTX5b1xFmmoCqou4Es3FbBEbual.jpg', NULL, NULL, '2025-12-09 14:52:27', '2025-12-09 14:52:27'),
(421, 114, 'ready', 84, 'عيش', 'عيش', 'products/L6gtEavR6NG4RPFsclJcnFasvydRRJOpKHmActYr.jpg', NULL, NULL, '2025-12-09 14:53:52', '2025-12-09 14:53:52'),
(422, 113, 'ready', 84, 'وجبه فرديه سنجل', '( 2 قطعة دجاج بروستد+ خبز + تومية + بطاطس + كاتشب )', 'products/1Id8XkQgsr5adfrFogNHhTg6duakcfJwLnH70KNy.jpg', NULL, NULL, '2025-12-09 14:57:07', '2025-12-09 14:57:07'),
(423, 113, 'ready', 84, 'لسه single', '( 3 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/OS3AiPWJbg7zEp0Bx071j16Fi5XLKO4OSBHhhCn8.jpg', NULL, NULL, '2025-12-09 14:58:30', '2025-12-09 14:58:30'),
(424, 113, 'ready', 84, 'Super Single', '( 4 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/Fa5RwahKTxiAMSBhK4UZda0Rtjom0xlVAALzbiwZ.jpg', NULL, NULL, '2025-12-09 15:00:13', '2025-12-09 15:00:13'),
(425, 113, 'ready', 84, 'وجبه grill العائليه', '( 6 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/brdLIB9eyaOOAvligqUMCI2Kmn640ITvoAbxAlE8.jpg', NULL, NULL, '2025-12-09 15:02:27', '2025-12-09 15:02:27'),
(426, 113, 'ready', 84, 'Super Grill', '( 8 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/Hx7u6ijyEnB1EeAvED2WxT5NLdqtIUH9qv9GsJx2.jpg', NULL, NULL, '2025-12-09 15:03:50', '2025-12-09 15:03:50'),
(427, 113, 'ready', 84, 'Ultra Grill', '( 12 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب + 1.5 بيبسى )', 'products/grruYjzCjO1FtzpvP0TMoTpw7uf2fhAnPRtReK5A.jpg', NULL, NULL, '2025-12-09 15:06:40', '2025-12-09 15:06:40'),
(428, 113, 'ready', 84, 'Family Grill', '( 16 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب + 1.5 بيبسى )', 'products/htRv2vOBqehDZcbjvbFX0UtuLQ9qopx70MNvPyoP.jpg', NULL, NULL, '2025-12-09 15:07:16', '2025-12-09 15:07:16'),
(429, 116, 'ready', 81, 'مانسيرا روز فانيليا', 'برفان وبودي سبلاش وبدي لوشن وبرفان شنطه', 'products/CdayXTnQp6E7ghRRkRusXskag3NHYY5k2NEqzP45.jpg', NULL, NULL, '2025-12-09 16:08:31', '2025-12-09 16:08:31'),
(430, 116, 'ready', 81, 'خمره', 'برفانات وبودي سبلاش وبودي لوشن', 'products/mKds7KAm1OILSoQd5xytysn8DcQiNQfoHg1T0Mx1.jpg', NULL, NULL, '2025-12-09 16:11:23', '2025-12-09 16:11:23'),
(431, 116, 'ready', 81, 'موماريس', 'برفانات موماريس من شركه امبر', 'products/Enoz1aVawHQg0tB4NKkW1IooINP1mwuYQXJ9CuZ4.jpg', NULL, NULL, '2025-12-09 16:13:12', '2025-12-09 16:13:12'),
(432, 116, 'ready', 81, 'نجده', 'برفان نجده من شركه لطافه', 'products/v6wQGI1ziTaCGPJZq4mpnC7ia18dRzFLpJOkVw8a.jpg', NULL, NULL, '2025-12-09 16:14:47', '2025-12-09 16:14:47'),
(433, 116, 'ready', 81, 'دارك فيفر', 'برفان درك فيفر من شركه لميس', 'products/BQalwr0HNa7Oio1eVSR5NTbW5kEPECoSVIUq0mpQ.jpg', NULL, NULL, '2025-12-09 16:19:28', '2025-12-09 16:19:28'),
(434, 116, 'ready', 81, 'شيخ الشيوخ', 'شيخ الشيوخ', 'products/Njs6HcpZYOhl5OPfxAo2c3CDFgYstVAcsHTVm2gv.jpg', NULL, NULL, '2025-12-09 16:20:43', '2025-12-09 16:20:43'),
(435, 116, 'ready', 81, 'جود جيرل', 'جود جيرل', 'products/op3WWuhKhQc87rYbGdh1fdb6k2UwTQO5MacPucyc.jpg', NULL, NULL, '2025-12-09 16:21:58', '2025-12-09 16:21:58'),
(436, 116, 'ready', 81, 'Blue cerulean', 'Blue cerulean', 'products/BOOnVR2GDBGS8eo8r3ckDWysQcLmGPwJTbfUnhHK.jpg', NULL, NULL, '2025-12-09 16:23:40', '2025-12-09 16:23:40'),
(437, 116, 'ready', 81, 'عود خصوصي', 'عود خصوصي من شركه الفارس', 'products/Ss2pZpVqx1znSg1dEsiJhbohbeGEXgZkRWKLpUrU.jpg', NULL, NULL, '2025-12-09 16:25:28', '2025-12-09 16:25:28'),
(438, 116, 'ready', 81, 'Mancera tobacco red', 'Mancera tobacco red', 'products/uSQBaQGDDZfHXxgFK8sqgpy3hBr4Vsq6k6HhEWt7.jpg', NULL, NULL, '2025-12-09 16:27:31', '2025-12-09 16:27:31'),
(439, 116, 'ready', 81, 'أشكال زجاج برفيوم التركيب', 'برفيوم مركب من اختيارك', 'products/PVA5Vy2CB0ZG8wS0L0855C4HGkXI1G8hvYNri6aa.jpg', NULL, NULL, '2025-12-09 16:31:53', '2025-12-09 16:31:53'),
(440, 116, 'ready', 81, 'عطور تركيب', 'جميع انواع العطور للتركيب الرجالي والحريم والعربي', 'products/gAsHpMTRrc6UUrPgl99vBW5uymYLZAPGTadL0QZm.jpg', NULL, NULL, '2025-12-09 16:34:13', '2025-12-09 16:34:13'),
(441, 118, 'ready', 81, 'مكينه دقن وشعر كهرباء', 'مكينه كهرباء', 'products/FGDykSPzB9tS25QmaUOAKYDOvOh9UYTxu3hzZJfe.jpg', NULL, NULL, '2025-12-09 16:35:50', '2025-12-09 16:35:50'),
(442, 118, 'ready', 81, 'مكينه اللوتس الفرعوني الأصلي', 'مكينه اللوتس الفرعوني الاصلي', 'products/Yypo0qCPJKjQErMChAetWG3fedH2wCYOUuDtVP4I.jpg', NULL, NULL, '2025-12-09 16:37:25', '2025-12-09 16:37:25'),
(443, 118, 'ready', 81, 'مكينه دقن زيرو ديجيتال', 'مكينه دقن زيرو ديجيتال', 'products/7H98hC3CTVAVl7poEzI98PfONd5NaD5LWBFyTfak.jpg', NULL, NULL, '2025-12-09 16:38:37', '2025-12-09 16:38:37'),
(444, 118, 'ready', 81, 'Vgr ziroo', 'Very ziroo', 'products/1pxM4unVDOhL4JAY7atToUWFZJcVmDZeLCl3h3Dn.jpg', NULL, NULL, '2025-12-09 16:40:43', '2025-12-09 16:40:43'),
(445, 118, 'ready', 81, 'Vgr تحديد', 'لتحديد الشعر والدقه', 'products/EBMZ9dFxBxAl3LSOmUH7xkQuSHFRwEdPErnMu1Pg.jpg', NULL, NULL, '2025-12-09 16:44:07', '2025-12-09 16:44:07'),
(446, 118, 'ready', 81, 'Vgr تنعيم', 'Vgr تنعيم', 'products/btVDkoMOLUZxIawaFDsddDeQQvK1Q2hL9TWzoPRl.jpg', NULL, NULL, '2025-12-09 16:45:18', '2025-12-09 16:45:18'),
(447, 117, 'ready', 81, 'المحفظه الكراته', 'المحفظه الكراته', 'products/ebnyWkQDimvaOOFpvCYNpBzbNUkMQEabE9IU4fum.jpg', NULL, NULL, '2025-12-09 16:50:46', '2025-12-09 16:50:46'),
(448, 117, 'ready', 81, 'المحفظه horse', 'محفظه جلد طبيعي', 'products/DqRDNeHfFVtOxwTmb8zQtUdDWVrJsSxEHrjxj9V0.jpg', NULL, NULL, '2025-12-09 16:52:27', '2025-12-09 16:52:27'),
(449, 117, 'ready', 81, 'محفظه مونت بلانك', 'محفظه مونت بلانك', 'products/ahujlI8bZVFZiScYA9SpapwHwzv97JSnmPO9Hu4Q.jpg', NULL, NULL, '2025-12-09 16:53:24', '2025-12-09 16:53:24'),
(450, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/ez2O1Trspr8qxnyhVbPC2qh7u24KkIr0OpBlaT6E.jpg', NULL, NULL, '2025-12-09 17:16:13', '2025-12-09 17:16:13'),
(451, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/sE2m965mrH5vDakF6bdq8aEQhxpGF9HbSN4rTjhg.jpg', NULL, NULL, '2025-12-09 17:17:15', '2025-12-09 17:17:15'),
(452, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/D6AoTDDTZEC9dKKH88fQN962odYMiX4tXPrrwxpg.jpg', NULL, NULL, '2025-12-09 17:17:57', '2025-12-09 17:17:57'),
(453, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/fb8y6w7GXbLjMWsMLhAIEd5OlhyhX6nODamU4nEE.jpg', NULL, NULL, '2025-12-09 17:18:54', '2025-12-09 17:18:54'),
(454, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/ObCxiyQs4xAdxZjjcnbKOJbFCcCggYA8nf7TLcFO.jpg', NULL, NULL, '2025-12-09 17:19:44', '2025-12-09 17:19:44'),
(455, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/MqQmlzhB385SgNDNrGqSTJMaBGGcW5x0LWDIfIni.jpg', NULL, NULL, '2025-12-09 17:20:22', '2025-12-09 17:20:22'),
(456, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/AGoCo7D37Fgfc7vgC1TGxcbL7oW4Z4A4XRKZYoEU.jpg', NULL, NULL, '2025-12-09 17:21:02', '2025-12-09 17:21:02'),
(457, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/DsMwptzBFfWdAv3MnC6luzimmifDanXzh5pbMgkm.jpg', NULL, NULL, '2025-12-09 17:21:50', '2025-12-09 17:21:50'),
(458, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/qzaZnLRt6D1P2uVjUQ9DbnohUYUhu69YKiCKvrUe.jpg', NULL, NULL, '2025-12-09 17:22:26', '2025-12-09 17:22:26'),
(459, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/NfV6BI5sWmjBrBYbOaUiZn8LPaKosaogsjsT7fMh.jpg', NULL, NULL, '2025-12-09 17:23:07', '2025-12-09 17:23:07'),
(460, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/kSBtqnUYwX1sA1854JiaKJKvwyIuDu9ZDFMstdhs.jpg', NULL, NULL, '2025-12-09 17:23:47', '2025-12-09 17:23:47'),
(461, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/5UFakQVZHGCy0jFbeJSIVZVzz2X4fztYLK8ykLp6.jpg', NULL, NULL, '2025-12-09 17:24:35', '2025-12-09 17:24:35'),
(462, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/XfeNigcdb9wGhZeviWU5RTViHOL9i1Nrps2vJrpX.jpg', NULL, NULL, '2025-12-09 17:25:08', '2025-12-09 17:25:08'),
(463, 119, 'ready', 81, 'نظارات شمسيه', 'نظارات شمسيه', 'products/Y0GvOwZuNtZxM6c8KuOFcjR9Qidg2mGdBn3Lj3mc.jpg', NULL, NULL, '2025-12-09 17:25:58', '2025-12-09 17:25:58'),
(464, 115, 'ready', 81, 'ساعه', 'ماركه ibso', 'products/JoUL58yvi28OJuGbFppboaEJJCCUL6sGFdZA6Cp1.jpg', NULL, NULL, '2025-12-10 15:37:48', '2025-12-10 15:37:48'),
(465, 115, 'ready', 81, 'ساعه', 'ماركت ibso', 'products/Bx44HfWt1BqngiVlWoPqjCNp0qCk42guSUVhf5Rx.jpg', NULL, NULL, '2025-12-10 15:38:42', '2025-12-10 15:38:42'),
(466, 115, 'ready', 81, 'ساعه رجالي', 'ماركت ibso', 'products/DVZiwRi5icWGg1Bohrh2aDkG3WbvpbSiAjYMolIp.jpg', NULL, NULL, '2025-12-10 15:39:48', '2025-12-10 15:39:48'),
(467, 115, 'ready', 81, 'ساعه حريمي', 'ماركت ibso', 'products/9imDuAMuJyBXFbNSibf17cKaW7NgENL2F9yUjYXx.jpg', NULL, NULL, '2025-12-10 15:42:20', '2025-12-10 15:42:20'),
(468, 115, 'ready', 81, 'ساعه حريمي', 'ماركت ibso', 'products/XkfCyTYObaxuApNhgqrZ1UI19tHWKRS7vPriSU2d.jpg', NULL, NULL, '2025-12-10 15:43:26', '2025-12-10 15:43:26'),
(469, 115, 'ready', 81, 'ساعه حريمي', 'ماركت ibso', 'products/4aNY28y862I3O4bWCOX3XPbMoDyAHqSnjnvd80QE.jpg', NULL, NULL, '2025-12-10 15:44:30', '2025-12-10 15:44:30'),
(470, 115, 'ready', 81, 'ساعه حريمي', 'ماركت ibso', 'products/MkXO9bw3znU9utjYoxSjH0YleufXIj3wgOMnyTvP.jpg', NULL, NULL, '2025-12-10 15:45:29', '2025-12-10 15:45:29'),
(471, 115, 'ready', 81, 'ساعه حريمي', 'ماركت zara', 'products/htFGygwJURJ47HqXKnm5FX6XYUf64lA9nrsoYuAD.jpg', NULL, NULL, '2025-12-10 15:46:45', '2025-12-10 15:46:45'),
(472, 115, 'ready', 81, 'ساعه حريمي', 'ماركت seifco', 'products/S2liuKx8dSuh4m0Gnn4pInSfaai7yyFXWr01vROU.jpg', NULL, NULL, '2025-12-10 15:47:37', '2025-12-10 15:47:37'),
(473, 115, 'ready', 81, 'ساعه حريمي', 'ماركت zara', 'products/CZ0f3VuZZRnL3PjgQSxO1rjlatmt8XTiW3H8YZV4.jpg', NULL, NULL, '2025-12-10 15:48:42', '2025-12-10 15:48:42'),
(474, 115, 'ready', 81, 'ساعه حريمي', 'ماركت Rolex', 'products/n2WVUBDPHwNRtMHyRhZ3Y0iQFWlBiepbP8zTXDQA.jpg', NULL, NULL, '2025-12-10 15:49:33', '2025-12-10 15:49:33'),
(475, 115, 'ready', 81, 'ساعه حريمي', 'ماركت ORIENT', 'products/uQPQpLuwse0SlBNF8NkPtYxm09WILbXMmUqrXWfD.jpg', NULL, NULL, '2025-12-10 15:50:27', '2025-12-10 15:50:27'),
(476, 115, 'ready', 81, 'ساعه حريمي', 'ماركت BVLGARI', 'products/TZ6DogkSh6CpGswJAwHDIrgecZXe1fzMDpKeWBaM.jpg', NULL, NULL, '2025-12-10 15:58:49', '2025-12-10 15:58:49'),
(477, 115, 'ready', 81, 'ساعه رجالي', 'ماركت CASIO', 'products/gtPGoyEhIDijnT8m1ru3KVVsgvrJFuiWyBL1TNXC.jpg', NULL, NULL, '2025-12-10 16:00:46', '2025-12-10 16:00:46'),
(478, 115, 'ready', 81, 'ساعه رجالي', 'ماركت CASIO', 'products/3xRAd2IYLuZ7biPPg3YMG6pJO15A3cpChyjgWi1j.jpg', NULL, NULL, '2025-12-10 16:02:51', '2025-12-10 16:02:51'),
(479, 115, 'ready', 81, 'ساعه رجالي', 'ماركت CASIO', 'products/dDdxwpGxnIho3f2Fz3nsaeXwChvEwm7zFkp5fFig.jpg', NULL, NULL, '2025-12-10 16:04:06', '2025-12-10 16:04:06'),
(480, 115, 'ready', 81, 'ساعه رجالي', 'ماركت CASIO', 'products/QEZRJmH1UAuzkDAZX6ZIlkJ50RH3eqnTwjJzT7Bt.jpg', NULL, NULL, '2025-12-10 16:05:15', '2025-12-10 16:05:15'),
(481, 115, 'ready', 81, 'ساعه رجالي', 'ماركت CASIO', 'products/8vfFHQDfoL06t2Dy4ACSbWj6V1XutwvzlycbOXUc.jpg', NULL, NULL, '2025-12-10 16:05:54', '2025-12-10 16:05:54'),
(482, 115, 'ready', 81, 'ساعه رجالي', 'ماركت SKMEI', 'products/IhJfr85Vr3t7kAWVd9LZpGeWReWKgfpb4vH7hgtu.jpg', NULL, NULL, '2025-12-10 16:06:45', '2025-12-10 16:06:45'),
(483, 115, 'ready', 81, 'ساعه رجالي', 'ماركت MF', 'products/LZtihcxi5mfvaIL0nEdvMlq3u08xJMZFWCsEMxvE.jpg', NULL, NULL, '2025-12-10 16:07:44', '2025-12-10 16:07:44'),
(484, 115, 'ready', 81, 'ساعه رجالي', 'ماركت MF', 'products/rklgupmxPHfJCHWSDoAt91zFFnJyM6kjUZUxk6Tq.jpg', NULL, NULL, '2025-12-10 16:08:39', '2025-12-10 16:08:39'),
(485, 115, 'ready', 81, 'ساعه رجالي', 'ماركت MF', 'products/ZsOaBpLp58QClE2n4lhZnInheVx3dRfG0EFuL3ZR.jpg', NULL, NULL, '2025-12-10 16:09:33', '2025-12-10 16:09:33'),
(486, 115, 'ready', 81, 'ساعه رجالي', 'ماركت MF', 'products/hHXSasTB4fbPhvDXhUHhqA1M8eTaaAgjZOsrX5oD.jpg', NULL, NULL, '2025-12-10 16:10:47', '2025-12-10 16:10:47'),
(487, 115, 'ready', 81, 'ساعه رجالي', 'ماركت zara', 'products/wKDSYsTRtfvHKvIyCViFx6ev40pjymRIcd0eM5Oc.jpg', NULL, NULL, '2025-12-10 16:11:50', '2025-12-10 16:11:50'),
(488, 121, 'ready', 85, 'مناديل مارتي', 'العلبه 500 منديل', 'products/q6sMhpGKg25cu0yoewCXy4iJkMTtfTcijhNtss3r.png', '1099.99', NULL, '2025-12-11 18:11:49', '2025-12-15 16:06:39'),
(489, 121, 'ready', 85, 'مناديل جانيس', 'العلبه 500 منديل', 'products/VQzY7FMv7QoWUYLRquo8XKD8whPjxOlCR40oWvUW.png', '1099.99', NULL, '2025-12-12 13:26:17', '2025-12-15 16:08:44'),
(490, 120, 'ready', 85, 'سي فولد', 'بالته 20 علبه بالكيلو', 'products/wMAOZoZIsim7YOgPFj8qpdqQDamzd12u8yKsCk2t.png', '599.99', NULL, '2025-12-12 13:30:02', '2025-12-15 16:14:55'),
(491, 121, 'ready', 85, 'مناديل سفره فاخره', '40 علبه , العلبه 50 منديل', 'products/rAU2tUAAmGYow0REozoq9p7yZ9abjzg0DZFrwvPH.png', '649.00', NULL, '2025-12-12 13:34:10', '2025-12-15 16:17:36'),
(492, 121, 'ready', 85, 'مناديل سحب بالكيلو فاخره', 'بالته 20 علبه , العلبه 250 جرام', 'products/kFw2U92GlYZzjqQeOBBNJkRDth2kYi21PSqQvrzP.png', '599.99', NULL, '2025-12-12 13:52:33', '2025-12-15 16:16:58'),
(493, 120, 'ready', 85, 'مناديل كتان', '550 منديل', 'products/4eTNWGQD4irX8qTYeXblY9be7VyvSh7P6zzIb6S5.jpg', '369.99', NULL, '2025-12-12 18:45:03', '2025-12-15 16:19:59'),
(494, 122, 'ready', 85, 'سيتي فيرجيان', 'العلبه ٢٠٠ منديل , مناديل منقوشه', 'products/X4K5RJqdW9HJC0KMXbPmfudPVXnH7iSP180zBY2r.jpg', '159.99', NULL, '2025-12-12 18:47:15', '2025-12-15 16:20:33'),
(495, 120, 'ready', 85, 'مناديل برافو بيور', '500 منديل ، مناديل ناعمه', 'products/rNxVxu0q54xkQX8zUeRi6zRYJrHEoMPATlsq2H3G.png', '419.99', NULL, '2025-12-12 18:50:52', '2025-12-15 16:21:45'),
(496, 123, 'ready', 86, 'بوكس 6 قطع', '6 قطع دجاج+بطاطس+5خبز+كاتشب+٢ تومية', 'products/TEJRFl6UFW93BrxjXN4OOzMkhtSbK1HACywzH2GI.jpg', NULL, NULL, '2025-12-13 16:55:50', '2025-12-15 18:53:14'),
(497, 123, 'ready', 86, 'فاميلي بوكس', '9 قطع دجاج+بطاطس+6خبز+كاتشب+٢ تومية', 'products/tz4Lug77BmFzT6zm767u4FbqVOwPaWPWQ9kIB0up.jpg', NULL, NULL, '2025-12-13 17:09:04', '2025-12-15 18:53:38'),
(498, 123, 'ready', 86, 'سوبر فاميلي', '12 قطع دجاج+بطاطس+8خبز+2 كلو سلو+٢ تومية +لتر بيج كولا', 'products/JU4s4doMGHU17QaMJ8QxTbB3XwQhBK18ks89syVB.jpg', NULL, NULL, '2025-12-13 17:13:19', '2025-12-15 18:54:15'),
(499, 123, 'ready', 86, 'جراند تشك ان', '18 قطع دجاج+بطاطس+خبز+كاتشب+3 تومية+لتر بيج كولا', 'products/lnjJyHqeyvsjApq19mXJX0n7hHIyyEbt2R1ucmuG.jpg', NULL, NULL, '2025-12-13 17:20:51', '2025-12-15 18:54:42'),
(500, 123, 'ready', 86, 'فاميلي ستربس', '10 قطع ستريبس+بطاطس كبيرة+6خبز+2 كلو سلو+ تومية +وريزو سادة', 'products/iGpWFvBtYJaHnaCeoJRbPo0UnHsDODGvItLiIyI6.jpg', NULL, NULL, '2025-12-13 17:24:51', '2025-12-15 18:56:58'),
(501, 123, 'ready', 86, 'سوبر فاميلي ستربس', '15 قطع ستريبس+بطاطس كبيرة+خبز+ كلو سلو +وريزو سادة', 'products/xjnyYHb5jYhpRSGxEz3ZIv30iDVOpDENMA5PxlmB.jpg', NULL, NULL, '2025-12-13 17:27:54', '2025-12-15 19:18:29'),
(502, 123, 'ready', 86, 'كيس حراري ستربس', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/FOWtqtfZwT0SEFnUXdoMr3h9uJyzIfaB1viEYKTu.jpg', NULL, NULL, '2025-12-13 17:35:56', '2025-12-13 17:35:56'),
(503, 123, 'ready', 86, 'كيس حراري وينجز', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/qSWESrhZISA4EZvfq2070eIxMGbOwf2mT0uohKgI.jpg', NULL, NULL, '2025-12-13 17:41:30', '2025-12-15 19:04:58'),
(504, 123, 'ready', 86, 'كيس حراري شرمبو', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/eC4sJ52bDXRyT6ulcjfGoOF5cAm5Zy0oaPok9g8v.jpg', NULL, NULL, '2025-12-13 17:46:47', '2025-12-15 19:05:34'),
(505, 123, 'ready', 86, 'كب تشك ان', 'طبق بطاطس مع فراخ مع مزيج من صوصات جراند تشك ان', 'products/x2yhLTHtYjnegSXdVkl0gcgDgG3oDjqYdvJsrHa2.jpg', NULL, NULL, '2025-12-13 18:00:40', '2025-12-15 19:06:23'),
(506, 123, 'ready', 86, 'كشريكو', 'طبق بطاطس مع فراخ مخلوط  مع مزيج من اللحوم المدخنة  مع صوصات جراند تشك ان', 'products/66vGvxBzn9qljCFBql2jkTooGvK3PGvc9HW9dgHQ.jpg', NULL, NULL, '2025-12-13 18:02:41', '2025-12-15 19:07:12'),
(507, 124, 'ready', 86, 'snack box', 'قطعتين دجاج+بطاطس+عيش+ثومية', 'products/b7MGftjigLRjSQVxKuHX4dbiAZZyfdWGEoE6dYLt.jpg', NULL, NULL, '2025-12-13 18:06:33', '2025-12-15 19:23:59'),
(508, 124, 'ready', 86, 'dinner box', '3قطع دجاج +بطاطس +2عيش+ثومية', 'products/zygcSG4IOG88JP4orZtLvhMTSqdnfSKn7LOX9SbD.jpg', NULL, NULL, '2025-12-13 18:09:19', '2025-12-15 19:20:51'),
(509, 124, 'ready', 86, 'large box', '٤قطع دجاج +بطاطس +٣عيش+ثومية', 'products/kPy44735HjUiZ8xRLlvuJ2RHTnXE70kNvEeDsAkE.jpg', NULL, NULL, '2025-12-13 18:13:27', '2025-12-15 19:19:09'),
(510, 124, 'ready', 86, 'strips box', '3قطع ستربس +بطاطس +عيش+ثومية', 'products/GdKDqL1paKRkNqiFFCCT65VyQcgv2JcfqQqDCLva.jpg', NULL, NULL, '2025-12-13 18:16:16', '2025-12-15 19:26:29'),
(511, 124, 'ready', 86, 'Dinner Strips box', '٤ قطع ستربس +بطاطس+ عيش+ ثومية', 'products/8arJVO0zvpnf162RT0mF4tHOsdAqUpRZ1nOw7afs.jpg', NULL, NULL, '2025-12-13 18:19:46', '2025-12-15 19:26:55'),
(512, 124, 'ready', 86, 'jumbo strips box', '5قطع ستربس +بطااطس+2عيش +ثومية', 'products/sXaihq8L86FpQ5qg7R9w6lWWokDEDhwkzbnRSJyE.jpg', NULL, NULL, '2025-12-13 18:22:09', '2025-12-15 19:27:17'),
(513, 126, 'ready', 86, 'تويستر رول كلاكسيك', 'قطع استربس + خس +مايونيز+باربكيو', 'products/dNzObp7fHm7386Rsm6MKEMjoIivcX3nBstDQ8IeD.jpg', NULL, NULL, '2025-12-13 18:24:27', '2025-12-15 19:30:06'),
(514, 126, 'ready', 86, 'تويستر رول فاير', 'قطع استربس + خس+ صوص فاير +تاجير', 'products/dNl8tExE06gK943nbLzQLOtgUFndDguNS4u0tFNH.jpg', NULL, NULL, '2025-12-13 18:27:49', '2025-12-14 20:32:17'),
(515, 126, 'ready', 86, 'سوبر يم', 'زنجر+تركي مدخن بيف صوص رانش+شيدر', 'products/CGB6cJ2i5L8IHrdUR7nNA3G84O2n1itQrvrMVRhl.jpg', NULL, NULL, '2025-12-13 18:30:48', '2025-12-15 19:30:44'),
(516, 126, 'ready', 86, 'زنجر هالبينو', 'زنجر +فلفل هالبينو +صوص فاير+شيدر', 'products/57L4rr5GZZQdyoaTVdQfw26ZFS7sGsgJHlfTFRJR.jpg', NULL, NULL, '2025-12-13 18:33:32', '2025-12-15 19:32:22'),
(517, 126, 'ready', 86, 'تشيكن موتزريلا ستيك', 'قطع دجاج مقلي +اصابع الجبنه الموتزريلا+خس+مايونيز+خيار مخلل', 'products/vm9jqSXVIsLGM6u4cgKkev2LKBGpnX5DKQBl8wYB.jpg', NULL, NULL, '2025-12-13 18:38:07', '2025-12-15 19:33:04'),
(518, 126, 'ready', 86, 'تشك ان فاير', 'دجاج مقلي تركي شريحة شيدر صوص شيدر+صوص باربكيو مايونيز+صوص شيلي هالبينو', 'products/R7T9hAh3ovqM1TdxfayP6lYVQB4wODGVCNKwVah2.jpg', NULL, NULL, '2025-12-13 18:41:36', '2025-12-15 19:35:09'),
(519, 126, 'ready', 86, 'تشك ان كلاسيك', 'صدور الدجاج المقلي +تركي بيف+جبنة شيدر +خس طماطم + خيار مخلل +صوص شيدر وباربيكيو ومايونيز', 'products/oNIQUEx3Pr3mnetBDSQBr0K3xUnKk3biL0uTYVCx.png', NULL, NULL, '2025-12-13 18:45:01', '2025-12-13 18:57:06'),
(520, 126, 'ready', 86, 'تشيكن تشيز لافر', 'صدور الدجاج المقلي +صوص رانش+تركي صوص تشك ان المميز', 'products/LruiR1fPsou8sJYcNxQrTz9kebfqJGroVc1vbsEl.png', NULL, NULL, '2025-12-13 18:48:57', '2025-12-13 18:56:43'),
(521, 126, 'ready', 86, 'تشيكن رانشيو', 'صدور الدجاج المقلي +صوص رانش+تركي صوص تشك ان المميز', 'products/USQdSuMSqIKp2cTC5DFujXbzvenPpMROkKJrlikA.png', NULL, NULL, '2025-12-13 18:52:02', '2025-12-13 18:56:17'),
(522, 126, 'ready', 86, 'تشيكن بيكون', 'صدور الدجاج المقلي+ شريحة جبنه + حلقات البصل+صوص الباربكيو+صوص شيدر+بيف بيكون', 'products/lPKercLKRQdId1ZCmo7DKBcn7d1P9WcctBTUO2eE.png', NULL, NULL, '2025-12-13 18:54:33', '2025-12-13 18:55:58'),
(523, 127, 'ready', 86, 'كلاسيك برجر', 'تسيتي+ خس+ بصل+ خيار خلل +طماطم شريحه جبنه+ باربيكيو', 'products/MKdKPV5PQVSoePyZzegcRuw0VIdIvYLMFhjqOqtl.jpg', NULL, NULL, '2025-12-13 19:02:45', '2025-12-15 19:37:10'),
(524, 127, 'ready', 86, 'مشروم برجر', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ باربيكيو', 'products/moXzEWUo3G5gD8eBkr7tOmZhxjAGGRKafsPVG00t.jpg', NULL, NULL, '2025-12-13 19:04:11', '2025-12-15 19:39:25'),
(525, 127, 'ready', 86, 'تشيز لافر برجر', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/B3hpwHF87rLlGyBYm43l4FRcb2ObJlfmRz55dhhk.jpg', NULL, NULL, '2025-12-13 19:06:45', '2025-12-15 19:42:04'),
(526, 127, 'ready', 86, 'برجر موتزريلا ستيك', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/pKi3MTVBkLhlIMlNHiiFzKzUJDzxkNXFhnwGkp5t.jpg', NULL, NULL, '2025-12-13 19:10:03', '2025-12-15 19:43:15'),
(527, 127, 'ready', 86, 'برجر بيكون', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/F121AV4ClIhEUbWY2IaWWwALsmhtvgRy0Wugy1M9.jpg', NULL, NULL, '2025-12-13 19:16:46', '2025-12-15 19:47:23'),
(528, 127, 'ready', 86, 'برجر بيف ان', 'تسيتي+ خس+ بصل+ خيار مخلل +باربيكيو+مع شرايح اللحمه البلدي', 'products/c4v4CYDSeczTCla58WukZENL8SsYRV6sFfQ5jBXl.jpg', NULL, NULL, '2025-12-13 19:19:25', '2025-12-15 19:48:17'),
(529, 127, 'ready', 86, 'سموك هاوس برجر', 'تسيتي+ خس+ بصل انيون + خيار مخلل +طماطم شريحه جبنه+باربيكيو+تركي مدخن+صوص جبنه', 'products/7eHtXDZSEMcoHPigHxTa88UAWAlqwY64AmYaOrn7.jpg', NULL, NULL, '2025-12-13 19:21:59', '2025-12-15 19:49:43');
INSERT INTO `products` (`id`, `category_id`, `type`, `user_id`, `name`, `description`, `cover`, `Purchase_price`, `selling_price`, `created_at`, `updated_at`) VALUES
(530, 127, 'ready', 86, 'اكس ان برجر', 'تسيتي+ خس+ بصل+ خيار  +طماطم شريحه جبنه+ باربيكيو+بيف بيكون تركي+موتزرلا استيك+صوص تاجر+صوص جبنة', 'products/RTjITbA3sFWw2karewVf9JF8mAXND8q2eQnC0NxP.jpg', NULL, NULL, '2025-12-13 19:29:12', '2025-12-15 19:53:50'),
(531, 125, 'ready', 86, 'سندوتش بيف', 'سندوتش بيف + بطاطس+ كلوسلو+عصير', 'products/ovAZxXfiMdbK7Nsikl4zblL2lkIvkrMyCyB9IUbK.png', NULL, NULL, '2025-12-13 19:32:11', '2025-12-13 19:32:11'),
(532, 125, 'ready', 86, 'سندوتش تشكين', 'سندوتش تشكين + بطاطس+ كلوسلو+عصير', 'products/Yhc92KBqQPogwUE7OM33ZyJpr9GlgRhAHnw4Bx4J.png', NULL, NULL, '2025-12-13 19:33:45', '2025-12-13 19:33:45'),
(533, 125, 'ready', 86, 'قطعة دجاج', 'قطعة دجاج + بطاطس+ كلوسلو+عصير', 'products/qUmEhhLRlzIsUcxfkVyVhv0WyTGVKAykft9BeUtJ.png', NULL, NULL, '2025-12-13 19:35:43', '2025-12-13 19:35:43'),
(534, 128, 'ready', 86, 'بطاطس', 'بطاطس', 'products/CQc3yxHXCRq4DtSAEpCgamPqcP2D2027LBX9xCSN.png', NULL, NULL, '2025-12-13 19:38:02', '2025-12-13 19:38:02'),
(535, 128, 'ready', 86, 'بطاطس شيدر', 'بطاطس شيدر', 'products/4YIYwh3dFZgkgaKGLKYr2iIWyMeXpDeFNu2sN9VK.png', NULL, NULL, '2025-12-13 19:39:51', '2025-12-13 19:39:51'),
(536, 128, 'ready', 86, 'بطاطس سوبريم', 'بطاطس سوبريم', 'products/Y6Hsdi2RjAxiwkE9Zkwt7JRjzIDiTjAL9zpx5Zgf.png', NULL, NULL, '2025-12-13 19:41:43', '2025-12-13 19:41:43'),
(537, 128, 'ready', 86, 'بطاطس تشيكن سوبريم', 'بطاطس تشيكن سوبريم', 'products/t87dKqx3TB12p6cXhMjsY4HbAoi6TmHXSa5PnMvL.jpg', NULL, NULL, '2025-12-13 19:45:45', '2025-12-13 19:45:45'),
(538, 128, 'ready', 86, 'بطاطس هالبينو', 'بطاطس هالبينو', 'products/cNFqH0AqvPWKnFO26V6oiXqMQ7LuyDkhcDluaBKt.jpg', NULL, NULL, '2025-12-13 19:47:13', '2025-12-13 19:47:13'),
(539, 128, 'ready', 86, 'موتزريلا ستيك', 'موتزريلا ستيك', 'products/XtwppiYYqRfvOJ8FevddXhZkwrNKUI0D5bHrPbkq.jpg', NULL, NULL, '2025-12-13 19:49:31', '2025-12-13 19:49:31'),
(540, 128, 'ready', 86, 'حلقات بصل', 'حلقات بصل', 'products/i8ovt5561uEECxO0jkaA04RQbv16RnylOktJl9po.jpg', NULL, NULL, '2025-12-13 19:51:05', '2025-12-13 19:51:05'),
(541, 128, 'ready', 86, 'كلوسلو', 'كلوسلو', 'products/c3fXlnst4d4mPTHPR3tAssRiFznp31VEgWfhy9S6.jpg', NULL, NULL, '2025-12-13 19:52:07', '2025-12-13 19:52:07'),
(542, 128, 'ready', 86, 'ثومية', 'ثومية', 'products/xBBYDkCWI8QE8dvZxEFnZPhDBALatARX9hZzOAv2.jpg', NULL, NULL, '2025-12-13 19:53:04', '2025-12-13 19:53:04'),
(543, 128, 'ready', 86, 'ارز سادة', 'ارز سادة', 'products/ba1IT1BvVw6dDdacRIqMq5kY8M3mHayAT20JCOwW.jpg', NULL, NULL, '2025-12-13 19:54:25', '2025-12-13 19:54:25'),
(544, 128, 'ready', 86, 'ريزو تشيكن كلاسيك', 'ريزو تشيكن كلاسيك', 'products/IZKXhDKpW6j5PZgp94C0NMbvUXhtSvcyi62Dm11w.jpg', NULL, NULL, '2025-12-13 19:56:20', '2025-12-13 19:56:20'),
(545, 128, 'ready', 86, 'ريزو تشيكن حار', 'ريزو تشيكن حار', 'products/TwLuN2BVCeuKNe79oqA9r9J81mjo1se0fZGKfc1D.jpg', NULL, NULL, '2025-12-13 19:58:19', '2025-12-13 19:58:19'),
(546, 128, 'ready', 86, 'ريزو تشيكن تشيز', 'ريزو تشيكن تشيز', 'products/bcMklT74eGIBOTJo2o3wAICHH7cEZMkq48Z60vdw.jpg', NULL, NULL, '2025-12-13 20:00:25', '2025-12-13 20:00:25'),
(547, 128, 'ready', 86, 'ريزو تشيكن رانش', 'ريزو تشيكن رانش', 'products/9Jk4wLPkWiVEptWsI3bAG1IhC3HvfnEeiuFLMoTO.jpg', NULL, NULL, '2025-12-13 20:02:31', '2025-12-13 20:02:31'),
(548, 128, 'ready', 86, 'ريزو شرمبو', 'ريزو شرمبو', 'products/uAyb3Vq9ZXMLkogPxphJCKlhe2vYQhSpKGVtOzgZ.jpg', NULL, NULL, '2025-12-13 20:04:17', '2025-12-13 20:04:17'),
(549, 128, 'ready', 86, 'صوص تايجر-رانش', 'صوص تايجر-رانش', 'products/GTR01uj7WwaNL7LBXOrItXJEEC58a9Inn8ULH0zd.png', NULL, NULL, '2025-12-13 20:06:36', '2025-12-13 20:06:36'),
(550, 128, 'ready', 86, 'صوص سويت شيلي', 'صوص سويت شيلي', 'products/DcFdklewDPFNfnXxujGEJhqbsQMIeWbXZvFhCCTa.jpg', NULL, NULL, '2025-12-13 20:07:58', '2025-12-13 20:07:58'),
(551, 128, 'ready', 86, 'صوص بيج تيستي -صوص جبنة', 'صوص بيج تيستي -صوص جبنة', 'products/V3hAGkm2zzAKVEzn14vAVmrXijzOpHx5xBW5ZrYd.jpg', NULL, NULL, '2025-12-13 20:09:24', '2025-12-13 20:09:24'),
(552, 130, 'ready', 86, 'مياه معدنيه صغيره', 'مياه معدنيه صغيره', 'products/4rSKSXEo96grbwy7e28wqicgJB3QHoiC47MpFHOv.jpg', NULL, NULL, '2025-12-13 20:12:35', '2025-12-13 20:12:35'),
(553, 130, 'ready', 86, 'مياه معدنيه كبيره', 'مياه معدنيه كبيره', 'products/IcTZVlBa6aoiBBhO3daG6N4dqD1cv9dmV4B0JLaI.jpg', NULL, NULL, '2025-12-13 20:13:44', '2025-12-13 20:13:44'),
(554, 130, 'ready', 86, 'Big cola', 'Big cola', 'products/CW0Z2zsLSPlEw6gdSBuLxahSqReSXFUEhWdwI8Ln.jpg', NULL, NULL, '2025-12-13 20:15:26', '2025-12-13 20:15:26'),
(555, 129, 'ready', 86, 'تبديل قطعه', 'تبديل قطعه', 'products/G2QzI929b73Quwv1LDw3dJFxGNasO6O6mDsrbJrN.png', NULL, NULL, '2025-12-13 20:17:56', '2025-12-13 20:17:56'),
(556, 129, 'ready', 86, 'اضافه قطعة', 'اضافه قطعة', 'products/qLUjU0Ja3rIa8YAxCeZLLTxHQmqnwPsdd5kUjOdz.png', NULL, NULL, '2025-12-13 20:19:25', '2025-12-13 20:19:25'),
(557, 129, 'ready', 86, 'تبديل جناح دبوس', 'تبديل جناح دبوس', 'products/9WgMedRygnwJuNC54KxcUGIXtMmt1NQJBFbYmhEr.png', NULL, NULL, '2025-12-13 20:20:28', '2025-12-13 20:20:28'),
(558, 129, 'ready', 86, 'قطعه ستريبس', 'قطعه ستريبس', 'products/bwkHFcomuhVC7AunHU1MYfm6jSfz2L72i5FeuLtT.png', NULL, NULL, '2025-12-13 20:21:35', '2025-12-13 20:21:35'),
(559, 129, 'ready', 86, 'عيش', 'عيش', 'products/YnT9R5tY9Z2i4m3fB6ucUeQarEkhVkmKd7URKALD.png', NULL, NULL, '2025-12-13 20:22:08', '2025-12-13 20:22:08'),
(560, 121, 'ready', 85, 'مناديل وايت', 'العلبه 500 منديل', 'products/nZ91DSS6hKfSdkbYWcLR8K9It3bxMNp2CNAWVNBS.png', '509.99', NULL, '2025-12-15 16:13:03', '2025-12-15 16:13:03'),
(561, 131, 'ready', 87, 'ربع ممبار', 'ربع ممبار', 'products/3odRTXYTeTWieQWLl41Av0Fm4oJB2WDX9alo5r8W.jpg', NULL, NULL, '2025-12-15 18:09:46', '2025-12-15 18:09:46'),
(562, 131, 'ready', 87, 'ربع كبده مقلية', 'ربع كبده مقلية', 'products/3eKv3fc6sH7nl6V88Jic0carcxwdg6taLQEmdX5Q.jpg', NULL, NULL, '2025-12-15 18:10:52', '2025-12-15 18:10:52'),
(563, 131, 'ready', 87, 'ربع كبدة اسكندراني', 'ربع كبدة اسكندراني', 'products/zpClrN4gJ6rDlQwI6ZILMByANdywdR5Afu8ju6zb.jpg', NULL, NULL, '2025-12-15 18:11:45', '2025-12-15 18:11:45'),
(564, 131, 'ready', 87, 'ربع مخ', 'ربع مخ', 'products/DOrUkpHs5pYkbuGHMqeppx7vvgXBdeEOzcMppatv.jpg', NULL, NULL, '2025-12-15 18:12:34', '2025-12-15 18:12:34'),
(565, 131, 'ready', 87, 'نص تقاطيع', 'كرشه فشه حلويات', 'products/nYc8wmY9A56JOsKspL8DlJHj02vQgEMuD6Hd9noA.jpg', NULL, NULL, '2025-12-15 18:13:48', '2025-12-15 18:13:48'),
(566, 131, 'ready', 87, 'نص مشكل', 'كرشة +فشه+حلويات+لحمة راس+كوترع ضاني', 'products/4xiqTxZ5UXU4x3oOE2InI8I7t6f3YOYit6gQEVwX.jpg', NULL, NULL, '2025-12-15 18:15:59', '2025-12-15 18:15:59'),
(567, 131, 'ready', 87, 'نص لحمة راس', 'نص لحمة راس', 'products/udZzeg2BIF0kciuRJev9KrxZ4ZlQJKUfKLGFHHtd.webp', NULL, NULL, '2025-12-15 18:17:33', '2025-12-15 18:17:33'),
(568, 132, 'ready', 87, 'مشكل', 'مشكل', 'products/9X3nmOt8tY2Jx8pK0J60HnmyEmn50Ja0Haz0ogIb.jpg', NULL, NULL, '2025-12-15 18:20:02', '2025-12-15 18:20:02'),
(569, 132, 'ready', 87, 'تقاطيع', 'تقاطيع', 'products/YEPCr1navDADlS620sd1ACM4TbAqKi4xiSnLwrTt.png', NULL, NULL, '2025-12-15 18:29:52', '2025-12-15 18:29:52'),
(570, 132, 'ready', 87, 'لحمة راس', 'لحمة راس', 'products/2XkPg8XPZ6cDdQwWogXqMjvbmstbJQ2m9fqDO25H.webp', NULL, NULL, '2025-12-15 18:33:20', '2025-12-15 18:33:20'),
(571, 132, 'ready', 87, 'كوارع ضاني', 'كوارع ضاني', 'products/bN4okbYzO7XIj6Q6xPPdyeJJJXwzh3sEnArP2KQm.jpg', NULL, NULL, '2025-12-15 18:36:13', '2025-12-15 18:36:13'),
(572, 132, 'ready', 87, 'عجالي', 'عجالي', 'products/xUDmszywwnd26OppAxDTeaOg07VGgkEplJXSWpGz.jpg', NULL, NULL, '2025-12-15 18:41:03', '2025-12-15 18:41:03'),
(573, 132, 'ready', 87, 'لسان صافي', 'لسان صافي', 'products/qebun13imhdydVMWRE4Gby4Z4UEAuYHDARuP2bQ5.jpg', NULL, NULL, '2025-12-15 18:42:28', '2025-12-15 18:42:28'),
(574, 132, 'ready', 87, 'وجبه عائلي', 'ربع ممبار+لحمه راس+كوارع ضاني+تقاطيع', 'products/2hg3ArDWY8w5Q5Ykz7AaMvTA6lmnQp2MauC9g9Un.jpg', NULL, NULL, '2025-12-15 18:44:47', '2025-12-15 18:44:47'),
(575, 133, 'ready', 87, 'ساندوتش كبده مقلي', 'ساندوتش كبده مقلي', 'products/pHySjksuyyN4gmqwfYiAc1O6kyBfune04xanPnfy.jpg', NULL, NULL, '2025-12-15 18:53:58', '2025-12-15 18:53:58'),
(576, 133, 'ready', 87, 'ساندوتش كبدة اسكندراني', 'ساندوتش كبدة اسكندراني', 'products/PVNLvZh6C2kkznzfaGrLw3XE2TLI846uPRkTC5UX.webp', NULL, NULL, '2025-12-15 18:55:19', '2025-12-15 18:55:19'),
(577, 133, 'ready', 87, 'ساندوتش تقاطيع', 'ساندوتش تقاطيع', 'products/7yfJ1Fb4674qqLjDFNcHY2tC36knmhYtWme5nd8I.jpg', NULL, NULL, '2025-12-15 18:56:53', '2025-12-15 18:56:53'),
(578, 133, 'ready', 87, 'ساندوتش مشكل', 'ساندوتش مشكل', 'products/gakEi15yKL3TbdIdxnbTji61YHu02EYSZPuR4vgs.jpg', NULL, NULL, '2025-12-15 18:58:05', '2025-12-15 18:58:05'),
(579, 133, 'ready', 87, 'ساندوتش لحمة راس', 'ساندوتش لحمة راس', 'products/2qgM29uk9EJ9jVaCwGmpAus8Nm6CMu6Ig6adMJIG.jpg', NULL, NULL, '2025-12-15 18:59:27', '2025-12-15 18:59:27'),
(580, 133, 'ready', 87, 'ساندوتش مخ', 'ساندوتش مخ', 'products/sQlyK0V5bOvaXEwAgje62ouxxWkBQ2lEtUhjU6tM.jpg', NULL, NULL, '2025-12-15 19:00:28', '2025-12-15 19:00:28'),
(581, 133, 'ready', 87, 'ساندوتش ممبار', 'ساندوتش ممبار', 'products/kKoyuiSDv3CMTLYwO7SFC9zzkOZeh9YvWut77iWV.webp', NULL, NULL, '2025-12-15 19:01:36', '2025-12-15 19:01:36'),
(770, 97, 'ready', 80, 'ساندوتش حووشي بنن بيف', 'حواوشي+بيكون+جبنه+كاتشب +طحينة', 'products/JUlwvoaL4mIkIL0ohERGNX2fF7armMsGiu8GASvM.jpg', '85.00', NULL, '2025-12-29 21:20:05', '2025-12-29 21:20:05'),
(771, 97, 'ready', 80, 'ساندوتش كرسبي', 'قطع الكرسبي مع الخص مع عيش تورتيلا', 'products/N1TzVBIVklRbTVKNrTx9NpKpSrBvnwOe9y5H6pJ2.jpg', '75.00', NULL, '2025-12-30 00:05:07', '2025-12-30 00:05:07'),
(772, 106, 'ready', 71, 'عميد', 'ذهب', '1778376185.png', '200.00', '600.00', '2026-05-09 22:23:05', '2026-05-09 22:23:05'),
(773, 106, 'ready', 71, 'ذهب نانو A', 'ذهب', '1778376772.png', '850.00', '900.00', '2026-05-09 22:32:52', '2026-05-09 22:32:52'),
(774, 106, 'ready', 71, 'ذهب نانو B', 'ذهب نلنو', '1778389449.png', '60.00', '70.00', '2026-05-10 02:04:09', '2026-05-10 02:04:09'),
(775, 89, 'ready', 71, 'بيتزا', 'بيتزا فراخ وجبنه', '1778389845.png', '20.00', '40.00', '2026-05-10 02:10:45', '2026-05-10 02:10:45'),
(777, 106, 'ready', 71, 'ذهب نانو C', 'ذهب نلنو', '1778403879.png', '502.00', '700.00', '2026-05-10 06:04:39', '2026-05-10 06:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_recipes`
--

CREATE TABLE `product_recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_size_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Purchase_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `size`, `Purchase_price`, `selling_price`, `product_id`, `created_at`, `updated_at`) VALUES
(3, 'وسط', 100, 0, 1, '2025-05-07 12:11:01', '2025-05-07 12:11:01'),
(4, 'نص', 150, 0, 1, '2025-05-07 12:11:01', '2025-05-07 12:11:01'),
(5, 'نص', 60, 0, 2, '2025-05-07 12:12:28', '2025-05-07 12:12:28'),
(6, 'كيلو', 120, 0, 2, '2025-05-07 12:12:28', '2025-05-07 12:12:28'),
(7, 'نص', 120, 0, 3, '2025-05-07 12:13:51', '2025-05-07 12:13:51'),
(8, 'كيلو', 130, 0, 3, '2025-05-07 12:13:51', '2025-05-07 12:13:51'),
(9, 'صغير', 40, 0, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18'),
(10, 'وسط', 60, 0, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18'),
(11, 'كبير', 70, 0, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18'),
(12, 'كبير', 40, 0, 5, '2025-05-07 12:31:58', '2025-05-07 12:31:58'),
(13, 'صغير', 40, 0, 6, '2025-08-16 11:47:53', '2025-08-16 11:47:53'),
(14, 'كبير', 110, 0, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12'),
(15, 'وسط', 95, 0, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12'),
(16, 'صغير', 55, 0, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12'),
(17, 'صغيره', 70, 0, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27'),
(18, 'متوسطه', 120, 0, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27'),
(19, 'كبيره', 200, 0, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27'),
(20, 'صغيره', 65, 0, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39'),
(21, 'متوسطه', 90, 0, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39'),
(22, 'كبيره', 120, 0, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39'),
(23, 'صغيره', 50, 0, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47'),
(24, 'متوسطه', 70, 0, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47'),
(25, 'كبيره', 120, 0, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47'),
(26, 'صغيره', 100, 0, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17'),
(27, 'متوسطه', 110, 0, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17'),
(28, 'كبيره', 150, 0, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17'),
(29, 'صغيره', 70, 0, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32'),
(30, 'متوسطه', 90, 0, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32'),
(31, 'كبيره', 120, 0, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32'),
(32, 'صغيره', 70, 0, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00'),
(33, 'متوسطه', 110, 0, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00'),
(34, 'كبيره', 150, 0, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00'),
(35, 'صغيره', 90, 0, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29'),
(36, 'متوسطه', 110, 0, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29'),
(37, 'كبيره', 150, 0, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29'),
(38, 'صغيره', 80, 0, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31'),
(39, 'متوسطه', 100, 0, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31'),
(40, 'كبيره', 120, 0, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31'),
(41, 'صغيره', 70, 0, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04'),
(42, 'متوسطه', 90, 0, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04'),
(43, 'كبيره', 110, 0, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04'),
(44, 'صغيره', 50, 0, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50'),
(45, 'متوسطه', 70, 0, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50'),
(46, 'كبيره', 110, 0, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50'),
(47, 'صغيره', 70, 0, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36'),
(48, 'متوسطه', 90, 0, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36'),
(49, 'كبيره', 110, 0, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36'),
(50, 'large', 100, 0, 19, '2025-08-26 07:36:40', '2025-08-26 07:36:40'),
(51, 'M', 80, 0, 19, '2025-08-26 07:36:40', '2025-08-26 07:36:40'),
(52, 'large', 100, 0, 20, '2025-08-31 09:15:42', '2025-08-31 09:15:42'),
(53, 'large', 100, 0, 21, '2025-08-31 09:24:29', '2025-08-31 09:24:29'),
(54, 'large', 100, 0, 22, '2025-08-31 09:37:19', '2025-08-31 09:37:19'),
(55, 'large', 50, 0, 25, '2025-08-31 10:35:48', '2025-08-31 10:35:48'),
(56, 'large', 50, 0, 26, '2025-08-31 10:40:40', '2025-08-31 10:40:40'),
(57, 'large', 100, 0, 27, '2025-08-31 10:41:10', '2025-08-31 10:41:10'),
(58, 'large', 100, 0, 28, '2025-08-31 10:42:10', '2025-08-31 10:42:10'),
(59, 'large', 30, 0, 29, '2025-08-31 10:45:01', '2025-08-31 10:45:01'),
(60, 'صغير', 10, 0, 29, '2025-08-31 10:45:01', '2025-08-31 10:45:01'),
(61, 'صغير', 10, 0, 30, '2025-08-31 10:45:37', '2025-08-31 10:45:37'),
(62, 'صغير', 100, 0, 31, '2025-08-31 11:02:30', '2025-08-31 11:02:30'),
(63, 'large', 10, 0, 32, '2025-08-31 11:03:31', '2025-08-31 11:03:31'),
(64, 'كبير', 100, 0, 33, '2025-08-31 11:05:49', '2025-08-31 11:05:49'),
(65, 'صغير', 50, 0, 34, '2025-08-31 11:25:21', '2025-08-31 11:25:21'),
(66, 'صغير', 50, 0, 35, '2025-08-31 11:35:37', '2025-08-31 11:35:37'),
(69, 'نص', 40, 0, 36, '2025-08-31 11:57:27', '2025-08-31 11:57:27'),
(70, 'وسط', 100, 0, 37, '2025-09-01 08:44:00', '2025-09-01 08:44:00'),
(72, 'وسط', 100, 0, 39, '2025-09-01 09:14:07', '2025-09-01 09:14:07'),
(73, 'صغير', 120, 0, 40, '2025-09-01 09:19:08', '2025-09-01 09:19:08'),
(75, 'وسط', 120, 0, 41, '2025-09-01 09:26:02', '2025-09-01 09:26:02'),
(77, 'صغير', 100, 0, 42, '2025-09-01 09:28:55', '2025-09-01 09:28:55'),
(81, 'وسط', 150, 0, 43, '2025-09-01 09:36:37', '2025-09-01 09:36:37'),
(83, 'وسط', 120, 0, 44, '2025-09-01 09:39:41', '2025-09-01 09:39:41'),
(85, 'وسط', 120, 0, 45, '2025-09-01 09:44:27', '2025-09-01 09:44:27'),
(88, 'صغير', 100, 0, 46, '2025-09-01 09:48:08', '2025-09-01 09:48:08'),
(90, 'وسط', 100, 0, 47, '2025-09-01 10:14:40', '2025-09-01 10:14:40'),
(91, 'صغير', 100, 0, 48, '2025-09-01 10:16:01', '2025-09-01 10:16:01'),
(93, 'وسط', 100, 0, 49, '2025-09-01 10:17:05', '2025-09-01 10:17:05'),
(94, 'وسط', 150, 0, 50, '2025-09-01 10:18:12', '2025-09-01 10:18:12'),
(97, 'وسط', 120, 0, 51, '2025-09-01 10:24:39', '2025-09-01 10:24:39'),
(98, 'صغير', 20, 0, 52, '2025-09-02 11:49:10', '2025-09-02 11:49:10'),
(99, 'Large', 160, 0, 53, '2025-09-03 15:23:13', '2025-09-03 15:23:13'),
(100, 'صغير', 100, 0, 54, '2025-09-04 08:34:30', '2025-09-04 08:34:30'),
(101, 'Large', 50, 0, 55, '2025-09-04 09:37:03', '2025-09-04 09:37:03'),
(102, 'وسط', 210, 0, 56, '2025-09-04 09:37:48', '2025-09-04 09:37:48'),
(103, 'صغير', 160, 0, 57, '2025-09-04 09:39:53', '2025-09-04 09:39:53'),
(104, 'وسط', 185, 0, 58, '2025-09-04 09:39:53', '2025-09-04 09:39:53'),
(105, 'وسط', 185, 0, 59, '2025-09-04 09:41:18', '2025-09-04 09:41:18'),
(106, 'وسط', 145, 0, 60, '2025-09-04 09:43:46', '2025-09-04 09:43:46'),
(108, 'وسط', 280, 0, 62, '2025-09-04 09:46:42', '2025-09-04 09:46:42'),
(110, 'وسط', 160, 0, 64, '2025-09-04 09:49:08', '2025-09-04 09:49:08'),
(111, 'وسط', 280, 0, 65, '2025-09-04 09:49:59', '2025-09-04 09:49:59'),
(112, 'وسط', 250, 0, 66, '2025-09-04 09:52:00', '2025-09-04 09:52:00'),
(113, 'وسط', 210, 0, 67, '2025-09-04 09:53:30', '2025-09-04 09:53:30'),
(114, 'وسط', 350, 0, 68, '2025-09-04 10:06:09', '2025-09-04 10:06:09'),
(115, 'وسط', 140, 0, 69, '2025-09-04 10:08:06', '2025-09-04 10:08:06'),
(116, 'وسط', 60, 0, 70, '2025-09-04 10:10:16', '2025-09-04 10:10:16'),
(117, 'وسط', 70, 0, 71, '2025-09-04 10:11:16', '2025-09-04 10:11:16'),
(118, 'وسط', 175, 0, 63, '2025-09-04 10:51:43', '2025-09-04 10:51:43'),
(119, 'وسط', 175, 0, 61, '2025-09-04 10:52:19', '2025-09-04 10:52:19'),
(122, 'large', 50, 0, 73, '2025-09-06 11:54:41', '2025-09-06 11:54:41'),
(123, 'وسط', 120, 0, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26'),
(124, 'كبير', 180, 0, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26'),
(125, 'كبير اوي', 220, 0, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26'),
(126, 'كبير خاص', 260, 0, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26'),
(127, 'اكبر حاجه', 300, 0, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26'),
(130, '5*9', 900, 0, 74, '2025-09-14 20:13:33', '2025-09-14 20:13:33'),
(135, 'فاهيتا -', 90, 0, 75, '2025-09-15 17:31:24', '2025-09-15 17:31:24'),
(136, 'سويت -', 100, 0, 76, '2025-09-15 17:33:08', '2025-09-15 17:33:08'),
(137, 'large', 30, 0, 79, '2025-09-16 11:13:33', '2025-09-16 11:13:33'),
(140, 'Large', 160, 0, 82, '2025-09-16 13:06:48', '2025-09-16 13:06:48'),
(141, 'كوردون بلو -', 100, 0, 83, '2025-09-20 10:55:43', '2025-09-20 10:55:43'),
(142, 'تشيكن زنجر -', 90, 0, 84, '2025-09-20 11:00:19', '2025-09-20 11:00:19'),
(144, 'تشيكن بانيه -', 90, 0, 85, '2025-09-20 11:18:20', '2025-09-20 11:18:20'),
(145, 'تشيكن كريسبي -', 90, 0, 86, '2025-09-20 11:19:45', '2025-09-20 11:19:45'),
(146, 'شيش طاووق', 100, 0, 87, '2025-09-20 11:22:37', '2025-09-20 11:22:37'),
(147, 'تشيكن جريل -', 100, 0, 88, '2025-09-20 11:28:05', '2025-09-20 11:28:05'),
(148, 'الكمية 1200 مل', 17900, 0, 89, '2025-09-26 18:47:42', '2025-09-26 18:47:42'),
(149, '800 مل', 9000, 0, 90, '2025-09-26 18:49:06', '2025-09-26 18:49:06'),
(150, '800 مل + ٪ 2', 12000, 0, 91, '2025-09-26 18:50:04', '2025-09-26 18:50:04'),
(151, '500 مل + 2 ٪', 9000, 0, 92, '2025-09-26 18:51:03', '2025-09-26 18:51:03'),
(153, 'سنجل', 35, 0, 109, '2025-11-05 21:52:19', '2025-11-05 21:52:19'),
(154, 'دبل', 45, 0, 109, '2025-11-05 21:52:19', '2025-11-05 21:52:19'),
(155, 'سنجل', 30, 0, 110, '2025-11-05 22:04:13', '2025-11-05 22:04:13'),
(156, 'دبل', 40, 0, 110, '2025-11-05 22:04:13', '2025-11-05 22:04:13'),
(157, 'سنجل', 35, 0, 111, '2025-11-06 20:40:45', '2025-11-06 20:40:45'),
(158, 'دبل', 45, 0, 111, '2025-11-06 20:40:45', '2025-11-06 20:40:45'),
(159, 'كفته مشويه', 75, 0, 112, '2025-11-13 09:01:46', '2025-11-13 09:01:46'),
(160, 'سجق شرقي', 75, 0, 113, '2025-11-13 09:05:48', '2025-11-13 09:05:48'),
(161, 'سجق شرقي', 75, 0, 114, '2025-11-13 09:07:40', '2025-11-13 09:07:40'),
(162, 'بيف برجر', 75, 0, 115, '2025-11-13 09:11:35', '2025-11-13 09:11:35'),
(163, 'هوت دوج', 75, 0, 116, '2025-11-13 09:13:47', '2025-11-13 09:13:47'),
(164, 'كريب مشروم', 70, 0, 117, '2025-11-13 09:15:23', '2025-11-13 09:15:23'),
(165, 'كريب بطاطس', 45, 0, 118, '2025-11-13 09:17:58', '2025-11-13 09:17:58'),
(166, 'ميكس شيش كفته', 125, 0, 119, '2025-11-13 09:24:26', '2025-11-13 09:24:26'),
(167, 'ميككس تشيكن', 135, 0, 120, '2025-11-13 09:27:20', '2025-11-13 09:27:20'),
(168, 'ميكس لحوم', 140, 0, 121, '2025-11-13 09:29:12', '2025-11-13 09:29:12'),
(169, 'ميكس لحوم', 140, 0, 122, '2025-11-13 09:29:22', '2025-11-13 09:29:22'),
(170, 'ميكس لحوم', 140, 0, 123, '2025-11-13 09:30:14', '2025-11-13 09:30:14'),
(174, 'ميكس كوكتيل', 140, 0, 124, '2025-11-13 09:56:56', '2025-11-13 09:56:56'),
(175, 'ميكس ابو البنات', 155, 0, 125, '2025-11-13 09:59:21', '2025-11-13 09:59:21'),
(176, 'حواوشي كلاسيك كبير', 60, 0, 126, '2025-11-13 10:02:39', '2025-11-13 10:02:39'),
(177, 'حواوشي بالجبنه كبير', 75, 0, 127, '2025-11-13 10:09:42', '2025-11-13 10:09:42'),
(178, 'حواوشي تركي مدخن', 90, 0, 128, '2025-11-13 10:13:22', '2025-11-13 10:13:22'),
(179, 'حواوشي بيف بيكون', 90, 0, 129, '2025-11-13 10:14:17', '2025-11-13 10:14:17'),
(180, 'حواوشي سجق', 90, 0, 130, '2025-11-13 10:14:49', '2025-11-13 10:14:49'),
(181, 'حواوشي ابو البنات', 110, 0, 131, '2025-11-13 10:15:30', '2025-11-13 10:15:30'),
(182, 'صاج', 75, 0, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06'),
(183, 'فرنساوي', 85, 0, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06'),
(184, 'كايزر', 55, 0, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06'),
(185, 'صاج', 80, 0, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33'),
(186, 'فرنساوي', 90, 0, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33'),
(187, 'كايزر', 60, 0, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33'),
(188, 'صاج', 80, 0, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39'),
(189, 'فرنساوي', 90, 0, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39'),
(190, 'كايزر', 65, 0, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39'),
(191, 'صاج', 90, 0, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27'),
(192, 'فرنساوي', 90, 0, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27'),
(193, 'كايزر', 65, 0, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27'),
(194, 'صاج', 95, 0, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43'),
(195, 'فرنساوي', 95, 0, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43'),
(196, 'كايزر', 70, 0, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43'),
(197, 'صاج', 95, 0, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36'),
(198, 'فرنساوي', 95, 0, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36'),
(199, 'كايزر', 70, 0, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36'),
(200, 'وجبه شاورما فراخ سينجل', 110, 0, 138, '2025-11-13 10:58:50', '2025-11-13 10:58:50'),
(201, 'وجبه شاورما فراخ دبل', 180, 0, 139, '2025-11-13 10:59:47', '2025-11-13 10:59:47'),
(202, 'وجبه شاورما لحمه سينجل', 120, 0, 140, '2025-11-13 11:00:46', '2025-11-13 11:00:46'),
(203, 'وجبه شاورما لحمه دبل', 190, 0, 141, '2025-11-13 11:01:29', '2025-11-13 11:01:29'),
(204, 'وجبه ماريا لحمه', 130, 0, 142, '2025-11-13 11:02:27', '2025-11-13 11:02:27'),
(205, 'وجبه ماريا فراخ', 120, 0, 143, '2025-11-13 11:03:21', '2025-11-13 11:03:21'),
(206, 'وجبه شاورما فراخ كبيره', 150, 0, 144, '2025-11-13 11:04:55', '2025-11-13 11:04:55'),
(209, 'فته شاورما لحمه وسط', 125, 0, 147, '2025-11-13 11:08:51', '2025-11-13 11:08:51'),
(210, 'فته شاورما فراخ وسط', 120, 0, 145, '2025-11-13 11:09:35', '2025-11-13 11:09:35'),
(211, 'فته شاورما لحمه كبيره', 150, 0, 146, '2025-11-13 11:10:02', '2025-11-13 11:10:02'),
(212, 'وجبه شاورما فرط', 140, 0, 148, '2025-11-13 11:11:06', '2025-11-13 11:11:06'),
(213, 'وجبه نص كيلو شاورما فراخ', 250, 0, 149, '2025-11-13 11:12:07', '2025-11-13 11:12:07'),
(214, 'وجبه كيلو شاورما فراخ', 500, 0, 150, '2025-11-13 11:13:05', '2025-11-13 11:13:05'),
(215, 'بيتزا مارجريتا', 115, 0, 151, '2025-11-13 12:11:17', '2025-11-13 12:11:17'),
(216, 'بيتزا خضروات', 125, 0, 152, '2025-11-13 12:13:17', '2025-11-13 12:13:17'),
(217, 'بيتزا ميكس جبن', 140, 0, 153, '2025-11-13 12:14:54', '2025-11-13 12:14:54'),
(218, 'بيتزا سلامي', 150, 0, 154, '2025-11-13 12:15:57', '2025-11-13 12:15:57'),
(219, 'بيتزا سجق', 150, 0, 155, '2025-11-13 12:17:29', '2025-11-13 12:17:29'),
(220, 'بيتزا تشيكن باربيكيو', 170, 0, 156, '2025-11-13 12:19:35', '2025-11-13 12:19:35'),
(221, 'بيتزا تشيكن سوبريم', 180, 0, 157, '2025-11-13 12:23:42', '2025-11-13 12:23:42'),
(222, 'بيتزا سوبر سوبريم', 190, 0, 158, '2025-11-13 12:26:54', '2025-11-13 12:26:54'),
(223, 'منقوشه قشقوان', 20, 0, 159, '2025-11-13 12:32:58', '2025-11-13 12:32:58'),
(224, 'منقوشه بيض عيون', 25, 0, 160, '2025-11-13 12:34:14', '2025-11-13 12:34:14'),
(225, 'منقوشه حلوم', 20, 0, 161, '2025-11-13 12:34:53', '2025-11-13 12:34:53'),
(226, 'منقوشه محمره', 20, 0, 162, '2025-11-13 12:35:34', '2025-11-13 12:35:34'),
(227, 'منقوشه سبانخ', 25, 0, 163, '2025-11-13 12:36:16', '2025-11-13 12:36:16'),
(228, 'منقوشه زعتر', 17, 0, 164, '2025-11-13 12:36:49', '2025-11-13 12:36:49'),
(229, 'منقوشه كيري', 20, 0, 165, '2025-11-13 12:37:21', '2025-11-13 12:37:21'),
(230, 'ميني بيتزا', 20, 0, 166, '2025-11-13 12:37:58', '2025-11-13 12:37:58'),
(231, 'منقوشه لحم بالعجين', 25, 0, 167, '2025-11-13 12:38:41', '2025-11-13 12:38:41'),
(232, 'بنا الفريدو', 80, 0, 168, '2025-11-13 12:40:52', '2025-11-13 12:40:52'),
(233, 'تشيكن ميكس تشيز', 90, 0, 169, '2025-11-13 12:41:52', '2025-11-13 12:41:52'),
(234, 'نجرسكو', 80, 0, 170, '2025-11-13 12:42:38', '2025-11-13 12:42:38'),
(235, 'تشيكن بيستو', 90, 0, 171, '2025-11-13 12:43:32', '2025-11-13 12:43:32'),
(236, 'اسباجيتي ميت بول', 90, 0, 172, '2025-11-13 12:44:21', '2025-11-13 12:44:21'),
(237, 'اربياتا بنا', 60, 0, 173, '2025-11-13 12:45:07', '2025-11-13 12:45:07'),
(238, 'باستا شيتوس', 80, 0, 174, '2025-11-13 12:45:50', '2025-11-13 12:45:50'),
(239, '2قطع دجاج بروست صدر', 120, 0, 175, '2025-11-13 12:47:41', '2025-11-13 12:47:41'),
(240, '2قطع كرسبي', 120, 0, 176, '2025-11-13 12:48:16', '2025-11-13 12:48:16'),
(241, '2قطع دجاج بروست ورك', 110, 0, 177, '2025-11-13 12:49:13', '2025-11-13 12:49:13'),
(242, '4قطع كرسبي', 120, 0, 178, '2025-11-13 12:49:52', '2025-11-13 12:49:52'),
(243, '4قطع دجاج بروست', 190, 0, 179, '2025-11-13 12:50:47', '2025-11-13 12:50:47'),
(244, '5قطع كرسبي', 190, 0, 180, '2025-11-13 12:51:36', '2025-11-13 12:51:36'),
(245, 'فرخه بروست8 قطع', 360, 0, 181, '2025-11-13 12:52:29', '2025-11-13 12:52:29'),
(246, 'وجبه اجنحه دجاج', 90, 0, 182, '2025-11-13 12:53:23', '2025-11-13 12:53:23'),
(247, 'وجبه10قطع بانيه', 350, 0, 183, '2025-11-13 12:54:09', '2025-11-13 12:54:09'),
(248, 'سوري', 80, 0, 184, '2025-11-13 13:52:00', '2025-11-13 13:52:00'),
(249, 'فرنساوي', 90, 0, 184, '2025-11-13 13:52:00', '2025-11-13 13:52:00'),
(250, 'سوري', 80, 0, 185, '2025-11-13 13:53:28', '2025-11-13 13:53:28'),
(251, 'فرنساوي', 90, 0, 185, '2025-11-13 13:53:28', '2025-11-13 13:53:28'),
(252, 'سوري', 80, 0, 186, '2025-11-13 13:54:32', '2025-11-13 13:54:32'),
(253, 'فرنساوي', 90, 0, 186, '2025-11-13 13:54:32', '2025-11-13 13:54:32'),
(254, 'سوري', 80, 0, 187, '2025-11-13 13:55:16', '2025-11-13 13:55:16'),
(255, 'فرنساوي', 90, 0, 187, '2025-11-13 13:55:16', '2025-11-13 13:55:16'),
(256, 'سوري', 80, 0, 188, '2025-11-13 13:55:52', '2025-11-13 13:55:52'),
(257, 'فرنساوي', 90, 0, 188, '2025-11-13 13:55:52', '2025-11-13 13:55:52'),
(258, 'سوري', 80, 0, 189, '2025-11-13 13:56:34', '2025-11-13 13:56:34'),
(259, 'فرنساوي', 90, 0, 189, '2025-11-13 13:56:34', '2025-11-13 13:56:34'),
(260, 'سوري', 80, 0, 190, '2025-11-13 13:57:42', '2025-11-13 13:57:42'),
(261, 'فرنساوي', 90, 0, 190, '2025-11-13 13:57:42', '2025-11-13 13:57:42'),
(262, 'فرنساوي', 110, 0, 191, '2025-11-13 13:59:12', '2025-11-13 13:59:12'),
(263, 'فرنساوي', 110, 0, 192, '2025-11-13 14:00:51', '2025-11-13 14:00:51'),
(264, 'فرنساوي', 110, 0, 193, '2025-11-13 14:02:20', '2025-11-13 14:02:20'),
(265, 'فرنساوي', 110, 0, 194, '2025-11-13 14:03:37', '2025-11-13 14:03:37'),
(266, 'برجر كلاسيك', 60, 0, 195, '2025-11-13 14:11:06', '2025-11-13 14:11:06'),
(267, 'برجر بيض', 70, 0, 196, '2025-11-13 14:12:27', '2025-11-13 14:12:27'),
(268, 'برجر فولكانو', 90, 0, 197, '2025-11-13 14:14:55', '2025-11-13 14:14:55'),
(269, 'سموك هاوس باربكيو', 110, 0, 198, '2025-11-13 14:17:15', '2025-11-13 14:17:15'),
(270, 'سموك هاوس باربكيو', 110, 0, 199, '2025-11-13 14:17:34', '2025-11-13 14:17:34'),
(271, 'انجري برجر', 110, 0, 200, '2025-11-13 14:20:27', '2025-11-13 14:20:27'),
(272, 'ميجا مشروم', 100, 0, 201, '2025-11-13 14:21:39', '2025-11-13 14:21:39'),
(273, 'ميكس بافلو', 110, 0, 202, '2025-11-13 14:24:02', '2025-11-13 14:24:02'),
(274, 'بيج مان', 115, 0, 203, '2025-11-13 14:25:46', '2025-11-13 14:25:46'),
(275, 'سندوتش كلاسيك', 90, 0, 204, '2025-11-13 14:27:18', '2025-11-13 14:27:18'),
(276, 'تشيكن رانش', 100, 0, 205, '2025-11-13 14:28:41', '2025-11-13 14:28:41'),
(277, 'فاير هوت', 100, 0, 206, '2025-11-13 14:30:13', '2025-11-13 14:30:13'),
(278, 'سوري', 65, 0, 207, '2025-11-13 14:37:13', '2025-11-13 14:37:13'),
(279, 'فرنساوي', 70, 0, 207, '2025-11-13 14:37:13', '2025-11-13 14:37:13'),
(280, 'سوري', 65, 0, 208, '2025-11-13 14:37:58', '2025-11-13 14:37:58'),
(281, 'فرنساوي', 70, 0, 208, '2025-11-13 14:37:58', '2025-11-13 14:37:58'),
(282, 'سوري', 40, 0, 209, '2025-11-13 14:42:41', '2025-11-13 14:42:41'),
(283, 'فرنساوي', 45, 0, 209, '2025-11-13 14:42:41', '2025-11-13 14:42:41'),
(284, 'سوري', 65, 0, 210, '2025-11-13 14:43:37', '2025-11-13 14:43:37'),
(285, 'فرنساوي', 65, 0, 210, '2025-11-13 14:43:37', '2025-11-13 14:43:37'),
(286, 'سوري', 55, 0, 211, '2025-11-13 14:50:30', '2025-11-13 14:50:30'),
(287, 'فرنساوي', 65, 0, 211, '2025-11-13 14:50:30', '2025-11-13 14:50:30'),
(288, 'سوري', 80, 0, 212, '2025-11-13 14:51:25', '2025-11-13 14:51:25'),
(289, 'فرنساوي', 95, 0, 212, '2025-11-13 14:51:25', '2025-11-13 14:51:25'),
(290, 'سوري', 30, 0, 213, '2025-11-13 14:52:11', '2025-11-13 14:52:11'),
(291, 'فرنساوي', 40, 0, 213, '2025-11-13 14:52:11', '2025-11-13 14:52:11'),
(292, 'سوري', 45, 0, 214, '2025-11-13 14:53:02', '2025-11-13 14:53:02'),
(293, 'فرنساوي', 45, 0, 214, '2025-11-13 14:53:02', '2025-11-13 14:53:02'),
(311, 'وجبه فراخ بانيه', 160, 0, 215, '2025-11-13 15:14:47', '2025-11-13 15:14:47'),
(312, 'وجبه تشيكن كرسبي', 160, 0, 216, '2025-11-13 15:15:48', '2025-11-13 15:15:48'),
(313, 'وجبه ميكس شيش+كفته', 210, 0, 217, '2025-11-13 15:16:01', '2025-11-13 15:16:01'),
(314, 'وجبه ميكس شاورما لحمه+شاورما فراخ', 210, 0, 218, '2025-11-13 15:16:25', '2025-11-13 15:16:25'),
(315, 'وجبه ربع كفته', 170, 0, 219, '2025-11-13 15:16:39', '2025-11-13 15:16:39'),
(316, 'وجبه استربس', 160, 0, 220, '2025-11-13 15:16:59', '2025-11-13 15:16:59'),
(317, 'وجبه شيش طاووق', 180, 0, 221, '2025-11-13 15:17:26', '2025-11-13 15:17:26'),
(318, 'وجبه ميكس ابو البنات', 240, 0, 222, '2025-11-13 15:17:48', '2025-11-13 15:17:48'),
(319, 'كيلو كفته', 380, 0, 223, '2025-11-13 15:18:01', '2025-11-13 15:18:01'),
(320, 'نص كيلو كفته', 220, 0, 224, '2025-11-13 15:19:02', '2025-11-13 15:19:02'),
(321, 'فرخه مشويه', 330, 0, 225, '2025-11-13 15:19:34', '2025-11-13 15:19:34'),
(322, 'نص فرخه مشويه', 185, 0, 226, '2025-11-13 15:19:50', '2025-11-13 15:19:50'),
(323, 'ربع فرخه صدر', 125, 0, 227, '2025-11-13 15:20:00', '2025-11-13 15:20:00'),
(324, 'ربع فرخه ورك', 115, 0, 228, '2025-11-13 15:20:13', '2025-11-13 15:20:13'),
(325, 'كيلو شيش طاووق', 400, 0, 229, '2025-11-13 15:20:27', '2025-11-13 15:20:27'),
(326, 'كيلو صدور', 400, 0, 230, '2025-11-13 15:20:47', '2025-11-13 15:20:47'),
(327, 'ميكس تشيز', 25, 0, 231, '2025-11-13 16:00:52', '2025-11-13 16:00:52'),
(328, 'ميكس تشيز', 25, 0, 232, '2025-11-13 16:00:55', '2025-11-13 16:00:55'),
(329, 'جبنه موتزاريلا او صوص من اختيارك', 20, 0, 233, '2025-11-13 16:10:35', '2025-11-13 16:10:35'),
(330, 'باكيت بطاطس بالجبنه', 45, 0, 234, '2025-11-13 16:13:14', '2025-11-13 16:13:14'),
(331, 'اضافه لحوم او فراخ', 30, 0, 235, '2025-11-13 16:14:27', '2025-11-13 16:14:27'),
(333, 'عبوة', 244.1, 0, 238, '2025-11-22 19:29:51', '2025-11-22 19:29:51'),
(334, 'عبوة', 337.5, 0, 237, '2025-11-22 19:30:18', '2025-11-22 19:30:18'),
(336, 'عبوة', 469, 0, 240, '2025-11-22 19:32:06', '2025-11-22 19:32:06'),
(338, 'عبوة', 400, 0, 243, '2025-11-22 19:32:45', '2025-11-22 19:32:45'),
(339, 'عبوة', 289, 0, 244, '2025-11-22 19:33:24', '2025-11-22 19:33:24'),
(340, 'عبوة', 275, 0, 246, '2025-11-22 19:33:47', '2025-11-22 19:33:47'),
(341, 'عبوة', 90.3, 0, 248, '2025-11-22 19:34:02', '2025-11-22 19:34:02'),
(342, 'عبوة', 253.44, 0, 250, '2025-11-22 19:34:25', '2025-11-22 19:34:25'),
(343, 'عبوة', 315, 0, 252, '2025-11-22 19:34:38', '2025-11-22 19:34:38'),
(344, 'عبوة', 222.3, 0, 254, '2025-11-22 19:34:58', '2025-11-22 19:34:58'),
(345, 'عبوة', 299.99, 0, 256, '2025-11-22 19:35:13', '2025-11-22 19:35:13'),
(346, 'عبوة', 85.5, 0, 258, '2025-11-22 19:35:28', '2025-11-22 19:35:28'),
(347, 'عبوة', 232, 0, 260, '2025-11-22 19:35:41', '2025-11-22 19:35:41'),
(348, 'عبوة', 284.99, 0, 262, '2025-11-22 19:35:54', '2025-11-22 19:35:54'),
(349, 'عبوة', 106.86, 0, 265, '2025-11-22 19:36:06', '2025-11-22 19:36:06'),
(350, 'عبوة', 324, 0, 266, '2025-11-22 19:36:20', '2025-11-22 19:36:20'),
(351, 'عبوة', 469, 0, 269, '2025-11-22 19:36:34', '2025-11-22 19:36:34'),
(352, 'عبوة', 36.9, 0, 270, '2025-11-22 19:36:53', '2025-11-22 19:36:53'),
(353, 'صغير', 10, 0, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20'),
(354, 'وسط', 15, 0, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20'),
(355, 'كبير', 20, 0, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20'),
(356, 'صغير', 10, 0, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25'),
(357, 'وسط', 15, 0, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25'),
(358, 'كبير', 20, 0, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25'),
(359, 'صغير', 10, 0, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02'),
(360, 'وسط', 15, 0, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02'),
(361, 'كبير', 20, 0, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02'),
(362, 'صغير', 10, 0, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50'),
(363, 'وسط', 15, 0, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50'),
(364, 'كبير', 20, 0, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50'),
(365, 'صغير', 10, 0, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41'),
(366, 'وسط', 15, 0, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41'),
(367, 'كبير', 20, 0, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41'),
(368, 'صغير', 10, 0, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32'),
(369, 'وسط', 15, 0, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32'),
(370, 'كبير', 20, 0, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32'),
(371, 'صغير', 10, 0, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21'),
(372, 'وسط', 15, 0, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21'),
(373, 'كبير', 20, 0, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21'),
(374, 'صغير', 10, 0, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39'),
(375, 'وسط', 15, 0, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39'),
(376, 'كبير', 20, 0, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39'),
(377, 'صغير', 10, 0, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48'),
(378, 'وسط', 15, 0, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48'),
(379, 'كبير', 20, 0, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48'),
(380, 'صغير', 10, 0, 286, '2025-12-04 20:07:06', '2025-12-04 20:07:06'),
(381, 'وسط', 15, 0, 286, '2025-12-04 20:07:06', '2025-12-04 20:07:06'),
(382, 'كبير', 20, 0, 286, '2025-12-04 20:07:06', '2025-12-04 20:07:06'),
(383, 'صغير', 10, 0, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56'),
(384, 'وسط', 15, 0, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56'),
(385, 'كبير', 20, 0, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56'),
(386, 'صغير', 10, 0, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45'),
(387, 'وسط', 15, 0, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45'),
(388, 'كبير', 20, 0, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45'),
(389, 'صغير', 10, 0, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33'),
(390, 'وسط', 15, 0, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33'),
(391, 'كبير', 20, 0, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33'),
(392, 'صغير', 10, 0, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40'),
(393, 'وسط', 15, 0, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40'),
(394, 'كبير', 20, 0, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40'),
(395, 'صغير', 10, 0, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18'),
(396, 'وسط', 15, 0, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18'),
(397, 'كبير', 20, 0, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18'),
(398, '١٥ ملي', 10, 0, 292, '2025-12-04 20:23:44', '2025-12-04 20:23:44'),
(399, 'صغير', 10, 0, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49'),
(400, 'وسط', 15, 0, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49'),
(401, 'كبير', 20, 0, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49'),
(405, 'عبوه', 200, 0, 295, '2025-12-04 20:26:42', '2025-12-04 20:26:42'),
(406, 'عبوه', 200, 0, 296, '2025-12-04 20:27:41', '2025-12-04 20:27:41'),
(407, 'عبوه', 200, 0, 297, '2025-12-04 20:28:18', '2025-12-04 20:28:18'),
(410, 'سنجل', 140, 0, 299, '2025-12-08 17:52:14', '2025-12-08 17:52:14'),
(411, 'دبل', 215, 0, 299, '2025-12-08 17:52:14', '2025-12-08 17:52:14'),
(416, 'سنجل', 140, 0, 300, '2025-12-08 17:58:56', '2025-12-08 17:58:56'),
(417, 'دبل', 210, 0, 300, '2025-12-08 17:58:56', '2025-12-08 17:58:56'),
(420, 'دبل', 175, 0, 303, '2025-12-08 18:11:54', '2025-12-08 18:11:54'),
(427, 'سنجل', 120, 0, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19'),
(428, 'دبل', 150, 0, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19'),
(429, 'تربل', 185, 0, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19'),
(436, 'سنجل', 110, 0, 309, '2025-12-08 18:27:35', '2025-12-08 18:27:35'),
(437, 'دبل', 145, 0, 309, '2025-12-08 18:27:35', '2025-12-08 18:27:35'),
(438, 'سنجل', 125, 0, 310, '2025-12-08 18:29:05', '2025-12-08 18:29:05'),
(439, 'دبل', 155, 0, 310, '2025-12-08 18:29:05', '2025-12-08 18:29:05'),
(440, 'سنجل', 125, 0, 311, '2025-12-08 18:30:41', '2025-12-08 18:30:41'),
(441, 'دبل', 155, 0, 311, '2025-12-08 18:30:41', '2025-12-08 18:30:41'),
(444, 'سنجل', 120, 0, 313, '2025-12-08 18:36:33', '2025-12-08 18:36:33'),
(445, 'دبل', 155, 0, 313, '2025-12-08 18:36:33', '2025-12-08 18:36:33'),
(446, 'سنجل', 145, 0, 314, '2025-12-08 18:46:43', '2025-12-08 18:46:43'),
(447, 'دبل', 175, 0, 314, '2025-12-08 18:46:43', '2025-12-08 18:46:43'),
(448, 'سنجل', 150, 0, 315, '2025-12-08 18:55:45', '2025-12-08 18:55:45'),
(449, 'دبل', 185, 0, 315, '2025-12-08 18:55:45', '2025-12-08 18:55:45'),
(450, 'حجم صغير', 40, 0, 316, '2025-12-08 18:58:39', '2025-12-08 18:58:39'),
(451, 'حجم كبير', 75, 0, 316, '2025-12-08 18:58:39', '2025-12-08 18:58:39'),
(452, 'حجم صغير', 45, 0, 317, '2025-12-08 19:00:13', '2025-12-08 19:00:13'),
(453, 'حجم كبير', 80, 0, 317, '2025-12-08 19:00:13', '2025-12-08 19:00:13'),
(454, 'كبير', 60, 0, 318, '2025-12-08 19:02:09', '2025-12-08 19:02:09'),
(455, 'كبير', 75, 0, 319, '2025-12-08 19:03:40', '2025-12-08 19:03:40'),
(457, 'كبير', 90, 0, 321, '2025-12-08 19:08:53', '2025-12-08 19:08:53'),
(458, 'كبير', 90, 0, 322, '2025-12-08 19:10:28', '2025-12-08 19:10:28'),
(459, 'كبير', 45, 0, 323, '2025-12-08 19:11:59', '2025-12-08 19:11:59'),
(460, 'كبير', 45, 0, 324, '2025-12-08 19:13:18', '2025-12-08 19:13:18'),
(490, 'وسط', 135, 0, 337, '2025-12-08 20:22:53', '2025-12-08 20:22:53'),
(492, 'كبير', 140, 0, 339, '2025-12-08 20:26:36', '2025-12-08 20:26:36'),
(496, 'طبق', 25, 0, 343, '2025-12-08 20:33:42', '2025-12-08 20:33:42'),
(497, 'طبق', 10, 0, 344, '2025-12-08 20:34:56', '2025-12-08 20:34:56'),
(498, 'طبق', 15, 0, 345, '2025-12-08 20:37:25', '2025-12-08 20:37:25'),
(499, 'طبق', 10, 0, 346, '2025-12-08 20:38:29', '2025-12-08 20:38:29'),
(500, 'طبق', 20, 0, 347, '2025-12-08 20:39:45', '2025-12-08 20:39:45'),
(501, 'طبق', 20, 0, 348, '2025-12-08 20:41:14', '2025-12-08 20:41:14'),
(502, 'طبق', 20, 0, 349, '2025-12-08 20:42:44', '2025-12-08 20:42:44'),
(503, 'طبق', 15, 0, 350, '2025-12-08 20:43:49', '2025-12-08 20:43:49'),
(504, 'طبق', 15, 0, 351, '2025-12-08 20:45:14', '2025-12-08 20:45:14'),
(508, 'وجبة', 200, 0, 355, '2025-12-08 21:08:19', '2025-12-08 21:08:19'),
(509, 'سوري', 90, 0, 381, '2025-12-09 13:29:03', '2025-12-09 13:29:03'),
(510, 'فرنساوي', 95, 0, 381, '2025-12-09 13:29:03', '2025-12-09 13:29:03'),
(511, 'سوري', 90, 0, 382, '2025-12-09 13:31:31', '2025-12-09 13:31:31'),
(512, 'فرنساوي', 95, 0, 382, '2025-12-09 13:31:31', '2025-12-09 13:31:31'),
(513, 'سوري', 95, 0, 383, '2025-12-09 13:36:47', '2025-12-09 13:36:47'),
(514, 'فرنساوي', 100, 0, 383, '2025-12-09 13:36:47', '2025-12-09 13:36:47'),
(515, 'سوري', 95, 0, 384, '2025-12-09 13:38:46', '2025-12-09 13:38:46'),
(516, 'فرنساوي', 95, 0, 384, '2025-12-09 13:38:46', '2025-12-09 13:38:46'),
(517, 'سوري', 90, 0, 385, '2025-12-09 13:39:53', '2025-12-09 13:39:53'),
(518, 'فرنساوي', 95, 0, 385, '2025-12-09 13:39:53', '2025-12-09 13:39:53'),
(519, 'سوري', 95, 0, 386, '2025-12-09 13:41:50', '2025-12-09 13:41:50'),
(520, 'فرنساوي', 100, 0, 386, '2025-12-09 13:41:50', '2025-12-09 13:41:50'),
(521, 'سوري', 140, 0, 387, '2025-12-09 13:44:28', '2025-12-09 13:44:28'),
(522, 'فرنساوي', 150, 0, 387, '2025-12-09 13:44:28', '2025-12-09 13:44:28'),
(523, 'سوري', 50, 0, 388, '2025-12-09 13:46:12', '2025-12-09 13:46:12'),
(524, 'فرنساوي', 55, 0, 388, '2025-12-09 13:46:12', '2025-12-09 13:46:12'),
(525, 'سوري', 35, 0, 389, '2025-12-09 13:52:16', '2025-12-09 13:52:16'),
(526, 'فرنساوي', 40, 0, 389, '2025-12-09 13:52:16', '2025-12-09 13:52:16'),
(527, 'سوري', 40, 0, 390, '2025-12-09 13:53:37', '2025-12-09 13:53:37'),
(528, 'فرنساوي', 45, 0, 390, '2025-12-09 13:53:37', '2025-12-09 13:53:37'),
(529, 'سوري', 30, 0, 391, '2025-12-09 13:54:38', '2025-12-09 13:54:38'),
(530, 'فرنساوي', 35, 0, 391, '2025-12-09 13:54:38', '2025-12-09 13:54:38'),
(531, 'وجبه', 150, 0, 392, '2025-12-09 13:56:51', '2025-12-09 13:56:51'),
(537, 'وجبه', 155, 0, 398, '2025-12-09 14:12:27', '2025-12-09 14:12:27'),
(538, 'وجبه', 150, 0, 396, '2025-12-09 14:12:47', '2025-12-09 14:12:47'),
(539, 'وجبه', 150, 0, 393, '2025-12-09 14:13:12', '2025-12-09 14:13:12'),
(540, 'وجبه', 155, 0, 394, '2025-12-09 14:13:21', '2025-12-09 14:13:21'),
(541, 'وجبه', 155, 0, 395, '2025-12-09 14:13:29', '2025-12-09 14:13:29'),
(542, 'وجبه', 150, 0, 397, '2025-12-09 14:13:39', '2025-12-09 14:13:39'),
(543, 'فراخ', 65, 0, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22'),
(544, 'لحمه', 80, 0, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22'),
(545, 'مكس', 75, 0, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22'),
(546, 'فراخ', 75, 0, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33'),
(547, 'لحمه', 90, 0, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33'),
(548, 'مكس', 85, 0, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33'),
(549, 'فراخ', 95, 0, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58'),
(550, 'لحمه', 110, 0, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58'),
(551, 'مكس', 100, 0, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58'),
(552, 'فراخ', 100, 0, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19'),
(553, 'لحمه', 125, 0, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19'),
(554, 'مكس', 115, 0, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19'),
(555, 'فراخ', 165, 0, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16'),
(556, 'لحمه', 190, 0, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16'),
(557, 'مكس', 170, 0, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16'),
(558, 'فراخ', 110, 0, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06'),
(559, 'لحمه', 125, 0, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06'),
(560, 'مكس', 120, 0, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06'),
(561, 'فراخ', 100, 0, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49'),
(562, 'لحمه', 145, 0, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49'),
(563, 'مكس', 140, 0, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49'),
(564, 'وجبه', 330, 0, 406, '2025-12-09 14:29:53', '2025-12-09 14:29:53'),
(565, 'وجبه', 175, 0, 407, '2025-12-09 14:30:56', '2025-12-09 14:30:56'),
(566, 'وجبه', 100, 0, 408, '2025-12-09 14:33:26', '2025-12-09 14:33:26'),
(567, 'وجبه', 110, 0, 409, '2025-12-09 14:35:57', '2025-12-09 14:35:57'),
(568, 'وجبه', 165, 0, 410, '2025-12-09 14:38:10', '2025-12-09 14:38:10'),
(569, 'طبق', 50, 0, 411, '2025-12-09 14:39:59', '2025-12-09 14:39:59'),
(570, 'طبق', 20, 0, 412, '2025-12-09 14:42:22', '2025-12-09 14:42:22'),
(571, 'طبق', 20, 0, 413, '2025-12-09 14:43:22', '2025-12-09 14:43:22'),
(572, 'طبق', 25, 0, 414, '2025-12-09 14:44:48', '2025-12-09 14:44:48'),
(573, 'طبق', 30, 0, 415, '2025-12-09 14:45:42', '2025-12-09 14:45:42'),
(574, 'طبق', 25, 0, 416, '2025-12-09 14:47:44', '2025-12-09 14:47:44'),
(575, 'طبق', 25, 0, 417, '2025-12-09 14:49:21', '2025-12-09 14:49:21'),
(576, 'طبق', 15, 0, 418, '2025-12-09 14:50:28', '2025-12-09 14:50:28'),
(577, 'طبق', 35, 0, 419, '2025-12-09 14:51:45', '2025-12-09 14:51:45'),
(578, 'طبق', 25, 0, 420, '2025-12-09 14:52:27', '2025-12-09 14:52:27'),
(579, 'عيش', 5, 0, 421, '2025-12-09 14:53:52', '2025-12-09 14:53:52'),
(580, 'وجبه', 100, 0, 422, '2025-12-09 14:57:07', '2025-12-09 14:57:07'),
(581, 'وجبه', 110, 0, 422, '2025-12-09 14:57:07', '2025-12-09 14:57:07'),
(582, 'وجبه', 125, 0, 423, '2025-12-09 14:58:30', '2025-12-09 14:58:30'),
(583, 'وجبه', 195, 0, 424, '2025-12-09 15:00:13', '2025-12-09 15:00:13'),
(584, 'وجبه', 280, 0, 425, '2025-12-09 15:02:27', '2025-12-09 15:02:27'),
(585, 'وجبه', 380, 0, 426, '2025-12-09 15:03:50', '2025-12-09 15:03:50'),
(586, 'وجبه', 565, 0, 427, '2025-12-09 15:06:40', '2025-12-09 15:06:40'),
(587, 'وجبه', 750, 0, 428, '2025-12-09 15:07:16', '2025-12-09 15:07:16'),
(588, 'علبه', 900, 0, 429, '2025-12-09 16:08:31', '2025-12-09 16:08:31'),
(589, 'علبه', 1000, 0, 430, '2025-12-09 16:11:23', '2025-12-09 16:11:23'),
(590, 'علبه', 1100, 0, 431, '2025-12-09 16:13:12', '2025-12-09 16:13:12'),
(591, 'علبه', 1250, 0, 432, '2025-12-09 16:14:47', '2025-12-09 16:14:47'),
(592, 'علبه', 750, 0, 433, '2025-12-09 16:19:28', '2025-12-09 16:19:28'),
(593, 'علبه', 400, 0, 434, '2025-12-09 16:20:43', '2025-12-09 16:20:43'),
(594, 'علبه', 400, 0, 435, '2025-12-09 16:21:58', '2025-12-09 16:21:58'),
(595, 'علبه', 1500, 0, 436, '2025-12-09 16:23:40', '2025-12-09 16:23:40'),
(596, 'علبه', 1400, 0, 437, '2025-12-09 16:25:28', '2025-12-09 16:25:28'),
(597, 'علبه', 750, 0, 438, '2025-12-09 16:27:31', '2025-12-09 16:27:31'),
(598, 'علب', 0, 0, 439, '2025-12-09 16:31:53', '2025-12-09 16:31:53'),
(599, 'علبه', 0, 0, 440, '2025-12-09 16:34:13', '2025-12-09 16:34:13'),
(600, 'علبه', 0, 0, 441, '2025-12-09 16:35:50', '2025-12-09 16:35:50'),
(601, 'علبه', 0, 0, 442, '2025-12-09 16:37:25', '2025-12-09 16:37:25'),
(602, 'علبه', 0, 0, 443, '2025-12-09 16:38:37', '2025-12-09 16:38:37'),
(603, 'علبه', 0, 0, 444, '2025-12-09 16:40:43', '2025-12-09 16:40:43'),
(604, 'علبه', 0, 0, 445, '2025-12-09 16:44:07', '2025-12-09 16:44:07'),
(605, 'علبه', 0, 0, 446, '2025-12-09 16:45:18', '2025-12-09 16:45:18'),
(606, 'علبه', 0, 0, 447, '2025-12-09 16:50:46', '2025-12-09 16:50:46'),
(607, 'علبه', 0, 0, 448, '2025-12-09 16:52:27', '2025-12-09 16:52:27'),
(608, 'علبه', 0, 0, 449, '2025-12-09 16:53:24', '2025-12-09 16:53:24'),
(609, 'نظاره', 0, 0, 450, '2025-12-09 17:16:13', '2025-12-09 17:16:13'),
(610, 'نظاره', 0, 0, 451, '2025-12-09 17:17:15', '2025-12-09 17:17:15'),
(611, 'نظاره', 0, 0, 452, '2025-12-09 17:17:57', '2025-12-09 17:17:57'),
(612, 'نظاره', 0, 0, 453, '2025-12-09 17:18:54', '2025-12-09 17:18:54'),
(613, 'نظاره', 0, 0, 454, '2025-12-09 17:19:44', '2025-12-09 17:19:44'),
(614, 'نظاره', 0, 0, 455, '2025-12-09 17:20:22', '2025-12-09 17:20:22'),
(615, 'نظاره', 0, 0, 456, '2025-12-09 17:21:02', '2025-12-09 17:21:02'),
(616, 'نظاره', 0, 0, 457, '2025-12-09 17:21:50', '2025-12-09 17:21:50'),
(617, 'نظاره', 0, 0, 458, '2025-12-09 17:22:26', '2025-12-09 17:22:26'),
(618, 'نظاره', 0, 0, 459, '2025-12-09 17:23:07', '2025-12-09 17:23:07'),
(619, 'نظاره', 0, 0, 460, '2025-12-09 17:23:47', '2025-12-09 17:23:47'),
(620, 'نظاره', 0, 0, 461, '2025-12-09 17:24:35', '2025-12-09 17:24:35'),
(621, 'نظاره', 0, 0, 462, '2025-12-09 17:25:08', '2025-12-09 17:25:08'),
(622, 'علبه', 0, 0, 463, '2025-12-09 17:25:58', '2025-12-09 17:25:58'),
(623, 'علبه', 0, 0, 464, '2025-12-10 15:37:48', '2025-12-10 15:37:48'),
(624, 'علبه', 0, 0, 465, '2025-12-10 15:38:42', '2025-12-10 15:38:42'),
(625, 'علبه', 0, 0, 466, '2025-12-10 15:39:48', '2025-12-10 15:39:48'),
(626, 'علبه', 0, 0, 467, '2025-12-10 15:42:20', '2025-12-10 15:42:20'),
(627, 'علبه', 0, 0, 468, '2025-12-10 15:43:26', '2025-12-10 15:43:26'),
(628, 'علبه', 0, 0, 469, '2025-12-10 15:44:30', '2025-12-10 15:44:30'),
(629, 'علبه', 0, 0, 470, '2025-12-10 15:45:29', '2025-12-10 15:45:29'),
(630, 'علبه', 0, 0, 471, '2025-12-10 15:46:45', '2025-12-10 15:46:45'),
(631, 'علبه', 0, 0, 472, '2025-12-10 15:47:37', '2025-12-10 15:47:37'),
(632, 'علبه', 0, 0, 473, '2025-12-10 15:48:42', '2025-12-10 15:48:42'),
(633, 'علبه', 0, 0, 474, '2025-12-10 15:49:33', '2025-12-10 15:49:33'),
(634, 'علبه', 0, 0, 475, '2025-12-10 15:50:27', '2025-12-10 15:50:27'),
(635, 'علبه', 0, 0, 476, '2025-12-10 15:58:49', '2025-12-10 15:58:49'),
(636, 'علبه', 0, 0, 477, '2025-12-10 16:00:46', '2025-12-10 16:00:46'),
(637, 'علبه', 0, 0, 478, '2025-12-10 16:02:51', '2025-12-10 16:02:51'),
(638, 'علبه', 0, 0, 479, '2025-12-10 16:04:06', '2025-12-10 16:04:06'),
(639, 'علبه', 0, 0, 480, '2025-12-10 16:05:15', '2025-12-10 16:05:15'),
(640, 'علبه', 0, 0, 481, '2025-12-10 16:05:54', '2025-12-10 16:05:54'),
(641, 'علبه', 0, 0, 482, '2025-12-10 16:06:45', '2025-12-10 16:06:45'),
(642, 'علبه', 0, 0, 483, '2025-12-10 16:07:44', '2025-12-10 16:07:44'),
(643, 'علبه', 0, 0, 484, '2025-12-10 16:08:39', '2025-12-10 16:08:39'),
(644, 'علبه', 0, 0, 485, '2025-12-10 16:09:33', '2025-12-10 16:09:33'),
(645, 'علبه', 0, 0, 486, '2025-12-10 16:10:47', '2025-12-10 16:10:47'),
(646, 'علبه', 0, 0, 487, '2025-12-10 16:11:50', '2025-12-10 16:11:50'),
(697, 'قطعة', 95, 0, 533, '2025-12-13 19:35:43', '2025-12-13 19:35:43'),
(698, 'طبق', 35, 0, 534, '2025-12-13 19:38:02', '2025-12-13 19:38:02'),
(699, 'طبق', 50, 0, 535, '2025-12-13 19:39:51', '2025-12-13 19:39:51'),
(700, 'طبق', 55, 0, 536, '2025-12-13 19:41:43', '2025-12-13 19:41:43'),
(701, 'طبق', 75, 0, 537, '2025-12-13 19:45:45', '2025-12-13 19:45:45'),
(702, 'طبق', 40, 0, 538, '2025-12-13 19:47:13', '2025-12-13 19:47:13'),
(703, 'طبق', 60, 0, 539, '2025-12-13 19:49:31', '2025-12-13 19:49:31'),
(704, 'طبق', 40, 0, 540, '2025-12-13 19:51:05', '2025-12-13 19:51:05'),
(705, 'طبق', 20, 0, 541, '2025-12-13 19:52:07', '2025-12-13 19:52:07'),
(706, 'طبق', 10, 0, 542, '2025-12-13 19:53:04', '2025-12-13 19:53:04'),
(707, 'طبق', 30, 0, 543, '2025-12-13 19:54:25', '2025-12-13 19:54:25'),
(708, 'طبق', 60, 0, 544, '2025-12-13 19:56:20', '2025-12-13 19:56:20'),
(709, 'طبق', 65, 0, 545, '2025-12-13 19:58:19', '2025-12-13 19:58:19'),
(710, 'طبق', 65, 0, 546, '2025-12-13 20:00:25', '2025-12-13 20:00:25'),
(711, 'طبق', 65, 0, 547, '2025-12-13 20:02:31', '2025-12-13 20:02:31'),
(712, 'طبق', 75, 0, 548, '2025-12-13 20:04:17', '2025-12-13 20:04:17'),
(713, 'طبق', 15, 0, 549, '2025-12-13 20:06:36', '2025-12-13 20:06:36'),
(714, 'طبق', 15, 0, 550, '2025-12-13 20:07:58', '2025-12-13 20:07:58'),
(715, 'طبق', 25, 0, 551, '2025-12-13 20:09:24', '2025-12-13 20:09:24'),
(716, 'قزازه', 10, 0, 552, '2025-12-13 20:12:35', '2025-12-13 20:12:35'),
(717, 'قزازه', 20, 0, 553, '2025-12-13 20:13:44', '2025-12-13 20:13:44'),
(718, 'قزازه', 20, 0, 554, '2025-12-13 20:15:26', '2025-12-13 20:15:26'),
(720, 'قطعه', 30, 0, 555, '2025-12-13 20:18:31', '2025-12-13 20:18:31'),
(721, 'اضافه قطعة', 65, 0, 556, '2025-12-13 20:19:25', '2025-12-13 20:19:25'),
(722, 'قطعة', 20, 0, 557, '2025-12-13 20:20:28', '2025-12-13 20:20:28'),
(723, 'قطعه', 40, 0, 558, '2025-12-13 20:21:35', '2025-12-13 20:21:35'),
(724, 'رغيف', 3, 0, 559, '2025-12-13 20:22:08', '2025-12-13 20:22:08'),
(727, 'سنجل', 125, 0, 298, '2025-12-13 22:31:37', '2025-12-13 22:31:37'),
(728, 'دبل', 195, 0, 298, '2025-12-13 22:31:37', '2025-12-13 22:31:37'),
(729, 'سنجل', 145, 0, 301, '2025-12-13 22:38:00', '2025-12-13 22:38:00'),
(730, 'دبل', 215, 0, 301, '2025-12-13 22:38:00', '2025-12-13 22:38:00'),
(731, 'سنجل', 125, 0, 312, '2025-12-13 23:00:28', '2025-12-13 23:00:28'),
(732, 'دبل', 160, 0, 312, '2025-12-13 23:00:28', '2025-12-13 23:00:28'),
(764, 'وجبة', 170, 0, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56'),
(765, 'حار', 170, 0, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56'),
(766, 'بارد', 170, 0, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56'),
(767, 'استربس فقط حار وصوص بارد', 170, 0, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56'),
(768, 'استربس فقط بارد وصوص حار', 170, 0, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56'),
(803, 'حار', 75, 0, 514, '2025-12-14 20:32:17', '2025-12-14 20:32:17'),
(811, 'بارد', 125, 0, 519, '2025-12-14 20:39:41', '2025-12-14 20:39:41'),
(812, 'حار', 115, 0, 520, '2025-12-14 20:40:16', '2025-12-14 20:40:16'),
(813, 'بارد', 115, 0, 520, '2025-12-14 20:40:16', '2025-12-14 20:40:16'),
(814, 'حار', 125, 0, 521, '2025-12-14 20:40:42', '2025-12-14 20:40:42'),
(815, 'بارد', 125, 0, 521, '2025-12-14 20:40:42', '2025-12-14 20:40:42'),
(816, 'حار', 125, 0, 522, '2025-12-14 20:41:05', '2025-12-14 20:41:05'),
(817, 'بارد', 125, 0, 522, '2025-12-14 20:41:05', '2025-12-14 20:41:05'),
(836, 'سندوتش بصوص حار', 105, 0, 531, '2025-12-14 20:48:20', '2025-12-14 20:48:20'),
(837, 'سندوتش بصوص بارد', 105, 0, 531, '2025-12-14 20:48:20', '2025-12-14 20:48:20'),
(838, 'استربس فقط حار مع صوص بارد', 105, 0, 532, '2025-12-14 20:49:27', '2025-12-14 20:49:27'),
(839, 'استربس فقط بارد مع صوص حار', 105, 0, 532, '2025-12-14 20:49:27', '2025-12-14 20:49:27'),
(845, 'سنجل', 100, 0, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02'),
(846, 'دبل', 135, 0, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02'),
(847, 'تربل', 175, 0, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02'),
(854, 'سنجل', 115, 0, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31'),
(855, 'دبل', 145, 0, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31'),
(856, 'تربل', 180, 0, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31'),
(857, 'سنجل', 125, 0, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00'),
(858, 'دبل', 160, 0, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00'),
(859, 'تربل', 195, 0, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00'),
(860, 'سنجل', 120, 0, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20'),
(861, 'دبل', 155, 0, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20'),
(862, 'تربل', 185, 0, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20'),
(863, 'سنجل', 155, 0, 302, '2025-12-15 13:30:46', '2025-12-15 13:30:46'),
(864, 'دبل', 225, 0, 302, '2025-12-15 13:30:46', '2025-12-15 13:30:46'),
(865, 'كبير', 65, 0, 320, '2025-12-15 15:12:01', '2025-12-15 15:12:01'),
(868, 'بالته 40 علبه', 1099.99, 0, 488, '2025-12-15 16:06:39', '2025-12-15 16:06:39'),
(870, 'بالته 40 علبه', 1099.99, 0, 489, '2025-12-15 16:08:44', '2025-12-15 16:08:44'),
(871, 'بالته 18 علبه', 509.99, 0, 560, '2025-12-15 16:13:03', '2025-12-15 16:13:03'),
(872, 'بالته 4 كيلو', 479.99, 0, 490, '2025-12-15 16:14:55', '2025-12-15 16:14:55'),
(873, 'بالته 5 كيلو', 599.99, 0, 490, '2025-12-15 16:14:55', '2025-12-15 16:14:55'),
(875, 'بالته 5 كيلو', 599.99, 0, 492, '2025-12-15 16:16:58', '2025-12-15 16:16:58'),
(876, '2000 منديل', 649.99, 0, 491, '2025-12-15 16:17:36', '2025-12-15 16:17:36'),
(877, 'بالته 18 علبه', 369.99, 0, 493, '2025-12-15 16:19:59', '2025-12-15 16:19:59'),
(878, 'بالته 24 علبه', 159.99, 0, 494, '2025-12-15 16:20:33', '2025-12-15 16:20:33'),
(880, 'بالته 18 علبه', 419.99, 0, 495, '2025-12-15 16:21:45', '2025-12-15 16:21:45'),
(881, 'ربع كيلو', 75, 0, 561, '2025-12-15 18:09:46', '2025-12-15 18:09:46'),
(882, 'ربع كيلو', 120, 0, 562, '2025-12-15 18:10:52', '2025-12-15 18:10:52'),
(883, 'ربع كيلو', 120, 0, 563, '2025-12-15 18:11:45', '2025-12-15 18:11:45'),
(884, 'ربع كيلو', 150, 0, 564, '2025-12-15 18:12:34', '2025-12-15 18:12:34'),
(885, 'نص كيلو', 120, 0, 565, '2025-12-15 18:13:48', '2025-12-15 18:13:48'),
(886, 'نص كيلو', 150, 0, 566, '2025-12-15 18:15:59', '2025-12-15 18:15:59'),
(887, 'نص كيلو', 180, 0, 567, '2025-12-15 18:17:33', '2025-12-15 18:17:33'),
(888, 'صغير', 80, 0, 568, '2025-12-15 18:20:02', '2025-12-15 18:20:02'),
(889, 'كبير', 100, 0, 568, '2025-12-15 18:20:02', '2025-12-15 18:20:02'),
(890, 'صغير', 60, 0, 569, '2025-12-15 18:29:52', '2025-12-15 18:29:52'),
(891, 'كبير', 80, 0, 569, '2025-12-15 18:29:52', '2025-12-15 18:29:52'),
(892, 'صغير', 100, 0, 570, '2025-12-15 18:33:20', '2025-12-15 18:33:20'),
(893, 'كبير', 150, 0, 570, '2025-12-15 18:33:20', '2025-12-15 18:33:20'),
(894, 'صغير', 100, 0, 571, '2025-12-15 18:36:13', '2025-12-15 18:36:13'),
(895, 'كبير', 150, 0, 571, '2025-12-15 18:36:13', '2025-12-15 18:36:13'),
(896, 'صغير', 160, 0, 572, '2025-12-15 18:41:03', '2025-12-15 18:41:03'),
(897, 'كبير', 220, 0, 572, '2025-12-15 18:41:03', '2025-12-15 18:41:03'),
(898, 'صغير', 100, 0, 573, '2025-12-15 18:42:28', '2025-12-15 18:42:28'),
(899, 'كبير', 150, 0, 573, '2025-12-15 18:42:28', '2025-12-15 18:42:28'),
(900, 'صغير', 300, 0, 574, '2025-12-15 18:44:47', '2025-12-15 18:44:47'),
(901, 'كبير', 400, 0, 574, '2025-12-15 18:44:47', '2025-12-15 18:44:47'),
(909, 'حار', 285, 0, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14'),
(910, 'بارد', 285, 0, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14'),
(911, 'ميكس', 285, 0, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14'),
(912, 'حار', 450, 0, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38'),
(913, 'بارد', 450, 0, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38'),
(914, 'ميكس', 450, 0, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38'),
(915, 'ساندوتش', 30, 0, 575, '2025-12-15 18:53:58', '2025-12-15 18:53:58'),
(916, 'حار', 590, 0, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15'),
(917, 'بارد', 590, 0, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15'),
(918, 'ميكس', 590, 0, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15'),
(919, 'حار', 810, 0, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42'),
(920, 'بارد', 810, 0, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42'),
(921, 'ميكس', 810, 0, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42'),
(922, 'ساندوتش', 30, 0, 576, '2025-12-15 18:55:19', '2025-12-15 18:55:19'),
(923, 'ساندوتش', 30, 0, 577, '2025-12-15 18:56:53', '2025-12-15 18:56:53'),
(924, 'حار', 320, 0, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58'),
(925, 'بارد', 320, 0, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58'),
(926, 'ميكس', 320, 0, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58'),
(930, 'ساندوتش', 40, 0, 578, '2025-12-15 18:58:05', '2025-12-15 18:58:05'),
(931, 'ساندوتش', 50, 0, 579, '2025-12-15 18:59:27', '2025-12-15 18:59:27'),
(932, 'ساندوتش', 50, 0, 580, '2025-12-15 19:00:28', '2025-12-15 19:00:28'),
(933, 'ساندوتش', 35, 0, 581, '2025-12-15 19:01:36', '2025-12-15 19:01:36'),
(934, 'حار', 150, 0, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58'),
(935, 'بارد', 150, 0, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58'),
(936, 'اجنحه بارد وصوص حار', 150, 0, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58'),
(937, 'اجنحه حار وصوص بارد', 150, 0, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58'),
(938, 'حار', 190, 0, 504, '2025-12-15 19:05:34', '2025-12-15 19:05:34'),
(939, 'بارد', 190, 0, 504, '2025-12-15 19:05:34', '2025-12-15 19:05:34'),
(940, 'بارد', 70, 0, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23'),
(941, 'استربس فقط حار مع صوص بارد', 70, 0, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23'),
(942, 'استربس فقط بارد مع صوص حار', 70, 0, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23'),
(943, 'بارد', 85, 0, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12'),
(944, 'استربس فقط حار مع صوص بارد', 85, 0, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12'),
(945, 'استربس فقط بارد مع صوص حار', 85, 0, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12'),
(946, 'حار', 85, 0, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12'),
(947, 'حار', 450, 0, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29'),
(948, 'بارد', 450, 0, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29'),
(949, 'ميكس', 450, 0, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29'),
(952, 'بارد', 195, 0, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34'),
(953, 'ميكس', 195, 0, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34'),
(954, 'حار', 195, 0, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34'),
(955, 'حار', 165, 0, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51'),
(956, 'ميكس', 165, 0, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51'),
(957, 'بارد', 165, 0, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51'),
(958, 'بارد', 105, 0, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59'),
(959, 'ميكس', 105, 0, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59'),
(960, 'حار', 105, 0, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59'),
(961, 'حار', 110, 0, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29'),
(962, 'بارد', 110, 0, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29'),
(963, 'ميكس', 110, 0, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29'),
(964, 'حار', 145, 0, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55'),
(965, 'بارد', 145, 0, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55'),
(966, 'ميكس', 145, 0, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55'),
(967, 'حار', 165, 0, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17'),
(968, 'بارد', 165, 0, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17'),
(969, 'ميكس', 165, 0, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17'),
(970, 'بارد', 70, 0, 513, '2025-12-15 19:30:06', '2025-12-15 19:30:06'),
(971, 'حار', 110, 0, 515, '2025-12-15 19:30:44', '2025-12-15 19:30:44'),
(972, 'بارد', 110, 0, 515, '2025-12-15 19:30:44', '2025-12-15 19:30:44'),
(973, 'حار', 110, 0, 516, '2025-12-15 19:32:22', '2025-12-15 19:32:22'),
(974, 'بارد', 110, 0, 516, '2025-12-15 19:32:22', '2025-12-15 19:32:22');
INSERT INTO `product_sizes` (`id`, `size`, `Purchase_price`, `selling_price`, `product_id`, `created_at`, `updated_at`) VALUES
(975, 'حار', 115, 0, 517, '2025-12-15 19:33:04', '2025-12-15 19:33:04'),
(976, 'بارد', 115, 0, 517, '2025-12-15 19:33:04', '2025-12-15 19:33:04'),
(977, 'حار', 125, 0, 518, '2025-12-15 19:35:09', '2025-12-15 19:35:09'),
(978, 'صوص بارد', 120, 0, 523, '2025-12-15 19:37:10', '2025-12-15 19:37:10'),
(979, 'صوص حار', 120, 0, 523, '2025-12-15 19:37:10', '2025-12-15 19:37:10'),
(980, 'صوص بارد', 125, 0, 524, '2025-12-15 19:39:25', '2025-12-15 19:39:25'),
(981, 'صوص حار', 125, 0, 524, '2025-12-15 19:39:25', '2025-12-15 19:39:25'),
(982, 'صوص بارد', 140, 0, 525, '2025-12-15 19:42:04', '2025-12-15 19:42:04'),
(983, 'صوص حار', 140, 0, 525, '2025-12-15 19:42:04', '2025-12-15 19:42:04'),
(984, 'صوص حار', 145, 0, 526, '2025-12-15 19:43:15', '2025-12-15 19:43:15'),
(985, 'صوص بارد', 145, 0, 526, '2025-12-15 19:43:15', '2025-12-15 19:43:15'),
(986, 'صوص حار', 155, 0, 527, '2025-12-15 19:47:23', '2025-12-15 19:47:23'),
(987, 'صوص بارد', 155, 0, 527, '2025-12-15 19:47:23', '2025-12-15 19:47:23'),
(988, 'صوص بارد', 160, 0, 528, '2025-12-15 19:48:17', '2025-12-15 19:48:17'),
(989, 'صوص حار', 160, 0, 528, '2025-12-15 19:48:17', '2025-12-15 19:48:17'),
(990, 'صوص حار', 145, 0, 529, '2025-12-15 19:49:43', '2025-12-15 19:49:43'),
(991, 'صوص بارد', 145, 0, 529, '2025-12-15 19:49:43', '2025-12-15 19:49:43'),
(992, 'صوص حار', 210, 0, 530, '2025-12-15 19:53:50', '2025-12-15 19:53:50'),
(993, 'صوص بارد', 210, 0, 530, '2025-12-15 19:53:50', '2025-12-15 19:53:50'),
(997, 'ربع كيلو', 160, 0, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46'),
(998, 'نص كيلو', 300, 0, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46'),
(999, 'كيلو', 600, 0, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46'),
(1000, 'ربع فرخة', 110, 0, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57'),
(1001, 'نص فرخة', 200, 0, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57'),
(1002, 'فرخة كاملة', 400, 0, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57'),
(1006, 'ربع كيلو', 115, 0, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04'),
(1007, 'نص كيلو', 225, 0, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04'),
(1008, 'كيلو', 450, 0, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04'),
(1009, 'ربع كيلو', 125, 0, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48'),
(1010, 'نص كيلو', 250, 0, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48'),
(1011, 'كيلو', 500, 0, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48'),
(1012, 'وسط', 70, 0, 331, '2025-12-16 16:56:24', '2025-12-16 16:56:24'),
(1016, 'كبير', 155, 0, 338, '2025-12-16 16:59:07', '2025-12-16 16:59:07'),
(1017, 'كبير', 170, 0, 340, '2025-12-16 16:59:39', '2025-12-16 16:59:39'),
(1018, 'كبير', 180, 0, 341, '2025-12-16 16:59:56', '2025-12-16 16:59:56'),
(1019, 'كبير', 70, 0, 342, '2025-12-16 17:00:16', '2025-12-16 17:00:16'),
(1021, 'وجبة', 200, 0, 352, '2025-12-16 17:05:52', '2025-12-16 17:05:52'),
(1022, 'وجبة', 250, 0, 353, '2025-12-16 17:06:35', '2025-12-16 17:06:35'),
(1024, 'وجبة', 300, 0, 354, '2025-12-16 17:07:14', '2025-12-16 17:07:14'),
(1025, 'طاجن', 120, 0, 582, '2025-12-24 13:30:27', '2025-12-24 13:30:27'),
(1026, 'طاجن', 250, 0, 583, '2025-12-24 13:31:51', '2025-12-24 13:31:51'),
(1027, 'طاجن', 250, 0, 584, '2025-12-24 13:33:20', '2025-12-24 13:33:20'),
(1028, 'طاجن', 275, 0, 585, '2025-12-24 13:35:28', '2025-12-24 13:35:28'),
(1029, 'طاجن', 250, 0, 586, '2025-12-24 13:37:39', '2025-12-24 13:37:39'),
(1030, 'طاجن', 70, 0, 587, '2025-12-24 13:38:54', '2025-12-24 13:38:54'),
(1031, 'طاجن', 250, 0, 588, '2025-12-24 13:40:47', '2025-12-24 13:40:47'),
(1033, 'طاجن', 80, 0, 589, '2025-12-24 13:42:03', '2025-12-24 13:42:03'),
(1034, 'طاجن', 350, 0, 590, '2025-12-24 13:45:21', '2025-12-24 13:45:21'),
(1035, 'طاجن', 300, 0, 591, '2025-12-24 13:46:58', '2025-12-24 13:46:58'),
(1036, 'طاجن', 275, 0, 592, '2025-12-24 13:50:04', '2025-12-24 13:50:04'),
(1037, 'طاجن', 250, 0, 593, '2025-12-24 13:51:47', '2025-12-24 13:51:47'),
(1053, 'ربع كيلو', 250, 0, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12'),
(1054, 'نص كيلو', 475, 0, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12'),
(1055, 'كيلو', 950, 0, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12'),
(1059, 'ربع كيلو', 225, 0, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47'),
(1060, 'نص كيلو', 450, 0, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47'),
(1061, 'كيلو', 900, 0, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47'),
(1068, 'ربع كيلو', 240, 0, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09'),
(1069, 'نص كيلو', 480, 0, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09'),
(1070, 'كيلو', 950, 0, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09'),
(1072, 'ربع كيلو', 230, 0, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49'),
(1073, 'نص كيلو', 460, 0, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49'),
(1074, 'كيلو', 920, 0, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49'),
(1075, 'ربع كيلو', 250, 0, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45'),
(1076, 'نص كيلو', 500, 0, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45'),
(1077, 'كيلو', 1000, 0, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45'),
(1081, 'ربع كيلو', 115, 0, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57'),
(1082, 'نص كيلو', 225, 0, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57'),
(1083, 'كيلو', 450, 0, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57'),
(1084, 'ربع كيلو', 115, 0, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03'),
(1085, 'نص كيلو', 225, 0, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03'),
(1086, 'كيلو', 450, 0, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03'),
(1088, 'وجبه', 450, 0, 607, '2025-12-24 14:48:42', '2025-12-24 14:48:42'),
(1089, 'وجبة', 350, 0, 606, '2025-12-24 14:48:52', '2025-12-24 14:48:52'),
(1090, 'طبق', 70, 0, 608, '2025-12-24 14:52:14', '2025-12-24 14:52:14'),
(1091, 'طبق', 50, 0, 609, '2025-12-24 14:54:37', '2025-12-24 14:54:37'),
(1092, 'طبق', 40, 0, 610, '2025-12-24 14:56:04', '2025-12-24 14:56:04'),
(1093, 'وجبة', 300, 0, 611, '2025-12-24 14:59:50', '2025-12-24 14:59:50'),
(1094, 'وجبة', 250, 0, 612, '2025-12-24 15:05:45', '2025-12-24 15:05:45'),
(1095, 'وجبة', 300, 0, 613, '2025-12-24 15:07:20', '2025-12-24 15:07:20'),
(1096, 'وجبة', 280, 0, 614, '2025-12-24 15:10:26', '2025-12-24 15:10:26'),
(1097, 'طبق', 70, 0, 615, '2025-12-24 15:11:56', '2025-12-24 15:11:56'),
(1098, 'طبق', 120, 0, 616, '2025-12-24 15:13:53', '2025-12-24 15:13:53'),
(1099, 'طبق', 80, 0, 617, '2025-12-24 15:15:01', '2025-12-24 15:15:01'),
(1100, 'وجبة ورك', 110, 0, 618, '2025-12-24 15:19:54', '2025-12-24 15:19:54'),
(1101, 'وجبة صدر', 125, 0, 618, '2025-12-24 15:19:54', '2025-12-24 15:19:54'),
(1102, 'وجبة', 130, 0, 619, '2025-12-24 15:21:20', '2025-12-24 15:21:20'),
(1103, 'وجبة', 150, 0, 620, '2025-12-24 15:24:00', '2025-12-24 15:24:00'),
(1104, 'وجبة', 130, 0, 621, '2025-12-24 15:28:07', '2025-12-24 15:28:07'),
(1109, 'طبق', 500, 0, 627, '2025-12-24 16:21:43', '2025-12-24 16:21:43'),
(1110, 'طبق', 200, 0, 628, '2025-12-24 16:24:24', '2025-12-24 16:24:24'),
(1111, 'طبق', 350, 0, 629, '2025-12-24 16:27:20', '2025-12-24 16:27:20'),
(1112, 'طبق', 75, 0, 630, '2025-12-24 16:30:03', '2025-12-24 16:30:03'),
(1113, 'طبق', 20, 0, 631, '2025-12-24 16:33:28', '2025-12-24 16:33:28'),
(1114, 'طبق', 125, 0, 632, '2025-12-24 16:37:01', '2025-12-24 16:37:01'),
(1115, 'طبق', 25, 0, 633, '2025-12-24 16:39:58', '2025-12-24 16:39:58'),
(1116, 'طبق', 50, 0, 634, '2025-12-24 16:42:39', '2025-12-24 16:42:39'),
(1118, 'طبق', 30, 0, 636, '2025-12-24 16:45:27', '2025-12-24 16:45:27'),
(1120, 'طبق', 35, 0, 635, '2025-12-24 16:45:41', '2025-12-24 16:45:41'),
(1121, 'طبق', 40, 0, 637, '2025-12-24 16:46:44', '2025-12-24 16:46:44'),
(1122, 'طبق', 15, 0, 638, '2025-12-24 16:47:40', '2025-12-24 16:47:40'),
(1123, 'ربع كيلو', 175, 0, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06'),
(1124, 'نص كيلو', 360, 0, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06'),
(1125, 'كيلو', 700, 0, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06'),
(1126, 'طبق', 15, 0, 639, '2025-12-24 16:49:13', '2025-12-24 16:49:13'),
(1127, 'طبق', 25, 0, 640, '2025-12-24 16:49:54', '2025-12-24 16:49:54'),
(1128, 'طبق', 15, 0, 641, '2025-12-24 16:50:41', '2025-12-24 16:50:41'),
(1129, 'طبق', 20, 0, 642, '2025-12-24 16:58:41', '2025-12-24 16:58:41'),
(1130, 'طبق', 10, 0, 643, '2025-12-24 16:59:49', '2025-12-24 16:59:49'),
(1131, 'صغير', 60, 0, 644, '2025-12-24 17:02:09', '2025-12-24 17:02:09'),
(1132, 'كبير', 80, 0, 644, '2025-12-24 17:02:09', '2025-12-24 17:02:09'),
(1133, 'صغير', 80, 0, 645, '2025-12-24 17:03:59', '2025-12-24 17:03:59'),
(1134, 'كبير', 100, 0, 645, '2025-12-24 17:03:59', '2025-12-24 17:03:59'),
(1135, 'كبير', 130, 0, 646, '2025-12-24 17:05:40', '2025-12-24 17:05:40'),
(1136, 'طبق', 200, 0, 647, '2025-12-24 17:08:59', '2025-12-24 17:08:59'),
(1137, 'طبق', 210, 0, 648, '2025-12-24 17:12:29', '2025-12-24 17:12:29'),
(1138, 'نص بطة', 250, 0, 649, '2025-12-24 17:14:47', '2025-12-24 17:14:47'),
(1139, 'طاجن', 150, 0, 650, '2025-12-24 17:16:30', '2025-12-24 17:16:30'),
(1140, 'طبق', 160, 0, 651, '2025-12-24 17:17:51', '2025-12-24 17:17:51'),
(1143, 'ساندوتش', 80, 0, 654, '2025-12-24 17:25:17', '2025-12-24 17:25:17'),
(1144, 'صغير', 10, 0, 655, '2025-12-24 17:26:44', '2025-12-24 17:26:44'),
(1145, 'كنز', 20, 0, 656, '2025-12-24 17:27:54', '2025-12-24 17:27:54'),
(1146, 'صغير', 30, 0, 657, '2025-12-24 17:28:48', '2025-12-24 17:28:48'),
(1147, 'كيلو', 380, 0, 658, '2025-12-24 18:12:33', '2025-12-24 18:12:33'),
(1150, 'كيلو', 400, 0, 661, '2025-12-24 18:16:08', '2025-12-24 18:16:08'),
(1151, 'كيلو', 400, 0, 662, '2025-12-24 18:17:11', '2025-12-24 18:17:11'),
(1152, 'كيلو', 380, 0, 663, '2025-12-24 18:18:17', '2025-12-24 18:18:17'),
(1153, 'كيلو', 420, 0, 664, '2025-12-24 18:19:22', '2025-12-24 18:19:22'),
(1154, 'كيلو', 400, 0, 665, '2025-12-24 18:20:36', '2025-12-24 18:20:36'),
(1155, 'كيلو', 420, 0, 666, '2025-12-24 18:21:52', '2025-12-24 18:21:52'),
(1156, 'كيلو', 420, 0, 667, '2025-12-24 18:22:55', '2025-12-24 18:22:55'),
(1157, 'كيلو', 400, 0, 668, '2025-12-24 18:23:51', '2025-12-24 18:23:51'),
(1158, 'كيلو', 400, 0, 669, '2025-12-24 18:25:06', '2025-12-24 18:25:06'),
(1159, 'كيلو', 400, 0, 670, '2025-12-24 18:26:15', '2025-12-24 18:26:15'),
(1160, 'كيلو', 400, 0, 671, '2025-12-24 18:27:21', '2025-12-24 18:27:21'),
(1162, 'كيلو', 300, 0, 673, '2025-12-24 18:30:27', '2025-12-24 18:30:27'),
(1163, 'كيلو', 380, 0, 674, '2025-12-24 18:32:02', '2025-12-24 18:32:02'),
(1164, 'كيلو', 360, 0, 675, '2025-12-24 18:35:23', '2025-12-24 18:35:23'),
(1165, 'كيلو', 400, 0, 676, '2025-12-24 18:36:30', '2025-12-24 18:36:30'),
(1166, 'كيلو', 440, 0, 677, '2025-12-24 18:37:30', '2025-12-24 18:37:30'),
(1167, 'كيلو', 420, 0, 678, '2025-12-24 18:38:41', '2025-12-24 18:38:41'),
(1170, 'كيلو', 380, 0, 681, '2025-12-24 18:44:35', '2025-12-24 18:44:35'),
(1171, 'كيلو', 360, 0, 682, '2025-12-24 18:46:04', '2025-12-24 18:46:04'),
(1172, 'كيلو', 150, 0, 683, '2025-12-24 18:47:18', '2025-12-24 18:47:18'),
(1173, 'كيلو', 150, 0, 684, '2025-12-24 18:48:45', '2025-12-24 18:48:45'),
(1174, 'كيلو', 420, 0, 685, '2025-12-24 18:49:47', '2025-12-24 18:49:47'),
(1175, 'كيلو', 390, 0, 686, '2025-12-24 18:51:53', '2025-12-24 18:51:53'),
(1176, 'كيلو', 450, 0, 687, '2025-12-24 18:52:46', '2025-12-24 18:52:46'),
(1177, 'كيلو', 450, 0, 688, '2025-12-24 18:54:18', '2025-12-24 18:54:18'),
(1178, 'كيلو', 550, 0, 689, '2025-12-24 18:55:36', '2025-12-24 18:55:36'),
(1179, 'كيلو', 600, 0, 690, '2025-12-24 18:56:41', '2025-12-24 18:56:41'),
(1180, 'كيلو', 330, 0, 691, '2025-12-24 18:57:46', '2025-12-24 18:57:46'),
(1181, 'كيلو', 300, 0, 692, '2025-12-24 18:58:40', '2025-12-24 18:58:40'),
(1182, 'كيلو', 350, 0, 693, '2025-12-24 18:59:36', '2025-12-24 18:59:36'),
(1183, 'كيلو', 350, 0, 694, '2025-12-24 19:00:44', '2025-12-24 19:00:44'),
(1184, 'كيلو', 400, 0, 695, '2025-12-24 19:01:41', '2025-12-24 19:01:41'),
(1186, 'كيلو', 450, 0, 697, '2025-12-24 19:04:46', '2025-12-24 19:04:46'),
(1187, 'كيلو', 380, 0, 698, '2025-12-24 19:06:02', '2025-12-24 19:06:02'),
(1188, 'كيلو', 150, 0, 699, '2025-12-24 19:06:56', '2025-12-24 19:06:56'),
(1189, 'كيلو', 200, 0, 700, '2025-12-24 19:08:13', '2025-12-24 19:08:13'),
(1190, 'كيلو', 250, 0, 701, '2025-12-24 19:09:06', '2025-12-24 19:09:06'),
(1191, 'كيلو', 250, 0, 702, '2025-12-24 19:09:25', '2025-12-24 19:09:25'),
(1192, 'مخ', 200, 0, 703, '2025-12-24 19:10:54', '2025-12-24 19:10:54'),
(1193, 'كيلو', 100, 0, 704, '2025-12-24 19:11:55', '2025-12-24 19:11:55'),
(1194, 'كيلو', 150, 0, 705, '2025-12-24 19:12:45', '2025-12-24 19:12:45'),
(1195, 'كيلو', 150, 0, 706, '2025-12-24 19:13:50', '2025-12-24 19:13:50'),
(1196, 'طحال', 200, 0, 707, '2025-12-24 19:14:49', '2025-12-24 19:14:49'),
(1197, 'مخاصي', 400, 0, 708, '2025-12-24 19:15:58', '2025-12-24 19:15:58'),
(1198, 'كارع', 300, 0, 710, '2025-12-24 19:18:17', '2025-12-24 19:18:17'),
(1199, 'كارع', 350, 0, 709, '2025-12-24 19:18:44', '2025-12-24 19:18:44'),
(1203, 'ربع كيلو', 250, 0, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56'),
(1204, 'نص كيلو', 475, 0, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56'),
(1205, 'كيلو', 950, 0, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56'),
(1212, 'ربع كيلو', 225, 0, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34'),
(1213, 'نص كيلو', 450, 0, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34'),
(1214, 'كيلو', 900, 0, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34'),
(1219, 'ربع كيلو', 240, 0, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28'),
(1220, 'نص كيلو', 480, 0, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28'),
(1221, 'كيلو', 950, 0, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28'),
(1222, 'ربع كيلو', 230, 0, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19'),
(1223, 'نص كيلو', 460, 0, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19'),
(1224, 'كيلو', 920, 0, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19'),
(1225, 'ربع كيلو', 250, 0, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25'),
(1226, 'نص كيلو', 500, 0, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25'),
(1227, 'كيلو', 1000, 0, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25'),
(1228, 'ربع كيلو', 250, 0, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38'),
(1229, 'نص كيلو', 500, 0, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38'),
(1230, 'كيلو', 1000, 0, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38'),
(1234, 'كيلو', 650, 0, 679, '2025-12-27 14:17:04', '2025-12-27 14:17:04'),
(1235, 'ربع كيلو', 115, 0, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50'),
(1236, 'نص كيلو', 225, 0, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50'),
(1237, 'كيلو', 450, 0, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50'),
(1238, 'ربع كيلو', 115, 0, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02'),
(1239, 'نص كيلو', 225, 0, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02'),
(1240, 'كيلو', 450, 0, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02'),
(1241, 'وجبة ورك', 110, 0, 724, '2025-12-27 14:48:05', '2025-12-27 14:48:05'),
(1242, 'وجبة صدر', 125, 0, 724, '2025-12-27 14:48:05', '2025-12-27 14:48:05'),
(1243, 'وجبة', 130, 0, 725, '2025-12-27 14:48:57', '2025-12-27 14:48:57'),
(1244, 'وجبة', 150, 0, 726, '2025-12-27 14:54:34', '2025-12-27 14:54:34'),
(1245, 'وجبة', 130, 0, 727, '2025-12-27 14:55:49', '2025-12-27 14:55:49'),
(1248, 'صغير', 35, 0, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59'),
(1249, 'كبير', 50, 0, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59'),
(1250, 'كبير بالجبنة', 60, 0, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59'),
(1251, 'طبق', 10, 0, 732, '2025-12-27 15:23:59', '2025-12-27 15:23:59'),
(1252, 'طبق', 10, 0, 733, '2025-12-27 15:24:54', '2025-12-27 15:24:54'),
(1253, 'طبق', 35, 0, 734, '2025-12-27 15:25:45', '2025-12-27 15:25:45'),
(1256, 'ساندوتش', 50, 0, 737, '2025-12-27 15:29:35', '2025-12-27 15:29:35'),
(1257, 'مياه', 10, 0, 738, '2025-12-27 15:31:27', '2025-12-27 15:31:27'),
(1258, 'كنز', 20, 0, 739, '2025-12-27 15:32:02', '2025-12-27 15:32:02'),
(1259, 'صغير', 60, 0, 740, '2025-12-27 15:33:05', '2025-12-27 15:33:05'),
(1260, 'كبير', 80, 0, 740, '2025-12-27 15:33:05', '2025-12-27 15:33:05'),
(1261, 'صغير', 70, 0, 741, '2025-12-27 15:34:26', '2025-12-27 15:34:26'),
(1262, 'كبير', 90, 0, 741, '2025-12-27 15:34:26', '2025-12-27 15:34:26'),
(1263, 'صغير', 80, 0, 742, '2025-12-27 15:35:13', '2025-12-27 15:35:13'),
(1264, 'كبير', 100, 0, 742, '2025-12-27 15:35:13', '2025-12-27 15:35:13'),
(1265, 'كبير', 130, 0, 743, '2025-12-27 15:37:23', '2025-12-27 15:37:23'),
(1266, 'صنية', 1400, 0, 729, '2025-12-27 15:51:49', '2025-12-27 15:51:49'),
(1267, 'صواني', 900, 0, 728, '2025-12-27 15:52:11', '2025-12-27 15:52:11'),
(1268, 'كيلو', 350, 0, 659, '2025-12-27 15:58:52', '2025-12-27 15:58:52'),
(1269, 'كيلو', 400, 0, 660, '2025-12-27 16:00:05', '2025-12-27 16:00:05'),
(1270, 'كيلو', 350, 0, 672, '2025-12-27 16:02:17', '2025-12-27 16:02:17'),
(1271, 'كيلو', 500, 0, 680, '2025-12-27 16:05:42', '2025-12-27 16:05:42'),
(1272, 'كيلو', 400, 0, 696, '2025-12-27 16:07:39', '2025-12-27 16:07:39'),
(1273, 'كيلو', 950, 0, 744, '2025-12-29 00:03:28', '2025-12-29 00:03:28'),
(1274, 'كيلو', 800, 0, 745, '2025-12-29 00:04:39', '2025-12-29 00:04:39'),
(1275, 'ربع كيلو', 225, 0, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49'),
(1276, 'نص كيلو', 425, 0, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49'),
(1277, 'كيلو', 850, 0, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49'),
(1278, 'ربع كيلو', 175, 0, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48'),
(1279, 'نص كيلو', 350, 0, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48'),
(1280, 'كيلو', 700, 0, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48'),
(1281, 'ربع كيلو', 150, 0, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28'),
(1282, 'نص كيلو', 300, 0, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28'),
(1283, 'كيلو', 600, 0, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28'),
(1284, 'ربع فرخة', 110, 0, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55'),
(1285, 'نص فرخة', 175, 0, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55'),
(1286, 'فرخة كاملة', 350, 0, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55'),
(1287, 'ربع فرخة ورك', 110, 0, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20'),
(1288, 'ربع فرخة صدر', 125, 0, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20'),
(1289, 'نص فرخة', 175, 0, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20'),
(1290, 'فرخة كاملة', 350, 0, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20'),
(1291, 'ساندوتش', 70, 0, 735, '2025-12-29 00:11:47', '2025-12-29 00:11:47'),
(1292, 'ساندوتش', 60, 0, 736, '2025-12-29 00:12:41', '2025-12-29 00:12:41'),
(1293, 'سندوتش', 50, 0, 746, '2025-12-29 00:14:57', '2025-12-29 00:14:57'),
(1294, 'سندوتش', 90, 0, 747, '2025-12-29 00:16:37', '2025-12-29 00:16:37'),
(1295, 'سندوتش', 60, 0, 748, '2025-12-29 00:18:09', '2025-12-29 00:18:09'),
(1296, 'سندوتش', 60, 0, 749, '2025-12-29 00:20:31', '2025-12-29 00:20:31'),
(1297, 'سندوتش', 80, 0, 750, '2025-12-29 00:21:51', '2025-12-29 00:21:51'),
(1298, 'سندوتش', 60, 0, 751, '2025-12-29 00:23:43', '2025-12-29 00:23:43'),
(1299, 'سندوتش', 50, 0, 752, '2025-12-29 00:24:46', '2025-12-29 00:24:46'),
(1301, 'كيلو', 100, 0, 754, '2025-12-29 00:28:35', '2025-12-29 00:28:35'),
(1302, 'البطه', 150, 0, 755, '2025-12-29 00:29:45', '2025-12-29 00:29:45'),
(1303, 'كيلو', 60, 0, 756, '2025-12-29 00:30:50', '2025-12-29 00:30:50'),
(1304, 'صنيه', 600, 0, 757, '2025-12-29 00:43:59', '2025-12-29 00:43:59'),
(1305, 'الفرخه', 80, 0, 753, '2025-12-29 13:10:53', '2025-12-29 13:10:53'),
(1306, 'ساندوتش', 70, 0, 652, '2025-12-29 19:39:02', '2025-12-29 19:39:02'),
(1307, 'ساندوتش', 60, 0, 653, '2025-12-29 19:39:51', '2025-12-29 19:39:51'),
(1308, 'ساندوتش', 50, 0, 758, '2025-12-29 19:41:58', '2025-12-29 19:41:58'),
(1309, 'ساندوتش', 50, 0, 759, '2025-12-29 19:42:57', '2025-12-29 19:42:57'),
(1310, 'ساندوتش', 90, 0, 760, '2025-12-29 19:44:14', '2025-12-29 19:44:14'),
(1311, 'ساندوتش', 60, 0, 761, '2025-12-29 19:46:08', '2025-12-29 19:46:08'),
(1312, 'ساندوتش', 60, 0, 762, '2025-12-29 19:47:56', '2025-12-29 19:47:56'),
(1313, 'ساندوتش', 80, 0, 763, '2025-12-29 19:50:03', '2025-12-29 19:50:03'),
(1315, 'ساندوتش', 50, 0, 765, '2025-12-29 19:52:38', '2025-12-29 19:52:38'),
(1316, 'ربع كيلو', 175, 0, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22'),
(1317, 'نص كيلو', 350, 0, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22'),
(1318, 'كيلو', 700, 0, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22'),
(1319, 'ربع كيلو', 150, 0, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10'),
(1320, 'نص كيلو', 300, 0, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10'),
(1321, 'كيلو', 600, 0, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10'),
(1322, 'ربع فرخة', 110, 0, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39'),
(1323, 'نص فرخة', 175, 0, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39'),
(1324, 'فرخة كاملة', 350, 0, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39'),
(1325, 'ربع فرخة ورك', 110, 0, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35'),
(1326, 'ربع فرخة صدر', 125, 0, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35'),
(1327, 'نص فرخة', 175, 0, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35'),
(1328, 'فرخة كاملة', 350, 0, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35'),
(1329, 'ربع كيلو', 225, 0, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23'),
(1330, 'نص كيلو', 425, 0, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23'),
(1331, 'كيلو', 850, 0, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23'),
(1332, 'كيلو', 950, 0, 766, '2025-12-29 20:10:18', '2025-12-29 20:10:18'),
(1333, 'كيلو', 800, 0, 767, '2025-12-29 20:11:39', '2025-12-29 20:11:39'),
(1336, 'صغير', 30, 0, 768, '2025-12-29 20:30:10', '2025-12-29 20:30:10'),
(1337, 'صغير', 30, 0, 769, '2025-12-29 20:41:08', '2025-12-29 20:41:08'),
(1346, 'كبير', 50, 0, 334, '2025-12-29 23:56:25', '2025-12-29 23:56:25'),
(1347, 'كبير', 80, 0, 770, '2025-12-29 23:57:12', '2025-12-29 23:57:12'),
(1351, 'كبير', 60, 0, 335, '2025-12-29 23:58:39', '2025-12-29 23:58:39'),
(1352, 'كبير', 45, 0, 336, '2025-12-29 23:58:58', '2025-12-29 23:58:58'),
(1353, 'كبير', 75, 0, 771, '2025-12-30 00:05:07', '2025-12-30 00:05:07'),
(1354, 'كبير', 75, 0, 330, '2025-12-30 15:01:40', '2025-12-30 15:01:40'),
(1355, 'كبير', 70, 0, 332, '2025-12-30 15:02:09', '2025-12-30 15:02:09'),
(1356, 'كبير', 70, 0, 333, '2025-12-30 15:03:32', '2025-12-30 15:03:32'),
(1357, 'ساندوتش', 60, 0, 764, '2025-12-30 20:07:34', '2025-12-30 20:07:34'),
(1358, 'صواني', 650, 0, 622, '2025-12-31 00:44:30', '2025-12-31 00:44:30'),
(1359, 'صنية', 1350, 0, 623, '2025-12-31 00:47:47', '2025-12-31 00:47:47'),
(1360, 'صنية', 2500, 0, 624, '2025-12-31 00:51:43', '2025-12-31 00:51:43'),
(1361, 'صنية', 5000, 0, 625, '2025-12-31 00:56:44', '2025-12-31 00:56:44'),
(1367, 'بيتزا', 50, 50, 776, '2026-05-10 02:40:22', '2026-05-10 02:40:22'),
(1368, 'صغير', 10, 20, 294, '2026-05-10 05:48:28', '2026-05-10 05:48:28'),
(1369, 'وسط', 15, 50, 294, '2026-05-10 05:48:28', '2026-05-10 05:48:28'),
(1370, 'كبير', 20, 4, 294, '2026-05-10 05:48:28', '2026-05-10 05:48:28'),
(1371, 'وسط', 50, 100, 777, '2026-05-10 06:04:39', '2026-05-10 06:04:39'),
(1372, 'متوسط', 30, 100, 777, '2026-05-10 06:04:39', '2026-05-10 06:04:39'),
(1373, 'كبير', 80, 100, 777, '2026-05-10 06:04:39', '2026-05-10 06:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoices`
--

CREATE TABLE `purchase_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('paid','partial','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_items`
--

CREATE TABLE `purchase_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `po_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `po_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `status` enum('draft','sent','partial_received','received','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `subtotal` decimal(14,3) NOT NULL DEFAULT 0.000,
  `discount` decimal(14,3) NOT NULL DEFAULT 0.000,
  `tax` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `user_id`, `supplier_id`, `purchase_request_id`, `po_number`, `po_date`, `expected_date`, `status`, `subtotal`, `discount`, `tax`, `total`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, NULL, 'PO-20260418235707', '2026-04-18', '2026-04-20', 'received', '999.000', '11.000', '1.000', '989.000', 'dddddddddddddddd', '2026-04-18 21:57:07', '2026-04-18 22:16:22', NULL),
(2, 71, 3, 1, 'PO-20260424122745', '2026-04-24', '2026-04-25', 'draft', '396.000', '5.000', '5.000', '396.000', 'dddddddd', '2026-04-24 09:27:45', '2026-04-24 09:27:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(14,3) NOT NULL,
  `received_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `unit_price` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `raw_material_id`, `unit_id`, `quantity`, `received_quantity`, `unit_price`, `total`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '3.000', '3.000', '333.000', '999.000', 'jjjjjjjjjjj', '2026-04-18 21:57:07', '2026-04-18 22:16:22'),
(2, 2, 3, 1, '6.000', '0.000', '66.000', '396.000', 'welcome', '2026-04-24 09:27:46', '2026-04-24 09:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` date NOT NULL,
  `status` enum('draft','pending','approved','rejected','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_requests`
--

INSERT INTO `purchase_requests` (`id`, `user_id`, `request_number`, `request_date`, `status`, `notes`, `approved_by`, `approved_at`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 'PR-20260418235431', '2026-04-18', 'approved', 'uuuuuuuuuuuuuuuu', 71, '2026-04-18 22:04:09', '2026-04-20 21:54:31', '2026-04-18 22:04:09', NULL),
(2, 71, 'PR-20260420073600', '2026-04-20', 'draft', 'aaaaaaaaaa', NULL, NULL, '2026-04-20 05:36:00', '2026-04-20 05:36:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request_items`
--

CREATE TABLE `purchase_request_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_quantity` decimal(14,3) NOT NULL,
  `approved_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_request_items`
--

INSERT INTO `purchase_request_items` (`id`, `purchase_request_id`, `raw_material_id`, `unit_id`, `requested_quantity`, `approved_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '1.000', '1.000', 'jjjjjjjjjjj', '2026-04-18 21:54:31', '2026-04-18 22:04:09'),
(2, 2, 2, 1, '22.000', '0.000', 'welcome', '2026-04-20 05:36:00', '2026-04-20 05:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `default_supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` decimal(14,3) NOT NULL DEFAULT 0.000,
  `avg_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `last_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `reorder_level` decimal(14,3) DEFAULT NULL,
  `min_quantity` decimal(14,3) DEFAULT NULL,
  `max_quantity` decimal(14,3) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_produced` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `user_id`, `inventory_category_id`, `default_supplier_id`, `purchase_unit_id`, `name`, `sku`, `barcode`, `description`, `purchase_price`, `avg_cost`, `last_cost`, `reorder_level`, `min_quantity`, `max_quantity`, `is_active`, `is_produced`, `created_at`, `updated_at`) VALUES
(1, 71, 1, 1, 1, 'agent', '123', '1111', 'ffffffffffffffffffffffffffff', '333.000', '333.000', '333.000', '5.000', '55.000', '53.000', 1, 1, '2026-04-18 21:07:03', '2026-04-19 21:45:25'),
(2, 71, 2, 1, 1, 'meat', '123', '1245', 'gggggggggggggggg', '77.000', '50.000', '50.000', '10.000', '10.000', '10.000', 1, 1, '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 71, 2, 2, 1, 'aaa', '111', '11111111', 'ccccccccccccccccccccc', '55.000', '66.000', '222.000', '2.000', '2.000', '2.000', 1, 1, '2026-04-24 09:21:48', '2026-04-24 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `output_raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yield_quantity` decimal(14,3) NOT NULL DEFAULT 1.000,
  `yield_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `output_raw_material_id`, `name`, `yield_quantity`, `yield_unit_id`, `notes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 71, 1, 'agent', '15.000', 1, 'Welcome', 1, '2026-04-19 21:45:25', '2026-04-19 21:45:25'),
(2, 71, 2, 'meat', '1.000', 1, 'aaaaaaaaaaa', 1, '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 71, 3, 'aaa', '1.000', 1, 'Welcome', 1, '2026-04-24 09:21:48', '2026-04-24 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_items`
--

CREATE TABLE `recipe_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(14,3) NOT NULL,
  `waste_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_items`
--

INSERT INTO `recipe_items` (`id`, `recipe_id`, `raw_material_id`, `unit_id`, `quantity`, `waste_percent`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '10.000', '3.00', 'Hello', '2026-04-19 21:45:25', '2026-04-19 21:45:25'),
(2, 2, 1, 1, '3.000', '1.00', 'Hello', '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 3, 1, 1, '22.000', '5.00', 'Hello', '2026-04-24 09:21:48', '2026-04-24 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `created_by`) VALUES
(2, 'agent', 'web', '2026-04-14 20:25:56', '2026-04-14 20:25:56', 71),
(3, 'qqq', 'web', '2026-04-14 20:40:22', '2026-04-14 20:40:22', 71),
(4, 'كشير', 'web', '2026-04-25 14:13:15', '2026-04-25 14:13:15', 71);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `ID` int(22) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `Days` int(22) NOT NULL,
  `Main Hours` int(11) NOT NULL,
  `per Days` int(11) NOT NULL,
  `Active Hour` int(22) NOT NULL,
  `In Day` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(2, '📲 QR منيو نانو – الحل العصري لكل أنواع المحلات 🚀', 'لو عندك مطعم – سوبر ماركت – كافيه – محل ملابس – أو أي نشاط تجاري\r\nدلوقتي تقدر تعرض منتجاتك بشكل احترافي وسهل لعملاءك من خلال QR منيو نانو 🛒✨\r\n\r\n✅ المميزات:\r\n\r\n1️⃣ عدد لا نهائي من المنتجات\r\n2️⃣ تحكم كامل في الألوان والشكل بما يناسب هويتك التجارية\r\n3️⃣ تعديل الأسعار وإضافة أصناف جديدة بسهولة\r\n4️⃣ إمكانية إضافة أكثر من حجم وسعر للمنتج\r\n5️⃣ تصنيفات منظمة لتسهيل تصفح العملاء\r\n6️⃣ سهولة الشراء أونلاين من خلال الموقع\r\n7️⃣ إمكانية عرض إعلانات وعروض خاصة داخل المنيو\r\n8️⃣ لوحة تحكم متكاملة لإدارة الطلبات والمنتجات\r\n9️⃣ ربط حسابات السوشيال ميديا بسهولة\r\n🔟 فرصتك للظهور على محركات البحث جوجل\r\n1️⃣1️⃣ خدمة عملاء + تحديثات مستمرة\r\n1️⃣2️⃣ إضافة رقم واتساب ورقم اتصال لسهولة التواصل مع العملاء', 'sections/zIQc0MlzYnsIYvW9tEwvdDdUpQiWbGWUGzXe9ZLq.png', '2025-08-31 11:44:51', '2025-12-01 12:11:28'),
(3, 'احصائيات لمتابعة النمو', 'تابع نمو عملك مع منيو رقمي. احصل على احصائيات دقيقة حول عدد الزوار، والطلبات، وأكثر من ذلك. كل ذلك من خلال لوحة تحكم سهلة الاستخدام.', 'sections/336NXBAR34Eyc9Kv6GNE4p6NBEORAVxbj0TLzOJx.png', '2025-08-31 11:45:41', '2025-12-01 12:11:14'),
(4, 'تحكم بشكل ظهورك', 'خصص الهوية البصرية من خلال تغيير الألوان، والشعار، والغلاف، وقم بالربط مع وسائل التواصل الاجتماعي المختلفة. يمكنك الغلاف من عرض صور لمنتج جديد أو دعم حملة تخفيضات معينة، وابتكر الطرق المناسبة لك للعرض. كما يمكنك تخصيص عرض المنيو بلغات مختلفة مثل العربية، الإنجليزية والتركية.', 'sections/nvICNr10rL2RTz0dEhMLC5s9eTWHWo6eui6y0Gq5.png', '2025-08-31 11:46:29', '2025-12-01 12:10:15'),
(5, 'Qr كود ورابط مخصص', 'احصل على الرمز المخصص لتتمكن من وضعه على طاولات مطعمك او بجانب الكاشير، وامتلك رابطك المخصص لتسهل الوصول لعملائك اثناء طلبهم من منصات التواصل الاجتماعي المختلفة.', 'sections/Zzg6pvGnzSsQXClI1otV8cs1RZENXZMkpqnZqB3Y.png', '2025-08-31 11:47:21', '2025-12-01 12:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('eJzGxWbRRSZyqh5QZOQXcGFQWcK8mqAv5T6OU6zh', 71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUVZFbDNoa3A0VXhBb2lXNTNNYklJRTg0cXpLMlpNbDhWSDhrS2t1YiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdXJjaGFzZXMvY3JlYXRlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NzE7czo1OiJhbGVydCI7YTowOnt9fQ==', 1778405446),
('EyHe84DqqLzYnoFL2FuBDcOGVoTHFdqp4QNOMt9S', 71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWHZTd01CYTlOVGw1aFdraUpTb1ZlVFkwRU1kQ25WWUhLam5IenRZTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdXJjaGFzZXMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NzE7fQ==', 1778413124),
('kFh6hi7xuH2edatG5m0zeUs0JcLEILujsMa57OZh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEZKZmtsQ2JoQ3JLSEdNaFBaRVZSUDNPVGx4bHR3WDFpeG5LTkdvZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778412732);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(35, 6, 'logo', 'http://127.0.0.1:8000/storage/images/setting/1756206870.jpg', '2025-08-26 08:13:42', '2025-08-26 08:14:30'),
(36, 6, 'name', 'wow', '2025-08-26 08:13:42', '2025-08-26 08:14:41'),
(37, 6, 'description', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(38, 6, 'phone', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(39, 6, 'whatsapp', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(40, 6, 'address', 'mansoura, torail', '2025-08-26 08:13:42', '2025-08-26 08:28:45'),
(41, 6, 'theme', '2', '2025-08-26 08:13:42', '2025-08-26 09:52:05'),
(42, 6, 'status', '1', '2025-08-26 08:13:42', '2025-08-26 09:51:05'),
(43, 6, 'facebook', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(44, 6, 'instagram', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(45, 6, 'copyright', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(46, 6, 'maincolor', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(47, 6, 'curency', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(48, 6, 'secondcolor', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(49, 6, 'maintextcolor', '#bc2929', '2025-08-26 08:13:42', '2025-08-26 08:14:51'),
(50, 6, 'secoundtextcolor', '#7daa89', '2025-08-26 08:13:42', '2025-08-26 09:50:43'),
(51, 6, 'thirdtextcolor', NULL, '2025-08-26 08:13:42', '2025-08-26 08:13:42'),
(52, 7, 'logo', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(53, 7, 'name', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(54, 7, 'description', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(55, 7, 'phone', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(56, 7, 'whatsapp', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(57, 7, 'address', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(58, 7, 'theme', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(59, 7, 'status', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(60, 7, 'facebook', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(61, 7, 'instagram', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(62, 7, 'copyright', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(63, 7, 'maincolor', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(64, 7, 'curency', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(65, 7, 'secondcolor', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(66, 7, 'maintextcolor', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(67, 7, 'secoundtextcolor', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(68, 7, 'thirdtextcolor', NULL, '2025-08-27 06:00:54', '2025-08-27 06:00:54'),
(69, 8, 'logo', 'images/setting/w2Wvy0ygo1JB1QHFIHjsquOPUQqfLVCpM8DNZ3zk.png', '2025-08-27 06:03:18', '2025-08-31 08:29:31'),
(70, 8, 'name', 'test', '2025-08-27 06:03:18', '2025-08-31 08:29:45'),
(71, 8, 'description', 'testtt', '2025-08-27 06:03:18', '2025-08-31 08:29:54'),
(72, 8, 'phone', '01012521797', '2025-08-27 06:03:18', '2025-08-31 08:30:11'),
(73, 8, 'whatsapp', '01012521797', '2025-08-27 06:03:18', '2025-08-31 08:30:21'),
(74, 8, 'address', 'cairo,6th of octoper', '2025-08-27 06:03:18', '2025-08-31 08:30:50'),
(75, 8, 'theme', '2', '2025-08-27 06:03:18', '2025-08-31 08:30:58'),
(76, 8, 'status', '1', '2025-08-27 06:03:18', '2025-08-31 08:31:07'),
(77, 8, 'facebook', 'https://meet.google.com/wvw-bxqx-yom', '2025-08-27 06:03:18', '2025-08-31 08:31:29'),
(78, 8, 'instagram', 'https://meet.google.com/wvw-bxqx-yom', '2025-08-27 06:03:18', '2025-08-31 08:31:37'),
(79, 8, 'copyright', 'amr', '2025-08-27 06:03:18', '2025-08-31 08:31:45'),
(80, 8, 'maincolor', '#ca3f3f', '2025-08-27 06:03:18', '2025-08-31 08:31:52'),
(81, 8, 'curency', 'جنيه', '2025-08-27 06:03:18', '2025-08-31 08:32:02'),
(82, 8, 'secondcolor', NULL, '2025-08-27 06:03:18', '2025-08-27 06:03:18'),
(83, 8, 'maintextcolor', '#e7d0d0', '2025-08-27 06:03:18', '2025-08-31 08:32:16'),
(84, 8, 'secoundtextcolor', NULL, '2025-08-27 06:03:18', '2025-08-27 06:03:18'),
(85, 8, 'thirdtextcolor', NULL, '2025-08-27 06:03:18', '2025-08-27 06:03:18'),
(86, 9, 'logo', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(87, 9, 'name', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(88, 9, 'description', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(89, 9, 'phone', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(90, 9, 'whatsapp', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(91, 9, 'address', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(92, 9, 'theme', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(93, 9, 'status', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(94, 9, 'facebook', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(95, 9, 'instagram', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(96, 9, 'copyright', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(97, 9, 'maincolor', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(98, 9, 'curency', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(99, 9, 'secondcolor', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(100, 9, 'maintextcolor', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(101, 9, 'secoundtextcolor', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(102, 9, 'thirdtextcolor', NULL, '2025-08-27 12:51:04', '2025-08-27 12:51:04'),
(103, 10, 'logo', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(104, 10, 'name', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(105, 10, 'description', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(106, 10, 'phone', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(107, 10, 'whatsapp', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(108, 10, 'address', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(109, 10, 'theme', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(110, 10, 'status', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(111, 10, 'facebook', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(112, 10, 'instagram', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(113, 10, 'copyright', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(114, 10, 'maincolor', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(115, 10, 'curency', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(116, 10, 'secondcolor', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(117, 10, 'maintextcolor', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(118, 10, 'secoundtextcolor', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(119, 10, 'thirdtextcolor', NULL, '2025-08-27 14:11:36', '2025-08-27 14:11:36'),
(120, 11, 'logo', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(121, 11, 'name', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(122, 11, 'description', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(123, 11, 'phone', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(124, 11, 'whatsapp', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(125, 11, 'address', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(126, 11, 'theme', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(127, 11, 'status', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(128, 11, 'facebook', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(129, 11, 'instagram', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(130, 11, 'copyright', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(131, 11, 'maincolor', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(132, 11, 'curency', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(133, 11, 'secondcolor', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(134, 11, 'maintextcolor', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(135, 11, 'secoundtextcolor', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(136, 11, 'thirdtextcolor', NULL, '2025-08-27 14:21:01', '2025-08-27 14:21:01'),
(137, 12, 'logo', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(138, 12, 'name', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(139, 12, 'description', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(140, 12, 'phone', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(141, 12, 'whatsapp', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(142, 12, 'address', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(143, 12, 'theme', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(144, 12, 'status', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(145, 12, 'facebook', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(146, 12, 'instagram', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(147, 12, 'copyright', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(148, 12, 'maincolor', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(149, 12, 'curency', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(150, 12, 'secondcolor', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(151, 12, 'maintextcolor', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(152, 12, 'secoundtextcolor', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(153, 12, 'thirdtextcolor', NULL, '2025-08-28 11:21:57', '2025-08-28 11:21:57'),
(154, 13, 'logo', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(155, 13, 'name', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(156, 13, 'description', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(157, 13, 'phone', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(158, 13, 'whatsapp', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(159, 13, 'address', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(160, 13, 'theme', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(161, 13, 'status', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(162, 13, 'facebook', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(163, 13, 'instagram', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(164, 13, 'copyright', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(165, 13, 'maincolor', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(166, 13, 'curency', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(167, 13, 'secondcolor', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(168, 13, 'maintextcolor', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(169, 13, 'secoundtextcolor', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(170, 13, 'thirdtextcolor', NULL, '2025-08-28 12:53:23', '2025-08-28 12:53:23'),
(171, 14, 'logo', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(172, 14, 'name', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(173, 14, 'description', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(174, 14, 'phone', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(175, 14, 'whatsapp', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(176, 14, 'address', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(177, 14, 'theme', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(178, 14, 'status', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(179, 14, 'facebook', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(180, 14, 'instagram', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(181, 14, 'copyright', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(182, 14, 'maincolor', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(183, 14, 'curency', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(184, 14, 'secondcolor', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(185, 14, 'maintextcolor', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(186, 14, 'secoundtextcolor', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(187, 14, 'thirdtextcolor', NULL, '2025-08-28 12:54:45', '2025-08-28 12:54:45'),
(188, 15, 'logo', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(189, 15, 'name', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(190, 15, 'description', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(191, 15, 'phone', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(192, 15, 'whatsapp', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(193, 15, 'address', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(194, 15, 'theme', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(195, 15, 'status', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(196, 15, 'facebook', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(197, 15, 'instagram', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(198, 15, 'copyright', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(199, 15, 'maincolor', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(200, 15, 'curency', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(201, 15, 'secondcolor', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(202, 15, 'maintextcolor', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(203, 15, 'secoundtextcolor', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(204, 15, 'thirdtextcolor', NULL, '2025-08-28 13:42:23', '2025-08-28 13:42:23'),
(205, 16, 'logo', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(206, 16, 'name', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(207, 16, 'description', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(208, 16, 'phone', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(209, 16, 'whatsapp', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(210, 16, 'address', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(211, 16, 'theme', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(212, 16, 'status', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(213, 16, 'facebook', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(214, 16, 'instagram', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(215, 16, 'copyright', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(216, 16, 'maincolor', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(217, 16, 'curency', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(218, 16, 'secondcolor', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(219, 16, 'maintextcolor', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(220, 16, 'secoundtextcolor', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(221, 16, 'thirdtextcolor', NULL, '2025-08-30 08:28:53', '2025-08-30 08:28:53'),
(222, 17, 'logo', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(223, 17, 'name', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(224, 17, 'description', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(225, 17, 'phone', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(226, 17, 'whatsapp', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(227, 17, 'address', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(228, 17, 'theme', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(229, 17, 'status', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(230, 17, 'facebook', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(231, 17, 'instagram', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(232, 17, 'copyright', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(233, 17, 'maincolor', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(234, 17, 'curency', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(235, 17, 'secondcolor', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(236, 17, 'maintextcolor', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(237, 17, 'secoundtextcolor', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(238, 17, 'thirdtextcolor', NULL, '2025-08-30 09:54:49', '2025-08-30 09:54:49'),
(239, 18, 'logo', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(240, 18, 'name', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(241, 18, 'description', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(242, 18, 'phone', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(243, 18, 'whatsapp', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(244, 18, 'address', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(245, 18, 'theme', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(246, 18, 'status', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(247, 18, 'facebook', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(248, 18, 'instagram', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(249, 18, 'copyright', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(250, 18, 'maincolor', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(251, 18, 'curency', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(252, 18, 'secondcolor', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(253, 18, 'maintextcolor', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(254, 18, 'secoundtextcolor', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(255, 18, 'thirdtextcolor', NULL, '2025-08-30 10:26:55', '2025-08-30 10:26:55'),
(256, 19, 'logo', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(257, 19, 'name', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(258, 19, 'description', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(259, 19, 'phone', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(260, 19, 'whatsapp', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(261, 19, 'address', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(262, 19, 'theme', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(263, 19, 'status', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(264, 19, 'facebook', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(265, 19, 'instagram', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(266, 19, 'copyright', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(267, 19, 'maincolor', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(268, 19, 'curency', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(269, 19, 'secondcolor', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(270, 19, 'maintextcolor', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(271, 19, 'secoundtextcolor', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(272, 19, 'thirdtextcolor', NULL, '2025-08-30 14:19:56', '2025-08-30 14:19:56'),
(273, 20, 'logo', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(274, 20, 'name', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(275, 20, 'description', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(276, 20, 'phone', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(277, 20, 'whatsapp', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(278, 20, 'address', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(279, 20, 'theme', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(280, 20, 'status', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(281, 20, 'facebook', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(282, 20, 'instagram', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(283, 20, 'copyright', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(284, 20, 'maincolor', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(285, 20, 'curency', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(286, 20, 'secondcolor', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(287, 20, 'maintextcolor', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(288, 20, 'secoundtextcolor', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(289, 20, 'thirdtextcolor', NULL, '2025-08-30 14:22:49', '2025-08-30 14:22:49'),
(290, 21, 'logo', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(291, 21, 'name', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(292, 21, 'description', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(293, 21, 'phone', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(294, 21, 'whatsapp', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(295, 21, 'address', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(296, 21, 'theme', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(297, 21, 'status', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(298, 21, 'facebook', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(299, 21, 'instagram', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(300, 21, 'copyright', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(301, 21, 'maincolor', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(302, 21, 'curency', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(303, 21, 'secondcolor', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(304, 21, 'maintextcolor', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(305, 21, 'secoundtextcolor', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(306, 21, 'thirdtextcolor', NULL, '2025-08-30 14:24:52', '2025-08-30 14:24:52'),
(307, 22, 'logo', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(308, 22, 'name', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(309, 22, 'description', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(310, 22, 'phone', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(311, 22, 'whatsapp', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(312, 22, 'address', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(313, 22, 'theme', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(314, 22, 'status', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(315, 22, 'facebook', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(316, 22, 'instagram', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(317, 22, 'copyright', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(318, 22, 'maincolor', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(319, 22, 'curency', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(320, 22, 'secondcolor', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(321, 22, 'maintextcolor', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(322, 22, 'secoundtextcolor', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(323, 22, 'thirdtextcolor', NULL, '2025-08-30 14:25:44', '2025-08-30 14:25:44'),
(324, 23, 'logo', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(325, 23, 'name', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(326, 23, 'description', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(327, 23, 'phone', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(328, 23, 'whatsapp', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(329, 23, 'address', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(330, 23, 'theme', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(331, 23, 'status', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(332, 23, 'facebook', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(333, 23, 'instagram', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(334, 23, 'copyright', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(335, 23, 'maincolor', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(336, 23, 'curency', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(337, 23, 'secondcolor', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(338, 23, 'maintextcolor', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(339, 23, 'secoundtextcolor', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(340, 23, 'thirdtextcolor', NULL, '2025-08-30 14:26:53', '2025-08-30 14:26:53'),
(341, 24, 'logo', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(342, 24, 'name', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(343, 24, 'description', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(344, 24, 'phone', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(345, 24, 'whatsapp', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(346, 24, 'address', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(347, 24, 'theme', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(348, 24, 'status', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(349, 24, 'facebook', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(350, 24, 'instagram', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(351, 24, 'copyright', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(352, 24, 'maincolor', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(353, 24, 'curency', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(354, 24, 'secondcolor', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(355, 24, 'maintextcolor', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(356, 24, 'secoundtextcolor', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(357, 24, 'thirdtextcolor', NULL, '2025-08-30 14:27:25', '2025-08-30 14:27:25'),
(358, 25, 'logo', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(359, 25, 'name', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(360, 25, 'description', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(361, 25, 'phone', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(362, 25, 'whatsapp', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(363, 25, 'address', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(364, 25, 'theme', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(365, 25, 'status', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(366, 25, 'facebook', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(367, 25, 'instagram', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(368, 25, 'copyright', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(369, 25, 'maincolor', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(370, 25, 'curency', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(371, 25, 'secondcolor', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(372, 25, 'maintextcolor', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(373, 25, 'secoundtextcolor', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(374, 25, 'thirdtextcolor', NULL, '2025-08-30 14:28:14', '2025-08-30 14:28:14'),
(375, 26, 'logo', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(376, 26, 'name', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(377, 26, 'description', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(378, 26, 'phone', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(379, 26, 'whatsapp', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(380, 26, 'address', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(381, 26, 'theme', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(382, 26, 'status', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(383, 26, 'facebook', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(384, 26, 'instagram', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(385, 26, 'copyright', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(386, 26, 'maincolor', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(387, 26, 'curency', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(388, 26, 'secondcolor', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(389, 26, 'maintextcolor', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(390, 26, 'secoundtextcolor', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(391, 26, 'thirdtextcolor', NULL, '2025-08-30 14:37:21', '2025-08-30 14:37:21'),
(392, 27, 'logo', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(393, 27, 'name', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(394, 27, 'description', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(395, 27, 'phone', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(396, 27, 'whatsapp', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(397, 27, 'address', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(398, 27, 'theme', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(399, 27, 'status', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(400, 27, 'facebook', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(401, 27, 'instagram', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(402, 27, 'copyright', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(403, 27, 'maincolor', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(404, 27, 'curency', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(405, 27, 'secondcolor', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(406, 27, 'maintextcolor', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(407, 27, 'secoundtextcolor', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(408, 27, 'thirdtextcolor', NULL, '2025-08-30 14:39:24', '2025-08-30 14:39:24'),
(409, 28, 'logo', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(410, 28, 'name', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(411, 28, 'description', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(412, 28, 'phone', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(413, 28, 'whatsapp', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(414, 28, 'address', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(415, 28, 'theme', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(416, 28, 'status', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(417, 28, 'facebook', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(418, 28, 'instagram', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(419, 28, 'copyright', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(420, 28, 'maincolor', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(421, 28, 'curency', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(422, 28, 'secondcolor', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(423, 28, 'maintextcolor', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(424, 28, 'secoundtextcolor', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(425, 28, 'thirdtextcolor', NULL, '2025-08-30 14:40:31', '2025-08-30 14:40:31'),
(426, 29, 'logo', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(427, 29, 'name', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(428, 29, 'description', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(429, 29, 'phone', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(430, 29, 'whatsapp', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(431, 29, 'address', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(432, 29, 'theme', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(433, 29, 'status', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(434, 29, 'facebook', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(435, 29, 'instagram', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(436, 29, 'copyright', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(437, 29, 'maincolor', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(438, 29, 'curency', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(439, 29, 'secondcolor', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(440, 29, 'maintextcolor', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(441, 29, 'secoundtextcolor', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(442, 29, 'thirdtextcolor', NULL, '2025-08-30 14:42:39', '2025-08-30 14:42:39'),
(443, 30, 'logo', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(444, 30, 'name', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(445, 30, 'description', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(446, 30, 'phone', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(447, 30, 'whatsapp', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(448, 30, 'address', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(449, 30, 'theme', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(450, 30, 'status', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(451, 30, 'facebook', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(452, 30, 'instagram', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(453, 30, 'copyright', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(454, 30, 'maincolor', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(455, 30, 'curency', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(456, 30, 'secondcolor', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(457, 30, 'maintextcolor', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(458, 30, 'secoundtextcolor', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(459, 30, 'thirdtextcolor', NULL, '2025-08-30 14:43:38', '2025-08-30 14:43:38'),
(460, 31, 'logo', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(461, 31, 'name', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(462, 31, 'description', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(463, 31, 'phone', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(464, 31, 'whatsapp', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(465, 31, 'address', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(466, 31, 'theme', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(467, 31, 'status', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(468, 31, 'facebook', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(469, 31, 'instagram', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(470, 31, 'copyright', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(471, 31, 'maincolor', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(472, 31, 'curency', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(473, 31, 'secondcolor', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(474, 31, 'maintextcolor', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(475, 31, 'secoundtextcolor', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(476, 31, 'thirdtextcolor', NULL, '2025-08-30 14:55:39', '2025-08-30 14:55:39'),
(477, 32, 'logo', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(478, 32, 'name', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(479, 32, 'description', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(480, 32, 'phone', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(481, 32, 'whatsapp', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(482, 32, 'address', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(483, 32, 'theme', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(484, 32, 'status', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(485, 32, 'facebook', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(486, 32, 'instagram', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(487, 32, 'copyright', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(488, 32, 'maincolor', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(489, 32, 'curency', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(490, 32, 'secondcolor', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(491, 32, 'maintextcolor', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(492, 32, 'secoundtextcolor', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(493, 32, 'thirdtextcolor', NULL, '2025-08-30 15:00:13', '2025-08-30 15:00:13'),
(494, 33, 'logo', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(495, 33, 'name', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(496, 33, 'description', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(497, 33, 'phone', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(498, 33, 'whatsapp', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(499, 33, 'address', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(500, 33, 'theme', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(501, 33, 'status', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(502, 33, 'facebook', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(503, 33, 'instagram', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(504, 33, 'copyright', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(505, 33, 'maincolor', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(506, 33, 'curency', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(507, 33, 'secondcolor', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(508, 33, 'maintextcolor', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(509, 33, 'secoundtextcolor', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(510, 33, 'thirdtextcolor', NULL, '2025-08-30 15:06:00', '2025-08-30 15:06:00'),
(511, 34, 'logo', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(512, 34, 'name', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(513, 34, 'description', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(514, 34, 'phone', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(515, 34, 'whatsapp', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(516, 34, 'address', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(517, 34, 'theme', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(518, 34, 'status', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(519, 34, 'facebook', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(520, 34, 'instagram', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(521, 34, 'copyright', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(522, 34, 'maincolor', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(523, 34, 'curency', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(524, 34, 'secondcolor', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(525, 34, 'maintextcolor', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(526, 34, 'secoundtextcolor', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(527, 34, 'thirdtextcolor', NULL, '2025-08-30 15:13:26', '2025-08-30 15:13:26'),
(528, 35, 'logo', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(529, 35, 'name', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(530, 35, 'description', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(531, 35, 'phone', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(532, 35, 'whatsapp', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(533, 35, 'address', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(534, 35, 'theme', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(535, 35, 'status', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(536, 35, 'facebook', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(537, 35, 'instagram', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(538, 35, 'copyright', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(539, 35, 'maincolor', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(540, 35, 'curency', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(541, 35, 'secondcolor', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(542, 35, 'maintextcolor', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(543, 35, 'secoundtextcolor', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(544, 35, 'thirdtextcolor', NULL, '2025-08-30 15:21:47', '2025-08-30 15:21:47'),
(545, 36, 'logo', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(546, 36, 'name', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(547, 36, 'description', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(548, 36, 'phone', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(549, 36, 'whatsapp', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(550, 36, 'address', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(551, 36, 'theme', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(552, 36, 'status', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(553, 36, 'facebook', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(554, 36, 'instagram', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(555, 36, 'copyright', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(556, 36, 'maincolor', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(557, 36, 'curency', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(558, 36, 'secondcolor', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(559, 36, 'maintextcolor', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(560, 36, 'secoundtextcolor', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(561, 36, 'thirdtextcolor', NULL, '2025-08-30 15:24:20', '2025-08-30 15:24:20'),
(562, 37, 'logo', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(563, 37, 'name', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(564, 37, 'description', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(565, 37, 'phone', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(566, 37, 'whatsapp', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(567, 37, 'address', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(568, 37, 'theme', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(569, 37, 'status', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(570, 37, 'facebook', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(571, 37, 'instagram', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(572, 37, 'copyright', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(573, 37, 'maincolor', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(574, 37, 'curency', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(575, 37, 'secondcolor', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(576, 37, 'maintextcolor', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(577, 37, 'secoundtextcolor', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(578, 37, 'thirdtextcolor', NULL, '2025-08-30 15:29:38', '2025-08-30 15:29:38'),
(579, 38, 'logo', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(580, 38, 'name', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(581, 38, 'description', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(582, 38, 'phone', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(583, 38, 'whatsapp', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(584, 38, 'address', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(585, 38, 'theme', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(586, 38, 'status', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(587, 38, 'facebook', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(588, 38, 'instagram', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(589, 38, 'copyright', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(590, 38, 'maincolor', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(591, 38, 'curency', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(592, 38, 'secondcolor', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(593, 38, 'maintextcolor', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(594, 38, 'secoundtextcolor', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(595, 38, 'thirdtextcolor', NULL, '2025-08-30 15:31:25', '2025-08-30 15:31:25'),
(596, 39, 'logo', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(597, 39, 'name', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(598, 39, 'description', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(599, 39, 'phone', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(600, 39, 'whatsapp', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(601, 39, 'address', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(602, 39, 'theme', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(603, 39, 'status', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(604, 39, 'facebook', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(605, 39, 'instagram', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(606, 39, 'copyright', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(607, 39, 'maincolor', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(608, 39, 'curency', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(609, 39, 'secondcolor', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(610, 39, 'maintextcolor', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(611, 39, 'secoundtextcolor', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(612, 39, 'thirdtextcolor', NULL, '2025-08-30 15:32:15', '2025-08-30 15:32:15'),
(630, 41, 'logo', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(631, 41, 'name', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(632, 41, 'description', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(633, 41, 'phone', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(634, 41, 'whatsapp', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(635, 41, 'address', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(636, 41, 'theme', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(637, 41, 'status', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(638, 41, 'facebook', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(639, 41, 'instagram', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(640, 41, 'copyright', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(641, 41, 'maincolor', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(642, 41, 'curency', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(643, 41, 'secondcolor', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(644, 41, 'maintextcolor', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(645, 41, 'secoundtextcolor', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(646, 41, 'thirdtextcolor', NULL, '2025-08-31 09:25:07', '2025-08-31 09:25:07'),
(647, 42, 'logo', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(648, 42, 'name', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(649, 42, 'description', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(650, 42, 'phone', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(651, 42, 'whatsapp', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(652, 42, 'address', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(653, 42, 'theme', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(654, 42, 'status', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(655, 42, 'facebook', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(656, 42, 'instagram', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(657, 42, 'copyright', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(658, 42, 'maincolor', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(659, 42, 'curency', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(660, 42, 'secondcolor', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(661, 42, 'maintextcolor', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(662, 42, 'secoundtextcolor', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(663, 42, 'thirdtextcolor', NULL, '2025-08-31 12:27:36', '2025-08-31 12:27:36'),
(664, 43, 'logo', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(665, 43, 'name', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(666, 43, 'description', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(667, 43, 'phone', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(668, 43, 'whatsapp', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(669, 43, 'address', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(670, 43, 'theme', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(671, 43, 'status', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(672, 43, 'facebook', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(673, 43, 'instagram', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(674, 43, 'copyright', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(675, 43, 'maincolor', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(676, 43, 'curency', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(677, 43, 'secondcolor', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(678, 43, 'maintextcolor', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(679, 43, 'secoundtextcolor', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(680, 43, 'thirdtextcolor', NULL, '2025-09-01 08:19:39', '2025-09-01 08:19:39'),
(681, 44, 'logo', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(682, 44, 'name', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(683, 44, 'description', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(684, 44, 'phone', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(685, 44, 'whatsapp', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(686, 44, 'address', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(687, 44, 'theme', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(688, 44, 'status', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(689, 44, 'facebook', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(690, 44, 'instagram', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(691, 44, 'copyright', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(692, 44, 'maincolor', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(693, 44, 'curency', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(694, 44, 'secondcolor', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(695, 44, 'maintextcolor', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(696, 44, 'secoundtextcolor', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(697, 44, 'thirdtextcolor', NULL, '2025-09-01 08:20:06', '2025-09-01 08:20:06'),
(698, 45, 'logo', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(699, 45, 'name', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(700, 45, 'description', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(701, 45, 'phone', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(702, 45, 'whatsapp', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(703, 45, 'address', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(704, 45, 'theme', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(705, 45, 'status', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(706, 45, 'facebook', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(707, 45, 'instagram', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(708, 45, 'copyright', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(709, 45, 'maincolor', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(710, 45, 'curency', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(711, 45, 'secondcolor', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(712, 45, 'maintextcolor', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(713, 45, 'secoundtextcolor', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(714, 45, 'thirdtextcolor', NULL, '2025-09-01 10:50:14', '2025-09-01 10:50:14'),
(715, 46, 'logo', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(716, 46, 'name', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(717, 46, 'description', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(718, 46, 'phone', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(719, 46, 'whatsapp', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(720, 46, 'address', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(721, 46, 'theme', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(722, 46, 'status', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(723, 46, 'facebook', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(724, 46, 'instagram', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(725, 46, 'copyright', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(726, 46, 'maincolor', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(727, 46, 'curency', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54');
INSERT INTO `settings` (`id`, `user_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(728, 46, 'secondcolor', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(729, 46, 'maintextcolor', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(730, 46, 'secoundtextcolor', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(731, 46, 'thirdtextcolor', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(732, 47, 'logo', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(733, 47, 'name', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(734, 47, 'description', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(735, 47, 'phone', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(736, 47, 'whatsapp', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(737, 47, 'address', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(738, 47, 'theme', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(739, 47, 'status', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(740, 47, 'facebook', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(741, 47, 'instagram', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(742, 47, 'copyright', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(743, 47, 'maincolor', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(744, 47, 'curency', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(745, 47, 'secondcolor', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(746, 47, 'maintextcolor', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(747, 47, 'secoundtextcolor', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(748, 47, 'thirdtextcolor', NULL, '2025-09-01 10:52:51', '2025-09-01 10:52:51'),
(749, 48, 'logo', 'images/setting/aSAdB2fcyt6DrKcDALu4ulLMu00Zw0pgK84P1MkN.avif', '2025-09-01 10:53:44', '2025-09-01 10:56:33'),
(750, 48, 'name', 'steak house', '2025-09-01 10:53:44', '2025-09-01 10:57:08'),
(751, 48, 'description', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(752, 48, 'phone', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(753, 48, 'whatsapp', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(754, 48, 'address', 'العين ، أبو ظبي الإمارات العربية المتحدة', '2025-09-01 10:53:44', '2025-09-01 10:56:58'),
(755, 48, 'theme', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(756, 48, 'status', '1', '2025-09-01 10:53:44', '2025-09-01 10:56:40'),
(757, 48, 'facebook', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(758, 48, 'instagram', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(759, 48, 'copyright', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(760, 48, 'maincolor', '#7aec09', '2025-09-01 10:53:44', '2025-09-01 11:43:22'),
(761, 48, 'curency', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(762, 48, 'secondcolor', '#2b1212', '2025-09-01 10:53:44', '2025-09-01 11:42:30'),
(763, 48, 'maintextcolor', NULL, '2025-09-01 10:53:44', '2025-09-01 10:53:44'),
(764, 48, 'secoundtextcolor', '#f41010', '2025-09-01 10:53:44', '2025-09-01 11:42:22'),
(765, 48, 'thirdtextcolor', '#b22e2e', '2025-09-01 10:53:44', '2025-09-01 11:44:53'),
(766, 49, 'logo', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(767, 49, 'name', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(768, 49, 'description', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(769, 49, 'phone', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(770, 49, 'whatsapp', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(771, 49, 'address', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(772, 49, 'theme', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(773, 49, 'status', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(774, 49, 'facebook', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(775, 49, 'instagram', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(776, 49, 'copyright', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(777, 49, 'maincolor', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(778, 49, 'curency', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(779, 49, 'secondcolor', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(780, 49, 'maintextcolor', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(781, 49, 'secoundtextcolor', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(782, 49, 'thirdtextcolor', NULL, '2025-09-01 12:30:37', '2025-09-01 12:30:37'),
(783, 2, 'logo', 'images/setting/hGKnmHinx0wXjG9yRX1nGUgjxdDTuOZnUQWkjY1l.png', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(784, 2, 'name', 'Menu Nano', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(785, 2, 'description', 'مطعم من افضل المطاعم في مصر يمكنك الطلب اون لاين بسهوله', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(786, 2, 'phone', '+201025570206', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(787, 2, 'whatsapp', '+201025570206', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(788, 2, 'address', 'العاشر من رمضان مول الدوحه', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(789, 2, 'theme', '2', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(790, 2, 'status', '1', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(791, 2, 'facebook', 'https://www.facebook.com/share/1946ZQCHcn/', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(792, 2, 'instagram', 'https://www.facebook.com/share/1946ZQCHcn/', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(793, 2, 'copyright', '© nano. All rights reserved.', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(794, 2, 'maincolor', '#eb0000', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(795, 2, 'curency', 'جنية', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(796, 2, 'secondcolor', '#ffffff', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(797, 2, 'maintextcolor', '#ffffff', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(798, 2, 'secoundtextcolor', '#5d0404', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(799, 2, 'thirdtextcolor', '#000000', '2025-09-01 16:11:56', '2025-09-01 16:11:56'),
(800, 50, 'logo', 'images/setting/wMIFkbJbMvQlwjRAG45TC3ABaEkfrjgBgaQrVegg.jpg', '2025-09-03 15:17:51', '2025-09-03 15:20:23'),
(801, 50, 'name', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(802, 50, 'description', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(803, 50, 'phone', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(804, 50, 'whatsapp', '01012521797', '2025-09-03 15:17:51', '2025-09-03 15:20:11'),
(805, 50, 'address', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(806, 50, 'theme', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(807, 50, 'status', '1', '2025-09-03 15:17:51', '2025-09-03 15:19:56'),
(808, 50, 'facebook', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(809, 50, 'instagram', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(810, 50, 'copyright', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(811, 50, 'maincolor', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(812, 50, 'curency', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(813, 50, 'secondcolor', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(814, 50, 'maintextcolor', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(815, 50, 'secoundtextcolor', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(816, 50, 'thirdtextcolor', NULL, '2025-09-03 15:17:51', '2025-09-03 15:17:51'),
(834, 52, 'logo', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(835, 52, 'name', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(836, 52, 'description', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(837, 52, 'phone', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(838, 52, 'whatsapp', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(839, 52, 'address', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(840, 52, 'theme', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(841, 52, 'status', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(842, 52, 'facebook', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(843, 52, 'instagram', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(844, 52, 'copyright', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(845, 52, 'maincolor', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(846, 52, 'curency', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(847, 52, 'secondcolor', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(848, 52, 'maintextcolor', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(849, 52, 'secoundtextcolor', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(850, 52, 'thirdtextcolor', NULL, '2025-09-05 18:41:40', '2025-09-05 18:41:40'),
(868, 54, 'logo', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(869, 54, 'name', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(870, 54, 'description', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(871, 54, 'phone', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(872, 54, 'whatsapp', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(873, 54, 'address', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(874, 54, 'theme', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(875, 54, 'status', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(876, 54, 'facebook', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(877, 54, 'instagram', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(878, 54, 'copyright', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(879, 54, 'maincolor', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(880, 54, 'curency', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(881, 54, 'secondcolor', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(882, 54, 'maintextcolor', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(883, 54, 'secoundtextcolor', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(884, 54, 'thirdtextcolor', NULL, '2025-09-06 08:44:09', '2025-09-06 08:44:09'),
(885, 55, 'logo', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(886, 55, 'name', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(887, 55, 'description', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(888, 55, 'phone', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(889, 55, 'whatsapp', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(890, 55, 'address', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(891, 55, 'theme', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(892, 55, 'status', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(893, 55, 'facebook', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(894, 55, 'instagram', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(895, 55, 'copyright', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(896, 55, 'maincolor', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(897, 55, 'curency', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(898, 55, 'secondcolor', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(899, 55, 'maintextcolor', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(900, 55, 'secoundtextcolor', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(901, 55, 'thirdtextcolor', NULL, '2025-09-06 08:50:09', '2025-09-06 08:50:09'),
(902, 56, 'logo', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(903, 56, 'name', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(904, 56, 'description', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(905, 56, 'phone', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(906, 56, 'whatsapp', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(907, 56, 'address', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(908, 56, 'theme', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(909, 56, 'status', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(910, 56, 'facebook', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(911, 56, 'instagram', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(912, 56, 'copyright', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(913, 56, 'maincolor', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(914, 56, 'curency', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(915, 56, 'secondcolor', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(916, 56, 'maintextcolor', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(917, 56, 'secoundtextcolor', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(918, 56, 'thirdtextcolor', NULL, '2025-09-06 08:51:31', '2025-09-06 08:51:31'),
(919, 57, 'logo', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(920, 57, 'name', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(921, 57, 'description', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(922, 57, 'phone', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(923, 57, 'whatsapp', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(924, 57, 'address', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(925, 57, 'theme', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(926, 57, 'status', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(927, 57, 'facebook', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(928, 57, 'instagram', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(929, 57, 'copyright', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(930, 57, 'maincolor', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(931, 57, 'curency', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(932, 57, 'secondcolor', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(933, 57, 'maintextcolor', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(934, 57, 'secoundtextcolor', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(935, 57, 'thirdtextcolor', NULL, '2025-09-06 08:59:40', '2025-09-06 08:59:40'),
(936, 58, 'logo', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(937, 58, 'name', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(938, 58, 'description', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(939, 58, 'phone', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(940, 58, 'whatsapp', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(941, 58, 'address', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(942, 58, 'theme', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(943, 58, 'status', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(944, 58, 'facebook', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(945, 58, 'instagram', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(946, 58, 'copyright', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(947, 58, 'maincolor', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(948, 58, 'curency', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(949, 58, 'secondcolor', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(950, 58, 'maintextcolor', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(951, 58, 'secoundtextcolor', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(952, 58, 'thirdtextcolor', NULL, '2025-09-06 09:03:17', '2025-09-06 09:03:17'),
(953, 59, 'logo', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(954, 59, 'name', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(955, 59, 'description', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(956, 59, 'phone', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(957, 59, 'whatsapp', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(958, 59, 'address', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(959, 59, 'theme', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(960, 59, 'status', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(961, 59, 'facebook', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(962, 59, 'instagram', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(963, 59, 'copyright', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(964, 59, 'maincolor', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(965, 59, 'curency', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(966, 59, 'secondcolor', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(967, 59, 'maintextcolor', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(968, 59, 'secoundtextcolor', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(969, 59, 'thirdtextcolor', NULL, '2025-09-06 09:06:25', '2025-09-06 09:06:25'),
(1157, 71, 'logo', 'images/setting/2G2kRe2wIszOxAjCF02EtmTUSp87TLUmcI5IsgZ3.jpg', '2025-11-29 12:05:48', '2026-05-02 19:11:29'),
(1158, 71, 'name', 'نانو سيتي', '2025-11-29 12:05:49', '2025-11-29 12:07:30'),
(1159, 71, 'description', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1160, 71, 'phone', '01025570206', '2025-11-29 12:05:49', '2025-11-29 12:07:18'),
(1161, 71, 'whatsapp', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1162, 71, 'address', 'العاشر من رمضان', '2025-11-29 12:05:49', '2025-11-29 13:03:19'),
(1163, 71, 'theme', '1', '2025-11-29 12:05:49', '2025-12-03 15:23:55'),
(1164, 71, 'status', '1', '2025-11-29 12:05:49', '2025-11-29 13:03:51'),
(1165, 71, 'facebook', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1166, 71, 'instagram', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1167, 71, 'copyright', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1168, 71, 'maincolor', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1169, 71, 'curency', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1170, 71, 'secondcolor', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1171, 71, 'maintextcolor', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1172, 71, 'secoundtextcolor', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1173, 71, 'thirdtextcolor', NULL, '2025-11-29 12:05:49', '2025-11-29 12:05:49'),
(1276, 78, 'logo', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1277, 78, 'name', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1278, 78, 'description', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1279, 78, 'phone', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1280, 78, 'whatsapp', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1281, 78, 'address', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1282, 78, 'theme', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1283, 78, 'status', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1284, 78, 'facebook', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1285, 78, 'instagram', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1286, 78, 'copyright', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1287, 78, 'maincolor', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1288, 78, 'curency', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1289, 78, 'secondcolor', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1290, 78, 'maintextcolor', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1291, 78, 'secoundtextcolor', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1292, 78, 'thirdtextcolor', NULL, '2025-12-02 16:57:29', '2025-12-02 16:57:29'),
(1293, 79, 'logo', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1294, 79, 'name', 'غزل ستور', '2025-12-02 21:05:50', '2025-12-02 21:11:25'),
(1295, 79, 'description', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1296, 79, 'phone', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1297, 79, 'whatsapp', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1298, 79, 'address', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1299, 79, 'theme', '3', '2025-12-02 21:05:50', '2025-12-02 21:15:53'),
(1300, 79, 'status', '1', '2025-12-02 21:05:50', '2025-12-02 21:15:43'),
(1301, 79, 'facebook', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1302, 79, 'instagram', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1303, 79, 'copyright', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1304, 79, 'maincolor', '#0b0909', '2025-12-02 21:05:50', '2025-12-02 21:17:38'),
(1305, 79, 'curency', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1306, 79, 'secondcolor', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1307, 79, 'maintextcolor', NULL, '2025-12-02 21:05:50', '2025-12-02 21:05:50'),
(1308, 79, 'secoundtextcolor', '#7b4ed0', '2025-12-02 21:05:50', '2025-12-02 21:26:05'),
(1309, 79, 'thirdtextcolor', '#9157b7', '2025-12-02 21:05:50', '2025-12-02 21:17:17'),
(1310, 80, 'logo', 'images/setting/vmOmeKqqHsPgu7ajssQzbasZxztRhTv5pBD833SH.jpg', '2025-12-03 16:28:42', '2025-12-08 17:23:21'),
(1311, 80, 'name', 'Bun N\' Beef', '2025-12-03 16:28:42', '2025-12-08 17:35:54'),
(1312, 80, 'description', 'Everyday is a burger day!', '2025-12-03 16:28:42', '2025-12-08 17:36:22'),
(1313, 80, 'phone', '01028296221', '2025-12-03 16:28:42', '2025-12-08 17:36:39'),
(1314, 80, 'whatsapp', '+201028296221', '2025-12-03 16:28:42', '2025-12-08 17:36:50'),
(1315, 80, 'address', 'مجاورة 18, بجوار وافلينو, 10th of Ramadan City, Egypt', '2025-12-03 16:28:42', '2025-12-08 17:41:41'),
(1316, 80, 'theme', '3', '2025-12-03 16:28:42', '2025-12-08 17:42:25'),
(1317, 80, 'status', '1', '2025-12-03 16:28:42', '2025-12-03 16:50:59'),
(1318, 80, 'facebook', 'https://www.facebook.com/BunNBeef', '2025-12-03 16:28:42', '2025-12-08 17:41:55'),
(1319, 80, 'instagram', NULL, '2025-12-03 16:28:42', '2025-12-03 16:28:42'),
(1320, 80, 'copyright', NULL, '2025-12-03 16:28:42', '2025-12-03 16:28:42'),
(1321, 80, 'maincolor', '#0d0d0d', '2025-12-03 16:28:42', '2025-12-08 19:15:22'),
(1322, 80, 'curency', 'جنية', '2025-12-03 16:28:42', '2025-12-08 21:14:37'),
(1323, 80, 'secondcolor', '#f2c41f', '2025-12-03 16:28:42', '2025-12-08 19:15:12'),
(1324, 80, 'maintextcolor', NULL, '2025-12-03 16:28:42', '2025-12-03 16:28:42'),
(1325, 80, 'secoundtextcolor', '#f2c41f', '2025-12-03 16:28:42', '2025-12-08 17:48:58'),
(1326, 80, 'thirdtextcolor', '#f2c41f', '2025-12-03 16:28:42', '2025-12-08 17:39:41'),
(1327, 81, 'logo', 'images/setting/DOQ9z18NBuOQtuFYL3piZ49fz5yvpCN53Q1Zns6Q.jpg', '2025-12-07 17:04:44', '2025-12-09 17:48:24'),
(1328, 81, 'name', 'سلطان العطور', '2025-12-07 17:04:44', '2025-12-09 17:28:25'),
(1329, 81, 'description', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1330, 81, 'phone', '01001784345', '2025-12-07 17:04:44', '2025-12-09 17:30:54'),
(1331, 81, 'whatsapp', '2001021143086+', '2025-12-07 17:04:44', '2025-12-10 16:14:15'),
(1332, 81, 'address', 'الاردنيه مجمع الموبايلات أمام مطعم الاصيل', '2025-12-07 17:04:44', '2025-12-09 17:29:31'),
(1333, 81, 'theme', '3', '2025-12-07 17:04:44', '2025-12-10 16:15:45'),
(1334, 81, 'status', '1', '2025-12-07 17:04:44', '2025-12-09 17:31:07'),
(1335, 81, 'facebook', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1336, 81, 'instagram', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1337, 81, 'copyright', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1338, 81, 'maincolor', '#ff0000', '2025-12-07 17:04:44', '2025-12-09 17:33:57'),
(1339, 81, 'curency', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1340, 81, 'secondcolor', '#f5f5f5', '2025-12-07 17:04:44', '2025-12-09 17:51:29'),
(1341, 81, 'maintextcolor', NULL, '2025-12-07 17:04:44', '2025-12-07 17:04:44'),
(1342, 81, 'secoundtextcolor', '#a86205', '2025-12-07 17:04:44', '2025-12-10 16:18:14'),
(1343, 81, 'thirdtextcolor', '#050505', '2025-12-07 17:04:44', '2025-12-09 17:53:30'),
(1378, 84, 'logo', 'images/setting/Cn2G1yJZTk6kbf6LAO48vco1w1JlPJvaixWhnS0S.jpg', '2025-12-09 12:17:53', '2025-12-09 13:32:26'),
(1379, 84, 'name', 'grill', '2025-12-09 12:17:53', '2025-12-09 15:19:26'),
(1380, 84, 'description', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1381, 84, 'phone', '01044074470', '2025-12-09 12:17:53', '2025-12-09 15:17:32'),
(1382, 84, 'whatsapp', '01277715490', '2025-12-09 12:17:53', '2025-12-09 15:17:42'),
(1383, 84, 'address', 'سوهاج مركز المنشأه طريق السنترال بجانب النيابه الاداريه', '2025-12-09 12:17:53', '2025-12-09 15:18:32'),
(1384, 84, 'theme', '3', '2025-12-09 12:17:53', '2025-12-09 13:50:48'),
(1385, 84, 'status', '1', '2025-12-09 12:17:53', '2025-12-09 13:32:03'),
(1386, 84, 'facebook', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1387, 84, 'instagram', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1388, 84, 'copyright', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1389, 84, 'maincolor', '#000000', '2025-12-09 12:17:53', '2025-12-09 13:50:14'),
(1390, 84, 'curency', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1391, 84, 'secondcolor', '#e60000', '2025-12-09 12:17:53', '2025-12-09 13:49:11'),
(1392, 84, 'maintextcolor', NULL, '2025-12-09 12:17:53', '2025-12-09 12:17:53'),
(1393, 84, 'secoundtextcolor', '#171717', '2025-12-09 12:17:53', '2025-12-09 13:50:03'),
(1394, 84, 'thirdtextcolor', '#ea0b0b', '2025-12-09 12:17:53', '2025-12-09 13:49:32'),
(1395, 85, 'logo', 'images/setting/Nvn1lmKLZz5O7ZWmjlWfsnoSyNsd9D71p7PvKZ6o.png', '2025-12-11 17:49:07', '2025-12-11 18:19:43'),
(1396, 85, 'name', 'Ella شركه ايلا للمناديل الورقيه', '2025-12-11 17:49:07', '2025-12-11 17:52:09'),
(1397, 85, 'description', 'إيلا للمناديل الورقية – جودة تستحقها 👑 موزعين معتمدين لأفضل أنواع المناديل الورقية للمطاعم والكافيهات والمنازل. نوصل لعندك بجودة عالية وسعر منافس  اطلب بالجملة أو بالتجزئة – تغليف محترف ، خدمة راقية  ‏', '2025-12-11 17:49:07', '2025-12-12 13:48:53'),
(1398, 85, 'phone', '01110002119', '2025-12-11 17:49:07', '2025-12-11 17:52:24'),
(1399, 85, 'whatsapp', '+201110002119', '2025-12-11 17:49:07', '2025-12-11 17:52:35'),
(1400, 85, 'address', 'العاشر من رمضان', '2025-12-11 17:49:07', '2025-12-11 17:52:59'),
(1401, 85, 'theme', '3', '2025-12-11 17:49:07', '2025-12-11 18:28:55'),
(1402, 85, 'status', '1', '2025-12-11 17:49:07', '2025-12-11 17:53:06'),
(1403, 85, 'facebook', 'Eila-Tissues-%25D8%25A5%25D9%258A%25D9%2584%25D8%25A7-%25D9%2584%25D9%2584%25D9%2585%25D9%2586%25D8%25A7%25D8%25AF%25D9%258A%25D9%2584-%25D8%25A7', '2025-12-11 17:49:07', '2025-12-12 13:50:02'),
(1404, 85, 'instagram', NULL, '2025-12-11 17:49:07', '2025-12-11 17:49:07'),
(1405, 85, 'copyright', 'نانو منيو', '2025-12-11 17:49:07', '2025-12-11 17:53:40'),
(1406, 85, 'maincolor', '#000000', '2025-12-11 17:49:07', '2025-12-13 15:52:12'),
(1407, 85, 'curency', NULL, '2025-12-11 17:49:07', '2025-12-11 17:49:07'),
(1408, 85, 'secondcolor', '#cda636', '2025-12-11 17:49:07', '2025-12-11 18:22:47'),
(1409, 85, 'maintextcolor', NULL, '2025-12-11 17:49:07', '2025-12-11 17:49:07'),
(1410, 85, 'secoundtextcolor', '#000000', '2025-12-11 17:49:07', '2025-12-11 18:23:09'),
(1411, 85, 'thirdtextcolor', '#cda636', '2025-12-11 17:49:07', '2025-12-11 18:22:35'),
(1412, 86, 'logo', 'images/setting/IF4VvZ8wGUN6npgFHoKs4ndZKl5nfCo0YvFGTWpq.jpg', '2025-12-13 15:59:43', '2025-12-13 16:04:01'),
(1413, 86, 'name', 'Chick N', '2025-12-13 15:59:43', '2025-12-13 16:03:43'),
(1414, 86, 'description', 'Chicken & Beef', '2025-12-13 15:59:43', '2025-12-13 16:05:55'),
(1415, 86, 'phone', '01002224076', '2025-12-13 15:59:43', '2025-12-13 16:06:26'),
(1416, 86, 'whatsapp', '+201030390175', '2025-12-13 15:59:43', '2025-12-21 20:17:13'),
(1417, 86, 'address', 'الشرقيه مركز ابوحماد شارع الواحه بجوار مول سيتي زون', '2025-12-13 15:59:43', '2025-12-13 16:08:30'),
(1418, 86, 'theme', '1', '2025-12-13 15:59:43', '2025-12-13 16:06:57'),
(1419, 86, 'status', '1', '2025-12-13 15:59:43', '2025-12-13 16:05:37'),
(1420, 86, 'facebook', 'https://www.facebook.com/share/1DVzGiC2SD/', '2025-12-13 15:59:43', '2025-12-13 16:08:53'),
(1421, 86, 'instagram', NULL, '2025-12-13 15:59:43', '2025-12-13 15:59:43'),
(1422, 86, 'copyright', 'منيو نانو من شركه نانو تكنولوجي للبرمجيات @2025', '2025-12-13 15:59:43', '2025-12-13 16:07:31'),
(1423, 86, 'maincolor', '#088cc4', '2025-12-13 15:59:43', '2025-12-13 16:59:19'),
(1424, 86, 'curency', 'جنية', '2025-12-13 15:59:43', '2025-12-15 21:52:35'),
(1425, 86, 'secondcolor', NULL, '2025-12-13 15:59:43', '2025-12-13 15:59:43'),
(1426, 86, 'maintextcolor', '#000000', '2025-12-13 15:59:43', '2025-12-13 16:57:41'),
(1427, 86, 'secoundtextcolor', '#ffffff', '2025-12-13 15:59:43', '2025-12-13 16:56:17'),
(1428, 86, 'thirdtextcolor', '#ffffff', '2025-12-13 15:59:43', '2025-12-13 16:45:19'),
(1429, 87, 'logo', 'images/setting/2NzddNyybRGCMAZGCOc73P2HP6ygdD4p53WB1n2F.jpg', '2025-12-15 17:47:54', '2025-12-15 17:52:17'),
(1430, 87, 'name', 'مسمط وحاتي الوحيد', '2025-12-15 17:47:54', '2025-12-15 17:48:55'),
(1431, 87, 'description', NULL, '2025-12-15 17:47:54', '2025-12-15 17:47:54'),
(1432, 87, 'phone', '01208722373', '2025-12-15 17:47:54', '2025-12-15 17:49:16'),
(1433, 87, 'whatsapp', '+201223023699', '2025-12-15 17:47:54', '2025-12-15 17:49:36'),
(1434, 87, 'address', 'الزقازيق المحطه من جهه القصر الابيض بجوار صيدليه د اسماعيل فريد', '2025-12-15 17:47:54', '2025-12-15 17:49:50'),
(1435, 87, 'theme', '1', '2025-12-15 17:47:54', '2025-12-15 17:52:23'),
(1436, 87, 'status', '1', '2025-12-15 17:47:54', '2025-12-15 17:49:01'),
(1437, 87, 'facebook', 'https://www.facebook.com/share/1DSAUboCru/', '2025-12-15 17:47:54', '2025-12-15 17:50:15'),
(1438, 87, 'instagram', NULL, '2025-12-15 17:47:54', '2025-12-15 17:47:54'),
(1439, 87, 'copyright', NULL, '2025-12-15 17:47:54', '2025-12-15 17:47:54'),
(1440, 87, 'maincolor', '#ff2e2e', '2025-12-15 17:47:54', '2025-12-15 17:50:34'),
(1441, 87, 'curency', 'جنية', '2025-12-15 17:47:54', '2025-12-15 21:52:15'),
(1442, 87, 'secondcolor', '#fffac2', '2025-12-15 17:47:54', '2025-12-15 17:51:11'),
(1443, 87, 'maintextcolor', '#000000', '2025-12-15 17:47:54', '2025-12-15 18:47:11'),
(1444, 87, 'secoundtextcolor', '#fffac2', '2025-12-15 17:47:54', '2025-12-15 18:46:49'),
(1445, 87, 'thirdtextcolor', '#fffac2', '2025-12-15 17:47:54', '2025-12-15 17:50:58'),
(1548, 94, 'logo', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1549, 94, 'name', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1550, 94, 'description', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1551, 94, 'phone', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1552, 94, 'whatsapp', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1553, 94, 'address', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1554, 94, 'theme', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1555, 94, 'status', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1556, 94, 'facebook', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1557, 94, 'instagram', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1558, 94, 'copyright', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1559, 94, 'maincolor', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1560, 94, 'curency', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1561, 94, 'secondcolor', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1562, 94, 'maintextcolor', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1563, 94, 'secoundtextcolor', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1564, 94, 'thirdtextcolor', NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40'),
(1565, 95, 'logo', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1566, 95, 'name', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1567, 95, 'description', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1568, 95, 'phone', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1569, 95, 'whatsapp', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1570, 95, 'address', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1571, 95, 'theme', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1572, 95, 'status', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1573, 95, 'facebook', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1574, 95, 'instagram', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1575, 95, 'copyright', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1576, 95, 'maincolor', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1577, 95, 'curency', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1578, 95, 'secondcolor', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1579, 95, 'maintextcolor', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1580, 95, 'secoundtextcolor', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1581, 95, 'thirdtextcolor', NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30'),
(1582, 96, 'logo', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1583, 96, 'name', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1584, 96, 'description', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1585, 96, 'phone', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1586, 96, 'whatsapp', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1587, 96, 'address', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1588, 96, 'theme', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1589, 96, 'status', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1590, 96, 'facebook', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1591, 96, 'instagram', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1592, 96, 'copyright', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1593, 96, 'maincolor', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1594, 96, 'curency', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1595, 96, 'secondcolor', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1596, 96, 'maintextcolor', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1597, 96, 'secoundtextcolor', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1598, 96, 'thirdtextcolor', NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06'),
(1599, 97, 'logo', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1600, 97, 'name', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1601, 97, 'description', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1602, 97, 'phone', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1603, 97, 'whatsapp', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1604, 97, 'address', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1605, 97, 'theme', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1606, 97, 'status', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1607, 97, 'facebook', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1608, 97, 'instagram', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1609, 97, 'copyright', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1610, 97, 'maincolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1611, 97, 'curency', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1612, 97, 'secondcolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1613, 97, 'maintextcolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1614, 97, 'secoundtextcolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1615, 97, 'thirdtextcolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `starting_cash` decimal(10,2) NOT NULL DEFAULT 0.00,
  `expected_cash` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'النقدية المتوقعة في نهاية الشيفت بناءً على المبيعات والمصروفات',
  `ending_cash` decimal(10,2) DEFAULT NULL,
  `cash_difference` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'الفرق بين النقدية المتوقعة والنقدية الفعلية',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('active','paused','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expenses_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sent_to_manager` decimal(12,2) NOT NULL DEFAULT 0.00,
  `carryover_to_next_shift` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `user_id`, `branch_id`, `starting_cash`, `expected_cash`, `ending_cash`, `cash_difference`, `start_time`, `end_time`, `status`, `notes`, `closed_by`, `created_at`, `updated_at`, `expenses_total`, `sent_to_manager`, `carryover_to_next_shift`) VALUES
(1, 94, 2, '150.00', '150.00', '150.00', '0.00', '2026-04-18 00:30:00', '2026-04-18 00:54:35', 'closed', 'ييييييييييييييييييييييي', 71, '2026-04-21 22:30:56', '2026-04-17 22:54:35', '0.00', '0.00', '0.00'),
(2, 71, 1, '155.00', '166.00', '316.00', '150.00', '2026-04-18 00:42:00', '2026-04-18 00:51:16', 'closed', 'gggggggggggggggggggg', 71, '2026-04-23 22:00:00', '2026-04-17 22:51:17', '0.00', '0.00', '0.00'),
(3, 95, 1, '55.00', '55.00', '110.00', '55.00', '2026-04-18 00:56:00', '2026-04-18 00:57:12', 'closed', 'كككككككككككككككككك', 71, '2026-04-17 22:56:44', '2026-04-17 22:57:12', '0.00', '0.00', '0.00'),
(4, 71, 1, '1500.00', '1500.00', '2100.00', '0.00', '2026-04-24 21:44:01', '2026-04-24 21:48:53', 'closed', NULL, NULL, '2026-04-24 18:44:01', '2026-04-24 18:48:53', '0.00', '0.00', '0.00'),
(5, 71, 1, '3000.00', '3000.00', '5500.00', '2500.00', '2026-04-24 21:54:23', '2026-04-24 21:54:59', 'closed', NULL, 71, '2026-04-24 18:54:23', '2026-04-24 18:54:59', '0.00', '0.00', '0.00'),
(6, 71, 1, '9500.00', '9500.00', '6000.00', '-3500.00', '2026-04-24 22:40:26', '2026-04-24 22:42:15', 'closed', NULL, 71, '2026-04-24 19:40:26', '2026-04-24 19:42:15', '0.00', '0.00', '0.00'),
(7, 71, 1, '36541.00', '36541.00', '3698.00', '-32843.00', '2026-04-24 23:08:36', '2026-04-24 23:11:56', 'closed', NULL, 71, '2026-04-24 20:08:36', '2026-04-24 20:11:56', '0.00', '0.00', '0.00'),
(8, 71, 1, '9874.00', '9874.00', '99999.00', '90125.00', '2026-04-24 23:12:14', '2026-04-24 23:37:09', 'closed', NULL, 71, '2026-04-24 20:12:14', '2026-04-24 20:37:09', '0.00', '0.00', '0.00'),
(9, 71, 1, '98745.00', '98745.00', '654123.00', '555378.00', '2026-04-25 14:07:14', '2026-04-25 14:08:39', 'closed', NULL, 71, '2026-04-25 11:07:14', '2026-04-25 11:08:39', '0.00', '0.00', '0.00'),
(10, 96, 1, '9999.00', '9999.00', '5555.00', '-4444.00', '2026-04-25 15:41:42', '2026-04-25 15:59:19', 'closed', NULL, 96, '2026-04-25 12:41:43', '2026-04-25 12:59:20', '0.00', '0.00', '0.00'),
(11, 96, 1, '14785.00', '14785.00', '987456.00', '972671.00', '2026-04-25 17:22:50', '2026-04-25 17:36:45', 'closed', NULL, 96, '2026-04-25 14:22:50', '2026-04-25 14:36:45', '0.00', '0.00', '0.00'),
(12, 71, 1, '100.00', '100.00', '150.00', '50.00', '2026-04-25 18:04:57', '2026-04-25 18:06:06', 'closed', NULL, 71, '2026-04-25 15:04:57', '2026-04-25 15:06:06', '0.00', '0.00', '0.00'),
(13, 71, 1, '100.00', '560.00', '500.00', '-60.00', '2026-04-25 20:50:09', '2026-04-25 20:56:51', 'closed', NULL, 71, '2026-04-25 17:50:09', '2026-04-25 17:56:51', '0.00', '0.00', '0.00'),
(14, 71, 1, '500.00', '880.00', '880.00', '0.00', '2026-04-25 21:31:06', '2026-04-25 21:52:47', 'closed', '', 71, '2026-04-25 18:31:06', '2026-04-25 18:52:47', '0.00', '0.00', '0.00'),
(15, 96, 1, '100.00', '110.00', '110.00', '0.00', '2026-04-25 22:13:35', '2026-04-25 22:17:13', 'closed', '', 96, '2026-04-25 19:13:35', '2026-04-25 19:17:13', '0.00', '0.00', '0.00'),
(16, 96, 1, '10.00', '10.00', '10.00', '0.00', '2026-04-25 22:27:56', '2026-04-25 23:06:14', 'closed', NULL, 96, '2026-04-25 19:27:56', '2026-04-25 20:06:14', '0.00', '0.00', '0.00'),
(17, 71, 1, '155.00', '130.00', '130.00', '0.00', '2026-04-26 21:25:48', '2026-04-26 22:22:59', 'closed', '', 71, '2026-04-26 18:25:48', '2026-04-26 19:22:59', '25.00', '150.00', '130.00'),
(18, 96, 1, '130.00', '20.00', '20.00', '0.00', '2026-04-26 22:53:09', '2026-04-26 23:05:32', 'closed', '', 96, '2026-04-26 19:53:09', '2026-04-26 20:05:33', '10.00', '100.00', '20.00'),
(19, 96, 1, '20.00', '20.00', '20.00', '0.00', '2026-04-26 23:16:40', '2026-04-26 23:17:01', 'closed', NULL, 96, '2026-04-26 20:16:40', '2026-04-26 20:17:01', '0.00', '0.00', '20.00'),
(21, 71, 1, '20.00', '20.00', '20.00', '0.00', '2026-04-27 20:18:42', '2026-04-27 20:19:24', 'closed', '', 71, '2026-04-27 17:18:42', '2026-04-27 17:19:25', '0.00', '0.00', '20.00'),
(22, 71, 1, '20.00', '30.00', '30.00', '0.00', '2026-04-27 20:44:15', '2026-04-27 20:45:59', 'closed', '', 71, '2026-04-27 17:44:15', '2026-04-27 17:45:59', '10.00', '100.00', '30.00'),
(23, 96, 1, '30.00', '30.00', '30.00', '0.00', '2026-05-02 16:29:16', '2026-05-02 16:29:36', 'closed', NULL, 96, '2026-05-02 13:29:16', '2026-05-02 13:29:36', '0.00', '0.00', '30.00'),
(24, 96, 1, '30.00', '30.00', '30.00', '0.00', '2026-05-02 16:35:31', '2026-05-02 16:37:50', 'closed', '', 96, '2026-05-02 13:35:31', '2026-05-02 13:37:50', '0.00', '0.00', '30.00'),
(25, 96, 1, '30.00', '30.00', '30.00', '0.00', '2026-05-02 17:40:16', '2026-05-02 17:41:04', 'closed', NULL, 96, '2026-05-02 14:40:16', '2026-05-02 14:41:04', '0.00', '0.00', '30.00');

-- --------------------------------------------------------

--
-- Table structure for table `shift_expenses`
--

CREATE TABLE `shift_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `expense_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shift_expenses`
--

INSERT INTO `shift_expenses` (`id`, `shift_id`, `user_id`, `branch_id`, `title`, `amount`, `expense_date`, `status`, `approved_by`, `notes`, `receipt_image`, `created_at`, `updated_at`) VALUES
(1, 17, 71, 1, 'مصروفات توصيل', '25.00', '2026-04-26 21:58:51', 'approved', 71, 'تم ارسال طلب ', NULL, '2026-04-26 18:58:51', '2026-04-26 18:58:51'),
(2, 18, 96, 1, 'مصروفات توصيل ', '10.00', '2026-04-26 22:55:23', 'approved', 96, 'مصروفات توصيل', NULL, '2026-04-26 19:55:23', '2026-04-26 19:55:23'),
(3, 22, 71, 1, 'توصيل', '10.00', '2026-04-27 20:44:52', 'approved', 71, 'توصيل ', NULL, '2026-04-27 17:44:52', '2026-04-27 17:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `user_id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(13, 8, 'slider', 'sliderrrry', 'sliders/NlJpsMt5Hsc5RBL6nigu9DB0JBtZ620PyQPVGzuK.png', '2025-08-31 09:38:39', '2025-08-31 09:38:39'),
(20, 50, NULL, NULL, 'sliders/xOqdVaKaNMU57XWC4b3wHJADjff6V79KITF9ylB8.png', '2025-09-03 15:19:21', '2025-09-03 15:19:21'),
(21, 50, NULL, NULL, 'sliders/oyW3rybwSiop42pVUEraub0bC7ScQzYRte4z3mTO.png', '2025-09-03 15:19:38', '2025-09-03 15:19:38'),
(23, 52, NULL, NULL, 'sliders/n3QY6KgtXpbVadFFqiRJcYPyf50pDrsrOGTCgrAq.jpg', '2025-09-05 18:42:50', '2025-09-05 18:42:50'),
(33, 79, NULL, NULL, 'sliders/AVcbN5bF5cLANvG2rVjOaz7IoipFDs5vVzkKyXZF.jpg', '2025-12-02 21:15:06', '2025-12-02 21:15:06'),
(34, 71, NULL, NULL, 'sliders/24mKky4DwpnBXFKbWoUSIGKbsFP8ox5ASdAMpf4O.png', '2025-12-03 16:00:45', '2025-12-03 16:00:45'),
(35, 71, NULL, NULL, 'sliders/1F1PPkKkJL8XlaO6fKi9x0hNXAnA4OAEobGqV09x.jpg', '2025-12-06 09:01:59', '2025-12-06 09:01:59'),
(36, 71, NULL, NULL, 'sliders/1OgDKimEiZImdnsdKcLUUHY4iM1b6hPPmVEzCoEl.jpg', '2025-12-08 11:21:16', '2026-04-11 17:13:25'),
(41, 80, NULL, NULL, 'sliders/AM2PaYwOLshX29axniixPCN41Vz7pkgZDsIAImjU.jpg', '2025-12-08 17:21:19', '2025-12-08 17:21:19'),
(43, 84, NULL, NULL, 'sliders/vM5HwFVqfd049apEfnUObErELrEdX1QjSn5pgDD6.jpg', '2025-12-09 13:23:59', '2025-12-09 13:23:59'),
(44, 81, NULL, NULL, 'sliders/non3xT3G9AUCJJhBqbalRmvwoWvnivMVftPR5HP0.jpg', '2025-12-09 17:52:28', '2025-12-09 18:00:25'),
(46, 85, NULL, NULL, 'sliders/YWSp9YmmT8R3dSANPB5uTIGqfIYVAkfTnitLac3o.png', '2025-12-11 18:23:51', '2025-12-11 18:23:51'),
(47, 86, NULL, NULL, 'sliders/gZINVSG0UTARyZQeYiHq8zFsGZoCA7sXhNBJeoWY.jpg', '2025-12-13 16:04:30', '2025-12-13 16:04:30'),
(48, 86, NULL, NULL, 'sliders/5jXkPK5JrxTDXmx0m0CcpLTz6jT3LGsSxlo3OmjM.jpg', '2025-12-13 16:08:05', '2025-12-13 16:08:05'),
(49, 87, NULL, NULL, 'sliders/u8kOd1HjusZKU3mSuC7YP1O8dXHgbHQB5LzotqGU.jpg', '2025-12-15 17:53:19', '2025-12-15 17:53:19'),
(50, 87, NULL, NULL, 'sliders/fZBndU6qVSFmxoYfuMw2lcVLtbvgvWMfbX883tBi.jpg', '2025-12-15 17:53:32', '2025-12-15 17:53:32'),
(51, 87, NULL, NULL, 'sliders/xEEOf7j5Zjn6BCvPu4xAU8zhPllJPqJzUmnqNtyo.jpg', '2025-12-15 17:54:10', '2025-12-15 17:54:10'),
(55, 71, NULL, NULL, 'sliders/ChytYnOFKwb52x26hDtEklpR3iQhwNo9vrzjxOk9.jpg', '2026-04-11 17:13:44', '2026-04-11 17:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `Name` varchar(22) NOT NULL,
  `BirthDay` date NOT NULL,
  `Academic_qualification` text NOT NULL,
  `Start_date` datetime NOT NULL,
  `End_date` datetime NOT NULL,
  `attach_File` varchar(50) DEFAULT NULL,
  `Salary` int(11) NOT NULL,
  `user_id` int(22) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `Name`, `BirthDay`, `Academic_qualification`, `Start_date`, `End_date`, `attach_File`, `Salary`, `user_id`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'AmrHassan', '0000-00-00', 'facultyofcommerceS.V.u', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ssdad.png', 500, 71, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '[value-12]'),
(7, 'عمرو حسن جيلاني', '2026-05-14', 'dv m', '2026-05-22 00:00:00', '2026-05-20 00:00:00', '1777582979.jpg', 300, 71, '2026-04-30 18:02:59', '2026-04-30 18:02:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `count_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_date` date NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full',
  `status` enum('draft','counting','approved','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_counts`
--

INSERT INTO `stock_counts` (`id`, `user_id`, `count_number`, `count_date`, `type`, `status`, `notes`, `approved_by`, `approved_at`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 'SC-20260419211956', '2026-04-19', 'full', 'approved', 'qwsadxc', 71, '2026-04-19 19:21:30', '2026-04-19 19:19:56', '2026-04-19 19:21:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_count_items`
--

CREATE TABLE `stock_count_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_count_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `system_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `physical_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `difference_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_count_items`
--

INSERT INTO `stock_count_items` (`id`, `stock_count_id`, `inventory_id`, `system_quantity`, `physical_quantity`, `difference_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '3.000', '10.000', '7.000', 'welcome', '2026-04-19 19:19:56', '2026-04-19 19:19:56'),
(2, 1, 1, '3.000', '1.000', '-2.000', 'welcome 2', '2026-04-19 19:19:56', '2026-04-19 19:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','active','expired','cancelled','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `package_id`, `payment_method_id`, `phone`, `receipt_image`, `price_paid`, `starts_at`, `ends_at`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 71, 7, 1, '+201025570206', NULL, '0.00', '2026-04-20 22:51:48', '2026-07-30 21:51:48', 'active', 1, '2026-04-21 00:46:05', '2026-04-20 22:51:48'),
(7, 71, 8, 1, '+20102557020600', NULL, '1452.00', '2026-04-20 22:57:13', '2026-05-29 23:43:13', 'active', 1, '2026-04-21 00:46:05', '2026-04-20 22:57:13'),
(8, 71, 3, 2, '+201025570206', NULL, '250.00', '2026-04-21 00:46:05', '2026-05-20 23:46:05', 'pending', 0, '2026-04-21 00:46:05', '2026-04-21 00:46:05'),
(9, 71, 4, 2, '+201025570206', NULL, '1250.00', '2025-10-12 23:46:05', '2026-04-11 00:46:05', 'pending', 1, '2026-04-21 00:46:05', '2026-04-21 00:46:05'),
(10, 71, 5, 1, '+201025570206', NULL, '2500.00', '2026-04-21 00:46:05', '2027-04-16 00:46:05', 'rejected', 0, '2026-04-23 00:46:05', '2026-04-21 00:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `name`, `contact_name`, `phone`, `email`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 71, 'Ahmed Salah', 'Ahmed', '01236589745', 'a@gmail.com', '123', 1, '2026-04-20 17:53:15', '2026-04-20 17:53:15'),
(2, 71, 'ffffff', 'gggggggggg', '01236589741', 'F@gmail.com', '145', 1, '2026-04-22 13:09:24', NULL),
(3, 71, 'eeeeeeeeeeeeee', 'rrrrrrrrrrrr', '01345967820', 'g@gmail.com', '456', 1, '2026-04-24 12:09:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_raw_materials`
--

CREATE TABLE `supplier_raw_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_item_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_quantity` decimal(12,3) NOT NULL DEFAULT 1.000,
  `conversion_factor` decimal(12,3) NOT NULL DEFAULT 1.000,
  `purchase_cost` decimal(12,3) NOT NULL DEFAULT 0.000,
  `is_preferred` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_raw_materials`
--

INSERT INTO `supplier_raw_materials` (`id`, `user_id`, `supplier_id`, `raw_material_id`, `unit_id`, `supplier_item_code`, `order_quantity`, `conversion_factor`, `purchase_cost`, `is_preferred`, `notes`, `created_at`, `updated_at`) VALUES
(1, 71, 1, 2, 1, '123', '1.000', '1.000', '100.000', 1, 'ضضضضضضضضضضضضضضضضض', '2026-04-20 18:13:23', '2026-04-20 18:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dining_area_id` bigint(20) UNSIGNED NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(4, '1. التعريف', 'المنيو الإلكتروني هو خدمة مقدمة من شركة نانو تكنولوجي للبرمجيات لعرض منتجات وخدمات المحل/المطعم بشكل رقمي عبر الإنترنت لتسهيل عملية الطلب والوصول للعملاء.', '2025-08-31 07:46:40', '2025-08-31 07:46:40'),
(5, '2. استخدام الخدمة', 'يلتزم العميل باستخدام المنيو الإلكتروني فقط للأغراض المشروعة الخاصة بنشاطه التجاري.\r\n\r\nلا يحق للعميل إعادة بيع أو منح حق استخدام الخدمة لأي طرف ثالث دون موافقة كتابية من الشركة.\r\n\r\nيلتزم العميل بعدم إدخال أي محتوى مخالف للقوانين أو مخل بالآداب العامة.', '2025-08-31 07:47:02', '2025-08-31 07:47:02'),
(6, '3. الاشتراك والرسوم', 'قيمة الاشتراك الشهري  للخدمة  ويتم دفعها مقدماً.\r\n\r\nتحتفظ الشركة بحق تعديل أسعار الاشتراك بعد إخطار العميل مسبقاً.\r\n\r\nفي حال التأخر عن سداد الاشتراك يحق للشركة إيقاف الخدمة مؤقتاً حتى السداد.', '2025-08-31 07:48:14', '2025-08-31 07:48:14'),
(7, '4. المحتوى والبيانات', 'العميل مسؤول عن صحة ودقة البيانات (الصور، الأسعار، الأوصاف) المضافة إلى المنيو.\r\n\r\nالشركة غير مسؤولة عن أي أخطاء أو مخالفات في المحتوى المقدم من العميل.\r\n\r\nتحتفظ الشركة بحق حذف أي محتوى مخالف للشروط دون إشعار مسبق.', '2025-08-31 07:48:40', '2025-08-31 07:48:40'),
(8, '5. الدعم الفني', 'تقدم الشركة الدعم الفني خلال أوقات العمل الرسمية فقط.\r\n\r\nلا تتحمل الشركة مسؤولية أي أعطال خارج إرادتها (انقطاع الإنترنت، مشاكل مزود الخدمة، قوة قاهرة).', '2025-08-31 07:49:24', '2025-08-31 07:49:24'),
(9, '6. حقوق الملكية الفكرية', 'جميع حقوق البرمجة والتصميم والتطوير خاصة بشركة نانو تكنولوجي للبرمجيات.\r\n\r\nيحق للعميل استخدام المنيو الإلكتروني خلال فترة الاشتراك فقط.', '2025-08-31 07:50:21', '2025-08-31 07:50:21'),
(10, '7. إخلاء المسؤولية', 'الشركة غير مسؤولة عن أي خسائر مالية أو أضرار مباشرة أو غير مباشرة نتيجة استخدام المنيو.\r\n\r\nالعميل وحده مسؤول عن إدارة الطلبات والتعامل مع عملائه.', '2025-08-31 07:50:48', '2025-08-31 07:50:48'),
(11, '8. إيقاف أو إنهاء الخدمة', 'يحق للعميل إلغاء الاشتراك في أي وقت دون استرداد المبالغ المدفوعة.\r\n\r\nتحتفظ الشركة بحق إلغاء الخدمة في حالة مخالفة العميل للشروط.', '2025-08-31 07:51:09', '2025-08-31 07:51:09'),
(12, '9. تعديل الشروط', 'تحتفظ الشركة بحق تعديل هذه الشروط والأحكام في أي وقت، ويتم إشعار العميل بها عبر البريد الإلكتروني أو المنصة.', '2025-08-31 07:51:27', '2025-08-31 07:51:27'),
(13, '10. القانون الواجب التطبيق', 'تخضع هذه الشروط والأحكام لقوانين', '2025-08-31 07:52:01', '2025-08-31 07:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requests`
--

CREATE TABLE `transfer_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `status` enum('draft','requested','approved','in_transit','received','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer_requests`
--

INSERT INTO `transfer_requests` (`id`, `user_id`, `transfer_number`, `from_branch_id`, `to_branch_id`, `transfer_date`, `status`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 'TR-20260419205900', 1, 3, '2026-04-19', 'received', 'welcome', '2026-04-22 18:59:00', '2026-04-19 19:13:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_request_items`
--

CREATE TABLE `transfer_request_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_request_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_quantity` decimal(14,3) NOT NULL,
  `sent_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `received_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer_request_items`
--

INSERT INTO `transfer_request_items` (`id`, `transfer_request_id`, `raw_material_id`, `unit_id`, `requested_quantity`, `sent_quantity`, `received_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '1.000', '1.000', '1.000', 'welcome', '2026-04-19 18:59:00', '2026-04-19 18:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('count','weight','volume') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'count',
  `allow_decimal` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `conversion_rate` decimal(10,4) DEFAULT NULL COMMENT 'Rate relative to base unit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `symbol`, `type`, `allow_decimal`, `is_active`, `user_id`, `base_unit_id`, `conversion_rate`, `created_at`, `updated_at`) VALUES
(1, 'kilo', 'kg', 'weight', 1, 1, 71, NULL, NULL, '2026-04-18 21:02:12', '2026-04-18 21:02:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `store_name`, `image`, `status`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `created_at`, `updated_at`, `role`, `created_by`, `branch_id`) VALUES
(2, 'a', 'admin1@admin.com', NULL, NULL, NULL, 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, NULL, NULL, 'super_admin', NULL, NULL),
(71, 'Ahmed', 'nanocity@gmail.com', '+201025570206', 'nanocity', 'admins/P3GfwEIiJHtpgkFOmoWazMeyLAC1sQcNUeWIL2RR.jpg', 1, '$2y$12$YQGtgEMKVo2r4KJQLQg/lOKo/ydI7taK7NYwwOb5zNdApIr8OlqYG', NULL, NULL, NULL, '2025-11-29 12:05:48', '2025-12-21 08:02:37', 'admin', NULL, NULL),
(78, 'b', 'first_pipe@gmeil.com', '+201200860222', 'firstpipe', NULL, 1, '$2y$12$7fIHpISo14yGA5Dtj1.EZ.298HROscF2A02B0647zAkURH67lyAAC', NULL, NULL, NULL, '2025-12-02 16:57:29', '2025-12-02 21:30:29', 'admin', NULL, NULL),
(79, 'c', 'enjysakr3@gmail.com', '+201007785293', 'jhazl', NULL, 0, '$2y$12$6IIS.0bQlr3LmexNfq2JDecHXmdr7EQYSyNNwH3MjjljF2Cxgxqia', NULL, NULL, NULL, '2025-12-02 21:05:50', '2026-01-02 13:23:20', 'admin', NULL, NULL),
(80, 'd', 'diyaareda4@gmail.com', '+201050222277', 'Bunnbeef', NULL, 0, '$2y$12$30mWbmRv7px82thCdjI2HuJ50VEmNTp37hamqtOQMD8n/PMzqTiQK', NULL, NULL, NULL, '2025-12-03 16:28:42', '2026-01-13 19:30:53', 'admin', NULL, NULL),
(81, 'e', '01021143086@gmail.com', '+201021143086', 'elsultan', NULL, 1, '$2y$12$dAkMb6Anq25JBt9T.NwRBe8GWpB5MzqAvpZ5oIuonqsW9ynTBz022', NULL, NULL, NULL, '2025-12-07 17:04:44', '2025-12-07 17:07:30', 'admin', NULL, NULL),
(84, 'f', 'grill@gmail.com', '+201027550212', 'grill', 'admins/11SWaRVCmcqsYUNbpVXlGLuvuPzMbDodt3UZQ7ih.jpg', 0, '$2y$12$fXGoPUzoZhH2tAxGbLX5l.qXyoYh3JfkKA29ZanHfeNPk5zhVeQg6', NULL, NULL, NULL, '2025-12-09 12:17:53', '2026-02-07 09:21:50', 'admin', NULL, NULL),
(85, 'g', 'osheko135@gmail.com', '+201110002119', 'Ella', 'admins/6JrQ7l1J5J40hqz1RemtgH0MKFfHjC3yFn3hBbQr.png', 1, '$2y$12$OOyEQybZEOsVR.xWLb6YtOcdMKpQ9WqdvW9UTL4TCaRu9VhK9kC1u', NULL, NULL, NULL, '2025-12-11 17:49:07', '2025-12-11 17:49:48', 'admin', NULL, NULL),
(86, 'h', '01507444580@gmail.com', '+201507444580', 'chickn', NULL, 1, '$2y$12$W05i/gRBvY0LIGOkxMHageD9Sxo/mM7FDiDt9pCQEMUYoItuNpPqu', NULL, NULL, NULL, '2025-12-13 15:59:43', '2025-12-13 16:01:06', 'admin', NULL, NULL),
(87, 'i', 'mahmoudhassen186@gmail.com', '+20⁦+201223023699⁩', 'alwahid', NULL, 1, '$2y$12$nkxqRFiGuURpZY/tMf.W3O43uP/UxmJDp3PHTIl4wLu9Df4fpD6c2', NULL, NULL, NULL, '2025-12-15 17:47:54', '2026-04-20 20:44:16', 'admin', NULL, NULL),
(94, 'agent33', 'w@gmail.com', NULL, NULL, NULL, 1, '$2y$12$1SwImodNmhYkhtMeWMfYgeRAAvCPl2Vgw5Q0RTeU47kRoHwD0Dtaq', NULL, NULL, NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40', 'cashier', 71, 1),
(95, 'ssssssssssssssssss', 'y@gmail.com', NULL, NULL, NULL, 1, '$2y$12$HLP4WdAd7rwKIznlID.C9ul3W85daPKZUzgyzUjrZWlJbLeOV/fZ6', NULL, NULL, NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30', 'cashier', 71, 1),
(96, 'ضضضضضضضضضض', 'x@gmail.com', NULL, NULL, NULL, 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06', 'cashier', 71, 1),
(97, 'ققق', 'na@gmail.com', NULL, NULL, 'users/1776207361_69dec601366b7.jpg', 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01', 'admin', 71, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_attendance_date_unique` (`user_id`,`attendance_date`),
  ADD KEY `attendances_shift_id_foreign` (`shift_id`),
  ADD KEY `attendances_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_created_by_foreign` (`created_by`),
  ADD KEY `branches_business_id_foreign` (`business_id`),
  ADD KEY `branches_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `branch_creation_requests`
--
ALTER TABLE `branch_creation_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_creation_requests_business_id_foreign` (`business_id`),
  ADD KEY `branch_creation_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `branch_creation_requests_approved_by_foreign` (`approved_by`),
  ADD KEY `branch_creation_requests_created_branch_id_foreign` (`created_branch_id`);

--
-- Indexes for table `branch_links`
--
ALTER TABLE `branch_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_links_from_branch_id_to_branch_id_unique` (`from_branch_id`,`to_branch_id`),
  ADD KEY `branch_links_business_id_foreign` (`business_id`),
  ADD KEY `branch_links_to_branch_id_foreign` (`to_branch_id`);

--
-- Indexes for table `branch_users`
--
ALTER TABLE `branch_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_users_branch_id_user_id_unique` (`branch_id`,`user_id`),
  ADD KEY `branch_users_user_id_foreign` (`user_id`),
  ADD KEY `branch_users_assigned_by_foreign` (`assigned_by`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `business_settings_key_unique` (`key`);

--
-- Indexes for table `business_types`
--
ALTER TABLE `business_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `business_types_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_customer_id_product_size_id_unique` (`customer_id`,`product_size_id`),
  ADD KEY `cart_items_product_size_id_foreign` (`product_size_id`),
  ADD KEY `cart_items_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `cash_transfers`
--
ALTER TABLE `cash_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_transfers_from_shift_id_foreign` (`from_shift_id`),
  ADD KEY `cash_transfers_to_shift_id_foreign` (`to_shift_id`),
  ADD KEY `cash_transfers_branch_id_foreign` (`branch_id`),
  ADD KEY `cash_transfers_from_user_id_foreign` (`from_user_id`),
  ADD KEY `cash_transfers_to_user_id_foreign` (`to_user_id`),
  ADD KEY `cash_transfers_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_user` (`user_id`),
  ADD KEY `categories_store_id_foreign` (`store_id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charges_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_user_id_phone_unique` (`user_id`,`phone`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_men_user_id_foreign` (`user_id`),
  ADD KEY `delivery_men_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `dining_areas`
--
ALTER TABLE `dining_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dining_areas_user_id_foreign` (`user_id`),
  ADD KEY `dining_areas_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `goods_receipts`
--
ALTER TABLE `goods_receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `goods_receipts_receipt_number_unique` (`receipt_number`),
  ADD KEY `goods_receipts_user_id_foreign` (`user_id`),
  ADD KEY `goods_receipts_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `goods_receipts_supplier_id_foreign` (`supplier_id`),
  ADD KEY `goods_receipts_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `goods_receipt_items`
--
ALTER TABLE `goods_receipt_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_receipt_items_goods_receipt_id_foreign` (`goods_receipt_id`),
  ADD KEY `goods_receipt_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `goods_receipt_items_purchase_order_item_id_foreign` (`purchase_order_item_id`),
  ADD KEY `goods_receipt_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_user_id_foreign` (`user_id`),
  ADD KEY `inventories_inventoriable_type_inventoriable_id_index` (`inventoriable_type`,`inventoriable_id`),
  ADD KEY `inventories_purchase_unit_id_foreign` (`purchase_unit_id`),
  ADD KEY `inventories_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_movements_user_id_foreign` (`user_id`),
  ADD KEY `inventory_movements_inventory_id_foreign` (`inventory_id`),
  ADD KEY `inventory_movements_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_table_id_foreign` (`table_id`),
  ADD KEY `orders_delivery_man_id_foreign` (`delivery_man_id`),
  ADD KEY `orders_shift_id_foreign` (`shift_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `order_product_sizes`
--
ALTER TABLE `order_product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_sizes_order_id_foreign` (`order_id`),
  ADD KEY `order_product_sizes_product_size_id_foreign` (`product_size_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_business_type_id_foreign` (`business_type_id`);

--
-- Indexes for table `package_features`
--
ALTER TABLE `package_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_features_package_id_foreign` (`package_id`);

--
-- Indexes for table `package_permissions`
--
ALTER TABLE `package_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_permissions_package_id_permission_key_unique` (`package_id`,`permission_key`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_name_unique` (`name`),
  ADD KEY `payment_methods_created_by_foreign` (`created_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `production_orders`
--
ALTER TABLE `production_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `production_orders_production_number_unique` (`production_number`),
  ADD KEY `production_orders_user_id_foreign` (`user_id`),
  ADD KEY `production_orders_recipe_id_foreign` (`recipe_id`),
  ADD KEY `production_orders_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `production_order_items`
--
ALTER TABLE `production_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_order_items_production_order_id_foreign` (`production_order_id`),
  ADD KEY `production_order_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `production_order_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_user` (`user_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_recipes`
--
ALTER TABLE `product_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_recipes_product_id_foreign` (`product_id`),
  ADD KEY `product_recipes_ingredient_id_foreign` (`ingredient_id`),
  ADD KEY `product_recipes_unit_id_foreign` (`unit_id`),
  ADD KEY `product_recipes_product_size_id_foreign` (`product_size_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sizes_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_invoices_user_id_foreign` (`user_id`),
  ADD KEY `purchase_invoices_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_invoices_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_invoice_items_purchase_invoice_id_foreign` (`purchase_invoice_id`),
  ADD KEY `purchase_invoice_items_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  ADD KEY `purchase_orders_user_id_foreign` (`user_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_orders_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `purchase_orders_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `purchase_order_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_requests_request_number_unique` (`request_number`),
  ADD KEY `purchase_requests_user_id_foreign` (`user_id`),
  ADD KEY `purchase_requests_approved_by_foreign` (`approved_by`),
  ADD KEY `purchase_requests_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_request_items_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `purchase_request_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `purchase_request_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_materials_user_id_foreign` (`user_id`),
  ADD KEY `raw_materials_inventory_category_id_foreign` (`inventory_category_id`),
  ADD KEY `raw_materials_default_supplier_id_foreign` (`default_supplier_id`),
  ADD KEY `raw_materials_purchase_unit_id_foreign` (`purchase_unit_id`),
  ADD KEY `raw_materials_sku_index` (`sku`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recipes_user_id_output_raw_material_id_unique` (`user_id`,`output_raw_material_id`),
  ADD KEY `recipes_output_raw_material_id_foreign` (`output_raw_material_id`),
  ADD KEY `recipes_yield_unit_id_foreign` (`yield_unit_id`);

--
-- Indexes for table `recipe_items`
--
ALTER TABLE `recipe_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recipe_items_recipe_id_raw_material_id_unique` (`recipe_id`,`raw_material_id`),
  ADD KEY `recipe_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `recipe_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_created_by_foreign` (`created_by`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_settings_user` (`user_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_user_id_foreign` (`user_id`),
  ADD KEY `shifts_branch_id_foreign` (`branch_id`),
  ADD KEY `shifts_closed_by_foreign` (`closed_by`);

--
-- Indexes for table `shift_expenses`
--
ALTER TABLE `shift_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shift_expenses_shift_id_foreign` (`shift_id`),
  ADD KEY `shift_expenses_user_id_foreign` (`user_id`),
  ADD KEY `shift_expenses_branch_id_foreign` (`branch_id`),
  ADD KEY `shift_expenses_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sliders_user` (`user_id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_counts_count_number_unique` (`count_number`),
  ADD KEY `stock_counts_user_id_foreign` (`user_id`),
  ADD KEY `stock_counts_approved_by_foreign` (`approved_by`),
  ADD KEY `stock_counts_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_count_items_stock_count_id_foreign` (`stock_count_id`),
  ADD KEY `stock_count_items_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_package_id_foreign` (`package_id`),
  ADD KEY `subscriptions_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `supplier_raw_materials`
--
ALTER TABLE `supplier_raw_materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_raw_materials_supplier_id_raw_material_id_unique` (`supplier_id`,`raw_material_id`),
  ADD KEY `supplier_raw_materials_user_id_foreign` (`user_id`),
  ADD KEY `supplier_raw_materials_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `supplier_raw_materials_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tables_dining_area_id_foreign` (`dining_area_id`),
  ADD KEY `tables_user_id_foreign` (`user_id`),
  ADD KEY `tables_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transfer_requests_transfer_number_unique` (`transfer_number`),
  ADD KEY `transfer_requests_user_id_foreign` (`user_id`),
  ADD KEY `transfer_requests_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `transfer_request_items`
--
ALTER TABLE `transfer_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_request_items_transfer_request_id_foreign` (`transfer_request_id`),
  ADD KEY `transfer_request_items_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `transfer_request_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_user_id_name_unique` (`user_id`,`name`),
  ADD KEY `units_base_unit_id_foreign` (`base_unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch_creation_requests`
--
ALTER TABLE `branch_creation_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch_links`
--
ALTER TABLE `branch_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch_users`
--
ALTER TABLE `branch_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `business_types`
--
ALTER TABLE `business_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cash_transfers`
--
ALTER TABLE `cash_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dining_areas`
--
ALTER TABLE `dining_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods_receipts`
--
ALTER TABLE `goods_receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goods_receipt_items`
--
ALTER TABLE `goods_receipt_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_product_sizes`
--
ALTER TABLE `order_product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `package_features`
--
ALTER TABLE `package_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `package_permissions`
--
ALTER TABLE `package_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `production_orders`
--
ALTER TABLE `production_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `production_order_items`
--
ALTER TABLE `production_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;

--
-- AUTO_INCREMENT for table `product_recipes`
--
ALTER TABLE `product_recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1374;

--
-- AUTO_INCREMENT for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipe_items`
--
ALTER TABLE `recipe_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `ID` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1616;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shift_expenses`
--
ALTER TABLE `shift_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_raw_materials`
--
ALTER TABLE `supplier_raw_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_request_items`
--
ALTER TABLE `transfer_request_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendances_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branches_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `branch_creation_requests`
--
ALTER TABLE `branch_creation_requests`
  ADD CONSTRAINT `branch_creation_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branch_creation_requests_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branch_creation_requests_created_branch_id_foreign` FOREIGN KEY (`created_branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branch_creation_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_links`
--
ALTER TABLE `branch_links`
  ADD CONSTRAINT `branch_links_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_links_from_branch_id_foreign` FOREIGN KEY (`from_branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_links_to_branch_id_foreign` FOREIGN KEY (`to_branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_users`
--
ALTER TABLE `branch_users`
  ADD CONSTRAINT `branch_users_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branch_users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_items_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_transfers`
--
ALTER TABLE `cash_transfers`
  ADD CONSTRAINT `cash_transfers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_transfers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_transfers_from_shift_id_foreign` FOREIGN KEY (`from_shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_transfers_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_transfers_to_shift_id_foreign` FOREIGN KEY (`to_shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_transfers_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD CONSTRAINT `delivery_men_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `delivery_men_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dining_areas`
--
ALTER TABLE `dining_areas`
  ADD CONSTRAINT `dining_areas_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dining_areas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods_receipts`
--
ALTER TABLE `goods_receipts`
  ADD CONSTRAINT `goods_receipts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `goods_receipts_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `goods_receipts_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `goods_receipts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods_receipt_items`
--
ALTER TABLE `goods_receipt_items`
  ADD CONSTRAINT `goods_receipt_items_goods_receipt_id_foreign` FOREIGN KEY (`goods_receipt_id`) REFERENCES `goods_receipts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_receipt_items_purchase_order_item_id_foreign` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `goods_receipt_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_receipt_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventories_purchase_unit_id_foreign` FOREIGN KEY (`purchase_unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  ADD CONSTRAINT `inventory_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `inventory_movements_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_movements_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_delivery_man_id_foreign` FOREIGN KEY (`delivery_man_id`) REFERENCES `delivery_men` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_business_type_id_foreign` FOREIGN KEY (`business_type_id`) REFERENCES `business_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `package_features`
--
ALTER TABLE `package_features`
  ADD CONSTRAINT `package_features_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_permissions`
--
ALTER TABLE `package_permissions`
  ADD CONSTRAINT `package_permissions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `production_orders`
--
ALTER TABLE `production_orders`
  ADD CONSTRAINT `production_orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `production_orders_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `production_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_order_items`
--
ALTER TABLE `production_order_items`
  ADD CONSTRAINT `production_order_items_production_order_id_foreign` FOREIGN KEY (`production_order_id`) REFERENCES `production_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_order_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_order_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_recipes`
--
ALTER TABLE `product_recipes`
  ADD CONSTRAINT `product_recipes_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_recipes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_recipes_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_recipes_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  ADD CONSTRAINT `purchase_invoices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_invoices_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  ADD CONSTRAINT `purchase_invoice_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `purchase_invoice_items_purchase_invoice_id_foreign` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_orders_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `purchase_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requests_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD CONSTRAINT `purchase_request_items_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_request_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_request_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD CONSTRAINT `raw_materials_default_supplier_id_foreign` FOREIGN KEY (`default_supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `raw_materials_inventory_category_id_foreign` FOREIGN KEY (`inventory_category_id`) REFERENCES `inventory_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `raw_materials_purchase_unit_id_foreign` FOREIGN KEY (`purchase_unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `raw_materials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_output_raw_material_id_foreign` FOREIGN KEY (`output_raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipes_yield_unit_id_foreign` FOREIGN KEY (`yield_unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recipe_items`
--
ALTER TABLE `recipe_items`
  ADD CONSTRAINT `recipe_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_items_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shifts_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shifts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shift_expenses`
--
ALTER TABLE `shift_expenses`
  ADD CONSTRAINT `shift_expenses_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shift_expenses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shift_expenses_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shift_expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD CONSTRAINT `stock_counts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD CONSTRAINT `stock_count_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_count_items_stock_count_id_foreign` FOREIGN KEY (`stock_count_id`) REFERENCES `stock_counts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_raw_materials`
--
ALTER TABLE `supplier_raw_materials`
  ADD CONSTRAINT `supplier_raw_materials_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_raw_materials_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_raw_materials_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `supplier_raw_materials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tables_dining_area_id_foreign` FOREIGN KEY (`dining_area_id`) REFERENCES `dining_areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD CONSTRAINT `transfer_requests_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transfer_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfer_request_items`
--
ALTER TABLE `transfer_request_items`
  ADD CONSTRAINT `transfer_request_items_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfer_request_items_transfer_request_id_foreign` FOREIGN KEY (`transfer_request_id`) REFERENCES `transfer_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfer_request_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_base_unit_id_foreign` FOREIGN KEY (`base_unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
