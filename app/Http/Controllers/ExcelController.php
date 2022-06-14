<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Brian2694\Toastr\Facades\Toastr;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;

class ExcelController extends Controller
{
    public $dataCustomers = '';

    public function __construct()
    {
        $this->dataCustomers = Customer::all();
    }

    public function import(Request $request)
    {
        return view('excel.list', [ 'customers' => $this->dataCustomers ]);
    }

    public function history(Request $request)
    {
        return view('excel.history');
    }

    public function postImport(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ],[
            'file.required' => 'Vui lòng chọn file Excel để import dữ liệu.',
            'file.max' => 'Tập tin quá lớn.',
            'file.mimes' => 'File không được cài mật khẩu, định dạng file không đúng. Chỉ cho phép import file Excel(xlsx,xls) thôi.'
        ]);

        \DB::beginTransaction();

        try {

            Excel::queueImport(new CustomerImport, request()->file('file'));
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

            return redirect()->back()->with('message', $errormessage);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062)
                \DB::rollback();
            return redirect()->back()->with('message', 'Dữ liệu thêm vào database đã có lỗi xảy ra.'. $e->getMessage());
        }

        Toastr::success('Import dữ liệu thành công!');

        return redirect()->route('data_import');
    }

    public function export(Request $request)
    {
        return Excel::download(new CustomerExport, 'users.xlsx');
    }
}
