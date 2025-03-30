CREATE DATABASE  IF NOT EXISTS `gesquip_tst` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `gesquip_tst`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: gesquip_tst.vpshost11463.mysql.dbaas.com.br    Database: gesquip_tst
-- ------------------------------------------------------
-- Server version	5.7.32-35-log

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
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nm_empresa` varchar(45) NOT NULL,
  `nr_cnpj` varchar(45) NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'empresa_teste_01','123123','2025-03-30 19:15:40'),(2,'empresa_teste_o0','312321','2025-03-30 19:16:05');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `familia`
--

DROP TABLE IF EXISTS `familia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `familia` (
  `id_familia` int(11) NOT NULL AUTO_INCREMENT,
  `id_classe` int(11) NOT NULL,
  `ds_familia` varchar(30) NOT NULL,
  PRIMARY KEY (`id_familia`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `familia`
--

LOCK TABLES `familia` WRITE;
/*!40000 ALTER TABLE `familia` DISABLE KEYS */;
INSERT INTO `familia` VALUES (3,1,'ALAVANCA'),(4,1,'CAVADOR ARTICULADO'),(5,1,'CHIBANCA'),(6,1,'CISCADOR'),(8,1,'ENXADA'),(9,1,'MARRETA'),(14,1,'PÁ'),(17,1,'PARAFUSADEIRA'),(18,1,'PÉ DE CABRA'),(19,1,'VASSOURA'),(20,1,'SERRA'),(21,1,'CHAVE'),(32,1,'FERRO DE COVA'),(33,2,'ESMERILHADEIRA'),(35,2,'EXTENÇÃO'),(37,1,'MALETA DE FERRAMENTAS'),(38,1,'MACHADINHA'),(39,2,'FURADEIRA'),(40,2,'LIXADEIRA'),(41,2,'LAVA JATO'),(42,2,'FURADEIRA BOSCH'),(43,3,'ESCADA'),(44,2,'ASPIRADOR'),(45,3,'CARRO DE 2 PNEUS'),(46,3,'CARRO DE MÃO'),(48,1,'PONTEIRO'),(49,2,'POLITRIZ ANGULAR'),(50,2,'POLICORTE'),(51,3,'RISCADEIRA'),(53,7,'SOPRADOR'),(54,2,'REFLETOR'),(55,4,'NIVEL A LASER'),(56,2,'MESA VIBRATÓRIA'),(57,3,'MARTELETE'),(58,2,'MISTURADOR'),(59,3,'PISTOLA'),(62,3,'COMPACTADOR DE PERCUSSAO'),(63,5,'EXAUSTOR ESPACO CONFINADO'),(64,2,'SERRA');
/*!40000 ALTER TABLE `familia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,
  `nm_fantasia` varchar(100) NOT NULL,
  `rz_social` varchar(100) NOT NULL,
  `cd_cnpj` varchar(15) NOT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_familia` int(10) unsigned DEFAULT NULL,
  `ds_item` varchar(200) NOT NULL,
  `nr_disponibilidade` int(11) NOT NULL DEFAULT '1',
  `dt_cad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `natureza` varchar(45) NOT NULL DEFAULT 'local',
  `nv_permissao` int(11) NOT NULL,
  `cod_patrimonio` varchar(45) DEFAULT NULL,
  `tipo` varchar(5) NOT NULL,
  `desativado` int(11) DEFAULT NULL,
  `id_obra` int(11) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (4,3,'alavanca',999999999,'2025-01-08 13:45:57','PRÓPRIO',1,'d0ded8','F',NULL,1),(5,4,'cavador',1,'2025-01-08 13:46:05','PRÓPRIO',1,'834969','E',NULL,1),(6,8,'tramontina laranjeida',1,'2025-01-08 14:13:58','LOCADO',1,'c54332','E',NULL,1),(7,18,'pretor tramontina',2,'2025-01-08 14:15:20','PRÓPRIO',1,'3c8282','E',1,1),(8,9,'1kg ',1,'2025-01-08 14:16:12','LOCADO',1,'cce829','F',NULL,1),(9,5,'chibanca 1',1,'2025-01-09 09:22:24','PRÓPRIO',1,'e5577d','F',NULL,1),(11,3,'alavanca 01',1,'2025-01-09 09:22:38','PRÓPRIO',1,'c7bb86','F',NULL,1),(12,3,'alavanca 02 branca',1,'2025-01-09 09:23:14','PRÓPRIO',1,'0d803d','F',NULL,1),(13,4,'cavador preto',1,'2025-01-09 11:06:46','PRÓPRIO',1,'8bd028','E',NULL,1),(14,6,'teste',2,'2025-02-27 14:45:18','PRÓPRIO',1,'42af56','E',NULL,1),(15,18,'xpto',999999999,'2025-02-27 14:53:11','PRÓPRIO',1,'1c8d3d','E',NULL,1),(17,3,'xpto00',1,'2025-03-14 15:31:50','LOCADO',1,'2a7659','E',NULL,1),(18,59,'PISTOLA SILICONE',2,'2025-03-18 14:42:39','PRÓPRIO',1,'f6a275','F',NULL,1),(19,46,'carro de mão preto',1,'2025-03-19 23:10:02','PRÓPRIO',1,'6e6b60','E',NULL,1),(20,63,'teste 0009',2,'2025-03-21 15:15:01','LOCADO',2,'I20F63E','E',NULL,1),(21,38,'MACHADINHA 243hTBG',1,'2025-03-24 11:55:11','LOCADO',2,'I21F38F','F',NULL,1),(22,54,'REFLETOR 1200',1,'2025-03-24 21:27:35','PRÓPRIO',1,'I22F54E','E',NULL,1),(23,20,'SERRA MÁRMORE',1,'2025-03-24 21:28:04','PRÓPRIO',1,'I23F20E','E',NULL,1),(24,17,'PARAFUSADEIRA BOSCH',1,'2025-03-24 21:28:45','LOCADO',1,'I24F17F','F',NULL,1),(25,41,'LAVA JATO VERMELHO',1,'2025-03-25 10:21:22','PRÓPRIO',1,'I25F41E','E',NULL,1),(26,21,'CHAVE 8',1,'2025-03-25 10:21:37','PRÓPRIO',1,'I26F21F','F',NULL,1),(27,9,'MARTELO',2,'2025-03-25 10:36:08','PRÓPRIO',1,'I27F9F','F',NULL,1),(28,21,'CHAVE DE FENDA',999999999,'2025-03-25 10:36:31','PRÓPRIO',1,'I28F21F','F',NULL,1),(29,21,'CHAVE PHILIPS',1,'2025-03-25 10:37:05','PRÓPRIO',1,'I29F21F','F',NULL,1),(30,20,'SERRA MANUAL',1,'2025-03-25 10:38:10','PRÓPRIO',1,'I30F20F','F',NULL,1),(31,51,'ESTILETE',1,'2025-03-25 10:38:32','PRÓPRIO',1,'I31F51F','F',NULL,1),(32,17,'bosh laranja',1,'2025-03-25 11:01:38','PRÓPRIO',2,'I32F17F','F',NULL,1),(33,19,'teste',1,'2025-03-25 11:02:18','PRÓPRIO',1,'I33F19E','E',1,1),(34,51,'ESTILETE',1,'2025-03-25 11:02:18','LOCADO',1,'I34F51F','F',NULL,1),(35,20,'SERRA TICO TICO',1,'2025-03-25 11:02:18','LOCADO',1,'I35F20F','F',NULL,1),(36,21,'CHAVE ALLEN 12',0,'2025-03-25 11:02:18','LOCADO',1,'I36F21F','F',NULL,1),(37,21,'CHAVE ALLEN 13',1,'2025-03-25 11:02:18','LOCADO',1,'I37F21F','F',NULL,1),(38,21,'CHAVE ALLEN 14',54,'2025-03-25 11:02:18','LOCADO',1,'I38F21F','F',NULL,1),(39,58,'MISTURADOR HILTI',1,'2025-03-26 11:18:43','LOCADO',1,'I39F58E','E',NULL,1),(40,51,'RISCADEIRA PORCELANATO',1,'2025-03-26 11:19:01','PRÓPRIO',1,'I40F51F','F',NULL,1),(41,56,'MESA VIBRATÓRIA',1,'2025-03-26 11:20:30','LOCADO',1,'I41F56E','E',NULL,1),(42,39,'FURADEIRA HILTI',1,'2025-03-26 11:29:12','LOCADO',2,'I42F39E','E',NULL,1),(43,53,'SOPRADOR TÉRMICO',1,'2025-03-26 15:24:08','PRÓPRIO',1,'I43F53E','E',NULL,1),(44,59,'PISTOLA SILICONE',1,'2025-03-26 15:24:41','PRÓPRIO',1,'I44F59E','E',NULL,1),(45,41,'LAVA JATO AMARELO',1,'2025-03-26 15:29:57','PRÓPRIO',1,'I45F41E','E',NULL,1),(46,5,'CHIBANCA POLIDA',1,'2025-03-26 15:30:21','PRÓPRIO',1,'I46F5F','F',NULL,1),(47,21,'CHAVE SEXTAVADA',1,'2025-03-26 15:30:44','PRÓPRIO',1,'I47F21F','F',NULL,1),(48,21,'CHAVE SEXTAVADA 1',0,'2025-03-26 15:30:59','PRÓPRIO',1,'I48F21F','F',NULL,1),(49,14,'MASTER BLASTER',999999999,'2025-03-28 09:02:15','PRÓPRIO',1,'I49F14F','F',NULL,1),(50,33,'ESMERILHADEIRA BOSCH',0,'2025-03-28 13:00:05','LOCADO',1,'I50F33E','E',NULL,1);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_movimentacao`
--

DROP TABLE IF EXISTS `item_movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_movimentacao` (
  `id_item_movimentacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_movimentacao` int(10) unsigned DEFAULT NULL,
  `id_item` int(10) unsigned DEFAULT NULL,
  `dt_devolucao` datetime DEFAULT NULL,
  `id_autor` int(11) NOT NULL,
  `id_autor_final` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_item_movimentacao`),
  KEY `id_item_idx` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_movimentacao`
--

LOCK TABLES `item_movimentacao` WRITE;
/*!40000 ALTER TABLE `item_movimentacao` DISABLE KEYS */;
INSERT INTO `item_movimentacao` VALUES (1,1,17,'2025-03-17 22:02:42',1,NULL,1),(2,1,15,'2025-03-17 22:02:45',1,NULL,1),(3,1,14,'2025-03-17 22:02:43',1,NULL,1),(4,1,13,'2025-03-17 22:02:45',1,NULL,1),(5,1,12,'2025-03-17 22:02:44',1,NULL,1),(6,1,11,'2025-03-17 22:02:49',1,NULL,1),(7,1,9,'2025-03-17 22:02:48',1,NULL,1),(8,1,8,'2025-03-17 22:02:48',1,NULL,1),(9,1,7,'2025-03-17 22:02:47',1,NULL,1),(10,1,6,'2025-03-17 22:02:52',1,NULL,1),(11,1,5,'2025-03-17 22:02:49',1,NULL,1),(12,1,4,'2025-03-17 22:02:50',1,NULL,1),(13,2,15,'2025-03-17 22:04:28',1,NULL,1),(14,2,11,'2025-03-17 22:04:05',1,NULL,1),(15,2,8,'2025-03-17 22:03:56',1,NULL,1),(16,2,6,'2025-03-17 22:03:55',1,NULL,1),(17,2,5,'2025-03-17 22:04:06',1,NULL,1),(18,2,4,'2025-03-17 22:04:14',1,NULL,1),(19,3,17,'2025-03-17 22:51:24',1,NULL,1),(20,3,15,'2025-03-17 22:51:25',1,NULL,1),(21,3,14,'2025-03-17 22:51:27',1,NULL,1),(22,3,13,'2025-03-17 22:51:26',1,NULL,1),(23,3,11,'2025-03-17 22:51:29',1,NULL,1),(24,4,17,'2025-03-17 23:25:14',1,NULL,1),(25,4,14,'2025-03-17 23:25:15',1,NULL,1),(26,5,15,'2025-03-17 23:25:28',1,NULL,1),(27,5,13,'2025-03-17 23:25:28',1,NULL,1),(28,5,12,'2025-03-17 23:47:10',1,NULL,1),(29,6,11,'2025-03-17 23:25:02',1,NULL,1),(30,6,6,'2025-03-17 23:25:03',1,NULL,1),(31,7,17,'2025-03-18 10:45:26',1,NULL,1),(32,8,15,'2025-03-17 23:51:43',1,NULL,1),(33,9,15,'2025-03-18 10:45:24',1,NULL,1),(34,10,14,'2025-03-18 10:45:22',1,NULL,1),(35,11,12,'2025-03-18 10:34:38',1,NULL,1),(36,12,13,'2025-03-18 09:43:04',1,NULL,1),(37,13,11,'2025-03-18 09:32:40',1,NULL,1),(38,15,17,'2025-03-20 09:54:58',3,NULL,1),(39,15,13,'2025-03-19 14:47:20',3,NULL,1),(40,16,13,'2025-03-20 09:55:35',3,NULL,1),(41,17,11,'2025-03-20 09:55:38',3,NULL,1),(42,18,12,'2025-03-19 23:08:59',10,NULL,1),(43,18,7,'2025-03-19 23:09:04',10,NULL,1),(44,18,6,'2025-03-19 23:09:05',10,NULL,1),(45,19,19,'2025-03-20 09:55:40',10,NULL,1),(46,20,17,'2025-03-21 17:23:30',1,NULL,1),(47,20,13,'2025-03-21 17:23:06',1,NULL,1),(48,21,7,'2025-03-21 17:22:42',1,NULL,1),(49,22,8,'2025-03-24 11:47:28',1,NULL,1),(50,23,11,'2025-03-21 17:22:30',1,NULL,1),(51,24,13,'2025-03-24 11:47:32',10,NULL,1),(52,24,9,'2025-03-24 11:47:30',10,NULL,1),(53,34,20,'2025-03-24 11:47:41',1,NULL,1),(54,35,17,'2025-03-24 11:47:47',3,NULL,1),(55,35,11,'2025-03-24 15:05:25',3,NULL,1),(56,36,21,'2025-03-24 11:57:11',3,NULL,1),(57,37,21,'2025-03-24 16:09:56',3,NULL,1),(58,38,17,'2025-03-25 11:01:27',1,NULL,1),(59,39,21,'2025-03-25 11:01:33',1,NULL,1),(60,39,20,'2025-03-25 11:01:34',1,NULL,1),(61,40,9,'2025-03-24 21:33:51',10,NULL,1),(62,40,6,'2025-03-25 11:01:38',10,NULL,1),(63,43,13,'2025-03-25 11:01:45',10,NULL,1),(64,43,8,'2025-03-25 11:01:44',10,NULL,1),(65,44,25,'2025-03-26 11:23:36',10,NULL,1),(66,44,24,'2025-03-25 14:47:13',10,NULL,1),(67,44,23,'2025-03-26 11:27:31',10,NULL,1),(68,45,26,'2025-03-25 14:46:52',10,NULL,1),(69,45,22,'2025-03-26 14:15:44',10,NULL,1),(70,46,31,'2025-03-26 18:05:23',3,NULL,1),(71,47,30,'2025-03-25 14:56:33',3,NULL,1),(72,48,29,'2025-03-26 11:23:25',3,NULL,1),(73,48,28,'2025-03-26 11:23:26',3,NULL,1),(74,49,11,'2025-03-25 14:56:29',3,NULL,1),(75,50,14,'2025-03-26 15:28:34',3,NULL,1),(76,51,13,'2025-03-25 17:24:58',10,NULL,1),(77,51,12,'2025-03-25 17:25:16',10,NULL,1),(78,52,33,'2025-03-25 18:30:58',1,NULL,1),(79,52,32,'2025-03-25 19:23:07',1,NULL,1),(80,52,30,'2025-03-25 19:38:45',1,NULL,1),(81,52,26,'2025-03-25 19:23:17',1,NULL,1),(82,52,21,'2025-03-25 15:58:04',1,NULL,1),(83,53,38,'2025-03-25 19:47:17',1,NULL,1),(84,53,37,'2025-03-25 19:48:40',1,NULL,1),(85,53,36,'2025-03-25 19:44:04',1,NULL,1),(86,55,41,'2025-03-26 15:28:11',10,NULL,1),(87,55,39,'2025-03-26 15:34:21',10,NULL,1),(88,56,40,'2025-03-29 00:48:19',10,NULL,1),(89,56,5,'2025-03-26 15:28:23',10,NULL,1),(90,57,35,'2025-03-26 18:09:26',10,NULL,1),(91,57,26,'2025-03-30 17:59:09',10,NULL,1),(92,57,21,'2025-03-29 03:44:26',10,NULL,1),(93,58,42,'2025-03-29 13:33:10',10,NULL,1),(94,59,37,'2025-03-26 14:20:58',1,NULL,1),(95,59,36,'2025-03-26 14:21:16',1,NULL,1),(96,59,34,'2025-03-26 14:21:30',1,NULL,1),(97,59,33,'2025-03-26 14:21:34',1,NULL,1),(98,59,32,'2025-03-26 14:21:51',1,NULL,1),(99,60,44,'2025-03-30 18:15:44',10,1,1),(100,60,36,NULL,10,NULL,1),(101,64,48,NULL,10,NULL,1),(102,64,14,'2025-03-28 09:03:33',10,NULL,1),(103,68,47,'2025-03-27 13:46:35',11,NULL,1),(104,69,49,'2025-03-28 09:06:38',3,NULL,1),(105,70,49,'2025-03-28 09:10:54',1,NULL,1),(106,70,47,'2025-03-29 03:42:29',1,NULL,1),(107,71,50,'2025-03-28 13:01:48',10,NULL,1),(108,71,43,'2025-03-28 13:02:04',10,NULL,1),(109,71,34,'2025-03-28 17:20:43',10,NULL,1),(110,74,50,'2025-03-28 17:41:24',1,NULL,1),(111,74,46,'2025-03-29 03:41:04',1,NULL,1),(112,74,45,'2025-03-28 17:44:20',1,NULL,1),(113,74,43,'2025-03-28 17:55:03',1,NULL,1),(114,75,50,NULL,10,NULL,1),(115,75,47,'2025-03-29 22:11:55',10,NULL,1),(116,75,43,'2025-03-29 22:15:03',10,NULL,1),(117,76,23,'2025-03-30 17:38:58',10,11,1),(118,76,22,'2025-03-30 17:39:16',10,11,1),(119,77,47,'2025-03-30 17:29:10',1,11,1),(120,77,42,'2025-03-30 17:26:47',1,1,1),(121,77,35,'2025-03-30 17:26:36',1,1,1),(122,77,19,'2025-03-30 17:24:53',1,1,1),(123,77,13,'2025-03-30 17:19:40',1,11,1),(124,77,5,'2025-03-30 14:18:55',1,NULL,1);
/*!40000 ALTER TABLE `item_movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manutencao`
--

DROP TABLE IF EXISTS `manutencao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manutencao` (
  `id_manutencao` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `id_item_movimentacao` int(11) NOT NULL,
  `obs_in` varchar(300) NOT NULL,
  `obs_out` varchar(300) DEFAULT NULL,
  `id_autor` int(11) NOT NULL,
  `dt_inicio_manutencao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_fim_manutencao` datetime DEFAULT NULL,
  `id_autor_final` int(11) DEFAULT NULL,
  `custo_manutencao` decimal(10,2) DEFAULT '0.00',
  `id_obra` int(11) NOT NULL,
  PRIMARY KEY (`id_manutencao`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manutencao`
--

LOCK TABLES `manutencao` WRITE;
/*!40000 ALTER TABLE `manutencao` DISABLE KEYS */;
INSERT INTO `manutencao` VALUES (1,4,18,'Manutenção','Item quebrado',3,'2025-03-18 12:51:04','2025-03-18 17:09:58',NULL,NULL,1),(2,14,34,'teste','Item quebrado',1,'2025-01-18 12:52:45','2025-01-18 17:06:50',NULL,NULL,1),(3,5,17,'teste223','deu certo',1,'2025-03-18 12:53:15','2025-03-21 16:01:13',NULL,NULL,1),(4,15,33,'Manutenção','Item quebrado',3,'2025-03-18 14:46:51','2025-03-18 16:12:59',NULL,NULL,1),(5,14,34,'teste','teste',1,'2025-03-19 21:52:17','2025-03-21 16:04:04',NULL,NULL,1),(6,12,42,'partiu','Retorno da manutenção',10,'2025-03-19 23:12:01','2025-03-25 11:00:07',NULL,NULL,1),(7,19,45,'Manutenção','teste',3,'2025-03-20 10:02:39','2025-03-26 17:05:14',NULL,12345.00,1),(8,6,44,'teste','deu bom',1,'2025-03-21 13:06:09','2025-03-24 17:37:24',NULL,NULL,1),(9,5,17,'tste','teste',1,'2025-03-21 13:08:21','2025-03-25 14:18:32',NULL,NULL,1),(10,14,34,'teste','Equipamento Retornou da Empresa',1,'2025-03-21 13:09:19','2025-03-24 11:53:32',NULL,NULL,1),(11,9,7,'aaaaaaaaaaaaaaaaaa','teste',1,'2025-03-21 13:12:11','2025-03-21 16:14:41',NULL,NULL,1),(12,9,61,'Manutenção','123456',3,'2025-03-25 10:59:30','2025-03-26 20:48:40',NULL,123456.00,1),(13,17,58,'teste','teste',1,'2025-03-25 14:24:17','2025-03-25 17:39:20',NULL,1000.00,1),(14,24,66,'não liga','Item retornado da manutenção',10,'2025-03-25 14:53:40','2025-03-25 17:15:55',NULL,0.00,1),(15,30,80,'','rwa',1,'2025-03-25 16:38:48','2025-03-26 12:56:30',NULL,0.00,1),(16,36,85,'crebou','teste',1,'2025-03-25 16:44:06','2025-03-26 16:59:49',NULL,1000.00,1),(17,38,83,'teste de manutenção','Produto entrando novamente como disponível.',1,'2025-03-25 16:47:20','2025-03-25 17:14:25',NULL,0.00,1),(18,13,76,'Item deverá ir para manutenção','22222',3,'2025-03-25 17:24:58','2025-03-26 20:49:32',NULL,222222.00,1),(19,12,77,'Item quebrado\n','19',3,'2025-03-25 17:25:16','2025-03-26 15:27:32',NULL,1919.00,1),(20,23,67,'Disco não encaixa','2020',10,'2025-03-26 11:27:31','2025-03-26 15:29:00',NULL,2002.00,1),(21,11,74,'Manutenção','teste 123',3,'2025-03-26 12:53:12','2025-03-26 12:53:39',NULL,0.00,1),(22,36,95,'teste','teste 1514',1,'2025-03-26 14:21:16','2025-03-26 18:14:11',NULL,15514.00,1),(23,34,96,'teste','teste 15 16',1,'2025-03-26 14:21:30','2025-03-26 18:16:52',NULL,1516.00,1),(26,6,62,'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA','aaa',1,'2025-03-26 14:54:18','2025-03-26 18:18:07',NULL,2222.00,1),(29,25,44,'teste 1504','teste',1,'2025-03-26 15:04:32','2025-03-26 18:18:44',NULL,1546.00,1),(30,31,46,'teste 1505','1555',1,'2025-03-26 15:05:24','2025-03-26 18:18:21',NULL,1505.00,1),(31,37,59,'teste 1506','teste 1506',1,'2025-03-26 15:06:06','2025-03-26 18:17:09',NULL,1506.00,1),(32,35,57,'teste 1509','teste',1,'2025-03-26 15:09:28','2025-03-26 15:10:24',NULL,0.00,1),(33,17,38,'xpto teste','teste1529',1,'2025-03-26 15:29:37','2025-03-26 15:29:52',NULL,1529.00,1),(34,39,55,'Dando choque','correção de fuga de corrente',10,'2025-03-26 15:34:21','2025-03-26 15:35:09',NULL,0.00,1),(35,9,40,'Manutenção','adasd',3,'2025-03-26 20:49:30','2025-03-26 20:49:48',NULL,12000.00,1),(36,12,51,'Manutenção','RETORNO DE MANUTENLÇAO OK',3,'2025-03-26 20:58:46','2025-03-28 09:10:13',NULL,32122.00,1),(37,47,68,'arrumar o lado direito no canto inferior','EQUIPAMENTO OK.',11,'2025-03-27 13:46:35','2025-03-28 09:07:04',NULL,12345.00,1),(38,28,48,'retifica','condenado',11,'2025-03-27 13:47:41','2025-03-28 13:03:27',NULL,0.00,1),(39,14,64,'ITEM QUEBRADO AO RETORNAR COM O FUNCIONÁRIO.','teste',3,'2025-03-15 09:03:33','2025-03-30 18:08:16',1,123.00,1),(40,24,44,'teste_0909','teste0909',1,'2025-03-28 09:09:26','2025-03-28 09:09:41',NULL,909.00,1),(41,49,70,'teste0910','teste 0911',1,'2025-03-28 09:10:54','2025-03-28 09:11:16',NULL,9011.00,1),(42,43,71,'não está esquentando','capacitor trocado',10,'2025-03-28 13:02:04','2025-03-28 13:02:45',NULL,60.00,1),(43,43,75,'fuga de corrente','oxente',10,'2025-03-29 22:15:03','2025-03-30 18:10:53',1,123.00,1),(45,14,64,'teste1604',NULL,1,'2025-03-30 16:04:38',NULL,NULL,0.00,1);
/*!40000 ALTER TABLE `manutencao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimentacao`
--

DROP TABLE IF EXISTS `movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(11) NOT NULL DEFAULT '1',
  `id_responsavel` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `dt_movimentacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_finalizacao` datetime DEFAULT NULL,
  `id_autor_final` int(11) DEFAULT NULL,
  `ds_movimentacao` varchar(200) DEFAULT NULL,
  `id_obra` int(11) NOT NULL,
  PRIMARY KEY (`id_movimentacao`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimentacao`
--

LOCK TABLES `movimentacao` WRITE;
/*!40000 ALTER TABLE `movimentacao` DISABLE KEYS */;
INSERT INTO `movimentacao` VALUES (1,'1',1,1,'2025-01-17 10:01:52','2025-03-17 22:03:53',NULL,'Retirada de equipamentos',1),(2,'1',3,1,'2025-03-17 18:03:07','2025-03-17 22:25:28',NULL,'Retirada de equipamentos',1),(3,'1',10,1,'2025-03-17 12:33:43','2025-03-17 22:52:29',NULL,'Retirada de equipamentos',1),(4,'1',3,1,'2025-03-17 13:07:34','2025-03-17 23:27:16',NULL,'Retirada de equipamentos',1),(5,'1',1,1,'2025-03-17 14:07:56','2025-03-17 23:45:10',NULL,'Retirada de equipamentos',1),(6,'1',10,1,'2025-03-17 06:08:18','2025-03-17 23:27:03',NULL,'Retirada de equipamentos',1),(7,'1',10,1,'2025-03-17 23:51:22','2025-03-18 10:45:26',NULL,'Retirada de equipamentos',1),(8,'1',10,1,'2025-03-17 23:51:34','2025-03-18 02:52:43',NULL,'Retirada de equipamentos',1),(9,'1',1,1,'2025-03-17 23:56:22','2025-03-18 10:45:24',NULL,'Retirada de equipamentos',1),(10,'1',3,1,'2025-03-17 23:56:33','2025-03-18 10:45:22',NULL,'Retirada de equipamentos',1),(11,'1',1,1,'2025-03-17 23:56:47','2025-03-18 10:34:39',NULL,'Retirada de equipamentos',1),(12,'1',10,1,'2025-03-17 17:57:10','2025-03-18 08:43:04',NULL,'Retirada de equipamentos',1),(13,'1',3,1,'2025-03-17 23:58:20','2025-03-18 06:33:40',NULL,'Retirada de equipamentos',1),(15,'1',3,3,'2025-03-19 14:45:24','2025-03-20 09:54:58',NULL,'Retirada de equipamentos',1),(16,'1',1,3,'2025-03-19 22:13:31','2025-03-20 09:55:35',NULL,'Retirada de equipamentos',1),(17,'1',1,3,'2025-03-19 22:14:47','2025-03-20 09:55:38',NULL,'Retirada de equipamentos',1),(18,'1',10,10,'2025-03-19 23:08:14','2025-03-19 23:09:06',NULL,'a',1),(19,'1',10,10,'2025-03-19 23:10:18','2025-03-20 09:55:40',NULL,'c',1),(20,'1',11,1,'2025-03-21 13:27:45','2025-03-21 17:23:32',NULL,'gdgdgd',1),(21,'1',11,1,'2025-03-21 13:29:20','2025-03-21 17:22:44',NULL,'teste',1),(22,'1',1,1,'2025-03-21 13:35:40','2025-03-24 11:47:28',NULL,'teste',1),(23,'1',11,1,'2025-03-21 14:22:11','2025-03-21 17:22:31',NULL,'teste',1),(24,'1',10,10,'2025-03-21 15:08:29','2025-03-24 11:47:32',NULL,'a',1),(34,'1',11,1,'2025-03-23 17:05:14','2025-03-24 11:47:41',NULL,'testeee',1),(35,'1',3,3,'2025-03-24 11:47:04','2025-03-24 15:05:25',NULL,'Retirada de equipamentos',1),(36,'1',3,3,'2025-03-24 11:55:51','2025-03-24 11:57:12',NULL,'Retirada de equipamentos',1),(37,'1',3,3,'2025-03-24 16:09:32','2025-03-24 16:09:56',NULL,'Retirada de equipamentos',1),(38,'1',11,1,'2025-03-17 10:01:52','2025-03-25 11:01:27',NULL,'teste3',1),(39,'1',1,1,'2025-03-24 19:32:37','2025-03-25 11:01:34',NULL,'4444',1),(40,'1',10,10,'2025-03-24 21:17:27','2025-03-25 11:01:38',NULL,'a',1),(43,'1',10,10,'2025-03-24 21:42:07','2025-03-25 11:01:45',NULL,'',1),(44,'1',15,10,'2025-03-25 10:21:46','2025-03-26 11:27:31',NULL,'',1),(45,'1',16,10,'2025-03-25 10:22:06','2025-03-26 14:15:44',NULL,'',1),(46,'1',3,3,'2025-03-25 10:38:56','2025-03-26 18:05:25',NULL,'Retirada de equipamentos',1),(47,'1',1,3,'2025-03-25 10:39:22','2025-03-25 14:56:33',NULL,'Retirada de equipamentos',1),(48,'1',15,3,'2025-03-25 10:39:32','2025-03-26 11:23:26',NULL,'Retirada de equipamentos',1),(49,'1',1,3,'2025-03-25 10:39:43','2025-03-25 14:56:29',NULL,'Retirada de equipamentos',1),(50,'1',17,3,'2025-03-25 11:00:50','2025-03-26 15:28:34',NULL,'Retirada de equipamentos',1),(51,'1',22,10,'2025-03-25 14:49:48','2025-03-25 17:25:16',NULL,'',1),(52,'1',1,1,'2025-03-25 14:56:58','2025-03-25 19:41:48',NULL,'teste_para_manutencao',1),(53,'1',1,1,'2025-03-25 16:43:12','2025-03-25 19:48:45',NULL,'teste',1),(54,'1',11,10,'2025-03-25 17:59:38','2025-03-26 11:18:28',NULL,'',1),(55,'1',24,10,'2025-03-26 11:20:42','2025-03-26 15:34:22',NULL,'',1),(56,'1',23,10,'2025-03-26 11:22:58','2025-03-29 00:48:30',NULL,'',1),(57,'1',25,10,'2025-03-26 11:23:57','2025-03-30 17:59:10',11,'',1),(58,'1',24,10,'2025-03-26 11:29:22','2025-03-29 13:33:10',NULL,'',1),(59,'1',1,1,'2025-03-26 14:17:21','2025-03-26 14:21:51',NULL,'teste_verificação',1),(60,'1',26,10,'2025-03-26 15:26:53',NULL,NULL,'',1),(61,'1',27,10,'2025-03-26 15:27:27',NULL,NULL,'',1),(64,'1',27,10,'2025-03-26 15:31:08',NULL,NULL,'',1),(68,'1',15,11,'2025-03-27 13:45:08','2025-03-27 13:46:35',NULL,'chave',1),(69,'1',10,3,'2025-03-28 09:02:28','2025-03-28 09:06:38',NULL,'Retirada de equipamentos',1),(70,'1',1,1,'2025-03-28 09:10:15','2025-03-29 03:42:29',NULL,'teste0910',1),(71,'1',25,10,'2025-03-28 13:00:32','2025-03-30 17:53:58',11,'',1),(74,'1',1,1,'2025-03-28 13:33:52','2025-03-29 03:42:07',NULL,'teste',1),(75,'1',10,10,'2025-03-29 22:11:26',NULL,NULL,'',1),(76,'1',30,10,'2025-03-29 22:24:19','2025-03-30 17:39:19',11,'',1),(77,'1',11,1,'2025-03-30 14:10:11','2025-03-30 17:29:12',11,'teste1410',1);
/*!40000 ALTER TABLE `movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `movimentacao_completa`
--

DROP TABLE IF EXISTS `movimentacao_completa`;
/*!50001 DROP VIEW IF EXISTS `movimentacao_completa`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `movimentacao_completa` AS SELECT 
 1 AS `CD_MOVIMENTACAO`,
 1 AS `CD_MOVIMENTAÇÃO_ITEM`,
 1 AS `CD_ITEM`,
 1 AS `DS_ITEM`,
 1 AS `NATUREZA_IT`,
 1 AS `CD_PATRIMONIO`,
 1 AS `CD_FAMILIA`,
 1 AS `DS_FAMILIA`,
 1 AS `CD_FUNCIONARIO`,
 1 AS `NM_FUNCIONARIO`,
 1 AS `AUTOR_MOVIMENTACAO`,
 1 AS `DT_MOVIMENTACAO`,
 1 AS `DT_DEVOLUCAO_ITEM`,
 1 AS `DT_FECHAMENTO_MOVIMENTACAO`,
 1 AS `MOVIMENTACAO`,
 1 AS `CD_DISPONIBILIDADE`,
 1 AS `STATUS_ITEM`,
 1 AS `STATUS_FINAL`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `obra`
--

DROP TABLE IF EXISTS `obra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `obra` (
  `id_obra` int(11) NOT NULL AUTO_INCREMENT,
  `ds_obra` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `endereco` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `CNPJ` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `resp_tec` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_crea` int(11) NOT NULL,
  `dt_cad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) COLLATE latin1_general_ci NOT NULL DEFAULT 'implementacao',
  PRIMARY KEY (`id_obra`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obra`
--

LOCK TABLES `obra` WRITE;
/*!40000 ALTER TABLE `obra` DISABLE KEYS */;
INSERT INTO `obra` VALUES (1,'teste','teste','123','teste',1,123,'2025-03-30 19:21:17','1'),(2,'teste01','teste01','123321','teste01',1,321,'2025-03-30 19:21:44','1'),(3,'teste02','teste02','222','teste02',2,222,'2025-03-30 19:22:07','1');
/*!40000 ALTER TABLE `obra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_obra`
--

DROP TABLE IF EXISTS `usuario_obra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_obra` (
  `id_usuario_obra` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_obra` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario_obra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_obra`
--

LOCK TABLES `usuario_obra` WRITE;
/*!40000 ALTER TABLE `usuario_obra` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_obra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(45) NOT NULL,
  `matricula` varchar(45) DEFAULT NULL,
  `login` varchar(60) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `nm_usuario` varchar(45) NOT NULL,
  `nr_contato` varchar(45) NOT NULL,
  `id_empresa` varchar(45) NOT NULL,
  `tp_usuario` varchar(45) NOT NULL DEFAULT 'user',
  `nv_permissao` int(11) NOT NULL DEFAULT '0',
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desativado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'12312312312','46207','hants','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','Eliabe G Paz','81900000000','1','super_admin',3,'2024-12-05 00:00:00',0),(2,'12312312312','46208','operador','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','Eliabe operador','81900000000','2','operador',3,'2024-12-05 00:00:00',0),(3,'12312312312','891236','Thyago','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','Thyago','81900000000','1','super_admin',3,'2025-03-17 21:07:18',0),(10,'12312312312','745891','israel','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','israel','81900000000','1','super_admin',3,'2025-03-17 21:07:18',0),(11,'12312332112','745891','ARI','$2y$10$lNtT6jCOZlS44xhECE.PuOohRypbXySJZts/6jGHKOdve3B1HxkCy','Ari','81900000000','2','admin',3,'2025-03-19 15:20:02',0),(15,'12345678900','1230','israel','$2y$10$K9KTTn4R2pl2Aj8GXUkXWu7EhWLfnkqR6YkxuWG7.r2zXS4m3we/a','José Bonifácio','81999999999','1','user',1,'2025-03-25 10:20:20',0),(16,'23412432342','1532','israel','$2y$10$332Ecf6q3x3juzc9AJGksepGaazkr4Wm3qBGN/EewJ863akJCT5D2','Rafael Ramos','83423212311','1','user',2,'2025-03-25 10:20:46',0),(17,'01234567899','4312','Thyago','$2y$10$Kf72IsV84vMmg1OpTq4kLu/XS67yyP1PZj4o.hzl.DZRHHPtwdlay','LUCAS ALMEIDA','819988888888','1','user',1,'2025-03-25 10:44:45',0),(18,'09889076544','9987','Thyago','$2y$10$idOinE5qD03LqKgkG6cgD.klTjuGnaWxCTGplbRFW3Y839x36plvW','MARIANA COSTA','81992231221','1','user',1,'2025-03-25 10:45:17',0),(19,'67543223567','6654','Thyago','$2y$10$0cDQkQ/OuodX5Cr5eKXtQea0U3q06Qed4S9pFXV3n73sN/0P1fbBu','GABRIEL SILVA','81987788776','1','user',2,'2025-03-25 10:45:52',0),(20,'99000988765','8674','Thyago','$2y$10$mEUEKli1bi9lxSsfEI8Ir.73FVMkrG.vRrpVTyN7InnaCim9wqD6O','ANA BEZERRA','87766555622','1','user',3,'2025-03-25 10:46:16',0),(21,'88776666676','9554','Thyago','$2y$10$T87QWNKbLXzACj9M8qh4k.X0YeIhg4d0r9gJUeVC2NnT/I3v./2tq','EDNA MODAS','81997767676','1','user',3,'2025-03-25 10:46:52',0),(22,'24153625212','1722','israel','$2y$10$4drvhvSNBDajO0jJ0qJGZuFYlj6eN8NzY.RzAs6od4SqktJZ1CgBS','Falcão Serafim','83923121232','1','user',1,'2025-03-25 14:49:03',0),(23,'24156675323','4214','israel','$2y$10$cwNMHy6fNBR3jbsvy.uNRucL6Uo4Q0nf5JPpGa1A89Puwuy46mcjO','Jean Carlos','11952245223','1','user',1,'2025-03-25 14:49:37',0),(24,'42141491212','7153','israel','$2y$10$9xYa0G2SzuA0f/lU6j4nLOq5yZYDKEaMnibpgLj.8k7PQ90RnWE/S','Abimael Gonçalves','11923214141','1','user',1,'2025-03-26 11:16:53',0),(25,'52314109212','2412','israel','$2y$10$QGByD4P0GO5gh7XIk7X5sOwR1SAl0HwGFDQ8/R7WZhdx8j6iPVNnC','Sérgio Emanuel','21988134124','1','user',1,'2025-03-26 11:17:34',0),(26,'41412819121','9813','israel','$2y$10$woz4I4sNPaRuRdaHY32R3ePvDDw8biKSC6XPpRDvgdX5EmEunlxQW','Graciliano Ramos','21942342311','1','user',1,'2025-03-26 15:26:04',0),(27,'81212412311','4124','israel','$2y$10$Jk5pe7Th8X4jHb1ZaESZCeUT6I0/B3SVC1U2txQ1s9qHkW8Cm/sbS','José Barbosa','81921427281','1','user',1,'2025-03-26 15:26:34',0),(28,'03226533479','123456','ARI','$2y$10$vVXYR7vW7X4wlwkzXkRrx.RzrKI6ZpDMEXo1v5f.gOurbK0fe5CY6','Ari filho','61996079249','1','user',3,'2025-03-27 13:51:54',0),(29,'31234124124','1122','israel','$2y$10$/idAQ0hZF3Y30Dh7gJPzPe.6HdGmn1cGaSKQgai2b2BqsxsCAmnLK','Lucilo Pessoa','81992131231','1','user',1,'2025-03-28 13:04:47',0),(30,'12312341241','1144','israel','$2y$10$80nmrimibLJWW19dAd8iROiOkgLtYb9GhonrnRNB0PVpdcxk7OxYq','Luiz Antônio','81921231231','1','user',1,'2025-03-29 22:23:55',0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vw_tx_utilizacao_item`
--

DROP TABLE IF EXISTS `vw_tx_utilizacao_item`;
/*!50001 DROP VIEW IF EXISTS `vw_tx_utilizacao_item`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_tx_utilizacao_item` AS SELECT 
 1 AS `cod_item`,
 1 AS `item`,
 1 AS `ds_item`,
 1 AS `qtd_repeticao`,
 1 AS `total_tempo_uso_hora`,
 1 AS `total_dia_utilizado_mes`,
 1 AS `taxa_utilizacao_real`,
 1 AS `taxa_utilizacao_final`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'gesquip_tst'
--

--
-- Final view structure for view `movimentacao_completa`
--

/*!50001 DROP VIEW IF EXISTS `movimentacao_completa`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gesquip_tst`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `movimentacao_completa` AS select `a`.`id_movimentacao` AS `CD_MOVIMENTACAO`,`a`.`id_item_movimentacao` AS `CD_MOVIMENTAÇÃO_ITEM`,`a`.`id_item` AS `CD_ITEM`,`b`.`ds_item` AS `DS_ITEM`,`b`.`natureza` AS `NATUREZA_IT`,`b`.`cod_patrimonio` AS `CD_PATRIMONIO`,`b`.`id_familia` AS `CD_FAMILIA`,`c`.`ds_familia` AS `DS_FAMILIA`,`d`.`id_responsavel` AS `CD_FUNCIONARIO`,`e`.`nm_usuario` AS `NM_FUNCIONARIO`,`a`.`id_autor` AS `AUTOR_MOVIMENTACAO`,date_format(`d`.`dt_movimentacao`,'%d-%m-%Y %H:%i:%s') AS `DT_MOVIMENTACAO`,date_format(`a`.`dt_devolucao`,'%d-%m-%Y %H:%i:%s') AS `DT_DEVOLUCAO_ITEM`,date_format(`d`.`dt_finalizacao`,'%d-%m-%Y %H:%i:%s') AS `DT_FECHAMENTO_MOVIMENTACAO`,`d`.`ds_movimentacao` AS `MOVIMENTACAO`,`b`.`nr_disponibilidade` AS `CD_DISPONIBILIDADE`,(case when (`b`.`nr_disponibilidade` = 1) then 'Disponível' when (`b`.`nr_disponibilidade` = 2) then 'Indisponível' when (`b`.`nr_disponibilidade` = 3) then 'Manutenção' when (`b`.`nr_disponibilidade` = 4) then 'Inativo' when (`b`.`nr_disponibilidade` = 999999999) then 'Quebrado' else 'Desconhecido' end) AS `STATUS_ITEM`,(case when (`b`.`nr_disponibilidade` in (1,2)) then 'Disponível' when (`b`.`nr_disponibilidade` = 999999999) then 'Quebrado' else 'Desconhecido' end) AS `STATUS_FINAL` from ((((`item_movimentacao` `a` join `item` `b`) join `familia` `c`) join `movimentacao` `d`) join `usuarios` `e`) where ((`a`.`id_item` = `b`.`id_item`) and (`c`.`id_familia` = `b`.`id_familia`) and (`a`.`id_movimentacao` = `d`.`id_movimentacao`) and (`d`.`id_responsavel` = `e`.`id_usuario`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tx_utilizacao_item`
--

/*!50001 DROP VIEW IF EXISTS `vw_tx_utilizacao_item`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gesquip_tst`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tx_utilizacao_item` AS select `movimentacao_completa`.`CD_PATRIMONIO` AS `cod_item`,`movimentacao_completa`.`CD_ITEM` AS `item`,`movimentacao_completa`.`DS_ITEM` AS `ds_item`,count(`movimentacao_completa`.`CD_ITEM`) AS `qtd_repeticao`,sum(timestampdiff(HOUR,str_to_date(`movimentacao_completa`.`DT_MOVIMENTACAO`,'%d-%m-%Y %H:%i:%s'),str_to_date(`movimentacao_completa`.`DT_DEVOLUCAO_ITEM`,'%d-%m-%Y %H:%i:%s'))) AS `total_tempo_uso_hora`,round((sum(timestampdiff(HOUR,str_to_date(`movimentacao_completa`.`DT_MOVIMENTACAO`,'%d-%m-%Y %H:%i:%s'),str_to_date(`movimentacao_completa`.`DT_DEVOLUCAO_ITEM`,'%d-%m-%Y %H:%i:%s'))) / 9),2) AS `total_dia_utilizado_mes`,round((((sum(timestampdiff(HOUR,str_to_date(`movimentacao_completa`.`DT_MOVIMENTACAO`,'%d-%m-%Y %H:%i:%s'),str_to_date(`movimentacao_completa`.`DT_DEVOLUCAO_ITEM`,'%d-%m-%Y %H:%i:%s'))) / count(`movimentacao_completa`.`CD_ITEM`)) / 176) * 100),2) AS `taxa_utilizacao_real`,round((((sum(timestampdiff(HOUR,str_to_date(`movimentacao_completa`.`DT_MOVIMENTACAO`,'%d-%m-%Y %H:%i:%s'),str_to_date(`movimentacao_completa`.`DT_DEVOLUCAO_ITEM`,'%d-%m-%Y %H:%i:%s'))) / 9) * 100) / 30),2) AS `taxa_utilizacao_final` from `movimentacao_completa` where (str_to_date(`movimentacao_completa`.`DT_MOVIMENTACAO`,'%d-%m-%Y %H:%i:%s') between '2025-03-01' and '2025-03-31') group by `movimentacao_completa`.`CD_PATRIMONIO`,`movimentacao_completa`.`CD_ITEM`,`movimentacao_completa`.`DS_ITEM` order by `movimentacao_completa`.`CD_ITEM` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-30 19:35:21
