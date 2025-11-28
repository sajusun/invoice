import axios from 'axios';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.axios = axios;

Alpine.start();
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add CSRF token configuration
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
} else {
    console.warn('CSRF token meta tag not found!');
}


import './echo';
