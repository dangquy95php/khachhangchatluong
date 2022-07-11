<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Area extends Model
{

    const HAVENT_CALLED_YET = null;
    const CALLED = 1;
    const AREA_ACTIVE = 1;

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

    public function customer() {
        return $this->belongsToMany(Customer::class, 'areas_customers', 'area_id', 'customer_id')
                ->where('user_id', \Auth::id())
                ->where('areas_customers.called', self::HAVENT_CALLED_YET)
                ->withPivot('type_call', 'comment', 'updated_at', 'called', 'created_at', 'id');
    }
}
