<?php
// Asegúrate de que estás en el contexto de WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Obtener el número de consultorios desde la base de datos
function get_num_consultorios() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_settings';
    $result = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_key = %s", 'num_consultorios'));
    return intval($result);
}
?>

<div class="main-content">
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <?php
            $num_consultorios = get_num_consultorios();
            for ($i = 1; $i <= $num_consultorios; $i++) {
                ?>
                <div class="col-xl-4 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Consultorio <?php echo $i; ?></h5>
                            <p class="card-text">Detalles del consultorio <?php echo $i; ?>.</p>
                            <a href="#" class="btn ani-btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
