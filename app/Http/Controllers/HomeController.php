<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\AreaUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $_dataOrigin = '';

    public function __construct()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('account.login');
        // $this->_dataOrigin = User::find()->get();
    }

    public function index(Request $request)
    {
        // Lấy danh muc
        $areas = \DB::table('areas_users')->leftJoin('areas', 'areas_users.id_area', 'areas.id')->where('areas_users.id_user', Auth::user()->id) 
                ->join('customers', 'areas.id', 'customers.by_area')->where('customers.info_option', null)->get();

        $unique = collect($areas)->unique('id_area');
        $areas = $unique->values()->all();

        $customer = new Customer();

        if (count($areas) > 0) {
            $data_id = $areas[0]->id_area;

            $customer = Customer::where(['by_area' => $data_id, 'info_option' => null ])->select('*')->first();

            $re = '/([0-9]{4})([0-9]{2})([0-9]{2})/';

            preg_match_all($re, $customer->join_date, $matches, PREG_SET_ORDER, 0);
            preg_match_all($re, $customer->date_due_full, $matches1, PREG_SET_ORDER, 0);
    
            $customer->join_date = $matches;
            $customer->date_due_full = $matches1;
            if (count($matches) > 0) {
                $customer->join_date = $matches[0][1] .'-'. $matches[0][2] .'-'. $matches[0][3];
            }
            if (count($matches1) > 0) {
                $customer->date_due_full = $matches1[0][1] .'-'. $matches1[0][2] .'-'. $matches1[0][3];
            }
        }

        return view('index', ['areas' => $areas, 'customer' => $customer]);
    }

    public function detail(Request $request)
    {
        $id = $request->get('data_id');
\Log::info($id);
        $customer = Customer::where('by_area', $id)->join('areas', 'customers.by_area', '=', 'areas.id')
        ->select('customers.*', 'areas.name')->first();
        \Log::info($customer);
        $re = '/([0-9]{4})([0-9]{2})([0-9]{2})/';

        preg_match_all($re, $customer->join_date, $matches, PREG_SET_ORDER, 0);
        preg_match_all($re, $customer->date_due_full, $matches1, PREG_SET_ORDER, 0);

        $customer->join_date = $matches;
        $customer->date_due_full = $matches1;
        
        \Log::info($customer);
        // Print the entire match result
        // var_dump($matches);

        return response()->json($customer, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $request->validate([
            'info_option' => 'required',
        ], [
            'info_option.required' => 'Vui lòng chọn kết quả gọi' 
        ]);

        try {

            $customer = Customer::find($request->get('id'));
            $customer->info_option = $request->get('info_option');
            $customer->comment = $request->get('comment');

            if($customer->isDirty()) {
                Toastr::success('Thông tin khách hàng đã thay đổi thành công.');
            } else {
                Toastr::warning('Dữ liệu chưa được cập nhật');
            }

            $customer->save();
        } catch (\Exception $ex) {
            Toastr::error('Cập nhật khách hàng thất bại'. $ex->getMessage());
        }
        

        return redirect()->back();
    }
}
