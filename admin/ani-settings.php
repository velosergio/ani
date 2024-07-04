<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;
$table_name = $wpdb->prefix . 'ani_consultorios';
$settings_table = $wpdb->prefix . 'ani_settings';
$consultorios = $wpdb->get_results("SELECT * FROM $table_name");

// Función para actualizar el número de consultorios en la tabla ani_settings
function actualizar_num_consultorios() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ani_consultorios';
    $settings_table = $wpdb->prefix . 'ani_settings';
    
    $num_consultorios = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $wpdb->update($settings_table, array('setting_value' => $num_consultorios), array('setting_key' => 'num_consultorios'));
}

// Procesar la actualización o registro del consultorio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update_consultorio' && check_admin_referer('update_consultorio_nonce')) {
        $id = intval($_POST['consultorio_id']);
        $nombre = sanitize_text_field($_POST['consultorio_nombre']);
        $horarios = isset($_POST['consultorio_horarios']) ? array_map('sanitize_text_field', $_POST['consultorio_horarios']) : [];
        $dias = isset($_POST['consultorio_dias']) ? array_map('sanitize_text_field', $_POST['consultorio_dias']) : [];

        $horarios_string = json_encode($horarios); // Convertir array a JSON
        $dias_string = json_encode($dias); // Convertir array a JSON

        $wpdb->update($table_name, array(
            'nombre' => $nombre, 
            'horarios' => $horarios_string, 
            'dias' => $dias_string
        ), array('id' => $id));

        echo '<div class="alert alert-success mt-3">Consultorio actualizado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
    } elseif (isset($_POST['action']) && $_POST['action'] == 'register_consultorio' && check_admin_referer('register_consultorio_nonce')) {
        $nombre = sanitize_text_field($_POST['consultorio_nombre']);
        $horarios = isset($_POST['consultorio_horarios']) ? array_map('sanitize_text_field', $_POST['consultorio_horarios']) : [];
        $dias = isset($_POST['consultorio_dias']) ? array_map('sanitize_text_field', $_POST['consultorio_dias']) : [];

        $horarios_string = json_encode($horarios); // Convertir array a JSON
        $dias_string = json_encode($dias); // Convertir array a JSON

        $wpdb->insert($table_name, array(
            'nombre' => $nombre, 
            'horarios' => $horarios_string, 
            'dias' => $dias_string
        ));

        // Actualizar el número de consultorios
        actualizar_num_consultorios();

        echo '<div class="alert alert-success mt-3">Consultorio registrado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete_consultorio' && check_admin_referer('delete_consultorio_nonce')) {
        $id = intval($_POST['consultorio_id']);
        $wpdb->delete($table_name, array('id' => $id));

        // Actualizar el número de consultorios
        actualizar_num_consultorios();

        echo '<div class="alert alert-success mt-3">Consultorio eliminado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Agregar Consultorio</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <?php wp_nonce_field('register_consultorio_nonce'); ?>
                        <input type="hidden" name="action" value="register_consultorio">
                        <div class="form-group">
                            <label for="consultorio_nombre">Nombre del Consultorio</label>
                            <input type="text" name="consultorio_nombre" id="consultorio_nombre" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Horarios Disponibles</label><br>
                            <label for="horario_8_12"><input type="checkbox" name="consultorio_horarios[]" value="8AM - 12PM" id="horario_8_12"> 8AM - 12PM</label><br>
                            <label for="horario_2_6"><input type="checkbox" name="consultorio_horarios[]" value="2PM - 6PM" id="horario_2_6"> 2PM - 6PM</label>
                        </div>
                        <div class="form-group">
                            <label>Días Disponibles</label><br>
                            <label for="dia_lunes"><input type="checkbox" name="consultorio_dias[]" value="Lunes" id="dia_lunes"> Lunes</label><br>
                            <label for="dia_martes"><input type="checkbox" name="consultorio_dias[]" value="Martes" id="dia_martes"> Martes</label><br>
                            <label for="dia_miercoles"><input type="checkbox" name="consultorio_dias[]" value="Miércoles" id="dia_miercoles"> Miércoles</label><br>
                            <label for="dia_jueves"><input type="checkbox" name="consultorio_dias[]" value="Jueves" id="dia_jueves"> Jueves</label><br>
                            <label for="dia_viernes"><input type="checkbox" name="consultorio_dias[]" value="Viernes" id="dia_viernes"> Viernes</label><br>
                            <label for="dia_sabado"><input type="checkbox" name="consultorio_dias[]" value="Sábado" id="dia_sabado"> Sábado</label>
                        </div>
                        <button type="submit" class="btn ani-btn-primary">Agregar Consultorio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card w-100">
                <div class="card-header">
                    <h4 class="card-title">Consultorios Existentes</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Horarios</th>
                                    <th>Días</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($consultorios as $consultorio) {
                                    $horarios = json_decode($consultorio->horarios, true);
                                    $dias = json_decode($consultorio->dias, true);

                                    $horarios = is_array($horarios) ? implode(", ", $horarios) : 'Datos inválidos';
                                    $dias = is_array($dias) ? implode(", ", $dias) : 'Datos inválidos';

                                    echo "<tr>
                                            <td>{$consultorio->nombre}</td>
                                            <td>{$horarios}</td>
                                            <td>{$dias}</td>
                                            <td>
                                                <button class='btn ani-btn-primary edit-button' data-id='{$consultorio->id}' data-nombre='{$consultorio->nombre}' data-horarios='" . htmlspecialchars($consultorio->horarios, ENT_QUOTES, 'UTF-8') . "' data-dias='" . htmlspecialchars($consultorio->dias, ENT_QUOTES, 'UTF-8') . "' data-bs-toggle='modal' data-bs-target='#editConsultorioModal'><i class='ni ni-settings-gear-65'></i></button>
                                                <button class='btn btn-danger delete-button' data-id='{$consultorio->id}' data-bs-toggle='modal' data-bs-target='#deleteConsultorioModal'><i class='ni ni-fat-remove'></i></button>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar consultorio -->
<div class="modal fade" id="editConsultorioModal" tabindex="-1" role="dialog" aria-labelledby="editConsultorioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editConsultorioModalLabel">Editar Consultorio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <?php wp_nonce_field('update_consultorio_nonce'); ?>
                <input type="hidden" name="action" value="update_consultorio">
                <input type="hidden" name="consultorio_id" id="edit_consultorio_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre del Consultorio</label>
                        <input type="text" name="consultorio_nombre" id="edit_nombre" class="form-control" autocomplete="name" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_horarios">Horarios Disponibles</label><br>
                        <label for="edit_horario_8_12"><input type="checkbox" name="consultorio_horarios[]" value="8AM - 12PM" id="edit_horario_8_12"> 8AM - 12PM</label><br>
                        <label for="edit_horario_2_6"><input type="checkbox" name="consultorio_horarios[]" value="2PM - 6PM" id="edit_horario_2_6"> 2PM - 6PM</label>
                    </div>
                    <div class="form-group">
                        <label for="edit_dias">Días Disponibles</label><br>
                        <label for="edit_dia_lunes"><input type="checkbox" name="consultorio_dias[]" value="Lunes" id="edit_dia_lunes"> Lunes</label><br>
                        <label for="edit_dia_martes"><input type="checkbox" name="consultorio_dias[]" value="Martes" id="edit_dia_martes"> Martes</label><br>
                        <label for="edit_dia_miercoles"><input type="checkbox" name="consultorio_dias[]" value="Miércoles" id="edit_dia_miercoles"> Miércoles</label><br>
                        <label for="edit_dia_jueves"><input type="checkbox" name="consultorio_dias[]" value="Jueves" id="edit_dia_jueves"> Jueves</label><br>
                        <label for="edit_dia_viernes"><input type="checkbox" name="consultorio_dias[]" value="Viernes" id="edit_dia_viernes"> Viernes</label><br>
                        <label for="edit_dia_sabado"><input type="checkbox" name="consultorio_dias[]" value="Sábado" id="edit_dia_sabado"> Sábado</label>
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

<!-- Modal para eliminar consultorio -->
<div class="modal fade" id="deleteConsultorioModal" tabindex="-1" role="dialog" aria-labelledby="deleteConsultorioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConsultorioModalLabel">Eliminar Consultorio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este consultorio?</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="">
                    <?php wp_nonce_field('delete_consultorio_nonce'); ?>
                    <input type="hidden" name="action" value="delete_consultorio">
                    <input type="hidden" name="consultorio_id" id="delete_consultorio_id">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#editConsultorioModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var horarios = button.data('horarios');
        var dias = button.data('dias');

        try {
            horarios = JSON.parse(horarios);
            dias = JSON.parse(dias);
        } catch (e) {
            console.error('Invalid JSON data:', e);
            horarios = [];
            dias = [];
        }

        var modal = $(this);

        modal.find('#edit_consultorio_id').val(id);
        modal.find('#edit_nombre').val(nombre);
        modal.find('#edit_horario_8_12').prop('checked', horarios.includes('8AM - 12PM'));
        modal.find('#edit_horario_2_6').prop('checked', horarios.includes('2PM - 6PM'));
        modal.find('#edit_dia_lunes').prop('checked', dias.includes('Lunes'));
        modal.find('#edit_dia_martes').prop('checked', dias.includes('Martes'));
        modal.find('#edit_dia_miercoles').prop('checked', dias.includes('Miércoles'));
        modal.find('#edit_dia_jueves').prop('checked', dias.includes('Jueves'));
        modal.find('#edit_dia_viernes').prop('checked', dias.includes('Viernes'));
        modal.find('#edit_dia_sabado').prop('checked', dias.includes('Sábado'));
    });

    $('#deleteConsultorioModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);

        modal.find('#delete_consultorio_id').val(id);
    });

    // Manejar el envío del formulario del modal de edición
    $('#editConsultorioModal form').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario

        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Cerrar el modal y recargar la página
                $('#editConsultorioModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Hubo un error al actualizar el consultorio.');
            }
        });
    });

    // Manejar el envío del formulario del modal de eliminación
    $('#deleteConsultorioModal form').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario

        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Cerrar el modal y recargar la página
                $('#deleteConsultorioModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Hubo un error al eliminar el consultorio.');
            }
        });
    });
});
</script>
