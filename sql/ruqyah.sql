-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250422.c097b1deca
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 26, 2025 at 10:46 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruqyah`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `practitioner_id` bigint UNSIGNED NOT NULL,
  `type` enum('ruqyah','hijama') COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_type_id` bigint UNSIGNED DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symptoms` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `rejected_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `approval_notes` text COLLATE utf8mb4_unicode_ci,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` bigint UNSIGNED DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `session_type_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_type_fee` decimal(8,2) DEFAULT NULL,
  `session_type_min_duration` int DEFAULT NULL,
  `session_type_max_duration` int DEFAULT NULL,
  `head_cupping_fee` decimal(8,2) DEFAULT NULL,
  `head_cupping_min_duration` int DEFAULT NULL,
  `head_cupping_max_duration` int DEFAULT NULL,
  `body_cupping_fee` decimal(8,2) DEFAULT NULL,
  `body_cupping_min_duration` int DEFAULT NULL,
  `body_cupping_max_duration` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initial_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `current_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `account_type` enum('savings','checking','current','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'savings',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `account_name`, `account_number`, `bank_name`, `branch_name`, `initial_balance`, `current_balance`, `account_type`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Bkash Mobile Banking', '017XXXXXXXX', 'Bkash', 'MFS banking', 50000.00, 50000.00, 'other', 'Primary mobile banking account for Bkash transactions.', 'active', 3, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(2, 'Nagad Mobile Banking', '018XXXXXXXX', 'Nagad', 'MFS banking', 75000.00, 75000.00, 'other', 'Main mobile banking account for Nagad transactions.', 'active', 3, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(3, 'Business Reserve Fund', '2468135790', 'Secure Trust Bank', 'MFS banking', 120000.00, 120000.00, 'current', 'High-yield current account for reserves.', 'active', 3, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(4, 'Cash in Hand', 'N/A', 'Physical Cash', 'MFS banking', 25000.00, 25000.00, 'other', 'Physical cash handling for direct transactions.', 'active', 2, '2025-07-26 10:44:12', '2025-07-26 10:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('cash_in','cash_out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handled_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `transaction_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_submissions`
--

CREATE TABLE `contact_form_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `read_at` timestamp NULL DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_information`
--

CREATE TABLE `contact_information` (
  `id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_hours` text COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_form_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Book a Consultation',
  `contact_form_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_information`
--

INSERT INTO `contact_information` (`id`, `address`, `phone`, `email`, `business_hours`, `facebook_url`, `twitter_url`, `instagram_url`, `whatsapp_url`, `youtube_url`, `linkedin_url`, `contact_form_title`, `contact_form_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '123 Islamic Center Street, Madinah Quarter, City 12345', '+1 (555) 123-4567', 'info@ruqyahhijama.com', 'Saturday - Thursday: 9:00 AM - 8:00 PM\nFriday: 2:00 PM - 8:00 PM', 'https://facebook.com/ruqyahhijama', 'https://twitter.com/ruqyahhijama', 'https://instagram.com/ruqyahhijama', 'https://wa.me/15551234567', 'https://youtube.com/ruqyahhijama', 'https://linkedin.com/company/ruqyahhijama', 'Book a Consultation', 'Get in touch with us to schedule your Islamic healing session. Our qualified practitioners are here to help you on your wellness journey.', 1, '2025-07-26 10:44:12', '2025-07-26 10:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `practitioner_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('unpaid','paid','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000002_create_raqi_session_types_table', 1),
(5, '2024_01_01_000003_create_appointments_table', 1),
(6, '2024_01_01_000004_create_settings_table', 1),
(7, '2024_01_01_000004_create_treatments_table', 1),
(8, '2025_07_13_112143_create_raqi_monthly_availabilities_table', 1),
(9, '2025_07_13_234927_add_audit_fields_to_appointments_table', 1),
(10, '2025_07_13_234939_add_audit_fields_to_treatments_table', 1),
(11, '2025_07_14_121826_add_cancellation_fields_to_appointments_table', 1),
(12, '2025_07_14_182036_update_appointments_status_enum', 1),
(13, '2025_07_15_165345_add_session_type_fields_to_appointments_table', 1),
(14, '2025_07_19_121055_add_appointment_end_time_to_appointments_table', 1),
(15, '2025_07_19_121953_create_notifications_table', 1),
(16, '2025_07_19_134600_create_categories_table', 1),
(17, '2025_07_19_134734_create_blogs_table', 1),
(18, '2025_07_20_120650_create_contact_information_table', 1),
(19, '2025_07_20_121908_create_contact_form_submissions_table', 1),
(20, '2025_07_20_200001_create_bank_accounts_table', 1),
(21, '2025_07_20_200002_create_transactions_table', 1),
(22, '2025_07_21_000001_add_cashflow_fields_to_transactions_table', 1),
(23, '2025_07_21_180409_update_transactions_table_for_payment_type', 1),
(24, '2025_07_22_000001_create_cash_flows_table', 1),
(25, '2025_07_22_120000_add_voided_at_to_transactions_table', 1),
(26, '2025_07_22_183000_add_hijama_pricing_fields_to_appointments_table', 1),
(27, '2025_07_23_000001_create_invoices_table', 1),
(28, '2025_07_24_000001_create_payments_table', 1),
(29, '2025_07_24_200002_update_transaction_type_enum_on_transactions_table', 1),
(30, '2025_07_24_200003_add_cup_fields_to_payments_table', 1),
(31, '2025_07_25_000001_create_questions_table', 1),
(32, '2025_07_25_000002_create_question_answers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED DEFAULT NULL,
  `from_user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by` bigint UNSIGNED DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `head_cup_price` decimal(10,2) DEFAULT NULL,
  `head_cup_qty` int DEFAULT NULL,
  `body_cup_price` decimal(10,2) DEFAULT NULL,
  `body_cup_qty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `question_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('text','radio','checkbox') COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json DEFAULT NULL,
  `category` enum('ruqyah','hijama') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `input_type`, `options`, `category`, `is_active`, `is_required`, `created_at`, `updated_at`) VALUES
(1, 'What is your main health concern for Ruqyah treatment?', 'text', NULL, 'ruqyah', 1, 1, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(2, 'Have you experienced any spiritual symptoms?', 'radio', '[\"Yes\", \"No\", \"Not sure\"]', 'ruqyah', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(3, 'What symptoms are you currently experiencing?', 'checkbox', '[\"Headache\", \"Anxiety\", \"Depression\", \"Insomnia\", \"Physical pain\", \"Other\"]', 'ruqyah', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(4, 'How long have you been experiencing these symptoms?', 'radio', '[\"Less than 1 month\", \"1-6 months\", \"6-12 months\", \"More than 1 year\"]', 'ruqyah', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(5, 'What is your main health concern for Hijama treatment?', 'text', NULL, 'hijama', 1, 1, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(6, 'Have you had Hijama treatment before?', 'radio', '[\"Yes\", \"No\"]', 'hijama', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(7, 'What areas of your body would you like to treat?', 'checkbox', '[\"Head\", \"Neck\", \"Back\", \"Shoulders\", \"Arms\", \"Legs\", \"Other\"]', 'hijama', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(8, 'Do you have any medical conditions or allergies?', 'text', NULL, 'hijama', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(9, 'Are you currently taking any medications?', 'radio', '[\"Yes\", \"No\"]', 'hijama', 1, 0, '2025-07-26 10:44:12', '2025-07-26 10:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `raqi_monthly_availabilities`
--

CREATE TABLE `raqi_monthly_availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `practitioner_id` bigint UNSIGNED NOT NULL,
  `availability_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_duration` int NOT NULL DEFAULT '30' COMMENT 'Duration in minutes',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raqi_monthly_availabilities`
--

INSERT INTO `raqi_monthly_availabilities` (`id`, `practitioner_id`, `availability_date`, `start_time`, `end_time`, `slot_duration`, `is_available`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-07-26', '20:00:00', '21:00:00', 60, 1, 'Late test slot for today', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(2, 2, '2025-07-28', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(3, 2, '2025-07-29', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(4, 2, '2025-07-30', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(5, 2, '2025-07-31', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(6, 2, '2025-08-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(7, 2, '2025-08-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(8, 2, '2025-08-05', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(9, 2, '2025-08-06', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(10, 2, '2025-08-07', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(11, 2, '2025-08-08', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(12, 2, '2025-08-11', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(13, 2, '2025-08-12', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(14, 2, '2025-08-13', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(15, 2, '2025-08-14', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(16, 2, '2025-08-15', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(17, 2, '2025-08-18', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(18, 2, '2025-08-19', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(19, 2, '2025-08-20', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(20, 2, '2025-08-21', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(21, 2, '2025-08-22', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(22, 2, '2025-08-25', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(23, 2, '2025-08-26', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(24, 2, '2025-08-27', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(25, 2, '2025-08-28', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(26, 2, '2025-08-29', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(27, 2, '2025-09-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(28, 2, '2025-09-02', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(29, 2, '2025-09-03', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(30, 2, '2025-09-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(31, 3, '2025-07-26', '20:00:00', '21:00:00', 60, 1, 'Late test slot for today', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(32, 3, '2025-07-28', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(33, 3, '2025-07-29', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(34, 3, '2025-07-30', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(35, 3, '2025-07-31', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(36, 3, '2025-08-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(37, 3, '2025-08-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(38, 3, '2025-08-05', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(39, 3, '2025-08-06', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(40, 3, '2025-08-07', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(41, 3, '2025-08-08', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(42, 3, '2025-08-11', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(43, 3, '2025-08-12', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(44, 3, '2025-08-13', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(45, 3, '2025-08-14', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(46, 3, '2025-08-15', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(47, 3, '2025-08-18', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(48, 3, '2025-08-19', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(49, 3, '2025-08-20', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(50, 3, '2025-08-21', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(51, 3, '2025-08-22', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(52, 3, '2025-08-25', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(53, 3, '2025-08-26', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(54, 3, '2025-08-27', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(55, 3, '2025-08-28', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(56, 3, '2025-08-29', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(57, 3, '2025-09-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(58, 3, '2025-09-02', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(59, 3, '2025-09-03', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(60, 3, '2025-09-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(61, 4, '2025-07-26', '20:00:00', '21:00:00', 60, 1, 'Late test slot for today', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(62, 4, '2025-07-28', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(63, 4, '2025-07-29', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(64, 4, '2025-07-30', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(65, 4, '2025-07-31', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(66, 4, '2025-08-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(67, 4, '2025-08-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(68, 4, '2025-08-05', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(69, 4, '2025-08-06', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(70, 4, '2025-08-07', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(71, 4, '2025-08-08', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(72, 4, '2025-08-11', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(73, 4, '2025-08-12', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(74, 4, '2025-08-13', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(75, 4, '2025-08-14', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(76, 4, '2025-08-15', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(77, 4, '2025-08-18', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(78, 4, '2025-08-19', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(79, 4, '2025-08-20', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(80, 4, '2025-08-21', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(81, 4, '2025-08-22', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(82, 4, '2025-08-25', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(83, 4, '2025-08-26', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(84, 4, '2025-08-27', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(85, 4, '2025-08-28', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(86, 4, '2025-08-29', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(87, 4, '2025-09-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(88, 4, '2025-09-02', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(89, 4, '2025-09-03', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(90, 4, '2025-09-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(91, 5, '2025-07-26', '20:00:00', '21:00:00', 60, 1, 'Late test slot for today', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(92, 5, '2025-07-28', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(93, 5, '2025-07-29', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:11', '2025-07-26 10:44:12'),
(94, 5, '2025-07-30', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(95, 5, '2025-07-31', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(96, 5, '2025-08-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(97, 5, '2025-08-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(98, 5, '2025-08-05', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(99, 5, '2025-08-06', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(100, 5, '2025-08-07', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(101, 5, '2025-08-08', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(102, 5, '2025-08-11', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(103, 5, '2025-08-12', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(104, 5, '2025-08-13', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(105, 5, '2025-08-14', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(106, 5, '2025-08-15', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(107, 5, '2025-08-18', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(108, 5, '2025-08-19', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(109, 5, '2025-08-20', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(110, 5, '2025-08-21', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(111, 5, '2025-08-22', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(112, 5, '2025-08-25', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(113, 5, '2025-08-26', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(114, 5, '2025-08-27', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(115, 5, '2025-08-28', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(116, 5, '2025-08-29', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(117, 5, '2025-09-01', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(118, 5, '2025-09-02', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(119, 5, '2025-09-03', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(120, 5, '2025-09-04', '09:00:00', '17:00:00', 60, 1, 'Regular availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(121, 2, '2025-07-21', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(122, 2, '2025-07-22', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(123, 2, '2025-07-23', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(124, 2, '2025-07-24', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(125, 2, '2025-07-25', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(126, 3, '2025-07-21', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(127, 3, '2025-07-22', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(128, 3, '2025-07-23', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(129, 3, '2025-07-24', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(130, 3, '2025-07-25', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(131, 4, '2025-07-21', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(132, 4, '2025-07-22', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(133, 4, '2025-07-23', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(134, 4, '2025-07-24', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(135, 4, '2025-07-25', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(136, 5, '2025-07-21', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(137, 5, '2025-07-22', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(138, 5, '2025-07-23', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(139, 5, '2025-07-24', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12'),
(140, 5, '2025-07-25', '09:00:00', '17:00:00', 60, 1, 'Backdated availability', '2025-07-26 10:44:12', '2025-07-26 10:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `raqi_session_types`
--

CREATE TABLE `raqi_session_types` (
  `id` bigint UNSIGNED NOT NULL,
  `practitioner_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int NOT NULL,
  `min_duration` int NOT NULL,
  `max_duration` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raqi_session_types`
--

INSERT INTO `raqi_session_types` (`id`, `practitioner_id`, `type`, `fee`, `min_duration`, `max_duration`, `created_at`, `updated_at`) VALUES
(1, 2, 'diagnosis', 1500, 30, 60, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(2, 2, 'short', 1000, 60, 90, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(3, 2, 'long', 3000, 180, 300, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(4, 3, 'head_cupping', 500, 15, 30, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(5, 3, 'body_cupping', 400, 15, 30, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(6, 4, 'diagnosis', 1500, 30, 60, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(7, 4, 'short', 1000, 60, 90, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(8, 4, 'long', 3000, 180, 300, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(9, 4, 'head_cupping', 500, 15, 30, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(10, 4, 'body_cupping', 400, 15, 30, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(11, 5, 'diagnosis', 1500, 30, 60, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(12, 5, 'short', 1000, 60, 90, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(13, 5, 'long', 3000, 180, 300, '2025-07-26 10:44:11', '2025-07-26 10:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('V5VmlbyjzDuiazWhdW7fOr3uymWI9nbzEJa9lMHQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTFMOGhtU01ISDNCR3pwbFNwVHNRNFZwVmRad0RUM3liMUlTanBvYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1753526704);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `options` json DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `options`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Ruqyah & Hijama Management System', 'text', 'general', 'Site Name', 'The name of your center', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(2, 'site_description', 'Professional Islamic healing services including Ruqyah and Hijama treatments', 'textarea', 'general', 'Site Description', 'Brief description of your center', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(3, 'site_tagline', 'Healing Through Islamic Tradition', 'text', 'general', 'Site Tagline', 'Short tagline displayed below site name', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(4, 'contact_email', 'info@rhms.com', 'text', 'general', 'Contact Email', 'Primary contact email address', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(5, 'contact_phone', '+880 1234567890', 'text', 'general', 'Contact Phone', 'Primary contact phone number', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(6, 'contact_address', '123 Islamic Center Street, Dhaka, Bangladesh', 'textarea', 'general', 'Contact Address', 'Physical address of the center', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(7, 'social_facebook', 'https://facebook.com/rhms', 'text', 'general', 'Facebook Page', 'Facebook page URL', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(8, 'social_instagram', 'https://instagram.com/rhms', 'text', 'general', 'Instagram Profile', 'Instagram profile URL', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(9, 'social_whatsapp', '+880 1234567890', 'text', 'general', 'WhatsApp Number', 'WhatsApp contact number with country code', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(10, 'site_logo', NULL, 'image', 'appearance', 'Site Logo', 'Upload your center logo (recommended: 200x60px)', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(11, 'admin_logo', NULL, 'image', 'appearance', 'Admin Panel Logo', 'Logo for admin dashboard (recommended: 180x50px)', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(12, 'favicon', NULL, 'image', 'appearance', 'Favicon', 'Upload favicon (recommended: 32x32px)', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(13, 'primary_color', '#3B82F6', 'text', 'appearance', 'Primary Color', 'Primary color for the website (hex code)', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(14, 'secondary_color', '#1E40AF', 'text', 'appearance', 'Secondary Color', 'Secondary color for the website (hex code)', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(15, 'accent_color', '#10B981', 'text', 'appearance', 'Accent Color', 'Accent color for highlights and buttons (hex code)', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(16, 'enable_dark_mode', '0', 'boolean', 'appearance', 'Enable Dark Mode Option', 'Allow users to switch to dark mode', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(17, 'maintenance_mode', '0', 'boolean', 'system', 'Maintenance Mode', 'Put the site in maintenance mode', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(18, 'timezone', 'Asia/Dhaka', 'select', 'system', 'Timezone', 'Default timezone for the system', '{\"UTC\": \"UTC\", \"Asia/Dhaka\": \"Dhaka\", \"Asia/Dubai\": \"Dubai\", \"Asia/Tokyo\": \"Tokyo\", \"Asia/Bangkok\": \"Bangkok\", \"Asia/Karachi\": \"Karachi\", \"Asia/Kolkata\": \"Kolkata\", \"Europe/Paris\": \"Paris\", \"Europe/London\": \"London\", \"America/Denver\": \"Mountain Time\", \"Asia/Singapore\": \"Singapore\", \"America/Chicago\": \"Central Time\", \"America/New_York\": \"Eastern Time\", \"Australia/Sydney\": \"Sydney\", \"America/Los_Angeles\": \"Pacific Time\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(19, 'date_format', 'Y-m-d', 'select', 'system', 'Date Format', 'Default date format for the system', '{\"Y-m-d\": \"YYYY-MM-DD\", \"d-m-Y\": \"DD-MM-YYYY\", \"d/m/Y\": \"DD/MM/YYYY\", \"m-d-Y\": \"MM-DD-YYYY\", \"m/d/Y\": \"MM/DD/YYYY\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(20, 'time_format', 'H:i', 'select', 'system', 'Time Format', 'Default time format for the system', '{\"H:i\": \"24-hour (HH:MM)\", \"h:i A\": \"12-hour (HH:MM AM/PM)\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(21, 'language', 'en', 'select', 'system', 'Default Language', 'Default language for the system', '{\"ar\": \"العربية\", \"bn\": \"বাংলা\", \"en\": \"English\", \"ms\": \"Bahasa Melayu\", \"tr\": \"Türkçe\", \"ur\": \"اردو\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(22, 'enable_registration', '1', 'boolean', 'system', 'Enable User Registration', 'Allow new users to register on the site', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(23, 'email_verification', '1', 'boolean', 'system', 'Email Verification', 'Require email verification for new accounts', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(24, 'currency', 'BDT', 'select', 'business', 'Currency', 'Default currency for the system', '{\"AED\": \"UAE Dirham (د.إ)\", \"BDT\": \"Bangladeshi Taka (৳)\", \"BHD\": \"Bahraini Dinar (د.ب)\", \"EGP\": \"Egyptian Pound (ج.م)\", \"EUR\": \"Euro (€)\", \"GBP\": \"British Pound (£)\", \"INR\": \"Indian Rupee (₹)\", \"JOD\": \"Jordanian Dinar (د.ا)\", \"KWD\": \"Kuwaiti Dinar (د.ك)\", \"MYR\": \"Malaysian Ringgit (RM)\", \"OMR\": \"Omani Rial (ر.ع)\", \"PKR\": \"Pakistani Rupee (₨)\", \"QAR\": \"Qatari Riyal (ر.ق)\", \"SAR\": \"Saudi Riyal (ر.س)\", \"TRY\": \"Turkish Lira (₺)\", \"USD\": \"US Dollar ($)\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(25, 'currency_symbol', '৳', 'text', 'business', 'Currency Symbol', 'Currency symbol to display', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(26, 'business_hours', 'Saturday - Thursday: 9:00 AM - 6:00 PM\\nFriday: 2:00 PM - 6:00 PM', 'textarea', 'business', 'Business Hours', 'Center operating hours', NULL, 1, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(27, 'appointment_duration', '60', 'select', 'business', 'Default Appointment Duration (minutes)', 'Default duration for appointments', '{\"30\": \"30 minutes\", \"45\": \"45 minutes\", \"60\": \"1 hour\", \"90\": \"1.5 hours\", \"120\": \"2 hours\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(28, 'default_ruqyah_duration', '60', 'select', 'business', 'Default Ruqyah Duration (minutes)', 'Default duration for Ruqyah appointments', '{\"30\": \"30 minutes\", \"45\": \"45 minutes\", \"60\": \"1 hour\", \"90\": \"1.5 hours\", \"120\": \"2 hours\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(29, 'default_hijama_duration', '45', 'select', 'business', 'Default Hijama Duration (minutes)', 'Default duration for Hijama appointments', '{\"30\": \"30 minutes\", \"45\": \"45 minutes\", \"60\": \"1 hour\", \"90\": \"1.5 hours\"}', 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(30, 'advance_booking_days', '30', 'text', 'business', 'Advance Booking Days', 'How many days in advance patients can book appointments', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(31, 'cancellation_hours', '24', 'text', 'business', 'Cancellation Notice (hours)', 'Minimum hours notice required for appointment cancellation', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(32, 'default_ruqyah_fee', '1000', 'text', 'business', 'Default Ruqyah Fee', 'Default fee for Ruqyah appointments', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(33, 'default_hijama_head_fee', '800', 'text', 'business', 'Default Hijama Head Cupping Fee', 'Default fee for Hijama Head Cupping', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(34, 'default_hijama_body_fee', '1200', 'text', 'business', 'Default Hijama Body Cupping Fee', 'Default fee for Hijama Body Cupping', NULL, 0, '2025-07-26 10:44:10', '2025-07-26 10:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `transaction_type` enum('deposit','withdrawal','transfer','cash_in','cash_out','payment') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('cash','check','bank_transfer','credit_card','debit_card','online_payment','mobile_banking','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handled_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `bank_account_id` bigint UNSIGNED NOT NULL,
  `related_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `voided_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `practitioner_id` bigint UNSIGNED NOT NULL,
  `treatment_type` enum('ruqyah','hijama','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ruqyah',
  `treatment_date` date NOT NULL,
  `status` enum('scheduled','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `prescription` text COLLATE utf8mb4_unicode_ci,
  `aftercare` text COLLATE utf8mb4_unicode_ci,
  `duration` int DEFAULT NULL,
  `cost` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `creation_notes` text COLLATE utf8mb4_unicode_ci,
  `update_notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','patient') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `specialization`, `phone`, `address`, `is_active`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@example.com', '2025-07-26 10:44:10', '$2y$12$l/NpKlPWSPPt6ro/XPOWA.XhmMYHm1y0UBYwCR.YuOdjv0Y139loq', 'super_admin', NULL, NULL, NULL, 1, NULL, NULL, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(2, 'Dr. Ahmad Raqi', 'raqi1@example.com', '2025-07-26 10:44:10', '$2y$12$BumUAx.Cc7fHamr9sdO7QeGjJADXsTYiM8//RYRjQbdcdOQuykFvC', 'admin', 'ruqyah_healing', '+1234567891', '123 Islamic Center, City', 1, NULL, NULL, '2025-07-26 10:44:10', '2025-07-26 10:44:10'),
(3, 'Dr. Bilal Hijama', 'raqi2@example.com', '2025-07-26 10:44:11', '$2y$12$/x4qGrJCZ3Ad9MAKiLO0aONAehu23DftYqSFXvd3X/VJRDFEeAMTC', 'admin', 'hijama_cupping', '+1234567892', '456 Wellness Center, City', 1, NULL, NULL, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(4, 'Dr. Samir Both', 'raqi3@example.com', '2025-07-26 10:44:11', '$2y$12$NKOc68EWE1BiHXIEpGxefe5JQQOnswKVS3uHvaLVWGd1oqiY/MGkW', 'admin', 'both', '+1234567893', '789 Holistic Center, City', 1, NULL, NULL, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(5, 'Dr. Classic Raqi', 'raqi@example.com', '2025-07-26 10:44:11', '$2y$12$MT/Po/xLCjOUB6WFAJLgn.IuJumu6z07Ar1YbXYt7sSUEOtcUkBqC', 'admin', 'ruqyah_healing', '+1234567890', '101 Classic Center, City', 1, NULL, NULL, '2025-07-26 10:44:11', '2025-07-26 10:44:11'),
(6, 'Patient Test', 'patient@example.com', '2025-07-26 10:44:11', '$2y$12$YrXaoJc6roNP6HpV.1AiQOCFllE7S7SUvUqqtLjpRjocL4hHPqbIS', 'patient', NULL, '+0987654321', '456 Patient Street, City', 1, NULL, NULL, '2025-07-26 10:44:11', '2025-07-26 10:44:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_appointment_no_unique` (`appointment_no`),
  ADD KEY `appointments_user_id_foreign` (`user_id`),
  ADD KEY `appointments_practitioner_id_foreign` (`practitioner_id`),
  ADD KEY `appointments_session_type_id_foreign` (`session_type_id`),
  ADD KEY `appointments_created_by_foreign` (`created_by`),
  ADD KEY `appointments_updated_by_foreign` (`updated_by`),
  ADD KEY `appointments_approved_by_foreign` (`approved_by`),
  ADD KEY `appointments_rejected_by_foreign` (`rejected_by`),
  ADD KEY `appointments_cancelled_by_foreign` (`cancelled_by`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_created_by_foreign` (`created_by`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_category_id_foreign` (`category_id`);

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
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_flows_transaction_id_foreign` (`transaction_id`),
  ADD KEY `cash_flows_created_by_foreign` (`created_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_information`
--
ALTER TABLE `contact_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_no_unique` (`invoice_no`),
  ADD KEY `invoices_appointment_id_foreign` (`appointment_id`),
  ADD KEY `invoices_patient_id_foreign` (`patient_id`),
  ADD KEY `invoices_practitioner_id_foreign` (`practitioner_id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_appointment_id_foreign` (`appointment_id`),
  ADD KEY `notifications_from_user_id_foreign` (`from_user_id`),
  ADD KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`),
  ADD KEY `notifications_type_user_id_index` (`type`,`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`),
  ADD KEY `payments_paid_by_foreign` (`paid_by`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_answers_appointment_id_foreign` (`appointment_id`),
  ADD KEY `question_answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `raqi_monthly_availabilities`
--
ALTER TABLE `raqi_monthly_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `raqi_avail_unique` (`practitioner_id`,`availability_date`);

--
-- Indexes for table `raqi_session_types`
--
ALTER TABLE `raqi_session_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raqi_session_types_practitioner_id_foreign` (`practitioner_id`);

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
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_bank_account_id_foreign` (`bank_account_id`),
  ADD KEY `transactions_created_by_foreign` (`created_by`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatments_appointment_id_foreign` (`appointment_id`),
  ADD KEY `treatments_practitioner_id_foreign` (`practitioner_id`),
  ADD KEY `treatments_created_by_foreign` (`created_by`),
  ADD KEY `treatments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_information`
--
ALTER TABLE `contact_information`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raqi_monthly_availabilities`
--
ALTER TABLE `raqi_monthly_availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `raqi_session_types`
--
ALTER TABLE `raqi_session_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_session_type_id_foreign` FOREIGN KEY (`session_type_id`) REFERENCES `raqi_session_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD CONSTRAINT `cash_flows_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_flows_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_paid_by_foreign` FOREIGN KEY (`paid_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD CONSTRAINT `question_answers_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raqi_monthly_availabilities`
--
ALTER TABLE `raqi_monthly_availabilities`
  ADD CONSTRAINT `raqi_monthly_availabilities_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raqi_session_types`
--
ALTER TABLE `raqi_session_types`
  ADD CONSTRAINT `raqi_session_types_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `treatments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `treatments_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
