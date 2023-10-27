<?php
include('../php/conn.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nombre_tarea"]) && isset($_POST["descripcion_tarea"]) && isset($_POST["id_usuario"]) && isset($_POST["fecha_vencimiento"]) && isset($_POST["estado_id"]) && isset($_POST["id_proyecto"])) {
        $nombreTarea = $_POST["nombre_tarea"];
        $descripcionTarea = $_POST["descripcion_tarea"];
        $idUsuario = $_POST["id_usuario"];
        $fechaVencimiento = $_POST["fecha_vencimiento"];
        $estadoId = $_POST["estado_id"];
        $idProyecto = $_POST["id_proyecto"];
        $carpetaProyecto = "../proyectos/proyecto_" . $idProyecto; // Ruta a la carpeta del proyecto
        agregarTarea($nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $idProyecto, $carpetaProyecto);
        header("Location: ../pages/tabla_tareas.php?id_proyecto=$idProyecto");
        exit;
    }
}

// ...

function agregarTarea($nombreTarea, $descripcionTarea, $idUsuario, $fechaVencimiento, $estadoId, $idProyecto, $carpetaProyecto)
{
    $pdo = conectarBaseDeDatos();
    try {
        // Guardar la tarea en la carpeta del proyecto
        $rutaTarea = $carpetaProyecto . "/tarea_" . uniqid(); // Nombre de archivo único
        file_put_contents($rutaTarea, $nombreTarea . "\n" . $descripcionTarea);
        // Continuar con la inserción en la base de datos
        $sql = "INSERT INTO tareas (id_proyecto, nombre_tarea, descripcion_tarea, estado_id, fecha_vencimiento, asignada_a, fecha_creacion, ruta_tarea) VALUES (:id_proyecto, :nombre_tarea, :descripcion_tarea, :estado_id, :fecha_vencimiento, :asignada_a, NOW(), :ruta_tarea)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_tarea", $nombreTarea, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_tarea", $descripcionTarea, PDO::PARAM_STR);
        $stmt->bindParam(":estado_id", $estadoId, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_vencimiento", $fechaVencimiento, PDO::PARAM_STR);
        $stmt->bindParam(":asignada_a", $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":ruta_tarea", $rutaTarea, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al agregar la tarea: " . $e->getMessage();
    }
}
?>
