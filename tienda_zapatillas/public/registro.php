<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
<link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-body">

<div class="auth-card">
    <h2>Registro</h2>

    <form method="POST" action="../app/controllers/UsuarioController.php?action=registro">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Registrarse</button>
    </form>

    <p class="link">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </p>
</div>

</body>
</html>