<?php
include '../config/conexion.php';
include '../modelo/usuario.php';

session_start();

$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'] ?? null;

$usuario = new Usuario($pdo);

if ($action == "register") {
    if (!$input || !isset($input['documento']) || !isset($input['email']) || !isset($input['password'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $documento = htmlspecialchars($input['documento']);
    $nombre = htmlspecialchars($input['nombre']);
    $apellido = htmlspecialchars($input['apellido']);
    $telefono = htmlspecialchars($input['telefono']);
    $email = htmlspecialchars($input['email']);      
    $password = htmlspecialchars($input['password']);

    $result = $usuario->registrarUsuario($documento, $nombre, $apellido, $telefono, $email, $password);
    echo json_encode($result);
} elseif ($action == "login") {
    if (!$input || !isset($input['documento']) || !isset($input['password']) || !isset($input['tipoUsuario'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $documento = htmlspecialchars($input['documento']);  
    $password = htmlspecialchars($input['password']);
    $tipoUsuario = htmlspecialchars($input['tipoUsuario']);

    $result = $usuario->login($documento, $password, $tipoUsuario);
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['documento'] = $result['documento'];
        $_SESSION['tipoUsuario'] = $result['tipoUsuario'];
    }
    echo json_encode($result);
} elseif ($action == "getPerfil") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    $userId = $_SESSION['user_id'];
    $result = $usuario->getPerfil($userId);
    echo json_encode($result);
} elseif ($action == "modificar") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }

    if (!$input || !isset($input['nombre']) || !isset($input['apellido']) || !isset($input['telefono']) || !isset($input['email'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $nombre = htmlspecialchars($input['nombre']);
    $apellido = htmlspecialchars($input['apellido']);
    $telefono = htmlspecialchars($input['telefono']);
    $email = htmlspecialchars($input['email']);

    $result = $usuario->actualizarPerfil($userId, $nombre, $apellido, $telefono, $email);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?> 