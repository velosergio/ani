<h2>Gestión de Pacientes</h2>
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
            <td colspan="2"><input type="submit" name="register_patient" value="Registrar Paciente" /></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['register_patient'])) {
    ANI_Patients::register_patient($_POST['name'], $_POST['email'], $_POST['phone']);
    echo '<div>Paciente registrado exitosamente</div>';
}
?>
