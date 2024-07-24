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
                        <h3 class="card-header font-italic">Información del Cliente</h3>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="txtDNI" class="col-xs-1">DNI</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="txtDNI" name="txtDNI">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" id="boton">Buscar</button>
                                </div>
                                <label for="txtNombre" class="col-xs-1">Nombre</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" readonly>
                                </div>
                                <label for="txtApellido" class="col-xs-1">Apellido</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="txtApellido" name="txtApellido"
                                        readonly>
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
                        <h3 class="card-header font-italic">Información de la Venta</h3>
                        <div class="card-body ">

                            <div class="row">
                                <!-- INPUT PARA INGRESO DEL CODIGO DE BARRAS O DESCRIPCION DEL PRODUCTO -->
                                <div class="col-md-12 mb-3">

                                    <div class="form-group mb-2">

                                        <label class="col-form-label" for="iptCodigoVenta">
                                            <i class="fas fa-barcode fs-6"></i>
                                            <span class="small">Productos</span>
                                        </label>

                                        <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                                            placeholder="Ingrese el código de barras o el nombre del producto">
                                    </div>
                                    <div id="resultados" class="mt-3"></div>

                                </div>

                                <!-- ETIQUETA QUE MUESTRA LA SUMA TOTAL DE LOS PRODUCTOS AGREGADOS AL LISTADO -->
                                <div class="col-md-7 mb-3 rounded-3"
                                    style="background-color: gray;color: white;text-align:center;border:1px solid gray;">
                                    <h2 class="fw-bold m-0" id="totalVenta">S/ <span class="fw-bold">0.00</span>
                                    </h2>

                                </div>

                                <!-- BOTONES PARA VACIAR LISTADO Y COMPLETAR LA VENTA -->
                                <div class="col-md-5 text-right">
                                    <button class="btn btn-primary" id="realizarVenta">
                                        <i class="fas fa-shopping-cart"></i> Realizar Venta
                                    </button>
                                    <button class="btn btn-danger" id="btnVaciarListado">
                                        <i class="far fa-trash-alt"></i> Vaciar Listado
                                    </button>
                                </div>

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
                                                    <th class="text-center">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="small text-left fs-6">
                                                <!-- Your table rows go here -->
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

                        <div class="card-body p-2">
                            <!-- SERIE Y NRO DE BOLETA -->
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="iptNroSerie" class="p-0 m-0">Serie</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="iptEfectivo" id="iptNroSerie"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $data["idVenta"]?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="Correlativo" class="p-0 m-0">Correlativo</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="Correlativo" id="Correlativo"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $data["correlativo"]?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <!-- MOSTRAR EL SUBTOTAL, IGV Y TOTAL DE LA VENTA -->
                            <div class="row fw-bold">

                                <div class="col-md-7">
                                    <span>OPE. GRAVADAS</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    S./ <span class="" id="opGravada">0.00</span>
                                </div>
                                <div class="col-md-7">
                                    <span>IGV (18%)</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    S./ <span class="" id="boleta_igv">0.00</span>
                                </div>

                                <div class="col-md-7">
                                    <span>SUBTOTAL</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    S./ <span class="" id="boleta_subtotal">0.00</span>
                                </div>

                                <div class="col-md-7">
                                    <span>TOTAL</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    S./ <span class="" id="boleta_total">0.00</span>
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


<script src="../js/api.js"></script>
<script src="../js/ventas.js"></script>