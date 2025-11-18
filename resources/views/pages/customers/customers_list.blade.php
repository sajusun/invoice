
<x-dashboard-layout>
    <x-slot name="meta">
        @vite('resources/js/customer.js')
        <title>Invozen Dashboard - Manage Your Invoices</title>
    </x-slot>
    <div id="app">
        <customers></customers>
    </div>
<script>
    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll("tr").forEach(th => th.classList.remove("active"));
        row.classList.add("active")
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hidden"));
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains("details-row")) {
            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hidden");
        }
    }
</script>

@if (session('response'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: '{{session('response')}}',
            title: '{{ session("message") }}',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: false,
        });
    </script>
@endif

</x-dashboard-layout>
