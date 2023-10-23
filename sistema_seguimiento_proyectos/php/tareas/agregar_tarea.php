<?php
include('../php/conn.php');

// Función para agregar una nueva tarea
function agregarTarea($idProyecto, $nombreTarea, $descripcionTarea, $estadoId, $fechaVencimiento, $asignadaA)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "INSERT INTO tareas (id_proyecto, nombre_tarea, descripcion_tarea, estado_id, fecha_vencimiento, asignada_a) VALUES (:idProyecto, :nombreTarea, :descripcionTarea, :estadoId, :fechaVencimiento, :asignadaA)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->bindParam(":nombreTarea", $nombreTarea, PDO::PARAM_STR);
        $stmt->bindParam(":descripcionTarea", $descripcionTarea, PDO::PARAM_STR);
        $stmt->bindParam(":estadoId", $estadoId, PDO::PARAM_INT);
        $stmt->bindParam(":fechaVencimiento", $fechaVencimiento, PDO::PARAM_STR);
        $stmt->bindParam(":asignadaA", $asignadaA, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al agregar la tarea: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["agregar_tarea"])) {
        $idProyecto = $_POST["id_proyecto"];
        $nombreTarea = $_POST["nombre_tarea"];
        $descripcionTarea = $_POST["descripcion_tarea"];
        $estadoId = $_POST["estado_id"];
        $fechaVencimiento = $_POST["fecha_vencimiento"];
        $asignadaA = $_POST["asignada_a"];
        agregarTarea($idProyecto, $nombreTarea, $descripcionTarea, $estadoId, $fechaVencimiento, $asignadaA);
        header("Location: ../pages/tabla_tareas.php");
        exit;
    }
}
