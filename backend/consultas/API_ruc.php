<?php
// Datos
$token = 'apis-token-6155.0ZaiWTro30C9hRPgy0nd-ww7d7oX8sNk';
$ruc = $_POST["ruc"];
$tipoUsuario = $_POST["tipoUsuario"]; 

// Verificamos la longitud del DNI
if (strlen($ruc) != 11){
  echo json_encode(array("status" => "error", "message" => "El RUC debe tener 11 dígitos."));
  exit;
} 

// Verificamos si el DNI se encuentra en nuestra BD
include("../config/conexion.php");
if ($tipoUsuario == "cliente") {
  $stmt = $conexion->prepare("SELECT nro_documento FROM cliente WHERE nro_documento = '".$ruc."' LIMIT 1");
} else if ($tipoUsuario == "proveedor") {
  $stmt = $conexion->prepare("SELECT nro_documento FROM proveedor WHERE nro_documento = '".$ruc."' LIMIT 1");
}

$stmt->execute();
$resultado = $stmt->fetchAll();

if (count($resultado) > 0){
  // Si el DNI ya está registrado, enviamos un mensaje y no realizamos la consulta a la API
  echo json_encode(array("status" => "error", "message" => "El RUC ya está registrado."));
  
} else {
  // Iniciar llamada a API
  $curl = curl_init();
  
  // Buscar ruc sunat
  curl_setopt_array($curl, array(
    // para usar la versión 2
      CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
      // para usar la versión 1
      // CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
          'Referer: http://apis.net.pe/api-ruc',
          'Authorization: Bearer ' . $token
      ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  // Datos de empresas según padron reducido
  echo $response;
}

?>