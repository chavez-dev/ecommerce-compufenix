<?php

include("../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $tipo_estado = $_POST['tipo_estado'];
    $descripcion = $_POST['descripcion'];

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " INSERT INTO estado (tipo_estado, descripcion) VALUES ( :tipo_estado, :descripcion) "); 
    
    $resultado = $stmt->execute(
        array(
            ':tipo_estado' => $tipo_estado,
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
    $id_estado = $_POST['id_usuario'];
    $tipo_estado = $_POST['tipo_estado'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare( "UPDATE estado SET tipo_estado = :tipo_estado, descripcion = :descripcion WHERE id_estado = :id_estado"); 
    
    $resultado = $stmt->execute(
        array(
            
            ':id_estado' => $id_estado,
            ':tipo_estado' => $tipo_estado,
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
    $stmt = $conexion->prepare("SELECT * FROM estado  WHERE id_estado = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["id_estado"] = $fila["id_estado"];
        $salida["tipo_estado"] = $fila["tipo_estado"];
        $salida["descripcion"] = $fila["descripcion"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){

    // Borrar de la tabla estado
    $sql_borrar_estado = $conexion->prepare( "DELETE FROM estado WHERE id_estado = '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_estado->execute();

    // Actualizar AUTO_INCREMENT de la tabla estado
    $sql_increment_estado = $conexion->prepare( "ALTER TABLE estado AUTO_INCREMENT = 1"); 
    $sql_increment_estado->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
