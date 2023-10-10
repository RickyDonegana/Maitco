<?php
// Función para insertar un nuevo usuario
function insertarUsuario($nombre_completo, $email, $contrasena, $user_role)
{
    $pdo = conectarBaseDeDatos();
    // Hashea la contraseña antes de almacenarla en la base de datos
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Obtener el ID del rol seleccionado
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
        return false; // Rol no encontrado
    }
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre_completo = $_POST["nombre_completo"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirm_contrasena = $_POST["confirm_contrasena"];
    $user_role = $_POST["user_role"];
    // Verifica si las contraseñas coinciden
    if ($contrasena !== $confirm_contrasena) {
        $mensajeError = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        if (insertarUsuario($nombre_completo, $email, $contrasena, $user_role)) {
            // Registro exitoso
            session_start();
            $_SESSION["registro_exitoso"] = true;
            header("Location: ../pages/login.php"); // Redirige al formulario de inicio de sesión
            exit; // Termina el script después de redirigir
        } else {
            // Error en el registro
            $mensajeError = "Error en el registro. Por favor, inténtalo de nuevo.";
        }
    }
}
