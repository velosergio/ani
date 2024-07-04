<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gestión de Especialidades</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Nombre de la Especialidad</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <button type="submit" name="register_specialty" class="btn ani-btn-primary">Registrar Especialidad</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 mt-4">
    <div class="card w-100">
        <div class="card-header">
            <h4 class="card-title">Lista de Especialidades</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Especialidad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function ani_register_specialty($name) {
                            global $wpdb;
                            $table_name = $wpdb->prefix . 'ani_specialties';

                            $wpdb->insert(
                                $table_name,
                                array(
                                    'name' => sanitize_text_field($name)
                                ),
                                array(
                                    '%s'
                                )
                            );
                        }

                        function ani_get_specialties() {
                            global $wpdb;
                            $table_name = $wpdb->prefix . 'ani_specialties';

                            return $wpdb->get_results("SELECT id, name FROM $table_name");
                        }

                        function ani_update_specialty($id, $name) {
                            global $wpdb;
                            $table_name = $wpdb->prefix . 'ani_specialties';

                            $wpdb->update(
                                $table_name,
                                array('name' => sanitize_text_field($name)),
                                array('id' => intval($id)),
                                array('%s'),
                                array('%d')
                            );
                        }

                        function ani_delete_specialty($id) {
                            global $wpdb;
                            $table_name = $wpdb->prefix . 'ani_specialties';

                            $wpdb->delete(
                                $table_name,
                                array('id' => intval($id)),
                                array('%d')
                            );
                        }

                        if (isset($_POST['register_specialty'])) {
                            ani_register_specialty($_POST['name']);
                            echo '<div class="alert alert-success mt-3">Especialidad registrada exitosamente</div>';
                        }

                        if (isset($_POST['edit_specialty'])) {
                            ani_update_specialty($_POST['edit_id'], $_POST['edit_name']);
                            echo '<div class="alert alert-success mt-3">Especialidad actualizada exitosamente</div>';
                        }

                        if (isset($_POST['delete_specialty'])) {
                            ani_delete_specialty($_POST['delete_id']);
                            echo '<div class="alert alert-success mt-3">Especialidad eliminada exitosamente</div>';
                        }

                        $specialties = ani_get_specialties();
                        if ($specialties) {
                            foreach ($specialties as $specialty) {
                                echo '<tr>';
                                echo '<td>' . esc_html($specialty->name) . '</td>';
                                echo '<td>
                                        <a href="#" class="btn ani-btn-primary" data-bs-toggle="modal" data-bs-target="#editSpecialtyModal" data-id="' . esc_attr($specialty->id) . '" data-name="' . esc_attr($specialty->name) . '"><i class="ni ni-settings-gear-65"></i></a>
                                        <form method="post" action="" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="' . esc_attr($specialty->id) . '">
                                            <button type="submit" name="delete_specialty" class="btn btn-danger"><i class="ni ni-fat-remove"></i></button>
                                        </form>
                                      </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="2">No hay especialidades registradas.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editSpecialtyModal" tabindex="-1" role="dialog" aria-labelledby="editSpecialtyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecialtyModalLabel">Editar Especialidad</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label>Nombre de la Especialidad</label>
                        <input type="text" name="edit_name" id="edit_name" class="form-control" required />
                    </div>
                    <input type="hidden" name="edit_id" id="edit_id" />
                    <button type="submit" name="edit_specialty" class="btn ani-btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editSpecialtyModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');

        var modalTitle = editModal.querySelector('.modal-title');
        var modalBodyInput = editModal.querySelector('#edit_name');
        var modalBodyId = editModal.querySelector('#edit_id');

        modalTitle.textContent = 'Editar Especialidad: ' + name;
        modalBodyInput.value = name;
        modalBodyId.value = id;
    });
});
</script>
