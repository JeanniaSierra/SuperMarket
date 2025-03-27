<?php
include 'conexion.php';

class Categoria {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cargarCategorias() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM categoria");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener las categorías: ' . $e->getMessage()];
        }
    }

    public function crearCategoria($nombre) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO categoria (Nombre_Categoria) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            return ['success' => true, 'message' => 'Categoría agregada correctamente'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al agregar la categoría: ' . $e->getMessage()];
        }
    }
}
?>