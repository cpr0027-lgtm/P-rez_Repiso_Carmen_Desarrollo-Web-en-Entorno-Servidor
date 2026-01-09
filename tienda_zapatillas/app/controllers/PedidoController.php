<?php
session_start();

/* 1️⃣ Comprobar sesión */
if (!isset($_SESSION['usuario'])) {
    header("Location: /tienda_zapatillas/public/login.php");
    exit;
}

/* 2️⃣ Normalizar rol (protección total) */
$rol = strtolower(trim($_SESSION['usuario']['rol'] ?? ''));

/* 3️⃣ Solo usuarios cliente */
if ($rol !== 'user') {
    header("Location: /tienda_zapatillas/public/index.php");
    exit;
}

/* 4️⃣ Carrito no vacío */
if (empty($_SESSION['carrito'])) {
    header("Location: /tienda_zapatillas/public/carrito.php");
    exit;
}

require_once __DIR__ . '/../services/ProductoService.php';

$productoService = new ProductoService();

/* 5️⃣ Comprobar stock */
foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
    $producto = $productoService->obtenerProductoPorId($idProducto);

    if (!$producto || $producto['stock'] < $cantidad) {
        header("Location: /tienda_zapatillas/public/carrito.php?error=stock");
        exit;
    }
}

/* 6️⃣ Restar stock */
foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
    $productoService->restarStock($idProducto, $cantidad);
}

/* 7️⃣ Vaciar carrito */
unset($_SESSION['carrito']);

/* 8️⃣ Compra realizada */
header("Location: /tienda_zapatillas/public/pedido_ok.php");
exit;