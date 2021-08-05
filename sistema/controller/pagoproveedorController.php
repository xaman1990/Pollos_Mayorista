<?php
session_start();

if ($_POST['action'] == 'obtenerpagoproveedor') {

  function obtenerpagoproveedor()
  {
    if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
      include "../../conexion.php";
      $fechavalidacionfil = $_POST['fechavalidacionfil'];
      $codproveedorfil = $_POST['codproveedorfil'];
      $query_precio = mysqli_query($conexion, "SELECT * FROM registropagoproveedor where estado='A' and fechapedido='$fechavalidacionfil' and codproveedor='$codproveedorfil'");

      $result = mysqli_num_rows($query_pagoproveedor);
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query_pagoproveedor);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }

  obtenerpagoproveedor();
  exit;
}
if ($_POST['action'] == 'Listarpagoproveedor') {

  function Listarpagoproveedor()
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
    $query = mysqli_query($conexion, "select pre.idprecio ,pro.proveedor,pre.preciocompra,sum(rc.totaldejabas) as totaldejabas,sum(rc.PesoNeto*pre.preciocompra) as MontoTotal,'' as Monto_Depositado,rc.fechapedido 
    from registrocuentas rc
    left join precio pre on rc.codproveedor=pre.codproveedor and rc.fechapedido=pre.fechavalidacion and pre.Estado='A'
    left join proveedor pro on pro.codproveedor=rc.codproveedor
    left join cliente cli on rc.idcliente=cli.idcliente
    where pre.idprecio IS not null 
    group by pro.proveedor,pre.preciocompra,rc.fechapedido
    order by fechapedido DESC ");

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
  Listarpagoproveedor();
  exit;
}
if ($_POST['action'] == 'Reportecuadre') {

  function Reportecuadre()
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
  Reportecuadre();
  exit;
}
