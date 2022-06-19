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
        // $this->dataCustomers = Customer::paginate(20);
    }

    public function import(Request $request)
    {
        $customers = \DB::table('areas_customers AS t1')
        ->select('t1.customer_id')
        ->rightJoin('customers AS t2', 't2.id','=', 't1.customer_id')
        ->whereNull('t1.id')->select('t2.*')->get();

        return view('excel.list', [ 'customers' => $customers ]);
    }

    public function deleteExcelCustomer($id, Request $request)
    {
        try {
            $customer = Customer::find($id);
            $customer->delete();
            Toastr::success("Xóa khách hàng ". $customer->ten ." thành công!");
        } catch (\Exception $ex) {
            Toastr::error("Xóa khách hàng ". $customer->ten ." thất bại!". $ex->getMessage());
        }

        return redirect()->route('data_import');
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
            $numberRows = Customer::count();

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
            
            return \Response::json(['message' => $errormessage], 400);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062)
                \DB::rollback();
            return \Response::json(['message' => 'Dữ liệu thêm vào database đã có lỗi xảy ra.'. $e->getMessage()], 500);
        }
        $numberRows1 = Customer::count();

        if ($numberRows == $numberRows1) {
            Toastr::warning('Vui lòng kiểm tra lại dữ liệu đã bị trùng lặp!');
        } else {
            Toastr::success('Import dữ liệu thành công!');
        }

        return \Response::json(['message' => 'Import dữ liệu thành công!'], 200);
    }

    public function export(Request $request)
    {
        try {
            $fileName = now()->format('Y-m-d-H-i-s');
            Toastr::success('Export dữ liệu thành công!');
            return Excel::download(new CustomerExport, 'customer_'. $fileName .self::EXCEL_TYPE_FILE);
        } catch (\Exception $ex) {
            Toastr::success('Export dữ liệu thất bại'. $ex->getMessage());
        }

        return redirect()->back();
    }
}
