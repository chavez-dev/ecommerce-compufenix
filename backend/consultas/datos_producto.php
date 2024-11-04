<?php
include("../config/conexion.php");


if (isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);
    
    $sql = "SELECT stock, precio_unitario FROM producto WHERE id_producto = :id_producto";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'stock' => $data['stock'], 'precio_unitario' => $data['precio_unitario']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
}
?>
