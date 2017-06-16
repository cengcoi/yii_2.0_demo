/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii_demo

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-15 14:29:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(60) NOT NULL COMMENT '密码',
  `salt` char(29) NOT NULL COMMENT '随机码',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT '验证令牌',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台管理用户表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '$2y$11$37213e8866a10fe299e12O57gSgOANSWl51i6JX7GHtR4mI0vCuhW', '$2y$11$37213e8866a10fe299e12b', 'bb6947ec5666f3c6fe3530aab11d2a1b', '1', '0');

-- ----------------------------
-- Table structure for admin_access
-- ----------------------------
DROP TABLE IF EXISTS `admin_access`;
CREATE TABLE `admin_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `access_name` varchar(100) NOT NULL DEFAULT '' COMMENT '权限名字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`access_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='后台用户权限表';

-- ----------------------------
-- Records of admin_access
-- ----------------------------

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `menu_text` varchar(200) NOT NULL DEFAULT '' COMMENT '菜单文字',
  `icon_alias` varchar(100) NOT NULL DEFAULT 'th-large' COMMENT '图标别名，使用fontawesomeicon中fa后面带的别名，不需要中横杠',
  `url` varchar(100) NOT NULL DEFAULT 'home/index' COMMENT '路径，基本上是yii中生成路径带的参数。',
  `access_name` varchar(100) NOT NULL DEFAULT 'home' COMMENT 'url别名，由controller或者加action组成',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `is_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `rank` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，越大排越前',
  `is_sys` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为系统菜单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台用户菜单表';

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '操作', 'th-large', '#', 'home', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('2', '用户操作', 'caret-right', 'home/index', 'home_index', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(100) NOT NULL COMMENT '角色名字',
  `access` text COMMENT '赋值字符',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台用户角色表';

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('1', '管理员', '');

