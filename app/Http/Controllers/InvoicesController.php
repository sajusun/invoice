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
        $query=Invoices::create([
            'client_id'=>Auth::id(),
            'invoice_date'=>request('invoice_date'),
            'due_date'=>request('due_date'),
            'total_amount'=>request('total_amount'),
            ]);
        foreach ($request->raws as $datum) {
             $this->queryLoop($datum,$query->id);
        }
    {

       };
        if($query){
            return response()->json([
                "success"=>true,
                "data"=>$query
            ]);
        }
        return response()->json([
            "success"=>false,
            "data"=>$query
        ]);
    }

    private function queryLoop($query, $id): void
    {
        $query2=Invoice_Items::create([
            'invoice_id'=>$id,
            'description'=>$query['description'],
            'quantity'=>$query['quantity'],
            'unit_price'=>$query['unit_price'],
//            'total_price'=>$query['total_price'],
        ]);
    }

}
