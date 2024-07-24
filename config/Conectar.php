<?php 
class Conectar{
    public static function Conectar(){
        $conexion = new mysqli("localhost", "root","", "bd_praia");
        if($conexion->connect_errno){
            die("Error inesperado en la conexión a base de datos: ". $conexion->connect_errno);
        }else{
            return $conexion; 
        }
    }
}
?>
