<?php
session_start();

if ($_POST['action'] == 'obtenercuadre') {

  function obtenercuadre()
  {
    if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
      include "../../conexion.php";
      $fechavalidacionfil = $_POST['fechavalidacionfil'];
      $codproveedorfil = $_POST['codproveedorfil'];
      $query_precio = mysqli_query($conexion, "SELECT * FROM cuadre where estado='A' and fechapedido='$fechavalidacionfil' and codproveedor='$codproveedorfil'");

      $result = mysqli_num_rows($query_cuadre);
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query_cuadre);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }

  obtenercuadre();
  exit;
}
if ($_POST['action'] == 'Listacuadre') {

  function Listacuadre()
  {
    $whereRC = "";
    $whereP = "";

    if (!empty($_POST['fecha_de']) || !empty($_POST['fecha_a']) || !empty($_POST['cb_proveedor'])) {
      $fecha_de = $_POST['fecha_de'];
      $fecha_a = $_POST['fecha_a'];
      $cb_Proveedor = $_POST['cb_proveedor'];
      if ($fecha_de > $fecha_a) {
      } else if ($fecha_de == $fecha_a) {
        $whereRC = "  VRC.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (VRC.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') ";
        $whereP = "  ped.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') ";
  
      } else {
        $f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
        $f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

        $whereRC = "   VRC.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (VRC.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') ";
        $whereP = "   ped.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') ";
      
        $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
      }
    } else if (empty($_POST['fecha_de']) && empty($_POST['fecha_a']) && empty($_POST['cb_proveedor'])) {
      $whereRC = "VRC.estado='A'";
      $whereP = "";
    }

    include "../../conexion.php";
    $query = mysqli_query($conexion, "");

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
    
      
      
      echo json_encode($dataset, JSON_UNESCAPED_UNICODE);
      exit;
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }
  Listacuadre();
  exit;
}
if ($_POST['action'] == 'Reportepago') {

  function Reportepago()
  {
    $where = "ped.Estado='A'";


    if (!empty($_POST['fecha_de']) || !empty($_POST['fecha_a']) || !empty($_POST['cb_proveedor']) || !empty($_POST['cb_cliente'])) {
      $fecha_de = $_POST['fecha_de'];
      $fecha_a = $_POST['fecha_a'];
      $cb_Proveedor = $_POST['cb_proveedor'];
      $cb_cliente = $_POST['cb_cliente'];
      if ($fecha_de > $fecha_a) {
        $where = " ped.Fechapedido>='$fecha_de' and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') order by ped.idpedido desc";
 
      } else if ($fecha_de == $fecha_a) {
        $where = " ped.Fechapedido='$fecha_de' and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') order by ped.idpedido desc";
      } else {
        $f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
        $f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

        $where = " ped.Fechapedido BETWEEN '$fecha_de' AND '$fecha_a' and ped.Estado='A' and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') order by ped.idpedido desc";
        $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
      }
    } else if (empty($_POST['fecha_de']) && empty($_POST['fecha_a']) && empty($_POST['cb_proveedor']) && empty($_POST['cb_cliente'])) {
      $where = "ped.Estado='A' order by ped.idpedido desc";
    }

    include "../../conexion.php";
    $query = mysqli_query($conexion, "");

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
    
      
      
      echo json_encode($dataset, JSON_UNESCAPED_UNICODE);
      exit;
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }
  Reportepago();
  exit;
}
