<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCalled extends Model
{
    use HasFactory;

    protected $table = 'history_called';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_customer_id',
        'so_thu_tu',
        'vpbank',
        'ngay_tham_gia',
        'msdl',
        'cv',
        'so_hop_dong',
        'menh_gia',
        'nam_dao_han',
        'ho',
        'ten',
        'ten_kh',
        'gioi_tinh',
        'ngay_sinh',
        'tuoi',
        'dien_thoai',
        'dia_chi_cu_the',
        'comment',
        'type_call',
        'cccd',
    ];
}