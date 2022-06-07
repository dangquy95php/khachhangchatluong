<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import()
    {
        $import = Excel::import(new CustomerImport, request()->file('file'));
        return redirect()->back()->with('success', 'Success!!!');
    }
}
