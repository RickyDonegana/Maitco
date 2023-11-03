<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

function agregarTarea($pdo, $nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $idProyecto)
{
    try {
        $sql = "INSERT INTO tareas (id_proyecto, nombre_tarea, descripcion_tarea, estado_id, fecha_vencimiento, asignada_a, fecha_creacion) VALUES (:id_proyecto, :nombre_tarea, :descripcion_tarea, :estado_id, :fecha_vencimiento, :asignada_a, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_tarea", $nombreTarea, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_tarea", $descripcionTarea, PDO::PARAM_STR);
        $stmt->bindParam(":estado_id", $estadoId, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_vencimiento", $fechaVencimiento, PDO::PARAM_STR);
        $stmt->bindParam(":asignada_a", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al agregar la tarea: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nombre_tarea"], $_POST["descripcion_tarea"], $_POST["id_usuario"], $_POST["fecha_vencimiento"], $_POST["estado_id"], $_POST["id_proyecto"])) {
        $nombreTarea = $_POST["nombre_tarea"];
        $descripcionTarea = $_POST["descripcion_tarea"];
        $idUsuario = $_POST["id_usuario"];
        $fechaVencimiento = $_POST["fecha_vencimiento"];
        $estadoId = $_POST["estado_id"];
        $idProyecto = $_POST["id_proyecto"];
        agregarTarea($pdo, $nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $idProyecto);
        header("Location: ../pages/tabla_tareas.php?id_proyecto=$idProyecto");
        exit;
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
