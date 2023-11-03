<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/_login.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
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
                    <label class="input__check">
                        <input type="checkbox"> Recordar usuario</label>
                    </label>
                    <?php if (isset($mensajeError)) : ?>
                        <p class="error-message">
                            <?php echo $mensajeError; ?>
                        </p>
                    <?php endif; ?>
                    <div class="btn__container">
                        <button type="submit" class="input__btn">Entrar</button>
                    </div>
                </div>
            </form>
            <p class="form__link">
                ¿No tienes una cuenta?
                <a href="../pages/registro.php" class="text-link">Regístrate aquí</a>
            </p>
        </div>
    </section>
</body>

</html>