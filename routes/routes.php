<?php 
// Validar controladores: GET
function validarControlador($controlador){
    $nombreControlador = $controlador;
    $fileControlador = "../controllers/".$nombreControlador.".php";

    if(!is_file($fileControlador)){
        return "";
    }else{
        require_once $fileControlador;
        $control = new $nombreControlador();
        return $control;
    }
}
// Validar acciones: GET

function validarAccion($controlador, $accion, $id=null){
    if($controlador!=""){
        if(isset($accion) && method_exists($controlador, $accion)){
            
            if ($id == null) {
                $controlador->$accion();
            } else {
                $controlador->$accion($id);
            }
        }else{
            require_once ERROR404;
            //echo "Error en la accion";
        }
    }else{
        require_once ERROR404;
        //echo "Error en el controlador";
    }
}



?>