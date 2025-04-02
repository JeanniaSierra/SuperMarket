<?php
include '../config/conexion.php';
require_once '../modelo/producto.php';

$input = json_decode(file_get_contents("php://input"), true);
$action = $_POST['action'] ?? $input['action'];
global $pdo;

$productoModel = new Producto($pdo);

if ($action == "cargarProductos") {
    try {
        $productos = $productoModel->cargarProductos();
        echo json_encode($productos);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los productos: ' . $e->getMessage()]);
    }
} elseif ($action == "crearProducto") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $idCategoria = $_POST['idCategoria'];
    $idProveedor = $_POST['idProveedor'];

    // Manejar la carga de la imagen
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo json_encode(['success' => false, 'message' => 'Lo siento, el archivo ya existe.']);
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo json_encode(['success' => false, 'message' => 'Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.']);
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado a 0 por un error
    if ($uploadOk == 0) {
        echo json_encode(['success' => false, 'message' => 'Lo siento, tu archivo no fue subido.']);
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            try {
                $resultado = $productoModel->crearProducto(
                    $target_file,
                    $nombre,
                    $descripcion,
                    $precio,
                    $stock,
                    $idCategoria,
                    $idProveedor
                );
                echo json_encode($resultado);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el producto: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Lo siento, hubo un error al subir tu archivo.']);
        }
    }
} elseif ($action == "editarProducto") {
    $id = $input['id'];
    $nombre = $input['nombre'];
    $descripcion = $input['descripcion'];
    $precio = $input['precio'];
    $stock = $input['stock'];

    try {
        $resultado = $productoModel->actualizarProducto($id, $nombre, $descripcion, $precio, $stock);
        echo json_encode($resultado);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al editar el producto: ' . $e->getMessage()]);
    }
} elseif ($action == "obtenerProducto") {
    $idProducto = $input['idProducto'];

    try {
        $producto = $productoModel->obtenerProducto($idProducto);
        echo json_encode($producto);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener el producto: ' . $e->getMessage()]);
    }
} elseif ($action == "eliminarProducto") {
    $id = $input['idProducto'];

    try {
        $resultado = $productoModel->eliminarProducto($id);
        echo json_encode($resultado);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()]);
    }
}
?>