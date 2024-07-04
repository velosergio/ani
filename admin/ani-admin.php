<?php
// Asegúrate de que estás en el contexto de WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Procesar la actualización o registro del consultorio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'asignar_consultorio' && check_admin_referer('asignar_consultorio_nonce')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ani_asignaciones';

        $consultorio = sanitize_text_field($_POST['consultorio']);
        $profesional = sanitize_text_field($_POST['profesional']);
        $dia = sanitize_text_field($_POST['dia']);
        $horario = sanitize_text_field($_POST['horario']);

        $wpdb->insert($table_name, array(
            'consultorio' => $consultorio,
            'profesional' => $profesional,
            'dia' => $dia,
            'horario' => $horario,
        ));

        echo '<div class="alert alert-success mt-3">Consultorio asignado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
        exit;
    }
}

// Obtener el número de consultorios desde la base de datos
function get_num_consultorios() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_settings';
    $result = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_key = %s", 'num_consultorios'));
    return intval($result);
}

// Obtener los consultorios desde la base de datos
function get_consultorios() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_consultorios';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Obtener las asignaciones desde la base de datos
function get_asignaciones() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_asignaciones';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Obtener los profesionales desde la base de datos
function get_profesionals(){
    global $wpdb;
    $table_professionals = $wpdb->prefix . 'ani_professionals';
    return $wpdb->get_results("SELECT * FROM $table_professionals");
}

$num_consultorios = get_num_consultorios();
$consultorios = get_consultorios();
$asignaciones = get_asignaciones();
$professionals = get_profesionals();
?>

<div class="main-content">
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button class="btn ani-btn-primary" data-bs-toggle="modal" data-bs-target="#asignarConsultorioModal">Asignar Consultorio</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="card w-100">
            <div class="card-header">
                <h4 class="card-title">Disposición de Consultorios</h4>
            </div>
            <div class="card-body">
                <h5>Mañana (8AM - 12PM)</h5>
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Consultorio</th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sábado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultorios as $consultorio): ?>
                                <tr>
                                    <td><?php echo esc_html($consultorio->nombre); ?></td>
                                    <?php
                                    $dias_semana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                    foreach ($dias_semana as $dia):
                                        $asignacion_texto = '';
                                        foreach ($asignaciones as $asignacion) {
                                            if ($asignacion->consultorio === $consultorio->nombre && $asignacion->dia === $dia && $asignacion->horario === '8AM - 12PM') {
                                                $asignacion_texto .= $asignacion->profesional . ' - ' . $asignacion->horario . '<br>';
                                            }
                                        }
                                        ?>
                                        <td><?php echo $asignacion_texto ? $asignacion_texto : 'Libre'; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <h5>Tarde (2PM - 6PM)</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Consultorio</th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sábado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultorios as $consultorio): ?>
                                <tr>
                                    <td><?php echo esc_html($consultorio->nombre); ?></td>
                                    <?php
                                    $dias_semana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                    foreach ($dias_semana as $dia):
                                        $asignacion_texto = '';
                                        foreach ($asignaciones as $asignacion) {
                                            if ($asignacion->consultorio === $consultorio->nombre && $asignacion->dia === $dia && $asignacion->horario === '2PM - 6PM') {
                                                $asignacion_texto .= $asignacion->profesional . ' - ' . $asignacion->horario . '<br>';
                                            }
                                        }
                                        ?>
                                        <td><?php echo $asignacion_texto ? $asignacion_texto : 'Libre'; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para asignar consultorio -->
<div class="modal fade" id="asignarConsultorioModal" tabindex="-1" role="dialog" aria-labelledby="asignarConsultorioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarConsultorioModalLabel">Asignar Consultorio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <?php wp_nonce_field('asignar_consultorio_nonce'); ?>
                <input type="hidden" name="action" value="asignar_consultorio">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="consultorio">Consultorio</label>
                        <select name="consultorio" id="consultorio" class="form-control" required>
                            <?php foreach ($consultorios as $consultorio): ?>
                                <option value="<?php echo esc_attr($consultorio->nombre); ?>"><?php echo esc_html($consultorio->nombre); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profesional">Profesional</label>
                        <select name="profesional" id="profesional" class="form-control" required>
                            <?php foreach ($professionals as $professional): ?>
                                <option value="<?php echo esc_attr($professional->name); ?>" data-especialidades="<?php echo esc_attr($professional->specialties); ?>"><?php echo esc_html($professional->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="especializacion">Especialización</label>
                        <input type="text" name="especializacion" id="especializacion" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label for="dia">Día de la semana</label>
                        <select name="dia" id="dia" class="form-control" required>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horario">Horario</label>
                        <select name="horario" id="horario" class="form-control" required>
                            <option value="8AM - 12PM">Mañana (8AM - 12PM)</option>
                            <option value="2PM - 6PM">Tarde (2PM - 6PM)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn ani-btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Llenar el campo de especialización al seleccionar un profesional
    $('#profesional').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var especialidades = selectedOption.data('especialidades');
        $('#especializacion').val(especialidades);
    });

    // Manejar el envío del formulario del modal
    $('#asignarConsultorioModal form').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario

        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Cerrar el modal y recargar la página
                $('#asignarConsultorioModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Hubo un error al asignar el consultorio.');
            }
        });
    });
});
</script>
