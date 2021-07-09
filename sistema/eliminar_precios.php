<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idprecio = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM precio WHERE idprecio = $idprecio");
    mysqli_close($conexion);
    header("location: lista_precios.php");
}
?>