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

function initPublicReportBarChart() {
  try {
    const el = document.getElementById('publicReportBarChart');
    const payload = window.__publicByCategory;
    if (!el || !payload || !payload.labels?.length) return;
    const colors = payload.labels.map((_, idx) => {
      const hue = (idx * 29) % 360;
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
    console.warn('Public report bar chart init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initPublicReportBarChart);

// Theme-related logic is now handled globally in app.js.

// Shop Personal Report Chart (My Report)
function initShopPersonalReportChart() {
  try {
    const el = document.getElementById('shopPersonalReportChart');
    const payload = window.__shopPersonalReportData;
    if (!el || !payload || !payload.labels?.length) return;
    new Chart(el, {
      type: 'line',
      data: {
        labels: payload.labels,
        datasets: [
          {
            label: 'Toner OUT',
            data: payload.series,
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79,70,229,0.15)',
            tension: 0.25,
            fill: true,
            pointRadius: 3,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true },
          tooltip: { enabled: true }
        },
        scales: {
          x: { display: true, ticks: { autoSkip: true, maxTicksLimit: 12 } },
          y: { display: true, beginAtZero: true }
        }
      }
    });
  } catch (e) {
    console.warn('Shop personal report chart init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initShopPersonalReportChart);

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
        // Always prevent navigation and keep the notifications menu content visible
        e.preventDefault();
        e.stopPropagation();
        const hasOrder =
          item.dataset.orderId ||
          item.dataset.orderNumber ||
          item.dataset.customer ||
          item.dataset.itemsCount ||
          item.dataset.total;
        const isOrder = Boolean(hasOrder);
        const title = isOrder
          ? (item.dataset.orderNumber
              ? `Order ${item.dataset.orderNumber}`
              : (item.dataset.orderId ? `Order #${item.dataset.orderId}` : 'Incoming Order'))
          : (item.dataset.message || 'Notification');
        const summaryParts = [];
        if (item.dataset.customer) summaryParts.push(`Customer: ${item.dataset.customer}`);
        if (item.dataset.itemsCount) summaryParts.push(`Items: ${item.dataset.itemsCount}`);
        if (item.dataset.total) summaryParts.push(`Total: ${item.dataset.total}`);
        const message = item.dataset.message || '';
        const createdAt = item.dataset.createdAt || '';
        // For non-order notifications, show created time as subtle context
        if (!isOrder && createdAt) summaryParts.push(createdAt);
        const summary = summaryParts.join(' • ');
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
        // Ensure the collapse remains open after click
        try {
          const BSCollapse = window.bootstrap?.Collapse;
          if (BSCollapse) {
            const inst = BSCollapse.getOrCreateInstance(collapse, { toggle: false });
            inst.show();
          } else {
            collapse.classList.add('show');
          }
        } catch (_) { /* noop */ }
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

// Enforce minimum open time and manual close for notifications menu
function initNotificationCollapseTiming() {
  try {
    const collapseEl = document.getElementById('notifCollapse');
    const toggleBtn = document.querySelector('[data-bs-target="#notifCollapse"]');
    if (!collapseEl || !toggleBtn) return;
    const minOpenMs = parseInt(collapseEl.getAttribute('data-min-open-ms') || '3000', 10);
    let openedAt = 0;
    let forceClose = false;

    // Track when the menu finishes opening
    collapseEl.addEventListener('shown.bs.collapse', () => {
      openedAt = Date.now();
    });

    // If something tries to hide the collapse before the minimum time, re-open it
    const ensureMinOpen = (/* event */ e) => {
      const elapsed = Date.now() - openedAt;
      if (!forceClose && elapsed < minOpenMs) {
        try { if (e && typeof e.preventDefault === 'function') e.preventDefault(); } catch (_) {}
        // Re-open using Bootstrap API if available; otherwise toggle class
        setTimeout(() => {
          try {
            const BSCollapse = window.bootstrap?.Collapse;
            if (BSCollapse) {
              const inst = BSCollapse.getOrCreateInstance(collapseEl, { toggle: false });
              inst.show();
            } else {
              collapseEl.classList.add('show');
            }
          } catch (_) { /* noop */ }
        }, 0);
      }
    };

    collapseEl.addEventListener('hide.bs.collapse', ensureMinOpen);
    collapseEl.addEventListener('hidden.bs.collapse', ensureMinOpen);

    // Intercept toggle clicks attempting to close before minimum open time
    toggleBtn.addEventListener('click', (e) => {
      const isOpen = collapseEl.classList.contains('show');
      if (isOpen) {
        const elapsed = Date.now() - openedAt;
        if (!forceClose && elapsed < minOpenMs) {
          e.preventDefault();
          e.stopPropagation();
          return;
        }
        // Allow close and reset force flag
        forceClose = false;
      }
    });

    // Manual close button inside the menu bypasses timing restriction
    const internalCloseBtn = document.getElementById('notifCloseBtn');
    if (internalCloseBtn) {
      internalCloseBtn.addEventListener('click', () => {
        forceClose = true;
        toggleBtn.click();
      });
    }

    // Expose a system command to close programmatically, bypassing minimum timing
    window.closeNotificationsMenu = function closeNotificationsMenu() {
      try {
        forceClose = true;
        toggleBtn.click();
      } catch (_) {
        // Fallback: directly hide if toggle fails
        collapseEl.classList.remove('show');
        forceClose = false;
      }
    };
  } catch (e) {
    console.warn('Notification collapse timing init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initNotificationCollapseTiming);

// Mobile sidebar toggle (off-canvas)
function initSidebarToggle() {
  try {
    const body = document.body;
    if (!body.classList.contains('material-layout')) return;
    const btn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    const aside = document.getElementById('sidenav-main');
    if (!btn || !aside) return;

    const updateAria = () => {
      const expanded = body.classList.contains('sidebar-open');
      btn.setAttribute('aria-expanded', String(expanded));
    };

    // Toggle on button click
    btn.addEventListener('click', () => {
      body.classList.toggle('sidebar-open');
      updateAria();
    });

    // Close when clicking overlay
    if (overlay) {
      overlay.addEventListener('click', () => {
        body.classList.remove('sidebar-open');
        updateAria();
      });
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        body.classList.remove('sidebar-open');
        updateAria();
      }
    });

    // Initialize in collapsed state on small screens
    body.classList.remove('sidebar-open');
    updateAria();
  } catch (e) {
    console.warn('Sidebar toggle init skipped:', e?.message || e);
  }
}

document.addEventListener('DOMContentLoaded', initSidebarToggle);