<?php
require_once 'config/database.php';

class Proveedor {
    private $id;
    private $nombre;
    private $direccion;
    private $telefono;
    private $email;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDireccion() { return $this->direccion; }
    public function getTelefono() { return $this->telefono; }
    public function getEmail() { return $this->email; }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setEmail($email) { $this->email = $email; }

    // Métodos CRUD
    public function getAll() {
        try {
            $sql = "SELECT * FROM proveedor ORDER BY Nombre_Proveedor ASC";
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
            $sql = "SELECT * FROM proveedor WHERE ID_Proveedor = :id";
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
            $sql = "INSERT INTO proveedor (Nombre_Proveedor, Direccion, Telefono, Email) 
                    VALUES (:nombre, :direccion, :telefono, :email)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':direccion', $this->direccion);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update() {
        try {
            $sql = "UPDATE proveedor SET 
                    Nombre_Proveedor = :nombre, 
                    Direccion = :direccion, 
                    Telefono = :telefono, 
                    Email = :email 
                    WHERE ID_Proveedor = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':direccion', $this->direccion);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete() {
        try {
            // Primero verificamos que no haya productos asociados a este proveedor
            $sql = "SELECT COUNT(*) as total FROM producto WHERE ID_Proveedor = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result['total'] > 0) {
                return false; // No se puede eliminar si hay productos asociados
            }
            
            // Si no hay productos, procedemos a eliminar el proveedor
            $sql = "DELETE FROM proveedor WHERE ID_Proveedor = :id";
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