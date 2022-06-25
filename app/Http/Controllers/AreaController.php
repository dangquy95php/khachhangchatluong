<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;
use App\Models\AreaCustomer;
use DB;

class AreaController extends Controller
{
    public $_status = '';
    public $dataAreas = '';
    public $dataCustomers = '';

    const CUSTOMER_ACTIVE = 1;
    const USER_ACTIVE = 1;

    public function __construct()
    {
        $this->_status = Area::getStatus();
        $this->dataAreas = Area::select('name', 'id', 'note', 'created_at')->opening()->get();
        $this->dataCustomers = Customer::select('*')->get();
    }

    public function index(Request $request)
    {
        $areas = Area::all();

        return view('area.list', ['areas' =>  $areas, 'area_status' => $this->_status]);
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:areas|min:2',
        ],[
            'name.required' => 'Tên khu vực bắt buộc phải có',
            'name.unique' => 'Tên khu vực đã tồn tại',
            'name.min' => 'Tên khu vực quá ngắn'
        ]);

        $data = $request->all();
        $product = Area::create($data);
        if ($product) {
            Toastr::success("Tạo khu vực ". $request->get('name') ." thành công!");
        } else {
            Toastr::error("Tạo khu vực ". $request->get('name') ." thất bại!");
        }

        return redirect()->route('index_area');
    }

    public function edit($id, Request $request)
    {
        $area = Area::find($id);
        $areas = Area::all();

        return view('area.list', ['area' =>  $area, 'areas' =>  $areas, 'area_status' => $this->_status ]);
    }

    public function postEdit($id, Request $request)
    {
        $model = Area::find($id);
        $model->name = $request->get('name');
        $model->status = $request->get('status');
        $model->note = $request->get('note');

        try {
            $model->update();
            Toastr::success("Cập nhật khu vực ". $model->name ." thành công!");
        } catch (\Exception $ex) {
            Toastr::error("Cập nhật khu vực ". $model->name ." thất bại!". $ex->getMessage());
        }

        return redirect()->route('index_area');
    }

    public function delete($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $areas = Area::find($id);
            $areas->delete();
            $ids = AreaCustomer::where('area_id', $id)->pluck('customer_id')->toArray();
            AreaCustomer::where('area_id', $id)->delete();
            Customer::whereIn('id', $ids)->delete();
            Toastr::success("Xoá khu vực ". $areas->name ." thành công!");
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            Toastr::error("Xoá khu vực ". $areas->name ." thất bại!". $ex->getMessage());
        }

        return redirect()->route('index_area');
    }

    public function customerByArea(Request $request)
    {
        $customers = \DB::table('areas_customers AS t1')
        ->select('t1.customer_id')
        ->rightJoin('customers AS t2', 't2.id','=', 't1.customer_id')
        ->whereNull('t1.id')->select('t2.*')->get();

        return view('area.customer-by-area', ['areas' => $this->dataAreas, 'customers' => $customers]);
    }

    public function postCustomerByArea(Request $request)
    {
        $request->validate([
            'area' => 'required',
        ], [
            'area.required' => 'Vui lòng chọn khu vực.',
        ]);

        $ids = $request->input('choose_customers');

        if (empty($ids)) {
            Toastr::error("Khách hàng chưa được chọn! ");
            return redirect()->back();
        }
        $data = explode('_', $request->input('area'));

        DB::beginTransaction();
        try {
            $dataSet = [];
            foreach ($ids as $custtomer) {
                $model = new AreaCustomer();
                $model->area_id = $data[0];
                $model->customer_id = $custtomer;
                $model->save();
            }

            DB::commit();
            Toastr::success("Đã thêm một số khách hàng vào khu vực ". $data[1]);
        } catch (\Exception $ex) {
            DB::rollback();
            Toastr::error("Cấp quyền cho khu vực bị thất bại! ". $ex->getMessage());
        }
        return redirect()->back();
    }

    public function addAreaToUser(Request $request)
    {
        $users = User::where('status', self::USER_ACTIVE )->get();
        $areas_users = Area::rightJoin('areas_users', 'areas.id', '=', 'areas_users.id_area')->select('areas.name', 'areas.id', 'areas_users.*')->get();

        return view('area.add-area-to-user', [ 'areas' => $this->dataAreas, 'users' => $users, 'areas_users' => $areas_users ]);
    }

    public function postAddAreaToUser(Request $request)
    {
        $userArea = \DB::table('users')->leftJoin('areas_users', 'users.id', '=', 'areas_users.id_user')
                    ->join('areas', 'areas_users.id_area', '=', 'areas.id')
                    ->select('users.*', 'areas.id as area_id', 'areas.name')->get();
                    
        $data = $request->get('user_area');
        AreaUser::truncate();

        collect($data)->contains(function ($value, $key) use($userArea) {

            \DB::beginTransaction();
            try {
                foreach($value as $item) {
                    $model = new AreaUser();
                    $model->id_area = $item;
                    $model->id_user = $key;
                    $model->save();
                }
                \DB::commit();
            } catch (\Exception $ex) {
                Toastr::error("Cấp quyền cho khu vực thất bại! ". $ex->getMessage());
                \DB::rollback();

                return redirect()->route('index_area');
            }
        });

        Toastr::success("Cấp quyền khu vực cho nhân viên thành công!");

        return redirect()->back();
    }

    public function delAreaToUser($id) {
        try {
            $area_user = AreaUser::find($id);
            Toastr::success("Xóa quyền khu vực cho nhân viên thành công");
            $area_user->delete();
            return redirect()->route('add_area_to_user');
        } catch (\Exception $ex) {
            Toastr::error("Xóa quyền cho khu vực thất bại! ". $ex->getMessage());
            return redirect()->route('add_area_to_user');
        }
    }
}
