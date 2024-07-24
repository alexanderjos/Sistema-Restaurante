<?php 

//declaracion de constantes:

define("CONTROLADOR_DEFAULT", "InicioController");
define("ACCION_DEFAULT", "index");
define("ERROR404", "../views/errors/error404.php");
define("ERROR403", "../views/errors/error403.php");
define("TEMPLATE", "../views/dashboard/template.php");

//MOZO
define("TEMPLATEMZ", "../views/dashboard/mozo.php");
define("CONTROLADOR_DEFAULT_MC", "PerfilController");
define("ACCION_DEFAULT_MC", "indexMC");

//Cajero
define("TEMPLATECJ", "../views/dashboard/caja.php");
define("ACCION_DEFAULT_CJ", "indexCJ");

//pdf
define("PDF","../fpdf/fpdf.php");
?>