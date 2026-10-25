-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: pizzeria_db
-- ------------------------------------------------------
-- Server version	8.0.43

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

CREATE DATABASE pizzeria_db;

USE pizzeria_db;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Pizzas Tradicionales'),(2,'Pizzas Especiales'),(3,'Empanadas'),(4,'Bebidas');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Juan Perez','3413546854','Paraguay 1242'),(2,'Adrian Baltazar','3435246525',''),(3,'ivan burali','3431234567','Carbo 123'),(4,'Jesus Maria','3434524156','Villaguay 2332 '),(5,'analia bertozzi','3431594562','marabi 123'),(6,'Nadia Werner','3434854625','Andres Pazos 25'),(7,'maria carey','3435246511',''),(8,'maribel cazzu','3433555666',''),(9,'julian calveira','343524777',''),(10,'Elias Jara','3414821151',''),(11,'milena paez','3224514855',''),(12,'sebastian ortiz','011888145',''),(13,'sebastian ortega','341514977',''),(14,'ggg','123456789',''),(15,'ñññkkkkk','1223156465789',''),(16,'asdasd','3435246525',''),(17,'dasdas','3435246525334',''),(18,'dfs','123121321',''),(19,'ffff','123432543',''),(20,'dfdsfsdfsd','1234567',''),(21,'vvvv','43434',''),(22,'khhjkgh98','54654745',''),(23,'vvvsfsdfds','65465475645',''),(24,'tttt','6765756',''),(25,'dsfgsdfd','3453765756',''),(26,'fdsfdsfsdfdsfsd','3435246525',''),(27,'Ortodoncia','3435246525',''),(28,'Extraccion 3er molar','3414521159',''),(29,'fdgdf','234567456',''),(30,'bbb','45786576',''),(31,'bcxbczxd','4354756876',''),(32,'bnmbn','564788975',''),(33,'xxxasdf','845645546',''),(34,'gfdgd','4565475678',''),(35,'elian valenzuela','3457654786',''),(36,'marisa torres','345765685',''),(37,'Juan','2342',''),(38,'Kevin Gamboa','3414521159',''),(39,'romi','3413546854',''),(40,'Juan','3435246525',''),(41,'Juan','3435246525',''),(42,'Juan','3435246525',''),(43,'Extraccion 3er molar','3431234567',''),(44,'Orodoncia','sadasdasd',''),(45,'ivan dos','3413333333',''),(46,'dada','111',''),(47,'dede','2222',''),(48,'davida','sommer',''),(49,'davis','22233233242',''),(50,'anabel rodriguez','3435246525',''),(51,'lucas rodriguez','5345346754745','');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medio_respuesta` enum('whatsapp','email','telefono') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'whatsapp',
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,'adrian','kevinivan4390@gmail.com','3413235959','Reserva / Evento','whatsapp','necesito hace runa reserva de 20 pizzas comunes','2026-09-29 19:41:15'),(2,'pamela','pame390@gmail.com','3415622451','Consulta General','whatsapp','necesito trabajo','2026-09-29 19:59:47'),(4,'Fernando torres','ft@gmail.com','','Otro','email','hola hermosa','2026-09-30 00:00:20'),(5,'Juan Ignacio Escobar','JIE@gmail.com','3414222111','Sugerencia / Reclamo','telefono','me estafaron','2026-09-30 00:01:18'),(6,'Nahuel Pennisi','nahuelpe@gmail.com','','Otro','whatsapp','aguante el pity','2026-09-30 00:02:39'),(7,'romi','romi@gmail.com','3431234564','Consulta General','whatsapp','hola estoy aburrida, llamame','2026-10-11 22:03:38'),(8,'adriam','adriam@gmail.com','3435246525','Consulta General','whatsapp','quiero hacer un cumpley  vivo en un cumple','2026-10-14 16:40:32');
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_pedidos`
--

DROP TABLE IF EXISTS `detalle_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `aclaraciones` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_pedidos` (`pedido_id`),
  KEY `fk_detalle_productos` (`producto_id`),
  CONSTRAINT `fk_detalle_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_detalle_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_pedidos`
--

LOCK TABLES `detalle_pedidos` WRITE;
/*!40000 ALTER TABLE `detalle_pedidos` DISABLE KEYS */;
INSERT INTO `detalle_pedidos` VALUES (1,1,2,1,9800.00,'sin morron'),(2,1,1,2,8500.00,''),(3,2,2,1,9800.00,''),(4,2,1,2,8500.00,'sin aceituna'),(5,2,5,1,2500.00,''),(6,2,4,2,1200.00,''),(7,3,1,1,8500.00,''),(8,4,6,1,10000.00,''),(9,5,2,2,9800.00,''),(10,5,1,2,8500.00,''),(11,5,3,1,11500.00,''),(12,5,4,4,1200.00,''),(13,5,6,1,10000.00,''),(14,5,5,1,2500.00,''),(15,6,2,1,9800.00,''),(16,6,3,1,11500.00,''),(17,6,4,1,1200.00,''),(18,7,2,1,9800.00,''),(19,7,1,1,8500.00,''),(20,7,3,1,11500.00,''),(21,8,1,1,8500.00,''),(22,9,6,2,10000.00,''),(23,10,1,2,8500.00,''),(24,10,3,1,11500.00,''),(25,11,2,4,9800.00,''),(26,11,3,4,11500.00,''),(27,12,4,12,1200.00,''),(28,13,5,1,2500.00,''),(29,13,2,1,9800.00,''),(30,14,1,1,8500.00,''),(31,15,2,5,9800.00,''),(32,16,2,2,9800.00,''),(33,17,2,1,9800.00,''),(34,18,2,1,9800.00,''),(35,19,4,2,1200.00,''),(36,20,1,1,8500.00,'con tomate'),(37,21,1,1,8500.00,''),(38,21,4,3,1200.00,''),(39,22,2,1,9800.00,''),(40,23,5,1,2500.00,''),(41,23,3,1,11500.00,''),(42,23,1,1,8500.00,''),(43,24,4,3,1200.00,''),(44,25,1,4,8500.00,''),(45,25,2,1,9800.00,''),(46,25,3,3,11500.00,''),(47,25,5,1,2500.00,''),(48,25,4,1,1200.00,''),(49,25,6,49,10000.00,''),(50,26,3,2,11500.00,''),(51,27,1,1,8500.00,''),(52,28,2,1,9800.00,''),(53,29,2,1,9800.00,''),(54,30,1,2,8500.00,''),(55,31,2,1,9800.00,''),(56,32,2,1,9800.00,''),(57,32,1,1,8500.00,''),(58,33,4,3,1200.00,''),(59,34,1,1,8500.00,''),(60,35,1,1,8500.00,''),(61,35,7,1,12000.00,''),(62,36,1,1,8500.00,''),(63,37,7,1,12000.00,''),(64,38,1,1,8500.00,''),(65,38,7,1,12000.00,''),(66,39,7,1,12000.00,''),(67,39,1,1,8500.00,''),(68,40,1,2,9800.00,''),(69,40,7,1,2500.00,'Bien fría'),(70,41,1,2,9800.00,''),(71,41,7,1,2500.00,'Bien fría'),(72,42,1,2,9800.00,''),(73,42,7,1,2500.00,'Bien fría'),(74,43,1,2,9800.00,''),(75,43,7,1,2500.00,'Bien fría'),(76,44,1,2,9800.00,''),(77,44,7,1,2500.00,'Bien fría'),(78,45,1,2,9800.00,''),(79,45,7,1,2500.00,'Bien fría'),(80,46,1,2,9800.00,''),(81,46,7,1,2500.00,'Bien fría'),(82,47,1,2,9800.00,''),(83,47,7,1,2500.00,'Bien fría'),(84,48,2,1,9800.00,''),(85,48,3,1,11500.00,''),(86,49,5,2,2500.00,''),(87,50,1,1,8500.00,'sin cebolla'),(88,50,4,3,1200.00,'de carne'),(89,51,3,1,11500.00,''),(90,51,5,1,2500.00,'');
/*!40000 ALTER TABLE `detalle_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noticias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_noticias_usuarios` (`usuario_id`),
  CONSTRAINT `fk_noticias_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (1,1,'2 X 1 en pizzas especiales','llevas dos y abonas una, no te pierdas esta oportunidad disponible hasta el 30 de diciembre','1790739076_6abc828409bd9.png','2026-09-30 00:31:16'),(2,1,'¡El secreto está en el queso! 🧀✨','No es un ingrediente más, es el que lo cambia todo. Un queso premium, bien derretido y con el dorado perfecto, es lo que transforma una simple masa en la pizza de tus sueños. ¡Ven a probar la verdadera perfección elástica! 🍕🔥','1790795755_6abd5febd080b.png','2026-09-30 16:15:55'),(4,1,'Mes de la madre!','Si reservas antes del viernes tenes un 50% de descuento','1792007105_6acfdbc13a928.webp','2026-10-14 16:45:05');
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `metodo_pago` enum('efectivo','transferencia','mercadopago') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `tipo_entrega` enum('delivery','retiro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'delivery',
  `notas` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_clientes` (`cliente_id`),
  CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,1,'2026-09-29 17:51:15',0.00,26800.00,'cancelado','efectivo','delivery',NULL),(2,2,'2026-09-29 18:04:11',0.00,31700.00,'completado','efectivo','retiro',NULL),(3,3,'2026-09-29 18:20:23',0.00,8500.00,'completado','transferencia','delivery',NULL),(4,4,'2026-09-29 18:32:27',0.00,10000.00,'completado','efectivo','delivery',NULL),(5,5,'2026-09-29 18:45:04',0.00,65400.00,'completado','efectivo','delivery','pago con $70000'),(6,6,'2026-09-29 18:52:52',0.00,22500.00,'completado','efectivo','delivery','Pago Justo'),(7,7,'2026-09-30 01:06:33',0.00,29800.00,'completado','transferencia','retiro',''),(8,8,'2026-09-30 01:14:07',0.00,8500.00,'completado','transferencia','retiro',''),(9,9,'2026-09-30 01:14:39',0.00,20000.00,'completado','efectivo','retiro',''),(10,10,'2026-09-30 01:22:24',0.00,28500.00,'completado','efectivo','retiro',''),(11,11,'2026-09-30 01:41:35',0.00,85200.00,'completado','efectivo','retiro',''),(12,12,'2026-09-30 01:42:21',0.00,14400.00,'completado','efectivo','retiro',''),(13,13,'2026-09-30 02:10:05',0.00,12300.00,'completado','efectivo','retiro',''),(14,14,'2026-09-30 02:12:07',0.00,8500.00,'completado','efectivo','retiro',''),(15,15,'2026-09-30 02:12:29',0.00,49000.00,'completado','efectivo','retiro',''),(16,16,'2026-09-30 02:17:26',0.00,19600.00,'completado','efectivo','delivery',''),(17,17,'2026-09-30 02:19:35',0.00,9800.00,'completado','efectivo','retiro',''),(18,18,'2026-09-30 02:23:09',0.00,9800.00,'completado','efectivo','retiro',''),(19,19,'2026-09-30 02:39:47',0.00,2400.00,'completado','efectivo','retiro',''),(20,20,'2026-09-30 02:40:17',0.00,8500.00,'completado','efectivo','retiro',''),(21,21,'2026-09-30 02:47:53',0.00,12100.00,'completado','efectivo','retiro',''),(22,22,'2026-09-30 02:52:54',0.00,9800.00,'completado','efectivo','retiro',''),(23,23,'2026-09-30 03:00:40',0.00,22500.00,'completado','efectivo','retiro',''),(24,24,'2026-09-30 03:01:01',0.00,3600.00,'completado','efectivo','retiro',''),(25,25,'2026-09-30 03:03:39',0.00,572000.00,'completado','efectivo','retiro',''),(26,26,'2026-09-30 03:10:44',0.00,23000.00,'completado','efectivo','retiro',''),(27,27,'2026-09-30 03:15:37',0.00,8500.00,'completado','efectivo','retiro',''),(28,28,'2026-09-30 03:18:07',0.00,9800.00,'completado','efectivo','retiro',''),(29,29,'2026-09-30 14:30:02',0.00,9800.00,'completado','efectivo','retiro',''),(30,30,'2026-09-30 14:48:21',0.00,17000.00,'completado','efectivo','retiro',''),(31,31,'2026-09-30 15:04:21',0.00,9800.00,'completado','efectivo','retiro',''),(32,32,'2026-09-30 15:06:00',0.00,18300.00,'completado','efectivo','retiro',''),(33,33,'2026-09-30 15:06:17',0.00,3600.00,'completado','efectivo','retiro',''),(34,34,'2026-09-30 16:59:22',0.00,8500.00,'completado','efectivo','retiro',''),(35,35,'2026-10-01 00:15:15',0.00,20500.00,'completado','efectivo','retiro',''),(36,36,'2026-10-01 00:17:48',0.00,8500.00,'completado','efectivo','retiro',''),(37,37,'2026-10-01 00:49:20',0.00,12000.00,'completado','efectivo','delivery',''),(38,38,'2026-10-08 03:01:22',0.00,20500.00,'completado','efectivo','retiro',''),(39,39,'2026-10-11 22:01:23',0.00,20500.00,'completado','efectivo','retiro',''),(40,40,'2026-10-14 15:23:33',0.00,22100.00,'completado','efectivo','retiro',''),(41,41,'2026-10-14 15:24:43',0.00,22100.00,'completado','efectivo','retiro',''),(42,42,'2026-10-14 15:26:16',0.00,22100.00,'completado','efectivo','retiro',''),(43,43,'2026-10-14 15:32:24',0.00,22100.00,'completado','efectivo','retiro',''),(44,44,'2026-10-14 15:34:55',0.00,22100.00,'completado','efectivo','retiro',''),(45,45,'2026-10-14 16:18:39',0.00,22100.00,'completado','efectivo','retiro',''),(46,46,'2026-10-14 16:20:17',0.00,22100.00,'completado','transferencia','retiro',''),(47,47,'2026-10-14 16:20:51',0.00,22100.00,'completado','efectivo','retiro',''),(48,48,'2026-10-14 16:32:52',0.00,21300.00,'completado','efectivo','retiro',''),(49,49,'2026-10-14 16:34:13',0.00,5000.00,'completado','efectivo','retiro',''),(50,50,'2026-10-14 16:37:16',0.00,12100.00,'completado','efectivo','retiro',''),(51,51,'2026-10-14 16:37:55',0.00,14000.00,'completado','efectivo','retiro','');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio` decimal(10,2) NOT NULL,
  `precio_promo` decimal(10,2) DEFAULT NULL,
  `es_promocion` tinyint(1) NOT NULL DEFAULT '0',
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_productos_categorias` (`categoria_id`),
  CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,1,'Muzzarella','Salsa de tomate, muzzarella, orégano y aceitunas',8500.00,NULL,0,'7d5bd7af8b3558f3f762ea37577f9c23.png',1),(2,1,'Especial','Salsa de tomate, muzzarella, jamón cocido y morrón',9800.00,NULL,0,'869b83d9326a6e5255c1b0bb87fdc7dc.png',1),(3,2,'Fugazzeta Rellena','Muzzarella, jamón y abundante cebolla',11500.00,NULL,0,'7ddb54a425888bb165cf963bf7a9a945.png',1),(4,3,'Empanada Carne Cortada a Cuchillo','Carne vacuna, cebolla, huevo y especias',1200.00,NULL,0,'12322b15416308a88b5926588a064ca6.png',1),(5,4,'Gaseosa 1.5L','Línea Coca-Cola / Sprite',2500.00,NULL,0,'686fc74901dcfa30bde0fcee21edd0c3.png',1),(6,2,'Roquefort','Con Roquefort y Muzzarella',10000.00,NULL,0,'d2b03dbb38cd7a97f2a02cd0f65cdc76.png',1),(7,2,'4 Quesos!','Muzzarella, Sardo, Ruso y Roquefort',12000.00,NULL,0,'c53fc97a85b9eb0bb4cac2c318872f6d.png',1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resenas`
--

DROP TABLE IF EXISTS `resenas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resenas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puntuacion` tinyint NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  CONSTRAINT `resenas_chk_1` CHECK ((`puntuacion` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resenas`
--

LOCK TABLES `resenas` WRITE;
/*!40000 ALTER TABLE `resenas` DISABLE KEYS */;
INSERT INTO `resenas` VALUES (9,'Juan',5,'muy buenas','2026-09-29 19:12:17',1),(17,'kevin',5,'de 1000','2026-09-29 19:32:10',1),(20,'ivan',4,'masooo','2026-09-29 19:35:07',1),(21,'damian',1,'muy malas','2026-09-29 19:35:36',1),(22,'lucia',5,'de 1000','2026-09-29 19:36:05',1),(23,'mamaa',5,'capooos','2026-09-30 17:25:40',1),(24,'pedro',4,'buenitas','2026-10-14 16:39:59',1);
/*!40000 ALTER TABLE `resenas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','empleado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Administrador Principal','admin');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pizzeria_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-14 17:08:27
