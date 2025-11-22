import { createApp } from 'vue'
import invoiceList from '@/components/invoice-list.vue'

const app = createApp({})
app.component('invoice', invoiceList)
app.mount('#app')
