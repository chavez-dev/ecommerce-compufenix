<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $tipo_documento = $_POST['tipo_documento'];
    $nro_documento = $_POST['nro_documento'];
    $nombre = strtoupper($_POST['nombre']);
    
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $nacionalidad = $_POST['nacionalidad']; 

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " CALL agregar_cliente ( :tipo_proveedor, :nro_documento, :nombre,
    :email, :celular, :direccion, :nacionalidad)"); 
    
    $resultado = $stmt->execute(
        array(
            ':tipo_proveedor' => $tipo_documento,
            ':nro_documento' => $nro_documento,
            ':nombre' => $nombre,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad,
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }else {
        echo 'Error al crear el registro';
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){
    // Datos del proveedor
    $tipo_documento = $_POST['tipo_documento'];
    $nro_documento = $_POST['nro_documento'];
    $nombre = strtoupper($_POST['nombre']);
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad'];

    // Empleado
    $codigo_cliente = $_POST['id_usuario'];

    $stmt = $conexion->prepare( " CALL editar_cliente ( :id_cliente, :tipo_cliente, :nro_documento, :nombre,
    :email, :celular, :direccion, :nacionalidad)"); 
    
    $resultado = $stmt->execute(
        array(
            ':id_cliente' => $codigo_cliente,
            ':tipo_cliente' => $tipo_documento,
            ':nro_documento' => $nro_documento,
            ':nombre' => $nombre,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad,
        )
    );

    if (!empty($resultado)) {

        echo 'Registro Editado';
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM cliente cl INNER JOIN contacto c ON cl.id_contacto=c.id_contacto WHERE id_cliente = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["id_cliente"] = $fila["id_cliente"];
        $salida["tipo_cliente"] = $fila["tipo_cliente"];
        $salida["nro_documento"] = $fila["nro_documento"];
        $salida["nombre"] = $fila["nombre"];
        $salida["nacionalidad"] = $fila["nacionalidad"];
        $salida["email"] = $fila["email"];
        $salida["celular"] = $fila["nro_celular"];
        $salida["direccion"] = $fila["direccion"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){
    
    $sql_id_contacto = $conexion->prepare("SELECT id_contacto FROM cliente WHERE id_cliente = '".$_POST["id_usuario"]."' LIMIT 1 ");
    $sql_id_contacto->execute();
    $id_contacto = $sql_id_contacto->fetchColumn();
    
    // Borrar de la tabla cliente
    $sql_borrar_cliente = $conexion->prepare( "DELETE FROM cliente WHERE id_cliente = '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_cliente->execute();

    // Borrar de la tabla contacto
    $sql_borrar_contacto = $conexion->prepare( "DELETE FROM contacto WHERE id_contacto = '".$id_contacto."' "); 
    $sql_borrar_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla contacto
    $sql_increment_contacto = $conexion->prepare( "ALTER TABLE contacto AUTO_INCREMENT = 1"); 
    $sql_increment_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla cliente
    $sql_increment_cliente = $conexion->prepare( "ALTER TABLE cliente AUTO_INCREMENT = 1"); 
    $sql_increment_cliente->execute();


    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
