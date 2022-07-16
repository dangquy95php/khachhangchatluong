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

    const CUSTOMER_ACTIVE = 1;
    const USER_ACTIVE = 1;
    const AREA_ACTIVE = 1;
    const HAVENT_CALLED_YET = null;

    public function __construct()
    {
        $this->dataAreas = Area::select('name', 'id', 'note', 'created_at')->opening()->get();
    }

    public function index(Request $request)
    {
        $areas = Area::withCount([
                    'areas_customers as havent_yet_call' => function($query) {
                        $query->whereNull('called');
                    },
                    'areas_customers as count_called' => function($query) {
                        $query->whereNotNull('called');
                    }
                ])->get();

        $areaAtatus = Area::getStatus();

        return view('area.list', compact('areas', 'areaAtatus'));
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
        $areaAtatus = Area::getStatus();

        return view('area.list', compact('area', 'areas', 'areaAtatus'));
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

    public function moveAreaBack(Request $request)
    {
        $area_id = $request->get('area_id');
        $user_id = $request->get('user_id');
        try {
            AreaCustomer::where([
                'user_id' => $user_id,
                'area_id' => $area_id,
                'called' => null,
            ])->update([
                'user_id' => null
            ]);
        } catch (\Exception $ex) {
            return \Response::json(['message' => $ex->getMessage()], 400);
        }
        return \Response::json(['message' => 'Cập nhật thành công!'], 200);
    }

    public function permissionArea(Request $request)
    {
        $area_id = $request->get('area_id');
        $user_id = $request->get('user_id');
        $user_id_old = $request->get('user_id_old');

        DB::beginTransaction();
        try {
            \Log::info(AreaCustomer::where('area_id', $area_id)->whereNull('user_id')->whereNull('called')->count());
            \Log::info($user_id);
            \Log::info($area_id);
            \Log::info($user_id_old);
            
            if (AreaCustomer::where('area_id', $area_id)->whereNull('user_id')->whereNull('called')->count() > 0) {
                AreaCustomer::where('area_id', $area_id)->whereNull('user_id')->whereNull('called')->update([ 'user_id' => $user_id ]);
            }
            if (!empty($user_id_old)) {
                AreaCustomer::where('area_id', $area_id)->where('user_id', $user_id_old)->whereNull('called')->update([ 'user_id' => $user_id ]);
            }
            
            \DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return \Response::json(['message' => $ex->getMessage()], 400);
        }
        return \Response::json(['message' => 'Cập nhật thành công!'], 200);
    }

    public function delete($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $area = Area::find($id);
            $area->area()->delete();
            $area->delete();
            Toastr::success("Xoá khu vực ". $area->name ." thành công!");
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            Toastr::error("Xoá khu vực ". $area->name ." thất bại!". $ex->getMessage());
        }

        return redirect()->route('index_area');
    }

    public function doleCustomersToArea()
    {
        $customers = Customer::leftJoin('areas_customers', function($join) {
            $join->on('customers.id', '=', 'areas_customers.customer_id');
        })->orderBy('areas_customers.created_at', "DESC")->whereNull('areas_customers.id')
        ->select([
            'customers.*',
        ])->get();
        
        $areas = Area::withCount('customers as count_customers_in_area')->where('status', self::AREA_ACTIVE)->orderBy('name', 'ASC')->get();

        return view('area.list-dole', compact('areas', 'customers'));
    }

    public function postDoleCustomersToArea(Request $request)
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
        $area = Area::findOrFail($request->input('area'));

        DB::beginTransaction();
        try {
            foreach($request->get('choose_customers') as $customer) {
                $model = new AreaCustomer();
                $model->area_id = $request->input('area');
                $model->customer_id = $customer;
                $model->save();
            }
            DB::commit();
            Toastr::success("Đã thêm ". count($request->get('choose_customers')) ." khách hàng vào khu vực ". $area->name);
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            DB::rollback();
            Toastr::error("Thêm dữ liệu cho khu vực bị thất bại! ". $ex->getMessage());
        }
        return redirect()->back();
    }

    public function indexAreaToUser(Request $request)
    {
        $areas = Area::withCount([
            'areas_havent_yet_assign as havent_yet_call' => function($query) {
                $query->whereNull('called');
            }
        ])->where('status', self::AREA_ACTIVE)->orderBy('name', 'ASC')->get();

        $areaUsers = User::with('areas_users')->where('status', self::USER_ACTIVE)->orderBy('name', 'ASC')->get();
        $areaAssignToUser = [];
        foreach($areaUsers as &$item) {
            if (count($item->areas_users) > 0) {
                $collection = $item->areas_users;
                $grouped = $collection->groupBy('area_id');
                $data = [];

                $dataAreas = $this->dataAreas;
                collect($grouped)->contains(function ($value, $key) use(&$data, $dataAreas, &$areaAssignToUser) {
                    foreach($dataAreas as $item) {
                        if($key == $item->id) {
                            array_push($data, (object)['area_id' => $key, 'count' => count($value), 'name' => $item->name ]);
                            array_push($areaAssignToUser, (object)['area_id' => $key, 'count' => count($value), 'name' => $item->name ]);
                        }
                    }
                });
                $item->areas = $data;
            }
        }
        
        return view('area.add-area-to-user', compact('areaUsers', 'areas', 'areaAssignToUser'));
    }
}
