<?php
session_start();
require_once __DIR__ . '/../../app/services/ProductoService.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit;
}

$service = new ProductoService();
$productos = $service->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos</title>
<link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Gestión de Productos</h1>
<a href="usuarios.php">Usuarios</a> | <a href="../index.php">Tienda</a>

<h2>Crear producto</h2>
<form method="POST" action="/tienda_zapatillas/app/controllers/ProductoController.php?action=crear">
    <input name="nombre" placeholder="Nombre" required>
    <input name="descripcion" placeholder="Descripción">
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <input name="imagen" placeholder="Imagen (ruta)">
    <button>Crear</button>
</form>

<h2>Lista de productos</h2>
<table>
<tr>
<th>Nombre</th>
<th>Precio</th>
<th>Stock</th>
<th>Acciones</th>
</tr>

<?php foreach ($productos as $p): ?>
<tr>
<td><?= htmlspecialchars($p['nombre']) ?></td>
<td><?= $p['precio'] ?> €</td>
<td><?= $p['stock'] ?></td>
<td>
    <a  href="editar_producto.php?id=<?= $p['id'] ?>">Editar </a> 
    <a  href="/tienda_zapatillas/app/controllers/ProductoController.php?action=eliminar&id=<?= $p['id'] ?>"
        onclick="return confirm('¿Eliminar producto?')">Eliminar
    </a>
</td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>