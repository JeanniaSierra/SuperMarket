<?php
// Incluir el archivo de conexión
include 'conexion.php';

session_start();

 // Obtener y decodificar la entrada JSON
$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !isset($input['action'])) {
    echo json_encode(['success' => false, 'message' => 'Action']);
    exit;
}
$action = $input['action'];
if ($action == "register") {
    // Obtener y decodificar la entrada JSON
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !isset($input['username']) || !isset($input['email']) || !isset($input['password'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $username = htmlspecialchars($input['username']);
    $email = htmlspecialchars($input['email']);      
    $password = htmlspecialchars($input['password']);

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuario (usuario, email, password) VALUES (:usuario, :email, :password)");
        $stmt->bindParam(':usuario', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->execute();

        // Enviar respuesta JSON de éxito
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'message' => 'El usuario o correo ya está registrado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario: ' . $e->getMessage()]);
        }
    }
} elseif ($action == "login") {
     // Obtener y decodificar la entrada JSON
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !isset($input['username']) || !isset($input['password'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $username = htmlspecialchars($input['username']);  
    $password = htmlspecialchars($input['password']);
 
    try {
        // Preparar la consulta de selección para comprobar el usuario
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $storedPassword = $user['password']; // Contraseña almacenada en la base de datos
            
            if (password_verify($password, $storedPassword)) {
                $_SESSION['user_id']= $user['IdUsuario'];
                echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al iniciar sesión: ' . $e->getMessage()]);
    }
} elseif($action=="getPerfil"){
    if(!isset($_SESSION['user_id'])){
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    $userId = $_SESSION['user_id'];
    try {
        // Obtener los datos del usuario desde la base de datos
        $stmt = $pdo->prepare("SELECT usuario, email FROM usuario WHERE IdUsuario = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode([
                'success' => true,
                'username' => $user['usuario'],
                'email' => $user['email']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos del perfil: ' . $e->getMessage()]);
    }
} 
else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>
