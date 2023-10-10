<?php
// Verifica si la función ya ha sido declarada antes de volver a declararla
if (!function_exists('conectarBaseDeDatos')) {
    // Función para conectar a la base de datos
    function conectarBaseDeDatos()
    {
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $base_de_datos = "ssp_db";

        try {
            // Configuración de la conexión
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            // Crear una nueva instancia de PDO para la conexión a la base de datos
            $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena, $opciones);

            return $pdo;
        } catch (PDOException $e) {
            // Manejar el error, ya sea mostrando un mensaje de error o registrándolo en un archivo de registro
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
