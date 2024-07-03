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
                        <button type="submit" name="register_specialty" class="btn btn-primary">Registrar Especialidad</button>
                    </form>

                    <?php
                    if (isset($_POST['register_specialty'])) {
                        ANI_Specialties::register_specialty($_POST['name']);
                        echo '<div class="alert alert-success mt-3">Especialidad registrada exitosamente</div>';
                    }

                    $specialties = ANI_Specialties::get_specialties();
                    if ($specialties) {
                        echo '<h3 class="mt-4">Lista de Especialidades</h3>';
                        echo '<ul class="list-group">';
                        foreach ($specialties as $specialty) {
                            echo '<li class="list-group-item">' . esc_html($specialty->name) . '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
