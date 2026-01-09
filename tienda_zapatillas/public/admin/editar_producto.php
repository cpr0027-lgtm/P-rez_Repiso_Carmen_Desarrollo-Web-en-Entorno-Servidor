<?php
session_start();
require_once __DIR__ . '/../../app/services/ProductoService.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit;
}

$service = new ProductoService();
$id = $_GET['id'];
$producto = $service->obtenerProductoPorId($id);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar producto</title>
<link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Editar producto</h1>

<form method="POST" action="/tienda_zapatillas/app/controllers/ProductoController.php?action=editar">
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">

    <input name="nombre" value="<?= $producto['nombre'] ?>" required>
    <input name="descripcion" value="<?= $producto['descripcion'] ?>">
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
    <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
    <input name="imagen" value="<?= $producto['imagen'] ?>">

    <button>Guardar cambios</button>
</form>

</body>
</html>