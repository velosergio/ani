<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Configuración de Consultorios</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Número de Consultorios Disponibles</label>
                            <input type="number" name="num_consultorios" class="form-control" value="<?php echo esc_attr(get_ani_setting('num_consultorios')); ?>" required />
                        </div>
                        <button type="submit" name="save_changes" class="btn ani-btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['save_changes'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_settings';

    $num_consultorios = sanitize_text_field($_POST['num_consultorios']);
    $wpdb->replace(
        $table_name,
        array(
            'setting_key' => 'num_consultorios',
            'setting_value' => $num_consultorios,
        ),
        array(
            '%s',
            '%d',
        )
    );

    // Redireccionar para evitar reenvío del formulario
    echo '<meta http-equiv="refresh" content="0;url=' . esc_url($_SERVER['REQUEST_URI']) . '">';
    exit;
}

function get_ani_setting($key) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_settings';
    $result = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_key = %s", $key));
    return $result;
}
?>
