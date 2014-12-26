-- MySQL dump 10.13  Distrib 5.1.62, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: sync_dev
-- ------------------------------------------------------
-- Server version	5.1.62-log

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
-- Table structure for table `sync_configs`
--

DROP TABLE IF EXISTS `sync_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_configs` (
  `c_k` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
  `c_v` varchar(255) NOT NULL DEFAULT '' COMMENT '值',
  `c_t` tinyint(3) unsigned DEFAULT '0' COMMENT '参数类型',
  UNIQUE KEY `c_k` (`c_k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_files`
--

DROP TABLE IF EXISTS `sync_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_list` (
  `l_hash` char(32) NOT NULL DEFAULT '' COMMENT '文件url的md5',
  `l_data` text NOT NULL COMMENT '格式话的文件部署结构',
  UNIQUE KEY `l_hash` (`l_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_history`
--

DROP TABLE IF EXISTS `sync_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_history` (
  `h_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上线历史单自增id',
  `h_t_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上线单id',
  `h_s_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务器的id',
  `h_username` varchar(80) NOT NULL DEFAULT '' COMMENT '用户名',
  `h_svn_from` varchar(20) NOT NULL DEFAULT '' COMMENT '从那个分支取的文件',
  `h_userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同步的用户id',
  `h_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同步的时间',
  `h_sum` text NOT NULL COMMENT '操作结果',
  `h_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型0同步历史,1修改文件列表,2同步结果,3同步失败的结果',
  PRIMARY KEY (`h_id`),
  KEY `u_id` (`h_t_id`,`h_username`,`h_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_project_group`
--

DROP TABLE IF EXISTS `sync_project_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_project_group` (
  `pg_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pg_name` char(100) NOT NULL COMMENT '组名',
  `pg_desc` char(255) NOT NULL COMMENT '组描述信息',
  `pg_del` tinyint(3) unsigned NOT NULL COMMENT '是否删除',
  `pg_createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`pg_id`),
  UNIQUE KEY `pg_name` (`pg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_projects`
--

DROP TABLE IF EXISTS `sync_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_projects` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目自增id',
  `p_name` varchar(255) NOT NULL DEFAULT '' COMMENT '项目名称',
  `p_group_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目组ID',
  `p_svn` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '项目对应的svn服务器自增id',
  `p_servers` varchar(255) NOT NULL DEFAULT '' COMMENT '项目对应的部署程序的服务器的列表,序列化后的数据结构',
  `p_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '项目状态,0为正常,1为不使用',
  PRIMARY KEY (`p_id`),
  UNIQUE KEY `p_name` (`p_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_servers`
--

DROP TABLE IF EXISTS `sync_servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_servers` (
  `s_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '服务器自增id',
  `s_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '服务器描述信息',
  `s_scheme` varchar(20) NOT NULL DEFAULT '' COMMENT '服务器模式',
  `s_ipv4` varchar(255) NOT NULL DEFAULT '' COMMENT 'ip地址或者主机名称',
  `s_port` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '端口',
  `s_prefix` varchar(255) NOT NULL DEFAULT '' COMMENT 'svn路径的前缀或者服务器部署路径',
  `s_uri` varchar(255) NOT NULL DEFAULT '' COMMENT '上线分支地址',
  `s_trunk_uri` varchar(255) NOT NULL DEFAULT '' COMMENT 'trunk地址',
  `s_username` varchar(255) NOT NULL DEFAULT '' COMMENT '服务器用户名',
  `s_password` varchar(255) NOT NULL DEFAULT '' COMMENT '服务器密码',
  `s_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '服务器类型svn或者server',
  `s_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`s_id`),
  UNIQUE KEY `s_desc` (`s_desc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_tickets`
--

DROP TABLE IF EXISTS `sync_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_tickets` (
  `s_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上线单自增id',
  `s_trac_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上线单唯一id',
  `s_file_list` longtext NOT NULL COMMENT '文件列表',
  `s_md5_sum` char(32) NOT NULL DEFAULT '' COMMENT '文件列表的md5校验值',
  `s_op_list` text NOT NULL COMMENT '操作列表',
  `s_owner` char(32) NOT NULL DEFAULT '上线单的创建者',
  `s_list_mtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件列表最后修改时间',
  `s_sync_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上线单最后同步时间',
  PRIMARY KEY (`s_id`),
  UNIQUE KEY `s_trac_id` (`s_trac_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sync_users`
--

DROP TABLE IF EXISTS `sync_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_users` (
      `s_userid` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表自增id',
      `s_username` char(100) NOT NULL DEFAULT '' COMMENT '用户名',
      `s_password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
      `s_createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
      `s_updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
      `s_usermod` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户权限',
      `s_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否停用',
      PRIMARY KEY (`s_userid`),
      UNIQUE KEY `s_username` (`s_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-06  0:28:05

--
-- Table structure for table `sync_tips` 小贴士表
--

DROP TABLE IF EXISTS `sync_tips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_tips` (
      `t_id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
      `t_content` text NOT NULL COMMENT '小贴士内容',
      `t_del` tinyint(3) unsigned NOT NULL COMMENT '是否删除',
      `t_createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
      PRIMARY KEY (`t_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
