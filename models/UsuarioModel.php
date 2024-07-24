<?php

class UsuarioModel
{

    protected $db;
    protected $usuario;

    public function __construct()
    {
        $this->db = Conectar::Conectar();
        $this->usuario = array();
    }

    public function getUsuarios()
    {

        $sql = "SELECT e.*, u.* FROM tb_empleado e INNER JOIN tb_usuario u ON e.idEmpleado = u.Usuario";
        $resultado = $this->db->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            $this->usuario[] = $row;
        }

        return $this->usuario;
    }


    public function save($data)
    {
        $sql = "INSERT INTO tb_empleado (idEmpleado, idTipoEmpleado, nombreEmpleado, apellidoEmpleado, imagen, estado, fecha_registro)
                            VALUES('" . $data["DNI"] . "',
                                   '" . $data["tipo"] . "',
                                   '" . $data["nombres"] . "',
                                   '" . $data["apellidos"] . "',
                                   '" . $data["imagen"] . "',
                                   '" . $data["estado"] . "',
                                   '" . $data["fechaRegistro"] . "') ";
        $this->db->query($sql);
        $sql1 = "INSERT INTO tb_usuario(Usuario,Contraseña) 
                            values ('" . $data["DNI"] . "',
                                    '" . $data["pass"] . "')";
        $this->db->query($sql1);
    }


    public function getUsuarioID($Usuario)
    {
        $Usuario = $this->db->real_escape_string($Usuario); // Escapar el valor para prevenir inyección SQL
        $sql = "SELECT e.*, u.* FROM tb_empleado e INNER JOIN tb_usuario u ON e.idEmpleado = u.Usuario WHERE e.idEmpleado = '$Usuario'";
        $resultado = $this->db->query($sql);

        if ($resultado) {
            $row = $resultado->fetch_assoc();
            return $row;
        } else {
            return null; // Manejo de errores si la consulta no se ejecuta correctamente
        }

    }

    public function update($Usuario, $data)
    {
        $consulta = "UPDATE tb_empleado SET nombreEmpleado = '" . $data['nombres'] . "', 
                                    apellidoEmpleado = '" . $data['apellidos'] . "', 
                                    imagen = '" . $data['imagen'] . "',
                                    estado = '" . $data['estado'] . "',
                                    idTipoEmpleado = '" . $data['tipo'] . "',
                                    fecha_registro = '" . $data['fecha_registro'] . "',
                                    fecha_edicion = '" . $data['fecha_edicion'] . "'
                                    WHERE idEmpleado = '$Usuario'";
        $consult = "UPDATE tb_usuario SET contraseña = '" . $data['pass'] . "' WHERE Usuario = '$Usuario'";
        $this->db->query($consulta);
        $this->db->query($consult);
    }

    public function delete($Usuario)
    {
        $sql = "DELETE FROM tb_usuario where Usuario = '$Usuario'";
        $this->db->query($sql);
        $sql = "DELETE FROM tb_empleado where idEmpleado = '$Usuario'";
        $this->db->query($sql);
    }
    public function DarBaja($idEmpleado,$estado)
    {
        $consulta = "UPDATE tb_empleado SET estado = '$estado' WHERE idEmpleado = '$idEmpleado'";
        $this->db->query($consulta);
    }
    public function Activar($idEmpleado,$estado)
    {
        $consulta = "UPDATE tb_empleado SET estado = '$estado' WHERE idEmpleado = '$idEmpleado'";
        $this->db->query($consulta);
    }


   
    public function validarUsuarioR($idUsuario){

        $sql = "SELECT*FROM tb_pedido where idEmpleado = '$idUsuario' ";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        if ($row) {
            return true;
        } else {
            return false;
        }
    }
    
}