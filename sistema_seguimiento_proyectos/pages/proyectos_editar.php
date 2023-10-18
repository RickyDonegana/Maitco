<?php
require_once('../php/conn.php');
require_once('../php/funcion_proyectos.php');
require_once('../php/usuario.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto | Maitco</title>
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
                <li><a href="../pages/configuracion.html">Configuración</a></li>
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
        <h1 class="titulo">Editar Proyecto</h1>
        <a href="../pages/proyectos.php" class="boton-agregarEditar">Mostrar Tabla</a>
        <div id="editarProyectoForm" class="formulario-proyecto">
            <h2 class="titulo" id="formTitle">Editar Proyecto</h2>
            <form method="POST" id="proyectoForm">
                <input type="hidden" class="input" id="id_proyecto_form" name="id_proyecto">
                <label for="nombre_proyecto" class="label">Nombre del Proyecto:</label>
                <input type="text" class="input" id="nombre_proyecto" name="nombre_proyecto" required>
                <label for="descripcion" class="label">Descripción:</label>
                <textarea class="input" id="descripcion" name="descripcion" required></textarea>
                <label for="cliente" class="label">Cliente:</label>
                <input type="text" class="input" id="cliente" name="cliente" required>
                <label for="desarrollador" class="label">Desarrollador:</label>
                <input type="text" class="input" id="desarrollador" name="desarrollador" required>
                <label for="fecha_inicio" class="label">Fecha de Inicio:</label>
                <input type="date" class="input" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_entrega_estimada" class="label">Fecha de Finalización Estimada:</label>
                <input type="date" class="input" id="fecha_entrega_estimada" name="fecha_entrega_estimada" required>
                <label for="estado" class="label">Estado:</label>
                <select name="estado" class="select" id="estado_form" required>
                    <option value="inicio">Inicio</option>
                    <option value="planificacion">Planificación</option>
                    <option value="ejecucion">Ejecución</option>
                    <option value="supervision">Supervisión</option>
                    <option value="cierre">Cierre</option>
                </select>
                <button type="submit" class="boton-agregarEditar" id="btnEditar" name="editar_proyecto">Editar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>