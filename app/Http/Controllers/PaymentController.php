<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Card;
use Stripe\StripeClient;

class PaymentController extends Controller
{
public function create(Order $order){
    return view('Admin.payments.create',
    [
        'order'=>$order
    ]);
}

public function  createStripePaymentIntent(Order $order){
    $stripe = new StripeClient("sk_test_51NZULnGUj5L3qAnS1QJwDj8CZZy9wsV1q6cOGzin6UcQR23I3QzefLzci1cZZ5Zo4r7dtrSWX96Q0FwzQ10mw0ct00sgIyQqZb");
   
    try {
      $paymentInten = $stripe->paymentIntents->create([
          'amount' => $order->total,
          'currency' => 'usd',
          'automatic_payment_methods' => [
              'Card',
          ],
      ]);

      return [
          'clientSecret' => $paymentInten->client_secret,
      ];
  } catch (\Stripe\Exception\ApiErrorException $e) {
     
      return response()->json(['error' => $e->getMessage()], 500);
  }

}


public function confirm(Request $request,  Order $order){
  dd($request->all());
}



}
