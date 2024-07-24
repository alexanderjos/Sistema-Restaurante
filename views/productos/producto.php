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
                    if (isset($_SESSION["mensaje"])) :
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
                        }, 3000);
                    </script>
                    <?php unset($_SESSION["mensaje"]);
                    endif;
                    ?>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="administrador.php?c=ProductoController&a=nuevo"
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
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tbl-Producto">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Marca</th>
                                            <th>Tipo de Producto</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cont = 1;
                                        foreach ($data["resultado"] as $row) :
                                    ?>
                                        <tr>
                                            <td><?php echo $cont++; ?></td>
                                            <td><?php echo $row["nombreProducto"]; ?></td>
                                            <td><?php echo $row["descripciónProducto"]; ?></td>
                                            <td><?php echo $row["nombreMarca"]; ?></td>
                                            <td><?php echo $row["nombre_tipoProducto"]; ?></td>
                                            <td><?php echo $row["precioUnitario"]; ?></td>
                                            <td class="text-center"><?php
                                                if ($row["stock"] == 0) {
                                                echo "--";
                                                } else {
                                                echo $row["stock"];
                                                }  ?>
                                            </td>
                                            <td>
                                                <a href="administrador.php?c=ProductoController&a=verProducto&id=<?php echo $row["idProducto"]; ?>"
                                                    class="btn btn-xs btn-warning"><i class="fas fa-user-edit"></i></a>
                                                <a href="#" class="btn btn-xs btn-danger deleteBtn" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    data-recordid="<?php echo $row["idProducto"]; ?>"><i
                                                        class="fas fa-trash"></i></a>
                                                <?php if ($row["stock"] > 0):?>

                                                <button type="button" class="btn btn-xs btn-info" data-toggle="modal"
                                                    data-target="#aumentarModal"
                                                    onclick="varProductoID(<?php echo $row['idProducto']; ?>)">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>

                                                <?php else : ?>
                                                <button class="btn btn-xs btn-info" disabled><i
                                                        class="fas fa-plus-circle"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para la confirmación de eliminación -->
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

<!-- Modal para aumentar el stock (solo para productos que cuenten con stock) -->

<div class="modal form-modal" id="aumentarModal" data-backdrop="static" data-keyboard="false" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="md-title">Aumentar Stock</h4>
            </div>
            <form action="#" id="formAumentarStock" method="post">
                <!-- Agrega un campo oculto para almacenar el ID del producto -->
                <input type="hidden" name="idProducto" id="idProducto" value="">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="txtNombre" class="col-sm-4 col-form-label text-right">Nombre:</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="txtStockN" class="col-sm-4 col-form-label text-right">Cantidad a agregar:</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtStockN" id="txtStockN" class="form-control">
                            <p id="errorControl" style="color:red"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" style="padding-left:30px; padding-right:30px"
                        data-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-success" id="btnActualizarStock" data-dismiss="modal" onclick="actualizarMarcaID()"> REGISTRAR DATOS</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modal-confirmacion" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alerta</h5>
            </div>
            <div class="modal-body">
                <p id="pConfirmacion"></p>
            </div>
            <div class="modal-footer">
            <a href="administrador.php?c=ProductoController" type="button" class="btn btn-success active  btn-Confirmar">ACEPTAR</a>
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
            var productId = $(this).data('recordid');
            var deleteUrl = 'administrador.php?c=ProductoController&a=eliminar&id=' + productId;
            $('#deleteRecordBtn').attr('href', deleteUrl);
        });
    });

    function varProductoID(id) {
        $("#md-title").text("Actualizar Producto");
        $("#btnActualizarStock").text("Actualizar Stock");
        $.ajax({
            url: '../views/administrador.php?c=ProductoController&a=varProductosSID&id=' + id,
            type: 'post',
            success: function (response) {
                console.log(response);
                var jsonData = JSON.parse(response);
                $("#txtNombre").val(jsonData.producto.nombreProducto);

                $("#btnActualizarStock").attr("onclick", "actualizarProducto(" + jsonData.producto.idProducto +
                    ")");
            },
            error: function () {
                alert("Error inesperado");
            }
        });
    }

    function actualizarProducto(id) {
        $.ajax({
            url: '../views/administrador.php?c=ProductoController&a=actualizarStock&id=' + id,
            type: 'post',
            data: $("#formAumentarStock").serialize(), // Corrige el nombre del formulario
            success: function (response) {
                console.log(response);
                var jsonData = JSON.parse(response);
                if (jsonData.statusCode == 200) {
                    $("#modal-confirmacion").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#pConfirmacion").text('Datos actualizados correctamente');

                } else if (jsonData.statusCode == 500) {
                    $("#aumentarModal").modal('show');
                    $("#errorControl").text(jsonData.errores["producto"]);
                    
        

                }
            },
            error: function () {
                alert("Error inesperado");
            }
        });
    }



</script>