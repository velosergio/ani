<h2>Scheduler</h2>
<form method="post" action="">
    <table>
        <tr>
            <th>Nombre del paciente</th>
            <td>
                <input type="text" id="patient_name" name="patient_name" autocomplete="off" required />
                <div id="patient_suggestions" style="border: 1px solid #ccc; display: none; max-height: 150px; overflow-y: auto;"></div>
            </td>
        </tr>
        <tr>
            <th>Especialidad</th>
            <td>
                <input type="text" id="specialty_name" name="specialty" autocomplete="off" required />
                <div id="specialty_suggestions" style="border: 1px solid #ccc; display: none; max-height: 150px; overflow-y: auto;"></div>
            </td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><input type="date" name="date" required /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="schedule_appointment" value="Programar Cita" /></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['schedule_appointment'])) {
    // Obtener el ID del paciente a partir del nombre
    $patient_name = $_POST['patient_name'];
    $patient = ANI_Patients::get_patient_by_name($patient_name);
    if ($patient) {
        ANI_Scheduler::schedule_appointment($patient->id, $_POST['specialty'], $_POST['date']);
        echo '<div>Cita programada exitosamente</div>';
    } else {
        echo '<div>No se encontró al paciente</div>';
    }
}
?>

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
                        suggestions += '<div class="suggestion-item" data-name="' + patient.name + '">' + patient.name + '</div>';
                    });
                    $('#patient_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#patient_suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion-item', function() {
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
                        suggestions += '<div class="suggestion-item" data-name="' + specialty.name + '">' + specialty.name + '</div>';
                    });
                    $('#specialty_suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#specialty_suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion-item', function() {
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
