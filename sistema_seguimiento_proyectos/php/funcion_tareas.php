<?php
// Incluir los archivos necesarios
require_once('../php/conn.php');

// Obtener el estado de las tareas y contarlas
$tareasRojo = 0;
$tareasAmarillo = 0;
$tareasVerde = 0;

foreach ($tareas as $tarea) {
    $estado = $tarea["estado_id"];
    if ($estado === 'rojo') {
        $tareasRojo++;
    } elseif ($estado === 'amarillo') {
        $tareasAmarillo++;
    } elseif ($estado === 'verde') {
        $tareasVerde++;
    }
}
