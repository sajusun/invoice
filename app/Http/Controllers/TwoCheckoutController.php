<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoCheckoutController extends Controller
{
    public function redirectToCheckout()
    {
        $merchant = env('TWOCHECKOUT_SELLER_ID');
        $secret   = env('TWOCHECKOUT_BUY_LINK_SECRET');
        $sandbox  = env('TWOCHECKOUT_SANDBOX') === 'true' ? 'sandbox.' : '';
        $url      = "https://{$sandbox}2checkout.com/checkout/buy";

        return view('payment-page.2checkout',compact('merchant'));

//        // Required parameters
//        $params = [
//            'merchant'             => $merchant,
//            'currency'             => 'USD',
//            'return-url'           => route('twocheckout.success'),
//            'items[0][name]'       => 'Premium Plan',
//            'items[0][quantity]'   => '1',
//            'items[0][price]'      => '20.00'
//        ];
//
//        // Build signature string
//        ksort($params);
//        $signatureString = '';
//        foreach ($params as $key => $value) {
//            $signatureString .= strlen($value) . $value;
//        }
//
//        // Generate HMAC-SHA256 signature
//        $signature = hash_hmac('sha256', $signatureString, $secret);
//        $params['signature'] = $signature;
//
//        // Final redirect
//        $finalUrl = $url . '?' . http_build_query($params);
//        return redirect()->away($finalUrl);
    }


    public function paymentSuccess(Request $request)
    {
        // Validate response here (optional — if using IPN / MD5 hash)
        // You can store transaction details if needed

        return view('payment-page.twocheckout-success');
    }
}
