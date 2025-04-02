<?php
include '../config/conexion.php';

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrarUsuario($documento, $nombre, $apellido, $telefono, $email, $password) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("INSERT INTO usuario (Nombre, Apellido, documento, Telefono, email, password) 
                                       VALUES (:nombre, :apellido, :documento, :telefono, :email, :password)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->execute();
            return ['success' => true, 'message' => 'Usuario registrado correctamente'];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ['success' => false, 'message' => 'El usuario o correo ya está registrado'];
            }
            return ['success' => false, 'message' => 'Error al registrar el usuario: ' . $e->getMessage()];
        }
    }

    public function login($documento, $password, $tipoUsuario) {
        try {
            $stmt = $this->pdo->prepare("SELECT u.*, r.nombreRol 
                                       FROM usuario u 
                                       INNER JOIN usuario_rol ur ON u.ID_Usuario = ur.id_usuario 
                                       INNER JOIN rol r ON ur.id_rol = r.idRol 
                                       WHERE u.documento = :documento AND r.idRol = :tipoUsuario");
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':tipoUsuario', $tipoUsuario);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return [
                    'success' => true,
                    'message' => 'Inicio de sesión exitoso',
                    'user_id' => $user['ID_Usuario'],
                    'documento' => $user['documento'],
                    'tipoUsuario' => $user['nombreRol']
                ];
            }
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al iniciar sesión: ' . $e->getMessage()];
        }
    }

    public function getPerfil($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE ID_Usuario = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return [
                    'success' => true,
                    'documento' => $user['documento'],
                    'Nombre' => $user['Nombre'],
                    'Apellido' => $user['Apellido'],
                    'Telefono' => $user['Telefono'],
                    'email' => $user['Email']
                ];
            }
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener los datos del perfil: ' . $e->getMessage()];
        }
    }

    public function actualizarPerfil($userId, $nombre, $apellido, $telefono, $email) {
        try {
            $stmt = $this->pdo->prepare("UPDATE usuario 
                                       SET Nombre = :nombre, Apellido = :apellido, 
                                           Telefono = :telefono, email = :email 
                                       WHERE ID_Usuario = :id");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            return ['success' => true, 'message' => 'Perfil actualizado correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al actualizar el perfil: ' . $e->getMessage()];
        }
    }
}
?> 