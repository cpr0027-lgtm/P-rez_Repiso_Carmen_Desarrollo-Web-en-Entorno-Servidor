<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';

class UsuarioService {

    private UsuarioDAO $dao;

    public function __construct() {
        $this->dao = new UsuarioDAO();
    }

    // Obtener todos los usuarios (ADMIN)
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }
    
    public function listarUsuarios() {
        return $this->obtenerTodos();
    }

    // Crear usuario
    public function crearUsuario($data) {

        if (
            empty($data['nombre']) ||
            empty($data['email']) ||
            empty($data['password']) ||
            empty($data['rol'])
        ) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        return $this->dao->crear(
            $data['nombre'],
            $data['email'],
            $passwordHash,
            $data['rol']
        );
    }

    // Actualizar usuario (con o sin contraseña)
    public function actualizarUsuario($data) {

        if (
            empty($data['id']) ||
            empty($data['nombre']) ||
            empty($data['email']) ||
            empty($data['rol'])
        ) {
            throw new Exception("Datos incompletos");
        }

        // Con contraseña
        if (!empty($data['password'])) {
            $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

            return $this->dao->actualizarConPassword(
                $data['id'],
                $data['nombre'],
                $data['email'],
                $passwordHash,
                $data['rol']
            );
        }

        // Sin contraseña
        return $this->dao->actualizar(
            $data['id'],
            $data['nombre'],
            $data['email'],
            $data['rol']
        );
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        if (empty($id)) {
            throw new Exception("ID inválido");
        }

        return $this->dao->eliminar($id);
    }

    // Cambiar solo el rol
    public function cambiarRol($id, $rol) {
        if (empty($id) || empty($rol)) {
            throw new Exception("Datos inválidos");
        }

        return $this->dao->cambiarRol($id, $rol);
    }

    // Login
    public function login($email, $password) {

        $usuario = $this->dao->buscarPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($password, $usuario['password'])) {
            return false;
        }

        return $usuario;
    }

    // Buscar usuario por ID
    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }
}
