<?php
class Conexion {
    public static function conectar() {
        return new PDO(
            "mysql:host=localhost;dbname=tienda_zapatillas;charset=utf8",
            "root",
            ""
        );
    }
}