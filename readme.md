# Proyecto ANI

## Descripción

ANI es un plugin de WordPress desarrollado para gestionar la asignación de consultorios y la programación de citas en ANI IPS, una institución de salud con énfasis en neuropsicología. Este plugin permite registrar pacientes y profesionales, y facilita la asignación automática de consultorios para las citas programadas, asegurando que cada profesional tenga una agenda llena y optimizada.

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

## Avances

### Estructura del Plugin

- **Archivo Principal (`ani.php`)**:
  - Configuración del plugin.
  - Inclusión de archivos necesarios.
  - Registro de menús en el administrador.
  - Endpoints AJAX para buscar nombres de pacientes y especialidades.

- **Base de Datos**:
  - Creación de tablas para pacientes, profesionales y especialidades.
  - Funciones para registrar y obtener pacientes, profesionales y especialidades.

- **Formulario de Registro de Pacientes**:
  - Eliminación del campo de especialidades.

- **Formulario de Registro de Profesionales**:
  - Eliminación del campo de horarios.
  - Implementación de autocompletar para el campo de especialidades.

- **Formulario de Scheduler**:
  - Cambio del campo ID a "Nombre del paciente".
  - Implementación de autocompletar para el campo de nombre del paciente.
  - Implementación de autocompletar para el campo de especialidad.
