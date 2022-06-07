<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
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
}
