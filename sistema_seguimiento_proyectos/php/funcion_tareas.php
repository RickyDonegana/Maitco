<?php
require_once('../php/conn.php');

// Función para contar tareas por estado en un proyecto específico
function contarTareasPorEstado($proyectoId, $estado)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM tareas WHERE id_proyecto = :proyectoId AND estado_id = (SELECT id_estado FROM estados_tarea WHERE nombre_estado = :estado)");
    $stmt->bindParam(":proyectoId", $proyectoId, PDO::PARAM_INT);
    $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Obtener la lista de proyectos
$pdo = conectarBaseDeDatos();
$stmt = $pdo->prepare("SELECT * FROM proyectos");
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
