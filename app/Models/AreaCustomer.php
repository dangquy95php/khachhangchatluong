<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaCustomer extends Model
{
    use HasFactory;

    protected $table = 'areas_customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_id',
        'customer_id',
    ];

    public function customer()
    {
        return $this->hasMany('App\Models\Customer', 'id', 'customer_id');
    }

    public function scopeAreaID($query, $id){

        return $query->where('area_id', $id);
    }
}
