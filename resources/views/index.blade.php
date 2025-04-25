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

