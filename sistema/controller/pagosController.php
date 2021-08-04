<?php
session_start();

if ($_POST['action'] == 'obtenerpagos') {

  function obtenerpagos()
  {
    if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
      include "../../conexion.php";
      $fechavalidacionfil = $_POST['fechavalidacionfil'];
      $codproveedorfil = $_POST['codproveedorfil'];
      $query_precio = mysqli_query($conexion, "SELECT * FROM registropagos where estado='A' and fechapedido='$fechavalidacionfil' and codproveedor='$codproveedorfil'");

      $result = mysqli_num_rows($query_pagos);
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query_pagos);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }

  obtenerpagos();
  exit;
}
if ($_POST['action'] == 'Listarpagos') {

  function Listarpagos()
  {
    $whereRC = "";
    $whereP = "";

    if (!empty($_POST['fecha_de']) || !empty($_POST['cb_proveedor']) || !empty($_POST['cb_cliente'])) {
      $fecha_de = $_POST['fecha_de'];
      $fecha_a = $_POST['fecha_a'];
      $cb_Proveedor = $_POST['cb_proveedor'];
      $cb_cliente = $_POST['cb_cliente'];
      if ($fecha_de > $fecha_a) {
        $whereRC = "  rc.fechapedido>= DATE_FORMAT('$fecha_de', '%m/%d/%Y')  and (rc.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (rc.idcliente='$cb_cliente' or '$cb_cliente'='') GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado";
        
      } else if ($fecha_de == $fecha_a ) {
        $whereRC = "  rc.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (rc.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (rc.idcliente='$cb_cliente' or '$cb_cliente'='') GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado";
        $whereP = "  ped.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') ";
  
      } else if (!empty($_POST['fecha_de']) && empty($_POST['fecha_a'])){
        $whereRC = "  rc.fechapedido>= DATE_FORMAT('$fecha_de', '%m/%d/%Y')  and (rc.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (rc.idcliente='$cb_cliente' or '$cb_cliente'='') GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado";
        

      } else {
        $f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
        $f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

        $whereRC = "   rc.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (rc.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (rc.idcliente='$cb_cliente' or '$cb_cliente'='' ) GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado";
        $whereP = "   ped.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='')";
      
        $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
      }
    } else if (empty($_POST['fecha_de']) && empty($_POST['fecha_a']) && empty($_POST['cb_proveedor']) && empty($_POST['cb_cliente'])) {
      $whereRC = " rc.estado='A' GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado";
      $whereP = "";
    }

    include "../../conexion.php";
    $query = mysqli_query($conexion, "SELECT rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre as cliente , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar,rc.montoacobrar-sum(ifnull(PagoaCuenta,0)) as Pendiente, rc.fechapedido as fechapedido , rc.Estado 
    FROM registrocuentas rc 
    LEFT JOIN registropagos rp ON rc.idregistro=rp.Id_RegistroCuentas 
    LEFT JOIN cliente c ON c.idcliente=rc.idcliente LEFT JOIN proveedor p ON p.codproveedor=rc.codproveedor  
    where + $whereRC 
    ");

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
  Listarpagos();
  exit;
}
