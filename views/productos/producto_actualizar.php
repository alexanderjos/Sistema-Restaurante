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
                            <form action="../views/administrador.php?c=ProductoController&a=actualizar" method="POST"
                                autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" class="hidden" name="txtIDProducto" value="<?php echo $data["consulta"]["idProducto"]; ?>"><br>

                                <div class="form-group row justify-content-center">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombres</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtNombre"
                                            value="<?php echo isset($_REQUEST['txtNombre']) ? $_REQUEST['txtNombre'] : $data["consulta"]["nombreProducto"]; ?>">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Descripción:</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control"
                                            name="txtDescripción"><?php echo isset($_REQUEST['txtDescripción']) ? $_REQUEST['txtDescripción'] : $data["consulta"]["descripciónProducto"]; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputMarca" class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-5">
                                        <select name="cboMarca" class="form-control">
                                            <?php
                                                require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta
                                                $sql = "SELECT idMarca, nombreMarca FROM tb_marca_producto";
                                                $resultado = $mysqli->query($sql);

                                                if (mysqli_num_rows($resultado) > 0) {
                                                    while ($fila = mysqli_fetch_assoc($resultado)) {
                                                        $selected = ($data["consulta"]["idMarca"] == $fila["idMarca"]) ? "selected" : "";
                                                        echo '<option value="' . $fila["idMarca"] . '" ' . $selected . '>' . $fila["nombreMarca"] . '</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputMarca" class="col-sm-2 col-form-label">Tipo Producto:</label>
                                    <div class="col-sm-5">
                                        <select name="cboTipoProducto" class="form-control" id="categorySelect">
                                            <?php
                                                require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta
                                                $sql = "SELECT idTipo_Producto, nombre_tipoProducto FROM tb_tipo_producto";
                                                $resultado = $mysqli->query($sql);

                                                if (mysqli_num_rows($resultado) > 0) {
                                                    while ($fila = mysqli_fetch_assoc($resultado)) {
                                                        $selected = ($data["consulta"]["idTipoProducto"] == $fila["idTipo_Producto"]) ? "selected" : "";
                                                        echo '<option value="' . $fila["idTipo_Producto"] . '" ' . $selected . '>' . $fila["nombre_tipoProducto"] . '</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center" >
                                    <label for="staticStock" class="col-sm-2 col-form-label">Precio :</label>
                                    <div class="col-sm-5">
                                        <input type="number" step="0.01" class="form-control" name="txtPrecio"
                                            value="<?php echo isset($_REQUEST['txtPrecio']) ? $_REQUEST['txtPrecio'] : $data["consulta"]["precioUnitario"]; ?>">
                                    </div>
                                </div>   
                                <div class="form-group row justify-content-center" id="stockField"style="visibility: hidden;">
                                    <label for="staticStock" class="col-sm-2 col-form-label">Stock:</label>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" name="txtStock"
                                            value="<?php echo isset($_REQUEST['txtStock']) ? $_REQUEST['txtStock'] : $data["consulta"]["stock"]; ?>">
                                    </div>
                                </div>
                                <script>
                                    const categorySelect = document.getElementById("categorySelect");
                                    const stockField = document.getElementById("stockField");

                                    categorySelect.addEventListener("change", function () {
                                        const selectedCategory = categorySelect.value;
                                        if (selectedCategory === "3" || selectedCategory === "4" ||
                                            selectedCategory === "6") {
                                            stockField.style.visibility =
                                            "visible"; // Mostrar el campo de stock para categorías 3, 4 y 6
                                        } else {
                                            stockField.style.visibility =
                                            "hidden"; // Ocultar el campo de stock para otras categorías
                                        }
                                    });

                                    // Llamar al evento change al cargar la página para que se muestre/oculte el campo según la selección inicial
                                    categorySelect.dispatchEvent(new Event('change'));
                                </script>


                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="administrador.php?c=ProductoController"
                                            class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="ACTUALIZAR DATOS" class="btn btn-success"
                                            name="btnEnviar">
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