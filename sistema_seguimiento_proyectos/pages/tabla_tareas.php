<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
require_once('../php/funcion_proyectos.php');
require_once('../php/funcion_tareas.php');
require_once('');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="es">

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
        <h1 class="titulo">Mis Tareas</h1>

        <!-- Botón para mostrar/ocultar el formulario -->
        <button class="boton-principal boton-agregar" id="btnAgregarTarea">Agregar Nueva Tarea</button>

        <!-- Tabla para mostrar las tareas -->
        <table id="tablaTareas" class="tabla-tareas">
            <!-- Encabezado de la tabla -->
            <thead>
                <tr>
                    <th>ID Tarea</th>
                    <th>Nombre Tarea</th>
                    <th>Descripción</th>
                    <th>Proyecto</th>
                    <th>Asignada a</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tareas as $tarea) : ?>
                    <tr>
                        <td><?php echo $tarea["id_tarea"]; ?></td>
                        <td><?php echo $tarea["nombre_tarea"]; ?></td>
                        <td><?php echo $tarea["descripcion_tarea"]; ?></td>
                        <td><?php echo $tarea["nombre_proyecto"]; ?></td>
                        <td><?php echo $tarea["nombre_usuario"]; ?></td>
                        <td><?php echo $tarea["fecha_vencimiento"]; ?></td>
                        <td><?php echo $tarea["estado_id"]; ?></td>
                        <td>
                            <form method="POST" class="select-container">
                                <input type="hidden" name="id_tarea" value="<?php echo $tarea["id_tarea"]; ?>">
                                <select name="nuevo_estado" class="select" onchange="cambiarEstado(<?php echo $proyecto['id_proyecto']; ?>, this.value)">
                                    <option value="inicio" <?php echo ($tarea["estado"] == 'inicio') ? 'selected' : ''; ?>>Inicio</option>
                                    <option value="planificacion" <?php echo ($tarea["estado"] == 'planificacion') ? 'selected' : ''; ?>>Planificación</option>
                                    <option value="ejecucion" <?php echo ($tarea["estado"] == 'ejecucion') ? 'selected' : ''; ?>>Ejecución</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <input type="hidden" id="estado_<?php echo $tarea["id_tarea"]; ?>" value="<?php echo $tarea["estado_id"]; ?>">
                            <button data-action="editar" data-id="<?php echo $tarea["id_tarea"]; ?>" data-nombre="<?php echo $tarea["nombre_tarea"]; ?>" data-descripcion="<?php echo $tarea["descripcion_tarea"]; ?>" data-cliente="<?php echo $tarea["nombre_proyecto"]; ?>" data-desarrollador="<?php echo $tarea["nombre_usuario"]; ?>" data-fechaInicio="<?php echo $tarea["fecha_vencimiento"]; ?>" data-fechaEntrega="<?php echo $tarea["estado_id"]; ?>" data-estado="<?php echo $tarea["estado_id"]; ?>" class="boton-principal boton-editar">Editar</button>
                            <button data-action="finalizar" data-id="<?php echo $tarea["id_tarea"]; ?>" class="boton-principal boton-finalizar">Finalizar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulario para agregar o editar tareas (inicialmente oculto) -->
        <div id="nuevaTareaForm" class="formulario-tarea" style="display: none;">
            <h2 class="titulo">Nueva Tarea</h2>
            <form method="POST">
                <!-- Agrega un campo oculto para almacenar el ID de la tarea en caso de edición -->
                <input type="hidden" class="input" id="id_tarea_form" name="id_tarea">
                <label for="nombre_tarea" class="label">Nombre de la Tarea:</label>
                <input type="text" class="input" id="nombre_tarea" name="nombre_tarea" required>
                <label for="descripcion_tarea" class="label">Descripción:</label>
                <textarea class="input" id="descripcion_tarea" name="descripcion_tarea" rows="2" required></textarea>
                <label for="id_proyecto" class="label">Proyecto:</label>
                <select name="id_proyecto" class="select" id="id_proyecto_form" required>
                    <!-- Opciones de proyectos aquí -->
                </select>
                <label for="id_usuario" class="label">Asignada a:</label>
                <select name="id_usuario" class="select" id="id_usuario_form" required>
                    <!-- Opciones de usuarios aquí -->
                </select>
                <label for="fecha_vencimiento" class="label">Fecha de Vencimiento:</label>
                <input type="date" class="input" id="fecha_vencimiento" name="fecha_vencimiento" required>
                <label for="estado_id" class="label">Estado:</label>
                <select name="estado_id" class="select" id="estado_id_form" required>
                    <!-- Opciones de estados aquí -->
                </select>
                <!-- Botón para agregar o editar tareas -->
                <button type="submit" class="boton-principal boton-agregar" id="btnAgregarEditarTarea" name="agregar_tarea">Agregar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>