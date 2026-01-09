<?php
require_once __DIR__ . '/../config/database.php';

class PedidoDAO {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConexion();
    }

    public function crearPedido($idUsuario, $total) {
        $stmt = $this->db->prepare(
            "INSERT INTO pedidos (id_usuario, total, fecha) VALUES (?, ?, NOW())"
        );
        $stmt->execute([$idUsuario, $total]);
        return $this->db->lastInsertId();
    }

    public function insertarProducto($idPedido, $idProducto, $cantidad, $precio) {
        $stmt = $this->db->prepare(
            "INSERT INTO pedido_detalle (id_pedido, id_producto, cantidad, precio)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$idPedido, $idProducto, $cantidad, $precio]);
    }

    public function obtenerPedidosPorUsuario($idUsuario) {
        $stmt = $this->db->prepare(
            "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY fecha DESC"
        );
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodosLosPedidos() {
        $stmt = $this->db->query(
            "SELECT p.id, p.fecha, p.total, u.nombre AS usuario
             FROM pedidos p
             JOIN usuarios u ON p.id_usuario = u.id
             ORDER BY p.fecha DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}