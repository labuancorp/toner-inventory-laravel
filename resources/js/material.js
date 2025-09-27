import * as Popper from '@popperjs/core';
import 'bootstrap';
import '@tabler/core/dist/js/tabler.min.js';
import PerfectScrollbar from 'perfect-scrollbar';
import { Chart, LineController, LineElement, PointElement, LinearScale, TimeScale, CategoryScale, Tooltip, Legend, PieController, ArcElement, BarController, BarElement } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, TimeScale, CategoryScale, Tooltip, Legend, PieController, ArcElement, BarController, BarElement);

function initPerfectScrollbar() {
  try {
    const el = document.querySelector('#sidenav-scrollbar');
    if (el) {
      // Initialize with default options; safe if element exists
      new PerfectScrollbar(el);
    }
  } catch (e) {
    // Swallow errors to avoid breaking the page
    console.warn('PerfectScrollbar init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initPerfectScrollbar);

function initMovementsChart() {
  try {
    const ctx = document.getElementById('movementsChart');
    const payload = window.__movementsChartData;
    if (!ctx || !payload) return;

    const { labels, inSeries, outSeries } = payload;
    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Stock In',
            data: inSeries,
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            tension: 0.3,
          },
          {
            label: 'Stock Out',
            data: outSeries,
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.2)',
            tension: 0.3,
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          tooltip: { enabled: true }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  } catch (e) {
    console.warn('Chart init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initMovementsChart);

function initAnalyticsCharts() {
  try {
    const tsEl = document.getElementById('analyticsMovementsChart');
    const tsPayload = window.__analyticsTimeseries;
    if (tsEl && tsPayload) {
      const { labels, inSeries, outSeries } = tsPayload;
      new Chart(tsEl, {
        type: 'line',
        data: {
          labels,
          datasets: [
            {
              label: 'Stock In',
              data: inSeries,
              borderColor: '#4CAF50',
              backgroundColor: 'rgba(76, 175, 80, 0.2)',
              tension: 0.3,
            },
            {
              label: 'Stock Out',
              data: outSeries,
              borderColor: '#F44336',
              backgroundColor: 'rgba(244, 67, 54, 0.2)',
              tension: 0.3,
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'top' },
            tooltip: { enabled: true }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    }

    const pieEl = document.getElementById('categoryPieChart');
    const piePayload = window.__categoryDistribution;
    if (pieEl && piePayload && piePayload.labels?.length) {
      const colors = piePayload.labels.map((_, idx) => {
        const hue = (idx * 47) % 360;
        return `hsl(${hue}, 70%, 55%)`;
      });
      new Chart(pieEl, {
        type: 'pie',
        data: {
          labels: piePayload.labels,
          datasets: [
            {
              data: piePayload.series,
              backgroundColor: colors,
              borderWidth: 1,
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'right' },
            tooltip: { enabled: true }
          }
        }
      });
    }
  } catch (e) {
    console.warn('Analytics charts init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initAnalyticsCharts);

function initYearlyBarChart() {
  try {
    const el = document.getElementById('yearlyOutBarChart');
    const payload = window.__yearlyByCategory;
    if (!el || !payload || !payload.labels?.length) return;
    const colors = payload.labels.map((_, idx) => {
      const hue = (idx * 37) % 360;
      return `hsl(${hue}, 65%, 55%)`;
    });
    new Chart(el, {
      type: 'bar',
      data: {
        labels: payload.labels,
        datasets: [
          {
            label: 'Total OUT',
            data: payload.series,
            backgroundColor: colors,
            borderWidth: 0,
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: { enabled: true }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  } catch (e) {
    console.warn('Yearly bar chart init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initYearlyBarChart);

// Theme toggling with persistence
function applyStoredTheme() {
  try {
    const stored = localStorage.getItem('theme') || 'light';
    const body = document.body;
    if (!body.classList.contains('material-layout')) return;
    if (stored === 'dark') {
      body.classList.add('material-dark');
      document.documentElement.classList.add('dark');
      document.documentElement.setAttribute('data-bs-theme', 'dark');
    } else {
      body.classList.remove('material-dark');
      document.documentElement.classList.remove('dark');
      document.documentElement.setAttribute('data-bs-theme', 'light');
    }
    const switchEl = document.getElementById('themeSwitch');
    if (switchEl) switchEl.checked = stored === 'dark';
  } catch (e) {
    console.warn('Theme apply skipped:', e?.message || e);
  }
}

function initThemeToggle() {
  try {
    applyStoredTheme();
    const switchEl = document.getElementById('themeSwitch');
    if (!switchEl) return;
    switchEl.addEventListener('change', (e) => {
      const isDark = !!e.target.checked;
      const body = document.body;
      if (!body.classList.contains('material-layout')) return;
      if (isDark) {
        body.classList.add('material-dark');
        localStorage.setItem('theme', 'dark');
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-bs-theme', 'dark');
      } else {
        body.classList.remove('material-dark');
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-bs-theme', 'light');
      }
    });
  } catch (e) {
    console.warn('Theme toggle init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initThemeToggle);

// Enhance accessibility: preserve focus outlines globally
try {
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
      document.body.classList.add('user-is-tabbing');
    }
  });
} catch (e) {
  // no-op
}

// Persistent notification toast with order details
function initNotificationToasts() {
  try {
    const collapse = document.getElementById('notifCollapse');
    const container = document.getElementById('notifToastContainer');
    if (!collapse || !container) return;
    const persistMs = parseInt(collapse.getAttribute('data-persist-ms') || '12000', 10);
    const autohideAttr = (collapse.getAttribute('data-autohide') || '').toLowerCase();
    const autoHide = !(autohideAttr === 'false' || autohideAttr === '0');
    const items = collapse.querySelectorAll('.dropdown-item');
    items.forEach((item) => {
      item.addEventListener('click', (e) => {
        const hasOrder =
          item.dataset.orderId ||
          item.dataset.orderNumber ||
          item.dataset.customer ||
          item.dataset.itemsCount ||
          item.dataset.total;
        if (!hasOrder) return; // allow normal navigation for non-order notifications
        e.preventDefault();
        const title = item.dataset.orderNumber
          ? `Order ${item.dataset.orderNumber}`
          : (item.dataset.orderId ? `Order #${item.dataset.orderId}` : 'Incoming Order');
        const summaryParts = [];
        if (item.dataset.customer) summaryParts.push(`Customer: ${item.dataset.customer}`);
        if (item.dataset.itemsCount) summaryParts.push(`Items: ${item.dataset.itemsCount}`);
        if (item.dataset.total) summaryParts.push(`Total: ${item.dataset.total}`);
        const summary = summaryParts.join(' • ');
        const message = item.dataset.message || '';
        const createdAt = item.dataset.createdAt || '';
        const toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center show';
        toastEl.setAttribute('role', 'status');
        toastEl.setAttribute('aria-live', 'polite');
        toastEl.setAttribute('aria-atomic', 'true');
        toastEl.innerHTML = `
          <div class="toast-header">
            <i class="ti ti-shopping-cart me-2"></i>
            <strong class="me-auto">${title}</strong>
            ${createdAt ? `<small class="text-muted">${createdAt}</small>` : ''}
            <button type="button" class="btn-close ms-2 mb-1" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            ${message ? `<div class="mb-1">${message}</div>` : ''}
            ${summary ? `<div class="text-muted">${summary}</div>` : ''}
          </div>`;
        container.appendChild(toastEl);
        const closeBtn = toastEl.querySelector('.btn-close');
        if (closeBtn) closeBtn.addEventListener('click', () => toastEl.remove());
        // Auto-hide timer with pause-on-hover
        let remaining = persistMs;
        let timeoutId = null;
        let startTs = null;
        const startTimer = () => {
          if (!autoHide) return; // sticky toast (manual close only)
          // If remaining already 0 (e.g., very short durations), remove immediately
          if (remaining <= 0) {
            if (toastEl.isConnected) toastEl.remove();
            return;
          }
          startTs = Date.now();
          timeoutId = setTimeout(() => {
            if (toastEl.isConnected) toastEl.remove();
          }, remaining);
        };
        const pauseTimer = () => {
          if (!autoHide) return;
          if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = null;
            if (startTs) {
              const elapsed = Date.now() - startTs;
              remaining = Math.max(0, remaining - elapsed);
            }
          }
        };
        toastEl.addEventListener('mouseenter', pauseTimer);
        toastEl.addEventListener('mouseleave', startTimer);
        startTimer();
      });
    });
  } catch (e) {
    console.warn('Notification toast init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initNotificationToasts);