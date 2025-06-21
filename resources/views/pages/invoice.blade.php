<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invoice Generator</title>
</head>
<body>
@include('custom-layouts.navbar')
<div class="p-4 md:p-1">
    @auth()
        @include('custom-layouts.invoice')
    @else
        @include('custom-layouts.guest_invoice')
    @endauth
</div>
{{--@include('custom-layouts.footer')--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
