<?php

class ANI_Patients {
    public static function register_patient($name, $email, $phone) {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_patients';

        $wpdb->insert($table, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ]);
    }

    public static function get_patients() {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_patients';
        return $wpdb->get_results("SELECT * FROM $table");
    }

    public static function get_patient_by_name($name) {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_patients';
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE name = %s", $name));
    }
}
?>
