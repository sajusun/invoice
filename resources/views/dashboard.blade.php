{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900">--}}
{{--                    {{ __("You're logged in!") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #1b2a4e; color: white; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px; margin: 5px 0; }
        .sidebar a:hover { background: #162241; }
        .main-content { margin-left: 270px; padding: 20px; }
        .card { border: none; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="sidebar">
    <h3>Dashboard</h3>
    <a href="{{ route('dashboard') }}">Home</a>
    <a href="/invoice">Invoice</a>
    <a href="{{ route('profile.edit') }}">Profile</a>

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <a href="{{route('logout')}}"
                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
            {{ __('Log Out') }}
        </a>
    </form>
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-light p-3 mb-4">
        <span>{{ __('Welcome') }}, <strong>{{ Auth::user()->name }}</strong></span>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Invoices</h5>
                <p>25</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Pending Payments</h5>
                <p>5</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Revenue</h5>
                <p>$12,000</p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Recent Invoices</h4>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>$500</td>
                <td>Paid</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>$750</td>
                <td>Pending</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
