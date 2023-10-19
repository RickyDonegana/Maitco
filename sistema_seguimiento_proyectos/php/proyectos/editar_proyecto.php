<?php
include('../php/conn.php');

// Función para editar un proyecto existente
function editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE proyectos SET nombre_proyecto = :nombre, descripcion = :descripcion, cliente = :cliente, desarrollador = :desarrollador, fecha_inicio = :fechaInicio, fecha_entrega_estimada = :fechaEntrega, estado = :estado WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al editar el proyecto: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["editar_proyecto"])) {
        $id = $_POST["id_proyecto"];
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
    }
}
