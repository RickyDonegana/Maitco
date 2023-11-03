<?php
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();

/**
 * Cuenta tareas por estado en un proyecto específico.
 *
 * @param int $proyectoId ID del proyecto.
 * @param string $estado Estado de la tarea.
 * @return int Cantidad de tareas en ese estado.
 */
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

/**
 * Obtener la lista de proyectos.
 *
 * @return array Lista de proyectos.
 */
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

// Obtener la lista de proyectos
$pdo = conectarBaseDeDatos();
$proyectos = obtenerListaDeProyectos();
