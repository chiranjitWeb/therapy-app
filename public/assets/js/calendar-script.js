document.addEventListener("DOMContentLoaded", function () {
  class Calendar {
    constructor(container, options = {}) {
      this.container = container;
      this.options = options;
      this.currentDate = new Date();
      this.eventsByDate = {};
      this.selectedDate = null;

      this.init();
    }

    init() {
      this.render();
      this.fetchEventsForMonth();
      this.setupEventListeners();
    }

    render() {
      const monthName = this.currentDate.toLocaleString("pl-PL", {
        month: "long",
        year: "numeric"
      });

      this.container.querySelector(".calendar-title").textContent = monthName;

      const daysOfWeek = ["P", "W", "S", "C", "P", "S", "N"];
      const grid = this.container.querySelector(".calendar-grid");
      grid.innerHTML = "";

      // Day headers
      daysOfWeek.forEach(day => {
        const dayElement = document.createElement("div");
        dayElement.className = "calendar-day-header";
        dayElement.textContent = day;
        grid.appendChild(dayElement);
      });

      const firstDayOfMonth = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth(),
        1
      ).getDay();

      const adjustedFirstDay = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;
      const daysInMonth = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth() + 1,
        0
      ).getDate();

      const lastDayOfPrevMonth = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth(),
        0
      ).getDate();

      // Previous month days
      for (let i = adjustedFirstDay - 1; i >= 0; i--) {
        const prevMonthDay = lastDayOfPrevMonth - i;
        this.createDayElement(prevMonthDay, true, -1);
      }

      // Current month days
      for (let day = 1; day <= daysInMonth; day++) {
        this.createDayElement(day);
      }

      // Next month days
      const totalDaysShown = adjustedFirstDay + daysInMonth;
      const remainingCells = (totalDaysShown <= 35 ? 35 : 42) - totalDaysShown;

      for (let i = 1; i <= remainingCells; i++) {
        this.createDayElement(i, true, 1);
      }
    }

    createDayElement(day, isOtherMonth = false, monthOffset = 0) {
      const grid = this.container.querySelector(".calendar-grid");
      const dayElement = document.createElement("div");

      let date;
      if (isOtherMonth) {
        date = new Date(
          this.currentDate.getFullYear(),
          this.currentDate.getMonth() + monthOffset,
          day
        );
        dayElement.className = "calendar-day other-month";
      } else {
        date = new Date(
          this.currentDate.getFullYear(),
          this.currentDate.getMonth(),
          day
        );
        dayElement.className = "calendar-day";

        if (this.isToday(date)) {
          dayElement.classList.add("today");
        }

        if (this.isDateSelected(date)) {
          dayElement.classList.add("selected");
        }
      }

      const dateString = date.toISOString().split("T")[0];
      const eventCount = this.eventsByDate[dateString] || 0;

      dayElement.innerHTML = `
        <span class="day-number">${day}</span>
        ${eventCount > 0 ? `
          <div class="event-indicators"><i class="las la-smile"></i></div>
        ` : ""}
      `;

      dayElement.addEventListener("click", () => {
        if (!isOtherMonth) {
          this.selectedDate = date;
          this.render();

          if (this.options.onDateSelect) {
            this.options.onDateSelect(this.selectedDate);
          }
        } else {
          // Switch month if clicking other-month date
          this.currentDate = new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth() + monthOffset,
            1
          );
          this.fetchEventsForMonth();
        }
      });

      grid.appendChild(dayElement);
    }

    async fetchEventsForMonth() {
      try {
        const startDate = new Date(
          this.currentDate.getFullYear(),
          this.currentDate.getMonth(),
          1
        );
        const endDate = new Date(
          this.currentDate.getFullYear(),
          this.currentDate.getMonth() + 1,
          0
        );

        // Mock demo events
        const mockEvents = this.generateMockEvents(startDate, endDate);
        const eventsMap = {};

        mockEvents.forEach((event) => {
          const date = event.date_start.split("T")[0];
          eventsMap[date] = (eventsMap[date] || 0) + 1;
        });

        this.eventsByDate = eventsMap;
        this.render();
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    }

    generateMockEvents(startDate, endDate) {
      const events = [];
      const days = (endDate - startDate) / (1000 * 60 * 60 * 24);

      for (let i = 0; i <= days; i++) {
        const date = new Date(startDate);
        date.setDate(date.getDate() + i);

        if (Math.random() > 0.7) {
          events.push({
            id: Math.floor(Math.random() * 1000),
            date_start: date.toISOString()
          });
        }
      }

      return events;
    }

    isToday(date) {
      const today = new Date();
      return (
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
      );
    }

    isDateSelected(date) {
      return (
        this.selectedDate &&
        this.selectedDate.getTime() === date.getTime()
      );
    }

    setupEventListeners() {
      this.container
        .querySelector(".prev-month")
        .addEventListener("click", () => {
          this.currentDate = new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth() - 1
          );
          this.fetchEventsForMonth();
        });

      this.container
        .querySelector(".next-month")
        .addEventListener("click", () => {
          this.currentDate = new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth() + 1
          );
          this.fetchEventsForMonth();
        });
    }
  }

  // Init calendar
  const calendar = new Calendar(document.getElementById("calendar-app"), {
    onDateSelect: (date) => {
      console.log("Selected date:", date);
    }
  });
});

