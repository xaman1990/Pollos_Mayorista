<?php
function obtenerprecio()
{
  if (!empty($_POST['fechavalidacionfil']) || !empty($_POST['codproveedorfil']) || !empty($_POST['idcliente'])) {
    include "../../conexion.php";
    $fechavalidacionfil = $_POST['fechavalidacionfil'];
    $codproveedorfil = $_POST['codproveedorfil'];
    $idcliente=$_POST['idcliente'];
    $query_precio = mysqli_query($conexion, "SELECT pre.PrecioVentaF-cli.puntos as PrecioVentaF FROM precio pre join cliente cli on cli.Estado='A'  and pre.fechavalidacion='$fechavalidacionfil' and pre.codproveedor='$codproveedorfil' and cli.idcliente='$idcliente'");
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