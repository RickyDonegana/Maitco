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
    if (isset($_POST["id_proyecto"])) {
        // Editar proyecto existente
        $id_proyecto = $_POST["id_proyecto"];
        $nombre_proyecto = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_entrega_estimada = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];

        $stmt = $pdo->prepare("UPDATE proyectos SET nombre_proyecto = :nombre_proyecto, descripcion = :descripcion, cliente = :cliente, desarrollador = :desarrollador, fecha_inicio = :fecha_inicio, fecha_entrega_estimada = :fecha_entrega_estimada, estado = :estado WHERE id_proyecto = :id_proyecto");
        $stmt->bindParam(":nombre_proyecto", $nombre_proyecto, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_entrega_estimada", $fecha_entrega_estimada, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $id_proyecto, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // Agregar nuevo proyecto
        $nombre_proyecto = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_entrega_estimada = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];

        // Realizar la inserción en la base de datos
        $stmt = $pdo->prepare("INSERT INTO proyectos (nombre_proyecto, descripcion, cliente, desarrollador, fecha_inicio, fecha_entrega_estimada, estado) VALUES (:nombre_proyecto, :descripcion, :cliente, :desarrollador, :fecha_inicio, :fecha_entrega_estimada, :estado)");
        $stmt->bindParam(":nombre_proyecto", $nombre_proyecto, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_entrega_estimada", $fecha_entrega_estimada, PDO::PARAM_STR);
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
    <title>Proyectos | Maitco</title>
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
        <button class="input_btn" id="btnNuevoProyecto">Agregar Nuevo Proyecto</button>
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
                        <td><?php echo $proyecto["id_proyecto"]; ?></td>
                        <td><?php echo $proyecto["nombre_proyecto"]; ?></td>
                        <td><?php echo $proyecto["descripcion"]; ?></td>
                        <td><?php echo $proyecto["cliente"]; ?></td>
                        <td><?php echo $proyecto["desarrollador"]; ?></td>
                        <td><?php echo $proyecto["fecha_inicio"]; ?></td>
                        <td><?php echo $proyecto["fecha_entrega_estimada"]; ?></td>
                        <td>
                            <select name="estado" id="estado">
                                <option value="inicio" <?php if ($proyecto["estado"] == 'inicio') echo 'selected'; ?>>Inicio</option>
                                <option value="planificacion" <?php if ($proyecto["estado"] == 'planificacion') echo 'selected'; ?>>Planificación</option>
                                <option value="ejecucion" <?php if ($proyecto["estado"] == 'ejecucion') echo 'selected'; ?>>Ejecución</option>
                                <option value="supervision" <?php if ($proyecto["estado"] == 'supervision') echo 'selected'; ?>>Supervisión</option>
                                <option value="cierre" <?php if ($proyecto["estado"] == 'cierre') echo 'selected'; ?>>Cierre</option>
                            </select>
                        </td>
                        <td>
                            <button onclick="editarProyecto(<?php echo $proyecto["id_proyecto"]; ?>)">Editar</button>
                            <button onclick="finalizarProyecto(<?php echo $proyecto["id_proyecto"]; ?>)">Finalizar</button>
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
                <input type="hidden" class="input" id="id_proyecto" name="id_proyecto">
                <label for="nombre_proyecto" class="input">Nombre del Proyecto:</label>
                <input type="text" class="input" id="nombre_proyecto" name="nombre_proyecto" required>
                <label for="descripcion" class="input">Descripción:</label>
                <textarea class="input" id="descripcion" name="descripcion" rows="2" required></textarea>
                <label for="cliente" class="input">Cliente:</label>
                <input type="text" class="input" id="cliente" name="cliente" required>
                <label for="desarrollador" class="input">Desarrollador:</label>
                <input type="text" class="input" id="desarrollador" name="desarrollador" required>
                <label for="fecha_inicio" class="input">Fecha de Inicio:</label>
                <input type="date" class="input" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_entrega_estimada" class="input">Fecha Estimada de Finalización:</label>
                <input type="date" class="input" id="fecha_entrega_estimada" name="fecha_entrega_estimada" required>
                <label for="estado" class="input">Estado:</label>
                <select name="estado" class="input" id="estado" required>
                    <option value="inicio">Inicio</option>
                    <option value="planificacion">Planificación</option>
                    <option value="ejecucion">Ejecución</option>
                    <option value="supervision">Supervisión</option>
                    <option value="cierre">Cierre</option>
                </select>
                <!-- Botón para agregar o editar proyectos -->
                <button type="submit" class="input_btn" id="btnAgregarEditarProyecto">Agregar</button>
            </form>
        </div>
    </main>
    <script src="../js/script.js"></script>
</body>

</html>