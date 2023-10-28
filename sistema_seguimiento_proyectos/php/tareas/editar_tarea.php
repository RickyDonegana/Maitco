<?php
require_once('../php/conn.php');
require_once('../php/usuario.php');
$pdo = conectarBaseDeDatos();

// Verifica si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editar_tarea"])) {
    $idTarea = $_POST["id_tarea"];
    $nombreTarea = $_POST["nombre_tarea"];
    $descripcionTarea = $_POST["descripcion_tarea"];
    $fechaVencimiento = $_POST["fecha_vencimiento"];
    $estadoId = $_POST["estado_id"];

    // Realiza la actualización en la base de datos (ajusta esta consulta según tu estructura)
    $stmt = $pdo->prepare("UPDATE tareas SET nombre_tarea = :nombre_tarea, descripcion_tarea = :descripcion_tarea, fecha_vencimiento = :fecha_vencimiento, estado_id = :estado_id WHERE id_tarea = :id_tarea");
    $stmt->bindParam(":nombre_tarea", $nombreTarea, PDO::PARAM_STR);
    $stmt->bindParam(":descripcion_tarea", $descripcionTarea, PDO::PARAM_STR);
    $stmt->bindParam(":fecha_vencimiento", $fechaVencimiento, PDO::PARAM_STR);
    $stmt->bindParam(":estado_id", $estadoId, PDO::PARAM_INT);
    $stmt->bindParam(":id_tarea", $idTarea, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirecciona a la página de tareas o muestra un mensaje de éxito
        header("Location: ../pages/tareas.php");
        exit;
    } else {
        // Manejo de error si la actualización falla
        echo "Error al actualizar la tarea.";
    }
}

// Obtener datos de la tarea a editar (puedes cargar los datos de la base de datos)
$idTarea = $_GET['id_tarea']; // Obtén el ID de la tarea a editar

// Realiza una consulta para obtener los detalles de la tarea según su ID y llena las variables con los datos

// Ejemplo de consulta SQL (ajusta según tu estructura):
$stmt = $pdo->prepare("SELECT nombre_tarea, descripcion_tarea, fecha_vencimiento, estado_id FROM tareas WHERE id_tarea = :id_tarea");
$stmt->bindParam(":id_tarea", $idTarea, PDO::PARAM_INT);
$stmt->execute();
$tarea = $stmt->fetch(PDO::FETCH_ASSOC);

// Asegúrate de realizar la consulta y cargar los datos correctamente desde la base de datos
if (!$tarea) {
    // Manejo de error si la tarea no se encuentra en la base de datos
    echo "Tarea no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea | Maitco</title>
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
        <h1 class="titulo">Editar Tarea</h1>
        <a href="../pages/tareas.php" class="boton-agregarEditar">Volver a Tareas</a>
        <div id="editarTareaForm" class="formulario-tarea">
            <h2 class="titulo">Editar Tarea</h2>
            <form method="POST">
                <input type="hidden" class="input" id="id_tarea" name="id_tarea" value="<?php echo $idTarea; ?>">
                <label for="nombre_tarea" class="label">Nombre de la Tarea:</label>
                <input type="text" class="input" id="nombre_tarea" name="nombre_tarea" required value="<?php echo $tarea['nombre_tarea']; ?>">
                <label for="descripcion_tarea" class="label">Descripción:</label>
                <textarea class="input" id="descripcion_tarea" name="descripcion_tarea" rows="2" required><?php echo $tarea['descripcion_tarea']; ?></textarea>
                <label for="fecha_vencimiento" class="label">Fecha de Vencimiento:</label>
                <input type="date" class="input" id="fecha_vencimiento" name="fecha_vencimiento" required value="<?php echo $tarea['fecha_vencimiento']; ?>">
                <label for="estado_id" class="label">Estado:</label>
                <select name="estado_id" class="select" id="estado_id" required>
                    <?php
                    // Obtén los estados de tareas desde la base de datos (ajusta la consulta)
                    $stmt = $pdo->prepare("SELECT id_estado, nombre_estado FROM estados_tarea WHERE nombre_estado != 'Finalizada'");
                    $stmt->execute();
                    $estadosTarea = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($estadosTarea as $estado) :
                        $selected = ($estado['id_estado'] == $tarea['estado_id']) ? "selected" : "";
                    ?>
                        <option value="<?php echo $estado['id_estado']; ?>" <?php echo $selected; ?>>
                            <?php echo $estado['nombre_estado']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="boton-agregarEditar" id="btnEditarTarea" name="editar_tarea">Editar Tarea</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
