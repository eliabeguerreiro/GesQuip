-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: projeto_patrimonio
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nm_cargo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `ds_categoria` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nv_permissao` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Ferramentas Manuais','1'),(2,'Ferramentas Elétricas','0'),(3,'Equipamentos de Construção','0'),(4,'Equipamentos de Medição','0'),(5,'Equipamentos de Segurança','0'),(6,'Equipamentos de Pintura','0'),(7,'Equipamentos de Jardinagem','0'),(8,'Ferragens e Fixadores','1'),(9,'Consumíveis','0');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classe` (
  `id_classe` int NOT NULL AUTO_INCREMENT,
  `ds_ds_classe` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classe`
--

LOCK TABLES `classe` WRITE;
/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
INSERT INTO `classe` VALUES (1,'Ferramentas Manuais'),(2,'Ferramentas Elétricas'),(3,'Equipamentos de Construção'),(4,'Equipamentos de Medição'),(5,'Equipamentos de Segurança'),(6,'Equipamentos de Pintura'),(7,'Equipamentos de Jardinagem'),(8,'Ferragens e Fixadores'),(9,'Consumíveis');
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilidade`
--

DROP TABLE IF EXISTS `disponibilidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disponibilidade` (
  `id_disponibilidade` int NOT NULL AUTO_INCREMENT,
  `nr_disponibilidade` int NOT NULL DEFAULT '0' COMMENT '0 disponivel, 1 indisponivel, 2 manutenção',
  `id_item_movimentacao` int NOT NULL,
  `dt_alteracao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_disponibilidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilidade`
--

LOCK TABLES `disponibilidade` WRITE;
/*!40000 ALTER TABLE `disponibilidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `disponibilidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id_empresa` int NOT NULL AUTO_INCREMENT,
  `nm_empresa` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nr_cnpj` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `familia`
--

DROP TABLE IF EXISTS `familia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `familia` (
  `id_familia` int NOT NULL AUTO_INCREMENT,
  `id_classe` int NOT NULL,
  `ds_familia` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_familia`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `id_fornecedor` int NOT NULL AUTO_INCREMENT,
  `nm_fantasia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rz_social` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cd_cnpj` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `id_item` int NOT NULL AUTO_INCREMENT,
  `id_familia` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ds_item` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nr_disponibilidade` int NOT NULL DEFAULT '1',
  `dt_cad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `natureza` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'local',
  `nv_permissao` int NOT NULL,
  `cod_patrimonio` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (4,'3','teste',0,'2025-01-08 13:45:57','proprio',2,'d0ded8'),(5,'4','teste',1,'2025-01-08 13:46:05','proprio',1,'834969'),(6,'8','tramontina laranjeida',0,'2025-01-08 14:13:58','locado',1,'c54332'),(7,'18','pretor tramontina',1,'2025-01-08 14:15:20','proprio',1,'3c8282'),(8,'9','1kg ',999999999,'2025-01-08 14:16:12','locado',2,'cce829'),(9,'5','chibanca 1',1,'2025-01-09 09:22:24','proprio',1,'e5577d'),(11,'3','alavanca 01',0,'2025-01-09 09:22:38','proprio',1,'c7bb86'),(12,'3','alavanca 02',1,'2025-01-09 09:23:14','proprio',1,'0d803d'),(13,'4','cavador preto',1,'2025-01-09 11:06:46','proprio',3,'8bd028'),(14,'6','teste',0,'2025-02-27 14:45:18','propio',2,'42af56'),(15,'18','reste',0,'2025-02-27 14:53:11','propio',1,'1c8d3d');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_movimentacao`
--

DROP TABLE IF EXISTS `item_movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_movimentacao` (
  `id_item_movimentacao` int NOT NULL AUTO_INCREMENT,
  `id_movimentacao` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_item` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dt_devolucao` datetime DEFAULT NULL,
  `id_autor` int NOT NULL,
  `tipo` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_item_movimentacao`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_movimentacao`
--

LOCK TABLES `item_movimentacao` WRITE;
/*!40000 ALTER TABLE `item_movimentacao` DISABLE KEYS */;
INSERT INTO `item_movimentacao` VALUES (1,'14','1','2025-01-08 17:31:32',1,1),(2,'14','2','2025-01-08 17:31:30',1,1),(3,'14','4','2025-01-08 17:31:34',1,1),(4,'14','5','2025-01-09 11:34:20',1,1),(5,'14','8','2025-01-08 17:31:17',1,1),(6,'15','1','2025-01-09 11:41:52',1,1),(7,'15','3','2025-01-09 11:42:22',1,1),(8,'15','4','2025-01-09 11:43:04',1,1),(9,'15','5','2025-01-09 11:43:01',1,1),(10,'15','8','2025-01-09 11:42:39',1,1),(11,'16','2','2025-01-09 11:59:23',1,1),(12,'16','3','2025-01-09 11:59:34',1,1),(13,'16','4','2025-01-09 12:03:00',1,1),(14,'16','6','2025-01-09 12:00:27',1,1),(15,'16','7','2025-01-09 12:03:01',1,1),(16,'17','9','2025-01-09 13:02:02',1,1),(17,'17','10','2025-01-09 13:02:01',1,1),(18,'17','11','2025-01-09 13:02:01',1,1),(19,'17','12','2025-01-09 13:01:57',1,1),(20,'18','6','2025-01-09 13:02:07',1,1),(21,'18','7','2025-01-09 13:02:07',1,1),(22,'19','9','2025-01-16 17:34:34',1,1),(23,'19','10','2025-01-10 13:24:13',1,1),(24,'19','11','2025-01-10 13:24:10',1,1),(25,'19','12','2025-01-10 13:27:07',1,1),(26,'21','1','2025-01-09 13:59:09',1,1),(27,'21','2','2025-01-09 13:59:10',1,1),(28,'21','3','2025-01-09 13:59:11',1,1),(29,'21','4','2025-01-09 13:59:08',1,1),(30,'21','5','2025-01-09 13:59:08',1,1),(31,'21','6','2025-01-09 13:59:07',1,1),(32,'22','7','2025-01-16 17:34:48',1,1),(33,'22','13','2025-01-09 14:14:46',1,1),(34,'23','10','2025-01-10 13:30:57',1,1),(35,'23','11','2025-01-10 13:30:55',1,1),(36,'23','13','2025-01-10 13:43:35',1,1),(37,'24','11','2025-01-16 17:44:53',1,1),(38,'24','12','2025-01-16 19:42:11',1,1),(39,'24','13','2025-01-16 19:42:11',1,1),(40,'25','5','2025-01-16 19:42:15',1,1),(41,'25','6','2025-01-16 19:42:14',1,1),(42,'26','9','2025-01-21 18:31:34',1,1),(43,'26','11','2025-01-21 18:31:34',1,1),(44,'26','12','2025-01-21 18:31:35',1,1),(45,'26','13','2025-01-21 18:31:37',1,1),(46,'27','6','2025-01-21 18:31:30',1,1),(47,'27','7','2025-01-21 18:31:31',1,1),(48,'28','5','2025-01-21 18:31:26',1,1),(49,'29','7','2025-02-03 12:46:18',1,1),(50,'29','11','2025-02-03 12:48:05',1,1),(51,'29','12','2025-01-22 18:00:21',1,1),(52,'29','13','2025-01-22 17:56:52',1,1),(53,'30','7','2025-02-03 12:51:27',1,1),(54,'30','9','2025-02-03 12:51:59',1,1),(55,'30','11','2025-02-03 12:53:55',1,1),(56,'30','12','2025-02-03 12:56:24',1,1),(57,'30','13','2025-02-03 12:56:43',1,1),(58,'31','4','2025-02-03 12:58:07',1,1),(59,'31','5','2025-02-03 13:51:53',1,1),(60,'31','6','2025-02-03 12:58:17',1,1),(61,'31','7','2025-02-03 13:03:20',1,1),(62,'31','9','2025-02-03 13:03:28',1,1),(63,'31','11','2025-02-03 13:50:53',1,1),(64,'31','12','2025-02-03 13:50:55',1,1),(65,'31','13','2025-02-03 13:50:56',1,1),(66,'32','6','2025-02-03 18:42:09',1,1),(67,'32','12','2025-02-03 18:38:58',1,1),(68,'32','13','2025-02-03 18:37:17',1,1),(69,'33','12','2025-02-17 18:06:22',1,1),(70,'33','13','2025-03-13 11:49:52',1,1),(71,'34','14','2025-03-13 17:18:20',1,1),(73,'42','4','2025-03-13 16:46:43',1,1),(76,'45','15','2025-03-13 19:05:38',1,1),(77,'45','14','2025-03-13 19:12:38',1,1),(78,'45','12','2025-03-13 19:12:34',1,1),(79,'46','13','2025-03-13 19:13:43',1,1),(80,'46','11','2025-03-13 19:13:44',1,1),(81,'46','9','2025-03-13 19:13:45',1,1),(82,'46','7','2025-03-13 19:13:46',1,1),(83,'59','4','2025-03-13 19:13:53',1,1),(84,'61','15',NULL,1,1),(85,'61','11',NULL,1,1),(86,'61','4',NULL,1,1),(87,'63','14',NULL,1,1),(88,'64','6',NULL,1,1);
/*!40000 ALTER TABLE `item_movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manutencao`
--

DROP TABLE IF EXISTS `manutencao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manutencao` (
  `id_manutencao` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `id_item_movimentacao` int NOT NULL,
  `obs_in` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `obs_out` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_autor` int NOT NULL,
  `dt_inicio_manutencao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_fim_manutencao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_manutencao`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manutencao`
--

LOCK TABLES `manutencao` WRITE;
/*!40000 ALTER TABLE `manutencao` DISABLE KEYS */;
INSERT INTO `manutencao` VALUES (3,2,2,'manutenção pá','teste',1,'2025-01-08 14:31:30','2025-01-08 17:34:33'),(4,8,10,'teste na enxada','deu ruim',1,'2025-01-09 08:42:39','2025-01-09 12:14:41'),(5,5,9,'teste na ota enxada','deu bom',1,'2025-01-09 08:43:01','2025-01-09 12:14:30'),(6,6,14,'teste','okey',1,'2025-01-09 09:00:27','2025-01-09 12:14:35'),(7,7,21,'set','topi',1,'2025-01-09 10:02:07','2025-01-09 13:59:40'),(8,13,33,'teste','testeeee',1,'2025-01-09 11:14:46','2025-01-10 13:30:33'),(9,11,24,'teste','123',1,'2025-01-10 10:24:10','2025-01-10 13:27:33'),(10,10,23,'testte','teste',1,'2025-01-10 10:24:13','2025-01-10 13:25:20'),(11,12,25,'123123','tesste',1,'2025-01-10 10:27:07','2025-01-10 13:31:42'),(12,11,35,'123','teste',1,'2025-01-10 10:30:55','2025-01-10 13:31:49'),(13,10,34,'321','tesste',1,'2025-01-10 10:30:57','2025-01-10 13:31:45'),(14,11,37,'test2','teste',1,'2025-01-16 14:44:53','2025-01-16 19:37:45'),(15,8,10,'teste direto','teste',1,'2025-01-16 16:29:12','2025-01-17 12:53:54');
/*!40000 ALTER TABLE `manutencao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimentacao`
--

DROP TABLE IF EXISTS `movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimentacao` (
  `id_movimentacao` int NOT NULL AUTO_INCREMENT,
  `id_itens` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_empresa` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `id_responsavel` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_autor` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dt_movimentacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_finalizacao` datetime DEFAULT NULL,
  `ds_movimentacao` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_movimentacao`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimentacao`
--

LOCK TABLES `movimentacao` WRITE;
/*!40000 ALTER TABLE `movimentacao` DISABLE KEYS */;
INSERT INTO `movimentacao` VALUES (10,NULL,'1','3','1','2024-12-28 11:11:47','2024-12-31 12:35:38','movimentação teste '),(11,NULL,'1','1','1','2024-12-31 09:33:44','2024-12-31 12:35:55','tesyer'),(12,NULL,'1','3','1','2024-12-31 10:09:51','2024-12-31 13:20:06','teste'),(13,NULL,'1','3','1','2024-12-31 10:19:52','2025-01-09 11:34:09','teste 01'),(14,NULL,'1','1','1','2025-01-08 14:16:40','2025-01-09 11:40:21','teste com nova modelagem de itens\r\n'),(15,NULL,'1','3','1','2025-01-09 08:41:01','2025-01-09 11:43:04','teste'),(16,NULL,'1','2','1','2025-01-09 08:58:52','2025-01-09 12:03:01','teste'),(17,NULL,'1','3','1','2025-01-09 09:23:37','2025-01-09 13:02:02','teste'),(18,NULL,'1','1','1','2025-01-09 09:37:50','2025-01-09 13:02:07','teste incomplete'),(19,NULL,'1','3','1','2025-01-09 10:21:15','2025-01-16 17:34:34','alo dr damião\r\n'),(20,NULL,'1','2','1','2025-01-09 10:24:38','2025-01-09 13:25:01','testando notificação de nivel\r\n'),(21,NULL,'1','2','','2025-01-09 10:25:20','2025-01-09 13:59:11','testando notifica\r\n'),(22,NULL,'1','3','1','2025-01-09 11:13:22','2025-01-16 17:34:48','ytr'),(23,NULL,'1','1','1','2025-01-10 10:30:45','2025-01-10 13:43:36','tsd'),(24,NULL,'1','5','','2025-01-16 14:36:20','2025-01-16 19:42:12','teste2'),(25,NULL,'1','1','1','2025-01-16 14:41:12','2025-01-16 19:42:15','teste32'),(26,NULL,'1','3','1','2025-01-21 15:27:24','2025-01-21 18:31:37','teste'),(27,NULL,'1','1','1','2025-01-21 15:28:50','2025-01-21 18:31:31','ete'),(28,NULL,'1','5','1','2025-01-21 15:31:03','2025-01-21 18:31:26','te2'),(29,NULL,'1','3','1','2025-01-22 14:46:25','2025-02-03 12:48:32','teste'),(30,NULL,'1','3','1','2025-02-03 09:48:59','2025-02-03 12:57:26','teste'),(31,NULL,'1','5','1','2025-02-03 09:57:36','2025-02-03 13:51:53','teste'),(32,NULL,'1','1','1','2025-02-03 14:40:27','2025-02-03 18:42:11','teste'),(33,NULL,'1','3','1','2025-02-03 15:43:05','2025-03-13 11:49:52','a'),(42,NULL,'1','1','1','2025-03-13 13:08:54','2025-03-13 16:46:43','teste'),(45,NULL,'1','1','1','2025-03-13 15:02:48','2025-03-13 19:12:38','xhunda'),(46,NULL,'1','5','1','2025-03-13 15:07:58','2025-03-13 19:13:46','teste2'),(47,NULL,'1','1','1','2025-03-13 15:11:34','2025-03-13 19:13:57','asdfasdfsa'),(48,NULL,'1','3','1','2025-03-13 15:12:17','2025-03-13 19:13:55','12'),(49,NULL,'1','3','1','2025-03-13 15:13:27','2025-03-13 19:13:50','teste'),(59,NULL,'1','3','1','2025-03-13 16:03:14','2025-03-13 19:13:53','opa'),(61,NULL,'1','3','1','2025-03-13 16:15:29',NULL,'h'),(63,NULL,'1','5','1','2025-03-13 16:16:19',NULL,'22'),(64,NULL,'1','4','1','2025-03-13 16:17:03',NULL,'we');
/*!40000 ALTER TABLE `movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nm_usuario` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nr_contato` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_empresa` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tp_usuario` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `nv_permissao` int NOT NULL DEFAULT '0',
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'hants','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','eliabe paz','81988668870','1','admin',3,'2024-12-05 00:00:00'),(3,'joao','$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO','joao teste','81988668870','1','user',0,'2024-12-18 21:27:49'),(4,'teste@teste','$2y$10$r5Douh1fv7gK2PN5hXKCNO.y0To6rR1JfV8J.cxBkz1LW/itrXk8a','testeer','teste','1','user',1,'2025-01-15 14:53:16'),(5,'teste2','$2y$10$Ud5CHMlHSEw5aDNU/HZbcebsI2IJhARQN8LWP6ZsD0WHy3M2BNSrC','teste2','teste2','1','user',1,'2025-01-15 15:09:31');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'projeto_patrimonio'
--

--
-- Dumping routines for database 'projeto_patrimonio'
--

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-14 12:31:03
