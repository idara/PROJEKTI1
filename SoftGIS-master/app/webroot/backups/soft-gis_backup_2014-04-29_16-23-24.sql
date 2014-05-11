-- MySQL dump 10.13  Distrib 5.6.12, for Win64 (x86_64)
--
-- Host: localhost    Database: projekti_1
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `map` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,1,1,'Aluevastaus',NULL,NULL,'ax`lKkjxzCvnG_gSniDjmGxeA|oUaiFdsOoyJflA'),(2,1,2,'Viivavastaus',NULL,NULL,'m`clKscb{C`tAwiV~dCjpWrB`sZazEhdPkeD}eM'),(3,1,3,'Momnimerkkivastaus',NULL,NULL,'_ualKo{xzChu@yl[pbBpjOvkBnuPx@hmGetDnbFyxCypNmj@phP`cFeoQ'),(4,1,4,'Merkkivastaus',NULL,NULL,'em`lKcvrzC'),(5,2,1,'KuivasjÃ¤rvi',NULL,NULL,'mjdlKq_ozCfb@{cBjSezAqd@oaAmWzhC'),(6,2,2,'Kalikkatie',NULL,NULL,'woclKmjrzCwEyFaC_EeAmCsAkDo@qCm@qCY}Eq@eIG}DBsD\\wFb@eE'),(7,2,3,'JÃ¤rviÃ¤',NULL,NULL,'ikclKylnzCjdByrBteG_e_@g`AqGe}DiyYdfBqpA'),(8,2,4,'PyykkÃ¶sjÃ¤rvi',NULL,NULL,'cd`lK}drzC');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `email` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'admin','e43bc80cb1fc17dc7e655c09e08b8949f46d210e',1,'admin@osoite.fi'),(2,'jani','8d1800abedde5019383ff916d121e176fd2b8ef1',2,'jjjj@osoite.fi'),(3,'jorma','ef0612d21392053772fd66cefcc4244547435983',2,'jorma@osoite.fi');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'PÃ¤Ã¤kÃ¤yttÃ¤jÃ¤t'),(2,'Users');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hashes`
--

DROP TABLE IF EXISTS `hashes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hashes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hashes`
--

LOCK TABLES `hashes` WRITE;
/*!40000 ALTER TABLE `hashes` DISABLE KEYS */;
/*!40000 ALTER TABLE `hashes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markers`
--

DROP TABLE IF EXISTS `markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `author_id` int(11) NOT NULL,
  `modified` date DEFAULT NULL,
  `content` text,
  `icon` varchar(50) DEFAULT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markers`
--

LOCK TABLES `markers` WRITE;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `overlays`
--

DROP TABLE IF EXISTS `overlays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overlays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `author_id` int(11) NOT NULL,
  `modified` date DEFAULT NULL,
  `content` text,
  `image` varchar(50) NOT NULL,
  `ne_lat` float NOT NULL,
  `ne_lng` float NOT NULL,
  `sw_lat` float NOT NULL,
  `sw_lng` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `overlays`
--

LOCK TABLES `overlays` WRITE;
/*!40000 ALTER TABLE `overlays` DISABLE KEYS */;
/*!40000 ALTER TABLE `overlays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `modified` date DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `content` text,
  `stroke_color` varchar(6) DEFAULT '333333',
  `stroke_opacity` float DEFAULT '0.8',
  `stroke_weight` float DEFAULT '1',
  `fill_color` varchar(6) DEFAULT '333333',
  `fill_opacity` float DEFAULT '0.2',
  `coordinates` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paths`
--

LOCK TABLES `paths` WRITE;
/*!40000 ALTER TABLE `paths` DISABLE KEYS */;
/*!40000 ALTER TABLE `paths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `launch` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `welcome_text` text,
  `thanks_text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls`
--

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;
INSERT INTO `polls` VALUES (1,'Mallikysely MIF',1,1,'2014-04-13','2015-04-15','Testikysely MIF','Kiitos'),(2,'Muokkaustestauskysely',1,1,NULL,NULL,'sdjfisdjafoiÃ¶jsdaiofjiodsaÃ¶jfoÃ¶idasjif','jfasdjfiajsdÃ¶oifjdas');
/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls_markers`
--

DROP TABLE IF EXISTS `polls_markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls_markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls_markers`
--

LOCK TABLES `polls_markers` WRITE;
/*!40000 ALTER TABLE `polls_markers` DISABLE KEYS */;
/*!40000 ALTER TABLE `polls_markers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls_overlays`
--

DROP TABLE IF EXISTS `polls_overlays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls_overlays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `overlay_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls_overlays`
--

LOCK TABLES `polls_overlays` WRITE;
/*!40000 ALTER TABLE `polls_overlays` DISABLE KEYS */;
/*!40000 ALTER TABLE `polls_overlays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls_paths`
--

DROP TABLE IF EXISTS `polls_paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls_paths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls_paths`
--

LOCK TABLES `polls_paths` WRITE;
/*!40000 ALTER TABLE `polls_paths` DISABLE KEYS */;
/*!40000 ALTER TABLE `polls_paths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `text` text NOT NULL,
  `low_text` varchar(255) DEFAULT NULL,
  `high_text` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `zoom` int(11) DEFAULT '12',
  `choice1` varchar(255) DEFAULT NULL,
  `choice2` varchar(255) DEFAULT NULL,
  `choice3` varchar(255) DEFAULT NULL,
  `choice4` varchar(255) DEFAULT NULL,
  `choice5` varchar(255) DEFAULT NULL,
  `choice6` varchar(255) DEFAULT NULL,
  `choice7` varchar(255) DEFAULT NULL,
  `choice8` varchar(255) DEFAULT NULL,
  `otherchoice` tinyint(1) NOT NULL DEFAULT '0',
  `answer_location` tinyint(1) NOT NULL DEFAULT '0',
  `answer_visible` tinyint(1) NOT NULL DEFAULT '0',
  `comments` tinyint(1) NOT NULL DEFAULT '0',
  `map_type` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,1,1,'Aluekysymys tekstillÃ¤',NULL,NULL,65.0163,25.5789,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0,0,5),(2,1,2,1,'Viivakysymys tekstillÃ¤',NULL,NULL,65.0163,25.5789,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0,0,4),(3,1,3,1,'Monimerkkikysymys tekstillÃ¤',NULL,NULL,65.0163,25.5789,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0,0,3),(4,1,4,1,'Merkkikysymys tekstillÃ¤',NULL,NULL,65.0163,25.5789,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0,0,2),(5,2,1,1,'testikysymys',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,0);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `request_created` datetime DEFAULT NULL,
  `request` text NOT NULL,
  `complete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
INSERT INTO `requests` VALUES (1,1,'2014-04-16 13:33:03','testiÃ¤ varten',0);
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` VALUES (1,1,'2014-04-14 09:55:44',NULL),(2,1,'2014-04-14 09:58:47',NULL);
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-29 16:23:24
