<?php
header('Content-Type: application/json');
include("../config/conexion.php");

$response = [
    "labels" => [],
    "data" => []
];

try {
    // Consulta para obtener los productos más vendidos
    $query = "
        SELECT 
            p.nombre_producto, 
            SUM(dv.cantidad_ordenada) AS total_vendido
        FROM 
            detalle_venta dv
        JOIN 
            producto p ON dv.id_producto = p.id_producto
        GROUP BY 
            p.id_producto
        ORDER BY 
            total_vendido DESC
        LIMIT 10"; // Puedes limitar el ranking a los 10 más vendidos
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Construye los datos para el gráfico
    foreach ($resultados as $row) {
        $response["labels"][] = $row["nombre_producto"];
        $response["data"][] = $row["total_vendido"];
    }

} catch (Exception $e) {
    $response["error"] = "Error al obtener los datos: " . $e->getMessage();
}

echo json_encode($response);
?>
