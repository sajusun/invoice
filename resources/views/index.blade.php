<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen - Smart Invoice Management</title>
    <meta name="description"
          content="Invozen is the smartest way to create, manage, and send invoices online. Save customer data and streamline your invoicing process effortlessly.">
    <meta name="keywords" content="invoice generator, online invoicing, invozen, billing software, invoice management">
    <meta name="author" content="Invozen">
    <!-- Canonical URL -->
    <link rel="canonical" href="{{config('app.url')}}">
    <!-- Open Graph (For social media sharing) -->
    <meta property="og:title" content="Invozen - Smart Invoice Management">
    <meta property="og:description"
          content="Invozen helps businesses create and manage invoices efficiently with smart tools.">
    <meta property="og:image" content="{{config('app.url')}}/images/preview.png">
    <meta property="og:url" content="{{config('app.url')}}">
    <meta property="og:type" content="website">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Invozen - Smart Invoice Management">
    <meta name="twitter:description" content="Create and manage invoices effortlessly with Invozen.">
    <meta name="twitter:image" content="{{config('app.url')}}/images/preview.png">
    <!-- Robots Meta Tag (For Search Engine Indexing) -->
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
</head>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Invozen - Smart Invoicing",
      "url": "https://www.invozen.com",
      "logo": "{{asset('/logo/invozen-favicon.png')}}",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "Web",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "215"
      }
    }
</script>
<body class="h-full">
<!-- Navbar -->
<nav class="navbar-light bg-light shadow-sm px-4 py-1 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <!-- Toggle Sidebar -->
{{--        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-700 focus:outline-none">--}}
{{--            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>--}}
{{--            </svg>--}}
{{--        </button>--}}
        {{--        <span class="text-xl font-semibold text-gray-800">Invozen</span>--}}
        <a class="navbar-brand fw-bold" style="font-size: 2rem;padding-top: .1rem; font-family: 'Roboto Thin',math;font-variant: small-caps;" href="/">
            <img
                src="https://thumbs.dreamstime.com/b/invoice-icon-linear-logo-mark-set-collection-black-white-web-invoice-icon-linear-logo-mark-black-white-330206480.jpg"
                alt="logo" width="40" height="40" class="d-inline-block align-text-top">
            InvoZen
        </a>
    </div>

    <div>
        @include('custom-layouts.auth-or-dashboard')
    </div>
</nav>
<!-- Hero Section -->
<header class="text-white text-center py-5 shadow-sm">
    <div class="container">
        <h1 class="display-4">Create Professional Invoices Instantly</h1>
        <p class="lead">Simple, fast, and free invoice generator</p>
        <a href="/invoice/builder" class="btn btn-lg">Create Invoice</a>
    </div>
</header>

<div class="flex"></div>
<section class="lg:px-6 sm:px-2">
    @include('custom-layouts.features_card')
</section>

<!-- Footer -->
@include('custom-layouts.footer')
</body>

</html>

