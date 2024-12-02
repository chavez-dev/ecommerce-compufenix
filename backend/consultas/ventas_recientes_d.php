<?php
// Conexión a la base de datos
include("../config/conexion.php");

// Consulta para obtener los datos de la vista lista_ventas
$sql = "SELECT fecha_hora_venta, nombre_cliente, precio_total FROM lista_ventas LIMIT 10"; // Limita a las 10 ventas más recientes
$result = $conn->query($sql);

// Comprobamos si la consulta devuelve resultados
if ($result->num_rows > 0) {
    // Almacenamos los resultados en un array
    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }
    // Devolvemos los datos en formato JSON
    echo json_encode($ventas);
} else {
    echo json_encode([]);
}

$conn->close();
?>
