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
    $pdf->SetTitle('Reporte de Empleados');

    // Configuración de encabezado
    $pdf->SetHeaderData('', 0, 'Reporte de Empleados', 'TIENDA COMPUFENIX');
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

    // Consultar los empleados desde la vista
    $query = "SELECT * FROM lista_empleados";
    $stmt = $conexion->prepare($query);
    $stmt->execute();

    // Crear tabla para el reporte
    $html = '<h1 style="text-align:center;">Reporte de Empleados</h1>';
    $html .= '<p style="font-size:12px;">Fecha de generación: ' . $fecha_actual . '</p>';
    $html .= '<table border="1" cellpadding="4" cellspacing="0" style="width:100%;"> 
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th style="width:5%; text-align:center;">#</th>
                        <th style="width:10%; text-align:center;">DNI</th>
                        <th style="width:30%; text-align:center;">Nombre Completo</th>
                        <th style="width:15%; text-align:center;">Cargo</th>
                        <th style="width:10%; text-align:center;">Estado</th>
                        <th style="width:15%; text-align:center;">Celular</th>
                        <th style="width:15%; text-align:center;">Email</th>
                    </tr>
                </thead>
                <tbody>';

    // Generar las filas de la tabla
    if ($stmt->rowCount() > 0) {
        $count = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verificar el estado y asignar "Activo" o "Inactivo"
            $estado = ($row['status'] == 1) ? 'Activo' : 'Inactivo';

            $html .= '<tr>
                        <td style="width:5%; text-align:center;">' . $count++ . '</td>
                        <td style="width:10%;">' . htmlspecialchars($row['DNI']) . '</td>
                        <td style="width:30%;">' . htmlspecialchars($row['nombre_completo']) . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['cargo']) . '</td>
                        <td style="width:10%;">' . $estado . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['nro_celular']) . '</td>
                        <td style="width:15%;">' . htmlspecialchars($row['email']) . '</td>
                      </tr>';
        }
    } else {
        $html .= '<tr>
                    <td colspan="7" style="text-align:center;">No hay registros</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Agregar contenido al PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Definir el nombre del archivo con fecha y hora
    $nombre_archivo = 'reporte_empleados_' . date('Y-m-d_H-i-s') . '.pdf';

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
