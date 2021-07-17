<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "UPDATE cliente SET ESTADO='D' WHERE idcliente = $id");
    mysqli_close($conexion);
    header("location: lista_cliente.php");
}
?>