<?php
require_once 'models/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new Usuario();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $documento = $_POST['documento'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol = $_POST['tipoUsuario'] ?? '';

            if (empty($documento) || empty($password) || empty($rol)) {
                $error = "Todos los campos son obligatorios";
                require_once 'views/usuario/login.php';
                return;
            }

            $this->model->setDocumento($documento);
            $this->model->setPassword($password);
            $this->model->setRol($rol);

            $usuario = $this->model->login();
            if ($usuario) {
                $_SESSION['usuario'] = $usuario;
                header("Location: " . BASE_URL . "?controller=producto&action=index");
            } else {
                $error = "Credenciales incorrectas";
                require_once 'views/usuario/login.php';
            }
        } else {
            require_once 'views/usuario/login.php';
        }
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $documento = $_POST['documento'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->model->setDocumento($documento);
            $this->model->setNombre($nombre);
            $this->model->setApellido($apellido);
            $this->model->setTelefono($telefono);
            $this->model->setEmail($email);
            $this->model->setPassword($password);
            $this->model->setRol('comprador'); // Por defecto es comprador

            if ($this->model->save()) {
                $success = "Usuario registrado correctamente";
            } else {
                $error = "Error al registrar el usuario";
            }
        }
        require_once 'views/usuario/login.php';
    }

    public function logout() {
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
        }
        header("Location: " . BASE_URL);
    }
}
?> 