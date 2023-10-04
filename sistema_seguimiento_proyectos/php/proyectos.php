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

// Función para agregar un nuevo proyecto
function agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO proyectos (nombre_proyecto, descripcion, cliente, desarrollador, fecha_inicio, fecha_entrega_estimada, estado) VALUES (:nombre, :descripcion, :cliente, :desarrollador, :fechaInicio, :fechaEntrega, :estado)");
    $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
    $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
    $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
    $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
    $stmt->execute();
}

// Función para editar un proyecto existente
function editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE proyectos SET nombre_proyecto = :nombre, descripcion = :descripcion, cliente = :cliente, desarrollador = :desarrollador, fecha_inicio = :fechaInicio, fecha_entrega_estimada = :fechaEntrega, estado = :estado WHERE id_proyecto = :id");
    $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $cliente, PDO::PARAM_STR);
    $stmt->bindParam(":desarrollador", $desarrollador, PDO::PARAM_STR);
    $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindParam(":fechaEntrega", $fechaEntrega, PDO::PARAM_STR);
    $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Función para finalizar un proyecto (no afecta a la base de datos, solo en la interfaz de usuario)
function finalizarProyecto($id)
{
    echo "Proyecto eliminado con ID: $id";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["agregar_proyecto"])) {
        // Procesar formulario para agregar proyecto
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        agregarProyecto($nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
        header("Location: ../php/proyectos.php");
    } elseif (isset($_POST["editar_proyecto"])) {
        // Procesar formulario para editar proyecto
        $id = $_POST["id_proyecto"];
        $nombre = $_POST["nombre_proyecto"];
        $descripcion = $_POST["descripcion"];
        $cliente = $_POST["cliente"];
        $desarrollador = $_POST["desarrollador"];
        $fechaInicio = $_POST["fecha_inicio"];
        $fechaEntrega = $_POST["fecha_entrega_estimada"];
        $estado = $_POST["estado"];
        editarProyecto($id, $nombre, $descripcion, $cliente, $desarrollador, $fechaInicio, $fechaEntrega, $estado);
    } elseif (isset($_POST["finalizar_proyecto"])) {
        // Procesar formulario para finalizar proyecto
        $id = $_POST["id_proyecto"];
        finalizarProyecto($id);
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
        <h1> Mis Proyectos</h1>
        <!-- Botón para mostrar/ocultar el formulario -->
        <button class="input_btn" id="btnNuevoProyecto">Agregar Nuevo Proyecto</button>
        <!-- Tabla para mostrar los proyectos -->
        <table id="tablaProyectos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Proyecto</th>
                    <th>Descripción</th>
                    <th>Cliente</th>
                    <th>Desarrollador</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Finalización Estimada</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $proyecto) { ?>
                    <tr id=" filaProyecto_<?php echo $proyecto["id_proyecto"]; ?>">
                        <td><?php echo $proyecto["id_proyecto"]; ?></td>
                        <td><?php echo $proyecto["nombre_proyecto"]; ?></td>
                        <td><?php echo $proyecto["descripcion"]; ?></td>
                        <td><?php echo $proyecto["cliente"]; ?></td>
                        <td><?php echo $proyecto["desarrollador"]; ?></td>
                        <td><?php echo $proyecto["fecha_inicio"]; ?></td>
                        <td><?php echo $proyecto["fecha_entrega_estimada"]; ?></td>
                        <td>
                            <select name="estado" id="estado_<?php echo $proyecto["id_proyecto"]; ?>">
                                <option value="inicio" <?php if ($proyecto["estado"] == 'inicio') echo 'selected'; ?>>Inicio</option>
                                <option value="planificacion" <?php if ($proyecto["estado"] == 'planificacion') echo 'selected'; ?>>Planificación</option>
                                <option value="ejecucion" <?php if ($proyecto["estado"] == 'ejecucion') echo 'selected'; ?>>Ejecución</option>
                                <option value="supervision" <?php if ($proyecto["estado"] == 'supervision') echo 'selected'; ?>>Supervisión</option>
                                <option value="cierre" <?php if ($proyecto["estado"] == 'cierre') echo 'selected'; ?>>Cierre</option>
                            </select>
                        </td>
                        <td>
                            <button data-action="editar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" data-nombre="<?php echo $proyecto["nombre_proyecto"]; ?>" data-descripcion="<?php echo $proyecto["descripcion"]; ?>" data-cliente="<?php echo $proyecto["cliente"]; ?>" data-desarrollador="<?php echo $proyecto["desarrollador"]; ?>" data-fecha-inicio="<?php echo $proyecto["fecha_inicio"]; ?>" data-fecha-entrega="<?php echo $proyecto["fecha_entrega_estimada"]; ?>" data-estado="<?php echo $proyecto["estado"]; ?>">Editar</button>
                            <button data-action="finalizar" data-id="<?php echo $proyecto["id_proyecto"]; ?>">Finalizar</button>
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
                <input type="hidden" class="input" id="id_proyecto_form" name="id_proyecto">
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
                <label for="fecha_entrega_estimada" class="input">Fecha de Finalización Estimada:</label>
                <input type="date" class="input" id="fecha_entrega_estimada" name="fecha_entrega_estimada" required>
                <label for="estado" class="input">Estado:</label>
                <select name="estado" class="input" id="estado_form" required>
                    <option value="inicio">Inicio</option>
                    <option value="planificacion">Planificación</option>
                    <option value="ejecucion">Ejecución</option>
                    <option value="supervision">Supervisión</option>
                    <option value="cierre">Cierre</option>
                </select>
                <!-- Botón para agregar o editar proyectos -->
                <button type="submit" class="input_btn" id="btnAgregarEditarProyecto" name="agregar_proyecto">Agregar</button>
            </form>
        </div>
    </main>
    <script src="../js/script.js"></script>
</body>

</html>