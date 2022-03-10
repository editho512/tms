-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 10 mars 2022 à 07:35
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tms`
--

-- --------------------------------------------------------

--
-- Structure de la table `camions`
--

DROP TABLE IF EXISTS `camions`;
CREATE TABLE IF NOT EXISTS `camions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marque` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_chassis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_camion_transporteur` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `camions`
--

INSERT INTO `camions` (`id`, `name`, `annee`, `model`, `marque`, `numero_chassis`, `photo`, `blocked`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'MAGNUM', '2015', 'Renault magnum', 'RENAULT', '123456789321654', 'camions/yWYslJDq93oQLvfUz4oK4Zc2bqpvg3qds0tmF0Db.jpg', 0, '2022-03-02 08:35:33', '2022-03-09 08:13:02', 1),
(2, 'PREMIUM', '2018', 'Premium 440', 'Renault', '789456123321654', 'camions/1b6YPlxkS8J3tnK3vXCLP5w2OBNajw09k2E7nLhH.jpg', 0, '2022-03-04 03:02:16', '2022-03-04 03:02:16', 2),
(3, 'Mercedes Benz', '2017', 'AZS852', 'Mercedes Benz', '78985469875', 'camions/SfVI0ldsYoO6VTn68fbKSVmOzQI0QUgFd6cCOynK.jpg', 0, '2022-03-08 05:18:55', '2022-03-09 08:13:07', 1);

-- --------------------------------------------------------

--
-- Structure de la table `carburants`
--

DROP TABLE IF EXISTS `carburants`;
CREATE TABLE IF NOT EXISTS `carburants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantite` double NOT NULL,
  `flux` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NULL DEFAULT NULL,
  `camion_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carburants`
--

INSERT INTO `carburants` (`id`, `quantite`, `flux`, `date`, `camion_id`, `created_at`, `updated_at`) VALUES
(1, 200, 0, '2022-03-07 21:00:00', 1, '2022-03-09 02:44:17', '2022-03-09 03:04:55'),
(2, 250, 0, '2022-03-08 05:44:00', 1, '2022-03-09 02:45:06', '2022-03-09 02:45:06');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
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
-- Structure de la table `categorie_departs`
--

DROP TABLE IF EXISTS `categorie_departs`;
CREATE TABLE IF NOT EXISTS `categorie_departs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `delais_approximatif` int(11) DEFAULT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Province de départ. Ex: Tana, Tamatave',
  `ville_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Ville d''arrivée. Ex: Manjakandriana',
  `categorie_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Catégorie a mettre pour ce trajet. Ex: A, B',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_depart` (`province_id`),
  KEY `i_fk_arrivee` (`ville_id`),
  KEY `i_fk_categorie` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_departs`
--

INSERT INTO `categorie_departs` (`id`, `delais_approximatif`, `province_id`, `ville_id`, `categorie_id`, `created_at`, `updated_at`) VALUES
(1, 24, 1, 1, 3, '2022-03-02 05:08:53', '2022-03-02 05:08:53'),
(2, 24, 1, 3, 3, '2022-03-02 05:09:04', '2022-03-02 05:09:04'),
(3, 24, 1, 2, 3, '2022-03-02 05:09:24', '2022-03-02 05:09:24'),
(4, 24, 1, 4, 2, '2022-03-02 05:10:24', '2022-03-02 05:10:24'),
(5, 24, 2, 1, 2, '2022-03-02 05:11:11', '2022-03-02 05:11:11'),
(6, 24, 2, 3, 1, '2022-03-02 05:11:20', '2022-03-02 05:11:20'),
(7, 24, 2, 4, 3, '2022-03-02 05:11:39', '2022-03-02 05:32:36'),
(8, 24, 2, 5, 3, '2022-03-02 05:11:50', '2022-03-02 05:11:50'),
(9, 48, 1, 56, 2, '2022-03-04 02:19:38', '2022-03-04 02:19:38'),
(10, 92, 1, 57, 5, '2022-03-04 02:20:49', '2022-03-04 02:20:49'),
(11, 92, 1, 58, 6, '2022-03-04 02:21:13', '2022-03-04 02:21:13'),
(12, 48, 1, 60, 2, '2022-03-04 02:21:39', '2022-03-04 02:21:39'),
(13, 48, 2, 56, 4, '2022-03-04 02:22:37', '2022-03-04 02:22:37'),
(14, 92, 2, 57, 7, '2022-03-04 02:22:59', '2022-03-04 02:22:59'),
(15, 92, 2, 58, 7, '2022-03-04 02:23:17', '2022-03-04 02:23:17'),
(16, 48, 2, 60, 4, '2022-03-04 02:24:06', '2022-03-04 02:24:06'),
(17, 24, 2, 71, 2, '2022-03-08 00:32:28', '2022-03-08 00:32:28'),
(18, 48, 2, 72, 3, '2022-03-08 00:36:14', '2022-03-08 00:36:14'),
(19, 48, 2, 73, 3, '2022-03-08 00:37:03', '2022-03-08 00:37:03'),
(20, 48, 2, 74, 4, '2022-03-08 00:37:21', '2022-03-08 00:37:21'),
(21, 48, 2, 75, 5, '2022-03-08 00:37:47', '2022-03-08 00:37:47'),
(22, 48, 2, 76, 5, '2022-03-08 00:40:03', '2022-03-08 00:40:03'),
(23, 48, 2, 77, 5, '2022-03-08 00:40:37', '2022-03-08 00:40:37'),
(24, 92, 2, 81, 6, '2022-03-08 00:42:07', '2022-03-08 00:42:07'),
(25, 24, 2, 36, 2, '2022-03-08 00:51:30', '2022-03-08 00:51:30'),
(26, 24, 3, 2, 3, '2022-03-08 00:51:54', '2022-03-08 00:51:54'),
(27, 24, 3, 71, 3, '2022-03-08 00:55:05', '2022-03-08 00:55:05'),
(28, 24, 3, 72, 3, '2022-03-08 00:55:23', '2022-03-08 00:55:23'),
(29, 24, 3, 73, 4, '2022-03-08 00:55:36', '2022-03-08 00:55:36'),
(30, 48, 3, 81, 4, '2022-03-08 00:55:59', '2022-03-08 00:55:59'),
(31, 24, 3, 77, 3, '2022-03-08 00:56:22', '2022-03-08 00:56:22'),
(32, 48, 3, 76, 4, '2022-03-08 00:56:45', '2022-03-08 00:56:45'),
(33, 48, 6, 36, 5, '2022-03-08 00:59:25', '2022-03-08 00:59:25'),
(34, 92, 6, 2, 5, '2022-03-08 00:59:50', '2022-03-08 00:59:50'),
(35, 92, 6, 5, 8, '2022-03-08 01:36:26', '2022-03-08 01:36:26'),
(36, 24, 6, 72, 1, '2022-03-09 05:25:35', '2022-03-09 05:25:35'),
(37, 92, 6, 4, 8, '2022-03-08 01:36:26', '2022-03-08 01:36:26'),
(41, 48, 2, 6, 1, '2022-03-10 03:52:00', '2022-03-10 03:52:00');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_rn_transporteurs`
--

DROP TABLE IF EXISTS `categorie_rn_transporteurs`;
CREATE TABLE IF NOT EXISTS `categorie_rn_transporteurs` (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `transporteur_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `categorie_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la catégorie',
  `prix` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_cat_trans_rn` (`rn_id`),
  KEY `i_fk_cat_rn_transporteur` (`transporteur_id`),
  KEY `i_fk_rn_trans_categorie` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_rn_transporteurs`
--

INSERT INTO `categorie_rn_transporteurs` (`id`, `rn_id`, `transporteur_id`, `categorie_id`, `prix`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 3, '5000000.00', '2022-03-03 06:26:07', '2022-03-03 06:26:07'),
(3, 1, 1, 1, '600000.00', '2022-03-03 12:26:05', '2022-03-03 12:26:05'),
(4, 1, 1, 7, '500000.00', '2022-03-10 02:44:32', '2022-03-10 02:44:32');

-- --------------------------------------------------------

--
-- Structure de la table `chauffeurs`
--

DROP TABLE IF EXISTS `chauffeurs`;
CREATE TABLE IF NOT EXISTS `chauffeurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permis` text COLLATE utf8mb4_unicode_ci,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chauffeurs`
--

INSERT INTO `chauffeurs` (`id`, `name`, `phone`, `cin`, `permis`, `blocked`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Kael', '0325033378', '78985466987', NULL, 0, 1, '2022-03-07 10:37:03', '2022-03-07 10:37:03');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `itineraires`
--

DROP TABLE IF EXISTS `itineraires`;
CREATE TABLE IF NOT EXISTS `itineraires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_trajet` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itineraires_id_trajet_foreign` (`id_trajet`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `itineraires`
--

INSERT INTO `itineraires` (`id`, `nom`, `created_at`, `updated_at`, `id_trajet`) VALUES
(1, 'toamasina', '2022-03-07 10:40:08', '2022-03-07 10:40:08', 3),
(2, 'antananarivo', '2022-03-07 10:40:08', '2022-03-07 10:40:08', 3),
(3, 'ANTANANARIVO', '2022-03-08 09:09:06', '2022-03-08 09:09:06', 7),
(4, 'TOAMASINA', '2022-03-08 09:09:06', '2022-03-08 09:09:06', 7),
(10, 'Fénérive Est', '2022-03-09 02:58:59', '2022-03-09 02:58:59', 10),
(9, 'Mananara Nord', '2022-03-09 02:58:59', '2022-03-09 02:58:59', 10),
(14, 'ANTANANARIVO', '2022-03-09 04:33:06', '2022-03-09 04:33:06', 12),
(13, 'TAMATAVE', '2022-03-09 04:33:06', '2022-03-09 04:33:06', 12),
(15, 'Soanierana Ivongo', '2022-03-09 08:26:32', '2022-03-09 08:26:32', 13),
(16, 'Vavatenina', '2022-03-09 08:26:32', '2022-03-09 08:26:32', 13),
(28, 'TOAMASINA', '2022-03-10 02:27:24', '2022-03-10 02:27:24', 19),
(27, 'ANTANANARIVO', '2022-03-10 02:27:24', '2022-03-10 02:27:24', 19),
(26, 'test 2', '2022-03-09 10:53:30', '2022-03-09 10:53:30', 18),
(25, 'test 1', '2022-03-09 10:53:30', '2022-03-09 10:53:30', 18);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
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
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provinces_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'TAMATAVE', NULL, NULL),
(2, 'ANTANANARIVO', NULL, NULL),
(3, 'FIANARANTSOA', NULL, NULL),
(4, 'MAHAJANGA', NULL, NULL),
(5, 'ANTSIRANANA', NULL, NULL),
(6, 'TOLIARY', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `province_rns`
--

DROP TABLE IF EXISTS `province_rns`;
CREATE TABLE IF NOT EXISTS `province_rns` (
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `rn_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`province_id`,`rn_id`),
  KEY `i_fk_rn_province` (`province_id`),
  KEY `i_fk_province_rn` (`rn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `province_rns`
--

INSERT INTO `province_rns` (`province_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 23, NULL, NULL),
(2, 1, NULL, NULL),
(2, 18, NULL, NULL),
(2, 27, NULL, NULL),
(3, 20, NULL, NULL),
(3, 27, NULL, NULL),
(6, 27, NULL, NULL),
(6, 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regions_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `regions`
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
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du client',
  `depart_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Province (grande ville) de départ de la reservation',
  `arrivee_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Ville d''arrivée de la reservation',
  `transporteur_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `trajet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_reservation_client` (`client_id`),
  KEY `i_fk_reservation_depart` (`depart_id`),
  KEY `i_fk_reservation_arrivee` (`arrivee_id`),
  KEY `i_fk_reservation_transporteur` (`transporteur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `depart_id`, `arrivee_id`, `transporteur_id`, `trajet_id`, `date`, `status`, `created_at`, `updated_at`, `numero`) VALUES
(1, 5, 2, 5, 1, 19, '2022-03-12 10:30:00', 'réservé', '2022-03-10 02:26:18', '2022-03-10 02:27:24', 'RES-664-18');

-- --------------------------------------------------------

--
-- Structure de la table `rns`
--

DROP TABLE IF EXISTS `rns`;
CREATE TABLE IF NOT EXISTS `rns` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rns_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rns`
--

INSERT INTO `rns` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'RN2', '2022-03-02 04:13:20', '2022-03-02 04:13:20'),
(2, 'RN1', '2022-03-04 03:37:33', '2022-03-04 03:37:33'),
(3, 'RN11A', '2022-03-04 03:38:06', '2022-03-04 03:38:06'),
(4, 'RN11', '2022-03-04 03:39:52', '2022-03-04 03:39:52'),
(5, 'RN12', '2022-03-04 03:40:46', '2022-03-04 03:40:46'),
(6, 'RN12A', '2022-03-04 03:42:11', '2022-03-04 03:42:11'),
(7, 'RN13', '2022-03-04 03:42:46', '2022-03-04 03:42:46'),
(8, 'RN10', '2022-03-04 03:43:14', '2022-03-04 03:43:14'),
(9, 'RN22', '2022-03-04 03:43:38', '2022-03-04 03:43:38'),
(10, 'RN25', '2022-03-04 03:43:49', '2022-03-04 03:43:49'),
(11, 'RN27', '2022-03-04 03:44:20', '2022-03-04 03:44:20'),
(12, 'RN31', '2022-03-04 03:44:54', '2022-03-04 03:44:54'),
(13, 'RN32', '2022-03-04 03:45:58', '2022-03-04 03:45:58'),
(14, 'RN34', '2022-03-04 03:46:22', '2022-03-04 03:46:22'),
(15, 'RN35', '2022-03-04 03:46:43', '2022-03-04 03:46:43'),
(16, 'RN3A', '2022-03-04 03:47:03', '2022-03-04 03:47:03'),
(17, 'RN3B', '2022-03-04 03:48:39', '2022-03-04 03:48:39'),
(18, 'RN4', '2022-03-04 03:49:14', '2022-03-04 03:49:14'),
(19, 'RN41', '2022-03-04 03:50:22', '2022-03-04 03:50:22'),
(20, 'RN42', '2022-03-04 03:50:48', '2022-03-04 03:50:48'),
(21, 'RN43', '2022-03-04 03:51:12', '2022-03-04 03:51:12'),
(22, 'RN44', '2022-03-04 03:51:41', '2022-03-04 03:51:41'),
(23, 'RN5', '2022-03-04 03:52:35', '2022-03-04 03:52:35'),
(24, 'RN53', '2022-03-04 03:52:51', '2022-03-04 03:52:51'),
(25, 'RN5A', '2022-03-04 03:53:33', '2022-03-04 03:53:33'),
(26, 'RN6', '2022-03-04 03:54:16', '2022-03-04 03:54:16'),
(27, 'RN7', '2022-03-04 03:55:38', '2022-03-04 03:55:38'),
(28, 'RN8A', '2022-03-04 03:56:30', '2022-03-04 03:56:30'),
(29, 'RN9', '2022-03-04 03:56:52', '2022-03-04 03:56:52'),
(30, 'RN1B', '2022-03-04 03:58:48', '2022-03-04 03:58:48');

-- --------------------------------------------------------

--
-- Structure de la table `rn_transporteurs`
--

DROP TABLE IF EXISTS `rn_transporteurs`;
CREATE TABLE IF NOT EXISTS `rn_transporteurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du transporteur',
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_transporteur` (`user_id`),
  KEY `i_fk_rn` (`rn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rn_transporteurs`
--

INSERT INTO `rn_transporteurs` (`id`, `user_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

DROP TABLE IF EXISTS `trajets`;
CREATE TABLE IF NOT EXISTS `trajets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `depart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrivee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime DEFAULT NULL,
  `etat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'En  cours',
  `camion_id` bigint(20) UNSIGNED NOT NULL,
  `chauffeur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trajets_camion_id_foreign` (`camion_id`),
  KEY `trajets_chauffeur_id_foreign` (`chauffeur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trajets`
--

INSERT INTO `trajets` (`id`, `depart`, `arrivee`, `date_heure_depart`, `date_heure_arrivee`, `etat`, `camion_id`, `chauffeur_id`, `created_at`, `updated_at`) VALUES
(18, 'test 2', 'test 1', '2022-03-09 16:52:00', '2022-03-09 18:53:00', 'Terminé', 1, 1, '2022-03-09 10:53:30', '2022-03-09 10:53:41'),
(19, 'TOAMASINA', 'ANTANANARIVO', '2022-03-12 10:30:00', '2022-03-14 08:38:00', 'A prévoir', 1, 1, '2022-03-10 02:27:24', '2022-03-10 02:38:19');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MEDLOG', 'medlog@gmail.com', 'admin', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', 'MHO5MPw6eQIDZnOtCEJJuEKtPWQz7qjkiYcJ38mvE41UtgdXKPbf40O59xo9', NULL, NULL),
(2, 'PREMIUM LOGISTICS ', 'premium@gmail.com', 'admin', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', NULL, NULL, NULL),
(3, 'root', 'root@root.root', 'superAdmin', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', '283pxrlp9SC14YTf4E003d7ZwmbB76KeMCoGyHvvSEaRHhF6ZD2EuI2cGLys', NULL, NULL),
(4, 'rod', 'rod@gmail.com', 'client', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', NULL, NULL, NULL),
(5, 'john', 'john@gmail.com', 'client', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', 'WS78e5LkhzW06fEM8hcBYKzVmHQToE4uFG30UmRIr0ticZtXCcVub8pv8KFv', NULL, NULL),
(6, 'editho', 'editho.alex512@gmail.com', 'client', NULL, '$2y$10$llWSnMGGw.2uYeOl.2NMGut5Nf8FakuvG7RpZucXv9m0zk/GfKgfu', NULL, '2022-03-07 03:38:41', '2022-03-07 03:38:41');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `villes_nom_unique` (`nom`),
  KEY `i_fk_ville_region` (`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`, `region_id`, `created_at`, `updated_at`) VALUES
(1, 'MORAMANGA', 16, NULL, NULL),
(2, 'ANTANANARIVO', 2, NULL, NULL),
(3, 'MANJAKANDRIANA', 2, NULL, NULL),
(4, 'BRICKAVILLE', 17, NULL, NULL),
(5, 'TOAMASINA', 17, NULL, NULL),
(6, 'ARIVONIMAMO', 1, NULL, NULL),
(7, 'MIARINARIVO', 1, NULL, NULL),
(8, 'TSIROANIMANDIDY', 4, NULL, NULL),
(9, 'ANALAVORY', 1, NULL, NULL),
(10, 'MAHANORO', 17, NULL, NULL),
(11, 'VATOMANDRY', 17, NULL, NULL),
(12, 'TAOLAGNARO', 22, NULL, NULL),
(13, 'VANGAINDRANO', 10, NULL, NULL),
(14, 'MANAKARA', 9, NULL, NULL),
(15, 'VOHIPENO', 9, NULL, NULL),
(16, 'IRONDRO', 9, NULL, NULL),
(17, 'MAHABO', 19, NULL, NULL),
(18, 'BETROKA', 22, NULL, NULL),
(19, 'AMBOVOMBE ANDROY', 21, NULL, NULL),
(20, 'VAVATENINA', 18, NULL, NULL),
(21, 'IFANADIANA', 9, NULL, NULL),
(22, 'FARAFANGANA', 10, NULL, NULL),
(23, 'BEALANANA', 12, NULL, NULL),
(24, 'BEFANDRIANA-NORD', 12, NULL, NULL),
(25, 'MANDRITSARA', 12, NULL, NULL),
(26, 'MIANDRIVAZO', 19, NULL, NULL),
(27, 'MORONDAVA', 19, NULL, NULL),
(28, 'AMPARAFARAVOLA', 16, NULL, NULL),
(29, 'TANAMBE', 16, NULL, NULL),
(30, 'ANDAPA', 5, NULL, NULL),
(31, 'AMBONDROMAMY', 14, NULL, NULL),
(32, 'MAEVATANANA', 14, NULL, NULL),
(33, 'MAHAJANGA I', 13, NULL, NULL),
(34, 'FANDRIANA', 7, NULL, NULL),
(35, 'SARANDAHY', 7, NULL, NULL),
(36, 'FIANARANTSOA', 8, NULL, NULL),
(37, 'SOAVINANDRIANA', 1, NULL, NULL),
(38, 'FARATSIHO', 3, NULL, NULL),
(39, 'AMBATONDRAZAKA', 16, NULL, NULL),
(40, 'MAROVOAY', 13, NULL, NULL),
(56, 'FENERIVE-EST', 18, NULL, NULL),
(57, 'MANANARA-NORD', 18, NULL, NULL),
(58, 'MAROANTSETRA', 18, NULL, NULL),
(59, 'SAINTE-MARIE', 18, NULL, NULL),
(60, 'SOANIERANA IVONGO', 18, NULL, NULL),
(61, 'ANTALAHA', 5, NULL, NULL),
(62, 'SAMBAVA', 5, NULL, NULL),
(63, 'VOHEMAR', 5, NULL, NULL),
(64, 'AMBANJA', 6, NULL, NULL),
(65, 'AMBILOBE', 6, NULL, NULL),
(66, 'ANTSIRANANA', 6, NULL, NULL),
(67, 'NOSY-BE', 6, NULL, NULL),
(68, 'ANTSOHIHY', 12, NULL, NULL),
(69, 'MAMPIKONY', 12, NULL, NULL),
(70, 'PORT-BERGE', 12, NULL, NULL),
(71, 'AMBOSITRA', 7, NULL, NULL),
(72, 'ILAKAKA', 20, NULL, NULL),
(73, 'AMBALAVAO', 8, NULL, NULL),
(74, 'AMBOHIMAHASOA', 8, NULL, NULL),
(75, 'IHOSY', 11, NULL, NULL),
(76, 'AMBATOLAMPY', 3, NULL, NULL),
(77, 'ANTSIRABE', 3, NULL, NULL),
(78, 'MAINTIRANO', 15, NULL, NULL),
(79, 'MORAFENOBE', 15, NULL, NULL),
(80, 'MOROMBE', 20, NULL, NULL),
(81, 'TOLIARY', 20, NULL, NULL),
(82, 'MANANJARY', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ville_rns`
--

DROP TABLE IF EXISTS `ville_rns`;
CREATE TABLE IF NOT EXISTS `ville_rns` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ville_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la ville',
  `rn_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant de la route nationale',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_fk_rn_ville` (`ville_id`),
  KEY `i_fk_ville_rn` (`rn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville_rns`
--

INSERT INTO `ville_rns` (`id`, `ville_id`, `rn_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 2, NULL, NULL),
(8, 8, 2, NULL, NULL),
(10, 10, 3, NULL, NULL),
(11, 11, 3, NULL, NULL),
(12, 82, 4, NULL, NULL),
(13, 12, 5, NULL, NULL),
(14, 13, 5, NULL, NULL),
(15, 14, 5, NULL, NULL),
(16, 15, 5, NULL, NULL),
(17, 16, 5, NULL, NULL),
(18, 17, 6, NULL, NULL),
(19, 18, 7, NULL, NULL),
(20, 19, 7, NULL, NULL),
(21, 19, 8, NULL, NULL),
(22, 20, 9, NULL, NULL),
(23, 21, 10, NULL, NULL),
(24, 22, 11, NULL, NULL),
(25, 23, 12, NULL, NULL),
(26, 24, 13, NULL, NULL),
(27, 25, 13, NULL, NULL),
(28, 26, 14, NULL, NULL),
(29, 27, 15, NULL, NULL),
(30, 29, 16, NULL, NULL),
(31, 28, 16, NULL, NULL),
(32, 30, 17, NULL, NULL),
(33, 31, 18, NULL, NULL),
(34, 32, 18, NULL, NULL),
(35, 33, 18, NULL, NULL),
(36, 34, 19, NULL, NULL),
(37, 35, 19, NULL, NULL),
(38, 36, 20, NULL, NULL),
(39, 37, 21, NULL, NULL),
(40, 38, 21, NULL, NULL),
(41, 39, 22, NULL, NULL),
(42, 40, 22, NULL, NULL),
(43, 56, 23, NULL, NULL),
(44, 57, 23, NULL, NULL),
(45, 58, 23, NULL, NULL),
(46, 59, 23, NULL, NULL),
(47, 60, 23, NULL, NULL),
(48, 61, 24, NULL, NULL),
(49, 62, 25, NULL, NULL),
(50, 63, 25, NULL, NULL),
(51, 64, 26, NULL, NULL),
(52, 65, 26, NULL, NULL),
(53, 66, 26, NULL, NULL),
(54, 67, 26, NULL, NULL),
(55, 68, 26, NULL, NULL),
(56, 69, 26, NULL, NULL),
(57, 70, 26, NULL, NULL),
(58, 36, 27, NULL, NULL),
(59, 71, 27, NULL, NULL),
(60, 72, 27, NULL, NULL),
(61, 73, 27, NULL, NULL),
(62, 74, 27, NULL, NULL),
(63, 75, 27, NULL, NULL),
(64, 76, 27, NULL, NULL),
(65, 77, 27, NULL, NULL),
(66, 78, 28, NULL, NULL),
(67, 80, 29, NULL, NULL),
(68, 81, 29, NULL, NULL),
(69, 8, 30, NULL, NULL),
(70, 9, 2, NULL, NULL),
(71, 9, 21, NULL, NULL),
(72, 16, 10, NULL, NULL),
(73, 22, 5, NULL, NULL),
(74, 77, 14, NULL, NULL),
(75, 81, 27, NULL, NULL),
(76, 2, 27, NULL, NULL),
(77, 2, 18, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `camions`
--
ALTER TABLE `camions`
  ADD CONSTRAINT `i_fk_camion_transporteur` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `categorie_departs`
--
ALTER TABLE `categorie_departs`
  ADD CONSTRAINT `i_fk_arrivee` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `i_fk_depart` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Contraintes pour la table `categorie_rn_transporteurs`
--
ALTER TABLE `categorie_rn_transporteurs`
  ADD CONSTRAINT `i_fk_cat_rn_transporteur` FOREIGN KEY (`transporteur_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `i_fk_cat_trans_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_rn_trans_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `province_rns`
--
ALTER TABLE `province_rns`
  ADD CONSTRAINT `i_fk_province_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_rn_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `i_fk_reservation_arrivee` FOREIGN KEY (`arrivee_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_reservation_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `i_fk_reservation_depart` FOREIGN KEY (`depart_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `i_fk_reservation_transporteur` FOREIGN KEY (`transporteur_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `rn_transporteurs`
--
ALTER TABLE `rn_transporteurs`
  ADD CONSTRAINT `i_fk_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`),
  ADD CONSTRAINT `i_fk_transporteur` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `villes`
--
ALTER TABLE `villes`
  ADD CONSTRAINT `i_fk_ville_region` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Contraintes pour la table `ville_rns`
--
ALTER TABLE `ville_rns`
  ADD CONSTRAINT `i_fk_rn_ville` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `i_fk_ville_rn` FOREIGN KEY (`rn_id`) REFERENCES `rns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
