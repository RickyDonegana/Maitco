<?php
/*
Plugin Name: Sistema de Seguimiento de Proyectos
Description: Un plugin para el seguimiento de proyectos web.
Version: 1.0
Author: Tu Nombre
*/

function cargar_estilos_plugin()
{
    // Enlazar el archivo CSS de estilos
    wp_enqueue_style('estilos-plugin', plugins_url('/css/styles.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'cargar_estilos_plugin');

// Paso 1: Crear la página de administración de etapas
function crear_pagina_admin_etapas()
{
    add_menu_page(
        'Administrar Etapas',
        'Etapas',
        'manage_options',
        'administrar-etapas',
        'mostrar_pagina_admin_etapas'
    );
}

add_action('admin_menu', 'crear_pagina_admin_etapas');

// Función para mostrar el contenido de la página de administración de etapas
function mostrar_pagina_admin_etapas()
{
    global $wpdb;

    // Comprobar si se ha enviado el formulario para guardar la etapa
    if (isset($_POST['guardar_etapa'])) {
        // Obtener el nombre de la etapa desde el formulario
        $nombre_etapa = sanitize_text_field($_POST['nombre_etapa']);

        // Validar que el nombre de la etapa no esté vacío
        if (empty($nombre_etapa)) {
            echo '<div class="error"><p>El nombre de la etapa no puede estar vacío.</p></div>';
        } else {
            // Agregar la etapa a la base de datos
            $etapa_id = agregar_etapa_a_base_de_datos($nombre_etapa);

            // Mostrar un mensaje de éxito
            echo '<div class="updated"><p>La etapa se ha agregado correctamente.</p></div>';
        }
    }

    // Mostrar el formulario para agregar etapas
?>
    <div class="wrap">
        <h2>Administrar Etapas</h2>
        <form method="post" action="">
            <label for="nombre_etapa">Nombre de la Etapa:</label>
            <input type="text" id="nombre_etapa" name="nombre_etapa" /><br />
            <input type="submit" name="guardar_etapa" value="Guardar Etapa" class="button-primary" />
        </form>
    </div>
<?php
}

// Función para agregar la etapa a la base de datos
function agregar_etapa_a_base_de_datos($nombre_etapa)
{
    global $wpdb;

    // Nombre de la tabla de etapas del proyecto
    $tabla_etapas = $wpdb->prefix . 'etapas_proyecto';

    // Datos a insertar
    $datos_etapa = array(
        'project_id' => 1, // Debes ajustar el ID del proyecto
        'stage_name' => $nombre_etapa,
        'color' => 'verde' // Puedes ajustar el color predeterminado
    );

    // Formato de los datos
    $formato_datos_etapa = array('%d', '%s', '%s');

    // Insertar la etapa en la tabla de etapas
    $wpdb->insert($tabla_etapas, $datos_etapa, $formato_datos_etapa);

    // Devolver el ID de la etapa recién agregada
    return $wpdb->insert_id;
}

// Función para eliminar una etapa de la base de datos
function eliminar_etapa_de_base_de_datos($etapa_id)
{
    global $wpdb;

    // Nombre de la tabla de etapas del proyecto
    $tabla_etapas = $wpdb->prefix . 'etapas_proyecto';

    // Realizar la eliminación de la etapa en la tabla de etapas
    $wpdb->delete($tabla_etapas, array('stage_id' => $etapa_id), array('%d'));
}

// Función para obtener la lista de etapas desde la base de datos
function obtener_lista_de_etapas_desde_base_de_datos()
{
    global $wpdb;

    // Nombre de la tabla de etapas del proyecto
    $tabla_etapas = $wpdb->prefix . 'etapas_proyecto';

    // Realizar la consulta a la base de datos
    $etapas = $wpdb->get_results("SELECT * FROM $tabla_etapas WHERE project_id = 1"); // Debes ajustar el ID del proyecto

    return $etapas;
}

// Paso 3: Crear la página de administración de proyectos
function crear_pagina_admin_proyectos()
{
    add_menu_page(
        'Administrar Proyectos',
        'Proyectos',
        'manage_options',
        'administrar-proyectos',
        'mostrar_pagina_admin_proyectos'
    );
}

add_action('admin_menu', 'crear_pagina_admin_proyectos');

// Función para mostrar el contenido de la página de administración de proyectos
function mostrar_pagina_admin_proyectos()
{
    global $wpdb;

    // Comprobar si se ha enviado el formulario para guardar el proyecto
    if (isset($_POST['guardar_proyecto'])) {
        // Obtener los datos del proyecto desde el formulario
        $nombre_proyecto = sanitize_text_field($_POST['nombre_proyecto']);
        $fecha_inicio = sanitize_text_field($_POST['fecha_inicio']);
        $fecha_entrega = sanitize_text_field($_POST['fecha_entrega']);

        // Validar que los campos no estén vacíos
        if (empty($nombre_proyecto) || empty($fecha_inicio) || empty($fecha_entrega)) {
            echo '<div class="error"><p>Todos los campos son obligatorios.</p></div>';
        } else {
            // Agregar el proyecto a la base de datos
            agregar_proyecto_a_base_de_datos($nombre_proyecto, $fecha_inicio, $fecha_entrega);

            // Mostrar un mensaje de éxito
            echo '<div class="updated"><p>El proyecto se ha agregado correctamente.</p></div>';
        }
    }

    // Mostrar el formulario para agregar proyectos
?>
    <div class="wrap">
        <h2>Administrar Proyectos</h2>
        <form method="post" action="">
            <label for="nombre_proyecto">Nombre del Proyecto:</label>
            <input type="text" id="nombre_proyecto" name="nombre_proyecto" /><br />
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" /><br />
            <label for="fecha_entrega">Fecha de Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" /><br />
            <input type="submit" name="guardar_proyecto" value="Guardar Proyecto" class="button-primary" />
        </form>
    </div>
    <?php

    // Mostrar la lista de proyectos desde la base de datos
    ?>
    <div class="wrap">
        <h2>Lista de Proyectos</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Proyecto</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Entrega</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtener la lista de proyectos desde la base de datos
                $proyectos = obtener_lista_de_proyectos_desde_base_de_datos();

                foreach ($proyectos as $proyecto) {
                    echo '<tr>';
                    echo '<td>' . esc_html($proyecto->project_id) . '</td>';
                    echo '<td>' . esc_html($proyecto->project_name) . '</td>';
                    echo '<td>' . esc_html($proyecto->start_date) . '</td>';
                    echo '<td>' . esc_html($proyecto->estimated_delivery_date) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
}

// Función para agregar el proyecto a la base de datos
function agregar_proyecto_a_base_de_datos($nombre_proyecto, $fecha_inicio, $fecha_entrega)
{
    global $wpdb;

    // Nombre de la tabla de proyectos
    $tabla_proyectos = $wpdb->prefix . 'proyectos';

    // Datos a insertar
    $datos_proyecto = array(
        'project_name' => $nombre_proyecto,
        'start_date' => $fecha_inicio,
        'estimated_delivery_date' => $fecha_entrega,
    );

    // Formato de los datos
    $formato_datos_proyecto = array('%s', '%s', '%s');

    // Insertar el proyecto en la tabla de proyectos
    $wpdb->insert($tabla_proyectos, $datos_proyecto, $formato_datos_proyecto);
}

// Función para obtener la lista de proyectos desde la base de datos
function obtener_lista_de_proyectos_desde_base_de_datos()
{
    global $wpdb;

    // Nombre de la tabla de proyectos
    $tabla_proyectos = $wpdb->prefix . 'proyectos';

    // Realizar la consulta a la base de datos
    $proyectos = $wpdb->get_results("SELECT * FROM $tabla_proyectos");

    return $proyectos;
}

// Paso 4: Crear la página de administración de etapas personalizadas por proyecto

// Agregar columna de acciones a la lista de proyectos
function agregar_columna_acciones_proyectos($columnas)
{
    $columnas['acciones'] = 'Acciones';
    return $columnas;
}

add_filter('manage_proyectos_posts_columns', 'agregar_columna_acciones_proyectos');

// Mostrar contenido de la columna de acciones
function mostrar_contenido_columna_acciones_proyectos($columna, $post_id)
{
    if ($columna === 'acciones') {
        // Obtener el ID del proyecto
        $project_id = get_post_meta($post_id, 'project_id', true);

        // Mostrar un enlace para administrar etapas
        echo '<a href="' . admin_url('admin.php?page=administrar-etapas-proyecto&project_id=' . $project_id) . '">Administrar Etapas</a>';
    }
}

add_action('manage_proyectos_posts_custom_column', 'mostrar_contenido_columna_acciones_proyectos', 10, 2);

// Crear la página de administración de etapas por proyecto
function crear_pagina_admin_etapas_proyecto()
{
    add_submenu_page(
        'edit.php?post_type=proyectos',
        'Administrar Etapas de Proyecto',
        'Administrar Etapas',
        'manage_options',
        'administrar-etapas-proyecto',
        'mostrar_pagina_admin_etapas_proyecto'
    );
}

add_action('admin_menu', 'crear_pagina_admin_etapas_proyecto');

// Función para mostrar el contenido de la página de administración de etapas por proyecto
function mostrar_pagina_admin_etapas_proyecto()
{
    global $wpdb;

    // Obtener el ID del proyecto desde la URL
    if (isset($_GET['project_id'])) {
        $project_id = intval($_GET['project_id']);
    } else {
        // Si no se proporciona un ID de proyecto, mostrar un mensaje de error
        echo '<div class="error"><p>No se ha proporcionado un proyecto válido.</p></div>';
        return;
    }

    // Comprobar si se ha enviado el formulario para agregar etapas al proyecto
    if (isset($_POST['guardar_etapa_proyecto'])) {
        // Obtener el nombre de la etapa desde el formulario
        $nombre_etapa = sanitize_text_field($_POST['nombre_etapa_proyecto']);

        // Validar que el nombre de la etapa no esté vacío
        if (empty($nombre_etapa)) {
            echo '<div class="error"><p>El nombre de la etapa no puede estar vacío.</p></div>';
        } else {
            // Agregar la etapa al proyecto en la base de datos
            agregar_etapa_a_proyecto($project_id, $nombre_etapa);

            // Mostrar un mensaje de éxito
            echo '<div class="updated"><p>La etapa se ha agregado al proyecto correctamente.</p></div>';
        }
    }

    // Obtener el nombre del proyecto
    $nombre_proyecto = get_post_meta($project_id, 'project_name', true);

    // Mostrar el nombre del proyecto
    echo '<div class="wrap">';
    echo '<h2>Administrar Etapas para el Proyecto: ' . esc_html($nombre_proyecto) . '</h2>';

    // Mostrar el formulario para agregar etapas al proyecto
    echo '<form method="post" action="">';
    echo '<label for="nombre_etapa_proyecto">Nombre de la Etapa:</label>';
    echo '<input type="text" id="nombre_etapa_proyecto" name="nombre_etapa_proyecto" />';
    echo '<input type="submit" name="guardar_etapa_proyecto" value="Agregar Etapa" class="button-primary" />';
    echo '</form>';

    // Mostrar la lista de etapas del proyecto desde la base de datos
    echo '<h3>Lista de Etapas</h3>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Nombre de la Etapa</th></tr></thead>';
    echo '<tbody>';

    $etapas_proyecto = obtener_etapas_de_proyecto_desde_base_de_datos($project_id);

    foreach ($etapas_proyecto as $etapa) {
        echo '<tr>';
        echo '<td>' . esc_html($etapa->stage_id) . '</td>';
        echo '<td>' . esc_html($etapa->stage_name) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// Función para agregar la etapa al proyecto en la base de datos
function agregar_etapa_a_proyecto($project_id, $nombre_etapa)
{
    global $wpdb;

    // Nombre de la tabla de etapas de proyecto
    $tabla_etapas_proyecto = $wpdb->prefix . 'etapas_proyecto';

    // Datos a insertar
    $datos_etapa_proyecto = array(
        'project_id' => $project_id,
        'stage_name' => $nombre_etapa,
        'color' => '', // Debes manejar la asignación de colores
    );

    // Formato de los datos
    $formato_datos_etapa_proyecto = array('%d', '%s', '%s');

    // Insertar la etapa en la tabla de etapas de proyecto
    $wpdb->insert($tabla_etapas_proyecto, $datos_etapa_proyecto, $formato_datos_etapa_proyecto);
}

// Función para obtener la lista de etapas del proyecto desde la base de datos
function obtener_etapas_de_proyecto_desde_base_de_datos($project_id)
{
    global $wpdb;

    // Nombre de la tabla de etapas de proyecto
    $tabla_etapas_proyecto = $wpdb->prefix . 'etapas_proyecto';

    // Realizar la consulta a la base de datos
    $etapas_proyecto = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabla_etapas_proyecto WHERE project_id = %d", $project_id));

    return $etapas_proyecto;
}

// Activar el plugin
function activar_plugin()
{
    // Puedes realizar acciones de activación aquí si es necesario
}

// Desactivar el plugin
function desactivar_plugin()
{
    // Puedes realizar acciones de desactivación aquí si es necesario
}

register_activation_hook(__FILE__, 'activar_plugin');
register_deactivation_hook(__FILE__, 'desactivar_plugin');
