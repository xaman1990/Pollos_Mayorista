<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Registro de Pagos</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<?php } ?>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>id</th>
							<th>Nombre Cliente</th>
							<th>Nombre Proveedor</th>
							<th>Precio Diario</th>
							<th>Total jaba</th>
							<th>Monto Total</th>
							<th>Saldo Pendiente</th>
							<th>Fecha de pedido</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
								<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT rc.idregistro,IFNULL(rp.idpagos,0) as idpagos,c.nombre , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar,'' as pendiente, rc.fechapedido, rc.Estado 
						FROM registrocuentas rc 
						LEFT JOIN registropagos rp ON rc.idregistro=rp.Id_RegistroCuentas 
						LEFT JOIN cliente c ON c.idcliente=rc.idcliente LEFT JOIN proveedor p ON p.codproveedor=rc.codproveedor
						");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idregistro']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['preciodiario']; ?></td>
									<td><?php echo $data['totaldejabas']; ?></td>
									<td><?php echo $data['montoacobrar']; ?></td>
									<td><?php echo $data['pendiente']; ?></td>
									<td><?php echo $data['fechapedido']; ?></td>
									<td><?php echo $data['Estado'];  ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
										<td>
											<a href="editar_registropagos.php?id=<?php echo $data['idregistro']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Registrar Pago</a>
											<form action="eliminar_registropagos.php?id=<?php echo $data['idregistro']; ?>" method="post" class="confirmar d-inline">
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