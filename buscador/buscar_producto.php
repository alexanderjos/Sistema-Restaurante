<?php 
    
    require "../config/conexion.php"; // Asegúrate de que esta ruta sea correcta

    // Recibe el término de búsqueda desde la solicitud Ajax
    $termino_busqueda = $_GET['termino_busqueda'];
    
    // Consulta SQL para buscar productos por código de barras o nombre
    $sql = "SELECT p.*, tp.*,m.*
            FROM tb_producto p 
            INNER JOIN tb_tipo_producto tp ON p.idTipoProducto = tp.idTipo_Producto 
            INNER JOIN tb_marca_producto m ON p.idMarca = m.idMarca
            WHERE p.idProducto LIKE '%$termino_busqueda%' OR p.nombreProducto LIKE '%$termino_busqueda%'";
    $result = $mysqli->query($sql);
    
    // Convierte los resultados a un array asociativo y luego a formato JSON
    $productos = array();
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    
    echo json_encode($productos);
    

?>