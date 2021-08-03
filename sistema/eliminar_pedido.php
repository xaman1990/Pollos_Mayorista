<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idpedido = $_GET['id'];
    $query_delete = mysqli_query($conexion, "UPDATE pedidos set estado='D' WHERE idpedido = $idpedido");
    mysqli_close($conexion);
    header("location: lista_pedido.php");
}
?>