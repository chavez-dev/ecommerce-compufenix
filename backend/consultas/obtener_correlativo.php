<?php
include("../config/conexion.php");// Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['serie_id'])) {
    $serieId = $_POST['serie_id'];

    try {
        $stmt = $conexion->prepare("SELECT correlativo FROM serie WHERE id = :id");
        $stmt->bindParam(':id', $serieId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['status' => 'success', 'correlativo' => $result['correlativo']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró el correlativo.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
