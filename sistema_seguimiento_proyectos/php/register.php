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
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, email, user_role, registro_completo) VALUES (:username, :password, :email, 'Cliente', 1)");
        $stmt->bindParam(":username", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":password", $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Registro exitoso
            header("Location: ../html/login.html"); // Redirige al formulario de inicio de sesión
            exit; // Termina el script después de redirigir
        } else {
            // Error en el registro
            echo "Error en el registro. Por favor, inténtalo de nuevo.";
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
                    <input type="text" class="input" name="nombre" placeholder="Nombre" required="required">
                    <input type="text" class="input" name="apellido" placeholder="Apellido" required="required">
                    <input type="email" class="input" name="email" placeholder="Email" required="required">
                    <input type="password" class="input" name="contrasena" placeholder="Contraseña" required="required">
                    <input type="password" class="input" name="confirm_contrasena" placeholder="Confirmar contraseña" required="required">
                    <label class="input__check"><input type="checkbox" required="required"> Acepto las <a href="#">Condiciones de uso</a> y <a href="#">la política de privacidad</a></label>

                    <div class="btn__container">
                        <button type="submit" class="input__btn">Registrarse</button>
                    </div>
                </div>
            </form>
            <p class="form__link">
                ¿Ya tienes una cuenta?
                <a href="../html/login.html" class="text-link">Iniciar sesión</a>
            </p>
        </div>
    </section>
</body>

</html>