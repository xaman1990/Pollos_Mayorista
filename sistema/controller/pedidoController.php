<?php
function obtenerprecio()
{
  if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil'])) {
    include "../../conexion.php";
    $fechavalidacionfil = $_POST['fechavalidacionfil'];
    $codproveedorfil = $_POST['codproveedorfil'];
    $query_precio = mysqli_query($conexion, "SELECT * FROM precio where estado='A' and fechavalidacion='$fechavalidacionfil' and codproveedor='$codproveedorfil'");
    mysqli_close($conexion);
    $result = mysqli_num_rows($query_precio);
    if ($result > 0) {
    $data = mysqli_fetch_assoc($query_precio);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
    }
  }else{
        $data = [ 'error' => 'err' ];
      echo json_encode($data);
  }
}

obtenerprecio();
?>