<?php 
    class InicioController{
        protected $admin;
        protected $validaciones;
        protected $errores;

        public function __construct(){
            require_once "../models/InicioModel.php";
            require_once "../controllers/ValController.php";
            $this->admin = new InicioModel();
            $this->validaciones = new ValController();
            $this->errores = array();
        }
        public function index(){
            
            $fecha_actual = date("Y-m-d");
            $Total = $this->admin->Totales();
            $Fecha = $this->admin->VentaFecha($fecha_actual);
            $producto = $this->admin->cantidadProductos();
            $productos["poco_stock"] = $this->admin->ProductosconStockMenor();
            $productosv["mas_vendidos"]= $this->admin->ProductosMasVendidos();
            $productosc["clientes_rc"] = $this->admin->clientesRecurrentes();
            $data3 = isset($producto["cantidad_productos"]) ? $producto["cantidad_productos"] : "0";
            $data1 = isset($Total["suma_totales"]) ? $Total["suma_totales"] : "0";
            $data2 = isset($Fecha["monto_total_ventas"]) ? $Fecha["monto_total_ventas"] : "0";
            $data["contenido"] = "../views/admin/administrador.php";
            require_once TEMPLATE;

        }
        public function grafico($anioactual) {
            // Incluimos el archivo de conexión a la base de datos
            require "../config/conexion.php";
    
            // Genera un rango de fechas que cubre todos los meses del año
            $fechasTodosLosMeses = array_map(function($mes) use ($anioactual) {
                return $anioactual . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT);
            }, range(1, 12));
    
            // Consulta SQL para obtener las ventas por mes
            $query = "SELECT DATE_FORMAT(Fecha, '%Y-%m') AS mes_anio, 
                            SUM(Total) AS total_ventas FROM tb_pedido 
                            WHERE YEAR(Fecha) = $anioactual GROUP BY mes_anio ORDER BY `mes_anio` ASC";
            $result = $mysqli->query($query);
    
            // Arreglo para almacenar los datos a enviar como respuesta JSON
            $data = array('labels' => array(), 'ventas' => array());
    
            // Inicializa un arreglo asociativo para almacenar las ventas de cada mes
            $ventasPorMes = array_fill_keys($fechasTodosLosMeses, 0);
    
            // Después de ejecutar la consulta SQL
            if (!$result) {
                die('Error en la consulta SQL: ' . $mysqli->error);
            }
    
            // Después de recuperar resultados
            if ($result->num_rows === 0) {
                die('No se encontraron resultados.');
            }
    
            // Recorremos los resultados de la consulta
            while ($row = $result->fetch_assoc()) {
                $mesAnio = $row['mes_anio'];
                $ventasPorMes[$mesAnio] = $row['total_ventas'];
            }
    
            // Crea etiquetas y datos para los meses
            foreach ($fechasTodosLosMeses as $mesAnio) {
                list($anio, $mes) = explode('-', $mesAnio);
    
                // Agrega etiquetas en formato "Mes Año" (por ejemplo, "Enero 2023")
                $data['labels'][] = $mesesEnEspanol[(int)$mes - 1];
                // Agrega datos de ventas para cada mes
                $data['ventas'][] = $ventasPorMes[$mesAnio];
            }
    
            // Liberamos los resultados y cerramos la conexión a la base de datos
            $result->free();
   
            // Establece la cabecera para indicar que la respuesta es de tipo JSON
            header('Content-Type: application/json');
            // Convierte el arreglo a formato JSON y lo imprime
            // En caso de error, devuelve un mensaje de error
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Hubo un error en el servidor.'));
            exit();

        }
        public function cerrarSession(){
            session_destroy();
            header('Location: ../index.php');
        }
    }   
    
?>