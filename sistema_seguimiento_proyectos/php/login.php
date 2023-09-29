<?php
// Incluye la conexión a la base de datos aquí
$host = "localhost";
$usuario = "root"; // Cambia esto si es diferente en tu entorno
$contrasena = ""; // Cambia esto si tienes una contraseña
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
        header("Location: ../html/index.html"); // Redirige al panel de control o página de inicio
        exit; // Termina el script después de redirigir
    } else {
        // Error de inicio de sesión
        echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <!-- login -->
    <section class="section__form">
        <div class="div__form card-nr">
            <div class="form__tittle">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="logo" class="img__form">
                <h1 class="tittle__form">Maitco</h1>
            </div>
            <h2 class="form__subtitle">Iniciar sesión</h2>
            <p class="form__paragraph">Ingresa tus datos aquí</p>

            <form action="" method="post" autocomplete="off">
                <div class="input__box">
                    <input type="email" name="email" class="input" placeholder="Email" required="required">
                    <input type="password" name="contrasena" class="input input-end" placeholder="Contraseña" required="required">
                    <label class="input__check"><input type="checkbox"> Recordar usuario</label>
                    <div class="btn__container">
                        <button type="submit" class="input__btn">Entrar</button>
                    </div>
                </div>
            </form>
            <p class="form__link">
                ¿No tienes una cuenta?
                <a href="../html/register.html" class="text-link">Regístrate aquí</a>
            </p>
        </div>
    </section>
</body>

</html>