<?php
session_start();
require_once "../models/ticketModel.php";
require "./code128.php";

// Crear una instancia del modelo de ventas
$ventaModel = new VentaModel();
date_default_timezone_set('America/Lima');

// Obtener el ID de la venta que deseas mostrar en el ticket (ajusta según tu lógica)
$idVenta = $_GET['idVenta']; // Por ejemplo, obtener el ID desde parámetros GET

// Obtener detalles de la venta
$venta = $ventaModel->obtenerVenta($idVenta);

// Obtener detalles de los productos de la venta
$detallesVenta = $ventaModel->obtenerdtVenta($idVenta);

// Crear el PDF
$alturaDetallesTabla = count($detallesVenta) * 10; // Altura estimada de cada fila de la tabla
$tamanioTicket = 190 + $alturaDetallesTabla; // Tamaño original del ticket + altura adicional

$pdf = new PDF_Code128('P', 'mm', array(90, $tamanioTicket));
$pdf->SetMargins(4, 10, 4);
$pdf->AddPage();


// Encabezado y datos de la empresa
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("PRAIA")), 0, 'C', false);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "RUC: 1178941682"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Manuel Seoane 916, Pimentel 5to Piso del Hotel Puerto del Sol"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Teléfono: 939921269"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Email: marketing@praia.net"), 0, 'C', false);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Fecha: " . date("d/m/Y") . " " . date("h:i:s A")), 0, 'C', false);

$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Mozo: ".$venta["nombreEmpleado"]." ".$venta["apellidoEmpleado"]), 0, 'C', false);
$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("Ticket Nro: " .$venta["idPedido"])), 0, 'C', false);
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(3);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "---------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Cliente: ".$venta["nombreCliente"]." ".$venta["apellidoCliente"]), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Documento: ".$venta["idCliente"]), 0, 'C', false);


$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Tabla de productos
$pdf->Cell(10, 5, iconv("UTF-8", "ISO-8859-1", "Código."), 0, 0, 'C');
$pdf->Cell(23, 5, iconv("UTF-8", "ISO-8859-1", "Cantidad"), 0, 0, 'C');
$pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", "Precio."), 0, 0, 'C');
$pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1", "Total"), 0, 0, 'C');

$pdf->Ln(3);
$pdf->Cell(82, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Detalles de la tabla
foreach ($detallesVenta as $producto) {
    $pdf->Ln(4);
    $pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", $producto['nombreProducto']), 0, 'C', false);
    $pdf->Cell(10, 4, iconv("UTF-8", "ISO-8859-1", $producto['idProducto']), 0, 0, 'C');
    $pdf->Cell(19, 4, iconv("UTF-8", "ISO-8859-1", $producto['cantidad']), 0, 0, 'C');
    $pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1", "S/.". $producto['precioUnitario'] ." PEN"), 0, 0, 'C');
    $pdf->Cell(29, 4, iconv("UTF-8", "ISO-8859-1", "S/.". $producto['subtotal'] ." PEN"), 0, 0, 'C');
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

$pdf->Cell(82, 5, iconv("UTF-8", "ISO-8859-1", "--------------------------------------------------------------------------"), 0, 0, 'C');

$pdf->Ln();

$pdf->Cell(18, 5, iconv("UTF-8", "ISO-8859-1", ""), 0, 0, 'C');
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-1", "Total a Pagar:"), 0, 0, 'C');
$pdf->Cell(12, 5, iconv("UTF-8", "ISO-8859-1", "S/.". $venta["Total"]." PEN"), 0, 0, 'C');



$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 7, iconv("UTF-8", "ISO-8859-1", "Gracias por su compra"), '', 0, 'C');

$pdf->Ln(9);

# Codigo de barras #
$barcodeContent = $venta['Correlativo'];
$pdf->Code128(10, $pdf->GetY(), $barcodeContent, 70, 20);
$pdf->SetXY(0, $pdf->GetY() + 21);
$pdf->SetFont('Arial', '', 14);


# Nombre del archivo PDF #
$pdf->Output("D", "Ticket_Nro_$idVenta.pdf", true);

// Redirigir antes de generar el PDF

?>
