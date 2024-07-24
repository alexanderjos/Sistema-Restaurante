<?php 
session_start();

require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        echo '<div>Campos Vacios</div>';
    } else {
        $usuario = $_POST["usuario"];
        $contraseña = md5($_POST["password"]);
        $sql = "SELECT * FROM tb_usuario WHERE Usuario = '$usuario' AND Contraseña = '$contraseña'";
        $resultado = $mysqli->query($sql);
        $fila = mysqli_num_rows($resultado); 

        if ($fila) {
            $sql1 = "SELECT e.* FROM tb_empleado e INNER JOIN tb_usuario u ON u.Usuario = e.idEmpleado WHERE u.Usuario = '$usuario'";
            $resultado1 = $mysqli->query($sql1);
            $sql2 = "SELECT te.nombreTipoEmpleado FROM tb_empleado e 
                            INNER JOIN tb_usuario u ON u.Usuario = e.idEmpleado 
                            INNER JOIN tb_tipo_empleado te ON e.idTipoEmpleado = te.idTipoEmpleado
                            WHERE u.Usuario = '$usuario'";
            $resultado2 = $mysqli->query($sql2);
            if ($resultado1->num_rows > 0) {
                $datos = $resultado1->fetch_object();
                $datos1 = $resultado2->fetch_object();
                $tipoEmpleado = $datos->idTipoEmpleado;
                $estado = $datos->estado;
                // Asignar los valores a las variables de sesión
                $_SESSION["DNI"] = $datos->idEmpleado;
                $_SESSION["nombre"] = $datos->nombreEmpleado;
                $_SESSION["apellido"] = $datos->apellidoEmpleado;
                $_SESSION["imagen"]= $datos->imagen;
                $_SESSION["idEmpleado"]= $datos->idEmpleado;
                $_SESSION["idTipoEmpleado"]= $tipoEmpleado;
                $_SESSION["tipoEmpleado"]= $datos1->nombreTipoEmpleado;
                $_SESSION["fechaIngreso"]= $datos->fecha_registro;
                if($estado == '1'){
                    // Realizar la redirección basada en el tipo de empleado
                    if ($tipoEmpleado == '001') {
                        header("Location: ../views/administrador.php");
                        exit;
                    } elseif ($tipoEmpleado == '002') {
                        header("Location: ../views/mozo.php");
                        exit;
                    } elseif ($tipoEmpleado == '003') {
                        header("Location: ../views/cajero.php");
                        exit;
                    }
                }else{
                    echo '<div>Usuario Inhabilitado</div>';
                }
            } else {
                echo '<div>Acceso Denegado</div>';
            }
        } else {
            echo '<div>Usuario o Contraseña incorrecta</div>';
        }
    }
}
?>
