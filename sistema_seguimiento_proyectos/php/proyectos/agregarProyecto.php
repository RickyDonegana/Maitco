<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

/**
 * Agregar un nuevo proyecto.
 *
 * @param PDO $pdo Conexión a la base de datos.
 * @param string $nombre Nombre del proyecto.
 * @param string $descripcion Descripción del proyecto.
 * @param string $cliente Cliente del proyecto.
 * @param string $desarrollador Desarrollador del proyecto.
 * @param string $fechaInicio Fecha de inicio del proyecto.
 * @param string $fechaEntrega Fecha estimada de entrega del proyecto.
 * @param int $estado Estado del proyecto.
 */
function agregarProyecto($pdo, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
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
        throw new Exception("Error al agregar el proyecto: " . $e->getMessage());
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
        agregarProyecto($pdo, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
        header("Location: ../pages/proyectos.php");
        exit;
    }
}
