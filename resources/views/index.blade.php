{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    @include('custom-layouts.headTagContent')--}}

{{--    <title>invozen is your invoice maker</title>--}}

{{--    <style>--}}
{{--        /* Reset some default styling */--}}
{{--        * {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            color: #333;--}}
{{--            line-height: 1.6;--}}
{{--        }--}}

{{--        /* General layout */--}}
{{--        header, .features, .how-it-works, .pricing, footer {--}}
{{--            padding: 2rem 10%;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        /* Hero Section */--}}
{{--        header {--}}
{{--            background-color: #2A9D8F;--}}
{{--            color: #fff;--}}
{{--            padding: 5rem 10%;--}}
{{--        }--}}

{{--        .auth {--}}
{{--            display: block;--}}
{{--            position: static;--}}
{{--        }--}}

{{--        .auth div {--}}
{{--            right: 4rem;--}}
{{--            position: absolute;--}}
{{--            top: 2rem;--}}
{{--        }--}}

{{--        .auth div a {--}}
{{--            padding: .5rem .7rem;--}}
{{--            /*background-color: #E76F51;*/--}}
{{--            background-color: #21B7A5;--}}
{{--            color: #fff;--}}
{{--            border: none;--}}
{{--            border-radius: 5px;--}}
{{--            cursor: pointer;--}}
{{--            font-size: 1rem;--}}
{{--            margin-inline: .5rem;--}}
{{--            text-decoration: none;--}}
{{--        }--}}

{{--        header h1 {--}}
{{--            font-size: 2.5rem;--}}
{{--            margin-bottom: 1rem;--}}
{{--        }--}}

{{--        header p {--}}
{{--            font-size: 1.25rem;--}}
{{--            margin-bottom: 2rem;--}}
{{--        }--}}

{{--        .cta-btn {--}}
{{--            padding: 1rem 2rem;--}}
{{--            background-color: #E76F51;--}}
{{--            color: #fff;--}}
{{--            border: none;--}}
{{--            border-radius: 5px;--}}
{{--            cursor: pointer;--}}
{{--            font-size: 1rem;--}}
{{--            text-decoration: none;--}}
{{--        }--}}

{{--        /* Features Section */--}}
{{--        .features {--}}
{{--            background-color: #f9f9f9;--}}
{{--        }--}}

{{--        .feature-item {--}}
{{--            display: inline-block;--}}
{{--            width: 30%;--}}
{{--            padding: 1rem;--}}
{{--            margin: 1rem;--}}
{{--        }--}}

{{--        .feature-item h3 {--}}
{{--            color: #2A9D8F;--}}
{{--        }--}}

{{--        /* How It Works Section */--}}
{{--        .how-it-works h2 {--}}
{{--            margin-bottom: 2rem;--}}
{{--        }--}}

{{--        .step {--}}
{{--            display: inline-block;--}}
{{--            width: 22%;--}}
{{--            padding: 1rem;--}}
{{--            margin: 1rem;--}}
{{--            background-color: #e9ecef;--}}
{{--            border-radius: 8px;--}}
{{--        }--}}

{{--        /* Pricing Section */--}}
{{--        .pricing h2 {--}}
{{--            margin-bottom: 1.5rem;--}}
{{--        }--}}

{{--        .pricing-plan {--}}
{{--            display: inline-block;--}}
{{--            width: 30%;--}}
{{--            padding: 1rem;--}}
{{--            border: 2px solid #ddd;--}}
{{--            border-radius: 8px;--}}
{{--            margin: 1rem;--}}
{{--        }--}}

{{--        .pricing-plan h3 {--}}
{{--            color: #2A9D8F;--}}
{{--        }--}}

{{--        .pricing-plan p.price {--}}
{{--            font-size: 1.5rem;--}}
{{--            color: #E76F51;--}}
{{--        }--}}

{{--        .pricing-plan button {--}}
{{--            padding: 0.5rem 1.5rem;--}}
{{--            background-color: #2A9D8F;--}}
{{--            color: #fff;--}}
{{--            border: none;--}}
{{--            border-radius: 5px;--}}
{{--            cursor: pointer;--}}
{{--        }--}}

{{--        /* Footer */--}}
{{--        footer {--}}
{{--            background-color: #333;--}}
{{--            color: #fff;--}}
{{--            padding: 1rem 10%;--}}
{{--        }--}}

{{--        footer a {--}}
{{--            color: #E76F51;--}}
{{--            text-decoration: none;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<!-- Hero Section -->--}}
{{--<header>--}}
{{--    <section class="auth">--}}
{{--        <div>--}}
{{--            @auth()--}}
{{--                <a href="/dashboard">Dashboard</a>--}}
{{--            @else--}}
{{--                <a href="/login">Login</a>--}}
{{--                <a href="/register">Register</a>--}}
{{--        </div>--}}
{{--        @endauth--}}
{{--    </section>--}}
{{--    <h1>Invozen - Simplify Your Invoicing, Get Paid Faster</h1>--}}
{{--    <p>Generate, send, and manage invoices effortlessly with Invozen.</p>--}}
{{--    @auth()--}}
{{--        <a class="cta-btn" href="/invoice">Make Invoice</a>--}}
{{--    @else--}}
{{--        <a class="cta-btn" href="/invoice">Get Started for Free</a>--}}
{{--    @endauth--}}
{{--</header>--}}

{{--<!-- Features Section -->--}}
{{--<section class="features">--}}
{{--    <h2>Key Features</h2>--}}
{{--    <div class="feature-item">--}}
{{--        <h3>Fast Invoice Creation</h3>--}}
{{--        <p>Create invoices quickly and easily with customizable templates.</p>--}}
{{--    </div>--}}
{{--    <div class="feature-item">--}}
{{--        <h3>Automated Reminders</h3>--}}
{{--        <p>Send reminders to clients automatically to ensure timely payments.</p>--}}
{{--    </div>--}}
{{--    <div class="feature-item">--}}
{{--        <h3>Secure Payments</h3>--}}
{{--        <p>Accept payments securely online through trusted providers.</p>--}}
{{--    </div>--}}
{{--</section>--}}

{{--<!-- How It Works Section -->--}}
{{--<section class="how-it-works">--}}
{{--    <h2>How It Works</h2>--}}
{{--    <div class="step">--}}
{{--        <h4>1. Sign Up</h4>--}}
{{--        <p>Create your free account and get started.</p>--}}
{{--    </div>--}}
{{--    <div class="step">--}}
{{--        <h4>2. Customize Invoices</h4>--}}
{{--        <p>Personalize your invoices with our easy-to-use editor.</p>--}}
{{--    </div>--}}
{{--    <div class="step">--}}
{{--        <h4>3. Send Invoices</h4>--}}
{{--        <p>Send invoices directly to clients via email or download as PDF.</p>--}}
{{--    </div>--}}
{{--    <div class="step">--}}
{{--        <h4>4. Track Payments</h4>--}}
{{--        <p>Monitor payments and keep your finances organized.</p>--}}
{{--    </div>--}}
{{--</section>--}}

{{--<!-- Pricing Section -->--}}
{{--<section class="pricing">--}}
{{--    <h2>Pricing Plans</h2>--}}
{{--    <div class="pricing-plan">--}}
{{--        <h3>Basic Plan</h3>--}}
{{--        <p class="price">$0 / month</p>--}}
{{--        <p>Great for freelancers and small businesses just starting out.</p>--}}
{{--        <button>Choose Plan</button>--}}
{{--    </div>--}}
{{--    <div class="pricing-plan">--}}
{{--        <h3>Pro Plan</h3>--}}
{{--        <p class="price">$15 / month</p>--}}
{{--        <p>Unlock advanced features for growing businesses.</p>--}}
{{--        <button>Choose Plan</button>--}}
{{--    </div>--}}
{{--    <div class="pricing-plan">--}}
{{--        <h3>Enterprise Plan</h3>--}}
{{--        <p class="price">Custom</p>--}}
{{--        <p>Get a tailored solution with dedicated support.</p>--}}
{{--        <button>Contact Us</button>--}}
{{--    </div>--}}
{{--</section>--}}

{{--<!-- Footer -->--}}
{{--<footer>--}}
{{--    <p>&copy; 2024 Invozen. All rights reserved.</p>--}}
{{--    <p><a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-of-service">Terms of Service</a> | <a--}}
{{--            href="/contact-us">Contact Us</a></p>--}}
{{--</footer>--}}
{{--</body>--}}
{{--</html>--}}

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
        <a href="#invoice-editor" class="btn btn-lg">Create Invoice</a>
    </div>
</header>

{{--<!-- Invoice Editor Section (Basic Structure) -->--}}
<section id="invoice-editor" class="py-5">
    <div class="container text-center">
        <h2>Invoice Generator</h2>
        <p class="text-muted">Easily customize and download your invoice</p>
        <div class="border p-4 bg-light rounded">
            @include('custom-layouts.invoice')
        </div>
    </div>
</section>

<!-- Footer -->
@include('custom-layouts.footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</html>

