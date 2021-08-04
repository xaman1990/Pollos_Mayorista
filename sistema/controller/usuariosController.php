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
if ($_POST['action'] == 'Listarusuarios') {

  function Listarusuarios()
  {
   
    include "../../conexion.php";
    $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol");

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
  Listarusuarios();
  exit;
}
