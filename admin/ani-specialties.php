<h2>Gestión de Especialidades</h2>
<form method="post" action="">
    <table>
        <tr>
            <th>Nombre de la Especialidad</th>
            <td><input type="text" name="name" required /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="register_specialty" value="Registrar Especialidad" /></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['register_specialty'])) {
    ANI_Specialties::register_specialty($_POST['name']);
    echo '<div>Especialidad registrada exitosamente</div>';
}

$specialties = ANI_Specialties::get_specialties();
if ($specialties) {
    echo '<h3>Lista de Especialidades</h3>';
    echo '<ul>';
    foreach ($specialties as $specialty) {
        echo '<li>' . esc_html($specialty->name) . '</li>';
    }
    echo '</ul>';
}
?>
