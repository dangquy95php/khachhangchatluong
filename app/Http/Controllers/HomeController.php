<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Response;
use \Cache;
class HomeController extends Controller
{
    const HAVENT_CALLED_YET = 0;
    const AREA_ACVITVE = 1;
    const CALLED = 1;

    public function index(Request $request)
    {
        $areas = User::find(\Auth::id());
        $areas->setRelation('areas', $areas->areas()->get());
        $area_id = $request->get('area_id');

        if ($area_id || isset($_COOKIE['area_id'])) {
            if ($area_id) {
                setcookie('area_id', $area_id, time() + (864000 * 30), "/");
                if(isset($_COOKIE['area_id']) && $_COOKIE['area_id'] == $area_id) {
                    $area_id = $_COOKIE['area_id'];
                }
            } else {
                $area_id =  $_COOKIE['area_id'];
            }

            $area = Area::findOrFail($area_id);
            $customer = User::with(["customer" => function($query) use($area_id) {
                $query->where(['customers.area_id' => $area_id]);
            }])->find(\Auth::user()->id);
        } else {
            // lay nguoi dung dau tien goi
            $customer = User::with("customer")->find(\Auth::user()->id);
        }

        $history = User::find(\Auth::id());
        $start_date = $request->get('start_date');
        $end_date =  Carbon::parse($request->get('end_date'))->addDay();
        if ($start_date && $end_date) {
            $history->setRelation('customers', $history->customers()
                ->where('customers.updated_at', '>=' , $start_date)
                ->where('customers.updated_at', '<=' , $end_date)
                ->paginate(20));
        } else {
            $history->setRelation('customers', $history->customers()->paginate(20));
        }

        $todayData = User::find(\Auth::id());
        $todayData->setRelation('customers', $todayData->customers()->where('customers.updated_at', '>=' ,Carbon::today())->get());

        $customer = $customer->customer;
        $today = $todayData->customers;

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
