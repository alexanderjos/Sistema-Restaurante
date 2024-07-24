<div class="content-wrapper">
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

    <!-- Contenido principal -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-6">
                                <h2 class="m-0"><i>Buscar por fechas</i></h2>
                            </div>
                            <br>
                            <form action="administrador.php?c=VentaController&a=verVentaFecha" method="POST">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="fechaInicio">Fecha de Inicio:</label>
                                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio"
                                                value="<?php echo $data["fechaInicio"]; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="fechaFinal">Fecha Final:</label>
                                            <input type="date" class="form-control" id="fechaFinal" name="fechaFinal"
                                                value="<?php echo $data["fechaFin"]; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">&nbsp;</label>
                                            <a href="../views/Administrador.php?c=VentaController&a=verVentasAdmin"
                                                class="btn btn-success btn-block">Ver Todas</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tbl-Venta">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nro Boleta</th>
                                            <th>Estado</th>
                                            <th>Mozo Encargado</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Ver Detalle</th>
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
                                            <td><?php echo $row["Conformidad"]; ?></td>
                                            <td><?php echo $row["nombreEmpleado"]." ".$row["apellidoEmpleado"]; ?></td>
                                            <td><?php echo $row["Fecha"]; ?></td>

                                            <td><?php echo $row["nombreCliente"]." ".$row["apellidoCliente"]; ?></td>
                                            <td><?php echo $row["Total"]; ?></td>
                                            <td>

                                                <?php if ($row["Conformidad"] === 'Pagada'):?>
                                                <!-- Botón de eliminar deshabilitado si el usuario es 'Admin' -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#detalleModal<?php echo $row["idPedido"]; ?>">
                                                    Ver Detalle
                                                </button>
                                                <a href="../fpdf/administrador.php?idVenta=<?php echo $row["idPedido"]; ?>"
                                                    class="btn btn-xs btn">
                                                    <i class="far fa-file-pdf"
                                                        style="font-size: 27px; color: #d2220f;"></i>
                                                </a>




                                                <?php else : ?>
                                                <!-- Botones habilitados para otros tipos de usuarios -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#detalleModal<?php echo $row["idPedido"]; ?>">
                                                    Ver Detalle
                                                </button>
                                                <button class="btn btn-xs btn" disabled>
                                                    <i class="far fa-file-pdf" style="font-size: 27px; color: #d2220f;"></i>
                                                </button>

                                                <?php endif; ?>



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