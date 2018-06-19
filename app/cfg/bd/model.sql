CREATE DATABASE  IF NOT EXISTS `secondcall` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `secondcall`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: secondcall
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.33-MariaDB

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
-- Table structure for table `half`
--

DROP TABLE IF EXISTS `half`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `half` (
  `idHalf` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `token` varchar(45) NOT NULL,
  PRIMARY KEY (`idHalf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `half`
--

LOCK TABLES `half` WRITE;
/*!40000 ALTER TABLE `half` DISABLE KEYS */;
/*!40000 ALTER TABLE `half` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matter`
--

DROP TABLE IF EXISTS `matter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matter` (
  `idMatter` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `time` varchar(45) NOT NULL,
  `token` varchar(40) NOT NULL,
  `fk_idHalf` int(11) NOT NULL,
  PRIMARY KEY (`idMatter`),
  KEY `fk_Matter_Half1_idx` (`fk_idHalf`),
  CONSTRAINT `fk_Matter_Half1` FOREIGN KEY (`fk_idHalf`) REFERENCES `half` (`idHalf`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matter`
--

LOCK TABLES `matter` WRITE;
/*!40000 ALTER TABLE `matter` DISABLE KEYS */;
/*!40000 ALTER TABLE `matter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matteruser`
--

DROP TABLE IF EXISTS `matteruser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matteruser` (
  `MatterUser_idUser` int(11) NOT NULL,
  `MatterUser_idMatter` int(11) NOT NULL,
  PRIMARY KEY (`MatterUser_idUser`,`MatterUser_idMatter`),
  KEY `fk_User_has_Matter_Matter1_idx` (`MatterUser_idMatter`),
  KEY `fk_User_has_Matter_User1_idx` (`MatterUser_idUser`),
  CONSTRAINT `fk_User_has_Matter_Matter1` FOREIGN KEY (`MatterUser_idMatter`) REFERENCES `matter` (`idMatter`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Matter_User1` FOREIGN KEY (`MatterUser_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matteruser`
--

LOCK TABLES `matteruser` WRITE;
/*!40000 ALTER TABLE `matteruser` DISABLE KEYS */;
/*!40000 ALTER TABLE `matteruser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secondcall`
--

DROP TABLE IF EXISTS `secondcall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secondcall` (
  `idSecondCall` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `localFile` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `local` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `fk_idTest` int(11) NOT NULL,
  `fk_idUser` int(11) NOT NULL,
  PRIMARY KEY (`idSecondCall`),
  KEY `fk_SecondCall_Test1_idx` (`fk_idTest`),
  KEY `fk_SecondCall_User1_idx` (`fk_idUser`),
  CONSTRAINT `fk_SecondCall_Test1` FOREIGN KEY (`fk_idTest`) REFERENCES `test` (`idTest`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_SecondCall_User1` FOREIGN KEY (`fk_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secondcall`
--

LOCK TABLES `secondcall` WRITE;
/*!40000 ALTER TABLE `secondcall` DISABLE KEYS */;
/*!40000 ALTER TABLE `secondcall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `idTest` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `fk_idMatter` int(11) NOT NULL,
  PRIMARY KEY (`idTest`),
  KEY `fk_Test_Matter1_idx` (`fk_idMatter`),
  CONSTRAINT `fk_Test_Matter1` FOREIGN KEY (`fk_idMatter`) REFERENCES `matter` (`idMatter`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fk_idUserType` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  KEY `fk_User_UserType_idx` (`fk_idUserType`),
  CONSTRAINT `fk_User_UserType` FOREIGN KEY (`fk_idUserType`) REFERENCES `usertype` (`idUserType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertype` (
  `idUserType` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`idUserType`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'Admin'),(2,'Professor'),(3,'Aluno');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-18 22:39:02
