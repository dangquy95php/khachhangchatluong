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
use Cache;

class ExcelController extends Controller
{

    const EXCEL_TYPE_FILE = '.xlsx';

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
            Cache::forget('list_customer');

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
        try {
            $fileName = now()->format('Y-m-d-H-i-s');
            $customer = Excel::download(new CustomerExport, 'customer_'. $fileName .self::EXCEL_TYPE_FILE);
            Toastr::success('Export dữ liệu thành công!');
        } catch (\Exception $ex) {
            Toastr::success('Export dữ liệu thất bại'. $ex->getMessage());
        }

        return redirect()->back();
    }
}
