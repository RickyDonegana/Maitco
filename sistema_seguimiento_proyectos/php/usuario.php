<?php
// Inicia la sesión si aún no se ha iniciado if (session_status()==PHP_SESSION_NONE) { session_start(); } // Obtener el nombre de usuario del usuario actual if (isset($_SESSION["id_usuario"])) { $stmt=$pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = :id_usuario");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener el nombre de usuario del usuario actual
if (isset($_SESSION["id_usuario"])) {
    $stmt = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt->bindParam(":id_usuario", $_SESSION["id_usuario"], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreUsuario = $usuario["nombre_usuario"];
}
