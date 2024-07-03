<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gestión de Pacientes</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="phone" class="form-control" required />
                        </div>
                        <button type="submit" name="register_patient" class="btn btn-primary">Registrar Paciente</button>
                    </form>

                    <?php
                    if (isset($_POST['register_patient'])) {
                        ANI_Patients::register_patient($_POST['name'], $_POST['email'], $_POST['phone']);
                        echo '<div class="alert alert-success mt-3">Paciente registrado exitosamente</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>