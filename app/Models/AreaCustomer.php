<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AreaCustomer extends Pivot
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
        'user_id',
        'customer_id',
        'type_call',
        'called',
        'comment'
    ];

}