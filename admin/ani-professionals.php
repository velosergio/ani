<h2>Gestión de Profesionales</h2>
<form method="post" action="">
    <table>
        <tr>
            <th>Nombre</th>
            <td><input type="text" name="name" required /></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><input type="email" name="email" required /></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><input type="text" name="phone" required /></td>
        </tr>
        <tr>
            <th>Especialidades</th>
            <td>
                <input type="text" id="specialty_name" name="specialties" autocomplete="off" required />
                <div id="specialty_suggestions" style="border: 1px solid #ccc; display: none; max-height: 150px; overflow-y: auto;"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="register_professional" value="Registrar Profesional" /></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['register_professional'])) {
    ANI_Professionals::register_professional($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['specialties']);
    echo '<div>Profesional registrado exitosamente</div>';
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
