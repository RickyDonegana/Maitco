<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');

$pdo = conectarBaseDeDatos();

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
    <header class="encabezado">
        <nav class="menu-navegacion">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="pestanas">
                <li><a href="../pages/inicio.php">Inicio</a></li>
                <li><a href="../pages/proyectos.php">Proyectos</a></li>
                <li><a href="../pages/tareas.html">Tareas</a></li>
                <li><a href="../pages/configuracion.html">Configuración</a></li>
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
        <section class="contenedor-proyectos">
            <!-- Contenido principal con proyectos -->
            <?php foreach ($proyectos as $proyecto) : ?>
                <div class="proyecto proyecto-enlace" onclick="redirigirAPrueba1()">
                    <h3 class="titulo-proyecto"><?php echo $proyecto["nombre_proyecto"]; ?></h3>
                    <p class="descripcion-proyecto"><?php echo $proyecto["descripcion"]; ?></p>
                    <p class="fechas-proyecto">
                        Cliente: <?php echo $proyecto["cliente"]; ?><br>
                        Desarrollador: <?php echo $proyecto["desarrollador"]; ?><br>
                        Fecha de Inicio: <?php echo $proyecto["fecha_inicio"]; ?><br>
                        Fecha Estimada de Finalización: <?php echo $proyecto["fecha_entrega_estimada"]; ?><br>
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