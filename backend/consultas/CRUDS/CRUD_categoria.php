<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $nombre_categoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " INSERT INTO categoria_producto (nombre_categoria, descripcion) VALUES ( :nombre_categoria, :descripcion) "); 
    
    $resultado = $stmt->execute(
        array(
            ':nombre_categoria' => $nombre_categoria,
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
    $id_categoria_producto = $_POST['id_usuario'];
    $nombre_categoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare( "UPDATE categoria_producto SET nombre_categoria = :nombre_categoria, descripcion = :descripcion WHERE id_categoria_producto = :id_categoria_producto"); 
    
    $resultado = $stmt->execute(
        array(
            
            ':id_categoria_producto' => $id_categoria_producto,
            ':nombre_categoria' => $nombre_categoria,
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
    $stmt = $conexion->prepare("SELECT * FROM categoria_producto  WHERE id_categoria_producto = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["id_categoria_producto"] = $fila["id_categoria_producto"];
        $salida["nombre_categoria"] = $fila["nombre_categoria"];
        $salida["descripcion"] = $fila["descripcion"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){

    // Borrar de la tabla cliente
    $sql_borrar_categoria = $conexion->prepare( "DELETE FROM categoria_producto WHERE id_categoria_producto = '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_categoria->execute();

    // Actualizar AUTO_INCREMENT de la tabla cliente
    $sql_increment_categoria = $conexion->prepare( "ALTER TABLE categoria_producto AUTO_INCREMENT = 1"); 
    $sql_increment_categoria->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
