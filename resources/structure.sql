-- MariaDB dump 10.19-12.0.2-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: zemit_core_refactored
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB
--
-- This schema has been refactored for consistency, integrity, and best practices.
-- Generation Date: 2025-10-07 22:55:07

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='-04:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- =================================================================
-- 1. CORE & USER MANAGEMENT TABLES
-- =================================================================
--

-- Table structure for table `user`
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `email` varchar(255) NOT NULL,
                        `password` varchar(255) DEFAULT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_tiomestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `email_UNIQUE` (`email`),
                        KEY `idx_email` (`email`),
                        CONSTRAINT `fk_user_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_user_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_user_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `profile`
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
                           `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                           `uuid` char(36) NOT NULL,
                           `user_id` BIGINT(1) unsigned NOT NULL,
                           `first_name` varchar(100) DEFAULT NULL,
                           `last_name` varchar(100) DEFAULT NULL,
                           `avatar_file_id` BIGINT(1) unsigned DEFAULT NULL,
                           `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                           `created_by` BIGINT(1) unsigned DEFAULT NULL,
                           `updated_at` datetime DEFAULT NULL,
                           `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                           `deleted_at` datetime DEFAULT NULL,
                           `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                           UNIQUE KEY `user_id_UNIQUE` (`user_id`),
                           CONSTRAINT `fk_profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                           CONSTRAINT `fk_profile_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_profile_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_profile_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `oauth2`
DROP TABLE IF EXISTS `oauth2`;
CREATE TABLE `oauth2` (
                          `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                          `uuid` char(36) NOT NULL,
                          `user_id` BIGINT(1) unsigned NOT NULL,
                          `provider` enum('google','microsoft') NOT NULL,
                          `provider_uuid` varchar(120) NOT NULL,
                          `access_token` varchar(255) NOT NULL,
                          `refresh_token` varchar(255) DEFAULT NULL,
                          `email` varchar(320) DEFAULT NULL,
                          `meta` JSON DEFAULT NULL,
                          `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                          `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                          `created_by` BIGINT(1) unsigned DEFAULT NULL,
                          `updated_at` datetime DEFAULT NULL,
                          `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                          `deleted_at` datetime DEFAULT NULL,
                          `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                          UNIQUE KEY `provider_uuid_UNIQUE` (`provider_uuid`),
                          KEY `idx_user_id` (`user_id`),
                          CONSTRAINT `fk_oauth2_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                          CONSTRAINT `fk_oauth2_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_oauth2_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_oauth2_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 2. ACL & GROUPING TABLES
-- =================================================================
--

-- Table structure for table `role`
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `key` varchar(50) NOT NULL COMMENT 'Programmatic identifier, e.g., "admin", "editor"',
                        `label` varchar(100) NOT NULL COMMENT 'Human-readable name, e.g., "Administrator"',
                        `position` int(1) unsigned NOT NULL DEFAULT 0,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `key_UNIQUE` (`key`),
                        CONSTRAINT `fk_role_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_role_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_role_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user_role`
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `user_id` BIGINT(1) unsigned NOT NULL,
                             `role_id` BIGINT(1) unsigned NOT NULL,
                             `position` int(1) unsigned NOT NULL DEFAULT 0,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             UNIQUE KEY `uq_user_role` (`user_id`, `role_id`),
                             KEY `idx_role_id` (`role_id`),
                             CONSTRAINT `fk_user_role_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_role_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_role_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_role_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `group`
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
                         `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                         `uuid` char(36) NOT NULL,
                         `key` varchar(50) NOT NULL,
                         `label` varchar(100) NOT NULL,
                         `position` int(1) unsigned NOT NULL DEFAULT 0,
                         `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         `created_by` BIGINT(1) unsigned DEFAULT NULL,
                         `updated_at` datetime DEFAULT NULL,
                         `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                         `deleted_at` datetime DEFAULT NULL,
                         `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                         UNIQUE KEY `key_UNIQUE` (`key`),
                         CONSTRAINT `fk_group_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_group_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_group_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user_group`
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
                              `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                              `uuid` char(36) NOT NULL,
                              `user_id` BIGINT(1) unsigned NOT NULL,
                              `group_id` BIGINT(1) unsigned NOT NULL,
                              `position` int(1) unsigned NOT NULL DEFAULT 0,
                              `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                              `created_by` BIGINT(1) unsigned DEFAULT NULL,
                              `updated_at` datetime DEFAULT NULL,
                              `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                              `deleted_at` datetime DEFAULT NULL,
                              `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                              UNIQUE KEY `uq_user_group` (`user_id`, `group_id`),
                              KEY `idx_group_id` (`group_id`),
                              CONSTRAINT `fk_user_group_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_user_group_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_user_group_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                              CONSTRAINT `fk_user_group_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                              CONSTRAINT `fk_user_group_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 3. WORKSPACE & HIERARCHY TABLES
-- =================================================================
--

-- Table structure for table `workspace`
DROP TABLE IF EXISTS `workspace`;
CREATE TABLE `workspace` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `label` varchar(60) NOT NULL,
                             `description` varchar(240) DEFAULT NULL,
                             `icon` varchar(64) DEFAULT NULL,
                             `color` char(9) DEFAULT NULL,
                             `status` enum('active','inactive') NOT NULL DEFAULT 'active',
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             CONSTRAINT `fk_workspace_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_workspace_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_workspace_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 4. VIRTUAL DATABASE TABLES (EAV MODEL)
-- =================================================================
--

-- Table structure for table `table`
DROP TABLE IF EXISTS `table`;
CREATE TABLE `table` (
                         `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                         `uuid` char(36) NOT NULL,
                         `workspace_id` BIGINT(1) unsigned NOT NULL,
                         `label` varchar(60) NOT NULL,
                         `description` varchar(240) DEFAULT NULL,
                         `icon` varchar(64) DEFAULT NULL,
                         `color` char(9) DEFAULT NULL,
                         `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         `created_by` BIGINT(1) unsigned DEFAULT NULL,
                         `updated_at` datetime DEFAULT NULL,
                         `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                         `deleted_at` datetime DEFAULT NULL,
                         `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                         KEY `idx_workspace_id` (`workspace_id`),
                         CONSTRAINT `fk_table_workspace_id` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                         CONSTRAINT `fk_table_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_table_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_table_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `column`
DROP TABLE IF EXISTS `column`;
CREATE TABLE `column` (
                          `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                          `uuid` char(36) NOT NULL,
                          `table_id` BIGINT(1) unsigned NOT NULL,
                          `label` varchar(60) NOT NULL,
                          `type` enum('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') NOT NULL DEFAULT 'singleLineText',
                          `description` varchar(120) DEFAULT NULL,
                          `options` JSON DEFAULT NULL COMMENT 'Stores options for select, formula, lookups etc.',
                          `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                          `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                          `created_by` BIGINT(1) unsigned DEFAULT NULL,
                          `updated_at` datetime DEFAULT NULL,
                          `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                          `deleted_at` datetime DEFAULT NULL,
                          `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                          KEY `idx_table_id` (`table_id`),
                          CONSTRAINT `fk_column_table_id` FOREIGN KEY (`table_id`) REFERENCES `table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                          CONSTRAINT `fk_column_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_column_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_column_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `record`
DROP TABLE IF EXISTS `record`;
CREATE TABLE `record` (
                          `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                          `uuid` char(36) NOT NULL,
                          `table_id` BIGINT(1) unsigned NOT NULL,
                          `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                          `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                          `created_by` BIGINT(1) unsigned DEFAULT NULL,
                          `updated_at` datetime DEFAULT NULL,
                          `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                          `deleted_at` datetime DEFAULT NULL,
                          `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                          KEY `idx_table_id` (`table_id`),
                          CONSTRAINT `fk_record_table_id` FOREIGN KEY (`table_id`) REFERENCES `table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                          CONSTRAINT `fk_record_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_record_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_record_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `data`
DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `record_id` BIGINT(1) unsigned NOT NULL,
                        `column_id` BIGINT(1) unsigned NOT NULL,
                        `value` mediumtext DEFAULT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `uq_cell` (`record_id`, `column_id`),
                        KEY `idx_column_id` (`column_id`),
                        FULLTEXT KEY `value_fulltext` (`value`),
                        CONSTRAINT `fk_data_record_id` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_data_column_id` FOREIGN KEY (`column_id`) REFERENCES `column` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_data_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_data_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_data_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- =================================================================
-- 5. CMS TABLES
-- =================================================================
--

-- Table structure for table `site`
DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `workspace_id` BIGINT(1) unsigned NOT NULL,
                        `label` varchar(60) NOT NULL,
                        `description` varchar(240) DEFAULT NULL,
                        `icon` varchar(64) DEFAULT NULL,
                        `color` char(9) DEFAULT NULL,
                        `status` enum('active','inactive') NOT NULL DEFAULT 'active',
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        KEY `idx_workspace_id` (`workspace_id`),
                        CONSTRAINT `fk_site_workspace_id` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_site_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_site_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_site_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `page`
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `site_id` BIGINT(1) unsigned NOT NULL,
                        `label` varchar(255) NOT NULL,
                        `description` varchar(255) DEFAULT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        KEY `idx_site_id` (`site_id`),
                        CONSTRAINT `fk_page_site_id` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_page_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_page_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_page_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `post`
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `page_id` BIGINT(1) unsigned NOT NULL,
                        `label` varchar(255) NOT NULL,
                        `description` varchar(255) DEFAULT NULL,
                        `content` MEDIUMTEXT DEFAULT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        KEY `idx_page_id` (`page_id`),
                        CONSTRAINT `fk_post_page_id` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_post_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_post_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_post_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `category`
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
                            `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                            `uuid` char(36) NOT NULL,
                            `site_id` BIGINT(1) unsigned NOT NULL,
                            `key` varchar(255) NOT NULL,
                            `label` varchar(255) NOT NULL,
                            `description` mediumtext DEFAULT NULL,
                            `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                            `created_by` BIGINT(1) unsigned DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                            UNIQUE KEY `uq_site_category_key` (`site_id`, `key`),
                            CONSTRAINT `fk_category_site_id` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT `fk_category_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                            CONSTRAINT `fk_category_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                            CONSTRAINT `fk_category_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `post_category`
DROP TABLE IF EXISTS `post_category`;
CREATE TABLE `post_category` (
                                 `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                 `uuid` char(36) NOT NULL,
                                 `post_id` BIGINT(1) unsigned NOT NULL,
                                 `category_id` BIGINT(1) unsigned NOT NULL,
                                 `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                 `updated_at` datetime DEFAULT NULL,
                                 `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                                 `deleted_at` datetime DEFAULT NULL,
                                 `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                 UNIQUE KEY `uq_post_category` (`post_id`, `category_id`),
                                 KEY `idx_category_id` (`category_id`),
                                 CONSTRAINT `fk_post_category_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `fk_post_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `fk_post_category_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                 CONSTRAINT `fk_post_category_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                 CONSTRAINT `fk_post_category_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 6. UTILITY & SUPPORTING TABLES
-- =================================================================
--

-- Table structure for table `lang`
DROP TABLE IF EXISTS `lang`;
CREATE TABLE `lang` (
                        `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `code` char(10) NOT NULL,
                        `label` varchar(255) NOT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `code_UNIQUE` (`code`),
                        CONSTRAINT `fk_lang_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_lang_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_lang_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `translate` (POLYMORPHIC MODEL)
DROP TABLE IF EXISTS `translate`;
CREATE TABLE `translate` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `lang_id` int(1) unsigned NOT NULL,
                             `translatable_table` varchar(60) NOT NULL COMMENT 'e.g., "post", "category"',
                             `translatable_id` BIGINT(1) unsigned NOT NULL COMMENT 'The ID of the record being translated',
                             `field` varchar(60) NOT NULL COMMENT 'e.g., "label", "content"',
                             `value` mediumtext DEFAULT NULL,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             UNIQUE KEY `uq_translation` (`lang_id`, `translatable_table`, `translatable_id`, `field`),
                             KEY `idx_translatable_lookup` (`translatable_table`, `translatable_id`),
                             CONSTRAINT `fk_translate_lang_id` FOREIGN KEY (`lang_id`) REFERENCES `lang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_translate_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_translate_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_translate_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `setting`
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
                           `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                           `uuid` char(36) NOT NULL,
                           `key` varchar(255) NOT NULL,
                           `label` varchar(255) DEFAULT NULL,
                           `value` text DEFAULT NULL,
                           `category` varchar(255) DEFAULT NULL,
                           `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                           `created_by` BIGINT(1) unsigned DEFAULT NULL,
                           `updated_at` datetime DEFAULT NULL,
                           `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                           `deleted_at` datetime DEFAULT NULL,
                           `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                           UNIQUE KEY `key_UNIQUE` (`key`),
                           KEY `idx_category` (`category`),
                           CONSTRAINT `fk_setting_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_setting_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_setting_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `file`
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `label` varchar(255) DEFAULT NULL COMMENT 'The original or display name of the file',
                        `category` enum('other','article','marker') NOT NULL DEFAULT 'other',
                        `path` varchar(255) NOT NULL COMMENT 'Relative path to the file in storage',
                        `mime_type` varchar(100) DEFAULT NULL COMMENT 'e.g., image/jpeg, application/pdf',
                        `extension` varchar(20) DEFAULT NULL COMMENT 'e.g., jpg, pdf',
                        `size` BIGINT(1) unsigned DEFAULT NULL COMMENT 'Size in bytes',
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        KEY `idx_category` (`category`),
                        KEY `idx_mime_type` (`mime_type`),
                        KEY `idx_extension` (`extension`),
                        CONSTRAINT `fk_file_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_file_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_file_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stores metadata for uploaded files';

-- Table structure for table `template`
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
                            `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                            `uuid` char(36) NOT NULL,
                            `key` varchar(120) NOT NULL,
                            `label` varchar(120) NOT NULL,
                            `subject` varchar(255) NOT NULL,
                            `content` mediumtext DEFAULT NULL,
                            `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                            `created_by` BIGINT(1) unsigned DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                            UNIQUE KEY `key_UNIQUE` (`key`),
                            CONSTRAINT `fk_template_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                            CONSTRAINT `fk_template_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                            CONSTRAINT `fk_template_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 7. SYSTEM, LOGGING & JOB TABLES
-- =================================================================
--

-- Table structure for table `audit`
DROP TABLE IF EXISTS `audit`;
CREATE TABLE `audit` (
                         `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                         `uuid` char(36) NOT NULL,
                         `model` varchar(255) NOT NULL COMMENT 'The class name of the model being changed',
                         `table` varchar(60) NOT NULL COMMENT 'The database table name',
                         `primary` BIGINT(1) unsigned NOT NULL COMMENT 'The primary key of the record being changed',
                         `event` enum('create','update','delete','restore','other') NOT NULL DEFAULT 'other',
                         `before` JSON DEFAULT NULL COMMENT 'JSON snapshot of data before the change',
                         `after` JSON DEFAULT NULL COMMENT 'JSON snapshot of data after the change',
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         `created_by` BIGINT(1) unsigned DEFAULT NULL COMMENT 'The user who performed the action',
                         `created_as` BIGINT(1) unsigned DEFAULT NULL COMMENT 'The user being impersonated (if any)',
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                         KEY `idx_audited_record` (`table`, `primary`),
                         KEY `idx_created_by` (`created_by`),
                         CONSTRAINT `fk_audit_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_audit_created_as` FOREIGN KEY (`created_as`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `audit_detail`
DROP TABLE IF EXISTS `audit_detail`;
CREATE TABLE `audit_detail` (
                                `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                `uuid` char(36) NOT NULL,
                                `audit_id` BIGINT(1) unsigned NOT NULL,
                                `column` varchar(60) NOT NULL,
                                `before` mediumtext DEFAULT NULL,
                                `after` mediumtext DEFAULT NULL,
                                `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                KEY `idx_audit_id` (`audit_id`),
                                CONSTRAINT `fk_audit_detail_audit_id` FOREIGN KEY (`audit_id`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_audit_detail_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `job`
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
                       `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                       `uuid` char(36) NOT NULL,
                       `label` varchar(100) DEFAULT NULL,
                       `task` char(100) NOT NULL,
                       `action` char(100) NOT NULL,
                       `params` JSON DEFAULT NULL,
                       `status` enum('new','progress','failed','finished') NOT NULL DEFAULT 'new',
                       `result` JSON DEFAULT NULL,
                       `priority` int(1) unsigned NOT NULL DEFAULT 0,
                       `run_at` datetime DEFAULT NULL,
                       `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                       `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                       `created_by` BIGINT(1) unsigned DEFAULT NULL,
                       `updated_at` datetime DEFAULT NULL,
                       `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                       `deleted_at` datetime DEFAULT NULL,
                       `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                       PRIMARY KEY (`id`),
                       UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                       KEY `idx_status_priority` (`status`, `priority`),
                       CONSTRAINT `fk_job_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                       CONSTRAINT `fk_job_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                       CONSTRAINT `fk_job_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `log`
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
                       `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                       `uuid` char(36) NOT NULL,
                       `level` int(1) NOT NULL DEFAULT 0,
                       `type` enum('critical','alert','error','warning','notice','info','debug','emergency','other') NOT NULL DEFAULT 'other',
                       `message` text NOT NULL,
                       `context` JSON DEFAULT NULL,
                       `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                       `created_by` BIGINT(1) unsigned DEFAULT NULL,
                       PRIMARY KEY (`id`),
                       UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                       KEY `idx_type_level` (`type`, `level`),
                       CONSTRAINT `fk_log_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `session`
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
                           `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                           `uuid` char(36) NOT NULL,
                           `user_id` BIGINT(1) unsigned DEFAULT NULL,
                           `as_user_id` BIGINT(1) unsigned DEFAULT NULL,
                           `token` varchar(128) NOT NULL,
                           `jwt` text DEFAULT NULL,
                           `meta` JSON DEFAULT NULL,
                           `expires_at` datetime NOT NULL,
                           `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                           UNIQUE KEY `token_UNIQUE` (`token`),
                           KEY `idx_user_id` (`user_id`),
                           KEY `idx_expires_at` (`expires_at`),
                           CONSTRAINT `fk_session_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                           CONSTRAINT `fk_session_as_user_id` FOREIGN KEY (`as_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `type`
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `key` varchar(50) NOT NULL,
                        `label` varchar(100) NOT NULL,
                        `position` int(1) unsigned NOT NULL DEFAULT 0,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `key_UNIQUE` (`key`),
                        CONSTRAINT `fk_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_type_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_type_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `feature`
DROP TABLE IF EXISTS `feature`;
CREATE TABLE `feature` (
                           `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                           `uuid` char(36) NOT NULL,
                           `key` varchar(50) NOT NULL,
                           `label` varchar(100) NOT NULL,
                           `position` int(1) unsigned NOT NULL DEFAULT 0,
                           `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                           `created_by` BIGINT(1) unsigned DEFAULT NULL,
                           `updated_at` datetime DEFAULT NULL,
                           `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                           `deleted_at` datetime DEFAULT NULL,
                           `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                           UNIQUE KEY `key_UNIQUE` (`key`),
                           CONSTRAINT `fk_feature_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_feature_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                           CONSTRAINT `fk_feature_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user_type`
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `user_id` BIGINT(1) unsigned NOT NULL,
                             `type_id` BIGINT(1) unsigned NOT NULL,
                             `position` int(1) unsigned NOT NULL DEFAULT 0,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             UNIQUE KEY `uq_user_type` (`user_id`, `type_id`),
                             KEY `idx_type_id` (`type_id`),
                             CONSTRAINT `fk_user_type_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_type_type_id` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_type_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_user_type_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user_feature`
DROP TABLE IF EXISTS `user_feature`;
CREATE TABLE `user_feature` (
                                `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                `uuid` char(36) NOT NULL,
                                `user_id` BIGINT(1) unsigned NOT NULL,
                                `feature_id` BIGINT(1) unsigned NOT NULL,
                                `position` int(1) unsigned NOT NULL DEFAULT 0,
                                `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                `updated_at` datetime DEFAULT NULL,
                                `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                                `deleted_at` datetime DEFAULT NULL,
                                `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                UNIQUE KEY `uq_user_feature` (`user_id`, `feature_id`),
                                KEY `idx_feature_id` (`feature_id`),
                                CONSTRAINT `fk_user_feature_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_user_feature_feature_id` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_user_feature_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                CONSTRAINT `fk_user_feature_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                CONSTRAINT `fk_user_feature_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `role_feature`
DROP TABLE IF EXISTS `role_feature`;
CREATE TABLE `role_feature` (
                                `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                `uuid` char(36) NOT NULL,
                                `role_id` BIGINT(1) unsigned NOT NULL,
                                `feature_id` BIGINT(1) unsigned NOT NULL,
                                `position` int(1) unsigned NOT NULL DEFAULT 0,
                                `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                `updated_at` datetime DEFAULT NULL,
                                `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                                `deleted_at` datetime DEFAULT NULL,
                                `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                UNIQUE KEY `uq_role_feature` (`role_id`, `feature_id`),
                                KEY `idx_feature_id` (`feature_id`),
                                CONSTRAINT `fk_role_feature_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_role_feature_feature_id` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_role_feature_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                CONSTRAINT `fk_role_feature_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                CONSTRAINT `fk_role_feature_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `backup`
DROP TABLE IF EXISTS `backup`;
CREATE TABLE `backup` (
                          `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                          `uuid` char(36) NOT NULL,
                          `label` varchar(120) NOT NULL,
                          `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                          `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                          `created_by` BIGINT(1) unsigned DEFAULT NULL,
                          `updated_at` datetime DEFAULT NULL,
                          `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                          `deleted_at` datetime DEFAULT NULL,
                          `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                          CONSTRAINT `fk_backup_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_backup_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                          CONSTRAINT `fk_backup_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `email`
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
                         `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                         `uuid` char(36) NOT NULL,
                         `template_id` BIGINT(1) unsigned DEFAULT NULL,
                         `from` varchar(255) NOT NULL,
                         `to` text NOT NULL,
                         `cc` text DEFAULT NULL,
                         `bcc` text DEFAULT NULL,
                         `subject` varchar(255) NOT NULL,
                         `content` mediumtext NOT NULL,
                         `meta` JSON DEFAULT NULL,
                         `sent_at` datetime DEFAULT NULL,
                         `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         `created_by` BIGINT(1) unsigned DEFAULT NULL,
                         `updated_at` datetime DEFAULT NULL,
                         `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                         `deleted_at` datetime DEFAULT NULL,
                         `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                         KEY `idx_template_id` (`template_id`),
                         CONSTRAINT `fk_email_template_id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_email_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_email_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_email_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `email_file`
DROP TABLE IF EXISTS `email_file`;
CREATE TABLE `email_file` (
                              `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                              `uuid` char(36) NOT NULL,
                              `email_id` BIGINT(1) unsigned NOT NULL,
                              `file_id` BIGINT(1) unsigned NOT NULL,
                              `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                              `created_by` BIGINT(1) unsigned DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                              UNIQUE KEY `uq_email_file` (`email_id`, `file_id`),
                              KEY `idx_file_id` (`file_id`),
                              CONSTRAINT `fk_email_file_email_id` FOREIGN KEY (`email_id`) REFERENCES `email` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_email_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_email_file_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `job_scheduler`
DROP TABLE IF EXISTS `job_scheduler`;
CREATE TABLE `job_scheduler` (
                                 `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                 `uuid` char(36) NOT NULL,
                                 `key` char(100) NOT NULL,
                                 `label` varchar(100) NOT NULL,
                                 `task` char(100) NOT NULL,
                                 `action` char(100) NOT NULL,
                                 `params` JSON DEFAULT NULL,
                                 `frequency` enum('manually','minutely','hourly','daily','weekdays','weekends','weekly','bi-weekly','monthly','bi-monthly','quarterly','semi-annually','yearly') NOT NULL DEFAULT 'manually',
                                 `starting_at` datetime NOT NULL,
                                 `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                 `updated_at` datetime DEFAULT NULL,
                                 `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                                 `deleted_at` datetime DEFAULT NULL,
                                 `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                 UNIQUE KEY `key_UNIQUE` (`key`),
                                 CONSTRAINT `fk_job_scheduler_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                 CONSTRAINT `fk_job_scheduler_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                                 CONSTRAINT `fk_job_scheduler_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `menu`
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `parent_id` BIGINT(1) unsigned DEFAULT NULL,
                        `key` varchar(255) NOT NULL,
                        `label` varchar(255) NOT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `key_UNIQUE` (`key`),
                        KEY `idx_parent_id` (`parent_id`),
                        CONSTRAINT `fk_menu_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_menu_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_menu_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_menu_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `role_role` (for role hierarchies)
DROP TABLE IF EXISTS `role_role`;
CREATE TABLE `role_role` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `parent_id` BIGINT(1) unsigned NOT NULL,
                             `child_id` BIGINT(1) unsigned NOT NULL,
                             `position` int(1) unsigned NOT NULL DEFAULT 0,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             UNIQUE KEY `uq_role_hierarchy` (`parent_id`, `child_id`),
                             KEY `idx_child_id` (`child_id`),
                             CONSTRAINT `fk_role_role_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_role_role_child_id` FOREIGN KEY (`child_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_role_role_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `group_feature`
DROP TABLE IF EXISTS `group_feature`;
CREATE TABLE `group_feature` (
                                 `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                 `uuid` char(36) NOT NULL,
                                 `group_id` BIGINT(1) unsigned NOT NULL,
                                 `feature_id` BIGINT(1) unsigned NOT NULL,
                                 `position` int(1) unsigned NOT NULL DEFAULT 0,
                                 `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                 UNIQUE KEY `uq_group_feature` (`group_id`, `feature_id`),
                                 KEY `idx_feature_id` (`feature_id`),
                                 CONSTRAINT `fk_group_feature_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `fk_group_feature_feature_id` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `fk_group_feature_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `workspace_lang`
DROP TABLE IF EXISTS `workspace_lang`;
CREATE TABLE `workspace_lang` (
                                  `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                  `uuid` char(36) NOT NULL,
                                  `workspace_id` BIGINT(1) unsigned NOT NULL,
                                  `lang_id` int(1) unsigned NOT NULL,
                                  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                  `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                  UNIQUE KEY `uq_workspace_lang` (`workspace_id`, `lang_id`),
                                  KEY `idx_lang_id` (`lang_id`),
                                  CONSTRAINT `fk_workspace_lang_workspace_id` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                  CONSTRAINT `fk_workspace_lang_lang_id` FOREIGN KEY (`lang_id`) REFERENCES `lang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                  CONSTRAINT `fk_workspace_lang_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `site_lang`
DROP TABLE IF EXISTS `site_lang`;
CREATE TABLE `site_lang` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `site_id` BIGINT(1) unsigned NOT NULL,
                             `lang_id` int(1) unsigned NOT NULL,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             UNIQUE KEY `uq_site_lang` (`site_id`, `lang_id`),
                             KEY `idx_lang_id` (`lang_id`),
                             CONSTRAINT `fk_site_lang_site_id` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_site_lang_lang_id` FOREIGN KEY (`lang_id`) REFERENCES `lang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_site_lang_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `meta` (Polymorphic Key-Value)
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `key` varchar(255) NOT NULL,
                        `value` mediumtext DEFAULT NULL,
                        `meta_table` varchar(60) NOT NULL COMMENT 'e.g., "post", "user", "site"',
                        `meta_id` BIGINT(1) unsigned NOT NULL COMMENT 'The ID of the record this meta belongs to',
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `uq_meta` (`meta_table`, `meta_id`, `key`),
                        CONSTRAINT `fk_meta_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_meta_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_meta_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `flag` (Feature Flags, etc.)
DROP TABLE IF EXISTS `flag`;
CREATE TABLE `flag` (
                        `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                        `uuid` char(36) NOT NULL,
                        `site_id` BIGINT(1) unsigned NOT NULL,
                        `key` varchar(255) NOT NULL,
                        `label` varchar(255) NOT NULL,
                        `value` tinyint(1) unsigned NOT NULL DEFAULT 1,
                        `meta` JSON DEFAULT NULL,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                        `created_by` BIGINT(1) unsigned DEFAULT NULL,
                        `updated_at` datetime DEFAULT NULL,
                        `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                        `deleted_at` datetime DEFAULT NULL,
                        `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                        UNIQUE KEY `uq_site_flag` (`site_id`, `key`),
                        CONSTRAINT `fk_flag_site_id` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk_flag_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_flag_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `fk_flag_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `validator`
DROP TABLE IF EXISTS `validator`;
CREATE TABLE `validator` (
                             `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                             `uuid` char(36) NOT NULL,
                             `column_id` BIGINT(1) unsigned NOT NULL,
                             `key` varchar(255) NOT NULL,
                             `label` varchar(255) NOT NULL,
                             `type` enum('text','alphanum','min','max','email','password','number','decimal','int') NOT NULL DEFAULT 'text',
                             `params` JSON DEFAULT NULL,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                             `created_by` BIGINT(1) unsigned DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `updated_by` BIGINT(1) unsigned DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` BIGINT(1) unsigned DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                             KEY `idx_column_id` (`column_id`),
                             CONSTRAINT `fk_validator_column_id` FOREIGN KEY (`column_id`) REFERENCES `column` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                             CONSTRAINT `fk_validator_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_validator_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                             CONSTRAINT `fk_validator_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `file_relation` (Polymorphic)
DROP TABLE IF EXISTS `file_relation`;
CREATE TABLE `file_relation` (
                                 `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                                 `uuid` char(36) NOT NULL,
                                 `file_id` BIGINT(1) unsigned NOT NULL,
                                 `relation_table` varchar(60) NOT NULL COMMENT 'e.g., "post", "user_profile"',
                                 `relation_id` BIGINT(1) unsigned NOT NULL COMMENT 'The ID of the record the file is related to',
                                 `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 `created_by` BIGINT(1) unsigned DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                                 UNIQUE KEY `uq_file_relation` (`file_id`, `relation_table`, `relation_id`),
                                 KEY `idx_relation_lookup` (`relation_table`, `relation_id`),
                                 CONSTRAINT `fk_file_relation_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `fk_file_relation_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `group_role`
DROP TABLE IF EXISTS `group_role`;
CREATE TABLE `group_role` (
                              `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                              `uuid` char(36) NOT NULL,
                              `group_id` BIGINT(1) unsigned NOT NULL,
                              `role_id` BIGINT(1) unsigned NOT NULL,
                              `position` int(1) unsigned NOT NULL DEFAULT 0,
                              `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                              `created_by` BIGINT(1) unsigned DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                              UNIQUE KEY `uq_group_role` (`group_id`, `role_id`),
                              KEY `idx_role_id` (`role_id`),
                              CONSTRAINT `fk_group_role_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_group_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_group_role_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `group_type`
DROP TABLE IF EXISTS `group_type`;
CREATE TABLE `group_type` (
                              `id` BIGINT(1) unsigned NOT NULL AUTO_INCREMENT,
                              `uuid` char(36) NOT NULL,
                              `group_id` BIGINT(1) unsigned NOT NULL,
                              `type_id` BIGINT(1) unsigned NOT NULL,
                              `position` int(1) unsigned NOT NULL DEFAULT 0,
                              `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                              `created_by` BIGINT(1) unsigned DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `uuid_UNIQUE` (`uuid`),
                              UNIQUE KEY `uq_group_type` (`group_id`, `type_id`),
                              KEY `idx_type_id` (`type_id`),
                              CONSTRAINT `fk_group_type_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_group_type_type_id` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT `fk_group_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- =================================================================
-- 8. FRAMEWORK & SYSTEM TABLES
-- =================================================================
--

-- Table structure for table `phalcon_migrations`
-- This table is managed by the Phalcon framework and should generally be left untouched.
DROP TABLE IF EXISTS `phalcon_migrations`;
CREATE TABLE `phalcon_migrations` (
                                      `version` varchar(255) NOT NULL,
                                      `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
                                      `end_time` timestamp NOT NULL DEFAULT current_timestamp(),
                                      PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-07 22:55:07
