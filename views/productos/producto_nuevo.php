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
    <div class="content">.
        <?php error_reporting(0);?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="administrador.php?c=ProductoController&a=registrar" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <div class="form-group row justify-content-center">
                                    <label for="staticNombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="txtNombre" value="<?php echo $_REQUEST["txtNombre"]?>">
                                        <?php if (isset($data["errores"]["producto"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["producto"]?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Descripción:</label>
                                    <div class="col-sm-5">
                                        <textarea type="text" class="form-control" name="txtDescripción" value="<?php echo $_REQUEST["txtDescripción"]?>"></textarea>
                                        <?php if (isset($data["errores"]["descripciónProducto"])) : ?>
                                            <div style="color:red">
                                                <?php echo $data["errores"]["descripciónProducto"]?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputMarca" class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-5">
                                        <?php
                                        require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta
                                        $sql = "SELECT idMarca, nombreMarca FROM tb_marca_producto";
                                        $resultado = $mysqli->query($sql);

                                        // Paso 4: Generar el campo de selección
                                        if (mysqli_num_rows($resultado) > 0) {
                                            echo '<select class="form-control" name="cboMarca">'; // Agregamos la clase "form-control" para aplicar estilos Bootstrap
                                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                                echo '<option value="' . $fila["idMarca"] . '">' . $fila["nombreMarca"] . '</option>';
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                        <?php if (isset($data["errores"]["nombreMarca"])) : ?>
                                            <div style="color: red;">
                                                <?php echo $data["errores"]["nombreMarca"]; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="inputTipoProducto" class="col-sm-2 col-form-label">Tipo de Producto:</label>
                                    <div class="col-sm-5">
                                        <?php
                                        require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta
                                        $sql = "SELECT * FROM tb_tipo_producto";
                                        $resultado = $mysqli->query($sql);

                                        // Paso 4: Generar el campo de selección
                                        if ($resultado->num_rows > 0) {
                                            echo '<select class="form-control" name="cboTipoProducto" id="categorySelect">'; // Agregamos la clase "form-control" para aplicar estilos Bootstrap
                                            while ($fila = $resultado->fetch_assoc()) {
                                                echo '<option value="' . $fila["idTipo_Producto"] . '">' . $fila["nombre_tipoProducto"] . '</option>';
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                        <?php if (isset($data["errores"]["nombreMarca"])) : ?>
                                            <div style="color: red;">
                                                <?php echo $data["errores"]["nombreMarca"]; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>  
                                <div class="form-group row justify-content-center">
                                    <label for="staticPrecio" class="col-sm-2 col-form-label">Precio:</label>
                                    <div class="col-sm-5">
                                    <input type="number" step="0.01" min="1" class="form-control" name="txtPrecio" value="<?php echo isset($_REQUEST["txtPrecio"]) ? $_REQUEST["txtPrecio"] : ''; ?>">
                                        <?php if (isset($data["errores"]["precio"])) : ?>
                                            <div style="color: red;">
                                                <?php echo $data["errores"]["precio"]; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                

                                <div class="form-group row justify-content-center"id="stockField" style="visibility: hidden;">
                                    <label for="staticStock" class="col-sm-2 col-form-label">Stock:</label>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" name="txtStock" value="<?php echo isset($_REQUEST["txtStock"]) ? $_REQUEST["txtStock"] : ''; ?>">
                                        <?php if (isset($data["errores"]["stockProducto"])) : ?>
                                            <div style="color: red;">
                                                <?php echo $data["errores"]["stockProducto"]; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <script>
                                    const categorySelect = document.getElementById("categorySelect");
                                    const stockField = document.getElementById("stockField");

                                    categorySelect.addEventListener("change", function() {
                                        const selectedCategory = categorySelect.value;
                                        if (selectedCategory === "3" || selectedCategory === "4" || selectedCategory === "6") {
                                            stockField.style.visibility = "visible"; // Mostrar el campo de stock para categorías 3, 4 y 6
                                        } else {
                                            stockField.style.visibility = "hidden"; // Ocultar el campo de stock para otras categorías
                                        }
                                    });
                                </script>

                                <div class="form-group row justify-content-center">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-5">
                                        <a href="administrador.php?c=ProductoController" class="btn btn-secondary">CANCELAR REGISTRO</a>
                                        <input type="submit" value="REGISTRAR PRODUCTO" class="btn btn-success" name="btnEnviar">
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