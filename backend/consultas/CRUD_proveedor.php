<?php

include("../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $tipo_documento = $_POST['tipo_documento'];
    $nro_documento = $_POST['nro_documento'];
    $nombre = strtoupper($_POST['nombre']);
    $departamento = $_POST['departamento'];
    
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad']; 
    

    // Agregar Proveedor en la BD
    $stmt = $conexion->prepare( " CALL agregar_proveedor ( :tipo_proveedor, :nro_documento, :nombre, :departamento,
    :email, :celular, :direccion, :nacionalidad)"); 
    
    $resultado = $stmt->execute(
        array(
            ':tipo_proveedor' => $tipo_documento,
            ':nro_documento' => $nro_documento,
            ':nombre' => $nombre,
            ':departamento' => $departamento,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad,
        )
    );

    if (!empty($resultado)) {

        // Insertamos las Categorias Seleccionadas en el modal
        $sqlNextId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'proveedor'";
        $stmtNextId = $conexion->query($sqlNextId);
        $id_proveedor = ($stmtNextId->fetchColumn())-1;

        // Iterar sobre las categorías
        $sql7 = "SELECT id_categoria_producto, nombre_categoria FROM categoria_producto";
        $stmt7 = $conexion->query($sql7);

        while ($fila7 = $stmt7->fetch(PDO::FETCH_ASSOC)) {
            $nombreCategoria = $fila7['nombre_categoria'];

            // Verificar si el checkbox está marcado
            if (isset($_POST[$nombreCategoria])) {
                // El checkbox está marcado, registrar en proveedor_has_categoria_producto
                $id_categoria = $fila7['id_categoria_producto'];
                $sqlInsert = "INSERT INTO proveedor_has_categoria_producto (id_proveedor, id_categoria_producto) VALUES (:id_proveedor, :id_categoria_producto)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $stmtInsert->bindParam(':id_proveedor', $id_proveedor);
                $stmtInsert->bindParam(':id_categoria_producto', $id_categoria);
                $stmtInsert->execute();
            }
        }

        echo 'Registro Creado. ID del proveedor: ' . $id_proveedor;

    }else {
        echo 'Error al crear el registro';
        error_log("Error al insertar proveedor en la BD.", 3, "ruta_de_tu_log/errores.log");
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){
    // Datos del proveedor
    $tipo_documento = $_POST['tipo_documento'];
    $nro_documento = $_POST['nro_documento'];
    $departamento = $_POST['departamento'];
    $nombre = strtoupper($_POST['nombre']);
    $departamento = $_POST['departamento'];
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad'];

    // Empleado
    $codigo_proveedor = $_POST['id_usuario'];

    $stmt = $conexion->prepare( " CALL editar_proveedor ( :id_proveedor, :tipo_proveedor, :nro_documento, :nombre, :departamento,
    :email, :celular, :direccion, :nacionalidad)"); 
    
    $resultado = $stmt->execute(
        array(
            ':id_proveedor' => $codigo_proveedor,
            ':tipo_proveedor' => $tipo_documento,
            ':nro_documento' => $nro_documento,
            ':nombre' => $nombre,
            ':departamento' => $departamento,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad,
        )
    );

    if (!empty($resultado)) {
        
        // Eliminar todas las categorías asociadas al proveedor
        $sqlDelete = "DELETE FROM proveedor_has_categoria_producto WHERE id_proveedor = :id_proveedor";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bindParam(':id_proveedor', $codigo_proveedor);
        $stmtDelete->execute();

        // Iterar sobre las categorías
        $sql7 = "SELECT id_categoria_producto, nombre_categoria FROM categoria_producto";
        $stmt7 = $conexion->query($sql7);

        while ($fila7 = $stmt7->fetch(PDO::FETCH_ASSOC)) {
            $nombreCategoria = $fila7['nombre_categoria'];

            // Verificar si el checkbox está marcado
            if (isset($_POST[$nombreCategoria])) {
                // El checkbox está marcado, registrar en proveedor_has_categoria_producto
                $id_categoria = $fila7['id_categoria_producto'];

                // Verificar si ya existe una entrada para este proveedor y categoría
                $sqlInsert = "INSERT INTO proveedor_has_categoria_producto (id_proveedor, id_categoria_producto) VALUES (:id_proveedor, :id_categoria_producto)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $stmtInsert->bindParam(':id_proveedor', $codigo_proveedor);
                $stmtInsert->bindParam(':id_categoria_producto', $id_categoria);
                $stmtInsert->execute();
            }
        }

        echo 'Registro Creado. ID del proveedor: ' . $id_proveedor;
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM proveedor p INNER JOIN contacto c ON p.id_contacto=c.id_contacto WHERE id_proveedor = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    $stmt10 = $conexion->prepare("SELECT id_proveedor, id_categoria_producto, nombre_categoria
        FROM proveedor_has_categoria_producto p
        INNER JOIN categoria_producto USING (id_categoria_producto)
        WHERE id_proveedor = '".$_POST["id_usuario"]."' ");
    $stmt10->execute();
    $resultado10 = $stmt10->fetchAll();

    foreach($resultado as $fila){
        $salida["id_proveedor"] = $fila["id_proveedor"];
        $salida["tipo_proveedor"] = $fila["tipo_proveedor"];
        $salida["nro_documento"] = $fila["nro_documento"];
        $salida["nombre"] = $fila["nombre"];
        $salida["departamento"] = $fila["departamento"];
        $salida["nacionalidad"] = $fila["nacionalidad"];
        $salida["email"] = $fila["email"];
        $salida["celular"] = $fila["nro_celular"];
        $salida["direccion"] = $fila["direccion"];

        $categorias = array(); // Array para guardar los nombres de las categorías seleccionadas

        foreach($resultado10 as $fila10){
            // Comprobamos si la categoría pertenece al proveedor actual
            if($fila["id_proveedor"] == $fila10["id_proveedor"]) {
                // Agregamos el nombre de la categoría al array de categorías
                $categorias[] = $fila10["nombre_categoria"];
            }
        }

        // Guardamos el array de categorías en $salida
        $salida["categorias_productos"] = $categorias;
    }

    echo json_encode($salida);
}

// !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){
    
    $sql_id_contacto = $conexion->prepare("SELECT id_contacto FROM proveedor WHERE id_proveedor = '".$_POST["id_usuario"]."' LIMIT 1 ");
    $sql_id_contacto->execute();
    $id_contacto = $sql_id_contacto->fetchColumn();
    
    // Borrar de la tabla proveedor_has_categoria_producto
    $sql_borrar_categoria = $conexion->prepare( "DELETE FROM proveedor_has_categoria_producto WHERE id_proveedor = '".$_POST["id_usuario"]."' "); 
    $sql_borrar_categoria->execute();
    // Borrar de la tabla proveedor
    $sql_borrar_empleado = $conexion->prepare( "DELETE FROM proveedor WHERE id_proveedor = '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_empleado->execute();

    // Borrar de la tabla contacto
    $sql_borrar_contacto = $conexion->prepare( "DELETE FROM contacto WHERE id_contacto = '".$id_contacto."' "); 
    $sql_borrar_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla contacto
    $sql_increment_contacto = $conexion->prepare( "ALTER TABLE contacto AUTO_INCREMENT = 1"); 
    $sql_increment_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla proveedor
    $sql_increment_proveedor = $conexion->prepare( "ALTER TABLE proveedor AUTO_INCREMENT = 1"); 
    $sql_increment_proveedor->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
