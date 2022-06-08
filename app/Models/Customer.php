<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    const BY_AREA_ACTIVE = 1; // đã update sau khi import. Tức là đã cho khách hàng vào khu vực

    const NEW_CUSTOMER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type_pay',
        'name_pay',
        'id_customer_pay', // mã người bán hàng
        'position', // chức vụ của văn phòng B
        'id_contract',
        'join_date',
        'note',
        'money',
        'date_due_full',
        'date_due',
        'month_due',
        'year_due',
        'last_name',
        'first_name',
        'sex',
        'date_birth',
        'age',
        'phone',
        'address_full',
        'home',
        'ward',
        'district',
        'province',
        'by_area'
    ];

    public function scopeByArea($query)
    {
        return $query->where('by_area', self::NEW_CUSTOMER);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
