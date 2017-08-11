<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $user = Auth::user();

      return view('payment.test');
    }

    public function process(Request $request) {
        $user = Auth::user();
        $input = $request->all();

        $token = $request->input('stripeToken');

        $affiliate_cut = 0.25;

        \Stripe\Stripe::setApiKey("sk_test_j6CkUgJIE31MbMd9n1NeXeE3");

        $price = 10000;
        $fee = floor($price * (1-$affiliate_cut));

        \Stripe\Charge::create(array(
            "amount"          => $price,
            "currency"        => "dkk",
            "application_fee" => $fee,
            "source"          => $token, // obtained with Stripe.js
            "description"     => "Testing charge",
            "destination"     => [
                "account" => $user->stripe_id
            ]
        ));

        return 'OK';

        }
}
