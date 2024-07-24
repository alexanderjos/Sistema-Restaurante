<?php
require_once "../config/conectar.php";

class VentaModel {
    protected $db;
    protected $venta;

    public function __construct() {
        $this->db = Conectar::Conectar();
        $this->venta = array();
    }

    public function obtenerVenta($id) {
        $sql = "SELECT v.*, cli.*, e.*
                FROM tb_pedido v 
                INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
                INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
                WHERE  v.idPedido ='$id'";         
        $resultado = $this->db->query($sql);
    
        // Obtener la única fila de resultados (si existe)
        $venta = $resultado->fetch_assoc();
    
        return $venta;
    }
    
    public function obtenerdtVenta($id){
        $sql = "SELECT v.*, d.*,tp.*,pro.*,mr.*
                FROM tb_pedido v 
                INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
                INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
                INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto
                INNER JOIN tb_marca_producto mr on pro.idMarca = mr.idMarca
                WHERE  v.idPedido ='$id'";         
        $resultado = $this->db->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            $this->venta[] = $row;
        }

        return $this->venta;
    }
}
?>
