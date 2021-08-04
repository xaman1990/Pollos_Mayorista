<?php
session_start();
if ($_POST['action'] == 'ListarUsuarios') {
  function ListarUsuarios()
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
  ListarUsuarios();
  exit;
}
