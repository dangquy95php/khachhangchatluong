<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaCustomer;
use App\Models\User;
use App\Models\Customer;
use App\Models\HistoryCalled;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use \Cache;
use DB;
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
        if ($area_id) {
            Cache::forget('area_id'.\Auth::user()->id);
            Cache::forever('area_id'.\Auth::user()->id, $area_id);
            $area_id = Cache::get('area_id'.\Auth::user()->id);
            $areaCustomer = $areaCustomer->areaId($area_id);
        } else {
            $area_id = Cache::get('area_id'. \Auth::user()->id);
        }

        $areaCustomer = $areaCustomer->join('areas', 'areas_customers.area_id', '=', 'areas.id')
                            ->where('areas.status', self::AREA_ACTIVE)->with('customer_have_called_yet')
                            ->orderBy('areas_customers.updated_at', 'DESC')
                            ->select('areas_customers.*', 'areas.name')->first();

        $today = AreaCustomer::userId()->called()->today()
                        ->join('areas', 'areas_customers.area_id', '=', 'areas.id')
                        ->where('areas.status', self::AREA_ACTIVE)->with('customer')
                        ->orderBy('areas_customers.updated_at', 'DESC')
                        ->select('areas_customers.*', 'areas.name')->paginate(20);

        $history = AreaCustomer::userId()->called()->join('areas', 'areas_customers.area_id', '=', 'areas.id');

        $start_date = $request->get('start_date');
        $end_date =  Carbon::parse($request->get('end_date'))->addDay();
        if ($start_date && $end_date) {
            $history = $history->searchToday($start_date, $end_date);
        }

        $history = $history->select('areas.*')
                            ->where('areas.status', self::AREA_ACTIVE)->with('customer')
                            ->orderBy('areas_customers.updated_at', 'DESC')
                            ->select('areas_customers.*', 'areas.name')->paginate(20);

        $customer = new Customer();
        
        if ($areaCustomer) {
            $customer = $areaCustomer->customer_have_called_yet;
            $customer->area_name = $areaCustomer->name;
            $customer->area_id = $areaCustomer->area_id;
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
            DB::beginTransaction();
            try {
                $now = Carbon::now();
                $areaCustomer = AreaCustomer::findOrFail($request->get('id'));
                $areaCustomer->called = self::CALLED;
                $areaCustomer->updated_at = $now;
                $areaCustomer->save();

                $historyCalled = HistoryCalled::where('area_customer_id', $request->get('id'))->firstOrFail();
                $historyCalled->nam_dao_han = $request->nam_dao_han;
                $historyCalled->menh_gia = $request->money;
                $historyCalled->ten_kh = $request->last_name;
                $historyCalled->dien_thoai = $request->phone;
                $historyCalled->dia_chi_cu_the = $request->address_full;
                $historyCalled->tuoi = $request->age;
                $historyCalled->gioi_tinh = $request->sex;
                $historyCalled->type_call = $request->type_call;
                $historyCalled->comment = $request->comment;
                $historyCalled->updated_at = $now;
                $historyCalled->save();
                Toastr::success('Cập nhật thông tin khách hàng thàng công.');
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
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
            DB::beginTransaction();
            try {
                $now = Carbon::now();
                $areaCustomer = AreaCustomer::findOrFail($request->get('id'));
                $areaCustomer->called = self::CALLED;
                $areaCustomer->updated_at = $now;
                $areaCustomer->save();

                $historyCalled = HistoryCalled::where('area_customer_id', $request->get('id'))->first();
                $historyCalled->comment = $request->get('comment');
                $historyCalled->type_call = $request->get('type_call');
                $historyCalled->updated_at = $now;
                $historyCalled->save();
                Toastr::success('Cập nhật thông tin khách hàng thàng công.');
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                if (!empty($request->get('id'))) {
                    Toastr::error('Có lỗi khi cập nhật thông tin người dùng.' . $ex->getMessage());
                }
            }

            return redirect(route("home")."?area_id=". $request->get('area_name'));
        }
    }
}
