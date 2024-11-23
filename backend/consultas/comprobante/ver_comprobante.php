<?php
// Obtener el ID de la venta desde la URL
$id_venta = isset($_GET['id_venta']) ? $_GET['id_venta'] : 0;

// Validar y sanitizar el ID para evitar problemas de seguridad
$id_venta = intval($id_venta);

// Conectar a la base de datos
include("../config/conexion.php");

error_log("Ver comprobante");

// Obtener los detalles de la venta
$stmt = $conexion->prepare("SELECT * FROM venta WHERE id_venta = ?");
$stmt->execute([$id_venta]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if ($venta) {
    // Aquí deberías generar el comprobante de acuerdo a los detalles de la venta
    // Por ejemplo, podrías mostrar la información de la venta en un formato de ticket
    echo "<h1>Comprobante de Venta</h1>";
    echo "<p>ID Venta: " . $venta['id_venta'] . "</p>";
    echo "<p>Fecha de Venta: " . $venta['registro_venta'] . "</p>";
    echo "<p>Total: " . $venta['pago_total'] . "</p>";
    // Agregar más detalles según lo necesites, como los productos comprados, impuestos, etc.
} else {
    echo "<p>Venta no encontrada.</p>";
}
?>
