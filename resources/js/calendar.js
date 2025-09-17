document.addEventListener("DOMContentLoaded", () => {
    const monthSelect = document.getElementById("month-select");
    const yearSelect = document.getElementById("year-select");
    const calendarDaysContainer = document.getElementById("calendar-days");

    // Populate year dropdown
    const currentYear = new Date().getFullYear();
    for (let i = currentYear - 10; i <= currentYear + 10; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.textContent = i;
        if (i === currentYear) option.selected = true;
        yearSelect.appendChild(option);
    }

    // Function to render calendar
    const renderCalendar = () => {
        const year = parseInt(yearSelect.value, 10);
        const month = parseInt(monthSelect.value, 10);

        // Calculate first day of the month and total days
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        // Clear existing calendar days
        calendarDaysContainer.innerHTML = "";

        // Add blank cells for days before the first day of the month
        for (let i = 0; i < firstDayOfMonth; i++) {
            const blankCell = document.createElement("div");
            blankCell.className = "text-gray-300";
            blankCell.textContent = "";
            calendarDaysContainer.appendChild(blankCell);
        }

        // Add cells for each day of the month
        for (let day = 1; day <= totalDays; day++) {
            const dayCell = document.createElement("div");
            dayCell.textContent = day;
            dayCell.className =
                "p-2 bg-gray-100 rounded hover:bg-blue-200 cursor-pointer";
            calendarDaysContainer.appendChild(dayCell);
        }
    };

    // Event listeners for dropdowns
    monthSelect.addEventListener("change", renderCalendar);
    yearSelect.addEventListener("change", renderCalendar);

    // Initial rendering of calendar
    renderCalendar();
});