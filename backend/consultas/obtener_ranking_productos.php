<?php
// Conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
include("../config/conexion.php");

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejecutar la consulta SQL
    $sql = "
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
            total_vendido DESC;
    ";
    $stmt = $pdo->query($sql);

    // Obtener los resultados y convertirlos a un array asociativo
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
console.log(sql);

?>
