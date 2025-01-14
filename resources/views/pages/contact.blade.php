<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Invozen</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem 10%; }
        h1 { color: #2A9D8F; }
        form { max-width: 600px; margin: 0 auto; }
        label { display: block; margin: 1rem 0 0.5rem; }
        input, textarea { width: 100%; padding: 0.5rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #2A9D8F; color: #fff; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Contact Us</h1>
    <p>If you have any questions or need assistance, please fill out the form below, and we'll get back to you as soon as possible.</p>
    
    <form action="submit_contact_form" method="post">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
