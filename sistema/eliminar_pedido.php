<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $idpedido = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM pedidos WHERE idpedido = $idpedido");
    mysqli_close($conexion);
    header("location: lista_pedido.php");
}
?>