<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Iniciar o reanudar la sesión
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

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuario (Nombre, Apellido, documento,Telefono, email, password) VALUES (:nombre, :apellido, :documento, :telefono, :email, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':telefono', $telefono);
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
    if (!$input || !isset($input['documento']) || !isset($input['password']) || !isset($input['tipoUsuario'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $documento = htmlspecialchars($input['documento']);  
    $password = htmlspecialchars($input['password']);
    $tipoUsuario = htmlspecialchars($input['tipoUsuario']);
 
    try {
        // traiga el usuario y el rol del usuario
        
        $stmt = $pdo->prepare("SELECT u.*, r.nombreRol FROM usuario u INNER JOIN usuario_rol ur ON u.ID_Usuario = ur.id_usuario 
        INNER JOIN rol r ON ur.id_rol = r.idRol WHERE u.documento = :documento AND r.idRol = :tipoUsuario");
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':tipoUsuario', $tipoUsuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $storedPassword = $user['password']; // Contraseña almacenada en la base de datos
        
            if (password_verify($password, $storedPassword)) {
                // Configurar sesión
                $_SESSION['user_id'] = $user['ID_Usuario'];
                $_SESSION['documento'] = $user['documento'];
                $_SESSION['tipoUsuario'] = $user['nombreRol'];
                echo json_encode([
                    'success' => true,
                    'message' => 'Inicio de sesión exitoso',
                    'user_id' => $user['ID_Usuario']
                ]);} else {
                echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al iniciar sesión: ' . $e->getMessage()]);
    }
} elseif ($action == "getPerfil") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    $userId = $_SESSION['user_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE ID_Usuario = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode([
                'success' => true,
                'documento' => $user['documento'],
                'Nombre' => $user['Nombre'],
                'Apellido' => $user['Apellido'],
                'Telefono' => $user['Telefono'],
                'email' => $user['Email']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos del perfil: ' . $e->getMessage()]);
    }
}elseif ($action == "modificar"){
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }

    
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !isset($input['nombre']) || !isset($input['apellido']) || !isset($input['telefono']) || !isset($input['email'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $nombre = htmlspecialchars($input['nombre']);
    $apellido = htmlspecialchars($input['apellido']);
    $telefono = htmlspecialchars($input['telefono']);
    $email = htmlspecialchars($input['email']);

    try {
        $stmt = $pdo->prepare("UPDATE usuario SET Nombre = :nombre, Apellido = :apellido, Telefono = :telefono, email = :email WHERE ID_Usuario = :id");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        // Enviar respuesta JSON de éxito
        echo json_encode(['success' => true, 'message' => 'Usuario modificado exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al modificar el usuario: ' . $e->getMessage()]);
    }
}
else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
?>
