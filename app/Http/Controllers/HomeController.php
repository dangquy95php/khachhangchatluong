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

        $re = '/([0-9]{4})([0-9]{2})([0-9]{2})/';

        preg_match_all($re, $customer->join_date, $matches, PREG_SET_ORDER, 0);
        preg_match_all($re, $customer->date_due_full, $matches1, PREG_SET_ORDER, 0);

        $customer->join_date = $matches;
        $customer->date_due_full = $matches1;
        
        \Log::info($customer);
        // Print the entire match result
        // var_dump($matches);

        return response()->json($customer, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'info_option' => 'required',
        ],[
           'info_option.required' => 'Vui lòng chọn kết quả gọi' 
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        $model = new Customer();
        $model->info_option = $request->get('info_option');
        $model->comment = $request->get('comment');
        $model->save();
        \Log::info($request->all());

        return response()->json(['message' => 'Cập nhật thông tin thành công!'], Response::HTTP_OK);
    }
}
