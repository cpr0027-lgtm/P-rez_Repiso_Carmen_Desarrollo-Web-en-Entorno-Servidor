<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';

class ProductoService {

    private $dao;

    public function __construct() {
        $this->dao = new ProductoDAO();
    }

    public function obtenerProductos() {
        return $this->dao->obtenerTodos();
    }

    public function obtenerProductoPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function crearProducto($nombre, $descripcion, $precio, $stock, $imagen) {
        return $this->dao->crear($nombre, $descripcion, $precio, $stock, $imagen);
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $imagen) {
        return $this->dao->actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen);
    }

    public function eliminarProducto($id) {
        return $this->dao->eliminar($id);
    }

    public function restarStock($idProducto, $cantidad) {
        $producto = $this->obtenerProductoPorId($idProducto);
        $nuevoStock = $producto['stock'] - $cantidad;

        $this->dao->actualizarStock($idProducto, $nuevoStock);
    }

}