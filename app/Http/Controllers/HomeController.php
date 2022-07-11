<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaCustomer;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use \Cache;
class HomeController extends Controller
{
    const HAVENT_CALLED_YET = 0;
    const AREA_ACTIVE = 1;
    const CALLED = 1;

    public function index(Request $request)
    {
        $area_id  = $request->get('area_id');
        $areas    = User::with('areas')->find(\Auth::id());

        if ($area_id) {
            $customer = Area::with(['customer' => function($query) use($area_id) {
                $query->where('area_id', '=', $area_id)->first();
            }])->where([
                'id' => $area_id,
                'status' => self::AREA_ACTIVE
            ])->first();
        } else {
            $customer = Area::with(['customer' => function($query) {
                $query->first();
            }])->first();
        }
        
        $today    = Customer::with('customers_today')->paginate(20);
        $history  = Customer::with('customers_history')->paginate(20);

        return view('index', compact('customer', 'history', 'areas', 'today'));
    }

    public function updateCusomter(Request $request)
    {
        if ($_POST['action'] == 'save') {
            if (!empty($request->get('id'))) {
                $request->validate([
                    'type_call' => 'required',
                    'area_name' => 'required'
                ], [
                    'type_call.required' => 'Vui lòng chọn kết quả gọi',
                    'area_name.required' => 'Vui lòng chọn nguồn dữ liệu'
                ]);
            }
            try {
                $customer = Customer::find($request->id);
                $customer->nam_dao_han = $request->nam_dao_han;
                $customer->menh_gia = $request->money;
                $customer->ten_kh = $request->last_name;
                $customer->dien_thoai = $request->phone;
                $customer->dia_chi_cu_the = $request->address_full;
                $customer->tuoi = $request->age;
                $customer->gioi_tinh = $request->sex;
                $customer->type_call = $request->type_call;
                $customer->comment = $request->comment;

                $customer->save();
                Toastr::success('Cập nhật thông tin khách hàng thàng công.');
            } catch (\Exception $ex) {
                if (!empty($request->get('id'))) {
                    Toastr::error('Có lỗi khi cập nhật thông tin người dùng.' . $ex->getMessage());
                }
            }
            return redirect()->back();
        } else if ($_POST['action'] == 'next') {

            if($request->get('id')) {
                $request->validate([
                    'type_call' => 'required',
                    'area_name' => 'required'
                ], [
                    'type_call.required' => 'Vui lòng chọn kết quả gọi',
                    'area_name.required' => 'Vui lòng chọn nguồn dữ liệu'
                ]);
            }

            try {
                $customer = Customer::findOrFail($request->get('id'));
                $customer->type_call = $request->get('type_call');
                $customer->comment = $request->get('comment');
                $customer->called = self::CALLED;
                $customer->save();
                Toastr::success('Cập nhật thông tin khách hàng thàng công.');
            } catch (\Exception $ex) {
                if (!empty($request->get('id'))) {
                    Toastr::error('Có lỗi khi cập nhật thông tin người dùng.' . $ex->getMessage());
                }
            }

            return redirect(route("home")."?area_id=". $request->get('area_name'));
        }
    }
}
