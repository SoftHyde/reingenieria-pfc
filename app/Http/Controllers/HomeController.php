<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;

class HomeController extends Controller
{
    public function index()
    {
    	$actions = Action::paginate();

        return view('home/home', compact('actions'));
    }

}
