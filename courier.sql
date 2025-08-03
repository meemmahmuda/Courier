-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 12:10 PM
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
-- Database: `courier`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
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
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
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
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_27_053040_create_trade_licences_table', 1),
(5, '2025_05_12_095416_create_otps_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `otp_code` varchar(255) NOT NULL,
  `verification_status` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `ref_no`, `mobile`, `otp_code`, `verification_status`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, '152413', '01777758200', '734909', 'Success', '2025-05-21 09:22:00', '2025-05-21 09:17:22', '2025-05-21 09:22:00'),
(6, '152418', '০১৭১৩৪৩৪২৫০', 'OTP not sent', 'Failed', '2025-05-21 09:59:56', '2025-05-21 09:43:39', '2025-05-21 09:44:42'),
(7, '152412', '01980600264', '151133', 'Success', '2025-05-21 09:49:41', '2025-05-21 09:49:17', '2025-05-21 09:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
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
('hyEUdkiNLWtgg2WqYEDsRM3VWW3mu1Psm15vhmal', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibkZHQ3BLN2cxWGNjbDMyaDl5YXVxV0tnQzJ1V3J2Y2NZeFlDa0hUcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1747822240),
('k73uVxcxwu0wKbF6fTwe35Puha3coWFSWYD7pPpJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1R0OVJFb2E2UmE1QURHMGdha1p3UzVTOHlDeEtXdExDNGxvZ3FGMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZWxpdmVyeW1hbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747815233),
('RDfNaNPpIBjP2yyQMOgabnLmJfso9LsxotHCdaA4', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaFJMbmhwRFZRUDN3a3pFYkVNeDg4SllJVlloRXlWWm5SMkdpUDNhSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZWxpdmVyeW1hbi9yZXR1cm5fdG9fZG5jYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7czo1NzoibG9naW5fc3VwZXJ2aXNvcl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1747821481),
('WjcuPeZP1b20wrvR7mAeVJQRjiEQfvEadGpV6ExU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0VvR2FjVHk2TzZjZHk4dHoxSzFBTEM2VG5RN0kzVnBteE9TR3FkWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2RlbGl2ZXJ5bWFuL2RlbGl2ZXJ5X3Byb2Nlc3MvZGVsaXZlcmVkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZWxpdmVyeW1hbi9kZWxpdmVyeV9wcm9jZXNzL2RlbGl2ZXJlZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747815232);

-- --------------------------------------------------------

--
-- Table structure for table `trade_licences`
--

CREATE TABLE `trade_licences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `cdate` text DEFAULT NULL,
  `Gateway` varchar(255) DEFAULT NULL,
  `zonename` varchar(255) DEFAULT NULL,
  `businame` varchar(255) DEFAULT NULL,
  `OwnerName` varchar(255) DEFAULT NULL,
  `Mob` varchar(255) DEFAULT NULL,
  `busiadd` text DEFAULT NULL,
  `TLNumber` varchar(255) DEFAULT NULL,
  `tl_page` varchar(255) DEFAULT NULL,
  `print_code` varchar(255) DEFAULT NULL,
  `uv_code` varchar(255) DEFAULT NULL,
  `PaymentType` varchar(255) DEFAULT NULL,
  `busitype` text DEFAULT NULL,
  `bookvalue` varchar(255) DEFAULT NULL,
  `collection_amount` varchar(255) DEFAULT NULL,
  `actual_amount` varchar(255) DEFAULT NULL,
  `assigned_sp` varchar(255) DEFAULT NULL,
  `assigned_sp_date` varchar(255) DEFAULT NULL,
  `assigned_dm` varchar(255) DEFAULT NULL,
  `assigned_dm_date` varchar(255) DEFAULT NULL,
  `sp_1st_call` text DEFAULT NULL,
  `sp_1st_status` varchar(255) DEFAULT NULL,
  `sp_2nd_call` text DEFAULT NULL,
  `sp_2nd_status` varchar(255) DEFAULT NULL,
  `sp_3rd_call` text DEFAULT NULL,
  `sp_3rd_status` varchar(255) DEFAULT NULL,
  `dm_1st_call` text DEFAULT NULL,
  `dm_1st_status` varchar(255) DEFAULT NULL,
  `dm_2nd_call` text DEFAULT NULL,
  `dm_2nd_status` varchar(255) DEFAULT NULL,
  `dm_3rd_call` text DEFAULT NULL,
  `dm_3rd_status` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `otp_verification` varchar(255) DEFAULT NULL,
  `delivery_slip` varchar(255) DEFAULT NULL,
  `receivers_photo` varchar(255) DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `return_slip` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trade_licences`
--

INSERT INTO `trade_licences` (`id`, `ref_no`, `cdate`, `Gateway`, `zonename`, `businame`, `OwnerName`, `Mob`, `busiadd`, `TLNumber`, `tl_page`, `print_code`, `uv_code`, `PaymentType`, `busitype`, `bookvalue`, `collection_amount`, `actual_amount`, `assigned_sp`, `assigned_sp_date`, `assigned_dm`, `assigned_dm_date`, `sp_1st_call`, `sp_1st_status`, `sp_2nd_call`, `sp_2nd_status`, `sp_3rd_call`, `sp_3rd_status`, `dm_1st_call`, `dm_1st_status`, `dm_2nd_call`, `dm_2nd_status`, `dm_3rd_call`, `dm_3rd_status`, `latitude`, `longitude`, `delivery_status`, `delivery_date`, `otp_verification`, `delivery_slip`, `receivers_photo`, `cancellation_reason`, `return_date`, `return_slip`, `product_type`, `created_at`, `updated_at`) VALUES
(32, '152411', '10-04-2025', 'Agent Banking', '১০ সাতারকুল', 'মীর ফ্যাশন হাউজ', 'মোঃ খলিল মীর', '০১৭১৮৭৬৭৫৮৪', 'রোকেয়া মঞ্জিল, দাগ-১৮৯১, বাড়ী-২/১, পূর্ব বাড্ডা, বাড্ডা, ঢাকা-১২১২।', 'TRAD/DNCC/042963/2024', NULL, NULL, NULL, 'APPL', 'টেইলার্স', '270', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trade_licence', '2025-05-21 09:08:51', '2025-05-21 09:08:51'),
(33, '152412', '10-04-2025', 'Agent Banking', '৩ মহাখালী', 'আনিকা বুটিকস এন্ড ফ্যাশন হাউস', 'সুলতানা রাজিয়া', '০১৯৮০৬০০২৬৪', 'হোল্ডিং- ২৫০,দোকান নং- ৭৯ (৩য় তলা), রামপুরা সুপার মার্কেট, রামপুরা, ঢাকা- ১২১৯', 'TRAD/DNCC/042964/2024', NULL, NULL, NULL, 'APPL', 'তৈরী পোশাক বিক্রেতা', '270', NULL, NULL, '3', '21-05-2025', '7', '21-05-2025', NULL, NULL, NULL, NULL, NULL, NULL, '21-05-2025 03:48 PM', 'Success', '21-05-2025 03:48 PM', 'Success', '21-05-2025 03:48 PM', 'Success', '23.7600326', '90.4184077', 'Delivered', '21-05-2025 03:49 PM', 'Success', '-', 'receivers_photos/1747820996_sp-1.png', '-', NULL, NULL, 'trade_licence', '2025-05-21 09:08:51', '2025-05-21 09:49:56'),
(34, '152413', '10-04-2025', 'Agent Banking', '৬ উত্তরা', 'নিপপন পেইন্ট ( বাংলাদেশ) প্রাইভেট লিমিটেড', 'ইউসেং হেঙ্গ (এম ডি)', '01777758200', 'বাসা-৪২, ব্লক-ডি, মেইন রোড, ধউর, নিশাতনগর, তুরাগ, ঢাকা-১৭১১।', 'TRAD/DNCC/042965/2024', NULL, NULL, NULL, 'APPL', 'আমদানী,প্রস্তুতকারক (অফিস),রং বিক্রেতা,রপ্তানী,সরবরাহকারী', '270', NULL, NULL, '2', '21-05-2025', '4', '21-05-2025', NULL, NULL, NULL, NULL, NULL, NULL, '21-05-2025 03:16 PM', 'Success', '21-05-2025 03:16 PM', 'Success', '21-05-2025 03:16 PM', 'Success', '23.8896199', '90.3765479', 'Delivered', '21-05-2025 03:22 PM', 'Success', '-', 'receivers_photos/1747819346_dm-1.jpg', '-', NULL, NULL, 'trade_licence', '2025-05-21 09:08:51', '2025-05-21 09:22:26'),
(35, '152414', '10-04-2025', 'Agent Banking', '৩ মহাখালী', 'মেডিকন কর্পোরেশন ', 'মোঃ মনোয়ারুল ইসলাম ', '০১৮২৭৮৮৬০২২', 'ল-২০/১, পূর্ব মেরুল নিমতলা রোড, বাড্ডা, ঢাকা-১২১২', 'TRAD/DNCC/042975/2024', NULL, NULL, NULL, 'APPL', 'প্রথম শ্রেণীর ঠিকাদার,সরবরাহকারী (দাহ্য পদার্থ ও ক্যামিকেল ব্যাতিত)', '270', NULL, NULL, '3', '21-05-2025', '7', '21-05-2025', '21-05-2025 03:56 PM', 'Failed', '21-05-2025 03:57 PM', 'Failed', '21-05-2025 03:57 PM', 'Failed', '21-05-2025 03:50 PM', 'Success', '21-05-2025 03:50 PM', 'Success', '21-05-2025 03:50 PM', 'Failed', NULL, NULL, 'Returned', NULL, NULL, NULL, NULL, 'Cancelled by DT', '21-05-2025 03:57 PM', 'return_slips/1747821481_sign.jpeg', 'trade_licence', '2025-05-21 09:08:51', '2025-05-21 09:58:01'),
(36, '152418', '10-04-2025', 'Agent Banking', '১ উত্তরা', 'পলি কেবলস ইন্ডাস্ট্রীজ লিঃ', 'মোহাম্মদ জাকির হোসেন', '০১৭১৩৪৩৪২৫০', 'প্লট-৭১,রাজউক কসমো শপিং কমপ্লেক্স,দোকান নং-১৭,আজমপুর,সেক্টর-০৭,উওরা,ঢাকা-১২৩০', 'TRAD/DNCC/042985/2024', NULL, NULL, NULL, 'APPL', 'ইলেকট্রিক পন্য বিক্রয়,সরবরাহকারী (দাহ্য পদার্থ ও ক্যামিকেল ব্যাতিত)', '270', NULL, NULL, '2', '21-05-2025', '4', '21-05-2025', NULL, NULL, NULL, NULL, NULL, NULL, '21-05-2025 03:15 PM', 'Success', '21-05-2025 03:15 PM', 'Success', '21-05-2025 03:15 PM', 'Success', '23.8688929', '90.3999393', 'Delivered', '21-05-2025 03:45 PM', 'Failed', 'delivery_slips/1747820745_sign.jpeg', 'receivers_photos/1747820745_dm-1.jpg', '-', NULL, NULL, 'trade_licence', '2025-05-21 09:10:37', '2025-05-21 09:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `zone` longtext DEFAULT NULL,
  `role` enum('admin','supervisor','deliveryman') NOT NULL DEFAULT 'deliveryman',
  `status` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `dob`, `mobile`, `nid`, `zone`, `role`, `status`, `address`, `image`, `otp_code`, `otp_expires_at`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$Lt8.d.Xt14wPT4W75e2eVeWSzV2jpLgAiQybq.S478pqfBwLbJVhS', '1992-12-12', '01712345678', '1234567891', '1', 'admin', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:51:08', '2025-05-21 06:51:08'),
(2, 'Supervisor-1', 'sp1@gmail.com', '$2y$12$5VDBGzB9Zaspc26qjmnGheRyHuVmlQrumxriOuuQdacJvykEmJ7uW', '1991-01-01', '01700000001', '0000000001', '১ উত্তরা, ৬ উত্তরা, ৭ দক্ষিণখান, ৮ উত্তরখান, ৯ ভাটারা', 'supervisor', 'active', 'Dhaka, Bangladesh', '', NULL, NULL, NULL, NULL, '2025-05-21 06:53:41', '2025-05-21 07:36:12'),
(3, 'Supervisor-2', 'sp2@gmail.com', '$2y$12$Bc83dHMNqFXIUFWB0F8Qp.g1DTsfFKOsxtic06GVhz37Qlucl0xcK', '1991-01-01', '01700000002', '0000000002', '২ মিরপুর, ৩ মহাখালী, ৪ মিরপুর, ৫ কারওয়ান বাজার, ১০ সাতারকুল', 'supervisor', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:56:13', '2025-05-21 09:47:36'),
(4, 'DM-1', 'dm1@gmail.com', '$2y$12$6WpnHSQbJMI52yLT3xkstugcZ6nTLKQAaZFQQptqS8gd/botnDbyW', '1991-01-01', '01900000001', '1000000001', '১ উত্তরা, ৬ উত্তরা, ৭ দক্ষিণখান, ৮ উত্তরখান, ৯ ভাটারা', 'deliveryman', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:57:05', '2025-05-21 07:36:52'),
(5, 'DM-2', 'dm2@gmail.com', '$2y$12$wo5AVJrR2D05es8s0ixgI.nCwJz/ahmjMd/Qxo7Q1J5IMDuAhjX8G', '1991-01-01', '01900000002', '1000000002', '১ উত্তরা, ৬ উত্তরা, ৭ দক্ষিণখান, ৮ উত্তরখান, ৯ ভাটারা', 'deliveryman', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:57:47', '2025-05-21 06:57:47'),
(6, 'DM-3', 'dm3@gmail.com', '$2y$12$ndDW68.T4XNynD1jW1c9O.nQYcy6HYYJZjEM9b3hzMuo0k7KOu5j2', '1992-02-02', '01900000003', '1000000003', '২ মিরপুর, ৩ মহাখালী, ৪ মিরপুর, ৫ কারওয়ান বাজার, ১০ সাতারকুল', 'deliveryman', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:58:13', '2025-05-21 06:58:13'),
(7, 'DM-4', 'dm4@gmail.com', '$2y$12$/KmtdugthyrDb16C5drcF.WoyD1CkwOUfmJvfhV9a5OX1NJi51dOe', '1993-03-03', '01900000004', '1000000004', '২ মিরপুর, ৩ মহাখালী, ৪ মিরপুর, ৫ কারওয়ান বাজার, ১০ সাতারকুল', 'deliveryman', 'active', '', '', NULL, NULL, NULL, NULL, '2025-05-21 06:58:59', '2025-05-21 09:47:05');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `otps_ref_no_unique` (`ref_no`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `trade_licences`
--
ALTER TABLE `trade_licences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trade_licences_ref_no_unique` (`ref_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_nid_unique` (`nid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trade_licences`
--
ALTER TABLE `trade_licences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
