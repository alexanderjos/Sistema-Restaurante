<?php
require "../config/conexion.php";

// Recibe el DNI desde la solicitud Ajax
$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

// Use prepared statements to prevent SQL injection
$stmt = $mysqli->prepare("SELECT * FROM tb_cliente WHERE id_Cliente = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors in the SQL query
if (!$result) {
    echo json_encode(['error' => 'Error in SQL query: ' . $mysqli->error]);
} else {
    // Fetch the single row as an associative array
    $cliente = $result->fetch_assoc();

    // Output the result as JSON
    echo json_encode($cliente);
}
?>
