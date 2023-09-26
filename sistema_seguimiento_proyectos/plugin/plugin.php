<?php
/*
Plugin Name: Sistema de Seguimiento de Proyectos
Description: Un plugin para el seguimiento de proyectos web.
Version: 1.0
Author: Ricardo Donegana y Agustín Fernández
*/

// Creación de Páginas de Administración

function crear_pagina_proyectos()
{
    add_menu_page('Proyectos', 'Proyectos', 'manage_options', 'pagina_proyectos', 'mostrar_pagina_proyectos');
}
add_action('admin_menu', 'crear_pagina_proyectos');

function crear_pagina_etapas()
{
    add_submenu_page('pagina_proyectos', 'Etapas', 'Etapas', 'manage_options', 'pagina_etapas', 'mostrar_pagina_etapas');
}
add_action('admin_menu', 'crear_pagina_etapas');

// Diseño de la Interfaz de Usuario (UI)

function mostrar_pagina_proyectos()
{
    echo '<div class="wrap">';
    echo '<h2>Página de Proyectos</h2>';

    // Conexión a la base de datos (reemplaza con tus datos de conexión)
    global $wpdb;

    // Consulta para obtener la lista de proyectos desde la base de datos
    $proyectos = $wpdb->get_results("SELECT * FROM proyectos");

    echo '<table class="widefat">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nombre del Proyecto</th>';
    echo '<th>Fecha de Inicio</th>';
    echo '<th>Fecha Estimada de Entrega</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($proyectos as $proyecto) {
        echo '<tr>';
        echo '<td>' . $proyecto->id . '</td>';
        echo '<td>' . $proyecto->nombre . '</td>';
        echo '<td>' . $proyecto->fecha_inicio . '</td>';
        echo '<td>' . $proyecto->fecha_entrega . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function mostrar_pagina_etapas()
{
    echo '<div class="wrap">';
    echo '<h2>Página de Etapas</h2>';

    // Conexión a la base de datos (reemplaza con tus datos de conexión)
    global $wpdb;

    // Consulta para obtener la lista de etapas desde la base de datos
    $etapas = $wpdb->get_results("SELECT * FROM etapas");

    echo '<table class="widefat">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nombre de la Etapa</th>';
    echo '<th>Estado</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($etapas as $etapa) {
        echo '<tr>';
        echo '<td>' . $etapa->id . '</td>';
        echo '<td>' . $etapa->nombre . '</td>';
        echo '<td>' . $etapa->estado . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
