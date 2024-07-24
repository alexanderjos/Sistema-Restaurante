<?php

class ProductoModel
{

    protected $db;
    protected $producto;

    public function __construct()
    {
        $this->db = Conectar::Conectar();
        $this->producto = array();
    }

    public function getProducto(){

        $sql = "SELECT  pro.idProducto,
                        mar.nombreMarca,
                        tp.nombre_tipoProducto,
                        pro.nombreProducto,
                        pro.descripciónProducto,
                        pro.precioUnitario,
                        pro.stock
                FROM tb_producto pro
                LEFT JOIN tb_marca_producto mar ON mar.idMarca = pro.idMarca
                LEFT JOIN tb_tipo_producto tp ON tp.idTipo_Producto = pro.idTipoProducto;";
        $resultado = $this->db->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            $this->producto[] = $row;
        }

        return $this->producto;
    }


    public function save($data){
        $sql = "INSERT INTO tb_producto (nombreProducto, idMarca, idTipoProducto, descripciónProducto, precioUnitario, stock)
                VALUES('" . $data["nombre"] . "',
                    '" . $data["marca"] . "',
                    '" . $data["tipoProducto"] . "',
                    '" . $data["descripcion"] . "',
                    '" . $data["precio"] . "',
                    '" . $data["stock"] . "')"; // Agregamos el paréntesis de cierre
        $this->db->query($sql);
    }
    public function getProductoID($id)
    {
        $sql = "SELECT * FROM tb_producto  WHERE idProducto = '$id'";
        $resultado = $this->db->query($sql);

        if ($resultado) {
            $row = $resultado->fetch_assoc();
            return $row;
        } else {
            return null; // Manejo de errores si la consulta no se ejecuta correctamente
        }

    }
    public function update($id, $data)
    {

        $consulta = "UPDATE tb_producto SET nombreProducto = '" . $data["nombre"] . "',
                                            idMarca = '" . $data["marca"] . "',
                                            idTipoProducto = '" . $data["tipoProducto"] . "',
                                            descripciónProducto = '" . $data["descripcion"] . "',
                                            precioUnitario = '" . $data["precio"] . "',
                                            stock = '" . $data["stock"] . "' 
                                            where idProducto = '$id'";
        $this->db->query($consulta);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM tb_producto where idProducto = '$id'";
        $this->db->query($sql);
    }
    public function updateStock($id, $data)
    {

        $consulta = "UPDATE tb_producto set stock ='" . $data['stock'] . "' 
                                          where idProducto = '$id'";
        $this->db->query($consulta);
    }
    public function validarProductoV($idProducto){
        $sql = "SELECT * FROM tb_detalle_pedido  WHERE idProducto = '$idProducto'";
        $resultado = $this->db->query($sql);

        if ($resultado) {
           return True;
        } else {
            return null; // Manejo de errores si la consulta no se ejecuta correctamente
        }
    }


    
}