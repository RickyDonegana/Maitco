<?php

include('../php/conn.php');

// Función para agregar un nuevo proyecto
function agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    global $pdo; // Reemplaza $pdo por tu objeto PDO configurado previamente

    try {
        $sql = "INSERT INTO proyectos (nombre_proyecto, descripcion, cliente, desarrollador, fecha_inicio, fecha_entrega_estimada, estado) VALUES (:nombre, :descripcion, :cliente, :desarrollador, :fechaInicio, :fechaEntrega, :estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->execute();
        // Puedes manejar cualquier excepción aquí si es necesario
    } catch (PDOException $e) {
        // Manejar el error, por ejemplo, registrar el error en un archivo o mostrar un mensaje de error al usuario
        echo "Error al agregar el proyecto: " . $e->getMessage();
    }
}

// Función para editar un proyecto existente
function editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    global $pdo; // Reemplaza $pdo por tu objeto PDO configurado previamente

    try {
        $sql = "UPDATE proyectos SET nombre_proyecto = :nombre, descripcion = :descripcion, cliente = :cliente, desarrollador = :desarrollador, fecha_inicio = :fechaInicio, fecha_entrega_estimada = :fechaEntrega, estado = :estado WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        // Puedes manejar cualquier excepción aquí si es necesario
    } catch (PDOException $e) {
        // Manejar el error, por ejemplo, registrar el error en un archivo o mostrar un mensaje de error al usuario
        echo "Error al editar el proyecto: " . $e->getMessage();
    }
}

// Función para finalizar un proyecto (actualiza el estado en la base de datos)
function finalizarProyecto($id)
{
    global $pdo; // Reemplaza $pdo por tu objeto PDO configurado previamente

    try {
        $sql = "UPDATE proyectos SET estado = 'cierre' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige nuevamente a la página de proyectos después de la actualización
        header("Location: ../pages/proyectos.php");
    } catch (PDOException $e) {
        // Manejar el error, por ejemplo, registrar el error en un archivo o mostrar un mensaje de error al usuario
        echo "Error al finalizar el proyecto: " . $e->getMessage();
    }
}

// Función para cambiar el estado de un proyecto
function cambiarEstadoProyecto($idProyecto, $nuevoEstado)
{
    global $pdo; // Reemplaza $pdo por tu objeto PDO configurado previamente

    try {
        $sql = "UPDATE proyectos SET estado = :nuevoEstado WHERE id_proyecto = :idProyecto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nuevoEstado", $nuevoEstado, PDO::PARAM_STR);
        $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Manejar el error, por ejemplo, registrar el error en un archivo o mostrar un mensaje de error al usuario
        echo "Error al cambiar el estado del proyecto: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nuevo_estado"])) {
        $idProyecto = $_POST["id_proyecto"];
        $nuevoEstado = $_POST["nuevo_estado"];
        cambiarEstadoProyecto($idProyecto, $nuevoEstado);
    }
}
