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
use App\Models\AreaCustomer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $_dataOrigin = '';
    private $_dataHistory = '';

    public function __construct()
    {
        // if (Auth::check()) {
        //     return redirect()->route('home');
        // }
       
        // return view('account.login');
        // $this->_dataOrigin = User::find()->get();
    }

    public function index(Request $request)
    {
        // $dataHistory = Customer::query('type_result')
        // ->notNullOnly()->join('areas_users', function($join) {
        //     $join->on('customers.area_name', '=', 'areas_users.id_area')
        //     ->where('areas_users.id_user', Auth::user()->id);
        // })->join('areas', 'areas.id',  '=', 'areas_users.id_area')
        // ->select('customers.*', 'areas.name as name_areas')
        // ->orderBy('customers.updated_at', 'DESC')
        // ->get();

        // Lấy danh muc
        $areas = \DB::table('areas_users')
                ->join('areas', 'areas_users.id_area', 'areas.id')
                ->where('areas_users.id_user', Auth::user()->id)
                ->select('areas.*')->get();

        $customer = new Customer();
        if (count($areas) > 0) {
            $data_id = $areas[0]->id;
            $customer = AreaCustomer::with('customer')->orderBy('updated_at', 'DESC')->first();
        }
        
        // foreach($customer as $item) {
        //     if (count($item->customer) > 0 ) {
        //         $customer = $item;
        //         break;
        //     }
        // }

        //nhat ky cuoc goi
        return view('index', compact('areas', 'customer'));
        // return view('index', compact('areas', 'customer', 'dataHistory'));

    }

    public function save(Request $request)
    {
        if (empty($request->get('id')))
            return redirect()->back();
        
        $request->validate([
            'type_result' => 'required',
            'area_name' => 'required'
        ], [
            'type_result.required' => 'Vui lòng chọn kết quả gọi',
            'area_name.required' => 'Vui lòng chọn nguồn dữ liệu' 
        ]);

        try {
            $customer = Customer::find($request->get('id'));
            $customer->type_result = $request->get('type_result');
            $customer->comment = $request->get('comment');

            if($customer->isDirty()) {
                Toastr::success('Thông tin khách hàng đã thay đổi thành công.');
            } else {
                Toastr::warning('Dữ liệu chưa được lưu');
            }

            $customer->save();
        } catch (\Exception $ex) {
            Toastr::error('Lưu khách hàng thất bại'. $ex->getMessage());
        }
        
        return redirect()->route('customer_detail', $request->get('id'));
    }

    public function detail($id, Request $request)
    {
        $areas = \DB::table('areas_users')
                ->join('areas', 'areas_users.id_area', 'areas.id')
                ->where('areas_users.id_user', Auth::user()->id)
                ->select('areas.*')->get();

        $customer = new Customer();
        if (count($areas) > 0) {
            $data_id = $areas[0]->id;
            $customer = AreaCustomer::with('customer')->orderBy('updated_at', 'DESC')->first();
        }
        //nhat ky cuoc goi
        return view('index', compact('areas', 'customer'));
    }

    public function update(Request $request)
    {
        if (empty($request->get('id')))
            return redirect()->back();
        
        $request->validate([
            'type_result' => 'required',
            'area_name' => 'required'
        ], [
            'type_result.required' => 'Vui lòng chọn kết quả gọi',
            'area_name.required' => 'Vui lòng chọn nguồn dữ liệu' 
        ]);

        try {
            $customer = Customer::find($request->get('id'));
            $customer->type_result = $request->get('type_result');
            $customer->comment = $request->get('comment');

            // update danh muc, khu vuc va nhan vien
            $category = AreaCustomer::where('customer_id', $request->get('id'))->first();
            $category->customer_id= $request->get('area_name');

            if($customer->isDirty() || $customer->isDirty()) {
                Toastr::success('Thông tin khách hàng đã thay đổi thành công.');
            } else {
                Toastr::warning('Dữ liệu chưa được cập nhật');
            }

            $category->save();
            $customer->save();
        } catch (\Exception $ex) {

            Toastr::error('Cập nhật khách hàng thất bại'. $ex->getMessage());
        }

        return \Redirect::route('customer_detail', $request->get('id'));
    }
}
