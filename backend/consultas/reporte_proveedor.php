<?php
// Requiere TCPDF
require_once('comprobante/TCPDF/tcpdf.php');

include("../config/conexion.php"); // Conexión a la base de datos

// Establecer la zona horaria de Perú
date_default_timezone_set('America/Lima');

try {
    // Crear una instancia de TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tu Nombre');
    $pdf->SetTitle('Reporte de Proveedores');

    // Configuración de encabezado
    $pdf->SetHeaderData('', 0, 'Reporte de Proveedores', 'TIENDA COMPUFENIX');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Configuración de márgenes
    $pdf->SetMargins(10, 20, 10); // Márgenes izquierdo, superior, derecho
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    // Salto de página automático
    $pdf->SetAutoPageBreak(TRUE, 10);

    // Fuente predeterminada
    $pdf->SetFont('helvetica', '', 10);

    // Agregar una página
    $pdf->AddPage();

    // Obtener la fecha actual
    $fecha_actual = date('d-m-Y H:i:s');

    // Consultar los proveedores desde la vista
    $query = "SELECT * FROM lista_proveedores";
    $stmt = $conexion->prepare($query);
    $stmt->execute();

    // Crear tabla para el reporte
    $html = '<h1 style="text-align:center;">Reporte de Proveedores</h1>';
    $html .= '<p style="font-size:12px;">Fecha de generación: ' . $fecha_actual . '</p>';
    $html .= '<table border="1" cellpadding="4" cellspacing="0" style="width:100%;"> 
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th style="width:5%; text-align:center;">#</th> <!-- Cambiar la anchura -->
                        <th style="width:15%; text-align:center;">Tipo Proveedor</th> <!-- Cambiar la anchura -->
                        <th style="width:15%; text-align:center;">Número de Documento</th> <!-- Cambiar la anchura -->
                        <th style="width:30%; text-align:center;">Nombre</th> <!-- Cambiar la anchura -->
                        <th style="width:15%; text-align:center;">Celular</th> <!-- Cambiar la anchura -->
                        <th style="width:20%; text-align:center;">Email</th> <!-- Cambiar la anchura -->
                    </tr>
                </thead>
                <tbody>';

    // Generar las filas de la tabla
    if ($stmt->rowCount() > 0) {
        $count = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr>
                        <td style="width:5%; text-align:center;">' . $count++ . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['tipo_proveedor']) . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['nro_documento']) . '</td>
                        <td style="width:30%;">' . htmlspecialchars($row['nombre']) . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['nro_celular']) . '</td>
                        <td style="width:20%;">' . htmlspecialchars($row['email']) . '</td>
                      </tr>';
        }
    } else {
        $html .= '<tr>
                    <td colspan="6" style="text-align:center;">No hay registros</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Agregar contenido al PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Definir el nombre del archivo con fecha y hora
    $nombre_archivo = 'reporte_proveedores_' . date('Y-m-d_H-i-s') . '.pdf';

    // Mostrar el PDF en el navegador con el nombre definido
    $pdf->Output($nombre_archivo, 'I'); // 'I' muestra el PDF en el navegador

    // Respuesta al cliente (opcional si el PDF es mostrado directamente)
    echo json_encode([
        'status' => 'success',
    ]);
} catch (Exception $e) {
    // Manejar errores
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
