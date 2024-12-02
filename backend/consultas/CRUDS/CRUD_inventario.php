<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // // Datos del empleado
    // $tipo_estado = $_POST['tipo_estado'];
    // $descripcion = $_POST['descripcion'];

    // // Agregar Proveedor en la BD
    // $stmt = $conexion->prepare( " INSERT INTO estado (tipo_estado, descripcion) VALUES ( :tipo_estado, :descripcion) "); 
    
    // $resultado = $stmt->execute(
    //     array(
    //         ':tipo_estado' => $tipo_estado,
    //         ':descripcion' => $descripcion,
    //     ),
    // );

    // if (!empty($resultado)) {
    //     echo 'Registro Creado';
    // }else {
    //     echo 'Error al crear el registro';
    // }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){
    // Datos del empleado
    $serie = $_POST['serie'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $garantia = $_POST['garantia'];
    $id_producto_item = $_POST['id_usuario'];

    if (empty($garantia)) {
        $garantia = null;
    }

    error_log("Datos recibidos: serie = " . $serie . ", ubicacion = " . $ubicacion . ", estado = " . $estado . ", garantia = " . $garantia . ", id_producto_item = " . $id_producto_item);

    $stmt = $conexion->prepare( "UPDATE producto_item SET serie = :serie, ubicacion = :ubicacion, id_estado = :id_estado, garantia = :garantia WHERE id_producto_item = :id_producto_item"); 
    
    $resultado = $stmt->execute(
        array(
            
            ':id_producto_item' => $id_producto_item,
            ':serie' => $serie,
            ':ubicacion' => $ubicacion,
            ':id_estado' => $estado,
            ':garantia' => $garantia,
        )
    );

    if (!empty($resultado)) {

        echo 'Registro Editado';
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){

    $salida = array();

    error_log("Consultando con ID de usuario: " . $_POST["id_usuario"]);


    $stmt = $conexion->prepare("SELECT * FROM vista_inventario  WHERE id_producto_item = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["id_producto_item"] = $fila["id_producto_item"];
        $salida["id_producto"] = $fila["id_producto"];
        $salida["id_compra"] = $fila["id_compra"];
        $salida["fecha_registro"] = $fila["fecha_registro"];
        $salida["nombre_producto"] = $fila["nombre_producto"];
        $salida["serie"] = $fila["serie"];
        $salida["ubicacion"] = $fila["ubicacion"];
        $salida["id_estado"] = $fila["id_estado"];
        $salida["garantia"] = $fila["garantia"];
        $salida["id_venta"] = $fila["id_venta"];
        $salida["cliente"] = $fila["cliente"];
        $salida["dni"] = $fila["dni"];
    }

    error_log("Datos de salida: " . print_r($salida, true));
    error_log("Datos obtenidos y preparados para el JSON.");

    echo json_encode($salida);
}

//  // !BORRAR: ELIMINACION DE LA BD
// if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){

//     // Borrar de la tabla estado
//     $sql_borrar_estado = $conexion->prepare( "DELETE FROM estado WHERE id_estado = '".$_POST["id_usuario"]."' "); 
//     $resultado = $sql_borrar_estado->execute();

//     // Actualizar AUTO_INCREMENT de la tabla estado
//     $sql_increment_estado = $conexion->prepare( "ALTER TABLE estado AUTO_INCREMENT = 1"); 
//     $sql_increment_estado->execute();

//     if (!empty($resultado)) {
//         echo 'Registro Eliminado';
//     }
// }


?>
