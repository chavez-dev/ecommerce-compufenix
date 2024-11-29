<?php

include("../../config/conexion.php");



// Consulta SQL y ejecucion y guardado del resultado 
$query_consulta = "";
$salida = array();
$query_consulta = "SELECT * FROM lista_productos ";

function obtener_todo_registros(){
    include("../../config/conexion.php");
    $stmt = $conexion->prepare("SELECT * FROM lista_productos");
    $stmt->execute();
    $resultado = $stmt -> fetchAll();
    return $stmt->rowCount();
}

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $query_consulta .= " WHERE id_producto LIKE '%". $search_value ."%' OR 
    nombre_producto LIKE '%". $search_value ."%' OR
    nombre_categoria LIKE '%". $search_value ."%' OR
    precio_unitario LIKE '%". $search_value ."%'
    ";
}

if(isset($_POST['order'])){
	$column = $_POST["order"]["0"]["column"];
	$order = $_POST["order"][0]["dir"];
	$query_consulta .= " ORDER BY ". $column . " " . $order . " ";
}
else{
	$query_consulta .= " ORDER BY id_producto DESC ";
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
    $imagen = '';
    if($fila["imagen"] != ''){
        $imagen = '<img src="' . $fila["imagen"] . '" class="img-thumbnail" width="90" height="70" /> ';
    }else{
        $imagen = '';
    }
    $sub_array = array();
    $sub_array[] = $fila['id_producto'];
    // $sub_array[] = $fila['imagen'];
    $sub_array[] = $imagen;
    $sub_array[] = $fila['nombre_producto'];
    $sub_array[] = $fila['modelo'];
    $sub_array[] = $fila['nombre_categoria'];
    // $sub_array[] = $fila['status'];
    // Verificar el valor de status y mostrar el botón correspondiente
    if ($fila['status'] == 1) {
        $sub_array[] = '<button type="button" class="btn btn-success btn-sm status-btn">Activo</button>';
    } else {
        $sub_array[] = '<button type="button" class="btn btn-danger btn-sm status-btn">Inactivo</button>';
    }
    $sub_array[] = $fila['precio_unitario'];
    $sub_array[] = $fila['stock'];
    $sub_array[] = '<button type="button" name="editar" class="btn btn-warning btn-sm editar text-center" id="'.$fila["id_producto"].'" > <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
    <button type="button" name="borrar" class="btn btn-danger btn-sm borrar" id="'.$fila["id_producto"].'" > <i class="fa-solid fa-ban" style="color: #ffffff;"></i></button>
    <button type="button" name="ver" class="btn btn-info btn-sm ver" id="'.$fila["id_producto"].'" > <i class="fa-solid fa-eye" style="color: #ffffff;"></i></button>';
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