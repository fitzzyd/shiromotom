-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2024 at 07:18 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(17, 'admin', 'ee92258b7b3ff967b74df40349a8312be94a60be');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `user_comment`, `created_at`) VALUES
(14, 11, 8, 'Good Phone', '2024-11-22 14:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `gcash_screenshot`
--

CREATE TABLE `gcash_screenshot` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `screenshot_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int DEFAULT NULL,
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `gcash_screenshot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `product_id`, `payment_status`, `transaction_id`, `gcash_screenshot`) VALUES
(69, 9, 'fitzyd@gmail.com', '333', 'fitzzyd21@gmail.com', 'paypal', 'gsis metrohomes phase 1 bldg. 6 anonas st., 628, manila, 123', 'Iphone 16 (₱ 85,000.00 x 1) - ', '85000.00', '2024-11-22 23:47:04', NULL, 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `cid` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `technology` varchar(255) DEFAULT NULL,
  `announced` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `build` varchar(255) DEFAULT NULL,
  `sim` longtext,
  `display_type` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `protection` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `chipset` varchar(255) DEFAULT NULL,
  `cpu` varchar(255) DEFAULT NULL,
  `gpu` varchar(255) DEFAULT NULL,
  `mem_card_slot` varchar(255) DEFAULT NULL,
  `mem_internal` varchar(255) DEFAULT NULL,
  `mc_modules` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mc_features` varchar(255) DEFAULT NULL,
  `mc_video` varchar(255) DEFAULT NULL,
  `sc_modules` varchar(255) DEFAULT NULL,
  `sc_features` varchar(255) DEFAULT NULL,
  `sc_video` varchar(255) DEFAULT NULL,
  `loudspeaker` varchar(255) DEFAULT NULL,
  `sound_jack` varchar(255) DEFAULT NULL,
  `wlan` varchar(255) DEFAULT NULL,
  `bluetooth` varchar(255) DEFAULT NULL,
  `positioning` varchar(255) DEFAULT NULL,
  `nfc` varchar(255) DEFAULT NULL,
  `infrared_port` varchar(255) DEFAULT NULL,
  `radio` varchar(255) DEFAULT NULL,
  `usb` varchar(255) DEFAULT NULL,
  `sensors` varchar(255) DEFAULT NULL,
  `battery_type` varchar(255) DEFAULT NULL,
  `charging` varchar(255) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `models` varchar(255) DEFAULT NULL,
  `compare_count` int NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cid`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `technology`, `announced`, `status`, `dimensions`, `weight`, `build`, `sim`, `display_type`, `size`, `resolution`, `protection`, `os`, `chipset`, `cpu`, `gpu`, `mem_card_slot`, `mem_internal`, `mc_modules`, `mc_features`, `mc_video`, `sc_modules`, `sc_features`, `sc_video`, `loudspeaker`, `sound_jack`, `wlan`, `bluetooth`, `positioning`, `nfc`, `infrared_port`, `radio`, `usb`, `sensors`, `battery_type`, `charging`, `colors`, `models`, `compare_count`, `stock`) VALUES
(8, NULL, 'Samsung Galaxy A5', 'Good Phone', '15000.00', 'samsung-galaxy-a55.jpg', 'samsung-galaxy-a55.jpg', 'samsung-galaxy-a55.jpg', 'GSM / HSPA / LTE / 5G', '2024, March 11', 'Available. Released 2024, March 15', '161.1 x 77.4 x 8.2 mm (6.34 x 3.05 x 0.32 in)	', '213 g (7.51 oz)	', 'Glass front (Gorilla Glass Victus+), glass back (Gorilla Glass), aluminum frame', 'Single SIM (Nano-SIM) or Single SIM (Nano-SIM, eSIM) or Hybrid Dual SIM (Nano-SIM, dual stand-by)', 'Super AMOLED, 120Hz, HDR10+, 1000 nits (HBM)', '6.6 inches, 106.9 cm2 (~85.8% screen-to-body ratio)', '1080 x 2340 pixels, 19.5:9 ratio (~390 ppi density)', 'Corning Gorilla Glass Victus+ Always-on display', 'Android 14, up to 4 major Android upgrades, One UI 6.1', 'Exynos 1480 (4 nm)', 'Octa-core (4x2.75 GHz Cortex-A78 &amp; 4x2.0 GHz Cortex-A55)', 'Xclipse 530', 'microSDXC (uses shared SIM slot)', '128GB 6GB RAM, 128GB 8GB RAM, 256GB 6GB RAM, 256GB 8GB RAM, 256GB 12GB RAM', '50 MP, f/1.8, (wide), 1/1.56&quot;, 1.0&micro;m, PDAF, OIS 12 MP, f/2.2, 123˚ (ultrawide), 1/3.06&quot;, 1.12&micro;m 5 MP, f/2.4, (macro)', 'LED flash, panorama, HDR', '4K@30fps, 1080p@30/60fps, gyro-EIS', '32 MP, f/2.2, 26mm (wide), 1/2.74&quot;, 0.8&micro;m	', 'None', '4K@30fps, 1080p@30/60fps', 'Yes, with stereo speakers', 'No', 'Wi-Fi 802.11 a/b/g/n/ac/6, dual-band, Wi-Fi Direct', '5.3, A2DP, LE', 'GPS, GALILEO, GLONASS, BDS, QZSS', 'Yes (market/region dependent)', 'No', 'No', 'USB Type-C 2.0, OTG', 'Fingerprint (under display, optical), accelerometer, gyro, compass Virtual proximity sensing Circle to Search', 'Li-Ion 5000 mAh, non-removable', '25W wired', 'Iceblue, Lilac, Navy, Lemon', 'SM-A556V, SM-A556B, SM-A556B/DS, SM-A556E, SM-A556E/DS, SM-A5560', 8, 410),
(9, NULL, 'Iphone 16', 'New Release Iphone', '85000.00', 'apple-iphone-16.jpg', 'apple-iphone-16.jpg', 'apple-iphone-16.jpg', 'GSM / CDMA / HSPA / EVDO / LTE / 5G', '2024, September 09', 'Available. Released 2024, September 20', '163 x 77.6 x 8.3 mm (6.42 x 3.06 x 0.33 in)', '227 g (8.01 oz)', 'Glass front (Corning-made glass), glass back (Corning-made glass), titanium frame (grade 5)', 'Nano-SIM and eSIM - International Dual eSIM with multiple numbers - USA Dual SIM (Nano-SIM, dual stand-by) - China IP68 dust/water resistant (up to 6m for 30 min) Apple Pay (Visa, MasterCard, AMEX certified)', 'type 1LTPO Super Retina XDR OLED, 120Hz, HDR10, Dolby Vision, 1000 nits (typ), 2000 nits (HBM)', '6.9 inches, 115.6 cm2 (~91.4% screen-to-body ratio)', '1320 x 2868 pixels, 19.5:9 ratio (~460 ppi density)', 'Ceramic Shield glass (2024 gen), Always-On display', 'iOS 18, upgradable to iOS 18.1', 'Apple A18 Pro (3 nm)', 'Hexa-core (2x4.05 GHz + 4x2.42 GHz)', 'Apple GPU (6-core graphics)', 'No', '256GB 8GB RAM, 512GB 8GB RAM, 1TB 8GB RAM	NVMe	', '48 MP, f/1.8, 24mm (wide), 1/1.28&quot;, 1.22&micro;m, dual pixel PDAF, sensor-shift OIS 12 MP, f/2.8, 120mm (periscope telephoto), 1/3.06&quot;, 1.12&micro;m, dual pixel PDAF, 3D sensor‑shift OIS, 5x optical zoom 48 MP, f/2.2, 13mm (ultrawide), 0.7&micro;m, PDAF TOF 3D LiDAR scanner (depth)', 'Dual-LED dual-tone flash, HDR (photo/panorama)', '4K@24/25/30/60/100/120fps, 1080p@25/30/60/120/240fps, 10-bit HDR, Dolby Vision HDR (up to 60fps), ProRes, 3D (spatial) video/audio, stereo sound rec.	', '12 MP, f/1.9, 23mm (wide), 1/3.6&quot;, PDAF, OIS SL 3D, (depth/biometrics sensor)', 'HDR, Dolby Vision HDR, 3D (spatial) audio, stereo sound rec.', '4K@24/25/30/60fps, 1080p@25/30/60/120fps, gyro-EIS', 'Yes, with stereo speakers	', 'No', 'Wi-Fi 802.11 a/b/g/n/ac/6e/7, tri-band, hotspot	', '5.3, A2DP, LE', 'GPS (L1+L5), GLONASS, GALILEO, BDS, QZSS, NavIC', 'Yes	', 'No	', 'No	', 'USB Type-C 3.2 Gen 2, DisplayPort	', 'Face ID, accelerometer, gyro, proximity, compass, barometer, Ultra Wideband (UWB) support (gen2 chip), Emergency SOS, Messages and Find My via satellite', 'Li-Ion 4685 mAh, non-removable	', 'Wired, PD2.0, 50% in 30 min (advertised) 25W wireless (MagSafe), 15W wireless (China only) 15W wireless (Qi2) 4.5W reverse wired', 'Black Titanium, White Titanium, Natural Titanium, Desert Titanium	', 'A3296, A3084, A3295, A3297, iPhone17,2	', 8, 10),
(10, NULL, 'Apple iPhone 14 Pro Max', 'The iPhone 14 Pro Max is Apple&rsquo;s most advanced smartphone, setting a new standard for performance, design, and innovation. It&rsquo;s crafted for those who demand excellence in every aspect of their device.', '57990.00', 'apple-iphone-14-pro-max-.jpg', 'apple-iphone-14-pro-max-.jpg', 'apple-iphone-14-pro-max-.jpg', 'GSM 850 / 900 / 1800 / 1900 - SIM 1 &amp; SIM 2 (dual-SIM)', '2022, September 07', 'Available. Released 2022, September 16', '160.7 x 77.6 x 7.9 mm (6.33 x 3.06 x 0.31 in)', '240 g (8.47 oz)', 'Glass front (Corning-made glass), glass back (Corning-made glass), stainless steel frame', 'Nano-SIM and eSIM - International Dual eSIM with multiple numbers - USA Dual SIM (Nano-SIM, dual stand-by) - China  	IP68 dust/water resistant (up to 6m for 30 min) Apple Pay (Visa, MasterCard, AMEX certified)', 'LTPO Super Retina XDR OLED, 120Hz, HDR10, Dolby Vision, 1000 nits (typ), 2000 nits (HBM)', '6.7 inches, 110.2 cm2 (~88.3% screen-to-body ratio)', '1290 x 2796 pixels, 19.5:9 ratio (~460 ppi density)', 'Ceramic Shield glass  	Always-On display', 'iOS 16, upgradable to iOS 18.1', 'Apple A16 Bionic (4 nm)', 'Hexa-core (2x3.46 GHz Everest + 4x2.02 GHz Sawtooth)', 'Apple GPU (5-core graphics)', 'No', '128GB 6GB RAM, 256GB 6GB RAM, 512GB 6GB RAM, 1TB 6GB RAM', '48 MP, f/1.8, 24mm (wide), 1/1.28&quot;, 1.22&micro;m, dual pixel PDAF, sensor-shift OIS 12 MP, f/2.8, 77mm (telephoto), 1/3.5&quot;, 1.0&micro;m, PDAF, OIS, 3x optical zoom 12 MP, f/2.2, 13mm, 120˚ (ultrawide), 1/2.55&quot;, 1.4&micro;m, dual pixel PDAF TOF 3D LiDAR scanner (depth)', 'Dual-LED dual-tone flash, HDR (photo/panorama)', '4K@24/25/30/60fps, 1080p@25/30/60/120/240fps, 10-bit HDR, Dolby Vision HDR (up to 60fps), ProRes, stereo sound rec.', '12 MP, f/1.9, 23mm (wide), 1/3.6&quot;, PDAF, OIS SL 3D, (depth/biometrics sensor)', 'HDR', '4K@24/25/30/60fps, 1080p@25/30/60/120fps, gyro-EIS', 'Yes, with stereo speakers', 'No', 'Wi-Fi 802.11 a/b/g/n/ac/6, dual-band, hotspot', '5.3, A2DP, LE', 'GPS (L1+L5), GLONASS, GALILEO, BDS, QZSS', 'Yes', '-None-', 'No', 'Lightning, USB 2.0', 'Face ID, accelerometer, gyro, proximity, compass, barometer', 'Li-Ion 4323 mAh, non-removable (16.68 Wh)', 'Wired, PD2.0, 50% in 30 min (advertised) 15W wireless (MagSafe) 15W wireless (Qi2) - requires iOS 17.2 update', 'Space Black, Silver, Gold, Deep Purple', 'A2894, A2651, A2893, A2895, iphone15,3', 0, 123),
(11, NULL, 'Oppo Find X8', 'The OPPO Find X8 is a cutting-edge flagship smartphone designed for those who seek top-tier performance, stunning design, and advanced technology. With its exceptional display, powerful hardware, and sophisticated camera system, the Find X8 delivers an unparalleled mobile experience.', '54999.00', 'oppo-find-x8.jpg', 'oppo-find-x8.jpg', 'oppo-find-x8.jpg', 'GSM 850 / 900 / 1800 / 1900 - SIM 1 &amp; SIM 2', '2024, October 24', 'Available. Released 2024, October 30', '157.4 x 74.3 x 7.9 mm (6.20 x 2.93 x 0.31 in)', '193 g (6.81 oz)', 'Glass front (Gorilla Glass 7i), glass back (Gorilla Glass 7i), aluminum frame', 'Nano-SIM, eSIM or Dual SIM (Nano-SIM, dual stand-by)  	IP68/IP69 dust/water resistant (up to 1.5m for 30 min)', 'AMOLED, 1B colors, 120Hz, Dolby Vision, HDR10+, 800 nits (typ), 1600 nits (HBM), 4500 nits (peak)', '6.59 inches, 105.6 cm2 (~90.3% screen-to-body ratio)', '1256 x 2760 pixels (~460 ppi density)', 'Corning Gorilla Glass 7i  	Ultra HDR image support', 'Android 15, up to 5 major Android upgrades, ColorOS 15', 'Mediatek Dimensity 9400 (3 nm)', 'Octa-core (1x3.63 GHz Cortex-X925 &amp; 3x3.3 GHz Cortex-X4 &amp; 4x2.4 GHz Cortex-A720)', 'Immortalis-G925', 'No', '256GB 12GB RAM, 256GB 16GB RAM, 512GB 12GB RAM, 512GB 16GB RAM, 1TB 16GB RAM', '50 MP, f/1.8, 24mm (wide), 1/1.56&quot;, 1.0&micro;m, PDAF, OIS 50 MP, f/2.6, 73mm (periscope telephoto), 1/1.95&quot;, 0.61&micro;m, 3x optical zoom, PDAF, OIS 50 MP, f/2.0, 15mm, 120˚ (ultrawide), 1/2.75&quot;, 0.64&micro;m, PDAF', 'Laser AF, Hasselblad Color Calibration, LED flash, HDR, panorama', '4K@30/60fps, 1080p@30/60/240fps; gyro-EIS; HDR, 10‑bit video, Dolby Vision', '32 MP, f/2.4, 21mm (wide), 1/2.74&quot;, 0.8&micro;m', 'Panorama', '4K@30/60fps, 1080p@30/60fps, gyro-EIS', 'Yes, with stereo speakers', 'No', 'Wi-Fi 802.11 a/b/g/n/ac/6/7, dual-band, Wi-Fi Direct', '5.4, A2DP, LE, aptX HD, LHDC 5', 'GPS (L1+L5), BDS (B1I+B1c+B2a+B2b), GALILEO (E1+E5a+E5b), QZSS (L1+L5), GLONASS, NavIC (L5)', 'Yes; NFC-SIM, HCE, eSE, eID', 'Yes', 'No', 'USB Type-C 3.0 (Global), 2.0 (China), OTG', 'Fingerprint (under display, optical), accelerometer, gyro, proximity, compass, color spectrum', 'Si/C 5630 mAh, non-removable', '80W wired, PD 55W, PPS, UFCS 50W wireless 10W reverse wireless', 'Star Grey, Space Black, Shell Pink, Blue', 'CPH2651, PKB110', 0, 2),
(12, NULL, 'Vivo V40', 'The Vivo V40 is a stylish and powerful smartphone designed to deliver high-end features at a competitive price. With its vibrant AMOLED display, sleek design, and advanced cameras, it caters to both tech enthusiasts and casual users who value a premium mobile experience.', '29999.00', 'vivo-v40.jpg', 'vivo-v40.jpg', 'vivo-v40.jpg', 'GSM / HSPA / LTE / 5G', '2024, June 17', 'Available. Released 2024, July 03', '164.2 x 75 x 7.6 mm (6.46 x 2.95 x 0.30 in)', '190 g (6.70 oz)', 'Glass front, plastic frame, glass back IP68/IP69 dust/water resistant (up to 1.5m for 30 min)', 'Dual SIM (Nano-SIM, dual stand-by) + eSIM or Dual SIM (Nano-SIM, dual stand-by)', 'AMOLED, HDR10+, 120Hz, 4500 nits (peak)', '6.78 inches, 111.0 cm2 (~90.1% screen-to-body ratio)', '1260 x 2800 pixels, 20:9 ratio (~453 ppi density)', 'Schott Xensation Alpha', 'Android 14, Funtouch 14', 'Qualcomm SM7550-AB Snapdragon 7 Gen 3 (4 nm)', 'Octa-core (1x2.63 GHz Cortex-A715 &amp; 3x2.4 GHz Cortex-A715 &amp; 4x1.8 GHz Cortex-A510)', 'Adreno 720', 'No', '128GB 8GB RAM, 256GB 8GB RAM, 256GB 12GB RAM, 512GB 12GB RAM', '50 MP, f/1.9, 24mm (wide), 1/1.56&quot;, 1.0&micro;m, PDAF, OIS 50 MP, f/2.0, 15mm, 119˚ (ultrawide), 1/2.76&quot;, 0.64&micro;m, AF', 'Zeiss optics, Ring-LED flash, panorama, HDR', '4K@30fps, 1080p@30fps, gyro-EIS, OIS', '50 MP, f/2.0, 21mm (wide), 1/2.76&quot;, 0.64&micro;m, AF', 'HDR', '4K@30fps, 1080p@30fps', 'Yes, with stereo speakers', 'No', 'Wi-Fi 802.11 a/b/g/n/ac/6, dual-band', '5.4, A2DP, LE', 'GPS, GALILEO, GLONASS, QZSS, BDS, NavIC', 'Yes (market/region dependent)', 'None', 'No', 'USB Type-C 2.0, OTG', 'Fingerprint (under display, optical), accelerometer, gyro, proximity, compass', 'Li-Ion 5500 mAh, non-removable', '80W wired, PD', 'Stellar Silver (Titanium Grey), Nebula Purple (Lotus Purple), Ganges Blue, Moonlight White, Sunglow Peach', 'V2348', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `statistics_tbl`
--

CREATE TABLE `statistics_tbl` (
  `id` bigint NOT NULL,
  `product_id` int NOT NULL,
  `type` tinyint NOT NULL COMMENT '0 => PAGE VIEW, 1 => ADD TO CART, 2 => ADD TO WISHLIST, 3 => ORDERED',
  `created_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statistics_tbl`
--

INSERT INTO `statistics_tbl` (`id`, `product_id`, `type`, `created_timestamp`) VALUES
(36, 8, 0, '2024-11-07 02:22:08'),
(43, 9, 1, '2024-11-11 17:05:18'),
(44, 9, 3, '2024-11-11 17:05:49'),
(45, 9, 0, '2024-11-11 18:24:07'),
(46, 8, 0, '2024-11-13 16:33:46'),
(47, 8, 0, '2024-11-13 16:43:59'),
(48, 9, 1, '2024-11-14 09:17:11'),
(49, 9, 3, '2024-11-14 09:17:56'),
(50, 9, 1, '2024-11-14 09:40:58'),
(51, 9, 3, '2024-11-14 09:42:16'),
(52, 8, 1, '2024-11-14 09:42:42'),
(53, 8, 3, '2024-11-14 09:43:22'),
(54, 9, 1, '2024-11-14 09:43:41'),
(55, 9, 3, '2024-11-14 09:44:04'),
(56, 9, 1, '2024-11-14 09:45:56'),
(57, 9, 3, '2024-11-14 09:52:54'),
(58, 8, 1, '2024-11-14 09:56:45'),
(59, 8, 3, '2024-11-14 09:59:45'),
(60, 9, 1, '2024-11-14 10:01:54'),
(61, 8, 0, '2024-11-15 10:16:17'),
(62, 9, 0, '2024-11-15 10:23:52'),
(63, 8, 0, '2024-11-15 12:11:35'),
(64, 8, 0, '2024-11-15 12:11:36'),
(65, 8, 1, '2024-11-15 13:09:40'),
(66, 9, 0, '2024-11-15 13:17:38'),
(67, 9, 0, '2024-11-15 13:18:50'),
(68, 8, 0, '2024-11-16 12:20:12'),
(69, 8, 0, '2024-11-16 13:44:02'),
(70, 8, 1, '2024-11-16 13:47:20'),
(71, 9, 1, '2024-11-16 14:07:20'),
(72, 8, 0, '2024-11-16 14:21:10'),
(73, 8, 3, '2024-11-16 18:48:52'),
(74, 9, 3, '2024-11-16 18:48:52'),
(75, 8, 1, '2024-11-16 18:49:34'),
(76, 8, 3, '2024-11-16 18:49:56'),
(77, 9, 1, '2024-11-16 18:52:48'),
(78, 9, 3, '2024-11-16 18:53:18'),
(79, 8, 1, '2024-11-16 18:54:52'),
(80, 8, 3, '2024-11-16 18:55:13'),
(81, 8, 1, '2024-11-16 18:58:44'),
(82, 8, 3, '2024-11-16 18:59:30'),
(83, 8, 1, '2024-11-16 19:05:25'),
(84, 8, 3, '2024-11-16 19:06:20'),
(85, 8, 1, '2024-11-17 12:13:38'),
(86, 8, 0, '2024-11-17 14:13:29'),
(87, 8, 2, '2024-11-17 14:15:17'),
(88, 8, 1, '2024-11-17 14:15:51'),
(89, 8, 3, '2024-11-17 14:16:59'),
(90, 9, 0, '2024-11-17 17:05:08'),
(91, 8, 0, '2024-11-17 18:09:01'),
(92, 9, 0, '2024-11-17 18:17:52'),
(93, 8, 0, '2024-11-17 18:19:31'),
(94, 8, 0, '2024-11-17 18:20:11'),
(95, 9, 0, '2024-11-17 18:20:34'),
(96, 8, 0, '2024-11-17 18:20:41'),
(97, 8, 0, '2024-11-18 13:14:37'),
(98, 9, 0, '2024-11-18 13:14:44'),
(99, 8, 0, '2024-11-18 13:21:18'),
(100, 8, 0, '2024-11-18 13:26:00'),
(101, 8, 0, '2024-11-18 13:26:14'),
(102, 8, 0, '2024-11-18 13:26:19'),
(103, 8, 0, '2024-11-18 13:28:13'),
(104, 8, 0, '2024-11-18 13:28:17'),
(105, 8, 0, '2024-11-18 13:28:56'),
(106, 8, 0, '2024-11-18 13:29:03'),
(107, 8, 0, '2024-11-18 13:29:11'),
(108, 8, 0, '2024-11-18 13:31:50'),
(109, 8, 0, '2024-11-18 13:31:54'),
(110, 8, 0, '2024-11-18 13:32:33'),
(111, 8, 0, '2024-11-18 13:32:39'),
(112, 8, 0, '2024-11-18 13:33:44'),
(113, 8, 0, '2024-11-18 13:34:43'),
(114, 8, 0, '2024-11-18 13:34:47'),
(115, 8, 0, '2024-11-18 13:35:31'),
(116, 8, 0, '2024-11-18 13:35:33'),
(117, 8, 0, '2024-11-18 13:37:01'),
(118, 8, 0, '2024-11-18 13:37:06'),
(119, 8, 0, '2024-11-18 13:38:06'),
(120, 8, 0, '2024-11-18 13:38:22'),
(121, 8, 0, '2024-11-18 13:39:19'),
(122, 8, 0, '2024-11-18 13:43:11'),
(123, 8, 0, '2024-11-18 13:43:31'),
(124, 8, 0, '2024-11-18 13:43:46'),
(125, 8, 0, '2024-11-18 13:44:11'),
(126, 8, 0, '2024-11-18 13:44:33'),
(127, 8, 0, '2024-11-18 13:46:20'),
(128, 8, 0, '2024-11-18 13:46:54'),
(129, 8, 0, '2024-11-18 16:55:05'),
(130, 8, 0, '2024-11-18 16:57:52'),
(131, 8, 0, '2024-11-18 16:57:59'),
(132, 8, 0, '2024-11-18 16:58:51'),
(133, 8, 0, '2024-11-18 17:01:26'),
(134, 8, 0, '2024-11-18 17:01:41'),
(135, 8, 0, '2024-11-18 17:02:20'),
(136, 8, 0, '2024-11-18 17:03:45'),
(137, 8, 0, '2024-11-18 17:04:15'),
(138, 8, 0, '2024-11-18 17:04:39'),
(139, 8, 0, '2024-11-18 17:09:41'),
(140, 8, 0, '2024-11-18 17:10:00'),
(141, 8, 0, '2024-11-18 17:10:02'),
(142, 8, 0, '2024-11-18 17:10:12'),
(143, 8, 0, '2024-11-18 17:12:29'),
(144, 8, 0, '2024-11-18 17:12:35'),
(145, 8, 0, '2024-11-18 17:16:33'),
(146, 8, 0, '2024-11-18 17:17:16'),
(147, 8, 0, '2024-11-18 17:18:38'),
(148, 8, 0, '2024-11-18 17:22:31'),
(149, 8, 0, '2024-11-18 17:23:41'),
(150, 8, 0, '2024-11-18 17:24:39'),
(151, 8, 0, '2024-11-18 17:25:05'),
(152, 8, 0, '2024-11-18 17:25:08'),
(153, 8, 0, '2024-11-18 17:28:54'),
(154, 8, 0, '2024-11-18 17:29:56'),
(155, 8, 0, '2024-11-18 17:33:12'),
(156, 8, 0, '2024-11-18 17:33:34'),
(157, 8, 0, '2024-11-18 17:38:52'),
(158, 8, 0, '2024-11-18 17:40:01'),
(159, 9, 0, '2024-11-18 17:40:21'),
(160, 8, 0, '2024-11-18 17:40:51'),
(161, 8, 0, '2024-11-18 17:42:05'),
(162, 8, 0, '2024-11-18 17:42:07'),
(163, 8, 0, '2024-11-18 17:42:11'),
(164, 8, 0, '2024-11-18 17:42:25'),
(165, 8, 0, '2024-11-18 17:43:30'),
(166, 9, 0, '2024-11-18 17:44:23'),
(167, 9, 0, '2024-11-18 17:44:42'),
(168, 9, 0, '2024-11-18 17:45:08'),
(169, 9, 0, '2024-11-18 17:50:19'),
(170, 9, 0, '2024-11-18 17:52:39'),
(171, 9, 0, '2024-11-18 17:56:55'),
(172, 9, 0, '2024-11-18 17:57:45'),
(173, 9, 0, '2024-11-18 17:57:55'),
(174, 8, 0, '2024-11-18 17:58:08'),
(175, 9, 0, '2024-11-18 17:58:17'),
(176, 9, 0, '2024-11-18 17:59:38'),
(177, 9, 0, '2024-11-18 17:59:49'),
(178, 9, 0, '2024-11-18 17:59:55'),
(179, 9, 0, '2024-11-18 18:00:27'),
(180, 8, 0, '2024-11-18 18:00:55'),
(181, 9, 0, '2024-11-18 18:01:03'),
(182, 8, 0, '2024-11-18 18:01:42'),
(183, 8, 0, '2024-11-18 18:03:30'),
(184, 8, 0, '2024-11-18 18:05:10'),
(185, 8, 0, '2024-11-18 18:06:49'),
(186, 8, 0, '2024-11-18 18:06:53'),
(187, 8, 0, '2024-11-18 18:07:13'),
(188, 8, 0, '2024-11-18 18:08:05'),
(189, 8, 2, '2024-11-18 18:08:26'),
(190, 8, 0, '2024-11-18 18:08:26'),
(191, 8, 1, '2024-11-18 18:08:29'),
(192, 8, 1, '2024-11-18 18:19:21'),
(193, 8, 3, '2024-11-18 18:19:37'),
(194, 8, 1, '2024-11-18 18:21:16'),
(195, 8, 3, '2024-11-18 19:26:33'),
(196, 8, 0, '2024-11-18 19:28:05'),
(197, 8, 1, '2024-11-18 19:28:18'),
(198, 8, 0, '2024-11-18 19:28:18'),
(199, 8, 3, '2024-11-18 19:41:25'),
(200, 8, 0, '2024-11-18 19:41:52'),
(201, 8, 0, '2024-11-18 19:41:53'),
(202, 8, 1, '2024-11-18 19:41:57'),
(203, 8, 0, '2024-11-18 19:41:57'),
(204, 8, 3, '2024-11-18 19:47:06'),
(205, 8, 0, '2024-11-18 19:54:46'),
(206, 8, 1, '2024-11-18 19:54:49'),
(207, 8, 0, '2024-11-18 19:54:49'),
(208, 8, 0, '2024-11-19 08:28:27'),
(209, 8, 0, '2024-11-19 08:28:42'),
(210, 8, 1, '2024-11-19 08:29:01'),
(211, 8, 0, '2024-11-19 08:29:01'),
(212, 9, 1, '2024-11-19 08:36:09'),
(213, 8, 3, '2024-11-19 08:46:23'),
(214, 9, 3, '2024-11-19 08:46:23'),
(215, 8, 1, '2024-11-19 08:46:30'),
(216, 8, 0, '2024-11-19 09:14:00'),
(217, 8, 1, '2024-11-19 09:14:37'),
(218, 8, 3, '2024-11-19 17:46:10'),
(219, 8, 0, '2024-11-19 17:48:55'),
(220, 9, 0, '2024-11-19 17:49:11'),
(221, 9, 1, '2024-11-21 06:09:04'),
(222, 9, 3, '2024-11-21 06:18:03'),
(223, 9, 0, '2024-11-21 06:18:32'),
(224, 9, 1, '2024-11-21 06:21:31'),
(225, 9, 0, '2024-11-21 06:21:31'),
(226, 9, 3, '2024-11-21 06:22:43'),
(227, 8, 1, '2024-11-21 06:41:49'),
(228, 8, 3, '2024-11-21 07:00:11'),
(229, 8, 1, '2024-11-21 07:02:22'),
(230, 8, 3, '2024-11-21 07:49:34'),
(231, 8, 0, '2024-11-21 07:49:47'),
(232, 8, 1, '2024-11-21 07:49:49'),
(233, 8, 0, '2024-11-21 07:49:49'),
(234, 8, 3, '2024-11-21 08:06:00'),
(235, 8, 1, '2024-11-21 08:06:10'),
(236, 8, 3, '2024-11-21 08:06:19'),
(237, 8, 1, '2024-11-21 08:07:23'),
(238, 8, 3, '2024-11-21 08:07:32'),
(239, 8, 1, '2024-11-21 08:09:19'),
(240, 8, 3, '2024-11-21 08:10:58'),
(241, 8, 1, '2024-11-21 08:12:52'),
(242, 8, 3, '2024-11-21 08:13:01'),
(243, 8, 0, '2024-11-21 08:13:08'),
(244, 8, 1, '2024-11-21 08:13:11'),
(245, 8, 0, '2024-11-21 08:13:11'),
(246, 8, 3, '2024-11-21 08:17:35'),
(247, 8, 1, '2024-11-21 08:23:46'),
(248, 8, 3, '2024-11-21 08:32:53'),
(249, 8, 1, '2024-11-21 08:34:47'),
(250, 8, 3, '2024-11-21 09:10:50'),
(251, 8, 1, '2024-11-21 09:24:05'),
(252, 8, 3, '2024-11-22 09:24:18'),
(253, 8, 0, '2024-11-22 09:24:24'),
(254, 9, 0, '2024-11-22 13:44:10'),
(255, 8, 3, '2024-11-22 13:44:50'),
(256, 8, 1, '2024-11-22 14:43:37'),
(257, 8, 0, '2024-11-22 14:46:39'),
(258, 8, 0, '2024-11-22 14:46:53'),
(259, 8, 0, '2024-11-22 14:47:00'),
(260, 8, 0, '2024-11-22 14:47:13'),
(261, 8, 0, '2024-11-22 14:51:07'),
(262, 8, 0, '2024-11-22 14:58:58'),
(263, 8, 0, '2024-11-22 15:00:29'),
(264, 8, 3, '2024-11-22 15:43:10'),
(265, 9, 1, '2024-11-22 15:46:13'),
(266, 9, 3, '2024-11-22 15:47:04'),
(267, 10, 0, '2024-11-22 16:53:15'),
(268, 12, 0, '2024-11-22 17:16:55'),
(269, 8, 0, '2024-11-22 17:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_code` varchar(10) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_code`, `reset_expires`) VALUES
(3, 'fitz', 'mianofitzanthony@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL),
(4, 'Lance', 'lance@gmail.com', '4e17a448e043206801b95de317e07c839770c8b8', NULL, NULL),
(5, 'admin', 'fitzzy@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', NULL, NULL),
(9, 'sm', 'smecanta@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL),
(10, 'leb', 'buenaventuraforthree@gmail.com', 'b2f0258a130c612bf7fe4be8cd25e1289509d7ad', NULL, NULL),
(11, 'blue', 'hate7799@gmail.com', '4c9a82ce72ca2519f38d0af0abbb4cecb9fceca9', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gcash_screenshot`
--
ALTER TABLE `gcash_screenshot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_idx` (`cid`);

--
-- Indexes for table `statistics_tbl`
--
ALTER TABLE `statistics_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `fk_product_id_idx` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `gcash_screenshot`
--
ALTER TABLE `gcash_screenshot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `statistics_tbl`
--
ALTER TABLE `statistics_tbl`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gcash_screenshot`
--
ALTER TABLE `gcash_screenshot`
  ADD CONSTRAINT `gcash_screenshot_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`cid`) REFERENCES `category` (`id`);

--
-- Constraints for table `statistics_tbl`
--
ALTER TABLE `statistics_tbl`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
