<?php

include("../../config/conexion.php");

// Obtener el ID de la venta desde la URL
$id_venta = isset($_GET['id_venta']) ? $_GET['id_venta'] : 0;
$id_venta = intval($id_venta);  // Sanitizar el valor de ID

// Obtener los datos de la tienda (supuesto id_tienda = 1)
$stmt_tienda = $conexion->prepare("SELECT * FROM tienda WHERE id_tienda = 1");
$stmt_tienda->execute();
$tienda = $stmt_tienda->fetch(PDO::FETCH_ASSOC);

// Obtener los datos de la venta
$stmt_venta = $conexion->prepare("SELECT v.*, c.nombre AS cliente_nombre, c.nro_documento, con.nro_celular AS telefono, 
                                  CONCAT(e.nombre, ' (', e.id_empleado, ')') AS empleado_nombre , con.direccion AS direccion_cliente
                                  FROM venta v
                                  LEFT JOIN cliente c ON v.id_cliente = c.id_cliente
                                  LEFT JOIN contacto con ON c.id_contacto = con.id_contacto
                                  LEFT JOIN empleado e ON v.id_empleado = e.id_empleado
                                  WHERE v.id_venta = ?");
$stmt_venta->execute([$id_venta]);
$venta = $stmt_venta->fetch(PDO::FETCH_ASSOC);

// Obtener los detalles de la venta (productos)
$stmt_detalles = $conexion->prepare("SELECT dv.*, p.nombre_producto, dv.subtotal , p.precio_unitario
                                     FROM detalle_venta dv
                                     LEFT JOIN producto p ON dv.id_producto = p.id_producto
                                     WHERE dv.id_venta = ?");
$stmt_detalles->execute([$id_venta]);
$detalles_venta = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

// Obtener el comprobante asociado a la venta
$stmt_comprobante = $conexion->prepare("SELECT * FROM comprobante WHERE id_venta = ?");
$stmt_comprobante->execute([$id_venta]);
$comprobante = $stmt_comprobante->fetch(PDO::FETCH_ASSOC);

if ($venta) {
    // Creación del PDF con TCPDF
    require_once('TCPDF/tcpdf.php');
    
    $pdf = new TCPDF('P', 'mm', array(80, 258)); // Tamaño ajustado para boleta
    $pdf->SetMargins(4, 10, 4);
    $pdf->AddPage();

    // Encabezado de la tienda
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 5, "TIENDA " . strtoupper($tienda['razon_social']), 0, 'C', false);

    // Logo de la tienda
    $logo_path = './logo.png';  // Ruta del logo
    $pdf->Image($logo_path, 28, 15, 23);  // Ajustar la posición y tamaño del logo
    
    $pdf->MultiCell(10, 5, "                                             ", 0, 'C', false);
    // Información de la tienda
    $pdf->SetFont('Helvetica', '', 9);
    $pdf->MultiCell(0, 5, "RUC: " . $tienda['ruc'], 0, 'C', false);
    $pdf->MultiCell(0, 5, "Dirección: " . $tienda['direccion'], 0, 'C', false);
    $pdf->MultiCell(0, 5, $tienda['departamento'] . " - " . $tienda['provincia'] . " - " . $tienda['distrito'], 0, 'C', false);
    
    $pdf->Ln(5);
    $pdf->Cell(0, 5, "------------------------------------------------------", 0, 0, 'C');
    $pdf->Ln(5);

    // Información de la venta
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->MultiCell(0, 5, "BOLETA DE VENTA", 0, 'C', false);
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->MultiCell(0, 5, "SERIE: " . $comprobante['serie'] . "   NUMERO: " . $comprobante['numero'], 0, 'C', false);
    $pdf->MultiCell(0, 5, "FECHA EMISIÓN: " . date("d/m/Y h:i A", strtotime($venta['registro_venta'])), 0, 'C', false);
    $pdf->MultiCell(0, 5, "VENDEDOR: " . $venta['empleado_nombre'], 0, 'C', false);
    $pdf->MultiCell(0, 5, "CLIENTE: " . $venta['cliente_nombre'], 0, 'C', false);
    $pdf->MultiCell(0, 5, "NRO DOC: " . $venta['nro_documento'], 0, 'C', false);

    $pdf->Ln(5);
    $pdf->Cell(0, 5, "------------------------------------------------------", 0, 0, 'C');
    $pdf->Ln(5);

    // Tabla de productos
    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Cell(30, 5, "DESCRIPCIÓN", 0, 0, 'C');
    $pdf->Cell(7, 5, "CANT.", 0, 0, 'C');
    $pdf->Cell(15, 5, "P. UNIT.", 0, 0, 'C');
    $pdf->Cell(15, 5, "IMP.", 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->Cell(72, 5, "------------------------------------------------------------------------------------", 0, 0, 'C');
    $pdf->Ln(3);

    // Detalles de los productos
    $total_venta = 0;
    foreach ($detalles_venta as $detalle) {
        $pdf->Cell(30, 4, $detalle['nombre_producto'], 0, 0, 'C');
        $pdf->Cell(7, 4, $detalle['cantidad_ordenada'], 0, 0, 'C');
        $pdf->Cell(15, 4, "S/ " . number_format($detalle['precio_unitario'], 2), 0, 0, 'C');
        $pdf->Cell(15, 4, "S/ " . number_format($detalle['subtotal'], 2), 0, 0, 'C');
        $pdf->Ln(4);
        $total_venta += $detalle['subtotal'];
    }

    // Totales
    $pdf->Ln(5);
    $pdf->Cell(72, 5, "------------------------------------------------------------------------------------", 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(18, 5, "", 0, 0, 'C');
    $pdf->Cell(22, 5, "TOTAL A PAGAR", 0, 0, 'C');
    $pdf->Cell(32, 5, "S/ " . number_format($total_venta, 2), 0, 0, 'C');

    // Información QR
    $qr_data = "ID Venta: " . $venta['id_venta'] . "\n" . 
               "Serie: " . $comprobante['serie'] . " - Numero: " . $comprobante['numero'] . "\n" . 
               "Cliente: " . $venta['cliente_nombre'] . "\n" . 
               "Total: S/ " . number_format($total_venta, 2) . "\n" . 
               "Fecha: " . date("d/m/Y h:i A", strtotime($venta['registro_venta']));

    // Generación del QR
    $qr_width = 30;  // Ancho del QR
    $pdf->Ln(10);  // Espacio antes del QR
    $center_x = (80 - $qr_width) / 2;  // Calcular el centro horizontal de la página
    $pdf->write2DBarcode($qr_data, 'QRCODE', $center_x, $pdf->GetY(), $qr_width, $qr_width); // Centrado del QR

    // Frase de agradecimiento
    $pdf->Ln(40);
    $pdf->SetFont('Helvetica', 'I', 9);
    $pdf->MultiCell(0, 5, "*** GRACIAS POR SU COMPRA ***", 0, 'C', false);

    // Generar el archivo PDF
    $pdf->Output('COMPROBANTE_' . $comprobante['numero'] . '.pdf', 'I');

} else {
    echo "<p>Venta no encontrada.</p>";
}

?>
