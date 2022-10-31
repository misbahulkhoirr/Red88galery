<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2 ) {
            return redirect('fish');
        } else if (auth()->user()->role_id == 3 ) {
            return redirect('fish');
        } else if (auth()->user()->role_id == 4){
            return redirect('sales');
        }
    }
}
