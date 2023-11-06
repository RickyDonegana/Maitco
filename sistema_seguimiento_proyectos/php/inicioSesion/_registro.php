<?php
require_once('../php/conn.php');

function esContraseñaSegura($contrasena) {
    return preg_match('/^(?=.*[a-záéíóúüñ])(?=.*[A-ZÁÉÍÓÚÜÑ])(?=.*\d).{8,}$/', $contrasena);
}

function insertarUsuario($nombre_completo, $email, $contrasena, $user_role)
{
    $pdo = conectarBaseDeDatos();
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("SELECT id_rol FROM roles WHERE nombre_rol = :nombre_rol");
    $stmt->bindParam(":nombre_rol", $user_role, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $rol_id = $result['id_rol'];
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, correo_electronico, rol_id, registro_completo) VALUES (:nombre_usuario, :contrasena, :correo_electronico, :rol_id, 1)");
        $stmt->bindParam(":nombre_usuario", $nombre_completo, PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $hashContrasena, PDO::PARAM_STR);
        $stmt->bindParam(":correo_electronico", $email, PDO::PARAM_STR);
        $stmt->bindParam(":rol_id", $rol_id, PDO::PARAM_INT);
        return $stmt->execute();
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST["nombre_completo"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirm_contrasena = $_POST["confirm_contrasena"];
    $user_role = $_POST["user_role"];
    if ($contrasena !== $confirm_contrasena) {
        $mensajeError = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } elseif (!esContraseñaSegura($contrasena)) {
        $mensajeError = "La contraseña debe cumplir con los siguientes requisitos: 
        al menos una letra mayúscula, una letra minúscula, un número y un mínimo de 8 caracteres.";
    } else {
        if (insertarUsuario($nombre_completo, $email, $contrasena, $user_role)) {
            session_start();
            $_SESSION["registro_exitoso"] = true;
            header("Location: ../pages/login.php");
            exit;
        } else {
            $mensajeError = "Error en el registro. Por favor, inténtalo de nuevo.";
        }
    }
}