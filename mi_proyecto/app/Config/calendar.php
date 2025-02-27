<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Dinámico</title>
    <!-- Metronic CSS -->
    <link href="path/to/metronic/assets/css/style.bundle.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Calendario Dinámico</h2>
        <div id="calendar"></div>
    </div>
 
    <!-- Metronic JS -->
    <script src="path/to/metronic/assets/js/scripts.bundle.js"></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 
    <script>
        $(document).ready(function () {
            const calendarEl = document.getElementById('calendar');
 
            // Inicializar FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
 
                // Cargar eventos desde el servidor
                events: function(fetchInfo, successCallback, failureCallback) {
                 
                },
 
                // Añadir evento
                select: function (info) {
                    const title = prompt('Título del evento:');
                    if (title) {
                    
                    }
                },
 
                // Eliminar evento
                eventClick: function (info) {
                    if (confirm('¿Deseas eliminar este evento?')) {
                      
                    }
                }
            });
 
            calendar.render();
        });
    </script>
</body>
</html>