<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $tipo_serie = $_POST['tipo_serie'];
    $serie = $_POST['serie'];
    $numero_inicio = $_POST['correlativo'];
    $correlativo = $_POST['correlativo'];
    $estado = $_POST['estado'];
    $estado = ($estado == 'on') ? 1 : 0;

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " INSERT INTO serie (tipo_serie, serie, numero_inicio, correlativo, estado) VALUES ( :tipo_serie, :serie, :numero_inicio, :correlativo, :estado) "); 
    
    $resultado = $stmt->execute(
        array(
            ':tipo_serie' => $tipo_serie,
            ':serie' => $serie,
            ':numero_inicio' => $numero_inicio,
            ':correlativo' => $correlativo,
            ':estado' => $estado,
        ),
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }else {
        echo 'Error al crear el registro';
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if ($_POST["operacion"] == "Editar") {
    // Datos del empleado
    $id_serie = $_POST["id_usuario"];
    $tipo_serie = $_POST['tipo_serie'];
    $serie = $_POST['serie'];
    $numero_inicio = $_POST['correlativo'];
    $correlativo = $_POST['correlativo'];
    $estado = $_POST['estado'];
    $estado = ($estado == 'on') ? 1 : 0;

    // Log de depuración
    error_log("Datos recibidos:");
    error_log("id_serie: " . $id_serie);
    error_log("tipo_serie: " . $tipo_serie);
    error_log("serie: " . $serie);
    error_log("numero_inicio: " . $numero_inicio);
    error_log("correlativo: " . $correlativo);
    error_log("estado: " . $estado);

    $stmt = $conexion->prepare(
        "UPDATE serie SET tipo_serie = :tipo_serie, serie = :serie, numero_inicio = :numero_inicio, correlativo = :correlativo, estado = :estado WHERE id = :id_serie"
    );

    $resultado = $stmt->execute(
        array(
            ':id_serie' => $id_serie,
            ':tipo_serie' => $tipo_serie,
            ':serie' => $serie,
            ':numero_inicio' => $numero_inicio,
            ':correlativo' => $correlativo,
            ':estado' => $estado,
        )
    );

    // Log de depuración del resultado de la consulta
    if ($resultado) {
        error_log("Consulta ejecutada con éxito.");
        echo 'Registro Editado';
    } else {
        error_log("Error en la ejecución de la consulta: " . implode(", ", $stmt->errorInfo()));
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM serie  WHERE id = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["tipo_serie"] = $fila["tipo_serie"];
        $salida["serie"] = $fila["serie"];
        $salida["correlativo"] = $fila["correlativo"];
        $salida["estado"] = $fila["estado"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){

    // Borrar de la tabla cliente
    $sql_borrar_serie = $conexion->prepare( "DELETE FROM serie WHERE id= '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_serie->execute();

    // Actualizar AUTO_INCREMENT de la tabla cliente
    $sql_increment_serie = $conexion->prepare( "ALTER TABLE serie AUTO_INCREMENT = 1"); 
    $sql_increment_serie->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
