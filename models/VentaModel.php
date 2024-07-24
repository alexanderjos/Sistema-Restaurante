<?php
class VentaModel {
    protected $db;
    protected $venta;

    public function __construct() {
        require_once "../config/conexion.php";
        $this->db = Conectar::Conectar();
        $this->venta = array();
    }

    public function obtenerDetallesDeTodasLasVentas() {
        // Consulta SQL para obtener todos los detalles de ventas
        $query = "SELECT v.*, d.*, cli.*,tp.*,pro.*,e.*
                    FROM tb_pedido v 
                    INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
                    INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
                    INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
                    INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
                    INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto";

        $result = $this->db->query($query);

        $detallesVentas = [];

        while ($row = $result->fetch_assoc()) {
            $detallesVentas[] = $row;
        }

        return $detallesVentas;
    }
    public function obtenerDetallesVentasMozo($idEmpleado) {
        // Consulta SQL para obtener todos los detalles de ventas
        $query = "SELECT v.*, d.*, cli.*,tp.*,pro.*,e.*
                    FROM tb_pedido v 
                    INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
                    INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
                    INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
                    INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
                    INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto
                    WHERE v.idEmpleado = '$idEmpleado' and v.Conformidad ='Pendiente de envio'";

        $result = $this->db->query($query);

        $detallesVentas = [];

        while ($row = $result->fetch_assoc()) {
            $detallesVentas[] = $row;
        }

        return $detallesVentas;
    }
    public function obtenerDetallesDeTodasLasVentasActual($date) {
        // Consulta SQL para obtener todos los detalles de ventas
        $query = "SELECT v.*, d.*, cli.*,tp.*,pro.*,e.*
                    FROM tb_pedido v 
                    INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
                    INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
                    INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
                    INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
                    INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto
                    WHERE v.Fecha = '$date'";

        $result = $this->db->query($query);

        $detallesVentas = [];

        while ($row = $result->fetch_assoc()) {
            $detallesVentas[] = $row;
        }

        return $detallesVentas;
    }
    public function obtenerVentaFechas($fehcaInicio, $fechaFin) {
        // Consulta SQL para obtener todos los detalles de ventas
        $query = "SELECT v.*, d.*, cli.*,tp.*,pro.*,e.*
                    FROM tb_pedido v 
                    INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
                    INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
                    INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
                    INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
                    INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto
                    WHERE v.Fecha >= '$fehcaInicio' AND v.Fecha <= '$fechaFin'";

        $result = $this->db->query($query);

        $detallesVentas = [];

        while ($row = $result->fetch_assoc()) {
            $detallesVentas[] = $row;
        }

        return $detallesVentas;
    }
    public function insertarCliente($cliente){
        $query = "SELECT * FROM tb_cliente WHERE id_Cliente = '{$cliente['DNI']}'";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            return false;
        } else {
            $sql = "INSERT INTO tb_cliente (id_Cliente , nombreCliente, apellidoCliente)
                            VALUES('" . $cliente['DNI'] . "',
                                   '" . $cliente['Nombre'] . "',
                                   '" . $cliente['Apellido']. "') ";
            $this->db->query($sql);
        }
    }
    public function insertarVenta($cliente,$mozo,$venta){
        $estado = "Pendiente de envio";
        $fecha = date("Y-m-d");
        $sql = "INSERT INTO tb_pedido (Correlativo,idCliente , Conformidad, idEmpleado,igv,opGravda,Total,Fecha )
                            VALUES('" . $venta['Correlativo'] . "',
                                   '" . $cliente['DNI'] . "',
                                   '" . $estado . "',
                                   '" . $mozo["idMozo"] . "',
                                   '" . $venta["igv"] . "',
                                   '" . $venta["opgravada"] . "',
                                   '" . $venta["totalVenta"] . "',
                                   '" . $fecha. "') ";
        $this->db->query($sql);
    }
    public function insertarDetalleVenta($venta,$producto){
        foreach ($producto as $detallesVentas) {
            $idVenta = $venta['numeroSerie'];
            $idProducto = $detallesVentas['codigoProducto'];
            $cantidad = $detallesVentas['cantidad'];
            $subtotal = $detallesVentas['total'];
            $stock = $detallesVentas['stock'];
            $sql = "INSERT INTO tb_detalle_pedido (idPedido , idProducto, cantidad,subtotal )
                            VALUES('" . $idVenta . "',
                                    '" . $idProducto . "',
                                    '" . $cantidad . "',
                                    '" . $subtotal . "') ";
            $this->db->query($sql); 
            //Actualizar Stock
            $sql1 = "UPDATE tb_producto SET stock = '$stock' where idProducto ='$idProducto' ";
            $this->db->query($sql1);          
        }
    }
    public function actualizarVenta($id){
        $estado = "En caja";
        $sql = "UPDATE tb_pedido SET Conformidad = '$estado' WHERE idPedido = '$id'";

        $this->db->query($sql);
    }
    public function VentaPagada($id,$pago){
        $estado = "Pagada";
        $hora = date("H:i:s");
        $sql = "UPDATE tb_pedido SET Conformidad = '$estado', metodoPago = '{$pago["metodo"]}', montoRecibido = '{$pago["efectivo"]}',vuelto = '{$pago["vuelto"]}' ,Hora ='$hora' WHERE idPedido = '$id'";
        $this->db->query($sql);
    }
    public function obtenerVentaCaja($id){
               // Consulta SQL para obtener todos los detalles de ventas
        $query = "SELECT v.*, d.*, cli.*,tp.*,pro.*,e.*
               FROM tb_pedido v 
               INNER JOIN tb_detalle_pedido d ON v.idPedido = d.idPedido 
               INNER JOIN tb_empleado e ON e.idEmpleado = v.idEmpleado
               INNER JOIN tb_cliente cli ON v.idCliente = cli.id_Cliente
               INNER JOIN tb_producto pro  on pro.idProducto = d.idProducto
               INNER JOIN tb_tipo_producto tp on pro.idTipoProducto = tp.idTipo_Producto
               WHERE  v.Conformidad ='En caja'";

        $result = $this->db->query($query);

        $detallesVentas = [];

        while ($row = $result->fetch_assoc()) {
            $detallesVentas[] = $row;
        }

        return $detallesVentas;
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
