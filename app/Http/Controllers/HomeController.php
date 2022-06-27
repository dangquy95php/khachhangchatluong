<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    const HAVENT_CALLED_YET = 0;
    const AREA_ACVITVE = 1;
    const CALLED = 1;

    public function index(Request $request)
    {   
        $areas = User::find(\Auth::id());
        $areas->setRelation('areas', $areas->areas()->get());
        
        // lay nguoi dung dau tien goi
        $customer = User::with("customer")->find(\Auth::user()->id);
        
        if (!empty($customer->customer)) {
            $id = $customer->customer->area_id;

            $area = $areas->areas->first(function ($value, $key) use($id) {
                return $value['id'] == $id;
            });

            $customer->customer->area_name = $area->name;
        }

        $history = User::find(\Auth::id());
        $history->setRelation('customers', $history->customers()->paginate(1));

        if(!empty($history)) {
            foreach($areas->areas as $area) {
                foreach($history->customers as &$item) {
                    if ($area->id == $item->area_id) {
                        $item->area_name = $area->name;
                    }
                }
            }
        }

        $customer = $customer->customer;

        return view('index', compact('customer', 'history', 'areas'));
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
dd(123);
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
