<?php
require_once('../php/conn.php');
require_once('../php/funcion_proyectos.php');
require_once('../php/proyectos/editar_proyecto.php');
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
                <input type="hidden" class="input" id="id_proyecto_form" name="id_proyecto" value="<?php echo $proyecto['id_proyecto']; ?>">
                <label for="nombre_proyecto" class="label">Nombre del Proyecto:</label>
                <input type="text" class="input" id="nombre_proyecto" name="nombre_proyecto" required value="<?php echo $proyecto['nombre_proyecto']; ?>">
                <label for="descripcion" class="label">Descripción:</label>
                <textarea class="input" id="descripcion" name="descripcion" required><?php echo $proyecto['descripcion']; ?></textarea>
                <label for="cliente" class "label">Cliente:</label>
                <input type="text" class="input" id="cliente" name="cliente" required value="<?php echo $proyecto['cliente']; ?>">
                <label for="desarrollador" class="label">Desarrollador:</label>
                <input type="text" class="input" id="desarrollador" name="desarrollador" required value="<?php echo $proyecto['desarrollador']; ?>">
                <label for="fecha_inicio" class="label">Fecha de Inicio:</label>
                <input type="date" class="input" id="fecha_inicio" name="fecha_inicio" required value="<?php echo $proyecto['fecha_inicio']; ?>">
                <label for="fecha_entrega_estimada" class="label">Fecha de Finalización Estimada:</label>
                <input type="date" class="input" id="fecha_entrega_estimada" name="fecha_entrega_estimada" required value="<?php echo $proyecto['fecha_entrega_estimada']; ?>">
                <label for="estado" class="label">Estado:</label>
                <select name="estado" class="select" id="estado_form" required>
                    <option value="inicio" <?php echo ($proyecto['estado'] === 'inicio') ? 'selected' : ''; ?>>Inicio</option>
                    <option value="planificacion" <?php echo ($proyecto['estado'] === 'planificacion') ? 'selected' : ''; ?>>Planificación</option>
                    <option value="ejecucion" <?php echo ($proyecto['estado'] === 'ejecucion') ? 'selected' : ''; ?>>Ejecución</option>
                    <option value="supervision" <?php echo ($proyecto['estado'] === 'supervision') ? 'selected' : ''; ?>>Supervisión</option>
                    <option value="cierre" <?php echo ($proyecto['estado'] === 'cierre') ? 'selected' : ''; ?>>Cierre</option>
                </select>
                <button type="submit" class="boton-agregarEditar" id="btnEditar" name="update">Editar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>