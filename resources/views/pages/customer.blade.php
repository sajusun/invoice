<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #1b2a4e;
            color: white;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background: #162241;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
{{--navbar--}}
@include('custom-layouts.navbar')
{{--left site bar--}}
<div class="sidebar">
    @include('custom-layouts.sidebar_dashboard')
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-light p-3 mb-4">
{{--        <span>{{ __('Welcome') }}, <strong>{{ Auth::user()->name }}</strong></span>--}}
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Customers</h5>
                <p>{{$controller->total_customers()}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Pending Payments</h5>
{{--                <p>{{$status}}</p>--}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Revenue</h5>
{{--                <p>{{$total}}</p>--}}
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Customers List</h4>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>phone</th>
                <th>email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->id}}</td>
                    <td>{{$customer['name']}}</td>
                    <td>{{$customer['phone']}}</td>
                    <td>{{$customer['email']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</html>
<script>
    serverRequest = new serverRequest();
    serverRequest.url = "http://localhost:8000/dashboard/customers"
    serverRequest.xGet().then((response) => {
        console.log(response)
    })
</script>
