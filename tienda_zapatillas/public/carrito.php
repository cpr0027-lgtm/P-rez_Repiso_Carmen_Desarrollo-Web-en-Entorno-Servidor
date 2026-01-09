<?php
session_start();
require_once __DIR__ . '/../app/services/ProductoService.php';

$service = new ProductoService();
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
$compraPermitida = true;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="./css/carrito.css">
</head>
<body>

<h1>Carrito de compra</h1>

<?php if (isset($_GET['ok'])): ?>
    <p class="ok">✅ Compra realizada correctamente</p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p class="error">❌ Stock insuficiente para completar la compra</p>
<?php endif; ?>

<?php if (empty($carrito)): ?>

    <p>El carrito está vacío.</p>

    <a href="index.php" class="btn-volver">
        ⬅ Volver a la tienda
    </a>

<?php else: ?>

<div class="contenedor">

<?php foreach ($carrito as $id => $cantidad): 
    $p = $service->obtenerProductoPorId($id);
    if (!$p) continue;

    if ($cantidad > $p['stock']) {
        $compraPermitida = false;
    }

    $subtotal = $p['precio'] * $cantidad;
    $total += $subtotal;
?>
    <div class="producto">
        <h3><?= htmlspecialchars($p['nombre']) ?></h3>

        <?php if (!empty($p['imagen'])): ?>
            <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
        <?php endif; ?>

        <p>Stock disponible: <strong><?= $p['stock'] ?></strong></p>

        <p>Cantidad en carrito: <strong><?= $cantidad ?></strong></p>

        <p class="precio"><?= number_format($subtotal, 2) ?> €</p>

        <div class="acciones-carrito">

            <?php if ($cantidad < $p['stock']): ?>
            <form method="POST" action="../app/controllers/CarritoController.php">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" name="sumar">➕</button>
            </form>
            <?php endif; ?>

            <form method="POST" action="../app/controllers/CarritoController.php">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" name="restar">➖</button>
            </form>

            <form method="POST" action="../app/controllers/CarritoController.php">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" name="eliminar" class="danger">❌ Eliminar</button>
            </form>

        </div>
    </div>
<?php endforeach; ?>

</div>

<h2>Total: <?= number_format($total, 2) ?> €</h2>

<?php if (!isset($_SESSION['usuario'])): ?>
    <p class="error">⚠️ Debes iniciar sesión para confirmar la compra</p>
    <a href="login.php">🔐 Iniciar sesión</a>

<?php elseif (!$compraPermitida): ?>
    <p class="error">❌ Hay productos con más unidades que stock disponible</p>

<?php else: ?>
    <form action="/tienda_zapatillas/app/controllers/PedidoController.php" method="post">
        <button type="submit">Confirmar compra</button>
    </form>
<?php endif; ?>

<form method="POST" action="../app/controllers/CarritoController.php">
    <button type="submit" name="vaciar" class="danger">🗑 Vaciar carrito</button>
</form>

<a href="index.php">⬅ Volver a la tienda</a>

<?php endif; ?>

</body>
</html>