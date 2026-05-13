-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: de_system_db
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account_tb`
--

DROP TABLE IF EXISTS `account_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_tb` (
  `Acc_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Acc_Fullname` varchar(100) DEFAULT NULL,
  `Acc_User` varchar(45) DEFAULT NULL,
  `Acc_Password` varchar(100) DEFAULT NULL,
  `Acc_Role` varchar(45) DEFAULT NULL,
  `Acc_Active` varchar(45) DEFAULT NULL,
  `Acc_Email` varchar(45) DEFAULT NULL,
  `Acc_Phone` varchar(45) DEFAULT NULL,
  `Acc_RegisterDate` varchar(45) DEFAULT NULL,
  `Acc_ApproveDate` varchar(45) DEFAULT NULL,
  `Acc_ApproveBy` varchar(45) DEFAULT NULL,
  `Si_ID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Acc_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_tb`
--

LOCK TABLES `account_tb` WRITE;
/*!40000 ALTER TABLE `account_tb` DISABLE KEYS */;
INSERT INTO `account_tb` VALUES (1,'Admin-System','System','86764939e8d3f0a781be5cbe4d0ebf86a5a2fea59db4cd6dadcefe1509045df7','Admin','Yes',NULL,NULL,NULL,NULL,NULL,NULL),(2,'ทศพล จำปา','Tossa','a80bc6b2a6207ba09cbb63ab095b257a7871f8c8c1a93b757f2f026b3a76dfe6','User','Registered','Tossaphol@test.com','080-1141444','2026-05-01 05:51:30',NULL,NULL,NULL),(3,'ปราณี อรุณศรี','Prany','a80bc6b2a6207ba09cbb63ab095b257a7871f8c8c1a93b757f2f026b3a76dfe6','User','Registered','Prany@test.com','080-2422242','2026-05-01 06:02:39',NULL,NULL,NULL),(5,'test002','11','1257a1aea44c40853dd393d73403c82fcc48e92047123d7a51b11e900fac9926','User','Registered','000@00.com','111','2026-05-01 06:03:32',NULL,NULL,NULL),(6,'test003','114','d5e67ce686e12a26700eb10bbd3531397f1ad62c92054533031032194bd8d643','User','Registered','000@00.com','1114','2026-05-01 06:04:06',NULL,NULL,NULL);
/*!40000 ALTER TABLE `account_tb` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-01  8:18:48
