import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// CALENDAR

const reserveFormDiv = document.getElementById("make-reserve-form");

if (document.getElementById("calendar")) {
    const slotMinTime = document.getElementById("slotMinTime").value;
    const slotMaxTime = document.getElementById("slotMaxTime").value;

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

            slotMinTime,
            slotMaxTime,

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
        let optionsHTML = `<option value="">Choose</option>`;

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

function goBack() {
    event.preventDefault();

    window.history.back();
}

function hideThis(e) {
    document.getElementById(e).classList.add("hidden");
}

let priceTiemout;

function isPrice() {
    clearTimeout(priceTiemout);

    priceTiemout = setTimeout(async () => {
        const price = document.getElementById("price").value;

        if (price != "") {
            const result = await fetch(`/admin/price/isPrice/${price}`);

            if (result.status === 404) {
                priceNotFound();
            } else {
                priceFound();
            }
        }
    }, 500);
}

function priceFound() {
    const messagefField = document.getElementById("priceMessage");
    const submitButton = document.getElementById("submitButton");

    messagefField.innerText = "Price already exist.";
    submitButton.disabled = true;
    submitButton.classList.add("cursor-not-allowed");
}

function priceNotFound() {
    const messagefField = document.getElementById("priceMessage");
    const submitButton = document.getElementById("submitButton");

    messagefField.innerText = "";
    submitButton.disabled = false;
    submitButton.classList.remove("cursor-not-allowed");
}

function redirectToCreatePrice(event, url) {
    event.preventDefault();

    const worktypeName = document.getElementById("worktypeName").value;
    const duration = document.getElementById("duration").value;

    if (worktypeName) url += `&worktypeName=${worktypeName}`;
    if (duration) url += `&duration=${duration}`;

    location.href = url;
}

function confirmWorktypeDelete(event) {
    if (!confirm("This will delete all associated appointment!")) {
        event.preventDefault();
    }
}

window.confirmWorktypeDelete = confirmWorktypeDelete;
window.redirectToCreatePrice = redirectToCreatePrice;
window.isPrice = isPrice;
window.hideThis = hideThis;
window.goBack = goBack;
window.goToDashboard = goToDashboard;
window.closeReserveFormDiv = closeReserveFormDiv;
window.setEndDate = setEndDate;
