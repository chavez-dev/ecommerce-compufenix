<?php

include("../../config/conexion.php");

// ! AGREGAR: INSERTAMOS UN NUEVO EMPLEADO
if($_POST["operacion"] == "Crear"){
    
    // Datos del empleado
    $dni = $_POST['dni'];
    $nombre = strtoupper($_POST['nombre']);
    $apellido = strtoupper($_POST['apellido']);
    $estatus = $_POST['estado'];
    $estatus = ($estatus == 'on') ? 1 : 0;

    // Encriptando contraseña del empleado
    $password_usuario = $_POST['password'];
    $password = password_hash($password_usuario, PASSWORD_BCRYPT);

    
    $fecha_nacimiento = $_POST['fecha_nac']; // El campo de fecha de nacimiento
    $cargo = $_POST['area'];
    
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad']; // El campo de nacionalidad

    // Empleado
    $codigo_empleado = $_POST['codigo_empleado'];


    $stmt = $conexion->prepare( " CALL agregar_empleado ( :dni, :nombre, :apellido, :estatus,
    :password, :fecha_nacimiento, :nombre_cargo, :email, :celular, :direccion, :nacionalidad)"); 
    
    $resultado = $stmt->execute(
        array(
            ':dni' => $dni,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':estatus' => $estatus,
            ':password' => $password,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':nombre_cargo' => $cargo,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad,
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){
    // Datos del empleado
    $dni = $_POST['dni'];
    $nombre = strtoupper($_POST['nombre']);
    $apellido = strtoupper($_POST['apellido']);

    $estatus = $_POST['estado'];
    $estatus = ($estatus == 'on') ? 1 : 0;


    $password_usuario = $_POST['password'];
    $password = null;
    if (!empty($password_usuario)) {
        // Solo hasheamos si se ingresa una nueva contraseña
        $password = password_hash($password_usuario, PASSWORD_BCRYPT);
    }

    $fecha_nacimiento = $_POST['fecha_nac']; // El campo de fecha de nacimiento
    $cargo = $_POST['area'];
    
    // Contacto
    $email = strtolower($_POST['email']);
    $nro_celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacionalidad = $_POST['nacionalidad']; // El campo de nacionalidad

    // Empleado
    $codigo_empleado = $_POST['id_usuario'];


    // Verificamos si hay una nueva contraseña para actualizarla
    if (!empty($password)) {
        // Actualizamos la contraseña junto con los demás datos
        $stmt = $conexion->prepare("CALL editar_empleado (
            :id_empleado, :dni, :nombre, :apellido, :status, :password, 
            :fecha_nacimiento, :id_cargo, :email, :celular, :direccion, :nacionalidad)"
        );
        $stmt->bindParam(':password', $password);
    } else {
        // Si no hay nueva contraseña, actualizamos sin tocar el campo password
        $stmt = $conexion->prepare("CALL editar_empleado_sin_password (
            :id_empleado, :dni, :nombre, :apellido, :status, 
            :fecha_nacimiento, :id_cargo, :email, :celular, :direccion, :nacionalidad)"
        );
    } 
    
    $resultado = $stmt->execute(
        array(
            ':id_empleado' => $codigo_empleado,
            ':dni' => $dni,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':status' => $estatus,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':id_cargo' => $cargo,
            ':email' => $email,
            ':celular' => $nro_celular,
            ':direccion' => $direccion,
            ':nacionalidad' => $nacionalidad
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("
        SELECT e.DNI, e.nombre, e.apellido, e.status, e.fecha_nacimiento, e.id_cargo, 
               c.email, c.nro_celular, c.direccion, c.nacionalidad 
        FROM empleado e 
        INNER JOIN contacto c ON e.id_contacto = c.id_contacto 
        WHERE id_empleado = :id_usuario 
        LIMIT 1
    ");
    
    $stmt->bindParam(':id_usuario', $_POST["id_usuario"], PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($resultado)) {
        foreach ($resultado as $fila) {
            $salida["dni"] = $fila["DNI"];
            $salida["nombre"] = $fila["nombre"];
            $salida["apellido"] = $fila["apellido"];
            $salida["status"] = $fila["status"];
            $salida["fecha_nacimiento"] = $fila["fecha_nacimiento"];
            $salida["nombre_cargo"] = $fila["id_cargo"];
            $salida["email"] = $fila["email"];
            $salida["celular"] = $fila["nro_celular"];
            $salida["direccion"] = $fila["direccion"];
            $salida["nacionalidad"] = $fila["nacionalidad"];
        }
    }
    
    echo json_encode($salida);
}

// !BORRAR: ELIMINACION DE LA BD
if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){
    
    $sql_id_contacto = $conexion->prepare("SELECT id_contacto FROM empleado WHERE id_empleado = '".$_POST["id_usuario"]."' LIMIT 1 ");
    $sql_id_contacto->execute();
    $id_contacto = $sql_id_contacto->fetchColumn();

    // Borrar de la tabla empleado
    $sql_borrar_empleado = $conexion->prepare( "DELETE FROM empleado WHERE id_empleado = '".$_POST["id_usuario"]."' "); 
    $resultado = $sql_borrar_empleado->execute();

    // Borrar de la tabla contacto
    $sql_borrar_contacto = $conexion->prepare( "DELETE FROM contacto WHERE id_contacto = '".$id_contacto."' "); 
    $sql_borrar_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla contacto
    $sql_increment_contacto = $conexion->prepare( "ALTER TABLE contacto AUTO_INCREMENT = 1"); 
    $sql_increment_contacto->execute();

    // Actualizar AUTO_INCREMENT de la tabla cliente
    $sql_increment_empleado = $conexion->prepare( "ALTER TABLE empleado AUTO_INCREMENT = 1"); 
    $sql_increment_empleado->execute();

    if (!empty($resultado)) {
        echo 'Registro Eliminado';
    }
}


?>
