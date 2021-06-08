/*
Navicat MySQL Data Transfer

Source Server         : MySqlConnection
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : bar_council

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2021-06-02 21:27:49
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `session_values`
-- ----------------------------
DROP TABLE IF EXISTS `session_values`;
CREATE TABLE `session_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(50) NOT NULL,
  `keyName` varchar(100) NOT NULL,
  `keyValue` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of session_values
-- ----------------------------
INSERT INTO session_values VALUES ('1', '60b738a208dfd1.05595191', 'userDetails', 0x7B2272656759656172223A2232303137222C227265674E6F223A2231227D);
INSERT INTO session_values VALUES ('3', '60b76ec36a5933.81861574', 'userDetails', 0x7B2272656759656172223A2232303137222C227265674E6F223A223230227D);
