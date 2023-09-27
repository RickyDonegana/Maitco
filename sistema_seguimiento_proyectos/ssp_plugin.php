<?php
/*
Plugin Name: Sistema de Seguimiento de Proyectos
Description: Un plugin para el seguimiento de proyectos web.
Version: 1.0
Author: Ricardo Donegana y Agustín Fernández
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
// Definir la página de opciones del plugin

function ssp_plugin_options_page()
{
    add_menu_page(
        'Opciones del Sistema de Seguimiento de Proyectos',
        'Seguimiento de Proyectos',
        'manage_options',
        'ssp-settings',
        'ssp_render_options_page'
    );
}

// Función para renderizar la página de opciones
function ssp_render_options_page()
{
?>
    <div class="wrap">
        <h2>Opciones del Sistema de Seguimiento de Proyectos</h2>
        <form method="post" action="options.php">
            <?php
            // Agregar campos ocultos para seguridad
            settings_fields('ssp_settings_group');
            do_settings_sections('ssp-settings');
            submit_button('Guardar Cambios');
            ?>
        </form>
    </div>
<?php
}

// Función para renderizar el campo de opción
function ssp_option_field_callback()
{
    $option = get_option('ssp_option', ''); // Obtener el valor actual de la opción
    echo '<input type="text" name="ssp_option" value="' . esc_attr($option) . '" />';
}

// Inicializar las opciones del plugin
function ssp_initialize_options()
{
    add_settings_section(
        'ssp_general_settings_section',
        'Configuración General',
        'ssp_general_section_callback',
        'ssp-settings'
    );

    add_settings_field(
        'ssp_option_field',
        'Opción de Ejemplo',
        'ssp_option_field_callback',
        'ssp-settings',
        'ssp_general_settings_section'
    );

    register_setting(
        'ssp_settings_group',
        'ssp_option'
    );
}

// Función para renderizar la sección de configuración general
function ssp_general_section_callback()
{
    echo '<p>Configuración general del plugin</p>';
}

// Agregar acciones para inicializar el plugin y la página de opciones
add_action('admin_init', 'ssp_initialize_options');
add_action('admin_menu', 'ssp_plugin_options_page');
?>