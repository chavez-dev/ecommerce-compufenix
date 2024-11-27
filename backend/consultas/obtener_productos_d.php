<?php
header('Content-Type: application/json');

include("../config/conexion.php");

// Verificar si la conexión existe
if (!$conexion) {
    echo json_encode(array("error" => "No se pudo conectar a la base de datos"));
    exit;
}

try {
    // Consulta para obtener el total de productos
    $query = "SELECT COUNT(*) AS totalProductos FROM producto";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta SQL.");
    }

    $stmt->execute();
    $resultado = $stmt->fetch();

    if (!$resultado) {
        throw new Exception("Error al obtener el resultado de la consulta SQL.");
    }

    // Devolver el total de productos en formato JSON
    echo json_encode(array("totalProductos" => $resultado['totalProductos']));
} catch (Exception $e) {
    echo json_encode(array("error" => "Excepción capturada: " . $e->getMessage()));
}
?>
