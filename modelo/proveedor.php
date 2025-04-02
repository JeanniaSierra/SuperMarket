<?php
include '../config/conexion.php';

class Proveedor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cargarProveedores() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM proveedor");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener los proveedores: ' . $e->getMessage()];
        }
    }

    public function crearProveedor($nombre, $telefono, $direccion) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO proveedor (Nombre_Proveedor, Telefono, Direccion) VALUES (:nombre, :telefono, :direccion)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->execute();
            return ['success' => true, 'message' => 'Proveedor agregado correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al agregar el proveedor: ' . $e->getMessage()];
        }
    }
}
?> 