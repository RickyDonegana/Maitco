<?php
// Función para verificar las credenciales del usuario
function verificarCredenciales($email, $contrasena)
{
    $pdo = conectarBaseDeDatos();
    $stmt = $pdo->prepare("SELECT id_usuario, nombre_usuario, rol_id, contrasena FROM usuarios WHERE correo_electronico = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contrasena, $row["contrasena"])) {
            return $row;
        }
    }
    return false;
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    // Verifica las credenciales del usuario
    $usuario = verificarCredenciales($email, $contrasena);
    if ($usuario) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre_usuario"] = $usuario["nombre_usuario"];
        $_SESSION["rol_usuario"] = $usuario["rol_id"];
        header("Location: ../pages/inicio.php");
        exit;
    } else {
        // Error de inicio de sesión
        $mensajeError = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
}
