import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// CALENDAR

const reserveFormDiv = document.getElementById("make-reserve-form");

if (document.getElementById("calendar")) {
    document.addEventListener("DOMContentLoaded", async function () {
        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: "hu",
            firstDay: 1,
            handleWindowResize: true,

            initialView: "timeGridWeek",

            headerToolbar: {
                start: "title",
                center: "",
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
}

async function select(selectInfo) {
    const startDate = document.getElementById("start-date");
    //make a request to check what work type available in the available time
    const availableWorkTypes = await getAvailableWorkTypes();

    reserveFormDiv.classList.remove("hidden");

    startDate.value = selectInfo.startStr.substring(0, 19);
}

async function getAvailableWorkTypes() {}

function closeReserveFormDiv() {
    document.getElementById("make-reserve-form").classList.add("hidden");
}

function setEndDate() {
    const selected = document.getElementById("title");

    const startDate = document.getElementById("start-date");
    const endDate = document.getElementById("end-date");
    const startDateDate = new Date(startDate.value);

    const newEndDateRaw = new Date(
        startDateDate.getTime() + selected.value * 60000
    );
    let newEndDate = newEndDateRaw
        .toLocaleDateString()
        .replaceAll(". ", "-")
        .substring(0, 10);

    let hours = String(newEndDateRaw.getHours()).padStart(2, "0");
    let minute = String(newEndDateRaw.getMinutes()).padStart(2, "0");
    let newEndTime = `${hours}:${minute}`;

    endDate.value = `${newEndDate}T${newEndTime}`;

    document.getElementById("workId").value =
        selected.options[selected.options.selectedIndex].id;
}

window.closeReserveFormDiv = closeReserveFormDiv;
window.setEndDate = setEndDate;
