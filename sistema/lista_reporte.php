<?php include_once "includes/header.php"; 



?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        
		<h1 class="h3 mb-0 text-gray-800">Reporte Pedido</h1>
		</button>
		</div>
	<div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>NombreProveedor</th>
							<th>C.JabaMacho</th>
							<th>C.JabaMixto</th>
							<th>C.Jabahembra</th>
                            <th>Total</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT  p.proveedor,SUM(r.CJabaMacho) AS CJabaMacho,SUM(r.CJabaMixto) AS CJabaMixto, SUM(r.CJabahembra) as CJabahembra, SUM(r.totaldejabas) AS totaldejabas FROM 
						pedidos r INNER JOIN proveedor p ON p.codproveedor=r.codproveedor
						GROUP BY p.proveedor");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['CJabaMacho']; ?></td>
									<td><?php echo $data['CJabaMixto']; ?></td>
									<td><?php echo $data['CJabahembra']; ?></td>
                                    <td><?php echo $data['totaldejabas']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
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
