<?php

include("../config/conexion.php");

function subir_imagen() {
    $cloud_name = 'div5zconf'; // Tu nombre de Cloudinary
    $api_key = '224466925556896'; // Tu API Key
    $api_secret = 'og70Z8GXhZl2TsOykOz1vB0ndzs'; // Tu API Secret

    // URL de carga de Cloudinary
    $url = "https://api.cloudinary.com/v1_1/$cloud_name/image/upload";

    // Generar un nombre único para la imagen
    $nombre_unico = uniqid('imagen_', true); // Prefijo "imagen_" seguido de un ID único

    // Asignar la ubicación temporal del archivo
    $ubicacion = $_FILES["imagen_producto"]["tmp_name"];

    // Los parámetros a enviar
    $params = [
        'file' => new CURLFile($ubicacion), // archivo a subir
        'api_key' => $api_key,
        'upload_preset' => 'my_upload_preset', // Asegúrate de que este sea el nombre de tu upload preset
        'public_id' => $nombre_unico, // Nombre único para evitar colisiones
        'folder' => 'compufenix' // Carpeta en Cloudinary (opcional si lo defines en el preset)
    ];

    // Iniciar la sesión de cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    curl_close($ch);

    // Convertir la respuesta JSON en un array
    $result = json_decode($response, true);

    // Verificar si la subida fue exitosa
    if (isset($result['secure_url'])) {
        return $result['secure_url']; // Obtener la URL segura de la imagen subida
    } else {
        error_log("Error al subir la imagen a Cloudinary: " . $result['error']);
        echo "Error al subir la imagen a Cloudinary: " . $result['error'];
        exit; // Salir si hay un error en la subida
    }
}



function obtener_nombre_imagen($codigo_producto) {
    global $conexion; // Asegúrate de que la conexión a la base de datos esté disponible

    $stmt = $conexion->prepare("SELECT imagen FROM producto WHERE id_producto = :codigo_producto");
    $stmt->bindParam(':codigo_producto', $codigo_producto);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el public_id (nombre) de la imagen o un string vacío si no existe
    return $resultado ? $resultado['imagen'] : '';
}

// Función para eliminar imagen de Cloudinary
function eliminar_imagen_cloudinary($public_id) {
    $cloud_name = 'div5zconf'; // Tu nombre de Cloudinary
    $api_key = '224466925556896'; // Tu API Key
    $api_secret = 'og70Z8GXhZl2TsOykOz1vB0ndzs'; // Tu API Secret

    // URL para eliminar imagen
    $url = "https://api.cloudinary.com/v1_1/$cloud_name/image/destroy";

    $params = [
        'public_id' => $public_id,
        'api_key' => $api_key,
        'api_secret' => $api_secret,
    ];

    // Iniciar la sesión de cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    curl_close($ch);

    // Convertir la respuesta JSON en un array
    $result = json_decode($response, true);

    if (isset($result['result']) && $result['result'] == 'ok') {
        error_log("Imagen eliminada correctamente de Cloudinary.");
    } else {
        error_log("Error al eliminar la imagen de Cloudinary: " . $result['error']);
    }
}


// ! AGREGAR: INSERTAMOS UN NUEVO PRODUCTO
if($_POST["operacion"] == "Crear"){
    
    $imagen = '';
    if ($_FILES["imagen_producto"]["name"] != ''){

        // Llama a la función para subir la imagen
        $imagen = subir_imagen();
        
    }

    // Datos del producto
    $codigo_producto = $_POST['codigo_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    // $imagen_producto = $_POST['imagen_producto'];
    $modelo = $_POST['modelo'];
    $id_categoria = $_POST['categoria'];
    $precio_unitario = $_POST['precio_unitario'];
    $status = $_POST['status'];
    if($status == 'on'){
        $status = 1;
    }else{
        $status = 0;
    }
    $stock_minimo = $_POST['stock_minimo'];
    $descripcion = $_POST['descripcion'];


    // * Agregando los datos a la BD con el procedimiento agregar_producto

    $stmt = $conexion->prepare( "CALL agregar_producto ( :nombre_producto, :modelo, :descripcion, :imagen,
    :status, :precio_unitario, :stock_minimo, :id_categoria)"); 
    
    $resultado = $stmt->execute(
        array(
            ':nombre_producto' => $nombre_producto,
            ':modelo' => $modelo,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen,
            ':status' => $status,
            ':precio_unitario' => $precio_unitario,
            ':stock_minimo' => $stock_minimo,
            ':id_categoria' => $id_categoria,
        )
    );

    if (!empty($resultado)) {
        echo 'Registro Creado';
    }
}

// ! EDITAR: ACTUALIZAMOS LOS DATOS EN LA BD
if($_POST["operacion"] == "Editar"){

    $imagen_antes = obtener_nombre_imagen($_POST["id_usuario"]);

    $imagen = '';
    if ($_FILES["imagen_producto"]["name"] != ''){
            // Subir nueva imagen a Cloudinary
            $imagen = subir_imagen(); // Asume que este es tu método para subir a Cloudinary
            // Si quieres eliminar la imagen anterior, también puedes hacerlo aquí
            eliminar_imagen_cloudinary($imagen_antes); // Llamada a función para eliminar imagen
    }else{
        $imagen = $_POST["imagen_producto_oculta"];
    }

    // Datos del producto
    $codigo_producto = $_POST['id_usuario'];
    $nombre_producto = $_POST['nombre_producto'];
    $modelo = $_POST['modelo'];
    $id_categoria = $_POST['categoria'];
    $precio_unitario = $_POST['precio_unitario'];
    $status = $_POST['status'];
    if($status == 'on'){
        $status = 1;
    }else{
        $status = 0;
    }
    $stock = $_POST['stock'];
    $stock_minimo = $_POST['stock_minimo'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conexion->prepare( "CALL editar_producto ( :id_producto, :nombre_producto, :modelo, :descripcion, :imagen,
    :status, :precio_unitario, :stock_minimo, :stock,  :id_categoria)"); 
    
    $resultado = $stmt->execute(
        array(
            ':id_producto' => $codigo_producto,
            ':nombre_producto' => $nombre_producto,
            ':modelo' => $modelo,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen,
            ':status' => $status,
            ':precio_unitario' => $precio_unitario,
            ':stock_minimo' => $stock_minimo,
            ':stock' => $stock,
            ':id_categoria' => $id_categoria,
        )
    );

    if (!empty($resultado)) {

        echo 'Registro Editado';
        
    }
}

// ! EDITAR: TRAEMOS LOS DATOS PARA EDITAR
if( isset($_POST["id_usuario"]) && ($_POST["operacion"])=='actualizar'){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM producto WHERE id_producto = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        $salida["nombre_producto"] = $fila["nombre_producto"];
        // $salida["imagen_producto"] = $fila["imagen"];
        if ($fila["imagen"] != '') {
            $salida["imagen_producto"] = '<img src="' . $fila["imagen"] . '" class="img-thumbnail" width="90" height="70" /><input type="hidden" name="imagen_producto_oculta" value="'.$fila["imagen"].'" />';
        }else{
            $salida["imagen_producto"] = '<input type="hidden" name="imagen_producto_oculta" value="" />';
        }
        $salida["modelo"] = $fila["modelo"];
        $salida["categoria"] = $fila["id_categoria_producto"];
        $salida["precio_unitario"] = $fila["precio_unitario"];
        $salida["stock"] = $fila["stock"];
        $salida["status"] = $fila["status"];
        $salida["stock_minimo"] = $fila["stock_minimo"];
        $salida["descripcion"] = $fila["descripcion"];
    }

    echo json_encode($salida);
}

 // !BORRAR: ELIMINACION DE LA BD
    if(isset($_POST["id_usuario"]) && ($_POST["operacion"])=='borrar' ){
        
        // $imagen = obtener_nombre_imagen($_POST["id_usuario"]);

        // if ($imagen != ''){
        //     unlink("../../frontend/assets/img/" . $imagen);
        // }
        // Borrar de la tabla alerta_stock
        $sql_borrar_alerta = $conexion->prepare( "DELETE FROM alerta_stock WHERE id_producto = '".$_POST["id_usuario"]."' "); 
        $resultado = $sql_borrar_alerta->execute();

        // Borrar de la tabla producto
        $sql_borrar_producto = $conexion->prepare( "UPDATE producto SET status = 0 WHERE id_producto = '".$_POST["id_usuario"]."' "); 
        $resultado = $sql_borrar_producto->execute();

        

        // Actualizar AUTO_INCREMENT de la tabla producto
        $sql_increment_producto = $conexion->prepare( "ALTER TABLE producto AUTO_INCREMENT = 1");
        $sql_increment_producto->execute();


        if (!empty($resultado)) {
            echo 'Producto Deshabilitado';
        }
    }


?>
