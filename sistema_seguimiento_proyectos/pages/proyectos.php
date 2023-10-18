<?php
require_once('../php/conn.php');
require_once('../php/funcion_proyectos.php');
require_once('../php/usuario.php');
$pdo = conectarBaseDeDatos();
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
                <?= isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <h1 class="titulo">Mis Proyectos</h1>
        <a href="../pages/proyectos_agregar.php" class="boton-agregar" id="btnNuevoProyecto">Agregar Nuevo Proyecto</a>
        <table id="tablaProyectos" class="tabla-proyectos">
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
                    <tr id="filaProyecto_<?php echo $proyecto["id_proyecto"]; ?>" <?php if ($proyecto['estado'] == 'finalizado') { ?> style="display:none;" <?php } ?>>
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
                                    <option value="finalizado" hidden <?php echo ($proyecto["estado"] == 'finalizado') ? 'selected' : ''; ?>>Cierre</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <input type="hidden" id="estado_<?php echo $proyecto["id_proyecto"]; ?>" value="<?php echo $proyecto["estado"]; ?>">
                            <a href="../pages/proyectos_editar.php" data-action="editar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" data-nombre="<?php echo $proyecto["nombre_proyecto"]; ?>" data-descripcion="<?php echo $proyecto["descripcion"]; ?>" data-cliente="<?php echo $proyecto["cliente"]; ?>" data-desarrollador="<?php echo $proyecto["desarrollador"]; ?>" data-fechaInicio="<?php echo $proyecto["fecha_inicio"]; ?>" data-fechaEntrega="<?php echo $proyecto["fecha_entrega_estimada"]; ?>" data-estado="<?php echo $proyecto["estado"]; ?>" class="boton-editar"></a>
                            <button data-action="finalizar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" class="boton-finalizar">
                                <img src="../svg/finalizar.svg" alt="Finalizar">
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>