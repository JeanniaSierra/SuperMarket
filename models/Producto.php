<?php
require_once 'config/database.php';

class Producto {
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $id_categoria;
    private $id_proveedor;
    private $imagen;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }
    public function getIdCategoria() { return $this->id_categoria; }
    public function getIdProveedor() { return $this->id_proveedor; }
    public function getImagen() { return $this->imagen; }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setPrecio($precio) { $this->precio = $precio; }
    public function setStock($stock) { $this->stock = $stock; }
    public function setIdCategoria($id_categoria) { $this->id_categoria = $id_categoria; }
    public function setIdProveedor($id_proveedor) { $this->id_proveedor = $id_proveedor; }
    public function setImagen($imagen) { $this->imagen = $imagen; }

    // Métodos CRUD
    public function getAll() {
        try {
            $sql = "SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor 
                    FROM producto p 
                    INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria 
                    INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getOne() {
        try {
            $sql = "SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor 
                    FROM producto p 
                    INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria 
                    INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor 
                    WHERE p.ID_Producto = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function save() {
        try {
            $sql = "INSERT INTO producto (Nombre, Descripcion, Precio, Stock, ID_Categoria, ID_Proveedor, Imagen) 
                    VALUES (:nombre, :descripcion, :precio, :stock, :id_categoria, :id_proveedor, :imagen)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':stock', $this->stock);
            $stmt->bindParam(':id_categoria', $this->id_categoria);
            $stmt->bindParam(':id_proveedor', $this->id_proveedor);
            $stmt->bindParam(':imagen', $this->imagen);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update() {
        try {
            $sql = "UPDATE producto SET 
                    Nombre = :nombre, 
                    Descripcion = :descripcion, 
                    Precio = :precio, 
                    Stock = :stock";
                    
            // Si se proporcionan categoría y proveedor, actualizarlos
            if (!empty($this->id_categoria)) {
                $sql .= ", ID_Categoria = :id_categoria";
            }
            
            if (!empty($this->id_proveedor)) {
                $sql .= ", ID_Proveedor = :id_proveedor";
            }
            
            // Si se proporciona una nueva imagen, actualizarla
            if (!empty($this->imagen)) {
                $sql .= ", Imagen = :imagen";
            }
            
            $sql .= " WHERE ID_Producto = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':stock', $this->stock);
            
            if (!empty($this->id_categoria)) {
                $stmt->bindParam(':id_categoria', $this->id_categoria);
            }
            
            if (!empty($this->id_proveedor)) {
                $stmt->bindParam(':id_proveedor', $this->id_proveedor);
            }
            
            if (!empty($this->imagen)) {
                $stmt->bindParam(':imagen', $this->imagen);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete() {
        try {
            $sql = "DELETE FROM producto WHERE ID_Producto = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    // Métodos adicionales
    public function getByCategory($id_categoria) {
        try {
            $sql = "SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor 
                    FROM producto p 
                    INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria 
                    INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor 
                    WHERE p.ID_Categoria = :id_categoria";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    public function getByProvider($id_proveedor) {
        try {
            $sql = "SELECT p.*, c.Nombre_Categoria as Categoria, pr.Nombre_Proveedor as Proveedor 
                    FROM producto p 
                    INNER JOIN categoria c ON p.ID_Categoria = c.ID_Categoria 
                    INNER JOIN proveedor pr ON p.ID_Proveedor = pr.ID_Proveedor 
                    WHERE p.ID_Proveedor = :id_proveedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_proveedor', $id_proveedor);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?> 