<?php

namespace App\Http\Controllers;

use App\Models\Invoice_Items;
use App\Models\Invoices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class InvoicesController extends Controller
{
    public function makeInvoice(Request $request): JsonResponse
    {
        $query = Invoices::create([
            'client_id' => Auth::id(),
            'invoice_date' => request('invoice_date'),
            'due_date' => request('due_date'),
            'total_amount' => request('total_amount'),
        ]);
        foreach ($request->raws as $datum) {
            $this->queryLoop($datum, $query->id);
        }

        if ($query) {
            return response()->json([
                "success" => true,
                "data" => $query
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => $query
        ]);
    }

    public function invoiceId_Maker(): string
    {
        $year = date("Y") % 10; // Get last digit of the year
        $month = date("m"); // Current month
        $day = date("d"); // Current day
        $randomNumber = str_pad(mt_rand(0, 9999), 4, "0", STR_PAD_LEFT); // 4-digit random number

        return  $year . $month . $day . $randomNumber;


    }

    private function queryLoop($query, $id): void
    {
        $query2 = Invoice_Items::create([
            'invoice_id' => $id,
            'description' => $query['description'],
            'quantity' => $query['quantity'],
            'unit_price' => $query['unit_price'],
//            'total_price'=>$query['total_price'],
        ]);
    }

    public function errorHandle(): string
    {
        return '@if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <span style="font-size: .8rem">{{ $error }}</span>
            @endforeach
        </div>
    @endif';
    }
}
