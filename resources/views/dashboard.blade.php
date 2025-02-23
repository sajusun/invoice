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
{{--        @if(session('success'))--}}
{{--           <span>{{ session('success'). session()->forget('success')}}</span>--}}

{{--        @endif--}}
        <span>
            {{ __('Welcome') }}, <strong>{{ Auth::user()->name }}</strong>
        </span>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Invoices</h5>
                <p>{{$num_of_invoices}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Pending Payments</h5>
                <p>{{$status}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Revenue</h5>
                <p>{{$total}}</p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Recent Invoices</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{$invoice['invoice_number']}}</td>
                    <td>{{$invoice->customer->name}}</td>
                    <td>{{$invoice['total_amount']}}</td>
                    <td>{{$invoice['status']}}</td>
                </tr>
            @endforeach

            {{--            <tr>--}}
            {{--                <td>1</td>--}}
            {{--                <td>John Doe</td>--}}
            {{--                <td>$500</td>--}}
            {{--                <td>Paid</td>--}}
            {{--            </tr>--}}
            {{--            <tr>--}}
            {{--                <td>2</td>--}}
            {{--                <td>Jane Smith</td>--}}
            {{--                <td>$750</td>--}}
            {{--                <td>Pending</td>--}}
            {{--            </tr>--}}
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
{{--<script>--}}
{{--    serverRequest = new serverRequest();--}}
{{--    serverRequest.url = "http://localhost:8000/invoice/all"--}}
{{--    serverRequest.xGet().then((response) => {--}}
{{--        console.log(response)--}}
{{--    })--}}
{{--</script>--}}
