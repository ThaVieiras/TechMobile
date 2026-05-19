-- MySQL dump 10.13  Distrib 8.0.43, for macos15 (arm64)
--
-- Host: localhost    Database: techmobile
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `endereco` text,
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Teste ','teste@teste.com','$2y$12$m2/pbIur9UNXYmKnrkryHObDKW57H.90X/4TpM5axxBFkwgAMXBB.','000.000.000-00','1140028922','Rua da Saudade, 6, Vila Sonia','2026-03-31 15:46:42',1),(7,'Miúcha Tester','teste@gmail.com','$2y$12$OhVOiiSF0wZkAxvG2gX5DeSY4OICJMDlmgtul.fIKVrwL2WyDz5gq','999.999.999-99','1130903090','Rua Felicidade, 221','2026-04-19 20:11:49',1),(9,'Thais','tvs@hotmail.com','$2y$12$ECPGF6/8yIdKo9a7l7zOa.FMw745RMkAlOxTDiEKeG5KRH6/J07Cy','999.999.999-99','11960358989','Rua da Felicidade, 221','2026-04-22 12:05:13',1),(12,'teste silver','teste@icloud.com','$2y$12$YswvEYrMSax3x2Sy7ud9jeU.bUUXVRXxZ.TVOqEejOjL7MROEMWda','999.999.999-99','1140028922','Rua Felicidade, 229','2026-04-22 12:34:08',1),(13,'Isabel','teste@terra.com','$2y$12$WPeLTDiUuGuokl.Opz4R5e0QE0w3t.twgPsfKmYdJdVq2tNRcnsJG',NULL,NULL,NULL,'2026-04-22 12:38:55',1),(14,'Gerard','testes@terra.com','$2y$12$zaHCyOA6R/BqnFvp4VY3C.Bjyhsjcf9.mEKRVANreEuO5RThppZtW','999.999.999-99','1160910899','Rua Tristeza, 444','2026-04-22 12:40:57',1),(15,'Valquiria','val@gmail.com','$2y$12$GTSvnqimLqAM6xvQxj9xf.wKC0cJ0ihyW3lDWFZVdZndw/lzyt/xO','999.999.999-99','1120424357','Rua Tristeza, 446','2026-04-22 12:44:28',1),(16,'Auro','auro@teste.com','$2y$12$7HeZ2WI5.PhtzVpc3lPc9u44OkMrMTQpiQrFGfdrPCQOzjPxeMAey','999.999.999-99','1160910899','Rua Felicidade, 229','2026-05-08 19:25:36',1);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contatos`
--

DROP TABLE IF EXISTS `contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contatos` (
  `id_contato` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `assunto` varchar(50) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lida` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contatos`
--

LOCK TABLES `contatos` WRITE;
/*!40000 ALTER TABLE `contatos` DISABLE KEYS */;
INSERT INTO `contatos` VALUES (1,'Teste ','teste@teste.com','Elogio/Sugestão','Adorei a página de vocês! Já realizei mais de um pedido e já indiquei para família.','2026-04-08 17:03:57',0),(2,'Teste ','teste@teste.com','Elogio/Sugestão','Adorei comprar com vocês!','2026-04-10 20:57:08',0),(3,'Teste ','teste@teste.com','Elogio/Sugestão','Adorei comprar com vocês!','2026-04-10 21:01:41',0),(4,'Thais','tvs@hotmail.com','Elogio/Sugestão','Adorei o site!','2026-04-22 15:09:16',0),(5,'Gerard','testes@terra.com','Elogio/Sugestão','Siten top!','2026-04-22 15:42:31',0),(6,'Gerard','teste@teste.com','Elogio/Sugestão','Teste','2026-05-08 22:25:04',0);
/*!40000 ALTER TABLE `contatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estoque` (
  `id_estoque` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `quantidade_atual` int NOT NULL,
  `atualizado_em` datetime NOT NULL,
  PRIMARY KEY (`id_estoque`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` VALUES (1,1,47,'2026-04-19 19:11:25'),(2,2,48,'2026-04-14 14:55:36'),(3,3,49,'2026-04-19 19:11:25'),(4,4,39,'2026-05-08 19:28:50'),(5,5,45,'2026-04-22 12:34:43'),(6,6,49,'2026-04-19 19:11:25'),(7,7,49,'2026-04-08 14:28:43'),(8,8,50,'2026-03-18 15:09:41'),(9,9,48,'2026-03-31 15:57:28'),(10,14,15,'2026-04-08 17:55:58'),(11,15,10,'2026-04-08 17:55:58'),(12,16,8,'2026-04-08 17:55:58'),(13,17,5,'2026-04-08 17:55:58'),(14,18,12,'2026-04-08 17:55:58');
/*!40000 ALTER TABLE `estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_pedidos`
--

DROP TABLE IF EXISTS `itens_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_pedidos` (
  `id_item` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`),
  UNIQUE KEY `id_pedido` (`id_pedido`,`id_produto`),
  KEY `fk_produto` (`id_produto`),
  CONSTRAINT `fk_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  CONSTRAINT `fk_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_pedidos`
--

LOCK TABLES `itens_pedidos` WRITE;
/*!40000 ALTER TABLE `itens_pedidos` DISABLE KEYS */;
INSERT INTO `itens_pedidos` VALUES (1,3,5,2,7784.00,15568.00),(2,3,9,2,3899.00,7798.00),(3,3,2,1,6800.00,6800.00),(4,3,1,1,7499.00,7499.00),(5,4,7,1,4822.00,4822.00),(6,4,4,1,8476.00,8476.00),(7,5,1,1,7499.00,7499.00),(8,5,5,1,7784.00,7784.00),(9,6,2,1,6800.00,6800.00),(10,7,4,2,8476.00,16952.00),(11,8,3,1,1500.00,1500.00),(12,8,1,1,7499.00,7499.00),(13,8,6,1,8899.00,8899.00),(14,9,5,1,7784.00,7784.00),(15,9,4,1,8476.00,8476.00),(16,9,19,1,199.00,199.00),(17,10,5,1,7784.00,7784.00),(18,11,4,1,8476.00,8476.00),(19,12,10,1,499.00,499.00),(20,12,4,1,8476.00,8476.00),(21,13,43,1,7499.00,7499.00),(22,14,4,5,8476.00,42380.00);
/*!40000 ALTER TABLE `itens_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_status` int NOT NULL,
  `id_cliente` int NOT NULL,
  `data_pedido` datetime NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `atualizado_em` datetime NOT NULL,
  `id_admin_ultimo_update` int DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_cliente_pedido` (`id_cliente`),
  KEY `fk_status_pedido` (`id_status`),
  KEY `fk_admin_pedido` (`id_admin_ultimo_update`),
  CONSTRAINT `fk_admin_pedido` FOREIGN KEY (`id_admin_ultimo_update`) REFERENCES `admin` (`id_admin`),
  CONSTRAINT `fk_cliente_pedido` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `fk_status_pedido` FOREIGN KEY (`id_status`) REFERENCES `status_pedido` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (3,1,1,'2026-03-31 15:57:28',37665.00,NULL,'2026-03-31 15:57:28',NULL),(4,1,1,'2026-04-08 14:28:43',13298.00,NULL,'2026-04-08 14:28:43',NULL),(5,1,1,'2026-04-10 18:01:13',15283.00,NULL,'2026-04-10 18:01:13',NULL),(6,1,1,'2026-04-14 14:55:36',6800.00,NULL,'2026-04-14 14:55:36',NULL),(7,1,1,'2026-04-17 11:39:59',16952.00,NULL,'2026-04-17 11:39:59',NULL),(8,1,1,'2026-04-19 19:11:25',17898.00,NULL,'2026-04-19 19:11:25',NULL),(9,1,9,'2026-04-22 12:08:10',16459.00,NULL,'2026-04-22 12:08:10',NULL),(10,1,12,'2026-04-22 12:34:43',7784.00,NULL,'2026-04-22 12:34:43',NULL),(11,1,14,'2026-04-22 12:41:30',8476.00,NULL,'2026-04-22 12:41:30',NULL),(12,1,15,'2026-04-22 12:44:56',8975.00,NULL,'2026-04-22 12:44:56',NULL),(13,1,1,'2026-04-22 12:54:49',7499.00,NULL,'2026-04-22 12:54:49',NULL),(14,1,16,'2026-05-08 19:28:50',42380.00,NULL,'2026-05-08 19:28:50',NULL);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(160) NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(80) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `mais_vendido` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'iPhone 15 Pro','Apple','Pro','smartphone','O melhor iPhone já lançado, com titânio e chip A17 Pro.',7499.00,'apple-iphone-15-pro.png',1,'2026-03-18 15:03:32',0),(2,'Galaxy S24 Ultra','Samsung','Ultra','smartphone','Potência máxima e a melhor tela em um smartphone Android.',6800.00,'samsung-galaxy-s24-ultra.png',1,'2026-03-18 15:03:32',0),(3,'Redmi Note 13','Xiaomi','Note 13','smartphone','O equilíbrio perfeito entre preço e performance.',1500.00,'xiaomi-redmi-note-13.png',1,'2026-03-18 15:03:32',0),(4,'Apple iPhone 17','Apple','17','smartphone','Lançamento com tecnologia de ponta e design inovador.',8476.00,'apple-iphone-17.png',1,'2026-03-18 15:09:35',0),(5,'Galaxy Z Fold7','Samsung','Z Fold7','smartphone','O melhor da tecnologia dobrável para produtividade.',7784.00,'samsung-galaxy-z-fold7.png',1,'2026-03-18 15:09:35',0),(6,'Motorola Signature','Motorola','Signature','smartphone','Design premium com acabamento exclusivo em couro vegano e performance de ponta.',8899.00,'motorola-signature.png',1,'2026-03-18 15:09:35',1),(7,'Xiaomi 17 Pro Max','Xiaomi','17 Pro Max','smartphone','Performance extrema com o novo sistema de câmeras Leica e carregamento ultra rápido.',4822.00,'xiaomi-17-pro-max.png',1,'2026-03-18 15:09:35',1),(8,'Poco X7','Xiaomi','X7','smartphone','O rei do custo-benefício para gamers, com tela de 120Hz e processador otimizado.',2299.00,'xiaomi-poco-x7.png',1,'2026-03-18 15:09:35',0),(9,'Galaxy S25 FE','Samsung','S25 FE','smartphone','A experiência Fan Edition definitiva, reunindo os recursos favoritos dos usuários.',3899.00,'samsung-galaxy-s25-fe.png',1,'2026-03-18 15:09:35',0),(10,'Carregador MagSafe','Apple','A2140','acessorios','Carregamento sem fios rápido e seguro.',499.00,'apple-carregador-magsafe.png',1,'2026-04-08 16:59:39',0),(11,'Fone Galaxy Buds3','Samsung','Buds3','acessorios','Som premium com cancelamento de ruído.',899.00,'samsung-fone-galaxy-buds3.png',1,'2026-04-08 16:59:39',0),(12,'iPhone 13 - Vitrine','Apple','13','recondicionado','Aparelho recondicionado com garantia de 12 meses.',3200.00,'apple-iphone-13-vitrine.png',1,'2026-04-08 16:59:39',0),(13,'Redmi Note 12','Xiaomi','Note 12','oferta','Oferta especial: o melhor preço da semana!',999.00,'xiaomi-redmi-note-12.png',1,'2026-04-08 16:59:39',0),(14,'Google Pixel 8','Google','Pixel 8','smartphone','O melhor da inteligência artificial do Google em um smartphone.',4200.00,'google-pixel-8.png',1,'2026-04-08 17:55:34',0),(15,'Asus ROG Phone 8','Asus','ROG 8','smartphone','O smartphone definitivo para gamers de elite.',6500.00,'asus-rog-phone-8.png',1,'2026-04-08 17:55:34',1),(16,'iPhone 12 64GB - Recondicionado','Apple','12','recondicionado','Aparelho classe A, testado e com bateria acima de 90%.',2100.00,'apple-iphone-12-64gb-recondicionado.png',1,'2026-04-08 17:55:52',0),(17,'Galaxy S22 Ultra - Vitrine','Samsung','S22 Ultra','recondicionado','Produto de vitrine, sem marcas de uso. Garantia TechMobile.',2800.00,'samsung-galaxy-s22-ultra-vitrine.png',1,'2026-04-08 17:55:52',0),(18,'iPad Air 4ª Gen - Recondicionado','Apple','Air 4','recondicionado','Performance de tablet profissional por um preço reduzido.',2900.00,'apple-ipad-air-4-gen-recondicionado.png',1,'2026-04-08 17:55:52',0),(19,'Cabo Tipo C','Baseus','Free2Draw','acessorios','Cabo para Carregar Dispositivo.',199.00,'baseus-cabo-tipo-c.png',1,'2026-04-14 22:16:52',0),(20,'Cabo 3 em 1 ','Baseus','Lightning + USB-C + Micro USB','acessorios','Cabo 3 em 1 com conectores Lightning, USB-C e Micro USB para carregar vários dispositivos ao mesmo tempo. ',89.00,'baseus-cabo-3-em-1.png',1,'2026-04-14 22:16:52',0),(21,'Cabo Rápido Usb','Baseus','Cafule Nylon','acessorios','O Cabo USB para Tipo-C da Baseus é a escolha perfeita para quem busca durabilidade e alta performance. ',99.00,'baseus-cabo-rapido-usb.png',1,'2026-04-14 22:16:52',0),(22,'Carregador Portátil','Baseus','MagSafe Picogo','acessorios','Power bank magnético ultrafino e leve, ideal para carregar seu iPhone e outros dispositivos compatíveis com MagSafe.',149.00,'baseus-carregador-portatil.png',1,'2026-04-14 22:16:52',0),(23,'Carregador Turbo','Baseus','Super Si 20W','acessorios','Compacto, potente e ideal para iPhones e outros dispositivos com carregamento rápido.',65.00,'baseus-carregador-turbo.png',1,'2026-04-14 22:16:52',0),(24,'Carregador Sem Fio','Baseus','Magnético 15W','acessorios','Carregue seu iPhone com praticidade e eficiência usando o carregador sem fio magnético de 15W.',189.00,'baseus-carregador-sem-fio.png',1,'2026-04-14 22:16:52',0),(25,'Smartwatch Huawei','Huawei','Watch Fit 4','acessorios','O Huawei Watch Fit 4 combina design elegante e moderno com tecnologia inteligente.',899.00,'huawei-smartwatch-watch-fit-4.png',1,'2026-04-14 22:16:52',0),(26,'Smartwatch Huawei','Huawei','Band 10','acessorios','O Band 10 oferece uma sensação leve, gerenciamento do sono e da bem-estar emocional e 100 modos esportivos.',289.00,'huawei-smartwatch-band-10.png',1,'2026-04-14 22:16:52',0),(27,'Smartwatch Huawei','Huawei','Watch 5 Titânio','acessorios','O HUAWEI WATCH 5, esculpido com vidro esférico de safira e caixa de titânio de nível aeroespacial.',5699.00,'huawei-smartwatch-watch-5-titanio.png',1,'2026-04-14 22:16:52',1),(28,'Smartwatch Huawei','Huawei','Watch Ultimate','acessorios','O HUAWEI WATCH Ultimate é um smartwatch premium com um modo de golfe do qual muitos jogadores de golfe realmente se beneficiariam.',4399.00,'huawei-smartwatch-watch-ultimate.png',1,'2026-04-14 22:16:52',0),(29,'Smartwatch Huawei','Huawei','WATCH GT 6','acessorios','Novo HUAWEI WATCH GT 6 com Monitoramento Avançado de Esportes ao Ar Livre. A carga da bateria pode durar até 14 dias.',1699.00,'huawei-smartwatch-watch-gt-6.png',1,'2026-04-14 22:16:52',0),(30,'Smartwatch Huawei','Huawei','Watch D2','acessorios','O HUAWEI WATCH D2 monitora sua Pressão Arterial Sistólica (SBP), Pressão Arterial Diastólica (DBP) e frequência de batimentos cardíacos continuamente, até durante o sono.',2799.00,'huawei-smartwatch-watch-d2.png',1,'2026-04-14 22:16:52',0),(31,'Smartwatch Samsung Galaxy','Samsung','Galaxy Watch7 BT','acessorios','Eleve seu estilo com o Galaxy Watch7. Um design com vidro suspenso e pontos de costura coloridos adicionam um toque de elegância ao seu pulso.',2499.00,'samsung-smartwatch-galaxy-watch7-bt.png',1,'2026-04-14 22:16:52',0),(32,'Smartwatch Samsung Galaxy','Samsung','Galaxy Watch8','acessorios','O Samsung Galaxy Watch mais fino de todos os tempos, o Galaxy Watch8 está pronto para causar impacto.',3499.00,'samsung-smartwatch-galaxy-watch8.png',1,'2026-04-14 22:16:52',0),(33,'Galaxy SmartTag2','Samsung','Galaxy SmartTag2','acessorios','Encontre com mais facilidade. Com bateria melhorada que dura até 500 dias, à prova d\'água e poeira IP67, recursos intuitivos de localização.',349.00,'samsung-galaxy-smarttag2.png',1,'2026-04-14 22:16:52',0),(34,'Galaxy SmartTag2 (Pct 4 unids)','Samsung','Galaxy SmartTag2(Pct com 4 unid)','acessorios','O Galaxy SmartTag2 localiza os seus objetos de valor e ajuda a controlar vários dispositivos IoT com um simples clique.',1349.00,'samsung-galaxy-smarttag2-pct-4-unids.png',1,'2026-04-14 22:16:52',0),(35,'Pulseira Sport Galaxy Watch8','Samsung','Watch8 Classic (P/M/G)','acessorios','Produzida em borracha macia, a Pulseira Sport oferece um ajuste confortável e flexível.',399.00,'samsung-pulseira-sport-galaxy-watch8.png',1,'2026-04-14 22:16:52',0),(36,'Pulseira Fabric Galaxy Watch7','Samsung','Galaxy Watch7 (P/M/G)','acessorios','A Pulseira Fabric do Galaxy Watch7 combina tecido leve e um fecho fácil de remover.',399.00,'samsung-pulseira-fabric-galaxy-watch7.png',1,'2026-04-14 22:16:52',0),(37,'Base de carregamento Buds2','Samsung','Base Buds2','acessorios','A base de carregamento para Galaxy Buds2 (modelo GH82-26679E) oferece carregamento via cabo USB-C e sem fio (Qi).',409.00,'samsung-base-carregamento-buds2.png',1,'2026-04-14 22:16:52',0),(38,'Galaxy Ring','Samsung','Galaxy Ring Titânio','acessorios','Uma estrutura leve de titânio e um design elegante que é tão confortável que você esquecerá que está usando.',3999.00,'samsung-galaxy-ring.png',1,'2026-04-14 22:16:52',0),(39,'Galaxy Buds Core','Samsung','Buds Core','acessorios','Projetados para proporcionar conforto o dia todo, os Galaxy Buds Core têm pontas de silicone com ajuste suave e sem pressão.',249.00,'samsung-galaxy-buds-core.png',1,'2026-04-14 22:16:52',0),(40,'Samsung Galaxy Buds4 Pro','Samsung','Buds4 Pro','acessorios','Os Samsung Galaxy Buds4 Pro são fones premium com design intra-auricular, drivers duplos de 11 mm e cancelamento de ruído adaptativo (ANC) aprimorado por IA.',2099.00,'samsung-galaxy-buds4-pro.png',1,'2026-04-14 22:16:52',0),(41,'Galaxy Tab S10 FE+ 5G','Samsung','Tab S10 FE+ 5G','acessorios','Encontre inspiração e expresse sua personalidade com o Galaxy Tab S10 FE e Tab S10 FE+ juntamente com a S Pen na cor branca.',5979.00,'samsung-galaxy-tab-s10-fe-5g.png',1,'2026-04-14 22:16:52',0),(42,'Galaxy Tab S10+ (Wi-Fi)','Samsung','Tab S10 com Capa Teclado','tablet','Encontre inspiração e expresse sua personalidade com o Galaxy Tab S10 FE e Tab S10 FE+ juntamente com a S Pen na cor branca.',8739.00,'samsung-galaxy-tab-s10-wi-fi.png',1,'2026-04-14 22:16:52',0),(43,'iPad Air','Apple','iPad Air','acessorios','Desempenho poderoso em um design fino e leve.',7499.00,'apple-ipad-air.png',1,'2026-04-14 22:16:52',1),(44,'iPad Pro','Apple','iPad Air','acessorios','A experiência definitiva em iPad com a mais avançada tecnologia.',12499.00,'apple-ipad-pro.png',1,'2026-04-14 22:16:52',0),(45,'AirPods Max 2','Apple','AirPods','acessorios','Os AirPods Max foram pensados para proporcionar conforto perfeito, criando uma vedação acústica impecável. Você vai se sentir dentro do som.',6499.00,'apple-airpods-max-2.png',1,'2026-04-14 22:16:52',0),(46,'AirPods Pro 3','Apple','AirPods Pro 3','acessorios','O melhor Cancelamento Ativo de Ruído do mundo em fones intra-auriculares, com medição de frequência cardíaca.',2699.00,'apple-airpods-pro-3.png',1,'2026-04-14 22:16:52',0),(47,'AirPods Pro 4','Apple','AirPods Pro 4','acessorios','O próximo passo em som, conforto e controle de ruído.',1999.00,'apple-airpods-pro-4.png',1,'2026-04-14 22:16:52',0),(48,'Apple Watch Series 11','Apple','Apple Watch Series 11','smartwatch','O parceiro ideal para cuidar da sua saúde.',5499.00,'apple-watch-series-11.png',1,'2026-04-14 22:16:52',0),(49,'Apple Watch SE 3','Apple','Apple Watch SE 3','acessorios','Recursos essenciais para a saúde ao seu alcance.',3299.00,'apple-watch-se-3.png',1,'2026-04-14 22:16:52',0),(50,'Apple Watch Nike','Apple','Apple Watch Nike','acessorios','A Apple e a Nike motivam as pessoas a correr há anos. Juntas, repensamos a forma de projetar pulseiras para que acompanhem o ritmo de todos os seus movimentos.',3199.00,'apple-watch-nike.png',1,'2026-04-14 22:16:52',0),(51,'iPhone 11 Red - Recondicionado','Apple','11 Red','recondicionado','Estado de novo, bateria acima de 90%.',2499.00,'apple-iphone-11-red-recondicionado.png',1,'2026-04-14 22:16:52',0),(52,'Motorola Edge 20 Pro - Recondicionado','Motorola','Edge 20 Pro','recondicionado','Aparelho 100% funcional, o celular funciona perfeitamente e vão sem acessórios.',999.00,'motorola-edge-20-pro-recondicionado.png',1,'2026-04-14 22:16:52',0),(53,'Motorola One Vision - Recondicionado','Motorola','Moto One Vision','recondicionado','MUITO BOM – Os celulares funcionam perfeitamente e vão sem acessórios.',799.00,'motorola-one-vision-recondicionado.png',1,'2026-04-14 22:16:52',0),(54,'Galaxy A54 Plus - Recondicionado','Samsung','Galaxy A54','recondicionado','Certificado pela Nexus com 6 meses de garantia.',1299.00,'samsung-galaxy-a54-plus-recondicionado.png',1,'2026-04-14 22:16:52',0),(55,'LG K41s - Recondicionado','LG','K41s','recondicionado','EXCELENTE – Os celulares funcionam perfeitamente e vão sem acessórios. O que vai alterar é a condição estética do aparelho.',599.00,'lg-k41s-recondicionado.png',1,'2026-04-14 22:21:29',0),(56,'Smartphone Huawei','Huawei','Mate X6','smartphone','Ultrafino e Durável Câmera Ultra Chroma.',12999.00,'huawei-smartphone-mate-x6.png',1,'2026-04-14 22:34:26',0),(57,'Xiaomi Poco X7','Xiaomi','Poco X7','oferta','Oferta Especial: O rei do custo-benefício com tela de 120Hz e carregamento turbo.',2299.00,'xiaomi-poco-x7.png',1,'2026-04-15 00:24:26',0),(59,'Samsung Galaxy A55','Samsung','A55 5G','oferta','Oferta Especial: Resistência à água e performance equilibrada para o dia a dia.',1899.00,'samsung-galaxy-a55.png',1,'2026-04-15 00:24:26',0),(60,'Motorola Edge 50 Fusion','Motorola','Edge 50','oferta','Oferta Especial: Design premium com tela curva e carregamento rápido.',2100.00,'motorola-edge-50-fusion.png',1,'2026-04-15 00:24:26',0),(61,'iPhone 13 - Vitrine','Apple','13','recondicionado','Recondicionado: Aparelho de vitrine, bateria acima de 90%, sem riscos.',3200.00,'apple-iphone-13-vitrine.png',1,'2026-04-15 00:24:56',0),(62,'iPhone 12 64GB - Grade A','Apple','12','recondicionado','Recondicionado: Testado e higienizado. Garantia Nexus de 6 meses.',2100.00,'apple-iphone-12-64gb-grade-a.png',1,'2026-04-15 00:24:56',0),(63,'Galaxy S22 Ultra - Vitrine','Samsung','S22 Ultra','recondicionado','Recondicionado: O poder da S-Pen por um preço acessível. Estado de novo.',2800.00,'samsung-galaxy-s22-ultra-vitrine.png',1,'2026-04-15 00:24:56',0),(64,'iPad Air 4ª Gen - Recondicionado','Apple','Air 4','recondicionado','Recondicionado: Performance de tablet profissional para estudos e design.',2900.00,'apple-ipad-air-4-gen-recondicionado.png',1,'2026-04-15 00:24:56',0),(65,'Apple AirTag','Apple','AirTag','acessorios','Rastreador Bluetooth para encontrar seus objetos com facilidade usando o app Buscar.',349.00,'apple-airtag.png',1,'2026-05-13 12:58:02',0),(66,'Xiaomi Smart Band 8','Xiaomi','Smart Band 8','acessorios','Pulseira inteligente com tela AMOLED, monitoramento de saúde e bateria de longa duração.',299.00,'xiaomi-smart-band-8.png',1,'2026-05-13 12:58:02',1),(67,'iPhone 16e','Apple','16e','smartphone','O novo iPhone com Dynamic Island e câmera avançada.',5999.00,'apple-iphone-16e.png',1,'2026-05-13 13:53:54',0),(68,'Galaxy S24','Samsung','S24','smartphone','Inteligência artificial e design premium no tamanho ideal.',5399.00,'samsung-galaxy-s24.png',1,'2026-05-13 13:53:54',0),(69,'Motorola Edge 40','Motorola','Edge 40','smartphone','Design curvo, resistente à água e carregamento ultrarrápido.',2599.00,'motorola-edge-40.png',1,'2026-05-13 13:53:54',0),(70,'iPhone 11 Pro - Recondicionado','Apple','11 Pro','recondicionado','Aparelho revisado, com garantia e excelente desempenho de bateria.',2799.00,'apple-iphone-11-pro-recondicionado.png',1,'2026-05-13 13:53:38',0),(71,'Galaxy S21 - Recondicionado','Samsung','S21','recondicionado','Desempenho top de linha com excelente custo-benefício, 100% testado.',1899.00,'samsung-galaxy-s21-recondicionado.png',1,'2026-05-13 13:53:38',0),(72,'Power Bank Turbo','Baseus','Airpow Lite','acessorios','CPower Bank compacto com 10000mAh e cabos integrados Lightning + USB-C. Carregamento rápido de até 22.5W.',130.00,'baseus-power-bank-air.png',1,'2026-05-13 13:53:26',0),(73,'Capa Magnética iPhone 15 Pro','Apple','Case Magnética','acessorios','Capa protetora projetada para o iPhone 15 Pro Max com encaixe magnético compatível com MagSafe.',499.00,'apple-capa-magnetica-iphone-15-pro.png',1,'2026-05-13 13:53:26',1),(74,'Caneta Stylus','Baseus','Smooth Writing Series 2','acessorios','Caneta touch precisa para iPad com controle de inclinação, indicador de bateria LED, pontas substituíveis e recarga direta no tablet.',269.00,'baseus-caneta-stylus.png',1,'2026-05-13 13:53:26',0),(75,'Suporte Veicular Turbo','Baseus','Smooth Writing Series 2','acessorios','Suporte Veicular Turbo com Carregamento Sem Fio Automático',189.00,'baseus-suporte-turbo.png',1,'2026-05-13 13:53:26',0),(76,'Moto G54','Motorola','G54','oferta','Bateria gigante e tela fluida com preço promocional.',1099.00,'motorola-moto-g54.png',1,'2026-05-13 13:53:01',1),(77,'Fone de Ouvido Bluetooth Open-Ear Sem Fio','Huawei','HUAWEI FreeArc','acessorios','Cancelamento de ruído de chamada/efeitos sonoros Multi-EQ (Inclui efeito sonoro personalizado).',637.00,'huawei-free-arc.png',1,'2026-05-13 14:25:41',0),(78,'Fone de Ouvido Bluetooth Open-Ear Sem Fio','Huawei','FreeClip 2','acessorios','O design open-ear em formato de clipe foi pensado para ser visível durante o uso, aproximando o produto de itens de estilo pessoal.',859.00,'huawei-free-clip2.png',1,'2026-05-13 14:27:53',0);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_pedido`
--

DROP TABLE IF EXISTS `status_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_pedido` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `nome_status` varchar(40) NOT NULL,
  PRIMARY KEY (`id_status`),
  UNIQUE KEY `nome_status` (`nome_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_pedido`
--

LOCK TABLES `status_pedido` WRITE;
/*!40000 ALTER TABLE `status_pedido` DISABLE KEYS */;
INSERT INTO `status_pedido` VALUES (5,'Cancelado'),(4,'Entregue'),(3,'Enviado'),(2,'Pago'),(1,'Pendente');
/*!40000 ALTER TABLE `status_pedido` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-18 22:50:36
