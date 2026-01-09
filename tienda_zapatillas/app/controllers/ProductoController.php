<?php
session_start();
require_once __DIR__ . '/../services/ProductoService.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
    header("Location: /tienda_zapatillas/public/login.php");
    exit;
}

$service = new ProductoService();
$action = $_GET['action'] ?? null;

if ($action === 'crear') {
    $service->crearProducto(
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['precio'],
        $_POST['stock'],
        $_POST['imagen']
    );
}

if ($action === 'editar') {
    $service->actualizarProducto(
        $_POST['id'],
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['precio'],
        $_POST['stock'],
        $_POST['imagen']
    );
}

if ($action === 'eliminar') {
    $service->eliminarProducto($_GET['id']);
}

header("Location: /tienda_zapatillas/public/admin/productos.php");
exit;