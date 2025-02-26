<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Customers</title>
</head>
<body>
{{--navbar--}}
@include('custom-layouts.navbar')
{{--left site bar--}}
<div class="sidebar">
    @include('custom-layouts.sidebar_dashboard')
</div>

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

    <div class="mt-4 list-view">
        <h4>Total Customers : {{$controller->total_customers()}}</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Name</th>
                <th>phone</th>
                <th>email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr class="list" data-id="{{$customer->id}}">
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
                console.log(response['customer_data'])
                let object = response['customer_data'];
                set_invoices(object.invoices.length)
                set_pending(response['customer_pending'])
                set_revenue(response['customer_revenue'])
            })
        });
    });
function find_invoices() {

   serverRequest.url=`http://localhost:8000/dashboard/customers/${customerId}/invoice`;
   serverRequest.xGet().then( (response)=>{
       console.log(response)
   })

}
</script>
