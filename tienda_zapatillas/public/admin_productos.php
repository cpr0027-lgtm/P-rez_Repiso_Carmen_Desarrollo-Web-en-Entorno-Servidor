<?php
session_start();
require_once __DIR__ . "/../app/services/ProductoService.php";

// Solo ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
    die("Acceso denegado");
}

$service = new ProductoService();
$productos = $service->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Productos</title>
</head>
<body>

<h1>Administrar</h1>

<p>
    <a href="index.php">Volver a la tienda</a> |
    <a href="logout.php">Cerrar sesión</a>
</p>

<hr>

<h2>Crear nuevo producto</h2>

<form action="../app/controllers/ProductoController.php" method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" required></textarea><br><br>

    <label>Precio (€):</label><br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <label>Imagen (ruta):</label><br>
    <input type="text" name="imagen" placeholder="img/productos/nike.jpg" required><br><br>

    <button type="submit" name="crear">Crear producto</button>
</form>

<hr>

<h2>Productos existentes</h2>

<?php if (empty($productos)): ?>
    <p>No hay productos creados.</p>
<?php endif; ?>

<?php foreach ($productos as $p): ?>
    <div>
        <strong><?= htmlspecialchars($p['nombre']) ?></strong><br>
        <?= htmlspecialchars($p['descripcion']) ?><br>
        <?= number_format($p['precio'], 2) ?> €<br>
        <img src="<?= htmlspecialchars($p['imagen']) ?>" width="100"><br><br>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>