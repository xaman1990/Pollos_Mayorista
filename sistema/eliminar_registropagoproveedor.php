<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idpagoproveedor = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM registropagoproveedor WHERE idpagoproveedor = $idpagoproveedor");
    mysqli_close($conexion);
    header("location: lista_registropagoproveedor.php");
}
?>