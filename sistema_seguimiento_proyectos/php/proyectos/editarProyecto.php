<?php
require_once('../php/conn.php');
require_once('../php/proyectos/tablaProyectos.php');
$pdo = conectarBaseDeDatos();

// Verificar si se ha enviado un ID de proyecto
if (isset($_GET['id'])) {
    $proyecto_id = $_GET['id'];
    $query = "SELECT * FROM proyectos WHERE id_proyecto = :proyecto_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':proyecto_id', $proyecto_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: ../pages/proyectos.php");
        exit;
    }
} else {
    header("Location: ../pages/proyectos.php");
    exit;
}

// Procesar los datos del formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $descripcion = $_POST['descripcion'];
    $cliente = $_POST['cliente'];
    $desarrollador = $_POST['desarrollador'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_entrega_estimada = $_POST['fecha_entrega_estimada'];
    $estado = $_POST['estado'];
    $sql = "UPDATE proyectos SET nombre_proyecto = :nombre_proyecto, descripcion = :descripcion, cliente = :cliente, desarrollador = :desarrollador, fecha_inicio = :fecha_inicio, fecha_entrega_estimada = :fecha_entrega_estimada, estado = :estado WHERE id_proyecto = :proyecto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre_proyecto', $nombre_proyecto, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':cliente', $cliente, PDO::PARAM_STR);
    $stmt->bindParam(':desarrollador', $desarrollador, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_entrega_estimada', $fecha_entrega_estimada);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':proyecto_id', $proyecto_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header("Location: ../pages/proyectos.php");
        exit;
    } else {
        echo "Error al actualizar el proyecto";
    }
}
