<?php

include("../config/conexion.php");

// ! AGREGAR: INSERTAMOS UNA NUEVA COMPRA
if ($_POST["operacion"] == "Crear") {

    // Datos del empleado
    $id_producto = $_POST['producto'];
    $id_proveedor = $_POST['proveedor'];
    $id_empleado = $_POST['empleado'];
    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_unitario = $_POST['precio_unitario'];
    $factura = $_POST['factura'];
    $metodo_pago = $_POST['metodo_pago'];
    $pago_total = $_POST['pago_total'];
    $descripcion = $_POST['descripcion'];


    $stmt = $conexion->prepare(" CALL agregar_compra ( :id_producto, :id_proveedor, :id_empleado, :descripcion, :cantidad_compra, :precio_unitario, :pago_total, 
    :id_metodo_pago, :numero_factura)");

    $resultado = $stmt->execute(
        array(
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':id_empleado' => $id_empleado,
            ':descripcion' => $descripcion,
            ':cantidad_compra' => $cantidad_compra,
            ':precio_unitario' => $precio_unitario,
            ':pago_total' => $pago_total,
            ':id_metodo_pago' => $metodo_pago,
            ':numero_factura' => $factura,
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }

    $sqlNextId = $conexion->prepare("SELECT MAX(id_compra) FROM compra");
    $sqlNextId->execute();
    $id_compra = $sqlNextId->fetchColumn();

    // Recorrer los campos de serie
    for ($i = 1; $i <= $cantidad_compra; $i++) {
        $nombre_campo = 'serie' . $i;
        // Verificar si el campo existe
        if (isset($_POST[$nombre_campo])) {
            // B

            // Agregar el valor al array
            $valor_serie = $_POST[$nombre_campo];
            $sql_inventario = $conexion->prepare("INSERT INTO producto_item (id_producto, id_compra, serie, id_estado) 
                                                    VALUES ( :id_producto, :id_compra, :serie, :id_estado ) ");
            $sql_inventario->execute(
                array(
                    ':id_producto' => $id_producto,
                    ':id_compra' => $id_compra ,
                    ':serie' => $valor_serie,
                    ':id_estado' => 1,
                )
            );
        }
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if ($_POST["operacion"] == "Editar") {
    // Datos de la compra
    $id_compra = $_POST['id_usuario'];
    $id_producto = $_POST['producto'];
    $id_proveedor = $_POST['proveedor'];
    $id_empleado = $_POST['empleado'];
    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_unitario = $_POST['precio_unitario'];
    $factura = $_POST['factura'];
    $metodo_pago = $_POST['metodo_pago'];
    $pago_total = $_POST['pago_total'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare(" UPDATE compra SET id_producto = :id_producto, id_proveedor = :id_proveedor, cantidad_compra = :cantidad_compra,
                                precio_unitario = :precio_unitario, numero_factura = :numero_factura, id_metodo_pago = :id_metodo_pago, pago_total = :pago_total, descripcion = :descripcion
                                WHERE id_compra = '" . $_POST["id_usuario"] . "' ");

    $resultado = $stmt->execute(
        array(
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':cantidad_compra' => $cantidad_compra,
            ':precio_unitario' => $precio_unitario,
            ':numero_factura' => $factura,
            ':id_metodo_pago' => $metodo_pago,
            ':pago_total' => $pago_total,
            ':descripcion' => $descripcion,
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }
}

// ! VER: TRAEMOS LOS DATOS PARA VISUALIZAR
if (isset($_POST["id_usuario"]) && ($_POST["operacion"]) == 'actualizar') {
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM compra WHERE id_compra = '" . $_POST["id_usuario"] . "' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach ($resultado as $fila) {
        $salida["id_producto"] = $fila["id_producto"];
        $salida["id_proveedor"] = $fila["id_proveedor"];
        $salida["descripcion"] = $fila["descripcion"];
        $salida["cantidad_compra"] = $fila["cantidad_compra"];
        $salida["precio_unitario"] = $fila["precio_unitario"];
        $salida["pago_total"] = $fila["pago_total"];
        $salida["metodo_pago"] = $fila["id_metodo_pago"];
        $salida["factura"] = $fila["numero_factura"];
    }

    // Consulta adicional para obtener los números de serie
    $stmt_series = $conexion->prepare("SELECT serie FROM producto_item WHERE id_compra = :id_compra");
    $stmt_series->bindParam(':id_compra', $_POST["id_usuario"]);
    $stmt_series->execute();
    $series = $stmt_series->fetchAll(PDO::FETCH_COLUMN);

    // Agregar los números de serie al array de salida
    $salida["series"] = $series;

    echo json_encode($salida);
}


// !BORRAR: ELIMINACION DE LA BD
if (isset($_POST["id_usuario"]) && ($_POST["operacion"]) == 'borrar') {

    // Borrar de la tabla empleado
    $sql_borrar_inventario = $conexion->prepare("DELETE FROM producto_item WHERE id_compra = '" . $_POST["id_usuario"] . "' ");
    $resultado = $sql_borrar_inventario->execute();

    $sql_borrar_empleado = $conexion->prepare("DELETE FROM compra WHERE id_compra = '" . $_POST["id_usuario"] . "' ");
    $resultado = $sql_borrar_empleado->execute();


    // Actualizar AUTO_INCREMENT de la tabla compra
    $sql_increment_compra = $conexion->prepare("ALTER TABLE compra AUTO_INCREMENT = 1");
    $sql_increment_compra->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}
