<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idregistro = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM registrocuentas WHERE idregistro  = $idregistro ");
    mysqli_close($conexion);
    header("location: lista_registrocuenta.php");
}
?>