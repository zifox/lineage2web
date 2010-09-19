/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : l2web

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2010-09-19 21:25:27
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `news_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(65) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(32) CHARACTER SET latin1 NOT NULL,
  `desc` text CHARACTER SET latin1 NOT NULL,
  `edited` datetime DEFAULT NULL,
  `edited_by` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'Heroes', '2010-09-17 21:00:00', '80MXM08', '<b>Heroes</b><br />A player who has recorded the highest score in each class in the Grand Olympiad, a Player vs. Player tournament played among the Noblesse, is conferred the title of Hero. Heroes are awarded exclusive weapons, skills, abilities and a distinct aura.<br /><b>Hero Abilities</b><br />Heroes are able to use weapons provided for their exclusive use. Once selected, weapons cannot be replaced. However, after one month, all weapons are automatically returned and Hero players will be abl', '0000-00-00 00:00:00', '80MXM08');
