<?php
require_once 'config/database.php';

class Categoria {
    private $id;
    private $nombre;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    // Métodos CRUD
    public function getAll() {
        try {
            $sql = "SELECT * FROM categoria ORDER BY Nombre_Categoria ASC";
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
            $sql = "SELECT * FROM categoria WHERE ID_Categoria = :id";
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
            $sql = "INSERT INTO categoria (Nombre_Categoria) VALUES (:nombre)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update() {
        try {
            $sql = "UPDATE categoria SET Nombre_Categoria = :nombre WHERE ID_Categoria = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nombre', $this->nombre);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete() {
        try {
            // Primero verificamos que no haya productos asociados a esta categoría
            $sql = "SELECT COUNT(*) as total FROM producto WHERE ID_Categoria = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result['total'] > 0) {
                return false; // No se puede eliminar si hay productos asociados
            }
            
            // Si no hay productos, procedemos a eliminar la categoría
            $sql = "DELETE FROM categoria WHERE ID_Categoria = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?> 