<?php
// Archivo para manejar la inserción de nuevos proyectos en la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "ssp_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Comprobar si se envió el formulario para agregar un nuevo proyecto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST["project_name"];
    $description = $_POST["description"];
    $start_date = $_POST["start_date"];
    $estimated_delivery_date = $_POST["estimated_delivery_date"];

    // Consulta SQL para insertar el nuevo proyecto en la base de datos
    $sql = "INSERT INTO proyectos (project_name, description, start_date, estimated_delivery_date) VALUES ('$project_name', '$description', '$start_date', '$estimated_delivery_date')";

    if ($conn->query($sql) === TRUE) {
        // Redireccionar de nuevo a la página de proyectos después de la inserción exitosa
        header("Location: proyectos.php");
        exit;
    } else {
        echo "Error al agregar el proyecto: " . $conn->error;
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <nav class="menu">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="tabs">
                <li><a href="../html/index.html">Inicio</a></li>
                <li><a href="../html/proyectos.html">Proyectos</a></li>
                <li><a href="../html/tareas.html">Tareas</a></li>
                <li><a href="../html/configuracion.html">Configuración</a></li>
            </ul>
            <div class="user-icon">
                <img src="user-icon.png" alt="Icono de Usuario">
            </div>
        </nav>
    </header>

    <main class="main-content">
        <h1>Mis Proyectos</h1>

        <!-- Botón para abrir el formulario de nuevo proyecto -->
        <button id="btnNuevoProyecto">Nuevo Proyecto</button>

        <!-- Tabla para mostrar los proyectos -->
        <table>
            <thead>
                <tr>
                    <th>ID del Proyecto</th>
                    <th>Nombre del Proyecto</th>
                    <th>Descripción</th>
                    <th>Cliente</th>
                    <th>Desarrollador</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha Estimada de Finalización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se generarán dinámicamente las filas de proyectos desde JavaScript -->
            </tbody>
        </table>
    </main>

    <!-- Formulario para agregar nuevos proyectos (inicialmente oculto) -->
    <div id="nuevoProyectoForm" class="form-container" style="display: none;">
        <h2>Nuevo Proyecto</h2>
        <form>
            <label for="project_name">Nombre del Proyecto:</label>
            <input type="text" id="project_name" name="project_name" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="start_date">Fecha de Inicio:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="estimated_delivery_date">Fecha Estimada de Finalización:</label>
            <input type="date" id="estimated_delivery_date" name="estimated_delivery_date" required>

            <button type="submit">Agregar Proyecto</button>
        </form>
    </div>

    <script src="../js/script.js"></script> <!-- Asegúrate de que la ruta de tus scripts JavaScript sea correcta -->
</body>

</html>