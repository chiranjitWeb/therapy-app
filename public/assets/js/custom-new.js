document.addEventListener("DOMContentLoaded", function () {
    const mql = window.matchMedia('(min-width: 761px)');
    const body = document.body;
    const nav = document.querySelector('.main-menu-nav');
    const btn = document.querySelector('.btn-toggle-nav');
    const overlay = document.querySelector('.menu-overlay');

    const isDesktop = () => mql.matches;

    function openSidebar() {
        if (isDesktop()) {
            nav.classList.remove('open-nav');   // expand
            body.classList.remove('on-padding');
            overlay?.classList.remove('active');
        } else {
            nav.classList.add('open-nav');      // slide in
            body.classList.add('on-padding');
            overlay?.classList.add('active');
        }
        btn.querySelector('i').classList.remove('la-times');
        btn.querySelector('i').classList.add('la-bars');
    }

    function closeSidebar() {
        if (isDesktop()) {
            nav.classList.add('open-nav');      // collapse
            body.classList.add('on-padding');
            overlay?.classList.remove('active');
        } else {
            nav.classList.remove('open-nav');   // slide out
            body.classList.remove('on-padding');
            overlay?.classList.remove('active');
        }
        btn.querySelector('i').classList.remove('la-bars');
        btn.querySelector('i').classList.add('la-times');
    }

    // Button click
    btn.addEventListener('click', function () {
        const navHas = nav.classList.contains('open-nav');
        if (isDesktop()) {
            navHas ? openSidebar() : closeSidebar();
        } else {
            navHas ? closeSidebar() : openSidebar();
        }
    });

    // Hover to expand on desktop
    document.querySelectorAll('.main-menu-nav .nav-primary > li > a').forEach(link => {
        link.addEventListener('mouseenter', () => {
            if (isDesktop()) openSidebar();
        });
    });

    nav.addEventListener('mouseleave', () => {
        if (isDesktop()) closeSidebar();
    });

    // Overlay click (mobile)
    overlay?.addEventListener('click', closeSidebar);

    // Keep state sane on resize
    mql.addEventListener('change', () => {
        closeSidebar();
    });

    // --- Dropdown Menu ---
    const icon = document.getElementById('userIcon');
    const menu = document.getElementById('dropdownMenu');

    document.addEventListener('click', function (e) {
        if (icon.contains(e.target)) {
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        } else if (!menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
});


/****Dashboard calender script***/
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("datepicker01");
  
    // Set minimum selectable date (tomorrow)
    const today = new Date();
    today.setDate(today.getDate() + 1);
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, "0");
    const dd = String(today.getDate()).padStart(2, "0");
    const minDate = new Date(`${yyyy}-${mm}-${dd}`);
  
    // Create a simple calendar container
    const calendar = document.createElement("div");
    calendar.style.position = "absolute";
    calendar.style.background = "#fff";
    calendar.style.border = "1px solid #ccc";
    calendar.style.padding = "8px";
    calendar.style.display = "none";
    calendar.style.zIndex = "1000";
    document.body.appendChild(calendar);
  
    function buildCalendar(date = new Date()) {
      calendar.innerHTML = ""; // Clear previous calendar
      const month = date.getMonth();
      const year = date.getFullYear();
  
      const firstDay = new Date(year, month, 1);
      const lastDay = new Date(year, month + 1, 0);
  
      const header = document.createElement("div");
      header.style.textAlign = "center";
      header.style.marginBottom = "5px";
  
      const monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
      header.textContent = `${monthNames[month]} ${year}`;
      calendar.appendChild(header);
  
      const grid = document.createElement("div");
      grid.style.display = "grid";
      grid.style.gridTemplateColumns = "repeat(7, 1fr)";
      grid.style.gap = "2px";
  
      // Day labels
      ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"].forEach(d => {
        const cell = document.createElement("div");
        cell.style.fontWeight = "bold";
        cell.style.textAlign = "center";
        cell.textContent = d;
        grid.appendChild(cell);
      });
  
      // Blank cells before first day
      for (let i = 0; i < firstDay.getDay(); i++) {
        const cell = document.createElement("div");
        grid.appendChild(cell);
      }
  
      // Days
      for (let d = 1; d <= lastDay.getDate(); d++) {
        const cellDate = new Date(year, month, d);
        const cell = document.createElement("button");
        cell.textContent = d;
        cell.style.padding = "4px";
        cell.style.border = "none";
        cell.style.background = "transparent";
        cell.style.cursor = cellDate >= minDate ? "pointer" : "not-allowed";
        cell.disabled = cellDate < minDate;
  
        if (!cell.disabled) {
          cell.addEventListener("click", () => {
            const mmStr = String(cellDate.getMonth() + 1).padStart(2, "0");
            const ddStr = String(cellDate.getDate()).padStart(2, "0");
            input.value = `${cellDate.getFullYear()}-${mmStr}-${ddStr}`;
            calendar.style.display = "none";
          });
        }
  
        grid.appendChild(cell);
      }
  
      calendar.appendChild(grid);
    }
  
    input.addEventListener("focus", () => {
      const rect = input.getBoundingClientRect();
      calendar.style.top = `${rect.bottom + window.scrollY}px`;
      calendar.style.left = `${rect.left + window.scrollX}px`;
      calendar.style.display = "block";
      buildCalendar();
    });
  
    document.addEventListener("click", (e) => {
      if (!calendar.contains(e.target) && e.target !== input) {
        calendar.style.display = "none";
      }
    });
  });

/****End Dashboard calender script***/



/****Custom toast message***/
class ToastManager {
    constructor() {
        this.container = document.getElementById('toast-container');
        if (!this.container) {
            console.error('Toast container not found');
            return;
        }
        
        // Process any toasts from server-side flash messages
        this.processServerToasts();
    }
    
    show(message, type = 'success', duration = 4000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        toast.innerHTML = `
            <div class="toast-body">
                <span class="toast-message">${this.escapeHtml(message)}</span>
                <button type="button" class="toast-close" aria-label="Close">&times;</button>
            </div>
        `;
        
        this.container.appendChild(toast);
        
        // Force reflow for transition
        void toast.offsetWidth;
        
        // Show toast with animation
        toast.classList.add('show');
        
        // Set up close button
        const closeButton = toast.querySelector('.toast-close');
        closeButton.addEventListener('click', () => this.hide(toast));
        
        // Auto-hide after duration if specified
        if (duration > 0) {
            setTimeout(() => this.hide(toast), duration);
        }
        
        return toast;
    }
    
    hide(toast) {
        if (!toast.parentNode) return;
        
        toast.classList.remove('show');
        
        // Remove after transition completes
        const removeToast = () => {
            if (toast.parentNode === this.container) {
                this.container.removeChild(toast);
            }
            toast.removeEventListener('transitionend', removeToast);
        };
        
        toast.addEventListener('transitionend', removeToast);
    }
    
    processServerToasts() {
        // Get the toast data element
        const toastDataEl = document.getElementById('toast-data');
        if (!toastDataEl) return;
        
        // Check for server-side flash messages
        const toastDataStr = toastDataEl.getAttribute('data-toast');
        if (toastDataStr) {
            try {
                const toastData = JSON.parse(toastDataStr);
                this.show(toastData.message, toastData.type);
            } catch (e) {
                console.error('Error parsing toast data:', e);
            }
        }
        
        // Check for validation errors
        const errorsStr = toastDataEl.getAttribute('data-errors');
        if (errorsStr) {
            try {
                const errors = JSON.parse(errorsStr);
                errors.forEach(error => this.show(error, 'error'));
            } catch (e) {
                console.error('Error parsing error data:', e);
            }
        }
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}
/****End Custom toast message***/

// Initialize toast manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.toastManager = new ToastManager();
});

