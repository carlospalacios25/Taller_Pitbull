<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\controllers\buysController;

header('Content-Type: application/json');  // Asegurarse de que el tipo de contenido sea JSON

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    try {
        $controlador = new buysController();
        $precio = $controlador->obtenerPrecioProducto($id_producto);

        // Verificar si se obtuvo el precio
        if ($precio) {
            echo json_encode(['precio_unitario' => $precio]);
        } else {
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
}

