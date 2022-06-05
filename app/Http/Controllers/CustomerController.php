<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.list');
    }

    public function search(Request $request)
    {
        return view('customer.search');
    }
}
