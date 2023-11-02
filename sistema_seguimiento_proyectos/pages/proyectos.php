<?php
require_once('../php/conn.php');
require_once('../php/inicioSesion/acceso.php');
require_once('../php/proyectos/tablaProyectos.php');
$pdo = conectarBaseDeDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="png">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                <li><a href="../php/logout.php">Cerrar Sesión</a></li>
            </ul>
            <div class="icono-usuario">
                <img src="../assets/svg/usuario.svg" alt="Icono de Usuario">
            </div>
            <span class="nombre-usuario">
                <?= isset($nombreUsuario) ? $nombreUsuario : ""; ?>
            </span>
        </nav>
    </header>
    <main class="contenedor-principal">
        <h1 class="titulo">Mis Proyectos</h1>
        <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios') : ?>
            <!-- Mostrar el botón para agregar nuevo proyecto solo para Desarrolladores -->
            <a href="../pages/agregar_proyecto.php" class="boton-agregarEditar">Agregar Nuevo Proyecto</a>
        <?php endif; ?>
        <table id="tablaProyectosTareas" class="tabla-proyectos">
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
                    <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios') : ?>
                        <!-- Mostrar el encabezado de Acciones solo para Desarrolladores -->
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $proyecto) : ?>
                    <tr <?php echo $proyecto["id_proyecto"]; ?>" <?php if ($proyecto['estado'] == 'finalizado') { ?> style="display:none;" <?php } ?>>
                        <td><?php echo $proyecto["id_proyecto"]; ?></td>
                        <td><?php echo $proyecto["nombre_proyecto"]; ?></td>
                        <td><?php echo $proyecto["descripcion"]; ?></td>
                        <td><?php echo $proyecto["cliente"]; ?></td>
                        <td><?php echo $proyecto["desarrollador"]; ?></td>
                        <td><?php echo $proyecto["fecha_inicio"]; ?></td>
                        <td><?php echo $proyecto["fecha_entrega_estimada"]; ?></td>
                        <td><?php echo $proyecto["estado"]; ?></td>
                        <?php if ($_SESSION['rol_usuario'] == 'Desarrollador de sitios') : ?>
                        <!-- Mostrar el encabezado de Acciones solo para Desarrolladores -->
                        <td>
                            <input type="hidden" id="estado_<?php echo $proyecto["id_proyecto"]; ?>" value="<?php echo $proyecto["estado"]; ?>">
                            <a href="../pages/editar_proyecto.php?id=<?php echo $proyecto["id_proyecto"]; ?>" class="boton-editar"></a>
                            <button data-action="finalizar" data-id="<?php echo $proyecto["id_proyecto"]; ?>" class="boton-finalizar">
                                <img src="../assets/svg/finalizar.svg" alt="Finalizar">
                            </button>
                        </td>
                        <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>