<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
   const APPOINTMENT = 0;
   const CALLED = 1;
   const DATE_MAX_TOTAL_CALLED = 1;

   public function dashboard(Request $request)
   {
      $todayData = User::with('get_data_today')->get();
      $totalCallCurrent = 0;
      $today = new \Illuminate\Database\Eloquent\Collection;

      foreach($todayData as $user) {
         $totalCallCurrent += count($user->get_data_today->toArray());
         foreach($user->get_data_today as &$item) {
            $item->username = $user->username;
         }
         $today = $today->merge(collect($user->get_data_today));
      }

      // Get max date
      $findDate = Customer::where('date_max', self::DATE_MAX_TOTAL_CALLED)->select('updated_at')->first();
      if (empty($findDate)) {
         $time = Carbon::today();
      } else {
         $time = $findDate->updated_at->toDateString('Y-m-d');
      }
      $totalCalledBefore = Customer::whereDate('updated_at', $time)->where('called', self::CALLED)->count();
      
      if ($totalCallCurrent > $totalCalledBefore) {
         Customer::whereDate('updated_at', $time)
            ->where('called', self::CALLED)
            ->orderBy('updated_at', 'DESC')
            ->first()
            ->update(['date_max' => self::DATE_MAX_TOTAL_CALLED]);
      }

      return view('dashboard', compact('today', 'totalCallCurrent', 'totalCalledBefore'));
   }
}