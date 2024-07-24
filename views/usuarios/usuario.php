    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1 class="m-0"><?php echo $data["titulo"]; ?></h1>
                    </div><!-- /.col -->

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
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="administrador.php?c=UsuarioController&a=nuevo"
                                    class="btn btn-success">NUEVO REGISTRO</a></li>
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
                                <p class="card-text">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover " id="tbl-Usuarios">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>nombres</th>
                                                    <th>apellidos</th>
                                                    <th>usuario</th>
                                                    <th>imagen</th>
                                                    <th>estado</th>
                                                    <th>tipo</th>
                                                    <th>fecha_registro</th>
                                                    <th>fecha_edicion</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data["resultado"] as $row) : ?>
                                                <tr>
                                                    <td> <?php echo $row["nombreEmpleado"]; ?></td>
                                                    <td> <?php echo $row["apellidoEmpleado"]; ?></td>
                                                    <td> <?php echo $row["Usuario"]; ?> </td>
                                                    <td> <img src="../public/users/<?php echo $row["imagen"]; ?>" width="50"
                                                            height="50"></td>
                                                    <td>
                                                        <?php 
                                                        if ($row["estado"] == 1) {
                                                            echo "Activo";
                                                        } else {
                                                            echo "Inactivo";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if ($row["idTipoEmpleado"] == 001) {
                                                            echo "Administrador";
                                                        } elseif ($row["idTipoEmpleado"] == 002) {
                                                            echo "Mozo";
                                                        } else {
                                                            echo "Cajero";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td> <?php echo $row["fecha_registro"]; ?></td>
                                                    <td> <?php echo $row["fecha_edicion"]; ?></td>
                                                    <td>
                                                        <?php if ($row["Usuario"] === '72112841' || $row["Usuario"] == $_SESSION["idEmpleado"]) : ?>
                                                        <!-- Botón de eliminar deshabilitado si el usuario es 'Admin' -->
                                                        <button class="btn btn-xs btn-danger" disabled><i
                                                                class="fas fa-trash"></i></button>
                                                        <a href="administrador.php?c=UsuarioController&a=verUsuario&id=<?php echo $row["Usuario"]; ?>"
                                                            class="btn btn-xs btn-warning"><i
                                                                class="fas fa-user-edit"></i></a>
                                                        
                                                        <button class="btn btn-xs btn-danger" disabled>
                                                            <i class="fas fa-power-off"></i>
                                                        </button>
                                                        <button class="btn btn-xs btn-success" disabled>
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <?php else : ?>
                                                        <!-- Botones habilitados para otros tipos de usuarios -->
                                                        <a href="#" class="btn btn-xs btn-danger deleteBtn"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            data-recordid="<?php echo $row["Usuario"]; ?>"><i
                                                                class="fas fa-trash"></i></a>
                                                        <a href="administrador.php?c=UsuarioController&a=verUsuario&id=<?php echo $row["Usuario"]; ?>"
                                                            class="btn btn-xs btn-warning"><i
                                                                class="fas fa-user-edit"></i></a>
                                                        
                                                        <a href="administrador.php?c=UsuarioController&a=DarBaja&id=<?php echo $row["Usuario"]; ?>"
                                                            class="btn btn-xs btn-danger"><i
                                                                class="fas fa-power-off"></i></a>
                                                        <a href="administrador.php?c=UsuarioController&a=Activar&id=<?php echo $row["Usuario"]; ?>"
                                                            class="btn btn-xs btn-success"><i
                                                                class="fas fa-check"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                </p>
                            </div>
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

    <!-- Modal para la confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a id="deleteRecordBtn" href="#" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                var userId = $(this).data('recordid');
                var deleteUrl = 'administrador.php?c=UsuarioController&a=eliminar&id=' + userId;
                $('#deleteRecordBtn').attr('href', deleteUrl);
            });
        });
    </script>