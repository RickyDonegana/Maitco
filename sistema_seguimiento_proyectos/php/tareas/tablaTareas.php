<?php

function finalizarTarea($pdo, $id)
{
    try {
        $sql = "UPDATE tareas SET estado_id = 4 WHERE id_tarea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        error_log("Tarea finalizada con éxito");
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        error_log("Error al finalizar la tarea: " . $e->getMessage());
        echo json_encode(["error" => "Error al finalizar la tarea: " . $e->getMessage()]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    error_log("Entrando en post");
    if (isset($_POST["id_tarea"]) && isset($_POST["action"]) && $_POST["action"] === "finalizar") {
        require_once('../conn.php');
        $pdo = conectarBaseDeDatos();
        $idTarea = $_POST["id_tarea"];
        finalizarTarea($pdo, $idTarea);
    } else {
        echo json_encode(["error" => "Acción no válida"]);
    }
} else {
    require_once('../php/conn.php');
    $pdo = conectarBaseDeDatos();
    $tareas = [];
    try {
        $stmt = $pdo->prepare("SELECT t.*, p.nombre_proyecto FROM tareas t JOIN proyectos p ON t.id_proyecto = p.id_proyecto");
        $stmt->execute();
        $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error al consultar la tarea: " . $e->getMessage());
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
