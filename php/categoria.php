<?php
include 'conexion.php';
$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'];
global $pdo;
if($action == "cargarCategorias"){
    try {
        $stmt = $pdo->prepare("SELECT * FROM categoria");
        $stmt->execute();
        $Categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($Categorias);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los Categorias: ' . $e->getMessage()]);
    }
}elseif($action == "crearCategoria"){
    $nombre = $input['nombreCategoria'];
    try {
        $stmt = $pdo->prepare("INSERT INTO categoria (Nombre_Categoria) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Categoria agregada correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la Categoria: ' . $e->getMessage()]);
    }
}

?>