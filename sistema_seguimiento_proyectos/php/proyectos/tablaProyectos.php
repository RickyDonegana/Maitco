<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

/**
 * Finalizar un proyecto.
 *
 * @param int $id ID del proyecto a finalizar.
 */
function finalizarProyecto($pdo, $id)
{
    try {
        $sql = "UPDATE proyectos SET estado = 'finalizado' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error al finalizar el proyecto: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["finalizar_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        echo json_encode(["confirmacion" => true, "id_proyecto" => $idProyecto]);
        exit;
    } elseif (isset($_POST["confirmar_finalizar_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        finalizarProyecto($pdo, $idProyecto);
        echo json_encode(["exito" => true]);
        exit;
    }
}

// Consultar proyectos existentes
$proyectos = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM proyectos");
    $stmt->execute();
    $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    throw new Exception("Error al consultar proyectos: " . $e->getMessage());
}
