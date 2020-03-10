/*
Navicat MySQL Data Transfer

Source Server         : yp
Source Server Version : 50725
Source Host           : localhost:3306
Source Database       : lar

Target Server Type    : MYSQL
Target Server Version : 50725
File Encoding         : 65001

Date: 2020-03-10 22:31:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `hooks`
-- ----------------------------
DROP TABLE IF EXISTS `hooks`;
CREATE TABLE `hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller_action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hooks_name_unique` (`name`),
  UNIQUE KEY `hooks_content_unique` (`content`),
  UNIQUE KEY `hooks_controller_action_unique` (`controller_action`),
  UNIQUE KEY `hooks_api_unique` (`api`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of hooks
-- ----------------------------
INSERT INTO `hooks` VALUES ('1', '用户数据获取', '用户数据获取', 'JwtController@getdata', '/jwt/userc/getdata', '1', '2020-03-10 22:01:58', '2020-03-10 22:01:58');

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', 'dashboard', '0', '系统首页', 'el-icon-lx-home', '1', 'dashboard', null, null);
INSERT INTO `menus` VALUES ('2', '', '0', '系统管理', 'el-icon-user', '1', '', null, null);
INSERT INTO `menus` VALUES ('3', 'userc', '2', '用户管理', '', '1', 'userc', null, null);
INSERT INTO `menus` VALUES ('4', 'role', '2', '角色管理', '', '1', 'role', null, null);
INSERT INTO `menus` VALUES ('5', 'limit', '2', '权限管理', '', '1', 'limit', null, null);
INSERT INTO `menus` VALUES ('6', 'menu', '2', '菜单管理', '', '1', 'menu', null, null);
INSERT INTO `menus` VALUES ('7', '', '2', '接口管理', '', '1', 'hook', '2020-03-10 21:17:57', '2020-03-10 21:17:57');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('5', '2020_03_05_205140_create_table_menus', '2');
INSERT INTO `migrations` VALUES ('6', '2020_03_05_215018_create_table_roles', '3');
INSERT INTO `migrations` VALUES ('8', '2020_03_10_213827_create_table_hooks', '4');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `auth` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '', '1,2,3,4,5,6,7', '1', null, '2020-03-10 21:23:16');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1', 'admin', '674689@qq.com', '$2y$10$y4JHaXlErq4kM8zLSV9sT.sxWUaXx1.95OYFjN.AighVS61q47LrC', null, '2020-02-28 22:29:14', '2020-03-08 12:48:23', '0', '0');
INSERT INTO `users` VALUES ('2', null, 'ypjj', '674689456@qq.com', '$2y$10$J.zFymO4ceoJ4cQ8RfJ6s.Gn6sFM0KtDXbg4vu1ebTK.0XZVNe6Su', null, '2020-02-29 22:51:11', '2020-02-29 22:51:11', '0', '1');
INSERT INTO `users` VALUES ('5', null, 'ypkk', '6746894516@qq.com', '$2y$10$Mvx3xnp/Nmuw4qvWbgZYwuGI/Z8InWSLlgZpTfKGrR/2qJOjwxhvK', null, '2020-02-29 22:52:24', '2020-02-29 22:52:24', '0', '1');
INSERT INTO `users` VALUES ('6', null, 'uopo', '456@163.com', '$2y$10$0Ta0EeAhI92pWoQOEFxytOjX95DJsrAT4FYjBfnMlYYSnBKtvK61m', null, '2020-02-29 22:53:08', '2020-02-29 22:53:08', '0', '1');
INSERT INTO `users` VALUES ('7', null, 'Yang', '65656@qq.com', '$2y$10$Q1r.8CK5YIMXWvLufcOLIuF0WbYUszoFOND5RmEhsNwlfDBs/gsya', null, '2020-02-29 22:53:39', '2020-02-29 22:53:39', '0', '1');
