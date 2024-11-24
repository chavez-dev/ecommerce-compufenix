<?php
include("../config/conexion.php");
// Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_comprobante'])) {
    $tipoComprobante = $_POST['tipo_comprobante'];

    try {
        $stmt = $conexion->prepare("SELECT id, serie FROM serie WHERE tipo_serie = :tipo_serie AND estado = 1");
        $stmt->bindParam(':tipo_serie', $tipoComprobante, PDO::PARAM_STR);
        $stmt->execute();
        
        $series = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status' => 'success', 'series' => $series]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
