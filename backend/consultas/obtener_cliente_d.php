<?php

include("../config/conexion.php");

// Verificar si la conexión existe
if (!$conexion) {
    echo json_encode(array("error" => "No se pudo conectar a la base de datos"));
    exit;
}

try {
    $query = "SELECT COUNT(*) AS totalClientes FROM cliente";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta SQL.");
    }

    $stmt->execute();
    $resultado = $stmt->fetch();

    if (!$resultado) {
        throw new Exception("Error al obtener el resultado de la consulta SQL.");
    }

    echo json_encode(array("totalClientes" => $resultado['totalClientes']));
} catch (Exception $e) {
    echo json_encode(array("error" => "Excepción capturada: " . $e->getMessage()));
}
?>
