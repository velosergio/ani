<?php

class ANI_Professionals {
    public static function register_professional($name, $email, $phone, $specialties) {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_professionals';

        $wpdb->insert($table, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'specialties' => $specialties
        ]);
    }

    public static function get_professionals() {
        global $wpdb;
        $table = $wpdb->prefix . 'ani_professionals';
        return $wpdb->get_results("SELECT * FROM $table");
    }
}
?>
