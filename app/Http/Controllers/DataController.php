<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;
use App\Models\AreaCustomer;
use DB;

class DataController extends Controller
{
    // SELECT count(id) from customers =>12431
    // SELECT count(id) FROM `customers` WHERE called ='' => 5995
    // SELECT count(id) FROM `customers` WHERE type_result = 0 => 2384   => 2459
    // SELECT count(id) FROM customers WHERE type_result = '0' => 75
    // SELECT * FROM `customers` WHERE id = 583 , 388
    //4copy-data

    // SELECT count(id) FROM customers WHERE type_call = 0 => 75
    // SELECT count(id) FROM customers WHERE type_call = 1 =>  1628
    // SELECT count(id) FROM customers WHERE type_call = 2 => 217
    // SELECT count(id) FROM customers WHERE type_call = 3 => 293
    // SELECT count(id) FROM customers WHERE type_call = 4 => 2268
    // SELECT count(id) FROM customers WHERE type_call = 5 => 471
    // SELECT count(id) FROM customers WHERE type_call = 6 => 920
    // SELECT count(id) FROM customers WHERE type_call = 7 => 564


    public function index()
    {
        $dataOld = DB::connection('mysql2')->table('customers')->orderBy('updated_at')
        ->chunk(500, function($rows) {
            foreach($rows as $item) {
            
                $modelNew = new Customer();
                $modelNew->id = $item->id;

                if (empty($item->so_thu_tu)) {
                    $item->so_thu_tu = null;
                }
                $modelNew->so_thu_tu = $item->so_thu_tu;
                if (empty($item->vpbank)) {
                    $item->vpbank = null;
                }
                $modelNew->vpbank = $item->vpbank;
                if (empty($item->msdl)) {
                    $item->msdl = null;
                }
                $modelNew->msdl = $item->msdl;
                if (empty($item->cv)) {
                    $item->cv = null;
                }
                $modelNew->cv = $item->cv;
                if (empty($item->ngay_tham_gia)) {
                    $item->ngay_tham_gia = null;
                }
                $modelNew->ngay_tham_gia = $item->ngay_tham_gia;
                
                $modelNew->so_hop_dong = $item->so_hop_dong;
                if (empty($item->menh_gia)) {
                    $item->menh_gia = null;
                }
                $modelNew->menh_gia = $item->menh_gia;
                if (empty($item->nam_dao_han)) {
                    $item->nam_dao_han = null;
                }
                $modelNew->nam_dao_han = $item->nam_dao_han;
                if (empty($item->ten_kh)) {
                    $item->ten_kh = null;
                }
                $modelNew->ten_kh = $item->ten_kh;
                if (empty($item->gioi_tinh)) {
                    $item->gioi_tinh = null;
                }
                $modelNew->gioi_tinh = $item->gioi_tinh;
                if (empty($item->ngay_sinh)) {
                    $item->ngay_sinh = null;
                }
                $modelNew->ngay_sinh = $item->ngay_sinh;
                if (empty($item->tuoi)) {
                    $item->tuoi = null;
                }
                $modelNew->tuoi = $item->tuoi;
                if (empty($item->dien_thoai)) {
                    $item->dien_thoai = null;
                }
                $modelNew->dien_thoai = $item->dien_thoai;
                if (empty($item->dia_chi_cu_the)) {
                    $item->dia_chi_cu_the = null;
                }
                $modelNew->dia_chi_cu_the = $item->dia_chi_cu_the;
                if (empty($item->comment)) {
                    $item->comment = null;
                }
                $modelNew->comment = $item->comment;
                
                if ($item->type_result===0 || $item->type_result ==='0')
                    $item->type_result = intval($item->type_result);
                if (intval($item->type_result==='')) {
                    $item->type_result = null;
                }
                $modelNew->type_call = $item->type_result;

                if (empty($item->created_at)) {
                    $item->created_at = null;
                }
                $modelNew->created_at = $item->created_at;
                if (empty($item->updated_at)) {
                    $item->updated_at = null;
                }
                $modelNew->updated_at = $item->updated_at;
                if (empty($item->called)) {
                    $item->called = null;
                }
                $modelNew->called = $item->called;
                if (empty($item->ho)) {
                    $item->ho = null;
                }
                $modelNew->ho = $item->ho;
                if (empty($item->ten)) {
                    $item->ten = null;
                }
                $modelNew->ten = $item->ten;
    
                $modelNew->save();
            }
        });
    }
    //22
    public function addArea()
    {
        $dataOld = DB::connection('mysql2')->table('areas')->orderBy('updated_at')
        ->chunk(500, function($rows) {
            foreach($rows as $item) {
                $modelNew = new Area();
                $modelNew->id = $item->id;
                if (empty($item->name)) {
                    $item->name = null;
                }
                $modelNew->name = $item->name;
                if (empty($item->status)) {
                    $item->status = null;
                }
                $modelNew->status = $item->status;

                if (empty($item->note)) {
                    $item->note = null;
                }
                $modelNew->note = $item->note;
                if (empty($item->role)) {
                    $item->user_id = null;
                }
                $modelNew->user_id = $item->user_id;
                if (empty($item->created_at)) {
                    $item->created_at = null;
                }
                $modelNew->created_at = $item->created_at;
                if (empty($item->updated_at)) {
                    $item->updated_at = null;
                }
                $modelNew->updated_at = $item->updated_at;

                $modelNew->save();
            }
        });
    }
    //5
    public function updateArea()
    {
        $dataOld = DB::connection('mysql2')->table('areas_customers')->orderBy('updated_at')
        ->chunk(500, function($rows) {
            foreach($rows as $item) {
                // $customer = Customer::where('id', $item->customer_id)->first();
                try {
                    $customer =  DB::connection('mysql2')->table('customers')->find($item->customer_id);
                    if (empty($customer)) {
                        \Log::info(print_r($item, true));
                    } else {
                        Customer::where('id', $item->customer_id)->update([
                            'area_id' => $item->area_id,
                            'created_at' => $customer->created_at,
                            'updated_at' => $customer->updated_at,
                        ]);
                    }
                } catch (\Exception $th) {
                    dd($th);
                    \Log::info($th->getMessage());
                }
            }
        });
    }
    //33 update-user
    public function updateUser()
    {
        $dataOld = DB::connection('mysql2')->table('areas_users')->orderBy('updated_at')
        ->chunk(500, function($rows) {
            foreach($rows as $item) {
                Area::where('id', $item->id_area)->update([
                    'user_id' => $item->id_user,
                    'updated_at' => $item->updated_at
                ]);
            }
        });
    }
    //11 add-user
    public function addUser()
    {
        $dataOld = DB::connection('mysql2')->table('users')->orderBy('created_at')
        ->chunk(500, function($rows) {
            foreach($rows as $item) {
                $modelNew = new User();
                $modelNew->id = $item->id;
                if (empty($item->name)) {
                    $item->name = null;
                }
                $modelNew->name = $item->name;
                if (empty($item->email)) {
                    $item->email = null;
                }
                $modelNew->email = $item->email;

                if (empty($item->username)) {
                    $item->username = null;
                }
                $modelNew->username = $item->username;
                if (empty($item->role)) {
                    $item->role = null;
                }
                $modelNew->role = $item->role;
                
                if (empty($item->status)) {
                    $item->status = null;
                }
                $modelNew->status = $item->status;

                if (empty($item->email_verified_at)) {
                    $item->email_verified_at = null;
                }
                $modelNew->email_verified_at = $item->email_verified_at;

                if (empty($item->password)) {
                    $item->password = null;
                }
                $modelNew->password = $item->password;

                if (empty($item->remember_token)) {
                    $item->remember_token = null;
                }
                $modelNew->remember_token = null;

                if (empty($item->created_at)) {
                    $item->created_at = null;
                }
                $modelNew->created_at = $item->created_at;

                if (empty($item->updated_at)) {
                    $item->updated_at = null;
                }
                \Log::info($item->updated_at);
                $modelNew->updated_at = $item->updated_at;

                $modelNew->save();
            }
        });

        $this->addArea();
        $this->updateUser();
    }
}
