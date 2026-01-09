<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-body">

<div class="auth-card">
    <h2>Iniciar sesión</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">❌ Email o contraseña incorrectos</p>
    <?php endif; ?>

    <form method="POST" action="../app/controllers/UsuarioController.php?action=login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="link">
        ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
    </p>
</div>

</body>
</html>