/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.16-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: gymflow
-- ------------------------------------------------------
-- Server version	10.11.16-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `muscle_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FA1499144004D0` (`muscle_group_id`),
  CONSTRAINT `FK_FA1499144004D0` FOREIGN KEY (`muscle_group_id`) REFERENCES `muscle_groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises`
--

LOCK TABLES `exercises` WRITE;
/*!40000 ALTER TABLE `exercises` DISABLE KEYS */;
INSERT INTO `exercises` VALUES
(1,'Bench Press','https://drive.google.com/uc?id=1nsGz08zBI4U6057Bk4DdYXJE4MoutVq2',1),
(2,'Incline Bench Press','https://drive.google.com/uc?id=1h-Kbj7owjoV1DtXD-pS8Dd1p1dvdhHI5',1),
(3,'Dumbbell Flyes','https://drive.usercontent.google.com/download?id=1vvHWOccDhsQQ7CjJiqED7xr45S_16-rJ&authuser=0',1),
(4,'Cable Crossovers','https://drive.google.com/uc?export=view&id=1n3Nd33ozn7GIQANycO4ZiEnRmuodnX2U',1),
(5,'Dumbbell Pullover','https://drive.usercontent.google.com/download?id=1v_-gMAnBW_h_QuTnHromBiUnMfWoaaOT&authuser=0',1),
(6,'Chest Dips','https://drive.google.com/uc?export=view&id=1Az4K1c7WWRNigBIiDJkl3M6SVoulUCe_',1),
(7,'Push-Ups','https://drive.google.com/uc?id=1HdVrOHC1bh8elb_anNp_5TJ1GEIYYHb2',1),
(8,'Deadlift','https://drive.google.com/uc?export=view&id=112h7bp0qsEqSdHRgpjcsUnLjzyhp2ZNa',2),
(9,'Barbell Row','https://drive.google.com/uc?export=view&id=17i8NxLS4OOZ_J5VxMgOs33LV8eY13ybj',2),
(10,'Seated Cable Row','https://drive.google.com/uc?export=view&id=1otpDB9uq4AEvXEdx5scCDhzEnh_rLYXN',2),
(11,'Pull-Ups','https://drive.google.com/uc?export=view&id=1lbHsqK-W_9g2NGrisUTwCQL1y7wyRxIf',2),
(12,'High Pulley Rows','https://drive.google.com/uc?export=view&id=1Hdby7e6BEdu4LURec2J7JzxjQwP-c6YS',2),
(13,'Shrugs','https://drive.google.com/uc?export=view&id=1lzQrnB2Lb46JrRp5r-ePGg7DgwkeFaik',2),
(14,'Squats','https://drive.google.com/uc?export=view&id=1mQhsDGHjZexOTh12tdqe_UFp0jRHU6TY',3),
(15,'Leg Extension','https://drive.google.com/uc?export=view&id=1lzQrnB2Lb46JrRp5r-ePGg7DgwkeFaik',3),
(16,'Leg Curl','https://drive.google.com/uc?export=view&id=1S6Xo3eqLkM05J4oe-ONzD1qoLMHhli0Y',3),
(17,'Hip Thrust','https://drive.google.com/uc?export=view&id=1Nll4jIvw2GuBDj0eX-rSEuB4hj2hTLEL',3),
(18,'Glute Kickback','https://drive.google.com/uc?export=view&id=1wc4Ewx9cGFKAPH9fCPu9tpMd84vpecEW',3),
(19,'Lunges','https://drive.google.com/uc?export=view&id=1jkw_RLyF2NhoV4K8bkukdZq6Fxz2rWmh',3),
(20,'Leg Press','https://drive.google.com/uc?export=view&id=171CcQ5J1PsuHM20o5v-w6RQEJBeTJx22',3),
(21,'Hack Squat','https://drive.google.com/uc?export=view&id=18PXjtfQ0KwOhtJms5d-55GckQ71Nh5Xy',3),
(22,'Box Step-Ups','https://drive.google.com/uc?export=view&id=16dHcu1W6kWBm9d_WYS6gffOWGlXNVzKB',3),
(23,'Overhead Press','https://drive.google.com/uc?export=view&id=1ImRj0l8O92mV84i7V0JN_mBKNWtpzWzp',4),
(24,'Arnold Press','https://drive.google.com/uc?export=view&id=10F_bwBC22RIIskZogddplbSocNYNkKYM',4),
(25,'Front Raises','https://drive.google.com/uc?export=view&id=13bEaZQYIBCx1kPdeCw3Qf3ApB2Ic-GdP',4),
(26,'Lateral Raises','https://drive.google.com/uc?export=view&id=1451UI5oFQYFJs3fhQg5OrvDZ2ZqsRDKh',4),
(27,'Upright Row','https://drive.google.com/uc?export=view&id=1neWaCabM7UGKq0X7WceeN2SxRVcCQ4nd',4),
(28,'Shoulder Push-Up','https://drive.google.com/uc?export=view&id=1vvWEutbDRbaAfEgV7OrlvgJ_Y8_8294_',4),
(29,'Rear Delt Raises','https://drive.google.com/uc?export=view&id=1fg6Cf3AYiysoC00dPonwPWzBh46unAVU',4),
(30,'Biceps Curl','https://drive.google.com/uc?export=view&id=1v_2I0LtNzHt43WDuwnVTGANqGXVeLuWO ',5),
(31,'Scott Bench Curl','https://drive.google.com/uc?export=view&id=1zbQInNKY2hWDchYQ2pOFdEB_FxI_f6oQ',5),
(32,'Hammer Curl','https://drive.google.com/uc?export=view&id=1i3U7D5nqEO6nbKk_b9YCgXfUt6v9CX-B',5),
(33,'Triceps Extension','https://drive.google.com/uc?export=view&id=1wAYg9qCCr5mC_ISAGdT371yoVA6J7Vtt',5),
(34,'Skull Crushers','https://drive.google.com/uc?export=view&id=19qoMbyR4yoGhPpdFz5miMZ-S1mVScNcF',5),
(35,'Diamond Push-Ups','https://drive.google.com/uc?export=view&id=1jfOfKEgu-Hq2-J2__sSw1OJn-vGfY6O2',5),
(36,'Triceps Dips','https://drive.google.com/uc?export=view&id=1dyuvXHQNKeUcbczCInZBgmaiFXIjAY5o',5),
(37,'Plank','https://drive.google.com/uc?export=view&id=1FApWP7ACfBIFbiZvhNwCgSlvobBKhvNp',6),
(38,'Dead Bug','https://drive.google.com/uc?export=view&id=1UbuziCPOFKP9DVdKA1WD--TFY7gIZy5B',6),
(39,'Bird Dog','https://drive.google.com/uc?export=view&id=1xN2H6KH_XnAmGU0-UX8mk8-Ro0-CiLpR',6),
(40,'Mountain Climbers','https://drive.google.com/uc?export=view&id=12XmOgqIkjmadR47bnvaXvgIdQ6pvhQ9m',6),
(41,'Pallof Press','https://drive.google.com/uc?export=view&id=1Wu3ckZp6Ktbs4erQ7rrMgY_hPgFliM51',6),
(42,'Farmer’s Walk','https://drive.google.com/uc?export=view&id=1s0hH8WqrsPpOFOrL6jRfbtF3OlGBecvq',6),
(43,'Glute Bridge','https://drive.google.com/uc?export=view&id=13tmiweMF3WHR3kGBRW1LXaubah54Yx7_',6),
(44,'Back Extension','https://drive.google.com/uc?export=view&id=1jEtiEliBp-BP1aENCf7MDsny9clA1oRA',6),
(45,'Russian Twists','https://drive.google.com/uc?export=view&id=1WfCATCiHPQx9HqvspyAI1h7wJeFQJNvr',6),
(46,'Hollow Hold','https://drive.google.com/uc?export=view&id=1xwjk8oUxJxm_HlksOAgnInWu5QdCCc1H',6);
/*!40000 ALTER TABLE `exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercises_muscles`
--

DROP TABLE IF EXISTS `exercises_muscles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises_muscles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `muscle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DA911D9E934951A` (`exercise_id`),
  KEY `IDX_3DA911D9354FDBB4` (`muscle_id`),
  CONSTRAINT `FK_3DA911D9354FDBB4` FOREIGN KEY (`muscle_id`) REFERENCES `muscles` (`id`),
  CONSTRAINT `FK_3DA911D9E934951A` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises_muscles`
--

LOCK TABLES `exercises_muscles` WRITE;
/*!40000 ALTER TABLE `exercises_muscles` DISABLE KEYS */;
INSERT INTO `exercises_muscles` VALUES
(1,'primary',1,1),
(2,'secondary',1,23),
(3,'secondary',1,20),
(4,'primary',2,1),
(5,'secondary',2,20),
(6,'primary',3,1),
(7,'primary',4,1),
(8,'secondary',5,1),
(9,'secondary',5,3),
(10,'primary',6,1),
(11,'secondary',6,23),
(12,'primary',7,1),
(13,'secondary',7,23),
(14,'primary',8,5),
(15,'primary',8,15),
(16,'secondary',8,14),
(17,'primary',9,3),
(18,'secondary',9,9),
(19,'secondary',9,4),
(20,'secondary',9,22),
(21,'primary',10,3),
(22,'secondary',10,9),
(23,'secondary',10,4),
(24,'secondary',10,22),
(25,'primary',11,3),
(26,'secondary',11,6),
(27,'secondary',11,22),
(28,'secondary',11,24),
(29,'primary',12,3),
(30,'secondary',12,6),
(31,'secondary',12,22),
(32,'primary',13,4),
(33,'stabilizer',13,5),
(34,'primary',14,10),
(35,'secondary',14,15),
(36,'secondary',14,14),
(37,'stabilizer',14,11),
(38,'stabilizer',14,16),
(39,'primary',15,10),
(40,'primary',16,14),
(41,'primary',17,15),
(42,'secondary',17,14),
(43,'secondary',17,16),
(44,'primary',18,15),
(45,'secondary',18,16),
(46,'primary',19,10),
(47,'secondary',19,15),
(48,'secondary',19,14),
(49,'stabilizer',19,16),
(50,'primary',20,10),
(51,'secondary',20,15),
(52,'secondary',20,14),
(53,'primary',21,10),
(54,'secondary',21,15),
(55,'secondary',21,14),
(56,'primary',22,10),
(57,'secondary',22,15),
(58,'secondary',22,14),
(59,'stabilizer',22,16),
(60,'primary',23,19),
(61,'secondary',23,20),
(62,'secondary',23,23),
(63,'primary',24,19),
(64,'secondary',24,20),
(65,'secondary',24,23),
(66,'primary',25,19),
(67,'primary',26,20),
(68,'secondary',26,4),
(69,'primary',27,20),
(70,'secondary',27,4),
(71,'secondary',27,22),
(72,'primary',28,19),
(73,'primary',29,21),
(74,'secondary',29,4),
(75,'primary',30,22),
(76,'secondary',30,24),
(77,'secondary',30,25),
(78,'primary',31,22),
(79,'secondary',31,24),
(80,'primary',32,25),
(81,'secondary',32,24),
(82,'secondary',32,22),
(83,'primary',33,23),
(84,'primary',34,23),
(85,'primary',35,23),
(86,'secondary',35,22),
(87,'primary',36,23),
(88,'secondary',36,22),
(89,'primary',37,28),
(90,'secondary',37,26),
(91,'secondary',37,27),
(92,'primary',38,28),
(93,'secondary',38,26),
(94,'secondary',39,5),
(95,'secondary',39,28),
(96,'primary',40,26),
(97,'secondary',40,27),
(98,'primary',41,27),
(99,'secondary',41,28),
(100,'primary',42,28),
(101,'secondary',42,27),
(102,'primary',43,15),
(103,'secondary',43,5),
(104,'primary',44,5),
(105,'secondary',44,15),
(106,'primary',45,27),
(107,'secondary',45,26),
(108,'primary',46,26),
(109,'secondary',46,28);
/*!40000 ALTER TABLE `exercises_muscles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercises_variants`
--

DROP TABLE IF EXISTS `exercises_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_66EEF335E934951A` (`exercise_id`),
  CONSTRAINT `FK_66EEF335E934951A` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises_variants`
--

LOCK TABLES `exercises_variants` WRITE;
/*!40000 ALTER TABLE `exercises_variants` DISABLE KEYS */;
INSERT INTO `exercises_variants` VALUES
(1,'Dumbbell Bench Press',1),
(2,'Incline Dumbbell Bench Press',2),
(3,'Incline Bench Flyes',3),
(4,'Flat Bench Flyes',3),
(5,'Plyometric Push-Ups',7),
(6,'Sumo Deadlift',8),
(7,'Dumbbell Deadlift',8),
(8,'3-Point Dumbbell Row',9),
(9,'Single-Arm Cable Row',10),
(10,'Wide-Grip Cable Row',10),
(11,'Close-Grip Cable Row',10),
(12,'Underhand Pull-Ups',11),
(13,'Neutral-Grip Pull-Ups',11),
(14,'Weighted Pull-Ups',11),
(15,'Wide-Grip Lat Pulldown',12),
(16,'Close-Grip Lat Pulldown',12),
(17,'Single-Arm Lat Pulldown',12),
(18,'Dumbbell Shrugs',13),
(19,'Barbell Squat',14),
(20,'Dumbbell Squat',14),
(21,'Sumo Squat',14),
(22,'Bulgarian Split Squat',14),
(23,'Lying Leg Curl',16),
(24,'Seated Leg Curl',16),
(25,'Machine Hip Thrust',17),
(26,'Barbell Hip Thrust',17),
(27,'Plate Hip Thrust',17),
(28,'Cable Glute Kickback',18),
(29,'Machine Glute Kickback',18),
(30,'Barbell Lunges',19),
(31,'Dumbbell Lunges',19),
(32,'Weighted Box Step-Ups',22),
(33,'Box Jump',22),
(34,'Dumbbell Shoulder Press',23),
(35,'Dumbbell Front Raises',25),
(36,'Low Cable Front Raises',25),
(37,'Plate Front Raises',25),
(38,'Dumbbell Lateral Raises',26),
(39,'Low Cable Lateral Raises',26),
(40,'Machine Lateral Raises',26),
(41,'Dumbbell Rear Delt Raises',29),
(42,'Low Cable Rear Delt Raises',29),
(43,'Machine Rear Delt Raises',29),
(44,'Barbell Biceps Curl',30),
(45,'Dumbbell Biceps Curl',30),
(46,'Low Cable Biceps Curl',30),
(47,'Machine Biceps Curl',30),
(48,'Dumbbell Preacher Curl',31),
(49,'Low Cable Hammer Curl',32),
(50,'Machine Triceps Extension',33),
(51,'Plate Triceps Extension',33),
(52,'Dumbbell Triceps Extension',33),
(53,'High Cable Triceps Extension',33),
(54,'EZ-Bar Skull Crusher',34),
(55,'Dumbbell Skull Crusher',34),
(56,'Parallel Bar Triceps Dips',36),
(57,'Bench Triceps Dips',36),
(58,'Front Plank',37),
(59,'Side Plank',37);
/*!40000 ALTER TABLE `exercises_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `muscle_groups`
--

DROP TABLE IF EXISTS `muscle_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `muscle_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `muscle_groups`
--

LOCK TABLES `muscle_groups` WRITE;
/*!40000 ALTER TABLE `muscle_groups` DISABLE KEYS */;
INSERT INTO `muscle_groups` VALUES
(1,'Chest','https://drive.google.com/uc?id=1J4ZrnHY8Coi4Jqd_IKErNuxOKWn9yVO2'),
(2,'Back','https://drive.google.com/uc?id=1W7D7mdGuplJeru-0UzJGowO-RaJr4Xz7'),
(3,'Legs','https://drive.google.com/uc?id=1U9Ztw3MCVmDFnHMbJdP9qsIyTm00hzwf'),
(4,'Shoulder','https://drive.google.com/uc?id=1np00rXyMBjua5wXdofCMxFccPfaixEmQ'),
(5,'Arms','https://drive.google.com/uc?id=1BRK3udwDfBPl-IbXCy1m3cHHbhOuebVd'),
(6,'Core','https://drive.google.com/uc?id=1Ur8z6G8OJJQNFOTtzTz_yKQb9fD9YxKc');
/*!40000 ALTER TABLE `muscle_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `muscles`
--

DROP TABLE IF EXISTS `muscles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `muscles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `muscle_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2B4821FB44004D0` (`muscle_group_id`),
  CONSTRAINT `FK_2B4821FB44004D0` FOREIGN KEY (`muscle_group_id`) REFERENCES `muscle_groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `muscles`
--

LOCK TABLES `muscles` WRITE;
/*!40000 ALTER TABLE `muscles` DISABLE KEYS */;
INSERT INTO `muscles` VALUES
(1,'Pectoralis major','https://drive.google.com/uc?export=view&id=1kFK0jRo3MhpA7uwOeni6MCjg0mWrEJ1_',1),
(2,'Pectoralis minor','https://drive.google.com/uc?export=view&id=1DNoTEzCg0uKMnodAnR1k83VCKXScKKnM',1),
(3,'Latissimus dorsi','https://drive.google.com/uc?export=view&id=1nJq4z6XH-wOLO-b8_CIu1m-PYkipW_5S',2),
(4,'Trapezius','https://drive.google.com/uc?export=view&id=1cbWve0TbchqNX-edQn895Q4ZFX7tzoxK',2),
(5,'Spinal erectors (lumbar)','https://drive.google.com/uc?export=view&id=1gzoeC32cOclfmW9zyiBfNpJma-KEznuT',2),
(6,'Teres major','https://drive.google.com/uc?export=view&id=1lYG-G0HkxqjXNRN_FW4u3qlbrw2GxHce',2),
(7,'Serratus anterior','https://drive.google.com/uc?export=view&id=1ghAexWfCkhJhfUNhpiYs_MnMqAzZUcuA',2),
(8,'Infraspinatus','https://drive.google.com/uc?export=view&id=1ThC2ON2TtIw3apQ_ove_x2qJc9GfWN83',2),
(9,'Rhomboids','https://drive.google.com/uc?export=view&id=1zUkrH9L9gezs9XuKCtjyFfqJ3jBRpMnj',2),
(10,'Quadriceps','https://drive.google.com/uc?export=view&id=1PlHSJFWZvYlOTyaPYcpEW4ijdQWIqM9N',3),
(11,'Adductors','https://drive.google.com/uc?export=view&id=1KS09SgXoQ5DkDZT7N5NkTTZ7Q3clok7n',3),
(12,'Abductors','https://drive.google.com/uc?export=view&id=1jPlis5Yr4pI31CLC6i-fwaTXINljOREG',3),
(13,'Soleus','https://drive.google.com/uc?export=view&id=1TaAVae3bH-BCurnbdMS-AL1ytOxVkN5i',3),
(14,'Hamstrings','https://drive.google.com/uc?export=view&id=1GXAPTjydO1CKcKoi9XI_G5b4LDElmQew',3),
(15,'Gluteus maximus','https://drive.google.com/uc?export=view&id=1AO-O0BygznCZ8accconMbRTl1XuSjjWs',3),
(16,'Gluteus medius','https://drive.google.com/uc?export=view&id=1Z2HIlmD0-c8G6mZ4dTVAMiR7R6i5dnnP',3),
(17,'Tibialis anterior','https://drive.google.com/uc?export=view&id=1Fimil39uknDcUfFyoDzvQIGPf6lUpUu-',3),
(18,'Gastrocnemius','https://drive.google.com/uc?export=view&id=1xUX3C1ddgYQhVwphEftEkK4XfhxJQ6M1',3),
(19,'Anterior deltoid','https://drive.google.com/uc?export=view&id=1m5JwpqtoKYGuoi2k7AQ6SoNvbUBkqKra',4),
(20,'Acromial deltoid','https://drive.google.com/uc?export=view&id=1wXd21j5XBAt41yZixMYw3RVEJCWwMi3s',4),
(21,'Posterior deltoid','https://drive.google.com/uc?export=view&id=1OUXNnCPGZ8hoXSPUBN5e6Og4mj9AW163',4),
(22,'Biceps brachii','https://drive.google.com/uc?export=view&id=1MaY9ewjNScna5PGPKuw1MJsyJxez9y9u',5),
(23,'Triceps brachii','https://drive.google.com/uc?export=view&id=1qZq0Lmw55rezpjnGdkb8VdqmrCbz6OOr',5),
(24,'Brachialis','https://drive.google.com/uc?export=view&id=1olEK63rn4Y7KY83IJNL00iNq6S3F68M3',5),
(25,'Brachioradialis','https://drive.google.com/uc?export=view&id=1Z2oD54qvGgZp-ejmSPO6a5wQiZXzVitO',5),
(26,'Rectus abdominis','https://drive.google.com/uc?export=view&id=1tNNVhAc8yQfm-W0M1IGEvyw_FP7BuW_6',6),
(27,'Obliques','https://drive.google.com/uc?export=view&id=15m_x2NqTORZz7roYRHxJiVXfUeimxdCR',6),
(28,'Transverse abdominis','https://drive.google.com/uc?export=view&id=1K30H5MoStwLDN92Rz3p_zECw00uvQXAe',6);
/*!40000 ALTER TABLE `muscles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_goal`
--

DROP TABLE IF EXISTS `training_goal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `training_goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_goal`
--

LOCK TABLES `training_goal` WRITE;
/*!40000 ALTER TABLE `training_goal` DISABLE KEYS */;
INSERT INTO `training_goal` VALUES
(1,'Hypertrophy','Objetivo centrado en ganar masa muscular mediante volumen e intensidad progresiva.'),
(2,'Fat Loss','Entrenamiento orientado a perder grasa manteniendo la mayor masa muscular posible.'),
(3,'Toning','Mejorar definición muscular y composición corporal.'),
(4,'Strength','Incrementar la fuerza máxima usando cargas altas y descansos largos.'),
(5,'Muscular Endurance','Mejorar la resistencia muscular con altas repeticiones y descansos cortos.'),
(6,'General Fitness','Mejorar condición física general y salud.'),
(7,'Specific Muscle Focus','Entrenamiento enfocado en desarrollar un grupo muscular concreto.');
/*!40000 ALTER TABLE `training_goal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_level`
--

DROP TABLE IF EXISTS `training_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `training_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_level`
--

LOCK TABLES `training_level` WRITE;
/*!40000 ALTER TABLE `training_level` DISABLE KEYS */;
INSERT INTO `training_level` VALUES
(1,'Beginner'),
(2,'Intermediate'),
(3,'Advanced');
/*!40000 ALTER TABLE `training_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_method`
--

DROP TABLE IF EXISTS `training_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `training_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_method`
--

LOCK TABLES `training_method` WRITE;
/*!40000 ALTER TABLE `training_method` DISABLE KEYS */;
INSERT INTO `training_method` VALUES
(1,'Progressive Overload','Incrementar progresivamente la carga, volumen o dificultad del entrenamiento.'),
(2,'RIR','Uso de repeticiones en reserva para controlar la intensidad del esfuerzo.'),
(3,'RPE','Escala de percepción del esfuerzo para regular la intensidad.'),
(4,'Superset','Realizar dos ejercicios consecutivos con poco o ningún descanso.'),
(5,'Drop Set','Reducir el peso tras alcanzar el fallo y continuar la serie.'),
(6,'Rest Pause','Pequeñas pausas dentro de una misma serie para extender el esfuerzo.'),
(7,'Myo Reps','Mini series cortas tras una serie principal efectiva.'),
(8,'Pyramid Set','Aumentar o disminuir progresivamente la carga entre series.'),
(9,'Circuit Training','Ejercicios realizados consecutivamente para aumentar intensidad y gasto calórico.'),
(10,'HIIT','Entrenamiento interválico de alta intensidad.'),
(11,'Full Body','Entrenamiento de cuerpo completo en cada sesión.'),
(12,'Push Pull Legs','División de entrenamiento por empuje, tirón y piernas.'),
(13,'Upper Lower','División torso y pierna.'),
(14,'Body Part Split','División clásica por grupos musculares.'),
(15,'Time Under Tension','Control del tiempo de ejecución para aumentar estímulo muscular.'),
(16,'Training to Failure','Series llevadas hasta el fallo muscular o muy cerca de él.');
/*!40000 ALTER TABLE `training_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'admin@florida.es','[\"ROLE_ADMIN\"]','$2y$13$v6VbDA5p5/oHQdjvmdZelOhaHR2eMs9t1NAukU6MAlhvtt5IlPkAO','Admin','Admin','Catarroja'),
(2,'test@user.es','[]','$2y$13$dLzFmi6GTG99Q70bOm3HU.Tlx.tkRSOT0Nq/kqI9.dVB/Qv2ZVNzC','User','User','Your Heart');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_plan`
--

DROP TABLE IF EXISTS `work_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` longtext DEFAULT NULL,
  `days_per_week` int(11) NOT NULL,
  `duration_weeks` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `training_goal_id` int(11) NOT NULL,
  `training_level_id` int(11) NOT NULL,
  `work_split_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2499EA45BB438AF0` (`training_goal_id`),
  KEY `IDX_2499EA45B8D45830` (`training_level_id`),
  KEY `IDX_2499EA45E869E299` (`work_split_id`),
  CONSTRAINT `FK_2499EA45B8D45830` FOREIGN KEY (`training_level_id`) REFERENCES `training_level` (`id`),
  CONSTRAINT `FK_2499EA45BB438AF0` FOREIGN KEY (`training_goal_id`) REFERENCES `training_goal` (`id`),
  CONSTRAINT `FK_2499EA45E869E299` FOREIGN KEY (`work_split_id`) REFERENCES `work_split` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_plan`
--

LOCK TABLES `work_plan` WRITE;
/*!40000 ALTER TABLE `work_plan` DISABLE KEYS */;
INSERT INTO `work_plan` VALUES
(1,'PPL Hypertrophy Intermediate','Rutina Push Pull Legs enfocada en hipertrofia con volumen moderado-alto y sobrecarga progresiva.',6,12,1,1,2,3),
(2,'Full Body Fat Loss Beginner','Rutina Full Body para pérdida de grasa y mejora de condición física general.',3,8,1,2,1,1),
(3,'Upper Lower Strength Advanced','Programa torso-pierna orientado a fuerza máxima con cargas altas y descansos largos.',4,10,1,4,3,2),
(4,'Bro Split Hypertrophy Advanced','División clásica por grupos musculares enfocada en alto volumen de entrenamiento.',5,12,1,1,3,4),
(5,'Full Body General Fitness Beginner','Rutina equilibrada para mejorar salud, movilidad, fuerza básica y condición física general.',3,6,1,6,1,1),
(6,'Glute Focus Intermediate','Programa específico para desarrollo de glúteos y piernas con énfasis en hipertrofia.',4,10,1,7,2,2);
/*!40000 ALTER TABLE `work_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_split`
--

DROP TABLE IF EXISTS `work_split`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_split` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_split`
--

LOCK TABLES `work_split` WRITE;
/*!40000 ALTER TABLE `work_split` DISABLE KEYS */;
INSERT INTO `work_split` VALUES
(1,'Full Body','Trabajo de todo el cuerpo en cada sesión.'),
(2,'Upper Lower','División torso y pierna.'),
(3,'Push Pull Legs','División por empuje, tirón y piernas.'),
(4,'Bro Split','Un grupo muscular principal por día.'),
(5,'Hybrid','Combinación de distintos sistemas de entrenamiento.');
/*!40000 ALTER TABLE `work_split` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-11 18:30:16
