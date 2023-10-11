<?php
require_once('../php/conn.php'); // Incluimos el archivo de conexión

// Iniciar la sesión si aún no se ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener el nombre de usuario del usuario actual
$nombreUsuario = obtenerNombreUsuarioActual();

/**
 * Función para obtener el nombre de usuario del usuario actual
 *
 * @return string|null Nombre de usuario o null si no se encuentra el usuario
 */
function obtenerNombreUsuarioActual()
{
    $pdo = conectarBaseDeDatos();

    if (isset($_SESSION["id_usuario"])) {
        try {
            $stmt = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = :id_usuario");
            $stmt->bindParam(":id_usuario", $_SESSION["id_usuario"], PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                return $usuario["nombre_usuario"];
            }
        } catch (PDOException $e) {
            // Manejar el error de base de datos si es necesario
            return null;
        }
    }

    return null;
}
