<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol'])) {
        echo '<script>
        Swal.fire({
              type: "error",
              title: "¡Todos los campos son obligatorios!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_usuarios.php";
                }
            })
      </script>';
    } else {

        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol'];

        $query = mysqli_query($conexion, "SELECT * FROM usuario where correo = '$email'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,rol) values ('$nombre', '$email', '$user', '$clave', '$rol')");
            if ($query_insert) {
                echo '<script>
                Swal.fire({
                  type: "success",
                  title: "¡El precio fue creado!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                    window.location = "lista_usuarios.php";
                    }
                })
          </script>';
          } else {
          echo '<script>
                Swal.fire({
                  type: "error",
                  title: "¡Error al crear al precio!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                    window.location = "lista_usuarios.php";
                    }
                })
          </script>';
            }
        }
    }
}
?>

<!-- Begin Page Content -->
<div id="modalagregarusuario" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content" class="align-items-center">
    <!-- Page Heading -->
    <div class="modal-body">
  <div class="box-body">
          <div class="card-header bg-primary text-white">
            Registro Usuario
          </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" id="usuario">
                </div>
                <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="rol" id="rol" class="form-control">
                        <?php
                        $query_rol = mysqli_query($conexion, " select * from rol");
                        mysqli_close($conexion);
                        $resultado_rol = mysqli_num_rows($query_rol);
                        if ($resultado_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                                <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
                        <?php

                            }
                        }

                        ?>
                    </select></div>
                <input type="submit" value="Guardar Usuario" class="btn btn-primary">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>