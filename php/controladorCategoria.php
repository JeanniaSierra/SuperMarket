<?php
include 'conexion.php';
include 'Categoria.php';

$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'] ?? null;

$categoria = new Categoria($pdo);

if ($action == "cargarCategorias") {
    $result = $categoria->cargarCategorias();
    echo json_encode($result);
} elseif ($action == "crearCategoria") {
    $nombre = $input['nombreCategoria'];
    $result = $categoria->crearCategoria($nombre);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>