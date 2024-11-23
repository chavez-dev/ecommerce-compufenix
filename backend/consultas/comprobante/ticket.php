<?php

include("../../config/conexion.php");



// Obtener el ID de la venta desde la URL
$id_venta = isset($_GET['id_venta']) ? $_GET['id_venta'] : 0;
$id_venta = intval($id_venta);  // Sanitizar el valor de ID

// Log: verificar el ID de la venta
error_log("ID de venta recibido: " . $id_venta);

// Obtener los datos de la tienda (supuesto id_tienda = 1)
$stmt_tienda = $conexion->prepare("SELECT * FROM tienda WHERE id_tienda = 1");
$stmt_tienda->execute();
$tienda = $stmt_tienda->fetch(PDO::FETCH_ASSOC);

// Log: verificar los datos de la tienda
error_log("Datos de la tienda: " . print_r($tienda, true));

// Obtener los datos de la venta
$stmt_venta = $conexion->prepare("SELECT v.*, c.nombre AS cliente_nombre, c.nro_documento, con.nro_celular AS telefono, e.nombre AS empleado_nombre, con.direccion AS direccion_cliente
                                   FROM venta v
                                   LEFT JOIN cliente c ON v.id_cliente = c.id_cliente
                                   LEFT JOIN contacto con ON c.id_contacto = con.id_contacto
                                   LEFT JOIN empleado e ON v.id_empleado = e.id_empleado
                                   WHERE v.id_venta = ?");
$stmt_venta->execute([$id_venta]);
$venta = $stmt_venta->fetch(PDO::FETCH_ASSOC);

// Log: verificar los datos de la venta
error_log("Datos de la venta: " . print_r($venta, true));

// Obtener los detalles de la venta (productos)
$stmt_detalles = $conexion->prepare("SELECT dv.*, p.nombre_producto, dv.subtotal , p.precio_unitario
                                     FROM detalle_venta dv
                                     LEFT JOIN producto p ON dv.id_producto = p.id_producto
                                     WHERE dv.id_venta = ?");
$stmt_detalles->execute([$id_venta]);
$detalles_venta = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

// Log: verificar los detalles de la venta
error_log("Detalles de la venta: " . print_r($detalles_venta, true));

// Obtener el comprobante asociado a la venta
$stmt_comprobante = $conexion->prepare("SELECT * FROM comprobante WHERE id_venta = ?");
$stmt_comprobante->execute([$id_venta]);
$comprobante = $stmt_comprobante->fetch(PDO::FETCH_ASSOC);

// Log: verificar los datos del comprobante
error_log("Datos del comprobante: " . print_r($comprobante, true));

if ($venta) {
    // Generación del comprobante con la librería FPDF y código de barras
    require "./code128.php";  // Asumiendo que ya tienes esta librería para el código de barras

    // Creación del PDF
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();

    // Encabezado de la tienda
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "TIENDA " . strtoupper($tienda['razon_social'])),0,'C',false);




    $logo_path = './logo.png';  // Reemplaza 'path/to/logo.png' con la ruta real de la imagen en tu servidor

    // Obtener el tamaño del logo (solo el ancho)
    $logo_width = 23; // Ajusta el ancho del logo (en mm)
    $logo_height = 0; // Calculamos la altura automáticamente

    // Calcular la posición X para centrar el logo
    $x = ($pdf->GetPageWidth() - $logo_width) / 2; // Centrar la imagen

    // Ajuste de la posición Y para mover la imagen hacia arriba
    $y_position = $pdf->GetY() - 0;  // Mueve el logo 10 unidades hacia arriba

    // Insertar el logo con tamaño ajustado y centrado
    $pdf->Image($logo_path, $x, $y_position, $logo_width, $logo_height);


    $pdf->MultiCell(4,5,iconv("UTF-8", "ISO-8859-1", "              "),0,'C',false);


    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "RUC: " . $tienda['ruc']),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "Dirección: " . $tienda['direccion']),0,'C',false);

    // Departamento-Ciudad-Distrito en una sola línea con guion
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", $tienda['departamento'] . " - " . $tienda['provincia'] . " - " . $tienda['distrito']),0,'C',false);


    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    // Información de la venta
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "BOLETA DE VENTA ELECTRÓNICA"),0,'C',false);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "SERIE: " . $comprobante['serie'] . "   " ."NUMERO: " . $comprobante['numero']),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "FECHA EMISIÓN: " . date("d/m/Y h:i A", strtotime($venta['registro_venta']))),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "VENDEDOR: " . $venta['empleado_nombre']),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "CLIENTE: " . $venta['cliente_nombre']),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "NRO DOC: " . $venta['nro_documento']),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    // Tabla de productos
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(30,5,iconv("UTF-8", "ISO-8859-1", "DESCRIPCIÓN"),0,0,'C');
    $pdf->Cell(7,5,iconv("UTF-8", "ISO-8859-1", "CANT."),0,0,'C');
    $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1", "P. UNIT."),0,0,'C');
    $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1", "IMP."),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    // Detalles de los productos
    $total_venta = 0;
    foreach ($detalles_venta as $detalle) {
         // Nombre del producto
        $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1", $detalle['nombre_producto']),0,0,'C');
        // Cantidad
        $pdf->Cell(7,4,iconv("UTF-8", "ISO-8859-1", $detalle['cantidad_ordenada']),0,0,'C');
        // Precio unitario
        $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1", "S/ " . number_format($detalle['precio_unitario'], 2)),0,0,'C');
        // Importe (cantidad * precio unitario)
        $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1", "S/ " . number_format($detalle['subtotal'], 2)),0,0,'C');
        $pdf->Ln(4);

        $total_venta += $detalle['subtotal'];
    }

    // Totales
    $pdf->Ln(5);
    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","S/ " . number_format($total_venta, 2)),0,0,'C');



   

    // Frase de agradecimiento centrada
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1", "*** GRACIAS POR SU COMPRA ***"), 0, 'C', false);

    // Generar el archivo PDF
    $pdf->Output("I", "Comprobante_".$comprobante['numero'].".pdf", true);
} else {
    echo "<p>Venta no encontrada.</p>";
}

?>
