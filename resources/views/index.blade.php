<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'Invozen' - Simple Invoice Generator</title>
    <link rel="icon" type="image/x-icon" href="invozen-fabicon.png">
    <style>
        /* Reset some default styling */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }

        /* General layout */
        header, .features, .how-it-works, .pricing, footer {
            padding: 2rem 10%;
            text-align: center;
        }

        /* Hero Section */
        header {
            background-color: #2A9D8F;
            color: #fff;
            padding: 5rem 10%;
        }
        .auth{
            display: block;
            position: static;
        }
        .auth div{
            right: 4rem;
            position: absolute;
            top: 2rem;
        }
        .auth div a{
            padding: .5rem .7rem;
            /*background-color: #E76F51;*/
            background-color: #21B7A5;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-inline: .5rem;
            text-decoration: none;
        }
        header h1 { font-size: 2.5rem; margin-bottom: 1rem; }
        header p { font-size: 1.25rem; margin-bottom: 2rem; }
        .cta-btn {
            padding: 1rem 2rem;
            background-color: #E76F51;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        /* Features Section */
        .features {
            background-color: #f9f9f9;
        }
        .feature-item {
            display: inline-block;
            width: 30%;
            padding: 1rem;
            margin: 1rem;
        }
        .feature-item h3 { color: #2A9D8F; }

        /* How It Works Section */
        .how-it-works h2 {
            margin-bottom: 2rem;
        }
        .step {
            display: inline-block;
            width: 22%;
            padding: 1rem;
            margin: 1rem;
            background-color: #e9ecef;
            border-radius: 8px;
        }

        /* Pricing Section */
        .pricing h2 {
            margin-bottom: 1.5rem;
        }
        .pricing-plan {
            display: inline-block;
            width: 30%;
            padding: 1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin: 1rem;
        }
        .pricing-plan h3 { color: #2A9D8F; }
        .pricing-plan p.price { font-size: 1.5rem; color: #E76F51; }
        .pricing-plan button {
            padding: 0.5rem 1.5rem;
            background-color: #2A9D8F;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 1rem 10%;
        }
        footer a {
            color: #E76F51;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <header>
        <section class="auth">
            <div>
                <a href="/login">Login</a>
                <a href="/register" type="submit">Register</a>
            </div>
        </section>
        <h1>Invozen - Simplify Your Invoicing, Get Paid Faster</h1>
        <p>Generate, send, and manage invoices effortlessly with Invozen.</p>
        <button class="cta-btn">Get Started for Free</button>
    </header>

    <!-- Features Section -->
    <section class="features">
        <h2>Key Features</h2>
        <div class="feature-item">
            <h3>Fast Invoice Creation</h3>
            <p>Create invoices quickly and easily with customizable templates.</p>
        </div>
        <div class="feature-item">
            <h3>Automated Reminders</h3>
            <p>Send reminders to clients automatically to ensure timely payments.</p>
        </div>
        <div class="feature-item">
            <h3>Secure Payments</h3>
            <p>Accept payments securely online through trusted providers.</p>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <h2>How It Works</h2>
        <div class="step">
            <h4>1. Sign Up</h4>
            <p>Create your free account and get started.</p>
        </div>
        <div class="step">
            <h4>2. Customize Invoices</h4>
            <p>Personalize your invoices with our easy-to-use editor.</p>
        </div>
        <div class="step">
            <h4>3. Send Invoices</h4>
            <p>Send invoices directly to clients via email or download as PDF.</p>
        </div>
        <div class="step">
            <h4>4. Track Payments</h4>
            <p>Monitor payments and keep your finances organized.</p>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing">
        <h2>Pricing Plans</h2>
        <div class="pricing-plan">
            <h3>Basic Plan</h3>
            <p class="price">$0 / month</p>
            <p>Great for freelancers and small businesses just starting out.</p>
            <button>Choose Plan</button>
        </div>
        <div class="pricing-plan">
            <h3>Pro Plan</h3>
            <p class="price">$15 / month</p>
            <p>Unlock advanced features for growing businesses.</p>
            <button>Choose Plan</button>
        </div>
        <div class="pricing-plan">
            <h3>Enterprise Plan</h3>
            <p class="price">Custom</p>
            <p>Get a tailored solution with dedicated support.</p>
            <button>Contact Us</button>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Invozen. All rights reserved.</p>
        <p><a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-of-service">Terms of Service</a> | <a href="/contact-us">Contact Us</a></p>
    </footer>
</body>
</html>
