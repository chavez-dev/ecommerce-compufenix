<?php

// $servername = "localhost:3307";
$username = "root";
$password = "";
//$namebd = "compufenix";

// $conexion = mysqli_connect($servername, $username, $password, $namebd);
$conexion = new PDO('mysql:host=localhost:3307;dbname=bd_tienda', $username, $password);

// Verificamos si la conexion se ha establecido
// if (!$conexion) {
//     die("La conexión falló: " . mysqli_connect_error());
// }

?>