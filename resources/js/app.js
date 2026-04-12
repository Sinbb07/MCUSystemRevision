import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const INACTIVITY_MINUTES = 30;
const INACTIVITY_TIMEOUT_MS = INACTIVITY_MINUTES * 60 * 1000;
let inactivityTimer;

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

async function logoutByInactivity() {
    const token = getCsrfToken();

    if (!token) {
        window.location.reload();
        return;
    }

    try {
        await fetch('/logout', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        });
    } catch (error) {
        console.error('Automatic logout failed:', error);
    } finally {
        alert('You have been logged out due to 30 minutes of inactivity.');
        window.location.reload();
    }
}

function resetInactivityTimer() {
    if (inactivityTimer) {
        clearTimeout(inactivityTimer);
    }
    inactivityTimer = window.setTimeout(logoutByInactivity, INACTIVITY_TIMEOUT_MS);
}

const activityEvents = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll'];
activityEvents.forEach((event) => {
    window.addEventListener(event, resetInactivityTimer, true);
});

window.addEventListener('load', resetInactivityTimer);
