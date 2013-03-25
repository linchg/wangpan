-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: wangpan
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `commision`
--

DROP TABLE IF EXISTS `commision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commision` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `income` float NOT NULL COMMENT '收入',
  `eff_time` int(11) NOT NULL COMMENT '有效下载次数',
  `eff_time_before` int(11) NOT NULL COMMENT '前天有效下载次数IP',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '日期',
  `statis_time` int(11) NOT NULL DEFAULT '0' COMMENT '统计时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commision`
--

LOCK TABLES `commision` WRITE;
/*!40000 ALTER TABLE `commision` DISABLE KEYS */;
/*!40000 ALTER TABLE `commision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory`
--

DROP TABLE IF EXISTS `directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directory` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `did` int(11) NOT NULL DEFAULT '0' COMMENT '目录序列号',
  `name` varchar(200) NOT NULL COMMENT '目录名称',
  `add_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户目录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory`
--

LOCK TABLES `directory` WRITE;
/*!40000 ALTER TABLE `directory` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '文件用户ID',
  `fid` int(11) NOT NULL COMMENT '文件ID',
  `down_time` int(11) NOT NULL COMMENT '下载时间',
  `down_ip` varchar(20) NOT NULL COMMENT '下载IP',
  `down_uid` int(11) NOT NULL DEFAULT '0' COMMENT '下载用户ID',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件下载表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads`
--

LOCK TABLES `downloads` WRITE;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange`
--

DROP TABLE IF EXISTS `exchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '递交时间',
  `ex_time` int(11) NOT NULL DEFAULT '0' COMMENT '兑换时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange`
--

LOCK TABLES `exchange` WRITE;
/*!40000 ALTER TABLE `exchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `did` int(11) NOT NULL COMMENT '目录序列号',
  `name` varchar(200) NOT NULL COMMENT '文件名称',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `down_times` int(11) NOT NULL DEFAULT '0' COMMENT '下载次数',
  `add_time` int(11) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户文件表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `name` varchar(80) NOT NULL COMMENT '商品名',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '所需积分',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `pic` varchar(80) NOT NULL COMMENT '商品图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城物品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `pid` int(11) NOT NULL COMMENT '项目ID',
  `points` int(11) NOT NULL COMMENT '积分量',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分明细表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `points`
--

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;
/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--


DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `username` varchar(80) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(80) DEFAULT '' COMMENT '电子邮件',
  `nick_name` varchar(80) DEFAULT '' COMMENT '昵称',
  `down_counts` int(12) DEFAULT 0 COMMENT '下载量',
  `total_money` int(12) DEFAULT 0 COMMENT '获得总拥金',
  `space_name` varchar(80) NOT NULL COMMENT '空间名称',
  `space_desc` text COMMENT '空间描述',
  `login_time` int(11) NOT NULL COMMENT '登录时间',
  `login_num` int(11) DEFAULT '0' COMMENT '登录次数',
  `points` int(11) DEFAULT '0' COMMENT '积分',
  `login_ip` varchar(20) NOT NULL COMMENT '登录IP',
  `add_time` int(11) NOT NULL COMMENT '创建时间',
  `add_ip` varchar(20) NOT NULL COMMENT '创建IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_xia`
--

DROP TABLE IF EXISTS `user_xia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_xia` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `xid` int(11) NOT NULL COMMENT '下线用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户下线表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_xia`
--

LOCK TABLES `user_xia` WRITE;
/*!40000 ALTER TABLE `user_xia` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_xia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID 自增',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `sum` float NOT NULL COMMENT '金额',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `offer_time` int(11) NOT NULL DEFAULT '0' COMMENT '提现时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-24 19:38:50
