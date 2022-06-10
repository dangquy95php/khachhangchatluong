<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    private $_dataOrigin = '';

    public function __construct()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('account.login');
        // $this->_dataOrigin = User::find()->get();
    }

    public function index(Request $request)
    {
        $areas = User::find(Auth::user()->id)->area()->get();

        return view('index', compact('areas'));
    }

    public function detail(Request $request)
    {
        $id = $request->get('data_id');

        $customer = Customer::where('by_area', $id)->join('areas', 'customers.by_area', '=', 'areas.id')
        ->select('customers.*', 'areas.name')->first();

        \Log::info($customer);
        return response()->json($customer, Response::HTTP_OK);
    }
}
