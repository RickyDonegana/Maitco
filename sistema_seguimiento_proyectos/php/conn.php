<?php
if (!function_exists('conectarBaseDeDatos')) {
    function conectarBaseDeDatos()
    {
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $base_de_datos = "ssp_db";
        try {
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena, $opciones);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
