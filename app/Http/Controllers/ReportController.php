<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\User;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $listCallOfStaff = User::with('customers_today_called')->get();

        return view('report.index', compact('listCallOfStaff'));
    }
}
