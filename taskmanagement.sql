-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 12, 2024 lúc 04:21 PM
-- Phiên bản máy phục vụ: 5.7.33
-- Phiên bản PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `taskmanagement`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `tel`, `email`, `manager`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'Chi  nhánh Gia Lâm', 'Phượng Cách Quốc Oai Hà Nội', '0368822642', 'duongvankhai2022001@gmail.com', 'Vũ Khánh Tùng', 3, '2024-05-08 07:08:05', '2024-05-08 07:08:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chemistries`
--

CREATE TABLE `chemistries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_regist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chemistries`
--

INSERT INTO `chemistries` (`id`, `code`, `name`, `number_regist`, `image`, `description`, `supplier`, `active`, `created_at`, `updated_at`) VALUES
(1, 'HC01', 'Hóa chất 1', NULL, NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(2, 'HC02', 'Hóa chất 2', NULL, NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `finish` date NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `name`, `start`, `finish`, `content`, `customer_id`, `branch_id`, `attachment`, `created_at`, `updated_at`) VALUES
(2, 'HD-0001', '2024-05-08', '2024-05-08', 'a', 2, 4, NULL, '2024-05-08 07:08:22', '2024-05-08 07:08:22'),
(3, 'HD-0002', '2024-05-08', '2024-07-08', 'V', 2, 4, NULL, '2024-05-08 08:57:22', '2024-05-08 08:57:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `name`, `representative`, `tax_code`, `address`, `website`, `email`, `avatar`, `manager`, `tel`, `province`, `field`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Dương Khải', 'Vũ Tuấn Tú', '123', 'Ha Noi', 'https://soccerstorenew.net', 'duongvankhai2022001@gmail.com', '/storage/upload/2024-05-08/14-07-24logo-fpt.PNG', 'Vũ Khánh Tùng', '0368822642', NULL, NULL, 3, '2024-05-08 07:07:33', '2024-05-08 07:07:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `info_users`
--

CREATE TABLE `info_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `info_users`
--

INSERT INTO `info_users` (`id`, `avatar`, `name`, `position`, `identification`, `tel`, `active`, `created_at`, `updated_at`, `user_id`) VALUES
(2, NULL, 'Khai Duong', 'Nhân viên', '001196033956', '0368822642', 1, '2024-05-08 08:55:07', '2024-05-08 08:55:07', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `items`
--

INSERT INTO `items` (`id`, `code`, `name`, `target`, `image`, `supplier`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Vật tư 1', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(2, NULL, 'Vật tư 2', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `maps`
--

CREATE TABLE `maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `maps`
--

INSERT INTO `maps` (`id`, `code`, `area`, `position`, `target`, `image`, `description`, `range`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'A', 'Cửa ra vào', 'Ruồi', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(2, NULL, 'A', 'Cửa ra vào', 'Muỗi', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(3, 'A-001', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(4, 'A-002', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(5, 'A-003', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(6, 'A-004', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(7, 'A-005', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(8, 'A-006', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(9, 'A-007', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(10, 'A-008', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(11, 'A-009', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(12, 'A-010', 'D', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(13, 'A-001', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(14, 'A-002', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(15, 'A-003', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(16, 'A-004', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(17, 'A-005', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(18, 'A-006', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(19, 'A-007', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(20, 'A-008', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(21, 'A-009', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(22, 'A-010', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(23, 'C-001', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(24, 'C-002', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(25, 'C-003', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(26, 'C-004', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(27, 'C-005', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(28, 'C-006', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(29, 'C-007', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(30, 'C-008', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(31, 'C-009', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(32, 'C-010', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(33, 'A-001', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(34, 'A-002', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(35, 'A-003', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(36, 'A-004', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(37, 'A-005', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(38, 'A-006', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(39, 'C-001', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(40, 'C-002', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(41, 'C-003', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(42, 'C-004', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(43, 'C-005', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(44, 'C-006', 'aa', 'Cửa trước', 'Muỗi', '', '', 'Phạm vi', 0, '2024-05-12 09:16:14', '2024-05-12 09:16:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(347, '2014_10_12_000000_create_users_table', 1),
(348, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(349, '2019_08_19_000000_create_failed_jobs_table', 1),
(350, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(351, '2023_01_22_074012_create_maps_table', 1),
(352, '2023_01_22_074344_create_chemistries_table', 1),
(353, '2023_01_22_074457_create_solutions_table', 1),
(354, '2023_01_22_074614_create_items_table', 1),
(355, '2023_10_28_155252_create_types_table', 1),
(356, '2023_10_28_155602_create_info_users_table', 1),
(357, '2023_10_30_155217_create_customers_table', 1),
(358, '2023_10_30_230843_create_branches_table', 1),
(359, '2023_10_31_155345_create_contracts_table', 1),
(360, '2023_10_31_170559_create_tasks_table', 1),
(361, '2023_11_27_100748_create_task_details_table', 1),
(362, '2024_01_25_020310_create_settings_table', 1),
(363, '2024_01_26_124234_create_task_maps_table', 1),
(364, '2024_01_26_124240_create_task_solutions_table', 1),
(365, '2024_01_27_045549_create_task_items_table', 1),
(366, '2024_01_27_045621_create_task_chemistries_table', 1),
(367, '2024_01_27_045631_create_task_staff_table', 1),
(368, '2024_02_25_155936_create_setting_task_maps_table', 1),
(369, '2024_02_25_160052_create_setting_task_items_table', 1),
(370, '2024_02_26_020532_create_setting_task_chemistries_table', 1),
(371, '2024_02_26_020539_create_setting_task_solutions_table', 1),
(372, '2024_02_26_020629_create_setting_task_staff_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `key`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'craw-count', 'Số luồng crawl count', '5', NULL, NULL),
(2, 'delay-time', 'Delay time mỗi luồng crawl count (ms)', '2000', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_task_chemistries`
--

CREATE TABLE `setting_task_chemistries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `chemistry_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting_task_chemistries`
--

INSERT INTO `setting_task_chemistries` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `chemistry_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Chai', '2', NULL, NULL, NULL, 3, 1, '2024-05-08 08:55:41', '2024-05-08 08:55:41'),
(2, NULL, NULL, 'Chai', '1', NULL, NULL, NULL, 5, 1, '2024-05-12 09:16:26', '2024-05-12 09:16:26'),
(3, NULL, NULL, 'Chai', '3', NULL, NULL, NULL, 6, 1, '2024-05-12 09:16:44', '2024-05-12 09:16:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_task_items`
--

CREATE TABLE `setting_task_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting_task_items`
--

INSERT INTO `setting_task_items` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `item_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Chai', '12', NULL, NULL, NULL, 3, 1, '2024-05-08 08:55:35', '2024-05-08 08:55:35'),
(2, NULL, NULL, 'Con', '1', NULL, NULL, NULL, 5, 1, '2024-05-12 09:16:22', '2024-05-12 09:16:22'),
(3, NULL, NULL, 'Con', '2', NULL, NULL, NULL, 6, 1, '2024-05-12 09:16:39', '2024-05-12 09:16:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_task_maps`
--

CREATE TABLE `setting_task_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `round` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fake_result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `map_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting_task_maps`
--

INSERT INTO `setting_task_maps` (`id`, `code`, `area`, `position`, `target`, `unit`, `kpi`, `result`, `image`, `detail`, `round`, `fake_result`, `task_id`, `map_id`, `created_at`, `updated_at`) VALUES
(1, 'A-001', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 3, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(2, 'A-002', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 4, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(3, 'A-003', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 5, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(4, 'A-004', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 6, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(5, 'A-005', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 7, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(6, 'A-006', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 8, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(7, 'A-007', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 9, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(8, 'A-008', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 10, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(9, 'A-009', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 11, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(10, 'A-010', 'D', 'Cửa trước', 'Muỗi', 'Con', '12', NULL, '', NULL, 'Phạm vi', '43', 3, 12, '2024-05-08 08:45:45', '2024-05-08 08:45:45'),
(11, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 13, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(12, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 14, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(13, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 15, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(14, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 16, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(15, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 17, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(16, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 18, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(17, 'A-007', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 19, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(18, 'A-008', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 20, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(19, 'A-009', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 21, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(20, 'A-010', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', NULL, '', NULL, 'Phạm vi', '11', 6, 22, '2024-05-12 09:15:24', '2024-05-12 09:15:24'),
(21, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 23, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(22, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 24, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(23, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 25, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(24, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 26, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(25, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 27, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(26, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 28, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(27, 'C-007', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 29, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(28, 'C-008', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 30, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(29, 'C-009', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 31, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(30, 'C-010', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', NULL, '', NULL, 'Phạm vi', '17', 6, 32, '2024-05-12 09:15:39', '2024-05-12 09:15:39'),
(31, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 33, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(32, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 34, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(33, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 35, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(34, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 36, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(35, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 37, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(36, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', NULL, '', NULL, 'Phạm vi', '44', 5, 38, '2024-05-12 09:16:04', '2024-05-12 09:16:04'),
(37, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 39, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(38, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 40, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(39, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 41, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(40, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 42, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(41, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 43, '2024-05-12 09:16:14', '2024-05-12 09:16:14'),
(42, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', NULL, '', NULL, 'Phạm vi', '22', 5, 44, '2024-05-12 09:16:14', '2024-05-12 09:16:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_task_solutions`
--

CREATE TABLE `setting_task_solutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `solution_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting_task_solutions`
--

INSERT INTO `setting_task_solutions` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `solution_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Cái', '21', NULL, NULL, NULL, 3, 1, '2024-05-08 08:55:47', '2024-05-08 08:55:47'),
(2, NULL, NULL, 'Cái', '2', NULL, NULL, NULL, 5, 1, '2024-05-12 09:16:30', '2024-05-12 09:16:30'),
(3, NULL, NULL, 'Cái', '3', NULL, NULL, NULL, 6, 1, '2024-05-12 09:16:49', '2024-05-12 09:16:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_task_staff`
--

CREATE TABLE `setting_task_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting_task_staff`
--

INSERT INTO `setting_task_staff` (`id`, `code`, `name`, `position`, `tel`, `identification`, `task_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 3, 5, '2024-05-08 08:55:28', '2024-05-08 08:55:28'),
(2, NULL, NULL, NULL, NULL, NULL, 5, 5, '2024-05-12 09:16:18', '2024-05-12 09:16:18'),
(3, NULL, NULL, NULL, NULL, NULL, 6, 5, '2024-05-12 09:16:35', '2024-05-12 09:16:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `solutions`
--

CREATE TABLE `solutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `solutions`
--

INSERT INTO `solutions` (`id`, `code`, `name`, `target`, `image`, `description`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Phương pháp 1', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(2, NULL, 'Phương pháp 2', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `frequence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`id`, `type_id`, `contract_id`, `frequence`, `confirm`, `status`, `reason`, `solution`, `note`, `created_at`, `updated_at`) VALUES
(3, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-08 07:08:22', '2024-05-08 07:08:22'),
(4, 10, 3, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(5, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(6, 9, 3, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-08 08:57:22', '2024-05-08 08:57:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_chemistries`
--

CREATE TABLE `task_chemistries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `chemistry_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_chemistries`
--

INSERT INTO `task_chemistries` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `chemistry_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Chai', '3', NULL, NULL, NULL, 28, 1, '2024-05-12 09:17:19', '2024-05-12 09:17:19'),
(2, NULL, NULL, 'Chai', '1', NULL, NULL, NULL, 20, 1, '2024-05-12 09:17:28', '2024-05-12 09:17:28'),
(3, NULL, NULL, 'Chai', '1', NULL, NULL, NULL, 21, 1, '2024-05-12 09:17:33', '2024-05-12 09:17:33'),
(4, NULL, NULL, 'Chai', '1', NULL, NULL, NULL, 22, 1, '2024-05-12 09:17:38', '2024-05-12 09:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_details`
--

CREATE TABLE `task_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_date` date DEFAULT NULL,
  `actual_date` date DEFAULT NULL,
  `time_in` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '07:00:00 AM',
  `time_out` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '11:00:00 AM',
  `range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_details`
--

INSERT INTO `task_details` (`id`, `plan_date`, `actual_date`, `time_in`, `time_out`, `range`, `status`, `reason`, `solution`, `note`, `task_id`, `created_at`, `updated_at`) VALUES
(11, '2024-05-08', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 3, '2024-05-08 07:08:22', '2024-05-08 07:08:22'),
(12, '2024-05-14', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(13, '2024-05-21', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(14, '2024-05-28', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(15, '2024-06-04', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(16, '2024-06-11', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(17, '2024-06-18', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(18, '2024-06-25', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(19, '2024-07-02', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 4, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(20, '2024-05-14', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(21, '2024-05-21', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(22, '2024-05-28', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(23, '2024-06-04', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(24, '2024-06-11', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(25, '2024-06-18', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(26, '2024-06-25', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(27, '2024-07-02', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 5, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(28, '2024-05-31', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 6, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(29, '2024-06-30', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 6, '2024-05-08 08:57:22', '2024-05-08 08:57:22'),
(30, '2024-07-31', NULL, '07:00:00 AM', '11:00:00 AM', NULL, NULL, NULL, NULL, NULL, 6, '2024-05-08 08:57:22', '2024-05-08 08:57:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_items`
--

CREATE TABLE `task_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_items`
--

INSERT INTO `task_items` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `item_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Con', '2', NULL, NULL, NULL, 28, 1, '2024-05-12 09:17:19', '2024-05-12 09:17:19'),
(2, NULL, NULL, 'Con', '1', NULL, NULL, NULL, 20, 1, '2024-05-12 09:17:28', '2024-05-12 09:17:28'),
(3, NULL, NULL, 'Con', '1', NULL, NULL, NULL, 21, 1, '2024-05-12 09:17:33', '2024-05-12 09:17:33'),
(4, NULL, NULL, 'Con', '1', NULL, NULL, NULL, 22, 1, '2024-05-12 09:17:38', '2024-05-12 09:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_maps`
--

CREATE TABLE `task_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `round` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fake_result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `map_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_maps`
--

INSERT INTO `task_maps` (`id`, `code`, `area`, `position`, `target`, `unit`, `kpi`, `result`, `image`, `detail`, `round`, `fake_result`, `task_id`, `map_id`, `created_at`, `updated_at`) VALUES
(1, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 13, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(2, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 14, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(3, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 15, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(4, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 16, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(5, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 17, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(6, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 18, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(7, 'A-007', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 19, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(8, 'A-008', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 20, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(9, 'A-009', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 21, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(10, 'A-010', 'aa', 'Cửa trước', 'Muỗi', 'Con', '43', '11', '', NULL, 'Phạm vi', '11', 28, 22, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(11, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 23, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(12, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 24, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(13, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 25, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(14, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 26, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(15, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 27, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(16, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 28, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(17, 'C-007', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 29, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(18, 'C-008', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 30, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(19, 'C-009', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 31, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(20, 'C-010', 'aa', 'Cửa trước', 'Muỗi', 'Con', '55', '17', '', NULL, 'Phạm vi', '17', 28, 32, '2024-05-12 09:17:19', '2024-05-12 09:17:22'),
(21, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 33, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(22, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 34, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(23, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 35, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(24, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 36, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(25, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 37, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(26, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 20, 38, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(27, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 39, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(28, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 40, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(29, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 41, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(30, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 42, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(31, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 43, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(32, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 20, 44, '2024-05-12 09:17:28', '2024-05-12 09:17:31'),
(33, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 33, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(34, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 34, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(35, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 35, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(36, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 36, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(37, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 37, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(38, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 21, 38, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(39, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 39, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(40, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 40, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(41, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 41, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(42, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 42, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(43, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 43, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(44, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 21, 44, '2024-05-12 09:17:33', '2024-05-12 09:17:35'),
(45, 'A-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 33, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(46, 'A-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 34, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(47, 'A-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 35, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(48, 'A-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 36, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(49, 'A-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 37, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(50, 'A-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '33', '44', '', NULL, 'Phạm vi', '44', 22, 38, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(51, 'C-001', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 39, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(52, 'C-002', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 40, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(53, 'C-003', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 41, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(54, 'C-004', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 42, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(55, 'C-005', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 43, '2024-05-12 09:17:38', '2024-05-12 09:17:41'),
(56, 'C-006', 'aa', 'Cửa trước', 'Muỗi', 'Con', '11', '22', '', NULL, 'Phạm vi', '22', 22, 44, '2024-05-12 09:17:38', '2024-05-12 09:17:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_solutions`
--

CREATE TABLE `task_solutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `solution_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_solutions`
--

INSERT INTO `task_solutions` (`id`, `code`, `name`, `unit`, `kpi`, `result`, `image`, `detail`, `task_id`, `solution_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Cái', '3', NULL, NULL, NULL, 28, 1, '2024-05-12 09:17:19', '2024-05-12 09:17:19'),
(2, NULL, NULL, 'Cái', '2', NULL, NULL, NULL, 20, 1, '2024-05-12 09:17:28', '2024-05-12 09:17:28'),
(3, NULL, NULL, 'Cái', '2', NULL, NULL, NULL, 21, 1, '2024-05-12 09:17:33', '2024-05-12 09:17:33'),
(4, NULL, NULL, 'Cái', '2', NULL, NULL, NULL, 22, 1, '2024-05-12 09:17:38', '2024-05-12 09:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_staff`
--

CREATE TABLE `task_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_staff`
--

INSERT INTO `task_staff` (`id`, `code`, `name`, `position`, `tel`, `identification`, `task_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 28, 5, '2024-05-12 09:17:19', '2024-05-12 09:17:19'),
(2, NULL, NULL, NULL, NULL, NULL, 20, 5, '2024-05-12 09:17:28', '2024-05-12 09:17:28'),
(3, NULL, NULL, NULL, NULL, NULL, 21, 5, '2024-05-12 09:17:33', '2024-05-12 09:17:33'),
(4, NULL, NULL, NULL, NULL, NULL, 22, 5, '2024-05-12 09:17:38', '2024-05-12 09:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suggestion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `types`
--

INSERT INTO `types` (`id`, `name`, `image`, `suggestion`, `note`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Kiểm soát côn trùng và dịch hại', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(2, 'Vệ sinh công nghiệp', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(3, 'Chăm sóc và duy tu cảnh quan', NULL, NULL, NULL, 0, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(4, 'Diệt chuột', NULL, NULL, NULL, 1, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(5, 'Diệt côn trùng', NULL, NULL, NULL, 1, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(6, 'Diệt mối', NULL, NULL, NULL, 1, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(7, 'Tưới cây', NULL, NULL, NULL, 2, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(8, 'Bón phân', NULL, NULL, NULL, 2, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(9, 'Phun thuốc', NULL, NULL, NULL, 2, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(10, 'Tẩy hóa chất', NULL, NULL, NULL, 3, '2024-05-06 08:28:48', '2024-05-06 08:28:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'duongvankhai2022001@gmail.com', '$2y$10$AOMe9kONYkVRC85HTJoLMeKT8ySck1ZaRbRfgRPdtp6.O0Mp2wJpq', 1, NULL, '2024-05-06 08:28:48', '2024-05-06 08:28:48'),
(3, NULL, 'kh2@gmail.com', '$2y$10$bsyUKJ1wG8At7iU29pATAuona.tTDNXZXEcMBBOCEBtQ.V6dhwyVi', 2, NULL, '2024-05-08 07:07:33', '2024-05-08 07:07:33'),
(5, NULL, 'nhanvien1@gmail.com', '$2y$10$h5g1tbCWAbH9JyXcG8e4LusfU3Xz5cqZ4tQKcOxBCL7MHD5yQnh0S', 0, NULL, '2024-05-08 08:55:07', '2024-05-08 08:55:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `chemistries`
--
ALTER TABLE `chemistries`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `info_users`
--
ALTER TABLE `info_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `info_users_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `setting_task_chemistries`
--
ALTER TABLE `setting_task_chemistries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_task_chemistries_task_id_foreign` (`task_id`),
  ADD KEY `setting_task_chemistries_chemistry_id_foreign` (`chemistry_id`);

--
-- Chỉ mục cho bảng `setting_task_items`
--
ALTER TABLE `setting_task_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_task_items_task_id_foreign` (`task_id`),
  ADD KEY `setting_task_items_item_id_foreign` (`item_id`);

--
-- Chỉ mục cho bảng `setting_task_maps`
--
ALTER TABLE `setting_task_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_task_maps_task_id_foreign` (`task_id`),
  ADD KEY `setting_task_maps_map_id_foreign` (`map_id`);

--
-- Chỉ mục cho bảng `setting_task_solutions`
--
ALTER TABLE `setting_task_solutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_task_solutions_task_id_foreign` (`task_id`),
  ADD KEY `setting_task_solutions_solution_id_foreign` (`solution_id`);

--
-- Chỉ mục cho bảng `setting_task_staff`
--
ALTER TABLE `setting_task_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_task_staff_task_id_foreign` (`task_id`),
  ADD KEY `setting_task_staff_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `solutions`
--
ALTER TABLE `solutions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_contract_id_foreign` (`contract_id`),
  ADD KEY `tasks_type_id_foreign` (`type_id`);

--
-- Chỉ mục cho bảng `task_chemistries`
--
ALTER TABLE `task_chemistries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_chemistries_task_id_foreign` (`task_id`),
  ADD KEY `task_chemistries_chemistry_id_foreign` (`chemistry_id`);

--
-- Chỉ mục cho bảng `task_details`
--
ALTER TABLE `task_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_details_task_id_foreign` (`task_id`);

--
-- Chỉ mục cho bảng `task_items`
--
ALTER TABLE `task_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_items_task_id_foreign` (`task_id`),
  ADD KEY `task_items_item_id_foreign` (`item_id`);

--
-- Chỉ mục cho bảng `task_maps`
--
ALTER TABLE `task_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_maps_task_id_foreign` (`task_id`),
  ADD KEY `task_maps_map_id_foreign` (`map_id`);

--
-- Chỉ mục cho bảng `task_solutions`
--
ALTER TABLE `task_solutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_solutions_task_id_foreign` (`task_id`),
  ADD KEY `task_solutions_solution_id_foreign` (`solution_id`);

--
-- Chỉ mục cho bảng `task_staff`
--
ALTER TABLE `task_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_staff_task_id_foreign` (`task_id`),
  ADD KEY `task_staff_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `chemistries`
--
ALTER TABLE `chemistries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `info_users`
--
ALTER TABLE `info_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `maps`
--
ALTER TABLE `maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `setting_task_chemistries`
--
ALTER TABLE `setting_task_chemistries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `setting_task_items`
--
ALTER TABLE `setting_task_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `setting_task_maps`
--
ALTER TABLE `setting_task_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `setting_task_solutions`
--
ALTER TABLE `setting_task_solutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `setting_task_staff`
--
ALTER TABLE `setting_task_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `solutions`
--
ALTER TABLE `solutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `task_chemistries`
--
ALTER TABLE `task_chemistries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `task_details`
--
ALTER TABLE `task_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `task_items`
--
ALTER TABLE `task_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `task_maps`
--
ALTER TABLE `task_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `task_solutions`
--
ALTER TABLE `task_solutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `task_staff`
--
ALTER TABLE `task_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `info_users`
--
ALTER TABLE `info_users`
  ADD CONSTRAINT `info_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `setting_task_chemistries`
--
ALTER TABLE `setting_task_chemistries`
  ADD CONSTRAINT `setting_task_chemistries_chemistry_id_foreign` FOREIGN KEY (`chemistry_id`) REFERENCES `chemistries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_task_chemistries_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `setting_task_items`
--
ALTER TABLE `setting_task_items`
  ADD CONSTRAINT `setting_task_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `setting_task_maps`
--
ALTER TABLE `setting_task_maps`
  ADD CONSTRAINT `setting_task_maps_map_id_foreign` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_task_maps_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `setting_task_solutions`
--
ALTER TABLE `setting_task_solutions`
  ADD CONSTRAINT `setting_task_solutions_solution_id_foreign` FOREIGN KEY (`solution_id`) REFERENCES `solutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_task_solutions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `setting_task_staff`
--
ALTER TABLE `setting_task_staff`
  ADD CONSTRAINT `setting_task_staff_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_task_staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_chemistries`
--
ALTER TABLE `task_chemistries`
  ADD CONSTRAINT `task_chemistries_chemistry_id_foreign` FOREIGN KEY (`chemistry_id`) REFERENCES `chemistries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_chemistries_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task_details` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_details`
--
ALTER TABLE `task_details`
  ADD CONSTRAINT `task_details_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_items`
--
ALTER TABLE `task_items`
  ADD CONSTRAINT `task_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task_details` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_maps`
--
ALTER TABLE `task_maps`
  ADD CONSTRAINT `task_maps_map_id_foreign` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_maps_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task_details` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_solutions`
--
ALTER TABLE `task_solutions`
  ADD CONSTRAINT `task_solutions_solution_id_foreign` FOREIGN KEY (`solution_id`) REFERENCES `solutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_solutions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task_details` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_staff`
--
ALTER TABLE `task_staff`
  ADD CONSTRAINT `task_staff_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
