<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idpagos = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM registropagos WHERE idpagos = $idpagos");
    mysqli_close($conexion);
    header("location: lista_registropagos.php");
}
?>