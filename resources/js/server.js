import axios from 'axios';

const BASE_URL = document.querySelector('meta[name="base-url"]')?.content || '';

const server = axios.create({
    baseURL: BASE_URL,
});
window.server = server;
export default server;
