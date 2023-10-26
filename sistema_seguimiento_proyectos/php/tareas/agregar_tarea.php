<?php
include('../php/conn.php');
include('../php/tareas/funcion_tablaTareas.php');

$nombreProyecto = "";

function agregarTarea($nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $proyectoId)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "INSERT INTO tareas (id_proyecto, nombre_tarea, descripcion_tarea, estado_id, fecha_vencimiento, asignada_a, fecha_creacion) VALUES (:proyecto_id, :nombre_tarea, :descripcion_tarea, :estado_id, :fecha_vencimiento, :asignada_a, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":proyecto_id", $proyectoId, PDO::PARAM_INT);
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
    if (isset($_POST["nombre_tarea"]) && isset($_POST["descripcion_tarea"]) && isset($_POST["id_usuario"]) && isset($_POST["fecha_vencimiento"]) && isset($_POST["estado_id"])) {
        $nombreTarea = $_POST["nombre_tarea"];
        $descripcionTarea = $_POST["descripcion_tarea"];
        $idUsuario = $_POST["id_usuario"];
        $fechaVencimiento = $_POST["fecha_vencimiento"];
        $estadoId = $_POST["estado_id"];
        $proyectoId = $_GET['proyecto_id'];
        agregarTarea($nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $proyectoId);
        header("Location: ../pages/tabla_tareas.php?proyecto_id=$proyectoId");
        exit;
    }
}
