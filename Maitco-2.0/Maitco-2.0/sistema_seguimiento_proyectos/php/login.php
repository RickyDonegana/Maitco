<?php
// Función para conectar a la base de datos
function conectarBaseDeDatos()
{
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_de_datos = "ssp_db";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo; // Devuelve la conexión PDO
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Función para verificar las credenciales del usuario
function verificarCredenciales($email, $contrasena)
{
    $pdo = conectarBaseDeDatos(); // Obtiene la conexión PDO

    $stmt = $pdo->prepare("SELECT user_id, username, user_role, password FROM usuarios WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contrasena, $row["password"])) {
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
        $_SESSION["user_id"] = $usuario["user_id"];
        $_SESSION["username"] = $usuario["username"];
        $_SESSION["user_role"] = $usuario["user_role"];
        header("Location: ../html/index.html"); // Redirige al panel de control o página de inicio
        exit; // Termina el script después de redirigir
    } else {
        // Error de inicio de sesión
        $mensajeError = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
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
                <a href="../php/register.php" class="text-link">Regístrate aquí</a>
            </p>

            <?php if (isset($mensajeError)) : ?>
                <p class="error-message"><?php echo $mensajeError; ?></p>
            <?php endif; ?>
            <?php
            // Muestra mensaje de registro exitoso si está presente
            session_start();
            if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
                echo '<p class="success-message">Registro exitoso. Ahora puedes iniciar sesión.</p>';
                unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
            }
            ?>
        </div>
    </section>
</body>

</html>