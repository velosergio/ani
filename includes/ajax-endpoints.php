<?php
// Endpoint AJAX para buscar nombres de pacientes
add_action('wp_ajax_search_patients', 'search_patients');
function search_patients() {
    global $wpdb;
    $query = sanitize_text_field($_POST['query']);
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT name FROM {$wpdb->prefix}ani_patients WHERE name LIKE %s LIMIT 10",
        '%' . $wpdb->esc_like($query) . '%'
    ));
    echo json_encode($results);
    wp_die();
}

// Endpoint AJAX para buscar especialidades
add_action('wp_ajax_search_specialties', 'search_specialties');
function search_specialties() {
    global $wpdb;
    $query = sanitize_text_field($_POST['query']);
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT name FROM {$wpdb->prefix}ani_specialties WHERE name LIKE %s LIMIT 10",
        '%' . $wpdb->esc_like($query) . '%'
    ));
    echo json_encode($results);
    wp_die();
}

// Endpoint AJAX para obtener citas
add_action('wp_ajax_get_appointments', 'get_appointments');
function get_appointments() {
    global $wpdb;
    $appointments = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ani_appointments");
    $events = array();
    foreach ($appointments as $appointment) {
        $events[] = array(
            'title' => $appointment->specialty . ' - ' . $appointment->patient_name,
            'start' => $appointment->date
        );
    }
    echo json_encode($events);
    wp_die();
}

// Endpoint AJAX para obtener citas del día de hoy
add_action('wp_ajax_get_todays_appointments', 'get_todays_appointments');
function get_todays_appointments() {
    global $wpdb;
    $today = date('Y-m-d');
    $appointments = $wpdb->get_results($wpdb->prepare(
        "SELECT patient_name, specialty, date, time FROM {$wpdb->prefix}ani_appointments WHERE date = %s",
        $today
    ));
    $events = array();
    foreach ($appointments as $appointment) {
        $events[] = array(
            'patient_name' => $appointment->patient_name,
            'specialty' => $appointment->specialty,
            'date' => $appointment->date,
            'time' => $appointment->time
        );
    }
    echo json_encode($events);
    wp_die();
}
