<?php
include('../php/conn.php');

session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    header('Location: ../pages/login.php');
    die();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener el nombre de usuario del usuario actual
$nombreUsuario = obtenerNombreUsuarioActual();
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
            return null;
        }
    }
    return null;
}
