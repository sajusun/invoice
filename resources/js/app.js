import './server.js'
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import { createApp } from 'vue'
import CustomerList from '@/components/customers.vue'

const app = createApp({})
app.component('customers', CustomerList)
app.mount('#app')
