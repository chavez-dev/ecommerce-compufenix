<?php


include("../config/conexion.php");

// Verificar si la conexión existe
if (!$conexion) {
    echo json_encode(array("error" => "No se pudo conectar a la base de datos"));
    exit;
}

try {
    // Consulta para obtener el número total de ventas
    $query = "SELECT COUNT(*) AS totalVentas FROM venta";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta SQL.");
    }

    $stmt->execute();
    $resultado = $stmt->fetch();

    if (!$resultado) {
        throw new Exception("Error al obtener el resultado de la consulta SQL.");
    }

    echo json_encode(array("totalVentas" => $resultado['totalVentas']));
} catch (Exception $e) {
    echo json_encode(array("error" => "Excepción capturada: " . $e->getMessage()));
}
?>
