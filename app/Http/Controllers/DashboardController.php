<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
   const APPOINTMENT = 0;
   const CALLED = 1;

   public function dashboard(Request $request)
   {
      // Khách hàng hôm nay
      $dataToday['data'] = Customer::whereDate('updated_at', Carbon::today())->select('id', 'called', 'menh_gia', 'type_result', 'so_hop_dong', 'ten_kh', 'gioi_tinh', 'dia_chi_cu_the', 'tuoi')->get();

      $dataToday['called'] = collect($dataToday['data'])->where('called', self::CALLED)->count(function ($item) {
         return $item['called'];
      });

      $dataToday['scheduled'] = collect($dataToday['data'])->where('called', self::CALLED)->where('type_result', self::APPOINTMENT)->paginate(20);
      
      $dataToday['turnover'] = collect($dataToday['data'])->where('called', self::CALLED)->where('type_result', self::APPOINTMENT)->sum(function ($item) {
         $item['menh_gia'] = (int)(str_replace(',', '', $item['menh_gia']));
         return $item['menh_gia'];
      });

      $dataYesterday['data'] = Customer::whereDate('updated_at', Carbon::yesterday())->select('id', 'called', 'menh_gia', 'type_result')->get();
      $dataYesterday['called'] = collect($dataYesterday['data'])->where('called', self::CALLED)->count(function ($item) {
         return $item['called'];
      });

      $dataYesterday['turnover'] = collect($dataYesterday['data'])->where('called', self::CALLED)->where('type_result', self::APPOINTMENT)->sum(function ($item) {
         $item['menh_gia'] = (int)(str_replace(',', '', $item['menh_gia']));
         return $item['menh_gia'];
      });

      return view('dashboard', compact('dataYesterday', 'dataToday'));
   }
}