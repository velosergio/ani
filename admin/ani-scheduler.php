<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Scheduler</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Nombre del paciente</label>
                            <input type="text" id="patient_name" name="patient_name" class="form-control" autocomplete="off" required />
                            <div id="patient_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label>Especialidad</label>
                            <input type="text" id="specialty_name" name="specialty" class="form-control" autocomplete="off" required />
                            <div id="specialty_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" id="date" name="date" class="form-control datepicker" required />
                        </div>
                        <div class="form-group">
                            <label>Hora</label>
                            <input type="time" name="time" class="form-control" required />
                        </div>
                        <button type="submit" name="schedule_appointment" class="btn btn-primary">Programar Cita</button>
                    </form>

                    <?php
                    if (isset($_POST['schedule_appointment'])) {
                        $patient_name = sanitize_text_field($_POST['patient_name']);
                        $specialty = sanitize_text_field($_POST['specialty']);
                        $date = sanitize_text_field($_POST['date']);
                        $time = sanitize_text_field($_POST['time']);
                        ANI_Scheduler::schedule_appointment($patient_name, $specialty, $date, $time);
                        echo '<div class="alert alert-success mt-3">Cita programada exitosamente</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
jQuery(document).ready(function($) {
    $('#patient_name').on('input', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'search_patients',
                    'query': query
                },
                success: function(data) {
                    var results = JSON.parse(data);
                    var suggestions = '';
                    results.forEach(function(patient) {
                        suggestions += '<div class="list-group-item suggestion-item-patient" data-name="' + patient.name + '">' + patient.name + '</div>';
                    });
                    $('#patient_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#patient_suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion-item-patient', function() {
        var name = $(this).data('name');
        $('#patient_name').val(name);
        $('#patient_suggestions').hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#patient_name, #patient_suggestions').length) {
            $('#patient_suggestions').hide();
        }
    });

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

    // Inicializar el datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
});
</script>
