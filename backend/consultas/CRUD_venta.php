<?php

include("../config/conexion.php");

// ! AGREGAR: INSERTAMOS UNA NUEVA COMPRA
if ($_POST["operacion"] == "Crear") {

    

    // Variables generales
    $conexion->beginTransaction(); // Inicia una transacción para garantizar consistencia

    try {
        // DATOS DEL COMPROBANTE DE PAGO

        error_log("Operación de crear venta iniciada");


        $id_empleado = $_POST['empleado'];

        $fecha_emision = $_POST['fecha_emision'];
        $tipo_comprobante = $_POST['tipo_comprobante'];
        $serie = $_POST['serie'];
        $correlativo = $_POST['correlativo'];
        $metodo_pago = $_POST['metodo_pago'];

        error_log("Datos del comprobante recibidos: " . print_r($_POST, true));

        // DATOS DEL CLIENTE
        $tipo_documento = $_POST['tipo_documento'];
        $nro_documento = $_POST['nro_documento'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];
        $celular = $_POST['celular'];

         // Log para datos del cliente
         error_log("Datos del cliente recibidos: " . print_r([
            "tipo_documento" => $tipo_documento,
            "nro_documento" => $nro_documento,
            "nombre" => $nombre,
            "direccion" => $direccion,
            "email" => $email,
            "celular" => $celular,
        ], true));

        // DETALLE VENTA
        $detalles_venta = json_decode($_POST['detalles_venta'], true); // Decodificar JSON

        // Usar error_log para depuración
        if ($detalles_venta === null) {
            error_log("Error al decodificar JSON: " . json_last_error_msg()); // Si ocurre un error al decodificar JSON
        } else {
            error_log("Detalles de venta recibidos: " . print_r($detalles_venta, true)); // Mostrar los detalles recibidos
        }

        $total_venta = $_POST['total_input']; // Total enviado desde el frontend

        // 1. Verificar si el cliente existe, si no, crearlo
        $stmt = $conexion->prepare("SELECT id_cliente FROM cliente WHERE nro_documento = ?");
        $stmt->execute([$nro_documento]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            // Cliente no existe, agregarlo
            error_log("El cliente no existe, creando uno nuevo");

            error_log("Enviando datos para agregar cliente:");
            error_log("Tipo de documento: $tipo_documento");
            error_log("Número de documento: $nro_documento");
            error_log("Nombre: $nombre");
            error_log("Email: $email");
            error_log("Celular: $celular");
            error_log("Dirección: $direccion");
            
            // 2. Preparar y ejecutar la consulta para insertar al cliente
            $stmt = $conexion->prepare("CALL agregar_cliente(?, ?, ?, ?, ?, ?, 'PER')");
            if ($stmt === false) {
                error_log("Error al preparar la consulta.");
                exit; // Detener ejecución si hubo error al preparar
            }
            
            $resultado = $stmt->execute([$tipo_documento, $nro_documento, $nombre, $email, $celular, $direccion]);
            
            // 3. Verificar si la ejecución fue exitosa
            if ($resultado) {
                error_log("Cliente insertado exitosamente.");
            } else {
                error_log("Error al insertar cliente.");
                $errorInfo = $stmt->errorInfo(); // Obtener detalles del error
                error_log("Detalles del error: " . print_r($errorInfo, true));
            }
            
            $sqlNextId = $conexion->prepare("SELECT MAX(id_cliente) FROM cliente");
            $sqlNextId->execute();
            $id_cliente = $sqlNextId->fetchColumn();
            error_log("ID del cliente insertado: $id_cliente");
            
            // 5. Verificar el ID del cliente
            if (!$id_cliente) {
                error_log("No se obtuvo el ID del cliente.");
                exit; // Detener ejecución si no se pudo obtener el ID
            } else {
                error_log("Cliente creado con ID: $id_cliente");
            }
        } else {
            $id_cliente = $cliente['id_cliente'];
            error_log("Cliente existente con ID: $id_cliente");
        }

         // 2. Insertar en la tabla `venta`
         error_log("Insertando datos en la tabla venta");

         $stmt = $conexion->prepare("
            INSERT INTO venta (id_empleado, id_cliente, id_metodo_pago, observaciones, pago_total)
            VALUES (?, ?, ?, ?, ?)
            ");
        $stmt->execute([
            $id_empleado, 
            $id_cliente,
            $metodo_pago,
            'Venta registrada desde el sistema', // Observaciones
            $total_venta // Usar el total enviado desde el frontend
            
        ]);
        $id_venta = $conexion->lastInsertId(); // Obtener el ID de la venta creada

        error_log("Venta creada con ID: $id_venta");

        // 3. Insertar en la tabla `detalle_venta`
        foreach ($detalles_venta as $detalle) {
            $producto_info = explode(" - ", $detalle['producto']);
            $id_producto = trim($producto_info[0]); 
            $cantidad = $detalle['cantidad'];
            $precio_unitario = $detalle['precio'];
            $subtotal = $cantidad * $precio_unitario;

            // Log para cada detalle de venta
            error_log("Insertando detalle de venta: Producto ID: $id_producto, Cantidad: $cantidad, Subtotal: $subtotal");

            // Insertar detalle de venta
            $stmt = $conexion->prepare("
                INSERT INTO detalle_venta (id_venta, id_producto, cantidad_ordenada, subtotal)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$id_venta, $id_producto, $cantidad, $subtotal]);
        }

        // 4. Insertar en la tabla `comprobante`
        $impuestos = $total_venta * 0.18; // Suponiendo un 18% de impuestos
        $subtotal = $total_venta - $impuestos;

        error_log("Insertando comprobante: Subtotal: $subtotal, Impuestos: $impuestos, Total: $total_venta");

        $stmt = $conexion->prepare("
            INSERT INTO comprobante (id_venta, tipo_comprobante, serie, numero, fecha_emision, subtotal, impuestos, total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $id_venta,
            $tipo_comprobante,
            $serie,
            $correlativo,
            $fecha_emision,
            $subtotal,
            $impuestos,
            $total_venta
        ]);

        // Confirmar la transacción
        $conexion->commit();

        error_log("Transacción completada exitosamente");

        echo json_encode([
            "status" => "success",
            "message" => "Venta registrada exitosamente.",
            "id_venta" => $id_venta
        ]);
    } catch (Exception $e) {
        // En caso de error, deshacer los cambios
        $conexion->rollBack();
        error_log("Error al registrar la venta: " . $e->getMessage());

        echo json_encode([
            "status" => "error",
            "message" => "Ocurrió un error al registrar la venta: " . $e->getMessage()
        ]);
    }

    

    



    



    // VENTA



    

    
}


// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
// if ($_POST["operacion"] == "Editar") {
//     // Datos de la compra
//     $id_compra = $_POST['id_usuario'];
//     $id_producto = $_POST['producto'];
//     $id_proveedor = $_POST['proveedor'];
//     $id_empleado = $_POST['empleado'];

//     $estado = $_POST['estado'];
//     if($estado == 'on'){
//         $estado = 1;
//     }else{
//         $estado = 0;
//     }

//     $cantidad_compra = $_POST['cantidad_compra'];
//     $precio_unitario = $_POST['precio_unitario'];
//     $factura = $_POST['factura'];
//     $metodo_pago = $_POST['metodo_pago'];
//     $pago_total = $_POST['pago_total'];
//     $descripcion = $_POST['descripcion'];

//     $stmt = $conexion->prepare(" UPDATE compra SET id_producto = :id_producto, id_proveedor = :id_proveedor, estado = :estado, cantidad_compra = :cantidad_compra,
//                                 precio_unitario = :precio_unitario, numero_factura = :numero_factura, id_metodo_pago = :id_metodo_pago, pago_total = :pago_total, descripcion = :descripcion
//                                 WHERE id_compra = '" . $_POST["id_usuario"] . "' ");

//     $resultado = $stmt->execute(
//         array(
//             ':id_producto' => $id_producto,
//             ':id_proveedor' => $id_proveedor,
//             ':estado' => $estado,
//             ':cantidad_compra' => $cantidad_compra,
//             ':precio_unitario' => $precio_unitario,
//             ':numero_factura' => $factura,
//             ':id_metodo_pago' => $metodo_pago,
//             ':pago_total' => $pago_total,
//             ':descripcion' => $descripcion,
//         )
//     );

//     if ($resultado) {
//         echo 'Compra actualizada correctamente';

//         // Si la compra cambió a estado "Disponible" (1), actualizar también los productos en el inventario que están en estado "Anulado" (0)
//         if ($estado == 1) {
//             $stmt_update_inventario = $conexion->prepare("UPDATE producto_item SET id_estado = 1 WHERE id_compra = :id_compra AND id_estado = 4");
//             $stmt_update_inventario->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
//             $resultado_inventario = $stmt_update_inventario->execute();

//             if ($resultado_inventario) {
//                 echo ' y productos anulados en inventario actualizados a "Disponible".';
//             } else {
//                 echo ' pero ocurrió un error al actualizar los productos en inventario.';
//             }
//         }else{
//             // Cambiar el estado de los productos en inventario a "Anulado" solo si están en estado "Disponible" (1)
//             $sql_anular_inventario = $conexion->prepare("UPDATE producto_item SET id_estado = 4 WHERE id_compra = :id_compra AND id_estado = 1");
//             $sql_anular_inventario->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
//             $resultado_inventario = $sql_anular_inventario->execute();

//             // Cambiar el estado de la compra a "Anulado" (estado = 0)
//             $sql_anular_compra = $conexion->prepare("UPDATE compra SET estado = 0 WHERE id_compra = :id_compra");
//             $sql_anular_compra->bindParam(':id_compra', $_POST["id_usuario"], PDO::PARAM_INT);
//             $resultado_compra = $sql_anular_compra->execute();
//         }
//     } else {
//         echo 'Error al actualizar la compra.';
//     }
// }

// // ! VER: TRAEMOS LOS DATOS PARA VISUALIZAR
// if (isset($_POST["id_usuario"]) && ($_POST["operacion"]) == 'actualizar') {
//     $salida = array();
//     $stmt = $conexion->prepare("SELECT * FROM compra WHERE id_compra = '" . $_POST["id_usuario"] . "' LIMIT 1");
//     $stmt->execute();
//     $resultado = $stmt->fetchAll();

//     foreach ($resultado as $fila) {
//         $salida["id_producto"] = $fila["id_producto"];
//         $salida["id_proveedor"] = $fila["id_proveedor"];
//         $salida["descripcion"] = $fila["descripcion"];
//         $salida["estado"] = $fila["estado"];
//         $salida["cantidad_compra"] = $fila["cantidad_compra"];
//         $salida["precio_unitario"] = $fila["precio_unitario"];
//         $salida["pago_total"] = $fila["pago_total"];
//         $salida["metodo_pago"] = $fila["id_metodo_pago"];
//         $salida["factura"] = $fila["numero_factura"];
//     }

//     // Consulta adicional para obtener los números de serie
//     $stmt_series = $conexion->prepare("SELECT serie FROM producto_item WHERE id_compra = :id_compra");
//     $stmt_series->bindParam(':id_compra', $_POST["id_usuario"]);
//     $stmt_series->execute();
//     $series = $stmt_series->fetchAll(PDO::FETCH_COLUMN);

//     // Agregar los números de serie al array de salida
//     $salida["series"] = $series;

//     echo json_encode($salida);
// }


// !BORRAR: ELIMINACION DE LA BD
if (isset($_POST["id_usuario"]) && ($_POST["operacion"]) == 'borrar') {

    $id_venta = $_POST['id_usuario'];  // El ID de la venta a eliminar

    // Iniciar transacción para asegurar que todos los pasos se realicen correctamente
    $conexion->beginTransaction();

    try {
        // Eliminar los registros de detalle_venta_has_producto_item (relación entre detalle_venta y producto_item)
        $stmt = $conexion->prepare("DELETE FROM detalle_venta_has_producto_item WHERE id_detalle_venta IN (SELECT id_detalle_venta FROM detalle_venta WHERE id_venta = :id_venta)");
        $stmt->execute(array(':id_venta' => $id_venta));

        // Eliminar los registros de detalle_venta
        $stmt = $conexion->prepare("DELETE FROM detalle_venta WHERE id_venta = :id_venta");
        $stmt->execute(array(':id_venta' => $id_venta));

        // Actualizar AUTO_INCREMENT de la tabla detalle_venta
        $sql_increment_detalle_venta = $conexion->prepare( "ALTER TABLE detalle_venta AUTO_INCREMENT = 1"); 
        $sql_increment_detalle_venta->execute();

        // Eliminar el registro de la venta
        $stmt = $conexion->prepare("DELETE FROM venta WHERE id_venta = :id_venta");
        $stmt->execute(array(':id_venta' => $id_venta));

        // Eliminar el registro de la venta
        $stmt = $conexion->prepare("DELETE FROM comprobante WHERE id_venta = :id_venta");
        $stmt->execute(array(':id_venta' => $id_venta));

        // Actualizar AUTO_INCREMENT de la tabla detalle_venta
        $sql_increment_venta = $conexion->prepare( "ALTER TABLE venta AUTO_INCREMENT = 1"); 
        $sql_increment_venta->execute();

        $sql_increment_comprobante = $conexion->prepare( "ALTER TABLE comprobante AUTO_INCREMENT = 1"); 
        $sql_increment_comprobante->execute();

        // Confirmar la transacción
        $conexion->commit();
        
        echo 'Venta eliminada exitosamente';
    } catch (Exception $e) {
        // Si ocurre algún error, revertir la transacción
        $conexion->rollBack();
        error_log("Error al eliminar la venta: " . $e->getMessage());
        echo 'Error al eliminar la venta';
    }

}
