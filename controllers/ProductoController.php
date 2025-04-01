<?php
require_once 'models/Producto.php';
require_once 'models/Categoria.php';
require_once 'models/Proveedor.php';

class ProductoController {
    private $model;
    private $categoriaModel;
    private $proveedorModel;

    public function __construct() {
        $this->model = new Producto();
        $this->categoriaModel = new Categoria();
        $this->proveedorModel = new Proveedor();
    }

    public function index() {
        // Obtener todos los productos
        $productos = $this->model->getAll();
        
        // Cargar la vista
        $content = 'productos/index';
        require_once 'views/layouts/main.php';
    }

    public function create() {
        // Obtener las categorías y proveedores para los selectores
        $categorias = $this->categoriaModel->getAll();
        $proveedores = $this->proveedorModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $id_categoria = $_POST['id_categoria'] ?? 0;
            $id_proveedor = $_POST['id_proveedor'] ?? 0;
            
            // Manejar la carga de la imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $target_dir = "public/uploads/";
                $file_name = time() . "_" . basename($_FILES["imagen"]["name"]);
                $target_file = $target_dir . $file_name;
                
                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                // Mover el archivo cargado al directorio destino
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $imagen = $file_name;
                } else {
                    $error = "Hubo un error al subir la imagen.";
                }
            }
            
            // Configurar el modelo
            $this->model->setNombre($nombre);
            $this->model->setDescripcion($descripcion);
            $this->model->setPrecio($precio);
            $this->model->setStock($stock);
            $this->model->setIdCategoria($id_categoria);
            $this->model->setIdProveedor($id_proveedor);
            $this->model->setImagen($imagen);
            
            // Guardar el producto
            if ($this->model->save()) {
                header("Location: " . BASE_URL . "?controller=producto&action=index");
                exit;
            } else {
                $error = "Hubo un error al guardar el producto.";
            }
        }
        
        // Cargar la vista
        $content = 'productos/create';
        require_once 'views/layouts/main.php';
    }

    public function edit() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        $producto = $this->model->getOne();
        
        if (!$producto) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        // Obtener las categorías y proveedores para los selectores
        $categorias = $this->categoriaModel->getAll();
        $proveedores = $this->proveedorModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $id_categoria = $_POST['id_categoria'] ?? $producto['ID_Categoria'];
            $id_proveedor = $_POST['id_proveedor'] ?? $producto['ID_Proveedor'];
            
            // Manejar la carga de la imagen
            $imagen = $producto['Imagen']; // Mantener la imagen actual por defecto
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $target_dir = "public/uploads/";
                $file_name = time() . "_" . basename($_FILES["imagen"]["name"]);
                $target_file = $target_dir . $file_name;
                
                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                // Mover el archivo cargado al directorio destino
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $imagen = $file_name;
                    
                    // Eliminar la imagen anterior si existe
                    if (!empty($producto['Imagen']) && file_exists($target_dir . $producto['Imagen'])) {
                        unlink($target_dir . $producto['Imagen']);
                    }
                } else {
                    $error = "Hubo un error al subir la imagen.";
                }
            }
            
            // Configurar el modelo
            $this->model->setNombre($nombre);
            $this->model->setDescripcion($descripcion);
            $this->model->setPrecio($precio);
            $this->model->setStock($stock);
            $this->model->setIdCategoria($id_categoria);
            $this->model->setIdProveedor($id_proveedor);
            $this->model->setImagen($imagen);
            
            // Actualizar el producto
            if ($this->model->update()) {
                header("Location: " . BASE_URL . "?controller=producto&action=index");
                exit;
            } else {
                $error = "Hubo un error al actualizar el producto.";
            }
        }
        
        // Cargar la vista
        $content = 'productos/edit';
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        
        // Obtener el producto para eliminar la imagen si es necesario
        $producto = $this->model->getOne();
        
        if ($producto && $this->model->delete()) {
            // Eliminar la imagen asociada si existe
            if (!empty($producto['Imagen'])) {
                $imagen_path = "public/uploads/" . $producto['Imagen'];
                if (file_exists($imagen_path)) {
                    unlink($imagen_path);
                }
            }
            
            header("Location: " . BASE_URL . "?controller=producto&action=index");
        } else {
            echo "Hubo un error al eliminar el producto.";
        }
    }
    
    public function view() {
        // Verificar si se proporcionó un ID
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        $id = $_GET['id'];
        $this->model->setId($id);
        $producto = $this->model->getOne();
        
        if (!$producto) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        // Cargar la vista
        $content = 'productos/view';
        require_once 'views/layouts/main.php';
    }
    
    public function byCategory() {
        // Verificar si se proporcionó un ID de categoría
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?controller=producto&action=index");
            exit;
        }
        
        $id_categoria = $_GET['id'];
        $productos = $this->model->getByCategory($id_categoria);
        
        // Obtener la información de la categoría
        $this->categoriaModel->setId($id_categoria);
        $categoria = $this->categoriaModel->getOne();
        
        // Cargar la vista
        $content = 'productos/category';
        require_once 'views/layouts/main.php';
    }
}
?> 