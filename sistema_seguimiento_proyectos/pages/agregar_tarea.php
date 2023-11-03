<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/tareas/agregarTarea.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Tarea | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="png">
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
        <h1 class="titulo">Mis Tareas</h1>
        <a href="../pages/tabla_tareas.php?id_proyecto=<?php echo $id_proyecto; ?>" class="boton-agregarEditar">Mostrar Tabla</a>
        <div class="formulario-tarea">
            <h2 class="titulo">Nueva Nueva Tarea</h2>
            <form method="POST">
                <input type="hidden" class="input" name="id_tarea">
                <input type="hidden" class="input" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
                <label for="nombre_proyecto" class="label">Proyecto:</label>
                <?php if (!empty($nombreProyecto)) : ?>
                    <input type="text" class="input" name="nombre_proyecto" value="<?php echo $nombreProyecto; ?>" readonly>
                <?php endif; ?>
                <label for="nombre_tarea" class="label">Nombre de la Tarea:</label>
                <input type="text" class="input" name="nombre_tarea" required>
                <label for="descripcion_tarea" class="label">Descripción:</label>
                <textarea class="input" name="descripcion_tarea" rows="2" required></textarea>
                <label for="id_usuario" class="label">Asignada a:</label>
                <select name="id_usuario" class="input" required>
                    <option value="" disabled selected>Selecciona un desarrollador</option>
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
                <input type="date" class="input" name="fecha_vencimiento" required>
                <label for="estado_id" class="label">Estado:</label>
                <select name="estado_id" class="input" required>
                    <option value="" disabled selected>Selecciona un estado</option>
                    <?php
                    $sql = "SELECT id_estado, nombre_estado FROM estados_tarea WHERE nombre_estado != 'Finalizada'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $estadosTarea = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($estadosTarea as $estado) :
                    ?>
                        <option value="<?php echo $estado['id_estado']; ?>">
                            <?php echo $estado['nombre_estado']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="fecha_creacion" class="label">Fecha de Creación:</label>
                <input type="text" class="input" name="fecha_creacion" value="<?php echo date('Y-m-d'); ?>" readonly>
                <button type="submit" class="boton-agregarEditar" name="agregar_tarea">Agregar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>