<?php include_once "includes/header.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro pedido</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarpedido" style="float:right">
			Nuevo Pedido
		</button>

	</div>
	<div>
		<label>DE: </label>
		<input type="text" name="fecha_de" id="fecha_de" class="datepicker" >
		<label> A </label>
		<input type="text" name="fecha_a" id="fecha_a" class="datepicker" >


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

		<label for="nombre">Cliente</label>
		<?php
		include "../conexion.php";
		$query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente where estado='A' ORDER BY nombre ASC");
		$resultado_cliente = mysqli_num_rows($query_cliente);
		mysqli_close($conexion);
		?>
		<select id="cb_cliente" name="cb_cliente">
			<option value="">Ninguno</option>
			<?php
			if ($resultado_cliente > 0) {
				while ($cliente = mysqli_fetch_array($query_cliente)) {
					// code...
			?>
					<option value="<?php echo $cliente['idcliente']; ?>"><?php echo $cliente['nombre']; ?></option>
			<?php
				}
			}
			?>
		</select>

		<button id="Listar_Pedidos" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
		<a href="lista_reporte.php" class="btn btn-primary">Reporte de pedidos</a>

	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-ListarPedidos" style="display: none;" class="table-responsive">
				<div id="list-ListarPedidos" style="width: 100%;">
					<table id="tb-ListarPedidos" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
								<th></th>								
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
<?php include_once "registro_pedido.php"; ?>
<script>
	$(document).ready(function() {

		var oListarPedidos;
		var oListaRegistros;
		$(Load);

		function Load() {
			InitButtons();
			ListarPedidos();

		}

		function InitButtons() {

			$('#Listar_Pedidos').click(ListarPedidos);
		}


		function ListarPedidos() {

			if (typeof oListarPedidos === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-ListarPedidos').removeAttr('style');
			} else {
				oListarPedidos.draw();
				$('#table-ListarPedidos').removeAttr('style');
				$("#tb-ListarPedidos").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "ListarPedidos";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oListarPedidos = $('#tb-ListarPedidos').DataTable({
				ajax: {
					url: 'controller/pedidoController.php',
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
				},
				rowCallback: function(row, data, index) {
						$('td', row).eq(9).html('<a href="editar_pedido.php?id='+ data.idpedido+'" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a><form action="eliminar_pedido.php?id='+data.idpedido+'" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');
									},
				order: [[ 0, "desc" ]],
				columns: [{
						data: 'idpedido'
					},
					{
						data: 'nombre'
					},
					{
						data: 'proveedor'
					},
					{
						data: 'PrecioDiario'
					},
					{
						data: 'CJabaMacho'
					},
					{
						data: 'CJabaMixto'
					},
					{
						data: 'CJabaHembra'
					},
					{
						data: 'Fechapedido'
					},
					{
						data: 'Estado'
					},
					{
						data: null
					}
				]

			});
		}
	});
</script>