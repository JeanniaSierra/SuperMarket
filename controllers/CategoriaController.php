<?php
require_once 'models/Categoria.php';

class CategoriaController {
    private $model;

    public function __construct() {
        $this->model = new Categoria();
    }

    public function index() {
        // Obtener todas las categorías
        $categorias = $this->model->getAll();
        
        // Cargar la vista
        $content = 'categorias/index';
        require_once 'views/layouts/main.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            
            if (empty($nombre)) {
                $error = "El nombre de la categoría es obligatorio";
            } else {
                // Configurar el modelo
                $this->model->setNombre($nombre);
                
                // Guardar la categoría
                if ($this->model->save()) {
                    header("Location: " . BASE_URL . "?controller=categoria&action=index");
                    exit;
                } else {
                    $error = "Hubo un error al guardar la categoría.";
                }
            }
        }
        
        // Cargar la vista
        $content = 'categorias/create';
        require_once 'views/layouts/main.php';
    }

    public function edit() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=categoria&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        $categoria = $this->model->getOne();
        
        if (!$categoria) {
            header("Location: " . BASE_URL . "?controller=categoria&action=index");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            
            if (empty($nombre)) {
                $error = "El nombre de la categoría es obligatorio";
            } else {
                // Configurar el modelo
                $this->model->setNombre($nombre);
                
                // Actualizar la categoría
                if ($this->model->update()) {
                    header("Location: " . BASE_URL . "?controller=categoria&action=index");
                    exit;
                } else {
                    $error = "Hubo un error al actualizar la categoría.";
                }
            }
        }
        
        // Cargar la vista
        $content = 'categorias/edit';
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=categoria&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        
        if ($this->model->delete()) {
            header("Location: " . BASE_URL . "?controller=categoria&action=index");
        } else {
            // Podría haber productos asociados a esta categoría
            echo "No se puede eliminar la categoría porque tiene productos asociados.";
        }
    }
}
?> 