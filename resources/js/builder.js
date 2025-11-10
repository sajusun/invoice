import {createApp} from 'vue'
import InvoiceBuilder from './components/builder.vue'


const app = createApp({})
app.component('invoice-builder', InvoiceBuilder)
app.mount('#app')

