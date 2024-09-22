<?php

include("../config/conexion.php");

// Consulta SQL y ejecucion y guardado del resultado 
$query_consulta = "";
$salida = array();
$query_consulta = "SELECT * FROM lista_producto_item";

// $resultado = mysqli_query($conexion, $consulta);
// $total_rows = mysqli_num_rows($resultado);
function obtener_todo_registros(){
    include("../config/conexion.php");
    $stmt = $conexion->prepare("SELECT * FROM lista_producto_item");
    $stmt->execute();
    $resultado = $stmt -> fetchAll();
    return $stmt->rowCount();
}

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $query_consulta .= " WHERE id_producto_item LIKE '%". $search_value ."%' OR 
    nombre_producto LIKE '%". $search_value ."%' OR 
    serie LIKE '%". $search_value ."%'
    ";
}

if(isset($_POST['order'])){
	$column = $_POST["order"]["0"]["column"];
	$order = $_POST["order"][0]["dir"];
	$query_consulta .= " ORDER BY ". $column . " " . $order . " ";
}
else{
	$query_consulta .= " ORDER BY id_producto_item DESC ";
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
    $sub_array[] = $fila['id_producto_item'];
    $sub_array[] = $fila['fecha_hora_registro'];
    $sub_array[] = $fila['nombre_producto']; 
    $sub_array[] = $fila['id_compra']; 
    $sub_array[] = $fila['serie']; 
    $sub_array[] = $fila['tipo_estado'];
    $sub_array[] = '<button type="button" name="editar" class="btn btn-warning btn-sm editar text-center" id="'.$fila["id_producto_item"].'" > Editar</button>
    <button type="button" name="borrar" class="btn btn-danger btn-sm borrar" id="'.$fila["id_producto_item"].'" > Borrar</button>
    <button type="button" name="ver" class="btn btn-info btn-sm ver" id="'.$fila["id_producto_item"].'" > Ver</button>';
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