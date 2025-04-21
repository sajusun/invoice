<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Customers</title>
    <style>
        .main-box.no-header {
            padding-top: 20px;
        }

        .main-box {
            background: #FFFFFF;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 2px 0 #CCCCCC;
            margin-bottom: 16px;
            -webikt-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .table a.table-link.danger {
            color: #e74c3c;
        }

        .label {
            border-radius: 3px;
            font-size: 0.875em;
            font-weight: 600;
        }

        .user-list tbody td .user-subhead {
            font-size: 0.875em;
            font-style: italic;
        }

        .user-list tbody td .user-link {
            display: block;
            font-size: 1.25em;
            padding-top: 3px;
            margin-left: 60px;
        }

        a {
            color: #3498db;
            outline: none !important;
        }

        .user-list tbody td > img {
            position: relative;
            max-width: 50px;
            float: left;
            margin-right: 15px;
        }

        .table thead tr th {
            text-transform: uppercase;
            font-size: 0.875em;
        }

        .table thead tr th {
            border-bottom: 2px solid #e7ebee;
        }

        .table tbody tr td:first-child {
            font-size: 1.125em;
            font-weight: 300;
        }

        .table tbody tr td {
            font-size: 0.875em;
            vertical-align: middle;
            border-top: 1px solid #e7ebee;
            padding: 12px 8px;
        }

        a:hover {
            text-decoration: none;
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
@php
    $sn=0;
@endphp
<div class="main-content">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3" onclick='find_invoices()'>
                <h5>Total Invoice</h5>
                <p id="invoice_Length">None</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Pending Payments</h5>
                <p id="pending">None</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Revenue</h5>
                <p id="revenue">None</p>
            </div>
        </div>
    </div>

{{--    @include('custom-layouts.layout_customers')--}}

    <div class="mt-4 list-view">
        <h4>Total Customers : {{$controller->total_customers()}}</h4>

        <table class="table user-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>phone</th>
                <th>email</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)

                <tr class="list" data-id="{{$customer->id}}">
                    <td>{{++$sn}}</td>
                    <td>{{$customer['name']}}</td>
                    <td>{{$customer['phone']}}</td>
                    <td>{{$customer['email']}}</td>
                    <td style="width: 10%;">
{{--                        <a href="#" class="table-link text-warning">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
                        <a href="#" class="table-link text-info">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                        </a>
                        <a href="#" class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                        </a>
                    </td>
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
    function set_invoices(data) {
        document.getElementById('invoice_Length').innerText = data;
    }

    function set_pending(data) {
        document.getElementById('pending').innerText = data;
    }

    function set_revenue(data) {
        document.getElementById('revenue').innerText = data;
    }

    let customerId;
    serverRequest = new serverRequest();
    // Select all elements with class "customer-item"
    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
            customerId = this.getAttribute("data-id");
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));

            console.log(customerId)
            serverRequest.url = `http://localhost:8000/dashboard/customers/${customerId}`;
            serverRequest.xGet().then((response) => {
                let object = response['customer_data'];
                set_invoices(object.invoices.length)
                set_pending(response['customer_pending'])
                set_revenue(response['customer_revenue'])
            })
        });
    });

    function find_invoices() {

        serverRequest.url = `http://localhost:8000/dashboard/customers/${customerId}/invoice`;
        serverRequest.xGet().then((response) => {
            console.log(response)
        })

    }
</script>
