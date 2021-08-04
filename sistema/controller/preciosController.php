<?php
session_start();

if ($_POST['action'] == 'obtenerprecios') {

  function obtenerprecios()
  {
    if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
      include "../../conexion.php";
      $fechavalidacionfil = $_POST['fechavalidacionfil'];
      $codproveedorfil = $_POST['codproveedorfil'];
      $query_precio = mysqli_query($conexion, "SELECT * FROM precio where estado='A' and fechavalidacion='$fechavalidacionfil' and codproveedor='$codproveedorfil'");

      $result = mysqli_num_rows($query_precio);
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query_precio);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }

  obtenerprecios();
  exit;
}
if ($_POST['action'] == 'Listarprecios') {

  function Listarprecios()
  {
    $where = "r.Estado='A'";
$fecha_de = "";
$fecha_a = "";

if (!empty($_REQUEST['fecha_de']) || !empty($_REQUEST['fecha_a'])) {
	$fecha_de = $_REQUEST['fecha_de'];
	$fecha_a = $_REQUEST['fecha_a'];
	if ($fecha_de > $fecha_a) {
    $where = " r.fechavalidacion='$fecha_de' and r.Estado='A'";
	} else if ($fecha_de == $fecha_a) {
		$where = " r.fechavalidacion='$fecha_de' and r.Estado='A'";
	} else {
		$f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
		$f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

		$where = " r.fechavalidacion BETWEEN '$fecha_de', '%m/%d/%Y') AND '$fecha_a' and r.Estado='A'";
		$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
	}
} else if (empty($_REQUEST['fecha_de']) || empty($_REQUEST['fecha_a'])) {
	$where = "r.Estado='A'";
}

    include "../../conexion.php";
    $query = mysqli_query($conexion, "SELECT r.idprecio,  p.codproveedor , p.proveedor , r.preciocompra , r.precioVenta , r.SubidaInterna , r.PrecioVentaF , r.FechaCreacion , r.Estado,r.fechavalidacion FROM  precio r  INNER JOIN  proveedor p ON p.codproveedor= r.codproveedor WHERE r.Estado='A' and + $where");

    $result = mysqli_num_rows($query);
    if ($result > 0) {
      while($row = mysqli_fetch_assoc($query)) {
        $array[] = $row;
      }
      $dataset = array(
        "echo" => 1,
        "totalrecords" => count($array),
        "totaldisplayrecords" => count($array),
        "data" => $array
    );
    
      ///aaaaaa
      
      echo json_encode($dataset, JSON_UNESCAPED_UNICODE);
      exit;
    } else {
      
      $data = ['error' => 'No hay registros'];
      echo json_encode($data);
    }
  }
  Listarprecios();
  exit;
}
