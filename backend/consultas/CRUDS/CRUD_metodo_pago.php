<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $nombre_metodo = $_POST['nombre_metodo'];
    $descripcion = $_POST['descripcion'];

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " INSERT INTO metodo_pago (nombre_metodo, descripcion) VALUES ( :nombre_metodo, :descripcion) "); 
    
    $resultado = $stmt->execute(
        array(
            ':nombre_metodo' => $nombre_metodo,
            ':descripcion' => $descripcion,
        ),
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }else {
        echo 'Error al crear el registro';
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){
    // Datos del empleado
    $id_metodo_pago = $_POST['id_usuario'];
    $nombre_metodo = $_POST['nombre_metodo'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare( "UPDATE metodo_pago SET nombre_metodo = :nombre_metodo, descripcion = :descripcion WHERE id_metodo_pago = :id_metodo_pago"); 
    
    $resultado = $stmt->execute(
        array(
            
            ':id_metodo_pago' => $id_metodo_pago,
            ':nombre_metodo' => $nombre_metodo,
            ':descripcion' => $descripcion,
        )
    );

    if (!empty($resultado)) {

        echo 'Registro Editado';
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM metodo_pago  WHERE id_metodo_pago = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["id_metodo_pago"] = $fila["id_metodo_pago"];
        $salida["nombre_metodo"] = $fila["nombre_metodo"];
        $salida["descripcion"] = $fila["descripcion"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){

    // Borrar de la tabla cliente
    $sql_borrar_metodo = $conexion->prepare( "DELETE FROM metodo_pago WHERE id_metodo_pago= '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_metodo->execute();

    // Actualizar AUTO_INCREMENT de la tabla cliente
    $sql_increment_metodo = $conexion->prepare( "ALTER TABLE metodo_pago AUTO_INCREMENT = 1"); 
    $sql_increment_metodo->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
