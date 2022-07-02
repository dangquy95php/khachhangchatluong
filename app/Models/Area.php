<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    const HAVENT_CALLED_YET = 0;

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
    // ko ro
    public function area()
    {
        return $this->hasMany(Customer::class, 'area_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'area_id', 'id')->whereNull('called');
    }
}
