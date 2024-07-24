<div class="content-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="content-heade">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h2 class="m-3">Perfil</h2>
                </div><!-- /.col -->
            </div>
            <div class="col-sm-4">
                    <?php
                    if (isset($_SESSION["mensaje"])) : // validamos si la variable mensaje de tipo sesión existe con el método isset()
                    ?>

                    <div id="alert-msj" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?php echo $_SESSION["mensaje"]; ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <script>
                        setTimeout(function () {
                            $('#alert-msj').fadeOut('fast');
                        }, 3000); // duración del alert. En este caso dura solo 3 segundos.
                    </script>
                    <?php unset($_SESSION["mensaje"]);
                    endif;   // con unset limpiamos los datos de las variables de tipo sesión
                    ?>
                </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3">
                    <div class="card">
                        <div class="card-body">
                            <center class="mt-4">
                                <!-- Cambiar mt-4 a mt-2 o eliminarlo -->
                                <img src="../public/users/<?php echo $_SESSION["imagen"]; ?>" class="img-circle"
                                    width="150" height="150">
                                <h4 class="mt-2"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"];?></h4>
                                <h6 class="card-subtitle"><?php echo $_SESSION["tipoEmpleado"];?></h6>

                            </center>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for= "txtNombre" class="col-md-12">Nombre</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly name="txtNombre" id="txtNombre"
                                        value="<?php echo $_SESSION["nombre"];?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtApellido" class="col-md-12">Apellidos</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly id="txtApellido" name="txtApellido"
                                        value="<?php echo $_SESSION["apellido"];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtDNI" class="col-md-12">DNI</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly id="txtDNI" name="txtDNI"
                                        value="<?php echo $_SESSION["DNI"];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fechIngreso" class="col-md-12">Fecha de Ingreso</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly id="fechIngreso" name="fechIngreso"
                                        value="<?php echo $_SESSION["fechaIngreso"];?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="administrador.php?c=PerfilController&a=cambiarContraseña" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" class="hidden" name="txtEmpleadoID" value="<?php echo $_SESSION["DNI"];?>"><br>
    
                            <div class="form-group">
                                    <label class="col-md-12">Nueva Contraseña</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="txtContraseña1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Repetir Contraseña</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="txtContraseña2">
                                        <?php if (isset($data["errores"]["Contraseña"])) : ?>
                                        <div style="color:red">
                                            <?php echo $data["errores"]["Contraseña"]?>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="float-sm-right">
                                        <button class="btn btn-success" name="btnEnviar">Actualizar Contraseña</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Column -->
            </div>
        </div>


    </div>

</div>