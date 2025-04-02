<?php
include '../config/conexion.php';

class Producto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cargarProductos() {
        try {
            $stmt = $this->pdo->prepare("SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor 
                                       FROM producto p 
                                       INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria 
                                       INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener los productos: ' . $e->getMessage()];
        }
    }

    public function crearProducto($imagen, $nombre, $descripcion, $precio, $stock, $idCategoria, $idProveedor) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO producto (imagen, Nombre, Descripcion, Precio, Stock, ID_Categoria, ID_Proveedor) 
                                       VALUES (:imagen, :nombre, :descripcion, :precio, :stock, :idCategoria, :idProveedor)");
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':idCategoria', $idCategoria);
            $stmt->bindParam(':idProveedor', $idProveedor);
            $stmt->execute();
            return ['success' => true, 'message' => 'Producto agregado correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al agregar el producto: ' . $e->getMessage()];
        }
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio, $stock) {
        try {
            $stmt = $this->pdo->prepare("UPDATE producto SET Nombre = :nombre, Descripcion = :descripcion, 
                                       Precio = :precio, Stock = :stock WHERE ID_Producto = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->execute();
            return ['success' => true, 'message' => 'Producto editado correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al editar el producto: ' . $e->getMessage()];
        }
    }

    public function obtenerProducto($idProducto) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM producto WHERE ID_Producto = :idProducto");
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener el producto: ' . $e->getMessage()];
        }
    }

    public function eliminarProducto($idProducto) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM producto WHERE ID_Producto = :id");
            $stmt->bindParam(':id', $idProducto);
            $stmt->execute();
            return ['success' => true, 'message' => 'Producto eliminado correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()];
        }
    }
}
?> 