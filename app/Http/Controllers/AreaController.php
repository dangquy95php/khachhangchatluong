<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;

class AreaController extends Controller
{
    public $_status = '';
    public $dataAreas = '';
    public $dataCustomers = '';

    const CUSTOMER_ACTIVE = 1;

    public function __construct()
    {
        $this->_status = Area::getStatus();
        $this->dataAreas = Area::select('name', 'id', 'note', 'created_at')->opening()->get();
        $this->dataCustomers = Customer::select('id', 'id_contract', 'join_date', 'money', 'date_due', 'month_due', 'year_due', 'last_name', 'first_name', 'sex', 'date_birth', 'phone', 'home', 'ward', 'district', 'province')->byArea()->get();
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
        try {
            $areas = Area::find($id);
            $areas->delete();
            Toastr::success("Xoá khu vực ". $areas->name ." thành công!");
        } catch (\Exception $ex) {
            Toastr::error("Xoá khu vực ". $areas->name ." thất bại!". $ex->getMessage());
        }

        return redirect()->route('index_area');
    }

    public function customerByArea(Request $request)
    {
        return view('area.customer-by-area', ['areas' => $this->dataAreas, 'customers' => $this->dataCustomers]);
    }

    public function postCustomerByArea(Request $request)
    {
        $request->validate([
            'area' => 'required',
        ], [
            'area.required' => 'Vui lòng chọn khu vực.',
        ]);

        $ids = $request->input('choose_customers');
        $data = explode('_', $request->input('area'));
        try {
            Customer::whereIn('id', $ids)->update([ 'by_area' =>  $data[0] ]);


            Toastr::success("Đã thêm một số khách hàng vào khu vực ". $data[1]);
        } catch (\Exception $ex) {
            Toastr::error("Cấp quyền cho khu vực bị thất bại! ". $ex->getMessage());
        }
        return redirect()->back();
    }

    public function addAreaToUser(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'username', 'role', 'status', 'created_at')->user()->get();

        return view('area.add-area-to-user', [ 'areas' => $this->dataAreas, 'users' => $users ]);
    }

    public function postAddAreaToUser(Request $request)
    {
        $data = $request->get('user_area');

        \DB::beginTransaction();
        
        collect($data)->contains(function ($value, $key) {
            try {
                foreach($value as $item) {
                    $model = new AreaUser;
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

        return redirect()->route('customer_by_area');
    }
}
