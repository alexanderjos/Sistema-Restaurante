<?php
session_start();
require_once "../models/ticketModel.php";

require('../fpdf/fpdf.php');
require('../phpqrcode/qrlib.php');

class PDFWithImage extends FPDF {
    function add_image($image_path, $x, $y, $w = 0, $h = 0) {
        $extension = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

        $image_type = ($extension == 'png') ? 'PNG' : 'JPEG';

        $this->Image($image_path, $x, $y, $w, $h, $image_type);
    }
    function add_qr_code($data, $x, $y, $w = 0, $h = 0, $tempImagePath = null) {
        // Configuración del código QR
        $ecc = 'L';
        ob_start();
        QRcode::png($data, null, $ecc, 3, 2);
        $qrCodeImage = ob_get_clean();

        if ($tempImagePath) {
            file_put_contents($tempImagePath, $qrCodeImage);
        } else {
            // Si no se proporciona una ruta temporal, crear un archivo temporal
            $tempImagePath = tempnam(sys_get_temp_dir(), 'qrcode');
            file_put_contents($tempImagePath, $qrCodeImage);
        }
        $extension = strtolower(pathinfo($tempImagePath, PATHINFO_EXTENSION));
        $image_type = ($extension == 'png') ? 'PNG' : 'JPEG';
        $this->Image($tempImagePath, $x, $y, $w, $h, $image_type);
    }
}
$pdf = new PDFWithImage();
$ventaModel = new VentaModel();
date_default_timezone_set('America/Lima');

$idVenta = $_GET['idVenta']; 

$venta = $ventaModel->obtenerVenta($idVenta);
$detallesVenta = $ventaModel->obtenerdtVenta($idVenta);

// Crear el PDF
$alturaDetallesTabla = count($detallesVenta) * 10; 
$tamanioTicket = 300 + $alturaDetallesTabla; 
$pdf = new PDFWithImage('P', 'mm', array(90, $tamanioTicket), 90, $tamanioTicket); 
$pdf->SetMargins(4, 10, 4);
$pdf->AddPage();


// Encabezado y datos de la empresa

$pdf->SetFont('Courier', '', 12);
$pdf->SetTextColor(0, 0, 0);
$imagePath = '../img/logo.png';
$pdf->add_image($imagePath, 36, 10, 20);
$pdf->Ln(20);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("PRAIA")), 0, 'C', false);

$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "RUC: 1178941682"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Manuel Seoane 916,Pimentel 5to  "), 0, 'C', false);
$pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", "Piso del Hotel Puerto del Sol"), 0, 'C', false);
$pdf->MultiCell(0, 9, iconv("UTF-8", "ISO-8859-1", "Teléfono: 939921269"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Email: marketing@praia.net"), 0, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Courier', '', 12);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("Boleta de Venta Electronica ")), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper($venta["idPedido"])), 0, 'C', false);

$pdf->SetFont('Arial', '', 9);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "---------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Courier', '', 10);

$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Fecha Emision : " .$venta["Fecha"]), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Hora  Emision : " .$venta["Hora"]), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Local         : 205 "), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Tipo de Moneda: SOL "), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Nro. de Serie : " . $venta["Correlativo"]), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Forma de Pago : " . $venta["metodoPago"]), 0, 'C', false);

// Reset font to default (or any other font you want to use for the rest of the document)
$pdf->SetFont('');
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "---------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Courier', '', 10);

$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Documento : " . $venta["idCliente"]), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Nombre    : " . $venta["nombreCliente"]), 0, 'C', false);
$pdf->Cell(8, 5, iconv("UTF-8", "ISO-8859-1", "Apellido  : " . $venta["apellidoCliente"]), 0, 'C', false);
// Reset font to default (or any other font you want to use for the rest of the document)
$pdf->SetFont('');

$pdf->SetFont('Arial', '', 9);
$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Tabla de productos
$pdf->Cell(14, 5, iconv("UTF-8", "ISO-8859-1", "Código."), 0, 0, 'C');
$pdf->Cell(16, 5, iconv("UTF-8", "ISO-8859-1", "Cantidad"), 0, 0, 'C');
$pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", "Precio."), 0, 0, 'C');
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", "Total"), 0, 0, 'C');

$pdf->Ln(3);
$pdf->Cell(82, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Detalles de la tabla
foreach ($detallesVenta as $producto) {
    $pdf->Ln(2);
    $pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", $producto['nombreProducto']), 0, 'C', false);
    $pdf->Cell(14, 4, iconv("UTF-8", "ISO-8859-1", $producto['idProducto']), 0, 0, 'C');
    $pdf->Cell(17, 4, iconv("UTF-8", "ISO-8859-1", $producto['cantidad']), 0, 0, 'C');
    $pdf->Cell(22, 4, iconv("UTF-8", "ISO-8859-1", "S/.". $producto['precioUnitario'] ." PEN"), 0, 0, 'C');
    $pdf->Cell(26, 4, iconv("UTF-8", "ISO-8859-1", "S/.". $producto['subtotal'] ." PEN"), 0, 0, 'C');
    $pdf->Ln(4);
}

$pdf->Ln(3);
$pdf->Cell(82, 5, iconv("UTF-8", "ISO-8859-1", "--------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

# Impuestos & totales #
$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(55, 5, iconv("UTF-8", "ISO-8859-1", "IGV:"), 0, 0, 'C');
$pdf->Cell(-10, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta["igv"]." PEN"), 0, 0, 'C');

$pdf->Ln(5);

$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-1", "OP. Gravada:"), 0, 0, 'C');
$pdf->Cell(12, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta["opGravda"]." PEN"), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-1", "Total a Pagar:"), 0, 0, 'C');
$pdf->Cell(12, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta["Total"]." PEN"), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(82, 5, iconv("UTF-8", "ISO-8859-1", "--------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-1","Pago con: "), 0, 0, 'C');
$pdf->Cell(12, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta['montoRecibido']." PEN"), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-1", "Vuelto:"), 0, 0, 'C');
$pdf->Cell(12, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta['vuelto']." PEN"), 0, 0, 'C');

$pdf->Ln(15);
$data = 'http://localhost/pafinal77/fpdf/comprobante.php?&idVenta='.$venta['idPedido'];

// Ruta temporal para el código QR
$tempQRImagePath = '../qrcode.png';

$alturaQR = count($detallesVenta) * 7;
$pdf->add_qr_code($data, 30, 190+$alturaQR, 30,30, $tempQRImagePath);


$pdf->Ln(28);
$pdf->SetFont('Courier', 'I', 9);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Guarda tu voucher. Es el sustento para validar tu compra"), 0, 'C', false);
$pdf->Ln(4);
$pdf->SetFont('Courier', 'I', 10);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Representación impresa de la"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Boleta de Venta Electronica"), 0, 'C', false);
$pdf->Ln(4);
$pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", "Consulte el documento ingresando a"), 0, 'C', false);
$pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", "https://restafac.pe"), 0, 'C', false);
$pdf->Ln(9);

$pdf->SetFont('Courier', 'BI', 12);
$pdf->Cell(0, 7, iconv("UTF-8", "ISO-8859-1", "Gracias por su compra"), '', 0, 'C');

$pdf->Ln(9);


# Nombre del archivo PDF #
$pdf->Output("D", "BoletaE_Nro_$idVenta.pdf", true);



// Guardar el PDF en el servidor con un nombre específico
$nombreArchivo = "BoletaE_Nro_{$idVenta}_{$venta['idCliente']}.pdf";
$anio =  date("Y");
$mes = date("M");
// Guardar el contenido en un archivo en el servidor
$rutaArchivo = "../reportes/$anio/$mes/$nombreArchivo";

// Guardar el contenido del PDF en un archivo en el servidor
$pdf->Output($rutaArchivo, 'F');

?>