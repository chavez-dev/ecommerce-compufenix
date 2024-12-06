<?php
session_start();
include('../config/conexion.php');

// Obtener datos del formulario de login
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos por su DNI
$sql_login = "SELECT e.*, c.nombre_cargo FROM empleado e 
              JOIN cargo c ON e.id_cargo = c.id_cargo 
              WHERE e.DNI = :usuario";
$stmt = $conexion->prepare($sql_login);
$stmt->bindParam(':usuario', $usuario); // Para evitar inyecciones
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Obtener la información del usuario
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar la contraseña introducida con el hash almacenado
    if (password_verify($password, $row['password'])) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['cargo'] = $row['nombre_cargo']; // Almacenar el cargo en la sesión
        echo "success";
    } else {
        // Contraseña incorrecta
        echo "error";
    }
} else {
    // Usuario no encontrado
    echo "error";
}
?>