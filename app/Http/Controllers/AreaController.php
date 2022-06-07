<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Brian2694\Toastr\Facades\Toastr;
class AreaController extends Controller
{
    public $_status = '';

    public function __construct()
    {
        $this->_status = Area::getStatus();
    }

    public function index(Request $request)
    {
        $areas = Area::all();

        return view('area.list', ['areas' =>  $areas, 'area_status' => $this->_status]);
    }

    public function create(Request $request)
    {
        $areas = Area::all();

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

        $model->save();
        
        Toastr::success("Cập nhật khu vực ". $model->name ." thành công!");

        return redirect()->route('index_area');
    }

    public function delete($id, Request $request)
    {
        try {
            $areas = Area::find($id);
            $areas->delete();
            Toastr::success("Xoá khu vực ". $areas->name ." thành công!");
        } catch (\Throwable $th) {
            Toastr::error("Xoá khu vực ". $areas->name ." thất bại!". $th->getMessage());
        }

        return redirect()->route('index_area');
    }
}
