<?php
// Conexión a la base de datos

include("../config/conexion.php");

// Obtener el id_proveedor de la solicitud GET
$id_proveedor = isset($_GET['proveedor_id']) ? (int) $_GET['proveedor_id'] : 0;

if ($id_proveedor > 0) {
    // Consulta SQL para obtener los productos de las categorías relacionadas al proveedor
    $sql = "
        SELECT p.id_producto, p.nombre_producto, p.precio_unitario
        FROM producto p
        INNER JOIN proveedor_has_categoria_producto pc ON p.id_categoria_producto = pc.id_categoria_producto
        WHERE pc.id_proveedor = :id_proveedor
    ";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados en formato JSON
    echo json_encode($productos);
} else {
    echo json_encode([]);
}
?>
