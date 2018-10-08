-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 08, 2018 at 07:33 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekoliko`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181007033629'),
('20181008053051');

-- --------------------------------------------------------

--
-- Table structure for table `sekoliko_horaire`
--

CREATE TABLE `sekoliko_horaire` (
  `id` int(11) NOT NULL,
  `hr_date_debut_saison` datetime DEFAULT NULL,
  `hr_date_fin_saison` datetime DEFAULT NULL,
  `hr_debut` time DEFAULT NULL,
  `hr_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sekoliko_horaire`
--

INSERT INTO `sekoliko_horaire` (`id`, `hr_date_debut_saison`, `hr_date_fin_saison`, `hr_debut`, `hr_fin`) VALUES
(1, '2018-10-12 00:00:00', '2018-10-12 00:00:00', '07:41:00', '07:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `sekoliko_jour_ferie`
--

CREATE TABLE `sekoliko_jour_ferie` (
  `id` int(11) NOT NULL,
  `jr_fer_nom` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jr_fer_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sekoliko_jour_ferie`
--

INSERT INTO `sekoliko_jour_ferie` (`id`, `jr_fer_nom`, `jr_fer_date`) VALUES
(1, 'Krisimasys', '2018-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `sekoliko_role`
--

CREATE TABLE `sekoliko_role` (
  `id` int(11) NOT NULL,
  `rl_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sekoliko_role`
--

INSERT INTO `sekoliko_role` (`id`, `rl_name`) VALUES
(1, 'Mpampianatra');

-- --------------------------------------------------------

--
-- Table structure for table `sekoliko_user`
--

CREATE TABLE `sekoliko_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `usr_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_date_create` datetime DEFAULT NULL,
  `usr_date_update` datetime DEFAULT NULL,
  `usr_phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_raison_sociale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#ff00ff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sekoliko_user`
--

INSERT INTO `sekoliko_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `usr_firstname`, `usr_lastname`, `usr_address`, `usr_date_create`, `usr_date_update`, `usr_phone`, `usr_photo`, `usr_raison_sociale`, `usr_color`) VALUES
(10, 'julien@techzara.mg', 'julien@techzara.mg', 'julien@techzara.mg', 'julien@techzara.mg', 1, NULL, '$2y$13$ttG0zf1MEFOgYkaBVwspGubh.29yqoD587M2NK/n.zW/4bONwM.Hm', '2018-10-07 20:28:42', NULL, NULL, 'a:1:{i:0;s:14:\"ROLE_PERSONNEL\";}', 'Jul', 'RAJERISON', 'Test', '2018-09-10 16:03:40', '2018-10-07 12:24:43', '0345987215', NULL, NULL, '#FF00FF'),
(15, 'jul@jul.fr', 'jul@jul.fr', 'jul@jul.fr', 'jul@jul.fr', 1, NULL, '$2y$13$R1.Jpa1Dk3.7tgc527XViOrynCY28AYqIkHHaQLtsztCaZemcrXnC', NULL, NULL, NULL, 'a:0:{}', 'qqqqwqw', 'qqwq', 'qwq', '2018-10-07 07:19:57', '2018-10-07 07:37:43', '0329473033', NULL, NULL, '#FFFFFF'),
(16, 'julien123@livenexx.fr', 'julien123@livenexx.fr', 'julien@julien.fr', 'julien@julien.fr', 1, NULL, '$2y$13$9rgRq3g.12OsagSwnpxf..oX4iOBpDrozmWaqR5cNQSCkCDBEcDEG', '2018-10-07 13:11:21', NULL, NULL, 'a:0:{}', 'Julien', 'Julien', 'julien', '2018-10-07 07:43:33', '2018-10-07 12:48:10', '0329473033', NULL, NULL, '#FFFFFF'),
(17, 'Julien', 'julien', 'julienrajerison5@gmail.com', 'julienrajerison5@gmail.com', 1, NULL, '$2y$13$lBE7yUpM4pt8QxG5PfqkjOFfbByH7yHOta.frmJ7VF.XPJKw9v3Ge', NULL, NULL, NULL, 'a:0:{}', 'Julien', 'RAJERISON', 'Antananarivo', '2018-10-08 07:27:03', NULL, '032 94 730 33', '/upload/user/555a46df6a04a4083a4849801e68ea0c.jpg', NULL, '#FFFF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sekoliko_horaire`
--
ALTER TABLE `sekoliko_horaire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekoliko_jour_ferie`
--
ALTER TABLE `sekoliko_jour_ferie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekoliko_role`
--
ALTER TABLE `sekoliko_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekoliko_user`
--
ALTER TABLE `sekoliko_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_canonical_UNIQUE` (`username_canonical`),
  ADD UNIQUE KEY `email_canonical_UNIQUE` (`email_canonical`),
  ADD UNIQUE KEY `confirmation_token_UNIQUE` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sekoliko_horaire`
--
ALTER TABLE `sekoliko_horaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sekoliko_jour_ferie`
--
ALTER TABLE `sekoliko_jour_ferie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sekoliko_role`
--
ALTER TABLE `sekoliko_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sekoliko_user`
--
ALTER TABLE `sekoliko_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
