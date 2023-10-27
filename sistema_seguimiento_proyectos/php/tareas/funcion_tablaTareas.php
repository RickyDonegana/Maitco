<?php
include('../php/conn.php');

// Función para finalizar una tarea
function finalizarTarea($id)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE tareas SET estado_id = 4 WHERE id_tarea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        echo json_encode(["exito" => false, "mensaje" => "Error al finalizar la tarea: " . $e->getMessage()]);
    }
}

// Función para cambiar el estado de una tarea
function cambiarEstadoTarea($idTarea, $nuevoEstado)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE tareas SET estado_id = :nuevoEstado WHERE id_tarea = :idTarea";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nuevoEstado", $nuevoEstado, PDO::PARAM_INT);
        $stmt->bindParam(":idTarea", $idTarea, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        echo json_encode(["exito" => false, "mensaje" => "Error al cambiar el estado de la tarea: " . $e->getMessage()]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nuevo_estado"]) && isset($_POST["id_tarea"])) {
        $idTarea = $_POST["id_tarea"];
        $nuevoEstado = $_POST["nuevo_estado"];
        cambiarEstadoTarea($idTarea, $nuevoEstado);
    }
    if (isset($_POST["finalizar_tarea"])) {
        $idTarea = $_POST["id_tarea"];
        finalizarTarea($idTarea);
    }
    exit;
}

if (isset($_GET['id_proyecto'])) {
    $idProyecto = $_GET['id_proyecto'];

    $stmt = $pdo->prepare("SELECT t.*, p.nombre_proyecto FROM tareas t JOIN proyectos p ON t.id_proyecto = p.id_proyecto WHERE t.id_proyecto = :id_proyecto");
    $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Manejar el caso en el que no se ha seleccionado un proyecto
}


// Consultar tareas existentes
$pdo = conectarBaseDeDatos();
$stmt = $pdo->prepare("SELECT * FROM tareas");
$stmt->execute();
$tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
