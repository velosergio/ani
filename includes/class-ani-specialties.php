<?php

class ANI_Specialties {
    public static function register_specialty($name) {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_specialties';

        $wpdb->insert($table, [
            'name' => $name
        ]);
    }

    public static function get_specialties() {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_specialties';
        return $wpdb->get_results("SELECT * FROM $table");
    }
}
?>
