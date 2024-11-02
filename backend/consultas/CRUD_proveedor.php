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

    if ($resultado) {

        // Obtener el ID del proveedor recién insertado usando el `nro_documento`
        $sqlGetId = "SELECT id_proveedor FROM proveedor WHERE nro_documento = :nro_documento LIMIT 1";
        $stmtGetId = $conexion->prepare($sqlGetId);
        $stmtGetId->bindParam(':nro_documento', $nro_documento, PDO::PARAM_STR);
        $stmtGetId->execute();
        $id_proveedor = $stmtGetId->fetchColumn();

    // Verificar y agregar las categorías seleccionadas en la tabla proveedor_has_categoria_producto
    if (isset($_POST['categorias']) && is_array($_POST['categorias'])) {

        foreach ($_POST['categorias'] as $id_categoria) {


            // Insertar la relación entre proveedor y categoría
            $sqlInsert = "INSERT INTO proveedor_has_categoria_producto (id_proveedor, id_categoria_producto) VALUES (:id_proveedor, :id_categoria_producto)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
            $stmtInsert->bindParam(':id_categoria_producto', $id_categoria, PDO::PARAM_INT);
            
            // Ejecutar el insert y verificar el resultado
            if ($stmtInsert->execute()) {
                error_log("Registro de relación exitoso - ID Proveedor: $id_proveedor, ID Categoría: $id_categoria", 3, "ruta_de_tu_log/errores.log");
            } else {
                error_log("Error al registrar relación - ID Proveedor: $id_proveedor, ID Categoría: $id_categoria", 3, "ruta_de_tu_log/errores.log");
            }
        }
    } else {
        error_log("No se seleccionaron categorías o el formato es incorrecto", 3, "ruta_de_tu_log/errores.log");
    }

    echo 'Registro Creado. ID del proveedor: ' . $id_proveedor;
} else {
    echo 'Error al crear el registro';
    error_log("Error al insertar proveedor en la BD.", 3, "ruta_de_tu_log/errores.log");
}

}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if ($_POST["operacion"] == "Editar") {
    // Datos del proveedor
    $tipo_documento = $_POST['tipo_documento'];
    $nro_documento = $_POST['nro_documento'];
    $nombre = strtoupper($_POST['nombre']);
    $departamento = $_POST['departamento'];
    
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad'];

    // ID del proveedor a editar
    $codigo_proveedor = $_POST['id_usuario'];

    // Llamar al procedimiento almacenado para editar el proveedor
    $stmt = $conexion->prepare("CALL editar_proveedor(:id_proveedor, :tipo_proveedor, :nro_documento, :nombre, :departamento, :email, :celular, :direccion, :nacionalidad)");

    $resultado = $stmt->execute(array(
        ':id_proveedor' => $codigo_proveedor,
        ':tipo_proveedor' => $tipo_documento,
        ':nro_documento' => $nro_documento,
        ':nombre' => $nombre,
        ':departamento' => $departamento,
        ':email' => $email,
        ':celular' => $nro_celular,
        ':direccion' => $direccion,
        ':nacionalidad' => $nacionalidad
    ));

    if ($resultado) {
        // Eliminar todas las categorías asociadas al proveedor
        $sqlDelete = "DELETE FROM proveedor_has_categoria_producto WHERE id_proveedor = :id_proveedor";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bindParam(':id_proveedor', $codigo_proveedor, PDO::PARAM_INT);
        $stmtDelete->execute();

        // Insertar las categorías seleccionadas en el formulario
        if (isset($_POST['categorias']) && is_array($_POST['categorias'])) {
            foreach ($_POST['categorias'] as $id_categoria) {
                $sqlInsert = "INSERT INTO proveedor_has_categoria_producto (id_proveedor, id_categoria_producto) VALUES (:id_proveedor, :id_categoria_producto)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $stmtInsert->bindParam(':id_proveedor', $codigo_proveedor, PDO::PARAM_INT);
                $stmtInsert->bindParam(':id_categoria_producto', $id_categoria, PDO::PARAM_INT);
                $stmtInsert->execute();
            }
        }

        echo 'Registro Actualizado. ID del proveedor: ' . $codigo_proveedor;
    } else {
        echo 'Error al actualizar el registro';
        error_log("Error al actualizar proveedor en la BD.", 3, "C:/wamp64/www/ecommerce-compufenix/backend/logs/errores.log");
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

        foreach ($resultado10 as $fila10) {
            // Comprobamos si la categoría pertenece al proveedor actual
            if ($fila["id_proveedor"] == $fila10["id_proveedor"]) {
                // Agregamos el ID de la categoría al array de categorías
                $categorias[] = $fila10["id_categoria_producto"];
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
