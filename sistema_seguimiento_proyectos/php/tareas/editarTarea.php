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
