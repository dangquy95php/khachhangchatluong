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
        // Lấy danh muc
        $areas = \DB::table('areas_users')
                ->join('areas', 'areas_users.id_area', 'areas.id')
                ->where('areas_users.id_user', Auth::user()->id)
                ->select('areas.*')->get();

        $customer = new Customer();

        if (count($areas) > 0) {
            for ($i = 0; $i < count($areas); $i++) {
                $data_id = $areas[$i]->id;
                
                //đếm số dòng chưa gọi -> mới hiển thị
                if($customer = AreaCustomer::where('area_id', $data_id)
                ->join('customers', 'areas_customers.customer_id', 'customers.id')
                ->where('type_result', '=', '')->count() > 0) {
                    //dd(123);
                    $customer = AreaCustomer::where('area_id', $data_id)
                    ->join('customers', 'areas_customers.customer_id', 'customers.id')
                    ->where('type_result', '=', '')->first();
                    break;
                } else {
                    continue;
                }
            }
        }

        $dataHistory = \DB::table('areas_users')
            ->where('areas_users.id_user', Auth::user()->id)
            ->join('areas', 'areas_users.id_area', '=', 'areas.id')
            ->join('areas_customers', 'areas.id', '=', 'areas_customers.area_id')
            ->join('customers', 'areas_customers.customer_id', '=', 'customers.id')
            ->where('customers.type_result', '<>', '')
            ->orderBy('customers.updated_at', 'DESC')
            ->select('customers.*', 'areas.name')
            ->get();

        return view('index', compact('areas', 'customer', 'dataHistory'));
    }

    public function updateCusomter(Request $request)
    {
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
            $customer->save();
            Toastr::success('Cập nhật thông tin khách hàng thàng công.');
        } catch (\Exception $ex) {
            Toastr::error('Có lỗi khi cập nhật thông tin người dùng.'. $ex->getMessage());
        }

        return redirect()->route('home');
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

            // update danh muc, khu vuc va nhan vien
            $category = AreaCustomer::where('customer_id', $request->get('id'))->first();
            $category->customer_id= $request->get('area_name');

            if($customer->isDirty() || $category->isDirty()) {
                Toastr::success('Thông tin khách hàng đã thay đổi thành công.');
            } else {
                Toastr::warning('Dữ liệu chưa được lưu');
            }
            $category->save();
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

            $customer = AreaCustomer::where('area_id', $data_id)
                        ->join('customers', 'areas_customers.customer_id', 'customers.id')
                        ->where('type_result', '=', '')->first();
        }

        return view('index', compact('areas', 'customer'));


        // $customer = Customer::query()
        // ->join('areas_customers', 'customers.id', 'areas_customers.customer_id')
        // ->where('customers.id', $id)
        // ->select('*')->get();

        // dd($customer);
        // // $customer = AreaCustomer::where('area_id', $data_id)
        // //             ->join('customers', 'areas_customers.customer_id', 'customers.id')
        // //             ->where('type_result', '=', '')->first();

        // $areas = \DB::table('areas_users')
        // ->join('areas', 'areas_users.id_area', 'areas.id')
        // ->where('areas_users.id_user', Auth::user()->id)
        // ->select('areas.*')->get();
        // dd($customer);

        // return view('index', compact('areas', 'customer'));
    }

    public function postDetail($id, Request $request)
    {
         // update danh muc, khu vuc va nhan vien
         try {
            $customer = Customer::find($id);
            $customer->type_result = $request->get('type_result');
            $customer->comment = $request->get('comment');

            // update danh muc, khu vuc va nhan vien
            $category = AreaCustomer::where('customer_id', $id)->first();
            $category->customer_id= $request->get('area_name');

            if($customer->isDirty() || $category->isDirty()) {
                Toastr::success('Thông tin khách hàng đã thay đổi thành công.');
            } else {
                Toastr::warning('Dữ liệu chưa được lưu');
            }
            $category->save();
            $customer->save();
        } catch (\Exception $ex) {
            Toastr::error('Lưu khách hàng thất bại'. $ex->getMessage());
        }

        return redirect()->back('customer_detail', $id);
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
