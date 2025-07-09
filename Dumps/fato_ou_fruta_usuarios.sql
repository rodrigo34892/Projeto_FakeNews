-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fato_ou_fruta
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.24-MariaDB

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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','autor','leitor') NOT NULL DEFAULT 'leitor',
  `codigo_verificacao` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Rafael Gomes','rafa@gmail.com','$2y$10$.3N481Stnh4KM2xjFul1JOg4DJS5tnlW0EFFgaUNokn1Viqu5xPz.','autor','6gt4veyl1w'),(2,'Rodrigo nunes','rodrigo@gmail.com','$2y$10$HQBhl/5kw3zi1Cxd8f6f0.qrdK8jUvwuMR2DFQBDpC9raQi7jGWVS','leitor','pn73ra5yhw'),(3,'Rodrigo Nunes','rodriguinho@gmail.com','$2y$10$lSg4iE/npJgihA5/WCzGQ.qJpRQRdf86/NL87wLqL.v6lETXNXMXK','autor',NULL),(4,'Davi S','davi@gmail.com','$2y$10$yxtJfnPooeEVu8UG4PceCueQ.65057f3vP7VwpCHy8OU80ol3kP3G','leitor',NULL),(5,'Makima','makima@gmail.com','$2y$10$xvuwo4TQaSy/vf4YP2897OLyLapqC1SVrCCp9oBbSvWVRGyupMNn6','leitor',NULL),(6,'teste','teste@gmail.com','$2y$10$8xirTk5OHELsoIs2fLwzbeVNL9jp1xNmM4rtFMgtZg7jtzDRl8PW2','leitor',NULL),(7,'leon','leon@gmail.com','$2y$10$jnjIH0R7zP7ny7Ws8apb0Opum425oA7cgiDEiMvZmW0K7/AklANBu','autor',NULL),(8,'Rodrigo Teste','rodrigo01@gmail.com','$2y$10$kRH0W7Kiyhl00wnki7DLO.hq00FDG4sJlmf/m2mkBwi6HQvQkVnW2','leitor',NULL),(9,'Rodrigo N','rodrigon@gmail.com','$2y$10$i8fysQGVQkmMyK9g2qI1eOt1ErK.YoKCzNBQNZ3y7zwjdlGKG0z7y','leitor',NULL),(10,'adminstrador','admin@fatooufruta.com','$2y$10$72P6V6GEu.e6QFU4xIfUYOpHST/LijwEWi27V6h9UZTlMKCzb/lZW','admin',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-09 19:34:14
