<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/tareas/editarTarea.php');
$pdo = conectarBaseDeDatos();

if (isset($_GET['id_proyecto'])) {
    $id_proyecto = $_GET['id_proyecto'];
    $stmt = $pdo->prepare("SELECT nombre_proyecto FROM proyectos WHERE id_proyecto = :id_proyecto");
    $stmt->bindParam(":id_proyecto", $id_proyecto, PDO::PARAM_INT);
    $stmt->execute();
    $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($proyecto) {
        $nombreProyecto = $proyecto['nombre_proyecto'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea | Maitco</title>
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
        <a href="../pages/tabla_tareas.php?id_proyecto=<?php echo $id_proyecto; ?>" class="boton-agregarEditar" id="btnAgregarTarea">Mostrar Tabla</a>
        <div class="formulario-tarea">
            <h2 class="titulo">Editar Tarea</h2>
            <form method="POST">
                <input type="hidden" class="input" id="id_tarea_form" name="id_tarea">
                <label for="nombre_proyecto" class="label">Proyecto:</label>
                <input type="text" class="input" id="nombre_proyecto" name="nombre_proyecto" value="<?php echo $nombreProyecto; ?>" readonly>
                <input type="hidden" class="input" id="id_proyecto" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
                <label for="nombre_tarea" class="label">Nombre de la Tarea:</label>
                <input type="text" class="input" id="nombre_tarea" name="nombre_tarea" value="<?php echo $tarea['nombre_tarea']; ?>" required>
                <label for="descripcion_tarea" class="label">Descripción:</label>
                <textarea class="input" id="descripcion_tarea" name="descripcion_tarea" rows="2" required><?php echo $tarea['descripcion_tarea']; ?></textarea>
                <label for="asignada_a" class="label">Asignada a:</label>
                <select name="asignada_a" class="input" id="asignada_a" required>
                    <?php
                    foreach ($usuariosDesarrolladores as $usuario) {
                        $selected = ($usuario['id_usuario'] == $tarea['asignada_a']) ? 'selected' : '';
                        echo "<option value='{$usuario['id_usuario']}' $selected>{$usuario['nombre_usuario']}</option>";
                    }
                    ?>
                </select>
                <label for="fecha_vencimiento" class="label">Fecha de Vencimiento:</label>
                <input type="date" class="input" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $tarea['fecha_vencimiento']; ?>" required>
                <label for="estado_id" class="label">Estado:</label>
                <select name="estado_id" class="input" id="estado_id" required>
                    <?php
                    foreach ($estados as $estado) {
                        $selected = ($estado['id_estado'] == $tarea['estado_id']) ? 'selected' : '';
                        echo "<option value='{$estado['id_estado']}' $selected>{$estado['nombre_estado']}</option>";
                    }
                    ?>
                </select>
                <label for="fecha_creacion" class="label">Fecha de Creación:</label>
                <input type="text" class="input" id="fecha_creacion" name="fecha_creacion" value="<?php echo $tarea['fecha_creacion']; ?>" readonly>
                <button type="submit" class="boton-agregarEditar" name="update">Editar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>