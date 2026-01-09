<?php
require_once __DIR__ . '/../dao/PedidoDAO.php';
require_once __DIR__ . '/../dao/ProductoDAO.php';

class PedidoService {

    public static function confirmarPedido($usuario, $carrito) {

        $productoDAO = new ProductoDAO();
        $pedidoDAO   = new PedidoDAO();

        $total = 0;

        foreach ($carrito as $idProducto => $cantidad) {
            $producto = $productoDAO->obtenerPorId($idProducto);

            if (!$producto) {
                throw new Exception("Producto no encontrado");
            }

            if ($producto['stock'] < $cantidad) {
                throw new Exception("Stock insuficiente");
            }

            $total += $producto['precio'] * $cantidad;
        }

        $idPedido = $pedidoDAO->crearPedido($usuario['id'], $total);

        foreach ($carrito as $idProducto => $cantidad) {
            $producto = $productoDAO->obtenerPorId($idProducto);

            $pedidoDAO->insertarProducto(
                $idPedido,
                $idProducto,
                $cantidad,
                $producto['precio']
            );

            $nuevoStock = $producto['stock'] - $cantidad;
            $productoDAO->actualizarStock($idProducto, $nuevoStock);
        }

        return $idPedido;
    }
}
