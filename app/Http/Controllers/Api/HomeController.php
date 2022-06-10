<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;
use App\Models\Customer;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    private $_dataOrigin = '';

    public function detail(Request $request)
    {
        $id = $request->get('data_id');

        $customer = Customer::where('by_area', 2)->join('areas', 'customers.by_area', '=', 'areas.id')
        ->select('customers.*', 'areas.name')->first();

        return response()->json($customer, Response::HTTP_OK);
    }
}
