-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 12:35 AM
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
-- Database: `u662177682_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` enum('present','absent','late','leave') NOT NULL DEFAULT 'present',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `staff_id`, `shift_id`, `attendance_date`, `check_in`, `check_out`, `status`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
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
  `name` varchar(191) NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
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
(4, 71, 'الفيوم', '66', '01325369874', 'الفيوم المسله', 1, 71, 71, '2026-05-02 10:12:19', '2026-05-02 13:15:14'),
(5, 71, 'الجيزة', '66', '01000000000', 'الجيزة شارع فيصل', 1, 71, 71, '2026-05-21 08:58:58', '2026-05-21 08:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `branch_creation_requests`
--

CREATE TABLE `branch_creation_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(191) NOT NULL,
  `branch_code` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','paid','approved','rejected') NOT NULL DEFAULT 'pending',
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
(3, 71, 71, 'الفيوم', '66', '01325369874', 'الفيوم المسله', 'approved', 2, '2026-05-02 10:12:19', 4, '2026-05-02 09:46:00', '2026-05-02 10:12:19'),
(4, 71, 71, 'الجيزة', '66', '01000000000', 'الجيزة شارع فيصل', 'approved', 2, '2026-05-21 08:58:58', 5, '2026-05-21 08:58:12', '2026-05-21 08:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `branch_links`
--

CREATE TABLE `branch_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `from_branch_id` bigint(20) UNSIGNED NOT NULL,
  `to_branch_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'linked',
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
  `role` varchar(191) NOT NULL DEFAULT 'manager',
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
(6, 4, 97, 'manager', 1, 0, '[\"dashboard.access\",\"emenu.access\",\"categories.access\",\"products.access\",\"sliders.access\"]', 71, '2026-05-02 13:39:29', '2026-05-02 13:39:29'),
(7, 5, 71, 'owner', 1, 1, '[\"*\"]', 2, '2026-05-21 08:58:58', '2026-05-21 08:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
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
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_types`
--

INSERT INTO `business_types` (`id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'مطعم', 'rest', 1, '2026-04-16 19:03:55', '2026-04-16 19:03:55'),
(3, 'محل', 'acc', 1, '2026-04-16 19:04:53', '2026-04-16 21:01:55'),
(5, 'منيو إلكتروني', 'menu', 1, '2026-05-11 07:54:16', '2026-05-11 07:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `business_type_permission_defaults`
--

CREATE TABLE `business_type_permission_defaults` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_type_id` bigint(20) UNSIGNED NOT NULL,
  `permission_key` varchar(120) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_type_permission_defaults`
--

INSERT INTO `business_type_permission_defaults` (`id`, `business_type_id`, `permission_key`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'dashboard.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(2, 2, 'emenu.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(3, 2, 'categories.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(4, 2, 'products.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(5, 2, 'sliders.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(6, 2, 'orders.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(7, 2, 'orders.all', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(8, 2, 'orders.delivery', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(9, 2, 'orders.pickup', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(10, 2, 'orders.local', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(11, 2, 'pos.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(12, 2, 'management.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(13, 2, 'users.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(14, 2, 'roles.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(15, 2, 'branches.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(16, 2, 'branch_creation_request.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(17, 2, 'branch_links.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(18, 2, 'shifts.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(19, 2, 'attendances.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(20, 2, 'cashier-cash-reports.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(21, 2, 'inventory.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(22, 2, 'inventory.dashboard', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(23, 2, 'inventory.suppliers', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(24, 2, 'inventory.categories', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(25, 2, 'units.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(26, 2, 'inventory.materials', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(27, 2, 'inventory.purchase_requests', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(28, 2, 'inventory.purchase_orders', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(29, 2, 'inventory.receipts', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(30, 2, 'inventory.production_orders', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(31, 2, 'inventory.transfer_requests', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(32, 2, 'inventory.stock_counts', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(33, 2, 'inventory.movements', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(34, 2, 'reports.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(35, 2, 'reports.sales', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(36, 2, 'reports.top_products', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(37, 2, 'reports.staff_performance', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(38, 2, 'settings.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(39, 2, 'settings.general', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(40, 2, 'payment_methods.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(41, 2, 'tables_areas.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(42, 2, 'charges.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(43, 3, 'dashboard.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(44, 3, 'categories.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(45, 3, 'products.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(46, 3, 'orders.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(47, 3, 'orders.all', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(48, 3, 'pos.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(49, 3, 'management.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(50, 3, 'users.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(51, 3, 'roles.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(52, 3, 'branches.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(53, 3, 'shifts.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(54, 3, 'attendances.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(55, 3, 'cashier-cash-reports.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(56, 3, 'inventory.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(57, 3, 'inventory.dashboard', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(58, 3, 'inventory.suppliers', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(59, 3, 'inventory.categories', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(60, 3, 'units.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(61, 3, 'inventory.materials', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(62, 3, 'inventory.purchase_requests', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(63, 3, 'inventory.purchase_orders', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(64, 3, 'inventory.receipts', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(65, 3, 'inventory.stock_counts', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(66, 3, 'inventory.movements', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(67, 3, 'reports.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(68, 3, 'reports.sales', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(69, 3, 'reports.top_products', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(70, 3, 'reports.staff_performance', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(71, 3, 'settings.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(72, 3, 'settings.general', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(73, 3, 'payment_methods.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(74, 5, 'dashboard.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(75, 5, 'emenu.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(76, 5, 'categories.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(77, 5, 'products.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(78, 5, 'sliders.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(79, 5, 'orders.access', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(80, 5, 'orders.all', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(81, 5, 'orders.delivery', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(82, 5, 'orders.pickup', 1, '2026-05-11 05:37:30', '2026-05-11 05:37:30'),
(88, 3, 'barcodes.access', 1, '2026-05-11 08:55:48', '2026-05-11 08:57:57'),
(89, 2, 'barcodes.access', 1, '2026-05-11 08:55:48', '2026-05-11 08:57:57'),
(91, 5, 'barcodes.access', 1, '2026-05-11 08:57:57', '2026-05-11 08:57:57'),
(94, 3, 'invoices.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(95, 5, 'invoices.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(96, 2, 'invoices.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(97, 3, 'invoices.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(98, 5, 'invoices.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(99, 2, 'invoices.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(100, 3, 'pos.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(101, 5, 'pos.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(102, 2, 'pos.print', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(103, 3, 'shift_receipts.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(104, 5, 'shift_receipts.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(105, 2, 'shift_receipts.access', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(106, 3, 'orders.returns', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(107, 5, 'orders.returns', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(108, 2, 'orders.returns', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(109, 3, 'orders.update_source', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(110, 5, 'orders.update_source', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(111, 2, 'orders.update_source', 1, '2026-05-11 09:18:01', '2026-05-11 09:18:01'),
(112, 2, 'payment_methods', 1, '2026-05-13 22:59:51', '2026-05-13 22:59:51'),
(113, 3, 'payment_methods', 1, '2026-05-13 22:59:51', '2026-05-13 22:59:51'),
(114, 5, 'payment_methods', 1, '2026-05-13 23:00:44', '2026-05-13 23:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
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
  `type` enum('to_manager','to_next_shift','to_safe') NOT NULL DEFAULT 'to_manager',
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_transfers`
--

INSERT INTO `cash_transfers` (`id`, `from_shift_id`, `to_shift_id`, `branch_id`, `from_user_id`, `to_user_id`, `type`, `amount`, `status`, `approved_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 17, NULL, 1, 71, 71, 'to_manager', 150.00, 'approved', 71, 'تم تسليم مبلغ اثناء الشيفت', '2026-04-26 19:04:36', '2026-04-26 19:04:36'),
(2, 17, 18, 1, 71, 96, 'to_next_shift', 130.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-26 19:22:59', '2026-04-26 19:53:09'),
(5, 18, NULL, 1, 96, 71, 'to_manager', 100.00, 'approved', 96, 'تم', '2026-04-26 20:04:33', '2026-04-26 20:04:33'),
(6, 18, 19, 1, 96, 96, 'to_next_shift', 20.00, 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-04-26 20:05:33', '2026-04-26 20:16:40'),
(7, 19, 21, 1, 96, 71, 'to_next_shift', 20.00, 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-04-26 20:17:01', '2026-04-27 17:18:42'),
(8, 21, 22, 1, 71, 71, 'to_next_shift', 20.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-27 17:19:25', '2026-04-27 17:44:16'),
(9, 22, NULL, 1, 71, 71, 'to_manager', 100.00, 'approved', 71, 'تم', '2026-04-27 17:45:33', '2026-04-27 17:45:33'),
(10, 22, 23, 1, 71, 96, 'to_next_shift', 30.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-04-27 17:45:59', '2026-05-02 13:29:16'),
(11, 23, 24, 1, 96, 96, 'to_next_shift', 30.00, 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 13:29:36', '2026-05-02 13:35:31'),
(12, 24, 25, 1, 96, 96, 'to_next_shift', 30.00, 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 13:37:50', '2026-05-02 14:40:17'),
(13, 25, 26, 1, 96, 71, 'to_next_shift', 30.00, 'approved', 96, 'مبلغ مرحل للشيفت التالي', '2026-05-02 14:41:04', '2026-05-07 05:10:10'),
(14, 26, 27, 1, 71, 71, 'to_next_shift', 30.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-07 05:20:11', '2026-05-07 05:22:30'),
(15, 27, 28, 1, 71, 71, 'to_next_shift', 30.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-07 05:22:57', '2026-05-07 05:43:15'),
(16, 28, 29, 1, 71, 71, 'to_next_shift', 30.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-07 05:43:39', '2026-05-07 05:45:52'),
(17, 29, 30, 1, 71, 71, 'to_next_shift', 180.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-07 09:41:37', '2026-05-07 09:49:29'),
(18, 30, 31, 1, 71, 71, 'to_next_shift', 20.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-08 10:43:16', '2026-05-08 10:46:00'),
(19, 31, 32, 1, 71, 71, 'to_next_shift', 35.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-08 10:54:25', '2026-05-08 10:57:00'),
(20, 32, 33, 1, 71, 71, 'to_next_shift', 235.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-08 11:08:50', '2026-05-10 07:43:04'),
(21, 33, 34, 1, 71, 71, 'to_next_shift', 50.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-10 07:44:50', '2026-05-10 11:36:27'),
(22, 34, 35, 1, 71, 71, 'to_next_shift', 50.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-10 11:39:06', '2026-05-10 11:39:49'),
(23, 35, 36, 1, 71, 71, 'to_next_shift', 50.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-10 12:08:34', '2026-05-10 12:09:15'),
(24, 36, 37, 1, 71, 71, 'to_next_shift', 210.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-10 13:15:00', '2026-05-11 03:28:09'),
(25, 37, 38, 1, 71, 71, 'to_next_shift', 794.50, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-15 17:13:51', '2026-05-15 17:14:46'),
(26, 38, 39, 1, 71, 71, 'to_next_shift', 1094.50, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-15 17:17:35', '2026-05-15 18:38:19'),
(27, 39, 40, 1, 71, 71, 'to_next_shift', 5924.50, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-15 22:02:02', '2026-05-15 22:13:47'),
(28, 40, 41, 1, 71, 71, 'to_next_shift', 5924.50, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-15 22:14:07', '2026-05-16 11:18:46'),
(29, 41, NULL, 1, 71, 71, 'to_manager', 7000.00, 'approved', 71, 'تم تسليم الدير', '2026-05-16 11:24:36', '2026-05-16 11:24:36'),
(30, 41, 42, 1, 71, 71, 'to_next_shift', 9734.50, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-16 11:28:06', '2026-05-16 11:28:38'),
(31, 42, NULL, 1, 71, 71, 'to_manager', 50.00, 'approved', 71, 'مدير', '2026-05-16 11:31:44', '2026-05-16 11:31:44'),
(32, 42, 43, 1, 71, 71, 'to_next_shift', 11000.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-16 11:35:43', '2026-05-16 11:36:02'),
(33, 43, 44, 1, 71, 71, 'to_next_shift', 15190.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-16 11:44:29', '2026-05-16 19:21:16'),
(34, 44, 45, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:10:18', '2026-05-18 11:10:58'),
(35, 45, 46, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:11:27', '2026-05-18 11:13:56'),
(36, 46, 47, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:18:48', '2026-05-18 11:19:44'),
(37, 47, 48, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:20:01', '2026-05-18 11:20:28'),
(38, 48, 49, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:20:42', '2026-05-18 11:23:04'),
(39, 49, 50, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:23:20', '2026-05-18 11:24:36'),
(40, 50, 51, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:25:04', '2026-05-18 11:27:58'),
(41, 51, 52, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:28:13', '2026-05-18 11:31:29'),
(42, 52, 53, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:35:58', '2026-05-18 11:42:38'),
(43, 53, 54, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:42:56', '2026-05-18 11:45:33'),
(44, 54, 55, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:45:51', '2026-05-18 11:46:23'),
(45, 55, 56, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:46:41', '2026-05-18 11:47:11'),
(46, 56, 57, 1, 71, 71, 'to_next_shift', 1080.00, 'approved', 71, 'مبلغ مرحل للشيفت التالي', '2026-05-18 11:47:28', '2026-05-20 07:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'menu',
  `cover` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `user_id`, `name`, `type`, `cover`, `created_at`, `updated_at`, `is_active`, `store_id`) VALUES
(12, 129, 79, 'برجر', 'menu', '1755003614.jpg', '2025-08-12 13:00:14', '2025-08-12 13:00:14', 1, NULL),
(13, 128, 79, 'بيتزا', 'menu', '1755003964.jpg', '2025-08-12 13:06:04', '2025-08-12 13:06:04', 1, NULL),
(24, NULL, 8, 'testtttt', 'menu', 'images/category/kUlBBgDALaCIjjO7kcbV4rTA2yHt8eKrlyk2vvHm.png', '2025-08-31 09:07:34', '2025-08-31 09:07:34', 1, NULL),
(30, NULL, 48, 'محاشي', 'menu', 'images/category/bZRrLj3zcUC0NRmnfpV04nFOWBciL3UK0zanlzgK.png', '2025-09-01 10:54:42', '2025-09-01 10:54:42', 1, NULL),
(31, NULL, 48, 'مخاصي', 'menu', 'images/category/1AfTbMBuKyPoIdAFOmS8lcPjJ1WwMKHaTvDSILpU.png', '2025-09-01 10:55:11', '2025-09-01 10:55:11', 1, NULL),
(32, NULL, 48, 'مشاوي', 'menu', 'images/category/2oBBrnmYIEohMXJarNHA3hmhFawgUCitbGv0CQdI.jpg', '2025-09-01 10:55:36', '2025-09-01 10:55:36', 1, NULL),
(33, NULL, 48, 'مبايض', 'menu', 'images/category/kMJQEJQh3m0PGX672owb7u4XiT88YBS5NYPHuoTh.avif', '2025-09-01 10:56:06', '2025-09-01 10:56:06', 1, NULL),
(34, NULL, 50, 'Fast Food', 'menu', 'images/category/5jRRvUpfk39eqGYWhEGwaAlKXcoMF5AVELafm197.png', '2025-09-03 15:22:21', '2025-09-03 15:22:21', 1, NULL),
(88, NULL, 79, 'عطور', 'menu', 'images/category/rlOAcW1bU72pxFO6MjxxWYLLuFsR3wlRBFdw2ltY.jpg', '2025-12-02 21:18:56', '2025-12-02 21:19:22', 1, NULL),
(89, 108, 71, 'مطعم نانو', 'menu', 'images/category/dv2G9HTk5mHRaOPL9YvX1tSJKNhVTV8K3sD959WM.jpg', '2025-12-03 15:23:12', '2026-05-10 06:39:21', 1, NULL),
(90, NULL, 71, 'عصاير نانو', 'menu', 'images/category/mmQPqucFoNfRi3xeYCyhV39ZzXw91ldcXgA4fr4X.jpg', '2025-12-04 20:00:06', '2025-12-04 20:09:59', 1, NULL),
(91, NULL, 71, 'كافي نانو', 'menu', 'images/category/DDybS0dJHavvQvEYcGeBXhezorIoijEt29FYXUzo.jpg', '2025-12-04 20:12:50', '2025-12-04 20:12:50', 1, NULL),
(92, NULL, 71, 'عطور نانو', 'menu', 'images/category/TgP8FhdwMKbDS2MJMNtth4KIhmROYbi9Nno0kDQz.png', '2025-12-04 20:22:39', '2025-12-04 20:22:39', 1, NULL),
(93, NULL, 80, 'Beef Burger', 'menu', 'images/category/h2p46eYHAYYvL5YRRKBaycIPiae68jaiiGhZvkxf.jpg', '2025-12-08 17:09:53', '2025-12-08 17:09:53', 1, NULL),
(94, NULL, 80, 'smash burger', 'menu', 'images/category/QUK5sAcvmflOMkwiwibv219bE0zp2AJImBww000q.jpg', '2025-12-08 17:10:59', '2025-12-08 17:10:59', 1, NULL),
(95, NULL, 80, 'chicken burger', 'menu', 'images/category/cXoCqkXTJ4HAB2yR7rU0EA4F9ur1x2IXkjJoEpPU.jpg', '2025-12-08 17:11:39', '2025-12-08 17:11:39', 1, NULL),
(96, NULL, 80, 'appetizers', 'menu', 'images/category/rgXJwMWHZN5Jlc0sS0toGDidTVVwYUkGGiDYGFKd.jpg', '2025-12-08 17:13:06', '2025-12-08 17:13:06', 1, NULL),
(97, NULL, 80, 'السندوتشات', 'menu', 'images/category/B1SolZ3YF3H2DKEsviSWf1SQ5vKTJuzmAPYtjjHF.jpg', '2025-12-08 17:14:38', '2025-12-29 20:20:52', 1, NULL),
(98, NULL, 80, 'الكريبات', 'menu', 'images/category/JpgPtQFRS1JeXpRxMCrUVhDgSPEexfB1LYnYLoRl.jpg', '2025-12-08 17:15:30', '2025-12-08 17:15:30', 1, NULL),
(100, NULL, 80, 'الاضافات', 'menu', 'images/category/OlCJ1xLooha2akbyFDQr4MBFLfFaak5tB83oPYJ8.jpg', '2025-12-08 17:44:31', '2025-12-08 17:44:31', 1, NULL),
(101, NULL, 80, 'المشروبات', 'menu', 'images/category/B6qJx0jZFWAy6FT4WmiIr6uEa8OrZJBjTQxk8Z2M.jpg', '2025-12-08 17:45:08', '2025-12-08 17:45:08', 1, NULL),
(103, NULL, 71, 'سجاد نانو', 'menu', 'images/category/93BWbbKwSu2rwwQuZN5f3SvwLezaekV57KDCc3Rp.jpg', '2025-12-09 10:39:32', '2025-12-09 10:39:32', 1, NULL),
(105, NULL, 71, 'ورد نانو', 'menu', 'images/category/hRuBQMcT2TNJs73TYqO2qyXHTwHkOqia4mDcfhVW.jpg', '2025-12-09 10:40:32', '2025-12-09 10:40:32', 1, NULL),
(106, NULL, 71, 'ذهب نانو', 'menu', 'images/category/o8WOs5g25LeCFaY3uYCrVV1zL3Ich6YGtCX1J3ik.jpg', '2025-12-09 10:42:19', '2025-12-09 10:42:19', 1, NULL),
(108, NULL, 71, 'ادوات منزليه نانو22', 'menu', 'images/category/DVROgWF3B3oYVKKxLo1mefaw7LOYVfBR5VTvuncw.jpg', '2025-12-09 10:43:21', '2026-04-11 16:58:42', 1, NULL),
(109, NULL, 84, 'القسم الغربي', 'menu', 'images/category/SRwVHd4qtPyzffl0kkxocBu1NzncmSxf6UOJNTCS.jpg', '2025-12-09 13:02:23', '2025-12-09 13:09:55', 1, NULL),
(110, NULL, 84, 'الوجبات الغربي', 'menu', 'images/category/VYiw1Ibo1Y2oHQrUsvAdYxBNiakEezvBZ5ILPGCo.jpg', '2025-12-09 13:07:29', '2025-12-09 13:07:29', 1, NULL),
(111, NULL, 84, 'قسم الشاورما', 'menu', 'images/category/nl6f4GyaQjMM9ROw1zJlSifDG1vzZSNLRuXyR4Bw.jpg', '2025-12-09 13:11:47', '2025-12-09 13:11:47', 1, NULL),
(112, NULL, 84, 'قسم الشوايه', 'menu', 'images/category/WWVR2xRe6LPRYpODrah8BRdtt8VQ0gVKuKouOWol.jpg', '2025-12-09 13:13:33', '2025-12-09 13:13:33', 1, NULL),
(113, NULL, 84, 'بروستيد جريل', 'menu', 'images/category/9CtP7kuv5NfWiqqxWLje6NcxyXdY2xgnY74q7bSH.jpg', '2025-12-09 13:17:23', '2025-12-09 13:17:23', 1, NULL),
(114, NULL, 84, 'المقبلات', 'menu', 'images/category/CQujgTygByK0qg66vxL8Mhl6sm7cz0juqZ5M51UT.jpg', '2025-12-09 13:19:13', '2025-12-09 13:19:13', 1, NULL),
(115, NULL, 81, 'قسم الساعات', 'menu', 'images/category/gtsMMmD1AxN6Rsb5k7dMFCI2P8Uv9EKBSuhYrHgR.jpg', '2025-12-09 15:55:28', '2025-12-09 15:55:28', 1, NULL),
(116, NULL, 81, 'قسم البرفيوم', 'menu', 'images/category/xFK0l7Xvj3CyMEWYW5F1BkKoKYPGtrl8q2XBrVXW.jpg', '2025-12-09 15:57:50', '2025-12-09 15:57:50', 1, NULL),
(117, NULL, 81, 'قسم المحافظ', 'menu', 'images/category/kHVN1jxKcYTdTC6jhhsRpagIxbufzgShlE1XebZn.jpg', '2025-12-09 15:58:22', '2025-12-09 15:58:22', 1, NULL),
(118, NULL, 81, 'قسم مكن الكهرباء', 'menu', 'images/category/o0qHn4tm5iMil7yeIY6xrYkPXlX4MsKSt9K8GfQz.jpg', '2025-12-09 15:59:57', '2025-12-09 15:59:57', 1, NULL),
(119, NULL, 81, 'النظارات الشمسيه', 'menu', 'images/category/OQy1S0Uc63QJNKJNTZ2IlYjJbXeSCzzurB9m0jDK.jpg', '2025-12-09 17:14:30', '2025-12-09 17:14:30', 1, NULL),
(120, NULL, 85, 'standard', 'menu', 'images/category/ANgZHvGDAHtyyRjMNue3vh3GmWOXaTGDs2G6pThG.png', '2025-12-11 18:05:02', '2025-12-11 18:06:03', 1, NULL),
(121, NULL, 85, 'Primum', 'menu', 'images/category/Ypk7vI064KngZJKbSBA6Kk70IWj1SKsHG4e6bhxW.png', '2025-12-11 18:05:27', '2025-12-11 18:05:27', 1, NULL),
(122, NULL, 85, 'Basic', 'menu', 'images/category/4YvFFQVcbj0OpCTdz7YtFE3ciDuCUiEDuJokF7Kf.png', '2025-12-11 18:06:28', '2025-12-11 18:06:28', 1, NULL),
(123, NULL, 86, 'chicken meels', 'menu', 'images/category/kF0w83rmOZ0SlZXq3e8E0hXrV9JZqJUh1wyN60BS.jpg', '2025-12-13 16:16:45', '2025-12-13 16:16:45', 1, NULL),
(124, NULL, 86, 'Single Meals', 'menu', 'images/category/j3mtBBuVp77XBwDDky8nX1OdXW2Ohextu4yI5Azn.jpg', '2025-12-13 16:36:29', '2025-12-13 16:36:29', 1, NULL),
(125, NULL, 86, 'Kids Meals', 'menu', 'images/category/luCvPdVKmiRK4dt53P7A08FwA9820VIEriWLL2bc.jpg', '2025-12-13 16:37:18', '2025-12-13 16:37:18', 1, NULL),
(126, NULL, 86, 'Chicken Sandwich', 'menu', 'images/category/AdTLQELJQ6jYjxPjJcBS9FVX8wV9uRr8pynq93yh.jpg', '2025-12-13 16:38:08', '2025-12-13 16:38:08', 1, NULL),
(127, NULL, 86, 'Beef Sandwich', 'menu', 'images/category/qTyYDYdq0we4YJ7wGFBAsLVxhChxoxWnv2BNXuEy.jpg', '2025-12-13 16:40:16', '2025-12-13 16:40:16', 1, NULL),
(128, NULL, 86, 'APPETIZER', 'menu', 'images/category/mAvH6SD7MZK4z4h8UbRV4o3StEYdAIuXXzTN27Fn.jpg', '2025-12-13 16:42:19', '2025-12-13 16:42:19', 1, NULL),
(129, NULL, 86, 'Adds', 'menu', 'images/category/B9sCPt2QwZtgih7CTZRrChSAMFLj4FZ0jG72bfb7.jpg', '2025-12-13 16:42:44', '2025-12-13 16:42:44', 1, NULL),
(130, NULL, 86, 'Drinks', 'menu', 'images/category/JKZgztceNiPINQhBEkLER8Whc3fnr6njGUb0HccX.jpg', '2025-12-13 16:43:09', '2025-12-13 16:43:09', 1, NULL),
(131, NULL, 87, 'وجبات بالكيلو', 'menu', 'images/category/4lt43ZGnMSPWMc75UQVspDP7fFPbvGqaqiwAAZUJ.png', '2025-12-15 17:59:45', '2025-12-15 17:59:45', 1, NULL),
(132, NULL, 87, 'وجبات الوحيد', 'menu', 'images/category/G5mfpkN5A8YWR64Z7jOlk4Ep9B0L0NKqVNOU8Lb1.png', '2025-12-15 18:00:54', '2025-12-15 18:00:54', 1, NULL),
(133, NULL, 87, 'سندوتشات', 'menu', 'images/category/rM850p0yroTGKqfO4UHJ2YtstDh5pQ8aiRxHVLZ6.png', '2025-12-15 18:01:44', '2025-12-15 18:01:44', 1, NULL),
(159, NULL, 71, 'بن ساده', 'menu', 'images/category/r8ExPwG0RJfrQokAYkoPvfG34Aw1DRB2HNV5TZpf.jpg', '2026-04-11 16:57:37', '2026-04-11 16:57:37', 1, NULL),
(160, NULL, 71, 'لحوم', 'internal', 'cWymDbyVIurzpvZyzrZsApdh9QtqN8cR2pxG4mkl.jpg', '2026-04-18 19:03:00', '2026-04-18 19:03:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chargeables`
--

CREATE TABLE `chargeables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `charge_id` bigint(20) UNSIGNED NOT NULL,
  `chargeable_type` varchar(191) NOT NULL,
  `chargeable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `classification` enum('tax','fee') NOT NULL DEFAULT 'tax',
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(8,2) NOT NULL,
  `is_inclusive` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(191) DEFAULT NULL,
  `applicable_order_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_order_types`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `user_id`, `name`, `classification`, `type`, `value`, `is_inclusive`, `is_active`, `description`, `applicable_order_types`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 71, 'ضريبة توصيل', 'tax', 'percentage', 10.00, 0, 0, NULL, NULL, '2026-05-20 11:06:02', '2026-05-20 11:30:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 71, 'عبدالرحمن احمد', '+2020150837340', '2026-01-21 06:25:52', '2026-01-21 06:25:52'),
(2, 71, 'test', '+201508373405', '2026-01-26 01:23:21', '2026-01-26 01:23:21'),
(3, 71, 'b', '+201200860222', '2026-05-07 08:23:46', '2026-05-07 08:23:46'),
(4, 71, 'أحمد تجربة', '+201012345678', '2026-05-14 17:59:51', '2026-05-14 17:59:51'),
(5, 71, 'Test Order', '+201000000000', '2026-05-15 09:40:19', '2026-05-15 09:40:19'),
(6, 71, 'حسام', '+2010929517374155', '2026-05-17 06:38:19', '2026-05-17 06:38:19'),
(7, 71, 'محمود محمود', '+2010929517345', '2026-05-17 11:11:30', '2026-05-17 11:11:30'),
(8, 71, 'ششششششش', '+201092951734', '2026-05-17 11:33:50', '2026-05-17 11:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `commission_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_men`
--

INSERT INTO `delivery_men` (`id`, `user_id`, `name`, `phone`, `commission_percent`, `is_active`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 95, 'احمد', '01236589745', 5.00, 1, '2026-05-07 11:53:29', '2026-05-07 11:53:29', 1),
(2, 71, 'محمد محمد', '01236589741', 10.00, 1, '2026-05-13 19:19:03', '2026-05-23 17:47:28', NULL),
(3, 71, 'على على', '01425368974', 6.00, 1, '2026-05-13 19:29:54', '2026-05-13 19:29:54', NULL),
(4, 71, 'علاء علاء', '01345789623', 6.00, 1, '2026-05-15 11:52:20', '2026-05-23 17:48:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dining_areas`
--

CREATE TABLE `dining_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `TITLE` varchar(191) NOT NULL,
  `Amount` decimal(10,2) DEFAULT 0.00,
  `Notes` text DEFAULT NULL,
  `attach_File` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `TITLE`, `Amount`, `Notes`, `attach_File`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'توريد', 1526.00, 'مصروفات شهر مايو', '1779527126.jpeg', 71, '2026-05-23 06:05:26', '2026-05-23 06:05:26'),
(2, 'صيانه', 9555.00, 'صيانه المطبخ', '1779527164.jpeg', 71, '2026-05-23 06:06:04', '2026-05-23 06:06:04');

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
-- Table structure for table `goods_receipts`
--

CREATE TABLE `goods_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_number` varchar(191) NOT NULL,
  `receipt_date` date NOT NULL,
  `status` enum('draft','posted','cancelled') NOT NULL DEFAULT 'posted',
  `subtotal` decimal(14,3) NOT NULL DEFAULT 0.000,
  `discount` decimal(14,3) NOT NULL DEFAULT 0.000,
  `tax` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goods_receipts`
--

INSERT INTO `goods_receipts` (`id`, `user_id`, `purchase_order_id`, `supplier_id`, `receipt_number`, `receipt_date`, `status`, `subtotal`, `discount`, `tax`, `total`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 1, 'GR-20260419001615', '2026-04-19', 'posted', 999.000, 10.000, 10.000, 999.000, 'dddddddd', '2026-04-18 22:16:15', '2026-04-18 22:16:22', NULL);

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
(1, 1, 1, 1, 1, 3.000, 333.000, 999.000, '2026-04-18 22:16:15', '2026-04-18 22:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `inventoriable_type` varchar(191) NOT NULL,
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
(1, 71, 'App\\Models\\RawMaterial', 1, 333.00, 1, 9.000, 333.000, 222.000, 5.000, 55.000, 53.000, 1, '2026-04-18 21:07:03', '2026-04-19 22:32:40', NULL),
(2, 71, 'App\\Models\\RawMaterial', 2, 77.00, 1, 15.000, 50.000, 50.000, 10.000, 10.000, 10.000, 1, '2026-04-20 05:35:25', '2026-05-21 08:01:02', NULL),
(3, 71, 'App\\Models\\RawMaterial', 3, 55.00, 1, 1.000, 66.000, 222.000, 2.000, 2.000, 2.000, 1, '2026-04-24 09:21:48', '2026-05-12 18:37:22', NULL),
(4, 79, 'App\\Models\\Product', 9, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(5, 79, 'App\\Models\\Product', 10, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(6, 79, 'App\\Models\\Product', 11, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(7, 79, 'App\\Models\\Product', 12, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(8, 79, 'App\\Models\\Product', 13, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(9, 79, 'App\\Models\\Product', 14, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(10, 79, 'App\\Models\\Product', 15, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(11, 79, 'App\\Models\\Product', 16, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(12, 79, 'App\\Models\\Product', 17, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(13, 79, 'App\\Models\\Product', 18, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(14, 79, 'App\\Models\\Product', 21, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(15, 79, 'App\\Models\\Product', 22, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(16, 79, 'App\\Models\\Product', 26, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(17, 79, 'App\\Models\\Product', 27, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(18, 79, 'App\\Models\\Product', 53, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(19, 79, 'App\\Models\\Product', 55, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(20, 79, 'App\\Models\\Product', 57, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(21, 79, 'App\\Models\\Product', 272, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(22, 79, 'App\\Models\\Product', 273, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(23, 79, 'App\\Models\\Product', 274, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(24, 79, 'App\\Models\\Product', 275, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(25, 79, 'App\\Models\\Product', 276, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(26, 71, 'App\\Models\\Product', 278, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(27, 79, 'App\\Models\\Product', 279, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(28, 71, 'App\\Models\\Product', 280, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(29, 71, 'App\\Models\\Product', 281, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(30, 71, 'App\\Models\\Product', 282, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(31, 71, 'App\\Models\\Product', 283, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(32, 71, 'App\\Models\\Product', 284, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(33, 71, 'App\\Models\\Product', 285, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(34, 71, 'App\\Models\\Product', 286, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(35, 71, 'App\\Models\\Product', 287, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(36, 71, 'App\\Models\\Product', 288, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(37, 71, 'App\\Models\\Product', 289, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(38, 71, 'App\\Models\\Product', 290, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(39, 71, 'App\\Models\\Product', 291, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(40, 71, 'App\\Models\\Product', 293, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(41, 71, 'App\\Models\\Product', 294, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(42, 71, 'App\\Models\\Product', 295, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(43, 71, 'App\\Models\\Product', 296, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(44, 71, 'App\\Models\\Product', 297, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(45, 80, 'App\\Models\\Product', 298, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(46, 80, 'App\\Models\\Product', 299, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(47, 80, 'App\\Models\\Product', 300, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(48, 80, 'App\\Models\\Product', 301, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(49, 80, 'App\\Models\\Product', 302, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(50, 80, 'App\\Models\\Product', 303, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(51, 80, 'App\\Models\\Product', 304, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(52, 80, 'App\\Models\\Product', 305, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(53, 80, 'App\\Models\\Product', 306, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(54, 80, 'App\\Models\\Product', 307, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(55, 80, 'App\\Models\\Product', 308, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(56, 80, 'App\\Models\\Product', 309, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(57, 80, 'App\\Models\\Product', 311, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(58, 80, 'App\\Models\\Product', 312, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(59, 80, 'App\\Models\\Product', 313, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(60, 80, 'App\\Models\\Product', 314, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(61, 80, 'App\\Models\\Product', 315, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(62, 80, 'App\\Models\\Product', 316, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(63, 80, 'App\\Models\\Product', 317, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(64, 80, 'App\\Models\\Product', 318, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(65, 80, 'App\\Models\\Product', 319, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(66, 80, 'App\\Models\\Product', 320, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(67, 80, 'App\\Models\\Product', 321, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(68, 80, 'App\\Models\\Product', 322, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(69, 80, 'App\\Models\\Product', 323, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(70, 80, 'App\\Models\\Product', 324, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(71, 80, 'App\\Models\\Product', 325, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(72, 80, 'App\\Models\\Product', 326, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(73, 80, 'App\\Models\\Product', 328, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(74, 80, 'App\\Models\\Product', 330, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(75, 80, 'App\\Models\\Product', 332, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:49', '2026-05-12 17:53:49', NULL),
(76, 80, 'App\\Models\\Product', 333, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(77, 80, 'App\\Models\\Product', 334, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(78, 80, 'App\\Models\\Product', 335, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(79, 80, 'App\\Models\\Product', 336, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(80, 80, 'App\\Models\\Product', 337, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(81, 80, 'App\\Models\\Product', 338, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(82, 80, 'App\\Models\\Product', 339, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(83, 80, 'App\\Models\\Product', 340, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(84, 80, 'App\\Models\\Product', 341, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(85, 80, 'App\\Models\\Product', 342, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(86, 80, 'App\\Models\\Product', 343, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(87, 80, 'App\\Models\\Product', 344, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(88, 80, 'App\\Models\\Product', 345, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(89, 80, 'App\\Models\\Product', 346, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(90, 80, 'App\\Models\\Product', 347, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(91, 80, 'App\\Models\\Product', 348, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(92, 80, 'App\\Models\\Product', 349, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(93, 80, 'App\\Models\\Product', 350, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(94, 80, 'App\\Models\\Product', 351, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(95, 80, 'App\\Models\\Product', 352, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(96, 80, 'App\\Models\\Product', 353, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(97, 80, 'App\\Models\\Product', 354, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(98, 71, 'App\\Models\\Product', 356, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(99, 71, 'App\\Models\\Product', 357, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(100, 71, 'App\\Models\\Product', 358, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(101, 71, 'App\\Models\\Product', 359, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(102, 71, 'App\\Models\\Product', 360, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(103, 71, 'App\\Models\\Product', 361, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(104, 71, 'App\\Models\\Product', 362, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(105, 71, 'App\\Models\\Product', 363, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(106, 71, 'App\\Models\\Product', 364, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(107, 71, 'App\\Models\\Product', 365, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(108, 71, 'App\\Models\\Product', 366, 500.00, NULL, 111.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 18:45:11', NULL),
(109, 71, 'App\\Models\\Product', 367, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(110, 71, 'App\\Models\\Product', 368, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(111, 71, 'App\\Models\\Product', 369, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(112, 71, 'App\\Models\\Product', 370, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(113, 71, 'App\\Models\\Product', 371, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(114, 71, 'App\\Models\\Product', 376, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(115, 71, 'App\\Models\\Product', 377, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(116, 71, 'App\\Models\\Product', 378, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(117, 71, 'App\\Models\\Product', 379, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(118, 71, 'App\\Models\\Product', 380, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(119, 84, 'App\\Models\\Product', 381, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(120, 84, 'App\\Models\\Product', 382, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(121, 84, 'App\\Models\\Product', 383, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(122, 84, 'App\\Models\\Product', 384, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(123, 84, 'App\\Models\\Product', 385, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(124, 84, 'App\\Models\\Product', 386, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(125, 84, 'App\\Models\\Product', 387, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(126, 84, 'App\\Models\\Product', 388, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(127, 84, 'App\\Models\\Product', 389, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(128, 84, 'App\\Models\\Product', 390, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(129, 84, 'App\\Models\\Product', 391, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(130, 84, 'App\\Models\\Product', 392, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(131, 84, 'App\\Models\\Product', 393, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(132, 84, 'App\\Models\\Product', 394, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(133, 84, 'App\\Models\\Product', 395, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(134, 84, 'App\\Models\\Product', 396, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(135, 84, 'App\\Models\\Product', 397, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(136, 84, 'App\\Models\\Product', 398, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(137, 84, 'App\\Models\\Product', 399, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(138, 84, 'App\\Models\\Product', 400, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(139, 84, 'App\\Models\\Product', 401, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(140, 84, 'App\\Models\\Product', 402, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(141, 84, 'App\\Models\\Product', 403, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(142, 84, 'App\\Models\\Product', 404, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(143, 84, 'App\\Models\\Product', 405, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(144, 84, 'App\\Models\\Product', 406, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(145, 84, 'App\\Models\\Product', 407, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(146, 84, 'App\\Models\\Product', 408, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(147, 84, 'App\\Models\\Product', 409, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(148, 84, 'App\\Models\\Product', 410, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(149, 84, 'App\\Models\\Product', 411, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(150, 84, 'App\\Models\\Product', 412, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(151, 84, 'App\\Models\\Product', 413, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(152, 84, 'App\\Models\\Product', 414, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(153, 84, 'App\\Models\\Product', 415, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(154, 84, 'App\\Models\\Product', 416, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(155, 84, 'App\\Models\\Product', 417, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(156, 84, 'App\\Models\\Product', 418, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(157, 84, 'App\\Models\\Product', 419, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(158, 84, 'App\\Models\\Product', 420, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(159, 84, 'App\\Models\\Product', 421, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(160, 84, 'App\\Models\\Product', 422, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(161, 84, 'App\\Models\\Product', 423, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(162, 84, 'App\\Models\\Product', 424, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(163, 84, 'App\\Models\\Product', 425, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(164, 84, 'App\\Models\\Product', 426, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(165, 84, 'App\\Models\\Product', 427, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(166, 84, 'App\\Models\\Product', 428, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(167, 81, 'App\\Models\\Product', 429, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(168, 81, 'App\\Models\\Product', 430, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(169, 81, 'App\\Models\\Product', 431, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(170, 81, 'App\\Models\\Product', 432, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(171, 81, 'App\\Models\\Product', 433, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(172, 81, 'App\\Models\\Product', 434, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(173, 81, 'App\\Models\\Product', 435, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(174, 81, 'App\\Models\\Product', 436, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(175, 81, 'App\\Models\\Product', 437, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(176, 81, 'App\\Models\\Product', 438, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(177, 81, 'App\\Models\\Product', 439, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(178, 81, 'App\\Models\\Product', 440, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(179, 81, 'App\\Models\\Product', 441, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(180, 81, 'App\\Models\\Product', 442, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(181, 81, 'App\\Models\\Product', 443, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(182, 81, 'App\\Models\\Product', 444, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(183, 81, 'App\\Models\\Product', 445, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(184, 81, 'App\\Models\\Product', 446, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(185, 81, 'App\\Models\\Product', 447, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(186, 81, 'App\\Models\\Product', 448, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(187, 81, 'App\\Models\\Product', 449, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(188, 81, 'App\\Models\\Product', 450, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(189, 81, 'App\\Models\\Product', 451, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(190, 81, 'App\\Models\\Product', 452, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(191, 81, 'App\\Models\\Product', 453, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(192, 81, 'App\\Models\\Product', 454, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(193, 81, 'App\\Models\\Product', 455, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(194, 81, 'App\\Models\\Product', 456, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(195, 81, 'App\\Models\\Product', 457, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(196, 81, 'App\\Models\\Product', 458, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(197, 81, 'App\\Models\\Product', 459, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(198, 81, 'App\\Models\\Product', 460, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(199, 81, 'App\\Models\\Product', 461, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(200, 81, 'App\\Models\\Product', 462, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(201, 81, 'App\\Models\\Product', 463, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(202, 81, 'App\\Models\\Product', 464, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(203, 81, 'App\\Models\\Product', 465, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(204, 81, 'App\\Models\\Product', 466, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(205, 81, 'App\\Models\\Product', 467, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(206, 81, 'App\\Models\\Product', 468, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(207, 81, 'App\\Models\\Product', 469, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(208, 81, 'App\\Models\\Product', 470, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(209, 81, 'App\\Models\\Product', 471, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(210, 81, 'App\\Models\\Product', 472, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(211, 81, 'App\\Models\\Product', 473, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(212, 81, 'App\\Models\\Product', 474, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(213, 81, 'App\\Models\\Product', 475, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(214, 81, 'App\\Models\\Product', 476, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(215, 81, 'App\\Models\\Product', 477, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(216, 81, 'App\\Models\\Product', 478, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(217, 81, 'App\\Models\\Product', 479, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(218, 81, 'App\\Models\\Product', 480, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(219, 81, 'App\\Models\\Product', 481, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(220, 81, 'App\\Models\\Product', 482, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(221, 81, 'App\\Models\\Product', 483, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(222, 81, 'App\\Models\\Product', 484, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(223, 81, 'App\\Models\\Product', 485, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(224, 81, 'App\\Models\\Product', 486, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(225, 81, 'App\\Models\\Product', 487, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(226, 79, 'App\\Models\\Product', 488, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:50', '2026-05-12 17:53:50', NULL),
(227, 79, 'App\\Models\\Product', 489, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(228, 79, 'App\\Models\\Product', 490, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(229, 79, 'App\\Models\\Product', 491, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(230, 79, 'App\\Models\\Product', 492, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(231, 79, 'App\\Models\\Product', 493, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(232, 79, 'App\\Models\\Product', 494, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(233, 79, 'App\\Models\\Product', 495, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(234, 86, 'App\\Models\\Product', 496, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(235, 86, 'App\\Models\\Product', 497, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(236, 86, 'App\\Models\\Product', 498, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(237, 86, 'App\\Models\\Product', 499, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(238, 86, 'App\\Models\\Product', 500, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(239, 86, 'App\\Models\\Product', 501, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(240, 86, 'App\\Models\\Product', 502, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(241, 86, 'App\\Models\\Product', 503, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(242, 86, 'App\\Models\\Product', 504, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(243, 86, 'App\\Models\\Product', 505, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(244, 86, 'App\\Models\\Product', 506, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(245, 86, 'App\\Models\\Product', 507, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(246, 86, 'App\\Models\\Product', 508, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(247, 86, 'App\\Models\\Product', 509, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(248, 86, 'App\\Models\\Product', 510, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(249, 86, 'App\\Models\\Product', 511, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(250, 86, 'App\\Models\\Product', 512, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(251, 86, 'App\\Models\\Product', 513, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(252, 86, 'App\\Models\\Product', 514, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(253, 86, 'App\\Models\\Product', 515, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(254, 86, 'App\\Models\\Product', 516, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(255, 86, 'App\\Models\\Product', 517, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(256, 86, 'App\\Models\\Product', 518, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(257, 86, 'App\\Models\\Product', 519, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(258, 86, 'App\\Models\\Product', 520, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(259, 86, 'App\\Models\\Product', 521, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(260, 86, 'App\\Models\\Product', 522, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(261, 86, 'App\\Models\\Product', 523, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(262, 86, 'App\\Models\\Product', 524, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(263, 86, 'App\\Models\\Product', 525, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(264, 86, 'App\\Models\\Product', 526, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(265, 86, 'App\\Models\\Product', 527, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(266, 86, 'App\\Models\\Product', 528, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(267, 86, 'App\\Models\\Product', 529, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(268, 86, 'App\\Models\\Product', 530, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(269, 86, 'App\\Models\\Product', 531, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(270, 86, 'App\\Models\\Product', 532, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(271, 86, 'App\\Models\\Product', 533, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(272, 86, 'App\\Models\\Product', 534, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(273, 86, 'App\\Models\\Product', 535, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(274, 86, 'App\\Models\\Product', 536, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(275, 86, 'App\\Models\\Product', 537, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(276, 86, 'App\\Models\\Product', 538, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(277, 86, 'App\\Models\\Product', 539, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(278, 86, 'App\\Models\\Product', 540, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(279, 86, 'App\\Models\\Product', 541, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(280, 86, 'App\\Models\\Product', 542, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(281, 86, 'App\\Models\\Product', 543, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(282, 86, 'App\\Models\\Product', 544, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(283, 86, 'App\\Models\\Product', 545, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(284, 86, 'App\\Models\\Product', 546, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(285, 86, 'App\\Models\\Product', 547, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(286, 86, 'App\\Models\\Product', 548, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(287, 86, 'App\\Models\\Product', 549, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(288, 86, 'App\\Models\\Product', 550, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(289, 86, 'App\\Models\\Product', 551, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(290, 86, 'App\\Models\\Product', 552, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(291, 86, 'App\\Models\\Product', 553, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(292, 86, 'App\\Models\\Product', 554, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(293, 86, 'App\\Models\\Product', 555, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(294, 86, 'App\\Models\\Product', 556, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(295, 86, 'App\\Models\\Product', 557, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(296, 86, 'App\\Models\\Product', 558, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(297, 86, 'App\\Models\\Product', 559, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(298, 85, 'App\\Models\\Product', 560, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(299, 87, 'App\\Models\\Product', 561, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(300, 87, 'App\\Models\\Product', 562, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(301, 87, 'App\\Models\\Product', 563, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(302, 87, 'App\\Models\\Product', 564, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(303, 87, 'App\\Models\\Product', 565, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(304, 87, 'App\\Models\\Product', 566, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(305, 87, 'App\\Models\\Product', 567, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(306, 87, 'App\\Models\\Product', 568, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(307, 87, 'App\\Models\\Product', 569, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(308, 87, 'App\\Models\\Product', 570, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(309, 87, 'App\\Models\\Product', 571, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(310, 87, 'App\\Models\\Product', 572, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(311, 87, 'App\\Models\\Product', 573, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(312, 87, 'App\\Models\\Product', 574, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(313, 87, 'App\\Models\\Product', 575, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(314, 87, 'App\\Models\\Product', 576, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(315, 87, 'App\\Models\\Product', 577, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(316, 87, 'App\\Models\\Product', 578, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(317, 87, 'App\\Models\\Product', 579, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(318, 87, 'App\\Models\\Product', 580, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(319, 87, 'App\\Models\\Product', 581, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(320, 79, 'App\\Models\\Product', 770, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(321, 79, 'App\\Models\\Product', 771, 0.00, NULL, 0.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 17:53:51', NULL),
(322, 71, 'App\\Models\\Product', 772, 146.99, NULL, 10.000, 0.000, 0.000, NULL, NULL, NULL, 1, '2026-05-12 17:53:51', '2026-05-12 18:25:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_categories`
--

CREATE TABLE `inventory_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(191) DEFAULT NULL,
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
  `type` enum('purchase','sale','waste','adjustment','transfer_out','transfer_in','production_in','production_out') NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_before` decimal(15,3) NOT NULL,
  `balance_after` decimal(15,3) NOT NULL,
  `description` text DEFAULT NULL,
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `reference_type` varchar(191) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `movement_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_movements`
--

INSERT INTO `inventory_movements` (`id`, `user_id`, `inventory_id`, `type`, `quantity`, `unit_cost`, `balance_before`, `balance_after`, `description`, `total_cost`, `reference_type`, `reference_id`, `notes`, `movement_date`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 'purchase', 3.000, 333.00, 0.000, 3.000, 'استلام شراء', 999.000, 'App\\Models\\GoodsReceipt', 1, 'استلام على الفاتورة GR-20260419001615', '2026-04-22 22:16:22', '2026-04-22 22:16:22', '2026-04-18 22:16:22', NULL),
(2, 71, 2, 'transfer_out', -1.000, 15.00, 3.000, 2.000, 'تحويل مخزني - صرف', 15.000, 'App\\Models\\TransferRequest', 1, 'من الفرع 1 إلى الفرع 3', '2026-04-19 19:11:49', '2026-04-19 19:11:49', '2026-04-19 19:11:49', NULL),
(3, 71, 2, 'transfer_in', 1.000, 15.00, 2.000, 3.000, 'تحويل مخزني - استلام', 15.000, 'App\\Models\\TransferRequest', 1, 'استلام تحويل من الفرع 1', '2026-04-19 19:13:53', '2026-04-19 19:13:53', '2026-04-19 19:13:53', NULL),
(4, 71, 2, 'adjustment', 7.000, 15.00, 3.000, 10.000, 'تسوية جرد', 105.000, 'App\\Models\\StockCount', 1, 'فائض جرد', '2026-04-19 19:21:30', '2026-04-19 19:21:30', '2026-04-19 19:21:30', NULL),
(5, 71, 1, 'adjustment', -2.000, 15.00, 10.000, 8.000, 'تسوية جرد', 30.000, 'App\\Models\\StockCount', 1, 'عجز جرد', '2026-04-19 19:21:30', '2026-04-19 19:21:30', '2026-04-19 19:21:30', NULL),
(6, 71, 1, 'production_out', -2.000, 333.00, 8.000, 6.000, 'استهلاك خامات للإنتاج', 666.000, 'App\\Models\\ProductionOrder', 1, 'أمر إنتاج PD-20260420001458', '2026-04-19 22:32:40', '2026-04-19 22:32:40', '2026-04-19 22:32:40', NULL),
(7, 71, 1, 'production_in', 3.000, 222.00, 6.000, 9.000, 'إضافة ناتج إنتاج', 666.000, 'App\\Models\\ProductionOrder', 1, 'ناتج أمر إنتاج PD-20260420001458', '2026-04-19 22:32:40', '2026-04-19 22:32:40', '2026-04-19 22:32:40', NULL),
(8, 71, 322, 'purchase', 10.000, 0.00, 0.000, 10.000, NULL, 0.000, 'App\\Models\\PurchaseInvoice', 5, 'شراء فاتورة مستلمة بمورد: Ahmed Salah', NULL, '2026-05-12 18:25:06', '2026-05-12 18:25:06', 4),
(9, 71, 3, 'purchase', 1.000, 0.00, 0.000, 1.000, NULL, 0.000, 'App\\Models\\PurchaseInvoice', 6, 'شراء فاتورة مستلمة بمورد: Ahmed Salah', NULL, '2026-05-12 18:37:22', '2026-05-12 18:37:22', NULL),
(10, 71, 108, 'purchase', 111.000, 0.00, 0.000, 111.000, NULL, 0.000, 'App\\Models\\PurchaseInvoice', 7, 'شراء فاتورة مستلمة بمورد: Ahmed Salah', NULL, '2026-05-12 18:45:11', '2026-05-12 18:45:11', NULL),
(11, 71, 2, 'purchase', 15.000, 0.00, 0.000, 15.000, NULL, 0.000, 'App\\Models\\PurchaseInvoice', 8, 'شراء فاتورة مستلمة بمورد: ffffff', NULL, '2026-05-21 08:01:02', '2026-05-21 08:01:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
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
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
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
  `migration` varchar(191) NOT NULL,
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
(96, '2026_04_30_031119_add_branch_id_to_remaining_tables', 29),
(97, '2026_05_03_112716_create_staff_table', 30),
(98, '2026_05_03_115307_create_salary_m_table', 31),
(99, '2026_05_03_123239_create_expenses_table', 32),
(100, '2026_05_07_113340_add_kitchen_note_to_orders_table', 33),
(101, '2026_05_09_073501_add_cost_sale_profit_inventory_to_products_table', 34),
(102, '2026_05_09_073658_add_cost_sale_profit_to_product_sizes_table', 34),
(103, '2026_05_10_091820_add_parent_id_to_categories_table', 35),
(104, '2026_05_10_112026_add_returned_at_to_orders_table', 36),
(105, '2026_05_10_115309_update_status_column_in_orders_table', 37),
(106, '2026_05_10_130007_update_source_values_in_orders_table', 38),
(107, '2026_05_10_154900_add_extra_fields_to_products_table', 39),
(108, '2026_05_10_160049_add_extra_fields_to_product_sizes_table', 40),
(109, '2026_05_11_064318_add_barcode_to_products_and_product_sizes_tables', 41),
(110, '2026_05_11_083432_create_business_type_permission_defaults_table', 42),
(111, '2026_05_12_211218_add_balance_to_suppliers_table', 43),
(112, '2026_05_16_002226_add_payments_breakdown_to_shifts', 44),
(114, '2026_05_17_140848_add_discount_to_orders_table', 45),
(115, '2026_05_17_155809_add_discount_amount_to_orders_table', 46),
(117, '2026_02_05_021053_create_charges_table', 47),
(118, '2026_05_20_131307_add_charges_to_orders_table', 48),
(119, '2026_05_20_214847_add_quantity_to_product_sizes_table', 49),
(120, '2026_05_14_182109_staff', 50),
(121, '2026_05_20_104252_create_chargeables_table', 50),
(122, '2026_05_23_214148_add_fields_to_staff_table', 50);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
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
  `name` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT 0,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(191) NOT NULL DEFAULT 'cash',
  `payment_proof` varchar(191) DEFAULT NULL,
  `status` enum('pending','served','returned') DEFAULT 'pending',
  `returned_at` timestamp NULL DEFAULT NULL,
  `type` enum('takeaway','table','free_seating','delivery') NOT NULL DEFAULT 'takeaway',
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_man_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kitchen_note` text DEFAULT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `source` varchar(191) NOT NULL DEFAULT 'online',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(191) NOT NULL DEFAULT 'fixed',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `charges_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `charges_breakdown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`charges_breakdown`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `name`, `phone`, `address`, `total_price`, `paid_amount`, `change_amount`, `payment_method`, `payment_proof`, `status`, `returned_at`, `type`, `table_id`, `delivery_man_id`, `kitchen_note`, `delivery_fee`, `source`, `created_at`, `updated_at`, `shift_id`, `branch_id`, `discount`, `discount_type`, `subtotal`, `discount_amount`, `charges_total`, `charges_breakdown`) VALUES
(1, 1, 71, 'ممت', '٨٠٠٠٠', 'اللب', 460, 460.00, 0.00, '1', NULL, 'returned', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-13 16:35:29', '2026-04-24 18:35:34', 4, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(2, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, 100.00, 0.00, '3', NULL, 'returned', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'cachire', '2026-04-13 16:35:29', '2026-04-24 18:59:04', 5, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(3, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, NULL, NULL, '2', NULL, 'returned', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'online', '2026-04-13 16:35:29', '2025-09-02 11:32:31', 6, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(4, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, NULL, NULL, '2', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 0.00, 'online', '2026-04-12 16:35:29', '2025-08-16 11:44:30', 7, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(5, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, 100.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 16:35:29', '2026-04-25 18:33:32', 8, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(6, NULL, 71, 'cffvgbhnjm', '٣٤٥٦٧٨٩', 'سيبلات', 100, 100.00, 0.00, '1', NULL, 'returned', '2026-05-10 10:45:49', 'delivery', NULL, 1, NULL, 0.00, 'cachire', '2026-04-12 16:35:29', '2026-05-10 10:45:49', 8, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(7, NULL, 71, 'llll', '123456789', 'kkkk', 120, NULL, NULL, '1', NULL, 'served', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 16:35:29', '2025-08-16 12:28:57', 8, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(9, NULL, 1, 'Amr Khaled', '0100000000', 'شارع الاختبار - القاهرة', 960, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-08-27 07:00:27', '2025-08-27 07:00:27', 8, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(10, NULL, 40, '555', '52343545352', '523432423', 360, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-09-04 08:25:07', '2025-09-04 08:25:07', 8, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(11, NULL, 1, 'amr', '0110928873', 'cairo', 1200, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-09-04 09:01:17', '2025-09-04 09:01:17', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(12, NULL, 40, 'زعبلة', '0123654789', 'عنوان بيننا', 200, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-10-13 20:57:12', '2025-10-13 20:57:12', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(13, NULL, 68, 'شاكر', '01099909123', 'قلين', 35, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-11-05 22:05:13', '2025-11-05 22:05:13', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(14, NULL, 53, 'وائل ابو البنات', '01211327252', 'بلازا 5', 185, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-11-13 17:21:01', '2025-11-13 17:21:01', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(15, NULL, 53, 'وائل ابو اللنات', '01211327252', 'بلازا 5', 190, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-11-13 22:03:08', '2025-11-13 22:03:08', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(16, NULL, 80, 'مممم', '01000058000', 'عولفعوو', 565, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-08 21:12:04', '2025-12-08 21:13:45', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(17, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-11 15:49:33', '2025-12-15 16:57:37', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(18, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-11 15:49:34', '2025-12-15 16:58:47', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(19, NULL, 80, 'فارس منصور', '01024167435', 'مج 18', 250, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-11 15:49:34', '2025-12-15 16:58:43', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(20, NULL, 86, 'Mostafa Matter', '01507444580', 'السعديه', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-14 07:55:58', '2025-12-14 20:58:38', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(21, NULL, 86, 'Mostafa Matter', '01507444580', 'الشرقيه', 6, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-14 08:16:53', '2025-12-14 20:58:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(22, NULL, 86, 'بوحه', '٠١٥٠٧٤٤٤٥٨٠', 'القطاويه', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-14 20:18:35', '2025-12-14 20:58:25', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(23, NULL, 80, 'ضياء رضا', '01050222277', 'المجاوره 10', 195, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-15 17:00:00', '2025-12-15 17:01:58', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(24, NULL, 86, 'بوحه', '٠١٥٠٧٤٤٤٥٨٠', 'السعديه', 155, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-15 20:51:04', '2025-12-16 00:01:57', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(25, NULL, 86, 'مصطفي', '٠١٥٠٧٤٤٤٥٨٠', 'السعدية', 320, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-23 20:53:28', '2025-12-16 00:02:02', NULL, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(26, NULL, 84, 'محمود نور', '01112556029', 'الحريزات الشرقيه شارع ال النجار', 380, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-24 13:58:05', '2025-12-23 14:49:47', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(27, NULL, 84, 'محمود نور', '01112556029', 'الحريزات الشرقيه شارع ال النجار', 380, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-17 14:58:06', '2025-12-23 14:49:44', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(28, NULL, 85, 'خخخخ', '01025570206', 'kkkkd kdkdk', 1099.99, NULL, NULL, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:13:27', '2025-12-21 08:22:43', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(29, NULL, 85, 'jddjjd', '01025570206', 'jcdjdjcxj', 1949.97, NULL, NULL, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:18:36', '2025-12-21 08:53:46', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(30, NULL, 85, 'بنبنبن', '01025570206', 'dkdkdk', 1949.97, NULL, NULL, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:23:27', '2025-12-21 08:53:44', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(31, NULL, 85, 'يتتيتي', '01025570206', 'kckkcc', 739.98, NULL, NULL, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:28:27', '2025-12-21 08:32:42', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(32, NULL, 85, 'ندندن', '01025570206', 'rfjfjf', 1099.99, NULL, NULL, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:47:05', '2025-12-21 08:53:40', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(33, NULL, 85, 'مميميميم', '01025570206', 'xkxkkx', 1099.99, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 08:54:17', '2025-12-21 09:02:12', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(34, NULL, 86, 'عمر خيري', '01507444580', 'السعديه', 285, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 09:03:13', '2025-12-21 09:07:20', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(35, NULL, 86, 'عمر', '01055020229', 'السعديه', 285, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 09:05:54', '2025-12-21 09:07:28', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(36, NULL, 86, 'ا', '5', 'ا', 3, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-21 20:13:09', '2025-12-21 20:13:50', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(37, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-22 22:55:23', '2025-12-22 23:02:37', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(38, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-22 22:55:24', '2025-12-22 23:02:33', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(39, NULL, 86, 'محمد سمير محمد الفقي', '01204456876', 'مفارق القطاويه', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-22 22:55:26', '2025-12-22 23:02:19', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(40, NULL, 86, 'H', '5', 'H', 875, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:12:08', '2025-12-24 00:12:37', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(41, NULL, 86, 'Hh', '55', 'Vb', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:13:07', '2025-12-24 00:14:55', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(42, NULL, 86, 'Jh ok', '8686', 'Kvi', 450, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:13:27', '2025-12-24 00:14:53', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(43, NULL, 86, 'Mostafa Matter', '04507888580', 'Hhhgxf', 570, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:13:53', '2025-12-24 00:14:51', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(44, NULL, 86, 'Bb', '88', 'Yv', 450, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:14:24', '2025-12-24 00:14:48', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(45, NULL, 86, 'Mostafa Matter', '01280912321', 'السعديه', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:16:25', '2025-12-24 00:16:37', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(46, NULL, 86, 'Mostafa Matter', '0000000', 'تااتزد', 285, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 00:17:32', '2025-12-24 00:18:16', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(47, NULL, 88, 'اشرف', '01010250854', 'العاشر من', 1900, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-24 23:03:00', '2026-01-08 18:41:35', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(48, NULL, 90, 'مدحت فخري', '01080362429', 'مجاوره 18', 200, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-27 22:44:11', '2025-12-27 22:44:11', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(49, NULL, 80, 'Osama', '124846487', '686', 125, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-30 17:57:00', '2025-12-30 17:58:24', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(50, NULL, 80, 'ياسمين أحمد', '01093478580', 'المجاوره 19 خلف فرن تبارك', 640, NULL, NULL, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2025-12-31 20:11:51', '2025-12-31 20:29:35', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(51, NULL, 80, 'عبدالرحمن خالد', '01027785305', 'الأردنية بجوار دار مناسبات العاشر', 145, NULL, NULL, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-01-11 13:33:55', '2026-01-11 13:33:55', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(52, 1, 71, 'عبدالرحمن احمد', '+2020150837340', 'الجيزة مركز الصف', 10, 10.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 06:26:54', '2026-04-25 19:15:22', 15, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(53, 2, 71, 'test', '+201508373405', 'test', 25, NULL, NULL, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 01:24:30', '2026-04-11 17:19:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(54, NULL, 71, 'عميل 1', '0100000001', 'القاهرة', 120, 120.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 16:37:24', '2026-04-24 20:34:07', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(55, NULL, 71, 'عميل 2', '0100000002', 'الجيزة', 180, 180.00, 0.00, '3', NULL, 'served', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'cachire', '2026-04-12 16:37:24', '2026-04-24 20:35:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(56, NULL, 71, 'عميل 3', '0100000003', 'المنصورة', 210, 210.00, 0.00, '3', NULL, 'served', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 16:37:24', '2026-04-25 17:53:23', 13, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(57, NULL, 71, 'عميل 4', '0100000004', 'طنطا', 300, 250.00, 50.00, '2', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 20.00, 'online', '2026-04-12 16:37:24', '2026-04-25 17:54:11', 13, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(58, NULL, 71, 'عميل 1', '0100000001', 'القاهرة', 120, 120.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'online', '2026-04-10 08:00:00', '2026-04-27 17:45:07', 22, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(59, NULL, 71, 'عميل 2', '0100000002', 'الجيزة', 150, 150.00, 0.00, '2', NULL, 'served', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'cachire', '2026-04-11 08:00:00', '2026-04-26 19:03:31', 17, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(60, NULL, 71, 'عميل 3', '0100000003', 'المنصورة', 180, 180.00, 0.00, '2', NULL, 'served', NULL, 'free_seating', NULL, NULL, NULL, 0.00, 'online', '2026-04-12 08:00:00', '2026-04-25 18:41:27', 14, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(61, NULL, 71, 'عميل 4', '0100000004', 'طنطا', 200, 200.00, 0.00, '2', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 0.00, 'online', '2026-04-12 12:00:00', '2026-04-25 18:37:05', 14, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(62, NULL, 71, NULL, NULL, NULL, 20, 20.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 07:20:51', '2026-05-07 07:20:51', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(63, NULL, 71, NULL, NULL, NULL, 20, 20.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 07:44:36', '2026-05-07 07:44:36', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(64, NULL, 71, NULL, NULL, NULL, 20, 20.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 07:50:29', '2026-05-07 07:50:29', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(65, 3, 71, NULL, NULL, NULL, 20, 20.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 08:23:46', '2026-05-07 08:23:46', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(66, 3, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بدو سكر', 0.00, 'cachire', '2026-05-07 08:47:21', '2026-05-07 08:47:21', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(67, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 08:55:38', '2026-05-07 08:55:38', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(68, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 08:57:53', '2026-05-07 08:57:53', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(69, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 09:01:58', '2026-05-07 09:01:58', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(70, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 09:05:11', '2026-05-07 09:05:11', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(71, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'cachire', '2026-05-07 09:16:05', '2026-05-07 09:16:05', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(72, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'returned', '2026-05-10 09:38:44', 'takeaway', NULL, 1, NULL, 0.00, 'cachire', '2026-05-07 09:19:56', '2026-05-10 09:38:44', 29, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(73, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'returned', '2026-05-10 09:38:38', 'takeaway', NULL, 1, 'aaaaaaaaaaaaaaa', 0.00, 'cachire', '2026-05-08 10:37:10', '2026-05-10 09:38:38', 30, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(74, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'returned', '2026-05-10 09:38:31', 'takeaway', NULL, NULL, 'hhhhhhhhhh', 0.00, 'cachire', '2026-05-08 10:46:56', '2026-05-10 09:38:31', 31, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(75, NULL, 71, NULL, NULL, NULL, 200, 200.00, 0.00, '1', NULL, 'returned', '2026-05-10 09:31:14', 'takeaway', NULL, NULL, 'aaaaaa', 0.00, 'online', '2026-05-08 11:01:55', '2026-05-10 10:05:27', 32, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(76, NULL, 71, NULL, NULL, NULL, 10, 10.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بدون سكر', 0.00, 'pos', '2026-05-10 12:57:40', '2026-05-10 12:57:40', 36, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(77, NULL, 71, NULL, NULL, NULL, 150, 150.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بدون سعر', 0.00, 'pos', '2026-05-10 13:05:34', '2026-05-10 13:05:34', 36, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(78, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 18:19:51', '2026-05-13 18:19:51', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(79, 1, 71, NULL, NULL, NULL, 30, 100.00, 70.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 18:24:51', '2026-05-13 18:24:51', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(80, 1, 71, NULL, NULL, NULL, 30, 30.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 18:27:02', '2026-05-13 18:27:02', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(81, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 18:27:51', '2026-05-13 18:27:51', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(82, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'شششششش', 0.00, 'pos', '2026-05-13 18:51:38', '2026-05-13 18:51:38', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(83, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, 'ييييييي', 0.00, 'pos', '2026-05-13 20:14:19', '2026-05-13 20:14:19', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(84, 2, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'شششششششش', 0.00, 'pos', '2026-05-13 20:20:42', '2026-05-13 20:20:42', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(85, 2, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 20:23:02', '2026-05-13 20:23:02', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(86, 2, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سسسسسسسسسس', 0.00, 'pos', '2026-05-13 20:27:01', '2026-05-13 20:27:01', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(87, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 20:30:00', '2026-05-13 20:30:00', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(88, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'ssssssssss', 0.00, 'pos', '2026-05-13 20:33:23', '2026-05-13 20:33:23', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(89, 2, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'يييييييي', 0.00, 'pos', '2026-05-13 20:36:08', '2026-05-13 20:36:08', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(90, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'لللللللللل', 0.00, 'pos', '2026-05-13 20:41:38', '2026-05-13 20:41:38', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(91, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-13 20:43:35', '2026-05-13 20:43:35', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(92, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سسسسسسسس', 0.00, 'pos', '2026-05-13 20:49:20', '2026-05-13 20:49:20', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(93, 2, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'ااااااااااااااااااا', 0.00, 'pos', '2026-05-13 20:52:31', '2026-05-13 20:52:31', 37, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(94, 3, 71, NULL, NULL, NULL, 60, 0.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بدون سكر', 0.00, 'pos', '2026-05-14 16:18:08', '2026-05-14 16:18:08', 37, 2, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(95, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'زيادة ثلج', 0.00, 'pos', '2026-05-14 16:24:22', '2026-05-14 16:24:22', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(96, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'صصصصصص', 0.00, 'pos', '2026-05-14 16:26:42', '2026-05-14 16:26:42', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(97, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'زيادة ثلج', 0.00, 'pos', '2026-05-14 16:27:52', '2026-05-14 16:27:52', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(98, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'زيادة ثلج', 0.00, 'pos', '2026-05-14 16:28:43', '2026-05-14 16:28:43', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(99, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:29:27', '2026-05-14 16:29:27', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(100, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:30:08', '2026-05-14 16:30:08', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(101, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:31:11', '2026-05-14 16:31:11', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(102, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:33:55', '2026-05-14 16:33:55', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(103, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:41:37', '2026-05-14 16:41:37', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(104, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:43:19', '2026-05-14 16:43:19', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(105, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:44:09', '2026-05-14 16:44:09', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(106, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:45:38', '2026-05-14 16:45:38', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(107, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:48:02', '2026-05-14 16:48:02', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(108, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:51:27', '2026-05-14 16:51:27', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(109, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:53:18', '2026-05-14 16:53:18', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(110, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:57:48', '2026-05-14 16:57:48', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(111, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 16:58:21', '2026-05-14 16:58:21', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(112, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 17:01:26', '2026-05-14 17:01:26', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(113, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 17:02:52', '2026-05-14 17:02:52', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(114, 3, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-14 17:06:20', '2026-05-14 17:06:20', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(115, 1, 71, 'أحمد تجربة', '01012345678', 'الفيوم - شارع الجامعة', 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, 'بدون بصل + سبايسي', 20.00, 'cashier', '2026-05-14 20:35:47', '2026-05-15 09:39:35', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(116, 1, 71, 'أحمد تجربة', '01012345678', 'الفيوم - شارع الجامعة', 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, 'بدون بصل + سبايسي', 20.00, 'cashier', '2026-05-14 20:58:09', '2026-05-14 17:58:33', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(117, 4, 71, NULL, NULL, NULL, 35, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 5.00, 'pos', '2026-05-14 17:59:52', '2026-05-14 17:59:52', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(118, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 21:44:36', '2026-05-15 09:39:25', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(119, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 21:49:03', '2026-05-15 09:39:44', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(120, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 21:52:17', '2026-05-15 09:40:29', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(121, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 22:00:17', '2026-05-15 09:39:12', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(122, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 22:10:35', '2026-05-15 09:40:37', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(123, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 22:19:20', '2026-05-15 09:38:51', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(124, 1, 71, 'Test Order', '01000000000', 'Fayoum', 100, 100.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'cashier', '2026-05-14 22:33:31', '2026-05-15 09:38:45', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(125, 5, 71, NULL, NULL, NULL, 35, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 5.00, 'pos', '2026-05-15 09:40:19', '2026-05-15 09:40:19', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(126, 1, 71, 'عميل تجربة', '01011111111', 'الفيوم - تجربة الجرس', 120, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 12:56:11', '2026-05-15 10:13:29', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(127, 1, 71, 'عميل تجربة', '01011111111', 'الفيوم - تجربة الجرس', 120, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 13:00:43', '2026-05-15 10:30:29', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(128, 1, 71, 'عميل تجربة', '01011111111', 'الفيوم - تجربة الجرس', 120, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 13:22:28', '2026-05-15 10:31:00', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(129, 1, 71, 'عميل InstaPay', '01022222222', 'الفيوم - تجربة الدفع', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 13:39:28', '2026-05-15 10:39:44', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(130, 1, 71, 'عميل InstaPay', '01022222222', 'الفيوم - تجربة الدفع', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 13:52:24', '2026-05-15 10:52:41', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(131, 1, 71, 'عميل InstaPay', '01022222222', 'الفيوم - تجربة الدفع', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 13:58:02', '2026-05-15 13:17:16', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(132, 1, 71, NULL, NULL, NULL, 36, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 4, NULL, 6.00, 'pos', '2026-05-15 11:54:27', '2026-05-15 11:54:27', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(133, 1, 71, 'عميل InstaPay', '01022222222', 'الفيوم - تجربة الدفع', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 16:19:23', '2026-05-15 13:52:48', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(134, 1, 71, 'عميل تجريبي 1', '01000000001', 'الفيوم', 120, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:20', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(135, 2, 71, 'عميل تجريبي 2', '01000000002', 'الفيوم', 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:27:56', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(136, 3, 71, 'عميل InstaPay', '01000000003', 'الفيوم', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:04', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(137, 4, 71, 'عميل 4', '01000000004', 'الفيوم', 180, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 12.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:10', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(138, 5, 71, 'عميل 5', '01000000005', 'الفيوم', 90, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 8.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:22', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(139, 1, 71, 'عميل 6', '01000000006', 'الفيوم', 300, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 20.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:23', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(140, 2, 71, 'عميل 7', '01000000007', 'الفيوم', 110, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:29:26', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(141, 3, 71, 'عميل 8', '01000000008', 'الفيوم', 250, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:29:23', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(142, 4, 71, 'عميل 9', '01000000009', 'الفيوم', 140, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:29:29', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(143, 5, 71, 'عميل 10', '01000000010', 'الفيوم', 220, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 17:07:19', '2026-05-15 14:28:17', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(144, 1, 71, 'عميل 1', '01000000001', 'الفيوم', 120, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:57:31', '2026-05-15 16:47:50', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(145, 1, 71, 'عميل 2', '01000000002', 'الفيوم', 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:57:31', '2026-05-15 16:49:03', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(146, 1, 71, 'عميل InstaPay', '01000000003', 'الفيوم', 200, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 17:57:31', '2026-05-15 15:05:29', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(147, 1, 71, 'عميل 4', '01000000004', 'الفيوم', 180, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 12.00, 'online', '2026-05-15 17:57:31', '2026-05-18 08:33:32', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(148, 1, 71, 'عميل 5', '01000000005', 'الفيوم', 90, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 8.00, 'online', '2026-05-15 17:57:31', '2026-05-18 08:50:55', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(149, 1, 71, 'عميل 6', '01000000006', 'الفيوم', 300, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 20.00, 'online', '2026-05-15 17:57:31', '2026-05-16 11:22:36', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(150, 1, 71, 'عميل 7', '01000000007', 'الفيوم', 110, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'online', '2026-05-15 17:57:31', '2026-05-18 08:55:39', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(151, 1, 71, 'عميل 8', '01000000008', 'الفيوم', 250, 0.00, 0.00, '1', NULL, 'returned', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'online', '2026-05-15 17:57:31', '2026-05-17 06:56:13', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(152, 1, 71, 'عميل 9', '01000000009', 'الفيوم', 140, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, 'بدون سكر', 10.00, 'online', '2026-05-15 17:57:31', '2026-05-15 17:03:24', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(153, 1, 71, 'عميل 10', '01000000010', 'الفيوم', 220, 0.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, NULL, 'اهلا', 15.00, 'online', '2026-05-15 17:57:31', '2026-05-15 17:16:10', NULL, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1014, 1, 71, NULL, NULL, NULL, 8400, 0.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سسسسسسس', 0.00, 'pos', '2026-05-15 14:39:29', '2026-05-15 14:39:29', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1015, 5, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'شششششششششش', 0.00, 'pos', '2026-05-15 14:59:27', '2026-05-15 14:59:27', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1017, 1, 71, NULL, NULL, NULL, 205, 0.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, 'صصصصص', 5.00, 'pos', '2026-05-15 15:06:05', '2026-05-15 15:06:05', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1018, 4, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سسسسسس', 0.00, 'pos', '2026-05-15 15:10:38', '2026-05-15 15:10:38', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1019, 4, 71, NULL, NULL, NULL, 154, 154.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, 1, 'ييييييي', 4.00, 'pos', '2026-05-15 15:20:53', '2026-05-15 15:20:53', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1020, 4, 71, 'عميل 9', NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'صصصص', 0.00, 'pos', '2026-05-20 15:30:29', '2026-05-15 15:30:29', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1021, 3, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'صصصصصص', 0.00, 'pos', '2026-05-15 16:18:38', '2026-05-15 16:18:38', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1022, 4, 71, 'عميل 9', NULL, NULL, 150, 200.00, 50.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بببببببببب', 0.00, 'pos', '2026-05-20 16:47:23', '2026-05-15 16:47:23', 37, 4, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1023, 1, 71, NULL, NULL, NULL, 125, 125.00, 0.00, '2', NULL, 'served', NULL, 'delivery', NULL, 1, 'ىىىىىىىى', 5.00, 'pos', '2026-05-15 16:48:39', '2026-05-15 16:48:39', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1024, 1, 71, NULL, NULL, NULL, 155, 155.00, 0.00, '1', NULL, 'returned', NULL, 'delivery', NULL, 2, 'ففففففففف', 5.00, 'pos', '2026-05-15 16:49:37', '2026-05-15 16:49:37', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1025, 1, 71, NULL, NULL, NULL, 150.5, 150.50, 0.00, '1', NULL, 'returned', NULL, 'delivery', NULL, 1, 'بدون سكر', 10.50, 'pos', '2026-05-15 17:04:27', '2026-05-15 17:04:27', 37, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1026, 2, 71, NULL, NULL, NULL, 300, 300.00, 0.00, '1', NULL, 'returned', NULL, 'takeaway', NULL, NULL, 'بقرى', 0.00, 'pos', '2026-05-15 17:15:53', '2026-05-15 17:15:53', 38, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1027, 1, 71, NULL, NULL, NULL, 230, 230.00, 0.00, '3', NULL, 'returned', NULL, 'delivery', NULL, 1, 'اهلا', 10.00, 'pos', '2026-05-15 17:16:44', '2026-05-15 17:16:44', 38, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1028, 1, 71, NULL, NULL, NULL, 300, 300.00, 0.00, '2', NULL, 'served', NULL, 'delivery', NULL, 1, NULL, 0.00, 'pos', '2026-05-15 18:39:12', '2026-05-15 18:39:12', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1029, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:02:45', '2026-05-15 20:02:45', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1030, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:05:54', '2026-05-15 20:05:54', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1031, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:06:00', '2026-05-15 20:06:00', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1032, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:06:38', '2026-05-15 20:06:38', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1033, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:07:06', '2026-05-15 20:07:06', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1034, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:14:43', '2026-05-15 20:14:43', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1035, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:14:49', '2026-05-15 20:14:49', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1036, 1, 71, NULL, NULL, NULL, 30, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:14:56', '2026-05-15 20:14:56', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1037, 1, 71, NULL, NULL, NULL, 60, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:15:16', '2026-05-15 20:15:16', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1038, 1, 71, NULL, NULL, NULL, 60, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:17:34', '2026-05-15 20:17:34', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1039, 1, 71, NULL, NULL, NULL, 60, 0.00, 0.00, '2', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:17:38', '2026-05-15 20:17:38', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1040, 1, 71, NULL, NULL, NULL, 30, 30.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:24:39', '2026-05-15 20:24:39', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1041, 1, 71, NULL, NULL, NULL, 4200, 4200.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 20:25:47', '2026-05-15 20:25:47', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1042, 1, 71, NULL, NULL, NULL, 150, 200.00, 50.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 21:00:00', '2026-05-15 21:00:00', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1043, 1, 71, NULL, NULL, NULL, 150, 150.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 21:05:34', '2026-05-15 21:05:34', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1044, 3, 71, NULL, NULL, NULL, 30, 30.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-15 21:48:02', '2026-05-15 21:48:02', 39, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1045, 2, 71, NULL, NULL, NULL, 150, 150.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'no suger', 0.00, 'pos', '2026-05-16 11:19:40', '2026-05-16 11:19:40', 41, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1046, 2, 71, NULL, NULL, NULL, 310, 310.00, 0.00, '2', NULL, 'served', NULL, 'delivery', NULL, 1, 'no', 10.00, 'pos', '2026-05-16 11:20:41', '2026-05-16 11:20:41', 41, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1047, 2, 71, NULL, NULL, NULL, 11000, 11100.00, 100.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'Apple', 0.00, 'pos', '2026-05-16 11:22:08', '2026-05-16 11:22:08', 41, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1048, 1, 71, NULL, NULL, NULL, 310, 310.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, 3, 'meet', 10.00, 'pos', '2026-05-16 11:23:06', '2026-05-16 11:23:06', 41, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1049, 2, 71, NULL, NULL, NULL, 500, 500.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'فراخ', 0.00, 'pos', '2026-05-16 11:29:42', '2026-05-16 11:29:42', 42, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1050, 2, 71, NULL, NULL, NULL, 90, 90.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سكر', 0.00, 'pos', '2026-05-16 11:30:17', '2026-05-16 11:30:17', 42, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1051, 2, 71, NULL, NULL, NULL, 1000, 1000.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'سسس', 0.00, 'pos', '2026-05-16 11:31:00', '2026-05-16 11:31:00', 42, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1052, 2, 71, NULL, NULL, NULL, 4200, 4200.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'ننن', 0.00, 'pos', '2026-05-16 11:36:55', '2026-05-16 11:36:55', 43, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1053, 2, 71, NULL, NULL, NULL, 4200, 4200.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 11:37:35', '2026-05-16 11:37:35', 43, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1054, 2, 71, NULL, NULL, NULL, 4200, 4200.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 11:39:23', '2026-05-16 11:39:23', 43, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1055, NULL, 71, NULL, NULL, NULL, 150, 150.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 19:27:55', '2026-05-16 19:27:55', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1056, NULL, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 19:45:56', '2026-05-16 19:45:56', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1057, NULL, 71, NULL, NULL, NULL, 150, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 20:21:21', '2026-05-16 20:21:21', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1058, NULL, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 20:25:30', '2026-05-16 20:25:30', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1059, NULL, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 20:27:59', '2026-05-16 20:27:59', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1060, NULL, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-16 20:31:52', '2026-05-16 20:31:52', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1061, 6, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '1', NULL, 'returned', NULL, 'delivery', NULL, NULL, '', 0.00, 'pos', '2026-05-17 06:38:19', '2026-05-17 06:58:12', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1062, 7, 71, NULL, NULL, NULL, 4200, 0.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'لاب ديل', 0.00, 'pos', '2026-05-17 11:11:30', '2026-05-17 11:11:30', 44, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1063, 8, 71, NULL, NULL, NULL, 0, 2100.00, 2100.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 11:33:50', '2026-05-17 11:33:50', 44, 1, 0.00, 'percent', 0.00, 0.00, 0.00, NULL),
(1064, 8, 71, NULL, NULL, NULL, 200, 200.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:08:54', '2026-05-17 12:08:54', 44, 1, 100.00, 'fixed', 300.00, 0.00, 0.00, NULL),
(1065, 8, 71, NULL, NULL, NULL, 130, 130.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:14:23', '2026-05-17 12:14:23', 44, 1, 20.00, 'fixed', 150.00, 0.00, 0.00, NULL),
(1066, 8, 71, NULL, NULL, NULL, 75, 65.00, 0.00, '1', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:21:02', '2026-05-17 12:21:02', 44, 1, 75.00, 'percent', 150.00, 0.00, 0.00, NULL),
(1067, 8, 71, NULL, NULL, NULL, 30, 30.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:23:29', '2026-05-17 12:23:29', 44, 1, 30.00, 'percent', 60.00, 0.00, 0.00, NULL),
(1068, 8, 71, NULL, NULL, NULL, 100, 100.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:40:49', '2026-05-17 12:40:49', 44, 1, 50.00, 'fixed', 150.00, 0.00, 0.00, NULL),
(1069, 8, 71, NULL, NULL, NULL, 75, 75.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:41:41', '2026-05-17 12:41:41', 44, 1, 75.00, 'percent', 150.00, 0.00, 0.00, NULL),
(1070, 8, 71, NULL, NULL, NULL, 75, 75.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:51:53', '2026-05-17 12:51:53', 44, 1, 75.00, 'percent', 150.00, 0.00, 0.00, NULL),
(1071, 8, 71, NULL, NULL, NULL, 15, 15.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 12:59:48', '2026-05-17 12:59:48', 44, 1, 15.00, 'percent', 30.00, 0.00, 0.00, NULL),
(1072, 7, 71, NULL, NULL, NULL, 15, 15.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 13:03:17', '2026-05-17 13:03:17', 44, 1, 15.00, 'percent', 30.00, 0.00, 0.00, NULL),
(1073, 7, 71, NULL, NULL, NULL, 75, 75.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, '', 0.00, 'pos', '2026-05-17 13:21:02', '2026-05-17 13:21:02', 44, 1, 50.00, 'percent', 150.00, 75.00, 0.00, NULL),
(1074, 2, 71, NULL, NULL, NULL, 100, 105.00, 5.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, '', 5.50, 'pos', '2026-05-18 08:50:07', '2026-05-18 08:50:07', 44, 1, 80.00, 'fixed', 180.00, 80.00, 0.00, NULL),
(1075, 2, 71, NULL, NULL, NULL, 85, 95.00, 10.00, '1', NULL, 'served', NULL, 'delivery', NULL, 2, '', 5.00, 'pos', '2026-05-18 08:55:19', '2026-05-18 08:55:19', 44, 1, 5.00, 'fixed', 90.00, 5.00, 0.00, NULL),
(1076, 2, 71, NULL, NULL, NULL, 55, 55.00, 0.00, '3', NULL, 'served', NULL, 'delivery', NULL, 3, 'ششششش', 0.00, 'pos', '2026-05-18 09:28:20', '2026-05-18 09:28:20', 44, 1, 50.00, 'percent', 110.00, 55.00, 0.00, NULL),
(1077, 1, 71, NULL, NULL, NULL, 120, 120.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'pos', '2026-05-18 12:36:31', '2026-05-20 07:03:16', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1078, 2, 71, NULL, NULL, NULL, 200, 200.00, 0.00, '2', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 15.00, 'pos', '2026-05-18 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1079, 3, 71, NULL, NULL, NULL, 150, 150.00, 0.00, '1', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-18 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1080, 4, 71, NULL, NULL, NULL, 300, 300.00, 0.00, '3', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 20.00, 'pos', '2026-05-18 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1081, 5, 71, NULL, NULL, NULL, 180, 180.00, 0.00, '1', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'pos', '2026-05-20 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1082, 6, 71, NULL, NULL, NULL, 90, 90.00, 0.00, '2', NULL, 'pending', NULL, 'table', NULL, NULL, NULL, 0.00, 'pos', '2026-05-18 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1083, 7, 71, NULL, NULL, NULL, 250, 250.00, 0.00, '1', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 25.00, 'pos', '2026-05-20 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL);
INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `name`, `phone`, `address`, `total_price`, `paid_amount`, `change_amount`, `payment_method`, `payment_proof`, `status`, `returned_at`, `type`, `table_id`, `delivery_man_id`, `kitchen_note`, `delivery_fee`, `source`, `created_at`, `updated_at`, `shift_id`, `branch_id`, `discount`, `discount_type`, `subtotal`, `discount_amount`, `charges_total`, `charges_breakdown`) VALUES
(1084, 8, 71, NULL, NULL, NULL, 110, 110.00, 0.00, '1', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'pos', '2026-05-20 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1085, 1, 71, NULL, NULL, NULL, 140, 140.00, 0.00, '2', NULL, 'pending', NULL, 'delivery', NULL, NULL, NULL, 10.00, 'pos', '2026-05-20 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1086, 2, 71, NULL, NULL, NULL, 160, 160.00, 0.00, '3', NULL, 'pending', NULL, 'takeaway', NULL, NULL, NULL, 0.00, 'pos', '2026-05-18 12:36:31', '2026-05-18 12:36:31', NULL, 1, 0.00, 'fixed', 0.00, 0.00, 0.00, NULL),
(1087, 8, 71, NULL, NULL, NULL, 434.5, 400.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, '', 5.00, 'pos', '2026-05-20 11:07:39', '2026-05-20 11:07:39', 57, 1, 25.00, 'fixed', 420.00, 25.00, 39.50, '\"[{\\\"id\\\":1,\\\"name\\\":\\\"\\\\u0636\\\\u0631\\\\u064a\\\\u0628\\\\u0629 \\\\u062a\\\\u0648\\\\u0635\\\\u064a\\\\u0644\\\",\\\"type\\\":\\\"percentage\\\",\\\"value\\\":\\\"10.00\\\",\\\"amount\\\":39.5}]\"'),
(1088, 8, 71, NULL, NULL, NULL, 32, 30.00, 0.00, '1', NULL, 'served', NULL, 'delivery', NULL, 1, 'سكر زيادة', 10.00, 'pos', '2026-05-20 11:19:38', '2026-05-20 11:19:38', 57, 1, 10.00, 'fixed', 30.00, 10.00, 2.00, '\"[{\\\"id\\\":1,\\\"name\\\":\\\"\\\\u0636\\\\u0631\\\\u064a\\\\u0628\\\\u0629 \\\\u062a\\\\u0648\\\\u0635\\\\u064a\\\\u0644\\\",\\\"type\\\":\\\"percentage\\\",\\\"value\\\":\\\"10.00\\\",\\\"amount\\\":2}]\"'),
(1089, 8, 71, NULL, NULL, NULL, 25, 25.00, 0.00, '2', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بدون سكر', 0.00, 'pos', '2026-05-20 11:31:49', '2026-05-20 11:31:49', 57, 1, 5.00, 'fixed', 30.00, 5.00, 0.00, '\"[]\"'),
(1090, 3, 71, NULL, NULL, NULL, 200, 200.00, 0.00, '3', NULL, 'served', NULL, 'takeaway', NULL, NULL, 'بقرى', 0.00, 'pos', '2026-05-21 06:35:26', '2026-05-21 06:35:26', 57, NULL, 60.00, 'fixed', 260.00, 60.00, 0.00, '\"[]\"');

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
(69, 53, 363, 15, 1, '2026-01-26 01:24:30', '2026-01-26 01:24:30'),
(70, 62, 395, 10, 2, '2026-05-07 07:20:51', '2026-05-07 07:20:51'),
(71, 63, 395, 10, 2, '2026-05-07 07:44:36', '2026-05-07 07:44:36'),
(72, 64, 395, 10, 2, '2026-05-07 07:50:29', '2026-05-07 07:50:29'),
(73, 65, 395, 10, 2, '2026-05-07 08:23:46', '2026-05-07 08:23:46'),
(74, 66, 395, 10, 1, '2026-05-07 08:47:21', '2026-05-07 08:47:21'),
(75, 67, 395, 10, 1, '2026-05-07 08:55:38', '2026-05-07 08:55:38'),
(76, 68, 395, 10, 1, '2026-05-07 08:57:53', '2026-05-07 08:57:53'),
(77, 69, 395, 10, 1, '2026-05-07 09:01:58', '2026-05-07 09:01:58'),
(78, 70, 395, 10, 1, '2026-05-07 09:05:11', '2026-05-07 09:05:11'),
(79, 71, 395, 10, 1, '2026-05-07 09:16:05', '2026-05-07 09:16:05'),
(80, 72, 395, 10, 1, '2026-05-07 09:19:56', '2026-05-07 09:19:56'),
(81, 73, 392, 10, 1, '2026-05-08 10:37:10', '2026-05-08 10:37:10'),
(82, 74, 392, 10, 1, '2026-05-08 10:46:56', '2026-05-08 10:46:56'),
(83, 75, 405, 200, 1, '2026-05-08 11:01:55', '2026-05-08 11:01:55'),
(84, 76, 386, 10, 1, '2026-05-10 12:57:40', '2026-05-10 12:57:40'),
(85, 77, 380, 150, 1, '2026-05-10 13:05:34', '2026-05-10 13:05:34'),
(86, 78, 1390, 30, 1, '2026-05-13 18:19:51', '2026-05-13 18:19:51'),
(87, 79, 1390, 30, 1, '2026-05-13 18:24:51', '2026-05-13 18:24:51'),
(88, 80, 1390, 30, 1, '2026-05-13 18:27:02', '2026-05-13 18:27:02'),
(89, 81, 1390, 30, 1, '2026-05-13 18:27:51', '2026-05-13 18:27:51'),
(90, 82, 1390, 30, 1, '2026-05-13 18:51:38', '2026-05-13 18:51:38'),
(91, 83, 1390, 30, 1, '2026-05-13 20:14:19', '2026-05-13 20:14:19'),
(92, 84, 1367, 150, 1, '2026-05-13 20:20:42', '2026-05-13 20:20:42'),
(93, 85, 1367, 150, 1, '2026-05-13 20:23:02', '2026-05-13 20:23:02'),
(94, 86, 1367, 150, 1, '2026-05-13 20:27:01', '2026-05-13 20:27:01'),
(95, 87, 1390, 30, 1, '2026-05-13 20:30:00', '2026-05-13 20:30:00'),
(96, 88, 1390, 30, 1, '2026-05-13 20:33:23', '2026-05-13 20:33:23'),
(97, 89, 1367, 150, 1, '2026-05-13 20:36:08', '2026-05-13 20:36:08'),
(98, 90, 1390, 30, 1, '2026-05-13 20:41:38', '2026-05-13 20:41:38'),
(99, 91, 1390, 30, 1, '2026-05-13 20:43:35', '2026-05-13 20:43:35'),
(100, 92, 1390, 30, 1, '2026-05-13 20:49:20', '2026-05-13 20:49:20'),
(101, 93, 1390, 30, 1, '2026-05-13 20:52:32', '2026-05-13 20:52:32'),
(102, 94, 1390, 30, 2, '2026-05-14 16:18:08', '2026-05-14 16:18:08'),
(103, 95, 1367, 150, 1, '2026-05-14 16:24:22', '2026-05-14 16:24:22'),
(104, 96, 1367, 150, 1, '2026-05-14 16:26:42', '2026-05-14 16:26:42'),
(105, 97, 1367, 150, 1, '2026-05-14 16:27:52', '2026-05-14 16:27:52'),
(106, 98, 1390, 30, 1, '2026-05-14 16:28:43', '2026-05-14 16:28:43'),
(107, 99, 1390, 30, 1, '2026-05-14 16:29:27', '2026-05-14 16:29:27'),
(108, 100, 1390, 30, 1, '2026-05-14 16:30:08', '2026-05-14 16:30:08'),
(109, 101, 1367, 150, 1, '2026-05-14 16:31:11', '2026-05-14 16:31:11'),
(110, 102, 1367, 150, 1, '2026-05-14 16:33:55', '2026-05-14 16:33:55'),
(111, 103, 1367, 150, 1, '2026-05-14 16:41:37', '2026-05-14 16:41:37'),
(112, 104, 1390, 30, 1, '2026-05-14 16:43:19', '2026-05-14 16:43:19'),
(113, 105, 1390, 30, 1, '2026-05-14 16:44:09', '2026-05-14 16:44:09'),
(114, 106, 1390, 30, 1, '2026-05-14 16:45:38', '2026-05-14 16:45:38'),
(115, 107, 1390, 30, 1, '2026-05-14 16:48:02', '2026-05-14 16:48:02'),
(116, 108, 1390, 30, 1, '2026-05-14 16:51:27', '2026-05-14 16:51:27'),
(117, 109, 1390, 30, 1, '2026-05-14 16:53:18', '2026-05-14 16:53:18'),
(118, 110, 1390, 30, 1, '2026-05-14 16:57:48', '2026-05-14 16:57:48'),
(119, 111, 1390, 30, 1, '2026-05-14 16:58:21', '2026-05-14 16:58:21'),
(120, 112, 1390, 30, 1, '2026-05-14 17:01:26', '2026-05-14 17:01:26'),
(121, 113, 1390, 30, 1, '2026-05-14 17:02:52', '2026-05-14 17:02:52'),
(122, 114, 1390, 30, 1, '2026-05-14 17:06:20', '2026-05-14 17:06:20'),
(123, 117, 1390, 30, 1, '2026-05-14 17:59:52', '2026-05-14 17:59:52'),
(124, 125, 1390, 30, 1, '2026-05-15 09:40:19', '2026-05-15 09:40:19'),
(125, 133, 1390, 30, 1, '2026-05-15 11:54:27', '2026-05-15 11:54:27'),
(126, 134, 1, 60, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(127, 135, 1, 75, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(128, 136, 1, 100, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(129, 137, 1, 90, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(130, 138, 1, 45, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(131, 139, 1, 150, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(132, 140, 1, 55, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(133, 141, 1, 125, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(134, 142, 1, 70, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(135, 143, 1, 110, 2, '2026-05-15 17:10:25', '2026-05-15 17:10:25'),
(136, 144, 1390, 60, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(137, 145, 1391, 75, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(138, 146, 1392, 100, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(139, 147, 1393, 90, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(140, 148, 1394, 45, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(141, 149, 1395, 150, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(142, 150, 1396, 55, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(143, 151, 1397, 125, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(144, 152, 1398, 70, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(145, 153, 1399, 110, 2, '2026-05-15 17:58:03', '2026-05-15 17:58:03'),
(146, 1017, 1392, 100, 2, '2026-05-15 15:06:05', '2026-05-15 15:06:05'),
(147, 1020, 380, 150, 1, '2026-05-15 15:30:29', '2026-05-15 15:30:29'),
(148, 1021, 379, 150, 1, '2026-05-15 16:18:38', '2026-05-15 16:18:38'),
(149, 1022, 773, 150, 1, '2026-05-15 16:47:23', '2026-05-15 16:47:23'),
(150, 1023, 1390, 60, 2, '2026-05-15 16:48:39', '2026-05-15 16:48:39'),
(151, 1024, 1391, 75, 2, '2026-05-15 16:49:37', '2026-05-15 16:49:37'),
(152, 1025, 1398, 70, 2, '2026-05-15 17:04:27', '2026-05-15 17:04:27'),
(153, 1026, 773, 150, 2, '2026-05-15 17:15:53', '2026-05-15 17:15:53'),
(154, 1027, 1399, 110, 2, '2026-05-15 17:16:44', '2026-05-15 17:16:44'),
(155, 1028, 1395, 150, 2, '2026-05-15 18:39:12', '2026-05-15 18:39:12'),
(156, 1029, 772, 30, 1, '2026-05-15 20:02:46', '2026-05-15 20:02:46'),
(157, 1030, 772, 30, 1, '2026-05-15 20:05:54', '2026-05-15 20:05:54'),
(158, 1031, 772, 30, 1, '2026-05-15 20:06:00', '2026-05-15 20:06:00'),
(159, 1032, 772, 30, 1, '2026-05-15 20:06:38', '2026-05-15 20:06:38'),
(160, 1033, 772, 30, 1, '2026-05-15 20:07:06', '2026-05-15 20:07:06'),
(161, 1034, 1390, 30, 1, '2026-05-15 20:14:44', '2026-05-15 20:14:44'),
(162, 1035, 1390, 30, 1, '2026-05-15 20:14:49', '2026-05-15 20:14:49'),
(163, 1036, 1390, 30, 1, '2026-05-15 20:14:56', '2026-05-15 20:14:56'),
(164, 1037, 1390, 30, 2, '2026-05-15 20:15:16', '2026-05-15 20:15:16'),
(165, 1038, 1390, 30, 2, '2026-05-15 20:17:35', '2026-05-15 20:17:35'),
(166, 1039, 1390, 30, 2, '2026-05-15 20:17:38', '2026-05-15 20:17:38'),
(167, 1040, 772, 30, 1, '2026-05-15 20:24:39', '2026-05-15 20:24:39'),
(168, 1041, 774, 4200, 1, '2026-05-15 20:25:47', '2026-05-15 20:25:47'),
(169, 1042, 379, 150, 1, '2026-05-15 21:00:00', '2026-05-15 21:00:00'),
(170, 1043, 380, 150, 1, '2026-05-15 21:05:34', '2026-05-15 21:05:34'),
(171, 1044, 772, 30, 1, '2026-05-15 21:48:02', '2026-05-15 21:48:02'),
(172, 1045, 379, 150, 1, '2026-05-16 11:19:40', '2026-05-16 11:19:40'),
(173, 1046, 380, 150, 2, '2026-05-16 11:20:41', '2026-05-16 11:20:41'),
(174, 1047, 774, 5500, 2, '2026-05-16 11:22:08', '2026-05-16 11:22:08'),
(175, 1048, 1395, 150, 2, '2026-05-16 11:23:06', '2026-05-16 11:23:06'),
(176, 1049, 380, 250, 2, '2026-05-16 11:29:42', '2026-05-16 11:29:42'),
(177, 1050, 772, 30, 3, '2026-05-16 11:30:17', '2026-05-16 11:30:17'),
(178, 1051, 380, 250, 4, '2026-05-16 11:31:00', '2026-05-16 11:31:00'),
(179, 1052, 774, 4200, 1, '2026-05-16 11:36:55', '2026-05-16 11:36:55'),
(180, 1053, 774, 4200, 1, '2026-05-16 11:37:35', '2026-05-16 11:37:35'),
(181, 1054, 774, 4200, 1, '2026-05-16 11:39:23', '2026-05-16 11:39:23'),
(182, 1055, 379, 150, 1, '2026-05-16 19:27:55', '2026-05-16 19:27:55'),
(183, 1056, 380, 150, 1, '2026-05-16 19:45:56', '2026-05-16 19:45:56'),
(184, 1057, 380, 150, 1, '2026-05-16 20:21:21', '2026-05-16 20:21:21'),
(185, 1058, 774, 4200, 1, '2026-05-16 20:25:30', '2026-05-16 20:25:30'),
(186, 1059, 774, 4200, 1, '2026-05-16 20:27:59', '2026-05-16 20:27:59'),
(187, 1060, 774, 4200, 1, '2026-05-16 20:31:52', '2026-05-16 20:31:52'),
(188, 1061, 774, 4200, 1, '2026-05-17 06:38:19', '2026-05-17 06:38:19'),
(189, 1062, 774, 4200, 1, '2026-05-17 11:11:30', '2026-05-17 11:11:30'),
(190, 1063, 774, 4200, 1, '2026-05-17 11:33:50', '2026-05-17 11:33:50'),
(191, 1064, 379, 150, 2, '2026-05-17 12:08:54', '2026-05-17 12:08:54'),
(192, 1065, 380, 150, 1, '2026-05-17 12:14:23', '2026-05-17 12:14:23'),
(193, 1066, 378, 150, 1, '2026-05-17 12:21:02', '2026-05-17 12:21:02'),
(194, 1067, 772, 30, 2, '2026-05-17 12:23:29', '2026-05-17 12:23:29'),
(195, 1068, 380, 150, 1, '2026-05-17 12:40:49', '2026-05-17 12:40:49'),
(196, 1069, 380, 150, 1, '2026-05-17 12:41:41', '2026-05-17 12:41:41'),
(197, 1070, 380, 150, 1, '2026-05-17 12:51:53', '2026-05-17 12:51:53'),
(198, 1071, 772, 30, 1, '2026-05-17 12:59:48', '2026-05-17 12:59:48'),
(199, 1072, 772, 30, 1, '2026-05-17 13:03:17', '2026-05-17 13:03:17'),
(200, 1073, 379, 150, 1, '2026-05-17 13:21:02', '2026-05-17 13:21:02'),
(201, 1074, 1393, 90, 2, '2026-05-18 08:50:07', '2026-05-18 08:50:07'),
(202, 1075, 1394, 45, 2, '2026-05-18 08:55:19', '2026-05-18 08:55:19'),
(203, 1076, 1396, 55, 2, '2026-05-18 09:28:20', '2026-05-18 09:28:20'),
(204, 1078, 3, 100, 1, '2026-05-18 12:39:11', '2026-05-18 12:39:11'),
(205, 1077, 4, 150, 2, '2026-05-18 12:39:18', '2026-05-18 12:39:18'),
(206, 1077, 6, 120, 1, '2026-05-18 12:39:18', '2026-05-18 12:39:18'),
(207, 1079, 12, 40, 3, '2026-05-18 12:39:30', '2026-05-18 12:39:30'),
(208, 1079, 6, 120, 1, '2026-05-18 12:39:30', '2026-05-18 12:39:30'),
(209, 1080, 71, 120, 2, '2026-05-18 12:39:39', '2026-05-18 12:39:39'),
(210, 1081, 4, 150, 1, '2026-05-18 12:39:51', '2026-05-18 12:39:51'),
(211, 1081, 3, 100, 2, '2026-05-18 12:39:51', '2026-05-18 12:39:51'),
(212, 1082, 6, 120, 2, '2026-05-18 12:40:01', '2026-05-18 12:40:01'),
(213, 1083, 12, 40, 5, '2026-05-18 12:40:21', '2026-05-18 12:40:21'),
(214, 1084, 71, 120, 3, '2026-05-18 12:40:26', '2026-05-18 12:40:26'),
(215, 1084, 4, 150, 1, '2026-05-18 12:40:26', '2026-05-18 12:40:26'),
(216, 1085, 3, 100, 1, '2026-05-18 12:40:35', '2026-05-18 12:40:35'),
(217, 1086, 6, 120, 2, '2026-05-18 12:40:43', '2026-05-18 12:40:43'),
(218, 1086, 12, 40, 2, '2026-05-18 12:40:43', '2026-05-18 12:40:43'),
(219, 1087, 4, 150, 2, '2026-05-20 11:07:39', '2026-05-20 11:07:39'),
(220, 1087, 6, 120, 1, '2026-05-20 11:07:39', '2026-05-20 11:07:39'),
(221, 1088, 772, 30, 1, '2026-05-20 11:19:38', '2026-05-20 11:19:38'),
(222, 1089, 772, 30, 1, '2026-05-20 11:31:49', '2026-05-20 11:31:49'),
(223, 54, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(224, 55, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(225, 56, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(226, 57, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(227, 58, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(228, 59, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(229, 60, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(230, 61, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(231, 115, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(232, 116, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(233, 118, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(234, 119, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(235, 120, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(236, 121, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(237, 122, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(238, 123, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(239, 124, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(240, 126, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(241, 127, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(242, 128, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(243, 129, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(244, 130, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(245, 131, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(246, 132, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(247, 1014, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(248, 1015, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(249, 1018, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(250, 1019, 1, 0, 1, '2026-05-20 16:41:01', '2026-05-20 16:41:01'),
(251, 1090, 1413, 130, 2, '2026-05-21 06:35:26', '2026-05-21 06:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `business_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
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
(3, 'باقه البداية', 2, 'شهريه', 250.00, 30, 1, '2025-08-31 07:12:22', '2025-08-31 07:12:22'),
(4, 'باقه النمو', 3, 'نصف سنوية', 1250.00, 180, 1, '2025-08-31 07:15:39', '2025-08-31 07:15:39'),
(5, 'باقه التميز', 2, '(خصم٪20)سنويه', 2500.00, 360, 1, '2025-08-31 07:20:46', '2025-08-31 07:20:46'),
(7, 'free', 3, 'trail', 0.00, 5, 1, '2025-09-01 08:18:29', '2025-09-01 08:18:29'),
(8, 'agent', 2, 'ششششششششششششششش', 1452.00, 10, 1, '2026-04-16 19:58:17', '2026-04-16 19:58:17'),
(10, 'الباقة الصيفيه', 2, 'باقة مناسبة', 100.00, 10, 1, '2026-04-21 12:28:31', '2026-04-21 12:28:31'),
(11, 'qqq', 3, 'qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', 100.00, 60, 1, '2026-04-27 16:32:11', '2026-04-27 16:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `package_features`
--

CREATE TABLE `package_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
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
(68, 11, 'aaaaaaaaaaaaaaaaaaaaaa', '2026-05-21 08:57:02', '2026-05-21 08:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `package_permissions`
--

CREATE TABLE `package_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `permission_key` varchar(191) NOT NULL,
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
(300, 11, 'dashboard.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(301, 11, 'emenu.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(302, 11, 'categories.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(303, 11, 'products.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(304, 11, 'sliders.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(305, 11, 'orders.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(306, 11, 'orders.all', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(307, 11, 'orders.delivery', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(308, 11, 'orders.pickup', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(309, 11, 'orders.local', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(310, 11, 'pos.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(311, 11, 'management.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(312, 11, 'users.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(313, 11, 'roles.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(314, 11, 'branches.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(315, 11, 'branch_creation_request.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(316, 11, 'branch_links.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(317, 11, 'shifts.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(318, 11, 'attendances.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(319, 11, 'cashier-cash-reports.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(320, 11, 'inventory.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(321, 11, 'barcodes.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(322, 11, 'inventory.dashboard', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(323, 11, 'inventory.suppliers', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(324, 11, 'inventory.categories', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(325, 11, 'units.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(326, 11, 'inventory.materials', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(327, 11, 'inventory.purchase_requests', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(328, 11, 'inventory.purchase_orders', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(329, 11, 'inventory.receipts', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(330, 11, 'inventory.production_orders', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(331, 11, 'inventory.transfer_requests', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(332, 11, 'inventory.stock_counts', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(333, 11, 'inventory.movements', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(334, 11, 'reports.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(335, 11, 'reports.sales', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(336, 11, 'reports.top_products', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(337, 11, 'reports.staff_performance', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(338, 11, 'settings.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(339, 11, 'settings.general', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(340, 11, 'payment_methods.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(341, 11, 'tables_areas.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(342, 11, 'charges.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(343, 11, 'invoices.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(344, 11, 'invoices.print', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(345, 11, 'pos.print', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(346, 11, 'shift_receipts.access', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(347, 11, 'orders.returns', '2026-05-21 08:57:02', '2026-05-21 08:57:02'),
(348, 11, 'orders.update_source', '2026-05-21 08:57:02', '2026-05-21 08:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `phone`, `is_active`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'cash', 'الدفع كاش', '01093334419', 1, '2025-08-30 08:09:37', '2026-05-13 20:01:35', 71),
(2, 'Vodafone Cash', 'تحويل الأموال عبر فودافون كاش', '01069944482', 1, '2025-08-30 08:09:37', '2026-01-08 08:13:49', 71),
(3, 'InstaPay', 'الدفع بواسطة انستاباى', '01325369874', 1, '2026-05-13 20:51:24', '2026-05-13 20:51:24', 71);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `group` varchar(191) DEFAULT NULL,
  `user_role` varchar(191) DEFAULT NULL,
  `guard_name` varchar(191) NOT NULL,
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
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
(79, 'App\\Models\\Customer', 2, 'customer-token', 'b30055f4fd5cce58edd0b7d75108bb4126f47de3b7977736c40e5f0fb88ce99b', '[\"*\"]', '2026-01-26 01:24:30', NULL, '2026-01-26 01:23:21', '2026-01-26 01:24:30'),
(80, 'App\\Models\\User', 2, 'auth_token', '847041ee07c09d485ae72ebb56ee8e1b0323526f3c7978f7cd8c3e52febb74b9', '[\"*\"]', '2026-05-14 19:55:21', NULL, '2026-05-14 19:47:29', '2026-05-14 19:55:21'),
(81, 'App\\Models\\User', 2, 'auth_token', '4b935f0e382baf30d96ca647819204de11f338608903e22cf6e042617ade5d85', '[\"*\"]', NULL, NULL, '2026-05-14 19:56:58', '2026-05-14 19:56:58'),
(82, 'App\\Models\\User', 2, 'auth_token', 'e6dc9490caf67d76f9c41728422fe96512862b60704c46118422463d5b07003c', '[\"*\"]', '2026-05-14 20:06:19', NULL, '2026-05-14 20:00:39', '2026-05-14 20:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `production_orders`
--

CREATE TABLE `production_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `production_number` varchar(191) NOT NULL,
  `production_date` date NOT NULL,
  `planned_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `produced_quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `status` enum('draft','approved','produced','cancelled') NOT NULL DEFAULT 'draft',
  `total_cost` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_orders`
--

INSERT INTO `production_orders` (`id`, `user_id`, `recipe_id`, `production_number`, `production_date`, `planned_quantity`, `produced_quantity`, `status`, `total_cost`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, 'PD-20260420001458', '2026-04-20', 5.000, 3.000, 'produced', 666.000, 'اهلا', '2026-04-22 22:14:58', '2026-04-19 22:32:40', NULL);

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
(1, 1, 1, 1, 5.000, 2.000, 333.000, 666.000, '2026-04-19 22:14:58', '2026-04-19 22:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('ready','manufactured','raw') NOT NULL DEFAULT 'ready',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `barcode` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(191) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Purchase_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `type`, `user_id`, `name`, `barcode`, `description`, `cover`, `price`, `created_at`, `updated_at`, `Purchase_price`, `selling_price`) VALUES
(9, 130, 'ready', 71, 'شطيرة شاورما دجاج', 'P00000009', 'شاورما دجاج', '1755350079.jpeg', 150.00, '2025-08-16 13:14:39', '2025-08-16 13:14:39', 100.00, 150.00),
(10, NULL, 'ready', 71, 'شاورما الديك الرومي', 'P00000010', 'شاورما الديك الرومي', '1755350627.png', 150.00, '2025-08-16 13:23:47', '2025-08-16 13:23:47', 100.00, 150.00),
(11, 12, 'ready', 79, 'برجر', 'P00000011', 'برجر', '1755351017.jpeg', 150.00, '2025-08-16 13:30:17', '2025-08-16 13:30:17', 100.00, 150.00),
(12, 12, 'ready', 79, 'برجر ستيشن', 'P00000012', 'برجر ستيشن', '1755351212.jpeg', 150.00, '2025-08-16 13:33:32', '2025-08-16 13:33:32', 100.00, 150.00),
(13, 12, 'ready', 79, 'دبل تشيز برجر', 'P00000013', 'دبل تشيز برجر', '1755351360.jpeg', 150.00, '2025-08-16 13:36:00', '2025-08-16 13:36:00', 100.00, 150.00),
(14, 13, 'ready', 79, 'بيتزا ايطالية', 'P00000014', 'بيتزا ايطالية', '1755351509.jpeg', 150.00, '2025-08-16 13:38:29', '2025-08-16 13:38:29', 100.00, 150.00),
(15, 13, 'ready', 79, 'باستا بيتزا', 'P00000015', 'باستا بيتزا', '1755351631.jpeg', 150.00, '2025-08-16 13:40:31', '2025-08-16 13:40:31', 100.00, 150.00),
(16, 13, 'ready', 79, 'بيتزا خضار', 'P00000016', 'بيتزا خضار', '1755351784.jpeg', 150.00, '2025-08-16 13:43:04', '2025-08-16 13:43:04', 100.00, 150.00),
(17, NULL, 'ready', 79, 'الفطير المشلتت', 'P00000017', 'الفطير المشلتت', '1755351950.jpeg', 150.00, '2025-08-16 13:45:50', '2025-08-16 13:45:50', 100.00, 150.00),
(18, NULL, 'ready', 79, 'فطائر الجبنة', 'P00000018', 'فطائر الجبنة', '1755352056.jpeg', 150.00, '2025-08-16 13:47:36', '2025-08-16 13:47:36', 100.00, 150.00),
(21, 24, 'ready', 79, 'test', 'P00000021', 'te', 'products/SpCsKqU4t09yaWhje7zcgDuoblTNv4fbCmXZ7GNk.png', 150.00, '2025-08-31 09:24:29', '2025-08-31 09:24:29', 100.00, 150.00),
(22, 24, 'ready', 79, 'pro', 'P00000022', 'test', 'products/D8j1Q2kbLzTDfRmMfyUQHbbFkAm7vwrYnuLuaXTN.png', 150.00, '2025-08-31 09:37:19', '2025-08-31 09:37:19', 100.00, 150.00),
(26, 24, 'ready', 79, 'Amr', 'P00000026', 'test', 'products/rUmLQb5EtZakVsFfYIfYJGJoR4OyjG0jmoxxT1Ha.png', 150.00, '2025-08-31 10:40:40', '2025-08-31 10:40:40', 100.00, 150.00),
(27, 24, 'ready', 79, 'باقة سنوية', 'P00000027', 'te', 'products/txOPkMsMWfNj6LLIsZIjrdRvcIVjX0UR5ecoh9rb.png', 150.00, '2025-08-31 10:41:10', '2025-08-31 10:41:10', 100.00, 150.00),
(53, 34, 'ready', 79, 'Burger', 'P00000053', 'Hot Burger', 'products/udjyuba0vd0Qqi9Wo4E26dEy3KPKVPUJRGh05wNW.png', 150.00, '2025-09-03 15:23:13', '2025-09-03 15:23:13', 100.00, 150.00),
(55, 34, 'ready', 79, 'test', 'P00000055', 'هيضاف', 'products/7EMuZuBnfbMJArb5qpOjgeC7QeCwy4l2ySLAMOKw.png', 150.00, '2025-09-04 09:37:03', '2025-09-04 09:37:03', 100.00, 150.00),
(57, 34, 'ready', 79, 'Kno', 'P00000057', 'let`s see', 'products/S7GQwjznex401JgRDeoOP87RJtBy6FuOhg7rndWs.png', 150.00, '2025-09-04 09:39:53', '2025-09-04 09:39:53', 100.00, 150.00),
(272, 88, 'ready', 79, 'عطر سينس لافيرن نسائي', 'P00000272', '😍😍😍😍🤩🤩🤩🤩 عطر سينس لافيرن نسائي  برفيوم جورجينا التريند 😍😍😍✌️  من وحي زهرةٍ تمايلت كراقصة باليه ومن أسرار الأنوثة التي عجز الشعراء عن كشفها! صُمم سينس ليجعل للأنوثة ملامح تبتسم وتقول : أنا أشعر إذن أنا موجودة! هو كلمة \"أحبك\" التي توجهينها لنفسك اولاً ثم للعالم..  رحلة تصميم العطر : سينس لم يكن صدفة! بل كان نتيجة رحلة من التخطيط والعمل تجاوزت عاماً بأكمله.. ابتكرت خلالها داليا ايزم بالتعاون مع جورجينا رودريغيز أكثر من ٧٤٠ عينة! لتختار اخيراً جورجينا التركيبة المثالية التي تجسد كل مشاعرها في زجاجة عطر.. ليكون سينس جامعًا لكل أسرار الأنوثة في زجاجة.  التركيبة : الافتتاحية : الكشمش الأسود، اليوسفي القلب : الياسمين، السوسن، الكشمير، زهر البرتقال القاعدة : المسك  عطر-سينس-لافيرن حجم العطر : 75 مل', 'products/8GlE8QiNluKHz0awhceiAob1Deh3iULG69zOBB4F.jpg', 150.00, '2025-12-02 21:21:13', '2025-12-02 21:21:13', 100.00, 150.00),
(273, 88, 'ready', 79, 'برفان حريمي 212 sexy', 'P00000273', 'برفان حريمي 212 sexy 💛💛🌸🌸  انا فتحتلي واحده 🌸🌸ايه داا ..فظيعه بجد.ازازتين فى واحده .... الاختيااار الاؤل للعرايس فعلااااا 💋💋😍😍 ريحتها وووهم وثابته.جداااا لو نفسك فحاجه 🙊🙊🙊 😉 كده ومختلفه  212 بتقولك انا اهو بتقولك اللي يجربني مش هيغيرني 💜 ❤️❤️💋😘 كوني مميزه ومختلفه مع عطر 212 ع ضمنتي..... من جماله عمرك ماهتقدري تستغني عنو  😍💥💥💥', 'products/CpVXckfMTCLRzpdDN5evwX4FGMlcf2RhYffuAlx7.jpg', 150.00, '2025-12-02 21:21:55', '2025-12-02 21:21:55', 100.00, 150.00),
(274, 88, 'ready', 79, 'Valentino Uomo Born in Roma', 'P00000274', '100 ml ❤❤❤ VALENTINO ❤❤❤  فلانتينو للرجال 🖤  أحد أفخم وأقوى ابداعات فلانتينو♥️ فهو يوصف بأنه مزیج من  الكلاسیكیة  🚧 Valentino Uomo Intense - فلانتينو   عطر بودري زهري مع جلود للرجال ⚓   ثبات وفوحان وأداء قوي ومعاك لفترة طويلة على الملابس🕖🔊  عطر عالمي جذاب من العطورات بتدمج بين الماضي والحاضر 🖤   برفان ملئ بالجمال واناقه لا متناهيه يعبر عن القوة والشجاعة 😎  إفتتاحية العطر ✨ الماندرين (اليوسفي) و المريمية 🍊 قلب العطر ✨ السوسن و حبوب التونكا🫚 قاعدة العطر ✨  الفانيليا و الجلود🌿', 'products/h9noIi7OlYWgWjGpJOR8qf5LeLh45vePhyQyH5k4.jpg', 150.00, '2025-12-02 21:22:54', '2025-12-02 21:22:54', 100.00, 150.00),
(275, 88, 'ready', 79, 'Jean Paul Gaultier La Belle Le Parfum', 'P00000275', 'الأنوثة المُركّزة في زجاجة حمراء😍، عطر شرقي زكي الرائحة مُمتع، مُركّز و مُغري يبرز قوة المرأة ويزيد من حِدّة جاذبيتها بمتعة أخاذة لا يمكن مقاومتها .  عطر شرقي - فانيليا للنساء حسِّي ، فتّان و مغوي بالدرجة الاولى ذو فوحان و ثبات عالي جداً يليق بلأجواء الباردة❄️ . عطر في منتهى الأنوثة و الجاذبية لا تفوتوا تجربته استسلم للروائح الشرقية للعطر الجديد La Belle le Parfum من Jean-Paul Gaultier. قصيدة للأنوثة الفائقة ، مركّزة في زجاجة حمراء ذات منحنيات مدمرة ، تعلوها عقد من الورود الذهبية. تغلفك المكونات الشرقية والذواقة لهذا العطر الجذاب طوال اليوم. استسلم للإغراء اليوم واكتشف العطر النسائي', 'products/nyNHM7Npw3PEPrAD5mWK4cIBunC7n9Jh1f3lP2Cf.jpg', 150.00, '2025-12-02 21:23:49', '2025-12-02 21:23:49', 100.00, 150.00),
(276, 88, 'ready', 79, 'Bonbon viktor and rolf 🍬 For women', 'P00000276', 'اخيرا بونبون 🔥🔥  بونبون وهي اسم علي مسمي بجد   كراميل وشوجري🩷🧡 كل اللي عايز حاجه سيكسي بجد ياخدها حلووووووه موووت🙈🙈🙈  جديدة معانا 30 ml 💥💥 Travel size 30 ml Bonbon Viktor&Rolf  عطر زهري - فواكه إفتتاحية العطر الخوخ, الماندرين (اليوسفي) و البرتقال; قلب العطر الكاراميل, زهر البرتقال و الياسمين;  قاعدة العطر تتكون من العنبر, خشب الصندل, أخشاب الغاياك و خشب الأرز.حجم 100 مللي', 'products/JMFlSvdgJBttxkd8x6rgcdyHRw6U5RC27DkC3hHg.jpg', 150.00, '2025-12-02 21:25:10', '2025-12-02 21:25:10', 100.00, 150.00),
(278, 89, 'ready', 71, 'بيتزا', 'P00000278', 'بيتزا فراخ وجبنه', 'products/4gCkUX1LlwZCIPf1K81WUnNpcXOJj7p8NJmNHGSI.jpg', 150.00, '2025-12-04 19:52:25', '2025-12-04 19:52:25', 100.00, 150.00),
(279, 89, 'ready', 79, 'وجبه فراخ', 'P00000279', 'نص فرخه مع بطاطس مع رز مع صلصات', 'products/CWc2CQebFUwRJthRQcfAiqxwR8WXnlpNt3tdE3Ye.jpg', 150.00, '2025-12-04 19:54:02', '2025-12-04 19:54:02', 100.00, 150.00),
(280, 89, 'ready', 71, 'مكرونه بشامل', 'P00000280', 'مكرونه بشامل بصوص الفراخ', 'products/bUAHD5j8zt9CleueYb2Rsp6fSbQIO7EDzib1iD6F.jpg', 150.00, '2025-12-04 19:54:50', '2025-12-04 19:54:50', 100.00, 150.00),
(281, 89, 'ready', 71, 'سلطه خضراوات', 'P00000281', 'سلطه خضراوات', 'products/5E5KvC6QEqS1ok0vfhFlhyx7QtCWn0j1iYPHNLpd.jpg', 150.00, '2025-12-04 19:55:41', '2025-12-04 19:55:41', 100.00, 150.00),
(282, 90, 'ready', 71, 'عصير فراوله', 'P00000282', 'عصير فراوله', 'products/goqXmrYKUzCBZskEYZXeHhviEioJjphPKDpQ9rKV.jpg', 150.00, '2025-12-04 20:01:32', '2025-12-04 20:01:32', 100.00, 150.00),
(283, 90, 'ready', 71, 'عصير لمون', 'P00000283', 'عصير لمون طازه', 'products/dfFRFU1Qd43xk4nAOYMrACcA6s6LPqQxnXflc1hm.jpg', 150.00, '2025-12-04 20:02:21', '2025-12-04 20:02:21', 100.00, 150.00),
(284, 90, 'ready', 71, 'عصير توت', 'P00000284', 'عصير توت طازه', 'products/ICdCKEuu1kKuSbazp07tDQOsMNXw9ROJSU2ooQw1.jpg', 150.00, '2025-12-04 20:04:39', '2025-12-04 20:04:39', 100.00, 150.00),
(285, 90, 'ready', 71, 'عصير برتقال', 'P00000285', 'عصير برتقال طازه', 'products/cemGZKLVVnNwMjFJDhNfCND8KtIsJoMWXsGVUKoE.jpg', 150.00, '2025-12-04 20:05:48', '2025-12-04 20:05:48', 100.00, 150.00),
(286, 90, 'ready', 71, 'عصير انناس 55', 'P00000286', 'عصير انناس طازه', '1778429249.jpg', 150.00, '2025-12-04 20:07:06', '2026-05-10 13:07:29', 100.00, 150.00),
(287, 91, 'ready', 71, 'شاي 66', 'P00000287', 'شاي فتله', 'products/lQPud4Gz7buMpWTC6QD8xdlBlbdT1CKQcT0ha1wG.jpg', 150.00, '2025-12-04 20:13:56', '2025-12-04 20:13:56', 100.00, 150.00),
(288, 91, 'ready', 71, 'نسكافيه بالبن', 'P00000288', 'نسكافيه باللبن', 'products/NL5Mnfr7M5kEKexWrstPWpGAqpEWOFmLD5ZCsqXS.jpg', 150.00, '2025-12-04 20:14:45', '2025-12-04 20:14:45', 100.00, 150.00),
(289, 91, 'ready', 71, 'شيكولاتا سخنه', 'P00000289', 'شيكولاتا سخنه', 'products/EEArj15iPPHZkJ8fCxcGSRoc5VEKyU1Eu4wQIw3P.jpg', 150.00, '2025-12-04 20:15:33', '2025-12-04 20:15:33', 100.00, 150.00),
(290, 91, 'ready', 71, 'قهوه مانو', 'P00000290', 'شهوه مانو', 'products/Xfrq5QUeWaQDlConjGviiYXGyGBEECFxTEeSL82A.jpg', 150.00, '2025-12-04 20:16:40', '2025-12-04 20:16:40', 100.00, 150.00),
(291, 91, 'ready', 71, 'شاي بالنعناع', 'P00000291', 'شاي بالنعناع', 'products/P6P8C3RRAFVOd9xS0b2pdRGaIqt4RlehBYsc83rt.jpg', 150.00, '2025-12-04 20:18:18', '2025-12-04 20:18:18', 100.00, 150.00),
(293, 92, 'ready', 71, 'عطور بلو', 'P00000293', 'اجود انواع العطور', 'products/67qyIJRxotQb5exfrxMbrYWqgePTTZOOGdLFkmdZ.jpg', 150.00, '2025-12-04 20:24:49', '2025-12-04 20:24:49', 100.00, 150.00),
(294, 92, 'ready', 71, 'عطور برادا', 'P00000294', 'اجود انواع العطور', 'products/yKrAqoZe11ArpjaXk0B5JqDFGPmzlKhiNsudDmEt.jpg', 150.00, '2025-12-04 20:25:31', '2025-12-04 20:25:31', 100.00, 150.00),
(295, 92, 'ready', 71, 'عطور سوفاج', 'P00000295', 'اجود انواع العطور', 'products/ZzZb6HHXugOxCqOxRDdHKEWCO8ukZ7n1gVwADSIH.jpg', 150.00, '2025-12-04 20:26:42', '2025-12-04 20:26:42', 100.00, 150.00),
(296, 92, 'ready', 71, 'عطور فرانك', 'P00000296', 'اجود انواع العطور', 'products/e3Gt64Fab83sEogUAHvqGfVBZcqGgpxiK1xPK76e.jpg', 150.00, '2025-12-04 20:27:41', '2025-12-04 20:27:41', 100.00, 150.00),
(297, 92, 'ready', 71, 'عطور سكندال', 'P00000297', 'اجود انواع العطور', 'products/4BAqqj7zKCHSDqOSM0Syn2uVciLvjqvu5VTqZO26.jpg', 150.00, '2025-12-04 20:28:18', '2025-12-04 20:28:18', 100.00, 150.00),
(298, 93, 'ready', 80, 'كلاسيك برجر', 'P00000298', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+تيستي', 'products/CCwawi6cR9yJDeQs2LOwLUqswJ70TR3UE1EVJZSS.jpg', 150.00, '2025-12-08 17:48:02', '2025-12-08 17:48:02', 100.00, 150.00),
(299, 93, 'ready', 80, 'بيكون', 'P00000299', 'شريحة لحم+صوص شيدر +خص+خيار مخلل+تيستي بيكون', 'products/WGWYDWD1sGCOISCBE4EPbJl7g9FWnlauQOeOMPFF.jpg', 150.00, '2025-12-08 17:52:14', '2025-12-08 17:52:14', 100.00, 150.00),
(300, 93, 'ready', 80, 'تشيز', 'P00000300', 'قطعة لحم١٥٠ جرام +صوص شيدر+خص+خيار مخلل+شريحة جبنه شيدر+تيستي', 'products/uCkngliyRKSrrlR7eRen7ui8NOFd18xTUIU47aU8.jpg', 150.00, '2025-12-08 17:55:47', '2025-12-08 17:55:47', 100.00, 150.00),
(301, 93, 'ready', 80, 'مشروم', 'P00000301', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+مشروم', 'products/i6eTEYgfOYp9bnfyWsibAiTdGiTeZomSjwqtafoS.jpg', 150.00, '2025-12-08 17:58:34', '2025-12-08 17:58:34', 100.00, 150.00),
(302, 93, 'ready', 80, 'BunnBeef', 'P00000302', 'قطعه لحم ١٥٠ جرام +صوص شيدر +خص+خيار مخلل+موتزريلا ستيكس', 'products/HjdrNBMA6YrJSrFGlcDaZL7B4WrCH4gO5ufBhjsG.jpg', 150.00, '2025-12-08 18:02:26', '2025-12-08 18:02:26', 100.00, 150.00),
(303, 93, 'ready', 80, 'ميكس بيف فرايد', 'P00000303', 'قطعة لحم١٥٠ جرام +قطعة فراخ ١٠٠جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل', 'products/8WzRKYh8YX5fagJ19rg1e4W9jbv1qyEDe4bOT0Ep.jpg', 150.00, '2025-12-08 18:11:54', '2025-12-08 18:11:54', 100.00, 150.00),
(304, 94, 'ready', 80, 'كلاسيك', 'P00000304', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل', 'products/6ws3htAwYtc54oxU72fK7VS2kVmJtr8AwydJe4ru.jpg', 150.00, '2025-12-08 18:14:36', '2025-12-08 18:14:36', 100.00, 150.00),
(305, 94, 'ready', 80, 'بيكون', 'P00000305', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+بيكون', 'products/MYFvKu7AUDo0gfsRzI90Zbj4gLOdJXfeW5wTbBZv.jpg', 150.00, '2025-12-08 18:16:38', '2025-12-08 18:16:38', 100.00, 150.00),
(306, 94, 'ready', 80, 'مشروم', 'P00000306', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+مشروم', 'products/qi24y0DrJCAzDACq6GFPgK0SbS79Eb271VvOrKAq.jpg', 150.00, '2025-12-08 18:18:19', '2025-12-08 18:18:19', 100.00, 150.00),
(307, 94, 'ready', 80, 'بافلو', 'P00000307', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+بافلو', 'products/o7T1lDaKAkjebzIAAEGg3FpPHudmFRJZTA19DgXA.jpg', 150.00, '2025-12-08 18:22:27', '2025-12-08 18:22:27', 100.00, 150.00),
(308, 94, 'ready', 80, 'بيكون مشروم', 'P00000308', 'قطعة لحم١٠٠ جرام +صوص شيدر+خص+خيار مخلل+بصل مكرمل+مشروم+بيكون', 'products/blJt0bF7DdFzWdLPdFaNQJMrYkpmRXDf8rBKYFTV.jpg', 150.00, '2025-12-08 18:24:30', '2025-12-08 18:24:30', 100.00, 150.00),
(309, 95, 'ready', 80, 'كلاسيك', 'P00000309', 'قطعة فراخ ١٠٠ جرام +مايونيز +صوص شيدر+خص+خيار مخلل', 'products/EfMeiFM8vNKUgbxcJrlCycVR362NvjSVuswfEjVb.jpg', 150.00, '2025-12-08 18:27:35', '2025-12-08 18:27:35', 100.00, 150.00),
(311, 95, 'ready', 80, 'تركي', 'P00000311', 'قطعة فراخ ١٠٠ جرام +مايونيز +صوص شيدر+خص+خيار مخلل+تركي', 'products/9m8va3MFoXKXQunu6WwQR4eEtUuV0OYZm8DRFxuJ.jpg', 150.00, '2025-12-08 18:30:41', '2025-12-08 18:30:41', 100.00, 150.00),
(312, 95, 'ready', 80, 'رانش', 'P00000312', 'قطعة فراخ ١٠٠ جرام +صوص رانش+صوص شيدر+خص+خيار مخلل', 'products/8MHVSlfrIr96q1KiZQRyltxf9vwQi96IXqx4p5GO.jpg', 150.00, '2025-12-08 18:34:13', '2025-12-08 18:34:13', 100.00, 150.00),
(313, 95, 'ready', 80, 'بافلو', 'P00000313', 'قطعة فراخ ١٠٠ جرام +صوص بافلو+صوص شيدر+خص+خيار مخلل', 'products/6XvTQQwoFPlhWLAVgf9wuFM9eE3A5QIkBixhdhB1.jpg', 150.00, '2025-12-08 18:36:33', '2025-12-08 18:36:33', 100.00, 150.00),
(314, 95, 'ready', 80, 'بنن بيف', 'P00000314', 'قطعة فراخ ١٠٠ جرام +موتزريلا ستكس+تركي+صوص شيدر+خص+خيار مخلل+تيستي', 'products/xci1eLQXnsoHyQwCDSI8M41OyTIfFhjGsB3PXYT1.jpg', 150.00, '2025-12-08 18:46:43', '2025-12-08 18:46:43', 100.00, 150.00),
(315, 95, 'ready', 80, 'مدخن جريل', 'P00000315', 'خص+خيار مخلل+قطعه فراخ ١٥٠ جرام علي الجريل +صوص شيدر+تيستي', 'products/Fcjp3BlUgHi0k0CwwdwYNu6TbU1mc5GlUFNmbqa0.jpg', 150.00, '2025-12-08 18:55:44', '2025-12-08 18:55:44', 100.00, 150.00),
(316, 96, 'ready', 80, 'باكت فرايز', 'P00000316', 'باكت فرايز', 'products/sAAWJ0kRnx7ujXpOm72XF7s23asQmYEGVGPq5Kxk.jpg', 150.00, '2025-12-08 18:58:39', '2025-12-08 18:58:39', 100.00, 150.00),
(317, 96, 'ready', 80, 'فرسكس فرايز', 'P00000317', 'فرسكس فرايز', 'products/uxvYpVXvgp9VdCCXU6Yy74je4otvnheyLfqv9g3M.jpg', 150.00, '2025-12-08 19:00:13', '2025-12-08 19:00:13', 100.00, 150.00),
(318, 96, 'ready', 80, 'بافلو فرايز', 'P00000318', 'بافلو فرايز', 'products/KUi8FaLrvz7mSoiEGkfmCtJshWIMZlwv1tePNqPj.jpg', 150.00, '2025-12-08 19:02:09', '2025-12-08 19:02:09', 100.00, 150.00),
(319, 96, 'ready', 80, 'بيكون فرايز', 'P00000319', 'بيكون فرايز', 'products/Z25VaXvLwOhI8QAYlTbiTXezb76Ub8FJjelD3QiN.png', 150.00, '2025-12-08 19:03:40', '2025-12-08 19:03:40', 100.00, 150.00),
(320, 96, 'ready', 80, 'تشيز فرايز', 'P00000320', 'تشيز فرايز', 'products/IvIxYLNFlg6VUWqhfaBFmHVjjzeSohwgPTy10UbB.jpg', 150.00, '2025-12-08 19:07:04', '2025-12-08 19:07:04', 100.00, 150.00),
(321, 96, 'ready', 80, 'كرانشي فرايز', 'P00000321', 'كرانشي فرايز', 'products/n9A1OdPEvdA5iVxaLVwIOJK4GGbMPzzOnwZUxsRS.webp', 150.00, '2025-12-08 19:08:53', '2025-12-08 19:08:53', 100.00, 150.00),
(322, 96, 'ready', 80, 'تشيلي فرايز', 'P00000322', 'تشيلي فرايز', 'products/wJVUM6qXHREjpG6oh2Hu8aEU9ihmHQDb2ita8GOk.jpg', 150.00, '2025-12-08 19:10:28', '2025-12-08 19:10:28', 100.00, 150.00),
(323, 96, 'ready', 80, 'حلقات بصل', 'P00000323', 'حلقات بصل 6 قطع', 'products/Tzr0U4JZ0qz81wCnEUqnvExFcm4uSglfEnAUzVll.png', 150.00, '2025-12-08 19:11:59', '2025-12-08 19:11:59', 100.00, 150.00),
(324, 96, 'ready', 80, 'موتزريلا ستيكس', 'P00000324', 'موتزريلا ستيكس ٣ قطع', 'products/qa9XrGucK16COSbVHGaMJO8vDmTQHD9lyEdK9tmz.webp', 150.00, '2025-12-08 19:13:18', '2025-12-08 19:13:18', 100.00, 150.00),
(325, NULL, 'ready', 80, 'كفته بلدي', 'P00000325', 'كفته بلدي +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/SZzOfRULfQHZ66VjCkaFEipEgv1MCvxDW7yl5nFT.jpg', 150.00, '2025-12-08 19:46:26', '2025-12-08 19:51:28', 100.00, 150.00),
(326, NULL, 'ready', 80, 'سجق بلدي', 'P00000326', 'سجق بلدي +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/AL1f1TZbmZzupMykkHBHDtV5sQZErGtbzgdgy2T4.jpg', 150.00, '2025-12-08 19:48:15', '2025-12-08 19:51:09', 100.00, 150.00),
(328, NULL, 'ready', 80, 'شيش طاووق', 'P00000328', 'شيش طاووق +سلطه بلدي +سلطه طحينه+رز بسمتي او عيش', 'products/uUkqeNVhO9dus5McDi74HnAo2oRbBAGLwecLMQhp.jpg', 150.00, '2025-12-08 19:53:00', '2025-12-08 19:53:00', 100.00, 150.00),
(330, 97, 'ready', 80, 'ساندوتش كفتة', 'P00000330', 'ساندوتش كفتة + علبه طحينة+علبة سلطة', 'products/mOOKXP7krAOsqbBrIWJK9mYJmcY2nqyZk5Kgjsw3.jpg', 150.00, '2025-12-08 19:59:19', '2025-12-08 19:59:19', 100.00, 150.00),
(332, 97, 'ready', 80, 'ساندوتش شيش طاووق', 'P00000332', 'شيش طاووق +كاتشب', 'products/9fSQ0Cvtp2qUp4fOlFNWBGhjqSaNoh21iFEhUr6s.jpg', 150.00, '2025-12-08 20:06:01', '2025-12-08 20:06:17', 100.00, 150.00),
(333, 97, 'ready', 80, 'ساندوتش تشكن رنش', 'P00000333', 'تشكن رنش+كاتشب', 'products/h6fln6ljXkpMAESeAoHmQrJpFijmiGSy6cwlBTxi.png', 150.00, '2025-12-08 20:08:01', '2025-12-08 20:08:01', 100.00, 150.00),
(334, 97, 'ready', 80, 'ساندوتش حواوشي كبير', 'P00000334', 'حواوشي+كاتشب +طحينة', 'products/ACmf97teHvTWnr92zXvsvDIM9Yq2PmCwgIsoMYlZ.jpg', 150.00, '2025-12-08 20:09:41', '2025-12-24 14:33:06', 100.00, 150.00),
(335, 97, 'ready', 80, 'ساندوتش حوواوشي جبنة', 'P00000335', 'حوواوشي جبنة+طحينة+كاتشب', 'products/yxSHAqmDvNZ4pyjx82ag4olyDh0YzxkPhOmbMUeo.avif', 150.00, '2025-12-08 20:14:01', '2025-12-08 20:14:01', 100.00, 150.00),
(336, 97, 'ready', 80, 'ساندوتش بطاطس', 'P00000336', 'ساندوتش بطاطس+صوص+كاتشب', 'products/nXggwWl5nfI1lTCLrWc9EnMma3txplEfPWIPBMDf.jpg', 150.00, '2025-12-08 20:20:28', '2025-12-08 20:20:28', 100.00, 150.00),
(337, 98, 'ready', 80, 'استربس', 'P00000337', 'استربس+كاتشب', 'products/mxLk29BLod7vVZG6nITrPeXYIT2aK6CYG4ZOSznj.jpg', 150.00, '2025-12-08 20:22:53', '2025-12-08 20:22:53', 100.00, 150.00),
(338, 98, 'ready', 80, 'شيش فحم', 'P00000338', 'شيش فحم+كاتشب', 'products/sufQqPWn7MlmNu5ArXvNJSgKXMx8FrG23vIYnrdu.jpg', 150.00, '2025-12-08 20:24:54', '2025-12-08 20:24:54', 100.00, 150.00),
(339, 98, 'ready', 80, 'كرسبي حار', 'P00000339', 'كرسبي حار+كاتشب', 'products/JF44c8JtWtd4q40RZjq3LOMhitCkODt6UMDjCn9X.jpg', 150.00, '2025-12-08 20:26:36', '2025-12-08 20:26:36', 100.00, 150.00),
(340, 98, 'ready', 80, 'ميكس فراخ', 'P00000340', 'ميكس فراخ+كاتشب', 'products/hSArqKj593JUTy4hLqPREaoiNw6UISaRT5OnSIKF.jpg', 150.00, '2025-12-08 20:28:35', '2025-12-08 20:28:35', 100.00, 150.00),
(341, 98, 'ready', 80, 'ميكس لحوم', 'P00000341', 'ميكس لحوم +كاتشب', 'products/6X5i7VKnbgQ6E5MqakJpntBkWsuiAOKW6q0fIbFa.jpg', 150.00, '2025-12-08 20:30:17', '2025-12-08 20:30:17', 100.00, 150.00),
(342, 98, 'ready', 80, 'كريب بطاطس', 'P00000342', 'بطاطس+كاتشب', 'products/I5jjiqpOA7vcdp1Ni3ma7YcTZrGmyhiIZQMhdg03.jpg', 150.00, '2025-12-08 20:31:58', '2025-12-08 20:31:58', 100.00, 150.00),
(343, 100, 'ready', 80, 'ارز بسمتي', 'P00000343', 'ارز بسمتي', 'products/blEG0sQ70mzHSHrmvXh9Hd8cvyZCq2hjoUnFUjRq.jpg', 150.00, '2025-12-08 20:33:42', '2025-12-08 20:33:42', 100.00, 150.00),
(344, 100, 'ready', 80, 'سلطة بلدي', 'P00000344', 'سلطة بلدي', 'products/4GLvGpPeLnaGdjv0Fr2zJs8Tz9rXvIlYr9bmYrgQ.jpg', 150.00, '2025-12-08 20:34:56', '2025-12-08 20:34:56', 100.00, 150.00),
(345, 100, 'ready', 80, 'سلطة فريش', 'P00000345', 'سلطة فريش', 'products/E6150IVrgKancDashqWQSwAl43X5uuicEnftoEVD.jpg', 150.00, '2025-12-08 20:37:25', '2025-12-08 20:37:25', 100.00, 150.00),
(346, 100, 'ready', 80, 'مخلل', 'P00000346', 'مخلل', 'products/9VUyO5FgzdMoz40Gq0anG8NfAiqWZvDqVMU8PX5v.jpg', 150.00, '2025-12-08 20:38:29', '2025-12-08 20:38:29', 100.00, 150.00),
(347, 100, 'ready', 80, 'مشروم', 'P00000347', 'مشروم', 'products/d5Dm5xDjmZmhEMYJ7DGszhONUoanll9hwdZJzLvg.jpg', 150.00, '2025-12-08 20:39:45', '2025-12-08 20:39:45', 100.00, 150.00),
(348, 100, 'ready', 80, 'تيستي', 'P00000348', 'تيستي', 'products/fzH7xHYqfoymVA2yXJczedlhJ5d37n7zMDX5qvD1.webp', 150.00, '2025-12-08 20:41:14', '2025-12-08 20:41:14', 100.00, 150.00),
(349, 100, 'ready', 80, 'رانش', 'P00000349', 'رانش', 'products/6ynxPTuPstv3EJTIX3kQp1uoT9ijkzBoPRsaHsyv.webp', 150.00, '2025-12-08 20:42:44', '2025-12-08 20:42:44', 100.00, 150.00),
(350, 100, 'ready', 80, 'صوص شيدر', 'P00000350', 'صوص شيدر', 'products/vsIWlBhXcNBf1fn7s7nWzl3Y1WX3hRKlRjdqBrOl.jpg', 150.00, '2025-12-08 20:43:49', '2025-12-08 20:43:49', 100.00, 150.00),
(351, 100, 'ready', 80, 'باربكيو', 'P00000351', 'باربكيو', 'products/CUDoRAx6Rnupzb2fXnzdNy6BGaZToGzjnbJ08osQ.jpg', 150.00, '2025-12-08 20:45:14', '2025-12-08 20:45:14', 100.00, 150.00),
(352, NULL, 'ready', 80, 'ربع فرخه+1/8كفته', 'P00000352', 'ربع فرخه+1/8كفته+رز+سلطة+طحينة', 'products/e6r60P2bUwiVrrJNdg1qp6ToRw9M5uBb1NybrcOH.webp', 150.00, '2025-12-08 20:50:11', '2025-12-08 20:50:11', 100.00, 150.00),
(353, NULL, 'ready', 80, 'وجبة ربع شيش +تمن كفتة', 'P00000353', 'وجبة ربع شيش +تمن كفتة +رز+سلطه+طحينة', 'products/Q35yTZwrnkJhql6Fp49VJkvwUO9TVJOHvFosSILc.png', 150.00, '2025-12-08 20:55:59', '2025-12-08 20:55:59', 100.00, 150.00),
(354, NULL, 'ready', 80, 'وجبة ربع شيش تمن كفته تمن سجق', 'P00000354', 'ربع شيش تمن كفته تمن سجق+رز+سلطة+طحينة', 'products/CNTDel4J7HlRkyNSBGn49ww1LSdgQBmPIIniG1zr.png', 150.00, '2025-12-08 21:00:26', '2025-12-08 21:00:26', 100.00, 150.00),
(356, 105, 'ready', 71, 'ورد نانو', 'P00000356', 'ورد', 'products/aYdPGHur8JprhyDpWwQuNDBmRI0AKbU13p9dvgrk.jpg', 150.00, '2025-12-09 10:45:12', '2025-12-09 10:45:12', 100.00, 150.00),
(357, NULL, 'ready', 71, 'ورد نانو', 'P00000357', 'ورد', 'products/ll3fn0nD1nsO3PZ12IVOTZUZtiUikc2l62BiqkDI.jpg', 150.00, '2025-12-09 10:45:38', '2025-12-09 10:45:38', 100.00, 150.00),
(358, 105, 'ready', 71, 'ورد نانو', 'P00000358', 'ورد', 'products/Jq9yBHzzsCQN6fj3ze3mPg9zfrjTQg5f7EJGy2z0.jpg', 150.00, '2025-12-09 10:46:47', '2025-12-09 10:46:47', 100.00, 150.00),
(359, 105, 'ready', 71, 'ورد نانو', 'P00000359', 'ورد', 'products/GjTYbO6QoGcQEbH7y1IXCgoggS0IQzjyaKARtZpi.jpg', 150.00, '2025-12-09 10:47:07', '2025-12-09 10:47:07', 100.00, 150.00),
(360, 105, 'ready', 71, 'ورد نانو', 'P00000360', 'ورد', 'products/STcFzt2rw9GZGiWX8WFP2nILSEB7VbrWd9haDEsW.jpg', 150.00, '2025-12-09 10:47:30', '2025-12-09 10:47:30', 100.00, 150.00),
(361, 105, 'ready', 71, 'ورد نانو', 'P00000361', 'ورد', 'products/zg6Iv5Jh1d7i1VkM6Y1I3IzeVEZStdkUPfgex45d.jpg', 150.00, '2025-12-09 10:48:00', '2025-12-09 10:48:00', 100.00, 150.00),
(362, 103, 'ready', 71, 'سجاد نانو', 'P00000362', 'سجاد', 'products/F3ugiVtzl6CP0urPKv3Fk8iYR1D6FtNV79SUXNQ0.jpg', 150.00, '2025-12-09 10:48:45', '2025-12-09 10:48:45', 100.00, 150.00),
(363, 103, 'ready', 71, 'سجاد نانو', 'P00000363', 'سجاد', 'products/ddhUSvLhk88BZ9yWACFaUkVFcsfZ7SNfz8Y0ISrm.jpg', 150.00, '2025-12-09 10:49:10', '2025-12-09 10:49:10', 100.00, 150.00),
(364, 103, 'ready', 71, 'سجاد نانو', 'P00000364', 'سجاد', 'products/zzXA6CeMyIjviNlEcUGYiyMCO3UkdHf3u4aPNIn4.jpg', 150.00, '2025-12-09 10:49:32', '2025-12-09 10:49:32', 100.00, 150.00),
(365, 103, 'ready', 71, 'سجاد نانو', 'P00000365', 'سجاد', 'products/38w7M948fE0g5fyJetZkNM574Eb1k4UlGx9xJlXy.jpg', 150.00, '2025-12-09 10:50:02', '2025-12-09 10:50:02', 100.00, 150.00),
(366, 103, 'ready', 71, 'سجاد نانو', 'P00000366', 'سجاد', 'products/ibNu8AZrOocbNAhv9HTZhfBlih7XRlXsTyrI0ZGq.jpg', 150.00, '2025-12-09 10:50:26', '2025-12-09 10:50:26', 100.00, 150.00),
(367, 106, 'ready', 71, 'ذهب نانو', 'P00000367', 'ذهب', 'products/xSjsWlTyDnHy1XwrcdfguzcdiXAqa2lQJ4kIqWED.jpg', 150.00, '2025-12-09 10:50:59', '2025-12-09 10:50:59', 100.00, 150.00),
(368, 106, 'ready', 71, 'ذ', 'P00000368', 'ذهب', 'products/4XLjSF8Rz9n0Z7FTslblGyOBqkK1769sV22BLdr9.jpg', 150.00, '2025-12-09 10:51:26', '2025-12-09 10:51:26', 100.00, 150.00),
(369, 106, 'ready', 71, 'ذهب نانو', 'P00000369', 'ذهب', 'products/bN21uQdqFhNtnrYyGXuvAMqeFsGsb9e6cp4faTEJ.jpg', 150.00, '2025-12-09 10:51:53', '2025-12-09 10:51:53', 100.00, 150.00),
(370, 106, 'ready', 71, 'ذهب نانو', 'P00000370', 'ذهب', 'products/rdapLyT4uy2p11BbuxqO88JhUwZW8xKmVLzFLBJ1.jpg', 150.00, '2025-12-09 10:52:20', '2025-12-09 10:52:20', 100.00, 150.00),
(371, 106, 'ready', 71, 'ذهب نانو', 'P00000371', 'ذهب', 'products/XaNZebgEMPWKLX27NcoKnr6CWA2hdhmPz4w5UOyz.jpg', 150.00, '2025-12-09 10:52:43', '2025-12-09 10:52:43', 100.00, 150.00),
(376, 108, 'ready', 71, 'ادوات منزليه نانو', 'P00000376', 'ادوات منزليه', 'products/uN0vwvuzkkn33jkjBwS64tQABBFRmVNsOUG8WkhJ.jpg', 150.00, '2025-12-09 10:54:58', '2025-12-09 10:54:58', 100.00, 150.00),
(377, 108, 'ready', 71, 'ادوات منزليه نانو', 'P00000377', 'ادوات منزليه', 'products/5WOTMJZbpsMuvtbOYr0dHtbz0DQRst5G1T8SJ7XI.jpg', 150.00, '2025-12-09 10:55:21', '2025-12-09 10:55:21', 100.00, 150.00),
(378, 108, 'ready', 71, 'ادوات منزليه نانو', 'P00000378', 'ادوات منزليه', '1778856559.jpg', 150.00, '2025-12-09 10:55:40', '2026-05-15 11:49:19', 100.00, 150.00),
(379, 160, 'ready', 71, 'كفته', 'P00000379', 'لحوم مستوردة', '1778856206.jpg', 150.00, '2025-12-09 10:55:58', '2026-05-15 11:43:26', 100.00, 150.00),
(380, 160, 'ready', 71, 'فراخ مجمدة', 'P00000380', 'فراخ مستوردة', '1778855968.jpg', 150.00, '2025-12-09 10:56:12', '2026-05-15 11:39:28', 100.00, 150.00),
(381, 109, 'ready', 84, 'كرسبي', 'P00000381', 'كرسبي', 'products/dMXbLOhCGM7RrZNz9ErUPL8UGnKmi3g14Ykcybow.jpg', 150.00, '2025-12-09 13:29:03', '2025-12-09 13:29:03', 100.00, 150.00),
(382, 109, 'ready', 84, 'زنجر', 'P00000382', 'زنجر', 'products/1B8LzcNDYMOHETESDqDac2s6y4bKbiD7xwnMLkMA.jpg', 150.00, '2025-12-09 13:31:02', '2025-12-09 13:31:31', 100.00, 150.00),
(383, 109, 'ready', 84, 'سوبريم', 'P00000383', 'سوبريم', 'products/uWEYCRw3Fcs2kqOXc6J6vt8XZRtsGfhdhUwITYFq.jpg', 150.00, '2025-12-09 13:36:47', '2025-12-09 13:36:47', 100.00, 150.00),
(384, 109, 'ready', 84, 'فاهيتا دجاج', 'P00000384', 'فاهيتا دجاج', 'products/l9ixWwpgJs0AIYXLEgRWxefounYkJ5PxLTbFvcTw.jpg', 150.00, '2025-12-09 13:38:46', '2025-12-09 13:38:46', 100.00, 150.00),
(385, 109, 'ready', 84, 'مكسيكانو', 'P00000385', 'مكسيكانو', 'products/k5Nrph17O0l9xCJri8keU5LfgyRFCwAimDOPhTin.jpg', 150.00, '2025-12-09 13:39:53', '2025-12-09 13:39:53', 100.00, 150.00),
(386, 109, 'ready', 84, 'شيش طاووق', 'P00000386', 'شيش طاووق', 'products/cXCOB4F3ytOsuDMU7EH1BlDU2WARSdw3MVHHKJmC.jpg', 150.00, '2025-12-09 13:41:50', '2025-12-09 13:41:50', 100.00, 150.00),
(387, 109, 'ready', 84, 'ماريا كريسبي', 'P00000387', 'ماريا كريسبي', 'products/O35pe7oX8VDPeOhf8xl6MxLVwtUPq9TacyMDAXyj.jpg', 150.00, '2025-12-09 13:44:28', '2025-12-09 13:44:28', 100.00, 150.00),
(388, 109, 'ready', 84, 'بطاطس مكس جبن', 'P00000388', 'بطاطس مكس جبن', 'products/sVBgUrJoKaAZXkeK62PIo0VZFBnoyReqZqSRpXQw.jpg', 150.00, '2025-12-09 13:46:12', '2025-12-09 13:46:12', 100.00, 150.00),
(389, 109, 'ready', 84, 'بطاطس', 'P00000389', 'بطاطس', 'products/MtUDdXt7PKaUiD9rCujHMFKDKJozhDGYjYTkZqcM.jpg', 150.00, '2025-12-09 13:52:16', '2025-12-09 13:52:16', 100.00, 150.00),
(390, 109, 'ready', 84, 'بطاطس موتزريلا\\شيدر', 'P00000390', 'بطاطس موتزريلا\\شيدر', 'products/CeTAivFErYJEi9MDkD5VMg8MXrRYH3eMaGxrLvIt.jpg', 150.00, '2025-12-09 13:53:37', '2025-12-09 13:53:37', 100.00, 150.00),
(391, 109, 'ready', 84, 'بطاطس صيامي', 'P00000391', 'بطاطس صيامي', 'products/7Wg26dneJA7o0D5elHwrrq9WPkRUjBR3EWWLLu7l.jpg', 150.00, '2025-12-09 13:54:38', '2025-12-09 13:54:38', 100.00, 150.00),
(392, 110, 'ready', 84, 'وجبه كرسبي', 'P00000392', '( قطع دجاج مقرمش + أرز + بطاطس + توميه + عيش + مخلل )', 'products/nxB89ARIosthJleEGI2ayvTcMJwfRCKSBgb0gqVX.jpg', 150.00, '2025-12-09 13:56:51', '2025-12-09 13:56:51', 100.00, 150.00),
(393, 110, 'ready', 84, 'وجبه زنجر', 'P00000393', '( قطع الدجاج المقرمش الحار + ارز + بطاطس + توميه + عيش + مخلل )', 'products/lDjY93yKIDDVNq5h8YGLwXeWAbMxVvI2lqnyglqH.jpg', 150.00, '2025-12-09 14:01:20', '2025-12-09 14:01:20', 100.00, 150.00),
(394, 110, 'ready', 84, 'وجبه سوبريم', 'P00000394', '( قطع دجاج رول محشو موتزريلا + ارز + بطاطس + توميه + عيش + مخلل )', 'products/QpXD0dMCk2fjxGyWKjhXKOSnTe8wNMpjNvUUf3a4.jpg', 150.00, '2025-12-09 14:03:45', '2025-12-09 14:03:45', 100.00, 150.00),
(395, 110, 'ready', 84, 'وجبه سوبريم', 'P00000395', '( قطع دجاج رول محشو موتزريلا + ارز + بطاطس + توميه + عيش + مخلل )', 'products/EtGAdXV85OqiFsE0Uuqh0bhMPovUVX2RpBUfNf4c.jpg', 150.00, '2025-12-09 14:03:51', '2025-12-09 14:03:51', 100.00, 150.00),
(396, 110, 'ready', 84, 'وجبه فاهيتا دجاج', 'P00000396', '( قطع دجاج بصوص الفاهيتا مع الفلفل الألوان + أرز + بطاطس + توميه + عيش + مخلل )', 'products/4AcSnLiO1BFaY0jrcRnnxNhux3TlDQDIptbxTvi1.jpg', 150.00, '2025-12-09 14:07:26', '2025-12-09 14:07:26', 100.00, 150.00),
(397, 110, 'ready', 84, 'وجبه مكسيكانو', 'P00000397', '( قطع دجاج بالصوص الحار + أرز + بطاطس + توميه + عيش + مخلل )', 'products/5w81f5wWFjpV7RHVS5Y9taDzBqIZTFKbwXyCvFMl.jpg', 150.00, '2025-12-09 14:09:29', '2025-12-09 14:09:29', 100.00, 150.00),
(398, 110, 'ready', 84, 'وجبه شيش طاووق', 'P00000398', '( قطع دجاج شيش طاووق + ارز + بطاطس + اوكيه + عيش + مخلل )', 'products/e4PEDkGZNdxAVXOtYmOQ6zJnymsBwIKh0xOeVd7V.jpg', 150.00, '2025-12-09 14:12:27', '2025-12-09 14:12:27', 100.00, 150.00),
(399, 111, 'ready', 84, 'ساندوتش شاورما وسط', 'P00000399', 'ساندوتش شاورما وسط', 'products/dd81pYTblFaeMXGicXGwyeLAD9ZfiTMiRsLbHEB2.jpg', 150.00, '2025-12-09 14:17:22', '2025-12-09 14:17:22', 100.00, 150.00),
(400, 111, 'ready', 84, 'ساندوتش شاورما كبير', 'P00000400', 'ساندوتش شاورما كبير', 'products/9rTTV85Fy8A1t2J4uIXcTvdyucgkWtn8O1FW4i6v.jpg', 150.00, '2025-12-09 14:18:33', '2025-12-09 14:18:33', 100.00, 150.00),
(401, 111, 'ready', 84, 'ساندوتش شاورما صاروخ', 'P00000401', 'ساندوتش شاورما صاروخ', 'products/n1HMZllMk6TWYCe3QfKhqyC3fvKT5qYmD1KX1SS0.jpg', 150.00, '2025-12-09 14:19:58', '2025-12-09 14:19:58', 100.00, 150.00),
(402, 111, 'ready', 84, 'شاورما عربي سنجل', 'P00000402', 'شاورما عربي سنجل', 'products/FfjcQsFr93iYvP1fmQYkPo2Et6SWn1eSnFJ0QEUp.jpg', 150.00, '2025-12-09 14:21:19', '2025-12-09 14:21:19', 100.00, 150.00),
(403, 111, 'ready', 84, 'شاورما عربي دبل', 'P00000403', 'شاورما عربي دبل', 'products/tWhJEsYCL58mbc9w2onlHuQt6JLRgRYRi1v5df7w.jpg', 150.00, '2025-12-09 14:23:16', '2025-12-09 14:23:16', 100.00, 150.00),
(404, 111, 'ready', 84, 'شاورما ماريا', 'P00000404', 'شاورما ماريا', 'products/FPPOYsva1XeEFLRXknfb0CcIs0bjX9QLeqhetfRj.jpg', 150.00, '2025-12-09 14:25:06', '2025-12-09 14:25:06', 100.00, 150.00),
(405, 111, 'ready', 84, 'فته شاورما كبير', 'P00000405', 'فته شاورما كبير', 'products/OGbG3UkZR3uVxoDJMKfMsqXPpZPm30AMjSgtnlzP.jpg', 150.00, '2025-12-09 14:26:49', '2025-12-09 14:26:49', 100.00, 150.00),
(406, 112, 'ready', 84, 'دجاج شوايه كامله', 'P00000406', 'دجاج شوايه كامله', 'products/InO1ITRH0NyUjiHJBntC92uQ1gno2F7kJfszwTmt.jpg', 150.00, '2025-12-09 14:29:53', '2025-12-09 14:29:53', 100.00, 150.00),
(407, 112, 'ready', 84, 'نصف دجاجه شوايه', 'P00000407', 'نصف دجاجه شوايه', 'products/T6Y66gGDX1oedqiJIoQkqNlCn3YmQzk0C7KvPyx8.jpg', 150.00, '2025-12-09 14:30:56', '2025-12-09 14:30:56', 100.00, 150.00),
(408, 112, 'ready', 84, 'ربع دجاجه ورك شوايه', 'P00000408', 'حسب المتاح', 'products/Pgk3YVtjNu2SSKuITsFpQPWvL0hbGoZO1QJzIUAq.jpg', 150.00, '2025-12-09 14:33:26', '2025-12-09 14:33:26', 100.00, 150.00),
(409, 112, 'ready', 84, 'ربع دجاجه صدر شوايه', 'P00000409', 'حسب المتاح', 'products/TVnklrE86DymeMbzDANqQ6XSYNbT09nGtthsr0m5.jpg', 150.00, '2025-12-09 14:35:57', '2025-12-09 14:35:57', 100.00, 150.00),
(410, 112, 'ready', 84, 'دبل ورك دجاج شوايه', 'P00000410', 'يقدم معها (أرز بسمتي + بطاطس + عيش + تومية + مخــلل)', 'products/R3IJt6fIfnCIcp1FRwmz7EqQXs3gbczIVpa4j4V6.jpg', 150.00, '2025-12-09 14:38:10', '2025-12-09 14:38:10', 100.00, 150.00),
(411, 114, 'ready', 84, 'سيزر سلاط', 'P00000411', '( سلطه خضرا + قطع شيش طاووق +صوص رانش )', 'products/S5WzSUdmzulMLf7VbsNXGVpw5andlSj8J5ZJqlpi.jpg', 150.00, '2025-12-09 14:39:59', '2025-12-09 14:39:59', 100.00, 150.00),
(412, 114, 'ready', 84, 'توميه', 'P00000412', 'توميه', 'products/r0jRpi8XK758kf2u1mJpkBks8rtanm2ZTH8qZyoi.jpg', 150.00, '2025-12-09 14:42:22', '2025-12-09 14:42:22', 100.00, 150.00),
(413, 114, 'ready', 84, 'توميه سبايسي', 'P00000413', 'توميه سبايسي', 'products/Vb3YEPEvgsyYIjQxbzywwXqxCHhEC5dm7xAWuVn3.jpg', 150.00, '2025-12-09 14:43:22', '2025-12-09 14:43:22', 100.00, 150.00),
(414, 114, 'ready', 84, 'طحينه', 'P00000414', 'طحينه', 'products/s2s4aibIwGh3mraEo41S8p3wiSHWIy8D6DWzFOBr.jpg', 150.00, '2025-12-09 14:44:48', '2025-12-09 14:44:48', 100.00, 150.00),
(415, 114, 'ready', 84, 'كولسلو', 'P00000415', 'كولسلو', 'products/ZReI1irSMt7WDZMckRBoliNiNb6ZMJItrYO5wmKh.jpg', 150.00, '2025-12-09 14:45:42', '2025-12-09 14:45:42', 100.00, 150.00),
(416, 114, 'ready', 84, 'فتوش', 'P00000416', 'فتوش', 'products/EnL3tCOCu6K2upnTSUTa60arQEWFjvGYfeQ6ZODN.jpg', 150.00, '2025-12-09 14:47:44', '2025-12-09 14:47:44', 100.00, 150.00),
(417, 114, 'ready', 84, 'تبوله', 'P00000417', 'تبوله', 'products/WsAZsGULfLYz7x7EXaMDXcxkWxKTqphhlV9WFLrK.jpg', 150.00, '2025-12-09 14:49:21', '2025-12-09 14:49:21', 100.00, 150.00),
(418, 114, 'ready', 84, 'مخلل', 'P00000418', 'مخلل', 'products/E5lkUykzq1BQebWhQdXK11cHYePs4oAZnVPzpcsh.jpg', 150.00, '2025-12-09 14:50:28', '2025-12-09 14:50:28', 100.00, 150.00),
(419, 114, 'ready', 84, 'ارز بسمتي', 'P00000419', 'ارز بسمتي', 'products/eAWMsVAoD0DMua8KUqFyvKTqx01vaMkjtp5dJrLo.jpg', 150.00, '2025-12-09 14:51:45', '2025-12-09 14:51:45', 100.00, 150.00),
(420, 114, 'ready', 84, 'بطاطس', 'P00000420', 'بطاطس', 'products/qmUaN0nEa4MvULTX5b1xFmmoCqou4Es3FbBEbual.jpg', 150.00, '2025-12-09 14:52:27', '2025-12-09 14:52:27', 100.00, 150.00),
(421, 114, 'ready', 84, 'عيش', 'P00000421', 'عيش', 'products/L6gtEavR6NG4RPFsclJcnFasvydRRJOpKHmActYr.jpg', 150.00, '2025-12-09 14:53:52', '2025-12-09 14:53:52', 100.00, 150.00),
(422, 113, 'ready', 84, 'وجبه فرديه سنجل', 'P00000422', '( 2 قطعة دجاج بروستد+ خبز + تومية + بطاطس + كاتشب )', 'products/1Id8XkQgsr5adfrFogNHhTg6duakcfJwLnH70KNy.jpg', 150.00, '2025-12-09 14:57:07', '2025-12-09 14:57:07', 100.00, 150.00),
(423, 113, 'ready', 84, 'لسه single', 'P00000423', '( 3 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/OS3AiPWJbg7zEp0Bx071j16Fi5XLKO4OSBHhhCn8.jpg', 150.00, '2025-12-09 14:58:30', '2025-12-09 14:58:30', 100.00, 150.00),
(424, 113, 'ready', 84, 'Super Single', 'P00000424', '( 4 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/Fa5RwahKTxiAMSBhK4UZda0Rtjom0xlVAALzbiwZ.jpg', 150.00, '2025-12-09 15:00:13', '2025-12-09 15:00:13', 100.00, 150.00),
(425, 113, 'ready', 84, 'وجبه grill العائليه', 'P00000425', '( 6 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/brdLIB9eyaOOAvligqUMCI2Kmn640ITvoAbxAlE8.jpg', 150.00, '2025-12-09 15:02:27', '2025-12-09 15:02:27', 100.00, 150.00),
(426, 113, 'ready', 84, 'Super Grill', 'P00000426', '( 8 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب )', 'products/Hx7u6ijyEnB1EeAvED2WxT5NLdqtIUH9qv9GsJx2.jpg', 150.00, '2025-12-09 15:03:50', '2025-12-09 15:03:50', 100.00, 150.00),
(427, 113, 'ready', 84, 'Ultra Grill', 'P00000427', '( 12 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب + 1.5 بيبسى )', 'products/grruYjzCjO1FtzpvP0TMoTpw7uf2fhAnPRtReK5A.jpg', 150.00, '2025-12-09 15:06:40', '2025-12-09 15:06:40', 100.00, 150.00),
(428, 113, 'ready', 84, 'Family Grill', 'P00000428', '( 16 قطعة دجاج بروستد + خبز + تومية + بطاطس + كاتشب + 1.5 بيبسى )', 'products/htRv2vOBqehDZcbjvbFX0UtuLQ9qopx70MNvPyoP.jpg', 150.00, '2025-12-09 15:07:16', '2025-12-09 15:07:16', 100.00, 150.00),
(429, 116, 'ready', 81, 'مانسيرا روز فانيليا', 'P00000429', 'برفان وبودي سبلاش وبدي لوشن وبرفان شنطه', 'products/CdayXTnQp6E7ghRRkRusXskag3NHYY5k2NEqzP45.jpg', 150.00, '2025-12-09 16:08:31', '2025-12-09 16:08:31', 100.00, 150.00),
(430, 116, 'ready', 81, 'خمره', 'P00000430', 'برفانات وبودي سبلاش وبودي لوشن', 'products/mKds7KAm1OILSoQd5xytysn8DcQiNQfoHg1T0Mx1.jpg', 150.00, '2025-12-09 16:11:23', '2025-12-09 16:11:23', 100.00, 150.00),
(431, 116, 'ready', 81, 'موماريس', 'P00000431', 'برفانات موماريس من شركه امبر', 'products/Enoz1aVawHQg0tB4NKkW1IooINP1mwuYQXJ9CuZ4.jpg', 150.00, '2025-12-09 16:13:12', '2025-12-09 16:13:12', 100.00, 150.00),
(432, 116, 'ready', 81, 'نجده', 'P00000432', 'برفان نجده من شركه لطافه', 'products/v6wQGI1ziTaCGPJZq4mpnC7ia18dRzFLpJOkVw8a.jpg', 150.00, '2025-12-09 16:14:47', '2025-12-09 16:14:47', 100.00, 150.00),
(433, 116, 'ready', 81, 'دارك فيفر', 'P00000433', 'برفان درك فيفر من شركه لميس', 'products/BQalwr0HNa7Oio1eVSR5NTbW5kEPECoSVIUq0mpQ.jpg', 150.00, '2025-12-09 16:19:28', '2025-12-09 16:19:28', 100.00, 150.00),
(434, 116, 'ready', 81, 'شيخ الشيوخ', 'P00000434', 'شيخ الشيوخ', 'products/Njs6HcpZYOhl5OPfxAo2c3CDFgYstVAcsHTVm2gv.jpg', 150.00, '2025-12-09 16:20:43', '2025-12-09 16:20:43', 100.00, 150.00),
(435, 116, 'ready', 81, 'جود جيرل', 'P00000435', 'جود جيرل', 'products/op3WWuhKhQc87rYbGdh1fdb6k2UwTQO5MacPucyc.jpg', 150.00, '2025-12-09 16:21:58', '2025-12-09 16:21:58', 100.00, 150.00),
(436, 116, 'ready', 81, 'Blue cerulean', 'P00000436', 'Blue cerulean', 'products/BOOnVR2GDBGS8eo8r3ckDWysQcLmGPwJTbfUnhHK.jpg', 150.00, '2025-12-09 16:23:40', '2025-12-09 16:23:40', 100.00, 150.00),
(437, 116, 'ready', 81, 'عود خصوصي', 'P00000437', 'عود خصوصي من شركه الفارس', 'products/Ss2pZpVqx1znSg1dEsiJhbohbeGEXgZkRWKLpUrU.jpg', 150.00, '2025-12-09 16:25:28', '2025-12-09 16:25:28', 100.00, 150.00),
(438, 116, 'ready', 81, 'Mancera tobacco red', 'P00000438', 'Mancera tobacco red', 'products/uSQBaQGDDZfHXxgFK8sqgpy3hBr4Vsq6k6HhEWt7.jpg', 150.00, '2025-12-09 16:27:31', '2025-12-09 16:27:31', 100.00, 150.00),
(439, 116, 'ready', 81, 'أشكال زجاج برفيوم التركيب', 'P00000439', 'برفيوم مركب من اختيارك', 'products/PVA5Vy2CB0ZG8wS0L0855C4HGkXI1G8hvYNri6aa.jpg', 150.00, '2025-12-09 16:31:53', '2025-12-09 16:31:53', 100.00, 150.00),
(440, 116, 'ready', 81, 'عطور تركيب', 'P00000440', 'جميع انواع العطور للتركيب الرجالي والحريم والعربي', 'products/gAsHpMTRrc6UUrPgl99vBW5uymYLZAPGTadL0QZm.jpg', 150.00, '2025-12-09 16:34:13', '2025-12-09 16:34:13', 100.00, 150.00),
(441, 118, 'ready', 81, 'مكينه دقن وشعر كهرباء', 'P00000441', 'مكينه كهرباء', 'products/FGDykSPzB9tS25QmaUOAKYDOvOh9UYTxu3hzZJfe.jpg', 150.00, '2025-12-09 16:35:50', '2025-12-09 16:35:50', 100.00, 150.00),
(442, 118, 'ready', 81, 'مكينه اللوتس الفرعوني الأصلي', 'P00000442', 'مكينه اللوتس الفرعوني الاصلي', 'products/Yypo0qCPJKjQErMChAetWG3fedH2wCYOUuDtVP4I.jpg', 150.00, '2025-12-09 16:37:25', '2025-12-09 16:37:25', 100.00, 150.00),
(443, 118, 'ready', 81, 'مكينه دقن زيرو ديجيتال', 'P00000443', 'مكينه دقن زيرو ديجيتال', 'products/7H98hC3CTVAVl7poEzI98PfONd5NaD5LWBFyTfak.jpg', 150.00, '2025-12-09 16:38:37', '2025-12-09 16:38:37', 100.00, 150.00),
(444, 118, 'ready', 81, 'Vgr ziroo', 'P00000444', 'Very ziroo', 'products/1pxM4unVDOhL4JAY7atToUWFZJcVmDZeLCl3h3Dn.jpg', 150.00, '2025-12-09 16:40:43', '2025-12-09 16:40:43', 100.00, 150.00),
(445, 118, 'ready', 81, 'Vgr تحديد', 'P00000445', 'لتحديد الشعر والدقه', 'products/EBMZ9dFxBxAl3LSOmUH7xkQuSHFRwEdPErnMu1Pg.jpg', 150.00, '2025-12-09 16:44:07', '2025-12-09 16:44:07', 100.00, 150.00),
(446, 118, 'ready', 81, 'Vgr تنعيم', 'P00000446', 'Vgr تنعيم', 'products/btVDkoMOLUZxIawaFDsddDeQQvK1Q2hL9TWzoPRl.jpg', 150.00, '2025-12-09 16:45:18', '2025-12-09 16:45:18', 100.00, 150.00),
(447, 117, 'ready', 81, 'المحفظه الكراته', 'P00000447', 'المحفظه الكراته', 'products/ebnyWkQDimvaOOFpvCYNpBzbNUkMQEabE9IU4fum.jpg', 150.00, '2025-12-09 16:50:46', '2025-12-09 16:50:46', 100.00, 150.00),
(448, 117, 'ready', 81, 'المحفظه horse', 'P00000448', 'محفظه جلد طبيعي', 'products/DqRDNeHfFVtOxwTmb8zQtUdDWVrJsSxEHrjxj9V0.jpg', 150.00, '2025-12-09 16:52:27', '2025-12-09 16:52:27', 100.00, 150.00),
(449, 117, 'ready', 81, 'محفظه مونت بلانك', 'P00000449', 'محفظه مونت بلانك', 'products/ahujlI8bZVFZiScYA9SpapwHwzv97JSnmPO9Hu4Q.jpg', 150.00, '2025-12-09 16:53:24', '2025-12-09 16:53:24', 100.00, 150.00),
(450, 119, 'ready', 81, 'نظارات شمسيه', 'P00000450', 'نظارات شمسيه', 'products/ez2O1Trspr8qxnyhVbPC2qh7u24KkIr0OpBlaT6E.jpg', 150.00, '2025-12-09 17:16:13', '2025-12-09 17:16:13', 100.00, 150.00),
(451, 119, 'ready', 81, 'نظارات شمسيه', 'P00000451', 'نظارات شمسيه', 'products/sE2m965mrH5vDakF6bdq8aEQhxpGF9HbSN4rTjhg.jpg', 150.00, '2025-12-09 17:17:15', '2025-12-09 17:17:15', 100.00, 150.00),
(452, 119, 'ready', 81, 'نظارات شمسيه', 'P00000452', 'نظارات شمسيه', 'products/D6AoTDDTZEC9dKKH88fQN962odYMiX4tXPrrwxpg.jpg', 150.00, '2025-12-09 17:17:57', '2025-12-09 17:17:57', 100.00, 150.00),
(453, 119, 'ready', 81, 'نظارات شمسيه', 'P00000453', 'نظارات شمسيه', 'products/fb8y6w7GXbLjMWsMLhAIEd5OlhyhX6nODamU4nEE.jpg', 150.00, '2025-12-09 17:18:54', '2025-12-09 17:18:54', 100.00, 150.00),
(454, 119, 'ready', 81, 'نظارات شمسيه', 'P00000454', 'نظارات شمسيه', 'products/ObCxiyQs4xAdxZjjcnbKOJbFCcCggYA8nf7TLcFO.jpg', 150.00, '2025-12-09 17:19:44', '2025-12-09 17:19:44', 100.00, 150.00),
(455, 119, 'ready', 81, 'نظارات شمسيه', 'P00000455', 'نظارات شمسيه', 'products/MqQmlzhB385SgNDNrGqSTJMaBGGcW5x0LWDIfIni.jpg', 150.00, '2025-12-09 17:20:22', '2025-12-09 17:20:22', 100.00, 150.00),
(456, 119, 'ready', 81, 'نظارات شمسيه', 'P00000456', 'نظارات شمسيه', 'products/AGoCo7D37Fgfc7vgC1TGxcbL7oW4Z4A4XRKZYoEU.jpg', 150.00, '2025-12-09 17:21:02', '2025-12-09 17:21:02', 100.00, 150.00),
(457, 119, 'ready', 81, 'نظارات شمسيه', 'P00000457', 'نظارات شمسيه', 'products/DsMwptzBFfWdAv3MnC6luzimmifDanXzh5pbMgkm.jpg', 150.00, '2025-12-09 17:21:50', '2025-12-09 17:21:50', 100.00, 150.00),
(458, 119, 'ready', 81, 'نظارات شمسيه', 'P00000458', 'نظارات شمسيه', 'products/qzaZnLRt6D1P2uVjUQ9DbnohUYUhu69YKiCKvrUe.jpg', 150.00, '2025-12-09 17:22:26', '2025-12-09 17:22:26', 100.00, 150.00),
(459, 119, 'ready', 81, 'نظارات شمسيه', 'P00000459', 'نظارات شمسيه', 'products/NfV6BI5sWmjBrBYbOaUiZn8LPaKosaogsjsT7fMh.jpg', 150.00, '2025-12-09 17:23:07', '2025-12-09 17:23:07', 100.00, 150.00),
(460, 119, 'ready', 81, 'نظارات شمسيه', 'P00000460', 'نظارات شمسيه', 'products/kSBtqnUYwX1sA1854JiaKJKvwyIuDu9ZDFMstdhs.jpg', 150.00, '2025-12-09 17:23:47', '2025-12-09 17:23:47', 100.00, 150.00),
(461, 119, 'ready', 81, 'نظارات شمسيه', 'P00000461', 'نظارات شمسيه', 'products/5UFakQVZHGCy0jFbeJSIVZVzz2X4fztYLK8ykLp6.jpg', 150.00, '2025-12-09 17:24:35', '2025-12-09 17:24:35', 100.00, 150.00),
(462, 119, 'ready', 81, 'نظارات شمسيه', 'P00000462', 'نظارات شمسيه', 'products/XfeNigcdb9wGhZeviWU5RTViHOL9i1Nrps2vJrpX.jpg', 150.00, '2025-12-09 17:25:08', '2025-12-09 17:25:08', 100.00, 150.00),
(463, 119, 'ready', 81, 'نظارات شمسيه', 'P00000463', 'نظارات شمسيه', 'products/Y0GvOwZuNtZxM6c8KuOFcjR9Qidg2mGdBn3Lj3mc.jpg', 150.00, '2025-12-09 17:25:58', '2025-12-09 17:25:58', 100.00, 150.00),
(464, 115, 'ready', 81, 'ساعه', 'P00000464', 'ماركه ibso', 'products/JoUL58yvi28OJuGbFppboaEJJCCUL6sGFdZA6Cp1.jpg', 150.00, '2025-12-10 15:37:48', '2025-12-10 15:37:48', 100.00, 150.00),
(465, 115, 'ready', 81, 'ساعه', 'P00000465', 'ماركت ibso', 'products/Bx44HfWt1BqngiVlWoPqjCNp0qCk42guSUVhf5Rx.jpg', 150.00, '2025-12-10 15:38:42', '2025-12-10 15:38:42', 100.00, 150.00),
(466, 115, 'ready', 81, 'ساعه رجالي', 'P00000466', 'ماركت ibso', 'products/DVZiwRi5icWGg1Bohrh2aDkG3WbvpbSiAjYMolIp.jpg', 150.00, '2025-12-10 15:39:48', '2025-12-10 15:39:48', 100.00, 150.00),
(467, 115, 'ready', 81, 'ساعه حريمي', 'P00000467', 'ماركت ibso', 'products/9imDuAMuJyBXFbNSibf17cKaW7NgENL2F9yUjYXx.jpg', 150.00, '2025-12-10 15:42:20', '2025-12-10 15:42:20', 100.00, 150.00),
(468, 115, 'ready', 81, 'ساعه حريمي', 'P00000468', 'ماركت ibso', 'products/XkfCyTYObaxuApNhgqrZ1UI19tHWKRS7vPriSU2d.jpg', 150.00, '2025-12-10 15:43:26', '2025-12-10 15:43:26', 100.00, 150.00),
(469, 115, 'ready', 81, 'ساعه حريمي', 'P00000469', 'ماركت ibso', 'products/4aNY28y862I3O4bWCOX3XPbMoDyAHqSnjnvd80QE.jpg', 150.00, '2025-12-10 15:44:30', '2025-12-10 15:44:30', 100.00, 150.00),
(470, 115, 'ready', 81, 'ساعه حريمي', 'P00000470', 'ماركت ibso', 'products/MkXO9bw3znU9utjYoxSjH0YleufXIj3wgOMnyTvP.jpg', 150.00, '2025-12-10 15:45:29', '2025-12-10 15:45:29', 100.00, 150.00),
(471, 115, 'ready', 81, 'ساعه حريمي', 'P00000471', 'ماركت zara', 'products/htFGygwJURJ47HqXKnm5FX6XYUf64lA9nrsoYuAD.jpg', 150.00, '2025-12-10 15:46:45', '2025-12-10 15:46:45', 100.00, 150.00),
(472, 115, 'ready', 81, 'ساعه حريمي', 'P00000472', 'ماركت seifco', 'products/S2liuKx8dSuh4m0Gnn4pInSfaai7yyFXWr01vROU.jpg', 150.00, '2025-12-10 15:47:37', '2025-12-10 15:47:37', 100.00, 150.00),
(473, 115, 'ready', 81, 'ساعه حريمي', 'P00000473', 'ماركت zara', 'products/CZ0f3VuZZRnL3PjgQSxO1rjlatmt8XTiW3H8YZV4.jpg', 150.00, '2025-12-10 15:48:42', '2025-12-10 15:48:42', 100.00, 150.00),
(474, 115, 'ready', 81, 'ساعه حريمي', 'P00000474', 'ماركت Rolex', 'products/n2WVUBDPHwNRtMHyRhZ3Y0iQFWlBiepbP8zTXDQA.jpg', 150.00, '2025-12-10 15:49:33', '2025-12-10 15:49:33', 100.00, 150.00),
(475, 115, 'ready', 81, 'ساعه حريمي', 'P00000475', 'ماركت ORIENT', 'products/uQPQpLuwse0SlBNF8NkPtYxm09WILbXMmUqrXWfD.jpg', 150.00, '2025-12-10 15:50:27', '2025-12-10 15:50:27', 100.00, 150.00),
(476, 115, 'ready', 81, 'ساعه حريمي', 'P00000476', 'ماركت BVLGARI', 'products/TZ6DogkSh6CpGswJAwHDIrgecZXe1fzMDpKeWBaM.jpg', 150.00, '2025-12-10 15:58:49', '2025-12-10 15:58:49', 100.00, 150.00),
(477, 115, 'ready', 81, 'ساعه رجالي', 'P00000477', 'ماركت CASIO', 'products/gtPGoyEhIDijnT8m1ru3KVVsgvrJFuiWyBL1TNXC.jpg', 150.00, '2025-12-10 16:00:46', '2025-12-10 16:00:46', 100.00, 150.00),
(478, 115, 'ready', 81, 'ساعه رجالي', 'P00000478', 'ماركت CASIO', 'products/3xRAd2IYLuZ7biPPg3YMG6pJO15A3cpChyjgWi1j.jpg', 150.00, '2025-12-10 16:02:51', '2025-12-10 16:02:51', 100.00, 150.00),
(479, 115, 'ready', 81, 'ساعه رجالي', 'P00000479', 'ماركت CASIO', 'products/dDdxwpGxnIho3f2Fz3nsaeXwChvEwm7zFkp5fFig.jpg', 150.00, '2025-12-10 16:04:06', '2025-12-10 16:04:06', 100.00, 150.00),
(480, 115, 'ready', 81, 'ساعه رجالي', 'P00000480', 'ماركت CASIO', 'products/QEZRJmH1UAuzkDAZX6ZIlkJ50RH3eqnTwjJzT7Bt.jpg', 150.00, '2025-12-10 16:05:15', '2025-12-10 16:05:15', 100.00, 150.00),
(481, 115, 'ready', 81, 'ساعه رجالي', 'P00000481', 'ماركت CASIO', 'products/8vfFHQDfoL06t2Dy4ACSbWj6V1XutwvzlycbOXUc.jpg', 150.00, '2025-12-10 16:05:54', '2025-12-10 16:05:54', 100.00, 150.00),
(482, 115, 'ready', 81, 'ساعه رجالي', 'P00000482', 'ماركت SKMEI', 'products/IhJfr85Vr3t7kAWVd9LZpGeWReWKgfpb4vH7hgtu.jpg', 150.00, '2025-12-10 16:06:45', '2025-12-10 16:06:45', 100.00, 150.00),
(483, 115, 'ready', 81, 'ساعه رجالي', 'P00000483', 'ماركت MF', 'products/LZtihcxi5mfvaIL0nEdvMlq3u08xJMZFWCsEMxvE.jpg', 150.00, '2025-12-10 16:07:44', '2025-12-10 16:07:44', 100.00, 150.00),
(484, 115, 'ready', 81, 'ساعه رجالي', 'P00000484', 'ماركت MF', 'products/rklgupmxPHfJCHWSDoAt91zFFnJyM6kjUZUxk6Tq.jpg', 150.00, '2025-12-10 16:08:39', '2025-12-10 16:08:39', 100.00, 150.00),
(485, 115, 'ready', 81, 'ساعه رجالي', 'P00000485', 'ماركت MF', 'products/ZsOaBpLp58QClE2n4lhZnInheVx3dRfG0EFuL3ZR.jpg', 150.00, '2025-12-10 16:09:33', '2025-12-10 16:09:33', 100.00, 150.00),
(486, 115, 'ready', 81, 'ساعه رجالي', 'P00000486', 'ماركت MF', 'products/hHXSasTB4fbPhvDXhUHhqA1M8eTaaAgjZOsrX5oD.jpg', 150.00, '2025-12-10 16:10:47', '2025-12-10 16:10:47', 100.00, 150.00),
(487, 115, 'ready', 81, 'ساعه رجالي', 'P00000487', 'ماركت zara', 'products/wKDSYsTRtfvHKvIyCViFx6ev40pjymRIcd0eM5Oc.jpg', 150.00, '2025-12-10 16:11:50', '2025-12-10 16:11:50', 100.00, 150.00),
(488, 121, 'ready', 79, 'مناديل مارتي', 'P00000488', 'العلبه 500 منديل', 'products/q6sMhpGKg25cu0yoewCXy4iJkMTtfTcijhNtss3r.png', 150.00, '2025-12-11 18:11:49', '2025-12-15 16:06:39', 100.00, 150.00),
(489, 121, 'ready', 79, 'مناديل جانيس', 'P00000489', 'العلبه 500 منديل', 'products/VQzY7FMv7QoWUYLRquo8XKD8whPjxOlCR40oWvUW.png', 150.00, '2025-12-12 13:26:17', '2025-12-15 16:08:44', 100.00, 150.00),
(490, 120, 'ready', 79, 'سي فولد', 'P00000490', 'بالته 20 علبه بالكيلو', 'products/wMAOZoZIsim7YOgPFj8qpdqQDamzd12u8yKsCk2t.png', 150.00, '2025-12-12 13:30:02', '2025-12-15 16:14:55', 100.00, 150.00),
(491, 121, 'ready', 79, 'مناديل سفره فاخره', 'P00000491', '40 علبه , العلبه 50 منديل', 'products/rAU2tUAAmGYow0REozoq9p7yZ9abjzg0DZFrwvPH.png', 150.00, '2025-12-12 13:34:10', '2025-12-15 16:17:36', 100.00, 150.00),
(492, 121, 'ready', 79, 'مناديل سحب بالكيلو فاخره', 'P00000492', 'بالته 20 علبه , العلبه 250 جرام', 'products/kFw2U92GlYZzjqQeOBBNJkRDth2kYi21PSqQvrzP.png', 150.00, '2025-12-12 13:52:33', '2025-12-15 16:16:58', 100.00, 150.00),
(493, 120, 'ready', 79, 'مناديل كتان', 'P00000493', '550 منديل', 'products/4eTNWGQD4irX8qTYeXblY9be7VyvSh7P6zzIb6S5.jpg', 150.00, '2025-12-12 18:45:03', '2025-12-15 16:19:59', 100.00, 150.00),
(494, 122, 'ready', 79, 'سيتي فيرجيان', 'P00000494', 'العلبه ٢٠٠ منديل , مناديل منقوشه', 'products/X4K5RJqdW9HJC0KMXbPmfudPVXnH7iSP180zBY2r.jpg', 150.00, '2025-12-12 18:47:15', '2025-12-15 16:20:33', 100.00, 150.00),
(495, 120, 'ready', 79, 'مناديل برافو بيور', 'P00000495', '500 منديل ، مناديل ناعمه', 'products/rNxVxu0q54xkQX8zUeRi6zRYJrHEoMPATlsq2H3G.png', 150.00, '2025-12-12 18:50:52', '2025-12-15 16:21:45', 100.00, 150.00),
(496, 123, 'ready', 86, 'بوكس 6 قطع', 'P00000496', '6 قطع دجاج+بطاطس+5خبز+كاتشب+٢ تومية', 'products/TEJRFl6UFW93BrxjXN4OOzMkhtSbK1HACywzH2GI.jpg', 150.00, '2025-12-13 16:55:50', '2025-12-15 18:53:14', 100.00, 150.00),
(497, 123, 'ready', 86, 'فاميلي بوكس', 'P00000497', '9 قطع دجاج+بطاطس+6خبز+كاتشب+٢ تومية', 'products/tz4Lug77BmFzT6zm767u4FbqVOwPaWPWQ9kIB0up.jpg', 150.00, '2025-12-13 17:09:04', '2025-12-15 18:53:38', 100.00, 150.00),
(498, 123, 'ready', 86, 'سوبر فاميلي', 'P00000498', '12 قطع دجاج+بطاطس+8خبز+2 كلو سلو+٢ تومية +لتر بيج كولا', 'products/JU4s4doMGHU17QaMJ8QxTbB3XwQhBK18ks89syVB.jpg', 150.00, '2025-12-13 17:13:19', '2025-12-15 18:54:15', 100.00, 150.00),
(499, 123, 'ready', 86, 'جراند تشك ان', 'P00000499', '18 قطع دجاج+بطاطس+خبز+كاتشب+3 تومية+لتر بيج كولا', 'products/lnjJyHqeyvsjApq19mXJX0n7hHIyyEbt2R1ucmuG.jpg', 150.00, '2025-12-13 17:20:51', '2025-12-15 18:54:42', 100.00, 150.00),
(500, 123, 'ready', 86, 'فاميلي ستربس', 'P00000500', '10 قطع ستريبس+بطاطس كبيرة+6خبز+2 كلو سلو+ تومية +وريزو سادة', 'products/iGpWFvBtYJaHnaCeoJRbPo0UnHsDODGvItLiIyI6.jpg', 150.00, '2025-12-13 17:24:51', '2025-12-15 18:56:58', 100.00, 150.00),
(501, 123, 'ready', 86, 'سوبر فاميلي ستربس', 'P00000501', '15 قطع ستريبس+بطاطس كبيرة+خبز+ كلو سلو +وريزو سادة', 'products/xjnyYHb5jYhpRSGxEz3ZIv30iDVOpDENMA5PxlmB.jpg', 150.00, '2025-12-13 17:27:54', '2025-12-15 19:18:29', 100.00, 150.00),
(502, 123, 'ready', 86, 'كيس حراري ستربس', 'P00000502', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/FOWtqtfZwT0SEFnUXdoMr3h9uJyzIfaB1viEYKTu.jpg', 150.00, '2025-12-13 17:35:56', '2025-12-13 17:35:56', 100.00, 150.00);
INSERT INTO `products` (`id`, `category_id`, `type`, `user_id`, `name`, `barcode`, `description`, `cover`, `price`, `created_at`, `updated_at`, `Purchase_price`, `selling_price`) VALUES
(503, 123, 'ready', 86, 'كيس حراري وينجز', 'P00000503', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/qSWESrhZISA4EZvfq2070eIxMGbOwf2mT0uohKgI.jpg', 150.00, '2025-12-13 17:41:30', '2025-12-15 19:04:58', 100.00, 150.00),
(504, 123, 'ready', 86, 'كيس حراري شرمبو', 'P00000504', 'تقدم مع الارز المبهر +قطع الاستربس +الذره الحلو+الفلفل اللوات مع صوص يقدم في الكيس الحراري مع البطاطس', 'products/eC4sJ52bDXRyT6ulcjfGoOF5cAm5Zy0oaPok9g8v.jpg', 150.00, '2025-12-13 17:46:47', '2025-12-15 19:05:34', 100.00, 150.00),
(505, 123, 'ready', 86, 'كب تشك ان', 'P00000505', 'طبق بطاطس مع فراخ مع مزيج من صوصات جراند تشك ان', 'products/x2yhLTHtYjnegSXdVkl0gcgDgG3oDjqYdvJsrHa2.jpg', 150.00, '2025-12-13 18:00:40', '2025-12-15 19:06:23', 100.00, 150.00),
(506, 123, 'ready', 86, 'كشريكو', 'P00000506', 'طبق بطاطس مع فراخ مخلوط  مع مزيج من اللحوم المدخنة  مع صوصات جراند تشك ان', 'products/66vGvxBzn9qljCFBql2jkTooGvK3PGvc9HW9dgHQ.jpg', 150.00, '2025-12-13 18:02:41', '2025-12-15 19:07:12', 100.00, 150.00),
(507, 124, 'ready', 86, 'snack box', 'P00000507', 'قطعتين دجاج+بطاطس+عيش+ثومية', 'products/b7MGftjigLRjSQVxKuHX4dbiAZZyfdWGEoE6dYLt.jpg', 150.00, '2025-12-13 18:06:33', '2025-12-15 19:23:59', 100.00, 150.00),
(508, 124, 'ready', 86, 'dinner box', 'P00000508', '3قطع دجاج +بطاطس +2عيش+ثومية', 'products/zygcSG4IOG88JP4orZtLvhMTSqdnfSKn7LOX9SbD.jpg', 150.00, '2025-12-13 18:09:19', '2025-12-15 19:20:51', 100.00, 150.00),
(509, 124, 'ready', 86, 'large box', 'P00000509', '٤قطع دجاج +بطاطس +٣عيش+ثومية', 'products/kPy44735HjUiZ8xRLlvuJ2RHTnXE70kNvEeDsAkE.jpg', 150.00, '2025-12-13 18:13:27', '2025-12-15 19:19:09', 100.00, 150.00),
(510, 124, 'ready', 86, 'strips box', 'P00000510', '3قطع ستربس +بطاطس +عيش+ثومية', 'products/GdKDqL1paKRkNqiFFCCT65VyQcgv2JcfqQqDCLva.jpg', 150.00, '2025-12-13 18:16:16', '2025-12-15 19:26:29', 100.00, 150.00),
(511, 124, 'ready', 86, 'Dinner Strips box', 'P00000511', '٤ قطع ستربس +بطاطس+ عيش+ ثومية', 'products/8arJVO0zvpnf162RT0mF4tHOsdAqUpRZ1nOw7afs.jpg', 150.00, '2025-12-13 18:19:46', '2025-12-15 19:26:55', 100.00, 150.00),
(512, 124, 'ready', 86, 'jumbo strips box', 'P00000512', '5قطع ستربس +بطااطس+2عيش +ثومية', 'products/sXaihq8L86FpQ5qg7R9w6lWWokDEDhwkzbnRSJyE.jpg', 150.00, '2025-12-13 18:22:09', '2025-12-15 19:27:17', 100.00, 150.00),
(513, 126, 'ready', 86, 'تويستر رول كلاكسيك', 'P00000513', 'قطع استربس + خس +مايونيز+باربكيو', 'products/dNzObp7fHm7386Rsm6MKEMjoIivcX3nBstDQ8IeD.jpg', 150.00, '2025-12-13 18:24:27', '2025-12-15 19:30:06', 100.00, 150.00),
(514, 126, 'ready', 86, 'تويستر رول فاير', 'P00000514', 'قطع استربس + خس+ صوص فاير +تاجير', 'products/dNl8tExE06gK943nbLzQLOtgUFndDguNS4u0tFNH.jpg', 150.00, '2025-12-13 18:27:49', '2025-12-14 20:32:17', 100.00, 150.00),
(515, 126, 'ready', 86, 'سوبر يم', 'P00000515', 'زنجر+تركي مدخن بيف صوص رانش+شيدر', 'products/CGB6cJ2i5L8IHrdUR7nNA3G84O2n1itQrvrMVRhl.jpg', 150.00, '2025-12-13 18:30:48', '2025-12-15 19:30:44', 100.00, 150.00),
(516, 126, 'ready', 86, 'زنجر هالبينو', 'P00000516', 'زنجر +فلفل هالبينو +صوص فاير+شيدر', 'products/57L4rr5GZZQdyoaTVdQfw26ZFS7sGsgJHlfTFRJR.jpg', 150.00, '2025-12-13 18:33:32', '2025-12-15 19:32:22', 100.00, 150.00),
(517, 126, 'ready', 86, 'تشيكن موتزريلا ستيك', 'P00000517', 'قطع دجاج مقلي +اصابع الجبنه الموتزريلا+خس+مايونيز+خيار مخلل', 'products/vm9jqSXVIsLGM6u4cgKkev2LKBGpnX5DKQBl8wYB.jpg', 150.00, '2025-12-13 18:38:07', '2025-12-15 19:33:04', 100.00, 150.00),
(518, 126, 'ready', 86, 'تشك ان فاير', 'P00000518', 'دجاج مقلي تركي شريحة شيدر صوص شيدر+صوص باربكيو مايونيز+صوص شيلي هالبينو', 'products/R7T9hAh3ovqM1TdxfayP6lYVQB4wODGVCNKwVah2.jpg', 150.00, '2025-12-13 18:41:36', '2025-12-15 19:35:09', 100.00, 150.00),
(519, 126, 'ready', 86, 'تشك ان كلاسيك', 'P00000519', 'صدور الدجاج المقلي +تركي بيف+جبنة شيدر +خس طماطم + خيار مخلل +صوص شيدر وباربيكيو ومايونيز', 'products/oNIQUEx3Pr3mnetBDSQBr0K3xUnKk3biL0uTYVCx.png', 150.00, '2025-12-13 18:45:01', '2025-12-13 18:57:06', 100.00, 150.00),
(520, 126, 'ready', 86, 'تشيكن تشيز لافر', 'P00000520', 'صدور الدجاج المقلي +صوص رانش+تركي صوص تشك ان المميز', 'products/LruiR1fPsou8sJYcNxQrTz9kebfqJGroVc1vbsEl.png', 150.00, '2025-12-13 18:48:57', '2025-12-13 18:56:43', 100.00, 150.00),
(521, 126, 'ready', 86, 'تشيكن رانشيو', 'P00000521', 'صدور الدجاج المقلي +صوص رانش+تركي صوص تشك ان المميز', 'products/USQdSuMSqIKp2cTC5DFujXbzvenPpMROkKJrlikA.png', 150.00, '2025-12-13 18:52:02', '2025-12-13 18:56:17', 100.00, 150.00),
(522, 126, 'ready', 86, 'تشيكن بيكون', 'P00000522', 'صدور الدجاج المقلي+ شريحة جبنه + حلقات البصل+صوص الباربكيو+صوص شيدر+بيف بيكون', 'products/lPKercLKRQdId1ZCmo7DKBcn7d1P9WcctBTUO2eE.png', 150.00, '2025-12-13 18:54:33', '2025-12-13 18:55:58', 100.00, 150.00),
(523, 127, 'ready', 86, 'كلاسيك برجر', 'P00000523', 'تسيتي+ خس+ بصل+ خيار خلل +طماطم شريحه جبنه+ باربيكيو', 'products/MKdKPV5PQVSoePyZzegcRuw0VIdIvYLMFhjqOqtl.jpg', 150.00, '2025-12-13 19:02:45', '2025-12-15 19:37:10', 100.00, 150.00),
(524, 127, 'ready', 86, 'مشروم برجر', 'P00000524', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ باربيكيو', 'products/moXzEWUo3G5gD8eBkr7tOmZhxjAGGRKafsPVG00t.jpg', 150.00, '2025-12-13 19:04:11', '2025-12-15 19:39:25', 100.00, 150.00),
(525, 127, 'ready', 86, 'تشيز لافر برجر', 'P00000525', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/B3hpwHF87rLlGyBYm43l4FRcb2ObJlfmRz55dhhk.jpg', 150.00, '2025-12-13 19:06:45', '2025-12-15 19:42:04', 100.00, 150.00),
(526, 127, 'ready', 86, 'برجر موتزريلا ستيك', 'P00000526', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/pKi3MTVBkLhlIMlNHiiFzKzUJDzxkNXFhnwGkp5t.jpg', 150.00, '2025-12-13 19:10:03', '2025-12-15 19:43:15', 100.00, 150.00),
(527, 127, 'ready', 86, 'برجر بيكون', 'P00000527', 'تسيتي+ خس+ بصل+ خيار مخلل +طماطم شريحه جبنه+ غرقان صوص جبنه شيدر', 'products/F121AV4ClIhEUbWY2IaWWwALsmhtvgRy0Wugy1M9.jpg', 150.00, '2025-12-13 19:16:46', '2025-12-15 19:47:23', 100.00, 150.00),
(528, 127, 'ready', 86, 'برجر بيف ان', 'P00000528', 'تسيتي+ خس+ بصل+ خيار مخلل +باربيكيو+مع شرايح اللحمه البلدي', 'products/c4v4CYDSeczTCla58WukZENL8SsYRV6sFfQ5jBXl.jpg', 150.00, '2025-12-13 19:19:25', '2025-12-15 19:48:17', 100.00, 150.00),
(529, 127, 'ready', 86, 'سموك هاوس برجر', 'P00000529', 'تسيتي+ خس+ بصل انيون + خيار مخلل +طماطم شريحه جبنه+باربيكيو+تركي مدخن+صوص جبنه', 'products/7eHtXDZSEMcoHPigHxTa88UAWAlqwY64AmYaOrn7.jpg', 150.00, '2025-12-13 19:21:59', '2025-12-15 19:49:43', 100.00, 150.00),
(530, 127, 'ready', 86, 'اكس ان برجر', 'P00000530', 'تسيتي+ خس+ بصل+ خيار  +طماطم شريحه جبنه+ باربيكيو+بيف بيكون تركي+موتزرلا استيك+صوص تاجر+صوص جبنة', 'products/RTjITbA3sFWw2karewVf9JF8mAXND8q2eQnC0NxP.jpg', 150.00, '2025-12-13 19:29:12', '2025-12-15 19:53:50', 100.00, 150.00),
(531, 125, 'ready', 86, 'سندوتش بيف', 'P00000531', 'سندوتش بيف + بطاطس+ كلوسلو+عصير', 'products/ovAZxXfiMdbK7Nsikl4zblL2lkIvkrMyCyB9IUbK.png', 150.00, '2025-12-13 19:32:11', '2025-12-13 19:32:11', 100.00, 150.00),
(532, 125, 'ready', 86, 'سندوتش تشكين', 'P00000532', 'سندوتش تشكين + بطاطس+ كلوسلو+عصير', 'products/Yhc92KBqQPogwUE7OM33ZyJpr9GlgRhAHnw4Bx4J.png', 150.00, '2025-12-13 19:33:45', '2025-12-13 19:33:45', 100.00, 150.00),
(533, 125, 'ready', 86, 'قطعة دجاج', 'P00000533', 'قطعة دجاج + بطاطس+ كلوسلو+عصير', 'products/qUmEhhLRlzIsUcxfkVyVhv0WyTGVKAykft9BeUtJ.png', 150.00, '2025-12-13 19:35:43', '2025-12-13 19:35:43', 100.00, 150.00),
(534, 128, 'ready', 86, 'بطاطس', 'P00000534', 'بطاطس', 'products/CQc3yxHXCRq4DtSAEpCgamPqcP2D2027LBX9xCSN.png', 150.00, '2025-12-13 19:38:02', '2025-12-13 19:38:02', 100.00, 150.00),
(535, 128, 'ready', 86, 'بطاطس شيدر', 'P00000535', 'بطاطس شيدر', 'products/4YIYwh3dFZgkgaKGLKYr2iIWyMeXpDeFNu2sN9VK.png', 150.00, '2025-12-13 19:39:51', '2025-12-13 19:39:51', 100.00, 150.00),
(536, 128, 'ready', 86, 'بطاطس سوبريم', 'P00000536', 'بطاطس سوبريم', 'products/Y6Hsdi2RjAxiwkE9Zkwt7JRjzIDiTjAL9zpx5Zgf.png', 150.00, '2025-12-13 19:41:43', '2025-12-13 19:41:43', 100.00, 150.00),
(537, 128, 'ready', 86, 'بطاطس تشيكن سوبريم', 'P00000537', 'بطاطس تشيكن سوبريم', 'products/t87dKqx3TB12p6cXhMjsY4HbAoi6TmHXSa5PnMvL.jpg', 150.00, '2025-12-13 19:45:45', '2025-12-13 19:45:45', 100.00, 150.00),
(538, 128, 'ready', 86, 'بطاطس هالبينو', 'P00000538', 'بطاطس هالبينو', 'products/cNFqH0AqvPWKnFO26V6oiXqMQ7LuyDkhcDluaBKt.jpg', 150.00, '2025-12-13 19:47:13', '2025-12-13 19:47:13', 100.00, 150.00),
(539, 128, 'ready', 86, 'موتزريلا ستيك', 'P00000539', 'موتزريلا ستيك', 'products/XtwppiYYqRfvOJ8FevddXhZkwrNKUI0D5bHrPbkq.jpg', 150.00, '2025-12-13 19:49:31', '2025-12-13 19:49:31', 100.00, 150.00),
(540, 128, 'ready', 86, 'حلقات بصل', 'P00000540', 'حلقات بصل', 'products/i8ovt5561uEECxO0jkaA04RQbv16RnylOktJl9po.jpg', 150.00, '2025-12-13 19:51:05', '2025-12-13 19:51:05', 100.00, 150.00),
(541, 128, 'ready', 86, 'كلوسلو', 'P00000541', 'كلوسلو', 'products/c3fXlnst4d4mPTHPR3tAssRiFznp31VEgWfhy9S6.jpg', 150.00, '2025-12-13 19:52:07', '2025-12-13 19:52:07', 100.00, 150.00),
(542, 128, 'ready', 86, 'ثومية', 'P00000542', 'ثومية', 'products/xBBYDkCWI8QE8dvZxEFnZPhDBALatARX9hZzOAv2.jpg', 150.00, '2025-12-13 19:53:04', '2025-12-13 19:53:04', 100.00, 150.00),
(543, 128, 'ready', 86, 'ارز سادة', 'P00000543', 'ارز سادة', 'products/ba1IT1BvVw6dDdacRIqMq5kY8M3mHayAT20JCOwW.jpg', 150.00, '2025-12-13 19:54:25', '2025-12-13 19:54:25', 100.00, 150.00),
(544, 128, 'ready', 86, 'ريزو تشيكن كلاسيك', 'P00000544', 'ريزو تشيكن كلاسيك', 'products/IZKXhDKpW6j5PZgp94C0NMbvUXhtSvcyi62Dm11w.jpg', 150.00, '2025-12-13 19:56:20', '2025-12-13 19:56:20', 100.00, 150.00),
(545, 128, 'ready', 86, 'ريزو تشيكن حار', 'P00000545', 'ريزو تشيكن حار', 'products/TwLuN2BVCeuKNe79oqA9r9J81mjo1se0fZGKfc1D.jpg', 150.00, '2025-12-13 19:58:19', '2025-12-13 19:58:19', 100.00, 150.00),
(546, 128, 'ready', 86, 'ريزو تشيكن تشيز', 'P00000546', 'ريزو تشيكن تشيز', 'products/bcMklT74eGIBOTJo2o3wAICHH7cEZMkq48Z60vdw.jpg', 150.00, '2025-12-13 20:00:25', '2025-12-13 20:00:25', 100.00, 150.00),
(547, 128, 'ready', 86, 'ريزو تشيكن رانش', 'P00000547', 'ريزو تشيكن رانش', 'products/9Jk4wLPkWiVEptWsI3bAG1IhC3HvfnEeiuFLMoTO.jpg', 150.00, '2025-12-13 20:02:31', '2025-12-13 20:02:31', 100.00, 150.00),
(548, 128, 'ready', 86, 'ريزو شرمبو', 'P00000548', 'ريزو شرمبو', 'products/uAyb3Vq9ZXMLkogPxphJCKlhe2vYQhSpKGVtOzgZ.jpg', 150.00, '2025-12-13 20:04:17', '2025-12-13 20:04:17', 100.00, 150.00),
(549, 128, 'ready', 86, 'صوص تايجر-رانش', 'P00000549', 'صوص تايجر-رانش', 'products/GTR01uj7WwaNL7LBXOrItXJEEC58a9Inn8ULH0zd.png', 150.00, '2025-12-13 20:06:36', '2025-12-13 20:06:36', 100.00, 150.00),
(550, 128, 'ready', 86, 'صوص سويت شيلي', 'P00000550', 'صوص سويت شيلي', 'products/DcFdklewDPFNfnXxujGEJhqbsQMIeWbXZvFhCCTa.jpg', 150.00, '2025-12-13 20:07:58', '2025-12-13 20:07:58', 100.00, 150.00),
(551, 128, 'ready', 86, 'صوص بيج تيستي -صوص جبنة', 'P00000551', 'صوص بيج تيستي -صوص جبنة', 'products/V3hAGkm2zzAKVEzn14vAVmrXijzOpHx5xBW5ZrYd.jpg', 150.00, '2025-12-13 20:09:24', '2025-12-13 20:09:24', 100.00, 150.00),
(552, 130, 'ready', 86, 'مياه معدنيه صغيره', 'P00000552', 'مياه معدنيه صغيره', 'products/4rSKSXEo96grbwy7e28wqicgJB3QHoiC47MpFHOv.jpg', 150.00, '2025-12-13 20:12:35', '2025-12-13 20:12:35', 100.00, 150.00),
(553, 130, 'ready', 86, 'مياه معدنيه كبيره', 'P00000553', 'مياه معدنيه كبيره', 'products/IcTZVlBa6aoiBBhO3daG6N4dqD1cv9dmV4B0JLaI.jpg', 150.00, '2025-12-13 20:13:44', '2025-12-13 20:13:44', 100.00, 150.00),
(554, 130, 'ready', 86, 'Big cola', 'P00000554', 'Big cola', 'products/CW0Z2zsLSPlEw6gdSBuLxahSqReSXFUEhWdwI8Ln.jpg', 150.00, '2025-12-13 20:15:26', '2025-12-13 20:15:26', 100.00, 150.00),
(555, 129, 'ready', 86, 'تبديل قطعه', 'P00000555', 'تبديل قطعه', 'products/G2QzI929b73Quwv1LDw3dJFxGNasO6O6mDsrbJrN.png', 150.00, '2025-12-13 20:17:56', '2025-12-13 20:17:56', 100.00, 150.00),
(556, 129, 'ready', 86, 'اضافه قطعة', 'P00000556', 'اضافه قطعة', 'products/qLUjU0Ja3rIa8YAxCeZLLTxHQmqnwPsdd5kUjOdz.png', 150.00, '2025-12-13 20:19:25', '2025-12-13 20:19:25', 100.00, 150.00),
(557, 129, 'ready', 86, 'تبديل جناح دبوس', 'P00000557', 'تبديل جناح دبوس', 'products/9WgMedRygnwJuNC54KxcUGIXtMmt1NQJBFbYmhEr.png', 150.00, '2025-12-13 20:20:28', '2025-12-13 20:20:28', 100.00, 150.00),
(558, 129, 'ready', 86, 'قطعه ستريبس', 'P00000558', 'قطعه ستريبس', 'products/bwkHFcomuhVC7AunHU1MYfm6jSfz2L72i5FeuLtT.png', 150.00, '2025-12-13 20:21:35', '2025-12-13 20:21:35', 100.00, 150.00),
(559, 129, 'ready', 86, 'عيش', 'P00000559', 'عيش', 'products/YnT9R5tY9Z2i4m3fB6ucUeQarEkhVkmKd7URKALD.png', 150.00, '2025-12-13 20:22:08', '2025-12-13 20:22:08', 100.00, 150.00),
(560, 121, 'ready', 85, 'مناديل وايت', 'P00000560', 'العلبه 500 منديل', 'products/nZ91DSS6hKfSdkbYWcLR8K9It3bxMNp2CNAWVNBS.png', 150.00, '2025-12-15 16:13:03', '2025-12-15 16:13:03', 100.00, 150.00),
(561, 131, 'ready', 87, 'ربع ممبار', 'P00000561', 'ربع ممبار', 'products/3odRTXYTeTWieQWLl41Av0Fm4oJB2WDX9alo5r8W.jpg', 150.00, '2025-12-15 18:09:46', '2025-12-15 18:09:46', 100.00, 150.00),
(562, 131, 'ready', 87, 'ربع كبده مقلية', 'P00000562', 'ربع كبده مقلية', 'products/3eKv3fc6sH7nl6V88Jic0carcxwdg6taLQEmdX5Q.jpg', 150.00, '2025-12-15 18:10:52', '2025-12-15 18:10:52', 100.00, 150.00),
(563, 131, 'ready', 87, 'ربع كبدة اسكندراني', 'P00000563', 'ربع كبدة اسكندراني', 'products/zpClrN4gJ6rDlQwI6ZILMByANdywdR5Afu8ju6zb.jpg', 150.00, '2025-12-15 18:11:45', '2025-12-15 18:11:45', 100.00, 150.00),
(564, 131, 'ready', 87, 'ربع مخ', 'P00000564', 'ربع مخ', 'products/DOrUkpHs5pYkbuGHMqeppx7vvgXBdeEOzcMppatv.jpg', 150.00, '2025-12-15 18:12:34', '2025-12-15 18:12:34', 100.00, 150.00),
(565, 131, 'ready', 87, 'نص تقاطيع', 'P00000565', 'كرشه فشه حلويات', 'products/nYc8wmY9A56JOsKspL8DlJHj02vQgEMuD6Hd9noA.jpg', 150.00, '2025-12-15 18:13:48', '2025-12-15 18:13:48', 100.00, 150.00),
(566, 131, 'ready', 87, 'نص مشكل', 'P00000566', 'كرشة +فشه+حلويات+لحمة راس+كوترع ضاني', 'products/4xiqTxZ5UXU4x3oOE2InI8I7t6f3YOYit6gQEVwX.jpg', 150.00, '2025-12-15 18:15:59', '2025-12-15 18:15:59', 100.00, 150.00),
(567, 131, 'ready', 87, 'نص لحمة راس', 'P00000567', 'نص لحمة راس', 'products/udZzeg2BIF0kciuRJev9KrxZ4ZlQJKUfKLGFHHtd.webp', 150.00, '2025-12-15 18:17:33', '2025-12-15 18:17:33', 100.00, 150.00),
(568, 132, 'ready', 87, 'مشكل', 'P00000568', 'مشكل', 'products/9X3nmOt8tY2Jx8pK0J60HnmyEmn50Ja0Haz0ogIb.jpg', 150.00, '2025-12-15 18:20:02', '2025-12-15 18:20:02', 100.00, 150.00),
(569, 132, 'ready', 87, 'تقاطيع', 'P00000569', 'تقاطيع', 'products/YEPCr1navDADlS620sd1ACM4TbAqKi4xiSnLwrTt.png', 150.00, '2025-12-15 18:29:52', '2025-12-15 18:29:52', 100.00, 150.00),
(570, 132, 'ready', 87, 'لحمة راس', 'P00000570', 'لحمة راس', 'products/2XkPg8XPZ6cDdQwWogXqMjvbmstbJQ2m9fqDO25H.webp', 150.00, '2025-12-15 18:33:20', '2025-12-15 18:33:20', 100.00, 150.00),
(571, 132, 'ready', 87, 'كوارع ضاني', 'P00000571', 'كوارع ضاني', 'products/bN4okbYzO7XIj6Q6xPPdyeJJJXwzh3sEnArP2KQm.jpg', 150.00, '2025-12-15 18:36:13', '2025-12-15 18:36:13', 100.00, 150.00),
(572, 132, 'ready', 87, 'عجالي', 'P00000572', 'عجالي', 'products/xUDmszywwnd26OppAxDTeaOg07VGgkEplJXSWpGz.jpg', 150.00, '2025-12-15 18:41:03', '2025-12-15 18:41:03', 100.00, 150.00),
(573, 132, 'ready', 87, 'لسان صافي', 'P00000573', 'لسان صافي', 'products/qebun13imhdydVMWRE4Gby4Z4UEAuYHDARuP2bQ5.jpg', 150.00, '2025-12-15 18:42:28', '2025-12-15 18:42:28', 100.00, 150.00),
(574, 132, 'ready', 87, 'وجبه عائلي', 'P00000574', 'ربع ممبار+لحمه راس+كوارع ضاني+تقاطيع', 'products/2hg3ArDWY8w5Q5Ykz7AaMvTA6lmnQp2MauC9g9Un.jpg', 150.00, '2025-12-15 18:44:47', '2025-12-15 18:44:47', 100.00, 150.00),
(575, 133, 'ready', 87, 'ساندوتش كبده مقلي', 'P00000575', 'ساندوتش كبده مقلي', 'products/pHySjksuyyN4gmqwfYiAc1O6kyBfune04xanPnfy.jpg', 150.00, '2025-12-15 18:53:58', '2025-12-15 18:53:58', 100.00, 150.00),
(576, 133, 'ready', 87, 'ساندوتش كبدة اسكندراني', 'P00000576', 'ساندوتش كبدة اسكندراني', 'products/PVNLvZh6C2kkznzfaGrLw3XE2TLI846uPRkTC5UX.webp', 150.00, '2025-12-15 18:55:19', '2025-12-15 18:55:19', 100.00, 150.00),
(577, 133, 'ready', 87, 'ساندوتش تقاطيع', 'P00000577', 'ساندوتش تقاطيع', 'products/7yfJ1Fb4674qqLjDFNcHY2tC36knmhYtWme5nd8I.jpg', 150.00, '2025-12-15 18:56:53', '2025-12-15 18:56:53', 100.00, 150.00),
(578, 133, 'ready', 87, 'ساندوتش مشكل', 'P00000578', 'ساندوتش مشكل', 'products/gakEi15yKL3TbdIdxnbTji61YHu02EYSZPuR4vgs.jpg', 150.00, '2025-12-15 18:58:05', '2025-12-15 18:58:05', 100.00, 150.00),
(579, 133, 'ready', 87, 'ساندوتش لحمة راس', 'P00000579', 'ساندوتش لحمة راس', 'products/2qgM29uk9EJ9jVaCwGmpAus8Nm6CMu6Ig6adMJIG.jpg', 150.00, '2025-12-15 18:59:27', '2025-12-15 18:59:27', 100.00, 150.00),
(580, 133, 'ready', 87, 'ساندوتش مخ', 'P00000580', 'ساندوتش مخ', 'products/sQlyK0V5bOvaXEwAgje62ouxxWkBQ2lEtUhjU6tM.jpg', 150.00, '2025-12-15 19:00:28', '2025-12-15 19:00:28', 100.00, 150.00),
(581, 133, 'ready', 87, 'ساندوتش ممبار', 'P00000581', 'ساندوتش ممبار', 'products/kKoyuiSDv3CMTLYwO7SFC9zzkOZeh9YvWut77iWV.webp', 150.00, '2025-12-15 19:01:36', '2025-12-15 19:01:36', 100.00, 150.00),
(770, 97, 'ready', 79, 'ساندوتش حووشي بنن بيف', 'P00000770', 'حواوشي+بيكون+جبنه+كاتشب +طحينة', 'products/JUlwvoaL4mIkIL0ohERGNX2fF7armMsGiu8GASvM.jpg', 150.00, '2025-12-29 21:20:05', '2025-12-29 21:20:05', 100.00, 150.00),
(771, 97, 'ready', 79, 'ساندوتش كرسبي', 'P00000771', 'قطع الكرسبي مع الخص مع عيش تورتيلا', 'products/N1TzVBIVklRbTVKNrTx9NpKpSrBvnwOe9y5H6pJ2.jpg', 150.00, '2025-12-30 00:05:07', '2025-12-30 00:05:07', 100.00, 150.00),
(772, 91, 'ready', 71, 'شاى اخضر', 'P00000772', 'شاى صينى', '1778481221.jpeg', NULL, '2026-05-11 03:33:41', '2026-05-11 03:33:41', 25.00, 30.00),
(773, 160, 'ready', 71, 'لحوم مجمدة', '2000000007731', 'لحوم مستوردة', '1778855448.jpg', NULL, '2026-05-15 11:30:48', '2026-05-15 11:30:48', 100.00, 150.00),
(774, 108, 'ready', 71, 'لاب توب', '2000000007748', 'اجهزة كمبيوتر', '1778856508.png', NULL, '2026-05-15 11:48:28', '2026-05-15 11:48:28', 5000.00, 6000.00),
(775, 91, 'ready', 71, 'زبادى', '2000000007755', 'زبادى طبيعى', '1779352560.jpg', NULL, '2026-05-21 05:36:00', '2026-05-21 05:36:00', 100.00, 130.00);

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
  `size` varchar(191) NOT NULL,
  `barcode` varchar(191) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Purchase_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `size`, `barcode`, `price`, `product_id`, `created_at`, `updated_at`, `Purchase_price`, `selling_price`, `quantity`) VALUES
(3, 'وسط', 'S00000003', 150, 1, '2025-05-07 12:11:01', '2025-05-07 12:11:01', 100.00, 150.00, 2),
(4, 'نص', 'S00000004', 150, 1, '2025-05-07 12:11:01', '2025-05-07 12:11:01', 100.00, 150.00, 20),
(5, 'نص', 'S00000005', 150, 2, '2025-05-07 12:12:28', '2025-05-07 12:12:28', 100.00, 150.00, 11),
(6, 'كيلو', 'S00000006', 150, 2, '2025-05-07 12:12:28', '2025-05-07 12:12:28', 100.00, 150.00, 15),
(7, 'نص', 'S00000007', 150, 3, '2025-05-07 12:13:51', '2025-05-07 12:13:51', 100.00, 150.00, 1),
(8, 'كيلو', 'S00000008', 150, 3, '2025-05-07 12:13:51', '2025-05-07 12:13:51', 100.00, 150.00, 2),
(9, 'صغير', 'S00000009', 150, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18', 100.00, 150.00, 5),
(10, 'وسط', 'S00000010', 150, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18', 100.00, 150.00, 20),
(11, 'كبير', 'S00000011', 150, 4, '2025-05-07 12:31:18', '2025-05-07 12:31:18', 100.00, 150.00, 5),
(12, 'كبير', 'S00000012', 150, 5, '2025-05-07 12:31:58', '2025-05-07 12:31:58', 100.00, 150.00, 2),
(13, 'صغير', 'S00000013', 150, 6, '2025-08-16 11:47:53', '2025-08-16 11:47:53', 100.00, 150.00, 17),
(14, 'كبير', 'S00000014', 150, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12', 100.00, 150.00, 19),
(15, 'وسط', 'S00000015', 150, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12', 100.00, 150.00, 2),
(16, 'صغير', 'S00000016', 150, 7, '2025-08-16 12:52:12', '2025-08-16 12:52:12', 100.00, 150.00, 12),
(17, 'صغيره', 'S00000017', 150, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27', 100.00, 150.00, 14),
(18, 'متوسطه', 'S00000018', 150, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27', 100.00, 150.00, 16),
(19, 'كبيره', 'S00000019', 150, 8, '2025-08-16 13:01:27', '2025-08-16 13:01:27', 100.00, 150.00, 14),
(20, 'صغيره', 'S00000020', 150, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39', 100.00, 150.00, 3),
(21, 'متوسطه', 'S00000021', 150, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39', 100.00, 150.00, 11),
(22, 'كبيره', 'S00000022', 150, 9, '2025-08-16 13:14:39', '2025-08-16 13:14:39', 100.00, 150.00, 4),
(23, 'صغيره', 'S00000023', 150, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47', 100.00, 150.00, 10),
(24, 'متوسطه', 'S00000024', 150, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47', 100.00, 150.00, 15),
(25, 'كبيره', 'S00000025', 150, 10, '2025-08-16 13:23:47', '2025-08-16 13:23:47', 100.00, 150.00, 5),
(26, 'صغيره', 'S00000026', 150, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17', 100.00, 150.00, 2),
(27, 'متوسطه', 'S00000027', 150, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17', 100.00, 150.00, 12),
(28, 'كبيره', 'S00000028', 150, 11, '2025-08-16 13:30:17', '2025-08-16 13:30:17', 100.00, 150.00, 13),
(29, 'صغيره', 'S00000029', 150, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32', 100.00, 150.00, 8),
(30, 'متوسطه', 'S00000030', 150, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32', 100.00, 150.00, 3),
(31, 'كبيره', 'S00000031', 150, 12, '2025-08-16 13:33:32', '2025-08-16 13:33:32', 100.00, 150.00, 8),
(32, 'صغيره', 'S00000032', 150, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00', 100.00, 150.00, 13),
(33, 'متوسطه', 'S00000033', 150, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00', 100.00, 150.00, 19),
(34, 'كبيره', 'S00000034', 150, 13, '2025-08-16 13:36:00', '2025-08-16 13:36:00', 100.00, 150.00, 16),
(35, 'صغيره', 'S00000035', 150, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29', 100.00, 150.00, 3),
(36, 'متوسطه', 'S00000036', 150, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29', 100.00, 150.00, 5),
(37, 'كبيره', 'S00000037', 150, 14, '2025-08-16 13:38:29', '2025-08-16 13:38:29', 100.00, 150.00, 17),
(38, 'صغيره', 'S00000038', 150, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31', 100.00, 150.00, 10),
(39, 'متوسطه', 'S00000039', 150, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31', 100.00, 150.00, 16),
(40, 'كبيره', 'S00000040', 150, 15, '2025-08-16 13:40:31', '2025-08-16 13:40:31', 100.00, 150.00, 12),
(41, 'صغيره', 'S00000041', 150, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04', 100.00, 150.00, 11),
(42, 'متوسطه', 'S00000042', 150, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04', 100.00, 150.00, 17),
(43, 'كبيره', 'S00000043', 150, 16, '2025-08-16 13:43:04', '2025-08-16 13:43:04', 100.00, 150.00, 11),
(44, 'صغيره', 'S00000044', 150, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50', 100.00, 150.00, 3),
(45, 'متوسطه', 'S00000045', 150, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50', 100.00, 150.00, 1),
(46, 'كبيره', 'S00000046', 150, 17, '2025-08-16 13:45:50', '2025-08-16 13:45:50', 100.00, 150.00, 16),
(47, 'صغيره', 'S00000047', 150, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36', 100.00, 150.00, 17),
(48, 'متوسطه', 'S00000048', 150, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36', 100.00, 150.00, 18),
(49, 'كبيره', 'S00000049', 150, 18, '2025-08-16 13:47:36', '2025-08-16 13:47:36', 100.00, 150.00, 18),
(50, 'large', 'S00000050', 150, 19, '2025-08-26 07:36:40', '2025-08-26 07:36:40', 100.00, 150.00, 17),
(51, 'M', 'S00000051', 150, 19, '2025-08-26 07:36:40', '2025-08-26 07:36:40', 100.00, 150.00, 7),
(52, 'large', 'S00000052', 150, 20, '2025-08-31 09:15:42', '2025-08-31 09:15:42', 100.00, 150.00, 6),
(53, 'large', 'S00000053', 150, 21, '2025-08-31 09:24:29', '2025-08-31 09:24:29', 100.00, 150.00, 8),
(54, 'large', 'S00000054', 150, 22, '2025-08-31 09:37:19', '2025-08-31 09:37:19', 100.00, 150.00, 19),
(55, 'large', 'S00000055', 150, 25, '2025-08-31 10:35:48', '2025-08-31 10:35:48', 100.00, 150.00, 14),
(56, 'large', 'S00000056', 150, 26, '2025-08-31 10:40:40', '2025-08-31 10:40:40', 100.00, 150.00, 12),
(57, 'large', 'S00000057', 150, 27, '2025-08-31 10:41:10', '2025-08-31 10:41:10', 100.00, 150.00, 16),
(58, 'large', 'S00000058', 150, 28, '2025-08-31 10:42:10', '2025-08-31 10:42:10', 100.00, 150.00, 4),
(59, 'large', 'S00000059', 150, 29, '2025-08-31 10:45:01', '2025-08-31 10:45:01', 100.00, 150.00, 11),
(60, 'صغير', 'S00000060', 150, 29, '2025-08-31 10:45:01', '2025-08-31 10:45:01', 100.00, 150.00, 2),
(61, 'صغير', 'S00000061', 150, 30, '2025-08-31 10:45:37', '2025-08-31 10:45:37', 100.00, 150.00, 15),
(62, 'صغير', 'S00000062', 150, 31, '2025-08-31 11:02:30', '2025-08-31 11:02:30', 100.00, 150.00, 12),
(63, 'large', 'S00000063', 150, 32, '2025-08-31 11:03:31', '2025-08-31 11:03:31', 100.00, 150.00, 12),
(64, 'كبير', 'S00000064', 150, 33, '2025-08-31 11:05:49', '2025-08-31 11:05:49', 100.00, 150.00, 4),
(65, 'صغير', 'S00000065', 150, 34, '2025-08-31 11:25:21', '2025-08-31 11:25:21', 100.00, 150.00, 2),
(66, 'صغير', 'S00000066', 150, 35, '2025-08-31 11:35:37', '2025-08-31 11:35:37', 100.00, 150.00, 20),
(69, 'نص', 'S00000069', 150, 36, '2025-08-31 11:57:27', '2025-08-31 11:57:27', 100.00, 150.00, 13),
(70, 'وسط', 'S00000070', 150, 37, '2025-09-01 08:44:00', '2025-09-01 08:44:00', 100.00, 150.00, 5),
(72, 'وسط', 'S00000072', 150, 39, '2025-09-01 09:14:07', '2025-09-01 09:14:07', 100.00, 150.00, 6),
(73, 'صغير', 'S00000073', 150, 40, '2025-09-01 09:19:08', '2025-09-01 09:19:08', 100.00, 150.00, 15),
(75, 'وسط', 'S00000075', 150, 41, '2025-09-01 09:26:02', '2025-09-01 09:26:02', 100.00, 150.00, 15),
(77, 'صغير', 'S00000077', 150, 42, '2025-09-01 09:28:55', '2025-09-01 09:28:55', 100.00, 150.00, 12),
(81, 'وسط', 'S00000081', 150, 43, '2025-09-01 09:36:37', '2025-09-01 09:36:37', 100.00, 150.00, 12),
(83, 'وسط', 'S00000083', 150, 44, '2025-09-01 09:39:41', '2025-09-01 09:39:41', 100.00, 150.00, 3),
(85, 'وسط', 'S00000085', 150, 45, '2025-09-01 09:44:27', '2025-09-01 09:44:27', 100.00, 150.00, 18),
(88, 'صغير', 'S00000088', 150, 46, '2025-09-01 09:48:08', '2025-09-01 09:48:08', 100.00, 150.00, 1),
(90, 'وسط', 'S00000090', 150, 47, '2025-09-01 10:14:40', '2025-09-01 10:14:40', 100.00, 150.00, 9),
(91, 'صغير', 'S00000091', 150, 48, '2025-09-01 10:16:01', '2025-09-01 10:16:01', 100.00, 150.00, 4),
(93, 'وسط', 'S00000093', 150, 49, '2025-09-01 10:17:05', '2025-09-01 10:17:05', 100.00, 150.00, 10),
(94, 'وسط', 'S00000094', 150, 50, '2025-09-01 10:18:12', '2025-09-01 10:18:12', 100.00, 150.00, 17),
(97, 'وسط', 'S00000097', 150, 51, '2025-09-01 10:24:39', '2025-09-01 10:24:39', 100.00, 150.00, 15),
(98, 'صغير', 'S00000098', 150, 52, '2025-09-02 11:49:10', '2025-09-02 11:49:10', 100.00, 150.00, 4),
(99, 'Large', 'S00000099', 150, 53, '2025-09-03 15:23:13', '2025-09-03 15:23:13', 100.00, 150.00, 16),
(100, 'صغير', 'S00000100', 150, 54, '2025-09-04 08:34:30', '2025-09-04 08:34:30', 100.00, 150.00, 8),
(101, 'Large', 'S00000101', 150, 55, '2025-09-04 09:37:03', '2025-09-04 09:37:03', 100.00, 150.00, 10),
(102, 'وسط', 'S00000102', 150, 56, '2025-09-04 09:37:48', '2025-09-04 09:37:48', 100.00, 150.00, 8),
(103, 'صغير', 'S00000103', 150, 57, '2025-09-04 09:39:53', '2025-09-04 09:39:53', 100.00, 150.00, 6),
(104, 'وسط', 'S00000104', 150, 58, '2025-09-04 09:39:53', '2025-09-04 09:39:53', 100.00, 150.00, 6),
(105, 'وسط', 'S00000105', 150, 59, '2025-09-04 09:41:18', '2025-09-04 09:41:18', 100.00, 150.00, 13),
(106, 'وسط', 'S00000106', 150, 60, '2025-09-04 09:43:46', '2025-09-04 09:43:46', 100.00, 150.00, 8),
(108, 'وسط', 'S00000108', 150, 62, '2025-09-04 09:46:42', '2025-09-04 09:46:42', 100.00, 150.00, 17),
(110, 'وسط', 'S00000110', 150, 64, '2025-09-04 09:49:08', '2025-09-04 09:49:08', 100.00, 150.00, 4),
(111, 'وسط', 'S00000111', 150, 65, '2025-09-04 09:49:59', '2025-09-04 09:49:59', 100.00, 150.00, 6),
(112, 'وسط', 'S00000112', 150, 66, '2025-09-04 09:52:00', '2025-09-04 09:52:00', 100.00, 150.00, 18),
(113, 'وسط', 'S00000113', 150, 67, '2025-09-04 09:53:30', '2025-09-04 09:53:30', 100.00, 150.00, 10),
(114, 'وسط', 'S00000114', 150, 68, '2025-09-04 10:06:09', '2025-09-04 10:06:09', 100.00, 150.00, 19),
(115, 'وسط', 'S00000115', 150, 69, '2025-09-04 10:08:06', '2025-09-04 10:08:06', 100.00, 150.00, 1),
(116, 'وسط', 'S00000116', 150, 70, '2025-09-04 10:10:16', '2025-09-04 10:10:16', 100.00, 150.00, 9),
(117, 'وسط', 'S00000117', 150, 71, '2025-09-04 10:11:16', '2025-09-04 10:11:16', 100.00, 150.00, 20),
(118, 'وسط', 'S00000118', 150, 63, '2025-09-04 10:51:43', '2025-09-04 10:51:43', 100.00, 150.00, 15),
(119, 'وسط', 'S00000119', 150, 61, '2025-09-04 10:52:19', '2025-09-04 10:52:19', 100.00, 150.00, 12),
(122, 'large', 'S00000122', 150, 73, '2025-09-06 11:54:41', '2025-09-06 11:54:41', 100.00, 150.00, 14),
(123, 'وسط', 'S00000123', 150, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26', 100.00, 150.00, 13),
(124, 'كبير', 'S00000124', 150, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26', 100.00, 150.00, 4),
(125, 'كبير اوي', 'S00000125', 150, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26', 100.00, 150.00, 19),
(126, 'كبير خاص', 'S00000126', 150, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26', 100.00, 150.00, 5),
(127, 'اكبر حاجه', 'S00000127', 150, 38, '2025-09-06 12:09:26', '2025-09-06 12:09:26', 100.00, 150.00, 5),
(130, '5*9', 'S00000130', 150, 74, '2025-09-14 20:13:33', '2025-09-14 20:13:33', 100.00, 150.00, 9),
(135, 'فاهيتا -', 'S00000135', 150, 75, '2025-09-15 17:31:24', '2025-09-15 17:31:24', 100.00, 150.00, 9),
(136, 'سويت -', 'S00000136', 150, 76, '2025-09-15 17:33:08', '2025-09-15 17:33:08', 100.00, 150.00, 17),
(137, 'large', 'S00000137', 150, 79, '2025-09-16 11:13:33', '2025-09-16 11:13:33', 100.00, 150.00, 20),
(140, 'Large', 'S00000140', 150, 82, '2025-09-16 13:06:48', '2025-09-16 13:06:48', 100.00, 150.00, 9),
(141, 'كوردون بلو -', 'S00000141', 150, 83, '2025-09-20 10:55:43', '2025-09-20 10:55:43', 100.00, 150.00, 2),
(142, 'تشيكن زنجر -', 'S00000142', 150, 84, '2025-09-20 11:00:19', '2025-09-20 11:00:19', 100.00, 150.00, 2),
(144, 'تشيكن بانيه -', 'S00000144', 150, 85, '2025-09-20 11:18:20', '2025-09-20 11:18:20', 100.00, 150.00, 5),
(145, 'تشيكن كريسبي -', 'S00000145', 150, 86, '2025-09-20 11:19:45', '2025-09-20 11:19:45', 100.00, 150.00, 19),
(146, 'شيش طاووق', 'S00000146', 150, 87, '2025-09-20 11:22:37', '2025-09-20 11:22:37', 100.00, 150.00, 20),
(147, 'تشيكن جريل -', 'S00000147', 150, 88, '2025-09-20 11:28:05', '2025-09-20 11:28:05', 100.00, 150.00, 1),
(148, 'الكمية 1200 مل', 'S00000148', 150, 89, '2025-09-26 18:47:42', '2025-09-26 18:47:42', 100.00, 150.00, 6),
(149, '800 مل', 'S00000149', 150, 90, '2025-09-26 18:49:06', '2025-09-26 18:49:06', 100.00, 150.00, 5),
(150, '800 مل + ٪ 2', 'S00000150', 150, 91, '2025-09-26 18:50:04', '2025-09-26 18:50:04', 100.00, 150.00, 7),
(151, '500 مل + 2 ٪', 'S00000151', 150, 92, '2025-09-26 18:51:03', '2025-09-26 18:51:03', 100.00, 150.00, 1),
(153, 'سنجل', 'S00000153', 150, 109, '2025-11-05 21:52:19', '2025-11-05 21:52:19', 100.00, 150.00, 4),
(154, 'دبل', 'S00000154', 150, 109, '2025-11-05 21:52:19', '2025-11-05 21:52:19', 100.00, 150.00, 16),
(155, 'سنجل', 'S00000155', 150, 110, '2025-11-05 22:04:13', '2025-11-05 22:04:13', 100.00, 150.00, 8),
(156, 'دبل', 'S00000156', 150, 110, '2025-11-05 22:04:13', '2025-11-05 22:04:13', 100.00, 150.00, 9),
(157, 'سنجل', 'S00000157', 150, 111, '2025-11-06 20:40:45', '2025-11-06 20:40:45', 100.00, 150.00, 1),
(158, 'دبل', 'S00000158', 150, 111, '2025-11-06 20:40:45', '2025-11-06 20:40:45', 100.00, 150.00, 19),
(159, 'كفته مشويه', 'S00000159', 150, 112, '2025-11-13 09:01:46', '2025-11-13 09:01:46', 100.00, 150.00, 12),
(160, 'سجق شرقي', 'S00000160', 150, 113, '2025-11-13 09:05:48', '2025-11-13 09:05:48', 100.00, 150.00, 4),
(161, 'سجق شرقي', 'S00000161', 150, 114, '2025-11-13 09:07:40', '2025-11-13 09:07:40', 100.00, 150.00, 20),
(162, 'بيف برجر', 'S00000162', 150, 115, '2025-11-13 09:11:35', '2025-11-13 09:11:35', 100.00, 150.00, 9),
(163, 'هوت دوج', 'S00000163', 150, 116, '2025-11-13 09:13:47', '2025-11-13 09:13:47', 100.00, 150.00, 4),
(164, 'كريب مشروم', 'S00000164', 150, 117, '2025-11-13 09:15:23', '2025-11-13 09:15:23', 100.00, 150.00, 14),
(165, 'كريب بطاطس', 'S00000165', 150, 118, '2025-11-13 09:17:58', '2025-11-13 09:17:58', 100.00, 150.00, 18),
(166, 'ميكس شيش كفته', 'S00000166', 150, 119, '2025-11-13 09:24:26', '2025-11-13 09:24:26', 100.00, 150.00, 5),
(167, 'ميككس تشيكن', 'S00000167', 150, 120, '2025-11-13 09:27:20', '2025-11-13 09:27:20', 100.00, 150.00, 10),
(168, 'ميكس لحوم', 'S00000168', 150, 121, '2025-11-13 09:29:12', '2025-11-13 09:29:12', 100.00, 150.00, 17),
(169, 'ميكس لحوم', 'S00000169', 150, 122, '2025-11-13 09:29:22', '2025-11-13 09:29:22', 100.00, 150.00, 13),
(170, 'ميكس لحوم', 'S00000170', 150, 123, '2025-11-13 09:30:14', '2025-11-13 09:30:14', 100.00, 150.00, 15),
(174, 'ميكس كوكتيل', 'S00000174', 150, 124, '2025-11-13 09:56:56', '2025-11-13 09:56:56', 100.00, 150.00, 13),
(175, 'ميكس ابو البنات', 'S00000175', 150, 125, '2025-11-13 09:59:21', '2025-11-13 09:59:21', 100.00, 150.00, 1),
(176, 'حواوشي كلاسيك كبير', 'S00000176', 150, 126, '2025-11-13 10:02:39', '2025-11-13 10:02:39', 100.00, 150.00, 3),
(177, 'حواوشي بالجبنه كبير', 'S00000177', 150, 127, '2025-11-13 10:09:42', '2025-11-13 10:09:42', 100.00, 150.00, 14),
(178, 'حواوشي تركي مدخن', 'S00000178', 150, 128, '2025-11-13 10:13:22', '2025-11-13 10:13:22', 100.00, 150.00, 1),
(179, 'حواوشي بيف بيكون', 'S00000179', 150, 129, '2025-11-13 10:14:17', '2025-11-13 10:14:17', 100.00, 150.00, 3),
(180, 'حواوشي سجق', 'S00000180', 150, 130, '2025-11-13 10:14:49', '2025-11-13 10:14:49', 100.00, 150.00, 10),
(181, 'حواوشي ابو البنات', 'S00000181', 150, 131, '2025-11-13 10:15:30', '2025-11-13 10:15:30', 100.00, 150.00, 2),
(182, 'صاج', 'S00000182', 150, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06', 100.00, 150.00, 17),
(183, 'فرنساوي', 'S00000183', 150, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06', 100.00, 150.00, 19),
(184, 'كايزر', 'S00000184', 150, 132, '2025-11-13 10:28:06', '2025-11-13 10:28:06', 100.00, 150.00, 4),
(185, 'صاج', 'S00000185', 150, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33', 100.00, 150.00, 4),
(186, 'فرنساوي', 'S00000186', 150, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33', 100.00, 150.00, 6),
(187, 'كايزر', 'S00000187', 150, 133, '2025-11-13 10:31:33', '2025-11-13 10:31:33', 100.00, 150.00, 16),
(188, 'صاج', 'S00000188', 150, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39', 100.00, 150.00, 2),
(189, 'فرنساوي', 'S00000189', 150, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39', 100.00, 150.00, 3),
(190, 'كايزر', 'S00000190', 150, 134, '2025-11-13 10:32:39', '2025-11-13 10:32:39', 100.00, 150.00, 10),
(191, 'صاج', 'S00000191', 150, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27', 100.00, 150.00, 18),
(192, 'فرنساوي', 'S00000192', 150, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27', 100.00, 150.00, 19),
(193, 'كايزر', 'S00000193', 150, 135, '2025-11-13 10:35:27', '2025-11-13 10:35:27', 100.00, 150.00, 2),
(194, 'صاج', 'S00000194', 150, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43', 100.00, 150.00, 13),
(195, 'فرنساوي', 'S00000195', 150, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43', 100.00, 150.00, 18),
(196, 'كايزر', 'S00000196', 150, 136, '2025-11-13 10:37:43', '2025-11-13 10:37:43', 100.00, 150.00, 11),
(197, 'صاج', 'S00000197', 150, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36', 100.00, 150.00, 1),
(198, 'فرنساوي', 'S00000198', 150, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36', 100.00, 150.00, 10),
(199, 'كايزر', 'S00000199', 150, 137, '2025-11-13 10:38:36', '2025-11-13 10:38:36', 100.00, 150.00, 6),
(200, 'وجبه شاورما فراخ سينجل', 'S00000200', 150, 138, '2025-11-13 10:58:50', '2025-11-13 10:58:50', 100.00, 150.00, 2),
(201, 'وجبه شاورما فراخ دبل', 'S00000201', 150, 139, '2025-11-13 10:59:47', '2025-11-13 10:59:47', 100.00, 150.00, 8),
(202, 'وجبه شاورما لحمه سينجل', 'S00000202', 150, 140, '2025-11-13 11:00:46', '2025-11-13 11:00:46', 100.00, 150.00, 16),
(203, 'وجبه شاورما لحمه دبل', 'S00000203', 150, 141, '2025-11-13 11:01:29', '2025-11-13 11:01:29', 100.00, 150.00, 14),
(204, 'وجبه ماريا لحمه', 'S00000204', 150, 142, '2025-11-13 11:02:27', '2025-11-13 11:02:27', 100.00, 150.00, 1),
(205, 'وجبه ماريا فراخ', 'S00000205', 150, 143, '2025-11-13 11:03:21', '2025-11-13 11:03:21', 100.00, 150.00, 3),
(206, 'وجبه شاورما فراخ كبيره', 'S00000206', 150, 144, '2025-11-13 11:04:55', '2025-11-13 11:04:55', 100.00, 150.00, 13),
(209, 'فته شاورما لحمه وسط', 'S00000209', 150, 147, '2025-11-13 11:08:51', '2025-11-13 11:08:51', 100.00, 150.00, 14),
(210, 'فته شاورما فراخ وسط', 'S00000210', 150, 145, '2025-11-13 11:09:35', '2025-11-13 11:09:35', 100.00, 150.00, 9),
(211, 'فته شاورما لحمه كبيره', 'S00000211', 150, 146, '2025-11-13 11:10:02', '2025-11-13 11:10:02', 100.00, 150.00, 4),
(212, 'وجبه شاورما فرط', 'S00000212', 150, 148, '2025-11-13 11:11:06', '2025-11-13 11:11:06', 100.00, 150.00, 13),
(213, 'وجبه نص كيلو شاورما فراخ', 'S00000213', 150, 149, '2025-11-13 11:12:07', '2025-11-13 11:12:07', 100.00, 150.00, 11),
(214, 'وجبه كيلو شاورما فراخ', 'S00000214', 150, 150, '2025-11-13 11:13:05', '2025-11-13 11:13:05', 100.00, 150.00, 18),
(215, 'بيتزا مارجريتا', 'S00000215', 150, 151, '2025-11-13 12:11:17', '2025-11-13 12:11:17', 100.00, 150.00, 16),
(216, 'بيتزا خضروات', 'S00000216', 150, 152, '2025-11-13 12:13:17', '2025-11-13 12:13:17', 100.00, 150.00, 4),
(217, 'بيتزا ميكس جبن', 'S00000217', 150, 153, '2025-11-13 12:14:54', '2025-11-13 12:14:54', 100.00, 150.00, 14),
(218, 'بيتزا سلامي', 'S00000218', 150, 154, '2025-11-13 12:15:57', '2025-11-13 12:15:57', 100.00, 150.00, 15),
(219, 'بيتزا سجق', 'S00000219', 150, 155, '2025-11-13 12:17:29', '2025-11-13 12:17:29', 100.00, 150.00, 14),
(220, 'بيتزا تشيكن باربيكيو', 'S00000220', 150, 156, '2025-11-13 12:19:35', '2025-11-13 12:19:35', 100.00, 150.00, 3),
(221, 'بيتزا تشيكن سوبريم', 'S00000221', 150, 157, '2025-11-13 12:23:42', '2025-11-13 12:23:42', 100.00, 150.00, 13),
(222, 'بيتزا سوبر سوبريم', 'S00000222', 150, 158, '2025-11-13 12:26:54', '2025-11-13 12:26:54', 100.00, 150.00, 17),
(223, 'منقوشه قشقوان', 'S00000223', 150, 159, '2025-11-13 12:32:58', '2025-11-13 12:32:58', 100.00, 150.00, 5),
(224, 'منقوشه بيض عيون', 'S00000224', 150, 160, '2025-11-13 12:34:14', '2025-11-13 12:34:14', 100.00, 150.00, 12),
(225, 'منقوشه حلوم', 'S00000225', 150, 161, '2025-11-13 12:34:53', '2025-11-13 12:34:53', 100.00, 150.00, 7),
(226, 'منقوشه محمره', 'S00000226', 150, 162, '2025-11-13 12:35:34', '2025-11-13 12:35:34', 100.00, 150.00, 18),
(227, 'منقوشه سبانخ', 'S00000227', 150, 163, '2025-11-13 12:36:16', '2025-11-13 12:36:16', 100.00, 150.00, 10),
(228, 'منقوشه زعتر', 'S00000228', 150, 164, '2025-11-13 12:36:49', '2025-11-13 12:36:49', 100.00, 150.00, 13),
(229, 'منقوشه كيري', 'S00000229', 150, 165, '2025-11-13 12:37:21', '2025-11-13 12:37:21', 100.00, 150.00, 15),
(230, 'ميني بيتزا', 'S00000230', 150, 166, '2025-11-13 12:37:58', '2025-11-13 12:37:58', 100.00, 150.00, 15),
(231, 'منقوشه لحم بالعجين', 'S00000231', 150, 167, '2025-11-13 12:38:41', '2025-11-13 12:38:41', 100.00, 150.00, 9),
(232, 'بنا الفريدو', 'S00000232', 150, 168, '2025-11-13 12:40:52', '2025-11-13 12:40:52', 100.00, 150.00, 1),
(233, 'تشيكن ميكس تشيز', 'S00000233', 150, 169, '2025-11-13 12:41:52', '2025-11-13 12:41:52', 100.00, 150.00, 15),
(234, 'نجرسكو', 'S00000234', 150, 170, '2025-11-13 12:42:38', '2025-11-13 12:42:38', 100.00, 150.00, 13),
(235, 'تشيكن بيستو', 'S00000235', 150, 171, '2025-11-13 12:43:32', '2025-11-13 12:43:32', 100.00, 150.00, 1),
(236, 'اسباجيتي ميت بول', 'S00000236', 150, 172, '2025-11-13 12:44:21', '2025-11-13 12:44:21', 100.00, 150.00, 4),
(237, 'اربياتا بنا', 'S00000237', 150, 173, '2025-11-13 12:45:07', '2025-11-13 12:45:07', 100.00, 150.00, 17),
(238, 'باستا شيتوس', 'S00000238', 150, 174, '2025-11-13 12:45:50', '2025-11-13 12:45:50', 100.00, 150.00, 11),
(239, '2قطع دجاج بروست صدر', 'S00000239', 150, 175, '2025-11-13 12:47:41', '2025-11-13 12:47:41', 100.00, 150.00, 5),
(240, '2قطع كرسبي', 'S00000240', 150, 176, '2025-11-13 12:48:16', '2025-11-13 12:48:16', 100.00, 150.00, 10),
(241, '2قطع دجاج بروست ورك', 'S00000241', 150, 177, '2025-11-13 12:49:13', '2025-11-13 12:49:13', 100.00, 150.00, 14),
(242, '4قطع كرسبي', 'S00000242', 150, 178, '2025-11-13 12:49:52', '2025-11-13 12:49:52', 100.00, 150.00, 18),
(243, '4قطع دجاج بروست', 'S00000243', 150, 179, '2025-11-13 12:50:47', '2025-11-13 12:50:47', 100.00, 150.00, 11),
(244, '5قطع كرسبي', 'S00000244', 150, 180, '2025-11-13 12:51:36', '2025-11-13 12:51:36', 100.00, 150.00, 18),
(245, 'فرخه بروست8 قطع', 'S00000245', 150, 181, '2025-11-13 12:52:29', '2025-11-13 12:52:29', 100.00, 150.00, 18),
(246, 'وجبه اجنحه دجاج', 'S00000246', 150, 182, '2025-11-13 12:53:23', '2025-11-13 12:53:23', 100.00, 150.00, 16),
(247, 'وجبه10قطع بانيه', 'S00000247', 150, 183, '2025-11-13 12:54:09', '2025-11-13 12:54:09', 100.00, 150.00, 5),
(248, 'سوري', 'S00000248', 150, 184, '2025-11-13 13:52:00', '2025-11-13 13:52:00', 100.00, 150.00, 15),
(249, 'فرنساوي', 'S00000249', 150, 184, '2025-11-13 13:52:00', '2025-11-13 13:52:00', 100.00, 150.00, 19),
(250, 'سوري', 'S00000250', 150, 185, '2025-11-13 13:53:28', '2025-11-13 13:53:28', 100.00, 150.00, 11),
(251, 'فرنساوي', 'S00000251', 150, 185, '2025-11-13 13:53:28', '2025-11-13 13:53:28', 100.00, 150.00, 17),
(252, 'سوري', 'S00000252', 150, 186, '2025-11-13 13:54:32', '2025-11-13 13:54:32', 100.00, 150.00, 12),
(253, 'فرنساوي', 'S00000253', 150, 186, '2025-11-13 13:54:32', '2025-11-13 13:54:32', 100.00, 150.00, 6),
(254, 'سوري', 'S00000254', 150, 187, '2025-11-13 13:55:16', '2025-11-13 13:55:16', 100.00, 150.00, 16),
(255, 'فرنساوي', 'S00000255', 150, 187, '2025-11-13 13:55:16', '2025-11-13 13:55:16', 100.00, 150.00, 19),
(256, 'سوري', 'S00000256', 150, 188, '2025-11-13 13:55:52', '2025-11-13 13:55:52', 100.00, 150.00, 8),
(257, 'فرنساوي', 'S00000257', 150, 188, '2025-11-13 13:55:52', '2025-11-13 13:55:52', 100.00, 150.00, 1),
(258, 'سوري', 'S00000258', 150, 189, '2025-11-13 13:56:34', '2025-11-13 13:56:34', 100.00, 150.00, 20),
(259, 'فرنساوي', 'S00000259', 150, 189, '2025-11-13 13:56:34', '2025-11-13 13:56:34', 100.00, 150.00, 17),
(260, 'سوري', 'S00000260', 150, 190, '2025-11-13 13:57:42', '2025-11-13 13:57:42', 100.00, 150.00, 6),
(261, 'فرنساوي', 'S00000261', 150, 190, '2025-11-13 13:57:42', '2025-11-13 13:57:42', 100.00, 150.00, 19),
(262, 'فرنساوي', 'S00000262', 150, 191, '2025-11-13 13:59:12', '2025-11-13 13:59:12', 100.00, 150.00, 15),
(263, 'فرنساوي', 'S00000263', 150, 192, '2025-11-13 14:00:51', '2025-11-13 14:00:51', 100.00, 150.00, 18),
(264, 'فرنساوي', 'S00000264', 150, 193, '2025-11-13 14:02:20', '2025-11-13 14:02:20', 100.00, 150.00, 6),
(265, 'فرنساوي', 'S00000265', 150, 194, '2025-11-13 14:03:37', '2025-11-13 14:03:37', 100.00, 150.00, 15),
(266, 'برجر كلاسيك', 'S00000266', 150, 195, '2025-11-13 14:11:06', '2025-11-13 14:11:06', 100.00, 150.00, 18),
(267, 'برجر بيض', 'S00000267', 150, 196, '2025-11-13 14:12:27', '2025-11-13 14:12:27', 100.00, 150.00, 3),
(268, 'برجر فولكانو', 'S00000268', 150, 197, '2025-11-13 14:14:55', '2025-11-13 14:14:55', 100.00, 150.00, 1),
(269, 'سموك هاوس باربكيو', 'S00000269', 150, 198, '2025-11-13 14:17:15', '2025-11-13 14:17:15', 100.00, 150.00, 14),
(270, 'سموك هاوس باربكيو', 'S00000270', 150, 199, '2025-11-13 14:17:34', '2025-11-13 14:17:34', 100.00, 150.00, 7),
(271, 'انجري برجر', 'S00000271', 150, 200, '2025-11-13 14:20:27', '2025-11-13 14:20:27', 100.00, 150.00, 11),
(272, 'ميجا مشروم', 'S00000272', 150, 201, '2025-11-13 14:21:39', '2025-11-13 14:21:39', 100.00, 150.00, 16),
(273, 'ميكس بافلو', 'S00000273', 150, 202, '2025-11-13 14:24:02', '2025-11-13 14:24:02', 100.00, 150.00, 4),
(274, 'بيج مان', 'S00000274', 150, 203, '2025-11-13 14:25:46', '2025-11-13 14:25:46', 100.00, 150.00, 13),
(275, 'سندوتش كلاسيك', 'S00000275', 150, 204, '2025-11-13 14:27:18', '2025-11-13 14:27:18', 100.00, 150.00, 14),
(276, 'تشيكن رانش', 'S00000276', 150, 205, '2025-11-13 14:28:41', '2025-11-13 14:28:41', 100.00, 150.00, 9),
(277, 'فاير هوت', 'S00000277', 150, 206, '2025-11-13 14:30:13', '2025-11-13 14:30:13', 100.00, 150.00, 3),
(278, 'سوري', 'S00000278', 150, 207, '2025-11-13 14:37:13', '2025-11-13 14:37:13', 100.00, 150.00, 7),
(279, 'فرنساوي', 'S00000279', 150, 207, '2025-11-13 14:37:13', '2025-11-13 14:37:13', 100.00, 150.00, 4),
(280, 'سوري', 'S00000280', 150, 208, '2025-11-13 14:37:58', '2025-11-13 14:37:58', 100.00, 150.00, 20),
(281, 'فرنساوي', 'S00000281', 150, 208, '2025-11-13 14:37:58', '2025-11-13 14:37:58', 100.00, 150.00, 9),
(282, 'سوري', 'S00000282', 150, 209, '2025-11-13 14:42:41', '2025-11-13 14:42:41', 100.00, 150.00, 1),
(283, 'فرنساوي', 'S00000283', 150, 209, '2025-11-13 14:42:41', '2025-11-13 14:42:41', 100.00, 150.00, 1),
(284, 'سوري', 'S00000284', 150, 210, '2025-11-13 14:43:37', '2025-11-13 14:43:37', 100.00, 150.00, 1),
(285, 'فرنساوي', 'S00000285', 150, 210, '2025-11-13 14:43:37', '2025-11-13 14:43:37', 100.00, 150.00, 2),
(286, 'سوري', 'S00000286', 150, 211, '2025-11-13 14:50:30', '2025-11-13 14:50:30', 100.00, 150.00, 5),
(287, 'فرنساوي', 'S00000287', 150, 211, '2025-11-13 14:50:30', '2025-11-13 14:50:30', 100.00, 150.00, 1),
(288, 'سوري', 'S00000288', 150, 212, '2025-11-13 14:51:25', '2025-11-13 14:51:25', 100.00, 150.00, 7),
(289, 'فرنساوي', 'S00000289', 150, 212, '2025-11-13 14:51:25', '2025-11-13 14:51:25', 100.00, 150.00, 13),
(290, 'سوري', 'S00000290', 150, 213, '2025-11-13 14:52:11', '2025-11-13 14:52:11', 100.00, 150.00, 5),
(291, 'فرنساوي', 'S00000291', 150, 213, '2025-11-13 14:52:11', '2025-11-13 14:52:11', 100.00, 150.00, 3),
(292, 'سوري', 'S00000292', 150, 214, '2025-11-13 14:53:02', '2025-11-13 14:53:02', 100.00, 150.00, 2),
(293, 'فرنساوي', 'S00000293', 150, 214, '2025-11-13 14:53:02', '2025-11-13 14:53:02', 100.00, 150.00, 1),
(311, 'وجبه فراخ بانيه', 'S00000311', 150, 215, '2025-11-13 15:14:47', '2025-11-13 15:14:47', 100.00, 150.00, 17),
(312, 'وجبه تشيكن كرسبي', 'S00000312', 150, 216, '2025-11-13 15:15:48', '2025-11-13 15:15:48', 100.00, 150.00, 3),
(313, 'وجبه ميكس شيش+كفته', 'S00000313', 150, 217, '2025-11-13 15:16:01', '2025-11-13 15:16:01', 100.00, 150.00, 4),
(314, 'وجبه ميكس شاورما لحمه+شاورما فراخ', 'S00000314', 150, 218, '2025-11-13 15:16:25', '2025-11-13 15:16:25', 100.00, 150.00, 9),
(315, 'وجبه ربع كفته', 'S00000315', 150, 219, '2025-11-13 15:16:39', '2025-11-13 15:16:39', 100.00, 150.00, 12),
(316, 'وجبه استربس', 'S00000316', 150, 220, '2025-11-13 15:16:59', '2025-11-13 15:16:59', 100.00, 150.00, 12),
(317, 'وجبه شيش طاووق', 'S00000317', 150, 221, '2025-11-13 15:17:26', '2025-11-13 15:17:26', 100.00, 150.00, 4),
(318, 'وجبه ميكس ابو البنات', 'S00000318', 150, 222, '2025-11-13 15:17:48', '2025-11-13 15:17:48', 100.00, 150.00, 2),
(319, 'كيلو كفته', 'S00000319', 150, 223, '2025-11-13 15:18:01', '2025-11-13 15:18:01', 100.00, 150.00, 20),
(320, 'نص كيلو كفته', 'S00000320', 150, 224, '2025-11-13 15:19:02', '2025-11-13 15:19:02', 100.00, 150.00, 11),
(321, 'فرخه مشويه', 'S00000321', 150, 225, '2025-11-13 15:19:34', '2025-11-13 15:19:34', 100.00, 150.00, 17),
(322, 'نص فرخه مشويه', 'S00000322', 150, 226, '2025-11-13 15:19:50', '2025-11-13 15:19:50', 100.00, 150.00, 12),
(323, 'ربع فرخه صدر', 'S00000323', 150, 227, '2025-11-13 15:20:00', '2025-11-13 15:20:00', 100.00, 150.00, 5),
(324, 'ربع فرخه ورك', 'S00000324', 150, 228, '2025-11-13 15:20:13', '2025-11-13 15:20:13', 100.00, 150.00, 12),
(325, 'كيلو شيش طاووق', 'S00000325', 150, 229, '2025-11-13 15:20:27', '2025-11-13 15:20:27', 100.00, 150.00, 4),
(326, 'كيلو صدور', 'S00000326', 150, 230, '2025-11-13 15:20:47', '2025-11-13 15:20:47', 100.00, 150.00, 5),
(327, 'ميكس تشيز', 'S00000327', 150, 231, '2025-11-13 16:00:52', '2025-11-13 16:00:52', 100.00, 150.00, 10),
(328, 'ميكس تشيز', 'S00000328', 150, 232, '2025-11-13 16:00:55', '2025-11-13 16:00:55', 100.00, 150.00, 14),
(329, 'جبنه موتزاريلا او صوص من اختيارك', 'S00000329', 150, 233, '2025-11-13 16:10:35', '2025-11-13 16:10:35', 100.00, 150.00, 19),
(330, 'باكيت بطاطس بالجبنه', 'S00000330', 150, 234, '2025-11-13 16:13:14', '2025-11-13 16:13:14', 100.00, 150.00, 12),
(331, 'اضافه لحوم او فراخ', 'S00000331', 150, 235, '2025-11-13 16:14:27', '2025-11-13 16:14:27', 100.00, 150.00, 2),
(333, 'عبوة', 'S00000333', 150, 238, '2025-11-22 19:29:51', '2025-11-22 19:29:51', 100.00, 150.00, 15),
(334, 'عبوة', 'S00000334', 150, 237, '2025-11-22 19:30:18', '2025-11-22 19:30:18', 100.00, 150.00, 9),
(336, 'عبوة', 'S00000336', 150, 240, '2025-11-22 19:32:06', '2025-11-22 19:32:06', 100.00, 150.00, 19),
(338, 'عبوة', 'S00000338', 150, 243, '2025-11-22 19:32:45', '2025-11-22 19:32:45', 100.00, 150.00, 10),
(339, 'عبوة', 'S00000339', 150, 244, '2025-11-22 19:33:24', '2025-11-22 19:33:24', 100.00, 150.00, 9),
(340, 'عبوة', 'S00000340', 150, 246, '2025-11-22 19:33:47', '2025-11-22 19:33:47', 100.00, 150.00, 14),
(341, 'عبوة', 'S00000341', 150, 248, '2025-11-22 19:34:02', '2025-11-22 19:34:02', 100.00, 150.00, 4),
(342, 'عبوة', 'S00000342', 150, 250, '2025-11-22 19:34:25', '2025-11-22 19:34:25', 100.00, 150.00, 17),
(343, 'عبوة', 'S00000343', 150, 252, '2025-11-22 19:34:38', '2025-11-22 19:34:38', 100.00, 150.00, 12),
(344, 'عبوة', 'S00000344', 150, 254, '2025-11-22 19:34:58', '2025-11-22 19:34:58', 100.00, 150.00, 10),
(345, 'عبوة', 'S00000345', 150, 256, '2025-11-22 19:35:13', '2025-11-22 19:35:13', 100.00, 150.00, 14),
(346, 'عبوة', 'S00000346', 150, 258, '2025-11-22 19:35:28', '2025-11-22 19:35:28', 100.00, 150.00, 19),
(347, 'عبوة', 'S00000347', 150, 260, '2025-11-22 19:35:41', '2025-11-22 19:35:41', 100.00, 150.00, 13),
(348, 'عبوة', 'S00000348', 150, 262, '2025-11-22 19:35:54', '2025-11-22 19:35:54', 100.00, 150.00, 5),
(349, 'عبوة', 'S00000349', 150, 265, '2025-11-22 19:36:06', '2025-11-22 19:36:06', 100.00, 150.00, 8),
(350, 'عبوة', 'S00000350', 150, 266, '2025-11-22 19:36:20', '2025-11-22 19:36:20', 100.00, 150.00, 5),
(351, 'عبوة', 'S00000351', 150, 269, '2025-11-22 19:36:34', '2025-11-22 19:36:34', 100.00, 150.00, 20),
(352, 'عبوة', 'S00000352', 150, 270, '2025-11-22 19:36:53', '2025-11-22 19:36:53', 100.00, 150.00, 6),
(353, 'صغير', 'S00000353', 150, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20', 100.00, 150.00, 9),
(354, 'وسط', 'S00000354', 150, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20', 100.00, 150.00, 7),
(355, 'كبير', 'S00000355', 150, 277, '2025-12-04 19:51:20', '2025-12-04 19:51:20', 100.00, 150.00, 8),
(356, 'صغير', 'S00000356', 150, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25', 100.00, 150.00, 20),
(357, 'وسط', 'S00000357', 150, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25', 100.00, 150.00, 12),
(358, 'كبير', 'S00000358', 150, 278, '2025-12-04 19:52:25', '2025-12-04 19:52:25', 100.00, 150.00, 3),
(359, 'صغير', 'S00000359', 150, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02', 100.00, 150.00, 16),
(360, 'وسط', 'S00000360', 150, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02', 100.00, 150.00, 11),
(361, 'كبير', 'S00000361', 150, 279, '2025-12-04 19:54:02', '2025-12-04 19:54:02', 100.00, 150.00, 6),
(362, 'صغير', 'S00000362', 150, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50', 100.00, 150.00, 15),
(363, 'وسط', 'S00000363', 150, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50', 100.00, 150.00, 19),
(364, 'كبير', 'S00000364', 150, 280, '2025-12-04 19:54:50', '2025-12-04 19:54:50', 100.00, 150.00, 7),
(365, 'صغير', 'S00000365', 150, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41', 100.00, 150.00, 17),
(366, 'وسط', 'S00000366', 150, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41', 100.00, 150.00, 7),
(367, 'كبير', 'S00000367', 150, 281, '2025-12-04 19:55:41', '2025-12-04 19:55:41', 100.00, 150.00, 20),
(368, 'صغير', 'S00000368', 150, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32', 100.00, 150.00, 2),
(369, 'وسط', 'S00000369', 150, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32', 100.00, 150.00, 7),
(370, 'كبير', 'S00000370', 150, 282, '2025-12-04 20:01:32', '2025-12-04 20:01:32', 100.00, 150.00, 8),
(371, 'صغير', 'S00000371', 150, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21', 100.00, 150.00, 18),
(372, 'وسط', 'S00000372', 150, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21', 100.00, 150.00, 6),
(373, 'كبير', 'S00000373', 150, 283, '2025-12-04 20:02:21', '2025-12-04 20:02:21', 100.00, 150.00, 14),
(374, 'صغير', 'S00000374', 150, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39', 100.00, 150.00, 14),
(375, 'وسط', 'S00000375', 150, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39', 100.00, 150.00, 8),
(376, 'كبير', 'S00000376', 150, 284, '2025-12-04 20:04:39', '2025-12-04 20:04:39', 100.00, 150.00, 17),
(377, 'صغير', 'S00000377', 150, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48', 100.00, 150.00, 18),
(378, 'وسط', 'S00000378', 150, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48', 100.00, 150.00, 2),
(379, 'كبير', 'S00000379', 150, 285, '2025-12-04 20:05:48', '2025-12-04 20:05:48', 100.00, 150.00, 14),
(383, 'صغير', 'S00000383', 150, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56', 100.00, 150.00, 2),
(384, 'وسط', 'S00000384', 150, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56', 100.00, 150.00, 8),
(385, 'كبير', 'S00000385', 150, 287, '2025-12-04 20:13:56', '2025-12-04 20:13:56', 100.00, 150.00, 14),
(386, 'صغير', 'S00000386', 150, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45', 100.00, 150.00, 5),
(387, 'وسط', 'S00000387', 150, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45', 100.00, 150.00, 1),
(388, 'كبير', 'S00000388', 150, 288, '2025-12-04 20:14:45', '2025-12-04 20:14:45', 100.00, 150.00, 12),
(389, 'صغير', 'S00000389', 150, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33', 100.00, 150.00, 16),
(390, 'وسط', 'S00000390', 150, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33', 100.00, 150.00, 4),
(391, 'كبير', 'S00000391', 150, 289, '2025-12-04 20:15:33', '2025-12-04 20:15:33', 100.00, 150.00, 11),
(392, 'صغير', 'S00000392', 150, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40', 100.00, 150.00, 4),
(393, 'وسط', 'S00000393', 150, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40', 100.00, 150.00, 4),
(394, 'كبير', 'S00000394', 150, 290, '2025-12-04 20:16:40', '2025-12-04 20:16:40', 100.00, 150.00, 9),
(395, 'صغير', 'S00000395', 150, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18', 100.00, 150.00, 11),
(396, 'وسط', 'S00000396', 150, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18', 100.00, 150.00, 8),
(397, 'كبير', 'S00000397', 150, 291, '2025-12-04 20:18:18', '2025-12-04 20:18:18', 100.00, 150.00, 9),
(398, '١٥ ملي', 'S00000398', 150, 292, '2025-12-04 20:23:44', '2025-12-04 20:23:44', 100.00, 150.00, 17),
(399, 'صغير', 'S00000399', 150, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49', 100.00, 150.00, 19),
(400, 'وسط', 'S00000400', 150, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49', 100.00, 150.00, 1),
(401, 'كبير', 'S00000401', 150, 293, '2025-12-04 20:24:49', '2025-12-04 20:24:49', 100.00, 150.00, 10),
(402, 'صغير', 'S00000402', 150, 294, '2025-12-04 20:25:31', '2025-12-04 20:25:31', 100.00, 150.00, 7),
(403, 'وسط', 'S00000403', 150, 294, '2025-12-04 20:25:31', '2025-12-04 20:25:31', 100.00, 150.00, 3),
(404, 'كبير', 'S00000404', 150, 294, '2025-12-04 20:25:31', '2025-12-04 20:25:31', 100.00, 150.00, 12),
(405, 'عبوه', 'S00000405', 150, 295, '2025-12-04 20:26:42', '2025-12-04 20:26:42', 100.00, 150.00, 12),
(406, 'عبوه', 'S00000406', 150, 296, '2025-12-04 20:27:41', '2025-12-04 20:27:41', 100.00, 150.00, 4),
(407, 'عبوه', 'S00000407', 150, 297, '2025-12-04 20:28:18', '2025-12-04 20:28:18', 100.00, 150.00, 4),
(410, 'سنجل', 'S00000410', 150, 299, '2025-12-08 17:52:14', '2025-12-08 17:52:14', 100.00, 150.00, 9),
(411, 'دبل', 'S00000411', 150, 299, '2025-12-08 17:52:14', '2025-12-08 17:52:14', 100.00, 150.00, 9),
(416, 'سنجل', 'S00000416', 150, 300, '2025-12-08 17:58:56', '2025-12-08 17:58:56', 100.00, 150.00, 18),
(417, 'دبل', 'S00000417', 150, 300, '2025-12-08 17:58:56', '2025-12-08 17:58:56', 100.00, 150.00, 5),
(420, 'دبل', 'S00000420', 150, 303, '2025-12-08 18:11:54', '2025-12-08 18:11:54', 100.00, 150.00, 8),
(427, 'سنجل', 'S00000427', 150, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19', 100.00, 150.00, 3),
(428, 'دبل', 'S00000428', 150, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19', 100.00, 150.00, 13),
(429, 'تربل', 'S00000429', 150, 306, '2025-12-08 18:18:19', '2025-12-08 18:18:19', 100.00, 150.00, 17),
(436, 'سنجل', 'S00000436', 150, 309, '2025-12-08 18:27:35', '2025-12-08 18:27:35', 100.00, 150.00, 2),
(437, 'دبل', 'S00000437', 150, 309, '2025-12-08 18:27:35', '2025-12-08 18:27:35', 100.00, 150.00, 1),
(438, 'سنجل', 'S00000438', 150, 310, '2025-12-08 18:29:05', '2025-12-08 18:29:05', 100.00, 150.00, 16),
(439, 'دبل', 'S00000439', 150, 310, '2025-12-08 18:29:05', '2025-12-08 18:29:05', 100.00, 150.00, 19),
(440, 'سنجل', 'S00000440', 150, 311, '2025-12-08 18:30:41', '2025-12-08 18:30:41', 100.00, 150.00, 7),
(441, 'دبل', 'S00000441', 150, 311, '2025-12-08 18:30:41', '2025-12-08 18:30:41', 100.00, 150.00, 18),
(444, 'سنجل', 'S00000444', 150, 313, '2025-12-08 18:36:33', '2025-12-08 18:36:33', 100.00, 150.00, 6),
(445, 'دبل', 'S00000445', 150, 313, '2025-12-08 18:36:33', '2025-12-08 18:36:33', 100.00, 150.00, 18),
(446, 'سنجل', 'S00000446', 150, 314, '2025-12-08 18:46:43', '2025-12-08 18:46:43', 100.00, 150.00, 12),
(447, 'دبل', 'S00000447', 150, 314, '2025-12-08 18:46:43', '2025-12-08 18:46:43', 100.00, 150.00, 6),
(448, 'سنجل', 'S00000448', 150, 315, '2025-12-08 18:55:45', '2025-12-08 18:55:45', 100.00, 150.00, 14),
(449, 'دبل', 'S00000449', 150, 315, '2025-12-08 18:55:45', '2025-12-08 18:55:45', 100.00, 150.00, 10),
(450, 'حجم صغير', 'S00000450', 150, 316, '2025-12-08 18:58:39', '2025-12-08 18:58:39', 100.00, 150.00, 7),
(451, 'حجم كبير', 'S00000451', 150, 316, '2025-12-08 18:58:39', '2025-12-08 18:58:39', 100.00, 150.00, 6),
(452, 'حجم صغير', 'S00000452', 150, 317, '2025-12-08 19:00:13', '2025-12-08 19:00:13', 100.00, 150.00, 7),
(453, 'حجم كبير', 'S00000453', 150, 317, '2025-12-08 19:00:13', '2025-12-08 19:00:13', 100.00, 150.00, 17),
(454, 'كبير', 'S00000454', 150, 318, '2025-12-08 19:02:09', '2025-12-08 19:02:09', 100.00, 150.00, 4),
(455, 'كبير', 'S00000455', 150, 319, '2025-12-08 19:03:40', '2025-12-08 19:03:40', 100.00, 150.00, 10),
(457, 'كبير', 'S00000457', 150, 321, '2025-12-08 19:08:53', '2025-12-08 19:08:53', 100.00, 150.00, 15),
(458, 'كبير', 'S00000458', 150, 322, '2025-12-08 19:10:28', '2025-12-08 19:10:28', 100.00, 150.00, 5),
(459, 'كبير', 'S00000459', 150, 323, '2025-12-08 19:11:59', '2025-12-08 19:11:59', 100.00, 150.00, 19),
(460, 'كبير', 'S00000460', 150, 324, '2025-12-08 19:13:18', '2025-12-08 19:13:18', 100.00, 150.00, 18),
(490, 'وسط', 'S00000490', 150, 337, '2025-12-08 20:22:53', '2025-12-08 20:22:53', 100.00, 150.00, 15),
(492, 'كبير', 'S00000492', 150, 339, '2025-12-08 20:26:36', '2025-12-08 20:26:36', 100.00, 150.00, 18),
(496, 'طبق', 'S00000496', 150, 343, '2025-12-08 20:33:42', '2025-12-08 20:33:42', 100.00, 150.00, 4),
(497, 'طبق', 'S00000497', 150, 344, '2025-12-08 20:34:56', '2025-12-08 20:34:56', 100.00, 150.00, 8),
(498, 'طبق', 'S00000498', 150, 345, '2025-12-08 20:37:25', '2025-12-08 20:37:25', 100.00, 150.00, 8),
(499, 'طبق', 'S00000499', 150, 346, '2025-12-08 20:38:29', '2025-12-08 20:38:29', 100.00, 150.00, 14),
(500, 'طبق', 'S00000500', 150, 347, '2025-12-08 20:39:45', '2025-12-08 20:39:45', 100.00, 150.00, 6),
(501, 'طبق', 'S00000501', 150, 348, '2025-12-08 20:41:14', '2025-12-08 20:41:14', 100.00, 150.00, 6),
(502, 'طبق', 'S00000502', 150, 349, '2025-12-08 20:42:44', '2025-12-08 20:42:44', 100.00, 150.00, 11),
(503, 'طبق', 'S00000503', 150, 350, '2025-12-08 20:43:49', '2025-12-08 20:43:49', 100.00, 150.00, 17),
(504, 'طبق', 'S00000504', 150, 351, '2025-12-08 20:45:14', '2025-12-08 20:45:14', 100.00, 150.00, 13),
(508, 'وجبة', 'S00000508', 150, 355, '2025-12-08 21:08:19', '2025-12-08 21:08:19', 100.00, 150.00, 13),
(509, 'سوري', 'S00000509', 150, 381, '2025-12-09 13:29:03', '2025-12-09 13:29:03', 100.00, 150.00, 4),
(510, 'فرنساوي', 'S00000510', 150, 381, '2025-12-09 13:29:03', '2025-12-09 13:29:03', 100.00, 150.00, 1),
(511, 'سوري', 'S00000511', 150, 382, '2025-12-09 13:31:31', '2025-12-09 13:31:31', 100.00, 150.00, 14),
(512, 'فرنساوي', 'S00000512', 150, 382, '2025-12-09 13:31:31', '2025-12-09 13:31:31', 100.00, 150.00, 8),
(513, 'سوري', 'S00000513', 150, 383, '2025-12-09 13:36:47', '2025-12-09 13:36:47', 100.00, 150.00, 14),
(514, 'فرنساوي', 'S00000514', 150, 383, '2025-12-09 13:36:47', '2025-12-09 13:36:47', 100.00, 150.00, 8),
(515, 'سوري', 'S00000515', 150, 384, '2025-12-09 13:38:46', '2025-12-09 13:38:46', 100.00, 150.00, 15),
(516, 'فرنساوي', 'S00000516', 150, 384, '2025-12-09 13:38:46', '2025-12-09 13:38:46', 100.00, 150.00, 11),
(517, 'سوري', 'S00000517', 150, 385, '2025-12-09 13:39:53', '2025-12-09 13:39:53', 100.00, 150.00, 8),
(518, 'فرنساوي', 'S00000518', 150, 385, '2025-12-09 13:39:53', '2025-12-09 13:39:53', 100.00, 150.00, 9),
(519, 'سوري', 'S00000519', 150, 386, '2025-12-09 13:41:50', '2025-12-09 13:41:50', 100.00, 150.00, 20),
(520, 'فرنساوي', 'S00000520', 150, 386, '2025-12-09 13:41:50', '2025-12-09 13:41:50', 100.00, 150.00, 11),
(521, 'سوري', 'S00000521', 150, 387, '2025-12-09 13:44:28', '2025-12-09 13:44:28', 100.00, 150.00, 16),
(522, 'فرنساوي', 'S00000522', 150, 387, '2025-12-09 13:44:28', '2025-12-09 13:44:28', 100.00, 150.00, 8),
(523, 'سوري', 'S00000523', 150, 388, '2025-12-09 13:46:12', '2025-12-09 13:46:12', 100.00, 150.00, 9),
(524, 'فرنساوي', 'S00000524', 150, 388, '2025-12-09 13:46:12', '2025-12-09 13:46:12', 100.00, 150.00, 3),
(525, 'سوري', 'S00000525', 150, 389, '2025-12-09 13:52:16', '2025-12-09 13:52:16', 100.00, 150.00, 6),
(526, 'فرنساوي', 'S00000526', 150, 389, '2025-12-09 13:52:16', '2025-12-09 13:52:16', 100.00, 150.00, 19),
(527, 'سوري', 'S00000527', 150, 390, '2025-12-09 13:53:37', '2025-12-09 13:53:37', 100.00, 150.00, 17),
(528, 'فرنساوي', 'S00000528', 150, 390, '2025-12-09 13:53:37', '2025-12-09 13:53:37', 100.00, 150.00, 9),
(529, 'سوري', 'S00000529', 150, 391, '2025-12-09 13:54:38', '2025-12-09 13:54:38', 100.00, 150.00, 14),
(530, 'فرنساوي', 'S00000530', 150, 391, '2025-12-09 13:54:38', '2025-12-09 13:54:38', 100.00, 150.00, 20),
(531, 'وجبه', 'S00000531', 150, 392, '2025-12-09 13:56:51', '2025-12-09 13:56:51', 100.00, 150.00, 17),
(537, 'وجبه', 'S00000537', 150, 398, '2025-12-09 14:12:27', '2025-12-09 14:12:27', 100.00, 150.00, 8),
(538, 'وجبه', 'S00000538', 150, 396, '2025-12-09 14:12:47', '2025-12-09 14:12:47', 100.00, 150.00, 5),
(539, 'وجبه', 'S00000539', 150, 393, '2025-12-09 14:13:12', '2025-12-09 14:13:12', 100.00, 150.00, 1),
(540, 'وجبه', 'S00000540', 150, 394, '2025-12-09 14:13:21', '2025-12-09 14:13:21', 100.00, 150.00, 9),
(541, 'وجبه', 'S00000541', 150, 395, '2025-12-09 14:13:29', '2025-12-09 14:13:29', 100.00, 150.00, 4),
(542, 'وجبه', 'S00000542', 150, 397, '2025-12-09 14:13:39', '2025-12-09 14:13:39', 100.00, 150.00, 13),
(543, 'فراخ', 'S00000543', 150, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22', 100.00, 150.00, 10),
(544, 'لحمه', 'S00000544', 150, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22', 100.00, 150.00, 13),
(545, 'مكس', 'S00000545', 150, 399, '2025-12-09 14:17:22', '2025-12-09 14:17:22', 100.00, 150.00, 14),
(546, 'فراخ', 'S00000546', 150, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33', 100.00, 150.00, 11),
(547, 'لحمه', 'S00000547', 150, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33', 100.00, 150.00, 13),
(548, 'مكس', 'S00000548', 150, 400, '2025-12-09 14:18:33', '2025-12-09 14:18:33', 100.00, 150.00, 9),
(549, 'فراخ', 'S00000549', 150, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58', 100.00, 150.00, 7),
(550, 'لحمه', 'S00000550', 150, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58', 100.00, 150.00, 9),
(551, 'مكس', 'S00000551', 150, 401, '2025-12-09 14:19:58', '2025-12-09 14:19:58', 100.00, 150.00, 2),
(552, 'فراخ', 'S00000552', 150, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19', 100.00, 150.00, 5),
(553, 'لحمه', 'S00000553', 150, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19', 100.00, 150.00, 15),
(554, 'مكس', 'S00000554', 150, 402, '2025-12-09 14:21:19', '2025-12-09 14:21:19', 100.00, 150.00, 20),
(555, 'فراخ', 'S00000555', 150, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16', 100.00, 150.00, 16),
(556, 'لحمه', 'S00000556', 150, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16', 100.00, 150.00, 19),
(557, 'مكس', 'S00000557', 150, 403, '2025-12-09 14:23:16', '2025-12-09 14:23:16', 100.00, 150.00, 7),
(558, 'فراخ', 'S00000558', 150, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06', 100.00, 150.00, 16),
(559, 'لحمه', 'S00000559', 150, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06', 100.00, 150.00, 17),
(560, 'مكس', 'S00000560', 150, 404, '2025-12-09 14:25:06', '2025-12-09 14:25:06', 100.00, 150.00, 19),
(561, 'فراخ', 'S00000561', 150, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49', 100.00, 150.00, 1),
(562, 'لحمه', 'S00000562', 150, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49', 100.00, 150.00, 8),
(563, 'مكس', 'S00000563', 150, 405, '2025-12-09 14:26:49', '2025-12-09 14:26:49', 100.00, 150.00, 18),
(564, 'وجبه', 'S00000564', 150, 406, '2025-12-09 14:29:53', '2025-12-09 14:29:53', 100.00, 150.00, 5),
(565, 'وجبه', 'S00000565', 150, 407, '2025-12-09 14:30:56', '2025-12-09 14:30:56', 100.00, 150.00, 9),
(566, 'وجبه', 'S00000566', 150, 408, '2025-12-09 14:33:26', '2025-12-09 14:33:26', 100.00, 150.00, 11),
(567, 'وجبه', 'S00000567', 150, 409, '2025-12-09 14:35:57', '2025-12-09 14:35:57', 100.00, 150.00, 5),
(568, 'وجبه', 'S00000568', 150, 410, '2025-12-09 14:38:10', '2025-12-09 14:38:10', 100.00, 150.00, 15),
(569, 'طبق', 'S00000569', 150, 411, '2025-12-09 14:39:59', '2025-12-09 14:39:59', 100.00, 150.00, 17),
(570, 'طبق', 'S00000570', 150, 412, '2025-12-09 14:42:22', '2025-12-09 14:42:22', 100.00, 150.00, 20),
(571, 'طبق', 'S00000571', 150, 413, '2025-12-09 14:43:22', '2025-12-09 14:43:22', 100.00, 150.00, 9),
(572, 'طبق', 'S00000572', 150, 414, '2025-12-09 14:44:48', '2025-12-09 14:44:48', 100.00, 150.00, 6),
(573, 'طبق', 'S00000573', 150, 415, '2025-12-09 14:45:42', '2025-12-09 14:45:42', 100.00, 150.00, 3),
(574, 'طبق', 'S00000574', 150, 416, '2025-12-09 14:47:44', '2025-12-09 14:47:44', 100.00, 150.00, 15),
(575, 'طبق', 'S00000575', 150, 417, '2025-12-09 14:49:21', '2025-12-09 14:49:21', 100.00, 150.00, 4),
(576, 'طبق', 'S00000576', 150, 418, '2025-12-09 14:50:28', '2025-12-09 14:50:28', 100.00, 150.00, 16),
(577, 'طبق', 'S00000577', 150, 419, '2025-12-09 14:51:45', '2025-12-09 14:51:45', 100.00, 150.00, 7),
(578, 'طبق', 'S00000578', 150, 420, '2025-12-09 14:52:27', '2025-12-09 14:52:27', 100.00, 150.00, 7),
(579, 'عيش', 'S00000579', 150, 421, '2025-12-09 14:53:52', '2025-12-09 14:53:52', 100.00, 150.00, 12),
(580, 'وجبه', 'S00000580', 150, 422, '2025-12-09 14:57:07', '2025-12-09 14:57:07', 100.00, 150.00, 19),
(581, 'وجبه', 'S00000581', 150, 422, '2025-12-09 14:57:07', '2025-12-09 14:57:07', 100.00, 150.00, 1),
(582, 'وجبه', 'S00000582', 150, 423, '2025-12-09 14:58:30', '2025-12-09 14:58:30', 100.00, 150.00, 6),
(583, 'وجبه', 'S00000583', 150, 424, '2025-12-09 15:00:13', '2025-12-09 15:00:13', 100.00, 150.00, 5),
(584, 'وجبه', 'S00000584', 150, 425, '2025-12-09 15:02:27', '2025-12-09 15:02:27', 100.00, 150.00, 7),
(585, 'وجبه', 'S00000585', 150, 426, '2025-12-09 15:03:50', '2025-12-09 15:03:50', 100.00, 150.00, 19),
(586, 'وجبه', 'S00000586', 150, 427, '2025-12-09 15:06:40', '2025-12-09 15:06:40', 100.00, 150.00, 13),
(587, 'وجبه', 'S00000587', 150, 428, '2025-12-09 15:07:16', '2025-12-09 15:07:16', 100.00, 150.00, 10),
(588, 'علبه', 'S00000588', 150, 429, '2025-12-09 16:08:31', '2025-12-09 16:08:31', 100.00, 150.00, 9),
(589, 'علبه', 'S00000589', 150, 430, '2025-12-09 16:11:23', '2025-12-09 16:11:23', 100.00, 150.00, 13),
(590, 'علبه', 'S00000590', 150, 431, '2025-12-09 16:13:12', '2025-12-09 16:13:12', 100.00, 150.00, 18),
(591, 'علبه', 'S00000591', 150, 432, '2025-12-09 16:14:47', '2025-12-09 16:14:47', 100.00, 150.00, 10),
(592, 'علبه', 'S00000592', 150, 433, '2025-12-09 16:19:28', '2025-12-09 16:19:28', 100.00, 150.00, 17),
(593, 'علبه', 'S00000593', 150, 434, '2025-12-09 16:20:43', '2025-12-09 16:20:43', 100.00, 150.00, 15),
(594, 'علبه', 'S00000594', 150, 435, '2025-12-09 16:21:58', '2025-12-09 16:21:58', 100.00, 150.00, 4),
(595, 'علبه', 'S00000595', 150, 436, '2025-12-09 16:23:40', '2025-12-09 16:23:40', 100.00, 150.00, 13),
(596, 'علبه', 'S00000596', 150, 437, '2025-12-09 16:25:28', '2025-12-09 16:25:28', 100.00, 150.00, 11),
(597, 'علبه', 'S00000597', 150, 438, '2025-12-09 16:27:31', '2025-12-09 16:27:31', 100.00, 150.00, 17),
(598, 'علب', 'S00000598', 150, 439, '2025-12-09 16:31:53', '2025-12-09 16:31:53', 100.00, 150.00, 12),
(599, 'علبه', 'S00000599', 150, 440, '2025-12-09 16:34:13', '2025-12-09 16:34:13', 100.00, 150.00, 6),
(600, 'علبه', 'S00000600', 150, 441, '2025-12-09 16:35:50', '2025-12-09 16:35:50', 100.00, 150.00, 16),
(601, 'علبه', 'S00000601', 150, 442, '2025-12-09 16:37:25', '2025-12-09 16:37:25', 100.00, 150.00, 2),
(602, 'علبه', 'S00000602', 150, 443, '2025-12-09 16:38:37', '2025-12-09 16:38:37', 100.00, 150.00, 20),
(603, 'علبه', 'S00000603', 150, 444, '2025-12-09 16:40:43', '2025-12-09 16:40:43', 100.00, 150.00, 13),
(604, 'علبه', 'S00000604', 150, 445, '2025-12-09 16:44:07', '2025-12-09 16:44:07', 100.00, 150.00, 6),
(605, 'علبه', 'S00000605', 150, 446, '2025-12-09 16:45:18', '2025-12-09 16:45:18', 100.00, 150.00, 11);
INSERT INTO `product_sizes` (`id`, `size`, `barcode`, `price`, `product_id`, `created_at`, `updated_at`, `Purchase_price`, `selling_price`, `quantity`) VALUES
(606, 'علبه', 'S00000606', 150, 447, '2025-12-09 16:50:46', '2025-12-09 16:50:46', 100.00, 150.00, 15),
(607, 'علبه', 'S00000607', 150, 448, '2025-12-09 16:52:27', '2025-12-09 16:52:27', 100.00, 150.00, 2),
(608, 'علبه', 'S00000608', 150, 449, '2025-12-09 16:53:24', '2025-12-09 16:53:24', 100.00, 150.00, 6),
(609, 'نظاره', 'S00000609', 150, 450, '2025-12-09 17:16:13', '2025-12-09 17:16:13', 100.00, 150.00, 2),
(610, 'نظاره', 'S00000610', 150, 451, '2025-12-09 17:17:15', '2025-12-09 17:17:15', 100.00, 150.00, 14),
(611, 'نظاره', 'S00000611', 150, 452, '2025-12-09 17:17:57', '2025-12-09 17:17:57', 100.00, 150.00, 1),
(612, 'نظاره', 'S00000612', 150, 453, '2025-12-09 17:18:54', '2025-12-09 17:18:54', 100.00, 150.00, 3),
(613, 'نظاره', 'S00000613', 150, 454, '2025-12-09 17:19:44', '2025-12-09 17:19:44', 100.00, 150.00, 9),
(614, 'نظاره', 'S00000614', 150, 455, '2025-12-09 17:20:22', '2025-12-09 17:20:22', 100.00, 150.00, 19),
(615, 'نظاره', 'S00000615', 150, 456, '2025-12-09 17:21:02', '2025-12-09 17:21:02', 100.00, 150.00, 8),
(616, 'نظاره', 'S00000616', 150, 457, '2025-12-09 17:21:50', '2025-12-09 17:21:50', 100.00, 150.00, 3),
(617, 'نظاره', 'S00000617', 150, 458, '2025-12-09 17:22:26', '2025-12-09 17:22:26', 100.00, 150.00, 8),
(618, 'نظاره', 'S00000618', 150, 459, '2025-12-09 17:23:07', '2025-12-09 17:23:07', 100.00, 150.00, 10),
(619, 'نظاره', 'S00000619', 150, 460, '2025-12-09 17:23:47', '2025-12-09 17:23:47', 100.00, 150.00, 5),
(620, 'نظاره', 'S00000620', 150, 461, '2025-12-09 17:24:35', '2025-12-09 17:24:35', 100.00, 150.00, 13),
(621, 'نظاره', 'S00000621', 150, 462, '2025-12-09 17:25:08', '2025-12-09 17:25:08', 100.00, 150.00, 13),
(622, 'علبه', 'S00000622', 150, 463, '2025-12-09 17:25:58', '2025-12-09 17:25:58', 100.00, 150.00, 5),
(623, 'علبه', 'S00000623', 150, 464, '2025-12-10 15:37:48', '2025-12-10 15:37:48', 100.00, 150.00, 4),
(624, 'علبه', 'S00000624', 150, 465, '2025-12-10 15:38:42', '2025-12-10 15:38:42', 100.00, 150.00, 3),
(625, 'علبه', 'S00000625', 150, 466, '2025-12-10 15:39:48', '2025-12-10 15:39:48', 100.00, 150.00, 6),
(626, 'علبه', 'S00000626', 150, 467, '2025-12-10 15:42:20', '2025-12-10 15:42:20', 100.00, 150.00, 18),
(627, 'علبه', 'S00000627', 150, 468, '2025-12-10 15:43:26', '2025-12-10 15:43:26', 100.00, 150.00, 11),
(628, 'علبه', 'S00000628', 150, 469, '2025-12-10 15:44:30', '2025-12-10 15:44:30', 100.00, 150.00, 3),
(629, 'علبه', 'S00000629', 150, 470, '2025-12-10 15:45:29', '2025-12-10 15:45:29', 100.00, 150.00, 2),
(630, 'علبه', 'S00000630', 150, 471, '2025-12-10 15:46:45', '2025-12-10 15:46:45', 100.00, 150.00, 20),
(631, 'علبه', 'S00000631', 150, 472, '2025-12-10 15:47:37', '2025-12-10 15:47:37', 100.00, 150.00, 12),
(632, 'علبه', 'S00000632', 150, 473, '2025-12-10 15:48:42', '2025-12-10 15:48:42', 100.00, 150.00, 2),
(633, 'علبه', 'S00000633', 150, 474, '2025-12-10 15:49:33', '2025-12-10 15:49:33', 100.00, 150.00, 12),
(634, 'علبه', 'S00000634', 150, 475, '2025-12-10 15:50:27', '2025-12-10 15:50:27', 100.00, 150.00, 12),
(635, 'علبه', 'S00000635', 150, 476, '2025-12-10 15:58:49', '2025-12-10 15:58:49', 100.00, 150.00, 5),
(636, 'علبه', 'S00000636', 150, 477, '2025-12-10 16:00:46', '2025-12-10 16:00:46', 100.00, 150.00, 9),
(637, 'علبه', 'S00000637', 150, 478, '2025-12-10 16:02:51', '2025-12-10 16:02:51', 100.00, 150.00, 10),
(638, 'علبه', 'S00000638', 150, 479, '2025-12-10 16:04:06', '2025-12-10 16:04:06', 100.00, 150.00, 2),
(639, 'علبه', 'S00000639', 150, 480, '2025-12-10 16:05:15', '2025-12-10 16:05:15', 100.00, 150.00, 19),
(640, 'علبه', 'S00000640', 150, 481, '2025-12-10 16:05:54', '2025-12-10 16:05:54', 100.00, 150.00, 10),
(641, 'علبه', 'S00000641', 150, 482, '2025-12-10 16:06:45', '2025-12-10 16:06:45', 100.00, 150.00, 12),
(642, 'علبه', 'S00000642', 150, 483, '2025-12-10 16:07:44', '2025-12-10 16:07:44', 100.00, 150.00, 9),
(643, 'علبه', 'S00000643', 150, 484, '2025-12-10 16:08:39', '2025-12-10 16:08:39', 100.00, 150.00, 11),
(644, 'علبه', 'S00000644', 150, 485, '2025-12-10 16:09:33', '2025-12-10 16:09:33', 100.00, 150.00, 5),
(645, 'علبه', 'S00000645', 150, 486, '2025-12-10 16:10:47', '2025-12-10 16:10:47', 100.00, 150.00, 11),
(646, 'علبه', 'S00000646', 150, 487, '2025-12-10 16:11:50', '2025-12-10 16:11:50', 100.00, 150.00, 19),
(697, 'قطعة', 'S00000697', 150, 533, '2025-12-13 19:35:43', '2025-12-13 19:35:43', 100.00, 150.00, 2),
(698, 'طبق', 'S00000698', 150, 534, '2025-12-13 19:38:02', '2025-12-13 19:38:02', 100.00, 150.00, 11),
(699, 'طبق', 'S00000699', 150, 535, '2025-12-13 19:39:51', '2025-12-13 19:39:51', 100.00, 150.00, 11),
(700, 'طبق', 'S00000700', 150, 536, '2025-12-13 19:41:43', '2025-12-13 19:41:43', 100.00, 150.00, 19),
(701, 'طبق', 'S00000701', 150, 537, '2025-12-13 19:45:45', '2025-12-13 19:45:45', 100.00, 150.00, 2),
(702, 'طبق', 'S00000702', 150, 538, '2025-12-13 19:47:13', '2025-12-13 19:47:13', 100.00, 150.00, 13),
(703, 'طبق', 'S00000703', 150, 539, '2025-12-13 19:49:31', '2025-12-13 19:49:31', 100.00, 150.00, 20),
(704, 'طبق', 'S00000704', 150, 540, '2025-12-13 19:51:05', '2025-12-13 19:51:05', 100.00, 150.00, 20),
(705, 'طبق', 'S00000705', 150, 541, '2025-12-13 19:52:07', '2025-12-13 19:52:07', 100.00, 150.00, 1),
(706, 'طبق', 'S00000706', 150, 542, '2025-12-13 19:53:04', '2025-12-13 19:53:04', 100.00, 150.00, 3),
(707, 'طبق', 'S00000707', 150, 543, '2025-12-13 19:54:25', '2025-12-13 19:54:25', 100.00, 150.00, 14),
(708, 'طبق', 'S00000708', 150, 544, '2025-12-13 19:56:20', '2025-12-13 19:56:20', 100.00, 150.00, 17),
(709, 'طبق', 'S00000709', 150, 545, '2025-12-13 19:58:19', '2025-12-13 19:58:19', 100.00, 150.00, 3),
(710, 'طبق', 'S00000710', 150, 546, '2025-12-13 20:00:25', '2025-12-13 20:00:25', 100.00, 150.00, 6),
(711, 'طبق', 'S00000711', 150, 547, '2025-12-13 20:02:31', '2025-12-13 20:02:31', 100.00, 150.00, 19),
(712, 'طبق', 'S00000712', 150, 548, '2025-12-13 20:04:17', '2025-12-13 20:04:17', 100.00, 150.00, 18),
(713, 'طبق', 'S00000713', 150, 549, '2025-12-13 20:06:36', '2025-12-13 20:06:36', 100.00, 150.00, 12),
(714, 'طبق', 'S00000714', 150, 550, '2025-12-13 20:07:58', '2025-12-13 20:07:58', 100.00, 150.00, 7),
(715, 'طبق', 'S00000715', 150, 551, '2025-12-13 20:09:24', '2025-12-13 20:09:24', 100.00, 150.00, 19),
(716, 'قزازه', 'S00000716', 150, 552, '2025-12-13 20:12:35', '2025-12-13 20:12:35', 100.00, 150.00, 10),
(717, 'قزازه', 'S00000717', 150, 553, '2025-12-13 20:13:44', '2025-12-13 20:13:44', 100.00, 150.00, 15),
(718, 'قزازه', 'S00000718', 150, 554, '2025-12-13 20:15:26', '2025-12-13 20:15:26', 100.00, 150.00, 3),
(720, 'قطعه', 'S00000720', 150, 555, '2025-12-13 20:18:31', '2025-12-13 20:18:31', 100.00, 150.00, 11),
(721, 'اضافه قطعة', 'S00000721', 150, 556, '2025-12-13 20:19:25', '2025-12-13 20:19:25', 100.00, 150.00, 4),
(722, 'قطعة', 'S00000722', 150, 557, '2025-12-13 20:20:28', '2025-12-13 20:20:28', 100.00, 150.00, 9),
(723, 'قطعه', 'S00000723', 150, 558, '2025-12-13 20:21:35', '2025-12-13 20:21:35', 100.00, 150.00, 11),
(724, 'رغيف', 'S00000724', 150, 559, '2025-12-13 20:22:08', '2025-12-13 20:22:08', 100.00, 150.00, 8),
(727, 'سنجل', 'S00000727', 150, 298, '2025-12-13 22:31:37', '2025-12-13 22:31:37', 100.00, 150.00, 8),
(728, 'دبل', 'S00000728', 150, 298, '2025-12-13 22:31:37', '2025-12-13 22:31:37', 100.00, 150.00, 14),
(729, 'سنجل', 'S00000729', 150, 301, '2025-12-13 22:38:00', '2025-12-13 22:38:00', 100.00, 150.00, 7),
(730, 'دبل', 'S00000730', 150, 301, '2025-12-13 22:38:00', '2025-12-13 22:38:00', 100.00, 150.00, 10),
(731, 'سنجل', 'S00000731', 150, 312, '2025-12-13 23:00:28', '2025-12-13 23:00:28', 100.00, 150.00, 8),
(732, 'دبل', 'S00000732', 150, 312, '2025-12-13 23:00:28', '2025-12-13 23:00:28', 100.00, 150.00, 12),
(764, 'وجبة', 'S00000764', 150, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56', 100.00, 150.00, 14),
(765, 'حار', 'S00000765', 150, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56', 100.00, 150.00, 15),
(766, 'بارد', 'S00000766', 150, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56', 100.00, 150.00, 12),
(767, 'استربس فقط حار وصوص بارد', 'S00000767', 150, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56', 100.00, 150.00, 13),
(768, 'استربس فقط بارد وصوص حار', 'S00000768', 150, 502, '2025-12-14 20:12:56', '2025-12-14 20:12:56', 100.00, 150.00, 8),
(803, 'حار', 'S00000803', 150, 514, '2025-12-14 20:32:17', '2025-12-14 20:32:17', 100.00, 150.00, 3),
(811, 'بارد', 'S00000811', 150, 519, '2025-12-14 20:39:41', '2025-12-14 20:39:41', 100.00, 150.00, 11),
(812, 'حار', 'S00000812', 150, 520, '2025-12-14 20:40:16', '2025-12-14 20:40:16', 100.00, 150.00, 4),
(813, 'بارد', 'S00000813', 150, 520, '2025-12-14 20:40:16', '2025-12-14 20:40:16', 100.00, 150.00, 5),
(814, 'حار', 'S00000814', 150, 521, '2025-12-14 20:40:42', '2025-12-14 20:40:42', 100.00, 150.00, 15),
(815, 'بارد', 'S00000815', 150, 521, '2025-12-14 20:40:42', '2025-12-14 20:40:42', 100.00, 150.00, 20),
(816, 'حار', 'S00000816', 150, 522, '2025-12-14 20:41:05', '2025-12-14 20:41:05', 100.00, 150.00, 16),
(817, 'بارد', 'S00000817', 150, 522, '2025-12-14 20:41:05', '2025-12-14 20:41:05', 100.00, 150.00, 16),
(836, 'سندوتش بصوص حار', 'S00000836', 150, 531, '2025-12-14 20:48:20', '2025-12-14 20:48:20', 100.00, 150.00, 14),
(837, 'سندوتش بصوص بارد', 'S00000837', 150, 531, '2025-12-14 20:48:20', '2025-12-14 20:48:20', 100.00, 150.00, 19),
(838, 'استربس فقط حار مع صوص بارد', 'S00000838', 150, 532, '2025-12-14 20:49:27', '2025-12-14 20:49:27', 100.00, 150.00, 14),
(839, 'استربس فقط بارد مع صوص حار', 'S00000839', 150, 532, '2025-12-14 20:49:27', '2025-12-14 20:49:27', 100.00, 150.00, 10),
(845, 'سنجل', 'S00000845', 150, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02', 100.00, 150.00, 11),
(846, 'دبل', 'S00000846', 150, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02', 100.00, 150.00, 4),
(847, 'تربل', 'S00000847', 150, 304, '2025-12-15 12:44:02', '2025-12-15 12:44:02', 100.00, 150.00, 4),
(854, 'سنجل', 'S00000854', 150, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31', 100.00, 150.00, 9),
(855, 'دبل', 'S00000855', 150, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31', 100.00, 150.00, 12),
(856, 'تربل', 'S00000856', 150, 307, '2025-12-15 12:45:31', '2025-12-15 12:45:31', 100.00, 150.00, 13),
(857, 'سنجل', 'S00000857', 150, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00', 100.00, 150.00, 9),
(858, 'دبل', 'S00000858', 150, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00', 100.00, 150.00, 4),
(859, 'تربل', 'S00000859', 150, 308, '2025-12-15 12:46:00', '2025-12-15 12:46:00', 100.00, 150.00, 12),
(860, 'سنجل', 'S00000860', 150, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20', 100.00, 150.00, 9),
(861, 'دبل', 'S00000861', 150, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20', 100.00, 150.00, 9),
(862, 'تربل', 'S00000862', 150, 305, '2025-12-15 12:47:20', '2025-12-15 12:47:20', 100.00, 150.00, 16),
(863, 'سنجل', 'S00000863', 150, 302, '2025-12-15 13:30:46', '2025-12-15 13:30:46', 100.00, 150.00, 15),
(864, 'دبل', 'S00000864', 150, 302, '2025-12-15 13:30:46', '2025-12-15 13:30:46', 100.00, 150.00, 3),
(865, 'كبير', 'S00000865', 150, 320, '2025-12-15 15:12:01', '2025-12-15 15:12:01', 100.00, 150.00, 12),
(868, 'بالته 40 علبه', 'S00000868', 150, 488, '2025-12-15 16:06:39', '2025-12-15 16:06:39', 100.00, 150.00, 10),
(870, 'بالته 40 علبه', 'S00000870', 150, 489, '2025-12-15 16:08:44', '2025-12-15 16:08:44', 100.00, 150.00, 15),
(871, 'بالته 18 علبه', 'S00000871', 150, 560, '2025-12-15 16:13:03', '2025-12-15 16:13:03', 100.00, 150.00, 2),
(872, 'بالته 4 كيلو', 'S00000872', 150, 490, '2025-12-15 16:14:55', '2025-12-15 16:14:55', 100.00, 150.00, 7),
(873, 'بالته 5 كيلو', 'S00000873', 150, 490, '2025-12-15 16:14:55', '2025-12-15 16:14:55', 100.00, 150.00, 8),
(875, 'بالته 5 كيلو', 'S00000875', 150, 492, '2025-12-15 16:16:58', '2025-12-15 16:16:58', 100.00, 150.00, 20),
(876, '2000 منديل', 'S00000876', 150, 491, '2025-12-15 16:17:36', '2025-12-15 16:17:36', 100.00, 150.00, 13),
(877, 'بالته 18 علبه', 'S00000877', 150, 493, '2025-12-15 16:19:59', '2025-12-15 16:19:59', 100.00, 150.00, 6),
(878, 'بالته 24 علبه', 'S00000878', 150, 494, '2025-12-15 16:20:33', '2025-12-15 16:20:33', 100.00, 150.00, 12),
(880, 'بالته 18 علبه', 'S00000880', 150, 495, '2025-12-15 16:21:45', '2025-12-15 16:21:45', 100.00, 150.00, 1),
(881, 'ربع كيلو', 'S00000881', 150, 561, '2025-12-15 18:09:46', '2025-12-15 18:09:46', 100.00, 150.00, 7),
(882, 'ربع كيلو', 'S00000882', 150, 562, '2025-12-15 18:10:52', '2025-12-15 18:10:52', 100.00, 150.00, 10),
(883, 'ربع كيلو', 'S00000883', 150, 563, '2025-12-15 18:11:45', '2025-12-15 18:11:45', 100.00, 150.00, 10),
(884, 'ربع كيلو', 'S00000884', 150, 564, '2025-12-15 18:12:34', '2025-12-15 18:12:34', 100.00, 150.00, 20),
(885, 'نص كيلو', 'S00000885', 150, 565, '2025-12-15 18:13:48', '2025-12-15 18:13:48', 100.00, 150.00, 9),
(886, 'نص كيلو', 'S00000886', 150, 566, '2025-12-15 18:15:59', '2025-12-15 18:15:59', 100.00, 150.00, 5),
(887, 'نص كيلو', 'S00000887', 150, 567, '2025-12-15 18:17:33', '2025-12-15 18:17:33', 100.00, 150.00, 17),
(888, 'صغير', 'S00000888', 150, 568, '2025-12-15 18:20:02', '2025-12-15 18:20:02', 100.00, 150.00, 11),
(889, 'كبير', 'S00000889', 150, 568, '2025-12-15 18:20:02', '2025-12-15 18:20:02', 100.00, 150.00, 1),
(890, 'صغير', 'S00000890', 150, 569, '2025-12-15 18:29:52', '2025-12-15 18:29:52', 100.00, 150.00, 12),
(891, 'كبير', 'S00000891', 150, 569, '2025-12-15 18:29:52', '2025-12-15 18:29:52', 100.00, 150.00, 16),
(892, 'صغير', 'S00000892', 150, 570, '2025-12-15 18:33:20', '2025-12-15 18:33:20', 100.00, 150.00, 3),
(893, 'كبير', 'S00000893', 150, 570, '2025-12-15 18:33:20', '2025-12-15 18:33:20', 100.00, 150.00, 9),
(894, 'صغير', 'S00000894', 150, 571, '2025-12-15 18:36:13', '2025-12-15 18:36:13', 100.00, 150.00, 16),
(895, 'كبير', 'S00000895', 150, 571, '2025-12-15 18:36:13', '2025-12-15 18:36:13', 100.00, 150.00, 11),
(896, 'صغير', 'S00000896', 150, 572, '2025-12-15 18:41:03', '2025-12-15 18:41:03', 100.00, 150.00, 6),
(897, 'كبير', 'S00000897', 150, 572, '2025-12-15 18:41:03', '2025-12-15 18:41:03', 100.00, 150.00, 19),
(898, 'صغير', 'S00000898', 150, 573, '2025-12-15 18:42:28', '2025-12-15 18:42:28', 100.00, 150.00, 15),
(899, 'كبير', 'S00000899', 150, 573, '2025-12-15 18:42:28', '2025-12-15 18:42:28', 100.00, 150.00, 19),
(900, 'صغير', 'S00000900', 150, 574, '2025-12-15 18:44:47', '2025-12-15 18:44:47', 100.00, 150.00, 8),
(901, 'كبير', 'S00000901', 150, 574, '2025-12-15 18:44:47', '2025-12-15 18:44:47', 100.00, 150.00, 2),
(909, 'حار', 'S00000909', 150, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14', 100.00, 150.00, 8),
(910, 'بارد', 'S00000910', 150, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14', 100.00, 150.00, 10),
(911, 'ميكس', 'S00000911', 150, 496, '2025-12-15 18:53:14', '2025-12-15 18:53:14', 100.00, 150.00, 9),
(912, 'حار', 'S00000912', 150, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38', 100.00, 150.00, 12),
(913, 'بارد', 'S00000913', 150, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38', 100.00, 150.00, 14),
(914, 'ميكس', 'S00000914', 150, 497, '2025-12-15 18:53:38', '2025-12-15 18:53:38', 100.00, 150.00, 11),
(915, 'ساندوتش', 'S00000915', 150, 575, '2025-12-15 18:53:58', '2025-12-15 18:53:58', 100.00, 150.00, 15),
(916, 'حار', 'S00000916', 150, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15', 100.00, 150.00, 3),
(917, 'بارد', 'S00000917', 150, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15', 100.00, 150.00, 6),
(918, 'ميكس', 'S00000918', 150, 498, '2025-12-15 18:54:15', '2025-12-15 18:54:15', 100.00, 150.00, 4),
(919, 'حار', 'S00000919', 150, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42', 100.00, 150.00, 19),
(920, 'بارد', 'S00000920', 150, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42', 100.00, 150.00, 4),
(921, 'ميكس', 'S00000921', 150, 499, '2025-12-15 18:54:42', '2025-12-15 18:54:42', 100.00, 150.00, 1),
(922, 'ساندوتش', 'S00000922', 150, 576, '2025-12-15 18:55:19', '2025-12-15 18:55:19', 100.00, 150.00, 13),
(923, 'ساندوتش', 'S00000923', 150, 577, '2025-12-15 18:56:53', '2025-12-15 18:56:53', 100.00, 150.00, 3),
(924, 'حار', 'S00000924', 150, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58', 100.00, 150.00, 16),
(925, 'بارد', 'S00000925', 150, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58', 100.00, 150.00, 11),
(926, 'ميكس', 'S00000926', 150, 500, '2025-12-15 18:56:58', '2025-12-15 18:56:58', 100.00, 150.00, 7),
(930, 'ساندوتش', 'S00000930', 150, 578, '2025-12-15 18:58:05', '2025-12-15 18:58:05', 100.00, 150.00, 20),
(931, 'ساندوتش', 'S00000931', 150, 579, '2025-12-15 18:59:27', '2025-12-15 18:59:27', 100.00, 150.00, 17),
(932, 'ساندوتش', 'S00000932', 150, 580, '2025-12-15 19:00:28', '2025-12-15 19:00:28', 100.00, 150.00, 6),
(933, 'ساندوتش', 'S00000933', 150, 581, '2025-12-15 19:01:36', '2025-12-15 19:01:36', 100.00, 150.00, 20),
(934, 'حار', 'S00000934', 150, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58', 100.00, 150.00, 20),
(935, 'بارد', 'S00000935', 150, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58', 100.00, 150.00, 18),
(936, 'اجنحه بارد وصوص حار', 'S00000936', 150, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58', 100.00, 150.00, 11),
(937, 'اجنحه حار وصوص بارد', 'S00000937', 150, 503, '2025-12-15 19:04:58', '2025-12-15 19:04:58', 100.00, 150.00, 19),
(938, 'حار', 'S00000938', 150, 504, '2025-12-15 19:05:34', '2025-12-15 19:05:34', 100.00, 150.00, 4),
(939, 'بارد', 'S00000939', 150, 504, '2025-12-15 19:05:34', '2025-12-15 19:05:34', 100.00, 150.00, 1),
(940, 'بارد', 'S00000940', 150, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23', 100.00, 150.00, 15),
(941, 'استربس فقط حار مع صوص بارد', 'S00000941', 150, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23', 100.00, 150.00, 8),
(942, 'استربس فقط بارد مع صوص حار', 'S00000942', 150, 505, '2025-12-15 19:06:23', '2025-12-15 19:06:23', 100.00, 150.00, 16),
(943, 'بارد', 'S00000943', 150, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12', 100.00, 150.00, 17),
(944, 'استربس فقط حار مع صوص بارد', 'S00000944', 150, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12', 100.00, 150.00, 15),
(945, 'استربس فقط بارد مع صوص حار', 'S00000945', 150, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12', 100.00, 150.00, 6),
(946, 'حار', 'S00000946', 150, 506, '2025-12-15 19:07:12', '2025-12-15 19:07:12', 100.00, 150.00, 2),
(947, 'حار', 'S00000947', 150, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29', 100.00, 150.00, 12),
(948, 'بارد', 'S00000948', 150, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29', 100.00, 150.00, 14),
(949, 'ميكس', 'S00000949', 150, 501, '2025-12-15 19:18:29', '2025-12-15 19:18:29', 100.00, 150.00, 12),
(952, 'بارد', 'S00000952', 150, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34', 100.00, 150.00, 18),
(953, 'ميكس', 'S00000953', 150, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34', 100.00, 150.00, 14),
(954, 'حار', 'S00000954', 150, 509, '2025-12-15 19:19:34', '2025-12-15 19:19:34', 100.00, 150.00, 16),
(955, 'حار', 'S00000955', 150, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51', 100.00, 150.00, 17),
(956, 'ميكس', 'S00000956', 150, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51', 100.00, 150.00, 17),
(957, 'بارد', 'S00000957', 150, 508, '2025-12-15 19:20:51', '2025-12-15 19:20:51', 100.00, 150.00, 12),
(958, 'بارد', 'S00000958', 150, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59', 100.00, 150.00, 11),
(959, 'ميكس', 'S00000959', 150, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59', 100.00, 150.00, 17),
(960, 'حار', 'S00000960', 150, 507, '2025-12-15 19:23:59', '2025-12-15 19:23:59', 100.00, 150.00, 13),
(961, 'حار', 'S00000961', 150, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29', 100.00, 150.00, 13),
(962, 'بارد', 'S00000962', 150, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29', 100.00, 150.00, 3),
(963, 'ميكس', 'S00000963', 150, 510, '2025-12-15 19:26:29', '2025-12-15 19:26:29', 100.00, 150.00, 18),
(964, 'حار', 'S00000964', 150, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55', 100.00, 150.00, 19),
(965, 'بارد', 'S00000965', 150, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55', 100.00, 150.00, 3),
(966, 'ميكس', 'S00000966', 150, 511, '2025-12-15 19:26:55', '2025-12-15 19:26:55', 100.00, 150.00, 15),
(967, 'حار', 'S00000967', 150, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17', 100.00, 150.00, 7),
(968, 'بارد', 'S00000968', 150, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17', 100.00, 150.00, 10),
(969, 'ميكس', 'S00000969', 150, 512, '2025-12-15 19:27:17', '2025-12-15 19:27:17', 100.00, 150.00, 7),
(970, 'بارد', 'S00000970', 150, 513, '2025-12-15 19:30:06', '2025-12-15 19:30:06', 100.00, 150.00, 6),
(971, 'حار', 'S00000971', 150, 515, '2025-12-15 19:30:44', '2025-12-15 19:30:44', 100.00, 150.00, 7),
(972, 'بارد', 'S00000972', 150, 515, '2025-12-15 19:30:44', '2025-12-15 19:30:44', 100.00, 150.00, 16),
(973, 'حار', 'S00000973', 150, 516, '2025-12-15 19:32:22', '2025-12-15 19:32:22', 100.00, 150.00, 19),
(974, 'بارد', 'S00000974', 150, 516, '2025-12-15 19:32:22', '2025-12-15 19:32:22', 100.00, 150.00, 8),
(975, 'حار', 'S00000975', 150, 517, '2025-12-15 19:33:04', '2025-12-15 19:33:04', 100.00, 150.00, 3),
(976, 'بارد', 'S00000976', 150, 517, '2025-12-15 19:33:04', '2025-12-15 19:33:04', 100.00, 150.00, 11),
(977, 'حار', 'S00000977', 150, 518, '2025-12-15 19:35:09', '2025-12-15 19:35:09', 100.00, 150.00, 4),
(978, 'صوص بارد', 'S00000978', 150, 523, '2025-12-15 19:37:10', '2025-12-15 19:37:10', 100.00, 150.00, 6),
(979, 'صوص حار', 'S00000979', 150, 523, '2025-12-15 19:37:10', '2025-12-15 19:37:10', 100.00, 150.00, 19),
(980, 'صوص بارد', 'S00000980', 150, 524, '2025-12-15 19:39:25', '2025-12-15 19:39:25', 100.00, 150.00, 15),
(981, 'صوص حار', 'S00000981', 150, 524, '2025-12-15 19:39:25', '2025-12-15 19:39:25', 100.00, 150.00, 16),
(982, 'صوص بارد', 'S00000982', 150, 525, '2025-12-15 19:42:04', '2025-12-15 19:42:04', 100.00, 150.00, 17),
(983, 'صوص حار', 'S00000983', 150, 525, '2025-12-15 19:42:04', '2025-12-15 19:42:04', 100.00, 150.00, 14),
(984, 'صوص حار', 'S00000984', 150, 526, '2025-12-15 19:43:15', '2025-12-15 19:43:15', 100.00, 150.00, 20),
(985, 'صوص بارد', 'S00000985', 150, 526, '2025-12-15 19:43:15', '2025-12-15 19:43:15', 100.00, 150.00, 19),
(986, 'صوص حار', 'S00000986', 150, 527, '2025-12-15 19:47:23', '2025-12-15 19:47:23', 100.00, 150.00, 12),
(987, 'صوص بارد', 'S00000987', 150, 527, '2025-12-15 19:47:23', '2025-12-15 19:47:23', 100.00, 150.00, 2),
(988, 'صوص بارد', 'S00000988', 150, 528, '2025-12-15 19:48:17', '2025-12-15 19:48:17', 100.00, 150.00, 14),
(989, 'صوص حار', 'S00000989', 150, 528, '2025-12-15 19:48:17', '2025-12-15 19:48:17', 100.00, 150.00, 3),
(990, 'صوص حار', 'S00000990', 150, 529, '2025-12-15 19:49:43', '2025-12-15 19:49:43', 100.00, 150.00, 12),
(991, 'صوص بارد', 'S00000991', 150, 529, '2025-12-15 19:49:43', '2025-12-15 19:49:43', 100.00, 150.00, 13),
(992, 'صوص حار', 'S00000992', 150, 530, '2025-12-15 19:53:50', '2025-12-15 19:53:50', 100.00, 150.00, 6),
(993, 'صوص بارد', 'S00000993', 150, 530, '2025-12-15 19:53:50', '2025-12-15 19:53:50', 100.00, 150.00, 12),
(997, 'ربع كيلو', 'S00000997', 150, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46', 100.00, 150.00, 19),
(998, 'نص كيلو', 'S00000998', 150, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46', 100.00, 150.00, 20),
(999, 'كيلو', 'S00000999', 150, 326, '2025-12-16 14:11:46', '2025-12-16 14:11:46', 100.00, 150.00, 2),
(1000, 'ربع فرخة', 'S00001000', 150, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57', 100.00, 150.00, 10),
(1001, 'نص فرخة', 'S00001001', 150, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57', 100.00, 150.00, 5),
(1002, 'فرخة كاملة', 'S00001002', 150, 327, '2025-12-16 14:14:57', '2025-12-16 14:14:57', 100.00, 150.00, 13),
(1006, 'ربع كيلو', 'S00001006', 150, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04', 100.00, 150.00, 10),
(1007, 'نص كيلو', 'S00001007', 150, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04', 100.00, 150.00, 11),
(1008, 'كيلو', 'S00001008', 150, 328, '2025-12-16 14:17:04', '2025-12-16 14:17:04', 100.00, 150.00, 5),
(1009, 'ربع كيلو', 'S00001009', 150, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48', 100.00, 150.00, 12),
(1010, 'نص كيلو', 'S00001010', 150, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48', 100.00, 150.00, 3),
(1011, 'كيلو', 'S00001011', 150, 329, '2025-12-16 14:17:48', '2025-12-16 14:17:48', 100.00, 150.00, 17),
(1012, 'وسط', 'S00001012', 150, 331, '2025-12-16 16:56:24', '2025-12-16 16:56:24', 100.00, 150.00, 18),
(1016, 'كبير', 'S00001016', 150, 338, '2025-12-16 16:59:07', '2025-12-16 16:59:07', 100.00, 150.00, 19),
(1017, 'كبير', 'S00001017', 150, 340, '2025-12-16 16:59:39', '2025-12-16 16:59:39', 100.00, 150.00, 19),
(1018, 'كبير', 'S00001018', 150, 341, '2025-12-16 16:59:56', '2025-12-16 16:59:56', 100.00, 150.00, 20),
(1019, 'كبير', 'S00001019', 150, 342, '2025-12-16 17:00:16', '2025-12-16 17:00:16', 100.00, 150.00, 1),
(1021, 'وجبة', 'S00001021', 150, 352, '2025-12-16 17:05:52', '2025-12-16 17:05:52', 100.00, 150.00, 3),
(1022, 'وجبة', 'S00001022', 150, 353, '2025-12-16 17:06:35', '2025-12-16 17:06:35', 100.00, 150.00, 11),
(1024, 'وجبة', 'S00001024', 150, 354, '2025-12-16 17:07:14', '2025-12-16 17:07:14', 100.00, 150.00, 6),
(1025, 'طاجن', 'S00001025', 150, 582, '2025-12-24 13:30:27', '2025-12-24 13:30:27', 100.00, 150.00, 16),
(1026, 'طاجن', 'S00001026', 150, 583, '2025-12-24 13:31:51', '2025-12-24 13:31:51', 100.00, 150.00, 2),
(1027, 'طاجن', 'S00001027', 150, 584, '2025-12-24 13:33:20', '2025-12-24 13:33:20', 100.00, 150.00, 3),
(1028, 'طاجن', 'S00001028', 150, 585, '2025-12-24 13:35:28', '2025-12-24 13:35:28', 100.00, 150.00, 6),
(1029, 'طاجن', 'S00001029', 150, 586, '2025-12-24 13:37:39', '2025-12-24 13:37:39', 100.00, 150.00, 2),
(1030, 'طاجن', 'S00001030', 150, 587, '2025-12-24 13:38:54', '2025-12-24 13:38:54', 100.00, 150.00, 10),
(1031, 'طاجن', 'S00001031', 150, 588, '2025-12-24 13:40:47', '2025-12-24 13:40:47', 100.00, 150.00, 4),
(1033, 'طاجن', 'S00001033', 150, 589, '2025-12-24 13:42:03', '2025-12-24 13:42:03', 100.00, 150.00, 10),
(1034, 'طاجن', 'S00001034', 150, 590, '2025-12-24 13:45:21', '2025-12-24 13:45:21', 100.00, 150.00, 19),
(1035, 'طاجن', 'S00001035', 150, 591, '2025-12-24 13:46:58', '2025-12-24 13:46:58', 100.00, 150.00, 4),
(1036, 'طاجن', 'S00001036', 150, 592, '2025-12-24 13:50:04', '2025-12-24 13:50:04', 100.00, 150.00, 1),
(1037, 'طاجن', 'S00001037', 150, 593, '2025-12-24 13:51:47', '2025-12-24 13:51:47', 100.00, 150.00, 14),
(1053, 'ربع كيلو', 'S00001053', 150, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12', 100.00, 150.00, 6),
(1054, 'نص كيلو', 'S00001054', 150, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12', 100.00, 150.00, 8),
(1055, 'كيلو', 'S00001055', 150, 595, '2025-12-24 14:22:12', '2025-12-24 14:22:12', 100.00, 150.00, 1),
(1059, 'ربع كيلو', 'S00001059', 150, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47', 100.00, 150.00, 20),
(1060, 'نص كيلو', 'S00001060', 150, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47', 100.00, 150.00, 16),
(1061, 'كيلو', 'S00001061', 150, 598, '2025-12-24 14:29:47', '2025-12-24 14:29:47', 100.00, 150.00, 19),
(1068, 'ربع كيلو', 'S00001068', 150, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09', 100.00, 150.00, 8),
(1069, 'نص كيلو', 'S00001069', 150, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09', 100.00, 150.00, 2),
(1070, 'كيلو', 'S00001070', 150, 600, '2025-12-24 14:35:09', '2025-12-24 14:35:09', 100.00, 150.00, 4),
(1072, 'ربع كيلو', 'S00001072', 150, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49', 100.00, 150.00, 13),
(1073, 'نص كيلو', 'S00001073', 150, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49', 100.00, 150.00, 14),
(1074, 'كيلو', 'S00001074', 150, 601, '2025-12-24 14:37:49', '2025-12-24 14:37:49', 100.00, 150.00, 11),
(1075, 'ربع كيلو', 'S00001075', 150, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45', 100.00, 150.00, 11),
(1076, 'نص كيلو', 'S00001076', 150, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45', 100.00, 150.00, 1),
(1077, 'كيلو', 'S00001077', 150, 602, '2025-12-24 14:38:45', '2025-12-24 14:38:45', 100.00, 150.00, 14),
(1081, 'ربع كيلو', 'S00001081', 150, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57', 100.00, 150.00, 6),
(1082, 'نص كيلو', 'S00001082', 150, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57', 100.00, 150.00, 7),
(1083, 'كيلو', 'S00001083', 150, 604, '2025-12-24 14:41:57', '2025-12-24 14:41:57', 100.00, 150.00, 18),
(1084, 'ربع كيلو', 'S00001084', 150, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03', 100.00, 150.00, 10),
(1085, 'نص كيلو', 'S00001085', 150, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03', 100.00, 150.00, 12),
(1086, 'كيلو', 'S00001086', 150, 605, '2025-12-24 14:43:03', '2025-12-24 14:43:03', 100.00, 150.00, 9),
(1088, 'وجبه', 'S00001088', 150, 607, '2025-12-24 14:48:42', '2025-12-24 14:48:42', 100.00, 150.00, 11),
(1089, 'وجبة', 'S00001089', 150, 606, '2025-12-24 14:48:52', '2025-12-24 14:48:52', 100.00, 150.00, 5),
(1090, 'طبق', 'S00001090', 150, 608, '2025-12-24 14:52:14', '2025-12-24 14:52:14', 100.00, 150.00, 13),
(1091, 'طبق', 'S00001091', 150, 609, '2025-12-24 14:54:37', '2025-12-24 14:54:37', 100.00, 150.00, 10),
(1092, 'طبق', 'S00001092', 150, 610, '2025-12-24 14:56:04', '2025-12-24 14:56:04', 100.00, 150.00, 11),
(1093, 'وجبة', 'S00001093', 150, 611, '2025-12-24 14:59:50', '2025-12-24 14:59:50', 100.00, 150.00, 4),
(1094, 'وجبة', 'S00001094', 150, 612, '2025-12-24 15:05:45', '2025-12-24 15:05:45', 100.00, 150.00, 8),
(1095, 'وجبة', 'S00001095', 150, 613, '2025-12-24 15:07:20', '2025-12-24 15:07:20', 100.00, 150.00, 4),
(1096, 'وجبة', 'S00001096', 150, 614, '2025-12-24 15:10:26', '2025-12-24 15:10:26', 100.00, 150.00, 19),
(1097, 'طبق', 'S00001097', 150, 615, '2025-12-24 15:11:56', '2025-12-24 15:11:56', 100.00, 150.00, 2),
(1098, 'طبق', 'S00001098', 150, 616, '2025-12-24 15:13:53', '2025-12-24 15:13:53', 100.00, 150.00, 10),
(1099, 'طبق', 'S00001099', 150, 617, '2025-12-24 15:15:01', '2025-12-24 15:15:01', 100.00, 150.00, 7),
(1100, 'وجبة ورك', 'S00001100', 150, 618, '2025-12-24 15:19:54', '2025-12-24 15:19:54', 100.00, 150.00, 1),
(1101, 'وجبة صدر', 'S00001101', 150, 618, '2025-12-24 15:19:54', '2025-12-24 15:19:54', 100.00, 150.00, 5),
(1102, 'وجبة', 'S00001102', 150, 619, '2025-12-24 15:21:20', '2025-12-24 15:21:20', 100.00, 150.00, 1),
(1103, 'وجبة', 'S00001103', 150, 620, '2025-12-24 15:24:00', '2025-12-24 15:24:00', 100.00, 150.00, 8),
(1104, 'وجبة', 'S00001104', 150, 621, '2025-12-24 15:28:07', '2025-12-24 15:28:07', 100.00, 150.00, 19),
(1109, 'طبق', 'S00001109', 150, 627, '2025-12-24 16:21:43', '2025-12-24 16:21:43', 100.00, 150.00, 9),
(1110, 'طبق', 'S00001110', 150, 628, '2025-12-24 16:24:24', '2025-12-24 16:24:24', 100.00, 150.00, 10),
(1111, 'طبق', 'S00001111', 150, 629, '2025-12-24 16:27:20', '2025-12-24 16:27:20', 100.00, 150.00, 1),
(1112, 'طبق', 'S00001112', 150, 630, '2025-12-24 16:30:03', '2025-12-24 16:30:03', 100.00, 150.00, 15),
(1113, 'طبق', 'S00001113', 150, 631, '2025-12-24 16:33:28', '2025-12-24 16:33:28', 100.00, 150.00, 12),
(1114, 'طبق', 'S00001114', 150, 632, '2025-12-24 16:37:01', '2025-12-24 16:37:01', 100.00, 150.00, 16),
(1115, 'طبق', 'S00001115', 150, 633, '2025-12-24 16:39:58', '2025-12-24 16:39:58', 100.00, 150.00, 1),
(1116, 'طبق', 'S00001116', 150, 634, '2025-12-24 16:42:39', '2025-12-24 16:42:39', 100.00, 150.00, 17),
(1118, 'طبق', 'S00001118', 150, 636, '2025-12-24 16:45:27', '2025-12-24 16:45:27', 100.00, 150.00, 20),
(1120, 'طبق', 'S00001120', 150, 635, '2025-12-24 16:45:41', '2025-12-24 16:45:41', 100.00, 150.00, 12),
(1121, 'طبق', 'S00001121', 150, 637, '2025-12-24 16:46:44', '2025-12-24 16:46:44', 100.00, 150.00, 16),
(1122, 'طبق', 'S00001122', 150, 638, '2025-12-24 16:47:40', '2025-12-24 16:47:40', 100.00, 150.00, 7),
(1123, 'ربع كيلو', 'S00001123', 150, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06', 100.00, 150.00, 3),
(1124, 'نص كيلو', 'S00001124', 150, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06', 100.00, 150.00, 15),
(1125, 'كيلو', 'S00001125', 150, 325, '2025-12-24 16:48:06', '2025-12-24 16:48:06', 100.00, 150.00, 6),
(1126, 'طبق', 'S00001126', 150, 639, '2025-12-24 16:49:13', '2025-12-24 16:49:13', 100.00, 150.00, 5),
(1127, 'طبق', 'S00001127', 150, 640, '2025-12-24 16:49:54', '2025-12-24 16:49:54', 100.00, 150.00, 4),
(1128, 'طبق', 'S00001128', 150, 641, '2025-12-24 16:50:41', '2025-12-24 16:50:41', 100.00, 150.00, 6),
(1129, 'طبق', 'S00001129', 150, 642, '2025-12-24 16:58:41', '2025-12-24 16:58:41', 100.00, 150.00, 17),
(1130, 'طبق', 'S00001130', 150, 643, '2025-12-24 16:59:49', '2025-12-24 16:59:49', 100.00, 150.00, 7),
(1131, 'صغير', 'S00001131', 150, 644, '2025-12-24 17:02:09', '2025-12-24 17:02:09', 100.00, 150.00, 3),
(1132, 'كبير', 'S00001132', 150, 644, '2025-12-24 17:02:09', '2025-12-24 17:02:09', 100.00, 150.00, 16),
(1133, 'صغير', 'S00001133', 150, 645, '2025-12-24 17:03:59', '2025-12-24 17:03:59', 100.00, 150.00, 7),
(1134, 'كبير', 'S00001134', 150, 645, '2025-12-24 17:03:59', '2025-12-24 17:03:59', 100.00, 150.00, 7),
(1135, 'كبير', 'S00001135', 150, 646, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 100.00, 150.00, 14),
(1136, 'طبق', 'S00001136', 150, 647, '2025-12-24 17:08:59', '2025-12-24 17:08:59', 100.00, 150.00, 8),
(1137, 'طبق', 'S00001137', 150, 648, '2025-12-24 17:12:29', '2025-12-24 17:12:29', 100.00, 150.00, 18),
(1138, 'نص بطة', 'S00001138', 150, 649, '2025-12-24 17:14:47', '2025-12-24 17:14:47', 100.00, 150.00, 7),
(1139, 'طاجن', 'S00001139', 150, 650, '2025-12-24 17:16:30', '2025-12-24 17:16:30', 100.00, 150.00, 19),
(1140, 'طبق', 'S00001140', 150, 651, '2025-12-24 17:17:51', '2025-12-24 17:17:51', 100.00, 150.00, 14),
(1143, 'ساندوتش', 'S00001143', 150, 654, '2025-12-24 17:25:17', '2025-12-24 17:25:17', 100.00, 150.00, 13),
(1144, 'صغير', 'S00001144', 150, 655, '2025-12-24 17:26:44', '2025-12-24 17:26:44', 100.00, 150.00, 3),
(1145, 'كنز', 'S00001145', 150, 656, '2025-12-24 17:27:54', '2025-12-24 17:27:54', 100.00, 150.00, 13),
(1146, 'صغير', 'S00001146', 150, 657, '2025-12-24 17:28:48', '2025-12-24 17:28:48', 100.00, 150.00, 16),
(1147, 'كيلو', 'S00001147', 150, 658, '2025-12-24 18:12:33', '2025-12-24 18:12:33', 100.00, 150.00, 2),
(1150, 'كيلو', 'S00001150', 150, 661, '2025-12-24 18:16:08', '2025-12-24 18:16:08', 100.00, 150.00, 19),
(1151, 'كيلو', 'S00001151', 150, 662, '2025-12-24 18:17:11', '2025-12-24 18:17:11', 100.00, 150.00, 11),
(1152, 'كيلو', 'S00001152', 150, 663, '2025-12-24 18:18:17', '2025-12-24 18:18:17', 100.00, 150.00, 18),
(1153, 'كيلو', 'S00001153', 150, 664, '2025-12-24 18:19:22', '2025-12-24 18:19:22', 100.00, 150.00, 16),
(1154, 'كيلو', 'S00001154', 150, 665, '2025-12-24 18:20:36', '2025-12-24 18:20:36', 100.00, 150.00, 5),
(1155, 'كيلو', 'S00001155', 150, 666, '2025-12-24 18:21:52', '2025-12-24 18:21:52', 100.00, 150.00, 15),
(1156, 'كيلو', 'S00001156', 150, 667, '2025-12-24 18:22:55', '2025-12-24 18:22:55', 100.00, 150.00, 1),
(1157, 'كيلو', 'S00001157', 150, 668, '2025-12-24 18:23:51', '2025-12-24 18:23:51', 100.00, 150.00, 18),
(1158, 'كيلو', 'S00001158', 150, 669, '2025-12-24 18:25:06', '2025-12-24 18:25:06', 100.00, 150.00, 8),
(1159, 'كيلو', 'S00001159', 150, 670, '2025-12-24 18:26:15', '2025-12-24 18:26:15', 100.00, 150.00, 7),
(1160, 'كيلو', 'S00001160', 150, 671, '2025-12-24 18:27:21', '2025-12-24 18:27:21', 100.00, 150.00, 9),
(1162, 'كيلو', 'S00001162', 150, 673, '2025-12-24 18:30:27', '2025-12-24 18:30:27', 100.00, 150.00, 4),
(1163, 'كيلو', 'S00001163', 150, 674, '2025-12-24 18:32:02', '2025-12-24 18:32:02', 100.00, 150.00, 14),
(1164, 'كيلو', 'S00001164', 150, 675, '2025-12-24 18:35:23', '2025-12-24 18:35:23', 100.00, 150.00, 16),
(1165, 'كيلو', 'S00001165', 150, 676, '2025-12-24 18:36:30', '2025-12-24 18:36:30', 100.00, 150.00, 16),
(1166, 'كيلو', 'S00001166', 150, 677, '2025-12-24 18:37:30', '2025-12-24 18:37:30', 100.00, 150.00, 12),
(1167, 'كيلو', 'S00001167', 150, 678, '2025-12-24 18:38:41', '2025-12-24 18:38:41', 100.00, 150.00, 14),
(1170, 'كيلو', 'S00001170', 150, 681, '2025-12-24 18:44:35', '2025-12-24 18:44:35', 100.00, 150.00, 11),
(1171, 'كيلو', 'S00001171', 150, 682, '2025-12-24 18:46:04', '2025-12-24 18:46:04', 100.00, 150.00, 12),
(1172, 'كيلو', 'S00001172', 150, 683, '2025-12-24 18:47:18', '2025-12-24 18:47:18', 100.00, 150.00, 6),
(1173, 'كيلو', 'S00001173', 150, 684, '2025-12-24 18:48:45', '2025-12-24 18:48:45', 100.00, 150.00, 14),
(1174, 'كيلو', 'S00001174', 150, 685, '2025-12-24 18:49:47', '2025-12-24 18:49:47', 100.00, 150.00, 10),
(1175, 'كيلو', 'S00001175', 150, 686, '2025-12-24 18:51:53', '2025-12-24 18:51:53', 100.00, 150.00, 7),
(1176, 'كيلو', 'S00001176', 150, 687, '2025-12-24 18:52:46', '2025-12-24 18:52:46', 100.00, 150.00, 7),
(1177, 'كيلو', 'S00001177', 150, 688, '2025-12-24 18:54:18', '2025-12-24 18:54:18', 100.00, 150.00, 14),
(1178, 'كيلو', 'S00001178', 150, 689, '2025-12-24 18:55:36', '2025-12-24 18:55:36', 100.00, 150.00, 7),
(1179, 'كيلو', 'S00001179', 150, 690, '2025-12-24 18:56:41', '2025-12-24 18:56:41', 100.00, 150.00, 14),
(1180, 'كيلو', 'S00001180', 150, 691, '2025-12-24 18:57:46', '2025-12-24 18:57:46', 100.00, 150.00, 6),
(1181, 'كيلو', 'S00001181', 150, 692, '2025-12-24 18:58:40', '2025-12-24 18:58:40', 100.00, 150.00, 9),
(1182, 'كيلو', 'S00001182', 150, 693, '2025-12-24 18:59:36', '2025-12-24 18:59:36', 100.00, 150.00, 6),
(1183, 'كيلو', 'S00001183', 150, 694, '2025-12-24 19:00:44', '2025-12-24 19:00:44', 100.00, 150.00, 2),
(1184, 'كيلو', 'S00001184', 150, 695, '2025-12-24 19:01:41', '2025-12-24 19:01:41', 100.00, 150.00, 11),
(1186, 'كيلو', 'S00001186', 150, 697, '2025-12-24 19:04:46', '2025-12-24 19:04:46', 100.00, 150.00, 9),
(1187, 'كيلو', 'S00001187', 150, 698, '2025-12-24 19:06:02', '2025-12-24 19:06:02', 100.00, 150.00, 11),
(1188, 'كيلو', 'S00001188', 150, 699, '2025-12-24 19:06:56', '2025-12-24 19:06:56', 100.00, 150.00, 8),
(1189, 'كيلو', 'S00001189', 150, 700, '2025-12-24 19:08:13', '2025-12-24 19:08:13', 100.00, 150.00, 5),
(1190, 'كيلو', 'S00001190', 150, 701, '2025-12-24 19:09:06', '2025-12-24 19:09:06', 100.00, 150.00, 3),
(1191, 'كيلو', 'S00001191', 150, 702, '2025-12-24 19:09:25', '2025-12-24 19:09:25', 100.00, 150.00, 17),
(1192, 'مخ', 'S00001192', 150, 703, '2025-12-24 19:10:54', '2025-12-24 19:10:54', 100.00, 150.00, 14),
(1193, 'كيلو', 'S00001193', 150, 704, '2025-12-24 19:11:55', '2025-12-24 19:11:55', 100.00, 150.00, 2),
(1194, 'كيلو', 'S00001194', 150, 705, '2025-12-24 19:12:45', '2025-12-24 19:12:45', 100.00, 150.00, 6),
(1195, 'كيلو', 'S00001195', 150, 706, '2025-12-24 19:13:50', '2025-12-24 19:13:50', 100.00, 150.00, 3),
(1196, 'طحال', 'S00001196', 150, 707, '2025-12-24 19:14:49', '2025-12-24 19:14:49', 100.00, 150.00, 18),
(1197, 'مخاصي', 'S00001197', 150, 708, '2025-12-24 19:15:58', '2025-12-24 19:15:58', 100.00, 150.00, 20),
(1198, 'كارع', 'S00001198', 150, 710, '2025-12-24 19:18:17', '2025-12-24 19:18:17', 100.00, 150.00, 4),
(1199, 'كارع', 'S00001199', 150, 709, '2025-12-24 19:18:44', '2025-12-24 19:18:44', 100.00, 150.00, 3),
(1203, 'ربع كيلو', 'S00001203', 150, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56', 100.00, 150.00, 19),
(1204, 'نص كيلو', 'S00001204', 150, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56', 100.00, 150.00, 5),
(1205, 'كيلو', 'S00001205', 150, 712, '2025-12-27 13:22:56', '2025-12-27 13:22:56', 100.00, 150.00, 9),
(1212, 'ربع كيلو', 'S00001212', 150, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34', 100.00, 150.00, 9),
(1213, 'نص كيلو', 'S00001213', 150, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34', 100.00, 150.00, 18),
(1214, 'كيلو', 'S00001214', 150, 715, '2025-12-27 13:31:34', '2025-12-27 13:31:34', 100.00, 150.00, 4),
(1219, 'ربع كيلو', 'S00001219', 150, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28', 100.00, 150.00, 4),
(1220, 'نص كيلو', 'S00001220', 150, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28', 100.00, 150.00, 7),
(1221, 'كيلو', 'S00001221', 150, 717, '2025-12-27 13:35:28', '2025-12-27 13:35:28', 100.00, 150.00, 3),
(1222, 'ربع كيلو', 'S00001222', 150, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19', 100.00, 150.00, 15),
(1223, 'نص كيلو', 'S00001223', 150, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19', 100.00, 150.00, 4),
(1224, 'كيلو', 'S00001224', 150, 718, '2025-12-27 13:37:19', '2025-12-27 13:37:19', 100.00, 150.00, 15),
(1225, 'ربع كيلو', 'S00001225', 150, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25', 100.00, 150.00, 1),
(1226, 'نص كيلو', 'S00001226', 150, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25', 100.00, 150.00, 3),
(1227, 'كيلو', 'S00001227', 150, 719, '2025-12-27 13:40:25', '2025-12-27 13:40:25', 100.00, 150.00, 8),
(1228, 'ربع كيلو', 'S00001228', 150, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38', 100.00, 150.00, 11),
(1229, 'نص كيلو', 'S00001229', 150, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38', 100.00, 150.00, 11),
(1230, 'كيلو', 'S00001230', 150, 720, '2025-12-27 13:40:38', '2025-12-27 13:40:38', 100.00, 150.00, 2),
(1234, 'كيلو', 'S00001234', 150, 679, '2025-12-27 14:17:04', '2025-12-27 14:17:04', 100.00, 150.00, 18),
(1235, 'ربع كيلو', 'S00001235', 150, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50', 100.00, 150.00, 1),
(1236, 'نص كيلو', 'S00001236', 150, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50', 100.00, 150.00, 13),
(1237, 'كيلو', 'S00001237', 150, 722, '2025-12-27 14:44:50', '2025-12-27 14:44:50', 100.00, 150.00, 20),
(1238, 'ربع كيلو', 'S00001238', 150, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02', 100.00, 150.00, 2),
(1239, 'نص كيلو', 'S00001239', 150, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02', 100.00, 150.00, 9),
(1240, 'كيلو', 'S00001240', 150, 723, '2025-12-27 14:46:02', '2025-12-27 14:46:02', 100.00, 150.00, 17),
(1241, 'وجبة ورك', 'S00001241', 150, 724, '2025-12-27 14:48:05', '2025-12-27 14:48:05', 100.00, 150.00, 17),
(1242, 'وجبة صدر', 'S00001242', 150, 724, '2025-12-27 14:48:05', '2025-12-27 14:48:05', 100.00, 150.00, 15),
(1243, 'وجبة', 'S00001243', 150, 725, '2025-12-27 14:48:57', '2025-12-27 14:48:57', 100.00, 150.00, 5),
(1244, 'وجبة', 'S00001244', 150, 726, '2025-12-27 14:54:34', '2025-12-27 14:54:34', 100.00, 150.00, 19),
(1245, 'وجبة', 'S00001245', 150, 727, '2025-12-27 14:55:49', '2025-12-27 14:55:49', 100.00, 150.00, 17),
(1248, 'صغير', 'S00001248', 150, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59', 100.00, 150.00, 9),
(1249, 'كبير', 'S00001249', 150, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59', 100.00, 150.00, 15),
(1250, 'كبير بالجبنة', 'S00001250', 150, 731, '2025-12-27 15:20:59', '2025-12-27 15:20:59', 100.00, 150.00, 8),
(1251, 'طبق', 'S00001251', 150, 732, '2025-12-27 15:23:59', '2025-12-27 15:23:59', 100.00, 150.00, 15),
(1252, 'طبق', 'S00001252', 150, 733, '2025-12-27 15:24:54', '2025-12-27 15:24:54', 100.00, 150.00, 7),
(1253, 'طبق', 'S00001253', 150, 734, '2025-12-27 15:25:45', '2025-12-27 15:25:45', 100.00, 150.00, 13),
(1256, 'ساندوتش', 'S00001256', 150, 737, '2025-12-27 15:29:35', '2025-12-27 15:29:35', 100.00, 150.00, 3),
(1257, 'مياه', 'S00001257', 150, 738, '2025-12-27 15:31:27', '2025-12-27 15:31:27', 100.00, 150.00, 14),
(1258, 'كنز', 'S00001258', 150, 739, '2025-12-27 15:32:02', '2025-12-27 15:32:02', 100.00, 150.00, 19),
(1259, 'صغير', 'S00001259', 150, 740, '2025-12-27 15:33:05', '2025-12-27 15:33:05', 100.00, 150.00, 15),
(1260, 'كبير', 'S00001260', 150, 740, '2025-12-27 15:33:05', '2025-12-27 15:33:05', 100.00, 150.00, 19),
(1261, 'صغير', 'S00001261', 150, 741, '2025-12-27 15:34:26', '2025-12-27 15:34:26', 100.00, 150.00, 6),
(1262, 'كبير', 'S00001262', 150, 741, '2025-12-27 15:34:26', '2025-12-27 15:34:26', 100.00, 150.00, 14),
(1263, 'صغير', 'S00001263', 150, 742, '2025-12-27 15:35:13', '2025-12-27 15:35:13', 100.00, 150.00, 13),
(1264, 'كبير', 'S00001264', 150, 742, '2025-12-27 15:35:13', '2025-12-27 15:35:13', 100.00, 150.00, 3),
(1265, 'كبير', 'S00001265', 150, 743, '2025-12-27 15:37:23', '2025-12-27 15:37:23', 100.00, 150.00, 16),
(1266, 'صنية', 'S00001266', 150, 729, '2025-12-27 15:51:49', '2025-12-27 15:51:49', 100.00, 150.00, 9),
(1267, 'صواني', 'S00001267', 150, 728, '2025-12-27 15:52:11', '2025-12-27 15:52:11', 100.00, 150.00, 18),
(1268, 'كيلو', 'S00001268', 150, 659, '2025-12-27 15:58:52', '2025-12-27 15:58:52', 100.00, 150.00, 3),
(1269, 'كيلو', 'S00001269', 150, 660, '2025-12-27 16:00:05', '2025-12-27 16:00:05', 100.00, 150.00, 19),
(1270, 'كيلو', 'S00001270', 150, 672, '2025-12-27 16:02:17', '2025-12-27 16:02:17', 100.00, 150.00, 4),
(1271, 'كيلو', 'S00001271', 150, 680, '2025-12-27 16:05:42', '2025-12-27 16:05:42', 100.00, 150.00, 3),
(1272, 'كيلو', 'S00001272', 150, 696, '2025-12-27 16:07:39', '2025-12-27 16:07:39', 100.00, 150.00, 3),
(1273, 'كيلو', 'S00001273', 150, 744, '2025-12-29 00:03:28', '2025-12-29 00:03:28', 100.00, 150.00, 4),
(1274, 'كيلو', 'S00001274', 150, 745, '2025-12-29 00:04:39', '2025-12-29 00:04:39', 100.00, 150.00, 11),
(1275, 'ربع كيلو', 'S00001275', 150, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49', 100.00, 150.00, 1),
(1276, 'نص كيلو', 'S00001276', 150, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49', 100.00, 150.00, 13),
(1277, 'كيلو', 'S00001277', 150, 721, '2025-12-29 00:06:49', '2025-12-29 00:06:49', 100.00, 150.00, 3),
(1278, 'ربع كيلو', 'S00001278', 150, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48', 100.00, 150.00, 13),
(1279, 'نص كيلو', 'S00001279', 150, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48', 100.00, 150.00, 15),
(1280, 'كيلو', 'S00001280', 150, 711, '2025-12-29 00:07:48', '2025-12-29 00:07:48', 100.00, 150.00, 19),
(1281, 'ربع كيلو', 'S00001281', 150, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28', 100.00, 150.00, 6),
(1282, 'نص كيلو', 'S00001282', 150, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28', 100.00, 150.00, 15),
(1283, 'كيلو', 'S00001283', 150, 713, '2025-12-29 00:08:28', '2025-12-29 00:08:28', 100.00, 150.00, 15),
(1284, 'ربع فرخة', 'S00001284', 150, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55', 100.00, 150.00, 9),
(1285, 'نص فرخة', 'S00001285', 150, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55', 100.00, 150.00, 19),
(1286, 'فرخة كاملة', 'S00001286', 150, 714, '2025-12-29 00:08:55', '2025-12-29 00:08:55', 100.00, 150.00, 10),
(1287, 'ربع فرخة ورك', 'S00001287', 150, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20', 100.00, 150.00, 11),
(1288, 'ربع فرخة صدر', 'S00001288', 150, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20', 100.00, 150.00, 4),
(1289, 'نص فرخة', 'S00001289', 150, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20', 100.00, 150.00, 7),
(1290, 'فرخة كاملة', 'S00001290', 150, 716, '2025-12-29 00:09:20', '2025-12-29 00:09:20', 100.00, 150.00, 20),
(1291, 'ساندوتش', 'S00001291', 150, 735, '2025-12-29 00:11:47', '2025-12-29 00:11:47', 100.00, 150.00, 2),
(1292, 'ساندوتش', 'S00001292', 150, 736, '2025-12-29 00:12:41', '2025-12-29 00:12:41', 100.00, 150.00, 9),
(1293, 'سندوتش', 'S00001293', 150, 746, '2025-12-29 00:14:57', '2025-12-29 00:14:57', 100.00, 150.00, 19),
(1294, 'سندوتش', 'S00001294', 150, 747, '2025-12-29 00:16:37', '2025-12-29 00:16:37', 100.00, 150.00, 9),
(1295, 'سندوتش', 'S00001295', 150, 748, '2025-12-29 00:18:09', '2025-12-29 00:18:09', 100.00, 150.00, 5),
(1296, 'سندوتش', 'S00001296', 150, 749, '2025-12-29 00:20:31', '2025-12-29 00:20:31', 100.00, 150.00, 19),
(1297, 'سندوتش', 'S00001297', 150, 750, '2025-12-29 00:21:51', '2025-12-29 00:21:51', 100.00, 150.00, 20),
(1298, 'سندوتش', 'S00001298', 150, 751, '2025-12-29 00:23:43', '2025-12-29 00:23:43', 100.00, 150.00, 3),
(1299, 'سندوتش', 'S00001299', 150, 752, '2025-12-29 00:24:46', '2025-12-29 00:24:46', 100.00, 150.00, 12),
(1301, 'كيلو', 'S00001301', 150, 754, '2025-12-29 00:28:35', '2025-12-29 00:28:35', 100.00, 150.00, 10),
(1302, 'البطه', 'S00001302', 150, 755, '2025-12-29 00:29:45', '2025-12-29 00:29:45', 100.00, 150.00, 13),
(1303, 'كيلو', 'S00001303', 150, 756, '2025-12-29 00:30:50', '2025-12-29 00:30:50', 100.00, 150.00, 16),
(1304, 'صنيه', 'S00001304', 150, 757, '2025-12-29 00:43:59', '2025-12-29 00:43:59', 100.00, 150.00, 20),
(1305, 'الفرخه', 'S00001305', 150, 753, '2025-12-29 13:10:53', '2025-12-29 13:10:53', 100.00, 150.00, 14),
(1306, 'ساندوتش', 'S00001306', 150, 652, '2025-12-29 19:39:02', '2025-12-29 19:39:02', 100.00, 150.00, 7),
(1307, 'ساندوتش', 'S00001307', 150, 653, '2025-12-29 19:39:51', '2025-12-29 19:39:51', 100.00, 150.00, 11),
(1308, 'ساندوتش', 'S00001308', 150, 758, '2025-12-29 19:41:58', '2025-12-29 19:41:58', 100.00, 150.00, 16),
(1309, 'ساندوتش', 'S00001309', 150, 759, '2025-12-29 19:42:57', '2025-12-29 19:42:57', 100.00, 150.00, 7),
(1310, 'ساندوتش', 'S00001310', 150, 760, '2025-12-29 19:44:14', '2025-12-29 19:44:14', 100.00, 150.00, 7),
(1311, 'ساندوتش', 'S00001311', 150, 761, '2025-12-29 19:46:08', '2025-12-29 19:46:08', 100.00, 150.00, 12),
(1312, 'ساندوتش', 'S00001312', 150, 762, '2025-12-29 19:47:56', '2025-12-29 19:47:56', 100.00, 150.00, 18),
(1313, 'ساندوتش', 'S00001313', 150, 763, '2025-12-29 19:50:03', '2025-12-29 19:50:03', 100.00, 150.00, 13),
(1315, 'ساندوتش', 'S00001315', 150, 765, '2025-12-29 19:52:38', '2025-12-29 19:52:38', 100.00, 150.00, 11),
(1316, 'ربع كيلو', 'S00001316', 150, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22', 100.00, 150.00, 16),
(1317, 'نص كيلو', 'S00001317', 150, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22', 100.00, 150.00, 6),
(1318, 'كيلو', 'S00001318', 150, 594, '2025-12-29 20:00:22', '2025-12-29 20:00:22', 100.00, 150.00, 2),
(1319, 'ربع كيلو', 'S00001319', 150, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10', 100.00, 150.00, 9),
(1320, 'نص كيلو', 'S00001320', 150, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10', 100.00, 150.00, 2),
(1321, 'كيلو', 'S00001321', 150, 596, '2025-12-29 20:01:10', '2025-12-29 20:01:10', 100.00, 150.00, 20),
(1322, 'ربع فرخة', 'S00001322', 150, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39', 100.00, 150.00, 14),
(1323, 'نص فرخة', 'S00001323', 150, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39', 100.00, 150.00, 8),
(1324, 'فرخة كاملة', 'S00001324', 150, 597, '2025-12-29 20:01:39', '2025-12-29 20:01:39', 100.00, 150.00, 20),
(1325, 'ربع فرخة ورك', 'S00001325', 150, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35', 100.00, 150.00, 15),
(1326, 'ربع فرخة صدر', 'S00001326', 150, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35', 100.00, 150.00, 13),
(1327, 'نص فرخة', 'S00001327', 150, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35', 100.00, 150.00, 19),
(1328, 'فرخة كاملة', 'S00001328', 150, 599, '2025-12-29 20:05:35', '2025-12-29 20:05:35', 100.00, 150.00, 19),
(1329, 'ربع كيلو', 'S00001329', 150, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23', 100.00, 150.00, 14),
(1330, 'نص كيلو', 'S00001330', 150, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23', 100.00, 150.00, 12),
(1331, 'كيلو', 'S00001331', 150, 603, '2025-12-29 20:07:23', '2025-12-29 20:07:23', 100.00, 150.00, 20),
(1332, 'كيلو', 'S00001332', 150, 766, '2025-12-29 20:10:18', '2025-12-29 20:10:18', 100.00, 150.00, 4),
(1333, 'كيلو', 'S00001333', 150, 767, '2025-12-29 20:11:39', '2025-12-29 20:11:39', 100.00, 150.00, 17),
(1336, 'صغير', 'S00001336', 150, 768, '2025-12-29 20:30:10', '2025-12-29 20:30:10', 100.00, 150.00, 13);
INSERT INTO `product_sizes` (`id`, `size`, `barcode`, `price`, `product_id`, `created_at`, `updated_at`, `Purchase_price`, `selling_price`, `quantity`) VALUES
(1337, 'صغير', 'S00001337', 150, 769, '2025-12-29 20:41:08', '2025-12-29 20:41:08', 100.00, 150.00, 15),
(1346, 'كبير', 'S00001346', 150, 334, '2025-12-29 23:56:25', '2025-12-29 23:56:25', 100.00, 150.00, 14),
(1347, 'كبير', 'S00001347', 150, 770, '2025-12-29 23:57:12', '2025-12-29 23:57:12', 100.00, 150.00, 7),
(1351, 'كبير', 'S00001351', 150, 335, '2025-12-29 23:58:39', '2025-12-29 23:58:39', 100.00, 150.00, 10),
(1352, 'كبير', 'S00001352', 150, 336, '2025-12-29 23:58:58', '2025-12-29 23:58:58', 100.00, 150.00, 9),
(1353, 'كبير', 'S00001353', 150, 771, '2025-12-30 00:05:07', '2025-12-30 00:05:07', 100.00, 150.00, 13),
(1354, 'كبير', 'S00001354', 150, 330, '2025-12-30 15:01:40', '2025-12-30 15:01:40', 100.00, 150.00, 18),
(1355, 'كبير', 'S00001355', 150, 332, '2025-12-30 15:02:09', '2025-12-30 15:02:09', 100.00, 150.00, 11),
(1356, 'كبير', 'S00001356', 150, 333, '2025-12-30 15:03:32', '2025-12-30 15:03:32', 100.00, 150.00, 20),
(1357, 'ساندوتش', 'S00001357', 150, 764, '2025-12-30 20:07:34', '2025-12-30 20:07:34', 100.00, 150.00, 9),
(1358, 'صواني', 'S00001358', 150, 622, '2025-12-31 00:44:30', '2025-12-31 00:44:30', 100.00, 150.00, 2),
(1359, 'صنية', 'S00001359', 150, 623, '2025-12-31 00:47:47', '2025-12-31 00:47:47', 100.00, 150.00, 3),
(1360, 'صنية', 'S00001360', 150, 624, '2025-12-31 00:51:43', '2025-12-31 00:51:43', 100.00, 150.00, 7),
(1361, 'صنية', 'S00001361', 150, 625, '2025-12-31 00:56:44', '2025-12-31 00:56:44', 100.00, 150.00, 9),
(1362, 'Default', NULL, 0, 272, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 20),
(1363, 'Default', NULL, 0, 273, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 15),
(1364, 'Default', NULL, 0, 274, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 13),
(1365, 'Default', NULL, 0, 275, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 19),
(1366, 'Default', NULL, 0, 276, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 16),
(1367, 'Default', NULL, 0, 286, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 2),
(1368, 'Default', NULL, 0, 356, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 3),
(1369, 'Default', NULL, 0, 357, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 8),
(1370, 'Default', NULL, 0, 358, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 12),
(1371, 'Default', NULL, 0, 359, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 13),
(1372, 'Default', NULL, 0, 360, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 8),
(1373, 'Default', NULL, 0, 361, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 20),
(1374, 'Default', NULL, 0, 362, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 18),
(1375, 'Default', NULL, 0, 363, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 9),
(1376, 'Default', NULL, 0, 364, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 10),
(1377, 'Default', NULL, 0, 365, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 3),
(1378, 'Default', NULL, 0, 366, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 6),
(1379, 'Default', NULL, 0, 367, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 20),
(1380, 'Default', NULL, 0, 368, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 3),
(1381, 'Default', NULL, 0, 369, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 12),
(1382, 'Default', NULL, 0, 370, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 11),
(1383, 'Default', NULL, 0, 371, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 17),
(1384, 'Default', NULL, 0, 376, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 11),
(1385, 'Default', NULL, 0, 377, '2026-05-12 22:33:21', '2026-05-12 22:33:21', 100.00, 150.00, 4),
(1390, 'Standard', '2100000013906', 30, 772, '2026-05-13 18:19:51', '2026-05-13 18:19:51', 25.00, 30.00, 6),
(1391, 'صغير', '2100000013913', NULL, 380, '2026-05-15 11:39:28', '2026-05-15 11:39:28', 100.00, 150.00, 20),
(1392, 'وسط', '2100000013920', NULL, 380, '2026-05-15 11:39:28', '2026-05-15 11:39:28', 200.00, 220.00, 20),
(1393, 'كبير', '2100000013937', NULL, 380, '2026-05-15 11:39:28', '2026-05-15 11:39:28', 230.00, 250.00, 1),
(1394, 'صغير', '2100000013944', NULL, 379, '2026-05-15 11:43:26', '2026-05-15 11:43:26', 100.00, 150.00, 4),
(1395, 'وسط', '2100000013951', NULL, 379, '2026-05-15 11:43:26', '2026-05-15 11:43:26', 120.00, 145.00, 18),
(1396, 'كبير', '2100000013968', NULL, 379, '2026-05-15 11:43:26', '2026-05-15 11:43:26', 130.00, 150.00, 16),
(1397, 'صغير', '2100000013975', NULL, 774, '2026-05-15 11:48:28', '2026-05-15 11:48:28', 3900.00, 4200.00, 4),
(1398, 'وسط', '2100000013982', NULL, 774, '2026-05-15 11:48:28', '2026-05-15 11:48:28', 4500.00, 4900.00, 13),
(1399, 'كبير', '2100000013999', NULL, 774, '2026-05-15 11:48:28', '2026-05-15 11:48:28', 5000.00, 5500.00, 11),
(1401, 'Default', '2100000014019', NULL, 378, '2026-05-15 11:51:06', '2026-05-15 11:51:06', 100.00, 150.00, 15),
(1411, 'صغير', '2100000014118', NULL, 773, '2026-05-21 06:04:43', '2026-05-21 06:04:43', 100.00, 110.00, 10),
(1412, 'وسط', '2100000014125', NULL, 773, '2026-05-21 06:04:43', '2026-05-21 06:04:43', 110.00, 120.00, 10),
(1413, 'كبير', '2100000014132', NULL, 773, '2026-05-21 06:04:43', '2026-05-21 06:35:26', 120.00, 130.00, 8),
(1414, 'صغير', '2100000014149', NULL, 775, '2026-05-23 12:35:23', '2026-05-23 12:35:23', 100.00, 105.00, 15),
(1415, 'وسط', '2100000014156', NULL, 775, '2026-05-23 12:35:24', '2026-05-23 12:35:24', 110.00, 115.00, 10),
(1416, 'كبير', '2100000014163', NULL, 775, '2026-05-23 12:35:24', '2026-05-23 12:35:24', 120.00, 125.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoices`
--

CREATE TABLE `purchase_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('paid','partial','unpaid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_invoices`
--

INSERT INTO `purchase_invoices` (`id`, `user_id`, `supplier_id`, `invoice_number`, `total_amount`, `paid_amount`, `due_date`, `notes`, `status`, `created_at`, `updated_at`, `branch_id`) VALUES
(5, 71, 1, '123', 1469.90, 1000.00, '2026-05-12', 'فاتورة شاى', 'partial', '2026-05-12 18:25:06', '2026-05-12 18:25:06', 4),
(6, 71, 1, '111', 55.00, 49.98, '2026-05-12', 'aaa', 'partial', '2026-05-12 18:37:22', '2026-05-12 18:37:22', NULL),
(7, 71, 1, '99', 55500.00, 55000.00, '2026-05-12', 'سجاد', 'partial', '2026-05-12 18:45:11', '2026-05-12 18:45:11', NULL),
(8, 71, 2, '145', 1155.00, 1155.00, '2026-05-21', 'تتتتتتتتتتتتتتتتت', 'paid', '2026-05-21 08:01:02', '2026-05-21 08:01:02', NULL);

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

--
-- Dumping data for table `purchase_invoice_items`
--

INSERT INTO `purchase_invoice_items` (`id`, `purchase_invoice_id`, `inventory_id`, `quantity`, `unit_price`, `total`, `created_at`, `updated_at`) VALUES
(4, 5, 322, 10.000, 146.99, 1469.90, '2026-05-12 18:25:06', '2026-05-12 18:25:06'),
(5, 6, 3, 1.000, 55.00, 55.00, '2026-05-12 18:37:22', '2026-05-12 18:37:22'),
(6, 7, 108, 111.000, 500.00, 55500.00, '2026-05-12 18:45:11', '2026-05-12 18:45:11'),
(7, 8, 2, 15.000, 77.00, 1155.00, '2026-05-21 08:01:02', '2026-05-21 08:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `po_number` varchar(191) NOT NULL,
  `po_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `status` enum('draft','sent','partial_received','received','cancelled') NOT NULL DEFAULT 'draft',
  `subtotal` decimal(14,3) NOT NULL DEFAULT 0.000,
  `discount` decimal(14,3) NOT NULL DEFAULT 0.000,
  `tax` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total` decimal(14,3) NOT NULL DEFAULT 0.000,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `user_id`, `supplier_id`, `purchase_request_id`, `po_number`, `po_date`, `expected_date`, `status`, `subtotal`, `discount`, `tax`, `total`, `notes`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 71, 1, NULL, 'PO-20260418235707', '2026-04-18', '2026-04-20', 'received', 999.000, 11.000, 1.000, 989.000, 'dddddddddddddddd', '2026-04-18 21:57:07', '2026-04-18 22:16:22', NULL),
(2, 71, 3, 1, 'PO-20260424122745', '2026-04-24', '2026-04-25', 'draft', 396.000, 5.000, 5.000, 396.000, 'dddddddd', '2026-04-24 09:27:45', '2026-04-24 09:27:45', NULL);

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
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `raw_material_id`, `unit_id`, `quantity`, `received_quantity`, `unit_price`, `total`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 3.000, 3.000, 333.000, 999.000, 'jjjjjjjjjjj', '2026-04-18 21:57:07', '2026-04-18 22:16:22'),
(2, 2, 3, 1, 6.000, 0.000, 66.000, 396.000, 'welcome', '2026-04-24 09:27:46', '2026-04-24 09:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(191) NOT NULL,
  `request_date` date NOT NULL,
  `status` enum('draft','pending','approved','rejected','converted') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
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
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_request_items`
--

INSERT INTO `purchase_request_items` (`id`, `purchase_request_id`, `raw_material_id`, `unit_id`, `requested_quantity`, `approved_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1.000, 1.000, 'jjjjjjjjjjj', '2026-04-18 21:54:31', '2026-04-18 22:04:09'),
(2, 2, 2, 1, 22.000, 0.000, 'welcome', '2026-04-20 05:36:00', '2026-04-20 05:36:00');

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
  `name` varchar(191) NOT NULL,
  `sku` varchar(191) DEFAULT NULL,
  `barcode` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
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
(1, 71, 1, 1, 1, 'agent', '123', '1111', 'ffffffffffffffffffffffffffff', 333.000, 333.000, 333.000, 5.000, 55.000, 53.000, 1, 1, '2026-04-18 21:07:03', '2026-04-19 21:45:25'),
(2, 71, 2, 1, 1, 'meat', '123', '1245', 'gggggggggggggggg', 77.000, 50.000, 50.000, 10.000, 10.000, 10.000, 1, 1, '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 71, 2, 2, 1, 'aaa', '111', '11111111', 'ccccccccccccccccccccc', 55.000, 66.000, 222.000, 2.000, 2.000, 2.000, 1, 1, '2026-04-24 09:21:48', '2026-04-24 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `output_raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `yield_quantity` decimal(14,3) NOT NULL DEFAULT 1.000,
  `yield_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `output_raw_material_id`, `name`, `yield_quantity`, `yield_unit_id`, `notes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 71, 1, 'agent', 15.000, 1, 'Welcome', 1, '2026-04-19 21:45:25', '2026-04-19 21:45:25'),
(2, 71, 2, 'meat', 1.000, 1, 'aaaaaaaaaaa', 1, '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 71, 3, 'aaa', 1.000, 1, 'Welcome', 1, '2026-04-24 09:21:48', '2026-04-24 09:21:48');

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
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_items`
--

INSERT INTO `recipe_items` (`id`, `recipe_id`, `raw_material_id`, `unit_id`, `quantity`, `waste_percent`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 10.000, 3.00, 'Hello', '2026-04-19 21:45:25', '2026-04-19 21:45:25'),
(2, 2, 1, 1, 3.000, 1.00, 'Hello', '2026-04-20 05:35:25', '2026-04-20 05:35:25'),
(3, 3, 1, 1, 22.000, 5.00, 'Hello', '2026-04-24 09:21:48', '2026-04-24 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
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
-- Table structure for table `salary_m`
--

CREATE TABLE `salary_m` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `penalties` decimal(10,2) DEFAULT 0.00,
  `Salary_advance` decimal(10,2) DEFAULT 0.00,
  `Rewards` decimal(10,2) DEFAULT 0.00,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bjqjzEcYGSg9iS2PEhAo3b6vemS4sePEHKlIMwjX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibnpkNEZPcXhRakFHdmRRdmFXSzN0M1UwN0ZpMURkZURsdTBNc1l6dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779362600),
('hj0UVfyJ9Z84K1K6J500PUH4cIghNfSCRtOmlcoJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:151.0) Gecko/20100101 Firefox/151.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnllN0F1RFR0UWhUUTFvMEVBQ2hlS3k3NDI5dnN0WVBjUjVoT0djaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779471869),
('oP1VrR4AThWQhIVyNPYYEJEjPtNQrrPGkTkaK8fq', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnBRcjZRV3VDOHRzb0lEVkYzTWV6RlNoc1NjWm8yYkpGZjJRbDd5WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9icmFuY2gtY3JlYXRpb24tcmVxdWVzdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1779364738),
('S7uCZRlmEkVZxSVcE3WwtHvGaVk1g100lkOI3rRu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:151.0) Gecko/20100101 Firefox/151.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTE9lbG9oUXBHRmlFVDNmRldzSWhFYUcyWjRJc0NMcGhJSDlET2ZiMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779471866),
('vxlNzdlOcPp9SPJ2nI60aESZJguRQ0BB1IMJCOgN', 71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiV1RIOEtNaGNFdmZQdHNqWk5qazdCWUFmVUJ3a1p4VmhTQkllMTBhdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGFmZiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjcxO3M6MTE6Imx3NDg5MDQ0MTU5IjthOjA6e31zOjEyOiJsdzM4NTk1MjY5MzIiO3M6NDoiY2FzaCI7czoxMjoibHc0MTA1NzUwMzc4IjtzOjg6InRha2Vhd2F5IjtzOjU6ImFsZXJ0IjthOjA6e319', 1779575547);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
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
(1615, 97, 'thirdtextcolor', NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01'),
(1616, 98, 'logo', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1617, 98, 'name', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1618, 98, 'description', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1619, 98, 'phone', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1620, 98, 'whatsapp', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1621, 98, 'address', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1622, 98, 'theme', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1623, 98, 'status', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1624, 98, 'facebook', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1625, 98, 'instagram', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1626, 98, 'copyright', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1627, 98, 'maincolor', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1628, 98, 'curency', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1629, 98, 'secondcolor', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1630, 98, 'maintextcolor', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1631, 98, 'secoundtextcolor', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17'),
(1632, 98, 'thirdtextcolor', NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17');

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
  `status` enum('active','paused','closed') NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expenses_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sent_to_manager` decimal(12,2) NOT NULL DEFAULT 0.00,
  `carryover_to_next_shift` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payments_breakdown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payments_breakdown`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `user_id`, `branch_id`, `starting_cash`, `expected_cash`, `ending_cash`, `cash_difference`, `start_time`, `end_time`, `status`, `notes`, `closed_by`, `created_at`, `updated_at`, `expenses_total`, `sent_to_manager`, `carryover_to_next_shift`, `payments_breakdown`) VALUES
(1, 94, 2, 150.00, 150.00, 150.00, 0.00, '2026-04-18 00:30:00', '2026-04-18 00:54:35', 'closed', 'ييييييييييييييييييييييي', 71, '2026-04-21 22:30:56', '2026-04-17 22:54:35', 0.00, 0.00, 0.00, NULL),
(2, 71, 1, 155.00, 166.00, 316.00, 150.00, '2026-04-18 00:42:00', '2026-04-18 00:51:16', 'closed', 'gggggggggggggggggggg', 71, '2026-04-23 22:00:00', '2026-04-17 22:51:17', 0.00, 0.00, 0.00, NULL),
(3, 95, 1, 55.00, 55.00, 110.00, 55.00, '2026-04-18 00:56:00', '2026-04-18 00:57:12', 'closed', 'كككككككككككككككككك', 71, '2026-04-17 22:56:44', '2026-04-17 22:57:12', 0.00, 0.00, 0.00, NULL),
(4, 71, 1, 1500.00, 1500.00, 2100.00, 0.00, '2026-04-24 21:44:01', '2026-04-24 21:48:53', 'closed', NULL, NULL, '2026-04-24 18:44:01', '2026-04-24 18:48:53', 0.00, 0.00, 0.00, NULL),
(5, 71, 1, 3000.00, 3000.00, 5500.00, 2500.00, '2026-04-24 21:54:23', '2026-04-24 21:54:59', 'closed', NULL, 71, '2026-04-24 18:54:23', '2026-04-24 18:54:59', 0.00, 0.00, 0.00, NULL),
(6, 71, 1, 9500.00, 9500.00, 6000.00, -3500.00, '2026-04-24 22:40:26', '2026-04-24 22:42:15', 'closed', NULL, 71, '2026-04-24 19:40:26', '2026-04-24 19:42:15', 0.00, 0.00, 0.00, NULL),
(7, 71, 1, 36541.00, 36541.00, 3698.00, -32843.00, '2026-04-24 23:08:36', '2026-04-24 23:11:56', 'closed', NULL, 71, '2026-04-24 20:08:36', '2026-04-24 20:11:56', 0.00, 0.00, 0.00, NULL),
(8, 71, 1, 9874.00, 9874.00, 99999.00, 90125.00, '2026-04-24 23:12:14', '2026-04-24 23:37:09', 'closed', NULL, 71, '2026-04-24 20:12:14', '2026-04-24 20:37:09', 0.00, 0.00, 0.00, NULL),
(9, 71, 1, 98745.00, 98745.00, 654123.00, 555378.00, '2026-04-25 14:07:14', '2026-04-25 14:08:39', 'closed', NULL, 71, '2026-04-25 11:07:14', '2026-04-25 11:08:39', 0.00, 0.00, 0.00, NULL),
(10, 96, 1, 9999.00, 9999.00, 5555.00, -4444.00, '2026-04-25 15:41:42', '2026-04-25 15:59:19', 'closed', NULL, 96, '2026-04-25 12:41:43', '2026-04-25 12:59:20', 0.00, 0.00, 0.00, NULL),
(11, 96, 1, 14785.00, 14785.00, 987456.00, 972671.00, '2026-04-25 17:22:50', '2026-04-25 17:36:45', 'closed', NULL, 96, '2026-04-25 14:22:50', '2026-04-25 14:36:45', 0.00, 0.00, 0.00, NULL),
(12, 71, 1, 100.00, 100.00, 150.00, 50.00, '2026-04-25 18:04:57', '2026-04-25 18:06:06', 'closed', NULL, 71, '2026-04-25 15:04:57', '2026-04-25 15:06:06', 0.00, 0.00, 0.00, NULL),
(13, 71, 1, 100.00, 560.00, 500.00, -60.00, '2026-04-25 20:50:09', '2026-04-25 20:56:51', 'closed', NULL, 71, '2026-04-25 17:50:09', '2026-04-25 17:56:51', 0.00, 0.00, 0.00, NULL),
(14, 71, 1, 500.00, 880.00, 880.00, 0.00, '2026-04-25 21:31:06', '2026-04-25 21:52:47', 'closed', '', 71, '2026-04-25 18:31:06', '2026-04-25 18:52:47', 0.00, 0.00, 0.00, NULL),
(15, 96, 1, 100.00, 110.00, 110.00, 0.00, '2026-04-25 22:13:35', '2026-04-25 22:17:13', 'closed', '', 96, '2026-04-25 19:13:35', '2026-04-25 19:17:13', 0.00, 0.00, 0.00, NULL),
(16, 96, 1, 10.00, 10.00, 10.00, 0.00, '2026-04-25 22:27:56', '2026-04-25 23:06:14', 'closed', NULL, 96, '2026-04-25 19:27:56', '2026-04-25 20:06:14', 0.00, 0.00, 0.00, NULL),
(17, 71, 1, 155.00, 130.00, 130.00, 0.00, '2026-04-26 21:25:48', '2026-04-26 22:22:59', 'closed', '', 71, '2026-04-26 18:25:48', '2026-04-26 19:22:59', 25.00, 150.00, 130.00, NULL),
(18, 96, 1, 130.00, 20.00, 20.00, 0.00, '2026-04-26 22:53:09', '2026-04-26 23:05:32', 'closed', '', 96, '2026-04-26 19:53:09', '2026-04-26 20:05:33', 10.00, 100.00, 20.00, NULL),
(19, 96, 1, 20.00, 20.00, 20.00, 0.00, '2026-04-26 23:16:40', '2026-04-26 23:17:01', 'closed', NULL, 96, '2026-04-26 20:16:40', '2026-04-26 20:17:01', 0.00, 0.00, 20.00, NULL),
(21, 71, 1, 20.00, 20.00, 20.00, 0.00, '2026-04-27 20:18:42', '2026-04-27 20:19:24', 'closed', '', 71, '2026-04-27 17:18:42', '2026-04-27 17:19:25', 0.00, 0.00, 20.00, NULL),
(22, 71, 1, 20.00, 30.00, 30.00, 0.00, '2026-04-27 20:44:15', '2026-04-27 20:45:59', 'closed', '', 71, '2026-04-27 17:44:15', '2026-04-27 17:45:59', 10.00, 100.00, 30.00, NULL),
(23, 96, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-02 16:29:16', '2026-05-02 16:29:36', 'closed', NULL, 96, '2026-05-02 13:29:16', '2026-05-02 13:29:36', 0.00, 0.00, 30.00, NULL),
(24, 96, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-02 16:35:31', '2026-05-02 16:37:50', 'closed', '', 96, '2026-05-02 13:35:31', '2026-05-02 13:37:50', 0.00, 0.00, 30.00, NULL),
(25, 96, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-02 17:40:16', '2026-05-02 17:41:04', 'closed', NULL, 96, '2026-05-02 14:40:16', '2026-05-02 14:41:04', 0.00, 0.00, 30.00, NULL),
(26, 71, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-07 08:10:10', '2026-05-07 08:20:11', 'closed', '', 71, '2026-05-07 05:10:10', '2026-05-07 05:20:11', 0.00, 0.00, 30.00, NULL),
(27, 71, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-07 08:22:30', '2026-05-07 08:22:57', 'closed', '', 71, '2026-05-07 05:22:30', '2026-05-07 05:22:57', 0.00, 0.00, 30.00, NULL),
(28, 71, 1, 30.00, 30.00, 30.00, 0.00, '2026-05-07 08:43:15', '2026-05-07 08:43:39', 'closed', '', 71, '2026-05-07 05:43:15', '2026-05-07 05:43:39', 0.00, 0.00, 30.00, NULL),
(29, 71, 1, 30.00, 180.00, 180.00, 0.00, '2026-05-07 08:45:52', '2026-05-07 12:41:37', 'closed', '', 71, '2026-05-07 05:45:52', '2026-05-07 09:41:37', 0.00, 0.00, 180.00, NULL),
(30, 71, 1, 10.00, 20.00, 20.00, 0.00, '2026-05-07 12:49:29', '2026-05-08 13:43:16', 'closed', '', 71, '2026-05-07 09:49:29', '2026-05-08 10:43:16', 0.00, 0.00, 20.00, NULL),
(31, 71, 1, 25.00, 35.00, 35.00, 0.00, '2026-05-08 13:46:00', '2026-05-08 13:54:25', 'closed', '', 71, '2026-05-08 10:46:00', '2026-05-08 10:54:25', 0.00, 0.00, 35.00, NULL),
(32, 71, 1, 35.00, 235.00, 235.00, 0.00, '2026-05-08 13:57:00', '2026-05-08 14:08:49', 'closed', '', 71, '2026-05-08 10:57:00', '2026-05-08 11:08:49', 0.00, 0.00, 235.00, NULL),
(33, 71, 1, 50.00, 50.00, 50.00, 0.00, '2026-05-10 10:43:03', '2026-05-10 10:44:50', 'closed', '', 71, '2026-05-10 07:43:03', '2026-05-10 07:44:50', 0.00, 0.00, 50.00, NULL),
(34, 71, 1, 50.00, 50.00, 50.00, 0.00, '2026-05-10 14:36:27', '2026-05-10 14:39:06', 'closed', '', 71, '2026-05-10 11:36:27', '2026-05-10 11:39:06', 0.00, 0.00, 50.00, NULL),
(35, 71, 1, 50.00, 50.00, 50.00, 0.00, '2026-05-10 14:39:49', '2026-05-10 15:08:34', 'closed', '', 71, '2026-05-10 11:39:49', '2026-05-10 12:08:34', 0.00, 0.00, 50.00, NULL),
(36, 71, 1, 50.00, 210.00, 210.00, 0.00, '2026-05-10 15:09:14', '2026-05-10 16:15:00', 'closed', '', 71, '2026-05-10 12:09:14', '2026-05-10 13:15:00', 0.00, 0.00, 210.00, NULL),
(37, 71, 1, 55.00, 794.50, 794.50, 0.00, '2026-05-11 06:28:09', '2026-05-15 20:13:51', 'closed', '', 71, '2026-05-11 03:28:09', '2026-05-15 17:13:51', 0.00, 0.00, 794.50, NULL),
(38, 71, 1, 794.50, 1094.50, 1094.50, 0.00, '2026-05-15 20:14:45', '2026-05-15 20:17:35', 'closed', '', 71, '2026-05-15 17:14:45', '2026-05-15 17:17:35', 0.00, 0.00, 1094.50, NULL),
(39, 71, 1, 1094.50, 5924.50, 5924.50, 0.00, '2026-05-15 21:38:19', '2026-05-16 01:02:02', 'closed', '', 71, '2026-05-15 18:38:19', '2026-05-15 22:02:02', 0.00, 0.00, 5924.50, '\"{\\\"Vodafone Cash\\\":450,\\\"cash\\\":4380,\\\"InstaPay\\\":30}\"'),
(40, 71, 1, 5924.50, 5924.50, 5924.50, 0.00, '2026-05-16 01:13:47', '2026-05-16 01:14:07', 'closed', '', 71, '2026-05-15 22:13:47', '2026-05-15 22:14:07', 0.00, 0.00, 5924.50, '\"[]\"'),
(41, 71, 1, 5924.50, 9734.50, 9734.50, 0.00, '2026-05-16 14:18:46', '2026-05-16 14:28:05', 'closed', '', 71, '2026-05-16 11:18:46', '2026-05-16 11:28:06', 500.00, 7000.00, 9734.50, '\"{\\\"InstaPay\\\":460,\\\"Vodafone Cash\\\":310,\\\"cash\\\":11000}\"'),
(42, 71, 1, 10000.00, 11000.00, 11000.00, 0.00, '2026-05-16 14:28:38', '2026-05-16 14:35:43', 'closed', '', 71, '2026-05-16 11:28:38', '2026-05-16 11:35:43', 40.00, 50.00, 11000.00, '\"{\\\"InstaPay\\\":500,\\\"Vodafone Cash\\\":90,\\\"cash\\\":1000}\"'),
(43, 71, 1, 11000.00, 15190.00, 15190.00, 0.00, '2026-05-16 14:36:02', '2026-05-16 14:44:29', 'closed', '', 71, '2026-05-16 11:36:02', '2026-05-16 11:44:29', 10.00, 0.00, 15190.00, '\"{\\\"cash\\\":4200,\\\"Vodafone Cash\\\":4200,\\\"InstaPay\\\":4200}\"'),
(44, 71, 1, 500.00, 1080.00, 1080.00, 0.00, '2026-05-16 22:21:16', '2026-05-18 14:10:18', 'closed', NULL, 71, '2026-05-16 19:21:16', '2026-05-18 11:10:18', 0.00, 0.00, 1080.00, '\"{\\\"\\\\u063a\\\\u064a\\\\u0631 \\\\u0645\\\\u0639\\\\u0631\\\\u0648\\\\u0641\\\":150,\\\"cash\\\":580,\\\"InstaPay\\\":100,\\\"Vodafone Cash\\\":340}\"'),
(45, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:10:58', '2026-05-18 14:11:27', 'closed', '', 71, '2026-05-18 11:10:58', '2026-05-18 11:11:27', 0.00, 0.00, 1080.00, '\"[]\"'),
(46, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:13:56', '2026-05-18 14:18:48', 'closed', NULL, 71, '2026-05-18 11:13:56', '2026-05-18 11:18:48', 0.00, 0.00, 1080.00, '\"[]\"'),
(47, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:19:44', '2026-05-18 14:20:00', 'closed', NULL, 71, '2026-05-18 11:19:44', '2026-05-18 11:20:00', 0.00, 0.00, 1080.00, '\"[]\"'),
(48, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:20:28', '2026-05-18 14:20:42', 'closed', NULL, 71, '2026-05-18 11:20:28', '2026-05-18 11:20:42', 0.00, 0.00, 1080.00, '\"[]\"'),
(49, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:23:04', '2026-05-18 14:23:20', 'closed', NULL, 71, '2026-05-18 11:23:04', '2026-05-18 11:23:20', 0.00, 0.00, 1080.00, '\"[]\"'),
(50, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:24:36', '2026-05-18 14:25:04', 'closed', NULL, 71, '2026-05-18 11:24:36', '2026-05-18 11:25:04', 0.00, 0.00, 1080.00, '\"[]\"'),
(51, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:27:58', '2026-05-18 14:28:13', 'closed', NULL, 71, '2026-05-18 11:27:58', '2026-05-18 11:28:13', 0.00, 0.00, 1080.00, '\"[]\"'),
(52, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:31:29', '2026-05-18 14:35:58', 'closed', NULL, 71, '2026-05-18 11:31:29', '2026-05-18 11:35:58', 0.00, 0.00, 1080.00, '\"[]\"'),
(53, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:42:38', '2026-05-18 14:42:55', 'closed', NULL, 71, '2026-05-18 11:42:38', '2026-05-18 11:42:55', 0.00, 0.00, 1080.00, '\"[]\"'),
(54, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:45:33', '2026-05-18 14:45:51', 'closed', '', 71, '2026-05-18 11:45:33', '2026-05-18 11:45:51', 0.00, 0.00, 1080.00, '\"[]\"'),
(55, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:46:23', '2026-05-18 14:46:41', 'closed', '', 71, '2026-05-18 11:46:23', '2026-05-18 11:46:41', 0.00, 0.00, 1080.00, '\"[]\"'),
(56, 71, 1, 1080.00, 1080.00, 1080.00, 0.00, '2026-05-18 14:47:11', '2026-05-18 14:47:28', 'closed', NULL, 71, '2026-05-18 11:47:11', '2026-05-18 11:47:28', 0.00, 0.00, 1080.00, '\"[]\"'),
(57, 71, 1, 1000.00, 1000.00, NULL, 0.00, '2026-05-20 10:02:40', NULL, 'active', NULL, NULL, '2026-05-20 07:02:40', '2026-05-20 07:02:40', 0.00, 0.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift_expenses`
--

CREATE TABLE `shift_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `expense_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `receipt_image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shift_expenses`
--

INSERT INTO `shift_expenses` (`id`, `shift_id`, `user_id`, `branch_id`, `title`, `amount`, `expense_date`, `status`, `approved_by`, `notes`, `receipt_image`, `created_at`, `updated_at`) VALUES
(1, 17, 71, 1, 'مصروفات توصيل', 25.00, '2026-04-26 21:58:51', 'approved', 71, 'تم ارسال طلب ', NULL, '2026-04-26 18:58:51', '2026-04-26 18:58:51'),
(2, 18, 96, 1, 'مصروفات توصيل ', 10.00, '2026-04-26 22:55:23', 'approved', 96, 'مصروفات توصيل', NULL, '2026-04-26 19:55:23', '2026-04-26 19:55:23'),
(3, 22, 71, 1, 'توصيل', 10.00, '2026-04-27 20:44:52', 'approved', 71, 'توصيل ', NULL, '2026-04-27 17:44:52', '2026-04-27 17:44:52'),
(4, 41, 71, 1, 'مصروفات توصيل', 500.00, '2026-05-16 14:24:03', 'approved', 71, '', NULL, '2026-05-16 11:24:03', '2026-05-16 11:24:03'),
(5, 42, 71, 1, 'توصيل', 40.00, '2026-05-16 14:31:31', 'approved', 71, '', NULL, '2026-05-16 11:31:31', '2026-05-16 11:31:31'),
(6, 43, 71, 1, 'تتت', 10.00, '2026-05-16 14:38:08', 'approved', 71, '', NULL, '2026-05-16 11:38:08', '2026-05-16 11:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
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
  `name` varchar(191) NOT NULL,
  `url` varchar(191) NOT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(191) NOT NULL,
  `BirthDay` date DEFAULT NULL,
  `Academic_qualification` varchar(191) DEFAULT NULL,
  `Start_date` datetime DEFAULT NULL,
  `End_date` datetime DEFAULT NULL,
  `attach_File` varchar(191) DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `Number_of_days` int(11) DEFAULT NULL,
  `Number_of_hours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `Name`, `BirthDay`, `Academic_qualification`, `Start_date`, `End_date`, `attach_File`, `Salary`, `user_id`, `created_by`, `created_at`, `updated_at`, `mobile`, `Number_of_days`, `Number_of_hours`) VALUES
(1, 'aaaaaaa', '2025-01-03', 'aaaaaaaaaaaaaaaaa', '2026-05-03 14:45:00', '2026-05-30 14:45:00', '1777808732.png', 66.00, 71, NULL, '2026-05-03 08:45:32', '2026-05-23 19:21:33', '1236985214', 2, 5),
(2, 'aaaaaaa', '2026-05-13', 'شششششششش', '2026-05-13 22:37:00', '2026-05-30 22:37:00', '1778701050.jpeg', 66.00, 71, NULL, '2026-05-13 16:37:30', '2026-05-23 19:28:20', '01236985214', 66, 150),
(3, 'احمد', NULL, NULL, '2026-05-01 01:04:00', '2026-05-30 01:04:00', NULL, 9500.00, 71, NULL, '2026-05-23 19:10:45', '2026-05-23 19:32:27', '0123698521455', 10, 100);

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `count_number` varchar(191) NOT NULL,
  `count_date` date NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'full',
  `status` enum('draft','counting','approved','cancelled') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
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
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_count_items`
--

INSERT INTO `stock_count_items` (`id`, `stock_count_id`, `inventory_id`, `system_quantity`, `physical_quantity`, `difference_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3.000, 10.000, 7.000, 'welcome', '2026-04-19 19:19:56', '2026-04-19 19:19:56'),
(2, 1, 1, 3.000, 1.000, -2.000, 'welcome 2', '2026-04-19 19:19:56', '2026-04-19 19:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `receipt_image` varchar(191) DEFAULT NULL,
  `price_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','active','expired','cancelled','rejected') NOT NULL DEFAULT 'pending',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `package_id`, `payment_method_id`, `phone`, `receipt_image`, `price_paid`, `starts_at`, `ends_at`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 71, 11, 1, '+201025570206', NULL, 0.00, '2026-04-20 22:51:48', '2026-07-30 21:51:48', 'active', 1, '2026-04-21 00:46:05', '2026-04-20 22:51:48'),
(7, 71, 8, 1, '+20102557020600', NULL, 1452.00, '2026-04-20 22:57:13', '2026-05-29 23:43:13', 'active', 1, '2026-04-21 00:46:05', '2026-04-20 22:57:13'),
(8, 71, 3, 2, '+201025570206', NULL, 250.00, '2026-04-21 00:46:05', '2026-05-20 23:46:05', 'active', 0, '2026-04-21 00:46:05', '2026-04-21 00:46:05'),
(9, 79, 4, 2, '+201007785293', NULL, 1250.00, '2025-10-12 23:46:05', '2026-06-29 23:46:05', 'active', 1, '2026-04-21 00:46:05', '2026-04-21 00:46:05'),
(10, 71, 5, 1, '+201025570206', NULL, 2500.00, '2026-04-21 00:46:05', '2027-04-16 00:46:05', 'rejected', 0, '2026-04-23 00:46:05', '2026-04-21 00:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `contact_name` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `name`, `contact_name`, `phone`, `email`, `code`, `is_active`, `created_at`, `updated_at`, `balance`) VALUES
(1, 71, 'Ahmed Salah', 'Ahmed', '01236589745', 'a@gmail.com', '123', 1, '2026-04-20 17:53:15', '2026-05-12 18:45:11', 974.92),
(2, 71, 'ffffff', 'gggggggggg', '01236589741', 'F@gmail.com', '145', 1, '2026-04-22 13:09:24', NULL, 0.00),
(3, 71, 'eeeeeeeeeeeeee', 'rrrrrrrrrrrr', '01345967820', 'g@gmail.com', '456', 1, '2026-04-24 12:09:24', NULL, 0.00);

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
  `supplier_item_code` varchar(191) DEFAULT NULL,
  `order_quantity` decimal(12,3) NOT NULL DEFAULT 1.000,
  `conversion_factor` decimal(12,3) NOT NULL DEFAULT 1.000,
  `purchase_cost` decimal(12,3) NOT NULL DEFAULT 0.000,
  `is_preferred` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_raw_materials`
--

INSERT INTO `supplier_raw_materials` (`id`, `user_id`, `supplier_id`, `raw_material_id`, `unit_id`, `supplier_item_code`, `order_quantity`, `conversion_factor`, `purchase_cost`, `is_preferred`, `notes`, `created_at`, `updated_at`) VALUES
(1, 71, 1, 2, 1, '123', 1.000, 1.000, 100.000, 1, 'ضضضضضضضضضضضضضضضضض', '2026-04-20 18:13:23', '2026-04-20 18:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
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
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
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
  `transfer_number` varchar(191) NOT NULL,
  `from_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `status` enum('draft','requested','approved','in_transit','received','cancelled') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
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
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer_request_items`
--

INSERT INTO `transfer_request_items` (`id`, `transfer_request_id`, `raw_material_id`, `unit_id`, `requested_quantity`, `sent_quantity`, `received_quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1.000, 1.000, 1.000, 'welcome', '2026-04-19 18:59:00', '2026-04-19 18:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `type` enum('count','weight','volume') NOT NULL DEFAULT 'count',
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
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `business_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(191) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `store_name`, `business_type_id`, `image`, `status`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `created_at`, `updated_at`, `role`, `created_by`, `branch_id`) VALUES
(2, 'a', 'admin1@admin.com', NULL, 'nanocity1', NULL, NULL, 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, NULL, NULL, 'super_admin', NULL, NULL),
(71, 'Ahmed', 'nanocity@gmail.com', '+201025570206', 'nanocity', NULL, 'admins/P3GfwEIiJHtpgkFOmoWazMeyLAC1sQcNUeWIL2RR.jpg', 1, '$2y$12$YQGtgEMKVo2r4KJQLQg/lOKo/ydI7taK7NYwwOb5zNdApIr8OlqYG', NULL, NULL, NULL, '2025-11-29 12:05:48', '2025-12-21 08:02:37', 'admin', NULL, NULL),
(78, 'b', 'first_pipe@gmeil.com', '+201200860222', 'firstpipe', 2, NULL, 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, '2025-12-02 16:57:29', '2025-12-02 21:30:29', 'admin', NULL, NULL),
(79, 'c', 'enjysakr3@gmail.com', '+201007785293', 'jhazl', 3, NULL, 0, '$2y$12$YQGtgEMKVo2r4KJQLQg/lOKo/ydI7taK7NYwwOb5zNdApIr8OlqYG', NULL, NULL, NULL, '2025-12-02 21:05:50', '2026-01-02 13:23:20', 'admin', NULL, NULL),
(80, 'd', 'diyaareda4@gmail.com', '+201050222277', 'Bunnbeef', NULL, NULL, 0, '$2y$12$30mWbmRv7px82thCdjI2HuJ50VEmNTp37hamqtOQMD8n/PMzqTiQK', NULL, NULL, NULL, '2025-12-03 16:28:42', '2026-01-13 19:30:53', 'admin', NULL, NULL),
(81, 'e', '01021143086@gmail.com', '+201021143086', 'elsultan', NULL, NULL, 1, '$2y$12$dAkMb6Anq25JBt9T.NwRBe8GWpB5MzqAvpZ5oIuonqsW9ynTBz022', NULL, NULL, NULL, '2025-12-07 17:04:44', '2025-12-07 17:07:30', 'admin', NULL, NULL),
(84, 'f', 'grill@gmail.com', '+201027550212', 'grill', NULL, 'admins/11SWaRVCmcqsYUNbpVXlGLuvuPzMbDodt3UZQ7ih.jpg', 0, '$2y$12$fXGoPUzoZhH2tAxGbLX5l.qXyoYh3JfkKA29ZanHfeNPk5zhVeQg6', NULL, NULL, NULL, '2025-12-09 12:17:53', '2026-02-07 09:21:50', 'admin', NULL, NULL),
(85, 'g', 'osheko135@gmail.com', '+201110002119', 'Ella', NULL, 'admins/6JrQ7l1J5J40hqz1RemtgH0MKFfHjC3yFn3hBbQr.png', 1, '$2y$12$OOyEQybZEOsVR.xWLb6YtOcdMKpQ9WqdvW9UTL4TCaRu9VhK9kC1u', NULL, NULL, NULL, '2025-12-11 17:49:07', '2025-12-11 17:49:48', 'admin', NULL, NULL),
(86, 'h', '01507444580@gmail.com', '+201507444580', 'chickn', NULL, NULL, 1, '$2y$12$W05i/gRBvY0LIGOkxMHageD9Sxo/mM7FDiDt9pCQEMUYoItuNpPqu', NULL, NULL, NULL, '2025-12-13 15:59:43', '2025-12-13 16:01:06', 'admin', NULL, NULL),
(87, 'i', 'mahmoudhassen186@gmail.com', '+20⁦+201223023699⁩', 'alwahid', NULL, NULL, 1, '$2y$12$nkxqRFiGuURpZY/tMf.W3O43uP/UxmJDp3PHTIl4wLu9Df4fpD6c2', NULL, NULL, NULL, '2025-12-15 17:47:54', '2026-04-20 20:44:16', 'admin', NULL, NULL),
(94, 'agent33', 'w@gmail.com', NULL, NULL, NULL, NULL, 1, '$2y$12$1SwImodNmhYkhtMeWMfYgeRAAvCPl2Vgw5Q0RTeU47kRoHwD0Dtaq', NULL, NULL, NULL, '2026-04-14 19:47:40', '2026-04-14 19:47:40', 'cashier', 71, 1),
(95, 'ssssssssssssssssss', 'y@gmail.com', NULL, 'nanocity', NULL, NULL, 1, '$2y$12$HLP4WdAd7rwKIznlID.C9ul3W85daPKZUzgyzUjrZWlJbLeOV/fZ6', NULL, NULL, NULL, '2026-04-14 20:03:30', '2026-04-14 20:03:30', 'delivery_men', 71, 1),
(96, 'ضضضضضضضضضض', 'x@gmail.com', NULL, NULL, NULL, NULL, 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, '2026-04-14 20:39:06', '2026-04-14 20:39:06', 'cashier', 71, 1),
(97, 'ققق', 'na@gmail.com', NULL, NULL, NULL, 'users/1776207361_69dec601366b7.jpg', 1, '$2y$12$DaLdCxcrFc6yuDwJcvADbuznCScRVZ2fTDO0ttHlLoixAXcYe230e', NULL, NULL, NULL, '2026-04-14 20:56:01', '2026-04-14 20:56:01', 'admin', 71, 4),
(98, 'agent', '123@gmail.com', NULL, NULL, NULL, 'users/1779567974_6a120d6618116.jpeg', 1, '$2y$12$946nUyMjeiIaP/xSFfnl6ee1r.2T9DfxhbtrBqAirMT/PMSESCft.', NULL, NULL, NULL, '2026-05-23 17:26:17', '2026-05-23 17:26:17', 'cashier', 71, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_attendance_date_unique` (`staff_id`,`attendance_date`),
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
-- Indexes for table `business_type_permission_defaults`
--
ALTER TABLE `business_type_permission_defaults`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bt_permission_default_unique` (`business_type_id`,`permission_key`);

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
  ADD KEY `categories_store_id_foreign` (`store_id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `chargeables`
--
ALTER TABLE `chargeables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chargeables_charge_id_foreign` (`charge_id`),
  ADD KEY `chargeables_chargeable_type_chargeable_id_index` (`chargeable_type`,`chargeable_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
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
  ADD UNIQUE KEY `product_sizes_barcode_unique` (`barcode`),
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
-- Indexes for table `salary_m`
--
ALTER TABLE `salary_m`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_m_staff_id_foreign` (`staff_id`),
  ADD KEY `salary_m_user_id_foreign` (`user_id`),
  ADD KEY `salary_m_created_by_foreign` (`created_by`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `staff_created_by_foreign` (`created_by`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch_creation_requests`
--
ALTER TABLE `branch_creation_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch_links`
--
ALTER TABLE `branch_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch_users`
--
ALTER TABLE `branch_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `business_types`
--
ALTER TABLE `business_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `business_type_permission_defaults`
--
ALTER TABLE `business_type_permission_defaults`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cash_transfers`
--
ALTER TABLE `cash_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `chargeables`
--
ALTER TABLE `chargeables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dining_areas`
--
ALTER TABLE `dining_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1091;

--
-- AUTO_INCREMENT for table `order_product_sizes`
--
ALTER TABLE `order_product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `package_features`
--
ALTER TABLE `package_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `package_permissions`
--
ALTER TABLE `package_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=776;

--
-- AUTO_INCREMENT for table `product_recipes`
--
ALTER TABLE `product_recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1417;

--
-- AUTO_INCREMENT for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- AUTO_INCREMENT for table `salary_m`
--
ALTER TABLE `salary_m`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1633;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `shift_expenses`
--
ALTER TABLE `shift_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendances_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `business_type_permission_defaults`
--
ALTER TABLE `business_type_permission_defaults`
  ADD CONSTRAINT `business_type_permission_defaults_business_type_id_foreign` FOREIGN KEY (`business_type_id`) REFERENCES `business_types` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chargeables`
--
ALTER TABLE `chargeables`
  ADD CONSTRAINT `chargeables_charge_id_foreign` FOREIGN KEY (`charge_id`) REFERENCES `charges` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `salary_m`
--
ALTER TABLE `salary_m`
  ADD CONSTRAINT `salary_m_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `salary_m_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_m_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
