<?php include_once "includes/header.php";


?>

<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro de pagos Proveedor</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarpagoproveedor" style="float:right">
			Nuevo pago Provedor
		</button>

	</div>
	<div>


		<label>DE: </label>
		<input type="text" class="datepicker" name="fecha_de" id="fecha_de" >
		<label> A </label>
		<input type="text" class="datepicker" name="fecha_a" id="fecha_a" >


		<label for="nombre">Proveedor</label>
		<?php
		include "../conexion.php";
		$query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor where estado='A' ORDER BY proveedor ASC");
		$resultado_proveedor = mysqli_num_rows($query_proveedor);
		?>

		<select id="cb_proveedor" name="cb_proveedor">
			<option value="">Ninguno</option>
			<?php
			if ($resultado_proveedor > 0) {
				while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					// code...
					if ($resultado_tipoproveedor > 0) {
			?>
						<option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
					<?php
					} else {
					?>
						<option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
			<?php
					}
				}
			}
			?>
		</select>
		<button id="Listar_pagoproveedor" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-Listarpagoproveedor" style="display: none;" class="table-responsive">
				<div id="list-Listarpagoproveedor" style="width: 100%;">
					<table id="tb-Listarpagoproveedor" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead class="thead-dark">
							<tr>

							<th>id</th>
							<th>NombreProveedor</th>
							<th>Precio Compra Diario</th>
							<th>Total Jabas</th>
                            <th>Monto Total</th>
                            <th>Monto depositado</th>
							<th>Fecha de pedido</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
							</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
			</div>





		</div>
	</div>


</div>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
<?php include_once "registro_registropagoproveedor.php"; ?>
<script>
	$(document).ready(function() {

		var oListarpagoproveedor;
		var oListaRegistros;
		$(Load);

		function Load() {
			InitButtons();
			Listarpagoproveedor();

		}

		function InitButtons() {

			$('#Listar_pagoproveedor').click(Listarpagoproveedor);


		}


		function Listarpagoproveedor() {

			if (typeof oListarpagoproveedor === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-Listarpagoproveedor').removeAttr('style');
			} else {
				oListarpagoproveedor.draw();
				$('#table-Listarpagoproveedor').removeAttr('style');
				$("#tb-Listarpagoproveedor").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "Listarpagoproveedor";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oListarCuentas = $('#tb-Listarpagoproveedor').DataTable({
				ajax: {
					url: 'controller/pagoproveedorController.php',
					type: "POST",
					dataType: "json",
					destroy: true,
					error: errorAjax,
					data: {
						//parametros
						action: action,
						fecha_de: fecha_de,
						fecha_a: fecha_a,
						cb_proveedor: cb_proveedor,
						cb_cliente: cb_cliente
					},

				},
				success: function(response) {
					if (response == 0) {

					} else {
						var data = JSON.parse(response);
					}
					//var info = JSON.parse(response);
					//console.log(info); console.log("HERE : ", response)

				},
				rowCallback: function(row, data, index) {

					
					$('td', row).eq(7).html('<a href="editar_registropagoproveedor.php?idpagoproveedor=' + data.idpagoproveedor + '&idpagoproveedor=' + data.idpagoproveedor + '" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a><form action="eliminar_registropagoproveedor.php?id=' + data.idpagoproveedor + '" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');



				},
				columns: [{

						data: 'idprecio'
					},
					{
						data: 'proveedor'
					},
					{
						data: 'preciocompra'
					},
					{
						data: 'totaldejabas'
					},
					{
						data: 'MontoTotal'
					},
					{
						data: 'Monto_Depositado'
					},

					{
						data: 'fechapedido'
					},
					{
						data: null
					}
				]

			});



		}



	});
</script>