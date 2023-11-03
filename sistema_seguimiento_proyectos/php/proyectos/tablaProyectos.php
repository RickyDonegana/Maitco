<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

function finalizarProyecto($pdo, $id)
{
    try {
        $sql = "UPDATE proyectos SET estado = 'Finalizado' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al finalizar el proyecto: " . $e->getMessage()]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id_proyecto"]) && isset($_POST["accion"]) && $_POST["accion"] === "finalizar") {
        $idProyecto = $_POST["id_proyecto"];
        finalizarProyecto($pdo, $idProyecto);
    } else {
        echo json_encode(["error" => "Acción no válida"]);
    }
}

$proyectos = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM proyectos");
    $stmt->execute();
    $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    throw new Exception("Error al consultar proyectos: " . $e->getMessage());
}
