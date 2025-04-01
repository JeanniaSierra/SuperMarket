<?php
require_once 'models/Proveedor.php';

class ProveedorController {
    private $model;

    public function __construct() {
        $this->model = new Proveedor();
    }

    public function index() {
        // Obtener todos los proveedores
        $proveedores = $this->model->getAll();
        
        // Cargar la vista
        $content = 'proveedores/index';
        require_once 'views/layouts/main.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $email = $_POST['email'] ?? '';
            
            if (empty($nombre)) {
                $error = "El nombre del proveedor es obligatorio";
            } else {
                // Configurar el modelo
                $this->model->setNombre($nombre);
                $this->model->setDireccion($direccion);
                $this->model->setTelefono($telefono);
                $this->model->setEmail($email);
                
                // Guardar el proveedor
                if ($this->model->save()) {
                    header("Location: " . BASE_URL . "?controller=proveedor&action=index");
                    exit;
                } else {
                    $error = "Hubo un error al guardar el proveedor.";
                }
            }
        }
        
        // Cargar la vista
        $content = 'proveedores/create';
        require_once 'views/layouts/main.php';
    }

    public function edit() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        $proveedor = $this->model->getOne();
        
        if (!$proveedor) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $email = $_POST['email'] ?? '';
            
            if (empty($nombre)) {
                $error = "El nombre del proveedor es obligatorio";
            } else {
                // Configurar el modelo
                $this->model->setNombre($nombre);
                $this->model->setDireccion($direccion);
                $this->model->setTelefono($telefono);
                $this->model->setEmail($email);
                
                // Actualizar el proveedor
                if ($this->model->update()) {
                    header("Location: " . BASE_URL . "?controller=proveedor&action=index");
                    exit;
                } else {
                    $error = "Hubo un error al actualizar el proveedor.";
                }
            }
        }
        
        // Cargar la vista
        $content = 'proveedores/edit';
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        
        if ($this->model->delete()) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
        } else {
            // Podría haber productos asociados a este proveedor
            echo "No se puede eliminar el proveedor porque tiene productos asociados.";
        }
    }
    
    public function view() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        $proveedor = $this->model->getOne();
        
        if (!$proveedor) {
            header("Location: " . BASE_URL . "?controller=proveedor&action=index");
            exit;
        }
        
        // Cargar la vista
        $content = 'proveedores/view';
        require_once 'views/layouts/main.php';
    }
}
?> 