<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }    
    if($_SESSION["idTipoEmpleado"]=="002"){
        date_default_timezone_set("America/Lima");

        require_once "../config/Conectar.php";
        require_once "../config/config.php";
        require_once "../routes/routes.php";
        
        
        
        if (isset($_GET["c"])) {
            $controlador = validarControlador($_GET["c"]);
        
            if(isset($_GET["a"])){ // variable a= acción enviado por GET
        
                if(isset($_GET["id"])){  // variable id= id de registro para eliminar o actualizar enviado por GET
                    validarAccion($controlador, $_GET['a'], $_GET['id']);
                }else{
                    validarAccion($controlador, $_GET['a']);
                }
            }else{
                validarAccion($controlador, ACCION_DEFAULT_MC);
            }
        } else {
            $control = validarControlador(CONTROLADOR_DEFAULT_MC);
            $accionTMP = ACCION_DEFAULT_MC;
            if (!is_object($control)) {
                echo "Error: El controlador de inicio de sesión no se ha cargado correctamente.";
            } else {
        
                $control->$accionTMP();
            }
        }
        
        
    }else{
        header("Location: ../index.php");
    }
    
?>
