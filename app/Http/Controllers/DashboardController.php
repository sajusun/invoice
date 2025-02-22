<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
   public function dashboard():View
   {
       $invoice_ctrl = new InvoicesController();
       $data=$invoice_ctrl->get_all_invoices();
        return view('dashboard',['num_of_invoices'=>$data['num_of_invoices'],'invoices'=>$data['invoices']]);
    }

}
