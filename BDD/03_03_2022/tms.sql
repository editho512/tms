-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2022 at 01:19 PM
-- Server version: 10.5.13-MariaDB-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `espacefiltre_tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `camions`
--

CREATE TABLE `camions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marque` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_chassis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `camions`
--

INSERT INTO `camions` (`id`, `name`, `annee`, `model`, `marque`, `numero_chassis`, `photo`, `blocked`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'MAGNUM', '2015', 'Renault magnum', 'RENAULT', '123456789321654', 'camions/T5QKwDp90zqKWMVnmaWIMz5jfqb5hnd0KHF9tLXO.jpg', 0, '2022-03-02 08:35:33', '2022-03-02 08:35:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `carburants`
--

CREATE TABLE `carburants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantite` double NOT NULL,
  `flux` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT NULL,
  `camion_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'A', NULL, NULL),
(2, 'B', NULL, NULL),
(3, 'C', NULL, NULL),
(4, 'D', NULL, NULL),
(5, 'E', NULL, NULL),
(6, 'F', NULL, NULL),
(7, 'G', NULL, NULL),
(8, 'H', NULL, NULL),
(9, 'I', NULL, NULL),
(10, 'J', NULL, NULL),
(11, 'K', NULL, NULL),
(12, 'L', NULL, NULL),
(13, 'M', NULL, NULL),
(14, 'N', NULL, NULL),
(15, 'O', NULL, NULL),
(16, 'P', NULL, NULL),
(17, 'Q', NULL, NULL),
(18, 'R', NULL, NULL),
(19, 'S', NULL, NULL),
(20, 'T', NULL, NULL),
(21, 'U', NULL, NULL),
(22, 'V', NULL, NULL),
(23, 'W', NULL, NULL),
(24, 'X', NULL, NULL),
(25, 'Y', NULL, NULL),
(26, 'Z', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categorie_departs`
--

CREATE TABLE `categorie_departs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delais_approximatif` int(11) DEFAULT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Province de départ. Ex: Tana, Tamatave',
  `ville_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Ville d''arrivée. Ex: Manjakandriana',
  `categorie_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Catégorie a mettre pour ce trajet. Ex: A, B',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie_departs`
--

INSERT INTO `categorie_departs` (`id`, `delais_approximatif`, `province_id`, `ville_id`, `categorie_id`, `created_at`, `updated_at`) VALUES
(1, 24, 1, 1, 3, '2022-03-02 08:08:53', '2022-03-02 08:08:53'),
(2, 24, 1, 3, 3, '2022-03-02 08:09:04', '2022-03-02 08:09:04'),
(3, 24, 1, 2, 3, '2022-03-02 08:09:24', '2022-03-02 08:09:24'),
(4, 24, 1, 4, 2, '2022-03-02 08:10:24', '2022-03-02 08:10:24'),
(5, 24, 2, 1, 2, '2022-03-02 08:11:11', '2022-03-02 08:11:11'),
(6, 24, 2, 3, 1, '2022-03-02 08:11:20', '2022-03-02 08:11:20'),
(7, 24, 2, 4, 3, '2022-03-02 08:11:39', '2022-03-02 08:32:36'),
(8, 24, 2, 5, 3, '2022-03-02 08:11:50', '2022-03-02 08:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `categorie_rn_transporteurs`
--

CREATE TABLE `categorie_rn_transporteurs` (
  `id` int(20) UNSIGNED NOT NULL,
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `transporteur_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `categorie_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la catégorie',
  `prix` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie_rn_transporteurs`
--

INSERT INTO `categorie_rn_transporteurs` (`id`, `rn_id`, `transporteur_id`, `categorie_id`, `prix`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 3, 5000000.00, '2022-03-03 06:26:07', '2022-03-03 06:26:07'),
(3, 1, 1, 1, 600000.00, '2022-03-03 12:26:05', '2022-03-03 12:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `chauffeurs`
--

CREATE TABLE `chauffeurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permis` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `itineraires`
--

CREATE TABLE `itineraires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_trajet` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_02_25_112226_create_reservations_table', 1),
(5, '2022_03_01_130440_create_users_table', 1),
(6, '2022_03_01_130457_create_camions_table', 1),
(7, '2022_03_01_130509_create_rns_table', 1),
(8, '2022_03_01_130524_create_categories_table', 1),
(9, '2022_03_01_130536_create_provinces_table', 1),
(10, '2022_03_01_130547_create_villes_table', 1),
(11, '2022_03_01_130608_create_regions_table', 1),
(12, '2022_03_01_130716_create_categorie_departs_table', 1),
(13, '2022_03_01_130749_create_categorie_rn_transporteurs_table', 1),
(14, '2022_03_01_130826_create_rn_transporteurs_table', 1),
(15, '2022_03_01_132344_create_chauffeurs_table', 1),
(16, '2022_03_01_133123_create_ville_rns_table', 1),
(17, '2022_03_01_135452_add_foreign_key_to_reservations_table', 1),
(18, '2022_03_01_135523_add_foreign_key_to_villes_table', 1),
(19, '2022_03_01_135542_add_foreign_key_to_categorie_departs_table', 1),
(20, '2022_03_01_135605_add_foreign_key_to_categorie_rn_transporteurs_table', 1),
(21, '2022_03_01_135618_add_foreign_key_to_rn_transporteurs_table', 1),
(22, '2022_03_01_135636_add_foreign_key_to_ville_rns_table', 1),
(23, '2022_03_02_055251_create_province_rns_table', 1),
(24, '2022_03_02_055557_add_foreign_key_to_province_rns_table', 1),
(25, '2022_03_02_063323_add_user_id_to_camions_table', 2),
(26, '2022_03_02_063442_add_foreign_key_to_camions_table', 2);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'TAMATAVE', NULL, NULL),
(2, 'ANTANANARIVO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `province_rns`
--

CREATE TABLE `province_rns` (
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `rn_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `province_rns`
--

INSERT INTO `province_rns` (`province_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Itasy', NULL, NULL),
(2, 'Analamanga', NULL, NULL),
(3, 'Vakinankaratra', NULL, NULL),
(4, 'Bongolava', NULL, NULL),
(5, 'SAVA', NULL, NULL),
(6, 'DIANA', NULL, NULL),
(7, 'Amoron\'i Mania', NULL, NULL),
(8, 'Haute Matsiatra', NULL, NULL),
(9, 'Vatovavy-Fitovinany', NULL, NULL),
(10, 'Atsimo-Atsinanana', NULL, NULL),
(11, 'Ihorombe', NULL, NULL),
(12, 'Sofia', NULL, NULL),
(13, 'Boeny', NULL, NULL),
(14, 'Betsiboka', NULL, NULL),
(15, 'Melaky', NULL, NULL),
(16, 'Alaotra-Mangoro', NULL, NULL),
(17, 'Atsinanana', NULL, NULL),
(18, 'Analanjirofo', NULL, NULL),
(19, 'Menabe', NULL, NULL),
(20, 'Atsimo-Andrefana', NULL, NULL),
(21, 'Androy', NULL, NULL),
(22, 'Anosy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du client',
  `depart_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Province (grande ville) de départ de la reservation',
  `arrivee_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Ville d''arrivée de la reservation',
  `transporteur_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `date` datetime NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `depart_id`, `arrivee_id`, `transporteur_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(2, 5, 2, 5, 1, '2022-03-04 10:00:00', 'en attente', '2022-03-03 11:37:50', '2022-03-03 11:37:50'),
(3, 4, 1, 1, 1, '2022-03-11 14:00:00', 'en attente', '2022-03-03 11:43:44', '2022-03-03 11:43:44'),
(4, 5, 2, 5, 1, '2022-03-05 10:00:00', 'en attente', '2022-03-03 12:08:06', '2022-03-03 12:08:06'),
(5, 5, 2, 5, 1, '2022-03-15 10:00:00', 'en attente', '2022-03-03 12:23:29', '2022-03-03 12:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `rns`
--

CREATE TABLE `rns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rns`
--

INSERT INTO `rns` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'RN2', '2022-03-02 04:13:20', '2022-03-02 04:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `rn_transporteurs`
--

CREATE TABLE `rn_transporteurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rn_transporteurs`
--

INSERT INTO `rn_transporteurs` (`id`, `user_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trajets`
--

CREATE TABLE `trajets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrivee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime DEFAULT NULL,
  `etat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'En  cours',
  `camion_id` bigint(20) UNSIGNED NOT NULL,
  `chauffeur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MEDLOG', 'medlog@gmail.com', 'admin', NULL, '$2y$10$yUoZWA3Wuqi1vgLxmp6ZSez5ZZAs9ifdAS0g.I0fnqFkNcVgQHeP6', NULL, NULL, NULL),
(2, 'PREMIUM', 'premium@gmail.com', 'admin', NULL, '$2y$10$yUoZWA3Wuqi1vgLxmp6ZSez5ZZAs9ifdAS0g.I0fnqFkNcVgQHeP6', NULL, NULL, NULL),
(3, 'root', 'root@root.root', 'superAdmin', NULL, '$2y$10$yUoZWA3Wuqi1vgLxmp6ZSez5ZZAs9ifdAS0g.I0fnqFkNcVgQHeP6', NULL, NULL, NULL),
(4, 'rod', 'rod@gmail.com', 'client', NULL, '$2y$10$yUoZWA3Wuqi1vgLxmp6ZSez5ZZAs9ifdAS0g.I0fnqFkNcVgQHeP6', NULL, NULL, NULL),
(5, 'john', 'john@gmail.com', 'client', NULL, '$2y$10$yUoZWA3Wuqi1vgLxmp6ZSez5ZZAs9ifdAS0g.I0fnqFkNcVgQHeP6', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `villes`
--

CREATE TABLE `villes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `villes`
--

INSERT INTO `villes` (`id`, `nom`, `region_id`, `created_at`, `updated_at`) VALUES
(1, 'MORAMANGA', 16, NULL, NULL),
(2, 'ANTANANARIVO', 2, NULL, NULL),
(3, 'MANJAKANDRIANA', 2, NULL, NULL),
(4, 'BRICKAVILLE', 17, NULL, NULL),
(5, 'TOAMASINA', 17, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ville_rns`
--

CREATE TABLE `ville_rns` (
  `id` int(10) UNSIGNED NOT NULL,
  `ville_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la ville',
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ville_rns`
--

INSERT INTO `ville_rns` (`id`, `ville_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `camions`
--
ALTER TABLE `camions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_camion_transporteur` (`user_id`);

--
-- Indexes for table `carburants`
--
ALTER TABLE `carburants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_nom_unique` (`nom`);

--
-- Indexes for table `categorie_departs`
--
ALTER TABLE `categorie_departs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_depart` (`province_id`),
  ADD KEY `i_fk_arrivee` (`ville_id`),
  ADD KEY `i_fk_categorie` (`categorie_id`);

--
-- Indexes for table `categorie_rn_transporteurs`
--
ALTER TABLE `categorie_rn_transporteurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_cat_trans_rn` (`rn_id`),
  ADD KEY `i_fk_cat_rn_transporteur` (`transporteur_id`),
  ADD KEY `i_fk_rn_trans_categorie` (`categorie_id`);

--
-- Indexes for table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `itineraires`
--
ALTER TABLE `itineraires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itineraires_id_trajet_foreign` (`id_trajet`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provinces_nom_unique` (`nom`);

--
-- Indexes for table `province_rns`
--
ALTER TABLE `province_rns`
  ADD PRIMARY KEY (`province_id`,`rn_id`),
  ADD KEY `i_fk_rn_province` (`province_id`),
  ADD KEY `i_fk_province_rn` (`rn_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_nom_unique` (`nom`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_reservation_client` (`client_id`),
  ADD KEY `i_fk_reservation_depart` (`depart_id`),
  ADD KEY `i_fk_reservation_arrivee` (`arrivee_id`),
  ADD KEY `i_fk_reservation_transporteur` (`transporteur_id`);

--
-- Indexes for table `rns`
--
ALTER TABLE `rns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rns_nom_unique` (`nom`);

--
-- Indexes for table `rn_transporteurs`
--
ALTER TABLE `rn_transporteurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_transporteur` (`user_id`),
  ADD KEY `i_fk_rn` (`rn_id`);

--
-- Indexes for table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trajets_camion_id_foreign` (`camion_id`),
  ADD KEY `trajets_chauffeur_id_foreign` (`chauffeur_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `villes_nom_unique` (`nom`),
  ADD KEY `i_fk_ville_region` (`region_id`);

--
-- Indexes for table `ville_rns`
--
ALTER TABLE `ville_rns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_fk_rn_ville` (`ville_id`),
  ADD KEY `i_fk_ville_rn` (`rn_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `camions`
--
ALTER TABLE `camions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carburants`
--
ALTER TABLE `carburants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categorie_departs`
--
ALTER TABLE `categorie_departs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categorie_rn_transporteurs`
--
ALTER TABLE `categorie_rn_transporteurs`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itineraires`
--
ALTER TABLE `itineraires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rns`
--
ALTER TABLE `rns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rn_transporteurs`
--
ALTER TABLE `rn_transporteurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `villes`
--
ALTER TABLE `villes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ville_rns`
--
ALTER TABLE `ville_rns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `camions`
--
ALTER TABLE `camions`
  ADD CONSTRAINT `i_fk_camion_transporteur` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categorie_departs`
--
ALTER TABLE `categorie_departs`
  ADD CONSTRAINT `i_fk_arrivee` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `i_fk_depart` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `categorie_rn_transporteurs`
--
ALTER TABLE `categorie_rn_transporteurs`
  ADD CONSTRAINT `i_fk_cat_rn_transporteur` FOREIGN KEY (`transporteur_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `i_fk_cat_trans_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_rn_trans_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `province_rns`
--
ALTER TABLE `province_rns`
  ADD CONSTRAINT `i_fk_province_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_rn_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `i_fk_reservation_arrivee` FOREIGN KEY (`arrivee_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_reservation_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `i_fk_reservation_depart` FOREIGN KEY (`depart_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `i_fk_reservation_transporteur` FOREIGN KEY (`transporteur_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rn_transporteurs`
--
ALTER TABLE `rn_transporteurs`
  ADD CONSTRAINT `i_fk_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_transporteur` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `villes`
--
ALTER TABLE `villes`
  ADD CONSTRAINT `i_fk_ville_region` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Constraints for table `ville_rns`
--
ALTER TABLE `ville_rns`
  ADD CONSTRAINT `i_fk_rn_ville` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_ville_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
