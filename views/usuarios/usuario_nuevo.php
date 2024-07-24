<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $data["titulo"]; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">.
        <?php error_reporting(0);?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="administrador.php?c=UsuarioController&a=registrar" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombres</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtNombres" value="<?php echo $_REQUEST["txtNombres"]?>">
                                        <?php if (isset($data["errores"]["nombreEmpleado"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["nombreEmpleado"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Apellidos:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtApellidos" value="<?php echo $_REQUEST["txtApellidos"]?>">
                                        <?php if (isset($data["errores"]["apellidoEmpleado"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["apellidoEmpleado"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">DNI:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtDNI" value="<?php echo $_REQUEST["txtDNI"]?>">
                                        <?php if (isset($data["errores"]["idEmpleado"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["idEmpleado"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Contraseña:</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" name="txtPassword" value="<?php echo $_REQUEST["txtPassword"]?>">
                                        <?php if (isset($data["errores"]["Contraseña"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["Contraseña"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Imagen:</label>
                                    <div class="col-sm-5">
                                        <input type="file" name="imagen">
                                        <?php if (isset($data["errores"]["imagen"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["imagen"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Estado:</label>
                                    <div class="col-sm-5">
                                        <select name="cboEstado" class="form-control">
                                            <option value="0"> Inactivo</option>
                                            <option value="1"> Activo</option>
                                        </select>
                                        <?php if (isset($data["errores"]["estado"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["estado"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Tipo:</label>
                                    <div class="col-sm-5">
                                        <select name="cboTipo" class="form-control">
                                            <option value="001"> Administrador</option>
                                            <option value="002"> Mozo</option>
                                            <option value="003"> Cajero</option>
                                        </select>
                                        <?php if (isset($data["errores"]["idTipoEmpleado"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["idTipoEmpleado"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="administrador.php?c=UsuarioController" class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="REGISTRAR USUARIO" class="btn btn-success" name="btnEnviar">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>