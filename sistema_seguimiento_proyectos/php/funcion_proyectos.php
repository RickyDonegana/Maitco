<?php
include('../php/conn.php');

function finalizarProyecto($id)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE proyectos SET estado = (SELECT id_estado FROM estados_proyectos WHERE nombre_estado = 'Finalizado') WHERE id_proyecto = :id";
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
        $sql = "UPDATE proyectos SET estado = (SELECT id_estado FROM estados_proyectos WHERE nombre_estado = :nuevoEstado) WHERE id_proyecto = :idProyecto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->bindParam(":nuevoEstado", $nuevoEstado, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar el estado del proyecto: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id_proyecto"]) && isset($_POST["nuevo_estado"])) {
        $idProyecto = $_POST["id_proyecto"];
        $nuevoEstado = $_POST["nuevo_estado"];
        cambiarEstadoProyecto($idProyecto, $nuevoEstado);
        echo json_encode(["exito" => true]);
        exit;
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
