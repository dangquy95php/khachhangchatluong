<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Area extends Model
{

    const HAVENT_CALLED_YET = null;
    const CALLED = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'note',
        'user_id',
    ];

    const CLOSED = 0;
    const OPENING = 1;

    const STATUS = [
        self::CLOSED,
        self::OPENING
    ];
    
    public static function getStatus()
    {
        return self::STATUS;
    }

    public function scopeOpening($query)
    {
        return $query->where('status', self::OPENING);
    }

    public function customers_today() {
        return $this->belongsToMany(Customer::class, 'areas_customers', 'area_id', 'customer_id')
                    ->where('areas_customers.called', self::CALLED)
                    ->where('user_id', \Auth::user()->id)
                    ->where('areas_customers.updated_at', '>=' , Carbon::today())
                    ->orderBy('areas_customers.updated_at', 'desc')
                    ->withPivot('id', 'updated_at');
    }

    public function customers_history() {
        return $this->belongsToMany(Customer::class, 'areas_customers', 'area_id', 'customer_id')
                    ->where('areas_customers.called', self::CALLED)
                    ->where('user_id', \Auth::user()->id)
                    ->orderBy('areas_customers.updated_at', 'desc');
    }

    // public function customers1()
    // {
    //     return $this->belongsToMany(Area::class, 'areas_customers', 'area_id', 'customer_id');
    // }


    public function area_customer()
    {
        return $this->hasOne(AreaCustomer::class, 'area_id', 'id')
                    ->where('called', self::HAVENT_CALLED_YET)
                    ->where('user_id', \Auth::user()->id)
                    ->select(['customer_id', 'area_id', 'id']);
    }
}
