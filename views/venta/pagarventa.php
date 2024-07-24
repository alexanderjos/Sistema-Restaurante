<?php
// Inicia la sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['idPedido'];

    // Verifica si 'idPedido' está definido en los datos POST
    if (isset($idPedido)) {
        // Guarda el ID en la sesión
        $_SESSION['idPedido'] = $idPedido;

    } else {
        $response = array(
            'status' => 'error',
            'message' => 'idPedido no está definido en los datos POST'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Método no permitido'
    );
    echo json_encode($response);
}

// Cierra la sesión
session_write_close();
?>
