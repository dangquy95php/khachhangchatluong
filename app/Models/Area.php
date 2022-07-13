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

    public function areas_customers()
    {
        return $this->hasMany(AreaCustomer::class, 'area_id', 'id');
    }
}
