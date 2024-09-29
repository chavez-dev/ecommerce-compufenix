<?php
include("./backend/config/conexion.php");

// Asegúrate de que Cloudinary esté correctamente incluido
require __DIR__ . '/vendor/autoload.php'; // Ajusta la ruta según sea necesario

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

// Configura Cloudinary
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'div5zconf', // Tu nombre de Cloudinary
        'api_key'    => '224466925556896',    // Tu API Key
        'api_secret' => 'og70Z8GXhZl2TsOykOz1vB0ndzs', // Tu API Secret
    ],
]);



$upload = new UploadApi();
$result = $upload->upload('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxFvoRX4Y_mAxPaWqaHP5XBrWmjd47UfiM0A&s', [
    'use_filename' => true,
    'overwrite' => true,
    'folder' => 'compufenix' // Aquí especificas el folder
]);


$image_url = $result['secure_url'];



$nombre_producto = 'hfghfg';
// $imagen_producto = $_POST['imagen_producto'];
$modelo = 'fghfgh';
$id_categoria = 1;
$precio_unitario = 100;
$status = 1;
$stock_minimo = 100;
$descripcion = 'fdgdfg';


// * Agregando los datos a la BD con el procedimiento agregar_producto

$stmt = $conexion->prepare( "CALL agregar_producto ( :nombre_producto, :modelo, :descripcion, :imagen,
:status, :precio_unitario, :stock_minimo, :id_categoria)"); 

$resultado = $stmt->execute(
    array(
        ':nombre_producto' => $nombre_producto,
        ':modelo' => $modelo,
        ':descripcion' => $descripcion,
        ':imagen' => $image_url,
        ':status' => $status,
        ':precio_unitario' => $precio_unitario,
        ':stock_minimo' => $stock_minimo,
        ':id_categoria' => $id_categoria,
    )
);

if (!empty($resultado)) {
    echo 'Registro Creado';
}






