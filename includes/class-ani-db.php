<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class ANI_DB {
    public static function install() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table_patients = $wpdb->prefix . 'ani_patients';
        $sql_patients = "CREATE TABLE $table_patients (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            email text NOT NULL,
            phone text NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $table_professionals = $wpdb->prefix . 'ani_professionals';
        $sql_professionals = "CREATE TABLE $table_professionals (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            email text NOT NULL,
            phone text NOT NULL,
            specialties text NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $table_specialties = $wpdb->prefix . 'ani_specialties';
        $sql_specialties = "CREATE TABLE $table_specialties (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $table_appointments = $wpdb->prefix . 'ani_appointments';
        $sql_appointments = "CREATE TABLE $table_appointments (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            patient_name tinytext NOT NULL,
            specialty tinytext NOT NULL,
            date date NOT NULL,
            time time NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $table_settings = $wpdb->prefix . 'ani_settings';
        $sql_settings = "CREATE TABLE $table_settings (
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            setting_key VARCHAR(191) NOT NULL,
            setting_value LONGTEXT NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY setting_key (setting_key)
        ) $charset_collate;";

        $table_consultorios = $wpdb->prefix . 'ani_consultorios';
        $sql_consultorios = "CREATE TABLE $table_consultorios (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nombre varchar(255) NOT NULL,
            horarios text NOT NULL,
            dias text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $table_asignaciones = $wpdb->prefix . 'ani_asignaciones';
        $sql_asignaciones = "CREATE TABLE $table_asignaciones (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            consultorio varchar(255) NOT NULL,
            profesional varchar(255) NOT NULL,
            dia text NOT NULL,
            horario text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_patients);
        dbDelta($sql_professionals);
        dbDelta($sql_specialties);
        dbDelta($sql_appointments);
        dbDelta($sql_settings);
        dbDelta($sql_consultorios);
        dbDelta($sql_asignaciones);
    }
}

?>
