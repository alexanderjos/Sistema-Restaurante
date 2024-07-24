<?php 
    class InicioModel{
        protected $db;
        protected $admin;
        public function __construct(){
            $this->db = Conectar::Conectar();
            $this->admin = array();
        }
        public function cantidadProductos(){
            $sql = "SELECT COUNT(*) as cantidad_productos FROM tb_producto";
            $resultado = $this->db->query($sql);
            $row = $resultado->fetch_assoc();
            return $row;
        }
        public function Totales(){
            $sql = "SELECT SUM(total) as suma_totales FROM tb_pedido";
            $resultado = $this->db->query($sql);
            $row = $resultado->fetch_assoc();
            return $row;
        }
        public function VentaFecha($fecha_actual){
            $sql = "SELECT SUM(total) as monto_total_ventas FROM tb_pedido WHERE Fecha = '$fecha_actual'";
            $resultado = $this->db->query($sql);
            $row = $resultado->fetch_assoc();
            return $row;
        }
        public function ProductosconStockMenor() {
            $sql = "SELECT * FROM tb_producto WHERE stock < 3 and stock >0";
            $resultado = $this->db->query($sql);
        
            // Verificar si se obtuvieron resultados
            if ($resultado->num_rows > 0) {
                // Obtener todas las filas
                $productos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $productos;
            }else{
                return null;
            }
        }
        public function ProductosMasVendidos(){
            $sql ="SELECT p.nombreProducto, SUM(cantidad) as totalVendido, SUM(subtotal) as totalSubtotal
                   FROM tb_detalle_pedido dp 
                   INNER JOIN tb_producto p on dp.idProducto = p.idProducto 
                   GROUP BY dp.idProducto ORDER BY totalVendido DESC LIMIT 10";
                   $resultado = $this->db->query($sql);
        
            // Verificar si se obtuvieron resultados
            if ($resultado->num_rows > 0) {
                // Obtener todas las filas
                $productos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $productos;
            }else{
                return null;
            }
        }
        public function clientesRecurrentes(){
            $sql ="SELECT cli.nombreCliente,cli.apellidoCliente, COUNT(idPedido) AS frecuencia
                    FROM tb_pedido pe
                    INNER JOIN tb_cliente cli on cli.id_Cliente = pe.idCliente
                    GROUP BY idCliente
                    ORDER BY frecuencia DESC
                    LIMIT 10";
                   $resultado = $this->db->query($sql);
        
            // Verificar si se obtuvieron resultados
            if ($resultado->num_rows > 0) {
                // Obtener todas las filas
                $clientes = $resultado->fetch_all(MYSQLI_ASSOC);
                return $clientes;
            }else{
                return null;
            }
        }
    }

?>