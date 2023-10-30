<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/funcion_proyectos.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <header class="encabezado">
        <nav class="menu-navegacion">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="pestanas">
                <li><a href="../pages/inicio.php">Inicio</a></li>
                <li><a href="../pages/proyectos.php">Proyectos</a></li>
                <li><a href="../pages/tareas.php">Tareas</a></li>
                <li><a href="../php/logout.php">Cerrar Sesión</a></li>
            </ul>
            <div class="icono-usuario">
                <img src="../svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="nombre-usuario">
                <?= isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <section class="contenedor-proyectos">
            <?php foreach ($proyectos as $proyecto) : ?>
                <div class="proyecto proyecto-enlace" onclick="redirigirAPrueba1()" <?php if ($proyecto['estado'] == 'finalizado') { ?> style="display:none;" <?php } ?>>
                    <h3 class="titulo-proyecto"><?= $proyecto["nombre_proyecto"]; ?></h3>
                    <p class="descripcion-proyecto"><?= $proyecto["descripcion"]; ?></p>
                    <p class="fechas-proyecto">
                        <strong>Cliente: </strong><?= $proyecto["cliente"]; ?><br>
                        <strong>Desarrollador: </strong><?= $proyecto["desarrollador"]; ?><br>
                        <strong>Fecha de Inicio: </strong><?= $proyecto["fecha_inicio"]; ?><br>
                        <strong>Fecha Estimada de Finalización: </strong><?= $proyecto["fecha_entrega_estimada"]; ?><br>
                    </p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <script>
        function redirigirAPrueba1() {
            window.location.href = "../html/prueba1.html";
        }
    </script>
</body>

</html>