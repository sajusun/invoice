<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen - Invoice Generator</title>
</head>
<body>
@include('custom-layouts.navbar')

<!-- Hero Section -->
<header class="text-white text-center py-5 shadow-sm">
    <div class="container">
        <h1 class="display-4">Create Professional Invoices Instantly</h1>
        <p class="lead">Simple, fast, and free invoice generator</p>
        <a href="/invoice" class="btn btn-lg">Create Invoice</a>
    </div>
</header>

<section class="guide-card">
    @include('custom-layouts.features_card')
</section>

<!-- Footer -->
@include('custom-layouts.footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</html>

