import global from './global_var.js';
import server from "./server.js";

// let url=`/invoice/search?search=`;
const {createApp} = Vue;

    createApp({
        data() {
            return {
                invoices: [],
                pagination: {},
                search: '',
                previous: [],
                loading: false,
                searchBtn: "Search",
                ready: false,
                url: '/invoice/search?search=',
            }
        },
        mounted() {
            this.fetchInvoices(this.url);
        },
        methods: {
            fetchInvoices(url) {
                this.searchBtn = "searching";
                this.loading = true;
                server.get(`${url}${this.search}`)
                    .then(response => {
                        this.searchBtn = "Search";
                        console.log(response)
                        this.invoices = response.data['invoices'].data;
                        let data = response.data['invoices'];
                        this.loading = false;
                        this.searchBtn = "Search";
                        this.pagination = {
                            current_page: data.current_page,
                            last_page: data.last_page,
                            next_page_url: data.next_page_url,
                            prev_page_url: data.prev_page_url
                        };

                    });
            },
            key_Searching() {
                if (this.search.trim() === '' && this.ready) {
                    this.ready = false;

                    this.fetchInvoices(this.url);
                }

            },
            onTabSearch() {
                if (this.search.trim() === '') {
                    return
                }
                this.fetchInvoices(this.url);
                this.ready = true;

            },
            goto(invoice_number) {
                return `${host}/invoice/${invoice_number}/preview`
            },
            confirmDelete(uid) {
             let   url = `${host}/invoice/${uid}/delete`
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will permanently delete the invoice.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Create and submit a form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;

                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = csrfToken
                        form.appendChild(token);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'POST';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            },
        },

    }).mount('#app');
