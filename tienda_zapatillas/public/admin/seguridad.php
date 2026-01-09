<?php
session_start();

/*
 * Comprobamos:
 * 1. Que el usuario haya iniciado sesión
 * 2. Que su rol sea ADMIN
 */
if (
    !isset($_SESSION['usuario']) ||
    !isset($_SESSION['usuario']['rol']) ||
    $_SESSION['usuario']['rol'] !== 'ADMIN'
) {
    header("Location: ../login.php");
}
    exit;