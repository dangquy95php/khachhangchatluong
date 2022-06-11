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
        'by_area',
        'info_option',
        'comment'
    ];
        //     Đã hẹn
        //     Không nghe máy
        //     Khách hàng đang suy nghĩ, gọi lại sau.
        //     Khách hàng ít tiền
        // Đại lý vẫn chăm sóc

    const APPOINTMENT = 0;
    const NOTE_ANS_PHONE = 1;
    const CALL_BACK_LATER = 2;
    const LOWBUDGET_CUSTOMETRS = 3;
    const DEALES_TAKE_CARE = 4;

    const INFOR_OPTION = [
        self::APPOINTMENT => 'Đã hẹn',
        self::NOTE_ANS_PHONE => 'Không nghe máy',
        self::CALL_BACK_LATER => 'Khách hàng đang suy nghĩ, gọi lại sau.',
        self::LOWBUDGET_CUSTOMETRS => 'Khách hàng ít tiền',
        self::DEALES_TAKE_CARE => 'Đại lý vẫn chăm sóc',
    ];

    public static function getInforOption()
    {
        return self::INFOR_OPTION;
    }

    public function scopeByArea($query)
    {
        return $query->where('by_area', self::NEW_CUSTOMER);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'id' , 'by_area');
    }

    public function scopeNotNullOnly($query){

        return $query->where('info_option', '<>', '');
    }
}