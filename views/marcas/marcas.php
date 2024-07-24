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
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-marcas">
                            NUEVA MARCA
                        </button>
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
                            <table class="table table-striped table-hover" id="tblmarcas">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Marca</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $cont = 1;
                                    foreach ($data["resultado"] as $row) : ?>
                                        <tr>
                                            <td> <?php echo $cont++; ?></td>
                                            <td> <?php echo $row["nombreMarca"]; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-marcas" onclick="varMarcaID(<?php echo $row['idMarca'] ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a href="" data-href="administrador.php?c=MarcaController&a=eliminar&id=<?php echo $row["idMarca"]; ?>" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-eliminar" title="Eliminar Marca">
                                                    <i class="fas fa-trash"></i></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>
                            </p>
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

<!-- modales de operaciones crud-->
<div class="modal form-modal" id="modal-marcas" data-backdrop="static" data-keyboard="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="md-title">Registrar marcas</h4>
            </div>
            <form action="#" id="formmarcas" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="lblMarca" class="col-sm-4 col-form-label text-right">Marca:</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtMarca" id="txtMarca" class="form-control">
                            <p id="errorControl" style="color:red"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-secondary" style="padding-left:30px; padding-right:30px"> CANCELAR </a>
                    <button type="button" class="btn btn-success" id="btnRegistrar" data-dismiss="modal" onclick="registrarDatos()"> REGISTRAR DATOS</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- modal para eliminar registro-->
<div class="modal fade" id="modal-eliminar" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <p>¿Estás seguro de eliminar este registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary active" data-dismiss="modal">CANCELAR</button>
                <a href="" type="button" class="btn btn-danger active  btn-Confirmar">CONFIRMAR</a>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-confirmacion" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Alerta</h5>
            </div>
            <div class="modal-body ">
                <p id="pConfirmacion"></p>
            </div>
            <div class="modal-footer">
                <a href="administrador.php?c=MarcaController" type="button" class="btn btn-success active  btn-Confirmar">ACEPTAR</a>
            </div>
        </div>
    </div>
</div>


<script>
    function registrarDatos() {
        $.ajax({
            url: '../views/administrador.php?c=MarcaController&a=registrar',
            type: 'POST',
            data: $("#formmarcas").serialize(),
            success: function(response) {
                var jsonData = JSON.parse(response);
                //console.log(jsonData);
                if (jsonData.statusCode == 200) {
                    $("#modal-confirmacion").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#pConfirmacion").text('Datos registrados correctamente');
                    //alert("Datos registrados correctamente");
                    //window.location.href = 'index.php?c=MarcaController';
                } else if (jsonData.statusCode == 500) {
                    $("#modal-marcas").modal('show');
                    $("#errorControl").text(jsonData.errores['marca']);
                    //console.log(jsonData);
                }
            },
            error: function() {
                alert('Error inesperado al procesar el formulario');
            }
        });
    }

    function varMarcaID(id) {
        $("#md-title").text("Actualizar Marcas");
        $("#btnRegistrar").text("ACTUALIZAR DATOS");
        $.ajax({
            url: '../views/administrador.php?c=MarcaController&a=varMarcaID&id=' + id,
            type: 'post',
            success: function(response) {
                var jsonData = JSON.parse(response);
                $("#txtMarca").val(jsonData.marca.nombreMarca);
                $("#btnRegistrar").attr("onclick", "actualizarMarcaID(" + jsonData.marca.idMarca + ")");
                //console.log(jsonData);
            },
            error: function() {
                alert("Error inesperado");
            }
        });
    }

    function actualizarMarcaID(id) {
        $.ajax({
            url: '../views/administrador.php?c=MarcaController&a=actualizar&id=' + id,
            type: 'post',
            data: $("#formmarcas").serialize(),
            success: function(response) {
                var jsonData = JSON.parse(response);
                if (jsonData.statusCode == 200) {
                    $("#modal-confirmacion").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#pConfirmacion").text('Datos actualizados correctamente');
                    //alert("Datos actualizados correctamente");
                    //window.location.href = 'index.php?c=MarcaController';
                } else if (jsonData.statusCode == 500) {
                    $("#modal-marcas").modal('show');
                    $("#errorControl").text(jsonData.errores['marca']);
                    console.log(jsonData);
                }
            },
            error: function() {
                alert("Error inesperado");
            }
        });
    }
</script>