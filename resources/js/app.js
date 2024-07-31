import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// CALENDAR

const reserveFormDiv = document.getElementById("make-reserve-form");

document.addEventListener("DOMContentLoaded", async function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "hu",
        firstDay: 1,
        handleWindowResize: true,

        initialView: "timeGridWeek",

        headerToolbar: {
            start: "title",
            center: "dayGridDay,timeGridWeek,dayGridMonth",
            end: "today prev,next",
        },

        buttonText: {
            today: "ma",
            month: "hónap",
            week: "hét",
            day: "nap",
        },

        weekends: false,

        dayHeaderFormat: {
            weekday: "long",
        },

        slotDuration: "00:15:00",
        slotLabelInterval: "00:15:00",
        slotLabelFormat: {
            hour: "numeric",
            minute: "2-digit",
            meridiem: "long",
        },

        slotMinTime: "08:00:00",
        slotMaxTime: "16:00:00",

        navLinks: true,
        weekNumbers: true,
        weekText: "",

        selectable: true,
        selectOverlap: false,
        select: select,

        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5],
            startTime: "08:00",
            endTime: "16:00",
        },

        events: "/get-events",
    });

    calendar.render();
});

function select(selectInfo) {
    const startDate = document.getElementById("start-date");
    const endDate = document.getElementById("end-date");
    reserveFormDiv.classList.remove("hidden");

    startDate.value = selectInfo.startStr.substring(0, 19);
    endDate.value = selectInfo.endStr.substring(0, 19);
}
