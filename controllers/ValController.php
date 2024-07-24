<?php 

class ValController{

    //funcion para validar datos requeridos/obligatorios
    public function validarRequeridos($valor){
        if($valor!=""){
            return true;
        }else{
            return false;
        }
    }
    //funcion para validar longitudes de campos

    public function validarLongitudes($valor, $opciones){
        $longitud = strlen($valor);
        if(filter_var($longitud, FILTER_VALIDATE_INT, $opciones)===false){
            return false;
        }else{
            return true;
        }

    }
}
?>
