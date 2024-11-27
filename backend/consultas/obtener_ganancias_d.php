<?php
header('Content-Type: application/json');

include("../config/conexion.php");

// Verificar si la conexión existe
if (!$conexion) {
    echo json_encode(array("error" => "No se pudo conectar a la base de datos"));
    exit;
}

try {
    // Cambia la consulta para obtener la suma total de ganancias
    $query = "SELECT SUM(pago_total) AS totalGanancias FROM venta";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta SQL.");
    }

    $stmt->execute();
    $resultado = $stmt->fetch();

    if (!$resultado) {
        throw new Exception("Error al obtener el resultado de la consulta SQL.");
    }

    // Enviar el total de ganancias en formato JSON
    echo json_encode(array("totalGanancias" => $resultado['totalGanancias']));
} catch (Exception $e) {
    echo json_encode(array("error" => "Excepción capturada: " . $e->getMessage()));
}
?>
