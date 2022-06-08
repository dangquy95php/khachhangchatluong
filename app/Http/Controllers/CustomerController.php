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
}
