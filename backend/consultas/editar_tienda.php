<?php
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $id_tienda = 1; // El ID de la tienda que estamos editando
    $razon_social = $_POST['razon_social'];
    $ruc = $_POST['ruc'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono_1 = $_POST['telefono_1'];
    $telefono_2 = $_POST['telefono_2'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];

    // Preparar la consulta de actualización
    $stmt = $conexion->prepare("
        UPDATE tienda
        SET razon_social = ?, ruc = ?, direccion = ?, correo = ?, telefono_1 = ?, telefono_2 = ?, departamento = ?, provincia = ?, distrito = ?
        WHERE id_tienda = ?
    ");
    
    $stmt->execute([$razon_social, $ruc, $direccion, $correo, $telefono_1, $telefono_2, $departamento, $provincia, $distrito, $id_tienda]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Datos de la tienda actualizados correctamente.'
    ]);
}
?>
