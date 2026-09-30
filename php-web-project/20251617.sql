-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: localhost    Database: assign_db
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` enum('건축도장기능사','방수기능사','건축목공기능사','거푸집기능사') NOT NULL,
  `class_date` date NOT NULL,
  `time_slot` enum('오전반(10시~16시)','오후반(18시~24시)') NOT NULL,
  `max_students` int(11) DEFAULT '3',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'건축도장기능사','2026-06-20','오전반(10시~16시)',3),(2,'건축도장기능사','2026-06-20','오후반(18시~24시)',3),(3,'방수기능사','2026-06-20','오전반(10시~16시)',3),(4,'방수기능사','2026-06-20','오후반(18시~24시)',3),(5,'건축목공기능사','2026-06-21','오전반(10시~16시)',3),(6,'건축목공기능사','2026-06-21','오후반(18시~24시)',3),(7,'거푸집기능사','2026-06-21','오전반(10시~16시)',3),(8,'거푸집기능사','2026-06-21','오후반(18시~24시)',3),(9,'건축도장기능사','2026-06-22','오전반(10시~16시)',3),(10,'건축도장기능사','2026-06-22','오후반(18시~24시)',3),(11,'방수기능사','2026-06-22','오전반(10시~16시)',3),(12,'방수기능사','2026-06-22','오후반(18시~24시)',3),(13,'건축목공기능사','2026-06-23','오전반(10시~16시)',3),(14,'건축목공기능사','2026-06-23','오후반(18시~24시)',3),(15,'거푸집기능사','2026-06-23','오전반(10시~16시)',3),(16,'거푸집기능사','2026-06-23','오후반(18시~24시)',3),(17,'건축도장기능사','2026-06-24','오전반(10시~16시)',3),(18,'방수기능사','2026-06-24','오전반(10시~16시)',3),(19,'건축목공기능사','2026-06-24','오후반(18시~24시)',3),(20,'거푸집기능사','2026-06-24','오후반(18시~24시)',3),(21,'건축도장기능사','2026-06-25','오전반(10시~16시)',3),(22,'건축도장기능사','2026-06-25','오후반(18시~24시)',3),(23,'방수기능사','2026-06-25','오전반(10시~16시)',3),(24,'방수기능사','2026-06-25','오후반(18시~24시)',3),(25,'건축목공기능사','2026-06-26','오전반(10시~16시)',3),(26,'건축목공기능사','2026-06-26','오후반(18시~24시)',3),(27,'거푸집기능사','2026-06-26','오전반(10시~16시)',3),(28,'거푸집기능사','2026-06-26','오후반(18시~24시)',3),(29,'건축도장기능사','2026-06-27','오전반(10시~16시)',3),(30,'방수기능사','2026-06-27','오후반(18시~24시)',3);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `class_id` int(11) NOT NULL,
  `res_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`res_id`),
  KEY `user_id` (`user_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,'student01',1,'2026-06-10 10:00:00'),(2,'student02',1,'2026-06-10 11:00:00'),(3,'student03',1,'2026-06-10 12:00:00'),(4,'student04',2,'2026-06-10 14:00:00'),(5,'student05',3,'2026-06-11 10:00:00'),(6,'student06',4,'2026-06-11 11:00:00'),(7,'student07',5,'2026-06-11 15:00:00'),(8,'student08',6,'2026-06-12 09:00:00'),(9,'student09',7,'2026-06-12 10:00:00'),(10,'student10',8,'2026-06-12 11:00:00'),(11,'student11',9,'2026-06-12 13:00:00'),(12,'student12',10,'2026-06-13 14:00:00'),(13,'student13',11,'2026-06-13 16:00:00'),(14,'student14',12,'2026-06-13 17:00:00'),(15,'student15',13,'2026-06-14 09:00:00'),(16,'student16',14,'2026-06-14 10:00:00'),(17,'student17',15,'2026-06-14 11:00:00'),(18,'student18',16,'2026-06-14 13:00:00'),(19,'student19',17,'2026-06-14 15:00:00'),(20,'student20',18,'2026-06-14 16:00:00'),(21,'student21',21,'2026-06-15 09:30:00'),(22,'student22',21,'2026-06-15 10:15:00'),(23,'student23',21,'2026-06-15 11:00:00'),(24,'student24',22,'2026-06-15 14:20:00'),(25,'student25',23,'2026-06-16 09:00:00'),(26,'student26',24,'2026-06-16 13:10:00'),(27,'student27',25,'2026-06-16 16:00:00'),(28,'student28',26,'2026-06-17 10:00:00'),(29,'student29',27,'2026-06-17 11:30:00'),(30,'student30',28,'2026-06-17 15:00:00');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `months` int(11) DEFAULT '3',
  `total_count` int(11) DEFAULT '30',
  `remaining_count` int(11) DEFAULT '30',
  `expiry_date` date DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'student01',3,30,27,'2026-09-01'),(2,'student02',1,10,9,'2026-07-01'),(3,'student03',3,30,29,'2026-09-02'),(4,'student04',6,60,59,'2026-12-02'),(5,'student05',3,30,29,'2026-09-03'),(6,'student06',1,10,9,'2026-07-03'),(7,'student07',3,30,29,'2026-09-04'),(8,'student08',6,60,59,'2026-12-04'),(9,'student09',3,30,29,'2026-09-05'),(10,'student10',1,10,9,'2026-07-05'),(11,'student11',3,30,29,'2026-09-06'),(12,'student12',6,60,59,'2026-12-06'),(13,'student13',3,30,29,'2026-09-07'),(14,'student14',1,10,9,'2026-07-07'),(15,'student15',3,30,29,'2026-09-08'),(16,'student16',6,60,59,'2026-12-08'),(17,'student17',3,30,29,'2026-09-09'),(18,'student18',1,10,9,'2026-07-09'),(19,'student19',3,30,29,'2026-09-10'),(20,'student20',6,60,59,'2026-12-10'),(21,'student21',3,30,27,'2026-09-11'),(22,'student22',1,10,10,'2026-07-11'),(23,'student23',3,30,29,'2026-09-12'),(24,'student24',6,60,59,'2026-12-12'),(25,'student25',3,30,29,'2026-09-13'),(26,'student26',1,10,10,'2026-07-13'),(27,'student27',3,30,29,'2026-09-14'),(28,'student28',6,60,59,'2026-12-14'),(29,'student29',3,30,29,'2026-09-15'),(30,'student30',1,10,9,'2026-07-15');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` varchar(15) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_level` enum('student','admin') DEFAULT 'student',
  `interests` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','$2y$10$G2q2lkutWFLyDAVx5Dfcdu/jsMRUTsLFRCcvu0nyswQUkIB5n7z8K','원장선생님','admin',NULL,NULL,NULL,NULL),('admin2','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','부원장님','admin',NULL,NULL,NULL,NULL),('student01','$2y$10$MTUSSBt2HH5V27uDHe5fcOjiXYjFQaMbwlZvzFxsAIbIczvymvEAa','홍길동','student','건축도장기능사','F4 비자 변경','2026-06-01','열심히 하겠습니다.'),('student02','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','김철수','student','방수기능사','현장 취업','2026-06-01',''),('student03','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','이영희','student','건축목공기능사','창업 목적','2026-06-02',''),('student04','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','박민수','student','거푸집기능사','경력수첩 발급','2026-06-02',''),('student05','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','최지우','student','건축도장기능사','F4 비자 변경','2026-06-03',''),('student06','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','정우성','student','방수기능사','현장 취업','2026-06-03',''),('student07','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','한지민','student','건축목공기능사','창업 목적','2026-06-04',''),('student08','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','강동원','student','거푸집기능사','경력수첩 발급','2026-06-04',''),('student09','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','송혜교','student','건축도장기능사','F4 비자 변경','2026-06-05',''),('student10','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','이정재','student','방수기능사','현장 취업','2026-06-05',''),('student11','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','공유','student','건축목공기능사','창업 목적','2026-06-06',''),('student12','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','김태리','student','거푸집기능사','경력수첩 발급','2026-06-06',''),('student13','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','조인성','student','건축도장기능사','F4 비자 변경','2026-06-07',''),('student14','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','손예진','student','방수기능사','현장 취업','2026-06-07',''),('student15','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','현빈','student','건축목공기능사','창업 목적','2026-06-08',''),('student16','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','유재석','student','거푸집기능사','경력수첩 발급','2026-06-08',''),('student17','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','강호동','student','건축도장기능사','F4 비자 변경','2026-06-09',''),('student18','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','신동엽','student','방수기능사','현장 취업','2026-06-09',''),('student19','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','이효리','student','건축목공기능사','창업 목적','2026-06-10',''),('student20','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','아이유','student','거푸집기능사','경력수첩 발급','2026-06-10',''),('student21','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','박보검','student','건축도장기능사','현장 취업','2026-06-11',''),('student22','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','송중기','student','방수기능사','창업 목적','2026-06-11',''),('student23','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','한소희','student','건축목공기능사','경력수첩 발급','2026-06-12',''),('student24','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','임시완','student','거푸집기능사','F4 비자 변경','2026-06-12',''),('student25','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','김수현','student','건축도장기능사','현장 취업','2026-06-13',''),('student26','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','수지','student','방수기능사','창업 목적','2026-06-13',''),('student27','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','강하늘','student','건축목공기능사','경력수첩 발급','2026-06-14',''),('student28','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','지창욱','student','거푸집기능사','F4 비자 변경','2026-06-14',''),('student29','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','박서준','student','건축도장기능사','현장 취업','2026-06-15',''),('student30','$2y$10$wKsnWfV596Tj19mCAn4MKeOQZ/W5TjG39w6Zp4bYI.UqU1/jX9DNG','안효섭','student','방수기능사','창업 목적','2026-06-15','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-09  5:27:52
