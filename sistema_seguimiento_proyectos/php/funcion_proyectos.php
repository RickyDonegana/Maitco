<?php
include('../php/conn.php');
function finalizarProyecto($id)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE proyectos SET estado = 'Finalizado' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al finalizar el proyecto: " . $e->getMessage();
    }
}
function cambiarEstadoProyecto($idProyecto, $nuevoEstado)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE proyectos SET estado = :nuevoEstado WHERE id_proyecto = :idProyecto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nuevoEstado", $nuevoEstado, PDO::PARAM_STR);
        $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        echo json_encode(["exito" => false, "mensaje" => "Error al cambiar el estado del proyecto: " . $e->getMessage()]);
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nuevo_estado"]) && isset($_POST["id_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        $nuevoEstado = $_POST["nuevo_estado"];
        cambiarEstadoProyecto($idProyecto, $nuevoEstado);
    }
    if (isset($_POST["finalizar_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        echo json_encode(["confirmacion" => true, "id_proyecto" => $idProyecto]);
        exit;
    } elseif (isset($_POST["confirmar_finalizar_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        finalizarProyecto($idProyecto);
        echo json_encode(["exito" => true]);
        exit;
    }
}
$pdo = conectarBaseDeDatos();
$stmt = $pdo->prepare("SELECT * FROM proyectos");
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
