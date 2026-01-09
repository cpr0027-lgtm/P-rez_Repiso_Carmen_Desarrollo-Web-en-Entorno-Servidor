<?php
session_start();

require_once __DIR__ . '/../services/UsuarioService.php';

class UsuarioController {

    private UsuarioService $service;

    public function __construct() {
        $this->service = new UsuarioService();
    }

    /* ================= LOGIN ================= */
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /tienda_zapatillas/public/login.php");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuario = $this->service->login($email, $password);

        if ($usuario) {
            $_SESSION['usuario'] = [
                'id'     => $usuario['id'],
                'nombre' => $usuario['nombre'],
                // 🔒 Protección: el rol NUNCA puede quedar vacío
                'rol'    => $usuario['rol'] ?: 'USER'
            ];

            header("Location: /tienda_zapatillas/public/index.php");
            exit;
        }

        header("Location: /tienda_zapatillas/public/login.php?error=1");
        exit;
    }

    /* ================= CREAR UN USUARIO (ADMIN) ================= */
    public function crear() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
            header("Location: /tienda_zapatillas/public/login.php");
            exit;
        }

        $data = [
            'nombre'   => $_POST['nombre'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'rol'      => $_POST['rol'] ?? 'USER'
        ];

        $this->service->crearUsuario($data);

        header("Location: /tienda_zapatillas/public/admin/usuarios.php");
        exit;
    }

    /* ================= REGISTRO DE UN CLIENTE ================= */
    public function registro() {

        $data = [
            'nombre'   => $_POST['nombre'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'rol'      => 'USER'
        ];

        $this->service->crearUsuario($data);

        header("Location: /tienda_zapatillas/public/login.php?registro=ok");
        exit;
    }

    /* ================= EDITAR UN USUARIO (ADMIN) ================= */
    public function editar() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
            header("Location: /tienda_zapatillas/public/login.php");
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header("Location: /tienda_zapatillas/public/admin/usuarios.php");
            exit;
        }

        // Evitar que el admin se quite su propio rol
        if ($id == $_SESSION['usuario']['id']) {
            $_POST['rol'] = 'ADMIN';
        }

        $this->service->actualizarUsuario($_POST);

        header("Location: /tienda_zapatillas/public/admin/usuarios.php");
        exit;
    }

    /* ================= ELIMINAR UN USUARIO ================= */
    public function eliminar() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'ADMIN') {
            header("Location: /tienda_zapatillas/public/login.php");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id || $id == $_SESSION['usuario']['id']) {
            header("Location: /tienda_zapatillas/public/admin/usuarios.php");
            exit;
        }

        $this->service->eliminarUsuario($id);

        header("Location: /tienda_zapatillas/public/admin/usuarios.php");
        exit;
    }
}

/* ================= ROUTER ================= */
$action = $_GET['action'] ?? null;
$controller = new UsuarioController();

switch ($action) {
    case 'login':
        $controller->login();
        break;

    case 'crear':
        $controller->crear();
        break;

    case 'registro':
        $controller->registro();
        break;

    case 'editar':
        $controller->editar();
        break;

    case 'eliminar':
        $controller->eliminar();
        break;

    default:
        header("Location: /tienda_zapatillas/public/index.php");
        exit;
}