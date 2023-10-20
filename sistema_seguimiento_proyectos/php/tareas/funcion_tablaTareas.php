<?php
include('../php/conn.php');

// Función para finalizar una tarea
function finalizarTarea($id)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE tareas SET estado_id = 3 WHERE id_tarea = :id"; // Suponiendo que 3 es el ID del estado "Completada"
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al finalizar la tarea: " . $e->getMessage();
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
        echo json_encode(["confirmacion" => true, "id_tarea" => $idTarea]);
        exit;
    } elseif (isset($_POST["confirmar_finalizar_tarea"])) {
        $idTarea = $_POST["id_tarea"];
        finalizarTarea($idTarea);
        echo json_encode(["exito" => true]);
        exit;
    }
}

// Consultar tareas existentes
$pdo = conectarBaseDeDatos();
$stmt = $pdo->prepare("SELECT * FROM tareas");
$stmt->execute();
$tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
