<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
class TagController extends Controller
{
    public function index()
    {
        return Tag::where('name', '<>', '')->select('name')->get();
    }
}
