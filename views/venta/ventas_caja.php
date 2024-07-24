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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tbl-Venta">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nro Boleta</th>
                                            <th>Correlativo</th>
                                            <th>Mozo Encargado</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Ver Detalle</th>
                                            <th>Pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $uniqueIds = array(); // Array para almacenar IDs únicos
                                            foreach ($data["resultado"] as $row) :
                                                // Verificar si el ID ya se ha mostrado
                                                if (!in_array($row["idPedido"], $uniqueIds)) :?>
                                        <tr>

                                            <td><?php echo $row["idPedido"]; ?></td>
                                            <td><?php echo $row["Correlativo"]; ?></td>
                                            <td><?php echo $row["nombreEmpleado"]." ".$row["apellidoEmpleado"]; ?></td>
                                            <td><?php echo $row["Fecha"]; ?></td>

                                            <td><?php echo $row["nombreCliente"]." ".$row["apellidoCliente"]; ?></td>
                                            <td><?php echo $row["Total"]; ?></td>
                                            <td>
                                                <!-- Botón para activar el modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#detalleModal<?php echo $row["idPedido"]; ?>">
                                                    Ver Detalle
                                                </button>

                                                <!-- Modal -->
                                                <!-- ... (Tu código existente) ... -->

                                                <!-- Modal -->
                                                <div class="modal fade" id="detalleModal<?php echo $row["idPedido"]; ?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog" role="document">
                                                        <!-- Agregada la clase modal-dialog-centered -->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detalleModalLabel">Detalle
                                                                    de Venta</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Mostrar detalles de la venta en una tabla -->
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Código de Barras</th>
                                                                            <th>Nombre del Producto</th>
                                                                            <th>Categoria</th>
                                                                            <th>Cantidad</th>
                                                                            <th>Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            // Obtener los detalles del producto para este ID de pedido
                                                                            foreach ($data["resultado"] as $detalle) :
                                                                                if ($detalle["idPedido"] == $row["idPedido"]) :
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $detalle["idProducto"]; ?>
                                                                            </td>
                                                                            <td><?php echo $detalle["nombreProducto"]; ?>
                                                                            </td>
                                                                            <td><?php echo $row['nombre_tipoProducto']; ?>
                                                                            </td>
                                                                            <td><?php echo $detalle["cantidad"]; ?></td>
                                                                            <td><?php echo $detalle["subtotal"]; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                            endif;
                                                                            endforeach;
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td><a href="#" class="btn btn-success btn-block btn-pagar" data-idpedido="<?php echo $row["idPedido"]; ?>">Pagar</a></td>

                                        </tr>
                                        <?php
                                            // Agregar el ID a la lista de IDs únicos
                                            $uniqueIds[] = $row["idPedido"];
                                                endif;
                                            endforeach;
                                        ?>
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


<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/pagarventa.js"></script>
