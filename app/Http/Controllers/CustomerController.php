<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Brian2694\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.list');
    }

    public function search(Request $request)
    {
        return view('customer.search');
    }

    public function export()
    {
        return Excel::download(new CustomerExport, 'customer.xlsx'); //download file export
        return Excel::store(new CustomerExport, 'customer.xlsx', 'disk-name'); //lưu file export trên ổ cứng
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ],[
            'file.required' => 'Vui lòng chọn file Excel để import dữ liệu.',
            'file.max' => 'Tập tin quá lớn.',
            'file.mimes' => 'Định dạng file không đúng. Chỉ cho phép import file Excel thôi.'
        ]);
        \DB::beginTransaction();

        try {

            Excel::import(new CustomerImport, request()->file('file'));
            Toastr::success('Import dữ liệu thành công!');
            \DB::commit();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errormessage = "";

            foreach ($failures as $failure) {
                $errormess = "";
                foreach($failure->errors() as $error) {
                    $errormess = $errormess.$error;
                }
                $errormessage = $errormessage."\n Dòng số ".$failure->row().", ".$errormess."<br>";
            }

            Toastr::error('Nhập dữ liệu bị lỗi! Vui lòng kiểm tra lại dữ liệu Excel.');
            return redirect()->back()->with('message', $errormessage);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062)
                \DB::rollback();
            return redirect()->back()->with('message', 'Dữ liệu thêm vào database đã có lỗi xảy ra.'. $e->getMessage());
        }

        return redirect()->back();
    }
}
