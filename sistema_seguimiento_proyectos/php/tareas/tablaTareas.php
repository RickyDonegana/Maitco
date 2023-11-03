<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

function finalizarTarea($pdo, $id)
{
    try {
        $sql = "UPDATE tareas SET estado_id = 4 WHERE id_tarea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al finalizar la tarea: " . $e->getMessage()]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id_tarea"]) && isset($_POST["accion"]) && $_POST["accion"] === "finalizar") {
        $idTarea = $_POST["id_tarea"];
        finalizarTarea($pdo, $idTarea);
    } else {
        echo json_encode(["error" => "Acción no válida"]);
    }
}

if (isset($_GET['id_proyecto'])) {
    $idProyecto = $_GET['id_proyecto'];
    $stmt = $pdo->prepare("SELECT t.*, p.nombre_proyecto FROM tareas t JOIN proyectos p ON t.id_proyecto = p.id_proyecto WHERE t.id_proyecto = :id_proyecto");
    $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT nombre_proyecto FROM proyectos WHERE id_proyecto = :id_proyecto");
    $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
    $stmt->execute();
    $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($proyecto) {
        $nombreProyecto = $proyecto['nombre_proyecto'];
    }
}
