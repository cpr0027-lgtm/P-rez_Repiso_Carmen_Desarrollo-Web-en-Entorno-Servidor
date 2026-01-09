<?php

class Database {

    private string $host = "localhost";
    private string $db   = "tienda_zapatillas";
    private string $user = "root";
    private string $pass = "";
    private ?PDO $conexion = null;

    public function getConexion(): PDO {

        if ($this->conexion === null) {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return $this->conexion;
    }
}