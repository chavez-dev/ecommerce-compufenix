<?php

include("../config/conexion.php");

// Consulta SQL y ejecucion y guardado del resultado 
$query_consulta = "";
$salida = array();
$query_consulta = "SELECT * FROM serie";

// $resultado = mysqli_query($conexion, $consulta);
// $total_rows = mysqli_num_rows($resultado);
function obtener_todo_registros(){
    include("../config/conexion.php");
    $stmt = $conexion->prepare("SELECT * FROM serie");
    $stmt->execute();
    $resultado = $stmt -> fetchAll();
    return $stmt->rowCount();
}

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $query_consulta .= " WHERE id LIKE '%". $search_value ."%' OR 
    serie LIKE '%". $search_value ."%'
    ";
}

if(isset($_POST['order'])){
	$column = $_POST["order"]["0"]["column"];
	$order = $_POST["order"][0]["dir"];
	$query_consulta .= " ORDER BY ". $column . " " . $order . " ";
}
else{
	$query_consulta .= " ORDER BY id ASC";
}

if($_POST['length'] != -1){
	$start = $_POST['start'];
	$length = $_POST['length'];
	$query_consulta .= " LIMIT  ". $start ." , " . $length ;
}

$stmt = $conexion->prepare($query_consulta);
$stmt->execute();
$resultado = $stmt->fetchAll();
$datos = array();
$filtered_rows = $stmt->rowCount();

foreach($resultado as $fila){
    $sub_array = array();
    $sub_array[] = $fila['id'];
    $sub_array[] = $fila['tipo_serie'];
    $sub_array[] = $fila['serie'];
    $sub_array[] = $fila['numero_inicio'];
    $sub_array[] = $fila['correlativo'];
    if ($fila['estado'] == 1) {
        $sub_array[] = '<button type="button" class="btn btn-success btn-sm status-btn">Activo</button>';
    } else {
        $sub_array[] = '<button type="button" class="btn btn-danger btn-sm status-btn">Inactivo</button>';
    }
    $sub_array[] = '<button type="button" name="editar" class="btn btn-warning btn-sm editar text-center" id="'.$fila["id"].'" > <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
    <button type="button" name="borrar" class="btn btn-danger btn-sm borrar" id="'.$fila["id"].'" > <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></button>
    <button type="button" name="ver" class="btn btn-info btn-sm ver" id="'.$fila["id"].'" > <i class="fa-solid fa-eye" style="color: #ffffff;"></i></button>';
    $datos[] = $sub_array;
}

$salida = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' => $filtered_rows,
	'recordsFiltered'=> obtener_todo_registros(),
	'data'=> $datos
);

echo  json_encode($salida);
?>