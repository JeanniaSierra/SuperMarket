<?php
include 'conexion.php';
$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'];
//funcion para llamar los proveedores con try catch ya tengo la conexion a la base de datos y $pdo genera error
if($action == "cargarProveedores"){
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM proveedor");
        $stmt->execute();
        $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // devolver los proveedores en formato JSON
        echo json_encode($proveedores);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los proveedores: ' . $e->getMessage()]);
    }
}elseif($action =="crearProveedor"){
    $nombre = $input['nombre'];
    $direccion = $input['direccion'];
    $telefono = $input['telefono'];
    try {
        $stmt = $pdo->prepare("INSERT INTO proveedor (Nombre_Proveedor,Telefono, Direccion) VALUES (:nombre, :telefono, :direccion)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Proveedor agregado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el proveedor: ' . $e->getMessage()]);
    }
}

?>
