/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `body_parts`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `body_parts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `disciplines`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disciplines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exercises`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `image_url` varchar(60) NOT NULL,
  `video_url` varchar(100) NOT NULL,
  `body_part_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `body_part_id` (`body_part_id`),
  CONSTRAINT `exercises_ibfk_1` FOREIGN KEY (`body_part_id`) REFERENCES `body_parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `levels`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `names` varchar(30) NOT NULL,
  `last_names` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `code` varchar(9) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `medical_obs` varchar(70) DEFAULT NULL,
  `discipline_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discipline_id` (`discipline_id`),
  CONSTRAINT `members_ibfk_1` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members_objectives`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members_objectives` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `objective_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `objective_id` (`objective_id`),
  CONSTRAINT `members_objectives_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `members_objectives_ibfk_2` FOREIGN KEY (`objective_id`) REFERENCES `objectives` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `membership_states`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_states` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memberships`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `memberships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `beginning` date NOT NULL,
  `ending` date NOT NULL,
  `member_id` int DEFAULT NULL,
  `membership_state_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `fk_memberships_membership_states` (`membership_state_id`),
  CONSTRAINT `fk_memberships_membership_states` FOREIGN KEY (`membership_state_id`) REFERENCES `membership_states` (`id`),
  CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `objectives`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `objectives` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `packages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `membership_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_id` (`membership_id`),
  CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `packages_exercises`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages_exercises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position` int DEFAULT NULL,
  `reps` int DEFAULT NULL,
  `sets` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `exercise_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  KEY `exercise_id` (`exercise_id`),
  CONSTRAINT `packages_exercises_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `packages_exercises_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schema_migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schema_migrations` (
  `version` varchar(128) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `reset_key` varchar(20) DEFAULT NULL,
  `activation_key` varchar(25) DEFAULT NULL,
  `state` varchar(12) NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_members`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `users_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_members_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'drgym'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed

--
-- Dbmate schema migrations
--

LOCK TABLES `schema_migrations` WRITE;
INSERT INTO `schema_migrations` (version) VALUES
  ('20230407222653'),
  ('20230407234751'),
  ('20230408000606'),
  ('20230408000607'),
  ('20230408000648'),
  ('20230408000659'),
  ('20230408002015'),
  ('20230408002334'),
  ('20230408002339'),
  ('20230408020803'),
  ('20230413035225'),
  ('20230413035244'),
  ('20230413035253'),
  ('20230413035259'),
  ('20230722011439'),
  ('20230809144748'),
  ('20230809145027'),
  ('20230809145940'),
  ('20230809151520'),
  ('20230810174001'),
  ('20230811011809'),
  ('20230823024902'),
  ('20230922011934');
UNLOCK TABLES;
