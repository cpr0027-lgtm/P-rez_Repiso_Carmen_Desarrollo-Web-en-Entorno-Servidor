<?php
require_once __DIR__ . '/../config/database.php';

class ProductoDAO {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConexion();
    }

    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion, $precio, $stock, $imagen) {
        $stmt = $this->db->prepare(
            "INSERT INTO productos (nombre, descripcion, precio, stock, imagen)
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen) {
        $stmt = $this->db->prepare(
            "UPDATE productos 
            SET nombre=?, descripcion=?, precio=?, stock=?, imagen=?
            WHERE id=?"
        );
        return $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function restarStock($idProducto, $cantidad) {
        $stmt = $this->db->prepare(
            "UPDATE productos SET stock = stock - ? WHERE id = ?"
        );
        return $stmt->execute([$cantidad, $idProducto]);
    }

    public function actualizarStock($id, $stock) {
        $sql = "UPDATE productos SET stock = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$stock, $id]);
    }

}