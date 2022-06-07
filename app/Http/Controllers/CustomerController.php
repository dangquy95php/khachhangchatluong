<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Customer;

class CustomerController extends Controller
{
    public $dataCustomers = '';


    public function __construct()
    {
        $this->dataCustomers = Customer::select('id', 'id_contract', 'join_date', 'money', 'date_due', 'month_due', 'year_due', 'last_name', 'first_name', 'sex', 'date_birth', 'phone', 'home', 'ward', 'district', 'province')->get();

        return $this->dataCustomers;
    }

    public function index(Request $request)
    {
        return view('excel.list', ['customers' => $this->dataCustomers]);
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
}
