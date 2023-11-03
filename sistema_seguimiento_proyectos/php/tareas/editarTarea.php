<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

function obtenerTareaYDatosRelacionados($pdo, $id_proyecto, $id_tarea)
{
    $stmt = $pdo->prepare("SELECT * FROM tareas WHERE id_proyecto = :id_proyecto AND id_tarea = :id_tarea");
    $stmt->bindParam(":id_proyecto", $id_proyecto, PDO::PARAM_INT);
    $stmt->bindParam(":id_tarea", $id_tarea, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerEstadosTarea($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM estados_tarea");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerUsuariosDesarrolladores($pdo)
{
    $stmt = $pdo->prepare("SELECT id_usuario, nombre_usuario FROM usuarios WHERE rol_id = (SELECT id_rol FROM roles WHERE nombre_rol = 'Desarrollador de sitios')");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['id_proyecto']) && isset($_GET['id_tarea'])) {
    $id_proyecto = $_GET['id_proyecto'];
    $id_tarea = $_GET['id_tarea'];
    $tarea = obtenerTareaYDatosRelacionados($pdo, $id_proyecto, $id_tarea);
    if (!$tarea) {
        header("Location: ../pages/tabla_tareas.php");
        exit;
    }
    $estados = obtenerEstadosTarea($pdo);
    $usuariosDesarrolladores = obtenerUsuariosDesarrolladores($pdo);
} else {
    header("Location: ../pages/tabla_tareas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Recuperar y validar datos de entrada
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion_tarea = $_POST['descripcion_tarea'];
    $estado_id = $_POST['estado_id'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $asignada_a = $_POST['asignada_a'];
    // Realizar la actualización de la tarea
    $sql = "UPDATE tareas SET nombre_tarea = :nombre_tarea, descripcion_tarea = :descripcion_tarea, estado_id = :estado_id, fecha_vencimiento = :fecha_vencimiento, asignada_a = :asignada_a WHERE id_proyecto = :id_proyecto AND id_tarea = :id_tarea";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre_tarea', $nombre_tarea, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion_tarea', $descripcion_tarea, PDO::PARAM_STR);
    $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
    $stmt->bindParam(':asignada_a', $asignada_a, PDO::PARAM_INT);
    $stmt->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
    $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header("Location: ../pages/tabla_tareas.php?id_proyecto=$id_proyecto");
        exit;
    } else {
        echo "Error al actualizar la tarea";
    }
}

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
