-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2016 at 02:11 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isacommerce_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address`, `city`, `postcode`, `user_id`, `country_id`, `province_id`, `created_at`, `updated_at`) VALUES
(1, 'Dukuh Pakis', 'Surabaya', '62245', 4, 1, 1, NULL, '2016-09-14 21:27:21'),
(3, 'St.Aaa 12', 'Sydney', '62283', 5, 2, 4, '2016-09-14 21:24:10', '2016-09-14 21:24:19'),
(4, 'Jl.Sumbersari', 'Malang', '54667', 6, 2, 2, NULL, NULL),
(6, 'Dukuh Pakis 3A', 'Surabaya', '62283', 17, 1, 1, '2016-09-27 02:30:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Somat', 'somat@gmail.com', '$2y$10$ZQ/uy7k3gTS.ka0L5gGti.MkI9sGJQ4t24Odq7CyUEJQ4iHW1i/D6', '32u8am0d8UrDpbUKzs1tH6T6AGDzNHtHG8Zdi4UIvfGMJTh2rfImRNHm3YBt', NULL, '2016-10-31 18:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'Size of clothes', 'Y', '2016-10-03 02:58:44', '2016-10-03 03:14:15'),
(2, 'Color', 'Color of product', 'Y', '2016-10-03 03:07:05', '2016-10-03 07:37:18'),
(3, 'Screen Size', 'Size for screen', 'Y', '2016-10-05 07:30:17', '2016-10-05 07:30:17'),
(4, 'Memory', 'Memory for device', 'Y', '2016-10-05 07:31:31', '2016-10-05 07:31:31'),
(5, 'Capacity', 'Capacity Capacity', 'Y', '2016-10-07 01:17:30', '2016-10-07 01:17:30'),
(6, 'CPU', 'CPU CPU CPU', 'Y', '2016-10-26 01:31:39', '2016-10-26 01:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_value`
--

CREATE TABLE `attribute_value` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attribute_value`
--

INSERT INTO `attribute_value` (`id`, `value`, `attribute_id`, `created_at`, `updated_at`) VALUES
(1, 'S', 1, '2016-10-03 06:30:13', '2016-10-03 07:28:29'),
(2, 'M', 1, '2016-10-03 06:30:51', '2016-10-03 07:28:38'),
(4, 'L', 1, '2016-10-03 06:51:24', '2016-10-03 07:34:19'),
(5, 'XL', 1, '2016-10-03 07:32:38', '2016-10-03 07:34:30'),
(8, 'Red', 2, '2016-10-03 07:35:21', '2016-10-03 07:35:21'),
(9, 'Green', 2, '2016-10-03 07:35:27', '2016-10-03 07:35:27'),
(10, 'Blue', 2, '2016-10-03 07:35:31', '2016-10-03 07:35:31'),
(11, 'Soft Pink', 2, '2016-10-05 02:56:02', '2016-10-05 02:56:02'),
(12, '7"', 3, '2016-10-05 07:31:55', '2016-10-05 07:31:55'),
(13, '8"', 3, '2016-10-05 07:32:01', '2016-10-05 07:32:01'),
(14, '9"', 3, '2016-10-05 07:32:07', '2016-10-05 07:32:07'),
(15, '1 GB', 4, '2016-10-05 07:32:43', '2016-10-05 07:32:43'),
(16, '2 GB', 4, '2016-10-05 07:32:50', '2016-10-05 07:32:50'),
(17, '4 GB', 4, '2016-10-05 07:32:55', '2016-10-05 07:32:55'),
(18, '1 Liter', 5, '2016-10-07 01:18:06', '2016-10-07 01:18:06'),
(19, '2 Liter', 5, '2016-10-07 01:18:14', '2016-10-07 01:18:14'),
(20, '3 Liter', 5, '2016-10-07 01:18:20', '2016-10-07 01:18:20'),
(21, '4 Liter', 5, '2016-10-07 01:18:26', '2016-10-07 01:18:26'),
(22, 'Quadcore 1GB', 6, '2016-10-26 01:32:25', '2016-10-26 01:32:25'),
(23, 'Quadcore 2GB', 6, '2016-10-26 01:32:31', '2016-10-26 01:32:31'),
(24, 'Quadcore 4GB', 6, '2016-10-26 01:32:37', '2016-10-26 01:32:37'),
(25, 'Octacore 1GB', 6, '2016-10-26 01:32:45', '2016-10-26 01:32:45'),
(26, 'Octacore 2GB', 6, '2016-10-26 01:32:52', '2016-10-26 01:32:52'),
(27, 'Octacore 4GB', 6, '2016-10-26 01:32:59', '2016-10-26 01:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Samsung', 'N', 'Samsung Samsung', '2016-09-29 21:48:15', '2016-10-06 08:57:01'),
(2, 'Apple', 'Y', 'Pen + Apple = PenApple', '2016-09-30 06:21:17', '2016-09-30 06:26:08'),
(4, 'Lenovo', 'Y', 'Lenovo Lenovo', '2016-09-30 08:06:41', '2016-10-06 08:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `session_id`, `quantity`, `created_at`, `updated_at`) VALUES
(234, 0, 23, '441479433109', 1, '2016-11-18 01:40:41', NULL),
(235, 0, 22, '641479433585', 1, '2016-11-18 01:46:25', NULL),
(236, 0, 23, '911479433693', 1, '2016-11-18 01:48:13', NULL),
(237, 0, 13, '931479434399', 1, '2016-11-18 01:59:59', NULL),
(238, 0, 22, '301480056732', 1, '2016-11-25 06:52:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_seo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_meta_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_meta_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_meta_keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `viewed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `category_name`, `category_seo`, `category_meta_title`, `category_meta_description`, `category_meta_keyword`, `status`, `viewed`, `created_at`, `updated_at`) VALUES
(31, 0, 'Elektronik', 'elektronik', 'Elektronik', 'Elektronik', 'Elektronik', 'Y', 0, '2016-08-21 20:11:38', '2016-08-21 20:11:38'),
(32, 0, 'Fashion', 'fashion', 'Fashion', 'Fashion', 'Fashion', 'Y', 0, '2016-08-21 20:11:52', '2016-08-21 20:11:52'),
(34, 31, 'Coffe Maker', 'coffe-maker', 'Coffe Maker', 'Coffe Maker', 'Coffe Maker', 'Y', 0, '2016-08-21 20:12:47', '2016-08-21 20:12:47'),
(35, 31, 'Elektronik Dapur', 'elektronik-dapur', 'Elektronik Dapur', 'Elektronik Dapur', 'Elektronik Dapur', 'Y', 0, '2016-08-21 20:13:19', '2016-08-21 20:13:19'),
(36, 31, 'Pendingin Ruangan', 'pendingin-ruangan', 'Pendingin Ruangan', 'Pendingin Ruangan', 'Pendingin Ruangan', 'Y', 0, '2016-08-21 20:13:52', '2016-08-21 20:13:52'),
(37, 31, 'Penghisap Debu', 'penghisap-debu', 'Penghisap Debu', 'Penghisap Debu', 'Penghisap Debu', 'Y', 0, '2016-08-21 20:14:19', '2016-08-21 20:14:19'),
(38, 31, 'Audio', 'audio', 'Audio', 'Audio', 'Audio', 'Y', 0, '2016-08-21 20:14:43', '2016-08-21 20:14:43'),
(39, 32, 'Pakaian', 'pakaian', 'Pakaian', 'Pakaian', 'Pakaian', 'Y', 0, '2016-08-21 20:15:09', '2016-08-21 20:15:09'),
(40, 32, 'Jam Tangan', 'jam-tangan', 'Jam Tangan', 'Jam Tangan', 'Jam Tangan', 'Y', 0, '2016-08-21 20:15:37', '2016-08-21 20:15:37'),
(41, 32, 'Tas', 'tas', 'Tas', 'Tas', 'Tas', 'Y', 0, '2016-08-21 20:15:55', '2016-08-21 20:15:55'),
(42, 32, 'Sepatu', 'sepatu', 'Sepatu', 'Sepatu', 'Sepatu', 'Y', 0, '2016-08-21 20:16:20', '2016-08-21 20:16:20'),
(43, 320, 'Aksesoris', 'aksesoris', 'Aksesoris', 'Aksesoris', 'Aksesoris', 'Y', 0, '2016-08-21 20:16:54', '2016-08-21 20:16:54'),
(44, 34, 'Aksesoris Mesin Kopi', 'aksesoris-mesin-kopi', 'Aksesoris Mesin Kopi', 'Aksesoris Mesin Kopi', 'Aksesoris Mesin Kopi', 'Y', 0, '2016-08-21 20:17:48', '2016-08-21 20:17:48'),
(45, 34, 'Penggiling Kopi', 'penggiling-kopi', 'Penggiling Kopi', 'Penggiling Kopi', 'Penggiling Kopi', 'Y', 0, '2016-08-21 20:18:08', '2016-08-21 20:18:08'),
(46, 34, 'Mesin Kopi Kapsul', 'mesin-kopi-kapsul', 'Mesin Kopi Kapsul', 'Mesin Kopi Kapsul', 'Mesin Kopi Kapsul', 'Y', 0, '2016-08-21 20:18:24', '2016-08-21 20:18:24'),
(47, 34, 'Mesin Kopi Otomatis', 'mesin-kopi-otomatis', 'Mesin Kopi Otomatis', 'Mesin Kopi Otomatis', 'Mesin Kopi Otomatis', 'Y', 0, '2016-08-21 20:18:38', '2016-08-21 20:18:38'),
(48, 34, 'Mesin Kopi Manual', 'mesin-kopi-manual', 'Mesin Kopi Manual', 'Mesin Kopi Manual', 'Mesin Kopi Manual', 'Y', 0, '2016-08-21 20:19:13', '2016-08-21 20:19:13'),
(49, 35, 'Timbangan Dapur', 'timbangan-dapur', 'Timbangan Dapur', 'Timbangan Dapur', 'Timbangan Dapur', 'Y', 0, '2016-08-21 20:19:59', '2016-08-21 20:19:59'),
(50, 35, 'Penggiling Daging', 'penggiling-daging', 'Penggiling Daging', 'Penggiling Daging', 'Penggiling Daging', 'Y', 0, '2016-08-21 20:20:17', '2016-08-21 20:20:17'),
(51, 35, 'Pemotong Elektrik', 'pemotong-elektrik', 'Pemotong Elektrik', 'Pemotong Elektrik', 'Pemotong Elektrik', 'Y', 0, '2016-08-21 20:20:32', '2016-08-21 20:20:32'),
(52, 35, 'Pengupas Elektrik', 'pengupas-elektrik', 'Pengupas Elektrik', 'Pengupas Elektrik', 'Pengupas Elektrik', 'Y', 0, '2016-08-21 20:20:48', '2016-08-21 20:20:48'),
(53, 35, 'Thermo Pot', 'thermo-pot', 'Thermo Pot', 'Thermo Pot', 'Thermo Pot', 'Y', 0, '2016-08-21 20:21:12', '2016-08-21 20:21:12'),
(54, 36, 'Penghisap Udara', 'penghisap-udara', 'Penghisap Udara', 'Penghisap Udara', 'Penghisap Udara', 'Y', 0, '2016-08-21 20:21:55', '2016-08-21 20:21:55'),
(55, 36, ' Kipas Angin', 'kipas-angin', ' Kipas Angin', '\r\nKipas Angin', '\r\nKipas Angin', 'Y', 0, '2016-08-21 20:22:12', '2016-08-21 20:22:12'),
(56, 36, 'Air Conditioner', 'air-conditioner', 'Air Conditioner', 'Air Conditioner', 'Air Conditioner', 'Y', 0, '2016-08-21 20:22:30', '2016-08-21 20:22:30'),
(57, 37, 'Penghisap Debu Robotik', 'penghisap-debu-robotik', 'Penghisap Debu Robotik', 'Penghisap Debu Robotik', 'Penghisap Debu Robotik', 'Y', 0, '2016-08-21 20:23:07', '2016-08-21 20:23:07'),
(58, 37, 'Sapu Elektrik', 'sapu-elektrik', 'Sapu Elektrik', 'Sapu Elektrik', 'Sapu Elektrik', 'Y', 0, '2016-08-21 20:23:25', '2016-08-21 20:23:25'),
(59, 37, 'Penghisap Debu Canister', 'penghisap-debu-canister', 'Penghisap Debu Canister', 'Penghisap Debu Canister', 'Penghisap Debu Canister', 'Y', 0, '2016-08-21 20:23:41', '2016-08-21 20:23:41'),
(60, 37, 'Penghisap Debu Kendaraan', 'penghisap-debu-kendaraan', 'Penghisap Debu Kendaraan', 'Penghisap Debu Kendaraan', 'Penghisap Debu Kendaraan', 'Y', 0, '2016-08-21 20:23:58', '2016-08-21 20:23:58'),
(61, 38, 'Aksesoris Audio', 'aksesoris-audio', 'Aksesoris Audio', 'Aksesoris Audio', 'Aksesoris Audio', 'Y', 0, '2016-08-21 20:24:31', '2016-08-21 20:24:31'),
(62, 38, 'Speaker', 'speaker', 'Speaker', 'Speaker', 'Speaker', 'Y', 0, '2016-08-21 20:24:54', '2016-08-21 20:24:54'),
(63, 38, 'Headset', 'headset', 'Headset', 'Headset', 'Headset', 'Y', 0, '2016-08-21 20:25:07', '2016-08-21 20:25:07'),
(64, 38, 'Karaoke', 'karaoke', 'Karaoke', 'Karaoke\r\n', 'Karaoke\r\n', 'Y', 0, '2016-08-21 20:25:22', '2016-08-21 20:25:22'),
(65, 38, 'Audio Player', 'audio-player', 'Audio Player', 'Audio Player', 'Audio Player', 'Y', 0, '2016-08-21 20:25:36', '2016-08-21 20:25:36'),
(66, 39, 'Baju Tidur', 'baju-tidur', 'Baju Tidur', 'Baju Tidur', 'Baju Tidur', 'Y', 0, '2016-08-21 20:26:40', '2016-08-21 20:26:40'),
(67, 39, 'Outerwear', 'outerwear', 'Outerwear', 'Outerwear', 'Outerwear', 'Y', 0, '2016-08-21 20:26:55', '2016-08-21 20:26:55'),
(68, 39, 'Batik & Etnik', 'batik-etnik', 'Batik & Etnik', 'Batik & Etnik', 'Batik & Etnik', 'Y', 0, '2016-08-21 20:27:11', '2016-08-21 20:27:11'),
(69, 39, 'Celana', 'celana', 'Celana', 'Celana', 'Celana', 'Y', 0, '2016-08-21 20:27:27', '2016-08-21 20:27:27'),
(70, 39, 'T Shirt', 't-shirt', 'T Shirt', 'T Shirt', 'T Shirt', 'Y', 0, '2016-08-21 20:28:07', '2016-08-21 20:28:07'),
(71, 40, 'Jam Tangan Kasual', 'jam-tangan-kasual', 'Jam Tangan Kasual', 'Jam Tangan Kasual', 'Jam Tangan Kasual', 'Y', 0, '2016-08-21 20:28:40', '2016-08-21 20:28:40'),
(72, 40, 'Jam Tangan Sport', 'jam-tangan-sport', 'Jam Tangan Sport', 'Jam Tangan Sport', 'Jam Tangan Sport', 'Y', 0, '2016-08-21 20:29:01', '2016-08-21 20:29:01'),
(73, 40, 'Jam Tangan Fashion', 'jam-tangan-fashion', 'Jam Tangan Fashion', 'Jam Tangan Fashion', 'Jam Tangan Fashion', 'Y', 0, '2016-08-21 20:29:20', '2016-08-21 20:29:20'),
(74, 41, 'Dompet', 'dompet', 'Dompet', 'Dompet', 'Dompet', 'Y', 0, '2016-08-21 20:29:56', '2016-08-21 20:29:56'),
(75, 41, 'Tas Ransel', 'tas-ransel', 'Tas Ransel', 'Tas Ransel', 'Tas Ransel', 'Y', 0, '2016-08-21 20:30:16', '2016-08-21 20:30:16'),
(76, 41, 'Tas Selempang', 'tas-selempang', 'Tas Selempang', 'Tas Selempang', 'Tas Selempang', 'Y', 0, '2016-08-21 20:30:33', '2016-08-21 20:30:33'),
(77, 41, 'Sling bag', 'sling-bag', 'Sling bag', 'Sling bag', 'Sling bag', 'Y', 0, '2016-08-21 20:31:00', '2016-08-21 20:31:00'),
(78, 42, 'Sepatu Sneaker Wanita', 'sepatu-sneaker-wanita', 'Sepatu Sneaker Wanita', 'Sepatu Sneaker Wanita', 'Sepatu Sneaker Wanita', 'Y', 0, '2016-08-21 20:31:45', '2016-08-21 20:31:45'),
(79, 42, 'Boots', 'boots', 'Boots', 'Boots', 'Boots', 'Y', 0, '2016-08-21 20:31:58', '2016-08-21 20:31:58'),
(80, 42, 'Heels', 'heels', 'Heels', 'Heels', 'Heels', 'Y', 0, '2016-08-21 20:32:11', '2016-08-21 20:32:11'),
(81, 42, 'Sandal Wanita', 'sandal-wanita', 'Sandal Wanita', 'Sandal Wanita', 'Sandal Wanita', 'Y', 0, '2016-08-21 20:32:26', '2016-08-21 20:32:26'),
(82, 42, 'Flats & Ballerina', 'flats-ballerina', 'Flats & Ballerina', 'Flats & Ballerina', 'Flats & Ballerina', 'Y', 0, '2016-08-21 20:32:39', '2016-08-21 20:32:39'),
(83, 42, 'Wedges', 'wedges', 'Wedges', 'Wedges', 'Wedges', 'Y', 0, '2016-08-21 20:32:55', '2016-08-21 20:32:55'),
(84, 43, 'Scraft & Shawl', 'scraft-shawl', 'Scraft & Shawl', 'Scraft & Shawl', 'Scraft & Shawl', 'Y', 0, '2016-08-21 20:33:39', '2016-08-21 20:33:39'),
(85, 43, 'Ikat Pinggang', 'ikat-pinggang', 'Ikat Pinggang', 'Ikat Pinggang', 'Ikat Pinggang', 'Y', 0, '2016-08-21 20:33:57', '2016-08-21 20:33:57'),
(87, 43, 'Perhiasan', 'perhiasan', 'Perhiasan', 'Perhiasan', 'Perhiasan', 'Y', 0, '2016-08-21 20:34:28', '2016-08-21 20:34:28'),
(88, 39, 'Hijab', 'hijab', 'Hijab Syar''i', 'Hijab', 'Hijab', 'Y', 0, '2016-09-14 20:37:26', '2016-09-14 20:59:30'),
(89, 31, 'Handphone and Tablet', 'handphone-and-tablet', 'Handphone and Tablet', 'Handphone and Tablet', 'Handphone and Tablet', 'Y', 0, '2016-09-28 20:41:24', '2016-09-28 20:41:24'),
(90, 89, 'Handphone', 'handphone', 'Handphone', 'Handphone', 'Handphone', 'Y', 0, '2016-09-28 20:41:53', '2016-09-28 20:41:53'),
(91, 89, 'Tablet', 'tablet', 'Tablet', 'Tablet', 'Tablet', 'Y', 0, '2016-09-28 20:42:11', '2016-09-28 20:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `iso_code`, `created_at`, `updated_at`) VALUES
(1, 'Indonesia', '1', NULL, NULL),
(2, 'Australia', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `discount_operation` enum('-','%','s') COLLATE utf8_unicode_ci NOT NULL,
  `discount_amount` double(12,2) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `product_id`, `is_active`, `discount_operation`, `discount_amount`, `expiry`, `created_at`, `updated_at`) VALUES
(16, '55', 'Y', '%', 90.00, '1970-01-01 00:00:00', '2016-10-06 08:37:33', '2016-10-06 08:37:50'),
(17, '56', 'Y', '-', 200000.00, '2016-10-28 00:00:00', '2016-10-06 08:42:58', '2016-10-21 06:49:09'),
(18, '57', 'Y', '%', 10.00, '2016-10-22 00:00:00', '2016-10-06 08:58:03', '2016-10-07 01:20:22'),
(19, '58', 'Y', '%', 20.00, '2016-10-21 00:00:00', '2016-10-06 08:58:20', '2016-10-07 01:24:00'),
(20, '10', 'Y', '%', 20.00, '2016-03-08 00:00:00', '2016-10-06 09:13:11', '2016-10-06 09:13:37'),
(22, '60', 'Y', '-', 250000.00, '2016-10-29 00:00:00', '2016-10-07 01:46:32', '2016-10-07 01:46:51'),
(23, '31', 'Y', '%', 50.00, '2016-11-17 00:00:00', '2016-10-07 02:31:04', '2016-11-08 06:56:23'),
(24, '61', 'Y', '%', 10.00, '2016-10-28 00:00:00', '2016-10-07 03:21:51', '2016-10-07 03:21:51'),
(25, '22', 'Y', '%', 10.00, '2016-10-30 00:00:00', '2016-10-07 03:24:49', '2016-10-07 03:24:49'),
(27, '63', 'Y', '-', 10000.00, '2016-10-28 00:00:00', '2016-10-07 04:35:26', '2016-10-07 04:35:26'),
(29, '70', 'Y', 's', 3000000.00, '2016-11-15 00:00:00', '2016-10-26 03:55:42', '2016-11-08 06:53:13'),
(30, '74', 'Y', '%', 20.00, '2016-03-08 00:00:00', '2016-11-08 06:24:59', '2016-11-08 06:25:19'),
(31, '75', 'Y', '%', 20.00, '2016-03-08 00:00:00', '2016-11-08 06:25:45', '2016-11-08 06:25:45'),
(32, '68', 'Y', '%', 15.00, '2016-12-02 00:00:00', '2016-11-08 07:08:43', '2016-11-08 07:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image`, `product_id`, `created_at`, `updated_at`) VALUES
(8, '1471859688.jpg', 9, '2016-08-22 02:54:48', NULL),
(9, '1471860242.jpg', 10, '2016-08-22 03:04:02', NULL),
(14, '1471918742.jpg', 11, '2016-08-22 19:19:02', NULL),
(15, '1471919100.jpg', 12, '2016-08-22 19:25:00', NULL),
(16, '1471919610.jpg', 13, '2016-08-22 19:33:30', NULL),
(17, '1471920024.jpg', 14, '2016-08-22 19:40:24', NULL),
(18, '1471920298.jpg', 15, '2016-08-22 19:44:58', NULL),
(19, '1471920600.jpg', 16, '2016-08-22 19:50:00', NULL),
(20, '1471920907.jpg', 17, '2016-08-22 19:55:07', NULL),
(21, '1471921175.jpg', 18, '2016-08-22 19:59:35', NULL),
(22, '1471922206.jpg', 19, '2016-08-22 20:16:46', NULL),
(23, '1471922616.jpg', 20, '2016-08-22 20:23:36', NULL),
(24, '1471922964.jpg', 21, '2016-08-22 20:29:24', NULL),
(25, '1471923252.jpg', 22, '2016-08-22 20:34:12', NULL),
(26, '1471923537.jpg', 23, '2016-08-22 20:38:57', NULL),
(27, '1471923809.jpg', 24, '2016-08-22 20:43:29', NULL),
(28, '1471924482.jpg', 26, '2016-08-22 20:54:42', NULL),
(29, '1471924875.jpg', 27, '2016-08-22 21:01:15', NULL),
(47, '1472781267.jpg', 25, '2016-09-01 11:54:27', NULL),
(52, '1473995366.jpg', 29, '2016-09-15 20:09:26', NULL),
(53, '1473995982.jpg', 30, '2016-09-15 20:19:42', NULL),
(54, '1475120231.PNG', 31, '2016-09-28 20:37:11', NULL),
(55, '1475120340.jpg', 31, '2016-09-28 20:39:00', NULL),
(57, '1475122520.PNG', 32, '2016-09-28 21:15:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_05_24_073233_create_admins_table', 1),
('2016_08_23_040856_create_permission_tables', 2),
('2016_09_09_082301_entrust_setup_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `session_id`, `expire_time`, `created_at`, `updated_at`) VALUES
('0V69aWHQwr2udvoqChRWI2kpszBfyB2uSO7XQlEB', 51, 1474949857, '2016-09-27 03:17:37', '2016-09-27 03:17:37'),
('2EYGWQvixe0vo4qCd4qr4bIuHbTRhJqUVKb7NYcQ', 20, 1470382447, '2016-08-05 06:34:07', '2016-08-05 06:34:07'),
('50y4wyJJz0R4zpXhkhGyQwTqz1r8cahCOC9DptQc', 5, 1470192194, '2016-08-03 01:43:14', '2016-08-03 01:43:14'),
('7IHRGUROFO1WMvUP6sZOOc1iVpEges4i00wfOa8D', 32, 1474518447, '2016-09-22 03:27:27', '2016-09-22 03:27:27'),
('AcMC7S7aJ3G2sFNiQ79gHlOo4aFUBxdaYBnlvgxx', 39, 1474605527, '2016-09-23 03:38:47', '2016-09-23 03:38:47'),
('AWm9IA1C3owfLZmevXZpqBcOOxud1p9boOFdsOTB', 13, 1470195573, '2016-08-03 03:38:33', '2016-08-03 03:38:33'),
('Bdi4R4RonkUXUHXFBCCzZKu0QbDs2Hwji1IP6saE', 30, 1474514225, '2016-09-22 02:17:06', '2016-09-22 02:17:06'),
('bDNe0JqGt99emYlFanu5NVeJjhd38M54x3UGeTL9', 47, 1474873381, '2016-09-26 06:03:01', '2016-09-26 06:03:01'),
('C9PMBLQnX7q13VZBZjwlD01hmKrMZy0k5sOX5MYQ', 49, 1474885706, '2016-09-26 09:28:26', '2016-09-26 09:28:26'),
('cClx5k8Qf7BNXRRzWtqmCCZyOpNnyFbwUQ819ppr', 34, 1474531992, '2016-09-22 07:13:12', '2016-09-22 07:13:12'),
('DI47mtuCwrMOoI15uR6H98uXeQYdh2oMsg4lX6fX', 24, 1470623579, '2016-08-08 01:32:59', '2016-08-08 01:32:59'),
('DQ7O57onu4X7pKBgK8u5vllIgsvxL3t3CAQ1zDNN', 6, 1470193117, '2016-08-03 01:58:37', '2016-08-03 01:58:37'),
('DXHVjhkoAlWX54sNPBZ2anLqibaxhs4OFVNZfpOY', 2, 1470190928, '2016-08-03 01:22:08', '2016-08-03 01:22:08'),
('etMwT16NZhptbgmpVgtn8olFTNSMZ65BMo1sc54n', 26, 1474512766, '2016-09-22 01:52:46', '2016-09-22 01:52:46'),
('fEGSoUInrfwIoV9y370TMT6kuQDz8OeYAd7Yac1q', 44, 1474859817, '2016-09-26 02:16:57', '2016-09-26 02:16:57'),
('H1WszcQq9DIMZo1UGR5rldL82xpEYf9uPk8fwSqV', 25, 1472704292, '2016-09-01 03:31:32', '2016-09-01 03:31:32'),
('hVIXGTnrCFdKs2pgFATXMzvW2Fj169s8GiKTI7S9', 41, 1474619860, '2016-09-23 07:37:40', '2016-09-23 07:37:40'),
('i7BEFJR8wf9STBwUebs9wRbQ6LnHFi3XpaOLjYEl', 35, 1474535701, '2016-09-22 08:15:01', '2016-09-22 08:15:01'),
('iCeujSGKIoq0utqTSjAq8fUmYo3Y17ATXX8Biwvn', 11, 1470193966, '2016-08-03 03:11:46', '2016-08-03 03:11:46'),
('jMepWN7MR7fGC1c0ChjFmycjv1wyEL9JuYRLqst2', 12, 1470197830, '2016-08-03 03:17:11', '2016-08-03 03:17:11'),
('JqmQwWJCM5BuhBdwu8SmMR4jJgVW1X7zIDoZJsUl', 43, 1474627650, '2016-09-23 09:47:30', '2016-09-23 09:47:30'),
('JQONPdmmTT2dXBxZAatrLmLhY1gbuHPnby7dRGNs', 48, 1474879420, '2016-09-26 07:43:40', '2016-09-26 07:43:40'),
('k4d12gHMirPbNiHb5BPEV8dMd94IWLiuDxZlooUA', 18, 1470373374, '2016-08-05 04:02:54', '2016-08-05 04:02:54'),
('LoDo5ZhWzQetY6SKgnMXTHGrv2iizVTqG08qaXi8', 23, 1470391589, '2016-08-05 09:06:29', '2016-08-05 09:06:29'),
('NdeTh2skerlAdpFvUyCIeiMOJ6UBSDUpyUvG499o', 36, 1474540253, '2016-09-22 09:30:53', '2016-09-22 09:30:53'),
('o4Svv8cbz6Pf1xkq4ICMdDZNaBqd9gYCEcZq3eX5', 4, 1470191809, '2016-08-03 01:36:49', '2016-08-03 01:36:49'),
('OqPNfjBoPXhqmkKBcOvFvdZN8jw6VcEWluC70YzQ', 37, 1474597799, '2016-09-23 01:30:00', '2016-09-23 01:30:00'),
('PcUP0qj26JjOsKrIJtlhDUrv0dYeSzEiKzVodNlj', 50, 1474942579, '2016-09-27 01:16:19', '2016-09-27 01:16:19'),
('pm6w5oG8ab1pY8lEC94antz4Kwm0NsBXnjtaIfws', 17, 1470214191, '2016-08-03 07:49:51', '2016-08-03 07:49:51'),
('PMVdvPJIXMY0XKkHEQITOenZqUXeLbIpRpcYt8PO', 15, 1470201460, '2016-08-03 04:17:40', '2016-08-03 04:17:40'),
('pwBddZsIhB6aTdsHzOOvZWW7lYv0ZJT837d6naXf', 46, 1474862258, '2016-09-26 02:57:38', '2016-09-26 02:57:38'),
('S7FbT1eZH8fwPXwwxBYCDwcfm6LcMx7fnNbt9yt8', 45, 1474861331, '2016-09-26 02:42:11', '2016-09-26 02:42:11'),
('sbuWDClVlg9mjxK4WmkRZQ5FKl62nCZHaLOlZ38U', 27, 1474513843, '2016-09-22 02:10:43', '2016-09-22 02:10:43'),
('SglhdubGMibbQ7V0WS2yKXmvapmAALkcCQIi3vBi', 22, 1470387372, '2016-08-05 07:56:12', '2016-08-05 07:56:12'),
('ssz02UhgOYfiwsmreh0a0ShPMR5QRbPWQ8SJQC99', 8, 1470193531, '2016-08-03 02:05:31', '2016-08-03 02:05:31'),
('SXLJXMFqQDkBdffGdj5kY9IKfcgvUAsBc1OO4WBM', 28, 1474514024, '2016-09-22 02:13:44', '2016-09-22 02:13:44'),
('TaN4RgXpnnPn8x5S1tcYq6i3ApS2wwZ0aP8CyMss', 7, 1470193235, '2016-08-03 02:00:35', '2016-08-03 02:00:35'),
('ThihWCmBkL2prMdm692Ca24sUmsNEHNIXXKvEQE0', 29, 1474514212, '2016-09-22 02:16:52', '2016-09-22 02:16:52'),
('uRzOYVttUjlWDx3AFCa4HVmbiM56DFU5zi7ZkQcy', 10, 1470194395, '2016-08-03 02:19:55', '2016-08-03 02:19:55'),
('VHEnjASJuLEjYnpfANpB9HNpd7idXqsP5HaDbjPJ', 3, 1470191795, '2016-08-03 01:36:36', '2016-08-03 01:36:36'),
('VOhRnaqzu6Hhpct33ZwO2Fq9J7FDOD01Zk4rvEKO', 9, 1470193616, '2016-08-03 02:06:56', '2016-08-03 02:06:56'),
('wFaO6h30XucvAKODOGVrpt733AOjXnRfiOmH1A0R', 19, 1470373401, '2016-08-05 04:03:21', '2016-08-05 04:03:21'),
('WpFBZf7Z8g7ObAIK1XQEsYLZ3kHhTDYM067g5JAE', 14, 1470199147, '2016-08-03 03:39:07', '2016-08-03 03:39:07'),
('Xu05xuLZPwg8ndfgIN8HC9eZR8ZvzKrLZF06YvHr', 21, 1470386937, '2016-08-05 07:48:57', '2016-08-05 07:48:57'),
('y10sUw1UmZZHPQow0nt2qokoGKo7MCwl71kCQPrs', 31, 1474514838, '2016-09-22 02:27:18', '2016-09-22 02:27:18'),
('yCr8sluGzoNO6G7eLSqvMA8CYz6gRZTKqbbltkT9', 33, 1474522076, '2016-09-22 04:27:56', '2016-09-22 04:27:56'),
('zBMEdlHIX7IXlIXc0ystm8XnbkQ8AUTFIaw1UrFT', 42, 1474623533, '2016-09-23 08:38:53', '2016-09-23 08:38:53'),
('zixylwO0MB7G2XcxyNzE4rjBwfeDrCMjp6Z1jDVt', 38, 1474601267, '2016-09-23 02:27:48', '2016-09-23 02:27:48'),
('ZObf8AmnAiXIlkeMSwfrpHGLS3lXYsE3iqXDNd6N', 40, 1474615726, '2016-09-23 06:28:46', '2016-09-23 06:28:46'),
('ZPzQjFCUniVctl94fXrx4LZMne6q9g7RBPqnqD6x', 1, 1470190654, '2016-08-03 01:17:34', '2016-08-03 01:17:34'),
('ZsBPmdjuev3Dj00ntDcX4iSxResnQfOty0jiKvBL', 16, 1470208803, '2016-08-03 06:20:03', '2016-08-03 06:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_token_scopes`
--

CREATE TABLE `oauth_access_token_scopes` (
  `id` int(10) UNSIGNED NOT NULL,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_code_scopes`
--

CREATE TABLE `oauth_auth_code_scopes` (
  `id` int(10) UNSIGNED NOT NULL,
  `auth_code_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `created_at`, `updated_at`) VALUES
('7e55234f', 'AdfGh65niuhxkjnmKldxgSw98wu67', 'Featours 1', '2016-08-01 17:00:00', NULL),
('klj87au8h', 'AdfGh65niuhxkjnmKldxgSw98wu67', 'Featours 2', '2016-07-31 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_client_endpoints`
--

CREATE TABLE `oauth_client_endpoints` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_client_grants`
--

CREATE TABLE `oauth_client_grants` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_client_scopes`
--

CREATE TABLE `oauth_client_scopes` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_grants`
--

CREATE TABLE `oauth_grants` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_grant_scopes`
--

CREATE TABLE `oauth_grant_scopes` (
  `id` int(10) UNSIGNED NOT NULL,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `expire_time`, `created_at`, `updated_at`) VALUES
('uZSDb1bTe5ZTwEsbHuFi8PL6bH7GjF3bniWCLTaP', '0V69aWHQwr2udvoqChRWI2kpszBfyB2uSO7XQlEB', 1474982257, '2016-09-27 03:17:37', '2016-09-27 03:17:37'),
('BEFYvyuryG6dWNrcMwR9V3E3Xqs6YT1HfrhStbmD', '2EYGWQvixe0vo4qCd4qr4bIuHbTRhJqUVKb7NYcQ', 1470414847, '2016-08-05 06:34:07', '2016-08-05 06:34:07'),
('PwiJ6HVgiT02eqs5itBBUrFNOSZwLEEk7sgLkqAx', '7IHRGUROFO1WMvUP6sZOOc1iVpEges4i00wfOa8D', 1474550847, '2016-09-22 03:27:28', '2016-09-22 03:27:28'),
('H1q0XAAybZQ1oRh7OzC7oLiAiOCZTMEfiDOsdCbO', 'AcMC7S7aJ3G2sFNiQ79gHlOo4aFUBxdaYBnlvgxx', 1474637927, '2016-09-23 03:38:47', '2016-09-23 03:38:47'),
('7U3bk2WtLhQU0TZmOcogG7f7thZnsQ4bjc4VE2kF', 'AWm9IA1C3owfLZmevXZpqBcOOxud1p9boOFdsOTB', 1470231513, '2016-08-03 03:38:33', '2016-08-03 03:38:33'),
('bJ3Juyd1pgvjb2EPA2Kmb4eZOuWYU0A12qMKyyWP', 'Bdi4R4RonkUXUHXFBCCzZKu0QbDs2Hwji1IP6saE', 1474546625, '2016-09-22 02:17:06', '2016-09-22 02:17:06'),
('Go2Glw2mDKAuZaSOQ0dkZUa00ZgeQtEHDrEVl1ms', 'bDNe0JqGt99emYlFanu5NVeJjhd38M54x3UGeTL9', 1474905781, '2016-09-26 06:03:01', '2016-09-26 06:03:01'),
('eb2J9KEzAsH379BFzhGD18g923V57u7GETiifbEH', 'C9PMBLQnX7q13VZBZjwlD01hmKrMZy0k5sOX5MYQ', 1474918106, '2016-09-26 09:28:26', '2016-09-26 09:28:26'),
('VeWcYJ99UL47RL7zb6oCPK0z0jwCvnmyW27egntg', 'cClx5k8Qf7BNXRRzWtqmCCZyOpNnyFbwUQ819ppr', 1474564392, '2016-09-22 07:13:12', '2016-09-22 07:13:12'),
('ep3yTsqQET0zoO6O9q1cUsjxl0PYTxjM7bNwyx0U', 'DI47mtuCwrMOoI15uR6H98uXeQYdh2oMsg4lX6fX', 1470655979, '2016-08-08 01:32:59', '2016-08-08 01:32:59'),
('zO0pEXeu8sjd1GlMcB0FG4L5c2PqdfZUvh3sYgdc', 'etMwT16NZhptbgmpVgtn8olFTNSMZ65BMo1sc54n', 1474545166, '2016-09-22 01:52:46', '2016-09-22 01:52:46'),
('Bk5b2XBiu9Xlha7k4NCwBEraQ1QRzAaDvkrxOOLG', 'fEGSoUInrfwIoV9y370TMT6kuQDz8OeYAd7Yac1q', 1474892217, '2016-09-26 02:16:57', '2016-09-26 02:16:57'),
('cNVk3S6YuUkXOL5rIpmZhVETYdC9wZdiUMkePebp', 'H1WszcQq9DIMZo1UGR5rldL82xpEYf9uPk8fwSqV', 1472736692, '2016-09-01 03:31:32', '2016-09-01 03:31:32'),
('k7EMLMc26fUXsTWTeNlfRgVInCOBuTqESByNu5m0', 'hVIXGTnrCFdKs2pgFATXMzvW2Fj169s8GiKTI7S9', 1474652260, '2016-09-23 07:37:40', '2016-09-23 07:37:40'),
('4zqvBeUk1ZaV0SO0ftc868shkNHlMmcOQhiiUTUp', 'i7BEFJR8wf9STBwUebs9wRbQ6LnHFi3XpaOLjYEl', 1474568101, '2016-09-22 08:15:01', '2016-09-22 08:15:01'),
('sJNkxoTq0sWLaUnLwdAM75zwcfcWR38X0PetXC8N', 'jMepWN7MR7fGC1c0ChjFmycjv1wyEL9JuYRLqst2', 1470230230, '2016-08-03 03:17:11', '2016-08-03 03:17:11'),
('wGhzsafEjlUssXTAnp7iF1ej9E0HtmiwAudLq8gw', 'JqmQwWJCM5BuhBdwu8SmMR4jJgVW1X7zIDoZJsUl', 1474660050, '2016-09-23 09:47:30', '2016-09-23 09:47:30'),
('25w0Nc4hCyja6P0C9IzWOirMK9mS4REVbQAAJwLp', 'JQONPdmmTT2dXBxZAatrLmLhY1gbuHPnby7dRGNs', 1474911820, '2016-09-26 07:43:40', '2016-09-26 07:43:40'),
('OVdL78z7YlgXAFNVEyhsRxRVYCFv9Yru9o1zf2Fw', 'k4d12gHMirPbNiHb5BPEV8dMd94IWLiuDxZlooUA', 1470405774, '2016-08-05 04:02:54', '2016-08-05 04:02:54'),
('Ig6TwUyIbzEszltMJ3OKd0s4CVakSiXqxOjKGlvt', 'LoDo5ZhWzQetY6SKgnMXTHGrv2iizVTqG08qaXi8', 1470423989, '2016-08-05 09:06:29', '2016-08-05 09:06:29'),
('lexptq6pqKKhtw42489xb6Xhel9Iop7pukvCJqth', 'NdeTh2skerlAdpFvUyCIeiMOJ6UBSDUpyUvG499o', 1474572653, '2016-09-22 09:30:54', '2016-09-22 09:30:54'),
('YWLJhALWyGu2F175OGvGxYjYACB2CLXQJQFB5WY9', 'OqPNfjBoPXhqmkKBcOvFvdZN8jw6VcEWluC70YzQ', 1474630200, '2016-09-23 01:30:00', '2016-09-23 01:30:00'),
('Lwklmofci04hIsLU2TV5wIZElnyWNpgjjsUb40nr', 'PcUP0qj26JjOsKrIJtlhDUrv0dYeSzEiKzVodNlj', 1474974979, '2016-09-27 01:16:19', '2016-09-27 01:16:19'),
('0RAKHYtLmsryLl7YssueBjmCAD4nywg0b4JKQUxU', 'pm6w5oG8ab1pY8lEC94antz4Kwm0NsBXnjtaIfws', 1470246591, '2016-08-03 07:49:51', '2016-08-03 07:49:51'),
('3YGOiTnKo9GvqXKhaIi5VAo5gR2ostgjGu7k2ewj', 'PMVdvPJIXMY0XKkHEQITOenZqUXeLbIpRpcYt8PO', 1470233860, '2016-08-03 04:17:40', '2016-08-03 04:17:40'),
('J2T9ACAPlIlhGMkqGGsnllVGSkq2P7VWD83VyX3k', 'pwBddZsIhB6aTdsHzOOvZWW7lYv0ZJT837d6naXf', 1474894658, '2016-09-26 02:57:38', '2016-09-26 02:57:38'),
('WUrSZcMwWVZMn63RNSxutqsYbrG6kHPBZYVfn4k3', 'S7FbT1eZH8fwPXwwxBYCDwcfm6LcMx7fnNbt9yt8', 1474893731, '2016-09-26 02:42:11', '2016-09-26 02:42:11'),
('72gw1LviUXEWjO085Bi1drwtnK0pk8Pt2wEc5tTl', 'sbuWDClVlg9mjxK4WmkRZQ5FKl62nCZHaLOlZ38U', 1474546243, '2016-09-22 02:10:43', '2016-09-22 02:10:43'),
('8OJwjg3IIEUdsHBzLTzWj87EGVSNjQ9sjnnQro5b', 'SglhdubGMibbQ7V0WS2yKXmvapmAALkcCQIi3vBi', 1470419772, '2016-08-05 07:56:12', '2016-08-05 07:56:12'),
('MfhFnnqppJtVU4F55WLYuQP3WgfiNHKCxfcGd1rA', 'SXLJXMFqQDkBdffGdj5kY9IKfcgvUAsBc1OO4WBM', 1474546424, '2016-09-22 02:13:45', '2016-09-22 02:13:45'),
('JRALbFY2LvgJVG54903x8OzEO4fhalb6fsW594kd', 'ThihWCmBkL2prMdm692Ca24sUmsNEHNIXXKvEQE0', 1474546612, '2016-09-22 02:16:52', '2016-09-22 02:16:52'),
('zikJgIQiMCgalNDXtZB2i0TS8pOkAHsbi8IFtVmj', 'wFaO6h30XucvAKODOGVrpt733AOjXnRfiOmH1A0R', 1470405801, '2016-08-05 04:03:21', '2016-08-05 04:03:21'),
('kzJVpZ4lHUzCnTkLmnimiJwn4RRHmDnJz67BcZ9s', 'WpFBZf7Z8g7ObAIK1XQEsYLZ3kHhTDYM067g5JAE', 1470231547, '2016-08-03 03:39:07', '2016-08-03 03:39:07'),
('unEaTWBEEtyyAfobQn0kPt2i4lyIbN66PolYJDo7', 'Xu05xuLZPwg8ndfgIN8HC9eZR8ZvzKrLZF06YvHr', 1470419337, '2016-08-05 07:48:57', '2016-08-05 07:48:57'),
('nBTqZnx8cpHn2jdAT1Ifh4BmBkH2quxoNdkw8Nhv', 'y10sUw1UmZZHPQow0nt2qokoGKo7MCwl71kCQPrs', 1474547238, '2016-09-22 02:27:18', '2016-09-22 02:27:18'),
('uITsAvlpde1tlrUhOaRChiqOfmmsYm4pguovvU1K', 'yCr8sluGzoNO6G7eLSqvMA8CYz6gRZTKqbbltkT9', 1474554476, '2016-09-22 04:27:57', '2016-09-22 04:27:57'),
('Q1c5sW4ws39zBiikITNg4NgMyC8a9ouhG6USlDNV', 'zBMEdlHIX7IXlIXc0ystm8XnbkQ8AUTFIaw1UrFT', 1474655933, '2016-09-23 08:38:53', '2016-09-23 08:38:53'),
('EGwyGvobRlxxeSYmidv1ODC4wk9zD1wehNEq7bkY', 'zixylwO0MB7G2XcxyNzE4rjBwfeDrCMjp6Z1jDVt', 1474633667, '2016-09-23 02:27:48', '2016-09-23 02:27:48'),
('FHX03EoZ0zhNv8AoAWaHTIWKGgrdn6KvgeS4J9t3', 'ZObf8AmnAiXIlkeMSwfrpHGLS3lXYsE3iqXDNd6N', 1474648126, '2016-09-23 06:28:46', '2016-09-23 06:28:46'),
('PNVR7fdYUFkJZFHbgR2CEYAIft98NOD4HdbP8Uao', 'ZsBPmdjuev3Dj00ntDcX4iSxResnQfOty0jiKvBL', 1470241203, '2016-08-03 06:20:03', '2016-08-03 06:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_sessions`
--

CREATE TABLE `oauth_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_sessions`
--

INSERT INTO `oauth_sessions` (`id`, `client_id`, `owner_type`, `owner_id`, `client_redirect_uri`, `created_at`, `updated_at`) VALUES
(1, '7e55234f', 'client', '1', NULL, '2016-08-03 01:17:34', '2016-08-03 01:17:34'),
(2, '7e55234f', 'client', '1', NULL, '2016-08-03 01:22:08', '2016-08-03 01:22:08'),
(3, 'klj87au8h', 'client', '2', NULL, '2016-08-03 01:36:35', '2016-08-03 01:36:35'),
(4, 'klj87au8h', 'client', '2', NULL, '2016-08-03 01:36:49', '2016-08-03 01:36:49'),
(5, 'klj87au8h', 'client', '2', NULL, '2016-08-03 01:43:14', '2016-08-03 01:43:14'),
(6, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 01:58:37', '2016-08-03 01:58:37'),
(7, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 02:00:35', '2016-08-03 02:00:35'),
(8, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 02:05:31', '2016-08-03 02:05:31'),
(9, 'klj87au8h', 'client', '2', NULL, '2016-08-03 02:06:56', '2016-08-03 02:06:56'),
(10, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 02:19:55', '2016-08-03 02:19:55'),
(11, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 03:11:46', '2016-08-03 03:11:46'),
(12, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 03:17:10', '2016-08-03 03:17:10'),
(13, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 03:35:47', '2016-08-03 03:35:47'),
(14, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 03:39:07', '2016-08-03 03:39:07'),
(15, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 04:17:40', '2016-08-03 04:17:40'),
(16, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 06:20:03', '2016-08-03 06:20:03'),
(17, 'klj87au8h', 'user', '{"id":1,"name":"User","email":"user@user.com","remember_token":null,"created_at":null,"updated_at":null}', NULL, '2016-08-03 07:49:51', '2016-08-03 07:49:51'),
(18, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 04:02:54', '2016-08-05 04:02:54'),
(19, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 04:03:21', '2016-08-05 04:03:21'),
(20, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 06:34:07', '2016-08-05 06:34:07'),
(21, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 07:48:57', '2016-08-05 07:48:57'),
(22, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 07:56:12', '2016-08-05 07:56:12'),
(23, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-05 09:06:29', '2016-08-05 09:06:29'),
(24, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-08-08 01:32:59', '2016-08-08 01:32:59'),
(25, '7e55234f', 'user', '{"id":5,"name":"OAuth 2.0","email":"featours_isa_api","api_token":"","remember_token":null,"created_at":"2016-08-05 05:00:00","updated_at":null}', NULL, '2016-09-01 03:31:32', '2016-09-01 03:31:32'),
(26, '7e55234f', 'user', '{"id":3,"name":"Featours Auth","email":"featours_isa","api_token":"Lr48mb4rKZG52Q3QDKasIjFr0wwOSUrZmCEvFIgEVT8tSBFHSYI3OJIiHbw5","remember_token":"6uajmPHMeDCHYok6jKgLkLSrwd4ugbJONSsWuGtNQ5EZNS3dwE4gfTRVG509","created_at":"2016-04-19 00:58:00","updated_at', NULL, '2016-09-22 01:52:46', '2016-09-22 01:52:46'),
(27, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 02:10:43', '2016-09-22 02:10:43'),
(28, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 02:13:44', '2016-09-22 02:13:44'),
(29, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 02:16:52', '2016-09-22 02:16:52'),
(30, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 02:17:05', '2016-09-22 02:17:05'),
(31, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 02:27:18', '2016-09-22 02:27:18'),
(32, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 03:27:27', '2016-09-22 03:27:27'),
(33, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 04:27:56', '2016-09-22 04:27:56'),
(34, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 07:13:12', '2016-09-22 07:13:12'),
(35, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 08:15:01', '2016-09-22 08:15:01'),
(36, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-22 09:30:53', '2016-09-22 09:30:53'),
(37, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 01:30:00', '2016-09-23 01:30:00'),
(38, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 02:27:47', '2016-09-23 02:27:47'),
(39, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 03:38:47', '2016-09-23 03:38:47'),
(40, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 06:28:46', '2016-09-23 06:28:46'),
(41, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 07:37:40', '2016-09-23 07:37:40'),
(42, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 08:38:53', '2016-09-23 08:38:53'),
(43, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-23 09:47:30', '2016-09-23 09:47:30'),
(44, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 02:16:57', '2016-09-26 02:16:57'),
(45, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 02:42:11', '2016-09-26 02:42:11'),
(46, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 02:57:38', '2016-09-26 02:57:38'),
(47, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 06:03:01', '2016-09-26 06:03:01'),
(48, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 07:43:40', '2016-09-26 07:43:40'),
(49, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-26 09:28:26', '2016-09-26 09:28:26'),
(50, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-27 01:16:19', '2016-09-27 01:16:19'),
(51, '7e55234f', 'user', '{"token":"","email":"idesolusiasia.com","username":"featours","created_at":"2016-05-04 11:57:36","updated_at":"2016-05-04 11:57:36","id":2}', NULL, '2016-09-27 03:17:37', '2016-09-27 03:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_scopes`
--

CREATE TABLE `oauth_session_scopes` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `invoice_no`, `user_id`, `firstname`, `lastname`, `email`, `phone`, `address`, `city`, `postcode`, `country_id`, `province_id`, `comment`, `total`, `order_status_id`, `created_at`, `updated_at`) VALUES
(2, 'JL9CFTD9ET', 17, 'Diyah', 'Fauziyah', 'diyahnf@gmail.com', '', 'Dukuh Pakis 3A', 'Surabaya', '62283', 1, 1, '', '385000.0000', 2, '2016-10-26 09:19:33', NULL),
(3, '0WN277QVCJ', 17, 'Diyah', 'Fauziyah', 'diyahnf@gmail.com', '', 'Dukuh Pakis 3A', 'Surabaya', '62283', 1, 1, '', '550000.0000', 1, '2016-11-08 07:17:06', NULL),
(4, 'E7L1HHIA34', 17, 'Diyah', 'Fauziyah', 'diyahnf@gmail.com', '', 'Dukuh Pakis 3A', 'Surabaya', '62283', 1, 1, '', '2090000.0000', 1, '2016-11-14 02:59:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(9, 2, 24, 'TL Women''s Utility Militray Anorak Drawtring Parka', 1, '350000.0000', '350000.0000', '2016-10-26 09:22:09', NULL),
(10, 3, 24, 'TL Women''s Utility Militray Anorak Drawtring Parka', 1, '350000.0000', '350000.0000', '2016-11-08 07:17:07', NULL),
(11, 3, 23, 'Dreamcrest Short Sleeve Nightgown', 1, '150000.0000', '150000.0000', '2016-11-08 07:17:07', NULL),
(12, 4, 74, 'Krups Burr GVX231 Coffee Grinder', 1, '1600000.0000', '1600000.0000', '2016-11-14 02:59:06', NULL),
(13, 4, 23, 'Dreamcrest Short Sleeve Nightgown', 2, '150000.0000', '300000.0000', '2016-11-14 02:59:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pending Payment', NULL, NULL),
(2, 'Paid', NULL, NULL),
(3, 'Sending', NULL, NULL),
(4, 'Received', NULL, NULL),
(5, 'Cenceled', NULL, NULL),
(6, 'Failed', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'user', 'Mod User', NULL, NULL, NULL),
(2, 'user-add', 'Add User', NULL, NULL, NULL),
(3, 'user-edit', 'Edit User', NULL, NULL, NULL),
(4, 'user-delete', 'Delete User', NULL, NULL, NULL),
(5, 'category', 'Mod Category', NULL, NULL, NULL),
(6, 'category-add', 'Add Category', NULL, NULL, NULL),
(7, 'category-edit', 'Update Category', NULL, NULL, NULL),
(8, 'category-delete', 'Delete Category', NULL, NULL, NULL),
(9, 'product', 'Mod Product', NULL, NULL, NULL),
(10, 'product-add', 'Add Product', NULL, NULL, NULL),
(11, 'product-edit', 'Edit Product', NULL, NULL, NULL),
(12, 'product-delete', 'Delete Product', NULL, NULL, NULL),
(13, 'product-add-picture', 'Add Product Picture', NULL, NULL, NULL),
(14, 'orders', 'Mod Orders', NULL, NULL, NULL),
(15, 'orders-edit', 'Edit Orders', NULL, NULL, NULL),
(16, 'orders-delete', 'Delete Orders', NULL, NULL, NULL),
(17, 'orders-detail', 'Detail Orders', NULL, NULL, NULL),
(18, 'customers', 'Mod Customers', NULL, NULL, NULL),
(19, 'customers-edit', 'Customers Edit', NULL, NULL, NULL),
(20, 'customers-delete', 'Delete Customers', NULL, NULL, NULL),
(21, 'configuration', 'Mod Configuration', NULL, NULL, NULL),
(22, 'admin', 'Mod Admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
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
(22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT '0',
  `sku` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `upc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_seo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8_unicode_ci NOT NULL,
  `product_detail` longtext COLLATE utf8_unicode_ci,
  `product_spesification` longtext COLLATE utf8_unicode_ci,
  `price` decimal(15,4) NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `quantity` int(4) NOT NULL,
  `min_quantity` int(4) NOT NULL,
  `subtract_quantity` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `viewed` int(10) UNSIGNED NOT NULL,
  `purchase_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `brand_id`, `parent_id`, `sku`, `upc`, `product_name`, `product_seo`, `product_meta_title`, `product_meta_description`, `product_meta_keyword`, `product_description`, `product_detail`, `product_spesification`, `price`, `weight`, `quantity`, `min_quantity`, `subtract_quantity`, `status`, `viewed`, `purchase_count`, `created_at`, `updated_at`) VALUES
(9, 0, 0, 'KKJ-15666-00044 ', '-', 'Gater BN-98A Coffee Roaster', 'gater-bn-98a-coffee-roaster', 'Coffee Roaster', 'Coffee Roaster', 'Coffee Roaster', 'Gater BN-98A Coffee Roaster merupakan coffee roaster berbahan paduan plastik &amp; stainless steel yang dirancang untuk memanggan biji kopi dalam skal kecil. Pemanggang biji kopi elektrik ini sanggup memanggang sebanyak 300 g kopi. Dengan daya 1.600 W dan tagangan 220-240V. Coffee Roaster ini sangat cocok untuk dipakai di rumah maupun coffee shop Anda.', NULL, NULL, '4900000.0000', '1.00000000', 95, 1, 'N', 'Y', 175, 500, '2016-08-22 02:50:52', '2016-09-29 03:08:33'),
(10, 2, 0, 'BBN-45666-00044 ', '-', 'Krups Burr GVX231 Coffee Grinder', 'krups-burr-gvx231-coffee-grinder', ' Coffee Grinder', ' Coffee Grinder', ' Coffee Grinder', 'Krups Burr GVX231 Coffee Grinder merupakan mesin penggiling kopi dengan 7 pengaturan penggilingan. Mesin penggiling ini dapat menggiling 2-12 porsi sekaligus, mudah dibersihkan, dan mudah digunakan.', NULL, NULL, '1500000.0000', '1.00000000', 100, 1, 'Y', 'Y', 82, 33, '2016-08-22 03:02:50', '2016-10-06 09:13:37'),
(11, 0, 0, 'BLM-15666-00099', '-', 'Bellman CX-25 Espresso Maker', 'espresso-maker', 'Espresso Maker', 'Espresso Maker', 'Espresso Maker', 'Bellman CX-25 Espresso Maker merupakan alat pembuat espresso dan steam susu dengan sistem manual, hanya memasukkan bubuk kopi ke gasket filter dan diisi air, serta dipanaskan dengan kompor, alat ini siap menghasilkan espresso layaknya mesin kopi tanpa listrik. Selain bisa menghasilkan espresso, Bellman juga bisa digunakan untuk steam atau frothing susu. ', NULL, NULL, '13900000.0000', '1.00000000', 0, 1, 'Y', 'Y', 127, 100, '2016-08-22 19:13:48', '2016-08-22 19:13:48'),
(12, 0, 0, 'WOC-15666-00044 ', '-', ' Worcas - Elegant Design French Press 350ml with Heat Resistant Glass', 'heat-resistant-glass', 'Heat Resistant Glass', 'Heat Resistant Glass', 'Heat Resistant Glass', 'Worcas - Elegant Design French Press 350ml with Heat Resistant Glass merupakan heat resistant glass berukuran 350 ml yang terbuat dari bahan berkualitas. French Press/Cafe Press/Plunger adalah cara termudah untuk menyeduh kopi yang disaring, hanya perlu 4 menit, bubuk kopi dengan seduhan air panas siap untuk disajikan tanpa ampas.', NULL, NULL, '110000.0000', '1.00000000', 12, 1, 'N', 'Y', 54, 12, '2016-08-22 19:21:27', '2016-08-22 19:21:27'),
(13, 0, 0, 'ANB-16096-00362 ', '-', 'Hamilton Beach 49970 Personal Cup One Cup Pod Brewer', 'cup-pod-brewer', 'Cup Pod Brewer', 'Cup Pod Brewer', 'Cup Pod Brewer', 'Sayota Coffee Grinder SCG-178 merupakan mesin penggiling daging, obat, dan bumbu dengan kapasitas 50 gram. Wadah mudah dibersihkan dan terbuat dari bahan stainless steel yang kokoh. Dilengkapi sistem pengunci dengan desain pisau yang unik. Cocok untuk menggiling biji kopi, bumbu-bumbu, buah kering, dan kacang-kacangan.', NULL, NULL, '150000.0000', '1.00000000', 13, 1, 'N', 'Y', 38, 23, '2016-08-22 19:30:36', '2016-08-22 19:30:36'),
(14, 0, 0, 'SAO-27128-00018 ', '-', 'Tokuniku SF-400 Proffesional Digital Kitchen Scale Timbangan Dapur Digital', 'kitchen-scale', 'Kitchen Scale Timbangan Dapur Digital', 'Kitchen Scale Timbangan Dapur Digital', 'Kitchen Scale Timbangan Dapur Digital', 'Tokuniku SF-400 Proffesional Digital Kitchen Scale Timbangan Dapur Digital merupakan timbangan digital dengan kapasitas 7 kg yang dapat digunakan untuk menghitung berat secara akurat dan mendetail. Didesain simple karna tidak memerlukan listrik, hanya menggunakan bateria AA 2 buah. Timbangan ini dilengkapi dengan power OFF otomatis apabila beberapa detik tidak digunakan, indikator power lemah, indikator EEEE pada display jika berat melebihi maximum, menggunakan 2 jenis ukuran gram & Oz, serta TARE jika menggunakan wadah di atas timbangan. Cara Menggunakan tombol "TARE" : Letakan wadah di atas timbangan (bisa keranjang kecil atau mangkok), contoh misalnya Anda ingin menimbang Gula Pasir, lalu tekan tombol "TARE" pada timbangan, maka ukuran akan kembali ke posisi NOL "0". Baru kemudian Anda masukan "Gula Pasir" tersebut ke dalam wadah tadi.', NULL, NULL, '85000.0000', '2.00000000', 14, 1, '', 'Y', 77, 41, '2016-08-22 19:37:10', '2016-08-22 19:37:10'),
(15, 0, 0, 'MEM-24935-00014 ', '-', 'Willman SXC-8 Electric Meat Grinder', 'meat-grinder', 'Meat Grinder', 'Meat Grinder', 'Meat Grinder', 'Willman SXC-8 Electric Meat Grinder merupakan mesin penggiling daging yang terbuat dari bahan full stainless steel. Mesin penggiling daging ini didesain praktis sehingga Anda dapat menggunakannya dengan mudah. Willman SXC-8 memiliki kapasitas penggilingan sebesar 80 kg/h dengan power 0.37 kw.', NULL, NULL, '2800000.0000', '3.00000000', 15, 1, '', 'Y', 66, 27, '2016-08-22 19:43:02', '2016-08-22 19:43:02'),
(16, 0, 0, 'TJS-18157-00081 ', '-', 'Ozeri Nouveaux II Electric Wine Opener', 'wine-opener', 'Wine Opener', 'Wine Opener', 'Wine Opener', ' Ozeri Nouveaux II Electric Wine Opener merupakan pisau dapur elektrik berbahan stainless steel yang didesain ergonomic denga 2 mata pisau untuk memudahkan pekerjaan dapur Anda dengan hasil pemotongan yang akurat dan rapi. Ideal untuk melengkapi peralatan dapur Anda. Garansi resmi kenwood 1 tahun', NULL, NULL, '230000.0000', '1.00000000', 22, 1, 'N', 'Y', 49, 47, '2016-08-22 19:47:38', '2016-08-22 19:47:38'),
(17, 0, 0, ' TOU-17127-00539 ', '-', 'Tokuniku Apple Peeler Pengupas Kulit Buah', 'tokuniku-apple', 'Pengupas Kulit Buah', 'Pengupas Kulit Buah', 'Pengupas Kulit Buah', 'Tokuniku Apple Peeler Pengupas Kulit Buah merupakan pengupas apel atau pisau pengganti berbahan plastik pp yang awet dan tahan lama, berfungsi untuk mengupas buah dengan cara berputar. Dilengkapi dengan handle, mengupas dari bagian bawah, sehingga praktis dan aman untuk di gunakan. Dimensi 20 x 18 x 12 cm.', NULL, NULL, '150000.0000', '1.00000000', 12, 1, 'N', 'Y', 98, 88, '2016-08-22 19:52:58', '2016-08-22 19:52:58'),
(18, 0, 0, ' SUS-15445-00094 ', '-', 'Zojirushi America Corporation CV-DCC40XT VE ', 'zojirushi', 'Thermos Pot', 'Thermos Pot', 'Thermos Pot', 'Zojirushi America Corporation CV-DCC40XT VE   merupakan termos yang sangat praktis untuk digunakan di rumah dengan body yang terbuat dari plastik PP dan inner pot berbahan stainless steel. Thermos pot ini dilengkapi dengan indikator on/off berupa lampu neon dan memiliki 3 cara untuk mengeluarkan air : menggunakan pompa yang tersedia, menggunakan tombol, serta sentuhan cangkir yang akan Anda gunakan sehingga tidak perlu repot jika ingin memasak atau menghangatkan air untuk kebutuhan sehari-hari.', NULL, NULL, '345000.0000', '2.00000000', 23, 1, '', 'Y', 79, 75, '2016-08-22 19:59:21', '2016-08-22 19:59:21'),
(19, 0, 0, ' STE-15867-00282 ', '-', ' Stainless Steel Vacuum Pump', 'steel-vacum', 'Steel Vacuum Pump', 'Steel Vacuum Pump', 'Steel Vacuum Pump', ' Stainless Steel Vacuum Pump merupakan alat penghisap debu kering yang memiliki sistem hisap berteknologi cyclone dengan sistem putaran angin, sehingga menghasilkan daya hisap yang lebih kuat. Vacuum cleaner ini dilengkapi dengan teknologi dry suction optimal sehingga dapat membersihkan debu dan kotoran kering pada sofa, karpet, dan lantai kering. ', NULL, NULL, '120000.0000', '1.00000000', 22, 1, 'N', 'Y', 87, 64, '2016-08-22 20:16:23', '2016-08-22 20:16:23'),
(20, 0, 0, 'MEE-14714-00616 ', '-', 'PANASONIC CS YN5RKJ AC Split', 'ac-splits', 'AC split berkapasitas', 'AC split berkapasitas', 'AC split berkapasitas', 'PANASONIC CS YN5RKJ AC Split [0.5 PK] merupakan AC split berkapasitas 1/2 PK yang menyediakan aliran udara yang luas untuk operasi pendinginan yang efektif. AC split ini didesain simpel, cocok untuk desain rumah minimalis.', NULL, NULL, '3180000.0000', '3.00000000', 33, 1, '', 'Y', 98, 91, '2016-08-22 20:22:26', '2016-08-22 20:22:26'),
(21, 0, 0, 'BLE-15019-00932 ', '-', ' Panasonic F-ES404-G2 Stand Fan', 'panasonic-f-es404-g2-stand-fan', 'Stand Fan', 'Stand Fan', 'Stand Fan', 'Panasonic F-ES404-G2 merupakan kipas angin dinding dengan standar kualitas dan 3 keunggulan yang telah diuji. Kipas angin ini super nyaman, aman, dan bandel. Kipas angin ini juga dilengkapi dengan baling berdiameter 40 cm (16 Inch) yang mampu menghasilkan hembusan angin lebih besar. Kipas angin ini juga memiliki kerja motor dan baling yang tidak berisik serta dilengkapi pengaturan waktu (timer) 3 jam.', NULL, NULL, '599000.0000', '3.00000000', 44, 1, 'N', 'Y', 155, 64, '2016-08-22 20:29:04', '2016-09-15 21:17:18'),
(22, 0, 0, 'ADS-12821-00255 ', '-', 'Adore Kaos Polo Pastel Atasan Wanita - ', 'adore-kaos-polo-pastel-atasan-wanita', 'Pastel Atasan Wanita -', 'Pastel Atasan Wanita -', 'Pastel Atasan Wanita -', 'Adore Kaos Polo Pastel Atasan Wanita - Green, short sleeves polo shirt berbahan cotton mercedess yang didesain trendy dengan pointed collar dan half placket.\r\n\r\nSize Measurement (All Size)', 'detail', '', '60000.0000', '1.00000000', 11, 1, 'Y', 'Y', 171, 31, '2016-08-22 20:33:51', '2016-10-07 03:24:49'),
(23, 0, 0, 'FAS-14419-00432 ', '-', 'Dreamcrest Short Sleeve Nightgown', 'sleeve-grown', ' Sleeve Nightgown', ' Sleeve Nightgown', ' Sleeve Nightgown', 'Dreamcrest Short Sleeve Nightgown aju Tidur Wanita merupakan sleepwear berbahan satin yang didesain casual dengan v-neckline, detail floral lace, aplikasi bow pada bagian depan, dan aksen ruffle di bagian bawah.', NULL, NULL, '150000.0000', '1.00000000', 6, 1, 'Y', 'Y', 125, 86, '2016-08-22 20:38:38', '2016-08-22 20:38:38'),
(24, 0, 0, ' GSW-27292-00017 ', '-', 'TL Women''s Utility Militray Anorak Drawtring Parka', 'drawting-parka', 'Drawtring Parka', 'Drawtring Parka', 'Drawtring Parka', 'TL Women''s Utility Militray Anorak Drawtring Parka jaket berbahan Fleace yang didesain trendy dengan detail ribbet cuff dan hem bottom, front pouch pockest.\r\n', NULL, NULL, '350000.0000', '1.00000000', -1, 1, 'Y', 'Y', 82, 53, '2016-08-22 20:43:11', '2016-08-22 20:43:11'),
(25, 0, 0, ' FAJ-22436-00042 ', '-', ' Favo Men Jeans 127-9093 Indigo Celana Panjang Pria', 'favo-mens', 'Celana Panjang Pria', 'Celana Panjang Pria', 'Celana Panjang Pria', '\r\nFavo Men Jeans 127-9093 Indigo Celana Panjang Pria long pants berbahan cotton yang didesain trendy dengan button & zipper opening, 2 front & back button pockets, dan detail belt loops.', NULL, NULL, '225000.0000', '1.00000000', 11, 1, 'Y', 'Y', 76, 5, '2016-08-22 20:46:48', '2016-08-22 20:46:48'),
(26, 0, 0, 'BAA-21113-00018 ', '-', 'Agrapana Hem Mega Mendung Yoga Baju Batik', 'agrapana-batik', 'Mendung Yoga Baju Batik', 'Mendung Yoga Baju Batik', 'Mendung Yoga Baju Batik', 'Agrapana Hem Mega Mendung Yoga Baju Batik, short sleeves shirt berbahan cotton yang didesain ethnic dalam motif batik dengan pointed collar dan hidden button opening.', NULL, NULL, '30000.0000', '1.00000000', 44, 1, 'Y', 'Y', 69, 29, '2016-08-22 20:54:17', '2016-08-22 20:54:17'),
(27, 0, 0, 'PTS-17224-00013 ', '-', 'Champion Women''s Linear Runner', 'champion-womens', 'Linear Runner', 'Linear Runner', 'Linear Runner', 'Power Cosmo D115 Dark Grey Light Blue Sepatu Casual merupakan low cut sneakers berbahan paduan synthetic PU & textile yang didesain sporty dengan detail neat stitching, 5 eyelets, rubber & phylon outsole, EVA & phylon midsole, dan mesh, fabrics, PU & PVC upper.', NULL, NULL, '1250000.0000', '1.00000000', 12, 1, 'Y', 'Y', 77, 8, '2016-08-22 21:00:28', '2016-08-22 21:00:28'),
(29, 0, 0, 'PTE-19049-00337', '123', ' Wish W1002M/05A Jam Tangan Pria - Brown', 'wish-w1002m05a-jam-tangan-pria-brown', 'Wish W1002M/05A Jam Tangan Pria - Brown', 'Wish W1002M/05A Jam Tangan Pria - Brown', 'Wish W1002M/05A Jam Tangan Pria - Brown', 'Wish W1002M/05A Jam Tangan Pria - Brown merupakan analog watch yang \r\nmemadukan rose gold stainless steel case &amp; genuine leather strap dan\r\n kain batik (motif batik bunga), white dial. Jam tangan yang didesain \r\ncasual dengan tampilan brown index numeral dan silver bezel ini \r\nmenggunakan Japan Movement serta memiliki Water Resistance 30 m &amp; \r\nRain resistant.', NULL, NULL, '189000.0000', '1.00000000', 15, 1, 'Y', 'Y', 0, 0, '2016-09-15 20:08:49', '2016-09-15 20:14:02'),
(30, 0, 0, 'BLI-00106-02973 ', '123', 'Poplin Mesh Scarf ', 'poplin-mesh-scarf', 'Poplin Mesh Scarf ', 'Poplin Mesh Scarf ', 'Poplin Mesh Scarf ', 'Poplin Mesh Scarf, scarf berbahan polyester yang didesain simple chic dengan raw edge finish.', NULL, NULL, '170000.0000', '1.00000000', 16, 1, 'Y', 'Y', 0, 0, '2016-10-16 20:19:01', '2016-09-15 20:19:01'),
(31, 2, 0, 'BIS-29870-00074 ', '123', 'Xiaomi Redmi Note 4 Smartphone', 'xiaomi-redmi-note-4-smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 merupakan sebuah produk menakjubkan yang dibangun \r\ndari komponen yang juga menakjubkan. Xiaomi Redmi Note 4 didukung dengan\r\n internal 64 GB, RAM 3 GB, serta menawarkan layar berukuran 5.5 inch \r\nyang dilengkapi dengan kamera 13 MP pada bagian belakang dan 5MP pada \r\nbagian depan. Untuk lebih menyempurnakan&nbsp;kami tambahkan kapasitas \r\nbaterai 4000 mAh untuk kenyamanan Anda.', '<ul><li>Layar : 5.0 inch</li><li>Memori : 32 GB dan 3 GB RAM</li><li>Kamera : 13 MP dan 5 MP</li><li>Prosesor : Quad-core 1.5 GHz Cortex-A53 &amp; quad-core 1.2 GHz Cortex-A53</li><li>Sistem operasi : Android OS, v5.1 (Lollipop)<br></li></ul>', '<ul><li><span style="font-weight: bold;"><span style="color: rgb(255, 0, 0);"><span style="font-family: Lato,sans-serif;">Test</span></span></span></li><li><span style="color: rgb(0, 0, 255);"><span style="background-color: yellow;"><span style="font-style: italic;"><span style="font-family: Lato,sans-serif;">test</span></span></span></span></li><li><span style="color: rgb(255, 0, 0);"><span style="font-family: Lato,sans-serif;">test<br></span></span><br><ul><li style="box-sizing: inherit; font-size: 20px; font-weight: bold; display: block; margin-bottom: 10px; margin-top: 0px; font-family: Lato,sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(255, 0, 0);"><span class="small-title" style="box-sizing: inherit; display: block; margin-top: 7px; font-size: 13px !important; font-weight: normal !important;"><br></span></span></li></ul></li></ul>', '3100000.0000', '1.00000000', 15, 1, 'Y', 'Y', 647, 0, '2016-09-29 20:25:31', '2016-11-08 06:56:22'),
(32, 1, 0, 'BLH-15012-04440 ', '123', 'Samsung Galaxy Tab A 2016 Tablet', 'samsung-galaxy-tab-a-2016-tablet', 'Samsung Galaxy Tab A 2016 Tablet', 'Samsung Galaxy Tab A 2016 Tablet', 'Samsung Galaxy Tab A 2016 Tablet', 'Samsung Galaxy Tab A 2016 Tablet, hadir dengan desain layar WXGA TFT \r\nseluas 7.0 Inch. Samsung Galaxy Tab A 2016 ini memiliki 1.5 GHz prosesor\r\n quad-core dengan 1.5 GB RAM dan penyimpanan internal 8 GB. Penyimpanan \r\ninternal dapat diperluas hingga 200 GB menggunakan kartu microSD. GPU \r\nAdreno 306 membuat grafis yang dihasilkan untuk bermain game maupun \r\nmenonton video, warnanya pun akan terlihat jelas dan jernih. Pilihan \r\nkonektivitas disediakan Wi-Fi (802.11 b / g / n 2.4GHz), Bluetooth V4.0,\r\n Wi-Fi Direct, GPS <br>', NULL, NULL, '2300000.0000', '1.00000000', 12, 1, 'Y', 'Y', 23, 0, '2016-11-17 21:03:05', '2016-09-30 08:07:06'),
(33, 1, 0, ' BUB-16014-00651 ', '123', 'Apple iPhone 7 256 GB Smartphone', 'apple-iphone-7-256-gb-smartphone', 'Apple iPhone 7 256 GB Smartphone', 'Apple iPhone 7 256 GB Smartphone', 'Apple iPhone 7 256 GB Smartphone', 'pple iPhone 7 secara dramatis meningkatkan aspek yang paling penting \r\ndari pengalaman menggunakan iPhone. iPhone 7 memperkenalkan sistem \r\nkamera baru yang canggih, kinerja yang baik, dan memiliki daya tahan \r\nbaterai yang belum pernah ada sebelumnya. Speaker stereo yang immersive,\r\n memiliki kemampuan tahan air (water resistant), dengan tiap bagian dari\r\n iPhone 7 yang membuatnya terlihat kokoh dan powerful. Itulah iPhone 7.', NULL, NULL, '13000000.0000', '1.00000000', 15, 1, 'Y', 'Y', 0, 0, '2016-09-30 07:29:15', '2016-09-30 07:59:16'),
(68, 2, 31, 'BIS-29870-00074 ', '123', 'Xiaomi Redmi Note 4 Smartphone', 'xiaomi-redmi-note-4-smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 merupakan sebuah produk menakjubkan yang dibangun \r\ndari komponen yang juga menakjubkan. Xiaomi Redmi Note 4 didukung dengan\r\n internal 64 GB, RAM 3 GB, serta menawarkan layar berukuran 5.5 inch \r\nyang dilengkapi dengan kamera 13 MP pada bagian belakang dan 5MP pada \r\nbagian depan. Untuk lebih menyempurnakan&nbsp;kami tambahkan kapasitas \r\nbaterai 4000 mAh untuk kenyamanan Anda.', NULL, NULL, '3200000.0000', '1.00000000', 15, 1, 'Y', 'Y', 528, 0, '2016-11-08 07:08:43', '2016-11-08 07:08:43'),
(69, 2, 31, 'BIS-29870-00074 ', '123', 'Xiaomi Redmi Note 4 Smartphone', 'xiaomi-redmi-note-4-smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 merupakan sebuah produk menakjubkan yang dibangun \r\ndari komponen yang juga menakjubkan. Xiaomi Redmi Note 4 didukung dengan\r\n internal 64 GB, RAM 3 GB, serta menawarkan layar berukuran 5.5 inch \r\nyang dilengkapi dengan kamera 13 MP pada bagian belakang dan 5MP pada \r\nbagian depan. Untuk lebih menyempurnakan&nbsp;kami tambahkan kapasitas \r\nbaterai 4000 mAh untuk kenyamanan Anda.', NULL, NULL, '3300000.0000', '1.00000000', 15, 1, 'Y', 'Y', 528, 0, '2016-10-27 01:35:30', '2016-10-27 01:35:30'),
(70, 2, 31, 'BIS-29870-00074 ', '123', 'Xiaomi Redmi Note 4 Smartphone', 'xiaomi-redmi-note-4-smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 Smartphone', 'Xiaomi Redmi Note 4 merupakan sebuah produk menakjubkan yang dibangun \r\ndari komponen yang juga menakjubkan. Xiaomi Redmi Note 4 didukung dengan\r\n internal 64 GB, RAM 3 GB, serta menawarkan layar berukuran 5.5 inch \r\nyang dilengkapi dengan kamera 13 MP pada bagian belakang dan 5MP pada \r\nbagian depan. Untuk lebih menyempurnakan&nbsp;kami tambahkan kapasitas \r\nbaterai 4000 mAh untuk kenyamanan Anda.', NULL, NULL, '3400000.0000', '1.00000000', 0, 1, 'Y', 'Y', 528, 0, '2016-11-08 06:53:12', '2016-11-08 06:53:12'),
(71, 0, 9, 'KKJ-15666-00044 ', '-', 'Gater BN-98A Coffee Roaster', 'gater-bn-98a-coffee-roaster', 'Coffee Roaster', 'Coffee Roaster', 'Coffee Roaster', 'Gater BN-98A Coffee Roaster merupakan coffee roaster berbahan paduan plastik &amp; stainless steel yang dirancang untuk memanggan biji kopi dalam skal kecil. Pemanggang biji kopi elektrik ini sanggup memanggang sebanyak 300 g kopi. Dengan daya 1.600 W dan tagangan 220-240V. Coffee Roaster ini sangat cocok untuk dipakai di rumah maupun coffee shop Anda.', NULL, NULL, '4600000.0000', '1.00000000', 95, 1, 'N', 'Y', 97, 0, '2016-10-27 01:51:11', '2016-10-27 01:51:11'),
(72, 0, 9, 'KKJ-15666-00044 ', '-', 'Gater BN-98A Coffee Roaster', 'gater-bn-98a-coffee-roaster', 'Coffee Roaster', 'Coffee Roaster', 'Coffee Roaster', 'Gater BN-98A Coffee Roaster merupakan coffee roaster berbahan paduan plastik &amp; stainless steel yang dirancang untuk memanggan biji kopi dalam skal kecil. Pemanggang biji kopi elektrik ini sanggup memanggang sebanyak 300 g kopi. Dengan daya 1.600 W dan tagangan 220-240V. Coffee Roaster ini sangat cocok untuk dipakai di rumah maupun coffee shop Anda.', NULL, NULL, '4700000.0000', '1.00000000', 95, 1, 'N', 'Y', 97, 0, '2016-10-27 01:37:39', '2016-10-27 01:37:39'),
(73, 0, 9, 'KKJ-15666-00044 ', '-', 'Gater BN-98A Coffee Roaster', 'gater-bn-98a-coffee-roaster', 'Coffee Roaster', 'Coffee Roaster', 'Coffee Roaster', 'Gater BN-98A Coffee Roaster merupakan coffee roaster berbahan paduan plastik &amp; stainless steel yang dirancang untuk memanggan biji kopi dalam skal kecil. Pemanggang biji kopi elektrik ini sanggup memanggang sebanyak 300 g kopi. Dengan daya 1.600 W dan tagangan 220-240V. Coffee Roaster ini sangat cocok untuk dipakai di rumah maupun coffee shop Anda.', NULL, NULL, '4900000.0000', '1.00000000', 95, 1, 'N', 'Y', 97, 0, '2016-10-27 01:38:00', '2016-10-27 01:38:00'),
(74, 2, 10, 'BBN-45666-00044 ', '-', 'Krups Burr GVX231 Coffee Grinder', 'krups-burr-gvx231-coffee-grinder', ' Coffee Grinder', ' Coffee Grinder', ' Coffee Grinder', 'Krups Burr GVX231 Coffee Grinder merupakan mesin penggiling kopi dengan 7 pengaturan penggilingan. Mesin penggiling ini dapat menggiling 2-12 porsi sekaligus, mudah dibersihkan, dan mudah digunakan.', NULL, NULL, '1600000.0000', '1.00000000', 99, 1, 'Y', 'Y', 13, 0, '2016-11-08 06:25:19', '2016-11-08 06:25:19'),
(75, 2, 10, 'BBN-45666-00044 ', '-', 'Krups Burr GVX231 Coffee Grinder', 'krups-burr-gvx231-coffee-grinder', ' Coffee Grinder', ' Coffee Grinder', ' Coffee Grinder', 'Krups Burr GVX231 Coffee Grinder merupakan mesin penggiling kopi dengan 7 pengaturan penggilingan. Mesin penggiling ini dapat menggiling 2-12 porsi sekaligus, mudah dibersihkan, dan mudah digunakan.', NULL, NULL, '1700000.0000', '1.00000000', 100, 1, 'Y', 'Y', 13, 0, '2016-11-08 06:25:45', '2016-11-08 06:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_to_attribute`
--

CREATE TABLE `product_to_attribute` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `value_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_to_attribute`
--

INSERT INTO `product_to_attribute` (`id`, `product_id`, `attribute_id`, `value_id`, `created_at`, `updated_at`) VALUES
(220, 69, 2, 8, '2016-10-27 01:35:30', '2016-10-27 01:35:30'),
(221, 69, 3, 13, '2016-10-27 01:35:30', '2016-10-27 01:35:30'),
(222, 69, 4, 15, '2016-10-27 01:35:30', '2016-10-27 01:35:30'),
(227, 72, 2, 9, '2016-10-27 01:37:39', '2016-10-27 01:37:39'),
(228, 73, 2, 10, '2016-10-27 01:38:00', '2016-10-27 01:38:00'),
(232, 71, 2, 8, '2016-10-27 01:51:11', '2016-10-27 01:51:11'),
(235, 74, 2, 8, '2016-11-08 06:25:19', '2016-11-08 06:25:19'),
(236, 74, 5, 18, '2016-11-08 06:25:19', '2016-11-08 06:25:19'),
(237, 75, 2, 9, '2016-11-08 06:25:45', '2016-11-08 06:25:45'),
(238, 75, 5, 19, '2016-11-08 06:25:45', '2016-11-08 06:25:45'),
(239, 70, 2, 10, '2016-11-08 06:53:12', '2016-11-08 06:53:12'),
(240, 70, 3, 13, '2016-11-08 06:53:12', '2016-11-08 06:53:12'),
(241, 70, 4, 17, '2016-11-08 06:53:12', '2016-11-08 06:53:12'),
(242, 68, 2, 8, '2016-11-08 07:08:43', '2016-11-08 07:08:43'),
(243, 68, 3, 12, '2016-11-08 07:08:43', '2016-11-08 07:08:43'),
(244, 68, 4, 16, '2016-11-08 07:08:43', '2016-11-08 07:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_to_category`
--

CREATE TABLE `product_to_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_to_category`
--

INSERT INTO `product_to_category` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(22, 11, 47, '2016-08-22 19:13:48', '2016-08-22 19:13:48'),
(23, 12, 48, '2016-08-22 19:21:27', '2016-08-22 19:21:27'),
(24, 13, 44, '2016-08-22 19:30:36', '2016-08-22 19:30:36'),
(25, 14, 49, '2016-08-22 19:37:10', '2016-08-22 19:37:10'),
(26, 15, 50, '2016-08-22 19:43:02', '2016-08-22 19:43:02'),
(27, 16, 51, '2016-08-22 19:47:38', '2016-08-22 19:47:38'),
(28, 17, 52, '2016-08-22 19:52:58', '2016-08-22 19:52:58'),
(29, 18, 53, '2016-08-22 19:59:21', '2016-08-22 19:59:21'),
(30, 19, 54, '2016-08-22 20:16:23', '2016-08-22 20:16:23'),
(31, 20, 56, '2016-08-22 20:22:26', '2016-08-22 20:22:26'),
(34, 23, 66, '2016-08-22 20:38:38', '2016-08-22 20:38:38'),
(35, 24, 67, '2016-08-22 20:43:11', '2016-08-22 20:43:11'),
(36, 25, 67, '2016-08-22 20:46:48', '2016-08-22 20:46:48'),
(37, 26, 68, '2016-08-22 20:54:17', '2016-08-22 20:54:17'),
(38, 27, 78, '2016-08-22 21:00:28', '2016-08-22 21:00:28'),
(42, 29, 72, '2016-09-15 20:14:02', '2016-09-15 20:14:03'),
(43, 30, 84, '2016-09-15 20:19:01', '2016-09-15 20:19:01'),
(49, 21, 55, '2016-09-15 21:17:18', '2016-09-15 21:17:18'),
(71, 9, 45, '2016-09-29 03:08:33', '2016-09-29 03:08:33'),
(74, 33, 90, '2016-09-30 07:59:16', '2016-09-30 07:59:16'),
(75, 32, 91, '2016-09-30 08:07:06', '2016-09-30 08:07:07'),
(78, 10, 46, '2016-10-06 09:13:37', '2016-10-06 09:13:37'),
(88, 22, 70, '2016-10-07 03:24:49', '2016-10-07 03:24:49'),
(94, 31, 90, '2016-11-08 06:56:22', '2016-11-08 06:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jawa Timur', NULL, NULL),
(2, 1, 'Jawa Tengah', NULL, NULL),
(3, 1, 'Jawa Barat', NULL, NULL),
(4, 2, 'Sydney', NULL, NULL),
(5, 2, 'Melbourne', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'User Administrator', 'User is allowed to manage and edit other users', '2016-09-09 01:36:11', '2016-09-09 01:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `token` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`token`, `email`, `username`, `password`, `created_at`, `updated_at`, `id`) VALUES
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIi', 'bst@bst.com', 'bst', '$2a$10$HN7dMssWQ0j1ulKWBS3ovuw72pW/kmAqlopVlbj.7oVnHqYlvD5qm', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
('', 'idesolusiasia.com', 'featours', '$2a$08$z3lp0eu//7bAKJpLGU7lJO0LCD8eiNWr.GrlQRtNspGfKMGMUOUzi', '2016-05-04 11:57:36', '2016-05-04 11:57:36', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_confirm` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `id_device` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_device` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `is_confirm`, `last_login`, `id_device`, `type_device`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Mamat', 'Dul', 'mamat@gmail.com', '0878327382', '$2y$10$ZQ/uy7k3gTS.ka0L5gGti.MkI9sGJQ4t24Odq7CyUEJQ4iHW1i/D6', 'Y', NULL, NULL, NULL, 'Bz9F3GfEvQqDIv3aLa1NwMqzLI6wZxqXiAkf5wsjM7BfN8yo7Z8ATf8D3ZVw', NULL, '2016-09-14 21:27:21'),
(5, 'Diyah', 'Fauziyah', 'diyahnf2@gmail.com', '085707907679', '$2y$10$zBBNtHGGG/.NP1QTrdG36OtH5Tn.WzQPQ0gVL1CJlQhXQsrae37LO', 'Y', '2016-09-26 09:43:36', '1234567', 'android', 'rPJ2h1Rh50cyOptRH4TsYY2UHxLx4epgKwlO2WPWxdwge7J0VaGrwyfUCaG0', NULL, '2016-09-15 20:51:42'),
(6, 'Yuni', 'Damayanti', 'yuni@gmail.com', '', '$2y$10$jxXwTwOFbW5qzmiF4vT9oevlPqtS9Idl8MYX/2qt2pkw3zY4OM7dq', 'N', NULL, NULL, NULL, 'bY0d2fmXi6hCjwKfJ0aFIfgo1LSxFgWrRqRz9ZTH4DcJjr9kxhiAoix3g5Qc', NULL, '2016-09-15 19:22:30'),
(7, 'Test', 'Test', 'test@test.com', '', '$2y$10$1CvRhaIQSrYKTAAt8XJUNOuuPIlLS77wfi8qACNcuktqYho3THWmC', 'N', NULL, NULL, NULL, '', '2016-09-16 02:51:48', NULL),
(8, 'Test', 'Test 2', 'test2@test.com', '', '$2y$10$6BvEkV3Pk0hqtGAcJzE4yu4V92.x.Rsm3Jjd1Pd4EdQyR/kLM.n1m', 'N', NULL, NULL, NULL, '', '2016-09-16 02:57:46', NULL),
(11, 'Diyah', 'Fauziyah', 'diyahnf@idesolusiasia.com', '', '$2y$10$64ZZ.haJTcovY34LoO4rw.d9XNo2SSF0qtqLdTmJROUStbeAPq2u.', 'N', NULL, NULL, NULL, '', '2016-09-26 02:44:18', NULL),
(16, 'marvelFN', 'marvelLN', 'marvel@agent.com', '', '$2y$10$K9pZSHEXqGpoJzKrbKUIOe6C6HFYj0gMkBu2fMm2fbvTWz7BYllHu', 'Y', NULL, NULL, NULL, '', '2016-09-27 01:17:28', NULL),
(17, 'Diyah', 'Fauziyah', 'diyahnf@gmail.com', '', '$2a$08$e60VDv7FGFwu8.ajskD1ruA5WIg0UfyGS/Mp3Csir.DL.td6ibPnW', 'Y', NULL, NULL, NULL, 'pDd1AvNsuWGvVec8shxk3tjoRFiEIwOyciwVSc7mAaxKyMDnaCCCzDinUoiE', '2016-09-27 01:34:34', '2016-11-11 03:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
(13, '22', '17', '2016-10-27 07:07:54', NULL),
(15, '23', '17', '2016-11-11 03:41:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`user_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_access_tokens_id_session_id_unique` (`id`,`session_id`),
  ADD KEY `oauth_access_tokens_session_id_index` (`session_id`);

--
-- Indexes for table `oauth_access_token_scopes`
--
ALTER TABLE `oauth_access_token_scopes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_token_scopes_access_token_id_index` (`access_token_id`),
  ADD KEY `oauth_access_token_scopes_scope_id_index` (`scope_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_session_id_index` (`session_id`);

--
-- Indexes for table `oauth_auth_code_scopes`
--
ALTER TABLE `oauth_auth_code_scopes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_code_scopes_auth_code_id_index` (`auth_code_id`),
  ADD KEY `oauth_auth_code_scopes_scope_id_index` (`scope_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`);

--
-- Indexes for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_client_endpoints_client_id_redirect_uri_unique` (`client_id`,`redirect_uri`);

--
-- Indexes for table `oauth_client_grants`
--
ALTER TABLE `oauth_client_grants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_grants_client_id_index` (`client_id`),
  ADD KEY `oauth_client_grants_grant_id_index` (`grant_id`);

--
-- Indexes for table `oauth_client_scopes`
--
ALTER TABLE `oauth_client_scopes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_scopes_client_id_index` (`client_id`),
  ADD KEY `oauth_client_scopes_scope_id_index` (`scope_id`);

--
-- Indexes for table `oauth_grants`
--
ALTER TABLE `oauth_grants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_grant_scopes`
--
ALTER TABLE `oauth_grant_scopes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_grant_scopes_grant_id_index` (`grant_id`),
  ADD KEY `oauth_grant_scopes_scope_id_index` (`scope_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`access_token_id`),
  ADD UNIQUE KEY `oauth_refresh_tokens_id_unique` (`id`);

--
-- Indexes for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_session_scopes`
--
ALTER TABLE `oauth_session_scopes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_session_scopes_session_id_index` (`session_id`),
  ADD KEY `oauth_session_scopes_scope_id_index` (`scope_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_to_attribute`
--
ALTER TABLE `product_to_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_to_category`
--
ALTER TABLE `product_to_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `attribute_value`
--
ALTER TABLE `attribute_value`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `oauth_access_token_scopes`
--
ALTER TABLE `oauth_access_token_scopes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_auth_code_scopes`
--
ALTER TABLE `oauth_auth_code_scopes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_client_grants`
--
ALTER TABLE `oauth_client_grants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_client_scopes`
--
ALTER TABLE `oauth_client_scopes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_grant_scopes`
--
ALTER TABLE `oauth_grant_scopes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `oauth_session_scopes`
--
ALTER TABLE `oauth_session_scopes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `product_to_attribute`
--
ALTER TABLE `product_to_attribute`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
--
-- AUTO_INCREMENT for table `product_to_category`
--
ALTER TABLE `product_to_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `address_ibfk_3` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD CONSTRAINT `oauth_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_access_token_scopes`
--
ALTER TABLE `oauth_access_token_scopes`
  ADD CONSTRAINT `oauth_access_token_scopes_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_access_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD CONSTRAINT `oauth_auth_codes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_auth_code_scopes`
--
ALTER TABLE `oauth_auth_code_scopes`
  ADD CONSTRAINT `oauth_auth_code_scopes_auth_code_id_foreign` FOREIGN KEY (`auth_code_id`) REFERENCES `oauth_auth_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_auth_code_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
  ADD CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_client_grants`
--
ALTER TABLE `oauth_client_grants`
  ADD CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `oauth_client_scopes`
--
ALTER TABLE `oauth_client_scopes`
  ADD CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_grant_scopes`
--
ALTER TABLE `oauth_grant_scopes`
  ADD CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD CONSTRAINT `oauth_refresh_tokens_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
  ADD CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_session_scopes`
--
ALTER TABLE `oauth_session_scopes`
  ADD CONSTRAINT `oauth_session_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_session_scopes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
