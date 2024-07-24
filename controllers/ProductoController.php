<?php
class ProductoController
{

    protected $producto;
    protected $validaciones;
    protected $errores;

    public function __construct()
    {
        require_once "../models/ProductoModel.php";
        require_once "../controllers/ValController.php";
        $this->producto = new ProductoModel();
        $this->validaciones = new ValController();
        $this->errores = array();
    }

    //deben tener la funcion index();
    public function index()
    {
        $data["titulo"] = "GESTIÓN DE PRODUCTOS";
        $data["resultado"] = $this->producto->getProducto();
        $data["contenido"] = "../views/productos/producto.php";
        require_once TEMPLATE;
    }
    public function nuevo()
    {
        $data["titulo"] = "FORMULARIO DE REGISTRO DE PRODUCTO";
        $data["contenido"] = "../views/productos/producto_nuevo.php";
        require_once TEMPLATE;
    }

    // funcion para registrar datos de nuevos usuarios
    public function registrar()
    {
        //variables reciben mediante el metodo POST
        $nombres = $_POST["txtNombre"];
        $marca = $_POST["cboMarca"];
        $tipoProd = $_POST["cboTipoProducto"];
        $descripcion = $_POST["txtDescripción"];
        $precio = $_POST["txtPrecio"];
        $stock = $_POST["txtStock"];
        if (isset($_POST["btnEnviar"])) {

            $this->validarNombres($nombres);
            $this->validarpPrecio($precio);

            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["titulo"] = "FORMULARIO DE REGISTRO DE PRODUCTO";
                $data["contenido"] = "../views/productos/producto_nuevo.php";
                require_once TEMPLATE;
            } else {
                $data = array(
                    "nombre" => $_POST["txtNombre"],
                    "marca" => $_POST["cboMarca"],
                    "tipoProducto" => $_POST["cboTipoProducto"],
                    "descripcion" => $_POST["txtDescripción"],
                    "precio" => $_POST["txtPrecio"],
                    "stock" => $_POST["txtStock"]
                );
                $this->producto->save($data);
                $_SESSION['mensaje'] = "Datos registrados correctamente";
                header("Location:../views/administrador.php?c=ProductoController");
            }
        } else {
            require_once ERROR404;
        }

    }

    public function verProducto($producto)
    {
        $data["titulo"] = "ACTUALIZAR DATOS DE PRODUCTO";
        $data["consulta"] = $this->producto->getProductoID($producto); // obtiene los datos de un usuario por ID.
        $data["contenido"] = "../views/productos/producto_actualizar.php";
        require_once "../views/dashboard/template.php";
    }
    public function varProductosSID($id)
    {
        echo json_encode(array('statusCode' => 200, 'producto' => $this->producto->getProductoID($id)));
    }
    public function actualizar()
    {
        // Variables recibidas mediante el método POST
        $id = $_POST["txtIDProducto"];
        $nombre = $_POST["txtNombre"];
        $marca = $_POST["cboMarca"];
        $tipoProducto = $_POST["cboTipoProducto"];
        $descripcion = $_POST["txtDescripción"];
        $precio = $_POST["txtPrecio"];
        $stock = $_POST["txtStock"];

        if (isset($_POST["btnEnviar"])) {
            // Realiza la validación, por ejemplo, validarNombres
            $this->validarNombres($nombre);
            $this->validarpPrecio($precio);
            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["consulta"] = $this->producto->getProductoID($id);
                $data["titulo"] = "FORMULARIO PARA ACTUALIZAR PRODUCTO";
                $data["contenido"] = "../views/productos/producto_actualizar.php";
                require_once TEMPLATE;
            } else {
            
                $data = array(
                    "nombre" => $_POST["txtNombre"],
                    "marca" => $_POST["cboMarca"],
                    "tipoProducto" => $_POST["cboTipoProducto"],
                    "descripcion" => $_POST["txtDescripción"],
                    "precio" => $_POST["txtPrecio"],
                    "stock" => $_POST["txtStock"]
                );
                var_dump($data);

                // Actualiza los datos utilizando el ID proporcionado
                $this->producto->update($id, $data);

                $_SESSION['mensaje'] = "Datos actualizados correctamente";
                header("Location: administrador.php?c=ProductoController");
            }
        } else {
            require_once ERROR404;
        }
    }
    private function validarNombres($nombreProducto)
    {
        require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta

        // Comprobar si el campo 'nombreMarca' está vacío
        if (empty($nombreProducto)) {
            $this->errores["producto"] = "Debe ingresar un valor en producto";
        } else {
            // Comprobar si ya existe el valor en la base de datos
            $sql = "SELECT * FROM tb_producto WHERE nombreProducto = '$nombreProducto'";
            $resultado = $mysqli->query($sql);

            if ($resultado->num_rows > 0) {
                $this->errores["producto"] = "El producto ya existe";
            }
        }
    }
    private function validarpPrecio($precio)
    {
        require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta

        // Comprobar si el campo 'nombreMarca' está vacío
        if (empty($precio)) {
            $this->errores["precio"] = "Debe ingresar un valor en producto";
        }if($precio <= 0){
            $this->errores["precio"] = "El precio debe ser positvo y mayor a 0";
        }
    }
    // funcion para eliminar categorias segun id
    public function eliminar($id)
    {
        $data["productoP"] = $this->producto->validarProductoV($id);
        if($data["productoP"]===null){
            $this->producto->delete($id);
            $_SESSION['mensaje'] = "Datos eliminados correctamente";
            header("Location: administrador.php?c=ProductoController");
        }else{
            require_once ERROR403;
        }
    }
    //aumentar stock
    public function actualizarStock($id)
    {
        $stock = $_POST["txtStockN"];
        $producto = $this->producto->getProductoID($id);
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->ValidarStock($stock);

            if ($this->errores) {
                echo json_encode(array('statusCode' => 500, "errores" => $this->errores));
            } else {
                $stocknuevo = $producto['stock'] + $stock;
                $data = ["stock" => $stocknuevo];
                $this->producto->updateStock($id, $data);
                echo json_encode(array('statusCode' => 200, "producto" => $data));
            }
        } else {
            require_once ERROR404;
        }
    }
    private function ValidarStock($stock)
    {

        // Comprobar si el campo 'stock' está vacío
        if (empty($stock)) {
            $this->errores["producto"] = "Debe ingresar un valor en productos a agregar";
        } 
    }



}
