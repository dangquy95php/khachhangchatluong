<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Customer;
use Cache;

class CustomerController extends Controller
{
    public $dataCustomers = '';
    const CACHE_EXPIRED = 600;

    public function __construct()
    {
        $this->dataCustomers = Cache::remember('list_customer', self::CACHE_EXPIRED,function(){
            return Customer::all();
         });

        return $this->dataCustomers;
    }

    public function index(Request $request)
    {
        return view('customer.list', ['customers' => $this->dataCustomers]);
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

    public function delete(Request $request)
    {
        try {
            Customer::truncate();
            Toastr::success("Xoá dữ liệu thành công");
        } catch (\Exception $ex) {
            Toastr::error("Xoá dữ liệu thất bại". $ex->getMessage());
        }
        return redirect()->back();
    }
}
