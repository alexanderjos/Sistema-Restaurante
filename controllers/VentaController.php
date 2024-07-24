<?php
class VentaController
{
    protected $venta;
    protected $validaciones;
    protected $errores;

    public function __construct()
    {

        require_once "../models/VentaModel.php";
        require_once "../controllers/ValController.php";
        $this->venta = new VentaModel();
        $this->validaciones = new ValController();
        $this->errores = array();
    }

    public function indexMC()
    {
        $data = array(); // Inicializa $data como un array
        $this->ventaID($data); // Pasa $data como argumento para que se pueda modificar

        $data["titulo"] = "GESTIÓN DE VENTAS";
        $data["contenido"] = "../views/venta/ventas.php";
        require_once TEMPLATEMZ;
    }

    private function ventaID(&$data)
    {
        require "../config/conexion.php";

        $query = "SELECT MAX(idPedido) AS maximoID FROM tb_pedido";
        $resultado = $mysqli->query($query);

        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            $maximoID = isset($fila['maximoID']) ? $fila['maximoID'] : 1;
            $data["idVenta"] = $maximoID+1;
            $data["correlativo"] = "VNT-" . ($data["idVenta"]);

        } else {
            $data["idVenta"] = 1; // Valor predeterminado si hay un problema con la consulta
            $data["correlativo"] = "VNT-" . ($data["idVenta"]);
        }
    }
    public function verVentas()
    {
        $data = array(); // Inicializa $data como un array
        $idEmpleado = $_SESSION["DNI"];
        $data["titulo"] = "GESTIÓN DE VENTAS";
        $data["resultado"] = $this->venta->obtenerDetallesVentasMozo($idEmpleado);
        $data["contenido"] = "../views/venta/ventas_mozo.php";
        require_once TEMPLATEMZ;
    }
    public function verVentasAdmin()
    {
        $data = array(); // Inicializa $data como un array
        $data["titulo"] = "GESTIÓN DE VENTAS";
        $data["fechaInicio"]=date('Y-m-d');
        $data["fechaFin"]=date('Y-m-d');
        $data["resultado"] = $this->venta->obtenerDetallesDeTodasLasVentas();
        $data["contenido"] = "../views/venta/ventas_totales.php";
        require_once TEMPLATE;
    }
    public function verVentasDiaActual($dia)
    {
        $data = array(); // Inicializa $data como un array
        $data["titulo"] = "GESTIÓN DE VENTAS";
        $data["fechaInicio"]=date('Y-m-d');
        $data["fechaFin"]=date('Y-m-d');
        $data["resultado"] = $this->venta->obtenerDetallesDeTodasLasVentasActual($dia);
        $data["contenido"] = "../views/venta/ventas_totales.php";
        require_once TEMPLATE;
    }
    public function verVentaFecha()
    {
        $data = array(); // Inicializa $data como un array
        $data["titulo"] = "GESTIÓN DE VENTAS";
        $fehcaInicio = $_POST["fechaInicio"];
        $fechaFin =$_POST["fechaFinal"];
        $data["fechaInicio"]=$fehcaInicio;
        $data["fechaFin"]=$fechaFin;
        $data["resultado"] = $this->venta->obtenerVentaFechas($fehcaInicio, $fechaFin);
        $data["contenido"] = "../views/venta/ventas_totales.php";
        require_once TEMPLATE;
    }
    public function nuevaVenta(){

        $ajaxResponse = $_SESSION['ajaxResponse'];
        $producto = $ajaxResponse['producto'];
        $ventas = $ajaxResponse['venta'];
        $cliente = $ajaxResponse['cliente'];
        $mozo = $ajaxResponse['mozo'];
        $this->venta->insertarCliente($cliente);
        $this->venta->insertarVenta($cliente,$mozo,$ventas);
        $this->venta->insertarDetalleVenta($ventas,$producto);
        $_SESSION['mensaje'] = "Venta Registrada Correctamente";
        header("Location: ../views/mozo.php?c=VentaController&a=verVentas" );
    }
    public function enviarVenta($id) {
        $this->venta->actualizarVenta($id);
        $_SESSION['mensaje'] = "Venta enviada a Caja";
        // Redirigir al usuario usando JavaScript después de la generación del PDF
        echo '<script>';
        echo 'window.location.href="../fpdf/ticket.php?idVenta=' . $id . '";';
        echo 'setTimeout(function() { window.location.href="../views/mozo.php?c=VentaController&a=verVentas"; }, 500);'; // Espera 500 milisegundos antes de redirigir
        echo '</script>';
        exit();
    }
    public function realizarPago($id) {
        $ajaxResponse = $_SESSION['ajaxResponse1'];
        $pago = $ajaxResponse['pago'];
        $this->venta->VentaPagada($id,$pago);
        $_SESSION['mensaje'] = "Venta Pagada";
        //Creación de carpetas
        $this->crearCarpetas();
        //Redirigir al usuario usando JavaScript después de la generación del PDF
        echo '<script>';
        echo 'window.location.href="../fpdf/comprobante.php?idVenta=' . $id . '";';
        echo 'setTimeout(function() { window.location.href="../views/cajero.php?c=VentaController&a=verVentasCajero"; }, 500);'; // Espera 500 milisegundos antes de redirigir
        echo '</script>';
        exit();
    }
    
    public function verVentasCajero(){
        $data = array(); // Inicializa $data como un array
        $id = $_SESSION["DNI"];
        $data["titulo"] = "GESTIÓN DE VENTAS";
        $data["resultado"] = $this->venta->obtenerVentaCaja($id);
        $data["contenido"] = "../views/venta/ventas_caja.php";
        require_once TEMPLATECJ;
    }
    public function pagarVenta(){
        $idPedido = $_SESSION["idPedido"];
        $data["titulo"] = "GESTIÓN DE PAGO";
        $data["resultado"] = $this->venta->obtenerVenta($idPedido);
        $data["detalle"] = $this->venta->obtenerdtVenta($idPedido);
        
        $data["contenido"] = "../views/venta/pagar.php";
        require_once TEMPLATECJ;
    }
    public function crearCarpetas(){
        $anio = date("Y");
        $micarpeta = '../reportes/'.$anio ;
        if (!file_exists($micarpeta)) {
            mkdir($micarpeta, 0777, true);
        }
        //crear carpeta por mes
        $mes = date("M");
        $micarpeta1 = '../reportes/'.$anio.'/'.$mes ;
        if (!file_exists($micarpeta1)) {
            mkdir($micarpeta1, 0777, true);
        }
    }
    
}
?>
