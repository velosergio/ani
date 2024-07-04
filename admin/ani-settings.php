<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Incluir el archivo de funciones de WordPress
require_once(ABSPATH . 'wp-admin/includes/template.php');

$num_consultorios = ani_get_setting('num_consultorios');

if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div class="alert alert-success mt-3">Configuración guardada exitosamente</div>';
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Configuración de Consultorios</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="ani_save_settings">
                        <div class="form-group">
                            <label>Número de Consultorios</label>
                            <input type="number" name="ani_num_consultorios" class="form-control" value="<?php echo esc_attr($num_consultorios); ?>" required />
                        </div>
                        <?php submit_button('Guardar cambios', 'primary', 'submit', true, array('class' => 'btn btn-primary')); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
