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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->where('id', 1);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class)->where('called', self::HAVENT_CALLED_YET);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class)->where('called', self::HAVENT_CALLED_YET);
    }
}
