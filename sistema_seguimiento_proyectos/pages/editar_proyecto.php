<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/proyectos/editarProyecto.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
            </ul>
            <div class="icono-usuario">
                <img src="../assets/svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="nombre-usuario">
                <?= isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <h1 class="titulo">Editar Proyecto</h1>
        <a href="../pages/proyectos.php" class="boton-agregarEditar">Mostrar Tabla</a>
        <div class="formulario-proyecto">
            <h2 class="titulo">Editar Proyecto</h2>
            <form method="POST">
                <input type="hidden" class="input" name="id_proyecto" value="<?php echo $proyecto['id_proyecto']; ?>">
                <label for="nombre_proyecto" class="label">Nombre del Proyecto:</label>
                <input type="text" class="input" name="nombre_proyecto" required value="<?php echo $proyecto['nombre_proyecto']; ?>">
                <label for="descripcion" class="label">Descripción:</label>
                <textarea class="input" name="descripcion" required><?php echo $proyecto['descripcion']; ?></textarea>
                <label for="cliente" class="label">Cliente:</label>
                <input type="text" class="input" name="cliente" required value="<?php echo $proyecto['cliente']; ?>">
                <label for="desarrollador" class="label">Desarrollador:</label>
                <input type="text" class="input" name="desarrollador" required value="<?php echo $proyecto['desarrollador']; ?>">
                <label for="fecha_inicio" class="label">Fecha de Inicio:</label>
                <input type="date" class="input" name="fecha_inicio" required value="<?php echo $proyecto['fecha_inicio']; ?>">
                <label for="fecha_entrega_estimada" class="label">Fecha de Finalización Estimada:</label>
                <input type="date" class="input" name="fecha_entrega_estimada" required value="<?php echo $proyecto['fecha_entrega_estimada']; ?>">
                <label for="estado" class="label">Estado:</label>
                <select name="estado" class="input" required>
                    <option value="Inicio" <?php echo ($proyecto['estado'] === 'Inicio') ? 'selected' : ''; ?>>Inicio</option>
                    <option value="Planificacion" <?php echo ($proyecto['estado'] === 'Planificacion') ? 'selected' : ''; ?>>Planificación</option>
                    <option value="Ejecucion" <?php echo ($proyecto['estado'] === 'Ejecucion') ? 'selected' : ''; ?>>Ejecución</option>
                    <option value="Supervision" <?php echo ($proyecto['estado'] === 'Supervision') ? 'selected' : ''; ?>>Supervisión</option>
                    <option value="Cierre" <?php echo ($proyecto['estado'] === 'Cierre') ? 'selected' : ''; ?>>Cierre</option>
                </select>
                <button type="submit" class="boton-agregarEditar" name="update">Editar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>