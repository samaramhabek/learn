<?php

namespace App\Http\Controllers;



use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class StripeController extends Controller
{

    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        
       
        Stripe::setApiKey('sk_test_51NZULnGUj5L3qAnS1QJwDj8CZZy9wsV1q6cOGzin6UcQR23I3QzefLzci1cZZ5Zo4r7dtrSWX96Q0FwzQ10mw0ct00sgIyQqZb');
        
        Charge::create ([
                "amount" => 100*100,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "This payment is testing purpose of techsolutionstuff",
        ]);
   
        Session::flash('success', 'Payment Successfull!');
           
        return back();
    }
        
}
