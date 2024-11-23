<?php
//Datos
$token = 'apis-token-6155.0ZaiWTro30C9hRPgy0nd-ww7d7oX8sNk';
$dni = $_POST["dni"];
$tipoUsuario = $_POST["tipoUsuario"]; 


error_log("DNI recibido: $dni");
error_log("Tipo de usuario: $tipoUsuario");


// Verificamos la longitud del DNI
if (strlen($dni) != 8){
  echo json_encode(array("status" => "error", "message" => "El DNI debe tener 8 dígitos."));
  exit;
} 

// Verificamos si el DNI se encuentra en nuestra BD
include("../config/conexion.php");
if ($tipoUsuario == "cliente") {
  $stmt = $conexion->prepare("SELECT nro_documento FROM cliente WHERE nro_documento = '".$dni."' LIMIT 1");
} else if ($tipoUsuario == "proveedor") {
  $stmt = $conexion->prepare("SELECT nro_documento FROM proveedor WHERE nro_documento = '".$dni."' LIMIT 1");
} else if ($tipoUsuario == "empleado") {
  $stmt = $conexion->prepare("SELECT DNI FROM empleado WHERE DNI = '".$dni."' LIMIT 1");
}

$stmt->execute();
$resultado = $stmt->fetchAll();

if (count($resultado) > 0){
  // Si el DNI ya está registrado, enviamos un mensaje y no realizamos la consulta a la API
  error_log("DNI ya registrado, obteniendo datos del cliente...");

  $stmt = $conexion->prepare("
    SELECT 
        c.nombre, 
        co.direccion, 
        co.email, 
        co.nro_celular 
    FROM 
        cliente c
    INNER JOIN 
        contacto co 
    ON 
        c.id_contacto = co.id_contacto
    WHERE 
        c.nro_documento = :dni
    LIMIT 1
  ");

  $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
  $stmt->execute();
  $clienteData = $stmt->fetch(PDO::FETCH_ASSOC);

  error_log("Datos del cliente: " . json_encode($clienteData));

  if ($clienteData) {
      echo json_encode(array("status" => "success", "cliente" => $clienteData));
  } else {
      error_log("Error: Cliente no encontrado en tabla relacionada.");
      echo json_encode(array("status" => "error", "message" => "No se pudo obtener la información del cliente."));
  }
  exit;
  
} else {
  // Iniciar llamada a API
  error_log("DNI no registrado, consultando API externa...");
  $curl = curl_init();
  
  // Buscar dni
  curl_setopt_array($curl, array(
    // para user api versión 2
      CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
      // para user api versión 1
      // CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
      'Referer: https://apis.net.pe/consulta-dni-api',
      'Authorization: Bearer ' . $token
      ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  // Datos listos para usar
  echo $response;
}



// Otra forma de consulta DNI

// $dni = $_POST["dni"];
// if(strlen($dni)<8 ||  strlen($dni)>8){
//     $prueba = 1;
// } else {
//     $prueba = file_get_contents('https://api.apis.net.pe/v2/reniec/dni?numero='.$dni.'');
// }
// echo $prueba;
// ?>