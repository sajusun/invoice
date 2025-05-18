import server from "./server.js";

const {createApp} = Vue;
createApp({
    data() {
        return {
            customers: [],
            pagination: {},
            search: '',
            sum_of_invoices: '',
            status: '',
            total: '',
            loading: false,
            searchBtn: "Search",
            ready: false,
            url: `/dashboard/customers/search?search=`
        }
    },
    mounted() {
        this.fetchCustomers(this.url);
    },
    methods: {
        fetchCustomers(url) {
            this.searchBtn = "searching";
            this.loading = true;
            server.get(`${url}${this.search}`)
                .then(response => {
                    this.searchBtn = "Search";

                    console.log(response.data)
                    this.customers = response.data['customers'].data;
                    this.status = response.data['status'];
                    this.sum_of_invoices = response.data['sum_of_invoices'];
                    this.total = response.data['total'];

                    let data = response.data['customers'];
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
                this.fetchCustomers(this.url);
            }

        },
        onTabSearch() {
            if (this.search.trim() === '') {
                return
            }
            this.fetchCustomers(this.url);
            this.ready = true;
        },
        goto(customer_id) {
            return `/customers/${customer_id}/preview`
        },
        confirmDelete(uid) {
            let url = `/customer/${uid}/delete`
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will permanently delete the Client.",
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
                    token.type = 'text';
                    token.name = '_token';
                    token.value = csrfToken;
                    form.appendChild(token);

                    const method = document.createElement('input');
                    method.type = 'text';
                    method.name = '_method';
                    method.value = 'POST';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    },

}).mount('#customer');
