<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public static function find_invoice($invoice_number)
    {
        return Auth::user()->invoices()->with(['customer:id,name,phone,email,address'])->where('invoice_number', $invoice_number)->first();
    }
}
