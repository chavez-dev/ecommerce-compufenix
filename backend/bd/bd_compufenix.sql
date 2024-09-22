-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307:3307
-- Tiempo de generación: 20-03-2024 a las 02:05:07
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_compufenix`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `agregar_cliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_cliente` (IN `new_tipo_cliente` ENUM('DNI','RUC'), IN `new_nro_documento` VARCHAR(12), IN `new_nombre` VARCHAR(90), IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo proveedor
	INSERT INTO cliente (tipo_cliente, nro_documento, nombre, id_contacto)
    VALUES (new_tipo_cliente, new_nro_documento, new_nombre, LAST_INSERT_ID());
END$$

DROP PROCEDURE IF EXISTS `agregar_compra`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_compra` (IN `new_id_producto` INT, IN `new_id_proveedor` INT, IN `new_id_empleado` INT, IN `new_descripcion` TEXT, IN `new_cantidad_compra` SMALLINT UNSIGNED, IN `new_precio_unitario` DECIMAL(10,2), IN `new_pago_total` DECIMAL(10,2), IN `new_id_metodo_pago` INT, IN `new_numero_factura` VARCHAR(20))   BEGIN
    -- Agregar una nueva Compra
	INSERT INTO compra (id_producto, id_proveedor, id_empleado, descripcion, cantidad_compra, precio_unitario, pago_total, 
    id_metodo_pago, numero_factura)
    VALUES (new_id_producto, new_id_proveedor, new_id_empleado, new_descripcion, new_cantidad_compra, new_precio_unitario ,new_pago_total, 
    new_id_metodo_pago, new_numero_factura);
END$$

DROP PROCEDURE IF EXISTS `agregar_contacto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_contacto` (IN `p_email` VARCHAR(45), IN `p_celular` VARCHAR(15), IN `p_direccion` VARCHAR(45), IN `p_nacionalidad` CHAR(3))   BEGIN
	INSERT INTO contacto ( email, nro_celular, direccion, nacionalidad)
    VALUES (p_email, p_celular, p_direccion, p_nacionalidad);
END$$

DROP PROCEDURE IF EXISTS `agregar_empleado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_empleado` (IN `new_DNI` VARCHAR(12), IN `new_nombre` VARCHAR(45), IN `new_apellido` VARCHAR(45), IN `new_estatus` TINYINT, IN `new_password` VARCHAR(45), IN `new_fecha_nacimiento` DATE, IN `new_id_cargo` INT, IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo empleado
	INSERT INTO empleado (DNI, nombre, apellido, status, password, id_cargo ,id_contacto, fecha_nacimiento)
    VALUES (new_DNI, new_nombre, new_apellido, new_estatus, new_password, new_id_cargo, 
    LAST_INSERT_ID(), new_fecha_nacimiento);
END$$

DROP PROCEDURE IF EXISTS `agregar_producto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_producto` (IN `new_nombre` VARCHAR(90), IN `new_modelo` VARCHAR(90), IN `new_descripcion` TEXT, IN `new_imagen` TEXT, IN `new_status` TINYINT(1), IN `new_precio_unitario` DECIMAL(10,2), IN `new_stock_minimo` SMALLINT UNSIGNED, IN `new_id_categoria` INT)   BEGIN
    -- Agregar un nuevo producto
	INSERT INTO producto (nombre_producto, modelo, descripcion, imagen, status, stock, precio_unitario, 
    stock_minimo, id_categoria_producto)
    VALUES (new_nombre, new_modelo, new_descripcion, new_imagen, new_status, 0 ,new_precio_unitario, 
    new_stock_minimo, new_id_categoria);
END$$

DROP PROCEDURE IF EXISTS `agregar_proveedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_proveedor` (IN `new_tipo_proveedor` ENUM('DNI','RUC'), IN `new_nro_documento` VARCHAR(12), IN `new_nombre` VARCHAR(45), IN `new_departamento` VARCHAR(45), IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
	-- Agregar un nuevo contacto
    CALL agregar_contacto(new_email, new_celular, new_direccion, new_nacionalidad);
    -- Agregar un nuevo proveedor
	INSERT INTO proveedor (tipo_proveedor, nro_documento, nombre, id_contacto, departamento)
    VALUES (new_tipo_proveedor, new_nro_documento, new_nombre, LAST_INSERT_ID(), new_departamento);
END$$

DROP PROCEDURE IF EXISTS `editar_cliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_cliente` (IN `new_id_cliente` INT, IN `new_tipo_cliente` ENUM('DNI','RUC'), IN `new_nro_documento` VARCHAR(12), IN `new_nombre` VARCHAR(45), IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
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
END$$

DROP PROCEDURE IF EXISTS `editar_empleado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_empleado` (IN `new_id_empleado` INT, IN `new_DNI` VARCHAR(12), IN `new_nombre` VARCHAR(45), IN `new_apellido` VARCHAR(45), IN `new_estatus` TINYINT, IN `new_password` VARCHAR(45), IN `new_fecha_nacimiento` DATE, IN `new_id_cargo` INT, IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
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
END$$

DROP PROCEDURE IF EXISTS `editar_producto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_producto` (IN `new_id_producto` INT, IN `new_nombre` VARCHAR(90), IN `new_modelo` VARCHAR(90), IN `new_descripcion` TEXT, IN `new_imagen` TEXT, IN `new_status` TINYINT(1), IN `new_precio_unitario` DECIMAL(10,2), IN `new_stock_minimo` SMALLINT UNSIGNED, IN `new_stock` SMALLINT UNSIGNED, IN `new_id_categoria` INT)   BEGIN
	-- Actualizamos datos del producto
	UPDATE producto SET nombre_producto=new_nombre, modelo=new_modelo, descripcion=new_descripcion, 
    imagen=new_imagen, status=new_status, precio_unitario=new_precio_unitario, stock_minimo=new_stock_minimo, 
    stock=new_stock, id_categoria_producto=new_id_categoria WHERE id_producto = new_id_producto;
END$$

DROP PROCEDURE IF EXISTS `editar_proveedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_proveedor` (IN `new_id_proveedor` INT, IN `new_tipo_proveedor` ENUM('DNI','RUC'), IN `new_nro_documento` VARCHAR(12), IN `new_nombre` VARCHAR(45), IN `new_departamento` VARCHAR(45), IN `new_email` VARCHAR(45), IN `new_celular` VARCHAR(15), IN `new_direccion` VARCHAR(45), IN `new_nacionalidad` CHAR(3))   BEGIN
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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta_stock`
--

DROP TABLE IF EXISTS `alerta_stock`;
CREATE TABLE IF NOT EXISTS `alerta_stock` (
  `id_alerta_stock` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `mensaje` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_mensaje` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_alerta_stock`),
  KEY `fk_alerta_stock_producto1_idx` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(75) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre_cargo`, `descripcion`) VALUES
(1, 'Administrador', NULL),
(2, 'Empleado', NULL),
(3, 'Tecnico', NULL),
(4, 'Marketing', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

DROP TABLE IF EXISTS `categoria_producto`;
CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `id_categoria_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_categoria_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id_categoria_producto`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Laptops', 'Computadoras portátiles'),
(2, 'Accesorios', 'Diversos accesorios para computadoras'),
(3, 'Impresoras', 'Impresoras y dispositivos de impresión'),
(4, 'Monitores', 'Monitores y pantallas'),
(5, 'Perifericos', 'Dispositivos periféricos como teclados y rato'),
(6, 'Utensilios', 'Utensiolios para PCs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `tipo_cliente` enum('DNI','RUC') COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_documento` varchar(12) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_contacto` int NOT NULL,
  `registro_cliente` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `nro_documento_UNIQUE` (`nro_documento`),
  KEY `fk_cliente_contacto1_idx` (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `tipo_cliente`, `nro_documento`, `nombre`, `id_contacto`, `registro_cliente`) VALUES
(1, 'DNI', '12345678', 'JUAN CARLOS PEREZ GOMEZ', 12, '2024-03-09 21:05:39'),
(2, 'DNI', '87654321', 'MARIA ANGELICA LOPEZ MARTINEZ', 13, '2024-03-09 21:05:39'),
(3, 'DNI', '98765432', 'CARLOS ALBERTO RAMIREZ CRUZ', 14, '2024-03-09 21:05:39'),
(4, 'RUC', '12345678901', 'TECHSOLUTIONS CORP', 15, '2024-03-09 21:05:39'),
(5, 'RUC', '10987654321', 'DATA SYSTEMS INC', 16, '2024-03-09 21:05:39'),
(6, 'RUC', '12345678902', 'SOFTWARETECH S.A.C.', 17, '2024-03-09 21:05:39'),
(7, 'DNI', '11223344', 'LUIS ANTONIO GARCIA RODRIGUEZ', 18, '2024-03-09 21:05:39'),
(8, 'DNI', '55667788', 'ANA MARIA TORRES GOMEZ', 19, '2024-03-09 21:05:39'),
(9, 'DNI', '79887766', 'PEDRO LUIS CRUZ PEREZ', 20, '2024-03-09 21:05:39'),
(10, 'RUC', '12345678903', 'INNOVATIONTECH INC', 21, '2024-03-09 21:05:39'),
(11, 'RUC', '10987654322', 'CLOUD COMPUTING SOLUTIONS', 22, '2024-03-09 21:05:39'),
(12, 'RUC', '12345678904', 'BIG DATA SOLUTIONS SAC', 23, '2024-03-09 21:05:39'),
(13, 'DNI', '76445566', 'JUANA ISABEL PEREZ LOPEZ', 24, '2024-03-09 21:05:39'),
(14, 'DNI', '77889900', 'CARLA PATRICIA LOPEZ TORRES', 25, '2024-03-09 21:05:39'),
(15, 'DNI', '72223355', 'MARIO ALFREDO RAMIREZ GARCIA', 26, '2024-03-09 21:05:39'),
(16, 'RUC', '12345678905', 'ARTIFICIAL INTELLIGENCE CORP', 27, '2024-03-09 21:05:39'),
(17, 'RUC', '10987654323', 'BLOCKCHAIN SOLUTIONS SAC', 28, '2024-03-09 21:05:39'),
(18, 'RUC', '20345678906', 'CYBERSECURITY SOLUTIONS INC', 29, '2024-03-09 21:05:39'),
(19, 'DNI', '73445577', 'JULIA ROSA GARCIA LOPEZ', 30, '2024-03-09 21:05:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_empleado` int NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `cantidad_compra` smallint UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `pago_total` decimal(10,2) DEFAULT NULL,
  `id_metodo_pago` int NOT NULL,
  `numero_factura` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_compra` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_compra`),
  KEY `fk_compra_proveedor1_idx` (`id_proveedor`),
  KEY `fk_compra_empleado1_idx` (`id_empleado`),
  KEY `fk_compra_metodo_pago1_idx` (`id_metodo_pago`),
  KEY `fk_compra_producto1_idx` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `id_producto`, `id_proveedor`, `id_empleado`, `descripcion`, `cantidad_compra`, `precio_unitario`, `pago_total`, `id_metodo_pago`, `numero_factura`, `registro_compra`) VALUES
(1, 1, 5, 1, 'faf', 2, 3622.00, 7244.00, 1, '1526', '2024-03-15 01:26:55');

--
-- Disparadores `compra`
--
DROP TRIGGER IF EXISTS `trigger_actualizar_stock_producto`;
DELIMITER $$
CREATE TRIGGER `trigger_actualizar_stock_producto` AFTER UPDATE ON `compra` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger_aumentar_stock_producto`;
DELIMITER $$
CREATE TRIGGER `trigger_aumentar_stock_producto` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
	IF NEW.cantidad_compra > 0 THEN
		UPDATE producto
		SET stock = stock + NEW.cantidad_compra
		WHERE id_producto = NEW.id_producto;
	END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger_borrar_stock_producto`;
DELIMITER $$
CREATE TRIGGER `trigger_borrar_stock_producto` AFTER DELETE ON `compra` FOR EACH ROW BEGIN
	-- Actualizamos el mismo producto con la nueva cantidad_compra
	UPDATE producto
	SET stock = stock - OLD.cantidad_compra
	WHERE id_producto = OLD.id_producto;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

DROP TABLE IF EXISTS `contacto`;
CREATE TABLE IF NOT EXISTS `contacto` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_celular` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nacionalidad` char(3) COLLATE utf8mb4_spanish_ci DEFAULT 'PER',
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `email`, `nro_celular`, `direccion`, `nacionalidad`) VALUES
(1, 'criss@gmail.com', '948151516', 'Av. Los Granados 514', 'PER'),
(2, 'ana@gmail.com', '948154815', 'Av.  Las flores 15', 'PER'),
(3, 'fernandez@gmail.com', '948154815', 'Av. Ejercito A15', 'PER'),
(4, 'litano@gmail.com', '915481516', 'Av. Los Proceres Mz. 16', 'PER'),
(5, 'abril@gmail.com', '948154812', 'Av. Concepcion 16', 'PER'),
(6, 'luna@gmail.com', '923453445', 'Av. Crnl. Armando A16', 'PER'),
(7, 'campos@gmail.com', '948152626', 'Av. Mendez 548 A5', 'ARG'),
(8, 'diaz@gmail.como', '934232345', 'Av. Los Generales 234', 'ARG'),
(9, 'catacora@gmail.com', '923455655', 'Av. Gran Bretaña 3434', 'COL'),
(11, 'milagros@gmail.com', '915481516', 'Av. Los Granados 154', 'PER'),
(12, 'juan@example.com', '999888777', 'AV. LARCO 123', 'PER'),
(13, 'maria@example.com', '111222333', 'AV. ARENALES 456', 'PER'),
(14, 'carlos@example.com', '444555666', 'AV. BRASIL 789', 'PER'),
(15, 'empresa1@example.com', '777888999', 'AV. TACNA 111', 'PER'),
(16, 'empresa2@example.com', '222333444', 'AV. HUAYLAS 222', 'PER'),
(17, 'empresa3@example.com', '555666777', 'AV. LIMA 333', 'PER'),
(18, 'luis@example.com', '111222333', 'AV. PERU 444', 'PER'),
(19, 'ana@example.com', '444555666', 'AV. BOLIVAR 555', 'PER'),
(20, 'pedro@example.com', '777888999', 'AV. ARICA 666', 'PER'),
(21, 'empresa4@example.com', '888999000', 'AV. TUMBES 777', 'PER'),
(22, 'empresa5@example.com', '333444555', 'AV. TACNA 888', 'PER'),
(23, 'empresa6@example.com', '666777888', 'AV. BRASIL 999', 'PER'),
(24, 'juana@example.com', '222333444', 'AV. LARCO 999', 'PER'),
(25, 'carla@example.com', '555666777', 'AV. ARENALES 888', 'PER'),
(26, 'mario@example.com', '888999000', 'AV. BRASIL 777', 'PER'),
(27, 'empresa7@example.com', '999000111', 'AV. LIMA 666', 'PER'),
(28, 'empresa8@example.com', '111222333', 'AV. TACNA 555', 'PER'),
(29, 'empresa9@example.com', '444555666', 'AV. ARICA 333', 'PER'),
(30, 'julia@example.com', '222333444', 'AV. PERU 222', 'PER'),
(31, 'juan@gmail.com', '999888777', 'AV. LARCO 123', 'PER'),
(32, 'maria@gmail.com', '111222333', 'AV. ARENALES 456', 'PER'),
(33, 'carlos@gmail.com', '444555666', 'AV. BRASIL 789', 'PER'),
(34, 'techsolutions@gmail.com', '777888999', 'AV. TACNA 111', 'PER'),
(35, 'datasystem@gmail.com', '222333444', 'AV. HUAYLAS 222', 'PER'),
(36, 'softwaretech@gmail.com', '555666777', 'AV. LIMA 333', 'PER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `id_detalle_venta` int NOT NULL,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad_ordenada` smallint DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_venta`,`id_venta`),
  KEY `fk_detalle_venta_venta1_idx` (`id_venta`),
  KEY `fk_detalle_venta_producto1_idx` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `DNI` varchar(12) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` tinyint NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_cargo` int NOT NULL,
  `id_contacto` int NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `registro_empleado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `DNI_UNIQUE` (`DNI`),
  KEY `fk_empleado_contacto1_idx` (`id_contacto`),
  KEY `fk_empleado_cargo1_idx` (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `DNI`, `nombre`, `apellido`, `status`, `password`, `id_cargo`, `id_contacto`, `fecha_nacimiento`, `registro_empleado`) VALUES
(1, '71234276', 'CRISTHIAN FERNANDO', 'CHAVEZ CARRILLO', 1, 'admin', 1, 1, '2000-10-01', '2024-03-02 02:19:54'),
(2, '71451815', 'ANA CECILIA', 'ASTUDILLO CHAVEZ', 1, 'emp', 2, 2, '1995-01-01', '2024-03-02 20:36:37'),
(3, '72154815', 'DAYHANA ELIZABETH', 'FERNANDEZ CCENTE', 1, 'emp', 2, 3, '1998-12-01', '2024-03-02 20:37:27'),
(4, '72164813', 'EDWAR FRANKLIN', 'LITANO PAZO', 1, 'emp', 2, 4, '1980-12-02', '2024-03-02 20:38:28'),
(5, '72154816', 'JHOAN MARTIN', 'ABRIL PILCO', 0, 'emp', 3, 5, '2000-04-12', '2024-03-02 20:39:44'),
(6, '00421548', 'CLAUDIO', 'LUNA CORONEL', 0, 'admin', 1, 6, '1990-12-12', '2024-03-02 20:41:05'),
(7, '00151216', 'ELENA', 'MERI CAMPOS', 0, 'emp', 2, 7, '2001-02-10', '2024-03-02 20:43:23'),
(8, '00152639', 'FLORINDA', 'DIAZ TUESTA VDA DE GARCIA', 0, 'emp', 2, 8, '2000-10-01', '2024-03-02 20:45:15'),
(9, '00485948', 'MARTINA MARTHA', 'CATACORA MAMANI', 1, 'emp', 2, 9, '1985-10-28', '2024-03-02 20:47:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `tipo_estado` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(90) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `tipo_estado`, `descripcion`) VALUES
(1, 'Disponible', 'El producto se encuentra en Stock'),
(2, 'Vendido', 'El producto ya fue vendido, pero queda registrado en el inventario\r\n'),
(3, 'Malogrado', 'indica que el producto llego con desperfectos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

DROP TABLE IF EXISTS `factura`;
CREATE TABLE IF NOT EXISTS `factura` (
  `num_factura` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo_factura` enum('Boleta','Factura','Ticket') COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `pago_total` decimal(10,2) DEFAULT NULL,
  `id_tienda` int NOT NULL,
  `fecha_emision` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_cliente` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `doc_cliente` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`num_factura`),
  KEY `fk_factura_tienda1_idx` (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id_inventario` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_compra` int NOT NULL,
  `serie` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT '0',
  `id_estado` int NOT NULL,
  `ubicacion` text COLLATE utf8mb4_spanish_ci,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inventario`,`id_producto`),
  KEY `fk_detalle_producto_producto1_idx` (`id_producto`),
  KEY `fk_inventario_estado1_idx` (`id_estado`),
  KEY `fk_inventario_compra1_idx` (`id_compra`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_clientes`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_clientes`;
CREATE TABLE IF NOT EXISTS `lista_clientes` (
`id_cliente` int
,`tipo_cliente` enum('DNI','RUC')
,`nro_documento` varchar(12)
,`nombre` varchar(90)
,`nro_celular` varchar(15)
,`email` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_compras`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_compras`;
CREATE TABLE IF NOT EXISTS `lista_compras` (
`id_compra` int
,`fecha_hora_registro` varchar(53)
,`nombre_producto` varchar(90)
,`nombre_proveedor` varchar(100)
,`cantidad_compra` smallint unsigned
,`precio_unitario` decimal(10,2)
,`pago_total` decimal(10,2)
,`numero_factura` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_empleados`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_empleados`;
CREATE TABLE IF NOT EXISTS `lista_empleados` (
`id_empleado` int
,`DNI` varchar(12)
,`nombre_completo` varchar(91)
,`cargo` varchar(75)
,`status` tinyint
,`nro_celular` varchar(15)
,`email` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_inventario`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_inventario`;
CREATE TABLE IF NOT EXISTS `lista_inventario` (
`id_inventario` int
,`fecha_hora_registro` varchar(53)
,`nombre_producto` varchar(90)
,`id_compra` int
,`serie` varchar(45)
,`tipo_estado` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_productos`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_productos`;
CREATE TABLE IF NOT EXISTS `lista_productos` (
`id_producto` int
,`imagen` text
,`nombre_producto` varchar(90)
,`modelo` varchar(90)
,`nombre_categoria` varchar(45)
,`status` tinyint(1)
,`precio_unitario` decimal(10,2)
,`stock` smallint unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lista_proveedores`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `lista_proveedores`;
CREATE TABLE IF NOT EXISTS `lista_proveedores` (
`id_proveedor` int
,`tipo_proveedor` enum('DNI','RUC')
,`nro_documento` varchar(15)
,`nombre` varchar(100)
,`nro_celular` varchar(15)
,`email` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

DROP TABLE IF EXISTS `metodo_pago`;
CREATE TABLE IF NOT EXISTS `metodo_pago` (
  `id_metodo_pago` int NOT NULL AUTO_INCREMENT,
  `nombre_metodo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id_metodo_pago`, `nombre_metodo`, `descripcion`) VALUES
(1, 'Efectivo', 'Pago al Contado'),
(2, 'Tarjeta', 'Pgo con Tarjeta de Credito o Debito'),
(3, 'Yape', 'El numero de cuenta es : 915481548');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `modelo` varchar(90) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `imagen` text COLLATE utf8mb4_spanish_ci,
  `status` tinyint(1) NOT NULL,
  `stock` smallint UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `stock_minimo` smallint UNSIGNED DEFAULT NULL,
  `id_categoria_producto` int NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_categoria_producto1_idx` (`id_categoria_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `modelo`, `descripcion`, `imagen`, `status`, `stock`, `precio_unitario`, `stock_minimo`, `id_categoria_producto`) VALUES
(1, 'Laptop HP', '15-dy2059la', 'fsfsd', '730235407.jpg', 1, 2, 2000.00, 200, 1),
(2, 'Laptop HP 4889', '15-eh1509la', 'fafaf', '1559754135.png', 1, 0, 6000.00, 20, 1),
(3, 'Laptop HP 15', '11aaa', '', '653721440.png', 1, 0, 5000.00, 30, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_venta`
--

DROP TABLE IF EXISTS `producto_venta`;
CREATE TABLE IF NOT EXISTS `producto_venta` (
  `id_producto_venta` int NOT NULL,
  `id_inventario` int NOT NULL,
  `id_detalle_venta` int NOT NULL,
  `id_venta` int NOT NULL,
  PRIMARY KEY (`id_producto_venta`,`id_inventario`,`id_detalle_venta`,`id_venta`),
  KEY `fk_inventario_has_detalle_venta_detalle_venta1_idx` (`id_detalle_venta`,`id_venta`),
  KEY `fk_inventario_has_detalle_venta_inventario1_idx` (`id_inventario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `tipo_proveedor` enum('DNI','RUC') COLLATE utf8mb4_spanish_ci NOT NULL,
  `nro_documento` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_contacto` int NOT NULL,
  `departamento` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `registro_proveedor` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `nro_documento_UNIQUE` (`nro_documento`),
  KEY `fk_proveedor_contacto1_idx` (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `tipo_proveedor`, `nro_documento`, `nombre`, `id_contacto`, `departamento`, `registro_proveedor`) VALUES
(1, 'DNI', '87654321', 'JUAN CARLOS GARCIA RAMIREZ', 31, 'LIMA', '2024-03-09 21:13:40'),
(2, 'DNI', '98765432', 'MARIA ANGELICA LOPEZ MARTINEZ', 32, 'AREQUIPA', '2024-03-09 21:13:40'),
(3, 'DNI', '11223344', 'CARLOS ALBERTO RAMIREZ CRUZ', 33, 'CUZCO', '2024-03-09 21:13:40'),
(4, 'RUC', '12345678901', 'TECHSOLUTIONS CORP', 34, 'TACNA', '2024-03-09 21:13:40'),
(5, 'RUC', '10987654321', 'DATA SYSTEMS INC', 35, 'PUNO', '2024-03-09 21:13:40'),
(6, 'RUC', '12345678902', 'SOFTWARETECH S.A.C.', 36, 'ICA', '2024-03-09 21:13:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_has_categoria_producto`
--

DROP TABLE IF EXISTS `proveedor_has_categoria_producto`;
CREATE TABLE IF NOT EXISTS `proveedor_has_categoria_producto` (
  `id_proveedor` int NOT NULL,
  `id_categoria_producto` int NOT NULL,
  PRIMARY KEY (`id_proveedor`,`id_categoria_producto`),
  KEY `fk_proveedor_has_categoria_producto_categoria_producto1_idx` (`id_categoria_producto`),
  KEY `fk_proveedor_has_categoria_producto_proveedor1_idx` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor_has_categoria_producto`
--

INSERT INTO `proveedor_has_categoria_producto` (`id_proveedor`, `id_categoria_producto`) VALUES
(1, 1),
(6, 1),
(5, 2),
(1, 3),
(3, 3),
(4, 3),
(5, 4),
(6, 4),
(1, 5),
(2, 5),
(3, 5),
(6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

DROP TABLE IF EXISTS `tienda`;
CREATE TABLE IF NOT EXISTS `tienda` (
  `id_tienda` int NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruc` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_1` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_2` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_metodo_pago` int NOT NULL,
  `num_factura` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registro_venta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  `pago_total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `fk_venta_empleado1_idx` (`id_empleado`),
  KEY `fk_venta_cliente1_idx` (`id_cliente`),
  KEY `fk_venta_factura1_idx` (`num_factura`),
  KEY `fk_venta_metodo_pago1_idx` (`id_metodo_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_clientes`
--
DROP TABLE IF EXISTS `lista_clientes`;

DROP VIEW IF EXISTS `lista_clientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_clientes`  AS SELECT `cliente`.`id_cliente` AS `id_cliente`, `cliente`.`tipo_cliente` AS `tipo_cliente`, `cliente`.`nro_documento` AS `nro_documento`, `cliente`.`nombre` AS `nombre`, `contacto`.`nro_celular` AS `nro_celular`, `contacto`.`email` AS `email` FROM (`cliente` join `contacto` on((`cliente`.`id_contacto` = `contacto`.`id_contacto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_compras`
--
DROP TABLE IF EXISTS `lista_compras`;

DROP VIEW IF EXISTS `lista_compras`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_compras`  AS SELECT `c`.`id_compra` AS `id_compra`, date_format(`c`.`registro_compra`,'%b %d, %Y, %H:%i') AS `fecha_hora_registro`, `producto`.`nombre_producto` AS `nombre_producto`, `pr`.`nombre` AS `nombre_proveedor`, `c`.`cantidad_compra` AS `cantidad_compra`, `c`.`precio_unitario` AS `precio_unitario`, `c`.`pago_total` AS `pago_total`, `c`.`numero_factura` AS `numero_factura` FROM ((`compra` `c` join `producto` on((`c`.`id_producto` = `producto`.`id_producto`))) join `proveedor` `pr` on((`c`.`id_proveedor` = `pr`.`id_proveedor`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_empleados`
--
DROP TABLE IF EXISTS `lista_empleados`;

DROP VIEW IF EXISTS `lista_empleados`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_empleados`  AS SELECT `empleado`.`id_empleado` AS `id_empleado`, `empleado`.`DNI` AS `DNI`, concat(`empleado`.`nombre`,' ',`empleado`.`apellido`) AS `nombre_completo`, `cargo`.`nombre_cargo` AS `cargo`, `empleado`.`status` AS `status`, `contacto`.`nro_celular` AS `nro_celular`, `contacto`.`email` AS `email` FROM ((`empleado` join `contacto` on((`empleado`.`id_contacto` = `contacto`.`id_contacto`))) join `cargo` on((`empleado`.`id_cargo` = `cargo`.`id_cargo`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_inventario`
--
DROP TABLE IF EXISTS `lista_inventario`;

DROP VIEW IF EXISTS `lista_inventario`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_inventario`  AS SELECT `inventario`.`id_inventario` AS `id_inventario`, date_format(`inventario`.`fecha_registro`,'%b %d, %Y, %H:%i') AS `fecha_hora_registro`, `producto`.`nombre_producto` AS `nombre_producto`, `inventario`.`id_compra` AS `id_compra`, `inventario`.`serie` AS `serie`, `estado`.`tipo_estado` AS `tipo_estado` FROM ((`inventario` join `estado` on((`inventario`.`id_estado` = `estado`.`id_estado`))) join `producto` on((`inventario`.`id_producto` = `producto`.`id_producto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_productos`
--
DROP TABLE IF EXISTS `lista_productos`;

DROP VIEW IF EXISTS `lista_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_productos`  AS SELECT `producto`.`id_producto` AS `id_producto`, `producto`.`imagen` AS `imagen`, `producto`.`nombre_producto` AS `nombre_producto`, `producto`.`modelo` AS `modelo`, `categoria_producto`.`nombre_categoria` AS `nombre_categoria`, `producto`.`status` AS `status`, `producto`.`precio_unitario` AS `precio_unitario`, `producto`.`stock` AS `stock` FROM (`producto` join `categoria_producto` on((`producto`.`id_categoria_producto` = `categoria_producto`.`id_categoria_producto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `lista_proveedores`
--
DROP TABLE IF EXISTS `lista_proveedores`;

DROP VIEW IF EXISTS `lista_proveedores`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lista_proveedores`  AS SELECT `proveedor`.`id_proveedor` AS `id_proveedor`, `proveedor`.`tipo_proveedor` AS `tipo_proveedor`, `proveedor`.`nro_documento` AS `nro_documento`, `proveedor`.`nombre` AS `nombre`, `contacto`.`nro_celular` AS `nro_celular`, `contacto`.`email` AS `email` FROM (`proveedor` join `contacto` on((`proveedor`.`id_contacto` = `contacto`.`id_contacto`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alerta_stock`
--
ALTER TABLE `alerta_stock`
  ADD CONSTRAINT `fk_alerta_stock_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_empleado1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_compra_metodo_pago1` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`),
  ADD CONSTRAINT `fk_compra_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `fk_compra_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `fk_detalle_venta_venta1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_cargo1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  ADD CONSTRAINT `fk_empleado_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_tienda1` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_detalle_producto_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `fk_inventario_compra1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`),
  ADD CONSTRAINT `fk_inventario_estado1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria_producto1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categoria_producto` (`id_categoria_producto`);

--
-- Filtros para la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  ADD CONSTRAINT `fk_inventario_has_detalle_venta_detalle_venta1` FOREIGN KEY (`id_detalle_venta`,`id_venta`) REFERENCES `detalle_venta` (`id_detalle_venta`, `id_venta`),
  ADD CONSTRAINT `fk_inventario_has_detalle_venta_inventario1` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_contacto1` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`);

--
-- Filtros para la tabla `proveedor_has_categoria_producto`
--
ALTER TABLE `proveedor_has_categoria_producto`
  ADD CONSTRAINT `fk_proveedor_has_categoria_producto_categoria_producto1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categoria_producto` (`id_categoria_producto`),
  ADD CONSTRAINT `fk_proveedor_has_categoria_producto_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_cliente1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_venta_empleado1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_venta_factura1` FOREIGN KEY (`num_factura`) REFERENCES `factura` (`num_factura`),
  ADD CONSTRAINT `fk_venta_metodo_pago1` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
