-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 07, 2023 at 09:02 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` bigint(20) UNSIGNED DEFAULT NULL,
  `geo_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`id`, `name`, `address`, `images`, `type`, `geo_location`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'New Hotel', '52, Popyye Vally, Dreamland - 11102', 'https://www.tajhotels.com/content/dam/luxury/hotels/Taj_Mahal_Delhi/images/new-images/Taj-Mahal-New-Delhi-Facade.jpg/_jcr_content/renditions/cq5dam.web.1280.1280.jpeg', 1, '28.5058058,77.0679584', 1, '2023-02-18 07:36:24', '2023-02-18 07:36:24', NULL, NULL),
(2, 'Kiayada Goodwin', 'Qui quia ut iure con', NULL, 1, NULL, 1, '2023-03-18 04:28:03', '2023-03-18 04:28:03', 4, NULL),
(3, 'Kiayada Goodwin', 'Qui quia ut iure con', NULL, 1, NULL, 1, '2023-03-18 04:28:05', '2023-03-18 04:28:05', 4, NULL),
(4, 'Frances Houston', 'Rem incididunt disti', NULL, 1, NULL, 1, '2023-03-18 04:28:50', '2023-03-18 04:28:50', 4, NULL),
(5, 'Huston Hall', 'Ne colling road, Oldwood 10092', NULL, 1, NULL, 1, '2023-03-18 04:30:38', '2023-03-18 04:30:38', 4, NULL),
(6, 'Ayurvedagram Heritage Wellness Center', 'Bengaluru, Karnataka', NULL, NULL, NULL, 0, '2023-03-18 05:21:43', '2023-03-18 05:21:43', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_facilities`
--

CREATE TABLE `accommodation_facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accommodation_id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accommodation_facilities`
--

INSERT INTO `accommodation_facilities` (`id`, `accommodation_id`, `facility_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(2, 1, 2, 1, NULL, NULL, NULL, NULL),
(3, 4, 2, 1, NULL, NULL, NULL, NULL),
(4, 5, 2, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_types`
--

CREATE TABLE `accommodation_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accommodation_types`
--

INSERT INTO `accommodation_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'Hotel', 1, '2023-02-18 12:58:56', '2023-02-18 12:58:56', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `accreditations`
--

CREATE TABLE `accreditations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accreditations`
--

INSERT INTO `accreditations` (`id`, `name`, `logo`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'Test Vendor', '/Applications/MAMP/tmp/php/phpjym89d', 1, '2023-03-06 14:07:34', '2023-03-06 14:07:34', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accreditation_hospitals`
--

CREATE TABLE `accreditation_hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accreditation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `active_queries`
--

CREATE TABLE `active_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `query_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_response` text COLLATE utf8mb4_unicode_ci,
  `patient_response` text COLLATE utf8mb4_unicode_ci,
  `attendant_passport` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tickets` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_visa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_payment_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_payment_done` tinyint(1) NOT NULL DEFAULT '0',
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `active_queries`
--

INSERT INTO `active_queries` (`id`, `query_id`, `doctor_response`, `patient_response`, `attendant_passport`, `tickets`, `medical_visa`, `is_payment_required`, `is_payment_done`, `country`, `state`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 3, 'Ut eget urna vel urna lacinia luctus sit amet pretium metus. Mauris laoreet, dolor vel vestibulum cursus, elit mi vulputate velit, faucibus accumsan enim tortor non enim. Maecenas pretium nisi augue, id tincidunt enim blandit ac. Aliquam euismod libero cursus purus mollis sagittis. Suspendisse ullamcorper neque magna. Aenean urna lectus, viverra sit amet facilisis in, placerat et metus. Donec pellentesque sagittis lacus in tincidunt. Sed elit elit, interdum sed purus eu, elementum vulputate lacus.Sed bibendum vitae nunc eget tempus. Nunc tincidunt dui in tristique laoreet. Aliquam consequat arcu libero, eu pulvinar lorem viverra vitae. Cras porttitor elit nunc, non suscipit odio placerat at. Phasellus pharetra mattis erat eleifend elementum. Donec euismod lobortis porta. Praesent blandit orci id urna pellentesque ultrices. Proin ut mi metus. Aliquam erat volutpat. Vestibulum id lacus eros. Quisque non lacus nulla. Nam accumsan bibendum ligula a porta. Aenean arcu libero, facilisis in lectus vitae, laoreet congue erat. Ut ac lacus magna. In sit amet fermentum lacus, iaculis laoreet diam. Suspendisse scelerisque interdum felis ac interdum. Suspendisse congue venenatis ex, semper tincidunt odio bibendum eget. Praesent elit sem, lobortis ut lorem at, facilisis varius mauris. Phasellus vehicula nibh lectus, ut posuere tellus sagittis eget. Nullam hendrerit tristique rhoncus. Sed fringilla sollicitudin lacus, quis auctor eros molestie quis. Nunc imperdiet vel risus quis molestie. Vivamus libero tortor, ultricies non dui eu, iaculis tempor lorem. Aenean viverra tellus sit amet enim placerat elementum non nec lacus. Ut eu volutpat lorem, convallis fermentum libero. Aliquam faucibus, augue non vulputate vulputate, nisl ante hendrerit massa, non vehicula nulla magna nec nibh. Nullam id varius turpis. Maecenas massa ligula, vestibulum nec diam quis, lacinia rhoncus ex.', 'Duis molestie, ligula non pellentesque consectetur, velit lacus pretium elit, quis bibendum ex libero ac lacus. Quisque porta porta posuere. In id mi nisl. Vivamus fermentum porttitor eros. Nullam eu feugiat erat, eu eleifend mi. Sed sed tempor dui. Duis hendrerit eu orci nec sollicitudin. Vestibulum eget mi sed augue ullamcorper egestas. Pellentesque ullamcorper magna turpis, ut dignissim massa convallis ultrices. Duis eu rutrum urna. Quisque tincidunt at nulla sit amet dictum. Vestibulum malesuada scelerisque eros eu faucibus.', 'at', 'atque', 'iure', 1, 0, 'India', 'Active', 1, '2023-02-18 06:12:24', '2023-02-18 06:12:24', NULL, NULL),
(4, 1, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '2023-02-20 04:24:47', '2023-02-20 04:24:47', 4, NULL),
(5, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 1, '2023-03-18 11:48:32', '2023-03-18 11:48:32', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_queries`
--

CREATE TABLE `confirmed_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `query_id` bigint(20) UNSIGNED NOT NULL,
  `accommodation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cab_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cab_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cab_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordinator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `confirmed_queries`
--

INSERT INTO `confirmed_queries` (`id`, `query_id`, `accommodation_id`, `cab_name`, `cab_number`, `cab_type`, `coordinator_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(2, 1, 1, NULL, NULL, NULL, 1, 1, '2023-02-20 02:14:43', '2023-02-20 03:16:02', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'MDS', 0, '2023-02-12 03:05:58', '2023-02-18 12:13:26', 4, 4),
(2, 'MBBS', 1, '2023-02-18 01:02:19', '2023-02-18 01:02:19', 4, NULL),
(3, 'BDS', 1, '2023-02-18 01:04:34', '2023-02-18 01:04:34', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detoxification_categories`
--

CREATE TABLE `detoxification_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detoxification_wellness`
--

CREATE TABLE `detoxification_wellness` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detoxification_category_id` bigint(20) UNSIGNED NOT NULL,
  `wellness_center_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_of_service` datetime NOT NULL,
  `awards` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `designation_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `faq` json DEFAULT NULL,
  `time_slots` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `start_of_service`, `awards`, `description`, `designation_id`, `qualification_id`, `faq`, `time_slots`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 2, '2023-02-05 12:09:05', 'vitae', 'tempore', '1', 1, '\"autem\"', '\"eos\"', 1, '2023-02-12 03:07:58', '2023-02-12 03:07:58', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_hospitals`
--

CREATE TABLE `doctor_hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_hospitals`
--

INSERT INTO `doctor_hospitals` (`id`, `doctor_id`, `hospital_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_patient_testimonials`
--

CREATE TABLE `doctor_patient_testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `testimonial_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specializations`
--

CREATE TABLE `doctor_specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_specializations`
--

INSERT INTO `doctor_specializations` (`id`, `doctor_id`, `specialization_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 1, 1, 1, '2023-02-20 09:01:04', NULL, NULL, NULL),
(2, 1, 2, 1, '2023-02-20 09:01:30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_tags`
--

CREATE TABLE `doctor_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_treatments`
--

CREATE TABLE `doctor_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `treatment_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_treatments`
--

INSERT INTO `doctor_treatments` (`id`, `doctor_id`, `treatment_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(2, 1, 13, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(2, 'New Facility', 1, '2023-03-18 09:31:52', '2023-03-18 09:31:52', NULL, NULL);

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `geo_location` json DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `address`, `description`, `geo_location`, `logo`, `images`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'Haag-Miller', '18218 Nathen Rue\nEliezerborough, NC 55214', 'Knave was standing before them, in chains, with a T!\' said the Hatter. He had been would have appeared to them she heard a little door was shut again, and looking at it gloomily: then he dipped it into his plate. Alice did not quite sure whether it was indeed: she was talking. \'How CAN I have to go down the chimney?--Nay, I shan\'t! YOU do it!--That I won\'t, then!--Bill\'s to go down the chimney close above her: then, saying to herself, \'I don\'t see how he can EVEN finish, if he thought it had.', '\"56.818382,-22.729678\"', 'https://via.placeholder.com/640x480.png/00eeaa?text=rerum', '[\"https://via.placeholder.com/640x480.png/008855?text=vero\", \"https://via.placeholder.com/640x480.png/005555?text=nesciunt\", \"https://via.placeholder.com/640x480.png/00ddee?text=aut\", \"https://via.placeholder.com/640x480.png/00cc11?text=molestias\", \"https://via.placeholder.com/640x480.png/000000?text=id\", \"https://via.placeholder.com/640x480.png/000066?text=dolores\", \"https://via.placeholder.com/640x480.png/00eeaa?text=beatae\", \"https://via.placeholder.com/640x480.png/000022?text=qui\", \"https://via.placeholder.com/640x480.png/0077cc?text=eum\", \"https://via.placeholder.com/640x480.png/008800?text=ad\"]', 1, '2023-02-12 06:00:09', '2023-02-12 06:00:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospital_tags`
--

CREATE TABLE `hospital_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_treatments`
--

CREATE TABLE `hospital_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED NOT NULL,
  `treatment_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospital_treatments`
--

INSERT INTO `hospital_treatments` (`id`, `hospital_id`, `treatment_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 1, 1, 1, '2023-02-20 09:13:57', NULL, NULL, NULL),
(2, 1, 4, 1, NULL, NULL, NULL, NULL),
(3, 1, 11, 1, NULL, NULL, NULL, NULL),
(4, 1, 12, 1, NULL, NULL, NULL, NULL),
(5, 1, 13, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 8, '52b7d6a3-abd3-43d1-8d3a-5504ba3251c9', 'user', 'attachment', 'attachment.png', 'image/png', 'public', 'public', 301392, '[]', '[]', '[]', 1, '2023-02-18 07:47:10', '2023-02-18 07:47:10'),
(2, 'App\\Models\\User', 8, '0885b44e-aed4-4a22-8242-1694ded8500b', 'user', 'essentia-luxury-hotel', 'essentia-luxury-hotel.jpeg', 'image/jpeg', 'public', 'public', 102981, '[]', '[]', '[]', 2, '2023-02-18 07:49:26', '2023-02-18 07:49:26'),
(3, 'App\\Models\\User', 8, '395c04c7-5f8a-4a90-ac0a-a8e3966d6494', 'user', 'essentia-luxury-hotel', 'essentia-luxury-hotel.jpeg', 'image/jpeg', 'public', 'public', 102981, '[]', '[]', '[]', 3, '2023-02-18 07:50:08', '2023-02-18 07:50:08'),
(4, 'App\\Models\\Hospital', 1, 'c5d45c16-c2fb-439d-a0d0-a3f84e5b469c', 'hospital', 'essentia-luxury-hotel', 'essentia-luxury-hotel.jpeg', 'image/jpeg', 'public', 'public', 102981, '[]', '[]', '[]', 4, '2023-02-18 08:03:41', '2023-02-18 08:03:41'),
(5, 'App\\Models\\Hospital', 1, 'ff8660fd-0422-438a-a17b-cb30563926ee', 'hospital', 'essentia-luxury-hotel', 'essentia-luxury-hotel.jpeg', 'image/jpeg', 'public', 'public', 102981, '[]', '[]', '[]', 5, '2023-02-18 08:06:54', '2023-02-18 08:06:54'),
(6, 'App\\Models\\Hospital', 1, 'd1a2a076-b00d-4917-9df6-47f74a697a5d', 'hospital', 'essentia-luxury-hotel', 'essentia-luxury-hotel.jpeg', 'image/jpeg', 'public', 'public', 102981, '[]', '[]', '[]', 6, '2023-02-18 08:07:20', '2023-02-18 08:07:20'),
(7, 'App\\Models\\Treatment', 6, '867a9a7d-9b1f-414e-9b35-d814daa1c8dc', 'treatment', 'avatar4', 'avatar4.png', 'image/png', 'public', 'public', 13543, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 7, '2023-03-06 12:45:21', '2023-03-06 12:45:21'),
(8, 'App\\Models\\Treatment', 7, 'aeed6697-3214-4189-8398-3727bd5b894c', 'treatment', 'AdminLTELogo', 'AdminLTELogo.png', 'image/png', 'public', 'public', 2637, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 8, '2023-03-06 12:56:07', '2023-03-06 12:56:07'),
(9, 'App\\Models\\Treatment', 10, '363b7cb6-05b1-40b6-b2eb-89c598b9e3ce', 'treatment', 'avatar2', 'avatar2.png', 'image/png', 'public', 'public', 8265, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 9, '2023-03-06 13:04:36', '2023-03-06 13:04:36'),
(10, 'App\\Models\\Treatment', 10, '6faa4c0d-5afa-4a1d-ac26-2d416fd5616c', 'treatment', 'avatar3', 'avatar3.png', 'image/png', 'public', 'public', 9246, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 10, '2023-03-06 13:04:36', '2023-03-06 13:04:36'),
(11, 'App\\Models\\Treatment', 10, 'e4990084-d402-4399-be32-4587ac28bb19', 'treatment', 'avatar4', 'avatar4.png', 'image/png', 'public', 'public', 13543, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 11, '2023-03-06 13:04:36', '2023-03-06 13:04:36'),
(12, 'App\\Models\\Treatment', 10, '0e2f551a-03c5-427b-8f27-b9ad0dcb4f22', 'treatment', 'avatar5', 'avatar5.png', 'image/png', 'public', 'public', 7587, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 12, '2023-03-06 13:04:36', '2023-03-06 13:04:36'),
(13, 'App\\Models\\Treatment', 11, 'da3a0b2d-5bf2-4106-a995-5eeb465b6b4f', 'treatment', 'home-decor-1', 'home-decor-1.jpg', 'image/jpeg', 'public', 'public', 937206, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 13, '2023-03-06 13:18:51', '2023-03-06 13:18:51'),
(14, 'App\\Models\\Treatment', 11, 'd98b4d36-3e64-499b-ab2f-0bba050521d1', 'treatment', 'home-decor-2', 'home-decor-2.jpg', 'image/jpeg', 'public', 'public', 1088035, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 14, '2023-03-06 13:18:51', '2023-03-06 13:18:51'),
(15, 'App\\Models\\Treatment', 11, '7e5aada5-7d65-48bd-9dae-8bfae8574a35', 'treatment', 'home-decor-3', 'home-decor-3.jpg', 'image/jpeg', 'public', 'public', 1159457, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 15, '2023-03-06 13:18:51', '2023-03-06 13:18:51'),
(16, 'App\\Models\\Treatment', 12, '236fc952-587e-4438-b7b2-2a9ab840225c', 'treatment', 'photo1', 'photo1.png', 'image/png', 'public', 'public', 662169, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 16, '2023-03-06 13:21:13', '2023-03-06 13:21:13'),
(17, 'App\\Models\\Treatment', 12, '31f20108-c6ac-4c46-8f8d-50d03c16e056', 'treatment', 'photo2', 'photo2.png', 'image/png', 'public', 'public', 422537, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 17, '2023-03-06 13:21:13', '2023-03-06 13:21:13'),
(18, 'App\\Models\\Treatment', 12, '63a4d282-34b6-4d3b-abd4-4b3e3b6dd5bd', 'treatment', 'photo3', 'photo3.jpg', 'image/jpeg', 'public', 'public', 370563, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 18, '2023-03-06 13:21:13', '2023-03-06 13:21:13'),
(22, 'App\\Models\\Accreditation', 1, '42318fef-1ccb-44e5-adeb-d6593e1376ee', 'logo', 'avatar3', 'avatar3.png', 'image/png', 'public', 'public', 9246, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 22, '2023-03-06 14:07:34', '2023-03-06 14:07:34'),
(28, 'App\\Models\\Treatment', 13, '6069c901-d568-4ea8-847e-47279ad720f7', 'treatment-logo', '1-2', '1-2.png', 'image/png', 'public', 'public', 94726, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 23, '2023-03-18 00:30:44', '2023-03-18 00:30:44'),
(29, 'App\\Models\\Accommodation', 4, 'ca4cd45b-642f-4458-b467-464e2321a55f', 'accommodation-images', 'image-008', 'image-008.png', 'image/png', 'public', 'public', 3268018, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 24, '2023-03-18 04:28:50', '2023-03-18 04:28:50'),
(30, 'App\\Models\\Accommodation', 5, 'f9fa2f77-e5fd-426d-8344-406f7c16c226', 'accommodation-images', 'image-000', 'image-000.png', 'image/png', 'public', 'public', 1938982, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 25, '2023-03-18 04:30:38', '2023-03-18 04:30:38'),
(31, 'App\\Models\\Accommodation', 6, 'a4fb80aa-05b8-4c9c-82ac-8fc97b37a7a8', 'accommodation-images', 'Ananda-in-the-Himalayas', 'Ananda-in-the-Himalayas.jpg', 'image/jpeg', 'public', 'public', 208653, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 26, '2023-03-18 05:21:43', '2023-03-18 05:21:43'),
(32, 'App\\Models\\Accommodation', 6, '0fce3d4b-5282-45f1-ac68-c781dc7a9591', 'accommodation-images', 'Ayurvedagram-Heritage-Wellness-Center-Bengaluru', 'Ayurvedagram-Heritage-Wellness-Center-Bengaluru.jpg', 'image/jpeg', 'public', 'public', 113608, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 27, '2023-03-18 05:21:43', '2023-03-18 05:21:43'),
(33, 'App\\Models\\WellnessCenter', 2, '5ce97c76-58d7-42eb-98ca-39318aa02571', 'wellness-center-logo', 'logo-gold', 'logo-gold.png', 'image/png', 'public', 'public', 11509, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 28, '2023-03-18 05:33:08', '2023-03-18 05:33:08'),
(34, 'App\\Models\\WellnessCenter', 2, '1fe0151c-d833-4e0b-a800-10c74a80bdb5', 'wellness-center-images', 'Ananda-in-the-Himalayas', 'Ananda-in-the-Himalayas.jpg', 'image/jpeg', 'public', 'public', 208653, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 29, '2023-03-18 05:33:08', '2023-03-18 05:33:08'),
(35, 'App\\Models\\WellnessCenter', 2, 'c2d3fe76-037f-4993-9814-e31c934d32fe', 'wellness-center-images', 'Ayurvedagram-Heritage-Wellness-Center-Bengaluru', 'Ayurvedagram-Heritage-Wellness-Center-Bengaluru.jpg', 'image/jpeg', 'public', 'public', 113608, '[]', '{\"generated_conversions\": {\"thumbnail\": true}}', '[]', 30, '2023-03-18 05:33:08', '2023-03-18 05:33:09');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_07_104524_create_permission_tables', 1),
(6, '2021_09_07_105055_create_media_table', 1),
(7, '2023_02_05_120901_create_accreditation_hospitals_table', 1),
(8, '2023_02_05_120901_create_active_queries_table', 1),
(9, '2023_02_05_120901_create_confirmed_queries_table', 1),
(10, '2023_02_05_120901_create_doctor_patient_testimonials_table', 1),
(11, '2023_02_05_120901_create_doctor_specializations_table', 1),
(12, '2023_02_05_120901_create_doctor_tags_table', 1),
(13, '2023_02_05_120901_create_hospital_treatments_table', 1),
(14, '2023_02_05_120901_create_past_queries_table', 1),
(15, '2023_02_05_120901_create_patient_families_table', 1),
(16, '2023_02_05_120901_create_queries_table', 1),
(17, '2023_02_05_120902_create_accommodation_facilities_table', 1),
(18, '2023_02_05_120902_create_accommodation_types_table', 1),
(19, '2023_02_05_120902_create_accommodations_table', 1),
(20, '2023_02_05_120902_create_detoxification_categories_table', 1),
(21, '2023_02_05_120902_create_detoxification_wellnesses_table', 1),
(22, '2023_02_05_120902_create_doctor_hospitals_table', 1),
(23, '2023_02_05_120902_create_doctor_treatments_table', 1),
(24, '2023_02_05_120902_create_facilities_table', 1),
(25, '2023_02_05_120902_create_patient_testimonies_table', 1),
(26, '2023_02_05_120902_create_patient_testimony_tags_table', 1),
(27, '2023_02_05_120902_create_wellness_centers_table', 1),
(28, '2023_02_05_120903_create_accreditations_table', 1),
(29, '2023_02_05_120903_create_designations_table', 1),
(30, '2023_02_05_120903_create_doctors_table', 1),
(31, '2023_02_05_120903_create_hospital_tags_table', 1),
(32, '2023_02_05_120903_create_hospitals_table', 1),
(33, '2023_02_05_120903_create_patient_details_table', 1),
(34, '2023_02_05_120903_create_patient_family_details_table', 1),
(35, '2023_02_05_120903_create_qualifications_table', 1),
(36, '2023_02_05_120903_create_specialization_treatments_table', 1),
(37, '2023_02_05_120903_create_specializations_table', 1),
(38, '2023_02_05_120903_create_tags_table', 1),
(39, '2023_02_05_120903_create_tests_table', 1),
(40, '2023_02_05_120903_create_treatments_table', 1),
(41, '2023_02_05_120904_create_push_notifications_table', 1),
(42, '2023_02_05_120905_create_social_logins_table', 1),
(43, '2023_02_05_130904_create_foreign_keys', 1),
(45, '2023_04_02_001138_add_specialization_to_patient_details', 2);

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
(4, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `past_queries`
--

CREATE TABLE `past_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `opening_date` datetime DEFAULT NULL,
  `closing_date` datetime DEFAULT NULL,
  `specialization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `query_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `speciality` bigint(20) UNSIGNED DEFAULT NULL,
  `treatment_country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medical_ifo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`id`, `user_id`, `speciality`, `treatment_country`, `medical_ifo`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 6, 1, 'Bahamas', 'Duchess; \'and that\'s why. Pig!\' She said it to make out who was trembling down to them, and all must have got into the wood. \'If it had VERY long claws and a piece of it at last, and managed to put.', 1, '2023-02-12 06:57:53', '2023-02-12 06:57:53', NULL, NULL),
(2, 8, 5, 'India', 'dolorLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pulvinar mi et finibus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris aliquet purus condimentum leo porta, vel posuere orci placerat. Nam luctus diam ut justo suscipit blandit. Mauris pharetra tempor condimentum. Mauris auctor elit at ligula viverra, in volutpat neque volutpat. Mauris volutpat consequat metus, sit amet rutrum est viverra et. Nullam aliquet erat eu diam pretium, a convallis augue tempus. Duis leo ipsum, pharetra id hendrerit sed, porttitor sollicitudin odio. Phasellus dui eros, auctor in velit eu, lacinia commodo orci.', 1, '2023-02-18 05:53:42', '2023-02-18 05:53:42', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_families`
--

CREATE TABLE `patient_families` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `family_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_family_details`
--

CREATE TABLE `patient_family_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_location` json DEFAULT NULL,
  `treatment_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `speciality` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_family_details`
--

INSERT INTO `patient_family_details` (`id`, `patient_id`, `name`, `phone`, `relationship`, `dob`, `gender`, `geo_location`, `treatment_country`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`, `speciality`) VALUES
(1, 3, 'Macy Kuhic', '(231) 777-8825', 'father', '2013-09-19 02:52:57', 'male', '\"-6.044267,130.838276\"', 'Denmark', 1, '2023-02-12 06:28:42', '2023-02-12 06:28:42', NULL, NULL, NULL),
(2, 6, 'Noemy Heaney', '+1-430-644-7600', 'mother', '1986-05-17 23:59:03', 'male', '\"47.914826,-124.666931\"', 'Zimbabwe', 1, '2023-02-12 06:57:53', '2023-02-12 06:57:53', NULL, NULL, NULL),
(3, 8, 'dsds', '8787676767', 'Relation', '1998-12-12 00:00:00', 'female', NULL, NULL, 1, '2023-04-01 19:42:53', '2023-04-01 19:42:53', 8, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `patient_testimonies`
--

CREATE TABLE `patient_testimonies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` json DEFAULT NULL,
  `videos` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_testimonies`
--

INSERT INTO `patient_testimonies` (`id`, `patient_id`, `hospital_id`, `doctor_id`, `description`, `images`, `videos`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 2, 1, 1, 'assumenda', '[\"https://via.placeholder.com/640x480.png/00eeaa?text=No%20Image\"]', '[\"voluptatem\"]', 0, '2023-03-05 04:45:23', '2023-03-05 04:45:23', 8, NULL),
(2, 2, 1, 1, 'assumenda', '[\"https://via.placeholder.com/640x480.png/00eeaa?text=No%20Image\", \"https://d3b6u46udi9ohd.cloudfront.net/wp-content/uploads/2016/11/05074959/healthcare21.webp\"]', '[\"https://www.youtube.com/watch?v=54VsMmpTdrU\"]', 0, '2023-03-05 04:48:26', '2023-03-05 04:48:26', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_testimony_tags`
--

CREATE TABLE `patient_testimony_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `testimony_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create_pastquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(2, 'read_pastquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(3, 'update_pastquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(4, 'delete_pastquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(5, 'create_activequery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(6, 'read_activequery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(7, 'update_activequery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(8, 'delete_activequery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(9, 'create_confirmedquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(10, 'read_confirmedquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(11, 'update_confirmedquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(12, 'delete_confirmedquery', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(13, 'create_patientfamily', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(14, 'read_patientfamily', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(15, 'update_patientfamily', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(16, 'delete_patientfamily', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(17, 'create_query', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(18, 'read_query', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(19, 'update_query', 'web', '2023-02-05 08:05:16', '2023-02-05 08:05:16'),
(20, 'delete_query', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(21, 'create_hospitaltreatment', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(22, 'read_hospitaltreatment', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(23, 'update_hospitaltreatment', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(24, 'delete_hospitaltreatment', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(25, 'create_accreditationhospital', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(26, 'read_accreditationhospital', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(27, 'update_accreditationhospital', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(28, 'delete_accreditationhospital', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(29, 'create_doctorpatienttestimonial', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(30, 'read_doctorpatienttestimonial', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(31, 'update_doctorpatienttestimonial', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(32, 'delete_doctorpatienttestimonial', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(33, 'create_doctortag', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(34, 'read_doctortag', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(35, 'update_doctortag', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(36, 'delete_doctortag', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(37, 'create_doctorspecialization', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(38, 'read_doctorspecialization', 'web', '2023-02-05 08:05:17', '2023-02-05 08:05:17'),
(39, 'update_doctorspecialization', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(40, 'delete_doctorspecialization', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(41, 'create_doctorhospital', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(42, 'read_doctorhospital', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(43, 'update_doctorhospital', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(44, 'delete_doctorhospital', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(45, 'create_patienttestimonytag', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(46, 'read_patienttestimonytag', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(47, 'update_patienttestimonytag', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(48, 'delete_patienttestimonytag', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(49, 'create_patienttestimony', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(50, 'read_patienttestimony', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(51, 'update_patienttestimony', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(52, 'delete_patienttestimony', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(53, 'create_detoxificationwellness', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(54, 'read_detoxificationwellness', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(55, 'update_detoxificationwellness', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(56, 'delete_detoxificationwellness', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(57, 'create_detoxificationcategory', 'web', '2023-02-05 08:05:18', '2023-02-05 08:05:18'),
(58, 'read_detoxificationcategory', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(59, 'update_detoxificationcategory', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(60, 'delete_detoxificationcategory', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(61, 'create_wellnesscenter', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(62, 'read_wellnesscenter', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(63, 'update_wellnesscenter', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(64, 'delete_wellnesscenter', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(65, 'create_accomodationfacitity', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(66, 'read_accomodationfacitity', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(67, 'update_accomodationfacitity', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(68, 'delete_accomodationfacitity', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(69, 'create_facility', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(70, 'read_facility', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(71, 'update_facility', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(72, 'delete_facility', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(73, 'create_accomodationtype', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(74, 'read_accomodationtype', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(75, 'update_accomodationtype', 'web', '2023-02-05 08:05:19', '2023-02-05 08:05:19'),
(76, 'delete_accomodationtype', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(77, 'create_accomodation', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(78, 'read_accomodation', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(79, 'update_accomodation', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(80, 'delete_accomodation', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(81, 'create_doctortreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(82, 'read_doctortreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(83, 'update_doctortreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(84, 'delete_doctortreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(85, 'create_specializationtreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(86, 'read_specializationtreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(87, 'update_specializationtreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(88, 'delete_specializationtreatment', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(89, 'create_test', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(90, 'read_test', 'web', '2023-02-05 08:05:20', '2023-02-05 08:05:20'),
(91, 'update_test', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(92, 'delete_test', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(93, 'create_treatment', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(94, 'read_treatment', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(95, 'update_treatment', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(96, 'delete_treatment', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(97, 'create_hospitaltags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(98, 'read_hospitaltags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(99, 'update_hospitaltags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(100, 'delete_hospitaltags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(101, 'create_tags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(102, 'read_tags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(103, 'update_tags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(104, 'delete_tags', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(105, 'create_accreditation', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(106, 'read_accreditation', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(107, 'update_accreditation', 'web', '2023-02-05 08:05:21', '2023-02-05 08:05:21'),
(108, 'delete_accreditation', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(109, 'create_specialization', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(110, 'read_specialization', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(111, 'update_specialization', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(112, 'delete_specialization', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(113, 'create_designation', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(114, 'read_designation', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(115, 'update_designation', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(116, 'delete_designation', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(117, 'create_hospital', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(118, 'read_hospital', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(119, 'update_hospital', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(120, 'delete_hospital', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(121, 'create_patientdetails', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(122, 'read_patientdetails', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(123, 'update_patientdetails', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(124, 'delete_patientdetails', 'web', '2023-02-05 08:05:22', '2023-02-05 08:05:22'),
(125, 'create_patientfamilydetails', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(126, 'read_patientfamilydetails', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(127, 'update_patientfamilydetails', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(128, 'delete_patientfamilydetails', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(129, 'create_qualification', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(130, 'read_qualification', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(131, 'update_qualification', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(132, 'delete_qualification', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(133, 'create_doctor', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(134, 'read_doctor', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(135, 'update_doctor', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(136, 'delete_doctor', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(137, 'create_user', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(138, 'read_user', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(139, 'update_user', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(140, 'delete_user', 'web', '2023-02-05 08:05:23', '2023-02-05 08:05:23'),
(141, 'manage_roles', 'web', '2023-02-05 08:05:24', '2023-02-05 08:05:24');

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
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'Client Login', '7f6b85b9d430c97af1bdd41316cee6a9f2f2414c70065ef6da71e4736aa54f41', '[\"*\"]', '2023-02-05 09:44:54', '2023-02-05 09:43:47', '2023-02-05 09:44:54'),
(2, 'App\\Models\\User', 4, 'Device Login', '3ee53d5ac9a9e9c2dfba8902d84211468f8290733b34c70b705f36980d55deac', '[\"*\"]', NULL, '2023-02-12 00:30:46', '2023-02-12 00:30:46'),
(3, 'App\\Models\\User', 4, 'Device Login', '46bc55329b70c12ddf8de0c0e4eb37bd90af4ba7c229aa7606379113034a78b2', '[\"*\"]', NULL, '2023-02-12 00:34:30', '2023-02-12 00:34:30'),
(4, 'App\\Models\\User', 4, 'Device Login', '08c7440105bc9bdb98ffb30e4a2f33176caa0b5908a796ccd240c335438b59ee', '[\"*\"]', NULL, '2023-02-12 00:37:41', '2023-02-12 00:37:41'),
(5, 'App\\Models\\User', 4, 'Device Login', 'a740051e0e705a4b89663b374f79e11e5ff5fa5de6e299f29103d0beec56087b', '[\"*\"]', NULL, '2023-02-12 00:40:02', '2023-02-12 00:40:02'),
(6, 'App\\Models\\User', 4, 'Device Login', 'f775d20315a47cb48213d6fc03cf5bc725409482e08e329ab322f695f8492a22', '[\"*\"]', NULL, '2023-02-12 00:43:13', '2023-02-12 00:43:13'),
(7, 'App\\Models\\User', 4, 'Device Login', '2a61b92d7ddef493bfe41542acb3aea30830977ffdd3129a056c44c7212d5d1d', '[\"*\"]', NULL, '2023-02-12 02:17:36', '2023-02-12 02:17:36'),
(8, 'App\\Models\\User', 4, 'Client Login', '8d8e4837bf2b45ecbb9d761d5f2dbd0682422846618c12bc01ae42cb6ed34bcf', '[\"*\"]', '2023-02-12 03:07:58', '2023-02-12 03:01:10', '2023-02-12 03:07:58'),
(9, 'App\\Models\\User', 4, 'Client Login', '41b4cb077e584e7a1dd53ee192e6e9bf86cc9aaa87abbf0ce1f420e74f26f563', '[\"*\"]', '2023-02-12 05:50:17', '2023-02-12 05:47:37', '2023-02-12 05:50:17'),
(10, 'App\\Models\\User', 4, 'Device Login', 'b26ddb19e4dcf47ad9a37987e4a2ed05056883dabf5b5b47b6799a67bfea33e9', '[\"*\"]', NULL, '2023-02-15 12:25:21', '2023-02-15 12:25:21'),
(11, 'App\\Models\\User', 4, 'Device Login', 'f2cbaf1489c36c56a9a67a72c826ccaffed9b72955edbe77f691153f1cfeda39', '[\"*\"]', NULL, '2023-02-17 23:26:04', '2023-02-17 23:26:04'),
(12, 'App\\Models\\User', 7, 'Client Login', '30b0e37f94fd89b4da797ced67d8dfdf7f1d05320c899a641fc5757af5cb9bb7', '[\"*\"]', NULL, '2023-02-18 05:33:45', '2023-02-18 05:33:45'),
(13, 'App\\Models\\User', 8, 'Client Login', 'c4d75cf95745d1720a73d82d15c2eb21856ed2483ab29070e7946e65d9f4da83', '[\"*\"]', '2023-02-18 06:12:43', '2023-02-18 05:40:07', '2023-02-18 06:12:43'),
(14, 'App\\Models\\User', 8, 'Client Login', '0b6f844943da3f8150bbe703b012a2ece59ca6a39695350223d7be3140f04163', '[\"*\"]', '2023-02-18 08:07:20', '2023-02-18 07:37:29', '2023-02-18 08:07:20'),
(15, 'App\\Models\\User', 4, 'Device Login', '878b39fa67440cca380466cca3a84046425c75aacbece5f7ceb0f798cf01cf74', '[\"*\"]', NULL, '2023-02-18 08:12:50', '2023-02-18 08:12:50'),
(16, 'App\\Models\\User', 4, 'Device Login', '97b734d0d453353c951fb94c42902de26690613331b2e009a2520abfdf1d253f', '[\"*\"]', NULL, '2023-02-19 21:37:09', '2023-02-19 21:37:09'),
(17, 'App\\Models\\User', 8, 'Client Login', 'fdb1307c1a5e80afaf419de047c2af4d24368d4b692b844a92abb130aec4a0f4', '[\"*\"]', '2023-02-20 09:38:56', '2023-02-20 09:25:35', '2023-02-20 09:38:56'),
(18, 'App\\Models\\User', 8, 'Client Login', 'e4297271fcf6e1ae4a7548d09887a9accd01ba237bb2facd14078021f3520a31', '[\"*\"]', NULL, '2023-02-20 10:33:30', '2023-02-20 10:33:30'),
(19, 'App\\Models\\User', 8, 'Client Login', '4f02d823036cda021278c5bd27e74230e828d59f4ddcf98491131ccddab7ccb6', '[\"*\"]', '2023-02-20 11:06:43', '2023-02-20 10:33:53', '2023-02-20 11:06:43'),
(20, 'App\\Models\\User', 8, 'Client Login', 'c9af5f52d1b87d2440442e36057b8289d199081c284d396d58fa183ad38722ae', '[\"*\"]', '2023-03-04 05:18:02', '2023-03-04 04:23:58', '2023-03-04 05:18:02'),
(21, 'App\\Models\\User', 8, 'Client Login', '543db0115fe427dc12c5362c26fafe81f01c22acc3c17f4ea947cc1b29c71898', '[\"*\"]', NULL, '2023-03-04 04:24:52', '2023-03-04 04:24:52'),
(22, 'App\\Models\\User', 8, 'Client Login', '45681cfe7d9f2ab52f76020e9528cfa9fe23d218f85fc18b10d6bd1243af151b', '[\"*\"]', NULL, '2023-03-04 04:28:15', '2023-03-04 04:28:15'),
(23, 'App\\Models\\User', 8, 'Client Login', '027a17bbd8a1f5692195a2db14fa391a6a91980a4a6ca2c0d3fb25d1c2a33223', '[\"*\"]', '2023-03-04 04:32:07', '2023-03-04 04:32:06', '2023-03-04 04:32:07'),
(24, 'App\\Models\\User', 8, 'Client Login', '3813afa4948d4d88998a6930aeef38d9390c25d5d133173e4ec59e5d987ff121', '[\"*\"]', '2023-03-04 04:33:12', '2023-03-04 04:33:11', '2023-03-04 04:33:12'),
(25, 'App\\Models\\User', 8, 'Client Login', '7d07ed2a871c4e73c811f8e24e604ad28ef6eb727eb0438e5fcbe85162ac04f2', '[\"*\"]', NULL, '2023-03-04 04:35:20', '2023-03-04 04:35:20'),
(26, 'App\\Models\\User', 8, 'Client Login', '027a2dbf2d77aa19c78aa6faf1af475681ccf8f47f1e39df8de90b0107a8626c', '[\"*\"]', NULL, '2023-03-04 04:35:55', '2023-03-04 04:35:55'),
(27, 'App\\Models\\User', 8, 'Client Login', '44d33f6b81f9c7cd23cf31e1f78497811de182cc1900702f78c4a403b01ab56c', '[\"*\"]', '2023-03-04 04:48:56', '2023-03-04 04:48:55', '2023-03-04 04:48:56'),
(28, 'App\\Models\\User', 8, 'Client Login', 'd54ee06c1b00d5601829d0f19968900cd13c58ae473afe4f0a599f306a410aea', '[\"*\"]', '2023-03-04 05:24:09', '2023-03-04 05:24:09', '2023-03-04 05:24:09'),
(29, 'App\\Models\\User', 8, 'Client Login', '892509ccd7a6b8012ba55750c1e5dba1033009926c90649fc5cfee8372e8f70c', '[\"*\"]', '2023-03-04 06:55:09', '2023-03-04 06:26:23', '2023-03-04 06:55:09'),
(30, 'App\\Models\\User', 8, 'Client Login', 'b7b520765a7c61c3704cb130d9f4239707f3c62656208033dfbbde997c54078d', '[\"*\"]', '2023-03-04 07:47:40', '2023-03-04 07:07:40', '2023-03-04 07:47:40'),
(31, 'App\\Models\\User', 8, 'Client Login', '86de62bdfc431dad9f5c062f0131be4514f721a39b46794597bc77211ad16386', '[\"*\"]', '2023-03-04 08:04:39', '2023-03-04 07:30:54', '2023-03-04 08:04:39'),
(32, 'App\\Models\\User', 8, 'Client Login', '92d4fadf906fff791547dc5341521be66275ed35506552fcaff9502b6383b6de', '[\"*\"]', '2023-03-05 01:17:21', '2023-03-05 01:17:19', '2023-03-05 01:17:21'),
(33, 'App\\Models\\User', 8, 'Client Login', '35963a41dfd7b13a4f18a82dc271e259e3a6c5881ea6334ed0037304ad243a2b', '[\"*\"]', '2023-03-05 02:37:16', '2023-03-05 02:37:15', '2023-03-05 02:37:16'),
(34, 'App\\Models\\User', 8, 'Client Login', '25c08ed587066db8dd6384d17c27307d40940a129bf967b3aba662cb769c102c', '[\"*\"]', '2023-03-05 03:45:10', '2023-03-05 03:15:16', '2023-03-05 03:45:10'),
(35, 'App\\Models\\User', 8, 'Client Login', '5c702de0b5039a4182779353733285ec1240b8559ef3be04d8dfe9b7568cda14', '[\"*\"]', '2023-03-05 05:35:42', '2023-03-05 04:40:10', '2023-03-05 05:35:42'),
(36, 'App\\Models\\User', 8, 'Client Login', '3cb359da5ec52c6237f5d2ebc60714405731551f297fdbacbdc1e0b60490adff', '[\"*\"]', '2023-03-05 05:57:29', '2023-03-05 05:38:54', '2023-03-05 05:57:29'),
(37, 'App\\Models\\User', 8, 'Client Login', '1add9c8b5a15350215573f8af9f732e3d6a100f756b313d9c8be8c791387df1e', '[\"*\"]', '2023-03-05 06:29:25', '2023-03-05 05:53:52', '2023-03-05 06:29:25'),
(38, 'App\\Models\\User', 8, 'Client Login', '24aaef7d9b913e50f74ef3137f169906768582fd762819373974424f96d2ca69', '[\"*\"]', '2023-03-05 14:32:41', '2023-03-05 06:47:15', '2023-03-05 14:32:41'),
(39, 'App\\Models\\User', 8, 'Client Login', '4d59f1d092066abccf4d122ae2fda6e6942db8a3044fd677db0fc2cbcfd22d68', '[\"*\"]', '2023-03-05 13:53:18', '2023-03-05 10:22:23', '2023-03-05 13:53:18'),
(40, 'App\\Models\\User', 8, 'Client Login', '721570ee6a7fd684885c1bfa9f4959717cc4cada0508db95a57a40a6fd84f273', '[\"*\"]', '2023-03-05 16:22:31', '2023-03-05 14:05:50', '2023-03-05 16:22:31'),
(41, 'App\\Models\\User', 4, 'Device Login', '9d6122889c2ac4e465664090281bd00e8b2d9ea07dd7c0d5a78e3d633dfd4bf7', '[\"*\"]', NULL, '2023-03-06 09:59:45', '2023-03-06 09:59:45'),
(42, 'App\\Models\\User', 8, 'Client Login', 'e76d224a802d87b1b6369873026fb10a3447adab594afd583d00c7b505e60be0', '[\"*\"]', NULL, '2023-03-07 09:53:19', '2023-03-07 09:53:19'),
(43, 'App\\Models\\User', 8, 'Client Login', 'b36b72ac1e68fb9a7619a42db4046a232b9a7aa41d39cfb5548fd49b4a3168d3', '[\"*\"]', '2023-03-08 03:22:52', '2023-03-08 03:00:57', '2023-03-08 03:22:52'),
(44, 'App\\Models\\User', 8, 'Client Login', '82c19b759ce093897508d24ffc21e116f524f91985bedc9b2be1e1e912cafeb4', '[\"*\"]', '2023-03-08 03:29:46', '2023-03-08 03:29:46', '2023-03-08 03:29:46'),
(45, 'App\\Models\\User', 8, 'Client Login', 'a45a367eec57b4828f6139804e1e9093b602c792c09ad04a9d77ff728aa5f7a0', '[\"*\"]', '2023-03-08 04:52:02', '2023-03-08 04:43:27', '2023-03-08 04:52:02'),
(46, 'App\\Models\\User', 8, 'Client Login', '8037219928794a1b6e0b285c28ec43df16bb1f4d76355494cd870c1d4252f9cb', '[\"*\"]', '2023-03-08 06:04:23', '2023-03-08 05:03:08', '2023-03-08 06:04:23'),
(47, 'App\\Models\\User', 8, 'Client Login', '5b944bf7ec2a66976393bb475883ab06f21367e1b8090ddf78c016a22c708fb7', '[\"*\"]', '2023-03-10 13:08:48', '2023-03-08 05:34:39', '2023-03-10 13:08:48'),
(48, 'App\\Models\\User', 4, 'Device Login', '9782e9e5b76775f4748e7260d3a2538d2443b5225ab05446327cb62fd9cac35b', '[\"*\"]', NULL, '2023-03-08 06:11:47', '2023-03-08 06:11:47'),
(49, 'App\\Models\\User', 8, 'Client Login', 'ca7fefd1ccd7abf51557780c61279282c1dd0f1a594b01e2b505593eaea11ce5', '[\"*\"]', '2023-03-08 07:25:03', '2023-03-08 07:03:02', '2023-03-08 07:25:03'),
(50, 'App\\Models\\User', 4, 'Device Login', 'ee260ba06dc4c3b5abdfc6143f73496519fb1ba98113e76e5f37dee81fc233a3', '[\"*\"]', NULL, '2023-03-10 12:14:41', '2023-03-10 12:14:41'),
(51, 'App\\Models\\User', 8, 'Client Login', '80b1dd3396ddd33672cb792bfc78edc30679f7ea66647ccbeca0e94be588e824', '[\"*\"]', '2023-03-10 13:22:33', '2023-03-10 13:10:48', '2023-03-10 13:22:33'),
(54, 'App\\Models\\User', 8, 'Client Login', '8d15f7083b3de8bef844cd012b1dfc3146a08bf6e07a7d7df1b21d4fb1a9ca84', '[\"*\"]', '2023-03-11 01:11:59', '2023-03-10 23:55:03', '2023-03-11 01:11:59'),
(55, 'App\\Models\\User', 8, 'Client Login', 'b569ed13436d947a65f8f4579f45dab73d6add51ad02924815e51b89092f8195', '[\"*\"]', '2023-03-11 01:16:44', '2023-03-11 00:14:38', '2023-03-11 01:16:44'),
(56, 'App\\Models\\User', 8, 'Client Login', 'aff49890a54e7f7e48b14fa3685d4e11ac1b0f1f3019215bbdfe3a468ce4ebfa', '[\"*\"]', '2023-03-11 01:46:19', '2023-03-11 01:41:05', '2023-03-11 01:46:19'),
(57, 'App\\Models\\User', 8, 'Client Login', '7794777f82bb37636e96b2443750b013024355efab315743d06f0626e405f746', '[\"*\"]', '2023-03-11 21:48:17', '2023-03-11 21:48:16', '2023-03-11 21:48:17'),
(58, 'App\\Models\\User', 8, 'Client Login', 'ba72890cebb29125a434bcd707c8bb08825abd1dbe4d2c959c1438a278c78c0f', '[\"*\"]', '2023-03-11 21:58:03', '2023-03-11 21:55:21', '2023-03-11 21:58:03'),
(59, 'App\\Models\\User', 8, 'Client Login', 'e9ad695d6cc3421df543b5673c423e2694b0b8230090d32b92144090f531b97c', '[\"*\"]', '2023-03-12 03:42:57', '2023-03-12 03:42:56', '2023-03-12 03:42:57'),
(60, 'App\\Models\\User', 8, 'Client Login', '283bad02bad01ad59c43002a9461d3d026305b980d51f0e35681af7e3aaa6aa9', '[\"*\"]', '2023-03-13 06:29:04', '2023-03-12 03:43:57', '2023-03-13 06:29:04'),
(61, 'App\\Models\\User', 8, 'Client Login', 'f18d090d378045ff843d452618a0887d58cfccefb2b62b33c47261effe6d1854', '[\"*\"]', '2023-03-12 06:11:59', '2023-03-12 06:10:53', '2023-03-12 06:11:59'),
(62, 'App\\Models\\User', 4, 'Device Login', '7a3a9198625fd7a08c0fe94311f1a720341ea77a9d6321ebb24449901fac0e85', '[\"*\"]', NULL, '2023-03-15 08:41:13', '2023-03-15 08:41:13'),
(63, 'App\\Models\\User', 4, 'Device Login', '91185d4b452e1412d213834fe8cfaa7b605cd2bcc08e00d7719bbdb1229e99c6', '[\"*\"]', NULL, '2023-03-15 12:09:53', '2023-03-15 12:09:53'),
(64, 'App\\Models\\User', 8, 'Client Login', '12def932eebda4f4613a0f788dd6adcccc9792be97b55a9b9b411c951b83586f', '[\"*\"]', '2023-03-18 10:43:30', '2023-03-16 05:17:28', '2023-03-18 10:43:30'),
(65, 'App\\Models\\User', 4, 'Device Login', '760d437f7b0424745c2e803237c79ea7cb76149b386499b9f97520d86cae9980', '[\"*\"]', NULL, '2023-03-17 23:46:54', '2023-03-17 23:46:54'),
(66, 'App\\Models\\User', 4, 'Device Login', 'd1654ea3b2d266b247a9c5a3fdc2f27eb47625c0b7550de22fe4e722e5d4946b', '[\"*\"]', NULL, '2023-03-18 03:42:23', '2023-03-18 03:42:23'),
(67, 'App\\Models\\User', 4, 'Device Login', '040cf3589586cbf77d6fa61268eec4e2c30a9ba02e69f67dd445a3d21bb7084d', '[\"*\"]', NULL, '2023-03-18 10:23:47', '2023-03-18 10:23:47'),
(68, 'App\\Models\\User', 8, 'Client Login', '125030eb14324ab383cf3bbbc80f2519e8c4194b1b08886fac17790f57c6f531', '[\"*\"]', '2023-03-18 10:43:49', '2023-03-18 10:43:48', '2023-03-18 10:43:49'),
(70, 'App\\Models\\User', 8, 'Client Login', '8d1dc9dc26fefc7f9b084db6c1c6c8c619ed80485accbad28b7418d9e58c5553', '[\"*\"]', '2023-03-18 11:19:39', '2023-03-18 11:19:37', '2023-03-18 11:19:39'),
(71, 'App\\Models\\User', 4, 'Device Login', '328350468979a75eb4ed46e026a594bb99b2008252053a2942b3fec432d1f744', '[\"*\"]', NULL, '2023-04-01 00:19:59', '2023-04-01 00:19:59'),
(72, 'App\\Models\\User', 8, 'Client Login', '98a282c04497dd9b0768ac1ef8003bd2ef2498e6647c7ccfbb442998634ff074', '[\"*\"]', '2023-04-02 08:15:28', '2023-04-01 02:52:09', '2023-04-02 08:15:28'),
(73, 'App\\Models\\User', 8, 'Client Login', '917516627ba5f4d8435a80afa183744ead6f75afb2570d7d6b180012cac490f9', '[\"*\"]', NULL, '2023-04-01 17:46:08', '2023-04-01 17:46:08'),
(74, 'App\\Models\\User', 8, 'Client Login', 'a9f1e1f9a418825284c7f666552f0dd5eea94a5824312f91823b7dd9834ad881', '[\"*\"]', '2023-04-01 20:44:59', '2023-04-01 19:15:06', '2023-04-01 20:44:59'),
(75, 'App\\Models\\User', 4, 'Device Login', '9f2150293f8b212263c03bc6c3d69f725ad0fefda51e5b2fddea69c25d324ca7', '[\"*\"]', NULL, '2023-04-01 20:08:00', '2023-04-01 20:08:00'),
(76, 'App\\Models\\User', 8, 'Client Login', 'dfb9a71253fcee41a4c465e1e35b8cf17f970b7887836cc55d620c41a303c846', '[\"*\"]', '2023-04-02 09:05:53', '2023-04-01 21:06:41', '2023-04-02 09:05:53'),
(77, 'App\\Models\\User', 8, 'Client Login', '2c7dfa9160860588629a90315edacb7d8038e9bc286dec586bc776d75bbb570a', '[\"*\"]', '2023-04-02 09:34:50', '2023-04-01 23:41:37', '2023-04-02 09:34:50'),
(78, 'App\\Models\\User', 8, 'Client Login', '02b73fc4b6d8b543502a292e5cbfcaba9a93fe099af03c6091d3746ad1dc975f', '[\"*\"]', '2023-04-04 11:53:44', '2023-04-02 03:22:09', '2023-04-04 11:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `push_notifications`
--

CREATE TABLE `push_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'MBBS', 0, '2023-02-12 03:05:24', '2023-02-12 03:05:24', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `patient_family_id` bigint(20) UNSIGNED DEFAULT NULL,
  `specialization_id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `medical_history` text COLLATE utf8mb4_unicode_ci,
  `preferred_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_report` text COLLATE utf8mb4_unicode_ci,
  `passport` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `patient_id`, `patient_family_id`, `specialization_id`, `hospital_id`, `doctor_id`, `medical_history`, `preferred_country`, `medical_report`, `passport`, `passport_image`, `status`, `model`, `model_id`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`, `is_completed`, `completed_at`) VALUES
(1, 8, NULL, 3, 1, 2, 'est', 'India', 'et', 'at', 'provident', 'dolorum', 'voluptatem', 1, 1, '2023-02-18 06:05:26', '2023-02-18 06:05:26', 8, NULL, 0, '2023-02-05 06:39:05'),
(2, 8, NULL, 3, 1, 2, 'est', 'Canada', 'et', 'at', 'provident', 'Active', NULL, NULL, 1, '2023-02-18 06:09:02', '2023-02-18 06:09:02', 8, NULL, 0, '2023-02-05 06:39:05'),
(3, 8, NULL, 3, 1, 2, 'est', NULL, 'et', 'at', 'provident', 'Active', NULL, NULL, 1, '2023-02-18 06:10:36', '2023-02-18 06:10:36', 8, NULL, 0, '2023-02-05 06:39:05'),
(4, 8, NULL, 3, 1, 2, 'est', NULL, 'et', 'at', 'provident', 'Active', NULL, NULL, 1, '2023-03-08 05:03:23', '2023-03-08 05:03:23', 8, NULL, 0, '2023-02-05 06:39:05'),
(5, 8, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, 1, '2023-03-08 06:18:36', '2023-03-08 06:18:36', 8, NULL, 0, NULL),
(6, 8, NULL, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, 1, '2023-03-08 06:36:58', '2023-03-08 06:36:58', 8, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'System User', 'web', '2023-02-05 08:05:24', '2023-02-05 08:05:24'),
(2, 'Moderator', 'web', '2023-02-05 08:05:24', '2023-02-05 08:05:24'),
(3, 'Admin', 'web', '2023-02-05 08:05:24', '2023-02-05 08:05:24'),
(4, 'User', 'web', '2023-02-05 08:05:24', '2023-02-05 08:05:24');

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
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(1, 2),
(2, 2),
(3, 2),
(5, 2),
(6, 2),
(7, 2),
(9, 2),
(10, 2),
(11, 2),
(13, 2),
(14, 2),
(15, 2),
(17, 2),
(18, 2),
(19, 2),
(21, 2),
(22, 2),
(23, 2),
(25, 2),
(26, 2),
(27, 2),
(29, 2),
(30, 2),
(31, 2),
(33, 2),
(34, 2),
(35, 2),
(37, 2),
(38, 2),
(39, 2),
(41, 2),
(42, 2),
(43, 2),
(45, 2),
(46, 2),
(47, 2),
(49, 2),
(50, 2),
(51, 2),
(53, 2),
(54, 2),
(55, 2),
(57, 2),
(58, 2),
(59, 2),
(61, 2),
(62, 2),
(63, 2),
(65, 2),
(66, 2),
(67, 2),
(69, 2),
(70, 2),
(71, 2),
(73, 2),
(74, 2),
(75, 2),
(77, 2),
(78, 2),
(79, 2),
(81, 2),
(82, 2),
(83, 2),
(85, 2),
(86, 2),
(87, 2),
(89, 2),
(90, 2),
(91, 2),
(93, 2),
(94, 2),
(95, 2),
(97, 2),
(98, 2),
(99, 2),
(101, 2),
(102, 2),
(103, 2),
(105, 2),
(106, 2),
(107, 2),
(109, 2),
(110, 2),
(111, 2),
(113, 2),
(114, 2),
(115, 2),
(117, 2),
(118, 2),
(119, 2),
(121, 2),
(122, 2),
(123, 2),
(125, 2),
(126, 2),
(127, 2),
(129, 2),
(130, 2),
(131, 2),
(133, 2),
(134, 2),
(135, 2),
(138, 2),
(139, 2),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3),
(89, 3),
(90, 3),
(91, 3),
(92, 3),
(93, 3),
(94, 3),
(95, 3),
(96, 3),
(97, 3),
(98, 3),
(99, 3),
(100, 3),
(101, 3),
(102, 3),
(103, 3),
(104, 3),
(105, 3),
(106, 3),
(107, 3),
(108, 3),
(109, 3),
(110, 3),
(111, 3),
(112, 3),
(113, 3),
(114, 3),
(115, 3),
(116, 3),
(117, 3),
(118, 3),
(119, 3),
(120, 3),
(121, 3),
(122, 3),
(123, 3),
(124, 3),
(125, 3),
(126, 3),
(127, 3),
(128, 3),
(129, 3),
(130, 3),
(131, 3),
(132, 3),
(133, 3),
(134, 3),
(135, 3),
(136, 3),
(137, 3),
(138, 3),
(139, 3),
(140, 3),
(141, 3),
(1, 4),
(2, 4),
(3, 4),
(5, 4),
(6, 4),
(7, 4),
(9, 4),
(10, 4),
(11, 4),
(13, 4),
(14, 4),
(15, 4),
(17, 4),
(18, 4),
(19, 4),
(22, 4),
(26, 4),
(30, 4),
(34, 4),
(38, 4),
(42, 4),
(46, 4),
(49, 4),
(50, 4),
(51, 4),
(54, 4),
(58, 4),
(62, 4),
(66, 4),
(70, 4),
(74, 4),
(78, 4),
(82, 4),
(86, 4),
(90, 4),
(94, 4),
(98, 4),
(101, 4),
(102, 4),
(106, 4),
(110, 4),
(114, 4),
(118, 4),
(121, 4),
(122, 4),
(123, 4),
(125, 4),
(126, 4),
(127, 4),
(130, 4),
(134, 4),
(137, 4),
(138, 4),
(139, 4),
(140, 4);

-- --------------------------------------------------------

--
-- Table structure for table `social_logins`
--

CREATE TABLE `social_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `logo`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'New Specialization', '/img/specialization/spec.png', 1, '2023-02-12 03:04:33', '2023-02-12 03:04:33', 4, NULL),
(2, 'Geriatrics', 'https://via.placeholder.com/640x480.png/00ee55?text=et', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(3, 'Bariatric Medicine/Surgery', 'https://via.placeholder.com/640x480.png/0033aa?text=et', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(4, 'Interventional Radiology', 'https://via.placeholder.com/640x480.png/007722?text=delectus', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(5, 'Geriatrics', 'https://via.placeholder.com/640x480.png/004433?text=adipisci', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(6, 'Pediatric Intensivist', 'https://via.placeholder.com/640x480.png/00cc88?text=enim', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(7, 'Hepatobiliary', 'https://via.placeholder.com/640x480.png/00aabb?text=nesciunt', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(8, 'Hematology/Oncology', 'https://via.placeholder.com/640x480.png/0000cc?text=quo', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(9, 'Geriatrics', 'https://via.placeholder.com/640x480.png/007733?text=nisi', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(10, 'Cardiac Catheterization', 'https://via.placeholder.com/640x480.png/002255?text=unde', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(11, 'Oral Surgery', 'https://via.placeholder.com/640x480.png/0044ff?text=expedita', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(12, 'General Surgery', 'https://via.placeholder.com/640x480.png/007799?text=laboriosam', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(13, 'Ophthalmology', 'https://via.placeholder.com/640x480.png/0044dd?text=molestias', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(14, 'Colorectal Surgery', 'https://via.placeholder.com/640x480.png/0055ff?text=accusamus', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(15, 'Cardiac Catheterization', 'https://via.placeholder.com/640x480.png/0044ee?text=sint', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL),
(16, 'Bariatric Medicine/Surgery', 'https://via.placeholder.com/640x480.png/0011bb?text=qui', 1, '2023-02-12 07:15:20', '2023-02-12 07:15:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `specialization_treatments`
--

CREATE TABLE `specialization_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED NOT NULL,
  `treatment_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'New Test added', 1, '2023-03-15 09:18:56', '2023-03-15 09:36:00', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `images` json DEFAULT NULL,
  `days_required` int(11) NOT NULL,
  `recovery_time` int(11) NOT NULL,
  `success_rate` int(11) NOT NULL,
  `covered` text COLLATE utf8mb4_unicode_ci,
  `not_covered` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `name`, `price`, `images`, `days_required`, `recovery_time`, `success_rate`, `covered`, `not_covered`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'New Treatment', 7876, NULL, 89, 12, 78, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Isaac Christian', 194, '{}', 13, 11, 76, 'Ullamco possimus ra', 'Suscipit ea nisi eum', 1, '2023-03-06 12:36:25', '2023-03-06 12:36:25', 4, NULL),
(3, 'Ronan Jenkins', 794, '{}', 27, 5, 21, 'Error quas incidunt', 'Corporis eaque sunt', 1, '2023-03-06 12:37:12', '2023-03-06 12:37:12', 4, NULL),
(4, 'Malachi Fitzgerald', 801, '{}', 10, 89, 78, 'Magnam quo eos nesci', 'Et omnis consectetur', 1, '2023-03-06 12:38:36', '2023-03-06 12:38:36', 4, NULL),
(5, 'Sara Armstrong', 391, '{}', 7, 85, 9, 'Eum quas omnis labor', 'Eum quisquam tempor', 1, '2023-03-06 12:44:57', '2023-03-06 12:44:57', 4, NULL),
(6, 'Dacey Navarro', 253, '{}', 25, 57, 42, 'Optio dolores sequi', 'Et earum aut et veri', 1, '2023-03-06 12:45:21', '2023-03-06 12:45:21', 4, NULL),
(7, 'Dahlia Conway', 532, '[{}, {}, {}, {}, {}, {}]', 23, 98, 64, 'Non nesciunt est to', 'Ea tempora ratione c', 1, '2023-03-06 12:56:07', '2023-03-06 12:56:07', 4, NULL),
(8, 'Kameko Booth', 494, '[{}, {}, {}, {}, {}]', 22, 85, 75, 'Molestiae aut incidu', 'Natus quo nemo venia', 1, '2023-03-06 12:58:04', '2023-03-06 12:58:04', 4, NULL),
(9, 'Daphne Stephens', 544, '[{}, {}, {}, {}, {}, {}]', 1, 78, 86, 'Iste dolorem cillum', 'Mollitia rem ea veli', 1, '2023-03-06 13:03:07', '2023-03-06 13:03:07', 4, NULL),
(10, 'Jessica Rivera', 676, '[{}, {}, {}, {}]', 23, 98, 90, 'Est obcaecati illum', 'Incidunt minima vol', 1, '2023-03-06 13:04:36', '2023-03-06 13:04:36', 4, NULL),
(11, 'Adara Duran', 626, '[{}, {}, {}]', 13, 3, 82, 'Cillum perferendis q', 'Facilis sint optio', 1, '2023-03-06 13:18:51', '2023-03-06 13:18:51', 4, NULL),
(12, 'Nina Phelps', 530, '[{}, {}, {}]', 5, 53, 94, 'Harum dolor quisquam', 'Aute et assumenda co', 1, '2023-03-06 13:21:13', '2023-03-06 13:21:13', 4, NULL),
(13, 'Shad Gibson', 530, '[{}]', 18, 83, 53, 'Veniam labore ut am', 'Dicta impedit ea ip', 1, '2023-03-06 13:37:20', '2023-03-18 00:21:20', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` char(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `login_reactive_time` timestamp NULL DEFAULT NULL,
  `login_retry_limit` int(11) NOT NULL DEFAULT '0',
  `reset_password_expire_time` timestamp NULL DEFAULT NULL,
  `reset_password_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `phone`, `email_verified_at`, `remember_token`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`, `image`, `gender`, `country`, `dob`, `login_reactive_time`, `login_retry_limit`, `reset_password_expire_time`, `reset_password_code`, `user_type`) VALUES
(1, 'mollitia', 'dolorem', '$2y$10$Fzh0Xc.9jU3TvWrYeQFV7evmJ/rQ8YKH4XQZ80qBeAg9QCg4ciY2W', 'junior14@hotmail.com', '2', '2023-02-05 08:05:24', NULL, 1, '2000-06-02 16:37:55', '2023-02-12 03:00:51', NULL, NULL, 'https://via.placeholder.com/640x480.png/00aa88?text=qui', 'female', 'atque', '1972-01-19', NULL, 2, NULL, NULL, 1),
(2, 'fugiat', 'perspiciatis', '$2y$10$LcdpZd2v4OB4KH3vjfnrUOSa0gQn5FJ9oXSC3FrkGXJG2mI6NfWq2', 'albina19@hotmail.com', '1', '2023-02-05 08:05:24', NULL, 1, '1978-10-16 18:31:28', '1986-11-05 05:47:24', NULL, NULL, 'https://via.placeholder.com/640x480.png/004499?text=aut', 'male', 'consectetur', '1977-10-16', NULL, 0, NULL, NULL, 2),
(3, 'explicabo', 'morris07', '$2y$10$Km.pA1V43q/o13B9KnUJX.UAPDMXQRFyoXHn1XPYeYwiNv2dp19Ju', 'elwyn01@reichel.biz', '1', '2023-02-05 08:05:24', NULL, 1, '1979-11-11 03:32:43', '1982-08-01 03:30:35', NULL, NULL, 'https://via.placeholder.com/640x480.png/004488?text=occaecati', 'male', 'et', '1986-01-25', NULL, 0, NULL, NULL, 2),
(4, 'MMT Admin', 'mmt', '$2y$10$WAI1J00GjFphS7dpOaB7TeOXsNPVk3W6RH998J5V8X.0yhE2hfYra', 'admin@gmail.com', NULL, '2023-02-05 15:10:57', NULL, 1, '2023-02-05 09:30:12', '2023-02-05 09:30:12', NULL, NULL, 'https://via.placeholder.com/640x480.png/006677?text=MMT', 'male', NULL, NULL, NULL, 0, NULL, NULL, 2),
(6, 'Oscar Sauer', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'uhettinger@example.net', '+1-270-234-1826', '2023-02-12 06:57:53', '3rHIWdRjUM', 1, '2023-02-12 06:57:53', '2023-02-12 06:57:53', NULL, NULL, 'https://via.placeholder.com/640x480.png/006677?text=quis', 'male', 'Estonia', '2010-02-23', NULL, 0, NULL, NULL, NULL),
(7, 'Tony', 'Tony', '$2y$10$0OlQi8aLb9YpZyIReXjpQuUGey0H9ZFsJBlgO7lkzEPNJyilhZkh2', 'tony123@gamil.com', NULL, '2023-02-18 05:31:17', NULL, 1, '2023-02-18 05:31:17', '2023-02-18 05:31:17', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1),
(8, 'MMT Users', 'User', '$2y$10$JVyOUe3vYHl1kFeWtUCx9u3iExDnmtIHPuVcaXP7VHbcb140Guvh6', 'user123@gmail.com', '7602121828', '2023-02-18 05:35:36', NULL, 1, '2023-02-18 05:35:36', '2023-04-01 17:47:42', NULL, NULL, NULL, 'male', 'India', '1998-09-09', NULL, 0, NULL, NULL, 1),
(9, 'b', 'b', '$2y$10$D9Q689wmnuRTILIlqkiJtOu8MgVujAecu5ALuBB9i5wuzqVJYLE9u', NULL, NULL, NULL, NULL, 1, '2023-03-11 02:21:16', '2023-03-11 02:21:16', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1),
(10, 'b', 'b', '$2y$10$/Q2Qq/20sD31mUJhteSaMeuLKx9F.p6KpyR0I.h5o.vuMd7qpEsTa', NULL, NULL, NULL, NULL, 1, '2023-03-11 02:21:20', '2023-03-11 02:21:20', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1),
(11, 'b', 'b', '$2y$10$ECQ1bhQO3zDN9yGmm1uUvOYaiLgAqafT6mvzoKwarDSUInL4C1KbG', NULL, NULL, NULL, NULL, 1, '2023-03-11 02:21:24', '2023-03-11 02:21:24', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1),
(12, 'b', 'b', '$2y$10$3lOnq0LHT9LQVDAY5jF3cOPKnKHXMPELxrXkun.nC50wKSHHywryW', 'b', NULL, NULL, NULL, 1, '2023-03-11 02:21:28', '2023-03-11 02:21:28', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1),
(13, 'b', 'b', '$2y$10$YJLHBgudEZGKsIt1aXvU2.jZa1SYc3AdUL.tHTltLaoqctnOhauLq', 'b', NULL, NULL, NULL, 1, '2023-03-11 02:21:28', '2023-03-11 02:21:28', NULL, NULL, NULL, 'male', NULL, NULL, NULL, 0, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wellness_centers`
--

CREATE TABLE `wellness_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` json DEFAULT NULL,
  `geo_location` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wellness_centers`
--

INSERT INTO `wellness_centers` (`id`, `name`, `address`, `description`, `logo`, `image`, `geo_location`, `is_active`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 'Ayurvedagram Heritage Wellness Center', 'Bengaluru, Karnataka', 'Located on the periphery of Bengaluru, Ayurvedagram Heritage Wellness Center is one India’s recognized wellness centers. Ayurveda and Yoga practices are performed here to treat people. Spread in the 9 acres of land, this Ayurvedic healthcare spa renders a gentle touch through Ayurvedic remedies, Yoga, Pranayama, and a vegetarian Ayurvedic diet for their believers. The place offers some attractive tailor-made packages as per guests’ needs which are determined by a doctor. Moreover, this top wellness center in India offers accommodation for its guests in an antique wooden cottage, keeping simple and comfortable.', '', NULL, NULL, 1, '2023-03-18 05:25:45', '2023-03-18 05:25:45', 4, NULL),
(2, 'Ananda in the Himalayas', 'Rishikesh, Uttarakhand', 'One of the top luxury spa resorts in India, Ananda is nestled in the hills of the Great Himalaya in North Indian state of Uttarakhand. The place is spread across 100 acres of land and is surrounded by sal forest. Besides offering varied treatments, the destination is pooled with the views of mighty Himalayan Mountains. They have tailor-made packages which concern an individual’s health, Moreover, they have their team of experts, Ayurvedic doctors, skilled therapist, nutritionist, yogis, and chefs. These experts have a professional approach and they aim to offer the best to their guests in terms of a healthier and sustainable lifestyle.\r\n\r\nSpecialization: The prime Specialization of Ananda is the spa. They have more than 80 varieties of spa therapies which are the mixture of traditional Ayurveda with modern spa. It also offers a range of Ayurvedic treatments- abhyanga, Shirodhara, shloka, takradhara, mukh lepa. Besides, the resort is also famous for Yoga & Meditation therapy, healing treatments, physiotherapy, and Vedanta talk.', '/Applications/MAMP/tmp/php/php8LQCSx', NULL, NULL, 0, '2023-03-18 05:33:08', '2023-03-18 05:33:08', 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodations_type_foreign` (`type`),
  ADD KEY `accommodations_added_by_foreign` (`added_by`),
  ADD KEY `accommodations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `accommodation_facilities`
--
ALTER TABLE `accommodation_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodation_facilities_accommodation_id_foreign` (`accommodation_id`),
  ADD KEY `accommodation_facilities_facility_id_foreign` (`facility_id`),
  ADD KEY `accommodation_facilities_added_by_foreign` (`added_by`),
  ADD KEY `accommodation_facilities_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodation_types_added_by_foreign` (`added_by`),
  ADD KEY `accommodation_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `accreditations`
--
ALTER TABLE `accreditations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accreditations_added_by_foreign` (`added_by`),
  ADD KEY `accreditations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `accreditation_hospitals`
--
ALTER TABLE `accreditation_hospitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accreditation_hospitals_accreditation_id_foreign` (`accreditation_id`),
  ADD KEY `accreditation_hospitals_hospital_id_foreign` (`hospital_id`),
  ADD KEY `accreditation_hospitals_added_by_foreign` (`added_by`),
  ADD KEY `accreditation_hospitals_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `active_queries`
--
ALTER TABLE `active_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active_queries_added_by_foreign` (`added_by`),
  ADD KEY `active_queries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `confirmed_queries`
--
ALTER TABLE `confirmed_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `confirmed_queries_query_id_foreign` (`query_id`),
  ADD KEY `confirmed_queries_accommodation_id_foreign` (`accommodation_id`),
  ADD KEY `confirmed_queries_coordinator_id_foreign` (`coordinator_id`),
  ADD KEY `confirmed_queries_added_by_foreign` (`added_by`),
  ADD KEY `confirmed_queries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_added_by_foreign` (`added_by`),
  ADD KEY `designations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `detoxification_categories`
--
ALTER TABLE `detoxification_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detoxification_categories_added_by_foreign` (`added_by`),
  ADD KEY `detoxification_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `detoxification_wellness`
--
ALTER TABLE `detoxification_wellness`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detoxification_wellness_detoxification_category_id_foreign` (`detoxification_category_id`),
  ADD KEY `detoxification_wellness_wellness_center_id_foreign` (`wellness_center_id`),
  ADD KEY `detoxification_wellness_added_by_foreign` (`added_by`),
  ADD KEY `detoxification_wellness_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`),
  ADD KEY `doctors_qualification_id_foreign` (`qualification_id`),
  ADD KEY `doctors_added_by_foreign` (`added_by`),
  ADD KEY `doctors_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctor_hospitals`
--
ALTER TABLE `doctor_hospitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_hospitals_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_hospitals_hospital_id_foreign` (`hospital_id`),
  ADD KEY `doctor_hospitals_added_by_foreign` (`added_by`),
  ADD KEY `doctor_hospitals_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctor_patient_testimonials`
--
ALTER TABLE `doctor_patient_testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_patient_testimonials_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_patient_testimonials_testimonial_id_foreign` (`testimonial_id`),
  ADD KEY `doctor_patient_testimonials_added_by_foreign` (`added_by`),
  ADD KEY `doctor_patient_testimonials_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctor_specializations`
--
ALTER TABLE `doctor_specializations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_specializations_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_specializations_specialization_id_foreign` (`specialization_id`),
  ADD KEY `doctor_specializations_added_by_foreign` (`added_by`),
  ADD KEY `doctor_specializations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctor_tags`
--
ALTER TABLE `doctor_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_tags_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `doctor_tags_added_by_foreign` (`added_by`),
  ADD KEY `doctor_tags_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `doctor_treatments`
--
ALTER TABLE `doctor_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_treatments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_treatments_treatment_id_foreign` (`treatment_id`),
  ADD KEY `doctor_treatments_added_by_foreign` (`added_by`),
  ADD KEY `doctor_treatments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facilities_added_by_foreign` (`added_by`),
  ADD KEY `facilities_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospitals_added_by_foreign` (`added_by`),
  ADD KEY `hospitals_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `hospital_tags`
--
ALTER TABLE `hospital_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_tags_hospital_id_foreign` (`hospital_id`),
  ADD KEY `hospital_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `hospital_tags_added_by_foreign` (`added_by`),
  ADD KEY `hospital_tags_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `hospital_treatments`
--
ALTER TABLE `hospital_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_treatments_hospital_id_foreign` (`hospital_id`),
  ADD KEY `hospital_treatments_treatment_id_foreign` (`treatment_id`),
  ADD KEY `hospital_treatments_added_by_foreign` (`added_by`),
  ADD KEY `hospital_treatments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `past_queries`
--
ALTER TABLE `past_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `past_queries_user_id_foreign` (`user_id`),
  ADD KEY `past_queries_specialization_id_foreign` (`specialization_id`),
  ADD KEY `past_queries_added_by_foreign` (`added_by`),
  ADD KEY `past_queries_updated_by_foreign` (`updated_by`),
  ADD KEY `past_queries_query_id_foreign` (`query_id`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_details_user_id_foreign` (`user_id`),
  ADD KEY `patient_details_speciality_foreign` (`speciality`),
  ADD KEY `patient_details_added_by_foreign` (`added_by`),
  ADD KEY `patient_details_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `patient_families`
--
ALTER TABLE `patient_families`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_families_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_families_family_id_foreign` (`family_id`),
  ADD KEY `patient_families_added_by_foreign` (`added_by`),
  ADD KEY `patient_families_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `patient_family_details`
--
ALTER TABLE `patient_family_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_family_details_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_family_details_added_by_foreign` (`added_by`),
  ADD KEY `patient_family_details_updated_by_foreign` (`updated_by`),
  ADD KEY `patient_family_details_speciality_foreign` (`speciality`);

--
-- Indexes for table `patient_testimonies`
--
ALTER TABLE `patient_testimonies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_testimonies_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_testimonies_hospital_id_foreign` (`hospital_id`),
  ADD KEY `patient_testimonies_doctor_id_foreign` (`doctor_id`),
  ADD KEY `patient_testimonies_added_by_foreign` (`added_by`),
  ADD KEY `patient_testimonies_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `patient_testimony_tags`
--
ALTER TABLE `patient_testimony_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_testimony_tags_testimony_id_foreign` (`testimony_id`),
  ADD KEY `patient_testimony_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `patient_testimony_tags_added_by_foreign` (`added_by`),
  ADD KEY `patient_testimony_tags_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `push_notifications`
--
ALTER TABLE `push_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_added_by_foreign` (`added_by`),
  ADD KEY `qualifications_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queries_patient_id_foreign` (`patient_id`),
  ADD KEY `queries_patient_family_id_foreign` (`patient_family_id`),
  ADD KEY `queries_specialization_id_foreign` (`specialization_id`),
  ADD KEY `queries_hospital_id_foreign` (`hospital_id`),
  ADD KEY `queries_doctor_id_foreign` (`doctor_id`),
  ADD KEY `queries_added_by_foreign` (`added_by`),
  ADD KEY `queries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specializations_added_by_foreign` (`added_by`),
  ADD KEY `specializations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `specialization_treatments`
--
ALTER TABLE `specialization_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialization_treatments_specialization_id_foreign` (`specialization_id`),
  ADD KEY `specialization_treatments_treatment_id_foreign` (`treatment_id`),
  ADD KEY `specialization_treatments_added_by_foreign` (`added_by`),
  ADD KEY `specialization_treatments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`),
  ADD KEY `tags_added_by_foreign` (`added_by`),
  ADD KEY `tags_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tests_name_unique` (`name`),
  ADD KEY `tests_added_by_foreign` (`added_by`),
  ADD KEY `tests_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treatments_name_unique` (`name`),
  ADD KEY `treatments_added_by_foreign` (`added_by`),
  ADD KEY `treatments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_added_by_foreign` (`added_by`),
  ADD KEY `users_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `wellness_centers`
--
ALTER TABLE `wellness_centers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wellness_centers_name_unique` (`name`),
  ADD KEY `wellness_centers_added_by_foreign` (`added_by`),
  ADD KEY `wellness_centers_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `accommodation_facilities`
--
ALTER TABLE `accommodation_facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accreditations`
--
ALTER TABLE `accreditations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accreditation_hospitals`
--
ALTER TABLE `accreditation_hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `active_queries`
--
ALTER TABLE `active_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `confirmed_queries`
--
ALTER TABLE `confirmed_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detoxification_categories`
--
ALTER TABLE `detoxification_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detoxification_wellness`
--
ALTER TABLE `detoxification_wellness`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_hospitals`
--
ALTER TABLE `doctor_hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_patient_testimonials`
--
ALTER TABLE `doctor_patient_testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_specializations`
--
ALTER TABLE `doctor_specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor_tags`
--
ALTER TABLE `doctor_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_treatments`
--
ALTER TABLE `doctor_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hospital_tags`
--
ALTER TABLE `hospital_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital_treatments`
--
ALTER TABLE `hospital_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `past_queries`
--
ALTER TABLE `past_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_families`
--
ALTER TABLE `patient_families`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_family_details`
--
ALTER TABLE `patient_family_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient_testimonies`
--
ALTER TABLE `patient_testimonies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_testimony_tags`
--
ALTER TABLE `patient_testimony_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `push_notifications`
--
ALTER TABLE `push_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `social_logins`
--
ALTER TABLE `social_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `specialization_treatments`
--
ALTER TABLE `specialization_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wellness_centers`
--
ALTER TABLE `wellness_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `accommodations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accommodations_type_foreign` FOREIGN KEY (`type`) REFERENCES `accommodation_types` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accommodations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `accommodation_facilities`
--
ALTER TABLE `accommodation_facilities`
  ADD CONSTRAINT `accommodation_facilities_accommodation_id_foreign` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accommodation_facilities_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accommodation_facilities_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accommodation_facilities_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  ADD CONSTRAINT `accommodation_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accommodation_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `accreditations`
--
ALTER TABLE `accreditations`
  ADD CONSTRAINT `accreditations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accreditations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `accreditation_hospitals`
--
ALTER TABLE `accreditation_hospitals`
  ADD CONSTRAINT `accreditation_hospitals_accreditation_id_foreign` FOREIGN KEY (`accreditation_id`) REFERENCES `accreditations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accreditation_hospitals_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accreditation_hospitals_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accreditation_hospitals_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `active_queries`
--
ALTER TABLE `active_queries`
  ADD CONSTRAINT `active_queries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `active_queries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `confirmed_queries`
--
ALTER TABLE `confirmed_queries`
  ADD CONSTRAINT `confirmed_queries_accommodation_id_foreign` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `confirmed_queries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `confirmed_queries_coordinator_id_foreign` FOREIGN KEY (`coordinator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `confirmed_queries_query_id_foreign` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `confirmed_queries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `designations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `detoxification_categories`
--
ALTER TABLE `detoxification_categories`
  ADD CONSTRAINT `detoxification_categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detoxification_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `detoxification_wellness`
--
ALTER TABLE `detoxification_wellness`
  ADD CONSTRAINT `detoxification_wellness_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detoxification_wellness_detoxification_category_id_foreign` FOREIGN KEY (`detoxification_category_id`) REFERENCES `detoxification_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detoxification_wellness_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detoxification_wellness_wellness_center_id_foreign` FOREIGN KEY (`wellness_center_id`) REFERENCES `wellness_centers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctors_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_hospitals`
--
ALTER TABLE `doctor_hospitals`
  ADD CONSTRAINT `doctor_hospitals_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctor_hospitals_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_hospitals_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_hospitals_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `doctor_patient_testimonials`
--
ALTER TABLE `doctor_patient_testimonials`
  ADD CONSTRAINT `doctor_patient_testimonials_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctor_patient_testimonials_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_patient_testimonials_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `patient_testimonies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_patient_testimonials_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `doctor_specializations`
--
ALTER TABLE `doctor_specializations`
  ADD CONSTRAINT `doctor_specializations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctor_specializations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_specializations_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_specializations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `doctor_tags`
--
ALTER TABLE `doctor_tags`
  ADD CONSTRAINT `doctor_tags_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctor_tags_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `doctor_treatments`
--
ALTER TABLE `doctor_treatments`
  ADD CONSTRAINT `doctor_treatments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `doctor_treatments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_treatments_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_treatments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `facilities_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD CONSTRAINT `hospitals_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `hospitals_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `hospital_tags`
--
ALTER TABLE `hospital_tags`
  ADD CONSTRAINT `hospital_tags_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `hospital_tags_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `hospital_treatments`
--
ALTER TABLE `hospital_treatments`
  ADD CONSTRAINT `hospital_treatments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `hospital_treatments_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_treatments_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_treatments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

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
-- Constraints for table `past_queries`
--
ALTER TABLE `past_queries`
  ADD CONSTRAINT `past_queries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `past_queries_query_id_foreign` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `past_queries_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `past_queries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `past_queries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD CONSTRAINT `patient_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_details_speciality_foreign` FOREIGN KEY (`speciality`) REFERENCES `specializations` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_families`
--
ALTER TABLE `patient_families`
  ADD CONSTRAINT `patient_families_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_families_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `patient_family_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_families_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_families_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `patient_family_details`
--
ALTER TABLE `patient_family_details`
  ADD CONSTRAINT `patient_family_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_family_details_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_family_details_speciality_foreign` FOREIGN KEY (`speciality`) REFERENCES `specializations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patient_family_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `patient_testimonies`
--
ALTER TABLE `patient_testimonies`
  ADD CONSTRAINT `patient_testimonies_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_testimonies_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_testimonies_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_testimonies_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_testimonies_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `patient_testimony_tags`
--
ALTER TABLE `patient_testimony_tags`
  ADD CONSTRAINT `patient_testimony_tags_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `patient_testimony_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_testimony_tags_testimony_id_foreign` FOREIGN KEY (`testimony_id`) REFERENCES `patient_testimonies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_testimony_tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `qualifications_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `queries_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `queries_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queries_patient_family_id_foreign` FOREIGN KEY (`patient_family_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queries_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queries_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specializations`
--
ALTER TABLE `specializations`
  ADD CONSTRAINT `specializations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `specializations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `specialization_treatments`
--
ALTER TABLE `specialization_treatments`
  ADD CONSTRAINT `specialization_treatments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `specialization_treatments_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `specialization_treatments_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `specialization_treatments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `tests_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `treatments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `treatments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `wellness_centers`
--
ALTER TABLE `wellness_centers`
  ADD CONSTRAINT `wellness_centers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `wellness_centers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
