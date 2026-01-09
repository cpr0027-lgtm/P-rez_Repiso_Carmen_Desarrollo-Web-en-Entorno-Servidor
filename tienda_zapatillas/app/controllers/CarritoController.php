<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_POST['vaciar'])) {
    $_SESSION['carrito'] = [];
    header("Location: ../../public/carrito.php");
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;

if (!$id) {
    header("Location: ../../public/index.php");
    exit;
}

if (isset($_POST['add'])) {
    if (!isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] = 1;
    } else {
        $_SESSION['carrito'][$id]++;
    }

    header("Location: ../../public/index.php");
    exit;
}

if (isset($_POST['sumar'])) {
    $_SESSION['carrito'][$id]++;
}

if (isset($_POST['restar'])) {
    $_SESSION['carrito'][$id]--;

    if ($_SESSION['carrito'][$id] <= 0) {
        unset($_SESSION['carrito'][$id]);
    }
}

if (isset($_POST['eliminar'])) {
    unset($_SESSION['carrito'][$id]);
}

header("Location: ../../public/carrito.php");
exit;