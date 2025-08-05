<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceService
{
    public static function invoiceIdGenerator(): string
    {
        $year = date("Y") % 10; // Get last digit of the year
        $month = date("m"); // Current month
        $day = date("d"); // Current day
        $randomNumber = str_pad(mt_rand(0, 9999), 4, "0", STR_PAD_LEFT); // 4-digit random number
        return $year . $month . $day . $randomNumber;
    }
//    Find an invoice by invoice_number
    public static function find_invoice($invoiceNumber)
    {
        return Auth::user()->invoices()->with(['customer:id,name,phone,email,address'])->where('invoice_number', $invoiceNumber)->first();
    }

//    Delete a Invoice by invoice_number
    public static function delete_invoice($invoiceNumber)
    {
        return Auth::user()->invoices()->where('invoice_number', $invoiceNumber)->delete();

    }

    public static function currency()
    {
       $user=Auth::user();
      return $user->settings->default_currency??'USD';
    }


}
