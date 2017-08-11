<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        if( env('APP_ENV') != 'local' && ! $request->secure())
        {
            return Redirect::secure($request->path());
        }

        return view('welcome');
    }
}
