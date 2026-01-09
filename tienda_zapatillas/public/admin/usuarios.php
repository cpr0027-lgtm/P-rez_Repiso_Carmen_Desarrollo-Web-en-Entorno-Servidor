<?php
session_start();

require_once __DIR__ . '/../../app/services/UsuarioService.php';

// SEGURIDAD: solo ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit;
}

$service = new UsuarioService();

/* EDITAR USUARIO */
if (isset($_POST['editar'])) {
    $service->actualizarUsuario([
        'id'       => $_POST['id'],
        'nombre'   => $_POST['nombre'],
        'email'    => $_POST['email'],
        'rol'      => $_POST['rol'],
        'password' => $_POST['password'] ?? null
    ]);

    header("Location: usuarios.php");
    exit;
}

/* LISTAR USUARIOS */
$usuarios = $service->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Usuarios</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="container">

    <h1>Panel de Administración</h1>
    <p><a href="../index.php">⬅ Volver a la tienda</a></p>

    <!-- CREAR USUARIO -->
    <div class="card">
        <h2>Crear usuario</h2>

        <form method="POST" action="/tienda_zapatillas/app/controllers/UsuarioController.php?action=crear">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Contraseña" required>

            <select name="rol">
                <option value="USER">Usuario</option>
                <option value="ADMIN">Administrador</option>
            </select>

            <button type="submit">Crear</button>
        </form>
    </div>

    <!-- LISTA USUARIOS -->
    <div class="card">
        <h2>Lista de usuarios</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>

            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <form method="POST">
                        <td><?= $u['id'] ?></td>

                        <td>
                            <input type="text" name="nombre"
                                   value="<?= htmlspecialchars($u['nombre']) ?>" required>
                        </td>

                        <td>
                            <input type="email" name="email"
                                   value="<?= htmlspecialchars($u['email']) ?>" required>
                        </td>

                        <!-- ROL -->
                        <td>
                            <?php if ($u['id'] != $_SESSION['usuario']['id']): ?>
                                <select name="rol">
                                    <option value="USER" <?= $u['rol'] === 'USER' ? 'selected' : '' ?>>USER</option>
                                    <option value="ADMIN" <?= $u['rol'] === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                                </select>
                            <?php else: ?>
                                <span class="protected">ADMIN (tú)</span>
                                <input type="hidden" name="rol" value="ADMIN">
                            <?php endif; ?>
                        </td>

                        <!-- PASSWORD OPCIONAL -->
                        <td>
                            <input type="password" name="password"
                                   placeholder="Nueva (opcional)">
                        </td>

                        <td>
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">

                            <?php if ($u['id'] != $_SESSION['usuario']['id']): ?>
                                <button type="submit" name="editar">Guardar</button>

                                <a href="/tienda_zapatillas/app/controllers/UsuarioController.php?action=eliminar&id=<?= $u['id'] ?>"
                                   onclick="return confirm('¿Eliminar usuario?')">
                                    Eliminar
                                </a>
                            <?php else: ?>
                                <span class="protected">🔒 Protegido</span>
                            <?php endif; ?>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

</body>
</html>