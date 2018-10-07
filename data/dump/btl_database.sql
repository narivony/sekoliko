-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 07 sep. 2018 à 13:03
-- Version du serveur :  5.7.21
-- Version de PHP :  7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `livenexx_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_category_post`
--

DROP TABLE IF EXISTS `sekoliko_category_post`;
CREATE TABLE IF NOT EXISTS `sekoliko_category_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_category_post_translation`
--

DROP TABLE IF EXISTS `sekoliko_category_post_translation`;
CREATE TABLE IF NOT EXISTS `sekoliko_category_post_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `cat_pst_libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sekoliko_category_post_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_F974C0B42C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_cms`
--

DROP TABLE IF EXISTS `sekoliko_cms`;
CREATE TABLE IF NOT EXISTS `sekoliko_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_seo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_18451D02B5766938` (`sekoliko_seo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_cms_translation`
--

DROP TABLE IF EXISTS `sekoliko_cms_translation`;
CREATE TABLE IF NOT EXISTS `sekoliko_cms_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `cmst_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmst_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cmst_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C06CC4F86A085A0` (`cmst_slug`),
  UNIQUE KEY `sekoliko_cms_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_C06CC4F2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_email_newsletter`
--

DROP TABLE IF EXISTS `sekoliko_email_newsletter`;
CREATE TABLE IF NOT EXISTS `sekoliko_email_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nws_email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nws_subscribed` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_68C3CF2CD5D52DEC` (`nws_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_fonction`
--

DROP TABLE IF EXISTS `sekoliko_fonction`;
CREATE TABLE IF NOT EXISTS `sekoliko_fonction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_pole_id` int(11) DEFAULT NULL,
  `fct_libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fct_desc` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_BF4A038B6D6738BA` (`sekoliko_pole_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_message_newsletter`
--

DROP TABLE IF EXISTS `sekoliko_message_newsletter`;
CREATE TABLE IF NOT EXISTS `sekoliko_message_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_message_newsletter_translation`
--

DROP TABLE IF EXISTS `sekoliko_message_newsletter_translation`;
CREATE TABLE IF NOT EXISTS `sekoliko_message_newsletter_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `message_newsletter_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_newsletter_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sekoliko_message_newsletter_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_50D182022C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_pole`
--

DROP TABLE IF EXISTS `sekoliko_pole`;
CREATE TABLE IF NOT EXISTS `sekoliko_pole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pl_libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_desc` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_post`
--

DROP TABLE IF EXISTS `sekoliko_post`;
CREATE TABLE IF NOT EXISTS `sekoliko_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_usr_id` int(11) DEFAULT NULL,
  `sekoliko_cat_pst_id` int(11) DEFAULT NULL,
  `sekoliko_seo_id` int(11) DEFAULT NULL,
  `pst_status` tinyint(1) DEFAULT NULL,
  `pst_image_url` tinytext COLLATE utf8_unicode_ci,
  `pst_created_at` datetime DEFAULT NULL,
  `pst_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2A545286B5766938` (`sekoliko_seo_id`),
  KEY `IDX_2A5452862EFC6745` (`sekoliko_usr_id`),
  KEY `IDX_2A5452864164A83F` (`sekoliko_cat_pst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_post_translation`
--

DROP TABLE IF EXISTS `sekoliko_post_translation`;
CREATE TABLE IF NOT EXISTS `sekoliko_post_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `pst_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pst_content` longtext COLLATE utf8_unicode_ci,
  `pst_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E2DC777B87DBD7FC` (`pst_slug`),
  UNIQUE KEY `sekoliko_post_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_E2DC777B2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_prj_lot_tch_statut`
--

DROP TABLE IF EXISTS `sekoliko_prj_lot_tch_statut`;
CREATE TABLE IF NOT EXISTS `sekoliko_prj_lot_tch_statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_lot_tch_st_libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet`
--

DROP TABLE IF EXISTS `sekoliko_projet`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_projet_type_id` int(11) DEFAULT NULL,
  `prj_nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prj_abrv` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prj_date_obtention` datetime DEFAULT NULL,
  `prj_date_ajout` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_72802817A68A8550` (`sekoliko_projet_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet_lot`
--

DROP TABLE IF EXISTS `sekoliko_projet_lot`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet_lot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_projet_lot_statut_id` int(11) DEFAULT NULL,
  `sekoliko_projet_id` int(11) DEFAULT NULL,
  `prj_lot_nom` tinytext COLLATE utf8_unicode_ci,
  `prj_lot_desc` tinytext COLLATE utf8_unicode_ci,
  `prj_lot_date_ajout` datetime DEFAULT NULL,
  `prj_lot_date_debut` datetime DEFAULT NULL,
  `prj_lot_date_prevu_livraison` datetime DEFAULT NULL,
  `prj_lot_date_livraison` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_38F2C0C454EDCC88` (`sekoliko_projet_lot_statut_id`),
  KEY `IDX_38F2C0C4CFCD5D3D` (`sekoliko_projet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet_lot_equipe`
--

DROP TABLE IF EXISTS `sekoliko_projet_lot_equipe`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet_lot_equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_user_id` int(11) DEFAULT NULL,
  `sekoliko_projet_lot_id` int(11) DEFAULT NULL,
  `prj_lot_eqp_nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prj_lot_eqp_date_debut` datetime DEFAULT NULL,
  `prj_lot_eqp_date_fin` datetime DEFAULT NULL,
  `prj_lot_eqp_is_responsable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F3AB2BC98B95D8AA` (`sekoliko_user_id`),
  KEY `IDX_F3AB2BC968AEBFEA` (`sekoliko_projet_lot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet_lot_statut`
--

DROP TABLE IF EXISTS `sekoliko_projet_lot_statut`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet_lot_statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_lot_st_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet_lot_tache`
--

DROP TABLE IF EXISTS `sekoliko_projet_lot_tache`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet_lot_tache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_prj_lot_tch_id` int(11) DEFAULT NULL,
  `sekoliko_user_id` int(11) DEFAULT NULL,
  `sekoliko_prj_lot_id` int(11) DEFAULT NULL,
  `sekoliko_prj_lot_tch_statut_id` int(11) DEFAULT NULL,
  `prj_lot_tch_libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prj_lot_tch_date_attribution` datetime DEFAULT NULL,
  `prj_lot_tch_date_debut` datetime DEFAULT NULL,
  `prj_lot_tch_date_fin` datetime DEFAULT NULL,
  `prj_lot_tch_estimation_resp` double DEFAULT NULL,
  `prj_lot_tch_estimation_pers` double DEFAULT NULL,
  `prj_lot_tch_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC41294B586D74F` (`sekoliko_prj_lot_tch_id`),
  KEY `IDX_7CC412948B95D8AA` (`sekoliko_user_id`),
  KEY `IDX_7CC41294A085771A` (`sekoliko_prj_lot_id`),
  KEY `IDX_7CC412948056B8F7` (`sekoliko_prj_lot_tch_statut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_projet_type`
--

DROP TABLE IF EXISTS `sekoliko_projet_type`;
CREATE TABLE IF NOT EXISTS `sekoliko_projet_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_tp_libelle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_role`
--

DROP TABLE IF EXISTS `sekoliko_role`;
CREATE TABLE IF NOT EXISTS `sekoliko_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rl_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_seo`
--

DROP TABLE IF EXISTS `sekoliko_seo`;
CREATE TABLE IF NOT EXISTS `sekoliko_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` longtext COLLATE utf8_unicode_ci,
  `seo_image_url` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_user`
--

DROP TABLE IF EXISTS `sekoliko_user`;
CREATE TABLE IF NOT EXISTS `sekoliko_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sekoliko_role_id` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_canonical_UNIQUE` (`username_canonical`),
  UNIQUE KEY `email_canonical_UNIQUE` (`email_canonical`),
  UNIQUE KEY `confirmation_token_UNIQUE` (`confirmation_token`),
  KEY `IDX_FD4DE842FAF82993` (`sekoliko_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `sekoliko_user`
--

INSERT INTO `sekoliko_user` (`id`, `sekoliko_role_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `usr_firstname`, `usr_lastname`, `usr_address`, `usr_date_create`, `usr_date_update`, `usr_phone`, `usr_photo`, `usr_raison_sociale`) VALUES
(1, 1, 'superadmin@livenexx-management.fr', 'superadmin@livenexx-management.fr', 'superadmin@livenexx-management.fr', 'superadmin@livenexx-management.fr', 1, NULL, '$2y$13$ZBd2iePhzWUzRsURVaa42u6mzbaMeyLRx.3lG4ZAgGEYpGCY/66GO', NULL, NULL, NULL, 'a:1:{i:0;s:15:\"ROLE_SUPERADMIN\";}', NULL, NULL, NULL, '2018-09-07 12:59:23', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sekoliko_user_fonction`
--

DROP TABLE IF EXISTS `sekoliko_user_fonction`;
CREATE TABLE IF NOT EXISTS `sekoliko_user_fonction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `sekoliko_fonction_id` int(11) DEFAULT NULL,
  `usr_fct_date_debut` datetime DEFAULT NULL,
  `usr_fct_date_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B419BF6A76ED395` (`user_id`),
  KEY `IDX_B419BF63605CAA3` (`sekoliko_fonction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180907125658');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sekoliko_category_post_translation`
--
ALTER TABLE `sekoliko_category_post_translation`
  ADD CONSTRAINT `FK_F974C0B42C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `sekoliko_category_post` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_cms`
--
ALTER TABLE `sekoliko_cms`
  ADD CONSTRAINT `FK_18451D02B5766938` FOREIGN KEY (`sekoliko_seo_id`) REFERENCES `sekoliko_seo` (`id`);

--
-- Contraintes pour la table `sekoliko_cms_translation`
--
ALTER TABLE `sekoliko_cms_translation`
  ADD CONSTRAINT `FK_C06CC4F2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `sekoliko_cms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_fonction`
--
ALTER TABLE `sekoliko_fonction`
  ADD CONSTRAINT `FK_BF4A038B6D6738BA` FOREIGN KEY (`sekoliko_pole_id`) REFERENCES `sekoliko_pole` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_message_newsletter_translation`
--
ALTER TABLE `sekoliko_message_newsletter_translation`
  ADD CONSTRAINT `FK_50D182022C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `sekoliko_message_newsletter` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_post`
--
ALTER TABLE `sekoliko_post`
  ADD CONSTRAINT `FK_2A5452862EFC6745` FOREIGN KEY (`sekoliko_usr_id`) REFERENCES `sekoliko_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2A5452864164A83F` FOREIGN KEY (`sekoliko_cat_pst_id`) REFERENCES `sekoliko_category_post` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_2A545286B5766938` FOREIGN KEY (`sekoliko_seo_id`) REFERENCES `sekoliko_seo` (`id`);

--
-- Contraintes pour la table `sekoliko_post_translation`
--
ALTER TABLE `sekoliko_post_translation`
  ADD CONSTRAINT `FK_E2DC777B2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `sekoliko_post` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_projet`
--
ALTER TABLE `sekoliko_projet`
  ADD CONSTRAINT `FK_72802817A68A8550` FOREIGN KEY (`sekoliko_projet_type_id`) REFERENCES `sekoliko_projet_type` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `sekoliko_projet_lot`
--
ALTER TABLE `sekoliko_projet_lot`
  ADD CONSTRAINT `FK_38F2C0C454EDCC88` FOREIGN KEY (`sekoliko_projet_lot_statut_id`) REFERENCES `sekoliko_projet_lot_statut` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_38F2C0C4CFCD5D3D` FOREIGN KEY (`sekoliko_projet_id`) REFERENCES `sekoliko_projet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_projet_lot_equipe`
--
ALTER TABLE `sekoliko_projet_lot_equipe`
  ADD CONSTRAINT `FK_F3AB2BC968AEBFEA` FOREIGN KEY (`sekoliko_projet_lot_id`) REFERENCES `sekoliko_projet_lot` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_F3AB2BC98B95D8AA` FOREIGN KEY (`sekoliko_user_id`) REFERENCES `sekoliko_user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_projet_lot_tache`
--
ALTER TABLE `sekoliko_projet_lot_tache`
  ADD CONSTRAINT `FK_7CC412948056B8F7` FOREIGN KEY (`sekoliko_prj_lot_tch_statut_id`) REFERENCES `sekoliko_prj_lot_tch_statut` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_7CC412948B95D8AA` FOREIGN KEY (`sekoliko_user_id`) REFERENCES `sekoliko_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7CC41294A085771A` FOREIGN KEY (`sekoliko_prj_lot_id`) REFERENCES `sekoliko_projet_lot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7CC41294B586D74F` FOREIGN KEY (`sekoliko_prj_lot_tch_id`) REFERENCES `sekoliko_projet_lot_tache` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sekoliko_user`
--
ALTER TABLE `sekoliko_user`
  ADD CONSTRAINT `FK_FD4DE842FAF82993` FOREIGN KEY (`sekoliko_role_id`) REFERENCES `sekoliko_role` (`id`);

--
-- Contraintes pour la table `sekoliko_user_fonction`
--
ALTER TABLE `sekoliko_user_fonction`
  ADD CONSTRAINT `FK_B419BF63605CAA3` FOREIGN KEY (`sekoliko_fonction_id`) REFERENCES `sekoliko_fonction` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B419BF6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `sekoliko_user` (`id`) ON DELETE CASCADE;
COMMIT;
