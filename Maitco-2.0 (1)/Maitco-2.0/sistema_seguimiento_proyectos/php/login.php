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
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Consulta la base de datos para verificar las credenciales del usuario
    $stmt = $pdo->prepare("SELECT user_id, username, user_role FROM usuarios WHERE email = :email AND password = :contrasena");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
    $stmt->execute();

    // Verifica si se encontró un usuario con las credenciales proporcionadas
    if ($stmt->rowCount() == 1) {
        // Inicio de sesión exitoso
        session_start();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["user_role"] = $row["user_role"];
        header("Location: dashboard.php"); // Redirige al panel de control o página de inicio
    } else {
        // Error de inicio de sesión
        echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
}
?>
