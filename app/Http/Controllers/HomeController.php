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

    public function index(Request $request)
    {   
        
        // Lấy danh muc
        $areas = \DB::table('areas_users')
            ->join('areas', 'areas_users.id_area', 'areas.id')
            ->where('areas_users.id_user', Auth::user()->id)
            ->select('areas.*')->get();

        $customer = new Customer();
        if ($request->get('area_id')) {
            $data_id = $request->get('area_id');

            //đếm số dòng chưa gọi -> mới hiển thị
            if ($customer = AreaCustomer::where('area_id', $data_id)
                ->join('customers', 'areas_customers.customer_id', 'customers.id')
                ->where('called', '=', '')->count() > 0
            ) {
                $customer = AreaCustomer::where('area_id', $data_id)
                    ->join('customers', 'areas_customers.customer_id', 'customers.id')
                    ->where('called', '=', '')->first();
            }
        } else {
            if (count($areas) > 0) {
                for ($i = 0; $i < count($areas); $i++) {
                    $data_id = $areas[$i]->id;
    
                    //đếm số dòng chưa gọi -> mới hiển thị
                    if ($customer = AreaCustomer::where('area_id', $data_id)
                        ->join('customers', 'areas_customers.customer_id', 'customers.id')
                        ->where('called', '')->count() > 0
                    ) {
                        $customer = AreaCustomer::where('area_id', $data_id)
                                        ->join('customers', 'areas_customers.customer_id', 'customers.id')
                                        ->where('called', '')->first();
                        break;
                    } else {
                        continue;
                    }
                }
            }
        }

        $startDate = $request->get('start_date');
        $endDate = \Carbon\Carbon::parse($request->get('end_date'))->addDays(1);

        $todayData = \DB::table('areas_users')
            ->where('areas_users.id_user', Auth::user()->id)
            ->join('areas', 'areas_users.id_area', '=', 'areas.id')
            ->join('areas_customers', 'areas.id', '=', 'areas_customers.area_id')
            ->join('customers', 'areas_customers.customer_id', '=', 'customers.id')
            ->where('customers.called', '<>', '')
            ->whereDate('customers.updated_at', \Carbon\Carbon::today())
            ->orderBy('customers.updated_at', 'DESC')
            ->select('customers.*', 'areas.name')
            ->get();

        if ($startDate && $endDate) {
            $dataHistory = \DB::table('areas_users')
            ->where('areas_users.id_user', Auth::user()->id)
            ->join('areas', 'areas_users.id_area', '=', 'areas.id')
            ->join('areas_customers', 'areas.id', '=', 'areas_customers.area_id')
            ->join('customers', 'areas_customers.customer_id', '=', 'customers.id')
            ->where('customers.called', '<>', '')
            ->whereDate('customers.updated_at', '>=', $startDate)
            ->whereDate('customers.updated_at', '<=', $endDate)
            ->orderBy('customers.updated_at', 'DESC')
            ->select('customers.*', 'areas.name')
            ->paginate(100);
        } else {
            $dataHistory = \DB::table('areas_users')
            ->where('areas_users.id_user', Auth::user()->id)
            ->join('areas', 'areas_users.id_area', '=', 'areas.id')
            ->join('areas_customers', 'areas.id', '=', 'areas_customers.area_id')
            ->join('customers', 'areas_customers.customer_id', '=', 'customers.id')
            ->where('customers.called', '<>', '')
            ->orderBy('customers.updated_at', 'DESC')
            ->select('customers.*', 'areas.name')
            ->paginate(200);
        }

        return view('index', compact('areas', 'customer', 'dataHistory', 'todayData'));
    }

    public function updateCusomter(Request $request)
    {
        if ($_POST['action'] == 'save') {
            if (!empty($request->get('id'))) {
                $request->validate([
                    'type_result' => 'required',
                    'area_name' => 'required'
                ], [
                    'type_result.required' => 'Vui lòng chọn kết quả gọi',
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
                $customer->type_result = $request->type_result;
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
                    'type_result' => 'required',
                    'area_name' => 'required'
                ], [
                    'type_result.required' => 'Vui lòng chọn kết quả gọi',
                    'area_name.required' => 'Vui lòng chọn nguồn dữ liệu'
                ]);
            }

            try {
                $customer = Customer::find($request->get('id'));
                $customer->type_result = $request->get('type_result');
                $customer->comment = $request->get('comment');
                $customer->called = 1;
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
