<?php
namespace App\Services;

 use Illuminate\Support\Facades\Auth;

 class CustomerService {

     public static function delete_customer($customerId)
     {
         return Auth::user()->customers()->where('id', $customerId)->delete();
     }
}
