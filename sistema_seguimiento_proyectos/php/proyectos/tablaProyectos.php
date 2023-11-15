<?php

function finalizarProyecto($pdo, $id)
{
    try {
        error_log("Entrando en finalizarProyecto");
        $sql = "UPDATE proyectos SET estado = 'Finalizado' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        error_log("Proyecto finalizado con éxito");
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        error_log("Error al finalizar el proyecto: " . $e->getMessage());
        echo json_encode(["error" => "Error al finalizar el proyecto: " . $e->getMessage()]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Entrando en post");
    if (isset($_POST["id_proyecto"]) && isset($_POST["action"]) && $_POST["action"] === "finalizar") {
        require_once('../conn.php');
        $pdo = conectarBaseDeDatos();
        $idProyecto = $_POST["id_proyecto"];
        finalizarProyecto($pdo, $idProyecto);
    } else {
        echo json_encode(["error" => "Acción no válida"]);
    }
} else {
    require_once('../php/conn.php');
    $pdo = conectarBaseDeDatos();
    $proyectos = [];
    try {
        $stmt = $pdo->prepare("SELECT * FROM proyectos");
        $stmt->execute();
        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error al consultar proyectos: " . $e->getMessage());
    }
}
