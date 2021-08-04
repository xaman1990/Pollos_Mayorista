<?php
session_start();

if ($_POST['action'] == 'obtenercuenta') {

  function obtenercuenta()
  {
    if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
      include "../../conexion.php";
      $fechavalidacionfil = $_POST['fechavalidacionfil'];
      $codproveedorfil = $_POST['codproveedorfil'];
      $query_precio = mysqli_query($conexion, "SELECT * FROM registrocuentas where estado='A' and fechapedido='$fechavalidacionfil' and codproveedor='$codproveedorfil'");

      $result = mysqli_num_rows($query_cuenta);
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query_cuenta);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
      }
    } else {
      $data = ['error' => 'err'];
      echo json_encode($data);
    }
  }
  obtenercuenta();
  exit;
}
if ($_POST['action'] == 'ListarCuentas') {

  function ListarCuentas()
  {
    $whereRC = "";
    $whereP = "";
    if (!empty($_POST['fecha_de']) || !empty($_POST['fecha_a']) || !empty($_POST['cb_proveedor']) || !empty($_POST['cb_cliente'])) {
      $fecha_de = $_POST['fecha_de'];
      $fecha_a = $_POST['fecha_a'];
      $cb_Proveedor = $_POST['cb_proveedor'];
      $cb_cliente = $_POST['cb_cliente'];
      if ($fecha_de > $fecha_a) {
      } else if ($fecha_de == $fecha_a) {
        $whereRC = "  VRC.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (VRC.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (VRC.idcliente='$cb_cliente' or '$cb_cliente'='') ";
        $whereP = "  ped.fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') ";  
      } else {
        $f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
        $f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));
        $whereRC = "   VRC.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (VRC.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (VRC.idcliente='$cb_cliente' or '$cb_cliente'='')";
        $whereP = "   ped.fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y')  and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='')";
        $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
      }
    } else if (empty($_POST['fecha_de']) && empty($_POST['fecha_a']) && empty($_POST['cb_proveedor']) && empty($_POST['cb_cliente'])) {
      $whereRC = "VRC.estado='A'";
      $whereP = "";
    }
    include "../../conexion.php";
    $query = mysqli_query($conexion, "select  *  from (SELECT rc.idregistro, rc.idpedido, cli.nombre ,rc.idcliente, pro.proveedor,rc.codproveedor,rc.totaldejabas,rc.TotalDestare AS TotalDestare , rc.preciodiario,rc.PesoNeto, ifnull(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,case when rc.idregistro is not null then 'Entregado' END as EstadoFlujo,rc.estado, rc.fechapedido
    FROM registrocuentas  rc  LEFT JOIN pedidos ped ON  rc.idpedido=ped.idpedido
  LEFT JOIN cliente cli ON cli.idcliente=rc.idcliente
  LEFT JOIN proveedor pro ON pro.codproveedor=rc.codproveedor 
  where ped.idpedido is null and rc.estado='A'
  UNION 
  SELECT IFNULL(rc.idregistro,0) as idregistro , ped.idpedido, cli.nombre,ped.idcliente , pro.proveedor,ped.codproveedor,ped.totaldejabas,ped.totaldejabas*pro.pesojaba AS TotalDestare , ped.preciodiario,IFNULL(rc.PesoNeto,0), IFNULL(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,case when rc.idregistro is null then 'Pendiente de Entrega' ELSE 'Entregado' end as EstadoFlujo,ped.estado, ped.fechapedido 
   FROM pedidos ped 
   LEFT JOIN registrocuentas rc ON  ped.idpedido=rc.idpedido
                           LEFT JOIN  cliente cli ON cli.idcliente=ped.idcliente
                           LEFT JOIN proveedor pro ON pro.codproveedor=ped.codproveedor
                where ped.estado='A' ) as VRC where estado='A' and +$whereRC");
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
  ListarCuentas();
  exit;
}
if ($_POST['action'] == 'Reportecuenta') {

  function Reportecuenta()
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
  Reportecuenta();
  exit;
}
