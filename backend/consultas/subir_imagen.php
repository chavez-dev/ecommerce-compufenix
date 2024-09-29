<?php
include("../config/conexion.php");
error_log("Entrando a subir_imagen.php: ");

// Asegúrate de que Cloudinary esté correctamente incluido
// No necesitamos la configuración de la API de Cloudinary aquí, porque vamos a usar curl.

function subir_imagen_a_cloudinary($ubicacion) {
    // Configuración de Cloudinary
    $cloud_name = 'div5zconf'; // Tu nombre de Cloudinary
    $api_key = '224466925556896'; // Tu API Key
    $api_secret = 'og70Z8GXhZl2TsOykOz1vB0ndzs'; // Tu API Secret

    // URL de carga de Cloudinary
    $url = "https://api.cloudinary.com/v1_1/$cloud_name/image/upload";

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

    // Manejar errores
    if ($response === false) {
        error_log('Error en cURL: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    // Convertir la respuesta JSON en un array
    $result = json_decode($response, true);

    // Verificar si hubo errores en la respuesta de Cloudinary
    if (isset($result['error'])) {
        error_log('Error al subir a Cloudinary: ' . $result['error']);
        error_log('Respuesta completa de Cloudinary: ' . print_r($result, true)); // Agregado para depuración
        return false;
    }

    return $result; // Devuelve el resultado de la carga
}

if (isset($_GET['imagen'])) {
    $imagen = urldecode($_GET['imagen']);
    $ubicacion = '../../frontend/assets/img/' . $imagen;

    // Verificar que el archivo existe
    if (file_exists($ubicacion)) {
        error_log("La ruta de la imagen es correcta: " . $ubicacion);

        // Subir la imagen a Cloudinary
        $result = subir_imagen_a_cloudinary($ubicacion);
        
        if ($result) {
            // URL segura de la imagen
            $imagen_url = $result['secure_url'];
            error_log("URL creada: " . $imagen_url);

            // Aquí puedes guardar la URL en la base de datos si lo deseas
            // Puedes hacer una consulta a la base de datos aquí para actualizar el registro correspondiente

            echo "Imagen subida a Cloudinary: " . $imagen_url;

            // Opcional: Eliminar el archivo local después de subirlo
            error_log("Iamgen subida creada: ");
            
        } else {
            echo "Error al subir la imagen a Cloudinary.";
        }
    } else {
        echo "El archivo no existe: " . $ubicacion;
    }
} else {
    echo "No se ha recibido ninguna imagen para subir.";
}
?>
