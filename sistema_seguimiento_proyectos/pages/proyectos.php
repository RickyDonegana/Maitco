<?php
// Incluir los archivos necesarios
require_once('../php/conn.php');
require_once('../php/funcion_proyectos.php');

// Establecer la conexión a la base de datos
$pdo = conectarBaseDeDatos();

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
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="png">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <header class="encabezado">
        <nav class="menu-navegacion">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="pestanas">
                <li><a href="../pages/inicio.php">Inicio</a></li>
                <li><a href="../pages/proyectos.php">Proyectos</a></li>
                <li><a href="../pages/tareas.php">Tareas</a></li>
                <li><a href="../pages/configuracion.html">Configuración</a></li>
            </ul>
            <div class="icono-usuario">
                <img src="../svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="nombre-usuario">
                <?php echo isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>

    <main class="contenedor-principal">
        <h1 class="titulo">Mis Proyectos</h1>
        <!-- Botón para mostrar/ocultar el formulario -->
        <button class="boton-agregar" id="btnNuevoProyecto">Agregar Nuevo Proyecto</button>
        <!-- Tabla para mostrar los proyectos -->
        <table id="tablaProyectos" class="tabla-proyectos">
            <!-- Encabezado de la tabla -->
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
                <?php foreach ($proyectos as $proyecto) : ?>
                    <tr id="filaProyecto_<?php echo $proyecto["id_proyecto"]; ?>">
                        <td><?php echo $proyecto["id_proyecto"]; ?></td>
                        <td><?php echo $proyecto["nombre_proyecto"]; ?></td>
                        <td><?php echo $proyecto["descripcion"]; ?></td>
                        <td><?php echo $proyecto["cliente"]; ?></td>
                        <td><?php echo $proyecto["desarrollador"]; ?></td>
                        <td><?php echo $proyecto["fecha_inicio"]; ?></td>
                        <td><?php echo $proyecto["fecha_entrega_estimada"]; ?></td>
                        <td>
                            <form method="POST" class="select-container">
                                <input type="hidden" name="id_proyecto" value="<?php echo $proyecto["id_proyecto"]; ?>">
                                <select name="nuevo_estado" class="select" onchange="cambiarEstado(<?php echo $proyecto['id_proyecto']; ?>, this.value)">
                                    <option value="inicio" <?php echo ($proyecto["estado"] == 'inicio') ? 'selected' : ''; ?>>Inicio</option>
                                    <option value="planificacion" <?php echo ($proyecto["estado"] == 'planificacion') ? 'selected' : ''; ?>>Planificación</option>
                                    <option value="ejecucion" <?php echo ($proyecto["estado"] == 'ejecucion') ? 'selected' : ''; ?>>Ejecución</option>
                                    <option value="supervision" <?php echo ($proyecto["estado"] == 'supervision') ? 'selected' : ''; ?>>Supervisión</option>
                                    <option value="cierre" <?php echo ($proyecto["estado"] == 'cierre') ? 'selected' : ''; ?>>Cierre</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <input type="hidden" id="estado_<?php echo $proyecto["id_proyecto"]; ?>" value="<?php echo $proyecto["estado"]; ?>">
                            <button data-action="editar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" data-nombre="<?php echo $proyecto["nombre_proyecto"]; ?>" data-descripcion="<?php echo $proyecto["descripcion"]; ?>" data-cliente="<?php echo $proyecto["cliente"]; ?>" data-desarrollador="<?php echo $proyecto["desarrollador"]; ?>" data-fechaInicio="<?php echo $proyecto["fecha_inicio"]; ?>" data-fechaEntrega="<?php echo $proyecto["fecha_entrega_estimada"]; ?>" data-estado="<?php echo $proyecto["estado"]; ?>" class="boton-editar">
                                <img src="../svg/editar.svg" alt="Editar">
                            </button>
                            <button data-action="finalizar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" class="boton-finalizar">
                                <img src="../svg/finalizar.svg" alt="Finalizar">
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Formulario para agregar o editar proyectos (inicialmente oculto) -->
        <div id="nuevoProyectoForm" class="formulario-proyecto" style="display: none;">
            <h2 class="titulo">Nuevo Proyecto</h2>
            <form method="POST">
                <!-- Agrega un campo oculto para almacenar el ID del proyecto en caso de edición -->
                <input type="hidden" class="input" id="id_proyecto_form" name="id_proyecto">
                <label for="nombre_proyecto" class="label">Nombre del Proyecto:</label>
                <input type="text" class="input" id="nombre_proyecto" name="nombre_proyecto" required>
                <label for="descripcion" class="label">Descripción:</label>
                <textarea class="input" id="descripcion" name="descripcion" rows="2" required></textarea>
                <label for="cliente" class="label">Cliente:</label>
                <input type="text" class="input" id="cliente" name="cliente" required>
                <label for="desarrollador" class="label">Desarrollador:</label>
                <input type="text" class="input" id="desarrollador" name="desarrollador" required>
                <label for="fecha_inicio" class="label">Fecha de Inicio:</label>
                <input type="date" class="input" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_entrega_estimada" class="label">Fecha de Finalización Estimada:</label>
                <input type="date" class="input" id="fecha_entrega_estimada" name="fecha_entrega_estimada" required>
                <label for="estado" class="label">Estado:</label>
                <select name="estado" class="select" id="estado_form" required>
                    <option value="inicio">Inicio</option>
                    <option value="planificacion">Planificación</option>
                    <option value="ejecucion">Ejecución</option>
                    <option value="supervision">Supervisión</option>
                    <option value="cierre">Cierre</option>
                </select>
                <!-- Botón para agregar o editar proyectos -->
                <button type="submit" class="boton-principal boton-agregar" id="btnAgregarEditarProyecto" name="agregar_proyecto">Agregar</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>