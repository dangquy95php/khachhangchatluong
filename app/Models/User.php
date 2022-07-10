<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableModel;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Sanctum\HasApiTokens;
use Stephenjude\DefaultModelSorting\Traits\DefaultOrderBy;
use Hash;
use Carbon\Carbon;

class User extends AuthenticatableModel implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, HasFactory, Notifiable, DefaultOrderBy;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected static $orderByColumn = 'updated_at';

    protected static $orderByColumnDirection = 'desc';

    const HAVENT_CALLED_YET = 0;
    const CALLED = 1;
    const AREA_HAVENT_CALLED_YET = null;
    const APPOINTMENT = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'username',
        'role',
        'password',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'id', 'role', 'status', 'name', 'id_user'
    ];

    public function username()
    {
        return 'username';
    }

    const AREA_ACTIVE = 1;

    const NOT_APPROVED_YET = 0;
    const ACTIVE = 1;
    const INACTIVE = 2;

    const STATUS = [
        self::NOT_APPROVED_YET,
        self::ACTIVE,
        self::INACTIVE
    ];

    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    const ROLES_ALL = [
        self::USER_ROLE,
        self::ADMIN_ROLE
    ];

    public static function getStatus()
    {
        return self::STATUS;
    }

    public static function getRole()
    {
        return self::ROLES_ALL;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function scopeUser($query)
    {
        return $query->where('role', self::USER_ROLE);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'areas_customers', 'user_id', 'area_id', 'id')
                    ->where('status', self::AREA_ACTIVE)
                    ->groupBy('pivot_area_id');
    }

    public function areas_customers()
    {
        return $this->belongsToMany(Customer::class, 'areas_customers', 'area_id', 'customer_id', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    // public function area()
    // {
    //     return $this->belongsToMany('App\Models\Area', 'areas_users', 'id_user', 'id_area');
    // }
    //---------------------
    // public function areas_users()
    // {
    //     return $this->hasManyThrough(AreaCustomer::class, AreaUser::class, 'user_id', 'area_id', 'id', 'id')
    //                 // ->where('areas.status', self::ACTIVE)
    //                 ->orderBy('areas_users.user_id', 'DESC')
    //                 // ->where('area_user.area_called', self::AREA_HAVENT_CALLED_YET)
    //                 ->select('*');
    // }


    // public function customers1()
    // {
    //     return $this->belongsToMany(Area::class, 'areas_customers', 'area_id', 'customer_id');
    // }

    // public function area()
    // {
    //     return $this->hasOne(Area::class)->where('status', self::AREA_ACTIVE);
    // }

    // public function customer()
    // {
    //     return $this->hasOneThrough(Customer::class, Area::class, 'user_id', 'area_id', 'id', 'id' )
    //                 ->whereNull('customers.called')
    //                 ->where('areas.status', self::AREA_ACTIVE)
    //                 ->orderBy('customers.updated_at', 'DESC')
    //                 ->select('customers.*', 'areas.name');
    // }

    // public function customers()
    // {
    //     return $this->hasManyThrough(Customer::class, Area::class, 'user_id', 'area_id', 'id', 'id')
    //             ->where('customers.called', self::CALLED)
    //             ->where('areas.status', self::ACTIVE)
    //             ->orderBy('customers.updated_at', 'DESC')
    //             ->select('customers.*', 'areas.name');
    // }

    // public function get_data_today()
    // {
    //     return $this->hasManyThrough(Customer::class, Area::class, 'user_id', 'area_id', 'id', 'id')
    //             ->where('customers.updated_at', '>=', \Carbon\Carbon::today())
    //             ->where('customers.called', self::CALLED)
    //             ->where('customers.type_call', self::APPOINTMENT)
    //             ->orderBy('customers.updated_at', 'DESC')
    //             ->select('customers.*', 'areas.name');
    // }

    // public function customers_area_has_users()
    // {
    //     return $this->hasMany(Area::class)->whereNotNull('user_id')->where('status', self::AREA_ACTIVE);
    // }
}