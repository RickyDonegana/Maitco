<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/funcion_proyectos.php');
require_once('../php/funcion_tareas.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="png">
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
                <?php echo isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <h1 class="titulo">Tareas</h1>
        <section class="contenedor-proyectos">
            <?php foreach ($proyectos as $proyecto) : ?>
                <div class="proyecto proyecto-enlace" onclick="redirigirATablaTareas(<?php echo $proyecto['id_proyecto']; ?>)">
                    <h3 class="titulo-proyecto">
                        <?php echo $proyecto["nombre_proyecto"]; ?>
                    </h3>
                    <p class="descripcion-proyecto">
                        <?php echo $proyecto["descripcion"]; ?>
                    </p>
                    <p class="fechas-proyecto">
                        Tareas Pendientes: <?php echo contarTareasPorEstado($proyecto['id_proyecto'], 'Pendiente'); ?><br>
                        Tareas en Progreso: <?php echo contarTareasPorEstado($proyecto['id_proyecto'], 'En Progreso'); ?><br>
                        Tareas Completadas: <?php echo contarTareasPorEstado($proyecto['id_proyecto'], 'Completada'); ?><br>
                        Fecha Estimada de Finalización: <?php echo $proyecto["fecha_entrega_estimada"]; ?><br>
                        <input type="hidden" name="id_proyecto" value="<?php echo $proyecto['id_proyecto']; ?>">
                    </p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <script>
        function redirigirATablaTareas(proyectoId) {
            window.location.href = "../pages/tabla_tareas.php?id_proyecto=" + proyectoId;
        }
    </script>
</body>

</html>