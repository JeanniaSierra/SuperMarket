<?php
include '../config/conexion.php';
include '../modelo/proveedor.php';

$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'] ?? null;

$proveedor = new Proveedor($pdo);

if ($action == "cargarProveedores") {
    $result = $proveedor->cargarProveedores();
    echo json_encode($result);
} elseif ($action == "crearProveedor") {
    $nombre = $input['nombre'];
    $telefono = $input['telefono'];
    $direccion = $input['direccion'];
    $result = $proveedor->crearProveedor($nombre, $telefono, $direccion);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?> 