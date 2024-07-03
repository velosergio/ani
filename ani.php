<?php
/*
Plugin Name: ANI
Description: Plugin para gestionar la asignación de consultorios y citas en ANI IPS.
Version: 0.1
Author: ANI IPS
*/

defined('ABSPATH') or die('No script kiddies please!');

// Incluir archivos necesarios
include_once(plugin_dir_path(__FILE__) . 'includes/class-ani-db.php');
include_once(plugin_dir_path(__FILE__) . 'includes/class-ani-patients.php');
include_once(plugin_dir_path(__FILE__) . 'includes/class-ani-professionals.php');
include_once(plugin_dir_path(__FILE__) . 'includes/class-ani-specialties.php');
include_once(plugin_dir_path(__FILE__) . 'includes/class-ani-scheduler.php');
include_once(plugin_dir_path(__FILE__) . 'includes/ajax-endpoints.php');

// Crear tablas en la activación del plugin
register_activation_hook(__FILE__, array('ANI_DB', 'install'));

// Encolar estilos y scripts
function ani_enqueue_admin_styles() {
    wp_enqueue_style('argon-dashboard-css', plugin_dir_url(__FILE__) . 'assets/css/argon-dashboard.css');
    wp_enqueue_style('nucleo-icons', plugin_dir_url(__FILE__) . 'assets/css/nucleo-icons.css');
    wp_enqueue_style('nucleo-svg', plugin_dir_url(__FILE__) . 'assets/css/nucleo-svg.css');
    wp_enqueue_script('argon-dashboard-js', plugin_dir_url(__FILE__) . 'assets/js/plugins/argon-dashboard.min.js', array('jquery'), null, true);
    wp_enqueue_style('fullcalendar-css', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css');
}

function ani_enqueue_admin_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('argon-dashboard-js', plugin_dir_url(__FILE__) . 'assets/js/plugins/argon-dashboard.min.js', array('jquery'), null, true);
    wp_enqueue_script('fullcalendar-js', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'ani_enqueue_admin_styles');
add_action('admin_enqueue_scripts', 'ani_enqueue_admin_scripts');

// Añadir menús de administración
function ani_admin_menu() {
    add_menu_page('ANI', 'ANI', 'manage_options', 'ani-admin', 'ani_admin_page', plugin_dir_url(__FILE__) . 'assets/ani.svg', 6);
    add_submenu_page('ani-admin', 'Pacientes', 'Pacientes', 'manage_options', 'ani-patients', 'ani_patients_page');
    add_submenu_page('ani-admin', 'Profesionales', 'Profesionales', 'manage_options', 'ani-professionals', 'ani_professionals_page');
    add_submenu_page('ani-admin', 'Especialidades', 'Especialidades', 'manage_options', 'ani-specialties', 'ani_specialties_page');
    add_submenu_page('ani-admin', 'Scheduler', 'Scheduler', 'manage_options', 'ani-scheduler', 'ani_scheduler_page');
    add_submenu_page('ani-admin', 'Citas', 'Citas', 'manage_options', 'ani-appointments', 'ani_appointments_page');
}

add_action('admin_menu', 'ani_admin_menu');

function ani_admin_page() {
    echo '<h1>ANI - Panel de Control</h1>';
}

function ani_patients_page() {
    include plugin_dir_path(__FILE__) . 'admin/ani-patients.php';
}

function ani_professionals_page() {
    include plugin_dir_path(__FILE__) . 'admin/ani-professionals.php';
}

function ani_specialties_page() {
    include plugin_dir_path(__FILE__) . 'admin/ani-specialties.php';
}

function ani_scheduler_page() {
    include plugin_dir_path(__FILE__) . 'admin/ani-scheduler.php';
}

function ani_appointments_page() {
    include plugin_dir_path(__FILE__) . 'admin/ani-appointments.php';
}
