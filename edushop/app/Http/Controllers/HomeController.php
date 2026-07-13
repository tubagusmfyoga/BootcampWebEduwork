<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pest\Support\View;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function productDetails(){
        return view ('product-details');
    }
}
