<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/tareas/_tareas.php');
require_once('../php/tareas/tablaTareas.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Tareas | Maitco</title>
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
                <li><a href="../php/logout.php">Cerrar Sesión</a></li>
            </ul>
            <div class="icono-usuario">
                <img src="../assets/svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="nombre-usuario">
                <?php echo isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <h1 class="titulo">Mis Tareas</h1>
        <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios') : ?>
            <a href="../pages/agregar_tarea.php?id_proyecto=<?php echo $idProyecto; ?>" class="boton-agregarEditar">Agregar Nueva Tarea</a>
        <?php endif; ?>
        <table id="tablaProyectosTareas" class="tabla-tareas">
            <thead>
                <tr>
                    <th>ID Tarea</th>
                    <th>Nombre Tarea</th>
                    <th>Descripción</th>
                    <th>Proyecto</th>
                    <th>Asignada a</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                    <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios') : ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea) : ?>
                    <tr data-id="<?php echo $tarea["id_tarea"]; ?>" <?php if ($tarea['estado_id'] == 4) { ?> style="display:none;" <?php } ?>>
                        <td><?php echo $tarea["id_tarea"]; ?></td>
                        <td><?php echo $tarea["nombre_tarea"]; ?></td>
                        <td><?php echo $tarea["descripcion_tarea"]; ?></td>
                        <td><?php echo $nombreProyecto; ?></td>
                        <td><?php echo $nombreUsuario; ?></td>
                        <td><?php echo $tarea["fecha_vencimiento"]; ?></td>
                        <td>
                            <?php
                            $sql = "SELECT nombre_estado FROM estados_tarea WHERE id_estado = :estado_id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindValue(":estado_id", $tarea['estado_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $estadoTarea = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $estadoTarea['nombre_estado'];
                            ?>
                        </td>
                        <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios' && $tarea['estado_id'] != 4) : ?>
                            <td>
                                <input type="hidden" id="estado_<?php echo $tarea["id_tarea"]; ?>" value="<?php echo $tarea["estado_id"]; ?>">
                                <a href="../pages/editar_tarea.php?id_proyecto=<?php echo $idProyecto; ?>&id_tarea=<?php echo $tarea["id_tarea"]; ?>" class="boton-editar"></a>
                                <button class="boton-finalizar-tarea" data-id="<?php echo $tarea["id_tarea"]; ?>" data-action="finalizar" data-url="../php/tareas/tablaTareas.php">
                                    <img src="../assets/svg/finalizar.svg" alt="Finalizar">
                                </button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>