<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "UPDATE proveedor set estado='D'  WHERE codproveedor = $id");
    mysqli_close($conexion);
    header("location: lista_proveedor.php");
}
?>