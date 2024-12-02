<?php
// Conexión a la base de datos (ajustar según tu configuración)
include("../config/conexion.php");

$query = "SELECT 
              p.nombre_producto, 
              SUM(dv.cantidad_ordenada) AS total_vendido
          FROM 
              detalle_venta dv
          JOIN 
              producto p ON dv.id_producto = p.id_producto
          GROUP BY 
              p.id_producto
          ORDER BY 
              total_vendido DESC";

$result = mysqli_query($conn, $query);

$productos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}

echo json_encode($productos);
?>
