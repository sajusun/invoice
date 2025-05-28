{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    @include('custom-layouts.headTagContent')--}}
{{--    <title>Invoice Preview - Invozen</title>--}}
{{--    <style>--}}
{{--        @media print {--}}
{{--            .page-tools {--}}
{{--                display: none;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="page-tools flex">--}}
{{--    <div class="action-buttons p-4 flex items-end">--}}
{{--        <a class="bg-blue-400 hover:bg-blue-500 text-white text-sm py-2.5 px-5 mr-2 mb-2 rounded-sm transition duration-300"--}}
{{--           href="#" data-title="Print" onclick="window.print()">--}}
{{--            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>--}}
{{--            Print--}}
{{--        </a>--}}
{{--        <a class="bg-red-400 hover:bg-red-500 text-white text-sm py-2.5 px-5 mr-2 mb-2 rounded-sm transition duration-300"--}}
{{--           href="#" data-title="PDF">--}}
{{--            <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>--}}
{{--            Export--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="max-w-3xl mx-auto bg-white p-4 shadow-lg rounded-md mt-1">--}}
{{--    <div class="flex justify-between items-center border-b pb-4">--}}
{{--        <div>--}}
{{--            <h1 class="text-2xl font-bold text-gray-800">Invoice</h1>--}}
{{--            <p class="text-sm text-gray-500">{{$invoice_data['invoice_number']}}</p>--}}
{{--        </div>--}}
{{--        <div class="text-right">--}}
{{--            <p class="text-sm text-gray-600">Date: {{$invoice_data['invoice_date']}}</p>--}}
{{--            @if($invoice_data['status']=='Paid')--}}
{{--                <div--}}
{{--                    class="center relative inline-block select-none whitespace-nowrap rounded-lg bg-green-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">--}}
{{--                    <div class="mt-px">{{$invoice_data['status']}}</div>--}}
{{--                </div>--}}
{{--            @else--}}
{{--                <div--}}
{{--                    class="center relative inline-block select-none whitespace-nowrap rounded-lg bg-amber-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-black">--}}
{{--                    <div class="mt-px">{{$invoice_data['status']}}</div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="mt-6">--}}
{{--        <div class="flex justify-between">--}}
{{--            <div>--}}
{{--                <h2 class="text-lg font-semibold text-gray-700">Billed To:</h2>--}}
{{--                <p class="text-sm text-gray-600">{{$invoice_data->customer['name']}}</p>--}}
{{--                <p class="text-sm text-gray-600">{{$invoice_data->customer['address']}}</p>--}}
{{--                <p class="text-sm text-gray-600">{{$invoice_data->customer['phone']}}</p>--}}
{{--            </div>--}}
{{--            <div class="text-right">--}}
{{--                <h2 class="text-lg font-semibold text-gray-700">From:</h2>--}}
{{--                <p class="text-sm text-gray-600">{{$invoice_data['company_name']}}</p>--}}
{{--                <p class="text-sm text-gray-600">invozen.com</p>--}}
{{--                <p class="text-sm text-gray-600">support@invozen.com</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="mt-6">--}}
{{--        <table class="w-full table-auto border-t border-gray-200">--}}
{{--            <thead>--}}
{{--            <tr class="text-left text-sm text-gray-600 bg-gray-100">--}}
{{--                <th class="p-2 text-center w-2">#</th>--}}
{{--                <th class="p-2">Item</th>--}}
{{--                <th class="p-2 text-right">Qty</th>--}}
{{--                <th class="p-2 text-right">Price</th>--}}
{{--                <th class="p-2 text-right">Total</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @php--}}
{{--                $sn=0;--}}
{{--                 $items=json_decode($invoice_data->items) @endphp--}}
{{--            @foreach($items as $item)--}}
{{--                <tr class="text-sm text-gray-700 border-b">--}}
{{--                    <td class="p-2 text-center">{{++$sn}}</td>--}}
{{--                    <td class="p-2">{{$item->name}}</td>--}}
{{--                    <td class="p-2 text-right">{{$item->qty}}</td>--}}
{{--                    <td class="p-2 text-right">{{$item->rate}}</td>--}}
{{--                    <td class="p-2 text-right">{{$item->qty*$item->rate}}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}

{{--        <div class="flex justify-end mt-4 text-sm text-gray-700">--}}
{{--            <div class="w-full px-1 text-sm text-gray-400"><p>{{$invoice_data['notes']}}</p></div>--}}
{{--            <div class="w-full max-w-xs">--}}
{{--                @if($invoice_data['need_tax'])--}}
{{--                    <div class="flex justify-between py-1">--}}
{{--                        <span>Subtotal:</span>--}}
{{--                        <span>{{$invoice_data['total_amount']/(1+($invoice_data['tax_amount'] / 100)) }} {{$invoice_data->currency}}</span>--}}
{{--                    </div>--}}
{{--                    <div class="flex justify-between py-1">--}}
{{--                        <span>Tax ({{$invoice_data['tax_amount']}}%):</span>--}}
{{--                        <span>{{(($invoice_data['total_amount']/(1+($invoice_data['tax_amount'] / 100))) / 100)*$invoice_data['tax_amount']}} {{$invoice_data->currency}}</span>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="flex justify-between py-2 font-semibold border-t border-gray-300 mt-2">--}}
{{--                    <span>Total:</span>--}}
{{--                    <span>{{$invoice_data['total_amount']}} {{$invoice_data->currency}}</span>--}}
{{--                </div>--}}
{{--                    @if($invoice_data['status']!='Paid')--}}
{{--                    <div class="flex justify-between py-2 font-normal text-red-400 border-t border-gray-50 mt-0">--}}
{{--                        <span>Due:</span>--}}
{{--                        <span>{{$invoice_data['total_amount']-$invoice_data['paid_amount']}} {{$invoice_data->currency}}</span>--}}
{{--                    </div>--}}
{{--                    @endif--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="mt-6 text-sm text-gray-500">--}}
{{--        <p>Thank you for your business!</p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--</body>--}}

{{--</html>--}}

{{$invoice_data['name']}}
