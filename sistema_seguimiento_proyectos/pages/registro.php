<?php
require_once('../php/conn.php');
require_once('../php/funcion_registro.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="es">

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
                    <label for="user_role" class="input">Rol</label>
                    <select name="user_role" id="user_role" class="input" required="required">
                        <option class="input" value="" selected disabled>Seleccionar rol</option>
                        <option class="input" value="Cliente">Cliente</option>
                        <option class="input" value="Desarrollador de sitios">Desarrollador de sitios</option>
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
                <a href="../pages/login.php" class="text-link">Iniciar sesión</a>
            </p>
            <?php if (!empty($mensajeError)) : ?>
                <p class="error-message">
                    <?php echo $mensajeError; ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>