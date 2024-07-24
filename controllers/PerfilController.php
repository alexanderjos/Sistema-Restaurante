<?php
    class PerfilController{
        protected $perfil;
        protected $validaciones;
        protected $errores;

        public function __construct(){

            require_once "../models/PerfilModel.php";
            require_once "../controllers/ValController.php";
            $this->perfil = new PerfilModel();
            $this->validaciones = new ValController();
            $this->errores = array();
        }
        public function index(){
            $data["contenido"] = "../views/Perfil/perfil.php";
            require_once TEMPLATE;
        }
        public function indexMC(){
            $data["contenido"] = "../views/Perfil/perfil.php";
            require_once TEMPLATEMZ;
        }
        public function indexCJ(){
            $data["contenido"] = "../views/Perfil/perfil.php";
            require_once TEMPLATECJ;
        }
        public function cambiarContraseña(){
            $id = $_POST["txtEmpleadoID"];
            $contraseña1 = $_POST["txtContraseña1"];
            $contraseña2 = $_POST["txtContraseña2"];
            if (isset($_POST["btnEnviar"])){
                $this->validarpass($contraseña1,$contraseña2);
                if ($this->errores) {
                    $data["errores"] = $this->errores;
                    $data["contenido"] = "../views/Perfil/perfil.php";
                    if($_SESSION["tipoEmpleado"]=="Administrador"){
                        require_once TEMPLATE;
                    }elseif ($_SESSION["tipoEmpleado"]=="mozo"){
                        require_once TEMPLATEMZ;
                    }elseif ($_SESSION["tipoEmpleado"]=="cajero"){
                        require_once TEMPLATECJ;
                    }
                } else {
                    $data = array(
                        "pass" => md5($_POST["txtContraseña1"])
                    );

                    $this->perfil->cambiar($id,$data);
                    $_SESSION['mensaje'] = "Contraseña Actualizada";
                    header("Location:../views/" . $_SESSION['tipoEmpleado'] . ".php?c=PerfilController");

                }
            } else {
                require_once ERROR404;
            }
        }
        private function validarpass($valor,$valor2){
            if (!$this->validaciones->validarRequeridos($valor)) {
                $this->errores["Contraseña"] = "Debes ingresar un valor en el campo contraseña";
            } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/", $valor)) {
                $this->errores["Contraseña"] = "La contraseña debe tener al menos 8 caracteres, no más de 16 caracteres <br> y debe incluir al menos una letra mayúscula, una letra minúscula y un dígito numérico.";
            }else if($valor != $valor2){
                $this->errores["Contraseña"] = "Las contraseña deben de ser iguales";
            }
            return $this->errores;
        }
    }
?>