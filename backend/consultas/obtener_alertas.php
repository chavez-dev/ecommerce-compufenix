<?php
include("../config/conexion.php");

$consulta = "SELECT * FROM alerta_stock";
$stmt = $conexion->prepare($consulta);
$stmt->execute();

$alertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($alertas);
?>
