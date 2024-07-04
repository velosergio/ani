# ANI - Plugin de Gestión para IPS

*versión 0.0.2*

ANI es un plugin de WordPress diseñado para gestionar la asignación de consultorios y la programación de citas en la institución de salud ANI IPS. Este plugin ayuda a optimizar la programación de citas, la gestión de profesionales y pacientes, y facilita el manejo de especialidades médicas.

## Características principales

1. **Gestión de Pacientes**:
   - Registro de pacientes con información básica (nombre, email, teléfono).
   - Listado de pacientes con opción de edición mediante un modal.
   - Uso de AJAX para actualizar información sin recargar la página.

2. **Gestión de Profesionales**:
   - Registro de profesionales con información básica y especialidades.
   - Listado de profesionales con opción de edición mediante un modal.
   - Especialidades gestionadas con Choices.js, permitiendo múltiples selecciones y adición de nuevas especialidades.
   - Nuevas especialidades se guardan automáticamente en la base de datos.

3. **Citas**:
   - Programación de citas con opciones de especialidades.
   - Visualización de citas programadas y citas del día en un calendario.
   - Manejo de horarios y consultorios disponibles.

4. **Configuración**:
   - Configuración de número de consultorios.
   - Guardado de configuraciones en la base de datos.

5. **Interfaz de Usuario**:
   - Diseño responsivo y moderno utilizando Argon Dashboard de Creative Tim.
   - Estilización personalizada de botones y componentes.

## Instalación

1. Clona este repositorio en la carpeta `wp-content/plugins` de tu instalación de WordPress:
   ```bash
   git clone https://github.com/velosergio/ani.git

## Funcionalidades

1. **Registro de Pacientes**:
   - Formulario para registrar datos personales de los pacientes.
   - Almacenamiento seguro de la información en la base de datos de WordPress.

2. **Registro de Profesionales**:
   - Formulario para registrar datos personales y especialidades de los profesionales.
   - Almacenamiento seguro de la información en la base de datos de WordPress.
   - Autocompletar para el campo de especialidades utilizando AJAX.

3. **Gestión de Especialidades**:
   - Registro de especialidades disponibles.
   - Listado de especialidades existentes.
   - Almacenamiento seguro de la información en la base de datos de WordPress.

4. **Scheduler**:
   - Programación de citas para pacientes con profesionales.
   - Autocompletar para el campo de nombre del paciente utilizando AJAX.
   - Autocompletar para el campo de especialidad utilizando AJAX.
   - Asignación automática de consultorios disponibles para las citas programadas.