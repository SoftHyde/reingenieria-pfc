<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  /*   public function __construct()
   {
        $this->middleware('guest');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::paginate();
        return view('home/home',compact('actions'));
    }
}
