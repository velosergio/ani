<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;
$table_name = $wpdb->prefix . 'ani_professionals';
$specialties_table = $wpdb->prefix . 'ani_specialties';
$professionals = $wpdb->get_results("SELECT * FROM $table_name");
$specialties = $wpdb->get_results("SELECT name FROM $specialties_table");

// Procesar la actualización o registro del profesional
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update_professional' && check_admin_referer('update_professional_nonce')) {
        $id = intval($_POST['professional_id']);
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $specialties = array_map('sanitize_text_field', $_POST['specialties']);

        // Insertar nuevas especialidades en la base de datos si no existen
        foreach ($specialties as $specialty) {
            $existing_specialty = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $specialties_table WHERE name = %s", $specialty));
            if ($existing_specialty == 0) {
                $wpdb->insert($specialties_table, array('name' => $specialty));
            }
        }

        $specialties_string = implode(',', $specialties); // Convertir array a string separado por comas
        $wpdb->update($table_name, array(
            'name' => $name, 
            'email' => $email, 
            'phone' => $phone, 
            'specialties' => $specialties_string
        ), array('id' => $id));

        echo '<div class="alert alert-success mt-3">Profesional actualizado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
    } elseif (isset($_POST['register_professional']) && check_admin_referer('register_professional_nonce')) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $specialties = array_map('sanitize_text_field', $_POST['specialties']);

        // Insertar nuevas especialidades en la base de datos si no existen
        foreach ($specialties as $specialty) {
            $existing_specialty = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $specialties_table WHERE name = %s", $specialty));
            if ($existing_specialty == 0) {
                $wpdb->insert($specialties_table, array('name' => $specialty));
            }
        }

        $specialties_string = implode(',', $specialties); // Convertir array a string separado por comas
        $wpdb->insert($table_name, array(
            'name' => $name, 
            'email' => $email, 
            'phone' => $phone, 
            'specialties' => $specialties_string
        ));

        echo '<div class="alert alert-success mt-3">Profesional registrado exitosamente</div>';
        echo '<script>window.location.reload();</script>'; // Recargar la página
    }
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gestión de Profesionales</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <?php wp_nonce_field('register_professional_nonce'); ?>
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
                        <div class="form-group">
                            <label for="specialties">Especialidades</label>
                            <select id="specialties" name="specialties[]" class="form-control" multiple></select>
                        </div>
                        <button type="submit" name="register_professional" class="btn ani-btn-primary">Registrar Profesional</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-header">
                    <h4 class="card-title">Lista de Profesionales</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Especialidades</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($professionals as $professional) : ?>
                                    <tr>
                                        <td><?php echo esc_html($professional->name); ?></td>
                                        <td><?php echo esc_html($professional->email); ?></td>
                                        <td><?php echo esc_html($professional->phone); ?></td>
                                        <td><?php echo esc_html($professional->specialties); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm ani-btn-primary" data-bs-toggle="modal" data-bs-target="#editProfessionalModal" data-id="<?php echo esc_attr($professional->id); ?>" data-name="<?php echo esc_attr($professional->name); ?>" data-email="<?php echo esc_attr($professional->email); ?>" data-phone="<?php echo esc_attr($professional->phone); ?>" data-specialties="<?php echo esc_attr($professional->specialties); ?>"><i class="ni ni-settings-gear-65"></i></a>
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

<!-- Modal para editar profesional -->
<div class="modal fade" id="editProfessionalModal" tabindex="-1" role="dialog" aria-labelledby="editProfessionalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfessionalModalLabel">Editar Profesional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <?php wp_nonce_field('update_professional_nonce'); ?>
                <input type="hidden" name="action" value="update_professional">
                <input type="hidden" name="professional_id" id="edit_professional_id">
                <div class="modal-body">
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
                    <div class="form-group">
                        <label for="edit_specialties">Especialidades</label>
                        <select id="edit_specialties" name="specialties[]" class="form-control" multiple></select>
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
    // Inicializar Choices.js para los campos de especialidades
    var specialtyOptions = <?php echo json_encode(array_map(function($specialty) { return $specialty->name; }, $specialties)); ?>;
    var specialtyChoices = specialtyOptions.map(function(specialty) {
        return { value: specialty, label: specialty };
    });

    new Choices('#specialties', {
        removeItemButton: true,
        choices: specialtyChoices,
        addItems: true
    });

    $('#editProfessionalModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var phone = button.data('phone');
        var specialties = button.data('specialties').split(',');
        var modal = $(this);
        modal.find('#edit_professional_id').val(id);
        modal.find('#edit_name').val(name);
        modal.find('#edit_email').val(email);
        modal.find('#edit_phone').val(phone);
        var editSpecialtiesChoices = new Choices('#edit_specialties', {
            removeItemButton: true,
            choices: specialtyChoices,
            addItems: true
        });
        editSpecialtiesChoices.clearStore();
        specialties.forEach(function(specialty) {
            editSpecialtiesChoices.setValue([{value: specialty, label: specialty, selected: true}]);
        });
    });

    // Manejar el envío del formulario del modal
    $('#editProfessionalModal form').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario

        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Cerrar el modal y recargar la página
                $('#editProfessionalModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Hubo un error al actualizar el profesional.');
            }
        });
    });
});
</script>
