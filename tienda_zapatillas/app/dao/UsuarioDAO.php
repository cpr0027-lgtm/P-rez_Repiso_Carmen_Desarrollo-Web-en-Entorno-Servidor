<?php
require_once __DIR__ . '/../config/database.php';

class UsuarioDAO {

    private PDO $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConexion();
    }

    // Obtener todos los usuarios (ADMIN)
    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT id, nombre, email, rol FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear usuario (password ya hasheada)
    public function crear($nombre, $email, $passwordHash, $rol) {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, email, password, rol) 
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $email, $passwordHash, $rol]);
    }

    // Actualizar usuario (sin cambiar contraseña)
    public function actualizar($id, $nombre, $email, $rol) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios 
             SET nombre = ?, email = ?, rol = ?
             WHERE id = ?"
        );
        return $stmt->execute([$nombre, $email, $rol, $id]);
    }

    // Actualizar usuario CON contraseña
    public function actualizarConPassword($id, $nombre, $email, $passwordHash, $rol) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios 
             SET nombre = ?, email = ?, password = ?, rol = ?
             WHERE id = ?"
        );
        return $stmt->execute([$nombre, $email, $passwordHash, $rol, $id]);
    }

    // Eliminar usuario
    public function eliminar($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM usuarios WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }

    // Cambiar solo el rol
    public function cambiarRol($id, $rol) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios SET rol = ? WHERE id = ?"
        );
        return $stmt->execute([$rol, $id]);
    }

    // 🔑 LOGIN → SOLO LOS CAMPOS NECESARIOS
    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare(
            "SELECT id, nombre, email, password, rol 
             FROM usuarios 
             WHERE email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuario por ID
    public function buscarPorId($id) {
        $stmt = $this->db->prepare(
            "SELECT id, nombre, email, rol FROM usuarios WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}