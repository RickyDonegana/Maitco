<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
require_once('../php/tareas/agregar_tarea.php');
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
        <a href="../pages/tabla_tareas.php" class="boton-agregarEditar" id="btnAgregarTarea">Mostrar Tabla</a>
        <div id="nuevaTareaForm" class="formulario-tarea">
            <h2 class="titulo">Nueva Tarea</h2>
            <form method="POST">
                <input type="hidden" class="input" id="id_tarea_form" name="id_tarea">
                <label for="nombre_tarea" class="label">Nombre de la Tarea:</label>
                <input type="text" class="input" id="nombre_tarea" name="nombre_tarea" required>
                <label for="descripcion_tarea" class="label">Descripción:</label>
                <textarea class="input" id="descripcion_tarea" name="descripcion_tarea" rows="2" required></textarea>
                
                <label for="id_usuario" class="label">Asignada a:</label>
                <select name="id_usuario" class="label" id="id_usuario_form" required>
                    <?php
                    $sql = "SELECT id_usuario, nombre_usuario FROM usuarios WHERE rol_id = (SELECT id_rol FROM roles WHERE nombre_rol = 'Desarrollador de sitios')";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $usuariosDesarrolladores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($usuariosDesarrolladores as $usuario) :
                    ?>
                        <option value="<?php echo $usuario['id_usuario']; ?>">
                            <?php echo $usuario['nombre_usuario']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="fecha_vencimiento" class="label">Fecha de Vencimiento:</label>
                <input type="date" class="input" id="fecha_vencimiento" name="fecha_vencimiento" required>
                <label for="estado_id" class="label">Estado:</label>
                <select name="estado_id" class="select" id="estado_id_form" required>
                    <option value="" disabled selected>Selecciona un estado</option>
                    <?php
                    // Realiza una consulta para obtener los estados de tareas desde la base de datos
                    $sql = "SELECT id_estado, nombre_estado FROM estados_tarea";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $estadosTarea = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Itera a través de los estados de tareas y crea opciones en el menú desplegable
                    foreach ($estadosTarea as $estado) :
                    ?>
                        <option value="<?php echo $estado['id_estado']; ?>">
                            <?php echo $estado['nombre_estado']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="boton-agregarEditar" id="btnAgregarEditarTarea" name="agregar_tarea">Agregar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>