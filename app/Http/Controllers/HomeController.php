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
use Carbon\Carbon;

class HomeController extends Controller
{
    const HAVENT_CALLED_YET = 0;
    const AREA_ACTIVE = 1;
    const CALLED = 1;

    public function index(Request $request)
    {
        $area_id  = $request->get('area_id');
        $areas    = User::with('areas')->findOrFail(\Auth::id());

        $areaCustomer = AreaCustomer::userId()->haveCalledYet();
        if ($area_id)
            $areaCustomer = $areaCustomer->areaId($area_id);

        $areaCustomer = $areaCustomer->leftJoin('areas', 'areas_customers.area_id', '=', 'areas.id')
                            ->where('areas.status', self::AREA_ACTIVE)->with('customer_have_called_yet')
                            ->orderBy('areas_customers.updated_at', 'DESC')->first();

        $today =  AreaCustomer::userId()->called()->today()
                        ->leftJoin('areas', 'areas_customers.area_id', '=', 'areas.id')
                        ->where('areas.status', self::AREA_ACTIVE)->with('customer')
                        ->orderBy('areas_customers.updated_at', 'DESC')->paginate(20);

        $history  = AreaCustomer::userId()->called()
                                ->leftJoin('areas', 'areas_customers.area_id', '=', 'areas.id')
                                ->where('areas.status', self::AREA_ACTIVE)->with('customer')
                                ->orderBy('areas_customers.updated_at', 'DESC')->paginate(20);

        $customer = new Customer();
        if ($areaCustomer) {
            $customer = $areaCustomer->customer_have_called_yet;
            $customer->area_name = $areaCustomer->name;
            $customer->area_id = $areaCustomer->id;
        }

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
                $areaCustomer = AreaCustomer::findOrFail($request->id);
                $areaCustomer->nam_dao_han = $request->nam_dao_han;
                $areaCustomer->menh_gia = $request->money;
                $areaCustomer->ten_kh = $request->last_name;
                $areaCustomer->dien_thoai = $request->phone;
                $areaCustomer->dia_chi_cu_the = $request->address_full;
                $areaCustomer->tuoi = $request->age;
                $areaCustomer->gioi_tinh = $request->sex;
                $areaCustomer->type_call = $request->type_call;
                $areaCustomer->comment = $request->comment;

                $areaCustomer->save();
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
                $areaCustomer = AreaCustomer::findOrFail($request->get('id'));
                $areaCustomer->type_call = $request->get('type_call');
                $areaCustomer->comment = $request->get('comment');
                $areaCustomer->called = self::CALLED;
                $areaCustomer->updated_at = Carbon::now();
                $areaCustomer->save();
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
