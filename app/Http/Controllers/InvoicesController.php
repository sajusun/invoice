<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Invoice_Items;
use App\Models\Invoices;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;


class InvoicesController extends Controller
{
    public function makeInvoice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'issue_to' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'date' => 'required|date',
            'currency' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $user = User::find(Auth::id());
//        search have any existing customer
        $customer = $user->customers()->where('phone', request('phone'))->first();
        if (!$customer) {
//            insert new customer
            $customer = Customers::create([
                'user_id' => Auth::id(),
                'name' => request('issue_to'),
                'phone' => request('phone'),
                'email' => request('email'),
                'address' => request('address'),
            ]);
        }


        //second query - inset invoice
        $invoice = Invoices::create([
            'user_id' => Auth::id(),
            'customer_id' => $customer->id,
            'invoice_number' => request('invoice_number'),
            'invoice_date' => request('date'),
            'items' => json_encode(request('items')),
            'tax_amount' => request('tax'),
            'need_tax' => request('need_tax'),
            'notes' => request('invoiceNotes'),
            'currency' => request('currency'),
            'paid_amount' => request('amount_paid'),
            'total_amount' => request('amount_total'),
        ]);

        return response()->json([
            "success" => $invoice,
            "data" => Request('items'),
            "data2" => $customer
        ]);

    }

    public function invoiceId_Maker(): string
    {
        $year = date("Y") % 10; // Get last digit of the year
        $month = date("m"); // Current month
        $day = date("d"); // Current day
        $randomNumber = str_pad(mt_rand(0, 9999), 4, "0", STR_PAD_LEFT); // 4-digit random number
        return $year . $month . $day . $randomNumber;
    }

    public function get_all_invoices(): Collection
    {
        //return all invoices for current user
        return Invoices::with('customer')->where('user_id', Auth::id())->get();
    }

//    return a specific customers invoice
    public function find_invoice($id): array
    {
        return User::find(Auth::id())->invoices->where('customer_id', $id)->all();
    }

    public function num_of_invoices()
    {
        return User::find(Auth::id())->invoices->count();
    }

    public function get_invoice(Request $id): JsonResponse
    {
        $invoices = Invoices::all()->where('user_id', Auth::id())->where('id', $id);
        return response()->json($invoices);
    }


    public function sum_of_total()
    {
        return Invoices::where('user_id', Auth::id())->sum('total_amount');
    }

    public function invoice_status()
    {
        return Invoices::where('user_id', Auth::id())->get('status')->count();
    }

//    public function errorHandle(): string
//    {
//        return '@if ($errors->any())
//        <div class="alert alert-danger">
//            @foreach ($errors->all() as $error)
//                <span style="font-size: .8rem">{{ $error }}</span>
//            @endforeach
//        </div>
//    @endif';
//    }
}
