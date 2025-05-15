<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, isLoggedIn: true }" class="h-full">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen Dashboard - Manage Your Invoices</title>
    <meta name="description"
          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">
    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">
    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->
    <link rel="canonical" href="{{config('app.live_url')}}/dashboard">
</head>
<body class="bg-gray-100 h-full">
{{--navbar--}}
@include('custom-layouts.navbar')
<!-- Sidebar -->
<div class="flex">
    @include('custom-layouts.sidebar_dashboard')

<main class="flex-1 p-6">
    @if (session('welcome_message'))
        <nav id="welcome_message" class="navbar navbar-light bg-light p-3 mb-4 transition-opacity duration-500">
        <span>
            {{ session('welcome_message') }} <strong>{{ Auth::user()->name }}</strong>
        </span>
        </nav>
    @endif

@include('pages.invoices_list')

</main>
</div>
@include('custom-layouts.footer')

</body>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<script>

    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));
        });
    });


    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hidden"));
        // remove active class previous selected roe
        document.querySelectorAll(".list").forEach(el => el.classList.remove("active"));

        row.classList.toggle("active");

        const nextRow = row.nextElementSibling;
        if (nextRow  && nextRow.classList.contains("details-row")) {
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
@if(session('welcome_message'))
    <script>
        setTimeout(() => {
            const alertBox = document.getElementById("welcome_message");
            if (alertBox) {
                alertBox.classList.add("fade-out"); // apply fade-out style
                setTimeout(() => {
                    alertBox.remove(); // remove after transition
                }, 500); // matches the CSS duration (500ms)
            }
        }, 3000);// 3000 milliseconds = 3 seconds
    </script>
@endif

