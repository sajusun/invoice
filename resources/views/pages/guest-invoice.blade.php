@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invoice</title>
    <style>
        .client-details button {
        }

        .client-area {
            text-align: left;
        }

        .client {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: stretch;
        }

        .client-details {
            text-align: left;
            display: grid;
            justify-content: space-around;
            align-items: baseline;
            align-content: space-around;
            justify-items: stretch;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="header">
        <h1>Invoice</h1>
    </div>
    <div class="row">
        <div class="col company-details">
            @if(Auth::check())
                <div><strong>Company Name:</strong>{{Auth::id()}}</div>
                <div><strong>Company Address:</strong></div>
                <div><strong>Email:</strong></div>
                <div><strong>Phone:</strong></div>
            @else
                <div><strong>Company Name:</strong> <span contenteditable="true">company name</span></div>
                <div><strong>Company Address:</strong> <span contenteditable="true">address</span></div>
                <div><strong>Email:</strong><span contenteditable="true"></span>email</div>
                <div><strong>Phone:</strong><span contenteditable="true"></span>phone</div>
            @endif

        </div>

        <div class="col invoice-details">
            <div><strong>Invoice #:</strong> <span></span></div>
            <div><strong>Date:</strong> <span>2024-09-21</span></div>
            <div><strong>Due Date:</strong> <span contenteditable="true">2024-09-21</span></div>
        </div>
    </div>


    {{--client section--}}
    <div class="client-area">
        <div><strong>Billed To:</strong></div>
        <div class="client">
            <div class="client-details">
                <label for="name">Name</label>
                <input name="name" placeholder="Name">
            </div>
            <div class="client-details">
                <label for="name">Address</label>
                <input name="address" placeholder="Address">
            </div>
            <div class="client-details">
                <label for="Phone">Phone</label>
                <input name="Phone" placeholder="Phone">
            </div>
        </div>
        <button class="btn btn-info" id="saveBtn">save & continue</button>

    </div>
    <table>
        <thead>
        <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>

        </tr>
        </thead>
        <tbody id="tableBody">
        <tr>
            <td contenteditable="true"></td>
            <td contenteditable="true" class="valueInput"></td>
            <td contenteditable="true" class="valueInput"></td>
            <td></td>
        </tr>
        <!-- Add more rows as needed -->
        </tbody>
    </table>
    <div class="row-controller-div">
        <button id="addRow">+</button>
        <button id="removeRow">-</button>
    </div>
    <div class="total-section">
        {{--        <div><strong>Tax (10%):</strong> $25.00</div>--}}
        <div><strong>Total:</strong> <span id="total"></span></div>
        <div><strong>Advance:</strong> <span id="advance" contenteditable="true"></span></div>
        <div><strong>Due:</strong> <span id="due"></span></div>
    </div>
    <div class="footer">
        <p>Thank you for your business! Please make the payment by the due date.</p>
    </div>
</div>
@if(Auth::check())
    <script>
        const invoice = new InvoiceGenerator();
        invoice.save;
    </script>
@endif
</body>

@include('custom-layouts.bottom_script_files')
</html>
