<?php
session_start();

if ($_POST['action'] == 'Reportecuadreyugoslabia') {

  function Reportecuadreyugoslabia()
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
  Reportecuadreyugoslabia();
  exit;
}
