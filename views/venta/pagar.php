<div class="content-wrapper">
    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_SESSION["DNI"];?>">
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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <h5 class="card-header font-italic">Información del Cliente</h5>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="txtDNI" class="col-xs-1">DNI</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="txtDNI" name="txtDNI"
                                        value="<?php echo $data["resultado"]["id_Cliente"]; ?>" readonly>
                                </div>
                                <label for="txtNombre" class="col-xs-2">Nombre</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                                        value="<?php echo $data["resultado"]["nombreCliente"]; ?>" readonly>
                                </div>
                                <label for="txtApellido" class="col-xs-2">Apellido</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="txtApellido" name="txtApellido"
                                        value="<?php echo $data["resultado"]["apellidoCliente"]; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row mb-3">

                <div class="col-md-9">

                    <div class="card card-gray shadow">
                        <h5 class="card-header font-italic">Información de la Venta</h5>
                        <div class="card-body p-3">

                            <div class="row">


                                <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="lstProductosVenta" class="table table-striped table-hover">
                                            <thead class="bg-gray text-left fs-6">
                                                <tr>
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Codigo</th>
                                                    <th class="text-center">Tipo Producto</th>
                                                    <th class="text-center">Marca</th>
                                                    <th class="text-center">Producto</th>
                                                    <th class="text-center">Cantidad</th>
                                                    <th class="text-center">Precio</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="small text-left fs-6">
                                                <?php $cont = 1; foreach ($data["detalle"] as $row) : ?>
                                                <tr>
                                                    <td class="text-center"> <?php echo $cont++; ?></td>
                                                    <td class="text-center"> <?php echo $row["idProducto"]; ?></td>
                                                    <td class="text-center">
                                                        <?php echo $row["nombre_tipoProducto"]; ?>
                                                    </td>
                                                    <td class="text-center"> <?php echo $row["nombreMarca"]; ?></td>
                                                    <td class="text-center"> <?php echo $row["nombreProducto"]; ?>
                                                    </td>
                                                    <td class="text-center"> <?php echo $row["cantidad"]; ?></td>
                                                    <td class="text-center"> <?php echo $row["precioUnitario"]; ?>
                                                    </td>
                                                    <td class="text-center"> <?php echo $row["subtotal"]; ?> </td>

                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div> <!-- ./ end card-body -->
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card card-gray shadow">

                        <div class="card-body ">
                            <!-- SELECCIONAR TIPO DE DOCUMENTO -->
                            <div class="form-group mb-1">
                                <div class="form-group mb-1 rounded-3 border border-2 border-light">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fas fa-file-alt fs-6"></i><label for="iptNroSerie"
                                                class="p-0 m-0">Documento</label>
                                        </div>
                                        <div class="col-md-12">
                                            <select class="form-select form-select-sm w-100"
                                                aria-label=".form-select-sm example" id="selDocumentoVenta">
                                                <option value="1" selected="true">Boleta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- SELECCIONAR TIPO DE DOCUMENTO -->
                            <div class="form-group mb-1">
                                <div class="form-group mb-1 rounded-3 border border-2 border-light">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fas fa-money-bill-alt fs-6"></i><label for="iptNroSerie"
                                                class="p-0 m-0">Tipo Pago</label>
                                        </div>
                                        <div class="col-md-12">
                                            <select class="form-select form-select-sm w-100"
                                                aria-label=".form-select-sm example" id="metodoPago">
                                                <option value="Efectivo" selected="true">Efectivo</option>
                                                <option value="Yape">Yape</option>
                                                <option value="Plin">Plin</option>
                                                <option value="POS">POS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- SERIE Y NRO DE BOLETA -->
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="iptNroSerie1" class="p-0 m-0">Serie</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="iptEfectivo" id="iptNroSerie1"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $data["resultado"]["idPedido"]?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="iptNroSerie2" class="p-0 m-0">Correlativo</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="iptEfectivo" id="iptNroSerie2"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $data["resultado"]["Correlativo"]?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!-- INPUT DE EFECTIVO ENTREGADO -->
                            <div class="form-group">
                                <label for="iptEfectivoRecibido" class="p-0 m-0">Efectivo recibido</label>
                                <input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido"
                                    class="form-control form-control-sm" placeholder="Cantidad de efectivo recibida" >
                            </div>

                            <!-- INPUT CHECK DE EFECTIVO EXACTO -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chkEfectivoExacto">
                                <label class="form-check-label" for="chkEfectivoExacto">
                                    Efectivo Exacto
                                </label>
                            </div>

                            <!-- MOSTRAR MONTO EFECTIVO ENTREGADO Y EL VUELTO -->
                            <div class="row mt-2">

                                <div class="col-md-7">
                                    <span>Monto recibido</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    S./ <span class="" id="montoEfectivo">0.00</span>
                                </div>
                                <div class="col-md-7 text" style="color: red;">
                                    <span>Vuelto</span>
                                </div>
                                <div class="col-md-5 text-right" style="color: red;">
                                    S./ <span id="vuelto">0.00</span>
                                </div>




                            </div>

                            <!-- MOSTRAR EL SUBTOTAL, IGV Y TOTAL DE LA VENTA -->
                            <div class="form-group">
                                <div class="row fw-bold">

                                    <div class="col-md-7">
                                        <span>IGV</span>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        S./ <span class=""
                                            id="boleta_igv"><?php echo $data["resultado"]["igv"]; ?></span>
                                    </div>
                                    <div class="col-md-7">
                                        <span>OPE. GRAVADAS</span>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        S./ <span class=""
                                            id="opGravada"><?php echo $data["resultado"]["opGravda"]; ?></span>
                                    </div>


                                    <div class="col-md-7">
                                        <span>SUBTOTAL</span>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        S./ <span class=""
                                            id="boleta_subtotal"><?php echo $data["resultado"]["Total"]; ?></span>
                                    </div>

                                    <div class="col-md-7">
                                        <span>TOTAL</span>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        S./ <span class=""
                                            id="boleta_total"><?php echo $data["resultado"]["Total"]; ?></span>
                                    </div>
                                    <!-- Botón de "Realizar Pago" -->
                                    <div class="col-md-12 mt-3 text-center">
                                        <td>
                                            <button id="btnRealizarPago" class="btn btn-info btn-block">Realizar
                                                Pago</button>
                                        </td>


                                    </div>
                                </div>
                            </div>

                        </div><!-- ./ CARD BODY -->

                    </div><!-- ./ CARD -->
                </div>

            </div>
        </div>

    </div>


</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/vuelto.js"></script>
<script>
        $(document).ready(function() {
            // Obtener elementos del DOM con jQuery
            var checkbox = $('#chkEfectivoExacto');
            var select = $('#metodoPago');
            var input = $('#iptEfectivoRecibido');

            checkbox.change(function() {
                actualizarEstadoInput();
            });

            select.change(function() {
                actualizarEstadoInput();
            });

            function actualizarEstadoInput() {
                input.prop('disabled', checkbox.is(':checked') || (select.val() !== 'Efectivo'));
            }
        });
    </script>

