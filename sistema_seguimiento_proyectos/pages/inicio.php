<?php
// Función para conectar a la base de datos
include('../php/conn.php');

// Función para conectar a la base de datos
include('../php/usuario.php');

// Obtener la lista de proyectos
$stmtProyectos = $pdo->query("SELECT * FROM proyectos");
$proyectos = $stmtProyectos->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- Encabezado de la página con menú fijo -->
    <header class="header">
        <nav class="menu">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="tabs">
                <li><a href="../pages/inicio.php">Inicio</a></li>
                <li><a href="../pages/proyectos.php">Proyectos</a></li>
                <li><a href="../pages/tareas.html">Tareas</a></li>
                <li><a href="../pages/configuracion.html">Configuración</a></li>
            </ul>
            <div class="user-icon">
                <img src="../svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="user-name"><?php echo isset($nombreUsuario) ? $nombreUsuario : ""; ?></span>
        </nav>
    </header>

    <main class="main-content">
        <section class="project-container">
            <!-- Contenido principal con proyectos -->
            <?php foreach ($proyectos as $proyecto) : ?>
                <div class="project-box">
                    <h3 class="project-title"><?php echo $proyecto["nombre_proyecto"]; ?></h3>
                    <p class="project-description"><?php echo $proyecto["descripcion"]; ?></p>
                    <p class="project-dates">
                        Cliente: <?php echo $proyecto["cliente"]; ?><br>
                        Desarrollador: <?php echo $proyecto["desarrollador"]; ?><br>
                        Fecha de Inicio: <?php echo $proyecto["fecha_inicio"]; ?><br>
                        Fecha Estimada de Finalización: <?php echo $proyecto["fecha_entrega_estimada"]; ?><br>
                    </p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>

</html>