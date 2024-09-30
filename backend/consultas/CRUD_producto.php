<?php

include("../config/conexion.php");


// Asegúrate de que Cloudinary esté correctamente incluido
// require __DIR__ . '../../vendor/autoload.php'; // Ajusta la ruta según sea necesario

// use Cloudinary\Api\Upload\UploadApi;
// use Cloudinary\Configuration\Configuration;

// // Configura Cloudinary
// Configuration::instance([
//     'cloud' => [
//         'cloud_name' => 'div5zconf', // Tu nombre de Cloudinary
//         'api_key'    => '224466925556896',    // Tu API Key
//         'api_secret' => 'og70Z8GXhZl2TsOykOz1vB0ndzs', // Tu API Secret
//     ],
// ]);

// $upload = new UploadApi();
//             $result = $upload->upload('https://www.compartirpalabramaestra.org/sites/default/files/field/image/infografia-lo-que-hay-que-saber-del-aprendizaje-en-linea.jpg', [
//                 'use_filename' => true,
//                 'overwrite' => true,
//                 'folder' => 'compufenix' // Aquí especificas el folder
//             ]);

function subir_imagen(){
    if(isset($_FILES["imagen_producto"])){
        $extension = explode('.',$_FILES["imagen_producto"]['name']);
        $nuevo_nombre = rand() . '.' . $extension[1];
        $ubicacion = '../../frontend/assets/img/'. $nuevo_nombre;
        move_uploaded_file($_FILES["imagen_producto"]['tmp_name'], $ubicacion);
        return $nuevo_nombre;
    }
}


function obtener_nombre_imagen($id_usuario){
    include('../config/conexion.php');
    $stmt = $conexion->prepare("SELECT imagen FROM producto WHERE id_producto = '$id_usuario'"); 
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    foreach($resultado as $fila){
        return $fila["imagen"];
    }
}

// ! AGREGAR: INSERTAMOS UN NUEVO PROVEEDOR
if($_POST["operacion"] == "Crear"){
    
    $imagen = '';
    if ($_FILES["imagen_producto"]["name"] != ''){

        $cloud_name = 'div5zconf'; // Tu nombre de Cloudinary
        $api_key = '224466925556896'; // Tu API Key
        $api_secret = 'og70Z8GXhZl2TsOykOz1vB0ndzs'; // Tu API Secret

        // URL de carga de Cloudinary
        $url = "https://api.cloudinary.com/v1_1/$cloud_name/image/upload";

        $ubicacion = $_FILES["imagen_producto"]["tmp_name"];

        // Los parámetros a enviar
        $params = [
            'file' => new CURLFile($ubicacion), // archivo a subir
            'api_key' => $api_key,
            'upload_preset' => 'my_upload_preset', // Asegúrate de que este sea el nombre de tu upload preset
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
            $imagen = $result['secure_url']; // Obtener la URL segura de la imagen subida
            error_log("Imagen subida correctamente: $imagen");
        } else {
            error_log("Error al subir la imagen a Cloudinary: " . $result['error']);
            echo "Error al subir la imagen a Cloudinary: " . $result['error'];
            exit; // Salir si hay un error en la subida
        }
        
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
            $imagen = subir_imagen();
            unlink("../../frontend/assets/img/" . $imagen_antes);
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
            $salida["imagen_producto"] = '<img src="../../assets/img/' . $fila["imagen"] . '" class="img-thumbnail" width="90" height="70" /><input type="hidden" name="imagen_producto_oculta" value="'.$fila["imagen"].'" />';
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
        
        $imagen = obtener_nombre_imagen($_POST["id_usuario"]);

        if ($imagen != ''){
            unlink("../../frontend/assets/img/" . $imagen);
        }
        
        // Borrar de la tabla cliente
        $sql_borrar_producto = $conexion->prepare( "DELETE FROM producto WHERE id_producto = '".$_POST["id_usuario"]."' "); 
        $resultado = $sql_borrar_producto->execute();

        // Actualizar AUTO_INCREMENT de la tabla producto
        $sql_increment_producto = $conexion->prepare( "ALTER TABLE producto AUTO_INCREMENT = 1");
        $sql_increment_producto->execute();


        if (!empty($resultado)) {
            echo 'Registro Eliminado';
        }
    }


?>
