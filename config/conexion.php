<?php
    //Coenexion de base de datos

    $mysqli = new mysqli("localhost","root","","bd_praia");

    if($mysqli->connect_error){
        die("Erroe en la conexión" .$mysqli->connect_error);
    }
    
?>