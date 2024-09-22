-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bd_tienda
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `alerta_stock`
--

DROP TABLE IF EXISTS `alerta_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerta_stock` (
  `id_alerta_stock` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `mensaje` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_mensaje` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_alerta_stock`),
  KEY `fk_alerta_stock_producto1_idx` (`id_producto`),
  CONSTRAINT `fk_alerta_stock_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerta_stock`
--

LOCK TABLES `alerta_stock` WRITE;
/*!40000 ALTER TABLE `alerta_stock` DISABLE KEYS */;
INSERT INTO `alerta_stock` VALUES (1,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 0','2024-09-22 04:26:16'),(2,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 3','2024-09-22 04:53:11'),(3,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 0','2024-09-22 04:57:00'),(4,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 3','2024-09-22 04:57:31'),(5,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 3','2024-09-22 04:57:58'),(6,1,'El stock del producto ASUS ROG Strix G16 (2024) está por debajo del límite mínimo. Stock actual: 2','2024-09-22 05:03:37');
/*!40000 ALTER TABLE `alerta_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(75) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Administrador',NULL);
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `id_carrito` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `creacion` datetime NOT NULL,
  `expiracion` datetime NOT NULL,
  PRIMARY KEY (`id_carrito`),
  KEY `fk_carrito_cliente1_idx` (`id_cliente`),
  CONSTRAINT `fk_carrito_cliente1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito_item`
--

DROP TABLE IF EXISTS `carrito_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito_item` (
  `id_producto` int NOT NULL,
  `id_carrito` int NOT NULL,
  `cantidad` int NOT NULL,
  KEY `fk_producto_has_carrito_carrito1_idx` (`id_carrito`),
  KEY `fk_producto_has_carrito_producto1_idx` (`id_producto`),
  CONSTRAINT `fk_producto_has_carrito_carrito1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  CONSTRAINT `fk_producto_has_carrito_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito_item`
--

LOCK TABLES `carrito_item` WRITE;
/*!40000 ALTER TABLE `carrito_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_producto`
--

DROP TABLE IF EXISTS `categoria_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_producto` (
  `id_categoria_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_categoria_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_producto`
--

LOCK TABLES `categoria_producto` WRITE;
/*!40000 ALTER TABLE `categoria_producto` DISABLE KEYS */;
INSERT INTO `categoria_producto` VALUES (1,'Laptops Gamer','Portátiles de alto rendimiento diseñadas específicamente para juegos.'),(2,'Impresoras','Impresoras de inyección de tinta, láser, multifuncionales y escáneres de alta resolución');
/*!40000 ALTER TABLE `categoria_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `id_contacto` int NOT NULL,
  `tipo_cliente` enum('DNI','RUC') COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_documento` varchar(12) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_cliente` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `nro_documento_UNIQUE` (`nro_documento`),
  KEY `fk_cliente_contacto1_idx` (`id_contacto`),
  CONSTRAINT `fk_cliente_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,4,'DNI','71154816','CARMEN GABRIELA CASTAÑEDA LEDESMA','2024-09-22 04:29:31'),(2,5,'DNI','72696255','KEIKO THALIA SILVA LEZAMA','2024-09-22 04:30:28');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_empleado` int NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `cantidad_compra` smallint NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `pago_total` decimal(10,2) DEFAULT NULL,
  `id_metodo_pago` int NOT NULL,
  `numero_factura` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_compra` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_compra`),
  KEY `fk_compra_proveedor1_idx` (`id_proveedor`),
  KEY `fk_compra_empleado1_idx` (`id_empleado`),
  KEY `fk_compra_metodo_pago1_idx` (`id_metodo_pago`),
  KEY `fk_compra_producto1_idx` (`id_producto`),
  CONSTRAINT `fk_compra_empleado1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  CONSTRAINT `fk_compra_metodo_pago1` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`),
  CONSTRAINT `fk_compra_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_compra_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
INSERT INTO `compra` VALUES (1,1,1,1,'',3,3150.00,9450.00,2,'20012','2024-09-22 04:57:31');
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_aumentar_stock_producto` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
	IF NEW.cantidad_compra > 0 THEN
		UPDATE producto
		SET stock = stock + NEW.cantidad_compra
		WHERE id_producto = NEW.id_producto;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_actualizar_stock_producto` AFTER UPDATE ON `compra` FOR EACH ROW BEGIN
	IF NEW.id_producto <> OLD.id_producto THEN
		-- Restamos la cantidad al producto anterior
		UPDATE producto
        SET stock = stock - OLD.cantidad_compra
        WHERE id_producto = OLD.id_producto;
        -- Aumentamos la cantidad al nuevo producto
        UPDATE producto
        SET stock = stock + NEW.cantidad_compra
        WHERE id_producto = NEW.id_producto;
	ELSE 
		-- Actualizamos el mismo producto con la nueva cantidad_compra
		UPDATE producto
        SET stock = stock - OLD.cantidad_compra + NEW.cantidad_compra
        WHERE id_producto = NEW.id_producto;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_borrar_stock_producto` AFTER DELETE ON `compra` FOR EACH ROW BEGIN
	-- Actualizamos el mismo producto con la nueva cantidad_compra
	UPDATE producto
	SET stock = stock - OLD.cantidad_compra
	WHERE id_producto = OLD.id_producto;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_celular` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nacionalidad` char(3) COLLATE utf8mb4_spanish_ci DEFAULT 'PER',
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (1,'cristhian@gmail.com','915481516','Av. Municipal 325','Per'),(2,'eduardo@gmail.com','918481516','CAL. RICARDO ANGULO NRO 724 DEP. 302 URB. COR','PER'),(3,'softwaretech@gmail.com','952154815','CAL. LOS NEGOCIOS NRO 433 ','PER'),(4,'grabiela@gmail.com','918481520','AV. EJERCITO 15','PER'),(5,'silvia@gmail.com','948154815','AV. JUNIN 89','PER');
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad_ordenada` smallint NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  KEY `fk_detalle_venta_venta1_idx` (`id_venta`),
  KEY `fk_detalle_venta_producto1_idx` (`id_producto`),
  CONSTRAINT `fk_detalle_venta_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_detalle_venta_venta1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES (1,1,1,1,3500.00);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_disminuir_stock_producto` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
	IF NEW.cantidad_ordenada > 0 THEN
		UPDATE producto
		SET stock = stock - NEW.cantidad_ordenada
		WHERE id_producto = NEW.id_producto;
        UPDATE venta
        SET pago_total = pago_total + NEW.subtotal
        WHERE id_venta = NEW.id_venta;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `id_cargo` int NOT NULL,
  `id_contacto` int NOT NULL,
  `DNI` varchar(12) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` tinyint NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `registro_empleado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `DNI_UNIQUE` (`DNI`),
  KEY `fk_empleado_contacto1_idx` (`id_contacto`),
  KEY `fk_empleado_cargo1_idx` (`id_cargo`),
  CONSTRAINT `fk_empleado_cargo1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  CONSTRAINT `fk_empleado_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,1,1,'71234276','CRISTHIAN FERNANDO','CHAVEZ CARRILLO',1,'admin','2000-01-01','2024-09-22 03:10:08');
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `tipo_estado` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(90) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Disponible','El producto se encuentra en Stock'),(2,'Vendido','El producto ya fue vendido, pero queda registrado en el inventario'),(3,'Defectuoso','indica que el producto llego con desperfectos');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_tienda` int NOT NULL,
  `tipo_factura` enum('FACTURA','BOLETA') COLLATE utf8mb4_spanish_ci NOT NULL,
  `serie` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `numero` int NOT NULL,
  `fecha_emision` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `impuestos` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `fk_factura_venta1_idx` (`id_venta`),
  KEY `fk_factura_tienda1_idx` (`id_tienda`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (1,1,1,'BOLETA','BBV1',200,'2024-09-22 05:07:59',3500.00,NULL,3500.00);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `lista_clientes`
--

DROP TABLE IF EXISTS `lista_clientes`;
/*!50001 DROP VIEW IF EXISTS `lista_clientes`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_clientes` AS SELECT 
 1 AS `id_cliente`,
 1 AS `tipo_cliente`,
 1 AS `nro_documento`,
 1 AS `nombre`,
 1 AS `nro_celular`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_compras`
--

DROP TABLE IF EXISTS `lista_compras`;
/*!50001 DROP VIEW IF EXISTS `lista_compras`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_compras` AS SELECT 
 1 AS `id_compra`,
 1 AS `fecha_hora_registro`,
 1 AS `nombre_producto`,
 1 AS `nombre_proveedor`,
 1 AS `cantidad_compra`,
 1 AS `precio_unitario`,
 1 AS `pago_total`,
 1 AS `numero_factura`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_empleados`
--

DROP TABLE IF EXISTS `lista_empleados`;
/*!50001 DROP VIEW IF EXISTS `lista_empleados`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_empleados` AS SELECT 
 1 AS `id_empleado`,
 1 AS `DNI`,
 1 AS `nombre_completo`,
 1 AS `cargo`,
 1 AS `status`,
 1 AS `nro_celular`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_producto_item`
--

DROP TABLE IF EXISTS `lista_producto_item`;
/*!50001 DROP VIEW IF EXISTS `lista_producto_item`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_producto_item` AS SELECT 
 1 AS `id_producto_item`,
 1 AS `fecha_hora_registro`,
 1 AS `nombre_producto`,
 1 AS `id_compra`,
 1 AS `serie`,
 1 AS `tipo_estado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_productos`
--

DROP TABLE IF EXISTS `lista_productos`;
/*!50001 DROP VIEW IF EXISTS `lista_productos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_productos` AS SELECT 
 1 AS `id_producto`,
 1 AS `imagen`,
 1 AS `nombre_producto`,
 1 AS `modelo`,
 1 AS `nombre_categoria`,
 1 AS `status`,
 1 AS `precio_unitario`,
 1 AS `stock`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_proveedores`
--

DROP TABLE IF EXISTS `lista_proveedores`;
/*!50001 DROP VIEW IF EXISTS `lista_proveedores`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_proveedores` AS SELECT 
 1 AS `id_proveedor`,
 1 AS `tipo_proveedor`,
 1 AS `nro_documento`,
 1 AS `nombre`,
 1 AS `nro_celular`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_ventas`
--

DROP TABLE IF EXISTS `lista_ventas`;
/*!50001 DROP VIEW IF EXISTS `lista_ventas`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_ventas` AS SELECT 
 1 AS `id_venta`,
 1 AS `fecha_hora_registro`,
 1 AS `nro_documento`,
 1 AS `cliente`,
 1 AS `numero_factura`,
 1 AS `pago_total`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `metodo_pago`
--

DROP TABLE IF EXISTS `metodo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int NOT NULL AUTO_INCREMENT,
  `nombre_metodo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodo_pago`
--

LOCK TABLES `metodo_pago` WRITE;
/*!40000 ALTER TABLE `metodo_pago` DISABLE KEYS */;
INSERT INTO `metodo_pago` VALUES (1,'Efectivo',''),(2,'Tarjeta',''),(3,'Yape','');
/*!40000 ALTER TABLE `metodo_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `modelo` varchar(90) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `imagen` text COLLATE utf8mb4_spanish_ci,
  `status` tinyint(1) NOT NULL,
  `stock` smallint unsigned NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `stock_minimo` smallint unsigned DEFAULT NULL,
  `id_categoria_producto` int NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_categoria_producto1_idx` (`id_categoria_producto`),
  CONSTRAINT `fk_producto_categoria_producto1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categoria_producto` (`id_categoria_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'ASUS ROG Strix G16 (2024)','G16 (2024) ','ASUS ROG Strix G16 (2024) Gaming Laptop, 16” 16:10 FHD 165Hz Display, NVIDIA® GeForce RTX™ 4060, Intel Core i7-13650HX, 16GB DDR5, 1TB PCIe Gen4 SSD, Wi-Fi 6E, Windows 11, G614JV-AS74','505083851._AC_SX466_',1,2,3500.00,5,1),(2,'ASUS TUF Gaming F17 (2023)','F17','ASUS TUF Gaming F17 (2023) Laptop para juegos, pantalla FHD de 17.3 pulgadas de 144 Hz, GeForce RTX 3050, Intel Core i5-12500H, DDR4 de 16 GB, SSD PCIe de 512 GB, Wi-Fi 6, Windows 11, FX707ZC-ES53,','829451801._AC_SX466_',1,0,3500.00,5,1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `alerta_stock_minimo` AFTER UPDATE ON `producto` FOR EACH ROW BEGIN
	DECLARE var_stock_minimo INT;
	DECLARE mensaje_alerta TEXT;

	-- Obtenemos el stock minimo del producto y lo guardamos en la variable var_stock_minimo
	SELECT stock_minimo INTO var_stock_minimo
	FROM producto
	WHERE id_producto = NEW.id_producto;

	-- Comparamos el nuevo stock con el stock_minimo del producto
	IF NEW.stock < var_stock_minimo THEN
		SET mensaje_alerta = CONCAT('El stock del producto ', NEW.nombre_producto, ' está por debajo del límite mínimo. Stock actual: ', NEW.stock);
		INSERT INTO alerta_stock (id_producto, mensaje) VALUES (NEW.id_producto, mensaje_alerta);
	ELSE
	-- Si el stock aumenta por encima del minimo, eliminamos la alerta
		DELETE FROM alerta_stock WHERE id_producto = NEW.id_producto;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `producto_item`
--

DROP TABLE IF EXISTS `producto_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_item` (
  `id_producto_item` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_compra` int NOT NULL,
  `id_estado` int NOT NULL,
  `serie` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT '0',
  `ubicacion` text COLLATE utf8mb4_spanish_ci,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_producto_item`,`id_producto`),
  KEY `fk_detalle_producto_producto1_idx` (`id_producto`),
  KEY `fk_inventario_estado1_idx` (`id_estado`),
  KEY `fk_inventario_compra1_idx` (`id_compra`),
  CONSTRAINT `fk_detalle_producto_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_inventario_compra1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`),
  CONSTRAINT `fk_inventario_estado1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_item`
--

LOCK TABLES `producto_item` WRITE;
/*!40000 ALTER TABLE `producto_item` DISABLE KEYS */;
INSERT INTO `producto_item` VALUES (1,1,1,2,'515151161615',NULL,'2024-09-22 04:57:31'),(2,1,1,1,'427274272772',NULL,'2024-09-22 04:57:31'),(3,1,1,1,'727456487867',NULL,'2024-09-22 04:57:31');
/*!40000 ALTER TABLE `producto_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_item_has_detalle_venta`
--

DROP TABLE IF EXISTS `producto_item_has_detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_item_has_detalle_venta` (
  `id_producto_item` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_detalle_venta` int NOT NULL,
  PRIMARY KEY (`id_producto_item`,`id_producto`,`id_detalle_venta`),
  KEY `fk_producto_item_has_detalle_venta_detalle_venta1_idx` (`id_detalle_venta`),
  KEY `fk_producto_item_has_detalle_venta_producto_item1_idx` (`id_producto_item`,`id_producto`),
  CONSTRAINT `fk_producto_item_has_detalle_venta_detalle_venta1` FOREIGN KEY (`id_detalle_venta`) REFERENCES `detalle_venta` (`id_detalle_venta`),
  CONSTRAINT `fk_producto_item_has_detalle_venta_producto_item1` FOREIGN KEY (`id_producto_item`, `id_producto`) REFERENCES `producto_item` (`id_producto_item`, `id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_item_has_detalle_venta`
--

LOCK TABLES `producto_item_has_detalle_venta` WRITE;
/*!40000 ALTER TABLE `producto_item_has_detalle_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_item_has_detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `tipo_proveedor` enum('DNI','RUC') COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_documento` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_contacto` int NOT NULL,
  `departamento` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `registro_proveedor` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `nro_documento_UNIQUE` (`nro_documento`),
  KEY `fk_proveedor_contacto1_idx` (`id_contacto`),
  CONSTRAINT `fk_proveedor_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'RUC','20274968908','SERVICIOS Y TECNOLOGIA S.R.L.',2,'LIMA','2024-09-22 04:21:19'),(2,'RUC','20600158741','TECNOLOGIA Y SERVICIOS PARA LA INFORMATICA PE',3,'LIMA','2024-09-22 04:27:59');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor_has_categoria_producto`
--

DROP TABLE IF EXISTS `proveedor_has_categoria_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor_has_categoria_producto` (
  `id_proveedor` int NOT NULL,
  `id_categoria_producto` int NOT NULL,
  PRIMARY KEY (`id_proveedor`,`id_categoria_producto`),
  KEY `fk_proveedor_has_categoria_producto_categoria_producto1_idx` (`id_categoria_producto`),
  KEY `fk_proveedor_has_categoria_producto_proveedor1_idx` (`id_proveedor`),
  CONSTRAINT `fk_proveedor_has_categoria_producto_categoria_producto1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categoria_producto` (`id_categoria_producto`),
  CONSTRAINT `fk_proveedor_has_categoria_producto_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor_has_categoria_producto`
--

LOCK TABLES `proveedor_has_categoria_producto` WRITE;
/*!40000 ALTER TABLE `proveedor_has_categoria_producto` DISABLE KEYS */;
INSERT INTO `proveedor_has_categoria_producto` VALUES (1,2);
/*!40000 ALTER TABLE `proveedor_has_categoria_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tienda`
--

DROP TABLE IF EXISTS `tienda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tienda` (
  `id_tienda` int NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruc` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_1` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_2` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tienda`
--

LOCK TABLES `tienda` WRITE;
/*!40000 ALTER TABLE `tienda` DISABLE KEYS */;
/*!40000 ALTER TABLE `tienda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_metodo_pago` int NOT NULL,
  `registro_venta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  `pago_total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `fk_venta_empleado1_idx` (`id_empleado`),
  KEY `fk_venta_cliente1_idx` (`id_cliente`),
  KEY `fk_venta_metodo_pago1_idx` (`id_metodo_pago`),
  CONSTRAINT `fk_venta_cliente1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_venta_empleado1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  CONSTRAINT `fk_venta_metodo_pago1` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,1,1,1,'2024-09-22 05:02:53','Todo Correcto',3500.00);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'bd_tienda'
--
/*!50003 DROP PROCEDURE IF EXISTS `agregar_cliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_cliente`(
	-- Datos proveedor
	IN new_tipo_cliente ENUM('DNI','RUC'),
    IN new_nro_documento VARCHAR(12),
    IN new_nombre VARCHAR(90),
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo proveedor
	INSERT INTO cliente (tipo_cliente, nro_documento, nombre, id_contacto)
    VALUES (new_tipo_cliente, new_nro_documento, new_nombre, LAST_INSERT_ID());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_compra`(
	-- Datos producto
    IN new_id_producto INT,
    IN new_id_proveedor INT,
    IN new_id_empleado INT,
    IN new_descripcion TEXT,
    IN new_cantidad_compra SMALLINT UNSIGNED,
    IN new_precio_unitario DECIMAL(10,2),
    IN new_pago_total DECIMAL(10,2),
    IN new_id_metodo_pago INT,
    IN new_numero_factura VARCHAR(20)
)
BEGIN
    -- Agregar una nueva Compra
	INSERT INTO compra (id_producto, id_proveedor, id_empleado, descripcion, cantidad_compra, precio_unitario, pago_total, 
    id_metodo_pago, numero_factura)
    VALUES (new_id_producto, new_id_proveedor, new_id_empleado, new_descripcion, new_cantidad_compra, new_precio_unitario ,new_pago_total, 
    new_id_metodo_pago, new_numero_factura);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_contacto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_contacto`(
	IN p_email VARCHAR(45),
	IN p_celular VARCHAR(15),
    IN p_direccion VARCHAR(45),
    IN p_nacionalidad CHAR(3)
)
BEGIN
	INSERT INTO contacto ( email, nro_celular, direccion, nacionalidad)
    VALUES (p_email, p_celular, p_direccion, p_nacionalidad);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_detalle_venta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_detalle_venta`(
	-- Datos del detalle venta
    IN new_id_venta INT,
    IN new_id_producto INT,
    IN new_id_cantidad_ordenada SMALLINT,
    IN new_subtotal DECIMAL(10,2)
)
BEGIN
    -- Agregar un detalle venta
	INSERT INTO detalle_venta (id_venta, id_producto, cantidad_ordenada, subtotal)
    VALUES (new_id_venta, new_id_producto, new_id_cantidad_ordenada, new_subtotal);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_empleado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_empleado`(
	-- Datos empleado
	IN new_DNI VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_apellido VARCHAR(45),
    IN new_estatus TINYINT,
    IN new_password VARCHAR(45),
    IN new_fecha_nacimiento DATE,
    IN new_id_cargo INT,
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo empleado
	INSERT INTO empleado (DNI, nombre, apellido, status, password, id_cargo ,id_contacto, fecha_nacimiento)
    VALUES (new_DNI, new_nombre, new_apellido, new_estatus, new_password, new_id_cargo, 
    LAST_INSERT_ID(), new_fecha_nacimiento);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_producto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_producto`(
	-- Datos producto
    IN new_nombre VARCHAR(90),
    IN new_modelo VARCHAR(90),
    IN new_descripcion TEXT,
    IN new_imagen TEXT,
	IN new_status TINYINT(1),
    IN new_precio_unitario DECIMAL(10,2),
    IN new_stock_minimo SMALLINT UNSIGNED,
	-- Datos categoria_producto
	IN new_id_categoria INT
)
BEGIN
    -- Agregar un nuevo producto
	INSERT INTO producto (nombre_producto, modelo, descripcion, imagen, status, stock, precio_unitario, 
    stock_minimo, id_categoria_producto)
    VALUES (new_nombre, new_modelo, new_descripcion, new_imagen, new_status, 0 ,new_precio_unitario, 
    new_stock_minimo, new_id_categoria);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_proveedor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_proveedor`(
	-- Datos proveedor
	IN new_tipo_proveedor ENUM('DNI','RUC'),
    IN new_nro_documento VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_departamento VARCHAR(45),
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo proveedor
	INSERT INTO proveedor (tipo_proveedor, nro_documento, nombre, id_contacto, departamento)
    VALUES (new_tipo_proveedor, new_nro_documento, new_nombre, LAST_INSERT_ID(), new_departamento);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_venta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_venta`(
	-- Datos de venta
    IN new_id_empleado INT,
    IN new_id_cliente INT,
    IN new_id_metodo_pago INT,
    IN new_observaciones TEXT
)
BEGIN
    -- Agregar una nueva Venta
	INSERT INTO venta (id_empleado, id_cliente, id_metodo_pago, observaciones)
    VALUES (new_id_empleado, new_id_cliente, new_id_metodo_pago, new_observaciones);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `editar_cliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_cliente`(
	-- Datos Proveedor
    IN new_id_cliente INT,
	IN new_tipo_cliente ENUM('DNI','RUC'),
    IN new_nro_documento VARCHAR(12),
    IN new_nombre VARCHAR(45),
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	DECLARE var_id_contacto INT;
    -- Buscamos el id_contacto del empleado
    SELECT cl.id_contacto INTO var_id_contacto FROM cliente cl
    INNER JOIN contacto c ON cl.id_contacto = c.id_contacto WHERE id_cliente = new_id_cliente; 
	-- Actualizamos datos de contacto
	UPDATE contacto SET email=new_email, nro_celular= new_celular, direccion=new_direccion, 
    nacionalidad=new_nacionalidad WHERE id_contacto = var_id_contacto;
    -- Actualizamos datos del empleado
	UPDATE cliente SET tipo_cliente=new_tipo_cliente, nro_documento=new_nro_documento, nombre=new_nombre 
	WHERE id_cliente = new_id_cliente;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `editar_empleado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_empleado`(
	-- Datos empleado
    IN new_id_empleado INT,
	IN new_DNI VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_apellido VARCHAR(45),
    IN new_estatus TINYINT,
    IN new_password VARCHAR(45),
    IN new_fecha_nacimiento DATE,
    IN new_id_cargo INT,
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	DECLARE var_id_contacto INT;
    -- Buscamos el id_contacto del empleado
    SELECT e.id_contacto INTO var_id_contacto FROM empleado e
    INNER JOIN contacto c ON e.id_contacto = c.id_contacto WHERE id_empleado = new_id_empleado; 
	-- Actualizamos datos de contacto
	UPDATE contacto SET email=new_email, nro_celular= new_celular, direccion=new_direccion, 
    nacionalidad=new_nacionalidad WHERE id_contacto = var_id_contacto;
    -- Actualizamos datos del empleado
	UPDATE empleado SET DNI=new_DNI, nombre=new_nombre, apellido=new_apellido, status=new_estatus, 
    password=new_password, id_cargo=new_id_cargo , fecha_nacimiento=new_fecha_nacimiento 
    WHERE id_empleado = new_id_empleado;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `editar_producto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_producto`(
	-- Datos producto
    IN new_id_producto INT,
    IN new_nombre VARCHAR(90),
    IN new_modelo VARCHAR(90),
    IN new_descripcion TEXT,
    IN new_imagen TEXT,
	IN new_status TINYINT(1),
    IN new_precio_unitario DECIMAL(10,2),
    IN new_stock_minimo SMALLINT UNSIGNED,
    IN new_stock SMALLINT UNSIGNED,
	-- Datos categoria_producto
	IN new_id_categoria INT
)
BEGIN
	-- Actualizamos datos del producto
	UPDATE producto SET nombre_producto=new_nombre, modelo=new_modelo, descripcion=new_descripcion, 
    imagen=new_imagen, status=new_status, precio_unitario=new_precio_unitario, stock_minimo=new_stock_minimo, 
    stock=new_stock, id_categoria_producto=new_id_categoria WHERE id_producto = new_id_producto;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `editar_proveedor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_proveedor`(
	-- Datos Proveedor
    IN new_id_proveedor INT,
	IN new_tipo_proveedor ENUM('DNI','RUC'),
    IN new_nro_documento VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_departamento VARCHAR(45),
	-- Datos contacto
	IN new_email VARCHAR(45),
	IN new_celular VARCHAR(15),
    IN new_direccion VARCHAR(45),
    IN new_nacionalidad CHAR(3)
)
BEGIN
	DECLARE var_id_contacto INT;
    -- Buscamos el id_contacto del empleado
    SELECT p.id_contacto INTO var_id_contacto FROM proveedor p
    INNER JOIN contacto c ON p.id_contacto = c.id_contacto WHERE id_proveedor = new_id_proveedor; 
	-- Actualizamos datos de contacto
	UPDATE contacto SET email=new_email, nro_celular= new_celular, direccion=new_direccion, 
    nacionalidad=new_nacionalidad WHERE id_contacto = var_id_contacto;
    -- Actualizamos datos del empleado
	UPDATE proveedor SET tipo_proveedor=new_tipo_proveedor, nro_documento=new_nro_documento, 
    nombre=new_nombre, departamento=new_departamento WHERE id_proveedor = new_id_proveedor;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `lista_clientes`
--

/*!50001 DROP VIEW IF EXISTS `lista_clientes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_clientes` AS select `cliente`.`id_cliente` AS `id_cliente`,`cliente`.`tipo_cliente` AS `tipo_cliente`,`cliente`.`nro_documento` AS `nro_documento`,`cliente`.`nombre` AS `nombre`,`contacto`.`nro_celular` AS `nro_celular`,`contacto`.`email` AS `email` from (`cliente` join `contacto` on((`cliente`.`id_contacto` = `contacto`.`id_contacto`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_compras`
--

/*!50001 DROP VIEW IF EXISTS `lista_compras`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_compras` AS select `c`.`id_compra` AS `id_compra`,date_format(`c`.`registro_compra`,'%b %d, %Y, %H:%i') AS `fecha_hora_registro`,`producto`.`nombre_producto` AS `nombre_producto`,`pr`.`nombre` AS `nombre_proveedor`,`c`.`cantidad_compra` AS `cantidad_compra`,`c`.`precio_unitario` AS `precio_unitario`,`c`.`pago_total` AS `pago_total`,`c`.`numero_factura` AS `numero_factura` from ((`compra` `c` join `producto` on((`c`.`id_producto` = `producto`.`id_producto`))) join `proveedor` `pr` on((`c`.`id_proveedor` = `pr`.`id_proveedor`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_empleados`
--

/*!50001 DROP VIEW IF EXISTS `lista_empleados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_empleados` AS select `empleado`.`id_empleado` AS `id_empleado`,`empleado`.`DNI` AS `DNI`,concat(`empleado`.`nombre`,' ',`empleado`.`apellido`) AS `nombre_completo`,`cargo`.`nombre_cargo` AS `cargo`,`empleado`.`status` AS `status`,`contacto`.`nro_celular` AS `nro_celular`,`contacto`.`email` AS `email` from ((`empleado` join `contacto` on((`empleado`.`id_contacto` = `contacto`.`id_contacto`))) join `cargo` on((`empleado`.`id_cargo` = `cargo`.`id_cargo`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_producto_item`
--

/*!50001 DROP VIEW IF EXISTS `lista_producto_item`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_producto_item` AS select `producto_item`.`id_producto_item` AS `id_producto_item`,date_format(`producto_item`.`fecha_registro`,'%b %d, %Y, %H:%i') AS `fecha_hora_registro`,`producto`.`nombre_producto` AS `nombre_producto`,`producto_item`.`id_compra` AS `id_compra`,`producto_item`.`serie` AS `serie`,`estado`.`tipo_estado` AS `tipo_estado` from ((`producto_item` join `estado` on((`producto_item`.`id_estado` = `estado`.`id_estado`))) join `producto` on((`producto_item`.`id_producto` = `producto`.`id_producto`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_productos`
--

/*!50001 DROP VIEW IF EXISTS `lista_productos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_productos` AS select `producto`.`id_producto` AS `id_producto`,`producto`.`imagen` AS `imagen`,`producto`.`nombre_producto` AS `nombre_producto`,`producto`.`modelo` AS `modelo`,`categoria_producto`.`nombre_categoria` AS `nombre_categoria`,`producto`.`status` AS `status`,`producto`.`precio_unitario` AS `precio_unitario`,`producto`.`stock` AS `stock` from (`producto` join `categoria_producto` on((`producto`.`id_categoria_producto` = `categoria_producto`.`id_categoria_producto`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_proveedores`
--

/*!50001 DROP VIEW IF EXISTS `lista_proveedores`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_proveedores` AS select `proveedor`.`id_proveedor` AS `id_proveedor`,`proveedor`.`tipo_proveedor` AS `tipo_proveedor`,`proveedor`.`nro_documento` AS `nro_documento`,`proveedor`.`nombre` AS `nombre`,`contacto`.`nro_celular` AS `nro_celular`,`contacto`.`email` AS `email` from (`proveedor` join `contacto` on((`proveedor`.`id_contacto` = `contacto`.`id_contacto`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_ventas`
--

/*!50001 DROP VIEW IF EXISTS `lista_ventas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_ventas` AS select `v`.`id_venta` AS `id_venta`,date_format(`v`.`registro_venta`,'%b %d, %Y, %H:%i') AS `fecha_hora_registro`,`c`.`nro_documento` AS `nro_documento`,`c`.`nombre` AS `cliente`,concat(`f`.`serie`,'-',`f`.`numero`) AS `numero_factura`,`v`.`pago_total` AS `pago_total` from ((`venta` `v` join `cliente` `c` on((`v`.`id_cliente` = `c`.`id_cliente`))) join `factura` `f` on((`v`.`id_venta` = `f`.`id_venta`))) */;
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

-- Dump completed on 2024-09-22 10:18:41
