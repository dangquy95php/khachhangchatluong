<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class ExcelController extends Controller
{
    public $dataCustomers = '';

    public function __construct()
    {
        $this->dataCustomers = Customer::select('id', 'id_contract', 'join_date', 'money', 'date_due', 'month_due', 'year_due', 'last_name', 'first_name', 'sex', 'date_birth', 'phone', 'home', 'ward', 'district', 'province')->get();
    }

    public function import(Request $request)
    {
        return view('excel.list', [ 'customers' => $this->dataCustomers ]);
    }

    public function history(Request $request)
    {
        return view('excel.history');
    }
}
