<?php
require "../config/conexion.php";
$anioActual = Date("Y"); 
// Genera un rango de fechas que cubre todos los meses del año
$fechasTodosLosMeses = array_map(function($mes) use ($anioActual) {
    return $anioActual . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT);
}, range(1, 12));


$query = "SELECT DATE_FORMAT(Fecha, '%Y-%m') AS mes_anio, SUM(Total) AS total_ventas FROM tb_pedido WHERE YEAR(Fecha) = '$anioActual' GROUP BY mes_anio ORDER BY `mes_anio` ASC";
$result = $mysqli->query($query);

$data = array('labels' => array(), 'ventas' => array());

// Inicializa un arreglo con los nombres de los 12 meses en español
$mesesEnEspanol = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

// Inicializa un arreglo asociativo para almacenar las ventas de cada mes
$ventasPorMes = array_fill_keys($fechasTodosLosMeses, 0);

while ($row = $result->fetch_assoc()) {
    $mesAnio = $row['mes_anio'];
    $ventasPorMes[$mesAnio] = $row['total_ventas'];
}

foreach ($fechasTodosLosMeses as $mesAnio) {
    list($anio, $mes) = explode('-', $mesAnio);

    $data['labels'][] = $mesesEnEspanol[(int)$mes - 1] ;
    $data['ventas'][] = $ventasPorMes[$mesAnio];
}

$result->free();
$mysqli->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
