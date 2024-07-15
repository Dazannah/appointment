<x-app-layout>
  <div id='calendar' class="w-3/4 mx-auto"></div>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

  <script>
    document.addEventListener('DOMContentLoaded', async function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "hu",
        firstDay: 1,
        handleWindowResize: true,

        initialView: 'timeGridWeek',

        headerToolbar: {
          start: 'title',
          center: 'dayGridDay,timeGridWeek,dayGridMonth',
          end: 'today prev,next'
        },

        buttonText:{
          today: 'ma',
          month: 'hónap',
          week: 'hét',
          day: 'nap',
        },

        weekends: false,

        dayHeaderFormat:{
          weekday: 'long'
        },

        slotDuration: '00:15:00',
        slotLabelInterval: '00:15:00',
        slotLabelFormat:{
          hour: 'numeric',
          minute: '2-digit',
          meridiem: 'long'
        },

        slotMinTime: '08:00:00',
        slotMaxTime: '16:00:00',
        
        navLinks: true,
        weekNumbers: true,
        weekText: "",

        selectable: true,
        selectOverlap: false,

        businessHours: {
          daysOfWeek: [ 1, 2, 3, 4, 5],
          startTime: '08:00',
          endTime: '16:00'
        },

        events: '/get-events',
      });

      calendar.render();      
    });
  </script>
</x-app-layout>