<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Pedidos</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_pedido.php" class="btn btn-primary">Nuevo Pedido</a>
		<?php } ?>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
						    <th>id</th>
						    <th>NombreCliente</th> 
							<th>NombreProveedor</th>
							<th>Precio Diario</th>
							<th>C.JabaMacho</th>
							<th>C.JabaMixto</th>
							<th>C.Jabahembra</th>
							<th>Fecha de pedido</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT idpedido,c.idcliente ,p.codproveedor, p.proveedor, c.nombre ,r.codproveedor, r.PrecioDiario , r.CJabaMacho , r.CJabaMixto , r.CJabahembra , r.Fechapedido , r.Estado  FROM 
						cliente c  INNER JOIN pedidos r ON c.idcliente= r.idcliente INNER JOIN proveedor p ON p.codproveedor=r.codproveedor
						");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
								<td><?php echo $data['idpedido']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['PrecioDiario']; ?></td>
									<td><?php echo $data['CJabaMacho']; ?></td>
									<td><?php echo $data['CJabaMixto']; ?></td>
									<td><?php echo $data['CJabahembra']; ?></td>
									<td><?php echo $data['Fechapedido']; ?></td>
									<td><?php echo $data['Estado'];  ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_pedido.php?id=<?php echo $data['idpedido']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_pedido.php?id=<?php echo $data['idpedido']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
									<?php } ?>
								</tr>
						<?php }
						} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>