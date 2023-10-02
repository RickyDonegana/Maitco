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

// Función para insertar un nuevo usuario
function insertarUsuario($nombre_completo, $email, $contrasena, $user_role)
{
    $pdo = conectarBaseDeDatos();

    // Hashea la contraseña antes de almacenarla en la base de datos
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, email, user_role, registro_completo) VALUES (:username, :password, :email, :user_role, 1)");

    // Divide el nombre completo en nombre y apellido
    $nombre_completo_array = explode(" ", $nombre_completo);
    $primer_nombre = $nombre_completo_array[0];
    $apellido = count($nombre_completo_array) > 1 ? end($nombre_completo_array) : "";

    $stmt->bindParam(":username", $nombre_completo, PDO::PARAM_STR);
    $stmt->bindParam(":password", $hashContrasena, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":user_role", $user_role, PDO::PARAM_STR);

    return $stmt->execute();
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
            header("Location: ../php/login.php"); // Redirige al formulario de inicio de sesión
            exit; // Termina el script después de redirigir
        } else {
            // Error en el registro
            $mensajeError = "Error en el registro. Por favor, inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- registro -->
    <section class="section__form">
        <div class="div__form card-nr">
            <div class="form__tittle">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="logo" class="img__form">
                <h1 class="tittle__form">Maitco</h1>
            </div>
            <h2 class="form__subtitle">Registro</h2>
            <p class="form__paragraph">Ingresa tus datos aquí</p>

            <form action="" method="post" autocomplete="off">
                <div class="input__box">
                    <input type="text" class="input" name="nombre_completo" placeholder="Nombre Completo" required="required">
                    <input type="email" class="input" name="email" placeholder="Email" required="required">
                    <input type="password" class="input" name="contrasena" placeholder="Contraseña" required="required">
                    <input type="password" class="input" name="confirm_contrasena" placeholder="Confirmar contraseña" required="required">

                    <label for="user_role" class="input__label">Rol</label>
                    <select name="user_role" id="user_role" class="input__field" required="required">
                        <option value="" selected disabled>Seleccionar rol</option>
                        <option value="Cliente">Cliente</option>
                        <option value="Desarrollador de sitios">Desarrollador de sitios</option>
                    </select>

                    <label class="input__check">
                        <input type="checkbox" required="required"> Acepto las <a href="#">Condiciones de uso</a> y <a href="#">la política de privacidad</a>
                    </label>

                    <div class="btn__container">
                        <button type="submit" class="input__btn">Registrarse</button>
                    </div>
                </div>
            </form>

            <p class="form__link">
                ¿Ya tienes una cuenta?
                <a href="../php/login.php" class="text-link">Iniciar sesión</a>
            </p>

            <?php if (isset($mensajeError)) : ?>
                <p class="error-message"><?php echo $mensajeError; ?></p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>