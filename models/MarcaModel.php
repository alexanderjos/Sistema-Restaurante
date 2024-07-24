<?php

class MarcaModel
{

    protected $db;
    protected $marca;

    public function __construct()
    {
        $this->db = Conectar::Conectar();
        $this->marca = array();
    }

    public function getMarcas()
    {

        $sql = "SELECT * FROM tb_marca_producto";
        $resultado = $this->db->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            $this->marca[] = $row;
        }
        return $this->marca;
    }


    public function save($data)
    {
        $sql = "INSERT INTO tb_marca_producto (nombreMarca)
                            VALUES('" . $data["marca"] . "') ";
        $this->db->query($sql);
    }


    public function getMarcaID($id)
    {
        $sql = "SELECT * FROM tb_marca_producto where idMarca = $id limit 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function update($id, $data)
    {

        $consulta = "UPDATE tb_marca_producto set nombreMarca ='" . $data['marca'] . "' 
                                          where idMarca = '$id'";
        $this->db->query($consulta);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tb_marca_producto where idMarca = '$id'";
        $this->db->query($sql);
    }
    public function validarMarcaP($idMarca){
        $sql = "SELECT * FROM tb_producto where idMarca = $idMarca limit 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
}
