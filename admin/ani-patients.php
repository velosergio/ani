<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;
$table_name = $wpdb->prefix . 'ani_patients';
$patients = $wpdb->get_results("SELECT * FROM $table_name");

if (isset($_POST['action']) && $_POST['action'] == 'update_patient') {
    $id = intval($_POST['patient_id']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $wpdb->update($table_name, array('name' => $name, 'email' => $email, 'phone' => $phone), array('id' => $id));
    echo '<div class="alert alert-success mt-3">Paciente actualizado exitosamente</div>';
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gestión de Pacientes</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" autocomplete="name" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="email" required />
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" name="phone" id="phone" class="form-control" autocomplete="tel" required />
                        </div>
                        <button type="submit" name="register_patient" class="btn ani-btn-primary">Registrar Paciente</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-header">
                    <h4 class="card-title">Lista de Pacientes</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patients as $patient) : ?>
                                    <tr>
                                        <td><?php echo esc_html($patient->name); ?></td>
                                        <td><?php echo esc_html($patient->email); ?></td>
                                        <td><?php echo esc_html($patient->phone); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm ani-btn-primary" data-bs-toggle="modal" data-bs-target="#editPatientModal" data-id="<?php echo esc_attr($patient->id); ?>" data-name="<?php echo esc_attr($patient->name); ?>" data-email="<?php echo esc_attr($patient->email); ?>" data-phone="<?php echo esc_attr($patient->phone); ?>"><i class="ni ni-settings-gear-65"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar paciente -->
<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Editar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_patient">
                    <input type="hidden" name="patient_id" id="edit_patient_id">
                    <div class="form-group">
                        <label for="edit_name">Nombre</label>
                        <input type="text" name="name" id="edit_name" class="form-control" autocomplete="name" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" autocomplete="email" required />
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Teléfono</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" autocomplete="tel" required />
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
    $('#editPatientModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var phone = button.data('phone');
        var modal = $(this);
        modal.find('#edit_patient_id').val(id);
        modal.find('#edit_name').val(name);
        modal.find('#edit_email').val(email);
        modal.find('#edit_phone').val(phone);
    });

    // Manejar el envío del formulario del modal
    $('#editPatientModal form').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario

        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Cerrar el modal y recargar la página
                $('#editPatientModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Hubo un error al actualizar el paciente.');
            }
        });
    });
});
</script>
