<?php
include '../config/conexion.php';
$input = json_decode(file_get_contents("php://input"), true);
$action = $_POST['action'] ?? $input['action'];
global $pdo;

if ($action == "cargarProductos") {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor FROM producto p INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productos);
    } catch (PDOException $e) {
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

    // // Verificar el tamaño del archivo
    // if ($_FILES["imagen"]["size"] > 500000) {
    //     echo json_encode(['success' => false, 'message' => 'Lo siento, tu archivo es demasiado grande.']);
    //     $uploadOk = 0;
    // }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo json_encode(['success' => false, 'message' => 'Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.']);
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado a 0 por un error
    if ($uploadOk == 0) {
        echo json_encode(['success' => false, 'message' => 'Lo siento, tu archivo no fue subido.']);
    // Si todo está bien, intentar subir el archivo
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO producto (imagen, Nombre, Descripcion, Precio, Stock, ID_Categoria, ID_Proveedor) VALUES (:imagen, :nombre, :descripcion, :precio, :stock, :idCategoria, :idProveedor)");
                $stmt->bindParam(':imagen', $target_file);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':idCategoria', $idCategoria);
                $stmt->bindParam(':idProveedor', $idProveedor);
                $stmt->execute();
                echo json_encode(['success' => true, 'message' => 'Producto agregado correctamente']);
            } catch (PDOException $e) {
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
        $stmt = $pdo->prepare("UPDATE producto SET Nombre = :nombre, Descripcion = :descripcion, Precio = :precio, Stock = :stock WHERE ID_Producto = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Producto editado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al editar el producto: ' . $e->getMessage()]);
    }
} elseif ($action == "obtenerProducto") {
    $idProducto = $input['idProducto'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE ID_Producto = :idProducto");
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($producto);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener el producto: ' . $e->getMessage()]);
    }
} elseif ($action == "eliminarProducto") {
    $id = $input['idProducto'];

    try {
        $stmt = $pdo->prepare("DELETE FROM producto WHERE ID_Producto = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()]);
    }
}
?>