-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2024 at 02:21 PM
-- Server version: 10.6.18-MariaDB-cll-lve-log
-- PHP Version: 8.1.28
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

CREATE PROCEDURE DropAllTablesExceptUsers()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE tableName VARCHAR(255);
    DECLARE cur CURSOR FOR 
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE() AND table_name <> 'users';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO tableName;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET @query = CONCAT('DROP TABLE ', tableName);
        PREPARE stmt FROM @query;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END LOOP;

    CLOSE cur;
END $$

DELIMITER ;

CALL DropAllTablesExceptUsers();
DROP PROCEDURE IF EXISTS DropAllTablesExceptUsers;


-- Add the Missiong columns into the user table.
ALTER TABLE `users`
ADD COLUMN `two_factor_confirmed_at` TIMESTAMP NULL AFTER `two_factor_recovery_codes`,
ADD COLUMN `received_signup_bonus` TINYINT NULL DEFAULT 1 AFTER `ref_bonus`,
ADD COLUMN `withdrawal_otp` VARCHAR(10) NULL AFTER `trade_mode`,
ADD COLUMN `withdrawal_otp_expired_at` DATETIME NULL AFTER `withdrawal_otp`,
ADD COLUMN `can_deposit` TINYINT NULL DEFAULT 1 AFTER `trade_mode`,
ADD COLUMN `can_withdraw` TINYINT NULL DEFAULT 1 AFTER `can_deposit`,
ADD COLUMN `email_preference` JSON NULL AFTER `trade_mode`,
ADD COLUMN `is_admin` TINYINT NULL DEFAULT 0 AFTER `email_preference`,
ADD COLUMN `token_2fa_expiry` DATETIME NULL AFTER `trade_mode`,
ADD COLUMN `enable_2fa` TINYINT NULL DEFAULT 0 AFTER `trade_mode`,
ADD COLUMN `admin_two_factor_code` VARCHAR(10) NULL AFTER `trade_mode`,
ADD COLUMN `pass_two_factor` TINYINT NULL DEFAULT 0 AFTER `trade_mode`,
ADD COLUMN `timezone` VARCHAR(100) NULL AFTER `trade_mode`,
CHANGE COLUMN `cstatus` `customer_status` VARCHAR(190),
CHANGE COLUMN `assign_to` `assigned_to` VARCHAR(190),
CHANGE COLUMN `dob` `date_of_birth` DATE,
CHANGE COLUMN `phone` `phone_number` VARCHAR(190),
CHANGE COLUMN `ref_by` `reffered_by` VARCHAR(190),
CHANGE COLUMN `trade_mode` `trade_mode` TINYINT NULL DEFAULT 1,
CHANGE COLUMN `ref_link` `refferal_link` VARCHAR(190);

UPDATE `users`
SET trade_mode = 1;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brlyawno_v6db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(191) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(191) DEFAULT NULL,
  `event` varchar(191) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `binance_transactions`
--

CREATE TABLE `binance_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prepay_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('e-pandapay_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:115:{i:0;a:3:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:11:\"create user\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";s:1:\"3\";s:1:\"b\";s:9:\"edit user\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";s:1:\"4\";s:1:\"b\";s:11:\"delete user\";s:1:\"c\";s:3:\"web\";}i:4;a:4:{s:1:\"a\";s:1:\"5\";s:1:\"b\";s:22:\"create investment plan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:5;a:3:{s:1:\"a\";s:1:\"6\";s:1:\"b\";s:20:\"edit investment plan\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";s:1:\"7\";s:1:\"b\";s:20:\"view investment plan\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";s:1:\"8\";s:1:\"b\";s:22:\"delete investment plan\";s:1:\"c\";s:3:\"web\";}i:8;a:3:{s:1:\"a\";s:1:\"9\";s:1:\"b\";s:17:\"delete users plan\";s:1:\"c\";s:3:\"web\";}i:9;a:3:{s:1:\"a\";s:2:\"10\";s:1:\"b\";s:15:\"view users plan\";s:1:\"c\";s:3:\"web\";}i:10;a:3:{s:1:\"a\";s:2:\"11\";s:1:\"b\";s:15:\"edit users plan\";s:1:\"c\";s:3:\"web\";}i:11;a:3:{s:1:\"a\";s:2:\"13\";s:1:\"b\";s:13:\"view deposits\";s:1:\"c\";s:3:\"web\";}i:12;a:3:{s:1:\"a\";s:2:\"14\";s:1:\"b\";s:16:\"process deposits\";s:1:\"c\";s:3:\"web\";}i:13;a:3:{s:1:\"a\";s:2:\"15\";s:1:\"b\";s:15:\"delete deposits\";s:1:\"c\";s:3:\"web\";}i:14;a:3:{s:1:\"a\";s:2:\"16\";s:1:\"b\";s:18:\"delete withdrawals\";s:1:\"c\";s:3:\"web\";}i:15;a:3:{s:1:\"a\";s:2:\"17\";s:1:\"b\";s:16:\"view withdrawals\";s:1:\"c\";s:3:\"web\";}i:16;a:3:{s:1:\"a\";s:2:\"18\";s:1:\"b\";s:19:\"process withdrawals\";s:1:\"c\";s:3:\"web\";}i:17;a:4:{s:1:\"a\";s:2:\"19\";s:1:\"b\";s:24:\"process kyc applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:18;a:4:{s:1:\"a\";s:2:\"20\";s:1:\"b\";s:21:\"view kyc applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:19;a:3:{s:1:\"a\";s:2:\"21\";s:1:\"b\";s:23:\"delete kyc applications\";s:1:\"c\";s:3:\"web\";}i:20;a:4:{s:1:\"a\";s:2:\"22\";s:1:\"b\";s:26:\"view admin dashboard stats\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:21;a:4:{s:1:\"a\";s:2:\"23\";s:1:\"b\";s:29:\"view users registration chart\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:22;a:3:{s:1:\"a\";s:2:\"24\";s:1:\"b\";s:17:\"view transactions\";s:1:\"c\";s:3:\"web\";}i:23;a:3:{s:1:\"a\";s:2:\"25\";s:1:\"b\";s:19:\"delete transactions\";s:1:\"c\";s:3:\"web\";}i:24;a:3:{s:1:\"a\";s:2:\"26\";s:1:\"b\";s:20:\"perform bulk actions\";s:1:\"c\";s:3:\"web\";}i:25;a:3:{s:1:\"a\";s:2:\"27\";s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";}i:26;a:3:{s:1:\"a\";s:2:\"28\";s:1:\"b\";s:28:\"view platform administration\";s:1:\"c\";s:3:\"web\";}i:27;a:3:{s:1:\"a\";s:2:\"29\";s:1:\"b\";s:26:\"update roles & permissions\";s:1:\"c\";s:3:\"web\";}i:28;a:3:{s:1:\"a\";s:2:\"30\";s:1:\"b\";s:16:\"view activty log\";s:1:\"c\";s:3:\"web\";}i:29;a:3:{s:1:\"a\";s:2:\"31\";s:1:\"b\";s:18:\"delete activty log\";s:1:\"c\";s:3:\"web\";}i:30;a:3:{s:1:\"a\";s:2:\"32\";s:1:\"b\";s:12:\"view cronjob\";s:1:\"c\";s:3:\"web\";}i:31;a:3:{s:1:\"a\";s:2:\"33\";s:1:\"b\";s:22:\"perform system cleanup\";s:1:\"c\";s:3:\"web\";}i:32;a:3:{s:1:\"a\";s:2:\"35\";s:1:\"b\";s:11:\"clear cache\";s:1:\"c\";s:3:\"web\";}i:33;a:3:{s:1:\"a\";s:2:\"36\";s:1:\"b\";s:16:\"view system info\";s:1:\"c\";s:3:\"web\";}i:34;a:3:{s:1:\"a\";s:2:\"37\";s:1:\"b\";s:21:\"perform system update\";s:1:\"c\";s:3:\"web\";}i:35;a:3:{s:1:\"a\";s:2:\"38\";s:1:\"b\";s:23:\"update general settings\";s:1:\"c\";s:3:\"web\";}i:36;a:3:{s:1:\"a\";s:2:\"39\";s:1:\"b\";s:21:\"update email settings\";s:1:\"c\";s:3:\"web\";}i:37;a:3:{s:1:\"a\";s:2:\"40\";s:1:\"b\";s:22:\"update email templates\";s:1:\"c\";s:3:\"web\";}i:38;a:3:{s:1:\"a\";s:2:\"41\";s:1:\"b\";s:27:\"update dashboard appearance\";s:1:\"c\";s:3:\"web\";}i:39;a:3:{s:1:\"a\";s:2:\"42\";s:1:\"b\";s:23:\"update modules settings\";s:1:\"c\";s:3:\"web\";}i:40;a:3:{s:1:\"a\";s:2:\"43\";s:1:\"b\";s:20:\"view payment methods\";s:1:\"c\";s:3:\"web\";}i:41;a:3:{s:1:\"a\";s:2:\"44\";s:1:\"b\";s:18:\"add payment method\";s:1:\"c\";s:3:\"web\";}i:42;a:3:{s:1:\"a\";s:2:\"45\";s:1:\"b\";s:19:\"edit payment method\";s:1:\"c\";s:3:\"web\";}i:43;a:3:{s:1:\"a\";s:2:\"46\";s:1:\"b\";s:21:\"delete payment method\";s:1:\"c\";s:3:\"web\";}i:44;a:3:{s:1:\"a\";s:2:\"47\";s:1:\"b\";s:25:\"update payment preference\";s:1:\"c\";s:3:\"web\";}i:45;a:3:{s:1:\"a\";s:2:\"48\";s:1:\"b\";s:27:\"update coinpayment settings\";s:1:\"c\";s:3:\"web\";}i:46;a:3:{s:1:\"a\";s:2:\"49\";s:1:\"b\";s:22:\"update stripe settings\";s:1:\"c\";s:3:\"web\";}i:47;a:3:{s:1:\"a\";s:2:\"50\";s:1:\"b\";s:24:\"update paystack settings\";s:1:\"c\";s:3:\"web\";}i:48;a:3:{s:1:\"a\";s:2:\"51\";s:1:\"b\";s:27:\"update flutterwave settings\";s:1:\"c\";s:3:\"web\";}i:49;a:3:{s:1:\"a\";s:2:\"52\";s:1:\"b\";s:23:\"update binance settings\";s:1:\"c\";s:3:\"web\";}i:50;a:3:{s:1:\"a\";s:2:\"53\";s:1:\"b\";s:29:\"update fund transfer settings\";s:1:\"c\";s:3:\"web\";}i:51;a:3:{s:1:\"a\";s:2:\"58\";s:1:\"b\";s:23:\"update website settings\";s:1:\"c\";s:3:\"web\";}i:52;a:3:{s:1:\"a\";s:2:\"59\";s:1:\"b\";s:28:\"update social login settings\";s:1:\"c\";s:3:\"web\";}i:53;a:3:{s:1:\"a\";s:2:\"60\";s:1:\"b\";s:21:\"update control center\";s:1:\"c\";s:3:\"web\";}i:54;a:3:{s:1:\"a\";s:2:\"61\";s:1:\"b\";s:29:\"update communication settings\";s:1:\"c\";s:3:\"web\";}i:55;a:3:{s:1:\"a\";s:2:\"62\";s:1:\"b\";s:17:\"update preference\";s:1:\"c\";s:3:\"web\";}i:56;a:3:{s:1:\"a\";s:2:\"63\";s:1:\"b\";s:18:\"see administrators\";s:1:\"c\";s:3:\"web\";}i:57;a:3:{s:1:\"a\";s:2:\"64\";s:1:\"b\";s:21:\"change admin password\";s:1:\"c\";s:3:\"web\";}i:58;a:3:{s:1:\"a\";s:2:\"65\";s:1:\"b\";s:12:\"delete admin\";s:1:\"c\";s:3:\"web\";}i:59;a:3:{s:1:\"a\";s:2:\"66\";s:1:\"b\";s:18:\"edit admin details\";s:1:\"c\";s:3:\"web\";}i:60;a:3:{s:1:\"a\";s:2:\"67\";s:1:\"b\";s:23:\"block and unblock admin\";s:1:\"c\";s:3:\"web\";}i:61;a:3:{s:1:\"a\";s:2:\"68\";s:1:\"b\";s:12:\"create admin\";s:1:\"c\";s:3:\"web\";}i:62;a:3:{s:1:\"a\";s:2:\"69\";s:1:\"b\";s:27:\"view tasks assigned to them\";s:1:\"c\";s:3:\"web\";}i:63;a:3:{s:1:\"a\";s:2:\"70\";s:1:\"b\";s:11:\"delete task\";s:1:\"c\";s:3:\"web\";}i:64;a:3:{s:1:\"a\";s:2:\"71\";s:1:\"b\";s:22:\"mark task as completed\";s:1:\"c\";s:3:\"web\";}i:65;a:3:{s:1:\"a\";s:2:\"72\";s:1:\"b\";s:9:\"edit task\";s:1:\"c\";s:3:\"web\";}i:66;a:3:{s:1:\"a\";s:2:\"73\";s:1:\"b\";s:12:\"add new task\";s:1:\"c\";s:3:\"web\";}i:67;a:3:{s:1:\"a\";s:2:\"74\";s:1:\"b\";s:13:\"view all task\";s:1:\"c\";s:3:\"web\";}i:68;a:3:{s:1:\"a\";s:2:\"75\";s:1:\"b\";s:21:\"export deposit record\";s:1:\"c\";s:3:\"web\";}i:69;a:3:{s:1:\"a\";s:2:\"76\";s:1:\"b\";s:24:\"export withdrawal record\";s:1:\"c\";s:3:\"web\";}i:70;a:3:{s:1:\"a\";s:2:\"77\";s:1:\"b\";s:29:\"see users plan profit history\";s:1:\"c\";s:3:\"web\";}i:71;a:3:{s:1:\"a\";s:2:\"78\";s:1:\"b\";s:23:\"manually create deposit\";s:1:\"c\";s:3:\"web\";}i:72;a:3:{s:1:\"a\";s:2:\"79\";s:1:\"b\";s:19:\"create new category\";s:1:\"c\";s:3:\"web\";}i:73;a:3:{s:1:\"a\";s:2:\"80\";s:1:\"b\";s:17:\"manage categories\";s:1:\"c\";s:3:\"web\";}i:74;a:3:{s:1:\"a\";s:2:\"81\";s:1:\"b\";s:15:\"delete category\";s:1:\"c\";s:3:\"web\";}i:75;a:3:{s:1:\"a\";s:2:\"82\";s:1:\"b\";s:19:\"see membership menu\";s:1:\"c\";s:3:\"web\";}i:76;a:3:{s:1:\"a\";s:2:\"83\";s:1:\"b\";s:14:\"manage courses\";s:1:\"c\";s:3:\"web\";}i:77;a:3:{s:1:\"a\";s:2:\"84\";s:1:\"b\";s:14:\"manage lessons\";s:1:\"c\";s:3:\"web\";}i:78;a:3:{s:1:\"a\";s:2:\"85\";s:1:\"b\";s:15:\"see signal menu\";s:1:\"c\";s:3:\"web\";}i:79;a:3:{s:1:\"a\";s:2:\"86\";s:1:\"b\";s:18:\"see copytrade menu\";s:1:\"c\";s:3:\"web\";}i:80;a:3:{s:1:\"a\";s:2:\"87\";s:1:\"b\";s:22:\"manage signal settings\";s:1:\"c\";s:3:\"web\";}i:81;a:3:{s:1:\"a\";s:2:\"88\";s:1:\"b\";s:14:\"manage signals\";s:1:\"c\";s:3:\"web\";}i:82;a:3:{s:1:\"a\";s:2:\"89\";s:1:\"b\";s:18:\"manage subscribers\";s:1:\"c\";s:3:\"web\";}i:83;a:3:{s:1:\"a\";s:2:\"90\";s:1:\"b\";s:11:\"send emails\";s:1:\"c\";s:3:\"web\";}i:84;a:3:{s:1:\"a\";s:2:\"91\";s:1:\"b\";s:23:\"manage general settings\";s:1:\"c\";s:3:\"web\";}i:85;a:4:{s:1:\"a\";s:2:\"92\";s:1:\"b\";s:12:\"make deposit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:86;a:4:{s:1:\"a\";s:2:\"93\";s:1:\"b\";s:15:\"make withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:87;a:4:{s:1:\"a\";s:2:\"94\";s:1:\"b\";s:18:\"see profit history\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:88;a:4:{s:1:\"a\";s:2:\"95\";s:1:\"b\";s:13:\"purchase plan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:89;a:4:{s:1:\"a\";s:2:\"96\";s:1:\"b\";s:15:\"see their plans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:90;a:4:{s:1:\"a\";s:2:\"97\";s:1:\"b\";s:11:\"refer users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:91;a:4:{s:1:\"a\";s:2:\"98\";s:1:\"b\";s:15:\"contact support\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:92;a:4:{s:1:\"a\";s:2:\"99\";s:1:\"b\";s:30:\"see their transactions history\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:93;a:4:{s:1:\"a\";s:3:\"100\";s:1:\"b\";s:20:\"update their profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:94;a:4:{s:1:\"a\";s:3:\"101\";s:1:\"b\";s:39:\"update their withdrawal payment options\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:95;a:4:{s:1:\"a\";s:3:\"102\";s:1:\"b\";s:21:\"change their password\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:96;a:4:{s:1:\"a\";s:3:\"103\";s:1:\"b\";s:29:\"use two-factor authentication\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:97;a:4:{s:1:\"a\";s:3:\"104\";s:1:\"b\";s:23:\"manage browser sessions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:98;a:3:{s:1:\"a\";s:3:\"105\";s:1:\"b\";s:20:\"delete their account\";s:1:\"c\";s:3:\"web\";}i:99;a:4:{s:1:\"a\";s:3:\"106\";s:1:\"b\";s:23:\"update email preference\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:23;}}i:100;a:3:{s:1:\"a\";s:3:\"107\";s:1:\"b\";s:28:\"see trade chart on dashboard\";s:1:\"c\";s:3:\"web\";}i:101;a:3:{s:1:\"a\";s:3:\"108\";s:1:\"b\";s:20:\"see crypto swap menu\";s:1:\"c\";s:3:\"web\";}i:102;a:3:{s:1:\"a\";s:3:\"109\";s:1:\"b\";s:13:\"manage assets\";s:1:\"c\";s:3:\"web\";}i:103;a:3:{s:1:\"a\";s:3:\"110\";s:1:\"b\";s:20:\"manage swap settings\";s:1:\"c\";s:3:\"web\";}i:104;a:3:{s:1:\"a\";s:3:\"111\";s:1:\"b\";s:26:\"update ref & other bonuses\";s:1:\"c\";s:3:\"web\";}i:105;a:3:{s:1:\"a\";s:3:\"112\";s:1:\"b\";s:29:\"admin update account settings\";s:1:\"c\";s:3:\"web\";}i:106;a:4:{s:1:\"a\";s:3:\"113\";s:1:\"b\";s:16:\"view other stats\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:26;}}i:107;a:3:{s:1:\"a\";s:3:\"114\";s:1:\"b\";s:19:\"manually add profit\";s:1:\"c\";s:3:\"web\";}i:108;a:3:{s:1:\"a\";s:3:\"115\";s:1:\"b\";s:25:\"manage copytrade settings\";s:1:\"c\";s:3:\"web\";}i:109;a:3:{s:1:\"a\";s:3:\"116\";s:1:\"b\";s:14:\"view providers\";s:1:\"c\";s:3:\"web\";}i:110;a:3:{s:1:\"a\";s:3:\"117\";s:1:\"b\";s:15:\"view symbolmaps\";s:1:\"c\";s:3:\"web\";}i:111;a:3:{s:1:\"a\";s:3:\"118\";s:1:\"b\";s:25:\"manage signal subscribers\";s:1:\"c\";s:3:\"web\";}i:112;a:3:{s:1:\"a\";s:3:\"120\";s:1:\"b\";s:22:\"update paypal settings\";s:1:\"c\";s:3:\"web\";}i:113;a:3:{s:1:\"a\";s:3:\"121\";s:1:\"b\";s:18:\"manage recycle bin\";s:1:\"c\";s:3:\"web\";}i:114;a:3:{s:1:\"a\";s:3:\"122\";s:1:\"b\";s:24:\"update coinbase settings\";s:1:\"c\";s:3:\"web\";}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";s:2:\"26\";s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";s:2:\"23\";s:1:\"b\";s:4:\"User\";s:1:\"c\";s:3:\"web\";}}}', 1724869114);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coinbases`
--

CREATE TABLE `coinbases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `charge_code` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coin_payments`
--

CREATE TABLE `coin_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `Item_number` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `user_plan` varchar(255) DEFAULT NULL,
  `user_tele_id` int(11) DEFAULT NULL,
  `amount1` varchar(255) DEFAULT NULL,
  `amount2` varchar(255) DEFAULT NULL,
  `currency1` varchar(255) DEFAULT NULL,
  `currency2` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_text` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `ref_key` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `page` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `ref_key`, `title`, `description`, `img_path`, `created_at`, `updated_at`, `page`) VALUES
(5, 'SMsJr1', 'Reviews from our users', 'Take a look at what some users who have used our platform for investing in financial markets have said', NULL, '2020-08-22 11:13:00', '2024-08-08 15:44:34', 'Home'),
(11, 'anvs8c', 'About Us', '-', NULL, '2020-08-22 11:32:29', '2024-03-02 20:34:33', 'About'),
(12, 'epJ4LI', 'Who we are', 'E-PandaPay is a solution for creating an investment management platform. It is suited for hedge or mutual fund managers and also Forex, stocks, bonds and cryptocurrency traders who are looking at runing pool trading system. E-PandaPay simplifies the investment,\n                            monitoring and management process. With a secure and compelling mobile-first design,\n                            together with a default front-end design, it takes few minutes to setup your own investment\n                            management or pool trading platform.', 'media/bfkz6NRkvnZiwlQjYigIPn6dUIrkUAZRPosXu8aX.jpg', '2020-08-22 11:33:32', '2024-08-25 13:39:44', 'About'),
(13, '5hbB6X', 'Get Started', 'How to get started ?', NULL, '2020-08-22 11:33:55', '2021-10-27 10:25:09', 'About'),
(14, 'Zrhm3I', 'Create an Account', 'Create an account with us using your preffered email/username', NULL, '2020-08-22 11:34:11', '2021-10-27 10:25:29', 'About'),
(15, 'yTKhlt', 'Make a Deposit', 'Make A deposit with any of your preffered currency', NULL, '2020-08-22 11:34:26', '2021-10-27 10:25:52', 'About'),
(16, 'u0Ervr', 'Start Trading/Investing', 'Start trading with Indices commodities e.tc', NULL, '2020-08-22 11:34:56', '2021-10-27 10:26:12', 'About'),
(23, 'vr6Xw0', 'Tailored Trading Plans for every Investor', 'Our expert trading plans are designed to cater to both novice and experienced investors, offering tailored strategies that align with your financial goals.', NULL, '2020-08-22 11:37:43', '2024-08-08 16:43:29', 'Plans'),
(30, '52GPRA', 'Address', '34 Ontario Canada', NULL, '2020-08-22 11:40:19', '2024-03-07 15:36:29', 'Contact'),
(31, '0EXbji', 'Phone Number', '+234 9xxxxxxxx', NULL, '2020-08-22 11:40:36', '2020-09-14 10:13:57', 'Contact'),
(32, 'HLgyaQ', 'Email', 'support@e-pandapay.xyz', NULL, '2020-08-22 11:41:14', '2024-03-07 15:36:38', 'Contact'),
(35, 'Mnag31', 'Achieve Financial Goals with us.', 'Secure your financial funds right now by investing in various instruments on our platform that have been officially recognized by the government.', 'media/piQWoDgJIQjugLjma8lvXhjZTPMgvQbivxN31frt.png', '2021-10-27 09:42:23', '2024-08-08 15:39:45', 'Home'),
(36, 'rXJ7JQ', 'Trade Invest stock, and Bond', 'Home page text', NULL, '2021-10-27 09:45:17', '2021-10-27 09:45:17', 'Home'),
(37, 'J23T0Y', 'Safe financial investment with the features we have', 'All these serves are easy for you just one touch', NULL, '2021-10-27 09:53:15', '2024-08-08 15:15:11', 'Home'),
(38, '9HOR1z', 'Security at it\'s core', 'Online Trade uses the highest levels of Internet Security to ensure that your information and funds are completely protected from fraud & hackers.', NULL, '2021-10-27 09:56:13', '2024-08-08 15:26:20', 'Home'),
(39, '7DH2G9', 'Two Factor Auth', 'Two-factor authentication (2FA) by default on all Online Trade accounts, to securely protect you from unauthorised access and impersonation.', NULL, '2021-10-27 09:56:26', '2021-10-27 09:56:26', 'Home'),
(40, '5Vg32I', 'Live and accurate market analysis', 'Analyze the market you choose easily through our features and you can analyze market movements accurately through charts that have advanced features and of course real markets', 'media/nie5LFRxXy2qeWh3UKiBpSVNsi0PUz7LBMcxdCxO.gif', '2021-10-27 09:56:38', '2024-08-25 19:03:56', 'Home'),
(41, 'Vg6Gy7', 'Powerful Trading Platforms', 'Online Trade offers multiple platform options to cover the needs of each type of trader and investors .', NULL, '2021-10-27 09:56:53', '2021-10-27 09:56:53', 'Home'),
(42, '1Sx1dl', 'High leverage', 'Chance to magnify your investment and really win big with super-low spreads to further up your profits', NULL, '2021-10-27 09:57:06', '2021-10-27 09:57:06', 'Home'),
(43, 'YYqKx3', 'Fast execution', 'Super-fast trading software, so you never suffer slippage.', NULL, '2021-10-27 09:57:20', '2021-10-27 09:57:20', 'Home'),
(44, 'yGg8xI', 'Ultimate Security', 'With advanced security systems, we keep your account always protected.', NULL, '2021-10-27 09:57:35', '2024-03-02 20:00:03', 'Home'),
(45, 'xEWMho', '24/7 live chat Support', 'Connect with our 24/7 support and Market Analyst on-demand.', '', '2021-10-27 09:57:48', '2024-03-02 19:57:10', 'Home'),
(46, '9SOtK1', 'Invest in many financial instruments', 'You can invest in many financial instruments such as stocks, various mutual fund products, stock\r\nindices ond the most protolice oy mony ocodiel\r\ntoday is crypto.', 'media/811PKt3SW9n32QQGnuu0HspNij7gc4uSxNGupN8D.png', '2021-10-27 09:58:05', '2024-08-08 15:42:02', 'Home'),
(47, 'wOS1ve', 'Cryptocurrency', 'Trade and invest Top Cryptocurrency', NULL, '2021-10-27 09:59:07', '2021-10-27 09:59:07', NULL),
(48, 'wuZlis', 'Hello!, How can we help you?', '-', NULL, '2021-10-27 10:32:12', '2024-03-02 20:35:56', 'Faq'),
(49, '1TYkw0', 'Find the help you need', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', NULL, '2021-10-27 10:32:33', '2021-10-27 10:32:33', 'Faq'),
(50, 'rK6Yhn', 'FAQs', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', NULL, '2021-10-27 10:32:49', '2021-10-27 10:32:49', 'Faq'),
(51, 'HBHBLo', 'Guides / Support', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', NULL, '2021-10-27 10:33:03', '2021-10-27 10:33:03', 'Faq'),
(52, 'rCTDQh', 'Support Request', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', NULL, '2021-10-27 10:33:14', '2021-10-27 10:33:14', 'Faq'),
(53, 'kMsswR', 'Get Started', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', NULL, '2021-10-27 10:33:28', '2021-10-27 10:33:28', 'Faq'),
(54, 'EOUU7R', 'Get in Touch !', 'This is required when, for text is not yet available.', NULL, '2021-10-27 10:33:56', '2021-10-27 10:33:56', 'Faq'),
(56, 'ROu4q6', 'Contact Us', 'Contact Us', NULL, '2021-10-27 10:47:41', '2021-10-27 10:47:41', 'Contact'),
(57, 'yHdg43', 'Fast, Efficient and Productive', 'In this kind of post, the blogger introduces a person they’ve interviewed\nand provides some background information about the interviewee and their\nwork following this is a transcript of the interview.', 'media/L36dOXfHZFvuKEh4PKUeytL6ixNLb3dppbveSmUf.png', '2024-02-25 19:37:09', '2024-08-25 13:37:17', 'Auth'),
(58, 'skjf23', 'Terms', '<p><strong>Our Commitment to You and yours:</strong></p>\n\n<p>Thank you for showing interest in our service. In order for us to provide you with our service, we are required to collect and process certain personal data about you and your activity.</p>\n\n<p>By entrusting us with your personal data, we would like to assure you of our commitment to keep such information private and to operate in accordance with all regulatory laws and all EU data protection laws, including General Data Protection Regulation (GDPR) 679/2016 (EU).</p>\n\n<p>We have taken measurable steps to protect the confidentiality, security and integrity of this data. We encourage you to review the following information carefully.</p>\n\n<p><strong>Grounds for data collection:</strong></p>\n\n<p>Processing of your personal information (meaning, any data which may potentially allow your identification with reasonable means; hereinafter &ldquo;Personal Data&rdquo;) is necessary for the performance of our contractual obligations towards you and providing you with our services, to protect our legitimate interests and for compliance with legal and financial regulatory obligations to which we are subject.</p>\n\n<p>When you use our services, you consent to the collection, storage, use, disclosure and other uses of your Personal Data as described in this Privacy Policy.</p>\n\n<p><strong>How do we receive data about you?</strong></p>\n\n<p>We receive your Personal Data from various sources:</p>\n\n<ol>\n	<li>When you voluntarily provide us with your personal details in order to create an account (for example, your name and email address)</li>\n	<li>When you use or access our site and services, in connection with your use of our services (for example, your financial transactions)</li>\n	<li>&nbsp;</li>\n</ol>\n\n<p><strong>What type of data we collect?</strong></p>\n\n<p>In order to open an account, and in order to provide you with our services we will need you to collect the following data:</p>\n\n<p><strong>Personal Data<br />\nWe collect the following Personal Data about you:</strong></p>\n\n<ul>\n	<li><em>Registration data</em>&nbsp;&ndash; your name, email address, phone number, occupation, country of residence, and your age (in order to verify you are over 18 years of age and eligible to participate in our service).</li>\n	<li><em>Voluntary data</em>&nbsp;&ndash; when you communicate with us (for example when you send us an email or use a &ldquo;contact us&rdquo; form on our site) we collect the personal data you provided us with.</li>\n	<li><em>Financial data</em>&nbsp;&ndash; by its nature, your use of our services includes financial transactions, thus requiring us to obtain your financial details, which includes, but not limited to your payment details (such as bank account details and financial transactions performed through our services).</li>\n	<li><em>Technical data</em>&nbsp;&ndash; we collect certain technical data that is automatically recorded when you use our services, such as your IP address, MAC address, device approximate location</li>\n	<li>Non Personal Data</li>\n</ul>\n\n<p>We record and collect data from or about your device (for example your computer or your mobile device) when you access our services and visit our site. This includes, but not limited to: your login credentials, UDID, Google advertising ID, IDFA, cookie identifiers, and may include other identifiers such your operating system version, browser type, language preferences, time zone, referring domains and the duration of your visits. This will facilitate our ability to improve our service and personalize your experience with us.<br />\nIf we combine Personal Data with non-Personal Data about you, the combined data will be treated as Personal Data for as long as it remains combined.</p>\n\n<p><strong>Tracking Technologies</strong></p>\n\n<p>When you visit or access our services we use (and authorize 3rd parties to use) pixels, cookies, events and other technologies (&ldquo;Tracking Technologies&ldquo;). Those allow us to automatically collect data about you, your device and your online behavior, in order to enhance your navigation in our services, improve our site&rsquo;s performance, perform analytics and customize your experience on it. In addition, we may merge data we have with data collected through said tracking technologies with data we may obtain from other sources and, as a result, such data may become Personal Data.<br />\nCookie Policy page.</p>\n\n<p><strong>How do we use the data We collect?</strong></p>\n\n<ul>\n	<li>Provision of service &ndash; we will use your Personal Data you provide us for the provision and improvement of our services to you.</li>\n	<li>Marketing purposes &ndash; we will use your Personal Data (such as your email address or phone number). For example, by subscribing to our newsletter you will receive tips and announcements straight to your email account. We may also send you promotional material concerning our services or our partners&rsquo; services (which we believe may interest you), including but not limited to, by building an automated profile based on your Personal Data, for marketing purposes. You may choose not to receive our promotional or marketing emails (all or any part thereof) by clicking on the &ldquo;unsubscribe&rdquo; link in the emails that you receive from us. Please note that even if you unsubscribe from our newsletter, we may continue to send you service-related updates and notifications or reply to your queries and feedback you provide us.</li>\n	<li>Opt-out of receiving marketing materials &ndash; If you do not want us to use or share your personal data for marketing purposes, you may opt-out in accordance with this &ldquo;Opt-out&rdquo; section. Please note that even if you opt-out, we may still use and share your personal information with third parties for non-marketing purposes (for example to fulfill your requests, communicate with you and respond to your inquiries, etc.). In such cases, the companies with whom we share your personal data are authorized to use your Personal Data only as necessary to provide these non-marketing services.</li>\n	<li>Analytics, surveys and research &ndash; we are always trying to improve our services and think of new and exciting features for our users. From time to time, we may conduct surveys or test features, and analyze the information we have to develop, evaluate and improve these features.</li>\n	<li>Protecting our interests &ndash; we use your Personal Data when we believe it&rsquo;s necessary in order to take precautions against liabilities, investigate and defend ourselves against any third-party claims or allegations, investigate and protect ourselves from fraud, protect the security or integrity of our services and protect the rights and property of the company, its users and/or partners.</li>\n	<li>Enforcing of policies &ndash; we use your Personal Data in order to enforce our policies, including but limited to our Terms &amp; Conditions.</li>\n	<li>Compliance with legal and regulatory requirements &ndash; we also use your Personal Data to investigate violations and prevent money laundering and perform due-diligence checks, and as required by law, regulation or other governmental authority, or to comply with a subpoena or similar legal process.</li>\n</ul>\n\n<p><strong>With whom do we share your Personal Data</strong></p>\n\n<ul>\n	<li>Internal concerned parties &ndash; we share your data with companies in our group, as well as our employees limited to those employees or partners who need to know the information in order to provide you with our services.</li>\n	<li>Financial providers and payment processors &ndash; we share your financial data about you for purposes of accepting deposits or performing risk analysis.</li>\n	<li>Business partners &ndash; we share your data with business partners, such as storage providers and analytics providers who help us provide you with our service.</li>\n	<li>Legal and regulatory entities &ndash; we may disclose any data in case we believe, in good faith, that such disclosure is necessary in order to enforce our Terms &amp; Conditions take precautions against liabilities, investigate and defend ourselves against any third party claims or allegations, protect the security or integrity of the site and our servers and protect the rights and property, our users and/or partners. We may also disclose your personal data where requested any other regulatory authority having control or jurisdiction over us, you or our associates or in the territories we have clients or providers, as a broker.</li>\n	<li>Merger and acquisitions &ndash; we may share your data if we enter into a business transaction such as a merger, acquisition, reorganization, bankruptcy, or sale of some or all of our assets. Any party that acquires our assets as part of such a transaction may continue to use your data in accordance with the terms of this Privacy Policy.</li>\n</ul>\n\n<p><strong>Transfer of data outside the EEA</strong></p>\n\n<p>Please note that some data recipients may be located outside the EEA. In such cases, we will transfer your data only to such countries as approved by the European Commission as providing an adequate level of data protection or enter into legal agreements ensuring an adequate level of data protection.</p>\n\n<p><strong>How we protect your data</strong></p>\n\n<p>We have implemented administrative, technical, and physical safeguards to help prevent unauthorized access, use, or disclosure of your personal data. Your data is stored on secure servers and isn&rsquo;t publicly available. We limit access of your data only to those employees or partners that need to know the information in order to enable the carrying out of the agreement between us.</p>\n\n<p>You need to help us prevent unauthorized access to your account by protecting your password appropriately and limiting access to your account (for example, by signing off after you have finished accessing your account). You will be solely responsible for keeping your password confidential and for all use of your password and your account, including any unauthorized use.</p>\n\n<p>While we seek to protect your data to ensure that it is kept confidential, we cannot absolutely guarantee its security. You should be aware that there is always some risk involved in transmitting data over the internet. While we strive to protect your Personal Data, we cannot ensure or warrant the security and privacy of your personal Data or other content you transmit using the service, and you do so at your own risk.</p>\n\n<p><strong>Retention</strong></p>\n\n<p>We will retain your personal data for as long as necessary to provide our services, and as necessary to comply with our legal obligations, resolve disputes, and enforce our policies. Retention periods will be determined taking into account the type of data that is collected and the purpose for which it is collected, bearing in mind the requirements applicable to the situation and the need to destroy outdated, unused data at the earliest reasonable time. Under applicable regulations, we will keep records containing client personal data, trading information, account opening documents, communications and anything else as required by applicable laws and regulations.</p>\n\n<p><strong>User Rights</strong></p>\n\n<ol>\n	<li>Receive confirmation as to whether or not personal data concerning you is being processed, and access your stored personal data, together with supplementary data.</li>\n	<li>Receive a copy of personal data you directly volunteer to us in a structured, commonly used and machine-readable format.</li>\n	<li>Request rectification of your personal data that is in our control.</li>\n	<li>Request erasure of your personal data.</li>\n	<li>Object to the processing of personal data by us.</li>\n	<li>Request to restrict processing of your personal data by us.</li>\n</ol>\n\n<p>However, please note that these rights are not absolute, and may be subject to our own legitimate interests and regulatory requirements.</p>\n\n<p><strong>How to Contact us?</strong></p>\n\n<p>If you wish to exercise any of the aforementioned rights, or receive more information, please contact our General Data Protection Officer (&ldquo;GDPO&rdquo;) using the details provided below:</p>\n\n<p>Email: support@onlintrade.com</p>\n\n<p>Attn. GDPO Compliance Officer</p>\n\n<p>If you decide to terminate your account, you may do so by emailing us at support@onlintrade.com. If you terminate your account, please be aware that personal information that you have provided us may still be maintained for legal and regulatory reasons (as described above), but it will no longer be accessible via your account.</p>\n\n<p><strong>Updates to this Policy</strong></p>\n\n<p>This Privacy Policy is subject to changes from time to time, at our sole discretion. The most current version will always be posted on our website (as reflected in the &ldquo;Last Updated&rdquo; heading). You are advised to check for updates regularly. In the event of material changes, we will provide you with a notice. By continuing to access or use our services after any revisions become effective, you agree to be bound by the updated Privacy Policy.</p>\n', NULL, '2024-03-02 21:53:19', '2024-03-02 21:03:56', 'Terms'),
(59, '39043d', 'Auth Aside Background Image', 'Auth Aside (Left) Background Image', 'media/WjS6qQtkw42F8nW8FJPlgf1QOrZZ6lbSZni8SE1O.png', '2024-03-07 16:02:12', '2024-03-07 15:37:39', 'Auth'),
(60, '2idn23', 'Admin authentication background image', 'Admin background image', 'media/6VW1UJV6D1FHCBTjGAZSQjY4EykjQAkXYJNJjNl4.jpg', '2024-08-25 14:18:20', '2024-08-25 13:41:06', 'Auth');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_accounts`
--

CREATE TABLE `crypto_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ada_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `xlm_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `xrp_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `bch_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `usdt_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `bnb_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `ltc_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `eth_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `btc_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_currencies`
--

CREATE TABLE `crypto_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `symbol` varchar(191) DEFAULT NULL,
  `price_in_usd` varchar(191) DEFAULT NULL,
  `price_in_token` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `logo_size` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crypto_currencies`
--

INSERT INTO `crypto_currencies` (`id`, `name`, `symbol`, `price_in_usd`, `price_in_token`, `status`, `is_default`, `created_at`, `updated_at`, `logo_url`, `logo_size`) VALUES
(1, 'Bitcoin', 'BTC', '62112', NULL, 'active', 1, '2024-02-21 02:09:29', '2024-08-27 22:20:09', 'https://img.icons8.com/color/48/000000/bitcoin--v1.png', 30),
(2, 'Ethereum', 'ETH', '2588.3', NULL, 'active', 1, '2024-02-21 02:09:57', '2024-08-27 22:20:11', 'https://img.icons8.com/fluency/48/000000/ethereum.png', 30),
(3, 'Litecoin', 'LTC', '63.57', NULL, 'active', 1, '2024-02-21 02:10:06', '2024-08-27 22:20:12', 'https://img.icons8.com/fluency/48/000000/litecoin.png', 30),
(4, 'Binance Coin', 'BNB', '561.51', NULL, 'active', 1, '2024-02-21 02:10:18', '2024-08-27 21:50:13', 'https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png', 27),
(5, 'USDT (Tether)', 'USDT', '1', NULL, 'active', 1, '2024-02-21 02:10:31', '2024-03-16 00:15:37', 'https://img.icons8.com/color/48/000000/tether--v2.png', 30),
(6, 'Bitcoin Cash', 'BCH', '338.27', NULL, 'active', 1, '2024-02-21 02:10:44', '2024-08-27 22:20:16', 'https://img.icons8.com/material-sharp/24/000000/bitcoin.png', 30),
(7, 'Ripple', 'XRP', '0.59851', NULL, 'active', 1, '2024-02-21 02:10:55', '2024-08-27 22:20:18', 'https://img.icons8.com/fluency/48/000000/ripple.png', 30),
(8, 'Stellar', 'XLM', '0.09672', NULL, 'active', 1, '2024-02-21 02:11:07', '2024-08-27 22:20:20', 'https://img.icons8.com/ios/50/000000/stellar.png', 30),
(9, 'Ada', 'ADA', '0.3727', NULL, 'active', 1, '2024-02-21 02:11:15', '2024-08-27 21:50:21', 'https://s2.coinmarketcap.com/static/img/coins/64x64/2010.png', 30);

-- --------------------------------------------------------

--
-- Table structure for table `crypto_records`
--

CREATE TABLE `crypto_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `dest` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `inapp_notification_content` varchar(191) DEFAULT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `inapp_notification_content`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'copytrade_success', 'he', NULL, 'f', 'active', '2024-02-26 01:47:41', '2024-02-26 01:47:41'),
(2, 'course', 'You just purchase a course', NULL, 'ff', 'active', '2024-02-26 01:48:07', '2024-03-01 03:57:07'),
(3, 'signal', 'Your have successfully subscribe to our signal', NULL, 'rr', 'active', '2024-02-26 01:48:26', '2024-03-03 02:33:54'),
(4, 'kyc_failed', 'Your KYC could not been approved', NULL, '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We regret to inform you that your Know Your Customer (KYC) process has been reviewed, and unfortunately, it has not met our verification requirements.</p>\n\n<p>Reason for Rejection: {{$reason}}</p>\n\n<p>To rectify this issue, please review and resubmit the required documentation through your account dashboard.</p>\n\n<p>If you have any specific questions or need guidance on the KYC process, feel free to contact our support team. We appreciate your understanding and cooperation.</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p><strong>E-PandaPay</strong></p>\n', 'active', '2024-02-26 01:49:21', '2024-03-06 01:45:13'),
(5, 'kyc_approved', 'Your KYC is Approved', NULL, '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We are pleased to inform you that your Know Your Customer (KYC) process has been successfully reviewed and approved. Thank you for providing the necessary information and documentation.</p>\n\n<p>Your account is now fully verified, and you can enjoy all the features and benefits of our platform without any restrictions.</p>\n\n<p>If you have any questions or require further assistance, please feel free to reach out to our support team. Thank you for choosing E-PandaPay!</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p><strong>E-PandaPay</strong></p>\n', 'active', '2024-02-26 01:49:21', '2024-03-06 01:38:10'),
(6, 'withdraw_processed', 'Withdrawal Request Processed 🤑', 'Your withdrawal request has been successfully processed, Amount: {{$amount}}.', '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We want to inform you that your withdrawal request has been successfully processed.</p>\n\n<p>Transaction Details:</p>\n\n<p><em>- <strong>Amount:</strong>&nbsp;{{$currency}}{{$amount}}</em></p>\n\n<p><em>- <strong>Withdrawal Method:</strong> {{$payment_mode}}</em></p>\n\n<p><em>- <strong>Date and Time: </strong>{{$created_at}}</em></p>\n\n<p>The funds should now be reflected in your designated account. If you have any questions or concerns, please feel free to contact our support team.</p>\n\n<p>Thank you for choosing E-PandaPay!</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p>E-PandaPay</p>\n', 'active', '2024-02-26 01:49:53', '2024-03-14 01:14:29'),
(7, 'withdraw_failed', 'Your Withdrawal could not be processed 😞', NULL, '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We regret to inform you that your withdrawal request has been rejected due to [reason for rejection].</p>\n\n<p>Withdrawal Details:</p>\n\n<p><em>- <strong>Amount:</strong>&nbsp;{{$currency}}</em><em>{{$amount}}</em></p>\n\n<p><em>- <strong>Withdrawal Method:</strong> {{$payment_mode}}</em></p>\n\n<p><em>- <strong>Date and Time: </strong>{{$created_at}}</em></p>\n\n<p>Reason for Rejection: [Detailed Reason]</p>\n\n<p>If you have any questions or need further clarification, please reach out to our support team. We apologize for any inconvenience this may have caused.</p>\n\n<p>Thank you for your understanding.</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p>E-PandaPay</p>\n', 'active', '2024-02-26 01:50:09', '2024-03-14 01:13:59'),
(8, 'roi_received', 'New ROI', NULL, '<p><strong>Helo {{$name}},</strong></p>\n\n<p>This is a notification of a new return on investment (ROI) on your investment account.</p>\n\n<p><strong>Plan:</strong> {{$plan_name}}</p>\n\n<p><strong>Amount:</strong>&nbsp;{{$currency}}{{$amount}}</p>\n\n<p><strong>Date:</strong> {{$created_at}}</p>\n\n<p>If you have any issues, please contact us.</p>\n\n<p>&nbsp;</p>\n\n<p>Thanks,</p>\n\n<p><strong>E-PandaPay</strong>.</p>\n', 'active', '2024-02-26 01:50:38', '2024-03-26 18:57:48'),
(9, 'kyc_received', 'We have received your KYC application', NULL, '<p><strong>Hello {{$name}},</strong></p>\n\n<p>We are informing you that your kyc application have been received, you will be notified via email regarding the status of your application.</p>\n\n<p>&nbsp;</p>\n\n<p>Cheers,</p>\n\n<p>E-PandaPay.</p>\n', 'active', '2024-02-26 01:51:12', '2024-03-24 18:40:01'),
(10, 'plan_started', 'You just purchase a plan', NULL, '<p>Hello {{$name}},</p>\n\n<p>You just purchase an invesment plan.&nbsp;</p>\n\n<p><strong>Plan</strong>: {{$plan_name}}</p>\n\n<p><strong>Amount</strong>: {{$currency}}{{$amount}}</p>\n\n<p><strong>Date</strong>: {{$created_at}}</p>\n\n<p><strong>Expiration Date</strong>: {{$expire_date}}</p>\n\n<p>&nbsp;</p>\n\n<p>Best Regards,</p>\n\n<p><strong>E-PandaPay</strong></p>\n', 'active', '2024-02-26 01:51:40', '2024-03-14 16:19:58'),
(11, 'plan_ended', 'Investment Plan Expiry Notification', NULL, '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We want to inform you that your investment plan has expired.</p>\n\n<p>Investment Plan Details:</p>\n\n<p>- Plan Name:&nbsp;{{$plan_name}}&nbsp;</p>\n\n<p>- Initial Investment: {{$currency}}{{$amount}},</p>\n\n<p>- Expiry Date: {{$expire_date}},</p>\n\n<p>- Current Value: {{$currency}}{{$profit_earned}},</p>\n\n<p>If you wish to renew your investment plan or explore other investment opportunities, please log in to your account on our platform and review the available options.</p>\n\n<p>If you have any questions or need assistance, our support team is ready to help. You can reach us at support@mail.com. Thank you for choosing us. We appreciate your trust in our services.</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p>E-PandaPay</p>\n', 'active', '2024-02-26 01:51:58', '2024-03-14 01:13:31'),
(12, 'deposit_sucess', 'You just made a Deposit', NULL, '<p><strong>Hello {{$name}},&nbsp;</strong></p>\n\n<p>Your Deposit of {{$currency}}{{$amount}} via {{$payment_mode}} have been received, please wait while we process this deposit. You will be notified if your deposit is confirmed.</p>\n', 'active', '2024-02-26 01:52:20', '2024-03-14 01:13:00'),
(13, 'deposit_confirmed', 'Your Deposit Have been confirmed.', NULL, '<p><strong>Hello {{$name}},</strong></p>\n\n<p>Your Deposit of {{$currency}}{{$amount}} via {{$payment_mode}} have been confirmed and your account balance have been updated accordingly.</p>\n\n<p>Thanks,</p>\n\n<p>E-PandaPay</p>\n', 'active', '2024-02-26 01:52:39', '2024-03-14 01:12:44'),
(15, 'welcome_email', 'Welcome to E-PandaPay', NULL, '<p><strong>Hurray {{$name}},</strong></p>\n\n<p>We are really excited to welcome you to E-PandaPay community.</p>\n\n<p>This is just the beginning of greater things to come.</p>\n\n<p>Here is how you can get the most out of our system.</p>\n\n<p>Make a Deposit, Buy an Investment Plan and sit back to enjoy while we make your money work for you</p>\n\n<p>We look forward to seeing you gain your financial desires.</p>\n\n<p>&nbsp;</p>\n\n<p>Your experience is going to be nice and smooth. 🙂</p>\n\n<p>No frustrations, no trouble.</p>\n\n<p>Thanks,</p>\n', 'active', '2024-03-01 13:10:54', '2024-03-03 22:09:17'),
(16, 'email_verification', 'Verify Email Address', NULL, '<p><strong>Hello {{ $name }},</strong></p>\n\n<p>Click the link below to verify your email address.</p>\n\n<p>{{ $url }}</p>\n\n<p>Thanks,</p>\n\n<p><strong>E-PandaPay</strong></p>\n', 'inactive', '2024-03-02 21:17:08', '2024-08-20 15:01:52'),
(17, 'withdraw_success', 'Withdrawal Request Submitted', NULL, '<p><strong>Dear {{$name}},</strong></p>\n\n<p>We want to inform you that your withdrawal request has been successfully submitted, please wait while we process your withdrawal. You will be notified on the status of your request.</p>\n\n<p>Transaction Details:</p>\n\n<p><em>- <strong>Amount: </strong>{{$currency}}{{$amount}}</em></p>\n\n<p><em>- <strong>Withdrawal Method:</strong> {{$payment_mode}}</em></p>\n\n<p><em>- <strong>Date and Time: </strong>{{$created_at}}</em></p>\n\n<p>&nbsp;</p>\n\n<p>Thank you for choosing E-PandaPay!</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p>E-PandaPay</p>\n', 'active', '2024-03-13 18:47:02', '2024-03-14 01:29:27'),
(18, 'transfer', 'Transfer is Successful', NULL, '<p><strong>Hello {{$receiver}},</strong></p>\n\n<p>You just received {{$currency}}{{$amount}} from {{$sender}} and your account balance have been updated accordingly.</p>\n\n<p>If you have any issues, please contact us.</p>\n\n<p>&nbsp;</p>\n\n<p>Best Regards,</p>\n\n<p><strong>E-PandaPay.</strong></p>\n', 'active', '2024-03-14 01:54:42', '2024-03-14 01:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(2, 'Do you Offer the Linage Limit in your trading', 'Lorem ipsum dolor sit amet consectetur adipiscing elit, quis nec nisl laoreet libero velit vivamus leo, auctor ligula venenatis platea mauris suspendisse. Cubilia aliquam dis per eros vitae vivamus non hac arcu iaculis, curae pulvinar eleifend suspendisse urna litora velit metus aliquet purus', '2024-02-21 18:33:49', '2024-02-21 18:34:37'),
(3, 'What is Smartsea', ' id torquent urna dis, justo tempus curabitur etiam nisl magna porttitor. Nisl interdum donec porta ultricies sociis lacinia sem sociosqu auctor, diam sed urna volutpat posuere metus pharetra fusce, porttitor sapien mattis a parturient hac ligula velit. Sed placerat est tempus primis id class nulla habitant egestas parturient, dictum vivamus a curabitur ', '2024-02-21 18:47:53', '2024-02-21 18:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_key` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `ref_key`, `title`, `description`, `path`, `created_at`, `updated_at`) VALUES
(3, NULL, 'sTnEPzjF31G5vcz3DYZYcCWj3Tu9hTm3kYQ4URFa.webp', NULL, 'media/sTnEPzjF31G5vcz3DYZYcCWj3Tu9hTm3kYQ4URFa.webp', '2024-02-21 19:30:07', '2024-02-21 19:30:07'),
(6, NULL, 'mxgxusj8p0ZuzFBkVyZZR9hPS8XF0rIvRSkp7Njf.webp', NULL, 'media/mxgxusj8p0ZuzFBkVyZZR9hPS8XF0rIvRSkp7Njf.webp', '2024-02-21 19:30:07', '2024-02-21 19:30:07'),
(11, NULL, 'WV2T5zAVrsWxXEll01k6fuhFcJDbpIEg9iqkjrV1.jpg', NULL, 'media/WV2T5zAVrsWxXEll01k6fuhFcJDbpIEg9iqkjrV1.jpg', '2024-02-22 13:46:12', '2024-02-22 13:46:12'),
(12, NULL, 'TtcH9tMPAgIUxuYhJDj7xeLbp4bqXskIO7nf3wh7.png', NULL, 'media/TtcH9tMPAgIUxuYhJDj7xeLbp4bqXskIO7nf3wh7.png', '2024-02-23 19:15:59', '2024-02-23 19:15:59'),
(13, NULL, '811PKt3SW9n32QQGnuu0HspNij7gc4uSxNGupN8D.png', NULL, 'media/811PKt3SW9n32QQGnuu0HspNij7gc4uSxNGupN8D.png', '2024-02-23 19:15:59', '2024-02-23 19:15:59'),
(14, NULL, '4R9VProhXIig13XNYJ3YfiQXmrbANE16oOX1XDZc.png', NULL, 'media/4R9VProhXIig13XNYJ3YfiQXmrbANE16oOX1XDZc.png', '2024-02-23 19:15:59', '2024-02-23 19:15:59'),
(15, NULL, 'bfkz6NRkvnZiwlQjYigIPn6dUIrkUAZRPosXu8aX.jpg', NULL, 'media/bfkz6NRkvnZiwlQjYigIPn6dUIrkUAZRPosXu8aX.jpg', '2024-02-23 19:17:12', '2024-02-23 19:17:12'),
(16, NULL, 'L36dOXfHZFvuKEh4PKUeytL6ixNLb3dppbveSmUf.png', NULL, 'media/L36dOXfHZFvuKEh4PKUeytL6ixNLb3dppbveSmUf.png', '2024-02-25 23:37:38', '2024-02-25 23:37:38'),
(17, NULL, 'WjS6qQtkw42F8nW8FJPlgf1QOrZZ6lbSZni8SE1O.png', NULL, 'media/WjS6qQtkw42F8nW8FJPlgf1QOrZZ6lbSZni8SE1O.png', '2024-03-07 20:01:08', '2024-03-07 20:01:08'),
(18, NULL, 'Rh5KnklLuN1LPctGMcBOjY9UOqgoI8NN70kLJtPO.webp', NULL, 'media/Rh5KnklLuN1LPctGMcBOjY9UOqgoI8NN70kLJtPO.webp', '2024-03-08 16:52:21', '2024-03-08 16:52:21'),
(22, NULL, 'p0fijw0OfDvOf8hkiUkws7M74y0mG8lWeIaa7Lbp.jpg', NULL, 'media/p0fijw0OfDvOf8hkiUkws7M74y0mG8lWeIaa7Lbp.jpg', '2024-08-08 19:35:04', '2024-08-08 19:35:04'),
(23, NULL, 'dI4rLIBr9u1TPe0qAGM7i3tki26Y9WOGiml7xcUB.webp', NULL, 'media/dI4rLIBr9u1TPe0qAGM7i3tki26Y9WOGiml7xcUB.webp', '2024-08-08 19:37:40', '2024-08-08 19:37:40'),
(24, NULL, 'piQWoDgJIQjugLjma8lvXhjZTPMgvQbivxN31frt.png', NULL, 'media/piQWoDgJIQjugLjma8lvXhjZTPMgvQbivxN31frt.png', '2024-08-08 19:39:36', '2024-08-08 19:39:36'),
(25, NULL, '6VW1UJV6D1FHCBTjGAZSQjY4EykjQAkXYJNJjNl4.jpg', NULL, 'media/6VW1UJV6D1FHCBTjGAZSQjY4EykjQAkXYJNJjNl4.jpg', '2024-08-25 17:19:10', '2024-08-25 17:19:10'),
(26, NULL, 'lTvgPfcoldftZ0mhUUKaorv5DtT8gN6zy7sEmcwm.jpg', NULL, 'media/lTvgPfcoldftZ0mhUUKaorv5DtT8gN6zy7sEmcwm.jpg', '2024-08-25 20:09:17', '2024-08-25 20:09:17'),
(27, NULL, 'c3e8LEcFHYzCLOWGBtU2N7aSFIB2F8uuZe8jgNiU.png', NULL, 'media/c3e8LEcFHYzCLOWGBtU2N7aSFIB2F8uuZe8jgNiU.png', '2024-08-25 20:11:51', '2024-08-25 20:11:51'),
(29, NULL, 'nie5LFRxXy2qeWh3UKiBpSVNsi0PUz7LBMcxdCxO.gif', NULL, 'media/nie5LFRxXy2qeWh3UKiBpSVNsi0PUz7LBMcxdCxO.gif', '2024-08-25 23:02:11', '2024-08-25 23:02:11'),
(30, NULL, 'tgzcwz4vfLnfjZ5HSQZWKtZKGQLL8ZJeKVYw7YG8.jpg', NULL, 'media/tgzcwz4vfLnfjZ5HSQZWKtZKGQLL8ZJeKVYw7YG8.jpg', '2024-08-26 16:26:28', '2024-08-26 16:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `i_p_addresses`
--

CREATE TABLE `i_p_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `frontimg` text DEFAULT NULL,
  `backimg` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(9, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2024_01_09_094218_create_sessions_table', 1),
(13, '2024_01_09_100510_create_binance_transactions_table', 2),
(14, '2024_01_09_100823_create_contents_table', 2),
(15, '2024_01_09_100945_create_coin_payments_table', 2),
(17, '2024_01_09_101447_create_crypto_records_table', 2),
(18, '2024_01_09_101636_create_deposits_table', 2),
(19, '2024_01_09_102130_create_faqs_table', 2),
(20, '2024_01_09_102224_create_images_table', 2),
(21, '2024_01_09_102403_create_kycs_table', 2),
(23, '2024_01_09_103015_create_notifications_table', 2),
(24, '2024_01_09_103105_create_plans_table', 2),
(25, '2024_01_09_103429_create_symbol_maps_table', 2),
(26, '2024_01_09_103605_create_tasks_table', 2),
(27, '2024_01_09_104109_create_testimonies_table', 2),
(28, '2024_01_09_104522_create_user_plans_table', 2),
(30, '2024_01_09_105209_create_payment_methods_table', 2),
(31, '2024_01_09_105736_create_withdrawals_table', 2),
(34, '2024_01_09_101146_create_crypto_accounts_table', 4),
(35, '2024_01_12_094330_create_permission_tables', 5),
(36, '2024_01_09_104843_create_transactions_table', 6),
(37, '2024_01_15_111417_create_rois_table', 6),
(38, '2024_01_09_110050_create_settings_table', 7),
(42, '2024_01_09_102612_create_trading_accounts_table', 8),
(44, '2024_02_12_141456_create_cache_table', 9),
(45, '2024_02_14_200248_create_activity_log_table', 10),
(46, '2024_02_14_200249_add_event_column_to_activity_log_table', 10),
(47, '2024_02_14_200250_add_batch_uuid_column_to_activity_log_table', 10),
(58, '2024_02_15_110633_add_to_settings_table', 11),
(60, '2024_02_15_192441_add_to_settings_table', 11),
(62, '2024_02_16_191204_add_more_fields_to_settings_table', 12),
(63, '2024_02_20_183244_create_crypto_currencies_table', 13),
(64, '2024_02_21_163414_create_i_p_addresses_table', 14),
(65, '2024_02_21_194631_add_to_settings_table', 15),
(71, '2024_02_22_180722_create_pages_table', 16),
(73, '2024_02_25_190056_create_email_templates_table', 17),
(74, '2024_03_14_230752_create_jobs_table', 18),
(76, '2024_05_15_085953_create_coinbases_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 3),
(23, 'App\\Models\\User', 2),
(23, 'App\\Models\\User', 26),
(23, 'App\\Models\\User', 30),
(23, 'App\\Models\\User', 36),
(23, 'App\\Models\\User', 42),
(23, 'App\\Models\\User', 43),
(23, 'App\\Models\\User', 44),
(23, 'App\\Models\\User', 45),
(23, 'App\\Models\\User', 46),
(23, 'App\\Models\\User', 48),
(23, 'App\\Models\\User', 50),
(23, 'App\\Models\\User', 51),
(26, 'App\\Models\\User', 14);

-- --------------------------------------------------------

INSERT INTO `users` (`name`, `username`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `customer_status`, `assigned_to`, `date_of_birth`, `address`, `country`, `phone_number`, `bank_name`, `account_name`, `account_number`, `swift_code`, `btc_address`, `eth_address`, `ltc_address`, `usdt_address`, `account_bal`, `roi`, `bonus`, `ref_bonus`, `received_signup_bonus`, `trade_mode`, `reffered_by`, `refferal_link`, `account_verify`, `status`, `withdrawal_otp`, `withdrawal_otp_expired_at`, `can_withdraw`, `can_deposit`, `email_preference`, `remember_token`, `current_team_id`, `profile_photo_path`, `is_admin`, `token_2fa_expiry`, `enable_2fa`, `admin_two_factor_code`, `pass_two_factor`, `timezone`, `created_at`, `updated_at`) VALUES
('Super Admin', 'admin', 'super@happ.com', '2024-01-11 21:49:25','$2y$12$OwbF3tv5jkZ5hnnZCAqhYebAAbWN7usE2k0Q75hsCoumridUzeuF2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Algeria', '09839934433', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0, 1, NULL, NULL, NULL, 'active', NULL, NULL, 1, 1, NULL, NULL, NULL, 'avatars/xwx2JR9tO8K0OcZDqk0tezfVJGkcqr57EiirgEc8.jpg', 1, NULL, 0, NULL, 1, NULL, '2024-01-09 21:27:12', '2024-08-26 16:04:27');

SET @last_id = LAST_INSERT_ID();

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\Models\User' , @last_id);

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `link_name` varchar(191) NOT NULL,
  `permalink` varchar(50) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` varchar(191) DEFAULT NULL,
  `show_breadcrumbs` tinyint(1) NOT NULL DEFAULT 0,
  `breadcrumb_background` varchar(191) DEFAULT NULL,
  `status` enum('active','draft') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `link_name`, `permalink`, `title`, `description`, `keywords`, `show_breadcrumbs`, `breadcrumb_background`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'Home', '/', 'Welcome to E-PandaPay', 'we are very much available', 'home,yours', 1, NULL, 'active', '2024-02-23 00:51:37', '2024-02-23 02:42:24'),
(3, 'About', 'About', '/about-us', 'About E-PandaPay', 'E-PandaPay introduction, purpose and features.', 'About Standard, Love us', 1, NULL, 'active', '2024-02-23 00:52:34', '2024-08-08 23:15:14'),
(4, 'Plans', 'Plans', '/investment-plans', 'Our system plans', 'Our system plans', 'plans', 1, NULL, 'active', '2024-02-23 00:52:53', '2024-08-05 15:42:09'),
(5, 'Faq', 'Faq', '/faqs', 'Our Frequently asked questions', 'Our Frequently asked questions', 'faqs', 1, NULL, 'active', '2024-02-23 00:53:56', '2024-08-05 15:46:29'),
(6, 'Contact', 'Contact Us', '/contact-us', 'Got Questions, Contact Us', 'Got Questions, Contact Us', 'Contact Us', 1, NULL, 'active', '2024-02-23 00:55:04', '2024-03-03 01:37:31'),
(7, 'Terms', 'Terms and Conditions', '/terms-and-conditions', 'Terms and Conditions', 'Terms and Conditions', 'Terms and Conditions', 1, NULL, 'active', '2024-02-23 00:55:57', '2024-03-10 02:21:31'),
(8, 'Footer', 'Footer', NULL, NULL, NULL, NULL, 0, NULL, 'active', '2024-02-23 01:44:30', '2024-02-23 01:44:30'),
(9, 'Auth', 'Auth', NULL, NULL, NULL, NULL, 0, NULL, 'active', '2024-02-26 00:34:11', '2024-02-26 00:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `minimum` decimal(8,2) DEFAULT NULL,
  `maximum` decimal(8,2) DEFAULT NULL,
  `charges_amount` decimal(8,2) DEFAULT NULL,
  `charges_type` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `wallet_address` text DEFAULT NULL,
  `coin` varchar(20) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `network` varchar(255) DEFAULT NULL,
  `methodtype` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `default_pay` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `minimum`, `maximum`, `charges_amount`, `charges_type`, `duration`, `type`, `img_url`, `bank_name`, `account_name`, `account_number`, `swift_code`, `wallet_address`, `coin`, `barcode`, `network`, `methodtype`, `status`, `default_pay`, `created_at`, `updated_at`, `note`) VALUES
(1, 'Bitcoin', 10.00, 300.00, 0.00, 'Percentage', 'Instant', 'both', NULL, NULL, NULL, NULL, NULL, 'bc1q4hdyp4h9wnwyxxmzel6hwu9zsnz4lryu97sk2w', 'BTC', NULL, '', 'crypto', 'active', 1, '2024-01-10 20:41:10', '2024-03-22 23:57:34', NULL),
(2, 'Ethereum', 20.00, 1000.00, 1.00, 'percentage', NULL, 'both', 'https://s2.coinmarketcap.com/static/img/coins/200x200/1027.png', 'Firstbank', 'Livesmart Acount', '883783728232', '324', 'sllskslss', 'ETH', NULL, 'BEP20', 'crypto', 'active', 1, '2024-02-20 16:39:23', '2024-03-22 23:57:49', 'Payment may take up to 2 Hours'),
(3, 'Litecoin', 100.00, 3000.00, 2.00, 'fixed', NULL, 'both', 'https://s2.coinmarketcap.com/static/img/coins/200x200/1027.png', NULL, NULL, NULL, NULL, 'ltc1q5ldhnkj7w2p9uel3d0cn6rj2ya2fukxrvmcl7e', 'LTC', 'barcodes/DOyk4iTGT79y73CxRwsYGCP91GuhkLU316YfdPY3.png', 'BEP20', 'crypto', 'active', 1, '2024-02-20 16:44:07', '2024-03-22 23:57:55', NULL),
(4, 'Bank Transfer', 100.00, 4500.00, 2.00, 'percentage', NULL, 'both', 'https://cdn-icons-png.flaticon.com/512/8043/8043680.png', 'Firstbank', 'Livesmart Acount', '883783728232', '3242332', NULL, NULL, NULL, NULL, 'currency', 'active', 1, '2024-02-20 16:47:56', '2024-03-22 23:57:55', 'Payment may take up to 2 Hours'),
(5, 'Paypal', 10.00, 0.00, 0.00, 'percentage', NULL, 'deposit', 'https://w7.pngwing.com/pngs/720/939/png-transparent-paypal-computer-icons-logo-paypal-blue-angle-service-thumbnail.png', '-', '-', '0', NULL, NULL, NULL, NULL, NULL, 'currency', 'active', 1, '2024-02-20 16:49:13', '2024-03-12 01:43:50', 'Payment may take up to 2 Hours'),
(7, 'Credit-Debit Card', 0.00, 0.00, 0.00, 'percentage', NULL, 'deposit', 'https://cdn-icons-png.flaticon.com/512/6963/6963703.png', '-', '-', '0', '-', NULL, NULL, NULL, NULL, 'currency', 'active', 1, '2024-03-11 18:08:35', '2024-03-11 18:08:35', 'Instant Payment'),
(8, 'BUSD', 20.00, 20.00, 1.00, 'percentage', NULL, 'both', NULL, NULL, NULL, NULL, NULL, 'jdjjdkd', 'BUSD', NULL, 'ERC20', 'crypto', 'active', 1, '2024-03-12 00:47:59', '2024-03-13 14:12:13', 'Instant Payment'),
(9, 'USDT', 90.00, 40.00, 2.00, 'percentage', NULL, 'both', NULL, NULL, NULL, NULL, NULL, 'fjjfkkf', 'USDT.TRC20', NULL, 'TRC20', 'crypto', 'active', 1, '2024-03-12 00:48:56', '2024-03-22 23:57:53', 'Instant Payment');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view users', 'web', '2024-01-12 19:42:54', '2024-01-12 19:42:54'),
(2, 'create user', 'web', '2024-01-12 19:43:16', '2024-01-12 19:43:16'),
(3, 'edit user', 'web', '2024-01-12 19:43:25', '2024-01-12 19:43:25'),
(4, 'delete user', 'web', '2024-01-12 19:43:35', '2024-01-12 19:43:35'),
(5, 'create investment plan', 'web', '2024-01-12 19:47:05', '2024-01-12 19:47:05'),
(6, 'edit investment plan', 'web', '2024-01-12 19:47:19', '2024-01-12 19:47:19'),
(7, 'view investment plan', 'web', '2024-01-12 19:47:27', '2024-01-12 19:47:27'),
(8, 'delete investment plan', 'web', '2024-01-12 19:47:34', '2024-01-12 19:47:34'),
(9, 'delete users plan', 'web', '2024-01-12 19:48:05', '2024-01-12 19:48:05'),
(10, 'view users plan', 'web', '2024-01-12 19:48:17', '2024-01-12 19:48:17'),
(11, 'edit users plan', 'web', '2024-01-12 19:48:43', '2024-01-12 19:48:43'),
(13, 'view deposits', 'web', '2024-01-12 19:50:04', '2024-01-12 19:50:04'),
(14, 'process deposits', 'web', '2024-01-12 19:50:24', '2024-01-12 19:50:24'),
(15, 'delete deposits', 'web', '2024-01-12 19:50:30', '2024-01-12 19:50:30'),
(16, 'delete withdrawals', 'web', '2024-01-12 19:51:14', '2024-01-12 19:51:14'),
(17, 'view withdrawals', 'web', '2024-01-12 19:51:21', '2024-01-12 19:51:21'),
(18, 'process withdrawals', 'web', '2024-01-12 19:51:30', '2024-01-12 19:51:30'),
(19, 'process kyc applications', 'web', '2024-01-12 19:52:00', '2024-01-12 19:52:00'),
(20, 'view kyc applications', 'web', '2024-01-12 19:52:09', '2024-01-12 19:52:09'),
(21, 'delete kyc applications', 'web', '2024-01-12 19:52:20', '2024-01-12 19:52:20'),
(22, 'view admin dashboard stats', 'web', '2024-01-13 00:05:29', '2024-01-13 00:05:29'),
(23, 'view users registration chart', 'web', '2024-01-13 00:05:41', '2024-01-13 00:05:41'),
(24, 'view transactions', 'web', '2024-01-13 01:26:45', '2024-01-13 01:26:45'),
(25, 'delete transactions', 'web', '2024-01-13 01:27:03', '2024-01-13 01:27:03'),
(26, 'perform bulk actions', 'web', '2024-01-13 01:28:33', '2024-01-13 01:28:33'),
(27, 'view settings', 'web', '2024-01-13 01:30:12', '2024-01-13 01:30:12'),
(28, 'view platform administration', 'web', '2024-01-13 01:30:34', '2024-01-13 01:30:34'),
(29, 'update roles & permissions', 'web', '2024-01-13 01:31:19', '2024-01-13 01:31:19'),
(30, 'view activty log', 'web', '2024-01-13 01:31:42', '2024-01-13 01:31:42'),
(31, 'delete activty log', 'web', '2024-01-13 01:31:51', '2024-01-13 01:31:51'),
(32, 'view cronjob', 'web', '2024-01-13 01:32:06', '2024-01-13 01:32:06'),
(33, 'perform system cleanup', 'web', '2024-01-13 01:32:22', '2024-01-13 01:32:22'),
(35, 'clear cache', 'web', '2024-01-13 01:33:07', '2024-01-13 01:33:07'),
(36, 'view system info', 'web', '2024-01-13 01:34:43', '2024-01-13 01:34:43'),
(37, 'perform system update', 'web', '2024-01-13 01:34:57', '2024-01-13 01:34:57'),
(38, 'update general settings', 'web', '2024-01-13 01:35:53', '2024-01-13 01:35:53'),
(39, 'update email settings', 'web', '2024-01-13 01:36:06', '2024-01-13 01:36:06'),
(40, 'update email templates', 'web', '2024-01-13 01:36:18', '2024-01-13 01:36:18'),
(41, 'update dashboard appearance', 'web', '2024-01-13 01:36:36', '2024-01-13 01:36:36'),
(42, 'update modules settings', 'web', '2024-01-13 01:36:50', '2024-01-13 01:36:50'),
(43, 'view payment methods', 'web', '2024-01-13 01:37:35', '2024-01-13 01:37:35'),
(44, 'add payment method', 'web', '2024-01-13 01:37:44', '2024-01-13 01:37:44'),
(45, 'edit payment method', 'web', '2024-01-13 01:37:53', '2024-01-13 01:37:53'),
(46, 'delete payment method', 'web', '2024-01-13 01:38:02', '2024-01-13 01:38:02'),
(47, 'update payment preference', 'web', '2024-01-13 01:38:20', '2024-01-13 01:38:20'),
(48, 'update coinpayment settings', 'web', '2024-01-13 01:38:38', '2024-01-13 01:38:38'),
(49, 'update stripe settings', 'web', '2024-01-13 01:38:53', '2024-01-13 01:38:53'),
(50, 'update paystack settings', 'web', '2024-01-13 01:39:02', '2024-01-13 01:39:02'),
(51, 'update flutterwave settings', 'web', '2024-01-13 01:39:12', '2024-01-13 01:39:12'),
(52, 'update binance settings', 'web', '2024-01-13 01:39:27', '2024-01-13 01:39:27'),
(53, 'update fund transfer settings', 'web', '2024-01-13 01:39:44', '2024-01-13 01:39:44'),
(58, 'update website settings', 'web', '2024-01-13 01:41:57', '2024-01-13 01:41:57'),
(59, 'update social login settings', 'web', '2024-01-13 01:42:40', '2024-01-13 01:42:40'),
(60, 'update control center', 'web', '2024-01-13 01:43:00', '2024-01-13 01:43:00'),
(61, 'update communication settings', 'web', '2024-01-13 01:43:19', '2024-01-13 01:43:19'),
(62, 'update preference', 'web', '2024-01-13 01:43:56', '2024-01-13 01:43:56'),
(63, 'see administrators', 'web', '2024-01-14 00:37:28', '2024-01-14 00:37:28'),
(64, 'change admin password', 'web', '2024-01-14 00:38:08', '2024-01-14 00:38:08'),
(65, 'delete admin', 'web', '2024-01-14 00:38:17', '2024-01-14 00:38:17'),
(66, 'edit admin details', 'web', '2024-01-14 00:38:37', '2024-01-14 00:38:37'),
(67, 'block and unblock admin', 'web', '2024-01-14 00:38:51', '2024-01-14 00:38:51'),
(68, 'create admin', 'web', '2024-01-14 01:15:56', '2024-01-14 01:15:56'),
(69, 'view tasks assigned to them', 'web', '2024-01-17 16:39:51', '2024-01-17 16:39:51'),
(70, 'delete task', 'web', '2024-01-17 16:40:09', '2024-01-17 16:40:09'),
(71, 'mark task as completed', 'web', '2024-01-17 16:40:30', '2024-01-17 16:40:30'),
(72, 'edit task', 'web', '2024-01-17 16:40:43', '2024-01-17 16:40:43'),
(73, 'add new task', 'web', '2024-01-17 16:41:54', '2024-01-17 16:41:54'),
(74, 'view all task', 'web', '2024-01-17 16:52:27', '2024-01-17 16:52:27'),
(75, 'export deposit record', 'web', '2024-01-17 19:39:01', '2024-01-17 19:39:01'),
(76, 'export withdrawal record', 'web', '2024-01-17 19:39:10', '2024-01-17 19:39:10'),
(77, 'see users plan profit history', 'web', '2024-01-17 20:01:40', '2024-01-17 20:01:40'),
(78, 'manually create deposit', 'web', '2024-01-31 01:20:51', '2024-01-31 01:20:51'),
(79, 'create new category', 'web', '2024-02-02 22:14:13', '2024-02-02 22:14:13'),
(80, 'manage categories', 'web', '2024-02-02 22:14:28', '2024-02-02 22:14:28'),
(81, 'delete category', 'web', '2024-02-02 22:14:36', '2024-02-02 22:14:36'),
(82, 'see membership menu', 'web', '2024-02-03 15:09:40', '2024-02-03 15:09:40'),
(83, 'manage courses', 'web', '2024-02-03 15:10:15', '2024-02-03 15:10:15'),
(84, 'manage lessons', 'web', '2024-02-03 15:10:32', '2024-02-03 15:10:32'),
(85, 'see signal menu', 'web', '2024-02-03 15:12:06', '2024-02-03 15:12:06'),
(86, 'see copytrade menu', 'web', '2024-02-03 15:12:24', '2024-02-03 15:12:24'),
(87, 'manage signal settings', 'web', '2024-02-08 15:42:59', '2024-02-08 15:42:59'),
(88, 'manage signals', 'web', '2024-02-08 15:43:11', '2024-02-08 15:43:11'),
(89, 'manage subscribers', 'web', '2024-02-08 15:43:23', '2024-02-08 15:43:23'),
(90, 'send emails', 'web', '2024-02-14 03:34:04', '2024-02-14 03:34:04'),
(91, 'manage general settings', 'web', '2024-02-16 19:48:42', '2024-02-16 19:48:42'),
(92, 'make deposit', 'web', '2024-02-20 02:10:57', '2024-02-20 02:10:57'),
(93, 'make withdrawal', 'web', '2024-02-20 02:11:12', '2024-02-20 02:11:12'),
(94, 'see profit history', 'web', '2024-02-20 02:11:51', '2024-02-20 02:11:51'),
(95, 'purchase plan', 'web', '2024-02-20 02:12:16', '2024-02-20 02:12:16'),
(96, 'see their plans', 'web', '2024-02-20 02:12:25', '2024-02-20 02:12:25'),
(97, 'refer users', 'web', '2024-02-20 02:12:40', '2024-02-20 02:12:40'),
(98, 'contact support', 'web', '2024-02-20 02:12:54', '2024-02-20 02:12:54'),
(99, 'see their transactions history', 'web', '2024-02-20 02:13:27', '2024-02-20 02:13:27'),
(100, 'update their profile', 'web', '2024-02-20 02:14:10', '2024-02-20 02:14:10'),
(101, 'update their withdrawal payment options', 'web', '2024-02-20 02:14:45', '2024-02-20 02:14:45'),
(102, 'change their password', 'web', '2024-02-20 02:15:05', '2024-02-20 02:15:05'),
(103, 'use two-factor authentication', 'web', '2024-02-20 02:15:37', '2024-02-20 02:15:37'),
(104, 'manage browser sessions', 'web', '2024-02-20 02:15:52', '2024-02-20 02:15:52'),
(105, 'delete their account', 'web', '2024-02-20 02:16:04', '2024-02-20 02:16:04'),
(106, 'update email preference', 'web', '2024-02-20 02:16:28', '2024-02-20 02:16:28'),
(107, 'see trade chart on dashboard', 'web', '2024-02-20 02:18:51', '2024-02-20 02:18:51'),
(108, 'see crypto swap menu', 'web', '2024-02-20 22:23:48', '2024-02-20 22:23:48'),
(109, 'manage assets', 'web', '2024-02-20 22:24:07', '2024-02-20 22:24:07'),
(110, 'manage swap settings', 'web', '2024-02-20 22:24:21', '2024-02-20 22:24:21'),
(111, 'update ref & other bonuses', 'web', '2024-02-21 02:45:59', '2024-02-21 02:45:59'),
(112, 'admin update account settings', 'web', '2024-03-05 02:06:34', '2024-03-05 02:06:34'),
(113, 'view other stats', 'web', '2024-03-06 16:29:39', '2024-03-06 16:29:39'),
(114, 'manually add profit', 'web', '2024-03-06 17:04:45', '2024-03-06 17:04:45'),
(115, 'manage copytrade settings', 'web', '2024-03-06 17:54:12', '2024-03-06 17:54:12'),
(116, 'view providers', 'web', '2024-03-06 17:54:23', '2024-03-06 17:54:23'),
(117, 'view symbolmaps', 'web', '2024-03-06 17:55:05', '2024-03-06 17:55:05'),
(118, 'manage signal subscribers', 'web', '2024-03-06 17:55:52', '2024-03-06 17:55:52'),
(120, 'update paypal settings', 'web', '2024-03-06 18:20:55', '2024-03-06 18:20:55'),
(121, 'manage recycle bin', 'web', '2024-03-23 23:02:31', '2024-03-23 23:02:31'),
(122, 'update coinbase settings', 'web', '2024-05-15 12:40:11', '2024-05-15 12:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `min_price` decimal(8,2) DEFAULT NULL,
  `max_price` decimal(8,2) DEFAULT NULL,
  `min_return` decimal(8,2) DEFAULT NULL,
  `max_return` decimal(8,2) DEFAULT NULL,
  `bonus` decimal(8,2) DEFAULT NULL,
  `expected_return` decimal(8,2) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `increment_interval` varchar(255) NOT NULL,
  `increment_type` varchar(255) NOT NULL,
  `increment_amount` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rois`
--

CREATE TABLE `rois` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_plan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `rate` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-01-12 18:39:48', '2024-01-12 18:39:48'),
(23, 'User', 'web', '2024-02-19 15:57:55', '2024-02-19 15:57:55'),
(26, 'Admin', 'web', '2024-03-06 18:24:37', '2024-03-06 18:24:37');

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
(5, 26),
(19, 26),
(20, 26),
(22, 26),
(23, 26),
(92, 23),
(93, 23),
(94, 23),
(95, 23),
(96, 23),
(97, 23),
(98, 23),
(99, 23),
(100, 23),
(101, 23),
(102, 23),
(103, 23),
(104, 23),
(106, 23),
(113, 26);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kYBvMaJZmCj56YckQEmuA9bCTdRWzxIrehYfvfe3', 3, '197.210.79.38', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 Edg/127.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczRuN2N0SjV5b0RkOXd1bFVlb2dVTHVQb3VFdFJFSGw0RFkxWjNVeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vb25saW5ldHJhZGVydjYuYnJseS54eXovYWRtaW4vcGxhdGZvcm0tYWRtaW5pc3RyYXRpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1724782882);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(50) DEFAULT NULL,
  `description` varchar(191) NOT NULL,
  `site_title` varchar(100) DEFAULT NULL,
  `site_address` varchar(50) DEFAULT NULL,
  `admin_base_url` varchar(100) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `notifiable_email` varchar(191) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `s_currency` varchar(10) DEFAULT NULL,
  `payment_mode` varchar(191) DEFAULT NULL,
  `location` varchar(191) DEFAULT NULL,
  `s_s_k` varchar(191) DEFAULT NULL,
  `s_p_k` varchar(191) DEFAULT NULL,
  `pp_cs` varchar(191) DEFAULT NULL,
  `pp_ci` varchar(191) DEFAULT NULL,
  `pp_app_id` varchar(191) DEFAULT NULL,
  `keywords` varchar(191) DEFAULT NULL,
  `enable_trade_mode` tinyint(1) NOT NULL DEFAULT 1,
  `enable_google_translate` tinyint(1) NOT NULL DEFAULT 0,
  `enable_weekend_trade` tinyint(1) NOT NULL DEFAULT 0,
  `timezone` varchar(50) DEFAULT NULL,
  `mail_server` varchar(191) DEFAULT NULL,
  `emailfrom` varchar(191) DEFAULT NULL,
  `emailfromname` varchar(191) DEFAULT NULL,
  `smtp_host` varchar(191) DEFAULT NULL,
  `smtp_port` varchar(8) DEFAULT NULL,
  `smtp_encrypt` varchar(10) DEFAULT NULL,
  `smtp_user` varchar(191) DEFAULT NULL,
  `smtp_password` varchar(191) DEFAULT NULL,
  `google_secret` varchar(191) DEFAULT NULL,
  `google_id` varchar(191) DEFAULT NULL,
  `google_redirect` varchar(191) DEFAULT NULL,
  `referral_commission` varchar(5) DEFAULT NULL,
  `referral_commission1` varchar(5) DEFAULT NULL,
  `referral_commission2` varchar(5) DEFAULT NULL,
  `referral_commission3` varchar(5) DEFAULT NULL,
  `referral_commission4` varchar(5) DEFAULT NULL,
  `referral_commission5` varchar(5) DEFAULT NULL,
  `signup_bonus` decimal(8,2) DEFAULT NULL,
  `deposit_bonus` decimal(8,2) DEFAULT NULL,
  `live_chat` text DEFAULT NULL,
  `enable_kyc` tinyint(1) NOT NULL DEFAULT 0,
  `enable_kyc_registration` tinyint(1) NOT NULL DEFAULT 0,
  `enable_withdrawal_otp` tinyint(1) NOT NULL DEFAULT 1,
  `enable_email_verification` tinyint(1) NOT NULL DEFAULT 1,
  `enable_social_login` tinyint(1) NOT NULL DEFAULT 0,
  `withdrawal_option` varchar(191) DEFAULT NULL,
  `deposit_option` varchar(191) DEFAULT NULL,
  `auto_merchant_option` varchar(191) DEFAULT NULL,
  `coinpayment_to_wallet` tinyint(1) DEFAULT 1,
  `auto_deposit_merchant` varchar(20) DEFAULT NULL,
  `enable_annoucement` tinyint(1) NOT NULL DEFAULT 0,
  `subscription_service` varchar(191) DEFAULT NULL,
  `return_capital` tinyint(1) NOT NULL DEFAULT 1,
  `should_cancel_plan` tinyint(1) NOT NULL DEFAULT 0,
  `subscription_type` varchar(50) DEFAULT NULL,
  `percentage_fee` decimal(8,2) DEFAULT NULL,
  `use_copytrade` tinyint(1) NOT NULL DEFAULT 1,
  `use_terms` tinyint(1) NOT NULL DEFAULT 1,
  `commission_type` varchar(50) DEFAULT NULL,
  `billing_period` varchar(50) DEFAULT NULL,
  `commission_fee` decimal(8,2) DEFAULT NULL,
  `monthlyfee` decimal(8,2) DEFAULT NULL,
  `quarterlyfee` decimal(8,2) DEFAULT NULL,
  `yearlyfee` decimal(8,2) DEFAULT NULL,
  `modules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`modules`)),
  `send_welcome_email` tinyint(1) DEFAULT 1,
  `edit_email_verification_mail` tinyint(1) DEFAULT 0,
  `install_type` varchar(15) DEFAULT 'Main-Domain',
  `receive_deposit_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_withdrawal_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_buyplan_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_kyc_submission_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_expired_plan_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_trade_account_submission_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_signal_subscribe_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_buy_course_email` tinyint(1) NOT NULL DEFAULT 1,
  `receive_payment_method_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_deposit_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_withdrawal_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_buyplan_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_expired_plan_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_trade_request_success_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_signal_subscribe_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_buy_course_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_kyc_status_email` tinyint(1) NOT NULL DEFAULT 1,
  `send_roi_email` tinyint(1) DEFAULT 1,
  `software_version` decimal(8,2) NOT NULL DEFAULT 6.00,
  `software_has_update` tinyint(1) NOT NULL DEFAULT 0,
  `redirect_url` varchar(191) DEFAULT NULL,
  `website_theme` varchar(191) DEFAULT NULL,
  `referral_proffit_from` varchar(191) DEFAULT NULL,
  `theme` varchar(191) DEFAULT NULL,
  `ib_link` varchar(191) DEFAULT NULL,
  `themes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`themes`)),
  `credit_card_provider` varchar(50) DEFAULT NULL,
  `deduction_option` varchar(191) DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `annoucement` text DEFAULT NULL,
  `merchant_key` varchar(191) DEFAULT NULL,
  `paystack_public_key` varchar(191) DEFAULT NULL,
  `paystack_secret_key` varchar(191) DEFAULT NULL,
  `paystack_url` varchar(191) DEFAULT NULL,
  `paystack_email` varchar(191) DEFAULT NULL,
  `use_crypto_feature` tinyint(1) NOT NULL DEFAULT 1,
  `crypto_charges` decimal(8,2) DEFAULT NULL,
  `currency_rate` decimal(8,2) DEFAULT NULL,
  `minamt` decimal(8,2) DEFAULT NULL,
  `use_transfer` tinyint(1) NOT NULL DEFAULT 1,
  `min_transfer` decimal(8,2) DEFAULT NULL,
  `purchase_code` varchar(191) DEFAULT NULL,
  `old_version` varchar(191) NOT NULL DEFAULT '6',
  `transfer_charges` decimal(8,2) DEFAULT NULL,
  `binance_secret_key` varchar(191) DEFAULT NULL,
  `binance_api_key` varchar(191) DEFAULT NULL,
  `flw_secret_hash` varchar(191) DEFAULT NULL,
  `flw_secret_key` varchar(191) DEFAULT NULL,
  `flw_public_key` varchar(191) DEFAULT NULL,
  `telegram_bot_api` varchar(191) DEFAULT NULL,
  `cp_p_key` varchar(191) DEFAULT NULL,
  `cp_pv_key` varchar(191) DEFAULT NULL,
  `cp_m_id` varchar(191) DEFAULT NULL,
  `cp_ipn_secret` varchar(191) DEFAULT NULL,
  `cp_debug_email` varchar(191) DEFAULT NULL,
  `password_validation_rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`password_validation_rules`)),
  `spa_mode` tinyint(1) NOT NULL DEFAULT 0,
  `progress_bar_color` varchar(10) NOT NULL DEFAULT '#2299dd',
  `use_api_price_for_swap` tinyint(1) DEFAULT 1,
  `swap_fee` decimal(8,2) DEFAULT NULL,
  `show_plans_on_home_page` tinyint(1) DEFAULT 1,
  `instagram_social_link` varchar(191) DEFAULT NULL,
  `coinbase_apikey` varchar(191) DEFAULT NULL,
  `coinbase_apiversion` varchar(191) DEFAULT NULL,
  `x_social_link` varchar(191) DEFAULT NULL,
  `facebook_social_link` varchar(191) DEFAULT NULL,
  `home_theme` varchar(7) DEFAULT 'Home1',
  `site_in_maintenance_mode` tinyint(1) DEFAULT 0,
  `maintenance_mode_token` text DEFAULT NULL,
  `admin_dashboard_logo_size` int(11) NOT NULL DEFAULT 20,
  `user_dashboard_logo_size` int(11) NOT NULL DEFAULT 20,
  `auth_pages_logo_size` int(11) DEFAULT 10,
  `website_logo_size` int(11) DEFAULT 10,
  `delete_records_older_than_days` int(11) NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `description`, `site_title`, `site_address`, `admin_base_url`, `logo`, `favicon`, `contact_email`, `notifiable_email`, `currency`, `s_currency`, `payment_mode`, `location`, `s_s_k`, `s_p_k`, `pp_cs`, `pp_ci`, `pp_app_id`, `keywords`, `enable_trade_mode`, `enable_google_translate`, `enable_weekend_trade`, `timezone`, `mail_server`, `emailfrom`, `emailfromname`, `smtp_host`, `smtp_port`, `smtp_encrypt`, `smtp_user`, `smtp_password`, `google_secret`, `google_id`, `google_redirect`, `referral_commission`, `referral_commission1`, `referral_commission2`, `referral_commission3`, `referral_commission4`, `referral_commission5`, `signup_bonus`, `deposit_bonus`, `live_chat`, `enable_kyc`, `enable_kyc_registration`, `enable_withdrawal_otp`, `enable_email_verification`, `enable_social_login`, `withdrawal_option`, `deposit_option`, `auto_merchant_option`, `coinpayment_to_wallet`, `auto_deposit_merchant`, `enable_annoucement`, `subscription_service`, `return_capital`, `should_cancel_plan`, `subscription_type`, `percentage_fee`, `use_copytrade`, `use_terms`, `commission_type`, `billing_period`, `commission_fee`, `monthlyfee`, `quarterlyfee`, `yearlyfee`, `modules`, `send_welcome_email`, `edit_email_verification_mail`, `install_type`, `receive_deposit_email`, `receive_withdrawal_email`, `receive_buyplan_email`, `receive_kyc_submission_email`, `receive_expired_plan_email`, `receive_trade_account_submission_email`, `receive_signal_subscribe_email`, `receive_buy_course_email`, `receive_payment_method_email`, `send_deposit_email`, `send_withdrawal_email`, `send_buyplan_email`, `send_expired_plan_email`, `send_trade_request_success_email`, `send_signal_subscribe_email`, `send_buy_course_email`, `send_kyc_status_email`, `send_roi_email`, `software_version`, `software_has_update`, `redirect_url`, `website_theme`, `referral_proffit_from`, `theme`, `ib_link`, `themes`, `credit_card_provider`, `deduction_option`, `welcome_message`, `annoucement`, `merchant_key`, `paystack_public_key`, `paystack_secret_key`, `paystack_url`, `paystack_email`, `use_crypto_feature`, `crypto_charges`, `currency_rate`, `minamt`, `use_transfer`, `min_transfer`, `purchase_code`, `old_version`, `transfer_charges`, `binance_secret_key`, `binance_api_key`, `flw_secret_hash`, `flw_secret_key`, `flw_public_key`, `telegram_bot_api`, `cp_p_key`, `cp_pv_key`, `cp_m_id`, `cp_ipn_secret`, `cp_debug_email`, `password_validation_rules`, `spa_mode`, `progress_bar_color`, `use_api_price_for_swap`, `swap_fee`, `show_plans_on_home_page`, `instagram_social_link`, `coinbase_apikey`, `coinbase_apiversion`, `x_social_link`, `facebook_social_link`, `home_theme`, `site_in_maintenance_mode`, `maintenance_mode_token`, `admin_dashboard_logo_size`, `user_dashboard_logo_size`, `auth_pages_logo_size`, `website_logo_size`, `delete_records_older_than_days`, `created_at`, `updated_at`) VALUES
(1, 'E-PandaPay', 'E-PandaPay', 'Welcome to E-PandaPay', 'https://onlinetrnew.test', '/admin', 'settings/88H9WNBoRXRhNY65GjBLGFZfzwUy1pEIUw7H1Bza.png', 'settings/hksELWkej0sLiGAsVNreGCriSD3u3vLeGPkY1DQi.png', 'support@bitproffittrades.com', 'me@gmail.com', ' $', 'USD ', NULL, NULL, 'sk_test_51JP8qpSBWKZBQRLPWqHkFM8oqFEAqXLAaH3S8byZF73X0UycxijVyfebcyu6OVoZ8eeAelr3js3ADYIGU22Dk2Vo00kGkdE9xP', 'pk_test_51JP8qpSBWKZBQRLPUIfQVYfUGly65fb1LiPUwAUajKy1nVM9Rvly3v3hQLvXnRqrWCrnUNz1qPQHNSxE689tSAoL00B1iOTNfd', '-', '-', NULL, NULL, 1, 0, 1, 'Africa/Lagos', 'sendmail', 'onlintrade@happ.com', 'Online Trade', 'smtp.mailtrap.io', '2525', 'tls', '', '', '-', '-', 'https://onlinetrade.test/auth/google/callback', '10', '5', '3.2', '2.34', '1', '0.51', 0.00, 0.00, '', 1, 0, 0, 1, 0, 'manual', 'manual', 'Coinpayment', 1, 'Coinpayment', 0, NULL, 1, 0, NULL, NULL, 1, 0, NULL, NULL, NULL, 30.00, 40.00, 50.00, '{\"signal\":\"false\",\"cryptoswap\":\"true\",\"investment\":\"true\",\"membership\":\"false\",\"subscription\":\"false\"}', 1, 0, 'Main-Domain', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 6.00, 0, '', '#c44aaa', 'Deposit', 'millage', 'https://dudi.dev/optimize-laravel-database-queries/', '[\"purpose\", \"millage\"]', 'Stripe', 'userRequest', 'Welcome to E-PandaPay', '', '', '-', '-', 'https://api.paystack.co', 'mail@gmail.com', 1, NULL, NULL, 5.00, 1, 5.00, '', '6', 0.00, '-', '-', '-', '-', '-', '', '-', '-', '-', '-', 'mail@m', '{\"letters\": \"0\", \"numbers\": \"0\", \"symbols\": \"0\", \"leastChar\": \"8\", \"mixedCase\": \"0\", \"uncompromised\": \"0\"}', 0, '#ffffff', 1, 0.00, 1, 'https://www.instagram.com/', '-', '2018-03-22', 'https://twitter.com/', 'https://web.facebook.com/', 'home2', 0, '', 139, 140, 170, 160, 2, '2024-01-28 22:10:47', '2024-08-27 22:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `symbol_maps`
--

CREATE TABLE `symbol_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_symbol` varchar(255) NOT NULL,
  `to_symbol` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_key` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `what_is_said` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonies`
--

INSERT INTO `testimonies` (`id`, `ref_key`, `position`, `name`, `what_is_said`, `picture`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Driver', 'Victory Oghene Efekpogua', 'I love this platform, its a good one and a media liver that movs the light forward ', 'media/sTnEPzjF31G5vcz3DYZYcCWj3Tu9hTm3kYQ4URFa.webp', '2024-02-21 22:23:11', '2024-02-22 13:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `trading_accounts`
--

CREATE TABLE `trading_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `meta_account_id` text DEFAULT NULL,
  `login` varchar(191) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `platform` varchar(191) DEFAULT NULL,
  `account_type` varchar(191) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `leverage` varchar(191) DEFAULT NULL,
  `server` varchar(191) DEFAULT NULL,
  `options` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `copying_trade` tinyint(1) NOT NULL DEFAULT 0,
  `is_deployed` tinyint(1) NOT NULL DEFAULT 0,
  `deployment_status` varchar(191) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `reminded_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `narration` varchar(191) DEFAULT NULL,
  `payment_channel` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `profit_earned` decimal(8,2) DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `inv_duration` varchar(255) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `next_growth` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `column` varchar(255) DEFAULT NULL,
  `to_deduct` decimal(8,2) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `paydetails` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `binance_transactions`
--
ALTER TABLE `binance_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binance_transactions_user_id_foreign` (`user_id`);

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
-- Indexes for table `coinbases`
--
ALTER TABLE `coinbases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coinbases_user_id_foreign` (`user_id`);

--
-- Indexes for table `coin_payments`
--
ALTER TABLE `coin_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coin_payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_accounts`
--
ALTER TABLE `crypto_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crypto_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_records`
--
ALTER TABLE `crypto_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crypto_records_user_id_foreign` (`user_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_user_id_foreign` (`user_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `i_p_addresses`
--
ALTER TABLE `i_p_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kycs`
--
ALTER TABLE `kycs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kycs_email_unique` (`email`),
  ADD KEY `kycs_user_id_foreign` (`user_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rois`
--
ALTER TABLE `rois`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rois_user_id_foreign` (`user_id`),
  ADD KEY `rois_user_plan_id_foreign` (`user_plan_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `symbol_maps`
--
ALTER TABLE `symbol_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trading_accounts`
--
ALTER TABLE `trading_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trading_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_plans_plan_id_foreign` (`plan_id`),
  ADD KEY `user_plans_user_id_foreign` (`user_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `binance_transactions`
--
ALTER TABLE `binance_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coinbases`
--
ALTER TABLE `coinbases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coin_payments`
--
ALTER TABLE `coin_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `crypto_accounts`
--
ALTER TABLE `crypto_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `crypto_records`
--
ALTER TABLE `crypto_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `i_p_addresses`
--
ALTER TABLE `i_p_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kycs`
--
ALTER TABLE `kycs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rois`
--
ALTER TABLE `rois`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `symbol_maps`
--
ALTER TABLE `symbol_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trading_accounts`
--
ALTER TABLE `trading_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binance_transactions`
--
ALTER TABLE `binance_transactions`
  ADD CONSTRAINT `binance_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coinbases`
--
ALTER TABLE `coinbases`
  ADD CONSTRAINT `coinbases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coin_payments`
--
ALTER TABLE `coin_payments`
  ADD CONSTRAINT `coin_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crypto_accounts`
--
ALTER TABLE `crypto_accounts`
  ADD CONSTRAINT `crypto_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crypto_records`
--
ALTER TABLE `crypto_records`
  ADD CONSTRAINT `crypto_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kycs`
--
ALTER TABLE `kycs`
  ADD CONSTRAINT `kycs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `rois`
--
ALTER TABLE `rois`
  ADD CONSTRAINT `rois_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rois_user_plan_id_foreign` FOREIGN KEY (`user_plan_id`) REFERENCES `user_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trading_accounts`
--
ALTER TABLE `trading_accounts`
  ADD CONSTRAINT `trading_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD CONSTRAINT `user_plans_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_plans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

UPDATE `users`
SET 
    account_bal = COALESCE(account_bal, 0),
    roi = COALESCE(roi, 0),
    bonus = COALESCE(bonus, 0),
    ref_bonus = COALESCE(ref_bonus, 0)
WHERE 
    account_bal IS NULL OR
    roi IS NULL OR
    bonus IS NULL OR
    ref_bonus IS NULL;

  
ALTER TABLE `users` 
MODIFY `account_bal` DECIMAL(16, 8) DEFAULT 0,
MODIFY `roi` DECIMAL(16, 8) DEFAULT 0,
MODIFY `bonus` DECIMAL(16, 8) DEFAULT 0,
MODIFY `ref_bonus` DECIMAL(16, 8) DEFAULT 0;

    
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
