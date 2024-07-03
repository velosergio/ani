<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gestión de Profesionales</h4>
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
                        <div class="form-group">
                            <label>Especialidades</label>
                            <input type="text" id="specialty_name" name="specialties" class="form-control" autocomplete="off" required />
                            <div id="specialty_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                        <button type="submit" name="register_professional" class="btn btn-primary">Registrar Profesional</button>
                    </form>

                    <?php
                    if (isset($_POST['register_professional'])) {
                        ANI_Professionals::register_professional($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['specialties']);
                        echo '<div class="alert alert-success mt-3">Profesional registrado exitosamente</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#specialty_name').on('input', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'search_specialties',
                    'query': query
                },
                success: function(data) {
                    var results = JSON.parse(data);
                    var suggestions = '';
                    results.forEach(function(specialty) {
                        suggestions += '<div class="list-group-item suggestion-item-specialty" data-name="' + specialty.name + '">' + specialty.name + '</div>';
                    });
                    $('#specialty_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#specialty_suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion-item-specialty', function() {
        var name = $(this).data('name');
        $('#specialty_name').val(name);
        $('#specialty_suggestions').hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#specialty_name, #specialty_suggestions').length) {
            $('#specialty_suggestions').hide();
        }
    });
});
</script>
