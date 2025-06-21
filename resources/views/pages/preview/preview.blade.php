<div class="max-w-3xl mx-auto bg-white p-4 shadow-lg rounded-md mt-1 print:shadow-none print:p-0" id="printable">
    <div class="flex justify-between items-center border-b pb-1">
        <div>
            <h1 class="text-xl font-bold text-gray-600">Invoice</h1>
            <p class="text-sm text-gray-600">{{$invoice_data['invoice_number']}}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-600">Date : {{$invoice_data['invoice_date']}}</p>
            @if($invoice_data['status']=='Paid')
                <div
                    class="center relative inline-block select-none whitespace-nowrap rounded-lg bg-green-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">
                    <div class="mt-px">{{$invoice_data['status']}}</div>
                </div>
            @else
                <div
                    class="center relative inline-block select-none whitespace-nowrap rounded-lg bg-amber-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-gray-600">
                    <div class="mt-px">{{$invoice_data['status']}}</div>
                </div>
            @endif

        </div>
    </div>
    <div class="mt-1">
        <div class="flex justify-between">
            <div class="ml-2">
                <p class="text-base font-semibold text-gray-500">Invoice To :</p>
                <p class="text-sm text-gray-600">{{$invoice_data->customer['name']}}</p>
                <p class="text-sm text-gray-600">{{$invoice_data->customer['address']}}</p>
                <p class="text-sm text-gray-600">{{$invoice_data->customer['phone']}}</p>
            </div>
            <div class="text-right mr-2">
                <p class="text-base font-semibold text-gray-500">Issue From :</p>
                <p class="text-sm text-gray-600">{{$company_data['name']}}</p>
                <p class="text-sm text-gray-600">{{$company_data['address']}}</p>
                <p class="text-sm text-gray-600">{{$company_data['email']}}</p>
                <p class="text-sm text-gray-600">{{$company_data['phone']}}</p>
            </div>
        </div>
    </div>

    <div class="mt-1">
        <table class="w-full table-auto border-t border-gray-200">
            <thead>
            <tr class="text-left text-sm text-gray-500 bg-gray-100">
                <th class="p-2 text-center w-2">#</th>
                <th class="p-2">Product's Name</th>
                <th class="p-2 text-right">Quantity</th>
                <th class="p-2 text-right">Price</th>
                <th class="p-2 text-right">Total</th>
            </tr>
            </thead>
            <tbody>
            @php
                $sn=0;
                 $items=json_decode($invoice_data->items) @endphp
            @foreach($items as $item)
                <tr class="text-sm text-gray-600 border-b">
                    <td class="p-2 text-center">{{++$sn}}</td>
                    <td class="p-2">{{$item->name}}</td>
                    <td class="p-2 text-right">{{$item->qty}}</td>
                    <td class="p-2 text-right">{{$item->rate}}</td>
                    <td class="p-2 text-right">{{$item->qty*$item->rate}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-2 text-sm text-gray-500">
            <div class="w-full px-1 text-sm text-gray-400"><p>{{$invoice_data['notes']}}</p></div>
            <div class="w-full max-w-xs">
                @if($invoice_data['need_tax'])
                    <div class="flex justify-between py-1">
                        <span>Subtotal :</span>
                        <span>{{$invoice_data['total_amount']/(1+($invoice_data['tax_amount'] / 100)) }} {{$invoice_data->currency}}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Tax ({{$invoice_data['tax_amount']}}%) :</span>
                        <span>{{(($invoice_data['total_amount']/(1+($invoice_data['tax_amount'] / 100))) / 100)*$invoice_data['tax_amount']}} {{$invoice_data->currency}}</span>
                    </div>
                @endif
                <div class="flex justify-between py-1 text-base border-t border-gray-300 mt-0">
                    <span>Total     :</span>
                    <span>{{$invoice_data['total_amount']}} {{$invoice_data->currency}}</span>
                </div>
                @if($invoice_data['status']!='Paid')
                    <div class="flex justify-between py-0.5 font-normal text-red-400 border-t border-gray-50 mt-0">
                        <span>Due :</span>
                        <span>{{$invoice_data['total_amount']-$invoice_data['paid_amount']}} {{$invoice_data->currency}}</span>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="mt-1 text-sm text-gray-500">
        <p>Thank you for your business!</p>
    </div>
</div>
