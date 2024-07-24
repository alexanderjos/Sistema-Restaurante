<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input');
    $datosVenta = json_decode($inputJSON, true);
    $response = procesarVenta($datosVenta);
    $_SESSION['ajaxResponse'] = $response;
    echo json_encode($response);
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Método no permitido'
    );
    echo json_encode($response);
}


function procesarVenta($datosVenta) {
    

    $respuesta = array(
        'status' => 'success',
        'message' => 'Venta procesada correctamente',
        'cliente' => $datosVenta['cliente'],
        'producto' => $datosVenta['productos'],
        'venta' => $datosVenta['venta'], 
        'mozo' => $datosVenta['mozo'],  
    );

    return $respuesta;
}
?>
