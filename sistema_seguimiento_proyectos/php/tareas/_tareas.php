<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

function contarTareasPorEstado($proyectoId, $estado)
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM tareas WHERE id_proyecto = :proyectoId AND estado_id = (SELECT id_estado FROM estados_tarea WHERE nombre_estado = :estado)");
        $stmt->bindParam(":proyectoId", $proyectoId, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    } catch (PDOException $e) {
        throw new Exception("Error al contar tareas: " . $e->getMessage());
    }
}

function obtenerListaDeProyectos()
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM proyectos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error al obtener la lista de proyectos: " . $e->getMessage());
    }
}

$pdo = conectarBaseDeDatos();
$proyectos = obtenerListaDeProyectos();
