<?php

class ANI_Scheduler {
    public static function schedule_appointment($patient_name, $specialty, $date, $time) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ani_appointments';

        $wpdb->insert(
            $table_name,
            array(
                'patient_name' => $patient_name,
                'specialty' => $specialty,
                'date' => $date,
                'time' => $time
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );
    }
}

?>
