-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ticketbooking
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

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
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `usuarios_id` int NOT NULL,
  `enderecos_id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_empresas_enderecos` (`enderecos_id`),
  KEY `fk_empresas_usuarios` (`usuarios_id`) USING BTREE,
  CONSTRAINT `fk_empresas_enderecos` FOREIGN KEY (`enderecos_id`) REFERENCES `enderecos` (`id`),
  CONSTRAINT `fk_empresas_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES (1,'5884221fe2db2a54972b7d483988a212c88eaa6acc38b5a0d1dfdcb619e09f2b',1,1,'Trans nack','N',NULL,NULL,'2022-08-29 19:40:27',NULL),(2,'535697b1455cd0a42273b5fa535be7b248327d088fe0fe48eb00a03e2eed77ad',1,1,'Trans nack','N',NULL,NULL,'2022-08-29 19:41:26',NULL),(3,'549cd73f27f6501935a713a44dcdd454c034899c32cae338535cd94f1c9f968f',1,1,'Trans nack','N',NULL,NULL,'2022-08-29 19:41:32',NULL),(4,'0b9202e8f57898f61582d723a577ec0e07c5fabfc6b1929ba875e12c093cad43',1,1,'Trans nack','N',NULL,NULL,'2022-08-29 19:42:06',NULL);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enderecos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enderecos`
--

LOCK TABLES `enderecos` WRITE;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `enderecos` VALUES (1,'ccd1ca6dd73c2ce89c38273c0ea97831716009f6851d2305d5be111ba261925b','87033190','Rua araxá','987','casa','Maringa','PR','Br',NULL,'N',NULL,NULL,'2022-08-29 19:33:57',NULL);
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,NULL,'ivan','aefdfc4e3e719a7b67ebc1e011e3311c','8c25cb3686462e9a86d2883c5688a22fe738b0bbc85f458d2d2b5f3f667c6d5a',NULL,NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `veiculos`
--

DROP TABLE IF EXISTS `veiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `veiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `veiculos_tipo_id` int NOT NULL,
  `empresas_id` int NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `ano` varchar(45) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `placa` varchar(45) DEFAULT NULL,
  `lugares` varchar(45) DEFAULT NULL,
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_veiculos_empresas` (`empresas_id`),
  KEY `fk_veiculos_veiculos_tipo` (`veiculos_tipo_id`),
  CONSTRAINT `fk_veiculos_empresas` FOREIGN KEY (`empresas_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `fk_veiculos_veiculos_tipo` FOREIGN KEY (`veiculos_tipo_id`) REFERENCES `veiculos_tipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veiculos`
--

LOCK TABLES `veiculos` WRITE;
/*!40000 ALTER TABLE `veiculos` DISABLE KEYS */;
INSERT INTO `veiculos` VALUES (1,'0b086a1e14da3e60a9959815a5587aace1d4fe380657ee99568dd83956be4f73',1,1,'Volvo','mo','2019','1100','N','mo',NULL,NULL,NULL,'2022-08-29 20:10:28',NULL),(2,'8cb98dd961b7849a570b54dd0427982158acc26f5473547bc6416ae8c94b2cf8',1,1,'Volvo','mo','2019','1100','N','mo',NULL,NULL,NULL,'2022-08-29 20:11:06',NULL),(3,'5eb795a671a23e1169b5264fc0fa854fbb316c71c6fdfcf1f9008cd093882158',1,1,'Volvo','mo','2019','1100','N','mo',NULL,NULL,NULL,'2022-08-29 20:11:13',NULL),(4,'9b15ba7df73577826177fc5796ff395e1a65f9d56249c7bc7a3dbf4c87dbc7c5',1,1,'Volvo','mo','2019','1100','N','mo',NULL,NULL,NULL,'2022-08-29 20:11:47',NULL),(5,'73813b726630d79c751a14de01b651732cbbffd149206ea9903486b65a233f70',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:12:31',NULL),(6,'fb7ac4dfb9f03132a04a5600afd7ebde2694e57268708f43a3436a34f403250b',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:13:04',NULL),(7,'bfd2fa645e0aae8a8c60a980c0ba3e6845ba63b5211a90205cfe157f1f409de7',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:13:08',NULL),(8,'02b1848a0796aeefa675a4fdcb35fcbf7807871d9593910a877f780416f480d3',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:13:59',NULL),(9,'a772c09fd49dc93734b72f65b0ad4d6ee28cc3a1df4b9b57995399eb34144703',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:14:19',NULL),(10,'51c1c0490fbfc5ecc590c7789c0df8abc2fbaa0b8fccd1b5a5f94652b95a058b',1,1,'Volvo','mo','2019','1100','N','ABC1FD55',NULL,NULL,NULL,'2022-08-29 20:14:30',NULL);
/*!40000 ALTER TABLE `veiculos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `veiculos_tipo`
--

DROP TABLE IF EXISTS `veiculos_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `veiculos_tipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'sha2(now(),256)',
  `nome` varchar(50) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT NULL,
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veiculos_tipo`
--

LOCK TABLES `veiculos_tipo` WRITE;
/*!40000 ALTER TABLE `veiculos_tipo` DISABLE KEYS */;
INSERT INTO `veiculos_tipo` VALUES (1,NULL,'Onibus','Onibus mesmo',NULL,NULL,NULL,'2022-08-29 21:12:07',NULL),(2,NULL,'Van','Filhote de ônibus',NULL,NULL,NULL,'2022-08-29 21:12:07',NULL);
/*!40000 ALTER TABLE `veiculos_tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viagens`
--

DROP TABLE IF EXISTS `viagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `viagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `veiculos_id` int DEFAULT NULL,
  `descricao` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `origem` varchar(45) NOT NULL,
  `destino` varchar(45) NOT NULL,
  `data_saida` datetime NOT NULL,
  `data_chegada` datetime NOT NULL,
  `detalhes` text,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_viagens_veiculos` (`veiculos_id`) USING BTREE,
  CONSTRAINT `fk_viagens_veiculos` FOREIGN KEY (`veiculos_id`) REFERENCES `veiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viagens`
--

LOCK TABLES `viagens` WRITE;
/*!40000 ALTER TABLE `viagens` DISABLE KEYS */;
INSERT INTO `viagens` VALUES (1,'d60bd8da8a09059a7f3449cab2839e04d183f3071ed90cf237705499b0d453cd',NULL,'Descrição da viagem','Rio de Janeiro','São Paulo','2022-08-30 08:00:00','2022-08-30 18:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-29 20:27:51',NULL),(2,'4c1afb6f4d9304473363e75d328ec74adcff8b2ca4c517c4bd26dfaa9a86e2e7',2,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:41:22','2022-08-30 07:55:56'),(3,'d6f4b26df527a5a23931f193f91ae015ac15bffcd1616e0f0df49e7679f953e2',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:41:41',NULL),(4,'e350293eb3285f84ccaa25e4425fb89eb3967ca4bd58d700c9e09a271827e4f3',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:42:33',NULL),(5,'0ebea8abbc2e1b0f669955aa143488a8907598e34f9d60632105dc64adf1c995',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:44:09',NULL),(6,'87761f5c64434254bba38e291a8ab2afbcb4d6d9fa785adc206a01ef27db6f89',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:46:01',NULL),(7,'bef0c94416ddc8a18a970ff04b1690b2ebc0aa9f3b7abbf29c087810c10e64c0',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:46:23',NULL),(8,'2a757d763b8a1e61cd4e028c37058b71e848f9afadd929a8c22963befea868e7',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:46:29',NULL),(9,'4f2a68c36fc4f00c9bc4a28e14a18a09b29de2796046443a5d7432900d8d4015',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:47:25',NULL),(10,'0c3d6c073c2a8626204a489e576d66c97294531146a0a736e6864e6bd5d3eff4',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:48:33',NULL),(11,'709e76dffcb3b98140bdb885a833fa011f22160ba9112a28e833e1ac442cd4c5',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:49:05',NULL),(12,'bfae7e537bd4b27171605a5d989264b76329b6da7c941101d68ff39d8d2812e0',NULL,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:49:27',NULL),(13,'eb2dd93f46504e29e7c12f08d51bbacc604d4ee49d437e97078087ceb3aa81d2',2,'Viagem para praia','Maringá','Florianópolis','2022-08-31 20:00:00','2022-09-01 11:00:00','Nenhum detalhe','N',NULL,NULL,'2022-08-30 07:50:16',NULL);
/*!40000 ALTER TABLE `viagens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-01  0:32:15
