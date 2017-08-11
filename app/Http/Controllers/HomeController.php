<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Torann\Currency\Facades\Currency;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Auth::user();

      \Stripe\Stripe::setApiKey("sk_test_j6CkUgJIE31MbMd9n1NeXeE3");
      if (empty($user->stripe_id)) {
        $str_account = \Stripe\Account::create(array(
          "type" => "custom",
          "country" => strtoupper($user->geo_code),
          "email" => $user->email
        ));

        $user->stripe_id = $str_account->id;
        $user->save();
      }

      $balance = \Stripe\Balance::retrieve(
        array("stripe_account" => $user->stripe_id)
      );

        //dd($balance->pending[0]->amount);
      //dd(currency($balance->pending->amount));

      return view('home',['balance'=>$balance]);
    }
}
