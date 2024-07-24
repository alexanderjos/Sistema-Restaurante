<?php

class MarcaController
{

    protected $marcas;
    protected $validaciones;
    protected $errores;

    public function __construct()
    {
        require_once "../models/MarcaModel.php";
        require_once "../controllers/ValController.php";

        $this->marcas = new MarcaModel();
        $this->validaciones = new ValController();
        $this->errores = array();
    }

    //deben tener la funcion index();
    public function index()
    {
        $data["titulo"] = "GESTIÓN DE MARCAS";
        $data["resultado"] = $this->marcas->getMarcas();
        $data["contenido"] = "../views/marcas/marcas.php";
        require_once TEMPLATE;
    }
    // funcion para registrar datos de nuevos marcas
    public function registrar()
    {

        $marcas = $_POST["txtMarca"];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->ValidarMarca($marcas);

            if ($this->errores) {
                echo json_encode(array('statusCode' => 500, "errores" => $this->errores));
            } else {
                $data = array("marca" => $marcas);
                $this->marcas->save($data);
                echo json_encode(array('statusCode' => 200));
            }
        } else {
            require_once ERROR404;
        }
    }

    private function ValidarMarca($nombreMarca)
    {
        require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta

        // Comprobar si el campo 'nombreMarca' está vacío
        if (empty($nombreMarca)) {
            $this->errores["marca"] = "Debe ingresar un valor en marca";
        } else {
            // Comprobar si ya existe el valor en la base de datos
            $sql = "SELECT * FROM tb_marca_producto WHERE nombreMarca = '$nombreMarca'";
            $resultado = $mysqli->query($sql);

            if ($resultado->num_rows > 0) {
                $this->errores["marca"] = "El valor de marca ya existe";
            }
        }
    }



    public function varMarcaID($id)
    {
        echo json_encode(array('statusCode' => 200, 'marca' => $this->marcas->getMarcaID($id)));
    }




    public function actualizar($id)
    {
        $marcas = $_POST["txtMarca"];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->ValidarMarca($marcas);

            if ($this->errores) {
                echo json_encode(array('statusCode' => 500, "errores" => $this->errores));
            } else {
                $data = ["marca" => $marcas];
                $this->marcas->update($id, $data);
                echo json_encode(array('statusCode' => 200));
            }
        } else {
            require_once ERROR404;
        }
    }


    // funcion para eliminar categorias segun id
    public function eliminar($id)
    {
        $data["validar"] = $this->marcas->ValidarMarcaP($id);
        if($data["validar"]=== NULL){
            $this->marcas->delete($id);
            header("Location: administrador.php?c=MarcaController"); // funcion para regresar a la funcion index del controlador
        }else{
            require_once ERROR403;
        }
    }
}
