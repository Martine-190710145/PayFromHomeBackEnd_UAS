/*
 Navicat Premium Data Transfer

 Source Server         : ID PROGRAMMER
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost:3306
 Source Schema         : paid_payfromhome-backend

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 16/12/2021 18:50:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `serial_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nominal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `payment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `user_id` int(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (6, 'LISTRIK', '7272773', '100000', 'balance', 'Thu Dec 16 14:50:55 GMT+07:00 2021', 7, '2021-12-16 07:50:56', '2021-12-16 07:50:56');
INSERT INTO `transactions` VALUES (7, 'LISTRIK', '172782828', '100000', 'balance', 'Thu Dec 16 14:51:51 GMT+07:00 2021', 7, '2021-12-16 07:51:52', '2021-12-16 07:51:52');
INSERT INTO `transactions` VALUES (10, 'WATER', '177272727', '439916', 'balance', 'Thu Dec 16 14:58:20 GMT+07:00 2021', 7, '2021-12-16 07:58:21', '2021-12-16 07:58:21');
INSERT INTO `transactions` VALUES (11, 'LISTRIK', '36363636', '15000', 'transfer', 'Thu Dec 16 15:28:54 GMT+07:00 2021', 7, '2021-12-16 08:28:54', '2021-12-16 08:28:54');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `balance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `email_verified_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (7, 'Yudha', 'adiyudha323@gmail.com', '$2y$10$pMncMJii0cWJ1s3O/ouUP.qJcQE.szRU5g64Y25ii.cdjG902N/lS', '360084', 'VqedDaFNLUYAbh03ja0qJWz74418y791', '2021-12-16 06:11:14', '2021-12-16 07:58:21', '2021-12-16 05:58:53');

SET FOREIGN_KEY_CHECKS = 1;
