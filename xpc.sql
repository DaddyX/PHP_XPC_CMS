# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: xpc
# ------------------------------------------------------
# Server version 5.5.38

#
# Source for table db_admin
#

DROP TABLE IF EXISTS `db_admin`;
CREATE TABLE `db_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(32) DEFAULT NULL COMMENT '管理员账号',
  `password` varchar(36) DEFAULT NULL COMMENT '管理员密码',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '最后登录IP',
  `login_count` mediumint(8) NOT NULL COMMENT '登录次数',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账户状态，禁用为0   启用为1',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Dumping data for table db_admin
#

LOCK TABLES `db_admin` WRITE;
/*!40000 ALTER TABLE `db_admin` DISABLE KEYS */;
INSERT INTO `db_admin` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','',1489483882,'127.0.0.1',303,'',1,1437979578);
/*!40000 ALTER TABLE `db_admin` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table db_web_menu
#

DROP TABLE IF EXISTS `db_web_menu`;
CREATE TABLE `db_web_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `func` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '级别',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名字',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '启用状态 1启用 2关闭',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

#
# Dumping data for table db_web_menu
#

LOCK TABLES `db_web_menu` WRITE;
/*!40000 ALTER TABLE `db_web_menu` DISABLE KEYS */;
INSERT INTO `db_web_menu` VALUES (2,'Authrule/index',1,0,'模块管理',1);
INSERT INTO `db_web_menu` VALUES (3,'Authrule/save',2,2,'添加模块',1);
INSERT INTO `db_web_menu` VALUES (4,'Authrule/index',2,2,'模块列表',1);
INSERT INTO `db_web_menu` VALUES (5,'Index/main',2,2,'产品参数',1);
INSERT INTO `db_web_menu` VALUES (6,'Explain/index',2,2,'产品分类',1);
INSERT INTO `db_web_menu` VALUES (7,'Index/main',2,2,'产品标签',1);
INSERT INTO `db_web_menu` VALUES (8,'Explain/index',2,2,'高级设置',1);
INSERT INTO `db_web_menu` VALUES (9,'Explain/list_index',1,0,'文章管理',1);
INSERT INTO `db_web_menu` VALUES (10,'Index/main',2,9,'文章列表',1);
INSERT INTO `db_web_menu` VALUES (11,'Explain/index',2,9,'文章分类',1);
INSERT INTO `db_web_menu` VALUES (12,'Explain/list_index',2,9,'高级设置',1);
INSERT INTO `db_web_menu` VALUES (13,'Explain/index',1,0,'图册管理',1);
INSERT INTO `db_web_menu` VALUES (14,'Explain/list_index',2,13,'创建图册',1);
INSERT INTO `db_web_menu` VALUES (15,'Explain/index',2,13,'管理图册',1);
INSERT INTO `db_web_menu` VALUES (17,'Web/index',1,0,'袁立峰',1);
/*!40000 ALTER TABLE `db_web_menu` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
