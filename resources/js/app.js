import './bootstrap.js'
import './server.js'

 import { createApp } from 'vue'
//
import CustomerList from '@/components/customers.vue'

const app = createApp({})
app.component('customers', CustomerList)
app.mount('#app')

import './user-notifcations.js'

