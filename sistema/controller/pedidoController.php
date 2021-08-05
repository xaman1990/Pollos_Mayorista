<?php
session_start();

if ($_POST['action'] == 'obtenerprecio') {

  function obtenerprecio()
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

  obtenerprecio();
  exit;
}
if ($_POST['action'] == 'ListarPedidos') {

  function ListarPedidos()
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
    $query = mysqli_query($conexion, "SELECT ped.idpedido,cli.nombre,pro.proveedor,ped.PrecioDiario,ped.CJabaMacho,ped.CJabaMixto,ped.CJabaHembra,ped.Fechapedido,ped.Estado
						FROM pedidos ped
						LEFT JOIN cliente cli ON ped.idcliente= cli.idcliente
						LEFT JOIN proveedor pro ON ped.codproveedor=pro.codproveedor
						WHERE ped.Estado='A' and +	 $where");

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
  ListarPedidos();
  exit;
}
if ($_POST['action'] == 'ReportePedidos') {

  function ReportePedidos()
  {
    $where = "ped.Estado='A'";


    if (!empty($_POST['fecha_de']) || !empty($_POST['fecha_a']) || !empty($_POST['cb_proveedor']) || !empty($_POST['cb_cliente'])) {
      $fecha_de = $_POST['fecha_de'];
      $fecha_a = $_POST['fecha_a'];
      $cb_Proveedor = $_POST['cb_proveedor'];
      $cb_cliente = $_POST['cb_cliente'];
      if ($fecha_de > $fecha_a) {
        $where = " ped.Estado='A' and ped.Fechapedido>='$fecha_de' and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') group by pro.proveedor,ped.fechapedido order by ped.fechapedido";
 
      } else if ($fecha_de == $fecha_a) {
        $where = " ped.Estado='A' and ped.Fechapedido='$fecha_de' and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') group by pro.proveedor,ped.fechapedido order by ped.fechapedido";
      } else {
        $f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
        $f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

        $where = " ped.Estado='A' and ped.Fechapedido BETWEEN '$fecha_de' AND '$fecha_a' and  and (ped.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='') and (ped.idcliente='$cb_cliente' or '$cb_cliente'='') group by pro.proveedor,ped.fechapedido order by ped.fechapedido";
        $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
      }
    } else if (empty($_POST['fecha_de']) && empty($_POST['fecha_a']) && empty($_POST['cb_proveedor']) && empty($_POST['cb_cliente'])) {
      $where = " ped.Estado='A' group by pro.proveedor,ped.fechapedido order by ped.fechapedido";
    }

    include "../../conexion.php";
    $query = mysqli_query($conexion, "SELECT pro.proveedor,sum(ped.CJabaMacho) as jabamacho,sum(ped.CJabaMixto) as jabamixto,sum(ped.CJabaHembra) as jabahembra,ped.fechapedido
    FROM pedidos ped
    LEFT JOIN cliente cli ON ped.idcliente= cli.idcliente
    LEFT JOIN proveedor pro ON ped.codproveedor=pro.codproveedor
    WHERE   + $where");

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
  ReportePedidos();
  exit;
}