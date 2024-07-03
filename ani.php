<?php
/*
Plugin Name: ANI
Description: Plugin para gestionar la asignación de consultorios y programación de citas en ANI IPS.
Version: 0.1
Author: ANI IPS
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Incluir archivos necesarios
include_once plugin_dir_path(__FILE__) . 'includes/class-ani-db.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ani-patients.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ani-professionals.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ani-specialties.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ani-scheduler.php';

// Activación del plugin: Crear tablas necesarias
function ani_activate() {
    ANI_DB::install();
}
register_activation_hook(__FILE__, 'ani_activate');

// Registro de menús en el administrador
function ani_admin_menu() {
    add_menu_page('ANI', 'ANI', 'manage_options', 'ani-admin', 'ani_admin_page', plugin_dir_url(__FILE__) . 'assets/ani.svg', 6);
    add_submenu_page('ani-admin', 'Pacientes', 'Pacientes', 'manage_options', 'ani-patients', 'ani_patients_page');
    add_submenu_page('ani-admin', 'Profesionales', 'Profesionales', 'manage_options', 'ani-professionals', 'ani_professionals_page');
    add_submenu_page('ani-admin', 'Especialidades', 'Especialidades', 'manage_options', 'ani-specialties', 'ani_specialties_page');
    add_submenu_page('ani-admin', 'Scheduler', 'Scheduler', 'manage_options', 'ani-scheduler', 'ani_scheduler_page');
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

// Endpoint AJAX para buscar especialidades
add_action('wp_ajax_search_specialties', 'search_specialties');
function search_specialties() {
    global $wpdb;
    $query = $_POST['query'];
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT name FROM {$wpdb->prefix}ani_specialties WHERE name LIKE %s LIMIT 10", 
        '%' . $wpdb->esc_like($query) . '%'
    ));
    echo json_encode($results);
    wp_die();
}

// Endpoint AJAX para buscar nombres de pacientes
add_action('wp_ajax_search_patients', 'search_patients');
function search_patients() {
    global $wpdb;
    $query = $_POST['query'];
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT name FROM {$wpdb->prefix}ani_patients WHERE name LIKE %s LIMIT 10", 
        '%' . $wpdb->esc_like($query) . '%'
    ));
    echo json_encode($results);
    wp_die();
}
