<?php

include("../config/conexion.php");

// ! AGREGAR: INSERTAMOS UNA NUEVA COMPRA
if ($_POST["operacion"] == "Crear") {

    // Datos del empleado
    $id_producto = $_POST['producto'];
    $id_proveedor = $_POST['proveedor'];
    $id_empleado = $_POST['empleado'];
    
    $estado = $_POST['estado'];
    if($estado == 'on'){
        $estado = 1;
    }else{
        $estado = 0;
    }

    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_unitario = $_POST['precio_unitario'];
    $factura = $_POST['factura'];
    $metodo_pago = $_POST['metodo_pago'];
    $pago_total = $_POST['pago_total'];
    $descripcion = $_POST['descripcion'];

    // Registrar en error.log para ver los datos recibidos
    error_log("Datos recibidos: producto=$id_producto, proveedor=$id_proveedor, empleado=$id_empleado, estado=$estado,cantidad=$cantidad_compra, precio=$precio_unitario, factura=$factura, metodo_pago=$metodo_pago, total=$pago_total, descripcion=$descripcion");

    $stmt = $conexion->prepare("CALL agregar_compra(:id_producto, :id_proveedor, :id_empleado, :descripcion, :estado, :cantidad_compra, :precio_unitario, :pago_total, :id_metodo_pago, :numero_factura)");

    // Ejecutar y registrar el resultado
    $resultado = $stmt->execute(
        array(
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':id_empleado' => $id_empleado,
            ':descripcion' => $descripcion,
            ':estado' => $estado,
            ':cantidad_compra' => $cantidad_compra,
            ':precio_unitario' => $precio_unitario,
            ':pago_total' => $pago_total,
            ':id_metodo_pago' => $metodo_pago,
            ':numero_factura' => $factura,
        )
    );

    // Verificar si la ejecución fue exitosa y registrar el resultado
    if ($resultado) {
        error_log("Registro de compra creado exitosamente.");
        echo 'Registro Creado';
    } else {
        $errorInfo = $stmt->errorInfo();
        error_log("Error al ejecutar la consulta: {$errorInfo[2]}");
    }

    // Obtener el ID de la compra recién creada
    $sqlNextId = $conexion->prepare("SELECT MAX(id_compra) FROM compra");
    $sqlNextId->execute();
    $id_compra = $sqlNextId->fetchColumn();
    error_log("ID de compra creado: $id_compra");

    // Recorrer los campos de serie
    for ($i = 1; $i <= $cantidad_compra; $i++) {
        $nombre_campo = 'serie' . $i;
        // Verificar si el campo existe
        if (isset($_POST[$nombre_campo])) {
            $valor_serie = $_POST[$nombre_campo];
            error_log("Procesando serie $i: $valor_serie");

            // Insertar en producto_item
            $sql_inventario = $conexion->prepare("INSERT INTO producto_item (id_producto, id_compra, serie, id_estado) VALUES (:id_producto, :id_compra, :serie, :id_estado)");
            $sql_inventario->execute(
                array(
                    ':id_producto' => $id_producto,
                    ':id_compra' => $id_compra,
                    ':serie' => $valor_serie,
                    ':id_estado' => 1,
                )
            );

            // Verificar si la ejecución fue exitosa y registrar el resultado
            if ($sql_inventario->rowCount() > 0) {
                error_log("Serie $valor_serie registrada correctamente en producto_item.");
            } else {
                $errorInfo = $sql_inventario->errorInfo();
                error_log("Error al registrar la serie $valor_serie: {$errorInfo[2]}");
            }
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

    $estado = $_POST['estado'];
    if($estado == 'on'){
        $estado = 1;
    }else{
        $estado = 0;
    }

    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_unitario = $_POST['precio_unitario'];
    $factura = $_POST['factura'];
    $metodo_pago = $_POST['metodo_pago'];
    $pago_total = $_POST['pago_total'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare(" UPDATE compra SET id_producto = :id_producto, id_proveedor = :id_proveedor, estado = :estado, cantidad_compra = :cantidad_compra,
                                precio_unitario = :precio_unitario, numero_factura = :numero_factura, id_metodo_pago = :id_metodo_pago, pago_total = :pago_total, descripcion = :descripcion
                                WHERE id_compra = '" . $_POST["id_usuario"] . "' ");

    $resultado = $stmt->execute(
        array(
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':estado' => $estado,
            ':cantidad_compra' => $cantidad_compra,
            ':precio_unitario' => $precio_unitario,
            ':numero_factura' => $factura,
            ':id_metodo_pago' => $metodo_pago,
            ':pago_total' => $pago_total,
            ':descripcion' => $descripcion,
        )
    );

    if ($resultado) {
        echo 'Compra actualizada correctamente';

        // Si la compra cambió a estado "Disponible" (1), actualizar también los productos en el inventario que están en estado "Anulado" (0)
        if ($estado == 1) {
            $stmt_update_inventario = $conexion->prepare("UPDATE producto_item SET id_estado = 1 WHERE id_compra = :id_compra AND id_estado = 4");
            $stmt_update_inventario->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
            $resultado_inventario = $stmt_update_inventario->execute();

            if ($resultado_inventario) {
                echo ' y productos anulados en inventario actualizados a "Disponible".';
            } else {
                echo ' pero ocurrió un error al actualizar los productos en inventario.';
            }
        }else{
            // Cambiar el estado de los productos en inventario a "Anulado" solo si están en estado "Disponible" (1)
            $sql_anular_inventario = $conexion->prepare("UPDATE producto_item SET id_estado = 4 WHERE id_compra = :id_compra AND id_estado = 1");
            $sql_anular_inventario->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
            $resultado_inventario = $sql_anular_inventario->execute();

            // Cambiar el estado de la compra a "Anulado" (estado = 0)
            $sql_anular_compra = $conexion->prepare("UPDATE compra SET estado = 0 WHERE id_compra = :id_compra");
            $sql_anular_compra->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
            $resultado_compra = $sql_anular_compra->execute();
        }
    } else {
        echo 'Error al actualizar la compra.';
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
        $salida["estado"] = $fila["estado"];
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

    // Cambiar el estado de los productos en inventario a "Anulado" solo si están en estado "Disponible" (1)
    $sql_anular_inventario = $conexion->prepare("UPDATE producto_item SET id_estado = 4 WHERE id_compra = :id_compra AND id_estado = 1");
    $sql_anular_inventario->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
    $resultado_inventario = $sql_anular_inventario->execute();

    if ($resultado_inventario) {
        // Cambiar el estado de la compra a "Anulado" (estado = 0)
        $sql_anular_compra = $conexion->prepare("UPDATE compra SET estado = 0 WHERE id_compra = :id_compra");
        $sql_anular_compra->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
        $resultado_compra = $sql_anular_compra->execute();

        if ($resultado_compra) {
            echo 'Compra y productos disponibles en inventario anulados correctamente.';
        } else {
            echo 'Error al anular la compra.';
        }
    } else {
        echo 'Error al actualizar el estado de los productos en el inventario.';
    }

}
