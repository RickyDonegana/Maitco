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
    // Procesar el formulario para agregar o editar proyectos
    if (isset($_POST["proyecto_id"])) {
        // Editar proyecto existente
        $proyecto_id = $_POST["proyecto_id"];
        $nombreProyecto = $_POST["nombreProyecto"];
        $descripcionProyecto = $_POST["descripcionProyecto"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaEstimada = $_POST["fechaEstimada"];
        $estado = $_POST["estado"];
        $stmt = $pdo->prepare("UPDATE proyectos SET project_name = :nombreProyecto, description = :descripcionProyecto, client = :cliente, developer = :desarrollador, start_date = :fechaInicio, estimated_delivery_date = :fechaEstimada, estado = :estado WHERE project_id = :proyecto_id");
        $stmt->bindParam(":nombreProyecto", $nombreProyecto, PDO::PARAM_STR);
        $stmt->bindParam(":descripcionProyecto", $descripcionProyecto, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEstimada", $fechaEstimada, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":proyecto_id", $proyecto_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // Agregar nuevo proyecto
        $nombreProyecto = $_POST["nombreProyecto"];
        $descripcionProyecto = $_POST["descripcionProyecto"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaEstimada = $_POST["fechaEstimada"];
        $estado = $_POST["estado"];
        // Realizar la inserción en la base de datos
        $stmt = $pdo->prepare("INSERT INTO proyectos (project_name, description, client, developer, start_date, estimated_delivery_date, estado) VALUES (:nombreProyecto, :descripcionProyecto, :cliente, :desarrollador, :fechaInicio, :fechaEstimada, :estado)");
        $stmt->bindParam(":nombreProyecto", $nombreProyecto, PDO::PARAM_STR);
        $stmt->bindParam(":descripcionProyecto", $descripcionProyecto, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaEstimada", $fechaEstimada, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->execute();
    }
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
                <li><a href="../php/inicio.php">Inicio</a></li>
                <li><a href="../php/proyectos.php">Proyectos</a></li>
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
                    <th>Estado</th>
                    <th>Acciones</th>
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
                        <td>
                            <select name="estado" id="estado">
                                <option value="inicio" <?php if (isset($proyecto["estado"]) && $proyecto["estado"] == 'inicio') echo 'selected'; ?>>Inicio</option>
                                <option value="planificacion" <?php echo ($proyecto["estado"] == 'planificacion') ? 'selected' : ''; ?>>Planificación</option>
                                <option value="ejecucion" <?php echo ($proyecto["estado"] == 'ejecucion') ? 'selected' : ''; ?>>Ejecución</option>
                                <option value="supervision" <?php echo ($proyecto["estado"] == 'supervision') ? 'selected' : ''; ?>>Supervisión</option>
                                <option value="cierre" <?php echo ($proyecto["estado"] == 'cierre') ? 'selected' : ''; ?>>Cierre</option>
                            </select>
                        </td>
                        <td>
                            <button onclick="editarProyecto(<?php echo $proyecto["project_id"]; ?>)">Editar</button>
                            <button onclick="finalizarProyecto(<?php echo $proyecto["project_id"]; ?>)">Finalizar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Formulario para agregar o editar proyectos (inicialmente oculto) -->
        <div id="nuevoProyectoForm" class="form-container" style="display: none;">
            <h2>Nuevo Proyecto</h2>
            <form method="POST">
                <!-- Agrega un campo oculto para almacenar el ID del proyecto en caso de edición -->
                <div class="input__box">
                    <input type="hidden" class="input" id="proyecto_id" name="proyecto_id">
                    <label for="nombreProyecto" class="input">Nombre del Proyecto:</label>
                    <input type=" text" class="input" id="nombreProyecto" name="nombreProyecto" required>
                    <label for="descripcionProyecto" class="input">Descripción:</label>
                    <textarea id="descripcionProyecto" class="input" name="descripcionProyecto" rows="4" required></textarea>
                    <label for="cliente" class="input">Cliente:</label>
                    <input type="text" class="input" id="cliente" name="cliente" required>
                    <label for="desarrollador" class="input">Desarrollador:</label>
                    <input type="text" class="input" id="desarrollador" name="desarrollador" required>
                    <label for="fechaInicio" class="input">Fecha de Inicio:</label>
                    <input type="date" class="input" id="fechaInicio" name="fechaInicio" required>
                    <label for="fechaEstimada" class="input">Fecha Estimada de Finalización:</label>
                    <input type="date" class="input" id="fechaEstimada" name="fechaEstimada" required>
                    <label for="estado" class="input">Estado:</label>
                    <select name="estado" class="input" id="estado">
                        <option value="inicio" class="input">Inicio</option>
                        <option value="planificacion" class="input">Planificación</option>
                        <option value="ejecucion" class="input">Ejecución</option>
                        <option value="supervision" class="input">Supervisión</option>
                        <option value="cierre" class="input">Cierre</option>
                    </select>
                    <!-- Botón para agregar o editar proyectos -->
                    <button type="button" class="input_btn" id="btnAgregarEditarProyecto">Agregar</button>
                    <di </form>
                </div>
                <script src="../js/script.js">
                </script>

</html>