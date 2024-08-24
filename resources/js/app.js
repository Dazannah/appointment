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
            locale: "en",
            firstDay: 1,
            handleWindowResize: true,

            initialView: "timeGridWeek",

            headerToolbar: {
                start: "title",
                center: "",
                end: "today prev,next",
            },

            /*buttonText: {
                today: "ma",
                month: "hónap",
                week: "hét",
                day: "nap",
            },*/

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
    startDate.value = selectInfo.startStr.substring(0, 19);

    const availableWorkTypes = await getAvailableWorkTypes(startDate.value);

    if (availableWorkTypes.length === 0) {
        const noAvailableDiv = document.getElementById("no-available-div");

        noAvailableDiv.innerHTML = `Whit this starting time there is not available work types:<br>${startDate.value.replace(
            "T",
            " "
        )}`;
        noAvailableDiv.classList.remove("hidden");
    } else {
        let optionsHTML = `<option value="">Válasz</option>`;

        availableWorkTypes.forEach((workType) => {
            optionsHTML += `<option id="${workType.id}" value="${workType.duration}">${workType.name} ${workType.duration} min ${workType.price.price} HUF</option>`;
        });

        const options = document.getElementById("title");
        options.innerHTML = optionsHTML;

        const optionsDiv = document.getElementById("options-div");
        optionsDiv.classList.remove("hidden");
    }
    reserveFormDiv.classList.remove("hidden");
}

async function getAvailableWorkTypes(startDate) {
    const getAvailableWorkTypes = await fetch(
        `/get-available-work-types?startDate=${startDate}`
    );

    const availableWorkTypes = await getAvailableWorkTypes.json();

    return availableWorkTypes;
}

function closeReserveFormDiv() {
    document.getElementById("start-date").value = null;
    document.getElementById("end-date").value = null;
    document.getElementById("make-reserve-form").classList.add("hidden");
    document.getElementById("options-div").classList.add("hidden");
    document.getElementById("no-available-div").classList.add("hidden");
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

function goToDashboard() {
    event.preventDefault();

    window.location.href = "/dashboard";
}

window.goToDashboard = goToDashboard;
window.closeReserveFormDiv = closeReserveFormDiv;
window.setEndDate = setEndDate;
