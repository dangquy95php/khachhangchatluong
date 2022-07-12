<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;
class AreaCustomer extends Pivot
{
    use HasFactory;

    const AREA_ACTIVE = 1;
    const CALLED = 1;
    const HAVENT_CALLED_YET = null;

    protected $table = 'areas_customers';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_id',
        'user_id',
        'customer_id',
        'called'
    ];

    public function customer() {
        return $this->belongsTo(HistoryCalled::class, 'id', 'area_customer_id');
    }

    public function customer_have_called_yet() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function scopeUserId($query)
    {
        return $query->where('user_id', \Auth::id());
    }

    public function scopeCalled($query)
    {
        return $query->where('called', self::CALLED);
    }

    public function scopeToday($query)
    {
        return $query->where('areas_customers.updated_at', '>=' , Carbon::today());
    }

    public function scopeAreaId($query, $areaID)
    {
        return $query->where('areas_customers.area_id', $areaID);
    }

    public function scopeHaveCalledYet($query)
    {
        return $query->where('called', self::HAVENT_CALLED_YET);
    }
}