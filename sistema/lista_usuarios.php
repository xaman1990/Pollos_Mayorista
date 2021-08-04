<?php include_once "includes/header.php";

?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro Usuario</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarusuario" style="float:right">
			Nuevo Usuario
		</button>
	</div>
	<div>
		<h5> Listar </h5>
		<button id="Listar_Usuarios" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-ListarUsuarios" style="display: none;" class="table-responsive">
				<div id="list-ListarUsuarios" style="width: 100%;">
					<table id="tb-ListarUsuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>ID</th>
								<th>NOMBRE</th>
								<th>CORREO</th>
								<th>USUARIO</th>
								<th>Rol</th>
								<th>ACCIONES</th>
							</tr>
						</thead>

						<tbody>
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
<?php include_once "registro_usuario.php"; ?>
<script>
	$(document).ready(function() {

		var oListarUsuarios;
		$(Load);

		function Load() {

			InitButtons();
			ListarUsuarios();

		}

		function InitButtons() {

			$('#Listar_Usuarios').click(ListarUsuarios);

		}

		function ListarUsuarios() {

			if (typeof oListarUsuarios === 'undefined') {

				ConstruirTablaListarRegistros();
				$('#table-ListarUsuarios').removeAttr('style');
			} else {
				oListarUsuarios.draw();

				$('#table-ListarUsuarios').removeAttr('style');
				$("#tb-ListarUsuarios").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "ListarUsuarios";
			var errorAjax = '';

			oListarUsuarios = $('#tb-ListarUsuarios').DataTable({
				ajax: {
					url: 'controller/usuariosController.php',
					type: "POST",
					dataType: "json",
					destroy: true,
					error: errorAjax,
					data: {
						//parametros
						action: action
					},

				},
				success: function(response) {
					if (response == 0) {

					} else {
						var data = JSON.parse(response);
					}

				},
				rowCallback: function(row, data, index) {
					$('td', row).eq(5).html('<a href="editar_usuario.php?id=' + data.idusuario + '" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a><form action="eliminar_usuario.php?id=' + data.idusuario + '" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');

				},
				order: [
					[0, "desc"]
				],
				columns: [{
						data: 'idusuario'
					},
					{
						data: 'nombre'
					},
					{
						data: 'correo'
					},
					{
						data: 'usuario'
					},
					{
						data: 'rol'
					},
					{

						data: null
					}
				]

			});

		}
	});
</script>