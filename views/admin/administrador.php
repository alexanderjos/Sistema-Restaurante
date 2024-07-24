<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Administración</h1>
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

                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4 id="totalProductos"><?php echo $data3; ?></h4>
                            <p>Productos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clipboard"></i>
                        </div>
                        <a href="administrador.php?c=ProductoController" style="cursor:pointer;"
                            class="small-box-footer">Mas Info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>



                <!-- TARJETA TOTAL VENTAS -->
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4 id="totalVentas"><?php echo "S/. ". $data1; ?></h4>

                            <p>Total Ventas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>
                        <a href="../views/Administrador.php?c=VentaController&a=verVentasAdmin" style="cursor:pointer;"
                            class="small-box-footer">Mas Info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- TARJETA TOTAL VENTAS DIA ACTUAL -->
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h4 id="totalVentasHoy"><?php echo "S/. ".$data2; ?></h4>

                            <p>Ventas del día</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-calendar"></i>
                        </div>
                        <a href="../views/Administrador.php?c=VentaController&a=verVentasDiaActual&id=<?php echo date('Y-m-d'); ?>"
                            style="cursor:pointer;" class="small-box-footer">Mas Info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div> <!-- ./row Tarjetas Informativas -->

            <!--  -->
            <!-- row Grafico de barras y doughnut-->
            <div class="row">

                <div class="col-12">

                    <div class="card card-gray shadow">

                        <div class="card-header">

                            <h3 class="card-title" id="title-header"></h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div> <!-- ./ end card-tools -->

                        </div> <!-- ./ end card-header -->


                        <div class="card-body">

                            <div class="chart col-12">

                                    <canvas id="myChart"></canvas>

                                <script>
                                    // Función para obtener datos del servidor
                                    async function fetchData() {
                                        const response = await fetch('../config/data.php');
                                        const data = await response.json();

                                        // Imprime los datos en la consola
                                        console.log('Datos obtenidos:', data);

                                        return data;
                                    }

                                    // Función para inicializar el gráfico
                                    async function initChart() {
                                        const data = await fetchData();

                                        const ctx = document.getElementById('myChart').getContext('2d');
                                        new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: data.labels,
                                                datasets: [{
                                                    label: 'Ventas Mensuales',
                                                    data: data.ventas,
                                                    fill: false,
                                                    borderColor: 'rgb(75, 192, 192)',
                                                    tension: 0.1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    x: {
                                                        type: 'category',
                                                        labels: data.labels,
                                                        position: 'bottom'
                                                    },
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    }

                                    // Llama a la función para inicializar el gráfico
                                    initChart();
                                </script>

                            </div>

                        </div> <!-- ./ end card-body -->

                    </div>

                </div>



            </div><!-- ./row Grafico de barras y doughnut -->

            <!-- Productos más venididos y con los de poco stock -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-gray shadow">
                        <div class="card-header">
                            <h3 class="card-title">Los 10 Productos más Vendidos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div> <!-- ./ end card-tools -->
                        </div> <!-- ./ end card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbl_productos_mas_vendidos">
                                    <thead>
                                        <tr class="text-danger">
                                            <!-- <th>Cod. producto</th> -->
                                            <th>Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Ventas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($productosv["mas_vendidos"]) && is_array($productosv["mas_vendidos"])) : ?>
                                        <?php foreach ($productosv["mas_vendidos"] as $row) : ?>
                                        <tr>
                                            <td> <?php echo  $row["nombreProducto"]; ?></td>
                                            <td class="text-center"> <?php echo $row["totalVendido"]; ?></td>
                                            <td class="text-center"> <?php echo"S/. ". $row["totalSubtotal"]; ?></td>
                                        </tr>

                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- ./ end card-body -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-gray shadow">
                        <div class="card-header">
                            <h3 class="card-title">Productos con Poco Stock</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div> <!-- ./ end card-tools -->
                        </div> <!-- ./ end card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbl_productos_poco_stock">
                                    <thead>
                                        <tr class="text-danger">
                                            <!-- <th>Cod. producto</th> -->
                                            <th>Producto</th>
                                            <th class="text-center">Stock Actual</th>
                                            <th class="text-center">Mín. Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if (isset($productos["poco_stock"]) && is_array($productos["poco_stock"])) : ?>
                                            <?php foreach ($productos["poco_stock"] as $row) : ?>
                                        <tr>
                                            <td> <?php echo $row["nombreProducto"]; ?></td>
                                            <td class="text-center"> <?php echo $row["stock"]; ?></td>
                                            <td class="text-center"> 1 </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- ./ end card-body -->
                    </div>
                </div>
            </div>
            <!-- Clientes Recurrentes -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-gray shadow">
                        <div class="card-header">
                            <h3 class="card-title">Los 10 Clientes más recurrentes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div> <!-- ./ end card-tools -->
                        </div> <!-- ./ end card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbl_clientes_recurrentes">
                                    <thead>
                                        <tr class="text-danger">
                                            <!-- <th>Cod. producto</th> -->
                                            <th>Cliente</th>
                                            <th class="text-center">frecuencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($productosc["clientes_rc"]) && is_array($productosc["clientes_rc"])) : ?>
                                        <?php foreach ($productosc["clientes_rc"] as $row) : ?>
                                        <tr>
                                            <td> <?php echo  $row["nombreCliente"]." ".$row["apellidoCliente"]; ?></td>
                                            <td class="text-center"> <?php echo $row["frecuencia"]; ?></td>
                                        </tr>

                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- ./ end card-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>