<?php
require_once 'config/database.php';

class Usuario {
    private $id;
    private $documento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;
    private $password;
    private $rol;
    private $estado;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function getDocumento() { return $this->documento; }
    public function getNombre() { return $this->nombre; }
    public function getApellido() { return $this->apellido; }
    public function getTelefono() { return $this->telefono; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRol() { return $this->rol; }
    public function getEstado() { return $this->estado; }

    public function setId($id) { $this->id = $id; }
    public function setDocumento($documento) { $this->documento = $documento; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
    public function setRol($rol) { $this->rol = $rol; }
    public function setEstado($estado) { $this->estado = $estado; }

    // Métodos CRUD
    public function login() {
        try {
            $sql = "SELECT * FROM usuarios WHERE Documento = :documento AND Rol = :rol";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':documento', $this->documento);
            $stmt->bindParam(':rol', $this->rol);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch();
                $verify = password_verify($this->password, $usuario['Password']);
                if ($verify || $this->password == $usuario['Password']) {
                    return $usuario;
                }
            }
            return false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function save() {
        try {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (Documento, Nombre, Apellido, Telefono, Email, Password, Rol, Estado) 
                    VALUES (:documento, :nombre, :apellido, :telefono, :email, :password, :rol, 'Activo')";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':documento', $this->documento);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':rol', $this->rol);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM usuarios";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?> 