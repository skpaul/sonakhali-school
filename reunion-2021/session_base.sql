/*
Navicat MySQL Data Transfer

Source Server         : MySqlConnection
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : bar_council

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2021-06-02 21:27:43
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `session_base`
-- ----------------------------
DROP TABLE IF EXISTS `session_base`;
CREATE TABLE `session_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(50) NOT NULL,
  `sessionName` varchar(100) NOT NULL,
  `sessionDatetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of session_base
-- ----------------------------
INSERT INTO session_base VALUES ('1', '60b738a208dfd1.05595191', '20171', '2021-06-02 21:24:36');
INSERT INTO session_base VALUES ('3', '60b76ec36a5933.81861574', '201720', '2021-06-02 21:03:34');
