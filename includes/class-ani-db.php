<?php

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

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_patients);
        dbDelta($sql_professionals);
        dbDelta($sql_specialties);
    }
}
?>
