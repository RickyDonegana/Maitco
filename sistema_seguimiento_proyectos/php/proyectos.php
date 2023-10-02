<?php
// Función para conectar a la base de datos
function conectarBaseDeDatos()
{
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_de_datos = "ssp_db";

    try {
        return new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Establecer la conexión a la base de datos
$pdo = conectarBaseDeDatos();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Procesar el formulario para agregar proyectos
    $nombreProyecto = $_POST["nombreProyecto"];
    $descripcionProyecto = $_POST["descripcionProyecto"];
    $cliente = $_POST["cliente"];
    $desarrollador = $_POST["desarrollador"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaEstimada = $_POST["fechaEstimada"];

    // Realizar la inserción en la base de datos
    $stmt = $pdo->prepare("INSERT INTO proyectos (project_name, description, client, developer, start_date, estimated_delivery_date) VALUES (:nombreProyecto, :descripcionProyecto, :cliente, :desarrollador, :fechaInicio, :fechaEstimada)");
    $stmt->bindParam(":nombreProyecto", $nombreProyecto, PDO::PARAM_STR);
    $stmt->bindParam(":descripcionProyecto", $descripcionProyecto, PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
    $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
    $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindParam(":fechaEstimada", $fechaEstimada, PDO::PARAM_STR);
    $stmt->execute();
}

// Consultar proyectos existentes
$stmt = $pdo->prepare("SELECT * FROM proyectos");
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <!-- Botón para mostrar/ocultar el formulario -->
        <button id="btnNuevoProyecto">Agregar Nuevo Proyecto</button>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $proyecto) { ?>
                    <tr>
                        <td><?php echo $proyecto["project_id"]; ?></td>
                        <td><?php echo $proyecto["project_name"]; ?></td>
                        <td><?php echo $proyecto["description"]; ?></td>
                        <td><?php echo $proyecto["client"]; ?></td>
                        <td><?php echo $proyecto["developer"]; ?></td>
                        <td><?php echo $proyecto["start_date"]; ?></td>
                        <td><?php echo $proyecto["estimated_delivery_date"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
    <!-- Formulario para agregar nuevos proyectos (inicialmente oculto) -->
    <div id="nuevoProyectoForm" class="form-container" style="display: none;">
        <!-- Formulario para agregar nuevos proyectos -->
        <div id="nuevoProyectoForm" class="form-container">
            <h2>Nuevo Proyecto</h2>
            <form method="POST">
                <label for="nombreProyecto">Nombre del Proyecto:</label>
                <input type="text" id="nombreProyecto" name="nombreProyecto" required>

                <label for="descripcionProyecto">Descripción:</label>
                <textarea id="descripcionProyecto" name="descripcionProyecto" rows="4" required></textarea>

                <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>

                <label for="desarrollador">Desarrollador:</label>
                <input type="text" id="desarrollador" name="desarrollador" required>

                <label for="fechaInicio">Fecha de Inicio:</label>
                <input type="date" id="fechaInicio" name="fechaInicio" required>

                <label for="fechaEstimada">Fecha Estimada de Finalización:</label>
                <input type="date" id="fechaEstimada" name="fechaEstimada" required>

                <button type="submit">Agregar Proyecto</button>
            </form>
        </div>

        <script src="../js/script.js"></script>
</body>

</html>