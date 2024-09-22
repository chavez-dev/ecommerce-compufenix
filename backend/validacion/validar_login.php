<?php

    session_start();

    include('../config/conexion.php');

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql_login = "SELECT * FROM empleado WHERE DNI = '$usuario' AND password = '$password'";

    $stmt = $conexion->prepare($sql_login);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $_SESSION['usuario'] = $usuario;
        echo "success";
    }else{
        echo "error";
    }


?>