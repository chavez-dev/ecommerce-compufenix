-- ===================================================
--          CONSULTAS SQL DE BD_COMPUFENIX
-- ===================================================

-- ===================================================
--                    1. VISTAS
-- ===================================================
-- 1.1 Lista de Empleados
-- 1.2 Lista de Proveedores
-- 1.3 Lista de Clientes
-- 1.4 Lista de Productos
-- 1.5 Lista de Compras
-- 1.6 Lista de Ventas
-- ===================================================

-- 1.1 Lista de Empleados
	DROP VIEW IF EXISTS lista_empleados;
	CREATE VIEW lista_empleados AS
	SELECT id_empleado, DNI , concat(nombre , ' ', apellido) AS nombre_completo, nombre_cargo as cargo, 
    status, nro_celular, email
	FROM empleado 
	INNER JOIN contacto USING (id_contacto)
	INNER JOIN cargo USING (id_cargo);
-- Llamando Vista lista_empleados
	SELECT * FROM lista_empleados;
    
-- ===================================================

-- 1.2 Lista de Proveedores
	DROP VIEW IF EXISTS lista_proveedores;
	CREATE VIEW lista_proveedores AS
	SELECT id_proveedor, tipo_proveedor , nro_documento, nombre, nro_celular, email
	FROM proveedor 
	INNER JOIN contacto USING (id_contacto);
	-- Llamando Vista lista_proveedores
	SELECT * FROM lista_proveedores;

-- ===================================================

-- 1.3 Lista de Clientes
	DROP VIEW IF EXISTS lista_clientes;
	CREATE VIEW lista_clientes AS
	SELECT id_cliente, tipo_cliente, nro_documento, nombre, nro_celular, email
	FROM cliente 
	INNER JOIN contacto USING (id_contacto);
	-- Llamando Vista lista_clientes
	SELECT * FROM lista_clientes;

-- ===================================================

-- 1.4 Lista de Productos
	DROP VIEW IF EXISTS lista_productos;
	CREATE VIEW lista_productos AS
	SELECT id_producto, imagen, nombre_producto, modelo, nombre_categoria, status, precio_unitario , stock
	FROM producto
	INNER JOIN categoria_producto USING (id_categoria_producto);
	-- Llamando Vista lista_productos
	SELECT * FROM lista_productos;
    
    -- ===================================================

-- 1.5 Lista de Compras
	DROP VIEW IF EXISTS lista_compras;
	CREATE VIEW lista_compras AS
	SELECT id_compra, DATE_FORMAT(registro_compra, '%b %d, %Y, %H:%i') AS fecha_hora_registro, pr.nombre AS nombre_proveedor ,
    nombre_producto, c.estado ,cantidad_compra, pago_total, numero_factura
	FROM compra c
	INNER JOIN producto USING (id_producto)
    INNER JOIN proveedor pr USING (id_proveedor);
	-- Llamando Vista lista_productos
	SELECT * FROM lista_compras;
    
-- ===================================================

-- 1.5 Lista de Inventario
	DROP VIEW IF EXISTS lista_producto_item;
	CREATE VIEW lista_producto_item AS
    SELECT id_producto_item, DATE_FORMAT(fecha_registro, '%b %d, %Y, %H:%i') AS fecha_hora_registro ,
    nombre_producto, id_compra, serie, pi.id_estado FROM producto_item pi
	INNER JOIN estado USING (id_estado)
	INNER JOIN producto USING (id_producto);
    -- Llamando Vista lista_inventario
	SELECT * FROM lista_producto_item;
    
-- ===================================================

-- 1.6 Lista de Ventas
	DROP VIEW IF EXISTS lista_ventas;
	CREATE VIEW lista_ventas AS
    SELECT v.id_venta, DATE_FORMAT(registro_venta, '%b %d, %Y, %H:%i') AS fecha_hora_registro ,
    c.nro_documento, c.nombre AS cliente, concat( cpb.serie , "-", cpb.numero ) AS "numero_comprobante", v.pago_total FROM venta v
	INNER JOIN cliente c USING (id_cliente)
    INNER JOIN comprobante cpb USING (id_venta);
    -- Llamando Vista lista_ventas
	SELECT * FROM lista_ventas;

-- ===================================================
--                 2. PROCEDIMIENTOS
-- ===================================================
-- 2.1 Agregar Contacto
-- 2.2 Agregar Empleado
-- 2.3 Editar Empleado
-- 2.3.1 Editar Empleado sin Contraseña
-- 2.4 Agregar Proveedor
-- 2.5 Editar Proveedor
-- 2.6 Agregar Cliente
-- 2.7 Editar Cliente
-- 2.8 Agregar Producto
-- 2.9 Editar Producto
-- 2.10 Agregar Compra
-- 2.11 Agregar Venta
-- ===================================================

-- 2.1 Agregar Contacto
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_contacto//
CREATE PROCEDURE agregar_contacto (
	IN p_email VARCHAR(45),
	IN p_celular VARCHAR(15),
    IN p_direccion VARCHAR(45),
    IN p_nacionalidad CHAR(3)
)
BEGIN
	INSERT INTO contacto ( email, nro_celular, direccion, nacionalidad)
    VALUES (p_email, p_celular, p_direccion, p_nacionalidad);
END // 
DELIMITER ;

-- ===================================================

-- 2.2 Agregar Empleado
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_empleado//
CREATE PROCEDURE agregar_empleado (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.3 Editar Empleado
DELIMITER // 
DROP PROCEDURE IF EXISTS editar_empleado//
CREATE PROCEDURE editar_empleado (
	-- Datos empleado
    IN new_id_empleado INT,
	IN new_DNI VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_apellido VARCHAR(45),
    IN new_estatus TINYINT,
    IN new_password VARCHAR(255),
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
END // 
DELIMITER ;

-- ===================================================
-- 2.3.1 Editar Empleado sin password
DELIMITER //
DROP PROCEDURE IF EXISTS editar_empleado_sin_password//
CREATE PROCEDURE editar_empleado_sin_password (
    -- Datos empleado
    IN new_id_empleado INT,
    IN new_DNI VARCHAR(12),
    IN new_nombre VARCHAR(45),
    IN new_apellido VARCHAR(45),
    IN new_estatus TINYINT,
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
    SELECT e.id_contacto INTO var_id_contacto 
    FROM empleado e
    WHERE id_empleado = new_id_empleado; 

    -- Actualizamos datos de contacto
    UPDATE contacto 
    SET email = new_email, 
        nro_celular = new_celular, 
        direccion = new_direccion, 
        nacionalidad = new_nacionalidad 
    WHERE id_contacto = var_id_contacto;

    -- Actualizamos datos del empleado sin modificar la contraseña
    UPDATE empleado 
    SET DNI = new_DNI, 
        nombre = new_nombre, 
        apellido = new_apellido, 
        status = new_estatus, 
        id_cargo = new_id_cargo, 
        fecha_nacimiento = new_fecha_nacimiento 
    WHERE id_empleado = new_id_empleado;
END //
DELIMITER ;


-- ===================================================

-- 2.4 Agregar Proveedor
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_proveedor//
CREATE PROCEDURE agregar_proveedor (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.5 Editar Proveedor
DELIMITER // 
DROP PROCEDURE IF EXISTS editar_proveedor//
CREATE PROCEDURE editar_proveedor (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.6 Agregar Cliente
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_cliente//
CREATE PROCEDURE agregar_cliente (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.7 Editar Cliente
DELIMITER // 
DROP PROCEDURE IF EXISTS editar_cliente//
CREATE PROCEDURE editar_cliente (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.8 Agregar Producto
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_producto//
CREATE PROCEDURE agregar_producto (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.9 Editar Producto
DELIMITER // 
DROP PROCEDURE IF EXISTS editar_producto//
CREATE PROCEDURE editar_producto (
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
END // 
DELIMITER ;

-- ===================================================

-- 2.10 Agregar Compra
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_compra//
CREATE PROCEDURE agregar_compra (
	-- Datos producto
    IN new_id_producto INT,
    IN new_id_proveedor INT,
    IN new_id_empleado INT,
    IN new_descripcion TEXT,
    IN new_estado TINYINT(1),
    IN new_cantidad_compra SMALLINT UNSIGNED,
    IN new_precio_unitario DECIMAL(10,2),
    IN new_pago_total DECIMAL(10,2),
    IN new_id_metodo_pago INT,
    IN new_numero_factura VARCHAR(20)
)
BEGIN
    -- Agregar una nueva Compra
	INSERT INTO compra (id_producto, id_proveedor, id_empleado, descripcion, estado ,cantidad_compra, precio_unitario, pago_total, 
    id_metodo_pago, numero_factura)
    VALUES (new_id_producto, new_id_proveedor, new_id_empleado, new_descripcion, new_estado, new_cantidad_compra, new_precio_unitario ,new_pago_total, 
    new_id_metodo_pago, new_numero_factura);
END // 
DELIMITER ;

-- ===================================================

-- 2.11 Agregar Venta
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_venta//
CREATE PROCEDURE agregar_venta (
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
END // 
DELIMITER ;

 CALL agregar_venta(1, 1, 1, 'Todo Correcto' );

-- ===================================================

-- 2.11 Agregar Detalle_Venta
DELIMITER // 
DROP PROCEDURE IF EXISTS agregar_detalle_venta//
CREATE PROCEDURE agregar_detalle_venta (
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
END // 
DELIMITER ;

CALL agregar_detalle_venta(1,1,1,3500);

-- ===================================================
--                 3. TRIGGERS
-- ===================================================
-- 3.1 Trigger para aumentar el stock del producto al agregar una compra
-- 3.2 Trigger para actualizar el stock del Producto al editar una compra
-- 3.3 Trigger para actualizar el stock del Producto al borrar una compra
-- 3.4 Trigger para mandar alerta si el stock se encuentra por debajo de un limite establecido.
-- 3.5 Trigger para actualizar el stock del Producto al realizar un detalle_venta
-- 3.6 Trigger para actualizar el stock del Producto al editar un detalle_venta
-- 3.7 Trigger para actualizar el stock del Producto al borrar una detalle_venta

-- ===================================================


-- ===================================================
-- 3.1 Trigger para aumentar el stock del producto al agregar una compra
DELIMITER //
DROP TRIGGER IF EXISTS trigger_aumentar_stock_producto//
CREATE TRIGGER trigger_aumentar_stock_producto
AFTER INSERT ON compra
FOR EACH ROW
BEGIN
	IF NEW.cantidad_compra > 0 THEN
		UPDATE producto
		SET stock = stock + NEW.cantidad_compra
		WHERE id_producto = NEW.id_producto;
	END IF;
END //
DELIMITER ;

-- ===================================================

-- 3.2 Trigger para actualizar el stock del Producto al editar una compra
DELIMITER //
DROP TRIGGER IF EXISTS trigger_actualizar_stock_producto //
CREATE TRIGGER trigger_actualizar_stock_producto
AFTER UPDATE ON compra
FOR EACH ROW
BEGIN
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
// 
DELIMITER ;

-- ===================================================

-- 3.3 Trigger para actualizar el stock del Producto al borrar una compra
DELIMITER //
DROP TRIGGER IF EXISTS trigger_borrar_stock_producto //
CREATE TRIGGER trigger_borrar_stock_producto
AFTER DELETE ON compra
FOR EACH ROW
BEGIN
	-- Actualizamos el mismo producto con la nueva cantidad_compra
	UPDATE producto
	SET stock = stock - OLD.cantidad_compra
	WHERE id_producto = OLD.id_producto;
    
END
// 
DELIMITER ;

-- SELECT MAX(id_compra) FROM compra;


-- 3.4 Trigger para mandar alerta si el stock se encuentra por debajo de un limite establecido.
DELIMITER $$
DROP TRIGGER IF EXISTS alerta_stock_minimo$$
CREATE TRIGGER alerta_stock_minimo
AFTER UPDATE ON producto FOR EACH ROW 
BEGIN
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
END;
$$

-- ===================================================

-- 3.5 Trigger para actualizar el stock del Producto al realizar una venta
DELIMITER //
DROP TRIGGER IF EXISTS trigger_disminuir_stock_producto//
CREATE TRIGGER trigger_disminuir_stock_producto
AFTER INSERT ON detalle_venta
FOR EACH ROW
BEGIN
	IF NEW.cantidad_ordenada > 0 THEN
		UPDATE producto
		SET stock = stock - NEW.cantidad_ordenada
		WHERE id_producto = NEW.id_producto;
        UPDATE venta
        SET pago_total = pago_total + NEW.subtotal
        WHERE id_venta = NEW.id_venta;
	END IF;
END //
DELIMITER ;

-- ===================================================

-- 3.6 Trigger para actualizar el stock del Producto al editar un detalle_venta
DELIMITER //
DROP TRIGGER IF EXISTS trigger_actualizar_stock_producto //
CREATE TRIGGER trigger_actualizar_stock_producto
AFTER UPDATE ON detalle_venta
FOR EACH ROW
BEGIN
	IF NEW.id_producto <> OLD.id_producto THEN
		-- Restamos la cantidad al producto anterior
		UPDATE producto
        SET stock = stock + OLD.cantidad_ordenada
        WHERE id_producto = OLD.id_producto;
        UPDATE venta
        SET pago_total = pago_total - OLD.subtotal
        WHERE id_venta = OLD.id_venta;
        -- Aumentamos la cantidad al nuevo producto
        UPDATE producto
        SET stock = stock - NEW.cantidad_ordenada
        WHERE id_producto = NEW.id_producto;
        UPDATE venta
        SET pago_total = pago_total + NEW.subtotal
        WHERE id_venta = NEW.id_venta;
	ELSE 
		-- Actualizamos el mismo producto con la nueva cantidad_compra
		UPDATE producto
        SET stock = stock + OLD.cantidad_ordenada - NEW.cantidad_ordenada
        WHERE id_producto = NEW.id_producto;
        UPDATE venta
        SET pago_total = pago_total - OLD.subtotal + NEW.subtotal
        WHERE id_venta = NEW.id_venta;
    END IF;
END
// 
DELIMITER ;

-- ===================================================
-- 3.7 Trigger para actualizar el stock del Producto al borrar un detalle_venta
DELIMITER //
DROP TRIGGER IF EXISTS trigger_borrar_stock_producto //
CREATE TRIGGER trigger_borrar_stock_producto
AFTER DELETE ON detalle_venta
FOR EACH ROW
BEGIN
	-- Actualizamos el mismo producto con la nueva cantidad_compra
	UPDATE producto
	SET stock = stock + OLD.cantidad_ordenada
	WHERE id_producto = OLD.id_producto;
    UPDATE venta
	SET pago_total = pago_total - OLD.subtotal
	WHERE id_venta = OLD.id_venta;
END
// 
DELIMITER ;









-- ================================================================================================================================================================================
-- ERRORES


-- 22/08



