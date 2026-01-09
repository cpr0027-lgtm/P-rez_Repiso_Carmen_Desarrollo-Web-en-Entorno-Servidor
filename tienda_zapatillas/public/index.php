<?php
session_start();
require_once __DIR__ . '/../app/services/ProductoService.php';

$service = new ProductoService();
$productos = $service->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tienda Online</title>
<link rel="stylesheet" href="./css/index.css">
</head>
<body>

<h1>SportivaX</h1>

<nav class="top-nav">
    <?php if (isset($_SESSION['usuario'])): ?>
        <span class="saludo">
            👋 Hola, <strong><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></strong>
        </span>

        <a href="carrito.php" class="nav-link">🛒 Carrito</a>
        <a href="logout.php" class="nav-link logout">Cerrar sesión</a>

        <?php if ($_SESSION['usuario']['rol'] === 'ADMIN'): ?>
            <a href="admin/usuarios.php" class="nav-link admin">Usuarios</a>
            <a href="admin/productos.php" class="nav-link admin">Productos</a>
        <?php endif; ?>

    <?php else: ?>
        <a href="login.php" class="nav-link">Login</a>
        <a href="registro.php" class="nav-link">Registro</a>
    <?php endif; ?>
</nav>

<?php if (isset($_GET['sin_stock'])): ?>
    <p class="alerta-error">❌ No hay stock disponible para este producto</p>
<?php endif; ?>

<div class="contenedor">
<?php foreach ($productos as $p): ?>
    <div class="producto">
        <h3><?= htmlspecialchars($p['nombre']) ?></h3>

        <?php if (!empty($p['imagen'])): ?>
            <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
        <?php endif; ?>

        <p><?= htmlspecialchars($p['descripcion']) ?></p>

        <p class="precio"><?= number_format($p['precio'], 2) ?> €</p>

        <p class="stock">
            Stock disponible: <strong><?= $p['stock'] ?></strong>
        </p>

        <?php if ($p['stock'] > 0): ?>
            <form method="POST" action="../app/controllers/CarritoController.php">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">

            <label>Cantidad:</label>
            <input
                    type="number"
                    name="cantidad"
                    value="1"
                    min="1"
                    max="<?= $p['stock'] ?>"
                    required
            >

    <button type="submit" name="add">Añadir</button>
</form>
        <?php else: ?>
            <button class="btn-disabled" disabled>Sin stock</button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>