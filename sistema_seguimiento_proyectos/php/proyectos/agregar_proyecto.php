<?php
include('../php/conn.php');

// Función para agregar un nuevo proyecto
function agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "INSERT INTO proyectos (nombre_proyecto, descripcion, cliente, desarrollador, fecha_inicio, fecha_entrega_estimada, estado) VALUES (:nombre, :descripcion, :cliente, :desarrollador, :fechaInicio, :fechaEntrega, :estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al agregar el proyecto: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["agregar_proyecto"])) {
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
        header("Location: ../pages/proyectos.php");
        exit;
    }
}
