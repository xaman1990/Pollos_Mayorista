<?php include_once "includes/header.php"; 


$busqueda='';
$fecha_de='';
$fecha_a='';
 if (!empty($_REQUEST['busqueda'])){
   if(!is_numeric($_REQUEST['busqueda'])){
         header("location: lista_proveedor.php");
}

$busqueda = strtolower($_REQUEST['busqueda']);
$where="nofactura=$busqueda";
$buscar= "busqueda=$busqueda";
} 

if(!empty($_REQUEST['fecha_de']) && !empty($_REQUEST['fecha_a'])){
$fecha_de = $_REQUEST['fecha_de'];
$fecha_a = $_REQUEST['fecha_a'];

$buscar='';

if($fecha_de > $fecha_a){
header("location : lista_proveedores.php");
}else if ($fecha_de == $fecha_a) {


$where = "fecha LIKE '$fecha_de%'";
$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";

}else{
$f_de = $fecha_de.'00:00:00';
$f_a = $fecha_a.'23:59:59';
$where = "fecha BETWEEN '$f_de' AND '$f_a'";
$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";


}
}







?>



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
		<a href="registro_proveedor.php" class="btn btn-primary">Nuevo</a>
		
	</div>
    <div>
<h5> buscar por fecha </h5>
<form action="lista_proveedor.php" method="get" class="form_search_date">
<label>DE: </label>
<input type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de;?>" required>
<label> A </label>	
<input type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a;?>" required>
<button type="submit" class="btn_view"><i class="fas fa-search" ></i></button>
</form>
</div>
    <br />
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
					<div class="table-responsive"  style="overflow-x: hidden;">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Tipo de proveedor</th>
							<th>Nombre de proveedor</th>
							<th>presojaba</th>
							<th>Fecha creacion</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, " SELECT  r.codproveedor ,  p.tipoproveedor, r.proveedor , r.preciojaba, r.fechadecreacion , r.Estado FROM proveedor r INNER JOIN tipoproveedor p ON r.tipoproveedor=p.idtipoproveedor");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['codproveedor']; ?></td>
									<td><?php echo $data['tipoproveedor']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['preciojaba']; ?></td>
									<td><?php echo $data['fechadecreacion']; ?></td>
									<td><?php echo $data['Estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" method="post" class="confirmar d-inline">
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