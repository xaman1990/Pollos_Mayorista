<?php
$connect = mysqli_connect("localhost", "root", "", "db_polleria");//Configurar los datos de conexion
$columns = array('codproveedor','proveedor', 'tipoproveedor', 'fechadecreacion', 'Estado', 'preciojaba','estado', 'usuario_id');

$query = "SELECT * FROM proveedor WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'fecha BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (id LIKE "%'.$_POST["search"]["value"].'%" 
  OR proveedor LIKE "%'.$_POST["search"]["value"].'%" 
  OR tipoproveedor LIKE "%'.$_POST["search"]["value"].'%" 
  OR preciojaba LIKE "%'.$_POST["search"]["value"].'%"
  OR estado LIKE "%'.$_POST["search"]["value"].'%")

 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $fecha=date("d/m/Y", strtotime($row["fecha"]));			
 $sub_array = array();
 $sub_array[] = $row["codproveedor "];
  $sub_array[] = $row["proveedor"];
 $sub_array[] = $row["tipoproveedor"];
 $sub_array[] = $row["preciojaba"];
 $sub_array[] = $row["Estado"];
 $sub_array[] = $fecha;
 
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM proveedor";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>