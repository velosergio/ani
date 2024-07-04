<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Citas Programadas</h4>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Citas de Hoy</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Especialidad</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody id="todays-appointments">
                            <tr>
                                <td colspan="3">Cargando citas...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />

<script>
jQuery(document).ready(function($) {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_appointments'
                },
                success: function(data) {
                    var events = JSON.parse(data);
                    successCallback(events);
                },
                error: function() {
                    failureCallback([]);
                }
            });
        }
    });
    calendar.render();

    // Function to convert 24-hour time to 12-hour time with AM/PM
    function formatTime(time) {
        var [hour, minute, second] = time.split(':');
        var ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12; // Convert to 12-hour format
        return hour + ':' + minute + ' ' + ampm;
    }

    // Fetch today's appointments
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_todays_appointments'
        },
        success: function(data) {
            var appointments = JSON.parse(data);
            var tbody = $('#todays-appointments');
            tbody.empty();
            if (appointments.length === 0) {
                tbody.append('<tr><td colspan="3">No hay citas para hoy.</td></tr>');
            } else {
                appointments.forEach(function(appointment) {
                    tbody.append('<tr><td>' + appointment.patient_name + '</td><td>' + appointment.specialty + '</td><td>' + formatTime(appointment.time) + '</td></tr>');
                });
            }
        },
        error: function() {
            var tbody = $('#todays-appointments');
            tbody.empty();
            tbody.append('<tr><td colspan="3">Error al cargar las citas.</td></tr>');
        }
    });
});
</script>
