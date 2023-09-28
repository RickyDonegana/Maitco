<?php
// Incluye la conexión a la base de datos aquí
// Reemplaza 'usuario', 'contraseña' y 'ssp_db' con tus propias credenciales
$host = "localhost";
$usuario = "usuario";
$contrasena = "contraseña";
$base_de_datos = "ssp_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirm_contrasena = $_POST["confirm_contrasena"];

    // Verifica si las contraseñas coinciden
    if ($contrasena !== $confirm_contrasena) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, email, user_role, acepta_condiciones) VALUES (:username, :password, :email, :user_role, :acepta_condiciones)");
        $stmt->bindParam(":username", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":password", $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":user_role", "Cliente", PDO::PARAM_STR); // Establece el rol del usuario como "Cliente"
        $stmt->bindValue(":acepta_condiciones", 1, PDO::PARAM_INT); // Asume que el usuario aceptó las condiciones

        if ($stmt->execute()) {
            // Registro exitoso
            header("Location: login.html"); // Redirige al formulario de inicio de sesión
        } else {
            // Error en el registro
            echo "Error en el registro. Por favor, inténtalo de nuevo.";
        }
    }
}
?>
