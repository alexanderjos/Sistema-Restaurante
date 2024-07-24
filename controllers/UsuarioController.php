<?php
class UsuarioController
{

    protected $usuarios;
    protected $validaciones;
    protected $errores;

    public function __construct()
    {


        require_once "../models/UsuarioModel.php";
        require_once "../controllers/ValController.php";
        $this->usuarios = new UsuarioModel();
        $this->validaciones = new ValController();
        $this->errores = array();
    }

    //deben tener la funcion index();
    public function index()
    {
        $data["titulo"] = "GESTIÓN DE USUARIOS";
        $data["resultado"] = $this->usuarios->getUsuarios();
        $data["contenido"] = "../views/usuarios/usuario.php";
        require_once TEMPLATE;
    }

    //function para abrir formulario de registro de usuarios
    public function nuevo()
    {
        $data["titulo"] = "FORMULARIO DE REGISTRO DE USUARIOS";
        $data["contenido"] = "../views/usuarios/usuario_nuevo.php";
        require_once TEMPLATE;
    }


    // funcion para registrar datos de nuevos usuarios
    public function registrar()
    {
        //variables reciben mediante el metodo POST
        $nombres = $_POST["txtNombres"];
        $apellidos = $_POST["txtApellidos"];
        $pass = $_POST["txtPassword"];
        $estado = $_POST["cboEstado"];
        $tipo = $_POST["cboTipo"];
        $DNI = $_POST["txtDNI"];


        if (isset($_POST["btnEnviar"])) {

            $nomArchivo = $_FILES["imagen"]["name"];
            $nomTemporal = $_FILES["imagen"]["tmp_name"];
            $fileSize = $_FILES["imagen"]["size"];
            $extension =  pathinfo($nomArchivo, PATHINFO_EXTENSION);
            $nomArchivo = substr(md5(time()), 0, 10) . "." . $extension;
            $this->validarDNI($DNI);
            $this->validarNombres($nombres);
            $this->validarApellidos($apellidos);
            $this->validarpass($pass);
            $this->validarImagen($extension, $fileSize);
            $this->validarEstado($estado);
            $this->validarTipo($tipo);


            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["titulo"] = "FORMULARIO DE REGISTRO DE USUARIOS";
                $data["contenido"] = "../views/usuarios/usuario_nuevo.php";
                require_once TEMPLATE;
            } else {

                move_uploaded_file($nomTemporal, "../public/users/" . $nomArchivo);

                $data = array(
                    "DNI" => $_POST["txtDNI"],
                    "nombres" => $_POST["txtNombres"],
                    "apellidos" => $_POST["txtApellidos"],
                    "pass" => md5($_POST["txtPassword"]),
                    "imagen" => $nomArchivo,
                    "estado" => $_POST["cboEstado"],
                    "tipo" => $_POST["cboTipo"],
                    "fechaRegistro" => date("Y-m-d H:i:s")
                );

                $this->usuarios->save($data);
                $_SESSION['mensaje'] = "Datos registrados correctamente";
                header("Location:../views/administrador.php?c=UsuarioController");
            }
        } else {
            require_once ERROR404;
        }
    }


    // funcion para obtener vista con datos de usuario mediante id
    public function verUsuario($Usuario)
    {
        $data["titulo"] = "ACTUALIZAR DATOS DE USUARIO";
        $data["consulta"] = $this->usuarios->getUsuarioID($Usuario); // obtiene los datos de un usuario por ID.
        $data["contenido"] = "../views/usuarios/usuario_actualizar.php";
        require_once "../views/dashboard/template.php";
    }

    public function actualizar()
    {
        // Variables reciben mediante el método POST
        $id = $_POST["txtDNI"];
        $nombres = $_POST["txtNombres"];
        $apellidos = $_POST["txtApellidos"];
        $email = $_POST["txtDNI"];
        $pass = $_POST["txtPassword"];
        $estado = $_POST["cboEstado"];
        $tipo = $_POST["cboTipo"];
        if (isset($_POST["btnEnviar"])) {

            $nomArchivo = $_FILES["imagen"]["name"];
            $nomTemporal = $_FILES["imagen"]["tmp_name"];
            $fileSize = $_FILES["imagen"]["size"];
            $extension =  pathinfo($nomArchivo, PATHINFO_EXTENSION);
            $nomArchivo = substr(md5(time()), 0, 10) . "." . $extension;

            $this->validarNombres($nombres);
            $this->validarApellidos($apellidos);
            
            $this->validarImagen($extension, $fileSize);
            $this->validarEstado($estado);
            $this->validarTipo($tipo);


            if ($this->errores) {
                $data["errores"] = $this->errores;
                $data["consulta"] = $this->usuarios->getUsuarioID($id);
                $data["titulo"] = "FORMULARIO PARA ACTUALIZAR USUARIO";
                $data["contenido"] = "../views/usuarios/usuario_actualizar.php";
                require_once TEMPLATE;
            } else {

                // if ($nomTemporal != "") { // verifica si hay imagen a enviar
                //     unlink("../public/users/" . $_POST["txtFile"]); //se tiene que eliminar la imagen asociada al usuario
                //     move_uploaded_file($nomTemporal, "../public/users/" . $nomArchivo); // movemos la nueva imagen con el nuevo nombre
                // } else { // si no se esta enviando imagen
                //     $nomArchivo = $_POST["txtFile"]; // se asigna el mismo nombre de la imagen que tenia registrado anteriormente.
                // }


                require_once "../config/conexion.php";

                $sql = "SELECT Contraseña FROM tb_usuario WHERE Usuario = '$id'";
                $resultado = $mysqli->query($sql);
                if ($resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    $contraseña = $fila["Contraseña"];
                    if ($contraseña == $pass) {
                        $data = array(
                            "nombres" => $_POST["txtNombres"],
                            "apellidos" => $_POST["txtApellidos"],
                            "pass" => $pass,
                            "imagen" => $nomArchivo,
                            "estado" => $_POST["cboEstado"],
                            "tipo" => $_POST["cboTipo"],
                            "fecha_registro" => $_POST["txtFechRegistro"],
                            "fecha_edicion" => date("Y-m-d H:i:s"),
                        );
                    } else {
                        $this->validarpass($pass);
                        $data = array(
                            "nombres" => $_POST["txtNombres"],
                            "apellidos" => $_POST["txtApellidos"],
                            "pass" => md5($pass),
                            "imagen" => $nomArchivo,
                            "estado" => $_POST["cboEstado"],
                            "tipo" => $_POST["cboTipo"],
                            "fecha_registro" => $_POST["txtFechRegistro"],
                            "fecha_edicion" => date("Y-m-d H:i:s"),
                        );
                    }
                }

                $this->usuarios->update($id, $data);
                /**
                 * Cramos una variable "mensaje" de tipo sesión el cual se utilizará para mostrar el mensaje en la vista usuario
                 */
                $_SESSION['mensaje'] = "Datos actualizados correctamente";
                header("Location: ../views/administrador.php?c=UsuarioController");
            }
        } else {
            require_once ERROR404;
        }
    }


    // funcion para eliminar usuarios segun id
    public function eliminar($Usuario)
    {
        $data["usuarioD"]  = $this->usuarios->validarUsuarioR($Usuario);
        if($data["usuarioD"]===null){
            $user = $this->usuarios->getUsuarioID($Usuario);
            $this->usuarios->delete($Usuario);
            unlink("../public/users/" . $user["imagen"]); // funcion para eliminar imagen de usuario
            $_SESSION['mensaje'] = "Datos eliminados correctamente";
            header("Location: ../views/administrador.php?c=UsuarioController");
        }else{
            require_once ERROR403;
        }
    }
    public function DarBaja($Usuario)
    {
        $user = $this->usuarios->getUsuarioID($Usuario);
        if($user["estado"] == "1"){
            $this->usuarios->DarBaja($Usuario,0);
            $_SESSION['mensaje'] = "Usurio dado de Baja";
            header("Location: ../views/administrador.php?c=UsuarioController"); // funcion para regresar a la funcion index del controlador
        }else{
            $_SESSION['mensaje'] = "El usuario ya se encontraba inactivo";
            header("Location: ../views/administrador.php?c=UsuarioController");
        }
        
    }
    public function Activar($Usuario)
    {
        $user = $this->usuarios->getUsuarioID($Usuario);
        if($user["estado"] == "0"){
            $this->usuarios->Activar($Usuario,1);
            $_SESSION['mensaje'] = "Usurio Activo";
            header("Location: ../views/administrador.php?c=UsuarioController"); // funcion para regresar a la funcion index del controlador
        }else{
            $_SESSION['mensaje'] = "El usuario ya se encontraba activo";
            header("Location: ../views/administrador.php?c=UsuarioController");
        }
    }
    private function validarNombres($valor)
    {
        $opciones = array(
            "options" => array(
                "min_range" => 3,
                "max_range" => 20
            )
        );

        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["nombreEmpleado"] = "Debes ingresar un valor en el campo nombres";
        } else if (!$this->validaciones->validarLongitudes($valor, $opciones)) {
            $this->errores["nombreEmpleado"] = "Longitud de caracteres inválidos para el campo nombre";
        }
        return $this->errores;
    }

    private function validarApellidos($valor)
    {
        $opciones = array(
            "options" => array(
                "min_range" => 3,
                "max_range" => 60
            )
        );
        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["apellidoEmpleado"] = "Debes ingresar un valor en el campo apellidos";
        } else if (!$this->validaciones->validarLongitudes($valor, $opciones)) {
            $this->errores["apellidoEmpleado"] = "Longitud de caracteres inválidos para el campo Apellidos";
        }
        return $this->errores;
    }
    private function validarpass($valor)
    {
        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["Contraseña"] = "Debes ingresar un valor en el campo contraseña";
        } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/", $valor)) {
            $this->errores["Contraseña"] = "La contraseña debe tener al menos 8 caracteres, no más de 16 caracteres <br> y debe incluir al menos una letra mayúscula, una letra minúscula y un dígito numérico.";
        }
        return $this->errores;
    }
    private function validarDNI($valor) {
        // Incluye el archivo de conexión
        require_once "../config/conexion.php";
    
        // Escapa el valor del DNI para evitar inyección de SQL
        $valor = $mysqli->real_escape_string($valor);
    
        // Realiza la consulta SQL para verificar si el DNI existe en la base de datos
        $sql = "SELECT * FROM tb_empleado WHERE idEmpleado = '$valor'";
        $resultado = $mysqli->query($sql);
    
        if (!$this->validaciones->validarRequeridos($valor)) {
            $this->errores["idEmpleado"] = "Debes ingresar un valor en el campo DNI";
        } else if ($resultado->num_rows > 0) {
            $this->errores["idEmpleado"] = "Ya hay una persona registrada con ese DNI";
        }
    

    
        return $this->errores;
    }
    
    private function validarImagen($extension, $img)
    {
        $extensionesValidas = array("jpg", "png", "jpeg", "gif");

        $max_file_size = "5000000"; // convertido a MB representaria 25MB, tener en cuenta que un 1MB = 1024KB

        if (!in_array($extension, $extensionesValidas)) {
            $this->errores["imagen"] = "Extensión de archivo invalido o no se ha subido ningun valor";
        } else if ($img > $max_file_size) {
            $this->errores["imagen"] = "La imagen debe tener un tamaño inferior a 5MB";
        }
        return $this->errores;
    }


    private function validarEstado($valor)
    {
        switch ($valor) {
            case '0':
            case '1':
                break;
            default:
                $this->errores["estado"] = "Valores no permitidos de campo estado";
                break;
        }
        return $this->errores;
    }

    private function validarTipo($valor)
    {
        switch ($valor) {
            case '001':
            case '002':
            case '003':
                break;
            default:
                $this->errores["tipo"] = "Valores no permitidos de campo Tipo";
                break;
        }
        return $this->errores;
    }
}
