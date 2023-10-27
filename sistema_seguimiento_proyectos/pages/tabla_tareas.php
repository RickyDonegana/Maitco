<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
require_once('../php/funcion_tareas.php');
require_once('../php/tareas/funcion_tablaTareas.php');
$pdo = conectarBaseDeDatos();

if (isset($_GET['id_proyecto'])) {
    $idProyecto = $_GET['id_proyecto'];

    $stmt = $pdo->prepare("SELECT t.*, p.nombre_proyecto FROM tareas t JOIN proyectos p ON t.id_proyecto = p.id_proyecto WHERE t.id_proyecto = :id_proyecto");
    $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Manejar el caso en el que no se ha seleccionado un proyecto
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Tareas | Maitco</title>
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
        <h1 class="titulo">Mis Tareas</h1>
        <a href="../pages/agregar_tarea.php?id_proyecto=<?php echo $idProyecto; ?>" class="boton-agregarEditar">Agregar Nueva Tarea</a>
        <table id="tablaTareas" class="tabla-tareas">
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
                        <td><?php echo $nombreProyecto; ?></td>
                        <td><?php echo $nombreUsuario; ?></td>
                        <td><?php echo $tarea["fecha_vencimiento"]; ?></td>
                        <td>
                            <form method="POST" class="select-container">
                                <input type="hidden" name="id_tarea" value="<?php echo $tarea["id_tarea"]; ?>">
                                <select name="estado_id" class="select" required onchange="cambiarEstadoTarea(this);">
                                    <?php
                                    $sql = "SELECT id_estado, nombre_estado FROM estados_tarea WHERE nombre_estado != 'Finalizada'";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $estadosTarea = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($estadosTarea as $estado) :
                                    ?>
                                        <option value="<?php echo $estado['id_estado']; ?>" <?php echo ($tarea['estado_id'] == $estado['id_estado']) ? 'selected' : ''; ?>>
                                            <?php echo $estado['nombre_estado']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                        <td>
                            <input type="hidden" id="estado_<?php echo $tarea["id_tarea"]; ?>" value="<?php echo $tarea["estado_id"]; ?>">
                            <a href="../pages/editar_tarea.php" data-action="editar" data-id="<?php echo $tarea["id_tarea"]; ?>" class="boton-editar"></a>
                            <button data-action="finalizar" data-id="<?php echo $tarea["id_tarea"]; ?>" class="boton-finalizar">
                                <img src="../svg/finalizar.svg" alt="Finalizar">
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>