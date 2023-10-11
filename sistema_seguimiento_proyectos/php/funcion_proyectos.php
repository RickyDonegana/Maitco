<?php
include('../php/conn.php');

// Función para agregar un nuevo proyecto
function agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    $pdo = conectarBaseDeDatos();
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
    $pdo = conectarBaseDeDatos();
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

// Función para finalizar un proyecto
function finalizarProyecto($id)
{
    $pdo = conectarBaseDeDatos();
    try {
        // Actualizar el estado del proyecto a "cierre"
        $sql = "UPDATE proyectos SET estado = 'finalizado' WHERE id_proyecto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        // Puedes manejar cualquier excepción aquí si es necesario
    } catch (PDOException $e) {
        // Manejar el error, por ejemplo, registrar el error en un archivo o mostrar un mensaje de error al usuario
        echo "Error al finalizar el proyecto: " . $e->getMessage();
    }
}

// Función para cambiar el estado de un proyecto
function cambiarEstadoProyecto($idProyecto, $nuevoEstado)
{
    $pdo = conectarBaseDeDatos();
    try {
        $sql = "UPDATE proyectos SET estado = :nuevoEstado WHERE id_proyecto = :idProyecto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nuevoEstado", $nuevoEstado, PDO::PARAM_STR);
        $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
        $stmt->execute();

        // Devuelve una respuesta JSON para confirmar el cambio de estado si es necesario
        echo json_encode(["exito" => true]);
    } catch (PDOException $e) {
        // Manejar el error si es necesario
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
        // Mostrar mensaje de advertencia antes de finalizar el proyecto
        echo json_encode(["confirmacion" => true, "id_proyecto" => $idProyecto]);
        exit;
    } elseif (isset($_POST["confirmar_finalizar_proyecto"])) {
        $idProyecto = $_POST["id_proyecto"];
        finalizarProyecto($idProyecto);
        echo json_encode(["exito" => true]);
        exit;
    } elseif (isset($_POST["agregar_proyecto"])) {
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
        header("Location: ../pages/proyectos.php");
        exit;
    } elseif (isset($_POST["editar_proyecto"])) {
        $id = $_POST["id_proyecto"];
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
    }
}
