<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function index(Request $request)
    {
        return view('excel.list');
    }

    public function history(Request $request)
    {
        return view('excel.history');
    }
}
