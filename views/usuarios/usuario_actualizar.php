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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body"> 
                            <form action="../views/administrador.php?c=UsuarioController&a=actualizar" method="POST" autocomplete="off" enctype="multipart/form-data">

                                <input type="hidden" class="hidden" name="txtIdUsuario" value="<?php echo $data["consulta"]["idEmpleado"]; ?>"><br>
                                <input type="hidden" class="hidden" name="txtFile" value="<?php echo $data["consulta"]["imagen"]; ?>"><br>


                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombres</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtNombres" value="<?php echo isset($_REQUEST['txtNombres']) ? $_REQUEST['txtNombres'] : $data["consulta"]["nombreEmpleado"]; ?>">
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
                                        <input type="text" class="form-control" name="txtApellidos" value="<?php echo isset($_REQUEST['txtApellidos']) ? $_REQUEST['txtApellidos'] : $data["consulta"]["apellidoEmpleado"]; ?>">
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
                                        <input type="text" class="form-control" readonly name="txtDNI" value="<?php echo $data["consulta"]["idEmpleado"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Contraseña:</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" name="txtPassword" value="<?php echo isset($_REQUEST['txtPassword']) ? $_REQUEST['txtPassword'] : $data["consulta"]["Contraseña"]; ?>">
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
                                            <?php
                                            
                                            ?>
                                            <option value="0" <?php echo ($data["consulta"]["estado"] == 0) ? "selected" : ""; ?>> Inactivo</option>
                                            <option value="1" <?php echo ($data["consulta"]["estado"] == 1) ? "selected" : ""; ?>> Activo</option>
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
                                            <option value="001" <?php echo ($data["consulta"]["idTipoEmpleado"] == 001) ? "selected" : ""; ?>>Administrador</option>
                                            <option value="002" <?php echo ($data["consulta"]["idTipoEmpleado"] == 002) ? "selected" : ""; ?>> Mozo</option>
                                            <option value="003" <?php echo ($data["consulta"]["idTipoEmpleado"] == 003) ? "selected" : ""; ?>> Cajero</option>
                                        </select>
                                        <?php if (isset($data["errores"]["tipo"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["tipo"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Fecha Registro:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" readonly name="txtFechRegistro" value="<?php echo $data["consulta"]["fecha_registro"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="administrador.php?c=UsuarioController" class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="ACTUALIZAR DATOS" class="btn btn-success" name="btnEnviar">
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