# ANI - Plugin de Gestión para IPS

*versión 0.0.3*

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

3. **Gestión de Consultorios**:
   - Registro de consultorios con horarios y días disponibles.
   - Listado de consultorios con opción de edición y eliminación mediante un modal.
   - Actualización automática del número de consultorios en la configuración global.
   - Disposición de consultorios en vista semanal, mostrando asignaciones de profesionales.

4. **Citas**:
   - Programación de citas con opciones de especialidades.
   - Visualización de citas programadas y citas del día en un calendario.
   - Manejo de horarios y consultorios disponibles.

5. **Configuración**:
   - Configuración de número de consultorios.
   - Guardado de configuraciones en la base de datos.

6. **Interfaz de Usuario**:
   - Diseño responsivo y moderno utilizando Argon Dashboard de Creative Tim.
   - Estilización personalizada de botones y componentes.

## Instalación

1. Clona este repositorio en la carpeta `wp-content/plugins` de tu instalación de WordPress:
   ```bash
   git clone https://github.com/velosergio/ani.git