<?php
require_once('../php/conn.php');
$conexion = conectarBaseDeDatos();

function obtenerProyecto($conexion, $idProyecto)
{
    $sql = "SELECT * FROM proyectos WHERE id_proyecto=?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProyecto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        echo "ERROR: datos no autorizados";
        return null;
    }
}

function actualizarProyecto($conexion, $idProyecto, $nombreProyecto, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntregaEstimada, $estado)
{
    $sql = "UPDATE proyectos SET nombre_proyecto=?, descripcion=?, cliente=?, desarrollador=?, fecha_inicio=?, fecha_entrega_estimada=?, estado=? WHERE id_proyecto=?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $nombreProyecto, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntregaEstimada, $estado, $idProyecto);

    if (mysqli_stmt_execute($stmt)) {
        echo "Actualización exitosa.";
    } else {
        echo "ERROR: no se pudo ejecutar la actualización. " . mysqli_error($conexion);
    }
}

if (isset($_POST['update'])) {
    $idProyecto = $_POST['id_proyecto'];
    $nombreProyecto = $_POST['nombre_proyecto'];
    $descripcion = $_POST['descripcion'];
    $cliente = $_POST['cliente'];
    $desarrollador = $_POST['desarrollador'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaEntregaEstimada = $_POST['fecha_entrega_estimada'];
    $estado = $_POST['estado'];

    actualizarProyecto($conexion, $idProyecto, $nombreProyecto, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntregaEstimada, $estado);
    header('location: ../pages/proyectos.php');
}

if (isset($_GET['editar_proyecto'])) {
    $idProyecto = $_GET['editar_proyecto'];
    $update = true;
    $proyecto = obtenerProyecto($conexion, $idProyecto);

    if ($proyecto) {
        $idProyecto = $proyecto['id_proyecto'];
        $nombreProyecto = $proyecto['nombre_proyecto'];
        $descripcion = $proyecto['descripcion'];
        $cliente = $proyecto['cliente'];
        $desarrollador = $proyecto['desarrollador'];
        $fechaInicio = $proyecto['fecha_inicio'];
        $fechaEntregaEstimada = $proyecto['fecha_entrega_estimada'];
        $estado = $proyecto['estado'];
    }
}
